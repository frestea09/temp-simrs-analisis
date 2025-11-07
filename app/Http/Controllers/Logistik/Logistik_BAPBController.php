<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Flashy;

class Logistik_BAPBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        request()->validate(
            [
                'no_faktur' => 'required|unique:logistik_bapbs,no_faktur',
                'tanggal_faktur' => 'required',
            ],
            [
                'no_faktur.unique' => 'No Faktur Sudah Ada',
                'tanggal_faktur.required' => 'Tanggal Faktur Di Isi'
            ]
        );
        // return $request; die;
        $gudang         = Auth::user()->id;
        $items          = $request->item;
        $nama           = $request->nama;
        $satuan         = $request->satuan;
        $jumlah         = $request->jumlah;
        $kondisi        = $request->kondisi;
        $keterangan     = $request->keterangan;
        $suplier        = $request->suplier;
        $nomor          = $request->nomor;
        $nomor_po       = $request->no_po;
        $no_faktur      = $request->no_faktur;
        $jatuh_tempo    = $request->tanggal_jatuh_tempo;
        $tanggal_faktur = $request->tanggal_faktur;
        for ($a = 0; $a < count($items); $a++) {
            if (isset($kondisi[$a]) != '') {
                $bpab_id = 0;
                $cek = \App\Logistik\Logistik_BAPB::where(['no_po' => $nomor_po, 'nama' => $items[$a]])->first();
                $obat = \App\Logistik\Logistik_BAPB::where(['no_po' => $nomor_po, 'nama' => $items[$a]])->count();
                if ($cek) {
                    if ($obat > 0) {
                        $bpab   = new \App\Logistik\Logistik_BAPB();
                        $bpab->no_bapb              = $nomor;
                        $bpab->no_faktur            = $no_faktur;
                        $bpab->tanggal_faktur       = valid_date($tanggal_faktur);
                        $bpab->tanggal_jatuh_tempo  = valid_date($jatuh_tempo);
                        $bpab->no_po                = $nomor_po;
                        $bpab->saplier              = $suplier;
                        $bpab->nama                 = $nama[$a];
                        $bpab->satuan               = $satuan[$a];
                        $bpab->jumlah_dipesan              = $jumlah[$a];
                        $bpab->jumlah_diterima              = $kondisi[$a];
                        $bpab->keterangan           = 'Kiriman Ke '. ($obat+1).'';
                        $bpab->user_id              = $gudang;
                        $bpab->tanggal              = date('d-m-y');
                        $bpab->save();
                        $bpab_id = $bpab->id;
                    }else {
                        $bpab = \App\Logistik\Logistik_BAPB::find($cek->id);
                        $bpab->no_bapb              = $nomor;
                        $bpab->no_faktur            = $no_faktur;
                        $bpab->tanggal_faktur       = valid_date($tanggal_faktur);
                        $bpab->tanggal_jatuh_tempo  = valid_date($jatuh_tempo);
                        $bpab->no_po                = $nomor_po;
                        $bpab->saplier              = $suplier;
                        $bpab->nama                 = $nama[$a];
                        $bpab->satuan               = $satuan[$a];
                        $bpab->jumlah_dipesan               = $jumlah[$a];
                        $bpab->jumlah_diterima              = $kondisi[$a];
                        $bpab->keterangan           = $keterangan[$a];
                        $bpab->user_id              = $gudang;
                        $bpab->tanggal              = date('d-m-y');
                        $bpab->update();
                    }
                    $bpab_id = $cek->id;
                } else {
                    $bpab   = new \App\Logistik\Logistik_BAPB();
                    $bpab->no_bapb      = $nomor;
                    $bpab->no_faktur    = $no_faktur;
                    $bpab->tanggal_faktur = valid_date($tanggal_faktur);
                    $bpab->tanggal_jatuh_tempo  = valid_date($jatuh_tempo);
                    $bpab->no_po        = $nomor_po;
                    $bpab->saplier      = $suplier;
                    $bpab->nama         = $nama[$a];
                    $bpab->satuan       = $satuan[$a];
                    $bpab->jumlah_dipesan      = $jumlah[$a];
                    $bpab->jumlah_diterima      = $kondisi[$a];
                    $bpab->keterangan   = $keterangan[$a];
                    $bpab->user_id      = $gudang;
                    $bpab->tanggal      = date('d-m-y');
                    $bpab->save();
                    $bpab_id = $bpab->id;
                }
            }
        }
        session()->forget('nomor');
        return response()->json(['sukses' => true]);
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
        $data = \App\Logistik\Logistik_BAPB::find($id)->delete();
        Flashy::success('Berhasil Hapus Transaksi Berita Acara!');
        return redirect()->back();
    }
}
