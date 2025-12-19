<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mastersplit;
use Modules\Config\Entities\Tahuntarif;
use Modules\Kategoriheader\Entities\Kategoriheader;
use Flashy;

class MastersplitController extends Controller
{
    public function index()
    {
        $data['master'] = Mastersplit::all();
        return view('mastersplit.index', $data)->with('no', 1);
    }

    public function create()
    {
        $data['tahuntarif'] = Tahuntarif::pluck('tahun', 'id');
        $data['kategoriheader'] = Kategoriheader::pluck('nama', 'id');
        return view('mastersplit.create', $data);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
          'tahuntarif_id' => 'required',
          'kategoriheader_id' => 'required',
          'nama' => 'required'
        ]);
        Mastersplit::create($data);
        Flashy::success('Master tarif berhasil ditambahkan');
        return redirect('mastersplit');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $data['mastersplit'] = Mastersplit::find($id);
      $data['tahuntarif'] = Tahuntarif::pluck('tahun', 'id');
      $data['kategoriheader'] = Kategoriheader::pluck('nama', 'id');
      return view('mastersplit.edit', $data);
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate([
        'tahuntarif_id' => 'required',
        'kategoriheader_id' => 'required',
        'nama' => 'required'
      ]);
      Mastersplit::find($id)->update($data);
      Flashy::info('Master tarif berhasil diubah');
      return redirect('mastersplit');
    }

    public function delete($id)
    {
        //
        $data = Mastersplit::find($id);
        // dd($data);
        if($data){
          Flashy::info('Master tarif '.$data->nama.' berhasil dihapus');
          $data->delete();
          return redirect('mastersplit');
        }
        Flashy::error('Gagal hapus master tarif');
        return redirect('mastersplit');
    }
}
