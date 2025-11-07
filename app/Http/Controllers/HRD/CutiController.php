<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdCuti;
use App\HRD\HrdBiodata;
use App\HRD\HrdApproveCuti;
use Validator;
use Yajra\DataTables\DataTables;
use App\HRD\HrdJenisCuti;
use App\HRD\HrdStruktur;
use Modules\Pegawai\Entities\Pegawai;
use App\pendidikan_kualifikasi;
use Carbon\Carbon;
use Flashy;
use Auth;
use PDF;
use DB;

class CutiController extends Controller
{

    public function index()
    {
        $data['jenis_cuti'] = HrdJenisCuti::all();
        return view('hrd.cuti.index',compact('data'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek =  Validator::make($request->all(), [
            'tglmulai' => 'required',
            'tglselesai' => 'required',
            'jenis_cuti_id' => 'required',
            // 'lama_cuti' => 'required',
            'alamat_cuti' => 'required',
            'telepon' => 'required',
            'alasan_cuti' => 'required',
            // 'nosk' => 'required',
            // 'tglsk' => 'required',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            DB::beginTransaction();
		    try {
                // $cuti = new HrdCuti();
                // $cuti->biodata_id = $request['biodata_id'];
                // $cuti->tglmulai = valid_date($request['tglmulai']);
                // $cuti->tglselesai = valid_date($request['tglselesai']);
                // $cuti->nosk = $request['nosk'];
                // $cuti->tglsk = valid_date($request['tglsk']);
                // $cuti->save();
                $tglMulai = Carbon::parse($request->tglmulai);
                $tglSelesai = Carbon::parse($request->tglselesai);
                $lamaCuti = $tglMulai->diffInDays($tglSelesai);
                $data = [
                    'pegawai_id' => $request->pegawai_id,
                    'biodata_id' => $request->biodata_id,
                    'jenis_cuti_id' => $request->jenis_cuti_id,
                    'tglmulai' => valid_date($request->tglmulai),
                    'tglselesai' => valid_date($request->tglselesai),
                    // 'nosk' => $request->,
                    // 'tglsk' => $request->,
                    'lama_cuti' => $lamaCuti+1,
                    'alamat_cuti' => $request->alamat_cuti,
                    'telepon' => $request->telepon,
                    // 'kepala_ruangan_approved_by' => $request->,
                    // 'kepala_ruangan_approved_at' => $request->,
                    // 'kepala_instalasi_approved_by' => $request->,
                    // 'kepala_instalasi_approved_at' => $request->,
                    // 'kasubid_approved_by' => $request->,
                    // 'kasubid_approved_at' => $request->,
                    // 'ppk_approved_by' => $request->,
                    // 'ppk_approved_at' => $request->,
                    // 'status_kepala_ruangan' => $request->,
                    // 'status_kepala_instalasi' => $request->,
                    // 'status_kasubid' => $request->,
                    // 'status_ppk' => $request->,
                    'status_final' => "menunggu",
                    'alasan_cuti' => $request->alasan_cuti,
                    'pelimpahan_tugas' => $request->pelimpahan_tugas,
                ];

                $peg = Pegawai::with('struktur')->find($request->pegawai_id);
                if(isset($peg->struktur_id)){
                    $verify = HrdStruktur::with(['up_category'])->where('id',$peg->struktur_id)->get();
                    $parentID = [];
                    foreach( $verify as $item ){
                        if( $item->up_category !== null ){
                            $parentID[] = $item->id; 
                            $parentID[] = $this->recursiveParentUp($item->up_category);
                        }
                    }
                    $parentID = array_flatten($parentID);
                }

                $cuti = HrdCuti::create($data);

                if(isset($peg->struktur_id)){ // verifikator CUTI
                    unset($parentID[0]); // remove first array
                    if( strpos($peg->struktur->nama,'Pelaksana') !== false ){ // peg. pelaksana
                        $parentID = array_diff($parentID,[2,3,4]); // remove direktur, wadir
                        // array_shift($parentID);// remove kepala ruang
                        // dd($parentID);
                    }elseif( strpos($peg->struktur->nama,'Kepala') !== false ){ // peg. kepala
                        $parentID = array_diff($parentID,[2,3,4]); // remove direktur, wadir
                    }elseif( strpos($peg->struktur->nama,'Kepala Subbidang') !== false ){ // peg. kasubid
                        $parentID = array_diff($parentID,[2,3,4]); // remove direktur, wadir
                    }
                    $pegStruktur = Pegawai::whereIn('struktur_id',$parentID)->get();
                    $strukturOne = HrdStruktur::where('id',$peg->struktur_id)->first();
                    $approval = [];
                    foreach( $pegStruktur as $k => $v ){
                        $approval[] = [
                            "cuti_id" => $cuti->id,
                            "pegawai_id" => $v->id,
                            "struktur_id" => $v->struktur_id,
                            "status" => "menunggu",
                            "tampil" => ( $strukturOne->parent_id == $v->struktur_id ) ? "Y" : "N",
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                    }
                    HrdApproveCuti::insert($approval);
                }
                // dd($data);
                DB::commit();
                return response()->json(['error' => $cek->errors(), 'sukses' => true]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage(), 'sukses' => false]);
            }
        }
    }

    public function show($id)
    {
        $cuti = HrdCuti::find($id);
        $cuti->Tglsk = tgl_indo($cuti->tglsk);
        $cuti->Tglmulai = tgl_indo($cuti->tglmulai);
        $cuti->Tglselesai = tgl_indo($cuti->tglselesai);
        return response()->json($cuti);
    }

    public function edit($id)
    {
        // $biodata = HrdBiodata::find($id);
        $biodata = Pegawai::with(['biodata'])->find($id);
        $pegawai = Pegawai::pluck('nama','id');
        $data['jenis_cuti'] = HrdJenisCuti::all();

        return view('hrd.cuti.form', compact('biodata','data','pegawai','id'));
    }

    public function update(Request $request, $id)
    {
        $cuti = HrdCuti::find($id);
        $cuti->biodata_id = $request['biodata_id'];
        $cuti->tglmulai = valid_date($request['tglmulai']);
        $cuti->tglselesai = valid_date($request['tglselesai']);
        $cuti->nosk = $request['nosk'];
        $cuti->tglsk = valid_date($request['tglsk']);
        $cuti->update();
        return response()->json(['sukses' => true]);
    }

    public function destroy($id)
    {
        $cuti = HrdCuti::find($id);
        HrdApproveCuti::where('cuti_id',$id)->delete();
        $cuti->delete();
        return response()->json(['sukses' => true]);
    }

    public function dataPegawai()
    {
        // $biodata = HrdBiodata::all();
        if( Auth::user()->id == 1 ){ // user admin
            $biodata = Pegawai::with(['biodata'])->get();
        }else{
            $biodata = Pegawai::with(['biodata'])->where('user_id', Auth::user()->id)->get();
        }
        return DataTables::of($biodata)
        ->addIndexColumn()
        ->addColumn('action', function ($biodata) {
            return '<div class="btn-group">' .
                ' <a href="'.url('/').'/hrd/cuti/' . $biodata->id . '/edit" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a> ' .
                '</div>';
        })
        ->make(true);
    }

    public function dataCuti($biodata_id)
    {
        // $cuti = HrdCuti::where('biodata_id', $biodata_id)->get();
        $cuti = HrdCuti::where('pegawai_id', $biodata_id)->orderBy('created_at','DESC')->get();
        // dd($cuti);
        return DataTables::of($cuti)
        ->addIndexColumn()
        ->addColumn('tglmulai', function ($cuti) {
            return tgl_indo($cuti->tglmulai);
        })
        ->addColumn('tglselesai', function ($cuti) {
            return tgl_indo($cuti->tglselesai);
        })
        ->addColumn('created_at', function ($cuti) {
            return tgl_indo(Carbon::parse($cuti->created_at)->format('Y-m-d'));
        })
        ->editColumn('lama_cuti', function ($cuti) {
            return $cuti->lama_cuti.' hari';
        })
        ->addColumn('status_final', function ($cuti) {
            $status = '';
            if($cuti->status_final == "menunggu") $status = '<span class="label label-default">'.$cuti->status_final.'</span>';
            elseif($cuti->status_final == "ditolak") $status = '<span class="label label-danger">'.$cuti->status_final.'</span>';
            else $status = '<span class="label label-success">'.$cuti->status_final.'</span>';
            return $status;
        })
        // ->addColumn('tglsk', function ($cuti) {
        //     return tgl_indo($cuti->tglsk);
        // })
        ->addColumn('action', function ($cuti) {
            return '<div class="btn-group">' .
                // ' <button type="button" onclick="edit(' . $cuti->id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></button> ' .
                ' <button type="button" onclick="hapus(' . $cuti->id . ')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></button> ' .
                ' <button type="button" onclick="verify(' . $cuti->id . ')" class="btn btn-default btn-flat btn-sm"><i class="fa fa-users"></i></button> ' .
                '</div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle btn-flat btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-print" aria-hidden="true"></i>
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                    <li><a target="_blank" href="'.url('hrd/cuti/cetak/cuti/'.$cuti->id).'" onclick="cetak_cuti('.$cuti->id.')">Surat Cuti</a></li>
                    <li><a target="_blank" href="'.url('hrd/cuti/cetak/pernyataan/'.$cuti->id).'" onclick="cetak_pernyataan('.$cuti->id.')">Surat Pernyataan</a></li>
                    <li><a target="_blank" href="'.url('hrd/cuti/cetak/pelimpahan/'.$cuti->id).'" onclick="cetak_pelimpahan('.$cuti->id.')">Surat Pelimpahan Tugas</a></li>
                    </ul>
                </div>';
        })
        ->rawColumns(['status_final','action'])
        ->make(true);
    }

    public function recursiveParentUp($child)
    {
        $parentID = [];
        $parentID[] = $child->id; 
        if ($child->parent){
            $parentID[] = $this->recursiveParentUp( $child->parent );
            // $parentID[] = $child->up_category->id; 
        }
        return $parentID;
    }

    function array_flatten($array) {

        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){ $return = array_merge($return, array_flatten($value));}
            else {$return[$key] = $value;}
        }
        return $return;
     
    }

    public function dataVerifikator(Request $request,$id)
    {
        if($request->ajax()){
            $data = HrdApproveCuti::with(['pegawai','struktur'])->where('cuti_id',$id)->get();
            $body = '';
            foreach( $data as $key => $item ){
                if( $item->status == "menunggu" ){
                    $status = '<span class="label label-default">'.$item->status.'</span>';
                }elseif( $item->status == "disetujui" ){
                    $status = '<span class="label label-success">'.$item->status.'</span>';
                }elseif($item->status == "ditolak" ){
                    $status = '<span class="label label-danger">'.$item->status.'</span>';
                }else{
                    $status = '<span class="label label-info">'.$item->status.'</span>';
                }
                $body .= '<tr>
                        <td>'.($key+1).'</td>
                        <td>'.$item->pegawai->nama.'</td>
                        <td>'.$item->struktur->nama.'</td>
                        <td>'.$status.'</td>
                        </tr>';
            }
            if( $body == '' ){
                $body = '<tr><td colspan="6" class="text-center">Data Tidak Ditemukan</td></tr>';
            }
            $html = '<table class="table table-bordered" id="data-peg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$body.'
                    </tbody>
                    </table>
                    <script>
                    $(\'#data-peg\').DataTable({
                        \'language\'    : {
                        "url": "/json/pasien.datatable-language.json",
                        },
                        \'paging\'      : true,
                        \'lengthChange\': false,
                        \'searching\'   : true,
                        \'ordering\'    : true,
                        \'info\'        : true,
                        \'autoWidth\'   : false
                    });
                    </script>';
            $res = [
                "status" => true,
                "html" => $html
            ];
            return response()->json($res);
        }
    }

    public function verifikator(Request $request)
    {
        $user = Pegawai::where('user_id',Auth::user()->id)->first();
        $data = [];
        if( isset($user->id) ){
            $data = HrdApproveCuti::with(['cuti.pegawai.struktur','cuti.jenis_cuti'])
                    ->join('hrd_cutis','hrd_cutis.id','hrd_approved_cuti.cuti_id')
                    // ->where('hrd_cutis.status_final','!=','ditolak')
                    ->select('hrd_approved_cuti.*','hrd_cutis.status_final')
                    ->where('hrd_approved_cuti.pegawai_id',$user->id)->get();
        }
        
        return view('hrd.verifikator.index', compact('data','user'));
    }

    public function prosesVerifikator(Request $request)
    {
        DB::beginTransaction();
		try {
            $find = HrdApproveCuti::find($request->id);
            $data = $request->all();
            if( $request->tgl_awal !== null || $request->tgl_akhir !== null ){
                $data['tgl_awal'] = Carbon::parse($request->tgl_awal)->format('Y-m-d');
                $data['tgl_akhir'] = Carbon::parse($request->tgl_akhir)->format('Y-m-d');
            }
            $find->update($data);

            // validate if status semua setuju
            $status = true;
            $statusDitolak = false;
            $all_cuti = HrdApproveCuti::where('cuti_id',$find->cuti_id)->get();
            foreach( $all_cuti as $val ){
                if( $val->status == "menunggu" ){
                    $status = false;
                }elseif( $val->status == "ditolak" ){
                    $statusDitolak = true;
                }
            }
            // update status final cuti
            $status_final = [
                "status_final" => "menunggu"
            ];
            if( $statusDitolak == true ){
                $status_final = [
                    "status_final" => "ditolak"
                ];
            }elseif( $status == true ){
                $status_final = [
                    "status_final" => "disetujui"
                ];
            }
            $cuti = HrdCuti::find($find->cuti_id);
            $cuti->update($status_final);

            if( $cuti->status_final != "ditolak" ){
                // update struktur atasnya
                $strukturOne = HrdStruktur::where('id',$find->struktur_id)->first();
                if(isset($strukturOne->id)){
                    $find2 = HrdApproveCuti::where('cuti_id',$find->cuti_id)->where('struktur_id',$strukturOne->parent_id)->first();
                    if(isset($find2)){
                        $data2['tampil'] = "Y";
                        $find2->update($data2);
                    }
                }
            }else{
                 // update struktur atasnya
                 $strukturOne = HrdStruktur::where('id',$find->struktur_id)->first();
                 if(isset($strukturOne->id)){
                     $find2 = HrdApproveCuti::where('cuti_id',$find->cuti_id)->where('struktur_id',$strukturOne->parent_id)->first();
                     if(isset($find2)){
                        $data2['tampil'] = "N";
                        $find2->update($data2);
                     }
                 }
            }

            DB::commit();

            Flashy::success('Persetujuan Cuti Berhasil Diperbarui');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage(), 'sukses' => false]);
        }
    }

    public function sinkronPegawai()
    {
        $exist = HrdBiodata::whereNotNull('pegawai_id')->get();
        $existID = [];
        foreach( $exist as $val ){
            $existID[] = $val->pegawai_id;
        }
        $pegawai = Pegawai::whereNotIn('id',$existID)->get();
        return view('hrd/sinkron/index',compact('pegawai'));
    }

    public function prosesSinkronPegawai(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
		try {
            $exist = HrdBiodata::whereNotNull('pegawai_id')->get();
            $existID = [];
            foreach( $exist as $val ){
                $existID[] = $val->pegawai_id;
            }
            $pegawai = Pegawai::whereNotIn('id',$existID)->limit(20)->get();

            $biodata = [];
            foreach($pegawai as $peg){
                $agama = 1;
                if( $peg->agama == "islam" ) $agama = 1;
                if( $peg->agama == "kristen" ) $agama = 2;
                if( $peg->agama == "katolik" ) $agama = 3;
                if( $peg->agama == "hindu" ) $agama = 4;
                if( $peg->agama == "budha" ) $agama = 5;
                if( $peg->agama == "konghucu" ) $agama = 6;
                $biodata[] = [
                    "pegawai_id" => $peg->id,
                    "namalengkap" => $peg->nama,
                    "tmplahir" => $peg->tmplahir,
                    "tgllahir" => $peg->tgllahir,
                    "kelamin" => $peg->kelamin,
                    "agama_id" => $agama,
                    "noktp" => $peg->nik,
                    "alamat" => $peg->alamat,
                    "created_at" => Carbon::now(),
                    "created_at" => Carbon::now(),
                ];
            }
            HrdBiodata::insert($biodata);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }

    public function cetakCuti(Request $request, $id)
    {
        $data['cuti'] = HrdCuti::with(['pegawai.struktur','jenis_cuti','pegawai_pelimpahan','approve_cuti.pegawai','approve_cuti.struktur'])->find($id);
        // dd($data);
        $data['jenis'] = HrdJenisCuti::all();
        $data['cuti_tahunan'] = HrdCuti::where('pegawai_id',$data['cuti']->pegawai_id)->where('jenis_cuti_id',1)->whereYear('created_at',Carbon::now())->count();
        $data['cuti_sakit'] = HrdCuti::where('pegawai_id',$data['cuti']->pegawai_id)->where('jenis_cuti_id',2)->whereYear('created_at',Carbon::now())->count();
        $data['cuti_penting'] = HrdCuti::where('pegawai_id',$data['cuti']->pegawai_id)->where('jenis_cuti_id',3)->whereYear('created_at',Carbon::now())->count();
        $data['cuti_besar'] = HrdCuti::where('pegawai_id',$data['cuti']->pegawai_id)->where('jenis_cuti_id',4)->whereYear('created_at',Carbon::now())->count();
        $data['cuti_lahir'] = HrdCuti::where('pegawai_id',$data['cuti']->pegawai_id)->where('jenis_cuti_id',5)->whereYear('created_at',Carbon::now())->count();
        $data['cuti_luar'] = HrdCuti::where('pegawai_id',$data['cuti']->pegawai_id)->where('jenis_cuti_id',6)->whereYear('created_at',Carbon::now())->count();
        return view('hrd.cuti.cetak-cuti',compact('data'));
        // $pdf = PDF::loadView('hrd.cuti.cetak-cuti', compact('data'));  
        // return $pdf->download('test.pdf');
    }

    public function cetakPernyataaan(Request $request, $id)
    {
        $data['cuti'] = HrdCuti::with(['pegawai.struktur','jenis_cuti','pegawai_pelimpahan.biodata.kepangkatan','kepangkatan'])->find($id);
        return view('hrd.cuti.cetak-pernyataan',compact('data'));
        // $pdf = PDF::loadView('hrd.cuti.cetak-pernyataan', compact('data'));  
        // return $pdf->download('test.pdf');
    }

    public function cetakPelimpahan(Request $request, $id)
    {
        $data['cuti'] = HrdCuti::with(['pegawai.struktur','jenis_cuti','pegawai_pelimpahan.biodata.kepangkatan','kepangkatan'])->find($id);
        $peg = Pegawai::with('struktur')->find($data['cuti']->pegawai_id);
        if(isset($peg->struktur_id)){
            $verify = HrdStruktur::with(['up_category'])->where('id',$peg->struktur_id)->get();
            $parentID = [];
            foreach( $verify as $item ){
                if( $item->up_category !== null ){
                    $parentID[] = $item->id; 
                    $parentID[] = $this->recursiveParentUp($item->up_category);
                }
            }
            $parentID = array_flatten($parentID);
        }

        if(isset($peg->struktur_id)){ // SEARCH WADIR
            $wadir = array_slice($parentID,-2,1);
            $data['pegStruktur'] = Pegawai::with('struktur','biodata.kepangkatan')->where('struktur_id',$wadir)->first();
        }

        return view('hrd.cuti.cetak-pelimpahan',compact('data'));
        // $pdf = PDF::loadView('hrd.cuti.cetak-pelimpahan', compact('data'));  
        // return $pdf->download('test.pdf');
    }
}
