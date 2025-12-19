<?php

namespace App\Http\Controllers\HRD;

use App\HRD\HrdBiodata;
use App\HRD\HrdKeluarga;
use App\HRD\HrdAnak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Yajra\DataTables\DataTables;
use Flashy;

class KeluargaController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {

        return view('hrd.keluarga.form');
    }

    public function store(Request $request)
    {
        $cek =  Validator::make($request->all(), [
            'namaayah' => 'required',
            'tmplahirayah' => 'required',
            'tgllahirayah' => 'required',
            'alamatayah' => 'required',
            'nohpayah' => 'required',
            'pekerjaanayah_id' => 'required',
            'namaibu' => 'required',
            'tmplahiribu' => 'required',
            'tgllahiribu' => 'required',
            'alamatibu' => 'required',
            'nohpibu' => 'required',
            'pekerjaanibu_id' => 'required',
            'namapasangan' => 'required',
            'tmplahirpasangan' => 'required',
            'tgllahirpasangan' => 'required',
            'tglnikah' => 'required',
            'pendidikan_id' => 'required',
            'pekerjaanpasangan_id' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $cek_data = HrdKeluarga::where('biodata_id', $request['biodata_id']);

            if( $cek_data->count() > 0){
                $keluarga = HrdKeluarga::where('biodata_id', $request['biodata_id'])->first();
                $keluarga->namaayah = $request['namaayah'];
                $keluarga->biodata_id = $request['biodata_id'];
                $keluarga->tmplahirayah = $request['tmplahirayah'];
                $keluarga->alamatayah = $request['alamatayah'];
                $keluarga->nohpayah = $request['nohpayah'];
                $keluarga->tgllahirayah = valid_date($request['tgllahirayah']);
                $keluarga->pekerjaanayah_id = $request['pekerjaanayah_id'];
                $keluarga->namaibu = $request['namaibu'];
                $keluarga->tmplahiribu = $request['tmplahiribu'];
                $keluarga->tgllahiribu = valid_date($request['tgllahiribu']);
                $keluarga->alamatibu = $request['alamatibu'];
                $keluarga->nohpibu = $request['nohpibu'];
                $keluarga->pekerjaanibu_id = $request['pekerjaanibu_id'];
                $keluarga->namapasangan = $request['namapasangan'];
                $keluarga->tmplahirpasangan = $request['tmplahirpasangan'];
                $keluarga->tgllahirpasangan = valid_date($request['tgllahirpasangan']);
                $keluarga->tglnikah = valid_date($request['tglnikah']);
                $keluarga->pendidikan_id = $request['pendidikan_id'];
                $keluarga->pekerjaanpasangan_id = $request['pekerjaanpasangan_id'];
                $keluarga->update();
                Flashy::success('Data Keluarga berhasil diupdate !');
                return response()->json(['error' => $cek->errors(), 'sukses' => true]);
            } else {
                $keluarga = new HrdKeluarga();
                $keluarga->namaayah = $request['namaayah'];
                $keluarga->biodata_id = $request['biodata_id'];
                $keluarga->tmplahirayah = $request['tmplahirayah'];
                $keluarga->alamatayah = $request['alamatayah'];
                $keluarga->nohpayah = $request['nohpayah'];
                $keluarga->tgllahirayah = valid_date($request['tgllahirayah']);
                $keluarga->pekerjaanayah_id = $request['pekerjaanayah_id'];
                $keluarga->namaibu = $request['namaibu'];
                $keluarga->tmplahiribu = $request['tmplahiribu'];
                $keluarga->tgllahiribu = valid_date($request['tgllahiribu']);
                $keluarga->alamatibu = $request['alamatibu'];
                $keluarga->nohpibu = $request['nohpibu'];
                $keluarga->pekerjaanibu_id = $request['pekerjaanibu_id'];
                $keluarga->namapasangan = $request['namapasangan'];
                $keluarga->tmplahirpasangan = $request['tmplahirpasangan'];
                $keluarga->tgllahirpasangan = valid_date($request['tgllahirpasangan']);
                $keluarga->tglnikah = valid_date($request['tglnikah']);
                $keluarga->pendidikan_id = $request['pendidikan_id'];
                $keluarga->pekerjaanpasangan_id = $request['pekerjaanpasangan_id'];
                $keluarga->save();
                Flashy::success('Data Keluarga berhasil ditambah !');
                return response()->json(['error' => $cek->errors(), 'sukses' => true]);
            }
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cek = HrdKeluarga::where('biodata_id', $id);
        if ( $cek->count() > 0) {
            $biodata = HrdBiodata::find($id);
            $keluarga = HrdKeluarga::where('biodata_id', $biodata->id)->first();
            $keluarga->tanggalLahirAyah = tgl_indo($keluarga->tgllahirayah);
            $keluarga->tanggalLahirIbu = tgl_indo($keluarga->tgllahiribu);
            $keluarga->tanggalLahirPasangan = tgl_indo($keluarga->tgllahirpasangan);
            $keluarga->tanggalNikah = tgl_indo($keluarga->tglnikah);
        } else {
            $biodata = HrdBiodata::find($id);
            $keluarga = HrdKeluarga::where('biodata_id', $biodata->id)->first();
        }
        $pekerjaan = \Modules\Pasien\Entities\Pekerjaan::all();
        $pendidikan = \Modules\Pendidikan\Entities\Pendidikan::all();
        return view('hrd.keluarga.form', compact('biodata','keluarga','pekerjaan','pendidikan'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function saveDataAnak(Request $request)
    {
        $cek =  Validator::make($request->all(), [
            'nama' => 'required',
            'tmplahir' => 'required',
            'tgllahir' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $anak = new Hrdanak();
            $anak->nama = $request['nama'];
            $anak->biodata_id = $request['biodata_id'];
            $anak->tmplahir = $request['tmplahir'];
            $anak->tgllahir = valid_date($request['tgllahir']);
            $anak->kelamin = $request['kelamin'];
            $anak->anakke = $request['anakke'];
            $anak->pendidikan_id = $request['pendidikan_id'];
            $anak->pekerjaan_id = $request['pekerjaan_id'];
            $anak->save();
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function editDaataAnak($id)
    {
        $anak = HrdAnak::find($id);
        $anak->tanggalLahir = tgl_indo($anak->tgllahir);
        return response()->json($anak);
    }

    public function updateDataAnak(Request $request, $id)
    {
        $anak = HrdAnak::find($id);
        $anak->nama = $request['nama'];
        $anak->biodata_id = $request['biodata_id'];
        $anak->tmplahir = $request['tmplahir'];
        $anak->tgllahir = valid_date($request['tgllahir']);
        $anak->kelamin = $request['kelamin'];
        $anak->anakke = $request['anakke'];
        $anak->pendidikan_id = $request['pendidikan_id'];
        $anak->pekerjaan_id = $request['pekerjaan_id'];
        $anak->update();
        return response()->json(['sukses' => true]);
    }

    public function hapusAnak($id)
    {
        $anak = HrdAnak::find($id);
        $anak->delete();
        return response()->json(['sukses' => true]);
    }

    public function data()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('namaAyah', function($biodata){
            return $biodata->keluarga ? $biodata->keluarga->namaayah : NULL;
        })
        ->addColumn('namaIbu', function($biodata){
            return $biodata->keluarga ? $biodata->keluarga->namaibu : NULL;
        })
        ->addColumn('namaPasangan', function($biodata){
            return $biodata->keluarga ? $biodata->keluarga->namapasangan : NULL;
        })
        ->addColumn('action', function($biodata) {
            return '<div class="btn-group">' .
                ' <a href="/hrd/keluarga/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataAnak($biodata_id)
    {
        $anak = HrdAnak::where('biodata_id', $biodata_id);
        return DataTables::of($anak)
            ->addIndexColumn()
            ->addColumn('ttl', function ($anak) {
                return $anak->tmplahir.', '. tgl_indo($anak->tgllahir);
            })
            ->addColumn('sekolah', function ($anak) {
                return $anak->pendidikan->pendidikan;
            })
            ->addColumn('kerja', function ($anak) {
                return $anak->pekerjaan->nama;
            })
            ->addColumn('action', function ($anak) {
                return '<div class="btn-group">' .
                ' <button type="button" onclick="editAnak('.$anak->id. ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapusAnak(' . $anak->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> '. '</div>';
            })
            ->make(true);
    }

    public function dataKerja()
    {
        $kerja = \Modules\Pasien\Entities\Pekerjaan::all();
        return response()->json($kerja);
    }

    public function dataPendidikan()
    {
        $pendidikan = \Modules\Pendidikan\Entities\Pendidikan::all();
        return response()->json($pendidikan);
    }
}
