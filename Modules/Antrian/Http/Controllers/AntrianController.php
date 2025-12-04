<?php

namespace Modules\Antrian\Http\Controllers;

use App\AntrianPoli;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Antrian\Entities\Antrian;
use Modules\Poli\Entities\Poli;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\HistoriStatus;
use App\Http\Controllers\SatuSehatController;
use App\Satusehat;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use Carbon\Carbon;
use Auth;
use DB;

class AntrianController extends Controller {

	// function __construct() {
	// 	$this->middleware(['auth']);
	// }

	public function touch() {
		$now = date('Y-m-d');
		$cek = Poli::where('updated_at', 'LIKE', $now . '%')->count();
		if ($cek <= 0) {
			foreach (Poli::all() as $key => $d) {
				$poli = Poli::find($d->id)->update(['terisi' => 0]);
			}
		}
		$data['poli'] 	= Poli::whereIn('politype', ['J', 'M'])->get();
		$data['loket1'] = Poli::where('loket', '1')->where('praktik', 'Y')->get();
		$data['loket2'] = Poli::where('loket', '2')->where('praktik', 'Y')->get();
		$data['loket3'] = Poli::where('loket', '3')->where('praktik', 'Y')->get();
		$data['loket4'] = Poli::where('loket', '4')->where('praktik', 'Y')->get();
		$data['loket5'] = Poli::where('loket', '5')->get();
		$data['loket6'] = Poli::where('loket', '6')->get();
		return view('antrian::touch', $data);
	}

	public function savetouchKlinik(Request $request) {
		// dd($request->all());
		// dd(hitung_kuota_poli($request->poli_id,$request->tanggal));
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $request['kelompok'])->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data = $request->all();
		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['poli_id'] = @$request->poli_id;
		$data['panggil'] = 0;
		$data['bagian'] = @$request->bagian;
		$data['tanggal'] = date('Y-m-d');
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		$antr = Antrian::create($data);


