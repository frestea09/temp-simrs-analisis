<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogistikNonMedik\LogistikNonMedikPo;
use Excel;
use DataTables;
use Validator;
use Auth;
use Flashy;
use PDF;

class LogistikNonMedikPoController extends Controller
{
    public function reset()
    {
        session()->forget('no_po');
        session()->forget('tanggal');
        return view('logistik.logistiknonmedik.proses.po');
    }

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
        // return $gudang; die;
        return view('logistik.logistiknonmedik.proses.po');
    }

    public function data(Request $request)
    {
        if (session('no_po')) {
            $po = LogistikNonMedikPo::where('no_po', session('no_po'))->get();
        } else {
            $po = [];
        }
        return DataTables::of($po)
            ->addIndexColumn()
            ->addColumn('aksi', function ($po) {
                return '<button type="button" onclick="hapus(\'' . $po->id . '\')" class="btn btn-sm btn-danger btn-flat" title="Edit"><i class="fa fa-remove"></i></button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

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
            'tanggal' => 'required',
            'masterbarang_id' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
            'jenis_pengadaan' => 'required',
        ]);

        $noAwal = '442/016/';
        $pelayanan = $request['jenis_pengadaan'];
        $cekUrutan = \App\LogistikNonMedik\LogistikNonMedikNoPo::where('no_po', 'LIKE', '%' . date('Y'))->count();
        $nextPo = $noAwal . sprintf("%04s", abs($cekUrutan + 1)) . '/' . $pelayanan . '/' . date('Y');

        if (!empty(session('no_po'))) {
            $noPO = session('no_po');
        } else {
            $noPO = $nextPo;
            $po = new \App\LogistikNonMedik\LogistikNonMedikNoPo();
            $po->no_po = $noPO;
            $po->user_id = Auth::user()->id;
            $po->save();
        }

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $po = new LogistikNonMedikPo();
            $po->no_po = $noPO;
            $po->jenis_pengadaan = $request['jenis_pengadaan'];
            $po->tanggal = valid_date($request['tanggal']);
            $po->supplier = $request['supplier'];
            $po->kode_barang = \App\LogistikNonMedik\LogistikNonMedikBarang::find($request['masterbarang_id'])->kode;
            $po->masterbarang_id = $request['masterbarang_id'];
            $po->jumlah = $request['jumlah'];
            $po->sisa = $request['jumlah'];
            $po->satuan = $request['satuan'];
            $po->keterangan = $request['keterangan'];
            $po->kode_rekening = $request['kode_rekening'];
            $po->kategori_barang = $request['kategori_barang'];
            $po->user = Auth::user()->id;
            $po->save();
            session(['no_po' => $po->no_po, 'tanggal' => $request['tanggal']]);
            return response()->json(['sukses' => true]);
        }
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
        $del = LogistikNonMedikPo::find($id)->delete();
        return response()->json(['sukses' => true]);
    }

    function cetakPO($no_po)
    {
        if (strpos($no_po, '_')) {
            $no_po = str_replace('_', '/', $no_po);
        }
        $po = LogistikNonMedikPo::where('no_po', $no_po)->first();
        $data = LogistikNonMedikPo::where('no_po', $no_po)->get();
        $no = 1;
        // $pejabat = \App\LogistikPejabatPengadaan::All();
        $pdf = PDF::loadView('logistik.logistiknonmedik.kuitansipo', compact('po', 'data', 'no', 'pejabat'));
        return $pdf->stream();
    }

    public function getBarang($barang)
    {
        $barang = \App\LogistikNonMedik\LogistikNonMedikBarang::find($barang);
        return response()->json($barang);
    }

    //laporan
    public function lap_po()
    {
        $data['po'] = LogistikNonMedikPo::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        return view('logistik.logistiknonmedik.laporan.lap_po', $data);
    }

    public function lap_po_bytanggal(Request $request)
    {
        request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

        $awal  = valid_date($request['tgl_awal']);
        $akhir = valid_date($request['tgl_akhir']);

        $po = LogistikNonMedikPo::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
            ->get();
        if ($request['lanjut']) {
            // return $po; die;
            return view('logistik.logistiknonmedik.laporan.lap_po', compact('po'));
        } elseif ($request['pdf']) {
            $pdf = PDF::loadView('logistik.logistiknonmedik.laporan.pdf_lap_po', compact('po'));
            $pdf->setPaper('A4', 'potret');
            return $pdf->download('pdf_laporan_po' . date('Y-m-d') . '.pdf');
        } elseif ($request['excel']) {
            Excel::create('laporan PO ', function ($excel) use ($po) {
                // Set the properties
                $excel->setTitle('laporan PO')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('laporan PO');
                $excel->sheet('laporan PO', function ($sheet) use ($po) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'No Po',
                        'Tgl PO',
                        'Jenis Pengadaan',
                        'Supplier',
                    ]);
                    foreach ($po as $key => $d) {
                        $sheet->row(++$row, [
                            $no++,
                            $d->no_po,
                            $d->tanggal,
                            $d->jenis_pengadaan,
                            $d->supplier,
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }
}
