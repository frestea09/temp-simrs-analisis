<?php

namespace App\Http\Controllers;
use App\Masteridrg;
use App\Masteridrgbiaya;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Validator;
use Flashy;
use Modules\Registrasi\Entities\Folio;
use Modules\Tarif\Entities\TarifLama;

use function Doctrine\Common\Cache\Psr6\get;

class MasteridrgController extends Controller {
	public function index() {
		return view('masteridrg.index');
	}

	public function storeEditTarif(Request $req) {
		
		$gettarif = Tarif::where('nama',$req->namatarif)->get();
		if(count($gettarif) > 0){
			foreach($gettarif as $t){
				$tr = Tarif::where('id',$t->id)->first();
				$tr->masteridrg_id = $req->masteridrg_id;
				$tr->idrg_biaya_id = $req->idrg_biaya_id;
				$tr->save();
				
				$trs = TarifLama::where('id',$t->id)->first();
				$trs->masteridrg_id = $req->masteridrg_id;
				$trs->idrg_biaya_id = $req->idrg_biaya_id;
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
					$tr->masteridrg_id = 3;
					$tr->idrg_biaya_id = 5;
					$tr->update();
				}
			}
		}
		dd("OKE");
	}
	public function editTarif() {
		$data['idrg'] = Masteridrg::all();
		$data['idrg_biaya'] = Masteridrgbiaya::all();
		return view('masteridrg.edittarif',$data);
	}

	public function dataList() {
		$idrg = Masteridrg::all();
		return view('masteridrg.datalist', compact('idrg'))->with('no', 1);
	}

	public function create() {

	}

	public function store(Request $request) {
		$cek = Validator::make($request->all(), [
			'idrg' => 'required|unique:masteridrg,idrg',
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
		} else {
			$mapp = new Masteridrg();
			$mapp->idrg = $request['idrg'];
			$mapp->save();
			return response()->json(['sukses' => true]);
		}
	}

	public function show($id) {
		$show = Masteridrg::find($id);
		return response()->json($show);
	}

	public function edit($id) {
		$idrg = Masteridrg::find($id);
		return response()->json($idrg);
	}

	public function update(Request $request, $id) {
		$cek = Validator::make($request->all(), [
			'idrg' => 'required|unique:masteridrg,idrg,' . $id,
		]);
		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
		} else {
			$mapp = Masteridrg::find($id);
			$mapp->idrg = $request['idrg'];
			$mapp->update();
			return response()->json(['sukses' => true]);
		}
	}

	public function destroy($id) {
		//
	}

	public function detailIdrg($masteridrg_id = '') {

	}
}
