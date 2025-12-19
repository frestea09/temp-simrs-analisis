<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikKategori;

class KategoriController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategori = LogistikNonMedikKategori::latest();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('aksi', function ($kategori) {
                    return '<button type="button" onclick="edit(\'' . $kategori->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        // return $gudang; die;
        return view('logistik.logistiknonmedik.masterKategori');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_kategoris,nama'],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama kategori Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $kategori = new LogistikNonMedikKategori();
            $kategori->nama    = $request['nama'];
            $kategori->kode  = $request['kode'];
            $kategori->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    {
        $kategori = LogistikNonMedikKategori::find($id);
        return response()->json(['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_kategoris,nama,' . $id],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $kategori = LogistikNonMedikKategori::find($id);
            $kategori->nama    = $request['nama'];
            $kategori->kode  = $request['kode'];
            $kategori->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getKategori()
    {
        $kategori = LogistikNonMedikKategori::all();
        return response()->json($kategori);
    }
}
