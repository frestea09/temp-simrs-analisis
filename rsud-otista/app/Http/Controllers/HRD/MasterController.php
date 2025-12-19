<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Pendidikan\Entities\Pendidikan;
use App\pendidikan_kualifikasi;
use Flashy;

class MasterController extends Controller
{
    public function index()
    {
        $data['pendidikan'] = pendidikan_kualifikasi::with('pendidikan')->get();
        return view('hrd.master.index-pendidikan', compact('data'));
    }

    public function create()
    {
        return view('hrd.master.create');
    }

    public function createKualifikasi($id)
    {
        $data['kualifikasi'] = pendidikan_kualifikasi::find($id);
        return view('hrd.master.create', compact('data'));
    }

    public function store(Request $request)
    {
    //   $data = request()->validate(['pendidikan'=>'required|unique:pendidians,pendidikan']);
        $data = $request->all();
      Pendidikan::create($data);
      Flashy::success('Pendidikan Telah Ditambahkan');
      return redirect('hrd/master/pendidikan');
    }

    public function edit($id)
    {
        $data['pendidikan'] = Pendidikan::findOrFail($id);
        $data['kualifikasi'] = pendidikan_kualifikasi::find($data['pendidikan']->kualifikasi_id);
        return view('hrd.master.edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
    //   $data = request()->validate(['pendidikan'=>'required|unique:pendidikans,pendidikan,'.$id]);
    $data = $request->all();
      Pendidikan::find($id)->update($data);
      Flashy::info('Data Pendidikan berhasil di update');
      return redirect('hrd/master/pendidikan');
    }
}
