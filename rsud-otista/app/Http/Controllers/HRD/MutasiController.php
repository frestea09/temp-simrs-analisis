<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Pegawai\Entities\Pegawai;
use Yajra\DataTables\DataTables;
use App\HRD\HrdBiodata;
use App\HRD\HrdMutasi;
use Carbon\Carbon;
use Flashy;
use DB;

class MutasiController extends Controller
{
    public function index()
    {
        return view('hrd.mutasi.index');
    }

    public function create($id)
    {
        $data['biodata'] = HrdBiodata::find($id);
        return view('hrd.mutasi.create',compact('data'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // update hrd biodata 
            $find = HrdBiodata::find($request->biodata_id);
            $find->update(['is_mutasi' => 1]);
            // update pegawai 
            $peg = Pegawai::find($request->pegawai_id);
            $peg->update(['is_mutasi' => 1, 'aktif' => 'N']);
            // create table mutasi
            $data = [
                "pegawai_id" => $request->pegawai_id,
                "biodata_id" => $request->biodata_id,
                "tgl_mutasi" => Carbon::parse($request->tgl_mutasi)->format('Y-m-d'),
                "keterangan" => $request->keterangan,
                "status" => "keluar"
            ];
            HrdMutasi::create($data);

            DB::commit();
            Flashy::success('Mutasi Pegawai Berhasil Dibuat');
            return redirect('hrd/mutasi');
        } catch (\Exception $e) {
            DB::rollback();
            Flashy::warning('Mutasi Pegawai Gagal Dibuat'. $e->getMessage());
            return redirect()->back();
        }
    }

    public function detail($id)
    {
        $biodata = HrdBiodata::find($id);
        $mutasi = HrdMutasi::where('biodata_id',$id)->get();

        $html = '';
        if( isset($biodata) ){
            if( count($mutasi) > 0 ){
                foreach( $mutasi as $key => $val ){
                    $html .= '<tr>
                            <td>'.($key+1).'</td>
                            <td>'.Carbon::parse($val->tgl_mutasi)->format('d-m-Y').'</td>
                            <td>'.$val->keterangan.'</td>
                        </tr>';
                }
            }else{
                $html = '<tr><td colspan="5" class="text-center">Data Tidak Ditemukan</td></tr>';
            }
            $bio = [
                "nama" => $biodata->namalengkap,
                "ttl" => $biodata->tmplahir.', '.$biodata->tgllahir,
                "alamat" => $biodata->alamat
            ];
        }else{
            $html = '<tr><td colspan="5" class="text-center">Data Tidak Ditemukan</td></tr>';
            $bio = [];
        }

        $res = [
            "status"=> true,
            "html" => $html,
            "data" => $bio
        ];
        return response()->json($res);
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // update hrd biodata 
            $find = HrdBiodata::find($request->id);
            $find->update(['is_mutasi' => 0]);
            // update pegawai 
            $peg = Pegawai::find($find->pegawai_id);
            $peg->update(['is_mutasi' => 0, 'aktif' => 'Y']);
            // create table mutasi
            // $mutasi = HrdMutasi::where('biodata_id',$id)->first();
            // $mutasi->delete();

            DB::commit();
            $res = [
                "status"=> true,
                "msg" => "Mutasi Berhasil Dihapus"
            ];
            return response()->json($res);
        } catch (\Exception $e) {
            DB::rollback();
            
            $res = [
                "status"=> fasle,
                "msg" => $e->getMessage()
            ];
            return response()->json($res);
        }
    }

    public function data()
    {
        $biodata = HrdBiodata::all();
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('nama', function ($biodata) {
            return $biodata->gelar_dpn . '. ' .$biodata->namalengkap . ', ' . $biodata->gelar_blk;
        })
        ->addColumn('kelamin', function ($biodata)
        {
            return ($biodata->kelamin == 'L') ? 'Laki-Laki' : 'Perempuan';
        })
        ->addColumn('ttl', function ($biodata)
        {
            return $biodata->tmplahir.', '.tgl_indo($biodata->tgllahir);
        })
        ->editColumn('status', function ($biodata)
        {
            return $biodata->is_mutasi == 1 ? "mutasi" : "";
        })
        ->addColumn('action', function ($biodata){
            if( $biodata->is_mutasi == 1 ){
                return '<a href="#" data-id="'.$biodata->id.'" class="btn btn-info btn-flat btn-detail"> <i class="fa fa-archive"></i></a> ' .
                        ' <a href="#" data-id="'.$biodata->id.'" class="btn btn-danger btn-flat btn-hapus"> <i class="fa fa-trash-o"></i></a> ';
            }else{
                return ' <a href="#" data-id="'.$biodata->id.'" class="btn btn-info btn-flat btn-detail"> <i class="fa fa-archive"></i></a>
                <a href="/hrd/mutasi/create/'.$biodata->id.'" class="btn btn-primary btn-flat"> <i class="fa fa-plus"></i></a> ';
            }
        })
        ->make(true);
    }
}
