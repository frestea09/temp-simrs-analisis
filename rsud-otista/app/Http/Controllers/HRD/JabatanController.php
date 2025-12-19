<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdBiodata;
use App\HRD\HrdJabatan;
use Validator;
use Yajra\DataTables\DataTables;

class JabatanController extends Controller
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
            'namajabatan' => 'required',
            'fungsionaltertentu' => 'required',
            'unitorganisasi' => 'required',
            'unitkerja' => 'required',
            'eselon' => 'required',
            'pangkat' => 'required',
            'golongan' => 'required',
            'tglsk' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $jabatan = new HrdJabatan();
            $jabatan->biodata_id = $request['biodata_id'];
            $jabatan->namajabatan = $request['namajabatan'];
            $jabatan->fungsionaltertentu = $request['fungsionaltertentu'];
            $jabatan->unitorganisasi = $request['unitorganisasi'];
            $jabatan->unitkerja = $request['unitkerja'];
            $jabatan->eselon = $request['eselon'];
            $jabatan->pangkat = $request['pangkat'];
            $jabatan->golongan = $request['golongan'];
            $jabatan->tglsk = valid_date($request['tglsk']);
            $jabatan->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        $jabatan = HrdJabatan::find($id);
        $jabatan->tglSK = tgl_indo($jabatan->tglsk);
        return response()->json($jabatan);
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::find($id);
        return view('hrd.jabatan.form', compact('biodata'));
    }

    public function update(Request $request, $id)
    {
        $jabatan = HrdJabatan::find($id);
        $jabatan->biodata_id = $request['biodata_id'];
        $jabatan->namajabatan = $request['namajabatan'];
        $jabatan->fungsionaltertentu = $request['fungsionaltertentu'];
        $jabatan->unitorganisasi = $request['unitorganisasi'];
        $jabatan->unitkerja = $request['unitkerja'];
        $jabatan->eselon = $request['eselon'];
        $jabatan->pangkat = $request['pangkat'];
        $jabatan->golongan = $request['golongan'];
        $jabatan->tglsk = valid_date($request['tglsk']);
        $jabatan->update();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $jabatan = HrdJabatan::find($id);
        $jabatan->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
            ->addIndexColumn()
            ->addColumn('action', function ($biodata) {
                return '<div class="btn-group">' .
                    ' <a href="/hrd/jabatan/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                    '</div>';
            })
            ->make(true);
    }
    public function dataJabatan($biodata_id)
    {
        $jabatan = HrdJabatan::where('biodata_id', $biodata_id)->get();
        return DataTables::of($jabatan)
            ->addIndexColumn()
            ->addColumn('tglsk', function ($jabatan) {
                return tgl_indo($jabatan->tglsk);
            })
            ->addColumn('action', function ($jabatan) {
                return '<div class="btn-group">' .
                    ' <button type="button" onclick="edit(' . $jabatan->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                    ' <button type="button" onclick="hapus(' . $jabatan->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .

                    '</div>';
            })
            ->make(true);
    }
}
