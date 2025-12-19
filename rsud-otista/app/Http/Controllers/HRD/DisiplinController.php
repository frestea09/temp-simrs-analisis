<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdDisiplinPegawai;
use App\HRD\HrdBiodata;
use Validator;
use Yajra\DataTables\DataTables;

class DisiplinController extends Controller
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
            'unitorganisasi' => 'required',
            'unitkerja' => 'required',
            'jabatan' => 'required',
            'namadisiplin' => 'required',
            'nosk' => 'required',
            'tglsk' => 'required',
            'tmtdisiplin' => 'required',
            'tmtdaluarsa' => 'required',
            'pelanggaran' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $disiplin = new HrdDisiplinPegawai();
            $disiplin->biodata_id = $request['biodata_id'];
            $disiplin->unitorganisasi = $request['unitorganisasi'];
            $disiplin->unitkerja = $request['unitkerja'];
            $disiplin->jabatan = $request['jabatan'];
            $disiplin->namadisiplin = $request['namadisiplin'];
            $disiplin->nosk = $request['nosk'];
            $disiplin->tglsk = valid_date($request['tglsk']);
            $disiplin->tmtdisiplin = valid_date($request['tmtdisiplin']);
            $disiplin->tmtdaluarsa = valid_date($request['tmtdaluarsa']);
            $disiplin->pelanggaran = $request['pelanggaran'];
            $disiplin->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $disiplin = HrdDisiplinPegawai::find($id);
        $disiplin->Tglsk = tgl_indo($disiplin->tglsk);
        $disiplin->Tmtdisiplin = tgl_indo($disiplin->tmtdisiplin);
        $disiplin->Tmtdaluarsa = tgl_indo($disiplin->tmtdaluarsa);
        return response()->json($disiplin);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.disiplin.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $disiplin = HrdDisiplinPegawai::find($id);;
        $disiplin->biodata_id = $request['biodata_id'];
        $disiplin->unitorganisasi = $request['unitorganisasi'];
        $disiplin->unitkerja = $request['unitkerja'];
        $disiplin->jabatan = $request['jabatan'];
        $disiplin->namadisiplin = $request['namadisiplin'];
        $disiplin->nosk = $request['nosk'];
        $disiplin->tglsk = valid_date($request['tglsk']);
        $disiplin->tmtdisiplin = valid_date($request['tmtdisiplin']);
        $disiplin->tmtdaluarsa = valid_date($request['tmtdaluarsa']);
        $disiplin->pelanggaran = $request['pelanggaran'];
        $disiplin->update();
        return response()->json(['sukses' => true]);
    }


    public function destroy($id)
    {
        $disiplin = HrdDisiplinPegawai::find($id);
        $disiplin->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function ($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/disiplin/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataDisiplin($biodata_id)
    {
        $disiplin = HrdDisiplinPegawai::where('biodata_id', $biodata_id)->get();
        return DataTables::of($disiplin)
        ->addIndexColumn()
        ->addColumn('action', function ($disiplin) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $disiplin->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $disiplin->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }
}