		$poli = Poli::find($antr->poli_id);
		$count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $poli->kelompok)->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';
		$tgl = date('Y-m-d');

		$antrian_poli = [
			"nomor" => $nomor,
			"suara" => $suara,
			"status" => 0,
			"panggil" => 1, 
			"antrian_id" => $antr->id, 
			"poli_id" => $poli->id, 
			"tanggal" => $tgl,
			// "loket" => session('no_loket') ? session('no_loket') : @$poli->loket,
			"kelompok" => $poli->kelompok
		];
		$data['antrian_polis'] = AntrianPoli::create($antrian_poli);

		// GET ANTRIAN POLI ID 
		
			//dd("J1");


		return view('antrian::cetak_antrian', $data)->with('loket', 2);
	}

	public function antrianPoli($poli_id = NULL) {
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', date('Y-m-d') . '%')->count();
		return $poli + 1;
	}

	public function savetouchKlinikNew(Request $request) {
		// dd($request->all());
		
		$pasien_id = $request->pasien_id;
		$no_rm = $request->no_rm;
		$poli_id = $request->poli_id;
		$kelompok = $request->kelompok;
		$bagian = $request->bagian;
		$tanggal = $request->tanggal;
		$pasienbaru = $request->pasienbaru;
		$pengirim_rujukan = '7';//datang sendiri
		$dokter_id = 1; // ??? pasien harus pilih dokter
		$user_id = 1; // default user_id

		$data = $request->all();

		if($pasienbaru == '0' && !empty($pasien_id)){
			DB::beginTransaction();

			$pasien = Pasien::find($pasien_id);
			$data['pasien'] = $pasien;

			$poli = Poli::find($poli_id);

			$count = AntrianPoli::where('tanggal', '=', $tanggal)->where('kelompok', $kelompok)->count();
			$nomor = $count + 1;
			$suara = $nomor . '.mp3';
	
			$antrian_poli = [
				"nomor" => $nomor,
				"suara" => $suara,
				"status" => 0,
				"panggil" => 1, 
				"poli_id" => $poli_id, 
				"tanggal" => $tanggal,
				"loket" => @$poli->loket,
				"kelompok" => $kelompok
			];
			$antrian = AntrianPoli::create($antrian_poli); 
			$data['antrian_polis'] = $antrian;
	

			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->input_from = 'apm_pasien_lama';
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->antrian_poli_id = @$antrian->id;
			$reg->status = 'lama';
			$reg->keterangan = NULL;
			$reg->rujukan = NULL;
			$reg->pengirim_rujukan = $pengirim_rujukan;
			$reg->nomorantrian = $nomor;
			$reg->dokter_id = $dokter_id;
			$reg->poli_id = $poli_id;
			$reg->bayar = '1'; //cash
			$reg->tipe_layanan = '3';//reguler
			$reg->sebabsakit_id = '3';//non bedah
			$reg->antrian_id = NULL;
			$reg->rjtl = NULL;
			$reg->kepesertaan = NULL;
			$reg->hakkelas = NULL;
			$reg->nomorrujukan =NULL;
			$reg->tglrujukan = NULL;
			$reg->kodeasal = NULL;
			$reg->catatan = NULL;
			$reg->icd = NULL;
			$reg->kecelakaan = NULL;
			$reg->tipe_jkn = NULL;
			$reg->no_sep = NULL;
			$reg->no_jkn = NULL;
			$reg->jenis_pasien = '2';//lama
			$reg->posisiberkas_id = '2';
			$reg->status_reg = 'J1';
			$reg->puskesmas_id = NULL;
			$reg->dokter_perujuk_id = NULL;
			if (($poli_id == 19) || ($poli_id == 20)) {
				$reg->tracer = 1;
			}
			$reg->perusahaan_id = NULL;
			$reg->antrian_poli = $this->antrianPoli($poli_id);
			$reg->created_at = date('Y-m-d H:i:s');
			$reg->updated_at = date('Y-m-d H:i:s');
			// dd($reg);
			$reg->save();

			if(satusehat()) {
				if (Satusehat::find(1)->aktif == 1) {
					if($reg->status_reg == 'J1'){
						// $reg->id_encounter_ss = SatuSehatController::EncounterPost($reg->id);
						// $reg->update();
					}
				}
			}

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->politipe = 'J';
			$hp->status_pasien = 'LAMA';
			$hp->created_at = date('Y-m-d H:i:s');
			//$hp->user = Auth::user()->name;
			$hp->save();

			//IRJ
			$irj = new HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $poli_id;
			$irj->dokter_id = $dokter_id;
			//$irj->user = Auth::user()->name;
			$irj->pengirim_rujukan = $pengirim_rujukan;
			$irj->save();


			// Insert Biaya Registrasi dan ke Folio
			$biaya = Biayaregistrasi::all();
			$harus_dibayar = 0;
			$harus_dibayar;

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = $user_id;//Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $dokter_id;
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
			$history->poli_id = $poli_id;
			$history->bed_id = NULL;
			//$history->user_id = Auth::user()->id;
			$history->pengirim_rujukan = $pengirim_rujukan;
			$history->save();

			DB::commit(); 
			return view('antrian::cetak_antrian_news', $data)->with('loket', 2);
		}

		return false;
	}

	// Tanpa antrian poli
	public function savetouchKlinikV1(Request $request) {
		// dd($request->all());
		// dd(hitung_kuota_poli($request->poli_id,$request->tanggal));
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $request['kelompok'])->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data = $request->all();
		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['poli_id'] = @$request->poli_id;
		$data['panggil'] = 0;
		$data['bagian'] = @$request->bagian;
		$data['tanggal'] = date('Y-m-d');
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		Antrian::create($data);


		return view('antrian::cetak_antrian', $data)->with('loket', 2);
	}


	public function savetouch(Request $request) {
		// dd($request->all());
		
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $request['kelompok'])->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['panggil'] = 0;
		$data['bagian'] = @$request['bagian'];
		$data['tanggal'] = date('Y-m-d');
		$data['kelompok'] = $request['kelompok'];
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		$antr = Antrian::create($data);
		
		return view('antrian::cetak_antrian', $data)->with('kelompok', $request['kelompok']);
	}

	public function layarlcd() {
		return view('antrian::layarlcd');
	}

	
	public function datalayarlcd() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('loket', 1)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 1)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrian::datalayarlcd', compact('antrian', 'terpanggil'));
	}

	public function daftarpanggil() {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'A')
			->where('status', '=', '0')
			->take(5)
			->get();
		return view('antrian::daftarpanggil', compact('antrian'));
	}

	public function daftarantrian() {
		//dd('antrian');
		session()->forget('blm_terdata');
		session()->forget('jenis');
		session()->forget('igdlama');
		session()->forget('igdumum-lama');
		session()->forget('pasienID');
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->with('registrasi')
			->where('status', '<>', '0')
			->where('loket', 1)
			->whereDoesntHave('registrasi')
			->orderBy('id', 'desc')
			// ->take(20)
			->get();
		return view('antrian::daftarantrian', compact('terpanggil'));
	}


	public function panggil($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = Antrian::find($id);
		$atr->status = 1;
		$atr->loket = 1;
		$atr->update();
		return redirect()->route('antrian.daftarantrian');
	}

	public function panggilBeda($id = '',$loket) {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = Antrian::find($id);
		$atr->status = 1;
		$atr->loket = $loket;
		$atr->update();
		return redirect()->back();
	}

	public function panggilkembali($id = '') {
		$d = Antrian::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrian.daftarantrian');
	}

	public function panggilkembaliBeda($id = '',$loket) {
		$d = Antrian::find($id);
		$d->status = $d->status + 1;
		$d->loket = $loket;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->back();
	}

	public function registrasi($id, $jenis) {
		$d = Antrian::find($id);
		$d->status = 3;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => 3]);
		session(['no_loket' => 1]);
		if ($jenis == 'jkn') {
			session(['antrian_id' => $id]);
			return redirect('registrasi/create');
		} elseif ($jenis == 'umum') {
			session(['antrian_id' => $id]);
			return redirect()->route('registrasi.create_umum');
		}

	}

	public function reg_pasienlama($id, $jenis) {
		$d = Antrian::find($id);
		$d->status = 3;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => 3]);
		session(['antrian_id' => $id]);
		session(['no_loket' => 1]);
		if ($jenis == 'jkn') {
			return redirect('registrasi');
		} elseif ($jenis == 'umum') {
			session(['jenis' => 'umum']);
			return redirect('registrasi');
		}
	}

	public function reg_blm_terdata($id, $jenis) {
		$d = Antrian::find($id);
		$d->status = 3;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => 3]);
		session(['antrian_id' => $id, 'blm_terdata' => true]);
		session(['no_loket' => 1]);
		if ($jenis == 'jkn') {
			return redirect('registrasi/create');
		} elseif ($jenis == 'umum') {
			return redirect('registrasi/create_umum');
		}
	}

	public function suara() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antrian::playlist', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}

}
