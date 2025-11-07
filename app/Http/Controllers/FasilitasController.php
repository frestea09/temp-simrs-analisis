<?php

namespace App\Http\Controllers;

use App\Consid;
use Illuminate\Http\Request;
use App\Fasilitas;
use App\JamLaporan;
use App\Satusehat;
use MercurySeries\Flashy\Flashy;
use DB;
class FasilitasController extends Controller
{
    public function index()
    {
      $data['fasilitas'] = Fasilitas::find(1);
      return view('fasilitas.index', $data);
    }

    public function update(Request $request, $id)
    {
      $fas = Fasilitas::find($id);
      $fas->fasilitas = $request['fasilitas'];
      $fas->update();
      Flashy::success('Fasilitas berhasil disimpan');
      return redirect('fasilitas');
    }

    // setting consid
    public function consid()
    {
      
      $data['data'] = Consid::all();
      // dd($data['data']);
      return view('fasilitas.consid', $data);
    }
    public function antrolo()
    {
      
      $data['data'] = Consid::where('consid','antr')->get();
      // dd($data['data']);
      return view('fasilitas.antrolo', $data);
    }

    public function updateConsid(Request $request)
    {
      // dd($request->all());
      $c = Consid::where('id','1')->first();
      foreach($request->aktif as $key=>$r){
        $c = Consid::where('id',$key)->first();
        $c->aktif = $r;
        $c->save();
      }
      // $fas = Fasilitas::find($id);
      // $fas->fasilitas = $request['fasilitas'];
      // $fas->update();
      Flashy::success('Taskid berhasil disimpan');
      return redirect()->back();
    }
    public function updateAntrolo(Request $request)
    {
      // dd($request->all());
      $c = Consid::where('consid','antr')->first();
        $c->aktif = $request->aktif;
        $c->save();
      // $fas = Fasilitas::find($id);
      // $fas->fasilitas = $request['fasilitas'];
      // $fas->update();
      Flashy::success('Perubahan berhasil disimpan');
      return redirect()->back();
    }
    
    public function Satusehat()
    { 
      $data['data'] = Satusehat::all();
      return view('fasilitas.satu_sehat', $data);
    }

    public function JamLaporan()
    { 
      $data['data'] = JamLaporan::all();
      return view('fasilitas.jam_laporan', $data);
    }
    public function LockApm()
    { 
      $data['data'] = DB::table('conf_consid')->where('consid', 'lock_apm')->first();
      return view('fasilitas.lock_apm', $data);
    }
    public function updateLockApm(Request $r)
    {
      $data = DB::table('conf_consid')
        ->where('consid', 'lock_apm')
        ->update(['aktif' => $r->aktif]);

      Flashy::success('Lock Apm berhasil disimpan');
      return redirect()->back();
    }
    public function updateJamLaporan(Request $request)
    {
      // dd($request->all());
      
      foreach($request->jam_buka as $key=>$r){
        $c =  JamLaporan::where('id',$key)->first();
        $c->jam_buka = $r;
        $c->save();
      }

      foreach($request->jam_tutup as $key=>$r){
        $c =  JamLaporan::where('id',$key)->first();
        $c->jam_tutup = $r;
        $c->save();
      }
      Flashy::success('Data berhasil disimpan');
      return redirect()->back();
    }

    public function updateSatusehat(Request $request)
    {
      // dd($request->all());
      $c = Satusehat::where('id','1')->first();
      foreach($request->aktif as $key=>$r){
        $c =  Satusehat::where('id',$key)->first();
        $c->aktif = $r;
        $c->save();
      }
      Flashy::success('Satu sehat berhasil disimpan');
      return redirect()->back();
    }
}
