<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogistikSpkController extends Controller
{
    
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $tab = new \App\Logistik\LogistikSpk();
        $tab->no_po         = $request['no_po'];
        $tab->nomor         = $request['nomor'];
        $tab->nama         = $request['nama'];
        $tab->nama_jabatan         = $request['nama_jabatan'];
        $tab->jabatan         = $request['jabatan'];
        $tab->alamat         = $request['alamat'];
        $tab->mengerjakan         = $request['mengerjakan'];
        $tab->terbilang         = $request['terbilang'];
        $tab->waktu_pelaksanaan     = $request['waktu_pelaksanaan'];
        $tab->waktu_hari           = $request['hari'];
        $tab->mulai_tanggal         = $request['mulai_tanggal'];
        if ($request['hari'] == 'hari') {
            $tab->sampai_tanggal         = date('d-m-Y', strtotime('+'.$request['waktu_pelaksanaan'].' days', strtotime($request['mulai_tanggal'])));
        }else{
            $tab->sampai_tanggal         = date('d-m-Y', strtotime('+' . $request['waktu_pelaksanaan'] . ' month', strtotime($request['mulai_tanggal'])));
        }
        $tab->anggaran                   = $request['anggaran'];
        $tab->kode_rekening              = $request['kode_rekening'];
        $tab->tahun_anggaran             = $request['tahun_anggaran'];
        $tab->pembayarana_pertama        = $request['pembayarana_pertama'];
        $tab->pembayarana_kedua          = $request['pembayarana_kedua'];
        $tab->pembayarana_ketiga         = $request['pembayarana_ketiga'];
        $tab->pembayarana_keempat        = $request['pembayarana_keempat'];
        $tab->total_pembayarana         = $request['pembayarana_pertama']+ $request['pembayarana_kedua']+ $request['pembayarana_ketiga']+$request['pembayarana_keempat'];
        $tab->save();
        return response()->json(['sukses' => true]);
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

    public function editSpk($no_faktur, $masterobat_id)
    {
        $penerimaan = \App\Logistik\LogistikPenerimaan::where('no_faktur', 'LIKE', '%' . $no_faktur . '%')
            ->where('masterobat_id', 'LIKE', '%' . $masterobat_id . '%')
            ->first();
        return response()->json(['penerimaan' => $penerimaan]);
    }

    public function saveEditSpk(Request $request)
    {
        $penerimaan = \App\Logistik\LogistikPenerimaan::where('no_faktur', 'LIKE', '%' . $request['no_faktur'] . '%')
            ->where('masterobat_id', 'LIKE', '%' . $request['masterobat_id'] . '%')
            ->first();
        $penerimaan->hpp = $request['hpp'];
        $penerimaan->update();
        return response()->json(['sukses' => true]);
    }

    public function saveEdit(Request $request)
    {
        $tab = \App\Logistik\LogistikSpk::find($request['id']);
        $tab->no_po         = $request['no_po'];
        $tab->nomor         = $request['nomor'];
        $tab->nama         = $request['nama'];
        $tab->nama_jabatan         = $request['nama_jabatan'];
        $tab->jabatan         = $request['jabatan'];
        $tab->alamat         = $request['alamat'];
        $tab->mengerjakan         = $request['mengerjakan'];
        $tab->terbilang         = $request['terbilang'];
        $tab->waktu_pelaksanaan         = $request['waktu_pelaksanaan'];
        $tab->mulai_tanggal         = $request['mulai_tanggal'];
        $tab->sampai_tanggal         = $request['sampai_tanggal'];
        $tab->anggaran         = $request['anggaran'];
        $tab->kode_rekening         = $request['kode_rekening'];
        $tab->tahun_anggaran         = $request['tahun_anggaran'];
        $tab->pembayarana_pertama         = $request['pembayarana_pertama'];
        $tab->pembayarana_kedua         = $request['pembayarana_kedua'];
        $tab->pembayarana_ketiga         = $request['pembayarana_ketiga'];
        $tab->pembayarana_keempat         = $request['pembayarana_keempat'];
        $tab->total_pembayarana         = $request['pembayarana_pertama'] + $request['pembayarana_kedua'] + $request['pembayarana_ketiga'] + $request['pembayarana_keempat'];
        $tab->update();
        return response()->json(['sukses' => true]);
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
