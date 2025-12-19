<?php

namespace App\Http\Controllers;

use App\Kategoriobat;
use App\Logistik\LogistikBatch;
use App\Logistik\LogistikStock;
use App\Logistik\Logistik_BAPB;
use App\Masterobat;
use App\Satuanbeli;
use App\Satuanjual;
use App\Supliyer;
use App\PenerimaanDetailProduks;
use DB;
use Excel;
use Auth;
use MercurySeries\Flashy\Flashy;
use Modules\Accounting\Entities\Master\AkunCOA;
use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogistikBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $masterobat = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->get();
            return DataTables::of($masterobat)
                ->addIndexColumn()
                ->addColumn('satuan_beli', function ($masterobat) {
                    return Satuanbeli::where('id', $masterobat->satuanbeli_id)->first()->nama;
                })
                ->addColumn('nomorbatch', function ($masterobat) {
                    return $masterobat->nomorbatch;
                })
                ->addColumn('satuan_jual', function ($masterobat) {
                    return Satuanjual::where('id', $masterobat->satuanjual_id)->first()->nama;
                })
                ->addColumn('harga_umum', function ($masterobat) {
                    return number_format($masterobat->hargajual_umum);
                })
                ->addColumn('harga_jkn', function ($masterobat) {
                    return number_format($masterobat->hargajual_jkn);
                })
                ->addColumn('harga_dinas', function ($masterobat) {
                    return number_format($masterobat->hargajual_dinas);
                })
                ->addColumn('harga_beli', function ($masterobat) {
                    return number_format($masterobat->hargabeli);
                })
                ->addColumn('aksi', function ($masterobat) {
                    return '<a onclick="edit(\'' . $masterobat->id . '\')" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>';
                    // return '<button type="button" onclick="cetak(\'' . $po->no_po . '\')" class="btn btn-sm btn-danger btn-flat" title="Edit"><i class="fa fa-print"></i></button>';
                })
                ->rawColumns(['aksi','satuan_beli','satuan_jual','harga_umum','harga_jkn','harga_dinas','harga_beli','nomorbatch'])
                ->make(true);
        }
        // return $masterobat; die;
        $data['satuanbeli'] = Satuanbeli::all();
		$data['satuanjual'] = Satuanjual::all();
        return view('masterbatch.index', $data);
    }

    public function import(Request $request)
	{
	    //dd('test import master logistic Bacth');
        //LogistikBatch
        //LogistikStock
        //Masterobat
        //Logistik_BAPB
        //PenerimaanDetailProduks
        //Supliyer

		ini_set('max_execution_time', 500); //300 seconds = 5 minutes
		ini_set('max_execution_time', 0); //0=NOLIMIT

		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		DB::beginTransaction();
		try {

			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
			})->get();

			$rowRules = [
				'kode_produk'  => 'required',
			];
			$data = [];

			 //Looping data
			// dd($excels);

			foreach ($excels as $row) {

				$validator = Validator::make($row->toArray(), $rowRules);
				if ($validator->fails()) {
					continue;
				}
            
                $stk        = PenerimaanDetailProduks::where('kode_produk', $row['kode_produk'])->first();
                if (!$stk) {
                }else{
                $nobapb     = $stk->kode_penerimaan;
                $stokobat   = $stk->stok;
                $obatkeluar = $stk->distribusi;
                }

               $bapb   = Logistik_BAPB::where('no_bapb', $nobapb)->first();

               if (!$bapb) {

                $supli     = '';
                $jmlterima = '';

               }else{
             
               $supli     = $bapb->saplier;
               $jmlterima = $bapb->jumlah_diterima;
               }

                //$satuan    = Masterobat::where('kode', $row['kode_produk'])->first();
               
                $sup       = Supliyer::where('nama', $supli)->first();
                if (!$sup) {
                    $IdSup     = '';
                }else{
                    $IdSup     = $sup->id;
                }

				// Satuan beli
				$satuanbeli = Satuanbeli::where('nama', $row['satuan'])->first();

				if (!$satuanbeli) {
					$sat       = new Satuanbeli();
					$sat->nama = $row['satuan'];
					$sat->save();
					$beli      = $sat->id;
				} else {
					$beli = $satuanbeli->id;
				}

				// Satuan Jual
				$satuanjual = Satuanjual::where('nama', $row['satuan'])->first();
				if (!$satuanjual) {
					$satj = new SatuanJual();
					$satj->nama = $row['satuan'];
					$satj->save();
					$jual = $satj->id;
				} else {
					$jual = $satuanjual->id;
				}

        
				$GetBatch = LogistikBatch::where('nama_obat', $row['nama_produk'])->first(); //Cek obat 
                
				if (!$GetBatch) { //Jika tiddk ada, buat baru

					$batch                = new LogistikBatch();
					$batch->masterobat_id = $row['kode_produk'];
					$batch->bapb_id       = $nobapb;
					$batch->nama_obat     = $row['nama_produk'];
					$batch->stok          = $stokobat;
					$batch->jumlah_item_diterima = $jmlterima;
					$batch->satuanbeli_id = $beli;
                    $batch->satuanjual_id = $jual;
                    $batch->gudang_id     = 01;
                    $batch->supplier_id   = $IdSup;
                    $batch->user_id       = 1;
                    $batch->nomorbatch    = $row['no_batch'];
                    $batch->expireddate    = $row['exdate'];
					$batch->hargabeli     = $row['harga'];
					$batch->hargajual_jkn = $row['harga'];
                    $batch->hargajual_umum  = $row['harga'];
					$batch->hargajual_dinas = $row['harga'];
					//$obat->hargabeli = $row['harga_beli'];
					$batch->save();
                    $logistikbatch       = $batch->id;

                    $stock = new LogistikStock();
                    $stock->opname_id     = $row['kode_produk'];
                    $stock->gudang_id     = 01;
                    $stock->supplier_id   = $IdSup;
                    $stock->periode_id    = '11';
					$stock->masterobat_id = $row['kode_produk'];
					$stock->batch_no      = $row['no_batch'];
                    $stock->logistik_batch_id = $logistikbatch;
                    $stock->expired_date    = $row['exdate'];
					$stock->masuk         = $jmlterima;
                    $stock->keluar        = $obatkeluar;
					$stock->total         = $stokobat;
                    $stock->user_id       = 1;
					$stock->save();

				} 

                 //Update Harga MasterObat After Insert Logistic Bacth
                 //$BC   = LogistikBatch::where('masterobat_id', $row['kode_produk'])->orderBy('masterobat_id', 'desc')->first();

                 //$Obat = Masterobat::where('kode', $BC->masterobat_id)->get();
                
                 $Obat['hargajual']       = $row['harga'];
                 $Obat['hargajual_jkn']   = $row['harga'];
                 $Obat['hargajual_kesda'] = $row['harga'];
                 $Obat['hargabeli']       = $row['harga'];
                
                 Masterobat::where('kode', $row['kode_produk'])->update($Obat);
 

			}

			DB::commit();
			Flashy::success('Obat Berhasil diimport');
			return redirect('masterobat-batches');
		} catch (Exception $e) {
			DB::rollback();

			Flashy::info('Gagal Import data');
			return redirect('masterobat-batches');
		}
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['satuanbeli'] = Satuanbeli::pluck('nama', 'id');
		$data['satuanjual'] = Satuanjual::pluck('nama', 'id');
		$data['kategoriobat'] = Kategoriobat::pluck('nama', 'id');

		$akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
		foreach ($akunCoa as $value) {
			$data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
		}

		return view('masterbatch.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsejenis_pemeriksaan
     */
    public function store(Request $request)
    {
        // return $request->all(); die;
        $cek = Validator::make($request->all(), [
            'expireddate' => 'required|string',
            'hargabeli' => 'required|string',
            'hargajual_jkn' => 'required|string',
            'hargajual_umum' => 'required|string',
            'hargajual_dinas' => 'required|string'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $LogistikBatch = new LogistikBatch();
            $LogistikBatch->nama_obat = $request['nama_obat'];
            $LogistikBatch->stok = $request['stok'];
            $LogistikBatch->satuanbeli_id = $request['satuanbeli_id'];
            $LogistikBatch->satuanjual_id = $request['satuanjual_id'];
            $LogistikBatch->nomorbatch = $request['nomorbatch'];
            $LogistikBatch->expireddate = $request['expireddate'];
            $LogistikBatch->hargabeli = $request['hargabeli'];
            $LogistikBatch->hargajual_jkn = $request['hargajual_jkn'];
            $LogistikBatch->hargajual_umum = $request['hargajual_umum'];
            $LogistikBatch->hargajual_dinas = $request['hargajual_dinas'];
            $LogistikBatch->save();
            return response()->json(['sukses' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $LogistikBatch = LogistikBatch::find($id);
        $gudang = baca_gudang_logistik($LogistikBatch->gudang_id);
        return response()->json(["LogistikBatch" => $LogistikBatch, "gudang" => $gudang]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'expireddate' => 'required|string',
            'hargabeli' => 'required|string',
            'hargajual_jkn' => 'required|string',
            'hargajual_umum' => 'required|string',
            'hargajual_dinas' => 'required|string'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $LogistikBatch = LogistikBatch::find($id);
            $LogistikBatch->nama_obat = $request['nama_obat'];
            $LogistikBatch->stok = $request['stok'];
            $LogistikBatch->satuanbeli_id = $request['satuanbeli_id'];
            $LogistikBatch->satuanjual_id = $request['satuanjual_id'];
            $LogistikBatch->nomorbatch = $request['nomorbatch'];
            $LogistikBatch->expireddate = $request['expireddate'];
            $LogistikBatch->hargabeli = $request['hargabeli'];
            $LogistikBatch->hargajual_jkn = $request['hargajual_jkn'];
            $LogistikBatch->hargajual_umum = $request['hargajual_umum'];
            $LogistikBatch->hargajual_dinas = $request['hargajual_dinas'];
            $LogistikBatch->update();
            return response()->json(['sukses' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function cek_batches(Request $request)
    {
        $data['masterobat'] = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->where('nomorbatch', $request['nomorbatch'])->get();
        // $data['masterobat'] = LogistikBatch::where('nomorbatch', $request['nomorbatch'])->get();
        $data['satuanbeli'] = Satuanbeli::all();
        $data['satuanjual'] = Satuanjual::all();
        // return $data; die;
        return view('masterbatch.cari', $data)->with('no', 1);
    }
}
