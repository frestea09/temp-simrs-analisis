<?php

namespace Modules\Pekerjaan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Flashy;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['pekerjaan'] = Pekerjaan::all();
        return view('pekerjaan::index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('pekerjaan::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:pekerjaans,nama']);
      Pekerjaan::create($data);
      Flashy::success('Pekerjaan Telah Ditambahkan');
      return redirect()->route('pekerjaan');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('pekerjaan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
      $data['pekerjaan'] = Pekerjaan::findOrFail($id);
        return view('pekerjaan::edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
      $data = request()->validate(['nama'=>'required|unique:pekerjaans,nama,'.$id]);
      Pekerjaan::find($id)->update($data);
      Flashy::info('Data Pekerjaan berhasil di update');
      return redirect()->route('pekerjaan');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
