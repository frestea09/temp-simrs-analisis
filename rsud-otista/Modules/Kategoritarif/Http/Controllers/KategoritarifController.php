<?php

namespace Modules\Kategoritarif\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Kategoriheader\Entities\Kategoriheader;
use MercurySeries\Flashy\Flashy;

class KategoritarifController extends Controller
{
    public function index()
    {
        $kategoritarif = Kategoritarif::all();
        return view('kategoritarif::index', compact('kategoritarif'))->with('no', 1);
    }

    public function create()
    {
        $header = Kategoriheader::pluck('nama', 'id');
        return view('kategoritarif::create', compact('header'));
    }

    public function store(Request $request)
    {
      $data = request()->validate(['namatarif'=>'required|unique:kategoritarifs,namatarif', 'kategoriheader_id'=>'required']);
      Kategoritarif::create($data);
      Flashy::success('Kategori tarif baru berhasil di tambahkan');
      return redirect()->route('kategoritarif');
    }

    public function show()
    {
        return view('kategoritarif::show');
    }

    public function edit($id)
    {
        $kategoritarif = Kategoritarif::find($id);
        $header = Kategoriheader::pluck('nama', 'id');
        return view('kategoritarif::edit', compact('kategoritarif', 'header'));
    }

    public function update(Request $request,$id)
    {
      $data = request()->validate(['namatarif'=>'required|unique:kategoritarifs,namatarif,'.$id, 'kategoriheader_id'=>'required']);
      Kategoritarif::find($id)->update($data);
      Flashy::info('Kategori tarif berhasil di update');
      return redirect()->route('kategoritarif');
    }

    public function destroy()
    {
    }
}
