<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use MercurySeries\Flashy\Flashy;
use App\MasterEtiket;
use PDF;
use App\BpjsObatPRB;
use App\BpjsProgramPRB;
use App\BpjsPRB;
use App\BpjsPRBDetail;
use App\BpjsPRBResponse;
use Carbon\Carbon;
use Auth;
use DB;

class BridgingPRBController extends Controller
{
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

	function HashBPJS() {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key'); 

		date_default_timezone_set('UTC');
		$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
		$encodedSignature = base64_encode($signature);
		// $encodedSignature = \LZCompressor\LZString::compressToBase64($signature);;
		return array($ID, $t, $encodedSignature);
	}
	// V2
    public function callAPI($method, $url, $body = '', $content_type = '') {
 
		date_default_timezone_set('UTC');
		$ID             = config('app.test_sep_id');
		$t              = time();
		$data           = "$ID&$t";
		$secretKey      = config('app.test_sep_key');
		$signature      = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		$completeurl    = config('app.sep_url_web_service') . $url;
        
		$ch        		= curl_init($completeurl);

		$content_type	= ($content_type == "form") ? "Application/x-www-form-urlencoded" : "application/json; charset=utf-8";

		$header      	= array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key: ' . config('app.user_key'),
			'Content-Type: ' . $content_type,
		);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');

