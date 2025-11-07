<?php

namespace App\Http\Controllers;

use App\AntrianPoli;
use Modules\Antrian\Entities\Antrian;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use App\Nomorrm;
use App\Satusehat;
use Auth;
use App\FolioMulti;
use DB;
use Flashy;
use Illuminate\Http\Request;
use Modules\Icd10\Entities\Icd10;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\Province;
use Illuminate\Support\Facades\Input;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Perusahaan\Entities\Perusahaan;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Status;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Jenisjkn\Entities\Jenisjkn;
use App\PengirimRujukan;
use App\RegistrasiDummy;
use Modules\Registrasi\Entities\BiayaPemeriksaan;

class RegOnlineController extends Controller {
	   

	public function savePerjanjianOnline(Request $request) {
		// dd("A");
		$regDum = RegistrasiDummy::find($request->registrasi_dummy_id);
		$no = Nomorrm::count() + config('app.no_rm');
		request()->validate([
			'created_at' => 'required',
			// 'no_rm' => 'unique:pasiens,no_rm',
		]);
		// dd($request->all());
		DB::beginTransaction();
        // try{
			

			$poli = Poli::find($request->poli_id);
			$dokters = Pegawai::find($request->dokter_id);
			$find = Antrian::find(isset($request['antrian_id']) ? $request['antrian_id'] : null); // find antrian
			
			// if($find){
			if (!empty($request['created_at'])) {
				$tgl = date(valid_date($request['created_at']));
			}else{
				$tgl = date('Y-m-d');
			}
			// if($find){
				// $count = AntrianPoli::where('tanggal', '=', $tgl)->where('kelompok', $poli->kelompok)->count();
				// $nomor = $count + 1;
				$cekantrian = hitungAntrolNew($request->dokter_id,$tgl,$poli->bpjs);
				$hitung =  $cekantrian;
				$tanggalantri =  date("dmY", strtotime($tgl));
				if($dokters->kode_antrian){
					$kodeantri = $dokters->kode_antrian;
				}else{
					$kodeantri =$tanggalantri; 
				}
				$nomorantri = $kodeantri.'-'.$poli->bpjs.''.$hitung;
			// if($find){
				// $count = AntrianPoli::where('tanggal', '=', $tgl)->where('kelompok', $poli->kelompok)->count();
				// $nomor = $count + 1;
				$nomor = $regDum->angkaantrian;
				$suara = $nomor . '.mp3';
				$antrian_poli = [
					"nomor" => $nomor,
					"suara" => $suara,
					"status" => 0,
					"panggil" => 1, 
					"poli_id" => $request->poli_id, 
					"tanggal" => $tgl,
					"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
					"kelompok" => $poli->kelompok
				];
			// GET ANTRIAN POLI ID 
			$antrian = AntrianPoli::create($antrian_poli); 
			// dd($request->all());
			// $no = Nomorrm::count() + config('app.no_rm');
			// $no_rm = !empty($request['no_rm']) ? $request['no_rm'] : $no;
			
			// Save data pasien
		if (Satusehat::find(1)->aktif == 1) {
			if(satusehat()) {
					$id_ss = SatuSehatController::PatientGet(@$request['nik']);
			}
		}
			$pasien = new Pasien();
			$pasien->nama = $request['nama'];
			$pasien->mr_id = generateRmId();
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			// $pasien->no_rm = sprintf("%06s", $no_rm);
			$pasien->id_patient_ss = @$id_ss;
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = $request['alamat'];
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->ibu_kandung = $request['ibu_kandung'];
			$pasien->status_marital = $request['status_marital'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->user_create = Auth::user()->name;
			$pasien->user_update = '';
			$pasien->no_jkn = @$request['no_jkn'];
			$pasien->save();
			
			$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
			$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
			$pasi = Pasien::where('id',$pasien->id)->first();
			$rmid = $rms->id;
			$cek_pas = Pasien::where('no_rm',$rmid)->first();
			if($cek_pas){
				$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
				$rmid = $rms->id;
			}
				$pasi->no_rm = $rmid;
			$pasi->save();

			// dd($pasien);
			//Save No RM
			if (!isset($request['no_rm']) || empty($request['no_rm'])) {
				Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no]);
			}
			
