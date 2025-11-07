<?php

namespace App\Http\Controllers;

use App\Hasillab;
use App\HistoriSep;
use App\Http\Controllers\HRD\MasterController;
use App\LogBridging;
use App\Logistik\LogistikStock;
use App\LogistikBatch;
use App\Masterobat;
use App\Nomorrm;
use App\Produk;
use App\RencanaKontrol;
use App\Satuanbeli;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Pegawai\Entities\Pegawai;
use PDF;
use Validator;
use Modules\Registrasi\Entities\Registrasi;
use Monolog\Handler\IFTTTHandler;
use Modules\Poli\Entities\Poli;
use MercurySeries\Flashy\Flashy;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Folio;
use Yajra\DataTables\DataTables;
use Excel;
use Modules\Tarif\Entities\Tarif;

class BridgingSEPController extends Controller {
	public function login2(){
		$d = [];
		sleep(60);
		// $fol = Folio::all();
		// while (1){ //infinite loop
		// 	foreach($fol as $f){
		// 		$d[] = $f->id;
		// 	}
		// 	}
		
		// return;
		return view('bridgingsep.log');
	}
	public function updatenik(){
		$pasien = Pasien::all();
		$total_digit_nik_asli = 16;
		DB::beginTransaction();
		foreach($pasien as $pas){
			$total_digit_nik_sekarang = strlen($pas->nik);


			if($pas->nik !== '-'){
				if($total_digit_nik_sekarang <= 16){
					$total = $total_digit_nik_asli - $total_digit_nik_sekarang;
					if($total){
						@$nik_sekarang = number_format(@$pas->nik, @$total, '', '');
			
						$pp = Pasien::find($pas->id);
						$pp->nik = $nik_sekarang;	
						$pp->save();

					}
	
				}
			}
		}
		DB::commit();
		//dd('OKE');
	}
	public function sinkronBatch($gudang){
		DB::beginTransaction();
		$log_batch = LogistikBatch::where('masterobat_id','>=',5000)->where('gudang_id',$gudang)->get();
		foreach($log_batch as $l){
			$mas = Masterobat::where('nama',$l->nama_obat)->first();
			if(!$mas){
				$mas = new Masterobat();
			}
				// $a = LogistikBatch::where('id',$l->id)->first();
				
				$mas->nama = $l->nama_obat;
				$mas->kode = $l->kode;
				$mas->kode = $l->masterobat_id;
				$mas->kode = $l->masterobat_id;
				$mas->satuanjual_id = $l->satuanjual_id;
				$mas->satuanbeli_id = $l->satuanbeli_id;
				$mas->kategoriobat_id = '2';
				$mas->hargajual = $l->hargabeli;
				$mas->hargajual_jkn = $l->hargabeli;
				$mas->hargabeli = $l->hargabeli;
				$mas->aktif = 'Y';
				$mas->save();

				
				$la = LogistikBatch::where('nama_obat',$mas->nama)->where('gudang_id',$gudang)->first();
				if($la){
					$la->masterobat_id = $mas->id;
					$la->save();
				}
			}
			DB::commit();
		// dd($log_batch);
		// dd("oke");

	}
	public function updateobat(){
		
		// $log_batch = LogistikBatch::all();
		$obat = Produk::all();
		DB::beginTransaction();
		
		foreach($obat as $o){
			$master = MasterObat::where('nama',$o->nama_produk)->first();
			if($master){
				$master->jenis_obat = $o->jenis_produk;
				$master->save();
				
			}
			// if(!$master){
				// $master = new Masterobat();
				// $master->nama = $o->nama_produk;
				// $master->satuanjual_id = @Satuanbeli::where('nama', $o->satuan_produk)->first()->id;
				// $master->satuanbeli_id = @Satuanbeli::where('nama', $o->satuan_produk)->first()->id;
				// $master->kategoriobat_id = '2';
				// $master->hargajual = '0';
				// $master->hargajual_jkn = '0';
				// $master->hargajual_kesda = '0';
				// $master->hargabeli = '0';
				// $master->aktif = 'Y';

				// $log_batch = LogistikBatch::where('nama_obat',$master->nama)->get();
				// foreach($log_batch as $l){
				// 	// $log_batch){
				// 	$l->masterobat_id = $master->id;
				// 	$l->save();
					

				// }
			// }
		}
		DB::commit();
		
		// foreach($log_batch as $log){
		// 	// logistik rajal
		// 	$log_b = new LogistikBatch();
		// 	$log_b->import = 'import_f'; 
		// 	$log_b->masterobat_id = $log->masterobat_id; 
		// 	$log_b->bapb_id = $log->bapb_id; 
		// 	$log_b->nama_obat = $log->nama_obat; 
		// 	$log_b->stok = $log->stok; 
		// 	$log_b->jumlah_item_diterima = $log->jumlah_item_diterima; 
		// 	$log_b->satuanbeli_id = $log->satuanbeli_id; 
		// 	$log_b->satuanjual_id = $log->satuanjual_id; 
		// 	$log_b->gudang_id = '2';
		// 	$log_b->supplier_id = $log->supplier_id; 
		// 	$log_b->user_id = $log->user_id; 
		// 	$log_b->nomorbatch = $log->nomorbatch; 
		// 	$log_b->expireddate = $log->expireddate; 
		// 	$log_b->hargabeli = $log->hargabeli; 
		// 	$log_b->hargajual_jkn = $log->hargajual_jkn; 
		// 	$log_b->hargajual_umum = $log->hargajual_umum; 
		// 	$log_b->hargajual_dinas = $log->hargajual_dinas; 
		// 	$log_b->created_at = $log->created_at; 
		// 	$log_b->updated_at = $log->updated_at; 
		// 	$log_b->save();

		// 	// logistik igd
		// 	$log_b = new LogistikBatch();
		// 	$log_b->import = 'import_f'; 
		// 	$log_b->masterobat_id = $log->masterobat_id; 
		// 	$log_b->bapb_id = $log->bapb_id; 
		// 	$log_b->nama_obat = $log->nama_obat; 
		// 	$log_b->stok = $log->stok; 
		// 	$log_b->jumlah_item_diterima = $log->jumlah_item_diterima; 
		// 	$log_b->satuanbeli_id = $log->satuanbeli_id; 
		// 	$log_b->satuanjual_id = $log->satuanjual_id; 
		// 	$log_b->gudang_id = '21';
		// 	$log_b->supplier_id = $log->supplier_id; 
		// 	$log_b->user_id = $log->user_id; 
		// 	$log_b->nomorbatch = $log->nomorbatch; 
		// 	$log_b->expireddate = $log->expireddate; 
		// 	$log_b->hargabeli = $log->hargabeli; 
		// 	$log_b->hargajual_jkn = $log->hargajual_jkn; 
		// 	$log_b->hargajual_umum = $log->hargajual_umum; 
		// 	$log_b->hargajual_dinas = $log->hargajual_dinas; 
		// 	$log_b->created_at = $log->created_at; 
		// 	$log_b->updated_at = $log->updated_at; 
		// 	$log_b->save();
		// }
		
		dd('OKE');
	}

