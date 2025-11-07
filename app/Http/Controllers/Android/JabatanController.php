<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Android\android_jabatan;
use MercurySeries\Flashy\Flashy;

class JabatanController extends Controller
{
    public function index()
    {
        $data = android_jabatan::all();
        return view('android.jabatan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jab_nama' => 'required|max:255'
        ]);
        $data = [
            "jab_nama" => $request->jab_nama
        ];
        android_jabatan::create($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('/android/jabatan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jab_nama' => 'required|max:255'
        ]);
        $data = [
            "jab_nama" => $request->jab_nama
        ];

        $find = android_jabatan::find($id);
        $find->update($data);

        Flashy::success('Data Berhasil Diubah !');
        return redirect('/android/jabatan');
    }

    public function destroy($id)
    {
        $find = android_jabatan::find($id);
        $find->delete();

        Flashy::success('Data Berhasil Dihapus !');
        return redirect('/android/jabatan');
    }
}
