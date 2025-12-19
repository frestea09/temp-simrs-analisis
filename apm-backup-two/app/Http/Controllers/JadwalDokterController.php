<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use App\Models\Pegawai;

class JadwalDokterController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['poli'] = Poli::where('politype','J')->get();
        return view('jadwal.index',$data);
    }

    // V2
	// function jadwalDokterHfis(Request $request) {
	// 	// dd($request->all());
	// 	$ID = config('app.consid_antrean');
	// 	date_default_timezone_set('UTC');
	// 	$t = time();
	// 	$data = "$ID&$t";
	// 	$secretKey = config('app.secretkey_antrean');
	// 	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
	// 	// dd($request->all());
		
	// 	// jika mengambil data dari reservasi
	// 	if(isset($request['reservasi'])){
	// 		if(!$request['tgl']){
	// 			$request['tgl'] = date('Y-m-d');
	// 		}
	// 		$poli = Poli::find($request['poli']);
	// 		$request['poli'] = $poli->bpjs;
	// 	}else{
	// 		$request['tgl'] = valid_date($request['tgl']);
	// 	}
	// 	$completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $request['poli'] . "/tanggal/" . $request['tgl'];
	// 	// dd($completeurl);
	// 	$session = curl_init($completeurl);
	// 	// dd($session);
	// 	$arrheader = array(
	// 		'x-cons-id: ' . $ID,
	// 		'x-timestamp: ' . $t,
	// 		'x-signature: ' . $signature,
	// 		'user_key:'.config('app.user_key_antrean'),
	// 		'Content-Type: application/json',
	// 	);
	// 	curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
	// 	curl_setopt($session, CURLOPT_HTTPGET, 1);
	// 	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		
	// 	$response = curl_exec($session);
	// 	// dd($response['metadata']['code']);
		
	// 	$message = json_decode($response, true); 
	// 	if($response =='Authentication failed'){
	// 		$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
	// 		return response()->json(json_encode($json,JSON_PRETTY_PRINT));
	// 	}
	// 	$array[] = json_decode($response, true);
	// 	if($message['metadata']['code'] == 200){
	// 		$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
	// 		$array[] = json_decode($this->decompress($stringEncrypt),true);
	// 	}else{
	// 		$array[] = json_decode($response,true);
	// 	}

	// 	$sml = json_encode($array,JSON_PRETTY_PRINT); 

	// 	$json = json_decode($sml,true);
		
	// 	return response()->json($sml);
	// }
	function cekJadwal($kode) {
		$pol = Poli::where('bpjs',$kode)->first();
		$dokter = Pegawai::where('kategori_pegawai',1)->where('poli_id',$pol->id)->get();
		$data = [];
		if($dokter){
			$data = [
				'message' =>"berhasil",
				'status'=> "success"
			];
			foreach($dokter as $d){
				$data['jadwal'][] = [
					'id'=>$d->id,
					'kodesubspesialis' => '',
					'hari' => '',
					'jadwal' => '',
					'kapasitaspasien' => '',
					'kodedokter' => $d->kode_bpjs,
					'kodepoli' => $kode,
					'kodesubspesialis' => $kode,
					'libur' => '',
					'kodesubspesialis' => $kode,
					'namadokter' => $d->nama,
					'namahari' => $d->nama,
					'namapoli' => $pol->nama,
					'namasubspesialis' => $pol->nama,
				];
			}
		}
		// dd($data);
		return response()->json($data);

	}
	// V2
	function jadwalDokterHfis(Request $request) {
		// dd($request->all());
		$ID = config('app.consid_antrean');
		date_default_timezone_set('UTC');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.secretkey_antrean');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
		// dd($request->all());
		
		// jika mengambil data dari reservasi
		if(isset($request['reservasi'])){
			if(!$request['tgl']){
				$request['tgl'] = date('Y-m-d');
			}
			$poli = Poli::find($request['poli']);
			$request['poli'] = $poli->bpjs;
		}else{
			$request['tgl'] = valid_date($request['tgl']);
		}
		$completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $request['poli'] . "/tanggal/".date('Y-m-d');
		// dd($completeurl);
		$session = curl_init($completeurl);
		// dd($session);
		$arrheader = array(
			'x-cons-id: ' . $ID,
			'x-timestamp: ' . $t,
			'x-signature: ' . $signature,
			'user_key:'.config('app.user_key_antrean'),
			'Content-Type: application/json',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		
		$response = curl_exec($session);
		// dd($response['metadata']['code']);
		
		$message = json_decode($response, true); 
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		if($message['metadata']['code'] == 200){
			$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
			$array[] = json_decode($this->decompress($stringEncrypt),true);
		}else{
			$array[] = json_decode($response,true);
		}

		$sml = json_encode($array,JSON_PRETTY_PRINT); 

		$json = json_decode($sml,true);
		// dd($sml);
		return response()->json($sml);
	}
	// function jadwalDokterHfis(Request $request) {
	// 	// dd($request->all());
	// 	$pol = Poli::where('bpjs',$request['poli'])->first();
	// 	if(!$pol){
	// 		$pol = Poli::where('id',$request['poli'])->first();
	// 	}
	// 	$dokter_id = [];

	// 	// foreach($pol->dokter_id as $pol) {
    //     //     $dokter_id[] = $pol;
    //     // }

	// 	$dokter_id = explode(",",$pol->dokter_id);
	// 	$dokter = Pegawai::whereIn('id',$dokter_id)->get();
	// 	if(count($dokter) == 0){
	// 		$dokter = Pegawai::where('kategori_pegawai',1)->get();
	// 	}		
	// 	$data = [];
	// 	// dd($dokter);

	// 	if($dokter){
	// 		$data[0] = [
	// 			'metadata'=> [
	// 				'code' => 200
	// 			]
	// 		];
	// 		foreach($dokter as $d){
	// 			$data[1][] = [
	// 				'jadwal' => '',
	// 				'namadokter' => $d->nama,
	// 				'id' => $d->id,
	// 				'kodedokter' => $d->kode_bpjs,
	// 			];
	// 		}
	// 	}else{
	// 		$data[0] = [
	// 			'metadata'=> [
	// 				'code' => 201
	// 			]
	// 		];
	// 	}
	// 	// foreach($dokter as $d){
	// 	// 	$data[]
	// 	// }

	// 	// $sml = json_encode($data,JSON_PRETTY_PRINT); 

	// 	// $json = json_decode($sml,true);
	// 	// $json = json_decode($sml,true);
	// 	return response()->json($data);
	// }

    function stringDecrypt($key, $string){
            
      
		$encrypt_method = 'AES-256-CBC';

		// hash
		$key_hash = hex2bin(hash('sha256', $key));
  
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
  
		return $output;
	}

	// function lzstring decompress 
	// download libraries lzstring : https://github.com/nullpunkt/lz-string-php
	function decompress($string){
		// dd($string);
		return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

	} 
}
