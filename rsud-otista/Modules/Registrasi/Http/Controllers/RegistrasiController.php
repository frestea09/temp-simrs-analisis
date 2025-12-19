<?php
namespace Modules\Registrasi\Http\Controllers;

use App\AntrianPoli;
use App\FolioMulti;
use Modules\Antrian\Entities\Antrian;
use App\histori_kunjungan_ambl;
use App\histori_kunjungan_jnz;
use App\HistorikunjunganIGD;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use App\Nomorrm;
use Auth;
use Validator;
use DB;
use Flashy;
use Illuminate\Http\Request;
use App\HistorikunjunganRM;
use Illuminate\Routing\Controller;
use Modules\Config\Entities\Config;
use Modules\Icd10\Entities\Icd10;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\Province;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Perusahaan\Entities\Perusahaan;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\BiayaMcu;
use Modules\Registrasi\Entities\Status;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Tarif\Entities\Tarif;
use App\Pasienlangsung;
use App\HistorikunjunganLAB;
use App\HistorikunjunganRAD;
use App\Http\Controllers\SatuSehatController;
use App\Http\Controllers\SatuSehatIGDController;
use Modules\Jenisjkn\Entities\Jenisjkn;
use App\PengirimRujukan;
use App\Satusehat;
use App\EmrInapPemeriksaan;
use Modules\Registrasi\Entities\BiayaPemeriksaan;
use Carbon\Carbon;

class RegistrasiController extends Controller {
	public function index() {
		return view('registrasi::index');
	}

	//pasien JKN
	public function create($id = null) {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		$data['provinsi']   = Province::pluck('name', 'id');
		$data['pekerjaan']  = Pekerjaan::pluck('nama', 'id');
		$data['agama']      = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status']     = Status::pluck('status', 'id');
		$data['carabayar']  = Carabayar::pluck('carabayar', 'id');
		$data['rujukan']    = Rujukan::pluck('nama', 'id');
		$data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
		$data['tipelayanan']  = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli']       = Poli::select('nama', 'id')->whereIn('politype', ['J'])->get();
		$data['pasien']     = Pasien::find($id);
		$data['reg']        = Registrasi::select('poli_id', 'id')->get();
		$data['dokter']     = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10']      = Icd10::all();
		$data['jenisjkn']   = Jenisjkn::pluck('nama', 'nama');

		if($data['pasien'] != null){
		  $data['id']       = $data['pasien']->id;
		}else{
		  $data['id']       ='';
		}

		return view('registrasi::create', $data);
	}

	public function getKasus($poli_id,$pasien) {
	
		$Kasus['data'] = Registrasi::orderby("poli_id","desc")
                         ->select('id','poli_id')
                         ->where('poli_id',$poli_id)
						 ->where('pasien_id',$pasien)
                         ->get();
        return response()->json($Kasus);
	}
	public function getDokterPoli($poli_id) {
	
		$data = [];
		$poli = Poli::where('id',$poli_id)->first();
		
		// dd($dokter);
		if(!$poli->dokter_id){
			$dokter = Pegawai::where('kategori_pegawai','1')->get(); 
		}else{
			$dokter = Pegawai::whereIn('id',explode (",", $poli->dokter_id))->get();
		}


		// dd($dokter);
		// if($dokter){
		$data[0] = [
			'metadata'=> [
				'code' => 200
			]
		];
		foreach($dokter as $d){
			$data[1][] = [
				'jadwal' => '',
				'namadokter' => $d->nama,
				'kodedokter' => $d->kode_bpjs,
				'id' => $d->id,
			];
			}
		// dd($data);
			// }else{
		// 	$data[0] = [
		// 		'metadata'=> [
		// 			'code' => 201
		// 		]
		// 	];
		// }
        return response()->json($data);
	}
	// public function getDokterPoli($poli_id) {
	
	// 	$data = [];
	// 	$dokter = Pegawai::where('poli_id',$poli_id)->get();
	// 	if(count($dokter) == 0){
	// 		$dokter = Pegawai::where('kategori_pegawai','1')->get(); 
	// 	}
	// 	// dd($dokter);
	// 	// if($dokter){
	// 	$data[0] = [
	// 		'metadata'=> [
	// 			'code' => 200
	// 		]
	// 	];
	// 	foreach($dokter as $d){
	// 		$data[1][] = [
	// 			'jadwal' => '',
	// 			'namadokter' => $d->nama,
	// 			'kodedokter' => $d->kode_bpjs,
	// 			'id' => $d->id,
	// 		];
	// 		}
	// 	// dd($data);
	// 		// }else{
	// 	// 	$data[0] = [
	// 	// 		'metadata'=> [
	// 	// 			'code' => 201
	// 	// 		]
	// 	// 	];
	// 	// }
    //     return response()->json($data);
	// }
	

	public function antrianPoli($poli_id = NULL) {
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', date('Y-m-d') . '%')->count();
		return $poli + 1;
	}

