<?php

namespace App\Http\Controllers;
use App\Foliopelaksana;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganRAD;
use App\KondisiAkhirPasien;
use App\Nomorrm;
use App\Pasienlangsung;
use App\Rawatinap;
use Auth;
use DB;
use MercurySeries\Flashy\Flashy;
use Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
// use Activity;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use PDF;
use App\Orderradiologi;
use App\PacsOrder;
use App\PacsExpertise;
use Carbon\Carbon;

class RadiologiGigiController extends Controller {

	public function tindakanIRJ() {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');

		session()->forget(['dokter', 'pelaksana', 'perawat']);
		 $data['registrasi'] = Registrasi::with('ekspertise')->where('status_reg', 'like', 'J%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();

		$data['notif']      = Orderradiologi::whereDate('created_at', Carbon::today())->first();
    
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'R')
		// 		->where('registrasis.status_reg', 'like', 'J%')
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		// /dd($data['registrasi']);
		// return view('radiologi-gigi.tindakanIRJ', $data)->with('no', 1);
		return view('radiologi-gigi.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRJByTanggal(Request $request) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');

		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'R')
		// 		->where('registrasis.status_reg', 'like', 'J%')
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('radiologi-gigi.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRD() {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');

		$data['rad'] = Poli::where('politype', 'R')->get();
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['G1', 'G2', 'G3', 'I1','I2','I3'])->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		// $data['registrasi'] = Registrasi::where('status_reg', ['I1', 'G1'])->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'R')
		// 		->where('registrasis.status_reg', 'like', 'G%')
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('radiologi-gigi.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRDByTanggal(Request $request) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');

		$data['rad'] = Poli::where('politype', 'R')->where('id', $request->radiologi)->get();
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['G1', 'G2', 'G3', 'I1','I2','I3'])
		->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
		->get();
		return view('radiologi-gigi.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRNA() {
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$date = date('Y-m-d', strtotime('-10 days'));
		$data['registrasi'] = Registrasi::with(['ekspertise'])->whereIn('status_reg', ['I1', 'I2', 'I3'])
		->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		->get();
		
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'R')
		// 		->whereIn('registrasis.status_reg', ['I1', 'I2'])
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('radiologi-gigi.tindakanIRNA', $data)->with('no', 1);
	}


	public function showCatatan($id)
	{
		$data = Folio::find($id);
		return response($data);
	}

	public function upadateCatatan($id, Request $request)
	{	
		$data = Folio::find($id);
		$data->catatan= $request->note;
		$data->embalase = $request->tgl_order;
		$data->update();
		return response($data);
	}


	public function showCatatanReg($id)
	{
		$data = Registrasi::find($id);
		return response($data);
	}

	public function upadateCatatanReg($id, Request $request)
	{	
	
		$data = Registrasi::find($id);
		$data->catatan = $request->catatan;
		$data->tgl_order = $request->tgl_order;
	
		$data->update();
		return response($data);
	}









	public function getTindakanRadiologi(Request $request, $id)
	{
		$tindakan = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $id, 'poli_tipe' => 'R'])->get();
		$data = '';
		foreach($tindakan as $val){
			$data .= '<li>'.$val->namatarif.'</li>';
			
			// OPTION TINDAKAN - // AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
			// $data .= '<option data_tgl="'.$val->created_at.'" value="'.$val->id.'">'.$val->namatarif.'</option>';
		}

		// AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
		// return '<select class="form-control" name="tindakan_id">'.$data.'</select>';
		return '<ul>'.$data.'</ul>';
	}

	public function getDokter(Request $request, $id)
	{
		$tindakan = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $id, 'poli_tipe' => 'R'])->groupBy('dokter_radiologi')->get();
	
		$data = '';
		foreach($tindakan as $val){
			// $data .= '<li>'.$val->namatarif.'</li>';
			
			// OPTION TINDAKAN - // AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
			$data .= '<option value="'.$val->dokter_id.'">'.baca_dokter($val->dokter_radiologi).'</option>';
		}

		// AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
		return '<select class="form-control" name="dokter_id">'.$data.'</select>';
		// return '<ul>'.$data.'</ul>';
	}


	public function getDiagnosaRadiologi(Request $request, $id)
	{
		$tindakan = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $id, 'poli_tipe' => 'R'])->get();
		$data = '';
		foreach($tindakan as $val){
			$data .= '<li>'.$val->diagnosa.'</li>';
			
			// OPTION TINDAKAN - // AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
			// $data .= '<option data_tgl="'.$val->created_at.'" value="'.$val->id.'">'.$val->namatarif.'</option>';
		}

		// AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
		// return '<select class="form-control" name="tindakan_id">'.$data.'</select>';
		return '<ul>'.$data.'</ul>';
	}



	public function getNoFotoRadiologi(Request $request, $id)
	{
		$tindakan = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $id, 'poli_tipe' => 'R'])->get();
		$data = '';
		foreach($tindakan as $val){
			$data .= '<li>'.$val->no_foto.'</li>';
			
			// OPTION TINDAKAN - // AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
			// $data .= '<option data_tgl="'.$val->created_at.'" value="'.$val->id.'">'.$val->namatarif.'</option>';
		}

		// AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
		// return '<select class="form-control" name="tindakan_id">'.$data.'</select>';
		return '<ul>'.$data.'</ul>';
	}









	public function tindakanIRNAByTanggal(Request $request) {
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2','I3'])
		->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
		->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'R')
		// 		->whereIn('registrasis.status_reg', ['I1', 'I2'])
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('radiologi-gigi.tindakanIRNA', $data)->with('no', 1);
	}

	public function sudahPulang() {
		$data['registrasi'] = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')->whereIn('status_reg', ['I3'])->get();
		return view('radiologi-gigi.sudahPulang', $data)->with('no', 1);
	}
	public function searchPasien(Request $request) {
		request()->validate(['keyword' => 'required']);
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm_lama', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();
		return view('radiologi-gigi.pasien', compact('data', 'keyword'))->with('no', 1);
	}

	public function simpanTransaksiLangsungLama(Request $request,$id) {
		// dd("A");

		// request()->validate(['nama' => 'required', 'alamat' => 'required', 'kelamin' => 'required', 'tgllahir' => 'required']);
		
		DB::transaction(function () use ($id,$request) {
			$pasien = Pasien::where('id',$id)->first();
			// dd($pasien);
			if($pasien){

				// dd($pasien);
				$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
				$reg = new Registrasi();
				$reg->pasien_id = $pasien->id;
				$reg->status_reg = 'R1';
				$reg->bayar = '2';
				$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
				$reg->user_create = Auth::user()->id;
				$reg->save();

	
				$pasiens = new Pasienlangsung();
				$pasiens->registrasi_id = $reg->id;
				$pasiens->nama = $pasien->nama;
				$pasiens->alamat = $pasien->alamat;
				$pasiens->no_jkn = $pasien->no_jkn;
				$pasiens->nik = $pasien->nik;
				$pasiens->no_rm = $pasien->no_rm;
				$pasiens->no_hp = $pasien->nohp;
				$pasiens->kelamin = $pasien->kelamin;
				$pasiens->tgllahir = $pasien->tgllahir;
				$pasiens->politype = 'R';
				$pasiens->pemeriksaan = @$request->pemeriksaan;
				$pasiens->user_id = Auth::user()->id;
				$pasiens->save();
				  
	
				$update = Registrasi::where('id', $reg->id)->first();
				$update->pasien_id= $pasien->id;
				$update->poli_id = poliRadiologiGigi();
				$update->save();
				// dd($update);
				// dd($pasien);
				
				
	
	
	
				$hk = new HistorikunjunganRAD();
				$hk->registrasi_id = $reg->id;
				$hk->pasien_id = $pasien->id;
				$hk->poli_id = poliRadiologiGigi();
				$hk->pasien_asal = 'TA';
				$hk->user = Auth::user()->name;
				$hk->save();
			}else{
				Flashy::error('Gagal Insert Pasien ke RADIOLOGI');
				return redirect()->back();
			}
			session(['registrasi_id' => $reg->id]);
		});
		return redirect('/radiologi-gigi/entry-transaksi-langsung/' . session('registrasi_id'));
	}

	public function sudahPulangByTanggal(Request $request) {
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['I3'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		return view('radiologi-gigi.sudahPulang', $data)->with('no', 1);
	}

	public function pencarianPasien() {
		$data['registrasi'] = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')->get();
		return view('radiologi-gigi.pencarianPasien', $data)->with('no', 1);
	}

	public function pencarianPasienByTanggal(Request $request) {
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['G1','G2','J1','J2','I1','I2','I3'])
		->where('created_at', 'like', valid_date($request['tga']) . '%')
		->get();
		return view('radiologi-gigi.pencarianPasien', $data)->with('no', 1);
	}

	public function insertKunjungan($registrasi_id, $pasien_id) {
		$reg = Registrasi::find($registrasi_id);
		$hk = new HistorikunjunganRAD();
		$hk->registrasi_id = $registrasi_id;
		$hk->pasien_id = $pasien_id;
		$hk->poli_id = $reg->poli_id;
		if (substr($reg->status_reg, 0, 1) == 'J') {
			$hk->pasien_asal = 'TA';
		} elseif (substr($reg->status_reg, 0, 1) == 'G') {
			$hk->pasien_asal = 'TG';
		} elseif (substr($reg->status_reg, 0, 1) == 'I') {
			$hk->pasien_asal = 'TI';
		}
		$hk->user = Auth::user()->name;
		$hk->save();
		if (substr($reg->status_reg, 0, 1) == 'I') {
			// Activity::log($hk->user.' Insert kunjungan Radiologi Rawatinap');
			return redirect('radiologi-gigi/entry-tindakan-irna/' . $registrasi_id . '/' . $pasien_id);
		} else {
			// Activity::log($hk->user.' Insert kunjungan Radiologi Rawatjalan');
			return redirect('radiologi-gigi/entry-tindakan-irj/' . $registrasi_id . '/' . $pasien_id);
		}

	}

	public function entryTindakanIRNA($idreg, $idpasien) {
		$data['folio'] = Folio::where('registrasi_id', $idreg)
			->where('poli_tipe', 'R')
			->where('poli_id',poliRadiologiGigi())
			->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)->where('poli_id',poliRadiologiGigi())->where('poli_tipe','R')->where('lunas', 'N')->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		// $data['perawat'] = Pegawai::pluck('nama', 'id');
		$data['rad']	= Orderradiologi::where('registrasi_id', $idreg)->first();
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['rawatinap'] = Rawatinap::where('registrasi_id', $idreg)->first();
		$data['rad'] = Poli::where('bpjs',codeRadiologiGigi())->first();
		$array_perawat = explode(',', $data['rad']->perawat_id);
		$data['perawat'] = Pegawai::whereIn('id', $array_perawat)->pluck('nama', 'id');
		// dd($data['perawat']);
		// return Rawatinap::where('registrasi_id', $idreg)->first();
		
		// $data['dokter'] =  (explode(",", $data['dokters_poli'][0]));
		// $data['perawat'] =  (explode(",", $data['perawats_poli'][0]));



		$jenis = $data['jenis']->status_reg;
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			$data['opt_poli'] = Poli::where('politype', 'R')->get();
		}

		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		return view('radiologi-gigi.entryTindakanRadiologiIRNA', $data)->with('no', 1);

	}

	public function entryTindakanIRJ($idreg, $idpasien) {
		// dd(poliRadiologiGigi());
		$data['folio'] = Folio::where('folios.registrasi_id', $idreg)
			->where('poli_tipe', 'R')->where('poli_id',poliRadiologiGigi())->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->where('lunas', 'N')->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		// $data['perawat'] = Pegawai::pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['rad'] = Poli::where('bpjs',codeRadiologiGigi())->first();
		$array_perawat = explode(',', $data['rad']->perawat_id);
		$data['perawat'] = Pegawai::whereIn('id', $array_perawat)->pluck('nama', 'id');

		$data['radiografer'] = getDokterRadiologiGigi();
		// dd($data['radiografer']);
		$jenis = $data['jenis']->status_reg;
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J' || substr($jenis, 0, 1) == 'R') {
			session(['jenis' => 'TA']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			$data['opt_poli'] = Poli::where('politype', 'R')->get();
		}

		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		return view('radiologi-gigi.entryTindakanRadiologi', $data)->with('no', 1);

	}

	public function editEkspertise($id, $registrasi_id)
	{
		$data['radiologi'] = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('radiologi_ekspertises.id', $id)
			->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'radiologi_ekspertises.dokter_id as dokter',  'radiologi_ekspertises.dokter_pengirim as pengirim')
			->first();
		$data['id_eksp'] = $id;
		// $dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['radiografer'] = getDokterRadiologiGigi();
		$data['umur'] = hitung_umur($data['reg']->pasien->tgllahir);
		$data['tindakan'] = Folio::where('poli_id', poliRadiologiGigi())->where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->get();
		$data['rad'] = Folio::where('poli_id', poliRadiologiGigi())->where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->orderBy('id','DESC')->first();
		$data['ekspertise'] = \App\RadiologiEkspertise::where('poli_id', poliRadiologiGigi())->where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$data['eksp'] = $data['ekspertise'] ? $data['ekspertise'] : [];
		$data['tanggal'] = !empty($data['ekspertise']->tanggal_eksp) ? tanggalPeriode($data['ekspertise']->tanggal_eksp) : null;
		$data['tindakan'] = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $registrasi_id, 'poli_tipe' => 'R'])->orderBy('id','DESC')->get();
		if(count($data['tindakan']) == '0'){
			Flashy::info('Tidak ada tindakan');
			return redirect()->back();
		}
		$data['order'] = Orderradiologi::where(['registrasi_id' => $registrasi_id, 'jenis' => 'TA'])->get();
		// $data = '';
		// foreach($tindakan as $key=>$val){
		// 	$selected = $key == '0' ? 'selected' : '';
		// 	$data .= '<option data_tgl="'.$val->created_at.'" value="'.$val->id.'" '.$selected.'>'.$val->namatarif.'</option>';
		// }
		// return '<select class="form-control" name="tindakan_id"><option>Silahkan Pilih</option>'.$data.'</select>';
		return view('radiologi-gigi.edit_ekspertise', $data)->with('no', 1);
	}

	public function Order($registrasi_id)
	{
		$data = \App\Orderradiologi::where('registrasi_id', $registrasi_id)->latest()->first();
		// dd($data);
		return response()->json($data);
	}

	public function notif(){
		//$datanotif = \App\Orderradiologi::whereIn('status', ['Y','N'])->latest()->first();
		$datanotif = \App\Orderradiologi::whereDate('created_at', Carbon::today())->latest()->first();
		return view('radiologi-gigi.notifbaru', compact('datanotif'));
	}

	public function saveTindakan(Request $request) {
		// dd($request->all());
		request()->validate(['tarif_id' => 'required']);
		session(['dokter' => $request['dokter_id'],'radiografer' => $request['radiografer'] ,'pelaksana' => $request['pelaksana'], 'perawat' => $request['perawat']]);
		// dd($request['pelaksana']);
		$reg = Registrasi::find($request['registrasi_id']);
		$tarif = Tarif::find($request['tarif_id']);
		$fol = new Folio();
		$fol->registrasi_id = $request['registrasi_id'];
		$fol->poli_id = $request['poli_id'];
		$fol->lunas = 'N';
		$fol->namatarif = $tarif->nama;
		$fol->tarif_id = $request['tarif_id'];
		$fol->jenis = $tarif->jenis;
		$fol->cara_bayar_id = !empty($request['cara_bayar_id']) ? $request['cara_bayar_id'] : $reg->bayar;
		$fol->poli_tipe = 'R';
		$fol->total = ($tarif->total * $request['jumlah']);
		$fol->jenis_pasien = $request['jenis'];
		$fol->pasien_id = $request['pasien_id'];
		$fol->dokter_id = $request['dokter_id'];
		$fol->verif_kasa_user  = 'tarif_new';
		$fol->no_foto = $request['no_foto'];
		$fol->diagnosa = $request['diagnosa'];
		$fol->user_id = Auth::user()->id;
		$fol->poli_id = $request['poli_id'];
		if (!empty($request['tanggal'])) {
			$fol->created_at = valid_date($request['tanggal']);
		}
		$fol->mapping_biaya_id = $tarif->mapping_biaya_id;

		//revisi pelaksana
		$fol->dpjp = $reg->dokter_id;
		$fol->dokter_radiologi = $request['dokter_radiologi'];
		$fol->radiografer = $request['radiografer'];
		if (substr($reg->status_reg, 0, 1) == 'G') {
			$fol->pelaksana_tipe = 'TG';
		} elseif (substr($reg->status_reg, 0, 1) == 'I') {
			$fol->pelaksana_tipe = 'TI';
		} else {
			$fol->pelaksana_tipe = 'TA';
		}
		// dd($fol);
		$fol->save();

		//INSERT FOLIO PELAKSANA
		// $fp = new Foliopelaksana();
		// $fp->folio_id = $fol->id;
		// $fp->dpjp = $reg->dokter_id;
		// $fp->dokter_radiologi = $request['dokter_radiologi'];
		// $fp->radiografer = $request['radiografer'];
		// if (substr($reg->status_reg, 0, 1) == 'G') {
		// 	$fp->pelaksana_tipe = 'TG';
		// } elseif (substr($reg->status_reg, 0, 1) == 'I') {
		// 	$fp->pelaksana_tipe = 'TI';
		// } else {
		// 	$fp->pelaksana_tipe = 'TA';
		// }
		// $fp->user = Auth::user()->id;
		// $fp->save();

		//Update status registrasi
		// if (substr($reg->status_reg, 0, 1) == 'G') {
		// 	$reg->status_reg = 'G2';
		// } elseif (substr($reg->status_reg, 0, 1) == 'I') {
		// 	$reg->status_reg = 'I2';
		// } elseif (substr($reg->status_reg, 0, 1) == 'R') {
		// 	$reg->status_reg = 'R1';
		// } else {
		// 	$reg->status_reg = 'J2';
		// }
		// $reg->update();

		// Insert Histori
		$history = new HistoriStatus();
		$history->registrasi_id = $request['registrasi_id'];
		if (substr($reg->status_reg, 0, 1) == 'G') {
			$history->status = 'G2';
		} elseif (substr($reg->status_reg, 0, 1) == 'J') {
			$history->status = 'J2';
		} else {
			$history->status = 'I2';
		}

		$history->poli_id = $request['poli_id'];
		$history->bed_id = null;
		$history->user_id = Auth::user()->id;
		$history->save();
		session()->forget('jenis');
		if (substr($reg->status_reg, 0, 1) == 'I') {
			return redirect('radiologi-gigi/entry-tindakan-irna/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		} elseif (substr($reg->status_reg, 0, 1) == 'R') {
			return redirect('radiologi-gigi/entry-transaksi-langsung/' . $request['registrasi_id']);
		} else {
			return redirect('radiologi-gigi/entry-tindakan-irj/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		}
	}

	public function hapusTindakan($id, $idreg, $pasien_id) {
		// if (Auth::user()->hasRole(['supervisor', 'radiologi', 'administrator'])) {
			// Folio::where('id', $id)->where('lunas', 'N')->delete();

			$folio = Folio::find($id);

			if (@$folio->lunas == 'N') {
				$folio->delete();
			}
		// }
		$reg = Registrasi::find($idreg);
		if (substr($reg->status_reg, 0, 1) == 'I') {
			return redirect('radiologi-gigi/entry-tindakan-irna/' . $idreg . '/' . $pasien_id);
		} elseif (substr($reg->status_reg, 0, 1) == 'R') {
			return redirect('radiologi-gigi/entry-transaksi-langsung/' . $idreg);
		} else {
			return redirect('radiologi-gigi/entry-tindakan-irj/' . $idreg . '/' . $pasien_id);
		}
	}

	public function lap_kunjungan() {
		$data['kunjungan'] = NULL;
		return view('radiologi-gigi.lap_kunjungan', $data);
	}

	public function lap_kunjungan_by_request(Request $request) {
		
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['kunjungan'] = HistorikunjunganIRJ::where('poli_id', '2')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		$data['kunjungan'] = Orderradiologi::whereBetween('order_radiologi.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
							->leftJoin('registrasis', 'order_radiologi.registrasi_id', '=', 'registrasis.id')
							->selectRaw('order_radiologi.registrasi_id as registrasi_id, registrasis.pasien_id as pasien_id, order_radiologi.created_at as created_at, order_radiologi.user_id as user_id, order_radiologi.status as status')
							->get();
		$data['pasien_asal'] = $request['pasien_asal'];
		if ($request['view']) {
			// dd($data);
			return view('radiologi-gigi.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
			// if ($request['pasien_asal'] == 'TI') {
			// 	$judul = 'IRNA';
			// } elseif ($request['pasien_asal'] == 'TA') {
			// 	$judul = 'IRJ';
			// } elseif ($request['pasien_asal'] == 'TG') {
			// 	$judul = 'IGD';
			// }
			$judul = 'Kunjungan Radiologi';
			
			Excel::create('Lap' . @$judul, function ($excel) use ($datareg, $judul) {
				// Set the properties
				$excel->setTitle('Lap' . $judul)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap' . $judul);
				$excel->sheet('Lap' . $judul, function ($sheet) use ($datareg) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama',
						'No. RM',
						'Umur',
						'L/P',
						'KLinik Asal',
						'Dokter',
						'Tanggal Kunjungan',
					]);
					foreach ($datareg as $key => $d) {
						$reg = Registrasi::find($d->registrasi_id);
						$pasien = Pasien::find($d->pasien_id);
						$sheet->row(++$row, [
							$no++,
							$pasien ? $pasien->nama : 'Pasien dari luar',
							$pasien ? $pasien->no_rm : NULL,
							$pasien ? hitung_umur($pasien->tgllahir, 'Y') : NULL,
							$pasien ? $pasien->kelamin : NULL,
							!empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL,
							!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id) : NULL,
							tanggal($d->created_at),
						]);
					}
				});
			})->export('xlsx');
		}

	}

	//TRANSAKSI LANGSUNG
	// public function transaksiLangsung() {
	// 	$data = Pasienlangsung::where('created_at', 'like', date('Y-m-d') . '%')->where('politype', 'R')->get();
	// 	return view('radiologi-gigi.transaksiLangsung', compact('data'))->with('no', 1);
	// }
	//TRANSAKSI LANGSUNG
	public function transaksiLangsung() {
		$data = Pasienlangsung::join('registrasis', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
		->where('pasien_langsung.created_at', 'like', date('Y-m-d') . '%')
		->where('politype', 'R')
		->select('registrasis.id as registrasi', 'registrasis.lunas', 'pasien_langsung.*')
		->get();
		// return $data; die;
		return view('radiologi-gigi.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public static function cetakEkspertiseLangsung($id) {
		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasien_langsung', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
			->where('registrasis.id', $id)
			->where('poli_id', poliRadiologiGigi())
			->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasien_langsung.nama','pasien_langsung.alamat','radiologi_ekspertises.ekspertise', 'radiologi_ekspertises.no_dokument', 'radiologi_ekspertises.dokter_id', 'radiologi_ekspertises.dokter_pengirim', 'radiologi_ekspertises.klinis', 'radiologi_ekspertises.tanggal_eksp', 'radiologi_ekspertises.user_id')
			->first();
		$folio = Folio::where('registrasi_id', $id)->get();
		// return $folio; die;
		if( !$radiologi ){
			return redirect('radiologi-gigi/transaksi-langsung');
		}
		$dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
			// return $radiologi; die;
		if ($radiologi) {
			$pdf = PDF::loadView('radiologi-gigi.lap_hasil_langsung_radiologi', compact('radiologi','dokter','folio'));
			return $pdf->stream();
		} else {
			Flashy::success('Cetak Ekspertise Gagal');
			return redirect()->back();
		}
	}

	public static function cetakEkspertise($id, $registrasi_id)
	{

		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('radiologi_ekspertises.id', $id)
			// ->where('radiologi_ekspertises.poli_id', poliRadiologi())
			->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'pasiens.no_rm as no_rm', 'radiologi_ekspertises.dokter_id as dokter','radiologi_ekspertises.folio_id',  'radiologi_ekspertises.dokter_pengirim as pengirim')
			->first();
		// dd($id);
		if(!empty($radiologi->folio_id)){
			$count = 1;
			$tindakan = Folio::where('id', $radiologi->folio_id)->first();	
		}else{
			$count = 2;
			$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->get();

		}
		$dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
		$folio = Folio::where('registrasi_id', $registrasi_id)->first();
			// return $radiologi; die;
		if ($radiologi) {
			if ($radiologi->tte) {
				$tte = json_decode($radiologi->tte);

				if ($tte) {
					$base64 = $tte->base64_signed_file;
			
					$pdfContent = base64_decode($base64);
					return Response::make($pdfContent, 200, [
						'Content-Type' => 'application/pdf',
					]);
				}

				return redirect("/dokumen_tte/".$radiologi->tte);
			}
			$pdf = PDF::loadView('radiologi-gigi.lap_hasil_langsung_radiologi', compact('radiologi','folio', 'dokter', 'tindakan','count'));
			return $pdf->stream();
		} else {
			Flashy::success('Cetak Ekspertise Gagal');
			return redirect()->back();
		}
	}

	public static function cetakEkspertisePacs($id)
	{
		$radiologi = PacsExpertise::where('id',$id)->first();
			// dd($radiologi);

		// return $folio; die;
		// return $radiologi; die;
		if ($radiologi) {
			$pdf = PDF::loadView('radiologi-gigi.lap_hasil_langsung_radiologi_pacs', compact('radiologi'));
			return $pdf->stream();
		} else {
			Flashy::success('Cetak Ekspertise Gagal');
			return redirect()->back();
		}
	}

	public static function cetakEkspertiseVedika($registrasi_id)
	{
		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.id', $registrasi_id)
			->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'radiologi_ekspertises.dokter_id as dokter',  'radiologi_ekspertises.dokter_pengirim as pengirim')
			->first();
		$dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
		// return $radiologi; die;

		// return $folio; die;
		// return $radiologi; die;
		if ($radiologi) {
			$pdf = PDF::loadView('radiologi-gigi.lap_hasil_langsung_radiologi', compact('radiologi', 'dokter'));
			return $pdf->stream();
		} else {
			Flashy::success('Cetak Ekspertise Gagal');
			return redirect()->back();
		}
	}

	public function tindakanLangsungBytanggal(Request $request)
	{
		$data = Pasienlangsung::join('registrasis', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
			->where('pasien_langsung.created_at', 'like', valid_date($request['tga']) . '%')
			->where('politype', 'R')
			->select('registrasis.id as registrasi', 'registrasis.lunas', 'pasien_langsung.*')
			->get();
			// return $data; die;
		return view('radiologi-gigi.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public function transaksiCetak($registrasi_id){
		$folio = Folio::where('registrasi_id', $registrasi_id)->where('poli_id', poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		$reg = Registrasi::find($registrasi_id);
		$jml = Folio::where('registrasi_id', $registrasi_id)->where('poli_id', poliRadiologiGigi())->where('poli_tipe', 'R')->sum('total');
		$no = 1;
		$status = 'radiologi';
		$pasienLangsung = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		return view('radiologi-gigi.cetakLangsung', compact('reg', 'folio', 'jml', 'no', 'status', 'pasienLangsung'));
		// $pdf = PDF::loadView('radiologi-gigi.cetakLangsung', compact('reg', 'folio', 'jml', 'no', 'status', 'pasienLangsung'));
		// return $pdf->stream();
		
		// $pasienLangsung = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		// $folio = Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
		// 	->where('folios.registrasi_id', $registrasi_id)
		// 	->select('folios.*', 'foliopelaksanas.dokter_radiologi', 'foliopelaksanas.radiografer')
		// 	->where('poli_id', 17)->get();
		// $tindakan = Folio::where('registrasi_id', $registrasi_id)->where('user_id', Auth::user()->id)->get();
		// return view('radiologi-gigi.cetak', compact('pasienLangsung', 'folio', 'tindakan'))->with('no', 1);
	}

	public function simpanTransaksiLangsung(Request $request) {
		request()->validate(['nama' => 'required', 'alamat' => 'required']);
		DB::transaction(function () use ($request) {
			sleep(5);
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = '0';
			$reg->status_reg = 'R1';
			$reg->bayar = '2';
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->user_create = Auth::user()->id;
			$reg->save();

			// $no = Nomorrm::count() + config('app.no_rm');
			// $no_rm = $no;
			// $cek = Pasien::where('no_rm', $no_rm)->count();
			// if ($cek > 0) {
			// 	Flashy::info('No RM baru (' . $no_rm . ') sdh ada,coba lagi atau hubungi Admin!');
			// 	return back();
			// }

			$pasien = new Pasienlangsung();
			$pasien->registrasi_id = $reg->id;
			$pasien->nama = $request['nama'];
			$pasien->alamat = $request['alamat'];
			$pasien->no_jkn = $request['no_jkn'];
			$pasien->nik = $request['nik'];
			// $pasien->no_rm = sprintf("%06s", $no_rm);
			$pasien->no_hp = $request['nohp'];
			$pasien->kelamin = $request['kelamin'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->politype = 'R';
			$pasien->pemeriksaan = $request['pemeriksaan'];
			$pasien->user_id = Auth::user()->id;
			$pasien->save();

			$pasien_new = new Pasien();
			$pasien_new->nama = strtoupper($request['nama']);
			$pasien_new->nik = $request['nik'];
			$pasien_new->tgllahir = valid_date($request['tgllahir']);
			$pasien_new->kelamin = $request['kelamin'];
			// $pasien_new->no_rm = sprintf("%06s", $no_rm);
			$pasien_new->alamat = strtoupper($request['alamat']);
			$pasien_new->tgldaftar = date("Y-m-d");
			$pasien_new->rt = $request['rt'];
			$pasien_new->rw = $request['rw'];
			$pasien_new->nohp = $request['nohp'];
			$pasien_new->negara = 'Indonesia';
			$pasien_new->no_jkn = $request['no_jkn'];
			$pasien_new->user_create = Auth::user()->name;
			$pasien_new->user_update = '';
			$pasien_new->save();

			// Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => $no_rm]);
			$rms = Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
			
			// UPDATEPASIEN  LANGSUNG
			$pasien->no_rm = $rms->id;
			$pasien->save();
			
			// UPDATEPASIEN
			$pasi = Pasien::where('id',$pasien_new->id)->first();
			$pasi->no_rm = $rms->id;
			$pasi->save();
			$update = Registrasi::where('id', $reg->id)->first();
			$update->pasien_id= $pasien_new->id;
			$update->poli_id = poliRadiologiGigi();
			$update->save();

			$hk = new HistorikunjunganRAD();
			$hk->registrasi_id = $reg->id;
			$hk->pasien_id = '0';
			$hk->poli_id = poliRadiologiGigi();
			$hk->pasien_asal = 'TA';
			$hk->user = Auth::user()->name;
			$hk->save();
			session(['registrasi_id' => $reg->id]);
		});
		return redirect('/radiologi-gigi/entry-transaksi-langsung/' . session('registrasi_id'));
	}

	public function entryTindakanLangsung($registrasi_id) {
		$data['folio'] = Folio::where('folios.registrasi_id', $registrasi_id)->get();
		$data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$data['reg_id'] = $registrasi_id;
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['rad'] = Poli::where('bpjs',codeRadiologiGigi())->first();
		$array_perawat = explode(',', $data['rad']->perawat_id);
		$data['perawat'] = Pegawai::whereIn('id', $array_perawat)->pluck('nama', 'id');
		$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		$data['jenis'] = Registrasi::find($registrasi_id);
		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['radiografer'] = getDokterRadiologiGigi();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		
		session(['jenis' => 'TA']);
		return view('radiologi-gigi.entryTindakanLangsung', $data)->with('no', 1);
	}

	//Get Pacs Rajal

	public function ekspertise($registrasi_id) {

		$reg      = Registrasi::find($registrasi_id);
		$reg->pasien;
		//$orderrad = Orderradiologi::where('registrasi_id',$reg->id)->where('jenis', 'TA')->whereDate('created_at', Carbon::today())->first();
		$pasien   = Pasien::where('id',$reg->pasien_id)->first();
		$umur     = hitung_umur($reg->pasien->tgllahir);
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		//Get Data dari PACS Rajal
		$pacs     = PacsOrder::rightJoin('pacs_expertise', 'pacs_order.no_rm', '=', 'pacs_expertise.no_rm')
		          ->where('pacs_order.no_rm', $pasien->no_rm)
				  ->where('pacs_order.room','LIKE','%Poliklinik%')
				  ->whereDate('pacs_order.created_at', Carbon::today())
				  ->orderBy('pacs_order.id','DESC')->groupBy('pacs_order.no_rm')->first();
		$klinis   = @$pacs->klinis;
		$eks      = @$pacs->expertise;

		$rad      = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->orderBy('id','DESC')->first();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$eksp     = $ekspertise ? $ekspertise : [];
		$tanggal  = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : date('d-m-Y');
		return response()->json(['reg' => $reg, 'tindakan' => $tindakan, 'ep' => $eksp, 'umur' => $umur, 'klinis' => $klinis,  'eks' => $eks, 'tanggal' => $tanggal,'rad'=>$rad]);
	}


	//Get Pacs IGD
	public function ekspertise_igd($registrasi_id){

		$folio = Folio::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->get();	
		$reg = Registrasi::find($registrasi_id);
		$reg->pasien;
		$pasien = Pasien::where('id',$reg->pasien_id)->first();
		$umur = hitung_umur($reg->pasien->tgllahir);
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		//Get Data dari PACS IGD
		$pacs    = PacsOrder::rightJoin('pacs_expertise', 'pacs_order.no_rm', '=', 'pacs_expertise.no_rm')
		         ->where('pacs_order.no_rm', $pasien->no_rm)->whereDate('pacs_order.created_at', Carbon::today())
				 ->where('pacs_order.room','UGD')
				 ->orderBy('pacs_order.id','DESC')
				 ->groupBy('pacs_order.no_rm')->first();
		$klinis  = @$pacs->klinis;
		$eks     = @$pacs->expertise;

		$rad     = Folio::where('registrasi_id', @$registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->orderBy('id','DESC')->first();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$eksp = $ekspertise ? $ekspertise : [];
		$tanggal = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : date('d-m-Y');
	
		return response()->json(['reg' => $reg, 'tindakan' => $tindakan, 'ep' => $eksp, 'umur' => $umur, 'klinis' => $klinis,  'eks' => $eks, 'tanggal' => $tanggal,'rad'=>$rad]);
		
	}

	//Get Pacs IRNA
	public function ekspertise_irna($registrasi_id){

		$reg    = Registrasi::find($registrasi_id);
		$reg->pasien;
		$pasien = Pasien::where('id',$reg->pasien_id)->first();
		$umur   = hitung_umur($reg->pasien->tgllahir);
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		//Get Data dari PACS IGD
		$pacs    = PacsOrder::rightJoin('pacs_expertise', 'pacs_order.no_rm', '=', 'pacs_expertise.no_rm')
		         ->where('pacs_order.no_rm', $pasien->no_rm)->whereDate('pacs_order.created_at', Carbon::today())
				 ->where('pacs_order.room','Asoka')
				 ->orderBy('pacs_order.id','DESC')
				 ->groupBy('pacs_order.no_rm')->first();
		$klinis  = @$pacs->klinis;
		$eks     = @$pacs->expertise;
		$rad     = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->orderBy('id','DESC')->first();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$eksp       = $ekspertise ? $ekspertise : [];
		$tanggal    = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : date('d-m-Y');
		return response()->json(['reg' => $reg, 'tindakan' => $tindakan, 'ep' => $eksp, 'umur' => $umur, 'klinis' => $klinis,  'eks' => $eks, 'tanggal' => $tanggal,'rad'=>$rad]);
		
	}

	public function ekspertiseBaru($registrasi_id,$id) {

		$reg = Registrasi::find($registrasi_id);
		$reg->pasien;
		$umur = hitung_umur($reg->pasien->tgllahir);
		$klinis ='test klinis';
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		$ekspertise = \App\RadiologiEkspertise::find($id);
		$eksp = $ekspertise ? $ekspertise : [];
		$tanggal = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : null;
		return response()->json(['reg' => $reg, 'tindakan' => $tindakan, 'ep' => $eksp, 'umur' => $umur, 'klinis' => $klinis, 'tanggal' => $tanggal]);
	}

	public function ekspertise_langsung($registrasi_id) {
		$reg = Registrasi::find($registrasi_id);
		// $reg->pasien_langsung;

		$pasien = \App\Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		// $umur = hitung_umur($reg->pasien->tgllahir);
        $klinis = "Heloo Klinis";

		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->first();
		$eksp = $ekspertise ? $ekspertise : [];
		$tanggal = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : null;
		return response()->json(['reg' => $reg,  'pasien' => $pasien, 'tindakan' => $tindakan, 'ep' => $eksp,  'klinis' => $klinis, 'tanggal' => $tanggal]);
	}

	function saveEkpertise(Request $request) {
		// return $request; die;
		if ($request['ekspertise_id']) {
			$ep = \App\RadiologiEkspertise::find($request['ekspertise_id']);
		} else {
			$ep = new \App\RadiologiEkspertise();
		}
		$ep->registrasi_id = $request['registrasi_id'];
		$ep->no_dokument = $request['no_dokument'];
		$ep->ekspertise = $request['ekspertise'];
		$ep->dokter_id = $request['dokter_id'];
		$ep->poli_id = @$request['poli_id'];
		$ep->dokter_pengirim = $request['dokter_pengirim'];
		$ep->tanggal_eksp = valid_date($request['tanggal_eksp']);
		$ep->tglPeriksa = valid_date($request['tglPeriksa']);
		$ep->klinis = $request['klinis'];
		$ep->user_id = Auth::user()->id;
		$ep->save();
		return response()->json(['sukses' => true, 'data' => $ep]);
	}

	function saveEkpertiseBaru(Request $request) {

		if ($request->proses_tte == "true") {
			if (empty($request->nik_dokter) || empty($request->passphrase)) {
				return response()->json(['sukses' => false, 'message' => "Mohon untuk mengisi informasi penandatangan dengan lengkap"]);
			}
		}

		if ($request['ekspertise_id']) {
			$ep = \App\RadiologiEkspertise::find($request['ekspertise_id']);
		} else { // create new
			$ep = new \App\RadiologiEkspertise();
			$reg = Registrasi::find($request['registrasi_id']);
			$count = \App\RadiologiEkspertise::whereDate('created_at', Carbon::today())->count() + 1;
			$uuid = 'EKP' . date('YmdHis').$count;
			$ep->uuid = $uuid;
			$ep->poli_id = @$request['poli_id'];
			$ep->pasien_id = @$reg->pasien_id;
            $dokumen = 'DK' . date('Y').$count;
			$ep->no_dokument = $dokumen;
		}

		$ep->registrasi_id = $request['registrasi_id'];
		// $ep->no_dokument = $request['no_dokument'];
		$ep->ekspertise = $request['ekspertise'];
		$ep->dokter_id = $request['dokter_id'];
		$ep->dokter_pengirim = $request['dokter_pengirim'];
		$ep->tanggal_eksp = valid_date($request['tanggal_eksp']);
		$ep->tglPeriksa = valid_date($request['tglPeriksa']);
		$ep->klinis = $request['klinis'];
		$ep->folio_id = $request['tindakan_id'];
		$ep->user_id = Auth::user()->id;
		$ep->save();

		
		$cek = \App\Orderradiologi::where('registrasi_id', $request['registrasi_id'])->first();
	
		if (@$cek->id != null) {
				$statRad = \App\Orderradiologi::find(@$cek->id);
				$statRad->status = 'D';
				$statRad->save();

		} 

		if ($request->proses_tte == "true") {
			$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
				->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->where('radiologi_ekspertises.id', $ep->id)
				->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'pasiens.no_rm as no_rm', 'radiologi_ekspertises.dokter_id as dokter','radiologi_ekspertises.folio_id',  'radiologi_ekspertises.dokter_pengirim as pengirim')
				->first();
	
			if(!empty($radiologi->folio_id)){
				$count = 1;
				$tindakan = Folio::where('id', $radiologi->folio_id)->first();	
			}else{
				$count = 2;
				$tindakan = Folio::where('registrasi_id', $request['registrasi_id'])->where('poli_tipe', 'R')->get();
	
			}
			$dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
			$folio = Folio::find($ep->folio_id);

			if (tte()) {
				if ($radiologi) {
					$proses_tte = true;
					$pdf = PDF::loadView('radiologi-gigi.lap_hasil_langsung_radiologi', compact('radiologi','folio', 'dokter', 'tindakan','count','proses_tte'));
					$pdf->setPaper('A4', 'potret');
					$pdfContent = $pdf->output();
		
					// Create temp pdf ekspertise file
					$filePath = uniqId() .'ekspertise-radiologi-gigi.pdf';
					File::put(public_path($filePath), $pdfContent);
	
					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(300)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(baca_dokter($ep->dokter_id) . ', ' . date('d-m-Y H:i:s'));
	
					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);
	
					$tte = tte_visible_koordinat($filePath, $request->nik_dokter, $request->passphrase, '#!', $qrCodePath);
					
					log_esign($request['registrasi_id'], $tte->response, "ekspertise-radiologi-gigi", $tte->httpStatusCode);
	
					$resp = json_decode($tte->response);
		
					if ($tte->httpStatusCode == 200) {
						$ep->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$ep->save();
						return response()->json(['sukses' => true, 'data' => $ep]);
					} elseif ($tte->httpStatusCode == 400) {
						if (isset($resp->error)) {
							// Batal save expertise (Hapus expertise)
							$ep->delete();
							if (!empty($ed)) {
								$ed->delete();
							}
	
							return response()->json(['sukses' => false, 'message' => $resp->error . ', Ekspertise tidak tersimpan']);
						}
					} elseif ($tte->httpStatusCode == 500) {
						return response()->json(['sukses' => false, 'message' => $tte->response . ', Ekspertise tidak tersimpan']);
					}
	
					// Batal save expertise (Hapus expertise)
					$ep->delete();
					if (!empty($ed)) {
						$ed->delete();
					}
	
					return response()->json(['sukses' => false, 'message' => "Gagal melakukan proses TTE, Ekspertise tidak tersimpan"]);
				}
			} else {
				if ($radiologi) {
					$tte_nonaktif = true;
					$pdf = PDF::loadView('radiologi-gigi.lap_hasil_langsung_radiologi', compact('radiologi','folio', 'dokter', 'tindakan','count','tte_nonaktif'));
					$pdf->setPaper('A4', 'potret');
					$pdfContent = $pdf->output();

					$ep->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
					$ep->save();
					return response()->json(['sukses' => true, 'data' => $ep]);
				}
			}
		}

		return response()->json(['sukses' => true, 'data' => $ep]);
	}

	//Laporan Kinerja
	public function laporanKinerja() {
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		return view('radiologi-gigi.lap_kinerja', $data);
	}

	public function laporanKinerjaByRequest(Request $request) {
		$tga = $request['tglAwal'] ? valid_date($request['tglAwal']) . ' 00:00:00' : NULL;
		$tgb = $request['tglAkhir'] ? valid_date($request['tglAkhir']) . ' 23:59:59' : NULL;
		$cara_bayar = \Modules\Registrasi\Entities\Carabayar::all();
		$pelayanan =  $request['pelayanan'];
		$bayar = $request['bayar'];
		$data = Folio::where('poli_tipe', 'R')
			->whereIN('poli_id', [38])
			->whereBetween('created_at', [$tga, $tgb])
			->select('registrasi_id', 'namatarif', 'cara_bayar_id', 'total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id',
				'jenis_pasien', 'poli_id', 'created_at','updated_at', 'radiografer', 'dokter_radiologi', 'user_id');
			// 	->where('jenis', $request['pelayanan'])
			// ->where('cara_bayar_id', $request['bayar'])
			if(isset($pelayanan)){
				$data   = $data->where('jenis', $pelayanan);
			}
			if(isset($bayar)){
				$data   = $data->where('cara_bayar_id', $bayar);
			}
			$data = $data->get();
		$total = $data->sum('total');
		if ($request['submit'] == 'lanjut') {
			return view('radiologi-gigi.lap_kinerja', compact('data', 'cara_bayar', 'total'))->with('no', 1);
		} elseif ($request['submit'] == 'excel') {
			Excel::create('Laporan Kinerja Radiologi', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Kinerja Radiologi')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Kinerja Radiologi');
				$excel->sheet('Laporan Kinerja Radiologi', function ($sheet) use ($data) {
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
						'Tanggal Entry Ekspertise',
						'Tanggal Input',
						'Penginput',
						'Radiografer',
						'Dokter',
						'Pemeriksaan',
						'Tarif RS',
					]);
					foreach ($data as $key => $d) {
						$ekspertise = @\App\RadiologiEkspertise::where('registrasi_id', $d->registrasi_id)->orderBy('created_at', 'desc')->first();
						$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
						$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
						$pasien = Pasien::find($d->pasien_id);
						if ($d->jenis == 'TA' || $d->jenis == 'TG') {
							$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
						} elseif ($d->jenis == 'TI') {
							$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
						}
						$sheet->row(++$row, [
							$no++,
							$pasien ? $pasien->nama : NULL,
							$pasien ? $pasien->no_rm : NULL,
							(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
							$pasien ? $pasien->kelamin : NULL,
							@$poli,
							baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
							@date('d/m/Y H:i:s ',strtotime(@$ekspertise->created_at)),
							@date('d/m/y H:i:s', strtotime(@$d->created_at)),
							!empty($d->user_id) ? baca_user($d->user_id) : NULL,
							!empty($d->radiografer) ? baca_dokter($d->radiografer) : NULL,
							!empty($d->dokter_radiologi) ? baca_dokter($d->dokter_radiologi) : NULL,
							@$d->namatarif,
							$d->total,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	//Laporan Radiologi Expertest
	public function radiologiHasil() {
		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
			// ->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'radiologi_ekspertises.ekspertise', 'radiologi_ekspertises.no_dokument')
			// ->orderby('registrasis.id')
			// ->get();
			->where('radiologi_ekspertises.poli_id',poliRadiologiGigi())
			->distinct('registrasis.id')
			->get(['registrasis.id']);
		// return compact('radiologi'); die;
		return view('radiologi-gigi.hasil_radiologi', compact('radiologi'))->with('no', 1);
	}

	public function radiologiHasilBytanggal(Request $request) {
		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.created_at', 'like', valid_date($request['tga']) . '%')
			// ->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'radiologi_ekspertises.ekspertise', 'radiologi_ekspertises.no_dokument')
			// ->orderby('registrasis.id')
			// ->get();
			->where('radiologi_ekspertises.poli_id',poliRadiologiGigi())
			->distinct('registrasis.id')
			->get(['registrasis.id']);
		// return $radiologi; die;
		return view('radiologi-gigi.hasil_radiologi', compact('radiologi'))->with('no', 1);
	}

	public static function cetakRincianRad($unit, $registrasi_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $registrasi_id, 'poli_tipe' => 'R'])->orderBy('created_at')->get();
		$data['sisaTagihan'] = Folio::where(['poli_id'=>poliRadiologiGigi(),'registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'R'])->orderBy('created_at')->get();
		if($unit == 'irj'){
			$data['unit'] = 'Instalasi Rawat Jalan';
		}elseif($unit == 'ird'){
			$data['unit'] = 'Instalasi Rawat Darurat';
		}else{
			$data['unit'] = 'Instalasi Rawat Inap';
		}
		return view('laboratorium.cetakRincian', $data)->with('no', 1);
		// $folio = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->get();
		// $reg = Registrasi::find($registrasi_id);
		// $jml = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->sum('total');
		// $no = 1;
		// $status = 'radiologi';
		// $pdf = PDF::loadView('bridging.rincianBiayaJKN', compact('reg', 'folio', 'jml', 'no', 'status'));
		// return $pdf->stream();
	}

	public static function lihatHasil($id) {
		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.id', $id)
			->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'radiologi_ekspertises.dokter_id as dokter',  'radiologi_ekspertises.dokter_pengirim as pengirim')
			->first();
		$dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
			// return $radiologi; die;
		if ($radiologi) {
			return view('radiologi-gigi.lihat-hasil', compact('radiologi','dokter'));
		} else {
			Flashy::success('Cetak Ekspertise Gagal');
			return redirect()->back();
		}
	}

	public static function cetakan($id)
	{
		$radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.id', $id)
			->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'radiologi_ekspertises.dokter_id as dokter',  'radiologi_ekspertises.dokter_pengirim as pengirim')
			->first();
		$dokter = \Modules\Pegawai\Entities\Pegawai::find($radiologi->dokter_id);
		// return $radiologi; die;
		if ($radiologi) {
			return view('radiologi-gigi.lap_hasil_radiologi', compact('radiologi', 'dokter'));
		} else {
			Flashy::success('Cetak Ekspertise Gagal');
			return redirect()->back();
		}
	}

	function saveEkpertisePasien(Request $request) {
		// return $request; die;
		request()->validate(['no_dokument' => 'required', 'tanggal_eksp' => 'required', 'klinis' => 'required']);
		
		if (\App\RadiologiEkspertise::where('id', $request['ekspertise_id'])->where('registrasi_id', $request['registrasi_id'])->count() > 0) {
			$ep = \App\RadiologiEkspertise::find($request['ekspertise_id']);
		} else {
			$ep = new \App\RadiologiEkspertise();
		}
		$ep->registrasi_id = $request['registrasi_id'];
		$ep->no_dokument = $request['no_dokument'];
		$ep->tarif_id = $request['tarif_id'];
		$ep->ekspertise = $request['ekspertise'];
		$ep->dokter_id = $request['dokter_id'];
		$ep->poli_id = @$request['poli_id'];
		$ep->dokter_pengirim = $request['dokter_pengirim'];
		$ep->tanggal_eksp = valid_date($request['tanggal_eksp']);
		$ep->klinis = $request['klinis'];
		$ep->user_id = Auth::user()->id;
		$ep->save();
		
		if ($request['jenis'] == 'IGD') {
			return redirect('radiologi-gigi/tindakan-ird');
			Flashy::success('Ekspertise Berhasil Simpan!!');
		} elseif($request['jenis'] == 'IRJ') {
			return redirect('radiologi-gigi/tindakan-irj');
			Flashy::success('Ekspertise Berhasil Simpan!!');
		} else {
			return redirect('radiologi-gigi/tindakan-irna');
			Flashy::success('Ekspertise Berhasil Simpan!!');
		}
	}

	//expertise satu-satu
	public function detailEkspertise($registrasi_id) {
		$data['ekspertise'] = Folio::where('poli_id',poliRadiologiGigi())->where('registrasi_id', $registrasi_id)->Where('poli_tipe', 'R')->get();
		return view('radiologi-gigi.detailTindakan', $data)->with(['no' => 1, 'baris' => 1]);
	}

	//Expertise Baru
	public function entryExpertiseIRJ($registrasi_id, $id, $tarif_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tindakan'] = Folio::where('id', $id)->first();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->first();
		$data['eksp'] = $ekspertise ? $ekspertise : [];
		$ekspertise1 = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->first();
		$data['eksp1'] = $ekspertise1 ? $ekspertise1 : [];
		$data['tanggal'] = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : date('d-m-Y');

		// return $data; die;
		return view('radiologi-gigi.entryExpertiseRadiologiIRJ', $data)->with('no', 1);

	}

	public function entryExpertiseIRNA($registrasi_id, $id, $tarif_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tindakan'] = Folio::where('id', $id)->first();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->first();
		$data['eksp'] = $ekspertise ? $ekspertise : [];
		$ekspertise1 = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->first();
		$data['eksp1'] = $ekspertise1 ? $ekspertise1 : [];
		$data['tanggal'] = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : date('d-m-Y');

		// return $data; die;
		return view('radiologi-gigi.entryExpertiseRadiologiIRNA', $data)->with('no', 1);

	}

	public function entryExpertiseIGD($registrasi_id, $id, $tarif_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tindakan'] = Folio::where('id', $id)->first();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
		$ekspertise = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->first();
		$data['eksp'] = $ekspertise ? $ekspertise : [];
		$ekspertise1 = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->first();
		$data['eksp1'] = $ekspertise1 ? $ekspertise1 : [];
		$data['tanggal'] = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : date('d-m-Y');

		// return $data; die;
		return view('radiologi-gigi.entryExpertiseRadiologiIGD', $data)->with('no', 1);
	}

	//Laporan Radiologi Expertest
	public function radiologiTerbilling() {
		// $radiologi = Folio::join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
			
		// 	->where('folios.poli_tipe','R')
		// 	->whereIn('folios.poli_id', [
		// 		3, 4, 34, 38
		// 	])
		// 	->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
			// ->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'radiologi_ekspertises.ekspertise', 'radiologi_ekspertises.no_dokument')
			// ->orderby('registrasis.id')
			// ->get();
			// ->distinct('registrasis.id')
			// ->get(['registrasis.id']);
		// dd($radiologi);
		// return compact('radiologi'); die;

		$radiologi = Folio::leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->with(['registrasi', 'registrasi.bayars', 'registrasi.poli', 'dokterRadiologi','user', 'user.pegawai'])
				->where('folios.poli_tipe','R')
				->where('folios.poli_id', poliRadiologiGigi())
				->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
				->select([
					'registrasis.id',
					'registrasis.dokter_id', 
					'folios.namatarif', 
					'folios.id as folios_id', 
					'folios.registrasi_id',
					'folios.dokter_radiologi', 
					'folios.no_foto', 
					'folios.waktu_periksa', 
					'folios.catatan',
					'folios.user_id',
					'folios.created_at', 
					'folios.updated_at', 
					'pasiens.nama as namaPasien', 
					'pasiens.no_rm as noRM'
				])
				->get();
		return view('radiologi-gigi.hasil_radiologi_terbilling', compact('radiologi'))->with('no', 1);
	}

	public function radiologiTerbillingBytanggal(Request $request) {
		// $radiologi = \App\RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
		// 	->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->where('registrasis.created_at', 'like', valid_date($request['tga']) . '%')
		// 	// ->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'radiologi_ekspertises.ekspertise', 'radiologi_ekspertises.no_dokument')
		// 	// ->orderby('registrasis.id')
		// 	// ->get();
		// 	->distinct('registrasis.id')
		// 	->get(['registrasis.id','radiologi_ekspertises.klinis']);
		// $radiologi = Folio::join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
			
		// 	->where('folios.poli_tipe','R')
		// 	->whereIn('folios.poli_id', [
		// 		3, 4, 34, 38
		// 	])
		// 	->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			// ->where('registrasis.created_at', 'like', valid_date($request['tga']) . '%')
			// ->orderby('registrasis.id')
			// ->get();
			// ->distinct('registrasis.id')
			// ->get(['registrasis.id']);
		// return $radiologi; die;
		$radiologi = Folio::leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->with(['registrasi', 'registrasi.bayars', 'registrasi.poli', 'dokterRadiologi','user', 'user.pegawai'])
				->where('folios.poli_tipe','R')
				->where('folios.poli_id', poliRadiologiGigi())
				->whereBetween('registrasis.created_at', [valid_date($request->tga) . ' 00.00.00', valid_date($request->tgb) . ' 23.59.59'])
				->select([
					'registrasis.id',
					'registrasis.dokter_id', 
					'folios.namatarif', 
					'folios.id as folios_id', 
					'folios.registrasi_id',
					'folios.dokter_radiologi', 
					'folios.no_foto', 
					'folios.waktu_periksa', 
					'folios.catatan',
					'folios.user_id',
					'folios.created_at', 
					'folios.updated_at', 
					'pasiens.nama as namaPasien', 
					'pasiens.no_rm as noRM'
				])
				->get();
		return view('radiologi-gigi.hasil_radiologi_terbilling', compact('radiologi'))->with('no', 1);
	}

	public function viewrad($id) {
		$data['reg'] = Registrasi::find($id);
		$data['folio'] = Folio::where(['registrasi_id' => $id, 'poli_tipe' => 'R','poli_id'=>poliRadiologiGigi()])->get();
	
		return view('radiologi-gigi.view', $data);
	}

	public function createEkspertise($registrasi_id)
	{
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['umur'] = hitung_umur($data['reg']->pasien->tgllahir);
		$data['tindakan'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->get();
		$data['rad'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_id',poliRadiologiGigi())->where('poli_tipe', 'R')->orderBy('id','DESC')->first();
		// dd($data['rad']);
		$data['ekspertise'] = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$data['eksp'] = $data['ekspertise'] ? $data['ekspertise'] : [];
		$data['tanggal'] = !empty($data['ekspertise']->tanggal_eksp) ? tanggalPeriode($data['ekspertise']->tanggal_eksp) : null;
		$data['tindakan'] = Folio::where(['poli_id' => poliRadiologiGigi(),'registrasi_id' => $registrasi_id, 'poli_tipe' => 'R'])->orderBy('id','DESC')->get();
		if(count($data['tindakan']) == '0'){
			Flashy::info('Tidak ada tindakan');
			return redirect()->back();
		}
		$data['radiografer'] = getDokterRadiologiGigi();
		$data['order'] = Orderradiologi::where(['registrasi_id' => $registrasi_id, 'jenis' => 'TA'])->get();
		// $data = '';
		// foreach($tindakan as $key=>$val){
		// 	$selected = $key == '0' ? 'selected' : '';
		// 	$data .= '<option data_tgl="'.$val->created_at.'" value="'.$val->id.'" '.$selected.'>'.$val->namatarif.'</option>';
		// }
		// return '<select class="form-control" name="tindakan_id"><option>Silahkan Pilih</option>'.$data.'</select>';
		return view('radiologi-gigi.ekspertise', $data)->with('no', 1);
	}



	public function cariPasien()
	{
		return view('radiologi-gigi.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		
		$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->first();
		$radiologi = Folio::join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
			->where('registrasis.pasien_id', @$data['pasien']->id)
			->where('folios.poli_tipe','R')
			->where('folios.poli_id', poliRadiologiGigi())
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->orderBy('registrasis.id','DESC')
			->get(['registrasis.id', 'folios.namatarif', 'folios.id as folios_id']);
	
	
		// return $data; die;
		return view('radiologi-gigi.cari-pasien', compact('radiologi'))->with('no', 1);
	}

	public function cariPasienPerawat()
	{	
		return view('radiologi-gigi.cari-pasien-perawat');
	}
	public function cariPasienProsesPerawat(Request $request)
	{
		
		session()->forget(['dokter', 'pelaksana', 'perawat']);
	

		$dataPasien = Pasien::where('no_rm', $request->no_rm)->first();
		$data['registrasi'] = Registrasi::where('pasien_id', @$dataPasien->id)->orderBy('id','DESC')->get();
		
		
		return view('radiologi-gigi.cari-pasien-perawat', $data)->with('no', 1);

	}












}
