<?php

namespace App\Http\Controllers;
use Modules\Config\Entities\Kelompoktarif;
use Illuminate\Http\Request;
use Flashy;

class KelompoktarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kelompoktarif'] = Kelompoktarif::all();
        return view('kelompoktarif.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kelompoktarif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['kelompok'=>'required|unique:kelompoktarifs,kelompok']);
      Kelompoktarif::create($data);
      Flashy::success('Kelompok Tarif Telah Ditambahkan');
      return redirect()->route('kelompoktarif');
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
      $data['kelompoktarif'] = Kelompoktarif::find($id);
      return view('kelompoktarif.edit',$data);
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
      $data = request()->validate(['kelompok'=>'required|unique:kelompoktarifs,kelompok,'.$id]);
      Kelompoktarif::find($id)->update($data);
      Flashy::info('Data Kelompok Tarif berhasil di update');
      return redirect()->route('kelompoktarif');
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
