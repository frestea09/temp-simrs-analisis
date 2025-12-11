<?php

namespace App\Http\Controllers;

use Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Registrasi;
use App\KondisiAkhirPasien;
use App\Http\Controllers\SatuSehatController;
use App\Posisiberkas;
use App\masterCaraMinum;
use App\HistorikunjunganIRJ;
use App\EmrInapPerencanaan;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use PDF;
use Modules\Registrasi\Entities\Carabayar;
use App\MasterEtiket;
use App\TakaranobatEtiket;
use App\Aturanetiket;
use App\LicaResult;
use App\Masterobat;
use App\Emr;
use App\PotensiPRB;
use App\IntervensiKeperawatan;
use App\ImplementasiKeperawatan;
use App\EmrGizi;
use App\EmrFarmasi;
use App\EmrRiwayat;
use App\EmrInapKondisiKhusus;
use App\EmrInapMedicalRecord;
use App\EmrRiwayatKesehatan;
use App\Hasillab;
use App\MasterRiwayatKesehatan;
use App\DiagnosaKeperawatan;
use App\Edukasi;
use App\RencanaKontrol;
use Modules\Registrasi\Entities\Folio;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Tarif\Entities\Tarif;
use Modules\Poli\Entities\Poli;
use Excel;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Kategoritarif\Entities\Kategoritarif;
use App\Orderlab;
use App\Orderradiologi;
use App\PacsExpertise;
use App\Rawatinap;
use App\EmrEws;
use App\ResepNote;
use App\ResepNoteDetail;
use App\ResepNoteDuplicate;
use Illuminate\Support\Facades\Cache;
use App\FolioMulti;
use App\OrderOdontogram;
use Auth;
use DB;
use App\MasterDiet;
use App\EdukasiDiet;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\Kelompokkelas;
use App\Labsection;
use App\LisResult;
use App\MasterLicas;
use App\MasterLicasPaket;
use App\Penjualan;
use App\Prognosis;
use App\Satusehat;
use App\AntrianRadiologi;
use App\AntrianLaboratorium;
use App\SuratInap;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\EsignLog;
use App\Http\Controllers\LogUserController;
use Carbon\Carbon;
use App\HasilPemeriksaan;
use App\ServiceNotif;
use App\inhealthSjp;
use Modules\Kamar\Entities\Kamar;
use App\PaguPerawatan;
use App\Inacbgs_sementara;
use Modules\Kelas\Entities\Kelas;
use App\FaskesRujukanRs;
use App\HistoriRawatInap;
use Illuminate\Support\Collection;

