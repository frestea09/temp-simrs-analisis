<?php

namespace App\Http\Controllers;

use App\Antrian3 as Antrian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Antrian3Controller extends Controller {

	// function __construct() {
	// 	$this->middleware(['auth']);
	// }

	public function savetouch(Request $request) {
		$count = Antrian::where('tanggal', '=', date('Y-m-d'))->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data = $request->all();
		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['panggil'] = 0;
		$data['tanggal'] = date('Y-m-d');
		$juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		Antrian::create($data);
		return view('antrian::cetak_antrian', $data)->with('loket', 3);
	}

	public function datalayarlcd() {
		$antrian = Antrian::whereIn('status', [1, 2, 3])
			->where('tanggal', date('Y-m-d'))
			->where('loket', 3)
			->orderBy('id', 'desc')
			->first();
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 3)
			->orderBy('id', 'desc')
			->first();
		return view('modules.antrian3.datalayarlcd', compact('antrian', 'terpanggil'));
	}

	public function daftarpanggil() {
		$antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
			->where('status', '=', '0')
			->where('kelompok', 'C')
			->take(5)
			->get();
		return view('modules.antrian3.daftarpanggil', compact('antrian'));
	}

	public function daftarantrian() {
		session()->forget('blm_terdata');
		session()->forget('jenis');
		session()->forget('igdlama');
		session()->forget('igdumum-lama');
		session()->forget('pasienID');
		$terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
			->with('registrasi')
			->where('status', '<>', '0')
			->where('loket', 3)
			->whereDoesntHave('registrasi')
			->orderBy('id', 'desc')
			// ->take(20)
			->paginate(10);
		return view('modules.antrian3.daftarantrian', compact('terpanggil'));
	}

	public function panggil($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = Antrian::find($id);
		$atr->status = 1;
		$atr->loket = 3;
		$atr->update();
		return redirect()->route('antrian3.daftarantrian');
	}

	public function panggilkembali($id = '') {
		$d = Antrian::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrian3')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrian3.daftarantrian');
	}

	public function registrasi($id, $jenis) {
		$d = Antrian::find($id);
		$d->status = 3;
		$d->update();
		// DB::table('antrian3')->where('id', $id)->update(['status' => 3]);
		session(['no_loket' => 3]);
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
		// DB::table('antrian3')->where('id', $id)->update(['status' => 3]);
		session(['no_loket' => 3]);
		session(['antrian_id' => $id]);
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
		// DB::table('antrian3')->where('id', $id)->update(['status' => 3]);
		session(['no_loket' => 3]);
		session(['antrian_id' => $id, 'blm_terdata' => true]);
		if ($jenis == 'jkn') {
			return redirect('registrasi/create');
		} elseif ($jenis == 'umum') {
			return redirect('registrasi/create_umum');
		}
	}

}
