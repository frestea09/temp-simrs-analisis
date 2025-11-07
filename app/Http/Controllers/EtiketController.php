<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\MasterEtiket;
use Auth;
use Flashy;

class EtiketController extends Controller
{
    public function index()
    {
        $data['etiket'] = MasterEtiket::all();
        return view('farmasi.etiket.index', $data)->with('no', 1);
    }

    public function create()
    {
      return view('farmasi.etiket.create');
    }

    public function store(Request $request)
    {
      request()->validate(['nama'=>'required']);
      $e = new MasterEtiket();
      $e->nama = $request['nama'];
      $e->save();
      Flashy::success('Data berhasil disimpan');
      return redirect('farmasi/etiket');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $data['etiket'] = MasterEtiket::find($id);
      return view('farmasi.etiket.edit', $data);
    }

    public function update(Request $request, $id)
    {
      request()->validate(['nama'=>'required']);
      $e = MasterEtiket::find($id);
      $e->nama = $request['nama'];
      $e->update();
      Flashy::info('Data berhasil diupdate');
      return redirect('farmasi/etiket');
    }

    public function destroy($id)
    {
      $e = MasterEtiket::find($id);
      $e->delete();
      Flashy::info('Data berhasil diupdate');
      return redirect('farmasi/etiket');
    }
}
