<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Labkategori;
use App\Labsection;
use MercurySeries\Flashy\Flashy;

class LabkategoriController extends Controller
{
    public function index()
    {
        $data['labkategori'] = Labkategori::all();
        return view('laboratorium.labkategori.index',$data)->with('no', 1);
    }

    public function create()
    {
        $section = Labsection::pluck('nama', 'id');
        return view('laboratorium.labkategori.create', compact('section'));
    }

    public function store(Request $request)
    {
        $data = request()->validate(['nama'=>'required|unique:labkategoris,nama', 'labsection_id'=>'sometimes']);
        Labkategori::create($data);
        Flashy::success('Data berhasil disimpan');
        return redirect('labkategori');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $labkategori = Labkategori::find($id);
      $section = Labsection::pluck('nama', 'id');
      return view('laboratorium.labkategori.edit', compact('section', 'labkategori'));
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nama'=>'required|unique:labkategoris,nama,'.$id, 'labsection_id'=>'sometimes']);
      $lk = Labkategori::find($id)->update($data);
      Flashy::info('Data berhasil diupdate');
      return redirect('labkategori');
    }

    public function destroy($id)
    {
        //
    }
}
