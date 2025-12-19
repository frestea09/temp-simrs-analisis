<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Satuanjual;
use Flashy;

class SatuanjualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $data['satuanjual'] = Satuanjual::all();
         return view('satuanjual.index',$data)->with('no', 1);
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         return view('satuanjual.create');
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
       $data = request()->validate(['nama'=>'required|unique:satuanjuals,nama']);
       Satuanjual::create($data);
       Flashy::success('Satuan Jual Telah Ditambahkan');
       return redirect('satuanjual');
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
       $data['satuanjual'] = Satuanjual::find($id);
       return view('satuanjual.edit',$data);
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
       $data = request()->validate(['nama'=>'required|unique:satuanjuals,nama,'.$id]);
       Satuanjual::find($id)->update($data);
       Flashy::info('Data Satuan Jual berhasil di update');
       return redirect('satuanjual');
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
