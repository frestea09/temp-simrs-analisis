<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikGolongan;

class GolonganController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $satuan = LogistikNonMedikGolongan::latest();
            return DataTables::of($satuan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satuan) {
                    return '<button type="button" onclick="edit(\'' . $satuan->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        // return $gudang; die;
        return view('logistik.logistiknonmedik.masterGolongan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_golongans,nama'],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Satuan Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $satuan = new LogistikNonMedikGolongan();
            $satuan->nama    = $request['nama'];
            $satuan->kode  = $request['kode'];
            $satuan->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    {
        $golongan = LogistikNonMedikGolongan::find($id);
        return response()->json(['golongan' => $golongan]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_golongans,nama,' . $id],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $golongan = LogistikNonMedikGolongan::find($id);
            $golongan->nama    = $request['nama'];
            $golongan->kode  = $request['kode'];
            $golongan->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getGologan()
    {
        $golongan = \App\LogistikNonMedik\LogistikNonMedikGolongan::all();
        return response()->json($golongan);
    }
}