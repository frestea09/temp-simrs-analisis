<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logistik\LogistikGudang;
use App\Logistik\LogistikPeriode;
use App\Kategoriobat;
use App\Logistik\LogistikStock;
use App\Logistik\Logistik_BAPB;
use App\Masterobat;
use App\LogistikOpname;
use App\Logistik\Po;
use Flashy;
use Excel;
use PDF;
use Auth;
use DB;
use Yajra\DataTables\DataTables;
use App\LogistikBatch;
use App\Logistik\LogistikSupplier;
use App\Satuanbeli;
use App\Satuanjual;
use Validator;

class OpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function stokOpname($id=""){
        $data['periode']    = LogistikPeriode::pluck('nama', 'id');
        $data['gudang']     = LogistikGudang::find(Auth::user()->gudang_id);
        $data['kategori']   = Kategoriobat::pluck('nama', 'id');
        $data['supplier']   = LogistikSupplier::all();
        $data['satuanbeli']   = Satuanbeli::all();
        $data['satuanjual']   = Satuanjual::all();

        // $data['obat']    = Masterobat::all('nama', 'id');
        $data['masterobat']    = Masterobat::find($id);
        $data['batch']    = LogistikBatch::where('masterobat_id', $id)->where('gudang_id',Auth::user()->gudang_id)->get();
        // return $data; die;
        if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
            return view('logistik.logistikmedik.opname.stokopname', $data)->with('no',1);
		}
    }

    public function deleteOpname( Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $query = LogistikBatch::where('id',$id)->first();
        $res = [
            "status" => true,
            "msg" => "Berhasil Menghapus data"
        ];
        if($query){
            $query->delete();
            return response()->json($res);
        }else{
            $res = [
                "status" => false,
                "msg" => "Ada stok obat, tidak bisa hapus"
            ];
            return response()->json($res);
        }
        
        // if( $user_id == config('app.user_gudang') ){ // user fitra
        //     $query->where('gudang_id',1);
        //     $query->delete();
        //     return response()->json($res);
        // }elseif( $user_id == config('app.user_farmasi') ){ // user fatur
        //     $query->where('gudang_id',2);
        //     $query->delete();
        //     return response()->json($res);
        // }elseif( $user_id == 1 ){ // admin
        //     $query->delete();
        //     return response()->json($res);
        // }   
        // $res = [
        //     "status" => false,
        //     "msg" => "Akses Tidak Diijinkan"
        // ];
        // return response()->json($res);
    }

    public function addOpname(Request $request){
        // return $request->all(); die;
        $periode        = $request->periode;
        $gudang         = Auth::user()->gudang_id;
        $kategori       = $request->kategori;
        $tanggal        = $request->tanggal;

        $obat_id        = $request->obat_id;
        $items          = $request->item;
        $stok_tercatat  = $request->stok_tercatat;
        $stok_sebenarnya= $request->stok_sebenarnya;
        $keterangans    = $request->keterangan;
        if(isset($obat_id)){
            if($tanggal != '') {
                foreach($request->stok_sebenarnya as $k => $v){
                    if($v != '') {
                       $cek = LogistikOpname::where(['periode' => $periode, 'obat_id' => $k, 'gudang' => $gudang])->first();
                        if ($cek) {
                            $opname = LogistikOpname::find($cek->id);
                            $opname->stok_sebenarnya   = $v;
                            $opname->update();
                            $opname_id = $cek->id;
                        }else{
                            $obat = Masterobat::where(['id' => $k])->first();

                            $Opname = new LogistikOpname();
                            $Opname->periode           = $periode;
                            $Opname->kategori          = $kategori;
                            $Opname->obat_id           = $k;
                            $Opname->nama_item         = $obat->nama;
                            $Opname->tanggalopname     = $tanggal;
                            $Opname->gudang            = $gudang;
                            $Opname->stok_tercatat     = $obat->saldo;
                            $Opname->stok_sebenarnya   = $v;
                            // $Opname->keterangan        = $keterangans[$a];
                            $Opname->user_id           = Auth::user()->id;
                            $Opname->save();
                            $opname_id = $Opname->id;

                            //Kurangi Saldo
                            if (Auth::user()->gudang_id == 2) {
                                $obat->saldo = $v;
                                $obat->update();
                            }
                        }

                        $logistik = LogistikStock::where(['gudang_id' => $gudang, 'masterobat_id' => $k])->get();
                        $total = $logistik->sum('masuk') - $logistik->sum('keluar');

                        $stocks = new LogistikStock();
                        $stocks->opname_id  = $opname_id;
                        $stocks->gudang_id = $gudang;
                        $stocks->periode_id = $periode;
                        $stocks->masterobat_id = $k;
                        $stocks->masuk = 0;
                        $stocks->keluar = 0;
                        $stocks->total = $v;
                        $stocks->keterangan = 'Opname '.$tanggal;
                        $stocks->user_id    = Auth::user()->id;
                        $stocks->save();
                    }
                }
                Flashy::info('Tanggal opname berhasil disimpan !');
            }else{
                Flashy::warning('Tanggal opname tidak boleh kosong !');
            }
        }else{
            Flashy::warning('Filter belum dipilih !');
        }
        return redirect('logistikmedik/stok-opname');
    }

    public function getObat($id)
    {
        session(['master_obat' => $id]);
        $cek_data = LogistikBatch::where('masterobat_id', $id)->count();
        if ($cek_data > 0) {
            $waktu = date('Y-m-d');
            $data['obat'] = LogistikBatch::where('masterobat_id', $id)->get();
            $data['opname'] = LogistikOpname::where('obat_id', $id)
            ->where('gudang', Auth::user()->gudang_id)
            ->where('created_at', 'like', '%'.$waktu.'%')
            ->first();
            $data['count_opname'] = LogistikOpname::where('obat_id', $id)
            ->where('gudang', Auth::user()->gudang_id)
            ->where('created_at', 'LIKE', '%'.$waktu.'%')
            ->count();
            // return $data; die;
        } else {
            return response()->json(['sukses' => false ]);
        }

        // return $data; die;

        // return view('logistik.logistikmedik.opname.getObat', compact('obat', 'per'))->with('no', 1);
        return view('logistik.logistikmedik.opname.getObat', $data)->with('no', 1);
    }

    public function laporanOpname(Request $request){
        //Auth::user()->gudang_id
        $idGudang = $request->gudang;
        $data['periode']   = LogistikPeriode::all();
        $data['bcgudang']  = LogistikGudang::find(Auth::user()->gudang_id);
        $data['gudang']    = LogistikGudang::pluck('nama', 'id');
        //return $data; die;
        return view('logistik.logistikmedik.laporan.laporanopname', $data);
    }

    public function getOpname($periode, $gudang){
        $data['bcgudang']  = LogistikGudang::where('id',$gudang)->first();
        //$opnames = LogistikOpname::where(['periode' => $periode, 'gudang' => $gudang])->get();
        // $opnames = LogistikOpname::where('gudang', $gudang)->where('created_at','like',date('Y-m').'%')->get();
        $opnames = LogistikOpname::where('gudang', $gudang)->where('created_at','like',date('Y-m').'%')->get();
        return view('logistik.logistikmedik.laporan.getDataOpname', compact('opnames'))->with('no', 1);
    }

    public function getOpnameEdit($id){
        $opnames = LogistikOpname::where('id', $id)->first();
        return response()->json(['sukses' => false, 'opnames' => $opnames]);
    }

    public function saveOpnameEdit(Request $request){
        return $request->all();
        $opname = LogistikOpname::find($request['id']);
        // $opname->periode   = $request['periode'];
        $opname->stok_tercatat   = $request['stok_sebenarnya'];
        $opname->stok_sebenarnya   = $request['stok_sebenarnya'];
        $opname->update();

        $stock = \App\Logistik\LogistikStock::where('opname_id', $request['id'])->first();
        $stock->periode_id = $request['periode'];
        $stock->total = $request['stok_sebenarnya'];
        $stock->update();

        return response()->json(['sukses' => true ]);
    }

    //Laporan Persediaan
    public function lappersediaanstok(){

        dd("View Lap Persediaan Barang");
    }

    //Laporan Stok
    public function export(Request $request){

        request()->validate([
			'tglAwal' => 'required',
			'tglAkhir' => 'required',
		]);

        $data['gudang']    = LogistikGudang::pluck('nama', 'id');
		$tglAwal      = valid_date($request['tglAwal']) . ' 00:00:00';
		$tglAkhir     = valid_date($request['tglAkhir']) . ' 23:59:59';
		$apotikjalan  = $request['apotikjalan'];
        $apotikinap   = $request['apotikinap'];
		$apotikigd    = $request['apotikigd'];
        //dd($apotikjalan ,$apotikinap,$apotikigd );
        $gudang = $request['gudang'];
		$data['tgl1'] = $request['tglAwal'];
		$data['tgl2'] = $request['tglAkhir'];
        // if($request['tampil']){
        //     $opnames = LogistikOpname::where('gudang', $request->gudang)->where('created_at','like',date('Y-m').'%')->get();
        //     return view('logistik.logistikmedik.laporan.getDataOpname', compact('opnames'))->with('no', 1);
        // }
        // $opnames = LogistikOpname::where(['periode' => $request->periode, 'gudang' => Auth::user()->gudang_id])->get();
        //$opnames = LogistikOpname::where('gudang', Auth::user()->gudang_id)->where('created_at','like',date('Y-m').'%')->get();

        $data['opnames'] = LogistikOpname::join('logistik_stocks', 'logistik_opnames.id', '=', 'logistik_stocks.opname_id')
                        ->join('masterobats','logistik_stocks.masterobat_id', '=', 'masterobats.id')
                        ->join('logistik_batches','logistik_opnames.logistik_batch_id', '=', 'logistik_batches.id')
                        ->whereBetween('logistik_opnames.created_at', [$tglAwal, $tglAkhir])
                        ->groupBy('logistik_stocks.masterobat_id')
                        ->select('masterobats.nama','masterobats.satuanjual_id','logistik_stocks.masuk','logistik_stocks.keluar','logistik_opnames.stok_tercatat as awal',
                        'logistik_opnames.tanggalopname','logistik_batches.hargajual_umum',DB::raw('sum(logistik_batches.hargajual_umum) as jumlah_harga'),
                        'logistik_stocks.expired_date','logistik_opnames.gudang','logistik_stocks.keterangan','logistik_opnames.stok_sebenarnya as sisa');
                        if(isset($gudang)){
                            $data['opnames']   = $data['opnames']->where('logistik_stocks.gudang_id', $gudang);
                        }
                        // if(isset($apotikinap)){
                        //     $data['opnames']   = $data['opnames']->where('logistik_stocks.gudang_id', $apotikinap);
                        // }
                        // if(isset($apotikigd)){
                        //     $data['opnames']   = $data['opnames']->where('logistik_stocks.gudang_id', $apotikigd);
                        // }
                      $data['opnames'] = $data['opnames']->get();
                      
       if ($request['tampil']) {
        return view('logistik.logistikmedik.laporan.laporanopname', $data);

       }elseif ($request['pdf']) {
          //dd('cetak pdf');
			$pdf = PDF::loadView('logistik.logistikmedik.laporan.pdf_lap_opname', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
       } elseif ($request['excel']) {
        //dd('cetak excel');
        Excel::create('Lap Stok Opname', function ($excel) use ($data) {
            // Set the properties
            $excel->setTitle('Lap Stok Opname')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Lap Stok Opname');
            $excel->sheet('Lap Stok Opname', function ($sheet) use ($data) {
                $row = 1;
                $no  = 1;
                $sheet->row($row, [
                    'No',
                    'Uraian Persediaan',
                    'Satuan',
                    'Awal',
                    'Masuk',
                    'Keluar',
                    'Sisa',
                    'Selisih',
                    'Harga Satuan (Rp)',
                    'Jumlah Harga (Rp)',
                    'Harga Selisih (Rp)',
                    'Expired',
                    'Keterangan',
                    'Tanggal Opname',
                    'Gudang',
                ]);
                foreach ($data['opnames'] as $key => $d) {
                    $sheet->row(++$row, [
                        $no++,
                        @$d->nama,
                        @baca_satuan_jual($d->satuanjual_id),
                        @$d->awal,
                        @$d->masuk,
                        @$d->keluar,
                        @$d->sisa,
                        @$d->awal - @$d->sisa,
                        @$d->hargajual_umum,
                        @$d->jumlah_harga*@$d->sisa,
                        @$d->hargajual_umum,
                        @$d->expired_date,
                        @$d->keterangan,
                        @$d->tanggalopname,
                        baca_gudang_logistik(@$d->gudang),
                    ]);
                }
            });
        })->export('xlsx');
    }
        // if($request['excel']){
        //     Excel::create('Laporan Stok Opname', function ($excel) use ($opnames) {
		// 		// Set the properties
		// 		$excel->setTitle('Laporan  Stok Opname')
		// 			->setCreator('Digihealth')
		// 			->setCompany('Digihealth')
		// 			->setDescription('Laporan  Stok Opname');
		// 		$excel->sheet('Laporan  Stok Opname', function ($sheet) use ($opnames) {
		// 			$row = 1;
		// 			$no = 1;
		// 			$sheet->row($row, [
		// 				'No',
		// 				'Tanggal Opname',
		// 				'Nama Item',
		// 				'Stok Tercatat',
		// 				'Masuk',
		// 				'Keluar',
		// 				'Stok Sisa',
		// 				'Keterangan'
		// 			]);
        //             foreach($opnames as $opname){
        //                 $sheet->row(++$row, [
        //                     $no++,
        //                     $opname->tanggalopname,
        //                     $opname->nama_item,
        //                     $opname->stok_tercatat,
        //                     opnameMasuk($opname->id),
        //                     opnameKeluar($opname->id),
        //                     $opname->stok_sebenarnya,
        //                     $opname->keterangan
        //                 ]);
        //             }
        //         });
		// 	})->export('xlsx');
        // }else{
        //     $no = 1;
        //     $pdf = PDF::loadView('logistik.logistikmedik.laporan.pdf_laporan_opname', compact('opnames', 'no'));
		// 	$pdf->setPaper('A4', 'landscape');
        //     return $pdf->download('lap_kunjungan.pdf');
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        return $request->all(); die;
        $stok   = $request['stok'];
        $expired = $request['expired'];
        $keterangan = $request['keterangan'];
        $id = $request['id'];
        $cek = Validator::make($request->all(), [
            'stok' => 'required'
            ]);
            if($cek->fails()){
                return response()->json(['success' => false, 'error' => $cek->errors()]);
            }else{
            DB::transaction(function () use ($stok, $expired, $keterangan, $id) {
                $b = LogistikBatch::find($id);
                $b->stok            = $stok;
                $b->expireddate     = $expired;
                $b->gudang_id       = Auth::user()->gudang_id;
                $b->user_id         = Auth::user()->id;
                $b->update();

                $obat = Masterobat::where('id', $b->masterobat_id)->first();

                $Opname = new LogistikOpname();
                $Opname->logistik_batch_id = $id;
                $Opname->periode           = 0;
                $Opname->kategori          = $obat->kategoriobat_id;
                $Opname->obat_id           = $b->masterobat_id;
                $Opname->nama_item         = $obat->nama;
                $Opname->tanggalopname     = date('Y-m-d') . ' ' . date('H:i:s');
                $Opname->gudang            = Auth::user()->gudang_id;
                $Opname->stok_tercatat     = $stok;
                $Opname->stok_sebenarnya   = $stok;
                $Opname->keterangan        = $keterangan;
                $Opname->user_id           = Auth::user()->id;
                $Opname->save();
                $opname_id = $Opname->id;

                $stocks = new LogistikStock();
                $stocks->opname_id  = $opname_id;
                $stocks->gudang_id = Auth::user()->gudang_id;
                $stocks->periode_id = 0;
                $stocks->masterobat_id = $b->masterobat_id;
                $stocks->masuk = 0;
                $stocks->keluar = 0;
                $stocks->total = $stok;
                $stocks->keterangan = 'Opname '.date('Y-m-d').', '.$keterangan;
                $stocks->save();
            });
            $b = LogistikBatch::find($id);
            return response()->json(['success' => true, 'obat' =>$b->masterobat_id]);
        }
    }

    public function saveOpname(Request $request, $id)
    {
        request()->validate(['stok_opname'=>'required']);
        // return $request->all(); die;

            // DB::transaction(function () use ($stok, $expired, $keterangan, $id) {
                $b = LogistikBatch::find($id);
                $b->stok            = $request['stok_opname'];
                $b->update();

                $obat = Masterobat::where('id', $request['masterobat_id'])->first();

                $Opname = new LogistikOpname();
                $Opname->logistik_batch_id = $id;
                $Opname->periode           = 0;
                $Opname->kategori          = $obat->kategoriobat_id;
                $Opname->obat_id           = $request['masterobat_id'];
                $Opname->nama_item         = $request['namaobat'];
                $Opname->tanggalopname     = date('Y-m-d') . ' ' . date('H:i:s');
                $Opname->gudang            = Auth::user()->gudang_id;
                $Opname->stok_tercatat     = $request['stok_tercatat'];
                $Opname->stok_sebenarnya   = $request['stok_opname'];
                $Opname->keterangan        = $request['keterangan'];
                $Opname->user_id           = Auth::user()->id;
                $Opname->save();

                $opname_id = $Opname->id;

                $totalstok = LogistikBatch::where('masterobat_id', $request['masterobat_id'])->where('gudang_id',Auth::user()->gudang_id)->sum('stok');

                $stocks = new LogistikStock();
                $stocks->opname_id  = $opname_id;
                $stocks->gudang_id = Auth::user()->gudang_id;
                $stocks->periode_id = 0; // bln sekarang
                $stocks->expired_date = $b->expired_date;
                $stocks->masterobat_id = $b->masterobat_id;
                $stocks->masuk = 0;
                $stocks->keluar = 0;
                $stocks->total = $totalstok;
                $stocks->logistik_batch_id = $b->id;
                $stocks->batch_no = $b->nomorbatch;
                $stocks->keterangan = 'Opname '.date('Y-m-d').', '.'Batch: '.$request['nomorbatch'];
                $stocks->save();
            // });
  		    Flashy::success('Opname Berhasil Disimpan');

            return redirect('/logistikmedik/stok-opname/'.$obat->id);

        // }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LogistikOpname::where('id', $id)->delete();
        return redirect()->back();
    }

    public function saveBatch(Request $request){
        // return $request->all(); die;
        $cek = Validator::make($request->all(), [
			
            'stok' => 'required',
            
            'hargabeli' => 'required',
            'hargajualumum' => 'required',
            'hargajualdinas' => 'required',
            // 'supplier_id' => 'required',
			'hargajualjkn' => 'required'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
                DB::beginTransaction();
                
                $b = New LogistikBatch();
                $b->masterobat_id   = $request['masterobat_id'];
                $b->nama_obat       = $request['nama_obat'];
                $b->satuanjual_id   = $request['satuanjual_id'];
                $b->satuanbeli_id   = $request['satuanbeli_id'];
                $b->nomorbatch      = $request['nomor_batch'];
                $b->stok            = $request['stok'];
                $b->expireddate     = $request['expired_date'];
                $b->supplier_id     = $request['supplier_id'];
                $b->hargabeli       = $request['hargabeli'];
                $b->hargajual_umum  = $request['hargajualumum'];
                $b->hargajual_jkn   = $request['hargajualjkn'];
                $b->hargajual_dinas = $request['hargajualdinas'];
                $b->gudang_id       = Auth::user()->gudang_id;
                $b->user_id         = Auth::user()->id;
                $b->save();
                $obat = Masterobat::where('id', $b->masterobat_id)->first();
                
                $Opname = new LogistikOpname();
                $Opname->logistik_batch_id = $b->id;
                $Opname->periode           = 0;
                $Opname->kategori          = $obat->kategoriobat_id;
                $Opname->obat_id           = $b->masterobat_id;
                $Opname->nama_item         = $obat->nama;
                $Opname->tanggalopname     = date('Y-m-d') . ' ' . date('H:i:s');
                $Opname->gudang            = Auth::user()->gudang_id;
                $Opname->stok_tercatat     = $b->stok;
                $Opname->stok_sebenarnya   = $b->stok;
                $Opname->keterangan        = 'Tambah Batch';
                $Opname->user_id           = Auth::user()->id;
                $Opname->save();
                $opname_id = $Opname->id;

                
                $stocks = new LogistikStock();
                $stocks->opname_id  = $opname_id;
                $stocks->gudang_id = Auth::user()->gudang_id;
                $stocks->periode_id = 0;
                $stocks->masterobat_id = $b->masterobat_id;
                $stocks->masuk = 0;
                $stocks->keluar = 0;
                $stocks->total = $b->stok;
                $stocks->keterangan = 'Opname '.date('Y-m-d').', '.'TambahBatch';
                $stocks->save();
                DB::commit();
                return response()->json(['success' => true]);
        }
    }

    public function simpanEditBatch(Request $request){
        // return $request->all(); die;
        $cek = Validator::make($request->all(), [
			
            'stok' => 'required',
          
            'hargabeli' => 'required',
            'hargajualumum' => 'required',
            'hargajualdinas' => 'required',
            // 'supplier_id' => 'required',
			'hargajualjkn' => 'required'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
                $b = LogistikBatch::find($request['id']);
                $b->masterobat_id   = $request['masterobat_id'];
                $b->nama_obat       = $request['nama_obat'];
                $b->satuanjual_id   = $request['satuanjual_id'];
                $b->satuanbeli_id   = $request['satuanbeli_id'];
                $b->nomorbatch      = $request['nomor_batch'];
                $b->stok            = $request['stok'];
                $b->expireddate     = $request['expired_date'];
                $b->supplier_id     = $request['supplier_id'];
                $b->hargabeli       = $request['hargabeli'];
                $b->hargajual_umum  = $request['hargajualumum'];
                $b->hargajual_jkn   = $request['hargajualjkn'];
                $b->hargajual_dinas = $request['hargajualdinas'];
                $b->gudang_id       = Auth::user()->gudang_id;
                $b->user_id         = Auth::user()->id;
                $b->update();

                $Opname = LogistikOpname::where('created_at','like',date('Y-m').'%')->where('logistik_batch_id', $request['id'])->first();
                $Opname->tanggalopname     = date('Y-m-d') . ' ' . date('H:i:s');
                $Opname->gudang            = Auth::user()->gudang_id;
                $Opname->stok_sebenarnya     = $request['stok'];
                $Opname->update();

                $stocks = LogistikStock::where('logistik_batch_id', $request['id'])->first();
                $stocks->total = $request['stok'];
                $stocks->update();

                // opname where nomer

                // kartu stok where id opname


                return response()->json(['success' => true]);
        }
    }

    public function namaObatBatch($obat_id, $id)
    {
        $berita_acara  = Logistik_BAPB::where('id', $id)->first();
        $po            = Po::where('no_po', $berita_acara->no_po)->first();
        $obat = Masterobat::where('id',$obat_id)->first();
        $satuan_beli = @baca_satuan_beli(@$obat->satuanbeli_id);
        $satuan_jual = @baca_satuan_jual(@$obat->satuanjual_id);
        return response()->json(['obat' => $obat, 'beli' => $satuan_beli, 'jual' => $satuan_jual, 'berita_acara' => $berita_acara, 'po' => $po]);
    }

    public function addNamaObatBatch($obat_id)
    {
        $obat = Masterobat::where('id', $obat_id)->first();
        $satuan_beli = @baca_satuan_beli(@$obat->satuanbeli_id);
        $satuan_jual = @baca_satuan_jual(@$obat->satuanjual_id);
        $date = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime($date. ' + 6 months'));
        // if(!$obat->expireddate){
        //     $newDate = $obat->expireddate;
        // }else{}
        return response()->json(['obat' => $obat, 'beli' => $satuan_beli, 'jual' => $satuan_jual,'newdate' => $newDate]);
    }

    public function editBatch($id)
    {
        $obat = LogistikBatch::where('id', $id)->first();
        $nama = baca_obat($obat->satuanjual_id);
        $date = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime($date. ' + 6 months'));
        return response()->json(['obat' => $obat, 'nama' => $nama,'newdate' => $newDate]);
    }
}
