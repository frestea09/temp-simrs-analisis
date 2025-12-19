<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Supliyer;
use Flashy;

class SupliyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['supliyer'] = Supliyer::all();
        return view('supliyer.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supliyer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:supliyers,nama']);
      $data = $request->all();
      Supliyer::create($data);
      Flashy::success('Supliyer Telah Ditambahkan');
      return redirect('supliyer');
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
        $data['supliyer'] = Supliyer::find($id);
        return view('supliyer.edit',$data);
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
      $data = request()->validate(['nama'=>'required|unique:supliyers,nama,'.$id]);
      $data = $request->all();
      Supliyer::find($id)->update($data);
      Flashy::info('Data Supliyer berhasil di update');
      return redirect('supliyer');
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