class EmrController extends Controller
{
	public function index($unit)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');

		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$poli_id = Auth::user()->poli_id;
		$data['unit'] 	= $unit;
		$data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
		$data['list_kelas'] = Kelompokkelas::select('general_code', \DB::raw("MIN(kelompok) as nama"))
			->groupBy('general_code')
			->get()
			->map(function ($item) {
				$item->label = strtok($item->nama, ' ');
				return $item;
			});
		$data['filter_kelas'] = '';
		$data['polis'] = Poli::where('politype', 'J')->get();
		if ($unit == 'jalan') {
			$data['registrasi'] = HistorikunjunganIRJ::query()
				->leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
				->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
				->whereNull('registrasis.deleted_at')
				->whereBetween('histori_kunjungan_irj.created_at', [
					Carbon::today()->startOfDay(),
					Carbon::today()->endOfDay()
				])
				->when(request('poli_id'), function ($q) {
					$q->where('registrasis.poli_id', request('poli_id'));
				})
				->when(!empty($poli_id), function ($q) use ($poli_id) {
					$ids = explode(",", $poli_id);
					$q->whereIn('histori_kunjungan_irj.poli_id', $ids);
				})
				->select([
					'histori_kunjungan_irj.id as id_kunjungan',
					'registrasis.antrian_poli_id',
					'histori_kunjungan_irj.pasien_id',
					'histori_kunjungan_irj.dokter_id',
					'histori_kunjungan_irj.poli_id',
					'histori_kunjungan_irj.created_at as tgl_reg',
					'registrasis.bayar',
					'registrasis.id',
					'registrasis.status_reg',
					'registrasis.nomorantrian',
					'registrasis.input_from',
					'registrasis.status as keteranganStatus',
					'pasiens.nama',
					'pasiens.no_jkn',
					'pasiens.no_rm',
					'pasiens.tgllahir',
					'pegawais.nama as dokter_dpjp',
					'carabayars.carabayar',
					'polis.nama as nama_poli',
					'registrasis.id_encounter_ss',
					'registrasis.dokter_id as dpjp',
					'pegawais.user_id as userDokter',
					'registrasis.tte_resume_pasien_status',
					\DB::raw("
						CASE 
							WHEN registrasis.input_from IN ('KIOSK Reservasi Lama','KIOSK Reservasi Baru') THEN 'Registrasi Online'
							WHEN registrasis.input_from = 'registrasi-ranap-langsung' THEN 'Registrasi Ranap Langsung'
							WHEN registrasis.input_from IN ('regperjanjian','regperjanjian_lama','regperjanjian_baru','regperjanjian_online') THEN 'Registrasi Perjanjian'
							WHEN registrasis.input_from IN ('registrasi-1','registrasi-2','registrasi-3','registrasi-4') THEN 'Registrasi Onsite'
							ELSE 'Registrasi'
						END as cara_registrasi
					")
				])
				->orderBy('histori_kunjungan_irj.created_at', 'ASC')
				->get();

			// Sorting tambahan untuk kelompok_ dan urutan_
			foreach ($data['registrasi'] as $d) {
				if (!baca_nomorantrian_bpjs($d->nomorantrian)) {
					$d->kelompok_   = $d->kelompok_antrian;
					$d->urutan_     = intval($d->nomor_antrian);
				} else {
					$split = split_nomorantrian_online(baca_nomorantrian_bpjs($d->nomorantrian));
					$d->kelompok_   = isset($split[1]) ? $split[1] : '';
					$d->urutan_     = isset($split[2]) ? intval($split[2]) : 0;
				}
			}

			$data['registrasi'] = $data['registrasi']->sortBy(function ($reg) {
				return [$reg->kelompok_, $reg->urutan_];
			});

			$regIds = $data['registrasi']->pluck('id')->toArray();
		} elseif ($unit == 'igd') {
			$data['registrasi'] = Registrasi::leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
				->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
				->leftJoin('emr_resume', function($join) {
					$join->on('emr_resume.registrasi_id', '=', 'registrasis.id')
						->where('emr_resume.type', '=', 'resume-igd');
				})
				->whereIn('status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
				->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%');

			if ($poli_id != '') {
				$pol = explode(",", $poli_id);
				$data['registrasi']->whereIn('registrasis.poli_id', $pol);
			}
			$data['registrasi'] = $data['registrasi']
				->select('registrasis.antrian_poli_id', 'registrasis.nomorantrian', 'registrasis.pasien_id', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.id', 'registrasis.input_from', 'registrasis.status_reg', 'registrasis.tgl_pulang', 'registrasis.no_sep', 'pasiens.no_rm', 'pasiens.nama', 'polis.nama as nama_poli', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'registrasis.id_encounter_ss', 'registrasis.status as keteranganStatus', 'registrasis.dokter_id as dpjp', 'pegawais.user_id as userDokter', 'registrasis.tte_resume_pasien_status', 'emr_resume.id as resume_igd')
				->get();

			$regIds = $data['registrasi']->pluck('id')->toArray();
			$data['cppts'] = Emr::whereIn('registrasi_id', $regIds)->get();
			$data['asesments'] = EmrInapPemeriksaan::whereIn('registrasi_id', $regIds)->get();
		} else {
			// Query Untuk INAP
			// $keyCache = 'emr_inap';
			// $data['registrasi'] = Cache::get($keyCache);
			// if(!$data['registrasi']){
			$today = now()->format('Y-m-d');
			$start = $today.' 00:00:00';
			$end   = $today.' 23:59:59';
			
				$data['registrasi'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
				->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
				// ->where('registrasis.status_reg', 'I2')
				->whereNull('registrasis.deleted_at')
				->where(function($q) use ($start, $end) {
					$q->where('registrasis.status_reg', 'I2')
					->orWhere(function($q2) use ($start, $end) {
						$q2->where('registrasis.status_reg', 'I3')
							->whereBetween('rawatinaps.tgl_keluar', [$start, $end]);
					});
				});
			// if ($poli_id != '') {
			// 	$pol = explode(",", $poli_id);
			// 	$data['registrasi']->where('registrasis.poli_id', $pol);
			// }
	
			$kelompokKelas = Auth::user()->coder_nik;
			if ($kelompokKelas != '' || $kelompokKelas != NULL) {
				$kelompokKelas = explode(",", $kelompokKelas);
				$data['registrasi']->whereIn('rawatinaps.kelompokkelas_id', $kelompokKelas);
			}
			$data['registrasi'] = $data['registrasi']
				// ->select('registrasis.antrian_poli_id','registrasis.nomorantrian', 'registrasis.pasien_id', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar','registrasis.id', 'registrasis.input_from', 'pasiens.no_rm', 'pasiens.nama', 'polis.nama as nama_poli', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'registrasis.id_encounter_ss', 'registrasis.status as keteranganStatus', 'registrasis.dokter_id as dpjp', 'pegawais.user_id as userDokter')
				->select(
					'registrasis.*',
					'rawatinaps.dokter_id as dokterInap',
					'rawatinaps.kamar_id',
					'rawatinaps.bed_id',
					'rawatinaps.tgl_masuk',
					'rawatinaps.tgl_keluar',
				)
				->orderBy('rawatinaps.tgl_masuk', 'DESC')
				->get();
			// 	Cache::put($keyCache,$data['registrasi'],120); //BUAT CACHE 2 menit
			// }

			
			
					
		}
		return view('emr.index', $data)->with('no', 1);
	}

	public function uploadHasilLain(Request $request,$unit, $registrasi_id)
	{
		$data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'LAINNYA')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::pluck('nama', 'id');
		$data['unit'] = $unit;
		$data['registrasi_id']  = $registrasi_id;

		if ($request->method() == 'POST') {
			$request->validate(['file' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048']);
			if(!empty($request->file('file'))){
				$filename = time().$request->file('file')->getClientOriginalName();
				$request->file('file')->move('hasil-pemeriksaan/', $filename);
			}else{
				$filename = null;
			}

			try{
				$hasillab = new HasilPemeriksaan();
				$hasillab->no_hasil_pemeriksaan = $request->no_hasil;
				$hasillab->registrasi_id = $request->registrasi_id;
				$hasillab->pasien_id = $request->pasien_id;
				$hasillab->dokter_id = $request->dokter_id;
				$hasillab->penanggungjawab = $request->penanggungjawab;
				$hasillab->tgl_pemeriksaan = $request->tgl_pemeriksaan;
				$hasillab->tgl_hasilselesai = $request->tgl_hasilselesai;
				$hasillab->keterangan = $request->keterangan;
				$hasillab->filename = $filename;
				$hasillab->user_id = Auth::user()->id;
				$hasillab->type = "LAINNYA";
				$hasillab->save();
				Flashy::success('Berhasil upload hasil pemeriksaan!');
			}catch(Exception $e){
				Flashy::error('Gagal mengupload hasil pemeriksaan!');
			}
			return redirect()->back();
		}

		return view('emr.modules.pemeriksaan.hasil_pemeriksaan_lain', $data);
	}

	public function index_byTanggal(Request $request)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		
		$poli_id            = Auth::user()->poli_id;
		// $data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		// $data['tiket'] 		= MasterEtiket::all('nama', 'id');
		// $data['cara_minum'] = Aturanetiket::all('aturan', 'id');
		// $data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		$data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
		$data['list_kelas'] = Kelompokkelas::select('general_code', \DB::raw("MIN(kelompok) as nama"))
			->groupBy('general_code')
			->get()
			->map(function ($item) {
				$item->label = strtok($item->nama, ' ');
				return $item;
			});
		$data['polis'] = Poli::where('politype', 'J')->get();
		$unit 				= $request['unit'];
		$data['unit'] 	    = $unit;
		$data['kondisi'] = $request['kondisi'];
		$data['status'] = $request['status'];
		$data['filter_kamar'] = $request['filter_kamar'];
		$tga                = $request['tga'] ? $request['tga'] : now()->format('d-m-Y');
		$tgb                = $request['tgb'] ? $request['tgb'] : now()->format('d-m-Y');
		$data['dokter_filter'] = $request->dokter_id;
		// request()->validate(['tga' => 'required', 'tgb' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);

		if ($unit == 'jalan') {
			$data['registrasi']	= HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
				->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
				->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
				->whereNull('registrasis.deleted_at')
				->whereBetween('histori_kunjungan_irj.created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
				->orderBy('histori_kunjungan_irj.created_at', 'ASC');

			if ($request->dokter_id != null) {
				// Tanpa Filter poli jika filter dokter hidup
				$data['registrasi']->where('registrasis.dokter_id', $request->dokter_id);
			} else {
				if ($poli_id != '') {
					$poli_id = explode(",", $poli_id);
					$data['registrasi']->whereIn('histori_kunjungan_irj.poli_id', $poli_id);
				}
			}

			if ($request->kondisi == 'belum') {
				$data['registrasi'] = $data['registrasi']->where(function ($query) {
					$query->doesntHave('emrPemeriksaan')->doesntHave('cppt');
				});
			} elseif ($request->kondisi == 'sudah') {
				$data['registrasi'] = $data['registrasi']->where(function ($query) {
					$query->whereHas('emrPemeriksaan')->orWhereHas('cppt');
				});
			}

			if (request('poli_id')) {
				$data['registrasi']->where('registrasis.poli_id', request('poli_id'));
			}
			
			// dd($data['registrasi']);
			$data['registrasi'] = $data['registrasi']
				->select('histori_kunjungan_irj.id as id_kunjungan', 'antrian_poli.status', 'antrian_poli.nomor as nomor_antrian', 'antrian_poli.kelompok as kelompok_antrian', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.input_from', 'registrasis.status as keteranganStatus', 'pasiens.nama', 'pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.tgllahir',  'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'polis.nama as nama_poli', 'registrasis.id_encounter_ss', 'registrasis.status as keteranganStatus', 'registrasis.dokter_id as dpjp', 'pegawais.user_id as userDokter', 'registrasis.tte_resume_pasien_status')
				->get();
			// Ordering
			foreach ($data['registrasi'] as $key => $d) {
				if ($d->input_from == 'KIOSK Reservasi Lama' || $d->input_from == 'KIOSK Reservasi Baru') {
					$d->cara_registrasi = 'Registrasi Online';
				} elseif ($d->input_from == 'registrasi-ranap-langsung') {
					$d->cara_registrasi = 'Registrasi Ranap Langsung';
				} elseif ($d->input_from == 'regperjanjian' || $d->input_from == 'regperjanjian_lama' || $d->input_from == 'regperjanjian_baru' || $d->input_from == 'regperjanjian_online') {
					$d->cara_registrasi = 'Registrasi Perjanjian';
				} elseif ($d->input_from == 'registrasi-1' || $d->input_from == 'registrasi-2' || $d->input_from == 'registrasi-3' || $d->input_from == 'registrasi-4') {
					$d->cara_registrasi = 'Registrasi Onsite';
				} else {
					$d->cara_registrasi = 'Registrasi';
				}

				if (!baca_nomorantrian_bpjs(@$d->nomorantrian)) {
					// Bukan Online / JKN
					$d->kelompok_   = $d->kelompok_antrian;
					$d->urutan_     = intval($d->nomor_antrian);
				} else {
					// Online JKN
					$d->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$d->nomorantrian))[1];
					$d->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$d->nomorantrian))[2]);
				}
			}
			$data['registrasi'] = $data['registrasi']->sortBy(function ($reg) {
				return [$reg['kelompok_'], $reg['urutan_']];
			});
			$regIds = $data['registrasi']->pluck('id')->toArray();
			// $data['cppts'] = Emr::whereIn('registrasi_id', $regIds)->get();
			// $data['asesments'] = EmrInapPemeriksaan::whereIn('registrasi_id', $regIds)->get();
		} elseif ($unit == 'igd') {
			$data['registrasi'] = Registrasi::leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
				->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
				->leftJoin('emr_resume', function($join) {
					$join->on('emr_resume.registrasi_id', '=', 'registrasis.id')
						->where('emr_resume.type', '=', 'resume-igd');
				})
				->whereIn('status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
				->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);

			// if ($poli_id != '') {
			//     $pol = explode(",",$poli_id);
			// 	$data['registrasi']->whereIn('registrasis.poli_id', $pol);
			// } 

			if ($request->dokter_id != null) {
				// Tanpa Filter poli jika filter dokter hidup
				$data['registrasi']->where('registrasis.dokter_id', $request->dokter_id);
			} else {
				if ($poli_id != '') {
					$pol = explode(",", $poli_id);
					$data['registrasi']->whereIn('registrasis.poli_id', $pol);
				}
			}
			$data['registrasi'] = $data['registrasi']
				->select('registrasis.antrian_poli_id', 'registrasis.nomorantrian', 'registrasis.pasien_id', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.id', 'registrasis.input_from', 'registrasis.status_reg', 'registrasis.tgl_pulang', 'registrasis.no_sep', 'pasiens.no_rm', 'pasiens.nama', 'polis.nama as nama_poli', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'registrasis.id_encounter_ss', 'registrasis.status as keteranganStatus', 'registrasis.dokter_id as dpjp', 'pegawais.user_id as userDokter', 'registrasis.tte_resume_pasien_status', 'emr_resume.id as resume_igd')
				->get();

			$regIds = $data['registrasi']->pluck('id')->toArray();
			$data['cppts'] = Emr::whereIn('registrasi_id', $regIds)->get();
			$data['asesments'] = EmrInapPemeriksaan::whereIn('registrasi_id', $regIds)->get();
		} else {
			// Query Untuk INAP
			$today = now()->format('Y-m-d');
			$start = $today.' 00:00:00';
			$end   = $today.' 23:59:59';
			
			$data['registrasi'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
				->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
				->leftJoin('kelompok_kelas', 'rawatinaps.kelompokkelas_id', '=', 'kelompok_kelas.id')
				->whereNull('registrasis.deleted_at');
				// ->whereBetween('rawatinaps.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);
			// if ($poli_id != '') {
			// 	$pol = explode(",", $poli_id);
			// 	$data['registrasi']->where('registrasis.poli_id', $pol);
			// }
			if ($request->tga && $request->tgb !== null){
				if ($request->status == 'inap') {
					// $data['registrasi']->where('registrasis.status_reg', 'I2');
					$data['registrasi']->whereBetween('rawatinaps.tgl_masuk', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);
				}else if ($request->status == 'pulang') {
					// $data['registrasi']->where('registrasis.status_reg', 'I3');
					$data['registrasi']->whereBetween('rawatinaps.tgl_keluar', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);
				}else{
					$start = valid_date($request['tga']).' 00:00:00';
					$end   = valid_date($request['tgb']).' 23:59:59';

					$data['registrasi']->where(function ($q) use ($start, $end) {
						// $q->where(function ($a) use ($start, $end) {
						// 	$a->where('registrasis.status_reg', 'I2');
						// 	// ->whereBetween('rawatinaps.created_at', [$start, $end]);
						// })->orWhere(function ($b) use ($start, $end) {
						// 	$b->where('registrasis.status_reg', 'I3')
						// 	->whereBetween('rawatinaps.tgl_keluar', [$start, $end]);
						// });
						$q->whereBetween('rawatinaps.created_at', [$start, $end])
     					 ->orWhereBetween('rawatinaps.tgl_keluar', [$start, $end]);
					});
				}
			}else{
				$today = now()->format('Y-m-d');
				if ($request->status == 'inap') {
					$data['registrasi']->where('registrasis.status_reg', 'I2');
				}else if ($request->status == 'pulang') {
					$data['registrasi']->where('registrasis.status_reg', 'I3');
					$data['registrasi']->whereBetween('rawatinaps.tgl_keluar', [
						$today . ' 00:00:00', 
						$today . ' 23:59:59'
					]);
				}else{
					$start = $today.' 00:00:00';
					$end   = $today.' 23:59:59';

					$data['registrasi']->where(function ($q) use ($start, $end) {
						$q->where(function ($a) use ($start, $end) {
							$a->where('registrasis.status_reg', 'I2');
							// ->whereBetween('rawatinaps.created_at', [$start, $end]);
						})->orWhere(function ($b) use ($start, $end) {
							$b->where('registrasis.status_reg', 'I3')
							->whereBetween('rawatinaps.tgl_keluar', [$start, $end]);
						});
					});

				}
			}
			if ($request->dokter_id) {
				$data['registrasi']->where('rawatinaps.dokter_id', $request->dokter_id);
			}
			
			// if ($request->status == 'pulang') {
			// 	$data['registrasi']->where('registrasis.status_reg', 'I3');
			// }else{
			// 	$data['registrasi']->where('registrasis.status_reg', 'I2');
			// }

			if ($request->filter_kamar) {
				$data['registrasi']->where('kelompok_kelas.general_code', $request->filter_kamar);
			}
			$data['registrasi'] = $data['registrasi']
				// ->select('registrasis.antrian_poli_id','registrasis.nomorantrian', 'registrasis.pasien_id', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar','registrasis.id', 'registrasis.input_from', 'pasiens.no_rm', 'pasiens.nama', 'polis.nama as nama_poli', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'registrasis.id_encounter_ss', 'registrasis.status as keteranganStatus', 'registrasis.dokter_id as dpjp', 'pegawais.user_id as userDokter')
				->select(
					'registrasis.*',
					'rawatinaps.dokter_id as dokterInap',
					'rawatinaps.kamar_id',
					'rawatinaps.bed_id',
					'rawatinaps.tgl_masuk',
					'rawatinaps.tgl_keluar'
				)
				->orderBy('rawatinaps.tgl_masuk', 'DESC')
				->get();
		}

		return view('emr.index', $data)->with('no', 1);
	}
	// Riwayat Kesehatan
	public function create($unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';

		// riwayat kesehatan
		// $kesehatan 		   = MasterRiwayatKesehatan::where('tipe', 'K')->get();
		// $riwayat_kesehatan = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'K')->get();
		// $data['riwayat_kesehatan'] = [];
		// foreach($kesehatan as $n =>$d){
		// 	$data['riwayat_kesehatan'][$d->id]['id'] = $d->id;
		// 	$data['riwayat_kesehatan'][$d->id]['nama'] = $d->nama;
		// 	foreach($riwayat_kesehatan as $key => $isi){
		// 		$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
		// 		$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
		// 	}
		// }
		// dd($data['riwayat_kesehatan']);
		// informasi
		$informasi 		   = MasterRiwayatKesehatan::where('tipe', 'I')->get();
		$riwayat_info      = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'I')->get();
		$data['riwayat_info'] = [];
		foreach ($informasi as $n => $d) {
			$data['riwayat_info'][$d->id]['id'] = $d->id;
			$data['riwayat_info'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_info as $key => $isi) {
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// cara masuk
		$caramasuk  = MasterRiwayatKesehatan::where('tipe', 'CM')->get();
		$CM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'CM')->get();
		$data['CM'] = [];
		foreach ($caramasuk as $n => $d) {
			$data['CM'][$d->id]['id'] = $d->id;
			$data['CM'][$d->id]['nama'] = $d->nama;
			foreach ($CM as $key => $isi) {
				$data['CM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['CM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// asal masuk
		$asalmasuk  = MasterRiwayatKesehatan::where('tipe', 'AM')->get();
		$AM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'AM')->get();
		$data['AM'] = [];
		foreach ($asalmasuk as $n => $d) {
			$data['AM'][$d->id]['id'] = $d->id;
			$data['AM'][$d->id]['nama'] = $d->nama;
			foreach ($AM as $key => $isi) {
				$data['AM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['AM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// riwayat Alergi
		// $alergi 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		// $riwayat_alergi = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'A')->get();
		// $data['riwayat_alergi'] = [];
		// foreach ($alergi as $n => $d) {
		// 	$data['riwayat_alergi'][$d->id]['id'] = $d->id;
		// 	$data['riwayat_alergi'][$d->id]['nama'] = $d->nama;
		// 	foreach ($riwayat_alergi as $key => $isi) {
		// 		$data['riwayat_alergi'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
		// 	}
		// }

		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		return view('emr.modules.medical_history', $data);
	}

	public function triase($unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';

		// riwayat kesehatan
		// $kesehatan 		   = MasterRiwayatKesehatan::where('tipe', 'K')->get();
		// $riwayat_kesehatan = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'K')->get();
		// $data['riwayat_kesehatan'] = [];
		// foreach($kesehatan as $n =>$d){
		// 	$data['riwayat_kesehatan'][$d->id]['id'] = $d->id;
		// 	$data['riwayat_kesehatan'][$d->id]['nama'] = $d->nama;
		// 	foreach($riwayat_kesehatan as $key => $isi){
		// 		$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
		// 		$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
		// 	}
		// }
		// dd($data['riwayat_kesehatan']);
		// informasi
		$informasi 		   = MasterRiwayatKesehatan::where('tipe', 'I')->get();
		$riwayat_info      = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'I')->get();
		$data['riwayat_info'] = [];
		foreach ($informasi as $n => $d) {
			$data['riwayat_info'][$d->id]['id'] = $d->id;
			$data['riwayat_info'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_info as $key => $isi) {
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// cara masuk
		$caramasuk  = MasterRiwayatKesehatan::where('tipe', 'CM')->get();
		$CM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'CM')->get();
		$data['CM'] = [];
		foreach ($caramasuk as $n => $d) {
			$data['CM'][$d->id]['id'] = $d->id;
			$data['CM'][$d->id]['nama'] = $d->nama;
			foreach ($CM as $key => $isi) {
				$data['CM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['CM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// asal masuk
		$asalmasuk  = MasterRiwayatKesehatan::where('tipe', 'AM')->get();
		$AM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'AM')->get();
		$data['AM'] = [];
		foreach ($asalmasuk as $n => $d) {
			$data['AM'][$d->id]['id'] = $d->id;
			$data['AM'][$d->id]['nama'] = $d->nama;
			foreach ($AM as $key => $isi) {
				$data['AM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['AM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// riwayat Alergi
		// $alergi 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		// $riwayat_alergi = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'A')->get();
		// $data['riwayat_alergi'] = [];
		// foreach ($alergi as $n => $d) {
		// 	$data['riwayat_alergi'][$d->id]['id'] = $d->id;
		// 	$data['riwayat_alergi'][$d->id]['nama'] = $d->nama;
		// 	foreach ($riwayat_alergi as $key => $isi) {
		// 		$data['riwayat_alergi'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
		// 	}
		// }

		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		return view('emr.modules.triase', $data);
	}


	public function pemeriksaanfisik($unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';

		// riwayat kesehatan
		$kesehatan 		   = MasterRiwayatKesehatan::where('tipe', 'K')->get();
		$riwayat_kesehatan = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'K')->get();
		$data['riwayat_kesehatan'] = [];
		foreach ($kesehatan as $n => $d) {
			$data['riwayat_kesehatan'][$d->id]['id'] = $d->id;
			$data['riwayat_kesehatan'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_kesehatan as $key => $isi) {
				$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}
		// dd($data['riwayat_kesehatan']);
		// informasi
		$informasi 		   = MasterRiwayatKesehatan::where('tipe', 'I')->get();
		$riwayat_info      = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'I')->get();
		$data['riwayat_info'] = [];
		foreach ($informasi as $n => $d) {
			$data['riwayat_info'][$d->id]['id'] = $d->id;
			$data['riwayat_info'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_info as $key => $isi) {
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// cara masuk
		$caramasuk  = MasterRiwayatKesehatan::where('tipe', 'CM')->get();
		$CM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'CM')->get();
		$data['CM'] = [];
		foreach ($caramasuk as $n => $d) {
			$data['CM'][$d->id]['id'] = $d->id;
			$data['CM'][$d->id]['nama'] = $d->nama;
			foreach ($CM as $key => $isi) {
				$data['CM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['CM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// asal masuk
		$asalmasuk  = MasterRiwayatKesehatan::where('tipe', 'AM')->get();
		$AM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'AM')->get();
		$data['AM'] = [];
		foreach ($asalmasuk as $n => $d) {
			$data['AM'][$d->id]['id'] = $d->id;
			$data['AM'][$d->id]['nama'] = $d->nama;
			foreach ($AM as $key => $isi) {
				$data['AM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['AM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// riwayat Alergi
		$alergi 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$riwayat_alergi = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'A')->get();
		$data['riwayat_alergi'] = [];
		foreach ($alergi as $n => $d) {
			$data['riwayat_alergi'][$d->id]['id'] = $d->id;
			$data['riwayat_alergi'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_alergi as $key => $isi) {
				$data['riwayat_alergi'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
			}
		}

		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		return view('emr.modules.pemeriksaan_fisik', $data);
	}


	public function save(Request $request)
	{


		LogUserController::log(Auth::user()->id, 'cppt',$request->registrasi_id);
		$data['reg']            = Registrasi::find($request->registrasi_id);
		$pegawai = Pegawai::where('user_id', Auth::user()->id)
			->where('kategori_pegawai', 1)
			->first();

		if ($pegawai) {
			@updateTaskId(5, $data['reg']->nomorantrian);
		}

		$create                 = new Emr();
		$create->registrasi_id  = $request->registrasi_id;
		$create->pasien_id      = $request->pasien_id;
		$create->subject        = $request->subject;
		$create->object         = $request->object;
		$create->hasil_usg      = $request->hasil_usg;
		$create->hasil_echo     = $request->hasil_echo;
		$create->hasil_ekg      = $request->hasil_ekg;
		$create->hasil_eeg      = $request->hasil_eeg;
		$create->histori_ranap_id      = @$request->histori_ranap_id;
		$create->hasil_ctg      = $request->hasil_ctg;
		$create->hasil_spirometri       = $request->hasil_spirometri;
		$create->hasil_lainnya  = $request->hasil_lainnya;
		$create->assesment      = $request->assesment;
		$create->diagnosistambahan      = $request->assesment_tambahan;
		$create->notation       = $request->notation;
		$create->planning       = $request->planning;
		$create->diagnosis      = $request->diagnosis;
		$create->keterangan     = $request->keterangan;
		$create->edukasi        = @$request->edukasi;
		$create->is_sesuai         = @$request->sesuai;
		$create->diet           = @$request->diet;
		$create->prognosis      = @$request->prognosis;
		$create->discharge = json_encode($request->fisik);
		$create->unit           = $request->unit;
		$create->dokter_id      = Auth::user()->id;
		$create->poli_id        = @$request->poli_id;
		$create->user_id        = Auth::user()->id;
		if ($request->created_at) {
			$create->created_at = date('Y-m-d H:i:s', strtotime($request->created_at));
		}
		// dd($create);
		// $create->keterangan = $request->kondisi;
		if (satusehat()) {
			if (Satusehat::find(12)->aktif) {
				$id_edukasi    = SatuSehatController::ProcedureEducationPost($request->registrasi_id, $request->edukasi);
			}
			if (Satusehat::find(13)->aktif) {
				$id_diet       = SatuSehatController::CompositionPost($request->registrasi_id, @$request->diet);
			}
			if (Satusehat::find(14)->aktif) {
				$id_prognosis  = SatuSehatController::ClinicalImpressionPost($request->registrasi_id, @$request->prognosis);
			}
			$id_observation_ss = [
				'edukasi'       => @$id_edukasi,
				'diet'          => @$id_diet,
				'prognosis'          => @$id_prognosis
			];
			$create->id_observation_ss = json_encode($id_observation_ss);
		}
		$create->save();

		// buat surkon otomatis jika diisi kontrol ulang rs
		$notifKontrol = null;
		if (isset($request->fisik['dischargePlanning']['kontrol'])) {
			$kontrol = $request->fisik['dischargePlanning']['kontrol'];
			$registrasi = Registrasi::find($request->registrasi_id);
			$poli = Poli::where('id',$registrasi->poli_id)->first();

			if (
				$registrasi &&
				$registrasi->bayar == 1 &&
				isset($kontrol['dipilih']) &&
				strtolower($kontrol['dipilih']) == 'kontrol ulang rs' &&
				!empty($kontrol['waktu'])
			) {
				$tglKontrol = date('Y-m-d', strtotime($kontrol['waktu']));

				if (!empty($registrasi->no_sep)) {
					try {
						$reqKontrol = new Request([
							'registrasi_id'   => $registrasi->id,
							'no_sep'          => $registrasi->no_sep,
							'rencana_kontrol' => $tglKontrol,
							'poli_id'         => $poli->bpjs,
							'kode_dokter'     => optional(Pegawai::find($registrasi->dokter_id))->kode_bpjs,
						]);

						$bridging = new BridgingSEPController();
						$response = $bridging->buatSuratKontrol($reqKontrol);
						$jsonRes = json_decode($response->getContent(), true);

						if (@$jsonRes[0]['metaData']['code'] == '200') {
							$notifKontrol = 'Surat Kontrol BPJS berhasil dibuat.';
						} else {
							$notifKontrol = 'Gagal membuat Surat Kontrol: ' . @$jsonRes[0]['metaData']['message'];
						}
					} catch (\Exception $e) {
						Log::error('Gagal auto buat surat kontrol BPJS: ' . $e->getMessage());
						$notifKontrol = 'Terjadi kesalahan saat membuat Surat Kontrol BPJS.';
					}
				}
			}
		}

		//Jika Poli Rehab Medik (Auto Simpan Asesmen - Layanan Rehab, Program Terapi, Uji Fungsi)
		if (@$request->poli_id == 20) {
			$layananRehabExists = EmrInapPemeriksaan::where('registrasi_id', $request->registrasi_id)
				->where('type', 'layanan_rehab')
				->exists();
			if (!$layananRehabExists) {
				$fisikRehab = [
					'anamnesa' => @$request->subject,
					'pemeriksaan_fisik' => @$request->object,
					'tgl_pelayanan' => date('Y-m-d H:i:s'),
					'pemeriksaan_penunjang' => '-',
					'anjuran' => 'FT',
					'evaluasi' => '8x',
					'penyakitAkibatkerja' => [
						'pilihan' => 'Tidak',
						'keterangan' => NULL,
					],
					'icd10' => @$request->assesment,
					'icd9' => @$request->icd9,

				];

				$layananRehab = new EmrInapPemeriksaan();
				$layananRehab->type = 'layanan_rehab';
				$layananRehab->pasien_id = $request->pasien_id;
				$layananRehab->registrasi_id = $request->registrasi_id;
				$layananRehab->user_id = Auth::user()->id;
				$layananRehab->fisik = json_encode($fisikRehab);
				$layananRehab->save();
			}

			$programTerapiExists = EmrInapPemeriksaan::where('registrasi_id', $request->registrasi_id)
				->where('type', 'program_terapi_rehab')
				->exists();
			if(!$programTerapiExists){
				$fisikTerapi = [
					'permintaanTerapi' => @$request->icd9,
					'program' => [
						'1' => @$request->icd9,
					],
					'tgl' => [
						'1' => date('d-m-Y'),
					],
				];

				$programTerapi = new EmrInapPemeriksaan();
				$programTerapi->type = 'program_terapi_rehab';
				$programTerapi->pasien_id = $request->pasien_id;
				$programTerapi->registrasi_id = $request->registrasi_id;
				$programTerapi->user_id = Auth::user()->id;
				$programTerapi->fisik = json_encode($fisikTerapi);
				$programTerapi->save();
			}

			$ujiFungsiExists = EmrInapPemeriksaan::where('registrasi_id', $request->registrasi_id)
			->where('type', 'uji_fungsi_rehab')
			->exists();
			if(!$ujiFungsiExists){
				$fisikUjiFungsi = [
					'hasilDidapat' => @$request->object,
					'kesimpulan' => @$request->assesment,
					'tgl_pelayanan' => date('d-m-Y'),
					'rekomendasi' => @$request->icd9,
				];

				$ujiFungsi = new EmrInapPemeriksaan();
				$ujiFungsi->type = 'uji_fungsi_rehab';
				$ujiFungsi->pasien_id = $request->pasien_id;
				$ujiFungsi->registrasi_id = $request->registrasi_id;
				$ujiFungsi->user_id = Auth::user()->id;
				$ujiFungsi->fisik = json_encode($fisikUjiFungsi);
				$ujiFungsi->save();
			}

		}
		//End Poli Rehab

		// Jika dari Gawat Darurat (Auto buat transfer internal)
		if ($request->unit == "igd") {
			$situation = $request->subject;
			$background = '';
			$assesment = [
				'diagnosa_medis' => $request->assesment,
			];
			$recomendation = '';
			$ekstra = [
				'ruang_asal' => $request->poli_id == 23 ? 'IGD' : 'IGD Kebidanan',
				'sbar_tipe' => 'sbar-igd',
				'dokter_yang_merawat' => Auth::user()->pegawai->nama
			];


			$create = new Emr();
			$create->registrasi_id = $request->registrasi_id;
			$create->pasien_id = $request->pasien_id;
			$create->situation = @$situation;
			$create->background = @$background;
			$create->histori_ranap_id = @$request->histori_ranap_id;
			$create->assesment = json_encode(@$assesment);
			$create->recomendation = @$recomendation;
			$create->ekstra = @json_encode(@$ekstra);
			$create->unit = 'sbar';
			$create->dokter_id = Auth::user()->pegawai->id;
			$create->poli_id = @$request->poli_id;
			$create->user_id = Auth::user()->id;
			$create->save();
		}
		// End IGD

		// Jika buat transfer internal di checklist
		if (!empty($request->transfer_internal_keluar)) {
			$situation = $request->subject;
			$background = [
				'hasil_pemeriksaan_selama_dirawat' => $request->object,
			];
			$assesment = [
				'diagnosa_medis' => $request->assesment,
				'diagnosa_keperawatan' => $request->assesment_tambahan,
			];
			$recomendation = $request->planning;
			$ekstra = [
				'ruang_asal' => 'Ruangan',
				'ruang_asal_detail' => baca_kamar(@Rawatinap::where('registrasi_id', $request->registrasi_id)->first()->kamar_id),
				'sbar_tipe' => 'sbar-inap-keluar-ruangan',
				'dokter_yang_merawat' => Auth::user()->pegawai->nama
			];


			$create = new Emr();
			$create->registrasi_id = $request->registrasi_id;
			$create->pasien_id = $request->pasien_id;
			$create->situation = @$situation;
			$create->background = json_encode(@$background);
			$create->assesment = json_encode(@$assesment);
			$create->recomendation = @$recomendation;
			$create->ekstra = @json_encode(@$ekstra);
			$create->unit = 'sbar';
			$create->dokter_id = Auth::user()->pegawai->id;
			$create->poli_id = @$request->poli_id;
			$create->user_id = Auth::user()->id;
			$create->save();
		}
		// End transfer internal

		if ($request->unit == 'farmasi') {
		Flashy::success('CPPT berhasil di input!');
		} else {
			if ($notifKontrol) {
				Flashy::success('CPPT berhasil di input! ' . $notifKontrol);
			} else {
				Flashy::success('CPPT berhasil di input! Mohon segera lakukan TTE pada menu hasil → histori → E-Resume.');
			}
		}

		return redirect()->back();
	}
	public function updateSoap(Request $request)
	{

		$create = Emr::find($request->emr_id);
		if ($create) {
			$create->subject = $request->subject;
			$create->object = $request->object;
			if ($request->has('hasil_usg')) {
				$create->hasil_usg = $request->hasil_usg;
			}
			if ($request->has('hasil_echo')) {
				$create->hasil_echo = $request->hasil_echo;
			}
			if ($request->has('hasil_ekg')) {
				$create->hasil_ekg = $request->hasil_ekg;
			}
			if ($request->has('hasil_eeg')) {
				$create->hasil_eeg = $request->hasil_eeg;
			}
			if ($request->has('hasil_ctg')) {
				$create->hasil_ctg = $request->hasil_ctg;
			}
			if ($request->has('hasil_spirometri')) {
				$create->hasil_spirometri = $request->hasil_spirometri;
			}
			if ($request->has('hasil_lainnya')) {
				$create->hasil_lainnya = $request->hasil_lainnya;
			}			
			$create->assesment = $request->assesment;
			$create->diagnosistambahan = $request->assesment_tambahan;
			$create->notation = $request->notation;
			$create->planning = $request->planning;
			$create->is_sesuai         = @$request->sesuai;
			$create->diagnosis = $request->diagnosis;
			$create->histori_ranap_id = @$request->histori_ranap_id;
			$create->keterangan = $request->keterangan;
			$create->discharge = json_encode($request->fisik);
			if ($request->created_at) {
				$create->created_at = date('Y-m-d H:i:s', strtotime($request->created_at));
			}
			$create->save();
		}


		Flashy::success('SOAP berhasil di diedit !');

		return redirect()->back();
	}


	public function savePerawat(Request $request)
	{
		LogUserController::log(Auth::user()->id, 'cppt',$request->registrasi_id);
		$planning = $request->planning;
		$implementasi = $request->implementasi;
		$assesment = $request->assesment;
		$create = new Emr();
		$create->registrasi_id = $request->registrasi_id;
		$create->pasien_id = $request->pasien_id;
		$create->subject = $request->subject;
		$create->object = $request->object;
		$create->assesment = @is_array(@$assesment) ? implode(' | ', @$assesment) : @$assesment;;
		$create->notation = $request->notation;
		$create->planning = @is_array(@$planning) ? implode(' | ', @$planning) : @$planning;
		$create->diagnosis = $request->diagnosis;
		$create->nadi = $request->nadi;
		$create->tekanan_darah = $request->tekanan_darah;
		$create->frekuensi_nafas = $request->frekuensi_nafas;
		$create->kesadaran = $request->kesadaran;
		$create->histori_ranap_id = @$request->histori_ranap_id;
		$create->state = $request->state;
		$create->suhu = $request->suhu;
		$create->saturasi = $request->saturasi;
		$create->berat_badan = $request->berat_badan;
		$create->skala_nyeri = $request->skala_nyeri;
		$create->keterangan = $request->keterangan;
		$create->implementasi = @is_array(@$implementasi) ? implode(' | ', @$implementasi) : @$implementasi;
		$create->discharge = json_encode($request->fisik);
		$create->unit = $request->unit;
		$create->dokter_id = Auth::user()->id;
		$create->poli_id = @$request->poli_id;
		$create->user_id = Auth::user()->id;
		// $create->created_at = date('Y-m-d', strtotime($request->created_at)) . ' ' . date("H:i:s");
		if ($request->created_at) {
			$create->created_at = date('Y-m-d H:i:s', strtotime($request->created_at));
		}
		// $create->keterangan = $request->kondisi;
		if (satusehat()) {
			if (Satusehat::find(11)->aktif) {
				$tekananDarah   = @explode('/', @$request->tekanan_darah);
				$id_nadi        = SatuSehatController::ObservationPostNadi($request->registrasi_id, @$request->nadi);
				$id_pernafasan  = SatuSehatController::ObservationPostPernafasan($request->registrasi_id, @$request->frekuensi_nafas);
				$id_sistol      = SatuSehatController::ObservationPostSistol($request->registrasi_id, @$tekananDarah[0]);
				$id_distol      = SatuSehatController::ObservationPostDistol($request->registrasi_id, @$tekananDarah[1]);
				$id_suhu        = SatuSehatController::ObservationPostSuhu($request->registrasi_id, @$request->suhu);
				$id_kesadaran   = SatuSehatController::ObservationPostKesadaran($request->registrasi_id, @$request->kesadaran);
				$id_observation_ss = [
					'nadi'          => @$id_nadi,
					'pernafasan'    => @$id_pernafasan,
					'sistol'        => @$id_sistol,
					'distol'        => @$id_distol,
					'suhu'          => @$id_suhu,
					'kesadaran'     => @$id_kesadaran
				];
				// dd($id_observation_ss);
				$create->id_observation_ss = json_encode($id_observation_ss);
			}
		}
		$create->save();


		Flashy::success('CPPT berhasil di input !');

		return redirect()->back();
	}


	public function updateSoapPerawat(Request $request)
	{
		$create = Emr::find($request->emr_id);
		$planning = $request->planning;
		$implementasi = $request->implementasi;
		$assesment = $request->assesment;
		if ($create) {
			$create->subject = $request->subject;
			$create->object = $request->object;
			$create->assesment = @is_array(@$assesment) ? implode(' | ', @$assesment) : @$assesment;;
			$create->notation = $request->notation;
			$create->planning = is_array($planning) ? implode(' | ', $planning) : $planning;
			$create->diagnosis = $request->diagnosis;
			$create->keterangan = $request->keterangan;
			$create->nadi = $request->nadi;
			$create->state = $request->state;
			$create->histori_ranap_id = @$request->histori_ranap_id;
			$create->tekanan_darah = $request->tekanan_darah;
			$create->frekuensi_nafas = $request->frekuensi_nafas;
			$create->suhu = $request->suhu;
			$create->berat_badan = $request->berat_badan;
			$create->skala_nyeri = $request->skala_nyeri;
			$create->implementasi = is_array($implementasi) ? implode(' | ', $implementasi) : $implementasi;
			// $create->created_at = date('Y-m-d', strtotime($request->created_at));
			// $create->created_at = Carbon::createFromFormat('Y-m-d\TH:i', $request->created_at);
			if ($request->created_at) {
				$create->created_at = date('Y-m-d H:i:s', strtotime($request->created_at));
			}
			$create->save();
		}


		Flashy::success('SOAP berhasil di diedit !');

		return redirect()->back();
	}




	public function duplicateSoap($id, $dpjp, $poli, $reg_id)
	{
		$find = Emr::find($id);
		if ($find) {
			LogUserController::log(Auth::user()->id, 'cppt',$reg_id);

			// dd($find);
			$create = new Emr();
			$create->registrasi_id = @$reg_id;
			$create->pasien_id = @$find->pasien_id;
			$create->histori_ranap_id = @$find->histori_ranap_id;
			$create->subject = @$find->subject;
			$create->object = @$find->object;
			$create->assesment = @$find->assesment;
			$create->notation = @$find->notation;
			$create->planning = @$find->planning;
			// new
			$create->diet = @$find->planning;
			$create->tekanandarah = @$find->tekanandarah;
			$create->bb = @$find->bb;
			$create->pemeriksaan_fisik = @$find->pemeriksaan_fisik;
			$create->diagnosis = @$find->diagnosis;
			$create->diagnosistambahan = @$find->diagnosistambahan;
			$create->discharge = @$find->discharge;
			$create->nadi = @$find->nadi;
			$create->tekanan_darah = @$find->tekanan_darah;
			$create->frekuensi_nafas = @$find->frekuensi_nafas;
			$create->suhu = @$find->suhu;
			$create->saturasi = @$find->saturasi;
			$create->berat_badan = @$find->berat_badan;
			$create->skala_nyeri = @$find->skala_nyeri;
			$create->implementasi = @$find->implementasi;
			$create->is_show_resume = @$find->is_show_resume;
			$create->state = @$find->state;
			$create->kesadaran = @$find->kesadaran;
			$create->edukasi = @$find->edukasi;
			$create->diet = @$find->diet;
			$create->prognosis = @$find->prognosis;
			$create->situation = @$find->situation;
			$create->recomendation = @$find->recomendation;
			$create->background = @$find->background;
			$create->ekstra = @$find->ekstra;


			$create->dokter_id = @$dpjp;
			$create->poli_id = @$poli;
			$create->user_id = @Auth::user()->id;
			$create->unit = @$find->unit;
			$create->save();
			Flashy::success('SOAP berhasil di duplikat, silahkan mengedit data');
		}
		// $create->keterangan = $request->kondisi;

		// KALAU REGISTRASI SEBELUMNYA SUDAH DIHAPUS MAKA AMBIL ID REGISTRASI YG SEKARANG
		$cek_reg = Registrasi::where('id', $find->registrasi_id)->first();
		if (!$cek_reg) {
			@$find->registrasi_id = $reg_id;
		}
		// return redirect('/emr/soap/' . $create->unit . '/' . $create->registrasi_id . '/' . $create->id . '/edit?poli=' . $poli . '&dpjp=' . $dpjp);
		return redirect()->back();
	}




	public function duplicateSoapPerawat($id, $dpjp, $poli, $reg_id)
	{
		LogUserController::log(Auth::user()->id, 'cppt',$reg_id);
		$find = Emr::find($id);
		if ($find) {
			// dd($find);
			$create = new Emr();
			$create->registrasi_id = $reg_id;
			$create->pasien_id = @$find->pasien_id;
			$create->histori_ranap_id = @$find->histori_ranap_id;
			$create->subject = $find->subject;
			$create->object = $find->object;
			$create->assesment = $find->assesment;
			$create->notation = $find->notation;
			$create->planning = $find->planning;
			$create->dokter_id = @$dpjp;
			$create->poli_id = @$poli;
			$create->subject = $find->subject;
			$create->object = $find->object;
			$create->diagnosis = $find->diagnosis;
			$create->keterangan = $find->keterangan;
			$create->nadi = $find->nadi;
			$create->tekanan_darah = $find->tekanan_darah;
			$create->frekuensi_nafas = $find->frekuensi_nafas;
			$create->suhu = $find->suhu;
			$create->berat_badan = $find->berat_badan;
			$create->skala_nyeri = $find->skala_nyeri;
			$create->implementasi = $find->implementasi;
			$create->user_id = Auth::user()->id;
			$create->unit = $find->unit;
			$create->save();
			Flashy::success('SOAP berhasil di duplikat, silahkan mengedit data');
		}
		// $create->keterangan = $request->kondisi;


		// return redirect('/emr/soap-perawat/'.$create->unit.'/'.$find->registrasi_id.'/'.$create->id.'/edit?poli='.$poli.'&dpjp='.$dpjp);
		return redirect()->back();
	}







	public function deleteResume($id)
	{
		$find   = Emr::find($id);
		$find->delete();
		// $rencana = RencanaKontrol::where('resume_id', $id)->delete();
		return response()->json(true);
	}

	public function cetakResume($reg_id)
	{
		$data['reg'] = Registrasi::find($reg_id);
		$data['resume'] = Emr::where('registrasi_id', $reg_id)->get();

		return view('emr.cetak', $data)->with('no', 1);
	}

	public function cetakPDFResume($reg_id)
	{
		$reg    = Registrasi::find($reg_id);
		$resume = Emr::where('registrasi_id', $reg_id)->get();

		$pdf = PDF::loadView('emr.cetak_pdf', compact('reg', 'resume'));
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream('resume-laporan.pdf');
	}

	public function cetakPDFResumeRencanaKontrol($reg_id)
	{
		$reg    = Registrasi::find($reg_id);
		$resume = Emr::where('registrasi_id', $reg_id)->get();

		$pdf = PDF::loadView('emr.cetak_pdf_rencana_kontrol', compact('reg', 'resume'));
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream('resume-laporan.pdf');
	}

	public function historySoap($unit, $pasienId)
	{
		$data['unit'] = $unit;
		$data['reg'] = '';
		$data['registrasis'] = Registrasi::where('pasien_id', $pasienId)
			->groupBy('poli_id')
			->orderBy('id', "DESC")
			->get(['id', 'poli_id', 'created_at']);

		$data['historyEmr'] = [];

		return view('emr.modules.modal-history-soap', $data);
	}

	public function filterHistorySoap(Request $req, $unit, $regId)
	{
		$data['unit'] = $unit;
		$data['reg'] = Registrasi::find($regId);
		$data['registrasis'] = Registrasi::where('pasien_id', $data['reg']->pasien_id)
			->groupBy('poli_id')
			->orderBy('id', "DESC")
			->get(['id', 'poli_id', 'created_at']);

		$data['historyEmr'] = Emr::join('registrasis', 'registrasis.id', '=', 'emr.registrasi_id')
			->where('emr.pasien_id', $data['reg']->pasien_id)
			->where('registrasis.poli_id', $data['reg']->poli_id)
			->orderBy('emr.id', 'DESC')
			->select('emr.*')
			->get();

		// dd($data['historyEmr']);
		return view('emr.modules.modal-history-soap', $data);
	}

	public function historyGizi($pasienId)
	{
		$data['reg'] = '';
		$data['registrasis'] = Registrasi::where('pasien_id', $pasienId)
			->orderBy('id', "DESC")
			->get(['id', 'created_at']);

		$data['historyEmr'] = EmrGizi::join('registrasis', 'registrasis.id', '=', 'emr_gizi.registrasi_id')
			->where('registrasis.pasien_id', $pasienId)
			->orderBy('emr_gizi.id', 'DESC')
			// ->select('emr_gizi.*')
			->get();

		return view('emr.modules.modal-history-gizi', $data);
	}

	public function modalListKontrol($tglKontrol, $dokterId)
	{
		$data['no'] = 1;
		$data['tglKontrol'] = Carbon::parse($tglKontrol)->format('Y-m-d');
		$data['dokter'] = Pegawai::find($dokterId);
		$data['rencanaKontrols'] = RencanaKontrol::with(['registrasi', 'registrasi.pasien'])
			->where('dokter_id', $dokterId)
			->where('tgl_rencana_kontrol', $data['tglKontrol'])
			->get();


		return view('emr.modules.modal-list-kontrol', $data);
	}

	public function listSoap($unit,$registrasi_id,$pasien_id)
	{
		// dd($unit);
		$data['reg']            = Registrasi::find($registrasi_id);

		// JIKA ENCOUNTER KOSONG JALANKAN FUNGSI ENCOUNTER
		if(!$data['reg']->id_encounter_ss){
			if(satusehat()) {
				if (Satusehat::find(1)->aktif == 1) {
					if(cek_jenis_reg($data['reg']->status_reg) == 'Rawat Jalan'){
                        $data['reg']->id_encounter_ss = SatuSehatController::EncounterPost($data['reg']->id,'registrasi');
                        $data['reg']->save();
                    }
                }
            }
		}

		$data['unit'] = $unit;
		$data['all_resume_emr']     = Emr::where('pasien_id', @$pasien_id)->where('unit', '!=', 'sbar')->orderBy('id', 'DESC')->get();
		$data['all_resume_gizi'] = EmrGizi::where('pasien_id', @$data['reg']->pasien->id)
		->orderBy('id', 'DESC')
		->get()
		->map(function($item) {
			$item->unit = 'gizi';
			return $item;
		});
		$data['all_resume'] 	= $data['all_resume_gizi']->merge($data['all_resume_emr'])->sortByDesc(function ($item) {
			return strtotime($item->created_at);
			})
			->values();
		
		return view('emr.modules.history-soap', $data);
	}
	public function listTindakan($unit,$registrasi_id,$pasien_id)
	{
		// dd($unit);
		$data['reg']            = Registrasi::find($registrasi_id);
		// @updateTaskId(4,$data['reg']->nomorantrian);
		// @updateTaskId(5,$data['reg']->nomorantrian);
		$data['opt_poli'] = Poli::where('politype', 'J')->get();
		session(['jenis' => 'TA']);
		$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
		// $data['perawatreal']  = explode(",", $data['perawats'][0]);
		$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		// if (Auth::user()->hasRole(['administrator'])) {
		$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $registrasi_id])->get();
		$data['pelaksana']   = Pegawai::where('kategori_pegawai', '1')->get();
		$data['perawat'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
		$data['no'] = 1;
		$data['tagihan'] = $data['folio']->sum('total');
		$data['dokter'] = Pegawai::all();
		$data['carabayar'] 	    = Carabayar::all('carabayar', 'id');
		return view('emr.modules.history-tindakan', $data);
	}
	public function soap($unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		// dd("Maaf Sistem Sedang Di Maintenace");
		$data['registrasi_id']  = $registrasi_id;
		// dd($data['registrasi_id']);
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);

		
		
		

		$data['edukasi']        = Edukasi::all();
		$data['prognosis']      = Prognosis::all();
		// $data['resume']         = Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', '!=', 'sbar')->first();
		$data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		// $data['dokter']         = Pegawai::pluck('nama', 'id');
		
		// $data['tiket'] 		    = MasterEtiket::all('nama', 'id');
		// $data['cara_minum']     = Aturanetiket::all('aturan', 'id');
		// $data['takaran'] 	    = TakaranobatEtiket::all('nama', 'nama');
		// $data['all_resume_emr']     = Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', '!=', 'sbar')->orderBy('id', 'DESC')->get();
		// $data['all_resume_gizi'] = EmrGizi::where('pasien_id', @$data['reg']->pasien->id)
		// 	->orderBy('id', 'DESC')
		// 	->get()
		// 	->map(function($item) {
		// 		$item->unit = 'gizi';
		// 		return $item;
		// 	});
		// $data['all_resume'] 	= $data['all_resume_gizi']->merge($data['all_resume_emr'])->sortByDesc(function ($item) {
		// 	return strtotime($item->created_at);
		// 	})
		// 	->values();
		$data['emr']			= Emr::find($id_soap);
		$data['pemeriksaan']    = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->get();
		$data['gambar']         = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
		$data['currentEmr']     = Emr::where('registrasi_id', $registrasi_id)->where('unit', '!=', 'sbar')->latest()->first();
		$dokter				    = Pegawai::find($data['reg']->dokter_id);
        $data['cppt_perawat']   = Emr::where('user_id', '!=' , $dokter->user_id)->where('registrasi_id', $data['reg']->id)->latest()->first();
		$assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mata')->first();
		$data['assesment_mata'] = json_decode(@$assesment->fisik, true);
		// $data['assesment_dokter'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('user_id', $dokter->user_id)->orWhere('userdokter_id', $dokter->user_id)->latest()->first();
		$data['assesment_dokter'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('user_id', $dokter->user_id)->latest()->first();

		$resep = ResepNote::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$data['namaObat'] = [];

		@$aswal_inap = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_dokter())->latest()->first();
		$data['aswal_inap'] = json_decode(@$aswal_inap->fisik, true);

		if ($resep) {
			$resepDetail = ResepNoteDetail::where('resep_note_id', $resep->id)->select('logistik_batch_id', 'cara_minum')->get();

			foreach ($resepDetail as $item) {
				$data['namaObat'][] = [
					'obat' => $item->logistik_batch->master_obat->nama,
					'signa' => $item->cara_minum,
				];
			}
		}

		// dd($data['namaObat']);

		//Tambahan
		$jenis = $data['reg']->status_reg;
		
		// if($unit !== 'jalan'){
			$data['pelaksana']   = Pegawai::where('kategori_pegawai', '1')->get();
			$data['perawat'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
			$data['no'] = 1;

			if($unit == "jalan"){
				$bayarjkn = $data['reg']->bayar;
				$cekPRB = PotensiPRB::where('no_kartu', $data['reg']->no_jkn)
                        ->where('poli_id', $data['reg']->poli_id)
                        ->first();
				if (($cekPRB)&& ($bayarjkn==1)) {
					$data['ketPRB'] = 'ya';
				}
			}
	
			if ($unit == "inap") {
				ini_set('max_execution_time', 0); //0=NOLIMIT
				ini_set('memory_limit', '8000M');
				$data['icd9'] = PerawatanIcd9::where('registrasi_id',  $registrasi_id)->pluck('icd9')->toArray();
				$data['icd10'] = PerawatanIcd10::where('registrasi_id',  $registrasi_id)->pluck('icd10')->toArray();
				$data['reg_id'] = $registrasi_id;
				$data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
				$data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
				$data['histori_ranap'] = HistoriRawatInap::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->get();
				if ($data['rawatinap']) {
					if (@$data['reg']->status_reg == NULL) {
						if ($data['rawatinap']->tgl_keluar) {
							@$data['reg']->status_reg = 'I3';
						} else {
							@$data['reg']->status_reg = 'I2';
						}
						@$data['reg']->save();
					}
				}

				$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
				$data['kamar'] = Kamar::pluck('nama', 'id');
				$data['kelas'] = Kelas::pluck('nama', 'id');
				// $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
				// $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
				$data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
				$data['pagu'] = PaguPerawatan::all();
				// inhealth mandiri
				// $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
				if ($data['rawatinap']) {
					session(['kelas' => $data['rawatinap']->kelas_id]);
				}
			}
	
			if (substr($jenis, 0, 1) == 'G' || substr($jenis, 0, 1) == 'I') {
				$data['opt_poli'] = Poli::where('politype', 'G')->get();
				$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
				// $data['perawatreal']  = explode(",", $data['perawats'][0]);
				$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
				session(['jenis' => 'TG']);
				$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TG')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
				// if (Auth::user()->hasRole(['administrator'])) {
				$data['folio'] = Folio::whereIn('jenis', ['TG', 'TI'])->where('registrasi_id', $registrasi_id)->get();
	
				// Asesmen IGD
				$asesmen_igd_dokter = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->first();
				$asesmen_igd_perawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-perawat-igd')->first();
				$asesmen_igd_ponek = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd-ponek')->first();
	
				if ($asesmen_igd_dokter) {
					$data['asesmen_igd_ttv'] = @json_decode(@$asesmen_igd_dokter->fisik, true)['igdAwal']['tandaVital'];
					$data['asesmen_igd_dokter'] = @json_decode(@$asesmen_igd_dokter->fisik, true);
				} elseif ($asesmen_igd_ponek) {
					$data['asesmen_igd_ttv'] = @json_decode(@$asesmen_igd_ponek->fisik, true)['tanda_vital'];
					$data['asesmen_igd_ponek'] = @json_decode(@$asesmen_igd_ponek->fisik, true);
				} else {
					$data['asesmen_igd_ttv'] = @json_decode(@$asesmen_igd_perawat->fisik, true)['tanda_vital'];
					$data['asesmen_igd_perawat'] = @json_decode(@$asesmen_igd_perawat->fisik, true);
				}
	
				// KHUSUS USER ANGGUN ,JIKA ADA ADMISI LAINNYA TINGGAL MASUKAN ID NYA SAJA DISINI
				if (Auth::user()->id == '570') {
					$data['opt_poli'] = Poli::where('politype', 'J')->get();
					session(['jenis' => 'TA']);
					$data['jenis']->status_reg = 'J2';
					$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
					// $data['perawatreal']  = explode(",", $data['perawats'][0]);
					$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
					$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
					// if (Auth::user()->hasRole(['administrator'])) {
					$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $registrasi_id])->get();
				}
			} 
			// elseif (substr($jenis, 0, 1) == 'J') {
			// 	$data['opt_poli'] = Poli::where('politype', 'J')->get();
			// 	session(['jenis' => 'TA']);
			// 	$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
			// 	// $data['perawatreal']  = explode(",", $data['perawats'][0]);
			// 	$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
			// 	// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			// 	// if (Auth::user()->hasRole(['administrator'])) {
			// 	$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $registrasi_id])->get();
			// } 
			elseif (substr($jenis, 0, 1) == 'I') {
				session(['jenis' => 'TI']);
				$data['opt_poli'] = Poli::where('politype', 'I')->get();
				$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
				// $data['perawatreal']  = explode(",", $data['perawats'][0]);
				$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
				$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
	
				$data['folio'] = Folio::whereIn('jenis', ['TG', 'TI'])->where('registrasi_id', $registrasi_id)->get();
			}
	
			if($unit !== 'jalan'){
				$data['tagihan'] = $data['folio']->sum('total');
				$data['dokter'] = Pegawai::all();
				$data['carabayar'] 	    = Carabayar::all('carabayar', 'id');
			}

		// }
		
		$data['faskesRujukanRs']  = FaskesRujukanRs::all();

		// dd($data['reg']);
		return view('emr.modules.soap', $data);
	}

	public function soapDelete($unit, $regId, $idSoap)
	{
		$unit = $unit;
		$reg = Registrasi::find($regId);
		// dd($reg->pasien->nama);
		$emr = Emr::find($idSoap);
		$emr->delete();


		Activity::log('User ' . Auth::user()->name . ' Menghapus Emr SOAP pada Pasien ' . @$reg->pasien->nama . '. No.RM ' . @$reg->pasien->no_rm);
		Flashy::success('Berhasil Menghapus Data');
		return redirect('emr/soap/' . $unit . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id);
	}




	public function soap_perawat($unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		// dd("Maaf Sistem Sedang Di Maintenace");
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		// JIKA ENCOUNTER KOSONG JALANKAN FUNGSI ENCOUNTER
		if(!$data['reg']->id_encounter_ss){
			if(satusehat()) {
				if (Satusehat::find(1)->aktif == 1) {
					if(cek_jenis_reg($data['reg']->status_reg) == 'Rawat Jalan'){
                        $data['reg']->id_encounter_ss = SatuSehatController::EncounterPost($data['reg']->id,'registrasi');
                        $data['reg']->save();
                    }
                }
            }
		}
		$data['resume']         = Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', '!=', 'sbar')->first();
		$data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		// $data['dokter'] = Pegawai::pluck('nama', 'id');
		// $data['pegawai'] = Pegawai::pluck('nama', 'id');
		$data['dokter'] = Pegawai::all();
		$data['perawat'] = Pegawai::pluck('nama', 'id');
		// $data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = Aturanetiket::all('aturan', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		$data['all_resume_emr']     = Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', '!=', 'sbar')->orderBy('id', 'DESC')->get();
		$data['all_resume_gizi'] = EmrGizi::where('pasien_id', @$data['reg']->pasien->id)
			->orderBy('id', 'DESC')
			->get()
			->map(function($item) {
				$item->unit = 'gizi';
				return $item;
			});
		$data['all_resume'] 	= $data['all_resume_gizi']->merge($data['all_resume_emr'])->sortByDesc(function ($item) {
			return strtotime($item->created_at);
			})
			->values();
		$data['emr']			= Emr::find($id_soap);
		$data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();
		$data['folios'] = Folio::where('namatarif','NOT LIKE','%retribusi%')->where('namatarif','NOT LIKE','%sticker%')->whereNull('poli_tipe')->where(['registrasi_id' => $registrasi_id])->where('jenis','!=','ORJ')->get();

		if ($unit == "inap") {
			ini_set('max_execution_time', 0); //0=NOLIMIT
			ini_set('memory_limit', '8000M');
			$data['icd9'] = PerawatanIcd9::where('registrasi_id',  $registrasi_id)->pluck('icd9')->toArray();
			$data['icd10'] = PerawatanIcd10::where('registrasi_id',  $registrasi_id)->pluck('icd10')->toArray();
			$data['reg_id'] = $registrasi_id;
			$data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
			$data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
			$data['histori_ranap'] = HistoriRawatInap::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->get();
			if ($data['rawatinap']) {
				if (@$data['reg']->status_reg == NULL) {
					if ($data['rawatinap']->tgl_keluar) {
						@$data['reg']->status_reg = 'I3';
					} else {
						@$data['reg']->status_reg = 'I2';
					}
					@$data['reg']->save();
				}
			}
			$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
			$data['kamar'] = Kamar::pluck('nama', 'id');
			$data['kelas'] = Kelas::pluck('nama', 'id');
			$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
			// $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			$data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
			$data['pagu'] = PaguPerawatan::all();
			// inhealth mandiri
			$data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
			if ($data['rawatinap']) {
				session(['kelas' => $data['rawatinap']->kelas_id]);
			}
		}elseif($unit == 'igd'){
			$asesmenDokter = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
					->where('type', 'assesment-awal-medis-igd')
					->first();
			if($asesmenDokter){
					$data['dataAsesmenDokter'] = json_decode($asesmenDokter->fisik, true);
			}

			// Asesmen IGD
			$asesmen_igd_dokter = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->first();
			$asesmen_igd_perawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-perawat-igd')->first();
			$asesmen_igd_ponek = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd-ponek')->first();

			if ($asesmen_igd_dokter) {
				$data['asesmen_igd'] = @json_decode(@$asesmen_igd_dokter->fisik, true)['igdAwal']['tandaVital'];
				$data['asesmen_igd']['igd_awal'] = true;
			} elseif ($asesmen_igd_ponek) {
				$data['asesmen_igd'] = @json_decode(@$asesmen_igd_ponek->fisik, true)['tanda_vital'];
				$data['asesmen_igd']['igd_awal'] = false;
			} else {
				$data['asesmen_igd'] = @json_decode(@$asesmen_igd_perawat->fisik, true)['tanda_vital'];
				$data['asesmen_igd']['igd_awal'] = false;
			}
		}

		$askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
		if ($askep) {
			$data['siki'] = json_decode($askep->pemeriksaandalam, true);
			$data['implementasi'] = json_decode($askep->fungsional, true);
			$data['diagnosis'] = json_decode($askep->diagnosis, true);
		}

		if (substr($data['reg']->status_reg, 0, 1) == 'G') {
			$aswal = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-perawat-igd')->first();
			if ($aswal && $aswal->fisik) {
				$data['aswalPerawat'] = json_decode(@$aswal->fisik, true);
			}
		}

		$data['faskesRujukanRs']  = FaskesRujukanRs::all();
		
		// dd($data['reg']);
		return view('emr.modules.soap_perawat', $data);
	}

	//SOAP GIZI
	public function soapGizi($unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		// dd("Maaf Sistem Sedang Di Maintenace");
		$data['registrasi_id']  = $registrasi_id;
		// dd($data['registrasi_id']);
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);


		$data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		$data['dokter'] = Pegawai::pluck('nama', 'id');
		$data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = Aturanetiket::all('aturan', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		$data['all_resume']     = EmrGizi::where('pasien_id', @$data['reg']->pasien->id)->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrGizi::find($id_soap);
		$data['cppt']			= Emr::where('registrasi_id', $registrasi_id)->latest()->first();
		$asesmenGizi = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gizi')->orderBy('id', 'DESC')->first();
		if ($asesmenGizi) {
			$data['fisikGizi'] = json_decode($asesmenGizi->fisik, true);
		} else {
			$data['fisikGizi'] = [];
		}
		// dd($data['reg']);
		return view('emr.modules.soap_gizi', $data);
	}

	public function updateSoapGizi(Request $request)
	{

		$create = EmrGizi::find($request->emr_id);
		if ($create) {
			$create->assesment = $request->assesment;
			$create->diagnosis = $request->diagnosis;
			$create->intervensi = $request->intervensi;
			$create->monitoring = $request->monitoring;
			$create->evaluasi = $request->evaluasi;
			$create->update();
		}
		Flashy::success('CPPT Gizi berhasil di edit !');

		return redirect()->back();
	}

	public function soapGiziDelete($id)
	{

		$soap = EmrGizi::find($id);
		if ($soap) {
			$soap->delete();
		}
		Flashy::success('CPPT Gizi berhasil di hapus !');

		return redirect()->back();
	}

	public function duplicateSoapGizi($id, $reg_id)
	{
		LogUserController::log(Auth::user()->id, 'cppt',$reg_id);
		$find = EmrGizi::find($id);
		if ($find) {

			$create = new EmrGizi();
			$create->registrasi_id = $reg_id;
			$create->pasien_id = @$find->pasien_id;
			$create->kamar_id = @$find->kamar_id;
			$create->assesment = $find->assesment;
			$create->diagnosis = $find->diagnosis;
			$create->intervensi = $find->intervensi;
			$create->monitoring = $find->monitoring;
			$create->evaluasi = $find->evaluasi;
			$create->user_id = Auth::user()->id;
			$create->save();
			Flashy::success('CPPT Gizi berhasil di duplikat, silahkan mengedit data');
		}

		// KALAU REGISTRASI SEBELUMNYA SUDAH DIHAPUS MAKA AMBIL ID REGISTRASI YG SEKARANG
		$cek_reg = Registrasi::where('id', $find->registrasi_id)->first();
		if (!$cek_reg) {
			$find->registrasi_id = $reg_id;
		}

		return redirect('/emr/soap-gizi/inap/' . $find->registrasi_id . '/' . $create->id . '/edit?');
		// return redirect()->back();
	}

	public function moveCppt($id, $reg_id)
	{
		$cppt = Emr::find($id);
		$reg = Registrasi::find($reg_id);
		if ($cppt) {
			$cppt->registrasi_id = $reg_id;
			$cppt->update();
		}

		Flashy::success('Berhasil memindahkan CPPT ke pendaftaran tanggal ' . date('d-m-Y H:i', strtotime(@$reg->created_at)));
		return redirect()->back();
	}

	public function saveGizi(Request $request)
	{
		// dd($request->all());
		LogUserController::log(Auth::user()->id, 'cppt',$request->registrasi_id);
		$create = new EmrGizi();
		$create->registrasi_id = $request->registrasi_id;
		$create->pasien_id = $request->pasien_id;
		$create->kamar_id = $request->kamar_id;
		$create->assesment = $request->assesment;
		$create->diagnosis = $request->diagnosis;
		$create->intervensi = $request->intervensi;
		$create->monitoring = $request->monitoring;
		$create->evaluasi = $request->evaluasi;
		if($request->tanggal){
			$create->created_at = @$request->tanggal.' '.date('H:m:s');
		}
		$create->user_id = Auth::user()->id;
		$create->save();

		Flashy::success('CPPT Gizi berhasil di input !');

		return redirect()->back();
	}
	// END SOAP GIZI

	//SOAP FARMASI
	public function soapFarmasi($unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		// dd("Maaf Sistem Sedang Di Maintenace");
		$data['registrasi_id']  = $registrasi_id;
		// dd($data['registrasi_id']);
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);


		$data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		$data['dokter'] 		= Pegawai::pluck('nama', 'id');
		$data['carabayar'] 		= Carabayar::all('carabayar', 'id');
		$data['tiket'] 			= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] 	= Aturanetiket::all('aturan', 'id');
		$data['takaran'] 		= TakaranobatEtiket::all('nama', 'nama');
		$data['all_resume']     = EmrFarmasi::where('pasien_id', @$data['reg']->pasien->id)->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrFarmasi::find($id_soap);
		$data['cppt']			= Emr::where('registrasi_id', $registrasi_id)->latest()->first();

		// dd($data['reg']);
		return view('emr.modules.soap_farmasi', $data);
	}

	public function updateSoapFarmasi(Request $request)
	{

		$create = EmrFarmasi::find($request->emr_id);
		if ($create) {
			$create->subjective = $request->subjective;
			$create->objective = $request->objective;
			$create->asesmen = $request->asesmen;
			$create->planning = $request->planning;
			$create->edukasi = $request->edukasi;
			$create->update();
		}
		Flashy::success('CPPT Faramasi berhasil di edit !');

		return redirect()->back();
	}

	public function soapFarmasiDelete($id)
	{

		$soap = EmrFarmasi::find($id);
		if ($soap) {
			$soap->delete();
		}
		Flashy::success('CPPT Farmasi berhasil di hapus !');

		return redirect()->back();
	}

	public function duplicateSoapFarmasi($id, $reg_id)
	{
		LogUserController::log(Auth::user()->id, 'cppt',$reg_id);
		$find = EmrFarmasi::find($id);
		if ($find) {

			$create = new EmrFarmasi();
			$create->registrasi_id = $reg_id;
			$create->pasien_id = @$find->pasien_id;
			$create->subjective = $find->subjective;
			$create->objective = $find->objective;
			$create->asesmen = $find->asesmen;
			$create->planning = $find->planning;
			$create->edukasi = $find->edukasi;
			$create->user_id = Auth::user()->id;
			$create->save();
			Flashy::success('CPPT Farmasi berhasil di duplikat, silahkan mengedit data');
		}

		// KALAU REGISTRASI SEBELUMNYA SUDAH DIHAPUS MAKA AMBIL ID REGISTRASI YG SEKARANG
		$cek_reg = Registrasi::where('id', $find->registrasi_id)->first();
		if (!$cek_reg) {
			$find->registrasi_id = $reg_id;
		}

		return redirect('/emr/soap-farmasi/inap/' . $find->registrasi_id . '/' . $create->id . '/edit?');
		// return redirect()->back();
	}

	public function saveFarmasi(Request $request)
	{
		// dd($request->all());
		LogUserController::log(Auth::user()->id, 'cppt',$request->registrasi_id);
		$create = new EmrFarmasi();
		$create->registrasi_id = $request->registrasi_id;
		$create->pasien_id = $request->pasien_id;
		$create->subjective = $request->subjective;
		$create->objective = $request->objective;
		$create->asesmen = $request->asesmen;
		$create->planning = $request->planning;
		$create->edukasi = $request->edukasi;
		if($request->tanggal){
			$create->created_at = @$request->tanggal.' '.date('H:m:s');
		}
		$create->user_id = Auth::user()->id;
		$create->save();

		Flashy::success('CPPT Farmasi berhasil di input !');

		return redirect()->back();
	}
	// END SOAP FARMASI


	// ERESEP
	public function eresep($unit, $registrasi_id)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');

		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		// $data['resume']         = Emr::where('registrasi_id', $registrasi_id)->first();
		// $data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		// $data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		// $data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		$data['penjualan'] 		= Penjualan::leftJoin('resep_note', 'penjualans.id', '=', 'resep_note.penjualan_id')->where('penjualans.registrasi_id', $registrasi_id)->orderBy('penjualans.id', 'DESC')->get();
		$data['eresep_belum_diproses']		= ResepNote::where('pasien_id', $data['reg']->pasien_id)->where('registrasi_id', $data['reg']->id)->where('proses', 'belum_diproses')->where('is_done_input', '1')->get();
		$data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		// $data['all_resume']     = Emr::where('registrasi_id', $registrasi_id)->get();
		$smf = Auth::user()->pegawai->smf ?? null;
		$data['template'] = ResepNoteDuplicate::with('user.pegawai')
			->whereHas('user.pegawai', function ($query) use ($smf) {
				$query->where('smf', $smf);
			})
			->where('pasien_id', $data['reg']->pasien_id)
			->limit(10)
			->orderBy('created_at', 'desc')
			->get();

		// $data['template_umum']	= ResepNoteDuplicate::where('is_umum', 'Y')->orderBy('created_at', 'desc')->get();
		//dd($data['template']);
		$data['template2']	= ResepNoteDuplicate::where('created_by', Auth::user()->id)
			->select('id', 'nama_racikan', 'created_by')
			->get();
		//dd($data['template2']);
		return view('emr.modules.eresep', $data);
	}
	// ERESEP RACIKAN
	public function eresepRacikan($unit, $registrasi_id)
	{
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		// $data['resume']         = Emr::where('registrasi_id', $registrasi_id)->first();
		// $data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		// $data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		// $data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();

		$data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		// $data['all_resume']     = Emr::where('registrasi_id', $registrasi_id)->get();

		// $data['template']	= ResepNoteDuplicate::
		// 	leftJoin('registrasis', 'resep_note_duplicate.registrasi_id', '=', 'registrasis.id')
		// 	// ->where('resep_note_duplicate.pasien_id', $data['reg']->pasien_id)
		// 	->where('registrasis.poli_id', $data['reg']->poli_id)
		// 	->select('resep_note_duplicate.id','resep_note_duplicate.nama_racikan','resep_note_duplicate.created_by')
		// 	->get();
		$data['template']	= ResepNoteDuplicate::where('created_by', Auth::user()->id)
			->select('id', 'nama_racikan', 'created_by')
			->get();

		return view('emr.modules.eresep_racikan', $data);
	}

	// ERESEP
	public function editEresep(Request $request, $unit, $registrasi_id, $uuid)
	{
		$data['registrasi_id']  = $registrasi_id;
		$data['uuid']  			= $uuid;
		$resep = ResepNote::where('uuid', $uuid)->first();
		$data['show'] 			= 	ResepNoteDetail::where('resep_note_id', $resep->id)->get();
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		// $data['resume']         = Emr::where('registrasi_id', $registrasi_id)->first();
		// $data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		// $data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		// $data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();

		$data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		$data['use_template'] = $request->use_template;
		// $data['all_resume']     = Emr::where('registrasi_id', $registrasi_id)->get();

		$data['template']	= ResepNoteDuplicate::where('pasien_id', $data['reg']->pasien_id)->get();

		return view('emr.modules.edit_eresep', $data);
	}

	public function cancelEresep(Request $request, $unit, $registrasi_id, $uuid)
	{
		$resep = ResepNote::where('uuid', $uuid)->first();

		if ($resep) {
			ResepNoteDetail::where('resep_note_id', $resep->id)->delete();
			$resep->delete();
		}
		return redirect('emr/eresep/' . $unit . '/' . $registrasi_id . '?poli=' . $request->poli . '&dpjp=' . $request->dpjp);
	}

	// END ERESEP
	public function useTemplateEresep(Request $request, $reg_id, $unit, $uuid)
	{
		//    dd($unit,$uuid);
		// dd($reg_id);
		$find = ResepNote::where('uuid', $uuid)->first();
		if(!$find){
			$find = ResepNoteDuplicate::where('uuid',$uuid)->first();
		}
		$reg = Registrasi::where('id', $reg_id)->first();
		$reg_last = Registrasi::where('pasien_id', $reg->pasien_id)->orderBy('id', 'DESC')->first();
		// dd($reg_last);
		if ($unit == 'jalan') {
			$uuid = 'ERJ' . date('YmdHis');
		} elseif ($unit == 'inap') {
			$uuid = 'ERI' . date('YmdHis');
		} elseif ($unit == 'igd') {
			$uuid = 'ERD' . date('YmdHis');
		}
		DB::beginTransaction();
		try {
			$data = [
				"uuid" => $uuid,
				"source" => $find->source,
				"nama_racikan" => $find->nama_racikan,
				"proses" => 'belum_diproses',
				"status" => NULL,
				'is_done_input' => '0',
				'is_validate' => '0',
				"registrasi_id" => $reg_id,
				"comment" => 'eresep_template',
				// "pasien_id" => $find->pasien_id
				"pasien_id" => $reg->pasien_id,
				"created_by" => Auth::user()->id,
			];
			$resep = ResepNote::create($data);
			$detail = ResepNoteDetail::where('resep_note_id', $find->id)->get();
			// dd($detail);
			foreach ($detail as $d) {
				// dd($d->logistik_batch->master_obat->id);
				$masterobat = Masterobat::where('id', $d->logistik_batch->masterobat_id)->whereNull('deleted_at')->first();

				if ($masterobat) {
					$batch = \App\LogistikBatch::where('masterobat_id', $d->logistik_batch->master_obat->id)
						->where('stok', '>', '0')
						->where('gudang_id', '3')
						->whereNull('deleted_at')
						->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')
						->first();
					if (!$batch) {
						$batch = \App\LogistikBatch::where('id', $d->logistik_batch_id)->whereNull('deleted_at')->first();
						if(!$batch){
							$batch = \App\LogistikBatch::where('masterobat_id', $d->logistik_batch->master_obat->id)
						// ->where('stok', '>', '0')
						->where('gudang_id', '3')
						// ->whereNull('deleted_at')
						->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')
						->withTrashed()
						->first();
						}
					}

					if ($batch) {
						$obat = [
							"resep_note_id" => $resep->id,
							"logistik_batch_id" => $batch->id,
							"qty" => $d->qty,
							"cara_bayar" => $d->cara_bayar,
							"tiket" => $d->tiket,
							"cara_minum" => $d->cara_minum,
							"takaran" => $d->takaran,
							"informasi" => $d->informasi,
						];
						// dd($obat);
						ResepNoteDetail::create($obat);
					}
				}
			}
			DB::commit();
			Flashy::success('Berhasil menggunakan template eresep silahkan edit obat, jika ada obat yang tidak masuk, mohon tambahkan obat secara manual');
			return redirect('emr/eresep/edit-template/' . $resep->source . '/' . $resep->registrasi_id . '/' . $resep->uuid . '?poli=' . $request->poli . '&dpjp=' . $request->dpjp . '&use_template=' . $request->use_template);
		} catch (Exception $e) {
			DB::rollback();

			Flashy::success('Gagal duplicate template');
			return redirect()->back();
		}
	}
	public function useTemplateEresepDelete($id)
	{
		$data = ResepNoteDuplicate::find($id);
		$data->delete();
		Flashy::success('Berhasil hapus template');
		return redirect()->back();
	}
	public function useTemplateEresepShare($id)
	{
		$data = ResepNoteDuplicate::find($id);
		$data->is_umum = 'Y';
		$data->save();
		Flashy::success('Berhasil share template');
		return redirect()->back();
	}

	public function rad($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'R'])
			->get();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->get();
		$data['reg'] = Registrasi::find($reg_id);
		$data['dokter'] = Pegawai::whereIn('id', ['20', '31', '43'])->get();
		$data['perawat'] = Pegawai::where('poli_type', 'R')->pluck('nama', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		
		if($unit == 'jalan'){
			if ($data['reg']->poli_id == 3 || $data['reg']->poli_id == 4 || $data['reg']->poli_id == 34 || $data['reg']->poli_id == 38 ||$data['reg']->poli_id == 47) {
				$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.kategoriheader_id', 13)
				->where('kategoritarifs.namatarif', 'DIGITAL RADIOLOGI')
				->where('tarifs.jenis', '=', baca_jenis_unit($unit))
				->where('tarifs.total', '<>', 0)
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->orderBy('nama', 'ASC')
				->get();

				$data['dokter_radiologi_gigi'] = 43;
	
				$data['opt_poli'] = Poli::where('politype', 'R')->where('kelompok', 'RADO')->get();
				
			}else if ($data['reg']->poli_id == 42) { //Klinik Eksekutif

				$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				// ->where('tarifs.kategoriheader_id', 4)
				->where('tarifs.kategoritarif_id', 208) //kategori tarif Radiologi Eksekutif
				->where('tarifs.jenis', '=', baca_jenis_unit($unit))
				->where('tarifs.total', '<>', 0)
				->where('tarifs.is_aktif', 'Y')
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->orderBy('nama', 'ASC')
				->get();
	
				$data['opt_poli'] = Poli::where('politype', 'R')->where('kelompok', 'RDO')->get();
				
			} else {
				
				$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.kategoriheader_id', 4)
				->where('kategoritarifs.namatarif', 'DIGITAL RADIOLOGI')
				->where('tarifs.jenis', '=', baca_jenis_unit($unit))
				->where('tarifs.total', '<>', 0)
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->orderBy('nama', 'ASC')
				->get();
	
				$data['opt_poli'] = Poli::where('politype', 'R')->where('kelompok', 'RDO')->get();
			}

		}else{
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				// ->where('tarifs.kategoriheader_id', 4)
				->where('kategoritarifs.namatarif', 'DIGITAL RADIOLOGI')
				->where('tarifs.jenis', '=', baca_jenis_unit($unit))
				->where('tarifs.total', '<>', 0)
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->orderBy('nama', 'ASC')
				->get();

			$data['opt_poli'] = Poli::where('politype', 'R')->get();
		}

		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['order'] = Orderradiologi::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();
		// dd("right");
		// dd($data['dokter']);
		return view('emr.modules.radiologi', $data)->with('no', 1);
	}
	public function ris($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::find($reg_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->sum('total');
		// $data['section'] = Labsection::all();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->whereNotNull('general_code')->pluck('nama', 'id');
		// $data['hasillabs'] = Hasillab::where('pasien_id', $data['reg']->pasien_id)->get();
		// $data['labsection'] = MasterLicas::orderby('name')->get();
		$data['rad'] = Poli::where('bpjs', codePoliRadiologi())->first();
		$array_perawat = explode(',', $data['rad']->perawat_id);
		$data['perawat'] = Pegawai::whereIn('id', $array_perawat)->pluck('nama', 'id');
		// dd("right");
		return view('emr.modules.ris', $data)->with('no', 1);
	}

	public function lab($unit, $reg_id)
	{

		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::find($reg_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->sum('total');
		// $data['section'] = Labsection::all();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->whereNotNull('general_code')->pluck('nama', 'id');
		$dokters = Pegawai::where('kategori_pegawai', 1)->whereNotNull('general_code')->pluck('user_id');
		$data['folioLabs']  = Folio::whereIn('user_id', $dokters)->where('pasien_id', $data['reg']->pasien_id)->where('poli_tipe', 'L')->orderBy('created_at', 'DESC')->get();
		$data['ruangan_inap'] = '';
		$data['kelompok'] = '';
		if ($unit == 'inap') {
			if (@$data['reg']->rawat_inap->kelompokkelas_id != null) {
				$data['ruangan_inap'] = @Kelompokkelas::where('id', @$data['reg']->rawat_inap->kelompokkelas_id)->first()->general_code;
			} else {
				$data['ruangan_inap'] = null;
			}
			$data['kelompok'] = @Kelompokkelas::where('id', @$data['reg']->rawat_inap->kelompokkelas_id)->first()->kelompok;
		}
		// dd($data['ruangan_inap']);
		// dd($data['ruangan']->kelompokkelas_id);
		// dd($data['hasillabs']);
		// if(session('lab_id'))
		// {
		//   $data['rincian'] = RincianHasillab::where('hasillab_id', session('lab_id'))->get();
		//   $data['no'] = 1;
		// }
		// $data['lab'] = Hasillab::where('id', $labid)->first();
		// $data['labsection'] = MasterLicas::orderby('name')->get();
		$data['labsection']  = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
		->where('tarifs.kategoriheader_id', 3)
		->where('tarifs.kategoritarif_id', '!=', 188)
		->where('tarifs.urutan_lab', '!=',NULL)
		->orderBy('tarifs.urutan_lab', 'ASC')
		->orderBy('tarifs.nama', 'ASC')
		->where('tarifs.jenis', '=', baca_jenis_unit($unit))
		->where('tarifs.total', '<>', 0)
		// ->select('tarifs.urutan_lab','tarifs.nama','tarifs.id')
		->select('tarifs.*', 'kategoritarifs.namatarif')
		->get()
		->unique('nama');
		
		$data['labsection2']  = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
		->where('tarifs.kategoriheader_id', 3)
		->where('tarifs.kategoritarif_id', '!=', 188)
		->where('tarifs.urutan_lab',NULL)
		->orderBy('tarifs.nama', 'ASC')
		->where('tarifs.jenis', '=', baca_jenis_unit($unit))
		->where('tarifs.total', '<>', 0)
		// ->select('tarifs.urutan_lab','tarifs.nama','tarifs.id')
		->select('tarifs.*', 'kategoritarifs.namatarif')
		->get()
		->unique('nama');

		// $daa = [];
		// foreach($data['labsection'] as $da){
		// 	$daa[]=[
		// 		'urutan' =>$da->urutan_lab
		// 	];
		// }
		// dd($daa);
		// $data['labsection'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
		// 	->where('tarifs.kategoriheader_id', 3)
		// 	->where('tarifs.kategoritarif_id', '!=', 188)
		// 	->where('tarifs.jenis', '=', baca_jenis_unit($unit))
		// 	->where('tarifs.total', '<>', 0)
		// 	// ->select('tarifs.*', 'kategoritarifs.namatarif')
		// 	// ->groupBy('tarifs.nama')
		// 	->whereRaw('tarifs.id IN (select MAX(id) FROM tarifs GROUP BY nama)')
		// 	->orderBy('tarifs.urutan_lab','ASC')
		// 	// ->orderBy('tarifs.nama','ASC')
		// 	->get();

		// dd($data['labsection']);

		return view('emr.modules.laboratorium', $data)->with('no', 1);
	}
	public function labPaket($unit, $reg_id)
	{

		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::find($reg_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->sum('total');
		// $data['section'] = Labsection::all();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->whereNotNull('general_code')->pluck('nama', 'id');
		$data['hasillabs'] = Hasillab::where('pasien_id', $data['reg']->pasien_id)->get();
		$data['ruangan_inap'] = '';
		$data['kelompok'] = '';
		if ($unit == 'inap') {
			$data['ruangan_inap'] = Kelompokkelas::where('id', @$data['reg']->rawat_inap->kelompokkelas_id)->first()->general_code;
			$data['kelompok'] = Kelompokkelas::where('id', @$data['reg']->rawat_inap->kelompokkelas_id)->first()->kelompok;
		}
		// dd($data['ruangan_inap']);
		// dd($data['ruangan']->kelompokkelas_id);
		// dd($data['hasillabs']);
		// if(session('lab_id'))
		// {
		//   $data['rincian'] = RincianHasillab::where('hasillab_id', session('lab_id'))->get();
		//   $data['no'] = 1;
		// }
		// $data['lab'] = Hasillab::where('id', $labid)->first();
		$data['labsection'] = MasterLicasPaket::whereNotNull('general_code')->orderby('name')->get();


		return view('emr.modules.laboratorium_paket', $data)->with('no', 1);
	}

	public function cetakLis($no_ref, $registrasi_id)
	{
		$data['registrasi'] = Registrasi::find($registrasi_id);
		if ($data['registrasi']->pasien_id == 0) {
			$data['registrasi']->pasien = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		}
		// $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
		$data['hasillab'] = Hasillab::where('no_lab', $no_ref)->first();
		$data_lis = LisResult::where('no_ref', $no_ref)->first();
		$level_keys = array();
		foreach (json_decode($data_lis->json, true)['hasil'] as $k => $sub_array) {
			$this_level = $sub_array['group_name'];
			$level_keys[$this_level][$k] = $sub_array;
		}
		$data['lis'] = $level_keys;
		// dd($data['lis']);
		// dd(json_decode($data['lis']->json,true));
		$pdf = PDF::loadView('emr._cetak_lab', $data);
		return $pdf->stream();
	}
	public function cetakLisPdf(Request $request, $id_lis, $registrasi_id)
	{
		$data['reg'] 	= Registrasi::find($registrasi_id);
		$data['lab'] 	= Hasillab::where('no_lab', $id_lis)->whereNotNull('order_lab_id')->first();
		$data['folios'] = Folio::where('registrasi_id',$registrasi_id)->where('order_lab_id', @$data['lab']->order_lab_id)->first();

		if (empty($data['lab'])) {
			Flashy::error('Tidak ditemukan hasil lab pada nomor lab ' . $id_lis);
			return redirect()->back();
		}
		

		// Jika dokumen sudah ber TTE, kembalikan pdf ber TTE
		if (!empty(json_decode(@$data['lab']->tte)->base64_signed_file) && $request->method() == 'GET') {
			$base64 = json_decode(@$data['lab']->tte)->base64_signed_file;

			$pdfContent = base64_decode($base64);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
			]);
		}

		// Jika dokumen belum ber TTE
		$licaResult = LicaResult::where('no_lab', $id_lis)->first();
		$hasil = '';
		$level_keys = array();
		$data['pemeriksa'] = @$licaResult['pemeriksa'];
		$data['keterangan'] = @$licaResult['keterangan'];
		if ($licaResult) {
			$hasil = json_decode($licaResult->json);

			// Ordering by sequence
			$dataHasil = collect($hasil);
			$sortedData = $dataHasil->sortBy('sequence')->values();

			// Grouping by group test
			foreach ($sortedData as $k => $sub_array) {
			  $this_level = @$sub_array->group_name ?? @$sub_array->group_test;
			  $level_keys[$this_level][$k] = $sub_array;
			}

			$data['hasillab'] = $level_keys;
			$data['response'] = (object) ["no_ref" => $id_lis, "tgl_kirim" => $licaResult->tgl_pemeriksaan];

		} else {
			Flashy::error('Hasil dari LIS belum muncul, coba beberapa saat lagi');  
      		return redirect()->back();

			
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "172.168.1.97/lica-soreang/public/api/get_result/" . $id_lis, // your preferred link
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_TIMEOUT => 30000,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					// Set Here Your Requesred Headers
					'x-api-key: licaapi',
				),
			));
			$response = curl_exec($curl);
			if (!isset(json_decode($response)->hasil)) {
				Flashy::error('Hasil dari LIS belum muncul, coba beberapa saat lagi');
				return redirect()->back();
			}
			$err = curl_error($curl);
			curl_close($curl);
			$data['response'] = '';
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				$data['response'] = json_decode($response);
				$hasil = $data['response']->hasil;

				// Ordering by sequence
				$dataHasil = collect($hasil);
				$sortedData = $dataHasil->sortBy('sequence')->values();
			}

			// Grouping by group test
			foreach ($sortedData as $k => $sub_array) {
				$this_level = $sub_array->group_test;
				$level_keys[$this_level][$k] = $sub_array;
			}

			$data['hasillab'] = $level_keys;
		}

		// if ($data['analis']) {
		// 	$data['qrcode'] = base64_encode(QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($data['analis']->nama . ' | ' . $data['analis']->nip));
		// }

		// Jika method POST dan proses TTE
		if ($request->method() == 'POST') {
			if ($request->proses_tte) {
				if (tte()) {
					$data['proses_tte'] = true;
					$pdf = PDF::loadView('emr._cetak_lab_lis', $data);
					$pdfContent = $pdf->output();
					// Create temp pdf file
					$filePath = uniqId() . '-hasil_lab.pdf';
					File::put(public_path($filePath), $pdfContent);
					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);
					$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

					log_esign($data['reg']->id, $tte->response, "hasil-lab", $tte->httpStatusCode);

					$resp = json_decode($tte->response);

					if ($tte->httpStatusCode == 200) {
						$data['lab']->tte = $tte->response;
						$data['lab']->update();
						return response()->json(['sukses' => true, 'message' => 'Berhasil melakukan tandatangan!']);
					} elseif ($tte->httpStatusCode == 400) {
						if (isset($resp->error)) {
							return response()->json(['sukses' => false, 'message' => $resp->error]);
						}
					} elseif ($tte->httpStatusCode == 500) {
						Flashy::error($tte->response);
						return redirect()->back();
					}

					return response()->json(['sukses' => false, 'message' => 'Gagal melakukan tandatangan!']);
				} else {
					$data['tte_nonaktif'] = true;
					$pdf = PDF::loadView('emr._cetak_lab_lis', $data);
					$pdfContent = $pdf->output();
					$data['lab']->tte = json_encode((object) [
						"base64_signed_file" => base64_encode($pdfContent),
					]);
					$data['lab']->update();
					return response()->json(['sukses' => true, 'message' => 'Berhasil menandatangani dokumen !']);
				}
			}
		}

		// Jika dokumen belum ber TTE
		$pdf = PDF::loadView('emr._cetak_lab_lis', $data);
		return $pdf->stream();
	}

	public function cetakLisAllPdf(Request $request, $registrasi_id)
	{
		$data['reg'] 	= Registrasi::find($registrasi_id);
		// $data['labs_all'] 	= Hasillab::where('registrasi_id', $registrasi_id)->whereNotNull('order_lab_id')->get();
		$data['labs_all'] = Hasillab::select('id', 'registrasi_id', 'order_lab_id', 'no_lab')
		->where('registrasi_id', $registrasi_id)
		->whereNotNull('order_lab_id')
		->get();

		if (empty($data['labs_all'])) {
			Flashy::error('Tidak ditemukan hasil lab');
			return redirect()->back();
		}

		foreach ($data['labs_all'] as $lab) {
			$lab->folio = Folio::where('registrasi_id',$lab->registrasi_id)->where('order_lab_id', $lab->order_lab_id)->first();

			$licaResult = LicaResult::where('no_lab', $lab->no_lab)->first();
			$hasil = '';
			$level_keys = array();
			
			if ($licaResult) {
				$hasil = json_decode($licaResult->json);
	
				// Ordering by sequence
				$dataHasil = collect($hasil);
				$sortedData = $dataHasil->sortBy('sequence')->values();
	
				// Grouping by group test
				foreach ($sortedData as $k => $sub_array) {
				  $this_level = @$sub_array->group_name ?? @$sub_array->group_test;
				  $level_keys[$this_level][$k] = $sub_array;
				}
	
				$lab->hasillab = $level_keys;
				$lab->response = (object) ["no_ref" => $lab->no_lab, "tgl_kirim" => $licaResult->tgl_pemeriksaan];
	
			} else {
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "172.168.1.97/lica-soreang/public/api/get_result/" . $lab->no_lab, // your preferred link
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_TIMEOUT => 30000,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => array(
						// Set Here Your Requesred Headers
						'x-api-key: licaapi',
					),
				));
				$response = curl_exec($curl);
				if (isset(json_decode($response)->hasil)) {
					$err = curl_error($curl);
					curl_close($curl);
					$lab->response = '';
					if ($err) {
						echo "cURL Error #:" . $err;
					} else {
						$lab->response = json_decode($response);
						$hasil = $lab->response->hasil;
		
						// Ordering by sequence
						$dataHasil = collect($hasil);
						$sortedData = $dataHasil->sortBy('sequence')->values();
					}
		
					// Grouping by group test
					foreach ($sortedData as $k => $sub_array) {
						$this_level = $sub_array->group_test;
						$level_keys[$this_level][$k] = $sub_array;
					}
		
					$lab->hasillab = $level_keys;
				}
			}
		}

		$pdf = PDF::loadView('emr._cetak_lab_lis_all', $data);
		return $pdf->stream();
	}

	public function orderPoli($unit, $reg_id)
	{
		$data['reg'] 			= Registrasi::where('id', $reg_id)->first();
		$data['poli']			= Poli::where('politype', '!=', 'G')->get();
		$data['pasien']			= Pasien::find($data['reg']->pasien->id);
		$data['registrasi_id']	= $reg_id;
		$data['dokter']			= Pegawai::where('kategori_pegawai', 1)->get();

		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'L'])
			->get();
		$folio = Folio::where('registrasi_id', $reg_id)->get(['tarif_id']);
		foreach ($folio as $key) {
			$data['select'][] = $key['tarif_id'];
		}
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::pluck('nama', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'L')->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'L')->get();

		$data['tarif'] = Tarif::where('jenis', baca_jenis_unit($unit))->get(['id', 'nama']);
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', baca_jenis_unit($unit))->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['order'] = Orderlab::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();

		return view('emr.modules.orderPoli', $data)->with('no', 1);
	}

