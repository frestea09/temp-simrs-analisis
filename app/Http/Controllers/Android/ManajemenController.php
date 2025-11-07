<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Android\android_manajemen;
use MercurySeries\Flashy\Flashy;

class ManajemenController extends Controller
{
    public function index()
    {
        $data = android_manajemen::all();
        return view('android.manajemen.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'manaj_nama' => 'required|max:255'
        ]);
        $data = [
            "manaj_nama" => $request->manaj_nama
        ];
        android_manajemen::create($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('/android/manajemen');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'manaj_nama' => 'required|max:255'
        ]);
        $data = [
            "manaj_nama" => $request->manaj_nama
        ];

        $find = android_manajemen::find($id);
        $find->update($data);

        Flashy::success('Data Berhasil Diubah !');
        return redirect('/android/manajemen');
    }

    public function destroy($id)
    {
        $find = android_manajemen::find($id);
        $find->delete();

        Flashy::success('Data Berhasil Dihapus !');
        return redirect('/android/manajemen');
    }
}
