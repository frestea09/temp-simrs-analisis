<?php

namespace Modules\Pegawai\Http\Controllers;

use Flashy;
use Illuminate\Routing\Controller;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Pegawai\Http\Requests\SavepegawaiRequest;
use App\Kategoripegawai;
use App\Satusehat;
use Image;
use Auth;
use Activity;
use Illuminate\Http\Request;
use Modules\Pegawai\Http\Requests\UpdatepegawaiRequest;


class PegawaiController extends Controller
{
	public function updateKuota(Request $request)
	{
		$request->validate([
			'id' => 'required|exists:pegawais,id',
			'kuota_poli' => 'required|integer|min:0'
		]);

		$pegawai = Pegawai::find($request->id);
		$pegawai->kuota_poli = $request->kuota_poli;
		$pegawai->save();

		return response()->json(['success' => true]);
	}

	public function index()
	{
		$pegawai = Pegawai::all();
		return view('pegawai::index', compact('pegawai'))->with('no', 1);
	}

	public function create()
	{

		$kat     = Kategoripegawai::pluck('kategori', 'id');
		// $pegawai = Pegawai::pluck('kategori_pegawai', 'id');
		// return compact('kat','pegawai'); die;
		return view('pegawai::create', compact('kat'));
	}

	public function store(SavepegawaiRequest $request)
	{
		$data = $request->all();
		$data['kelompok_pegawai'] = $request['kelompok_pegawai'];
		$data['tgllahir'] = $request['tgllahir'];
		$data['sip_awal'] = $request['sip_awal'];
		$data['sip_akhir'] = $request['sip_akhir'];
		$data['poli_type'] = $request['poli_type'];
		$data['user_id'] = null;

		if (Satusehat::find(2)->aktif == 1) {
			if (satusehat()) {
				// ambil Id_satusehat dokter dari NIK
				// ambil key client_id dan secretkey
				$client_id = config('app.client_id');
				$client_secret = config('app.client_secret');
				// create code satusehat
				$urlcreatetoken = config('app.create_token');
				$curl1 = curl_init();

				curl_setopt_array($curl1, array(
					CURLOPT_URL => $urlcreatetoken,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/x-www-form-urlencoded'
					),
				));

				$response1 = curl_exec($curl1);
				$token = json_decode($response1);
				$access_token = $token->access_token;
				curl_close($curl1);
				// echo $response1;

				//  Ambil id_satusehat bedasarkan NIK
				$urlcreatepractitioner = config('app.create_practitioner');
				$curl2 = curl_init();

				curl_setopt_array($curl2, array(
					CURLOPT_URL => $urlcreatepractitioner . $request->nik,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'GET',
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
						'Authorization: Bearer ' . $access_token . ''
					),
				));

				$response2 = curl_exec($curl2);
				$id_ss = json_decode($response2);
				//    dd($response2);
				// dd($id_ss->entry[0]->resource->id);
				if (!empty($id_ss->entry)) {
					$idss = $id_ss->entry[0]->resource->id;
				} else {
					$idss = NULL;
				}
				curl_close($curl2);
				$data['id_dokterss'] = $idss;
			}
		}


		Pegawai::create($data);
		Flashy::success('Pegawai ' . $request['nama'] . ' berhasil ditambahkan');
		return redirect()->route('pegawai');
	}

	public function show()
	{
		return view('pegawai::show');
	}

	public function edit($id)
	{
		$pegawai = Pegawai::find($id);
		$kat     = Kategoripegawai::pluck('kategori', 'id');
		return view('pegawai::edit', compact('pegawai', 'kat'));
	}

	public function update(UpdatepegawaiRequest $request, $id)
	{
		// dd('test');
		$pegawai = Pegawai::find($id);
		if (!empty($request->file('ttd'))) {
			$image = time() . $request->file('ttd')->getClientOriginalName();
			$request->file('ttd')->move('images/', $image);
			$img   = Image::make(public_path() . '/images/' . $image)->resize(300, 300);
			$img->save();
		} else {
			$image = $pegawai->tanda_tangan;
		}
		$data                 = $request->all();
		$lahir                = $request['tgllahir'];
		$data['tgllahir']     = @valid_date($lahir);
		$data['sip_awal']     = $request['sip_awal'];
		$data['sip_akhir']    = $request['sip_akhir'];
		$data['general_code']    = $request['general_code'];
		$data['tanda_tangan'] = $image;

		if (Satusehat::find(2)->aktif == 1) {
			if (satusehat()) {
				// ambil Id_satusehat dokter dari NIK
				// ambil key client_id dan secretkey
				$client_id = config('app.client_id');
				$client_secret = config('app.client_secret');
				// create code satusehat
				$urlcreatetoken = config('app.create_token');
				$curl1 = curl_init();

				curl_setopt_array($curl1, array(
					CURLOPT_URL => $urlcreatetoken,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/x-www-form-urlencoded'
					),
				));

				$response1 = curl_exec($curl1);
				$token = json_decode($response1);
				$access_token = @$token->access_token;
				curl_close($curl1);
				// echo $response1;

				//  Ambil id_satusehat bedasarkan NIK
				$urlcreatepractitioner = config('app.create_practitioner');
				$curl2 = curl_init();

				curl_setopt_array($curl2, array(
					CURLOPT_URL => $urlcreatepractitioner . $request->nik,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'GET',
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
						'Authorization: Bearer ' . $access_token . ''
					),
				));
				//    dd($request->nik);
				$response2 = curl_exec($curl2);
				//    dd($response2);
				$id_ss = json_decode($response2);
				// dd($id_ss->entry[0]->resource->id);
				if (!empty($id_ss->entry)) {
					$idss = $id_ss->entry[0]->resource->id;
				} else {
					$idss = NULL;
				}
				curl_close($curl2);
				if($idss){
					$data['id_dokterss'] = $idss;
				}
			}
		}



		$pegawai->update($data);
		Flashy::info('Pegawai ' . $request['nama'] . ' berhasil diupdate');
		return redirect()->route('pegawai');
	}

	public function destroy($id)
	{
		$user = Auth::user();
		// dd($user);
		$pegawai = Pegawai::findOrFail($id);
		$namaPegawai = $pegawai->nama;
		// dd($namaPegawai);
		$pegawai->delete();

		Activity::log('User Atas Nama ' . $user->name . ' Telah Menghapus Data Pegawai Dengan Nama ' . $namaPegawai);
		Flashy::info('Pegawai Berhasil Dihapus');
		return redirect()->route('pegawai');
	}
}
