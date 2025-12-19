<?php

namespace App\Services;
use Modules\Icd10\Entities\Icd10;
use App\PerawatanIcd10;
use Modules\Poli\Entities\Poli;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Excel;
class SirsRIService
{

    public function generateLaporanImmodialisis($filters = [])
    {
        // Mengambil data ICD10 dengan ID 71-112
        $icd10 = Icd10::where('id', '>=', 71)
            ->where('id', '<=', 112)
            ->pluck('nomor');

        // Default tanggal hari ini jika filter tidak diberikan
        $tanggalMulai = isset($filters['tanggal_mulai']) ? Carbon::parse($filters['tanggal_mulai'])->startOfDay() : Carbon::now()->startOfDay();
        $tanggalAkhir = isset($filters['tanggal_akhir']) ? Carbon::parse($filters['tanggal_akhir'])->endOfDay() : Carbon::now()->endOfDay();

        // Query dasar
        $query = DB::table('perawatan_icd10s')
            ->join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
            // ->whereIn('perawatan_icd10s.icd10', $icd10)
            //  ->limit(10)
            ->whereBetween('registrasis.created_at', [$tanggalMulai, $tanggalAkhir]);

        // Tambahkan filter poli jika ada
        if (!empty($filters['poli'])) {
            $query->where('registrasis.poli_id', '=', $filters['poli']);
        }

        // Tambahkan Filter Rawat Jalan, Rawat Inap, IGD jika ada
        if (!empty($filters['layanan'])) {
            if ($filters['layanan'] == "TI") {
                $query->leftJoin('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id');
                $query->leftJoin('kamars', 'rawatinaps.kamar_id', '=', 'kamars.id');
                // $query->where('kamars.id', '=', $filters['poli']);
                $query->where('perawatan_icd10s.jenis', '=', 'TI');
                // $query->where('kamars.id', '!=', null);
            }
            if ($filters['layanan'] == "TA") {
                $query->where('perawatan_icd10s.jenis', '=', 'TA');
            }
            if ($filters['layanan'] == "TG") {
                $query->where('perawatan_icd10s.jenis', '=', 'TG');
                // dd($query->select('perawatan_icd10s.jenis')->get(), $query->select('perawatan_icd10s.jenis')->get());
            }
        }

        // Pilih kolom yang dibutuhkan
        $query->select(
            'icd10s.nomor as nomor',
            'icd10s.nama as penyakit',
            DB::raw('COUNT(perawatan_icd10s.icd10) as total'),
            DB::raw('SUM(CASE WHEN pasiens.kelamin = "L" THEN 1 ELSE 0 END) as jumlah_laki_laki'),
            DB::raw('SUM(CASE WHEN pasiens.kelamin = "P" THEN 1 ELSE 0 END) as jumlah_perempuan'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(DAY, pasiens.tgllahir, registrasis.created_at) < 28 THEN 1 ELSE 0 END) as Usia_0_28_Hari'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) < 1 
            AND TIMESTAMPDIFF(DAY, pasiens.tgllahir, registrasis.created_at) >= 28 THEN 1 ELSE 0 END) as Usia_28Hari_1Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 1 AND 4 THEN 1 ELSE 0 END) as Usia_1_4_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 5 AND 14 THEN 1 ELSE 0 END) as Usia_5_14_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 15 AND 24 THEN 1 ELSE 0 END) as Usia_15_24_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 25 AND 44 THEN 1 ELSE 0 END) as Usia_25_44_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 45 AND 64 THEN 1 ELSE 0 END) as Usia_45_64_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) >= 65 THEN 1 ELSE 0 END) as Usia_65_Tahun'),
            DB::raw('SUM(CASE WHEN registrasis.pulang NOT IN (8, 9) THEN 1 ELSE 0 END) as Jumlah_Pulang_Biasa'),
            DB::raw('SUM(CASE WHEN registrasis.pulang IN (8, 9) THEN 1 ELSE 0 END) as Jumlah_Pulang_Meninggal'),
            DB::raw('SUM(CASE WHEN perawatan_icd10s.kasus = "lama" THEN 1 ELSE 0 END) as kasus_lama'),
            DB::raw('SUM(CASE WHEN perawatan_icd10s.kasus IN ("baru", "lama") THEN 1 ELSE 0 END) as kasus_total')
        );

        // Tambahkan grouping
        $query->groupBy('icd10s.nomor', 'icd10s.nama')
            ->orderBy('total', 'desc');

        // Pagination
        $irj = $query->get();

        // Mengambil data poli
        $poli = Poli::pluck('nama', 'id');

        return [
            'irj' => $irj,
            'poli' => $poli,
        ];
    }

    public function generateLaporanImmodialisisForExcel($filters = [])
    {
        // Mengambil data ICD10 dengan ID 71-112
        $icd10 = Icd10::where('id', '>=', 71)
            ->where('id', '<=', 112)
            ->pluck('nomor');

        // Default tanggal hari ini jika filter tidak diberikan
        $tanggalMulai = isset($filters['tanggal_mulai']) ? Carbon::parse($filters['tanggal_mulai'])->startOfDay() : Carbon::now()->startOfDay();
        $tanggalAkhir = isset($filters['tanggal_akhir']) ? Carbon::parse($filters['tanggal_akhir'])->endOfDay() : Carbon::now()->endOfDay();

        // Query dasar
        $query = DB::table('perawatan_icd10s')
            ->join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
            // ->limit(10)
            ->whereBetween('registrasis.created_at', [$tanggalMulai, $tanggalAkhir]);
        // ->whereIn('perawatan_icd10s.icd10', $icd10)
        // ->limit(1000);

        // Tambahkan filter poli jika ada
        if (!empty($filters['poli'])) {
            $query->where('registrasis.poli_id', '=', $filters['poli']);
        }

        // Tambahkan Filter Rawat Jalan, Rawat Inap, IGD jika ada
        if (!empty($filters['layanan'])) {
            if ($filters['layanan'] == "TI") {
                $query->where('perawatan_icd10s.jenis', '=', 'TI');
            }
            if ($filters['layanan'] == "TA") {
                $query->where('perawatan_icd10s.jenis', '=', 'TA');
                $query->leftJoin('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id');
                $query->where('rawatinaps.kamar_id', '=', $filters['poli']);
            }
            if ($filters['layanan'] == "TG") {
                $query->where('perawatan_icd10s.jenis', '=', 'TG');
            }
        }

        // Pilih kolom yang dibutuhkan
        $query->select(
            'icd10s.nomor as nomor',
            'icd10s.nama as penyakit',
            DB::raw('COUNT(perawatan_icd10s.icd10) as total'),
            DB::raw('SUM(CASE WHEN pasiens.kelamin = "L" THEN 1 ELSE 0 END) as jumlah_laki_laki'),
            DB::raw('SUM(CASE WHEN pasiens.kelamin = "P" THEN 1 ELSE 0 END) as jumlah_perempuan'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(DAY, pasiens.tgllahir, registrasis.created_at) < 28 THEN 1 ELSE 0 END) as Usia_0_28_Hari'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) < 1 
            AND TIMESTAMPDIFF(DAY, pasiens.tgllahir, registrasis.created_at) >= 28 THEN 1 ELSE 0 END) as Usia_28Hari_1Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 1 AND 4 THEN 1 ELSE 0 END) as Usia_1_4_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 5 AND 14 THEN 1 ELSE 0 END) as Usia_5_14_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 15 AND 24 THEN 1 ELSE 0 END) as Usia_15_24_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 25 AND 44 THEN 1 ELSE 0 END) as Usia_25_44_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) BETWEEN 45 AND 64 THEN 1 ELSE 0 END) as Usia_45_64_Tahun'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) >= 65 THEN 1 ELSE 0 END) as Usia_65_Tahun'),
            DB::raw('SUM(CASE WHEN registrasis.pulang NOT IN (8, 9) THEN 1 ELSE 0 END) as Jumlah_Pulang_Biasa'),
            DB::raw('SUM(CASE WHEN registrasis.pulang IN (8, 9) THEN 1 ELSE 0 END) as Jumlah_Pulang_Meninggal'),
            DB::raw('SUM(CASE WHEN perawatan_icd10s.kasus = "baru" THEN 1 ELSE 0 END) as kasus_baru'),
            DB::raw('SUM(CASE WHEN perawatan_icd10s.kasus = "lama" THEN 1 ELSE 0 END) as kasus_lama'),
            DB::raw('SUM(CASE WHEN perawatan_icd10s.kasus IN ("baru", "lama") THEN 1 ELSE 0 END) as kasus_total')
        );

        // Tambahkan grouping berdasarkan kode ICD
        $query->groupBy('icd10s.nomor', 'icd10s.nama')
            ->orderBy('total', 'desc');

        // Dapatkan semua data
        $irj = $query->get();

        return [
            'irj' => $irj
        ];
    }

    public function exportMorbiditasRawatJalan($dataForExcel)
    {
        return Excel::create('Laporan Morbiditas', function ($excel) use ($dataForExcel) {
            $excel->setTitle('Laporan Morbiditas Rawat Jalan')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan Morbiditas Rawat Jalan');

            $excel->sheet('Laporan', function ($sheet) use ($dataForExcel) {
                // Baris awal
                $row = 1;

                // Header Utama
                $sheet->mergeCells('A1:A2'); // Kolom No
                $sheet->mergeCells('B1:B2'); // Kolom Kode ICD
                $sheet->mergeCells('C1:C2'); // Kolom Golongan Sebab Sakit
                $sheet->mergeCells('D1:K1'); // Kolom Pasien Keluar Menurut Golongan Umur
                $sheet->mergeCells('L1:N1'); // Kolom Pasien Keluar Hidup & Mati Menurut Sex
                $sheet->mergeCells('O1:O2'); // Kolom Jumlah Pasien Keluar
                $sheet->mergeCells('P1:P2'); // Kolom Jumlah Pasien Keluar Mati

                // Header Sub-Header
                $sheet->row($row++, [
                    'No',
                    'Kode ICD',
                    'Golongan Sebab Sakit',
                    'KASUS BARU MENURUT GOLONGAN UMUR',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    'KASUS BARU MENURUT SEX',
                    '',
                    '',
                    'Kasus Lama',
                    'Total'
                ]);

                $sheet->row($row++, [
                    '',
                    '',
                    '',
                    '0-<28 Hari',
                    '28Hr-<1Th',
                    '1-4Th',
                    '5-14Th',
                    '15-24Th',
                    '25-44Th',
                    '45-64Th',
                    '65Th',
                    'Lk', // Pastikan header untuk "Laki-Laki" ada
                    'Pr', // Pastikan header untuk "Perempuan" ada
                    'JML',
                    '',
                    ''
                ]);

                // Data
                $no = 1;
                foreach ($dataForExcel as $key => $d) {
                    $sheet->row($row++, [
                        $no++,
                        @$d->nomor,
                        @$d->penyakit,
                        @$d->Usia_0_28_Hari,
                        @$d->Usia_28Hari_1Tahun,
                        @$d->Usia_1_4_Tahun,
                        @$d->Usia_5_14_Tahun,
                        @$d->Usia_15_24_Tahun,
                        @$d->Usia_25_44_Tahun,
                        @$d->Usia_45_64_Tahun,
                        @$d->Usia_65_Tahun,
                        @$d->jumlah_laki_laki,   // Data Laki-Laki
                        @$d->jumlah_perempuan,  // Data Perempuan
                        @$d->Jumlah_Pulang_Biasa,
                        @$d->kasus_lama,
                        @$d->kasus_total,
                    ]);
                }

                // Styling Header
                $sheet->row(1, function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                $sheet->row(2, function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                // Auto Size Columns
                $sheet->setAutoSize(true);
            });
        })->export('xlsx');
    }
    public function exportMorbiditas($dataForExcel)
    {
        return Excel::create('Laporan Morbiditas', function ($excel) use ($dataForExcel) {
            $excel->setTitle('Laporan Morbiditas Rawat Inap')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan Morbiditas Rawat Inap');

            $excel->sheet('Laporan', function ($sheet) use ($dataForExcel) {
                // Baris awal
                $row = 1;

                // Header Utama
                $sheet->mergeCells('A1:A2'); // Kolom No
                $sheet->mergeCells('B1:B2'); // Kolom Kode ICD
                $sheet->mergeCells('C1:C2'); // Kolom Golongan Sebab Sakit
                $sheet->mergeCells('D1:K1'); // Kolom Pasien Keluar Menurut Golongan Umur
                $sheet->mergeCells('L1:M1'); // Kolom Pasien Keluar Hidup & Mati Menurut Sex
                $sheet->mergeCells('N1:N2'); // Kolom Jumlah Pasien Keluar
                $sheet->mergeCells('O1:O2'); // Kolom Jumlah Pasien Keluar Mati

                // Header Sub-Header
                $sheet->row($row++, [
                    'No',
                    'Kode ICD',
                    'Golongan Sebab Sakit',
                    'Pasien Keluar (Hidup & Mati) Menurut Golongan Umur',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    'Pasien Keluar Hidup & Mati Menurut Sex',
                    '',
                    'Jumlah Pasien Keluar',
                    'Jumlah Pasien Keluar Mati'
                ]);

                $sheet->row($row++, [
                    '',
                    '',
                    '',
                    '0-<28 Hari',
                    '28Hr-<1Th',
                    '1-4Th',
                    '5-14Th',
                    '15-24Th',
                    '25-44Th',
                    '45-64Th',
                    '65Th',
                    'Lk', // Pastikan header untuk "Laki-Laki" ada
                    'Pr', // Pastikan header untuk "Perempuan" ada
                    '',
                    ''
                ]);

                // Data
                $no = 1;
                foreach ($dataForExcel as $key => $d) {
                    $sheet->row($row++, [
                        $no++,
                        @$d->nomor,
                        @$d->penyakit,
                        @$d->Usia_0_28_Hari,
                        @$d->Usia_28Hari_1Tahun,
                        @$d->Usia_1_4_Tahun,
                        @$d->Usia_5_14_Tahun,
                        @$d->Usia_15_24_Tahun,
                        @$d->Usia_25_44_Tahun,
                        @$d->Usia_45_64_Tahun,
                        @$d->Usia_65_Tahun,
                        @$d->jumlah_laki_laki,   // Data Laki-Laki
                        @$d->jumlah_perempuan,  // Data Perempuan
                        @$d->Jumlah_Pulang_Biasa,
                        @$d->Jumlah_Pulang_Meninggal,
                    ]);
                }

                // Styling Header
                $sheet->row(1, function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                $sheet->row(2, function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                // Auto Size Columns
                $sheet->setAutoSize(true);
            });
        })->export('xlsx');
    }
    public function getPatientData($filters = [])
    {
        $tanggalMulai = isset($filters['tanggal_mulai']) ? Carbon::parse($filters['tanggal_mulai'])->startOfDay() : Carbon::now()->startOfDay();
        $tanggalAkhir = isset($filters['tanggal_akhir']) ? Carbon::parse($filters['tanggal_akhir'])->endOfDay() : Carbon::now()->endOfDay();

        return DB::table('hasillabs')
            ->join('registrasis', 'hasillabs.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->leftJoin('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->leftJoin('perawatan_icd10s', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->leftJoin('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
            ->leftJoin('histori_rawatinap', 'histori_rawatinap.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('lica_results', 'hasillabs.no_lab', '=', 'lica_results.no_lab')
            ->leftJoin('villages', 'pasiens.village_id', '=', 'villages.id')
            ->leftJoin('districts', 'pasiens.district_id', '=', 'districts.id')
            ->leftJoin('kamars', 'rawatinaps.kamar_id', '=', 'kamars.id')
            ->leftJoin('polis', 'registrasis.poli_id', '=', 'polis.id')
            ->leftJoin('histori_kunjungan_irj', 'registrasis.id', '=', 'histori_kunjungan_irj.registrasi_id')
            ->leftJoin('histori_kunjungan_igd', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
            ->select([
                'pasiens.no_rm',
                'villages.name AS desa',
                'districts.name AS kecamatan',
                'kamars.nama as namaKelas',
                'pasiens.nama',
                'pasiens.tgllahir',
                'pasiens.kelamin',
                'pasiens.alamat',
                'registrasis.created_at',
                'rawatinaps.kelas_id',
                'rawatinaps.kamar_id',
                'rawatinaps.bed_id',
                'rawatinaps.tgl_masuk',
                'rawatinaps.tgl_keluar',
                'icd10s.nomor AS nomor_icd10',
                'icd10s.nama AS nama_icd10',
                'lica_results.id AS lica_result_id',
                'lica_results.json AS lica_hasil_pemeriksaan',
                'lica_results.tgl_pemeriksaan AS tgl_pemeriksaan_lica',
                DB::raw("CASE 
                    WHEN registrasis.pulang IN ('8', '9') THEN 'M'
                    ELSE 'P'
                END AS status_pulang"),
                DB::raw('TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at) AS umur')
            ])
            // Menambahkan filter yang lebih relevan pada tanggal registrasi
            ->whereRaw('TRIM(hasillabs.json) != ""')
            // Memastikan data pasien muncul meskipun tidak ada data rawat inap
            ->whereBetween('registrasis.created_at', [$tanggalMulai, $tanggalAkhir])
            ->whereIn('perawatan_icd10s.icd10', ['A90', 'A91'])
            // ->limit(50)
            ->get();
    }



   public function getPatientDataWithDetails(array $filters)
{
    $data = $this->getPatientData($filters);

    $data->transform(function ($item) {
        $hasilPemeriksaan = json_decode($item->lica_hasil_pemeriksaan, true);

        $item->hasil_pemeriksaan = collect($hasilPemeriksaan)->map(function ($test) {
            return [
                'test_name' => $test['test_name'],
                'result' => $test['result'],
                'tgl_pemeriksaan' => $test['draw_time'] ?? null
            ];
        });

        // Ambil hasil IgM terbaru
        $igmResult = collect($hasilPemeriksaan)->filter(function ($test) {
            return isset($test['test_name']) && stripos($test['test_name'], 'IgM') !== false;
        })->sortByDesc(function ($test) {
            return $test['draw_time'] ?? '1970-01-01 00:00:00';
        })->first();

        // Ambil hasil IgG terbaru
        $iggResult = collect($hasilPemeriksaan)->filter(function ($test) {
            return isset($test['test_name']) && stripos($test['test_name'], 'IgG') !== false;
        })->sortByDesc(function ($test) {
            return $test['draw_time'] ?? '1970-01-01 00:00:00';
        })->first();

        // Set IgM dan IgG
        $item->igm = $igmResult ? $igmResult['result'] : '-';
        $item->igg = $iggResult ? $iggResult['result'] : '-';

        // Ambil nilai terendah dan tertinggi dari parameter lainnya (Leukosit, Hemoglobin, Trombosit, Hematokrit)
        $leukosit = collect($hasilPemeriksaan)->where('test_name', 'Leukosit')->pluck('result')->map(fn($x) => (float) $x);
        $hemoglobin = collect($hasilPemeriksaan)->where('test_name', 'Hemoglobin')->pluck('result')->map(fn($x) => (float) $x);
        $thrombosit = collect($hasilPemeriksaan)->where('test_name', 'Trombosit')->pluck('result')->map(fn($x) => (float) $x);
        $hematokrit = collect($hasilPemeriksaan)->where('test_name', 'Hematokrit')->pluck('result')->map(fn($x) => (float) $x);

        // Pastikan terambil nilai terendah dan tertinggi dengan benar
        $item->leukosit_terendah = $leukosit->min() ?? null;
        $item->leukosit_tertinggi = $leukosit->max() ?? null;

        $item->hemoglobin_terendah = $hemoglobin->min() ?? null;
        $item->hemoglobin_tertinggi = $hemoglobin->max() ?? null;

        $item->thrombosit_terendah = $thrombosit->min() ?? null;
        $item->thrombosit_tertinggi = $thrombosit->max() ?? null;

        $item->hematokrit_terendah = $hematokrit->min() ?? null;
        $item->hematokrit_tertinggi = $hematokrit->max() ?? null;

        // Optional: PCV terendah diset sesuai hematokrit terendah
        $item->pcv_terendah = $hematokrit->min() ?? null;

        return $item;
    });
    // Mengelompokkan data berdasarkan no_rm dan mengambil nilai terendah dari setiap parameter
    $groupedData = $data->groupBy('no_rm')->map(function ($group) {
        $firstItem = $group->first();
        $firstItem->leukosit_terendah = $group->pluck('leukosit_terendah')->min();
        $firstItem->leukosit_tertinggi = $group->pluck('leukosit_tertinggi')->max();

        $firstItem->hemoglobin_terendah = $group->pluck('hemoglobin_terendah')->min();
        $firstItem->hemoglobin_tertinggi = $group->pluck('hemoglobin_tertinggi')->max();

        $firstItem->thrombosit_terendah = $group->pluck('thrombosit_terendah')->min();
        $firstItem->thrombosit_tertinggi = $group->pluck('thrombosit_tertinggi')->max();

        $firstItem->hematokrit_terendah = $group->pluck('hematokrit_terendah')->min();
        $firstItem->hematokrit_tertinggi = $group->pluck('hematokrit_tertinggi')->max();


        $firstItem->pcv_terendah = $firstItem->hematokrit_terendah;

        // Ambil IgM dan IgG terbaru
        $firstItem->igm = $group->max('igm');
        $firstItem->igg = $group->max('igg');

        return $firstItem;
    })->values();
    // dd($groupedData);

    return $groupedData;
    }



    public function exportIcd($dataForExcel)
    {
        return \Maatwebsite\Excel\Facades\Excel::create('Laporan ICD', function ($excel) use ($dataForExcel) {
            $excel->setTitle('Laporan ICD')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan Pasien ICD');

            $excel->sheet('Laporan', function ($sheet) use ($dataForExcel) {
                $row = 1;
                $sheet->mergeCells('A1:A2'); // Kolom No
                $sheet->mergeCells('B1:B2'); // Kolom No Medrec
                $sheet->mergeCells('C1:C2'); // Kolom Nama Pasien
                $sheet->mergeCells('D1:E1'); // Kolom Jenis Kelamin (L dan P)
                $sheet->mergeCells('F1:F2'); // Kolom Alamat
                $sheet->mergeCells('G1:G2'); // Kolom Kelurahan
                $sheet->mergeCells('H1:H2'); // Kolom Kecamatan
                $sheet->mergeCells('I1:I2'); // Kolom Kabupaten/Kota
                $sheet->mergeCells('J1:O1'); // Kolom Keadaan Keluar RS (Sembuh, Perbaikan, dll)
                $sheet->mergeCells('P1:P2'); // Kolom Tanggal Masuk
                $sheet->mergeCells('Q1:Q2'); // Kolom Tanggal Keluar

                // Judul Kolom
                $sheet->row($row++, [
                    'No',
                    'No Medrec',
                    'Nama Pasien',
                    'Jenis Kelamin',
                    '',
                    'Alamat',
                    'Kelurahan',
                    'Kecamatan',
                    'Kabupaten/Kota',
                    'Keadaan Keluar RS',
                    "",
                    "",
                    "",
                    "",
                    "",
                    'Tanggal Masuk',
                    'Tanggal Keluar',
                ]);

                // Baris kedua untuk kolom-kolom spesifik
                $sheet->row($row++, [
                    '',
                    '',
                    '',
                    'L',
                    'P',
                    '',
                    '',
                    '',
                    '',
                    'Sembuh',
                    'Perbaikan',
                    'Tidak Sembuh',
                    'Meninggal < 48 Jam',
                    'Meninggal > 48 Jam',
                    'Lain-lain',
                    '',
                    ''
                ]);

                // Data
                $no = 1;
                foreach ($dataForExcel as $data) {
                    $sheet->row($row++, [
                        $no++,
                        $data->no_medrec,
                        $data->nama_pasien,
                        $data->kelamin == 'L' ? \Carbon\Carbon::parse($data->tanggal_lahir)->diffInYears($data->created_at) : '-',
                        $data->kelamin == 'P' ? \Carbon\Carbon::parse($data->tanggal_lahir)->diffInYears($data->created_at) : '-',
                        $data->alamat ?? '-',
                        $data->desa ?? '-',
                        $data->kecamatan ?? '-',
                        $data->kabupaten ?? '-',
                        $data->keadaan_keluar == 'Sembuh' ? '×' : '-',
                        $data->keadaan_keluar == 'Perbaikan' ? '×' : '-',
                        $data->keadaan_keluar == 'Tidak Sembuh' ? '×' : '-',
                        $data->keadaan_keluar == 'Meninggal < 48 Jam' ? '×' : '-',
                        $data->keadaan_keluar == 'Meninggal > 48 Jam' ? '×' : '-',
                        $data->keadaan_keluar == 'Lain-lain' ? '×' : '-',
                        \Carbon\Carbon::parse($data->created_at)->format('d-m-Y'),
                        \Carbon\Carbon::parse($data->tgl_pulang)->format('d-m-Y'),
                    ]);
                }

                // Styling Header
                $sheet->row(1, function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                $sheet->row(2, function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                // Auto Size Columns
                $sheet->setAutoSize(true);
            });
        })->export('xlsx');
    }



public function exportMorbiditasDBD($dataForExcel)
{
    return \Maatwebsite\Excel\Facades\Excel::create('Laporan DBD', function ($excel) use ($dataForExcel) {
        $excel->setTitle('Laporan DBD')
            ->setCreator('Digihealth')
            ->setCompany('Digihealth')
            ->setDescription('Laporan Pasien DBD');

        $excel->sheet('Laporan', function ($sheet) use ($dataForExcel) {
            $row = 1; // Set baris pertama untuk header

            // Header Utama
            $sheet->row($row++, [
                'No',
                'No RM',
                'Nama',
                'Umur',
                'Jenis Kelamin',
                'Alamat',
                'Kecamatan',
                'Desa',
                'Bulan DiRawat',
                'Diagnosa',
                'Status Pulang',
                'IgM',
                'IgG',
                'PCV Terendah',
                'Leukosit Terendah',
                'Hemoglobin Terendah',
                'Thrombosit Terendah',
                'Hematokrit Tertinggi',
                'Tempat DiRawat',
                'Tanggal Masuk RS'
            ]);

            // Styling Header
            $sheet->row(1, function ($row) {
                $row->setFontWeight('bold');
                $row->setAlignment('center');
                $row->setValignment('center');
            });

            // Data
            $no = 1;
            foreach ($dataForExcel as $data) {
                $sheet->row($row++, [
                    $no++,
                    $data->no_rm,
                    $data->nama,
                    $data->umur,
                    $data->kelamin,
                    $data->alamat,
                    $data->kecamatan,
                    $data->desa,
                    \Carbon\Carbon::parse($data->tgl_masuk)->format('F'),
                    $data->nama_icd10,
                    $data->status_pulang,
                    $data->igm,
                    $data->igg,
                    $data->pcv_terendah,
                    $data->leukosit_terendah,
                    $data->hemoglobin_terendah,
                    $data->thrombosit_terendah,
                    $data->hematokrit_tertinggi,
                    $data->namaKelas,
                    \Carbon\Carbon::parse($data->tgl_masuk)->format('d-m-Y'),
                ]);
            }

            // Auto Size Columns
            $sheet->setAutoSize(true);
        });
    })->export('xlsx');
}
// public function exportSpecialDiasesis($dataForExcel)
// {
//     return \Maatwebsite\Excel\Facades\Excel::create('Laporan Penyakit Khusus', function ($excel) use ($dataForExcel) {
//         $excel->setTitle('Laporan Penyakit Khusus')
//             ->setCreator('Digihealth')
//             ->setCompany('Digihealth')
//             ->setDescription('Laporan Penyakit Khusus per Bulan');

//         $excel->sheet('Laporan', function ($sheet) use ($dataForExcel) {
//             $row = 1; // Set baris pertama untuk header

//             // Header Utama
//             $sheet->row($row++, [
//                 'No',
//                 'Kode ICD 10',
//                 'Golongan Sebab Penyakit',
//                 'Bulan',
//                 'Rawat Inap',
//                 'IGD',
//                 'Rawat Jalan',
//                 'Total'
//             ]);

//             // Styling Header
//             $sheet->row(1, function ($row) {
//                 $row->setFontWeight('bold');
//                 $row->setAlignment('center');
//                 $row->setValignment('center');
//             });

//             // Data
//             $no = 1;
//             foreach ($dataForExcel as $data) {
//                 // Mengambil data untuk setiap kode ICD
//                 $sheet->row($row++, [
//                     $no++, // Nomor urut
//                     $data->kode_icd10, // Mengakses kode ICD
//                     $data->golongan_penyakit, // Mengakses golongan penyakit
//                     \DateTime::createFromFormat('!m', $data->bulan)->format('F'), // Mengakses bulan
//                     $data->rawat_inap, // Mengakses rawat inap
//                     $data->igd, // Mengakses IGD
//                     $data->rawat_jalan, // Mengakses rawat jalan
//                     $data->total // Mengakses total
//                 ]);
//             }

//             // Auto Size Columns
//             $sheet->setAutoSize(true);
//         });
//     })->export('xlsx');
// }

  public function exportSpecialDiasesis($dataForExcel)
{
    // Pemetaan nama bulan ke angka
    $bulanMap = [
        'JANUARI' => 1, 'FEBRUARI' => 2, 'MARET' => 3, 'APRIL' => 4,
        'MEI' => 5, 'JUNI' => 6, 'JULI' => 7, 'AGUSTUS' => 8,
        'SEPTEMBER' => 9, 'OKTOBER' => 10, 'NOVEMBER' => 11, 'DESEMBER' => 12
    ];

    // Mengelompokkan data berdasarkan kode ICD
    $groupedData = [];
    foreach ($dataForExcel as $data) {
        $kodeICD = $data->kode_icd10;
        $bulan = is_numeric($data->bulan) ? (int) $data->bulan : ($bulanMap[strtoupper($data->bulan)] ?? null);
        
        if ($bulan === null) {
            continue; // Lewati jika bulan tidak valid
        }

        // Jika kode ICD belum ada dalam array, inisialisasi
        if (!isset($groupedData[$kodeICD])) {
            $groupedData[$kodeICD] = [
                'kode_icd10' => $kodeICD,
                'golongan_penyakit' => $data->golongan_penyakit,
                'data' => array_fill_keys(range(1, 12), [
                    'rawat_inap' => 0,
                    'igd' => 0,
                    'rawat_jalan' => 0,
                    'total' => 0,
                ])
            ];
        }

        // Tambahkan data ke bulan yang sesuai
        $groupedData[$kodeICD]['data'][$bulan]['rawat_inap'] += $data->rawat_inap;
        $groupedData[$kodeICD]['data'][$bulan]['igd'] += $data->igd;
        $groupedData[$kodeICD]['data'][$bulan]['rawat_jalan'] += $data->rawat_jalan;
        $groupedData[$kodeICD]['data'][$bulan]['total'] += $data->total;
    }

    return \Maatwebsite\Excel\Facades\Excel::create('Laporan Penyakit Khusus', function ($excel) use ($groupedData, $bulanMap) {
        $excel->setTitle('Laporan Penyakit Khusus')
            ->setCreator('Digihealth')
            ->setCompany('Digihealth')
            ->setDescription('Laporan Penyakit Khusus per Bulan');

        $excel->sheet('Laporan', function ($sheet) use ($groupedData, $bulanMap) {
            $row = 1;
            $header = ['No', 'Kode ICD 10', 'Golongan Sebab Penyakit'];
            
            // Tambahkan header bulan
            foreach (array_keys($bulanMap) as $bulan) {
                array_push($header, $bulan, '', '', '');
            }
            $sheet->row($row++, $header);

            // Sub-header untuk kategori
            $subHeader = ['', '', ''];
            foreach (array_keys($bulanMap) as $bulan) {
                array_push($subHeader, 'RAWAT INAP', 'IGD', 'RAWAT JALAN', 'TOTAL');
            }
            $sheet->row($row++, $subHeader);

            // Merge cells untuk header bulan
            $sheet->mergeCells('A1:A2'); // No
            $sheet->mergeCells('B1:B2'); // Kode ICD 10
            $sheet->mergeCells('C1:C2'); // Golongan Penyakit
            
            $colIndex = 4;
            foreach (array_keys($bulanMap) as $bulan) {
                $startCol = \PHPExcel_Cell::stringFromColumnIndex($colIndex - 1);
                $endCol = \PHPExcel_Cell::stringFromColumnIndex($colIndex + 2);
                $sheet->mergeCells("{$startCol}1:{$endCol}1");
                $colIndex += 4;
            }
            
            // Isi Data
            $no = 1;
            foreach ($groupedData as $data) {
                $rowData = [$no++, $data['kode_icd10'], $data['golongan_penyakit']];
                foreach (range(1, 12) as $bulan) {
                    $rowData[] = $data['data'][$bulan]['rawat_inap'];
                    $rowData[] = $data['data'][$bulan]['igd'];
                    $rowData[] = $data['data'][$bulan]['rawat_jalan'];
                    $rowData[] = $data['data'][$bulan]['total'];
                }
                $sheet->row($row++, $rowData);
            }

            $sheet->setAutoSize(true);
            $sheet->setAllBorders('thin'); // Beri border pada semua sel agar rapi
        });
    })->export('xlsx');
}




    public function getPatientDataWithConditions($filters = [])
    {
        $tanggalMulai = isset($filters['tanggal_mulai']) ? Carbon::parse($filters['tanggal_mulai'])->startOfDay() : Carbon::now()->startOfDay();
        $tanggalAkhir = isset($filters['tanggal_akhir']) ? Carbon::parse($filters['tanggal_akhir'])->endOfDay() : Carbon::now()->endOfDay();
        $query = DB::table('perawatan_icd10s')
            ->join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->leftJoin('villages', 'pasiens.village_id', '=', 'villages.id')
            ->leftJoin('regencies', 'pasiens.regency_id', '=', 'regencies.id')
            ->leftJoin('districts', 'pasiens.district_id', '=', 'districts.id')
            ->leftJoin('kondisi_akhir_pasiens', 'registrasis.pulang', '=', 'kondisi_akhir_pasiens.id')
            ->select([
                'pasiens.no_rm AS no_medrec',
                'pasiens.tgllahir as tanggal_lahir',
                'pasiens.nama AS nama_pasien',
                'pasiens.kelamin',
                DB::raw("CASE 
                WHEN pasiens.kelamin = 'L' THEN CONCAT('', TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at), ' Th')
                WHEN pasiens.kelamin = 'P' THEN CONCAT('', TIMESTAMPDIFF(YEAR, pasiens.tgllahir, registrasis.created_at), ' Th')
                ELSE pasiens.kelamin
            END AS jenis_kelamin"),
                'pasiens.alamat',
                'villages.name AS kelurahan',
                'districts.name AS kecamatan',
                'regencies.name AS kabupaten',
                DB::raw("'Kabupaten Bandung' AS kabupaten_kota"), // Ubah jika dinamis
                DB::raw("CASE 
                WHEN kondisi_akhir_pasiens.namakondisi = 'Sembuh' THEN '×'
                WHEN kondisi_akhir_pasiens.namakondisi = 'Perbaikan' THEN '×'
                WHEN kondisi_akhir_pasiens.namakondisi = 'Tidak Sembuh' THEN '×'
                WHEN kondisi_akhir_pasiens.namakondisi = 'Meninggal < 48 Jam' THEN '×'
                WHEN kondisi_akhir_pasiens.namakondisi = 'Meninggal > 48 Jam' THEN '×'
                ELSE 'Lain-lain'
            END AS keadaan_keluar"),
                'registrasis.created_at',
                'registrasis.tgl_pulang',
            ])
            ->where('perawatan_icd10s.jenis', '=', 'TI')
            ->whereBetween('registrasis.created_at', [$tanggalMulai, $tanggalAkhir])
            ->limit(50)
            ->whereNotNull('registrasis.tgl_pulang');
        // ->limit(50);
        if (!empty($filters['poli'])) {
            $query->where('registrasis.poli_id', '=', $filters['poli']);
        }
        if (!empty($filters['icds'])) {
            $query->where('perawatan_icd10s.icd10', '=', $filters['icds']);
        }
        // Tambahkan Filter Rawat Jalan, Rawat Inap, IGD jika ada
        if (!empty($filters['layanan'])) {
            if ($filters['layanan'] == "TI") {
                $query->leftJoin('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id');
                $query->leftJoin('kamars', 'rawatinaps.kamar_id', '=', 'kamars.id');
                // $query->where('kamars.id', '=', $filters['poli']);
                $query->where('perawatan_icd10s.jenis', '=', 'TI');
                // $query->where('kamars.id', '!=', null);
            }
            if ($filters['layanan'] == "TA") {
                $query->where('perawatan_icd10s.jenis', '=', 'TA');
            }
            if ($filters['layanan'] == "TG") {
                $query->where('perawatan_icd10s.jenis', '=', 'TG');
                // dd($query->select('perawatan_icd10s.jenis')->get(), $query->select('perawatan_icd10s.jenis')->get());
            }
        }
        $query->groupBy('pasiens.no_rm');
        // Return data
        return $query->get();
    }
    public function generateLaporanByRawatKekhususan($filters = [])
    {
        // Default tanggal hari ini jika filter tidak diberikan
        $tahun = isset($filters['tahun']) ? $filters['tahun'] : now()->year;
        $kategori = isset($filters['kategori']) ? $filters['kategori'] : null;

            // Daftar kategori diagnosa
            $kategoriDiagnosa = [
                'penyakit_jantung' => [
                    ['I05.0', 'I05.9'],
                    ['I06.0', 'I06.9'],
                    ['I07.0', 'I07.9'],
                    ['I08.0', 'I08.9'],
                    ['I09.0', 'I09.9'],
                    ['I11.0', 'I11.9'],
                    ['I12.0', 'I12.9'],
                    ['I13.0', 'I13.9'],
                    ['I14.0', 'I14.9'],
                    ['I15.0', 'I15.9'],
                    ['I21.0', 'I21.9'],
                    ['I22.0', 'I22.9'],
                    ['I23.0', 'I23.9'],
                    ['I24.0', 'I24.9'],
                    ['I25.0', 'I25.9'],
                    ['I27.0', 'I27.9'],
                    ['I28.0', 'I28.9'],
                    ['I29.0', 'I29.9'],
                    ['I30.0', 'I30.9'],
                    ['I31.0', 'I31.9'],
                    ['I32.0', 'I32.9'],
                    ['I33.0', 'I33.9'],
                    ['I34.0', 'I34.9'],
                    ['I35.0', 'I35.9'],
                    ['I36.0', 'I36.9'],
                    ['I37.0', 'I37.9'],
                    ['I38.0', 'I38.9'],
                    ['I39.0', 'I39.9'],
                    ['I40.0', 'I40.9'],
                    ['I41.0', 'I41.9'],
                    ['I42.0', 'I42.9'],
                    ['I43.0', 'I43.9'],
                    ['I44.0', 'I44.9'],
                    ['I45.0', 'I45.9'],
                    ['I46.0', 'I46.9'],
                    ['I47.0', 'I47.9'],
                    ['I48.0', 'I48.9'],
                    ['I49.0', 'I49.9'],
                    ['I50.0', 'I50.9'],
                    ['I51.0', 'I51.9'],
                    ['I52.0', 'I52.9'],
                ],

                'stroke' => [
                    ['I60.0', 'I60.9'], ['I61.0', 'I61.9'], ['I62.0', 'I62.9'], ['I63.0', 'I63.9'], ['I64', 'I64']
                ],
                'hipertensi' => [['I10', 'I10']],
                'diabetes' => [
                    ['E10.0', 'E10.9'], ['E11.0', 'E11.9'], ['E12.0', 'E12.9'], ['E13.0', 'E13.9'], ['E14.0', 'E14.9']
                ],
                'kanker' => [['C00.0', 'C99.9']],
                'tuberkulosis' => [['A15.0', 'A19.9']],
                'hiv' => [['B20.0', 'B24.9']],
            ];
        // Query untuk menghasilkan data laporan
        $query = DB::table('perawatan_icd10s')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
            ->select(
                'icd10s.nomor as kode_icd10',
                'icd10s.nama as golongan_penyakit',
                DB::raw('MONTH(registrasis.created_at) as bulan'),
                DB::raw('YEAR(registrasis.created_at) as tahun'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis = "TI" THEN 1 ELSE 0 END) as rawat_inap'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis = "TG" THEN 1 ELSE 0 END) as igd'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis = "TA" THEN 1 ELSE 0 END) as rawat_jalan'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis IN ("TI", "TG", "TA") THEN 1 ELSE 0 END) as total')
            )
            // ->limit(10)
            ->whereYear('registrasis.created_at', $tahun); // Tambahkan filter tahun

         if ($kategori && isset($kategoriDiagnosa[$kategori])) {
                $query->where(function ($q) use ($kategoriDiagnosa, $kategori) {
                    foreach ($kategoriDiagnosa[$kategori] as $range) {
                        $q->orWhereBetween('icd10s.nomor', $range);
                    }
                });
            }
        // Grouping dan sorting data
        $query->groupBy('icd10s.nomor', 'icd10s.nama', DB::raw('MONTH(registrasis.created_at)'), DB::raw('YEAR(registrasis.created_at)'))
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->orderBy('golongan_penyakit');

        return $query->get();
    }
    public function generateLaporanByRawatKekhususanExcel($filters = [])
    {
        $tahun = isset($filters['tahun']) ? $filters['tahun'] : now()->year;

        // Query database
        $data = DB::table('perawatan_icd10s')
            ->join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
            ->select(
                'icd10s.nomor as kode_icd10',
                'icd10s.nama as golongan_penyakit',
                DB::raw('MONTH(registrasis.created_at) as bulan'),
                DB::raw('YEAR(registrasis.created_at) as tahun'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis = "TI" THEN 1 ELSE 0 END) as rawat_inap'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis = "TG" THEN 1 ELSE 0 END) as igd'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis = "TA" THEN 1 ELSE 0 END) as rawat_jalan'),
                DB::raw('SUM(CASE WHEN perawatan_icd10s.jenis IN ("TI", "TG", "TA") THEN 1 ELSE 0 END) as total')
            )
            ->whereYear('registrasis.created_at', $tahun)
            ->groupBy('icd10s.nomor', 'icd10s.nama', DB::raw('MONTH(registrasis.created_at)'))
            ->get();

        // Format data untuk Excel
        $formattedData = [];
        foreach ($data as $row) {
            $kategori = $this->determineKategori($row->kode_icd10);
            if (!isset($formattedData[$kategori])) {
                $formattedData[$kategori] = [];
            }

            $formattedData[$kategori][] = [
                'kode_icd10' => $row->kode_icd10,
                'golongan_penyakit' => $row->golongan_penyakit,
                'data_bulan' => array_fill(1, 12, ['rawat_inap' => 0, 'igd' => 0, 'rawat_jalan' => 0, 'total' => 0]),
            ];
            $formattedData[$kategori][count($formattedData[$kategori]) - 1]['data_bulan'][$row->bulan] = [
                'rawat_inap' => $row->rawat_inap,
                'igd' => $row->igd,
                'rawat_jalan' => $row->rawat_jalan,
                'total' => $row->total,
            ];
        }

        return $formattedData;
    }

    private function determineKategori($kodeIcd)
        {
            $kategoriDiagnosa = [
                'penyakit_jantung' => ['I05.0', 'I52.9'],
                'stroke' => ['I60.0', 'I64'],
                'hipertensi' => ['I10'],
                'diabetes' => ['E10.0', 'E14.9'],
                'kanker' => ['C00.0', 'C99.9'],
                'tuberkulosis' => ['A15.0', 'A19.9'],
                'hiv' => ['B20.0', 'B24.9'],
            ];

            foreach ($kategoriDiagnosa as $kategori => $range) {
                if ($kodeIcd >= $range[0] && $kodeIcd <= $range[1]) {
                    return $kategori;
                }
            }

            return null;
        }
        public function exportSpecialAttentionDiseases($dataForExcel)
        {
            return \Maatwebsite\Excel\Facades\Excel::create('Laporan Penyakit Khusus', function ($excel) use ($dataForExcel) {
                $excel->setTitle('Laporan Penyakit Khusus')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Penyakit Khusus');

                $excel->sheet('Laporan', function ($sheet) use ($dataForExcel) {
                    $row = 1;

                    // Header Utama
                    $sheet->mergeCells('A1:A2'); // Kolom No
                    $sheet->mergeCells('B1:B2'); // Kolom Kode ICD
                    $sheet->mergeCells('C1:C2'); // Kolom Golongan Penyakit
                    $sheet->mergeCells('D1:D2'); // Kolom Rawat Inap
                    $sheet->mergeCells('E1:E2'); // Kolom IGD
                    $sheet->mergeCells('F1:F2'); // Kolom Rawat Jalan
                    $sheet->mergeCells('G1:G2'); // Kolom Total

                    $sheet->row($row++, [
                        'No',
                        'Kode ICD',
                        'Golongan Penyakit',
                        'Rawat Inap',
                        'IGD',
                        'Rawat Jalan',
                        'Total'
                    ]);

                    // Data
                    $no = 1;
                    foreach ($dataForExcel as $kategori => $penyakit) {
                        // Menambahkan kategori penyakit
                        $sheet->row($row++, [
                            '',
                            strtoupper($kategori), // Nama kategori (misalnya "Penyakit Jantung")
                            '',
                            '',
                            '',
                            '',
                            ''
                        ]);

                        foreach ($penyakit as $data) {
                            $sheet->row($row++, [
                                $no++,
                                $data->kode_icd10,
                                $data->golongan_penyakit,
                                $data->rawat_inap,
                                $data->igd,
                                $data->rawat_jalan,
                                $data->total
                            ]);
                        }
                    }

                    // Styling Header
                    $sheet->row(1, function ($row) {
                        $row->setFontWeight('bold');
                        $row->setAlignment('center');
                        $row->setValignment('center');
                    });

                    $sheet->row(2, function ($row) {
                        $row->setFontWeight('bold');
                        $row->setAlignment('center');
                        $row->setValignment('center');
                    });

                    // Auto Size Columns
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }

}