	public function labPatalogiAnatomi($unit, $reg_id)
	{

		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::find($reg_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->sum('total');
		// $data['section'] = Labsection::all();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->whereNotNull('general_code')->pluck('nama', 'id');
		$data['hasillabs'] = Hasillab::leftJoin('order_lab', 'order_lab.id', '=', 'hasillabs.order_lab_id')
			->leftJoin('folios', 'folios.order_lab_id', '=', 'order_lab.id')
			->where('hasillabs.registrasi_id', $reg_id)
			->whereNotNull('folios.diagnosa')
			->select('hasillabs.*', 'folios.diagnosa')
			->get();
		// dd( $data['orderlab']);
		$data['ruangan_inap'] = '';
		$data['kelompok'] = '';
		if ($unit == 'inap') {
			if (@$data['reg']->rawat_inap->kelompokkelas_id != null) {
				$data['ruangan_inap'] = Kelompokkelas::where('id', @$data['reg']->rawat_inap->kelompokkelas_id)->first()->general_code;
			} else {
				$data['ruangan_inap'] = null;
			}
			$data['kelompok'] = Kelompokkelas::where('id', @$data['reg']->rawat_inap->kelompokkelas_id)->first()->kelompok;
		}

		$data['labsection'] = Tarif::where('kategoriheader_id', 10)
			->where('is_aktif', 'Y')
			->where('jenis', baca_jenis_unit($unit))
			->where('total', '<>', 0)
			->get();



		return view('emr.modules.labPatalogiAnatomi', $data)->with('no', 1);
	}

	public function getTindakanPA($katTarif, $unit)
	{
		$tarif = Tarif::where('kategoritarif_id', $katTarif)
			->where('jenis', baca_jenis_unit($unit))
			->where('total', '<>', 0)
			->get();

		$data = [];

		$data[0] = [
			'metadata' => [
					'code' => 200
			]
		];

		foreach($tarif as $t){
			$data[1][] = [
				'id' => $t->id,
 				'nama' => $t->nama,
				'total' => $t->total
			];
		}

		return response()->json($data);
	}

	public function saveTindakan(Request $request)
	{
		request()->validate(['tarif_id' => 'required']);
		// dd($request->all());
		LogUserController::log(Auth::user()->id, 'billing',$request['registrasi_id']);
		//Multi Insert
		$reg    = Registrasi::find($request['registrasi_id']);
		foreach ($request['tarif_id'] as $i) {

			$kode   = $i;
			$tarif  = Tarif::where('id', $kode)->first();
			// $catatan = $request['keterangan'][$tarif->id];
			// dd($request['keterangan'][$tarif->id]);
			$cyto = 0;
			if($request['cito'][$tarif->id]){
				if($reg->poli->kelompok == 'ESO'){ // Jika Poli Eksekutif
					$cyto = ($tarif->total * 30) / 100;
				}else{
					$cyto = $tarif->total / 2;
				}
			}

			if (isset($request['page'])) {
				if ($request['page'] == 'labJalan' || $request['page'] == 'labIgd' || $request['page'] == 'labInap') {
					$poli_tipe = 'L';

					//Update Baru
					$dateNow = date('Y-m-d');
					$cekAntrianRegistrasi = AntrianLaboratorium::where('registrasi_id', $reg->id)->whereDate('tanggal', $dateNow)->first();

					if(!$cekAntrianRegistrasi){
						$cekAntrian = AntrianLaboratorium::whereDate('tanggal', $dateNow)->max('nomor');

						if ($cekAntrian !== null) {
								$nomorurut = $cekAntrian + 1;
						} else {
								$nomorurut = '001';
						}

						$nomorAntrian = $nomorurut;

						$antrianLab = new AntrianLaboratorium();
						$antrianLab->registrasi_id = $reg->id;
						$antrianLab->nomor = $nomorAntrian;
						$antrianLab->tanggal = $dateNow;
						$antrianLab->save();
					}

					    // Untuk notifikasi
						$notif  = ServiceNotif::where('registrasi_id', $reg->id)->where('service', 'laboratorium')->first();
						if($notif  == null){
							$notif  = new ServiceNotif();
							$notif->registrasi_id   = $reg->id;
							$notif->service         = 'laboratorium';
						}
						$notif->is_muted        = 'N';
						$notif->is_done         = 'N';
						$notif->updated_at      = now(); //jangan dihapus
						$notif->save();

				} else if ($request['page'] == 'radJalan' || $request['page'] == 'radIgd' || $request['page'] == 'radInap') {
					$poli_tipe = 'R';

					//Update Baru
					$dateNow = date('Y-m-d');
					$cekAntrianRegistrasi = AntrianRadiologi::where('registrasi_id', $reg->id)->whereDate('tanggal', $dateNow)->first();

					if(!$cekAntrianRegistrasi){
						$cekAntrian = AntrianRadiologi::whereDate('tanggal', $dateNow)->max('nomor');

						if ($cekAntrian !== null) {
								$nomorurut = $cekAntrian + 1;
						} else {
								$nomorurut = '001';
						}

						$nomorAntrian = $nomorurut;

						$antrianRad = new AntrianRadiologi();
						$antrianRad->registrasi_id = $reg->id;
						$antrianRad->nomor = $nomorAntrian;
						$antrianRad->tanggal = $dateNow;
						$antrianRad->save();
					}

					    // Untuk notifikasi
						$notif  = ServiceNotif::where('registrasi_id', $reg->id)->where('service', 'radiologi')->first();
						if($notif  == null){
							$notif  = new ServiceNotif();
							$notif->registrasi_id   = $reg->id;
							$notif->service         = 'radiologi';
						}
						$notif->is_muted        = 'N';
						$notif->is_done         = 'N';
						$notif->updated_at      = now(); //jangan dihapus
						$notif->save();
				}
			} else {
				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
					$poli_tipe = 'G';
				} else {
					$poli_tipe = 'J';
				}
			}

			if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
				$pelaksana_tipe = 'TG';
			} else {
				$pelaksana_tipe = 'TA';
			}

			if (!empty($request['tanggal'])) {
				$created_at = valid_date($request['tanggal']) . ' ' . date('H:i:s');
			}
			$insertData = [
				'registrasi_id'    => $request['registrasi_id'],
				// 'poli_id'          => $poli_tipe == 'R' ? 1 : $request['poli_id'],
				'poli_id'          => $request['poli_id'],
				'lunas'            => 'N',
				'namatarif'        => $tarif->nama,
				'dijamin'          => $request['dijamin'],
				'tarif_id'         => $tarif->id,
				'cara_bayar_id'    => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
				'status_puasa'     => $request['status_puasa'],
				'mulai_puasa'      => $request['mulai_puasa'],
				'selesai_puasa'    => $request['selesai_puasa'],
				'jenis'            => $tarif->jenis,
				'poli_tipe'        => $poli_tipe,
				'total'            => ($tarif->total + $cyto) * $request['jumlah'],
				'jenis_pasien'     => $request['jenis'],
				'pasien_id'        => $request['pasien_id'],
				'verif_kasa_user'  => 'tarif_new',
				'harus_bayar'      => @$request['jumlah'],
				'dokter_id'        => $request['dokter_id'],
				'user_id'          => Auth::user()->id,
				'mapping_biaya_id' => $tarif->mapping_biaya_id,
				'dpjp'             => $request['dokter_id'],
				'dokter_pelaksana' => $request['pelaksana'],
				'diagnosa'         => $request['keterangan'][$tarif->id],
				'cyto'             => $request['cito'][$tarif->id] ?? null,
				'dokter_radiologi' => $request['dokter_radiologi'],
				'perawat'          => $request['perawat'],
				'pelaksana_tipe'   => $pelaksana_tipe,
				'created_at'       => $created_at
			];
			// dd($insertData);

			$folio = FolioMulti::create($insertData);

			if (satusehat()) {
				$id_puasa = null;
				

				if (Satusehat::find(18)->aktif) {
					$id_puasa = SatuSehatController::ProcedurePuasaRadiologiPost($folio->registrasi_id, $folio->id);
				}
				if (Satusehat::find(19)->aktif) {
					$id_kehamilan = SatuSehatController::ObservationPostKehamilanRad($folio->registrasi_id, $folio->id);
				}
				if (Satusehat::find(20)->aktif) {
					$id_alergi = SatuSehatController::ObservationPostAlergiRad($folio->registrasi_id, $folio->id);
				}

				$folio->update([
					'id_observation_ss' => json_encode([
						'puasa' => $id_puasa,
						'kehamilan' => $id_kehamilan,
						'alergi' => $id_alergi
						])
				]);
			}
		}

