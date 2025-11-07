<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use Modules\Icd10\Entities\Icd10;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;
use App\FaskesLanjutan;
use PDF;
use App\BpjsProv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\BpjsKab;
use App\BpjsKec;
use App\BpjsKecamatan;
use App\DokumenRekamMedis;
use App\echocardiogram;
use App\FolioMulti;
use App\Hasillab;
use App\HistorikunjunganIRJ;
use Yajra\DataTables\DataTables;
use Validator;
use MercurySeries\Flashy\Flashy;
use \App\HistoriSep;
use App\Penjualan;
use App\EmrInapPerencanaan;
use App\RadiologiEkspertise;
use App\RecordSatuSehat;
use App\Satusehat;
use App\RegistrasiDummy;
use App\RencanaKontrol;
use Illuminate\Support\Facades\Auth;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\BiayaPemeriksaan;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Tarif\Entities\Tarif;

class AdmissionController extends Controller {
	
	public function index() {
		//dd('tets1');
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
		$data['total_bed'] = Bed::count();
		$data['sisa_bed'] = Bed::where('reserved', 'N')->count();
		$data['bed'] = Bed::where('reserved', 'N')->get();
		$data['reg'] = Registrasi::with('pasien')->where('created_at', 'like', date('Y-m-d') . '%')->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4', 'G1', 'G2', 'G3', 'G4'])->get();
		$data['spri'] = EmrInapPerencanaan::whereIn('registrasi_id', $data['reg']->pluck('id'))
			->where('type', 'rujukan')
			->orderBy('id', 'DESC')
			->get()
			->keyBy('registrasi_id');
		// $data['reg'] = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')->whereIn('status_reg', ['G1', 'G2', 'G3', 'G4'])->get();
		return view('admission.index', $data)->with('no', 1);
	}

	public function admissionByTanggal(Request $request) {
		//dd('tets2');
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
		request()->validate(['tga' => 'required']);
		$data['total_bed'] = Bed::count();
		$data['sisa_bed'] = Bed::where('reserved', 'N')->count();
		$data['bed'] = Bed::where('reserved', 'N')->get();
		$data['reg'] = Registrasi::with('pasien')->where('created_at', 'like', valid_date($request['tga']) . '%')->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4', 'G1', 'G2', 'G3', 'G4'])->get();
		$data['spri'] = EmrInapPerencanaan::whereIn('registrasi_id', $data['reg']->pluck('id'))
			->where('type', 'rujukan')
			->orderBy('id', 'DESC')
			->get()
			->keyBy('registrasi_id');
		// $data['reg'] = Registrasi::where('created_at', 'like', valid_date($request['tga']) . '%')->whereIn('status_reg', ['G1', 'G2', 'G3', 'G4'])->get();
		return view('admission.index', $data)->with('no', 1);
	}

	public function proses($id = '') {
		$reg = Registrasi::find($id);
		$reg->status_reg = 'I1';
		$reg->update();
        $histori = new HistoriStatus();
        $histori->registrasi_id = $reg->id;
        $histori->status = 'I1';
        $histori->poli_id = $reg->poli_id;
        $histori->user_id = Auth::user()->id;
        $histori->save();
		Flashy::success('Pasien masuk daftar Antrian Rawat Inap');
		return redirect('rawat-inap/admission');
	}

