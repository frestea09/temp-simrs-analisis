<?php

namespace App\Http\Controllers;

use App\DiagnosaKeperawatan;
use Illuminate\Http\Request;
use Flashy;

class DiagnosaKeperawatanController extends Controller
{
    public function index(){
        $diagnosaKeperawatan = DiagnosaKeperawatan::orderBy('kode', 'ASC')->get();

        return view('diagnosakeperawatan.index', compact('diagnosaKeperawatan'));
    }

    public function create(){
        return view('diagnosakeperawatan.create');
    }

    public function store(Request $request){
        request()->validate([
            'nama' => 'required',
        ]);

        $diagnosaKeperawatan = new DiagnosaKeperawatan();
        $diagnosaKeperawatan->nama = $request->nama;
        $diagnosaKeperawatan->kode = $request->kode;
        $diagnosaKeperawatan->jenis = $request->jenis;
        $diagnosaKeperawatan->save();

    //    dd($diagnosaKeperawatan);
        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('diagnosa-keperawatan');
    }

    public function show(){
        return redirect('diagnosa-keperawatan');
    }

    public function edit($id){
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::find($id);
        
        return view('diagnosakeperawatan.edit', $data);
    }

    public function update(Request $request, $id){
        request()->validate([
            'nama' => 'required',
        ]);

        $diagnosaKeperawatan = DiagnosaKeperawatan::find($id);
        $diagnosaKeperawatan->nama = $request->nama;
        $diagnosaKeperawatan->kode = $request->kode;
        $diagnosaKeperawatan->jenis = $request->jenis;
        $diagnosaKeperawatan->update();

        return redirect('diagnosa-keperawatan');
    }

    public function destroy($id){
        DiagnosaKeperawatan::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('diagnosa-keperawatan');
    }
}