		$result       	= curl_exec($ch);
		$result 		= json_decode($result, TRUE);
		dd($result);
		curl_close($ch);
		return $result;
	}

    public function prb() {
        $data['reg']          = [];
        return view('bridgingsep.rujuk_balik', $data);
    }

	// V2
	public function prb_delete($id) {
		DB::beginTransaction();
		try{
			$find	= BpjsPRB::find($id);
			if($find){
				$ID = config('app.sep_id');
				date_default_timezone_set('UTC');
				$t = time();
				$data = "$ID&$t";
				$secretKey = config('app.sep_key');
				$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
				$request = '{
							"request":
							{"t_sep":
								{
									"noSep":"' . $find->no_sep . '",
									"noSep":"' . $find->no_srb . '",
									"user":"' . Auth::user()->id . '"
								}
							}
						}';
				// return $request; die;
				$uri = config('app.sep_url_web_service');
				$completeurl = "$uri/PRB/Delete";
	
				$session = curl_init($completeurl);
				$arrheader = array(
					'X-cons-id: ' . $ID,
					'X-timestamp: ' . $t,
					'X-signature: ' . $signature,
					'user_key:'. config('app.user_key'),
					'Content-Type: application/x-www-form-urlencoded',
				);
				curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($session, CURLOPT_POSTFIELDS, $request);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
				$response = curl_exec($session);
				$sml = json_decode($response, true);
				if ($sml['metaData']['code'] == 200) {
					$find->delete();
					DB::commit(); 
		
					$res	= [
						"status" 	=> "success",
						"text"		=> "Delete PRB Success!"
					];
					return response()->json($res);
				} else {
					$res	= [
						"status" 	=> "failed",
						"text"		=> "Delete PRB Gagal!"
					];
					return response()->json($res);
				}
				
				// call API BPJS
				

			}else{
				$res	= [
					"status" 	=> "gagal",
					"text"		=> "Delete PRB Gagal!"
				];
				return response()->json($res);
			}


		}catch( \Exception $e ){
			DB::rollback();
			$res	= [
				"status" 	=> "error",
				"text"		=> "Error Delete PRB. Error: ".$e->getMessage()
			];
			return response()->json($res);
		}
	}

    public function prb_search(Request $request) {
		$data['reg']    = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                        ->where('registrasis.bayar', 1)
                        ->whereNotIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
                        ->where('pasiens.no_rm', $request['no_rm'])
                        ->orderBy('registrasis.id', 'desc')
                        ->select('registrasis.id', 'registrasis.poli_id', 'registrasis.dokter_id', 'registrasis.no_sep', 'registrasis.created_at', 'pasiens.no_rm', 'pasiens.nama')
                        ->get();
        return view('bridgingsep.rujuk_balik', $data);
	}

    public function prb_proses($reg_id, $id = '') { 
		$registrasi			= Registrasi::find($reg_id);
		$dokter = Pegawai::all();
		if( !isset($registrasi->id) ) {
			Flashy::success('Berhasil disimpan');
			return redirect('bridgingsep/rujuk-balik');
		}
		$pasien				= Pasien::find($registrasi->pasien_id);
		$kode_dokter_dpjp	= Pegawai::find($registrasi->dokter_id);
		$program_prb		= BpjsProgramPRB::pluck('nama','kode');
		$obat_prb			= BpjsObatPRB::get();
		$signa				= MasterEtiket::get();
		$bpjs_prb			= BpjsPRB::where('reg_id', $reg_id)->get();
		$prb				= '';
		$prb_detail			= [];
		if( $id != '' )
			$prb			= BpjsPRB::find($id);
			$prb_detail		= BpjsPRBDetail::where('bpjs_prb_id',$id)->get();

		$data          = [
			"reg"				=> $registrasi,
			"pasien"			=> $pasien,
			'kode_dokter_dpjp'	=> $kode_dokter_dpjp,
			'dokter'			=> $dokter,
			'program_prb'		=> $program_prb,
			'obat_prb'			=> $obat_prb,
			'signa'				=> $signa,
			'bpjs_prb'			=> $bpjs_prb,
			"prb"				=> $prb,
			'prb_detail'		=> $prb_detail
		];
		// dd($data);
        return view('bridgingsep.rujuk_balik_proses', $data);
    }
    public function prb_cetak($reg_id, $id = '') { 
		$registrasi			= Registrasi::find($reg_id);
		$dokter = Pegawai::all();
		if( !isset($registrasi->id) ) {
			Flashy::success('Berhasil disimpan');
			return redirect('bridgingsep/rujuk-balik');
		}
		$pasien				= Pasien::find($registrasi->pasien_id);
		$kode_dokter_dpjp	= Pegawai::find($registrasi->dokter_id);
		$obat_prb			= BpjsObatPRB::get();
		$signa				= MasterEtiket::get();
		$bpjs_prb			= BpjsPRB::where('reg_id', $reg_id)->get();
		$prb				= '';
		$program_prb		= '';
		$prb_detail			= [];
		if( $id != '' ){
			$prb			= BpjsPRB::find($id);
			$prb_detail		= BpjsPRBDetail::where('bpjs_prb_id',$id)->get();
			$program_prb	= BpjsProgramPRB::where('kode',$prb->program_prb)->first();

		}

		$data          = [
			"reg"				=> $registrasi,
			"pasien"			=> $pasien,
			'kode_dokter_dpjp'	=> $kode_dokter_dpjp,
			'dokter'			=> $dokter,
			'program_prb'		=> $program_prb,
			'obat_prb'			=> $obat_prb,
			'signa'				=> $signa,
			'bpjs_prb'			=> $bpjs_prb,
			"prb"				=> $prb,
			'prb_detail'		=> $prb_detail
		];
		// dd($data);
        // return view('bridgingsep.rujuk_balik_proses', $data);
		$pdf = PDF::loadView('bridgingsep.cetak_prb', $data);
		// $customPaper = array(0, 0, 793.7007874, 340);
		$customPaper = array(0, 0, 793.7007874, 360);
		$pdf->setPaper($customPaper);
		// return $pdf->download('lab.pdf');
		return $pdf->stream();
    }

	// V2
	public function prb_save( Request $request ) {
		
		DB::beginTransaction();
		try{
			$data_prb = [
				"reg_id"		=> $request->reg_id,
				"pasien_id"		=> $request->pasien_id,
				"no_srb"		=> null,
				"no_sep"		=> $request->no_sep,
				"no_kartu"		=> $request->no_kartu,
				"email"			=> $request->email,
				"alamat"		=> $request->alamat,
				"program_prb"	=> $request->program_prb,
				"kode_dpjp"		=> $request->kode_dokter_dpjp,
				"keterangan"	=> $request->keterangan,
				"saran"			=> $request->saran,
				"user"			=> Auth::user()->id,
				"created_by"	=> Auth::user()->id,
			];

			$prb 	= BpjsPRB::create($data_prb);

			$data_prb_detail = [];
			$obat_a			= [];
			foreach( $request->jml as $key => $val ) {
				$data_prb_detail[] = [
					"bpjs_prb_id"	=> $prb->id,
					"kode_obat"		=> $request->obat_id[$key],
					"signa_1"		=> $request->signa_1[$key],
					"signa_2"		=> $request->signa_2[$key],
					"jumlah"		=> $val,
					'created_at'	=> Carbon::now(),
					'updated_at'	=> Carbon::now(),
				];
				$obat_a[] = [
					"kdObat"		=> $request->obat_id[$key],
					// "kdObat"		=> '00010000017',
					"signa1"		=> $request->signa_1[$key],
					"signa2"		=> $request->signa_2[$key],
					"jmlObat"		=> $val
				];
			}

			BpjsPRBDetail::insert($data_prb_detail);

			// CALL API BPJS
			$user_id		= Auth::user()->id;
			$ID = config('app.sep_id');
			date_default_timezone_set('UTC');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.sep_key');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
			
			$body_prb		= '{
				"request": {
					"t_prb": {
						"noSep": "'.$request->no_sep.'",
						"noKartu": "'.$request->no_kartu.'",
						"alamat": "'.$request->alamat.'",
						"email": "'.$request->email.'",
						"programPRB": "'.$request->program_prb.'",
						"kodeDPJP": "'.$request->kode_dokter_dpjp.'",
						"keterangan": "'.$request->keterangan.'",
						"saran": "'.$request->saran.'",
						"user": "'.$user_id.'"
					}
				}
			}';

			$body_prb									= json_decode($body_prb, true);
			$body_prb['request']['t_prb']['obat']		= $obat_a;
			// dd($body_prb);
			$completeurl = config('app.sep_url_web_service') . "/PRB/insert";
			

			$session = curl_init($completeurl);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.user_key'),
				'Content-Type: application/x-www-form-urlencoded',
			);
			// dd(json_decode($body_prb));
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($body_prb));
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			
			$response = curl_exec($session);
			$sml = json_decode($response, true);
			// dd($sml);
			if ($sml['metaData']['message'] == 'Sukses') {
				$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
				$res = json_decode($this->decompress($stringEncrypt),true);
				// dd($res);
				$find	= BpjsPRB::find($prb->id);
				$find->update([
					"no_srb"	=> $res['noSRB']
				]);

				// END CALL API BPJS

				DB::commit();
				// dd($res);
				Flashy::success('Berhasil Simpan');
				return redirect()->back();


				// return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
			} else {
				// dd($sml);
				Flashy::error('Gagal Simpan,' .$sml['metaData']['message']);
				return redirect()->back();
			}
			// $prb_insert		= $this->callAPI('POST', '/PRB/insert', json_encode($body_prb), 'form');

			
		}catch( \Exception $e ){
			DB::rollback();
			// dd($e->getMessage());
			Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
			return redirect()->back();
		}
	}

	public function prb_update( Request $request, $id ) {
		DB::beginTransaction();
		try{
			$user_id		= Auth::user()->id;
			$ID = config('app.sep_id');
			date_default_timezone_set('UTC');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.sep_key');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
			
			$prb	= BpjsPRB::find($id);

			$data_prb = [
				"reg_id"		=> $request->reg_id,
				"pasien_id"		=> $request->pasien_id,
				"no_srb"		=> null,
				"no_sep"		=> $request->no_sep,
				"no_kartu"		=> $request->no_kartu,
				"email"			=> $request->email,
				"alamat"		=> $request->alamat,
				"program_prb"	=> $request->program_prb,
				"kode_dpjp"		=> $request->kode_dokter_dpjp,
				"keterangan"	=> $request->keterangan,
				"saran"			=> $request->saran,
				"user"			=> Auth::user()->id,
				"created_by"	=> Auth::user()->id,
			];

			$prb->update($data_prb);

			

			$data_prb_detail = [];
			foreach( $request->jml as $key => $val ) {
				$data_prb_detail[] = [
					"bpjs_prb_id"	=> $prb->id,
					"kode_obat"		=> $request->obat_id[$key],
					"signa_1"		=> $request->signa_1[$key],
					"signa_2"		=> $request->signa_2[$key],
					"jumlah"		=> $val,
					'created_at'	=> Carbon::now(),
					'updated_at'	=> Carbon::now(),
				];
				$obat_a[] = [
					"kdObat"		=> $request->obat_id[$key],
					// "kdObat"		=> '00010000017',
					"signa1"		=> $request->signa_1[$key],
					"signa2"		=> $request->signa_2[$key],
					"jmlObat"		=> $val
				];
			}
			$body_prb		= '{
				"request": {
					"t_prb": {
						"noSep": "'.$request->no_sep.'",
						"noKartu": "'.$request->no_kartu.'",
						"alamat": "'.$request->alamat.'",
						"email": "'.$request->email.'",
						"programPRB": "'.$request->program_prb.'",
						"kodeDPJP": "'.$request->kode_dokter_dpjp.'",
						"keterangan": "'.$request->keterangan.'",
						"saran": "'.$request->saran.'",
						"user": "'.$user_id.'"
					}
				}
			}';

			$body_prb									= json_decode($body_prb, true);
			$body_prb['request']['t_prb']['obat']		= $obat_a;
			

			// CALL API BPJS
			
			$completeurl = config('app.sep_url_web_service') . "/PRB/Update";
			

			$session = curl_init($completeurl);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.user_key'),
				'Content-Type: application/x-www-form-urlencoded',
			);
			// dd(json_decode($body_prb));
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($body_prb));
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			
			$response = curl_exec($session);
			$sml = json_decode($response, true);
			// dd($sml);
			if ($sml['metaData']['message'] == 'Sukses') {
				BpjsPRBDetail::where('bpjs_prb_id', $prb->id)->delete();	// delete prb detail
				BpjsPRBDetail::insert($data_prb_detail);
				$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
				$res = json_decode($this->decompress($stringEncrypt),true);
				// dd($res);
				$find	= BpjsPRB::find($prb->id);
				$find->update([
					"no_srb"	=> $res['noSRB']
				]);

				// END CALL API BPJS

				DB::commit();
				// dd($res);
				Flashy::success('Berhasil Simpan');
				return redirect()->back();


				// return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
			} else {
				// dd($sml);
				Flashy::error('Gagal Simpan,' .$sml['metaData']['message']);
				return redirect()->back();
			}

			// END CALL API BPJS

			DB::commit();
			Flashy::success('Berhasi Update');
			return redirect()->back();
		}catch( \Exception $e ){
			DB::rollback();
			Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
			return redirect()->back();
		}
	}
	// V2
	public function cari_sep(Request $request) {
		$ID = config('app.sep_id');
		$t = time();
		$datasep = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('UTC');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($datasep), utf8_encode($secretKey), true));

		$completeurl = config('app.sep_url_web_service')."/SEP/" . $request->sep;
		

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
		$sep = json_decode($this->decompress($stringEncrypt),true);

		if( isset($sep['noSep']) ) {
			$status = "success";
			$table 	= "<table class='table table-bordered'>
						<thead>
							<tr>
								<th>Nama</th>
								<th>Tgl Lahir</th>
								<th>Jenis Kelamin</th>
								<th>Jenis Peserta</th>
								<th>No Kartu</th>
								<th>No SEP</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td>".$sep['peserta']['nama']."</td>
							<td>".$sep['peserta']['tglLahir']."</td>
							<td>".$sep['peserta']['kelamin']."</td>
							<td>".$sep['peserta']['jnsPeserta']."</td>
							<td>".$sep['peserta']['noKartu']."</td>
							<td>".$sep['noSep']."</td>
						</tr>
						</tbody>
						</table>";
			$data	= [
						"no_sep"	=> $sep['noSep'],
						"no_kartu"	=> $sep['peserta']['noKartu']
					];
		}else{
			$status = "error";
			$table 	= "<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Nama</th>
									<th>Jenis Kelamin</th>
									<th>Jenis Peserta</th>
									<th>Tgl Lahir</th>
									<th>No Kartu</th>
									<th>No SEP</th>
								</tr>
							</thead>
							<tbody>
							<tr>
								<td class='text-center' colspan='6'>".$sml['metaData']['message']."</td>
							</tr>
							</tbody>
							</table>";
			$data	= [];
		}

		$html  = [
			"status"	=> $status,
			"html"		=> '<hr><br>'.$table,
			"data"		=> $data
		];
        return response()->json($html);
	}

	// V2
	public function search_referensi_obat_prb(Request $request) {
		// dd($request->q);
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.sep_url_web_service') . "/referensi/obatprb/".$request->q;
 
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$sml = json_decode($this->decompress($stringEncrypt),true);
		// $sml = json_encode($array,JSON_PRETTY_PRINT); 
		// dd($sml);

		$data	= [];
		if($array[0]['metaData']['code'] ==200){
			if( isset( $sml['list'] ) ){
				foreach( $sml['list'] as $val_o ) {
					$data[]	= [
						"id"	=> $val_o['kode'],
						"text"	=> $val_o['nama'],
					];
				}
			}
		}

		return response()->json($data);
	}

	public function sync_obat_prb($param) {
		// dd($request->q);
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.sep_url_web_service') . "/referensi/obatprb/".$param;
 
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$sml = json_decode($this->decompress($stringEncrypt),true);
		// $sml = json_encode($array,JSON_PRETTY_PRINT); 
		// dd($sml);

		$data	= [];
		if($array[0]['metaData']['code'] ==200){
			if( isset( $sml['list'] ) ){
				foreach( $sml['list'] as $val_o ) {
					$data[]	= [
						"id"	=> $val_o['kode'],
						"text"	=> $val_o['nama'],
					];
				}
			}

			foreach($data as $d){
				$obat_prb	= BpjsObatPRB::where('kode',$d['id'])->first();
				if(empty($obat_prb)){
					$obat = new BpjsObatPRB();
					$obat->kode = $d['id'];
					$obat->nama = $d['text'];
					$obat->save();
				}else{
					$obat_prb->nama = $d['text'];
					$obat_prb->save();
				}
			}
		}
		
		Flashy::success('SUKSES SINKRON DATA OBAT '.strtoupper($param).' DARI BPJS KE DATABASE LOKAL');
		return redirect('bridgingsep');
	}

	public function seeder() {
		$string = '[
			{
			  "kode": "00019100017",
			  "nama": "Analog Insulin Long Acting inj 100 UI/ml"
			},
			{
			  "kode": "00012300016",
			  "nama": "Analog Insulin Mix Acting inj 100 UI/ml"
			}
		  ]';
		  $json = json_decode($string,true);
		  
		  BpjsObatPRB::insert($json);
		  dd($json);
	}

}
