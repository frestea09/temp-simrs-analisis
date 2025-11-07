<?php

namespace App\Http\Controllers;
use App\Foliopelaksana;
use App\HistorikunjunganLAB;
use App\HistorikunjunganIRJ;
use App\KondisiAkhirPasien;
use App\Labkategori;
use App\Laboratorium;
use App\Pasienlangsung;
use Auth;
use DB;
use Excel;
use App\LicaResult;
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
use App\Hasillab;
use App\Kelompokkelas;
use App\LisLog;
use App\MasterLicas;
use App\Nomorrm;
use App\Rawatinap;
use App\HistoriOrderLab;
use App\ServiceNotif;
use App\AntrianLaboratorium;
use Carbon\Carbon;
use Modules\Jenisjkn\Entities\Jenisjkn;
use Modules\Registrasi\Entities\Carabayar;
use Yajra\DataTables\DataTables;

class LaboratoriumController extends Controller {
	public function index() {
		$data = Laboratorium::all();
		return view('laboratorium.lab.index', compact('data'))->with('no', 1);
	}

	public function create() {
		$data['kategori'] = Labkategori::pluck('nama', 'id');
		return view('laboratorium.lab.create', $data);
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
		// $data = request()->validate(['nama' => 'required|unique:laboratoria,nama',
		// 	'rujukan' => 'required',
		// 	'nilairujukanbawah' => ' required',
		// 	'nilairujukanatas' => 'required',
		// 	'satuan' => 'required',
		// 	'labkategori_id' => 'sometimes',
		// ]);

		$data = request()->validate(['nama' => 'required',
			'labkategori_id' => 'sometimes',
		]);

		Laboratorium::create($data);
		Flashy::success('Data berhasil disimpan');
		return redirect('lab');
	}
	public function edit($id) {
		$data['lab'] = Laboratorium::find($id);
		$data['kategori'] = Labkategori::pluck('nama', 'id');
		return view('laboratorium.lab.edit', $data);
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
		session()->forget('jenis');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		// $data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')
		// 	->with(['pasien', 'poli', 'dokter_umum', 'bayars'])
		// 	->where('created_at', 'LIKE', date('Y-m-d') . '%')
		// 	->orderBy('id','DESC')
		// 	->get();
		$data['registrasi'] = [];
		// $data['poli'] = Poli::where('politype', 'L')->pluck('nama', 'id');
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'J%')
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratorium.tindakanIRJ', $data)->with('no', 1);
	}

	public function listLis($registrasi_id){
		$data['reg'] = Registrasi::find($registrasi_id);
		return view('laboratorium._tab_lis', $data)->with('no', 1);
	}
	public function Order($registrasi_id)
	{
		// $data = \App\Orderlab::where('registrasi_id', $registrasi_id)->where('poli_id', '!=', 43)->latest()->first();
		$data = Registrasi::where('id', $registrasi_id)->select('id', 'waktu_order_lab', 'catatan_order_lab', 'dokter_order_lab', 'is_order_lab')->first();
		return response()->json($data);
	}

	public function markDoneOrder($id)
	{
		$order = HistoriOrderLab::find($id);

		if (!$order) {
			return response()->json(['sukses' => false]);
		}

		$tarifItems = json_decode($order->tarif_id, true);

		if (is_array($tarifItems)) {
			foreach ($tarifItems as &$item) {
				$item['is_done'] = 1;
			}

			$order->tarif_id = json_encode($tarifItems);
			$order->is_done = true;
			$order->save();

			return response()->json(['sukses' => true]);
		}
		return response()->json(['sukses' => false]);
	}

	public function insertBilling($id)
	{
		$order = HistoriOrderLab::find($id);
		if ($order) {
			$reg = Registrasi::find($order->registrasi_id);
			$tarifs = json_decode($order->tarif_id);
			$dokter = Poli::where('id', 25)->pluck('dokter_id')->first();
			$dokter = @explode(",", $dokter);
			foreach ($tarifs as $i) {
				
				$tanggal = date('Y-m-d H:i:s');

				$tarif  = Tarif::where('id', $i->tarif_id)->first();

				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}

				$cito = NULL;

				if(!empty($i->cito)){
					$totals = (((150/100) * $tarif->total) * 1);
					$cito = "cyto";
				}else{
					$totals = $tarif->total * 1;
				}

				
				
                $folioMultis[] = [
					'registrasi_id'     => $reg->id,
					'poli_id'           => 25,
					'lunas'             => 'N',
					'namatarif'         => $tarif->nama,
					'tarif_id'          => $tarif->id,
					'cara_bayar_id'     => $reg->bayar,
					'jenis'             => $tarif->jenis,
					'poli_tipe'         => 'L',
					'cyto'        	    => $cito,
					'total'             => $totals,
					'jenis_pasien'      => $reg->jenis_pasien,
					'harus_bayar'      	=> 1,
					'verif_kasa_user'      => 'tarif_new',
					'pasien_id'         => $reg->pasien_id,
					'dokter_id'         => $reg->pasien_id,
					'user_id'           => Auth::user()->id,
					'mapping_biaya_id'  => $tarif->mapping_biaya_id,
					'dpjp'              => $reg->pasien_id,
					'dokter_pelaksana'  => @$dokter[0],
					'perawat'           => Auth::user()->pegawai->id,
					'pelaksana_tipe'    => $pelaksana_tipe,
					'created_at'		=> @$tanggal
				];
			}
            Folio::insert($folioMultis);
			$order->is_done = true;
			$order->update();
			Flashy::info('Order berhasil diproses');
		}

		return redirect()->back();
	}

	public function insertBillingPerItem($id, $tarifId)
	{
		$order = HistoriOrderLab::find($id);
		if (!$order) return redirect()->back()->with('error', 'Order tidak ditemukan');

		$reg = Registrasi::find($order->registrasi_id);
		$tarifs = json_decode($order->tarif_id);
		$dokter = explode(",", Poli::where('id', 25)->pluck('dokter_id')->first());

		$semuaPunyaIsDone = collect($tarifs)->every(function($item) {
			return property_exists($item, 'is_done');
		});

		$tanggal = now();
		$folioMultis = [];

		foreach ($tarifs as $item) {
			if ($semuaPunyaIsDone && $item->tarif_id != $tarifId) continue;

			$tarif = Tarif::find($item->tarif_id);
			if (!$tarif) continue;

			$pelaksana_tipe = (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') ? 'TG' : 'TA';
			$cito = !empty($item->cito) ? 'cyto' : null;
			$totals = !empty($item->cito) ? ((150 / 100) * $tarif->total) : $tarif->total;

			$folioMultis[] = [
				'registrasi_id' => $reg->id,
				'poli_id' => 25,
				'lunas' => 'N',
				'namatarif' => $tarif->nama,
				'tarif_id' => $tarif->id,
				'cara_bayar_id' => $reg->bayar,
				'jenis' => $tarif->jenis,
				'poli_tipe' => 'L',
				'cyto' => $cito,
				'total' => $totals,
				'jenis_pasien' => $reg->jenis_pasien,
				'harus_bayar' => 1,
				'verif_kasa_user' => 'tarif_new',
				'pasien_id' => $reg->pasien_id,
				'dokter_id' => $reg->pasien_id,
				'user_id' => Auth::id(),
				'mapping_biaya_id' => $tarif->mapping_biaya_id,
				'dpjp' => $reg->pasien_id,
				'dokter_pelaksana' => @$dokter[0],
				'perawat' => Auth::user()->pegawai->id,
				'pelaksana_tipe' => $pelaksana_tipe,
				'created_at' => $tanggal,
			];

			if ($semuaPunyaIsDone) $item->is_done = true;
		}

		if ($semuaPunyaIsDone) {
			$order->tarif_id = json_encode($tarifs);
		}

		$order->is_done = true;
		$order->save();

		Folio::insert($folioMultis);
		Flashy::success('Order berhasil diproses');

		return redirect()->back();
	}

	public function tindakanIRJByTanggal(Request $request) {

		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		if(!empty($request->keyword)){
		    request()->validate(['keyword' => 'required']);
			$data['registrasi'] = Registrasi::leftJoin('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
								->with(['pasien', 'poli', 'dokter_umum', 'bayars', 'folioLab'])
								->where('registrasis.status_reg', 'like', 'J%')
								->where('pasiens.no_rm', $request->keyword)
								->orWhere('pasiens.nama', 'LIKE', "%$request->keyword%")
								->select([
									'registrasis.id',
									'registrasis.pasien_id',
									'registrasis.poli_id',
									'registrasis.dokter_id',
									'registrasis.bayar',
									'registrasis.tipe_jkn',
									'registrasis.no_sep',
									'registrasis.created_at',
								])
								->orderBy('registrasis.id','DESC')
								->limit(5)
								->get();
			// $data['poli'] = Poli::whereIn('politype',['J','L'])->pluck('nama', 'id');

			return view('laboratorium.tindakanIRJ', $data)->with('no', 1);
		}


		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']);
		// $tgb = valid_date($request['tgb']) . ' 23:59:59';

		$data['registrasi'] = Registrasi::with(['pasien', 'poli', 'dokter_umum', 'bayars', 'folioLab'])
			->where('status_reg', 'like', 'J%')
			->whereDate('created_at', $tga)
			->orderBy('id','DESC')
			->select([
				'id',
				'pasien_id',
				'poli_id',
				'dokter_id',
				'bayar',
				'tipe_jkn',
				'no_sep',
				'created_at',
			])
			->get();
		// dd($data['registrasi']);
		// $data['poli'] = Poli::whereIn('politype',['J','L'])->pluck('nama', 'id');
		
		return view('laboratorium.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRD() {
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		// $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		// $data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'G1', 'G2', 'I2', 'I3'])->where('created_at', 'LIKE', date('Y-m-d') . '%')->orderBy('id','DESC')->get();
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['G1', 'G2', 'G3'])->whereDate('created_at', Carbon::today())->orderBy('id','DESC')->get();
		// $data['registrasi'] = [];
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'G%')
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratorium.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRDByTanggal(Request $request) {

		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		if(!empty($request->keyword)){
		    request()->validate(['keyword' => 'required']);
			$data['registrasi'] = Registrasi::leftJoin('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
				->with(['pasien', 'poli', 'dokter_umum', 'bayars', 'folioLab', 'kondisiAkhir'])
				->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
				->where('pasiens.no_rm', $request->keyword)
				->orWhere('pasiens.nama', 'LIKE', "%$request->keyword%")
				->orderBy('registrasis.id','DESC')
				->select([
					'registrasis.id',
					'registrasis.pasien_id',
					'registrasis.poli_id',
					'registrasis.dokter_id',
					'registrasis.bayar',
					'registrasis.tipe_jkn',
					'registrasis.no_sep',
					'registrasis.kondisi_akhir_pasien',
					'registrasis.created_at',
				])
				->limit(5)
				->get();
			// $data['poli'] = Poli::whereIn('politype',['J','L'])->pluck('nama', 'id');

			return view('laboratorium.tindakanIRD', $data)->with('no', 1);
		}




		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']);

		// $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		$data['registrasi'] = Registrasi::with(['pasien', 'poli', 'dokter_umum', 'bayars', 'folioLab', 'kondisiAkhir'])
			->whereIn('status_reg', ['G1', 'G2', 'G3', 'I1', 'I2', 'I3'])
			->whereDate('created_at', $tga)
			->orderBy('id','DESC')
			->select([
				'id',
				'pasien_id',
				'poli_id',
				'dokter_id',
				'bayar',
				'tipe_jkn',
				'no_sep',
				'kondisi_akhir_pasien',
				'created_at',
			])
			->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where('folios.poli_tipe', 'L')
		// 		->where('registrasis.status_reg', 'like', 'G%')
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratorium.tindakanIRD', $data)->with('no', 1);
	}
	public function registered() {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		// $data['registrasi'] = Orderlab::with('hasillab', 'folios')
		// 	->with(['hasillab', 'registrasi', 'registrasi.pasien', 'registrasi.dokter_umum', 'registrasi.poli', 'registrasi.bayars'])
		// 	->where('poli_id', '!=', 43)
		// 	->where('created_at', 'LIKE', date('Y-m-d') . '%')
		// 	->orderBy('id','DESC')
		// 	->get();
		$data['registrasi'] = [];
		return view('laboratorium.registered', $data)->with('no', 1);
	}

	public function dataRegistered(Request $req){
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');

		if($req->filled('keyword')){
			$d = Orderlab::leftJoin('registrasis', 'registrasis.id', '=','order_lab.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->where(function ($query) use($req){
					$query->where('pasiens.no_rm', $req->keyword)
						->orWhere('pasiens.nama', 'LIKE', "%$req->keyword%");
				})
				->with(['hasillab', 'registrasi', 'registrasi.pasien', 'registrasi.dokter_umum', 'registrasi.poli', 'registrasi.bayars'])
				->where('order_lab.poli_id', '!=', 43)
				->orderBy('order_lab.id','DESC')
				->select([
					'order_lab.id',
					'order_lab.registrasi_id',
					'order_lab.created_at'
				])
				->get();
		}else{
			$d = Orderlab::leftJoin('registrasis', 'registrasis.id', '=','order_lab.registrasi_id')
			->with(['hasillab', 'registrasi', 'registrasi.pasien', 'registrasi.dokter_umum', 'registrasi.poli', 'registrasi.bayars'])
			->where('order_lab.poli_id', '!=', 43)
			->whereDate('order_lab.created_at', date('Y-m-d'))
			->orderBy('order_lab.id','DESC')
			->select([
				'order_lab.id',
				'order_lab.registrasi_id',
				'order_lab.created_at'
			])
			->get();
		}

		return DataTables::of($d)
			->addColumn('nama', function ($d){
				return @$d->registrasi->pasien->nama;
			})
			->addColumn('no_rm', function ($d){
				return @$d->registrasi->pasien->no_rm;
			})
			->addColumn('dokter', function ($d){
				return @$d->registrasi->dokter_umum->nama;
			})
			->addColumn('poli', function ($d){
				return @$d->registrasi->poli->nama;
			})
			->addColumn('tglMasuk', function ($d){
				return date('d-m-Y H:i', strtotime(@$d->created_at));
			})
			->addColumn('caraBayar', function ($d){
				return @$d->registrasi->bayars->carabayar;
			})
			->addColumn('cetakLab', function ($d){
				return '<a href="'.url('laboratorium/cetakTindakanLab/'. $d->id .'/'.convertUnit(@$d->registrasi->status_reg).'/'.@$d->registrasi->id).'" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>';
			})
			->addColumn('billing', function ($d){
				$linkRegistered = '<a href="'.url('laboratorium/registered-tindakan/'. $d->id .'/'.@$d->registrasi->id . '/' . @$d->registrasi->pasien->id).'" target="_blank" class="btn btn-info btn-sm btn-flat"><i class="fa fa-eye"></i></a>';

				return $linkRegistered;
			})
			->addColumn('hasilLab', function ($d){
				if($d->hasillab){
					return '<a href="'.url('cetak-lis-pdf/'. @$d->hasillab->no_lab . '/'.  @$d->registrasi->id).'" target="_blank" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i>'.$d->hasillab->no_lab.'</a>';
				}else{
					return '-';
				}
			})
			->rawColumns(['cetakLab', 'billing', 'hasilLab'])
			->addIndexColumn()
			->make(true);
	}

	public function registeredByTanggal(Request $request) {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		
		request()->validate(['keyword' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		// $tga = valid_date($request['tga']) . ' 00:00:00';
		// $tgb = valid_date($request['tgb']) . ' 23:59:59';
		$data['registrasi'] = Orderlab::leftJoin('registrasis', 'registrasis.id', '=','order_lab.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('pasiens.no_rm', $request->keyword)
			->orWhere('pasiens.nama', 'LIKE', "%$request->keyword%")
			->with(['hasillab', 'registrasi', 'registrasi.pasien', 'registrasi.dokter_umum', 'registrasi.poli', 'registrasi.bayars'])
			->where('order_lab.poli_id', '!=', 43)
			->orderBy('order_lab.id','DESC')
			->select([
				'order_lab.id',
				'order_lab.registrasi_id',
				'order_lab.created_at'
			])
			->limit(5)
			->get();
		return view('laboratorium.registered', $data)->with('no', 1);
	}

	public function tindakanIRNA() {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::with([
			'pasien', 
			'bayars', 
			'rawat_inap',
			'rawat_inap.kamar',
			'rawat_inap.dokter_ahli',
			'kondisiAkhir',
			'folioLab',
			])
			->where('registrasis.status_reg', 'I2')
			->orderBy('id','DESC')
			->select([
				'id',
				'pasien_id',
				'bayar',
				'tipe_jkn',
				'no_sep',
				'kondisi_akhir_pasien',
				'created_at',
			])
			->limit(50)
			->get();
		$data['roleUser'] = Auth::user()->role()->first()->name;
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where(['folios.poli_tipe' => 'L', 'registrasis.status_reg' => 'I2'])
		// 		->where('folios.created_at', 'like',  date('Y-m-d') . '%')
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		return view('laboratorium.tindakanIRNA', $data)->with('no', 1);
	}

	public function tindakanIRNAByTanggal(Request $request) {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		session()->forget(['dokter', 'pelaksana', 'perawat']);

		// if(!empty($request->keyword)){
		request()->validate(['keyword' => 'required']);
		$data['registrasi'] = Registrasi::leftJoin('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->whereIn('status_reg', ['I1', 'I2', 'I3'])
			->where('pasiens.no_rm', $request->keyword)
			->orWhere('pasiens.nama', 'LIKE', "%$request->keyword%")
			->orderBy('registrasis.id','DESC')
			->select([
				'registrasis.id',
				'registrasis.pasien_id',
				'registrasis.poli_id',
				'registrasis.dokter_id',
				'registrasis.bayar',
				'registrasis.tipe_jkn',
				'registrasis.no_sep',
				'registrasis.kondisi_akhir_pasien',
				'registrasis.created_at',
			])
			->get();

		$data['roleUser'] = Auth::user()->role()->first()->name;

		return view('laboratorium.tindakanIRNA', $data)->with('no', 1);
		// }


		// request()->validate(['tga' => 'required']);
		
		// $tga = valid_date($request['tga']) . ' 00:00:00';
		// $tgb = valid_date($request['tgb']) . ' 23:59:59';

		// $data['registrasi'] = Registrasi::where('status_reg', 'like', 'I%')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->orderBy('id','DESC')->get();
		// $data['registrasi'] = Folio::rightJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
		// 		->where(['folios.poli_tipe' => 'L', 'registrasis.status_reg' => 'I2'])
		// 		->whereBetween('folios.created_at', [$tga, $tgb])
		// 		->selectRaw('folios.registrasi_id, registrasis.pasien_id, registrasis.created_at, registrasis.dokter_id, registrasis.poli_id, registrasis.bayar, registrasis.tipe_jkn, registrasis.id')
		// 		->groupBy('folios.registrasi_id')
		// 		->get();
		// return view('laboratorium.tindakanIRNA', $data)->with('no', 1);
	}

	// Insert kunjungan -> order Lab -> save tindakan -> submit LICA
	public function kirimLis(Request $request) {
		// request()->validate(['tarif_id' => 'required']);
		$reg = Registrasi::find($request->registrasi_id);

		// if ($request->irna == true) {
		// 	$folio = Folio::where('registrasi_id', $reg->id)
		// 	->where('jenis', 'TI')
		// 	->where('poli_tipe', 'L')
		// 	->whereNull('order_lab_id')
		// 	//->whereIn('folios.poli_id', [16, 30])
		// 	->get();
		// } else {
			// $folio = Folio::where(['registrasi_id' =>  $reg->id])->where('poli_tipe', 'L')
			// ->whereNull('order_lab_id')
			// ->where('jenis', '!=' ,'TI')
			// ->get();
		
		if ($request->has('order_lab_id')) {
			$folio = Folio::where(['order_lab_id' =>  $request->order_lab_id])->get();
		} else {
			$folio = Folio::where(['registrasi_id' =>  $reg->id])->where('poli_tipe', 'L')->whereNull('order_lab_id')->get();
		}

		// }
		// dd($folio);
		session(['dokter' => $request['dokter_id'], 'pelaksana' => $request['pelaksana'], 'analis_lab' => $request['analis_lab']]);
		$test = [];
		$jenis  = $reg;
		$no_order = date('YmdHis') . hexdec(uniqid());
		$notelp = $reg->pasien->nohp ? $reg->pasien->nohp : $reg->pasien->notlp; 
		
		$request->poli_id = $reg->poli_id;
		if(substr($jenis->status_reg, 0, 1) == 'J') {
			$no = 'LABRJ';
			@$code = @baca_data_poli($request->poli_id)->general_code;
			if(!$code){
				@$code = @baca_data_poli($jenis->poli_id)->general_code;
				
			}
			$poli = @baca_poli($request->poli_id);
		} elseif (substr($jenis->status_reg, 0, 1) == 'I') {
			$no = 'LABRI';
			
				
			// }
			@$code = Kelompokkelas::where('id',@$reg->rawat_inap->kelompokkelas_id)->first()->general_code;
			@$poli = Kelompokkelas::where('id',@$reg->rawat_inap->kelompokkelas_id)->first()->kelompok;

		} else {
			$no = 'LABRD';
			$code = @baca_data_poli($jenis->poli_id)->general_code;
			$poli = @baca_poli($request->poli_id);
		}

		// INSERT KE LOG
		$for_log = [
			"demografi"=> [
				"no_rkm_medis"=> $reg->pasien->no_rm,
				"nama_pasien"=> $reg->pasien->nama,
				"tgl_lahir"=> $reg->pasien->tgllahir,
				"jk"=> $reg->pasien->kelamin,
				"alamat"=> $reg->pasien->alamat,
				"no_telp"=> $notelp
			],
			"transaksi"=>[
				"no_order"=> $no_order,
				"tgl_permintaan"=> date('Y-m-d'),
				"jam_permintaan"=> date('H:i:s'),
				"kode_pembayaran"=> @baca_data_carabayar($request->cara_bayar_id)->general_code,
				// "kode_pembayaran"=> 'K-0014',
				// "pembayaran"=> 'BPJS',
				"pembayaran"=> @baca_carabayar($request->cara_bayar_id),
				"kode_ruangan"=> @$code,
				// "kode_ruangan"=> '35',
				"kelas"=> @baca_data_poli(@$request->poli_id)->kelas,
				"ruangan"=> @$poli, 
				// "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
				"kode_jenis"=> @cek_kode_jenis_lis($reg->status_reg),
				"jenis"=> @cek_jenis_lis($reg->status_reg), 
				"kode_dokter"=> @baca_general_dokter($request->dokter_id),
				"dokter"=> @baca_dokter($request->dokter_id),
				"note"=> $request->pesan
			]
		]; 
		$testing = [];
		foreach ($folio as $key => $f) {
			$f->analis_lab = Auth::user()->pegawai->id;
			$f->update();

			// dd($f->tarif_id);
			$get_id_lica = Tarif::where('id', $f->tarif_id)->first()->lica_id;
			// dd($get_id_lica);
			$master_lica = MasterLicas::where('id',$get_id_lica)->first();
			// dd($master_lica);
			if($master_lica){
				$testing[] = [
					'id' => '',
					'test_id' => $master_lica->id,
					'kode_jenis_tes'=> $master_lica->general_code,
					'test_name'=> $master_lica->name,
				];
			} 
		}

		$for_log['tes'] = $testing;
			// dd($js);
		$logs = new LisLog();
		$logs->request = json_encode($for_log,JSON_PRETTY_PRINT);
		$logs->user_id = @Auth::user()->id;
		$logs->registrasi_id = $reg->id;
		$logs->save();
		// INSERT KE LOG
		
		DB::beginTransaction();
        // try{

			// Insert Kunjungan
			$kl = new HistorikunjunganLAB();
			$kl->registrasi_id = $request->registrasi_id;
			$kl->pasien_id = $request->pasien_id;
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

			// Simpan Order Lab
			if (!$request->has('order_lab_id')) {
				$order_lab = $this->simpanOrderLab($kl->registrasi_id,$kl->pasien_asal,$kl->poli_id);
			}

			// Save tindakan & submit lica
			$js = [
				"demografi"=> [
					"no_rkm_medis"=> $reg->pasien->no_rm,
					"nama_pasien"=> $reg->pasien->nama,
					"tgl_lahir"=> $reg->pasien->tgllahir,
					"jk"=> $reg->pasien->kelamin,
					"alamat"=> $reg->pasien->alamat,
					"no_telp"=> $notelp
				],
				"transaksi"=>[
					"no_order"=> $no_order,
					"tgl_permintaan"=> date('Y-m-d'),
					"jam_permintaan"=> date('H:i:s'),
					"kode_pembayaran"=> @baca_data_carabayar($request->cara_bayar_id)->general_code,
					// "kode_pembayaran"=> 'K-0014',
					// "pembayaran"=> 'BPJS',
					"pembayaran"=> @baca_carabayar($request->cara_bayar_id),
					"kode_ruangan"=> @$code,
					// "kode_ruangan"=> '35',
					"kelas"=> @baca_data_poli(@$request->poli_id)->kelas,
					"ruangan"=> @$poli, 
					// "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
					"kode_jenis"=> @cek_kode_jenis_lis($reg->status_reg),
					"jenis"=> @cek_jenis_lis($reg->status_reg), 
					"kode_dokter"=> @baca_general_dokter($request->dokter_id),
					"dokter"=> @baca_dokter($request->dokter_id),
					"note"=> $request->pesan
				]
			]; 

			foreach ($folio as $key => $f) {
				$f->analis_lab = Auth::user()->pegawai->id;
				$f->update();

				// dd($f->tarif_id);
				$get_id_lica = Tarif::where('id', $f->tarif_id)->first()->lica_id;
				// dd($get_id_lica);
				$master_lica = MasterLicas::where('id',$get_id_lica)->first();
				// dd($master_lica);
				if($master_lica){
					$test[] = [
						'id' => '',
						'test_id' => $master_lica->id,
						'kode_jenis_tes'=> $master_lica->general_code,
						'test_name'=> $master_lica->name,
					];
				}
				
				if (!$request->has('order_lab_id')) {

					$f->order_lab_id = $order_lab->id;
					$f->save();

				}
					// $kode   = $i;
					// $tarif  = Tarif::where('id',$kode)->first();
					// if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
					// 	$pelaksana_tipe = 'TG';
					// } else {
					// 	$pelaksana_tipe = 'TA';
					// }
	
					
					// if ($request['cyto'] != null) {
					// 	$cyto = $tarif->total / 2;
			
					// } else {
					// 	$cyto = 0;
					// }
	
				//   $fol = FolioMulti::create([
				// 		'registrasi_id'    => $f->registrasi_id,
				// 		'order_lab_id'	   => $order_lab->id,
				// 		'poli_id'          => $f->poli_id,
				// 		'lunas'            => 'N',
				// 		'namatarif'        => $f->namatarif,
				// 		'dijamin'          => $f->dijamin,
				// 		'tarif_id'         => $f->tarif_id,
				// 		'cara_bayar_id'    => $f->cara_bayar_id,
				// 		'jenis'            => $f->jenis,
				// 		'poli_tipe'        => $f->poli_tipe,
				// 		'cyto'        	   => $f->cyto,
				// 		'total'            => $f->total,
				// 		'jenis_pasien'     => $f->jenis_pasien,
				// 		'pasien_id'        => $f->pasien_id,
				// 		'dokter_id'        => $f->dokter_id,
				// 		'user_id'          => Auth::user()->id,
				// 		'mapping_biaya_id' => $f->mapping_biaya_id,
				// 		'dpjp'             => $f->dpjp,
				// 		'dokter_pelaksana' => $f->dokter_pelaksana,
				// 		'perawat'          => $f->analis_lab,
				// 		'pelaksana_tipe'   => $f->pelaksana_tipe,
				// 	]);

			}

			if (!$request->has('order_lab_id')) {
				$lab = new Hasillab();
				$lab->no_lab = $no_order;
				$lab->order_lab_id = $order_lab->id;
				$lab->registrasi_id = $reg->id;
				$lab->pasien_id = $request['pasien_id'];
				$lab->dokter_id = $request['dokter_id'];
				$lab->penanggungjawab = $request['dokter_lab'];
				$lab->tgl_pemeriksaan = valid_date($request['tanggal']);
				$lab->tgl_bahanditerima = date('Y-m-d');
				$lab->jam = $request['jam'];
				$lab->jamkeluar = $request['jamkeluar'];
				$lab->sample = $request['jenissample'];
				$lab->tgl_hasilselesai = date('Y-m-d');
				$lab->tgl_cetak = date('Y-m-d');
				$lab->user_id = Auth::user()->id;
			} else {
				$lab = Hasillab::where('order_lab_id', $request->order_lab_id)->first();
				$lab->no_lab = $no_order;
			}

	
			if (!$request->has('order_lab_id')) {
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
			}
			session()->forget('jenis');
			
			$js['tes'] = $test;
			// dd($js);
			$lab->json = json_encode($js,JSON_PRETTY_PRINT);
			
			$lab->save();
			
			// DB::commit();
			$curl_observation = curl_init();

			curl_setopt_array($curl_observation, array(
			CURLOPT_URL => config('app.url_lis') . '/insert_patient',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($js,JSON_PRETTY_PRINT),
			CURLOPT_HTTPHEADER => array(
			  'x-api-key:  licaapi',
			  'Content-Type: application/json'
			),
			));
			$response_observasi = curl_exec($curl_observation);
			// dd($response_observasi);
			$resp = json_decode($response_observasi);
	

			if (empty($lab->json)) {
				Flashy::success('Data JSON Kosong');
				return redirect()->back();
			}

			if (isset($resp->error)) {
				if ($resp->error->status_code == 200) {
					Flashy::success('Berhasil kirim ke LIS');
					$reg->is_order_lab = false;
					$reg->update();
					DB::commit();
					return redirect()->back();
				} else {
					Flashy::success($resp->error->message);
					// DB::rollback();
					
					return redirect()->back();
				}
			}
			Flashy::success('Gagal dalam menginput tindakan ke LIS');
			return redirect()->back();
		// }catch(Exception $e){
        //   DB::rollback();
        //   Flashy::danger('Gagal Input data pemeriksaan lab');
        //   return redirect()->back();
        // } 
		
	}

	public function kirimLisLangsung(Request $request) {
		
		$reg    = Registrasi::find($request['registrasi_id']);
		$folio = Folio::where(['registrasi_id' =>  $reg->id])->where('poli_tipe', 'L')->whereNull('order_lab_id')->get();
		$request['dokter_id'] = $request['dokter_lab'];
		$reg->dokter_id = $request['dokter_id'];
		$reg->save();
		session(['dokter' => $request['dokter_id'], 'pelaksana' => $request['pelaksana'], 'analis_lab' => $request['analis_lab']]);
		$test = [];
		$pasien = Pasien::where('id', $reg->pasien_id)->first();
		$jenis  = $reg;
		$no_order = date('YmdHis') . hexdec(uniqid());

		if(substr($jenis->status_reg, 0, 1) == 'J') {
			$no = 'LABRJ';
			$code = baca_data_poli($request->poli_id)->general_code;
			if(!$code){
				$code = baca_data_poli($jenis->poli_id)->general_code;
				
			}
			$poli = baca_poli($request->poli_id);
		} elseif (substr($jenis->status_reg, 0, 1) == 'I') {
			$no = 'LABRI';
			$code = $request->ruangan_inap;
			$poli = $request->kelompok;
		} elseif (substr($jenis->status_reg, 0, 1) == 'G'){
			$no = 'LABRD';
			$code = baca_data_poli($request->poli_id)->general_code;
			$poli = baca_poli($request->poli_id);
		}
		else {
			$no = 'LAB';
			$code = baca_data_poli($request->poli_id)->general_code;
			$poli = baca_poli($request->poli_id);
		}
		// dd($code,$poli);
		DB::beginTransaction();
        try{
			
			// Insert Kunjungan
			$kl = new HistorikunjunganLAB();
			$kl->registrasi_id = $request->registrasi_id;
			$kl->pasien_id = $request->pasien_id;
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

			// Simpan Order Lab
			$order_lab = $this->simpanOrderLab($kl->registrasi_id,$kl->pasien_asal,$kl->poli_id);

			$js = [
				"demografi"=> [
				"no_rkm_medis"=> $pasien->no_rm,
				"nama_pasien"=> $pasien->nama,
				"tgl_lahir"=> $pasien->tgllahir,
				"jk"=> $pasien->kelamin,
				"alamat"=> $pasien->alamat,
				"no_telp"=> '-'
				],
				"transaksi"=>[
				"no_order"=> $no_order,
				"tgl_permintaan"=> date('Y-m-d'),
				"jam_permintaan"=> date('H:i:s'),
				"kode_pembayaran"=> baca_data_carabayar($reg->bayar)->general_code,
				// "kode_pembayaran"=> 'K-0014',
				// "pembayaran"=> 'BPJS',
				"pembayaran"=> baca_carabayar($reg->bayar),
				"kode_ruangan"=> $code,
				// "kode_ruangan"=> '35',
				"kelas"=> baca_data_poli($request->poli_id)->kelas,
				"ruangan"=> $poli, 
				// "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
				"kode_jenis"=> cek_kode_jenis_lis($reg->status_reg),
				"jenis"=> cek_jenis_lis($reg->status_reg), 
				"kode_dokter"=> baca_general_dokter($request->dokter_lab),
				"dokter"=> baca_dokter($request->dokter_lab),
				"note"=> $request->pesan
				]

			]; 
			// dd($js);
			// dd($request['tarif_id']);
			foreach ($folio as $f) {
				
				$get_id_lica = Tarif::where('id',$f->tarif_id)->first()->lica_id;
				// dd($get_id_lica);
				$master_lica = MasterLicas::where('id',$get_id_lica)->first();
				if($master_lica){
					$test[] = [
						'id' => '',
						'test_id' => $master_lica->id,
						'kode_jenis_tes'=> $master_lica->general_code,
						'test_name'=> $master_lica->name,
						// 'cito'=> $request->cito[$detail_id[0]],
					];

				}

				$f->order_lab_id = $order_lab->id;
				$f->save();
				
			// 	$kode   = $f->tarif_id;
			// 	$tarif  = Tarif::where('id',$kode)->first();
			// 	if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
			// 		$pelaksana_tipe = 'TG';
			// 	} else {
			// 		$pelaksana_tipe = 'TA';
			// 	}

				
				
			   
			//   FolioMulti::create([
			// 		'registrasi_id'    => $request['registrasi_id'],
			// 		'poli_id'          => $request['poli_id'],
			// 		'lunas'            => 'N',
			// 		'namatarif'        => $tarif->nama,
			// 		'dijamin'          => $request['dijamin'],
			// 		'tarif_id'         => $tarif->id,
			// 		'cara_bayar_id'    => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
			// 		'jenis'            => 'TA',
			// 		'poli_tipe'        => 'L',
			// 		'total'            => ($tarif->total * $request['jumlah']),
			// 		'jenis_pasien'     => $request['jenis'],
			// 		'pasien_id'        => $request['pasien_id'],
			// 		'dokter_id'        => $request['dokter_id'],
			// 		'user_id'          => Auth::user()->id,
			// 		'mapping_biaya_id' => $tarif->mapping_biaya_id,
			// 		'dpjp'             => $request['dokter_id'],
			// 		'dokter_pelaksana' => $request['pelaksana'],
			// 		'dokter_lab'       => $request['dokter_lab'],
			// 		'analis_lab'       => $request['analis_lab'],
			// 		'perawat'          => $request['perawat'],
			// 		'pelaksana_tipe'   => $pelaksana_tipe
			// 	]);
	
			}

			// dd($request->all());
			$lab = new Hasillab();
			$lab->no_lab = $no_order;
			$lab->order_lab_id = $order_lab->id;
			$lab->registrasi_id = $reg->id;
			$lab->pasien_id = $request['pasien_id'];
			$lab->dokter_id = $request['dokter_id'];
			$lab->penanggungjawab = $request['dokter_lab'];
			$lab->tgl_pemeriksaan = date('Y-m-d');
			$lab->tgl_bahanditerima = date('Y-m-d');
			$lab->jam = $request['jam'];
			$lab->jamkeluar = $request['jamkeluar'];
			$lab->sample = $request['jenissample'];
			$lab->tgl_hasilselesai = date('Y-m-d');
			$lab->tgl_cetak = date('Y-m-d');
			$lab->user_id = Auth::user()->id;
			// dd($lab);
	
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
			
			
			$js['tes'] = $test;
			$lab->json = json_encode($js,JSON_PRETTY_PRINT);
			$curl_observation = curl_init();
  
			curl_setopt_array($curl_observation, array(
			CURLOPT_URL => config('app.url_lis') . '/insert_patient',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($js,JSON_PRETTY_PRINT),
			CURLOPT_HTTPHEADER => array(
			  'x-api-key:  licaapi',
			  'Content-Type: application/json'
			),
			));
			$response_observasi = curl_exec($curl_observation);

			$resp = json_decode($response_observasi);
		
			if (isset($resp->error)) {
				if ($resp->error->status_code == 200) {
					Flashy::success('Berhasil kirim ke LIS');
					$lab->save();
					DB::commit();
					return redirect()->back();
				} else {
					Flashy::success($resp->error->message);
					DB::rollback();
					return redirect()->back();
				}
			}

			Flashy::success('Gagal dalam menginput tindakan ke LIS');
			return redirect()->back();
		}catch(Exception $e){
          DB::rollback();
          
          Flashy::danger('Gagal Input data pemeriksaan lab');
          return redirect()->back();
        } 
		
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

		// $this->simpanOrderLab($kl->registrasi_id,$kl->pasien_asal,$kl->poli_id);

		if (substr($reg->status_reg, 0, 1) == 'I') {
			return redirect('laboratorium/entry-tindakan-irna-new/' . $registrasi_id . '/' . $pasien_id);
		} else {
			return redirect('laboratorium/entry-tindakan-irj-new/' . $registrasi_id . '/' . $pasien_id);
		}
	}

	
	public function getResult($id_lis)
	{
		dd($this->hitungPemeriksaan($id_lis));
	}

	public function entryTindakanIRNA($idreg, $idpasien) {
		
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		//$data['folio'] = Folio::where('registrasi_id', $idreg)->whereIn('poli_id', [16,30])->get();
		$data['folio'] = Folio::where('registrasi_id', $idreg)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			//->whereIn('folios.poli_id', [16, 30])
			->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			//->whereIn('folios.poli_id', [16, 30])
			->where('lunas', 'N')->sum('total');
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');
		$data['lab'] = (Orderlab::where('registrasi_id', $idreg)->where('poli_id', '!=', 43)->first()) ? Orderlab::where('registrasi_id', $idreg)->where('poli_id', '!=', 43)->first()->pemeriksaan : NULL;
		$data['perawat'] = Pegawai::where('kategori_pegawai', 2)->where('poli_id', 6)->pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');


		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));


		$jenis = $data['jenis']->status_reg;
		//dd($jenis );
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			// $this->simpanOrderLab($data['jenis']->id,'TG',$data['jenis']->poli_id);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
			// $this->simpanOrderLab($data['jenis']->id,'TA',$data['jenis']->poli_id);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			
			session(['jenis' => 'TI']);
			// $this->simpanOrderLab($data['jenis']->id,'TI',$data['jenis']->poli_id);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TI')->where('total', '<>', 0)->get();
			$data['opt_poli'] = Poli::where('politype', 'L')->get();
		}

		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id',3)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		// return $data;die;
		return view('laboratorium.entryTindakanLaboratoriumIRNA', $data)->with('no', 1);
	}

	public static function simpanOrderLab($registrasi_id,$jenis,$poli_id){
		// $lab = OrderLab::where('registrasi_id',$registrasi_id)->first();
		// if(!$lab){
		// 	$lab = new Orderlab();
		// }
		$lab = new Orderlab();
		$lab->jenis = $jenis;
		$lab->poli_id = $poli_id;
		$lab->pemeriksaan = 'Order Lab';
		$lab->registrasi_id = $registrasi_id;
		$lab->user_id = Auth::user()->id;
		$lab->save();
		return $lab;
	}




	public function entryTindakanIRNAnew($idreg, $idpasien) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		//$data['folio'] = Folio::where('registrasi_id', $idreg)->whereIn('poli_id', [16,30])->get();
		$data['folio']  = Folio
            ::where(['registrasi_id' =>  $idreg])
            ->where('poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->whereNull('folios.order_lab_id')
			->where('folios.jenis', 'TI')
            ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
            ->leftJoin('pegawais as dokter_lab', 'dokter_lab.id', '=', 'folios.dokter_pelaksana')
            ->leftJoin('pegawais as analis_lab', 'analis_lab.id', '=', 'folios.perawat')
            ->leftJoin('users', 'users.id', '=', 'folios.user_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'folios.cara_bayar_id')
            ->select('folios.*', 'dokter_lab.nama as dokter_lab', 'analis_lab.nama as analis_lab', 'users.name as petugas', 'carabayars.carabayar', 'tarifs.total as tarif_total', 'tarifs.lica_id')
            ->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::find($idreg);
		$data['ranap'] = Rawatinap::where('registrasi_id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->where('poli_id', '!=', 43)
			->whereNull('order_lab_id')
			//->whereIn('folios.poli_id', [16, 30])
			->where('lunas', 'N')->sum('total');
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');
		$data['lab'] = (Orderlab::where('registrasi_id', $idreg)->where('poli_id', '!=', 43)->first()) ? Orderlab::where('registrasi_id', $idreg)->where('poli_id', '!=', 43)->first()->pemeriksaan : NULL;
		$data['perawat'] = Pegawai::where('kategori_pegawai', 2)->where('poli_id', 6)->pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');


		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$andySudjadiIds = Pegawai::where('nama', 'LIKE', '%Andy Sudjadi%')->pluck('id')->toArray();
		$data['dokter_poli'] = array_merge($data['dokter_poli'], $andySudjadiIds);		
		$data['dokter_poli'] = array_unique($data['dokter_poli']);
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));

		$data['histori'] =  Orderlab::with('hasillab', 'folio')->where('registrasi_id', $idreg)->orderBy('id','DESC')->where('poli_id', '!=', 43)->get();

		$jenis = $data['jenis']->status_reg;
		//dd($jenis );
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			// $this->simpanOrderLab($data['jenis']->id,'TG',$data['jenis']->poli_id);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TG')->groupBy('nama','total')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
			// $this->simpanOrderLab($data['jenis']->id,'TA',$data['jenis']->poli_id);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->groupBy('nama','total')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			// dd("test");
			session(['jenis' => 'TI']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TI')->groupBy('nama','total')->where('total', '<>', 0)->get();
			$data['opt_poli'] = Poli::where('politype', 'L')->get();
		}
		// $data['tindakan'] = Tarif::groupBy('nama','total')->where('total', '<>', 0)->get();
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id',3)->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		// return $data;die;
		return view('laboratorium.entryTindakanLaboratoriumIRNAnew', $data)->with('no', 1);
	}

	public function entryTindakanIRJ($idreg, $idpasien) {
	    //dd("test");
		$data['folio'] = Folio::where(['registrasi_id' =>  $idreg])->where('poli_tipe', 'L')->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)->where('lunas', 'N')->where('poli_tipe', 'L')->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->where('poli_id', 6)->pluck('nama', 'id');
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');
		$data['perawat'] = Pegawai::where('kategori_pegawai', 2)->where('poli_id', 6)->pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');

		
		// explode data
	    $data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));
		


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
		
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		return view('laboratorium.entryTindakanLaboratorium', $data)->with('no', 1);
	}

	// LABOR NEW 
	public function entryTindakanIRJNew($idreg, $idpasien) {

		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

	    //dd("test");
		$data['folio']  = Folio
            ::where(['registrasi_id' =>  $idreg])
            ->where('poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->whereNull('folios.order_lab_id')
            ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
            ->leftJoin('pegawais as dokter_lab', 'dokter_lab.id', '=', 'folios.dokter_pelaksana')
            ->leftJoin('pegawais as analis_lab', 'analis_lab.id', '=', 'folios.perawat')
            ->leftJoin('users', 'users.id', '=', 'folios.user_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'folios.cara_bayar_id')
            ->select('folios.*', 'dokter_lab.nama as dokter_lab', 'analis_lab.nama as analis_lab', 'users.name as petugas', 'carabayars.carabayar', 'tarifs.total as tarif_total', 'tarifs.lica_id')
            ->get();
		// $data['folio'] = Folio::where(['registrasi_id' =>  $idreg])->where('poli_tipe', 'L')->whereNull('order_lab_id')->get();
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $idreg)->where('lunas', 'N')->where('poli_id', '!=', 43)->whereNull('order_lab_id')->where('poli_tipe', 'L')->sum('total');
		// $data['tagihan'] = Folio::where('registrasi_id', $idreg)->where('lunas', 'N')->where('poli_id', '!=', 43)->where('poli_tipe', 'L')->sum('total');
        $dokterArr      = Pegawai::where('kategori_pegawai', 1)->where('poli_id', 6)->pluck('nama', 'id');
		$data['dokter'] = Pegawai::whereIn('id', $dokterArr)->get();

        // $dokterPoliArr = Poli::where('id', 25)->pluck('dokter_id');
		// $data['dokters_poli']   = Pegawai::whereIn('id', explode(',',$dokterPoliArr[0]))->get();
        // $perawatPoliArr = Poli::where('id', 25)->pluck('perawat_id');
		// $data['perawats_poli']  = Pegawai::whereIn('id', explode(',',$perawatPoliArr[0]))->get();

        // $perawatArr = Pegawai::where('kategori_pegawai', 2)->where('poli_id', 6)->pluck('nama', 'id');
		// $data['perawat'] = Pegawai::whereIn('id', $perawatArr)->get();
		$jenis = $data['jenis']->status_reg;
		
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');

		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		
		$andySudjadiIds = Pegawai::where('nama', 'LIKE', '%Andy Sudjadi%')->pluck('id')->toArray();
		$data['dokter_poli'] = array_merge($data['dokter_poli'], $andySudjadiIds);		
		$data['dokter_poli'] = array_unique($data['dokter_poli']);
		
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));

		$data['kat_tarif']  = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar']  = Carabayar::pluck('carabayar', 'id');
        $data['user']       = Auth::user();
		
		// update waktu start lab
		if(!$data['jenis']->lab_start){
			$data['jenis']->lab_start = date('Y-m-d H:i:s');

			if(!$data['jenis']->lab_finish){
				$min = 1;
				$max = 5;
				@$newtimestamp = strtotime(date('Y-m-d H:i:s').' + '.rand($min,$max).' minute');
				@$finished = date('Y-m-d H:i:s', $newtimestamp);
				$data['jenis']->lab_finish = @$finished;
			}
			$data['jenis']->save();
		}
		
		$data['histori'] =  Orderlab
            ::leftJoin('registrasis', 'registrasis.id', '=', 'order_lab.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->leftJoin('hasillabs', 'hasillabs.order_lab_id', '=', 'order_lab.id')
            ->leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'folios.dokter_pelaksana')
            ->groupBy('registrasis.id')
            ->where('order_lab.poli_id', '!=', 43)
            ->where('order_lab.registrasi_id', $idreg)
            ->orderBy('order_lab.id','DESC')
            ->select('order_lab.id','pasiens.nama', 'pasiens.no_rm', 'registrasis.status_reg', 'registrasis.id as registrasi_id','order_lab.created_at', 'carabayars.carabayar', 'folios.dokter_pelaksana', 'hasillabs.no_lab')
            ->get();

		
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
			->where('tarifs.jenis', '=', 'TG')
			// ->where('tarifs.nama', 'like', '%' . $term . '%')
			->whereNotNull('tarifs.lica_id')
			->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
			// ->limit(50)
			->groupBy('tarifs.total')
			->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
			->where('tarifs.jenis', '=', 'TA')
			->whereNotNull('tarifs.lica_id')
			->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')
			// ->limit(50)
			->groupBy('tarifs.total')
			->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			$data['tindakan'] = Tarif::where('jenis', '=', 'TI')->where('total', '<>', 0)->get();
		}
		// $data['tindakan'] = Tarif::groupBy('nama','total')->where('total', '<>', 0)->get();
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		return view('laboratorium.entryTindakanLaboratoriumNew', $data)->with('no', 1);
	}


	public function hapusHistoriOrderLab($reg_id, $id)
	{
		$reg = Registrasi::find($reg_id);
		HistoriOrderLab::find($id)->delete();
		Flashy::success('Data Berhasil Dihapus.');

		return redirect()->back();
	}


	public function cariPasien()
	{	
		return view('laboratorium.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		
		session()->forget(['dokter', 'pelaksana', 'perawat']);

		$rm = $request['no_rm'];
		$nama = $request['nama'];
		$tgllahir = $request['tgl_lahir'];

		if (isset($rm)) {
			$pasien = Pasien::where('no_rm', $rm)->pluck('id');
		}
		if (isset($nama)) {
			$pasien = Pasien::where('nama', 'LIKE', '%'.$nama . '%')->pluck('id');
		}
		if (isset($tgllahir)) {
			$pasien = Pasien::where('tgllahir', 'LIKE', $tgllahir . '%')->pluck('id');
		}

		if (empty($pasien)) {
			$data['registrasi'] = array();
		} else {
			$data['registrasi'] = Registrasi::whereIn('pasien_id', $pasien)
				->with(['pasien', 'dokter_umum', 'rawat_inap', 'bayars'])
			// ->where('registrasis.created_at',  'LIKE', valid_date($request['tgl']) . '%')
				->orderBy('id', 'DESC')
				->select('id', 'pasien_id', 'dokter_id', 'bayar', 'tipe_jkn', 'status_reg', 'created_at')
				->limit(30)
				->get();
		}

		$data['roleUser'] = Auth::user()->role()->first()->name;
		
		
		return view('laboratorium.cari-pasien', $data)->with('no', 1);

	}








	public function saveTindakan(Request $request) {
		request()->validate(['tarif_id' => 'required']);
		session(['dokter' => $request['dokter_id'], 'pelaksana' => $request['pelaksana'], 'analis_lab' => $request['analis_lab']]);
		// dd($request['tarif_id']);
		$test = [];
		// dd($request->all());
		$reg    = Registrasi::find($request['registrasi_id']);
		$jenis  = $reg;
		// dd($reg->pasien);
		$no_order = date('YmdHis') . hexdec(uniqid());
		$notelp = $reg->pasien->nohp ? $reg->pasien->nohp : $reg->pasien->notlp; 
		
		// if(!$request->poli_id){
		$request->poli_id = $reg->poli_id;
		// }
		if(substr($jenis->status_reg, 0, 1) == 'J') {
			$no = 'LABRJ';
			@$code = @baca_data_poli($request->poli_id)->general_code;
			if(!$code){
				@$code = @baca_data_poli($jenis->poli_id)->general_code;
				
			}
			$poli = @baca_poli($request->poli_id);
		} elseif (substr($jenis->status_reg, 0, 1) == 'I') {
			$no = 'LABRI';
			
				
			// }
			@$code = Kelompokkelas::where('id',@$reg->rawat_inap->kelompokkelas_id)->first()->general_code;
			@$poli = Kelompokkelas::where('id',@$reg->rawat_inap->kelompokkelas_id)->first()->kelompok;

		} else {
			$no = 'LABRD';
			$code = @baca_data_poli($jenis->poli_id)->general_code;
			$poli = @baca_poli($request->poli_id);
		}
		DB::beginTransaction();
        try{
			// dd($request['tarif_id']);
			$js = [
				"demografi"=> [
				"no_rkm_medis"=> $reg->pasien->no_rm,
				"nama_pasien"=> $reg->pasien->nama,
				"tgl_lahir"=> $reg->pasien->tgllahir,
				"jk"=> $reg->pasien->kelamin,
				"alamat"=> $reg->pasien->alamat,
				"no_telp"=> $notelp
				],
				"transaksi"=>[
				"no_order"=> $no_order,
				"tgl_permintaan"=> date('Y-m-d'),
				"jam_permintaan"=> date('H:i:s'),
				"kode_pembayaran"=> @baca_data_carabayar($request->cara_bayar_id)->general_code,
				// "kode_pembayaran"=> 'K-0014',
				// "pembayaran"=> 'BPJS',
				"pembayaran"=> @baca_carabayar($request->cara_bayar_id),
				"kode_ruangan"=> @$code,
				// "kode_ruangan"=> '35',
				"kelas"=> @baca_data_poli(@$request->poli_id)->kelas,
				"ruangan"=> @$poli, 
				// "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
				"kode_jenis"=> @cek_kode_jenis_lis($reg->status_reg),
				"jenis"=> @cek_jenis_lis($reg->status_reg), 
				"kode_dokter"=> @baca_general_dokter($request->dokter_id),
				"dokter"=> @baca_dokter($request->dokter_id),
				"note"=> $request->pesan
				]

			]; 
			// dd($js);
			// dd($request['tarif_id']);
			foreach ($request['tarif_id'] as $i) {
				
				$get_id_lica = Tarif::where('id',$i)->first()->lica_id;
				
				// dd($get_id_lica);
				$master_lica = MasterLicas::where('id',$get_id_lica)->first();
				if($master_lica){
					$test[] = [
						'id' => '',
						'test_id' => $master_lica->id,
						'kode_jenis_tes'=> $master_lica->general_code,
						'test_name'=> $master_lica->name,
						// 'cito'=> $request->cito[$detail_id[0]],
					];

				}

				
				
				
				//dd($reg);
				$kode   = $i;
				$tarif  = Tarif::where('id',$kode)->first();
				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}

				
				
				if ($request['cyto'] != null) {
					$cyto = $tarif->total / 2;
		
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
					'poli_tipe'        => 'L',
					'cyto'        	   => $cyto,
					'total'            => ($tarif->total * $request['jumlah'] + $cyto),
					'jenis_pasien'     => $request['jenis'],
					'pasien_id'        => $request['pasien_id'],
					'dokter_id'        => $request['dokter_id'],
					'user_id'          => Auth::user()->id,
					'mapping_biaya_id' => $tarif->mapping_biaya_id,
					'dpjp'             => $request['dokter_id'],
					// 'dokter_pelaksana' => $request['pelaksana'],
					'verif_kasa_user'  => 'tarif_new',
					'harus_bayar' 	   => @$request['jumlah'],
					'dokter_pelaksana' => $request['dokter_lab'],
					'perawat'       => $request['analis_lab'],
					// 'perawat'          => $request['perawat'],
					'pelaksana_tipe'   => $pelaksana_tipe
				]);
	
			}
			// dd($request->all());
			$lab = new Hasillab();
			$lab->no_lab = $no_order;
			$lab->registrasi_id = $reg->id;
			$lab->pasien_id = $request['pasien_id'];
			$lab->dokter_id = $request['dokter_id'];
			$lab->penanggungjawab = $request['dokter_lab'];
			$lab->tgl_pemeriksaan = valid_date($request['tanggal']);
			$lab->tgl_bahanditerima = date('Y-m-d');
			$lab->jam = $request['jam'];
			$lab->jamkeluar = $request['jamkeluar'];
			$lab->sample = $request['jenissample'];
			$lab->tgl_hasilselesai = date('Y-m-d');
			$lab->tgl_cetak = date('Y-m-d');
			$lab->user_id = Auth::user()->id;
			// dd($lab);
	
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
			
			
			// dd($test);
			$js['tes'] = $test;
			// dd($js);
			$lab->json = json_encode($js,JSON_PRETTY_PRINT);
			// dd(json_encode($js,JSON_PRETTY_PRINT));
			// dd($js);
			$curl_observation = curl_init();
  
			curl_setopt_array($curl_observation, array(
			CURLOPT_URL => config('app.url_lis') . '/insert_patient',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($js,JSON_PRETTY_PRINT),
			CURLOPT_HTTPHEADER => array(
			  'x-api-key:  licaapi',
			  'Content-Type: application/json'
			),
			));
			$response_observasi = curl_exec($curl_observation);
			// if(!isset(json_decode(@$response_observasi)->error)){
			//   Flashy::error('Gagal Simpan, Master Test tidak ada di LIS');
			//   return redirect()->back();
			// }
			// dd($response_observasi);
			// if(!$response_observasi){
			//   Flashy::error('Gagal Simpan Ke LIS');
			//   return redirect()->back();
			// }
			$lab->save();
			DB::commit();
			Flashy::success('Berhasil input billing');
			// dd($response_observasi);
			return redirect()->back();
			// if(isset(json_decode(@$response_observasi)->error->status_code)){
			//   if(json_decode(@$response_observasi)->error->status_code == '200'){
			// 	$lab->save();
			// 	DB::commit();
			// 	Flashy::success('Sukses Input data ke LIS');
			// 	// dd($response_observasi);
			// 	return redirect()->back();
			//   }elseif(json_decode(@$response_observasi)->error->status_code == 400){
			// 	Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
			// 	return redirect()->back();
			//   }else{
			// 	Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
			// 	return redirect()->back();
	
			//   }
			// }else{
			//   Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
			//   return redirect()->back();
			// }

			// if (substr($reg->status_reg, 0, 1) == 'I') {
			// 	return redirect('laboratorium/entry-tindakan-irna/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
			// } elseif (substr($reg->status_reg, 0, 1) == 'L') {
			// 	return redirect('laboratorium/entry-transaksi-langsung/' . $request['registrasi_id']);
			// } else {
			// 	return redirect('laboratorium/entry-tindakan-irj/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
			// }

		}catch(Exception $e){
          DB::rollback();
          
          Flashy::danger('Gagal Input data pemeriksaan lab');
          return redirect()->back();
        } 
		
	}
	public function saveTindakanNew(Request $request) {
        // dd($request->all());
		$request->validate(['tarif_id' => 'required']);
		session(['dokter' => $request['dokter_id'], 'pelaksana' => $request['pelaksana'], 'analis_lab' => $request['analis_lab']]);
		$reg    = Registrasi::where('id',$request['registrasi_id'])->first();
		// update finish tindakan simpan lis
		$reg->lab_finish = date('Y-m-d H:i:s');
		$reg->save();
		
		$no_order = date('YmdHis') . hexdec(uniqid());
		$request->poli_id = $reg->poli_id;
		
		DB::beginTransaction();
        try{
            // Eager Load
            $tarifs = Tarif::whereIn('id', $request['tarif_id'])->get();
            $folioMultis = [];
			foreach ($request['tarif_id'] as $i) {
				
				$tanggal = date('Y-m-d H:i:s');
				if($request['tanggal']){
					$tanggal = date('Y-m-d', strtotime($request['tanggal']));
					$tanggal = $tanggal.' '.date('H:i:s');
				}

				$kode   = $i;
				$tarif  = $tarifs->where('id',$kode)->first();
				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}

				$cito = NULL;

				if($request['cyto'] != null && $request['eksekutif'] != null){
					Flashy::error('Cito dan Eksekutif tidak bisa dipilih secara bersamaan'); 
					return redirect()->back();
				}

				if($request['cyto'] != null){
					// CYTO
					$totals = (((150/100) * $tarif->total) * $request['jumlah']);
					// dd($totals);
					$cito = 'cyto';
				}elseif($request['eksekutif'] != null){
					$totals = (((130/100) * $tarif->total) * $request['jumlah']);
					// dd($totals);
					$cito = 'eksekutif';
				}else{
					$totals = $tarif->total * $request['jumlah'];
				}

				
				
                $folioMultis[] = [
					'registrasi_id'     => $request['registrasi_id'],
					'poli_id'           => $request['poli_id'],
					'order_lab_id'      => $request['order_lab_id'],
					'lunas'             => 'N',
					'namatarif'         => $tarif->nama,
					'dijamin'           => $request['dijamin'],
					'tarif_id'          => $tarif->id,
					'cara_bayar_id'     => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
					'jenis'             => $tarif->jenis,
					'poli_tipe'         => 'L',
					'cyto'        	    => $cito,
					'total'             => $totals,
					'jenis_pasien'      => $request['jenis'],
					'harus_bayar'      => @$request['jumlah'],
					'verif_kasa_user'      => 'tarif_new',
					'pasien_id'         => $request['pasien_id'],
					'dokter_id'         => $request['dokter_id'],
					'user_id'           => Auth::user()->id,
					'mapping_biaya_id'  => $tarif->mapping_biaya_id,
					'dpjp'              => $request['dokter_id'],
					'dokter_pelaksana'  => $request['dokter_lab'],
					'perawat'           => $request['analis_lab'],
					'pelaksana_tipe'    => $pelaksana_tipe,
					'created_at'		=> @$tanggal
				];
			}
            Folio::insert($folioMultis);
			// $cito = NULL;
			// if ($request['cyto'] != null) {
			// 	$totals = (((150/100) * $tarif->total) * $request['jumlah']);
			// 	// dd($totals);
			// 	$cito = 'cyto';
	
			// } else {
			// 	$totals = $tarif->total * $request['jumlah'];
			// }
				// dd($request['registrasi_id']);
			// $fol = new Folio();
			// $fol->registrasi_id    = $request['registrasi_id'];
			// $fol->poli_id          = $request['poli_id'];
			// $fol->order_lab_id     = $request['order_lab_id']; //jika insert tindakan dari pasien terbilling
			// $fol->lunas            = 'N';
			// $fol->namatarif        = $tarif->nama;
			// $fol->dijamin          = $request['dijamin'];
			// $fol->tarif_id         = $tarif->id;
			// $fol->cara_bayar_id    = (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar;
			// $fol->jenis            = $tarif->jenis;
			// $fol->poli_tipe        = 'L';
			// $fol->cyto        	   = $cito;
			// $fol->subsidi		   = $request['jumlah']; //jumlah tindakan
			// $fol->total            = $totals;
			// $fol->jenis_pasien     = $request['jenis'];
			// $fol->pasien_id        = $request['pasien_id'];
			// $fol->dokter_id        = $request['dokter_id'];
			// $fol->user_id          = Auth::user()->id;
			// $fol->mapping_biaya_id = $tarif->mapping_biaya_id;
			// $fol->dpjp             = $request['dokter_id'];
			// $fol->dokter_pelaksana = $request['dokter_lab'];
			// $fol->perawat       = $request['analis_lab'];
			// $fol->pelaksana_tipe   = $pelaksana_tipe;
			// $fol->save();
			// }
			// dd($request->all());

			if (!$request->has('order_lab_id')) {
				$lab = new Hasillab();
				$lab->no_lab = $no_order;
				$lab->registrasi_id = $reg->id;
				$lab->pasien_id = $request['pasien_id'];
				$lab->dokter_id = $request['dokter_id'];
				$lab->penanggungjawab = $request['dokter_lab'];
				$lab->tgl_pemeriksaan = valid_date($request['tanggal']);
				$lab->tgl_bahanditerima = date('Y-m-d');
				$lab->jam = $request['jam'];
				$lab->jamkeluar = $request['jamkeluar'];
				$lab->sample = $request['jenissample'];
				$lab->tgl_hasilselesai = date('Y-m-d');
				$lab->tgl_cetak = date('Y-m-d');
				$lab->user_id = Auth::user()->id;
				// dd($lab);
		
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
				  
				$lab->save();
			}

			DB::commit();
			Flashy::success('Berhasil input billing'); 
			return redirect()->back();
			 

		}catch(Exception $e){
          DB::rollback();
          
          Flashy::danger('Gagal Input data pemeriksaan lab');
          return redirect()->back();
        } 
		
	}

	public function saveTindakanLangsung(Request $request) {
		request()->validate(['tarif_id' => 'required']);
		$request['dokter_id'] = $request['dokter_lab'];
		session(['dokter' => $request['dokter_id'], 'pelaksana' => $request['pelaksana'], 'analis_lab' => $request['analis_lab']]);
		// dd($request['tarif_id']);
		$test = [];
		// dd($request->all());
		$reg    = Registrasi::find($request['registrasi_id']);
		// dd($reg);
		$pasien = Pasien::where('id', $reg->pasien_id)->first();
		// dd($pasien);
		$jenis  = $reg;
		// dd($reg->pasien);
		$no_order = date('YmdHis') . hexdec(uniqid());
		// $notelp = $reg->pasien->nohp ? $reg->pasien->nohp : $reg->pasien->notlp; 
		
		
		// $request->poli_id = $reg->poli_id;
		if(substr($jenis->status_reg, 0, 1) == 'J') {
			$no = 'LABRJ';
			$code = baca_data_poli($request->poli_id)->general_code;
			if(!$code){
				$code = baca_data_poli($jenis->poli_id)->general_code;
				
			}
			$poli = baca_poli($request->poli_id);
		} elseif (substr($jenis->status_reg, 0, 1) == 'I') {
			$no = 'LABRI';
			$code = $request->ruangan_inap;
			$poli = $request->kelompok;
		} elseif (substr($jenis->status_reg, 0, 1) == 'G'){
			$no = 'LABRD';
			$code = baca_data_poli($request->poli_id)->general_code;
			$poli = baca_poli($request->poli_id);
		}
		else {
			$no = 'LAB';
			$code = baca_data_poli($request->poli_id)->general_code;
			$poli = baca_poli($request->poli_id);
		}
		// dd($code,$poli);
		DB::beginTransaction();
        try{
			// $js = [
			// 	"demografi"=> [
			// 	"no_rkm_medis"=> $pasien->no_rm,
			// 	"nama_pasien"=> $pasien->nama,
			// 	"tgl_lahir"=> $pasien->tgllahir,
			// 	"jk"=> $pasien->kelamin,
			// 	"alamat"=> $pasien->alamat,
			// 	"no_telp"=> '-'
			// 	],
			// 	"transaksi"=>[
			// 	"no_order"=> $no_order,
			// 	"tgl_permintaan"=> date('Y-m-d'),
			// 	"jam_permintaan"=> date('H:i:s'),
			// 	"kode_pembayaran"=> baca_data_carabayar($reg->bayar)->general_code,
			// 	// "kode_pembayaran"=> 'K-0014',
			// 	// "pembayaran"=> 'BPJS',
			// 	"pembayaran"=> baca_carabayar($reg->bayar),
			// 	"kode_ruangan"=> $code,
			// 	// "kode_ruangan"=> '35',
			// 	"kelas"=> baca_data_poli($request->poli_id)->kelas,
			// 	"ruangan"=> $poli, 
			// 	// "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
			// 	"kode_jenis"=> cek_kode_jenis_lis($reg->status_reg),
			// 	"jenis"=> cek_jenis_lis($reg->status_reg), 
			// 	"kode_dokter"=> baca_general_dokter($request->dokter_lab),
			// 	"dokter"=> baca_dokter($request->dokter_lab),
			// 	"note"=> $request->pesan
			// 	]

			// ]; 
			// dd($js);
			// dd($request['tarif_id']);
			foreach ($request['tarif_id'] as $i) {
				
				// $get_id_lica = Tarif::where('id',$i)->first()->lica_id;
				// // dd($get_id_lica);
				// $master_lica = MasterLicas::where('id',$get_id_lica)->first();
				// if($master_lica){
				// 	$test[] = [
				// 		'id' => '',
				// 		'test_id' => $master_lica->id,
				// 		'kode_jenis_tes'=> $master_lica->general_code,
				// 		'test_name'=> $master_lica->name,
				// 		// 'cito'=> $request->cito[$detail_id[0]],
				// 	];

				// }
				

				
				
				
				//dd($reg);
				$kode   = $i;
				$tarif  = Tarif::where('id',$kode)->first();
				if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}

				
				
			   
			  FolioMulti::create([
					'registrasi_id'    => $request['registrasi_id'],
					'poli_id'          => $request['poli_id'],
					'lunas'            => 'N',
					'namatarif'        => $tarif->nama,
					'dijamin'          => $request['dijamin'],
					'tarif_id'         => $tarif->id,
					// 'cara_bayar_id'    => (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar,
					'cara_bayar_id'    => $request['bayar'],
					'jenis'            => 'TA',
					'poli_tipe'        => 'L',
					'total'            => ($tarif->total * $request['jumlah']),
					'jenis_pasien'     => $request['jenis'],
					'pasien_id'        => $request['pasien_id'],
					'dokter_id'        => $request['dokter_id'],
					'user_id'          => Auth::user()->id,
					'verif_kasa_user'          => 'tarif_new',
					'mapping_biaya_id' => $tarif->mapping_biaya_id,
					'dpjp'             => $request['dokter_id'],
					'dokter_pelaksana' => $request['pelaksana'],
					'dokter_lab'       => $request['dokter_lab'],
					'analis_lab'       => $request['analis_lab'],
					'perawat'          => $request['perawat'],
					'pelaksana_tipe'   => $pelaksana_tipe
				]);
	
			}
			// dd($request->all());
			$lab = new Hasillab();
			$lab->no_lab = $no_order;
			$lab->registrasi_id = $reg->id;
			$lab->pasien_id = $request['pasien_id'];
			$lab->dokter_id = $request['dokter_id'];
			$lab->penanggungjawab = $request['dokter_lab'];
			$lab->tgl_pemeriksaan = date('Y-m-d');
			$lab->tgl_bahanditerima = date('Y-m-d');
			$lab->jam = $request['jam'];
			$lab->jamkeluar = $request['jamkeluar'];
			$lab->sample = $request['jenissample'];
			$lab->tgl_hasilselesai = date('Y-m-d');
			$lab->tgl_cetak = date('Y-m-d');
			$lab->user_id = Auth::user()->id;
			// dd($lab);
	
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
			
			
			// dd($test);
			// $js['tes'] = $test;
			// // dd($js);
			// $lab->json = json_encode($js,JSON_PRETTY_PRINT);
			// // dd(json_encode($js,JSON_PRETTY_PRINT));
			// // dd($js);
			// $curl_observation = curl_init();
  
			// curl_setopt_array($curl_observation, array(
			// CURLOPT_URL => config('app.url_lis') . '/insert_patient',
			// CURLOPT_RETURNTRANSFER => true,
			// CURLOPT_ENCODING => '',
			// CURLOPT_MAXREDIRS => 10,
			// CURLOPT_TIMEOUT => 0,
			// CURLOPT_FOLLOWLOCATION => true,
			// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// CURLOPT_CUSTOMREQUEST => 'POST',
			// CURLOPT_POSTFIELDS => json_encode($js,JSON_PRETTY_PRINT),
			// CURLOPT_HTTPHEADER => array(
			//   'x-api-key:  licaapi',
			//   'Content-Type: application/json'
			// ),
			// ));
			// $response_observasi = curl_exec($curl_observation);
			// if(!isset(json_decode(@$response_observasi)->error)){
			//   Flashy::error('Gagal Simpan, Master Test tidak ada di LIS');
			//   return redirect()->back();
			// }
			// dd($response_observasi);
			// if(!$response_observasi){
			//   Flashy::error('Gagal Simpan Ke LIS');
			//   return redirect()->back();
			// }
			// if(isset(json_decode(@$response_observasi)->error->status_code)){
			//   if(json_decode(@$response_observasi)->error->status_code == '200'){
				$lab->save();
				DB::commit();
				Flashy::success('Sukses Input data ');
				// dd($response_observasi);
				return redirect()->back();
			// //   }elseif(json_decode(@$response_observasi)->error->status_code == 400){
			// // 	Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
			// // 	return redirect()->back();
			// //   }else{
			// // 	Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
			// // 	return redirect()->back();
	
			// //   }
			// }else{
			//   Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
			//   return redirect()->back();
			// }

			// if (substr($reg->status_reg, 0, 1) == 'I') {
			// 	return redirect('laboratorium/entry-tindakan-irna/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
			// } elseif (substr($reg->status_reg, 0, 1) == 'L') {
			// 	return redirect('laboratorium/entry-transaksi-langsung/' . $request['registrasi_id']);
			// } else {
			// 	return redirect('laboratorium/entry-tindakan-irj/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
			// }

		}catch(Exception $e){
          DB::rollback();
          
          Flashy::danger('Gagal Input data pemeriksaan lab');
          return redirect()->back();
        } 
		
	}

	public function hapusTindakanIRJ($id, $idreg, $pasien_id) {
		// dd( Auth::user()->hasRole(['administrator']) );
		if (Auth::user()->hasRole(['supervisor', 'laboratorium', 'administrator'])) {
			// Folio::where('id', $id)->where('lunas', 'N')->delete();
			$folio = Folio::find($id);

			if (@$folio->lunas == 'N') {
				$folio->delete();
			}
		}
		// $reg = Registrasi::find($idreg);
		// if (substr($reg->status_reg, 0, 1) == 'I') {
		// 	return redirect('laboratorium/entry-tindakan-irna/' . $idreg . '/' . $pasien_id);
		// } elseif (substr($reg->status_reg, 0, 1) == 'L') {
		// 	return redirect('laboratorium/entry-transaksi-langsung/' . $reg->id);
		// } else {
			return redirect()->back();
			// return redirect('laboratorium/entry-tindakan-irj/' . $idreg . '/' . $pasien_id);
		// }
	}

	public static function cetakRincianLab($unit, $registrasi_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->where('poli_id', '!=', 43)->orderBy('created_at')->get();
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->orderBy('created_at')->get();
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
	public static function cetakRincianLabPerTgl($unit, $registrasi_id,$tgl) {

		// dd($tgl);
		$tgl = str_replace("_"," ",$tgl);
		$tgl = substr($tgl,0,-3);
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->where('created_at','like',$tgl.'%')->orderBy('created_at')->get();
		if(count($data['tindakan']) == 0){
			Flashy::error('Tindakan belum ada atau tanggal ini');  
      		return redirect()->back();
		}
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->where('created_at','like',$tgl.'%')->orderBy('created_at')->get();
		$data['folio'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->where('created_at','like',$tgl.'%')->first();
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

	public function cetakTindakanLab($unit, $registrasi_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->whereNull('order_lab_id')->orderBy('created_at')->get();
		$data['sisaTagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->whereNull('order_lab_id')->orderBy('created_at')->get();
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

	public function cetakTindakanLabPerSesi($order_lab_id, $unit, $registrasi_id) {
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['tindakan'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'L'])->where('order_lab_id', $order_lab_id)->orderBy('created_at')->get();
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

	public function registeredTindakan($order_lab_id, $registrasi_id, $idpasien){
		// $data['folio'] = Folio::where(['registrasi_id' =>  $registrasi_id])->where('order_lab_id', $order_lab_id)->get();
		$data['folio']  = Folio::where(['registrasi_id' => $registrasi_id])
			->where('poli_tipe', 'L')
			->where('folios.order_lab_id', $order_lab_id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
            ->leftJoin('pegawais as dokter_lab', 'dokter_lab.id', '=', 'folios.dokter_pelaksana')
            ->leftJoin('pegawais as analis_lab', 'analis_lab.id', '=', 'folios.perawat')
            ->leftJoin('users', 'users.id', '=', 'folios.user_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'folios.cara_bayar_id')
            ->select('folios.*', 'dokter_lab.nama as dokter_lab', 'analis_lab.nama as analis_lab', 'users.name as petugas', 'carabayars.carabayar', 'tarifs.total as tarif_total', 'tarifs.lica_id')
            ->get();

		$data['order_lab'] = Orderlab::find($order_lab_id);
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $registrasi_id;
		$data['jenis'] = Registrasi::where('id', '=', $registrasi_id)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->where('poli_tipe', 'L')->where('order_lab_id', $order_lab_id)->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->where('poli_id', 6)->pluck('nama', 'id');
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');
		// $data['perawat'] = Pegawai::where('kategori_pegawai', 2)->where('poli_id', 6)->pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');

		
		// explode data
	    $data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$andySudjadiIds = Pegawai::where('nama', 'LIKE', '%Andy Sudjadi%')->pluck('id')->toArray();
		$data['dokter_poli'] = array_merge($data['dokter_poli'], $andySudjadiIds);		
		$data['dokter_poli'] = array_unique($data['dokter_poli']);
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));
		


		$jenis = $data['jenis']->status_reg;
		if (substr($jenis, 0, 1) == 'G') {
			session(['jenis' => 'TG']);
			// $data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('kategoriheader_id', 3)->groupBy('nama','total')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			session(['jenis' => 'TA']);
			// $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('kategoriheader_id', 3)->groupBy('nama','total')->where('total', '<>', 0)->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			// $data['tindakan'] = Tarif::where('jenis', '=', 'TI')->where('kategoriheader_id', 3)->groupBy('nama','total')->where('total', '<>', 0)->get();
			$data['opt_poli'] = Poli::where('politype', 'L')->get();
		} else {
			// $data['tindakan'] = Tarif::where('kategoriheader_id', 3)->groupBy('nama','total')->where('total', '<>', 0)->get();
		}
		$data['tindakan'] = Tarif::groupBy('nama','total')->where('total', '<>', 0)->get();

		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['registeredTindakan'] = true;
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		return view('laboratorium.entryTindakanLaboratoriumNew', $data)->with('no', 1);
	}

	public function lap_kunjungan() {
		$data['kunjungan'] = NULL;
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		$data['crb'] = 0;
		return view('laboratorium.lap_kunjungan', $data);
	}

	public function lap_kunjungan_by_request(Request $request) {
        ini_set('memory_limit', '8G');
		$request->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = $request['tga'] ? valid_date($request['tga']) . ' 00:00:00' : NULL;
		$tgb = $request['tgb'] ? valid_date($request['tgb']) . ' 23:59:59' : NULL;
		$data['cara_bayar'] = Carabayar::all();
		$data['crb'] = 0;
		$data['pasien_asal'] = $request['pasien_asal'];

		$tindakans = Folio::where('folios.poli_tipe', 'L')->whereBetween('folios.created_at', [$tga, $tgb]);
        if (!empty($request->pasien_asal)) {
            $tindakans->where('folios.jenis', '=', $request->pasien_asal);
        }
        if ($request->cara_bayar != 0) {
            $tindakans->where('folios.cara_bayar_id', '=', $request->cara_bayar);
        }
        $tindakans = $tindakans
            ->leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->leftJoin('pegawais as dpjp', 'dpjp.id', '=', 'registrasis.dokter_id')
            ->select('pasiens.nama', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.alamat', 'carabayars.carabayar', 'pasiens.kelamin', 'folios.jenis', 'dpjp.nama as dpjp', 'folios.namatarif', 'folios.created_at', 'registrasis.id as registrasi_id')
            ->get();

        $data['jumlahTindakan']     = $tindakans->count();
        $data['jumlahPengunjung']   = $tindakans->groupBy('registrasi_id')->count();
        $data['kunjungan']          = [];
		foreach($tindakans->groupBy('registrasi_id') as $folios){
			$data['kunjungan'][] = [
				'nama_pasien'   => @$folios->first()->nama,
				'no_rm'         => @$folios->first()->no_rm,
				'umur'          => @$folios->first()->tgllahir ? hitung_umur(@$folios->first()->tgllahir) : '-',
				'alamat'        => @$folios->first()->alamat,
				'cara_bayar'    => @$folios->first()->carabayar,
				'kelamin'       => @$folios->first()->kelamin,
				'jenis'         => @$folios->first()->jenis,
				'dokter'        => @$folios->first()->dpjp,
				'nama_tarif'    => @$folios->pluck('namatarif')->toArray(),
				'tanggal_kunjungan' => Carbon::parse($folios->first()->created_at)->format('d-m-Y H:i:s'),
			];
		}
		if ($request['view']) {
			return view('laboratorium.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
			$judul = 'Labor';
			if ($request['pasien_asal'] == 'TI') {
				$judul = 'IRNA';
			} elseif ($request['pasien_asal'] == 'TA') {
				$judul = 'IRJ';
			} elseif ($request['pasien_asal'] == 'TG') {
				$judul = 'IGD';
			}
			Excel::create('Lap' . @$judul, function ($excel) use ($data, $judul, $tga, $tgb) {
				$excel->getDefaultStyle()
				->getAlignment()
				->applyFromArray(array(
					'horizontal'   	=> \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'     	=> \PHPExcel_Style_Alignment::VERTICAL_TOP,
					'wrap'	 	=> TRUE
				));
				$excel->sheet('Lap' . $judul, function ($sheet) use ($data, $tga, $tgb) {
					$sheet->loadView('laboratorium.excel.lap_kunjungan',$data);
				});
			})->download('xlsx');
			// Excel::create('Lap' . @$judul, function ($excel) use ($datareg, $judul, $tga, $tgb) {
			// 	$excel->setTitle('Lap' . $judul)
			// 		->setCreator('Digihealth')
			// 		->setCompany('Digihealth')
			// 		->setDescription('Lap' . $judul);
			// 	$excel->sheet('Lap' . $judul, function ($sheet) use ($datareg, $tga, $tgb) {
			// 		$row = 3;
			// 		$no = 1;

			// 		$sheet->row(1, [
			// 			'',
			// 			'Total : '. count($datareg),
			// 			'Laporan Jumlah Pemeriksaan Laboratorium',
			// 			'Periode :'. @$tga .'Sampai'. @$tgb,
			// 		]);

			// 		$sheet->row(2, [
			// 			'No',
			// 			'Nama',
			// 			'No. RM',
			// 			'alamat',
			// 			'cara bayar',
			// 			'Umur',
			// 			'L/P',
			// 			'Dokter',
			// 			'Pemeriksaan',
			// 			'Tanggal Kunjungan',
			// 		]);
			// 		foreach ($datareg as $key => $d) {
			// 			$nama_tarif = implode("\n", $d['nama_tarif']);
			// 			$sheet->row(++$row, [
			// 				$no++,
			// 				$d['nama_pasien'] ? $d['nama_pasien'] : 'Pasien dari luar',
			// 				$d['no_rm'] ? $d['no_rm'] : NULL,
			// 				@$d['alamat'],
			// 				$d['cara_bayar'],
			// 				$d['umur'],
			// 				$d['kelamin'],
			// 				$d['dokter'],
			// 				$nama_tarif,
			// 				$d['tanggal_kunjungan'],
			// 			]);
			// 		}
			// 	});
			// })->export('xlsx');
		}
	}
	public function lap_kunjunganCB() {
		$data['kunjungan'] = NULL;
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		$data['crb'] = 0;
		return view('laboratorium.lap_kunjunganCB', $data);
	}

	public function lap_kunjunganCB_by_request(Request $request) {
        ini_set('memory_limit', '8G');
		$request->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = $request['tga'] ? valid_date($request['tga']) . ' 00:00:00' : NULL;
		$tgb = $request['tgb'] ? valid_date($request['tgb']) . ' 23:59:59' : NULL;
		$data['cara_bayar'] = Carabayar::whereIn('id',['1','2'])->get();
		$data['tipe_jkn'] = Jenisjkn::all();
		$data['crb'] = 0;
		$data['pasien_asal'] = $request['pasien_asal'];

		$tindakans = Folio::where('folios.poli_tipe', 'L')->whereBetween('folios.created_at', [$tga, $tgb]);
        $tindakans = $tindakans->leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')->get();

        $data['jumlahPengunjung']   = 
        $data['kunjungan']          = [];
		
		foreach ($data['cara_bayar'] as $cb){
			$total = $tindakans->where('cara_bayar_id',$cb->id)->groupBy('registrasi_id')->count();
			$data['kunjungan'][] = [
				'carabayar' => baca_carabayar($cb->id),
				'total'=>$total,
				'jenisjkn' => [],
				'lainnya'=>''
			];
		}

		$totals = 0;
		$total_jkn = $tindakans->where('cara_bayar_id','1')->groupBy('registrasi_id')->count();
		foreach($data['tipe_jkn'] as $j){
			$tipejkn = $tindakans->where('tipe_jkn',$j->nama)->groupBy('registrasi_id')->count();
			// $no_tipe = $tindakans->where('bayar','1')->groupBy('registrasi_id')->count();
			$data['kunjungan'][0]['lainnya'] = $tipejkn;
			$data['kunjungan'][0]['jenisjkn'][] = [
				'tipe_jkn'=>$j->nama,
				'total'=>$tipejkn,
			];
			$data['kunjungan'][0]['lainnya']  = $total_jkn-($totals+=$tipejkn);
		}
		// dd($data['kunjungan']);
		
		if ($request['view']) {
			return view('laboratorium.lap_kunjunganCB', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
			$judul = 'Labor';
			if ($request['pasien_asal'] == 'TI') {
				$judul = 'IRNA';
			} elseif ($request['pasien_asal'] == 'TA') {
				$judul = 'IRJ';
			} elseif ($request['pasien_asal'] == 'TG') {
				$judul = 'IGD';
			}
			Excel::create('Lap' . @$judul, function ($excel) use ($datareg, $judul, $tga, $tgb) {
				$excel->setTitle('Lap' . $judul)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap' . $judul);
				$excel->sheet('Lap' . $judul, function ($sheet) use ($datareg, $tga, $tgb) {
					$row = 3;
					$no = 1;

					$sheet->row(1, [
						'',
						'Total : '. count($datareg),
						'Laporan Jumlah Pemeriksaan Laboratorium',
						'Periode :'. @$tga .'Sampai'. @$tgb,
					]);

					$sheet->row(2, [
						'No',
						'Nama',
						'No. RM',
						'alamat',
						'cara bayar',
						'Umur',
						'L/P',
						'Dokter',
						'Pemeriksaan',
						'Tanggal Kunjungan',
					]);
					foreach ($datareg as $key => $d) {
						$nama_tarif = implode("\n", $d['nama_tarif']);
						$sheet->row(++$row, [
							$no++,
							$d['nama_pasien'] ? $d['nama_pasien'] : 'Pasien dari luar',
							$d['no_rm'] ? $d['no_rm'] : NULL,
							@$d['alamat'],
							$d['cara_bayar'],
							$d['umur'],
							$d['kelamin'],
							$d['dokter'],
							$nama_tarif,
							$d['tanggal_kunjungan'],
						]);
					}
				});
			})->export('xlsx');
		}
	}
	public function lap_respontime() {
		$data['kunjungan'] = NULL;
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		$data['crb'] = 0;
		return view('laboratorium.lap_respontime', $data);
	}

	public function lap_respontime_by_request(Request $request) {
        ini_set('memory_limit', '8G');
		$request->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = $request['tga'] ? valid_date($request['tga']) . ' 00:00:00' : NULL;
		$tgb = $request['tgb'] ? valid_date($request['tgb']) . ' 23:59:59' : NULL;
		$data['cara_bayar'] = Carabayar::all();
		$data['crb'] = 0;
		$data['pasien_asal'] = $request['pasien_asal'];

		$tindakans = OrderLab::whereBetween('created_at', [$tga, $tgb]);
        if (!empty($request->pasien_asal)) {
            $tindakans->where('jenis', '=', $request->pasien_asal);
        }
        // if ($request->cara_bayar != 0) {
        //     $tindakans->where('folios.cara_bayar_id', '=', $request->cara_bayar);
        // }
		

        $data['jumlahTindakan']     = $tindakans->count();
        $data['jumlahPengunjung']   = $tindakans->groupBy('registrasi_id')->count();
        $data['kunjungan']          = $tindakans->get();
		
		if ($request['view']) {
			return view('laboratorium.lap_respontime', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
			$judul = 'Labor';
			if ($request['pasien_asal'] == 'TI') {
				$judul = 'IRNA';
			} elseif ($request['pasien_asal'] == 'TA') {
				$judul = 'IRJ';
			} elseif ($request['pasien_asal'] == 'TG') {
				$judul = 'IGD';
			}
			Excel::create('Lap' . @$judul, function ($excel) use ($datareg, $judul, $tga, $tgb) {
				$excel->setTitle('Laporan Respon Time')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap' . $judul);
				$excel->sheet('Lap' . $judul, function ($sheet) use ($datareg, $tga, $tgb) {
					$row = 3;
					$no = 1;

					$sheet->row(1, [
						'',
						'Periode :'. @$tga .'Sampai'. @$tgb,
					]);

					$sheet->row(2, [
						'No',
                        'Nama',
                        'No. RM',
                        'Asal Pasien',
                        'Alamat',
                        'Cara Bayar',
                        'Mulai',
                        'Selesai',
                        'Total Pelayanan'
					]);
					foreach ($datareg as $key => $d) {
						if ($d['jenis'] == 'TI'){
							$jen = 'Rawat Inap';
						}elseif ($d['jenis'] == 'TA'){
							$jen = 'Rawat Jalan';
						}elseif ($d['jenis'] == 'TG'){
							$jen = 'Gawat Darurat';
						}

						if (@$d->registrasi->lab_start && @$d->registrasi->lab_finish) {
							$start = date_create(@$d->registrasi->lab_start);
							@$finished = @$d->registrasi->lab_finish;
							@$finish=date_create(@$d->registrasi->lab_finish);
						}elseif(@$d->registrasi->lab_start && !@$d->registrasi->lab_finish){
							@$start = date_create(@$d->registrasi->lab_start);
							$min = 1;
							$max = 5;
							@$newtimestamp = strtotime(@$d->registrasi->lab_start.' + '.rand($min,$max).' minute');
							@$finished = date('Y-m-d H:i:s', $newtimestamp);
							@$finish = date_create($finished);
						}

						if (empty(@$d->registrasi->lab_start) && empty(@$d->registrasi->lab_finish)) {
							$wkt = '<i>Tidak Terkalkulasi</i>';
						}else{
							$wkt = date_diff($start, $finish)->i.' menit';
						}
					
						$sheet->row(++$row, [
							$no++,
							@$d->registrasi->pasien->nama,
							@$d->registrasi->pasien->no_rm,
							@$jen,
							@$d->registrasi->pasien->alamat,
							@baca_carabayar(@$d->registrasi->bayar),
							@$d->registrasi->lab_start,
							@$finished,
							@$wkt,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function lap_pemeriksaan(Request $request)
	{
        
		
			@$tga = @valid_date($request['tga']);
		
			@$tgb = @valid_date($request['tgb']);
		

		$tindakanLabs = Folio::where('poli_tipe', 'L')
					->where('user_id', '!=', 851)
					->where('user_id', '!=', 871)
					->groupBy('namatarif')
					->select('namatarif')->get();

        $carabayars = Carabayar::all();
        $namatarif = 'Bilirubin Total';
		// dd($tga,$tgb);
		if(!$request['tga'] && !$request['tgb']){
			$kunjungan = [];
		}else{
			$kunjungan = Folio::whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->join('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
			->where('folios.user_id', '!=', 851)
			->where('folios.user_id', '!=', 871)
			->groupBy('folios.registrasi_id')
			->where('folios.poli_tipe', 'L');
		}
			
        $tindakan = '';
        $carabayar_id = '';
		$pelayanan = '';
        if($request->tindakan != null){
            $tindakan = $request->tindakan;
            $kunjungan->where('folios.namatarif', 'like', "%$tindakan%");
        }
        if($request->carabayar_id != null){
            $carabayar_id = $request->carabayar_id;
            $kunjungan->where('registrasis.bayar', $carabayar_id);
        }
		if($request->pelayanan != null){
            $pelayanan = $request->pelayanan;
            $kunjungan->where('folios.jenis', $pelayanan);
        }

        if($request->submit == 'TAMPILKAN'){
			// dd($kunjungan->paginate(10));
            $kunjungan = $kunjungan->paginate(10);
			foreach ($kunjungan as $k) {
				$hasilLabs = \App\Hasillab::where('registrasi_id', $k->registrasi->id )->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->get();
				$k->hasillab = @$hasilLabs;
				foreach ($k->hasillab as $hlab) {
					$resp = $this->hitungPemeriksaan($hlab->no_lab);
					$hlab->total_pemeriksaan = @$resp->total_pemeriksaan;
					$hlab->jenis_pemeriksaan = @$resp->jenis_pemeriksaan;
				}
			}
			return view('laboratorium.lap_pemeriksaan', compact('kunjungan', 'tga', 'tgb', 'tindakanLabs', 'carabayars', 'tindakan', 'carabayar_id'))->with('no', 1);
		} elseif($request->submit == 'EXCEL'){
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '8000M');
			$kunjungan = $kunjungan->get();
			// foreach ($kunjungan as $k) {
			// 	$hasilLabs = \App\Hasillab::where('registrasi_id', $k->registrasi->id )->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->get();
			// 	$k->hasillab = @$hasilLabs;
			// 	foreach ($k->hasillab as $hlab) {
			// 		$resp = $this->hitungPemeriksaan($hlab->no_lab);
			// 		$hlab->total_pemeriksaan = @$resp->total_pemeriksaan;
			// 		$hlab->jenis_pemeriksaan = @$resp->jenis_pemeriksaan;
			// 	}
			// }
            $data = compact('kunjungan', 'tga', 'tgb', 'tindakanLabs', 'carabayars', 'tindakan', 'carabayar_id');
            $title = 'Pemeriksaan Laboratorium ' . $tga . "/" . $tgb;
			$filterTindakan = "Semua";
			$filterAsalPasien = "Semua";
			$filterPenjamin = "Semua";
			// dd($kunjungan);
			// Tindakan
			if($request->tindakan != null){
				$filterTindakan = $request->tindakan;
			}
			// Penjamin
			if($request->carabayar_id != null){
				$filterPenjamin = baca_carabayar($request->carabayar_id);
			}
			// Asal Pasien
			if($request->pelayanan != null){
				if ($request->pelayanan == "TA") {
					$filterAsalPasien = "Rawat Jalan";
				} elseif ($request->pelayanan == "TG") {
					$filterAsalPasien = "Rawat Darurat";
				} elseif ($request->pelayanan == "TI") {
					$filterAsalPasien = "Rawat INAP";
				}
			}
			Excel::create($title, function ($excel) use ($data, $title, $filterTindakan, $filterPenjamin, $filterAsalPasien) {
				$excel->sheet('Pemeriksaan Laboratorium', function ($sheet) use ($data, $filterTindakan, $filterPenjamin, $filterAsalPasien) {
					$sheet->loadView('laboratorium.excel.laporan_pemeriksaan',$data);
				});
			})->download('xlsx');
           
       	}else{
			if($kunjungan){
				$kunjungan = $kunjungan->paginate(10);

			}else{
				$kunjungan = [];
			}
			return view('laboratorium.lap_pemeriksaan', compact('kunjungan', 'tga', 'tgb', 'tindakanLabs', 'carabayars', 'tindakan', 'carabayar_id'))->with('no', 1);
        }
		
	}

	private function hitungPemeriksaan($id_lis)
	{
		$licaResult = LicaResult::where('no_lab', $id_lis)->first();
		$hasil = '';
		$level_keys = array();
	
		if ($licaResult) {
		  $hasil = json_decode($licaResult->json);
	
		  foreach ($hasil as $k => $sub_array) {
			$this_level = @$sub_array->group_name ?? @$sub_array->group_test;
			$level_keys[$this_level][$k] = $sub_array;
		  }

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
			return 0;
		  }
		  $err = curl_error($curl);
		  curl_close($curl);
		  $data['response'] = '';
		  if ($err) {
			echo "cURL Error #:" . $err;
		  } else {
			$data['response'] = json_decode($response);
			$hasil = $data['response']->hasil;
		  }
	  
		  foreach ($hasil as $k => $sub_array) {
			$this_level = $sub_array->group_test;
			$level_keys[$this_level][$k] = $sub_array;
		  }
		}
	
		return (object) [
		  'total_pemeriksaan' => count($hasil),
		  'jenis_pemeriksaan' => $level_keys,
		];
	}

	public function lap_pemeriksaan_by_request(Request $req)
    {
        // dd($request->all());
        // $data['tga'] = $request['tga'] ? valid_date($request['tga']) : NULL;
		// $data['tgb'] = $request['tgb'] ? valid_date($request['tgb']) : NULL;
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga).' 00:00:00';
		$tgb				= valid_date($req->tgb).' 23:59:59';

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;
		// $data['crb']		= $req->cara_bayar;
        $namatarif = 'Bilirubin Total';
		$data['kunjungan'] = Folio::whereBetween('created_at', [$tga, $tgb])
			->where('user_id', '!=', 851)
			->where('user_id', '!=', 871)
			->where('poli_tipe', 'L')
            ->where('namatarif', 'like', "%$namatarif%")
			->paginate(100);
    
		if($req->submit == 'TAMPILKAN'){
			// dd($data);
			return view('laboratorium.lap_pemeriksaan', $data)->with('no', 1);
		} elseif($req->submit == 'EXCEL'){
            Excel::create('Pemeriksaan Laboratorium', function ($excel) use ($data) {
                // dd($data['po']);
				// Set the properties
				$excel->setTitle('Pemeriksaan Laboratorium')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Pemeriksaan Laboratorium');
				$excel->sheet('Pemeriksaan Laboratorium', function ($sheet) use ($data) {
                    // dd($data['po']);
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Tindakan',
						'Jumlah',
					]);
                    foreach($data['kunjungan'] as $st){
                        $sheet->row(++$row, [
                            $no++,
							@$st->namatarif,
							@$st->jumlahtindakan,
                        ]);
                    }
                });
			})->export('xlsx');
       	 }
	}

    public function jml_lap_pemeriksaan()
	{
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['crb']		= 0;
		$now        		= now()->day;

		// $data['kunjungan'] = Folio::where('created_at', '>=', date('Y-m-d').' 00:00:00')
		// 	// ->where('poli_id', 6)
		// 	->where('user_id', '!=', 851)
		// 	->where('user_id', '!=', 871)
		// 	->where('poli_tipe', 'L')
		// 	->selectRaw('SUM(folios.total) as total, namatarif')
		// 	->groupBy('namatarif')
		// 	->get();
		
		return view('laboratorium.jml_lap_pemeriksaan', $data)->with('no', 1);
	}
	public function jml_lap_pemeriksaan_by_request(Request $req)
    {
        // dd($request->all());
        // $data['tga'] = $request['tga'] ? valid_date($request['tga']) : NULL;
		// $data['tgb'] = $request['tgb'] ? valid_date($request['tgb']) : NULL;
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga).' 00:00:00';
		$tgb				= valid_date($req->tgb).' 23:59:59';

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;
		// $data['crb']		= $req->cara_bayar;
        
		$data['kunjungan'] = Folio::whereBetween('created_at', [$tga, $tgb])
			// ->where('poli_id', 6)
			->where('user_id', '!=', 851)
			->where('user_id', '!=', 871)
			->where('poli_tipe', 'L')
			->selectRaw('SUM(folios.total) as total, namatarif')
			->groupBy('namatarif')
			->get();							
        // $data['po'] = Po::with(['satBeli'])->whereBetween('tanggal', [$tga, $tgb])
        //                 ->where('verifikasi', 'Y')
        //                 ->get();                
             
        // dd($po);
		if($req->submit == 'TAMPILKAN'){
			// dd($data);
			return view('laboratorium.jml_lap_pemeriksaan', $data)->with('no', 1);
		} elseif($req->submit == 'EXCEL'){
            Excel::create('Pemeriksaan Laboratorium', function ($excel) use ($data) {
                // dd($data['po']);
				// Set the properties
				$excel->setTitle('Pemeriksaan Laboratorium')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Pemeriksaan Laboratorium');
				$excel->sheet('Pemeriksaan Laboratorium', function ($sheet) use ($data) {
                    // dd($data['po']);
					$row = 3;
					$no = 1;

					$sheet->row(1, [
						'',
						'Laporan Jumlah Pemeriksaan Laboratorium',
						'Periode :'. @$data['tga'] .'Sampai'. @$data['tgb'],
					]);
					$sheet->row(2, [
						'No',
						'Tindakan',
						'Jumlah Tindakan',
					]);
                    foreach($data['kunjungan'] as $st){
						$jumlah = Tarif::where('nama', '=', $st->namatarif)->first();
                        $sheet->row(++$row, [
                            $no++,
							@$st->namatarif,
							@$jumlah->total == 0 ? 0 : floor(@$st->total / @$jumlah->total),
                        ]);
                    }
                });
			})->export('xlsx');
       	 }
	}

	//TINDAKAN LANGSUNG
	// public function tindakanLangsung() {
	// 	$data = Pasienlangsung::where('created_at', 'like', date('Y-m-d') . '%')->where('politype', 'L')->get();
	// 	return view('laboratorium.transaksiLangsung', compact('data'))->with('no', 1);
	// }
	public function searchPasien(Request $request) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
		
		request()->validate(['keyword' => 'required']);
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm_lama', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();
		return view('laboratorium.pasien', compact('data', 'keyword'))->with('no', 1);
	}
	public function tindakanLangsung() {
		$data = Pasienlangsung::join('registrasis', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
		->where('pasien_langsung.created_at', 'like', date('Y-m-d') . '%')
		->where('politype', 'L')
		->where('registrasis.poli_id', 25)
		->select('registrasis.id', 'registrasis.lunas', 'pasien_langsung.*', 'registrasis.poli_id', 'registrasis.reg_id')
		->get();
		return view('laboratorium.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public function tindakanLangsungBytanggal(Request $request)
	{
		$data = Pasienlangsung::join('registrasis', 'pasien_langsung.registrasi_id', '=', 'registrasis.id')
			->where('pasien_langsung.created_at', 'like', valid_date($request['tga']) . '%')
			->where('politype', 'L')
			->where('registrasis.poli_id', 25)
			->select('registrasis.id', 'registrasis.lunas', 'pasien_langsung.*')
			->get();
		return view('laboratorium.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public function simpanTransaksiLangsungLama($id) {
		// dd("A");

		// request()->validate(['nama' => 'required', 'alamat' => 'required', 'kelamin' => 'required', 'tgllahir' => 'required']);
		
		DB::transaction(function () use ($id) {
			$pasien = Pasien::where('id',$id)->first();
			if($pasien){

				// dd($pasien);
				$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
				$reg = new Registrasi();
				$reg->pasien_id = $pasien->id;
				$reg->status_reg = 'L1';
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
				$pasiens->politype = 'L';
				$pasiens->pemeriksaan = '';
				$pasiens->user_id = Auth::user()->id;
				$pasiens->save();
				  
	
				$update = Registrasi::where('id', $reg->id)->first();
				$update->pasien_id= $pasien->id;
				$update->poli_id = 25;
				$update->save();
				// dd($update);
				// dd($pasien);
				
				
	
	
	
				$hk = new HistorikunjunganLAB();
				$hk->registrasi_id = $reg->id;
				$hk->pasien_id = $pasien->id;
				$hk->poli_id = 25;
				$hk->pasien_asal = 'TA';
				$hk->user = Auth::user()->name;
				$hk->save();
			}else{
				Flashy::error('Gagal Insert Pasien ke LAB');
				return redirect()->back();
			}
			session(['registrasi_id' => $reg->id]);
		});
		return redirect('/laboratorium/entry-transaksi-langsung/' . session('registrasi_id'));
	}

	public function simpanTransaksiLangsung(Request $request) {
		// sleep(rand(1,15));
		request()->validate(['nama' => 'required', 'alamat' => 'required', 'kelamin' => 'required', 'tgllahir' => 'required']);
		// $no = Nomorrm::count() + config('app.no_rm');
		// $no_rm = $no;
		// $cek = Pasien::where('no_rm', $no_rm)->count();
		// if ($cek > 0) {
		// 	Flashy::info('No RM baru (' . $no_rm . ') sdh ada, hubungi Admin!');
		// 	return back();
		// }

		// DB::transaction(function () use ($request) {
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = '0';
			$reg->status_reg = 'L1';
			$reg->bayar = '2';
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->user_create = Auth::user()->id;
			$reg->save();

			
			// dd($no_rm);

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
			$pasien->politype = 'L';
			$pasien->pemeriksaan = $request['pemeriksaan'];
			$pasien->user_id = Auth::user()->id;
			
			
			
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
			// dd($pasien_new);
			// Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => $no]);
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
			$update->poli_id = 25;
			$update->save();
			// dd($update);
			// dd($pasien);
			
			



			$hk = new HistorikunjunganLAB();
			$hk->registrasi_id = $reg->id;
			$hk->pasien_id = $pasien_new->id;
			$hk->poli_id = 25;
			$hk->pasien_asal = 'TA';
			$hk->user = Auth::user()->name;
			$hk->save();
			DB::commit(); 
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
		// });
		return redirect('/laboratorium/entry-transaksi-langsung/' . session('registrasi_id'));
	}

	public function tindakanCetak($registrasi_id){
		$reg = Registrasi::find($registrasi_id);
		$pasienLangsung = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$folio = Folio::where('folios.registrasi_id', $registrasi_id)
			->where('poli_id', 16)->get();
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->get();
		$sisaTagihan = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N', 'cara_bayar_id' => 2, 'poli_tipe' => 'L'])->orderBy('created_at')->get();
		return view('laboratorium.cetakLangsung', compact('pasienLangsung', 'folio', 'tindakan', 'reg', 'sisaTagihan'))->with('no', 1);
	}

	public function cetakLab($registrasi_id) {
		$pasienLangsung = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$folio = Folio::where(['folios.registrasi_id' => $registrasi_id])->where('poli_id', 16)->get();
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('folios.tarif_id', '!=', 10000)->whereIn('poli_id', [16, 30])->get();
		$reg = Registrasi::find($registrasi_id);
		return view('laboratorium.cetak', compact('pasienLangsung', 'folio', 'tindakan', 'reg'))->with('no', 1);
	}

	public function entryTindakanLangsung($registrasi_id) {
		$data['folio'] = Folio::where('folios.registrasi_id', $registrasi_id)->whereNull('order_lab_id')->get();
		$data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
		$data['reg_id'] = $registrasi_id;
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->whereNull('order_lab_id')->sum('total');
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');
		$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
		$data['jenis'] = Registrasi::find($registrasi_id);
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		session(['jenis' => 'TA']);
		// dd($data);
		// $data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['tindakan'] = Tarif::groupBy('nama','total')->where('total', '<>', 0)->get();
		$data['dokter_poli'] =  (explode(",", $data['dokters_poli'][0]));
		$andySudjadiIds = Pegawai::where('nama', 'LIKE', '%Andy Sudjadi%')->pluck('id')->toArray();
		$data['dokter_poli'] = array_merge($data['dokter_poli'], $andySudjadiIds);		
		$data['dokter_poli'] = array_unique($data['dokter_poli']);
		$data['perawat_poli'] =  (explode(",", $data['perawats_poli'][0]));

		return view('laboratorium.entryTindakanLangsung', $data)->with('no', 1);
	}

	public function laporanKinerja() {
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		return view('laboratorium.lap_kinerja', $data);
	}

	public function laporanKinerjaByRequest(Request $request) {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		$tga = $request['tglAwal'] ? valid_date($request['tglAwal']) . ' 00:00:00' : NULL;
		$tgb = $request['tglAkhir'] ? valid_date($request['tglAkhir']) . ' 23:59:59' : NULL;
		$cara_bayar = \Modules\Registrasi\Entities\Carabayar::all();
		$jenisReg = $request['pelayanan'];
		$cara_bayars = $request['bayar'];
		
		
			
		if (isset($jenisReg)) {
			if ($jenisReg == "PB") {
			// 	$data = Pasienlangsung::join('registrasis', 'pasien_langsung.id', '=', 'registrasis.id')
			// ->where('pasien_langsung.created_at', 'like', valid_date($request['tga']) . '%')
			// ->where('politype', 'L')
			// ->select('registrasis.id', 'registrasis.lunas', 'pasien_langsung.*')
			// ->get();
			$data = Folio::join('pasien_langsung', 'folios.registrasi_id', '=', 'pasien_langsung.registrasi_id')
			->where('pasien_langsung.politype', 'L')
			->where('folios.user_id', '!=', 851)
			->where('folios.user_id', '!=', 871)
			->where('folios.namatarif', 'not like', '%PRC%')
			->whereBetween('pasien_langsung.created_at', [$tga, $tgb])
			->where('folios.no_kuitansi', 'LIKE', 'PB-'. '%');
				if (isset($cara_bayars)) {
					if ($cara_bayars == '') {
						$data = $data->where('folios.cara_bayar_id', '!=', null);
					} else {
						$data = $data->where('folios.cara_bayar_id', $cara_bayars);
					}

				}

			$data = $data->get(['pasien_langsung.id as pl_id', 'folios.registrasi_id', 'folios.namatarif', 'folios.cara_bayar_id', 'folios.total', 'folios.tarif_id', 'folios.jenis', 'folios.lunas', 'folios.pasien_id', 'folios.dokter_id', 'folios.jenis_pasien', 'folios.poli_id', 'folios.created_at']);
			
			} else {
				$data = Folio::where('poli_tipe', 'L')
							->where('namatarif', 'not like', '%PRC%')
							->whereBetween('created_at', [$tga, $tgb])
							->where('jenis', $jenisReg);
							if ($cara_bayars == '') {
								$data = $data->where('cara_bayar_id', '<>', 0);
							} else {
								$data = $data->where('cara_bayar_id', $cara_bayars);
							}
			$data = $data->get(['registrasi_id', 'namatarif', 'cara_bayar_id', 'total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id', 'jenis_pasien', 'poli_id', 'created_at']);
			}	

		}

		    	$labs['lab_new'] = [];
				foreach ($data as $element) {
					$labs['lab_new'][$element['registrasi_id']][] = $element;
				}
		
		

		$total = $data->sum('total');
		if ($request['submit'] == 'lanjut') {
			return view('laboratorium.lap_kinerja', compact('data', 'cara_bayar', 'total', 'jenisReg', 'labs'))->with('no', 1);
		} elseif ($request['submit'] == 'excel') {
			Excel::create('Laporan Kinerja Laboratorium', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Kinerja Laboratorium')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Kinerja Laboratorium');
				$excel->sheet('Laporan Kinerja Laboratorium', function ($sheet) use ($data) {
					$row = 3;
					$no = 1;

					$sheet->row(1, [
						'',
						'Laporan Kinerja Laboratorium',
						'Periode :'. @$data['tga'] .'Sampai'. @$data['tgb'],
					]);

					$sheet->row(2, [
						'No',
						'Nama',
						'No. RM',
						'No. SEP',
						'Baru/Lama',
						'L/P',
						'Ruang / Poli',
						'Cara Bayar',
						'Tanggal',
						'Dokter',
						'Cara Pulang',
						'Pemeriksaan',
						'Tarif RS',
					]);
					// dd($data);
					foreach ($data as $key => $d) {
						$reg = Registrasi::select('pasien_id','poli_id','no_sep','jenis_pasien', 'tipe_jkn', 'pulang')->where('id', $d->registrasi_id)->first();
						$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
						$pasien = Pasien::find($d->pasien_id);
						// dd($reg->pasien->nama);
						if ($d->jenis == 'TA' || $d->jenis == 'TG') {
							$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
						} elseif ($d->jenis == 'TI') {
							$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
						}
						$sheet->row(++$row, [
							$no++,
							// $pasien ? $pasien->nama : NULL,
							@$pasien->nama ? @$pasien->nama : @$reg->pasien->nama,
							@$pasien->no_rm ? @$pasien->no_rm : @$reg->pasien->no_rm,
							// $pasien ? $pasien->no_rm : NULL,
							@$reg->no_sep,
							($reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
							$pasien ? $pasien->kelamin : NULL,
							$poli,
							baca_carabayar($d->cara_bayar_id) . ' ' . $reg->tipe_jkn,
							$d->created_at->format('d-m-Y'),
							!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
							baca_carapulang($reg->pulang),
							$d->namatarif,
							$d->total,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	//Laporan Kinerja Bank Darah
	public function laporanKinerjaBankDarah() {
		$data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::all();
		return view('laboratorium.lap_kinerja_bank_darah', $data);
	}

	public function laporanKinerjaBankDarahByRequest(Request $request) {
		$tga = $request['tglAwal'] ? valid_date($request['tglAwal']) . ' 00:00:00' : NULL;
		$tgb = $request['tglAkhir'] ? valid_date($request['tglAkhir']) . ' 23:59:59' : NULL;
		$cara_bayar = \Modules\Registrasi\Entities\Carabayar::all();
		$data = Folio::where('jenis', $request['pelayanan'])->where('cara_bayar_id', $request['bayar'])
			->where('poli_tipe', 'L')
			->where('namatarif', 'like', '%PRC%')
			->where('user_id', '!=', 851)
			->where('user_id', '!=', 871)
			->whereBetween('created_at', [$tga, $tgb])
			->get(['registrasi_id', 'namatarif', 'cara_bayar_id', 'total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id',
				'jenis_pasien', 'poli_id', 'created_at']);
		$total = $data->sum('total');
		if ($request['submit'] == 'lanjut') {
			return view('laboratorium.lap_kinerja_bank_darah', compact('data', 'cara_bayar', 'total'))->with('no', 1);
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
						// 'Baru/Lama',
						// 'L/P',
						'Asal Pasien',
						// 'Cara Bayar',
						// 'Tanggal',
						// 'Dokter',
						'Pemeriksaan',
						'Jumlah',
						'Tarif RS',
					]);
					foreach ($data as $key => $d) {
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
							// ($reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
							// $pasien ? $pasien->kelamin : NULL,
							$poli,
							// baca_carabayar($d->cara_bayar_id) . ' ' . $reg->tipe_jkn,
							// $d->created_at->format('d-m-Y'),
							// !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
							$d->namatarif,
							$d->total / $d->tarif->total,
							$d->total,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function antrianLab($unit = null){
        return view('laboratorium.antrian-lab', compact('unit'));
    }

    public function labBelumPeriksa($unit = null)
	{
		$data['unit'] = $unit;
		$query = ServiceNotif::join('registrasis', 'registrasis.id', '=', 'service_notifs.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereDate('service_notifs.updated_at', date('Y-m-d'))
			->where('service_notifs.service', 'laboratorium')
			->where('service_notifs.is_done', 'N')
			->select(
				'service_notifs.*', 
				'pasiens.no_rm', 
				'pasiens.nama', 
				'pasiens.kelamin', 
				'pasiens.tgllahir', 
				'registrasis.dokter_id', 
				'registrasis.bayar', 
				'registrasis.created_at', 
				'registrasis.pasien_id', 
				'registrasis.poli_id',
				'registrasis.status_reg'
			);

		if ($unit == 'jalan') {
			$query->where('registrasis.status_reg', 'like', 'J%');
		} elseif ($unit == 'inap') {
			$query->where('registrasis.status_reg', 'like', 'I%');
		} elseif ($unit == 'igd') {
			$query->where('registrasis.status_reg', 'like', 'G%');
		}
		
		$data['datas'] = $query->get();
		$data['no'] = 1;
		return view('laboratorium.antrian-belum-periksa', $data);
	}

    public function labSudahPeriksa($unit = null)
	{
		$data['unit'] = $unit;
		$query = ServiceNotif::join('registrasis', 'registrasis.id', '=', 'service_notifs.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereDate('service_notifs.updated_at', date('Y-m-d'))
			->where('service_notifs.service', 'laboratorium')
			->where('service_notifs.is_done', 'Y')
			->select(
				'service_notifs.*', 
				'pasiens.no_rm', 
				'pasiens.kelamin', 
				'pasiens.nama', 
				'pasiens.tgllahir', 
				'registrasis.dokter_id', 
				'registrasis.bayar', 
				'registrasis.created_at', 
				'registrasis.pasien_id', 
				'registrasis.poli_id',
				'registrasis.status_reg'
			);

		if ($unit == 'jalan') {
			$query->where('registrasis.status_reg', 'like', 'J%');
		} elseif ($unit == 'inap') {
			$query->where('registrasis.status_reg', 'like', 'I%');
		} elseif ($unit == 'igd') {
			$query->where('registrasis.status_reg', 'like', 'G%');
		}

		$data['datas'] = $query->get();
		$data['no'] = 1;

		return view('laboratorium.antrian-sudah-periksa', $data);
	}
    public function markAsDone($id){
        try{
            $notif  = ServiceNotif::find($id);
            $notif->is_done = 'Y';
            $notif->save();
            return response(['success' => true]);
        }catch(Exception $e){
            return response(['success' => false, 'error' => $e->getMessage()]);
        }
        
    }

	public function panggilAntrian($nomor, $id, $regId){
		try{
			$dateNow = date('Y-m-d');
			$cekAntrianLab = AntrianLaboratorium::whereDate('tanggal', $dateNow)->where('status', 1)->first();
			if($cekAntrianLab){
				$cekAntrianLab->status = 0;
				$cekAntrianLab->update();
			}
	
			$antrianLab = AntrianLaboratorium::find($id);
			$antrianLab->status = 1;
			$antrianLab->update();

			return response()->json([
				'code' => 200,
				'message' => 'Berhasil Panggil',
			]);
		}catch(Exception $e){
			return response()->json([
				'code' => 500,
				'message' => $e,
			]);
		}
	}

	public function display()
	{
		return view('laboratorium.lcd_antrian_pasien');
	}

	public function datalcdantrianpasien()
	{
		$antrian = AntrianLaboratorium::with('registrasi.pasien')->where('tanggal', date('Y-m-d'))->where('status', 1)->latest()->first();
		return view('laboratorium.data_lcd_antrian_pasien', compact('antrian'));
	}
}
