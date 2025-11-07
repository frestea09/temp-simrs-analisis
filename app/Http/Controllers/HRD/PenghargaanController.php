<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdPenghargaan;
use App\HRD\HrdBiodata;
use Validator;
use Yajra\DataTables\DataTables;

class PenghargaanController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek =  Validator::make($request->all(), [
            'namapenghargaan' => 'required',
            'nosk' => 'required',
            'tglsk' => 'required',
            'asalpenghargaan' => 'required',
            'pemberipenghargaan' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $gaji = new HrdPenghargaan();
            $gaji->biodata_id = $request['biodata_id'];
            $gaji->namapenghargaan = $request['namapenghargaan'];
            $gaji->nosk = $request['nosk'];
            $gaji->tglsk = valid_date($request['tglsk']);
            $gaji->asalpenghargaan = $request['asalpenghargaan'];
            $gaji->pemberipenghargaan = $request['pemberipenghargaan'];
            $gaji->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $penghargaan = HrdPenghargaan::find($id);
        $penghargaan->Tglsk = tgl_indo($penghargaan->tglsk);
        return response()->json($penghargaan);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view( 'hrd.penghargaan.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $gaji = HrdPenghargaan::find($id);
        $gaji->biodata_id = $request['biodata_id'];
        $gaji->namapenghargaan = $request['namapenghargaan'];
        $gaji->nosk = $request['nosk'];
        $gaji->tglsk = valid_date($request['tglsk']);
        $gaji->asalpenghargaan = $request['asalpenghargaan'];
        $gaji->pemberipenghargaan = $request['pemberipenghargaan'];
        $gaji->save();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $penghargaan = HrdPenghargaan::find($id);
        $penghargaan->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function ($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/penghargaan/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataPenghargaan($biodata_id)
    {
        $penghargaan = HrdPenghargaan::where('biodata_id', $biodata_id)->get();
        return DataTables::of($penghargaan)
        ->addIndexColumn()
        ->addColumn('tglsk', function ($penghargaan) {
            return tgl_indo($penghargaan->tglsk);
        })
        ->addColumn('action', function ($penghargaan) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $penghargaan->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $penghargaan->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }
}