	public function sepSusulanIRNA() {
		$date = date('Y-m-d', strtotime('-5 days'));
		$data['antrian'] =Registrasi::where('bayar', 1)
		->whereBetween('created_at', [ $date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		->whereIn('status_reg', ['I1', 'I2'])
		->orderby('id','DESC')
		->get();
		// return $data['antrian'];die;
		//$data['reg']    = Registrasi::find($id);
		$data['bpjsprov']	= BpjsProv::all();
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('admission.sep_susulan_irna', $data)->with('no', 1);
	}

	public function sepSusulanIRNAByTanggal(Request $request)
	{
		$data['antrian'] = Registrasi::where('created_at', 'like', valid_date($request['tga']) . '%')
		->where('bayar', 1)
		->whereIn('status_reg', ['I1', 'I2'])
		->orderby('id','DESC')
		->get();
		// return $data['antrian'];die;
		//$data['reg']    = Registrasi::find($id);
		$data['bpjsprov']	= BpjsProv::all();
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('admission.sep_susulan_irna', $data)->with('no', 1);
	}

	public function sepSusulanIRJ()
	{

		// $date = date('Y-m-d', strtotime('-1 days'));

		// $data['reg'] = Registrasi::where('no_sep', NULL)
		
		// ->where('created_at', 'like', date('Y-m-d') . '%')
		// // ->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// ->where('bayar', 1)
		// ->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4'])
		// // ->take(10)
		// ->get();
		return view('admission.sep_susulan_irj')->with('no', 1);
	}
	public function dataRawatJalan(Request $req)
	{
		$keyCache = 'sep_susulan_irj';
		if($req->filled('keyword')){
			$d = Registrasi::leftJoin('pasiens', 'pasiens.id', 'registrasis.pasien_id')
				->where(function ($query) use($req){
					$query->where('pasiens.no_rm', $req->keyword)
						->orWhere('pasiens.nama', 'LIKE', "%$req->keyword%");
				})
				->where('registrasis.status_reg', 'like', 'J%')
				->where('registrasis.bayar', 1)
				->where('registrasis.no_sep', NULL)
				->orderBy('registrasis.id', 'DESC')
				->select('registrasis.*','registrasis.id as id')
				->limit(5)
				->get();
		}else{
			$d = Cache::get($keyCache);
			if(!$d){
				$d = Registrasi::where('no_sep', NULL)
				
				->where('created_at', 'like', date('Y-m-d') . '%')
				->where('bayar', 1)
				->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4'])
				->get();
				Cache::put($keyCache,$d,120); //BUAT CACHE 2 menit
			}
		}

		return DataTables::of($d)
		
			->addColumn('nama', function ($d) {
				return @$d->pasien->nama;
			})
			->addColumn('no_rm', function ($d) {
				return @$d->pasien->no_rm;
			})
			->addColumn('dokter', function ($d) {
				return @baca_dokter($d->dokter_id);
			})
			->addColumn('poli', function ($d) {
				return @$d->poli->nama;
			})
			->addColumn('cara_bayar', function ($d) {
				return @$d->bayars->carabayar.' ' .@$d->tipe_jkn;
			})
			->addColumn('tanggal', function ($d) {
				return @$d->created_at->format('d-m-Y');
			})
			->addColumn('aksi', function ($d) {
				return '<a href="'.url('/form-sep-susulan/'.$d->id).'" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>';
			}) 
			->rawColumns(['aksi'])
			->addIndexColumn()
			->make(true);
	}

	public function sepSusulanIRJByTanggal(Request $request)
	{
		$data['reg'] = Registrasi::where('no_sep', NULL)
		->where('created_at', 'like', valid_date($request['tga']) . '%')
		->where('bayar', 1)
		->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4'])
		// ->take(10)
		->get();
		return view('admission.sep_susulan_irj', $data)->with('no', 1);
	}

	public function sepSusulanIGD()
	{
		$data['reg'] = Registrasi::where('no_sep', NULL)
		->where('bayar',1)
		->where('created_at', 'like', date('Y-m-d') . '%')
		->whereIn('status_reg', ['G1', 'G2', 'G3', 'G4'])
		// ->take(10)
		->get();
		return view('admission.sep_susulan_igd', $data)->with('no', 1);
	}

	public function sepSusulanIGDByTanggal(Request $request)
	{
		$data['reg'] = Registrasi::where('no_sep', NULL)
		->where('created_at', 'like', valid_date($request['tga']) . '%')
		->where('bayar', 1)
		->whereIn('status_reg', ['G1', 'G2', 'G3', 'G4'])
		// ->take(10)
		->get();
		return view('admission.sep_susulan_igd', $data)->with('no', 1);
	}

	public function formSEP_igd_irj($reg_id = '')
	{
		$registrasi_id =  $reg_id;
		$data['poli'] = Poli::select('nama', 'bpjs')->get();
		$data['bpjsprov'] = BpjsProv::select('propinsi', 'kode')->get();
		$data['bpjskab'] = BpjsKab::pluck('kabupaten', 'kode');
		$data['bpjskec'] = BpjsKec::pluck('kecamatan', 'kode');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'kode_bpjs')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['surkon'] = RencanaKontrol::where('pasien_id',@$data['reg']->pasien_id)->orderBy('id','DESC')->limit(10)->get();
		$data['poli_bpjs'] = Poli::find(@$data['reg']->poli_id)->bpjs;
		$data['dokter_bpjs'] = Pegawai::find(@$data['reg']->dokter_id)->kode_bpjs;
		$data['kd_ppk'] = FaskesLanjutan::all();
		$data['noKartu'] = @$data['reg']->pasien->no_jkn;

		if(isset($data['reg'])){
			if($data['reg']->nomorantrian){
				if(status_consid(4)){
					if($data['reg']->pasien->no_jkn){
						@$no_surkons = @cekNoSurkon($data['reg']->pasien->no_jkn);
						if(@$no_surkons[1]['list'][0]['tglRencanaKontrol'] == date('Y-m-d')){
							@$data['no_surkon'] = @$no_surkons[1]['list'][0]['noSuratKontrol'];
						}
					}
				}

				$ID = config('app.consid_antrean');
				date_default_timezone_set('Asia/Jakarta');
				$t = time();
				$dat = "$ID&$t";
				$secretKey = config('app.secretkey_antrean');
				$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
				$completeurl = config('app.antrean_url_web_service')."antrean/updatewaktu";
				$arrheader = array(
					'X-cons-id: ' . $ID,
					'X-timestamp: ' . $t,
					'X-signature: ' . $signature,
					'user_key:'. config('app.user_key_antrean'),
					'Content-Type: application/json',
				);
				if(status_consid(4)){
					$updatewaktu   = '{
						"kodebooking": "'.@$data['reg']->nomorantrian.'",
						"taskid": "4",
						"waktu": "'.round(microtime(true) * 1000).'"
					}';
					$session2 = curl_init($completeurl);
					curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
					curl_setopt($session2, CURLOPT_POST, TRUE);
					curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
					curl_exec($session2);

				}
				// sleep(3);
				
				if(status_consid(5)){
					$updatewaktu5   = '{
						"kodebooking": "'.@$data['reg']->nomorantrian.'",
						"taskid": "5",
						"waktu": "'.round(microtime(true) * 1000).'"
					}';
					$session5 = curl_init($completeurl);
					curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
					curl_setopt($session5, CURLOPT_POST, TRUE);
					curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
					curl_exec($session5);

				}
				// sleep(3);
			}
		}
		
