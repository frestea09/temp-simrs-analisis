<?php

namespace App\Http\Controllers;
use App\Foliopelaksana;
use App\HistorikunjunganLAB;
use App\HistorikunjunganIRJ;
use App\KondisiAkhirPasien;
use App\Labkategori;
use App\Laboratorium;
use App\Pasienlangsung;
use App\Hasillab;
use Auth;
use DB;
use Excel;
use Flashy;
use Illuminate\Http\Request;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use PDF;
use App\Orderlab;
use App\Labsection;
use App\FolioMulti;
use Modules\Registrasi\Entities\Carabayar;
use App\Nomorrm;

class LaboratoriumControllerCommon extends Controller {
	public function index() {
		$data = Laboratorium::all();
		return view('laboratoriumCommon.lab.index', compact('data'))->with('no', 1);
	}

	public function create() {
		$data['kategori'] = Labkategori::pluck('nama', 'id');
		return view('laboratoriumCommon.lab.create', $data);
	}

	public function hapusLabSection($id) {
	     //dd($id);
		 $LabSec = Labsection::find($id);
		 $LabSec->delete();
		 Flashy::success('Data Berhasil dihapus');
	     return redirect('labsection');
	}

	public function hapusLabKategori($id) {
		//dd($id);
		$LabKat = Labkategori::find($id);
		$LabKat->delete();
		Flashy::success('Data Berhasil dihapus');
	    return redirect('labkategori');
   }

	public function store(Request $request) {
		$data = request()->validate(['nama' => 'required|unique:laboratoria,nama',
			'rujukan' => 'required',
			'nilairujukanbawah' => ' required',
			'nilairujukanatas' => 'required',
			'satuan' => 'required',
			'labkategori_id' => 'sometimes',
		]);
		Laboratorium::create($data);
		Flashy::success('Data berhasil disimpan');
		return redirect('lab');
	}
	public function edit($id) {
		$data['lab'] = Laboratorium::find($id);
		$data['kategori'] = Labkategori::pluck('nama', 'id');
		return view('laboratoriumCommon.lab.edit', $data);
	}

	public function update(Request $request, $id) {
		$data = request()->validate(['nama' => 'required|unique:laboratoria,nama,' . $id,
			'rujukan' => 'required',	
			'nilairujukanbawah' => ' required',
			'nilairujukanatas' => 'required',
			'satuan' => 'required',
			'labkategori_id' => 'sometimes',
		]);

		Laboratorium::find($id)->update($data);
		Flashy::info('Data berhasil disimpan');
		return redirect('lab');
	}

	public function destroy($id) {
		Laboratorium::find($id)->delete();
		Flashy::danger('Data berhasil dihapus');
		return redirect('lab');
	}

