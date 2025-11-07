<?php

namespace App\Http\Controllers;

use App\ObatAntibiotik;
use App\Masterobat;
use Illuminate\Http\Request;
use Flashy;

class ObatAntibiotikController extends Controller
{
    public function index(){
        $obatAntibiotik = ObatAntibiotik::all();

        return view('obatantibiotik.index', compact('obatAntibiotik'));
    }

    public function create(){
        $masterobat = Masterobat::pluck('nama', 'id');
        return view('obatantibiotik.create', compact('masterobat'));
    }

    public function store(Request $request){
        request()->validate([
            'masterobat_id' => 'required|unique:obat_antibiotik,masterobat_id',
        ]);

        $obatAntibiotik = new ObatAntibiotik();
        $obatAntibiotik->masterobat_id = $request->masterobat_id;
        $obatAntibiotik->save();

        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('obat-antibiotik');
    }

    public function show(){
        return redirect('obat-antibiotik');
    }

    public function edit($id){
        $data['obatAntibiotik'] = ObatAntibiotik::find($id);
        $data['masterobat'] = Masterobat::pluck('nama', 'id');
        
        return view('obatantibiotik.edit', $data);
    }

    public function update(Request $request, $id){
        $obatAntibiotik = ObatAntibiotik::find($id);
        request()->validate([
            'masterobat_id' => 'required|unique:obat_antibiotik,masterobat_id,' . $obatAntibiotik->id,
        ]);

        $obatAntibiotik->masterobat_id = $request->masterobat_id;
        $obatAntibiotik->update();

        return redirect('obat-antibiotik');
    }

    public function destroy($id){
        ObatAntibiotik::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('obat-antibiotik');
    }
}
