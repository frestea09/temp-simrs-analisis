<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Satuanbeli;
use Flashy;

class SatuanbeliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['satuanbeli'] = Satuanbeli::all();
        return view('satuanbeli.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satuanbeli.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:satuanbelis,nama']);
      Satuanbeli::create($data);
      Flashy::success('Satuan Beli Telah Ditambahkan');
      return redirect('satuanbeli');
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
      $data['satuanbeli'] = Satuanbeli::find($id);
      return view('satuanbeli.edit',$data);
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
      $data = request()->validate(['nama'=>'required|unique:satuanbelis,nama,'.$id]);
      Satuanbeli::find($id)->update($data);
      Flashy::info('Data Satuan Beli berhasil di update');
      return redirect('satuanbeli');
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