	public function updatebatch(){
		
		$log_batch = LogistikBatch::all();
		DB::beginTransaction();
		foreach($log_batch as $log){
			// $log = LogistikBatch::where('id',$log->id)->where('nomorbatch',NULL)->first();
			// if($log){
			// 	$nobatch = substr(strtoupper(str_replace(' ','',$log->nama_obat)),0,5).$log->id;
			// 	// dd($nobatch);
			// 	$log->nomorbatch = $nobatch;
			// 	$log->save();
			// }
			$logStok = new LogistikStock();
			// gudang pusat
			$logStok->gudang_id = $log->gudang_id;
			$logStok->periode_id = 0;
			$logStok->supplier_id = $log->supplier_id;
			$logStok->masuk = 0;
			$logStok->keluar = 0;
			$logStok->total = $log->stok;
			$logStok->expired_date = $log->expireddate;
			$logStok->batch_no = $log->nomorbatch;
			$logStok->logistik_batch_id = $log->id;
			$logStok->masterobat_id = $log->masterobat_id;
			$logStok->keterangan = 'Stok Gudang Pusat '.date('d-m-Y').','.$log->nomorbatch;
			$logStok->user_id = Auth::user()->id;
			$logStok->save();

			// gudang depo rajal
			// $logStok2 = new LogistikStock();
			// $logStok2->periode_id = 0;
			// $logStok2->masterobat_id = $log->masterobat_id;
			// $logStok2->masuk = 0;
			// $logStok2->keluar = 0;
			// $logStok2->total = $log->stok;
			// $logStok2->expired_date = $log->expireddate;
			// $logStok2->batch_no = $log->nomorbatch;
			// $logStok2->logistik_batch_id = $log->id;
			// $logStok2->masterobat_id = $log->masterobat_id;
			// $logStok2->keterangan = 'Stok Depo Rajal '.date('d-m-Y').','.$log->nomorbatch;
			// $logStok2->user_id = Auth::user()->id;
			// $logStok2->save();

			 
		}
		  
		DB::commit();
		
		 
		
		dd('OKE BATCH');
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

	public function index() {
		// Nomorrm::create(['pasien_id' => '00', 'no_rm' => '9999']);
		// $rm = dd($rm);
		return view('bridgingsep.index');
	}
	// V2
	public function pengajuanSEP(Request $req) {
		$re = \LZCompressor\LZString::decompressFromBase64($req->data);
		$request = array();
		parse_str($re, $request);
		$cek = Validator::make($request, [
			'noKartu' => 'required',
			'tglSep' => 'required',
			'keterangan' => 'required',
		]);
		// dd($cek->passess());
		// if (!$cek->passes()) {
		if ($cek->fails()) {
			return response()->json(['metaData' => ['code' => 201, 'error' => $cek->errors()]]);
		}

		$sep = new \App\SepPengajuan();
		$sep->no_kartu = $request['noKartu'];
		$sep->tanggal_sep = valid_date($request['tglSep']);
		$sep->jenis_pelayanan = $request['jenisPelayanan'];
		$sep->jenis_pengajuan = $request['jenisPengajuan'];
		$sep->keterangan = $request['keterangan'];
		$sep->user = Auth::user()->name;
		// dd($sep);
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		
		$request = '{
		               "request": {
		                  "t_sep": {
		                     "noKartu": "' . $request['noKartu'] . '",
		                     "tglSep": "' . valid_date($request['tglSep']) . '",
		                     "jnsPelayanan": "' . $request['jenisPelayanan'] . '",
							 "jnsPengajuan": "' . $request['jenisPengajuan'] . '",
		                     "keterangan": "' . $request['keterangan'] . '",
		                     "user": "' . Auth::user()->name . '"
		                  }
		               }
		            }'; 
		$completeurl = config('app.sep_url_web_service') . "/Sep/pengajuanSEP";

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
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}

