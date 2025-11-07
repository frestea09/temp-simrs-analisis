<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdIjinBelajar;
use App\HRD\HrdBiodata;
use Validator;
use Yajra\DataTables\DataTables;

class IjinBelajarController extends Controller
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
            'jenis' => 'required',
            'nosk' => 'required',
            'tglsk' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $ijin = new HrdIjinBelajar();
            $ijin->biodata_id = $request['biodata_id'];
            $ijin->jenis = $request['jenis'];
            $ijin->nosk = $request['nosk'];
            $ijin->tglsk = valid_date($request['tglsk']);
            $ijin->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $ijin = HrdIjinBelajar::find($id);
        $ijin->Tglsk = tgl_indo($ijin->tglsk);
        return response()->json($ijin);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.ijin_belajar.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $ijin = HrdIjinBelajar::find($id);
        $ijin->biodata_id = $request['biodata_id'];
        $ijin->jenis = $request['jenis'];
        $ijin->nosk = $request['nosk'];
        $ijin->tglsk = valid_date($request['tglsk']);
        $ijin->update();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $ijin = HrdIjinBelajar::find($id);
        $ijin->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function ($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/ijin/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataIjinBelajar($biodata_id)
    {
        $ijin = HrdIjinBelajar::where('biodata_id', $biodata_id)->get();
        return DataTables::of($ijin)
        ->addIndexColumn()
        ->addColumn('tglsk', function ($ijin) {
            return tgl_indo($ijin->tglsk);
        })
        ->addColumn('action', function ($ijin) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $ijin->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $ijin->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }
}