		// $reg = Registrasi::find($request['registrasi_id']);
		// $tarif = Tarif::find($request['tarif_id']);
		// $fol = new Folio();
		// $fol->registrasi_id = $request['registrasi_id'];
		// $fol->poli_id = $request['poli_id'];
		// $fol->lunas = 'N';
		// $fol->namatarif = $tarif->nama;
		// $fol->dijamin = $request['dijamin'];
		// $fol->tarif_id = $request['tarif_id'];
		// $fol->cara_bayar_id = (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar;
		// $fol->jenis = $tarif->jenis;
		// if (isset($request['page'])) {
		// 	if ($request['page'] == 'labJalan' || $request['page'] == 'labIgd' || $request['page'] == 'labInap') {
		// 		$fol->poli_tipe = 'L';
		// 	} else if ($request['page'] == 'radJalan' || $request['page'] == 'radIgd' || $request['page'] == 'radInap') {
		// 		$fol->poli_tipe = 'R';
		// 	}
		// } else {
		// 	if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
		// 		$fol->poli_tipe = 'G';
		// 	} else {
		// 		$fol->poli_tipe = 'J';
		// 	}
		// }
		// $fol->total = ($tarif->total * $request['jumlah']);
		// $fol->jenis_pasien = $request['jenis'];
		// $fol->pasien_id = $request['pasien_id'];
		// $fol->dokter_id = $request['dokter_id'];
		// $fol->user_id = Auth::user()->id;
		// $fol->poli_id = $request['poli_id'];
		// if (!empty($request['tanggal'])) {
		// 	$fol->created_at = valid_date($request['tanggal']) . ' ' . date('H:i:s');
		// }
		// $fol->mapping_biaya_id = $tarif->mapping_biaya_id;