			// Save registrasi
			// $antrianRegis = $regDum->kodebooking? $regDum->kodebooking: generateKodeBooking();
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = $pasien->id;
			$reg->input_from = 'registrasi_online';
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->antrian_poli_id = @$antrian->id;
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->nomorantrian = @$regDum->kodebooking;
			$reg->nomorantrian_jkn = @$regDum->nomorantrian;
			$reg->rujukan = $request['rujukan'];
			$reg->pengirim_rujukan = $request['pengirim_rujukan'];
			$reg->antrian_id = NULL;
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hakkelas = $request['hakkelas'];
			$reg->nomorrujukan = $request['nomorrujukan'];
			$reg->tglrujukan = $request['tglrujukan'];
			$reg->kodeasal = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
			$reg->catatan = $request['catatan'];
			$reg->dokter_id = $request['dokter_id'];
			$reg->poli_id = $request['poli_id'];
			$reg->icd = $request['icd'];
			$reg->kecelakaan = $request['kecelakaan'];
			$reg->tipe_jkn = $request['jkn'];
			$reg->no_sep = $request['no_sep'];
			$reg->sebabsakit_id = $request['sebabsakit_id'];
			$reg->bayar = $request['bayar'];
			$reg->no_jkn = $request['no_jkn'];
			$reg->user_create = Auth::user()->id;
			$reg->jenis_pasien = $request['bayar'];
			$reg->posisiberkas_id = '2';
			$reg->status_reg = $request['status_reg'];
			$reg->pengirim_rujukan = $request['pengirim_rujukan'];
			$reg->puskesmas_id = $request['puskesmas_id'];
			$reg->dokter_perujuk_id = $request['dokter_perujuk_id'];
			if ($request['status_reg'] == 'G1') {
				$reg->status_ugd = $request['status_ugd'];
			}
			if (($request['poli_id'] == 19) || ($request['poli_id'] == 20)) {
				$reg->tracer = 1;
			}
			$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->antrian_poli = $this->antrianPoli($request['poli_id'], valid_date($request['created_at']));
			$reg->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$reg->updated_at = date(valid_date($request['created_at']) . ' H:i:s');
			// dd($reg);
			$reg->save();


