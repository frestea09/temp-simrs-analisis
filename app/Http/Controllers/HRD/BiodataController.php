<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdBiodata;
use App\Http\Requests\SaveBiodataRequest;
use Validator;
use Yajra\DataTables\DataTables;
use File;
use Image;
use Flashy;
use Laracasts\Flash\Flash;
use Modules\Pegawai\Entities\Pegawai;
use DB;

class BiodataController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $agama = \Modules\Pasien\Entities\Agama::all();
        $provinsi = \Modules\Pasien\Entities\Province::all();
        return view( 'hrd.biodata.form', compact('agama','provinsi') );
    }

    public function store(Request $request)
    {
        $cek =  Validator::make($request->all(),[
            'namalengkap' => 'required',
            'tmplahir'  => 'required',
            'tgllahir'  => 'required',
            'suku'  => 'required',
            'warganegara'   => 'required',
            'alamat'    => 'required',
            'province_id'   => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'notlp' => 'required',
            'nohp'  => 'required',
            'kdpos' => 'required',
            'email' => 'required',
            'nokartupegawai' => 'required',
        ]);

        if($cek->fails()){
            return response()->json([ 'sukses' => false, 'error' => $cek->errors()]);
        }else{
            if (!empty($request->file('foto'))) {
                $image = time() . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('images/pegawai/', $image);
                Image::make(public_path() . '/images/pegawai/' . $image)->resize(200, 200)->save();
            } else {
                $image = 'foto.jpg';
            }

            $biodata = new HrdBiodata();
            $biodata->pegawai_id = $request['pegawai_id'];
            $biodata->namalengkap = $request['namalengkap'];
            $biodata->tmplahir = $request['tmplahir'];
            $biodata->tgllahir = valid_date($request['tgllahir']);
            $biodata->kelamin = $request['kelamin'];
            $biodata->goldarah = $request['goldarah'];
            $biodata->suku = $request['suku'];
            $biodata->agama_id = $request['agama_id'];
            $biodata->warganegara = $request['warganegara'];
            $biodata->statuskawin = $request['statuskawin'];
            $biodata->alamat = $request['alamat'];
            $biodata->province_id = $request['province_id'];
            $biodata->regency_id = $request['regency_id'];
            $biodata->district_id = $request['district_id'];
            $biodata->village_id = $request['village_id'];
            $biodata->notlp = $request['notlp'];
            $biodata->nohp = $request['nohp'];
            $biodata->kdpos = $request['kdpos'];
            $biodata->email = $request['email'];
            $biodata->gelar_dpn = $request['gelar_dpn'];
            $biodata->gelar_blk = $request['gelar_blk'];
            $biodata->tmtcpns = valid_date($request['tmtcpns']);
            $biodata->dupeg = $request['dupeg'];
            $biodata->nokartupegawai = $request['nokartupegawai'];
            $biodata->noktp = $request['noktp'];
            $biodata->noaskes = $request['noaskes'];
            $biodata->notaspen = $request['notaspen'];
            $biodata->npwp = $request['npwp'];
            $biodata->nokarsu = $request['nokarsu'];
            $biodata->jenisfungsional = $request['jenisfungsional'];
            $biodata->fungsional = $request['fungsional'];
            $biodata->fungsionaltertentu = $request['fungsionaltertentu'];
            $biodata->foto = $image;
            $biodata->save();
            Flashy::success('Biodata berhasil ditambah !');
            return response()->json(['error' => $cek->errors(), 'sukses' => true]);
        }
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $biodata = HrdBiodata::with(['pegawai'])->find($id);
        $biodata->tanggalLahir = tgl_indo($biodata->tgllahir);
        $biodata->TMTCPNS   = ($biodata->tmtcpns != null) ? tgl_indo($biodata->tmtcpns) : null;
        $agama = \Modules\Pasien\Entities\Agama::all();
        $provinsi = \Modules\Pasien\Entities\Province::all();
        $kabupaten = isset(\Modules\Pasien\Entities\Regency::find($biodata->regency_id)->name) ? \Modules\Pasien\Entities\Regency::find($biodata->regency_id)->name : null;
        $kecamatan = isset(\Modules\Pasien\Entities\District::find($biodata->district_id)->name) ? \Modules\Pasien\Entities\District::find($biodata->district_id)->name : null;
        $desa = isset(\Modules\Pasien\Entities\Village::find($biodata->village_id)->name) ? \Modules\Pasien\Entities\Village::find($biodata->village_id)->name : null;
        // return $biodata; die;
        return view('hrd.biodata.form', compact('biodata','agama','provinsi','kabupaten','kecamatan','desa'));
    }

    public function update(Request $request, $id)
    {
        $cek =  Validator::make($request->all(), [
            'namalengkap' => 'required',
            'tmplahir'  => 'required',
            'tgllahir'  => 'required',
            'suku'  => 'required',
            'warganegara'   => 'required',
            'alamat'    => 'required',
            'province_id'   => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'notlp' => 'required',
            'nohp'  => 'required',
            'kdpos' => 'required',
            'email' => 'required',
            'nokartupegawai' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['error' => $cek->errors(), 'sukses ' => false]);
        } else {
            DB::beginTransaction();
		    try {
                $biodata = HrdBiodata::find($id);
                if (!empty($request->file('foto'))) {
                    $image = time() . $request->file('foto')->getClientOriginalName();
                    $request->file('foto')->move('images/pegawai/', $image);
                    Image::make(public_path() . '/images/pegawai/' . $image)->resize(200, 200)->save();
                    File::delete('images/pegawai/' . $biodata->foto);
                } else {
                    $image = $biodata->foto;
                }
                $biodata->namalengkap = $request['namalengkap'];
                if($request['pegawai_id'] != null){
                    $biodata->pegawai_id = $request['pegawai_id'];
                }
                $biodata->tmplahir = $request['tmplahir'];
                $biodata->tgllahir = valid_date($request['tgllahir']);
                $biodata->kelamin = $request['kelamin'];
                $biodata->goldarah = $request['goldarah'];
                $biodata->suku = $request['suku'];
                $biodata->agama_id = $request['agama_id'];
                $biodata->warganegara = $request['warganegara'];
                $biodata->statuskawin = $request['statuskawin'];
                $biodata->alamat = $request['alamat'];
                $biodata->province_id = $request['province_id'];
                $biodata->regency_id = $request['regency_id'];
                $biodata->district_id = $request['district_id'];
                $biodata->village_id = $request['village_id'];
                $biodata->notlp = $request['notlp'];
                $biodata->nohp = $request['nohp'];
                $biodata->kdpos = $request['kdpos'];
                $biodata->email = $request['email'];
                $biodata->gelar_dpn = $request['gelar_dpn'];
                $biodata->gelar_blk = $request['gelar_blk'];
                $biodata->tmtcpns = ($request['tmtcpns'] != null) ? valid_date($request['tmtcpns']) : null;
                $biodata->dupeg = $request['dupeg'];
                $biodata->nokartupegawai = $request['nokartupegawai'];
                $biodata->noktp = $request['noktp'];
                $biodata->noaskes = $request['noaskes'];
                $biodata->notaspen = $request['notaspen'];
                $biodata->npwp = $request['npwp'];
                $biodata->nokarsu = $request['nokarsu'];
                $biodata->jenisfungsional = $request['jenisfungsional'];
                $biodata->fungsional = $request['fungsional'];
                $biodata->fungsionaltertentu = $request['fungsionaltertentu'];
                $biodata->foto = $image;
                $biodata->update();
                // update table pegawai
                $peg = Pegawai::find($request['pegawai_id']);
                if(isset($find)){
                    $agama = "islam";
                    if( $pegawai->agama == 1 ) $agama = "islam";
                    if( $pegawai->agama == 2 ) $agama = "kristen";
                    if( $pegawai->agama == 3 ) $agama = "katolik";
                    if( $pegawai->agama == 4 ) $agama = "hindu";
                    if( $pegawai->agama == 5 ) $agama = "budha";
                    if( $pegawai->agama == 6 ) $agama = "konghucu";
                    $pegawai = [
                        "nama" => $request['namalengkap'],
                        "tmplahir" => $request['tmplahir'],
                        "tgllahir" => valid_date($request['tgllahir']),
                        "kelamin" => $request['kelamin'],
                        "agama" => $agama,
                        "nik" => $request['noktp'],
                        "alamat" => $request['alamat'],
                    ];
                    $peg->update($pegawai);
                }
                DB::commit();

                // Flashy::info('Biodata berhasil diupdate !');
                return response()->json(['error' => 'null', 'sukses' => true]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage(), 'sukses' => false]);
            }
        }
    }

    public function destroy($id)
    {
        //
    }
    
    public function data()
    {
        $biodata = HrdBiodata::with(['pegawai'])->get();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('nama', function ($biodata) {
            if($biodata->gelar_dpn){
                return $biodata->gelar_dpn . '. ' .$biodata->namalengkap . ', ' . $biodata->gelar_blk;
            }else{
                return $biodata->namalengkap . ', ' . $biodata->gelar_blk;
            }
        })
        ->addColumn('kelamin', function ($biodata)
        {
            return ($biodata->kelamin == 'L') ? 'Laki-Laki' : 'Perempuan';
        })
        ->addColumn('ttl', function ($biodata)
        {
            return $biodata->tmplahir.', '.tgl_indo($biodata->tgllahir);
        })
        ->addColumn('status', function ($biodata)
        {
            // if( $biodata->pegawai->is_mutasi == 1 ){
            //     return 'mutasi';
            // }elseif( $biodata->pegawai->is_pensiun == 1 ){
            //     return 'pensiun';
            // }
        })
        ->addColumn('action', function ($biodata){
            return '<div class="btn-group">'. 
            ' <a href="/hrd/biodata/'.$biodata->id.'/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
            '</div>';
        })
        ->make(true);
    }

    public function searchPegawai(Request $request)
    {
        $peg = HrdBiodata::whereNotNull('pegawai_id')->get();
    
        foreach($peg as $v){
            $notIn[] = $v->pegawai_id;
        }
        $find = Pegawai::where('nama','LIKE','%'.$request->q.'%')->whereNotIn('id',$notIn)->limit(10)->get();
        $res = [];
        foreach ($find as $val){
            $res[] = [
                "id" => $val->id,
                "text" => $val->nama
            ];
        }
        return response()->json($res);
    }
}
