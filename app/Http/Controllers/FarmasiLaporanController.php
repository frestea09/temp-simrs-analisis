<?php

namespace App\Http\Controllers;

use App\Logistik\LogistikGudang;
use Illuminate\Http\Request;
use App\Logistik\LogistikStock;
use App\Logistik\LogistikSupplier;
use App\LogistikBatch;
use App\Masterobat;
use Flashy;
use Excel;
use PDF;
use Auth;
use DB;

class FarmasiLaporanController extends Controller
{
    public function lapExpiredDate()
    {
        // $data['obat']	= Masterobat::with(['logistik_batch'])->get();
        $data['obat']    = LogistikBatch::where('gudang_id', 3)->where('stok', '!=', '0')->orderBy('id', 'DESC')->get();
        // dd($data['obat']);
        $data['sel_gud'] = 3;
        $data['gudang']    = LogistikGudang::pluck('nama', 'id');
        return view('farmasi.laporan.expired-date', $data);
    }

    public function lapExpiredDateExcel(Request $request)
    {
        // dd("A");
        // $tga = $request['tga'] ? valid_date($request['tga']) : NULL;
        // $tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;
        // dd($tga,$tgb);
        $tahun_expired = $request->tahun_expired;
        $data['sel_gud'] = $request->gudang_id;
        $data['obat']    = LogistikBatch::where(DB::raw('YEAR(expireddate)'), '=', $tahun_expired);
        $data['gudang']    = LogistikGudang::pluck('nama', 'id');
        if ($data['sel_gud']) {
            $data['obat'] = $data['obat']->where('gudang_id', $data['sel_gud']);
        } else {
        }
        $data['obat']    = $data['obat']->where('stok', '!=', '0')->orderBy('expireddate', 'ASC')->get();
        // $data['obat']	= LogistikBatch::where('gudang_id',3)->whereBetween('created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])->where('stok','!=','0')->orderBy('id','DESC')->get();

        if ($request->view) {
            return view('farmasi.laporan.expired-date', $data);
        } else {
            $obat    = $data['obat'];
            Excel::create('Laporan Expired Date ', function ($excel) use ($obat) {
                // Set the properties
                $excel->setTitle(' Expired Date')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription(' Expired Date');
                $excel->sheet(' Expired Date', function ($sheet) use ($obat) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nomor Batch',
                        'Nama Obat',
                        'Gudang',
                        'Stok Saat Ini',
                        'Expired Date',
                        'Keterangan',
                        'Distributor'
                    ]);
                    foreach ($obat as $st) {
                        $keterangan = '-';
                        if (isset($st->expireddate)) {
                            $date = \Carbon\Carbon::parse($st->expireddate);
                            $now = \Carbon\Carbon::now();
                            $day = $date->diffInDays($now);
                            $keterangan = 'Kadaluarsa ' . $day . ' hari lagi';
                        }
                        
                        if( isset($st->expireddate) ){
                            $date   = \Carbon\Carbon::parse($st->expireddate);
                            $now    = \Carbon\Carbon::now();
                            $day    = $date->diffInDays($now);
                        
                            $dueDate = \Carbon\Carbon::parse($st->expireddate);
                            $day = @$dueDate->diffInDays(now());
                            if ($dueDate->isPast()) {
                                $keterangan = 'Kadaluarsa '.$day.' hari yang lalu';
                            } else {
                                $keterangan = 'Kadaluarsa '.$day.' hari lagi';
                            }
                        } 
                        $sheet->row(++$row, [
                            $no++,
                            $st->nomorbatch,
                            $st->nama_obat,
                            baca_gudang_logistik($st->gudang_id),
                            $st->stok,
                            $st->gudang_id ? baca_gudang_logistik($st->gudang_id) : '-',
                            isset($st->expireddate) ? \Carbon\Carbon::parse($st->expireddate)->format('d-m-Y') : '-',
                            $keterangan,
                            LogistikSupplier::where('id', $st->supplier_id)->first()->nama
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }
    // public function lapExpiredDate()
    // {
    //     $data['obat']	= Masterobat::with(['logistik_batch'])->get();
    //     return view('farmasi.laporan.expired-date', compact('data'));
    // }

    // public function lapExpiredDateExcel( Request $request)
    // {
    //     $obat	= Masterobat::with(['logistik_batch'])->get();
    //     Excel::create('Laporan Expired Date ', function ($excel) use ($obat) {
    //         // Set the properties
    //         $excel->setTitle(' Expired Date')
    //             ->setCreator('Digihealth')
    //             ->setCompany('Digihealth')
    //             ->setDescription(' Expired Date');
    //         $excel->sheet(' Expired Date', function ($sheet) use ($obat) {
    //             $row = 1;
    //             $no = 1;
    //             $sheet->row($row, [
    //                 'No',
    //                 'Nomor Batch',
    //                 'Nama Obat',
    //                 'Expired Date',
    //                 'Keterangan'
    //             ]);
    //             foreach($obat as $st){
    //                 $keterangan = '-';
    //                 if( isset($st->logistik_batch) ){
    //                     $date = \Carbon\Carbon::parse($st->logistik_batch->expireddate);
    //                     $now = \Carbon\Carbon::now();
    //                     $day = $date->diffInDays($now);
    //                     $keterangan = 'Kadaluarsa '.$day.' hari lagi';
    //                 } 
    //                 $sheet->row(++$row, [
    //                     $no++,
    //                     isset($st->logistik_batch) ? $st->logistik_batch->nomorbatch : '-',
    //                     $st->nama ,
    //                     isset($st->logistik_batch) ? \Carbon\Carbon::parse($st->logistik_batch->expireddate)->format('d-m-Y') : '-',
    //                     $keterangan
    //                 ]);
    //             }
    //         });
    //     })->export('xlsx');
    // }
}
