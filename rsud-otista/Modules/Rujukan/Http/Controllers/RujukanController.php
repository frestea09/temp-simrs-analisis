<?php

namespace Modules\Rujukan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Rujukan\Entities\Rujukan;
use Flashy;


class RujukanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['rujukan']= Rujukan::all();
        return view('rujukan::index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('rujukan::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:rujukans,nama']);
      Rujukan::create($data);
      Flashy::success('Rujukan Telah Ditambahkan');
      return redirect()->route('rujukan');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('rujukan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
      $data['rujukan'] = Rujukan::find($id);
        return view('rujukan::edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
      $data = request()->validate(['nama'=>'required|unique:rujukans,nama,'.$id]);
      Rujukan::find($id)->update($data);
      Flashy::info('Data Rujukan berhasil di update');
      return redirect()->route('rujukan');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
