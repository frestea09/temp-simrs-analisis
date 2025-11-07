<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikSatuan;

class SatuanBarangController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $satuan = LogistikNonMedikSatuan::latest();
            return DataTables::of($satuan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satuan) {
                    return '<button type="button" onclick="edit(\'' . $satuan->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
            // return $gudang; die;
        return view('logistik.logistiknonmedik.satuanBarang');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_satuans,nama'],
            'jumlah' => ['required'],
            'tipe' => ['required', 'string', 'max:255'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'jumlah.required' => 'Jumlah Wajib Diisi !',
            'tipe.required' => 'Tipe Wajib Diisi !',
            'nama.unique' => 'Nama Satuan Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $satuan = new LogistikNonMedikSatuan();
            $satuan->nama    = $request['nama'];
            $satuan->jumlah  = $request['jumlah'];
            $satuan->tipe    = $request['tipe'];
            $satuan->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $satuan = LogistikNonMedikSatuan::find($id);
        return response()->json(['satuan' => $satuan]); 
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_satuans,nama,'.$id],
            'jumlah' => ['required'],
            'tipe' => ['required', 'string', 'max:255'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'jumlah.required' => 'Jumlah Wajib Diisi !',
            'tipe.required' => 'Tipe Wajib Diisi !',
            'nama.unique' => 'Nama Satuan Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $satuan = LogistikNonMedikSatuan::find($id);
            $satuan->nama    = $request['nama'];
            $satuan->jumlah  = $request['jumlah'];
            $satuan->tipe    = $request['tipe'];
            $satuan->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getBarang($satuan)
    {
        $satuan = LogistikNonMedikSatuan::all();
        return response()->json($satuan);
    }
}
