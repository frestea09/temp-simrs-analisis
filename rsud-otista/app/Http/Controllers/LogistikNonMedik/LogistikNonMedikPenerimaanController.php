<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\LogistikNonMedik\LogistikNonMedikPo;
use App\LogistikNonMedik\LogistikNonPenerimaan;
use Excel;
use DataTables;
use Validator;
use Auth;
use Flashy;
use DB;
use PDF;

class LogistikNonMedikPenerimaanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $po = LogistikNonMedikPo::latest();
            return DataTables::of($po)
                ->addIndexColumn()
                ->addColumn('aksi', function ($po) {
                    return '<a href="' . route('nota', $po->no_po) . '" class="btn btn-info btn-sm"><i class="fa fa-print" target="_blank"></i></a>';
                    // return '<button type="button" onclick="cetak(\'' . $po->no_po . '\')" class="btn btn-sm btn-danger btn-flat" title="Edit"><i class="fa fa-print"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('logistik.logistiknonmedik.proses.proses_penerimaan');
    }

    public function getPO(Request $request)
    {
        $tga = $request['tga'] ? valid_date($request['tga']) : NULL;
        $tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;
        session(['tga' => $request['tga'], 'tgb' => $request['tgb']]);
        $data = \App\LogistikNonMedik\LogistikNonMedikPo::distinct()
            ->whereBetween('tanggal', [$tga, $tgb])
            // ->orWhere('no_po', $request['no_po'])
            ->get(['no_po', 'supplier', 'tanggal', 'user']);
        // return $data; die;
        return view('logistik.logistiknonmedik.proses.proses_penerimaan', compact('data'))->with('no', 1);
        die;
    }

    public function addPenerimaan($po_id)
    {
        $cek_id = strlen($po_id);
        if ($cek_id > 12) {
            $no_po = $po_id;
        } else {
            $no_po = \App\LogistikNonMedik\LogistikNonMedikNoPo::find($po_id)->no_po;
        }

        $penerimaan['po'] = \App\LogistikNonMedik\LogistikNonMedikPo::where('no_po', $no_po)->first();
        $penerimaan['data'] = \App\LogistikNonMedik\LogistikNonMedikPo::join('logistik_non_medik_barangs', 'logistik_non_medik_barangs.id', '=', 'logistik_non_medik_pos.masterbarang_id')
            ->where('logistik_non_medik_pos.no_po', $no_po)
            ->where('logistik_non_medik_pos.sisa', '<>', 0)
            ->select('logistik_non_medik_pos.id as id_po', 'logistik_non_medik_pos.*', 'logistik_non_medik_barangs.*')
            ->get();
        // return $penerimaan; die;
        return view('logistik.logistiknonmedik.proses.add_penerimaan', $penerimaan)->with('no', 1);
    }

    public function getItemPo($id)
    {
        $data['item'] = \App\LogistikNonMedik\LogistikNonMedikPo::find($id);
        $data['namaBarang'] = \App\LogistikNonMedik\LogistikNonMedikBarang::select('nama', 'harga_beli')->where('id', $data['item']->masterbarang_id)->first();
        $data['satuan'] = \App\LogistikNonMedik\LogistikNonMedikSatuan::find($data['item']->satuan);
        return $data;
        die;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            if (!empty($request['terima'])) {
                $pm = new \App\LogistikNonMedik\LogistikNonPenerimaan();
                $pm->no_po = $request['no_po'];
                $pm->tanggal_po = $request['tanggal'];
                $pm->supplier = $request['supplier'];
                $pm->no_faktur = $request['no_faktur'];
                $pm->tanggal_penerimaan = valid_date($request['tanggal_penerimaan']);
                $pm->masterbarang_id = $request['masterbarang_id'];
                $pm->jumlah = $request['jumlah'];
                $pm->terima = $request['terima'];
                $pm->hna = rupiah($request['hna']);
                $pm->hna_lama = 0;
                $pm->total_hna = rupiah($request['total_hna']);
                $pm->ppn = rupiah($request['ppn']);
                $pm->hpp = rupiah($request['hpp']);
                $pm->harga_jual = rupiah($request['harga_jual']);
                // $pm->batch = $request['batch'];
                $pm->expired = !empty($request['expired']) ? valid_date($request['expired']) : date('Y-m-d');
                $pm->diskon_rupiah = rupiah($request['diskon_rupiah']);
                $pm->diskon_persen = $request['diskon_persen'];
                $pm->user_id = Auth::user()->id;
                $pm->save();

                //Update PO
                $po = \App\LogistikNonMedik\LogistikNonMedikPo::where('no_po', $request['no_po'])->where('masterbarang_id', $request['masterbarang_id'])->first();
                $po->sisa = $po->sisa - $request['terima'];
                $po->update();

                $master = \App\LogistikNonMedik\LogistikNonMedikBarang::find($request['masterbarang_id']);
                $master->harga_jual = rupiah($request['harga_jual_satuan']);
                $master->harga_beli = rupiah($request['hna']);
                $master->update();
            }
        });
        if (!empty($request['diterima'])) {
            Flashy::success('Penerimaan berhasil di simpan');
        }
        return response()->json(['sukses' => true]);
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
        //
    }

    public function lap_penerimaan()
    {
        $data['penerimaan'] = \App\LogistikNonMedik\LogistikNonPenerimaan::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        return view('logistik.logistiknonmedik.laporan.lap_penerimaan', $data);
    }

    public function lap_penerimaan_bytanggal(Request $request)
    {
        request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

        $awal  = valid_date($request['tgl_awal']);
        $akhir = valid_date($request['tgl_akhir']);

        $penerimaan = \App\LogistikNonMedik\LogistikNonPenerimaan::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
            ->get();
        if ($request['lanjut']) {
            // return $penerimaan; die;
            return view('logistik.logistiknonmedik.laporan.lap_penerimaan', compact('penerimaan'));
        } elseif ($request['pdf']) {
            $pdf = PDF::loadView('logistik.logistiknonmedik.laporan.pdf_lap_penerimaan', compact('penerimaan'));
            $pdf->setPaper('A4', 'potret');
            return $pdf->download('pdf_laporan_penerimaan' . date('Y-m-d') . '.pdf');
        } elseif ($request['excel']) {
            Excel::create('laporan penerimaan ', function ($excel) use ($penerimaan) {
                // Set the properties
                $excel->setTitle('laporan penerimaan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('laporan penerimaan');
                $excel->sheet('laporan penerimaan', function ($sheet) use ($penerimaan) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'No Faktur',
                        'Tgl PO',
                        'Tgl Penerimaan',
                        'Jumlah',
                        'Di Terima',
                        'Supplier',
                    ]);
                    foreach ($penerimaan as $key => $d) {
                        $sheet->row(++$row, [
                            $no++,
                            $d->no_faktur,
                            $d->tanggal_po,
                            $d->tanggal_penerimaan,
                            $d->jumlah,
                            $d->terima,
                            $d->supplier,
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }
}
