<?php

namespace Modules\Perusahaan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Perusahaan\Entities\Perusahaan;
use Flashy;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      $data['perusahaan'] = Perusahaan::all();
        return view('perusahaan::index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('perusahaan::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:perusahaans,nama','kode'=>'required', 'id_prk'=>'required','alamat'=>'required','diskon'=>'required','plafon'=>'required']);
      Perusahaan::create($data);
      return redirect()->route('perusahaan');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('perusahaan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
      $data['perusahaan'] = Perusahaan::find($id);
        return view('perusahaan::edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
      $data = request()->validate(['nama'=>'required|unique:perusahaans,nama,'.$id,'kode'=>'required', 'id_prk'=>'required','alamat'=>'required','diskon'=>'required','plafon'=>'required']);
      Perusahaan::find($id)->update($data);
      Flashy::info('Data Perusahaan Berhasil Ditambahkan');
      return redirect()->route('perusahaan');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
