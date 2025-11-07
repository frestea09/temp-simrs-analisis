<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Icd9\Entities\Icd9;
use App\Icd9Im;
use Yajra\DataTables\DataTables;
use Flashy;

class Icd9ImController extends Controller
{
    public function index(){
        $icd9im = Icd9Im::all();

        return view('icd9-im.index', compact('icd9im'))->with('no', 1);
    }
    public function getData()
	{
		$data = Icd9Im::orderBy('id', 'asc');

		return DataTables::of($data)
			->make(true);
	}

    public function create(){
        $icd9 = Icd9::pluck('nama', 'id');

        return view('icd9-im.create', compact('icd9'));
    }

    public function store(Request $request){
        request()->validate([
            'icd9' => 'required',
            'nama_icd9_im' => 'required',
        ]);

        foreach($request->icd9 as $icd9){
            $icd9im = new Icd9Im();
            $icd9im->nama_icd9_im = $request->nama_icd9_im;
            $icd9im->icd9_id = $icd9;
            $icd9im->save();
        }

        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('icd9-im');
    }

    public function show(){
        return redirect('icd9-im');
    }

    public function edit($id){
        $data['icd9im'] = Icd9Im::find($id);
        $data['icd9'] = Icd9::pluck('nama', 'id');
        
        return view('icd9-im.edit', $data);
    }

    public function update(Request $request, $id){
        request()->validate([
            'icd9' => 'required',
            'nama_icd9_im' => 'required',
        ]);

        $icd9im = Icd9Im::find($id);
        $icd9im->nama_icd9_im = $request->nama_icd9_im;
        $icd9im->icd9_id = $request->icd9;
        $icd9im->update();

        Flashy::info('Data Berhasil Diperbarui');
        return redirect('icd9-im');
    }

    public function destroy($id){
        Icd9Im::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('icd9-im');
    }
}