		if (substr($data['reg']->status_reg, 0, 1) == 'G') {
			return view('admission.form_igd', $data);
		} else {
			return view('admission.form_irj', $data);
		}
	}
	public function formSEP_igd_irj_online($reg_id = '')
	{
		$registrasi_id =  $reg_id;
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['surkon'] = RencanaKontrol::where('pasien_id',@$data['reg']->pasien_id)->groupBy('no_surat_kontrol')->orderBy('id','DESC')->limit(10)->get();
		$dataOnline = RegistrasiDummy::where('registrasi_id',$reg_id)->first();
		$data['rujukan'] = cekRujukan($dataOnline->no_rujukan);
		$data['poli_bpjs'] = Poli::find($data['reg']->poli_id)->bpjs;
		if($data['rujukan'][0]['metaData']['code'] == '200'){
			$data['rujukan'] = cekRujukan($dataOnline->no_rujukan)[1]['rujukan'];
			$poli_kode = $data['rujukan']['poliRujukan']['kode'];
		}else{
			$poli_kode = $data['poli_bpjs'];
		}
		
		
		$data['poli'] = Poli::select('nama', 'bpjs')->get();
		$data['bpjsprov'] = BpjsProv::select('propinsi', 'kode')->get();
		$data['bpjskab'] = BpjsKab::pluck('kabupaten', 'kode');
		$data['bpjskec'] = BpjsKec::pluck('kecamatan', 'kode');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'kode_bpjs')->get();
		
		
		// $data['dokter_bpjs'] = Pegawai::find($data['reg']->dokter_id)->kode_bpjs;
		
		$pol = Poli::where('bpjs',$poli_kode)->first();
		$dokter_id = [];

		// foreach($pol->dokter_id as $pol) {
        //     $dokter_id[] = $pol;
        // }

		$dokter_id = explode(",",$pol->dokter_id);
		$data['dokter'] = Pegawai::whereIn('id',$dokter_id)->get();
		$data['dokter_bpjs'] = Pegawai::whereIn('id',$dokter_id)->get();
		$data['kd_ppk'] = FaskesLanjutan::all();
		if (substr($data['reg']->status_reg, 0, 1) == 'G') {
			return view('admission.form_igd_online', $data);
		} else {
			return view('admission.form_irj_online', $data);
		}
	}

	public function faskesLanjut($kode_ppk)
	{
		$bpjskab = FaskesLanjutan::where('kode_ppk', $kode_ppk)->pluck('kode_ppk', 'nama_ppk');
		return json_encode($bpjskab);
	}

	public function getDataRawatInap($registrasi_id) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
		$data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			// ->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->join('carabayars', 'registrasis.bayar', '=', 'carabayars.id')
			->where('registrasis.id', $registrasi_id)
			->select(
				DB::raw('DATE(registrasis.created_at) as tgl'),
				'registrasis.id', 'registrasis.pasien_id', 'registrasis.bayar', 'registrasis.dokter_id', 'pasiens.no_rm', 'pasiens.nama', 'pasiens.nik', 'pasiens.no_jkn', 'carabayars.carabayar as pembayaran')
			->first();
		return response()->json($data);
	}

	public function saveSEPirna(Request $request) {
		// return $request->all();
		$validator = Validator::make($request->all(), [
			'no_sep' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['error' => 'sep_kosong']);
		}
		$reg = Registrasi::find($request['registrasi_id']);
		$reg->no_sep = $request['no_sep'];
		$reg->diagnosa_awal = $request['diagnosa_awal'];
		$reg->hak_kelas_inap = $request['hak_kelas_inap'];
		$reg->update();

		$pasien = \Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
		$pasien->nik = !empty($request['nik']) ? $request['nik'] : $pasien->nik;
		$pasien->nohp = !empty($request['no_tlp']) ? $request['no_tlp'] : $pasien->nohp;
		$pasien->no_jkn = !empty($request['no_bpjs']) ? $request['no_bpjs'] : $pasien->no_jkn;
		$pasien->update();

		if (!empty($request['no_sep'])) {
			session(['no_sep' => $request['no_sep']]);
		}



		$historisep = new HistoriSep();
		$historisep->nik = (!empty($request['nik'])) ? $request['nik'] : NULL;
		$historisep->registrasi_id = (!empty($request['registrasi_id'])) ? $request['registrasi_id'] : NULL;
		$historisep->namapasien = (!empty($request['namaPasien'])) ? $request['namaPasien'] : NULL;
		$historisep->nama_kartu = (!empty($request['nama'])) ? $request['nama'] : NULL;
		$historisep->nama_ppk_perujuk = (!empty($request['nama_ppk_perujuk'])) ? $request['nama_ppk_perujuk'] : NULL;
		$historisep->kode_ppk_perujuk = (!empty($request['kode_ppk_perujuk'])) ? $request['kode_ppk_perujuk'] : NULL;
		$historisep->no_rm = (!empty($request['no_rm'])) ? $request['no_rm'] : NULL;
		$historisep->no_bpjs = (!empty($request['no_bpjs'])) ? $request['no_bpjs'] : NULL;
		$historisep->no_tlp = (!empty($request['no_tlp'])) ? $request['no_tlp'] : NULL;
		$historisep->tgl_rujukan = (!empty($request['tgl_rujukan'])) ? $request['tgl_rujukan'] : NULL;
		$historisep->no_rujukan = (!empty($request['no_rujukan'])) ? $request['no_rujukan'] : NULL;
		$historisep->ppk_rujukan = (!empty($request['ppk_rujukan'])) ? $request['ppk_rujukan'] : NULL;
		$historisep->nama_perujuk = (!empty($request['nama_perujuk'])) ? $request['nama_perujuk'] : NULL;
		$historisep->diagnosa_awal = (!empty($request['diagnosa_awal'])) ? $request['diagnosa_awal'] : NULL;
		$historisep->jenis_layanan = (!empty($request['jenis_layanan'])) ? $request['jenis_layanan'] : NULL;
		$historisep->asalRujukan = (!empty($request['asalRujukan'])) ? $request['asalRujukan'] : NULL;
		$historisep->hak_kelas_inap = (!empty($request['hak_kelas_inap'])) ? $request['hak_kelas_inap'] : NULL;
		$historisep->katarak = (!empty($request['katarak'])) ? $request['katarak'] : NULL;
		$historisep->tglSep = (!empty($request['tglSep'])) ? $request['tglSep'] : NULL;
		$historisep->tipe_jkn = (!empty($request['tipe_jkn'])) ? $request['tipe_jkn'] : NULL;
		$historisep->poli_bpjs = (!empty($request['poli_bpjs'])) ? $request['poli_bpjs'] : NULL;
		$historisep->noSurat = (!empty($request['noSurat'])) ? $request['noSurat'] : NULL;
		$historisep->kodeDPJP = (!empty($request['kodeDPJP'])) ? $request['kodeDPJP'] : NULL;
		$historisep->laka_lantas = (!empty($request['laka_lantas'])) ? $request['laka_lantas'] : NULL;
		$historisep->penjamin = (!empty($request['penjamin'])) ? $request['penjamin'] : NULL;
		$historisep->no_lp = (!empty($request['no_lp'])) ? $request['no_lp'] : NULL;
		$historisep->tglKejadian = (!empty($request['tglKejadian'])) ? $request['tglKejadian'] : NULL;
		$historisep->kll = (!empty($request['kll'])) ? $request['kll'] : NULL;
		$historisep->suplesi = (!empty($request['suplesi'])) ? $request['suplesi'] : NULL;
		$historisep->noSepSuplesi = (!empty($request['noSepSuplesi'])) ? $request['noSepSuplesi'] : NULL;
		$historisep->kdPropinsi = (!empty($request['kdPropinsi'])) ? $request['kdPropinsi'] : NULL;
		$historisep->kdKabupaten = (!empty($request['kdKabupaten'])) ? $request['kdKabupaten'] : NULL;
		$historisep->kdKecamatan = (!empty($request['kdKecamatan'])) ? $request['kdKecamatan'] : NULL;
		$historisep->no_sep = (!empty($request['no_sep'])) ? $request['no_sep'] : NULL;
		$historisep->carabayar_id = (!empty($request['carabayar_id'])) ? $request['carabayar_id'] : NULL;
		$historisep->catatan_bpjs = (!empty($request['catatan_bpjs'])) ? $request['catatan_bpjs'] : NULL;
		$historisep->cob = (!empty($request['cob'])) ? $request['cob'] : NULL;
		$historisep->dokter_id = (!empty($request['dokter_id'])) ? $request['dokter_id'] : NULL;
		$historisep->​kodeDPJP = (!empty($request['​kodeDPJP'])) ? $request['​kodeDPJP'] : NULL;
		$historisep->save();

		Flashy::success('SEP Susulan Rawat inap berhasil disimpan');
		return response()->json(['success' => '1']);
	}

	public function saveSEP_irj_igd(Request $request)
	{				

		request()->validate(['no_sep' => 'required']);
		$registrasi_id = $request['registrasi_id'];
		$reg = Registrasi::find($registrasi_id);

		$pasien = Pasien::find(@$reg->pasien_id);
		

		//GET PATIENT BY NIK
		if (Satusehat::find(1)->aktif == 1) {
			if(satusehat() && $pasien) {
				if(!$pasien->id_patient_ss){
					@$id_ss = SatuSehatController::PatientGet(@$reg->pasien->nik);
					if(empty(@$id_ss)){
						$request['nik'] = $request['nik']?$request['nik']:$request['niks'];
						@$id_ss = SatuSehatController::PatientGet(@$request['nik'] ? @$request['nik']:@$reg->pasien->nik);
					}
					// $id_ss = SatuSehatController::PatientGet(@$request->nik);
					if(@$id_ss){
						$pasien->id_patient_ss = @$id_ss;
						if(!$pasien->nik){
							$pasien->nik = @$request['nik'] ?@$request['nik'] :@$reg->pasien->nik;

						}
						$pasien->save();

					}

				}
			}
		}
		
		if(satusehat()) {
			if (Satusehat::find(1)->aktif == 1) {
				if($reg->status_reg == 'J1' && @$reg->id_encounter_ss == NULL){
					$reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'sep_susulan');
					$reg->update();
				}
			}
		}

		
		$reg->no_sep = $request['no_sep'];
		$reg->tgl_rujukan = $request['tgl_rujukan'];
		$reg->no_rujukan = $request['no_rujukan'];
		$reg->ppk_rujukan = $request['ppk_rujukan'] . '|' . $request['nama_perujuk'];
		$reg->diagnosa_awal = $request['diagnosa_awal'];
		$reg->tgl_sep = $request['tglSep'];
		$reg->poli_bpjs = $request['poli_bpjs'];
		if(isset($request['kodeDPJP'])){
			if($request['kodeDPJP'] !== null){
				@$dpjp = Pegawai::where('kode_bpjs',$request['kodeDPJP'])->first();
				if(@$dpjp){
					@$reg->dokter_id = @$dpjp->id;
					@$updatehistori = HistorikunjunganIRJ::where('registrasi_id',@$reg->id)->orderBy('id','DESC')->first();
					if(@$updatehistori){
						@$updatehistori->dokter_id = @$dpjp->id;
						@$updatehistori->save();
					}
				}
			}

		}
		$reg->hakkelas = $request['hak_kelas_inap'];
		$reg->nomorrujukan = $request['no_rujukan'];
		$reg->catatan = $request['catatan_bpjs'];
		$reg->kecelakaan = $request['laka_lantas'];
		$reg->no_jkn = $request['no_bpjs'];
		$reg->update();


		if(isset($request['billing'])){
			$retri = [];
			// dd('B');

			// CEK RETRIBUSI PASIEN BARU 
			$retri1 = BiayaPemeriksaan::where('tipe',cek_status_reg($reg->status_reg))->where('pasien','pasien_lama')->whereNull('poli_id')->get();
			if(count($retri1) >0){
				foreach($retri1 as $i){
					$retri[] = $i->tarif_id;
				}
			}
			// CEK RETRIBUSI PASIEN BARU SESUAI POLI
			$retri2 = BiayaPemeriksaan::where('tipe',cek_status_reg($reg->status_reg))->where('pasien','pasien_lama')->where('poli_id',$reg->poli_id)->get();
			if(count($retri2) >0){
				foreach($retri2 as $i){
					$retri[] = $i->tarif_id;
				}
			}

			if (cek_status_reg($reg->status_reg) == 'G' || $reg->status_reg == 'I1' ||$reg->status_reg == 'I2'||$reg->status_reg == 'I3') {
				$pelaksana_tipe = 'TG';
			} else {
				$pelaksana_tipe = 'TA';
			}
			// dd($retri);
			foreach($retri as $key=>$value){
				$created_at = date('Y-m-d H:i:s');
				$tarif  = Tarif::where('id',$value)->first();
				FolioMulti::create([
					'registrasi_id'    => @$reg->id,
					'poli_id'          => @$reg->poli_id,
					'lunas'            => 'N',
					'namatarif'        => @$tarif->nama,
					'dijamin'          => @$request['dijamin'],
					'tarif_id'         => @$tarif->id,
					'cara_bayar_id'    => @$reg->bayar,
					'jenis'            => @$tarif->jenis,
					'poli_tipe'        => cek_status_reg($request['status_reg']),
					'total'            => @$tarif->total,
					'jenis_pasien'     => @$reg->jenis_pasien,
					'pasien_id'        => @$reg->pasien_id,
					'dokter_id'        => @$reg->dokter_id,
					'user_id'          => Auth::user()->id,
					'mapping_biaya_id' => @$tarif->mapping_biaya_id,
					'dpjp'             => @$reg->dokter_id,
					'dokter_pelaksana' => @$reg->dokter_id,
					'pelaksana_tipe'   => @$pelaksana_tipe,
					'created_at'       => @$created_at
				]);
			}
		}


		$historisep = new HistoriSep();
		$historisep->nik = (!empty($request['nik'])) ? $request['nik'] : NULL;
		$historisep->registrasi_id = (!empty($request['registrasi_id'])) ? $request['registrasi_id'] : NULL;
		$historisep->namapasien = (!empty($request['namapasien'])) ? $request['namapasien'] : NULL;
		$historisep->nama_kartu = (!empty($request['nama'])) ? $request['nama'] : NULL;
		$historisep->nama_ppk_perujuk = (!empty($request['nama_ppk_perujuk'])) ? $request['nama_ppk_perujuk'] : NULL;
		$historisep->kode_ppk_perujuk = (!empty($request['kode_ppk_perujuk'])) ? $request['kode_ppk_perujuk'] : NULL;
		$historisep->no_rm = (!empty($request['no_rm'])) ? $request['no_rm'] : NULL;
		$historisep->no_bpjs = (!empty($request['no_bpjs'])) ? $request['no_bpjs'] : NULL;
		$historisep->no_tlp = (!empty($request['no_tlp'])) ? $request['no_tlp'] : NULL;
		$historisep->tgl_rujukan = (!empty($request['tgl_rujukan'])) ? $request['tgl_rujukan'] : NULL;
		$historisep->no_rujukan = (!empty($request['no_rujukan'])) ? $request['no_rujukan'] : NULL;
		$historisep->ppk_rujukan = (!empty($request['ppk_rujukan'])) ? $request['ppk_rujukan'] : NULL;
		$historisep->nama_perujuk = (!empty($request['nama_perujuk'])) ? $request['nama_perujuk'] : NULL;
		$historisep->diagnosa_awal = (!empty($request['diagnosa_awal'])) ? $request['diagnosa_awal'] : NULL;
		$historisep->jenis_layanan = (!empty($request['jenis_layanan'])) ? $request['jenis_layanan'] : NULL;
		$historisep->asalRujukan = (!empty($request['asalRujukan'])) ? $request['asalRujukan'] : NULL;
		$historisep->hak_kelas_inap = (!empty($request['hak_kelas_inap'])) ? $request['hak_kelas_inap'] : NULL;
		$historisep->katarak = (!empty($request['katarak'])) ? $request['katarak'] : NULL;
		$historisep->tglSep = (!empty($request['tglSep'])) ? $request['tglSep'] : NULL;
		$historisep->tipe_jkn = (!empty($request['tipe_jkn'])) ? $request['tipe_jkn'] : NULL;
		$historisep->poli_bpjs = (!empty($request['poli_bpjs'])) ? $request['poli_bpjs'] : NULL;
		$historisep->noSurat = (!empty($request['noSurat'])) ? $request['noSurat'] : NULL;
		$historisep->kodeDPJP = (!empty($request['kodeDPJP'])) ? $request['kodeDPJP'] : NULL;
		$historisep->laka_lantas = (!empty($request['laka_lantas'])) ? $request['laka_lantas'] : NULL;
		$historisep->penjamin = (!empty($request['penjamin'])) ? $request['penjamin'] : NULL;
		$historisep->no_lp = (!empty($request['no_lp'])) ? $request['no_lp'] : NULL;
		$historisep->tglKejadian = (!empty($request['tglKejadian'])) ? $request['tglKejadian'] : NULL;
		$historisep->kll = (!empty($request['kll'])) ? $request['kll'] : NULL;
		$historisep->suplesi = (!empty($request['suplesi'])) ? $request['suplesi'] : NULL;
		$historisep->noSepSuplesi = (!empty($request['noSepSuplesi'])) ? $request['noSepSuplesi'] : NULL;
		$historisep->kdPropinsi = (!empty($request['kdPropinsi'])) ? $request['kdPropinsi'] : NULL;
		$historisep->kdKabupaten = (!empty($request['kdKabupaten'])) ? $request['kdKabupaten'] : NULL;
		$historisep->kdKecamatan = (!empty($request['kdKecamatan'])) ? $request['kdKecamatan'] : NULL;
		$historisep->no_sep = (!empty($request['no_sep'])) ? $request['no_sep'] : NULL;
		$historisep->carabayar_id = (!empty($request['carabayar_id'])) ? $request['carabayar_id'] : NULL;
		$historisep->catatan_bpjs = (!empty($request['catatan_bpjs'])) ? $request['catatan_bpjs'] : NULL;
		$historisep->cob = (!empty($request['cob'])) ? $request['cob'] : NULL;
		$historisep->dokter_id = (!empty($request['dokter_id'])) ? $request['dokter_id'] : NULL;
		$historisep->​kodeDPJP = (!empty($request['​kodeDPJP'])) ? $request['​kodeDPJP'] : NULL;
		$historisep->save();

		
		$pasien = \Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
		$pasien->nik = !empty($request['nik']) ? $request['nik'] : $pasien->nik;
		$pasien->nohp = !empty($request['no_tlp']) ? $request['no_tlp'] : $pasien->nohp;
		$pasien->no_jkn = !empty($request['no_bpjs']) ? $request['no_bpjs'] : $pasien->no_jkn;
		$pasien->update();




		session()->forget('reg_id');
		if (!empty($request['no_sep'])) {
			session(['no_sep' => $request['no_sep']]);
			Flashy::success('Integrasi SEP sukses, No SEP berhasil simpan');
		}

		if (substr($reg->status_reg, 0, 1) == 'G') {
			return redirect('admission/sep-susulan/rawat-darurat');
		} else {
			return redirect('admission/sep-susulan/rawat-jalan');
		}
	}

	public function readmisi()
	{
		return view('admission/readmisi');
	}
	public function readmisiSearch(Request $request)
	{
		// $date = date('Y-m-d', strtotime('-7 days'));
		// return $request->all();
		$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->first();
		$data['reg'] = Registrasi::join('rawatinaps','rawatinaps.registrasi_id','=','registrasis.id')
		->where('registrasis.pasien_id', $data['pasien']->id)
		// ->whereBetween('rawatinaps.tgl_keluar', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		->orderby('registrasis.id','DESC')
		->select('registrasis.*','rawatinaps.tgl_masuk as tgl_masuk','rawatinaps.tgl_keluar as tgl_keluar')
		->get();
		// return $data; die;
		return view('admission/readmisi', $data)->with('no',1);
	}
	public function prosesReadmisi(Request $request)
	{
		$cekfolio = Folio::where('registrasi_id', $request->dari)->first();
		if ($cekfolio) {
			$folio = Folio::where('registrasi_id', $request->dari)->update(['registrasi_id' => $request->menuju]);
		}
		
		$ceklab = Hasillab::where('registrasi_id', $request->dari)->first();
		if ($ceklab) {
			$lab = Hasillab::where('registrasi_id', $request->dari)->update(['registrasi_id' => $request->menuju]);
		}

		$cekekspertise = RadiologiEkspertise::where('registrasi_id', $request->dari)->first();
		if ($cekekspertise) {
			$ekspertise = RadiologiEkspertise::where('registrasi_id', $request->dari)->update(['registrasi_id' => $request->menuju]);
		}

		$cekekg = echocardiogram::where('registrasi_id', $request->dari)->first();
		if ($cekekg) {
			$ekg = echocardiogram::where('registrasi_id', $request->dari)->update(['registrasi_id' => $request->menuju]);
		}

		$cekpenjualan = Penjualan::where('registrasi_id', $request->dari)->first();
		if ($cekpenjualan) {
			$penjualan = Penjualan::where('registrasi_id', $request->dari)->update(['registrasi_id' => $request->menuju]);
		}
		
		$cekdokumen	=	DokumenRekamMedis::where('registrasi_id', $request->dari)->first();
		if ($cekdokumen) {
			$dokumen = DokumenRekamMedis::where('registrasi_id', $request->dari)->update(['registrasi_id' => $request->menuju]);
		}
		$no_rm = $request->no_rm;
		Flashy::success('Readmisi berhasil!');
		return redirect('frontoffice/readmisi')->with('no_rm', $no_rm);
	}

}
