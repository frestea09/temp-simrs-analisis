<?php

namespace App\Http\Controllers;

use App\BedLog;
use App\BpjsLog;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Pegawai\Entities\Pegawai;
use PDF;
use Validator;
use App\HfisDokter;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use app\LogBridging;
use Modules\Registrasi\Entities\Registrasi;
use Monolog\Handler\IFTTTHandler;
use MercurySeries\Flashy\Flashy;
use Modules\Poli\Entities\Poli;
use Yajra\DataTables\DataTables;
use Modules\Pasien\Entities\Pasien;
use App\Masterobat;
use App\Logistik\LogistikBatch;
use App\Logistik\LogistikStock;
use App\Nomorrm;
use App\PasienBjb;
use App\PenerimaanDetailProduks;
use App\Penjualan;
use App\RegistrasiDummy;
use App\User;
use DB;
use Modules\Bed\Entities\Bed;
use Modules\Registrasi\Entities\Folio;

class BridgingReferensiController extends Controller {
	public function cekDoub(){
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		
		$results = Pasien::whereIn('id', function ( $query ) {
            $query->select('id')->from('pasiens')->groupBy('no_rm')->havingRaw('count(*) > 1');
        })->where('created_at', '>', date('Y-m-d', strtotime("-2 days")))->select('id','no_rm')->get();
		// dd($results);
		return view('bridgingsep.cekDoub',compact('results'));
        // dd($results);
	}
	function sinkronRm($id){
		$cek_pasien = Pasien::where('id',$id)->first();
		$no = Nomorrm::count() + config('app.no_rm');
		$rms = Nomorrm::create(['pasien_id' => $cek_pasien->id, 'no_rm' => $no]);
			// UPDATEPASIEN
			// $pasi = Pasien::where('id',$pasien->id)->first();
			// if(!empty($request['no_rm'])){
			// 	$pasi->no_rm = $request['no_rm'];
			// }else{
			// 	$pasi->no_rm = $rms->id;	
			// }
			// $pasi->save();
		// Nomorrm::create(['pasien_id' => $cek_pasien->id, 'no_rm' => $no]);
		$cek_pasien->no_rm = $rms->id;
		$cek_pasien->save();

		Flashy::success('RM Berhasil Diperbarui');
		return redirect()->back();
	}
	function sinkronIrj($reg_id){
		$reg= Registrasi::where('id',$reg_id)->first();
		$hist = HistorikunjunganIRJ::where('registrasi_id',$reg->id)->first();
		$pengunjung = Historipengunjung::where('registrasi_id',$reg->id)->first();
		if(!$hist){
			$h = new HistorikunjunganIRJ();
			$h->registrasi_id = $reg->id;
			$h->pasien_id = $reg->pasien_id;
			$h->poli_id = $reg->poli_id;
			$h->user = 'Admin';
			$h->dokter_id = $reg->dokter_id;
			$h->pengirim_rujukan = 1;
			$h->save();

		}

		if(!$pengunjung){
			$hp = new Historipengunjung();
			 $hp->registrasi_id = $reg->id;
			 $hp->pasien_id = $reg->pasien_id;
			 $hp->pengirim_rujukan = 1;
			 $hp->politipe = 'J';
			 $hp->status_pasien = 'LAMA';
			 $hp->save();
		}
		dd($reg_id." OKE");
	}
	function sinkronPasien($start,$end){
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		// DB::beginTransaction();
        // try{
			$pasienBjb = PasienBjb::skip($start)->take($end)->select('mr_no','mr_name',
			'mr_tempat_lahir','agama','telpon','pekerjaan','pendidikan','nama_penanggung',
			'mr_tgl_lahir','mr_jk','mr_gol_darah','rec_created','mr_alamat','nama_ayah',
			'nama_ibu','nik','no_penjamin','rt','rw','propinsi','kabupaten','kecamatan','kelurahan',
			'mr_id')->get();
			foreach($pasienBjb as $bjb){
				$pasien = Pasien::where('no_rm',$bjb->mr_no)->first();
				if(!$pasien){
					$new = new Pasien();
					$new->no_rm = @$bjb->mr_no;
					$new->nama = @$bjb->mr_name;
					$new->tmplahir = @$bjb->mr_tempat_lahir;
					$new->tgllahir = @$bjb->mr_tgl_lahir;
					$new->kelamin = @$bjb->mr_jk;
					$new->golda = @$bjb->mr_gol_darah;
					$new->alamat = @$bjb->mr_alamat;
					$new->tgldaftar = @date('Y-m-d',strtotime($bjb->rec_created));
					$new->agama = @$bjb->agama;
					$new->nohp = @$bjb->telpon;
					$new->notlp = @$bjb->telpon;
					$new->negara = 'Indonesian';
					$new->pekerjaan = @$bjb->pekerjaan;
					$new->pendidikan = @$bjb->pendidikan;
					$new->nama_keluarga = @$bjb->nama_penanggung;
					$new->nama_ayah = @$bjb->nama_ayah;
					$new->ibu_kandung = @$bjb->nama_ibu;
					$new->nik = @$bjb->nik;
					$new->no_jkn = @$bjb->no_penjamin;
					$new->no_jaminan = @$bjb->no_penjamin;
					// $new->nama_penjamin = @$bjb->nama_penjamin;
					$new->rt = @$bjb->rt;
					$new->rw = @$bjb->rw;
					$new->province_id = @$bjb->propinsi;
					$new->regency_id = @$bjb->kabupaten;
					$new->district_id = @$bjb->kecamatan;
					$new->village_id = @$bjb->kelurahan;
					$new->user_create = 'import_faiq';
					$new->mr_id = @$bjb->mr_id;
					$new->save();
				}
			}
			DB::commit();
			dd('TERSIMPAN');
		// }catch(Exception $e){
		// 	DB::rollback();
			
		// 	Flashy::info('Gagal Import data');
		// 	return redirect()->back();
		// }
	}

	function updateBed($gudang_id = null){
		$bed = Bed::all();
		foreach($bed as $b){
			$be = new Bed();
			$be->kelompokkelas_id = 2;
			$be->kelas_id = $b['kelas_id'];
			$be->kamar_id = $b['kamar_id'];
			$be->nama = $b['nama'];
			$be->kode = $b['kode'];
			$be->reserved = 'N';
			$be->virtual = $b['virtual'];
			$be->keterangan = $b['keterangan'];
			$be->save();
		}

		dd("oke");
	}

