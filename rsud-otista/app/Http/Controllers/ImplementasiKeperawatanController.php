<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiagnosaKeperawatan;
use App\ImplementasiKeperawatan;
use Flashy;

class ImplementasiKeperawatanController extends Controller
{
    public function index(){
        $implementasis = ImplementasiKeperawatan::all();

        return view('implementasikeperawatan.index', compact('implementasis'))->with('no', 1);
    }

    public function create(){
        $diagnosas = DiagnosaKeperawatan::pluck('nama', 'id');

        return view('implementasikeperawatan.create', compact('diagnosas'));
    }

    public function store(Request $request){
        request()->validate([
            'diagnosa' => 'required',
            'nama_implementasi' => 'required',
        ]);

        foreach($request->diagnosa as $diagnosa){
            $implementasi = new ImplementasiKeperawatan();
            $implementasi->nama_implementasi = $request->nama_implementasi;
            $implementasi->diagnosa_keperawatan_id = $diagnosa;
            $implementasi->save();
        }

        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('master-implementasi');
    }

    public function show(){
        return redirect('master-implementasi');
    }

    public function edit($id){
        $data['implementasi'] = ImplementasiKeperawatan::find($id);
        $data['diagnosas'] = DiagnosaKeperawatan::pluck('nama', 'id');
        
        return view('implementasikeperawatan.edit', $data);
    }

    public function update(Request $request, $id){
        request()->validate([
            'diagnosa' => 'required',
            'nama_implementasi' => 'required',
        ]);

        $implementasi = ImplementasiKeperawatan::find($id);
        $implementasi->nama_implementasi = $request->nama_implementasi;
        $implementasi->diagnosa_keperawatan_id = $request->diagnosa;
        $implementasi->update();

        Flashy::info('Data Berhasil Diperbarui');
        return redirect('master-implementasi');
    }

    public function destroy($id){
        ImplementasiKeperawatan::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('master-implementasi');
    }
}
