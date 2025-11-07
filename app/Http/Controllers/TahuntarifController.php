<?php

namespace App\Http\Controllers;
use Modules\Config\Entities\Tahuntarif;
use Illuminate\Http\Request;
use Flashy;

class TahuntarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tahuntarif'] = Tahuntarif::all();
        return view('tahuntarif.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tahuntarif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['tahun'=>'required|unique:tahuntarifs,tahun']);
      Tahuntarif::create($data);
      Flashy::success('Tahun Tarif Telah Ditambahkan');
      return redirect()->route('tahuntarif');
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
      $data['tahuntarif'] = Tahuntarif::find($id);
      return view('tahuntarif.edit',$data);
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
      $data = request()->validate(['tahun'=>'required|unique:tahuntarifs,tahun,'.$id]);
      Tahuntarif::find($id)->update($data);
      Flashy::info('Data Tahun Tarif berhasil di update');
      return redirect()->route('tahuntarif');
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
