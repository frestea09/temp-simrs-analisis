<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Labsection;
use Flashy;

class LabsectionController extends Controller
{

    public function index()
    {
        $data['labsection'] = Labsection::all();
        return view('laboratorium.labsection.index', $data)->with('no', 1);
    }

    public function create()
    {
        return view('laboratorium.labsection.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate(['nama'=>'required|unique:labsections,nama']);
        Labsection::create($data);
        Flashy::success('Lab Section berhasil di simpan');
        return redirect('labsection');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $labsection = Labsection::find($id);
        return view('laboratorium.labsection.edit', compact('labsection'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $ls = Labsection::find($id);
        if($ls->deleted_at == null){
            $ls->nama = $request->nama;
        }
        // $data = request()->validate(['nama'=>'required|unique:labsections,nama,'.$id]);
        $ls->save();
        Flashy::info('Data berhasil di update');
        return redirect('labsection');
    }


    public function destroy($id)
    {
        //
    }
}