	public function store(SaveRegistrasiRequest $request) {
		//dd(date("Y-m-d"));
		// sleep(rand(1,15));
		// $no = Nomorrm::count() + config('app.no_rm');
		// $no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;

		// $norm = \App\Nomorrm::latest()->first();
		// if($request['no_rm']){
		// 	$cek_pasi_tdk_terdata = Pasien::where('no_rm',$request['no_rm'])->first();
		// 	if ($cek_pasi_tdk_terdata) {
		// 		Flashy::info('No RM  (' . $request['no_rm'] . ') sudah digunakan di dalam aplikasi, seharusnya adalah Pasien Lama Belum Terdata, hubungi Admin!');
		// 		return back();
		// 	}
		// }

		// $cek = Pasien::where('no_rm', $no_rm)->count();
		// if ($cek > 0) {
		// 	Flashy::info('No RM baru (' . $no_rm . ') sdh ada, hubungi Admin!');
		// 	return back();
		// }
		DB::beginTransaction();
		// DB::transaction(function () use ($request) {

					$poli = Poli::find($request['poli_id']);
					$find = Antrian::find(isset($request['antrian_id']) ? $request['antrian_id'] : null); // find antrian
					
					// if($find){
					$count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
					$nomor = $count + 1;
					$suara = $nomor . '.mp3';
					if (!empty($request['tanggal'])) {
						$tgl = valid_date($request['tanggal']);
					}else{
						$tgl = date('Y-m-d');
					}
					$antrian_poli = [
						"nomor" => $nomor,
						"suara" => $suara,
						"status" => 0,
						"panggil" => 1, 
						"poli_id" => $request['poli_id'], 
						"tanggal" => $tgl,
						"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
						"kelompok" => $poli->kelompok
					];
					// GET ANTRIAN POLI ID 
					if($request['status_reg'] == 'J1'){
						//dd("J1");
						$cek_antrian_poli_id = AntrianPoli::where('poli_id',$poli->id)->where('antrian_id',$request['antrian_id'])->first();
						if($cek_antrian_poli_id){
							$antrian = 	$cek_antrian_poli_id;
						}else{
							$antrian = AntrianPoli::create($antrian_poli); 
	
						}
		             }

			// $no = Nomorrm::count() + config('app.no_rm');
			// $no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;
			
			$id_ss = NULL;
			if (Satusehat::find(1)->aktif == 1) {
				if(satusehat()) {
                    $id_ss = SatuSehatController::PatientGet($request->nik);
				}
			}
			// dd(sprintf("%05s", $no_rm));
			// Save data pasien
			$pasien = new Pasien();
			$pasien->nama = strtoupper($request['nama']);
			$pasien->nik = $request['nik'];
			$pasien->mr_id = generateRmId();
			$pasien->tmplahir = strtoupper($request['tmplahir']);
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->id_patient_ss = $id_ss;
			// $pasien->no_rm = sprintf("%06s", $no_rm);
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = strtoupper($request['alamat']);
			$pasien->tgldaftar = date("Y-m-d");
			$pasien->nama_keluarga = $request['namakeluarga'];
			$pasien->hub_keluarga = $request['hubungan'];
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->ibu_kandung = strtoupper($request['ibu_kandung']);
			$pasien->status_marital = $request['status_marital'];
			$pasien->nodarurat = $request['nodarurat'];
			$pasien->no_jkn = $request['no_jkn'];
			$pasien->jkn = $request['jkn'];
			if(!$request['jkn']){
				$pasien->jkn = 'PBI';
			}
			$pasien->user_create = Auth::user()->name;
			$pasien->user_update = '';
			$pasien->save();

			//Save No RM
			$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
			$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
			// UPDATEPASIEN
			$pasi = Pasien::where('id',$pasien->id)->first();
			$rmid = $rms->id;
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
			// 	Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no]);
			// }
			$dokters = Pegawai::find($request->dokter_id);
			$id_ss_encounter =NULL;
			@$cekantrian = hitungAntrolNew($request->dokter_id,$tgl,$poli->bpjs);
			@$hitung =  $cekantrian;
			
			@$tanggalantri =  date("dmY", strtotime($tgl));
			if($dokters->kode_antrian){
				@$kodeantri = $dokters->kode_antrian;
			}else{
				@$kodeantri =$tanggalantri; 
			}
			@$nomorantri = $kodeantri.'-'.$poli->bpjs.''.$hitung;
            
			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->input_from = 'registrasi-1';
			$reg->antrian_poli_id = @$antrian->id;
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->status = $request['status'];
			$reg->rujukan = $request['rujukan'];
            $reg->status_ugd = @json_encode(['caraMasuk' => @$request->cara_masuk]);
			$reg->id_encounter_ss = @$id_ss_encounter;
			$reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
			$reg->rjtl = $request['rjtl'];
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hakkelas = $request['hakkelas'];
			$reg->nomorrujukan = $request['nomorrujukan'];
			$reg->tglrujukan = $request['tglrujukan'];
			$reg->kodeasal = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
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
			$reg->keterangan = $request['keterangan'];
			$reg->status_reg = $request['status_reg'];
			$reg->pengirim_rujukan = $request['pengirim_rujukan'];
			$reg->puskesmas_id = $request['puskesmas_id'];
			$reg->dokter_perujuk_id = $request['dokter_perujuk_id'];
			$reg->nomorantrian_jkn = @$nomorantri;

			if ($request['status_reg'] == 'G1') {
				$reg->status_ugd = $request['status_ugd'];
			}
			$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->no_loket = session('no_loket');
			$reg->antrian_poli = $this->antrianPoli($request['poli_id']);
			if (!empty($request['tanggal'])) {
				// $reg->created_at = valid_date($request['tanggal']);
				$reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
			}
			$reg->save();
            if(satusehat()) {
                if (Satusehat::find(1)->aktif == 1) {
                    if($reg->status_reg == 'J1'){
                        $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'registrasi');
                        $reg->save();
                    }
					if($reg->status_reg == 'G1'){
						$reg->id_encounter_ss = SatuSehatIGDController::EncounterPost($reg->id,'registrasi');
						$reg->save();
					}
                }
            }

			//Jika Pasien IGD Update Triage
			if($reg->status_reg == 'G1'){
				if($request['triage'] != null){
					$triage = EmrInapPemeriksaan::where('id', $request['triage'])->where('type', 'triage-igd')->first();
					if($triage){
						$triage->pasien_id = $pasien->id;
						$triage->registrasi_id = $reg->id;
						$triage->update(); // Update triage dulu baru jalan satusehat

						if(satusehat()) {
							// Data Triage & Gawat Darurat Untuk Satu Sehat
							// 1. Sarana Transportasi Kedatangan
							$triage->id_sarana_transportasi_ss = SatuSehatIGDController::ObservationPostSaranaTransportasi($reg->id);
							// 2. Surat Pengantar Rujukan
							$triage->id_surat_pengantar_rujukan_ss = SatuSehatIGDController::ObservationPostSuratPengantarRujukan($reg->id);
							// 3. Kondisi Pasien Tiba
							$triage->id_kondisi_pasien_tiba_ss = SatuSehatIGDController::ObservationPostKondisiPasienTiba($reg->id);
							// 4. Masuk Ruang Triage
							$reg->id_encounter_ss = SatuSehatIGDController::EncounterPutMasukRuanganTriage($reg->id);
							// Update Encounter Ke Ruangan Tindakan
							$reg->id_encounter_ss = SatuSehatIGDController::EncounterPutMasukRuanganTindakan($reg->id);
							$reg->update();
							// 5. Allergy Intolerance
							$triage->id_allergy_intolerance_ss = SatuSehatIGDController::AllergyIntolerancePost($reg->id);
							$triage->update();
						}
					}
				}
			}

