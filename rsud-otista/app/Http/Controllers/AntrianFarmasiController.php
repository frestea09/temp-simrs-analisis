<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\AntrianFarmasi;
use App\HistorikunjunganIRJ;
use Carbon\Carbon;
use Modules\Registrasi\Entities\Registrasi;
use Session;

class AntrianFarmasiController extends Controller
{
    public function touch() {
		return view('antrianfarmasi.touch');
	}
    public function savetouch(Request $request) {
		$count = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $request['kelompok'])->count();
		$nomor = $count + 1;
		$suara = $nomor . '.mp3';

		$data['nomor'] = $nomor;
		$data['suara'] = $suara;
		$data['status'] = '0';
		$data['panggil'] = 0;
		$data['tanggal'] = date('Y-m-d');
		$data['kelompok'] = $request['kelompok'];
		$juml_terpanggil = AntrianFarmasi::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
		$data['sisa'] = $nomor - $juml_terpanggil;
		AntrianFarmasi::create($data);

		Session::put('antrian', $data);

		// return view('antrianfarmasi.cetak-antrian', $data)->with('kelompok', $request['kelompok']);
		return view('antrianfarmasi.cetak-antrian', $data)->with('print','1');
	}

	public function printAntrian() {
		$data	= Session::get('antrian');
		Session::forget('antrian');
		return view('antrianfarmasi.cetak-antrian', $data)->with('print','2');
	}

	public function antrianLayarLCD() {
		$next_antrian_a = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'A')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
		$next_antrian_b = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'B')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
		$next_antrian_c = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'C')
			->where('status', '=', '0')
			->orderBy('id', 'ASC')
			->limit(3)
			->get();
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

		$data = [
			"loket_a"	=> $loket_a,
			"loket_b"	=> $loket_b
		];

		return response()->json($data);

	}
	
	public function suara() {
		$antrian = AntrianFarmasi::whereIn('status', [1, 2, 3])
			->where('panggil', 0)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'asc')->get();
		return view('antrianfarmasi.suara', compact('antrian'))->with(['start' => 1, 'no' => 4]);
	}
	public function layarlcd() {
		return view('antrianfarmasi.layarlcd');
	}

	// LOKET 1
	public function daftarantrian1() {
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 1)
			->orderBy('id', 'desc')
			->get();
		return view('antrianfarmasi.daftarantrian1', compact('terpanggil'));
	}
    public function ajaxPasien(Request $request){
        $term = $request->term;
        $datas = HistorikunjunganIRJ::
            join('pasiens', 'histori_kunjungan_irj.pasien_id', '=', 'pasiens.id')
            ->whereDate('histori_kunjungan_irj.created_at', now()->format('Y-m-d'))
            ->where(function ($query) use ($term) {
                $query->where('pasiens.no_rm', 'LIKE', "$term%")
                    ->orWhere('pasiens.nama', 'LIKE', "$term%");
            })
            ->select('pasiens.nama', 'pasiens.no_rm', 'histori_kunjungan_irj.registrasi_id')
            ->limit(50)
            ->get();
        return response($datas);
    }
    public function insertReg($reg_id, $antrian_id){
        $antrian = AntrianFarmasi::find($antrian_id);
        $antrian->registrasi_id = $reg_id;
        $antrian->processed_at = now()->format('Y-m-d H:i:s');
        $antrian->save();
        return response([], 200);
    }
	public function daftarpanggil1() {
		$antrian = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'U')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianfarmasi.daftarpanggil1', compact('antrian'));
	}
	public function panggil1($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianFarmasi::find($id);
		$atr->status = 1;
		$atr->loket = 1;
		$atr->panggil1_at = now()->format('Y-m-d H:i:s');
		$atr->update();
		return redirect()->route('antrianfarmasi.daftarantrian1');
	}
	public function panggilkembali1($id = '') {
		$d = AntrianFarmasi::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
        $d->panggil2_at = now()->format('Y-m-d H:i:s');
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianfarmasi.daftarantrian1');
	}
    public function panggilSelesai($id = '') {
		$d = AntrianFarmasi::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
        $d->finished_at = now()->format('Y-m-d H:i:s');
		$d->update();
		return redirect()->back();
	}
	public function datalayarlcd1() {
		$antrian = AntrianFarmasi::whereIn('status', [1, 2, 3])
			->where('loket', 1)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 1)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianfarmasi.datalayarlcd1', compact('antrian', 'terpanggil'));
	}

	// LOKET 2
	public function daftarantrian2() {
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 2)
			->orderBy('id', 'desc')
			->get();
		return view('antrianfarmasi.daftarantrian2', compact('terpanggil'));
	}
	public function daftarpanggil2() {
		$antrian = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'K')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianfarmasi.daftarpanggil2', compact('antrian'));
	}
	public function panggil2($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianFarmasi::find($id);
		$atr->status = 1;
		$atr->loket = 2;
		$atr->update();
		return redirect()->route('antrianfarmasi.daftarantrian2');
	}
	public function panggilkembali2($id = '') {
		$d = AntrianFarmasi::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianfarmasi.daftarantrian2');
	}
	public function datalayarlcd2() {
		$antrian = AntrianFarmasi::whereIn('status', [1, 2, 3])
			->where('loket', 2)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 2)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianfarmasi.datalayarlcd2', compact('antrian', 'terpanggil'));
	}

	// LOKET 3
	public function daftarantrian3() {
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 3)
			->orderBy('id', 'desc')
			->get();
		return view('antrianfarmasi.daftarantrian3', compact('terpanggil'));
	}
	public function daftarpanggil3() {
		$antrian = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'N')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianfarmasi.daftarpanggil3', compact('antrian'));
	}
	public function panggil3($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianFarmasi::find($id);
		$atr->status = 1;
		$atr->loket = 3;
		$atr->update();
		return redirect()->route('antrianfarmasi.daftarantrian3');
	}
	public function panggilkembali3($id = '') {
		$d = AntrianFarmasi::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianfarmasi.daftarantrian3');
	}
	public function datalayarlcd3() {
		$antrian = AntrianFarmasi::whereIn('status', [1, 2, 3])
			->where('loket', 3)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 3)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianfarmasi.datalayarlcd3', compact('antrian', 'terpanggil'));
	}

	// LOKET 4
	public function daftarantrian4() {
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('status', '<>', '0')
			->where('loket', 4)
			->orderBy('id', 'desc')
			->get();
		return view('antrianfarmasi.daftarantrian4', compact('terpanggil'));
	}
	public function daftarpanggil4() {
		$antrian = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('kelompok', 'R')
			->where('status', '=', '0')
			->take(1)
			->get();
		return view('antrianfarmasi.daftarpanggil4', compact('antrian'));
	}
	public function panggil4($id = '') {
		// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
		$atr = AntrianFarmasi::find($id);
		$atr->status = 1;
		$atr->loket = 4;
		$atr->update();
		return redirect()->route('antrianfarmasi.daftarantrian4');
	}
	public function panggilkembali4($id = '') {
		$d = AntrianFarmasi::find($id);
		$d->status = $d->status + 1;
		$d->panggil = 0;
		$d->update();
		// DB::table('antrians')->where('id', $id)->update(['status' => $d->status + 1, 'panggil'=>0]);
		return redirect()->route('antrianfarmasi.daftarantrian4');
	}
	public function datalayarlcd4() {
		$antrian = AntrianFarmasi::whereIn('status', [1, 2, 3])
			->where('loket', 4)
			->where('tanggal', date('Y-m-d'))
			->orderBy('id', 'desc')->first();
		$terpanggil = AntrianFarmasi::where('tanggal', '=', date('Y-m-d'))
			->where('loket', 4)
			->where('status', '<>', '0')
			->orderBy('id', 'desc')->first();
		return view('antrianfarmasi.datalayarlcd4', compact('antrian', 'terpanggil'));
	}
    
}
