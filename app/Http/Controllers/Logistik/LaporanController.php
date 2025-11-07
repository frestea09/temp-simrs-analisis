<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logistik\LogistikFaktur;
use App\Logistik\LogistikPenerimaan;
use App\Logistik\LogistikPermintaan;
use App\Logistik\LogistikSupplier;
use App\Logistik\Po;
use App\LogistikOpname;
use App\Masterobat;
use App\Supliyer;
use Excel;
use PDF;

class LaporanController extends Controller
{

    // public function cetakBeritaAcara($id)
    // {   
    //     $data = Po::where('supplier', $id)->get();  
    //     $po = Po::find($id);     
    //     return view('logistik.logistikmedik.laporan-baru.cetakBeritaAcara', compact('po'));
    // }

    public function penerimaan()
    {
        $supplier = null;
        return view('logistik.logistikmedik.laporan-baru.penerimaan', compact('supplier'));
    }

    public function filterPenerimaan(Request $request)
    {
        $tga = $request['tga'] ? valid_date($request['tga']) : NULL;
        $tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;
        $supplier = $request['supplier'];
        $tanggal_cetak_sp = $request->tanggal_cetak_sp;
        $no_sp = $request->no_sp;
        $no_usulan_cetak_sp = $request->no_usulan_cetak_sp;

        $data['po'] = LogistikFaktur::join('logistik_po', 'logistik_fakturs.po_id', 'logistik_po.id')->whereBetween('logistik_fakturs.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59']);
        if ($supplier) {
            $data['po'] = $data['po']->where('logistik_fakturs.supplier', $supplier);
        }

        $data['po'] = $data['po']->get();
        $data['po'] = $data['po']->groupBy('no_faktur');
        if ($request['type'] == 'CETAK BA') {
            $data = LogistikFaktur::join('logistik_po', 'logistik_fakturs.po_id', 'logistik_po.id')->whereBetween('logistik_fakturs.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->where('logistik_fakturs.supplier', $supplier)
                ->get();
            $po = Po::find($data[0]->id);

            $pdf = PDF::loadView('logistik.logistikmedik.po.berita_acara', compact('po', 'data', 'supplier'));
            return $pdf->stream();
        }
        if ($request['type'] == 'CETAK SP') {
            $data = LogistikFaktur::join('logistik_po', 'logistik_fakturs.po_id', 'logistik_po.id')->whereBetween('logistik_fakturs.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->where('logistik_fakturs.supplier', $supplier)
                ->get();
            $po = Po::find($data[0]->id);

            $pdf = PDF::loadView('logistik.logistikmedik.po.sp', compact('po', 'data', 'supplier', 'no_usulan_cetak_sp', 'no_sp', 'tanggal_cetak_sp'));
            return $pdf->stream();
        }
        if ($request['type'] == 'CETAK SPPBJ') {
            $data = LogistikFaktur::join('logistik_po', 'logistik_fakturs.po_id', 'logistik_po.id')->whereBetween('logistik_fakturs.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->where('logistik_fakturs.supplier', $supplier)
                ->get();
            $po = Po::find($data[0]->id);

            $pdf = PDF::loadView('logistik.logistikmedik.po.sppbj', compact('po', 'data', 'supplier'));
            return $pdf->stream();
        }
        if ($request['type'] == 'CETAK') {
            $data = LogistikFaktur::join('logistik_po', 'logistik_fakturs.po_id', 'logistik_po.id')->whereBetween('logistik_fakturs.created_at', [$tga, $tgb])
                ->where('logistik_fakturs.supplier', $supplier)
                ->get();
            $po = Po::find($data[0]->id);

            $pdf = PDF::loadView('logistik.logistikmedik.po.berita_acara_2', compact('po', 'data', 'supplier'));
            return $pdf->stream();
        }
        if ($request['type'] == 'EXCEL') {
            Excel::create('Laporan Penerimaan' . $tga . ' sampai ' . $tgb, function ($excel) use ($data) {
                // dd($data['po']);
                // Set the properties
                $excel->setTitle('Logistik Medik Laporan Penerimaan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan penerimaan logistik medik');
                $excel->sheet('Logistik Penerimaan', function ($sheet) use ($data) {
                    // dd($data['po']);
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'No. PO',
                        'Supplier',
                        'Tanggal Penerimaan',
                        'Obat',
                        'PPN %',
                        'PPN',
                        'diskon',
                        'Jumlah Terima'
                    ]);
                    foreach ($data['po'] as $st) {
                        $sheet->row(++$row, [
                            $no++,
                            @$st->no_po,
                            @$st->supplier,
                            @$st->tanggal,
                            @$st->barang->nama,
                            @$st->jml_ppn ?? 0 . '%',
                            'Rp. ' . number_format(@$st->ppn),
                            @$st->diskon_persen . '%',
                            @$st->jumlah_verif
                        ]);
                    }
                });
            })->export('xlsx');
        }

        return view('logistik.logistikmedik.laporan-baru.penerimaan', compact('data', 'supplier'));
    }

