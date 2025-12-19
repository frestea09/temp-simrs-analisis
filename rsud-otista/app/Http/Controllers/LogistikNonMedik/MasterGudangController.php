<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikGudang;

class MasterGudangController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gudang = LogistikNonMedikGudang::latest();
            return DataTables::of($gudang)
                ->addIndexColumn()
                ->addColumn('aksi', function($gudang){
                    return '<button type="button" onclick="edit(\'' . $gudang->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
            // return $gudang; die;
        return view('logistik.logistiknonmedik.masterGudang');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'set_gudang_pusat' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_gudangs,set_gudang_pusat'],
            'kode_gudang' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_gudangs,kode_gudang'],
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_gudangs,nama'],
            'kepala_gudang' => ['required', 'string', 'max:255'],
            'gudang_pj' => ['required', 'string', 'max:255'],
            'bagian' => ['required', 'string', 'max:255'],
        ], [
            'set_gudang_pusat.required' => 'Set Gudang Pusat Wajib Diisi !',
            'kode_gudang.required' => 'Kode Gudang Wajib Diisi !',
            'nama.required' => 'Nama Wajib Diisi !',
            'kepala_gudang.required' => 'Kepala Gudang Wajib Diisi !',
            'gudang_pj.required' => 'Gudang Pj Wajib Diisi !',
            'bagian.required' => 'Bagian Wajib Diisi !',
            'set_gudang_pusat.unique' => 'Kepala Gudang Sudah Ada !',
            'kode_gudang.unique' => 'Gudang Pj Sudah Ada !',
            'nama.unique' => 'Bagian Sudah Ada !',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $gudang = new LogistikNonMedikGudang();
            $gudang->set_gudang_pusat  = $request['set_gudang_pusat'];
            $gudang->kode_gudang       = $request['kode_gudang'];
            $gudang->nama              = $request['nama'];
            $gudang->kepala_gudang     = $request['kepala_gudang'];
            $gudang->gudang_pj         = $request['gudang_pj'];
            $gudang->bagian            = $request['bagian'];
            $gudang->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $gudang = LogistikNonMedikGudang::find($id);
        return response()->json(['gudang' => $gudang]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'set_gudang_pusat' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_gudangs,set_gudang_pusat,'.$id],
            'kode_gudang' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_gudangs,kode_gudang,'.$id],
            'nama' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_gudangs,nama,'.$id],
            'kepala_gudang' => ['required', 'string', 'max:255'],
            'gudang_pj' => ['required', 'string', 'max:255'],
            'bagian' => ['required', 'string', 'max:255'],
        ], [
            'set_gudang_pusat.required' => 'Set Gudang Pusat Wajib Diisi !',
            'kode_gudang.required' => 'Kode Gudang Wajib Diisi !',
            'nama.required' => 'Nama Wajib Diisi !',
            'kepala_gudang.required' => 'Kepala Gudang Wajib Diisi !',
            'gudang_pj.required' => 'Gudang Pj Wajib Diisi !',
            'bagian.required' => 'Bagian Wajib Diisi !',
            'set_gudang_pusat.unique' => 'Kepala Gudang Sudah Ada !',
            'gudang_pj.unique' => 'Gudang Pj Sudah Ada !',
            'bagian.unique' => 'Bagian Sudah Ada !',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $gudang = LogistikNonMedikGudang::find($id);
            $gudang->set_gudang_pusat  = $request['set_gudang_pusat'];
            $gudang->kode_gudang       = $request['kode_gudang'];
            $gudang->nama              = $request['nama'];
            $gudang->kepala_gudang     = $request['kepala_gudang'];
            $gudang->gudang_pj         = $request['gudang_pj'];
            $gudang->bagian            = $request['bagian'];
            $gudang->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getGudang()
    {
        $gudang = LogistikNonMedikGudang::all();
        return response()->json($gudang);
    }
}
