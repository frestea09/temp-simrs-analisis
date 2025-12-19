<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
use PDF;

class LogistikNonMedikPermintaanController extends Controller
{
    public function reset()
    {
        session()->forget('nomor');
        return view('logistik.logistiknonmedik.proses.add_permintaan');
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permintaan = \App\LogistikNonMedik\LogistikNonMedikPermintaan::latest();
            return DataTables::of($permintaan)
                ->addIndexColumn()
                ->addColumn('asal', function ($permintaan) {
                    return baca_gudang($permintaan->gudang_asal);
                })
                ->addColumn('tujuan', function ($permintaan) {
                    return baca_gudang($permintaan->gudang_tujuan);
                })
                ->addColumn('aksi', function ($permintaan) {
                    return '<a href="' . route('cetak-permintaan', $permintaan->nomor) . '" class="btn btn-info btn-sm"><i class="fa fa-print" target="_blank"></i></a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('logistik.logistiknonmedik.proses.add_permintaan');
    }

    public function data(Request $request)
    {
        if (session('nomor')) {
            $permintaan = \App\LogistikNonMedik\LogistikNonMedikPermintaan::where('nomor', session('nomor'))->get();
        } else {
            $permintaan = [];
        }
        return DataTables::of($permintaan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($permintaan) {
                return '<button type="button" onclick="hapus(\'' . $permintaan->id . '\')" class="btn btn-sm btn-danger btn-flat" title="Edit"><i class="fa fa-remove"></i></button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        session([
            'nomor' => $request['nomor'],
        ]);
        $pm = new \App\LogistikNonMedik\LogistikNonMedikPermintaan();
        $pm->nomor = $request['nomor'];
        $pm->tanggal_permintaan = valid_date($request['tanggal']);
        $pm->gudang_asal = Auth::user()->gudang_id;
        $pm->gudang_tujuan = $request['gudang_tujuan'];
        $pm->masterbarang_id = $request['masterbarang_id'];
        $pm->jumlah_permintaan = $request['jumlah_permintaan'];
        $pm->sisa_stock = $request['sisa_stock'] ? $request['sisa_stock'] : 0;
        $pm->keterangan = $request['keterangan'];
        $pm->user_id = Auth::user()->id;
        $pm->save();
        if ($pm) {
            return response()->json(['sukses' => true, 'message' => 'Permintaan berhasil disimpan']);
        }
    }

    function cetakPermintaan($nomor)
    {
        $gudang = \App\LogistikNonMedik\LogistikNonMedikPermintaan::distinct()->where('nomor', $nomor)->first();
        $data = \App\LogistikNonMedik\LogistikNonMedikPermintaan::where('nomor', $nomor)->get();
        $no = 1;
        // return $data; die;
        $pdf = PDF::loadView('logistik.logistiknonmedik.proses.kuitansi-permintaan', compact('data', 'gudang', 'no'));
        return $pdf->stream();
    }

    public function show($id)
    {
        //
    }
    

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $del = \App\LogistikNonMedik\LogistikNonMedikPermintaan::find($id)->delete();
        return response()->json(['sukses' => true]);
    }
}
