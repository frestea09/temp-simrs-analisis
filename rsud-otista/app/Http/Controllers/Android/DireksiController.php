<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Android\android_direksi;
use App\Android\android_manajemen;
use App\Android\android_jabatan;
use App\Android\agama;
use MercurySeries\Flashy\Flashy;
use Image;

class DireksiController extends Controller
{
    public function index()
    {
        $data = android_direksi::with(['agama','jabatan','manajemen'])->get();
        return view('android.direksi.index', compact('data'));
    }

    public function create()
    {
        $data['agama'] = agama::pluck('agama','id');
        $data['manajemen'] = android_manajemen::pluck('manaj_nama','id');
        $data['jabatan'] = android_jabatan::pluck('jab_nama','id');
        $data['jk'] = [ "L" => "Laki Laki","P" => "Perempuan"];

        return view('android.direksi.form', compact('data'));
    }

    public function edit($id)
    {
        $data['agama'] = agama::pluck('agama','id');
        $data['manajemen'] = android_manajemen::pluck('manaj_nama','id');
        $data['jabatan'] = android_jabatan::pluck('jab_nama','id');
        $data['jk'] = [ "L" => "Laki Laki","P" => "Perempuan"];
        $data['direksi'] = android_direksi::find($id);

        return view('android.direksi.form', compact('data'));
    }

    public function update( Request $request, $id)
    {
        $validate = [
            'dir_nik' => 'required',
            'dir_nama' => 'required',
            'dir_tmplahir' => 'required',
            'dir_tgllahir' => 'required',
            'dir_kelamin' => 'required',
            'dir_alamat' => 'required',
            'agama_id' => 'required',
            'manajemen_id' => 'required',
            'jabatan_id' => 'required'
        ];
        $request->validate($validate);

        $data = $request->all();

        $find = android_direksi::find($id);

        if(!empty($request->file('photo'))){
            $image = time().$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move('images/direksi/', $image);
            $img = Image::make(public_path().'/images/direksi/'.$image);
            $img->save();
            $dir_photo_path = '/images/direksi/';
        }else{
            $image = $find->dir_photo;
            $dir_photo_path = $find->dir_photo_path;
        }

        $data['dir_photo'] = $image;
        $data['dir_photo_path'] = $dir_photo_path;
        $find->update($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('android/direksi');
    }

    public function store( Request $request)
    {
        $validate = [
            'dir_nik' => 'required',
            'dir_nama' => 'required',
            'dir_tmplahir' => 'required',
            'dir_tgllahir' => 'required',
            'dir_kelamin' => 'required',
            'dir_alamat' => 'required',
            'agama_id' => 'required',
            'manajemen_id' => 'required',
            'jabatan_id' => 'required',
            'photo' => 'required',
        ];
        $request->validate($validate);

        $data = $request->all();

        $image = time().$request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(base_path('public/images/direksi'), $image);
        $img = Image::make(public_path().'/images/direksi/'.$image);
        $img->save();
        $dir_photo_path = '/images/direksi/';

        $data['dir_photo'] = $image;
        $data['dir_photo_path'] = $dir_photo_path;

        android_direksi::create($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('android/direksi');
    }

    public function destroy($id)
    {
        $find = android_direksi::findOrFail($id);
        $find->delete();
        Flashy::success('Data Berhasil Dihapus !');
        return redirect('android/direksi');
    }
}
