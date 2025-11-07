<?php

namespace App\Http\Controllers;

use App\AntrianPoli;
use App\FolioMulti;
use Modules\Antrian\Entities\Antrian;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use App\Nomorrm;
use Auth;
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
use Modules\Registrasi\Entities\BiayaMcu;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use Modules\Registrasi\Http\Requests\SaveRegistrasiPerjRequest;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Jenisjkn\Entities\Jenisjkn;
use App\PengirimRujukan;
use App\RegistrasiDummy;
use App\Http\Controllers\SatuSehatController;
use App\Satusehat;
use Modules\Registrasi\Entities\BiayaPemeriksaan;
use Modules\Tarif\Entities\Tarif;
use App\HistoriOrderLab;

class RegperjanjianController extends Controller {
	public function index($id = '') {
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		$data['poli'] = Poli::select('nama', 'id')->whereIn('politype', ['J', 'M'])->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		if($data['pasien'] != null){
			$data['id']       = $data['pasien']->id;
		  }else{
			$data['id']       ='';
		  }
		session()->forget('pasienID');
		session()->forget('blm_terdata');
		return view('reg-perjanjian.index', $data);
	}

	public function indexOnline($id = '') {
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		$data['poli'] = Poli::select('nama', 'id','bpjs')->whereIn('politype', ['J', 'M'])->get();
		$data['pasien'] = RegistrasiDummy::find($id);
		$data['dokter'] = Pegawai::select('nama', 'id','kode_bpjs')->where('kategori_pegawai',1)->get();
		$data['icd10'] = Icd10::all();
		// dd($data['pasien']);
		session()->forget('pasienID');
		session()->forget('blm_terdata');
		return view('reg-perjanjian.indexOnline', $data);
	}

	public function antrianPoli($poli_id = NULL, $tgl = NULL) {
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', $tgl . '%')->count();
		return $poli + 1;
	}

