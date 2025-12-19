<?php

namespace App\Http\Controllers;

use App\Antrian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Registrasi\Entities\Registrasi;
use Illuminate\Support\Facades\Cache;


class AntrianNewController extends Controller {

	// function __construct() {
	// 	$this->middleware(['auth']);
	// }
	public function baruSajaDipanggil() {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->orderBy('id', 'desc')
			->first();
		// dd($terpanggil);
		return view('antriannew.terpanggil', compact('antrian'));
	}
	public function baruSajaDipanggilLoket() {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->orderBy('id', 'desc')
			->first();
		// dd($antrian);
		return view('antriannew.terpanggil-loket', compact('antrian'));
	}
	public function baruSajaDipanggilNew($bagian) {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', '!=', 'A')
			->where('status', '<>', '0')
			->where('bagian', $bagian)
			->orderBy('id', 'desc')
			->first();
		// dd($terpanggil);
		return view('antriannew.terpanggil', compact('antrian'));
	}
	public function baruSajaDipanggilLoketNew($bagian) {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', '!=', 'A')
			->where('status', '<>', '0')
			->where('bagian', $bagian)
			->orderBy('id', 'desc')
			->first();
		// dd($antrian);
		return view('antriannew.terpanggil-loket', compact('antrian'));
	}
	public function datalayarlcdumum() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('kelompok','A')
			->where('tanggal', date('Y-m-d'))
			->orderBy('updated_at', 'desc')->first();
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok','A')
			->where('status', '<>', '0')
			->orderBy('updated_at', 'desc')->first();
		return view('antrian::datalayarlcd', compact('antrian', 'terpanggil'));
	}
	public function layarlcd() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.layarlcdnew', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function layarlcdbawah() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.layarlcdnew2', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function layarlcdumum() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.layarlcdumum', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function layarlcdAtasNew() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.layarlcdnewAtasNews', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function datalayarlcdbawahnew($bagian,$no_loket) {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('tanggal', date('Y-m-d'))
			->where('loket', $no_loket)
			->where('bagian', $bagian)
			->orderBy('id', 'desc')
			->first();
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', $no_loket)
			->where('bagian', $bagian)
			->orderBy('id', 'desc')
			->first();
		return view('modules.antrian3.datalayarlcd', compact('antrian', 'terpanggil'));
	}
	public function layarlcdAtas() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
			// dd("A");
		return view('antriannew.layarlcdnewAtas', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}

	public function suaraAntrian() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('kelompok', '!=', 'A')
			->where('panggil', 0)
			->where('bagian','bawah')
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.playlist', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function suaraAntrianUmum() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('kelompok', 'A')
			->where('panggil', 0)
			->where('bagian','bawah')
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.playlistUmum', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function suaraAntrianAtas() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('bagian','atas')
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antriannew.playlistAtas', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function cekAntrian() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get()->count();
		return response()->json(['status'=>200,'count'=>$antrian]);

		return view('antriannew.playlist', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function cekAntrianUmum() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('kelompok', 'A')
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get()->count();
		return response()->json(['status'=>200,'count'=>$antrian]);

		return view('antriannew.playlist', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}

	

	public function savetouch(Request $request) {
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data = $request->all();
		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['bagian'] = @$request->bagian;
		$data['panggil'] = 0;
		$data['tanggal'] = date('Y-m-d');
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		Antrian::create($data);
		return view('antrian::cetak_antrian', $data)->with('loket', 2);
	}

	public function datalayarlcd() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('loket', 2)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')
			->first();
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 2)
			->orderBy('id', 'desc')
			->first();
		return view('modules.antrian2.datalayarlcd', compact('antrian', 'terpanggil'));
	}

	public function datalayarlcdNew() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('loket', 2)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')
			->first();
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 2)
			->orderBy('id', 'desc')
			->first();
		return view('modules.antrian2.datalayarlcd', compact('antrian', 'terpanggil'));
	}

	public function daftarpanggil() {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'B')
			->where('status', '=', '0')
			//->take(1)
			->get();
		return view('modules.antrian2.daftarpanggil', compact('antrian'));
	}

	public function daftarantrian() {
		
		session()->forget('blm_terdata');
		session()->forget('jenis');
		session()->forget('igdlama');
		session()->forget('igdumum-lama');
		session()->forget('pasienID');
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 2)
			->orderBy('id', 'desc')
			// ->take(20)
			->get();
		return view('modules.antrian2.daftarantrian', compact('terpanggil'));
	}
	public function daftarantrianNew($bagian,$no_loket) {
		// dd($bagian);
		$bagians = '';
		if($bagian == 'B' || $bagian == 'A'){
			$bagians = 'bawah';
		}elseif($bagian == 'C'){
			$bagians = 'atas';
		}
		// dd($bagians);
		session()->forget('blm_terdata');
		session()->forget('jenis');
		session()->forget('igdlama');
		session()->forget('igdumum-lama');
		session()->forget('pasienID');
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			// ->where('loket', $no_loket)
			->where('kelompok', $bagian)
			->where('bagian', $bagians)
			->doesntHave('registrasi')
			->orderBy('id', 'desc')
			// ->take(20)
			->paginate(3);
		// dd($terpanggil);

		// $regPerjanjian = Registrasi::whereDate('created_at', date('Y-m-d'))
		// 	->whereHas('poli', function ($query){
		// 		$query->where('politype', 'J');
		// 	})
		// 	->whereIn('input_from', ['regperjanjian', 'regperjanjian_lama', 'regperjanjian_baru', 'regperjanjian_online'])
		// 	->count();
		
		// $regOnline = Registrasi::whereDate('created_at', date('Y-m-d'))
		// 	->whereHas('poli', function ($query){
		// 		$query->where('politype', 'J');
		// 	})
		// 	->whereIn('input_from', ['KIOSK Reservasi Lama', 'KIOSK Reservasi Baru'])
		// 	->count();

		// $regOnsite = Registrasi::whereDate('created_at', date('Y-m-d'))
		// 	->whereHas('poli', function ($query){
		// 		$query->where('politype', 'J');
		// 	})
		// 	->whereIn('input_from', ['registrasi-1', 'registrasi-2', 'registrasi-3', 'registrasi-4'])
		// 	->count();

		return view('modules.antrian_news.daftarantrian', compact('terpanggil','no_loket','bagian'));
	}

	public function getStatistikRegistrasi(Request $request)
{
    $tanggalHariIni = date('Y-m-d');

	// Cache untuk regPerjanjian
	$regPerjanjian = Cache::remember('regPerjanjian_' . $tanggalHariIni, 1800, function () use ($tanggalHariIni) {
		return Registrasi::whereDate('created_at', $tanggalHariIni)
			->whereHas('poli', function ($q) {
				$q->where('politype', 'J');
			})
			->whereIn('input_from', [
				'regperjanjian',
				'regperjanjian_lama',
				'regperjanjian_baru',
				'regperjanjian_online'
			])
			->count();
	});

	// Cache untuk regOnline
	$regOnline = Cache::remember('regOnline_' . $tanggalHariIni, 1800, function () use ($tanggalHariIni) {
		return Registrasi::whereDate('created_at', $tanggalHariIni)
			->whereHas('poli', function ($q) {
				$q->where('politype', 'J');
			})
			->whereIn('input_from', [
				'KIOSK Reservasi Lama',
				'KIOSK Reservasi Baru'
			])
			->count();
	});

	// Cache untuk regOnsite
	$regOnsite = Cache::remember('regOnsite_' . $tanggalHariIni, 1800, function () use ($tanggalHariIni) {
		return Registrasi::whereDate('created_at', $tanggalHariIni)
			->whereHas('poli', function ($q) {
				$q->where('politype', 'J');
			})
			->whereIn('input_from', [
				'registrasi-1',
				'registrasi-2',
				'registrasi-3',
				'registrasi-4'
			])
			->count();
	});

    // Perbaikan di sini:
    return response()->json([
        'regPerjanjian' => $regPerjanjian,
        'regOnline' => $regOnline,
        'regOnsite' => $regOnsite
    ]);
}
	public function daftarpanggilNew($bagian,$no_loket) {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '=', '0');
			
		if($bagian == 'B') {
			$antrian = $antrian->where('kelompok', 'B');
			
		}else{
			$antrian = $antrian->where('kelompok', 'C');
		}
		$antrian = $antrian->limit(8)->get();
		return view('modules.antrian_news.daftarpanggil', compact('antrian','no_loket','bagian'));
	}

	public function panggil($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = Antrian::find($id);
		$atr->status = 1;
		$atr->loket = 2;
		$atr->update();
		return redirect()->route('antrian2.daftarantrian');
	}
	public function panggilNew($bagian,$no_loket,$id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = Antrian::find($id);
		$atr->status = 1;
		$atr->loket = $no_loket;
		$atr->update();
		return redirect('/antrian-news/'.$bagian.'/'.$no_loket.'/daftarantrian');
	}

	public function panggilkembaliNew($bagian,$no_loket,$id = ''){
		$d = Antrian::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrian2')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect('/antrian-news/'.$bagian.'/'.$no_loket.'/daftarantrian');
	}
	public function panggilkembali($id = '') {
		$d = Antrian::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrian2')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrian2.daftarantrian');
	}

	public function registrasi($id, $jenis) {
		$d = Antrian::find($id);
		$d->status = 3;
		$d->update();
		// DB::table('antrian2')->where('id', $id)->update(['status' => 3]);
		session(['no_loket' => 2]);
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
		// DB::table('antrian2')->where('id', $id)->update(['status' => 3]);
		session(['antrian_id' => $id]);
		session(['no_loket' => 2]);
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
		// DB::table('antrian2')->where('id', $id)->update(['status' => 3]);
		session(['no_loket' => 2]);
		session(['antrian_id' => $id, 'blm_terdata' => true]);
		if ($jenis == 'jkn') {
			return redirect('registrasi/create');
		} elseif ($jenis == 'umum') {
			return redirect('registrasi/create_umum');
		}
	}
	
	public function savetouchKlinik(Request $request) {
		dd("A");
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data = $request->all();
		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['panggil'] = 0;
		$data['bagian'] = @$request->bagian;
		$data['tanggal'] = date('Y-m-d');
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		Antrian::create($data);
		return view('antrian::cetak_antrian', $data)->with('loket', 2);
	}

}
