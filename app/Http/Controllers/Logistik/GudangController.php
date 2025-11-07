<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class GudangController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('logistik.logistikmedik.gudang.index');
	}

	public function data() {
		$gudang = \App\Logistik\LogistikGudang::all();
		return view('logistik.logistikmedik.gudang.data', compact('gudang'))->with('no', 1);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$cek = Validator::make($request->all(), [
			'kode' => 'required|unique:logistik_gudangs,kode',
			'nama' => 'required|unique:logistik_gudangs,nama',
			'bagian' => 'required',
			'kepala' => 'required',
			'tipe' => 'required',
			'penanggungjawab' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = new \App\Logistik\LogistikGudang();
			$gd->kode = $request['kode'];
			$gd->nama = $request['nama'];
			$gd->bagian = $request['bagian'];
			$gd->kepala = $request['kepala'];
			$gd->tipe = $request['tipe'];
			$gd->penanggungjawab = $request['penanggungjawab'];
			$gd->save();
			return response()->json(['sukses' => true]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		return \App\Logistik\LogistikGudang::find($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$cek = Validator::make($request->all(), [
			'kode' => 'required|unique:logistik_gudangs,kode,' . $id,
			'nama' => 'required|unique:logistik_gudangs,nama,' . $id,
			'bagian' => 'required',
			'kepala' => 'required',
			'tipe' => 'required',
			'penanggungjawab' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = \App\Logistik\LogistikGudang::find($id);
			$gd->kode = $request['kode'];
			$gd->nama = $request['nama'];
			$gd->bagian = $request['bagian'];
			$gd->kepala = $request['kepala'];
			$gd->tipe = $request['tipe'];
			$gd->penanggungjawab = $request['penanggungjawab'];
			$gd->update();
			return response()->json(['sukses' => true]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	public function getSatker() {
		return \App\Logistik\LogistikSatker::all();
	}
}
