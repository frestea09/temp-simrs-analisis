<?php

namespace Modules\Accounting\Helpers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\JournalDetail;

class Helper extends Controller
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
        $codeCoa = str_split($code);

        if (isset($codeCoa[5])) {
            $val = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4] . "." . $codeCoa[5] . $codeCoa[6];
        } elseif (isset($codeCoa[3])) {
            $val = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2] . "." . $codeCoa[3] . $codeCoa[4];
        } elseif (isset($codeCoa[2])) {
            $val = $codeCoa[0] . "." . $codeCoa[1] . "." . $codeCoa[2];
        } elseif (isset($codeCoa[1])) {
            $val = $codeCoa[0] . "." . $codeCoa[1];
        } else {
            $val = $codeCoa[0];
        }

        return $val;
    }

    public static function getPerhitungan($tahun, $level, $code)
    {
        $anggaran = JournalDetail::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit - akutansi_journal_details.credit), 0) AS total'))
            ->join('akutansi_journals', 'akutansi_journal_details.id_journal', 'akutansi_journals.id')
            ->join('akutansi_akun_coas', 'akutansi_journal_details.id_akun_coa', 'akutansi_akun_coas.id')
            ->where([
                'akutansi_journal_details.type'         => 'anggaran',
                'akutansi_journals.tanggal'             => $tahun . '-01-01',
                'akutansi_journals.verifikasi'          => 1
            ]);
        $realisasi = JournalDetail::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit - akutansi_journal_details.credit), 0) AS total'))
            ->join('akutansi_journals', 'akutansi_journal_details.id_journal', 'akutansi_journals.id')
            ->join('akutansi_akun_coas', 'akutansi_journal_details.id_akun_coa', 'akutansi_akun_coas.id')
            ->where([
                'akutansi_journals.verifikasi'          => 1
            ])->where('akutansi_journal_details.type', '!=', 'anggaran')
            ->where('akutansi_journals.tanggal', 'LIKE', $tahun . '%');
        $realisasi_sebelum = JournalDetail::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit - akutansi_journal_details.credit), 0) AS total'))
            ->join('akutansi_journals', 'akutansi_journal_details.id_journal', 'akutansi_journals.id')
            ->join('akutansi_akun_coas', 'akutansi_journal_details.id_akun_coa', 'akutansi_akun_coas.id')
            ->where([
                'akutansi_journals.verifikasi'          => 1
            ])->where('akutansi_journal_details.type', '!=', 'anggaran')
            ->where('akutansi_journals.tanggal', 'LIKE', (int) $tahun - 1 . '%');

        $anggaran->where('akutansi_akun_coas.code', 'like', $code . '%');
        $realisasi->where('akutansi_akun_coas.code', 'like', $code . '%');
        $realisasi_sebelum->where('akutansi_akun_coas.code', 'like', $code . '%');

        return [
            'anggaran'          => (is_null($anggaran->first())) ? 0 : (int) $anggaran->first()->total,
            'realisasi'         => (is_null($realisasi->first())) ? 0 : (int) $realisasi->first()->total,
            'realisasi_sebelum' => (is_null($realisasi_sebelum->first())) ? 0 : (int) $realisasi_sebelum->first()->total,
        ];
    }
}
