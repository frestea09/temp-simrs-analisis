<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiagnosaKeperawatan;
use App\IntervensiKeperawatan;
use Flashy;

class IntervensiKeperawatanController extends Controller
{
    public function index(){
        $intervensis = IntervensiKeperawatan::all();

        return view('intervensikeperawatan.index', compact('intervensis'))->with('no', 1);
    }

    public function create(){
        $diagnosas = DiagnosaKeperawatan::pluck('nama', 'id');

        return view('intervensikeperawatan.create', compact('diagnosas'));
    }

    public function store(Request $request){
        request()->validate([
            'diagnosa' => 'required',
            'nama_intervensi' => 'required',
        ]);
        // dd($request->all());
        foreach($request->diagnosa as $diagnosa){
            $intervensi = new IntervensiKeperawatan();
            $intervensi->nama_intervensi = $request->nama_intervensi;
            $intervensi->diagnosa_keperawatan_id = $diagnosa;
            $intervensi->save();
        }

        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('master-intervensi');
    }

    public function show(){
        return redirect('master-intervensi');
    }

    public function edit($id){
        $data['intervensi'] = IntervensiKeperawatan::find($id);
        $data['diagnosas'] = DiagnosaKeperawatan::pluck('nama', 'id');
        
        return view('intervensikeperawatan.edit', $data);
    }

    public function update(Request $request, $id){
        request()->validate([
            'diagnosa' => 'required',
            'nama_intervensi' => 'required',
        ]);

        $intervensi = IntervensiKeperawatan::find($id);
        $intervensi->nama_intervensi = $request->nama_intervensi;
        $intervensi->diagnosa_keperawatan_id = $request->diagnosa;
        $intervensi->update();

        Flashy::info('Data Berhasil Diperbarui');
        return redirect('master-intervensi');
    }

    public function destroy($id){
        IntervensiKeperawatan::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('master-intervensi');
    }
}