		$array[] = json_decode($response, true);
		// dd($array[0]['metaData']['code']);
		if($array[0]['metaData']['code'] == 200){
			$sep->save();
		}

		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);

		$sml = json_encode($array,JSON_PRETTY_PRINT); 
		return response()->json($sml);
	}

	public function dataPengajuanSEP() {
		$date = date('Y-m-d', strtotime('-2 days'));
		$data = \App\SepPengajuan::orderBy('status')->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])->get();
		return DataTables::of($data)
			->addColumn('jenisPelayanan', function ($data) {
				return ($data->jenis_pelayanan == 2) ? 'Rawat Jalan' : 'Rawat Inap';
			})
			->addColumn('approve', function ($data) {
				if ($data->status == '0') {
					return '<button type="button" onclick="saveApproval(' . $data->id . ')" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-edit"></i"></i></button>';
				} else {
					return '<i class="fa fa-check text-success"></i>';
				}
			})
			->rawColumns(['approve'])
			->make(true);
	}

	public function approveSEP($id) {
		$sep = \App\SepPengajuan::find($id);

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
		             "request": {
		                "t_sep": {
		                   "noKartu": "' . $sep->no_kartu . '",
		                   "tglSep": "' . $sep->tanggal_sep . '",
		                   "jnsPelayanan": "' . $sep->jenis_pelayanan . '",
		                   "jnsPengajuan": "' . $sep->jenis_pengajuan . '",
		                   "keterangan": "' . $sep->keterangan . '",
		                   "user": "' . $sep->user . '"
		                }
		             }
		          }';

		$completeurl = config('app.sep_url_web_service') . "/Sep/aprovalSEP";

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
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}

		$array[] = json_decode($response, true);
		// dd($array[0]['metaData']['code']);
		if($array[0]['metaData']['code'] == 200){
			$sep->status = '1';
			$sep->save();
		}

		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);

		$sml = json_encode($array,JSON_PRETTY_PRINT);
		return response()->json($sml);
	}
	 
	//koding yang lama => "tglPulang":"' . valid_date($request['tglSep']) . ' ' . date('10:25:00') . '",
	public function updateTanggalPulang(Request $request) { 

		// dd($request->noSEP);
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		$tgl_meninggal = !empty($request->tglMeninggal) ? valid_date($request->tglMeninggal) : '';
		$tgl_pulang = !empty($request->tglPulang) ? valid_date($request->tglPulang) : '';
		$req = '{
			"request":{
				"t_sep":{
					"noSep": "'.$request->noSEP.'",
					"statusPulang":"'.$request->statusPulang.'",
					"noSuratMeninggal":"'.$request->suratMeninggal.'",
					"tglMeninggal":"'.$tgl_meninggal.'",
					"tglPulang":"'.$tgl_pulang.'",
					"noLPManual":"'.$request->noLPManual.'",
					"user":"'.Auth::user()->name.'"
				}
			}
		}';  
		// dd($req);
		// if (!$cek->passes()) {
		// 	return response()->json(['metaData' => ['code' => 201, 'message' => 'SEMUA FIELD WAJIB DIISI']]);
		// }

		// $sep = Registrasi::where('no_sep',$request['noSEP'])->count();
		// if ($sep == 0) {
		// 	// Flashy::info('SEP tidak ditemukan di SIMRS, ada kemungkinan SEP dari VCLAM.');
		// 	return response()->json(['metaData' => ['code' => 201, 'message' => 'SEP Tidak Ditemukan di SIMRS']]);
		// }
		// else{
		// 	$updatesep = Registrasi::where('no_sep',$request['noSEP'])->first();
		// 	$updatesep->kondisi_akhir_pasien = $request['statusPulang'];
		// 	$updatesep->surat_meninggal = !empty($request['surat_meninggal']) ? $request['surat_meninggal'] : NULL ;
		// 	$updatesep->update();
		// 	// return $updatesep; die; #updatesep
		// }
		// dd($req);
		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/updtglplg";

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key: ' . config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		); 
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($session, CURLOPT_POSTFIELDS, $req);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		
		$response = curl_exec($session);
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}

		if($response =='No Mapping Rule matched'){
			return response()->json(['metaData'=>['code'=>201,'message'=>'No Mapping Rule matched From BPJS Server']]);
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		// dd($array);
		// $sml = json_decode($response, true);
		$sml = json_encode($array,JSON_PRETTY_PRINT); 
		// dd($sml);
		// $json = json_encode($sml);
		return response()->json($sml);
	}

	// V2
	public function sepHapus($sep) {

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
                "request":
                    {
                    "t_sep":
                        {
                            "noSep":"' . $sep . '",
                            "user": "Ws"
                        }
                    }
            }';

		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/delete";

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'.config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");

		$response = curl_exec($session);
		$message = json_decode($response, true); 
		$array[] = json_decode($response, true);

		if($message['metaData']['code'] == 200){
			$get_sep = HistoriSep::where('no_sep',$sep)->first();
			if($get_sep){
				$log = new LogBridging();
				$log->user_id = Auth::user()->id;
				$log->no_sep = @$get_sep->no_sep;
				$log->kode_dpjp = @$get_sep->kode_dpjp;
				$log->registrasi_id = @$get_sep->registrasi_id;
				$log->no_surat = @$get_sep->no_surat;
				$log->poli_tujuan = @$get_sep->poli_bpjs;
				$log->tgl_rujukan = @$get_sep->tgl_rujukan;
				$log->no_rujukan = @$get_sep->no_rujukan;
				$log->user = Auth::user()->name;
				$log->save();
			}

		}
		
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);

		return response()->json($sml);
	}

	// V2
	public function cariSep(Request $request) {
		$cek = Validator::make($request->all(), [
			'noSEP' => 'required',
		]);
		if (!$cek->passes()) {
			return response()->json(['metaData' => ['code' => 201, 'error' => $cek->errors()]]);
		}
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/SEP/" . $request['noSEP'];

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'.config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
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
		
		// $json = json_encode($sml);
		return response()->json($sml);
	}

	// V2
	function dataKunjungan() {
		return view('bridgingsep.dataKunjungan');
	}

	// V2
	function cariDataKunjungan(Request $req) {
		$re = \LZCompressor\LZString::decompressFromBase64($req->data);
		$request = array();
		parse_str($re, $request);
		// dd($request);

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/Monitoring/Kunjungan/Tanggal/" . valid_date($request['tglSep']) . "/JnsPelayanan/" . $request['jenisPelayanan'];

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

	public function updateBed() {
		$ID = '9606';
		$t = time();
		$data = "$ID&$t";
		$secretKey = '2aH65269D3';
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
					    "kodekelas":"NON",
					    "koderuang":"RG09",
					    "namaruang":"Kamar Gabung",
					    "kapasitas":"11",
					    "tersedia":"8",
					    "tersediapria":"0",
					    "tersediawanita":"0",
					    "tersediapriawanita":"0"

					  }';
		// $request = '{ "kodekelas":"VIP",
		// 			    "koderuang":"RG01"
		// 			 }';

		$completeurl = "http://api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/".config('app.sep_ppkLayanan');

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'Content-Type: application/json',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		return $json;
	}

	// V2
	public function historiKunjungan() {
		return view('bridgingsep.historiKunjungan');
	}
	
	// V2
	function cariHistoriKunjungan(Request $request) {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/monitoring/HistoriPelayanan/NoKartu/" . $request['noKartu'] . "/tglAwal/" . valid_date($request['tga']) . "/tglAkhir/" . valid_date($request['tgb']);

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
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
		// dd($sml);
		// $json = json_encode($sml);
		return response()->json($sml);
	}
	function buatSuratKontrol(Request $req) {
		// dd($req->all());
		$registrasi = Registrasi::find($req->registrasi_id);
		if(empty($registrasi->no_sep)){
			$registrasi->no_sep = @$req->no_sep;
			$registrasi->save();
		}
		$poli = $req->poli_id !== null ? $req->poli_id :Poli::where('bpjs',$registrasi->poli_id)->first()->bpjs;
		// dd($poli);
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
			"request": { 
				"noSEP": "' . $req->no_sep . '",
				"kodeDokter": "' . $req->kode_dokter. '",
				"poliKontrol": "' . $poli. '",
				"tglRencanaKontrol": "' . date('Y-m-d', strtotime($req->rencana_kontrol)) . '",
				"user": "' . Auth::user()->name . '" 
			}
			}'; 
		// dd($request);
		$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/insert";
			
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
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		// dd($array);
		$sml_save = json_decode($response, true);
		// dd($response);
		if($response !== null){
			if(@$array[0]['metaData']['code'] == '200' || @$array[0]['metaData']['code'] == 200){
				$kontrol = RencanaKontrol::where('no_surat_kontrol',$array[1]['noSuratKontrol'])->where('registrasi_id',$req->registrasi_id)->first();
				if(!$kontrol){
					$kontrol = new RencanaKontrol();
				}
				
				$kontrol->registrasi_id = @$req->registrasi_id;
				$kontrol->resume_id = NULL;
				$kontrol->no_surat_kontrol = $array[1]['noSuratKontrol'];
				$kontrol->dokter_id = @Pegawai::where('kode_bpjs',$req->kode_dokter)->first()->id;
				$kontrol->poli_id = @baca_id_poli($req->poli_id);
				$kontrol->pasien_id = $registrasi->pasien_id;
				$kontrol->tgl_rencana_kontrol = date('Y-m-d', strtotime($req->rencana_kontrol));
				$kontrol->user_id = Auth::user()->id;
				$kontrol->input_from = 'form_sep';
				$kontrol->no_sep = $req->no_sep;
				$kontrol->diagnosa_awal = @$array[1]['namaDiagnosa'];
				$kontrol->save();
			}
		}

		// dd($sml);
		// $json = json_encode($sml);
		return response()->json($sml);
	}
	function hapusSuratKontrol(Request $req) { 
		// dd($req->all());
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
			"request": { 
				"t_suratkontrol":{
					"noSuratKontrol": "'.$req->no_surat_kontrol.'",
					"user": "' . Auth::user()->name . '" 
				}
			}
		}'; 
		// dd($request);
		$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/Delete";
			
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
		// curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		// dd($sml);
		// $json = json_encode($sml);
		return response()->json($sml);
	}

	// SEP RUJUKAN
	// V2
	public function insertRujukan(Request $request) {
		session(['sep_rujukan' => $request['noSEP']]);
		$cek = Validator::make($request->all(), [
			'noSEP' => 'required',
			'tglRujukan' => 'required',
			'ppkDirujuk' => 'required',
			'jnsPelayanan' => 'required',
			'catatan' => 'required',
			'diagnosaRujukan' => 'required',
			'tipeRujukan' => 'required',
			'poliRujukan' => 'required',
		]);
		if (!$cek->passes()) {
			return response()->json(['metaData' => ['code' => 201, 'error' => $cek->errors()]]);
		}

		$rjk = new \App\SepRujukanKeluar();
		$rjk->no_sep = $request['noSEP'];
		$rjk->tanggal_rujukan = valid_date($request['tglRujukan']);
		$rjk->ppk_dirujuk = $request['ppkDirujuk'];
		$rjk->jenis_pelayanan = $request['jnsPelayanan'];
		$rjk->catatan = $request['catatan'];
		$rjk->diagnosa = $request['diagnosaRujukan'];
		$rjk->tipe_rujukan = $request['tipeRujukan'];
		$rjk->poli = $request['poliRujukan'];

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
				       "request": {
				          "t_rujukan": {
				             "noSep": "' . $request['noSEP'] . '",
				             "tglRujukan": "' . valid_date($request['tglRujukan']) . '",
				             "tglRencanaKunjungan": "' . valid_date($request['tglRencanaKunjungan']) . '",
				             "ppkDirujuk": "' . $request['ppkDirujuk'] . '",
				             "jnsPelayanan": "' . $request['jnsPelayanan'] . '",
				             "catatan": "' . $request['catatan'] . '",
				             "diagRujukan": "' . $request['diagnosaRujukan'] . '",
				             "tipeRujukan": "' . $request['tipeRujukan'] . '",
				             "poliRujukan": "' . $request['poliRujukan'] . '",
				             "user": "' . Auth::user()->name . '"
				          }
				       }
				    }';

		$completeurl = config('app.sep_url_web_service') . "/Rujukan/2.0/insert";

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: Application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session); 
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$sml = json_decode($response, true); 

		if ($sml['metaData']['code'] == "200") {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);

			$rjk->noRujukan = $sep['rujukan']['noRujukan'];
			$rjk->jnsPeserta = $sep['rujukan']['peserta']['jnsPeserta'];
			$rjk->kelamin = $sep['rujukan']['peserta']['kelamin'];
			$rjk->nama = $sep['rujukan']['peserta']['nama'];
			$rjk->noKartu = $sep['rujukan']['peserta']['noKartu'];
			$rjk->noMR = $sep['rujukan']['peserta']['noMr'];
			$rjk->tglLahir = $sep['rujukan']['peserta']['tglLahir'];
			$rjk->poliTujuan_code = $sep['rujukan']['poliTujuan']['kode'];
			$rjk->poliTujuan_nama = $sep['rujukan']['poliTujuan']['nama'];
			$rjk->tglRujukan = $sep['rujukan']['tglRujukan'];
			$rjk->tglRencanaKunjungan = $sep['rujukan']['tglRencanaKunjungan'];
			$rjk->tujuanRujukan_code = $sep['rujukan']['tujuanRujukan']['kode'];
			$rjk->tujuanRujukan_nama = $sep['rujukan']['tujuanRujukan']['nama'];
			$rjk->user = Auth::user()->name;
			$rjk->save();
			// $sep['metaData']['noSEP'] = $rjk->no_sep;
			//return redirect('/bridgingsep/cetak-rujukan/'.$request['noSEP']);
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml2 = json_encode($array,JSON_PRETTY_PRINT);
		// // dd($sml);
		// $json = json_decode($array,true);
		
		

		// dd($sml);
		


		
		return response()->json($sml2);
	}

	public function insertRujukan2(Request $request) {
		session(['sep_rujukan' => $request['noSEP']]);
		$cek = Validator::make($request->all(), [
			'noSEP' => 'required',
			'tglRujukan' => 'required',
			'ppkDirujuk' => 'required',
			'jnsPelayanan' => 'required',
			'catatan' => 'required',
			'diagnosaRujukan' => 'required',
			'tipeRujukan' => 'required',
			'poliRujukan' => 'required',
		]);
		if (!$cek->passes()) {
			return response()->json(['metaData' => ['code' => 201, 'error' => $cek->errors()]]);
		}
		$nosep = $request['noSEP'];
		$rjk = new \App\SepRujukanKeluar();
		$rjk->no_sep = $request['noSEP'];
		$rjk->tanggal_rujukan = valid_date($request['tglRujukan']);
		$rjk->ppk_dirujuk = $request['ppkDirujuk'];
		$rjk->jenis_pelayanan = $request['jnsPelayanan'];
		$rjk->catatan = $request['catatan'];
		$rjk->diagnosa = $request['diagnosaRujukan'];
		$rjk->tipe_rujukan = $request['tipeRujukan'];
		$rjk->poli = $request['poliRujukan'];

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
				       "request": {
				          "t_rujukan": {
				             "noSep": "' . $request['noSEP'] . '",
				             "tglRujukan": "' . valid_date($request['tglRujukan']) . '",
				             "tglRencanaKunjungan": "' . valid_date($request['tglRencanaKunjungan']) . '",
				             "ppkDirujuk": "' . $request['ppkDirujuk'] . '",
				             "jnsPelayanan": "' . $request['jnsPelayanan'] . '",
				             "catatan": "' . $request['catatan'] . '",
				             "diagRujukan": "' . $request['diagnosaRujukan'] . '",
				             "tipeRujukan": "' . $request['tipeRujukan'] . '",
				             "poliRujukan": "' . $request['poliRujukan'] . '",
				             "user": "' . Auth::user()->name . '"
				          }
				       }
				    }';

		$completeurl = config('app.sep_url_web_service') . "/Rujukan/2.0/insert";

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: Application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session); 
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$sml = json_decode($response, true); 

		if ($sml['metaData']['code'] == "200") {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);

			$rjk->noRujukan = $sep['rujukan']['noRujukan'];
			$rjk->jnsPeserta = $sep['rujukan']['peserta']['jnsPeserta'];
			$rjk->kelamin = $sep['rujukan']['peserta']['kelamin'];
			$rjk->nama = $sep['rujukan']['peserta']['nama'];
			$rjk->noKartu = $sep['rujukan']['peserta']['noKartu'];
			$rjk->noMR = $sep['rujukan']['peserta']['noMr'];
			$rjk->tglLahir = $sep['rujukan']['peserta']['tglLahir'];
			$rjk->poliTujuan_code = $sep['rujukan']['poliTujuan']['kode'];
			$rjk->poliTujuan_nama = $sep['rujukan']['poliTujuan']['nama'];
			$rjk->tglRujukan = $sep['rujukan']['tglRujukan'];
			$rjk->tglRencanaKunjungan = $sep['rujukan']['tglRencanaKunjungan'];
			$rjk->tujuanRujukan_code = $sep['rujukan']['tujuanRujukan']['kode'];
			$rjk->tujuanRujukan_nama = $sep['rujukan']['tujuanRujukan']['nama'];
			$rjk->user = Auth::user()->name;
			$rjk->save();
			// $sep['metaData']['noSEP'] = $rjk->no_sep;
			 
			$json = [['metaData'=>['code'=>'200','message'=>$nosep]]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT)); 
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml2 = json_encode($array,JSON_PRETTY_PRINT);
		// // dd($sml);
		// $json = json_decode($array,true);
		
		

		// dd($sml);
		


		
		return response()->json($sml2);
	}
	public function updateRujukan(Request $request) {
		session(['sep_rujukan' => $request['noSEP']]);
		$cek = Validator::make($request->all(), [
			'noSEP' => 'required',
			'tglRujukan' => 'required',
			'ppkDirujuk' => 'required',
			'jnsPelayanan' => 'required',
			'catatan' => 'required',
			'diagnosaRujukan' => 'required',
			'tipeRujukan' => 'required',
			'poliRujukan' => 'required',
		]);
		if (!$cek->passes()) {
			return response()->json(['metaData' => ['code' => 201, 'error' => $cek->errors()]]);
		}

		$rjk = new \App\SepRujukanKeluar();
		$rjk->no_sep = $request['noSEP'];
		$rjk->tanggal_rujukan = valid_date($request['tglRujukan']);
		$rjk->ppk_dirujuk = $request['ppkDirujuk'];
		$rjk->jenis_pelayanan = $request['jnsPelayanan'];
		$rjk->catatan = $request['catatan'];
		$rjk->diagnosa = $request['diagnosaRujukan'];
		$rjk->tipe_rujukan = $request['tipeRujukan'];
		$rjk->poli = $request['poliRujukan'];

		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$request = '{
				       "request": {
				          "t_rujukan": {
				             "noSep": "' . $request['noSEP'] . '",
				             "tglRujukan": "' . valid_date($request['tglRujukan']) . '",
				             "tglRencanaKunjungan": "' . valid_date($request['tglRencanaKunjungan']) . '",
				             "ppkDirujuk": "' . $request['ppkDirujuk'] . '",
				             "jnsPelayanan": "' . $request['jnsPelayanan'] . '",
				             "catatan": "' . $request['catatan'] . '",
				             "diagRujukan": "' . $request['diagnosaRujukan'] . '",
				             "tipeRujukan": "' . $request['tipeRujukan'] . '",
				             "poliRujukan": "' . $request['poliRujukan'] . '",
				             "user": "' . Auth::user()->name . '"
				          }
				       }
				    }';

		$completeurl = config('app.sep_url_web_service') . "/Rujukan/2.0/insert";

		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: Application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session); 
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$sml = json_decode($response, true); 

		if ($sml['metaData']['code'] == "200") {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);

			$rjk->noRujukan = $sep['rujukan']['noRujukan'];
			$rjk->jnsPeserta = $sep['rujukan']['peserta']['jnsPeserta'];
			$rjk->kelamin = $sep['rujukan']['peserta']['kelamin'];
			$rjk->nama = $sep['rujukan']['peserta']['nama'];
			$rjk->noKartu = $sep['rujukan']['peserta']['noKartu'];
			$rjk->noMR = $sep['rujukan']['peserta']['noMr'];
			$rjk->tglLahir = $sep['rujukan']['peserta']['tglLahir'];
			$rjk->poliTujuan_code = $sep['rujukan']['poliTujuan']['kode'];
			$rjk->poliTujuan_nama = $sep['rujukan']['poliTujuan']['nama'];
			$rjk->tglRujukan = $sep['rujukan']['tglRujukan'];
			$rjk->tglRencanaKunjungan = $sep['rujukan']['tglRencanaKunjungan'];
			$rjk->tujuanRujukan_code = $sep['rujukan']['tujuanRujukan']['kode'];
			$rjk->tujuanRujukan_nama = $sep['rujukan']['tujuanRujukan']['nama'];
			$rjk->user = Auth::user()->name;
			$rjk->save();
			// $sep['metaData']['noSEP'] = $rjk->no_sep;
			//return redirect('/bridgingsep/cetak-rujukan/'.$request['noSEP']);
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml2 = json_encode($array,JSON_PRETTY_PRINT);
		// // dd($sml);
		// $json = json_decode($array,true);
		
		

		// dd($sml);
		


		
		return response()->json($sml2);
	}


	public function laporanTaskId(Request $r) {
		$data_antrian = [];
		if ($r->method() == 'POST')
		{
			ini_set('max_execution_time', 0); //0=NOLIMIT
			ini_set('memory_limit', '8000M');

			$cek_reg = Registrasi::
						whereBetween('created_at', [valid_date($r->tgl). ' 00:00:00', valid_date($r->tgl_akhir) . ' 23:59:59'])
						// where('created_at','LIKE', valid_date($r->tgl).'%')
						->whereNotNull('nomorantrian')
						->orderBy('poli_id','ASC')
						->get();

			foreach($cek_reg as $key=> $c){
				@$data_antrian[$key]['poli'] = baca_poli($c->poli_id);
				@$data_antrian[$key]['nomorantrian'] = $c->nomorantrian;
				@$data_antrian[$key]['nama'] = $c->pasien->nama;
				@$data_antrian[$key]['no_rm'] = $c->pasien->no_rm;
				// $cek_re[] = $c->nomorantrian;
				$ID = config('app.consid_antrean');
				date_default_timezone_set('Asia/Jakarta');
				$t = time();
				$data = "$ID&$t";
				$secretKey = config('app.secretkey_antrean');
				$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

				$request = array();
				// parse_str($re, $request);
				$req = '{"kodebooking": "'.$c->nomorantrian.'"}'; 
				// dd($req);
				$completeurl = config('app.antrean_url_web_service') . "antrean/getlisttask";
				// dd($completeurl);
				
				$session = curl_init($completeurl);
				$arrheader = array(
					'x-cons-id: ' . $ID,
					'x-timestamp: ' . $t,
					'x-signature: ' . $signature,
					'user_key:'.config('app.user_key_antrean'),
					'Content-Type: application/json',
				);
				curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session, CURLOPT_POSTFIELDS, $req);
				curl_setopt($session, CURLOPT_POST, TRUE);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
				@$response = curl_exec($session);
				// // dd($response);
				@$message = json_decode($response, true);
				@$array = json_decode($response, true);
				if(@$message['metadata']['code'] == 200){
					@$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array['response']);
					@$array = json_decode($this->decompress($stringEncrypt),true);
					@$data_antrian[$key]['data'] = $array;
				}
			}
			// dd($data_antrian);
			// dd($cek_reg);
			// dd($r->all());
			Excel::create('Lap Responses Time Pelayanan '.$r->tgl, function ($excel) use ($data_antrian) {
				// Set the properties
				$excel->setTitle('Lap Responses Time Pelayanan')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Responses Time Pelayanan');
				$excel->sheet('Lap Responses Time Pelayanan', function ($sheet) use ($data_antrian) {
					$row = 1;
					$no  = 1;
					$sheet->row($row, [
						'No',
						'Kode Booking',
						'RM',
						'poli',
						'Poli',
						'TaskID 1',
						'TaskID 2',
						'TaskID 3',
						'TaskID 4',
						'TaskID 5',
						'TaskID 6',
						'TaskID 7'
					]);
					foreach ($data_antrian as $key => $d) {
						if (!empty($d['data'])) {

							// Inisialisasi kolom TaskID 1-7 dengan null
							@$tasks = array_fill(1, 7, '');

							// Isi berdasarkan taskid
							foreach ($d['data'] as $task) {
								@$id = $task['taskid'];
								if ($id >= 1 && $id <= 7) {
									@$tasks[$id] = $task['wakturs'];
								}
							}

							// Tulis ke baris Excel sesuai urutan kolom
							$sheet->row(++$row, [
								@$no++,
								@$d['nomorantrian'] ?? '',
								@$d['no_rm'] ?? '',
								@$d['nama'] ?? '',
								@$d['poli'] ?? '',
								@$tasks[1],
								@$tasks[2],
								@$tasks[3],
								@$tasks[4],
								@$tasks[5],
								@$tasks[6],
								@$tasks[7],
							]);
						}
					}
				});
			})->export('xlsx');
		}
		// dd($data_antrian);
		
		return view('bridgingsep.laporanTaskid',compact('data_antrian'));
	}
	public function referensiKelas() {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		//$completeurl = "http://api.bpjs-kesehatan.go.id/aplicaresws/rest/ref/kelas";
		$completeurl = config('app.sep_url_web_service') . "/referensi/dokter/pelayanan/2/tglPelayanan/2018-10-08/Spesialis/GIG";
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
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
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		// echo $json; die;
		return response()->json($sml);
	}

	public function dokterBPJS($kode) {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		//$completeurl = "http://api.bpjs-kesehatan.go.id/aplicaresws/rest/ref/kelas";
		$completeurl = config('app.sep_url_web_service') . "/referensi/dokter/pelayanan/2/tglPelayanan/" . date('Y-m-d') . "/Spesialis/" . $kode;
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
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
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		return response()->json($sml);
	}
	// V2
	public function rujukanPPK2(Request $request) {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/Rujukan/RS/List/Peserta/" . \LZCompressor\LZString::decompressFromEncodedURIComponent($request['no_kartu']);
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
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
		$sml = json_decode($response, true);
		// dd($sml);
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);

		$sml = json_encode($array,JSON_PRETTY_PRINT); 
		
		return response()->json($sml);
	}

	// SUDAH V2
	public function rujukanPPK2byNomorRujukan(Request $request) {
		// dd($request->all());
		if($request->data){
			request()->validate(['data' => 'required']);
			$re = \LZCompressor\LZString::decompressFromBase64($request->data);
			$removeParam = str_replace("no_rujukan=","",$re);
			$no_rujukan_encode = explode('&',$removeParam);
			$no_rujukan = $no_rujukan_encode[2];
		}else{
			$no_rujukan = \LZCompressor\LZString::decompressFromBase64($request['no_rujukan']);
		}
		// dd($no_rujukan);
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/Rujukan/RS/" . $no_rujukan;
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
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
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		// dd($sml);
		// $encodedResult = \LZCompressor\LZString::compressToBase64($sml);
		return response()->json($sml);
	}

	public function postHD(Request $request) {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/Rujukan/List/Peserta/" . $request['no_kartu'];
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'Content-Type: application/json; charset=utf-8',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		return response()->json($sml);
	}

	public function cetakRujukan($noSep) {
		session()->forget('sep_rujukan');
		$data = \App\SepRujukanKeluar::where('no_sep', $noSep)->first();
		$pdf = PDF::loadView('bridgingsep.cetak_rujukan', compact('data'));
		$customPaper = array(0, 0, 793.7007874, 340);
		$pdf->setPaper($customPaper);
		return $pdf->stream();
	}

	public function getKodePPK2(Request $request) {
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = \App\FaskesLanjutan::where('nama_ppk', 'like', '%' . $term . '%')->limit(5)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->kode_ppk, 'text' => $tag->nama_ppk];
		}

		return \Response::json($formatted_tags);
	}

	public function getPoliRujukan() {
		return \App\SepPoliLanjutan::select('kode_poli', 'nama_poli')->get();
	}

	public function getDokter() {
		return Pegawai::where('kategori_pegawai', 1)->where('kode_bpjs', '<>', '')->get();
	}

	//laporan klaim
	public function dataKlaim(Request $request) {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/Monitoring/Klaim/Tanggal/" . valid_date($request['tgl_pulang']) . "/JnsPelayanan/" . $request['jenis_pelayanan'] . "/Status/" . $request['status'];
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
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
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		 
		$sml = json_encode($array,JSON_PRETTY_PRINT);
		return response()->json($sml);
	}
	//laporan klaim pdf
	public function getDataKlaim(Request $request) {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service') . "/Monitoring/Klaim/Tanggal/" . valid_date($request['tgl_pulang']) . "/JnsPelayanan/" . $request['jenis_pelayanan'] . "/Status/" . $request['status'];
		$session = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
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
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		$dataKlaim['sml'] = $sml;
		if(!$sml['metaData']['message'] == 'Data Tidak Ada'){
			return view('bridgingsep.data_klaim_pdf', $dataKlaim)->with('no', 1);
		}else{
			return view('bridgingsep.data_klaim');
		}
		// return $sml;
	}

	public function getPpk($nama_ppk){
		$data = \App\FaskesLanjutan::where('nama_ppk','like', $nama_ppk.'%')->take(10)->pluck('nama_ppk');
		return response()->json($data);
	}

	public function kodePpk($nama_ppk)
	{
		$data = \App\FaskesLanjutan::where('nama_ppk', 'like', $nama_ppk . '%')->take(10)->pluck('kode_ppk');
		return response()->json($data);
	}

	// V2
	function viewUpdateRujukan(Request $req) {
		$no_spri = $req->input('no');
		if($req->ajax()){
			$rjk = \App\SepRujukanKeluar::where('noRujukan',$req->nomor)->first();
			if($rjk){
				$sml = $rjk;
				$sml = json_decode($sml,true);
				$sml['meta']['status'] = 'ok';
				$sml['meta']['code']   = '200';
			}else{
				$sml['meta'] = [
					'status'=>'No. Rujukan tidak ditemukan didatabase',
					'code' => '201'
				];
			}
			// dd($sml);
			
			// dd($sml);
			// $array[] = json_decode($response, true);
			// $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
			// $array[] = json_decode($this->decompress($stringEncrypt),true);

			// $sml = json_encode($array,JSON_PRETTY_PRINT); 
			return response()->json($sml);
		}

		return view('bridgingsep.updateRujukan',compact('no_spri'));
	}

	public function exporttarif($bulan){

		$hasillab = Hasillab::where('created_at','LIKE','2024-'.$bulan.'%')->whereNotNull('json')->select('json','id')->get();
		foreach($hasillab as $hl){
			$hasil  = Hasillab::where('id',$hl->id)->first();
			$hasil->json = compress_json($hasil->json);
			$hasil->save();
		}
		
		dd("BERHASIL");



		$tarif = Tarif::groupBy('nama')->groupBy('total')->groupBy('kelas_id')->orderBy('kelas_id','ASC')->orderBy('nama','ASC')->select('nama','total','kelas_id','kategoritarif_id')->get();
		// dd($tarif);
		Excel::create('Tarif 2023', function ($excel) use ($tarif) {
			$excel->setTitle('Tarif 2023')
				->setCreator('Digihealth')
				->setCompany('Digihealth')
				->setDescription('Tarif 2023');
			$excel->sheet('Tarif 2023', function ($sheet) use ($tarif) {
				$row = 3;
				$no = 1;

				$sheet->row(2, [
					'No',
					'Tarif',
					'Harga',
					'Harga_Baru',
					'Kelas',
					'Kategori Tarif',
					'Kelas_id'
				]);
				foreach ($tarif as $key => $d) {
				
					$sheet->row(++$row, [
						$no++,
						@$d->nama,
						@$d->total,
						'',
						@$d->kelas_id ? @baca_kelas($d->kelas_id) : '',
						@$d->kategoritarif_id ? @$d->kategoritarif->namatarif : '',
						@$d->kelas_id,
					]);
				}
			});
		})->export('xlsx');

	}
}