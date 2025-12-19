<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\BiayaInfus;
use Modules\Registrasi\Entities\BiayaInfusDetail;
use Flashy;
use Modules\Poli\Entities\Poli;

class BiayaPemeriksaanInfusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['biayapemeriksaan'] = BiayaInfus::with('detail')->get();
        return view('biayapemeriksaaninfus.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('biayapemeriksaaninfus.create');
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
        BiayaInfus::create($data);
        Flashy::success('Biaya Infus Telah Ditambahkan');
      return  redirect('/biayapemeriksaaninfus');
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
      $data['biayainfus'] = BiayaInfus::find($id);
      $data['biayapemeriksaan'] = BiayaInfusDetail::where('biaya_infus_id',$id)->orderBy('created_at','ASC')->get();
      $data['tarif'] = Tarif::where('jenis','TG')->groupBy('nama','total')->select('nama','total','id')->get();
      return view('biayapemeriksaaninfus.edit',$data);
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
      BiayaInfus::find($id)->update($data);
      Flashy::info('Data Biaya Infus berhasil di update');
      return redirect()->route('biayapemeriksaaninfus');
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
        $biaya = BiayaInfus::find($id);
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
      $biaya = BiayaInfus::find($id);
      $biayaDetail = new BiayaInfusDetail();
      $biayaDetail->biaya_infus_id = $biaya->id;
      $biayaDetail->tarif_id = $request->tarif_id;
      if ($biayaDetail->save()) {
        return response()->json(['sukses' => true]);
      }
      return response()->json(['sukses' => false]);
    }

    public function removeTarif($id)
    {
      if (BiayaInfusDetail::find($id)->delete()) {
        Flashy::success('Tarif berhasil dihapus');
        return redirect()->back();
      }
      Flashy::error('Tarif gagal dihapus');
      return redirect()->back();
    }
}
