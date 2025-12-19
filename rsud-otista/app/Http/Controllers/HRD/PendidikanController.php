<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdBiodata;
use App\HRD\HrdPendidikanFormal;
use Validator;
use Yajra\DataTables\DataTables;
use Flashy;

class PendidikanController extends Controller
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
            'pendidikan_id' => 'required',
            'jurusan' => 'required',
            'sekolah' => 'required',
            'status' => 'required',
            'akreditasi' => 'required',
            'alamatsekolah' => 'required',
            'tglsttb' => 'required',
            'tahunmasuk' => 'required',
            'tahunlulus' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $pendidikan = new HrdPendidikanFormal();
            $pendidikan->biodata_id = $request['biodata_id'];
            $pendidikan->pendidikan_id = $request['pendidikan_id'];
            $pendidikan->jurusan = $request['jurusan'];
            $pendidikan->sekolah = $request['sekolah'];
            $pendidikan->status = $request['status'];
            $pendidikan->akreditasi = $request['akreditasi'];
            $pendidikan->alamatsekolah = $request['alamatsekolah'];
            $pendidikan->tglsttb = valid_date($request['tglsttb']);
            $pendidikan->tahunmasuk = $request['tahunmasuk'];
            $pendidikan->tahunlulus = $request['tahunlulus'];
            $pendidikan->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $pendidikan = HrdPendidikanFormal::find($id);
        $pendidikan->tanggalSTTB = tgl_indo($pendidikan->tglsttb);
        return response()->json($pendidikan);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.pendidikan.form', compact('biodata'));

    }

    public function update(Request $request, $id)
    {
        $pendidikan = HrdPendidikanFormal::find($id);;
        $pendidikan->biodata_id = $request['biodata_id'];
        $pendidikan->pendidikan_id = $request['pendidikan_id'];
        $pendidikan->jurusan = $request['jurusan'];
        $pendidikan->sekolah = $request['sekolah'];
        $pendidikan->status = $request['status'];
        $pendidikan->akreditasi = $request['akreditasi'];
        $pendidikan->alamatsekolah = $request['alamatsekolah'];
        $pendidikan->tglsttb = valid_date($request['tglsttb']);
        $pendidikan->tahunmasuk = $request['tahunmasuk'];
        $pendidikan->tahunlulus = $request['tahunlulus'];
        $pendidikan->update();
        return response()->json(['sukses' => true]);
    }


    public function destroy($id)
    {
        $pendidikan = HrdPendidikanFormal::find($id);
        $pendidikan->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/pendidikan/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function pendidikan($biodata_id)
    {
        $pendidikan = HrdPendidikanFormal::where('biodata_id', $biodata_id)->get();
        return DataTables::of($pendidikan)
        ->addIndexColumn()
        ->addColumn('Pendidikan', function ($pendidikan) {
            return $pendidikan->pendidikan->pendidikan;
        })
        ->addColumn('tglsttb', function ($pendidikan) {
            return tgl_indo($pendidikan->tglsttb);
        })
        ->addColumn('action', function ($pendidikan) {
            return '<div class="btn-group">' .
                ' <button type="button" onclick="edit(' . $pendidikan->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $pendidikan->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                '</div>';
        })
        ->make(true);
    }

    public function dataPendidikan()
    {
        $pendidikan = \Modules\Pendidikan\Entities\Pendidikan::all();
        return response()->json($pendidikan);
    }
}
