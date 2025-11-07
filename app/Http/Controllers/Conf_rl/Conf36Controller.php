<?php

namespace App\Http\Controllers\Conf_rl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Conf_rl\M_config36;
use Validator;
use Yajra\DataTables\DataTables;
use Modules\Tarif\Entities\Tarif;
use DB;

class Conf36Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sirs.mapping.conf36.list_confrl36');
    }

    public function table_conf_rl36()
    {
        return view('sirs.mapping.conf36.table_conf36');
    }

    public function dashboard_conf()
    {
        return view('sirs.mapping.conf36.dashboardConf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'kegiatan' => 'required|unique:M_config36,kegiatan'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $insert = M_config36::insert($request->all());

            return response()->json(['sukses' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = M_config36::where('id_conf_rl36', $id)->first();

        return response()->json($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $show = M_config36::where('id_conf_rl36', $id)->first();
        return response()->json($show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'kegiatan' => 'required|unique:conf_rl36,kegiatan'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $affected =  M_config36::where('id_conf_rl36', $id)
                ->update([
                    'nomer' => $request['nomer'],
                    'kegiatan' => $request['kegiatan']
                ]);
            return response()->json(['sukses' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function add_mapping(Request $request, $id)
    {
        $request->session()->put('conf_rl36_id', $id);
        $data_mapping = M_config36::where('id_conf_rl36', $id)->get();
        return view('sirs.mapping.conf36.mapping_tarif', compact('data_mapping'));
    }

    public function data_list(Request $request)
    {
        $jenis = $request->jenis;
        if ($jenis == 'laporan') {
            $data =  M_config36::leftJoin('tarifs', 'tarifs.conf_rl36_id', '=', 'conf_rl36.id_conf_rl36')
                ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
                // ->where('tarifs.conf_rl36_id', 1)
                ->selectRaw('conf_rl36.*, COUNT(folios.tarif_id) as count')
                ->groupBy('conf_rl36.id_conf_rl36')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $show =  'show(' . $row->id_conf_rl36 . ')';
                    $edit =  'edit(' . $row->id_conf_rl36 . ')';
                    $hapus =  'hapus(' . $row->id_conf_rl36 . ')';
                    $image =  'image(' . $row->id_conf_rl36 . ')';
                    $btn = " <button type='button' onclick='editForm($row->id_conf_rl36)' class='btn btn-info btn-flat btn-sm'>
                            <i class='fa fa-edit'></i>
                         </button>
                        <a href='" . route('mastermapping_confrl36.mapping', $row->id_conf_rl36) . "' class='btn btn-primary btn-flat btn-sm'><i class='fa fa-map'></i> </a>
                        <button type='button' onclick='detailconfrl36($row->id_conf_rl36)' class='btn btn-warning btn-flat btn-sm'>
                            <i class='fa fa-folder-open'></i>
                         </button>";
                    return $btn;
                })
                ->addColumn('kode_propinsi', function ($row) {
                    $data = config('app.propinsi');
                    return $data;
                })
                ->addColumn('kabupaten', function ($row) {
                    $data = config('app.kabupaten');
                    return $data;
                })
                ->addColumn('kode_rs', function ($row) {
                    $data = config('app.kode_rs');
                    return $data;
                })
                ->addColumn('nama_rs', function ($row) {
                    $data = config('app.nama');
                    return $data;
                })
                ->addColumn('tahun', function ($row) {
                    $data = 2020;
                    return $data;
                })
                ->addColumn('jumlah', function ($row) {
                    // $data = 20;
                    // // $tarif = Tarif::where('conf_rl36_id', $row->id_conf_rl36)->count() ;  
                    // $tarif = DB::table('folios')->whereNull('deleted_at')
                    //     ->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                    //     ->where('conf_rl36_id', $row->id_conf_rl36)
                    //     ->count();
                    return $row->count;
                })
                ->rawColumns(['action'])
                ->toJson();
        } else {
            return Datatables::of(M_config36::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $show =  'show(' . $row->id_conf_rl36 . ')';
                    $edit =  'edit(' . $row->id_conf_rl36 . ')';
                    $hapus =  'hapus(' . $row->id_conf_rl36 . ')';
                    $image =  'image(' . $row->id_conf_rl36 . ')';
                    $btn = " <button type='button' onclick='editForm($row->id_conf_rl36)' class='btn btn-info btn-flat btn-sm'>
                            <i class='fa fa-edit'></i>
                         </button>
                        <a href='" . route('mastermapping_confrl36.mapping', $row->id_conf_rl36) . "' class='btn btn-primary btn-flat btn-sm'><i class='fa fa-map'></i> </a>
                        <button type='button' onclick='detailconfrl36($row->id_conf_rl36)' class='btn btn-warning btn-flat btn-sm'>
                            <i class='fa fa-folder-open'></i>
                         </button>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }
    public function dataTarif($tahuntarif_id = '', $jenis = '', $kategoritarif_id = '')
    {
        if ($kategoritarif_id) {
            $tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('conf_rl36_id', '=', NULL)->get();
            $kiri = ceil($tarif->count() / 2);
            $dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('conf_rl36_id', '=', NULL)->skip(0)->take($kiri)->get();
            $dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('conf_rl36_id', '=', NULL)->skip($kiri)->take($kiri)->get();
        } else {
            $tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('conf_rl36_id', '=', NULL)->get();
            $kiri = ceil($tarif->count() / 2);
            $dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('conf_rl36_id', '=', NULL)->skip(0)->take($kiri)->get();
            $dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('conf_rl36_id', '=', NULL)->skip($kiri)->take($kiri)->get();
        }
        return view('sirs.mapping.conf36.data_tarif', compact('tarif', 'dataKiri', 'dataKanan'))->with('no', 1);
    }

    public function simpan_conf_rl36(Request $request)
    {
        $total = count($request->tarif);
        $conf_rl36_id = $request->conf_rl36_id;

        $id = [];
        foreach ($request->tarif as $key => $val) {
            if (!empty($val)) {
                $tarif =  Tarif::where('id', $val)
                    ->update([
                        'conf_rl36_id' => $conf_rl36_id
                    ]);
                array_push($id, $val);
            }
        }
        $trf = Tarif::whereIn('id', $id)->get();
        return response()->json(['sukses' => true, 'message' => $trf->count() . ' tarif berhasil di mapping']);
    }

    public function detailconfrl36($id)
    {
        $tarif = Tarif::where('conf_rl36_id', $id)->get();
        return DataTables::of($tarif)
            ->addIndexColumn()
            ->addColumn('total', function ($tarif) {
                return number_format($tarif->total);
            })
            ->addColumn('hapus', function ($tarif) {
                return '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapusMapping(' . $tarif->conf_rl36_id . ',' . $tarif->id . ')"><i class="fa fa-remove"></i></button>';
            })
            ->rawColumns(['hapus'])
            ->make(true);
    }

    public function hapus_detail_conf_rl36($tarif_id)
    {
        $tarif = Tarif::find($tarif_id);
        $tarif->conf_rl36_id = NULL;
        $tarif->update();
        return $tarif;
    }
}
