<?php
namespace Modules\Registrasi\Http\Controllers;

use App\AntrianPoli;
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
use Modules\Jenisjkn\Entities\Jenisjkn;
use App\PengirimRujukan;
use Modules\Kelas\Entities\Kelas;
use App\PaguPerawatan;
use App\EmrInapPemeriksaan;
use Carbon\Carbon;
use App\Rawatinap;

class RegistrasiRanapController extends Controller {
	 //REG RANAP JKN
	public function reg_ranap_jkn($id = null) {
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
		$data['poli'] = Poli::select('nama', 'id', 'politype')->get();
		// $data['poli'] = Poli::select('nama', 'id','politype')->whereIn('politype', ['G', 'L', 'R'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		$data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		$data['triage'] = EmrInapPemeriksaan::where('registrasi_id', 0)
			->where('pasien_id', 0)
			->where('type', 'triage-igd')
			->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
			->get();

		return view('rawat-inap.reg.create', $data);
	}

	public function reg_ranap_jkn_lama() {
		session()->forget('ranapumum-lama');
		session(['ranaplama' => true]);
		return view('registrasi::index');
	}
	public function form_sep($reg_id) {
		$data['rawatinap'] = Rawatinap::where('registrasi_id', $reg_id)->first();
		// if ($data['rawatinap']) {
		// 	Flashy::info('Pasien sudah diregistrasi di rawat inap!');
		// }
		$data['reg'] = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->join('carabayars', 'registrasis.bayar', '=', 'carabayars.id')
			->select('registrasis.id','registrasis.dokter_id', 'carabayars.carabayar as pembayaran', 'registrasis.bayar', 'registrasis.no_jkn', 'registrasis.tipe_jkn','pasiens.nik','pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.nama')
			->where('registrasis.id', $reg_id)
			->first();
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		$data['pagu'] = PaguPerawatan::all();
		$data['poli'] = Poli::select('nama', 'id', 'politype')->get();
		return view('rawat-inap.reg._form_sep',$data);
	}
	public function reg_ranap_jkn_blmterdata($id = null) {
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
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->Orderby('politype')->get();
		$data['poli'] = Poli::select('nama', 'id', 'politype')->get();
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G', 'R', 'L'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		$data['jenisjkn'] = Jenisjkn::pluck('nama', 'nama');
		$data['triage'] = EmrInapPemeriksaan::where('registrasi_id', 0)
			->where('pasien_id', 0)
			->where('type', 'triage-igd')
			->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
			->get();

		return view('rawat-inap.reg.create_blmterdata', $data);
	}

	//RANAP UMUM
	public function reg_ranap_umum($id = null) {
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
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->Orderby('politype')->get();
		$data['poli'] = Poli::select('nama', 'id', 'politype')->get();
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

		return view('rawat-inap.reg.umum.create_umum', $data);
	}

	public function reg_ranap_umum_lama() {
		session()->forget('ranaplama');
		session(['ranapumum-lama' => true]);
		return view('registrasi::index');
	}

	public function reg_ranap_umum_blmterdata($id = null) {
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
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G'])->Orderby('politype')->get();
		$data['poli'] = Poli::select('nama', 'id', 'politype')->get();
		// $data['poli'] = Poli::select('nama', 'id', 'politype')->whereIn('politype', ['G', 'L', 'R'])->Orderby('politype')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		return view('ranap.reg.umum.create_umum_blmterdata', $data);
	}

	public function store(SaveRegistrasiRequest $request) {

		// dd($request);
		//dd(date("Y-m-d"));
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
		// DB::transaction(function () use ($request) {
			// dd($request->all());
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
					   $antrian = AntrianPoli::create($antrian_poli); 
		             }

