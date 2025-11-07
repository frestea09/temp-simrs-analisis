<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class SaldoAwalController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('logistik.logistikmedik.stok_awal.index');
	}

	function getObat() {
		return \App\Masterobat::all();
	}

	function getGudang() {
		return \App\Logistik\LogistikGudang::all();
	}

	function getSupplier() {
		return \App\Logistik\LogistikSupplier::all();
	}

	function getPeriode() {
		return \App\Logistik\LogistikPeriode::all();
	}

	public function data() {
		$data = \App\Logistik\LogistikStock::get();
		return view('logistik.logistikmedik.stok_awal.data', compact('data'))->with('no', 1);
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
			'batch_no' => 'required',
			'expired_date' => 'required',
			'total_batch' => 'required',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$batch_no = \App\Logistik\LogistikStock::where('batch_no', $request['batch_no'])->first();
			if (empty($batch_no)) {
				$stock = new \App\Logistik\LogistikStock();
				$stock->gudang_id = $request['gudang_id'];
				$stock->supplier_id = $request['supplier_id'];
				$stock->periode_id = $request['periode_id'];
				$stock->masterobat_id = $request['masterobat_id'];
				$stock->batch_no = $request['batch_no'];
				$stock->expired_date = valid_date($request['expired_date']);
				$stock->masuk = $request['total_batch'];
				$stock->total = $stock->total + $request['total_batch'];
				$stock->keterangan = $request['keterangan'];
				$stock->created_at = date('2019-03-01 00:00:00');
				$stock->updated_at = date('2019-03-01 00:00:00');
				$stock->save();

				$master = \App\Masterobat::find($request['masterobat_id']);
				$master->saldo = $request['total_batch'];
				$master->update();

				$lnb = new \App\Logistik\LogistikNoBatch();
				$lnb->gudang_id = $request['gudang_id'];
				$lnb->supplier_id = $request['supplier_id'];
				$lnb->masterobat_id = $request['masterobat_id'];
				$lnb->saldo = $request['total_batch'];
				$lnb->batch_no = $request['batch_no'];
				$lnb->expired_date = valid_date($request['expired_date']);
				$lnb->created_at = date('2019-03-01 00:00:00');
				$lnb->updated_at = date('2019-03-01 00:00:00');
				$lnb->save();

				return response()->json(['sukses' => true]);
			} else {
				return response()->json(['sukses' => false]);
			}

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
		$stock = \App\Logistik\LogistikStock::find($id);
		$stock['tanggal'] = tgl_indo($stock->expired_date);
		return $stock;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(Request $request) {
		$id = $request['id'];
		$stock = \App\Logistik\LogistikStock::find($id);
		$stock->gudang_id = $request['gudang_id'];
		$stock->supplier_id = $request['supplier_id'];
		$stock->periode_id = $request['periode_id'];
		$stock->masterobat_id = $request['masterobat_id'];
		$stock->batch_no = $request['batch_no'];
		$stock->expired_date = valid_date($request['expired_date']);
		$stock->masuk = $request['total_batch'];
		$stock->total = $stock->total + $request['total_batch'];
		$stock->update();
		if($stock){
			return response()->json(['sukses' => true]);
		}
	}

	public function hapusSaldo($id){
		$stock = \App\Logistik\LogistikStock::find($id);
		$stock->delete();
		if($stock){
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
