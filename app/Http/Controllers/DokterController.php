<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Dokter;
use Modules\Poli\Entities\Poli;
use Modules\Pegawai\Entities\Pegawai;
use Auth;
use Flashy;
use App\User;

class DokterController extends Controller
{
    public function index()
    {
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
        return view('dokter.index',$data)->with('no', 1);
    }

    public function create()
    {
        $data['user'] = User::pluck('name','id');
        $data['poli'] = Poli::pluck('nama','id');
        return view('dokter.create',$data);
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:dokters,nama']);
      $data['poli_id']= $request['poli_id'];
      $data['user_id'] = Auth::user()->id;

      Dokter::create($data);
      Flashy::success('Dokter Telah Ditambahkan');
      return redirect('dokter');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['dokter'] = Dokter::find($id);
        $data['user'] = User::pluck('name','id');
        $data['poli'] = Poli::pluck('nama','id');
        return view('dokter.edit',$data);
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nama'=>'required|unique:dokters,nama,'.$id]);
      $data['poli_id']= $request['poli_id'];
      $data['user_id'] = Auth::user()->id;
      Dokter::find($id)->update($data);
      Flashy::info('Data Dokter berhasil di update');
      return redirect('dokter');
    }

    public function destroy($id)
    {
        //
    }
}
