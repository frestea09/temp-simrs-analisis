<?php

namespace App\Http\Controllers;
use App\Mastermapping;
use App\Mastermappingbiaya;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Validator;
use Flashy;
use Modules\Registrasi\Entities\Folio;
use Modules\Tarif\Entities\TarifLama;

use function Doctrine\Common\Cache\Psr6\get;

class MastermappingController extends Controller {
	public function index() {
		return view('mastermapping.index');
	}

	public function storeEditTarif(Request $req) {
		
		$gettarif = Tarif::where('nama',$req->namatarif)->get();
		if(count($gettarif) > 0){
			foreach($gettarif as $t){
				$tr = Tarif::where('id',$t->id)->first();
				$tr->mastermapping_id = $req->mastermapping_id;
				$tr->mapping_biaya_id = $req->mapping_biaya_id;
				$tr->save();
				
				$trs = TarifLama::where('id',$t->id)->first();
				$trs->mastermapping_id = $req->mastermapping_id;
				$trs->mapping_biaya_id = $req->mapping_biaya_id;
				$trs->save();
			}
		}
		if($req->nama !== null){
			echo '<script>window.close();</script>';
			return;
		}
		Flashy::success(count($gettarif).' tarif berhasil di mapping di kelompok biaya');
		return redirect()->back();
	}

	public function mappRad() {
		$fol = Folio::where('poli_tipe','R')->groupBy('namatarif')->get();
		$ff = [];
		foreach($fol as $f){
			$gettarif = Tarif::where('nama',$f->namatarif)->get();
			if(count($gettarif) > 0){
				foreach($gettarif as $t){
					$tr = Tarif::where('id',$t->id)->first();
					$tr->mastermapping_id = 3;
					$tr->mapping_biaya_id = 5;
					$tr->update();
				}
			}
		}
		dd("OKE");
	}
	public function editTarif() {
		$data['mapping'] = Mastermapping::all();
		$data['mapping_biaya'] = Mastermappingbiaya::all();
		return view('mastermapping.edittarif',$data);
	}

	public function dataList() {
		$mapping = Mastermapping::all();
		return view('mastermapping.datalist', compact('mapping'))->with('no', 1);
	}

	public function create() {

	}

	public function store(Request $request) {
		$cek = Validator::make($request->all(), [
			'mapping' => 'required|unique:mastermapping,mapping',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
		} else {
			$mapp = new Mastermapping();
			$mapp->mapping = $request['mapping'];
			$mapp->save();
			return response()->json(['sukses' => true]);
		}
	}

	public function show($id) {
		$show = Mastermapping::find($id);
		return response()->json($show);
	}

	public function edit($id) {
		$mapping = Mastermapping::find($id);
		return response()->json($mapping);
	}

	public function update(Request $request, $id) {
		$cek = Validator::make($request->all(), [
			'mapping' => 'required|unique:mastermapping,mapping,' . $id,
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
		} else {
			$mapp = Mastermapping::find($id);
			$mapp->mapping = $request['mapping'];
			$mapp->update();
			return response()->json(['sukses' => true]);
		}
	}

	public function destroy($id) {
		//
	}

	public function detailMapping($mastermapping_id = '') {

	}
}
