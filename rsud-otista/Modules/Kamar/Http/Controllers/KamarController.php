<?php

namespace Modules\Kamar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kamar\Entities\Kamar;
use Modules\Kelas\Entities\Kelas;
use MercurySeries\Flashy\Flashy;
use App\Kelompokkelas;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::orderBy('id', 'asc')->get();
        // dd($kamar);
        return view('kamar::index', compact('kamar'))->with('no', 1);
    }

    public function create()
    {
        $kelas = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
        $kelompok = Kelompokkelas::pluck('kelompok', 'id');
        return view('kamar::create', compact('kelas', 'kelompok'));
    }

    public function store(Request $request)
    {
      // $data = request()->validate(['kelompokkelas_id'=>'required','nama'=>'required','kelas_id'=>'required', 'kode_kamar'=>'required','nama_kamar'=>'required', ]);
      $kamar                    = new Kamar();
      $kamar->kelompokkelas_id  = $request->kelompokkelas_id;
      $kamar->nama              = $request->nama;
      $kamar->kelas_id          = $request->kelas_id;
      $kamar->kode              = $request->kode_kamar;
      $kamar->hidden            = $request->hidden == 'Y' ? 'Y' : 'N';
      // $kamar->nama_kamar  = $request->nama_kamar;
      // $kamar->id_ss_kamar  = $request->id_ss_kamar;
      $kamar->save();
      // Kamar::create($data);
      Flashy::success('Kamar baru berhasil di tambahkan');
      return redirect()->route('kamar');
    }

    public function show()
    {
        return view('kamar::show');
    }

    public function edit($id)
    {
        $kelas      = Kelas::pluck('nama', 'id');
        $kamar      = Kamar::find($id);
        $kelompok   = Kelompokkelas::pluck('kelompok', 'id');
        return view('kamar::edit', compact('kelas', 'kamar', 'kelompok'));
    }

    public function update(Request $request, $id)
    {
      // $data = request()->validate(['kelompokkelas_id'=>'required','nama'=>'required','nama_kamar'=>'required', 'kelas_id'=>'required', 'kode_kamar'=>'required']);
      $kamar                    = Kamar::find($id);
      $kamar->kelompokkelas_id  = $request->kelompokkelas_id;
      $kamar->nama              = $request->nama;
      $kamar->kelas_id          = $request->kelas_id;
      $kamar->hidden            = $request->hidden == 'Y' ? 'Y' : 'N';
      $kamar->bed()->update(['hidden' => $kamar->hidden]);
      $kamar->kode              = $request->kode_kamar;
      // $kamar->nama_kamar  = $request->nama_kamar;
      // $kamar->id_ss_kamar  = $request->id_ss_kamar;
      $kamar->update();
      Flashy::info('Kamar berhasil di update');
      return redirect()->route('kamar');
    }

    public function destroy()
    {
    }

    //Ajax
    public function getKelas($kelompokkelas_id='')
    {
      $kelompok = Kamar::where('kelompokkelas_id', $kelompokkelas_id)->distinct()->get(['kelas_id']);
      $kelas = [];
      foreach ($kelompok as $key => $d) {
        $kelas[] = ['id' => $d->kelas_id, 'kelas' => Kelas::find($d->kelas_id)->nama];
      }
      return response()->json($kelas);
    }

    public function getKamar($kelompokkelas_id, $kelas_id)
    {
      $kamar = Kamar::where('kelompokkelas_id', $kelompokkelas_id)->where('kelas_id', $kelas_id)->get(['id', 'nama']);
      return response()->json($kamar);
    }
}
