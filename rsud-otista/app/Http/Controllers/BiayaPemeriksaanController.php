<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\BiayaPemeriksaan;
use Flashy;
use Modules\Poli\Entities\Poli;

class BiayaPemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['biayapemeriksaan'] = BiayaPemeriksaan::selectRaw('count(tarif_id) as tarif_id, tipe')->groupBy('tipe')->get();
        // dd($data['biayapemeriksaan']);
        return view('biayapemeriksaan.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tarif'] = Tarif::pluck('nama','id');
        $data['tahuntarif'] = Tahuntarif::pluck('tahun','id');
        return view('biayapemeriksaan.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request->all());
      $data = request()->validate([
        'tarif_id'=>'required',
        'tipe'=>'required',
        'pasien'=>'required',
        'poli_id'=>'sometimes',
      ]);
      // dd($data);
      $cek = BiayaPemeriksaan::where('tarif_id',$request->tarif_id)->where('poli_id',$request->poli_id)->where('pasien',$request->pasien)->where('tipe',$request->tipe)->first();
      if(!$cek){
        BiayaPemeriksaan::create($data);
        Flashy::success('Biaya Pemeriksaan Telah Ditambahkan');
      }else{
        Flashy::info('Biaya Pemeriksaan Sudah ada');
      }
      return  redirect()->back();
      // return redirect()->route('biayapemeriksaan');
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
      
      if($id == 'J'){
        $jenis = 'TA';
      }elseif($id == 'G'){
        $jenis = 'TG';
      }else{
        $jenis = 'TI';
      }
      // dd($jenis);
      $data['biayapemeriksaan'] = BiayaPemeriksaan::where('tipe',$id)->orderBy('pasien','ASC')->get();
      $data['tarif'] = Tarif::where('jenis',$jenis)->groupBy('nama','total')->select('nama','total','id')->get();
      $data['poli'] = Poli::pluck('nama','id');
      $data['jenis'] =$id;
      return view('biayapemeriksaan.edit',$data);
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
      $data = request()->validate(['tipe'=>'required']);
      BiayaPemeriksaan::find($id)->update($data);
      Flashy::info('Data Biaya Registrasi berhasil di update');
      return redirect()->route('biayapemeriksaan');
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
        BiayaPemeriksaan::find($id)->delete();
        Flashy::success('Tarif berhasil dihapus');
        return redirect()->back();
    }
}