			// JIKA BILLING DICENTANG
			if(isset($request['billing'])){
				$retri = [];
				// dd('B');

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
						'created_at'       => @$created_at
					]);
				}
			}

			if ($request['status_reg'] == 'G1') {
				$jenis = 'TG';
			} elseif ($request['status_reg'] == 'J1') {
				$jenis = 'TA';
			}

			// Insert Biaya Registrasi dan ke Folio
			// if ($request['status_reg'] == 'G1') {
			// 	$biaya = Biayaregistrasi::where('tipe', 'R')->get();
			// } else {
			// 	$biaya = Biayaregistrasi::where('tipe', 'E')->get();
			// }
			// $harus_dibayar = 0;
			// foreach ($biaya as $key => $d) {
			// 	$fol = new Folio();
			// 	$fol->registrasi_id = $reg->id;
			// 	$fol->namatarif = $d->tarif->nama; //koneksi ke Tarif
			// 	$fol->total = $d->tarif->total; //koneksi ke Tarif
			// 	$fol->tarif_id = $d->tarif->id; //koneksi ke Tarif
			// 	$fol->lunas = 'N';
			// 	$fol->cara_bayar_id = $request['bayar'];
			// 	if ($request['status_reg'] == 'G1') {
			// 		$fol->poli_tipe = 'G';
			// 	} elseif ($request['status_reg'] == 'J1') {
			// 		$fol->poli_tipe = 'J';
			// 	}

			// 	$fol->jenis = $jenis;
			// 	$fol->pasien_id = $pasien->id;
			// 	$fol->dokter_id = $reg->dokter_id;
			// 	$fol->poli_id = $reg->poli_id;
			// 	$fol->user_id = Auth::user()->id;
			// 	$fol->save();
			// 	$harus_dibayar += $d->tarif->total;
			// }

			// $harus_dibayar;

			// // Insert ke Tagihan
			// $tag = new Tagihan();
			// $tag->user_id = Auth::user()->id;
			// $tag->registrasi_id = $reg->id;
			// $tag->dokter_id = $reg->dokter_id;
			// $tag->diskon = 0;
			// $tag->pasien_id = $pasien->id;
			// $tag->harus_dibayar = $harus_dibayar;
			// $tag->subsidi = 0;
			// $tag->dijamin = 0;
			// $tag->selisih_positif = 0;
			// $tag->selisih_negatif = 0;
			// $tag->approval_tanggal = date('Y-m-d');
			// $tag->user_approval = '';
			// $tag->pembulatan = 0;
			// $tag->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = null;
			$history->user_id = Auth::user()->id;
			$history->pengirim_rujukan = $request['pengirim_rujukan'];
			$history->save();

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->pengirim_rujukan = $request['pengirim_rujukan'];
			if ($request['status_reg'] == 'G1') {
				$hp->politipe = 'G';
			} elseif ($request['status_reg'] == 'J1') {
				$hp->politipe = 'J';
			}
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			if ($request['status_reg'] == 'G1') {
				//IGD
				$igd = new HistorikunjunganIGD();
				$igd->registrasi_id = $reg->id;
				$igd->pasien_id = $pasien->id;
				$igd->triage_nama = baca_poli($request['poli_id']);
				$igd->dokter_id = @$request['dokter_id'];
				$igd->doa = 'N';
				$igd->user = Auth::user()->name;
				$igd->pengirim_rujukan = $request['pengirim_rujukan'];
				$igd->save();
			} elseif ($request['status_reg'] == 'J1') {
				//IRJ
				$irj = new HistorikunjunganIRJ();
				$irj->registrasi_id = $reg->id;
				$irj->pasien_id = $pasien->id;
				$irj->poli_id = $request['poli_id'];
				$irj->dokter_id = $request['dokter_id'];
				$irj->user = Auth::user()->name;
				$irj->pengirim_rujukan = $request['pengirim_rujukan'];
				$irj->save();
			}

			session(['pasienID' => $pasien->id, 'reg_id' => $reg->id]);

			
				// else{
				// 	$rmss = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
				// 	$pasien->no_rm = $rmss->id;
				// 	$pasien->save();
				// }
				// });
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
			
		// $cek_pas_rm = Pasien::where('no_rm',$rmid)->first();
		// if($cek_pas_rm){
		// 	$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
		// 	$rmid = $rms->id;
		// }

		Flashy::success('Registrasi Sukses..');
		if ($request['bayar'] == 1) {
			return redirect('form-sep/' . session('reg_id'));
		} else {
			if ($request['status_reg'] == 'G1') {
				return redirect('/frontoffice/rawat-darurat');
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
		}
	}

	public function show() {
		$biaya = Biayaregistrasi::find(1);
		$nama  = $biaya->tarif->nama;
		$total = $biaya->tarif->total;
		return $nama . ' ' . $total;
		// return view('registrasi::show');
	}

	public function edit() {
		return view('registrasi::edit');
	}

	public function update(Request $request, $id) {
		request()->validate([
			'no_rm' => 'unique:pasiens,no_rm',
			'nama' => 'required', 
			'tmplahir' => 'required',
			'tgllahir' => 'required|date_format:d-m-Y',
			'kelamin' => 'required',
			'province_id' => 'required',
			'regency_id' => 'required',
			'district_id' => 'required',
			'village_id' => 'required',
			'alamat' => 'required',
			'rt' => 'required',
			'rw' => 'required',
			'nohp' => 'required',
			'pekerjaan_id' => 'required',
			'agama_id' => 'required',
			// 'pendidikan_id' => 'required',
			'ibu_kandung' => 'required',
			'status_marital' => 'required',
			// 'nodarurat' => 'required',
			'kasus' => 'required',
			// 'dokter_id'     => 'required',
			'poli_id' => 'required',
		]);
		// dd(cek_status_reg($request['status_reg']));
		if ($this->cekToday($id, $request['poli_id']) <= 100) {
			// $cekPasien = Pasien::find($id);
			DB::transaction(function () use ($request, $id) {
				
				// dd("A");
				
				// Update Pasien
				$polis	= Poli::find($request['poli_id']);
				$pasien = Pasien::find($id);
				if($request['no_jkn']){
					$pasien->no_jkn = $request['no_jkn'];
					$pasien->save();
				}
				if (empty($pasien->no_rm)) {
					
					$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
					$pasien->no_rm = $rms->id;
				}
				$poli = Poli::find($request['poli_id']);
				$dokters = Pegawai::find($request->dokter_id);
				// if($find){
				// $count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
				// $nomor = $count + 1;
				
				if (!empty($request['tanggal'])) {
					$tgl = valid_date($request['tanggal']);
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
					// $count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
					// $nomor = $count + 1;
					$nomor = $cekantrian;
					$suara = $nomor . '.mp3';
				$antrian_poli = [
					"nomor" => $nomor,
					"suara" => $suara,
					"status" => 0,
					"panggil" => 1, 
					"poli_id" => $request['poli_id'], 
					"tanggal" => $tgl,
					"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
					"kelompok" => $poli->kelompok
				];
				$id_ss = NULL;
                if (Satusehat::find(1)->aktif == 1) {
                    if(satusehat()) {
                        $id_ss = SatuSehatController::PatientGet($request->nik);
                    }
                }
				// GET ANTRIAN POLI ID 
				if($request['status_reg'] == 'J1'){
				//dd("J1");
				$cek_antrian_poli_id = AntrianPoli::where('poli_id',$poli->id)->where('antrian_id',$request['antrian_id'])->first();
				if($cek_antrian_poli_id){
					$antrian = 	$cek_antrian_poli_id;
				}else{
					$antrian = AntrianPoli::create($antrian_poli); 
				}
				}

				$pasien->nama = strtoupper($request['nama']);
				$pasien->nik = $request['nik'];
				$pasien->tmplahir = strtoupper($request['tmplahir']);
				$pasien->tgllahir = valid_date($request['tgllahir']);
				$pasien->kelamin = $request['kelamin'];
				$pasien->province_id = $request['province_id'];
				$pasien->id_patient_ss = $id_ss;
				$pasien->regency_id = $request['regency_id'];
				$pasien->district_id = $request['district_id'];
				$pasien->village_id = $request['village_id'];
				$pasien->alamat = $request['alamat'];
				$pasien->rt = $request['rt'];
				$pasien->rw = $request['rw'];
				$pasien->nohp = $request['nohp'];
				$pasien->negara = 'Indonesia';
				$pasien->pekerjaan_id = $request['pekerjaan_id'];
				$pasien->agama_id = $request['agama_id'];
				$pasien->pendidikan_id = $request['pendidikan_id'];
				$pasien->ibu_kandung = $request['ibu_kandung'];
				$pasien->status_marital = $request['status_marital'];
				$pasien->nodarurat = $request['nodarurat'];
				$pasien->no_jkn = $request['no_jkn'];
				$pasien->jkn = $request['jkn'];
				if(!$request['jkn']){
					$pasien->jkn = 'PBI';
				}
				$pasien->user_update = Auth::user()->name;
				$pasien->update();

				
				$id_ss_encounter = NULL;
				// dd(@$id_ss_encounter);
				// Save registrasi
				$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
				$reg = new Registrasi();
				$reg->input_from = 'registrasi-2';
				$reg->antrian_poli_id = @$antrian->id;
				$reg->id_encounter_ss = @$id_ss_encounter;
				$reg->pasien_id = $pasien->id;
				$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
				$reg->status = $request['status'];
				$reg->rujukan = $request['rujukan'];
                $reg->status_ugd = @json_encode(['caraMasuk' => @$request->cara_masuk]);
				$reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
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
				$reg->keterangan = $request['keterangan'];
				$reg->tipe_jkn = $request['jkn'];
				$reg->no_sep = $request['no_sep'];
				$reg->sebabsakit_id = $request['sebabsakit_id'];
				$reg->bayar = $request['bayar'];
				$reg->no_jkn = $request['no_jkn'];
				$reg->user_create = Auth::user()->id;
				$reg->jenis_pasien = $request['bayar'];
				$reg->posisiberkas_id = '2';
				$reg->pengirim_rujukan = $request['pengirim_rujukan'];
				$reg->puskesmas_id = $request['puskesmas_id'];
				$reg->dokter_perujuk_id = $request['dokter_perujuk_id'];
				$reg->kasus = $request['kasus'];
				$reg->nomorantrian_jkn = @$nomorantri;
				// $reg->status_reg = () ? 'L1' : (() ? 'R1'$request['status_reg']);

				if ($request['status_reg'] == 'G1') {
					if(in_array($polis->politype, ['L', 'R', 'Z', 'B', 'M'])){
						$poli_type = $polis->politype.'1';
						$reg->status_reg = $poli_type;
					}else{
						$reg->status_reg = $request['status_reg'];
					}
				}else{
					$reg->status_reg = $request['status_reg'];
				}
				$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
				$reg->no_loket = session('no_loket');
				$reg->antrian_poli = $this->antrianPoli($request['poli_id']);
				if (!empty($request['tanggal'])) {
					$reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
				}
				$reg->save();

                if(satusehat()) {
					if (Satusehat::find(1)->aktif == 1) {
						if($reg->status_reg == 'J1'){
							$reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'registrasi');
                            $reg->save();
                        }
                        if($reg->status_reg == 'G1'){
							$reg->id_encounter_ss = SatuSehatIGDController::EncounterPost($reg->id,'registrasi');
                            $reg->save();
                        }
                    }
                }

				//Jika Pasien IGD Update Triage
				if($reg->status_reg == 'G1'){
					if($request['triage'] != null){
						$triage = EmrInapPemeriksaan::where('id', $request['triage'])->where('type', 'triage-igd')->first();
						if($triage){
							$triage->pasien_id = $pasien->id;
							$triage->registrasi_id = $reg->id;
							$triage->update(); // Update triage dulu baru jalan satusehat
	
							if(satusehat()) {
								// Data Triage & Gawat Darurat Untuk Satu Sehat
								// 1. Sarana Transportasi Kedatangan
								$triage->id_sarana_transportasi_ss = SatuSehatIGDController::ObservationPostSaranaTransportasi($reg->id);
								// 2. Surat Pengantar Rujukan
								$triage->id_surat_pengantar_rujukan_ss = SatuSehatIGDController::ObservationPostSuratPengantarRujukan($reg->id);
								// 3. Kondisi Pasien Tiba
								$triage->id_kondisi_pasien_tiba_ss = SatuSehatIGDController::ObservationPostKondisiPasienTiba($reg->id);
								// 4. Masuk Ruang Triage
								$reg->id_encounter_ss = SatuSehatIGDController::EncounterPutMasukRuanganTriage($reg->id);
								// Update Encounter Ke Ruangan Tindakan
								$reg->id_encounter_ss = SatuSehatIGDController::EncounterPutMasukRuanganTindakan($reg->id);
								$reg->update();
								// 5. Allergy Intolerance
								$triage->id_allergy_intolerance_ss = SatuSehatIGDController::AllergyIntolerancePost($reg->id);
								$triage->update();
							}
						}
					}
				}
				// JIKA BILLING DICENTANG
				if(isset($request['billing'])){
					$retri = [];
					// dd('B');

					// CEK RETRIBUSI PASIEN LAMA 
					$retri1 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_lama')->whereNull('poli_id')->get();
					if(count($retri1) >0){
						foreach($retri1 as $i){
							$retri[] = $i->tarif_id;
						}
					}
					// CEK RETRIBUSI PASIEN LAMA SESUAI POLI
					$retri2 = BiayaPemeriksaan::where('tipe',cek_status_reg($request['status_reg']))->where('pasien','pasien_lama')->where('poli_id',$request->poli_id)->get();
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
							'created_at'       => @$created_at
						]);
					}
				}
				
				// if($polis->politype)

				if ($request['status_reg'] == 'G1') {
					
					if($polis->politype == 'L'){
						$pasien = new Pasienlangsung();
						$pasien->registrasi_id = $reg->id;
						$pasien->nama = strtoupper($request['nama']);
						$pasien->alamat = $request['alamat'];
						$pasien->politype = $polis->politype;
						$pasien->user_id = Auth::user()->id;
						$pasien->save();

						$hk = new HistorikunjunganLAB();
						$hk->registrasi_id = $reg->id;
						$hk->pasien_id = $pasien->id;
						$hk->poli_id = $request['poli_id'];
						$hk->pasien_asal = 'TG';
						$hk->user = Auth::user()->name;
						$hk->save();
					}elseif($polis->politype == 'R'){
						$pasien = new Pasienlangsung();
						$pasien->registrasi_id = $reg->id;
						$pasien->nama = strtoupper($request['nama']);
						$pasien->alamat = $request['alamat'];
						$pasien->politype = $polis->politype;
						$pasien->user_id = Auth::user()->id;
						$pasien->save();

						$hk = new HistorikunjunganRAD();
						$hk->registrasi_id = $reg->id;
						$hk->pasien_id = $pasien->id;
						$hk->poli_id = $request['poli_id'];
						$hk->pasien_asal = 'TG';
						$hk->user = Auth::user()->name;
						$hk->save();
					}elseif($polis->politype == 'M'){
						$pasien = new Pasienlangsung();
						$pasien->registrasi_id = $reg->id;
						$pasien->nama = strtoupper($request['nama']);
						$pasien->alamat = $request['alamat'];
						$pasien->politype = $polis->politype;
						$pasien->user_id = Auth::user()->id;
						$pasien->save();

						$hk = new HistorikunjunganRM();
						$hk->registrasi_id = $reg->id;
						$hk->pasien_id = $pasien->id;
						$hk->poli_id = $request['poli_id'];
						$hk->pasien_asal = 'TG';
						$hk->user = Auth::user()->name;
						$hk->save();
					}elseif($polis->politype == 'Z'){
						$pasien = new Pasienlangsung();
						$pasien->registrasi_id = $reg->id;
						$pasien->nama = strtoupper($request['nama']);
						$pasien->alamat = $request['alamat'];
						$pasien->politype = $polis->politype;
						$pasien->user_id = Auth::user()->id;
						$pasien->save();

						$hk = new histori_kunjungan_jnz();
						$hk->registrasi_id = $reg->id;
						$hk->pasien_id = $pasien->id;
						$hk->poli_id = $request['poli_id'];
						$hk->pasien_asal = 'TG';
						$hk->user = Auth::user()->name;
						$hk->save();
					}elseif($polis->politype == 'B'){
						$pasien = new Pasienlangsung();
						$pasien->registrasi_id = $reg->id;
						$pasien->nama = strtoupper($request['nama']);
						$pasien->alamat = $request['alamat'];
						$pasien->politype = $polis->politype;
						$pasien->user_id = Auth::user()->id;
						$pasien->save();
						
						$hk = new histori_kunjungan_ambl();
						$hk->registrasi_id = $reg->id;
						$hk->pasien_id = $pasien->id;
						$hk->poli_id = $request['poli_id'];
						$hk->pasien_asal = 'TG';
						$hk->user = Auth::user()->name;
						$hk->save();
					}
					$jenis = 'TG';
				} elseif ($request['status_reg'] == 'J1') {
					$jenis = 'TA';
				}

				// Insert Biaya Registrasi dan ke Folio
				// if ($request['status_reg'] == 'G1') {
				// 	$biaya = Biayaregistrasi::where('tipe', 'R')->get();
				// } else {
				// 	$biaya = Biayaregistrasi::where('tipe', 'E')->get();
				// }
				// $harus_dibayar = 0;
				// foreach ($biaya as $key => $d) {
				// 	$fol = new Folio();
				// 	$fol->registrasi_id = $reg->id;
				// 	$fol->namatarif = $d->tarif->nama; //koneksi ke Tarif
				// 	$fol->total = $d->tarif->total; //koneksi ke Tarif
				// 	$fol->tarif_id = $d->tarif->id; //koneksi ke Tarif
				// 	$fol->lunas = 'N';
				// 	$fol->cara_bayar_id = $request['bayar'];
				// 	if ($request['status_reg'] == 'G1') {
				// 		$fol->poli_tipe = 'G';
				// 	} elseif ($request['status_reg'] == 'J1') {
				// 		$fol->poli_tipe = 'J';
				// 	}
				// 	$fol->jenis = $jenis;
				// 	$fol->pasien_id = $pasien->id;
				// 	$fol->dokter_id = $reg->dokter_id;
				// 	$fol->poli_id = $reg->poli_id;
				// 	$fol->user_id = Auth::user()->id;
				// 	$fol->save();

				// 	$harus_dibayar += $d->tarif->total;
				// }

				// $harus_dibayar;

				// // Insert ke Tagihan
				// $tag = new Tagihan();
				// $tag->user_id = Auth::user()->id;
				// $tag->registrasi_id = $reg->id;
				// $tag->dokter_id = $reg->dokter_id;
				// $tag->diskon = 0;
				// $tag->pasien_id = $pasien->id;
				// $tag->harus_dibayar = $harus_dibayar;
				// $tag->subsidi = 0;
				// $tag->dijamin = 0;
				// $tag->selisih_positif = 0;
				// $tag->selisih_negatif = 0;
				// $tag->approval_tanggal = date('Y-m-d');
				// $tag->user_approval = '';
				// $tag->pembulatan = 0;
				// $tag->save();

				// Insert Histori
				$history = new HistoriStatus();
				$history->registrasi_id = $reg->id;
				$history->status = 'J1';
				$history->poli_id = $reg->poli_id;
				$history->bed_id = null;
				$history->user_id = Auth::user()->id;
				$history->pengirim_rujukan = $request['pengirim_rujukan'];
				$history->save();

				//Insert Histori Pengunjung
				$hp = new Historipengunjung();
				$hp->registrasi_id = $reg->id;
				$hp->pasien_id = $pasien->id;
				$hp->pengirim_rujukan = $request['pengirim_rujukan'];
				if ($request['status_reg'] == 'G1') {
					$hp->politipe = 'G';
				} elseif ($request['status_reg'] == 'J1') {
					$hp->politipe = 'J';
				}
				if ($request['status'] == 1) {
					$hp->status_pasien = 'BARU';
				} else {
					$hp->status_pasien = 'LAMA';
				}
				$hp->user = Auth::user()->name;
				$hp->save();

				//Histori Kunjungan
				if ($request['status_reg'] == 'G1') {
					//IGD
					$igd = new HistorikunjunganIGD();
					$igd->registrasi_id = $reg->id;
					$igd->pasien_id = $pasien->id;
					$igd->triage_nama = baca_poli($request['poli_id']);
					$igd->dokter_id = $request['dokter_id'];
					$igd->doa = 'N';
					$igd->user = Auth::user()->name;
					$igd->pengirim_rujukan = $request['pengirim_rujukan'];
					$igd->save();
				} elseif ($request['status_reg'] == 'J1') {
					//IRJ
					$irj = new HistorikunjunganIRJ();
					$irj->registrasi_id = $reg->id;
					$irj->pasien_id = $pasien->id;
					$irj->poli_id = $request['poli_id'];
					$irj->dokter_id = $request['dokter_id'];
					$irj->user = Auth::user()->name;
					$irj->pengirim_rujukan = $request['pengirim_rujukan'];
					$irj->save();
				}

				session(['pasienID' => $pasien->id, 'no_rm' => $pasien->no_rm, 'noka' => $reg->no_jkn, 'reg_id' => $reg->id]);
			});

			session()->forget('igdlama');
			Flashy::success('Proses Registrasi Sukses');
			if ($request['bayar'] == 1) {
				return redirect('form-sep/' . session('reg_id'));
			} elseif ($request['bayar'] == 8){ // mandiri inhealth
				return redirect('form-sep-inhealth/' . session('reg_id'));
			} else {
				if ($request['status_reg'] == 'G1') {
					return redirect('/frontoffice/rawat-darurat');
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
			}
		} else {
			if ($request['status_reg'] == 'G1') {
				Flashy::info('Sudah terdaftar hari ini di poli yang sama');
				return redirect('frontoffice/rawat-darurat');
			} else {
				Flashy::info('Sudah terdaftar hari ini di poli yang sama');
				return redirect()->route('antrian.daftarantrian');
			}
		}

	}

	public function search(Request $request) {
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm_lama', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();

		return view('registrasi::index', compact('data', 'keyword'))->with('no', 1);
	}

	public function search_ajax(Request $request) {
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();
		if (count($data) == 0) {
			$searchResult[] = 'No item found';
		} else {
			foreach ($items as $key => $value) {
				$searchResult[] = $value->item;
			}
		}
		return $searchResult;

	}

	// pasien umum

	public function create_umum($id = null) {
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::whereNotIn('id', [1])->get();
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['J'])->Orderby('politype')->get();
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['J', 'M', 'R', 'L'])->orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		//dd($data['id']);
		  if($data['pasien'] != null){
			$data['id']       = $data['pasien']->id;
		  }else{
			$data['id']       ='';
		  }
		return view('registrasi::create_umum', $data);
	}

	//REG IGD JKN
	public function reg_igd_jkn($id = null) {
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
		$data['triage'] = EmrInapPemeriksaan::where('registrasi_id', 0)
			->where('pasien_id', 0)
			->where('type', 'triage-igd')
			->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
			->get();
		$data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->where('satusehat_room', 'N')->Orderby('politype')->get();
		// $data['poli'] = Poli::select('nama', 'id','politype')->whereIn('politype', ['G', 'L', 'R'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		$data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		return view('igd.reg.create', $data);
	}

	public function reg_igd_jkn_lama() {
		session()->forget('igdumum-lama');
		session(['igdlama' => true]);
		return view('registrasi::index');
	}

	public function reg_igd_jkn_blmterdata($id = null) {
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
		$data['triage'] = EmrInapPemeriksaan::where('registrasi_id', 0)
			->where('pasien_id', 0)
			->where('type', 'triage-igd')
			->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
			->get();
		$data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->where('satusehat_room', 'N')->Orderby('politype')->get();
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G', 'R', 'L'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		$data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		return view('igd.reg.create_blmterdata', $data);
	}

	//IGD UMUM
	public function reg_igd_umum($id = null) {
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->where('satusehat_room', 'N')->Orderby('politype')->get();
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G', 'L', 'M', 'R', 'Z', 'B'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		if($data['pasien'] != null){
			$data['id']       = $data['pasien']->id;
		  }else{
			$data['id']       ='';
		  }
		$data['triage'] = EmrInapPemeriksaan::where('registrasi_id', 0)
			->where('pasien_id', 0)
			->where('type', 'triage-igd')
			->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
			->get();

		return view('igd.reg.umum.create_umum', $data);
	}

	public function reg_igd_umum_lama() {
		session()->forget('igdlama');
		session(['igdumum-lama' => true]);
		return view('registrasi::index');
	}

	public function reg_igd_umum_blmterdata($id = null) {
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['pengirim_rujukan'] = PengirimRujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->where('satusehat_room', 'N')->Orderby('politype')->get();
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G', 'L', 'R'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		return view('igd.reg.umum.create_umum_blmterdata', $data);
	}

	public function cekToday($pasien_id, $poli_id) {
		$reg = Registrasi::where('pasien_id', $pasien_id)->where('poli_id', $poli_id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
		return $reg;
	}

	 
	// Store with antrol
	public function storeWithAntrol(SaveRegistrasiRequest $request) {
		// sleep(rand(1,15));
		// $no = Nomorrm::count() + config('app.no_rm');
		// $no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;

		// $norm = \App\Nomorrm::latest()->first();
		// if ($request['no_rm'] > config('app.no_rm')) {
		// 	Flashy::info('No RM  (' . $no_rm . ') seharusnya adalah Pasien Lama Belum Terdata, hubungi Admin!');
		// 	return back();
		// }

		// $cek = Pasien::where('no_rm', $no_rm)->count();
		// if ($cek > 0) {
		// 	Flashy::info('No RM baru (' . $no_rm . ') sdh ada, hubungi Admin!');
		// 	return back();
		// }

		DB::beginTransaction();
        try{
			$poli = Poli::find($request['poli_id']);
			$find = Antrian::find(isset($request['antrian_id']) ? $request['antrian_id'] : null); // find antrian
			
			// if($find){
			$count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
			$nomor = $count + 1;
			$suara = $nomor . '.mp3';
			if (!empty($request['tanggal'])) {
				$tgl = valid_date($request['tanggal']);
			}else{
				$tgl = date('Y-m-d');
			}
			$antrian_poli = [
				"nomor" => $nomor,
				"suara" => $suara,
				"status" => 0,
				"panggil" => 1, 
				"poli_id" => $request['poli_id'], 
				"tanggal" => $tgl,
				"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
				"kelompok" => $poli->kelompok
			];
			// GET ANTRIAN POLI ID 
			$cek_antrian_poli_id = AntrianPoli::where('poli_id',$poli->id)->where('antrian_id',$request['antrian_id'])->first();
			if($cek_antrian_poli_id){
				$antrian = 	$cek_antrian_poli_id;
			}else{
				$antrian = AntrianPoli::create($antrian_poli); 

			}


			// $no = Nomorrm::count() + config('app.no_rm');
			// $no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;
			$id_ss = NULL;
			if (Satusehat::find(1)->aktif == 1) {
                if(satusehat()) {
                    $id_ss = SatuSehatController::PatientGet($request->nik);
                }
            }
			// dd($request->all());
			// dd(sprintf("%05s", $no_rm));
			// Save data pasien
			$pasien = new Pasien();
			$pasien->nama = strtoupper($request['nama']);
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = strtoupper($request['tmplahir']);
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			// $pasien->no_rm = sprintf("%06s", $no_rm);
			$pasien->mr_id = generateRmId();
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = strtoupper($request['alamat']);
			$pasien->tgldaftar = date("Y-m-d");
			$pasien->nama_keluarga = $request['namakeluarga'];
			$pasien->hub_keluarga = $request['hubungan'];
			$pasien->rt = $request['rt'];
			$pasien->id_patient_ss = $id_ss;
			$pasien->rw = $request['rw'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->ibu_kandung = strtoupper($request['ibu_kandung']);
			$pasien->status_marital = $request['status_marital'];
			$pasien->nodarurat = $request['nodarurat'];
			$pasien->no_jkn = $request['no_jkn'];
			$pasien->jkn = $request['jkn'];
			if(!$request['jkn']){
				$pasien->jkn = 'PBI';
			}
			$pasien->user_create = Auth::user()->name;
			$pasien->user_update = '';
			$pasien->save();

			$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
			$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
			// dd($rms);
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
			//Save No RM
			// if (!isset($request['no_rm']) || empty($request['no_rm'])) {
			// 	Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no]);
			// }

			$id_ss_encounter = NULL;
			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->input_from = 'registrasi-3';
			$reg->id_encounter_ss = @$id_ss_encounter;
			$reg->antrian_poli_id = @$antrian->id;
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->status = $request['status'];
			$reg->rujukan = $request['rujukan'];
			$reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
			$reg->rjtl = $request['rjtl'];
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hakkelas = $request['hakkelas'];
			$reg->nomorrujukan = $request['nomorrujukan'];
			$reg->tglrujukan = $request['tglrujukan'];
			$reg->kodeasal = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
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
			$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->no_loket = session('no_loket');
			$reg->antrian_poli = $this->antrianPoli($request['poli_id']);
			if (!empty($request['tanggal'])) {
				$reg->created_at = valid_date($request['tanggal']);
			}
			$reg->save();
            if(satusehat()) {
                if (Satusehat::find(1)->aktif == 1) {
                    if($reg->status_reg == 'J1'){
                        $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'registrasi');
                        $reg->save();
                    }
					if($reg->status_reg == 'G1'){
						$reg->id_encounter_ss = SatuSehatIGDController::EncounterPost($reg->id,'registrasi');
						$reg->save();
					}
                }
            }

			if ($request['status_reg'] == 'G1') {
				$jenis = 'TG';
			} elseif ($request['status_reg'] == 'J1') {
				$jenis = 'TA';
			}
 

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = null;
			$history->user_id = Auth::user()->id;
			$history->pengirim_rujukan = $request['pengirim_rujukan'];
			$history->save();

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->pengirim_rujukan = $request['pengirim_rujukan'];
			if ($request['status_reg'] == 'G1') {
				$hp->politipe = 'G';
			} elseif ($request['status_reg'] == 'J1') {
				$hp->politipe = 'J';
			}
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			if ($request['status_reg'] == 'G1') {
				//IGD
				$igd = new HistorikunjunganIGD();
				$igd->registrasi_id = $reg->id;
				$igd->pasien_id = $pasien->id;
				$igd->triage_nama = baca_poli($request['poli_id']);
				$igd->dokter_id = $request['dokter_id'];
				$igd->doa = 'N';
				$igd->user = Auth::user()->name;
				$igd->pengirim_rujukan = $request['pengirim_rujukan'];
				$igd->save();
			} elseif ($request['status_reg'] == 'J1') {
				//IRJ
				$irj = new HistorikunjunganIRJ();
				$irj->registrasi_id = $reg->id;
				$irj->pasien_id = $pasien->id;
				$irj->poli_id = $request['poli_id'];
				$irj->dokter_id = $request['dokter_id'];
				$irj->user = Auth::user()->name;
				$irj->pengirim_rujukan = $request['pengirim_rujukan'];
				$irj->save();
			}

			session(['pasienID' => $pasien->id, 'reg_id' => $reg->id]);


			$new_noantri = date('dmY').sprintf("%04s", 0);
			$noantri = Registrasi::where('nomorantrian','like',(int)date('dmY') . '%')->count();
			// dd($noantri);
			if($noantri > 0){
				$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
			}else{
				$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
			}
			// dd($nomorantrian);
			// $registrasi_id = !empty($request['registrasi_id']) ? $request['registrasi_id'] : session('reg_id');
			// $reg = Registrasi::find($registrasi_id);
			// dd(baca_bpjs_poli($reg->poli_id));
			
			// $reg->nomorantrian = $nomorantrian;
			// $reg->update();

			// KOMEN FAIQ
			// $ID = config('app.consid_antrean');
			// date_default_timezone_set('UTC');
			// $t = time();
			// $data = "$ID&$t";
			// $secretKey = config('app.secretkey_antrean');
			// $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
			
			// $kuotaJKN = Poli::where('bpjs',baca_bpjs_poli($reg->poli_id))->first()->kuota; 
			// $nomor = substr($nomorantrian,-4); 
				
			// $pasienbaru = $request['no_rm'] ? 0 : 1;

			// // $tgl = $request['tglrujukan'] ? $request['tglrujukan'] : date('Y-m-d');
			// $bayar = $reg->bayar == '1' ? 'JKN' : 'NON JKN';
			// $estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
			// @$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
			// @$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
			
			// // if(empty($reg->nomorantrian)){
			// 	$reg->nomorantrian = $nomorantrian;
			// 	$reg->save();
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
			
			// if($reg->bayar == '1'){
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
			// 		//  dd(['response'=>$sml,'task_id'=>$sml2]);
			// 		// return response()->json(['code'=>$sml['metadata']['code'],'msg' => $reg->nomorantrian,'duplicate'=>'']);
					
			// 	}else{
			// 		// return response()->json(['code'=>$sml['metadata']['code'],'msg' => $sml['metadata']['message'],'duplicate'=>'']);
			// 	}
			// }
			// END KOMEN FAIQ
			
			// dd(['response'=>$sml,'task_id_1'=>$sml2,'task_id_2'=>$sml3]);

			// JIKA BILLING DICENTANG
			if(isset($request['billing'])){
				$retri = [];
				// dd('B');

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
						'created_at'       => @$created_at
					]);
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
						$tarifObj  = Tarif::where('id',$value)->first();
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


			DB::commit();
			$cek_rmss = Nomorrm::where('pasien_id',$pasien->id)->orderBy('id','DESC')->first();
			if($cek_rmss){
				if($pasien->no_rm !== $cek_rmss->id){
					$up_pas = Pasien::where('id',$pasien->id)->first();
					$up_pas->no_rm = $cek_rmss->id;
					$up_pas->save();
				}
			}
			Flashy::success('Registrasi Sukses');

			if ($request['bayar'] == 1) {
				return redirect('form-sep/' . session('reg_id'));
			} else {
				if ($request['status_reg'] == 'G1') {
					return redirect('/frontoffice/rawat-darurat');
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
			}
		}catch(Exception $e){
			DB::rollback();
			session()->forget('reg_id');
			Flashy::info('Gagal Simpan Data');
			return redirect()->back();
		}  
	}

		// Store with antrol
	public function updateWithAntrol(Request $request, $id) {
		//dd('Update');
		
		DB::beginTransaction();
        try{
			if ($this->cekToday($id, $request['poli_id']) <= 0) { 
					// Update Pasien
					$polis	= Poli::find($request['poli_id']);
					$pasien = Pasien::find($id);
					$dokters = Pegawai::find($request->dokter_id);

					if($request['no_jkn']){
						$pasien->no_jkn = $request['no_jkn'];
						$pasien->save();
					}
					// if (empty($pasien->no_rm)) {
						// sleep(rand(1,15));
						// $no_rm = Nomorrm::count() + config('app.no_rm');
						// Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no_rm]);
						// $pasien->no_rm = sprintf("%06s", $no_rm);
					// }
					if (empty($pasien->no_rm)) {
						$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
						$pasien->no_rm = $rms->id;
					}
					if (!empty($request['tanggal'])) {
						$tgl = valid_date($request['tanggal']);
					}else{
						$tgl = date('Y-m-d');
					}
					$poli = Poli::find($request['poli_id']);
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
					// $count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
					// $nomor = $count + 1;
					$nomor = $cekantrian;
					$suara = $nomor . '.mp3';
					
					$antrian_poli = [
						"nomor" => $nomor,
						"suara" => $suara,
						"status" => 0,
						"panggil" => 1, 
						"poli_id" => $request['poli_id'], 
						"tanggal" => $tgl,
						"loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
						"kelompok" => $poli->kelompok
					];
					$id_ss = NULL;
					if (Satusehat::find(1)->aktif == 1) {
                        if(satusehat()) {
                            $id_ss = SatuSehatController::PatientGet($request->nik);
                        }
                    }

					// GET ANTRIAN POLI ID 
					$cek_antrian_poli_id = AntrianPoli::where('poli_id',$poli->id)->where('antrian_id',$request['antrian_id'])->first();
					if($cek_antrian_poli_id){
						$antrian = 	$cek_antrian_poli_id;
					}else{
						$antrian = AntrianPoli::create($antrian_poli); 

					}
	
					$pasien->nama = strtoupper($request['nama']);
					$pasien->nik = $request['nik'];
					$pasien->tmplahir = strtoupper($request['tmplahir']);
					$pasien->tgllahir = valid_date($request['tgllahir']);
					$pasien->kelamin = $request['kelamin'];
					$pasien->province_id = $request['province_id'];
					$pasien->regency_id = $request['regency_id'];
					$pasien->district_id = $request['district_id'];
					$pasien->village_id = $request['village_id'];
					$pasien->alamat = $request['alamat'];
					$pasien->id_patient_ss = $id_ss;
					$pasien->rt = $request['rt'];
					$pasien->rw = $request['rw'];
					$pasien->nohp = $request['nohp'];
					$pasien->negara = 'Indonesia';
					$pasien->pekerjaan_id = $request['pekerjaan_id'];
					$pasien->agama_id = $request['agama_id'];
					$pasien->pendidikan_id = $request['pendidikan_id'];
					$pasien->ibu_kandung = $request['ibu_kandung'];
					$pasien->status_marital = $request['status_marital'];
					$pasien->nodarurat = $request['nodarurat'];
					$pasien->no_jkn = $request['no_jkn'];
					$pasien->jkn = $request['jkn'];
					if(!$request['jkn']){
						$pasien->jkn = 'PBI';
					}
					$pasien->user_update = Auth::user()->name;
					$pasien->update();

					
					
				    $id_ss_encounter = NULL;
					// Save registrasi
					$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
					$reg = new Registrasi();
					$reg->id_encounter_ss = @$id_ss_encounter;
					$reg->input_from = 'registrasi-4';
					$reg->antrian_poli_id = @$antrian->id;
					$reg->pasien_id = $pasien->id;
					$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
					$reg->status = $request['status'];
					$reg->rujukan = $request['rujukan'];
					$reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
					$reg->rjtl = $request['rjtl'];
					$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
					$reg->hakkelas = $request['hakkelas'];
					$reg->nomorrujukan = $request['nomorrujukan'];
					$reg->nomorantrian_jkn = @$nomorantri;
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
					$reg->pengirim_rujukan = $request['pengirim_rujukan'];
					$reg->puskesmas_id = $request['puskesmas_id'];
					$reg->dokter_perujuk_id = $request['dokter_perujuk_id'];
					$reg->kasus = $request['kasus'];
					// $reg->status_reg = () ? 'L1' : (() ? 'R1'$request['status_reg']);
	
					if ($request['status_reg'] == 'G1') {
						if(in_array($polis->politype, ['L', 'R', 'Z', 'B', 'M'])){
							$poli_type = $polis->politype.'1';
							$reg->status_reg = $poli_type;
						}else{
							$reg->status_reg = $request['status_reg'];
						}
					}else{
						$reg->status_reg = $request['status_reg'];
					}
					$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
					$reg->no_loket = session('no_loket');
					$reg->antrian_poli = $this->antrianPoli($request['poli_id']);
					if (!empty($request['tanggal'])) {
						$reg->created_at = valid_date($request['tanggal']);
					}
					$reg->save();
                    if(satusehat()) {
                        if (Satusehat::find(1)->aktif == 1) {
                            if($reg->status_reg == 'J1'){
                                $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id,'registrasi');
                                $reg->save();
                            }
							if($reg->status_reg == 'G1'){
								$reg->id_encounter_ss = SatuSehatIGDController::EncounterPost($reg->id,'registrasi');
								$reg->save();
							}
                        }
                    }
					
					// if($polis->politype)
	
					if ($request['status_reg'] == 'G1') {
						
						if($polis->politype == 'L'){
							$pasien = new Pasienlangsung();
							$pasien->registrasi_id = $reg->id;
							$pasien->nama = strtoupper($request['nama']);
							$pasien->alamat = $request['alamat'];
							$pasien->politype = $polis->politype;
							$pasien->user_id = Auth::user()->id;
							$pasien->save();
	
							$hk = new HistorikunjunganLAB();
							$hk->registrasi_id = $reg->id;
							$hk->pasien_id = $pasien->id;
							$hk->poli_id = $request['poli_id'];
							$hk->pasien_asal = 'TG';
							$hk->user = Auth::user()->name;
							$hk->save();
						}elseif($polis->politype == 'R'){
							$pasien = new Pasienlangsung();
							$pasien->registrasi_id = $reg->id;
							$pasien->nama = strtoupper($request['nama']);
							$pasien->alamat = $request['alamat'];
							$pasien->politype = $polis->politype;
							$pasien->user_id = Auth::user()->id;
							$pasien->save();
	
							$hk = new HistorikunjunganRAD();
							$hk->registrasi_id = $reg->id;
							$hk->pasien_id = $pasien->id;
							$hk->poli_id = $request['poli_id'];
							$hk->pasien_asal = 'TG';
							$hk->user = Auth::user()->name;
							$hk->save();
						}elseif($polis->politype == 'M'){
							$pasien = new Pasienlangsung();
							$pasien->registrasi_id = $reg->id;
							$pasien->nama = strtoupper($request['nama']);
							$pasien->alamat = $request['alamat'];
							$pasien->politype = $polis->politype;
							$pasien->user_id = Auth::user()->id;
							$pasien->save();
	
							$hk = new HistorikunjunganRM();
							$hk->registrasi_id = $reg->id;
							$hk->pasien_id = $pasien->id;
							$hk->poli_id = $request['poli_id'];
							$hk->pasien_asal = 'TG';
							$hk->user = Auth::user()->name;
							$hk->save();
						}elseif($polis->politype == 'Z'){
							$pasien = new Pasienlangsung();
							$pasien->registrasi_id = $reg->id;
							$pasien->nama = strtoupper($request['nama']);
							$pasien->alamat = $request['alamat'];
							$pasien->politype = $polis->politype;
							$pasien->user_id = Auth::user()->id;
							$pasien->save();
	
							$hk = new histori_kunjungan_jnz();
							$hk->registrasi_id = $reg->id;
							$hk->pasien_id = $pasien->id;
							$hk->poli_id = $request['poli_id'];
							$hk->pasien_asal = 'TG';
							$hk->user = Auth::user()->name;
							$hk->save();
						}elseif($polis->politype == 'B'){
							$pasien = new Pasienlangsung();
							$pasien->registrasi_id = $reg->id;
							$pasien->nama = strtoupper($request['nama']);
							$pasien->alamat = $request['alamat'];
							$pasien->politype = $polis->politype;
							$pasien->user_id = Auth::user()->id;
							$pasien->save();
							
							$hk = new histori_kunjungan_ambl();
							$hk->registrasi_id = $reg->id;
							$hk->pasien_id = $pasien->id;
							$hk->poli_id = $request['poli_id'];
							$hk->pasien_asal = 'TG';
							$hk->user = Auth::user()->name;
							$hk->save();
						}
						$jenis = 'TG';
					} elseif ($request['status_reg'] == 'J1') {
						$jenis = 'TA';
					}
	 
					// Insert Histori
					$history = new HistoriStatus();
					$history->registrasi_id = $reg->id;
					$history->status = 'J1';
					$history->poli_id = $reg->poli_id;
					$history->bed_id = null;
					$history->user_id = Auth::user()->id;
					$history->pengirim_rujukan = $request['pengirim_rujukan'];
					$history->save();
	
					//Insert Histori Pengunjung
					$hp = new Historipengunjung();
					$hp->registrasi_id = $reg->id;
					$hp->pasien_id = $pasien->id;
					$hp->pengirim_rujukan = $request['pengirim_rujukan'];
					if ($request['status_reg'] == 'G1') {
						$hp->politipe = 'G';
					} elseif ($request['status_reg'] == 'J1') {
						$hp->politipe = 'J';
					}
					if ($request['status'] == 1) {
						$hp->status_pasien = 'BARU';
					} else {
						$hp->status_pasien = 'LAMA';
					}
					$hp->user = Auth::user()->name;
					$hp->save();
	
					//Histori Kunjungan
					if ($request['status_reg'] == 'G1') {
						//IGD
						$igd = new HistorikunjunganIGD();
						$igd->registrasi_id = $reg->id;
						$igd->pasien_id = $pasien->id;
						$igd->triage_nama = baca_poli($request['poli_id']);
						$igd->dokter_id = $request['dokter_id'];
						$igd->doa = 'N';
						$igd->user = Auth::user()->name;
						$igd->pengirim_rujukan = $request['pengirim_rujukan'];
						$igd->save();
					} elseif ($request['status_reg'] == 'J1') {
						//IRJ
						$irj = new HistorikunjunganIRJ();
						$irj->registrasi_id = $reg->id;
						$irj->pasien_id = $pasien->id;
						$irj->poli_id = $request['poli_id'];
						$irj->dokter_id = $request['dokter_id'];
						$irj->user = Auth::user()->name;
						$irj->pengirim_rujukan = $request['pengirim_rujukan'];
						$irj->save();
					}
	
				session(['pasienID' => $pasien->id, 'no_rm' => $pasien->no_rm, 'noka' => $reg->no_jkn, 'reg_id' => $reg->id]);
				
				$new_noantri = date('dmY').sprintf("%04s", 0);
				$noantri = Registrasi::where('nomorantrian','like',date('dmY') . '%')->count();
				// dd($noantri);
				if($noantri > 0){
					$nomorantrian = date('dmY').sprintf("%04s", $noantri+1);
				}else{
					$nomorantrian = $new_noantri +1;
				}

				// KOMEN FAIQ

				// $ID = config('app.consid_antrean');
				// date_default_timezone_set('UTC');
				// $t = time();
				// $data = "$ID&$t";
				// $secretKey = config('app.secretkey_antrean');
				// $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
				
				// $kuotaJKN = Poli::where('bpjs',baca_bpjs_poli($reg->poli_id))->first()->kuota; 
				// $nomor = substr($nomorantrian,-4); 
					
				// $pasienbaru = 0;

				// // $tgl = $request['tglrujukan'] ? $request['tglrujukan'] : date('Y-m-d');
				// $bayar = $reg->bayar == '1' ? 'JKN' : 'NON JKN';
				// $estimasi = strtotime(date('Y-m-d H:i')) * 1000 + 900;
				// @$jam_start = strlen((string)@$request['jam_start']) == 4 ? "0".@$request['jam_start'] : @$request['jam_start'];
				// @$jam_end = strlen((string)@$request['jam_end']) == 4 ? "0".@$request['jam_end'] : @$request['jam_end'];
				
				// // if(empty($reg->nomorantrian)){
				// 	$reg->nomorantrian = $nomorantrian;
				// 	$reg->save();
				// // }else{
				// // 	$reg->nomorantrian;
				// // }

				// if($reg->bayar == '1'){
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
				// 		//  dd(['response'=>$sml,'task_id'=>$sml2]);
				// 		// return response()->json(['code'=>$sml['metadata']['code'],'msg' => $reg->nomorantrian,'duplicate'=>'']);
						
				// 	}else{
				// 		// return response()->json(['code'=>$sml['metadata']['code'],'msg' => $sml['metadata']['message'],'duplicate'=>'']);
				// 	}
				// }

				// END KOMEN

				// JIKA BILLING DICENTANG
				if(isset($request['billing'])){
					$retri = [];
					// dd('B');

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
							'created_at'       => @$created_at
						]);
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
							$tarifObj  = Tarif::where('id',$value)->first();
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
					

				DB::commit();
				session()->forget('igdlama');
				Flashy::success('Registrasi Sukses');
				if ($request['bayar'] == 1) {
					return redirect('form-sep/' . session('reg_id'));
				} elseif ($request['bayar'] == 8){ // mandiri inhealth
					return redirect('form-sep-inhealth/' . session('reg_id'));
				} else {
					if ($request['status_reg'] == 'G1') {
						return redirect('/frontoffice/rawat-darurat');
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
				}
			} else {
				if ($request['status_reg'] == 'G1') {
					Flashy::info('Sudah terdaftar hari ini di poli yang sama');
					return redirect('frontoffice/rawat-darurat');
				} else {
					Flashy::info('Sudah terdaftar hari ini di poli yang sama');
					return redirect()->route('antrian.daftarantrian');
				}
			}
		}catch(Exception $e){
			DB::rollback();
			session()->forget('reg_id');
			Flashy::info('Gagal Simpan Data');
			return redirect()->back();
		}  
	}
	
	public function setTarifIDRG(Request $request)
	{
		$request->validate([
			'registrasi_id' => 'required',
			'tarif_idrg' => 'required|numeric',
		]);

		$registrasi = Registrasi::findOrFail($request->registrasi_id);
		$registrasi->tarif_idrg = $request->tarif_idrg;
		$registrasi->save();

		return response()->json(['success' => true]);
	}
}