		// //revisi foliopelaksana
		// $fol->dpjp = $request['dokter_id'];
		// $fol->dokter_pelaksana = $request['pelaksana'];
		// $fol->perawat = $request['perawat'];
		// if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
		// 	$fol->pelaksana_tipe = 'TG';
		// } else {
		// 	$fol->pelaksana_tipe = 'TA';
		// }
		// $fol->save();

		// Insert Kunjungan IRJ
		if ($poli_tipe == 'J') {
			$cek = HistorikunjunganIRJ::where('registrasi_id', $request['registrasi_id'])->where('poli_id', $request['poli_id'])->count();
			if ($cek < 1) {
				$rj = new HistorikunjunganIRJ();
				$rj->registrasi_id = $request['registrasi_id'];
				$rj->pasien_id = $request['pasien_id'];
				$rj->poli_id = $request['poli_id'];
				$rj->dokter_id = @$request['dokter_id'];
				$rj->user = Auth::user()->id;
				$rj->save();
			}
		}

		// Insert Kunjungan IRD
		if ($poli_tipe == 'G') {
			$cek = HistorikunjunganIGD::where('registrasi_id', $request['registrasi_id'])->where('triage_nama', baca_poli($request['poli_id']))->count();
			if ($cek < 1) {
				$rj = new HistorikunjunganIGD();
				$rj->registrasi_id = $request['registrasi_id'];
				$rj->pasien_id = $request['pasien_id'];
				$rj->triage_nama = baca_poli($request['poli_id']);
				$rj->user = Auth::user()->id;
				$rj->save();
			}
		}

