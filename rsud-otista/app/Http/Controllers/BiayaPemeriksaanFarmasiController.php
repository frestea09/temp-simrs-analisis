<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\Masterobat;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\BiayaFarmasi;
use Modules\Registrasi\Entities\BiayaFarmasiDetail;
use Flashy;
use Modules\Poli\Entities\Poli;

class BiayaPemeriksaanFarmasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['biayapemeriksaan'] = BiayaFarmasi::with('detail')->get();
        return view('biayapemeriksaanfarmasi.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('biayapemeriksaanfarmasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = request()->validate([
        'nama_biaya'=>'required',
      ]);
        BiayaFarmasi::create($data);
        Flashy::success('Biaya Farmasi Telah Ditambahkan');
      return  redirect('/biayapemeriksaanfarmasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data['biayafarmasi'] = BiayaFarmasi::find($id);
      $data['biayapemeriksaan'] = BiayaFarmasiDetail::where('biaya_farmasi_id',$id)->orderBy('created_at','ASC')->get();
      $data['obat'] = Masterobat::where('aktif','Y')->groupBy('nama','hargajual')->select('nama','hargajual','id')->get();
      return view('biayapemeriksaanfarmasi.edit',$data);
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
      $data = request()->validate(['nama_biaya'=>'required']);
      BiayaFarmasi::find($id)->update($data);
      Flashy::info('Data Biaya Farmasi berhasil di update');
      return redirect()->route('biayapemeriksaanfarmasi');
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
        $biaya = BiayaFarmasi::find($id);
        if ($biaya->detail) {
          foreach ($biaya->detail as $key => $item) {
            $item->delete();
          }
        }
        $biaya->delete();
        Flashy::success('Biaya pemeriksaan berhasil dihapus');
        return redirect()->back();
    }

    public function storeObat(Request $request, $id)
    {
      $biaya = BiayaFarmasi::find($id);
      $biayaDetail = new BiayaFarmasiDetail();
      $biayaDetail->biaya_farmasi_id = $biaya->id;
      $biayaDetail->masterobat_id = $request->masterobat_id;
      $biayaDetail->qty = $request->qty;
      $biayaDetail->obat_racikan = $request->obat_racikan;
      $biayaDetail->cara_minum = $request->cara_minum;
      $biayaDetail->informasi = $request->informasi;
      if ($biayaDetail->save()) {
        return response()->json(['sukses' => true]);
      }
      return response()->json(['sukses' => false]);
    }

    public function removeObat($id)
    {
      if (BiayaFarmasiDetail::find($id)->delete()) {
        Flashy::success('Obat berhasil dihapus');
        return redirect()->back();
      }
      Flashy::error('Obat gagal dihapus');
      return redirect()->back();
    }
}