	//============================== TINDAKAN IRJ ===========================
	public function tindakanIRJ() {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '10000M');
		session()->forget('jenis');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		$data['poli'] = Poli::where('politype', 'L')->pluck('nama', 'id');
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'J%')
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratoriumCommon.tindakanIRJ', $data)->with('no', 1);
	}

	public function Order($registrasi_id)
	{
		$data = \App\Orderlab::where('registrasi_id', $registrasi_id)->latest()->first();
		return response()->json($data);
	}

	public function tindakanIRJByTanggal(Request $request) {

		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '10000M');
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		$query = Registrasi::where('status_reg', 'like', 'J%');
		if($request->poli_id){
			$query = $query->where('poli_id',$request->poli_id);
		}
		$data['registrasi'] = $query->whereBetween('created_at', [$tga, $tgb])->get();
		// dd($data['registrasi']);
		$data['poli'] = Poli::whereIn('politype',['J','L'])->pluck('nama', 'id');
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'J%')
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		
		return view('laboratoriumCommon.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRD() {
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		// $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'G1'])->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'G%')
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratoriumCommon.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRDByTanggal(Request $request) {
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		// $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'G1'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'G%')
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratoriumCommon.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRNA() {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '10000M');

		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::with([
			'pasien',
			'bayars', 
			'folioLabPA',
			'rawat_inap', 
			'rawat_inap.dokter_ahli',
			'rawat_inap.kamar',
		])
			->where('registrasis.status_reg', 'I2')
			->select([
				'id',
				'pasien_id',
				'bayar',
				'tipe_jkn',
				'no_sep',
				'created_at',
			])
			->get();

		$data['role'] = Auth::user()->role()->first()->name;
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where(['folios.poli_tipe' => 'L', 'registrasis.status_reg' => 'I2'])
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratoriumCommon.tindakanIRNA', $data)->with('no', 1);
	}

	public function tindakanIRNAByTanggal(Request $request) {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '10000M');
		
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		$data['registrasi'] = Registrasi::with([
				'pasien',
				'bayars', 
				'folioLabPA',
				'rawat_inap', 
				'rawat_inap.dokter_ahli',
				'rawat_inap.kamar',
			])
			->where('status_reg', 'like', 'I%')
			->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->select([
				'id',
				'pasien_id',
				'bayar',
				'tipe_jkn',
				'no_sep',
				'created_at',
			])
			->get();

		$data['role'] = Auth::user()->role()->first()->name;	
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where(['folios.poli_tipe' => 'L', 'registrasis.status_reg' => 'I2'])
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratoriumCommon.tindakanIRNA', $data)->with('no', 1);
	}

	//Insert ke Histori Kunjungan
	public function insertKunjungan($registrasi_id, $pasien_id) {
		$reg = Registrasi::find($registrasi_id);
		$kl = new HistorikunjunganLAB();
		$kl->registrasi_id = $registrasi_id;
		$kl->pasien_id = $pasien_id;
		$kl->poli_id = $reg->poli_id;
		if (substr($reg->status_reg, 0, 1) == 'J') {
			$kl->pasien_asal = 'TA';
		} elseif (substr($reg->status_reg, 0, 1) == 'G') {
			$kl->pasien_asal = 'TG';
		} elseif (substr($reg->status_reg, 0, 1) == 'I') {
			$kl->pasien_asal = 'TI';
		}
		$kl->user = Auth::user()->name;
		$kl->save();
		if (substr($reg->status_reg, 0, 1) == 'I') {
			return redirect('laboratoriumCommon/entry-tindakan-irna/' . $registrasi_id . '/' . $pasien_id);
		} else {
			return redirect('laboratoriumCommon/entry-tindakan-irj/' . $registrasi_id . '/' . $pasien_id);
		}
	}

	public function entryTindakanIRNA($idreg, $idpasien) {
		//$data['folio'] = Folio::where('registrasi_id', $idreg)->whereIn('poli_id', [16,30])->get();
		$data['folio'] = Folio::where('registrasi_id', $idreg)
			->where('jenis', 'TI')
			->where('poli_id', 43)
			->where('poli_tipe', 'L')
			//->whereIn('folios.poli_id', [16, 30])
			->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)
			->where('jenis', 'TI')
			->where('poli_id', 43)
			->where('poli_tipe', 'L')
			//->whereIn('folios.poli_id', [16, 30])
			->where('lunas', 'N')->sum('total');
	
		$data['lab'] = (Orderlab::where('registrasi_id', $idreg)->first()) ? Orderlab::where('registrasi_id', $idreg)->first()->pemeriksaan : NULL;
		$data['dokters_poli'] = Poli::where('id', 43)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 43)->pluck('perawat_id');
		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');

		$jenis = $data['jenis']->status_reg;
		//dd($jenis );
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			//dd("test");
			session(['jenis' => 'TI']);
			$data['opt_poli'] = Poli::where('politype', 'L')->get();
		}

		$data['opt_poli'] = Poli::where('politype', 'L')->where('id', '!=',25)->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id',10)->where('tarifs.jenis', '=', 'TI')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		// return $data;die;
		return view('laboratoriumCommon.entryTindakanLaboratoriumIRNA', $data)->with('no', 1);
	}

	public function entryTindakanIRJ($idreg, $idpasien) {

	    //dd("test");
		$data['folio'] = Folio::where(['registrasi_id' =>  $idreg])->where('poli_id', 43)->where('poli_tipe', 'L')->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)->where('lunas', 'N')->where('poli_id', 43)->sum('total');
		$data['dokters_poli'] = Poli::where('id', 43)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 43)->pluck('perawat_id');
		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');

	    //dd($data['jenis']->status_reg);

		$jenis = $data['jenis']->status_reg;
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			$data['opt_poli'] = Poli::where('politype', 'L')->get();
		}
		$data['opt_poli'] = Poli::where('id', 43)->get();
		$data['opt_poli'] = Poli::where('id', 43)->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id',10)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		return view('laboratoriumCommon.entryTindakanLaboratorium', $data)->with('no', 1);
	}

	public function saveTindakan(Request $request) {
		request()->validate(['tarif_id' => 'required']);
		session(['dokter' => $request['dokter_id'], 'pelaksana' => $request['pelaksana'], 'analis_lab' => $request['analis_lab']]);

		$reg    = Registrasi::find($request['registrasi_id']);

		// Save ket klinis
		$reg->keterangan_klinis = $request['ket_klinis'];
		$reg->save();

		foreach ($request['tarif_id'] as $i) {

			//dd($reg);
            $kode   = $i;
			$tarif  = Tarif::where('id',$kode)->first();

			// if (isset($request['page'])) {
			// 	if ($request['page'] == 'labJalan' || $request['page'] == 'labIgd' || $request['page'] == 'labInap') {
			// 		$poli_tipe = 'L';
			// 	} else if ($request['page'] == 'radJalan' || $request['page'] == 'radIgd' || $request['page'] == 'radInap') {
			// 		$poli_tipe = 'R';
			// 	}
			// } else {
			// 	if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
			// 		$poli_tipe = 'G';
			// 	} else {
			// 		$poli_tipe = 'J';
			// 	}
			// }

			if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
				$pelaksana_tipe = 'TG';
			} else {
				$pelaksana_tipe = 'TA';
			}
			

			if (isset($request->no_sediaan)) {
				$noSedia = $request->no_sediaan;
			}


           
	      FolioMulti::create([
                'registrasi_id'    => $request['registrasi_id'],
				'poli_id'          => 43,
				'lunas'            => 'N',
                'namatarif'        => $tarif->nama,
				'dijamin'          => $request['dijamin'],
				'tarif_id'         => $tarif->id,
                // 'cara_bayar_id'    => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
                'cara_bayar_id'    => $request['bayar'],
				'jenis'            => $tarif->jenis,
				'poli_tipe'        => 'L',
                'total'            => ($tarif->total * $request['jumlah']),
				'jenis_pasien'     => $request['jenis'],
				'harus_bayar'     => @$request['jumlah'],
				'verif_kasa_user'     => 'tarif_new',
                'pasien_id'        => $request['pasien_id'],
                'dokter_id'        => $request['dokter_id'],
                'user_id'          => Auth::user()->id,
                'mapping_biaya_id' => $tarif->mapping_biaya_id,
				'dpjp'             => $request['dokter_id'],
				'dokter_pelaksana' => $request['pelaksana'],
				'dokter_lab'       => $request['dokter_lab'],
		        'analis_lab'       => $request['analis_lab'],
				'no_sediaan'	   => @$request['no_sediaan'],
				'diagnosa'	 	   => @$request['ket_klinis'],
				'perawat'          => $request['perawat'],
                'pelaksana_tipe'   => $pelaksana_tipe
            ]);

		}
		
		// $reg = Registrasi::find($request['registrasi_id']);
		// $tarif = Tarif::find($request['tarif_id']);
		// $fol = new Folio();
		// $fol->registrasi_id = $request['registrasi_id'];
		// $fol->poli_id = $request['poli_id'];
		// $fol->lunas = 'N';
		// $fol->namatarif = $tarif->nama;
		// $fol->tarif_id = $request['tarif_id'];
		// $fol->jenis = $tarif->jenis;
		// if(isset($request->cara_bayar_id)){
		// 	$fol->cara_bayar_id = $request->cara_bayar_id;
		// }else{
		// 	$fol->cara_bayar_id = $reg->bayar;
		// }
		// $fol->poli_tipe = 'L';
		// $fol->total = ($tarif->total * $request['jumlah']);
		// $fol->jenis_pasien = $request['jenis'];
		// $fol->pasien_id = $request['pasien_id'];
		// $fol->dokter_id = $request->dokter_id;
		// if (!empty($request['tanggal'])) {
		// 	$fol->created_at = valid_date($request['tanggal']);
		// }
		// $fol->user_id = Auth::user()->id;
		// $fol->mapping_biaya_id = $tarif->mapping_biaya_id;

		// //revisi folio
		// $fol->dpjp = $reg->dokter_id;
		// $fol->dokter_lab = $request['dokter_lab'];
		// $fol->analis_lab = $request['analis_lab'];
		// if (substr($reg->status_reg, 0, 1) == 'G') {
		// 	$fol->pelaksana_tipe = 'TG';
		// } elseif (substr($reg->status_reg, 0, 1) == 'I') {
		// 	$fol->pelaksana_tipe = 'TI';
		// } else {
		// 	$fol->pelaksana_tipe = 'TA';
		// }
		// $fol->save();


		//INSERT FOLIO PELAKSANA
		// $fp = new Foliopelaksana();
		// $fp->folio_id = $fol->id;
		// $fp->dpjp = $reg->dokter_id;
		// $fp->dokter_lab = $request['dokter_lab'];
		// $fp->analis_lab = $request['analis_lab'];
		// if (substr($reg->status_reg, 0, 1) == 'G') {
		// 	$fp->pelaksana_tipe = 'TG';
		// } elseif (substr($reg->status_reg, 0, 1) == 'I') {
		// 	$fp->pelaksana_tipe = 'TI';
		// } else {
		// 	$fp->pelaksana_tipe = 'TA';
		// }
		// $fp->user = Auth::user()->id;
		// $fp->save();

		// if (substr($reg->status_reg, 0, 1) == 'G') {
		// 	$reg->status_reg = 'G2';
		// } elseif (substr($reg->status_reg, 0, 1) == 'I') {
		// 	$reg->status_reg = 'I2';
		// } elseif (substr($reg->status_reg, 0, 1) == 'L') {
		// 	$reg->status_reg = 'L1';
		// } elseif (substr($reg->status_reg, 0, 1) == 'J') {
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
			return redirect('laboratoriumCommon/entry-tindakan-irna/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		} elseif (substr($reg->status_reg, 0, 1) == 'L') {
			return redirect('laboratoriumCommon/entry-transaksi-langsung/' . $request['registrasi_id']);
		} else {
			return redirect('laboratoriumCommon/entry-tindakan-irj/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		}
	}

	public function hapusTindakanIRJ($id, $idreg, $pasien_id) {
		// dd( Auth::user()->hasRole(['administrator']) );
		if (Auth::user()->hasRole(['supervisor', 'laboratorium_patalogi_anatomi', 'administrator'])) {
			// Folio::where('id', $id)->where('lunas', 'N')->delete();

			$folio = Folio::find($id);

			if (@$folio->lunas == 'N') {
				$folio->delete();
			}
		}
		$reg = Registrasi::find($idreg);
		if (substr($reg->status_reg, 0, 1) == 'I') {
			return redirect('laboratoriumCommon/entry-tindakan-irna/' . $idreg . '/' . $pasien_id);
		} elseif (substr($reg->status_reg, 0, 1) == 'L') {
			return redirect('laboratoriumCommon/entry-transaksi-langsung/' . $reg->id);
		} else {
			return redirect('laboratoriumCommon/entry-tindakan-irj/' . $idreg . '/' . $pasien_id);
		}
	}

	public static function cetakRincianLab($unit, $registrasi_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L', 'poli_id' => 43])->orderBy('created_at')->get();
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->orderBy('created_at')->get();
		$data['folio'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L', 'poli_id' => 43])->first();
		// $data['pelaksana']	= Folio::where('id', $data['folio']->id)->first();
		// // return $data; die;
		if($unit == 'irj'){
			$data['unit'] = 'Instalasi Rawat Jalan';
		}elseif($unit == 'ird'){
			$data['unit'] = 'Instalasi Rawat Darurat';
		}else{
			$data['unit'] = 'Instalasi Rawat Inap';
		}
		return view('laboratoriumCommon.cetakRincian', $data)->with('no', 1);
	}

	public function lap_kunjungan() {
		$data['kunjungan'] = NULL;
		return view('laboratoriumCommon.lap_kunjungan', $data);
	}

	public function lap_kunjungan_by_request(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['kunjungan'] = HistorikunjunganIRJ::where('poli_id', '6')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		// return $data['kunjungan']; die;
		// $data['kunjungan'] = Orderlab::whereBetween('order_lab.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
		// 					->leftJoin('registrasis', 'order_lab.registrasi_id', '=', 'registrasis.id')
		// 					->selectRaw('registrasis.pasien_id as pasien_id, order_lab.created_at as created_at, order_lab.user_id as user_id, registrasis.status as status, order_lab.registrasi_id as registrasi_id, registrasis.poli_id as poli_id')
		// 					->get();
		// $data['kunjungan'] = Folio::leftJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 	->where('folios.poli_id', 43)
		// 	->whereBetween('folios.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
		// 	->groupBy('folios.registrasi_id')
		// 	->get(['folios.registrasi_id', 'folios.namatarif', 'folios.cara_bayar_id', 'folios.total', 'folios.tarif_id', 'folios.jenis','folios.dokter_lab', 'folios.lunas', 'folios.pasien_id', 'folios.dokter_id', 'folios.jenis_pasien', 'folios.poli_id', 'folios.created_at', 'folios.dokter_pelaksana', 'registrasis.status', 'registrasis.no_sep']);
		$query = Folio::leftJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
			->where('folios.poli_id', 43)
			->whereBetween('folios.created_at', [
				valid_date($request['tga']) . ' 00:00:00',
				valid_date($request['tgb']) . ' 23:59:59'
			]);

		if (!empty($request['status_reg'])) {
			$query->where('registrasis.status_reg', $request['status_reg']);
		}

		$data['kunjungan'] = $query->groupBy('folios.registrasi_id')
			->get([
				'folios.registrasi_id',
				'folios.namatarif',
				'folios.cara_bayar_id',
				'folios.total',
				'folios.tarif_id',
				'folios.jenis',
				'folios.dokter_lab',
				'folios.lunas',
				'folios.pasien_id',
				'folios.dokter_id',
				'folios.jenis_pasien',
				'folios.poli_id',
				'folios.created_at',
				'folios.dokter_pelaksana',
				'registrasis.status',
				'registrasis.no_sep',
				'registrasis.status_reg'
			]);
		$data['pasien_asal'] = $request['pasien_asal'];
		if ($request['view']) {
			return view('laboratoriumCommon.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
			// dd($data);
			$judul = 'Labor';
			if ($request['pasien_asal'] == 'TI') {
				$judul = 'IRNA';
			} elseif ($request['pasien_asal'] == 'TA') {
				$judul = 'IRJ';
			} elseif ($request['pasien_asal'] == 'TG') {
				$judul = 'IGD';
			}
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
						'No. SEP',
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
							$d->no_sep ? $d->no_sep : NULL,
							$pasien ? $pasien->nama : @$reg->pasien->nama,
							$pasien ? $pasien->no_rm : NULL,
							$pasien ? hitung_umur($pasien->tgllahir, 'Y') : NULL,
							$pasien ? $pasien->kelamin : NULL,
							!empty($d->poli_id) ? baca_poli($d->poli_id) : NULL,
							!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id) : NULL,
							tanggal($d->created_at),
						]);
					}
				});
			})->export('xlsx');
		}

	}

	//TINDAKAN LANGSUNG
	// public function tindakanLangsung() {
	// 	$data = Pasienlangsung::where('created_at', 'like', date('Y-m-d') . '%')->where('politype', 'L')->get();
	// 	return view('laboratoriumCommon.transaksiLangsung', compact('data'))->with('no', 1);
	// }

	public function tindakanLangsung() {
		$data = Pasienlangsung::join('registrasis', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
		->where('pasien_langsung.created_at', 'like', date('Y-m-d') . '%')
		->where('politype', 'L')
		->where('registrasis.poli_id', 43)
		->select('registrasis.id', 'registrasis.lunas', 'pasien_langsung.*')
		->get();
		return view('laboratoriumCommon.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public function tindakanLangsungBytanggal(Request $request)
	{
		$data = Pasienlangsung::join('registrasis', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
			->where('pasien_langsung.created_at', 'like', valid_date($request['tga']) . '%')
			->where('politype', 'L')
			->where('registrasis.poli_id', 43)
			->select('registrasis.id', 'registrasis.lunas', 'pasien_langsung.*')
			->get();
		return view('laboratoriumCommon.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public function simpanTransaksiLangsung(Request $request) {
		request()->validate(['nama' => 'required', 'alamat' => 'required', 'kelamin' => 'required', 'tgllahir' => 'required']);
		DB::transaction(function () use ($request) {
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = '0';
			$reg->status_reg = 'L1';
			$reg->bayar = '2';
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->user_create = Auth::user()->id;
			$reg->save();

			$pasien = new Pasienlangsung();
			$pasien->registrasi_id = $reg->id;
			$pasien->nama = $request['nama'];
			$pasien->alamat = $request['alamat'];
			$pasien->no_jkn = $request['no_jkn'];
			$pasien->nik = $request['nik'];
			$pasien->no_hp = $request['nohp'];
			$pasien->kelamin = $request['kelamin'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->politype = 'L';
			$pasien->pemeriksaan = $request['pemeriksaan'];
			$pasien->user_id = Auth::user()->id;
			$pasien->save();

			$pasien_new = new Pasien();
			$pasien_new->nama = strtoupper($request['nama']);
			$pasien_new->nik = $request['nik'] ?? '-';
			$pasien_new->nohp = $request['nohp'];
			$pasien_new->tgllahir = valid_date($request['tgllahir']);
			$pasien_new->kelamin = $request['kelamin'];
			$pasien_new->alamat = strtoupper($request['alamat']);
			$pasien_new->tgldaftar = date("Y-m-d");
			$pasien_new->rt = $request['rt'];
			$pasien_new->rw = $request['rw'];
			$pasien_new->negara = 'Indonesia';
			$pasien_new->no_jkn = $request['no_jkn'];
			$pasien_new->user_create = Auth::user()->name;
			$pasien_new->user_update = '';
			$pasien_new->save();

			$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
			$rms = Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
			$rmid = $rms->id;
			$cek_pas = Pasien::where('no_rm',$rmid)->first();
			if($cek_pas){
				$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
				$rmid = $rms->id;
			}
			// UPDATEPASIEN  LANGSUNG
			$pasien->no_rm = $rmid;
			$pasien->save();

			// UPDATEPASIEN
			$pasi = Pasien::where('id',$pasien_new->id)->first();
			$pasi->no_rm = $rmid;
			$pasi->save();
			// dd($no);
			$update = Registrasi::where('id', $reg->id)->first();
			$update->pasien_id= $pasien_new->id;
			$update->poli_id = 43;
			$update->save();

			$hk = new HistorikunjunganLAB();
			$hk->registrasi_id = $reg->id;
			$hk->pasien_id = $pasien_new->id;
			$hk->poli_id = 25;
			$hk->pasien_asal = 'TA';
			$hk->user = Auth::user()->name;
			$hk->save();

			$cek_rmss = Nomorrm::where('pasien_id',$pasien_new->id)->orderBy('id','DESC')->first();
			// dd($cek_rmss);
			
			if($cek_rmss){
				if($pasien_new->no_rm !== $cek_rmss->id){
					// dd("BB");
					$up_pas = Pasien::where('id',$pasien_new->id)->first();
					$up_pas->no_rm = $cek_rmss->id;
					$up_pas->save();
				}else{
					// dd("CCC");
				}
			}

			session(['registrasi_id' => $reg->id]);
		});
		return redirect('/laboratoriumCommon/entry-transaksi-langsung/' . session('registrasi_id'));
	}

	public function tindakanCetak($registrasi_id){
		$reg = Registrasi::find($registrasi_id);
		$pasienLangsung = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$folio = Folio::where('folios.registrasi_id', $registrasi_id)
			->where('poli_id', 43)->get();
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->get();
		$sisaTagihan = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->orderBy('created_at')->get();
		return view('laboratoriumCommon.cetakLangsung', compact('pasienLangsung', 'folio', 'tindakan', 'reg', 'sisaTagihan'))->with('no', 1);
	}

	public function cetakLab($registrasi_id) {
		$pasienLangsung = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$folio = Folio::where(['folios.registrasi_id' => $registrasi_id])->where('poli_id', 43)->get();
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('folios.tarif_id', '!=', 10000)->whereIn('poli_id', [16, 30])->get();
		$reg = Registrasi::find($registrasi_id);
		return view('laboratoriumCommon.cetak', compact('pasienLangsung', 'folio', 'tindakan', 'reg'))->with('no', 1);
	}

	public function entryTindakanLangsung($registrasi_id) {
		$data['folio'] = Folio::where('folios.registrasi_id', $registrasi_id)->get();
		$data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$data['reg_id'] = $registrasi_id;
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->sum('total');
		$data['dokters_poli'] = Poli::where('id', 43)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 43)->pluck('perawat_id');
		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id',10)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['jenis'] = Registrasi::find($registrasi_id);
		$data['opt_poli'] = Poli::where('politype', 'L')->where('id', '!=', 25)->get();
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		session(['jenis' => 'TA']);
		// dd($data);
		return view('laboratoriumCommon.entryTindakanLangsung', $data)->with('no', 1);
	}

	public function laporanKinerja() {
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		return view('laboratoriumCommon.lap_kinerja', $data);
	}

	public function laporanKinerjaByRequest(Request $request) {
		$tga = $request['tglAwal'] ? valid_date($request['tglAwal']) . ' 00:00:00' : NULL;
		$tgb = $request['tglAkhir'] ? valid_date($request['tglAkhir']) . ' 23:59:59' : NULL;
		$cara_bayar = \Modules\Registrasi\Entities\Carabayar::all();
		// $data = Folio::where('jenis', $request['pelayanan'])->where('cara_bayar_id', $request['bayar'])
		// 	->where('poli_tipe', 'L')
		// 	->where('poli_id', 43)
		// 	->whereBetween('created_at', [$tga, $tgb])
		// 	->get(['registrasi_id', 'namatarif', 'cara_bayar_id', 'total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id', 'dokter_lab' ,'jenis_pasien', 'poli_id', 'created_at']);
		$query = Folio::join('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
			->where('folios.cara_bayar_id', $request['bayar'])
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', 43)
			->whereBetween('folios.created_at', [$tga, $tgb]);

		if ($request['pelayanan'] == 'PB') {
			$query->where('registrasis.status_reg', 'L1');
		} elseif ($request['pelayanan'] != '') {
			// Kalau ada nilai selain kosong dan bukan 'PB', filter jenis langsung
			$query->where('folios.jenis', $request['pelayanan']);
		}

		// Ambil kolom yang diinginkan
		$data = $query->get([
			'folios.registrasi_id', 
			'folios.namatarif', 
			'folios.cara_bayar_id', 
			'folios.total', 
			'folios.tarif_id', 
			'folios.jenis', 
			'folios.lunas', 
			'folios.pasien_id', 
			'folios.dokter_id', 
			'folios.dokter_lab',
			'folios.jenis_pasien', 
			'folios.poli_id', 
			'folios.created_at'
		]);
		$total = $data->sum('total');
		if ($request['submit'] == 'lanjut') {
			return view('laboratoriumCommon.lap_kinerja', compact('data', 'cara_bayar', 'total'))->with('no', 1);
		} elseif ($request['submit'] == 'excel') {
			Excel::create('Laporan Kinerja Laboratorium', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Kinerja Laboratorium')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Kinerja Laboratorium');
				$excel->sheet('Laporan Kinerja Laboratorium', function ($sheet) use ($data) {
					$sheet->row(1, ["DAFTAR KUNJUNGAN PASIEN LABORATORIUM PATALOGI ANATOMI RSUD OTO ISKANDAR DI NATA"]);
					$sheet->mergeCells('A1:L1');
					$row = 3;
					$no = 1;
					$sheet->row($row, [
						'NO',
						'NO. SEP',
						'TANGGAL KUNJUNGAN',
						'TANGGAL HASIL PEMERIKSAAN',
						'NAMA PASIEN',
						'UMUR',
						'JENIS KELAMIN',
						'No. RM',
						'RUANG / POLI',
						'CARA BAYAR',
						// 'Baru/Lama',
						// 'Dokter',
						'JENIS PEMERIKSAAN',
						'TARIF',
						'LUNAS',
					]);
					foreach ($data as $key => $d) {
						$reg = Registrasi::where('id', $d->registrasi_id)->first();
						$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
						$pasien = Pasien::find($d->pasien_id);
						$regs = Registrasi::where('id', $d->registrasi_id)->first();
						if ($d->lunas == 'Y'){
							$lunas = 'LUNAS';
						}else{
							$lunas ='BELUM LUNAS';
						}

						if ($d->jenis == 'TA' || $d->jenis == 'TG') {
							$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
						} elseif ($d->jenis == 'TI') {
							$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
						}
						$sheet->row(++$row, [
							$no++,
							$reg->no_sep ? $reg->no_sep : NULL,
							$regs->created_at->format('d-m-Y'),
							$d->created_at->format('d-m-Y'),
							$reg->pasien->nama,
							hitung_umur($reg->pasien->tgllahir),
							$reg->pasien->kelamin,
							$reg->pasien->no_rm,
							$poli,
							baca_carabayar($d->cara_bayar_id) . ' ' . $regs->tipe_jkn . '- Kelas ' . $regs->hakkelas,
							// ($reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
							// !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
							$d->namatarif,
							$d->total,
							$lunas,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	//Laporan Kinerja Bank Darah
	public function laporanKinerjaBankDarah() {
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		return view('laboratoriumCommon.lap_kinerja_bank_darah', $data);
	}

	public function laporanKinerjaBankDarahByRequest(Request $request) {
		$tga = $request['tglAwal'] ? valid_date($request['tglAwal']) . ' 00:00:00' : NULL;
		$tgb = $request['tglAkhir'] ? valid_date($request['tglAkhir']) . ' 23:59:59' : NULL;
		$cara_bayar = \Modules\Registrasi\Entities\Carabayar::all();
		$data = Folio::where('jenis', $request['pelayanan'])->where('cara_bayar_id', $request['bayar'])
			->where('poli_tipe', 'L')
			->where('poli_id', 43)
			->whereBetween('created_at', [$tga, $tgb])
			->get(['registrasi_id', 'namatarif', 'cara_bayar_id', 'total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id',
				'jenis_pasien', 'poli_id', 'created_at']);
		$total = $data->sum('total');
		if ($request['submit'] == 'lanjut') {
			return view('laboratoriumCommon.lap_kinerja_bank_darah', compact('data', 'cara_bayar', 'total'))->with('no', 1);
		} elseif ($request['submit'] == 'excel') {
			Excel::create('Laporan Kinerja Bank Darah', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Kinerja Bank Darah')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Kinerja Bank Darah');
				$excel->sheet('Laporan Kinerja Bank Darah', function ($sheet) use ($data) {
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
						'Dokter',
						'Pemeriksaan',
						'Tarif RS',
					]);
					foreach ($data as $key => $d) {
						$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
						$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
						$pasien = Pasien::find($d->pasien_id);
						if ($d->jenis == 'TA') {
							$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
						} elseif ($d->jenis == 'TI') {
							$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
						}
						$sheet->row(++$row, [
							$no++,
							$pasien ? $pasien->nama : NULL,
							$pasien ? $pasien->no_rm : NULL,
							($reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
							$pasien ? $pasien->kelamin : NULL,
							$poli,
							baca_carabayar($d->cara_bayar_id) . ' ' . $reg->tipe_jkn,
							$d->created_at->format('d-m-Y'),
							!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
							$d->namatarif,
							$d->total,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function cariPasien()
	{	
		return view('laboratoriumCommon.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		
		session()->forget(['dokter', 'pelaksana', 'perawat']);
	

		$dataPasien = Pasien::where('no_rm', $request->no_rm)->first();
		$data['registrasi'] = Registrasi::where('pasien_id', @$dataPasien->id)->orderBy('id','DESC')->get();
		
		
		return view('laboratoriumCommon.cari-pasien', $data)->with('no', 1);

	}


	public function cetakTindakanLabPerSesi($order_lab_id, $unit, $registrasi_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->where('order_lab_id', $order_lab_id)->orderBy('created_at')->get();
		// dd($order_lab_id, $unit, $registrasi_id);
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->where('order_lab_id', $order_lab_id)->orderBy('created_at')->get();
		$data['folio'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->first();
		// $data['pelaksana']	= Folio::where('id', $data['folio']->id)->first();
		// // return $data; die;
		if($unit == 'irj'){
			$data['unit'] = 'Instalasi Rawat Jalan';
		}elseif($unit == 'ird'){
			$data['unit'] = 'Instalasi Rawat Darurat';
		}else{
			$data['unit'] = 'Instalasi Rawat Inap';
		}
		return view('laboratorium.cetakRincian', $data)->with('no', 1);
	}

	public function hapusHistoriOrderLab($reg_id, $id)
	{
		try {
			$lab = Hasillab::where('registrasi_id', $reg_id)
				->where('id', $id)
				->first();

			if (!$lab) {
				return redirect()->back()->with('error', 'Data tidak ditemukan.');
			}

			$lab->deleted_at = now();
			$lab->save();

			return redirect()->back();
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
		}
	}


}

