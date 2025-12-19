<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\LogistikGudang;
use Auth;
use App\Logistik\LogistikStock;
use App\Logistik\LogistikPeriode;
use App\Masterobat;
use App\Penjualan;
use Flashy;
use Excel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy as FlashyFlashy;
use Modules\Registrasi\Entities\Registrasi;

class KartuStokController extends Controller {
	
	public function index() {
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['gudang']	= LogistikGudang::pluck('nama', 'id');
		$data['obat']	= Masterobat::pluck('nama', 'id');
		$data['periode']    = LogistikPeriode::pluck('nama', 'id');
		 if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.kartu_stok.index', $data);
		}
	}

	public function dataStok(Request $request) {
		
		// request()->validate(['tga' => 'required', 'tgb' => 'required'], ['tga.required' => 'Periode Tanggal Wajib Diisi', 'tgb.required' => 'Periode Tanggal Wajib Diisi']);
		
	
		$data['obat']	= Masterobat::pluck('nama', 'id');
		$data['gudang']	= LogistikGudang::pluck('nama', 'id');

        $data['stok']   = 
            LogistikStock::where('gudang_id', $request['gudang_id'])
            ->leftjoin('penjualans', function($join){
                $join->on(
                    DB::raw("SUBSTRING(logistik_stocks.keterangan, LENGTH('Penjualan ') + 1)"), '=', 'penjualans.no_resep'
                );
            })
            ->leftjoin('registrasis', 'registrasis.id', '=', 'penjualans.registrasi_id')
            ->leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->where('logistik_stocks.masterobat_id', $request['masterobat_id']);
            
		if ($request['tga'] && $request['tgb']) {
			$data['tga']    = valid_date($request['tga']);
			$data['tgb']    = valid_date($request['tgb']);
			$data['stok']   = $data['stok']
                ->whereBetween('logistik_stocks.created_at', [$data['tga'] . ' 00:00:00', $data['tgb'] . ' 23:59:59'])
                ->select('logistik_stocks.*', 'penjualans.no_resep', 'pasiens.nama', 'pasiens.no_rm')
                ->get();
		} else {
			$data['tga'] = "";
			$data['tgb'] = "";
			$data['stok']   = $data['stok']
                ->select('logistik_stocks.*',  'logistik_suppliers.nama as nama_supplier', 'penjualans.no_resep', 'pasiens.nama', 'pasiens.no_rm')
                ->get();
		}
        if($request['excel']){
			ini_set('max_execution_time', 300); //0=NOLIMIT
			ini_set('memory_limit', '8000M');
            Excel::create('Logistik Kartu Stok', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Logistik Kartu Stok')
					->setCreator('DIMJ')
					->setCompany('DIMJ')
					->setDescription('Logistik Kartu Stok');
				$excel->sheet('Logistik Kartu Stok', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama Pasien',
						'No RM',
						'Keterangan',
						'Tanggal',
						'Masuk',
						'Keluar',
						'Saldo',
						'Batch'
					]);
                    foreach($data['stok'] as $st){
                        $sheet->row(++$row, [
                            $no++,
							$st->nama,
							$st->no_rm,
                            $st->keterangan,
                            $st->created_at,
                            $st->masuk,
                            $st->keluar,
                            $st->total,
                            $st->batch_no
                        ]);
                    }
                });
			})->export('xlsx');
        }else if($request['cetak']){
            $no = 1;
            $pdf = PDF::loadView('logistik.logistikmedik.kartu_stok.cetakPdf', compact('stock', 'no', 'obat'));
			$pdf->setPaper('A4', 'landscape');
            return $pdf->download('lap_kunjungan.pdf');
		}
		else{
			return view('logistik.logistikmedik.kartu_stok.index', $data)->with('no',1);
		}
		
	}

	public function kartuStokBatch()
	{
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['gudang']	= LogistikGudang::find(Auth::user()->gudang_id);
		$data['obat']	= Masterobat::pluck('nama', 'id');
		$data['periode']    = LogistikPeriode::pluck('nama', 'id');
		 if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.kartu_stok.kartustok-batch', $data);
		}
	}

	public function kartuStokBatchFilter(Request $request)
	{
		$data['obat']	= Masterobat::pluck('nama', 'id');
		$data['gudang']	= LogistikGudang::find(Auth::user()->gudang_id);

		if ($request['tga'] && $request['tgb']) {
			# code...
			$data['tga'] = valid_date($request['tga']);
			$data['tgb'] = valid_date($request['tgb']);
			$data['stok'] = LogistikStock::with(['logistik_batch'])->where('gudang_id', $request['gudang_id'])
			->whereBetween('created_at', [$data['tga'] . ' 00:00:00', $data['tgb'] . ' 23:59:59'])
			->where('masterobat_id', $request['masterobat_id'])
			->get();
		} else {
			$data['tga'] = "";
			$data['tgb'] = "";
			$data['stok'] = LogistikStock::with(['logistik_batch'])->where('gudang_id', $request['gudang_id'])
			->where('created_at', 'like', date('Y-m') . '%')
			->where('masterobat_id', $request['masterobat_id'])
			->get();
		}
		// dd( $data );
		
        if($request['excel']){
            Excel::create('Logistik Kartu Stok '.$obat, function ($excel) use ($stock, $obat) {
				// Set the properties
				$excel->setTitle('Logistik Kartu Stok '.$obat)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Logistik Kartu Stok');
				$excel->sheet('Logistik Kartu Stok', function ($sheet) use ($stock) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Tanggal',
						'Masuk',
						'Keluar',
						'Saldo',
						'Keterangan'
					]);
                    foreach($stock as $st){
                        $sheet->row(++$row, [
                            $no++,
                            $st->created_at,
                            $st->masuk,
                            $st->keluar,
                            $st->total,
                            $st->keterangan
                        ]);
                    }
                });
			})->export('xlsx');
        }else if($request['cetak']){
            $no = 1;
            $pdf = PDF::loadView('logistik.logistikmedik.kartu_stok.cetakPdf', compact('stock', 'no', 'obat'));
			$pdf->setPaper('A4', 'landscape');
            return $pdf->download('lap_kunjungan.pdf');
		}
		else{
			return view('logistik.logistikmedik.kartu_stok.kartustok-batch', $data)->with('no',1);
		}
	}

	public function gelobalKartuStok()
	{
		// $data['gudang']	= LogistikGudang::all();
		$data['obat']	= Masterobat::select('nama','id')->get();
		return view('logistik.logistikmedik.kartu_stok.gelobal', $data);
	}

	// public function datagelobalKartuStok(Request $request)
	// {
	// 	ini_set('max_execution_time', 900); // 5 minutes

	// 	if(!$request['tgl_awal'] || !$request['tgl_akhir']){
	// 		return response()->json(['data' => 'Tanggal wajib diisi lengkap','sukses'=>false]);
	// 	}
	// 	// request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jangan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

	// 	$awal  = valid_date($request['tgl_awal']);
	// 	$akhir = valid_date($request['tgl_akhir']);
	// 	// dd([$awal,$akhir]);
	// 	$stock = LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')]);
		
	// 	// dd($request['masterobat_id']);
	// 	$obat = 'SEMUA OBAT';
	// 	if($request['masterobat_id'] !== "all"){
	// 		$stock->where('masterobat_id', $request['masterobat_id']);
	// 		$obat	= Masterobat::find($request['masterobat_id'])->nama;
		
	// 	}
	// 	// $stock = $stock->get();
	// 	$stock = $stock->orderBy('created_at','DESC')->groupBy('masterobat_id')->get();
	// 	// dd($stock);
	// 	// if()

	// 	if ($request['excel']) {
			
	// 		$data_stock = [];
	// 		foreach($stock as $item){
	// 			$gudang_pusat = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->total;
	// 			$rajal = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->total;
	// 			$ugd  = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',3)->orderBy('created_at','DESC')->first()->total;
	// 			$kpr = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->total;
				
	// 			$masuk_gudang_pusat = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->masuk;
	// 			$masuk_rajal = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->masuk;
	// 			$masuk_ugd  = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',3)->orderBy('created_at','DESC')->first()->masuk;
	// 			$masuk_kpr = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->masuk;


	// 			$data_stock[] = [
	// 				'nama' => $item->item->nama,
	// 				'masuk' => ((is_numeric($masuk_gudang_pusat) ? $masuk_gudang_pusat:0) + (is_numeric($masuk_rajal) ? $masuk_rajal: 0) + (is_numeric($masuk_ugd) ? $masuk_ugd:0) + (is_numeric($masuk_kpr) ? $masuk_kpr :0)),
	// 				'keluar' => $item->keluar,
	// 				'gudang_id' => $item->gudang_id,
	// 				'nama_gudang' => $item->gudang->nama,
	// 				'gudang_pusat' => number_format($gudang_pusat),
	// 				'rajal' => number_format($rajal),
	// 				'ugd' => number_format($ugd),
	// 				'kpr' => number_format($kpr),
	// 				// 'gudang_pusat' => $item->gudang_id,
	// 				'total' => ((is_numeric($gudang_pusat) ? $gudang_pusat:0) + (is_numeric($rajal) ? $rajal: 0) + (is_numeric($ugd) ? $ugd:0) + (is_numeric($kpr) ? $kpr :0)),
	// 				'keterangan' => $item->keterangan,
	// 			];
				
	// 		}
	// 		// dd($data_stock);

	// 		Excel::create('Logistik Kartu Stok ' . $obat, function ($excel) use ($obat,$data_stock) {
	// 			// Set the properties
	// 			$excel->setTitle('Logistik Kartu Stok ' . $obat)
	// 				->setCreator('Digihealth')
	// 				->setCompany('Digihealth')
	// 				->setDescription('Logistik Kartu Stok');
	// 			$excel->sheet('Logistik Kartu Stok', function ($sheet) use ($data_stock) {
	// 				$row = 1;
	// 				$no = 1;
	// 				$sheet->row($row, [
	// 					'Nomor',
	// 					'Nama Barang',
	// 					'Masuk',
	// 					'Gudang Pusat',
	// 					'Rajal',
	// 					'UGD',
	// 					'KPR',
	// 					'Total Stok',
	// 				]);
	// 				foreach ($data_stock as $st) {
	// 					$sheet->row(++$row, [
	// 						$no++,
	// 						$st['nama'],
	// 						$st['masuk'],
	// 						$st['gudang_pusat'],
	// 						$st['rajal'],
	// 						$st['ugd'],
	// 						$st['kpr'],
	// 						$st['total']
	// 					]);
	// 				}
	// 			});
	// 		})->export('xlsx');
	// 	} else if ($request['cetak']) {
	// 		$no = 1;
	// 		$pdf = PDF::loadView('logistik.logistikmedik.kartu_stok.cetakPdf', compact('stock', 'no', 'obat'));
	// 		$pdf->setPaper('A4', 'landscape');
	// 		return $pdf->download('lap_kunjungan.pdf');
	// 	}
	// 	$data_stock = [];
	// 	if ($stock) {
	// 		foreach($stock as $item){
	// 			$gudang_pusat = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->total;
	// 			$rajal = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->total;
	// 			$ugd  = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',3)->orderBy('created_at','DESC')->first()->total;
	// 			$kpr = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->total;
				
	// 			$masuk_gudang_pusat = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->masuk;
	// 			$masuk_rajal = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->masuk;
	// 			$masuk_ugd  = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',3)->orderBy('created_at','DESC')->first()->masuk;
	// 			$masuk_kpr = @LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])->where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->masuk;


	// 			$data_stock[] = [
	// 				'nama' => $item->item->nama,
	// 				'masuk' => ((is_numeric($masuk_gudang_pusat) ? $masuk_gudang_pusat:0) + (is_numeric($masuk_rajal) ? $masuk_rajal: 0) + (is_numeric($masuk_ugd) ? $masuk_ugd:0) + (is_numeric($masuk_kpr) ? $masuk_kpr :0)),
	// 				'keluar' => $item->keluar,
	// 				'gudang_id' => $item->gudang_id,
	// 				'nama_gudang' => $item->gudang->nama,
	// 				'gudang_pusat' => number_format($gudang_pusat),
	// 				'rajal' => number_format($rajal),
	// 				'ugd' => number_format($ugd),
	// 				'kpr' => number_format($kpr),
	// 				// 'gudang_pusat' => $item->gudang_id,
	// 				'total' => ((is_numeric($gudang_pusat) ? $gudang_pusat:0) + (is_numeric($rajal) ? $rajal: 0) + (is_numeric($ugd) ? $ugd:0) + (is_numeric($kpr) ? $kpr :0)),
	// 				'keterangan' => $item->keterangan,
	// 			];
				
	// 		}
	// 		// dd($data_stock);
	// 		return response()->json(['data' => $data_stock,'sukses'=>true]);;
	// 	} else {
	// 		return response()->json(['data' => $data_stock,'sukses'=>false]);
	// 	}
	// }

	public function datagelobalKartuStok(Request $request)
	{
		ini_set('max_execution_time', 900); // 5 minutes
 
		
		// dd([$awal,$akhir]);
		$stock = LogistikStock::orderBy('created_at','DESC');
		
		// dd($request['masterobat_id']);
		$obat = 'SEMUA OBAT';
		if($request['masterobat_id'] !== "all"){
			$stock->where('masterobat_id', $request['masterobat_id']);
			$obat	= Masterobat::find($request['masterobat_id'])->nama;
		
		}
		// $stock = $stock->get();
		$stock = $stock->groupBy('masterobat_id')->get();
		// dd($stock);
		// if()

		if ($request['excel']) {
			
			$data_stock = [];
			foreach($stock as $item){
				$gudang_pusat = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id', 8)->orderBy('created_at','DESC')->first()->total;
				$rajal = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',9)->orderBy('created_at','DESC')->first()->total;
				$ranap = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',10)->orderBy('created_at','DESC')->first()->total;
				$ugd  = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->total;
				$kpr = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->total;
				$ibs = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->total;
				
				$masuk_gudang_pusat = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',8)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_rajal = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',9)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_ranap = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',10)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_ugd  = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_kpr = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_ibs = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->masuk;


				$data_stock[] = [
					'nama' => $item->item->nama,
					'masuk' => ((is_numeric($masuk_gudang_pusat) ? $masuk_gudang_pusat:0) + (is_numeric($masuk_rajal) ? $masuk_rajal: 0) + (is_numeric($masuk_ranap) ? $masuk_ranap: 0) + (is_numeric($masuk_ugd) ? $masuk_ugd:0) + (is_numeric($masuk_ibs) ? $masuk_ibs :0)),
					'keluar' => $item->keluar,
					'gudang_id' => $item->gudang_id,
					'nama_gudang' => $item->gudang->nama,
					'gudang_pusat' => number_format($gudang_pusat),
					'rajal' => number_format($rajal),
					'ranap' => number_format($ranap),
					'ugd' => number_format($ugd),
					'ibs' => number_format($ibs),
					'kpr' => number_format($kpr),
					// 'gudang_pusat' => $item->gudang_id,
					'total' => ((is_numeric($gudang_pusat) ? $gudang_pusat:0) + (is_numeric($rajal) ? $rajal: 0) + (is_numeric($ranap) ? $ranap: 0) + (is_numeric($ugd) ? $ugd:0) + (is_numeric($ibs) ? $ibs :0)),
					'keterangan' => $item->keterangan,
				];
				
			}
			// dd($data_stock);

			Excel::create('Logistik Kartu Stok ' . $obat, function ($excel) use ($obat,$data_stock) {
				// Set the properties
				$excel->setTitle('Logistik Kartu Stok ' . $obat)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Logistik Kartu Stok');
				$excel->sheet('Logistik Kartu Stok', function ($sheet) use ($data_stock) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'Nomor',
						'Nama Barang',
						'Masuk',
						'Gudang Pusat',
						'Rajal',
						'Ranap',
						'UGD',
						'IBS',
						'Total Stok',
						'Keterangan',
					]);
					foreach ($data_stock as $st) {
						$sheet->row(++$row, [
							$no++,
							$st['nama'],
							$st['masuk'],
							$st['gudang_pusat'],
							$st['rajal'],
							$st['ranap'],
							$st['ugd'],
							$st['ibs'],
							$st['total'],
							$st['keterangan'],
						]);
					}
				});
			})->export('xlsx');
		} else if ($request['cetak']) {
			$no = 1;
			$pdf = PDF::loadView('logistik.logistikmedik.kartu_stok.cetakPdf', compact('stock', 'no', 'obat'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->download('lap_kunjungan.pdf');
		}
		$data_stock = [];
		if ($stock) {
			foreach($stock as $item){
				$gudang_pusat = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',8)->orderBy('created_at','DESC')->first()->total;
				$rajal = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',9)->orderBy('created_at','DESC')->first()->total;
				$ugd  = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->total;
				$kpr = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->total;
				$ranap = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',10)->orderBy('created_at','DESC')->first()->total;
				$ibs = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->total;
				
				$masuk_gudang_pusat = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',8)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_rajal = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',9)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_ugd  = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',1)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_kpr = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',4)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_ranap = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',10)->orderBy('created_at','DESC')->first()->masuk;
				$masuk_ibs = @LogistikStock::where('masterobat_id',$item->masterobat_id)->where('gudang_id',2)->orderBy('created_at','DESC')->first()->masuk;


				$data_stock[] = [
					'nama' => $item->item->nama,
					'masuk' => ((is_numeric($masuk_gudang_pusat) ? $masuk_gudang_pusat:0) + (is_numeric($masuk_rajal) ? $masuk_rajal: 0) + (is_numeric($masuk_ranap) ? $masuk_ranap: 0) + (is_numeric($masuk_ugd) ? $masuk_ugd:0) + (is_numeric($masuk_ibs) ? $masuk_ibs :0)),
					'keluar' => $item->keluar,
					'gudang_id' => $item->gudang_id,
					'nama_gudang' => $item->gudang->nama,
					'gudang_pusat' => is_numeric($gudang_pusat) ? $gudang_pusat : 0,
					'rajal' => is_numeric($rajal) ? $rajal : 0,
					'ranap' => is_numeric($ranap) ? $ranap : 0,
					'ugd' => is_numeric($ugd) ? $ugd : 0,
					'ibs' => is_numeric($ibs) ? $ibs : 0,
					// 'kpr' => number_format($kpr),
					// 'gudang_pusat' => $item->gudang_id,
					'total' => ((is_numeric($gudang_pusat) ? $gudang_pusat:0) + (is_numeric($rajal) ? $rajal: 0) + (is_numeric($ranap) ? $ranap: 0) + (is_numeric($ugd) ? $ugd:0) + (is_numeric($ibs) ? $ibs :0)),
					'keterangan' => $item->keterangan,
				];
				
			}
			// dd($data_stock);
			return response()->json(['data' => $data_stock,'sukses'=>true]);;
		} else {
			return response()->json(['data' => $data_stock,'sukses'=>false]);
		}
	}

	public function editLogistikID()
	{
		// $data['gudang']	= LogistikGudang::all();
		$data['stok']	= LogistikStock::where('logistik_batch_id',NULL)
		->where('created_at','LIKE','2020-04-01'.'%')
		->where('opname_id','!=',NULL)->get();
		// return $data;die;

		return view('logistik.logistikmedik.kartu_stok.edit-logistik-id', $data)->with('no',1);
	}
	public function updateLogistikID(Request $request, $id)
	{
		$batch_id = $request['logistik_batch_id'];
		$batch_no = $request['batch_no'];
		$stok = LogistikStock::find($id);
		$stok->logistik_batch_id = $batch_id;
		$stok->batch_no = $batch_no;
		$stok->update();
		Flashy::success('sukses update '.$batch_id.'  '.$batch_no);
		return redirect('logistikmedik/kartustok/edit-logistik-batch-id');
	}
}
