<?php

namespace App\Http\Controllers;

use App\Bdrs;
use Modules\Tarif\Entities\Tarif;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Carabayar;
use Illuminate\Http\Request;
use Flashy;
use PDF;
use Illuminate\Support\Facades\Auth;

class BDRSController extends Controller {
	public function billing() {
		$data['dokters_poli'] = Poli::where('id', 25)->pluck('dokter_id');
		$data['dokter_poli'] =  @(explode(",", $data['dokters_poli'][0]));
		$index = array_search(17, $data['dokter_poli']);
		
		if ($index !== false) {
			unset($data['dokter_poli'][$index]);
		}
		
		$data['perawats_poli'] = Poli::where('id', 25)->pluck('perawat_id');
		$data['perawat_poli'] =  @(explode(",", $data['perawats_poli'][0]));
		$data['cara_bayar'] = Carabayar::all();
		
		$data['bdrs'] = Bdrs::with('detail')->where('created_at', 'like', date('Y-m-d').'%')->get();

		return view('bdrs.billing', $data)->with('no', 1);
	}

	public function simpanTransaksi(Request $request)
	{
		request()->validate(['tarif_id' => 'required']);

		$bdrs = new Bdrs();
		$bdrs->no_sample = $request['no_sample'];
		$bdrs->created_by = Auth::user()->id;
		$bdrs->tanggal = $request['tanggal'];
		$bdrs->save();

		foreach ($request['tarif_id'] as $tarif_id) {
			$tarif  = Tarif::find($tarif_id);
			if ($tarif) {
				$bdrs->detail()->create([
					'namatarif' => $tarif->nama,
					'tarif_id' => $tarif->id,
					'cara_bayar_id' => $request['cara_bayar'],
					'user_id' => Auth::user()->id,
					'dokter_id' => $request['dokter_id'],
					'pelaksana_lab_id' => $request['pelaksana_lab'],
					'total' => $tarif->total,
				]);
			}
		}

		Flashy::success('Selesai Input Tindakan');
		return redirect()->back();
	}

	public function rincianBiaya($id)
	{
		$data['bdrs'] = Bdrs::findOrFail($id);
		$data['rincian'] = [];
		
		$pdf = PDF::loadView('bdrs.pdf-rincian-biaya', $data);
		return $pdf->stream();
	}

	public function delete($id)
	{
		$bdrs = Bdrs::findOrFail($id);
		$bdrs->detail()->delete();
		$bdrs->delete();

		Flashy::success('Berhasil menghapus data');
		return redirect()->back();
	}
}
