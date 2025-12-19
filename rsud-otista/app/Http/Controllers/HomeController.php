<?php

namespace App\Http\Controllers;

use App\HistorikunjunganIRJ;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use App\Historipengunjung;
use DB;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['total'] = 0;

        $data['l'] = 0;

        $data['p'] = 0;
        $data['rajal'] = 0;
        $data['igd'] = 0;
        $data['jkn'] = 0;
        $data['umum'] = 0;

        $data['irna'] = 0;

        // $data['poli'] = DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', date('Y-m-d').'%')->select('poli_id')->where('created_at', 'LIKE', date('Y-m-d').'%')->distinct()->get();
        $data['poli'] = 0;
        $data['kelas']  = 0;
        $data['bed']    = 0;
        // $data['total'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->count();

        // $data['l'] = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
        //                         ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
        //                         ->where('pasiens.kelamin', '=', 'L')->count();

        // $data['p'] = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
        //                         ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
        //                         ->where('pasiens.kelamin', '=', 'P')->count();
        // $data['rajal'] = HistorikunjunganIRJ::where('created_at', 'LIKE', date('Y-m-d').'%')->whereNotNull('poli_id')->count();
        // $data['igd'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'G')->count();
        // $data['jkn'] = Historipengunjung::leftJoin('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')->where('bayar', '1')->count();
        // $data['umum'] = Historipengunjung::leftJoin('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')->where('bayar', '<>', '1')->count();

        // $data['irna'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'I')->count();

        // $data['poli'] = DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', date('Y-m-d').'%')->select('poli_id')->where('created_at', 'LIKE', date('Y-m-d').'%')->distinct()->get();
        // $data['poli'] = HistorikunjunganIRJ::leftJoin('polis', 'histori_kunjungan_irj.poli_id', '=', 'polis.id')->select('histori_kunjungan_irj.poli_id')->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d').'%')->where('histori_kunjungan_irj.poli_id', '<>', '')->orderBy('polis.urutan','ASC')->distinct()->get();
        // $data['kelas']  = Kelas::get();
        // $data['bed']    = Bed::count();

        // if(date('Y-m-d') == '2023-08-01'){
        //     $data['total'] =     $data['rajal']+$data['igd']+$data['irna'];
        // }
        return view('dashboard', $data)->with('no', 1);
    }
}
