<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function poli($loket,$posisi){
        // dd($loket,$posisi);
        $data['poli'] = Poli::where('kode_loket',$loket)->where('praktik','Y')->get();
        // dd($poli);
        $data['posisi'] = $posisi;
        $data['loket'] = $loket;
        return view('poli',$data);
    }

    //versi 2 (Loket B & C)
    public function poli_v2($loket,$posisi){
        // dd($loket,$posisi);
        $data['poli'] = Poli::where('kode_loket',$loket)->where('praktik','Y')->get();
        // dd($poli);
        $data['posisi'] = $posisi;
        $data['loket'] = $loket;
        return view('poli_v2',$data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function home()
    {
        return view('welcome');
    }
    public function home2()
    {
        return view('welcome_v2');
    }

    public function home3()
	{
		// Session::flash('error', 'Data Rujukan Tidak Ditemukan, harap ke admisi');
			$data['poli'] = Poli::all();
			return view('reservasi.cek-reservasi-all',$data);
	}
}
