<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdGajiBerkala;
use App\HRD\HrdBiodata;
use Validator;
use Yajra\DataTables\DataTables;

class GajiBerkalaController extends Controller
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
            'noskkgb' => 'required',
            'tglskkgb' => 'required',
            'pangkat' => 'required',
            'golongan' => 'required',
            'gajipokok' => 'required',
            'tmtkgb' => 'required',
            'tmtyad' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $gaji = new HrdGajiBerkala();
            $gaji->biodata_id = $request['biodata_id'];
            $gaji->noskkgb = $request['noskkgb'];
            $gaji->tglskkgb = valid_date($request['tglskkgb']);
            $gaji->pangkat = $request['pangkat'];
            $gaji->golongan = $request['golongan'];
            $gaji->gajipokok = rupiah($request['gajipokok']);
            $gaji->tmtkgb = valid_date($request['tmtkgb']);
            $gaji->tmtyad = valid_date($request['tmtyad']);
            $gaji->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $gaji = HrdGajiBerkala::find($id);
        $gaji->Tglskkgb = tgl_indo($gaji->tglskkgb);
        $gaji->Tmtkgb = tgl_indo($gaji->tmtkgb);
        $gaji->Tmtyad = tgl_indo($gaji->tmtyad);
        return response()->json($gaji);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.gaji_berkala.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $gaji = HrdGajiBerkala::find($id);
        $gaji->biodata_id = $request['biodata_id'];
        $gaji->noskkgb = $request['noskkgb'];
        $gaji->tglskkgb = valid_date($request['tglskkgb']);
        $gaji->pangkat = $request['pangkat'];
        $gaji->golongan = $request['golongan'];
        $gaji->gajipokok = rupiah($request['gajipokok']);
        $gaji->tmtkgb = valid_date($request['tmtkgb']);
        $gaji->tmtyad = valid_date($request['tmtyad']);
        $gaji->update();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $gaji = HrdGajiBerkala::find($id);
        $gaji->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function ($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/gaji/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataGaji($biodata_id)
    {
        $gaji = HrdGajiBerkala::where('biodata_id', $biodata_id)->get();
        return DataTables::of($gaji)
        ->addIndexColumn()
        ->addColumn('gaji', function ($gaji) {
            return number_format($gaji->gajipokok);
        })
        ->addColumn('tglskkgb', function ($gaji) {
            return tgl_indo($gaji->tglskkgb);
        })
        ->addColumn('tmtkgb', function ($gaji) {
            return tgl_indo($gaji->tmtkgb);
        })
        ->addColumn('tmtyad', function ($gaji) {
            return tgl_indo($gaji->tmtyad);
        })
        ->addColumn('action', function ($gaji) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $gaji->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $gaji->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }
}
