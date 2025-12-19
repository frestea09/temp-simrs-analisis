<?php

namespace App\Http\Controllers\PPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use Auth;

class MasterPpiController extends Controller
{
     public function index(Request $request)
    {

        // dd('ini');


        if ($request->ajax()) {
            $ppi = \App\PPI\MasterPpi::latest();
            return DataTables::of($ppi)
                ->addIndexColumn()
                ->addColumn('aksi', function ($ppi) {
                    // 
                    return 
                        '<button type="button" onclick="edit(\'' . $ppi->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>'
                        .
                        '<button type="button" onclick="destroy(\'' . $ppi->id . '\')" class="btn btn-sm btn-danger btn-flat" title="Hapus"><i class="fa fa-trash"></i></button>';

                })
                ->rawColumns(['aksi'])
                ->make(true);
                
            return $ppi;
        }

        return view('ppi.master');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'unique:master_ppis'],
        ],[
            'nama.unique' => 'Nama Tindakan Wajib Diisi !',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $ppi = new \App\PPI\MasterPpi();
            $ppi->nama     = $request['nama'];
            $ppi->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ppi = \App\PPI\MasterPpi::find($id);
        return response()->json(['ppi' => $ppi]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required', 'unique:master_ppis,nama,'.$id],
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $ppi = \App\PPI\MasterPpi::find($id);
            $ppi->nama  = $request['nama'];
            $ppi->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        $ppi = \App\PPI\MasterPpi::find($id);
		$ppi->delete();
		return response()->json(['sukses' => true]);
    }
}
