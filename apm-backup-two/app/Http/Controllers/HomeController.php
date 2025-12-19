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
    public function home(){
        return view('welcome');
    }
    public function poli($loket,$posisi){
        // dd($loket,$posisi);
        $data['poli'] = Poli::where('kode_loket',$loket)->where('praktik','Y')->get();
        // dd($poli);
        $data['posisi'] = $posisi;
        $data['loket'] = $loket;
        return view('poli',$data);
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
}