		// Insert Histori
		$history = new HistoriStatus();
		$history->registrasi_id = $request['registrasi_id'];
		if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
			$history->status = 'G2';
		} else if (substr($reg->status_reg, 0, 1) == 'J') {
			$history->status = 'J2';
		} else if (substr($reg->status_reg, 0, 1) == 'I') {
			$history->status = 'I2';
		}

		$history->poli_id = $request['poli_id'];
		$history->bed_id = null;
		$history->user_id = Auth::user()->id;
		$history->save();

		// CEK APAKAH ADA NOMORANTRIAN
		// if ($reg->nomorantrian) {
		// 	// JIKA ADA UPDATE TASKID 3
		// 	$ID = config('app.consid_antrean');
		// 	date_default_timezone_set('UTC');
		// 	$t = time();
		// 	$data = "$ID&$t";
		// 	$secretKey = config('app.secretkey_antrean');
		// 	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		// 	$completeurl = config('app.antrean_url_web_service') . "antrean/updatewaktu";
		// 	$arrheader = array(
		// 		'X-cons-id: ' . $ID,
		// 		'X-timestamp: ' . $t,
		// 		'X-signature: ' . $signature,
		// 		'user_key:' . config('app.user_key_antrean'),
		// 		'Content-Type: application/json',
		// 	);
		// 	$updatewaktu   = '{
		// 		"kodebooking": "' . $reg->nomorantrian . '",
		// 		"taskid": 4,
		// 		"waktu": "' . round(microtime(true) * 1000) . '"
		// 	 }';
		// 	$session2 = curl_init($completeurl);
		// 	curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
		// 	curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
		// 	curl_setopt($session2, CURLOPT_POST, TRUE);
		// 	curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
		// 	curl_exec($session2);
		// 	$resp = curl_exec($session2);
		// 	//  dd($resp);

		// }

		session()->forget('jenis');
		if (isset($request['page'])) {
			if ($request['page'] == 'labJalan') {
				return redirect('emr/lab/jalan/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radJalan') {
				return redirect()->back();
				// return redirect('emr/rad/jalan/' . $request['registrasi_id']);
			} else if ($request['page'] == 'labIgd') {
				return redirect('emr/lab/igd/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radIgd') {
				return redirect('emr/rad/igd/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radInap') {
				return redirect('emr/rad/inap/' . $request['registrasi_id']);
			} else if ($request['page'] == 'labInap') {
				return redirect('emr/lab/inap/' . $request['registrasi_id']);
			}
		} else {
			return redirect('tindakan/entry/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		}
	}

	public function saveRiwayat(Request $request)
	{
		// dd($request);




		DB::beginTransaction();
		try {

			$riwayat = EmrRiwayat::where('pasien_id', $request['pasien_id'])->first();
			if (!$riwayat) { //Jika Kosong maka buat data baru
				$riwayat = new EmrRiwayat();
			}

			$id_observation_ss = NULL;
			if (Satusehat::find(11)->aktif == 1) {
				if (satusehat()) {


					// API TOKEN
					$client_id = config('app.client_id');
					$client_secret = config('app.client_secret');
					// create code satusehat
					$urlcreatetoken = config('app.create_token');
					$curl_token = curl_init();

					curl_setopt_array($curl_token, array(
						CURLOPT_URL => $urlcreatetoken,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/x-www-form-urlencoded'
						),
					));

					$response_token = curl_exec($curl_token);
					$token = json_decode($response_token);
					$access_token = $token->access_token;
					// dd($access_token);
					curl_close($curl_token);
					// END OF API TOKEN
				}



				if (satusehat()) {
					// API CREATE OBSERVASI
					$url_create_observasi = config('app.create_observation');
					$id_dokter_ss = Pegawai::find(Registrasi::find($request['registrasi_id'])->dokter_id)->id_dokterss;
					$id_encounter_ss = Registrasi::find($request['registrasi_id'])->id_encounter_ss;
					$pasien_ss = Pasien::find($request['pasien_id'])->nama;
					$pasien_ss_id = Pasien::find($request['pasien_id'])->id_patient_ss;
					$time = date('H:i:s');
					$time_2 = date('H:i');
					$date = date('d F Y');
					$waktu = time();
					$today = date("Y-m-d", $waktu);


					if ($request['suhu_tubuh'] > 38) {
						$code = 'H';
						$code_disp = 'High';
					} elseif ($request['suhu_tubuh'] < 35) {
						$code = 'L';
						$code_disp = 'Low';
					} else {
						$code = 'N';
						$code_disp = 'Normal';
					}

					// dd($today);
					$curl_observation = curl_init();

					curl_setopt_array($curl_observation, array(
						CURLOPT_URL => $url_create_observasi,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => '{
					"resourceType": "Observation",
					"status": "final",
					"category": [
						{
							"coding": [
								{
									"system": "http://terminology.hl7.org/CodeSystem/observation-category",
									"code": "vital-signs",
									"display": "Vital Signs"
								}
							]
						}
					],
					"code": {
						"coding": [
							{
								"system": "http://loinc.org",
								"code": "8310-5",
								"display": "Body Temperature"
							}
						]
					},
					"subject": {
						"reference": "Patient/' . $pasien_ss_id . '"
					},
					"performer": [
						{
							"reference": "Practitioner/' . $id_dokter_ss . '"
						}
					],
					"encounter": {
						"reference": "Encounter/' . $id_encounter_ss . '",
						"display": "Pemeriksaan Suhu Tubuh ' . $pasien_ss . ' di tanggal ' . $today . '"
					},
					"effectiveDateTime": "' . $today . '",
					"issued": "' . $today . 'T' . $time . '+07:00",
					"valueQuantity": {
						"value": ' . $request['suhu_tubuh'] . ',
						"unit": "C",
						"system": "http://unitsofmeasure.org",
						"code": "Cel"
					},
					"interpretation": [
					{
					   "coding": [
						  {
							"system":
							"http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation",
							"code": "' . $code . '",
							"display": "' . $code_disp . '"
						  }
							],
							"text": "Tekanan Darah = ' . $request['tekanan_darah'] . ' Nadi = ' . $request['nadi'] . '"
						 } 
					  ]
				}',
						CURLOPT_HTTPHEADER => array(
							'Authorization: Bearer ' . $access_token . '',
							'Content-Type: application/json'
						),
					));

					$response_observasi = curl_exec($curl_observation);
					$id_observation = json_decode($response_observasi);
					if (!empty($id_observation->id)) {
						$id_observation_ss = $id_observation->id;
					} else {
						$id_observation_ss = NULL;
					}
					// dd($id_observation);
					curl_close($curl_observation);
					// END OF API CREATE OBSERVASI
				}
			}


			$riwayat->registrasi_id 		= $request['registrasi_id'];
			$riwayat->pasien_id 			= $request['pasien_id'];
			$riwayat->unit					= $request['unit'];
			$riwayat->tipe_anamnesis		= $request['tipe_anamnesis'];
			$riwayat->tipe_anamnesis_keterangan	= $request['tipe_anamnesis_keterangan'];
			$riwayat->keluhan_utama			= $request['keluhan_utama'];
			$riwayat->riwayat_penyakit_sekarang	= $request['riwayat_penyakit_sekarang'];
			$riwayat->riwayat_pengobatan	= $request['riwayat_pengobatan'];
			$riwayat->riwayat_medis_sebelumnya	= $request['riwayat_medis_sebelumnya'];
			$riwayat->riwayat_medis_sebelumnya_keterangan	= $request['riwayat_medis_sebelumnya_keterangan'];
			$riwayat->sejarah_bedah			= $request['sejarah_bedah'];
			$riwayat->tanda_vital			= $request['tanda_vital'];
			$riwayat->tekanan_darah			= $request['tekanan_darah'];
			$riwayat->id_observation_ss	    = @$id_observation_ss;
			$riwayat->suhu_tubuh			= $request['suhu_tubuh'];
			$riwayat->nadi					= $request['nadi'];
			$riwayat->user_id				= Auth::user()->id;
			$riwayat->updated_at 			= date('Y-m-d H:i:s'); //updated at
			$riwayat->save();

			// save Informasi Pasien =
			foreach ($request['informasi'] as $j) {
				if (isset($j['cek'])) {
					$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
						->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();
					// dd($kesehatan);
					if (!$kesehatan) {
						$kesehatan = new EmrRiwayatKesehatan();
					}
					$kesehatan->registrasi_id = @$request['registrasi_id'];
					$kesehatan->pasien_id = @$request['pasien_id'];
					$kesehatan->riwayat_id = @$riwayat->id;
					$kesehatan->checked = '1';
					$kesehatan->user_id = Auth::user()->id;
					$kesehatan->tipe = 'I';
					$kesehatan->riwayat_kesehatan_id = @$j['cek']; //master kesehatan id
					$kesehatan->keterangan = @$j['keterangan']; //keterangan
					$kesehatan->updated_at = date('Y-m-d H:i:s'); //updated at
					$kesehatan->save();
				} else {
					$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
						->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();;
					if ($kesehatan) {
						$kesehatan->checked = '0';
						$kesehatan->save();
					}
				}
			}
			//save Cara Masuk 
			foreach ($request['caramasuk'] as $j) {

				if (isset($j['cek'])) {
					$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
						->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();
					// dd($kesehatan);
					if (!$kesehatan) {
						$kesehatan = new EmrRiwayatKesehatan();
					}
					$kesehatan->registrasi_id = @$request['registrasi_id'];
					$kesehatan->pasien_id = @$request['pasien_id'];
					$kesehatan->riwayat_id = @$riwayat->id;
					$kesehatan->checked = '1';
					$kesehatan->user_id = Auth::user()->id;
					$kesehatan->tipe = 'CM';
					$kesehatan->riwayat_kesehatan_id = @$j['id']; //master kesehatan id
					$kesehatan->keterangan = @$j['keterangan']; //keterangan
					$kesehatan->updated_at = date('Y-m-d H:i:s'); //updated at
					$kesehatan->save();
				} else {
					$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
						->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();;
					if ($kesehatan) {
						$kesehatan->checked = '0';
						$kesehatan->save();
					}
				}
			}

			//  dd($request['asalmasuk']);
			foreach ($request['asalmasuk'] as $j) {
				// Kesehatan
				if (isset($j['cek'])) {
					$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
						->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();
					// dd($kesehatan);
					if (!$kesehatan) {
						$kesehatan = new EmrRiwayatKesehatan();
					}
					$kesehatan->registrasi_id = @$request['registrasi_id'];
					$kesehatan->pasien_id = @$request['pasien_id'];
					$kesehatan->riwayat_id = @$riwayat->id;
					$kesehatan->checked = '1';
					$kesehatan->user_id = Auth::user()->id;
					$kesehatan->tipe = 'AM';
					$kesehatan->riwayat_kesehatan_id = @$j['id']; //master kesehatan id
					$kesehatan->keterangan = @$j['keterangan']; //keterangan
					$kesehatan->updated_at = date('Y-m-d H:i:s'); //updated at
					$kesehatan->save();
				} else {
					$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
						->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();;
					if ($kesehatan) {
						$kesehatan->checked = '0';
						$kesehatan->save();
					}
				}
			}

			// dd($request['kesehatan']);
			if (isset($request['pemeriksaan'])) {
				foreach ($request['pemeriksaan'] as $j) {
					// Kesehatan
					// dd($request->all());
					if (isset($j['cek'])) {
						$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
							->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->where('tipe', 'K')->first();
						// dd($kesehatan);
						if (!$kesehatan) {
							$kesehatan = new EmrRiwayatKesehatan();
						}
						$kesehatan->registrasi_id = @$request['registrasi_id'];
						$kesehatan->pasien_id = @$request['pasien_id'];
						$kesehatan->riwayat_id = @$riwayat->id;
						$kesehatan->checked = '1';
						$kesehatan->user_id = Auth::user()->id;
						$kesehatan->tipe = 'K';
						$kesehatan->pemeriksaan = @$request['pemeriksaan'];
						// $kesehatan->riwayat_kesehatan_id = @$j['id']; //master kesehatan id
						// $kesehatan->keterangan = @$j['keterangan']; //keterangan
						$kesehatan->updated_at = date('Y-m-d H:i:s'); //updated at
						$kesehatan->save();
					} else {
						$kesehatan = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
							->where('riwayat_kesehatan_id', @$j['id'])->where('riwayat_id', $riwayat->id)->first();;
						if ($kesehatan) {
							$kesehatan->checked = '0';
							$kesehatan->save();
						}
					}
				}
			}

			// foreach ($request['alergi'] as $id => $j) {
			// 	// Kesehatan
			// 	if ($j['keterangan'] !== null) {
			// 		$alergi = EmrRiwayatKesehatan::where('pasien_id', $request['pasien_id'])
			// 			->where('riwayat_kesehatan_id', $id)->where('riwayat_id', $riwayat->id)->first();
			// 		if (!$alergi) {
			// 			$alergi = new EmrRiwayatKesehatan();
			// 		}
			// 		$alergi->registrasi_id = @$request['registrasi_id'];
			// 		$alergi->pasien_id = @$request['pasien_id'];
			// 		$alergi->riwayat_id = @$riwayat->id;
			// 		$alergi->tipe = 'A';
			// 		$alergi->riwayat_kesehatan_id = @$id; //master kesehatan id
			// 		$alergi->keterangan = @$j['keterangan']; //keterangan
			// 		$alergi->updated_at = date('Y-m-d H:i:s'); //keterangan
			// 		$alergi->save();
			// 	}
			// }
			DB::commit();
			Flashy::success('Riwayat berhasil disimpan');
			return redirect()->back();
		} catch (Exception $e) {
			DB::rollback();
			Flashy::error('Riwayat gagal disimpan, silahkan input ulang');
			return redirect()->back();
		}
	}

	public function pemeriksaanRad($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$pasien_id = Registrasi::find($reg_id)->pasien_id;
		// dd($pasien_id);
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$reg = Registrasi::where('pasien_id', $pasien_id)->get();
		$idregs = [];
		foreach ($reg as $r) {
			$idregs[] = $r->id;
		}
		// $data['rad']			= \App\RadiologiEkspertise::where('registrasi_id', $reg_id)->get();
		$data['rad']			= \App\RadiologiEkspertise::whereIn('registrasi_id', $idregs)->get();
		// $data['rad']			= PacsExpertise::where('no_rm',@$data['reg']->pasien->no_rm)->get();


		return view('emr.modules.pemeriksaan_radiologi', $data)->with('no', 1);
	}

	public function pemeriksaanPenunjang($unit, $reg_id)
	{
		$data['registrasi_id'] = $reg_id;
		$data['unit'] = $unit;
		$data['reg'] = Registrasi::find($reg_id);
		$pasien_id = $data['reg']->pasien_id;

		$data['penunjang'] = Emr::where('pasien_id', $pasien_id)
			->where(function ($query) {
				$query->whereNotNull('hasil_echo')
					->orWhereNotNull('hasil_ekg')
					->orWhereNotNull('hasil_eeg')
					->orWhereNotNull('hasil_usg')
					->orWhereNotNull('hasil_ctg')
					->orWhereNotNull('hasil_spirometri')
					->orWhereNotNull('hasil_lainnya');
			})
			->get();

		return view('emr.modules.pemeriksaan_penunjang', $data)->with('no', 1);
	}

	public function pemeriksaanLabPA($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		// $pasien_id = Registrasi::find($reg_id)->pasien_id;
		$data['reg'] = Registrasi::find($reg_id);
		$data['labPa']			= Hasillab::where('pasien_id', $data['reg']->pasien_id)->where('no_lab', 'LIKE', 'LABR%')->select(['id', 'no_lab', 'created_at'])->get();


		return view('emr.modules.pemeriksaan_lab_pa', $data)->with('no', 1);
	}

	public function pemeriksaanLaporanOperasi($unit, $reg_id)
	{
		$data['registrasi_id'] = $reg_id;
		$data['unit'] = $unit;
		$data['reg'] = Registrasi::find($reg_id);
		$pasien_id = $data['reg']->pasien_id;

		$data['laporan'] = EmrInapPemeriksaan::where('pasien_id', $pasien_id)->where('type', 'laporan-operasi')->select(['id', 'registrasi_id', 'created_at'])->get();
		$data['laporan_ranap'] = EmrInapPemeriksaan::where('pasien_id', $pasien_id)->where('type', 'laporan-operasi-ranap')->select(['id', 'registrasi_id', 'created_at'])->get();

		return view('emr.modules.pemeriksaan_laporan_operasi', $data)->with('no', 1);
	}

	public function cetakLaporanOperasi($unit, $registrasi_id, $id)
	{
		$data['unit'] = $unit;
		$data['smf'] = smf();
		$data['reg'] = Registrasi::findOrFail($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['laporan'] = EmrInapPemeriksaan::findOrFail($id);
		$data['asessment'] = json_decode($data['laporan']->fisik, true);

		$pdf = Pdf::loadView('emr.modules.pemeriksaan.cetak_laporan_operasi', $data);

		return $pdf->stream('laporan-operasi.pdf');
	}

	public function resume($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$pasien_id = Registrasi::find($reg_id)->pasien_id;
		// dd($pasien_id);
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		// $reg = Registrasi::where('pasien_id', $pasien_id)->get();
		// $idregs = [];
		// foreach ($reg as $r) {
		// 	$idregs[] = $r->id;
		// }
		// $data['rad']			= \App\RadiologiEkspertise::whereIn('registrasi_id', $idregs)->get();
		$data['rad']			= PacsExpertise::where('no_rm', @$data['reg']->pasien->no_rm)->get();

		$data['pasien'] = Pasien::find($pasien_id);
		$data['norm']   = $data['pasien']->no_rm;
		// if ($data['reg']->poli_id == "3" || $data['reg']->poli_id == "34") {
		// 	$data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->where('type','fisik_gigi')->orderBy('id','DESC')->get();
		// } elseif ($data['reg']->poli_id == "15") {
		// 	$data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->where('type','fisik_obgyn')->orderBy('id','DESC')->get();
		// } elseif ($data['reg']->poli_id == "6") {
		// 	$data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->where('type','fisik_mata')->orderBy('id','DESC')->get();
		// } elseif ($data['reg']->poli_id == "27") {
		// 	$data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->where('type','fisik_hemodialisis')->orderBy('id','DESC')->get();
		// } elseif ($data['reg']->poli_id == "41") {
		// 	$data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->where('type','fisik_paru')->orderBy('id','DESC')->get();
		// } else {
		// 	$data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->where('type','fisik_umum')->orderBy('id','DESC')->get();
		// }
		$data['resume']    = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
			->orderBy('id', 'DESC')
			->whereNotIn('type', not_an_asesmen())
			->whereNull('deleted_at')
			->get();
		$resume_cppt = Emr::where('pasien_id', $data['reg']->pasien_id)
							->where('unit', '!=', 'sbar')
							->orderBy('id', 'DESC')->get();
		$resume_cppt = $resume_cppt->map(function ($item) {
			$item['source'] = 'cppt';
			return $item;
		});
		$data['resume'] = $data['resume']->map(function ($item) {
			$item['source'] = 'asesmen';
			$item['unit'] = in_array($item->type, asesmen_ranap_dokter()) ? 'inap' : '';
			return $item;
		});
		$data['resume'] = $data['resume']->concat($resume_cppt);
		$data['resume'] =  $data['resume']->sortByDesc('created_at');
		// $data['resume']    = EmrInapPemeriksaan::where('registrasi_id',$reg_id)->orderBy('id','DESC')->get();
		$data['registrasi'] = Registrasi::with(['poli'])
			->where('pasien_id', $pasien_id)
			->whereNull('deleted_at')
			->orderBy('id', 'DESC')
			->select('id', 'poli_id', 'tte_resume_pasien', 'created_at', 'status_reg')
			->get();
		$data['layanan_rehab'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
			->with(['registrasi', 'registrasi.poli'])
			->where(function ($query){
				$query->where('type', 'layanan_rehab')
					->orWhere('type', 'uji_fungsi_rehab')
					->orWhere('type', 'program_terapi_rehab');
			})
			->orderBy('id', 'DESC')
			->get();
		$data['triage_igd'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
			->with(['registrasi', 'registrasi.poli'])
			->where('type', 'triage-igd')
			->orderBy('id', 'DESC')
			->get();

		$data['spri'] = SuratInap::join('registrasis', 'registrasis.id', '=', 'surat_inaps.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('surat_inaps.registrasi_id', $data['reg']->id)
			->select('surat_inaps.no_spri','registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'registrasis.dokter_id', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.alamat', 'surat_inaps.*')
			->get();
		
		$data['transfer_internal'] =  Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', 'sbar')->orderBy('id', 'DESC')->get();
		$data['ews'] =  EmrEws::where('pasien_id', @$data['reg']->pasien->id)->orderBy('id', 'DESC')->get();
		$data['askep_askeb'] =  EmrInapPemeriksaan::where('pasien_id', @$data['reg']->pasien->id)->whereIn('type', ['asuhan-kebidanan', 'asuhan-keperawatan'])->orderBy('id', 'DESC')->get();

		return view('emr.modules.resume', $data)->with('no', 1);
	}

	public function resumeGizi($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$pasien_id = Registrasi::find($reg_id)->pasien_id;
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['rad']			= PacsExpertise::where('no_rm', @$data['reg']->pasien->no_rm)->get();

		$data['pasien'] = Pasien::find($pasien_id);
		$data['norm']   = $data['pasien']->no_rm;
		$data['cppt']    = EmrGizi::where('registrasi_id', $data['reg']->id)
								->orderBy('id', 'DESC')
								->whereNull('deleted_at')
								->get();
		$data['skrining'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
							->whereIn('type', [
								'inap-perawat-dewasa',
								'inap-perawat-anak',
								'asesmen-awal-perawat-maternitas',
								'asesmen-perinatologi'
							])
							->orderBy('id', 'DESC')
							->get()
							->map(function ($skrining) {
								if ($skrining->type == "inap-perawat-dewasa") {
									$skrining->jenis = "Skrining Gizi Dewasa";
								} elseif ($skrining->type == "inap-perawat-anak") {
									$skrining->jenis = "Skrining Gizi Anak";
								} elseif ($skrining->type == "asesmen-awal-perawat-maternitas") {
									$skrining->jenis = "Skrining Gizi Maternitas";
								} elseif ($skrining->type == "asesmen-perinatologi") {
									$skrining->jenis = "Skrining Gizi Perinatologi";
								}

								return $skrining;
							});

		$data['pengkajian'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
								->where('type', 'fisik_gizi')
								->orderBy('id', 'DESC')
								->get();

		return view('emr.modules.resumeGizi', $data)->with('no', 1);
	}

	public function cetakSBAR($id)
	{
		$sbar = Emr::find($id);
		$pegawai = Pegawai::where('user_id', $sbar->user_id)->first();
		$reg = Registrasi::find($sbar->registrasi_id);
		$pdf = PDF::loadView('emr._cetak_sbar', compact('sbar','reg', 'pegawai'));
		$pdf->setPaper('A4', 'portrait');
		return $pdf->stream('sbar-laporan.pdf');
	}
	public function tteSBAR(Request $request, $id)
	{
		$sbar = Emr::find($id);
		$pegawai = Pegawai::where('user_id', $sbar->user_id)->first();
		$reg = Registrasi::find($sbar->registrasi_id);
		
		if (tte()) {
			$proses_tte = true;
			$pdf = PDF::loadView('emr._cetak_sbar', compact('sbar','reg', 'pegawai', 'proses_tte'));
			$pdf->setPaper('A4', 'portrait');
			$pdfContent = $pdf->output();

            // Create temp pdf file
            $filePath = uniqId() . '-sbar.pdf';
            File::put(public_path($filePath), $pdfContent);

			// Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

			$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "sbar", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

			if ($tte->httpStatusCode == 200) {
                $sbar->tte = $tte->response;
                $sbar->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
		} else {
			$tte_nonaktif = true;
			$pdf = PDF::loadView('emr._cetak_sbar', compact('sbar','reg', 'pegawai', 'tte_nonaktif'));
			$pdf->setPaper('A4', 'portrait');
			$pdfContent = $pdf->output();
            $sbar->tte = json_encode((object) [
                "base64_signed_file" => base64_encode($pdfContent),
            ]);
            $sbar->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
		}
	}
	public function cetakTTESBAR($id)
	{
		$sbar = Emr::find($id);

        $tte = json_decode($sbar->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Transfer Internal-' . $sbar->id . '.pdf"',
        ]);
	}
	public function pemeriksaanLab($unit, $reg_id)
	{
		$pasien_id = Registrasi::find($reg_id)->pasien_id;
		// dd($pasien_id);
		$reg = Registrasi::where('pasien_id', $pasien_id)->pluck('id');
		// $data['hasillab']   = Hasillab::with('orderLab.folios')->whereIn('registrasi_id', $reg)->orderBy('id', 'DESC')->get();
		$data['hasillab']   = Hasillab::
		// with([
		// 	'orderLab.folios' => function ($query) {
		// 		$query->select('id', 'order_lab_id', 'namatarif'); // Pilih hanya kolom yang dibutuhkan
		// 	}
		// ])
		select('id', 'no_lab', 'tgl_pemeriksaan', 'jam', 'registrasi_id')
		->whereNotNull('order_lab_id')
		->whereIn('registrasi_id', $reg)
		->orderBy('id', 'DESC')
		->get();

		// dd($data['hasillab']);
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($data['registrasi_id']);
		return view('emr.modules.pemeriksaan_labor', $data)->with('no', 1);
	}

	// ANAMNESIS
	public function anamnesisUmum(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat_mr']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'umum')->orderBy('id', 'DESC')->get();
		$data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'tanda_vital')->orderBy('id', 'DESC')->get();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['riwayat_me']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';





		// riwayat kesehatan
		$kesehatan 		   = MasterRiwayatKesehatan::where('tipe', 'K')->get();
		$riwayat_kesehatan = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'K')->get();
		$data['riwayat_kesehatan'] = [];
		foreach ($kesehatan as $n => $d) {
			$data['riwayat_kesehatan'][$d->id]['id'] = $d->id;
			$data['riwayat_kesehatan'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_kesehatan as $key => $isi) {
				$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}
		// dd($data['riwayat_kesehatan']);
		// informasi
		$informasi 		   = MasterRiwayatKesehatan::where('tipe', 'I')->get();
		$riwayat_info      = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'I')->get();
		$data['riwayat_info'] = [];
		foreach ($informasi as $n => $d) {
			$data['riwayat_info'][$d->id]['id'] = $d->id;
			$data['riwayat_info'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_info as $key => $isi) {
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// cara masuk
		$caramasuk  = MasterRiwayatKesehatan::where('tipe', 'CM')->get();
		$CM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'CM')->get();
		$data['CM'] = [];
		foreach ($caramasuk as $n => $d) {
			$data['CM'][$d->id]['id'] = $d->id;
			$data['CM'][$d->id]['nama'] = $d->nama;
			foreach ($CM as $key => $isi) {
				$data['CM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['CM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// asal masuk
		$asalmasuk  = MasterRiwayatKesehatan::where('tipe', 'AM')->get();
		$AM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'AM')->get();
		$data['AM'] = [];
		foreach ($asalmasuk as $n => $d) {
			$data['AM'][$d->id]['id'] = $d->id;
			$data['AM'][$d->id]['nama'] = $d->nama;
			foreach ($AM as $key => $isi) {
				$data['AM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['AM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// riwayat Alergi
		$alergi 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$riwayat_alergi = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'A')->get();
		$data['riwayat_alergi'] = [];
		foreach ($alergi as $n => $d) {
			$data['riwayat_alergi'][$d->id]['id'] = $d->id;
			$data['riwayat_alergi'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_alergi as $key => $isi) {
				$data['riwayat_alergi'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
			}
		}


		// $data['registrasi_id']     = $registrasi_id;
		// $data['unit']              = $unit;
		// $data['reg']               = Registrasi::find($registrasi_id);
		// $data['riwayat_mr']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'umum')->orderBy('id', 'DESC')->get();
		// $data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id',$data['reg']->pasien_id)->where('type','tanda_vital')->orderBy('id','DESC')->get();

		// $data['riwayat'] = Registrasi::leftJoin('emr_inap_medical_records', 'emr_inap_medical_records.registrasi_id', '=', 'registrasis.id')
		// 							   ->where('emr_inap_medical_records.pasien_id', $data['reg']->pasien_id)
		// 							   ->where('emr_inap_medical_records.type', 'umum')
		// 							   ->orderBy('emr_inap_medical_records.id', 'DESC')
		// 							   ->leftJoin('emr_inap_pemeriksaans', 'emr_inap_pemeriksaans.registrasi_id', '=', 'registrasis.id')
		// 							   ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
		// 							   ->where('emr_inap_pemeriksaans.type', 'tanda_vital')
		// 							   ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
		// 							   ->select('emr_inap_medical_records.keterangan', 'emr_inap_pemeriksaans.tanda_vital')
		// 							   ->get();

		// 'registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id'


		if ($record_id) {
			// dd($record_id);
			$data['history'] = EmrInapPemeriksaan::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}



		if ($r->method() == 'POST') {



			$emr = new EmrInapPemeriksaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->tanda_vital  = json_encode($r->pemeriksaan);
			$emr->type  	= 'tanda_vital';
			$emr->save();



			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}

		// dd($data);
		return view('emr.modules.anamnesis.umum', $data);
	}




	public function anamnesisMain(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		// if($data['reg']->bayar == '1' && $data['reg']->no_sep == null && substr($data['reg']->status_reg, 0, 1) == 'J'){
		// 	Flashy::warning('SEP PASIEN BELUM TERBIT');
		// 	return redirect()->back();
		// }
		// Jika pasien bpjs dan yg akses dokter maka langsung buka i-care
		// if($unit != 'inap' && $data['reg']->bayars->carabayar == 'JKN' && Auth::user()->pegawai->kategori_pegawai == 1){
		// 	return redirect('emr-soap-icare/fkrtl/'.$unit.'/'.$data['reg']->id);
		// }
		
		$data['riwayat_mr']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'umum')->orderBy('id', 'DESC')->get();
		$data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'tanda_vital')->orderBy('id', 'DESC')->get();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['riwayat_me']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';

		// riwayat kesehatan
		$kesehatan 		   = MasterRiwayatKesehatan::where('tipe', 'K')->get();
		$riwayat_kesehatan = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'K')->get();
		$data['riwayat_kesehatan'] = [];
		foreach ($kesehatan as $n => $d) {
			$data['riwayat_kesehatan'][$d->id]['id'] = $d->id;
			$data['riwayat_kesehatan'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_kesehatan as $key => $isi) {
				$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_kesehatan'][@$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}
		// dd($data['riwayat_kesehatan']);
		// informasi
		$informasi 		   = MasterRiwayatKesehatan::where('tipe', 'I')->get();
		$riwayat_info      = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'I')->get();
		$data['riwayat_info'] = [];
		foreach ($informasi as $n => $d) {
			$data['riwayat_info'][$d->id]['id'] = $d->id;
			$data['riwayat_info'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_info as $key => $isi) {
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// cara masuk
		$caramasuk  = MasterRiwayatKesehatan::where('tipe', 'CM')->get();
		$CM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'CM')->get();
		$data['CM'] = [];
		foreach ($caramasuk as $n => $d) {
			$data['CM'][$d->id]['id'] = $d->id;
			$data['CM'][$d->id]['nama'] = $d->nama;
			foreach ($CM as $key => $isi) {
				$data['CM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['CM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// asal masuk
		$asalmasuk  = MasterRiwayatKesehatan::where('tipe', 'AM')->get();
		$AM         = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'AM')->get();
		$data['AM'] = [];
		foreach ($asalmasuk as $n => $d) {
			$data['AM'][$d->id]['id'] = $d->id;
			$data['AM'][$d->id]['nama'] = $d->nama;
			foreach ($AM as $key => $isi) {
				$data['AM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['AM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// riwayat Alergi
		$alergi 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$riwayat_alergi = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat_me']->id)->where('tipe', 'A')->get();
		$data['riwayat_alergi'] = [];
		foreach ($alergi as $n => $d) {
			$data['riwayat_alergi'][$d->id]['id'] = $d->id;
			$data['riwayat_alergi'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_alergi as $key => $isi) {
				$data['riwayat_alergi'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
			}
		}




		// dd($data);
		return view('emr.modules.anamnesis.main', $data);
	}




	// Hapus Data Anamnesis Umum
	public function hapusUmum($registrasi_id, $id)
	{
		//dd("Hapus Anamnesis Umum");
		$umum = EmrInapMedicalRecord::find($id);
		//dd($umum);
		$umum->delete();
		Flashy::success('Catatan medis Umum berhasil dihapus');
		return redirect()->back();
	}





	// Hapus Data Anamnesis Umum
	public function ubahDpjp($registrasi_id, Request $request)
	{
		//dd("Hapus Anamnesis Umum");
		$data = Registrasi::find($registrasi_id);
		$data->dokter_id =  $request->dokter_id;
		$data->update();

		return response($data);
	}



	// Hapus Data Anamnesis Riwayat
	public function hapusRiwayat($registrasi_id, $id)
	{
		//dd("Hapus Anamnesis Riwayat");
		$riwayat = EmrInapMedicalRecord::find($id);
		//dd($umum);
		$riwayat->delete();
		Flashy::success('Catatan medis Riwayat berhasil dihapus');
		return redirect()->back();
	}

	public function anamnesisRiwayat(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'riwayat')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {

			// dd($r->all());

			$emr = new EmrInapMedicalRecord();
			$emr->keterangan = $r->keterangan;
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->menstruasi  = json_encode($r->menstruasi);
			$emr->user_id  = Auth::user()->id;
			$emr->type  	= 'riwayat';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.riwayat', $data);
	}





	public function anamnesisRiwayatUmum(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'riwayat_umum')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {

			$emr = new EmrInapMedicalRecord();
			$emr->keterangan = $r->keterangan;
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->riwayat  = json_encode($r->riwayat);
			$emr->user_id  = Auth::user()->id;
			$emr->type  	= 'riwayat_umum';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.riwayat_umum', $data);
	}











	public function anamnesisRiwayatGigi(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'riwayat_gigi')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {

			// dd($r->all());

			$emr = new EmrInapMedicalRecord();
			$emr->keterangan = "gigi";
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->menstruasi  = json_encode($r->riwayat);
			$emr->user_id  = Auth::user()->id;
			$emr->type  	= 'riwayat_gigi';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.riwayat_gigi', $data);
	}

	public function anamnesisKeluhanUtama(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'keluhan_utama')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapMedicalRecord::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		if ($r->method() == 'POST') {
			$emr = new EmrInapMedicalRecord();
			$emr->keterangan = $r->keterangan;
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->type  	= 'keluhan_utama';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.keluhan_utama', $data);
	}


	public function anamnesisKeadaanMukosaOral(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'keadaan_mukosa_oral')->orderBy('id', 'DESC')->get();
		// DELETE
		// dd($data['riwayat']);
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		// if ($r->id != null ) {
		// 	// dd($r->all());
		// 	// $alatbantu = json_encode($r->alatbantu);
		// 	$emr = EmrInapKondisiKhusus::find($r->id);
		// 	$emr->pasien_id  = $r->pasien_id;
		// 	$emr->registrasi_id  = $r->registrasi_id;
		// 	$emr->user_id  = Auth::user()->id;
		// 	$emr->kondisi_mukosa_oral  = json_encode($r->keadaan_mukosa_oral);
		// 	$emr->type  	= 'keadaan_mukosa_oral';
		// 	$emr->update();

		// 	Flashy::success('Catatan berhasil diupdate');
		// 	return redirect()->back();
		// }

		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->kondisi_mukosa_oral  = json_encode($r->keadaan_mukosa_oral);
			$emr->type  	= 'keadaan_mukosa_oral';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}



		return view('emr.modules.anamnesis.keadaan_mukosa_oral', $data);
	}

	public function airway(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->where('type', 'airway')->orderBy('id', 'DESC')->get();

		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrRiwayat();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->riwayat_pengobatan  = json_encode($r->riwayat_pengobatan);
			$emr->type  	= 'airway';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}



		return view('emr.modules.primary_airway', $data);
	}

	public function breathing(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->where('type', 'breathing')->orderBy('id', 'DESC')->get();

		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrRiwayat();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->riwayat_pengobatan  = json_encode($r->riwayat_pengobatan);
			$emr->type  	= 'breathing';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}



		return view('emr.modules.primary_breathing', $data);
	}

	public function circulation(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->where('type', 'circulation')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrRiwayat();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->riwayat_pengobatan  = json_encode($r->riwayat_pengobatan);
			$emr->type  	= 'circulation';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}



		return view('emr.modules.primary_circulation', $data);
	}

	public function disability(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->where('type', 'disability')->orderBy('id', 'DESC')->get();
		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrRiwayat();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->riwayat_pengobatan  = json_encode($r->riwayat_pengobatan);
			$emr->type  	= 'disability';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}



		return view('emr.modules.primary_disability', $data);
	}

	public function eksposure(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'eksposure')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrRiwayat();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->riwayat_pengobatan  = json_encode($r->riwayat_pengobatan);
			$emr->type  	= 'eksposure';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}



		return view('emr.modules.primary_eksposure', $data);
	}


	public function suratkematian()
	{
		return view('emr.modules.surat_kematian');
	}



	public function anamnesisObgyn(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'obgyn')->orderBy('id', 'DESC')->get();
		// DELETE
		// dd($data['riwayat']);
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		$alatbantu = [];
		// if ($r->id != null ) {
		// 	// dd($r->all());
		// 	// $alatbantu = json_encode($r->alatbantu);
		// 	$emr = EmrInapKondisiKhusus::find($r->id);
		// 	$emr->pasien_id  = $r->pasien_id;
		// 	$emr->registrasi_id  = $r->registrasi_id;
		// 	$emr->user_id  = Auth::user()->id;
		// 	$emr->obgyn  = json_encode($r->obgyn);
		// 	$emr->type  	= 'obgyn';
		// 	$emr->update();

		// 	Flashy::success('Catatan berhasil diupdate');
		// 	return redirect()->back();
		// }
		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->obgyn  = json_encode($r->obgyn);
			$emr->type  	= 'obgyn';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.obgyn', $data);
	}







	public function anamnesisSarafOtak(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'saraf_otak')->orderBy('id', 'DESC')->get();
		// DELETE
		// dd($data['riwayat']);
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		$alatbantu = [];
		// if ($r->id != null ) {
		// 	// dd($r->all());
		// 	// $alatbantu = json_encode($r->alatbantu);
		// 	$emr = EmrInapKondisiKhusus::find($r->id);
		// 	$emr->pasien_id  = $r->pasien_id;
		// 	$emr->registrasi_id  = $r->registrasi_id;
		// 	$emr->user_id  = Auth::user()->id;
		// 	$emr->saraf_otak  = json_encode($r->saraf_otak);
		// 	$emr->type  	= 'saraf_otak';
		// 	$emr->update();

		// 	Flashy::success('Catatan berhasil diupdate');
		// 	return redirect()->back();
		// }
		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->saraf_otak  = json_encode($r->saraf_otak);
			$emr->type  	= 'saraf_otak';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.saraf_otak', $data);
	}









	public function anamnesisStatusFungsional(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'status_fungsional')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		$alatbantu = [];
		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->penggunaan_alat_bantu  = json_encode($r->alatbantu);
			$emr->cacat_tubuh  = json_encode($r->cidera);
			$emr->type  	= 'status_fungsional';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.status_fungsional', $data);
	}

	public function anamnesisStatusGeneralis(Request $r, $unit, $registrasi_id)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'generalis_bedah')->orderBy('id', 'DESC')->get();

		$alatbantu = [];
		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->generalis  = json_encode($r->generalis);
			$emr->type  	= 'generalis_bedah';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.generalis_bedah', $data);
	}

	public function anamnesisKondisiSosial(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'kondisi_sosial')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}

		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->kondisi_sosial  = json_encode($r->kondisisosial);
			$emr->type  	= 'kondisi_sosial';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.kondisi_sosial', $data);
	}
	public function anamnesisPermasalahanGizi(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'permasalahan_gizi')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}

		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->permasalahan_gizi  = json_encode($r->permasalahan_gizi);
			$emr->type  	= 'permasalahan_gizi';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.permasalahan_gizi', $data);
	}
	public function anamnesisEdukasiPasienKeluarga(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'edukasi_pasien')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}

		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->edukasi_pasien  = json_encode($r->edukasipasien);
			$emr->type  	= 'edukasi_pasien';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.edukasi_pasien', $data);
	}



	public function anamnesisEdukasiObgyn(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{



		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'edukasi_obgyn')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}

		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->edukasi_pasien  = json_encode($r->obgyn);
			$emr->type  	= 'edukasi_obgyn';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.edukasi_pasien_obgyn', $data);
	}







	public function generalisTHT(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'generalis_tht')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		$alatbantu = [];
		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->generalis  = json_encode($r->generalis);
			$emr->type  	= 'generalis_tht';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.generalisTHT', $data);
	}




	public function asesmenAnatomiAnak(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'anatomi_anak')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}
		$alatbantu = [];
		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->generalis  = json_encode($r->generalis);
			$emr->type  	= 'anatomi_anak';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.asesmen_anatomi_anak', $data);
	}








	public function anamnesisRencana(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapKondisiKhusus::where('pasien_id', $data['reg']->pasien_id)->where('type', 'rencana')->orderBy('id', 'DESC')->get();
		// DELETE
		if ($record_id) {
			$data['history'] = EmrInapKondisiKhusus::where('id', $record_id)->first();
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}

		if ($r->method() == 'POST') {
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapKondisiKhusus();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->rencana  = json_encode($r->rencana);
			$emr->type  	= 'rencana';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anamnesis.rencana', $data);
	}





	public function diet($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['datadiet'] = MasterDiet::pluck('kode', 'nama');
		$data['diet'] = MasterDiet::select('id', 'kode', 'nama')->get();
		// $data['riwayat'] = EdukasiDiet::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();
		$pasien_id = Registrasi::find($reg_id)->pasien_id;
		// dd($pasien_id);
		$reg = Registrasi::where('pasien_id', $pasien_id)->get();
		$idregs = [];
		foreach ($reg as $r) {
			$idregs[] = $r->id;
		}
		// dd($idregs);
		$data['riwayat'] = EdukasiDiet::whereIn('registrasi_id', $idregs)->orderBy('created_at', 'DESC')->get();
		$data['edukasi'] = EdukasiDiet::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();
		return view('emr.modules.diet', $data)->with('no', 1);
	}
	public function dietGizi($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['datadiet'] = MasterDiet::pluck('kode', 'nama');
		$data['diet'] = MasterDiet::select('id', 'kode', 'nama')->get();
		// $data['riwayat'] = EdukasiDiet::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();
		$pasien_id = Registrasi::find($reg_id)->pasien_id;
		// dd($pasien_id);
		$reg = Registrasi::where('pasien_id', $pasien_id)->get();
		$idregs = [];
		foreach ($reg as $r) {
			$idregs[] = $r->id;
		}
		// dd($idregs);
		$data['riwayat'] = EdukasiDiet::whereIn('registrasi_id', $idregs)->orderBy('created_at', 'DESC')->get();
		$data['edukasi'] = EdukasiDiet::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();
		return view('emr.modules.diet-gizi', $data)->with('no', 1);
	}
	public function jasaDokter($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$pasien_id = Registrasi::find($reg_id)->pasien_id;

		return view('emr.modules.jasa_dokter', $data)->with('no', 1);
	}
	public function dataLaporanKinerja(Request $request)
	{
		// dd($request->all());
		$datas['registrasi_id']  = $request->reg_id;
		$datas['unit']           = $request->unit;
		$datas['reg'] = Registrasi::where('id', $request->reg_id)->first();
		$pasien_id = Registrasi::find($request->reg_id)->pasien_id;
		request()->validate([
			'tglAwal' => 'required',
			'tglAkhir' => 'required',
		]);
		$tglAwal  = valid_date($request['tglAwal']) . ' 00:00:00';
		$tglAkhir = valid_date($request['tglAkhir']) . ' 23:59:59';
		$dokter   = $request['dokter'];

		if ($request['jenis'] == 'TA') {
			$jenis = 'FRJ';
		} elseif ($request['jenis'] == 'TI') {
			$jenis = 'FRI';
		} elseif ($request['jenis'] == 'TG') {
			$jenis = 'FRD';
		} elseif ($request['jenis'] == 'TL') {
			$jenis = 'FPB';
		}

		$dokter = \Modules\Pegawai\Entities\Pegawai::select('id')->get();
		$di = [];
		foreach ($dokter as $key => $d) {
			$di[] = '' . $d->id . '';
		}
		$dokters = $request->dokter;
		$datas['data'] = Folio::join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
			->where('folios.lunas', 'Y')
			->where('registrasis.dokter_id', $dokters)
			// ->where('folios.cara_bayar_id', $request['cara_bayar_id'])
			// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
			->where('folios.total', '<>', 0)
			// ->where('folios.dokter_id', $dokters)
			->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
			->select('folios.registrasi_id', 'folios.namatarif', 'folios.jenis', 'folios.cara_bayar_id', 'folios.total', 'folios.pasien_id', 'folios.dokter_id', 'folios.poli_id', 'folios.created_at')
			->get();
		// dd($datas['data']);
		if ($request['submit'] == 'lanjut') {
			// return view('farmasi.laporan.kinerjaFarmasi', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
			return view('emr.modules.jasa_dokter', $datas);
		} elseif ($request['submit'] == 'excel') {
			$jenis = $request['jenis'];

			Excel::create('Laporan Kinerja', function ($excel) use ($datas, $jenis) {
				// Set the properties
				$excel->setTitle('Laporan Kinerja')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Kinerja');
				$excel->sheet('Laporan Kinerja', function ($sheet) use ($datas, $jenis) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama',
						'No. RM',
						'Baru/Lama',
						'L/P',
						'Ruang / Poli',
						'Cara Bayar',
						'Tanggal',
						// 'Dokter',
						'Tindakan',
						'Tarif',
					]);
					foreach ($datas['data'] as $key => $d) {
						$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
						$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
						$pasien = Pasien::find($d->pasien_id);

						if (substr($reg->status_reg, 0, 1) == 'G' || substr($reg->status_reg, 0, 1) == 'I') {
							$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
						} else {
							$poli = baca_poli($reg->poli_id);
						}

						$sheet->row(++$row, [
							$no++,
							@$pasien ? @$pasien->nama : NULL,
							@$pasien ? @$pasien->no_rm : NULL,
							(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
							@$pasien ? @$pasien->kelamin : NULL,
							$poli,
							baca_carabayar($d->cara_bayar_id) . ' ' . $reg->tipe_jkn,
							$d->created_at->format('d-m-Y'),
							// !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
							$d->namatarif,
							$d->total,
						]);
					}
				});
			})->export('xlsx');
		}
	}
	public function odontogram($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'R'])
			->get();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['odontogram'] = OrderOdontogram::where(['registrasi_id' => $reg_id, 'jenis' => baca_jenis_unit($unit)])->get();
		return view('emr.modules.odontogram', $data)->with('no', 1);
	}


	public function editDokter($id, $registrasi_id)
	{
		$data = Registrasi::find($registrasi_id);
		$data->dokter_id = $id;
		$data->ubah_dpjp = 'Y';
		$data->update();

		$folio = Folio::where('registrasi_id', $registrasi_id)
			->where(function ($q) {
				$q->where('namatarif', 'like', 'Retribusi%')
				->orWhere('namatarif', 'like', 'Sticker%');
			})
			->get();
		foreach ($folio as $d) {
			$fol = Folio::find($d->id);
			$fol->dokter_id = $id;
			$fol->dokter_pelaksana = $id;
			$fol->save();
		}

		// $histori = HistorikunjunganIRJ::where('registrasi_id', '=', $registrasi_id);
		// $histori->dokter_id = $id;
		// $histori->update();

		return response($data);
	}




	public function saveOdontogram(Request $request)
	{
		DB::transaction(function () use ($request) {
			//SAVE ODO
			$odontogram = new OrderOdontogram();
			$odontogram->registrasi_id = $request['registrasi_id'];
			$odontogram->occlusi = $request['occlusi'];
			$odontogram->torus_palatinus  = $request['torus_palatinus'];
			$odontogram->torus_mandibularis = $request['torus_mandibularis'];
			$odontogram->palatanum = $request['palatanum'];
			$odontogram->diastema = $request['diastema'];
			$odontogram->gigi_anomali = $request['gigi_anomali'];
			$odontogram->lain_lain  = $request['lain_lain'];
			$odontogram->jenis = 'TA';

			// for( $i = 11; $i < 86; $i++) {
			// 	if($i === 19 || $i === 20 || $i === 29 || $i === 30 || $i === 39 || $i === 40 || $i === 49 || $i === 50 || $i === 56 || $i === 57 || $i === 58 || $i === 59 || $i === 60 || $i === 66 || $i === 67 || $i === 68 || $i === 69 || $i === 70 || $i === 76 || $i === 77 || $i === 78 || $i === 79 || $i === 80) 
			// 	{
			// 		continue;
			// 	}else{
			// 		// $odontogram->gigi11 = $request['inputGigi11'];
			// 		$odontogram->gigi.$i = $request['inputGigi'.$i];
			// 	}
			// }
			$odontogram->gigi11 = $request['inputGigi11'];
			$odontogram->gigi12 = $request['inputGigi12'];
			$odontogram->gigi13 = $request['inputGigi13'];
			$odontogram->gigi14 = $request['inputGigi14'];
			$odontogram->gigi15 = $request['inputGigi15'];
			$odontogram->gigi16 = $request['inputGigi16'];
			$odontogram->gigi17 = $request['inputGigi17'];
			$odontogram->gigi18 = $request['inputGigi18'];

			$odontogram->gigi21 = $request['inputGigi21'];
			$odontogram->gigi22 = $request['inputGigi22'];
			$odontogram->gigi23 = $request['inputGigi23'];
			$odontogram->gigi24 = $request['inputGigi24'];
			$odontogram->gigi25 = $request['inputGigi25'];
			$odontogram->gigi26 = $request['inputGigi26'];
			$odontogram->gigi27 = $request['inputGigi27'];
			$odontogram->gigi28 = $request['inputGigi28'];

			$odontogram->gigi31 = $request['inputGigi31'];
			$odontogram->gigi32 = $request['inputGigi32'];
			$odontogram->gigi33 = $request['inputGigi33'];
			$odontogram->gigi34 = $request['inputGigi34'];
			$odontogram->gigi35 = $request['inputGigi35'];
			$odontogram->gigi35 = $request['inputGigi35'];
			$odontogram->gigi36 = $request['inputGigi36'];
			$odontogram->gigi37 = $request['inputGigi37'];
			$odontogram->gigi38 = $request['inputGigi38'];

			$odontogram->gigi41 = $request['inputGigi41'];
			$odontogram->gigi42 = $request['inputGigi42'];
			$odontogram->gigi43 = $request['inputGigi43'];
			$odontogram->gigi44 = $request['inputGigi44'];
			$odontogram->gigi45 = $request['inputGigi45'];
			$odontogram->gigi46 = $request['inputGigi46'];
			$odontogram->gigi47 = $request['inputGigi47'];
			$odontogram->gigi48 = $request['inputGigi48'];

			$odontogram->gigi51 = $request['inputGigi51'];
			$odontogram->gigi52 = $request['inputGigi52'];
			$odontogram->gigi53 = $request['inputGigi53'];
			$odontogram->gigi54 = $request['inputGigi54'];
			$odontogram->gigi55 = $request['inputGigi55'];

			$odontogram->gigi61 = $request['inputGigi61'];
			$odontogram->gigi62 = $request['inputGigi62'];
			$odontogram->gigi63 = $request['inputGigi63'];
			$odontogram->gigi64 = $request['inputGigi64'];
			$odontogram->gigi65 = $request['inputGigi65'];

			$odontogram->gigi71 = $request['inputGigi71'];
			$odontogram->gigi72 = $request['inputGigi72'];
			$odontogram->gigi73 = $request['inputGigi73'];
			$odontogram->gigi74 = $request['inputGigi74'];
			$odontogram->gigi75 = $request['inputGigi75'];

			$odontogram->gigi81 = $request['inputGigi81'];
			$odontogram->gigi82 = $request['inputGigi82'];
			$odontogram->gigi83 = $request['inputGigi83'];
			$odontogram->gigi84 = $request['inputGigi84'];
			$odontogram->gigi85 = $request['inputGigi85'];
			$odontogram->save();
		});
		Flashy::success('Odontogram berhasil disimpan');
		return redirect()->back();
	}

	public function saveDiet(Request $request)
	{
		DB::transaction(function () use ($request) {


			$create_composition = config('app.create_composition');
			$id_dokter_ss = Pegawai::find(Registrasi::find($request['registrasi_id'])->dokter_id)->id_dokterss;
			$nama_dokter = Pegawai::find(Registrasi::find($request['registrasi_id'])->dokter_id)->nama;
			$organization_id = config('app.organization_id');
			$pasien_ss = Pasien::find(Registrasi::find($request['registrasi_id'])->pasien_id)->nama;
			$pasien_ss_id = Pasien::find(Registrasi::find($request['registrasi_id'])->pasien_id)->id_patient_ss;
			$id_encounter_ss = Registrasi::find($request['registrasi_id'])->id_encounter_ss;
			$namaDiet = MasterDiet::where('kode', $request['kodeDiet'])->first();
			$time = date('H:i:s');
			$time_2 = date('H:i');
			$date = date('d F Y');
			$waktu = time();
			$today = date("Y-m-d", $waktu);

			$reg = Registrasi::find($request['registrasi_id']);
			$id_composition_ss = NULL;
			if (Satusehat::find(6)->aktif == 1 && $reg->id_encounter_ss != null) {
				if (satusehat()) {


					// API TOKEN
					$client_id = config('app.client_id');
					$client_secret = config('app.client_secret');
					// create code satusehat
					$urlcreatetoken = config('app.create_token');
					$curl_token = curl_init();

					curl_setopt_array($curl_token, array(
						CURLOPT_URL => $urlcreatetoken,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/x-www-form-urlencoded'
						),
					));

					$response_token = curl_exec($curl_token);
					$token = json_decode($response_token);
					$access_token = $token->access_token;
					// dd($access_token);
					curl_close($curl_token);
					// END OF API TOKEN

					//API COMPOSITION


					$curl_composition = curl_init();

					curl_setopt_array($curl_composition, array(
						CURLOPT_URL => 	$create_composition,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => '{
						"resourceType": "Composition",
						"identifier": {
							"system": "http://sys-ids.kemkes.go.id/composition/' . $organization_id . '",
							"value": ""
						},
						"status": "final",
						"type": {
							"coding": [
								{
									"system": "http://loinc.org",
									"code": "18842-5",
									"display": "Discharge summary"
								}
							]
						},
						"category": [
							{
								"coding": [
									{
										"system": "http://loinc.org",
										"code": "LP173421-1",
										"display": "Report"
									}
								]
							}
						],
						"subject": {
							"reference": "Patient/' . $pasien_ss_id . '",
							"display": "' . $pasien_ss . '"
						},
						"encounter": {
							"reference": "Encounter/' . $id_encounter_ss . '",
							"display": "Kunjungan ' . $pasien_ss . ' di tanggal ' . $today . ' "
						},
						"date": "' . $today . 'T' . $time . '+07:00",
						"author": [
							{
								"reference": "Practitioner/' . $id_dokter_ss . '",
								"display": "' . $nama_dokter . '"
							}
						],
						"title": "Resume Medis Rawat Jalan",
						"custodian": {
							"reference": "Organization/' . $organization_id . '"
						},
						"section": [
							{
								"code": {
									"coding": [
										{
											"system": "http://loinc.org",
											"code": "42344-2",
											"display": "Discharge diet (narrative)"
										}
									]
								},
								"text": {
									"status": "additional",
									"div": "' . $request['catatan'] . '"
								}
							}
						]
					}',
						CURLOPT_HTTPHEADER => array(
							'Authorization: Bearer ' . $access_token . '',
							'Content-Type: application/json'
						),
					));

					$response_composition = curl_exec($curl_composition);
					// dd($response_composition);
					$composition_ss = json_decode($response_composition);
					if (!empty($composition_ss->id)) {
						$id_composition_ss = $composition_ss->id;
					} else {
						$id_composition_ss = NULL;
					}
					// dd($composition_ss);
					curl_close($curl_composition);
					//END OF API COMPOSITION
				}
			}

			$unit = $request['unit'];
			if ($unit == 'jalan') {
				$jenis = 'TA';
			} elseif ($unit == 'igd') {
				$jenis = 'TG';
			} else {
				$jenis = 'TI';
			}

			//SAVE DIET
			$diet = new EdukasiDiet();
			$diet->kode = $request['kodeDiet'];
			$diet->registrasi_id = $request['registrasi_id'];
			$diet->carabayar_id = $request['cara_bayar'];
			$diet->nama = $request['namaDiet'];
			$diet->catatan_dokter = $request['catatan'];
			$diet->id_composition_ss = @$id_composition_ss;
			$diet->jenis = $jenis;
			$diet->jenis_diet = $request['jenisDiet'];
			$diet->save();
		});
		Flashy::success('Diet berhasil disimpan');
		return redirect()->back();
	}

	public function saveDietGizi(Request $request)
	{
		DB::transaction(function () use ($request) {


			$create_composition = config('app.create_composition');
			$id_dokter_ss = Pegawai::find(Registrasi::find($request['registrasi_id'])->dokter_id)->id_dokterss;
			$nama_dokter = Pegawai::find(Registrasi::find($request['registrasi_id'])->dokter_id)->nama;
			$organization_id = config('app.organization_id');
			$pasien_ss = Pasien::find(Registrasi::find($request['registrasi_id'])->pasien_id)->nama;
			$pasien_ss_id = Pasien::find(Registrasi::find($request['registrasi_id'])->pasien_id)->id_patient_ss;
			$id_encounter_ss = Registrasi::find($request['registrasi_id'])->id_encounter_ss;
			$namaDiet = MasterDiet::where('kode', $request['kodeDiet'])->first();
			$time = date('H:i:s');
			$time_2 = date('H:i');
			$date = date('d F Y');
			$waktu = time();
			$today = date("Y-m-d", $waktu);

			$reg = Registrasi::find($request['registrasi_id']);
			$id_composition_ss = NULL;
			if (Satusehat::find(6)->aktif == 1 && $reg->id_encounter_ss != null) {
				if (satusehat()) {


					// API TOKEN
					$client_id = config('app.client_id');
					$client_secret = config('app.client_secret');
					// create code satusehat
					$urlcreatetoken = config('app.create_token');
					$curl_token = curl_init();

					curl_setopt_array($curl_token, array(
						CURLOPT_URL => $urlcreatetoken,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/x-www-form-urlencoded'
						),
					));

					$response_token = curl_exec($curl_token);
					$token = json_decode($response_token);
					$access_token = $token->access_token;
					// dd($access_token);
					curl_close($curl_token);
					// END OF API TOKEN

					//API COMPOSITION


					$curl_composition = curl_init();

					curl_setopt_array($curl_composition, array(
						CURLOPT_URL => 	$create_composition,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => '{
						"resourceType": "Composition",
						"identifier": {
							"system": "http://sys-ids.kemkes.go.id/composition/' . $organization_id . '",
							"value": ""
						},
						"status": "final",
						"type": {
							"coding": [
								{
									"system": "http://loinc.org",
									"code": "18842-5",
									"display": "Discharge summary"
								}
							]
						},
						"category": [
							{
								"coding": [
									{
										"system": "http://loinc.org",
										"code": "LP173421-1",
										"display": "Report"
									}
								]
							}
						],
						"subject": {
							"reference": "Patient/' . $pasien_ss_id . '",
							"display": "' . $pasien_ss . '"
						},
						"encounter": {
							"reference": "Encounter/' . $id_encounter_ss . '",
							"display": "Kunjungan ' . $pasien_ss . ' di tanggal ' . $today . ' "
						},
						"date": "' . $today . 'T' . $time . '+07:00",
						"author": [
							{
								"reference": "Practitioner/' . $id_dokter_ss . '",
								"display": "' . $nama_dokter . '"
							}
						],
						"title": "Resume Medis Rawat Jalan",
						"custodian": {
							"reference": "Organization/' . $organization_id . '"
						},
						"section": [
							{
								"code": {
									"coding": [
										{
											"system": "http://loinc.org",
											"code": "42344-2",
											"display": "Discharge diet (narrative)"
										}
									]
								},
								"text": {
									"status": "additional",
									"div": "' . $request['catatan'] . '"
								}
							}
						]
					}',
						CURLOPT_HTTPHEADER => array(
							'Authorization: Bearer ' . $access_token . '',
							'Content-Type: application/json'
						),
					));

					$response_composition = curl_exec($curl_composition);
					// dd($response_composition);
					$composition_ss = json_decode($response_composition);
					if (!empty($composition_ss->id)) {
						$id_composition_ss = $composition_ss->id;
					} else {
						$id_composition_ss = NULL;
					}
					// dd($composition_ss);
					curl_close($curl_composition);
					//END OF API COMPOSITION
				}
			}

			$unit = $request['unit'];
			if ($unit == 'jalan') {
				$jenis = 'TA';
			} elseif ($unit == 'igd') {
				$jenis = 'TG';
			} else {
				$jenis = 'TI';
			}

			//SAVE DIET
			$diet = new EdukasiDiet();
			$diet->kode = $request['kodeDiet'];
			$diet->registrasi_id = $request['registrasi_id'];
			$diet->carabayar_id = $request['cara_bayar'];
			$diet->nama = $request['namaDiet'];
			$diet->catatan_dokter = $request['catatan'];
			$diet->id_composition_ss = @$id_composition_ss;
			$diet->jenis = $jenis;
			$diet->jenis_diet = $request['jenisDiet'];
			$diet->save();
		});
		Flashy::success('Diet berhasil disimpan');
		return redirect()->back();
	}

	public function fkrtl($unit, $reg_id)
	{
		$data['registrasi_id']  = $reg_id;
		$data['unit']           = $unit;

		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');

		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$peg = Pegawai::where('id', $data['reg']->dokter_id)->first();
		$ID = config('app.icare_id');
		$t = time();
		$datas = "$ID&$t";
		$secretKey = config('app.icare_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($datas), utf8_encode($secretKey), true));
		// dd($request);
		$completeurl = config('app.icare_url_web_service') . "/api/rs/validate";
		// dd($completeurl);
		$resp = [];
		// dd($data['reg']->pasien);
		// if()
		if ($data['reg']->pasien->no_jkn) {
			$rrr = [
				'param' => $data['reg']->pasien->no_jkn,
				'kodedokter' => (int)$peg->kode_bpjs
			];
			// $rrr = [
			// 		'param'=>'0000410759842',
			// 		'kodedokter'=>(int)78316
			// 	];
			// dd($rrr);

			$session = curl_init($completeurl);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:' . config('app.icare_user_key'),
				'Content-Type: application/json',
			);
			// dd($arrheader);
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($rrr));
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			curl_getinfo($session, CURLINFO_HTTP_CODE);
			$response = curl_exec($session);
			@$array[] = @json_decode(@$response, true);
			// dd($array);
			if (!@$array) {
				Flashy::success('Data Tidak Tersedia');
				return redirect()->back();
			}
			@$stringEncrypt = $this->stringDecrypt($ID . config('app.icare_key') . $t, @$array[0]['response']);
			@$array[] = json_decode($this->decompress(@$stringEncrypt), true);

			// $sml = json_encode($array,JSON_PRETTY_PRINT); 
			@$data['url'] = '';
			// dd($array);
			if (@$array) {
				if (@$array[1]) {
					$data['url'] = @$array[1]['url'];
				}
			}
		}
		// dd($data['url']);

		return view('emr.modules.fkrtl', $data)->with('no', 1);
	}
	function stringDecrypt($key, $string)
	{


		$encrypt_method = 'AES-256-CBC';

		// hash
		$key_hash = hex2bin(hash('sha256', $key));

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

		return $output;
	}

	// function lzstring decompress 
	// download libraries lzstring : https://github.com/nullpunkt/lz-string-php
	function decompress($string)
	{
		// dd($string);
		return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
	}

	public function uploadHasilUSG(Request $request,$unit, $registrasi_id)
	{
		$data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'USG')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['unit'] = $unit;
		$data['registrasi_id']  = $registrasi_id;

		if ($request->method() == 'POST') {
			$request->validate(['file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg']);
			if(!empty($request->file('file'))){
				$filename = time().$request->file('file')->getClientOriginalName();
				$request->file('file')->move('hasil-pemeriksaan/', $filename);
			}else{
				$filename = null;
			}

			try{
				$hasillab = new HasilPemeriksaan();
				$hasillab->no_hasil_pemeriksaan = $request->no_hasil;
				$hasillab->registrasi_id = $request->registrasi_id;
				$hasillab->pasien_id = $request->pasien_id;
				$hasillab->dokter_id = $request->dokter_id;
				$hasillab->penanggungjawab = $request->penanggungjawab;
				$hasillab->tgl_pemeriksaan = $request->tgl_pemeriksaan;
				$hasillab->tgl_hasilselesai = $request->tgl_hasilselesai;
				$hasillab->keterangan = $request->keterangan;
				$hasillab->filename = $filename;
				$hasillab->user_id = Auth::user()->id;
				$hasillab->type = "USG";
				$hasillab->save();
				Flashy::success('Berhasil upload hasil pemeriksaan!');
			}catch(Exception $e){
				Flashy::error('Gagal mengupload hasil pemeriksaan!');
			}
			return redirect()->back();
		}

		return view('emr.modules.pemeriksaan.hasil_pemeriksaan_usg', $data);
	}

	public function cetakUSG(Request $request,$unit, $registrasi_id)
	{
		$data['emr'] = Emr::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['unit'] = $unit;
		$data['registrasi_id']  = $registrasi_id;

		return view('emr.modules.pemeriksaan.cetak_pemeriksaan_usg', $data);
	}

	public function uploadHasilEKG(Request $request,$unit, $registrasi_id)
	{
		$data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'EKG')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['unit'] = $unit;
		$data['registrasi_id']  = $registrasi_id;

		if ($request->method() == 'POST') {
			$request->validate(['file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg']);
			if(!empty($request->file('file'))){
				$filename = time().$request->file('file')->getClientOriginalName();
				$request->file('file')->move('hasil-pemeriksaan/', $filename);
			}else{
				$filename = null;
			}

			try{
				$hasillab = new HasilPemeriksaan();
				$hasillab->no_hasil_pemeriksaan = $request->no_hasil;
				$hasillab->registrasi_id = $request->registrasi_id;
				$hasillab->pasien_id = $request->pasien_id;
				$hasillab->dokter_id = $request->dokter_id;
				$hasillab->penanggungjawab = $request->penanggungjawab;
				$hasillab->tgl_pemeriksaan = $request->tgl_pemeriksaan;
				$hasillab->tgl_hasilselesai = $request->tgl_hasilselesai;
				$hasillab->keterangan = $request->keterangan;
				$hasillab->filename = $filename;
				$hasillab->user_id = Auth::user()->id;
				$hasillab->type = "EKG";
				$hasillab->save();
				Flashy::success('Berhasil upload hasil pemeriksaan!');
			}catch(Exception $e){
				Flashy::error('Gagal mengupload hasil pemeriksaan!');
			}
			return redirect()->back();
		}

		return view('emr.modules.pemeriksaan.hasil_pemeriksaan_ekg', $data);
	}

	public function uploadHasilCTG(Request $request,$unit, $registrasi_id)
	{
		$data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'CTG')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['unit'] = $unit;
		$data['registrasi_id']  = $registrasi_id;

		if ($request->method() == 'POST') {
			$request->validate(['file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg']);
			if(!empty($request->file('file'))){
				$filename = time().$request->file('file')->getClientOriginalName();
				$request->file('file')->move('hasil-pemeriksaan/', $filename);
			}else{
				$filename = null;
			}

			try{
				$hasillab = new HasilPemeriksaan();
				$hasillab->no_hasil_pemeriksaan = $request->no_hasil;
				$hasillab->registrasi_id = $request->registrasi_id;
				$hasillab->pasien_id = $request->pasien_id;
				$hasillab->dokter_id = $request->dokter_id;
				$hasillab->penanggungjawab = $request->penanggungjawab;
				$hasillab->tgl_pemeriksaan = $request->tgl_pemeriksaan;
				$hasillab->tgl_hasilselesai = $request->tgl_hasilselesai;
				$hasillab->keterangan = $request->keterangan;
				$hasillab->filename = $filename;
				$hasillab->user_id = Auth::user()->id;
				$hasillab->type = "CTG";
				$hasillab->save();
				Flashy::success('Berhasil upload hasil pemeriksaan!');
			}catch(Exception $e){
				Flashy::error('Gagal mengupload hasil pemeriksaan!');
			}
			return redirect()->back();
		}

		return view('emr.modules.pemeriksaan.hasil_pemeriksaan_ctg', $data);
	}


	public function hapusHasilPemeriksaan($id)
	{
		try{
            $hasilPemeriksaan = HasilPemeriksaan::find($id);
            $fileToDelete = public_path('hasil-pemeriksaan/' . $hasilPemeriksaan->filename);
            if (File::exists($fileToDelete)) {
                File::delete($fileToDelete);
            } 
            $hasilPemeriksaan->delete();
            Flashy::success('Berhasil menghapus hasil pemeriksaan!');
        }catch(Exception $e){
            Flashy::error('Gagal menghapus hasil pemeriksaan!');
        }
        return redirect()->back();
	}

	public function verifDPJP($id)
	{
		$soap = Emr::find($id);

		if (!empty($soap)) {
			$reg = Registrasi::find($soap->registrasi_id);
			$dpjp = $reg->rawat_inap->dokter_id ?? $reg->dokter_id;
			$dokter = Pegawai::find($dpjp);
			if (Auth::user()->pegawai->id == $dokter->id) {
				$soap->verifikasi_dpjp = now();
				$soap->update();
				Flashy::success('Berhasil memverifikasi DPJP');
			} else {
				Flashy::error('Hanya DPJP yang dapat memverifikasi');
			}
		}

		return redirect()->back();
	}

	public function verifPengalihan($id)
	{
		$emr = EmrInapPerencanaan::find($id);

		$emr->verifikasi = now();
		$emr->save();

		Flashy::success('Berhasil diverifikasi');
		return redirect()->back();
	}

	//SBAR
	public function SBAR(Request $request, $unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		$data['registrasi_id']  = $registrasi_id;
		$data['reg']            = Registrasi::find($registrasi_id);
		$dokter					= Pegawai::find($data['reg']->dokter_id);
		$data['unit']           = $unit;
		$data['source'] 		= $request->get('source');

		$data['resume']         = Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', 'sbar')->first();
		$data['all_resume']     = Emr::where('pasien_id', @$data['reg']->pasien->id)->where('unit', 'sbar')->orderBy('id', 'DESC')->get();
		$data['emr']			= Emr::find($id_soap);
		$data['cppt']			= Emr::where('registrasi_id', $registrasi_id)->where('unit', '!=', 'sbar')->where('user_id', '!=', $dokter->user_id)->latest()->first(); // Perawat
		$data['kamar']			= Kamar::pluck('nama');

		//Update baru - mengatasi user dokter yg mengisi cppt selain dpjp
        $poli = Poli::find($data['reg']->poli_id, ['dokter_id']);
        $dokterPoli = preg_split("/\,/", $poli->dokter_id);
		$userDokterPoli = Pegawai::whereIn('id', $dokterPoli)->pluck('user_id');
        $data['cpptPerawat'] = Emr::where('registrasi_id', $data['reg']->id)->whereNotIn('user_id', $userDokterPoli)->latest()->first();

		// Diagnosa diambil dari aswal medis dokter
		if ($unit == "jalan") {
			$aswal = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'like', 'fisik_%')->where('type', 'not like', '%perawat')->first();
			$dataAswal = json_decode(@$aswal->fisik, true);
			$data['diagnosa'] = @$dataAswal['diagnosis'];
			$data['sbar_tipe'] = "sbar-jalan";
		} elseif ($unit == "inap") {
			$aswal = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_dokter())->first();
			$dataAswal = json_decode(@$aswal->fisik, true);
			$data['diagnosa'] = @$dataAswal['diagnosa'];
			$data['sbar_tipe'] = "sbar-inap-" . $request['sbar_tipe'];
		} elseif ($unit == "igd") {
			$aswal = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->first();
			$dataAswal = json_decode(@$aswal->fisik, true);
			$data['diagnosa'] = @$dataAswal['igdAwal']['diagnosa'];
			$data['sbar_tipe'] = "sbar-igd";
		}
		$data['aswal'] = $aswal; 
		$data['dataAswal'] = $dataAswal; 

		return view('emr.modules.sbar_new', $data);
	}

	public function updateSBAR(Request $request)
	{
		$create = Emr::find($request->emr_id);
		if ($create) {
			$create->situation = $request->situation;
			$create->background = $request->background;
			$create->assesment = $request->assesment;
			$create->recomendation = $request->recomendation;
			$create->save();
		}
		Flashy::success('SBAR berhasil di diedit !');
		return redirect()->back();
	}

	public function duplicateSBAR($id,$dpjp,$poli,$reg_id)
	{

		$find = Emr::find($id);
		if ($find) {
			
			$create = new Emr();
			$create->registrasi_id = $reg_id;
			$create->pasien_id = @$find->pasien_id;
			$create->situation = @$find->situation;
			$create->background = @$find->background;
			$create->assesment = @$find->assesment;
			$create->recomendation = @$find->recomendation;
			$create->dokter_id = @$dpjp;
			$create->poli_id = @$poli;
			$create->user_id = Auth::user()->id;
			$create->unit = 'sbar';
			$create->save();
			Flashy::success('SBAR berhasil di duplikat, silahkan mengedit data');
		}

		// KALAU REGISTRASI SEBELUMNYA SUDAH DIHAPUS MAKA AMBIL ID REGISTRASI YG SEKARANG
		$cek_reg = Registrasi::where('id',$find->registrasi_id)->first();
		if(!$cek_reg){
			$find->registrasi_id = $reg_id;
		}
		// return redirect('/emr/soap/'.$create->unit.'/'.$find->registrasi_id.'/'.$create->id.'/edit?poli='.$poli.'&dpjp='.$dpjp);
		return redirect()->back();
	}

	public function saveSBAR(Request $request)
	{
		$create = new Emr();
		$create->registrasi_id = $request->registrasi_id;
		$create->pasien_id = $request->pasien_id;
		$create->situation = $request->situation;
		$create->background = $request->background;
		$create->assesment = $request->assesment;
		$create->recomendation = $request->recomendation;
		$create->discharge = $request->discharge;
		$create->keterangan = $request->alasan_dirawat.'|'.$request->alasan_pindah;
		$create->unit = 'sbar';
		$create->dokter_id = Auth::user()->id;
		$create->poli_id = @$request->poli_id;
		$create->user_id = Auth::user()->id;
		// $create->keterangan = $request->kondisi;
		$create->save();
	
		Flashy::success('SBAR berhasil di input !');
		return redirect()->back();
	}

	public function saveSBARNew(Request $request)
	{
		$create = new Emr();
		$create->registrasi_id = $request->registrasi_id;
		$create->pasien_id = $request->pasien_id;
		$create->situation = @is_array(@$request->situation) ? json_encode(@$request->situation) : @$request->situation;
		$create->background = @is_array(@$request->background) ? json_encode(@$request->background) : @$request->background;
		$create->assesment = @is_array(@$request->assesment) ? json_encode(@$request->assesment) : @$request->assesment;
		$create->recomendation = @is_array(@$request->recomendation) ? json_encode(@$request->recomendation) : @$request->recomendation;
		$create->ekstra = @is_array(@$request->ekstra) ? json_encode(@$request->ekstra) : @$request->ekstra;
		$create->unit = 'sbar';
		$create->dokter_id = Auth::user()->id;
		$create->poli_id = @$request->poli_id;
		$create->user_id = Auth::user()->id;
		// $create->keterangan = $request->kondisi;
		$create->save();
	
		Flashy::success('SBAR berhasil di input !');
		return redirect()->back();
	}

	public function duplicateSBARNew($id, $reg_id)
	{

		$find = Emr::find($id);
		if ($find) {
			
			$create = new Emr();
			$create->registrasi_id = $reg_id;
			$create->pasien_id = @$find->pasien_id;
			$create->situation = @$find->situation;
			$create->background = @$find->background;
			$create->assesment = @$find->assesment;
			$create->recomendation = @$find->recomendation;
			$create->ekstra = @$find->ekstra;
			$create->dokter_id = @$find->dokter_id;
			$create->poli_id = @$find->poli_id;
			$create->user_id = Auth::user()->id;
			$create->unit = 'sbar';
			$create->save();
			Flashy::success('SBAR berhasil di duplikat, silahkan mengedit data');
		}

		// KALAU REGISTRASI SEBELUMNYA SUDAH DIHAPUS MAKA AMBIL ID REGISTRASI YG SEKARANG
		$cek_reg = Registrasi::where('id',$find->registrasi_id)->first();
		if(!$cek_reg){
			$find->registrasi_id = $reg_id;
		}
		// return redirect('/emr/soap/'.$create->unit.'/'.$find->registrasi_id.'/'.$create->id.'/edit?poli='.$poli.'&dpjp='.$dpjp);
		return redirect()->back();
	}

	public function updateSBARNew(Request $request)
	{
		$create = Emr::find($request->emr_id);
		if ($create) {
			$create->situation = @is_array(@$request->situation) ? json_encode(@$request->situation) : @$request->situation;
			$create->background = @is_array(@$request->background) ? json_encode(@$request->background) : @$request->background;
			$create->assesment = @is_array(@$request->assesment) ? json_encode(@$request->assesment) : @$request->assesment;
			$create->recomendation = @is_array(@$request->recomendation) ? json_encode(@$request->recomendation) : @$request->recomendation;
			$create->ekstra = @is_array(@$request->ekstra) ? json_encode(@$request->ekstra) : @$request->ekstra;
			$create->save();
		}
		Flashy::success('SBAR berhasil di diedit !');
		return redirect()->back();
	}

	public function deleteSBAR($unit, $regId, $idSoap)
	{
		$unit = $unit;
		$reg = Registrasi::find($regId);
		$emr = Emr::find($idSoap);
		$emr->delete();

		Flashy::success('Berhasil Menghapus Data');
		return redirect()->back();
	}

	public function cetakSBARNew($id)
	{
		$sbar = Emr::find($id);
		$pegawai = Pegawai::where('user_id', $sbar->user_id)->first();
		$registrasi = Registrasi::find($sbar->registrasi_id);
		$emr = $sbar;
		$pdf = PDF::loadView('emr._cetak_sbar_new', compact('sbar','registrasi', 'pegawai', 'emr'));
		$pdf->setPaper('A4', 'portrait');
		return $pdf->stream('sbar-laporan.pdf');
	}

	public function operasiMain(Request $r, $unit, $registrasi_id, $record_id = null, $method = null)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		return view('emr.modules.pemeriksaan.inap.operasi.main', $data);
	}

	public function formKriteriaMasukICU(Request $r, $unit, $reg_id)
	{
		$data['registrasi_id'] 	= $reg_id;
		$data['reg'] 			= Registrasi::where('id', $reg_id)->first();
		$data['pasien'] 		= Pasien::find($data['reg']->pasien_id);
		$data['unit']   		= $unit;
		$data['riwayats'] 		= EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'kriteria-masuk-icu')->orderBy('id', 'DESC')->get();

		if ($r->filled('asessment_id')) {
			$data['riwayat'] = EmrInapPemeriksaan::find($r->asessment_id);
			$data['assesment'] = json_decode($data['riwayat']->fisik, true);
		} else {
			$data['riwayat'] = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'kriteria-masuk-icu')->orderBy('id', 'DESC')->first();
			if (!empty($data['riwayat'])) {
				$data['assesment'] = json_decode($data['riwayat']->fisik, true);
			} else {
				$data['assesment'] = [];
			}
		}

		if ($r->method() == 'POST') {
			$asessment = new EmrInapPemeriksaan();
			$asessment->pasien_id = $r->pasien_id;
			$asessment->registrasi_id = $r->registrasi_id;
			$asessment->user_id = Auth::user()->id;
			$asessment->fisik = json_encode($r->fisik);
			$asessment->type = 'kriteria-masuk-icu';
			$asessment->save();
			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
        }

		return view('emr.modules.formKriteriaMasukICU', $data);
	}

	public function cetakKriteriaMasukICU($unit, $reg_id, $id)
    {
        $cetak = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($reg_id);
		$unit = $unit;
        $dokter = Pegawai::find($reg->dokter_id);

        $pdf = PDF::loadView('emr.modules._cetak_kriteria_masuk_icu', compact('reg', 'cetak', 'unit', 'dokter'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('kriteria_masuk_icu.pdf');
    }

	public function formKriteriaKeluarICU(Request $r, $unit, $reg_id)
	{
		$data['registrasi_id'] 	= $reg_id;
		$data['reg'] 			= Registrasi::where('id', $reg_id)->first();
		$data['pasien'] 		= Pasien::find($data['reg']->pasien_id);
		$data['unit']   		= $unit;
		$data['riwayats'] 		= EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'kriteria-keluar-icu')->orderBy('id', 'DESC')->get();

		if ($r->filled('asessment_id')) {
			$data['riwayat'] = EmrInapPemeriksaan::find($r->asessment_id);
			$data['assesment'] = json_decode($data['riwayat']->fisik, true);
		} else {
			$data['riwayat'] = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'kriteria-keluar-icu')->orderBy('id', 'DESC')->first();
			if (!empty($data['riwayat'])) {
				$data['assesment'] = json_decode($data['riwayat']->fisik, true);
			} else {
				$data['assesment'] = [];
			}
		}

		if ($r->method() == 'POST') {
			$asessment = new EmrInapPemeriksaan();
			$asessment->pasien_id = $r->pasien_id;
			$asessment->registrasi_id = $r->registrasi_id;
			$asessment->user_id = Auth::user()->id;
			$asessment->fisik = json_encode($r->fisik);
			$asessment->type = 'kriteria-keluar-icu';
			$asessment->save();
			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
        }

		return view('emr.modules.formKriteriaKeluarICU', $data);
	}

	public function cetakKriteriaKeluarICU($unit, $reg_id, $id)
    {
        $cetak = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($reg_id);
		$unit = $unit;
        $dokter = Pegawai::find($reg->dokter_id);

        $pdf = PDF::loadView('emr.modules._cetak_kriteria_keluar_icu', compact('reg', 'cetak', 'unit', 'dokter'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('kriteria_keluar_icu.pdf');
    }
}