<?php

namespace Modules\Tindakan\Http\Controllers;

use App\Foliopelaksana;
use App\HistorikunjunganIGD;
use App\HistorikunjunganIRJ;
use App\Inacbgs_sementara;
use App\KondisiAkhirPasien;
use App\Orderlab;
use App\Orderradiologi;
use App\LogistikBatch;
use App\AntrianPoli;
use App\RencanaKontrol;
use App\User;
use App\Penjualan;
use	App\Rawatinap;
use App\EmrKonsul;
use Auth;
use App\Masterobat;
use App\SuratIzinPulang;
use Excel;
use PDF;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use MercurySeries\Flashy\Flashy;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Carabayar;
use App\TakaranobatEtiket;
use App\MasterEtiket;
use App\Aturanetiket;
use App\ResepNote;
use App\ResepNoteDuplicate;
use App\ResepNoteDetail;
use App\Helpers\CurlAPI;
use App\inhealthSjp;
use App\FolioMulti;
use App\Pembayaran;
use App\Penjualandetail;
use DB;
use App\Satusehat;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\EsignLog;
use App\Http\Controllers\LogUserController;
use App\TandaTangan;
use Modules\Registrasi\Entities\BiayaInfus;
use Modules\Registrasi\Entities\BiayaFarmasi;

class TindakanController extends Controller
{

	protected $client;

	public function __construct(CurlAPI $client)
	{
		$this->client = $client;
	}

	/*
	public function updateKunjunganIrj($o = ''){
		$his = HistorikunjunganIRJ::where('dokter_id', null)->limit($o)->get();
		foreach($his as $h){
			$reg = Registrasi::where(['id' => $h->registrasi_id])->first();
			if($reg){
				HistorikunjunganIRJ::where(['registrasi_id' => $h->registrasi_id])->update(['dokter_id' => $reg->dokter_id]);
			}
		}
	}*/

