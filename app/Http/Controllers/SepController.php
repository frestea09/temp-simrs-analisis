<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Icd10\Entities\Icd10;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;
use PDF;
use DB;
use App\BpjsProv;
use App\BpjsKab;
use App\BpjsKec;
use App\BpjsLog;
use Yajra\DataTables\DataTables;
use Validator;
use \App\HistoriSep;
use App\MasterDiet;
use App\HistorikunjunganIGD;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use App\Nomorrm;
use App\RencanaKontrol;
use App\Satusehat;
use App\SepLog;
use Modules\Icd9\Entities\Icd9;

class SepController extends Controller {
	public function index($reg_id = '') {
		
		$registrasi_id = !empty(session('reg_id')) ? session('reg_id') : $reg_id;
		
		$data['poli'] = Poli::select('nama', 'bpjs')->get();
		$data['bpjsprov'] = BpjsProv::select('propinsi', 'kode')->get();
		$data['bpjskab'] = BpjsKab::pluck('kabupaten', 'kode');
		$data['bpjskec'] = BpjsKec::pluck('kecamatan', 'kode');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'kode_bpjs')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		if(!$data['reg']){
			return redirect()->back();
		}

		$data['surkon'] = RencanaKontrol::where('pasien_id',@$data['reg']->pasien_id)->groupBy('no_surat_kontrol')->orderBy('id','DESC')->limit(10)->get();
		$data['poli_bpjs'] = Poli::find($data['reg']->poli_id)->bpjs;
		$data['dokter_bpjs'] = Pegawai::find($data['reg']->dokter_id)->kode_bpjs;
		// dd($data['reg']);
		$data['noKartu'] = @$data['reg']->pasien->no_jkn;
		
