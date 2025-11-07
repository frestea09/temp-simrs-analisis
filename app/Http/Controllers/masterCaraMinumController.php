<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\masterCaraMinum;
use App\Http\Controllers\Controller;
use MercurySeries\Flashy\Flashy;
use Validator;

class masterCaraMinumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mastercarabayar'] = masterCaraMinum::all();
        return view('penjualan.cara_minum', $data)->with('no', 1);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsejenis_pemeriksaan
     */
    public function store(Request $request)
    {
        // return $request->all(); die;
        $cek = Validator::make($request->all(), [
            'nama' => 'required|string'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $mastercarabayar = new masterCaraMinum();
            $mastercarabayar->nama = $request['nama'];
            $mastercarabayar->save();
            return response()->json(['sukses' => true]);
        }
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
        $mastercarabayar = masterCaraMinum::find($id);
        return response()->json($mastercarabayar);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => 'required|string'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $mastercarabayar = masterCaraMinum::find($id);
            $mastercarabayar->nama = $request['nama'];
            $mastercarabayar->update();
            return response()->json(['sukses' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $mastercarabayar = masterCaraMinum::find($id);
            $mastercarabayar->delete();
            return response()->json(['sukses' => true]);
        
    }
}