	public function index()
	{

		session()->forget(['dokter', 'pelaksana', 'perawat']);

		$poli_id            = Auth::user()->poli_id;
		$data['carabayar'] 	= Carabayar::all('carabayar', 'id'); 
		$poli_id            = Auth::user()->poli_id;
		$data['tga']        = now()->format('d-m-Y');
		$data['tgb']        = now()->format('d-m-Y');
		$data['filter_reg'] = 'Semua';
		$data['filter_poli'] 	= '';
		$data['dokters'] 	= Pegawai::where('kategori_pegawai', 1)->get();
		$data['registrasi']	= HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
			->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
			->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
			->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->whereNull('registrasis.deleted_at')
			->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d') . '%')
			->orderBy('histori_kunjungan_irj.created_at', 'ASC');
		$data['poli'] = [];

		if ($poli_id != '') {
			$poli_id = explode(",", $poli_id);
			$data['poli']		= Poli::whereIn('id', $poli_id)->pluck('nama', 'id');
			$data['registrasi']->whereIn('histori_kunjungan_irj.poli_id', $poli_id);
		} else {
			$data['poli'] 		= Poli::pluck('nama', 'id');
		}

		$data['registrasi'] = $data['registrasi']->select('registrasis.no_sep', 'histori_kunjungan_irj.id as id_kunjungan','pasiens.tanda_tangan', 'antrian_poli.status', 'antrian_poli.nomor as nomor_antrian', 'antrian_poli.kelompok as kelompok_antrian', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.nomorantrian_jkn', 'registrasis.input_from', 'pasiens.nama', 'pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.tgllahir',  'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'antrians.id as antrian_regis');

		if (Auth::user()->id == 570 || Auth::user()->id == 574 || Auth::user()->id == 566) {
			$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'I1', 'I2', 'I3'])->get();
		} else {
			$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])->get();
		}


		// Ordering
		$registrasiIds = $data['registrasi']->pluck('id');
		$signPads = TandaTangan::whereIn('registrasi_id', $registrasiIds)
		->where('jenis_dokumen', 'e-resume')
		->select('registrasi_id', 'id')
		->get()
		->keyBy('registrasi_id');

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
			// $resepNote = ResepNote::where('registrasi_id', $d->id)->whereNotNull('nomor')->select('id')->first();
			// $data['registrasi'][$key]['resepNoteId'] = $resepNote ? $resepNote->id : null;

			$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'jawab_konsul')->select('id')->orderBy('id', 'DESC')->first();
			if (!$konsulJawab) {
				$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'konsul_dokter')->select('id')->orderBy('id', 'DESC')->first();
			}
			$d->konsulJawabId = $konsulJawab ? $konsulJawab->id : null;
			$d->sign_pad = isset($signPads[$d->id]) ? $signPads[$d->id] : null;

		}
		$data['registrasi'] = $data['registrasi']->sortBy(function ($reg) {
			return [$reg['kelompok_'], $reg['urutan_']];
		});
		return view('tindakan::index', $data)->with('no', 1);
	}


	public function index_byTanggal(Request $request)
	{
		// dd('tindakan by tanggal');
		$poli_id                = Auth::user()->poli_id;
		$data['carabayar'] 	    = Carabayar::all('carabayar', 'id');
		// $data['tiket'] 		    = MasterEtiket::all('nama', 'id');
		// $data['cara_minum']     = Aturanetiket::all('aturan', 'id');
		// $data['takaran'] 	    = TakaranobatEtiket::all('nama', 'nama');
		$data['filter_reg'] 	= $request['filter_reg'];
		$data['filter_poli'] 	= $request['filter_poli'];
		$data['dokters'] 		= Pegawai::where('kategori_pegawai', 1)->get();
		request()->validate(['tga' => 'required']);
		request()->validate(['tgb' => 'required']);
		$data['tga']            = now()->format('d-m-Y');
		$data['tgb']            = now()->format('d-m-Y');
		$data['dokter_filter'] 	= $request->dokter_id;
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['poli'] = [];

		$data['registrasi']	= HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
			->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
			->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
			->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->whereNull('registrasis.deleted_at')
			->orderBy('histori_kunjungan_irj.created_at', 'ASC')
			->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);

		if ($poli_id != '') {
			$poli_id = explode(",", $poli_id);
			$data['poli']		= Poli::whereIn('id', $poli_id)->pluck('nama', 'id');
		} else {
			$data['poli']       = Poli::pluck('nama', 'id');
		}

		if ($request->dokter_id != null) {
			$data['registrasi']->where('registrasis.dokter_id', $request->dokter_id);
		}

		if ($request->filter_poli) {
			$data['registrasi']->where('histori_kunjungan_irj.poli_id', $request->filter_poli);
		} elseif (!empty($poli_id)) {
			$data['registrasi']->whereIn('histori_kunjungan_irj.poli_id', $poli_id);
		}

		if (!empty($request['filter_reg'])) {
			if ($request['filter_reg'] == "Pendaftaran Onsite") {
				$data['registrasi'] = $data['registrasi']->whereNotNull('antrians.id');
			} elseif ($request['filter_reg'] == "Pendaftaran Online") {
				$data['registrasi'] = $data['registrasi']->whereNull('antrians.id')->where('registrasis.input_from', 'LIKE', '%KIOSK Reservasi%');
			} elseif ($request['filter_reg'] == "registrasi-ranap-langsung") {
				$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', '=', 'registrasi-ranap-langsung');
			} elseif ($request['filter_reg'] == "regperjanjian") {
				$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', 'like', '%regperjanjian%');
			} elseif ($request['filter_reg'] == "Registrasi") {
				$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', '!=', 'registrasi-ranap-langsung')->where('registrasis.input_from', 'notlike', '%regperjanjian%');
			} elseif ($request['filter_reg'] == "Semua") {
				$data['registrasi'] = $data['registrasi'];
			}
		}


		$data['registrasi'] = $data['registrasi']->select('registrasis.no_sep', 'histori_kunjungan_irj.id as id_kunjungan', 'antrian_poli.status', 'antrian_poli.nomor as nomor_antrian', 'antrian_poli.kelompok as kelompok_antrian', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.nomorantrian_jkn', 'registrasis.input_from', 'pasiens.nama', 'pasiens.no_jkn','pasiens.tanda_tangan', 'pasiens.no_rm', 'pasiens.tgllahir',  'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'antrians.id as antrian_regis');

		if (Auth::user()->id == 570 || Auth::user()->id == 574) {
			$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'I1', 'I2', 'I3'])->get();
		} else {
			$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])->get();
		}

		// Ordering
		// Ordering
		$registrasiIds = $data['registrasi']->pluck('id');
		$signPads = TandaTangan::whereIn('registrasi_id', $registrasiIds)
		->where('jenis_dokumen', 'e-resume')
		->select('registrasi_id', 'id')
		->get()
		->keyBy('registrasi_id');
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

			// $resepNote = ResepNote::where('registrasi_id', $d->id)->whereNotNull('nomor')->select('id')->first();
			// $d->resepNoteId = $resepNote ? $resepNote->id : null;
			$d->sign_pad = isset($signPads[$d->id]) ? $signPads[$d->id] : null;

			$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'jawab_konsul')->select('id')->orderBy('id', 'DESC')->first();
			if (!$konsulJawab) {
				$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'konsul_dokter')->select('id')->orderBy('id', 'DESC')->first();
			}
			$d->konsulJawabId = $konsulJawab ? $konsulJawab->id : null;
		}
		// dd($data['registrasi']);
		$data['registrasi'] = $data['registrasi']->sortBy(function ($reg) {
			return [$reg['kelompok_'], $reg['urutan_']];
		});
		// dd($data['registrasi'][11]);
		return view('tindakan::index', $data)->with('no', 1);
	}

	public function cetakSBPK($registrasi_id = '')
	{

		//$data['reg']    = Registrasi::find($registrasi_id);
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::find($data['reg']->dokter_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id])->get();
		$data['lab'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->sum('total');
		$data['rad'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'R'])->sum('total');
		$data['igd'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'G'])->sum('total');
		$data['total'] = Folio::where(['registrasi_id' => $registrasi_id])->sum('total');
		$data['penunjang'] = Folio::where(['registrasi_id' => $registrasi_id])->whereIn('poli_tipe', ['L', 'R', 'G'])->sum('total');
		$data['visite'] = $data['total'] - $data['penunjang'];
		$data['status'] = 'irj';
		$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();

		$data['return'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('return');
		$data['jamkesda'] = \App\Jamkesda::where('registrasi_id', $registrasi_id)->first();
		$data['dijamin'] = Folio::where(['registrasi_id' => $registrasi_id])->sum('dijamin');
		$data['deposit'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('nominal');
		$data['jkn'] = Folio::where(['registrasi_id' => $registrasi_id, 'cara_bayar_id' => 1])->sum('total');
		$data['dibayar'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'Y'])->sum('total');
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2])->orderBy('created_at');

		$data['detail']		= Folio::leftJoin('mastermapping_biaya', 'mastermapping_biaya.id', '=', 'folios.mapping_biaya_id')
			->where('folios.registrasi_id', $registrasi_id)
			->where('folios.tarif_id', '!=', 10000)
			->groupBy('folios.mapping_biaya_id')
			->selectRaw('SUM(folios.total) as total, mastermapping_biaya.kelompok as nama')->get();
		$data['obat']		= Folio::where(['registrasi_id' => $registrasi_id, 'tarif_id' => 10000])
			->groupBy('jenis')
			->selectRaw('SUM(total) as total, jenis')->get();



		// $pdf = PDF::loadView('modules.tindakan.cetaksbpk', $data)->setPaper('folio', 'landscape');
		// return $pdf->stream();
		return view('modules.tindakan.cetaksbpk', $data);
	}



	public function cetakSIP($registrasi_id = '')
	{

		//$data['reg']    = Registrasi::find($registrasi_id);
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['ranap'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::find($data['reg']->dokter_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id])->get();
		$data['lab'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->sum('total');
		$data['rad'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'R'])->sum('total');
		$data['igd'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'G'])->sum('total');
		$data['total'] = Folio::where(['registrasi_id' => $registrasi_id])->sum('total');
		$data['penunjang'] = Folio::where(['registrasi_id' => $registrasi_id])->whereIn('poli_tipe', ['L', 'R', 'G'])->sum('total');
		$data['visite'] = $data['total'] - $data['penunjang'];
		$data['status'] = 'irj';
		$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
		$data['sip'] = SuratIzinPulang::where('registrasi_id', $registrasi_id)->first();

		$data['return'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('return');
		$data['jamkesda'] = \App\Jamkesda::where('registrasi_id', $registrasi_id)->first();
		$data['dijamin'] = Folio::where(['registrasi_id' => $registrasi_id])->sum('dijamin');
		$data['deposit'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('nominal');
		$data['jkn'] = Folio::where(['registrasi_id' => $registrasi_id, 'cara_bayar_id' => 1])->sum('total');
		$data['dibayar'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'Y'])->sum('total');
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2])->orderBy('created_at');

		$data['detail']		= Folio::leftJoin('mastermapping_biaya', 'mastermapping_biaya.id', '=', 'folios.mapping_biaya_id')
			->where('folios.registrasi_id', $registrasi_id)
			->where('folios.tarif_id', '!=', 10000)
			->groupBy('folios.mapping_biaya_id')
			->selectRaw('SUM(folios.total) as total, mastermapping_biaya.kelompok as nama')->get();
		$data['obat']		= Folio::where(['registrasi_id' => $registrasi_id, 'tarif_id' => 10000])
			->groupBy('jenis')
			->selectRaw('SUM(total) as total, jenis')->get();

		$data['pembayaran'] = Pembayaran::where('registrasi_id', $registrasi_id)->first();

		// $pdf = PDF::loadView('modules.tindakan.cetaksbpk', $data)->setPaper('folio', 'landscape');
		// return $pdf->stream();
		return view('modules.tindakan.cetaksip', $data);
	}

	public function cetakSUSPEK($registrasi_id = '')
	{
		//dd("cetak Suspek");
		//$data['reg']    = Registrasi::find($registrasi_id);
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);

		$pdf = PDF::loadView('modules.tindakan.cetaksuspek', $data);
		return $pdf->stream();
	}

	public function cetakGelang($registrasi_id = '')
	{

		//$data['reg']    = Registrasi::find($registrasi_id);
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);

		return view('modules.tindakan.cetak_gelang', $data);
	}

	public function orderPoli($reg = '', $pas = '')
	{
		$data['poli']			= Poli::where('politype', '!=', 'G')->get();
		$data['pasien']			= Pasien::find($pas);
		$data['registrasi_id']	= $reg;
		$data['dokter']			= Pegawai::where('kategori_pegawai', 1)->get();
		return view('tindakan::orderPoli', $data);
	}

	public function poliOrdered(Request $req)
	{

		$cek = HistorikunjunganIRJ::where(['pasien_id' => $req->pasien_id, 'registrasi_id' => $req->registrasi_id, 'poli_id' => $req->poli_id])
			->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
		if ($cek == 0) {
			$h = new HistorikunjunganIRJ();
			$h->registrasi_id = $req->registrasi_id;
			$h->pasien_id = $req->pasien_id;
			$h->poli_id = $req->poli_id;
			$h->dokter_id = $req->dokter_id;
			$h->user = Auth::user()->name;
			$h->save();

			$poli = Poli::find($req->poli_id);
			$count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
			$antr_poli = RegistrasiDummy::whereNotIn('status', ['pending', 'dibatalkan'])->where('tglperiksa',date('Y-m-d'))->where('kode_poli', $poli->bpjs)->count();

			$nomor = hitungAntrolNew2($poli->kelompok,$poli->bpjs);
			// $nomor = $count + 1;
			$suara = $nomor . '.mp3';
			$tgl = date('Y-m-d', strtotime($h->created_at));

			$antrian_poli = [
				"nomor" => $nomor,
				"suara" => $suara,
				"status" => 0,
				"panggil" => 1,
				"poli_id" => $poli->id,
				"tanggal" => $tgl,
				// 'registrasi_id' => $h->registrasi_id,
				'histori_kunjungan_irj_id' => $h->id,
				"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
				"kelompok" => $poli->kelompok
			];
			// GET ANTRIAN POLI ID 
			//dd("J1");
			$antrian = AntrianPoli::create($antrian_poli);
		}
		Flashy::success('Berhasil order poli');
		return redirect()->back();
	}

	public function tindakanIGD()
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = Aturanetiket::all('aturan', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		// $data['registrasi'] = Registrasi::whereIn('status_reg', ['G1', 'G2', 'G3', 'I1'])->where('created_at', 'LIKE', date('Y-m-d') . '%')->where('lunas','N')->get();
		// $data['registrasi']	= Registrasi::leftJoin('histori_kunjungan_igd', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
		// ->where('histori_kunjungan_igd.created_at', 'LIKE', date('Y-m-d') . '%')
		// ->select('histori_kunjungan_igd.created_at as masuk', 'registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'histori_kunjungan_igd.created_at')->get();

		$data['registrasi']	= HistorikunjunganIGD::leftJoin('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
			->where('histori_kunjungan_igd.created_at', 'LIKE', date('Y-m-d') . '%')
			->whereNull('registrasis.deleted_at')
			->select('registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'histori_kunjungan_igd.created_at', 'histori_kunjungan_igd.triage_nama')->get();
		
		foreach ($data['registrasi'] as $key => $d) {
			$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'jawab_konsul')->select('id')->orderBy('id', 'DESC')->first();
			if (!$konsulJawab) {
				$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'konsul_dokter')->select('id')->orderBy('id', 'DESC')->first();
			}
			$d->konsulJawabId = $konsulJawab ? $konsulJawab->id : null;
		}
		//$data['registrasi'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('lunas','N')->get();
		// dd($data['registrasi']);
		// $data['registrasi']	= Registrasi::leftJoin('histori_kunjungan_igd', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
		// ->where('histori_kunjungan_igd.created_at', 'LIKE', date('Y-m-d') . '%')
		// ->select('histori_kunjungan_igd.created_at as masuk', 'registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'histori_kunjungan_igd.created_at')->get();
		return view('tindakan::indexIGD', $data)->with('no', 1);
	}

	public function tindakanIGD_byTanggal(Request $request)
	{
		$data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = Aturanetiket::all('aturan', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		if ($request->cari == 'CARI') {
			request()->validate(['keyword' => 'required']);
			$data['registrasi']	= HistorikunjunganIGD::leftJoin('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'histori_kunjungan_igd.pasien_id')
				->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
				->where('pasiens.no_rm', $request->keyword)
				->orWhere('pasiens.nama', 'LIKE', "%$request->keyword%")
				->select('registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'histori_kunjungan_igd.created_at', 'histori_kunjungan_igd.triage_nama')->get();
			// return $data['registrasi'];die;
			return view('tindakan::indexIGD', $data)->with('no', 1);
		}
		request()->validate(['tga' => 'required']);

		// $data['registrasi'] = Registrasi::whereIn('status_reg', ['G1', 'G2', 'G3', 'I1'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		$data['registrasi']	= HistorikunjunganIGD::leftJoin('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
			->whereBetween('histori_kunjungan_igd.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->select('registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'histori_kunjungan_igd.created_at', 'histori_kunjungan_igd.triage_nama')->get();
		// return $data['registrasi'];die;
		
		foreach ($data['registrasi'] as $key => $d) {
			$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'jawab_konsul')->select('id')->orderBy('id', 'DESC')->first();
			if (!$konsulJawab) {
				$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'konsul_dokter')->select('id')->orderBy('id', 'DESC')->first();
			}
			$d->konsulJawabId = $konsulJawab ? $konsulJawab->id : null;
		}

		return view('tindakan::indexIGD', $data)->with('no', 1);
	}

	public function ajax_tindakanIGD()
	{
		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', '>=', Carbon::now()->format('Y-m-d'))->get();
		return view('tindakan::view_ajax', $data)->with('no', 1);
	}

	public function view_ajax()
	{
		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->where('created_at', '>=', Carbon::now()->format('Y-m-d'))->get();
		return view('tindakan::view_ajax', $data)->with('no', 1);
	}

	public function search(Request $request)
	{
		request()->validate(['tga' => 'required']);
		$tga = date("Y-m-d", strtotime($request['tga']));
		$tgb = date("Y-m-d", strtotime($request['tgb'] . "+1 day"));
		$data['registrasi'] = Registrasi::whereBetween('created_at', [$tga, $tgb])->get();
		return view('tindakan::index', $data)->with('no', 1);
	}

	public function entry($idreg, $idpasien, $idhistory = null)
	{
		//dd("tindakan Rajal");
		$poli_id        = Auth::user()->poli_id;
		$cekpoli        = User::where('poli_id', Auth::user()->poli_id)->first();
		//dd($cekpoli->poli_id);
		$data['pasien'] = Pasien::find($idpasien);
		$data['kondisi_akhirs'] = KondisiAkhirPasien::orderBy('urutan', 'ASC')->pluck('namakondisi', 'id');
		$data['reg_id'] = $idreg;
		$data['history'] = '';
		if ($idhistory) {
			$data['history'] = HistorikunjunganIRJ::where('id', $idhistory)->first();
		}
		// dd($data['history']);
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['bayar_lunas'] = Pembayaran::where('registrasi_id', $idreg)->select('no_kwitansi')->get();
		//dd($data['jenis']);
		// CEK APAKAH ADA NOMORANTRIAN
		if (@$data['jenis']->nomorantrian) {
			// JIKA ADA UPDATE TASKID 3

			$ID = config('app.consid_antrean');
			date_default_timezone_set('UTC');
			$t = time();
			$dat = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
			$completeurl = config('app.antrean_url_web_service') . "antrean/updatewaktu";
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:' . config('app.user_key_antrean'),
				'Content-Type: application/json',
			);

			if (status_consid(3)) {
				$updatewaktu   = '{
					"kodebooking": "' . @$data['jenis']->nomorantrian . '",
					"taskid": 3,
					"waktu": "' . round(microtime(true) * 1000) . '"
				 }';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session2);
			}

			if (status_consid(4)) {
				//  TASKID 4 RUN
				$updatewaktu4   = '{
					"kodebooking": "' . @$data['jenis']->nomorantrian . '",
					"taskid": 4,
					"waktu": "' . round(microtime(true) * 1000) . '"
				 }';
				$session4 = curl_init($completeurl);
				curl_setopt($session4, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session4, CURLOPT_POSTFIELDS, $updatewaktu4);
				curl_setopt($session4, CURLOPT_POST, TRUE);
				curl_setopt($session4, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session4);
			}



			if (status_consid(5)) {
				//  TASKID 5 RUN
				$updatewaktu5   = '{
					"kodebooking": "' . @$data['jenis']->nomorantrian . '",
					"taskid": 5,
					"waktu": "' . round(microtime(true) * 1000) . '"
				 }';
				$session5 = curl_init($completeurl);
				curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
				curl_setopt($session5, CURLOPT_POST, TRUE);
				curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session5);
			}
			//  dd($resp);
		}
		#IGD PONEK
		$data['drponek'] = ['191,192,193'];
		#PERINATOLOGI
		$data['drperinatologi'] = ['194,195'];
		#POLI OBGYN ATAU KEBIDANAN
		$data['drobgyn'] = ['191,192,193'];
		#POLI INTERNA
		$data['drinterna'] = ['197,196'];
		#poli THT
		$data['drtht'] = ['200, 201'];
		#poli jantung
		$data['drjantung'] = ['203'];
		#poli saraf:
		$data['drsaraf'] = ['204'];
		#poli anak
		$data['dranak'] = ['1'];
		#poli gigi:
		$data['drgigi'] = ['214, 213, 210, 211'];

		$pol['status']  = 4;
		AntrianPoli::where('registrasi_id', $idreg)->where('tanggal', date('Y-m-d'))->update($pol);

		$data['pegawai'] =  Pegawai::find(Auth::user()->id);

		@$jenis = @$data['jenis']->status_reg;

		//dd($jenis );
		$data['tglmasukrawat'] = Carbon::parse(@$data['jenis']->created_at)->format('Y-m-d');

		// if (substr($jenis, 0, 1) == 'G' || $jenis == 'I1') {
		// $data['pelaksana'] = Pegawai::where('id', 1)->pluck('nama');
		//$data['pelaksana']  = Pegawai::where('kategori_pegawai', 1)->where('poli_id', $data['jenis']->poli_id)->pluck('nama', 'id');
		// $getPolis = Poli::find(Auth::user()->poli_id);
		// $try = Pegawai::where('poli_id', 20)->get();
		// dd($try);
		$data['pelaksana']   = Pegawai::where('kategori_pegawai', '1')->get();

		//  if(count($data['pelaksana']) == '0'){
		// 	$data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->where('poli_id', $data['jenis']->poli_id)->get();

		//  }
		$data['perawat'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
		//  $data['pelaksana'] = Pegawai::join('users', 'users.id', '=', 'pegawais.user_id')
		// 								->where('pegawais.kategori_pegawai', 1)
		// 								->where('users.poli_id', Auth::user()->poli_id)
		// 								->get();
		// dd($data['pelaksana']);
		// }elseif (substr($jenis, 0, 1) == 'J') {
		// 	$data['pelaksana'] = Pegawai::whereIn('id', ['191','192','193','197','196','200','201','203','204','214','213','210','211','205','194','195','212','209','198', '228'])->pluck('nama', 'id');
		// } 
		// join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
		// if (substr($jenis, 0, 1) == 'G' || $jenis == 'I1') {
		// $data['perawat'] = Pegawai::where('id', 5)->pluck('nama', 'id');
		// $data['perawat'] = Pegawai::join('users', 'users.id', '=', 'pegawais.user_id')
		// 						->where('pegawais.kategori_pegawai', 2)
		// 						->where('users.poli_id', Auth::user()->poli_id)
		// 						->pluck('pegawais.nama', 'pegawais.id');
		// $data['perawat'] = User::join('pegawais', 'pegawais.user_id', '=', '466')->get();
		// }elseif (substr($jenis, 0, 1) == 'J') {
		// $data['perawat'] = Pegawai::where('kategori_pegawai', 2)->pluck('nama', 'id');
		// }
		// dd($data['perawat']);
		// return $data; die;

		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = \Modules\Registrasi\Entities\Carabayar::pluck('carabayar', 'id');

		// inhealth mandiri
		$data['inhealth'] = inhealthSjp::where('reg_id', $idreg)->first();

		if (substr($jenis, 0, 1) == 'G' || substr($jenis, 0, 1) == 'I') {
			$data['opt_poli'] = Poli::where('politype', 'G')->get();
			$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
			// $data['perawatreal']  = explode(",", $data['perawats'][0]);
			$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
			session(['jenis' => 'TG']);
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TG')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			// if (Auth::user()->hasRole(['administrator'])) {
			$data['folio'] = Folio::whereIn('jenis', ['TG', 'TI'])->where('registrasi_id', $idreg)->get();

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
				$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $idreg])->get();
			}
		} elseif (substr($jenis, 0, 1) == 'J') {
			$data['opt_poli'] = Poli::where('politype', 'J')->get();
			session(['jenis' => 'TA']);
			$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
			// $data['perawatreal']  = explode(",", $data['perawats'][0]);
			$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			// if (Auth::user()->hasRole(['administrator'])) {
			@$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $idreg])->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			$data['opt_poli'] = Poli::where('politype', 'I')->get();
			$data['perawats'] = Poli::where('politype', 'G')->pluck('perawat_id');
			// $data['perawatreal']  = explode(",", $data['perawats'][0]);
			$data['perawatreal'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();

			@$data['folio'] = Folio::whereIn('jenis', ['TG', 'TI'])->where('registrasi_id', $idreg)->get();
		}

		if (@$data['folio']) {
			@$data['tagihan'] = @$data['folio']->sum('total');
		} else {
			$data['tagihan'] = 0;
		}
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['login']   = Auth::user()->id;
		//dd($data['login']);
		return view('tindakan::entry_tindakan', $data)->with('no', 1);
	}

	public function sinkronTindakanInhealth(Request $request, $id)
	{
		$find = Folio::find($id);
		$poli = Poli::find($request->poli);
		$dokter = Pegawai::find($request->kodedokter);
		$tarif = Tarif::find($find->tarif_id);
		$data = [
			"token" => config('app.token_inhealth'),
			"kodeprovider"  => config('app.kodeprovider_inhealth'),
			"jenispelayanan" => $request->jenispelayanan,
			"nosjp" => $request->nosjp,
			"tglmasukrawat" => Carbon::parse($request->tglmasukrawat)->format('Y-m-d'),
			"tanggalpelayanan" => Carbon::now()->format('Y-m-d'),
			"kodetindakan" => $request->kodetindakan,
			"poli" => $poli->inhealth,
			"kodedokter" => $dokter->kode_dokter_inhealth,
			"biayaaju" => $tarif->total
		];
		// dd($data);
		$res = $this->client->post('SimpanTindakan', json_encode($data)); // api
		// dd($res);
		if ($res['data']['ERRORCODE'] == "00") { // jika sukses
			$find->sinkron_inhealth = "sinkron";
			$find->update();
			$result = [
				"status" => true,
				"msg" => $res['data']['ERRORDESC']
			];
		} else { // jika status error
			$result = [
				"status" => false,
				"msg" => $res['data']['ERRORDESC']
			];
		}
		return response()->json($result);
	}

	public function updateCaraBayar($id, $cara_bayar)
	{
		$folio = Folio::find($id);
		$folio->cara_bayar_id = $cara_bayar;
		$folio->update();

		Flashy::success('Cara bayar berhasil di update !');
	}

	public function saveLis(Request $request)
	{
		// dd($request->all());
		$reg = Registrasi::find($request['registrasi_id']);
		$tgllahir = $reg->pasien->nohp ? $reg->pasien->nohp : $reg->pasien->notlp;
		$data = '{
			"demografi": {
				"no_rkm_medis": "' . $reg->pasien->no_rm . '",
				"nama_pasien": "' . $reg->pasien->nama . '",
				"tgl_lahir": "' . $reg->pasien->tgllahir . '",
				"jk": "' . $reg->pasien->kelamin . '",
				"alamat": "' . $reg->pasien->alamat . '",
				"no_telp": "' . $tgllahir . '"
			},
			"transaksi": {
				"no_order": "' . date('ymdHis') . '", 
				"tgl_permintaan": "' . date('Y-m-d') . '", 
				"jam_permintaan": "' . date('H:i:s') . '", 
				"kode_pembayaran": "' . $request->cara_bayar_id . '", 
				"pembayaran": "' . baca_carabayar($request->cara_bayar_id) . '", 
				"kode_ruangan": "' . baca_data_poli($reg->poli_id)->general_code . '",
				"kelas": "2",
				"ruangan": "LABORATORIUM", 
				"kode_jenis": "2",
				"jenis": "Rawat Jalan", 
				"kode_dokter": "' . $request->dokter_id . '",
				"dokter": "' . baca_dokter($request->dokter_id) . '",
				"note": "' . $request->note . '"
			},
			"test": [
				{
				    "id": "171296",
					"test_id": "228",
					"test_name": "Methamphetamine", "cito": "1"
				},
				{
					"id": "171297",
					"test_id": "229",
					"test_name": "Benzodiazepine / Psikotropik", "cito": "1"
				},
				{
					"id": "171298",
					"test_id": "225",
					"test_name": "Morphin/Heroin Opiat Test", "cito": "1"
				}
				
			]}
		}';

		dd($data);
	}

	public function saveTindakan(Request $request)
	{
		// dd($request->all());
		if ($request['billing_infus'] != "Ya") {
			request()->validate(['tarif_id' => 'required', 'pelaksana' => 'required']);
		} else {
			request()->validate(['paket_infus' => 'required', 'pelaksana' => 'required']);
		}

		//Multi Insert
		LogUserController::log(Auth::user()->id, 'billing', @$request['registrasi_id']);

		if (is_array(@$request['tarif_id'])) {
			foreach ($request['tarif_id'] as $i) {
				$reg    = Registrasi::find($request['registrasi_id']);
				$kode   = $i;

				$tarif  = Tarif::where('id', $kode)->first();


				if (isset($request['page'])) {
					if ($request['page'] == 'labJalan' || $request['page'] == 'labIgd' || $request['page'] == 'labInap') {
						$poli_tipe = 'L';
					} else if ($request['page'] == 'radJalan' || $request['page'] == 'radIgd' || $request['page'] == 'radInap') {
						$poli_tipe = 'R';
					}
				} else {
					if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1' || $reg->status_reg == 'I2' || $reg->status_reg == 'I3') {
						$poli_tipe = 'G';
					} else {
						$poli_tipe = 'J';
					}
				}

				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1' || $reg->status_reg == 'I2' || $reg->status_reg == 'I3') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}
				if (!empty($request['tanggal'])) {
					if (!empty($request['jam'])) {
						$created_at = valid_date($request['tanggal']) . ' ' . $request['jam'];
					} else {
						$created_at = valid_date($request['tanggal']) . ' ' . date('H:i:s');
					}
				}


				if ($request['cyto'] != null) {
					// CITO JIKA POLI EKSEKUTIF MAKA DITAMBAH 30%
					if ($reg->poli->kelompok == 'ESO') {
						$cyto = ($tarif->total * 30) / 100;
					} else {
						// JIKA BUKAN POLI EKSEKUTIF
						$cyto = $tarif->total / 2;
					}
				} else {
					$cyto = 0;
				}

				FolioMulti::create([
					'registrasi_id'    => $request['registrasi_id'],
					'poli_id'          => $request['poli_id'],
					'lunas'            => 'N',
					'namatarif'        => $tarif->nama,
					'dijamin'          => $request['dijamin'],
					'tarif_id'         => $tarif->id,
					'cara_bayar_id'    => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
					'jenis'            => $tarif->jenis,
					'poli_tipe'        => $poli_tipe,
					'total'            => ($tarif->total + $cyto) * $request['jumlah'],
					'jenis_pasien'     => $request['jenis'],
					'pasien_id'        => $request['pasien_id'],
					'dokter_id'        => $request['dokter_id'],
					'diagnosa'         => $request['kondisi_akhir_pasien'],
					'cyto'			   => $request['cyto'],
					'user_id'          => Auth::user()->id,
					'mapping_biaya_id' => $tarif->mapping_biaya_id,
					'dpjp'             => $request['dokter_id'],
					'dokter_pelaksana' => $request['pelaksana'],
					'harus_bayar' 	   => @$request['jumlah'],
					'perawat'          => $request['perawat'],
					'pelaksana_tipe'   => $pelaksana_tipe,
					'created_at'       => $created_at,
					'verif_kasa_user'  => 'tarif_new',
					'catatan'  		   => @$request['keterangan'],
					'jam_masuk'        => $request->jam_masuk != null ? $request->jam_masuk : date("H:i:s"),
					'jam_penanganan'   => $request->jam_penanganan != null ? $request->jam_penanganan : date("H:i:s")
				]);
			}
		}
		// Jika billing infus di pilih
		if ($request['billing_infus'] == "Ya") {
			$tarifs = [];
			$biaya = BiayaInfus::with('detail')->find($request['paket_infus']);
			if (count($biaya->detail) > 0) {
				foreach ($biaya->detail as $i) {
					$tarifs[] = $i->tarif_id;
				}
			}

			foreach ($tarifs as $i) {
				$reg    = Registrasi::find($request['registrasi_id']);
				$kode   = $i;

				$tarif  = Tarif::where('id', $kode)->first();


				if (isset($request['page'])) {
					if ($request['page'] == 'labJalan' || $request['page'] == 'labIgd' || $request['page'] == 'labInap') {
						$poli_tipe = 'L';
					} else if ($request['page'] == 'radJalan' || $request['page'] == 'radIgd' || $request['page'] == 'radInap') {
						$poli_tipe = 'R';
					}
				} else {
					if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1' || $reg->status_reg == 'I2' || $reg->status_reg == 'I3') {
						$poli_tipe = 'G';
					} else {
						$poli_tipe = 'J';
					}
				}

				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1' || $reg->status_reg == 'I2' || $reg->status_reg == 'I3') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}
				if (!empty($request['tanggal'])) {
					if (!empty($request['jam'])) {
						$created_at = valid_date($request['tanggal']) . ' ' . $request['jam'];
					} else {
						$created_at = valid_date($request['tanggal']) . ' ' . date('H:i:s');
					}
				}


				if ($request['cyto'] != null) {
					// CITO JIKA POLI EKSEKUTIF MAKA DITAMBAH 30%
					if ($reg->poli->kelompok == 'ESO') {
						$cyto = ($tarif->total * 30) / 100;
					} else {
						// JIKA BUKAN POLI EKSEKUTIF
						$cyto = $tarif->total / 2;
					}
				} else {
					$cyto = 0;
				}

				FolioMulti::create([
					'registrasi_id'    => $request['registrasi_id'],
					'poli_id'          => $request['poli_id'],
					'lunas'            => 'N',
					'namatarif'        => $tarif->nama,
					'dijamin'          => $request['dijamin'],
					'tarif_id'         => $tarif->id,
					'cara_bayar_id'    => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
					'jenis'            => $tarif->jenis,
					'poli_tipe'        => $poli_tipe,
					'total'            => ($tarif->total + $cyto) * $request['jumlah'],
					'jenis_pasien'     => $request['jenis'],
					'pasien_id'        => $request['pasien_id'],
					'dokter_id'        => $request['dokter_id'],
					'diagnosa'         => $request['kondisi_akhir_pasien'],
					'cyto'			   => $request['cyto'],
					'user_id'          => Auth::user()->id,
					'mapping_biaya_id' => $tarif->mapping_biaya_id,
					'dpjp'             => $request['dokter_id'],
					'dokter_pelaksana' => $request['pelaksana'],
					'harus_bayar' 	   => @$request['jumlah'],
					'perawat'          => $request['perawat'],
					'pelaksana_tipe'   => $pelaksana_tipe,
					'created_at'       => $created_at,
					'verif_kasa_user'  => 'tarif_new',
					'catatan'  		   => @$request['keterangan'],
					'jam_masuk'        => $request->jam_masuk != null ? $request->jam_masuk : date("H:i:s"),
					'jam_penanganan'   => $request->jam_penanganan != null ? $request->jam_penanganan : date("H:i:s")
				]);
			}
		}


		//sigle insert
		// $reg   = Registrasi::find($request['registrasi_id']);
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
		// //$fol->poli_id = $request['poli_id'];
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
				// $rj->keterangan = @$request['keterangan'];
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

		//Update Reg Status
		// if (substr($reg->status_reg, 0, 1) == 'G') {
		// 	$reg->status_reg = 'G2';
		// } else if (substr($reg->status_reg, 0, 1) == 'J') {
		// 	$reg->status_reg = 'J2';
		// } else if (substr($reg->status_reg, 0, 1) == 'I') {
		// 	$reg->status_reg = 'I2';
		// }
		// $reg->update();

		//input folio pelaksana
		// $fp = new Foliopelaksana();
		// $fp->folio_id = $fol->id;
		// $fp->dpjp = $request['dokter_id'];
		// $fp->dokter_pelaksana = $request['pelaksana'];
		// $fp->perawat = $request['perawat'];
		// if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
		// 	$fp->pelaksana_tipe = 'TG';
		// } else {
		// 	$fp->pelaksana_tipe = 'TA';
		// }
		// $fp->user = Auth::user()->id;
		// $fp->save();

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
		if (@$reg->nomorantrian) {
			// JIKA ADA UPDATE TASKID 4
			if (status_consid(4)) {

				$ID = config('app.consid_antrean');
				date_default_timezone_set('UTC');
				$t = time();
				$data = "$ID&$t";
				$secretKey = config('app.secretkey_antrean');
				$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
				$completeurl = config('app.antrean_url_web_service') . "antrean/updatewaktu";
				$arrheader = array(
					'X-cons-id: ' . $ID,
					'X-timestamp: ' . $t,
					'X-signature: ' . $signature,
					'user_key:' . config('app.user_key_antrean'),
					'Content-Type: application/json',
				);
				$updatewaktu   = '{
					"kodebooking": "' . @$reg->nomorantrian . '",
					"taskid": 4,
					"waktu": "' . round(microtime(true) * 1000) . '"
				 }';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session2);
				$resp = curl_exec($session2);
			}
			//  dd($resp);

		}
		if (isset($request['verifikasi_rajal_kasa'])) {
			return redirect()->back();
		}
		session()->forget('jenis');
		if (isset($request['page'])) {
			if ($request['page'] == 'labJalan') {
				return redirect('tindakan/labJalan/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radJalan') {
				return redirect('tindakan/radJalan/' . $request['registrasi_id']);
			} else if ($request['page'] == 'labIgd') {
				return redirect('tindakan/labIgd/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radIgd') {
				return redirect('tindakan/radIgd/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radInap') {
				return redirect('rawat-inap/radiologi/' . $request['registrasi_id']);
			} else if ($request['page'] == 'labInap') {
				return redirect('rawat-inap/laboratorium/' . $request['registrasi_id']);
			} else if ($request['page'] == 'radInap') {
				return redirect('tindakan/radInap/' . $request['registrasi_id']);
			}
		} else {
			return redirect('tindakan/entry/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		}
	}


	public function cetakentry($id = '')
	{
		$data['kuitansi'] = Pembayaran::where('id', $id)->first();
		//dd($data['kuitansi']);
		$data['reg']      = Registrasi::with('bayars')->find($data['kuitansi']->registrasi_id);
		$nokuitansi       = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)->where('jenis', 'ORJ')->where('lunas', 'Y')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->first();
		if (!$nokuitansi) {
			$noresep = '';
		} else {
			$noresep = $nokuitansi->namatarif;
		}

		$data['penjualan'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			//->where('penjualandetails.no_kuitansi',$noresep)
			->where('penjualandetails.jumlah', '!=', '0')
			->where('penjualans.registrasi_id', $data['reg']->id)
			->select('penjualandetails.*')
			->get();

		//dd($data['penjualan'] );
		// return $data['penjualan']; die;

		//kondisi to lab rajal
		$data['folio_irj_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to rad rajal
		$data['folio_irj_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab igd
		$data['folio_igd_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to rad igd
		$data['folio_igd_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab irna
		$data['folio_irna_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab irna
		$data['folio_irna_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//Master Loop
		$data['folio_irj'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['folio_igd'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'G')
			// ->where('poli_tipe', 'J')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['folio_irna'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();
		// $data['folio_irna']   = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)->groupBy('tarif_id')->where('lunas', 'Y')->where('jenis', 'TI')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->get();

		$data['folio_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'ORJ')
			->get();

		$data['folio'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			//->where('jenis','TI')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['listDokter'] = [];
		foreach (Pegawai::where('kategori_pegawai', 1)->whereNotIn('id', [$data['reg']->dokter_id])->get() as $d) {
			$data['listDokter'][] = '' . $d->id . '';
		}
		$data['dokter'] = Folio::where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)
			->where('registrasi_id', $data['reg']->id)->whereIn('dokter_pelaksana', [$data['listDokter']])
			->groupBy('dokter_pelaksana')->select('dokter_pelaksana')->get();

		$data['jml'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('lunas', 'Y')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');
		$data['no'] = 1;

		//JUMLAH IGD

		$data['jml_igd'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			// ->where('poli_tipe', 'J')
			->Where('poli_tipe', 'G')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)
			->sum('total');

		$data['jml_igd_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_igd_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		//JUMLAH RAJAL

		$data['jml_irj_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irj_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irj'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'J')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');


		//JUMLAH IRNA

		$data['jml_irna_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irna_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irna'] = Folio::where('registrasi_id', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', null)
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		// $data['jml_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
		//     ->where('namatarif','!=','Retur penjualan')
		//     ->where('jenis','ORJ')
		// 	->where('lunas', 'Y')
		// 	->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		//new commant
		$data['jml_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('namatarif', '!=', 'Retur penjualan')
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->sum('total');

		// $data['jml_obat'] = Folio::join('penjualans','folios.registrasi_id','=','penjualans.registrasi_id')
		// 					->join('penjualandetails','penjualans.id','=','penjualandetails.penjualan_id')
		// 					->where('folios.registrasi_id', '=', $data['kuitansi']->registrasi_id)
		// 					->where('folios.namatarif','!=','Retur penjualan')
		// 					->where('penjualandetails.jumlah','!=','0')
		// 					->where('folios.jenis','ORJ')
		// 					->where('folios.lunas', 'Y')
		// 					->sum('total');

		//dd($data['jml_obat']);

		$data['embalase'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('embalase');

		$data['jasaracik'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('jasa_racik');

		$data['uangracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)->sum('uang_racik');

		$data['jmlracikper'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->groupBy('uang_racik_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)->sum('uang_racik');

		$data['Totracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)
			->groupBy('uang_racik_id')
			->selectRaw('count(penjualandetails.uang_racik) as Tot')
			->get();

		$data['jenisracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->join('uang_raciks', 'penjualandetails.uang_racik_id', '=', 'uang_raciks.id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)
			->groupBy('uang_racik_id')
			->select('penjualandetails.uang_racik', 'uang_raciks.nama', DB::raw('sum(penjualandetails.uang_racik) as uracik'), DB::raw('count(penjualandetails.uang_racik) as jmlracik'))
			->get();

		$data['no'] = 1;
		$pdf        = PDF::loadView('tindakan.cetakentry', $data)->setpaper('folio', 'landscape');
		return $pdf->stream();
	}


	public function kondisi_akhir_pasien(Request $request)
	{
		// $reg = Registrasi::find($request['registrasi_id']);
		$reg = Registrasi::find($request['registrasi_id']);
		// $reg->kondisi_akhir_pasien = $request['kondisi_akhir_pasien'];
		// $reg->keterangan = $request['keterangan'];
		// if ($request['status_reg'] == 'G') {
		// 	$reg->status_reg = 'G2';
		// } elseif ($request['status_reg'] == 'J') {
		// 	$reg->status_reg = 'J2';
		// }
		// $reg->update();
		if ($request->tanpa_obat) {
			// dd($reg->nomorantrian);
			if (@$reg->nomorantrian && $reg->bayar = '1') {
				// JIKA ADA UPDATE TASKID 5

				if (status_consid(5)) {

					$ID = config('app.consid_antrean');
					date_default_timezone_set('UTC');
					$t = time();
					$dat = "$ID&$t";
					$secretKey = config('app.secretkey_antrean');
					$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
					$completeurl = config('app.antrean_url_web_service') . "antrean/updatewaktu";
					$arrheader = array(
						'X-cons-id: ' . $ID,
						'X-timestamp: ' . $t,
						'X-signature: ' . $signature,
						'user_key:' . config('app.user_key_antrean'),
						'Content-Type: application/json',
					);
					$updatewaktu   = '{
						"kodebooking": "' . @$reg->nomorantrian . '",
						"taskid": 5,
						"waktu": "' . round(microtime(true) * 1000) . '"
					 }';
					$session2 = curl_init($completeurl);
					curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
					curl_setopt($session2, CURLOPT_POST, TRUE);
					curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
					curl_exec($session2);
					$resp = curl_exec($session2);
				}
			}
		}
		Flashy::success('Selesai Input Tindakan');
		if ($request['source'] && $request['source'] == 'cppt') {
			return redirect('/emr/jalan');
		}

		if (substr($reg->status_reg, 0, 1) == 'G') {
			return redirect()->route('tindakan.igd');
		} else {
			return redirect()->route('tindakan');
		}
	}
	// public function kondisi_akhir_pasien(Request $request) {
	// 	$kondisi = request()->validate(['kondisi_akhir_pasien' => 'required']);
	// 	$reg = Registrasi::find($request['registrasi_id']);
	// 	$reg->kondisi_akhir_pasien = $request['kondisi_akhir_pasien'];
	// 	if ($request['status_reg'] == 'G') {
	// 		$reg->status_reg = 'G2';
	// 	} elseif ($request['status_reg'] == 'J') {
	// 		$reg->status_reg = 'J2';
	// 	}
	// 	$reg->update();

	// 	if($reg->bayar == 2){
	// 		$folio = Folio::where(['registrasi_id' => $request['registrasi_id'], 'jenis' => 'TA'])->get();
	// 		foreach($folio as $f){
	// 			$l = Folio::find($f->id);
	// 			$l->lunas = 'Y';
	// 			$l->update();
	// 		}
	// 	}

	// 	if ($request['status_reg'] == 'G') {
	// 		return redirect()->route('tindakan.igd');
	// 	} else {
	// 		return redirect()->route('tindakan');
	// 	}
	// }

	public function ubahStatusUGD($registrasi_id, $status_ugd)
	{
		$ugd = Registrasi::find($registrasi_id);
		$ugd->status_ugd = $status_ugd;
		$ugd->update();
		if ($ugd) {
			return response()->json(['sukses' => true]);
		} else {
			return response()->json(['sukses' => false]);
		}
	}

	public function hapusTindakan($id, $idreg, $pasien_id)
	{
		if (Auth::user()->hasRole(['rawatjalan', 'kasir', 'supervisor', 'rawatdarurat', 'administrator'])) {
			$folio = Folio::find($id);

			if (@$folio->lunas == 'N') {
				$folio->delete();
			}

		}
		// return redirect('tindakan/entry/' . $idreg . '/' . $pasien_id);
		return redirect()->back();
	}

	public function getTarif($kategoritarif_id = '')
	{
		$tarif = Tarif::where('kategoritarif_id', '=', $kategoritarif_id)->where('is_aktif', 'Y')->where('jenis', session('jenis'))->where('total', '<>', 0)->select('nama', 'id', 'total')->get();
		return response()->json($tarif);
	}

	//VERIFIKASI TINDAKAN RJ/RD
	public function verifikasiRJ()
	{
		$data['registrasi'] = Registrasi::where('lunas', 'N')
			->where('verif_rj', 'N')
			->whereIn('status_reg', ['J1', 'J2', 'G1', 'G2'])
			->where('created_at', 'like', date('Y-m-d') . '%')->get();
		return view('kasir.verifikasiRJ.verifikasiRJ', $data)->with('no', 1);
	}

	public function detailVerifikasiRJ($registrasi_id)
	{
		$data['registrasi'] = Registrasi::select('id', 'pasien_id', 'status_reg', 'dokter_id', 'poli_id', 'bayar')->where('id', $registrasi_id)->first();
		$data['pasien'] = Pasien::find($data['registrasi']->pasien_id);
		$data['folio'] = Folio::where('registrasi_id', $registrasi_id)->where('verif_rj', 'N')->get();
		return view('kasir.verifikasiRJ.detailVerifikasiRJ', $data)->with(['no' => 1, 'baris' => 1]);
	}

	public function saveVerifikasiRJ(Request $request)
	{
		$jumlah = $request['jmlbaris'];
		$jml = [];
		for ($i = 1; $i < $jumlah; $i++) {
			if (!empty($request['verif_rj' . $i])) {
				$fol = Folio::where('id', $request['verif_rj' . $i])->first();
				$fol->verif_rj = 'Y';
				$fol->verif_rj_user = Auth::user()->name;
				$fol->update();

				$reg = Registrasi::find($fol->registrasi_id);
				$reg->verif_rj = 'Y';
				$reg->update();
				array_push($jml, $fol->id);
			}
		}
		$data = Folio::whereIn('id', $jml)->get();
		$pesan = $data->count() . ' tindakan berhasil di verifikasi';
		Flashy::success($pesan);
		return response()->json(['sukses' => true]);
	}

	public function cetakTindakanIGD($registrasi_id)
	{
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'jenis' => 'TG'])->orderBy('created_at')->get();
		$data['jamkesda'] = \App\Jamkesda::where('registrasi_id', $registrasi_id)->first();
		$data['dijamin'] = Folio::where(['registrasi_id' => $registrasi_id, 'jenis' => 'TG'])->sum('dijamin');
		$data['deposit'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('nominal');
		$data['return'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('return');
		$data['jkn'] = Folio::where(['registrasi_id' => $registrasi_id, 'cara_bayar_id' => 1, 'jenis' => 'TG'])->sum('total');
		$data['dibayar'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'Y', 'jenis' => 'TG'])->sum('total');
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'jenis' => 'TG'])->orderBy('created_at')->get();
		$data['status'] = 'igd';
		$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
		$data['detail']		= Folio::leftJoin('mastermapping_biaya', 'mastermapping_biaya.id', '=', 'folios.mapping_biaya_id')
			->where(['folios.registrasi_id' => $registrasi_id, 'jenis' => 'TG'])
			->where('folios.tarif_id', '!=', 10000)
			->groupBy('folios.mapping_biaya_id')
			->selectRaw('SUM(folios.total) as total, mastermapping_biaya.kelompok as nama')->get();
		$data['obat']		= Folio::where(['registrasi_id' => $registrasi_id, 'tarif_id' => 10000, 'jenis' => 'TG'])
			->groupBy('jenis')
			->selectRaw('SUM(total) as total, jenis')->get();

		return view('modules.tindakan.cetak', $data)->with('no', 1);
	}

	public function cetakTindakanRawatJalan($registrasi_id)
	{
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id])->get();
		// $tindakan = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->get();
		$data['lab'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->sum('total');
		$data['rad'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'R'])->sum('total');
		$data['igd'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'G'])->sum('total');
		$data['total'] = Folio::where(['registrasi_id' => $registrasi_id])->sum('total');
		$data['penunjang'] = Folio::where(['registrasi_id' => $registrasi_id])->whereIn('poli_tipe', ['L', 'R', 'G'])->sum('total');
		$data['visite'] = $data['total'] - $data['penunjang'];
		$data['status'] = 'irj';
		$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();

		$data['return'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('return');
		$data['jamkesda'] = \App\Jamkesda::where('registrasi_id', $registrasi_id)->first();
		$data['dijamin'] = Folio::where(['registrasi_id' => $registrasi_id])->sum('dijamin');
		$data['deposit'] = \App\Deposit::where('registrasi_id', $registrasi_id)->sum('nominal');
		$data['jkn'] = Folio::where(['registrasi_id' => $registrasi_id, 'cara_bayar_id' => 1])->sum('total');
		$data['dibayar'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'Y'])->sum('total');
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2])->orderBy('created_at');

		$data['detail']		= Folio::leftJoin('mastermapping_biaya', 'mastermapping_biaya.id', '=', 'folios.mapping_biaya_id')
			->where('folios.registrasi_id', $registrasi_id)
			->where('folios.tarif_id', '!=', 10000)
			->groupBy('folios.mapping_biaya_id')
			->selectRaw('SUM(folios.total) as total, mastermapping_biaya.kelompok as nama')->get();
		$data['obat']		= Folio::where(['registrasi_id' => $registrasi_id, 'tarif_id' => 10000])
			->groupBy('jenis')
			->selectRaw('SUM(total) as total, jenis')->get();
		return view('modules.tindakan.cetak', $data)->with('no', 1);
	}

	// Laboratorium & Radiologi Rawat Jalan
	public function labJalan($reg_id = '')
	{
		// dd
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'L'])
			->get();
		$folio = Folio::where('registrasi_id', $reg_id)->get(['tarif_id']);
		foreach ($folio as $key) {
			$data['select'][] = $key['tarif_id'];
		}
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::whereIn('id', [2, 3])->pluck('nama', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		// $data['perawat'] = Pegawai::where('poli_type', 'L')->whereIn('id',[8,13])->pluck('nama', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'L')->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['tarif'] = Tarif::where('jenis', 'TA')->where('kategoriheader_id', 9)->get(['id', 'nama']); //id header lab
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 9)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['order'] = Orderlab::where(['registrasi_id' => $reg_id, 'jenis' => 'TA'])->get();
		return view('rawat-jalan.laboratorium', $data)->with('no', 1);
	}

	public function lis($reg_id = '')
	{
		// dd
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'L'])
			->get();
		$folio = Folio::where('registrasi_id', $reg_id)->get(['tarif_id']);
		foreach ($folio as $key) {
			$data['select'][] = $key['tarif_id'];
		}
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->pluck('nama', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		// $data['perawat'] = Pegawai::where('poli_type', 'L')->whereIn('id',[8,13])->pluck('nama', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'L')->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['poli'] = Poli::where('politype', 'J')->pluck('nama', 'id');
		$data['tarif'] = Tarif::where('jenis', 'TA')->where('kategoriheader_id', 9)->get(['id', 'nama']); //id header lab
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 9)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['order'] = Orderlab::where(['registrasi_id' => $reg_id, 'jenis' => 'TA'])->get();
		return view('modules.tindakan.lis', $data)->with('no', 1);
	}

	public function simpanLabJalan(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);

		$lab = new Orderlab();
		$lab->jenis = 'TA';
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Laboratorium Sukses');
		// return redirect('tindakan');
		return redirect()->back();
	}

	public function radJalan($reg_id = '')
	{
		//dd("A");
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'R'])
			->get();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::pluck('nama', 'id');
		// $data['pelaksana'] = Pegawai::whereIn('id', '3');
		$data['perawat'] = Pegawai::where('poli_type', 'R')->pluck('nama', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 4)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['order'] = Orderradiologi::where(['registrasi_id' => $reg_id, 'jenis' => 'TA'])->get();
		return view('rawat-jalan.radiologi', $data)->with('no', 1);
	}

	public function simpanRadJalan(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderradiologi();
		$lab->jenis = 'TA';
		$lab->status = 'Y';
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Radiologi Sukses');
		// return redirect('tindakan');
		return redirect()->back();
	}

	public function simpanRadInap(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderradiologi();
		$lab->jenis = 'TI';
		$lab->status = 'Y';
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Radiologi Sukses');
		// return redirect('tindakan');
		return redirect()->back();
	}

	// Laboratorium & Radiologi IGD
	public function labIgd($reg_id = '')
	{

		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'L'])->get();
		$folio = Folio::where('registrasi_id', $reg_id)->get(['tarif_id']);
		foreach ($folio as $key) {
			$data['select'][] = $key['tarif_id'];
		}
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['tarif'] = Tarif::where('jenis', 'TG')->get(['id', 'nama']);
		$data['order'] = Orderlab::where(['registrasi_id' => $reg_id, 'jenis' => 'TG'])->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');

		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::pluck('nama', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'L')->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 9)->where('tarifs.jenis', '=', 'TG')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['order'] = Orderlab::where(['registrasi_id' => $reg_id, 'jenis' => 'TG'])->get();
		return view('igd.laboratorium', $data)->with('no', 1);
	}

	public function simpanLabIgd(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);

		$lab = new Orderlab();
		$lab->jenis = 'TG';
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Laboratorium Sukses');
		return redirect('tindakan/igd');
	}

	public function simpanLabInap(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);
		$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $request['registrasi_id'])->first();
		$lab = new Orderlab();
		$lab->jenis = 'TI';
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->kamar_id = @$irna->kamar_id;
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Laboratorium Sukses');
		return redirect()->back();
	}


	public function radIgd($reg_id = '')
	{
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'R'])
			->get();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		// $data['pelaksana'] = Pegawai::whereIn('id', ['206'])->pluck('nama', 'id');
		$data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->pluck('nama', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'R')->pluck('nama', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 11)->where('tarifs.jenis', '=', 'TG')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['order'] = Orderradiologi::where(['registrasi_id' => $reg_id, 'jenis' => 'TG'])->get();
		return view('igd.radiologi', $data)->with('no', 1);
	}

	public function simpanRadIgd(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderradiologi();
		$lab->jenis  = 'TG';
		$lab->status = 'Y';
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Radiologi Sukses');
		return redirect('tindakan/igd');
	}

	public function lunaskanTindakan(Request $request)
	{
		foreach ($request->lunas as $key) {
			$id = (int) $key;
			$folio = Folio::find($id);
			$folio->lunas = 'Y';
			$folio->update();
		}
		Flashy::success('Tindakan berhasil di bayarkan / lunas');
		return response()->json(['sukses' => true]);
	}

	public function belumLunas(Request $request)
	{
		foreach ($request->lunas as $key) {
			$id = (int) $key;
			$folio = Folio::find($id);
			$folio->lunas = 'N';
			$folio->update();
		}
		Flashy::success('Tindakan berhasil');
		return response()->json(['sukses' => true]);
	}

	// E Resep
	public function getRegistrasi(Request $request, $reg_id)
	{
		$find = Registrasi::with('pasien', 'bayars')->find($reg_id);
		$res = [
			"status" => true,
			"data" => $find,
			"poli" => @$find->poli
		];
		return response()->json($res);
	}

	public function saveDetailResep(Request $request)
	{
		DB::beginTransaction();
		try {
			$cekStok = LogistikBatch::find($request->masterobat_id)->stok;
			if ($request->qty <= '0' || empty($request->qty)) {
				return $res = [
					"status" => false,
					// "data" => "Stok saat ini tersisa : ".$cekStok.", Masukkan jumlah sesuai sisa stok, Pastikan jumlah yang diinput sesuai, atau obat sudah sudah habis terinput oleh perawat lain"
					"data" => "Masukkan Jumlah Obat"
				];
			}


			$id_medication_req = NULL;
			if (!empty($request->uuid)) { // update
				$resep = ResepNote::where('uuid', $request->uuid)->where('registrasi_id', $request->reg_id)->first();
				if (Satusehat::find(8)->aktif == 1) {
					if (satusehat()) {
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

						@$response_token = curl_exec($curl_token);
						@$token = @json_decode($response_token);
						@$access_token = @$token->access_token;
						// dd($access_token);
						curl_close($curl_token);
						// END OF API TOKEN

						@$urlcreatemedicationrequest = config('app.create_medicationrequest');
						@$organization = config('app.organization_id');
						@$id_medication = Masterobat::find(LogistikBatch::find($request->masterobat_id)->masterobat_id);
						@$pasien = Pasien::find(Registrasi::find(ResepNote::find($resep->id)->registrasi_id)->pasien_id);
						@$dokter = Pegawai::find(Registrasi::find(ResepNote::find($resep->id)->registrasi_id)->dokter_id);
						@$id_encounter = Registrasi::find(ResepNote::find($resep->id)->registrasi_id)->id_encounter_ss;
						$today = date("Y-m-d");
						// dd($id_medication->id_medication);

						$curl = curl_init();
						$body = '{
							"resourceType": "MedicationRequest",
							"identifier": [
								{
									"system": "http://sys-ids.kemkes.go.id/prescription/' . $organization . '",
									"use": "official",
									"value": ""
								},
								{
									"system": "http://sys-ids.kemkes.go.id/prescription-item/' . $organization . '",
									"use": "official",
									"value": ""
								}
							],
							"status": "completed",
							"intent": "order",
							"category": [
								{
									"coding": [
										{
											"system": "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
											"code": "outpatient",
											"display": "Outpatient"
										}
									]
								}
							],
							"priority": "routine",
							"medicationReference": {
								"reference": "Medication/' . @$id_medication->id_medication . '",
								"display": "' . @$id_medication->nama_obat . '"
							},
							"subject": {
								"reference": "Patient/' . @$pasien->id_patient_ss . '",
								"display": "' . @$pasien->nama . '"
							},
							"encounter": {
								"reference": "Encounter/' . @$id_encounter . '"
							},
							"authoredOn": "' . @$today . '",
							"requester": {
								"reference": "Practitioner/' . @$dokter->id_dokterss . '",
								"display": "' . @$dokter->nama . '"
							},  
							"courseOfTherapyType": {
								"coding": [
									{
										"system": "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
										"code": "continuous",
										"display": "Continuing long term therapy"
									}
								]
							}
						}';
						curl_setopt_array($curl, array(
							CURLOPT_URL => $urlcreatemedicationrequest,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => '',
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 0,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => 'POST',
							CURLOPT_POSTFIELDS => $body,
							CURLOPT_HTTPHEADER => array(
								'Authorization: Bearer ' . @$access_token . '',
								'Content-Type: application/json'
							),
						));

						@$response = curl_exec($curl);
						@$id_medicationrequest = json_decode($response);
						// dd($id_medicationrequest->id);
						if (!empty($id_medicationrequest->id)) {
							@$id_medication_req = $id_medicationrequest->id;
						} else {
							@$id_medication_req = NULL;
						}

						curl_close($curl);
					}
				}


				if ($request->jenis_obat == 'racikan') {
					$resep->jenis_resep = 'racikan';
					$resep->save();
				}

				if ($request->kronis == 'Y') {
					$resep->jenis_resep = 'kronis';
					$resep->save();
				}

				$detail = [
					"is_empty" => $cekStok <= '100' ? '1' : '0', //jika kurang dari 100 maka 1
					"resep_note_id" => $resep->id,
					"logistik_batch_id" => $request->masterobat_id,
					"obat_racikan" => $request->jenis_obat == 'racikan' ? 'Y' : 'N',
					"kronis" => $request->kronis,
					"qty" => $request->qty,
					"cara_bayar" => $request->cara_bayar,
					"tiket" => $request->tiket,
					"cara_minum" => $request->cara_minum,
					"takaran" => $request->takaran,
					"informasi" => $request->informasi,
					"id_medication_request" => $id_medication_req,
				];
				$resp = ResepNoteDetail::create($detail);
			} else { // create
				// Jika mendapatkan source
				if ($request->source) {
					$unit = $request->source;
					if ($unit == 'jalan') {
						$uuid = 'ERJ' . date('YmdHis');
					} elseif ($unit == 'inap') {
						$uuid = 'ERI' . date('YmdHis');
					} elseif ($unit == 'igd') {
						$uuid = 'ERD' . date('YmdHis');
					}
				} else {
					$uuid = 'ERJ' . date('YmdHis');
				}
				$re = Registrasi::where('id', $request->reg_id)->first();

				// $reg_last = Registrasi::where('pasien_id',$re->pasien_id)->orderBy('id','DESC')->first()->id;
				// if(!$reg_last){
				$reg_last = $request->reg_id;
				// }
				$data = [
					"uuid" => $uuid,
					"source" => $request->source,
					"registrasi_id" => $reg_last,
					"pasien_id" => $request->pasien_id,
					"created_by" => Auth::user()->id,
				];
				if ($request->jenis_obat == 'racikan') {
					$data['jenis_resep'] = 'racikan';
				}
				if ($request->kronis == 'Y') {
					$data['jenis_resep'] = 'kronis';
				}
				// dd($data);
				$resep = ResepNote::create($data);
				$id_medication_req = NULL;
				if (Satusehat::find(8)->aktif == 1) {
					if (satusehat()) {
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

						$urlcreatemedicationrequest = config('app.create_medicationrequest');
						$organization = config('app.organization_id');
						$id_medication = Masterobat::find(LogistikBatch::find($request->masterobat_id)->masterobat_id);
						$pasien = Pasien::find(Registrasi::find(ResepNote::find($resep->id)->registrasi_id)->pasien_id);
						$dokter = Pegawai::find(Registrasi::find(ResepNote::find($resep->id)->registrasi_id)->dokter_id);
						$id_encounter = Registrasi::find(ResepNote::find($resep->id)->registrasi_id)->id_encounter_ss;
						$today = date("Y-m-d");
						// dd($id_medication->id_medication);

						$curl = curl_init();
						$body = '{
							"resourceType": "MedicationRequest",
							"identifier": [
								{
									"system": "http://sys-ids.kemkes.go.id/prescription/' . $organization . '",
									"use": "official",
									"value": ""
								},
								{
									"system": "http://sys-ids.kemkes.go.id/prescription-item/' . $organization . '",
									"use": "official",
									"value": ""
								}
							],
							"status": "completed",
							"intent": "order",
							"category": [
								{
									"coding": [
										{
											"system": "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
											"code": "outpatient",
											"display": "Outpatient"
										}
									]
								}
							],
							"priority": "routine",
							"medicationReference": {
								"reference": "Medication/' . $id_medication->id_medication . '",
								"display": "' . $id_medication->nama_obat . '"
							},
							"subject": {
								"reference": "Patient/' . $pasien->id_patient_ss . '",
								"display": "' . $pasien->nama . '"
							},
							"encounter": {
								"reference": "Encounter/' . $id_encounter . '"
							},
							"authoredOn": "' . $today . '",
							"requester": {
								"reference": "Practitioner/' . $dokter->id_dokterss . '",
								"display": "' . $dokter->nama . '"
							},  
							"courseOfTherapyType": {
								"coding": [
									{
										"system": "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
										"code": "continuous",
										"display": "Continuing long term therapy"
									}
								]
							}
						}';
						curl_setopt_array($curl, array(
							CURLOPT_URL => $urlcreatemedicationrequest,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => '',
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 0,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => 'POST',
							CURLOPT_POSTFIELDS => $body,
							CURLOPT_HTTPHEADER => array(
								'Authorization: Bearer ' . $access_token . '',
								'Content-Type: application/json'
							),
						));

						$response = curl_exec($curl);
						$id_medicationrequest = json_decode($response);
						// dd($id_medicationrequest->id);
						if (!empty($id_medicationrequest->id)) {
							$id_medication_req = $id_medicationrequest->id;
						} else {
							$id_medication_req = NULL;
						}

						curl_close($curl);
					}
				}

				$detail = [
					"resep_note_id" => $resep->id,
					"is_empty" => $cekStok <= '100' ? '1' : '0', //jika kurang dari 100 maka 1
					"logistik_batch_id" => $request->masterobat_id,
					"kronis" => $request->kronis,
					"qty" => $request->qty,
					"cara_bayar" => $request->cara_bayar,
					"tiket" => $request->tiket,
					"cara_minum" => $request->cara_minum,
					"takaran" => $request->takaran,
					"obat_racikan" => $request->jenis_obat == 'racikan' ? 'Y' : 'N',
					"informasi" => $request->informasi,
					"id_medication_request" => $id_medication_req,
				];
				ResepNoteDetail::create($detail);
			}
			$show = ResepNoteDetail::where('resep_note_id', $resep->id)->get();
			// dd($show);
			$re = Registrasi::where('id', $request->reg_id)->first();
			$html = '';
			$total = 0;
			$total_jkn = 0;
			foreach ($show as $key => $val) {
				// dd($val->logistik_batch);
				if ($val->id_medication_request != null) {
					$i =  '<i class="fa fa-check"></i>';
				} else {
					$i = "-";
				}

				$hargaTotal = $val->logistik_batch->hargajual_umum;
				if ($re->poli->kelompok == 'ESO') {
					$cyto = ($hargaTotal * 30) / 100;
					$hargaTotal = $hargaTotal + $cyto;
				}

				if ($val->is_empty == '1') {
					$html .= '<tr>
							<td>' . ($key + 1) . '</td>
							<td style="color: red;">' . @$val->logistik_batch->master_obat->nama . '</td>
							<td data-id="' . $val->id . '" style="width: 10%;"><input onblur="editQty(' . $val->id . ')" style="width: 100%;" type="number" name="edit-qty-' . $val->id . '" value="' . $val->qty . '"/></td>
							<td>' . $val->cara_bayar . '</td>
							<td>' . 'Rp. ' . number_format($hargaTotal) . '</td>
							<td>' . $val->cara_minum . '</td>
							<td>' . $val->obat_racikan . '</td>
							<td>' . $val->informasi . '</td>
							<td>
								<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</td>
							</tr>';
				} else {
					$html .= '<tr>
							<td>' . ($key + 1) . '</td>
							<td>' . @$val->logistik_batch->master_obat->nama . '</td>
							<td data-id="' . $val->id . '" style="width: 10%;"><input onblur="editQty(' . $val->id . ')" style="width: 100%;" type="number" name="edit-qty-' . $val->id . '" value="' . $val->qty . '"/></td>
							<td>' . $val->cara_bayar . '</td>
							<td>' . 'Rp. ' . number_format($hargaTotal) . '</td>
							<td>' . $val->cara_minum . '</td>
							<td>' . $val->obat_racikan . '</td>
							<td>' . $val->informasi . '</td>
							<td>
								<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</td>
							</tr>';
				}
				$total += $hargaTotal * $val->qty;
				// $total_jkn += $val->logistik_batch->master_obat->hargajual_jkn * $val->qty;
			}

			DB::commit();
			$res = [
				"status" => true,
				"html" => $html,
				"uuid" => $resep->uuid,
				'total' => 'Rp. ' . number_format($total),
				'show_warning' => $total > 70000 ? true : false
				// 'total_jkn' => 'Rp. ' . number_format($total_jkn),
			];
			return response()->json($res);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json([
				"status" => false,
				"data" => $e->getMessage(),
				"line" => $e->getLine()
			]);
		}
	}

	public function getPaketFarmasi($id)
	{
		try {
			$paket = BiayaFarmasi::with(['detail.masterobat'])->findOrFail($id);

			$details = $paket->detail->map(function($d) {
				return [
					'masterobat_id' => $d->masterobat_id,
					'nama'          => $d->masterobat->nama ?? '-',
					'qty'           => $d->qty ?? 0,
					'cara_minum'    => $d->cara_minum ?? null,
					'takaran'       => $d->takaran ?? null,
					'tiket'         => $d->tiket ?? null,
					'informasi'     => $d->informasi ?? null,
					'jenis_obat'    => $d->jenis ?? 'non_racik',
				];
			});

			return response()->json([
				'status' => true,
				'data' => [
					'id'         => $paket->id,
					'nama_biaya' => $paket->nama_biaya,
					'details'    => $details
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status'  => false,
				'message' => $e->getMessage()
			], 500);
		}
	}

	public function saveDetailResepIGD(Request $request)
	{

		DB::beginTransaction();
		try {
			if (!empty($request->uuid)) { // update
				$resep = ResepNote::where('uuid', $request->uuid)->first();
				$detail = [
					"resep_note_id" => $resep->id,
					"logistik_batch_id" => $request->masterobat_id,
					"qty" => $request->qty,
					"cara_bayar" => $request->cara_bayar,
					"tiket" => $request->tiket,
					"cara_minum" => $request->cara_minum,
					"takaran" => $request->takaran,
					"informasi" => $request->informasi,
				];
				ResepNoteDetail::create($detail);
			} else { // create
				// $reg_last = Registrasi::where('id',$request->pasien_id)->orderBy('id','DESC')->first();
				// if(!$reg_last){
				$reg_last = $request->reg_id;
				// }
				$uuid = 'ERD' . date('YmdHis');
				$data = [
					"uuid" => $uuid,
					"source" => $request->source,
					"registrasi_id" => $reg_last,
					"pasien_id" => $request->pasien_id,
					"created_by" => Auth::user()->id,
				];

				$resep = ResepNote::create($data);
				$detail = [
					"resep_note_id" => $resep->id,
					"logistik_batch_id" => $request->masterobat_id,
					"qty" => $request->qty,
					"cara_bayar" => $request->cara_bayar,
					"tiket" => $request->tiket,
					"cara_minum" => $request->cara_minum,
					"takaran" => $request->takaran,
					"informasi" => $request->informasi,
				];
				ResepNoteDetail::create($detail);
			}
			$show = ResepNoteDetail::where('resep_note_id', $resep->id)->get();
			// dd($show);
			$html = '';
			foreach ($show as $key => $val) {
				// dd($val->logistik_batch);
				$html .= '<tr>
						<td>' . ($key + 1) . '</td>
						<td>' . @$val->logistik_batch->master_obat->nama . '</td>
						<td>' . $val->qty . '</td>
						<td>' . $val->cara_bayar . '</td>
						<td>' . $val->tiket . '</td>
						<td>' . $val->cara_minum . '</td>
						<td>' . $val->takaran . '</td>
						<td>' . $val->informasi . '</td>
						<td>
							<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
						</tr>';
			}

			DB::commit();
			$res = [
				"status" => true,
				"html" => $html,
				"uuid" => $resep->uuid
			];
			return response()->json($res);
		} catch (Exception $e) {
			DB::rollback();
			$res = [
				"status" => false,
				"data" => ""
			];
			return response()->json($res);
		}
	}

	public function deleteDetailResep(Request $request, $id)
	{
		$find = ResepNoteDetail::find($id);
		// delete
		$find->delete();
		if (isset($find->id)) {
			$show = ResepNoteDetail::with(['logistik_batch.master_obat'])->where('resep_note_id', $find->resep_note_id)->get();
			$html = '';
			$total = 0;
			foreach ($show as $key => $val) {
				if ($val->logistik_batch['stok'] <= 0) {
					$stok = '<i style="color:red;font-size:11px;">Stok Kurang atau habis</i>';
				} else {
					$stok = $val->logistik_batch['stok'];
				}
				$html .= '<tr>
					<td>' . ($key + 1) . '</td>
					<td style="color: red;">' . @$val->logistik_batch->master_obat->nama . '</td>
					<td data-id="' . $val->id . '" style="width: 10%;"><input onblur="editQty(' . $val->id . ')" style="width: 100%;" type="number" name="edit-qty-' . $val->id . '" value="' . $val->qty . '"/></td>
					<td>' . $val->cara_bayar . '</td>
					<td>' . 'Rp. ' . number_format($val->logistik_batch->hargajual_umum) . '</td>
					<td>' . $val->cara_minum . '</td>
					<td>' . $val->obat_racikan . '</td>
					<td>' . $val->informasi . '</td>
					<td>
						<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
					</td>
					</tr>';
				$total += $val->logistik_batch->hargajual_umum * $val->qty;
			}
			$res = [
				"status" => true,
				"html" => $html,
				'total' => 'Rp. ' . number_format($total),
			];
			return response()->json($res);
		}
		$res = [
			"status" => false,
			"html" => '<tr colspan="9" class="text-center">
					<td>Data Tidak Ada</td>
					</tr>',
		];
		return response()->json($res);
	}

	public function editQtyDetailResep(Request $request, $id)
	{
		$find = ResepNoteDetail::find($id);
		// dd($find);
		$find->update($request->all());
		if (isset($find->id)) {
			$show = ResepNoteDetail::with(['logistik_batch.master_obat'])->where('resep_note_id', $find->resep_note_id)->get();
			$html = '';
			$total = 0;
			foreach ($show as $key => $val) {
				if ($val->logistik_batch['stok'] <= 0) {
					$stok = '<i style="color:red;font-size:11px;">Stok Kurang atau habis</i>';
				} else {
					$stok = $val->logistik_batch['stok'];
				}
				if ($val->id_medication_request != null) {
					$i =  '<i class="fa fa-check"></i>';
				} else {
					$i = "-";
				}
				$html .= '<tr>
						<td>' . ($key + 1) . '</td>
						<td style="color: red;">' . @$val->logistik_batch->master_obat->nama . '</td>
						<td data-id="' . $val->id . '" style="width: 10%;"><input onblur="editQty(' . $val->id . ')" style="width: 100%;" type="number" name="edit-qty-' . $val->id . '" value="' . $val->qty . '"/></td>
						<td>' . $val->cara_bayar . '</td>
						<td>' . 'Rp. ' . number_format($val->logistik_batch->hargajual_umum) . '</td>
						<td><input onchange="editSigna(' . $val->id . ')" style="width: 100%;" type="text" name="edit-signa-' . $val->id . '" value="' . $val->cara_minum . '"/></td>
						<td>' . $val->obat_racikan . '</td>
						<td>' . $val->informasi . '</td>
						<td>
							<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
						</tr>';
				$total += $val->logistik_batch->hargajual_umum * $val->qty;
			}
			$res = [
				"status" => true,
				"html" => $html,
				"total" => 'Rp. ' . number_format($total),
			];
			return response()->json($res);
			// return redirect()->back();
		}
		$res = [
			"status" => false,
			"html" => '<tr colspan="8" class="text-center">
					<td>Data Tidak Ada</td>
					</tr>',
		];
		return response()->json($res);
	}
	public function editSigna(Request $request, $id)
	{
		$find = ResepNoteDetail::where('id', $id)->first();
		// dd($find);
		// dd($request->all());
		if (isset($find->id)) {
			$find->cara_minum = $request->signa;
			$find->save();

			$res = [
				"status" => true
			];
			return response()->json($res);
			// return redirect()->back();
		}
		$res = [
			"status" => false,
			"html" => '<tr colspan="8" class="text-center">
					<td>Data Tidak Ada</td>
					</tr>',
		];
		return response()->json($res);
	}

	public function saveResep(Request $request)
	{
		$find = ResepNote::where('uuid', $request->uuid)->first();

		if (empty($find)) {
			return response()->json([
				'status' => false,
				'message' => 'Eresep tidak ditemukan, mohon refresh halaman dan input ulang eresep!'
			]);
		}


		$dt['reg'] = Registrasi::find($find->registrasi_id);
		// sleep(2);

		// if ($dt['reg']->poli->kelompok == 'ESO') {
		// 	$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
		// 		->join('polis', 'polis.id', '=', 'registrasis.poli_id')
		// 		->where('polis.kelompok', 'ESO')
		// 		->where('resep_note.is_done_input', "1")
		// 		->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// 		->count();
		// 	$kelompok = 'EKS';
		// } else {
		// 	if ($dt['reg']->bayar == '1') {
		// 		$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
		// 			->where('registrasis.bayar', '1')
		// 			->where('resep_note.is_done_input', "1")
		// 			->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// 			->count();
		// 	} else {
		// 		$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
		// 			->where('registrasis.bayar', '!=', '1')
		// 			->where('resep_note.is_done_input', "1")
		// 			->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// 			->count();
		// 		$kelompok = 'U';
		// 	}
		// }

		$query = ResepNote::where('is_done_input', "1")
			->whereBetween('created_at', [date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59']);

		if ($dt['reg']->poli->kelompok == 'ESO') {
			$count = $query->whereHas('registrasi.poli', function ($q) {
				$q->where('kelompok', 'ESO');
			})->count();
			$kelompok = 'EKS';
		} else {
			if ($dt['reg']->bayar == '1') {
				$count = $query->whereHas('registrasi', function ($q) {
					$q->where('bayar', '1');
				})->count();
			} else {
				$count = $query->whereHas('registrasi', function ($q) {
					$q->where('bayar', '!=', '1');
				})->count();
				$kelompok = 'U';
			}
		}

		$resep_note_detail = ResepNoteDetail::leftJoin('logistik_batches', 'logistik_batches.id', '=', 'resep_note_detail.logistik_batch_id')->where('resep_note_detail.resep_note_id', $find->id)->where('logistik_batches.stok', '<=', '0')->count();
		// if ($resep_note_detail > 0) {
		// 	return $res = [
		// 		"status" => false,
		// 		"message" => 'Ada obat yang stok kosong atau kurang, harap dihapus atau diedit, sebelum simpan'
		// 	];
		// }
		if (substr($dt['reg']->status_reg, 0, 1) == 'J') {
			$unit = 'jalan';
		} elseif (substr($dt['reg']->status_reg, 0, 1) == 'G') {
			$unit = 'igd';
		} else {
			$unit = 'inap';
		}

		$data = [
			"status" => "dikirim",
			"is_done_input" => "1",
			"signa_peracikan" => @$request->signa_peracikan,
			"poli_id" => @$request->poli_id,
			"nama_racikan" => @$request->nama_racikan,
			"nomor" => $count + 1,
			"input_from" => url()->full(),
			"kelompok" => @$kelompok ?? NULL,
		];
		$res = [
			"regId" => @$dt['reg']->id,
			"unit" => $unit,
			"status" => true,
		];
		// dd($data);
		$dt['detail'] = ResepNoteDetail::where('resep_note_id', $find->id)->get();

		$dt['nama_racikan'] = $find->nama_racikan;
		$dt['no_resep'] = $find->no_resep;
		$dt['signa_peracikan'] = $find->signa_peracikan;

		DB::beginTransaction();
		try {
			LogUserController::log(Auth::user()->id, 'eresep', @$dt['reg']->id);
			$find->update($data);

			if ($request->proses_tte == "true") {
				if (tte()) {
					// Proses TTE
					// Buat PDF
					$dt['proses_tte'] = true;
					$pdf = PDF::loadView('farmasi.laporan.resepDokter', $dt);
					$pdf->setPaper('A4', 'potret');
					$pdfContent = $pdf->output();

					// Create temp pdf eresep file
					$filePath = uniqId() . 'eresep.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(500)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

					log_esign($dt['reg']->id, $tte->response, "eresep-dokter", $tte->httpStatusCode);

					$resp = json_decode($tte->response);
					if ($tte->httpStatusCode == 200) {
						$find->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$find->save();
						DB::commit();
						return response()->json($res);
					} elseif ($tte->httpStatusCode == 400) {
						if (isset($resp->error)) {
							$res['message'] = $resp->error;
						} else {
							$res['message'] = null;
						}
					} elseif ($tte->httpStatusCode == 500) {
						$res['message'] = $tte->response;
					}
					DB::rollback();
					log_esign($dt['reg']->id, $tte->response, "eresep-dokter", $tte->httpStatusCode);
					$res['status'] = false;
					return response()->json($res);
				} else {
					DB::commit();
					return response()->json($res);
				}
			} else {
				DB::commit();
				return response()->json($res);
			}
		} catch (\Exception $e) {
			DB::rollback();
			$res['status'] = false;
			return response()->json($res);
		}
	}

	public function saveResepDuplicate(Request $request)
	{
		DB::beginTransaction();
		try {
			$find = ResepNote::where('uuid', $request->uuid)->first();
			@$reg = Registrasi::find($find->registrasi_id);
			if ($reg->bayar == '1') {
				$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
					->where('registrasis.bayar', '1')
					->where('resep_note.is_done_input', "1")
					->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
					->count();
			} else {
				$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
					->where('registrasis.bayar', '!=', '1')
					->where('resep_note.is_done_input', "1")
					->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
					->count();
				$kelompok = 'U';
			}
			// if($find){
			$find->status = "dikirim";
			$find->is_done_input = "1";
			$find->poli_id = @$request->poli_id;
			$find->signa_peracikan = @$request->signa_peracikan;
			$find->nama_racikan = @$request->nama_racikan;
			$find->kelompok = @$kelompok ?? NULL;
			$find->nomor = $count + 1;
			$find->input_from = url()->full();
			$find->save();
			// }
			// dd($find);

			$uuid = 'ERJ' . date('YmdHis');
			$data = [
				"id"   => $find->id,
				"uuid" => $find->uuid,
				"source" => $find->source,
				"nama_racikan" => $find->nama_racikan,
				"signa_peracikan" => @$find->signa_peracikan,
				"status" => $find->status,
				"registrasi_id" => $find->registrasi_id,
				"pasien_id" => @$reg->pasien_id,
				"poli_id" => @$find->poli_id,
				"is_done_input" => "1",
				"created_by" => Auth::user()->id,
			];

			$resep = ResepNoteDuplicate::create($data);

			$res = [
				"status" => true,
			];

			$dt['detail'] = ResepNoteDetail::where('resep_note_id', $find->id)->get();
			$dt['reg'] = Registrasi::find($find->registrasi_id);
			$dt['nama_racikan'] = $find->nama_racikan;
			$dt['no_resep'] = $find->no_resep;
			$dt['signa_peracikan'] = @$find->signa_peracikan;
			LogUserController::log(Auth::user()->id, 'eresep', @$dt['reg']->id);
			// Proses TTE
			if ($request->proses_tte == "true") {
				if (tte()) {
					// Proses TTE
					// Buat PDF
					$dt['proses_tte'] = true;
					$pdf = PDF::loadView('farmasi.laporan.resepDokter', $dt);
					$pdf->setPaper('A4', 'potret');
					$pdfContent = $pdf->output();

					// Create temp pdf eresep file
					$filePath = uniqId() . 'eresep.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(500)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

					log_esign($dt['reg']->id, $tte->response, "eresep-dokter", $tte->httpStatusCode);

					$resp = json_decode($tte->response);
					if ($tte->httpStatusCode == 200) {
						$find->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$find->save();
						DB::commit();
						return response()->json($res);
					} elseif ($tte->httpStatusCode == 400) {
						if (isset($resp->error)) {
							$res['message'] = $resp->error;
						} else {
							$res['message'] = null;
						}
					} elseif ($tte->httpStatusCode == 500) {
						$res['message'] = $tte->response;
					}
					DB::rollback();
					log_esign($dt['reg']->id, $tte->response, "eresep-dokter", $tte->httpStatusCode);
					$res['status'] = false;
					return response()->json($res);
				} else {
					DB::commit();
					return response()->json($res);
				}
			} else {
				DB::commit();
				return response()->json($res);
			}
		} catch (Exception $e) {
			DB::rollback();
			$res = [
				"status" => false,
				"message" => $e
			];
			return response()->json($res);
		}
	}

	public function saveResepDuplicateNext(Request $request)
	{
		DB::beginTransaction();
		try {
			$find = ResepNote::where('uuid', $request->uuid)->first();
			$resep_note_detail = ResepNoteDetail::leftJoin('logistik_batches', 'logistik_batches.id', '=', 'resep_note_detail.logistik_batch_id')->where('resep_note_detail.resep_note_id', $find->id)->where('logistik_batches.stok', '<=', '0')->count();
			// if ($resep_note_detail > 0) {
			// 	return $res = [
			// 		"status" => false,
			// 		"message" => 'Ada obat yang stok kosong atau kurang, harap dihapus atau diedit, sebelum simpan'
			// 	];
			// }
			@$reg = Registrasi::find($find->registrasi_id);
			if ($reg->bayar == '1') {
				$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
					->where('registrasis.bayar', '1')
					->where('resep_note.is_done_input', "1")
					->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
					->count();
			} else {
				$count = ResepNote::join('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
					->where('registrasis.bayar', '!=', '1')
					->where('resep_note.is_done_input', "1")
					->whereBetween('resep_note.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
					->count();
				$kelompok = 'U';
			}
			// if($find){
			$find->status = "dikirim";
			$find->is_done_input = "1";
			$find->poli_id = @$request->poli_id;
			$find->signa_peracikan = @$request->signa_peracikan;
			$find->nama_racikan = @$request->nama_racikan;
			$find->kelompok = @$kelompok ?? NULL;
			$find->nomor = $count + 1;
			$find->input_from = url()->full();
			$find->save();
			// }
			// dd($find);

			$uuid = 'ERJ' . date('YmdHis');
			$data = [
				"id"   => $find->id,
				"uuid" => $find->uuid,
				"source" => $find->source,
				"nama_racikan" => $find->nama_racikan,
				"signa_peracikan" => @$find->signa_peracikan,
				"status" => $find->status,
				"registrasi_id" => $find->registrasi_id,
				"pasien_id" => @$reg->pasien_id,
				"poli_id" => @$find->poli_id,
				"is_done_input" => "1",
				"created_by" => Auth::user()->id,
			];
			// dd($data);

			$resep = ResepNoteDuplicate::create($data);
			LogUserController::log(Auth::user()->id, 'eresep', @$find->registrasi_id);
			if (substr($reg->status_reg, 0, 1) == 'J') {
				$unit = 'jalan';
			} elseif (substr($reg->status_reg, 0, 1) == 'G') {
				$unit = 'igd';
			} else {
				$unit = 'inap';
			}

			$res = [
				"regId" => $reg->id,
				"unit" => $unit,
				"status" => true,
			];
			DB::commit();
			return response()->json($res);
		} catch (Exception $e) {
			DB::rollback();
			$res = [
				"status" => false,
				"data" => ""
			];
			return response()->json($res);
		}
	}


	public function getHistoryResep(Request $request, $reg_id)
	{
		$reg = Registrasi::find($reg_id);
		// $data = ResepNote::with('resep_detail.logistik_batch.master_obat')->whereNotNull('status')->where('registrasi_id', $reg_id)->get();
		$data = ResepNote::with('resep_detail.logistik_batch.master_obat')->whereNotNull('status')->where('pasien_id', $reg->pasien_id)->get();
		$html = '';
		if (count($data) == 0) {
			$html = '<p class="text-center">Belum Ada E-Resep :)</p>';
		}
		foreach ($data as $key => $val) {
			$detail = '';
			foreach ($val->resep_detail as $k => $v) {
				$detail .= '<tr>
							<td>' . ($k + 1) . '</td>
							<td>' . $v->logistik_batch->master_obat->nama . '</td>
							<td>' . $v->qty . '</td>
							</tr>';
			}
			$stat = ($val->status == "diproses") ? '<span class="text-success"><i class="fa fa-check-square" aria-hidden="true"></i>
			</span>' : '';
			$comment = '<tr><td>Keterangan </td><td colspan="2"><i>' . $val->comment . '</i></td></tr>';
			$html .= '<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>' . $val->uuid . '</th>
					<th class="text-center">' . $stat . '</th>
				</tr>
				<tr>
					<td>No</td>
					<td>Nama Obat</td>
					<td>Qty</td>
				</tr>
				' . $detail . '
				' . $comment . '
				</table>';
		}
		$res = [
			"status" => true,
			"html" => $html,
		];
		return response()->json($res);
	}
	// End E Resep

	public function ajaxTindakan(Request $request, $status_reg, $kelas_id = NULL)
	{


		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		if ($status_reg == 'J') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TA')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.total', '<>', 0)
				->where('tarifs.is_aktif', 'Y')
				->whereNotIn('tarifs.kategoriheader_id', [10])
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->groupBy('tarifs.total')
				->orderBy('tarifs.id', 'DESC')
				->limit(50)
				->get();
			if (count($tags) == 0) {
				$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
					->where('tarifs.jenis', '=', 'TA')
					->Where('tarifs.kode', 'like', '%' . $term . '%')
					->where('tarifs.total', '<>', 0)
					->where('tarifs.is_aktif', 'Y')
					->whereNotIn('tarifs.kategoriheader_id', [10])
					->select('tarifs.*', 'kategoritarifs.namatarif')
					->groupBy('tarifs.nama')
					->groupBy('tarifs.total')
					->orderBy('tarifs.id', 'DESC')
					->limit(50)
					->get();
			}
		} elseif ($status_reg == 'G') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TG')
				->where('tarifs.is_aktif', 'Y')
				->whereNotIn('tarifs.kategoriheader_id', [10])
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->limit(50)
				->groupBy('tarifs.nama')
				->groupBy('tarifs.total')
				->get();
			if (count($tags) == 0) {
				$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
					->where('tarifs.jenis', '=', 'TG')
					->where('tarifs.is_aktif', 'Y')
					->whereNotIn('tarifs.kategoriheader_id', [10])
					->where('tarifs.kode', 'like', '%' . $term . '%')
					->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
					->limit(50)
					->groupBy('tarifs.nama')
					->groupBy('tarifs.total')
					->get();
			}
		} else {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TI')
				->where('tarifs.kelas_id', '=', $kelas_id)
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->where('tarifs.is_aktif', 'Y')
				->whereNotIn('tarifs.kategoriheader_id', [10])
				->groupBy('tarifs.nama')
				->groupBy('tarifs.total')
				->orderBy('tarifs.id', 'DESC')
				->limit(50)
				->get();
			if (count($tags) == 0) {
				$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
					->where('tarifs.jenis', '=', 'TI')
					->where('tarifs.is_aktif', 'Y')
					->whereNotIn('tarifs.kategoriheader_id', [10])
					// ->where('tarifs.kode', 'like', '%' . $term . '%')
					->where(function ($query) use ($term) {
						// $query->where('poli_tipe', '=', 'J')
						$query->where('tarifs.kode', 'like', '%' . $term . '%')
							->orWhere('tarifs.nama', 'like', '%' . $term . '%');
					})
					->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
					->groupBy('tarifs.nama')
					->groupBy('tarifs.total')
					->orderBy('tarifs.id', 'DESC')
					->limit(50)
					->get();
			}
		}


		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . @$tag->kode  . ' | ' . @number_format(@$tag->total)];
		}
		return \Response::json($formatted_tags);
	}
	public function ajaxTindakanLis(Request $request, $status_reg)
	{
		// dd($status_reg);
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		if ($status_reg == 'J') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TA')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoritarif_id', '!=', 188)
				->where('tarifs.total', '<>', 0)
				->whereNotNull('tarifs.lica_id')
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->limit(50)
				->get();
		} elseif ($status_reg == 'G') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TG')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoritarif_id', '!=', 188)
				->whereNotNull('tarifs.lica_id')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->limit(50)
				->groupBy('tarifs.nama')
				->get();
		} else {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TI')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoritarif_id', '!=', 188)
				->whereNotNull('tarifs.lica_id')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->limit(50)
				->get();
		}

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$list_tag = $tag->lica_id == 0 ? 'NON LIS' : 'LIS';
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . @$tag->kode  . ' | ' . @number_format($tag->total) . '-' . $list_tag];
		}
		return \Response::json($formatted_tags);
	}

	public function ajaxTindakanLab(Request $request, $status_reg)
	{
		// dd($status_reg);
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		if ($status_reg == 'J') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TA')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoritarif_id', '!=', 188)
				->where('tarifs.total', '<>', 0)
				->whereNotNull('tarifs.lica_id')
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->limit(50)
				->get();
		} elseif ($status_reg == 'G') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TG')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoritarif_id', '!=', 188)
				->whereNotNull('tarifs.lica_id')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->limit(50)
				->groupBy('tarifs.nama')
				->get();
		} else {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TI')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoritarif_id', '!=', 188)
				->whereNotNull('tarifs.lica_id')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.nama')
				->limit(50)
				->get();
		}

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . @$tag->kode  . ' | ' . @number_format($tag->total)];
		}
		return \Response::json($formatted_tags);
	}



	public function ajaxTindakanLabCommon(Request $request, $status_reg)
	{
		// dd($status_reg);
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		if ($status_reg == 'J') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TA')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.kategoriheader_id', '=', 10)
				->where('tarifs.total', '<>', 0)
				->where('tarifs.lica_id', '=', null)
				->where('tarifs.is_aktif', 'Y')
				->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.total')
				->limit(50)
				->get();
		} elseif ($status_reg == 'G') {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TG')
				->where('tarifs.kategoriheader_id', '=', 10)
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.lica_id', '=', null)
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->limit(50)
				->groupBy('tarifs.total')
				->get();
		} else {
			$tags = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				->where('tarifs.jenis', '=', 'TI')
				->where('tarifs.kategoriheader_id', '=', 10)
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.lica_id', '=', null)
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
				->groupBy('tarifs.total')
				->limit(50)
				->get();
		}

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$list_tag = $tag->lica_id == 0 ? 'NON LIS' : 'LIS';
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . @$tag->kode  . ' | ' . @number_format($tag->total) . '-' . $list_tag];
		}
		return \Response::json($formatted_tags);
	}








	public function ajaxTindakanOperasi(Request $request, $kelas = NULL)
	{
		// dd($status_reg);
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}
		// dd($term);
		if ($kelas == 8 || $kelas == null) {
			$tags = Tarif::
				// leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				where('tarifs.jenis', '=', 'TI')
				->whereNotNull('tarifs.kelas_id')
				// ->whereNull('tarifs.kode')
				->where('tarifs.kategoriheader_id', '<>', 10)
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.nama', 'not like', '%PA Biopsi%')
				->where('tarifs.nama', 'not like', '%PA Biopsi Besar%')
				->where('tarifs.nama', 'not like', '%PA Biopsi Kecil%')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				->where('tarifs.total', '<>', 0)
				// ->select('tarifs.*', 'kategoritarifs.namatarif')
				// ->groupBy('tarifs.total')
				->groupBy('tarifs.nama')
				->limit(50)
				->get();
			// dd($tags);
			// dd($kelas);

			if (count($tags) == 0) {

				$tags = Tarif::
					// leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
					where('tarifs.jenis', '=', 'TI')
					// ->where(function ($query) {
					// 	$query->Where('tarifs.kode', '')
					// 		->orWhereNull('tarifs.kode');
					// })
					->where('tarifs.is_aktif', 'Y')
					->where('tarifs.kategoriheader_id', '!=', 10)
					->where('tarifs.nama', 'not like', '%PA Biopsi%')
					->where('tarifs.nama', 'not like', '%PA Biopsi Besar%')
					->where('tarifs.nama', 'not like', '%PA Biopsi Kecil%')
					->where('tarifs.nama', 'like', '%' . $term . '%')
					->where('tarifs.total', '<>', 0)
					// ->select('tarifs.*', 'kategoritarifs.namatarif')
					// ->groupBy('tarifs.total')
					->groupBy('tarifs.nama')
					->limit(50)
					->get();
			}
		} else {
			$tags = Tarif::
				// leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
				where('tarifs.jenis', '=', 'TI')
				->where('tarifs.kelas_id', '=', $kelas)
				// ->whereNull('tarifs.kode')
				->where('tarifs.is_aktif', 'Y')
				->where('tarifs.kategoriheader_id', '<>', 10)
				->where('tarifs.nama', 'not like', '%PA Biopsi%')
				->where('tarifs.nama', 'not like', '%PA Biopsi Besar%')
				->where('tarifs.nama', 'not like', '%PA Biopsi Kecil%')
				->where('tarifs.nama', 'like', '%' . $term . '%')
				// ->orWhere('kategoritarifs.namatarif', 'like', '%' . $term . '%')
				// ->orWhere('tarifs.kode', 'like', '%' . $term . '%')
				->where('tarifs.total', '<>', 0)
				// ->select('tarifs.*', 'kategoritarifs.namatarif')
				// ->groupBy('tarifs.total')
				->groupBy('tarifs.nama')
				->limit(50)
				->get();


			if (count($tags) == 0) {

				$tags = Tarif::
					// leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
					where('tarifs.jenis', '=', 'TI')
					// ->whereNull('tarifs.kode')
					// ->where(function ($query) {
					// 	// $query->where('poli_tipe', '=', 'J')
					// 	$query->Where('tarifs.kode', '')
					// 		->orWhereNull('tarifs.kode');
					// })
					->where('tarifs.is_aktif', 'Y')
					->where('tarifs.kategoriheader_id', '!=', 10)
					->where('tarifs.nama', 'not like', '%PA Biopsi%')
					->where('tarifs.nama', 'not like', '%PA Biopsi Besar%')
					->where('tarifs.nama', 'not like', '%PA Biopsi Kecil%')
					->where('tarifs.nama', 'like', '%' . $term . '%')
					// ->orWhere('kategoritarifs.namatarif', 'like', '%' . $term . '%')
					// ->orWhere('tarifs.kode', 'like', '%' . $term . '%')
					->where('tarifs.total', '<>', 0)
					// ->select('tarifs.*', 'kategoritarifs.namatarif')
					// ->groupBy('tarifs.total')
					->groupBy('tarifs.nama')
					->limit(50)
					->get();
			}
		} //NON KELAS

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = [
				'id' => $tag->id,
				'text' => @$tag->nama . ' | ' . @$tag->kode  . ' | ' . @number_format($tag->total)
			];
		}
		return \Response::json($formatted_tags);
	}

	public function cariPasien()
	{

		return view('tindakan::cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		// $date = date('Y-m-d', strtotime('-7 days'));
		// return $request->all();
		// $data['pasien'] = Pasien::where('no_rm', $request->no_rm);
		// if ($request->nama){
		// 	$data['pasien'] = $data['pasien']->where('nama','like','%' . $request->nama.'%');
		// }
		// $data['pasien'] = $data['pasien']->first();
		$data['registrasi']	= HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
			->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id');

		if ($request->no_rm) {
			$data['registrasi'] = $data['registrasi']->where('pasiens.no_rm', $request->no_rm);
		} elseif ($request->nama) {
			$data['registrasi'] = $data['registrasi']->where('pasiens.nama', 'like', $request->nama . '%');
		}
		$data['registrasi'] = $data['registrasi']
			// ->where('registrasis.pasien_id', $data['pasien']->id)
			->where('registrasis.status_reg', 'like', 'J%')
			->whereNull('registrasis.deleted_at')
			// ->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->select('histori_kunjungan_irj.id as id_kunjungan', 'antrian_poli.status', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id',  'histori_kunjungan_irj.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.id')
			->orderBy('id', 'DESC')
			->get();
		// return $data; die;
		return view('tindakan::cari-pasien', $data)->with('no', 1);
	}

	public function cetakRincianBiayaKronis($id = '')
	{
		// dd($id);
		$data['reg'] = Registrasi::find($id);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->where('cara_bayar_id', '!=', '2')
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// OTOMATIS SINKRON
		$data['sinkron_obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
		foreach ($data['sinkron_obat'] as $so) {
			$sink = Penjualan::with('penjualandetail')->where('no_resep', $so->namatarif)->first()->penjualandetail->sum('hargajual');
			// dd($sink);
			if ($so->total !== $sink) {
				if ($sink !== '0') {
					DB::table('folios')->whereNull('deleted_at')
						->where('registrasi_id', $id)
						->where('namatarif', $so->namatarif)
						->update(['total' => $sink]);
				}
			}
		}
		// dd($data['tagihan']);
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		$data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('jenis', 'ORJ')->groupBy('gudang_id')
			->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
			->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where(function ($query) {
				// $query->where('poli_tipe', '=', 'J')
				$query->whereNotIn('poli_tipe', ['G', 'L', 'R', 'O'])
					->orWhereNull('poli_tipe');
			})
			// ->where('poli_tipe', '!=','L')
			->where('cara_bayar_id', '!=', '2')
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		// dd($data['folio_rajal']);

		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->whereIn('jenis', ['TG', 'TI'])
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');

		// OBAT RAJAL
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('user_id', '!=', 610)
			->where('gudang_id', '9') //rajal
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_rajal'] == 0) {
			$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->sum('total');
			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->where('user_id', '!=', 610)
			// 	->select('namatarif', 'total')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'Y')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->select('namatarif', 'total')
				->get();
		} else {

			$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->sum('total');
			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	// ->with([
			// 	// 	'obat' => function ($query) {
			// 	// 		$query->where('is_kronis', 'Y')->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
			// 	// 	},
			// 	// ])
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->where('user_id', '!=', 610)
			// 	->select('namatarif', 'total')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'Y')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->select('namatarif', 'total')
				->get();
		}

		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRJ' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
			->where('gudang_id', NULL)
			->sum('total');
		// $data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('namatarif', 'like', 'FRJ' . '%')
		// 	->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
		// 	->where('gudang_id', NULL)
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->where('is_kronis', 'Y')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('namatarif', 'like', 'FRJ' . '%')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
			->where('gudang_id', NULL)
			->where('jenis', 'ORJ')
			->select('namatarif', 'total')
			->get();

		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id', '2') //OPERASI
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total', 'user_id')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->where('is_kronis', 'Y')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
			// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('gudang_id', NULL)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total', 'user_id')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'Y')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->select('namatarif', 'total', 'user_id')
				->get();
		}

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id ,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			$data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}

		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();

		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->where('cara_bayar_id', '!=', '2')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));


		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));

		$data['total_biaya'] = 0;
		return view('tindakan::cetakRincianBiayaObat', $data);
	}

	public function cetakRincianBiayaNonKronis($id = '')
	{
		// dd($id);
		$data['reg'] = Registrasi::find($id);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->where('cara_bayar_id', '!=', '2')
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// OTOMATIS SINKRON
		$data['sinkron_obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
		foreach ($data['sinkron_obat'] as $so) {
			$sink = Penjualan::with('penjualandetail')->where('no_resep', $so->namatarif)->first()->penjualandetail->sum('hargajual');
			// dd($sink);
			if ($so->total !== $sink) {
				if ($sink !== '0') {
					DB::table('folios')->whereNull('deleted_at')
						->where('registrasi_id', $id)
						->where('namatarif', $so->namatarif)
						->update(['total' => $sink]);
				}
			}
		}
		// dd($data['tagihan']);
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		$data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('jenis', 'ORJ')->groupBy('gudang_id')
			->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
			->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where(function ($query) {
				// $query->where('poli_tipe', '=', 'J')
				$query->whereNotIn('poli_tipe', ['G', 'L', 'R', 'O'])
					->orWhereNull('poli_tipe');
			})
			// ->where('poli_tipe', '!=','L')
			->where('cara_bayar_id', '!=', '2')
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		// dd($data['folio_rajal']);

		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->whereIn('jenis', ['TG', 'TI'])
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');

		// OBAT RAJAL
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('user_id', '!=', 610)
			->where('gudang_id', '9') //rajal
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_rajal'] == 0) {
			$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->sum('total');
			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->where('user_id', '!=', 610)
			// 	->select('namatarif', 'total')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->select('namatarif', 'total')
				->get();
		} else {

			$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->sum('total');
			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->where('user_id', '!=', 610)
			// 	->select('namatarif', 'total')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->select('namatarif', 'total')
				->get();
		}

		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRJ' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
			->where('gudang_id', NULL)
			->sum('total');
		// $data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('namatarif', 'like', 'FRJ' . '%')
		// 	->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
		// 	->where('gudang_id', NULL)
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('namatarif', 'like', 'FRJ' . '%')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
			->where('gudang_id', NULL)
			->where('jenis', 'ORJ')
			->select('namatarif', 'total')
			->get();

		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id', '2') //OPERASI
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total', 'user_id')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->select('namatarif', 'total', 'user_id')
			->get();
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
			// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('gudang_id', NULL)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total', 'user_id')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->select('namatarif', 'total', 'user_id')
				->get();
		}

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id ,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			$data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}

		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();

		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->where('cara_bayar_id', '!=', '2')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));


		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));

		$data['total_biaya'] = 0;
		return view('tindakan::cetakRincianBiayaObat', $data);
	}
	public function kontrolPrint($reg_id)
	{
		$data['reg'] = Registrasi::find($reg_id);
		$data['rencana_kontrol'] = RencanaKontrol::where('registrasi_id', $data['reg']->id)->orderBy('id', 'DESC')->first();
		return view('tindakan::cetak-kontrol', $data)->with('no', 1);
	}
}
