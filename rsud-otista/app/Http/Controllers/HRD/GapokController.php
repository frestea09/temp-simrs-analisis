<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdPerubahanGapok;
use App\HRD\HrdBiodata;
use Validator;
use Yajra\DataTables\DataTables;

class GapokController extends Controller
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
            'tmt' => 'required',
            'gajipokok' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $gapok = new HrdPerubahanGapok();
            $gapok->biodata_id = $request['biodata_id'];
            $gapok->jenis = $request['jenis'];
            $gapok->nosk = $request['nosk'];
            $gapok->tglsk = valid_date($request['tglsk']);
            $gapok->tmt = valid_date($request['tmt']);
            $gapok->gajipokok = rupiah($request['gajipokok']);
            $gapok->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $gapok = HrdPerubahanGapok::find($id);
        $gapok->Tglsk = tgl_indo($gapok->tglsk);
        $gapok->Tmt = tgl_indo($gapok->tmt);
        $gapok->Gajipokok = number_format($gapok->gajipokok);
        return response()->json($gapok);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.gapok.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $gapok = HrdPerubahanGapok::find($id);
        $gapok->biodata_id = $request['biodata_id'];
        $gapok->jenis = $request['jenis'];
        $gapok->nosk = $request['nosk'];
        $gapok->tglsk = valid_date($request['tglsk']);
        $gapok->tmt = valid_date($request['tmt']);
        $gapok->gajipokok = rupiah($request['gajipokok']);
        $gapok->update();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $gapok = HrdPerubahanGapok::find($id);
        $gapok->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function ($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/gapok/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataGapok($biodata_id)
    {
        $gapok = HrdPerubahanGapok::where('biodata_id', $biodata_id)->get();
        return DataTables::of($gapok)
        ->addIndexColumn()
        ->addColumn('tmt', function ($gapok) {
            return tgl_indo($gapok->tmt);
        })
        ->addColumn('tglsk', function ($gapok) {
            return tgl_indo($gapok->tglsk);
        })
        ->addColumn('gajipokok', function ($gapok) {
            return number_format($gapok->gajipokok);
        })
        ->addColumn('action', function ($gapok) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $gapok->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $gapok->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }
}
