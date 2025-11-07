<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikBarang;

class BarangController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barang = LogistikNonMedikBarang::latest();
            return DataTables::of($barang)
                ->addIndexColumn()
                ->addColumn('golongan', function ($barang) {
                    return $barang->golongan->nama;
                })
                ->addColumn('bidang', function ($barang) {
                    return $barang->bidang->nama;
                })
                ->addColumn('kelompok', function ($barang) {
                    return $barang->kelompok->nama;
                })
                ->addColumn('subkelompok', function ($barang) {
                    return $barang->subkelompok->nama;
                })
                ->addColumn('supplier', function ($barang) {
                    return $barang->supplier->nama;
                })
                ->addColumn('aksi', function ($barang) {
                    return '<button type="button" onclick="edit(\'' . $barang->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi', 'golongan', 'bidang', 'kelompok', 'subkelompok', 'supplier'])
                ->make(true);
        }
        // return $barang; die;
        return view('logistik.logistiknonmedik.masterBarang');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_barangs,nama'],
            'kode' => ['required'],
            'harga_beli' => ['required'],
            'harga_jual' => ['required'],
            'satuan_beli' => ['required'],
            'satuan_jual' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'satuan_beli.required' => 'Satuan Beli Wajib Diisi !',
            'satuan_jual.required' => 'Satuan Jual Wajib Diisi !',
            'harga_jual.required' => 'Harga Jual Wajib Diisi !',
            'harga_beli.required' => 'Harga Beli Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $barang = new LogistikNonMedikBarang();
            $barang->nama    = $request['nama'];
            $barang->kode  = $request['kode'];
            $barang->golongan_id  = $request['golongan_id'];
            $barang->bidang_id  = $request['bidang_id'];
            $barang->kelompok_id  = $request['kelompok_id'];
            $barang->sub_kelompok_id  = $request['sub_kelompok_id'];
            $barang->supplier_id  = $request['supplier_id'];
            $barang->kategori_id  = $request['kategori_id'];
            $barang->harga_beli  = rupiah($request['harga_beli']);
            $barang->harga_jual  = rupiah($request['harga_jual']);
            $barang->satuan_beli  = $request['satuan_beli'];
            $barang->satuan_jual  = $request['satuan_jual'];
            $barang->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    {
        $barang = LogistikNonMedikBarang::find($id);
        return response()->json(['barang' => $barang]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_barangs,nama,' . $id],
            'kode' => ['required'],
            'harga_beli' => ['required'],
            'harga_jual' => ['required'],
            'satuan_beli' => ['required'],
            'satuan_jual' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'satuan_beli.required' => 'Satuan Beli Wajib Diisi !',
            'satuan_jual.required' => 'Satuan Jual Wajib Diisi !',
            'harga_jual.required' => 'Harga Jual Wajib Diisi !',
            'harga_beli.required' => 'Harga Beli Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $barang = LogistikNonMedikBarang::find($id);
            $barang->nama    = $request['nama'];
            $barang->kode  = $request['kode'];
            $barang->golongan_id  = $request['golongan_id'];
            $barang->bidang_id  = $request['bidang_id'];
            $barang->kelompok_id  = $request['kelompok_id'];
            $barang->sub_kelompok_id  = $request['sub_kelompok_id'];
            $barang->supplier_id  = $request['supplier_id'];
            $barang->kategori_id  = $request['kategori_id'];
            $barang->harga_beli  = rupiah($request['harga_beli']);
            $barang->harga_jual  = rupiah($request['harga_jual']);
            $barang->satuan_beli  = $request['satuan_beli'];
            $barang->satuan_jual  = $request['satuan_jual'];
            $barang->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getBarang()
    {
        $barang = LogistikNonMedikBarang::all();
        return response()->json($barang);
    }
}