	function updatedatabase($gudang_id = null){
		//dd("Update Harga Obat JAdi 11%");
		//$pasien = Pasien::where('nik','LIKE','%e19%')->get();
		// $pasien = Pasien::all();
		// DB::beginTransaction();
		// foreach($pasien as $s){
		// 	$pp        = Pasien::where('id',$s->id)->first();
		// 	$pp->no_rm = substr($s->no_rm,1);
		// 	//$s->nik = str_replace('e19',"0",$s->nik);
		// 	 $pp->save();
		// }

		// DB::commit();
		// dd("done update no rm");

		//$masterobat = LogistikBatch::all();
		//foreach($masterobat as $s){
			//$logs = LogistikBatch::where('id',$s->id)->first();
			//$mas = MasterObat::where('nama',$s->nama_obat)->first();
			//if($mas){
			//	$logs->masterobat_id = $mas->id;
			//	$logs->stok = 1000;
		   	//	$logs->save();
			//}
			

			// $log = LogistikStock::where('logistik_batch_id',@$s->id)->first();
			// if($log){
			// 	@$log->masterobat_id =@$mas->id;
			// 	@$log->save();
			// }

			// $log = LogistikBatch::where('id',$s->id)->first();

			// $log = LogistikBatch::where('gudang_id',$gudang_id)->get();
			$log = LogistikBatch::all();
			foreach($log as $s){
				
				// $pen = PenerimaanDetailProduks::where('nama_produk',$s->nama_obat)->orderBy('id','DESC')->first();
				$pen = MasterObat::where('nama',$s->nama_obat)->orderBy('id','DESC')->first();
				if($pen){
					$logs = LogistikBatch::where('id',$s->id)->first();
					//$s->hargabeli        = $pen->harga;

					$persenjkn   = $logs->hargajual_jkn*11/100;
					$persenumum  = $logs->hargajual_umum*11/100;
					$persendinas = $logs->hargajual_dinas*11/100;

					$s->hargajual_jkn    = $persenjkn+$logs->hargajual_jkn;
					$s->hargajual_umum   = $persenumum+$logs->hargajual_umum;
					$s->hargajual_dinas  = $persendinas+$logs->hargajual_dinas;
					//$s->expireddate    = $pen->ed;
					$s->save();
				}
			}
		
		dd("Update Tarif Obat 11% done");
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

		date_default_timezone_set('Asia/Jakarta');
		$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
		$encodedSignature = base64_encode($signature);
		// $encodedSignature = \LZCompressor\LZString::compressToBase64($signature);;
		return array($ID, $t, $encodedSignature);
	}
	// V2
	function jadwalDokter(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/JadwalPraktekDokter/JnsKontrol/" . $request['jenisKontrol'] . "/KdPoli/" . $request['poli']."/TglRencanaKontrol/".valid_date($request['tgl']);
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t);
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


