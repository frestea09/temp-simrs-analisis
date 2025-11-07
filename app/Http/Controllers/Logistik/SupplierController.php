<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('logistik.logistikmedik.supplier.index');
	}

	public function data() {
		$data = \App\Logistik\LogistikSupplier::all();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('edit', function ($data) {
				return '<button type="button" class="btn btn-primary btn-sm btn-flat" onclick="editForm(' . $data->id . ')">
							<i class="fa fa-edit"></i>
						</button>';
			})
			->addColumn('status', function ($data) {
				return $data->status == 1 ? 'Aktif' : 'Tidak Aktif';
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
			'alamat' => 'required',
			'telepon' => 'required',
			'nohp' => 'required',
			'nama_pejabat' => 'required',
			'jabatan' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = new \App\Logistik\LogistikSupplier();
			$gd->nama = $request['nama'];
			$gd->alamat = $request['alamat'];
			$gd->telepon = $request['telepon'];
			$gd->nohp = $request['nohp'];
			$gd->status = $request['status'];
			$gd->nama_pejabat = $request['nama_pejabat'];
			$gd->jabatan = $request['jabatan'];
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
		return \App\Logistik\LogistikSupplier::find($id);
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
			'alamat' => 'required',
			'telepon' => 'required',
			'nohp' => 'required',
			'nama_pejabat' => 'required',
			'jabatan' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = \App\Logistik\LogistikSupplier::find($id);
			$gd->nama = $request['nama'];
			$gd->alamat = $request['alamat'];
			$gd->telepon = $request['telepon'];
			$gd->nohp = $request['nohp'];
			$gd->status = $request['status'];
			$gd->nama_pejabat = $request['nama_pejabat'];
			$gd->jabatan = $request['jabatan'];
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

	public function getSupplier(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = \App\Logistik\LogistikSupplier::where('nama', 'like', '%' . $term . '%')->limit(15)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama];
		}

		return \Response::json($formatted_tags);
	}
}