	public function searchPasien(Request $request) {
		// request()->validate(['keyword' => 'required']);
		$keyword = $request['keyword'];
		// $data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
		// 	->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
		// 	->orWhere('no_rm_lama', 'LIKE', '%' . $keyword . '%')
		// 	->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
		// 	->get();
		// dd($request->all());
		$no_rm = (!empty($request["no_rm_s"])) ? ($request["no_rm_s"]) : ('');
		$alamat = (!empty($request["alamats"])) ? ($request["alamats"]) : ('');
		$nama = (!empty($request["namas"])) ? ($request["namas"]) : ('');
		$tgllahir = (!empty($request["tgllahirs"])) ? ($request["tgllahirs"]) : ('');
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'no_rm_lama',
			'nama',
			'nik',
			'alamat',
			'ibu_kandung',
			'no_jkn',
			'tgllahir',
			
			// date("dmY", strtotime( @$d->updated_at ))
			
		]);
		if(!empty($no_rm)){
			$pasien = $pasien->where('no_rm',$no_rm);
		}
		if(!empty($nama)){
			$pasien = $pasien->where('nama','LIKE','%'.$nama.'%');
		}
		if(!empty($alamat)){
			$pasien = $pasien->where('alamat','LIKE','%'.$alamat.'%');
		}
		if(!empty($tgllahir)){
			@$hri = @substr($tgllahir,0,2);
			@$bulan = @substr($tgllahir,2,2);
			@$tahun = @substr($tgllahir,4,4);
			// dd($tahun);
			$pasien = $pasien->where('tgllahir',@$tahun.'-'.@$bulan.'-'.@$hri);
		}
		
		$pasien = $pasien->orderBy('id', 'asc')->get();
		$data = $pasien;
		return view('reg-perjanjian.pasien', compact('data', 'keyword'))->with('no', 1);
	}

	public function savePerjanjian(SaveRegistrasiRequest $request) {
		// $no = Nomorrm::count() + config('app.no_rm');
		// dd($request->all());
		// sleep(rand(1,15));
		// $no = Nomorrm::count() + config('app.no_rm');
		// $no_rm = !empty($request['no_rm']) ? $request['no_rm'] : $no;
		// dd($no);
		request()->validate([
			'created_at' => 'required',
			// 'no_rm' => 'unique:pasiens,no_rm',
		]);
		// $cek = Pasien::where('no_rm', $no_rm)->count();
		// if ($cek > 0) {
		// 	Flashy::info('No RM baru (' . $no_rm . ') sdh ada, hubungi Admin!');
		// 	return back();
		// }

		// dd($request->all());
		DB::beginTransaction();
        try{
			$poli = Poli::find($request->poli_id);
			$find = Antrian::find(isset($request['antrian_id']) ? $request['antrian_id'] : null); // find antrian
			$dokters = Pegawai::find($request->dokter_id);
			// if($find){
			if (!empty($request['created_at'])) {
				$tgl = date(valid_date($request['created_at']));
			}else{
				$tgl = date('Y-m-d');
			}

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
				$nomor = $cekantrian;
			// if($find){
				// $count = AntrianPoli::where('tanggal', '=', $tgl)->where('kelompok', $poli->kelompok)->count();
				// $nomor = $count + 1;
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
			// $no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;
			// Save data pasien
			$pasien = new Pasien();
			$pasien->nama = $request['nama'];
			$pasien->nik = $request['nik'];
			$pasien->mr_id = generateRmId();
			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
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
			// $pasien->no_rm = sprintf("%06s", $no_rm);
			
			// dd($pasien);
			//Save No RM
			// if (!isset($request['no_rm']) || empty($request['no_rm'])) {
			// }
			$pasien->save();
			
			// INSERT RM
			$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
			$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
			// UPDATEPASIEN
			$rmid = $rms->id;
			$pasi = Pasien::where('id',$pasien->id)->first();
			$cek_pas = Pasien::where('no_rm',$rmid)->first();
			
			if($cek_pas){
				$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
				$rmid = $rms->id;
			}

			if(!empty($request['no_rm'])){
				$pasi->no_rm = $request['no_rm'];
				$pasi->user_create = $pasien->user_create.' - Pasien Tidak terdata (RM MANUAL)';
			}else{
				$pasi->no_rm = $rmid;	
			}
			$pasi->save();
			// if (!isset($request['no_rm']) || empty($request['no_rm'])) {

			// }
			

			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = $pasien->id;
			$reg->input_from = 'regperjanjian_baru';
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->antrian_poli_id = @$antrian->id;
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->nomorantrian = @$request['nomorantrian'];
			$reg->nomorantrian_jkn = @$nomorantri;
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
			if($request['status_reg'] == 'I1'){
				$request['status_reg'] = 'J1';
			}
			$reg->status_reg = 'J1';
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
			$reg->save();

			if(satusehat()) {
                if (Satusehat::find(1)->aktif == 1) {
                    if($reg->status_reg == 'J1'){
                        $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'registrasi-perjanjian');
                        $reg->save();
                    }
                }
            }

			// Jika Billing MCU di centang
			if(isset($request['billing_mcu'])){
				// Paket MCU yang dipilih
				if (isset($request['paket_mcu'])) {
					$tarif = [];
					$biaya = BiayaMcu::with('detail')->find($request['paket_mcu']);
					if(count($biaya->detail) >0){
						foreach($biaya->detail as $i){
							$tarif[] = $i->tarif_id;
						}
					}

					if (cek_status_reg($request['status_reg']) == 'G' || $reg->status_reg == 'I1' ||$reg->status_reg == 'I2'||$reg->status_reg == 'I3') {
						$pelaksana_tipe = 'TG';
					} else {
						$pelaksana_tipe = 'TA';
					}
					foreach($tarif as $key=>$value){
						$created_at = date('Y-m-d H:i:s');
						$tarifObj  = Tarif::where('id', $value)->first();
						FolioMulti::create([
							'registrasi_id'    => @$reg->id,
							'poli_id'          => @$reg->poli_id,
							'lunas'            => 'N',
							'namatarif'        => @$tarifObj->nama,
							'dijamin'          => @$request['dijamin'],
							'tarif_id'         => @$tarifObj->id,
							'cara_bayar_id'    => @$reg->bayar,
							'jenis'            => @$tarifObj->jenis,
							'poli_tipe'        => cek_status_reg($request['status_reg']),
							'total'            => @$tarifObj->total,
							'jenis_pasien'     => @$reg->jenis_pasien,
							'pasien_id'        => @$reg->pasien_id,
							'dokter_id'        => $reg->dokter_id,
							'user_id'          => Auth::user()->id,
							'mapping_biaya_id' => @$tarifObj->mapping_biaya_id,
							'dpjp'             => @$reg->dokter_id,
							'dokter_pelaksana' => @$reg->dokter_id,
							'pelaksana_tipe'   => @$pelaksana_tipe,
							'created_at'       => @$created_at
						]);
					}

					$tarifMCU = [];
					if (count($biaya->detail) > 0) {
						foreach ($biaya->detail as $i) {
							if ($i->jenis === 'LAB') {
								$tarifMCU[] = [
									'tarif_id' => $i->tarif_id,
									'cito' => '0'
								];
							}
						}
					}
					// Simpan ke HistoriOrderLab
					$histori = new HistoriOrderLab();
					$histori->registrasi_id = $reg->id;
					$histori->unit = 'jalan';
					$histori->user_id = Auth::user()->id;
					$histori->tarif_id = json_encode($tarifMCU);
					$histori->save();
				}
			}

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
			
			// if($request['bayar'] == 2){ //jika pembayaran umum
			// 	$new_noantri = date('dmY').sprintf("%04s", 0);
			// 	$noantri = Registrasi::where('nomorantrian','like',(int)date('dmY') . '%')->count();
			// 	// dd($noantri);
			// 	if($noantri > 0){
			// 		$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
			// 	}else{
			// 		$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
			// 	}
			// 	// $nomorantrian = 136202201;
				
			// 	$ID = config('app.consid_antrean');
			// 	date_default_timezone_set('Asia/Jakarta');
			// 	$t = time();
			// 	$data = "$ID&$t";
			// 	$secretKey = config('app.secretkey_antrean');
			// 	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
				
			// 	$kuotaJKN = Poli::where('bpjs',baca_bpjs_poli($reg->poli_id))->first()->kuota; 
			// 	$nomor = substr($nomorantrian,-4); 
					
			// 	$pasienbaru = $request['no_rm'] ? 0 : 1;

			// 	$bayar = $reg->bayar == '1' ? 'JKN' : 'NON JKN';
			// 	$estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
			// 	@$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
			// 	@$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
				
			// 	// if(empty($reg->nomorantrian)){
			// 	$reg->nomorantrian = $nomorantrian;
			// 	$reg->save();
			// 	// }else{
			// 	// 	$reg->nomorantrian;
			// 	// }

			// 	$req   = '{
			// 		"kodebooking": "'.$nomorantrian.'",
			// 		"jenispasien": "'.$bayar.'",
			// 		"nomorkartu": "'.$request['no_bpjs'].'",
			// 		"nik": "'.@$request['nik'].'",
			// 		"nohp": "'.@$request['nohp'].'",
			// 		"kodepoli": "'.@baca_bpjs_poli(@$request['poli_id']).'",
			// 		"namapoli": "'.baca_poli(@$request['poli_id']).'", 
			// 		"pasienbaru": "'.$pasienbaru.'",
			// 		"norm": "'.$pasien->no_rm.'",
			// 		"tanggalperiksa": "'.date('Y-m-d').'", 
			// 		"kodedokter": "'.baca_dokter_kode($request['dokter_id']).'", 
			// 		"namadokter": "'.baca_dokter_bpjs(baca_dokter_kode($request['dokter_id'])).'",
			// 		"jampraktek": "'.($jam_start.'-'.$jam_end).'",
			// 		"jeniskunjungan": "1",
			// 		"nomorreferensi": "'.@$request['no_rujukan'].'",
			// 		"nomorantrean": "'.$nomor.'",
			// 		"angkaantrean": "'.(int) $nomor.'",
			// 		"estimasidilayani": "'.$estimasi.'",
			// 		"sisakuotajkn":"'.$kuotaJKN.'",
			// 		"kuotajkn": "'.$kuotaJKN.'",
			// 		"sisakuotanonjkn": "0",
			// 		"kuotanonjkn": "0",
			// 		"keterangan": "'.@$request['keterangan'].'"
			// 	}';
			// 	// dd([$req]);
				
			// 	// dd($req);
			// 	$completeurl = config('app.antrean_url_web_service')."antrean/add";
			// 	$session = curl_init($completeurl);
			// 	// dd($completeurl);
			// 	$arrheader = array(
			// 		'X-cons-id: ' . $ID,
			// 		'X-timestamp: ' . $t,
			// 		'X-signature: ' . $signature,
			// 		'user_key:'. config('app.user_key_antrean'),
			// 		'Content-Type: application/json',
			// 	);
				
			// 	// dd(json_decode($body_prb));
			// 	curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			// 	curl_setopt($session, CURLOPT_POSTFIELDS, $req);
			// 	curl_setopt($session, CURLOPT_POST, TRUE);
			// 	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			// 	$response = curl_exec($session);
			// 	$sml = json_decode($response, true);
			// 	// dd($sml); 
			// 	if($sml['metadata']['code'] == '201' && $sml['metadata']['message'] != 'missing data'){
			// 		Flashy::error($sml['metadata']['message']);
			// 		return redirect()->back()->withInput(Input::all());
			// 	}
			// 	if($sml['metadata']['code'] == '200' || $sml['metadata']['code'] == '208'){

			// 		// Update waktu 1
			// 		$updatewaktu   = '{
			// 			"kodebooking": "'.$nomorantrian.'",
			// 			"taskid": 1,
			// 			"waktu": "'.round(microtime(true) * 1000).'"
			// 		}';
			// 		$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
			// 		$session2 = curl_init($completeurl2);
			// 		curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			// 		curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
			// 		curl_setopt($session2, CURLOPT_POST, TRUE);
			// 		curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			// 		$response2 = curl_exec($session2);
			// 		$sml2 = json_decode($response2, true);  

			// 		sleep(2);
			// 			// run task_id2
			// 			$updatewaktu2   = '{
			// 				"kodebooking": "'.$nomorantrian.'",
			// 				"taskid": 2,
			// 				"waktu": "'.round(microtime(true) * 1000).'"
			// 				}';
			// 				$session3 = curl_init($completeurl2);
			// 				curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
			// 				curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
			// 				curl_setopt($session3, CURLOPT_POST, TRUE);
			// 				curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
			// 				$response3 = curl_exec($session3);
			// 				$sml3 = json_decode($response3, true); 
			// 	}else{
			// 	}
			// }

			if(isset($request['reg_online']) == '1'){
				$regdum = RegistrasiDummy::where('jenis_registrasi','antrian')->where('nomorantrian',@$request['nomorantrian'])->first();
				if($regdum){
					$regdum->status = 'terdaftar';
					$regdum->save();
				}

			}

			DB::commit();
			$cek_rmss = Nomorrm::where('pasien_id',$pasien->id)->orderBy('id','DESC')->first();
				if($cek_rmss){
					if($pasien->no_rm !== $cek_rmss->id){
						$up_pas = Pasien::where('id',$pasien->id)->first();
						$up_pas->no_rm = $cek_rmss->id;
						$up_pas->save();
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
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Registrasi Data');
			return redirect('regperjanjian');
		} 
		
	}

	public function savePerjanjianPasienLama(Request $request, $id) {
		// dd($request->all());
		request()->validate([
			'created_at' => 'required',
			'poli_id' => 'required',
			'dokter_id' => 'required',
		]);
		DB::beginTransaction();
        try{
			$poli = Poli::find($request->poli_id);
			$dokters = Pegawai::find($request->dokter_id);
			$find = Antrian::find(isset($request['antrian_id']) ? $request['antrian_id'] : null); // find antrian
			
			// if($find){
				if (!empty($request['created_at'])) {
					$tgl = date(valid_date($request['created_at']));
				}else{
					$tgl = date('Y-m-d');
				}

				// CEK JIKA TIDAK POLI EKSEKUTIF TIDAK BISA REGIS LEBIH DARI 1x
				if($request['poli_id'] !== "42"){
					if ($this->cekToday($id, $request['poli_id'],$tgl) > 0) { 
						Flashy::info('Sudah terdaftar ditanggal dan poli yang sama');
						return redirect()->back();
					}
				}

				// CEK ANTRIAN NEW
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
					$nomor = $cekantrian;
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
				$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
				$pasien->no_rm = $rms->id;
				// $pasi->save();
			}
			$pasien->nama = $request['nama'];
			
			if($request['nik']){
				$pasien->nik = $request['nik'];
			}

			// dd($nomorantri);

			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
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
			$reg->input_from = 'regperjanjian_lama';
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->antrian_poli_id = @$antrian->id;
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->rujukan = $request['rujukan'];
			$reg->pengirim_rujukan = $request['pengirim_rujukan'];
			$reg->nomorantrian = @$request['nomorantrian'];
			$reg->nomorantrian_jkn = @$nomorantri;
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
			if($request['status_reg'] == 'I1'){
				$request['status_reg'] = 'J1';
			}
			$reg->status_reg = 'J1';
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
			
			if(satusehat()) {
                if (Satusehat::find(1)->aktif == 1) {
                    if($reg->status_reg == 'J1'){
                        $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'registrasi-perjanjian');
                        $reg->save();
                    }
                }
            }

			// Jika Billing MCU di centang
			if(isset($request['billing_mcu'])){
				// Paket MCU yang dipilih
				if (isset($request['paket_mcu'])) {
					$tarif = [];
					$biaya = BiayaMcu::with('detail')->find($request['paket_mcu']);
					if(count($biaya->detail) >0){
						foreach($biaya->detail as $i){
							$tarif[] = $i->tarif_id;
						}
					}

					if (cek_status_reg($request['status_reg']) == 'G' || $reg->status_reg == 'I1' ||$reg->status_reg == 'I2'||$reg->status_reg == 'I3') {
						$pelaksana_tipe = 'TG';
					} else {
						$pelaksana_tipe = 'TA';
					}
					foreach($tarif as $key=>$value){
						$created_at = date('Y-m-d H:i:s');
						$tarifObj  = Tarif::where('id', $value)->first();
						FolioMulti::create([
							'registrasi_id'    => @$reg->id,
							'poli_id'          => @$reg->poli_id,
							'lunas'            => 'N',
							'namatarif'        => @$tarifObj->nama,
							'dijamin'          => @$request['dijamin'],
							'tarif_id'         => @$tarifObj->id,
							'cara_bayar_id'    => @$reg->bayar,
							'jenis'            => @$tarifObj->jenis,
							'poli_tipe'        => cek_status_reg($request['status_reg']),
							'total'            => @$tarifObj->total,
							'jenis_pasien'     => @$reg->jenis_pasien,
							'pasien_id'        => @$reg->pasien_id,
							'dokter_id'        => $reg->dokter_id,
							'user_id'          => Auth::user()->id,
							'mapping_biaya_id' => @$tarifObj->mapping_biaya_id,
							'dpjp'             => @$reg->dokter_id,
							'dokter_pelaksana' => @$reg->dokter_id,
							'pelaksana_tipe'   => @$pelaksana_tipe,
							'created_at'       => @$created_at
						]);
					}

					$tarifMCU = [];
					if (count($biaya->detail) > 0) {
						foreach ($biaya->detail as $i) {
							if ($i->jenis === 'LAB') {
								$tarifMCU[] = [
									'tarif_id' => $i->tarif_id,
									'cito' => '0'
								];
							}
						}
					}
					// Simpan ke HistoriOrderLab
					$histori = new HistoriOrderLab();
					$histori->registrasi_id = $reg->id;
					$histori->unit = 'jalan';
					$histori->user_id = Auth::user()->id;
					$histori->tarif_id = json_encode($tarifMCU);
					$histori->save();
				}
			}

			// JIKA BILLING DICENTANG
			if(isset($request['billing'])){
				$retri = [];
				// dd('B');
				if(!$request['status_reg']){
					$request['status_reg'] == 'J';
				}
				// CEK RETRIBUSI PASIEN BARU 
				$retri1 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_lama')->whereNull('poli_id')->get();
				if(count($retri1) >0){
					foreach($retri1 as $i){
						$retri[] = $i->tarif_id;
					}
				}
				// CEK RETRIBUSI PASIEN BARU SESUAI POLI
				$retri2 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_lama')->where('poli_id',$request->poli_id)->get();
				if(count($retri2) >0){
					foreach($retri2 as $i){
						$retri[] = $i->tarif_id;
					}
				}

				// dd($retri);

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
							'catatan'          => 'reg_perj_lama'
						]);
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
			if($request['bayar'] == 2){ //jika pembayaran umum
				$new_noantri = date('dmY').sprintf("%04s", 0);
				$noantri = Registrasi::where('nomorantrian','like',(int)date('dmY') . '%')->count();
				// dd($noantri);
				if($noantri > 0){
					$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
				}else{
					$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
				}
				// $nomorantrian = 136202201;
				
				// $ID = config('app.consid_antrean');
				// date_default_timezone_set('Asia/Jakarta');
				// $t = time();
				// $data = "$ID&$t";
				// $secretKey = config('app.secretkey_antrean');
				// $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
				
				// $kuotaJKN = Poli::where('bpjs',baca_bpjs_poli($reg->poli_id))->first()->kuota; 
				// $nomor = substr($nomorantrian,-4); 
					
				// $pasienbaru = $request['no_rm'] ? 0 : 1;

				// $bayar = $reg->bayar == '1' ? 'JKN' : 'NON JKN';
				// $estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
				// @$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
				// @$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
				
				// // if(empty($reg->nomorantrian)){
				// $reg->nomorantrian = $nomorantrian;
				// $reg->save();
				// // }else{
				// // 	$reg->nomorantrian;
				// // }

				// $req   = '{
				// 	"kodebooking": "'.$nomorantrian.'",
				// 	"jenispasien": "'.$bayar.'",
				// 	"nomorkartu": "'.$request['no_bpjs'].'",
				// 	"nik": "'.@$request['nik'].'",
				// 	"nohp": "'.@$request['nohp'].'",
				// 	"kodepoli": "'.@baca_bpjs_poli(@$request['poli_id']).'",
				// 	"namapoli": "'.baca_poli(@$request['poli_id']).'", 
				// 	"pasienbaru": "'.$pasienbaru.'",
				// 	"norm": "'.$pasien->no_rm.'",
				// 	"tanggalperiksa": "'.date('Y-m-d').'", 
				// 	"kodedokter": "'.baca_dokter_kode($request['dokter_id']).'", 
				// 	"namadokter": "'.baca_dokter_bpjs(baca_dokter_kode($request['dokter_id'])).'",
				// 	"jampraktek": "'.($jam_start.'-'.$jam_end).'",
				// 	"jeniskunjungan": "1",
				// 	"nomorreferensi": "'.@$request['no_rujukan'].'",
				// 	"nomorantrean": "'.$nomor.'",
				// 	"angkaantrean": "'.(int) $nomor.'",
				// 	"estimasidilayani": "'.$estimasi.'",
				// 	"sisakuotajkn":"'.$kuotaJKN.'",
				// 	"kuotajkn": "'.$kuotaJKN.'",
				// 	"sisakuotanonjkn": "0",
				// 	"kuotanonjkn": "0",
				// 	"keterangan": "'.@$request['keterangan'].'"
				// }';
				// // dd([$req]);
				
				// // dd($req);
				// $completeurl = config('app.antrean_url_web_service')."antrean/add";
				// $session = curl_init($completeurl);
				// // dd($completeurl);
				// $arrheader = array(
				// 	'X-cons-id: ' . $ID,
				// 	'X-timestamp: ' . $t,
				// 	'X-signature: ' . $signature,
				// 	'user_key:'. config('app.user_key_antrean'),
				// 	'Content-Type: application/json',
				// );
				
				// // dd(json_decode($body_prb));
				// curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
				// curl_setopt($session, CURLOPT_POSTFIELDS, $req);
				// curl_setopt($session, CURLOPT_POST, TRUE);
				// curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
				// $response = curl_exec($session);
				// $sml = json_decode($response, true);
				// // dd($sml); 
				// if($sml['metadata']['code'] == '201' && $sml['metadata']['message'] != 'missing data'){
				// 	Flashy::error($sml['metadata']['message']);
				// 	return redirect()->back()->withInput(Input::all());
				// }
				// if($sml['metadata']['code'] == '200' || $sml['metadata']['code'] == '208'){

				// 	// Update waktu 1
				// 	$updatewaktu   = '{
				// 		"kodebooking": "'.$nomorantrian.'",
				// 		"taskid": 1,
				// 		"waktu": "'.round(microtime(true) * 1000).'"
				// 	}';
				// 	$completeurl2 = config('app.antrean_url_web_service')."antrean/updatewaktu";
				// 	$session2 = curl_init($completeurl2);
				// 	curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				// 	curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				// 	curl_setopt($session2, CURLOPT_POST, TRUE);
				// 	curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				// 	$response2 = curl_exec($session2);
				// 	$sml2 = json_decode($response2, true);  

				// 	sleep(2);
				// 		// run task_id2
				// 		$updatewaktu2   = '{
				// 			"kodebooking": "'.$nomorantrian.'",
				// 			"taskid": 2,
				// 			"waktu": "'.round(microtime(true) * 1000).'"
				// 			}';
				// 			$session3 = curl_init($completeurl2);
				// 			curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
				// 			curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
				// 			curl_setopt($session3, CURLOPT_POST, TRUE);
				// 			curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
				// 			$response3 = curl_exec($session3);
				// 			$sml3 = json_decode($response3, true); 
				// }else{
				// }
			}


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

	// ============= VIEW ============================================================
	public function antrianPerjanjian($tgl = '', $poli_id = '', Request $request) {
		if ($request->filter == "true") {
			$data['pasien'] = new Registrasi();
			if (!empty($tgl)) {
				$data['pasien'] = $data['pasien']->where('created_at', 'LIKE', date($tgl) . '%');
			}
			if (!empty($poli_id)) {
				$data['pasien'] = $data['pasien']->where('poli_id', $poli_id);
			}
			if (!empty($request->no_rm)) {
				$pasien = Pasien::where('no_rm', $request->no_rm)->first();
				$data['pasien'] = $data['pasien']->where('pasien_id', $pasien->id);
			}

			$data['pasien'] = $data['pasien']->get();
		} else {
			$data['pasien'] = [];
		}
		$data['poli'] = Poli::select('nama', 'id')->get();
		$data['no'] = 1;
		return view('reg-perjanjian.daftarperjanjian', $data);
	}

	public function cariAntrian(Request $req) {
		if (!$req->no_rm) {
			request()->validate(['tgl' => 'required', 'poli_id' => 'required']);
		}
		return redirect('daftar-perjanjian/' . valid_date($req['tgl']) . '/' . $req['poli_id'] . '?filter=true&no_rm=' . $req['no_rm']);
	}

	public function hapusAntrian($id, $tgl, $poli_id) {
		HistorikunjunganIRJ::where('registrasi_id',$id)->delete();
		Registrasi::find($id)->delete();
		Flashy::success('Daftar Antrian Sukses Dihapus');
		return redirect('daftar-perjanjian/' . $tgl . '/' . $poli_id);
	}
	public function cekToday($pasien_id, $poli_id,$tgl) {
		$reg = Registrasi::where('pasien_id', $pasien_id)->where('poli_id', $poli_id)->where('created_at', 'LIKE', $tgl . '%')->count();
		return $reg;
	}
}