			// $no = Nomorrm::count() + config('app.no_rm');
			// $no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no; 
			// dd(sprintf("%05s", $no_rm));
			// Save data pasien
			$pasien = new Pasien();
			$pasien->nama = strtoupper($request['nama']);
			$pasien->nik = $request['nik'];
			$pasien->mr_id = generateRmId();
			$pasien->tmplahir = strtoupper($request['tmplahir']);
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->id_patient_ss = @$id_ss;
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
			// dd($request['poli_id']);
			// Save registrasi
			if(empty($request['status_reg'])){
				$request['status_reg'] = 'I1';
			}
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->input_from = 'registrasi-ranap-langsung';
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
				// $reg->created_at = valid_date($request['tanggal']);
				$reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
			}
			$reg->save();

			if ($request['status_reg'] == 'G1') {
				$jenis = 'TG';
			} elseif ($request['status_reg'] == 'J1') {
				$jenis = 'TA';
			}elseif ($request['status_reg'] == 'I1') {
				$jenis = 'TI';
			}

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = $jenis;
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

			session(['pasienID' => $pasien->id, 'reg_id' => $reg->id]);
		// });
		DB::commit();
		$cek_rmss = Nomorrm::where('pasien_id',$pasien->id)->orderBy('id','DESC')->first();
		if($cek_rmss){
			if($pasien->no_rm !== $cek_rmss->id){
				$up_pas = Pasien::where('id',$pasien->id)->first();
				$up_pas->no_rm = $cek_rmss->id;
				$up_pas->save();
			}
		}

		Flashy::success('Registrasi Sukses..');
		if ($request['bayar'] == 1) {
			return redirect('/registrasi/ranap/form-sep/' . session('reg_id'));
		} else {
			return redirect('/rawat-inap/admission'); 
		}
	}

	public function update(Request $request, $id) {
		// dd($request->kasus);
		

		// return $request->all();
		request()->validate([
			'no_rm' => 'unique:pasiens,no_rm',
			'nama' => 'required', 
			'tmplahir' => 'required',
			// 'tgllahir' => 'required|date_format:d-m-Y',
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
			// 'poli_id' => 'required',
		]);
		if(isset($request['poli_id'])){
			$request['poli_id'] = $request['poli_id'];
		}else{
			$request['poli_id'] = '';
		}
		// //
		if ($this->cekToday($id, $request['poli_id']) <= 0) {
			// dd("A");
			// $cekPasien = Pasien::find($id);
			DB::transaction(function () use ($request, $id) {
				// Update Pasien
				$polis	= Poli::find($request['poli_id']);
				$pasien = Pasien::find($id);
				if($request['no_jkn']){
					$pasien->no_jkn = $request['no_jkn'];
					$pasien->save();
				}
				
				// if (empty($pasien->no_rm)) {
				// 	$no_rm = Nomorrm::count() + config('app.no_rm');
				// 	Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no_rm]);
				// 	$pasien->no_rm = sprintf("%06s", $no_rm);
				// }
				
				if (empty($pasien->no_rm)) {
					$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
					$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);
					$rmid = $rms->id;
					$cek_pas = Pasien::where('no_rm',$rmid)->first();
					if($cek_pas){
						$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
						$rmid = $rms->id;
					}
					$pasien->no_rm = $rmid;
					$pasien->save();
				}
				if (!empty($request['tanggal'])) {
					$tgl = valid_date($request['tanggal']);
				}else{
					$tgl = date('Y-m-d');
				}
			 
				$id_ss = NULL;
				$id_ss_encounter=NULL; 
				
				//dd("G1");

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
				$pasien->user_update = Auth::user()->name;
				$pasien->update();
				
				// Save registrasi
				if(empty($request['status_reg'])){
						$request['status_reg'] = 'I1';
				}
				$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
				$reg = new Registrasi();
				$reg->input_from = 'registrasi-ranap-langsung';
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
				$reg->status_reg = $request['status_reg'];
				$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
				$reg->no_loket = session('no_loket');
				if (!empty($request['tanggal'])) {
					$reg->created_at = valid_date($request['tanggal']).' '.date('H:i:s');
				}
				$reg->save();
				$jenis = 'TI';

			

				// Insert Histori
				$history = new HistoriStatus();
				$history->registrasi_id = $reg->id;
				$history->status = $jenis;
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

				session(['pasienID' => $pasien->id, 'no_rm' => $pasien->no_rm, 'noka' => $reg->no_jkn, 'reg_id' => $reg->id]);
			});

			session()->forget('ranaplama');
			Flashy::success('Proses Registrasi Sukses');
			if ($request['bayar'] == 1) {
				return redirect('/registrasi/ranap/form-sep/' . session('reg_id'));
			} else {
				return redirect('/rawat-inap/admission'); 
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

	public function cekToday($pasien_id, $poli_id) {
		$reg = Registrasi::where('pasien_id', $pasien_id)->where('poli_id', $poli_id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
		return $reg;
	}
}