		$poli = Poli::all();
		return view('bridgingsep.jadwalDokter',compact('poli'));
	}
	public function sinkronFaktur($namatarif,$reg_id,$harga) {
		$folios = Folio::where('namatarif',$namatarif)->where('registrasi_id',$reg_id)->first();
		if($folios){
			$folios->total = $harga;
			$folios->catatan = 'sinkron-update';
			$folios->save();
			Flashy::success('Data Berhasil disinkronkan dengan faktur !');
			return redirect()->back();
		}else{
			$regis = Registrasi::where('id',$reg_id)->first();
			$penjualan = Penjualan::where('no_resep',$namatarif)->first();
			$get_gudang = User::where('id',$penjualan->user_id)->first();
			$folios = Folio::where('namatarif',$namatarif)->where('registrasi_id',$reg_id)->first();
			if(!$folios){
				$fol = new Folio();
				$fol->registrasi_id = @$reg_id;
				$fol->namatarif = @$namatarif;
				$fol->cara_bayar_id = @$regis->bayar;
				$fol->total = @$harga;
				$fol->jasa_racik = 0;
				$fol->gudang_id = @$get_gudang->gudang_id;
				$fol->tarif_id = 10000;
				$fol->lunas = 'N';
				$fol->catatan = 'sinkron';
				$fol->jenis = 'ORJ';
				$fol->pasien_id = @$regis->pasien_id;
				$fol->dokter_id = @$regis->dokter_id;
				$fol->poli_id = @$regis->poli_id;
				$fol->user_id = @$get_gudang->id;
				$fol->save();
				Flashy::success('Data Berhasil disinkronkan dengan faktur !');
				return redirect()->back();
			}
		}
		Flashy::success('Data Berhasil disinkronkan dengan faktur !');
		// Flashy::success('Gagal Sinkron');
		return redirect()->back();
	}
	// V2
	function jadwalDokterHfis(Request $request) {
		if($request->ajax()){ 
			// dd($request);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
			
			$completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $request['poli'] . "/tanggal/" . valid_date($request['tgl']);
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
			// dd($json);
			if($json[0]['metadata']['code'] == '201'){
				return false;
			}else{  
				foreach($json[1] as $v){
				// update nama pegawais dokter
				$cekDokter = Pegawai::where('kode_bpjs',$v['kodedokter'])->first();
				// dd( $v['namadokter']);
				if($cekDokter){
					// $cekDokter->nama = $v['namadokter'];
					$cekDokter->updated_at = date('Y-m-d');
					// dd($cekDokter);
					$cekDokter->save();
				}

				$cek = HfisDokter::where('kodedokter',$v['kodedokter'])->where('hari',$v['hari'])->where('kodesubspesialis',$v['kodesubspesialis'])->first();
				// dd($v['kodesubspesialis']);
				if(!$cek){
					$hfis                     = new HfisDokter();
					$hfis->kodesubspesialis   = $v['kodesubspesialis'];
					$hfis->hari   = $v['hari'];
					$hfis->libur   = $v['libur'];
					$hfis->namahari   = $v['namahari'];
					$hfis->jadwal   = $v['jadwal'];
					$hfis->jadwal_start   = explode('-',$v['jadwal'])[0];
					$hfis->jadwal_end   = explode('-',$v['jadwal'])[1];
					$hfis->namasubspesialis   = $v['namasubspesialis'];
					$hfis->namadokter   = $v['namadokter'];
					$hfis->kodepoli   = $v['kodepoli'];
					$hfis->namapoli   = $v['namapoli'];
					$hfis->kodedokter   = $v['kodedokter'];
					$hfis->save();
					
				}else{
					$cek->jadwal   = $v['jadwal'];
					$cek->jadwal_start   = explode('-',$v['jadwal'])[0];
					$cek->jadwal_end   = explode('-',$v['jadwal'])[1];
					$cek->updated_at   = date('Y-m-d H:i:s');
					$cek->save();
				}

				} 
			}
			// dd($sml);
			return response()->json($sml);
		}


		$poli = Poli::all();
		return view('bridgingsep.jadwalDokterHfis',compact('poli'));
	}
	// V2
	function editJadwalDokterHfis($kodedokter,$kodepoli,$kodesubspesialis) {
		$jadwal = HfisDokter::where('kodedokter',$kodedokter)->orderBy('hari','ASC')->get();
		// dd($dokter);
		return view('bridgingsep.updateJadwalDokterHfis',compact('jadwal'));
	}

	// V2
	function updateJadwalDokterHfis(Request $request) {
		// dd($request->all());
		// dd(date('N'));
		$ID = config('app.consid_antrean');
      date_default_timezone_set('Asia/Jakarta');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.secretkey_antrean');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
      
      $req   = '{
        "kodepoli": "'.$request['kodepoli'].'",
        "kodesubspesialis": "'.$request['kodesubspesialis'].'",
        "kodedokter": "'.$request['kodedokter'].'"
      }'; 
     
      // dd(json_decode($req));
      $jadwal = [];

      foreach($request['jadwal'] as $j){
		  if($j['buka'] || $j['tutup']){
			  $jadwal[] = [
				'hari'=>$j['hari'],
				'buka'=>$j['buka'],
				'tutup'=>$j['tutup'],
			  ];
		  }
      } 
      $req = json_decode($req, true); 
      $req['jadwal'] = $jadwal;
	//   dd($req);

      // return json_encode($req);
      $completeurl =config('app.antrean_url_web_service')."/jadwaldokter/updatejadwaldokter";;
      

      $session = curl_init($completeurl);
      // dd($session);
      $arrheader = array(
        'x-cons-id: ' . $ID,
        'x-timestamp: ' . $t,
        'x-signature: ' . $signature,
        'user_key:'.config('app.user_key_antrean'),
        'Content-Type: application/json',
      );
      // dd([$arrheader,$completeurl]);
      // dd(json_decode($body_prb));
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($req));
      curl_setopt($session, CURLOPT_POST, TRUE);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
      
      $response = curl_exec($session);
	  $sml = json_decode($response, true);
      if ($sml['metadata']['code'] == '200') {
		// $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
		// $res = json_decode($this->decompress($stringEncrypt),true);
		// // dd($res);
		// $find	= BpjsPRB::find($prb->id);
		// $find->update([
		// 	"no_srb"	=> $res['noSRB']
		// ]);

		// // END CALL API BPJS

		// DB::commit();
		// // dd($res);
		Flashy::success('Berhasil simpan, menunggu aproval dari BPJS atau otomatis approve jadwal dokter oleh sistem');
		return redirect('bridgingsep/jadwal-dokter-hfis');


		// return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
	} else {
		// dd($sml);
		Session::flash('error', $sml['metadata']['message']);
		// Flashy::error('Gagal Simpan,' .$sml['metadata']['message']);
		return redirect()->back();
	}
		// dd($dokter);
		return view('bridgingsep.updateJadwalDokterHfis',compact('jadwal'));
	}
	
	// V2
	function rujukanSpesialistik(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/Rujukan/ListSpesialistik/PPKRujukan/" . $request['nomor'] . "/TglRujukan/" .valid_date($request['tgl']);
 
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


		$poli = Poli::all();
		return view('bridgingsep.rujukanSpesialistik',compact('poli'));
	}
	
	
	// V2
	function jadwalSpesialistik(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/ListSpesialistik/JnsKontrol/" . $request['jenisKontrol'] . "/nomor/" . $request['nomor']."/TglRencanaKontrol/".valid_date($request['tgl']);
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.jadwalSpesialistik');
	}

	// V2
	function SepRkSpri(Request $req) {
		$no_spri = $req->input('no');
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/noSuratKontrol/" . $request['nomor'];
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.sepRkRi',compact('no_spri'));
	}
	// ICARE
	function icare(Request $req) {
		$no_spri = $req->input('no');
		$dokter = Pegawai::where('kategori_pegawai','1')->whereNotNull('kode_bpjs')->get();
		if($req->ajax()){
			// dd($req->all());
			$ID = config('app.icare_id');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.icare_key');
			date_default_timezone_set('UTC');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($request);
			$completeurl = config('app.icare_url_web_service') . "/api/rs/validate";
			$requests = '{
					  "param": "' . $request['nomor'] . '",
					  "kodedokter": "' . (int)$request['kode_dokter'] . '"
			 			}';


			$rrr = [
				'param'=>$request['nomor'],
				'kodedokter'=>(int)$request['kode_dokter']
			];
			// dd($requests);
			// dd([
			// 	'url'=>$completeurl,
			// 	'req' =>$requests
			// ]);
			// dd
			$session = curl_init($completeurl);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.icare_user_key'),
				'Content-Type: application/json',
			);
			// dd($arrheader);
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($rrr));
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			curl_getinfo($session, CURLINFO_HTTP_CODE);
			$response = curl_exec($session);
			// dd($response);
			// dd([
			// 	'url'=>$completeurl,
			// 	'credentials'=>$arrheader,
			// 	'request'=>json_decode($requests),
			// 	'respon_bpjs'=>$response,
			// ]);
			// if($response =='Authentication failed'){
			// 	$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			// 	return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			// }
			// $array[] = json_decode($response, true);
			// $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
			// $array[] = json_decode($this->decompress($stringEncrypt),true);

			// $sml = json_encode($array,JSON_PRETTY_PRINT); 
			// return response()->json($sml);
		}

		return view('bridgingsep.icare',compact('no_spri','dokter'));
	}

	// V2
	function sepRencanaKontrol(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/ListRencanaKontrol/tglAwal/" . valid_date($request['tga']) . "/tglAkhir/" . valid_date($request['tgb'])."/filter/".$request['jenisKontrol'];
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.sepRencanaKontrol');
	}
	// V2
	function SepRencanaKontrolNoKartu(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($request);
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/ListRencanaKontrol/Bulan/" . sprintf("%02s", $request['bln']) . "/Tahun/" . $request['thn']. "/Nokartu/" . $request['no_kartu']."/filter/".$request['jenisKontrol'];
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

		return view('bridgingsep.sepRencanaKontrolNoKartu');
	}
	// V2
	function hapusAntrol(Request $req) {
		if($req->ajax()){
			// dd($req->all());
			$data = RegistrasiDummy::where('jenisdaftar','fkrtl')->where('no_rujukan',$req->nomor)->where('tglperiksa',$req->tglperiksa)->first();
			if(!$data){
				return response()->json(['code'=>201,'message'=>'Data Tidak Ditemukan']);
			}else{
				return response()->json(['code'=>200,'message'=>$data]);
			}
		}

		return view('bridgingsep.hapusAntrol');
	}
	
	function sinkronTaskid(Request $req) {
		if($req->ajax()){

			// UPDATE TASK ID 4
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
			
			$updatewaktu33   = '{
				"kodebooking": "'.$req->nomor.'",
				"taskid": "3",
				"waktu": "'.randomWaktu1().'"
			}';
			$session33 = curl_init($completeurl);
			curl_setopt($session33, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session33, CURLOPT_POSTFIELDS, $updatewaktu33);
			curl_setopt($session33, CURLOPT_POST, TRUE);
			curl_setopt($session33, CURLOPT_RETURNTRANSFER, TRUE);
			
			// dd($re);
			$updatewaktu   = '{
				"kodebooking": "'.$req->nomor.'",
				"taskid": "4",
				"waktu": "'.randomWaktu2().'"
			}';
			$session2 = curl_init($completeurl);
			curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
			curl_setopt($session2, CURLOPT_POST, TRUE);
			curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			$re4 = curl_exec($session2);
			// dd($re4);
			// sleep(3);
			
			
			$updatewaktu5   = '{
				"kodebooking": "'.$req->nomor.'",
				"taskid": "5",
				"waktu": "'.randomwaktu3().'"
			}';
			$session5 = curl_init($completeurl);
			curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
			curl_setopt($session5, CURLOPT_POST, TRUE);
			curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
			curl_exec($session5);
			// sleep(3);
			
			// TASKID 6
			// $updatewaktu6   = '{
			// 	"kodebooking": "'.$req->nomor.'",
			// 	"taskid": "6",
			// 	"waktu": "'.round(microtime(true) * 1000).'"
			// }';
			// $session6 = curl_init($completeurl);
			// curl_setopt($session6, CURLOPT_HTTPHEADER, $arrheader);
			// curl_setopt($session6, CURLOPT_POSTFIELDS, $updatewaktu6);
			// curl_setopt($session6, CURLOPT_POST, TRUE);
			// curl_setopt($session6, CURLOPT_RETURNTRANSFER, TRUE);
			// curl_exec($session6);
			// sleep(3);
			
			// TASKID 7
			// $updatewaktu7   = '{
			// 	"kodebooking": "'.$req->nomor.'",
			// 	"taskid": "7",
			// 	"waktu": "'.round(microtime(true) * 1000).'"
			// }';
			// $session7 = curl_init($completeurl);
			// curl_setopt($session7, CURLOPT_HTTPHEADER, $arrheader);
			// curl_setopt($session7, CURLOPT_POSTFIELDS, $updatewaktu7);
			// curl_setopt($session7, CURLOPT_POST, TRUE);
			// curl_setopt($session7, CURLOPT_RETURNTRANSFER, TRUE);
			// curl_exec($session7);
			// sleep(3);

			return response()->json(['code'=>200,'message'=>'Taskid Tersinkron']);
		}

		return view('bridgingsep.sinkronTaskId');
	}
	
	function sinkronTaskidCron() {
			ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
			// dd(is_numeric('05072023JAN18'));
			$reg= Registrasi::whereNotNull('nomorantrian')
					->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
					->select('nomorantrian')
					->orderBy('id','DESC')
					->get();
			// dd($reg);
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
			if(count($reg) > 0){
				foreach ($reg as $key => $val){
					// $req->nomor = $val->nomorantrian;
					
					$updatewaktu   = '{
						"kodebooking": "'.$val->nomorantrian.'",
						"taskid": "4",
						"waktu": "'.round(microtime(true) * 1000).'"
					}';
					$session2 = curl_init($completeurl);
					curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
					curl_setopt($session2, CURLOPT_POST, TRUE);
					curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
					$e = curl_exec($session2);
					// sleep(180);
					
					$starttime = round(microtime(true) * 1000);
					$min=5;
					$max=10;
					$endtime = $starttime + rand($min,$max)*60*1000;
					$updatewaktu5   = '{
						"kodebooking": "'.$val->nomorantrian.'",
						"taskid": "5",
						"waktu": "'.$endtime.'"
					}';
					$session5 = curl_init($completeurl);
					curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
					curl_setopt($session5, CURLOPT_POST, TRUE);
					curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
					curl_exec($session5);
					// sleep(3);
					
				}

			}

			// return response()->json(['code'=>200,'message'=>'Taskid Tersinkron']);
		

		dd("OKE");
	}
	function sinkronTaskidCron4() {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		// dd(is_numeric('05072023JAN18'));
		$reg= Registrasi::whereNotNull('nomorantrian')
				->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
				->select('nomorantrian')
				->orderBy('id','DESC')
				->get();
		// dd($reg);
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
		if(count($reg) > 0){
			foreach ($reg as $key => $val){
				// $req->nomor = $val->nomorantrian;
				$updatewaktu2   = '{
					"kodebooking": "'.$val->nomorantrian.'",
					"taskid": "3",
					"waktu": "'.randomWaktu2().'"
				}';
				$session3 = curl_init($completeurl);
				curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
				curl_setopt($session3, CURLOPT_POST, TRUE);
				curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session3);


				$updatewaktu   = '{
					"kodebooking": "'.$val->nomorantrian.'",
					"taskid": "4",
					"waktu": "'.randomWaktu3().'"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$e = curl_exec($session2);
				// sleep(180); 
				
			}

		}

		// return response()->json(['code'=>200,'message'=>'Taskid Tersinkron']);
	

	dd("OKE");
}
	function sinkronTaskidCron6() {
		// dd("A");
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		// dd(is_numeric('05072023JAN18'));
		$penjualan = Penjualan::with('registrasi')->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])->get();
		// dd($penjualan);
		// $reg= Registrasi::whereNotNull('nomorantrian')
		// 		->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// 		->select('nomorantrian')
		// 		->orderBy('id','DESC')
		// 		->get();
		// dd($reg);
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
		if(count($penjualan) > 0){
			foreach ($penjualan as $key => $val){
				// dd($val->registrasi->nomorantrian);
				if($val->registrasi){
					if($val->registrasi->nomorantrian){
						// $req->nomor = $val->nomorantrian;
					$updatewaktu2   = '{
						"kodebooking": "'.@$val->registrasi->nomorantrian.'",
						"taskid": "6",
						"waktu": "'.randomWaktu1().'"
					}';
					$session3 = curl_init($completeurl);
					curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
					curl_setopt($session3, CURLOPT_POST, TRUE);
					curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
					curl_exec($session3);


					$updatewaktu   = '{
						"kodebooking": "'.@$val->registrasi->nomorantrian.'",
						"taskid": "7",
						"waktu": "'.randomWaktu3().'"
					}';
					$session2 = curl_init($completeurl);
					curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
					curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
					curl_setopt($session2, CURLOPT_POST, TRUE);
					curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
					$e = curl_exec($session2);
					// sleep(180); 
					}
				}

				
				
			}

		}

		// return response()->json(['code'=>200,'message'=>'Taskid Tersinkron']);
	

	dd("OKE");
}
	function sinkronTaskidCron5() {
		// dd("A");
		// dd(is_numeric('05072023JAN18'));
		// $penjualan = Penjualan::with('registrasi')->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])->get();
		// dd($penjualan);
		// $reg= Registrasi::whereNotNull('nomorantrian')
		// 		->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// 		->select('nomorantrian')
		// 		->orderBy('id','DESC')
		// 		->get();
		// dd($reg);
		$reg= Registrasi::whereNotNull('nomorantrian')
				->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
				->select('nomorantrian')
				->orderBy('id','DESC')
				->get();
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
		if(count($reg) > 0){
			foreach ($reg as $key => $val){
				// $req->nomor = $val->nomorantrian;
				$updatewaktu2   = '{
					"kodebooking": "'.$val->nomorantrian.'",
					"taskid": "5",
					"waktu": "'.randomWaktu2().'"
				}';
				$session3 = curl_init($completeurl);
				curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
				curl_setopt($session3, CURLOPT_POST, TRUE);
				curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session3);


				 
				
			}

		}

		// return response()->json(['code'=>200,'message'=>'Taskid Tersinkron']);
	

	dd("OKE");
}


	function sinkronTaskidTgl(Request $req) {
		if($req->ajax()){
			$reg= Registrasi::whereNotNull('nomorantrian')
					->whereBetween('created_at', [$req['tga'] . ' 00:00:00', $req['tgb'] . ' 23:59:59'])
					->select('nomorantrian')
					->get();
			
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
			foreach ($reg as $key => $val){
				$req->nomor = $val->nomorantrian;
				
				$updatewaktu   = '{
					"kodebooking": "'.$req->nomor.'",
					"taskid": "4",
					"waktu": "'.round(microtime(true) * 1000).'"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session2);
				// sleep(3);
				
				
				$updatewaktu5   = '{
					"kodebooking": "'.$req->nomor.'",
					"taskid": "5",
					"waktu": "'.round(microtime(true) * 1000).'"
				}';
				$session5 = curl_init($completeurl);
				curl_setopt($session5, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session5, CURLOPT_POSTFIELDS, $updatewaktu5);
				curl_setopt($session5, CURLOPT_POST, TRUE);
				curl_setopt($session5, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session5);
				// sleep(3);
				
				// TASKID 6
				$updatewaktu6   = '{
					"kodebooking": "'.$req->nomor.'",
					"taskid": "6",
					"waktu": "'.round(microtime(true) * 1000).'"
				}';
				$session6 = curl_init($completeurl);
				curl_setopt($session6, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session6, CURLOPT_POSTFIELDS, $updatewaktu6);
				curl_setopt($session6, CURLOPT_POST, TRUE);
				curl_setopt($session6, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session6);
				// sleep(3);
				
				// TASKID 7
				$updatewaktu7   = '{
					"kodebooking": "'.$req->nomor.'",
					"taskid": "7",
					"waktu": "'.round(microtime(true) * 1000).'"
				}';
				$session7 = curl_init($completeurl);
				curl_setopt($session7, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session7, CURLOPT_POSTFIELDS, $updatewaktu7);
				curl_setopt($session7, CURLOPT_POST, TRUE);
				curl_setopt($session7, CURLOPT_RETURNTRANSFER, TRUE);
				curl_exec($session7);
				// sleep(3);	
			}

			return response()->json(['code'=>200,'message'=>'Taskid Tersinkron']);
		}

		return view('bridgingsep.sinkronTaskIdTgl');
	}
	function tambahPasienAntrol(Request $req) {
		if($req->ajax()){
			// dd($req->all());
			$bjb = PasienBjb::where('mr_no',$req->nomor)->first();
			$pas = Pasien::where('no_rm',$req->nomor)->first();
			if($pas){
				return response()->json(['code'=>201,'message'=>'Pasien Sudah ada']);
			}
				if($bjb){
					$new = new Pasien();
					$new->no_rm = @$bjb->mr_no;
					$new->nama = @$bjb->mr_name;
					$new->tmplahir = @$bjb->mr_tempat_lahir;
					$new->tgllahir = @$bjb->mr_tgl_lahir;
					$new->kelamin = @$bjb->mr_jk;
					$new->golda = @$bjb->mr_gol_darah;
					$new->alamat = @$bjb->mr_alamat;
					$new->tgldaftar = @date('Y-m-d',strtotime($bjb->rec_created));
					$new->agama = @$bjb->agama;
					$new->nohp = @$bjb->telpon;
					$new->notlp = @$bjb->telpon;
					$new->negara = 'Indonesian';
					$new->pekerjaan = @$bjb->pekerjaan;
					$new->pendidikan = @$bjb->pendidikan;
					$new->nama_keluarga = @$bjb->nama_penanggung;
					$new->nama_ayah = @$bjb->nama_ayah;
					$new->ibu_kandung = @$bjb->nama_ibu;
					$new->nik = @$bjb->nik;
					$new->no_jkn = @$bjb->no_penjamin;
					$new->no_jaminan = @$bjb->no_penjamin;
					// $new->nama_penjamin = @$bjb->nama_penjamin;
					$new->rt = @$bjb->rt;
					$new->rw = @$bjb->rw;
					$new->province_id = @$bjb->propinsi;
					$new->regency_id = @$bjb->kabupaten;
					$new->district_id = @$bjb->kecamatan;
					$new->village_id = @$bjb->kelurahan;
					$new->user_create = 'sinkron_bjb';
					$new->mr_id = @$bjb->mr_id;
					$new->save();

					return response()->json(['code'=>200,'message'=>'Berhasil']);
				}else{
				return response()->json(['code'=>201,'message'=>'Data Tidak Ditemukan']);
				// return response()->json(['code'=>200,'message'=>$data]);
			}
		}

		return view('bridgingsep.tambahPasienAntrol');
	}

	function hapusAntrolRujukan($nomor,$tgl) {
		// dd($nomor,$tgl);
			// dd($req->all());
			$data = RegistrasiDummy::where('jenisdaftar','fkrtl')->where('no_rujukan',$nomor)->where('tglperiksa',$tgl)->first();
			$data->delete();
			Flashy::success('Berhasil Hapus');
			return redirect()->back();
	}
	function sepInternal(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/SEP/Internal/" . $request['nomor'];
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.sepInternal');
	}
	// V2
	function fingerprint(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/SEP/FingerPrint/List/Peserta/TglPelayanan/" .valid_date($request['tgl']);
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.fingerprint');
	}
	// V2
	function viewFingerprint(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/SEP/FingerPrint/Peserta/". $request['nomor']."/TglPelayanan/".valid_date($request['tgl']);
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.fingerprintView');
	}
	// V2
	function suplesi(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			 
			$completeurl = config('app.sep_url_web_service') . "/sep/JasaRaharja/Suplesi/" . $request['nomor']."/tglPelayanan/".valid_date($request['tgl']);
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.suplesi');
	}

	// V2
	function rujukanKhusus(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();
			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($request);
			 
			$completeurl = config('app.sep_url_web_service') . "/Rujukan/Khusus/List/Bulan/" .$request['bln']."/Tahun/".$request['thn'];
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.rujukanKhusus');
	}
	// V2
	function saranaRujukan(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();
			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($request);
			 
			$completeurl = config('app.sep_url_web_service') . "/Rujukan/ListSarana/PPKRujukan/" .$request['nomor'];
 
			$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

		return view('bridgingsep.saranaRujukan');
	}

	// EDIT SPRI V2
	public function editSpri(Request $request){
		// dd($request->all());
		if(empty($request->no_surat_kontrol)){
			return redirect('bridgingsep');
		}
		$data['dokter'] = Pegawai::all();
		$data['poli'] = Poli::all();
		// $no_surat = $request->no_surat_kontrol;
        // $poli_id = $request->poli;
        // $kode_dokter = $request->kode_dokter;
        // $tglRencanaKontrol  = $request->tglRencanaKontrol; 
		$data['request'] = $request; 
		return view('bridgingsep.editSpri',$data);
    }
	// UPDATE SPRI V2
	public function updateSpri(Request $request) {
		$re = \LZCompressor\LZString::decompressFromBase64($request->data);
		$request = array();
		parse_str($re, $request);
		// dd($request);
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		date_default_timezone_set('Asia/Jakarta');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		
		$req = '{
			"request": { 
						"noSPRI": "' . $request['no_surat_kontrol'] . '",
						"kodeDokter": "' . $request['kode_dokter'] . '",
						"poliKontrol": "' . $request['poli_id'] . '",
						"tglRencanaKontrol": "' . valid_date($request['tglRencanaKontrol']) . '",
						"user": "' . Auth::user()->name . '"
					} 
				}';
				// dd($req);
				$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/UpdateSPRI";
				
				$session = curl_init($completeurl);
				$arrheader = array(
					'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t, 
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($session, CURLOPT_POSTFIELDS, $req);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		
		$response = curl_exec($session);  
		$array[] = json_decode($response, true);
		// dd($array);
		// dd($array[0]['metaData']['code']);
		if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
		
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);
		if($array[0]['metaData']['code'] == 200){
			// dd($array);
			$spri = \App\SuratInap::where('no_spri',$array[1]['noSPRI'])->first();
			if(!empty($spri)){
				$spri->no_spri = $array[1]['noSPRI'];
				$spri->tgl_rencana_kontrol = $array[1]['tglRencanaKontrol'];
				$spri->poli = $request['poli_id'];
				$spri->poli_id = Poli::where('bpjs',$request['poli_id'])->first()->id;
				$spri->save();
			}
			 
		}
		$sml = json_encode($array,JSON_PRETTY_PRINT); 
		// dd($sml);
		return response()->json($sml);
	}

	// HAPUS SEP INTERNAL
	function hapusSepInternal(Request $req) { 
		if($req->ajax()){
			$ID = config('app.sep_id');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.sep_key');
			date_default_timezone_set('Asia/Jakarta');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

			$request = '{
				"request": {
					"t_sep": {
					"noSep": "'.$req->no_sep.'",
					"noSurat": "'.$req->no_surat.'",
					"tglRujukanInternal": "'.valid_date($req->tgl).'",
					"kdPoliTuj": "'.$req->poli.'",
					"user": "' . Auth::user()->name . '" 
					}
				} 
			}'; 
			// dd($request);
			$completeurl = config('app.sep_url_web_service') . "/SEP/Internal/delete";
				
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
			// $sml = json_decode($response, true);
			$array[] = json_decode($response, true);
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
			
			$array[] = json_decode($this->decompress($stringEncrypt),true);
			
			$sml = json_encode($array,JSON_PRETTY_PRINT);
			// dd($sml);
			// $json = json_encode($sml);
			return response()->json($sml);
		}

		//Save LogBridging
		// $p = new LogBridging();
		// $p->no_sep      = $req->no_sep;
		// $p->no_surat    = $req->no_surat;
		// $p->tgl_rujukan = valid_date($req->tgl);
		// $p->poli_tujuan = $req->poli;
		// $p->user_id     = Auth::user()->id;
		// $p->user        = Auth::user()->name;
		// $p->save();

		$poli = Poli::all();
		return view('bridgingsep.hapusSepInternal',compact('poli')); 
	}

	// V2
	function taskList(Request $req) {  
			// dd($request);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
			$completeurl = config('app.antrean_url_web_service') . "/antrean/getlisttask";
			$req = '{
				"kodebooking": "202112150002"  
					}';
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.user_key_antrean'),
				'Content-Type: application/json',
			);
			$session2 = curl_init($completeurl);
			curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session2, CURLOPT_POSTFIELDS, $req);
			curl_setopt($session2, CURLOPT_POST, TRUE);
			curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session2);
			// dd($response);
		
			// $sml = json_decode($response, true);
			$array[] = json_decode($response, true);
			$stringEncrypt = $this->stringDecrypt($ID.config('app.consid_antrean').$t,$array[0]['response']);
			
			$array[] = json_decode($this->decompress($stringEncrypt),true);
	
			$sml = json_encode($array,JSON_PRETTY_PRINT);
			dd($sml);
		}
	
		public function cekBooking($kode) {  
			// dd($kode);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
			$completeurl = config('app.antrean_url_web_service') . "antrean/pendaftaran/kodebooking/".$kode;
			// dd($completeurl);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.user_key_antrean'),
				'Content-Type: application/json',
			);
			$session2 = curl_init($completeurl);
			curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session2, CURLOPT_HTTPGET, 1);
			curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session2);
			// dd($response);
		
			// $sml = json_decode($response, true);
			$array[] = json_decode($response, true);
			// dd($array);
			$stringEncrypt = $this->stringDecrypt($ID.config('app.consid_antrean').$t,$array[0]['response']);
			
			$array[] = json_decode($this->decompress($stringEncrypt),true);
	
			$sml = json_encode($array,JSON_PRETTY_PRINT);
			dd($array);
		}

		// DASHBOARD ANTRIAN PER TANGGAL
	// V2
	function dashboardAntrianPerTanggal(Request $req) {
		if($req->ajax()){
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($request);
			$completeurl = config('app.antrean_url_web_service') . "dashboard/waktutunggu/tanggal/".valid_date($request['tgl'])."/waktu/".$request['waktu'];
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
			  curl_setopt($session, CURLOPT_HTTPGET, 1);
			  curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			  
			   
			  $response = curl_exec($session);
			// dd($response);
			$message = json_decode($response, true); 
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
			$array[] = json_decode($response, true);
			// dd($array);
			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// dd($sml);
			return response()->json($sml); 
		}

		return view('bridgingsep.dashboardPerTanggal');
	}
	
	// V2
	function logAntrian(Request $req) {
		if($req->ajax()){
			 $log = BpjsLog::whereBetween('created_at', [date('Y-m-d', strtotime($req->tgl_awal)) . ' 00:00:00', date('Y-m-d', strtotime($req->tgl_akhir)) . ' 23:59:59']);
			 if(!empty($req->status)){
				// if($req->status == '200'||$req->status =='208'){
				if($req->status == '200'){
					$log = $log->whereIn('status',[200,208]);
				}else{
					$log = $log->where('status',$req->status);
				}
			 }
			 $log = $log->orderBy('id','DESC')->get()->toJson();
			//  dd($log);
			// dd($sml);
			// dd(response()->json($log));
			return response()->json($log); 
			// return $log;
		}

		return view('bridgingsep.logAntrian');
	}

	function logAntrianPDF(Request $req) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		$log = BpjsLog::whereBetween('created_at', [date('Y-m-d', strtotime($req->tgl_awal)) . ' 00:00:00', date('Y-m-d', strtotime($req->tgl_akhir)) . ' 23:59:59']);
		if(!empty($req->status)){
		// if($req->status == '200'||$req->status =='208'){
		if($req->status == '200'){
			$log = $log->whereIn('status',[200,208]);
		}else{
			$log = $log->where('status',$req->status);
		}
		}
		$log = $log->orderBy('id','DESC')->get();
		$no = 1;

		if(!$log){
			Flashy::warning('Data Tidak Ditemukan');
			return redirect()->back();
		}

		$pdf = PDF::loadView('bridgingsep.logAntrianPDF', compact('log', 'no'));
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream('Log_Antrian_BPJS.pdf');
	}

	// V2
	function logBed(Request $req,$id =NULL) {
		if($req->ajax()){
			 $log = BedLog::whereBetween('created_at', [date('Y-m-d', strtotime($req->tgl_awal)) . ' 00:00:00', date('Y-m-d', strtotime($req->tgl_akhir)) . ' 23:59:59']);
			 
			 $log = $log->orderBy('id','DESC')->get()->toJson();
			//  dd($log);
			// dd($sml);
			// dd(response()->json($log));
			return response()->json($log); 
			// return $log;
		}

		if($id){
			$log = BedLog::find($id);
			// dd(json_decode($log->request,true));
			return view('bridgingsep.logBedDetail',compact('log'));	
		}

		return view('bridgingsep.logBed');
	}


	function dashboardAntrianPerBulan(Request $req) {
		if($req->ajax()){
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($request);
			$completeurl = config('app.antrean_url_web_service') . "dashboard/waktutunggu/bulan/".$request['bln']."/tahun/".$request['thn']."/waktu/".$request['waktu'];
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
			  curl_setopt($session, CURLOPT_HTTPGET, 1);
			  curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			  
			  $response = curl_exec($session);
			// dd($response);
			$message = json_decode($response, true); 
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
			$array[] = json_decode($response, true);
			// dd($array);
			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// dd($sml);
			return response()->json($sml); 
		}

		return view('bridgingsep.dashboardPerBulan');
	}

	// List task id
	function listTaskid(Request $req) {
		if($req->ajax()){
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			$req = '{"kodebooking": "'.$request['kodebooking'].'"}'; 
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
			  
			  $response = curl_exec($session);
			// dd($response);
			$message = json_decode($response, true); 
			$array[] = json_decode($response, true);
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
			if($message['metadata']['code'] == 200){
				$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
				$array[] = json_decode($this->decompress($stringEncrypt),true);
			}else{
				$array[] = json_decode($response,true);
			}
			// dd($array);
			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// dd($sml);
			return response()->json($sml); 
		}

		return view('bridgingsep.listTaskid');
	}


	// Batal antrol
	function batalAntrol(Request $req) {
		if($req->ajax()){
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			$req = '{"kodebooking": "'.$request['kodebooking'].'","keterangan": "'.$request['alasan'].'"}'; 
			// dd($req);
			$completeurl = config('app.antrean_url_web_service') . "antrean/batal";
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
			  
			  $response = curl_exec($session);
			// dd($response);
			$message = json_decode($response, true); 
			$array[] = json_decode($response, true);
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
			// dd($array);
			if($message['metadata']['code'] == 200){
				$json = [['metadata'=>['code'=>'200','message'=>'Berhasil Hapus']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
				// $stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
				// $array[] = json_decode($this->decompress($stringEncrypt),true);
			}else{
				$array[] = json_decode($response,true);
			}
			// dd($array);
			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// dd($sml);
			return response()->json($sml); 
		}

		return view('bridgingsep.batalAntrol');
	}

	// V2
	function antrianBelumDilayani(Request $req) {
		if($req->ajax()){
			// list($ID, $t, $signature) = $this->HashBPJS();

			// $re = \LZCompressor\LZString::decompressFromBase64($req->data);
			// $request = array();
			// parse_str($re, $request);
			// $ID = config('app.consid_antrean');
			// date_default_timezone_set('Asia/Jakarta');
			// $t = time();
			// $data = "$ID&$t";
			// $secretKey = config('app.secretkey_antrean');
			// $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
			// // dd($request);
			// $completeurl = config('app.antrean_url_web_service') . "antrean/pendaftaran/aktif";
			// // dd($completeurl);
			// $response = $this->xrequest($completeurl, $signature, $ID, $t);
			// // dd($response);
			// if($response =='Authentication failed'){
			// 	$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			// 	return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			// }
			// $array[] = json_decode($response, true);
			// $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
			// $array[] = json_decode($this->decompress($stringEncrypt),true);

			// $sml = json_encode($array,JSON_PRETTY_PRINT); 
			
			// // dd($sml);
			// return response()->json($sml);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			// dd($req);
			$completeurl = config('app.antrean_url_web_service') . "antrean/pendaftaran/aktif";
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
			//   curl_setopt($session, CURLOPT_POSTFIELDS, $req);
			  curl_setopt($session, CURLOPT_POST, FALSE);
			  curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			  
			  $response = curl_exec($session);
			// dd($response);
			$message = json_decode($response, true); 
			$array[] = json_decode($response, true);
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
			if($message['metadata']['code'] == 200){
				$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
				$array[] = json_decode($this->decompress($stringEncrypt),true);
			}else{
				$array[] = json_decode($response,true);
			}
			// dd($array);
			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// dd($sml);
			return response()->json($sml); 
		}

		return view('bridgingsep.antrianBelumDilayani');
	}
	
	// V2
	function antrianBelumDilayaniPoli(Request $req) {
		if($req->ajax()){
			list($ID, $t, $signature) = $this->HashBPJS();
			$re = \LZCompressor\LZString::decompressFromBase64($req->data);
			$request = array();
			parse_str($re, $request);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
			// dd($request);
			// $completeurl = config('app.antrean_url_web_service') . "antrean/pendaftaran/kodepoli/".$request['poli'].'/kodedokter/'.$request['kodedokter'].'/hari/'.$request['hari'].'/jampraktek/'.$request['jam_praktek'];
			$completeurl = config('app.antrean_url_web_service') . "antrean/pendaftaran/kodepoli/".$request['poli'].'/kodedokter/'.$request['kodedokter'].'/hari/'.convert_hari(ucfirst(strtolower($request['hari']))).'/jampraktek/'.$request['jam_praktek'];
			// dd($completeurl);
			$response = $this->xrequest($completeurl, $signature, $ID, $t);
			// dd($response->metadata);
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}

			
			$array[] = json_decode($response, true);
			if($array[0]['metadata']['code'] == '204'){
				return response()->json(json_encode($array,JSON_PRETTY_PRINT));	
			}
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
			$array[] = json_decode($this->decompress($stringEncrypt),true);

			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			
			
			return response()->json($sml);
		}
		$data['poli'] = Poli::all();
		return view('bridgingsep.antrianBelumDilayaniPoli',$data);
	}
	 
	function DashboardRateantrian(Request $req) {
		if($req->ajax()){
			 $log = BpjsLog::whereBetween('created_at', [valid_date($req->tglAwal). ' 00:00:00', valid_date($req->tglAkhir) . ' 23:59:59']);
			 if(!empty($req->status)){
				if($req->status == '200'||$req->status =='208'){
					$log = $log->whereIn('status',[200,208]);
				}else{
					$log = $log->where('status',$req->status);
				}
			 }

			 $registrasi = Registrasi::whereNotNull('no_sep')
				->where('status_reg', 'like', 'J%')
				->whereBetween('created_at', [
					valid_date($req->tglAwal) . ' 00:00:00', 
					valid_date($req->tglAkhir) . ' 23:59:59'
				])
				->get();

			 $totalSep = $registrasi->count();
        	 $totalKodeBooking = $log->count();

			 $rateAntrian = ($totalSep > 0) ? round(($totalKodeBooking / $totalSep) * 100, 2) : 0;

			 $data = [
				'total_sep' => $totalSep,
				'total_kode_booking' => $totalKodeBooking,
				'rate_antrian' => $rateAntrian . '%'
			 ];
			 return response()->json($data);
			//  $log = $log->orderBy('id','DESC')->get()->toJson();
			// return response()->json($log); 
		}

		return view('bridgingsep.dashboardAntrianrate');
	}
	 
}