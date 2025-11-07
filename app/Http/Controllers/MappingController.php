<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Yajra\DataTables\DataTables;

class MappingController extends Controller {
	public function index() {
		return view('mapping.index');
	}

	public function dataTarif($tahuntarif_id = '', $jenis = '', $kategoritarif_id = '') {
		// if ($kategoritarif_id) {
		// 	$tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('mastermapping_id', '=', NULL)->get();
		// 	$kiri = ceil($tarif->count() / 2);
		// 	$dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('mastermapping_id', '=', NULL)->skip(0)->take($kiri)->get();
		// 	$dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('mastermapping_id', '=', NULL)->skip($kiri)->take($kiri)->get();
		// } else {
			
			// if($jenis == 'TI'){
				// dd(Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', NULL)->get());
			// }
			$tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->get();
			$kiri = ceil($tarif->count() / 2);
			$dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->skip(0)->take($kiri)->get();
			$dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->skip($kiri)->take($kiri)->get();
		// }
		return view('mapping.dataTarif', compact('tarif', 'dataKiri', 'dataKanan'))->with('no', 1);
	}

	public function simpanMapping(Request $request) {
		$total = $request['total'];
		$mastermapping_id = $request['mastermapping_id'];
		$id = [];
		// dd($request->all());
		for ($i = 1; $i <= $total; $i++) {
			if (!empty($request['tarif' . $i])) {
				$tarif = Tarif::find($request['tarif' . $i]);
				$namatarif = $tarif->nama;
				$tarf = Tarif::where('nama',$namatarif)->select('nama','mastermapping_id','id')->get();
				foreach($tarf as $t){
					$tarifs = Tarif::find($t->id);
					$tarifs->mastermapping_id = $mastermapping_id;
					$tarifs->update();
				}
				array_push($id, $tarif->id);
			}
		}
		$trf = Tarif::whereIn('id', $id)->get();
		return response()->json(['sukses' => true, 'message' => $trf->count() . ' tarif berhasil di mapping']);
	}

	public function mappingDetail($mastermapping_id = '') {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		$tarif = Tarif::where('mastermapping_id', $mastermapping_id)->select('nama','carabayar','total','id','mastermapping_id')->groupBy('nama')->groupBy('total')->get();
		return DataTables::of($tarif)
			->addIndexColumn()
			->addColumn('total', function ($tarif) {
				return @number_format(@$tarif->total);
			})
			->addColumn('carabayar', function ($tarif) {
				return @baca_carabayar(@$tarif->carabayar);
			})
			->addColumn('hapus', function ($tarif) {
				return '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapusMapping(' . @$tarif->mastermapping_id . ',' . @$tarif->id . ')"><i class="fa fa-remove"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	public function hapusMapping($tarif_id) {
		$tarif = Tarif::find($tarif_id);
		$tarif->mastermapping_id = NULL;
		$tarif->update();
		return $tarif;
	}

}
