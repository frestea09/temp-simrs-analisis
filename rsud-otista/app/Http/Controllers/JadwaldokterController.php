<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jadwaldokter;
use MercurySeries\Flashy\Flashy;

class JadwaldokterController extends Controller
{
    public function index()
    {
        $data['jadwal'] = Jadwaldokter::all();
        return view('jadwaldokter.index', $data)->with('no', 1);
    }

    public function store(Request $request)
    {
        request()->validate(['poli'=>'required', 'dokter'=>'required']);
        $d = new Jadwaldokter();
        $d->poli = $request['poli'];
        $d->dokter = $request['dokter'];
        $d->hari = $request['hari'];
        $d->jam_mulai = $request['jam_mulai'];
        $d->jam_berakhir = $request['jam_berakhir'];
        $d->save();
        Flashy::success('Jadwal Dokter berhasil ditambahkan');
        return redirect('jadwal-dokter');
    }

    public function hapusJadwal($id)
    {
        Jadwaldokter::find($id)->delete();
        Flashy::info('Jadwal berhasil dihapus');
        return redirect('jadwal-dokter');
    }
}
