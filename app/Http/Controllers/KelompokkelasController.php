<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Kelas\Entities\Kelas;
use App\Kelompokkelas;
use Validator;
use DB;
use Yajra\DataTables\DataTables;

class KelompokkelasController extends Controller
{
  public function index()
  {
    return view('kelompokkelas.index');
  }

  public function data()
  {
    DB::statement(DB::raw('set @nomorbaris=0'));
		$data = Kelompokkelas::select([
				DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'),
				'id',
				'kelompok',
			]);
      return DataTables::of($data)
      ->addColumn('edit', function ($data)
      {
        return '<button type="button" onclick="editForm('.$data->id.')" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i> </button>';
      })
      ->rawColumns(['edit'])
      ->make(true);
  }

  public function save(Request $request)
  {
    $cek = Validator::make($request->all(), [
      'kelompok' => 'required|unique:kelompok_kelas,kelompok'
    ]);

    if($cek->passes()) {
      $kk = new Kelompokkelas();
      $kk->kelompok = $request['kelompok'];
      $kk->save();
      return response()->json(['sukses'=>true]);
    } else {
      return response()->json(['sukses'=>false, 'error' => $cek->errors()]);
    }
  }

  public function edit($id)
  {
    $kk = Kelompokkelas::find($id);
    return response()->json($kk);
  }

  public function update(Request $request, $id)
  {
    $cek = Validator::make($request->all(), [
      'kelompok' => 'required|unique:kelompok_kelas,kelompok,'.$id
    ]);
    if($cek->passes()) {
      $kk = Kelompokkelas::find($id);
      $kk->kelompok = $request['kelompok'];
      $kk->update();
      return response()->json(['sukses'=>true]);
    } else {
      return response()->json(['sukses'=>false, 'error' => $cek->errors()]);
    }
  }


}
