<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdBiodata;
use App\HRD\HrdKepangkatan;
use Validator;
use Yajra\DataTables\DataTables;
use Flashy;

class KepangkatanController extends Controller
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
            'pangkat' => 'required',
            'golongan' => 'required',
            'nosk' => 'required',
            'tglsk' => 'required',
            'tmtpangkat' => 'required',
            'mkgtahun' => 'required',
            'mkgbulan' => 'required',
            'gajipokok' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $kepangkatan = new HrdKepangkatan();
            $kepangkatan->biodata_id = $request['biodata_id'];
            $kepangkatan->jenis = $request['jenis'];
            $kepangkatan->pangkat = $request['pangkat'];
            $kepangkatan->golongan = $request['golongan'];
            $kepangkatan->nosk = $request['nosk'];
            $kepangkatan->tglsk = valid_date($request['tglsk']);
            $kepangkatan->tmtpangkat = valid_date($request['tmtpangkat']);
            $kepangkatan->mkgtahun = $request['mkgtahun'];
            $kepangkatan->mkgbulan = $request['mkgbulan'];
            $kepangkatan->gajipokok = rupiah($request['gajipokok']);
            $kepangkatan->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $kepangkatan = HrdKepangkatan::find($id);
        $kepangkatan->tglSK = tgl_indo($kepangkatan->tglsk);
        $kepangkatan->tmtPangkat = tgl_indo($kepangkatan->tmtpangkat);
        $kepangkatan->Gajipokok = number_format($kepangkatan-> gajipokok);
        return response()->json($kepangkatan);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.kepangkatan.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $kepangkatan = HrdKepangkatan::find($id);
        $kepangkatan->biodata_id = $request['biodata_id'];
        $kepangkatan->jenis = $request['jenis'];
        $kepangkatan->pangkat = $request['pangkat'];
        $kepangkatan->golongan = $request['golongan'];
        $kepangkatan->nosk = $request['nosk'];
        $kepangkatan->tglsk = valid_date($request['tglsk']);
        $kepangkatan->tmtpangkat = valid_date($request['tmtpangkat']);
        $kepangkatan->mkgtahun = $request['mkgtahun'];
        $kepangkatan->mkgbulan = $request['mkgbulan'];
        $kepangkatan->gajipokok = rupiah($request['gajipokok']);
        $kepangkatan->update();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $kepangkatan = HrdKepangkatan::find($id);
        $kepangkatan->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/kepangkatan/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataKepangakatan($biodata_id)
    {
        $kepangkatan = HrdKepangkatan::where('biodata_id', $biodata_id)->get();
        return DataTables::of($kepangkatan)
        ->addIndexColumn()
        ->addColumn('gajipokok', function($kepangkatan) {
            return number_format($kepangkatan->gajipokok);
        })
        ->addColumn('tglsk', function ($kepangkatan) {
            return tgl_indo($kepangkatan->tglsk);
        })
        ->addColumn('tmtpangkat', function ($kepangkatan) {
            return tgl_indo($kepangkatan->tmtpangkat);
        })
        ->addColumn('action', function($kepangkatan) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $kepangkatan->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $kepangkatan->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }
}
