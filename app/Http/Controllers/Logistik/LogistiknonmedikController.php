<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogistiknonmedikController extends Controller{
    
    public function masterGudang(){
        return view('logistik.logistiknonmedik.masterGudang');
    }
    
    public function satuanBarang(){
        return view('logistik.logistiknonmedik.satuanBarang');
    }
    
    public function supplierNonmedik(){
        return view('logistik.logistiknonmedik.supplierNonmedik');
    }
    
    public function masterBarang(){
        return view('logistik.logistiknonmedik.masterBarang');
    }
    
    public function barangPergudang(){
        return view('logistik.logistiknonmedik.barangPergudang');
    }
    
    public function masterGolongan(){
        return view('logistik.logistiknonmedik.masterGolongan');
    }
    
    public function masterBidang(){
        return view('logistik.logistiknonmedik.masterBidang');
    }
    
    public function masterKelompok(){
        return view('logistik.logistiknonmedik.masterKelompok');
    }
    
    public function subKelompok(){
        return view('logistik.logistiknonmedik.subKelompok');
    }
    
    public function subSubkelompok(){
        return view('logistik.logistiknonmedik.subSubkelompok');
    }
    
    public function masterPeriode(){
        return view('logistik.logistiknonmedik.masterPeriode');
    }
}
