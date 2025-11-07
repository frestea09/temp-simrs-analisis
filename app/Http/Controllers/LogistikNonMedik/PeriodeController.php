<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikPeriode;

class PeriodeController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $satuan = LogistikNonMedikPeriode::latest();
            return DataTables::of($satuan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satuan) {
                    return '<button type="button" onclick="edit(\'' . $satuan->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        // return $gudang; die;
        return view('logistik.logistiknonmedik.masterPeriode');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required'],
            'periodeAwal' => ['required'],
            'periodeAkhir' => ['required'],
            'transaksiAwal' => ['required'],
            'transaksiAkhir' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'periodeAwal.required' => 'periode Awal Wajib Diisi !',
            'periodeAkhir.required' => 'periode Akhir Wajib Diisi !',
            'transaksiAwal.required' => 'transaksi Awal Wajib Diisi !',
            'transaksiAkhir.required' => 'transaksi Akhir Wajib Diisi !',
            'nama.unique' => 'Nama Satuan Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $periode = new LogistikNonMedikPeriode();
            $periode->nama    = $request['nama'];
            $periode->periodeAwal  = valid_date($request['periodeAwal']);
            $periode->periodeAkhir  = valid_date($request['periodeAkhir']);
            $periode->transaksiAwal  = valid_date($request['transaksiAwal']);
            $periode->transaksiAkhir  = valid_date($request['transaksiAkhir']);
            $periode->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    {
        $periode = LogistikNonMedikPeriode::find($id);
        return response()->json(['periode' => $periode]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'nama' => ['required'],
            'periodeAwal' => ['required'],
            'periodeAkhir' => ['required'],
            'transaksiAwal' => ['required'],
            'transaksiAkhir' => ['required'],
        ], [
            'nama.required' => 'Nama Wajib Diisi !',
            'periodeAwal.required' => 'periode Awal Wajib Diisi !',
            'periodeAkhir.required' => 'periode Akhir Wajib Diisi !',
            'transaksiAwal.required' => 'transaksi Awal Wajib Diisi !',
            'transaksiAkhir.required' => 'transaksi Akhir Wajib Diisi !',
            'nama.unique' => 'Nama Satuan Sudah Ada !'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $periode = LogistikNonMedikPeriode::find($id);
            $periode->nama    = $request['nama'];
            $periode->periodeAwal  = valid_date($request['periodeAwal']);
            $periode->periodeAkhir  = valid_date($request['periodeAkhir']);
            $periode->transaksiAwal  = valid_date($request['transaksiAwal']);
            $periode->transaksiAkhir  = valid_date($request['transaksiAkhir']);
            $periode->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getPeriode()
    {
        $periode = LogistikNonMedikPeriode::all();
        return response()->json($periode);
    }
}