			// JIKA BILLING DICENTANG
			if(isset($request['billing'])){
				$retri = [];
				// dd('B');
				if(!$request['status_reg']){
					$request['status_reg'] == 'J';
				}
				// CEK RETRIBUSI PASIEN BARU 
				$retri1 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_baru')->whereNull('poli_id')->get();
				if(count($retri1) >0){
					foreach($retri1 as $i){
						$retri[] = $i->tarif_id;
					}
				}
				// CEK RETRIBUSI PASIEN BARU SESUAI POLI
				$retri2 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_baru')->where('poli_id',$request->poli_id)->get();
				if(count($retri2) >0){
					foreach($retri2 as $i){
						$retri[] = $i->tarif_id;
					}
				}

				if (cek_status_reg($request['status_reg']) == 'G' || $reg->status_reg == 'I1' ||$reg->status_reg == 'I2'||$reg->status_reg == 'I3') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}
				if($request['status_reg']){
					foreach($retri as $key=>$value){
						$created_at = date('Y-m-d H:i:s');
						$tarif  = Tarif::where('id',$value)->first();
						FolioMulti::create([
							'registrasi_id'    => @$reg->id,
							'poli_id'          => @$reg->poli_id,
							'lunas'            => 'N',
							'namatarif'        => @$tarif->nama,
							'dijamin'          => @$request['dijamin'],
							'tarif_id'         => @$tarif->id,
							'cara_bayar_id'    => @$reg->bayar,
							'jenis'            => @$tarif->jenis,
							'poli_tipe'        => cek_status_reg($request['status_reg']),
							'total'            => @$tarif->total,
							'jenis_pasien'     => @$reg->jenis_pasien,
							'pasien_id'        => @$reg->pasien_id,
							'dokter_id'        => $reg->dokter_id,
							'user_id'          => Auth::user()->id,
							'mapping_biaya_id' => @$tarif->mapping_biaya_id,
							'dpjp'             => @$reg->dokter_id,
							'dokter_pelaksana' => @$reg->dokter_id,
							'pelaksana_tipe'   => @$pelaksana_tipe,
							'created_at'       => @$created_at,
							'catatan'         => 'reg_perj_new'
						]);
					}

				}
			}


			if(satusehat()) {
				if (Satusehat::find(1)->aktif == 1) {
					if($reg->status_reg == 'J1'){
						$reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id);
						$reg->update();
					}
				}
		}
			session(['reg_online_id' => $reg->id]);
			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->politipe = 'J';
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			$irj = new HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $request['poli_id'];
			$irj->dokter_id = @$request['dokter_id'];
			$irj->user = Auth::user()->name;
			$irj->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$irj->pengirim_rujukan = $request['pengirim_rujukan'];
			$irj->save();

			// Insert Biaya Registrasi dan ke Folio
			$biaya = Biayaregistrasi::all();
			$harus_dibayar = 0;
			$harus_dibayar;

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = $pasien->id;
			$tag->harus_dibayar = $harus_dibayar;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = NULL;
			$history->user_id = Auth::user()->id;
			$history->pengirim_rujukan = $request['pengirim_rujukan'];
			$history->save();
			session(['pasienID' => $pasien->id]);
			

			// UPDATE REGISTRASI DUMMY
			$cekantrian = RegistrasiDummy::where('jenisdaftar', 'fkrtl')->where('tglperiksa',valid_date($request['created_at']))->where('kode_poli', $poli->bpjs)->count();
			$hitung =  $cekantrian+1;
			$tanggalantri =  date("dmY", strtotime($request['created_at']));
			$nomorantri = $tanggalantri.''.$poli->bpjs.''.$hitung;
			// dd($nomorantri);
			$regDum = RegistrasiDummy::find($request->registrasi_dummy_id);
			
			if(!$regDum->nomorantrian){
				$nomorantri = $nomorantri;
			}else{
				$nomorantri = $regDum->kodebooking;
			}
			
			
			if(is_numeric(substr($nomorantri,-2))){
				$angka = substr($nomorantri,-2);
			}else{
				$angka = substr($nomorantri,-1);
			}
			// dd($angka);
			$dok = Pegawai::where('id',$request['dokter_id'])->first();
			// if($regDum->jenis_registrasi == 'pasien_baru'){
				$regDum->tglPeriksa = valid_date($request->created_at);
				$regDum->registrasi_id = $reg->id;
				$regDum->kode_poli = $poli->bpjs;
				$regDum->nomorkartu = @$request['no_jkn'];
				$regDum->nomorantrian = $nomorantri;
				$regDum->status       = 'dilayani';
				$regDum->angkaantrian = $angka;
				$regDum->no_rm = $pasien->no_rm;
				$regDum->kode_dokter = @$dok->kode_bpjs;
				$regDum->dokter_id = $request['dokter_id'];
				$regDum->save();
				// dd($regDum);
			// }
			// dd($regDum);
			// dd($regDum);
			// dd($regDum->nomorantrian);
			$arrheader = signature_bpjs();
			$updatewaktu   = '{
				"kodebooking": "'.$regDum->kodebooking.'",
				"taskid": 2,
				"waktu": "'.round(microtime(true) * 1000).'"
			 }';
			//  dd($updatewaktu);
			 
			 $completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			 $session2 = curl_init($completeurl2);
			//  dd($updatewaktu);
			 curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			 curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
			 curl_setopt($session2, CURLOPT_POST, TRUE);
			 curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			 $response2 = curl_exec($session2);
			//  dd($response2);
			 $sml2 = json_decode($response2, true);

			if(isset($request['reg_online']) == '1'){
				$regdums = RegistrasiDummy::where('jenis_registrasi','antrian')->where('nomorantrian',@$request['nomorantrian'])->first();
				if($regdums){
					$regdums->status = 'terdaftar';
					$regdums->save();
				}

			}

			DB::commit(); 
			$cek_rmss = Nomorrm::where('pasien_id',$pasien->id)->orderBy('id','DESC')->first();
				// dd($cek_rmss);
				if($cek_rmss){
					if($pasien->no_rm !== $cek_rmss->id){
						// dd("BB");
						$up_pas = Pasien::where('id',$pasien->id)->first();
						$up_pas->no_rm = $cek_rmss->id;
						$up_pas->save();
					}else{
						// dd("CCC");
					}
				}

			if ($request['bayar'] == 1) {
				Flashy::success('Registrasi Sukses');
				return redirect('form-sep/' . session('reg_online_id'));
			} else {
				Flashy::success('Registrasi Sukses');
				return redirect('regperjanjian');
			}
			
			// return redirect('regperjanjian');
		// }catch(Exception $e){
		// 	DB::rollback();
			
		// 	Flashy::info('Gagal Registrasi Data');
		// 	return redirect('regperjanjian');
		// } 
		
	}

	public function savePerjanjianPasienLamaOnline(Request $request, $id) {
		// dd($request->all());
		$regDum = RegistrasiDummy::find($request->registrasi_dummy_id);
		request()->validate([
			'created_at' => 'required',
			'poli_id' => 'required',
			'dokter_id' => 'required',
		]);
		DB::beginTransaction();
        try{
			$poli = Poli::find($request->poli_id);
			$find = Antrian::find(isset($request['antrian_id']) ? $request['antrian_id'] : null); // find antrian
			
			// if($find){
				if (!empty($request['created_at'])) {
					$tgl = date(valid_date($request['created_at']));
				}else{
					$tgl = date('Y-m-d');
				}
				// if($find){
					$count = AntrianPoli::where('tanggal', '=', $tgl)->where('kelompok', $poli->kelompok)->count();
					$nomor = $count + 1;
					$suara = $nomor . '.mp3';
					$antrian_poli = [
						"nomor" => $nomor,
						"suara" => $suara,
						"status" => 0,
						"panggil" => 1, 
						"poli_id" => $request->poli_id, 
						"tanggal" => $tgl,
						"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
						"kelompok" => $poli->kelompok
					];
			// GET ANTRIAN POLI ID 
			$antrian = AntrianPoli::create($antrian_poli); 
			// Update Pasien
			$pasien = Pasien::find($id);
			if (empty($pasien->no_rm)) {
				$no_rm = Nomorrm::count() + 1;
				Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no_rm]);
				$pasien->no_rm = sprintf("%06s", $no_rm);
			}

			if (Satusehat::find(1)->aktif == 1) {
				if(satusehat()) {
					$id_ss = SatuSehatController::PatientGet($request['nik']);
				}
		}
			$pasien->nama = $request['nama'];
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->id_patient_ss = @$id_ss;
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = $request['alamat'];
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->ibu_kandung = $request['ibu_kandung'];
			$pasien->status_marital = $request['status_marital'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->user_update = Auth::user()->name;
			$pasien->update();

			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->input_from = 'regperjanjian_online';
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->antrian_poli_id = @$antrian->id;
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->rujukan = $request['rujukan'];
			$reg->pengirim_rujukan = $request['pengirim_rujukan'];
			$reg->nomorantrian = $regDum->kodebooking;
			$reg->nomorantrian_jkn = $regDum->nomorantrian;
			$reg->antrian_id = NULL;
			$reg->rjtl = $request['rjtl'];
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hakkelas = $request['hakkelas'];
			$reg->nomorrujukan = $request['nomorrujukan'];
			$reg->tglrujukan = $request['tglrujukan'];
			$reg->kodeasal = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
			$reg->catatan = $request['catatan'];
			$reg->dokter_id = $request['dokter_id'];
			$reg->poli_id = $request['poli_id'];
			$reg->icd = $request['icd'];
			$reg->kecelakaan = $request['kecelakaan'];
			$reg->tipe_jkn = $request['jkn'];
			$reg->no_sep = $request['no_sep'];
			$reg->sebabsakit_id = $request['sebabsakit_id'];
			$reg->bayar = $request['bayar'];
			$reg->no_jkn = $request['no_jkn'];
			$reg->user_create = Auth::user()->id;
			$reg->jenis_pasien = $request['bayar'];
			$reg->posisiberkas_id = '2';
			$reg->status_reg = $request['status_reg'];
			$reg->puskesmas_id = $request['puskesmas_id'];
			$reg->dokter_perujuk_id = $request['dokter_perujuk_id'];
			if ($request['status_reg'] == 'G1') {
				$reg->status_ugd = $request['status_ugd'];
			}
			$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->antrian_poli = $this->antrianPoli($request['poli_id'], valid_date($request['created_at']));
			$reg->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$reg->updated_at = date(valid_date($request['created_at']) . ' H:i:s');
			// dd($reg);
			$reg->save();

			// JIKA BILLING DICENTANG
			if(isset($request['billing'])){
				$retri = [];
				// dd('B');
				if(!$request['status_reg']){
					$request['status_reg'] == 'J';
				}
				// CEK RETRIBUSI PASIEN BARU 
				$retri1 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_baru')->whereNull('poli_id')->get();
				if(count($retri1) >0){
					foreach($retri1 as $i){
						$retri[] = $i->tarif_id;
					}
				}
				// CEK RETRIBUSI PASIEN BARU SESUAI POLI
				$retri2 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_baru')->where('poli_id',$request->poli_id)->get();
				if(count($retri2) >0){
					foreach($retri2 as $i){
						$retri[] = $i->tarif_id;
					}
				}

				if (cek_status_reg($request['status_reg']) == 'G' || $reg->status_reg == 'I1' ||$reg->status_reg == 'I2'||$reg->status_reg == 'I3') {
					$pelaksana_tipe = 'TG';
				} else {
					$pelaksana_tipe = 'TA';
				}
				if($request['status_reg']){
					foreach($retri as $key=>$value){
						$created_at = date('Y-m-d H:i:s');
						$tarif  = Tarif::where('id',$value)->first();
						FolioMulti::create([
							'registrasi_id'    => @$reg->id,
							'poli_id'          => @$reg->poli_id,
							'lunas'            => 'N',
							'namatarif'        => @$tarif->nama,
							'dijamin'          => @$request['dijamin'],
							'tarif_id'         => @$tarif->id,
							'cara_bayar_id'    => @$reg->bayar,
							'jenis'            => @$tarif->jenis,
							'poli_tipe'        => cek_status_reg($request['status_reg']),
							'total'            => @$tarif->total,
							'jenis_pasien'     => @$reg->jenis_pasien,
							'pasien_id'        => @$reg->pasien_id,
							'dokter_id'        => $reg->dokter_id,
							'user_id'          => Auth::user()->id,
							'mapping_biaya_id' => @$tarif->mapping_biaya_id,
							'dpjp'             => @$reg->dokter_id,
							'dokter_pelaksana' => @$reg->dokter_id,
							'pelaksana_tipe'   => @$pelaksana_tipe,
							'created_at'       => @$created_at,
							'catatan'         => 'reg_perj_new'
						]);
					}

				}
			}

			if(satusehat()) {
				if (Satusehat::find(1)->aktif == 1) {
					if($reg->status_reg == 'J1'){
						$reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id);
						$reg->update();
					}
				}
		}
			session(['reg_online_id' => $reg->id]);

			// jika ada antrian online
			if(isset($request['registrasi_dummy_id'])){
				$reg_dumm = RegistrasiDummy::where('id',$request['registrasi_dummy_id'])->first();
				if($reg_dumm){
					$reg_dumm->status = 'dilayani';
					$reg_dumm->save();
				}
			}

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->politipe = 'J';
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			$irj = new HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->dokter_id = $request['dokter_id'];
			$irj->poli_id = $request['poli_id'];
			$irj->user = Auth::user()->name;
			$irj->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$irj->save();

			// Insert Biaya Registrasi dan ke Folio
			$biaya = Biayaregistrasi::all();
			$harus_dibayar = 0;
			$harus_dibayar;

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = $pasien->id;
			$tag->harus_dibayar = $harus_dibayar;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = 1;
			$history->user_id = Auth::user()->id;
			$history->save();
			session(['pasienID' => $pasien->id]);
			// if($request['bayar'] == 2){ //jika pembayaran umum
				$new_noantri = date('dmY').sprintf("%04s", 0);
				$noantri = Registrasi::where('nomorantrian','like',(int)date('dmY') . '%')->count();
				// dd($noantri);
				if($noantri > 0){
					$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
				}else{
					$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
				}
				// $nomorantrian = 136202201;
				
			$arrheader = signature_bpjs();
			$updatewaktu   = '{
				"kodebooking": "'.$regDum->kodebooking.'",
				"taskid": 2,
				"waktu": "'.round(microtime(true) * 1000).'"
			 }';
			 $completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			 $session2 = curl_init($completeurl2);
			//  dd($updatewaktu);
			 curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			 curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
			 curl_setopt($session2, CURLOPT_POST, TRUE);
			 curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			 $response2 = curl_exec($session2);
			//  dd($response2);
			 $sml2 = json_decode($response2, true);


			session()->forget('igdlama');
			DB::commit();
			if ($request['bayar'] == 1) {
				Flashy::success('Registrasi Sukses');
				return redirect('form-sep/' . session('reg_online_id'));
			} else {
				Flashy::success('Registrasi Sukses');
				return redirect('regperjanjian');
			}
		}catch(Exception $e){
			DB::rollback(); 
			Flashy::info('Gagal Registrasi Data');
			return redirect('regperjanjian');
		} 
			

	}

	public function antrianPoli($poli_id = NULL, $tgl = NULL) {
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', $tgl . '%')->count();
		return $poli + 1;
	}
  

}
