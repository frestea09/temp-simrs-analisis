<?php

namespace Modules\Bed\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use Modules\Bed\Http\Requests\SavebedRequest;
use Modules\Bed\Http\Requests\UpdatebedRequest;
use MercurySeries\Flashy\Flashy;
use DB;

class BedController extends Controller
{
    public function index()
    {
        $bed = Bed::all();
        return view('bed::index', compact('bed'))->with('no', 1);
    }

    public function create()
    {
        $kamar = Kamar::pluck('nama', 'id');
        return view('bed::create', compact('kamar'));
    }

    public function store(SavebedRequest $request)
    {
      $bed                      = new Bed();
      $bed->kelompokkelas_id    = $request['kelompokkelas_id'];
      $bed->kelas_id            = $request['kelas_id'];
      $bed->kamar_id            = $request['kamarid'];
      $bed->nama                = $request['nama'];
      $bed->kode                = $request['kode'];
      $bed->reserved            = 'N';
      $bed->virtual             = $request['virtual'];
      $bed->hidden              = $request['hidden'] == 'Y' ? 'Y' : 'N';
      $bed->keterangan          = !empty($request['keterangan']) ? $request['keterangan'] : '-';
      // $bed->kode_bed  = $request->kode_bed;
      // $bed->nama_bed  = $request->nama_bed;
      // $bed->id_ss_bed  = $request->id_ss_bed;
      $bed->save();
      Flashy::success('Bed baru berhasil di tambahkan');
      return redirect()->route('bed');
    }

    public function show()
    {
        return view('bed::show');
    }

    public function edit($id)
    {
        $kamar = Kamar::pluck('nama', 'id');
        $bed = Bed::find($id);
        return view('bed::edit', compact('kamar','bed'));
    }

    public function update(UpdatebedRequest $request, $id)
    {
      $bed                      = Bed::find($id);
      $bed->kelompokkelas_id    = $request['kelompokkelas_id'];
      $bed->kelas_id            = $request['kelas_id'];
      $bed->kamar_id            = $request['kamarid'];
      $bed->nama                = $request['nama'];
      $bed->virtual             = $request['virtual'];
      $bed->hidden              = $request['hidden'] == 'Y' ? 'Y' : 'N';
      $bed->kode                = $request['kode'];
      $bed->keterangan          = !empty($request['keterangan']) ? $request['keterangan'] : '-';
      // $bed->kode_bed  = $request->kode_bed;
      // $bed->nama_bed  = $request->nama_bed;
      // $bed->id_ss_bed  = $request->id_ss_bed;
      $bed->update();
      Flashy::info('Bed berhasil di update');
      return redirect()->route('bed');
    }

    public function destroy($id)
    {
      $bed = Bed::find($id);
      if($bed->reserved == 'Y'){
        Flashy::error('Bed sedang terisi, mohon kosongkan terlebih dahulu');
        return redirect()->back();  
      }
      $bed->delete();
      Flashy::success('Berhasil hapus bed.');
      return redirect()->back();
    }

    public function kosongkanBed($id)
    {
      $bed = Bed::find($id);
      $bed->reserved = 'N';
      $bed->update();
      Flashy::info('Bed '.strtoupper($bed->nama).' berhasil di kosongkan.');
      return redirect()->route('bed');
    }

    public function batalKosongkanBed($id)
    {
      $bed = Bed::find($id);
      $bed->reserved = 'Y';
      $bed->update();
      Flashy::info('Bed '.strtoupper($bed->nama).' berhasil di kembalikan ke status isi.');
      return redirect()->route('bed');
    }

    public function display_bed()
    {
        $data['totalbed'] = Bed::where('virtual','N')->count();
        $data['kelas'] = Kelas::where('nama', '<>', '-')->take(12)->get();
        $data['vvip'] = Bed::where('kelas_id',2)->where('virtual', 'N')->count();
        $data['vip'] = Bed::where('kelas_id',3)->where('virtual', 'N')->count();
        $data['kelas1'] = Bed::where('kelas_id',4)->where('virtual', 'N')->count();
        $data['kelas2'] = Bed::where('kelas_id',5)->where('virtual', 'N')->count();
        $data['kelas3'] = Bed::where('kelas_id',6)->where('virtual', 'N')->count();
        $data['hcu'] = Bed::where('kelas_id',7)->where('virtual', 'N')->count();
        $data['iso'] = Bed::where('kelas_id',8)->where('virtual', 'N')->count();
        $data['perina'] = Bed::where('kelas_id',9)->where('virtual', 'N')->count();
        // $data['total'] = Bed::where('virtual','N')->count();
        return view('displaytempattidur.displaybed', $data)->with('no', 1);
    }


}
