<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Validator;
use Excel;
use PDF;
use Flashy;
use Carbon\Carbon;
use App\LogistikBatch;

class PemakaianController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$gudang_id = Auth::user()->gudang_id;
		$data= [];
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.pemakaian.index', compact('data'));
		}
	}
	public function excel(Request $request) { 
		$data = \App\Logistik\LogistikPemakaian::
		whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
		->where('gudang_id', Auth::user()->gudang_id)->get();
		Excel::create('Laporan Pemakaian '.$request['tga'].'__'.$request['tgb'], function ($excel) use ($data,$request) {
			// Set the properties
			$excel->setTitle('Laporan Pemakaian')
				->setCreator('RSI Attaqwa Gumawang')
				->setCompany('RSI Attaqwa Gumawang')
				->setDescription('Laporan Pemakaian');
			$excel->sheet('Laporan Pemakaian', function ($sheet) use ($data) {
				$row = 1;
				$no = 1;
				$sheet->row($row, [
					'No',
					'Barang',
					'Jumlah',
					'Keterangan',
					'User',
					'Tanggal',
				]);
				foreach ($data as $key => $d) {
					$sheet->row(++$row, [
						$no++,
						@$d->barang->nama,
						@$d->jumlah,
						@$d->keterangan, 
						@$d->user->name, 
						Carbon::parse($d->created_at)->format('d-m-Y')
					]);
				};
			});

		})->export('xlsx');
		// dd($data);
	}

	public function data(Request $request) {
		// $data = \App\Logistik\LogistikPemakaian::where('gudang_id', Auth::user()->gudang_id)->latest();
		// return DataTables::of($data)
		// 	->addIndexColumn()
		// 	->addColumn('barang', function ($data) {
		// 		return $data->barang->nama;
		// 	})
		// 	->addColumn('user', function ($data) {
		// 		return $data->user->name;
		// 	})
		// 	->make(true);
		if ($request->ajax()) {
			$data = \App\Logistik\LogistikPemakaian::where('gudang_id', Auth::user()->gudang_id)->latest();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('barang', function ($data) {
					return $data->barang->nama;
				})
				->addColumn('user', function ($data) {
					return $data->user->name;
				})
				->addColumn('tanggal', function ($data) {
					return Carbon::parse($data->created_at)->format('d-m-Y');
				})
				// ->addColumn('jumlah', function ($data){
				// 	return '<input type="number" style="width: 25%" class="form-control text-center" name="jumlah' . $data->id . '" value="' . $data->jumlah . '" onchange="editJumlah(\'' . $data->id . '\')">';
				// })
				->addColumn('aksi', function ($data) {
					return '<a href="' . route('nota-pemakaian', $data->id) . '" class="btn btn-info btn-sm"><i class="fa fa-print" target="_blank"></i></a>';
				})
				->rawColumns(['aksi','jumlah'])
				->make(true);
		}
	}

	public function getMasterObat(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = \App\Masterobat::where('nama', 'like', '%' . $term . '%')->limit(15)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$cek = \App\Logistik\LogistikStock::where('gudang_id', Auth::user()->gudang_id)->where('masterobat_id', $tag->id);
			if ($cek->count() > 0) {
				$saldo = \App\Logistik\LogistikStock::where('gudang_id', Auth::user()->gudang_id)->where('masterobat_id', $tag->id)->latest()->first()->total;
			}else{
				$saldo = '';
			}

			// $stok = \App\Logistik\LogistikStock::where('gudang_id', Auth::user()->gudang_id)->where('masterobat_id', $tag->id)->get();
			// $saldo = $stok->sum('masuk') - $stok->sum('keluar');

			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . $saldo . ' |', 'saldo' => $saldo];
		}

		return \Response::json($formatted_tags);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$jumlahobat = \App\Logistik\LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;

		if ($request['jumlah'] > $jumlahobat) {
			return response()->json(['gagal' => true,'msg' => 'Jumlah Tidak boleh lebih dari '.$jumlahobat]);
		} else {
			$cek = Validator::make($request->all(), [
				'jumlah' => 'required',
				'keterangan' => 'required',
			]);
			// dd($request->all());
			if ($cek->fails()) {
				return response()->json(['sukses' => false, 'error' => $cek->errors()]);
			} else {
				DB::beginTransaction();
				try{
					$getMasterObatId = explode('|', $request['masterobat_id']);
					// $obat = LogistikBatch::find($request['masterobat_id']);
					$obat = LogistikBatch::where('masterobat_id',$request['masterobat_id'])
											->where('gudang_id', Auth::user()->gudang_id)->latest()->first();
					// dd($obat);
					$pm = new \App\Logistik\LogistikPemakaian();
					$pm->masterobat_id = $request['masterobat_id'];
					$pm->batch_no = $obat->nomorbatch;
					$pm->gudang_id = Auth::user()->gudang_id;
					$pm->jumlah = $request['jumlah'];
					$pm->keterangan = $request['keterangan'];
					$pm->user_id = Auth::user()->id;
					if (!empty($request['tanggal'])) {
						$pm->created_at = valid_date($request['tanggal']) . ' ' . date('H:i:s');
					} else {
						$pm->created_at = date('Y-m-d H:i:s');
					}
					$pm->save();
					// $obat = \App\Masterobat::find($getMasterObatId[0]);
					// $obat->saldo = $obat->saldo - $request['jumlah'];
					// $obat->update();

					// //Kurangi Stok
					// $getStock = \App\Logistik\LogistikStock::where('masterobat_id', $getMasterObatId[0])
					// 	// ->where('batch_no', $getMasterObatId[1])
					// 	->orderBy('created_at', 'desc')
					// 	->first();
					// if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $getMasterObatId[0])->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
					// 	$saldo = \App\Logistik\LogistikStock::where('masterobat_id', $getMasterObatId[0])->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
					// } else {
					// 	$saldo = 0;
					// }
					// $stock = new \App\Logistik\LogistikStock();
					// $stock->gudang_id = Auth::user()->gudang_id;
					// $stock->supplier_id = $getStock->supplier_id;
					// $stock->masterobat_id = $getStock->masterobat_id;
					// $stock->batch_no = $getStock->batch_no;
					// $stock->expired_date = $getStock->expired_date;
					// $stock->masuk = 0;
					// $stock->periode_id = date('m');
					// $stock->keluar = $request['jumlah'];
					// $stock->total = $saldo - $request['jumlah'];
					// $stock->keterangan = 'Pemakaian '.$request['keterangan'];
					// $stock->save();

					// $saldo_obat = LogistikBatch::find($request['masterobat_id']);
					$saldo_obat = LogistikBatch::where('masterobat_id',$request['masterobat_id'])
												->where('gudang_id', Auth::user()->gudang_id)->latest()->first();
					$saldo_obat->stok = $saldo_obat->stok - $request['jumlah'];
					$saldo_obat->updated_at = Carbon::now();
					$saldo_obat->update();
 
					if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
						$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
					} else {
						$total_stok = \App\LogistikBatch::where('masterobat_id', $request['masterobat_id'])->sum('stok');
					}

					$stock = new \App\Logistik\LogistikStock();
					$stock->gudang_id = Auth::user()->gudang_id;
					// $stock->supplier_id = null;
					$stock->supplier_id = isset($saldo_obat->supplier_id) ? $saldo_obat->supplier_id : null;
					$stock->masterobat_id = $saldo_obat->masterobat_id;
					$stock->logistik_batch_id = $saldo_obat->id;
					$stock->batch_no = $saldo_obat->nomorbatch;
					$stock->expired_date = Carbon::parse($saldo_obat->expireddate)->format('Y-m-d');
					$stock->masuk = 0;
					$stock->periode_id = date('m');
					$stock->keluar = $request['jumlah'];
					$stock->total = $total_stok - $request['jumlah'];
					$stock->keterangan = 'Pemakaian '.$request['keterangan'].' Tanggal '.$request['tanggal'];
					$stock->save();

					// //Kurangi Saldo Batch
					// $lnb = \App\Logistik\LogistikNoBatch::where('masterobat_id', $getMasterObatId[0])->where('batch_no', $getMasterObatId[1])->first();
					// $lnb->saldo = $lnb->saldo - $request['jumlah'];
					// $lnb->update();
					DB::commit();

					return response()->json(['sukses' => true]);
				}catch (\Exception $e) {
					DB::rollback();
					return response()->json(['sukses' => false, "msg" => $e->getMessage()]);
				}
				
			}
		}

	}

	public function ubahjumlah(Request $request)
	{
		$cek= \App\Logistik\LogistikPemakaian::where('id', $request['id'])->first();
		// return $cek->jumlah; die;
		if ($request['jumlah'] >= $cek->jumlah) {
			$jumlah = $request['jumlah'] - $cek->jumlah;
			$obat = \App\Masterobat::find($cek->masterobat_id);
			$obat->saldo = $obat->saldo - $jumlah;
			$obat->update();
		} elseif ($request['jumlah'] <= $cek->jumlah) { 
			$obat = \App\Masterobat::find($cek->masterobat_id);
			$obat->saldo = $obat->saldo - $request['jumlah'];
			$obat->update();
		}

		$po = \App\Logistik\LogistikPemakaian::where('id', $request['id'])->first();
		$po->jumlah = $request['jumlah'];
		$po->update();

		//Kurangi Stok
		$getStock = \App\Logistik\LogistikStock::where('masterobat_id', $cek->masterobat_id)
			// ->where('batch_no', $getMasterObatId[1])
			->orderBy('created_at', 'desc')
			->limit(1)
			->first();
		$stock = new \App\Logistik\LogistikStock();
		$stock->gudang_id = Auth::user()->gudang_id;
		$stock->supplier_id = $getStock->supplier_id;
		$stock->masterobat_id = $getStock->masterobat_id;
		$stock->batch_no = $getStock->batch_no;
		$stock->expired_date = $getStock->expired_date;
		$stock->masuk = 0;
		$stock->keluar = $request['jumlah'];
		$stock->total = $getStock->total-$request['jumlah'];
		$stock->keterangan = 'Edit Pemakaian ' . $request['keterangan'] . $cek->jumlah .' Jadi ' . $request['jumlah'] ;
		$stock->save();

		return response()->json(['sukses' => true]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function cetak($id)
	{
		
	}

	public function cetakPemakaian($id)
	{
		$tahun = date('Y');
		$no = 1;
		$data = \App\Logistik\LogistikPemakaian::where('id', $id)
			->get();
		// return compact('data','tahun','no'); die;
		$pdf = PDF::loadView('logistik.logistikmedik.pemakaian.kuitansiPemakaian', compact('data', 'no'));
		return $pdf->stream();
	}

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
