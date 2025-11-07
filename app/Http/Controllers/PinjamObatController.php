<?php

namespace App\Http\Controllers;

use App\Logistik\LogistikStock;
use App\Logistik\LogistikSupplier;
use App\LogistikBatch;
use App\LogistikPinjamObat;
use App\Masterobat;
use App\Satuanbeli;
use App\Rstujuanpinjam;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Validate;
use Auth;
use App\RincianPinjamObat;

class PinjamObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pinjamobat'] = LogistikPinjamObat::all();
        return view('logistik.logistikmedik.pinjamobat.index', $data)->with('no',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rspinjam'] = \App\Rstujuanpinjam::all();
		return view('logistik.logistikmedik.pinjamobat.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomorberita' => 'required',
            'pinjamdari' => 'required',
        ]);
       
		$date = date('Y-m-d', strtotime($request->tanggal));
        $data = New LogistikPinjamObat();
        $data->nomorberitaacara = $request->nomorberita;
        $data->pinjam_dari      = $request->pinjamdari;
        $data->tgl_pinjam       =  $date;
        //$data->user_id        =  Auth::user()->id;
        $data->save();
        // Flashy::success('Berhasil Simpan ')
        return redirect('/peminjaman/rincian/'.$data->id);
    }
    public function rincian($id)
    {
        $data['pinjamobat'] = LogistikPinjamObat::find($id);
        $data['rincian']    = RincianPinjamObat::where('logistik_pinjam_obat_id', $id)->get();
        $data['masterobat'] = Masterobat::all();
        $data['satuan']     = Satuanbeli::all();
		return view('logistik.logistikmedik.pinjamobat.rincian', $data)->with('no',1);
    }

    public function simpanRincian(Request $request)
    {
        // return $request->all();
        $masterobat = Masterobat::where('id', $request->masterobat_id)->first();
        $lnb = new \App\LogistikBatch();
        $lnb->gudang_id = Auth::user()->gudang_id;
        $lnb->user_id = Auth::user()->id;
        $lnb->nama_obat = $masterobat->nama;
        $lnb->bapb_id = NULL;
        $lnb->masterobat_id = $masterobat->id;
        $lnb->satuanbeli_id = $request['satuan'];
        $lnb->satuanjual_id = $request['satuan'];
        $lnb->supplier_id = NULL;
        $lnb->nomorbatch = $request['nomorbatch'];
        $lnb->expireddate = valid_date($request['expired']);
        $lnb->stok = $request['jumlah'];
        $lnb->jumlah_item_diterima = $request['jumlah'];
        $lnb->hargabeli = $request['hargabeli'];
        $lnb->hargajual_jkn   = $request['hargajual'];
        $lnb->hargajual_umum  = $request['hargajual'];
        $lnb->hargajual_dinas = $request['hargajual'];
        $lnb->save();

        $data = new RincianPinjamObat();
        $data->logistik_pinjam_obat_id = $request['pinjamobat_id'];
        $data->masterobat_id = $request->masterobat_id;
        $data->jumlah = $request->jumlah;
        $data->logistik_batch_id = $lnb->id;
        $data->save();


        $jumlah = LogistikBatch::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', Auth::user()->gudang_id)->sum('stok');
        $stock = new \App\Logistik\LogistikStock();
        $stock->gudang_id = Auth::user()->gudang_id;
        $stock->supplier_id = NULL;
        $stock->masterobat_id = $request['masterobat_id'];
        $stock->batch_no = $request['nomorbatch'];
        $stock->logistik_batch_id = $lnb->id;
        $stock->expired_date = valid_date($request['expired']);
        $stock->masuk = $request['jumlah'];
        $stock->periode_id = date('m');
        $stock->total = $jumlah + $request['terima'];
        $stock->rincianpinjam_id = $data->id;
        $stock->keterangan = 'Peminjaman Obat '.'| No. ' . $request['nomorberita']. ' '.$request['pinjamdari'];
        $stock->save();
        return redirect('peminjaman/rincian/'.$data->logistik_pinjam_obat_id)->with('no',1);
    }

    public function hapusObat($id)
    {
        $getrincian = RincianPinjamObat::where('id', $id)->first()->id;
        $logistikbatch = RincianPinjamObat::where('id', $id)->first()->logistik_batch_id;
        
        $rincian = RincianPinjamObat::find($id);
        $rincian->delete();

        $batch = LogistikBatch::find($logistikbatch)->delete();
        $stok = LogistikStock::where('rincianpinjam_id', $getrincian)->delete();
        
        Flashy::success('Rincian Obat berhasil dihapus');
        return redirect()->back();
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
        //
    }
}
