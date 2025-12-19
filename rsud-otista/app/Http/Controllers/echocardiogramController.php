<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Folio;
use App\echocardiogram;
use Auth;
use DB;
use Excel;
use PDF;
use Flashy;
use Illuminate\Support\Facades\Response;


class echocardiogramController extends Controller
{
	public function tindakanIRJ()
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		return view('echocardiogram.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRJByTanggal(Request $request)
	{
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();

		return view('echocardiogram.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRD()
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();

		return view('echocardiogram.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRDByTanggal(Request $request)
	{
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		$data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();

		return view('echocardiogram.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRNA()
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$date = date('Y-m-d', strtotime('-10 days'));
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2', 'I3'])
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->get();

		return view('echocardiogram.tindakanIRNA', $data)->with('no', 1);
	}

	public function tindakanIRNAByTanggal(Request $request)
	{
		request()->validate(['tga' => 'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2', 'I3'])
			->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->get();
		return view('echocardiogram.tindakanIRNA', $data)->with('no', 1);
	}

	public function echocardiogram($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$reg->pasien;
		$umur = hitung_umur($reg->pasien->tgllahir);
		$tindakan = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->get();
		$ekspertise = \App\echocardiogram::where('registrasi_id', $registrasi_id)->first();
		$eksp = $ekspertise ? $ekspertise : [];
		$tanggal = !empty($ekspertise->tanggal_eksp) ? tanggalPeriode($ekspertise->tanggal_eksp) : null;
		return response()->json(['reg' => $reg, 'tindakan' => $tindakan, 'ep' => $eksp, 'umur' => $umur, 'tanggal' => $tanggal]);
	}

	function saveEchocardiogram(Request $request)
	{
		// return $request; die;
		if ($request['id']) {
			$ep = \App\echocardiogram::where('id', $request['id'])->first();
		} else {
			$ep = new \App\echocardiogram();
		}
		// dd($ep);
		$ep->registrasi_id = $request['registrasi_id'];
		$ep->pasien_id = $request['pasien_id'];
		$ep->atrium_kiri = $request['atrium_kiri'];
		$ep->global = $request['global'];
		$ep->ventrikel_kanan = $request['ventrikel_kanan'];
		$ep->katup_katup_jantung_aorta = $request['katup_katup_jantung_aorta'];
		$ep->ejeksi_fraksi = $request['ejeksi_fraksi'];
		$ep->diagnosa = $request['diagnosa'];
		$ep->ea = $request['ea'];
		$ep->ee = $request['ee'];
		$ep->tapse = $request['tapse'];
		$ep->lvesd = $request['lvesd'];
		$ep->ivsd = $request['ivsd'];
		$ep->ivss = $request['ivss'];
		$ep->lvedd = $request['lvedd'];
		$ep->pwd = $request['pwd'];
		$ep->pws = $request['pws'];
		$ep->lvmi = $request['lvmi'];
		$ep->rwt = $request['rwt'];
		$ep->kesimpulan = $request['kesimpulan'];
		$ep->catatan_dokter = $request['catatan_dokter'];
		$ep->jenis = $request['jenis'];
		$ep->user_id = Auth::user()->id;
		$ep->save();
		return response()->json(['sukses' => true, 'data' => $ep]);
	}

	//Laporan echocardiogram
	public function echocardiogramHasil()
	{
		$echocardiogram = \App\echocardiogram::join('registrasis', 'registrasis.id', '=', 'echocardiograms.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
			->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'echocardiograms.*')
			->orderby('registrasis.id')
			->get();
		return view('echocardiogram.hasil_echocardiogram', compact('echocardiogram'))->with('no', 1);
	}

	public function echocardiogramBytanggal(Request $request)
	{
		$echocardiogram = \App\echocardiogram::join('registrasis', 'registrasis.id', '=', 'echocardiograms.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.created_at', 'like', valid_date($request['tga']) . '%')
			->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'echocardiograms.*')
			->orderby('registrasis.id')
			->get();
		// return $radiologi; die;
		return view('echocardiogram.hasil_echocardiogram', compact('echocardiogram'))->with('no', 1);
	}

	public static function cetakEchocardiogram($registrasi_id, $id = '')
	{
		$radiologi = \App\echocardiogram::join('registrasis', 'registrasis.id', '=', 'echocardiograms.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('echocardiograms.registrasi_id', $registrasi_id)
			->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.rt', 'pasiens.rw', 'pasiens.village_id', 'echocardiograms.*');

		if (!empty($id)) {
			$radiologi = $radiologi->where('echocardiograms.id', $id);
		}

		$radiologi = $radiologi->first();

		if ($radiologi->tte) {
			$tte = json_decode($radiologi->tte);
	
			if ($tte) {
				$base64 = $tte->base64_signed_file;
	
				$pdfContent = base64_decode($base64);
				return Response::make($pdfContent, 200, [
					'Content-Type' => 'application/pdf',
					// 'Content-Disposition' => 'attachment; filename="Echocardiogram-' . $radiologi->id . '.pdf"',
				]);
			} else {
				return redirect("/dokumen_tte/" . $radiologi->tte);
			}
		} else {
			$cek = \App\echocardiogram::where('registrasi_id', $registrasi_id)->first();
			$pdf = PDF::loadView('echocardiogram.lap_hasil_echocardiogram', compact('radiologi'));
			return $pdf->stream();
		}
	}

	public function index()
	{
		//
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
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
