<?php

namespace App\Http\Controllers;
use App\PaguPerawatan;
use Illuminate\Http\Request;
use Flashy;
use Modules\Kelas\Entities\Kelas;

class MasterpaguController extends Controller {
	public function index() 
    {
		return view('masterpagu.index', [
            'pagu' => PaguPerawatan::with('kelas')->get(),
            'no' => 1,
        ]);
	}

    public function create()
    {
        return view('masterpagu.create', [
          'kelas' => Kelas::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
          'biaya' => 'required|numeric',
          'diagnosa_awal' => 'required',
          'kelas' => 'required',
        ]);

        PaguPerawatan::create([
          'biaya' => $request->biaya,
          'diagnosa_awal' => $request->diagnosa_awal,
          'kelas_id' => $request->kelas, 
        ]);

        Flashy::success('Master pagu berhasil ditambahkan');
        return redirect('masterpagu');
    }

    public function edit($id)
    {
      $data['masterpagu'] = PaguPerawatan::find($id);
      $data['kelas'] = Kelas::all();
      return view('masterpagu.edit', $data);
    }


    public function update(Request $request, $id)
    {
      $data = request()->validate([
        'biaya' => 'required|numeric',
        'diagnosa_awal' => 'required',
        'kelas' => 'required',
      ]);
      PaguPerawatan::find($id)->update([
        'biaya' => $request->biaya,
        'diagnosa_awal' => $request->diagnosa_awal,
        'kelas_id' => $request->kelas,
      ]);
      Flashy::info('Master pagu berhasil diubah');
      return redirect('masterpagu');
    }

    public function destroy($id)
    {
        PaguPerawatan::findOrFail($id)->delete();
        Flashy::info('Master pagu berhasil dihapus');
        return redirect('masterpagu');
    }
}
