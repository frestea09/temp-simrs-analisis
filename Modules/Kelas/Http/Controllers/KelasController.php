<?php

namespace Modules\Kelas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kelas\Entities\Kelas;
use MercurySeries\Flashy\Flashy;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas::index', compact('kelas'))->with('no', 1);
    }

    public function create()
    {
        return view('kelas::create');
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:kelas,nama']);
      Kelas::create($data);
      Flashy::success('Kelas baru berhasil di tambahkan');
      return redirect()->route('kelas');
    }

    public function show()
    {
        return view('kelas::show');
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        return view('kelas::edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nama'=>'required|unique:kelas,nama,'.$id]);
      Kelas::find($id)->update($data);
      Flashy::info('Kelas berhasil di update');
      return redirect()->route('kelas');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        // dd($kelas);
        $kelas->delete();

        Flashy::success('Kelas Telah Dihapus');
        return redirect()->back();
    }
}
