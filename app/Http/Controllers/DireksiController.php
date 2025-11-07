<?php

namespace App\Http\Controllers;

use App\Inacbg;
use App\JenisPengeluaran;
use App\Kelompokkelas;
use App\KlasifikasiPengeluaran;
use App\Pembayaran;
use App\Rawatinap;
use App\TransaksiKeluar;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use DataTables;
use DB;
use PDF;
use Excel;
use Illuminate\Http\Request;
// use Lcobucci\JWT\Builder;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;

class DireksiController extends Controller
{
    public function __construct()
    {
        set_time_limit(300);
    }

    public function direksiNoRm()
    {
        $data = Folio::join('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where(['folios.jenis' => 'TI', 'folios.kamar_id' => null])
            ->get(['pasiens.no_rm']);
        return $data;
    }

    public function updateKamarFolio()
    {
        $folio = Folio::where(['jenis' => 'TI', 'kamar_id' => null])->take(1000)->get();
        foreach ($folio as $f) {
            $kamar = Rawatinap::where('registrasi_id', $f->registrasi_id)->first();

            $fol = Folio::find($f->id);
            $fol->kamar_id = $kamar['kamar_id'];
            $fol->update();
        }
    }

    public function laporanKinerja()
    {
        $inacbg = Inacbg::all();
        return view('direksi.laporanKinerja', compact('inacbg'))->with('no', 1);
    }

    public function laporanKinerjaByTanggal(Request $request)
    {
        $inacbg = Inacbg::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
        return view('direksi.laporanKinerja', compact('inacbg'))->with('no', 1);
    }

    public function tagihan()
    {
        return view('direksi.tagihan');
    }

    public function pendapatan()
    {
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['cara_bayar'] = Carabayar::whereIn('id', [1, 2])->get();
        $data['kategori'] = 'ALL';
        $data['data_petugas'] = Pembayaran::distinct()->get(['user_id']);
        $data['petugas'] = '0';
        $data['carabayar'] = '0';
        $data['poliSelect'] = '';

        return view('direksi.pendapatan', $data)->with('no', 1);
    }

    public static function viewPendapatan(Request $request)
    {
        // dd($request->all());
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tga']    = date(valid_date($request['tga']) . ' 00:00:00');
        $data['tgb']    = date(valid_date($request['tgb']) . ' 23:59:59');
        $data['kategori'] = $request['kategori'];
        $data['carabayar'] = $request['carabayar'];
        $data['poliSelect'] = $request['poli'];
        $data['petugas'] = $request['petugas'];
        $carabayar = $request['carabayar'];
        $poli = $request['poli'];
        $data['cara_bayar'] = Carabayar::whereIn('id', [1, 2])->get();
        $data['data_petugas'] = Pembayaran::distinct()->get(['user_id']);

        $data['pembayaran'] = Pembayaran::with(
            [
                'registrasis' => function ($query) {
                    $query->whereNotIn('poli_id', [25, 40]);
                }
            ]
        )->where('flag', 'Y')
            ->whereBetween('created_at', [$data['tga'], $data['tgb']]);

        if ($request['kategori'] !== 'ALL') { //jika dapat kategori pembayran
            $data['pembayaran'] = $data['pembayaran']->where('no_kwitansi', 'LIKE', $request['kategori'] . '%');
        }
        if ($request['petugas'] !== '0') { //jika dapat kategori pembayran
            $data['pembayaran'] = $data['pembayaran']->where('user_id', $data['petugas']);
        }

        if ($carabayar !== '0') { //jika dapat kategori pembayran

            $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($carabayar) {
                $query->where('bayar', '=', $carabayar);
            });
        }

        if ($poli) { //jika dapat kategori poli

            $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($poli) {
                $query->where('poli_id', $poli);
            });
        }
        if ($request->time_start !== null && $request->time_end !== null) {
            $data['pembayaran'] = $data['pembayaran']->whereTime('created_at', '>=', $request->time_start)
                ->whereTime('created_at', '<=',  $request->time_end);
        }
        // ->get();

        $data['pembayaran'] = $data['pembayaran']->orderBy('pasien_id', 'DESC')->orderBy('no_kwitansi', 'ASC');

        // $data['pembayaran']->get();

