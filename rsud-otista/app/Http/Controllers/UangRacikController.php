<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UangRacik;
use App\Http\Controllers\Controller;
use MercurySeries\Flashy\Flashy;
use Validator;


class UangRacikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['uangracik'] = UangRacik::all();
        return view('penjualan.uang_racik', $data)->with('no', 1);
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
            'nama' => 'required|string',
            'nominal' => 'required|string'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $uangracik = new UangRacik();
            $uangracik->nama = $request['nama'];
            $uangracik->nominal = $request['nominal'];
            $uangracik->save();
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
        $uangracik = UangRacik::find($id);
        return response()->json($uangracik);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nominal' => 'required|string'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $uangracik = UangRacik::find($id);
            $uangracik->nama = $request['nama'];
            $uangracik->nominal = $request['nominal'];
            $uangracik->update();
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
        $uangracik = UangRacik::find($id);
        $uangracik->delete();
        return response()->json(['sukses' => true]);
    }
}

