<?php

namespace Modules\Sebabsakit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Flashy;


class SebabsakitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['sebabsakit'] = Sebabsakit::all();
        return view('sebabsakit::index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('sebabsakit::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:sebabsakits,nama']);
      Sebabsakit::create($data);
      Flashy::success('Sebab Sakit Telah Ditambahkan');
      return redirect()->route('sebabsakit');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('sebabsakit::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['sebabsakit'] = Sebabsakit::findOrFail($id);
        return view('sebabsakit::edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
      $data = request()->validate(['nama'=>'required|unique:sebabsakits,nama,'.$id]);
      Sebabsakit::find($id)->update($data);
      Flashy::info('Data Sebab Sakit berhasil di update');
      return redirect()->route('sebabsakit');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
