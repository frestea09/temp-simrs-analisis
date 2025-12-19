<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class PengirimPenerimaController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('logistik.logistikmedik.pengirimpenerima.index');
	}

	public function data() {
		$data = \App\Logistik\LogistikPengirimPenerima::all();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('edit', function ($data) {
				return '<button type="button" class="btn btn-primary btn-sm btn-flat" onclick="editForm(' . $data->id . ')">
                            <i class="fa fa-edit"></i>
                        </button>';
			})
			->rawColumns(['edit'])
			->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$cek = Validator::make($request->all(), [
			'nama' => 'required',
			'nip' => 'required',
			'departemen' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = new \App\Logistik\LogistikPengirimPenerima();
			$gd->kode = $request['kode'];
			$gd->nama = $request['nama'];
			$gd->nip = $request['nip'];
			$gd->departemen = $request['departemen'];
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
		return \App\Logistik\LogistikPengirimPenerima::find($id);
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
			'nama' => 'required',
			'nip' => 'required',
			'departemen' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = \App\Logistik\LogistikPengirimPenerima::find($id);
			$gd->kode = $request['kode'];
			$gd->nama = $request['nama'];
			$gd->nip = $request['nip'];
			$gd->departemen = $request['departemen'];
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
}
