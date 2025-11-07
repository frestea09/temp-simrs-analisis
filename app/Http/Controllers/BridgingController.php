<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Pasien\Entities\Pasien;

class BridgingController extends Controller
{
    public function index()
    {
      return view('bridging.index');
    }

    public function cariPasien(Request $req)
    {
      $data = Pasien::where('nama', 'LIKE', '%'.$req['nama'].'%')->get();
      return $data;
    }


}
