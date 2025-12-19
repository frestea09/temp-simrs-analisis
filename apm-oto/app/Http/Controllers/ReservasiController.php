<?php

namespace App\Http\Controllers;

use App\Models\BpjsLog;
use App\Models\Antrian;
use App\Models\Poli;
use App\Models\Registrasi;
use App\Models\Carabayar;
use App\Models\Pegawai;
use App\Models\Jenisjkn;
use App\Models\HistoriStatus;
use App\Models\PengirimRujukan;
use PDF;
use App\Models\SepPoliLanjutan;
use App\Models\Pasien\Village;
use App\Models\Historipengunjung;
use App\Models\HistorikunjunganIRJ;
use App\Models\Pasien\Pasien;
use App\Models\Pasien\Pekerjaan;
use App\Models\Pasien\Pendidikan;
use App\Models\Pasien\Agama;
use App\Models\RegistrasiDummy;
use Illuminate\Http\Request;
use App\Models\AntrianPoli;
use App\Models\Nomorrm;
use App\Models\RencanaKontrol;
use App\Models\BiayaPemeriksaan;
use App\Models\Tarif;
use App\Models\FolioMulti;
use Response;
use Auth;
use Carbon\Carbon;
use DB;
use Session;

class ReservasiController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
        $data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		// $data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
        $data['poli'] = Poli::where('politype','J')->whereNotNull('bpjs')->get();
        $data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
        // $data['poli_bpjs'] =$this->poli();
        // dd($data['poli_bpjs']);
        return view('reservasi.index',$data);
    }
    public function indexLama()
    {
        $data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['carabayar'] = Carabayar::where('id','1')->pluck('carabayar', 'id');
        $data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		// $data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
        $data['poli'] = Poli::where('politype','J')->whereNotNull('bpjs')->get();
        $data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
        // $data['poli_bpjs'] =$this->poli();
        // dd($data['poli_bpjs']);
        return view('reservasi.indexLama',$data);
    }
 


	public function store(Request $request)
	{
		// dd($request->all());
		// CEK JADWAL POLI
		$dayname = date("D", strtotime($request->tanggalperiksa)); 
			$start = strtotime('now');
		$end =  strtotime('+90 days');
		
		if (  '$dayname' == 'Sun' )
		{
		$resp =  Response::json([
			"metadata" =>[
			"message"=>"Pendaftaran ke Poli Ini Sedang Tutup",
			"code"=>201
			]
			]);
		return $resp;
		} 
		$dokter = Pegawai::where('id',$request->kodedokter)->first();
		// CEK FORMAT TANGGAL
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$request->tanggalperiksa)) {
		$resp = Response::json([
			"metadata" => [
			"message" =>"Format Tanggal Periksa Tidak Sesuai, format yang benar adalah yyyy-mm-dd",
			"code"=> 201
			]
		]); 
		return $resp;
		} 
		
		
		if(is_numeric($request->kodepoli)){
			$cekpoli   = Poli::where('id', $request->kodepoli)->first();
		}else{
			$cekpoli   = Poli::where('bpjs', $request->kodepoli)->first();
		}
		$request->kodepoli = $cekpoli->bpjs;
		// dd($request->kodepoli);
		// CEK POLI
		
		if (empty($cekpoli)) { 
		$resp = Response::json([
			"metadata" => [
			"message" =>"Poli Tidak Ditemukan",
			"code"=> 201
			]
		]); 
		return $resp;
		}
		// dd($request->kodepoli);

		
		// CEK PASIEN SUDAH PERNAH DAFTAR APA BELUM
		// $cek = RegistrasiDummy::where('no_rm', $request->norm)
		// ->where('nik',$request->nik)
		// ->where('jenis_registrasi','pasien_baru')
		// ->first();
		// if (!$cek) {
		// $resp = [
		// 	'metadata' =>[
		// 	'message' =>"Data pasien ini tidak ditemukan, silahkan Melakukan Registrasi Pasien Baru",
		// 	'code'=>202
		// 	]
		// ]; 
		// return Response::json($resp);
		// } 
		// dd($request->all());
		// Validasi Nomor kartu antrian yang sama
		if (  
		RegistrasiDummy::where('nomorkartu', $request->nomorkartu)
		->where('no_rm', $request->norm)
		->where('status','pending')
		->where('jenis_registrasi','antrian')
		->where('kode_poli',$request->kodepoli)
		->where('tglperiksa', $request->tanggalperiksa)
		->first()){
			
		$resp = Response::json([
			"metadata" => [
			"message"=> "Nomor Antrean Hanya Dapat Diambil 1 Kali Pada Tanggal Yang Sama",
			"code"=> 201
			]
		]);
		return $resp;
		}

		DB::beginTransaction();
        try{
			date_default_timezone_set('Asia/Jakarta');
			$tStamp = date('d-m-Y');
			$signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));
	
			$cekantrian = RegistrasiDummy::where('jenisdaftar', 'fkrtl')->where('tglperiksa',$request->tanggalperiksa)->where('kode_poli', $request->kodepoli)->count();
			$hitung =  $cekantrian+1;
			$tanggalantri =  date("dmY", strtotime($request->tanggalperiksa));
			$nomorantri = $tanggalantri.''.$request->kodepoli.''.$hitung;
			// dd($nomorantri);

			if ($cekantrian == 0) {
				$buka_poli = Poli::where('bpjs',$request->kodepoli)->first();
				$convertestimasi = $request->tanggalperiksa.' '.$buka_poli->buka;
			} else {
				# code...
				$cek_estimasi = RegistrasiDummy::where('jenisdaftar', 'fkrtl')->where('tglperiksa',$request->tanggalperiksa)->where('kode_poli', $request->kodepoli)->latest('id')->first();
				$estimasi = strtotime("+15 minutes", strtotime($cek_estimasi->estimasidilayani));
				$convertestimasi = date("Y-m-d H:i:s", $estimasi);
				// return $estimasi*1000; die;
			}
			// dd($request->all());
			// JIKA PASIEN BARU NGECEK DI REGDUMMY
			if($request->status == 'BARU'){
				$pasien = RegistrasiDummy::where('nik',$request->nik)->where('jenis_registrasi','pasien_baru')->first();
				$noka = $pasien->nomorkartu;
			}else{
			// JIKA PASIEN LAMA NGECEK DI TABEL PASIEN
				$pasien = Pasien::where('nik',$request->nik)->first();
				if($pasien){
					if(isset($request->kelurahan_id)){
						$kel = Village::find($request->kelurahan_id);
						
						$pasien->province_id    = @$kel->kecamatan->kabupaten->provinsi->id;
						$pasien->regency_id     = @$kel->kecamatan->kabupaten->id;
						$pasien->district_id    = @$kel->kecamatan->id;
						$pasien->village_id     = @$kel->id;
						$pasien->save();
					}
	
					if(isset($request->nomorkartu)){
						$pasien->no_jkn         = @$request->nomorkartu;
						$pasien->save();
					}

				}
				

				
				if(!$pasien){
					$pasien = Pasien::where('no_rm',$request->norm)->first();
					$pasien->nik = $request->nik;
					if(isset($request->kelurahan_id)){
						$kel = Village::find($request->kelurahan_id);
						$pasien->province_id    = @$kel->kecamatan->kabupaten->provinsi->id;
						$pasien->regency_id     = @$kel->kecamatan->kabupaten->id;
						$pasien->district_id    = @$kel->kecamatan->id;
						$pasien->village_id     = @$kel->id;
					}
					@$pasien->no_jkn         = @$request->nomorkartu;
					$pasien->save();
					// dd($pasien);
				}
				$noka = $pasien->no_jkn;
			}

			$provinsi = $request->status == 'BARU' ? $pasien->kodeprop :$pasien->province_id;
			$regency  = $request->status == 'BARU' ? $pasien->regency_id :$pasien->regency_id;
			$district = $request->status == 'BARU' ? $pasien->district_id :$pasien->district_id;
			$village  = $request->status == 'BARU' ? $pasien->village_id :$pasien->village_id;
			$nohp  	  = $request->status == 'BARU' ? $pasien->no_hp :$pasien->nohp;
			// dd($pasien);

			$fkrtl   = New RegistrasiDummy();
			// data pasien
			$fkrtl->nomorkartu     = $noka;
			$fkrtl->nik            = $pasien->nik;
			$fkrtl->no_rm          = $pasien->no_rm;
			$fkrtl->nama           = $pasien->nama;
			$fkrtl->alamat         = $pasien->alamat;
			$fkrtl->no_hp          = $nohp;
			$fkrtl->kelamin        = $pasien->kelamin;
			$fkrtl->tmplahir       = $pasien->tmplahir;
			$fkrtl->tgllahir       = $pasien->tgllahir;
			$fkrtl->dokter_id      = @$request->kodedokter;
			// $fkrtl->nomorkk        = $pasien->nomorkk;
			$fkrtl->kodeprop       = $provinsi;
			$fkrtl->namaprop       = @$pasien->namaprop;
			$fkrtl->kodedati2      = $regency;
			$fkrtl->namadati2      = @$pasien->namadati2;
			$fkrtl->kodekec        = $district;
			$fkrtl->namakec        = @$pasien->namakec;
			$fkrtl->kodekel        = $village;
			$fkrtl->namakel        = @$pasien->namakel;
			$fkrtl->rw        	   = $pasien->rw;
			$fkrtl->rt        	   = $pasien->rt;

			// data antrian
			$fkrtl->tglperiksa     = $request->tanggalperiksa;
			$fkrtl->kode_poli      = $request->kodepoli;
			$fkrtl->no_rujukan     = $request->nomorreferensi;
			$fkrtl->jenisrequest   = $request->jenisrequest;
			$fkrtl->polieksekutif  = $request->polieksekutif;
			$fkrtl->kode_dokter    = @$dokter->bpjs;
			// $fkrtl->jampraktek     = $cekDokter->jadwal;
			$fkrtl->jampraktek     = $request->jam_praktek;
			$fkrtl->jeniskunjungan = $request->pengirim_rujukan;
			$fkrtl->cekin           = 'N';
			$fkrtl->jenis_registrasi    = 'antrian'; 
			$fkrtl->jenisdaftar    = 'fkrtl';
			$fkrtl->nomorantrian   = $nomorantri;
			$fkrtl->angkaantrian   = $hitung;
			$fkrtl->kode_cara_bayar = $request->bayar;
			$fkrtl->status = 'pending';
			$fkrtl->estimasidilayani = $convertestimasi;
			// dd($fkrtl);
			// return $fkrtl;die;
			$fkrtl->save();
			
			$poli   = SepPoliLanjutan::where('kode_poli', $request->kodepoli)->first();
			@$nama_poli = @$poli['nama_poli'];
			if(!$poli){
				$poli = Poli::where('bpjs',$request->kodepoli)->first();
				$nama_poli = $poli['nama'];
			}
			// $reg_dum  = RegistrasiDummy::where(['no_rm' => $request->nomorrm, 'tglperiksa' => $request->tanggalperiksa])->whereIn('kode_poli', $poli_id)->first();
			$reg_dum  = RegistrasiDummy::where('nomorantrian', $nomorantri)->first();
			// return $reg_dum; die;
			if (!empty($reg_dum)) {
				$kuotaJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota_online;
				$kuotaNonJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota;

				// if(is_numeric(substr($reg_dum->nomorantrian,-2))){
				// $angka = substr($reg_dum->nomorantrian,-2);
				// }else{
				// $angka = substr($reg_dum->nomorantrian,-1);
				// }
				$resp = [
				"response"=>[
					"id"=>$reg_dum->id,
					"nomorantrean" => $reg_dum->nomorantrian,
					"angkaantrean" => $reg_dum->angkaantrian,
					"kodebooking" => $reg_dum->kodebooking,
					"norm" => (string) $reg_dum->no_rm,
					"estimasidilayani" => (strtotime($reg_dum->estimasidilayani)*1000),
					"namapoli" => $nama_poli,
					"sisakuotajkn" => $kuotaJKN,
					"kuotajkn" => $kuotaJKN,
					"sisakuotanonjkn" => $kuotaNonJKN,
					"kuotanonjkn" => $kuotaNonJKN,
					"keterangan" => "Peserta harap 60 menit lebih awal guna pencatatan administrasi.",
					"namadokter" => baca_dokter_bpjs($reg_dum->kode_dokter)
				],
				"metadata"=> [
					"message"=>"Harap datang ke admisi untuk melengkapi data rekam medis",
					"code"=>200
				]
				];
			} else {
				$resp = [
				"metadata"=> [
					"message"=> "Data invalid !",
					"code"=> 201
				]
				];
			}
			DB::commit();
			return Response::json($resp);
		}catch(Exception $e){
			DB::rollback();
			echo ("GAGAL DAFTAR");
			// Flashy::info('Gagal Registrasi Data');
			return;
		} 

		
	}

	public function cetak($id_reservasi,$id_antrian = '')
	{
		$antrian = Antrian::where('id',$id_antrian)->first();		
		
		$data = RegistrasiDummy::where('id',$id_reservasi)->first();
		// JIKA CARA BAYAR UMUM MAKA CETAK ANTRIAN
		if($data->kode_cara_bayar == '2'){
			// $count = Antrian::where('tanggal', '=', date('Y-m-d'))->where('kelompok', "A")->count();
			// $nomor = $count + 1;
			// $suara = $nomor . '.mp3';

			// $data['nomor'] = $nomor;
			// $data['suara'] = $suara;
			// $data['status'] = '0';
			// $data['panggil'] = 0;
			// $data['tanggal'] = date('Y-m-d');
			// $data['kelompok'] = "A";
			// $juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
			// $data['sisa'] = $nomor - $juml_terpanggil;
			// Antrian::create($data);
		}
		$pasien = Pasien::where('no_rm',$data->no_rm)->first();
		$nama_pasien = @$data->nama ? @$data->nama : @$pasien->nama;
		// dd("id_reservasi");
		if($data){
			return view('reservasi.cetak', compact('data','nama_pasien','antrian'));
		}else{
			return redirect()->back();
		}
		
		
	}
	public function cetakBaru($id_reservasi,$no_rm = '')
	{
		
		$data = RegistrasiDummy::where('id',$id_reservasi)->first();
		$data_reg = Registrasi::where('id',$data->registrasi_id)->first();

		// JIKA CARA BAYAR UMUM MAKA CETAK ANTRIAN 
		$pasien = Pasien::where('no_rm',$no_rm)->first();
		$nama_pasien = @$data->nama ? @$data->nama : @$pasien->nama;
		// dd("id_reservasi");
		if($data){
			return view('reservasi.cetak_baru', compact('data','nama_pasien','data_reg'));
		}else{
			return redirect()->back();
		}
		
		
	}
	public function checkinUmum($id_reservasi,$no_rm = null)
	{
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->where('kelompok', "A")->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['bagian'] = 'bawah';
		$data['panggil'] = 0;
		$data['tanggal'] = date('Y-m-d');
		$data['kelompok'] = "A";
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		Antrian::create($data);
		return view('reservasi.cetak_antrian', $data)->with('loket', 2);
	}

	public function checkin($id_reservasi,$no_rm = null)
	{
		
		$data = RegistrasiDummy::where('id',$id_reservasi)->first();
		$dokters = Pegawai::where('kode_bpjs',$data->kode_dokter)->first();
		if(!$dokters){
			$dokters = Pegawai::where('id',$data->kode_dokter)->first();
		}
		// if(strlen($data->kode_dokter) <= 3){
		// 	$dokters = Pegawai::where('id',$data->kode_dokter)->first();
		// }else{
		// 	$dokters = Pegawai::where('kode_bpjs',$data->kode_dokter)->first();

		// }
		if(!$data->kode_dokter){
			$kode_dokter = @baca_dokter_kode($data->dokter_id);	
		}else{
			$kode_dokter = @$data->kode_dokter;
		}

		// dd($dokters);
		$arrheader = signature_bpjs();
			
		$estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
		// $dokter_hfis = jadwalDokterHfis($data->kode_poli,$data->tglperiksa);
		@$dokter_hfis = jadwalDokterHfis($data->kode_poli,$data->kode_dokter,$data->tglperiksa);
		// dd($dokter_hfis);
		if(@$dokter_hfis['status'] == 201){
			// Flashy::error(@$dokter_hfis['result']);
			return redirect()->back()->with('error', @$dokter_hfis['result']);
		}elseif($dokter_hfis['status'] == 200 && $dokter_hfis['result'] == 'Maaf Dokter Tidak Tersedia Pada Tanggal Periksa'){
			return redirect()->back()->with('error', @$dokter_hfis['result']);
		}
		DB::beginTransaction();
		if($dokter_hfis['result'] == 'Maaf Dokter Tidak Tersedia Pada Tanggal Periksa'){
			$jadwal = $data->jampraktek;
		}else{
			$jadwal = $dokter_hfis['result'];
		}
		if (str_contains($data->no_rujukan, 'K')) {
			$jenisKunj = '3';
		}else{
			$jenisKunj = '1';
		}

        try{
			$req   = '{
				"kodebooking": "'.(@$data->kodebooking ?: @$data->nomorantrian).'",
				"jenispasien": "JKN",
				"nomorkartu": "'.$data->nomorkartu.'",
				"nik": "'.$data->nik.'",
				"nohp": "'.$data->no_hp.'",
				"kodepoli": "'.$data->kode_poli.'",
				"namapoli": "'.baca_kode_poli($data->kode_poli).'", 
				"pasienbaru": "0",
				"norm": "'.$data->no_rm.'",
				"tanggalperiksa": "'.$data->tglperiksa.'", 
				"kodedokter": "'.$kode_dokter.'", 
				"namadokter": "'.@baca_dokter($data->dokter_id).'",
				"jampraktek": "'.@$jadwal.'",
				"jeniskunjungan": "'.$jenisKunj.'",
				"nomorreferensi": "'.$data->no_rujukan.'",
				"nomorantrean": "'.$data->nomorantrian.'",
				"angkaantrean": "'.$data->angkaantrian.'",
				"estimasidilayani": "'.$estimasi.'",
				"sisakuotajkn":"'.sisaKuotaJkn($data->kode_poli,$data->tglperiksa).'",
				"kuotajkn": "'.baca_data_poli($data->kode_poli)->kuota_online.'",
				"sisakuotanonjkn": "'.sisaKuotaNonJkn($data->kode_poli,$data->tglperiksa).'",
				"kuotanonjkn": "'.baca_data_poli($data->kode_poli)->kuota.'",
				"keterangan": "-"
			}';
			// dd($req);
			$completeurl = config('app.antrean_url_web_service')."antrean/add";
			$session = curl_init($completeurl); 
			
			// dd(json_decode($body_prb));
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_POSTFIELDS, $req);
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			@$jsonrespon = json_decode($response, true); 

			// $sml = json_decode($response, true);
			// dd($sml);
			// dd($kodeBooking);
			// if(isset($sml)){
			// 	if($sml['metadata']['code'] == 201){
			// 		return redirect()->back()->with('error', @$sml['metadata']['message']);
			// 		// return Response::json($sml);
			// 	}
			// }

			$updatewaktu   = '{
				"kodebooking": "'.$data->kodebooking.'",
				"taskid": 3,
				"waktu": "'.round(microtime(true) * 1000).'"
			}';
			// $completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			// $session2 = curl_init($completeurl2);
			// curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			// curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
			// curl_setopt($session2, CURLOPT_POST, TRUE);
			// curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			// $response2 = curl_exec($session2);
			// $sml = json_decode($response, true);

			$bpjslog = BpjsLog::where('nomorantrian',@$data->nomorantrian)->first();
			// if(isset($jsonrespon) && isset($sml)){
			if(isset($jsonrespon)){
				// if(@$jsonrespon['metadata']['code'] !== 208 && @$sml['metadata']['code'] !== 208 && @$sml['metadata']['message'] !== 'TaskId terakhir 5' || @$sml['metadata']['message'] !== 'TaskId=3 sudah ada'){
				if(@$jsonrespon['metadata']['code'] !== 208){
					if(!$bpjslog){
						$bpjslog = new BpjsLog();
					}
					$bpjslog->request = @$req;
					// if(isset($sml)){
					$bpjslog->status = @$jsonrespon['metadata']['code'];
					// }
					$bpjslog->response = @$response;
					// $bpjslog->response_taskid = @$response2;
					$bpjslog->url = url()->full();
					$bpjslog->user_id = '0';
					$bpjslog->penginput = 'KIOSK';
					$bpjslog->nomorantrian = @$data->nomorantrian;
					$bpjslog->save();
				}
			}
			// $sml2 = json_decode($response2, true);
			// if(isset($sml2)){
			// 	if($sml2['metadata']['code'] !== 200){
			// 		return Response::json($sml2);
			// 	}
			// }
			// dd([
			// 	'antrian' =>$sml,
			// 	'taskid' =>$sml2,
			// ]);

			 // Update Pasien
			 $polis	= Poli::where('bpjs',$data->kode_poli)->first();
			 $pasien = Pasien::where('no_rm',$no_rm)->first();
			//  dd($pasien);
			 
			 if (empty($pasien->no_rm)) {
				$rms = Nomorrm::create(['pasien_id' => @$pasien->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
				$pasien->no_rm = $rms->id;
				// sleep(rand(1,10));
				//  $no_rm = Nomorrm::count() + config('app.no_rm');
				//  Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no_rm]);
				//  $pasien->no_rm = sprintf("%06s", $no_rm);
			 }
			 $poli = Poli::find($polis->id);
			 
			 // if($find){
			//  $count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
			//  $nomor = $count + 1;
			$count = $data->angkaantrian;
			$nomor = $count;

			 $suara = $nomor . '.mp3';
			 if (!empty($data->tglperiksa)) {
				 $tgl = $data->tglperiksa;
			 }else{
				 $tgl = date('Y-m-d');
			 }
			 $antrian_poli = [
				 "nomor" => $nomor,
				 "suara" => $suara,
				 "status" => 0,
				 "panggil" => 1, 
				 "poli_id" => $poli->id,
				 "tanggal" => $tgl,
				 "loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
				 "kelompok" => $poli->kelompok
			 ];
			 
			//  if($data->nomorkartu && $data->no_rujukan){
			// 	$cek = $this->cekRujukan($data->no_rujukan);
			// 	if($cek[0]['metaData']['code'] !== '200'){
			// 		return response()->json(['status'=>$cek[0]['metaData']['code'],'result'=>$cek[0]['metaData']['message']]);
			// 	}else{
			// 		return response()->json(['status'=>$cek[0]['metaData']['code'],'result'=>$cek[0]['metaData']['message']]);
			// 	}

				
			//  }

			// if($poli->kode_loket == 'B' || $poli->kode_loket == 'A') {
			// 	$bagian = 'bawah';
			//  }else{
			// 	$bagian = 'atas';
			//  }

			// $count = Antrian::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kode_loket)->count();
			// $nomor = $count + 1;
			// $suara = $nomor . '.mp3';

			// $kode_loket = $polis->kode_loket ? $polis->kode_loket : 'B';
			
			// $dataantrian['nomor'] = $nomor;
			// $dataantrian['suara'] = $suara;
			// $dataantrian['status'] = '0';
			// $dataantrian['bagian'] = $bagian;
			// $dataantrian['poli_id'] = @$poli->id;
			// $dataantrian['panggil'] = 0;
			// $dataantrian['tanggal'] = date('Y-m-d');
			// $dataantrian['kelompok'] = $kode_loket;
			// $juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
			// $dataantrian['sisa'] = $nomor - $juml_terpanggil;
			// // dd($dataantrian);
			// $data_antrian = Antrian::create($dataantrian);
			// dd($data_antrian);
			
			 // GET ANTRIAN POLI ID 
			 
			$antrian = AntrianPoli::create($antrian_poli); 
			//  } 
			// dd($antrian);
			 // Save registrasi
			 $id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			//  dd($id);
			 $reg = new Registrasi();
			 $reg->input_from = 'registrasi';
			 $reg->antrian_poli_id = @$antrian->id;
			 $reg->pasien_id = $pasien->id;
			 $reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			 $reg->status = 2; //pasien lama
			 $reg->created_at = $tgl.' '.date('H:i:s');
			//  $reg->created_at = date('Y-m-d H:i:s'); //pasien lama
			 $reg->updated_at = $tgl.' '.date('H:i:s'); //pasien lama
			 $reg->nomorantrian = @$data->kodebooking;
			 $reg->nomorantrian_jkn = @$data->nomorantrian;
			 
			//  $reg->rujukan = $request['rujukan'];
			//  $reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
			//  $reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			//  $reg->hakkelas = $request['hakkelas'];
			//  $reg->nomorrujukan = $request['nomorrujukan'];
			//  $reg->tglrujukan = $request['tglrujukan'];
			//  $reg->kodeasal = $request['kodeasal'];
			//  $reg->tipe_layanan = $request['tipe_layanan'];
			//  $reg->catatan = $request['catatan'];
			
			 $reg->dokter_id = @$dokters->id;
			 $reg->poli_id = $poli->id;
			 $reg->bayar = $data->kode_cara_bayar;
			 $reg->no_jkn = $data->nomorkartu;
			 $reg->no_rujukan = @$data->no_rujukan;
			//  $reg->user_create = 0; //checkin 
			 $reg->jenis_pasien = $data->kode_cara_bayar;
			 $reg->posisiberkas_id = '2';
			 $reg->pengirim_rujukan = $data->jeniskunjungan;
			 $reg->status_reg = 'J1';
			 $reg->input_from = 'KIOSK Reservasi Lama';
			//  $reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			//  $reg->no_loket = session('no_loket');
			 $reg->antrian_poli = $this->antrianPoli($poli->id);
			//  if (!empty($request['tanggal'])) {
			// 	 $reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
			//  }
			 $reg->save();
			 
			 // if($polis->politype)
 
			 // Insert Histori
			 $history = new HistoriStatus();
			 $history->registrasi_id = $reg->id;
			 $history->status = 'J1';
			 @$history->created_at = $tgl.' '.date('H:i:s');
			//  @$history->updated_at = $tgl.' '.date('H:i:s');
			 $history->poli_id = $reg->poli_id;
			 $history->bed_id = null;

			//  $history->user_id = Auth::user()->id;
			 $history->pengirim_rujukan = $data->jeniskunjungan;
			 $history->save();

			 //Insert Histori Pengunjung
			 $hp = new Historipengunjung();
			 $hp->registrasi_id = $reg->id;
			 $hp->pasien_id = $pasien->id;
			 $hp->pengirim_rujukan = $data->jeniskunjungan;
			 $hp->politipe = 'J';
			 @$hp->created_at = $tgl.' '.date('H:i:s');
			//  @$hp->updated_at = $tgl.' '.date('H:i:s');
			 $hp->status_pasien = 'LAMA';
			//  $hp->user = Auth::user()->name;
			 $hp->save();

			 //Histori Kunjungan
			
			//IRJ
			$irj = new HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $poli->id;
			$irj->dokter_id = $data->dokter_id;
			// $irj->user = Auth::user()->name;
			$irj->created_at = $tgl.' '.date('H:i:s');
			// $irj->updated_at = $tgl.' '.date('H:i:s');
			$irj->pengirim_rujukan = $data->jeniskunjungan;
			$irj->save();

			$data->status = 'checkin';
			$data->registrasi_id = @$reg->id;
			$data->update();
			// dd("A");
			// Flashy::success('Berhasil Checkin');
			 DB::commit();
			//  return redirect('/reservasi/cetak/'.$data->id.'/'.$data_antrian->id);
			 return redirect('/reservasi/cetak/'.$data->id);
		}catch(Exception $e){
			DB::rollback();
			
			// Flashy::info('Gagal Registrasi Data');
			return redirect('/pendaftaran/regPendaftaran/' . session('reg_id'));
		} 
		// if($data){
		// 	return view('reservasi.cetak', compact('data'));
		// }else{
		// 	return redirect()->back();
		// }
		
		
	}
	
	

	public function checkinAjax($id_reservasi,$no_rm = null)
	{
		$data = RegistrasiDummy::where('id',$id_reservasi)->first();
		DB::beginTransaction();
        try{
			 // Update Pasien
			 $polis	= Poli::where('bpjs',$data->kode_poli)->first();
			 $pasien = Pasien::where('no_rm',$no_rm)->first();
			 
			 
			 if (empty($pasien->no_rm)) {
				//  sleep(rand(1,10));
				$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
				$pasien->no_rm = $rms->id;
				//  $no_rm = Nomorrm::count() + config('app.no_rm');
				//  Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no_rm]);
				//  $pasien->no_rm = sprintf("%06s", $no_rm);
			 }
			 $poli = Poli::find($polis->id);
			 
			 // if($find){
			 $count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
			 $nomor = $count + 1;
			 $suara = $nomor . '.mp3';
			 if (!empty($data->tglperiksa)) {
				 $tgl = $data->tglperiksa;
			 }else{
				 $tgl = date('Y-m-d');
			 }
			 $antrian_poli = [
				 "nomor" => $nomor,
				 "suara" => $suara,
				 "status" => 0,
				 "panggil" => 1, 
				 "poli_id" => $poli->id,
				 "tanggal" => $tgl,
				 "loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
				 "kelompok" => $poli->kelompok
			 ];
			 $data_rujukan = [];
			 if($data->nomorkartu && $data->no_rujukan){
				$cek = $this->cekRujukan($data->no_rujukan);
				if($cek[0]['metaData']['code'] !== '200'){
					return response()->json(['status'=>$cek[0]['metaData']['code'],'result'=>$cek[0]['metaData']['message'],'data'=>[]]);
				}else{
					 $data_rujukan = ['status'=>$cek[0]['metaData']['code'],'result'=>$cek[0]['metaData']['message'],'data'=>$cek[1]];
					//  $data_rujukan = json_decode($data_rujukan, true);
				}
			 }
			//  dd($data_rujukan);
			// dd("A");
			 // GET ANTRIAN POLI ID 
			 
			$antrian = AntrianPoli::create($antrian_poli); 
			//  } 
			 // Save registrasi
			 $id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			 
			 $reg = new Registrasi();
			 $reg->input_from = 'registrasi';
			 $reg->antrian_poli_id = @$antrian->id;
			 $reg->pasien_id = $pasien->id;
			 $reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			 $reg->status = 2; //pasien lama
			//  $reg->rujukan = $request['rujukan'];
			//  $reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			//  $reg->hakkelas = $request['hakkelas'];
			 $reg->nomorrujukan = @$data->no_rujukan;
			//  $reg->tglrujukan = $request['tglrujukan'];
			//  $reg->kodeasal = $request['kodeasal'];
			//  $reg->tipe_layanan = $request['tipe_layanan'];
			//  $reg->catatan = $request['catatan'];
			 $reg->dokter_id = $data->dokter_id;
			 $reg->poli_id = $poli->id;
			 $reg->bayar = $data->kode_cara_bayar;
			 $reg->no_jkn = $data->nomorkartu;
			//  $reg->user_create = 0; //checkin 
			 $reg->jenis_pasien = $data->kode_cara_bayar;
			 $reg->posisiberkas_id = '2';
			 $reg->pengirim_rujukan = $data->jeniskunjungan;
			 $reg->status_reg = 'J1';
			//  $reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			//  $reg->no_loket = session('no_loket');
			 $reg->antrian_poli = $this->antrianPoli($poli->id);
			//  if (!empty($request['tanggal'])) {
			// 	 $reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
			//  }
			 $reg->save();
			 
			 // Insert Histori
			 $history = new HistoriStatus();
			 $history->registrasi_id = $reg->id;
			 $history->status = 'J1';
			 $history->poli_id = $reg->poli_id;
			 $history->bed_id = null;
			 $history->pengirim_rujukan = $data->jeniskunjungan;
			 $history->save();

			 //Insert Histori Pengunjung
			 $hp = new Historipengunjung();
			 $hp->registrasi_id = $reg->id;
			 $hp->pasien_id = $pasien->id;
			 $hp->pengirim_rujukan = $data->jeniskunjungan;
			 $hp->politipe = 'J';
			 $hp->status_pasien = 'LAMA';
			 $hp->save();

			 //Histori Kunjungan
			
			//IRJ
			$irj = new HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $poli->id;
			$irj->dokter_id = $data->dokter_id;
			$irj->pengirim_rujukan = $data->jeniskunjungan;
			$irj->save();

			$data->status = 'checkin';
			$data->registrasi_id = @$reg->id;
			$data->update();
			
			 DB::commit();
			 return response()->json(['status'=>200,'result'=>'Registrasi Berhasil','data'=>[]]);
			//  return redirect('/reservasi/cetak/'.$data->id);
		}catch(Exception $e){
			DB::rollback();
			return redirect('/pendaftaran/regPendaftaran/' . session('reg_id'));
		} 
		
	}

	// CEK RESERVASI
	public function cek()
    {
		// Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
        $data['poli'] = Poli::all();
        return view('reservasi.cek-reservasi',$data);
    }
	public function cekKontrol()
    {
		// Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
        $data['poli'] = Poli::all();
        return view('reservasi.cek-reservasi-kontrol',$data);
    }
	public function cekTesting()
    {
		// Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
        $data['poli'] = Poli::all();
        return view('reservasi.cek-reservasi-testing',$data);
    }
	public function cekUmum()
    {
		// Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
        $data['poli'] = Poli::all();
        return view('reservasi.cek-reservasi-umum',$data);
    }

	// CEK RESERVASI BARU
	public function cekBaru()
    {
		// Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
        $data['poli'] = Poli::all();
        return view('reservasi.cek-reservasi-baru',$data);
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
		// if(@$nomorkartu && @$tglperiksa){
		// 	$cek_finger = $this->cekFinger(@$nomorkartu,@$tglperiksa);
		// 	$data['kode_finger'] = @$cek_finger[1]['kode'];
		// 	$data['status_finger'] = @$cek_finger[1]['status'];
		// }
		// dd($cek_finger);
		return view('reservasi.cetak_sep_new', $data);
		// $pdf = PDF::loadView('reservasi.cetak_sep_new', $data);
		// $customPaper = array(0, 0, 793.7007874, 340);
		// $customPaper = array(0, 0, 793.7007874, 420);
		// $pdf->setPaper($customPaper);
		// return $pdf->download('lab.pdf');
		// return $pdf->stream();
	}

	

	// CEK SEP
	public function cekSep($id,$rm=null)
    {
		$data['data'] = RegistrasiDummy::find($id);
		$data['pasien'] = Pasien::where('no_rm',$data['data']->no_rm)->first();
        
		$data['rujukan'] = [];
		if($data['data']->nomorkartu && $data['data']->no_rujukan){
			$cek = $this->cekRujukan($data['data']->no_rujukan);
			
			if($cek[0]['metaData']['code'] !== '200'){
				Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
				return redirect('reservasi/cek');
				// return response()->json(['status'=>$cek[0]['metaData']['code'],'result'=>$cek[0]['metaData']['message'],'data'=>[]]);
			}else{
				$data['rujukan'] = $cek[1];
				//  $data_rujukan = json_decode($data_rujukan, true);
			}
		}

		$pol = Poli::where('bpjs',$data['rujukan']['rujukan']['poliRujukan']['kode'])->first();
		$dokter_id = [];

		// foreach($pol->dokter_id as $pol) {
        //     $dokter_id[] = $pol;
        // }

		$dokter_id = explode(",",$pol->dokter_id);
		$data['dokter'] = Pegawai::whereIn('id',$dokter_id)->get();
		$data['dokter_bpjs'] = Pegawai::whereIn('id',$dokter_id)->get();

        return view('reservasi.cek-sep',$data);
    }
	public function responseKunjungan($id,$rm=null)
    {
		$data['data'] = RegistrasiDummy::find($id);
		$data['pasien'] = Pasien::where('no_rm',$data['data']->no_rm)->first();
        
		$data['rujukan'] = [];
		if($data['data']->nomorkartu && $data['data']->no_rujukan){
			$cek = $this->cekRujukan($data['data']->no_rujukan);
			
			if($cek[0]['metaData']['code'] !== '200'){
				Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
				return redirect('reservasi/cek');
				// return response()->json(['status'=>$cek[0]['metaData']['code'],'result'=>$cek[0]['metaData']['message'],'data'=>[]]);
			}else{
				$data['rujukan'] = $cek[1];
				//  $data_rujukan = json_decode($data_rujukan, true);
			}
		}
		dd($data['rujukan']);

		$pol = Poli::where('bpjs',$data['rujukan']['rujukan']['poliRujukan']['kode'])->first();
		$dokter_id = [];

		// foreach($pol->dokter_id as $pol) {
        //     $dokter_id[] = $pol;
        // }

		$dokter_id = explode(",",$pol->dokter_id);
		$data['dokter'] = Pegawai::whereIn('id',$dokter_id)->get();
		$data['dokter_bpjs'] = Pegawai::whereIn('id',$dokter_id)->get();

        return view('reservasi.cek-sep',$data);
    }

	public function antrianPoli($poli_id = NULL) {
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', date('Y-m-d') . '%')->count();
		return $poli + 1;
	}

	public function cekReservasi(Request $request)
    {
		// dd(date('dmY').strtoupper($request->keyword));

		$panjang = strlen($request->keyword);

		$data = RegistrasiDummy::where('jenis_registrasi', 'antrian')
		->where('jenisdaftar', 'fkrtl')
		->where('tglperiksa', date('Y-m-d'));

		if($panjang > '200'){
			$base = base64_decode($request->keyword);
			$data_json = json_decode($base,true);
			$kodebooking = $data_json['kodeBooking'];
			$data = $data->where('kodebooking', $kodebooking);
		}elseif (strpos($request->keyword, '-') !== false) {
			$kodebooking = $request->keyword;
			$data = $data->where('nomorantrian', $kodebooking);
		}else{
			$kodebooking = date('dmY').strtoupper($request->keyword);
			$data = $data->where('nomorantrian', $kodebooking);
		}
		// dd($data_json);
		// $data = RegistrasiDummy::where([
		// 		['jenis_registrasi','=','antrian'],
		// 		['jenisdaftar','=','fkrtl'],
		// 		['tglperiksa','=',date('Y-m-d')],
		// 		['nomorantrian','=',$kodebooking],
		// 		// ['status','=','pending']
		// ]);
		
		// ->where(function ($query) use ($kodebooking) {
		// 	$query->where('nomorantrian', $kodebooking)
		// 		->orWhere('kodebooking', $kodebooking);
		// })
		// ->where('status', 'pending') // aktifkan kalau memang perlu
		
		if($request->from){
			$data = $data->whereNotNull('no_rm');
		}
			
		$data = $data->first();
		// dd($data);
		
		
		if(!$data){
			return response()->json(['status'=>500,'result'=>'Reservasi Tidak Ditemukan, atau Cek-in tidak sesuai tanggal periksa']);
		}
		$pasien = Pasien::where('no_rm',$data->no_rm)->first();
		$nama_pasien = $data ? @$data->nama : $pasien->nama;
		
		if(!$data->nama){
			@$data['cekrujukan'] = $this->cekRujukan($data->no_rujukan);
			$nama_pasien = @$data['cekrujukan']['1']['rujukan']['peserta']['nama'];
		}


		if($data){

			$kode_finger = '1';
			$status_finger = 'OK';
			$cek_finger = [];

			if($data->nomorkartu && $data->no_rujukan){
				$cek_status_finger = DB::table('configs')->where('status_finger_kiosk','1')->first();
				if($cek_status_finger){
					// if($data->kode_poli == 'IRM' || $data->kode_poli == 'MAT' ||$data->kode_poli == 'JAN'){
						$cek_finger = $this->cekFinger($data->nomorkartu,$data->tglperiksa);
						$kode_finger = @$cek_finger[1]['kode'];
						$status_finger = @$cek_finger[1]['status'];
	
					// }
					
				}
			}
			// dd($cek_finger)
			
			$cek_pasien_lama = Pasien::where('no_rm',$data->no_rm)->first();
			if(!$cek_pasien_lama){
				return response()->json(['status'=>500,'result'=>'Reservasi Pasien baru harap mendatangi admisi, untuk proses registrasi awal']);
			}
			$estimasi = Carbon::parse($data->estimasidilayani);
			$sekarang = Carbon::now();

			// waktu 60 menit sebelum estimasi
			$batas_cekin = $estimasi->copy()->subMinutes(60);
			$jam_bisa_dilayani = $batas_cekin->format('H:i');
			// jika sekarang >= (estimasi - 60 menit), maka bisa cekin

			if(status_consid('lock_apm')){
				$cekin = $sekarang->greaterThanOrEqualTo($batas_cekin);
			}else{
				$cekin = true;
			}

			$data['tglperiksa'] = valid_date($data->tglperiksa);
			$datas = [
				'nomorantrian' => $data->nomorantrian,
				'nama' => $nama_pasien,
				'no_hp' => $data->no_hp,
				'no_rujukan' => $data->no_rujukan,
				'nik' => substr($data->nik,0,7).'*********',
				'tglperiksa' => $data->tglperiksa,
				'status' => $data->status,
				'id' => $data->id,
				'no_rm' => $data->no_rm,
				'poli' => strtoupper(baca_kode_poli($data->kode_poli)),
				'fingerprint'=>[
					'kode' => @$kode_finger,
					'status' => @$status_finger,
				],
				'cekin' => @$cekin, // ← tambahan status cekin true/false
				'jam_dilayani' => @$jam_bisa_dilayani, // ⏰ waktu mulai bisa cekin
				
			];
			// dd($datas);
			return response()->json(['status'=>200,'result'=> $datas]);
		}else{
			return response()->json(['status'=>500,'result'=>'Data Reservasi Tidak Ditemukan']);
		}
        
    } 
	public function formCekinSep($id,$no_rm = null){

		$data['regdum'] = RegistrasiDummy::where('id',$id)->first();
		$data['data'] = $this->cekRujukan($data['regdum']->no_rujukan);
		// dd($data['data']);
		if($data['data'][1] == null){
			return redirect('/reservasi/cek')->with('error', 'Data Rujukan Tidak Ditemukan.');
		}
		$data['error'] = '';
		// JIKA KODE 202 / RUJUKAN TIDAK BERLAKU 
		if(isset($data['data'][0]['metaData']['code'])){
			if($data['data'][0]['metaData']['code'] == "202"){
				@$data['error'] = @$data['data'][0]['metaData']['message'];
			}
		}
		if($data['error']){
			return redirect('/reservasi/cek')->with('error', @$data['error']);
		}

		// dd($data['data']);
		if(!$data['data']){
			return redirect('/reservasi/cek')->with('error', 'Web Service BPJS sedang gangguan, coba beberapa waktu lagi');
		}
		// dd($data['data']);
		// dd($data['data']);
		$kodePoli = $data['data'][1]['rujukan']['poliRujukan']['kode'];
		$poli = Poli::where('bpjs',$kodePoli)->first();
		$dokter_id = explode(",", @$poli->dokter_id);
		// $data['dokter'] = Pegawai::whereIn('id',$dokter_id)->whereNotNull('kode_bpjs')->get();
		$data['dokter_hfis'] = $this->dokterHfis($poli->bpjs);
		if($data['dokter_hfis']){
			$data['kode_hfis'] = $data['dokter_hfis'][0]['metadata']['code'];
		}else{
			$data['kode_hfis'] = 201;
		}

		// dd($data['kode_hfis']);
		if($data){
			return view('reservasi.form-cekin-sep',$data);
		}else{
			return redirect('/reservasi/cek');
		}
	}
	public function formCekinSepKontrol($id,$no_rm = null){

		$data['regdum'] = RegistrasiDummy::where('id',$id)->first();
		$data['data'] = $this->cekRujukanSKDP($data['regdum']->no_rujukan);
		
		
		if(!$data['data']){
			return redirect()->back()->with('error', 'Jaringan bermasalah, tidak dapat terhubung ke BPJS');;
		}
		if($data['data'][1] == null){
			return redirect('/reservasi/cek-kontrol')->with('error', @$data['data'][0]['metaData']['message']);
		}
		// dd($data['data']);
		$data['dataSkdp'] = $data['data'][1];
		
		$data['no_surkon'] = $data['regdum']->no_rujukan;
		$data['error'] = '';
		// CARI RUJUKAN DARI SEP
		$data['surkon'] = RencanaKontrol::where('no_surat_kontrol', $data['no_surkon'])->first();

		if (!$data['surkon']) {
			return redirect()->back()->with('error', 'Surat kontrol tidak ditemukan.');
		}
		$tglKontrolRaw = $data['surkon']->tgl_rencana_kontrol;
		// Cek jika null
		if (empty($tglKontrolRaw)) {
			return redirect()->back()->with('error', 'Tanggal Kontrol tidak ditemukan. Silahkan menghubungi bagian Admisi.');
		}
		$tglKontrol = \Carbon\Carbon::parse($tglKontrolRaw);
		$hariIni = \Carbon\Carbon::today();

		// if ($tglKontrol->gt($hariIni)) {
		// 	return redirect()->back()->with('error', 'Tanggal Kontrol tidak sesuai dengan Surat Kontrol. Silahkan menghubungi bagian Admisi.');
		// }
		@$data['data'] = $this->cekRujukan($data['dataSkdp']['sep']['provPerujuk']['noRujukan']);
		// dd(($data['dataSkdp']));
		
		// JIKA KODE 202 / RUJUKAN TIDAK BERLAKU
		if(isset($data['data'][0]['metaData']['code'])){
			if($data['data'][0]['metaData']['code'] == "202"){
				@$data['error'] = @$data['data'][0]['metaData']['message'];
			}
		}


		if(@$data['data'][0]['metaData']['message'] == 'Data Rujukan Tidak Ditemukan.'){
			@$data['data'][1] = $data['dataSkdp'];
		}

		// dd($data['data']);
		// dd($data['dataSkdp']);
		if($data['error']){
			return redirect('/reservasi/cek-kontrol')->with('error', @$data['error']);
		}
		
		// dd($data['data']);
		if(!$data['data']){
			return redirect('/reservasi/cek-kontrol')->with('error', 'Web Service BPJS sedang gangguan, coba beberapa waktu lagi');
		}
		
		// dd($data['data']);
		// dd($data['data']);
		$kodePoli = $data['regdum']->kode_poli;
		@$bulan = @date('m');
		@$tahun = @date('Y');
		// dd($bulan);
		// @$data['no_surkon'] = $this->cekNoSurkon($data['regdum']->nomorkartu,$bulan,$tahun);
		
		$poli = Poli::where('bpjs',$kodePoli)->first();
		$dokter_id = explode(",", @$poli->dokter_id);
		// $data['dokter'] = Pegawai::whereIn('id',$dokter_id)->whereNotNull('kode_bpjs')->get();
		$data['dokter_hfis'] = $this->dokterHfis($poli->bpjs);
		if($data['dokter_hfis']){
			$data['kode_hfis'] = $data['dokter_hfis'][0]['metadata']['code'];
		}else{
			$data['kode_hfis'] = 201;
		}
		// dd($data);
		// dd($data['kode_hfis']);
		if($data){
			return view('reservasi.form-cekin-sep-kontrol',$data);
		}else{
			return redirect('/reservasi/cek-kontrol');
		}
	}
	public function formCekinSepKontrolOLD($id,$no_rm = null){

		$data['regdum'] = RegistrasiDummy::where('id',$id)->first();
		$data['data'] = $this->cekRujukanSKDP($data['regdum']->no_rujukan);
		
		
		if(!$data['data']){
			return redirect()->back()->with('error', 'Jaringan bermasalah, tidak dapat terhubung ke BPJS');;
		}
		if($data['data'][1] == null){
			return redirect('/reservasi/cek-kontrol')->with('error', @$data['data'][0]['metaData']['message']);
		}
		// dd($data['data']);
		$data['dataSkdp'] = $data['data'][1];
		
		$data['no_surkon'] = $data['regdum']->no_rujukan;
		$data['error'] = '';
		// CARI RUJUKAN DARI SEP
		$data['surkon'] = RencanaKontrol::where('no_surat_kontrol', $data['no_surkon'])->first();

		if (!$data['surkon']) {
			return redirect()->back()->with('error', 'Surat kontrol tidak ditemukan.');
		}
		$tglKontrolRaw = $data['surkon']->tgl_rencana_kontrol;
		// Cek jika null
		if (empty($tglKontrolRaw)) {
			return redirect()->back()->with('error', 'Tanggal Kontrol tidak ditemukan. Silahkan menghubungi bagian Admisi.');
		}
		$tglKontrol = \Carbon\Carbon::parse($tglKontrolRaw);
		$hariIni = \Carbon\Carbon::today();

		if ($tglKontrol->gt($hariIni)) {
			return redirect()->back()->with('error', 'Tanggal Kontrol tidak sesuai dengan Surat Kontrol. Silahkan menghubungi bagian Admisi.');
		}
		// dd(($data['dataSkdp']));
		@$data['data'] = $this->cekRujukan($data['dataSkdp']['sep']['provPerujuk']['noRujukan']);
		
		// JIKA KODE 202 / RUJUKAN TIDAK BERLAKU
		if(isset($data['data'][0]['metaData']['code'])){
			if($data['data'][0]['metaData']['code'] == "202"){
				@$data['error'] = @$data['data'][0]['metaData']['message'];
			}
		}


		if(@$data['data'][0]['metaData']['message'] == 'Data Rujukan Tidak Ditemukan.'){
			@$data['data'][1] = $data['dataSkdp'];
		}

		// dd($data['data']);
		// dd($data['dataSkdp']);
		if($data['error']){
			return redirect('/reservasi/cek-kontrol')->with('error', @$data['error']);
		}
		
		// dd($data['data']);
		if(!$data['data']){
			return redirect('/reservasi/cek-kontrol')->with('error', 'Web Service BPJS sedang gangguan, coba beberapa waktu lagi');
		}
		
		// dd($data['data']);
		// dd($data['data']);
		$kodePoli = $data['regdum']->kode_poli;
		@$bulan = @date('m');
		@$tahun = @date('Y');
		// dd($bulan);
		// @$data['no_surkon'] = $this->cekNoSurkon($data['regdum']->nomorkartu,$bulan,$tahun);
		
		$poli = Poli::where('bpjs',$kodePoli)->first();
		$dokter_id = explode(",", @$poli->dokter_id);
		// $data['dokter'] = Pegawai::whereIn('id',$dokter_id)->whereNotNull('kode_bpjs')->get();
		$data['dokter_hfis'] = $this->dokterHfis($poli->bpjs);
		if($data['dokter_hfis']){
			$data['kode_hfis'] = $data['dokter_hfis'][0]['metadata']['code'];
		}else{
			$data['kode_hfis'] = 201;
		}
		// dd($data);
		// dd($data['kode_hfis']);
		if($data){
			return view('reservasi.form-cekin-sep-kontrol',$data);
		}else{
			return redirect('/reservasi/cek-kontrol');
		}
	}
	 
	public function storeCekinSep(Request $request){
		DB::beginTransaction();
    	try{	

			// dd($request->all());
		$dokter = explode("_",$request->dokter_id);
		// dd($dokter);
		$cekantrian = RegistrasiDummy::where('jenisdaftar', 'fkrtl')->where('tglperiksa',date('Y-m-d'))->where('kode_poli', $dokter[3])->count();
		// dd($request->id_reg_dum);
		$get_data = RegistrasiDummy::where('id',$request->id_reg_dum)->where('tglperiksa',date('Y-m-d'))->first();
		if(!$get_data){
			return Response::json([
				'metadata'=>[
					'code'=> 201,
					'message'=> 'Maaf, Tidak dapat checkin, cek tanggal periksa',
					]
				]);
			}
		$tgl = $get_data->tglperiksa;
		// dd($get_data);
		$hitung =  $cekantrian+1;
		$tanggalantri =  date("dmY");
		$nomorantri = $tanggalantri.''.$dokter[3].''.$hitung;
		if(is_numeric(substr($nomorantri,-2))){
			$angka = substr($nomorantri,-2);
		  }else{
			$angka = substr($nomorantri,-1);
		  }
		// GENERATE NEW NO RM
		$new_no_rm = date('Yn').sprintf("%03s", 0);
		$cek_norm = RegistrasiDummy::where('no_rm','like',date('Yn') . '%')->count();
		if($cek_norm > 0){
		  $norm = date('Yn').sprintf("%03s", $cek_norm+1);
		}else{
		  $norm = $new_no_rm +1;
		}
			$arrheader = signature_bpjs();
			
			$estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
		// dd($kodeBooking);
		// dd($arrheader);
		$kodeBooking = $nomorantri;
		// $kodeBooking = '22052023ANA3';
		@$kuotaJKN = @Poli::where('bpjs',$dokter[3])->first()->kuota_online;
        @$kuotaNonJKN = @Poli::where('bpjs',$dokter[3])->first()->kuota;
		$sisaKuotaJkn  = RegistrasiDummy::where('tglperiksa',date('Y-m-d'))
        ->where('kode_poli',$dokter[3])
        ->where('kode_cara_bayar','1')
        ->count();

		$noKartu = $request['nomorkartu'];
		$tglSep = date('Y-m-d');
		$jnsLayanan = 2; //Rawat Jalan
		$kodeKelas = $request["hak_kelas_inap"];
		$kodeKelasNaik = @$request["hak_kelas_inap_naik"];
		$pembiayaan = @$request["pembiayaan"];
		$penanggungJawab = @penanggungJawabSep($pembiayaan);
		$noMR = $request["no_rm"];
		$asalRujukan = $request["asalRujukan"];
		$TglRujuk = $request['tgl_rujukan'];
		$noRujuk = $request['no_rujukan'];
		$ppkRujuk = $request['ppk_rujukan'];
		$catatan = '';
		$regdiagAwal = $request["diagnosa_awal"];
		$poliTujuan = $request['poli_bpjs'];
		$cob = 0;
		$katarak = $request["katarak"];
		@$lakaLantas = 0;
		@$penjamin = @$request["penjamin"];
		@$tglKejadian = @$request["tglKejadian"];
		@$kll = @$request["kll"];
		@$suplesi = @$request["suplesi"];
		@$noSepSuplesi = @$request["noSepSuplesi"];
		@$kdPropinsi = @$request['kdPropinsi'];
		@$kdKabupaten = @$request['kdKabupaten'];
		@$kdKecamatan = @$request['kdKecamatan'];
		$tujuanKunj = $request["tujuanKunj"];
		$flagProcedure = $request["flagProcedure"];
		$kdPenunjang = $request["kdPenunjang"];
		$assesmentPel = $request["assesmentPel"];
		$notelp = $request["nohp"];
		$noSurat = $request["noSurat"];
		$kodeDPJP = '';
		$dpjpLayan = $dokter[0];
		if(@$request['type_sep'] != 'sep_baru'){
			$kodeDPJP = $dokter[0];
		}
		
		$request_sep = '{
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
					  "penanggungJawab":"'.$penanggungJawab.'",
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

		 $bpjslog_create_sep = new BpjsLog();
			// $bpjslog_create_sep->request = @$request_sep;
			// $bpjslog_create_sep->response = @json_encode($response);
			// $bpjslog_create_sep->url = url()->full();
			$bpjslog_create_sep->penginput = "APM_OTISTA_CREATE_SEP";
			// $bpjslog_create_sep->nomorantrian = @$get_data->kodebooking;
			$bpjslog_create_sep->save();
		// dd("A");
		//  dd($request_sep);
		$ID = config('app.sep_id');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/insert"; //Insert

		$session_sep = curl_init($completeurl);
		$arrheader = array(
			'X-cons-id: ' . $ID,
			'X-timestamp: ' . $t,
			'X-signature: ' . $signature,
			'user_key:'. config('app.user_key'),
			'Content-Type: application/x-www-form-urlencoded',
		);
		curl_setopt($session_sep, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session_sep, CURLOPT_POSTFIELDS, $request_sep);
		curl_setopt($session_sep, CURLOPT_POST, TRUE);
		curl_setopt($session_sep, CURLOPT_RETURNTRANSFER, TRUE);
		
		
		
		$poli = Poli::where('bpjs',$request->kode_poli)->first();
		// dd($request_sep);
		$count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';
		
		
		// GET ANTRIAN POLI ID 
		// dd("A");
		$dokters = Pegawai::where('kode_bpjs',@$dokter[0])->first();
		// dd($dokters);
		
		if(!$dokters){
			return Response::json([
				'metadata'=>[
					'code'=> 201,
					'message'=> 'Maaf, dokter tidak tersedia',
				]
			]);
		}
		$pasien = Pasien::where('no_rm',$get_data->no_rm)->first();
		if(!$pasien){
			// return Response::json([
			// 	'metadata'=>[
			// 		'code'=> 201,
			// 		'message'=> 'Maaf, Pasien belum terdaftar, silahkan cekin di pasien baru',
			// 	]
			// ]);
			$pasien_new = new Pasien();
			$pasien_new->nama = strtoupper($request['nama']);
			$pasien_new->nik = $request['nik'];
			$pasien_new->tgllahir = @$request['tanggallahir'] ? @valid_date(@$request['tanggallahir']) : '';
			$pasien_new->kelamin = @$request['jeniskelamin'];
			// $pasien_new->no_rm = sprintf("%06s", $no_rm);
			$pasien_new->alamat = @strtoupper($request['alamat']);
			$pasien_new->tgldaftar = date("Y-m-d");
			$pasien_new->rt = @$request['rt'];
			$pasien_new->rw = @$request['rw'];
			$pasien_new->nohp = @$request['nohp'];
			$pasien_new->negara = 'Indonesia';
			$pasien_new->no_jkn = $request['nomorkartu'];
			$pasien_new->user_create = 'APM-KIOSK';
			$pasien_new->user_update = '';
			$pasien_new->save();

			// Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => $no_rm]);
			$rms = Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);

			// UPDATEPASIEN
			$pasi = Pasien::where('id', $pasien_new->id)->first();
			$pasi->no_rm = $rms->id;
			$pasi->save();
		}
		
		$antrian = new AntrianPoli();
		$antrian->nomor = $nomor;
		$antrian->suara = $suara;
		$antrian->status = 0;
		$antrian->panggil = 1;
		$antrian->poli_id = $poli->id;
		$antrian->tanggal = $tgl;
		$antrian->loket = $poli->loket;
		$antrian->kelompok = $poli->kelompok;
		$antrian->save();
		// dd("A");
		// $antrian->save();
		// dd("ANTRIAN");
		// Save registrasi
		$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
	//  dd($id);
		$reg = new Registrasi();
		$reg->input_from = 'registrasi';
		$reg->antrian_poli_id = @$antrian->id;
		$reg->nomorantrian = @$get_data->kodebooking;
		$reg->nomorantrian_jkn = @$get_data->nomorantrian;
		$reg->pasien_id = $pasien->id;
		$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
		$reg->status = 1; //pasien lama
		$reg->created_at = $tgl.' '.date('H:i:s');
		$reg->updated_at = $tgl.' '.date('H:i:s'); //pasien lama
		

		$reg->dokter_id = @$dokters->id;
		$reg->poli_id = $poli->id;
		$reg->input_from = 'APM';
		$reg->bayar = 1;
		$reg->no_jkn = $pasien->no_jkn;
		$reg->no_rujukan = @$request->no_rujukan;
	//  $reg->user_create = 0; //checkin 
		$reg->jenis_pasien = 1;
		$reg->posisiberkas_id = '2';
		$reg->pengirim_rujukan = '';
		$reg->status_reg = 'J1';
		$reg->antrian_poli = $this->antrianPoli($poli->id);
	//  if (!empty($request['tanggal'])) {
	// 	 $reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
	//  }
		$reg->save();
		
		// if($polis->politype)

		// Insert Histori
		$history = new HistoriStatus();
		$history->registrasi_id = $reg->id;
		$history->status = 'J1';
		@$history->created_at = $tgl.' '.date('H:i:s');
		@$history->updated_at = $tgl.' '.date('H:i:s');
		$history->poli_id = $reg->poli_id;
		$history->bed_id = null;

	//  $history->user_id = Auth::user()->id;
		$history->pengirim_rujukan = 1;
		$history->save();

		//Insert Histori Pengunjung
		$hp = new Historipengunjung();
		$hp->registrasi_id = $reg->id;
		$hp->pasien_id = $pasien->id;
		$hp->pengirim_rujukan = 1;
		$hp->politipe = 'J';
		@$hp->created_at = $tgl.' '.date('H:i:s');
		@$hp->updated_at = $tgl.' '.date('H:i:s');
		$hp->status_pasien = 'LAMA';
	//  $hp->user = Auth::user()->name;
		$hp->save();

		//Histori Kunjungan
	
		//IRJ
		$irj = new HistorikunjunganIRJ();
		$irj->registrasi_id = $reg->id;
		$irj->pasien_id = $pasien->id;
		$irj->poli_id = $poli->id;
		$irj->dokter_id = $dokters->id;
		// $irj->user = Auth::user()->name;
		$irj->created_at = $tgl.' '.date('H:i:s');
		$irj->updated_at = $tgl.' '.date('H:i:s');
		$irj->pengirim_rujukan = '1';
		$irj->save();

		$get_data->status = 'checkin';
		$get_data->no_rm = @$pasien->no_rm;
		$get_data->registrasi_id = @$reg->id;
		$get_data->update();

		// JIKA BILLING DICENTANG
		// if(isset($request['billing'])){
			$retri = [];

			// CEK RETRIBUSI PASIEN BARU 
			$retri1 = BiayaPemeriksaan::where('tipe', 'J')->where('pasien','pasien_baru')->whereNull('poli_id')->get();
			if(count($retri1) >0){
				foreach($retri1 as $i){
					$retri[] = $i->tarif_id;
				}
			}
			// CEK RETRIBUSI PASIEN BARU SESUAI POLI
			$retri2 = BiayaPemeriksaan::where('tipe', 'J')->where('pasien','pasien_baru')->where('poli_id', @$reg->poli_id)->get();
			if(count($retri2) >0){
				foreach($retri2 as $i){
					$retri[] = $i->tarif_id;
				}
			}
			
			$pelaksana_tipe = 'TA';
			
				foreach($retri as $key=>$value){
					$created_at = date('Y-m-d H:i:s');
					$tarif  = Tarif::where('id', $value)->first();
					
					$fol = new FolioMulti();

					
						$fol->registrasi_id    =  @$reg->id;
						$fol->poli_id          =  @$reg->poli_id;
						$fol->lunas            = 'N';
						$fol->namatarif        =  @$tarif->nama;
						$fol->dijamin          =  @$request['dijamin'];
						$fol->tarif_id         =  @$tarif->id;
						$fol->cara_bayar_id    =  @$reg->bayar;
						$fol->jenis            =  @$tarif->jenis;
						$fol->poli_tipe        = 'J';
						$fol->total            =  @$tarif->total;
						$fol->jenis_pasien     =  @$reg->jenis_pasien;
						$fol->pasien_id        =  @$reg->pasien_id;
						$fol->dokter_id        =  @$reg->dokter_id;
						$fol->user_id          = '1';
						$fol->mapping_biaya_id =  @$tarif->mapping_biaya_id;
						$fol->dpjp             =  @$reg->dokter_id;
						$fol->dokter_pelaksana =  @$reg->dokter_id;
						$fol->pelaksana_tipe   =  @$pelaksana_tipe;
						$fol->created_at       =  @$created_at;
						$fol->catatan          = 'apm';
						$fol->save();
						// dd($fol);
					
				}
				// dd("A");
		// }

		// dd($kuotaJKN-$sisaKuotaJkn);
		$sisakuotajkn = ($kuotaJKN-$sisaKuotaJkn) < 0 ? 1 : $kuotaJKN-$sisaKuotaJkn;
		$sisakuotaNonJkn = sisaKuotaNonJkn($request->kode_poli,date('Y-m-d')) < 0 ? 1 :sisaKuotaNonJkn($request->kode_poli,date('Y-m-d'));
		if($request['jenisKunjungan'] == '3' || $request['tujuanKunj'] == '2'){
			$noref = $request['noSurat'];
		}else{
			$noref = $request['no_rujukan'];
		}
		if (str_contains($noref, 'K')) {
			$jenisKunj = $request['jenisKunjungan'];
		}else{
			$jenisKunj = '1';
		}

		$req   = '{
			"kodebooking": "'.@$kodeBooking.'",
			"jenispasien": "JKN",
			"nomorkartu": "'.$request['nomorkartu'].'",
			"nik": "'.$request['nik'].'",
			"nohp": "'.$request->nohp.'",
			"kodepoli": "'.$dokter[3].'",
			"namapoli": "'.$dokter[4].'", 
			"pasienbaru": "0",
			"norm": "'.$pasien->no_rm.'",
			"tanggalperiksa": "'.date('Y-m-d').'", 
			"kodedokter": "'.$dokter[0].'", 
			"namadokter": "'.$dokter[1].'",
			"jampraktek": "'.$dokter[2].'",
			"jeniskunjungan": "'.$jenisKunj.'",
			"nomorreferensi": "'.@$noref.'",
			"nomorantrean": "'.$dokter[3].''.$hitung.'",
			"angkaantrean": "'.(int) $angka.'",
			"estimasidilayani": "'.$estimasi.'",
			"sisakuotajkn": "'.$sisakuotajkn.'",
			"kuotajkn": "20",
			"sisakuotanonjkn": "'.$sisakuotaNonJkn.'",
			"kuotanonjkn": "'.baca_data_poli($request->kode_poli)->kuota.'",
			"keterangan": "-"
		}';
		// dd($req);
		
		// dd($req);
		$completeurl = config('app.antrean_url_web_service')."antrean/add";
		$session = curl_init($completeurl); 
		
		// dd(json_decode($body_prb));
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $req);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		$sml = json_decode($response, true);
		@$jsonrespon = json_decode($response, true); 
		// dd("A");
		// dd($kodeBooking);
		// dd($sml);
		// if(isset($sml)){
			// if($sml['metadata']['code'] == 201){
			// 	return Response::json($sml);
			// }
		// }

		$updatewaktu   = '{
			"kodebooking": "'.$kodeBooking.'",
			"taskid": 3,
			"waktu": "'.round(microtime(true) * 1000).'"
		 }';
		 $completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
		 $session2 = curl_init($completeurl2);
		 curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
		 curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
		 curl_setopt($session2, CURLOPT_POST, TRUE);
		 curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
		 $s_n = curl_exec($session2);
		 $sml4 = json_decode($s_n, true);

		// LOG BPJS
		$bpjslog = new BpjsLog();
		$bpjslog->request = @$req;
		$bpjslog->status = @$jsonrespon['metadata']['code'];
		$bpjslog->response = @$response;
		$bpjslog->response_taskid = @$s_n;
		$bpjslog->url = 'storeCekinSep';
		$bpjslog->user_id = '0';
		$bpjslog->penginput = 'APM_OTISTA';
		$bpjslog->nomorantrian = @$kodeBooking;
		$bpjslog->save();

		// dd(Satusehat::find(1)->aktif); 
		 // EKSEKUSI SEP
		$response = curl_exec($session_sep);
		
		$sml = json_decode($response, true); 
		
		
		
		// dd($sml);
		// DB::commit(); 
		// return Response::json([
		// 	'metadata'=>[
		// 		'code'=> 200,
		// 		'id'=> @$get_data->id,
		// 		'norm'=> @$get_data->no_rm,
		// 	]
		// ]);
		
		if ($sml['metaData']['message'] == 'Sukses') {
			$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);
			

			$new_reg = Registrasi::where('id',$reg->id)->first();
			$new_reg->no_sep = @$sep['sep']['noSep'];
			$new_reg->tgl_rujukan = @$TglRujuk;
			$new_reg->no_rujukan = @$noRujuk;
			$new_reg->ppk_rujukan = @$ppkRujuk . '|' . @$request['nama_ppk_rujukan'];
			$new_reg->diagnosa_awal = @$regdiagAwal;
			$new_reg->tgl_sep = @$tglSep;
			if(isset($kodeDPJP)){
				if($kodeDPJP !== null){
					@$dpjp = Pegawai::where('kode_bpjs',$kodeDPJP)->first();
					if(@$dpjp){
						@$new_reg->dokter_id = @$dpjp->id;
						@$updatehistori = HistorikunjunganIRJ::where('registrasi_id',@$new_reg->id)->orderBy('id','DESC')->first();
						if(@$updatehistori){
							@$updatehistori->dokter_id = @$dpjp->id;
							@$updatehistori->save();
						}
					}
				}
	
			}
			$new_reg->poli_bpjs = @$poliTujuan;
			$new_reg->hakkelas = @$kodeKelas;
			$new_reg->nomorrujukan = $noRujuk;
			$new_reg->catatan = '';
			$new_reg->kecelakaan = @$request['laka_lantas'];
			$new_reg->no_jkn = @$noKartu;
			$new_reg->jenis_kunjungan = @$request['jenisKunjungan'];
			$new_reg->save();

			DB::commit(); 
			// return redirect('/reservasi/cetak-sep/'.$sep['sep']['noSep']);
			return Response::json([
				'metadata'=>[
					'code'=> 200,
					'id'=> @$get_data->id,
					'norm'=> @$get_data->no_rm,
				]
			]);
			// return response()->json(['sukses' => $sep['sep']['noSep'],'cetak'=>$sep['sep']]);
		}else{
			 
			return Response::json([
				'metadata'=>[
					'code'=> 201,
					'message'=> error_msg_bpjs($sml['metaData']['message']),
				]
			]);
		}
	// END EKSEKUSI SEP


		}catch( \Exception $e ){
			DB::rollback();
			// dd($e->getMessage());
			// Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
			return Response::json([
				'metadata'=>[
					'code'=> 201,
					'message'=> $e->getMessage(),
				]
			]);
			// return redirect()->back();
		}
		
	}
	function cekFinger($nomor,$tglperiksa){
		list($ID, $t, $signature) = $this->HashBPJS();
			
		$completeurl = config('app.sep_url_web_service') . "/SEP/FingerPrint/Peserta/". $nomor."/TglPelayanan/".$tglperiksa;
		$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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
	function dokterHfis($poli){
		$ID = config('app.consid_antrean');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.secretkey_antrean');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
		
		$completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $poli . "/tanggal/" . date('Y-m-d');
		// $completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $poli . "/tanggal/2023-05-19";
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
		if(!$response){
			return redirect('/reservasi/cek-baru')->with('error', 'Web Service BPJS sedang gangguan,coba beberapa waktu lagi');
		}
		// dd($response);
		
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
		return $json;
	}
	function cekRujukanRs($nomor){
		list($ID, $t, $signature) = $this->HashBPJS();
			
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/RS/". $nomor;
		$response = $this->xrequest($completeurl, $signature, $ID, $t); 
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

	function cekRujukan($nomor){
		list($ID, $t, $signature) = $this->HashBPJS();
		// dd($nomor);
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/". $nomor;
		// $completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/noSuratKontrol/". $nomor;
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
		// dd($json);
		return $json;
	}
	function cekRujukanSKDP($nomor){
		list($ID, $t, $signature) = $this->HashBPJS();
		// dd($nomor);
		$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/noSuratKontrol/". $nomor;
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
		// dd($json);
		return $json;
	}
	function cekNomorSep($nomor){
		list($ID, $t, $signature) = $this->HashBPJS();
		// dd($nomor);
		// $completeurl = config('app.sep_url_web_service') . "/SEP/1002R0060724V008154";
		$completeurl = config('app.sep_url_web_service') . "/SEP/". $nomor;
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
		// dd($json);
		return $json;
	}
	function cekNoSurkon($nomorkartu,$bulan,$tahun){
		list($ID, $t, $signature) = $this->HashBPJS();
		// dd($nomor);
		// $bulan = 7;
		$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/ListRencanaKontrol/Bulan/".date('m')."/Tahun/".$tahun."/Nokartu/".$nomorkartu."/filter/2";
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
		// dd($json);
		return $json;
	}
	 

	// END CEK RESERVASI

    public function pilihPasien(Request $request)
    {
        // dd($request->all());
        $find = Pasien::where('id',$request->id)->first();
        if($find){
            return response()->json(['status'=>200,'result'=> $find]);
        }else{
            return response()->json(['status'=>500,'result'=>'Data pasien tidak ditemukan. Silahkan mendaftar terlebih dahulu.']);
        }
        // return view('reservasi.index',$data);
    }

    public function cariPasien(Request $request)
    {
        // dd($request->all());
		// cari pasien diregistrasi dummy
        $find = Pasien::Where('nik',$request->keyword)->orWhere('no_rm',$request->keyword);
		
        if($find->count() > 0){
            return response()->json(['status'=>200,'result'=> $find->first()]);
        }else{
            return response()->json(['status'=>500,'result'=>'Data pasien tidak ditemukan. Silahkan mendaftar terlebih dahulu.']);
        }
        // return view('reservasi.index',$data);
    }

    // V2
	function poli() {
		$ID = config('app.consid_antrean');
		date_default_timezone_set('Asia/Jakarta');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.secretkey_antrean');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
		// dd($request->all());
		 
		$completeurl =config('app.antrean_url_web_service')."ref/poli";
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
        // dd($response);
		// dd($response['metadata']['code']);
		
		$message = json_decode($response, true); 
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);

		if($message['metadata']['code'] == '1'){
			$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
			$array[] = json_decode($this->decompress($stringEncrypt),true);
		}else{
			$array[] = json_decode($response,true);
		}
		$sml = json_encode($array,JSON_PRETTY_PRINT); 
        // dd($sml);
		$json = json_decode($sml,true);
        dd($json[1]);
		return $json;
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
     
}
