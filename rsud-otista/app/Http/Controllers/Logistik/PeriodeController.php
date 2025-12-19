<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class PeriodeController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('logistik.logistikmedik.periode.index');
	}

	public function data() {
		$data = \App\Logistik\LogistikPeriode::all();
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
	public function tanggal($tgl_input) {
		$tgl = explode('-', $tgl_input);
		return $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
	}

	public function store(Request $request) {
		$cek = Validator::make($request->all(), [
			'nama' => 'required',
			'periodeAwal' => 'required',
			'periodeAkhir' => 'required',
			'transaksiAwal' => 'required',
			'transaksiAkhir' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = new \App\Logistik\LogistikPeriode();
			$gd->nama = $request['nama'];
			$gd->periodeAwal = $this->tanggal($request['periodeAwal']);
			$gd->periodeAkhir = $this->tanggal($request['periodeAkhir']);
			$gd->transaksiAwal = $this->tanggal($request['transaksiAwal']);
			$gd->transaksiAkhir = $this->tanggal($request['transaksiAkhir']);
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
		$pr = \App\Logistik\LogistikPeriode::find($id);
		$data['id'] = $pr->id;
		$data['nama'] = $pr->nama;
		$data['periodeAwal'] = tanggalPeriode($pr->periodeAwal);
		$data['periodeAkhir'] = tanggalPeriode($pr->periodeAkhir);
		$data['transaksiAwal'] = tanggalPeriode($pr->transaksiAwal);
		$data['transaksiAkhir'] = tanggalPeriode($pr->transaksiAkhir);
		return $data;
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
			'periodeAwal' => 'required',
			'periodeAkhir' => 'required',
			'transaksiAwal' => 'required',
			'transaksiAkhir' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$gd = \App\Logistik\LogistikPeriode::find($id);
			$gd->nama = $request['nama'];
			$gd->periodeAwal = $this->tanggal($request['periodeAwal']);
			$gd->periodeAkhir = $this->tanggal($request['periodeAkhir']);
			$gd->transaksiAwal = $this->tanggal($request['transaksiAwal']);
			$gd->transaksiAkhir = $this->tanggal($request['transaksiAkhir']);
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
