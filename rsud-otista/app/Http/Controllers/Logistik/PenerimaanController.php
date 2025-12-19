<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Flashy;
use Excel;
use Illuminate\Http\Request;
use PDF;
use App\LogistikBatch;
use App\Logistik\LogistikSupplier;
use App\Satuanbeli;
use App\Satuanjual;
use App\Logistik\LogistikGudang;
use App\Logistik\LogistikPeriode;
use App\Logistik\Logistik_BAPB;
use App\Kategoriobat;
use App\Logistik\LogistikStock;
use App\Logistik\Po;
use App\Masterobat;
use App\LogistikOpname;
use App\PenerimaanProduks;
use App\Supliyer;
use Symfony\Component\Config\Definition\Exception\Exception;
use Validator;



class PenerimaanController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//dd('test');
		session()->forget(['tga', 'tgb', 'no_po']);

		$tga = date('Y-m-d', strtotime('now'));
		$tgb = date('Y-m-d', strtotime('now'));

		$data = \App\Logistik\Po::whereBetween('tanggal', [$tga, $tgb])
				->where('verifikasi', 'Y')
				->distinct('no_po')
				->get(['no_po']);
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.penerimaan.index', compact('data'))->with('no', 1);
		}

	}

	public function getPO(Request $request) {
		$tga = $request['tga'] ? valid_date($request['tga']) : NULL;
		$tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;
		session(['tga' => $request['tga'], 'tgb' => $request['tgb'], 'no_po' => $request['no_po']]);

		$data = \App\Logistik\Po::whereBetween('tanggal', [$tga, $tgb])
			->where('verifikasi', 'Y')
			->orWhere('no_po', $request['no_po'])
			->distinct('no_po')
			->get(['no_po']);
		// return $data; die;
		return view('logistik.logistikmedik.penerimaan.index', compact('data'))->with('no', 1);
	}

	public function detailPO($no_po) {
		$data = \App\Logistik\Po::where('no_po', $no_po)->get();
		return view('logistik.logistikmedik.penerimaan.detailPO', compact('data'))->with('no_po', $no_po);
	}

	public function addPenerimaan($po_id) {

		session(['poli_id' => $po_id]);
		$cek_id = strlen($po_id);
		if($cek_id > 12){
			$no_po = $po_id;
		} else {
			$no_po = \App\NoPo::find($po_id)->no_po;
		}

		$penerimaan['gudang']     = LogistikGudang::find(Auth::user()->gudang_id);
		$penerimaan['kategori']   = Kategoriobat::pluck('nama', 'id');
		$penerimaan['supplier']   = LogistikSupplier::all();
		$penerimaan['satuanbeli']   = Satuanbeli::all();
		$penerimaan['satuanjual']   = Satuanjual::all();

		$penerimaan['po'] = Po::where('no_po', $no_po)->first();
		$penerimaan['tgl_jth_tempo'] = @date('d-m-Y', strtotime($penerimaan['po']->tanggal. ' + 3 months'));
		// dd($penerimaan['po']);
		// $penerimaan['list_penerimaan'] = LogistikPenerimaan::where('no_po', $no_po)->get();
		// return $penerimaan; die;
		$penerimaan['data'] = Logistik_BAPB::
            join('logistik_po', 'logistik_po.no_po', '=', 'logistik_bapbs.no_po')
            ->where('logistik_bapbs.no_po', $no_po)
            ->distinct('logistik_bapbs.no_po')
            ->get(['logistik_bapbs.nama','logistik_bapbs.satuan','logistik_bapbs.id', 'logistik_bapbs.no_po', 'logistik_bapbs.no_faktur', 'logistik_bapbs.created_at', 'logistik_bapbs.jumlah_diterima', 'logistik_bapbs.id']);

        // Eager Load Manual Agar Query tidak lambat
        $arr_nama_obat = $penerimaan['data']->pluck('nama')->toArray();
        $penerimaan['obats'] = Masterobat::whereIn('nama', $arr_nama_obat)->get(['id', 'nama']);

        $arr_bapb_id = $penerimaan['data']->pluck('id')->toArray();
        $penerimaan['batches'] = LogistikBatch::whereIn('bapb_id', $arr_bapb_id)->get(['id', 'bapb_id', 'jumlah_item_diterima']);
		return view('logistik.logistikmedik.penerimaan.addPenerimaan', $penerimaan)->with('no', 1);
	}

	public function editPenerimaan(Request $request){
		// dd($request->all());
		$noPo = $request->noPo;
		$supplier = $request->supplier;
		
		try{
			//Update supplier di tabel logistik_po
			$po = Po::where('no_po', $noPo)->get();
			foreach($po as $p){
				$p->supplier = $supplier;
				$p->update();
			}
	
			//Update supplier di tabel logistik_bapbs
			$bapb = Logistik_BAPB::where('no_po', $noPo)->get();
			foreach($bapb as $d){
				$d->saplier = $supplier;
				$d->update();
			}
			
			return response()->json([
				'code' => 200,
				'message' => 'Berhasil Update data',
				'extra' => '',
			]);
		}catch(Exception $e){
			return response()->json([
				'code' => 500,
				'message' => 'Gagal Update data',
				'extra' => $e,
			]);
		}

	}

	public function cetakPenerimaan($nomor)
	{
		// $tahun = date('Y');
		$tahun = baca_tahun(\App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')->first()->no_po);
		$data = \App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->get();
		$pemeriksa = \App\Logistik\Logistik_BAPB::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')->first();
		$pegawai = \App\Logistik\LogistikPejabatBendahara::where('id', 1)->first();
		$pegawaiPPKMedis = \App\Logistik\LogistikPejabatBendahara::where('id', 2)->first();
		$baranglist = \App\Logistik\Logistik_BAPB::where('no_po', 'LIKE', '%' . $nomor . '%')
		->get();
		// return compact('data', 'pegawai', 'pemeriksa', 'pegawaiPPKMedis'); die;
		$pdf = PDF::loadView('logistik.logistikmedik.penerimaan.kuitansiPenerimaan', compact('data', 'pegawai', 'pemeriksa', 'pegawaiPPKMedis','baranglist'));
		return $pdf->stream();
	}

	public function cetakSpk($nomor)
	{
		// $tahun = date('Y');
		$tahun = baca_tahun(\App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')->first()->no_po);
		$data = \App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->distinct('no_faktur')
			->get(['no_faktur']);
		$total = \App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->sum('hpp');
		$spk = \App\Logistik\LogistikSpk::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->first();

		$pegawai = \App\Logistik\LogistikPejabatBendahara::where('id', 1)->first();
		$pegawai_pengadaan = \App\LogistikPejabatPengadaan::where('id', 1)->first();
		// return compact('data', 'pegawai', 'spk','total'); die;
		$pdf = PDF::loadView('logistik.logistikmedik.penerimaan.kuitansiSPK', compact('data', 'pegawai', 'spk', 'total', 'pegawai_pengadaan'));
		return $pdf->stream();
	}

	public function cetakPemeriksaBarang($nomor, $faktur)
	{
		// $tahun = date('Y');
		$tahun = baca_tahun(\App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')->first()->no_po);
		$data = \App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->get();
		$barang = \App\Logistik\Logistik_BAPB::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->first();
		$baranglist = \App\Logistik\Logistik_BAPB::where('no_po', 'LIKE', '%' . $nomor . '%')
			->where('no_po', 'LIKE', '%' . $tahun . '%')
			->where('no_faktur', $faktur)
			->get();

		$pegawai = \App\Logistik\PejabatPengecekan::all();
		// return compact('data','tahun','no', 'baranglist'); die;
		$pdf = PDF::loadView('logistik.logistikmedik.penerimaan.kuitansiPemeriksaanBarang', compact('data', 'pegawai', 'barang', 'baranglist'));
		return $pdf->stream();
	}

	// public function getItemPo($id) {
	// 	$data['item'] = \App\Logistik\Po::find($id);
	// 	$data['namaBarang'] = \App\Masterobat::select('nama', 'hargabeli')->where('id', $data['item']->masterobat_id)->first();
	// 	$data['satuan'] = \App\Satuanbeli::find($data['item']->satuan);
	// 	$data['penerimaan'] = \App\Logistik\LogistikPenerimaan::join('logistik_po', 'logistik_po.no_po', '=', 'logistik_penerimaans.no_po')
	// 	->where('logistik_po.id', $data['item']->$id)->first();
	// 	if (\App\Logistik\Logistik_BAPB::where('no_po', $data['item']->no_po)->count() > 0) {
	// 		$data['berita'] = \App\Logistik\Logistik_BAPB::where('no_po', $data['item']->no_po)->first();
	// 	}else{
	// 		$data['berita'] = [];
	// 	}
	// 	return $data; die;
	// }

	public function getItem($id, $no_faktur) {
		// if (strpos($no_faktur, '-')) {
		// 	$no_faktur = str_replace('-', '/', $no_faktur);
		// }
		$data['item'] = \App\Logistik\Po::find($id);
		$data['namaBarang'] = \App\Masterobat::select('nama', 'hargabeli','id')->where('id', $data['item']->masterobat_id)->first();
		$data['satuan'] = \App\Satuanbeli::find($data['item']->satuan);
		$data['penerimaan'] = \App\Logistik\LogistikPenerimaan::join('logistik_po', 'logistik_po.no_po', '=', 'logistik_penerimaans.no_po')
		->where('logistik_po.id', $data['item']->$id)->first();

		if (\App\Logistik\Logistik_BAPB::where('no_po', $data['item']->no_po)->count() > 0) {
			$data['berita'] = \App\Logistik\Logistik_BAPB::where('no_po', $data['item']->no_po)
			->where('nama', $data['namaBarang']->nama)
			->where('no_faktur', $no_faktur)
			->first();
		}else{
			$data['berita'] = [];
		}

		// return $data; die;
		return view('logistik.logistikmedik.penerimaan.fromPenerimaan', $data)->with('no', 1);
	}

	public function getEditItemPenerimaan($no_po)
	{
		// return $no_po; die;
		$data['item'] = \App\Logistik\Po::where('no_po', 'LIKE', '%' . $no_po . '%')->first();
		$data['namaBarang'] = \App\Masterobat::select('nama', 'hargabeli')->where('id', $data['item']->masterobat_id)->first();
		$data['satuan'] = \App\Satuanbeli::find($data['item']->satuan);
		$data['penerimaan'] = \App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $no_po . '%')->first();
		return $data;
	}

	public function savePenerimaan(Request $request) {
		// return $request->all(); die;
		// dd($request->all());
		DB::transaction(function () use ($request) {
			if (!empty($request['terima'])) {
				$master = \App\Masterobat::find($request['masterobat_id']);
				$supplier = \App\Logistik\LogistikSupplier::where('nama', $request['supplier'])->first();
				@$po = \App\Logistik\Po::where([['masterobat_id','=', $request['masterobat_id']],['no_po','=', $request['no_po']]])->first();

				// dd($po);
				//Update Stok
				// $cekJml = \App\Logistik\LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->orderBy('created_at', 'desc')->first();
				// $jumlah = $cekJml ? $cekJml->total : \App\LogistikBatch::where('masterobat_id', $request['masterobat_id'])->sum('stok');

				if (\App\Logistik\LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->count() > 0) {
					$jumlah = \App\Logistik\LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
				} else {
					$jumlah = \App\LogistikBatch::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->sum('stok');
				}

				$lnb = new \App\LogistikBatch();
				$lnb->gudang_id = Auth::user()->gudang_id;
				$lnb->user_id = Auth::user()->id;
				$lnb->nama_obat = $request['namaBarang'];
				$lnb->bapb_id = $request['bapb_id'];
				$lnb->masterobat_id = $request['masterobat_id'];
				$lnb->satuanbeli_id = $master->satuanbeli_id;
				$lnb->satuanjual_id = $master->satuanjual_id;
				$lnb->supplier_id = $supplier->id;
				$lnb->nomorbatch = $request['batch'];
				$lnb->expireddate = valid_date($request['expired']);
				$lnb->stok = $request['jml_satuan'];
				$lnb->jumlah_item_diterima = $request['terima'];
				$lnb->hargabeli = rupiah($request['hna']);
				$lnb->hargajual_jkn = rupiah($request['harga_jual_satuan']);
				$lnb->hargajual_umum = rupiah($request['harga_jual_satuan']);
				$lnb->hargajual_dinas = rupiah($request['harga_jual_satuan']);
				$lnb->save();

				// Update harga jual obat
				$master->hargajual_jkn = rupiah($request['harga_jual_jkn']);
				$master->hargajual = rupiah($request['harga_jual_satuan']);
				$master->hargabeli = rupiah($request['hna']);
				$master->save();
				

				$stock = new \App\Logistik\LogistikStock();
				$stock->gudang_id = Auth::user()->gudang_id;
				$stock->supplier_id = $supplier->id;
				$stock->masterobat_id = $request['masterobat_id'];
				$stock->batch_no = $request['batch'];
				$stock->logistik_batch_id = $lnb->id;
				$stock->expired_date = valid_date($request['expired']);
				$stock->masuk = $request['jml_satuan'];
				$stock->periode_id = date('m');
				$stock->total = $jumlah + $request['jml_satuan'];
				// $stock->total = $request['jml_satuan'];
				$stock->keterangan = 'Penerimaan No. Faktur ' . $request['no_faktur'];
				$stock->save();

				// Save Logistik Faktur
				$faktur = new \App\Logistik\LogistikFaktur();
				$faktur->user_id = Auth::user()->id;
				$faktur->po_id = @$po->id;
				$faktur->supplier = $request['supplier'];
				$faktur->jenis_pembayaran = $request['jenis_pembayaran'];
				$faktur->masterobat_id = $request['masterobat_id'];
				$faktur->nama_barang = $request['namaBarang'];
				// $faktur->jenis_obat = $request['jenis_obat']; 
				$faktur->no_faktur = $request['no_faktur']; 
				$faktur->tgl_jatuh_tempo = valid_date($request['jatuh_tempo']);
				$faktur->tgl_faktur = valid_date($request['tanggal_penerimaan']);
				$faktur->jumlah_box = $request['terima'];
				$faktur->jumlah_isi = $request['satuan'];
				$faktur->jumlah_satuan = $request['jml_satuan'];
				$faktur->total_tagihan = rupiah($request['jml_total']);
				$faktur->total_desimal = $request['harga_jual_faktur'];
				$faktur->tgl_dibayar = valid_date($request['tgl_bayar']);
				$faktur->save();
			}
			DB::commit();
		});
		if (!empty($request['diterima'])) {
			Flashy::success('Penerimaan berhasil di simpan');
		}
		$poli_id = $request['url'];
		return response()->json(['sukses' => true, 'url' => $poli_id]);
	}

	function listPenerimaan($id)
	{
		$data['verif'] = Po::find($id);
		$cek_bapb	= Logistik_BAPB::where('no_po', $data['verif']->no_po)->count();
		if ($cek_bapb > 0) {
			$data['bapb']	= Logistik_BAPB::where('no_po', $data['verif']->no_po)->first();
		} else {
			$data['bapb']	= 'kosong';
		}

		$cekbapb = Logistik_BAPB::count();
		if ($cekbapb == 0) {
			$cekUrutanbapb = 0000;
		} else {
			$cekUrutanbapb = explode('/', DB::table('logistik_bapbs')
				->latest()
				->first()->no_bapb);
		}
		$noAwalbapb = '020/';
		$data['nomorBAPB'] = $noAwalbapb . sprintf("%04s", abs($cekUrutanbapb[1] + 1)) . '/PLK';

		$data['penerimaan']    = Po::
            leftJoin('masterobats', 'logistik_po.masterobat_id', '=', 'masterobats.id')
			->leftJoin('satuanbelis', 'logistik_po.satuan', '=', 'satuanbelis.id')
			->where('logistik_po.no_po', $data['verif']->no_po)
			->where('logistik_po.verifikasi', 'Y')
			->select('logistik_po.*', 'masterobats.nama', 'satuanbelis.nama as nama_satuan')
			->distinct('logistik_po.id')
			->get(['logistik_po.id']);
        
        $arr_masterobat_id =  $data['penerimaan']->pluck('masterobat_id')->toArray();
        $data['stocks'] = LogistikBatch::
            where('gudang_id', 8)
            ->whereIn('masterobat_id', $arr_masterobat_id )
            ->groupBy  ('masterobat_id')->select('masterobat_id', DB::raw('SUM(stok) as stok'))
            ->get();
     
		$data['list'] = Logistik_BAPB::
            leftJoin('masterobats', 'logistik_bapbs.nama', '=', 'masterobats.nama')
            ->where('no_po', $data['verif']->no_po)
            ->select('logistik_bapbs.*', 'masterobats.id as masterobat_id')
            ->get();
		return view('logistik.logistikmedik.penerimaan.listPenerimaan', $data);
	}

	//detail
	public function listBatches($id) {
		$bapb = Logistik_BAPB::find($id);
		$batches = \App\LogistikBatch::where('bapb_id', $id)->get();
		$nomer_batch = \App\LogistikBatch::where('bapb_id', $id)->first();
		$jumlah = \App\LogistikBatch::where('bapb_id', $id)->sum('jumlah_item_diterima');
		return response()->json(['batches' => $batches, 'nomer_batch' => $nomer_batch, 'jumlah' => $jumlah, 'bapb' => $bapb]);
	}


	public function editBatch($id, Request $request) {

		$batches = \App\LogistikBatch::where('id', $id)->get();
		$nomer_batch = \App\LogistikBatch::find($id);
		$jumlah = \App\LogistikBatch::where('id', $id)->sum('jumlah_item_diterima');

		$nomer_batch->jumlah_item_diterima = $request->jumlah_batch;
		$nomer_batch->hargabeli = $request->hargaBeli;
		$nomer_batch->hargajual_jkn = $request->hargaJual;
		$nomer_batch->hargajual_umum = $request->hargaJual;
		$nomer_batch->hargajual_dinas = $request->hargaJual;
		$nomer_batch->update();

		return response()->json(['batches' => $batches, 'nomer_batch' => $nomer_batch, 'jumlah' => $jumlah]);
	}


	public function hapusBatch($id, Request $request) {

		$batches = \App\LogistikBatch::where('id', $id)->get();
		$nomer_batch = \App\LogistikBatch::find($id);
		$jumlah = \App\LogistikBatch::where('id', $id)->sum('jumlah_item_diterima');

		$nomer_batch->delete();

		return response()->json(['batches' => $batches, 'nomer_batch' => $nomer_batch, 'jumlah' => $jumlah]);
	}




	public function create() {

		$data['satuanbeli'] = Satuanbeli::pluck('nama', 'id');
		$data['satuanjual'] = Satuanjual::pluck('nama', 'id');
		

		/*$akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
		foreach ($akunCoa as $value) {
			$data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
		}*/

		return view('logistik.logistikmedik.penerimaan.create', $data);

	}

	public function import(Request $request)
	{

		//dd('test import penerimaan logistic');

		ini_set('max_execution_time', 500); //300 seconds = 5 minutes
		ini_set('max_execution_time', 0); //0=NOLIMIT

		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		DB::beginTransaction();
		try {

			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
			})->get();

			$rowRules = [
				'nama_produk'   => 'required',
				
			];
			$data = [];

			//Looping data
			//dd($excels);
			foreach ($excels as $row) {
				$validator = Validator::make($row->toArray(), $rowRules);
				if ($validator->fails()) {
					continue;
				}

				// Penerimaan Produk where kode_penerimaan untuk mengambil nama_supllier
				$GetSupliyer = PenerimaanProduks::where('kode_penerimaan', $row['kode_pe'])->first();
      
				if (!$GetSupliyer) {
					/*$sat       = new Satuanbeli();
					$sat->nama = $row['satuan'];
					$sat->save();
					$beli      = $sat->id;*/
				
				} else {
					// Cek Supplier ada tidak di SIM-RS
					
 					$Sup     = PenerimaanProduks::where('kode_penerimaan', $row['kode_pe'])->first();
					if (!$Sup) {
						
					} else {
						$Cre     = Supliyer::where('nama', $Sup->nama_supplier)->first();
						if (!$Cre) {
							$satj = new Supliyer();
							$satj->nama = $Sup->nama_supplier;
							$satj->save();
							$sup = $satj->id;
						}else{
							//$namasupliyer  = $Sup->nama_supplier;
						}

						$sup           = $Sup->id;
						$namasupliyer  = $Sup->nama_supplier;
						$tanggal       = $Sup->tanggal_penerimaan;
						$nomorfaktur   = $Sup->nomor_faktur;
						$tanggalfaktur = $Sup->tanggal_faktur;
						$keterangan    = $Sup->keterangan_penerimaan;
					}

					   

					$datasup['kode']  = $sup;
                    Supliyer::where('id', $sup)->update($datasup);
					
				}

				    $BAPBS = Logistik_BAPB::where('nama', $row['nama_produk'])->first(); //Cek BAPB
					if (!$BAPBS) { //Jika tiddk ada, buat baru
						
					$bapb = new Logistik_BAPB();
					$bapb->saplier = $namasupliyer;
					$bapb->tanggal_jatuh_tempo = '';
					$bapb->no_po = $row['kode_pe'];
					$bapb->tanggal_faktur = $tanggalfaktur;
					$bapb->no_faktur = $nomorfaktur;
					$bapb->no_bapb = $row['kode_pe'];
					$bapb->nama = $row['nama_produk'];
					$bapb->satuan = $row['satuan'];
					$bapb->jumlah_dipesan = $row['dipesan'];
					$bapb->jumlah_diterima = $row['dipesan'];
					$bapb->keterangan = $keterangan;
					//$obat->hargabeli = $row['harga_beli'];
					$bapb->user_id = 1;
					$bapb->tanggal = $tanggal;
					$bapb->save();
					}
				
			}

			DB::commit();
			Flashy::success('Logistic BAPB Berhasil diimport');
			return redirect('logistikmedik/penerimaan');
		} catch (Exception $e) {
			DB::rollback();

			Flashy::info('Gagal Import data');
			return redirect('logistikmedik/penerimaan');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