        if ($request['tampil']) {
            return view('direksi.pendapatan', $data)->with('no', 1);
        } elseif ($request['cetak']) {
            $pembayaran = $data['pembayaran'];
            $no = 1;
            $tga = $data['tga'];
            $tgb = $data['tgb'];
            $kategori = $data['kategori'];

            $pdf = PDF::loadView('direksi.pdf_pendapatan', compact('pembayaran', 'no', 'tga', 'tgb', 'kategori'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('pendapatan.pdf');
            // request()->validate(['tga' => 'required', 'tgb' => 'required']);
            // $tga = date(valid_date($request['tga']) . ' 00:00:00');
            // $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
            // $data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            // 	->whereBetween('registrasis.created_at', [$tga, $tgb])
            // 	->where('poli_id', $request['poliId'])
            //     ->select('registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.id as registrasi_id', 'pasiens.no_rm', 'pasiens.nama', 'pasiens.alamat', 'pasiens.tgllahir', 'pasiens.kelamin')
            //     ->get();
        } elseif ($request['excel']) {
            Excel::create('Laporan Pendapatan ', function ($excel) use ($data) {
                // Set the properties
                $excel->setTitle('Laporan Pendapatan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pendapatan');
                $excel->sheet('Laporan Pendapatan', function ($sheet) use ($data) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'No RM',
                        'Poli / Ruangan',
                        'No. Kwitansi',
                        'Tagihan',
                        'Diskon',
                        'Dibayar',
                        'Petugas',
                    ]);
                    foreach ($data['pembayaran']->get() as $item) {
                        if (!$item->pasien) {
                            @$namapasien = Registrasi::where('id',$item->registrasi_id)->first();
                        }
                        $poli = '';
                        if(@$item->registrasis->poli_id){
                            if(@$item->registrasis->rawat_inap) {
                                $poli = @baca_kamar($item->registrasis->rawat_inap->kamar_id);
                            } else {
                                $poli = @baca_poli($item->registrasis->poli_id);
                            }
                        } else {
                            $poli = 'Penjualan Bebas';
                        }
                        $sheet->row(++$row, [
                            $no++,
                            @$item->pasien->nama ? @$item->pasien->nama : @$namapasien->pasien->nama,
                            !empty($item->pasien->no_rm) ? $item->pasien->no_rm: @$namapasien->pasien->no_rm,
                            $poli,
                            !empty($item->no_kwitansi) ? $item->no_kwitansi: '-',
                            ($item->total),
                            ($item->diskon_rupiah),
                            (($item->dibayar ?? 0) - ($item->diskon_rupiah ?? 0)),
                            @$item->user->name
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }
    public function pendapatanNew()
    {
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['cara_bayar'] = Carabayar::whereIn('id', [1, 2])->get();
        $data['kategori'] = 'ALL';
        $data['data_petugas'] = Pembayaran::distinct()->get(['user_id']);
        $data['petugas'] = '0';
        $data['carabayar'] = '0';
        $data['poliSelect'] = '';

        return view('direksi.pendapatanNew', $data)->with('no', 1);
    }

    public static function viewPendapatanNew(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '9000M');
        // dd($request->all());
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tga']    = date(valid_date($request['tga']) . ' 00:00:00');
        $data['tgb']    = date(valid_date($request['tgb']) . ' 23:59:59');
        $data['kategori'] = $request['kategori'];
        $data['carabayar'] = $request['carabayar'];
        $data['poliSelect'] = $request['poli'];
        $data['petugas'] = $request['petugas'];
        $carabayar = $request['carabayar'];
        $poli = $request['poli'];
        $data['cara_bayar'] = Carabayar::whereIn('id', [1, 2])->get();
        $data['data_petugas'] = Pembayaran::distinct()->get(['user_id']);


        // Folio::where('registrasi_id', $registrasi_id)->where('verif_kasa', 'Y')->groupBy('tarif_id')
        //     ->selectRaw('tarif_id, sum(total) as total')
        //     ->get();


        $data['pembayaran'] = 
        Folio::leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
        ->with('registrasi')
		->groupBy('folios.registrasi_id')
        ->whereNull('registrasis.deleted_at')
        // ->where('tarifs.jenis', '=', baca_jenis_unit($unit))
        // ->where('folio.total', '<>', 0)
        ->whereBetween('registrasis.created_at', [$data['tga'], $data['tgb']])
        ->groupBy('folios.registrasi_id')
        ->selectRaw('SUM(folios.total) as total, folios.registrasi_id, registrasis.pasien_id,registrasis.bayar,registrasis.poli_id,registrasis.created_at,registrasis.status_reg');
        // ->limit(10)
        // ->get();
        // dd($data['pembayaran']);
        // if ($carabayar !== '0') { //jika dapat kategori pembayran

        //     $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($carabayar) {
        //         $query->where('bayar', '=', $carabayar);
        //     });
        // }

        // if ($poli) { //jika dapat kategori poli

        //     $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($poli) {
        //         $query->where('poli_id', $poli);
        //     });
        // }
        // if ($request->time_start !== null && $request->time_end !== null) {
        //     $data['pembayaran'] = $data['pembayaran']->whereTime('created_at', '>=', $request->time_start)
        //         ->whereTime('created_at', '<=',  $request->time_end);
        // }
        // ->get();

        // $data['pembayaran']->get();

        // if ($request['kategori'] !== 'ALL') { //jika dapat kategori pembayran
        //     $data['pembayaran'] = $data['pembayaran']->where('no_kwitansi', 'LIKE', $request['kategori'] . '%');
        // }
        if ($request['petugas'] !== '0') { //jika dapat kategori pembayran
            $data['pembayaran'] = $data['pembayaran']->where('user_id', $data['petugas']);
        }

        if ($carabayar !== '0') { //jika dapat kategori pembayran

            $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($carabayar) {
                $query->where('bayar', '=', $carabayar);
            });
        }

        if ($poli) { //jika dapat kategori poli

            $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($poli) {
                $query->where('poli_id', $poli);
            });
        }
        if ($request->time_start !== null && $request->time_end !== null) {
            $data['pembayaran'] = $data['pembayaran']->whereTime('created_at', '>=', $request->time_start)
                ->whereTime('created_at', '<=',  $request->time_end);
        }
        // ->get();

        $data['pembayaran'] = $data['pembayaran']->orderBy('registrasis.id', 'ASC');

        if ($request['tampil']) {
            return view('direksi.pendapatanNew', $data)->with('no', 1);
        } elseif ($request['cetak']) {
            $pembayaran = $data['pembayaran'];
            $no = 1;
            $tga = $data['tga'];
            $tgb = $data['tgb'];
            $kategori = $data['kategori'];

            $pdf = PDF::loadView('direksi.pdf_pendapatan_new', compact('pembayaran', 'no', 'tga', 'tgb', 'kategori'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('pendapatan.pdf');
            // request()->validate(['tga' => 'required', 'tgb' => 'required']);
            // $tga = date(valid_date($request['tga']) . ' 00:00:00');
            // $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
            // $data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            // 	->whereBetween('registrasis.created_at', [$tga, $tgb])
            // 	->where('poli_id', $request['poliId'])
            //     ->select('registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.id as registrasi_id', 'pasiens.no_rm', 'pasiens.nama', 'pasiens.alamat', 'pasiens.tgllahir', 'pasiens.kelamin')
            //     ->get();
        } elseif ($request['excel']) {
            $kategori = $data['kategori'];
            $tga = $data['tga'];
            $tgb = $data['tgb'];
            $pembayaran = $data['pembayaran'];
            // dd($pembayaran->get());
            Excel::create('Laporan Pendapatan '.date('d-m-Y',strtotime($tga)).'_'.date('d-m-Y',strtotime($tgb)), function ($excel) use ($pembayaran,$tga,$tgb,$kategori) {
                $excel->setTitle('Laporan Pendapatan'.date('d-m-Y',strtotime($tga)).'_'.date('d-m-Y',strtotime($tgb)))
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pendapatan'.date('d-m-Y',strtotime($tga)).'_'.date('d-m-Y',strtotime($tgb)));
                $excel->sheet('Pendapatan All', function ($sheet) use ($pembayaran,$tga,$tgb,$kategori) {
                    $sheet->loadView('direksi.excel.laporan_pendapatan', compact('pembayaran', 'tga', 'tgb', 'kategori'));
                });
            })->export('xlsx');
        }
    }

    public static function exportExcel(Request $request,$awal,$akhir,$unit,$lunas)
    {

        // dd($unit,$lunas);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '9000M');
        // dd($request->all());
        // request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tga']    =  '2024-'.$awal.'-01';
        $data['tgb']    = '2024-'.$akhir.'-31';
        // $data['kategori'] = $request['kategori'];
        // $data['carabayar'] = $request['carabayar'];
        // $data['poliSelect'] = $request['poli'];
        // $data['petugas'] = $request['petugas'];
        // $carabayar = $request['carabayar'];
        // $poli = $request['poli'];
        // $data['cara_bayar'] = Carabayar::whereIn('id', [1, 2])->get();
        // $data['data_petugas'] = Pembayaran::distinct()->get(['user_id']);


        // Folio::where('registrasi_id', $registrasi_id)->where('verif_kasa', 'Y')->groupBy('tarif_id')
        //     ->selectRaw('tarif_id, sum(total) as total')
        //     ->get();


        $data['pembayaran'] = 
        Folio::leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
        // ->with('registrasi')
		->groupBy('folios.registrasi_id')
        ->whereNull('registrasis.deleted_at')
        ->where('folios.lunas', $lunas)
        ->where('registrasis.bayar', '2')
        ->where('registrasis.status_reg', 'LIKE',$unit.'%')
        ->whereBetween('registrasis.created_at', [$data['tga'].' 00:00:00', $data['tgb'].' 23:59:59'])
        ->groupBy('folios.registrasi_id')
        ->selectRaw('SUM(folios.total) as total, folios.registrasi_id, registrasis.pasien_id,registrasis.bayar,registrasis.poli_id,registrasis.created_at,registrasis.status_reg');
        // ->limit(10)
        // ->get();
        // dd($data['pembayaran']);
        // if ($carabayar !== '0') { //jika dapat kategori pembayran

        //     $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($carabayar) {
        //         $query->where('bayar', '=', $carabayar);
        //     });
        // }

        // if ($poli) { //jika dapat kategori poli

        //     $data['pembayaran'] = $data['pembayaran']->whereHas('registrasis', function (Builder $query) use ($poli) {
        //         $query->where('poli_id', $poli);
        //     });
        // }
        // if ($request->time_start !== null && $request->time_end !== null) {
        //     $data['pembayaran'] = $data['pembayaran']->whereTime('created_at', '>=', $request->time_start)
        //         ->whereTime('created_at', '<=',  $request->time_end);
        // }
        // ->get();

        $data['pembayaran'] = $data['pembayaran']->orderBy('registrasis.id', 'ASC');

        // $data['pembayaran']->get();

        // if ($request['tampil']) {
        //     return view('direksi.pendapatanNew', $data)->with('no', 1);
        // } elseif ($request['cetak']) {
        //     $pembayaran = $data['pembayaran'];
        //     $no = 1;
        //     $tga = $data['tga'];
        //     $tgb = $data['tgb'];
        //     $kategori = $data['kategori'];

        //     $pdf = PDF::loadView('direksi.pdf_pendapatan_new', compact('pembayaran', 'no', 'tga', 'tgb', 'kategori'));
        //     $pdf->setPaper('A4', 'landscape');
        //     return $pdf->stream('pendapatan.pdf');
        //     // request()->validate(['tga' => 'required', 'tgb' => 'required']);
        //     // $tga = date(valid_date($request['tga']) . ' 00:00:00');
        //     // $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
        //     // $data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     // 	->whereBetween('registrasis.created_at', [$tga, $tgb])
        //     // 	->where('poli_id', $request['poliId'])
        //     //     ->select('registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.id as registrasi_id', 'pasiens.no_rm', 'pasiens.nama', 'pasiens.alamat', 'pasiens.tgllahir', 'pasiens.kelamin')
        //     //     ->get();
        // } elseif ($request['excel']) {
            // $kategori = $data['kategori'];
            $tga = $data['tga'];
            $tgb = $data['tgb'];
            $pembayaran = $data['pembayaran'];
            // dd($pembayaran->get());
            Excel::create('Laporan Pendapatan '.$tga.'_'.$tgb.'_'.$unit.'-'.$lunas, function ($excel) use ($pembayaran,$tga,$tgb,$unit) {
                $excel->setTitle('Laporan Pendapatan'.$tga.'_'.$tgb)
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pendapatan'.$tga.'_'.$tgb);
                $excel->sheet('Pendapatan All', function ($sheet) use ($pembayaran,$tga,$tgb,$unit) {
                    $sheet->loadView('direksi.excel.laporan_pendapatan_news', compact('pembayaran', 'tga', 'tgb','unit'));
                });
            })->export('xlsx');
        // }
    }

    public function lapPasien()
    {
        return view('direksi.lapPasien');
    }

    public function viewLapPasien(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = date(valid_date($req['tga']) . ' 00:00:00');
        $tgb = date(valid_date($req['tgb']) . ' 23:59:59');
        $data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->whereBetween('registrasis.created_at', [$tga, $tgb])->get(['registrasis.id as reg_id', 'pasiens.nama', 'pasiens.no_rm']);
        // return $data;die;
        if ($req['tampil']) {
            return view('direksi.lapPasien', compact('data', 'tga'))->with('no', 1);
        } else {
            Excel::create('Laporan Pasien ', function ($excel) use ($data) {
                $excel->setTitle('Laporan Pasien')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pasien');
                $excel->sheet('Laporan Pasien', function ($sheet) use ($data) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Pasien',
                        'No RM',
                        'Rawat Jalan',
                        'Rawat Inap',
                        'Rawat Darurat',
                        'Laboratorium',
                        'Radiologi',
                        'Farmasi',
                        'Rehab Medik',
                        'Total'
                    ]);
                    foreach ($data as $key => $d) {
                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            $d->no_rm,
                            lapPasien($d->reg_id, 'J'),
                            lapPasien($d->reg_id, ''),
                            lapPasien($d->reg_id, 'G'),
                            lapPasien($d->reg_id, 'L'),
                            lapPasien($d->reg_id, 'R'),
                            lapPasien($d->reg_id, 'A'),
                            lapPasien($d->reg_id, 'M'),
                            lapPasien($d->reg_id, 'T')
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function penerimaan()
    {

        $data = [];
        $tga  = '';
        $tgb  = '';

        return view('direksi.penerimaan', compact('data', 'tga', 'tgb'))->with('no', 1);
    }

    public function viewPenerimaan(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = date(valid_date($request['tga']) . ' 00:00:00');
        $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
        $data = Folio::where('lunas', 'Y')->whereBetween('created_at', [$tga, $tgb])->groupBy('cara_bayar_id')
            ->selectRaw('cara_bayar_id, sum(total) as total')
            ->get();
        return view('direksi.penerimaan', compact('data', 'tga', 'tgb'))->with('no', 1);
    }




    public function penunjang()
    {

        $data = [];
        $tga  = '';
        $tgb  = '';

        return view('direksi.penunjang', compact('data', 'tga', 'tgb'))->with('no', 1);
    }

    public function viewPenunjang(Request $request)
    {

        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = date(valid_date($request['tga']) . ' 00:00:00');
        $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
        $data = [];
        $laboratorium = Folio::where('jenis', '!=', 'ORJ')
            ->whereIn('poli_tipe', ['L'])
            ->where('namatarif', 'not like', '%usg%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();

        $radiologi = Folio::where('jenis', '!=', 'ORJ')
            ->whereIn('poli_tipe', ['R'])
            ->where('namatarif', 'not like', '%usg%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();

        $usg = Folio::where('jenis', '!=', 'ORJ')
            ->where('namatarif', 'like', '%usg%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();

        $citologi = Folio::where('jenis', '!=', 'ORJ')
            ->where('namatarif', 'like', '%citologi%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();

        $fnab = Folio::where('jenis', '!=', 'ORJ')
            ->where('namatarif', 'like', '%fnab%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();
        $pa_biopsi = Folio::where('jenis', '!=', 'ORJ')
            ->where('namatarif', 'like', '%pa biopsi%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();

        $pa_operasi = Folio::where('jenis', '!=', 'ORJ')
            ->where('namatarif', 'like', '%pa operasi%')
            ->whereBetween('created_at', [$tga, $tgb])
            ->selectRaw('sum(total) AS total, count(*) as jumlah')
            ->get();

        if ($request['submit'] == 'Check') {

            return view('direksi.penunjang', compact('data', 'laboratorium', 'radiologi', 'usg', 'citologi', 'fnab', 'pa_biopsi', 'pa_operasi', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['cetak'] == 'Cetak') {

            $pdf = PDF::loadView('direksi.penunjangPDF',  compact('data', 'laboratorium', 'radiologi', 'usg', 'citologi', 'fnab', 'pa_biopsi', 'pa_operasi', 'tga', 'tgb'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();

            // $pdf = PDF::loadView('farmasi.laporan.pdf_pemakaian_obat', $data);
            // $pdf->setPaper('A4', 'potret');
            // return $pdf->stream();

        }
    }






    public function uangmuka()
    {
        return view('direksi.pem_uang_muka');
    }

    public function bridgingjkn()
    {
        return view('direksi.bridging_jkn');
    }

    public function selisihnegatif()
    {
        return view('direksi.selisih_negatif_jkn');
    }

    public function naikkelas()
    {
        return view('direksi.naik_kelas');
    }

    //KINERJA RAWAT JALAN
    public function kinerjaRawatJalan()
    {
        $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
        $data['klinik'] = Poli::where('politype', 'J')->get();
        $data['dokter'] = \Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
        return view('direksi.kinerjaRawatJalan', $data)->with('no', 1);
    }

    public function kinerjaRawatJalanByDate(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = date(valid_date($request['tga']) . ' 00:00:00');
        $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
        $poli = $request['poli_id'];
        $dokter = $request['dokter_id'];

        if ($dokter != 'all') {
            $query = "AND folios.dokter_id = $dokter";
        } else {
            $query = "";
        }

        if ($request['carabayar'] == 1) {
            $bayar = '=';
        } else {
            $bayar = '<>';
        }
        $kinerja = DB::select("SELECT
                            folios.id,
                            folios.registrasi_id,
                            (SELECT nama FROM pasiens WHERE id = registrasis.pasien_id) AS pasien,
                            (SELECT no_rm FROM pasiens WHERE id = registrasis.pasien_id) AS noRM,
                            folios.tarif_id,
                            folios.namatarif,
                            (SELECT carabayar FROM carabayars WHERE id = folios.cara_bayar_id ) AS jenisPasien,
                            folios.total,
                            (SELECT nominal from splits WHERE splits.tarif_id = folios.tarif_id AND splits.nama = 'Jasa Pelayanan') AS JasaPelayanan,
                            folios.jenis,
                            (SELECT nama FROM pegawais WHERE id = folios.dokter_id) AS dokter,
                            (SELECT nama FROM polis WHERE id = folios.poli_id) AS poli,
                            (SELECT kelompok FROM kelompok_kelas WHERE id = folios.kelompokkelas_id) AS bangsal,
                            (SELECT nama FROM kamars WHERE id = folios.kamar_id) AS kamar,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dpjp) AS dpjp,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_pelaksana) AS pelaksana,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_lab) AS dokter_lab,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.analis_lab) AS analis_lab,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_radiologi) AS dokter_radiologi,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.radiografer) AS radiografer,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat) AS perawat,
                            (SELECT name FROM users WHERE id = folios.user_id) AS admin,
                            foliopelaksanas.pelaksana_tipe,
                            folios.created_at,
                            foliopelaksanas.updated_at
                            FROM folios
                            LEFT JOIN foliopelaksanas ON folios.id = foliopelaksanas.folio_id, registrasis
                            WHERE folios.registrasi_id = registrasis.id
                            $query
                            AND folios.poli_id = $poli
                            AND folios.jenis = 'TA'
                            AND folios.cara_bayar_id $bayar 1
                            AND folios.created_at BETWEEN '$tga' AND '$tgb'
                            ORDER BY folios.updated_at ASC");
        // return $kinerja; die;

        Excel::create('Laporan Kinerja Rawat Jalan', function ($excel) use ($kinerja) {
            $excel->setTitle('Laporan Kinerja Rawat Jalan')
                ->setCreator('SIMRS Versi 4.0')
                ->setCompany(configrs()->nama)
                ->setDescription('Laporan Kinerja Rawat Jalan');
            $excel->sheet('Laporan Kinerja Rawat Jalan', function ($sheet) use ($kinerja) {
                $no = 1;
                $sheet->appendRow([
                    'No',
                    'Klinik',
                    'registrasi_id',
                    'pasien',
                    'noRM',
                    'namatarif',
                    'jenisPasien',
                    'total',
                    'JasaPelayanan',
                    'dokter',
                    'dpjp',
                    'pelaksana',
                    'dokter_lab',
                    'analis_lab',
                    'dokter_radiologi',
                    'radiografer',
                    'perawat',
                    'Admin',
                    'created_at',
                ]);

                foreach ($kinerja as $d) {
                    $sheet->appendRow([
                        $no++,
                        $d->poli,
                        $d->registrasi_id,
                        $d->pasien,
                        $d->noRM,
                        $d->namatarif,
                        $d->jenisPasien,
                        $d->total,
                        $d->JasaPelayanan,
                        $d->dokter,
                        $d->dpjp,
                        $d->pelaksana,
                        $d->dokter_lab,
                        $d->analis_lab,
                        $d->dokter_radiologi,
                        $d->radiografer,
                        $d->perawat,
                        $d->admin,
                        $d->created_at,
                    ]);
                }
            });
        })->export('xlsx');
    }

    public function detailKinerjaRawatJalan($dokter_id, $cara_bayar_id, $mapping)
    {
        $pemeriksaan = Tarif::where('mapping_pemeriksaan', $mapping)->get();
        $pm = [];
        foreach ($pemeriksaan as $key => $d) {
            $pm[] = '' . $d->id . '';
        }
        $bayar = [];
        foreach (Carabayar::select('id')->get() as $d) {
            $bayar[] = '' . $d->id . '';
        }
        if ($cara_bayar_id == '100') {
            $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->whereIn('cara_bayar_id', $bayar)->where('jenis', 'TA')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();
        } else {
            $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('cara_bayar_id', $cara_bayar_id)->where('jenis', 'TA')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();
        }

        return view('direksi.detailKinerjaRawatJalan', $data)->with('no', 1);
    }

    //KINERJA RAWAT DARURAT
    public function kinerjaRawatDarurat()
    {
        $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
        $data['klinik'] = Poli::where('politype', 'G')->get();
        $data['dokter'] = \Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
        return view('direksi.kinerjaRawatDarurat', $data)->with('no', 1);
    }

    public function kinerjaRawatDaruratByDate(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = date(valid_date($request['tga']) . ' 00:00:00');
        $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
        $poli = $request['poli_id'];
        $dokter = $request['dokter_id'];

        if ($dokter != 'all') {
            $query = "AND folios.dokter_id = $dokter";
        } else {
            $query = "";
        }

        if ($request['carabayar'] == 1) {
            $bayar = '=';
        } else {
            $bayar = '<>';
        }
        $kinerja = DB::select("SELECT
                            folios.id,
                            folios.registrasi_id,
                            (SELECT nama FROM pasiens WHERE id = registrasis.pasien_id) AS pasien,
                            (SELECT no_rm FROM pasiens WHERE id = registrasis.pasien_id) AS noRM,
                            folios.tarif_id,
                            folios.namatarif,
                            (SELECT carabayar FROM carabayars WHERE id = folios.cara_bayar_id ) AS jenisPasien,
                            folios.total,
                            (SELECT nominal from splits WHERE splits.tarif_id = folios.tarif_id AND splits.nama = 'Jasa Pelayanan') AS JasaPelayanan,
                            folios.jenis,
                            (SELECT nama FROM pegawais WHERE id = folios.dokter_id) AS dokter,
                            (SELECT nama FROM polis WHERE id = folios.poli_id) AS poli,
                            (SELECT kelompok FROM kelompok_kelas WHERE id = folios.kelompokkelas_id) AS bangsal,
                            (SELECT nama FROM kamars WHERE id = folios.kamar_id) AS kamar,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dpjp) AS dpjp,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_pelaksana) AS pelaksana,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_lab) AS dokter_lab,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.analis_lab) AS analis_lab,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_radiologi) AS dokter_radiologi,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.radiografer) AS radiografer,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat) AS perawat,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.bidan) AS bidan,
                            (SELECT name FROM users WHERE id = folios.user_id) AS admin,
                            foliopelaksanas.pelaksana_tipe,
                            folios.created_at,
                            foliopelaksanas.updated_at
                            FROM folios
                            LEFT JOIN foliopelaksanas ON folios.id = foliopelaksanas.folio_id, registrasis
                            WHERE folios.registrasi_id = registrasis.id
                            $query
                            AND folios.poli_id = $poli
                            AND folios.jenis = 'TG'
                            AND folios.cara_bayar_id $bayar 1
                            AND folios.created_at BETWEEN '$tga' AND '$tgb'
                            ORDER BY folios.updated_at ASC");
        // return $kinerja; die;

        Excel::create('Laporan Kinerja Rawat Darurat', function ($excel) use ($kinerja) {
            $excel->setTitle('Laporan Kinerja Rawat Darurat')
                ->setCreator('SIMRS Versi 4.0')
                ->setCompany(configrs()->nama)
                ->setDescription('Laporan Kinerja Rawat Darurat');
            $excel->sheet('Laporan Kinerja Rawat Darurat', function ($sheet) use ($kinerja) {
                $no = 1;
                $sheet->appendRow([
                    'No',
                    'Klinik',
                    'registrasi_id',
                    'pasien',
                    'noRM',
                    'namatarif',
                    'jenisPasien',
                    'total',
                    'JasaPelayanan',
                    'dokter',
                    'dpjp',
                    'pelaksana',
                    'dokter_lab',
                    'analis_lab',
                    'dokter_radiologi',
                    'radiografer',
                    'perawat',
                    'bidan',
                    'Admin',
                    'created_at',
                ]);

                foreach ($kinerja as $d) {
                    $sheet->appendRow([
                        $no++,
                        $d->poli,
                        $d->registrasi_id,
                        $d->pasien,
                        $d->noRM,
                        $d->namatarif,
                        $d->jenisPasien,
                        $d->total,
                        $d->JasaPelayanan,
                        $d->dokter,
                        $d->dpjp,
                        $d->pelaksana,
                        $d->dokter_lab,
                        $d->analis_lab,
                        $d->dokter_radiologi,
                        $d->radiografer,
                        $d->perawat,
                        $d->bidan,
                        $d->admin,
                        $d->created_at,
                    ]);
                }
            });
        })->export('xlsx');
    }

    public function detailKinerjaRawatDarurat($dokter_id, $cara_bayar_id, $mapping)
    {
        $pemeriksaan = Tarif::where('mapping_pemeriksaan', $mapping)->get();
        $pm = [];
        foreach ($pemeriksaan as $key => $d) {
            $pm[] = '' . $d->id . '';
        }
        $bayar = [];
        foreach (Carabayar::select('id')->get() as $d) {
            $bayar[] = '' . $d->id . '';
        }
        if ($cara_bayar_id == '100') {
            $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->whereIn('cara_bayar_id', $bayar)->where('jenis', 'TG')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();
        } else {
            $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('cara_bayar_id', $cara_bayar_id)->where('jenis', 'TG')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();
        }
        return view('direksi.detailKinerjaRawatDarurat', $data)->with('no', 1);
    }

    //KINERJA RAWAT INAP
    public function kinerjaRawatInap()
    {
        $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
        $data['bangsal'] = Kelompokkelas::all();
        return view('direksi.kinerjaRawatInap', $data)->with('no', 1);
    }

    public function kinerjaRawatInapByDate(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = date(valid_date($request['tga']) . ' 00:00:00');
        $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
        $kelompok = $request['kelompokkelas_id'];

        if ($request['carabayar'] == 1) {
            $bayar = '=';
        } else {
            $bayar = '<>';
        }
        $kinerja = DB::select("SELECT
                            folios.id,
                            folios.registrasi_id,
                            (SELECT nama FROM pasiens WHERE id = registrasis.pasien_id) AS pasien,
                            (SELECT no_rm FROM pasiens WHERE id = registrasis.pasien_id) AS noRM,
                            folios.tarif_id,
                            folios.namatarif,
                            (SELECT carabayar FROM carabayars WHERE id = folios.cara_bayar_id ) AS jenisPasien,
                            folios.total,
                            (SELECT nominal from splits WHERE splits.tarif_id = folios.tarif_id AND splits.nama = 'Jasa Pelayanan') AS JasaPelayanan,
                            folios.jenis,
                            (SELECT nama FROM pegawais WHERE id = folios.dokter_id) AS dokter,
                            (SELECT nama FROM polis WHERE id = folios.poli_id) AS poli,
                            (SELECT kelompok FROM kelompok_kelas WHERE id = folios.kelompokkelas_id) AS bangsal,
                            (SELECT nama FROM kamars WHERE id = folios.kamar_id) AS kamar,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dpjp) AS dpjp,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_pelaksana) AS pelaksana,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_anestesi) AS dokter_anestesi,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_anestesi1) AS perawat_anestesi1,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_anestesi2) AS perawat_anestesi2,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_anestesi3) AS perawat_anestesi3,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_operator) AS dokter_operator,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_lab) AS dokter_lab,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.analis_lab) AS analis_lab,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_radiologi) AS dokter_radiologi,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.radiografer) AS radiografer,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat) AS perawat,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.dokter_bedah) AS dokter_bedah,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_ibs1) AS perawat_ibs1,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_ibs2) AS perawat_ibs2,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_ibs3) AS perawat_ibs3,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_ibs4) AS perawat_ibs4,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.perawat_ibs5) AS perawat_ibs5,
                            (SELECT nama FROM pegawais WHERE id = foliopelaksanas.bidan) AS bidan,
                            (SELECT name FROM users WHERE id = folios.user_id) AS admin,
                            foliopelaksanas.pelaksana_tipe,
                            folios.created_at,
                            foliopelaksanas.updated_at
                            FROM folios
                            LEFT JOIN foliopelaksanas ON folios.id = foliopelaksanas.folio_id, registrasis
                            WHERE folios.registrasi_id = registrasis.id
                            AND folios.kelompokkelas_id = $kelompok
                            AND folios.jenis = 'TI'
                            AND folios.cara_bayar_id $bayar 1
                            AND folios.created_at BETWEEN '$tga' AND '$tgb'
                            ORDER BY folios.updated_at ASC");
        Excel::create('Laporan Kinerja Rawat Inap', function ($excel) use ($kinerja) {
            $excel->setTitle('Laporan Kinerja Rawat Inap')
                ->setCreator('SIMRS Versi 4.0')
                ->setCompany(configrs()->nama)
                ->setDescription('Laporan Kinerja Rawat Inap');
            $excel->sheet('Laporan Kinerja Rawat Inap', function ($sheet) use ($kinerja) {
                $row = 1;
                $no = 1;
                $sheet->row($row, [
                    'No',
                    'registrasi_id',
                    'pasien',
                    'noRM',
                    'namatarif',
                    'jenisPasien',
                    'total',
                    'JasaPelayanan',
                    'dokter',
                    'bangsal',
                    'kamar',
                    'dpjp',
                    'pelaksana',
                    'dokter_anestesi',
                    'perawat_anestesi1',
                    'perawat_anestesi2',
                    'perawat_anestesi3',
                    'dokter_operator',
                    'dokter_lab',
                    'analis_lab',
                    'dokter_radiologi',
                    'radiografer',
                    'perawat',
                    'dokter_bedah',
                    'perawat_ibs1',
                    'perawat_ibs2',
                    'perawat_ibs3',
                    'perawat_ibs4',
                    'perawat_ibs5',
                    'admin',
                    'created_at',
                    'updated_at',
                ]);
                foreach ($kinerja as $key => $d) {
                    $sheet->row(++$row, [
                        $no++,
                        $d->registrasi_id,
                        $d->pasien,
                        $d->noRM,
                        $d->namatarif,
                        $d->jenisPasien,
                        $d->total,
                        $d->JasaPelayanan,
                        $d->dokter,
                        $d->bangsal,
                        $d->kamar,
                        $d->dpjp,
                        $d->pelaksana,
                        $d->dokter_anestesi,
                        $d->perawat_anestesi1,
                        $d->perawat_anestesi2,
                        $d->perawat_anestesi3,
                        $d->dokter_operator,
                        $d->dokter_lab,
                        $d->analis_lab,
                        $d->dokter_radiologi,
                        $d->radiografer,
                        $d->perawat,
                        $d->dokter_bedah,
                        $d->perawat_ibs1,
                        $d->perawat_ibs2,
                        $d->perawat_ibs3,
                        $d->perawat_ibs4,
                        $d->perawat_ibs5,
                        $d->admin,
                        $d->created_at,
                        $d->updated_at,
                    ]);
                }
            });
        })->export('xlsx');
    }

    public function detailKinerjaRawatInap($dokter_id, $cara_bayar_id, $mapping)
    {
        $pemeriksaan = Tarif::where('mapping_pemeriksaan', $mapping)->get();
        $pm = [];
        foreach ($pemeriksaan as $key => $d) {
            $pm[] = '' . $d->id . '';
        }
        $bayar = [];
        foreach (Carabayar::select('id')->get() as $d) {
            $bayar[] = '' . $d->id . '';
        }
        if ($cara_bayar_id == '100') {
            $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->whereIn('cara_bayar_id', $bayar)->where('jenis', 'TI')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();
        } else {
            $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('cara_bayar_id', $cara_bayar_id)->where('jenis', 'TI')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();
        }
        return view('direksi.detailKinerjaRawatInap', $data)->with('no', 1);
    }

    public function laporanLOS()
    {
        $data['kamar'] = Kelompokkelas::select('kelompok', 'id')->get();
        return view('direksi.laporanLOS', $data);
    }

    public function viewLOS(Request $req)
    {
        $tga = date(valid_date($req['tga']) . ' 00:00:00');
        $tgb = date(valid_date($req['tgb']) . ' 23:59:59');

        $los = Rawatinap::join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->where('kelompokkelas_id', $req['kelompokkelas_id'])
            ->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
            ->orderBy('rawatinaps.tgl_keluar', 'asc')
            ->select('rawatinaps.kelompokkelas_id', 'rawatinaps.tgl_masuk', 'rawatinaps.tgl_keluar', 'registrasis.pasien_id')
            ->get();
        return DataTables::of($los)
            ->addColumn('kamar', function ($los) {
                return Kelompokkelas::find($los->kelompokkelas_id)->kelompok;
            })
            ->addColumn('pasien', function ($los) {
                return Pasien::find($los->pasien_id)->nama;
            })
            ->addColumn('no_rm', function ($los) {
                return Pasien::find($los->pasien_id)->no_rm;
            })
            ->addColumn('jml', function ($los) {
                $date1 = Carbon::createMidnightDate(tglLOS($los->tgl_masuk, 'Y'), tglLOS($los->tgl_masuk, 'm'), tglLOS($los->tgl_masuk, 'd'));
                $date2 = Carbon::createMidnightDate(tglLOS($los->tgl_keluar, 'Y'), tglLOS($los->tgl_keluar, 'm'), tglLOS($los->tgl_keluar, 'd'));
                return $date1->diffInDays($date2);
            })
            ->make(true);
    }

    public function laporanTransaksiKeluar()
    {
        $data['poli'] = Poli::all();

        $data['data_klasifikasi'] = KlasifikasiPengeluaran::orderBy('name', 'ASC')->get();
        $data['klasifikasi'] = '0';

        $data['data_jenis'] = JenisPengeluaran::orderBy('name', 'ASC')->get();
        $data['jenis'] = '0';



        return view('direksi.laporan_transaksi_keluar', $data)->with('no', 1);
    }

    public static function viewLaporanTransaksiKeluar(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tga']    = valid_date($request['tga']);
        $data['tgb']    = valid_date($request['tgb']);

        $data['klasifikasi'] = $request['klasifikasi'];
        $data['jenis'] = $request['jenis'];

        $data['data_klasifikasi'] = KlasifikasiPengeluaran::orderBy('name', 'ASC')->get();
        $data['data_jenis'] = JenisPengeluaran::orderBy('name', 'ASC')->get();

        $data['data'] = TransaksiKeluar::whereBetween('tanggal', [$data['tga'], $data['tgb']]);

        if ($request['klasifikasi'] !== '0') { //jika dapat kategori pembayran
            $data['data'] = $data['data']->where('klasifikasi_pengeluaran_id', $request['klasifikasi']);
        }
        if ($request['jenis'] !== '0') { //jika dapat kategori pembayran
            $data['data'] = $data['data']->where('jenis_pengeluaran_id', $request['jenis']);
        }


        // ->get();

        $data['data'] = $data['data']->orderBy('tanggal', 'DESC')->orderBy('no_bkk', 'ASC');
        // dd($data['data']->get());
        // $data['pembayaran']->get();

        if ($request['tampil']) {
            return view('direksi.laporan_transaksi_keluar', $data)->with('no', 1);
        } elseif ($request['cetak']) {

            // dd($data['pembayaran']);
            $pembayaran = $data['pembayaran'];
            $no = 1;
            $tga = $data['tga'];
            $tgb = $data['tgb'];
            $kategori = $data['kategori'];

            // $pdf = PDF::loadView('direksi.pdf_pendapatan', compact('pembayaran', 'no', 'tga', 'tgb', 'kategori'));
            // $pdf->setPaper('A4', 'portrait');
            // return $pdf->stream('pendapatan.pdf');
            // request()->validate(['tga' => 'required', 'tgb' => 'required']);
            // $tga = date(valid_date($request['tga']) . ' 00:00:00');
            // $tgb = date(valid_date($request['tgb']) . ' 23:59:59');
            // $data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            // 	->whereBetween('registrasis.created_at', [$tga, $tgb])
            // 	->where('poli_id', $request['poliId'])
            //     ->select('registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.id as registrasi_id', 'pasiens.no_rm', 'pasiens.nama', 'pasiens.alamat', 'pasiens.tgllahir', 'pasiens.kelamin')
            //     ->get();
            Excel::create('Laporan Pendapatan ', function ($excel) use ($data) {
                // Set the properties
                $excel->setTitle('Laporan Pendapatan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pendapatan');
                $excel->sheet('Laporan Pendapatan', function ($sheet) use ($data) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'No RM',
                        'Alamat',
                        'Ruang Rawat',
                        'Umur',
                        'L/P',
                        'Klinik',
                        'Dokter',
                        'Cara Bayar',
                        'Tindakan HD',
                        'LAB',
                        'RO',
                        'Gizi',
                        'Ekg',
                        'Darah',
                        'Obat',
                        'Total',
                        'Tarif',
                    ]);
                    foreach ($data as $key => $d) {
                        $total = Folio::where('registrasi_id', $d->registrasi_id)->where('poli_id', $d->poli_id)->sum('total');
                        $inacbg = Inacbg::where('registrasi_id', $d->registrasi_id)->first();
                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            $d->no_rm,
                            $d->alamat,
                            $d->registrasi_id,
                            hitung_umur($d->tgllahir),
                            $d->kelamin,
                            baca_poli($d->poli_id),
                            baca_dokter($d->dokter_id),
                            baca_carabayar($d->bayar),
                            Folio::where('registrasi_id', $d->registrasi_id)->where('poli_id', 20)->sum('total'),
                            Folio::where('registrasi_id', $d->registrasi_id)->where('poli_id', 26)->sum('total'),
                            Folio::where('registrasi_id', $d->registrasi_id)->where('poli_id', 27)->sum('total'),
                            '',
                            '',
                            Folio::where('registrasi_id', $d->registrasi_id)->where('poli_id', 30)->sum('total'),
                            Folio::where('registrasi_id', $d->registrasi_id)->where('tarif_id', 10000)->sum('total'),
                            $total,
                            $inacbg ? $inacbg->dijamin : '',
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function LapTindakan()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8000M');

        $data['dokter']            = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
        $data['tindakan']        = Tarif::groupBy('nama')->get();
        $data['cara_bayar']        = Carabayar::all();

        $data['tga']            = '';
        $data['tgb']            = '';
        $data['jenis_pasien']    = 0;
        $data['asal_tindakan']    = 'semua';
        $data['dokter_id']        = 0;
        $data['tarif_id']        = 0;
        $data['operasi']        = [];
        $data['detail_dokter']    = [];
        $data['catatan'] = [];
        return view('direksi.laporan.laporan-tindakan', $data)->with('no', 1);
    }

    public function LapTindakan_by(Request $req)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '8000M');
        // dd($req->all());
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tarif']            = Tarif::find($req->tarif_id);
        // dd($data['tarif']);
        $data['dokter']            = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
        $data['tindakan']        = Tarif::groupBy('nama')->get();
        $data['cara_bayar']        = Carabayar::all();

        $data['tga']            = $req->tga;
        $data['tgb']            = $req->tgb;
        $data['jenis_pasien']    = $req->jenis_pasien;
        $data['asal_tindakan']    = $req->asal_tindakan;
        $data['dokter_id']        = $req->dokter_id;
        $data['tarif_id']        = $req->tarif_id;

        $tga                = valid_date($req['tga']) . ' 00:00:00';
        $tgb                = valid_date($req['tgb']) . ' 23:59:59';

        // Update: Tampilkan semua tindakan baik TI, TA, TG
        $data['tindakan_pasien']        = Folio::with('obat')->whereBetween('folios.created_at', [$tga, $tgb])
            // ->where('folios.jenis', '!=', 'ORJ')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('kelompok_kelas', 'kelompok_kelas.id', '=', 'rawatinaps.kelompokkelas_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->leftJoin('pegawais as dpjp', 'dpjp.id', '=', 'folios.dokter_id')
            ->leftJoin('pegawais as pelaksana', 'pelaksana.id', '=', 'folios.dokter_pelaksana')
            ->select('folios.registrasi_id', 'folios.jenis', 'folios.tarif_id', 'folios.dokter_radiologi', 'folios.poli_id', 'folios.kamar_id', 'folios.created_at', 'folios.namatarif', 'folios.total', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'registrasis.status', 'registrasis.bayar', 'registrasis.tipe_jkn', 'carabayars.carabayar', 'kelompok_kelas.kelompok', 'dpjp.nama as dpjp', 'pelaksana.nama as pelaksana', 'registrasis.no_sep', 'registrasis.poli_id');
        if ($data['dokter_id']) {
            $data['tindakan_pasien']->where('folios.dokter_id', $data['dokter_id']);
        }
        if ($data['jenis_pasien']) {
            $data['tindakan_pasien']->where(function ($query) use ($data) {
                $query->where('folios.jenis_pasien', $data['jenis_pasien'])
                    ->orWhere('folios.jenis', 'ORJ');
            });
        }
        if ($data['tarif_id']) {
            $data['tindakan_pasien']->where('folios.namatarif', $data['tarif']->nama);
        }
        if ($req->asal_tindakan != "semua") {
            $data['tindakan_pasien']->where(function ($query) use ($req) {
                $query->where('folios.jenis', 'like', '%' . $req->asal_tindakan . '%')
                    ->orWhere('folios.jenis', 'ORJ');
            });
        }

        $data['tindakan_pasien'] = $data['tindakan_pasien']
            ->orderBy('folios.created_at', 'ASC')
            ->groupBy('folios.registrasi_id', 'tarif_id')->get();

        $data['grandTotal'] = $data['tindakan_pasien']->sum('total');
        $data['tindakan_pasien_new'] = [];
        foreach ($data['tindakan_pasien'] as $element) {
            $data['tindakan_pasien_new'][$element['registrasi_id']][] = $element;
        }

        // dd($data['tindakan_pasien_new']);
        if ($req->lanjut) {
            return view('direksi.laporan.laporan-tindakan', $data)->with('no', 1);
        } elseif ($req->excel) {
            Excel::create('Laporan Tagihan '.@$tga.'/'.@$tgb, function ($excel) use ($data) {
                // Set the properties
                $excel->setTitle('Laporan Tagihan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Tagihan');
                $excel->sheet('Laporan Tagihan', function ($sheet) use ($data) {
                    $row = 1;
                    $no  = 1;
                    $sheet->row($row, [
                        'No',
                        'No.RM',
                        'Nama',
                        'Ruangan',
                        'Nomor SEP',
                        'Status',
                        'L/P',
                        'Bayar',
                        'Dokter Pelaksana',
                        'DPJP',
                        'Dokter Radiologi',
                        'Tangal',
                        'Nama Tindakan',
                        'Total',
                    ]);
                    foreach ($data['tindakan_pasien'] as $key => $d) {
                        $carabayar = $d->carabayar;
                        if ($d->bayar == '1') {
                            $carabayar = $carabayar . " - " .  @$d->tipe_jkn;
                            $carabayar = strtoupper($carabayar);
                        }
                        $kelompok = null;
                        if ($d->jenis == 'TI') {
                            $kelompok = @$d->kelompok;
                        }
                        if ($d->jenis == 'TG') {
                            $kelompok = 'IGD';
                        } elseif ($d->jenis == 'TA') {
                            $kelompok = baca_poli($d->poli_id);
                        }

                        $obat = '';
                        if (@$d->jenis == 'ORJ') {
                            foreach (@$d->obat as $p) {
                                $obat .= ', ' . @$p->logistik_batch->nama_obat . (@$p->jumlah) . ' - Rp. ' . number_format(@$p->hargajual);
                            }
                        }

                        $sheet->row(++$row, [
                            $no++,
                            @$d->no_rm,
                            @$d->nama,
                            @$kelompok,
                            @$d->no_sep,
                            @$d->status == 'baru' ? 'Baru' : 'Lama',
                            @$d->kelamin,
                            @$carabayar,
                            @$d->pelaksana,
                            @$d->dpjp,
                            baca_dokter(@$d->dokter_radiologi),
                            date('d-m-Y', strtotime(@$d->created_at)),
                            @$d->namatarif . ', ' . $obat,
                            @$d->total,
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }
    public function LapTindakanUmum()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8000M');

        // $data['dokter']            = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
        // $data['tindakan']        = Tarif::groupBy('nama')->get();
        $data['cara_bayar']        = Carabayar::all();

        $data['tga']            = '';
        $data['tgb']            = '';
        $data['jenis_pasien']    = 0;
        $data['asal_tindakan']    = 'semua';
        $data['dokter_id']        = 0;
        $data['tarif_id']        = 0;
        $data['operasi']        = [];
        $data['detail_dokter']    = [];
        $data['catatan'] = [];
        return view('direksi.laporan.laporan-tindakan-umum', $data)->with('no', 1);
    }

    public function LapTindakanUmum_by(Request $req)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '8000M');
        // dd($req->all());
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        // $data['tarif']            = Tarif::find($req->tarif_id);
        // dd($data['tarif']);
        // $data['dokter']            = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
        // $data['tindakan']        = Tarif::groupBy('nama')->get();
        $data['cara_bayar']        = Carabayar::all();

        $data['tga']            = $req->tga;
        $data['tgb']            = $req->tgb;
        $data['jenis_pasien']    = $req->jenis_pasien;
        $data['asal_tindakan']    = $req->asal_tindakan;
        $data['dokter_id']        = $req->dokter_id;
        $data['tarif_id']        = $req->tarif_id;

        $tga                = valid_date($req['tga']) . ' 00:00:00';
        $tgb                = valid_date($req['tgb']) . ' 23:59:59';

        // Update: Tampilkan semua tindakan baik TI, TA, TG
        $data['tindakan_pasien_new']        = Folio::
            whereBetween('folios.created_at', [$tga, $tgb])
            ->whereBetween('registrasis.created_at', [$tga, $tgb])
            ->where('registrasis.bayar', 2) //AMBIL REGISTRASI YANG CARA BAYAR UMUM
            ->where('folios.cara_bayar_id', '!=', 1) //AMBIL FOLIOS YANG CARA BAYAR ID TIDAK SAMA DENGAN 1
            ->where('folios.lunas', 'N')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->groupBy('registrasis.id')
            ->orderBy('registrasis.created_at', 'ASC')
            ->selectRaw('pasiens.nama AS nama_pasien,pasiens.no_rm,SUM(folios.total) AS total,registrasis.status_reg,registrasis.created_at AS tgl_reg,registrasis.id AS registrasi_id');
        // dd($data['tindakan_pasien_new']->get());
        // dd($data['tindakan_pasien_new']);
        if ($req->lanjut) {
            return view('direksi.laporan.laporan-tindakan-umum', $data)->with('no', 1);
        } elseif ($req->excel) {
            $tindakan_pasien_new = $data['tindakan_pasien_new']->get();
            Excel::create('Laporan Penerimaan Tindakan '.date('d-m-Y',strtotime($tga)).'_'.date('d-m-Y',strtotime($tgb)), function ($excel) use ($tindakan_pasien_new,$tga,$tgb) {
                $excel->setTitle('Laporan Penerimaan Tindakan'.date('d-m-Y',strtotime($tga)).'_'.date('d-m-Y',strtotime($tgb)))
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Penerimaan Tindakan'.date('d-m-Y',strtotime($tga)).'_'.date('d-m-Y',strtotime($tgb)));
                $excel->sheet('Laporan Penerimaan Tindakan', function ($sheet) use ($tindakan_pasien_new,$tga,$tgb) {
                    $sheet->loadView('direksi.excel.laporan-tindakan-umum', compact('tindakan_pasien_new', 'tga', 'tgb'));
                });
            })->export('xlsx');
        }
    }
}
