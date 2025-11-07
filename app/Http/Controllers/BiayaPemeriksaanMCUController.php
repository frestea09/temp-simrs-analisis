<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\BiayaMcu;
use Modules\Registrasi\Entities\BiayaMcuDetail;
use Flashy;
use Modules\Poli\Entities\Poli;

class BiayaPemeriksaanMCUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['biayapemeriksaan'] = BiayaMcu::with('detail')->get();
        return view('biayapemeriksaanmcu.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('biayapemeriksaanmcu.create');
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
        BiayaMcu::create($data);
        Flashy::success('Biaya MCU Telah Ditambahkan');
      return  redirect('/biayapemeriksaanmcu');
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
      $data['biayamcu'] = BiayaMcu::find($id);
      $data['biayapemeriksaan'] = BiayaMcuDetail::where('biaya_mcu_id',$id)->orderBy('created_at','ASC')->get();
      $data['tarif'] = Tarif::where('jenis','TA')->groupBy('nama','total')->select('nama','total','id')->get();
      return view('biayapemeriksaanmcu.edit',$data);
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
      BiayaMcu::find($id)->update($data);
      Flashy::info('Data Biaya MCU berhasil di update');
      return redirect()->route('biayapemeriksaanmcu');
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
        $biaya = BiayaMcu::find($id);
        if ($biaya->detail) {
          foreach ($biaya->detail as $key => $item) {
            $item->delete();
          }
        }
        $biaya->delete();
        Flashy::success('Biaya pemeriksaan berhasil dihapus');
        return redirect()->back();
    }

    public function storeTarif(Request $request, $id)
    {
      $biaya = BiayaMcu::find($id);
      $biayaDetail = new BiayaMcuDetail();
      $biayaDetail->biaya_mcu_id = $biaya->id;
      $biayaDetail->jenis = $request->jenis;
      $biayaDetail->tarif_id = $request->tarif_id;
      if ($biayaDetail->save()) {
        return response()->json(['sukses' => true]);
      }
      return response()->json(['sukses' => false]);
    }

    public function removeTarif($id)
    {
      if (BiayaMcuDetail::find($id)->delete()) {
        Flashy::success('Tarif berhasil dihapus');
        return redirect()->back();
      }
      Flashy::error('Tarif gagal dihapus');
      return redirect()->back();
    }
}