		if(isset($data['reg'])){
			if($data['reg']->nomorantrian){
				if(status_consid(4)){
					if($data['reg']->pasien->no_jkn){

						@$no_surkons = @cekNoSurkon($data['reg']->pasien->no_jkn);
						if(@$no_surkons[1]['list'][0]['tglRencanaKontrol'] == date('Y-m-d')){
							@$data['no_surkon'] = @$no_surkons[1]['list'][0]['noSuratKontrol'];
						}
					}
				}


				$ID = config('app.consid_antrean');
				date_default_timezone_set('Asia/Jakarta');
				$t = time();
				$dat = "$ID&$t";
				$secretKey = config('app.secretkey_antrean');
				$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
				$completeurl = config('app.antrean_url_web_service')."antrean/updatewaktu";
				$arrheader = array(
					'X-cons-id: ' . $ID,
					'X-timestamp: ' . $t,
					'X-signature: ' . $signature,
					'user_key:'. config('app.user_key_antrean'),
					'Content-Type: application/json',
				);
				
				if(status_consid(4)){
					$updatewaktu   = '{
						"kodebooking": "'.@$data['reg']->nomorantrian.'",
						"taskid": "4",
						"waktu": "'.round(microtime(true) * 1000).'"
					}';
					$session2 = curl_init($completeurl);
					curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
					curl_setopt($session2, CURLOPT_POST, TRUE);
					curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
					curl_exec($session2);

				}
				// sleep(3);
				
				
				// $updatewaktu5   = '{
				// 	"kodebooking": "'.@$data['reg']->nomorantrian.'",
				// 	"taskid": "5",
				// 	"waktu": "'.round(microtime(true) * 1000).'"
				// }';
				// $session5 = curl_init($completeurl);
				// curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
				// curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
				// curl_setopt($session5, CURLOPT_POST, TRUE);
				// curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
				// curl_exec($session5);
				// sleep(3);
			}
		}
		
		if (substr($data['reg']->status_reg, 0, 1) == 'G') {
			//dd('test1');
			return view('sep.form_create_rujukan', $data);
		} else {
			//dd('test12');
			return view('sep.form_create', $data);
		}

	}


	public function getPoli()
	{
		$poli = Poli::where('politype', 'J')->get();
	
		$data = '';
		foreach($poli as $val){
			// $data .= '<li>'.$val->namatarif.'</li>';
			
			// OPTION TINDAKAN - // AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
			$data .= '<option value="'.$val->bpjs.'">'.$val->nama.'</option>';
		}

		// AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
		return '<select class="form-control select2" name="poliKontrol">'.$data.'</select>';
		// return '<ul>'.$data.'</ul>';
	}

	public function getDokter()
	{
		$pegawai = Pegawai::where('kode_bpjs', '!=', null)->where('kategori_pegawai', 1)->get();
	
		$data = '';
		foreach($pegawai as $val){
			// $data .= '<li>'.$val->namatarif.'</li>';
			
			// OPTION TINDAKAN - // AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
			$data .= '<option value="'.$val->kode_bpjs.'">'.baca_dokter($val->id).'</option>';
		}

		// AKTFIKAN JIKA INGIN FOLIO ID MASUK DATABASE
		return '<select class="form-control" id="select2" name="dokterKontrol">'.$data.'</select>';
		// return '<ul>'.$data.'</ul>';
	}






		public function getDataDiet() {
		$data = MasterDiet::all();
		return DataTables::of($data)
			->addColumn('add', function ($data) {
				return ' <a href="#" data-kode="' . $data->kode . '" class="btn btn-sm btn-success btn-flat addKode"><i class="fa fa-check"></i></a> ';
			})
			// ->addColumn('add', function ($data) {
			// 	return ' <a href="#" data-nama="' . $data->nama . '" class="btn btn-sm btn-success btn-flat addNama"><i class="fa fa-check"></i></a> ';
			// })
			->rawColumns(['add'])
			->make(true);
	}

	public function cetakLabel($registrasi_id) {
		$data['data'] = Registrasi::find($registrasi_id);
		$data['ID']   = $registrasi_id;
		return view('sep.cetak_label_firefox', $data);
	}


	public function searchUpdateSEP(){
		$data = [];
		return view('sep.form_update', $data);
	}

	public function updateSEP(Request $request){
		$sep = $request['nosep'];
		$registrasi = Registrasi::where('no_sep', $sep)->first();
		if (!$registrasi) {
			Flashy::info('Data tidak ditemukan, SEP dari VCLAM');
		    $data = [];
			return view('sep.form_update', $data);
		}
		$data['reg'] = Registrasi::where('no_sep', $sep)->first();
		// return $data['reg']; die;
		$data['poli'] = Poli::select('nama', 'bpjs')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'kode_bpjs')->get();
		$data['poli_bpjs'] = Poli::find($data['reg']->poli_id)->bpjs;
		$data['dokter_bpjs'] = Pegawai::find($data['reg']->dokter_id)->kode_bpjs;	
		$data['bpjsprov'] = BpjsProv::select('propinsi', 'kode')->get();
		$data['bpjskab'] = BpjsKab::pluck('kabupaten', 'kode');
		$data['bpjskec'] = BpjsKec::pluck('kecamatan', 'kode');
		return view('sep.form_update', $data);
	}

	public function simpanUpdateSEP(Request $request)
	{
		$cek = Validator::make($request->all(), [
			'penjamin'		=> 'required',
			'tglKejadian'	=> 'required',
			'kll'			=> 'required',
			'suplesi'		=> 'required',
			'noSepSuplesi'	=> 'required',
			'kdPropinsi'	=> 'required',
			'kdKabupaten'	=> 'required',
			'kdKecamatan'	=> 'required'
		], [
			'kll.required'	=> 'Keterangan laka harus diisi !',
			'kdPropinsi.required' => 'Propinsi harus diisi !',
			'kdKabupaten.required' => 'Kabupaten harus diisi !',
			'kdKecamatan.required' => 'Kecamatan harus diisi !'
		]);

		if ($request->laka_lantas == 1) {
			if ($cek->fails()) {
				return response()->json(['error' => $cek->errors()]);
			}
		}

		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$noKartu = $request['no_bpjs'];
		$notelp = $request["no_tlp"];
		$TglRujuk = $request['tgl_rujukan'];
		$noRujuk = $request['no_rujukan'];
		$asalRujukan = $request["asalRujukan"];
		$ppkRujuk = $request['ppk_rujukan'];
		$ppkLayanan = config('app.sep_ppkLayanan');
		$jnsLayanan = $request["jenis_layanan"];
		$catatan = $request["catatan_bpjs"];
		$ArrayregdiagAwal = $request["diagnosa_awal"];

		$regdiagAwal = $request["diagnosa_awal"];
		$ArrayPoliTujuan = explode("-", $request["poli_bpjs"]);
		$poliTujuan = $request['poli_bpjs'];
		$kodeKelas = $request["hak_kelas_inap"];
		$lakaLantas = $request["laka_lantas"];
		$cob = $request["cob"];
		$katarak = $request["katarak"];
		if ($lakaLantas == 1) {
			$penjamin = $request["penjamin"];
		} else {
			$penjamin = NULL;
		}
		$tglKejadian = $request["tglKejadian"];
		$kll = $request["kll"];
		$suplesi = $request["suplesi"];
		$noSepSuplesi = $request["noSepSuplesi"];
		$kdPropinsi = $request['kdPropinsi'];
		$kdKabupaten = $request['kdKabupaten'];
		$kdKecamatan = $request['kdKecamatan'];
		$noSurat = $request['noSurat'];
		$kodeDPJP = $request['kodeDPJP'];
		$dpjpLayan = $request['dpjpLayan'];
		@$no_lp = @$request['no_lp'];
		// $noSurat          = '987656';
		// $kodeDPJP         = '37527';
		$noMR = $request["no_rm"];
		$tglSep = $request["tglSep"];

		$request = '{
				       "request": {
				          "t_sep": {
				             "noSep": "' . $request['no_sep'] . '", 
							 "klsRawat":{
                                "klsRawatHak":"' . $kodeKelas . '",
                                "klsRawatNaik":"",
                                "pembiayaan":"",
                                "penanggungJawab":""
                              },
				             "noMR": "' . $noMR . '", 
				             "catatan": "' . $catatan . '",
				             "diagAwal": "' . $regdiagAwal . '",
				             "poli": {
								"tujuan": "IGD",
				                "eksekutif": "0"
				             },
				             "cob": {
				                "cob": "' . $cob . '"
				             },
				             "katarak":{
				                "katarak":"' . $katarak . '"
				             },
				             "skdp":{
				                "noSurat":"' . $noSurat . '",
				                "kodeDPJP":"' . $kodeDPJP . '"            
				             },
				             "jaminan": {
				                "lakaLantas":"' . $lakaLantas . '",
				                "noLP":"' . $no_lp . '",
				                "penjamin":
				                {
				                    "penjamin":"' . $penjamin . '",
				                    "tglKejadian":"' . $tglKejadian . '",				
				                    "keterangan":"' . $kll . '",
				                    "suplesi":
				                        {
				                            "suplesi":"' . $suplesi . '",
				                            "noSepSuplesi":"' . $noSepSuplesi . '",
				                            "lokasiLaka": 
				                                {
				                                "kdPropinsi":"' . $kdPropinsi . '",
				                                "kdKabupaten":"' . $kdKabupaten . '",
				                                "kdKecamatan":"' . $kdKecamatan . '"
				                                }
				                        }					
				                }
				             },             
				             "noTelp": "' . $notelp . '",
							 "dpjpLayan": "'.$dpjpLayan.'",
				             "user": "User"
				          }
				       }
				    }  ';
		//echo $request;die;
		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/update"; //Update

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: Application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		//echo $json; die;

		if ($sml['metaData']['message'] == 'Sukses') {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);
			//$sep = 'No. SEP adalah: '.$sml['response'];
			return response()->json(['sukses' => $sep,'cetak'=>$sep]);
		} else {
			//$sep = $sml['metadata']['message'];
			return response()->json(['msg' => $sml['metaData']['message']]);
		}
	}



	public function sepRujukan() {
		$data['poli'] = Poli::pluck('nama', 'bpjs');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['reg'] = Registrasi::find(session('reg_id'));
		return view('sep.form_create_rujukan', $data);
	}

	function HashBPJS() {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');

		date_default_timezone_set('Asia/Jakarta');
		$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
		$encodedSignature = base64_encode($signature);
		// $encodedSignature = \LZCompressor\LZString::compressToBase64($signature);;
		return array($ID, $t, $encodedSignature);
	}

	// SUDAH V2
	function xrequest($url, $signature, $ID, $t) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "Content-Type: application/json";
		$headers[] = "X-Cons-Id:" . $ID;
		$headers[] = "X-Timestamp:" . $t;
		$headers[] = "X-Signature:" . $signature;
		$headers[] = "user_key:" . config('app.user_key');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$message = 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $response;
	}

	public function cari_nojkn(Request $request) {
		// dd($request);
		request()->validate(['no_kartu' => 'required']);
		list($ID, $t, $signature) = $this->HashBPJS();

		// $completeurl = config('app.sep_url_web_service') . "/Rujukan/Peserta/" . $request['no_kartu']; //sdh punya rujukan
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/List/Peserta/" . \LZCompressor\LZString::decompressFromEncodedURIComponent($request['no_kartu']); //Multiple
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);

		// $hasil = json_decode($response);
		// $sml = json_encode($hasil);
		// $encodedResult = \LZCompressor\LZString::compressToBase64($sml);
		// dd($encodedResult);
		return response()->json($sml);
	}

	public function cariHistoriPelayanan(Request $request) {
		$dateTwoWeekBefore = date('Y-m-d',strtotime('-2 weeks'));
		$dateNow 		   = date('Y-m-d');
		$noKartu 		   = \LZCompressor\LZString::decompressFromEncodedURIComponent($request['no_kartu']);

		request()->validate(['no_kartu' => 'required']);
		list($ID, $t, $signature) = $this->HashBPJS();
		
		$completeurl = config('app.sep_url_web_service') . "/monitoring/HistoriPelayanan/NoKartu/".$noKartu."/tglMulai/".$dateTwoWeekBefore."/tglAkhir/".$dateNow;
		// dd($completeurl);
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		// dd($sml);
		return response()->json($sml);
	}

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
	// SUDAH V2
	function signature(){
		
		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$user_key = config('app.user_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));


		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'.$user_key, 
			'Content-Type: application/json; charset=utf-8',
		);

		return response()->json($arrheader);
		
		// $json = json_encode($sml);
		// echo $json;die;
	}

	function resp(Request $request){
		$ID = config('app.sep_id');
		$t = $request->time;
		// $array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$request['response']);
		
		$data = json_decode($this->decompress($stringEncrypt),true);
		return response()->json($data);
		// $sml = json_encode($array,JSON_PRETTY_PRINT);
	}

	function poli($polikode){
		
		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$user_key = config('app.user_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service')."/referensi/poli/". $polikode;

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'.$user_key, 
			'Content-Type: application/json; charset=utf-8',
		);

		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
		// $sml = json_decode($response, true);

		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		dd($sml);
		// $json = json_encode($sml);
		// echo $json;die;
	}
	// SUDAH V2
	function ref_dokter($polikode){
		
		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$user_key = config('app.user_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service')."/referensi/dokter/pelayanan/1/tglPelayanan/" . date('Y-m-d') . "/Spesialis/" . $polikode;

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'.$user_key, 
			'Content-Type: application/json; charset=utf-8',
		);
		// dd($arrheader);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		// dd($response);
		// dd([
		// 	'header'=>$arrheader,
		// 	'url'=>$completeurl,
		// 	'response'=>$response]);

		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		// dd([
		// 	'header'=>$arrheader,
		// 	'url'=>$completeurl,
		// 	'response'=>$sml]);
		// // $sml = json_decode($response, true);
		dd($sml);
		// $json = json_encode($sml);
		// echo $json;die;
	}

	// SUDAH V2
	public function cari_nojkn_igd(Request $request) {

		// dd($request);
		request()->validate(['no_kartu' => 'required']);
		list($ID, $t, $signature) = $this->HashBPJS();
		// dd(\LZCompressor\LZString::decompressFromEncodedURIComponent($request['no_kartu']));
		$completeurl = config('app.sep_url_web_service') . "/Peserta/nokartu/" . \LZCompressor\LZString::decompressFromEncodedURIComponent($request['no_kartu']) . "/tglSEP/" . date('Y-m-d'); //igd atau manual
		// dd($completeurl);
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		
		if($response==null || $response==false || empty($response)){
			$json = [['metaData'=>['code'=>'201','message'=>'NULL']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}

		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		
		return response()->json($sml);
	}

	// SUDAH V2
	public function cari_nojknIRNA($no_kartu) {
		list($ID, $t, $signature) = $this->HashBPJS();

		$completeurl = config('app.sep_url_web_service') . "/Peserta/nokartu/" . \LZCompressor\LZString::decompressFromEncodedURIComponent($no_kartu) . "/tglSEP/" . date('Y-m-d');

		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if($response==null){
			$json = [['metaData'=>['code'=>'201','message'=>'NULL']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		
		// $encodedResult = \LZCompressor\LZString::compressToBase64($sml);
		return response()->json($sml);
	}

	// SUDAH V2
	public function cari_nikIRNA($nik) {
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.sep_url_web_service') . "/Peserta/nik/" . \LZCompressor\LZString::decompressFromEncodedURIComponent($nik) . "/tglSEP/" . date('Y-m-d');

		$response = $this->xrequest($completeurl, $signature, $ID, $t);

		if($response==null){
			$json = [['metaData'=>['code'=>'201','message'=>'NULL']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		
		// $encodedResult = \LZCompressor\LZString::compressToBase64($sml);
		return response()->json($sml);
	}
	
	// SUDAH V2
	public function getDataByRujukan(Request $request) {
		
		if($request->data){
			request()->validate(['data' => 'required']);
			$re = \LZCompressor\LZString::decompressFromBase64($request->data);
			$removeParam = str_replace("no_rujukan=","",$re);
			$no_rujukan_encode = explode('&',$removeParam);
			$no_rujukan = $no_rujukan_encode[2];
		}else{
			$no_rujukan = $request['no_rujukan'];
		}
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/" . $no_rujukan;

		//$completeurl = "https://dvlp.bpjs-kesehatan.go.id/vclaim-rest/Rujukan/RS/".$request['no_rujukan']; //Rumah sakit
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		
		// $encodedResult = \LZCompressor\LZString::compressToBase64($sml);
		return response()->json($sml);
	}

	// SUDAH V2
	public function cari_nik(Request $request) {

		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.sep_url_web_service') . "/Peserta/nik/" . \LZCompressor\LZString::decompressFromEncodedURIComponent($request['nik'])  . "/tglSEP/" . date('Y-m-d');

		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if($response==null){
			$json = [['metaData'=>['code'=>'201','message'=>'NULL']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}

		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);

		$sml = json_encode($array,JSON_PRETTY_PRINT);
		
		return response()->json($sml);

	}

	public function cari_ppk2ByNoka(Request $request) {
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/RS/Peserta/" . $request['noka'];

		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$hasil = json_decode($response);
		$sml = json_encode($hasil);
		return response()->json($hasil);
	}

	// SUDAH V2
	public function buat_sep(Request $req) {
		$re = \LZCompressor\LZString::decompressFromBase64($req->data);
		$request = array();
		parse_str($re, $request);
		
		
		$cek = Validator::make($request, [
			'penjamin'		=> 'required',
			'tglKejadian'	=> 'required',
			'kll'			=> 'required',
			'suplesi'		=> 'required',
			'noSepSuplesi'	=> 'required',
			'kdPropinsi'	=> 'required',
			'kdKabupaten'	=> 'required',
			'kdKecamatan'	=> 'required'
		], [
			'kll.required'	=> 'Keterangan laka harus diisi !',
			'kdPropinsi.required' => 'Propinsi harus diisi !',
			'kdKabupaten.required' => 'Kabupaten harus diisi !',
			'kdKecamatan.required' => 'Kecamatan harus diisi !'
		]);
		
		$registrasi_id = $request['registrasi_id'];
        $reg = Registrasi::find($registrasi_id);
		
		if(substr($reg->status_reg, 0, 1) == 'J'){
			$noantri = Registrasi::where('nomorantrian','like',date('dmY') . '%')->count();
			$nomorantrian = date('dmY').sprintf("%04s",$noantri+1);
			@$kuotaJKN = @Poli::where('bpjs',@baca_bpjs_poli(@$reg->poli_id))->first()->kuota; 
			$nomor = substr($nomorantrian,-4);
			// dd($nomor);
				
			@$pasienbaru = $request['no_rm'] ? 0 : 1;
			
			// $tgl = $request['tglrujukan'] ? $request['tglrujukan'] : date('Y-m-d');
			@$bayar = @$reg->bayar == '1' ? 'JKN' : 'NON JKN';
			@$estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
			@$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
			@$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
			
			if(empty($reg->nomorantrian)){
				$reg->nomorantrian = $nomorantrian;
				$reg->save();
			}else{
				$reg->nomorantrian;
				$nomor = substr($reg->nomorantrian,-4);
			}

			if($request['jenisKunjungan'] == '3' || $request['tujuanKunj'] == '2'){
				$noref = $request['noSurat'];
			}else{
				$noref = $request['no_rujukan'];
			}

			if (str_contains($noref, 'K')) {
				$request['jenisKunjungan'] = '3';
			}
			
			$req   = '{
				"kodebooking": "'.@$reg->nomorantrian.'",
				"jenispasien": "'.@$bayar.'",
				"nomorkartu": "'.@$request['no_bpjs'].'",
				"nik": "'.@$request['nik'].'",
				"nohp": "'.@$request['no_tlp'].'",
				"kodepoli": "'.@$request['poli_bpjs'].'",
				"namapoli": "'.baca_kode_poli(@$request['poli_bpjs']).'", 
				"pasienbaru": "'.@$pasienbaru.'",
				"norm": "'.@$request['no_rm'].'",
				"tanggalperiksa": "'.date('Y-m-d').'", 
				"kodedokter": "'.@$request['kodeDPJP'].'", 
				"namadokter": "'.baca_dokter_bpjs(@$request['kodeDPJP']).'",
				"jampraktek": "'.(@$jam_start.'-'.@$jam_end).'",
				"jeniskunjungan": "'.@$request['jenisKunjungan'].'",
				"nomorreferensi": "'.@$noref.'",
				"nomorantrean": "'.@$nomor.'",
				"angkaantrean": "'.(int) @$nomor.'",
				"estimasidilayani": "'.@$estimasi.'",
				"sisakuotajkn":"'.@$kuotaJKN.'",
				"kuotajkn": "'.@$kuotaJKN.'",
				"sisakuotanonjkn": "0",
				"kuotanonjkn": "0",
				"keterangan": "'.@$request['keterangan'].'"
			}';
			
			
			$completeurlantr = config('app.antrean_url_web_service')."antrean/add";
			$sessionan = curl_init($completeurlantr);
			
			// dd(json_decode($body_prb));
			curl_setopt($sessionan, CURLOPT_HTTPHEADER, signature_bpjs());
			curl_setopt($sessionan, CURLOPT_POSTFIELDS, $req);
			curl_setopt($sessionan, CURLOPT_POST, TRUE);
			curl_setopt($sessionan, CURLOPT_RETURNTRANSFER, TRUE);
			$responseantr= curl_exec($sessionan);
			// dd($responseantr);
			@$jsonrespon = json_decode($responseantr, true); 
			// dd($jsonrespon);
			// dd($req);
			// UPDATE TASKID1
			$updatewaktu   = '{
				"kodebooking": "'.@$reg->nomorantrian.'",
				"taskid": 1,
				"waktu": "'.round(microtime(true) * 1000).'"
			}';
			sleep(1);
			$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			$session = curl_init($completeurl2);
			curl_setopt($session, CURLOPT_HTTPHEADER, signature_bpjs());
			curl_setopt($session, CURLOPT_POSTFIELDS, $updatewaktu);
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			$sml = json_decode($response, true); 
			// dd($sml);
			// INSERT KE TABLE LOG BPJS
			if(cek_status_reg(@$reg->status_reg) == 'J'){
				$bpjslog = BpjsLog::where('nomorantrian',@$reg->nomorantrian)->first();
				if(isset($jsonrespon) && isset($sml)){
					if(@$jsonrespon['metadata']['code'] !== 208 && @$sml['metadata']['code'] !== 208 && @$sml['metadata']['message'] !== 'TaskId terakhir 5'){
						if(!$bpjslog){
							$bpjslog = new BpjsLog();
						}
						$bpjslog->request = @$req;
						// if(isset($sml)){
						$bpjslog->status = @$jsonrespon['metadata']['code'];
						// }
						$bpjslog->response = @$responseantr;
						$bpjslog->response_taskid = @$response;
						$bpjslog->url = url()->full();
						$bpjslog->user_id = @Auth::user()->id;
						$bpjslog->penginput = @Auth::user()->name;
						$bpjslog->nomorantrian = @$reg->nomorantrian;
						$bpjslog->save();
					}
				}
				
			}
			
			
			//  UPDATE TASKID ID 2
			$updatewaktu2   = '{
				"kodebooking": "'.@$reg->nomorantrian.'",
				"taskid": 2,
				"waktu": "'.randomWaktu2().'"
			}';
			$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			$session2 = curl_init($completeurl2);
			curl_setopt($session2, CURLOPT_HTTPHEADER, signature_bpjs());
			curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu2);
			curl_setopt($session2, CURLOPT_POST, TRUE);
			curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			curl_exec($session2);
			
			//  UPDATE TASKID 3
			$updatewaktu3   = '{
				"kodebooking": "'.@$reg->nomorantrian.'",
				"taskid": 3,
				"waktu": "'.randomWaktu3().'"
			}';
			$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			$session3 = curl_init($completeurl2);
			curl_setopt($session3, CURLOPT_HTTPHEADER, signature_bpjs());
			curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu3);
			curl_setopt($session3, CURLOPT_POST, TRUE);
			curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
			curl_exec($session3);
		}
		

		//  dd($)
		// dd($req);
		// dd($nomorantrian);
		// dd($request);
		if($request['laka_lantas'] == 1){
			if ($cek->fails()) {
				return response()->json(['error' => $cek->errors()]);
			}
		}

		// dd($request);

		// $data['reg'] = Registrasi::find($request['registrasi_id']);
		// dd($data['reg']);
		// if(isset($data['reg'])){
		// 	if($data['reg']->nomorantrian){
		// 		$ID = config('app.consid_antrean');
		// 		date_default_timezone_set('Asia/Jakarta');
		// 		$t = time();
		// 		$dat = "$ID&$t";
		// 		$secretKey = config('app.secretkey_antrean');
		// 		$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
		// 		$completeurl = config('app.antrean_url_web_service')."antrean/updatewaktu";
		// 		$arrheader = array(
		// 			'X-cons-id: ' . $ID,
		// 			'X-timestamp: ' . $t,
		// 			'X-signature: ' . $signature,
		// 			'user_key:'. config('app.user_key_antrean'),
		// 			'Content-Type: application/json',
		// 		);
				
		// 		$updatewaktu   = '{
		// 			"kodebooking": "'.@$data['reg']->nomorantrian.'",
		// 			"taskid": "4",
		// 			"waktu": "'.round(microtime(true) * 1000).'"
		// 		}';
		// 		$session2 = curl_init($completeurl);
		// 		curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
		// 		curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
		// 		curl_setopt($session2, CURLOPT_POST, TRUE);
		// 		curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
		// 		curl_exec($session2);
		// 		// sleep(3);
				
				
		// 		$updatewaktu5   = '{
		// 			"kodebooking": "'.@$data['reg']->nomorantrian.'",
		// 			"taskid": "5",
		// 			"waktu": "'.round(microtime(true) * 1000).'"
		// 		}';
		// 		$session5 = curl_init($completeurl);
		// 		curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
		// 		curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
		// 		curl_setopt($session5, CURLOPT_POST, TRUE);
		// 		curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
		// 		curl_exec($session5);
		// 		// sleep(3);
		// 	}
		// }

		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$noKartu = $request['no_bpjs'];
		$notelp = $request["no_tlp"];
		$TglRujuk = $request['tgl_rujukan'];
		$noRujuk = $request['no_rujukan'];
		$asalRujukan = $request["asalRujukan"];
		$ppkRujuk = $request['ppk_rujukan'];
		// $ppkRujuk = '0620R001';
		$ppkLayanan = config('app.sep_ppkLayanan');
		$jnsLayanan = $request["jenis_layanan"];
		// dd($jnsLayanan);
		$catatan = $request["catatan_bpjs"];
		$ArrayregdiagAwal = $request["diagnosa_awal"];

		$regdiagAwal = $request["diagnosa_awal"];
		$ArrayPoliTujuan = explode("-", $request["poli_bpjs"]);
		$poliTujuan = $request['poli_bpjs'];
		$kodeKelas = $request["hak_kelas_inap"];
		$kodeKelasNaik = $request["hak_kelas_inap_naik"];
		$pembiayaan = $request["pembiayaan"];
		$penanggungJawab = penanggungJawabSep($pembiayaan);
		$tujuanKunj = $request["tujuanKunj"];
		$flagProcedure = $request["flagProcedure"];
		$kdPenunjang = $request["kdPenunjang"];
		$assesmentPel = $request["assesmentPel"];
		// $dpjpLayanan = $request["dpjpLayanan"];
		
		$lakaLantas = $request["laka_lantas"];
		$cob = $request["cob"];
		$katarak = $request["katarak"];

		$penjamin = $request["penjamin"];
		$tglKejadian = $request["tglKejadian"];
		$kll = $request["kll"];
		$suplesi = $request["suplesi"];
		$noSepSuplesi = $request["noSepSuplesi"];
		$kdPropinsi = $request['kdPropinsi'];
		$kdKabupaten = $request['kdKabupaten'];
		$kdKecamatan = $request['kdKecamatan'];
		$noSurat = $request['noSurat'];
		$kodeDPJP = $request['kodeDPJP'];
		$dpjpLayan = $request['dpjpLayan'];
		@$no_lp = @$request['no_lp'];
		// $noSurat          = '987656';
		// $kodeDPJP         = '37527';
		$noMR = $request["no_rm"];
		$tglSep = $request["tglSep"];
		// dd($request);
		$request = '{
                 "request": {
                    "t_sep": {
                       "noKartu": "' . $noKartu . '",
                       "tglSep": "' . $tglSep . '",
                       "ppkPelayanan": "' . config('app.sep_ppkLayanan') . '",
                       "jnsPelayanan": "' . $jnsLayanan . '",
                       "klsRawat": {
						   "klsRawatHak":"'.$kodeKelas.'",
						   "klsRawatNaik":"'.$kodeKelasNaik.'",
						   "pembiayaan":"'.$pembiayaan.'",
						   "penanggungJawab":"'.$penanggungJawab.'"
					   },
                       "noMR": "' . $noMR . '",
                       "rujukan": {
                          "asalRujukan": "' . $asalRujukan . '",
                          "tglRujukan": "' . $TglRujuk . '",
                          "noRujukan":"' . $noRujuk . '",
                          "ppkRujukan": "' . $ppkRujuk . '"
                       },
                       "catatan": "' . $catatan . '",
                       "diagAwal": "' . $regdiagAwal . '",
                       "poli": {
                          "tujuan": "' . $poliTujuan . '",
                          "eksekutif": "0"
                       },
                       "cob": {
                          "cob": "' . $cob . '"
                       },
                       "katarak": {
                          "katarak": "' . $katarak . '"
                       },
                       "jaminan": {
                          "lakaLantas": "' . $lakaLantas . '",
                          "noLP": "' . $no_lp . '",
                          "penjamin": {
                              "penjamin": "' . $penjamin . '",
                              "tglKejadian": "' . $tglKejadian . '",
                              "keterangan": "' . $kll . '",
                              "suplesi": {
                                  "suplesi": "' . $suplesi . '",
                                  "noSepSuplesi": "' . $noSepSuplesi . '",
                                  "lokasiLaka": {
                                      "kdPropinsi": "' . $kdPropinsi . '",
                                      "kdKabupaten": "' . $kdKabupaten . '",
                                      "kdKecamatan": "' . $kdKecamatan . '"
                                      }
                              }
                          }
                       },
					   "tujuanKunj": "' . $tujuanKunj . '",
					   "flagProcedure": "' . $flagProcedure . '",
					   "kdPenunjang": "' . $kdPenunjang . '",
					   "assesmentPel": "'.$assesmentPel.'",
                       "skdp": {
                          "noSurat": "' . $noSurat . '",
                          "kodeDPJP": "' . $kodeDPJP . '"
                       },
					   "dpjpLayan": "'.$dpjpLayan.'",
                       "noTelp": "' . $notelp . '",
                       "user": "VCLAIM"
                    }
                 }
              }'; 

		@$sep_log = SepLog::where('registrasi_id',$reg->id)->first();
		if(!$sep_log){
			@$sep_log = new SepLog();
		}
		$sep_log->registrasi_id = @$reg->id ;
		$sep_log->request = @$request;
		$sep_log->url = @url()->full();
		$sep_log->penginput = @Auth::user()->name;
		$sep_log->save();
		//echo $request;die;
		// return response()->json(json_decode($request));
		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/insert"; //Insert

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		
		$sml = json_decode($response, true); 
		
		// @$sep_log->response = @$response;
		// @$sep_log->save();

		if ($sml['metaData']['message'] == 'Sukses') {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);
			//$sep = 'No. SEP adalah: '.$sml['response'];
			// dd($sep);

			@$sep_log->response = @json_encode($stringEncrypt);
			@$sep_log->save();
			return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
		} else {
			@$sep_log->response = @$response;
			@$sep_log->save();
			//$sep = $sml['metadata']['message'];
			return response()->json(['msg' => $sml['metaData']['message']]);
		}

	}

	public function buat_sep_inap(Request $req) {
		$re = \LZCompressor\LZString::decompressFromBase64($req->data);
		$request = array();
		parse_str($re, $request);
		
		
		$cek = Validator::make($request, [
			'penjamin'		=> 'required',
			'tglKejadian'	=> 'required',
			'kll'			=> 'required',
			'suplesi'		=> 'required',
			'noSepSuplesi'	=> 'required',
			'kdPropinsi'	=> 'required',
			'kdKabupaten'	=> 'required',
			'kdKecamatan'	=> 'required'
		], [
			'kll.required'	=> 'Keterangan laka harus diisi !',
			'kdPropinsi.required' => 'Propinsi harus diisi !',
			'kdKabupaten.required' => 'Kabupaten harus diisi !',
			'kdKecamatan.required' => 'Kecamatan harus diisi !'
		]);
		
		$registrasi_id = $request['registrasi_id'];
        $reg = Registrasi::find($registrasi_id);

		

		//  dd($)
		// dd($req);
		// dd($nomorantrian);
		// dd($request);
		if($request['laka_lantas'] == 1){
			if ($cek->fails()) {
				return response()->json(['error' => $cek->errors()]);
			}
		}

		

		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$noKartu = $request['no_bpjs'];
		$notelp = $request["no_tlp"];
		$TglRujuk = $request['tgl_rujukan'];
		$noRujuk = $request['no_rujukan'];
		$asalRujukan = $request["asalRujukan"];
		$ppkRujuk = $request['ppk_rujukan'];
		// $ppkRujuk = '0620R001';
		$ppkLayanan = config('app.sep_ppkLayanan');
		$jnsLayanan = $request["jenis_layanan"];
		// dd($jnsLayanan);
		$catatan = $request["catatan_bpjs"];
		$ArrayregdiagAwal = $request["diagnosa_awal"];

		$regdiagAwal = $request["diagnosa_awal"];
		$ArrayPoliTujuan = explode("-", $request["poli_bpjs"]);
		$poliTujuan = $request['poli_bpjs'];
		$kodeKelas = $request["hak_kelas_inap"];
		$kodeKelasNaik = $request["hak_kelas_inap_naik"];
		$pembiayaan = $request["pembiayaan"];
		$penanggungJawab = penanggungJawabSep($pembiayaan);
		$tujuanKunj = $request["tujuanKunj"];
		$flagProcedure = $request["flagProcedure"];
		$kdPenunjang = $request["kdPenunjang"];
		$assesmentPel = $request["assesmentPel"];
		// $dpjpLayanan = $request["dpjpLayanan"];
		
		$lakaLantas = $request["laka_lantas"];
		$cob = $request["cob"];
		$katarak = $request["katarak"];

		$penjamin = $request["penjamin"];
		$tglKejadian = $request["tglKejadian"];
		$kll = $request["kll"];
		$suplesi = $request["suplesi"];
		$noSepSuplesi = $request["noSepSuplesi"];
		$kdPropinsi = $request['kdPropinsi'];
		$kdKabupaten = $request['kdKabupaten'];
		$kdKecamatan = $request['kdKecamatan'];
		$noSurat = $request['noSurat'];
		@$no_lp = @$request["no_lp"];
		
		$dpjpLayan = $request['dpjpLayan'];

		// INI KODE DPJP
		@$dokter = Pegawai::find($request['dokter_id']);
		$kodeDPJP = @$dokter->kode_bpjs;
		// $dpjpLayan = $request['dpjpLayan'] ?? null;
		// $noSurat          = '987656';
		// $kodeDPJP         = '37527';
		$noMR = $request["no_rm"];
		$tglSep = $request["tglSep"];
		
		// dd($request);
		$request = '{
                 "request": {
                    "t_sep": {
                       "noKartu": "' . $noKartu . '",
                       "tglSep": "' . $tglSep . '",
                       "ppkPelayanan": "' . config('app.sep_ppkLayanan') . '",
                       "jnsPelayanan": "' . $jnsLayanan . '",
                       "klsRawat": {
						   "klsRawatHak":"'.$kodeKelas.'",
						   "klsRawatNaik":"'.$kodeKelasNaik.'",
						   "pembiayaan":"'.$pembiayaan.'",
						   "penanggungJawab":"'.$penanggungJawab.'"
					   },
                       "noMR": "' . $noMR . '",
                       "rujukan": {
                          "asalRujukan": "' . $asalRujukan . '",
                          "tglRujukan": "' . $TglRujuk . '",
                          "noRujukan":"' . $noRujuk . '",
                          "ppkRujukan": "' . $ppkRujuk . '"
                       },
                       "catatan": "' . $catatan . '",
                       "diagAwal": "' . $regdiagAwal . '",
                       "poli": {
                          "tujuan": "' . $poliTujuan . '",
                          "eksekutif": "0"
                       },
                       "cob": {
                          "cob": "' . $cob . '"
                       },
                       "katarak": {
                          "katarak": "' . $katarak . '"
                       },
                       "jaminan": {
                          "lakaLantas": "' . $lakaLantas . '",
                          "noLP": "' . $no_lp . '",
                          "penjamin": {
                              "penjamin": "' . $penjamin . '",
                              "tglKejadian": "' . $tglKejadian . '",
                              "keterangan": "' . $kll . '",
                              "suplesi": {
                                  "suplesi": "' . $suplesi . '",
                                  "noSepSuplesi": "' . $noSepSuplesi . '",
                                  "lokasiLaka": {
                                      "kdPropinsi": "' . $kdPropinsi . '",
                                      "kdKabupaten": "' . $kdKabupaten . '",
                                      "kdKecamatan": "' . $kdKecamatan . '"
                                      }
                              }
                          }
                       },
					   "tujuanKunj": "' . $tujuanKunj . '",
					   "flagProcedure": "' . $flagProcedure . '",
					   "kdPenunjang": "' . $kdPenunjang . '",
					   "assesmentPel": "'.$assesmentPel.'",
                       "skdp": {
                          "noSurat": "' . $noSurat . '",
                          "kodeDPJP": "' . $kodeDPJP . '"
                       },
					   "dpjpLayan": "'.$dpjpLayan.'",
                       "noTelp": "' . $notelp . '",
                       "user": "VCLAIM"
                    }
                 }
              }'; 
		
		//echo $request;die;
		// return response()->json(json_decode($request));
		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/insert"; //Insert

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		
		$sml = json_decode($response, true); 
		 
		if ($sml['metaData']['message'] == 'Sukses') {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);
			//$sep = 'No. SEP adalah: '.$sml['response'];
			// dd($sep);
			return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
		} else {
			//$sep = $sml['metadata']['message'];
			return response()->json(['msg' => $sml['metaData']['message']]);
		}

	}
	public function buat_sep_validasi(Request $req) {
		$re = \LZCompressor\LZString::decompressFromBase64($req->data);
		$request = array();
		parse_str($re, $request);
		
		
		$cek = Validator::make($request, [
			'penjamin'		=> 'required',
			'tglKejadian'	=> 'required',
			'kll'			=> 'required',
			'suplesi'		=> 'required',
			'noSepSuplesi'	=> 'required',
			'kdPropinsi'	=> 'required',
			'kdKabupaten'	=> 'required',
			'kdKecamatan'	=> 'required'
		], [
			'kll.required'	=> 'Keterangan laka harus diisi !',
			'kdPropinsi.required' => 'Propinsi harus diisi !',
			'kdKabupaten.required' => 'Kabupaten harus diisi !',
			'kdKecamatan.required' => 'Kecamatan harus diisi !'
		]);
		
		$registrasi_id = $request['registrasi_id'];
        $reg = Registrasi::find($registrasi_id);
		
		if(substr($reg->status_reg, 0, 1) == 'J'){
			$noantri = Registrasi::where('nomorantrian','like',date('dmY') . '%')->count();
			$nomorantrian = date('dmY').sprintf("%04s",$noantri+1);
			@$kuotaJKN = @Poli::where('bpjs',@baca_bpjs_poli(@$reg->poli_id))->first()->kuota; 
			$nomor = substr($nomorantrian,-4);
			// dd($nomor);
				
			@$pasienbaru = $request['no_rm'] ? 0 : 1;
			
			// $tgl = $request['tglrujukan'] ? $request['tglrujukan'] : date('Y-m-d');
			@$bayar = @$reg->bayar == '1' ? 'JKN' : 'NON JKN';
			@$estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
			@$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
			@$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
			
			if(empty($reg->nomorantrian)){
				$reg->nomorantrian = $nomorantrian;
				$reg->save();
			}else{
				$reg->nomorantrian;
				$nomor = substr($reg->nomorantrian,-4);
			}
			if($request['jenisKunjungan'] == '3' || $request['tujuanKunj'] == '2'){
				$noref = $request['noSurat'];
			}else{
				$noref = $request['no_rujukan'];
			}
			if (str_contains($noref, 'K')) {
				$request['jenisKunjungan'] = '3';
			}
			$req   = '{
				"kodebooking": "'.@$reg->nomorantrian.'",
				"jenispasien": "'.@$bayar.'",
				"nomorkartu": "'.@$request['no_bpjs'].'",
				"nik": "'.@$request['nik'].'",
				"nohp": "'.@$request['no_tlp'].'",
				"kodepoli": "'.@$request['poli_bpjs'].'",
				"namapoli": "'.baca_kode_poli(@$request['poli_bpjs']).'", 
				"pasienbaru": "'.@$pasienbaru.'",
				"norm": "'.@$request['no_rm'].'",
				"tanggalperiksa": "'.@date('Y-m-d').'", 
				"kodedokter": "'.@$request['kodeDPJP'].'", 
				"namadokter": "'.baca_dokter_bpjs(@$request['kodeDPJP']).'",
				"jampraktek": "'.(@$jam_start.'-'.@$jam_end).'",
				"jeniskunjungan": "'.@$request['jenisKunjungan'].'",
				"nomorreferensi": "'.@$noref.'",
				"nomorantrean": "'.@$nomor.'",
				"angkaantrean": "'.(int) @$nomor.'",
				"estimasidilayani": "'.@$estimasi.'",
				"sisakuotajkn":"'.@$kuotaJKN.'",
				"kuotajkn": "'.@$kuotaJKN.'",
				"sisakuotanonjkn": "0",
				"kuotanonjkn": "0",
				"keterangan": "'.@$request['keterangan'].'"
			}';
			
			
			
			$completeurlantr = config('app.antrean_url_web_service')."antrean/add";
			$sessionan = curl_init($completeurlantr);
			
			// dd(json_decode($body_prb));
			curl_setopt($sessionan, CURLOPT_HTTPHEADER, signature_bpjs());
			curl_setopt($sessionan, CURLOPT_POSTFIELDS, $req);
			curl_setopt($sessionan, CURLOPT_POST, TRUE);
			curl_setopt($sessionan, CURLOPT_RETURNTRANSFER, TRUE);
			$responseantr= curl_exec($sessionan);
			
			@$jsonrespon = json_decode($responseantr, true); 
			if($jsonrespon !== null){

				// EKSEKUSI ADD ANTRIAN LAGI JIKA RUJUKAN TIDAK VALID DENGAN JENIS KUNJUNGAN = 1
				// if($jsonrespon['metadata']['message'] == 'Rujukan tidak valid'){
				// 	$req2   = '{
				// 		"kodebooking": "'.@$reg->nomorantrian.'",
				// 		"jenispasien": "'.@$bayar.'",
				// 		"nomorkartu": "'.@$request['no_bpjs'].'",
				// 		"nik": "'.@$request['nik'].'",
				// 		"nohp": "'.@$request['no_tlp'].'",
				// 		"kodepoli": "'.@$request['poli_bpjs'].'",
				// 		"namapoli": "'.baca_kode_poli(@$request['poli_bpjs']).'", 
				// 		"pasienbaru": "'.@$pasienbaru.'",
				// 		"norm": "'.@$request['no_rm'].'",
				// 		"tanggalperiksa": "'.@date('Y-m-d').'", 
				// 		"kodedokter": "'.@$request['kodeDPJP'].'", 
				// 		"namadokter": "'.baca_dokter_bpjs(@$request['kodeDPJP']).'",
				// 		"jampraktek": "'.(@$jam_start.'-'.@$jam_end).'",
				// 		"jeniskunjungan": "1",
				// 		"nomorreferensi": "'.@$noref.'",
				// 		"nomorantrean": "'.@$nomor.'",
				// 		"angkaantrean": "'.(int) @$nomor.'",
				// 		"estimasidilayani": "'.@$estimasi.'",
				// 		"sisakuotajkn":"'.@$kuotaJKN.'",
				// 		"kuotajkn": "'.@$kuotaJKN.'",
				// 		"sisakuotanonjkn": "0",
				// 		"kuotanonjkn": "0",
				// 		"keterangan": "'.@$request['keterangan'].'"
				// 	}';

                //     curl_setopt($sessionan, CURLOPT_HTTPHEADER, signature_bpjs());
                //     curl_setopt($sessionan, CURLOPT_POSTFIELDS, $req2);
                //     curl_setopt($sessionan, CURLOPT_POST, TRUE);
                //     curl_setopt($sessionan, CURLOPT_RETURNTRANSFER, TRUE);
                //     $responseantr= curl_exec($sessionan);
                //     @$jsonrespon = json_decode($responseantr, true);
                // }

				if($jsonrespon['metadata']['code'] == 201 && $jsonrespon['metadata']['message'] !== 'Rujukan untuk tanggal '.date('Y-m-d').' tidak valid / masa berlaku habis' && $jsonrespon['metadata']['code'] !== 208){
				// if($jsonrespon['metadata']['code'] == 201){
					return response()->json(['code'=>$jsonrespon['metadata']['code'],'msg' => $jsonrespon['metadata']['message'],'duplicate'=>false]);
				}
			}
			// dd("OKE");
			// dd($jsonrespon);
			// dd($req);
			// UPDATE TASKID1

			if(status_consid(1)){
				$updatewaktu   = '{
					"kodebooking": "'.@$reg->nomorantrian.'",
					"taskid": 1,
					"waktu": "'.round(microtime(true) * 1000).'"
				}';
				sleep(1);
				$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
				$session = curl_init($completeurl2);
				curl_setopt($session, CURLOPT_HTTPHEADER, signature_bpjs());
				curl_setopt($session, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session, CURLOPT_POST, TRUE);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
				$response = curl_exec($session);
				$sml = json_decode($response, true); 

				// INSERT KE TABLE LOG BPJS
				if(cek_status_reg(@$reg->status_reg) == 'J'){
					$bpjslog = BpjsLog::where('nomorantrian',@$reg->nomorantrian)->first();
					if(isset($jsonrespon) && isset($sml)){
						if(@$jsonrespon['metadata']['code'] !== 208 && @$sml['metadata']['code'] !== 208 && @$sml['metadata']['message'] !== 'TaskId terakhir 5'){
							if(!$bpjslog){
								$bpjslog = new BpjsLog();
							}
							$bpjslog->request = @$req;
							// if(isset($sml)){
							$bpjslog->status = @$jsonrespon['metadata']['code'];
							// }
							$bpjslog->response = @$responseantr;
							$bpjslog->response_taskid = @$response;
							$bpjslog->url = url()->full();
							$bpjslog->user_id = @Auth::user()->id;
							$bpjslog->penginput = @Auth::user()->name;
							$bpjslog->nomorantrian = @$reg->nomorantrian;
							$bpjslog->save();
						}
					}
					
				}
			}

			// INSERT KE TABLE LOG BPJS
			if(cek_status_reg(@$reg->status_reg) == 'J'){
				$bpjslog = BpjsLog::where('nomorantrian',@$reg->nomorantrian)->first();
				if(isset($jsonrespon)){
					if(@$jsonrespon['metadata']['code'] !== 208){
						if(!$bpjslog){
							$bpjslog = new BpjsLog();
						}
						$bpjslog->request = @$req;
						// if(isset($sml)){
						$bpjslog->status = @$jsonrespon['metadata']['code'];
						// }
						$bpjslog->response = @$responseantr;
						// $bpjslog->response_taskid = @$response;
						$bpjslog->url = @$request['url'];
						$bpjslog->user_id = @Auth::user()->id;
						$bpjslog->penginput = @Auth::user()->name;
						$bpjslog->nomorantrian = @$reg->nomorantrian;
						$bpjslog->save();
					}
				}
				
			}
			// dd($sml);
			
			
			if(status_consid(2)){
				//  UPDATE TASKID ID 2
				$updatewaktu2   = '{
					"kodebooking": "'.@$reg->nomorantrian.'",
					"taskid": 2,
					"waktu": "'.randomWaktu2().'"
				}';
				$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
				$session2 = curl_init($completeurl2);
				curl_setopt($session2, CURLOPT_HTTPHEADER, signature_bpjs());
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu2);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session2);

			}
			
			
			if(status_consid(3)){
				//  UPDATE TASKID 3
				$updatewaktu3   = '{
					"kodebooking": "'.@$reg->nomorantrian.'",
					"taskid": 3,
					"waktu": "'.randomWaktu3().'"
				}';
				$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
				$session3 = curl_init($completeurl2);
				curl_setopt($session3, CURLOPT_HTTPHEADER, signature_bpjs());
				curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu3);
				curl_setopt($session3, CURLOPT_POST, TRUE);
				curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session3);

			}
		}
		

		//  dd($)
		// dd($req);
		// dd($nomorantrian);
		// dd($request);
		if($request['laka_lantas'] == 1){
			if ($cek->fails()) {
				return response()->json(['error' => $cek->errors()]);
			}
		}

		// dd($request);

		// $data['reg'] = Registrasi::find($request['registrasi_id']);
		// dd($data['reg']);
		// if(isset($data['reg'])){
		// 	if($data['reg']->nomorantrian){
		// 		$ID = config('app.consid_antrean');
		// 		date_default_timezone_set('Asia/Jakarta');
		// 		$t = time();
		// 		$dat = "$ID&$t";
		// 		$secretKey = config('app.secretkey_antrean');
		// 		$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
		// 		$completeurl = config('app.antrean_url_web_service')."antrean/updatewaktu";
		// 		$arrheader = array(
		// 			'X-cons-id: ' . $ID,
		// 			'X-timestamp: ' . $t,
		// 			'X-signature: ' . $signature,
		// 			'user_key:'. config('app.user_key_antrean'),
		// 			'Content-Type: application/json',
		// 		);
				
		// 		$updatewaktu   = '{
		// 			"kodebooking": "'.@$data['reg']->nomorantrian.'",
		// 			"taskid": "4",
		// 			"waktu": "'.round(microtime(true) * 1000).'"
		// 		}';
		// 		$session2 = curl_init($completeurl);
		// 		curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
		// 		curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
		// 		curl_setopt($session2, CURLOPT_POST, TRUE);
		// 		curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
		// 		curl_exec($session2);
		// 		// sleep(3);
				
				
		// 		$updatewaktu5   = '{
		// 			"kodebooking": "'.@$data['reg']->nomorantrian.'",
		// 			"taskid": "5",
		// 			"waktu": "'.round(microtime(true) * 1000).'"
		// 		}';
		// 		$session5 = curl_init($completeurl);
		// 		curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
		// 		curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
		// 		curl_setopt($session5, CURLOPT_POST, TRUE);
		// 		curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
		// 		curl_exec($session5);
		// 		// sleep(3);
		// 	}
		// }

		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$noKartu = $request['no_bpjs'];
		$notelp = $request["no_tlp"];
		$TglRujuk = $request['tgl_rujukan'];
		$noRujuk = $request['no_rujukan'];
		$asalRujukan = $request["asalRujukan"];
		$ppkRujuk = $request['ppk_rujukan'];
		// $ppkRujuk = '0620R001';
		$ppkLayanan = config('app.sep_ppkLayanan');
		$jnsLayanan = $request["jenis_layanan"];
		// dd($jnsLayanan);
		$catatan = $request["catatan_bpjs"];
		$ArrayregdiagAwal = $request["diagnosa_awal"];

		$regdiagAwal = $request["diagnosa_awal"];
		$ArrayPoliTujuan = explode("-", $request["poli_bpjs"]);
		$poliTujuan = $request['poli_bpjs'];
		$kodeKelas = $request["hak_kelas_inap"];
		$kodeKelasNaik = $request["hak_kelas_inap_naik"];
		$pembiayaan = $request["pembiayaan"];
		$penanggungJawab = penanggungJawabSep($pembiayaan);
		$tujuanKunj = $request["tujuanKunj"];
		$flagProcedure = $request["flagProcedure"];
		$kdPenunjang = $request["kdPenunjang"];
		$assesmentPel = $request["assesmentPel"];
		// $dpjpLayanan = $request["dpjpLayanan"];
		
		$lakaLantas = $request["laka_lantas"];
		$cob = $request["cob"];
		$katarak = $request["katarak"];

		$penjamin = $request["penjamin"];
		$tglKejadian = $request["tglKejadian"];
		$kll = $request["kll"];
		$suplesi = $request["suplesi"];
		$noSepSuplesi = $request["noSepSuplesi"];
		$kdPropinsi = $request['kdPropinsi'];
		$kdKabupaten = $request['kdKabupaten'];
		$kdKecamatan = $request['kdKecamatan'];
		$noSurat = $request['noSurat'];
		$kodeDPJP = $request['kodeDPJP'];
		$dpjpLayan = $request['dpjpLayan'];
		// $noSurat          = '987656';
		// $kodeDPJP         = '37527';
		$noMR = $request["no_rm"];
		$tglSep = $request["tglSep"];
		@$no_lp = @$request["no_lp"];
		// dd($request);
		$request = '{
                 "request": {
                    "t_sep": {
                       "noKartu": "' . $noKartu . '",
                       "tglSep": "' . $tglSep . '",
                       "ppkPelayanan": "' . config('app.sep_ppkLayanan') . '",
                       "jnsPelayanan": "' . $jnsLayanan . '",
                       "klsRawat": {
						   "klsRawatHak":"'.$kodeKelas.'",
						   "klsRawatNaik":"'.$kodeKelasNaik.'",
						   "pembiayaan":"'.$pembiayaan.'",
						   "penanggungJawab":"'.$penanggungJawab.'"
					   },
                       "noMR": "' . $noMR . '",
                       "rujukan": {
                          "asalRujukan": "' . $asalRujukan . '",
                          "tglRujukan": "' . $TglRujuk . '",
                          "noRujukan":"' . $noRujuk . '",
                          "ppkRujukan": "' . $ppkRujuk . '"
                       },
                       "catatan": "' . $catatan . '",
                       "diagAwal": "' . $regdiagAwal . '",
                       "poli": {
                          "tujuan": "' . $poliTujuan . '",
                          "eksekutif": "0"
                       },
                       "cob": {
                          "cob": "' . $cob . '"
                       },
                       "katarak": {
                          "katarak": "' . $katarak . '"
                       },
                       "jaminan": {
                          "lakaLantas": "' . $lakaLantas . '",
                          "noLP": "' . $no_lp . '",
                          "penjamin": {
                              "penjamin": "' . $penjamin . '",
                              "tglKejadian": "' . $tglKejadian . '",
                              "keterangan": "' . $kll . '",
                              "suplesi": {
                                  "suplesi": "' . $suplesi . '",
                                  "noSepSuplesi": "' . $noSepSuplesi . '",
                                  "lokasiLaka": {
                                      "kdPropinsi": "' . $kdPropinsi . '",
                                      "kdKabupaten": "' . $kdKabupaten . '",
                                      "kdKecamatan": "' . $kdKecamatan . '"
                                      }
                              }
                          }
                       },
					   "tujuanKunj": "' . $tujuanKunj . '",
					   "flagProcedure": "' . $flagProcedure . '",
					   "kdPenunjang": "' . $kdPenunjang . '",
					   "assesmentPel": "'.$assesmentPel.'",
                       "skdp": {
                          "noSurat": "' . $noSurat . '",
                          "kodeDPJP": "' . $kodeDPJP . '"
                       },
					   "dpjpLayan": "'.$dpjpLayan.'",
                       "noTelp": "' . $notelp . '",
                       "user": "VCLAIM"
                    }
                 }
              }'; 

		//echo $request;die;
		// return response()->json(json_decode($request));
		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/insert"; //Insert

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		
		$sml = json_decode($response, true); 
		 
		if ($sml['metaData']['message'] == 'Sukses') {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);
			//$sep = 'No. SEP adalah: '.$sml['response'];
			// dd($sep);
			return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
		} else {
			//$sep = $sml['metadata']['message'];
			return response()->json(['msg' => $sml['metaData']['message']]);
		}

	}
	// SUDAH V2
	public function buat_antrian(Request $req) {
		$re = \LZCompressor\LZString::decompressFromBase64($req->data);
		$request = array();
		parse_str($re, $request);
		
		
		$cek = Validator::make($request, [
			
		], [
			 
		]); 
		// dd($request);
		$noantri = Registrasi::where('nomorantrian','like',date('dmY') . '%')->count();
		$nomorantrian = date('dmY').sprintf("%04s",$noantri+1);
		// dd($nomorantrian);
		$registrasi_id = $request['registrasi_id'];
		$reg = Registrasi::find($registrasi_id);
		// dd(baca_bpjs_poli($reg->poli_id));
		
		// $reg->nomorantrian = $nomorantrian;
		// $reg->update();
		$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
			
			$kuotaJKN = Poli::where('bpjs',baca_bpjs_poli($reg->poli_id))->first()->kuota; 
			$nomor = substr($nomorantrian,-4); 
			 
			$pasienbaru = $request['no_rm'] ? 0 : 1;

			// $tgl = $request['tglrujukan'] ? $request['tglrujukan'] : date('Y-m-d');
			$bayar = $reg->bayar == '1' ? 'JKN' : 'NON JKN';
			$estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
			@$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
			@$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
			
			if(empty($reg->nomorantrian)){
				$reg->nomorantrian = $nomorantrian;
				$reg->save();
			}else{
				$reg->nomorantrian;
			}

			$req   = '{
				"kodebooking": "'.$reg->nomorantrian.'",
				"jenispasien": "'.$bayar.'",
				"nomorkartu": "'.$request['no_bpjs'].'",
				"nik": "'.@$request['nik'].'",
				"nohp": "'.@$request['no_tlp'].'",
				"kodepoli": "'.@$request['poli_bpjs'].'",
				"namapoli": "'.baca_kode_poli(@$request['poli_bpjs']).'", 
				"pasienbaru": "'.$pasienbaru.'",
				"norm": "'.@$request['no_rm'].'",
				"tanggalperiksa": "'.$request['tglSep'].'", 
				"kodedokter": "'.$request['kodeDPJP'].'", 
				"namadokter": "'.baca_dokter_bpjs($request['kodeDPJP']).'",
				"jampraktek": "'.($jam_start.'-'.$jam_end).'",
				"jeniskunjungan": "'.$request['jenisKunjungan'].'",
				"nomorreferensi": "'.@$request['no_rujukan'].'",
				"nomorantrean": "'.$nomor.'",
				"angkaantrean": "'.(int) $nomor.'",
				"estimasidilayani": "'.$estimasi.'",
				"sisakuotajkn":"'.$kuotaJKN.'",
				"kuotajkn": "'.$kuotaJKN.'",
				"sisakuotanonjkn": "0",
				"kuotanonjkn": "0",
				"keterangan": "'.@$request['keterangan'].'"
			}';
			// dd([$request]);
			
			// dd($req);
			$completeurl = config('app.antrean_url_web_service')."antrean/add";
			$session = curl_init($completeurl);
			// dd($completeurl);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.user_key_antrean'),
				'Content-Type: application/json',
			);
			
			// dd(json_decode($body_prb));
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_POSTFIELDS, $req);
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			$sml = json_decode($response, true);
			if($sml !== null){
				if($sml['metadata']['code'] == '200' || $sml['metadata']['code'] == '208'){

					// Update waktu 1
					$updatewaktu   = '{
						"kodebooking": "'.$reg->nomorantrian.'",
						"taskid": 1,
						"waktu": "'.round(microtime(true) * 1000).'"
					 }';
					 $completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
					 $session2 = curl_init($completeurl2);
					 curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
					 curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
					 curl_setopt($session2, CURLOPT_POST, TRUE);
					 curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
					 $response2 = curl_exec($session2);
					 $sml2 = json_decode($response2, true); 
					//  dd($sml2);
					//  dd($sml);
					//  sleep(2);
	
					//  dd($sml2);
					//  Update waktu 2
					//  if($sml2['metadata']['code'] == '200' || $sml2['metadata']['message'] == 'TaskId=1 sudah ada'){
					// 	$updatewaktu2   = '{
					// 		"kodebooking": "'.$reg->nomorantrian.'",
					// 		"taskid": 2,
					// 		"waktu": "'.round(microtime(true) * 1000).'"
					// 	 }';
					// 	 $completeurl3 = config('app.antrean_url_web_service')."antrean/updatewaktu";
					// 	 $session3 = curl_init($completeurl3);
					// 	 curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
					// 	 curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
					// 	 curl_setopt($session3, CURLOPT_POST, TRUE);
					// 	 curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
					// 	 $response3 = curl_exec($session3);
					// 	 $sml3 = json_decode($response3, true); 
	
						 
					//  } 
					// dd(['response'=>$sml,'task_id'=>$sml2]);
					//  dd(['insert' => $sml, 'task_id1' => $sml2]);
					return response()->json(['code'=>$sml['metadata']['code'],'msg' => $reg->nomorantrian,'duplicate'=>false]);
					 
				}else{
					return response()->json(['code'=>$sml['metadata']['code'],'msg' => $sml['metadata']['message'],'duplicate'=>true]);
				}
			}else{
				return response()->json(['code'=>'200','msg' => $reg->nomorantrian,'duplicate'=>false]);
			}
			
			
				  
	}
	


	function updateTglPulang($noSep, $tglPulang) {
		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		$request = '{
                      "request":
                      {"t_sep":
                          {
                              "noSep":"' . $noSep . '",
                              "tglPulang":"' . $tglPulang . '",
                              "user":"' . Auth::user()->name . '"
                          }
                      }
                }';
		// return $request; die;
		$uri = config('app.sep_url_web_service');
		$completeurl = "$uri/Sep/updtglplg";

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		return $json;
	}

	public function simpan_sep(Request $request) {
	
		// dd($request->all());

		DB::beginTransaction();
        try{
			$registrasi_id = !empty($request['registrasi_id']) ? $request['registrasi_id'] : session('reg_id');
			$reg = Registrasi::find($registrasi_id);

			if (substr($reg->status_reg, 0, 1) != 'G') {
				// TASK ID 2
				if(!empty($reg->nomorantrian && $reg->bayar == '1')){
					$ID = config('app.consid_antrean');
					date_default_timezone_set('Asia/Jakarta');
					$t = time();
					$data = "$ID&$t";
					$secretKey = config('app.secretkey_antrean');
					$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
					$arrheader = array(
						'X-cons-id: ' . $ID,
						'X-timestamp: ' . $t,
						'X-signature: ' . $signature,
						'user_key:'. config('app.user_key_antrean'),
						'Content-Type: application/json',
					);
					$updatewaktu2   = '{
						"kodebooking": "'.$reg->nomorantrian.'",
						"taskid": 2,
						"waktu": "'.round(microtime(true) * 1000).'"
						}';
						$completeurl3 = config('app.antrean_url_web_service')."antrean/updatewaktu";
						$session3 = curl_init($completeurl3);
						curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
						curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
						curl_setopt($session3, CURLOPT_POST, TRUE);
						curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
						$response3 = curl_exec($session3);
						$sml3 = json_decode($response3, true); 
				}

			}

            

			$reg->no_sep = @$request['no_sep'];
			$reg->tgl_rujukan = $request['tgl_rujukan'];
			$reg->no_rujukan = $request['no_rujukan'];
			$reg->ppk_rujukan = $request['ppk_rujukan'] . '|' . $request['nama_perujuk'];
			$reg->diagnosa_awal = $request['diagnosa_awal'];
			$reg->tgl_sep = $request['tglSep'];
			if(isset($request['kodeDPJP'])){
				if($request['kodeDPJP'] !== null){
					@$dpjp = Pegawai::where('kode_bpjs',$request['kodeDPJP'])->first();
					if(@$dpjp){
						@$reg->dokter_id = @$dpjp->id;
						@$updatehistori = HistorikunjunganIRJ::where('registrasi_id',@$reg->id)->orderBy('id','DESC')->first();
						if(@$updatehistori){
							@$updatehistori->dokter_id = @$dpjp->id;
							@$updatehistori->save();
						}
					}
				}
	
			}
			$reg->poli_bpjs = $request['poli_bpjs'];
			$reg->hakkelas = @$request['hak_kelas_inap'];
			$reg->nomorrujukan = $request['no_rujukan'];
			$reg->catatan = $request['catatan_bpjs'];
			$reg->kecelakaan = $request['laka_lantas'];
			$reg->no_jkn = $request['no_bpjs'];
			$reg->jenis_kunjungan = $request['jenisKunjungan'];
			$reg->update();

			$pasien = \Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
			if($request['nik']){
				$pasien->nik = $request['nik'];
			}
			$pasien->nohp = $request['no_tlp'];
			$pasien->no_jkn = $request['no_bpjs'];
			$pasien->update();
			//GET PATIENT BY NIK
			


			
			
			$historisep = new HistoriSep();
			$historisep->nik = (!empty($request['nik'])) ? $request['nik'] : NULL;
			$historisep->registrasi_id = (!empty($request['registrasi_id'])) ? $request['registrasi_id'] : NULL;
			$historisep->namapasien = (!empty($request['namapasien'])) ? $request['namapasien'] : NULL;
			$historisep->nama_kartu = (!empty($request['nama'])) ? $request['nama'] : NULL;
			$historisep->nama_ppk_perujuk = (!empty($request['nama_ppk_perujuk'])) ? $request['nama_ppk_perujuk'] : NULL;
			$historisep->kode_ppk_perujuk = (!empty($request['kode_ppk_perujuk'])) ? $request['kode_ppk_perujuk'] : NULL;
			$historisep->no_rm = (!empty($request['no_rm'])) ? $request['no_rm'] : NULL;
			$historisep->no_bpjs = (!empty($request['no_bpjs'])) ? $request['no_bpjs'] : NULL;
			$historisep->no_tlp = (!empty($request['no_tlp'])) ? $request['no_tlp'] : NULL;
			$historisep->tgl_rujukan = (!empty($request['tgl_rujukan'])) ? $request['tgl_rujukan'] : NULL;
			$historisep->no_rujukan = (!empty($request['no_rujukan'])) ? $request['no_rujukan'] : NULL;
			$historisep->ppk_rujukan = (!empty($request['ppk_rujukan'])) ? $request['ppk_rujukan'] : NULL;
			$historisep->nama_perujuk = (!empty($request['nama_perujuk'])) ? $request['nama_perujuk'] : NULL;
			$historisep->diagnosa_awal = (!empty($request['diagnosa_awal'])) ? $request['diagnosa_awal'] : NULL;
			$historisep->jenis_layanan = (!empty($request['jenis_layanan'])) ? $request['jenis_layanan'] : NULL;
			$historisep->asalRujukan = (!empty($request['asalRujukan'])) ? $request['asalRujukan'] : NULL;
			$historisep->hak_kelas_inap = (!empty($request['hak_kelas_inap'])) ? $request['hak_kelas_inap'] : NULL;
			$historisep->katarak = (!empty($request['katarak'])) ? $request['katarak'] : NULL;
			$historisep->tglSep = (!empty($request['tglSep'])) ? $request['tglSep'] : NULL;
			$historisep->tipe_jkn = (!empty($request['tipe_jkn'])) ? $request['tipe_jkn'] : NULL;
			$historisep->poli_bpjs = (!empty($request['poli_bpjs'])) ? $request['poli_bpjs'] : NULL;
			$historisep->noSurat = (!empty($request['noSurat'])) ? $request['noSurat'] : NULL;
			$historisep->kodeDPJP = (!empty($request['kodeDPJP'])) ? $request['kodeDPJP'] : NULL;
			$historisep->laka_lantas = (!empty($request['laka_lantas'])) ? $request['laka_lantas'] : NULL;
			$historisep->penjamin = (!empty($request['penjamin'])) ? $request['penjamin'] : NULL;
			$historisep->no_lp = (!empty($request['no_lp'])) ? $request['no_lp'] : NULL;
			$historisep->tglKejadian = (!empty($request['tglKejadian'])) ? $request['tglKejadian'] : NULL;
			$historisep->kll = (!empty($request['kll'])) ? $request['kll'] : NULL;
			$historisep->suplesi = (!empty($request['suplesi'])) ? $request['suplesi'] : NULL;
			$historisep->noSepSuplesi = (!empty($request['noSepSuplesi'])) ? $request['noSepSuplesi'] : NULL;
			$historisep->kdPropinsi = (!empty($request['kdPropinsi'])) ? $request['kdPropinsi'] : NULL;
			$historisep->kdKabupaten = (!empty($request['kdKabupaten'])) ? $request['kdKabupaten'] : NULL;
			$historisep->kdKecamatan = (!empty($request['kdKecamatan'])) ? $request['kdKecamatan'] : NULL;
			$historisep->no_sep = (!empty($request['no_sep'])) ? $request['no_sep'] : NULL;
			$historisep->carabayar_id = (!empty($request['carabayar_id'])) ? $request['carabayar_id'] : NULL;
			$historisep->catatan_bpjs = (!empty($request['catatan_bpjs'])) ? $request['catatan_bpjs'] : NULL;
			$historisep->cob = (!empty($request['cob'])) ? $request['cob'] : NULL;
			$historisep->dokter_id = (!empty($request['dokter_id'])) ? $request['dokter_id'] : NULL; 
			$historisep->save();

			DB::commit();
			
			if (Satusehat::find(1)->aktif == 1) {
				if(satusehat() && $pasien) {
					if(!$pasien->id_patient_ss){
						$request['nik'] = $request['nik'] ? $request['nik'] :@$request['niks'];
						@$id_ss = SatuSehatController::PatientGet(@$reg->pasien->nik);
						if(empty(@$id_ss)){
							@$id_ss = SatuSehatController::PatientGet(@$request['nik'] ? @$request['nik']:@$reg->pasien->nik);
						}
						if(@$id_ss){
							$pasien->id_patient_ss = @$id_ss;
							if(!$pasien->nik){
								$pasien->nik = @$request['nik'] ? @$request['nik'] :@$reg->pasien->nik;

							}
							$pasien->save();
	
						}

					}
				}
			}
			// Jika pasien melakukan registrasi normal seharusnya sudah terdaftar di satusehat
            if($reg->id_encounter_ss == null){
                if (Satusehat::find(1)->aktif == 1) {
                    $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'form_sep');
                    $reg->save();
                }
            }
			session()->forget('reg_id');
			if (!empty($request['no_sep'])) {
				session(['no_sep' => $request['no_sep']]);
				Flashy::success('Integrasi SEP sukses, No SEP berhasil simpan');
			}

			if (substr($reg->status_reg, 0, 1) == 'G') {
				if (session('status') == 'ubahdpjp') {
					return redirect('/frontoffice/supervisor/ubahdpjp');
				} else {
					return redirect('/frontoffice/rawat-darurat');
				}

			} else {
				if(session('bagian_loket')){
					return redirect('antrian-news/'.bagian_lokets(session('bagian_loket')).'/'. session('no_loket') . '/daftarantrian');
				}else{
					if (session('no_loket') == '1') {
						return redirect('antrian/daftarantrian');
					} else {
						return redirect('antrian' . session('no_loket') . '/daftarantrian');
					}

				}
			} 
		}catch(Exception $e){
			DB::rollback();
			session()->forget('reg_id');
			Flashy::info('Gagal Simpan Data');
			return redirect()->back();
		} 
		

	}

	public function sep_sukses() {
		return view('sep.sukses');
	}

	public function cetak_sep($no_sep = '') {

		if (!empty($no_sep)) {
			$data['reg'] = Registrasi::where('no_sep', $no_sep)->first();
			// dd($data['reg']);
			if(!empty($data['reg']->ppk_rujukan)){
				$perujuk = explode('|', $data['reg']->ppk_rujukan);
				if (isset($perujuk[1])) {
					$data['perujuk'] = $perujuk[1];
				} else {
					$data['perujuk'] = NULL;
				}
			}else{
				$data['perujuk'] = '-';
			}
			
			session()->forget('no_sep');

		} else {
			$data['error'] = 'No. SEP Tidak ada';
		}

		
		$ID = config('app.sep_id');
		$t = time();
		$datasep = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($datasep), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service')."/SEP/" . $no_sep;
		

		$session = curl_init($completeurl);
		$arrheader = array(
		'X-cons-id: ' . $ID,
		'X-timestamp: ' . $t,
		'X-signature: ' . $signature,
		'user_key:'. config('app.user_key'),
		'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		$sml = json_decode($response, true);
		if($response == null || $sml == null){
			Flashy::info('Jaringan bermasalah, tidak dapat terhubung ke VCLAIM BPJS');
			return redirect()->back();
		}

		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
		$data['sep'] = json_decode($this->decompress($stringEncrypt),true);

		// dd($data['sep']);

		// CEK FINGER
		$data['kode_finger'] = '1';
		$data['status_finger'] = 'OK';
		$cek_finger = [];
		@$nomorkartu = @$data['reg']->pasien->no_jkn;
		@$tglperiksa = @date('Y-m-d',strtotime($data['reg']->created_at));
		// @$tglperiksa = '2024-01-02';
		// dd(@$nomorkartu,$tglperiksa);
		if(@$nomorkartu && @$tglperiksa){
			$cek_finger = $this->cekFinger(@$nomorkartu,@$tglperiksa);
			$data['kode_finger'] = @$cek_finger[1]['kode'];
			$data['status_finger'] = @$cek_finger[1]['status'];
		}
		// dd($cek_finger);
		

		$pdf = PDF::loadView('sep.cetak_sep', $data);
		// $customPaper = array(0, 0, 793.7007874, 340);
		$customPaper = array(0, 0, 793.7007874, 360);
		$pdf->setPaper($customPaper);
		// return $pdf->download('lab.pdf');
		return $pdf->stream();
	}
	public function cetak_sep_new($no_sep = '') {

		if (!empty($no_sep)) {
			$data['reg'] = Registrasi::where('no_sep', $no_sep)->first();
			// dd($data['reg']);
			// dd($data['reg']->ppk_rujukan);
			if(!empty($data['reg']->ppk_rujukan)){
				$perujuk = explode('|', $data['reg']->ppk_rujukan);
				if (isset($perujuk[1])) {
					$data['perujuk'] = $perujuk[1];
				} else {
					$data['perujuk'] = NULL;
				}
			}else{
				$data['perujuk'] = '-';
			}
			
			session()->forget('no_sep');

		} else {
			$data['error'] = 'No. SEP Tidak ada';
		}

		
		$ID = config('app.sep_id');
		$t = time();
		$datasep = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($datasep), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service')."/SEP/" . $no_sep;
		

		$session = curl_init($completeurl);
		$arrheader = array(
		'X-cons-id: ' . $ID,
		'X-timestamp: ' . $t,
		'X-signature: ' . $signature,
		'user_key:'. config('app.user_key'),
		'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		$sml = json_decode($response, true);
		if($response == null || $sml == null){
			Flashy::info('Jaringan bermasalah, tidak dapat terhubung ke VCLAIM BPJS');
			return redirect()->back();
		}

		$data['rujukan'] = '';
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
		$data['sep'] = json_decode($this->decompress($stringEncrypt),true);
		if($data['sep']){
			$data['rujukan'] = $this->cekRujukan($data['sep']['noRujukan']);
		}
		// dd($data['rujukan']);
		// $this->cekRujukan($data['data']->no_rujukan);
		// dd($data['sep']);

		// CEK FINGER
		$data['kode_finger'] = '1';
		$data['status_finger'] = 'OK';
		$cek_finger = [];
		@$nomorkartu = @$data['reg']->pasien->no_jkn;
		@$tglperiksa = @date('Y-m-d',strtotime($data['reg']->created_at));
		// @$tglperiksa = '2024-01-02';
		// dd(@$nomorkartu,$tglperiksa);
		if(@$nomorkartu && @$tglperiksa){
			$cek_finger = $this->cekFinger(@$nomorkartu,@$tglperiksa);
			$data['kode_finger'] = @$cek_finger[1]['kode'];
			$data['status_finger'] = @$cek_finger[1]['status'];
		}
		// dd($cek_finger);
		

		$pdf = PDF::loadView('sep.cetak_sep_new', $data);
		// $customPaper = array(0, 0, 793.7007874, 340);
		$customPaper = array(0, 0, 793.7007874, 420);
		$pdf->setPaper($customPaper);
		// return $pdf->download('lab.pdf');
		return $pdf->stream();
	}
	function cekFinger($nomor,$tglperiksa){
		list($ID, $t, $signature) = $this->HashBPJS();
			
		@$completeurl = config('app.sep_url_web_service') . "/SEP/FingerPrint/Peserta/". $nomor."/TglPelayanan/".$tglperiksa;
		@$response = $this->xrequest($completeurl, $signature, $ID, $t); 
		if(@$response =='Authentication failed'){
			@$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		@$array[] = json_decode(@$response, true);
		@$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		@$array[] = json_decode($this->decompress(@$stringEncrypt),true);
		// dd($array);
		@$sml = json_encode($array,JSON_PRETTY_PRINT); 
		@$json = json_decode($sml,true);
		return @$json;
	}
	
	public function cetak_sep_rad($no_sep = '') {

		if (!empty($no_sep)) {
			$data['reg'] = Registrasi::where('no_sep', $no_sep)->first();
			// dd($data['reg']);
			if(!empty($data['reg']->ppk_rujukan)){
				$perujuk = explode('|', $data['reg']->ppk_rujukan);
				if (isset($perujuk[1])) {
					$data['perujuk'] = $perujuk[1];
				} else {
					$data['perujuk'] = NULL;
				}
			}else{
				$data['perujuk'] = '-';
			}
			
			session()->forget('no_sep');

		} else {
			$data['error'] = 'No. SEP Tidak ada';
		}

		
		$ID = config('app.sep_id');
		$t = time();
		$datasep = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($datasep), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service')."/SEP/" . $no_sep;
		

		$session = curl_init($completeurl);
		$arrheader = array(
		'X-cons-id: ' . $ID,
		'X-timestamp: ' . $t,
		'X-signature: ' . $signature,
		'user_key:'. config('app.user_key'),
		'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		$sml = json_decode($response, true);

		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
		$data['sep'] = json_decode($this->decompress($stringEncrypt),true);

		// dd($data['sep']);

		

		$pdf = PDF::loadView('sep.cetak_sep_rad', $data);
		// $customPaper = array(0, 0, 793.7007874, 340);
		$customPaper = array(0, 0, 793.7007874, 360);
		$pdf->setPaper($customPaper);
		// return $pdf->download('lab.pdf');
		return $pdf->stream();
	}

	public function respon_cetak_sep($no_sep = '')
	{
		// if (!empty($no_sep)) {
			// $data['reg'] = Registrasi::where('no_sep', $no_sep)->first();
			$data['reg'] = $no_sep;
		// 	$perujuk = explode('|', $data['reg']->ppk_rujukan);
		// 	if (isset($perujuk[1])) {
		// 		$data['perujuk'] = $perujuk[1];
		// 	} else {
		// 		$data['perujuk'] = NULL;
		// 	}
		// 	session()->forget('no_sep');
		// } else {
		// 	$data['error'] = 'No. SEP Tidak ada';
		// }
		return view('sep.respon_cetak_sep',$data);
	}

	public function getIcd10() {
		$data = Icd10::all();
		return DataTables::of($data)
			->addColumn('add', function ($data) {
				return ' <a href="#" data-nomor="' . $data->nomor . '" class="btn btn-sm btn-success btn-flat addICD"><i class="fa fa-check"></i></a> ';
			})
			->rawColumns(['add'])
			->make(true);
	}


	public function getIcd9() {
		$data = Icd9::all();
		return DataTables::of($data)
			->addColumn('add', function ($data) {
				return ' <a href="#" data-nomor="' . @$data->nomor . '" class="btn btn-sm btn-success btn-flat addICD"><i class="fa fa-check"></i></a> ';
			})
			->rawColumns(['add'])
			->make(true);
	}


	public function cetakSepSY($id)
	{
		// $cek = Validator::make($request->all(), [
		// 	'noSEP' => 'required',
		// ]);
		// if (!$cek->passes()) {
		// 	return response()->json(['metaData' => ['code' => 201, 'error' => $cek->errors()]]);
		// }

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/SEP/" . $id;

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		return response()->json($sml);
	}


	public function create() {
		$data['poli'] = Poli::select('nama', 'bpjs')->get();
		return view('sep.form_antrian',$data);
		
	}
	
	public function returnRedirectRegister() {
		return redirect('/');
	}
	

	function cekRujukan($nomor){
		list($ID, $t, $signature) = $this->HashBPJS();
		// dd($nomor);
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/". $nomor;
		$response = $this->xrequest($completeurl, $signature, $ID, $t); 
		// dd($response);
		if(!$response){
			return $response;
		}
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);

		$sml = json_encode($array,JSON_PRETTY_PRINT); 
		$json = json_decode($sml,true);
		return $json;
	}

}
