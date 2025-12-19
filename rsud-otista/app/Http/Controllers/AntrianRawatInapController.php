<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\AntrianRawatinap;
use Session;

class AntrianRawatInapController extends Controller
{
    public function touch() {
		return view('antrianrawatinap.touch');
	}
    public function savetouch(Request $request) {
		$count = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $request['kelompok'])->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['panggil'] = 0;
		$data['tanggal'] = date('Y-m-d');
		$data['kelompok'] = $request['kelompok'];
		$juml_terpanggil = AntrianRawatinap::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		AntrianRawatinap::create($data);

		Session::put('antrian', $data);

		// return view('antrianrawatinap.cetak-antrian', $data)->with('kelompok', $request['kelompok']);
		return view('antrianrawatinap.cetak-antrian', $data)->with('print','1');
	}

	public function printAntrian() {
		$data	= Session::get('antrian');
		Session::forget('antrian');
		return view('antrianrawatinap.cetak-antrian', $data)->with('print','2');
	}

	public function antrianLayarLCD() {
		$next_antrian_a = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'A')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
		$next_antrian_b = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'B')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
		$next_antrian_c = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'C')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
		$next_antrian_d = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'D')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
		// dd($next_antrian_d);
		$tr_a = '';
		foreach( $next_antrian_a as $val_a ) {
			$tr_a .= '<tr>
						<th class="font-antrian text-center">'.$val_a->kelompok.$val_a->nomor.'</th>
					  </tr>';
		}
		$loket_a	= ' <table class="table">'.$tr_a.'</table>';

		$tr_b = '';
		foreach( $next_antrian_b as $val_b ) {
			$tr_b .= '<tr>
						<th class="font-antrian text-center">'.$val_b->kelompok.$val_b->nomor.'</th>
					  </tr>';
		}
		$loket_b	= ' <table class="table">'.$tr_b.'</table>';

		$tr_c = '';
		foreach( $next_antrian_c as $val_c ) {
			$tr_c .= '<tr>
						<th class="font-antrian text-center">'.$val_c->kelompok.$val_c->nomor.'</th>
					  </tr>';
		}
		$loket_c	= ' <table class="table">'.$tr_c.'</table>';
		
		$tr_d = '';
		foreach( $next_antrian_d as $val_d ) {
			$tr_d .= '<tr>
						<th class="font-antrian text-center">'.$val_d->kelompok.$val_d->nomor.'</th>
					  </tr>';
		}
		$loket_d	= ' <table class="table">'.$tr_d.'</table>';

		$data = [
			"loket_a"	=> $loket_a,
			"loket_b"	=> $loket_b,
			"loket_c"	=> $loket_c,
			"loket_d"	=> $loket_d
		];

		return response()->json($data);

	}
	
	public function suara() {
		$antrian = AntrianRawatinap::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antrianrawatinap.suara', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function layarlcd() {
		return view('antrianrawatinap.layarlcd');
	}

	// LOKET 1
	public function daftarantrian1() {
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 1)
			->orderBy('id', 'desc')
			->get();
		return view('antrianrawatinap.daftarantrian1', compact('terpanggil'));
	}
	public function daftarpanggil1() {
		$antrian = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'A')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianrawatinap.daftarpanggil1', compact('antrian'));
	}
	public function panggil1($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianRawatinap::find($id);
		$atr->status = 1;
		$atr->loket = 1;
		$atr->update();
		return redirect()->route('antrianrawatinap.daftarantrian1');
	}
	public function panggilkembali1($id = '') {
		$d = AntrianRawatinap::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianrawatinap.daftarantrian1');
	}
	public function datalayarlcd1() {
		$antrian = AntrianRawatinap::whereIn('status', [1, 2, 3])
			->where('loket', 1)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 1)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianrawatinap.datalayarlcd1', compact('antrian', 'terpanggil'));
	}

	// LOKET 2
	public function daftarantrian2() {
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 2)
			->orderBy('id', 'desc')
			->get();
		return view('antrianrawatinap.daftarantrian2', compact('terpanggil'));
	}
	public function daftarpanggil2() {
		$antrian = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'B')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianrawatinap.daftarpanggil2', compact('antrian'));
	}
	public function panggil2($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianRawatinap::find($id);
		$atr->status = 1;
		$atr->loket = 2;
		$atr->update();
		return redirect()->route('antrianrawatinap.daftarantrian2');
	}
	public function panggilkembali2($id = '') {
		$d = AntrianRawatinap::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianrawatinap.daftarantrian2');
	}
	public function datalayarlcd2() {
		$antrian = AntrianRawatinap::whereIn('status', [1, 2, 3])
			->where('loket', 2)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 2)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianrawatinap.datalayarlcd2', compact('antrian', 'terpanggil'));
	}

	// LOKET 3
	public function daftarantrian3() {
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 3)
			->orderBy('id', 'desc')
			->get();
		return view('antrianrawatinap.daftarantrian3', compact('terpanggil'));
	}
	public function daftarpanggil3() {
		$antrian = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'C')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianrawatinap.daftarpanggil3', compact('antrian'));
	}
	public function panggil3($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianRawatinap::find($id);
		$atr->status = 1;
		$atr->loket = 3;
		$atr->update();
		return redirect()->route('antrianrawatinap.daftarantrian3');
	}
	public function panggilkembali3($id = '') {
		$d = AntrianRawatinap::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianrawatinap.daftarantrian3');
	}
	public function datalayarlcd3() {
		$antrian = AntrianRawatinap::whereIn('status', [1, 2, 3])
			->where('loket', 3)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 3)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianrawatinap.datalayarlcd3', compact('antrian', 'terpanggil'));
	}

	// LOKET 4
	public function daftarantrian4() {
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 4)
			->orderBy('id', 'desc')
			->get();
		return view('antrianrawatinap.daftarantrian4', compact('terpanggil'));
	}
	public function daftarpanggil4() {
		$antrian = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'D')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianrawatinap.daftarpanggil4', compact('antrian'));
	}
	public function panggil4($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianRawatinap::find($id);
		$atr->status = 1;
		$atr->loket = 4;
		$atr->update();
		return redirect()->route('antrianrawatinap.daftarantrian4');
	}
	public function panggilkembali4($id = '') {
		$d = AntrianRawatinap::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianrawatinap.daftarantrian4');
	}
	public function datalayarlcd4() {
		$antrian = AntrianRawatinap::whereIn('status', [1, 2, 3])
			->where('loket', 4)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianRawatinap::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 4)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianrawatinap.datalayarlcd4', compact('antrian', 'terpanggil'));
	}
    
}