    public function tagihan()
    {
        return view('logistik.logistikmedik.laporan-baru.tagihan');
    }

    public function filterTagihan(Request $request)
    {
        $tga = $request['tga'] ? valid_date($request['tga']) : NULL;
        $tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;
        $data['supplier_cache'] = $request->supplier;

        $data['po'] = LogistikFaktur::whereBetween('tgl_faktur', [$tga, $tgb]);

        if (isset($request->supplier)) {
            $data['po'] = $data['po']->where('supplier', 'LIKE', '%' . $request->supplier . '%');
        }

        $data['po'] = $data['po']->get();
        // dd($data);
        if ($request['type'] == 'EXCEL') {
            Excel::create('Laporan Tagihan' . $tga . ' sampai ' . $tgb, function ($excel) use ($data) {
                // dd($data['po']);
                // Set the properties
                $excel->setTitle('Logistik Medik Laporan Tagihan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Tagihan logistik medik');
                $excel->sheet('Logistik Tagihan', function ($sheet) use ($data) {
                    // dd($data['po']);
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama Barang',
                        'Timestamp',
                        'Perusahaan',
                        'Jenis Pembelian',
                        'No.Faktur',
                        'Tgl.Faktur',
                        'Tgl.Jatuh Tempo',
                        'Jumlah',
                        'Tgl.Pembayaran'
                    ]);
                    $total = 0;
                    foreach ($data['po'] as $st) {
                        $total += @$st->total_tagihan;
                        $sheet->row(++$row, [
                            $no++,
                            baca_obat(@$st->masterobat_id),
                            @$st->created_at,
                            @$st->supplier,
                            baca_carabayar(@$st->jenis_pembayaran),
                            @$st->no_faktur,
                            @$st->tgl_faktur,
                            @$st->tgl_jatuh_tempo,
                            @$st->total_tagihan,
                            @$st->tgl_dibayar

                        ]);
                    }
                    $sheet->row($row + 1, [

                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        'Total Tagihan Keseluruhan',
                        $total,
                    ]);
                });
            })->export('xlsx');
        }
        return view('logistik.logistikmedik.laporan-baru.tagihan', compact('data'));
    }

    public function lap_pembelian_obat()
    {
        $supp = '';
        $supplier = LogistikSupplier::pluck('nama', 'id');
        return view('logistik.logistikmedik.laporan.lap-pembelian-obat', compact('supp', 'supplier'));
    }

    public function lap_pembelian_obat_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = $request['tga'] ? valid_date($request['tga']) : NULL;
        $tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;

        $data['supp'] = $request['supplier'];
        $data['supplier'] = LogistikSupplier::pluck('nama', 'id');

        // $data['po'] = LogistikFaktur::join('logistik_po', 'logistik_fakturs.po_id', 'logistik_po.id')
        //     ->whereBetween('logistik_fakturs.created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])
        //     ->groupBy('logistik_fakturs.no_faktur');
        $data['po'] = LogistikFaktur::with(['po'])
            ->whereBetween('logistik_fakturs.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59']);

        if ($request['supplier'] != null) {
            $data['po'] = $data['po']->where('logistik_fakturs.supplier', $request['supplier']);
        }

        $data['po'] = $data['po']->get();

        $faktur = $data['po']->groupBy('no_faktur');

        // foreach($faktur as $items){
        //     $rowspan = $items->count();
        //     foreach($items as $item){
        //         $item->rowspan = $rowspan;
        //     }
        // }

        $data['po'] = $faktur;
        if ($request['type'] == 'EXCEL') {
            Excel::create('Laporan Pembelian Obat' . $tga . ' sampai ' . $tgb, function ($excel) use ($data) {
                $excel->setTitle('Logistik Medik Laporan Pembelian Obat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pembelian Obat logistik medik');
                $excel->sheet('Logistik Pembelian Obat', function ($sheet) use ($data) {
                    $sheet->loadView('logistik.logistikmedik.laporan.excel_lap_pembelian_obat', [
                        'po' => $data['po']
                    ]);
                    // $row = 1;
                    // $no = 1;
                    // $sheet->row($row, [
                    //    'No',
                    //    'No Faktur',
                    //    'Supplier',
                    //    'Kode Barang',
                    //    'Nama Barang',
                    //    'Satuan',
                    //    'Jumlah',
                    //    'Harga Beli Satuan',
                    //    'Diskon Rp.',
                    //    'Jumlah Pembelian',
                    //    'PPN %',
                    //    'PPN Rp.',
                    //    'Jenis Pembayaran',
                    //    'Tanggal Faktur',
                    // ]);
                    // $total = 0;
                    // foreach($data['po'] as $st){
                    //     $total += $st->totalHarga;
                    //     $totalPPN = $st->totalHarga * ($st->jml_ppn / 100);
                    //     $sheet->row(++$row, [
                    //         $no++,
                    //         @$st->no_faktur,
                    //         @$st->supplier,
                    //         @$st->kode_barang,
                    //         @$st->nama_barang,
                    //         @baca_satuan_beli(@$st->satuan),
                    //         @$st->jumlah,
                    //         'Rp. ' . number_format(@$st->harga),
                    //         'Rp. ' . number_format(@$st->diskon_rupiah),
                    //         'Rp. ' . number_format(@$st->totalHarga),
                    //         @$st->jml_ppn ?? 0 . '%',
                    //         'Rp. ' . number_format($totalPPN),
                    //         @$st->jenis_pembayaran == 1 ? 'Cash' : 'Faktur',
                    //         @$st->tgl_faktur

                    //     ]);
                    // }
                    // $sheet->row($row+1, [

                    //         '',
                    //         '',
                    //         '',
                    //         '',
                    //         '',
                    //         '',
                    //         '',
                    //         '',
                    //         'GRAND TOTAL',
                    //         'Rp. '. number_format($total),
                    // ]);
                });
            })->export('xlsx');
        }

        return view('logistik.logistikmedik.laporan.lap-pembelian-obat', $data);
    }




    public function pengeluaran()
    {
        return view('logistik.logistikmedik.pengeluaran');
    }

    public function filterPengeluaran(Request $request)
    {
        $tga = $request['tga'] ? valid_date($request['tga']) : NULL;
        $tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;



        $data['po'] = LogistikPermintaan::where('gudang_asal', '!=', 8)->where('terkirim', '!=', NULL)->whereBetween('created_at', [$tga, $tgb])
            ->get();
        // dd($data);
        if ($request['type'] == 'EXCEL') {
            Excel::create('Laporan pengeluaran' . $tga . ' sampai ' . $tgb, function ($excel) use ($data) {
                // dd($data['po']);
                // Set the properties
                $excel->setTitle('Logistik Medik Laporan pengeluaran')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan pengeluaran logistik medik');
                $excel->sheet('Logistik pengeluaran', function ($sheet) use ($data) {
                    // dd($data['po']);
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama Obat',
                        'Gudang Tujuan',
                        'Satuan',
                        'Pengeluaran',
                        'Tanggal'
                    ]);
                    $total = 0;
                    foreach ($data['po'] as $st) {

                        $obat = Masterobat::find(@$st->masterobat_id);

                        $sheet->row(++$row, [
                            $no++,
                            baca_obat($st->masterobat_id),
                            baca_gudang_logistik($st->gudang_asal),
                            @$obat->satuanbeli->nama,
                            @$st->terkirim,
                            @$st->created_at

                        ]);
                    }
                });
            })->export('xlsx');
        }
        return view('logistik.logistikmedik.pengeluaran', compact('data'));
    }
}
