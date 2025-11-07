<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikKelompok;

class KelompokController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kelompok = LogistikNonMedikKelompok::latest();
            return DataTables::of($kelompok)
                ->addIndexColumn()
                ->addColumn('golongan', function ($kelompok) {
                    return $kelompok->golongan->nama;
                })
                ->addColumn('bidang', function ($kelompok) {
                    return $kelompok->bidang->nama;
                })
                ->addColumn('aksi', function ($kelompok) {
                    return '<button type="button" onclick="edit(\'' . $kelompok->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi', 'golongan', 'bidang'])
                ->make(true);
        }
        // return $bidang; die;
        return view('logistik.logistiknonmedik.masterKelompok');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_kelompoks,nama'],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $kelompok = new LogistikNonMedikKelompok();
            $kelompok->nama    = $request['nama'];
            $kelompok->kode  = $request['kode'];
            $kelompok->golongan_id  = $request['golongan_id'];
            $kelompok->bidang_id  = $request['bidang_id'];
            $kelompok->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    {
        $kelompok = LogistikNonMedikKelompok::find($id);
        return response()->json(['kelompok' => $kelompok]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_kelompoks,nama,' . $id],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $kelompok = LogistikNonMedikKelompok::find($id);
            $kelompok->nama    = $request['nama'];
            $kelompok->kode  = $request['kode'];
            $kelompok->golongan_id  = $request['golongan_id'];
            $kelompok->bidang_id  = $request['bidang_id'];
            $kelompok->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getKelompok()
    {
        $kelompok = LogistikNonMedikKelompok::all();
        return response()->json($kelompok);
    }
}
