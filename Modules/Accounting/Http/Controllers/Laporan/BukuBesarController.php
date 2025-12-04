<?php

namespace Modules\Accounting\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\Master\AkunCOA;
use Excel;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Journal;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['excel'])) {
            $getAkun = AkunCOA::where('status', 1)->where('id', $post['excel'])->get()->toArray();
        } else {
            $getAkun = AkunCOA::where('status', 1)->where('akun_code_9', '!=', '0')->get()->toArray();
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
                $getData['data'][$i]            = $value;
                $getData['data'][$i]['detail']  = $getJournal;
                $saldo          = 0;
                $totalDebit     = 0;
                $totalCredit    = 0;
                $totalSaldo     = 0;
                foreach ($getJournal as $kj => $journal) {
                    // if ($value['saldo_normal'] == 'debit') {
                    //     $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                    // } else {
                    //     $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                    // }
                    $saldo = $saldo + ($journal['debit'] - $journal['credit']);
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
                            $sheet->setCellValue('A' . $k, 'Direktur .configrs()->nama');
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
        return view('accounting::laporan.buku_besar.index', $getData);
    }

    public function export(Request $request)
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
                    $getData['data'][$i]            = $value;
                    $getData['data'][$i]['detail']  = $getJournal;
                    $saldo          = 0;
                    $totalDebit     = 0;
                    $totalCredit    = 0;
                    $totalSaldo     = 0;
                    foreach ($getJournal as $kj => $journal) {
                        $tanggal = explode(' ', $journal['tanggal']);
                        // if ($value['saldo_normal'] == 'debit') {
                        //     $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                        // } else {
                        //     $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                        // }
                        $saldo = $saldo + ($journal['debit'] - $journal['credit']);
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
                            $sheet->setCellValue('A' . $k, 'Direktur .configrs()->nama');
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
                    $saldo          = 0;
                    $totalDebit     = 0;
                    $totalCredit    = 0;
                    $totalSaldo     = 0;
                    foreach ($getJournal as $kj => $journal) {
                        $tanggal = explode(' ', $journal['tanggal']);
                        // if ($value['saldo_normal'] == 'debit') {
                        //     $saldo = $saldo + $journal['debit'];
                        // } else {
                        //     $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                        // }
                        $saldo = $saldo + ($journal['debit'] - $journal['credit']);
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
                            $sheet->setCellValue('A' . $k, 'Direktur '.configrs()->nama);
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

    public function pembantu(Request $request)
    {
        $post = $request->except('_token');

        if (isset($post['excel'])) {
            $getAkun = AkunCOA::where('status', 1)->where('id', $post['excel'])->get()->toArray();
        } else {
            $getAkun = AkunCOA::where('status', 1)->where('code', 'like', '101201%')->where('akun_code_9', '!=', '0')->get()->toArray();
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
                $getData['data'][$i]            = $value;
                $getData['data'][$i]['detail']  = $getJournal;
                $saldo          = 0;
                $totalDebit     = 0;
                $totalCredit    = 0;
                $totalSaldo     = 0;
                foreach ($getJournal as $kj => $journal) {
                    // if ($value['saldo_normal'] == 'debit') {
                    //     $saldo = $saldo + ($journal['debit'] - $journal['credit']);
                    // } else {
                    //     $saldo = $saldo + ($journal['credit'] - $journal['debit']);
                    // }
                    $saldo = $saldo + ($journal['debit'] - $journal['credit']);
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
                            $sheet->setCellValue('A' . $k, 'Direktur .configrs()->nama');
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
        return view('accounting::laporan.buku_besar.pembantu', $getData);
    }
}