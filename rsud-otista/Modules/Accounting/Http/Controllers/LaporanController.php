<?php

namespace Modules\Accounting\Http\Controllers;

use App\RkaRealisasi;
use App\PaguRka;
use App\RkaTriwulan;
use App\RkaTahun;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\Master\AkunCOA;
use Excel;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Ekuitas;
use Modules\Accounting\Entities\Sal;
use Modules\Accounting\Entities\PenguranganPiutang;
use Modules\Accounting\Entities\PenyisihanPiutang;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Accounting\Entities\Master\AkunType;
use PHPExcel_Style_Alignment;

class LaporanController extends Controller
{
    public static function monthIndonesia($angka)
    {
        $bulan = [
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        return $bulan[(int) $angka];
    }

    public static function reCode($code)
    {
        return $code;
    }

    /**
     * Display a listing of the laporan journal.
     * @return Response
     */
    public function lap_journal(Request $request)
    {
        $post = $request->except('_token');

        $getJournal = Journal::with('journal_detail.akun')->where('verifikasi', 1)->orderBy('id', 'DESC');
        if (!empty($post)) {
            $getJournal = $getJournal->where('tanggal', '>=', date('Y-m-d', strtotime($post['tga'])))
                ->where('tanggal', '<=', date('Y-m-d', strtotime($post['tgs'])));
        } else {
            $getJournal = $getJournal->where('tanggal', date('Y-m-d'));
        }
        $getJournal = $getJournal->where('type', '!=', 'anggaran')->where('type', '!=', 'journal_pengeluaran')->get()->toArray();

        if (isset($post['excel'])) {
            $datea = explode('-', $post['tga']);
            $dates = explode('-', $post['tgs']);

            $i = 0;
            $totalTrx = 0;
            foreach ($getJournal as $d) {
                $totalTrx = $totalTrx + $d['total_transaksi'];

                $export['data'][$i] = [
                    'date'          => date('H:i d-m-Y', strtotime($d['created_at'])),
                    'code'          => $d['code'],
                    'keterangan'    => $d['keterangan'],
                    'akun'          => '',
                    'transaksi'     => $d['total_transaksi']
                ];
                $i++;
            }
            $export['total'] = [
                'date'          => '',
                'code'          => '',
                'keterangan'    => 'Total',
                'akun'          => '',
                'transaksi'     => $totalTrx
            ];
            Excel::load('laporan/Jurnal Penerimaan.xlsx', function ($doc) use ($export, $datea, $dates) {
                $doc->sheet('Sheet1', function ($sheet) use ($export, $datea, $dates) {
                    $sheet->setCellValue('A3', "Periode " . $datea[0] . " " . $this->monthIndonesia($datea[1]) . " " . $datea[2] . " sampai " . $dates[0] . " " . $this->monthIndonesia($dates[1]) . " " . $datea[2]);
                    $k = 8;
                    foreach ($export['data'] as $exp) {
                        $sheet->setCellValue('A' . $k, $exp['date']);
                        $sheet->setCellValue('B' . $k, $exp['code']);
                        $sheet->setCellValue('C' . $k, $exp['keterangan']);
                        $sheet->setCellValue('D' . $k, $exp['transaksi']);
                        $sheet->cell('A' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('B' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('C' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('D' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $k++;
                    }
                    $k = $k + 1;
                    $sheet->setCellValue('A' . $k, 'Total');
                    $sheet->setCellValue('D' . $k, $export['total']['transaksi']);

                    $k = $k + 2;
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, 'Kuningan, ');

                    $k = $k + 2;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, 'Mengetahui,');

                    $k = $k + 1;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, 'Bendahara Penerimaan');

                    $k = $k + 7;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, '_________________________');
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, '_________________________');

                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
        } else {
            $i = 0;
            $totalDeb = 0;
            $totalCre = 0;
            if ($getJournal) {
                foreach ($getJournal as $value) {
                    $data['data'][$i] = [
                        'date'          => date('d-m-Y', strtotime($value['tanggal'])),
                        'code'          => $value['code'],
                        'keterangan'    => $value['keterangan'],
                        'akun'          => '',
                        'debit'         => '',
                        'credit'        => '',
                    ];
                    $i++;
                    $sumDeb = 0;
                    $sumCre = 0;
                    foreach ($value['journal_detail'] as $jd) {
                        $data['data'][$i] = [
                            'date'          => '',
                            'code'          => '',
                            'keterangan'    => $jd['akun']['nama'],
                            'akun'          => $jd['akun']['code'],
                            'debit'         => $jd['debit'],
                            'credit'        => $jd['credit'],
                        ];
                        $sumDeb = $sumDeb + $jd['debit'];
                        $sumCre = $sumCre + $jd['credit'];

                        $totalDeb = $totalDeb + $jd['debit'];
                        $totalCre = $totalCre + $jd['credit'];
                        $i++;
                    }
                    $data['data'][$i] = [
                        'date'          => '',
                        'code'          => '',
                        'keterangan'    => 'Total',
                        'akun'          => '',
                        'debit'         => $sumDeb,
                        'credit'        => $sumCre,
                    ];
                    $i++;
                    $data['data'][$i] = [
                        'date'          => '',
                        'code'          => '',
                        'keterangan'    => '',
                        'akun'          => '',
                        'debit'         => '',
                        'credit'        => '',
                    ];
                    $i++;
                }
            } else {
                $data['data'] = [];
            }

            $data['total'] = [
                'date'          => '',
                'code'          => '',
                'keterangan'    => 'Total',
                'akun'          => '',
                'debit'         => $totalDeb,
                'credit'        => $totalCre,
            ];
            return view('accounting::laporan.journal.index', $data);
        }
    }

    public function lap_journal_export(Request $request)
    {
        $post = $request->except('_token');

        $datea = explode('-', $post['tgea']);
        $dates = explode('-', $post['tges']);

        $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(SUM(akutansi_journals.total_transaksi), 0) AS total_transaksi'))
            ->where('akutansi_journals.verifikasi', 1)
            ->whereBetween('akutansi_journals.tanggal', [$datea[1] . '-' . $datea[0] . '-01', $dates[1] . '-' . $dates[0] . '-' . date('t', strtotime($dates[1] . '-' . $dates[0] . '-01'))])
            ->where('akutansi_journals.type', '!=', 'anggaran')->where('akutansi_journals.type', '!=', 'journal_pengeluaran')->groupBy('akutansi_journals.tanggal')->get()->toArray();

        $i = 0;
        $totalTrx = 0;
        foreach ($getJournal as $d) {
            $tanggal = explode(' ', $d['tanggal']);
            $totalTrx = $totalTrx + $d['total_transaksi'];

            $export['data'][$i] = [
                'date'          => date('d-m-Y', strtotime($d['created_at'])),
                'code'          => $d['code'],
                'keterangan'    => 'Journal Penerimaan Tanggal ' . explode('-', $tanggal[0])[2],
                'akun'          => '',
                'transaksi'     => $d['total_transaksi']
            ];
            $i++;
        }
        $export['total'] = [
            'date'          => '',
            'code'          => '',
            'keterangan'    => 'Total',
            'akun'          => '',
            'transaksi'     => $totalTrx
        ];

        Excel::load('laporan/Jurnal Penerimaan.xlsx', function ($doc) use ($post, $export, $datea, $dates) {
            $doc->sheet('Sheet1', function ($sheet) use ($post, $export, $datea, $dates) {
                $sheet->setCellValue('A3', "TAHUN ANGGARAN " . explode('-', $post['tgea'])[1] . " Periode " . $this->monthIndonesia($datea[0]) . " sampai " . $this->monthIndonesia($dates[0]));
                $k = 8;
                foreach ($export['data'] as $exp) {
                    $sheet->setCellValue('A' . $k, $exp['date']);
                    $sheet->setCellValue('B' . $k, 'Penerimaan-' . date('d.m.Y', strtotime($exp['date'])));
                    $sheet->setCellValue('C' . $k, $exp['keterangan']);
                    $sheet->setCellValue('D' . $k, $exp['transaksi']);
                    $sheet->cell('A' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell('B' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell('C' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell('D' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $k++;
                }
                $k = $k + 1;
                $sheet->setCellValue('A' . $k, 'Total');
                $sheet->setCellValue('D' . $k, $export['total']['transaksi']);

                $k = $k + 2;
                $sheet->mergeCells('C' . $k . ':D' . $k);
                $sheet->setCellValue('C' . $k, 'Kuningan, ');

                $k = $k + 2;
                $sheet->mergeCells('A' . $k . ':B' . $k);
                $sheet->setCellValue('A' . $k, 'Mengetahui,');

                $k = $k + 1;
                $sheet->mergeCells('A' . $k . ':B' . $k);
                $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                $sheet->mergeCells('C' . $k . ':D' . $k);
                $sheet->setCellValue('C' . $k, 'Bendahara Penerimaan');

                $k = $k + 7;
                $sheet->mergeCells('A' . $k . ':B' . $k);
                $sheet->setCellValue('A' . $k, '_________________________');
                $sheet->mergeCells('C' . $k . ':D' . $k);
                $sheet->setCellValue('C' . $k, '_________________________');

                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
    }

    public function lap_journal_pengeluaran(Request $request)
    {
        $post = $request->except('_token');

        $getJournal = Journal::with('journal_detail.akun')->where('verifikasi', 1)->orderBy('id', 'DESC');
        if (!empty($post)) {
            $getJournal = $getJournal->where('tanggal', '>=', date('Y-m-d', strtotime($post['tga'])))
                ->where('tanggal', '<=', date('Y-m-d', strtotime($post['tgs'])));
        } else {
            $getJournal = $getJournal->where('tanggal', date('Y-m-d'));
        }
        $getJournal = $getJournal->where('type', 'journal_pengeluaran')->get()->toArray();

        if (isset($post['excel'])) {
            $datea = explode('-', $post['tga']);
            $dates = explode('-', $post['tgs']);

            $i = 0;
            $totalTrx = 0;
            foreach ($getJournal as $d) {
                $totalTrx = $totalTrx + $d['total_transaksi'];

                $export['data'][$i] = [
                    'date'          => date('H:i d-m-Y', strtotime($d['created_at'])),
                    'code'          => $d['code'],
                    'keterangan'    => $d['keterangan'],
                    'akun'          => '',
                    'transaksi'     => $d['total_transaksi']
                ];
                $i++;
            }
            $export['total'] = [
                'date'          => '',
                'code'          => '',
                'keterangan'    => 'Total',
                'akun'          => '',
                'transaksi'     => $totalTrx
            ];
            Excel::load('laporan/Jurnal Pengeluaran.xlsx', function ($doc) use ($export, $datea, $dates) {
                $doc->sheet('Sheet1', function ($sheet) use ($export, $datea, $dates) {
                    $sheet->setCellValue('A3', "Periode " . $datea[0] . " " . $this->monthIndonesia($datea[1]) . " " . $datea[2] . " sampai " . $dates[0] . " " . $this->monthIndonesia($dates[1]) . " " . $datea[2]);
                    $k = 8;
                    foreach ($export['data'] as $exp) {
                        $sheet->setCellValue('A' . $k, $exp['date']);
                        $sheet->setCellValue('B' . $k, $exp['code']);
                        $sheet->setCellValue('C' . $k, $exp['keterangan']);
                        $sheet->setCellValue('D' . $k, $exp['transaksi']);
                        $sheet->cell('A' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('B' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('C' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('D' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $k++;
                    }
                    $k = $k + 1;
                    $sheet->setCellValue('A' . $k, 'Total');
                    $sheet->setCellValue('D' . $k, $export['total']['transaksi']);

                    $k = $k + 2;
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, 'Kuningan, ');

                    $k = $k + 2;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, 'Mengetahui,');

                    $k = $k + 1;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, 'Bendahara Pengeluaran');

                    $k = $k + 7;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, '_________________________');
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, '_________________________');

                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
        } else {
            $i = 0;
            $totalDeb = 0;
            $totalCre = 0;
            if ($getJournal) {
                foreach ($getJournal as $value) {
                    $data['data'][$i] = [
                        'date'          => date('d-m-Y', strtotime($value['tanggal'])),
                        'code'          => $value['code'],
                        'keterangan'    => $value['keterangan'],
                        'akun'          => '',
                        'debit'         => '',
                        'credit'        => '',
                    ];
                    $i++;
                    $sumDeb = 0;
                    $sumCre = 0;
                    foreach ($value['journal_detail'] as $jd) {
                        $code = str_split($jd['akun']['code']);
                        $data['data'][$i] = [
                            'date'          => '',
                            'code'          => '',
                            'keterangan'    => $jd['akun']['nama'],
                            'akun'          => $code[0] . '.' . $code[1] . '.' . $code[2] . '.' . $code[3] . $code[4] . '.' . $code[5] . $code[6],
                            'debit'         => $jd['debit'],
                            'credit'        => $jd['credit'],
                        ];
                        $sumDeb = $sumDeb + $jd['debit'];
                        $sumCre = $sumCre + $jd['credit'];

                        $totalDeb = $totalDeb + $jd['debit'];
                        $totalCre = $totalCre + $jd['credit'];
                        $i++;
                    }
                    $data['data'][$i] = [
                        'date'          => '',
                        'code'          => '',
                        'keterangan'    => 'Total',
                        'akun'          => '',
                        'debit'         => $sumDeb,
                        'credit'        => $sumCre,
                    ];
                    $i++;
                    $data['data'][$i] = [
                        'date'          => '',
                        'code'          => '',
                        'keterangan'    => '',
                        'akun'          => '',
                        'debit'         => '',
                        'credit'        => '',
                    ];
                    $i++;
                }
            } else {
                $data['data'] = [];
            }

            $data['total'] = [
                'date'          => '',
                'code'          => '',
                'keterangan'    => 'Total',
                'akun'          => '',
                'debit'         => $totalDeb,
                'credit'        => $totalCre,
            ];

            return view('accounting::laporan.journal_pengeluaran.index', $data);
        }
    }

    public function lap_journal_pengeluaran_export(Request $request)
    {
        $post = $request->except('_token');

        $datea = explode('-', $post['tgea']);
        $dates = explode('-', $post['tges']);

        $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(SUM(akutansi_journals.total_transaksi), 0) AS total_transaksi'))
            ->where('akutansi_journals.verifikasi', 1)
            ->whereBetween('akutansi_journals.tanggal', [$datea[1] . '-' . $datea[0] . '-01', $dates[1] . '-' . $dates[0] . '-' . date('t', strtotime($dates[1] . '-' . $dates[0] . '-01'))])
            ->where('akutansi_journals.type', 'journal_pengeluaran')->groupBy('akutansi_journals.tanggal')->get()->toArray();

        $i = 0;
        $totalTrx = 0;
        foreach ($getJournal as $d) {
            $tanggal = explode(' ', $d['tanggal']);
            $totalTrx = $totalTrx + $d['total_transaksi'];

            $export['data'][$i] = [
                'date'          => date('d-m-Y', strtotime($d['created_at'])),
                'code'          => $d['code'],
                'keterangan'    => 'Journal Pengeluaran Tanggal ' . explode('-', $tanggal[0])[2],
                'akun'          => '',
                'transaksi'     => $d['total_transaksi']
            ];
            $i++;
        }
        $export['total'] = [
            'date'          => '',
            'code'          => '',
            'keterangan'    => 'Total',
            'akun'          => '',
            'transaksi'     => $totalTrx
        ];

        Excel::load('laporan/Jurnal Pengeluaran.xlsx', function ($doc) use ($post, $export, $datea, $dates) {
            $doc->sheet('Sheet1', function ($sheet) use ($post, $export, $datea, $dates) {
                $sheet->setCellValue('A3', "TAHUN ANGGARAN " . explode('-', $post['tgea'])[1] . " Periode " . $this->monthIndonesia($datea[0]) . " sampai " . $this->monthIndonesia($dates[0]));
                $k = 8;
                foreach ($export['data'] as $exp) {
                    $sheet->setCellValue('A' . $k, $exp['date']);
                    $sheet->setCellValue('B' . $k, 'Pengeluaran-' . date('d.m.Y', strtotime($exp['date'])));
                    $sheet->setCellValue('C' . $k, $exp['keterangan']);
                    $sheet->setCellValue('D' . $k, $exp['transaksi']);
                    $sheet->cell('A' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell('B' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell('C' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell('D' . $k, function ($cells) {
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $k++;
                }
                $k = $k + 1;
                $sheet->setCellValue('A' . $k, 'Total');
                $sheet->setCellValue('D' . $k, $export['total']['transaksi']);

                $k = $k + 2;
                $sheet->mergeCells('C' . $k . ':D' . $k);
                $sheet->setCellValue('C' . $k, 'Kuningan, ');

                $k = $k + 2;
                $sheet->mergeCells('A' . $k . ':B' . $k);
                $sheet->setCellValue('A' . $k, 'Mengetahui,');

                $k = $k + 1;
                $sheet->mergeCells('A' . $k . ':B' . $k);
                $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                $sheet->mergeCells('C' . $k . ':D' . $k);
                $sheet->setCellValue('C' . $k, 'Bendahara Pengeluaran');

                $k = $k + 7;
                $sheet->mergeCells('A' . $k . ':B' . $k);
                $sheet->setCellValue('A' . $k, '_________________________');
                $sheet->mergeCells('C' . $k . ':D' . $k);
                $sheet->setCellValue('C' . $k, '_________________________');

                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
    }

    public function lap_buku_besar_penerimaan(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['excel'])) {
            $getAkun = AkunCOA::where('status', 1)->where('id', $post['excel'])->get()->toArray();
        } else {
            $getAkun = AkunCOA::where('status', 1)->where('code', 'like', '1011%')->where('akun_code_9', '!=', '0')->get()->toArray();
        }

        $getData = [];
        $i = 0;
        foreach ($getAkun as $value) {
            $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id']);
            if (!empty($post)) {
                $getJournal = $getJournal->where('akutansi_journals.created_at', '>=', date('Y-m-d H:i', strtotime($post['tga'])))
                    ->where('akutansi_journals.created_at', '<=', date('Y-m-d H:i', strtotime($post['tgs'])));
            } else {
                $getJournal = $getJournal->where('akutansi_journals.created_at', date('Y-m-d'));
            }
            $getJournal = $getJournal->where('akutansi_journals.type', '!=', 'anggaran')->groupBy('akutansi_journals.id')->get()->toArray();
            if (!is_null($getJournal) && !empty($getJournal)) {
                $codeCoa = str_split($value['code']);
                $value['code'] = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];

                $getData['data'][$i]            = $value;
                $getData['data'][$i]['detail']  = $getJournal;
                $saldo          = 0;
                $totalDebit     = 0;
                $totalCredit    = 0;
                $totalSaldo     = 0;
                foreach ($getJournal as $kj => $journal) {
                    if ($value['saldo_normal'] == 'debit') {
                        $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                    } else {
                        $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                    }
                    $totalDebit     = $totalDebit + $journal['debit'];
                    $totalCredit    = $totalCredit + $journal['credit'];
                    $totalSaldo     = $saldo;

                    $getData['data'][$i]['detail'][$kj]['saldo'] = $saldo;
                    $getData['data'][$i]['total']['debit'] = (string) $totalDebit;
                    $getData['data'][$i]['total']['credit'] = (string) $totalCredit;
                    $getData['data'][$i]['total']['saldo'] = (string) $totalSaldo;

                    $export['detail'][$kj]  = $journal;
                    $export['detail'][$kj]['saldo'] = (string) $saldo;
                    $export['total']['debit'] = (string) $totalDebit;
                    $export['total']['credit'] = (string) $totalCredit;
                    $export['total']['saldo'] = (string) $totalSaldo;
                }
                $i++;
                if (isset($post['excel'])) {
                    Excel::load('laporan/Buku Besar Penerimaan.xlsx', function ($doc) use ($post, $value, $export) {
                        $doc->sheet('Sheet1', function ($sheet) use ($post, $value, $export) {
                            $sheet->setCellValue('A3', "TAHUN ANGGARAN " . explode('-', $post['tga'])[2]);
                            $sheet->setCellValue('C5', ": " . $value['code']);
                            $sheet->setCellValue('C6', ": " . $value['nama']);
                            $k = 13;
                            foreach ($export['detail'] as $exp) {
                                $sheet->setCellValue('A' . $k, date('H:i d-m-Y', strtotime($exp['created_at'])));
                                $sheet->setCellValue('B' . $k, $exp['keterangan']);
                                $sheet->setCellValue('C' . $k, $exp['code']);
                                $sheet->setCellValue('D' . $k, $exp['debit']);
                                $sheet->setCellValue('E' . $k, $exp['credit']);
                                $sheet->setCellValue('F' . $k, $exp['saldo']);
                                $sheet->cell('A' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $k++;
                            }
                            $k = $k + 1;
                            $sheet->setCellValue('A' . $k, 'Total');
                            $sheet->setCellValue('D' . $k, $export['total']['debit']);
                            $sheet->setCellValue('E' . $k, $export['total']['credit']);
                            $sheet->setCellValue('F' . $k, $export['total']['saldo']);

                            $k = $k + 2;
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Kuningan, ');

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Mengetahui,');

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Bendahara Penerimaan');

                            $k = $k + 7;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, '_________________________');
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, '_________________________');

                            $sheet->setAutoSize(true);
                        });
                    })->download('xlsx');
                }
            }
        }

        if (empty($getData)) {
            $getData['data'] = [];
        }
        // return $getData;
        return view('accounting::laporan.buku_besar.penerimaan', $getData);
    }

    public function lap_buku_besar_penerimaan_export(Request $request)
    {
        $post = $request->except('_token');
        $datea = explode('-', $post['tgea']);
        $dates = explode('-', $post['tges']);

        $getAkun = AkunCOA::where('status', 1)->where('code', '1110201')->get()->toArray();

        $getData = [];
        $i = 0;
        foreach ($getAkun as $value) {
            $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                ->whereBetween('akutansi_journals.tanggal', [$datea[1] . '-' . $datea[0] . '-01', $dates[1] . '-' . $dates[0] . '-' . date('t', strtotime($dates[1] . '-' . $dates[0] . '-01'))])
                ->where('akutansi_journals.type', '!=', 'anggaran')->groupBy('akutansi_journals.tanggal')->get()->toArray();

            if ($post['excel'] == 'monthly') {
                if (!is_null($getJournal) && !empty($getJournal)) {
                    $codeCoa = str_split($value['code']);
                    $value['code'] = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];

                    $getData['data'][$i]            = $value;
                    $getData['data'][$i]['detail']  = $getJournal;
                    $saldo          = 0;
                    $totalDebit     = 0;
                    $totalCredit    = 0;
                    $totalSaldo     = 0;
                    foreach ($getJournal as $kj => $journal) {
                        $tanggal = explode(' ', $journal['tanggal']);
                        if ($value['saldo_normal'] == 'debit') {
                            $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                        } else {
                            $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                        }
                        $totalDebit     = $totalDebit + $journal['debit'];
                        $totalCredit    = $totalCredit + $journal['credit'];
                        $totalSaldo     = $saldo;

                        $getData['data'][$i]['detail'][$kj]['saldo'] = $saldo;
                        $getData['data'][$i]['total']['debit'] = (string) $totalDebit;
                        $getData['data'][$i]['total']['credit'] = (string) $totalCredit;
                        $getData['data'][$i]['total']['saldo'] = (string) $totalSaldo;

                        $export['detail'][$kj]  = $journal;

                        $export['detail'][$kj]['ket'] = 'Buku Besar Penerimaan Tanggal ' . explode('-', $tanggal[0])[2];
                        $export['detail'][$kj]['saldo'] = (string) $saldo;
                        $export['total']['debit'] = (string) $totalDebit;
                        $export['total']['credit'] = (string) $totalCredit;
                        $export['total']['saldo'] = (string) $totalSaldo;
                    }
                    $i++;
                    Excel::load('laporan/Buku Besar Penerimaan.xlsx', function ($doc) use ($post, $value, $export, $datea, $dates) {
                        $doc->sheet('Sheet1', function ($sheet) use ($post, $value, $export, $datea, $dates) {
                            $sheet->setCellValue('A3', "TAHUN ANGGARAN " . explode('-', $post['tgea'])[1] . " Periode " . $this->monthIndonesia($datea[0]) . " sampai " . $this->monthIndonesia($dates[0]));
                            $sheet->setCellValue('C5', ": " . $value['code']);
                            $sheet->setCellValue('C6', ": " . $value['nama']);
                            $k = 13;
                            foreach ($export['detail'] as $exp) {
                                $sheet->setCellValue('A' . $k, date('H:i d-m-Y', strtotime($exp['created_at'])));
                                $sheet->setCellValue('B' . $k, $exp['ket']);
                                $sheet->setCellValue('C' . $k, 'Penerimaan-' . date('d.m.Y', strtotime($exp['tanggal'])));
                                $sheet->setCellValue('D' . $k, $exp['debit']);
                                $sheet->setCellValue('E' . $k, $exp['credit']);
                                $sheet->setCellValue('F' . $k, $exp['saldo']);
                                $sheet->cell('A' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $k++;
                            }
                            $k = $k + 1;
                            $sheet->setCellValue('A' . $k, 'Total');
                            $sheet->setCellValue('D' . $k, $export['total']['debit']);
                            $sheet->setCellValue('E' . $k, $export['total']['credit']);
                            $sheet->setCellValue('F' . $k, $export['total']['saldo']);

                            $k = $k + 2;
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Kuningan, ');

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Mengetahui,');

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Bendahara Penerimaan');

                            $k = $k + 7;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, '_________________________');
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, '_________________________');

                            $sheet->setAutoSize(true);
                        });
                    })->download('xlsx');
                }
            } else {
                if (!is_null($getJournal) && !empty($getJournal)) {
                    $codeCoa = str_split($value['code']);
                    $value['code'] = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];

                    $saldo          = 0;
                    $totalDebit     = 0;
                    $totalCredit    = 0;
                    $totalSaldo     = 0;
                    foreach ($getJournal as $kj => $journal) {
                        $tanggal = explode(' ', $journal['tanggal']);
                        if ($value['saldo_normal'] == 'debit') {
                            $saldo = $saldo + $journal['debit'];
                        } else {
                            $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                        }
                        $totalDebit     = $totalDebit + $journal['debit'];
                        $totalCredit    = $totalCredit + $journal['credit'];
                        $totalSaldo     = $saldo;

                        $export['detail'][$kj]  = $journal;
                        $export['detail'][$kj]['ket'] = 'Buku Besar Penerimaan Tanggal ' . explode('-', $tanggal[0])[2] . ' ' . $this->monthIndonesia(explode('-', $tanggal[0])[1]);
                        $export['detail'][$kj]['saldo'] = (string) $saldo;

                        $dateShift = explode(' ', $journal['tanggal'])[0];
                        $shiftPagi = Journal::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit - akutansi_journal_details.credit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                            ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                            ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                            ->whereBetween('akutansi_journals.created_at', [date($dateShift . ' 00:00'), date($dateShift . ' 13:31')])
                            ->where('akutansi_journals.type', '!=', 'anggaran')
                            ->where('akutansi_journals.code', 'NOT LIKE', 'TRF-SALDO%')
                            ->groupBy('akutansi_journals.tanggal')->get()->toArray();
                        $shiftSiang = Journal::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit - akutansi_journal_details.credit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                            ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                            ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                            ->whereBetween('akutansi_journals.created_at', [date($dateShift . ' 13:31'), date($dateShift . ' 23:59')])
                            ->where('akutansi_journals.type', '!=', 'anggaran')
                            ->where('akutansi_journals.code', 'NOT LIKE', 'TRF-SALDO%')
                            ->groupBy('akutansi_journals.tanggal')->get()->toArray();

                        $getSaldoAwal = Journal::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                            ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                            ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                            ->where('akutansi_journals.tanggal', '<=', $datea[1] . '-' . $datea[0] . '-01')
                            ->where('akutansi_journals.type', '!=', 'anggaran')->first()->toArray();

                        if ($shiftPagi) {
                            $export['detail'][$kj]['shift']['pagi'] = $shiftPagi[0];
                        } else {
                            $export['detail'][$kj]['shift']['pagi'] = [
                                'debit'     => 0,
                                'credit'    => 0
                            ];
                        }
                        if ($shiftSiang) {
                            $export['detail'][$kj]['shift']['siang'] = $shiftSiang[0];
                        } else {
                            $export['detail'][$kj]['shift']['siang'] = [
                                'debit'     => 0,
                                'credit'    => 0
                            ];
                        }
                        if ((int) $journal['credit'] > 0) {
                            $export['detail'][$kj]['shift']['transfer'] = (int) $journal['credit'];
                        }
                        $export['total']['debit'] = (string) $totalDebit;
                        $export['total']['credit'] = (string) $totalCredit;
                        $export['total']['saldo'] = (string) $totalSaldo;
                    }

                    $i++;
                    Excel::load('laporan/BKU Penerimaan.xlsx', function ($doc) use ($getSaldoAwal, $post, $export, $datea) {
                        $doc->sheet('Sheet1', function ($sheet) use ($getSaldoAwal, $post, $export, $datea) {
                            $sheet->setCellValue('A3', $this->monthIndonesia($datea[0]) . " " . explode('-', $post['tgea'])[1]);

                            $sheet->setCellValue('A12', 1);
                            $sheet->setCellValue('C12', 'Saldo Awal Bulan Lalu');
                            $sheet->setCellValue('D12', $getSaldoAwal['debit']);
                            $sheet->setCellValue('E12', $getSaldoAwal['credit']);
                            $sheet->setCellValue('F12', $getSaldoAwal['debit'] - $getSaldoAwal['credit']);
                            $sheet->cell('A12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('B12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('C12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('D12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('E12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('F12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });

                            $k = 13;
                            $i = 2;
                            $saldo = $getSaldoAwal['debit'] - $getSaldoAwal['credit'];
                            foreach ($export['detail'] as $exp) {
                                $saldo = $saldo + $exp['debit'];
                                $sheet->setCellValue('A' . $k, $i++);
                                $sheet->setCellValue('B' . $k, date('d-m-Y', strtotime($exp['created_at'])));
                                $sheet->setCellValue('C' . $k, $exp['ket']);
                                $sheet->setCellValue('D' . $k, $exp['debit']);
                                $sheet->setCellValue('E' . $k, 0);
                                $sheet->setCellValue('F' . $k, $saldo);
                                $sheet->cell('A' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    $cells->setBackground('#808080');
                                });
                                $sheet->cell('B' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    $cells->setBackground('#808080');
                                });
                                $sheet->cell('C' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    $cells->setBackground('#808080');
                                });
                                $sheet->cell('D' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    $cells->setBackground('#808080');
                                });
                                $sheet->cell('E' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    $cells->setBackground('#808080');
                                });
                                $sheet->cell('F' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    $cells->setBackground('#808080');
                                });
                                $k++;
                                foreach ($exp['shift'] as $ks => $shift) {
                                    if ($ks == 'pagi') {
                                        $sheet->setCellValue('C' . $k, 'Diterima pendapatan tgl ' . date('d', strtotime($exp['created_at'])) . ' ' . $this->monthIndonesia($datea[0]) . ' shift pagi sebesar');
                                        $sheet->setCellValue('D' . $k, $shift['debit']);
                                        $sheet->setCellValue('E' . $k, $shift['credit']);
                                    } elseif ($ks == 'siang') {
                                        $sheet->setCellValue('C' . $k, 'Diterima pendapatan tgl ' . date('d', strtotime($exp['created_at'])) . ' ' . $this->monthIndonesia($datea[0]) . ' shift siang sebesar');
                                        $sheet->setCellValue('D' . $k, $shift['debit']);
                                        $sheet->setCellValue('E' . $k, $shift['credit']);
                                    } else {
                                        $saldo = $saldo - $shift;
                                        $sheet->setCellValue('A' . $k, $i++);
                                        $sheet->setCellValue('B' . $k, date('d-m-Y', strtotime($exp['created_at'])));
                                        $sheet->setCellValue('C' . $k, 'Dipindahbukukan ke Kas Bendahara Pengeluaran tgl ' . date('d', strtotime($exp['created_at'])) . ' ' . $this->monthIndonesia($datea[0]) . ' sebesar');
                                        $sheet->setCellValue('D' . $k, 0);
                                        $sheet->setCellValue('E' . $k, $shift);
                                        $sheet->setCellValue('F' . $k, $saldo);
                                        $sheet->cell('A' . $k, function ($cells) {
                                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                            $cells->setBackground('#808080');
                                        });
                                        $sheet->cell('B' . $k, function ($cells) {
                                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                            $cells->setBackground('#808080');
                                        });
                                        $sheet->cell('C' . $k, function ($cells) {
                                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                            $cells->setBackground('#808080');
                                        });
                                        $sheet->cell('D' . $k, function ($cells) {
                                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                            $cells->setBackground('#808080');
                                        });
                                        $sheet->cell('E' . $k, function ($cells) {
                                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                            $cells->setBackground('#808080');
                                        });
                                        $sheet->cell('F' . $k, function ($cells) {
                                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                            $cells->setBackground('#808080');
                                        });
                                    }
                                    $sheet->cell('A' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('B' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('C' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('D' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('E' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('F' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $k++;
                                }
                            }

                            for ($j = $k; $j <= $k + 6; $j++) {
                                $sheet->cell('A' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                            }

                            $k = $k + 2;
                            $sheet->setCellValue('C' . $k, 'Jumlah Bulan Ini');
                            $sheet->setCellValue('D' . $k, $export['total']['debit']);
                            $sheet->setCellValue('E' . $k, $export['total']['credit']);
                            $sheet->setCellValue('F' . $k, $export['total']['debit'] - $export['total']['credit']);

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Jumlah s/d Bulan Lalu');
                            $sheet->setCellValue('D' . $k, $getSaldoAwal['debit']);
                            $sheet->setCellValue('E' . $k, $getSaldoAwal['credit']);
                            $sheet->setCellValue('F' . $k, $getSaldoAwal['debit'] - $getSaldoAwal['credit']);

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Jumlah s/d Bulan Ini');
                            $sheet->setCellValue('D' . $k, $getSaldoAwal['debit'] + $export['total']['debit']);
                            $sheet->setCellValue('E' . $k, $getSaldoAwal['credit'] + $export['total']['credit']);
                            $sheet->setCellValue('F' . $k, ($getSaldoAwal['debit'] + $export['total']['debit']) - ($getSaldoAwal['credit'] + $export['total']['credit']));

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Saldo');
                            $sheet->setCellValue('F' . $k, ($getSaldoAwal['debit'] + $export['total']['debit']) - ($getSaldoAwal['credit'] + $export['total']['credit']));

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':F' . $k);
                            $sheet->setCellValue('A' . $k, 'Pada hari ini BKU Penerimaan Pendapatan .configrs()->nama per tgl di tutup oleh kami dan didapat');

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Saldo Kas');
                            $sheet->setCellValue('E' . $k, ($getSaldoAwal['debit'] + $export['total']['debit']) - ($getSaldoAwal['credit'] + $export['total']['credit']));

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':B' . $k);
                            $sheet->setCellValue('A' . $k, 'Dengan rincian sebagai berikut');
                            $sheet->setCellValue('C' . $k, 'Kas Tunai');

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Saldo Bank rek BJB Cab. Kuningan no.');

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Saldo Bank rek BJB Cab. Kuningan no.');

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Jumlah');

                            $k = $k + 1;
                            $sheet->setCellValue('C' . $k, 'Selisih');

                            $k = $k + 2;
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Kuningan, ');

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Mengetahui,');

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Bendahara Penerimaan');

                            $k = $k + 7;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'dr. DEKI SAIFULLAH, MM.Kes.');
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'NANA SUDIANA, SE., MM');

                            $sheet->setAutoSize(true);
                        });
                    })->download('xlsx');
                }
            }
        }
    }

    public function lap_buku_besar_pengeluaran(Request $request)
    {
        $post = $request->except('_token');
        if (isset($post['excel'])) {
            $getAkun = AkunCOA::where('status', 1)->where('id', $post['excel'])->get()->toArray();
        } else {
            $getAkun = AkunCOA::where('status', 1)->where('code', '1110301')->get()->toArray();
        }

        $getData = [];
        $i = 0;
        foreach ($getAkun as $value) {
            $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id']);
            if (!empty($post)) {
                $getJournal = $getJournal->where('akutansi_journals.created_at', '>=', date('Y-m-d H:i', strtotime($post['tga'])))
                    ->where('akutansi_journals.created_at', '<=', date('Y-m-d H:i', strtotime($post['tgs'])));
            } else {
                $getJournal = $getJournal->where('akutansi_journals.created_at', date('Y-m-d'));
            }
            $getJournal = $getJournal->where('akutansi_journals.type', '!=', 'anggaran')->groupBy('akutansi_journals.id')->get()->toArray();
            if (!is_null($getJournal) && !empty($getJournal)) {
                $codeCoa = str_split($value['code']);
                $value['code'] = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];

                $getData['data'][$i]            = $value;
                $getData['data'][$i]['detail']  = $getJournal;
                $saldo          = 0;
                $totalDebit     = 0;
                $totalCredit    = 0;
                $totalSaldo     = 0;
                foreach ($getJournal as $kj => $journal) {
                    if ($value['saldo_normal'] == 'debit') {
                        $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                    } else {
                        $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                    }
                    $totalDebit     = $totalDebit + $journal['debit'];
                    $totalCredit    = $totalCredit + $journal['credit'];
                    $totalSaldo     = $saldo;

                    $getData['data'][$i]['detail'][$kj]['saldo'] = $saldo;
                    $getData['data'][$i]['total']['debit'] = (string) $totalDebit;
                    $getData['data'][$i]['total']['credit'] = (string) $totalCredit;
                    $getData['data'][$i]['total']['saldo'] = (string) $totalSaldo;

                    $export['detail'][$kj]  = $journal;
                    $export['detail'][$kj]['saldo'] = (string) $saldo;
                    $export['total']['debit'] = (string) $totalDebit;
                    $export['total']['credit'] = (string) $totalCredit;
                    $export['total']['saldo'] = (string) $totalSaldo;
                }
                $i++;
                $codeCoa = str_split($value['code']);
                if (isset($post['excel'])) {
                    Excel::load('laporan/Buku Besar Pengeluaran.xlsx', function ($doc) use ($post, $value, $export) {
                        $doc->sheet('Sheet1', function ($sheet) use ($post, $value, $export) {
                            $sheet->setCellValue('A3', "TAHUN ANGGARAN " . explode('-', $post['tga'])[2]);
                            $sheet->setCellValue('C5', ": " . $value['code']);
                            $sheet->setCellValue('C6', ": " . $value['nama']);
                            $k = 13;
                            foreach ($export['detail'] as $exp) {
                                $sheet->setCellValue('A' . $k, date('H:i d-m-Y', strtotime($exp['created_at'])));
                                $sheet->setCellValue('B' . $k, $exp['keterangan']);
                                $sheet->setCellValue('C' . $k, $exp['code']);
                                $sheet->setCellValue('D' . $k, $exp['debit']);
                                $sheet->setCellValue('E' . $k, $exp['credit']);
                                $sheet->setCellValue('F' . $k, $exp['saldo']);
                                $sheet->cell('A' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $k++;
                            }
                            $k = $k + 1;
                            $sheet->setCellValue('A' . $k, 'Total');
                            $sheet->setCellValue('D' . $k, $export['total']['debit']);
                            $sheet->setCellValue('E' . $k, $export['total']['credit']);
                            $sheet->setCellValue('F' . $k, $export['total']['saldo']);

                            $k = $k + 2;
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Kuningan, ');

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Mengetahui,');

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Bendahara Pengeluaran');

                            $k = $k + 7;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, '_________________________');
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, '_________________________');

                            $sheet->setAutoSize(true);
                        });
                    })->download('xlsx');
                }
            }
        }

        if (empty($getData)) {
            $getData['data'] = [];
        }
        // return $getData;
        return view('accounting::laporan.buku_besar.pengeluaran', $getData);
    }

    public function lap_buku_besar_pengeluaran_export(Request $request)
    {
        ini_set('memory_limit', '512M');
        $post = $request->except('_token');
        $datea = explode('-', $post['tgea']);
        $dates = explode('-', $post['tges']);

        $getAkun = AkunCOA::where('status', 1)->where('code', '1110301')->get()->toArray();

        $getData = [];
        $i = 0;
        foreach ($getAkun as $value) {
            if ($post['excel'] == 'monthly') {
                $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                    ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                    ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                    ->whereBetween('akutansi_journals.tanggal', [$datea[1] . '-' . $datea[0] . '-01', $dates[1] . '-' . $dates[0] . '-' . date('t', strtotime($dates[1] . '-' . $dates[0] . '-01'))])
                    ->where('akutansi_journals.type', '!=', 'anggaran')->groupBy('akutansi_journals.tanggal')->get()->toArray();

                if (!is_null($getJournal) && !empty($getJournal)) {
                    $codeCoa = str_split($value['code']);
                    $value['code'] = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];

                    $getData['data'][$i]            = $value;
                    $getData['data'][$i]['detail']  = $getJournal;
                    $saldo          = 0;
                    $totalDebit     = 0;
                    $totalCredit    = 0;
                    $totalSaldo     = 0;
                    foreach ($getJournal as $kj => $journal) {
                        $tanggal = explode(' ', $journal['tanggal']);
                        if ($value['saldo_normal'] == 'debit') {
                            $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                        } else {
                            $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                        }
                        $totalDebit     = $totalDebit + $journal['debit'];
                        $totalCredit    = $totalCredit + $journal['credit'];
                        $totalSaldo     = $saldo;

                        $getData['data'][$i]['detail'][$kj]['saldo'] = $saldo;
                        $getData['data'][$i]['total']['debit'] = (string) $totalDebit;
                        $getData['data'][$i]['total']['credit'] = (string) $totalCredit;
                        $getData['data'][$i]['total']['saldo'] = (string) $totalSaldo;

                        $export['detail'][$kj]  = $journal;

                        $export['detail'][$kj]['ket'] = 'Buku Besar Pengeluaran Tanggal ' . explode('-', $tanggal[0])[2];
                        $export['detail'][$kj]['saldo'] = (string) $saldo;
                        $export['total']['debit'] = (string) $totalDebit;
                        $export['total']['credit'] = (string) $totalCredit;
                        $export['total']['saldo'] = (string) $totalSaldo;
                    }
                    $i++;
                    Excel::load('laporan/Buku Besar Pengeluaran.xlsx', function ($doc) use ($post, $value, $export, $datea, $dates) {
                        $doc->sheet('Sheet1', function ($sheet) use ($post, $value, $export, $datea, $dates) {
                            $sheet->setCellValue('A3', "TAHUN ANGGARAN " . explode('-', $post['tgea'])[1] . " Periode " . $this->monthIndonesia($datea[0]) . " sampai " . $this->monthIndonesia($dates[0]));
                            $sheet->setCellValue('C5', ": " . $value['code']);
                            $sheet->setCellValue('C6', ": " . $value['nama']);
                            $k = 13;
                            foreach ($export['detail'] as $exp) {
                                $sheet->setCellValue('A' . $k, date('d-m-Y', strtotime($exp['tanggal'])));
                                $sheet->setCellValue('B' . $k, $exp['ket']);
                                $sheet->setCellValue('C' . $k, 'Pengeluaran-' . date('d.m.Y', strtotime($exp['tanggal'])));
                                $sheet->setCellValue('D' . $k, $exp['debit']);
                                $sheet->setCellValue('E' . $k, $exp['credit']);
                                $sheet->setCellValue('F' . $k, $exp['saldo']);
                                $sheet->cell('A' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $k++;
                            }
                            $k = $k + 1;
                            $sheet->setCellValue('A' . $k, 'Total');
                            $sheet->setCellValue('D' . $k, $export['total']['debit']);
                            $sheet->setCellValue('E' . $k, $export['total']['credit']);
                            $sheet->setCellValue('F' . $k, $export['total']['saldo']);

                            $k = $k + 2;
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Kuningan, ');

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Mengetahui,');

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, 'Bendahara Pengeluaran');

                            $k = $k + 7;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, '_________________________');
                            $sheet->mergeCells('D' . $k . ':F' . $k);
                            $sheet->setCellValue('D' . $k, '_________________________');

                            $sheet->setAutoSize(true);
                        });
                    })->download('xlsx');
                }
            } else {
                $getJournal = Journal::select('akutansi_journals.*', DB::raw('COALESCE(akutansi_journal_details.debit, 0) AS debit'), DB::raw('COALESCE(akutansi_journal_details.credit, 0) AS credit'))
                    ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                    ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                    ->whereBetween('akutansi_journals.tanggal', [$datea[1] . '-' . $datea[0] . '-01', $dates[1] . '-' . $dates[0] . '-' . date('t', strtotime($dates[1] . '-' . $dates[0] . '-01'))])
                    ->where('akutansi_journals.type', '!=', 'anggaran')->get()->toArray();

                $getSaldoAwal = Journal::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                    ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                    ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                    ->where('akutansi_journals.tanggal', '<=', $datea[1] . '-' . $datea[0] . '-01')
                    ->where('akutansi_journals.type', '!=', 'anggaran')->first()->toArray();

                $getPajak = Journal::select(
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_ppn), 0) AS pajak_ppn'),
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_pph22), 0) AS pajak_pph22'),
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_pph23), 0) AS pajak_pph23'),
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_pph21_4), 0) AS pajak_pph21_4'),
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_pph21_3), 0) AS pajak_pph21_3'),
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_daerah), 0) AS pajak_daerah'),
                    DB::raw('COALESCE(SUM(rka_realisasi.pajak_total), 0) AS pajak_total')
                )
                    ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                    ->join('rka_realisasi', 'akutansi_journals.id', 'rka_realisasi.id_journal')
                    ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['id'])
                    ->whereBetween('akutansi_journals.tanggal', [$datea[1] . '-' . $datea[0] . '-01', $dates[1] . '-' . $dates[0] . '-' . date('t', strtotime($dates[1] . '-' . $dates[0] . '-01'))])
                    ->where('akutansi_journals.type', '!=', 'anggaran')->first()->toArray();

                if (!is_null($getJournal) && !empty($getJournal)) {
                    $codeCoa = str_split($value['code']);
                    $value['code'] = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];

                    $saldo          = 0;
                    $totalDebit     = 0;
                    $totalCredit    = 0;
                    $totalSaldo     = 0;
                    foreach ($getJournal as $kj => $journal) {
                        $tanggal = explode(' ', $journal['tanggal']);
                        if ($value['saldo_normal'] == 'debit') {
                            $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                        } else {
                            $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                        }
                        $totalDebit     = $totalDebit + $journal['debit'];
                        $totalCredit    = $totalCredit + $journal['credit'];
                        $totalSaldo     = $saldo;

                        $keterangan = explode('-', $journal['keterangan']);
                        $export['detail'][$kj]  = $journal;
                        if (count($keterangan) > 1) {
                            $export['detail'][$kj]['kode_rka'] = explode('.', $keterangan[0]);
                        }
                        $export['detail'][$kj]['ket'] = end($keterangan);
                        $export['detail'][$kj]['saldo'] = (string) $saldo;

                        $export['total']['debit'] = (string) $totalDebit;
                        $export['total']['credit'] = (string) $totalCredit;
                        $export['total']['saldo'] = (string) $totalSaldo;
                    }
                    $i++;
                    Excel::load('laporan/BKU Pengeluaran.xlsx', function ($doc) use ($getPajak, $getSaldoAwal, $post, $export, $datea) {
                        $doc->sheet('Sheet1', function ($sheet) use ($getPajak, $getSaldoAwal, $post, $export, $datea) {
                            $sheet->setCellValue('A3', $this->monthIndonesia($datea[0]) . " " . explode('-', $post['tgea'])[1]);

                            $sheet->setCellValue('A12', 1);
                            $sheet->setCellValue('H12', 'Saldo Awal Bulan Lalu');
                            $sheet->setCellValue('I12', $getSaldoAwal['debit']);
                            $sheet->setCellValue('J12', $getSaldoAwal['credit']);
                            $sheet->setCellValue('K12', $getSaldoAwal['debit'] - $getSaldoAwal['credit']);
                            $sheet->cell('A12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('B12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('C12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('D12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('E12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('F12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('G12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('H12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('I12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('J12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('K12', function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });

                            $k = 13;
                            $i = 2;
                            $saldo = $getSaldoAwal['debit'] - $getSaldoAwal['credit'];
                            foreach ($export['detail'] as $exp) {
                                $saldo = $saldo + ($exp['debit'] - $exp['credit']);
                                $sheet->setCellValue('A' . $k, $i++);
                                $sheet->setCellValue('B' . $k, date('d-m-Y', strtotime($exp['created_at'])));
                                if (isset($exp['kode_rka'])) {
                                    $sheet->setCellValue('C' . $k, $exp['kode_rka'][7]);
                                    $sheet->setCellValue('D' . $k, $exp['kode_rka'][8]);
                                    $sheet->setCellValue('E' . $k, $exp['kode_rka'][9]);
                                    $sheet->setCellValue('F' . $k, $exp['kode_rka'][10]);
                                    $sheet->setCellValue('G' . $k, $exp['kode_rka'][11]);
                                }
                                $sheet->setCellValue('H' . $k, $exp['ket']);
                                $sheet->setCellValue('I' . $k, $exp['debit']);
                                $sheet->setCellValue('J' . $k, $exp['credit']);
                                $sheet->setCellValue('K' . $k, $saldo);
                                $sheet->cell('A' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('G' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('H' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('I' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('J' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('K' . $k, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $k++;
                            }

                            for ($j = $k; $j <= $k + 13; $j++) {
                                $sheet->cell('A' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('B' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('C' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('D' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('E' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('F' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('G' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('H' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('I' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('J' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                                $sheet->cell('K' . $j, function ($cells) {
                                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                            }

                            $k = $k + 2;
                            $sheet->setCellValue('H' . $k, 'PPN');
                            $sheet->setCellValue('J' . $k, $getPajak['pajak_ppn']);
                            $sheet->setCellValue('K' . $k, $saldo - $getPajak['pajak_ppn']);

                            $k = $k + 1;
                            $saldo = $saldo - $getPajak['pajak_ppn'];
                            $sheet->setCellValue('H' . $k, 'PPh. 22');
                            $sheet->setCellValue('J' . $k, $getPajak['pajak_pph22']);
                            $sheet->setCellValue('K' . $k, $saldo - $getPajak['pajak_pph22']);

                            $k = $k + 1;
                            $saldo = $saldo - $getPajak['pajak_pph22'];
                            $sheet->setCellValue('H' . $k, 'PPh. 21');
                            $sheet->setCellValue('J' . $k, $getPajak['pajak_pph21_3'] + $getPajak['pajak_pph21_4']);
                            $sheet->setCellValue('K' . $k, $saldo - ($getPajak['pajak_pph21_3'] + $getPajak['pajak_pph21_4']));

                            $k = $k + 1;
                            $saldo = $saldo - ($getPajak['pajak_pph21_3'] + $getPajak['pajak_pph21_4']);
                            $sheet->setCellValue('H' . $k, 'PPh. 23');
                            $sheet->setCellValue('J' . $k, $getPajak['pajak_pph23']);
                            $sheet->setCellValue('K' . $k, $saldo - $getPajak['pajak_pph23']);

                            $k = $k + 1;
                            $saldo = $saldo - $getPajak['pajak_pph23'];
                            $sheet->setCellValue('H' . $k, 'Pajak Daerah');
                            $sheet->setCellValue('J' . $k, $getPajak['pajak_daerah']);
                            $sheet->setCellValue('K' . $k, $saldo - $getPajak['pajak_daerah']);

                            $k = $k + 1;
                            $sheet->setCellValue('K' . $k, $saldo - $getPajak['pajak_daerah']);

                            $k = $k + 2;
                            $sheet->setCellValue('H' . $k, 'Jumlah Bulan Ini');
                            $sheet->setCellValue('I' . $k, $export['total']['debit']);
                            $sheet->setCellValue('J' . $k, $export['total']['credit'] + $getPajak['pajak_total']);

                            $k = $k + 1;
                            $sheet->setCellValue('H' . $k, 'Jumlah s/d Bulan Lalu');
                            $sheet->setCellValue('I' . $k, $getSaldoAwal['debit']);
                            $sheet->setCellValue('J' . $k, $getSaldoAwal['credit']);

                            $k = $k + 1;
                            $sheet->setCellValue('H' . $k, 'Jumlah s/d Bulan Ini');
                            $sheet->setCellValue('I' . $k, $getSaldoAwal['debit'] + $export['total']['debit']);
                            $sheet->setCellValue('J' . $k, $getSaldoAwal['credit'] + ($export['total']['credit'] + $getPajak['pajak_total']));

                            $k = $k + 1;
                            $sheet->setCellValue('H' . $k, 'Jumlah Semua');
                            $sheet->setCellValue('I' . $k, $getSaldoAwal['debit'] + $export['total']['debit']);
                            $sheet->setCellValue('J' . $k, $getSaldoAwal['credit'] + ($export['total']['credit'] + $getPajak['pajak_total']));

                            $k = $k + 1;
                            $sheet->setCellValue('H' . $k, 'Saldo');
                            $sheet->setCellValue('J' . $k, ($getSaldoAwal['debit'] - ($getSaldoAwal['credit'] + $getPajak['pajak_total'])) + $export['total']['saldo']);

                            $k = $k + 2;
                            $sheet->mergeCells('I' . $k . ':K' . $k);
                            $sheet->setCellValue('I' . $k, 'Kuningan, ');

                            $k = $k + 2;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Mengetahui,');

                            $k = $k + 1;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                            $sheet->mergeCells('I' . $k . ':K' . $k);
                            $sheet->setCellValue('I' . $k, 'Bendahara Pengeluaran');

                            $k = $k + 7;
                            $sheet->mergeCells('A' . $k . ':C' . $k);
                            $sheet->setCellValue('A' . $k, '_________________________');
                            $sheet->mergeCells('I' . $k . ':K' . $k);
                            $sheet->setCellValue('I' . $k, '_________________________');
                        });
                    })->download('xlsx');
                }
            }
        }

        if (empty($getData)) {
            $getData['data'] = [];
        }
        // return $getData;
        return view('accounting::laporan.buku_besar.pengeluaran', $getData);
    }

    public function lap_ra(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $post['level'] = '2';
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;
        $data['level']  = $post['level'];
        $i = 0;

        if (isset($post['excel'])) {
            Excel::load('laporan/LRA SAP.xlsx', function ($doc) use ($data) {
                $doc->sheet('Sheet1', function ($sheet) use ($data) {
                    $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                    $sheet->setCellValue('C6', 'Anggaran ' . $data['tha']);
                    $sheet->setCellValue('D6', 'Realisasi ' . $data['tha']);
                    $sheet->setCellValue('F6', 'Realisasi ' . $data['ths']);

                    $pJL = self::getPerhitunganLRA($data['tha'], 5, '4141801');
                    $sheet->setCellValue('C8', $pJL['anggaran']);
                    $sheet->setCellValue('D8', $pJL['realisasi']);
                    $sheet->setCellValue('E8', ($pJL['anggaran'] == 0) ? 0 : ($pJL['realisasi'] / $pJL['anggaran']) * 100);
                    $sheet->setCellValue('F8', $pJL['realisasi_sebelum']);
                    // $pJLE = self::getPerhitunganLRA($data['tha'], 5, '4141801');
                    // $sheet->setCellValue('C9', $pJLE['anggaran']);
                    // $sheet->setCellValue('D9', $pJLE['realisasi']);
                    // $sheet->setCellValue('E9', ($pJLE['anggaran'] == 0) ? 0 : ($pJLE['realisasi'] / $pJLE['anggaran']) * 100);
                    // $sheet->setCellValue('F9', $pJLE['realisasi_sebelum']);
                    $pHK = self::getPerhitunganLRA($data['tha'], 5, '4141803');
                    $sheet->setCellValue('C10', $pHK['anggaran']);
                    $sheet->setCellValue('D10', $pHK['realisasi']);
                    $sheet->setCellValue('E10', ($pHK['anggaran'] == 0) ? 0 : ($pHK['realisasi'] / $pHK['anggaran']) * 100);
                    $sheet->setCellValue('F10', $pHK['realisasi_sebelum']);
                    $pHibah = self::getPerhitunganLRA($data['tha'], 5, '4141802');
                    $sheet->setCellValue('C11', $pHibah['anggaran']);
                    $sheet->setCellValue('D11', $pHibah['realisasi']);
                    $sheet->setCellValue('E11', ($pHibah['anggaran'] == 0) ? 0 : ($pHibah['realisasi'] / $pHibah['anggaran']) * 100);
                    $sheet->setCellValue('F11', $pHibah['realisasi_sebelum']);
                    // $pULain = self::getPerhitunganLRA($data['tha'], 5, '4141803');
                    // $sheet->setCellValue('C12', $pULain['anggaran']);
                    // $sheet->setCellValue('D12', $pULain['realisasi']);
                    // $sheet->setCellValue('E12', ($pULain['anggaran'] == 0) ? 0 : ($pULain['realisasi'] / $pULain['anggaran']) * 100);
                    // $sheet->setCellValue('F12', $pULain['realisasi_sebelum']);

                    $tPen = [
                        'anggaran'          => $pJL['anggaran'] + $pHK['anggaran'] + $pHibah['anggaran'],
                        'realisasi'         => $pJL['realisasi'] + $pHK['realisasi'] + $pHibah['realisasi'],
                        'realisasi_sebelum' => $pJL['realisasi_sebelum'] + $pHK['realisasi_sebelum'] + $pHibah['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C13', $tPen['anggaran']);
                    $sheet->setCellValue('D13', $tPen['realisasi']);
                    $sheet->setCellValue('E13', ($tPen['anggaran'] == 0) ? 0 : ($tPen['realisasi'] / $tPen['anggaran']) * 100);
                    $sheet->setCellValue('F13', $tPen['realisasi_sebelum']);

                    $bPegawai = self::getPerhitunganLRA($data['tha'], 3, '511');
                    $sheet->setCellValue('C17', $bPegawai['anggaran']);
                    $sheet->setCellValue('D17', $bPegawai['realisasi']);
                    $sheet->setCellValue('E17', ($bPegawai['anggaran'] == 0) ? 0 : ($bPegawai['realisasi'] / $bPegawai['anggaran']) * 100);
                    $sheet->setCellValue('F17', $bPegawai['realisasi_sebelum']);
                    $bBarang = self::getPerhitunganLRA($data['tha'], 3, '512');
                    $sheet->setCellValue('C18', $bBarang['anggaran']);
                    $sheet->setCellValue('D18', $bBarang['realisasi']);
                    $sheet->setCellValue('E18', ($bBarang['anggaran'] == 0) ? 0 : ($bBarang['realisasi'] / $bBarang['anggaran']) * 100);
                    $sheet->setCellValue('F18', $bBarang['realisasi_sebelum']);
                    $bunga = self::getPerhitunganLRA($data['tha'], 3, '513');
                    $sheet->setCellValue('C19', $bunga['anggaran']);
                    $sheet->setCellValue('D19', $bunga['realisasi']);
                    $sheet->setCellValue('E19', ($bunga['anggaran'] == 0) ? 0 : ($bunga['realisasi'] / $bunga['anggaran']) * 100);
                    $sheet->setCellValue('F19', $bunga['realisasi_sebelum']);
                    $bLain = self::getPerhitunganLRA($data['tha'], 3, '531');
                    $sheet->setCellValue('C20', $bLain['anggaran']);
                    $sheet->setCellValue('D20', $bLain['realisasi']);
                    $sheet->setCellValue('E20', ($bLain['anggaran'] == 0) ? 0 : ($bLain['realisasi'] / $bLain['anggaran']) * 100);
                    $sheet->setCellValue('F20', $bLain['realisasi_sebelum']);

                    $tBeban = [
                        'anggaran'          => $bPegawai['anggaran'] + $bBarang['anggaran'] + $bunga['anggaran'] + $bLain['anggaran'],
                        'realisasi'         => $bPegawai['realisasi'] + $bBarang['realisasi'] + $bunga['realisasi'] + $bLain['realisasi'],
                        'realisasi_sebelum' => $bPegawai['realisasi_sebelum'] + $bBarang['realisasi_sebelum'] + $bunga['realisasi_sebelum'] + $bLain['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C21', $tBeban['anggaran']);
                    $sheet->setCellValue('D21', $tBeban['realisasi']);
                    $sheet->setCellValue('E21', ($tBeban['anggaran'] == 0) ? 0 : ($tBeban['realisasi'] / $tBeban['anggaran']) * 100);
                    $sheet->setCellValue('F21', $tBeban['realisasi_sebelum']);

                    $bTanah = self::getPerhitunganLRA($data['tha'], 3, '521');
                    $sheet->setCellValue('C24', $bTanah['anggaran']);
                    $sheet->setCellValue('D24', $bTanah['realisasi']);
                    $sheet->setCellValue('E24', ($bTanah['anggaran'] == 0) ? 0 : ($bTanah['realisasi'] / $bTanah['anggaran']) * 100);
                    $sheet->setCellValue('F24', $bTanah['realisasi_sebelum']);
                    $bPM = self::getPerhitunganLRA($data['tha'], 3, '522');
                    $sheet->setCellValue('C25', $bPM['anggaran']);
                    $sheet->setCellValue('D25', $bPM['realisasi']);
                    $sheet->setCellValue('E25', ($bPM['anggaran'] == 0) ? 0 : ($bPM['realisasi'] / $bPM['anggaran']) * 100);
                    $sheet->setCellValue('F25', $bPM['realisasi_sebelum']);
                    $bGB = self::getPerhitunganLRA($data['tha'], 3, '523');
                    $sheet->setCellValue('C26', $bGB['anggaran']);
                    $sheet->setCellValue('D26', $bGB['realisasi']);
                    $sheet->setCellValue('E26', ($bGB['anggaran'] == 0) ? 0 : ($bGB['realisasi'] / $bGB['anggaran']) * 100);
                    $sheet->setCellValue('F26', $bGB['realisasi_sebelum']);
                    $bJIJ = self::getPerhitunganLRA($data['tha'], 3, '524');
                    $sheet->setCellValue('C27', $bJIJ['anggaran']);
                    $sheet->setCellValue('D27', $bJIJ['realisasi']);
                    $sheet->setCellValue('E27', ($bJIJ['anggaran'] == 0) ? 0 : ($bJIJ['realisasi'] / $bJIJ['anggaran']) * 100);
                    $sheet->setCellValue('F27', $bJIJ['realisasi_sebelum']);
                    $bATL = self::getPerhitunganLRA($data['tha'], 3, '525');
                    $sheet->setCellValue('C28', $bATL['anggaran']);
                    $sheet->setCellValue('D28', $bATL['realisasi']);
                    $sheet->setCellValue('E28', ($bATL['anggaran'] == 0) ? 0 : ($bATL['realisasi'] / $bATL['anggaran']) * 100);
                    $sheet->setCellValue('F28', $bATL['realisasi_sebelum']);
                    // $bAL = self::getPerhitunganLRA($data['tha'], 3, '531');
                    // $sheet->setCellValue('C29', $bAL['anggaran']);
                    // $sheet->setCellValue('D29', $bAL['realisasi']);
                    // $sheet->setCellValue('E29', ($bAL['anggaran'] == 0) ? 0 : ($bAL['realisasi'] / $bAL['anggaran']) * 100);
                    // $sheet->setCellValue('F29', $bAL['realisasi_sebelum']);

                    $tBM = [
                        'anggaran'          => $bTanah['anggaran'] + $bPM['anggaran'] + $bGB['anggaran'] + $bJIJ['anggaran'] + $bATL['anggaran'],
                        'realisasi'         => $bTanah['realisasi'] + $bPM['realisasi'] + $bGB['realisasi'] + $bJIJ['realisasi'] + $bATL['realisasi'],
                        'realisasi_sebelum' => $bTanah['realisasi_sebelum'] + $bPM['realisasi_sebelum'] + $bGB['realisasi_sebelum'] + $bJIJ['realisasi_sebelum'] + $bATL['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C30', $tBM['anggaran']);
                    $sheet->setCellValue('D30', $tBM['realisasi']);
                    $sheet->setCellValue('E30', ($tBM['anggaran'] == 0) ? 0 : ($tBM['realisasi'] / $tBM['anggaran']) * 100);
                    $sheet->setCellValue('F30', $tBM['realisasi_sebelum']);

                    $tBelanja = [
                        'anggaran'          => $tBeban['anggaran'] + $tBM['anggaran'],
                        'realisasi'         => $tBeban['realisasi'] + $tBM['realisasi'],
                        'realisasi_sebelum' => $tBeban['realisasi_sebelum'] + $tBM['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C31', $tBelanja['anggaran']);
                    $sheet->setCellValue('D31', $tBelanja['realisasi']);
                    $sheet->setCellValue('E31', ($tBeban['anggaran'] == 0) ? 0 : ($tBeban['realisasi'] / $tBeban['anggaran']) * 100);
                    $sheet->setCellValue('F31', $tBelanja['realisasi_sebelum']);

                    $tSD = [
                        'anggaran'          => $tPen['anggaran'] + $tBelanja['anggaran'],
                        'realisasi'         => $tPen['realisasi'] + $tBelanja['realisasi'],
                        'realisasi_sebelum' => $tPen['realisasi_sebelum'] + $tBelanja['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C32', $tSD['anggaran']);
                    $sheet->setCellValue('D32', $tSD['realisasi']);
                    $sheet->setCellValue('E32', ($tSD['anggaran'] == 0) ? 0 : ($tSD['realisasi'] / $tSD['anggaran']) * 100);
                    $sheet->setCellValue('F32', $tSD['realisasi_sebelum']);

                    $pPinjaman = self::getPerhitunganLRA($data['tha'], 3, '714');
                    $sheet->setCellValue('C37', $pPinjaman['anggaran']);
                    $sheet->setCellValue('D37', $pPinjaman['realisasi']);
                    $sheet->setCellValue('E37', ($pPinjaman['anggaran'] == 0) ? 0 : ($pPinjaman['realisasi'] / $pPinjaman['anggaran']) * 100);
                    $sheet->setCellValue('F37', $pPinjaman['realisasi_sebelum']);
                    // $pDivalasi = self::getPerhitunganLRA($data['tha'], 3, '522');
                    // $sheet->setCellValue('C38', $pDivalasi['anggaran']);
                    // $sheet->setCellValue('D38', $pDivalasi['realisasi']);
                    // $sheet->setCellValue('E38', ($pDivalasi['anggaran'] == 0) ? 0 : ($pDivalasi['realisasi'] / $pDivalasi['anggaran']) * 100);
                    // $sheet->setCellValue('F38', $pDivalasi['realisasi_sebelum']);
                    $pKembali = self::getPerhitunganLRA($data['tha'], 3, '715');
                    $sheet->setCellValue('C39', $pKembali['anggaran']);
                    $sheet->setCellValue('D39', $pKembali['realisasi']);
                    $sheet->setCellValue('E39', ($pKembali['anggaran'] == 0) ? 0 : ($pKembali['realisasi'] / $pKembali['anggaran']) * 100);
                    $sheet->setCellValue('F39', $pKembali['realisasi_sebelum']);

                    $tPDN = [
                        'anggaran'          => $pPinjaman['anggaran'] + $pKembali['anggaran'],
                        'realisasi'         => $pPinjaman['realisasi'] + $pKembali['realisasi'],
                        'realisasi_sebelum' => $pPinjaman['realisasi_sebelum'] + $pKembali['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C40', $tPDN['anggaran']);
                    $sheet->setCellValue('D40', $tPDN['realisasi']);
                    $sheet->setCellValue('E40', ($tPDN['anggaran'] == 0) ? 0 : ($tPDN['realisasi'] / $tPDN['anggaran']) * 100);
                    $sheet->setCellValue('F40', $tPDN['realisasi_sebelum']);
                    $sheet->setCellValue('C41', $tPDN['anggaran']);
                    $sheet->setCellValue('D41', $tPDN['realisasi']);
                    $sheet->setCellValue('E41', ($tPDN['anggaran'] == 0) ? 0 : ($tPDN['realisasi'] / $tPDN['anggaran']) * 100);
                    $sheet->setCellValue('F41', $tPDN['realisasi_sebelum']);

                    $pPP = self::getPerhitunganLRA($data['tha'], 3, '723');
                    $sheet->setCellValue('C45', $pPP['anggaran']);
                    $sheet->setCellValue('D45', $pPP['realisasi']);
                    $sheet->setCellValue('E45', ($pPP['anggaran'] == 0) ? 0 : ($pPP['realisasi'] / $pPP['anggaran']) * 100);
                    $sheet->setCellValue('F45', $pPP['realisasi_sebelum']);
                    $pPModal = self::getPerhitunganLRA($data['tha'], 3, '722');
                    $sheet->setCellValue('C46', $pPModal['anggaran']);
                    $sheet->setCellValue('D46', $pPModal['realisasi']);
                    $sheet->setCellValue('E46', ($pPModal['anggaran'] == 0) ? 0 : ($pPModal['realisasi'] / $pPModal['anggaran']) * 100);
                    $sheet->setCellValue('F46', $pPModal['realisasi_sebelum']);
                    $pPKPL = self::getPerhitunganLRA($data['tha'], 3, '726');
                    $sheet->setCellValue('C47', $pPKPL['anggaran']);
                    $sheet->setCellValue('D47', $pPKPL['realisasi']);
                    $sheet->setCellValue('E47', ($pPKPL['anggaran'] == 0) ? 0 : ($pPKPL['realisasi'] / $pPKPL['anggaran']) * 100);
                    $sheet->setCellValue('F47', $pPKPL['realisasi_sebelum']);

                    $tPPDL = [
                        'anggaran'          => $pPP['anggaran'] + $pPModal['anggaran'] + $pPKPL['anggaran'],
                        'realisasi'         => $pPP['realisasi'] + $pPModal['realisasi'] + $pPKPL['realisasi'],
                        'realisasi_sebelum' => $pPP['realisasi_sebelum'] + $pPModal['realisasi_sebelum'] + $pPKPL['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C48', $tPPDL['anggaran']);
                    $sheet->setCellValue('D48', $tPPDL['realisasi']);
                    $sheet->setCellValue('E48', ($tPPDL['anggaran'] == 0) ? 0 : ($tPPDL['realisasi'] / $tPPDL['anggaran']) * 100);
                    $sheet->setCellValue('F48', $tPPDL['realisasi_sebelum']);
                    $sheet->setCellValue('C49', $tPPDL['anggaran']);
                    $sheet->setCellValue('D49', $tPPDL['realisasi']);
                    $sheet->setCellValue('E49', ($tPPDL['anggaran'] == 0) ? 0 : ($tPPDL['realisasi'] / $tPPDL['anggaran']) * 100);
                    $sheet->setCellValue('F49', $tPPDL['realisasi_sebelum']);

                    $neto = [
                        'anggaran'          => $tPDN['anggaran'] + $tPPDL['anggaran'],
                        'realisasi'         => $tPDN['realisasi'] + $tPPDL['realisasi'],
                        'realisasi_sebelum' => $tPDN['realisasi_sebelum'] + $tPPDL['realisasi_sebelum'],
                    ];
                    $sheet->setCellValue('C50', $neto['anggaran']);
                    $sheet->setCellValue('D50', $neto['realisasi']);
                    $sheet->setCellValue('E50', ($neto['anggaran'] == 0) ? 0 : ($neto['realisasi'] / $neto['anggaran']) * 100);
                    $sheet->setCellValue('F50', $neto['realisasi_sebelum']);
                });
            })->download('xlsx');
        } else {
            $sumPendapatan = [
                'anggaran'              => 0,
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatan = AkunType::with('sub_type.class.sub_class.coa')->where('code', 4)->get()->toArray();
            foreach ($pendapatan as $pen) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen['code']);

                $data['data'][$i]['code']               = $this->reCode($pen['code']);
                $data['data'][$i]['nama']               = $pen['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['anggaran']           = '';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['percent']            = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen['sub_type'] as $pen_sub) {
                        $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_sub['code']);

                        $data['data'][$i]['code']               = $this->reCode($pen_sub['code']);
                        $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_sub['nama'];
                        if ($post['level'] >= 3) {
                            $data['data'][$i]['tag']                = 'b0';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            foreach ($pen_sub['class'] as $class) {
                                $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                if ($getPerhitungan3['anggaran'] != 0 || $getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                    $data['data'][$i]['code']               = $this->reCode($class['code']);
                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                    if ($post['level'] >= 4) {
                                        $data['data'][$i]['tag']                = 'b0';
                                        $data['data'][$i]['anggaran']           = '';
                                        $data['data'][$i]['realisasi']          = '';
                                        $data['data'][$i]['percent']            = '';
                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                        $i++;

                                        foreach ($class['sub_class'] as $sub_class) {
                                            $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                            if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                if ($post['level'] >= 5) {
                                                    $data['data'][$i]['tag']                = 'b0';
                                                    $data['data'][$i]['anggaran']           = '';
                                                    $data['data'][$i]['realisasi']          = '';
                                                    $data['data'][$i]['percent']            = '';
                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                    $i++;

                                                    foreach ($sub_class['coa'] as $coa) {
                                                        $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                        if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                            $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                            if ($post['level'] >= 6) {
                                                                $data['data'][$i]['tag']                = 'b0';
                                                                $data['data'][$i]['anggaran']           = '';
                                                                $data['data'][$i]['realisasi']          = '';
                                                                $data['data'][$i]['percent']            = '';
                                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                                $i++;
                                                            } else {
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan5['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan5['anggaran'] == 0) ? 0 : ($getPerhitungan5['realisasi'] / $getPerhitungan5['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                $i++;
                                                            }

                                                            if (end($sub_class['coa']) == $coa) {
                                                                $data['data'][$i]['code']               = '';
                                                                $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                    $i++;
                                                }

                                                if (end($class['sub_class']) == $sub_class) {
                                                    $data['data'][$i]['code']               = '';
                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                    $i++;
                                                }
                                            }
                                        }
                                    } else {
                                        $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                        $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                                if (end($pen_sub['class']) == $class) {
                                    $data['data'][$i]['code']               = '';
                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_sub['nama'];
                                    $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                                    $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                    $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                    $i++;
                                }
                            }
                        } else {
                            $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                            $i++;
                        }

                        if (end($pen['sub_type']) == $pen_sub) {
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = 'JUMLAH ' . $pen['nama'];
                            $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                            $i++;

                            $sumPendapatan['anggaran']          = $sumPendapatan['anggaran'] + $getPerhitungan1['anggaran'];
                            $sumPendapatan['realisasi']         = $sumPendapatan['realisasi'] + $getPerhitungan1['realisasi'];
                            $sumPendapatan['realisasi_sebelum'] = $sumPendapatan['realisasi_sebelum'] + $getPerhitungan1['realisasi_sebelum'];
                        }
                    }
                } else {
                    $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                    $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                    $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                    $i++;

                    $sumPendapatan['anggaran']          = $getPerhitungan1['anggaran'];
                    $sumPendapatan['realisasi']         = $getPerhitungan1['realisasi'];
                    $sumPendapatan['realisasi_sebelum'] = $getPerhitungan1['realisasi_sebelum'];
                }
            }

            $sumBelanja = [
                'anggaran'              => 0,
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $belanja = AkunType::with('sub_type.class.sub_class.coa')->where('code', 5)->get()->toArray();
            foreach ($belanja as $bel) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $bel['code']);

                $data['data'][$i]['code']               = $this->reCode($bel['code']);
                $data['data'][$i]['nama']               = $bel['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['anggaran']           = '';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['percent']            = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($bel['sub_type'] as $bel_sub) {
                        $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $bel_sub['code']);

                        $data['data'][$i]['code']               = $this->reCode($bel_sub['code']);
                        $data['data'][$i]['nama']               = '&emsp;&emsp;' . $bel_sub['nama'];
                        if ($post['level'] >= 3) {
                            $data['data'][$i]['tag']                = 'b0';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            foreach ($bel_sub['class'] as $class) {
                                $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                if ($getPerhitungan3['anggaran'] != 0 || $getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                    $data['data'][$i]['code']               = $this->reCode($class['code']);
                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                    if ($post['level'] >= 4) {
                                        $data['data'][$i]['tag']                = 'b0';
                                        $data['data'][$i]['anggaran']           = '';
                                        $data['data'][$i]['realisasi']          = '';
                                        $data['data'][$i]['percent']            = '';
                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                        $i++;

                                        foreach ($class['sub_class'] as $sub_class) {
                                            $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                            if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                if ($post['level'] >= 5) {
                                                    $data['data'][$i]['tag']                = 'b0';
                                                    $data['data'][$i]['anggaran']           = '';
                                                    $data['data'][$i]['realisasi']          = '';
                                                    $data['data'][$i]['percent']            = '';
                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                    $i++;

                                                    foreach ($sub_class['coa'] as $coa) {
                                                        $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                        if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                            $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                            if ($post['level'] >= 6) {
                                                                $data['data'][$i]['tag']                = 'b0';
                                                                $data['data'][$i]['anggaran']           = '';
                                                                $data['data'][$i]['realisasi']          = '';
                                                                $data['data'][$i]['percent']            = '';
                                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                                $i++;
                                                            } else {
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan5['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan5['anggaran'] == 0) ? 0 : ($getPerhitungan5['realisasi'] / $getPerhitungan5['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                $i++;
                                                            }

                                                            if (end($sub_class['coa']) == $coa) {
                                                                $data['data'][$i]['code']               = '';
                                                                $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                    $i++;
                                                }

                                                if (end($class['sub_class']) == $sub_class) {
                                                    $data['data'][$i]['code']               = '';
                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                    $i++;
                                                }
                                            }
                                        }
                                    } else {
                                        $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                        $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                                if (end($bel_sub['class']) == $class) {
                                    $data['data'][$i]['code']               = '';
                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $bel_sub['nama'];
                                    $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                                    $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                    $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                    $i++;
                                }
                            }
                        } else {
                            $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                            $i++;
                        }

                        if (end($bel['sub_type']) == $bel_sub) {
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = 'JUMLAH ' . $bel['nama'];
                            $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                            $i++;

                            $sumBelanja['anggaran']          = $sumBelanja['anggaran'] + $getPerhitungan1['anggaran'];
                            $sumBelanja['realisasi']         = $sumBelanja['realisasi'] + $getPerhitungan1['realisasi'];
                            $sumBelanja['realisasi_sebelum'] = $sumBelanja['realisasi_sebelum'] + $getPerhitungan1['realisasi_sebelum'];
                        }
                    }
                } else {
                    $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                    $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                    $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                    $i++;

                    $sumBelanja['anggaran']          = $getPerhitungan1['anggaran'];
                    $sumBelanja['realisasi']         = $getPerhitungan1['realisasi'];
                    $sumBelanja['realisasi_sebelum'] = $getPerhitungan1['realisasi_sebelum'];
                }
            }

            $surplusDefisit['anggaran']             = $sumPendapatan['anggaran'] - $sumBelanja['anggaran'];
            $surplusDefisit['realisasi']            = $sumPendapatan['realisasi'] - $sumBelanja['realisasi'];
            $surplusDefisit['realisasi_sebelum']    = $sumPendapatan['realisasi_sebelum'] - $sumBelanja['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT';
            $data['data'][$i]['anggaran']           = $surplusDefisit['anggaran'];
            $data['data'][$i]['realisasi']          = $surplusDefisit['realisasi'];
            $data['data'][$i]['percent']            = ($surplusDefisit['anggaran'] == 0) ? 0 : ($surplusDefisit['realisasi'] / $surplusDefisit['anggaran']) * 100;
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisit['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $sumPembiayaan = [
                'anggaran'              => 0,
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pembiayaan = AkunType::with('sub_type.class.sub_class.coa')->where('code', 7)->get()->toArray();
            foreach ($pembiayaan as $pem) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pem['code']);

                $data['data'][$i]['code']               = $this->reCode($pem['code']);
                $data['data'][$i]['nama']               = $pem['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['anggaran']           = '';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['percent']            = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    $sumPenerimaanPembiayaan = [
                        'anggaran'              => 0,
                        'realisasi'             => 0,
                        'realisasi_sebelum'     => 0
                    ];
                    $sumPengeluaranPembiayaan = [
                        'anggaran'              => 0,
                        'realisasi'             => 0,
                        'realisasi_sebelum'     => 0
                    ];
                    foreach ($pem['sub_type'] as $pem_sub) {
                        $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pem_sub['code']);

                        $data['data'][$i]['code']               = $this->reCode($pem_sub['code']);
                        $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pem_sub['nama'];
                        if ($post['level'] >= 3) {
                            $data['data'][$i]['tag']                = 'b0';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            foreach ($pem_sub['class'] as $class) {
                                $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                if ($getPerhitungan3['anggaran'] != 0 || $getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                    $data['data'][$i]['code']               = $this->reCode($class['code']);
                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                    if ($post['level'] >= 4) {
                                        $data['data'][$i]['tag']                = 'b0';
                                        $data['data'][$i]['anggaran']           = '';
                                        $data['data'][$i]['realisasi']          = '';
                                        $data['data'][$i]['percent']            = '';
                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                        $i++;

                                        foreach ($class['sub_class'] as $sub_class) {
                                            $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                            if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                if ($post['level'] >= 5) {
                                                    $data['data'][$i]['tag']                = 'b0';
                                                    $data['data'][$i]['anggaran']           = '';
                                                    $data['data'][$i]['realisasi']          = '';
                                                    $data['data'][$i]['percent']            = '';
                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                    $i++;

                                                    foreach ($sub_class['coa'] as $coa) {
                                                        $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                        if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                            $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                            if ($post['level'] >= 6) {
                                                                $data['data'][$i]['tag']                = 'b0';
                                                                $data['data'][$i]['anggaran']           = '';
                                                                $data['data'][$i]['realisasi']          = '';
                                                                $data['data'][$i]['percent']            = '';
                                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                                $i++;
                                                            } else {
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan5['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan5['anggaran'] == 0) ? 0 : ($getPerhitungan5['realisasi'] / $getPerhitungan5['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                $i++;
                                                            }

                                                            if (end($sub_class['coa']) == $coa) {
                                                                $data['data'][$i]['code']               = '';
                                                                $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                    $i++;
                                                }

                                                if (end($class['sub_class']) == $sub_class) {
                                                    $data['data'][$i]['code']               = '';
                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                    $i++;
                                                }
                                            }
                                        }
                                    } else {
                                        $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                        $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                                if (end($pem_sub['class']) == $class) {
                                    $data['data'][$i]['code']               = '';
                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $pem_sub['nama'];
                                    $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                                    $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                    $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                    $i++;
                                }
                            }
                        } else {
                            $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                            $i++;
                        }

                        if (end($pem['sub_type']) == $pem_sub) {
                            if ($pem_sub['code'] == 71) {
                                $sumPenerimaanPembiayaan['anggaran']            = $sumPenerimaanPembiayaan['anggaran'] + $getPerhitungan2['anggaran'];
                                $sumPenerimaanPembiayaan['realisasi']           = $sumPenerimaanPembiayaan['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPenerimaanPembiayaan['realisasi_sebelum']   = $sumPenerimaanPembiayaan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            } elseif ($pem_sub['code'] == 72) {
                                $sumPengeluaranPembiayaan['anggaran']           = $sumPengeluaranPembiayaan['anggaran'] + $getPerhitungan2['anggaran'];
                                $sumPengeluaranPembiayaan['realisasi']          = $sumPengeluaranPembiayaan['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPengeluaranPembiayaan['realisasi_sebelum']  = $sumPengeluaranPembiayaan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                            $sumPembiayaan['anggaran']          = $sumPembiayaan['anggaran'] + ($sumPenerimaanPembiayaan['anggaran'] - $sumPengeluaranPembiayaan['anggaran']);
                            $sumPembiayaan['realisasi']         = $sumPembiayaan['realisasi'] + ($sumPenerimaanPembiayaan['realisasi'] - $sumPengeluaranPembiayaan['realisasi']);
                            $sumPembiayaan['realisasi_sebelum'] = $sumPembiayaan['realisasi_sebelum'] + ($sumPenerimaanPembiayaan['realisasi_sebelum'] - $sumPengeluaranPembiayaan['realisasi_sebelum']);

                            $data['data'][$i]['tag']                = '0';
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = '';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            $data['data'][$i]['total']              = '';
                            $data['data'][$i]['tag']                = 'b';
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = 'PEMBIAYAAN NETTO';
                            $data['data'][$i]['anggaran']           = $sumPembiayaan['anggaran'];
                            $data['data'][$i]['realisasi']          = $sumPembiayaan['realisasi'];
                            $data['data'][$i]['percent']            = ($sumPembiayaan['anggaran'] == 0) ? 0 : ($sumPembiayaan['realisasi'] / $sumPembiayaan['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $sumPembiayaan['realisasi_sebelum'];
                            $i++;

                            $data['data'][$i]['tag']                = '0';
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = '';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;
                        }
                    }
                } else {
                    $sumPenerimaanPembiayaan = [
                        'anggaran'              => 0,
                        'realisasi'             => 0,
                        'realisasi_sebelum'     => 0
                    ];
                    $sumPengeluaranPembiayaan = [
                        'anggaran'              => 0,
                        'realisasi'             => 0,
                        'realisasi_sebelum'     => 0
                    ];
                    foreach ($pem['sub_type'] as $pem_sub) {
                        $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pem_sub['code']);
                        if (end($pem['sub_type']) == $pem_sub) {
                            if ($pem_sub['code'] == 71) {
                                $sumPenerimaanPembiayaan['anggaran']            = $sumPenerimaanPembiayaan['anggaran'] + $getPerhitungan2['anggaran'];
                                $sumPenerimaanPembiayaan['realisasi']           = $sumPenerimaanPembiayaan['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPenerimaanPembiayaan['realisasi_sebelum']   = $sumPenerimaanPembiayaan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            } elseif ($pem_sub['code'] == 72) {
                                $sumPengeluaranPembiayaan['anggaran']           = $sumPengeluaranPembiayaan['anggaran'] + $getPerhitungan2['anggaran'];
                                $sumPengeluaranPembiayaan['realisasi']          = $sumPengeluaranPembiayaan['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPengeluaranPembiayaan['realisasi_sebelum']  = $sumPengeluaranPembiayaan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                            $sumPembiayaan['anggaran']          = $sumPembiayaan['anggaran'] + ($sumPenerimaanPembiayaan['anggaran'] - $sumPengeluaranPembiayaan['anggaran']);
                            $sumPembiayaan['realisasi']         = $sumPembiayaan['realisasi'] + ($sumPenerimaanPembiayaan['realisasi'] - $sumPengeluaranPembiayaan['realisasi']);
                            $sumPembiayaan['realisasi_sebelum'] = $sumPembiayaan['realisasi_sebelum'] + ($sumPenerimaanPembiayaan['realisasi_sebelum'] - $sumPengeluaranPembiayaan['realisasi_sebelum']);

                            $data['data'][$i]['code']               = $pem['code'];
                            $data['data'][$i]['nama']               = $pem['nama'];
                            $data['data'][$i]['anggaran']           = $sumPembiayaan['anggaran'];
                            $data['data'][$i]['realisasi']          = $sumPembiayaan['realisasi'];
                            $data['data'][$i]['percent']            = ($sumPembiayaan['anggaran'] == 0) ? 0 : ($sumPembiayaan['realisasi'] / $sumPembiayaan['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $sumPembiayaan['realisasi_sebelum'];
                            $i++;
                        }
                    }
                    $data['data'][$i]['code']               = '';
                    $data['data'][$i]['nama']               = 'PEMBIAYAAN NETTO';
                    $data['data'][$i]['anggaran']           = $sumPembiayaan['anggaran'];
                    $data['data'][$i]['realisasi']          = $sumPembiayaan['realisasi'];
                    $data['data'][$i]['percent']            = ($sumPembiayaan['anggaran'] == 0) ? 0 : ($sumPembiayaan['realisasi'] / $sumPembiayaan['anggaran']) * 100;
                    $data['data'][$i]['realisasi_sebelum']  = $sumPembiayaan['realisasi_sebelum'];
                    $i++;
                }
            }
            $sisaAnggaran['anggaran']             = $surplusDefisit['anggaran'] + $sumPembiayaan['anggaran'];
            $sisaAnggaran['realisasi']            = $surplusDefisit['realisasi'] + $sumPembiayaan['realisasi'];
            $sisaAnggaran['realisasi_sebelum']    = $surplusDefisit['realisasi_sebelum'] + $sumPembiayaan['realisasi_sebelum'];

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SISA LEBIH PEMBIAYAAN ANGGARAN';
            $data['data'][$i]['anggaran']           = $sisaAnggaran['anggaran'];
            $data['data'][$i]['realisasi']          = $sisaAnggaran['realisasi'];
            $data['data'][$i]['percent']            = ($sisaAnggaran['anggaran'] == 0) ? 0 : ($sisaAnggaran['realisasi'] / $sisaAnggaran['anggaran']) * 100;
            $data['data'][$i]['realisasi_sebelum']  = $sisaAnggaran['realisasi_sebelum'];
            $i++;

            return view('accounting::laporan.realisasi_anggaran.index', $data);
        }
        return view('accounting::laporan.realisasi_anggaran.index', $data);
    }

    public function lap_ra_penerimaan(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $post['level'] = '5';
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;
        $data['level']  = $post['level'];
        $i = 0;

        $sumPendapatan = [
            'anggaran'              => 0,
            'realisasi'             => 0,
            'realisasi_sebelum'     => 0
        ];
        $pendapatan = AkunType::with('sub_type.class.sub_class.coa')->where('code', 4)->get()->toArray();
        foreach ($pendapatan as $pen) {
            $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen['code']);

            $data['data'][$i]['code']               = $this->reCode($pen['code']);
            $data['data'][$i]['nama']               = $pen['nama'];
            if ($post['level'] >= 2) {
                $data['data'][$i]['tag']                = 'b0';
                $data['data'][$i]['anggaran']           = '';
                $data['data'][$i]['realisasi']          = '';
                $data['data'][$i]['percent']            = '';
                $data['data'][$i]['realisasi_sebelum']  = '';
                $i++;

                foreach ($pen['sub_type'] as $pen_sub) {
                    if ($pen_sub['code'] == '41') {
                        $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_sub['code']);

                        $data['data'][$i]['code']               = $this->reCode($pen_sub['code']);
                        $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_sub['nama'];
                        if ($post['level'] >= 3) {
                            $data['data'][$i]['tag']                = 'b0';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            foreach ($pen_sub['class'] as $class) {
                                $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                if ($getPerhitungan3['anggaran'] != 0 || $getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                    $data['data'][$i]['code']               = $this->reCode($class['code']);
                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                    if ($post['level'] >= 4) {
                                        $data['data'][$i]['tag']                = 'b0';
                                        $data['data'][$i]['anggaran']           = '';
                                        $data['data'][$i]['realisasi']          = '';
                                        $data['data'][$i]['percent']            = '';
                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                        $i++;

                                        foreach ($class['sub_class'] as $sub_class) {
                                            $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                            if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                if ($post['level'] >= 5) {
                                                    $data['data'][$i]['tag']                = 'b0';
                                                    $data['data'][$i]['anggaran']           = '';
                                                    $data['data'][$i]['realisasi']          = '';
                                                    $data['data'][$i]['percent']            = '';
                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                    $i++;

                                                    foreach ($sub_class['coa'] as $coa) {
                                                        $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                        if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                            $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                            if ($post['level'] >= 6) {
                                                                $data['data'][$i]['tag']                = 'b0';
                                                                $data['data'][$i]['anggaran']           = '';
                                                                $data['data'][$i]['realisasi']          = '';
                                                                $data['data'][$i]['percent']            = '';
                                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                                $i++;
                                                            } else {
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan5['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan5['anggaran'] == 0) ? 0 : ($getPerhitungan5['realisasi'] / $getPerhitungan5['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                $i++;
                                                            }

                                                            if (end($sub_class['coa']) == $coa) {
                                                                $data['data'][$i]['code']               = '';
                                                                $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                                $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                    $i++;
                                                }

                                                if (end($class['sub_class']) == $sub_class) {
                                                    $data['data'][$i]['code']               = '';
                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                    $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                                    $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                    $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                    $i++;
                                                }
                                            }
                                        }
                                    } else {
                                        $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                        $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                                if (end($pen_sub['class']) == $class) {
                                    $data['data'][$i]['code']               = '';
                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_sub['nama'];
                                    $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                                    $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                    $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                    $i++;
                                }
                            }
                        } else {
                            $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                            $i++;
                        }
                    }

                    if (end($pen['sub_type']) == $pen_sub) {
                        $data['data'][$i]['code']               = '';
                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen['nama'];
                        $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                        $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                        $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                        $i++;

                        $sumPendapatan['anggaran']          = $sumPendapatan['anggaran'] + $getPerhitungan1['anggaran'];
                        $sumPendapatan['realisasi']         = $sumPendapatan['realisasi'] + $getPerhitungan1['realisasi'];
                        $sumPendapatan['realisasi_sebelum'] = $sumPendapatan['realisasi_sebelum'] + $getPerhitungan1['realisasi_sebelum'];
                    }
                }
            } else {
                $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                $i++;

                $sumPendapatan['anggaran']          = $getPerhitungan1['anggaran'];
                $sumPendapatan['realisasi']         = $getPerhitungan1['realisasi'];
                $sumPendapatan['realisasi_sebelum'] = $getPerhitungan1['realisasi_sebelum'];
            }
        }

        if (isset($post['excel'])) {
            foreach ($data['data'] as $kE => $exp) {
                if ($exp['anggaran'] != "") {
                    $data['data'][$kE]['anggaran'] = number_format($exp['anggaran'], 2, ',', '.');
                } else {
                    $data['data'][$kE]['anggaran'] = "";
                }
                if ($exp['realisasi'] != "") {
                    $data['data'][$kE]['realisasi'] = number_format($exp['realisasi'], 2, ',', '.');
                } else {
                    $data['data'][$kE]['realisasi'] = "";
                }
                if ($exp['realisasi_sebelum'] != "") {
                    $data['data'][$kE]['realisasi_sebelum'] = number_format($exp['realisasi_sebelum'], 2, ',', '.');
                } else {
                    $data['data'][$kE]['realisasi_sebelum'] = "";
                }
                if ($exp['percent'] != "") {
                    $data['data'][$kE]['percent'] = (string) $exp['percent'];
                } else {
                    $data['data'][$kE]['percent'] = "";
                }
                $data['data'][$kE]['code'] = str_replace("&emsp;", "  ", $exp['code']);
                $data['data'][$kE]['nama'] = str_replace("&emsp;", "  ", $exp['nama']);
            }
            $data['ths'] = (string) $data['ths'];

            Excel::load('laporan/LRA Penerimaan.xlsx', function ($doc) use ($data) {
                $doc->sheet('Sheet1', function ($sheet) use ($data) {
                    $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                    $sheet->setCellValue('C6', $data['tha']);
                    $sheet->setCellValue('F6', $data['ths']);

                    $k = 8;
                    foreach ($data['data'] as $exp) {
                        $sheet->setCellValue('A' . $k, $exp['code']);
                        $sheet->getStyle('A' . $k)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $sheet->setCellValue('B' . $k, $exp['nama']);
                        $sheet->setCellValue('C' . $k, $exp['anggaran']);
                        $sheet->setCellValue('D' . $k, $exp['realisasi']);
                        $sheet->setCellValue('E' . $k, $exp['percent']);
                        $sheet->setCellValue('F' . $k, $exp['realisasi_sebelum']);
                        $k++;
                    }

                    $k = $k + 2;
                    $sheet->mergeCells('D' . $k . ':F' . $k);
                    $sheet->setCellValue('D' . $k, 'Kuningan, ');

                    $k = $k + 2;
                    $sheet->mergeCells('D' . $k . ':F' . $k);
                    $sheet->setCellValue('D' . $k, 'Direktur ' .configrs()->nama);

                    $k = $k + 7;
                    $sheet->mergeCells('D' . $k . ':F' . $k);
                    $sheet->setCellValue('D' . $k, '_________________________');

                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
        } else {
            return view('accounting::laporan.realisasi_anggaran.penerimaan', $data);
        }
    }

    public function lap_ra_pengeluaran(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $post['level'] = '5';
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;
        $data['level']  = $post['level'];
        $i = 0;

        $sumBelanja = [
            'anggaran'              => 0,
            'realisasi'             => 0,
            'realisasi_sebelum'     => 0
        ];
        $belanja = AkunType::with('sub_type.class.sub_class.coa')->where('code', 5)->get()->toArray();
        foreach ($belanja as $bel) {
            $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $bel['code']);

            $data['data'][$i]['code']               = $this->reCode($bel['code']);
            $data['data'][$i]['nama']               = $bel['nama'];
            if ($post['level'] >= 2) {
                $data['data'][$i]['tag']                = 'b0';
                $data['data'][$i]['anggaran']           = '';
                $data['data'][$i]['realisasi']          = '';
                $data['data'][$i]['percent']            = '';
                $data['data'][$i]['realisasi_sebelum']  = '';
                $i++;

                foreach ($bel['sub_type'] as $bel_sub) {
                    $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $bel_sub['code']);

                    $data['data'][$i]['code']               = $this->reCode($bel_sub['code']);
                    $data['data'][$i]['nama']               = '&emsp;&emsp;' . $bel_sub['nama'];
                    if ($post['level'] >= 3) {
                        $data['data'][$i]['tag']                = 'b0';
                        $data['data'][$i]['anggaran']           = '';
                        $data['data'][$i]['realisasi']          = '';
                        $data['data'][$i]['percent']            = '';
                        $data['data'][$i]['realisasi_sebelum']  = '';
                        $i++;

                        foreach ($bel_sub['class'] as $class) {
                            $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                            if ($getPerhitungan3['anggaran'] != 0 || $getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                $data['data'][$i]['code']               = $this->reCode($class['code']);
                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                if ($post['level'] >= 4) {
                                    $data['data'][$i]['tag']                = 'b0';
                                    $data['data'][$i]['anggaran']           = '';
                                    $data['data'][$i]['realisasi']          = '';
                                    $data['data'][$i]['percent']            = '';
                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                    $i++;

                                    foreach ($class['sub_class'] as $sub_class) {
                                        $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                        if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                            $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                            if ($post['level'] >= 5) {
                                                $data['data'][$i]['tag']                = 'b0';
                                                $data['data'][$i]['anggaran']           = '';
                                                $data['data'][$i]['realisasi']          = '';
                                                $data['data'][$i]['percent']            = '';
                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                $i++;

                                                foreach ($sub_class['coa'] as $coa) {
                                                    $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                    if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                        $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                        if ($post['level'] >= 6) {
                                                            $data['data'][$i]['tag']                = 'b0';
                                                            $data['data'][$i]['anggaran']           = '';
                                                            $data['data'][$i]['realisasi']          = '';
                                                            $data['data'][$i]['percent']            = '';
                                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                                            $i++;
                                                        } else {
                                                            $data['data'][$i]['anggaran']           = $getPerhitungan5['anggaran'];
                                                            $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                            $data['data'][$i]['percent']            = ($getPerhitungan5['anggaran'] == 0) ? 0 : ($getPerhitungan5['realisasi'] / $getPerhitungan5['anggaran']) * 100;
                                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                            $i++;
                                                        }

                                                        if (end($sub_class['coa']) == $coa) {
                                                            $data['data'][$i]['code']               = '';
                                                            $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                            $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                            $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                            $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                            $i++;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $data['data'][$i]['anggaran']           = $getPerhitungan4['anggaran'];
                                                $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                $data['data'][$i]['percent']            = ($getPerhitungan4['anggaran'] == 0) ? 0 : ($getPerhitungan4['realisasi'] / $getPerhitungan4['anggaran']) * 100;
                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                $i++;
                                            }

                                            if (end($class['sub_class']) == $sub_class) {
                                                $data['data'][$i]['code']               = '';
                                                $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                                $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                $i++;
                                            }
                                        }
                                    }
                                } else {
                                    $data['data'][$i]['anggaran']           = $getPerhitungan3['anggaran'];
                                    $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                    $data['data'][$i]['percent']            = ($getPerhitungan3['anggaran'] == 0) ? 0 : ($getPerhitungan3['realisasi'] / $getPerhitungan3['anggaran']) * 100;
                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                    $i++;
                                }
                            }
                            if (end($bel_sub['class']) == $class) {
                                $data['data'][$i]['code']               = '';
                                $data['data'][$i]['nama']               = 'JUMLAH ' . $bel_sub['nama'];
                                $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    } else {
                        $data['data'][$i]['anggaran']           = $getPerhitungan2['anggaran'];
                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                        $data['data'][$i]['percent']            = ($getPerhitungan2['anggaran'] == 0) ? 0 : ($getPerhitungan2['realisasi'] / $getPerhitungan2['anggaran']) * 100;
                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                        $i++;
                    }

                    if (end($bel['sub_type']) == $bel_sub) {
                        $data['data'][$i]['code']               = '';
                        $data['data'][$i]['nama']               = 'JUMLAH ' . $bel['nama'];
                        $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                        $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                        $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                        $i++;

                        $sumBelanja['anggaran']          = $sumBelanja['anggaran'] + $getPerhitungan1['anggaran'];
                        $sumBelanja['realisasi']         = $sumBelanja['realisasi'] + $getPerhitungan1['realisasi'];
                        $sumBelanja['realisasi_sebelum'] = $sumBelanja['realisasi_sebelum'] + $getPerhitungan1['realisasi_sebelum'];
                    }
                }
            } else {
                $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                $i++;

                $sumBelanja['anggaran']          = $getPerhitungan1['anggaran'];
                $sumBelanja['realisasi']         = $getPerhitungan1['realisasi'];
                $sumBelanja['realisasi_sebelum'] = $getPerhitungan1['realisasi_sebelum'];
            }
        }

        if (isset($post['excel'])) {
            foreach ($data['data'] as $kE => $exp) {
                if ($exp['anggaran'] != "") {
                    $data['data'][$kE]['anggaran'] = number_format($exp['anggaran'], 2, ',', '.');
                } else {
                    $data['data'][$kE]['anggaran'] = "";
                }
                if ($exp['realisasi'] != "") {
                    $data['data'][$kE]['realisasi'] = number_format($exp['realisasi'], 2, ',', '.');
                } else {
                    $data['data'][$kE]['realisasi'] = "";
                }
                if ($exp['realisasi_sebelum'] != "") {
                    $data['data'][$kE]['realisasi_sebelum'] = number_format($exp['realisasi_sebelum'], 2, ',', '.');
                } else {
                    $data['data'][$kE]['realisasi_sebelum'] = "";
                }
                if ($exp['percent'] != "") {
                    $data['data'][$kE]['percent'] = (string) $exp['percent'];
                } else {
                    $data['data'][$kE]['percent'] = "";
                }
                $data['data'][$kE]['code'] = str_replace("&emsp;", "  ", $exp['code']);
                $data['data'][$kE]['nama'] = str_replace("&emsp;", "  ", $exp['nama']);
            }
            $data['ths'] = (string) $data['ths'];

            Excel::load('laporan/LRA Pengeluaran.xlsx', function ($doc) use ($data) {
                $doc->sheet('Sheet1', function ($sheet) use ($data) {
                    $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                    $sheet->setCellValue('C6', $data['tha']);
                    $sheet->setCellValue('F6', $data['ths']);

                    $k = 8;
                    foreach ($data['data'] as $exp) {
                        $sheet->setCellValue('A' . $k, $exp['code']);
                        $sheet->getStyle('A' . $k)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $sheet->setCellValue('B' . $k, $exp['nama']);
                        $sheet->setCellValue('C' . $k, $exp['anggaran']);
                        $sheet->setCellValue('D' . $k, $exp['realisasi']);
                        $sheet->setCellValue('E' . $k, $exp['percent']);
                        $sheet->setCellValue('F' . $k, $exp['realisasi_sebelum']);
                        $k++;
                    }

                    $k = $k + 2;
                    $sheet->mergeCells('D' . $k . ':F' . $k);
                    $sheet->setCellValue('D' . $k, 'Kuningan, ');

                    $k = $k + 2;
                    $sheet->mergeCells('D' . $k . ':F' . $k);
                    $sheet->setCellValue('D' . $k, 'Direktur ' .configrs()->nama);

                    $k = $k + 7;
                    $sheet->mergeCells('D' . $k . ':F' . $k);
                    $sheet->setCellValue('D' . $k, '_________________________');

                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
        } else {
            return view('accounting::laporan.realisasi_anggaran.pengeluaran', $data);
        }
    }

    public function lap_operasional(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $post['level'] = '2';
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;
        $data['level']  = $post['level'];
        $i = 0;

        if (isset($post['excel']) && !isset($post['is_lpe'])) {
            if ($post['excel'] == 'SAP') {
                Excel::load('laporan/LO SAP.xlsx', function ($doc) use ($data) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                        $sheet->setCellValue('C6', $data['tha']);
                        $sheet->setCellValue('D6', $data['ths']);

                        $pJL = self::getPerhitunganLRA($data['tha'], 5, '8142001');
                        $sheet->setCellValue('C10', $pJL['realisasi']);
                        $sheet->setCellValue('D10', $pJL['realisasi_sebelum']);
                        $sheet->setCellValue('E10', $pJL['realisasi'] - $pJL['realisasi_sebelum']);
                        $sheet->setCellValue('F10', ($pJL['realisasi'] - $pJL['realisasi_sebelum'] == 0) ? 0 : $pJL['realisasi'] - $pJL['realisasi_sebelum'] / $pJL['realisasi']);
                        $pHK = self::getPerhitunganLRA($data['tha'], 5, '8142004');
                        $sheet->setCellValue('C11', $pHK['realisasi']);
                        $sheet->setCellValue('D11', $pHK['realisasi_sebelum']);
                        $sheet->setCellValue('E11', $pHK['realisasi'] - $pHK['realisasi_sebelum']);
                        $sheet->setCellValue('F11', ($pHK['realisasi'] - $pHK['realisasi_sebelum'] == 0) ? 0 : $pHK['realisasi'] - $pHK['realisasi_sebelum'] / $pHK['realisasi']);
                        $pHibah = self::getPerhitunganLRA($data['tha'], 5, '8142002');
                        $sheet->setCellValue('C12', $pHibah['realisasi']);
                        $sheet->setCellValue('D12', $pHibah['realisasi_sebelum']);
                        $sheet->setCellValue('E12', $pHibah['realisasi'] - $pHibah['realisasi_sebelum']);
                        $sheet->setCellValue('F12', ($pHibah['realisasi'] - $pHibah['realisasi_sebelum'] == 0) ? 0 : $pHibah['realisasi'] - $pHibah['realisasi_sebelum'] / $pHibah['realisasi']);
                        $pULain = self::getPerhitunganLRA($data['tha'], 5, '8142005');
                        $sheet->setCellValue('C13', $pULain['realisasi']);
                        $sheet->setCellValue('D13', $pULain['realisasi_sebelum']);
                        $sheet->setCellValue('E13', $pULain['realisasi'] - $pULain['realisasi_sebelum']);
                        $sheet->setCellValue('F13', ($pULain['realisasi'] - $pULain['realisasi_sebelum'] == 0) ? 0 : $pULain['realisasi'] - $pULain['realisasi_sebelum'] / $pULain['realisasi']);
                        $pAPBN = self::getPerhitunganLRA($data['tha'], 5, '8142006');
                        $sheet->setCellValue('C14', $pAPBN['realisasi']);
                        $sheet->setCellValue('D14', $pAPBN['realisasi_sebelum']);
                        $sheet->setCellValue('E14', $pAPBN['realisasi'] - $pAPBN['realisasi_sebelum']);
                        $sheet->setCellValue('F14', ($pAPBN['realisasi'] - $pAPBN['realisasi_sebelum'] == 0) ? 0 : $pAPBN['realisasi'] - $pAPBN['realisasi_sebelum'] / $pAPBN['realisasi']);

                        $tPen = [
                            'realisasi'         => $pJL['realisasi'] + $pHK['realisasi'] + $pHibah['realisasi'] + $pULain['realisasi'] + $pAPBN['realisasi'],
                            'realisasi_sebelum' => $pJL['realisasi_sebelum'] + $pHK['realisasi_sebelum'] + $pHibah['realisasi_sebelum'] + $pULain['realisasi_sebelum'] + $pAPBN['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C15', $tPen['realisasi']);
                        $sheet->setCellValue('D15', $tPen['realisasi_sebelum']);
                        $sheet->setCellValue('E15', $tPen['realisasi'] - $tPen['realisasi_sebelum']);
                        $sheet->setCellValue('F15', ($tPen['realisasi'] - $tPen['realisasi_sebelum'] == 0) ? 0 : $tPen['realisasi'] - $tPen['realisasi_sebelum'] / $tPen['realisasi']);

                        $bPegawai = self::getPerhitunganLRA($data['tha'], 3, '911');
                        $sheet->setCellValue('C18', $bPegawai['realisasi']);
                        $sheet->setCellValue('D18', $bPegawai['realisasi_sebelum']);
                        $sheet->setCellValue('E18', $bPegawai['realisasi'] - $bPegawai['realisasi_sebelum']);
                        $sheet->setCellValue('F18', ($bPegawai['realisasi'] - $bPegawai['realisasi_sebelum'] == 0) ? 0 : $bPegawai['realisasi'] - $bPegawai['realisasi_sebelum'] / $bPegawai['realisasi']);
                        $bPersediaan = self::getPerhitunganLRA($data['tha'], 5, '9190302');
                        $sheet->setCellValue('C19', $bPersediaan['realisasi']);
                        $sheet->setCellValue('D19', $bPersediaan['realisasi_sebelum']);
                        $sheet->setCellValue('E19', $bPersediaan['realisasi'] - $bPersediaan['realisasi_sebelum']);
                        $sheet->setCellValue('F19', ($bPersediaan['realisasi'] - $bPersediaan['realisasi_sebelum'] == 0) ? 0 : $bPersediaan['realisasi'] - $bPersediaan['realisasi_sebelum'] / $bPersediaan['realisasi']);
                        $bBJasa = self::getPerhitunganLRA($data['tha'], 3, '912');
                        $sheet->setCellValue('C20', $bBJasa['realisasi']);
                        $sheet->setCellValue('D20', $bBJasa['realisasi_sebelum']);
                        $sheet->setCellValue('E20', $bBJasa['realisasi'] - $bBJasa['realisasi_sebelum']);
                        $sheet->setCellValue('F20', ($bBJasa['realisasi'] - $bBJasa['realisasi_sebelum'] == 0) ? 0 : $bBJasa['realisasi'] - $bBJasa['realisasi_sebelum'] / $bBJasa['realisasi']);
                        $bPemeliharaan = self::getPerhitunganLRA($data['tha'], 5, '9190304');
                        $sheet->setCellValue('C21', $bPemeliharaan['realisasi']);
                        $sheet->setCellValue('D21', $bPemeliharaan['realisasi_sebelum']);
                        $sheet->setCellValue('E21', $bPemeliharaan['realisasi'] - $bPemeliharaan['realisasi_sebelum']);
                        $sheet->setCellValue('F21', ($bPemeliharaan['realisasi'] - $bPemeliharaan['realisasi_sebelum'] == 0) ? 0 : $bPemeliharaan['realisasi'] - $bPemeliharaan['realisasi_sebelum'] / $bPemeliharaan['realisasi']);
                        $bLJasa = self::getPerhitunganLRA($data['tha'], 5, '9190305');
                        $sheet->setCellValue('C22', $bLJasa['realisasi']);
                        $sheet->setCellValue('D22', $bLJasa['realisasi_sebelum']);
                        $sheet->setCellValue('E22', $bLJasa['realisasi'] - $bLJasa['realisasi_sebelum']);
                        $sheet->setCellValue('F22', ($bLJasa['realisasi'] - $bLJasa['realisasi_sebelum'] == 0) ? 0 : $bLJasa['realisasi'] - $bLJasa['realisasi_sebelum'] / $bLJasa['realisasi']);
                        $bPDinas = self::getPerhitunganLRA($data['tha'], 5, '9190307');
                        $sheet->setCellValue('C23', $bPDinas['realisasi']);
                        $sheet->setCellValue('D23', $bPDinas['realisasi_sebelum']);
                        $sheet->setCellValue('E23', $bPDinas['realisasi'] - $bPDinas['realisasi_sebelum']);
                        $sheet->setCellValue('F23', ($bPDinas['realisasi'] - $bPDinas['realisasi_sebelum'] == 0) ? 0 : $bPDinas['realisasi'] - $bPDinas['realisasi_sebelum'] / $bPDinas['realisasi']);
                        $bPAset = self::getPerhitunganLRA($data['tha'], 3, '917');
                        $sheet->setCellValue('C24', $bPAset['realisasi']);
                        $sheet->setCellValue('D24', $bPAset['realisasi_sebelum']);
                        $sheet->setCellValue('E24', $bPAset['realisasi'] - $bPAset['realisasi_sebelum']);
                        $sheet->setCellValue('F24', ($bPAset['realisasi'] - $bPAset['realisasi_sebelum'] == 0) ? 0 : $bPAset['realisasi'] - $bPAset['realisasi_sebelum'] / $bPAset['realisasi']);
                        $bBunga = self::getPerhitunganLRA($data['tha'], 3, '913');
                        $sheet->setCellValue('C25', $bBunga['realisasi']);
                        $sheet->setCellValue('D25', $bBunga['realisasi_sebelum']);
                        $sheet->setCellValue('E25', $bBunga['realisasi'] - $bBunga['realisasi_sebelum']);
                        $sheet->setCellValue('F25', ($bBunga['realisasi'] - $bBunga['realisasi_sebelum'] == 0) ? 0 : $bBunga['realisasi'] - $bBunga['realisasi_sebelum'] / $bBunga['realisasi']);

                        $tBeban = [
                            'realisasi'         => $bPegawai['realisasi'] + $bPersediaan['realisasi'] + $bBJasa['realisasi'] + $bPemeliharaan['realisasi'] + $bLJasa['realisasi'] + $bPDinas['realisasi'] + $bPAset['realisasi'] + $bBunga['realisasi'],
                            'realisasi_sebelum' => $bPegawai['realisasi_sebelum'] + $bPersediaan['realisasi_sebelum'] + $bBJasa['realisasi_sebelum'] + $bPemeliharaan['realisasi_sebelum'] + $bLJasa['realisasi_sebelum'] + $bPDinas['realisasi_sebelum'] + $bPAset['realisasi_sebelum'] + $bBunga['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C26', $tBeban['realisasi']);
                        $sheet->setCellValue('D26', $tBeban['realisasi_sebelum']);
                        $sheet->setCellValue('E26', $tBeban['realisasi'] - $tBeban['realisasi_sebelum']);
                        $sheet->setCellValue('F26', ($tBeban['realisasi'] - $tBeban['realisasi_sebelum'] == 0) ? 0 : $tBeban['realisasi'] - $tBeban['realisasi_sebelum'] / $tBeban['realisasi']);

                        $tLO = [
                            'realisasi'         => $tPen['realisasi'] - $tBeban['realisasi'],
                            'realisasi_sebelum' => $tPen['realisasi_sebelum'] - $tBeban['realisasi_sebelum']
                        ];
                        $sheet->setCellValue('C28', $tLO['realisasi']);
                        $sheet->setCellValue('D28', $tLO['realisasi_sebelum']);
                        $sheet->setCellValue('E28', $tLO['realisasi'] - $tLO['realisasi_sebelum']);
                        $sheet->setCellValue('F28', ($tLO['realisasi'] - $tLO['realisasi_sebelum'] == 0) ? 0 : $tLO['realisasi'] - $tLO['realisasi_sebelum'] / $tLO['realisasi']);
                    });
                })->download('xlsx');
            } else {
                Excel::load('laporan/LO SAK.xlsx', function ($doc) use ($data) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang berakhir sampai dengan 31 Desember " . $data['tha'] . " dan " . $data['ths']);
                        $sheet->setCellValue('D6', $data['tha']);
                        $sheet->setCellValue('E6', $data['ths']);

                        $pendapatan = self::getPerhitunganLRA($data['tha'], 1, 8);
                        $sheet->setCellValue('D9', $pendapatan['realisasi']);
                        $sheet->setCellValue('E9', $pendapatan['realisasi_sebelum']);
                        $sheet->setCellValue('D10', $pendapatan['realisasi']);
                        $sheet->setCellValue('E10', $pendapatan['realisasi_sebelum']);

                        $bPegawai = self::getPerhitunganLRA($data['tha'], 3, '911');
                        $sheet->setCellValue('D13', $bPegawai['realisasi']);
                        $sheet->setCellValue('E13', $bPegawai['realisasi_sebelum']);
                        $bAKantor = self::getPerhitunganLRA($data['tha'], 5, '9190303');
                        $sheet->setCellValue('D14', $bAKantor['realisasi']);
                        $sheet->setCellValue('E14', $bAKantor['realisasi_sebelum']);
                        $bPemeliharaan = self::getPerhitunganLRA($data['tha'], 5, '9190304');
                        $sheet->setCellValue('D15', $bPemeliharaan['realisasi']);
                        $sheet->setCellValue('E15', $bPemeliharaan['realisasi_sebelum']);
                        $bBJasa = self::getPerhitunganLRA($data['tha'], 3, '912');
                        $sheet->setCellValue('D16', $bBJasa['realisasi']);
                        $sheet->setCellValue('E16', $bBJasa['realisasi_sebelum']);
                        $bPromosi = self::getPerhitunganLRA($data['tha'], 5, '9190306');
                        $sheet->setCellValue('D17', $bPromosi['realisasi']);
                        $sheet->setCellValue('E17', $bPromosi['realisasi_sebelum']);
                        $bPAT = self::getPerhitunganLRA($data['tha'], 3, '917');
                        $sheet->setCellValue('D18', $bPAT['realisasi']);
                        $sheet->setCellValue('E18', $bPAT['realisasi_sebelum']);
                        $bPPiutang = self::getPerhitunganLRA($data['tha'], 3, '918');
                        $sheet->setCellValue('D19', $bPPiutang['realisasi']);
                        $sheet->setCellValue('E19', $bPPiutang['realisasi_sebelum']);

                        $biayaOps = $bPegawai['realisasi'] + $bAKantor['realisasi'] + $bPemeliharaan['realisasi'] + $bBJasa['realisasi'] + $bPromosi['realisasi'] + $bPAT['realisasi'] + $bPPiutang['realisasi'];
                        $biayaOpsSebelum = $bPegawai['realisasi_sebelum'] + $bAKantor['realisasi_sebelum'] + $bPemeliharaan['realisasi_sebelum'] + $bBJasa['realisasi_sebelum'] + $bPromosi['realisasi_sebelum'] + $bPAT['realisasi_sebelum'] + $bPPiutang['realisasi_sebelum'];
                        $sheet->setCellValue('D20', $biayaOps);
                        $sheet->setCellValue('E20', $biayaOpsSebelum);
                        $sheet->setCellValue('D21', $biayaOps);
                        $sheet->setCellValue('E21', $biayaOpsSebelum);

                        $bBunga = self::getPerhitunganLRA($data['tha'], 3, '913');
                        $sheet->setCellValue('D24', $bBunga['realisasi']);
                        $sheet->setCellValue('E24', $bBunga['realisasi_sebelum']);
                        $bABank = self::getPerhitunganLRA($data['tha'], 5, '9190308');
                        $sheet->setCellValue('D25', $bABank['realisasi']);
                        $sheet->setCellValue('E25', $bABank['realisasi_sebelum']);
                        $bKPAset = self::getPerhitunganLRA($data['tha'], 5, '9190309');
                        $sheet->setCellValue('D26', $bKPAset['realisasi']);
                        $sheet->setCellValue('E26', $bKPAset['realisasi_sebelum']);
                        $KPNilai = self::getPerhitunganLRA($data['tha'], 5, '9190310');
                        $sheet->setCellValue('D27', $KPNilai['realisasi']);
                        $sheet->setCellValue('E27', $KPNilai['realisasi_sebelum']);

                        $biayaNonOps = $bBunga['realisasi'] + $bABank['realisasi'] + $bKPAset['realisasi'] + $KPNilai['realisasi'];
                        $biayaNonOpsSebelum = $bBunga['realisasi_sebelum'] + $bABank['realisasi_sebelum'] + $bKPAset['realisasi_sebelum'] + $KPNilai['realisasi_sebelum'];

                        $sheet->setCellValue('D28', $biayaNonOps);
                        $sheet->setCellValue('E28', $biayaNonOpsSebelum);
                        $sheet->setCellValue('D29', $biayaOps + $biayaNonOps);
                        $sheet->setCellValue('E29', $biayaOpsSebelum + $biayaNonOpsSebelum);
                        $sheet->setCellValue('D32', $pendapatan['realisasi'] - ($biayaOps + $biayaNonOps));
                        $sheet->setCellValue('E32', $pendapatan['realisasi_sebelum'] - ($biayaOpsSebelum + $biayaNonOpsSebelum));
                    });
                })->download('xlsx');
            }
        } else {
            $sumPendapatan = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatan = AkunType::with('sub_type.class.sub_class.coa')->where('code', 8)->get()->toArray();
            foreach ($pendapatan as $pen) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen['code']);

                $data['data'][$i]['code']               = $this->reCode($pen['code']);
                $data['data'][$i]['nama']               = $pen['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen['sub_type'] as $pen_sub) {
                        if ($pen_sub['code'] == 81 || $pen_sub['code'] == 82 || $pen_sub['code'] == 83) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($pen_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($pen_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($pen_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            $sumPendapatan['realisasi']           = $sumPendapatan['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumPendapatan['realisasi_sebelum']   = $sumPendapatan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                        }
                    }
                } else {
                    foreach ($pen['sub_type'] as $pen_sub) {
                        if ($pen_sub['code'] == 81 || $pen_sub['code'] == 82 || $pen_sub['code'] == 83) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_sub['code']);
                            $sumPendapatan['realisasi']           = $sumPendapatan['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumPendapatan['realisasi_sebelum']   = $sumPendapatan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                            if ($pen['sub_type'][2] == $pen_sub) {
                                $data['data'][$i]['code']               = $pen['code'];
                                $data['data'][$i]['nama']               = $pen['nama'];
                                $data['data'][$i]['realisasi']          = $sumPendapatan['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatan['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $pen['nama'];
                $data['data'][$i]['realisasi']          = $sumPendapatan['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatan['realisasi_sebelum'];
                $i++;
            }

            $sumBeban = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $beban = AkunType::with('sub_type.class.sub_class.coa')->where('code', 9)->get()->toArray();
            foreach ($beban as $beb) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $beb['code']);

                $data['data'][$i]['code']               = $this->reCode($beb['code']);
                $data['data'][$i]['nama']               = $beb['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($beb['sub_type'] as $beb_sub) {
                        if ($beb_sub['code'] == 91 || $beb_sub['code'] == 92) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($beb_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beb_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($beb_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($beb_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            $sumBeban['realisasi']           = $sumBeban['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumBeban['realisasi_sebelum']   = $sumBeban['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                        }
                    }
                } else {
                    foreach ($beb['sub_type'] as $beb_sub) {
                        if ($beb_sub['code'] == 91 || $beb_sub['code'] == 92) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_sub['code']);
                            $sumBeban['realisasi']           = $sumBeban['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumBeban['realisasi_sebelum']   = $sumBeban['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                            if ($beb['sub_type'][1] == $beb_sub) {
                                $data['data'][$i]['code']               = $beb['code'];
                                $data['data'][$i]['nama']               = $beb['nama'];
                                $data['data'][$i]['realisasi']          = $sumBeban['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumBeban['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $beb['nama'];
                $data['data'][$i]['realisasi']          = $sumBeban['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumBeban['realisasi_sebelum'];
                $i++;
            }

            $surplusDefisitKegiatanOperasional['realisasi']            = $sumPendapatan['realisasi'] - $sumBeban['realisasi'];
            $surplusDefisitKegiatanOperasional['realisasi_sebelum']    = $sumPendapatan['realisasi_sebelum'] - $sumBeban['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT KEGIATAN OPERASIONAL';
            $data['data'][$i]['realisasi']          = $surplusDefisitKegiatanOperasional['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitKegiatanOperasional['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $sumPendapatanNonOperasional = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatanNonOperasional = AkunType::with('sub_type.class.sub_class.coa')->where('code', 8)->get()->toArray();
            foreach ($pendapatanNonOperasional as $pen_non_ops) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen_non_ops['code']);

                $data['data'][$i]['code']               = $this->reCode($pen_non_ops['code']);
                $data['data'][$i]['nama']               = $pen_non_ops['nama'] . ' NON OPERASIONAL';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen_non_ops['sub_type'] as $pen_non_ops_sub) {
                        if ($pen_non_ops_sub['code'] == 84) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_non_ops_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($pen_non_ops_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_non_ops_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($pen_non_ops_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($pen_non_ops_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_non_ops_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($pen_non_ops['sub_type'][3] == $pen_non_ops_sub) {
                                $sumPendapatanNonOperasional['realisasi']           = $sumPendapatanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanNonOperasional['realisasi_sebelum']   = $sumPendapatanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($pen_non_ops['sub_type'] as $pen_non_ops_sub) {
                        if ($pen_non_ops_sub['code'] == 84) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_non_ops_sub['code']);
                            if ($pen_non_ops['sub_type'][3] == $pen_non_ops_sub) {
                                $sumPendapatanNonOperasional['realisasi']           = $sumPendapatanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanNonOperasional['realisasi_sebelum']   = $sumPendapatanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $pen_non_ops['code'];
                                $data['data'][$i]['nama']               = $pen_non_ops['nama'] . ' NON OPERASIONAL';
                                $data['data'][$i]['realisasi']          = $sumPendapatanNonOperasional['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanNonOperasional['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_non_ops['nama'] . ' NON OPERASIONAL';
                $data['data'][$i]['realisasi']          = $sumPendapatanNonOperasional['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanNonOperasional['realisasi_sebelum'];
                $i++;
            }

            $sumBebanNonOperasional = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $bebanNonOperasional = AkunType::with('sub_type.class.sub_class.coa')->where('code', 9)->get()->toArray();
            foreach ($bebanNonOperasional as $beb_non_ops) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $beb_non_ops['code']);

                $data['data'][$i]['code']               = $this->reCode($beb_non_ops['code']);
                $data['data'][$i]['nama']               = $beb_non_ops['nama'] . ' NON OPERASIONAL';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($beb_non_ops['sub_type'] as $beb_non_ops_sub) {
                        if ($beb_non_ops_sub['code'] == 93) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_non_ops_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($beb_non_ops_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beb_non_ops_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($beb_non_ops_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($beb_non_ops_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_non_ops_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($beb_non_ops['sub_type'][2] == $beb_non_ops_sub) {
                                $sumBebanNonOperasional['realisasi']           = $sumBebanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanNonOperasional['realisasi_sebelum']   = $sumBebanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($beb_non_ops['sub_type'] as $beb_non_ops_sub) {
                        if ($beb_non_ops_sub['code'] == 93) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_non_ops_sub['code']);
                            if ($beb_non_ops['sub_type'][2] == $beb_non_ops_sub) {
                                $sumBebanNonOperasional['realisasi']           = $sumBebanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanNonOperasional['realisasi_sebelum']   = $sumBebanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $beb_non_ops['code'];
                                $data['data'][$i]['nama']               = $beb_non_ops['nama'] . ' NON OPERASIONAL';
                                $data['data'][$i]['realisasi']          = $sumBebanNonOperasional['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumBebanNonOperasional['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_non_ops['nama'] . ' NON OPERASIONAL';
                $data['data'][$i]['realisasi']          = $sumBebanNonOperasional['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumBebanNonOperasional['realisasi_sebelum'];
                $i++;
            }

            $surplusDefisitKegiatanNonOperasional['realisasi']            = $sumPendapatanNonOperasional['realisasi'] - $sumBebanNonOperasional['realisasi'];
            $surplusDefisitKegiatanNonOperasional['realisasi_sebelum']    = $sumPendapatanNonOperasional['realisasi_sebelum'] - $sumBebanNonOperasional['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT KEGIATAN NON OPERASIONAL';
            $data['data'][$i]['realisasi']          = $surplusDefisitKegiatanNonOperasional['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitKegiatanNonOperasional['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $surplusDefisitSebelumLuarBiasa['realisasi']            = $surplusDefisitKegiatanOperasional['realisasi'] + $surplusDefisitKegiatanNonOperasional['realisasi'];
            $surplusDefisitSebelumLuarBiasa['realisasi_sebelum']    = $surplusDefisitKegiatanOperasional['realisasi_sebelum'] + $surplusDefisitKegiatanNonOperasional['realisasi_sebelum'];

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT SEBELUM POS LUAR BIASA';
            $data['data'][$i]['realisasi']          = $surplusDefisitSebelumLuarBiasa['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitSebelumLuarBiasa['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $sumPendapatanLuarBiasa = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatanLuarBiasa = AkunType::with('sub_type.class.sub_class.coa')->where('code', 8)->get()->toArray();
            foreach ($pendapatanLuarBiasa as $pen_luar_biasa) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen_luar_biasa['code']);

                $data['data'][$i]['code']               = $this->reCode($pen_luar_biasa['code']);
                $data['data'][$i]['nama']               = $pen_luar_biasa['nama'] . ' LUAR BIASA';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen_luar_biasa['sub_type'] as $pen_luar_biasa_sub) {
                        if ($pen_luar_biasa_sub['code'] == 85) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_luar_biasa_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($pen_luar_biasa_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_luar_biasa_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($pen_luar_biasa_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($pen_luar_biasa_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_luar_biasa_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($pen_luar_biasa['sub_type'][4] == $pen_luar_biasa_sub) {
                                $sumPendapatanLuarBiasa['realisasi']           = $sumPendapatanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanLuarBiasa['realisasi_sebelum']   = $sumPendapatanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($pen_luar_biasa['sub_type'] as $pen_luar_biasa_sub) {
                        if ($pen_luar_biasa_sub['code'] == 85) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_luar_biasa_sub['code']);
                            if ($pen_luar_biasa['sub_type'][4] == $pen_luar_biasa_sub) {
                                $sumPendapatanLuarBiasa['realisasi']           = $sumPendapatanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanLuarBiasa['realisasi_sebelum']   = $sumPendapatanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $pen_luar_biasa['code'];
                                $data['data'][$i]['nama']               = $pen_luar_biasa['nama'] . ' LUAR BIASA';
                                $data['data'][$i]['realisasi']          = $sumPendapatanLuarBiasa['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanLuarBiasa['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_luar_biasa['nama'] . ' LUAR BIASA';
                $data['data'][$i]['realisasi']          = $sumPendapatanLuarBiasa['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanLuarBiasa['realisasi_sebelum'];
                $i++;
            }

            $sumBebanLuarBiasa = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $bebanLuarBiasa = AkunType::with('sub_type.class.sub_class.coa')->where('code', 9)->get()->toArray();
            foreach ($bebanLuarBiasa as $beb_luar_biasa) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $beb_luar_biasa['code']);

                $data['data'][$i]['code']               = $this->reCode($beb_luar_biasa['code']);
                $data['data'][$i]['nama']               = $beb_luar_biasa['nama'] . ' LUAR BIASA';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($beb_luar_biasa['sub_type'] as $beb_luar_biasa_sub) {
                        if ($beb_luar_biasa_sub['code'] == 94) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_luar_biasa_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($beb_luar_biasa_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beb_luar_biasa_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($beb_luar_biasa_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($beb_luar_biasa_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_luar_biasa_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($beb_luar_biasa['sub_type'][3] == $beb_luar_biasa_sub) {
                                $sumBebanLuarBiasa['realisasi']           = $sumBebanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanLuarBiasa['realisasi_sebelum']   = $sumBebanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($beb_luar_biasa['sub_type'] as $beb_luar_biasa_sub) {
                        if ($beb_luar_biasa_sub['code'] == 94) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_luar_biasa_sub['code']);
                            if ($beb_luar_biasa['sub_type'][3] == $beb_luar_biasa_sub) {
                                $sumBebanLuarBiasa['realisasi']           = $sumBebanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanLuarBiasa['realisasi_sebelum']   = $sumBebanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $beb_luar_biasa['code'];
                                $data['data'][$i]['nama']               = $beb_luar_biasa['nama'] . ' LUAR BIASA';
                                $data['data'][$i]['realisasi']          = $sumBebanLuarBiasa['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumBebanLuarBiasa['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_luar_biasa['nama'] . ' LUAR BIASA';
                $data['data'][$i]['realisasi']          = $sumBebanLuarBiasa['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumBebanLuarBiasa['realisasi_sebelum'];
                $i++;
            }

            $surplusDefisitKegiatanLuarBiasa['realisasi']            = $sumPendapatanLuarBiasa['realisasi'] - $sumBebanLuarBiasa['realisasi'];
            $surplusDefisitKegiatanLuarBiasa['realisasi_sebelum']    = $sumPendapatanLuarBiasa['realisasi_sebelum'] - $sumBebanLuarBiasa['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT KEGIATAN LUAR BIASA';
            $data['data'][$i]['realisasi']          = $surplusDefisitKegiatanLuarBiasa['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitKegiatanLuarBiasa['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $surplusDefisitLO['realisasi']            = $surplusDefisitSebelumLuarBiasa['realisasi'] + $surplusDefisitKegiatanLuarBiasa['realisasi'];
            $surplusDefisitLO['realisasi_sebelum']    = $surplusDefisitSebelumLuarBiasa['realisasi_sebelum'] + $surplusDefisitKegiatanLuarBiasa['realisasi_sebelum'];

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT LO';
            $data['data'][$i]['realisasi']          = $surplusDefisitLO['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitLO['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            if (isset($request->is_lpe) && $request->is_lpe == 1) {
                return $surplusDefisitLO['realisasi'];
            }

            return view('accounting::laporan.operasional.index', $data);
        }
    }

    public function lap_perubahan_ekuitas(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $request->request->add(['tha' => date('Y')]);
        } else {
            $request->request->add(['tha' => $post['tha']]);
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;

        $request->request->add(['is_lpe' => 1, 'level' => 2]);
        $lap_lo = $this->lap_operasional($request);

        $getEkuitasAwal = Ekuitas::where([
            'tahun' => $data['ths']
        ])->get();
        $sumEA = 0;
        foreach ($getEkuitasAwal as $jmlE) {
            $sumEA = $sumEA + $jmlE['jumlah'];
        }

        Ekuitas::updateOrCreate([
            'key'       => 'ekuitas_awal',
            'tahun'     => $data['tha']
        ], [
            'key'       => 'ekuitas_awal',
            'jumlah'    => $sumEA,
            'tahun'     => $data['tha']
        ]);

        Ekuitas::updateOrCreate([
            'key'       => 'surplus',
            'tahun'     => $data['tha']
        ], [
            'key'       => 'surplus',
            'jumlah'    => $lap_lo,
            'tahun'     => $data['tha']
        ]);

        $getEkuitasNow = Ekuitas::where([
            'tahun' => $data['tha']
        ])->get()->toArray();
        $dataEN = [];
        $ekuNowSum = 0;
        foreach ($getEkuitasNow as $valEN) {
            $dataEN[$valEN['key']] = $valEN['jumlah'];
            $ekuNowSum = $ekuNowSum + $valEN['jumlah'];
        }

        $getEkuitasBefore = Ekuitas::where([
            'tahun' => $data['ths']
        ])->get()->toArray();
        $dataEB = [];
        $ekuBeforeSum = 0;
        foreach ($getEkuitasBefore as $valEB) {
            $dataEB[$valEB['key']] = $valEB['jumlah'];
            $ekuBeforeSum = $ekuBeforeSum + $valEB['jumlah'];
        }

        if (isset($post['is_neraca'])) {
            return [
                'ekuitas_now'       => $dataEN,
                'ekuitas_before'    => $dataEB,
                'ekuitas_now_sum'   => $ekuNowSum,
                'ekuitas_before_sum' => $ekuBeforeSum
            ];
        }

        if (isset($post['excel'])) {
            if ($post['excel'] == 'SAP') {
                Excel::load('laporan/LPE SAP.xlsx', function ($doc) use ($data, $dataEN, $dataEB, $ekuNowSum, $ekuBeforeSum) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data, $dataEN, $dataEB, $ekuNowSum, $ekuBeforeSum) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                        $sheet->setCellValue('C6', $data['tha']);
                        $sheet->setCellValue('D6', $data['ths']);

                        $sheet->setCellValue('C7', $dataEN['ekuitas_awal'] ?? 0);
                        $sheet->setCellValue('D7', $dataEB['ekuitas_awal'] ?? 0);

                        $sheet->setCellValue('C8', $dataEN['surplus'] ?? 0);
                        $sheet->setCellValue('D8', $dataEB['surplus'] ?? 0);

                        $sheet->setCellValue('C10', $dataEN['koreksi'] ?? 0);
                        $sheet->setCellValue('D10', $dataEB['koreksi'] ?? 0);

                        $sheet->setCellValue('C11', $dataEN['selisih_ra'] ?? 0);
                        $sheet->setCellValue('D11', $dataEB['selisih_ra'] ?? 0);

                        $sheet->setCellValue('C12', $dataEN['lain-lain'] ?? 0);
                        $sheet->setCellValue('D12', $dataEB['lain-lain'] ?? 0);

                        $sheet->setCellValue('C13', $ekuNowSum + ($dataEN['ekuitas_awal'] ?? 0));
                        $sheet->setCellValue('D13', $ekuBeforeSum + ($dataEB['ekuitas_awal'] ?? 0));
                    });
                })->download('xlsx');
            } else {
                Excel::load('laporan/LPE SAK.xlsx', function ($doc) use ($data, $dataEN, $dataEB) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data, $dataEN, $dataEB) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);

                        $sheet->setCellValue('C7', $dataEN['ekuitas_awal'] ?? 0);
                        $sheet->setCellValue('D7', $dataEB['surplus'] ?? 0);
                        $sheet->setCellValue('E7', $dataEN['ekuitas_awal'] ?? 0 + $dataEB['surplus'] ?? 0);

                        $sheet->setCellValue('C8', 0);
                        $sheet->setCellValue('D8', 0);
                        $sheet->setCellValue('E8', 0);

                        $sheet->setCellValue('C9', 0);
                        $sheet->setCellValue('D9', $dataEN['koreksi'] ?? 0);
                        $sheet->setCellValue('E9', $dataEN['koreksi'] ?? 0);

                        $sheet->setCellValue('C10', 0);
                        $sheet->setCellValue('D10', $dataEN['surplus'] ?? 0);
                        $sheet->setCellValue('E10', $dataEN['surplus'] ?? 0);

                        $sheet->setCellValue('C11', $dataEN['ekuitas_awal'] ?? 0);
                        $sheet->setCellValue('D11', ($dataEB['surplus'] ?? 0) + ($dataEN['koreksi'] ?? 0) + ($dataEN['surplus'] ?? 0));
                        $sheet->setCellValue('E11', ($dataEN['ekuitas_awal'] ?? 0) + ($dataEB['surplus'] ?? 0) + ($dataEN['koreksi'] ?? 0) + ($dataEN['surplus'] ?? 0));
                    });
                })->download('xlsx');
            }
        } else {
            $data['data']   = [[
                'nama'      => 'Ekuitas Awal',
                'now'       => $dataEN['ekuitas_awal'] ?? 0,
                'before'    => $dataEB['ekuitas_awal'] ?? 0
            ], [
                'nama'      => '',
                'now'       => '',
                'before'    => ''
            ], [
                'nama'      => 'Surplus / Defisit LO',
                'now'       => $dataEN['surplus'] ?? 0,
                'before'    => $dataEB['surplus'] ?? 0
            ], [
                'nama'      => '',
                'now'       => '',
                'before'    => ''
            ], [
                'nama'      => 'Koreksi Yang Menambah / Mengurangi Ekuitas',
                'now'       => '',
                'before'    => ''
            ], [
                'nama'      => '&emsp;&emsp;Penyesuaian Nilai Aset',
                'now'       => $dataEN['penyesuaian'] ?? 0,
                'before'    => $dataEB['penyesuaian'] ?? 0
            ], [
                'nama'      => '&emsp;&emsp;Koreksi Persediaan',
                'now'       => $dataEN['koreksi'] ?? 0,
                'before'    => $dataEB['koreksi'] ?? 0
            ], [
                'nama'      => '&emsp;&emsp;Selisih Nilai Aset Tetap',
                'now'       => $dataEN['selisih_ra'] ?? 0,
                'before'    => $dataEB['selisih_ra'] ?? 0
            ], [
                'nama'      => '&emsp;&emsp;Koreksi Nilai Aset Tetap Non Revaluasi',
                'now'       => $dataEN['koreksi_ra'] ?? 0,
                'before'    => $dataEB['koreksi_ra'] ?? 0
            ], [
                'nama'      => '',
                'now'       => '',
                'before'    => ''
            ], [
                'nama'      => 'Transaksi Antar Entitas',
                'now'       => $dataEN['transaksi_antar_entitas'] ?? 0,
                'before'    => $dataEB['transaksi_antar_entitas'] ?? 0
            ], [
                'nama'      => '',
                'now'       => '',
                'before'    => ''
            ], [
                'nama'      => 'Kenaikan / Penurunan Ekuitas',
                'now'       => $dataEN['kenaikan_penurunan_ekuitas'] ?? 0,
                'before'    => $dataEB['kenaikan_penurunan_ekuitas'] ?? 0
            ], [
                'nama'      => '',
                'now'       => '',
                'before'    => ''
            ], [
                'nama'      => 'Ekuitas Akhir',
                'now'       => $ekuNowSum + $dataEN['ekuitas_awal'],
                'before'    => $ekuBeforeSum + ($dataEB['ekuitas_awal'] ?? 0)
            ]];

            return view('accounting::laporan.perubahan_ekuitas.index', $data);
        }
    }

    public function save_lap_perubahan_ekuitas(Request $request)
    {
        $post = $request->except('_token');

        foreach ($post as $key => $val) {
            if ($key != 'tahun') {
                Ekuitas::updateOrCreate([
                    'key'       => $key,
                    'tahun'     => $post['tahun']
                ], [
                    'key'       => $key,
                    'jumlah'    => $val,
                    'tahun'     => $post['tahun']
                ]);
            }
        }

        return redirect()->route('laporan.perubahan_ekuitas');
    }

    public function lap_arus_kas(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $post['level'] = '2';
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;
        $i = 0;

        if (isset($post['excel']) && !isset($post['is_lpe'])) {
            if ($post['excel'] == 'SAP') {
                Excel::load('laporan/LAK SAP.xlsx', function ($doc) use ($data) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                        $sheet->setCellValue('C6', $data['tha']);
                        $sheet->setCellValue('D6', $data['ths']);

                        $pAPBN = self::getPerhitunganLRA($data['tha'], 5, '8142006');
                        $sheet->setCellValue('C9', $pAPBN['realisasi']);
                        $sheet->setCellValue('D9', $pAPBN['realisasi_sebelum']);
                        $pJL = self::getPerhitunganLRA($data['tha'], 5, '8142001');
                        $sheet->setCellValue('C10', $pJL['realisasi']);
                        $sheet->setCellValue('D10', $pJL['realisasi_sebelum']);
                        $pHK = self::getPerhitunganLRA($data['tha'], 5, '8142004');
                        $sheet->setCellValue('C12', $pHK['realisasi']);
                        $sheet->setCellValue('D12', $pHK['realisasi_sebelum']);
                        $pHibah = self::getPerhitunganLRA($data['tha'], 5, '8142002');
                        $sheet->setCellValue('C13', $pHibah['realisasi']);
                        $sheet->setCellValue('D13', $pHibah['realisasi_sebelum']);
                        $pULain = self::getPerhitunganLRA($data['tha'], 5, '8142005');
                        $sheet->setCellValue('C14', $pULain['realisasi']);
                        $sheet->setCellValue('D14', $pULain['realisasi_sebelum']);

                        $tPen = [
                            'realisasi'         => $pJL['realisasi'] + $pHK['realisasi'] + $pHibah['realisasi'] + $pULain['realisasi'] + $pAPBN['realisasi'],
                            'realisasi_sebelum' => $pJL['realisasi_sebelum'] + $pHK['realisasi_sebelum'] + $pHibah['realisasi_sebelum'] + $pULain['realisasi_sebelum'] + $pAPBN['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C15', $tPen['realisasi']);
                        $sheet->setCellValue('D15', $tPen['realisasi_sebelum']);

                        $bPegawai = self::getPerhitunganLRA($data['tha'], 3, '911');
                        $sheet->setCellValue('C17', $bPegawai['realisasi']);
                        $sheet->setCellValue('D17', $bPegawai['realisasi_sebelum']);
                        $bBJasa = self::getPerhitunganLRA($data['tha'], 3, '912');
                        $sheet->setCellValue('C18', $bBJasa['realisasi']);
                        $sheet->setCellValue('D18', $bBJasa['realisasi_sebelum']);
                        $bPemeliharaan = self::getPerhitunganLRA($data['tha'], 5, '9190304');
                        $sheet->setCellValue('C19', $bPemeliharaan['realisasi']);
                        $sheet->setCellValue('D19', $bPemeliharaan['realisasi_sebelum']);
                        $bLJasa = self::getPerhitunganLRA($data['tha'], 5, '9190305');
                        $sheet->setCellValue('C20', $bLJasa['realisasi']);
                        $sheet->setCellValue('D20', $bLJasa['realisasi_sebelum']);
                        $bPDinas = self::getPerhitunganLRA($data['tha'], 5, '9190307');
                        $sheet->setCellValue('C21', $bPDinas['realisasi']);
                        $sheet->setCellValue('D21', $bPDinas['realisasi_sebelum']);
                        $bBunga = self::getPerhitunganLRA($data['tha'], 3, '913');
                        $sheet->setCellValue('C22', $bBunga['realisasi']);
                        $sheet->setCellValue('D22', $bBunga['realisasi_sebelum']);

                        $tBeban = [
                            'realisasi'         => $bPegawai['realisasi'] + $bBJasa['realisasi'] + $bPemeliharaan['realisasi'] + $bLJasa['realisasi'] + $bPDinas['realisasi'] + $bBunga['realisasi'],
                            'realisasi_sebelum' => $bPegawai['realisasi_sebelum'] + $bBJasa['realisasi_sebelum'] + $bPemeliharaan['realisasi_sebelum'] + $bLJasa['realisasi_sebelum'] + $bPDinas['realisasi_sebelum'] + $bBunga['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C23', $tBeban['realisasi']);
                        $sheet->setCellValue('D23', $tBeban['realisasi_sebelum']);

                        $tLO = [
                            'realisasi'         => $tPen['realisasi'] - $tBeban['realisasi'],
                            'realisasi_sebelum' => $tPen['realisasi_sebelum'] - $tBeban['realisasi_sebelum']
                        ];
                        $sheet->setCellValue('C25', $tLO['realisasi']);
                        $sheet->setCellValue('D25', $tLO['realisasi_sebelum']);

                        $pT = self::getPerhitunganLRA($data['tha'], 5, '8140101');
                        $sheet->setCellValue('C29', $pT['realisasi']);
                        $sheet->setCellValue('D29', $pT['realisasi_sebelum']);
                        $pPM = self::getPerhitunganLRA($data['tha'], 5, '8140102');
                        $sheet->setCellValue('C30', $pPM['realisasi']);
                        $sheet->setCellValue('D30', $pPM['realisasi_sebelum']);
                        $pGB = self::getPerhitunganLRA($data['tha'], 5, '8140103');
                        $sheet->setCellValue('C31', $pGB['realisasi']);
                        $sheet->setCellValue('D31', $pGB['realisasi_sebelum']);
                        $pJIJ = self::getPerhitunganLRA($data['tha'], 5, '8140104');
                        $sheet->setCellValue('C32', $pJIJ['realisasi']);
                        $sheet->setCellValue('D32', $pJIJ['realisasi_sebelum']);
                        $pATL = self::getPerhitunganLRA($data['tha'], 5, '8140105');
                        $sheet->setCellValue('C33', $pATL['realisasi']);
                        $sheet->setCellValue('D33', $pATL['realisasi_sebelum']);
                        $pAL = self::getPerhitunganLRA($data['tha'], 5, '8140201');
                        $sheet->setCellValue('C34', $pAL['realisasi']);
                        $sheet->setCellValue('D34', $pAL['realisasi_sebelum']);
                        // $pD = self::getPerhitunganLRA($data['tha'], 5, '8142005');
                        // $sheet->setCellValue('C14', $pD['realisasi']);
                        // $sheet->setCellValue('D14', $pD['realisasi_sebelum']);
                        // $pPIBS = self::getPerhitunganLRA($data['tha'], 5, '8142005');
                        // $sheet->setCellValue('C14', $pPIBS['realisasi']);
                        // $sheet->setCellValue('D14', $pPIBS['realisasi_sebelum']);

                        $tPenLain = [
                            'realisasi'         => $pT['realisasi'] + $pPM['realisasi'] + $pGB['realisasi'] + $pJIJ['realisasi'] + $pATL['realisasi'] + $pAL['realisasi'],
                            'realisasi_sebelum' => $pT['realisasi_sebelum'] + $pPM['realisasi_sebelum'] + $pGB['realisasi_sebelum'] + $pJIJ['realisasi_sebelum'] + $pATL['realisasi_sebelum'] + $pAL['realisasi'],
                        ];
                        $sheet->setCellValue('C37', $tPenLain['realisasi']);
                        $sheet->setCellValue('D37', $tPenLain['realisasi_sebelum']);
                        $sheet->setCellValue('C49', $tPenLain['realisasi']);
                        $sheet->setCellValue('D49', $tPenLain['realisasi_sebelum']);
                    });
                })->download('xlsx');
            } else {
                Excel::load('laporan/LAK SAK.xlsx', function ($doc) use ($data) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang berakhir sampai dengan 31 Desember " . $data['tha'] . " dan " . $data['ths']);
                        $sheet->setCellValue('D6', $data['tha']);
                        $sheet->setCellValue('E6', $data['ths']);

                        $pJL = self::getPerhitunganLRA($data['tha'], 5, '8142001');
                        $sheet->setCellValue('D10', $pJL['realisasi']);
                        $sheet->setCellValue('E10', $pJL['realisasi_sebelum']);
                        $pLL = self::getPerhitunganLRA($data['tha'], 5, '8142005');
                        $sheet->setCellValue('D11', $pLL['realisasi']);
                        $sheet->setCellValue('E11', $pLL['realisasi_sebelum']);
                        // $pPP = self::getPerhitunganLRA($data['tha'], 5, '8142001');
                        // $sheet->setCellValue('D12', $pPP['realisasi']);
                        // $sheet->setCellValue('E12', $pPP['realisasi_sebelum']);

                        $tArusMasuk = [
                            'realisasi'         => $pJL['realisasi'] + $pLL['realisasi'],
                            'realisasi_sebelum' => $pJL['realisasi_sebelum'] + $pLL['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D13', $tArusMasuk['realisasi']);
                        $sheet->setCellValue('E13', $tArusMasuk['realisasi_sebelum']);

                        $bPelayanan = self::getPerhitunganLRA($data['tha'], 2, '91');
                        $sheet->setCellValue('D16', $bPelayanan['realisasi']);
                        $sheet->setCellValue('E16', $bPelayanan['realisasi_sebelum']);
                        $bPenunjang = self::getPerhitunganLRA($data['tha'], 2, '92');
                        $sheet->setCellValue('D17', $bPenunjang['realisasi']);
                        $sheet->setCellValue('E17', $bPenunjang['realisasi_sebelum']);
                        $bPU = self::getPerhitunganLRA($data['tha'], 3, '932');
                        $sheet->setCellValue('D18', $bPU['realisasi']);
                        $sheet->setCellValue('E18', $bPU['realisasi_sebelum']);

                        $tArusKeluar = [
                            'realisasi'         => $bPelayanan['realisasi'] + $bPenunjang['realisasi'] + $bPU['realisasi'],
                            'realisasi_sebelum' => $bPelayanan['realisasi_sebelum'] + $bPenunjang['realisasi_sebelum'] + $bPU['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D19', $tArusKeluar['realisasi']);
                        $sheet->setCellValue('E19', $tArusKeluar['realisasi_sebelum']);

                        $bBMT = self::getPerhitunganLRA($data['tha'], 3, '521');
                        $sheet->setCellValue('D24', $bBMT['realisasi']);
                        $sheet->setCellValue('E24', $bBMT['realisasi_sebelum']);
                        $bBMPM = self::getPerhitunganLRA($data['tha'], 3, '522');
                        $sheet->setCellValue('D25', $bBMPM['realisasi']);
                        $sheet->setCellValue('E25', $bBMPM['realisasi_sebelum']);
                        $bBMGB = self::getPerhitunganLRA($data['tha'], 3, '523');
                        $sheet->setCellValue('D26', $bBMGB['realisasi']);
                        $sheet->setCellValue('E26', $bBMGB['realisasi_sebelum']);
                        $bBMJIJ = self::getPerhitunganLRA($data['tha'], 3, '524');
                        $sheet->setCellValue('D27', $bBMJIJ['realisasi']);
                        $sheet->setCellValue('E27', $bBMJIJ['realisasi_sebelum']);
                        $bBMATL = self::getPerhitunganLRA($data['tha'], 3, '525');
                        $sheet->setCellValue('D28', $bBMATL['realisasi']);
                        $sheet->setCellValue('E28', $bBMATL['realisasi_sebelum']);

                        $tArusKeluarI = [
                            'realisasi'         => $bBMT['realisasi'] + $bBMPM['realisasi'] + $bBMGB['realisasi'] + $bBMJIJ['realisasi'] + $bBMATL['realisasi'],
                            'realisasi_sebelum' => $bBMT['realisasi_sebelum'] + $bBMPM['realisasi_sebelum'] + $bBMGB['realisasi_sebelum'] + $bBMJIJ['realisasi_sebelum'] + $bBMATL['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D29', $tArusKeluarI['realisasi']);
                        $sheet->setCellValue('E29', $tArusKeluarI['realisasi_sebelum']);

                        $tArusKas = [
                            'realisasi'         => $tArusMasuk['realisasi'] + $tArusKeluar['realisasi'] + $tArusKeluarI['realisasi'],
                            'realisasi_sebelum' => $tArusMasuk['realisasi_sebelum'] + $tArusKeluar['realisasi_sebelum'] + $tArusKeluarI['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D41', $tArusKas['realisasi']);
                        $sheet->setCellValue('E41', $tArusKas['realisasi_sebelum']);

                        $tArusKasAwal = [
                            'realisasi'         => 0,
                            'realisasi_sebelum' => 0,
                        ];
                        $sheet->setCellValue('D42', $tArusKasAwal['realisasi']);
                        $sheet->setCellValue('E42', $tArusKasAwal['realisasi_sebelum']);

                        $tSaldoAkhir = [
                            'realisasi'         => $tArusKas['realisasi'] + $tArusKasAwal['realisasi'],
                            'realisasi_sebelum' => $tArusKas['realisasi_sebelum'] + $tArusKasAwal['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D43', $tSaldoAkhir['realisasi']);
                        $sheet->setCellValue('E43', $tSaldoAkhir['realisasi_sebelum']);
                    });
                })->download('xlsx');
            }
        } else {
            $sumPendapatan = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatan = AkunType::with('sub_type.class.sub_class.coa')->where('code', 8)->get()->toArray();
            foreach ($pendapatan as $pen) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen['code']);

                $data['data'][$i]['code']               = $this->reCode($pen['code']);
                $data['data'][$i]['nama']               = $pen['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen['sub_type'] as $pen_sub) {
                        if ($pen_sub['code'] == 81 || $pen_sub['code'] == 82 || $pen_sub['code'] == 83) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($pen_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($pen_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($pen_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            $sumPendapatan['realisasi']           = $sumPendapatan['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumPendapatan['realisasi_sebelum']   = $sumPendapatan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                        }
                    }
                } else {
                    foreach ($pen['sub_type'] as $pen_sub) {
                        if ($pen_sub['code'] == 81 || $pen_sub['code'] == 82 || $pen_sub['code'] == 83) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_sub['code']);
                            $sumPendapatan['realisasi']           = $sumPendapatan['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumPendapatan['realisasi_sebelum']   = $sumPendapatan['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                            if ($pen['sub_type'][2] == $pen_sub) {
                                $data['data'][$i]['code']               = $pen['code'];
                                $data['data'][$i]['nama']               = $pen['nama'];
                                $data['data'][$i]['realisasi']          = $sumPendapatan['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatan['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $pen['nama'];
                $data['data'][$i]['realisasi']          = $sumPendapatan['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatan['realisasi_sebelum'];
                $i++;
            }

            $sumBeban = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $beban = AkunType::with('sub_type.class.sub_class.coa')->where('code', 9)->get()->toArray();
            foreach ($beban as $beb) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $beb['code']);

                $data['data'][$i]['code']               = $this->reCode($beb['code']);
                $data['data'][$i]['nama']               = $beb['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($beb['sub_type'] as $beb_sub) {
                        if ($beb_sub['code'] == 91 || $beb_sub['code'] == 92) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($beb_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beb_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($beb_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($beb_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            $sumBeban['realisasi']           = $sumBeban['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumBeban['realisasi_sebelum']   = $sumBeban['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                        }
                    }
                } else {
                    foreach ($beb['sub_type'] as $beb_sub) {
                        if ($beb_sub['code'] == 91 || $beb_sub['code'] == 92) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_sub['code']);
                            $sumBeban['realisasi']           = $sumBeban['realisasi'] + $getPerhitungan2['realisasi'];
                            $sumBeban['realisasi_sebelum']   = $sumBeban['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                            if ($beb['sub_type'][1] == $beb_sub) {
                                $data['data'][$i]['code']               = $beb['code'];
                                $data['data'][$i]['nama']               = $beb['nama'];
                                $data['data'][$i]['realisasi']          = $sumBeban['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumBeban['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $beb['nama'];
                $data['data'][$i]['realisasi']          = $sumBeban['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumBeban['realisasi_sebelum'];
                $i++;
            }

            $surplusDefisitKegiatanOperasional['realisasi']            = $sumPendapatan['realisasi'] - $sumBeban['realisasi'];
            $surplusDefisitKegiatanOperasional['realisasi_sebelum']    = $sumPendapatan['realisasi_sebelum'] - $sumBeban['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT KEGIATAN OPERASIONAL';
            $data['data'][$i]['realisasi']          = $surplusDefisitKegiatanOperasional['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitKegiatanOperasional['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $sumPendapatanNonOperasional = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatanNonOperasional = AkunType::with('sub_type.class.sub_class.coa')->where('code', 8)->get()->toArray();
            foreach ($pendapatanNonOperasional as $pen_non_ops) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen_non_ops['code']);

                $data['data'][$i]['code']               = $this->reCode($pen_non_ops['code']);
                $data['data'][$i]['nama']               = $pen_non_ops['nama'] . ' NON OPERASIONAL';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen_non_ops['sub_type'] as $pen_non_ops_sub) {
                        if ($pen_non_ops_sub['code'] == 84) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_non_ops_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($pen_non_ops_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_non_ops_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($pen_non_ops_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($pen_non_ops_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_non_ops_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($pen_non_ops['sub_type'][3] == $pen_non_ops_sub) {
                                $sumPendapatanNonOperasional['realisasi']           = $sumPendapatanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanNonOperasional['realisasi_sebelum']   = $sumPendapatanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($pen_non_ops['sub_type'] as $pen_non_ops_sub) {
                        if ($pen_non_ops_sub['code'] == 84) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_non_ops_sub['code']);
                            if ($pen_non_ops['sub_type'][3] == $pen_non_ops_sub) {
                                $sumPendapatanNonOperasional['realisasi']           = $sumPendapatanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanNonOperasional['realisasi_sebelum']   = $sumPendapatanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $pen_non_ops['code'];
                                $data['data'][$i]['nama']               = $pen_non_ops['nama'] . ' NON OPERASIONAL';
                                $data['data'][$i]['realisasi']          = $sumPendapatanNonOperasional['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanNonOperasional['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_non_ops['nama'] . ' NON OPERASIONAL';
                $data['data'][$i]['realisasi']          = $sumPendapatanNonOperasional['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanNonOperasional['realisasi_sebelum'];
                $i++;
            }

            $sumBebanNonOperasional = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $bebanNonOperasional = AkunType::with('sub_type.class.sub_class.coa')->where('code', 9)->get()->toArray();
            foreach ($bebanNonOperasional as $beb_non_ops) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $beb_non_ops['code']);

                $data['data'][$i]['code']               = $this->reCode($beb_non_ops['code']);
                $data['data'][$i]['nama']               = $beb_non_ops['nama'] . ' NON OPERASIONAL';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($beb_non_ops['sub_type'] as $beb_non_ops_sub) {
                        if ($beb_non_ops_sub['code'] == 93) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_non_ops_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($beb_non_ops_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beb_non_ops_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($beb_non_ops_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($beb_non_ops_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_non_ops_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($beb_non_ops['sub_type'][2] == $beb_non_ops_sub) {
                                $sumBebanNonOperasional['realisasi']           = $sumBebanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanNonOperasional['realisasi_sebelum']   = $sumBebanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($beb_non_ops['sub_type'] as $beb_non_ops_sub) {
                        if ($beb_non_ops_sub['code'] == 93) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_non_ops_sub['code']);
                            if ($beb_non_ops['sub_type'][2] == $beb_non_ops_sub) {
                                $sumBebanNonOperasional['realisasi']           = $sumBebanNonOperasional['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanNonOperasional['realisasi_sebelum']   = $sumBebanNonOperasional['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $beb_non_ops['code'];
                                $data['data'][$i]['nama']               = $beb_non_ops['nama'] . ' NON OPERASIONAL';
                                $data['data'][$i]['realisasi']          = $sumBebanNonOperasional['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumBebanNonOperasional['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_non_ops['nama'] . ' NON OPERASIONAL';
                $data['data'][$i]['realisasi']          = $sumBebanNonOperasional['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumBebanNonOperasional['realisasi_sebelum'];
                $i++;
            }

            $surplusDefisitKegiatanNonOperasional['realisasi']            = $sumPendapatanNonOperasional['realisasi'] - $sumBebanNonOperasional['realisasi'];
            $surplusDefisitKegiatanNonOperasional['realisasi_sebelum']    = $sumPendapatanNonOperasional['realisasi_sebelum'] - $sumBebanNonOperasional['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT KEGIATAN NON OPERASIONAL';
            $data['data'][$i]['realisasi']          = $surplusDefisitKegiatanNonOperasional['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitKegiatanNonOperasional['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $surplusDefisitSebelumLuarBiasa['realisasi']            = $surplusDefisitKegiatanOperasional['realisasi'] + $surplusDefisitKegiatanNonOperasional['realisasi'];
            $surplusDefisitSebelumLuarBiasa['realisasi_sebelum']    = $surplusDefisitKegiatanOperasional['realisasi_sebelum'] + $surplusDefisitKegiatanNonOperasional['realisasi_sebelum'];

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT SEBELUM POS LUAR BIASA';
            $data['data'][$i]['realisasi']          = $surplusDefisitSebelumLuarBiasa['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitSebelumLuarBiasa['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $sumPendapatanLuarBiasa = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatanLuarBiasa = AkunType::with('sub_type.class.sub_class.coa')->where('code', 8)->get()->toArray();
            foreach ($pendapatanLuarBiasa as $pen_luar_biasa) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $pen_luar_biasa['code']);

                $data['data'][$i]['code']               = $this->reCode($pen_luar_biasa['code']);
                $data['data'][$i]['nama']               = $pen_luar_biasa['nama'] . ' LUAR BIASA';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($pen_luar_biasa['sub_type'] as $pen_luar_biasa_sub) {
                        if ($pen_luar_biasa_sub['code'] == 85) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_luar_biasa_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($pen_luar_biasa_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pen_luar_biasa_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($pen_luar_biasa_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($pen_luar_biasa_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_luar_biasa_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($pen_luar_biasa['sub_type'][4] == $pen_luar_biasa_sub) {
                                $sumPendapatanLuarBiasa['realisasi']           = $sumPendapatanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanLuarBiasa['realisasi_sebelum']   = $sumPendapatanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($pen_luar_biasa['sub_type'] as $pen_luar_biasa_sub) {
                        if ($pen_luar_biasa_sub['code'] == 85) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $pen_luar_biasa_sub['code']);
                            if ($pen_luar_biasa['sub_type'][4] == $pen_luar_biasa_sub) {
                                $sumPendapatanLuarBiasa['realisasi']           = $sumPendapatanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumPendapatanLuarBiasa['realisasi_sebelum']   = $sumPendapatanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $pen_luar_biasa['code'];
                                $data['data'][$i]['nama']               = $pen_luar_biasa['nama'] . ' LUAR BIASA';
                                $data['data'][$i]['realisasi']          = $sumPendapatanLuarBiasa['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanLuarBiasa['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $pen_luar_biasa['nama'] . ' LUAR BIASA';
                $data['data'][$i]['realisasi']          = $sumPendapatanLuarBiasa['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumPendapatanLuarBiasa['realisasi_sebelum'];
                $i++;
            }

            $sumBebanLuarBiasa = [
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $bebanLuarBiasa = AkunType::with('sub_type.class.sub_class.coa')->where('code', 9)->get()->toArray();
            foreach ($bebanLuarBiasa as $beb_luar_biasa) {
                $getPerhitungan1   = self::getPerhitunganLRA($data['tha'], 1, $beb_luar_biasa['code']);

                $data['data'][$i]['code']               = $this->reCode($beb_luar_biasa['code']);
                $data['data'][$i]['nama']               = $beb_luar_biasa['nama'] . ' LUAR BIASA';
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    foreach ($beb_luar_biasa['sub_type'] as $beb_luar_biasa_sub) {
                        if ($beb_luar_biasa_sub['code'] == 94) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_luar_biasa_sub['code']);

                            $data['data'][$i]['code']               = $this->reCode($beb_luar_biasa_sub['code']);
                            $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beb_luar_biasa_sub['nama'];
                            if ($post['level'] >= 3) {
                                $data['data'][$i]['tag']                = 'b0';
                                $data['data'][$i]['realisasi']          = '';
                                $data['data'][$i]['realisasi_sebelum']  = '';
                                $i++;

                                foreach ($beb_luar_biasa_sub['class'] as $class) {
                                    $getPerhitungan3   = self::getPerhitunganLRA($data['tha'], 3, $class['code']);

                                    if ($getPerhitungan3['realisasi'] != 0 || $getPerhitungan3['realisasi_sebelum'] != 0) {
                                        $data['data'][$i]['code']               = $this->reCode($class['code']);
                                        $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                        if ($post['level'] >= 4) {
                                            $data['data'][$i]['tag']                = 'b0';
                                            $data['data'][$i]['realisasi']          = '';
                                            $data['data'][$i]['realisasi_sebelum']  = '';
                                            $i++;

                                            foreach ($class['sub_class'] as $sub_class) {
                                                $getPerhitungan4   = self::getPerhitunganLRA($data['tha'], 4, $sub_class['code']);

                                                if ($getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                                    $data['data'][$i]['code']               = $this->reCode($sub_class['code']);
                                                    $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                                    if ($post['level'] >= 5) {
                                                        $data['data'][$i]['tag']                = 'b0';
                                                        $data['data'][$i]['realisasi']          = '';
                                                        $data['data'][$i]['realisasi_sebelum']  = '';
                                                        $i++;

                                                        foreach ($sub_class['coa'] as $coa) {
                                                            $getPerhitungan5   = self::getPerhitunganLRA($data['tha'], 5, $coa['code']);

                                                            if ($getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                                $data['data'][$i]['code']               = $this->reCode($coa['code']);
                                                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $coa['nama'];
                                                                if ($post['level'] >= 6) {
                                                                    $data['data'][$i]['tag']                = 'b0';
                                                                    $data['data'][$i]['realisasi']          = '';
                                                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                                                    $i++;
                                                                } else {
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan5['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan5['realisasi_sebelum'];
                                                                    $i++;
                                                                }

                                                                if (end($sub_class['coa']) == $coa) {
                                                                    $data['data'][$i]['code']               = '';
                                                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $sub_class['nama'];
                                                                    $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan4['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan4['realisasi_sebelum'];
                                                        $i++;
                                                    }

                                                    if (end($class['sub_class']) == $sub_class) {
                                                        $data['data'][$i]['code']               = '';
                                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $class['nama'];
                                                        $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                                        $i++;
                                                    }
                                                }
                                            }
                                        } else {
                                            $data['data'][$i]['realisasi']          = $getPerhitungan3['realisasi'];
                                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan3['realisasi_sebelum'];
                                            $i++;
                                        }
                                    }
                                    if (end($beb_luar_biasa_sub['class']) == $class) {
                                        $data['data'][$i]['code']               = '';
                                        $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_luar_biasa_sub['nama'];
                                        $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                        $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                        $i++;
                                    }
                                }
                            } else {
                                $data['data'][$i]['realisasi']          = $getPerhitungan2['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan2['realisasi_sebelum'];
                                $i++;
                            }

                            if ($beb_luar_biasa['sub_type'][3] == $beb_luar_biasa_sub) {
                                $sumBebanLuarBiasa['realisasi']           = $sumBebanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanLuarBiasa['realisasi_sebelum']   = $sumBebanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];
                            }
                        }
                    }
                } else {
                    foreach ($beb_luar_biasa['sub_type'] as $beb_luar_biasa_sub) {
                        if ($beb_luar_biasa_sub['code'] == 94) {
                            $getPerhitungan2   = self::getPerhitunganLRA($data['tha'], 2, $beb_luar_biasa_sub['code']);
                            if ($beb_luar_biasa['sub_type'][3] == $beb_luar_biasa_sub) {
                                $sumBebanLuarBiasa['realisasi']           = $sumBebanLuarBiasa['realisasi'] + $getPerhitungan2['realisasi'];
                                $sumBebanLuarBiasa['realisasi_sebelum']   = $sumBebanLuarBiasa['realisasi_sebelum'] + $getPerhitungan2['realisasi_sebelum'];

                                $data['data'][$i]['code']               = $beb_luar_biasa['code'];
                                $data['data'][$i]['nama']               = $beb_luar_biasa['nama'] . ' LUAR BIASA';
                                $data['data'][$i]['realisasi']          = $sumBebanLuarBiasa['realisasi'];
                                $data['data'][$i]['realisasi_sebelum']  = $sumBebanLuarBiasa['realisasi_sebelum'];
                                $i++;
                            }
                        }
                    }
                }
                $data['data'][$i]['code']               = '';
                $data['data'][$i]['nama']               = 'JUMLAH ' . $beb_luar_biasa['nama'] . ' LUAR BIASA';
                $data['data'][$i]['realisasi']          = $sumBebanLuarBiasa['realisasi'];
                $data['data'][$i]['realisasi_sebelum']  = $sumBebanLuarBiasa['realisasi_sebelum'];
                $i++;
            }

            $surplusDefisitKegiatanLuarBiasa['realisasi']            = $sumPendapatanLuarBiasa['realisasi'] - $sumBebanLuarBiasa['realisasi'];
            $surplusDefisitKegiatanLuarBiasa['realisasi_sebelum']    = $sumPendapatanLuarBiasa['realisasi_sebelum'] - $sumBebanLuarBiasa['realisasi_sebelum'];

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT KEGIATAN LUAR BIASA';
            $data['data'][$i]['realisasi']          = $surplusDefisitKegiatanLuarBiasa['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitKegiatanLuarBiasa['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            $surplusDefisitLO['realisasi']            = $surplusDefisitSebelumLuarBiasa['realisasi'] + $surplusDefisitKegiatanLuarBiasa['realisasi'];
            $surplusDefisitLO['realisasi_sebelum']    = $surplusDefisitSebelumLuarBiasa['realisasi_sebelum'] + $surplusDefisitKegiatanLuarBiasa['realisasi_sebelum'];

            $data['data'][$i]['total']              = '';
            $data['data'][$i]['tag']                = 'b';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = 'SURPLUS / DEFISIT LO';
            $data['data'][$i]['realisasi']          = $surplusDefisitLO['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $surplusDefisitLO['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            if (isset($request->is_lpe) && $request->is_lpe == 1) {
                return $surplusDefisitLO['realisasi'];
            }

            return view('accounting::laporan.arus_kas.index', $data);
        }
    }

    public function lap_sal(Request $request)
    {
        $post = $request->except('_token');

        if (empty($post)) {
            $post['tha'] = date('Y');
            $request->request->add(['tha' => date('Y')]);
        } else {
            $request->request->add(['tha' => $post['tha']]);
        }

        $data['tha']    = $post['tha'];
        $data['ths']    = (int) $post['tha'] - 1;

        $getSALAwal = Sal::where([
            'tahun' => $data['ths']
        ])->get();
        $sumSALA = 0;
        foreach ($getSALAwal as $jmlSAL) {
            switch ($jmlSAL['key']) {
                case 'sal_awal':
                    $sumSALA = $sumSALA + $jmlSAL['jumlah'];
                    break;
                case 'penggunaan_sal':
                    $sumSALA = $sumSALA - $jmlSAL['jumlah'];
                    break;
                case 'sisa_pembiayaan_anggaran':
                    $sumSALA = $sumSALA + $jmlSAL['jumlah'];
                    break;
                case 'koreksi_sal_tahun_sebelum':
                    $sumSALA = $sumSALA + $jmlSAL['jumlah'];
                    break;
                case 'lain_lain':
                    $sumSALA = $sumSALA + $jmlSAL['jumlah'];
                    break;
            }
        }

        Sal::updateOrCreate([
            'key'       => 'sal_awal',
            'tahun'     => $data['tha']
        ], [
            'key'       => 'sal_awal',
            'jumlah'    => $sumSALA,
            'tahun'     => $data['tha']
        ]);

        $getSALNow = Sal::where([
            'tahun' => $data['tha']
        ])->get()->toArray();
        $dataEN = [];
        foreach ($getSALNow as $valEN) {
            $dataEN[$valEN['key']] = $valEN['jumlah'];
        }

        $getSALBefore = Sal::where([
            'tahun' => $data['ths']
        ])->get()->toArray();
        $dataEB = [];
        foreach ($getSALBefore as $valEB) {
            $dataEB[$valEB['key']] = $valEB['jumlah'];
        }

        if (isset($post['excel'])) {
            Excel::load('laporan/SAL.xlsx', function ($doc) use ($data, $dataEN, $dataEB) {
                $doc->sheet('Sheet1', function ($sheet) use ($data, $dataEN, $dataEB) {
                    $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                    $sheet->setCellValue('C6', $data['tha']);
                    $sheet->setCellValue('D6', $data['ths']);

                    $sheet->setCellValue('C7', $dataEN['sal_awal'] ?? 0);
                    $sheet->setCellValue('D7', $dataEB['sal_awal'] ?? 0);

                    $sheet->setCellValue('C8', $dataEN['penggunaan_sal'] ?? 0);
                    $sheet->setCellValue('D8', $dataEB['penggunaan_sal'] ?? 0);

                    $sheet->setCellValue('C9', ($dataEN['sal_awal'] ?? 0) - ($dataEN['penggunaan_sal'] ?? 0));
                    $sheet->setCellValue('D9', ($dataEB['sal_awal'] ?? 0) - ($dataEB['penggunaan_sal'] ?? 0));

                    $sheet->setCellValue('C10', $dataEN['sisa_pembiayaan_anggaran'] ?? 0);
                    $sheet->setCellValue('D10', $dataEB['sisa_pembiayaan_anggaran'] ?? 0);

                    $sheet->setCellValue('C11', (($dataEN['sal_awal'] ?? 0) - ($dataEN['penggunaan_sal'] ?? 0)) + ($dataEN['sisa_pembiayaan_anggaran'] ?? 0));
                    $sheet->setCellValue('D11', (($dataEB['sal_awal'] ?? 0) - ($dataEB['penggunaan_sal'] ?? 0)) + ($dataEB['sisa_pembiayaan_anggaran'] ?? 0));

                    $sheet->setCellValue('C12', $dataEN['koreksi_sal_tahun_sebelum'] ?? 0);
                    $sheet->setCellValue('D12', $dataEB['koreksi_sal_tahun_sebelum'] ?? 0);

                    $sheet->setCellValue('C13', $dataEN['lain_lain'] ?? 0);
                    $sheet->setCellValue('D13', $dataEB['lain_lain'] ?? 0);

                    $sheet->setCellValue('C14', ((($dataEN['sal_awal'] ?? 0) - ($dataEN['penggunaan_sal'] ?? 0)) + ($dataEN['sisa_pembiayaan_anggaran'] ?? 0)) + ($dataEN['koreksi_sal_tahun_sebelum'] ?? 0) + ($dataEN['lain_lain'] ?? 0));
                    $sheet->setCellValue('D14', ((($dataEB['sal_awal'] ?? 0) - ($dataEB['penggunaan_sal'] ?? 0)) + ($dataEB['sisa_pembiayaan_anggaran'] ?? 0)) + ($dataEB['koreksi_sal_tahun_sebelum'] ?? 0) + ($dataEB['lain_lain'] ?? 0));
                });
            })->download('xlsx');
        } else {
            $data['data']   = [[
                'nama'      => 'Saldo Anggaran Lebih Awal',
                'now'       => $dataEN['sal_awal'] ?? 0,
                'before'    => $dataEB['sal_awal'] ?? 0
            ], [
                'nama'      => 'Penggunaan SAL',
                'now'       => $dataEN['penggunaan_sal'] ?? 0,
                'before'    => $dataEB['penggunaan_sal'] ?? 0
            ], [
                'nama'      => '&emsp;Subtotal (1 - 2)',
                'now'       => ($dataEN['sal_awal'] ?? 0) - ($dataEN['penggunaan_sal'] ?? 0),
                'before'    => ($dataEB['sal_awal'] ?? 0) - ($dataEB['penggunaan_sal'] ?? 0)
            ], [
                'nama'      => 'Sisa Lebih/Kurang Pembiayaan Anggaran (SiLPA/SiKPA)',
                'now'       => $dataEN['sisa_pembiayaan_anggaran'] ?? 0,
                'before'    => $dataEB['sisa_pembiayaan_anggaran'] ?? 0
            ], [
                'nama'      => '&emsp;Subtotal (3 + 4)',
                'now'       => (($dataEN['sal_awal'] ?? 0) - ($dataEN['penggunaan_sal'] ?? 0)) + ($dataEN['sisa_pembiayaan_anggaran'] ?? 0),
                'before'    => (($dataEB['sal_awal'] ?? 0) - ($dataEB['penggunaan_sal'] ?? 0)) + ($dataEB['sisa_pembiayaan_anggaran'] ?? 0)
            ], [
                'nama'      => 'Koreksi Kesalahan Pembukuan Tahun Sebelumnya',
                'now'       => $dataEN['koreksi_sal_tahun_sebelum'] ?? 0,
                'before'    => $dataEB['koreksi_sal_tahun_sebelum'] ?? 0
            ], [
                'nama'      => 'Lain-lain',
                'now'       => $dataEN['lain_lain'] ?? 0,
                'before'    => $dataEB['lain_lain'] ?? 0
            ], [
                'nama'      => '&emsp;Saldo Anggaran Lebih Akhir (5 + 6 + 7)',
                'now'       => ((($dataEN['sal_awal'] ?? 0) - ($dataEN['penggunaan_sal'] ?? 0)) + ($dataEN['sisa_pembiayaan_anggaran'] ?? 0)) + ($dataEN['koreksi_sal_tahun_sebelum'] ?? 0) + ($dataEN['lain_lain'] ?? 0),
                'before'    => ((($dataEB['sal_awal'] ?? 0) - ($dataEB['penggunaan_sal'] ?? 0)) + ($dataEB['sisa_pembiayaan_anggaran'] ?? 0)) + ($dataEB['koreksi_sal_tahun_sebelum'] ?? 0) + ($dataEB['lain_lain'] ?? 0)
            ]];

            return view('accounting::laporan.sal.index', $data);
        }
    }

    public function save_lap_sal(Request $request)
    {
        $post = $request->except('_token');

        foreach ($post as $key => $val) {
            if ($key != 'tahun') {
                Sal::updateOrCreate([
                    'key'       => $key,
                    'tahun'     => $post['tahun']
                ], [
                    'key'       => $key,
                    'jumlah'    => $val,
                    'tahun'     => $post['tahun']
                ]);
            }
        }

        return redirect()->route('laporan.sal');
    }

    public function lap_umur_piutang(Request $request)
    {
        $post = $request->except('_token');

        $getPiutang = JournalDetail::select('akutansi_journals.*', 'akutansi_journal_details.*', 'akutansi_journals.keterangan as ket')->join('akutansi_journals', 'akutansi_journal_details.id_journal', 'akutansi_journals.id')
            ->join('akutansi_akun_coas', 'akutansi_journal_details.id_akun_coa', 'akutansi_akun_coas.id')
            ->orderBy('akutansi_journals.id', 'ASC')
            ->where('akutansi_akun_coas.code', '1130414');
        if (!empty($post)) {
            $getPiutang = $getPiutang->where('akutansi_journals.created_at', '>=', date('Y-m-d', strtotime($post['tga'])))
                ->where('akutansi_journals.created_at', '<=', date('Y-m-d', strtotime($post['tgs'])));
        } else {
            $getPiutang = $getPiutang->where('akutansi_journals.created_at', date('Y-m-d'));
        }
        $getPiutang = $getPiutang->groupBy('akutansi_journals.id')->get()->toArray();

        if (isset($post['excel'])) {
            $datea = explode('-', $post['tga']);
            $dates = explode('-', $post['tgs']);

            $i = 0;
            $totalTrx = 0;
            foreach ($getPiutang as $d) {
                $totalTrx = $totalTrx + $d['total_transaksi'];

                $export['data'][$i] = [
                    'date'          => date('H:i d-m-Y', strtotime($d['created_at'])),
                    'code'          => $d['code'],
                    'keterangan'    => $d['keterangan'],
                    'akun'          => '',
                    'transaksi'     => $d['total_transaksi']
                ];
                $i++;
            }
            $export['total'] = [
                'date'          => '',
                'code'          => '',
                'keterangan'    => 'Total',
                'akun'          => '',
                'transaksi'     => $totalTrx
            ];
            Excel::load('laporan/Jurnal Penerimaan.xlsx', function ($doc) use ($export, $datea, $dates) {
                $doc->sheet('Sheet1', function ($sheet) use ($export, $datea, $dates) {
                    $sheet->setCellValue('A3', "Periode " . $datea[0] . " " . $this->monthIndonesia($datea[1]) . " " . $datea[2] . " sampai " . $dates[0] . " " . $this->monthIndonesia($dates[1]) . " " . $datea[2]);
                    $k = 8;
                    foreach ($export['data'] as $exp) {
                        $sheet->setCellValue('A' . $k, $exp['date']);
                        $sheet->setCellValue('B' . $k, $exp['code']);
                        $sheet->setCellValue('C' . $k, $exp['keterangan']);
                        $sheet->setCellValue('D' . $k, $exp['transaksi']);
                        $sheet->cell('A' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('B' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('C' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->cell('D' . $k, function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $k++;
                    }
                    $k = $k + 1;
                    $sheet->setCellValue('A' . $k, 'Total');
                    $sheet->setCellValue('D' . $k, $export['total']['transaksi']);

                    $k = $k + 2;
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, 'Kuningan, ');

                    $k = $k + 2;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, 'Mengetahui,');

                    $k = $k + 1;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, 'Direktur ' .configrs()->nama);
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, 'Bendahara Penerimaan');

                    $k = $k + 7;
                    $sheet->mergeCells('A' . $k . ':B' . $k);
                    $sheet->setCellValue('A' . $k, '_________________________');
                    $sheet->mergeCells('C' . $k . ':D' . $k);
                    $sheet->setCellValue('C' . $k, '_________________________');

                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
        } else {
            $data['cara_bayar']['semua']        = 'Semua';
            $data['cara_bayar']['bpjs']         = 'JKN';
            $data['cara_bayar']['umum']         = 'Umum';
            $data['cara_bayar']['jamkesda']     = 'Jamkesda';
            $data['cara_bayar']['jasa_rahaja']  = 'Jasa Raharja';
            $data['cara_bayar']['jampersal']    = 'Jampersal';
            $data['cara_bayar']['asuransi']     = 'Asuransi';
            $data['data']                       = $getPiutang;
            return view('accounting::laporan.umur_piutang.index', $data);
        }
    }

    public function lap_penyusutan_piutang(Request $request)
    {
        $post = $request->except('_token');

        $getPenyusutan = Carabayar::with('penyisihanpiutang.pengurangan')->get()->toArray();
        $getTotalUmum = PenyisihanPiutang::select(
            'akutansi_penyisihan_piutang.tahun',
            'akutansi_penyisihan_piutang.saldo_piutang',
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.penyisihan), 0) AS penyisihan'),
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.penghapusan), 0) AS penghapusan'),
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.penambahan), 0) AS penambahan'),
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.pembayaran), 0) AS pembayaran')
        )
            ->leftJoin('akutansi_pengurangan_piutang', 'akutansi_penyisihan_piutang.id', 'akutansi_pengurangan_piutang.akutansi_penyisihan_piutang_id')
            ->where('cara_bayar_id', 2)->groupBy('akutansi_penyisihan_piutang.tahun')->get()->toArray();
        $getTotalAsuransi = PenyisihanPiutang::select(
            'akutansi_penyisihan_piutang.tahun',
            'akutansi_penyisihan_piutang.saldo_piutang',
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.penyisihan), 0) AS penyisihan'),
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.penghapusan), 0) AS penghapusan'),
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.penambahan), 0) AS penambahan'),
            DB::raw('COALESCE(SUM(akutansi_pengurangan_piutang.pembayaran), 0) AS pembayaran')
        )
            ->leftJoin('akutansi_pengurangan_piutang', 'akutansi_penyisihan_piutang.id', 'akutansi_pengurangan_piutang.akutansi_penyisihan_piutang_id')
            ->where('cara_bayar_id', '!=', 2)->groupBy('akutansi_penyisihan_piutang.tahun')->get()->toArray();
        // return $getTotalUmum;
        if (isset($post['excel'])) {
            if ($post['excel'] == 'Penyisihan') {
                Excel::load('laporan/Penyisihan Piutang.xlsx', function ($doc) use ($getTotalUmum, $getTotalAsuransi, $getPenyusutan) {
                    $doc->sheet('Sheet1', function ($sheet) use ($getPenyusutan) {
                        $sheet->setCellValue('A3', "PER 31 DESEMBER TAHUN " . date('Y'));
                        $sheet->setCellValue('H5', "PEMBAYARAN PIUTANG TAHUN " . date('Y'));
                        $sheet->setCellValue('I5', "SISA PIUTANG PER 31 DESEMBER " . date('Y'));
                        $sheet->setCellValue('J5', "PENYISIHAN PIUTANG TAHUN " . date('Y'));
                        $sheet->setCellValue('L5', "BEBAN PENYISIHAN PIUTANG PER 31 DESEMBER " . date('Y'));

                        $k = 7;
                        $i = 1;
                        foreach ($getPenyusutan as $exp) {
                            $sheet->setCellValue('A' . $k, $i++);
                            $sheet->setCellValue('B' . $k, $exp['carabayar']);
                            if (isset($exp['saldo_piutang'])) {
                                $sheet->setCellValue('C' . $k, $exp['saldo_piutang']);
                            } else {
                                $sheet->setCellValue('C' . $k, '');
                            }

                            $sheet->setCellValue('D' . $k, '');
                            $sheet->setCellValue('E' . $k, '');
                            $sheet->setCellValue('F' . $k, '');
                            $sheet->setCellValue('G' . $k, '');
                            $sheet->setCellValue('H' . $k, '');
                            $sheet->setCellValue('I' . $k, '');
                            $sheet->setCellValue('J' . $k, '');
                            $sheet->setCellValue('K' . $k, '');
                            $sheet->setCellValue('L' . $k, '');

                            $styleBold = array(
                                'font' => array(
                                    'bold' => true
                                )
                            );
                            $sheet->getStyle('A' . $k . ':L' . $k)->applyFromArray($styleBold);
                            $sheet->cell('A' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('B' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('C' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('D' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('E' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('F' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('G' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('H' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('I' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('J' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('K' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('L' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $k++;
                            if ($exp['penyisihanpiutang']) {
                                foreach ($exp['penyisihanpiutang'] as $pp) {
                                    $sheet->setCellValue('A' . $k, '');
                                    $sheet->setCellValue('B' . $k, $pp['tahun']);
                                    $sheet->setCellValue('C' . $k, $pp['saldo_piutang']);
                                    if ($pp['pengurangan']) {
                                        $sheet->setCellValue('D' . $k, $pp['pengurangan']['penyisihan']);
                                        $sheet->setCellValue('E' . $k, $pp['pengurangan']['penghapusan']);
                                        $sheet->setCellValue('F' . $k, $pp['pengurangan']['penambahan']);
                                        $sheet->setCellValue('G' . $k, $pp['saldo_piutang'] + $pp['pengurangan']['penambahan']);
                                        $sheet->setCellValue('H' . $k, $pp['pengurangan']['pembayaran']);
                                        $sheet->setCellValue('I' . $k, ($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']);
                                        if ((date('Y') - $pp['tahun']) > 5) {
                                            $sheet->setCellValue('J' . $k, '100%');
                                            $sheet->setCellValue('K' . $k, ($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']);
                                            $sheet->setCellValue('L' . $k, 0);
                                        } elseif ((date('Y') - $pp['tahun']) > 2) {
                                            $sheet->setCellValue('J' . $k, '50%');
                                            $sheet->setCellValue('K' . $k, (($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']) * (50 / 100));
                                            $sheet->setCellValue('L' . $k, ((($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']) * (50 / 100)) - $pp['pengurangan']['penyisihan']);
                                        } elseif ((date('Y') - $pp['tahun']) > 1) {
                                            $sheet->setCellValue('J' . $k, '10%');
                                            $sheet->setCellValue('K' . $k, (($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']) * (10 / 100));
                                            $sheet->setCellValue('L' . $k, ((($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']) * (10 / 100)) - $pp['pengurangan']['penyisihan']);
                                        } else {
                                            $sheet->setCellValue('J' . $k, '5%');
                                            $sheet->setCellValue('K' . $k, (($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']) * (5 / 100));
                                            $sheet->setCellValue('L' . $k, ((($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran']) * (5 / 100)) - $pp['pengurangan']['penyisihan']);
                                        }
                                    } else {
                                        $sheet->setCellValue('D' . $k, '');
                                        $sheet->setCellValue('E' . $k, '');
                                        $sheet->setCellValue('F' . $k, '');
                                        $sheet->setCellValue('G' . $k, '');
                                        $sheet->setCellValue('H' . $k, '');
                                        $sheet->setCellValue('I' . $k, '');
                                        if ((date('Y') - $pp['tahun']) > 5) {
                                            $sheet->setCellValue('J' . $k, '100%');
                                            $sheet->setCellValue('K' . $k, $pp['saldo_piutang']);
                                            $sheet->setCellValue('L' . $k, 0);
                                        } elseif ((date('Y') - $pp['tahun']) > 2) {
                                            $sheet->setCellValue('J' . $k, '50%');
                                            $sheet->setCellValue('K' . $k, ($pp['saldo_piutang']) * (50 / 100));
                                            $sheet->setCellValue('L' . $k, ($pp['saldo_piutang']) * (50 / 100));
                                        } elseif ((date('Y') - $pp['tahun']) > 1) {
                                            $sheet->setCellValue('J' . $k, '10%');
                                            $sheet->setCellValue('K' . $k, ($pp['saldo_piutang']) * (10 / 100));
                                            $sheet->setCellValue('L' . $k, ($pp['saldo_piutang']) * (10 / 100));
                                        } else {
                                            $sheet->setCellValue('J' . $k, '5%');
                                            $sheet->setCellValue('K' . $k, ($pp['saldo_piutang']) * (5 / 100));
                                            $sheet->setCellValue('L' . $k, ($pp['saldo_piutang']) * (5 / 100));
                                        }
                                    }
                                    $sheet->cell('A' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('B' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('C' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('D' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('E' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('F' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('G' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('H' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('I' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('J' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('K' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $sheet->cell('L' . $k, function ($cells) {
                                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                                    });
                                    $k++;
                                }
                            }

                            $sheet->setCellValue('A' . $k, '');
                            $sheet->setCellValue('B' . $k, '');
                            $sheet->setCellValue('C' . $k, '');
                            $sheet->setCellValue('D' . $k, '');
                            $sheet->setCellValue('E' . $k, '');
                            $sheet->setCellValue('F' . $k, '');
                            $sheet->setCellValue('G' . $k, '');
                            $sheet->setCellValue('H' . $k, '');
                            $sheet->setCellValue('I' . $k, '');
                            $sheet->setCellValue('J' . $k, '');
                            $sheet->setCellValue('K' . $k, '');
                            $sheet->setCellValue('L' . $k, '');
                            $sheet->cell('A' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('B' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('C' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('D' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('E' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('F' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('G' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('H' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('I' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('J' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('K' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell('L' . $k, function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $k++;
                        }

                        $k = $k + 2;
                        $sheet->mergeCells('C' . $k . ':D' . $k);
                        $sheet->setCellValue('C' . $k, 'Mengetahui,');
                        $sheet->mergeCells('G' . $k . ':I' . $k);
                        $sheet->setCellValue('G' . $k, 'Kuningan, ');

                        $k = $k + 1;
                        $sheet->mergeCells('C' . $k . ':D' . $k);
                        $sheet->setCellValue('C' . $k, 'Ka. Bag. Keuangan');
                        $sheet->mergeCells('G' . $k . ':I' . $k);
                        $sheet->setCellValue('G' . $k, 'Ka. Sub. Bag. Akuntansi dan Verifikasi');

                        $k = $k + 5;
                        $sheet->mergeCells('C' . $k . ':D' . $k);
                        $sheet->setCellValue('C' . $k, '_________________________');
                        $sheet->mergeCells('G' . $k . ':I' . $k);
                        $sheet->setCellValue('G' . $k, '_________________________');
                    });
                })->download('xlsx');
            } else {
                Excel::load('laporan/Klasifikasi Piutang.xlsx', function ($doc) use ($getTotalUmum, $getTotalAsuransi) {
                    $doc->sheet('Sheet1', function ($sheet) use ($getTotalUmum, $getTotalAsuransi) {
                        $sheet->setCellValue('A3', "PER 31 DESEMBER TAHUN " . date('Y'));
                        $sheet->setCellValue('F5', "PEMBAYARAN PIUTANG TAHUN " . date('Y'));
                        $sheet->setCellValue('G5', "SISA PIUTANG PER 31 DESEMBER " . date('Y'));
                        $sheet->setCellValue('H5', "PENYISIHAN PIUTANG TAHUN " . date('Y'));
                        $sheet->setCellValue('J5', "BEBAN PENYISIHAN PIUTANG PER 31 DESEMBER " . date('Y'));

                        $tuSP5 = $tuPK5 = $tuPP5 = $tuPPT5 = $tuSPP5 = $tuTJ5 = $tuBPP5 = 0;
                        $tuSP2 = $tuPK2 = $tuPP2 = $tuPPT2 = $tuSPP2 = $tuTJ2 = $tuBPP2 = 0;
                        $tuSP1 = $tuPK1 = $tuPP1 = $tuPPT1 = $tuSPP1 = $tuTJ1 = $tuBPP1 = 0;
                        $tuSP0 = $tuPK0 = $tuPP0 = $tuPPT0 = $tuSPP0 = $tuTJ0 = $tuBPP0 = 0;
                        foreach ($getTotalUmum as $tu) {
                            if ((date('Y') - $tu['tahun']) > 5) {
                                $tuSP5 = $tuSP5 + $tu['saldo_piutang'];
                                $tuPK5 = $tuPK5 + $tu['penambahan'];
                                $tuPP5 = $tuPP5 + $tu['penghapusan'];
                                $tuPPT5 = $tuPPT5 + $tu['pembayaran'];
                                $tuSPP5 = $tuSPP5 + (($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran']));
                                $tuTJ5 = $tuTJ5 + (($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran']));
                                $sheet->setCellValue('C8', $tuSP5);
                                $sheet->setCellValue('D8', $tuPK5);
                                $sheet->setCellValue('E8', $tuPP5);
                                $sheet->setCellValue('F8', $tuPPT5);
                                $sheet->setCellValue('G8', $tuSPP5);
                                $sheet->setCellValue('I8', $tuTJ5);
                                $sheet->setCellValue('J8', $tuBPP5);
                            } elseif ((date('Y') - $tu['tahun']) > 2) {
                                $tuSP2 = $tuSP2 + $tu['saldo_piutang'];
                                $tuPK2 = $tuPK2 + $tu['penambahan'];
                                $tuPP2 = $tuPP2 + $tu['penghapusan'];
                                $tuPPT2 = $tuPPT2 + $tu['pembayaran'];
                                $tuSPP2 = $tuSPP2 + (($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran']));
                                $tuTJ2 = $tuTJ2 + ((($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran'])) * (50 / 100));
                                $tuBPP2 = $tuBPP2 + ((($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran'])) * (50 / 100));
                                $sheet->setCellValue('C9', $tuSP2);
                                $sheet->setCellValue('D9', $tuPK2);
                                $sheet->setCellValue('E9', $tuPP2);
                                $sheet->setCellValue('F9', $tuPPT2);
                                $sheet->setCellValue('G9', $tuSPP2);
                                $sheet->setCellValue('I9', $tuTJ2);
                                $sheet->setCellValue('J9', $tuBPP2);
                            } elseif ((date('Y') - $tu['tahun']) > 1) {
                                $tuSP1 = $tuSP1 + $tu['saldo_piutang'];
                                $tuPK1 = $tuPK1 + $tu['penambahan'];
                                $tuPP1 = $tuPP1 + $tu['penghapusan'];
                                $tuPPT1 = $tuPPT1 + $tu['pembayaran'];
                                $tuSPP1 = $tuSPP1 + (($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran']));
                                $tuTJ1 = $tuTJ1 + ((($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran'])) * (10 / 100));
                                $tuBPP1 = $tuBPP1 + ((($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran'])) * (90 / 100));
                                $sheet->setCellValue('C10', $tuSP1);
                                $sheet->setCellValue('D10', $tuPK1);
                                $sheet->setCellValue('E10', $tuPP1);
                                $sheet->setCellValue('F10', $tuPPT1);
                                $sheet->setCellValue('G10', $tuSPP1);
                                $sheet->setCellValue('I10', $tuTJ1);
                                $sheet->setCellValue('J10', $tuBPP1);
                            } else {
                                $tuSP0 = $tuSP0 + $tu['saldo_piutang'];
                                $tuPK0 = $tuPK0 + $tu['penambahan'];
                                $tuPP0 = $tuPP0 + $tu['penghapusan'];
                                $tuPPT0 = $tuPPT0 + $tu['pembayaran'];
                                $tuSPP0 = $tuSPP0 + (($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran']));
                                $tuTJ0 = $tuTJ0 + ((($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran'])) * (5 / 100));
                                $tuBPP0 = $tuBPP0 + ((($tu['saldo_piutang'] + $tu['penambahan']) - ($tu['penghapusan'] + $tu['pembayaran'])) * (95 / 100));
                                $sheet->setCellValue('C11', $tuSP0);
                                $sheet->setCellValue('D11', $tuPK0);
                                $sheet->setCellValue('E11', $tuPP0);
                                $sheet->setCellValue('F11', $tuPPT0);
                                $sheet->setCellValue('G11', $tuSPP0);
                                $sheet->setCellValue('I11', $tuTJ0);
                                $sheet->setCellValue('J11', $tuBPP0);
                            }
                        }

                        $taSP5 = $taPK5 = $taPP5 = $taPPT5 = $taSPP5 = $taTJ5 = $taBPP5 = 0;
                        $taSP2 = $taPK2 = $taPP2 = $taPPT2 = $taSPP2 = $taTJ2 = $taBPP2 = 0;
                        $taSP1 = $taPK1 = $taPP1 = $taPPT1 = $taSPP1 = $taTJ1 = $taBPP1 = 0;
                        $taSP0 = $taPK0 = $taPP0 = $taPPT0 = $taSPP0 = $taTJ0 = $taBPP0 = 0;
                        foreach ($getTotalAsuransi as $ta) {
                            if ((date('Y') - $ta['tahun']) > 5) {
                                $taSP5 = $taSP5 + $ta['saldo_piutang'];
                                $taPK5 = $taPK5 + $ta['penambahan'];
                                $taPP5 = $taPP5 + $ta['penghapusan'];
                                $taPPT5 = $taPPT5 + $ta['pembayaran'];
                                $taSPP5 = $taSPP5 + (($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran']));
                                $taTJ5 = $taTJ5 + (($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran']));
                                $sheet->setCellValue('C16', $taSP5);
                                $sheet->setCellValue('D16', $taPK5);
                                $sheet->setCellValue('E16', $taPP5);
                                $sheet->setCellValue('F16', $taPPT5);
                                $sheet->setCellValue('G16', $taSPP5);
                                $sheet->setCellValue('I16', $taTJ5);
                                $sheet->setCellValue('J16', $taBPP5);
                            } elseif ((date('Y') - $ta['tahun']) > 2) {
                                $taSP2 = $taSP2 + $ta['saldo_piutang'];
                                $taPK2 = $taPK2 + $ta['penambahan'];
                                $taPP2 = $taPP2 + $ta['penghapusan'];
                                $taPPT2 = $taPPT2 + $ta['pembayaran'];
                                $taSPP2 = $taSPP2 + (($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran']));
                                $taTJ2 = $taTJ2 + ((($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran'])) * (50 / 100));
                                $taBPP2 = $taBPP2 + ((($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran'])) * (50 / 100));
                                $sheet->setCellValue('C17', $taSP2);
                                $sheet->setCellValue('D17', $taPK2);
                                $sheet->setCellValue('E17', $taPP2);
                                $sheet->setCellValue('F17', $taPPT2);
                                $sheet->setCellValue('G17', $taSPP2);
                                $sheet->setCellValue('I17', $taTJ2);
                                $sheet->setCellValue('J17', $taBPP2);
                            } elseif ((date('Y') - $ta['tahun']) > 1) {
                                $taSP1 = $taSP1 + $ta['saldo_piutang'];
                                $taPK1 = $taPK1 + $ta['penambahan'];
                                $taPP1 = $taPP1 + $ta['penghapusan'];
                                $taPPT1 = $taPPT1 + $ta['pembayaran'];
                                $taSPP1 = $taSPP1 + (($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran']));
                                $taTJ1 = $taTJ1 + ((($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran'])) * (10 / 100));
                                $taBPP1 = $taBPP1 + ((($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran'])) * (90 / 100));
                                $sheet->setCellValue('C18', $taSP1);
                                $sheet->setCellValue('D18', $taPK1);
                                $sheet->setCellValue('E18', $taPP1);
                                $sheet->setCellValue('F18', $taPPT1);
                                $sheet->setCellValue('G18', $taSPP1);
                                $sheet->setCellValue('I18', $taTJ1);
                                $sheet->setCellValue('J18', $taBPP1);
                            } else {
                                $taSP0 = $taSP0 + $ta['saldo_piutang'];
                                $taPK0 = $taPK0 + $ta['penambahan'];
                                $taPP0 = $taPP0 + $ta['penghapusan'];
                                $taPPT0 = $taPPT0 + $ta['pembayaran'];
                                $taSPP0 = $taSPP0 + (($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran']));
                                $taTJ0 = $taTJ0 + ((($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran'])) * (5 / 100));
                                $taBPP0 = $taBPP0 + ((($ta['saldo_piutang'] + $ta['penambahan']) - ($ta['penghapusan'] + $ta['pembayaran'])) * (95 / 100));
                                $sheet->setCellValue('C19', $taSP0);
                                $sheet->setCellValue('D19', $taPK0);
                                $sheet->setCellValue('E19', $taPP0);
                                $sheet->setCellValue('F19', $taPPT0);
                                $sheet->setCellValue('G19', $taSPP0);
                                $sheet->setCellValue('I19', $taTJ0);
                                $sheet->setCellValue('J19', $taBPP0);
                            }
                        }
                    });
                })->download('xlsx');
            }
        } else {
            $data['data']       = $getPenyusutan;

            $caraBayar = Carabayar::orderBy('id')->get()->toArray();
            foreach ($caraBayar as $value) {
                $data['cara_bayar'][$value['id']] = $value['carabayar'];
            }

            $saldoPiutang = PenyisihanPiutang::with('carabayar')->get()->toArray();
            if ($saldoPiutang) {
                foreach ($saldoPiutang as $value) {
                    $data['saldo_piutang'][$value['id']] = implode(' - ', [$value['tahun'], $value['carabayar']['carabayar'], $value['saldo_piutang']]);
                }
            } else {
                $data['saldo_piutang'] = [];
            }

            return view('accounting::laporan.penyusutan_piutang.index', $data);
        }
    }

    public function save_lap_penyusutan_piutang(Request $request)
    {
        $post = $request->except('_token');

        PenyisihanPiutang::updateOrCreate([
            'tahun'         => $post['tahun'],
            'cara_bayar_id' => $post['cara_bayar_id']
        ], [
            'saldo_piutang' => (is_null($post['saldo_piutang'])) ? 0 : $post['saldo_piutang'],
            'tahun'         => $post['tahun'],
            'cara_bayar_id' => $post['cara_bayar_id']
        ]);

        return redirect()->route('laporan.penyusutan_piutang');
    }

    public function save_lap_pengurangan_piutang(Request $request)
    {
        $post = $request->except('_token');

        PenguranganPiutang::updateOrCreate([
            'akutansi_penyisihan_piutang_id'    => $post['akutansi_penyisihan_piutang_id'],
            'tahun'                             => $post['tahun']
        ], [
            'akutansi_penyisihan_piutang_id'    => $post['akutansi_penyisihan_piutang_id'],
            'tahun'                             => $post['tahun'],
            'penyisihan'                        => $post['penyisihan'],
            'penghapusan'                       => $post['penghapusan'],
            'penambahan'                        => $post['penambahan'],
            'pembayaran'                        => $post['pembayaran']
        ]);

        return redirect()->route('laporan.penyusutan_piutang');
    }
}
