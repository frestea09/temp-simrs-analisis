<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikBidang;

class BidangController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bidang = LogistikNonMedikBidang::latest();
            return DataTables::of($bidang)
                ->addIndexColumn()
                ->addColumn('golongan', function ($bidang) {
                    return $bidang->golongan->nama;
                })
                ->addColumn('aksi', function ($bidang) {
                    return '<button type="button" onclick="edit(\'' . $bidang->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi', 'golongan'])
                ->make(true);
        }
        // return $bidang; die;
        return view('logistik.logistiknonmedik.masterBidang');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_bidangs,nama'],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $bidang = new LogistikNonMedikBidang();
            $bidang->nama    = $request['nama'];
            $bidang->kode  = $request['kode'];
            $bidang->golongan_id  = $request['golongan_id'];
            $bidang->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    {
        $bidang = LogistikNonMedikBidang::find($id);
        return response()->json(['bidang' => $bidang]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_bidangs,nama,' . $id],
            'kode' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'kode.required' => 'kode Wajib Diisi !',
            'nama.unique' => 'Nama Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $bidang = LogistikNonMedikBidang::find($id);
            $bidang->nama    = $request['nama'];
            $bidang->kode  = $request['kode'];
            $bidang->golongan_id  = $request['golongan_id'];
            $bidang->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getBidang()
    {
        $bidang = LogistikNonMedikBidang::all();
        return response()->json($bidang);
    }
}
