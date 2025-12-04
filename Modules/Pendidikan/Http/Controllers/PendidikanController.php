<?php

namespace Modules\Pendidikan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pendidikan\Entities\Pendidikan;
use Flashy;


class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['pendidikan'] = Pendidikan::all();
        return view('pendidikan::index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('pendidikan::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['pendidikan'=>'required|unique:pendidikans,pendidikan']);
      Pendidikan::create($data);
      Flashy::success('Pendidikan Telah Ditambahkan');
      return redirect()->route('pendidikan');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('pendidikan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['pendidikan'] = Pendidikan::findOrFail($id);
        return view('pendidikan::edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
      $data = request()->validate(['pendidikan'=>'required|unique:pendidikans,pendidikan,'.$id]);
      Pendidikan::find($id)->update($data);
      Flashy::info('Data Pendidikan berhasil di update');
      return redirect()->route('pendidikan');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
