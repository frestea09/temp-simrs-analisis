<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use MercurySeries\Flashy\Flashy;
use App\Android\android_content_type;

class TypeController extends Controller
{
    public function index()
    {
        $data = android_content_type::all();
        return view('android.type.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_nama' => 'required|max:255'
        ]);
        $data = [
            "type_nama" => $request->type_nama,
            "type_slug" => Str::slug($request->type_nama),
        ];
        android_content_type::create($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('/android/type');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_nama' => 'required|max:255'
        ]);
        $data = [
            "type_nama" => $request->type_nama,
            "type_slug" => Str::slug($request->type_nama),
        ];

        $find = android_content_type::find($id);
        $find->update($data);

        Flashy::success('Data Berhasil Diubah !');
        return redirect('/android/type');
    }

    public function destroy($id)
    {
        $find = android_content_type::find($id);
        $find->delete();

        Flashy::success('Data Berhasil Dihapus !');
        return redirect('/android/type');
    }
}
