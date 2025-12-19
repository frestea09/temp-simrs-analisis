<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
use PDF;

class LogistikNonMedikDistribusiController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permintaan = \App\LogistikNonMedik\LogistikNonMedikPermintaan::latest();
            return DataTables::of($permintaan)
                ->addIndexColumn()
                ->addColumn('asal', function ($permintaan) {
                    return baca_gudang($permintaan->gudang_asal);
                })
                ->addColumn('tujuan', function ($permintaan) {
                    return baca_gudang($permintaan->gudang_tujuan);
                })
                ->addColumn('aksi', function ($permintaan) {
                    return '<a href="' . route('proses-transfer', $permintaan->nomor) . '" class="btn btn-info btn-sm"><i class="fa fa-upload" target="_blank"></i></a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('logistik.logistiknonmedik.proses.add_transfer');
    }

    public function prosesTransfer($nomor)
    {
        $gudang = \App\LogistikNonMedik\LogistikNonMedikPermintaan::where('nomor', $nomor)->first();
        $data = \App\LogistikNonMedik\LogistikNonMedikPermintaan::where('nomor', $nomor)->get();
        $no_stok = 1;
        $no_barang = 1;
        $no_dikirim = 1;
        $no_permintaan = 1;
        $no_cek = 1;
        // return compact('data', 'gudang', 'no_stok', 'no_barang', 'no_dikirim', 'no_permintaan', 'no_cek'); die;
        return view('logistik.logistiknonmedik.proses.proses_transfer', compact('data', 'gudang', 'no_stok', 'no_barang', 'no_dikirim', 'no_permintaan', 'no_cek'))->with('no', 1);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

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
        //
    }
}
