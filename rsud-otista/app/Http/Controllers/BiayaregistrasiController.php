<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Flashy;

class BiayaregistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['biayaregistrasi'] = Biayaregistrasi::all();
        return view('biayaregistrasi.index',$data)->with('no', 1);
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
        return view('biayaregistrasi.create',$data);
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
        'tipe'=>'required',
        'tarif_id'=>'required',
        'shift'=>'required',
        'tahuntarif_id'=>'required',
      ]);
      Biayaregistrasi::create($data);
      Flashy::success('Biaya Registrasi Telah Ditambahkan');
      return redirect()->route('biayaregistrasi');
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
      $data['biayaregistrasi'] = Biayaregistrasi::find($id);
      $data['tarif'] = Tarif::pluck('nama','id');
      $data['tahuntarif'] = Tahuntarif::pluck('tahun','id');
      return view('biayaregistrasi.edit',$data);
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
      Biayaregistrasi::find($id)->update($data);
      Flashy::info('Data Biaya Registrasi berhasil di update');
      return redirect()->route('biayaregistrasi');
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
