<?php

namespace App\Http\Controllers;

use Excel;
use App\Conf_rl33;
use App\Conf_rl36;
use Carbon\Carbon;
use App\PerawatanIcd9;
use App\PerawatanIcd10;
use App\HistorikunjunganIGD;
use App\ResepNote;
use App\EmrInapPemeriksaan;
use App\Emr;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Modules\Poli\Entities\Poli;
use Modules\Icd10\Entities\Icd10;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;
use App\Services\SirsRIService;
use Illuminate\Support\Facades\DB;
use Modules\Kamar\Entities\Kamar;
class SirsRlController extends Controller
{
    protected $laporanService;

    public function __construct(SirsRIService $sirsRIService)
    {
        $this->laporanService = $sirsRIService;
    }

    public function gigiMulut()
    {
        $data['mapping'] = Conf_rl33::withCount('tarif')->get();
        return view('sirs.gigi-mulut', compact('data'));
    }

    public function pembedahan()
    {
        $data['mapping'] = Conf_rl36::withCount('tarif')->get();
        return view('sirs.pembedahan', compact('data'));
    }

    public function rawatDarurat()
    {
        $data['maternal'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD Maternal')->get();
        $data['perinatologi'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD Perinatologi')->get();
        $data['ponek'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD PONEK')->get();
        $data['umum'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD Umum')->get();
        // maternal
        $data['rujukan_maternal'] = 0;
        $data['nonRujukan_maternal'] = 0;
        foreach ($data['maternal'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_maternal'] += 1;
            } else {
                $data['rujukan_maternal'] += 1;
            }
        }
        // perinatologi
        $data['rujukan_perinatologi'] = 0;
        $data['nonRujukan_perinatologi'] = 0;
        foreach ($data['perinatologi'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_perinatologi'] += 1;
            } else {
                $data['rujukan_perinatologi'] += 1;
            }
        }
        // ponek
        $data['rujukan_ponek'] = 0;
        $data['nonRujukan_ponek'] = 0;
        foreach ($data['ponek'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_ponek'] += 1;
            } else {
                $data['rujukan_ponek'] += 1;
            }
        }
        // umum
        $data['rujukan_umum'] = 0;
        $data['nonRujukan_umum'] = 0;
        foreach ($data['umum'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_umum'] += 1;
            } else {
                $data['rujukan_umum'] += 1;
            }
        }
        // $data['igd'] = HistorikunjunganIGD::where('triage_nama','IGD')->get();
        // $data['igd'] = HistorikunjunganIGD::where('triage_nama','Perinatologi')->get();
        // $data['igd'] = HistorikunjunganIGD::where('triage_nama','PONEK')->get();
        // $data['igd'] = HistorikunjunganIGD::where('triage_nama','Radiologi')->get();
        // $data['igd'] = HistorikunjunganIGD::where('triage_nama','Radiologi USG')->get();
        // $data['igd'] = HistorikunjunganIGD::where('triage_nama','Umum')->get();
        return view('sirs.rawat-darurat', compact('data'));
    }

    public function rawatDaruratExcel()
    {
        $data['maternal'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD Maternal')->get();
        $data['perinatologi'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD Perinatologi')->get();
        $data['ponek'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD PONEK')->get();
        $data['umum'] = HistorikunjunganIGD::with('registrasi.rujukan')->has('registrasi.rujukan')->where('triage_nama', 'IGD Umum')->get();
        // maternal
        $data['rujukan_maternal'] = 0;
        $data['nonRujukan_maternal'] = 0;
        foreach ($data['maternal'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_maternal'] += 1;
            } else {
                $data['rujukan_maternal'] += 1;
            }
        }
        // perinatologi
        $data['rujukan_perinatologi'] = 0;
        $data['nonRujukan_perinatologi'] = 0;
        foreach ($data['perinatologi'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_perinatologi'] += 1;
            } else {
                $data['rujukan_perinatologi'] += 1;
            }
        }
        // ponek
        $data['rujukan_ponek'] = 0;
        $data['nonRujukan_ponek'] = 0;
        foreach ($data['ponek'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_ponek'] += 1;
            } else {
                $data['rujukan_ponek'] += 1;
            }
        }
        // umum
        $data['rujukan_umum'] = 0;
        $data['nonRujukan_umum'] = 0;
        foreach ($data['umum'] as $v) {
            if ($v->registrasi->rujukan == 1) { // pasien datang sendiri
                $data['nonRujukan_umum'] += 1;
            } else {
                $data['rujukan_umum'] += 1;
            }
        }
        Excel::create('Laporan RL Rawat Darurat - 3.2', function ($excel) use ($data) {
            // Set the properties
            $excel->setTitle('Laporan RL Rawat Darurat - 3.2')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan RL Rawat Darurat - 3.2');
            $excel->sheet('Laporan RL Rawat Darurat - 3.2', function ($sheet) use ($data) {
                $row = 1;
                $no = 1;
                $sheet->row($row, [
                    'No',
                    'Jenis Pelayanan',
                    'Total Pasien Rujukan',
                    'Total Pasien Non Rujukan',
                ]);
                $dt = [
                    [
                        "nama" => "IGD Maternal",
                        "rujukan" => $data['rujukan_maternal'],
                        "non_rujukan" => $data['nonRujukan_maternal'],
                    ],
                    [
                        "nama" => "IGD Perinatologi",
                        "rujukan" => $data['rujukan_perinatologi'],
                        "non_rujukan" => $data['nonRujukan_perinatologi'],
                    ],
                    [
                        "nama" => "IGD Ponek",
                        "rujukan" => $data['rujukan_ponek'],
                        "non_rujukan" => $data['nonRujukan_ponek'],
                    ],
                    [
                        "nama" => "IGD Umum",
                        "rujukan" => $data['rujukan_umum'],
                        "non_rujukan" => $data['nonRujukan_umum'],
                    ]
                ];
                foreach ($dt as $val) {
                    $sheet->row(++$row, [
                        $no++,
                        $val['nama'],
                        $val['rujukan'],
                        $val['non_rujukan'],
                    ]);
                };
            });
        })->export('xlsx');
    }

    public function laporanTb()
    {
        return view('sirs.laporan-tb');
    }

    public function laporanTbIrj()
    {

        $icd10 = Icd10::where('id', '>=', 71)->where('id', '<=', 112)->pluck('nomor');

        $data['irj'] = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', '.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('registrasis.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', '<>', 'TI')
            ->whereIn('perawatan_icd10s.icd10', $icd10)
            ->limit(10)
            ->get();
        $data['poli'] = Poli::pluck('nama', 'id');

        return view('sirs.laporan-tb-irj', $data)->with('no', 1);
    }

    public function laporanTbIrjByTanggal(Request $request)
    {
        $poli = Poli::pluck('nama', 'id');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $icd10 = Icd10::where('id', '>=', 71)->where('id', '<=', 112)->pluck('nomor');
        // dd($icd10);

        $irj = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', '<>', 'TI')
            ->limit(1000);

        $irj = $irj->whereIn('perawatan_icd10s.icd10', $icd10);
        if ($request->poli != '') {
            $irj = $irj->where('registrasis.poli_id', $request->poli);
        }

        $ok = $irj->get();

        if ($request['view']) {
            return view('sirs.laporan-tb-irj', compact('irj', 'ok', 'poli'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan TB IRJ ', function ($excel) use ($ok) {
                // Set the properties
                $excel->setTitle('Laporan TB IRJ')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan TB IRJ');
                $excel->sheet('Laporan TB IRJ', function ($sheet) use ($ok) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Pasien',
                        'RM',
                        'NIK',
                        'Dokter',
                        'Kasus 1',
                        'Kasus 2',
                        'Rujuk Ke',
                        'Poli',
                        'Diagnosa Awal',
                        'Diagnosa Akhir',
                        'ICD 9',
                        'ICD 10',
                        'Keterangan',
                        'Asuransi',
                        'Alamat',
                        'Provinsi',
                        'Kabupaten',
                        'Kecamatan',
                        'Kelurahan'
                    ]);
                    foreach ($ok as $key => $d) {

                        $reg = Registrasi::find($d->registrasi_id);
                        $icd9 = PerawatanIcd9::where('registrasi_id', $reg->id)->first();
                        $pasien = Registrasi::where('pasien_id', $reg->pasien_id)->count();

                        if ($pasien > 1) {
                            $kasus = 'Lama';
                        } else {
                            $kasus = 'Baru';
                        }

                        $jk = null;
                        $sheet->row(++$row, [
                            $no++,
                            baca_pasien(@$reg->pasien_id),
                            @$reg->pasien->no_rm,
                            " " . strval(@$reg->pasien->nik),
                            baca_dokter(@$reg->dokter_id),
                            @$reg->status,
                            @$kasus,
                            @baca_rujukan(@$reg->rujukan),
                            baca_poli(@$reg->poli_id),
                            @baca_diagnosa(@$reg->diagnosa_awal),
                            @baca_diagnosa(@$reg->diagnosa_akhir),
                            @baca_icd9(@$icd9->icd9),
                            baca_icd10(@$d->icd10),
                            @$reg->keterangan,
                            @baca_jkn(@$reg->id),
                            @$reg->pasien->alamat,
                            baca_propinsi(@$reg->pasien->province_id),
                            baca_kabupaten(@$reg->pasien->regency_id),
                            baca_kecamatan(@$reg->pasien->district_id),
                            baca_kelurahan(@$reg->pasien->village_id)
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function laporanMorbiditas(Request $request)
    {
        $data = $this->laporanService->generateLaporanImmodialisis();
        $data['layanan'] = $request->has('layanan') ? $request['layanan'] : null;
        $data['poli'] = Poli::pluck('nama', 'id');
        return view('sirs.laporan-tb-immodialisis', $data)->with('no', 1);
    }
    public function getPoliOrKamar(Request $request)
    {
        $layanan = $request->input('layanan');
        $options = [];

        if ($layanan === 'TI') {
            $options = Kamar::pluck('nama', 'id');
        } else {
            $options = Poli::pluck('nama', 'id');
        }

        return response()->json($options);
    }
    public function filtermorbiditas(Request $request)
    {
        $tga = $request->has('tga') ? valid_date($request['tga']) : null;
        $tgb = $request->has('tgb') ? valid_date($request['tgb']) : null;
        $poli = $request->has('poli') ? $request['poli'] : null;
        $layanan = $request->has('layanan') ? $request['layanan'] : null;

        $filters = [
            'tanggal_mulai' => $tga,
            'tanggal_akhir' => $tgb,
            'poli' => $poli,
            'layanan' => $layanan
        ];

        $poli = Poli::pluck('nama', 'id');
        $kamar = Kamar::pluck('nama', 'id');
        $data = $this->laporanService->generateLaporanImmodialisis($filters);
        $dataForExcel = $this->laporanService->generateLaporanImmodialisisForExcel($filters);
        $dataForExcel = $dataForExcel['irj'];
        $data['poli'] = $poli;
        $data['layanan'] = $layanan ?? null; // Tambahkan layanan dengan default null jika tidak ada

        if ($request->has('excel')) {
            if ($request['layanan'] == "TA" || $request['layanan'] == "TG") {
                return $this->laporanService->exportMorbiditasRawatJalan($dataForExcel);
            }
            return $this->laporanService->exportMorbiditas($dataForExcel);
        }

        // $data['irj']->appends($request->all());

        return view('sirs.laporan-tb-immodialisis', $data)->with('no', 1);
    }

    public function filterDBD(Request $request)
    {
        $filters = [
            'tanggal_mulai' => $request->has('tga') ? valid_date($request['tga']) : null,
            'tanggal_akhir' => $request->has('tgb') ? valid_date($request['tgb']) : null,
            'poli' => $request->has('poli') ? $request['poli'] : null,
            'layanan' => $request->has('layanan') ? $request['layanan'] : null,
        ];

        // Ambil data dari service
        $dataForDBD = $this->laporanService->getPatientDataWithDetails($filters);
        if ($request->has('excel')) {
            $dataForExcel = $dataForDBD->all();
            return $this->laporanService->exportMorbiditasDBD($dataForExcel);
        }

        // Kirim data ke view
        $data['irj'] = $dataForDBD;
        $data['poli'] = Poli::pluck('nama', 'id');
        // $data['irj']->appends($request->all());

        return view('sirs.laporan-tb-dbd', $data)->with('no', 1);
    }

    public function filterICD(Request $request)
    {
        $filters = [
            'tanggal_mulai' => $request->has('tga') ? valid_date($request['tga']) : null,
            'tanggal_akhir' => $request->has('tgb') ? valid_date($request['tgb']) : null,
            'poli' => $request->has('poli') ? $request['poli'] : null,
            'icds' => $request->has('icds') ? $request['icds'] : null,
            'layanan' => $request->has('layanan') ? $request['layanan'] : null,
        ];

        // Ambil data dari service
        $dataForDBD = $this->laporanService->getPatientDataWithConditions($filters);
        // Proses data tambahan
        $dataForDBD->transform(function ($item) {
            $item->umur = \Carbon\Carbon::parse($item->tanggal_lahir)->diffInYears($item->created_at);
            return $item;
        });
        if ($request->has('excel')) {
            $dataForExcel = $dataForDBD->all();
            return $this->laporanService->exportIcd($dataForExcel);
        }
        $data['irj'] = $dataForDBD;
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['icds'] = Icd10::pluck('nama', 'id');
        return view('sirs.laporan-diagnosis-icd', $data)->with('no', 1);
    }
    public function exportExcel(Request $request)
    {
        $filters = [
            'tahun' => $request->input('tahun', now()->year),
            'kategori' => $request->input('kategori'),
        ];

        $dataForExcel = $this->laporanService->generateLaporanByRawatKekhususanExcel($filters);

        return \Maatwebsite\Excel\Facades\Excel::create('Laporan Kekhususan', function ($excel) use ($dataForExcel) {
            $excel->setTitle('Laporan Kekhususan')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan Kekhususan Pasien');

            $excel->sheet('Laporan Kekhususan', function ($sheet) use ($dataForExcel) {
                $row = 1;

                // Header Utama
                $sheet->mergeCells('A1:A2'); // Kolom No
                $sheet->mergeCells('B1:B2'); // Kolom Kode ICD 10
                $sheet->mergeCells('C1:C2'); // Kolom Golongan Sebab Penyakit
                $sheet->mergeCells('D1:AP1'); // Header Jumlah Pasien

                $sheet->row($row++, [
                    'No',
                    'Kode ICD 10',
                    'Golongan Sebab Penyakit',
                    'Jumlah Pasien',
                ]);

                // Header Bulan dan Jenis Perawatan
                $row++;
                $bulan = [
                    'Januari',
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
                    'Desember',
                ];
                $columns = [];
                foreach ($bulan as $b) {
                    $columns[] = ['Rawat Inap', 'IGD', 'Rawat Jalan', 'Total'];
                }
                $sheet->row($row, array_merge(['', '', ''], ...$columns));

                // Data
                $row++;
                $no = 1;
                foreach ($dataForExcel as $kategori => $records) {
                    // Tampilkan header kategori
                    $sheet->row($row++, [$kategori]);
                    foreach ($records as $data) {
                        $sheet->row($row++, [
                            $no++,
                            $data['kode_icd10'],
                            $data['golongan_penyakit'],
                            ...array_flatten($data['data_bulan']),
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

    public function filterKekhususan(Request $request)
    {
        $filters = [
            'tahun' => $request->has('tahun') ? $request['tahun'] : now()->year,
            'kategori' => $request->has('kategori') ? $request['kategori'] : null,
        ];

        // Ambil data dari service
        $dataForDBD = $this->laporanService->generateLaporanByRawatKekhususan($filters);

        // Jika permintaan GET untuk Excel
        if ($request->isMethod('get') && $request->has('excel')) {
            return $this->laporanService->exportSpecialDiasesis($dataForDBD);
        }

        // Format data untuk tampilan
        $bulanList = range(1, 12);
        $formattedData = [];

        foreach ($dataForDBD as $row) {
            $kode = $row->kode_icd10;
            if (!isset($formattedData[$kode])) {
                $formattedData[$kode] = [
                    'kode_icd10' => $row->kode_icd10,
                    'golongan_penyakit' => $row->golongan_penyakit,
                    'data_bulan' => array_fill_keys($bulanList, [
                        'rawat_inap' => 0,
                        'igd' => 0,
                        'rawat_jalan' => 0,
                        'total' => 0,
                    ])
                ];
            }
            $formattedData[$kode]['data_bulan'][$row->bulan] = [
                'rawat_inap' => $row->rawat_inap,
                'igd' => $row->igd,
                'rawat_jalan' => $row->rawat_jalan,
                'total' => $row->total,
            ];
        }

        $data['irj'] = $formattedData;
        $data['tahun'] = $filters['tahun'];

        return view('sirs.laporan-perhatian-penyakit-khusus', $data);
    }


    public function laporanTbIgd()
    {
        $icd10 = Icd10::where('id', '>=', 71)->where('id', '<=', 112)->pluck('nomor');

        $data['irj'] = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('registrasis.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', '<>', 'TG')
            ->whereIn('perawatan_icd10s.icd10', $icd10)
            ->limit(10)
            ->get();
        $data['poli'] = Poli::pluck('nama', 'id');
        return view('sirs.laporan-tb-igd', $data)->with('no', 1);
    }
    public function laporanTbIgdByTanggal(Request $request)
    {
        $poli = Poli::pluck('nama', 'id');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $icd10 = Icd10::where('id', '>=', 71)->where('id', '<=', 112)->pluck('nomor');
        // dd($icd10);

        $igd = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', '<>', 'TG')
            ->limit(1000);

        $igd = $igd->whereIn('perawatan_icd10s.icd10', $icd10);
        if ($request->poli != '') {
            $igd = $igd->where('registrasis.poli_id', $request->poli);
        }

        $ok = $igd->get();

        if ($request['view']) {
            return view('sirs.laporan-tb-igd', compact('igd', 'ok', 'poli'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan TB IGD ', function ($excel) use ($ok) {
                // Set the properties
                $excel->setTitle('Laporan TB IGD')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan TB IGD');
                $excel->sheet('Laporan TB IGD', function ($sheet) use ($ok) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Pasien',
                        'RM',
                        'NIK',
                        'Dokter',
                        'Kasus 1',
                        'Kasus 2',
                        'Rujuk Ke',
                        'Tgl. Registrasi',
                        'Poli',
                        'Diagnosa Awal',
                        'Diagnosa Akhir',
                        'ICD 9',
                        'ICD 10',
                        'Keterangan',
                        'Asuransi',
                        'Alamat',
                        'Provinsi',
                        'Kabupaten',
                        'Kecamatan',
                        'Kelurahan'
                    ]);
                    foreach ($ok as $key => $d) {

                        $reg = Registrasi::find($d->registrasi_id);
                        $icd9 = PerawatanIcd9::where('registrasi_id', $reg->id)->first();
                        $pasien = Registrasi::where('pasien_id', $reg->pasien_id)->count();

                        if ($pasien > 1) {
                            $kasus = 'Lama';
                        } else {
                            $kasus = 'Baru';
                        }

                        $jk = null;
                        $sheet->row(++$row, [
                            $no++,
                            baca_pasien(@$reg->pasien_id),
                            @$reg->pasien->no_rm,
                            " " . strval(@$reg->pasien->nik),
                            baca_dokter(@$reg->dokter_id),
                            @$reg->status,
                            @$kasus,
                            @baca_rujukan(@$reg->rujukan),
                            Carbon::parse(@$reg->created_at)->format('d-m-Y'),
                            baca_poli(@$reg->poli_id),
                            @baca_diagnosa(@$reg->diagnosa_awal),
                            @baca_diagnosa(@$reg->diagnosa_akhir),
                            @baca_icd9(@$icd9->icd9),
                            baca_icd10(@$d->icd10),
                            @$reg->keterangan,
                            @baca_jkn(@$reg->id),
                            @$reg->pasien->alamat,
                            baca_propinsi(@$reg->pasien->province_id),
                            baca_kabupaten(@$reg->pasien->regency_id),
                            baca_kecamatan(@$reg->pasien->district_id),
                            baca_kelurahan(@$reg->pasien->village_id)
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function laporanTbIrna()
    {
        $icd10 = Icd10::where('id', '>=', 71)->where('id', '<=', 112)->pluck('nomor');

        $data['irj'] = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', 'TI')
            ->whereIn('perawatan_icd10s.icd10', $icd10)
            ->select('perawatan_icd10s.icd10 as icd10', 'registrasis.id as reg_id', 'registrasis.tipe_jkn as tipe_jkn', 'registrasis.dokter_id as dokter_id', 'registrasis.status as status', 'registrasis.rujukan as rujukkan', 'registrasis.diagnosa_awal as diagnosa_awal', 'registrasis.keterangan as keterangan', 'registrasis.created_at as tgl_regis', 'rawatinaps.kelompokkelas_id as kelompok', 'rawatinaps.tgl_masuk as tgl_masuk', 'rawatinaps.tgl_keluar as tgl_keluar', 'pasiens.id as pasien_id', 'pasiens.no_rm as no_rm', 'pasiens.nik as nik', 'pasiens.alamat as alamat', 'pasiens.province_id as province_id', 'pasiens.regency_id as regency_id', 'pasiens.district_id as district_id', 'pasiens.village_id as village_id')
            ->limit(10)
            ->get();
        $data['poli'] = Poli::pluck('nama', 'id');

        return view('sirs.laporan-tb-irna', $data)->with('no', 1);
    }

    public function laporanTbIrnaByTanggal(Request $request)
    {
        $poli = Poli::pluck('nama', 'id');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $icd10 = Icd10::where('id', '>=', 71)->where('id', '<=', 112)->pluck('nomor');
        // dd($icd10);

        $irna = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', 'TI')
            ->select('perawatan_icd10s.icd10 as icd10', 'registrasis.id as reg_id', 'registrasis.tipe_jkn as tipe_jkn', 'registrasis.dokter_id as dokter_id', 'registrasis.status as status', 'registrasis.rujukan as rujukkan', 'registrasis.diagnosa_awal as diagnosa_awal', 'registrasis.keterangan as keterangan', 'registrasis.created_at as tgl_regis', 'rawatinaps.kelompokkelas_id as kelompok', 'rawatinaps.tgl_masuk as tgl_masuk', 'rawatinaps.tgl_keluar as tgl_keluar', 'pasiens.id as pasien_id', 'pasiens.no_rm as no_rm', 'pasiens.nik as nik', 'pasiens.alamat as alamat', 'pasiens.province_id as province_id', 'pasiens.regency_id as regency_id', 'pasiens.district_id as district_id', 'pasiens.village_id as village_id')
            ->limit(1000);

        $irna = $irna->whereIn('perawatan_icd10s.icd10', $icd10);
        if ($request->poli != '') {
            $irna = $irna->where('registrasis.poli_id', $request->poli);
        }

        $ok = $irna->get();

        if ($request['view']) {
            return view('sirs.laporan-tb-irna', compact('irna', 'ok', 'poli'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan TB IRNA ', function ($excel) use ($ok) {
                // Set the properties
                $excel->setTitle('Laporan TB IRNA')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan TB IRNA');
                $excel->sheet('Laporan TB IRNA', function ($sheet) use ($ok) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Pasien',
                        'RM',
                        'NIK',
                        'Dokter',
                        'Kasus 1',
                        'Kasus 2',
                        'Rujuk Ke',
                        'Tgl. Registrasi',
                        'Ruangan',
                        'Tgl. Masuk',
                        'Tgl. Keluar',
                        'Diagnosa Awal',
                        'Diagnosa Akhir',
                        'ICD 9',
                        'ICD 10',
                        'Keterangan',
                        'Asuransi',
                        'Alamat',
                        'Provinsi',
                        'Kabupaten',
                        'Kecamatan',
                        'Kelurahan'
                    ]);
                    foreach ($ok as $key => $d) {

                        // $reg = Registrasi::find($d->registrasi_id);
                        $icd9 = PerawatanIcd9::where('registrasi_id', $d->reg_id)->first();
                        // $ranap = Rawatinap::where('registrasi_id', $reg->id)->first();
                        $pasien = Registrasi::where('pasien_id', $d->pasien_id)->count();

                        if ($pasien > 1) {
                            $kasus = 'Lama';
                        } else {
                            $kasus = 'Baru';
                        }

                        $jk = null;
                        $sheet->row(++$row, [
                            $no++,
                            baca_pasien(@$d->pasien_id),
                            @$d->no_rm,
                            " " . strval(@$d->nik),
                            baca_dokter(@$d->dokter_id),
                            @$d->status,
                            @$kasus,
                            baca_rujukan(@$d->rujukkan),
                            Carbon::parse(@$d->tgl_regis)->format('d-m-Y'),
                            baca_kelompok(@$d->kelompok),
                            Carbon::parse(@$d->tgl_masuk)->format('d-m-Y'),
                            Carbon::parse(@$d->tgl_keluar)->format('d-m-Y'),
                            @baca_diagnosa(@$d->diagnosa_awal),
                            @baca_diagnosa(@$d->diagnosa_akhir),
                            baca_icd9(@$icd9->icd9),
                            baca_icd10(@$d->icd10),
                            @$d->keterangan,
                            @$d->tipe_jkn,
                            @$d->alamat,
                            baca_propinsi(@$d->province_id),
                            baca_kabupaten(@$d->regency_id),
                            baca_kecamatan(@$d->district_id),
                            baca_kelurahan(@$d->village_id)
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function laporanDB()
    {
        $data['dbd'] = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('registrasis.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->whereIn('perawatan_icd10s.icd10', ['A90', 'A91'])
            ->select('perawatan_icd10s.icd10 as icd10', 'registrasis.id as reg_id', 'registrasis.tipe_jkn as tipe_jkn', 'registrasis.dokter_id as dokter_id', 'registrasis.status as status', 'registrasis.rujukan as rujukkan', 'registrasis.diagnosa_awal as diagnosa_awal', 'registrasis.keterangan as keterangan', 'registrasis.created_at as tgl_regis', 'pasiens.id as pasien_id', 'pasiens.no_rm as no_rm', 'pasiens.nik as nik', 'pasiens.alamat as alamat', 'pasiens.province_id as province_id', 'pasiens.regency_id as regency_id', 'pasiens.district_id as district_id', 'pasiens.village_id as village_id')
            ->get();

        return view('sirs.laporan-db', $data)->with('no', 1);
    }

    public function laporanDBByTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $dbd = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
            ->whereIn('perawatan_icd10s.icd10', ['A90', 'A91'])
            ->select('perawatan_icd10s.icd10 as icd10', 'registrasis.id as reg_id', 'registrasis.tipe_jkn as tipe_jkn', 'registrasis.dokter_id as dokter_id', 'registrasis.status as status', 'registrasis.rujukan as rujukkan', 'registrasis.diagnosa_awal as diagnosa_awal', 'registrasis.keterangan as keterangan', 'registrasis.created_at as tgl_regis', 'pasiens.id as pasien_id', 'pasiens.no_rm as no_rm', 'pasiens.nik as nik', 'pasiens.alamat as alamat', 'pasiens.province_id as province_id', 'pasiens.regency_id as regency_id', 'pasiens.district_id as district_id', 'pasiens.village_id as village_id')
            ->get();

        if ($request['view']) {
            return view('sirs.laporan-db', compact('dbd', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan DB ', function ($excel) use ($dbd) {
                // Set the properties
                $excel->setTitle('Laporan DB')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan DB');
                $excel->sheet('Laporan DB', function ($sheet) use ($dbd) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Pasien',
                        'RM',
                        'NIK',
                        'Dokter',
                        'Kasus',
                        'Rujuk Ke',
                        'Tgl. Registrasi',
                        'ICD 9',
                        'ICD 10',
                        'Keterangan',
                        'Asuransi',
                        'Alamat',
                        'Provinsi',
                        'Kabupaten',
                        'Kecamatan',
                        'Kelurahan'
                    ]);
                    foreach ($dbd as $key => $d) {
                        $icd9 = PerawatanIcd9::where('registrasi_id', $d->reg_id)->first();
                        $pasien = Registrasi::where('pasien_id', $d->pasien_id)->count();

                        if ($pasien > 1) {
                            $kasus = 'Lama';
                        } else {
                            $kasus = 'Baru';
                        }

                        $jk = null;
                        $sheet->row(++$row, [
                            $no++,
                            baca_pasien(@$d->pasien_id),
                            @$d->no_rm,
                            " " . strval(@$d->nik),
                            baca_dokter(@$d->dokter_id),
                            @$kasus,
                            baca_rujukan(@$d->rujukkan),
                            Carbon::parse(@$d->tgl_regis)->format('d-m-Y'),
                            baca_icd9(@$icd9->icd9),
                            baca_icd10(@$d->icd10),
                            @$d->keterangan,
                            @$d->tipe_jkn,
                            @$d->alamat,
                            baca_propinsi(@$d->province_id),
                            baca_kabupaten(@$d->regency_id),
                            baca_kecamatan(@$d->district_id),
                            baca_kelurahan(@$d->village_id)
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function laporanEmrDokter()
    {
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        return view('sirs.laporan-emr-dokter', $data);
    }

    public function laporanEmrDokterByTanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request->tga) . ' 00:00:00';
        $tgb = valid_date($request->tgb) . ' 23:59:59';
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['registrasi'] = Registrasi::with(['pasien', 'dokter_umum', 'aswal', 'cppt', 'eResepTTE']);
        $data['filter_dokter'] = $request->dokter;
        $data['tga'] = $tga;
        $data['tgb'] = $tgb;
        $data['filter_poli'] = $request->poli;

        if (!empty($request->poli)) {
            $data['registrasi'] = $data['registrasi']->where('poli_id', $request->poli);
        }
        if (!empty($request->dokter)) {
            $data['registrasi'] = $data['registrasi']->where('dokter_id', $request->dokter);
        }
        if (!empty($tga) && !empty($tgb)) {
            $data['registrasi'] = $data['registrasi']->whereBetween('created_at', [$tga, $tgb]);
        }

        $data['registrasi'] = $data['registrasi']->select('id', 'dokter_id', 'pasien_id', 'poli_id', 'tte_resume_pasien', 'tte_resume_pasien_status')->get()->map(function ($reg) {
            // $pegawai = Pegawai::find($reg->dokter_id);
            $pegawai = $reg->dokter_umum;
            $reg->aswal_dokter = $reg->aswal->filter(function ($item) use ($pegawai) {
                return ($item->user_id == $pegawai->user_id || $item->userdokter_id == $pegawai->user_id);
            });
            $reg->cppt_dokter = $reg->cppt->filter(function ($item) use ($pegawai) {
                return $item->user_id == $pegawai->user_id;
            });
            return $reg;
        });
        if ($request->view) {
            return view('sirs.laporan-emr-dokter', $data);
        } elseif ($request->excel) {
            Excel::create('Laporan Pengisian EMR Dokter ', function ($excel) use ($data, $tga, $tgb, $request) {
                $registrasi = $data['registrasi'];
                // Set the properties
                $excel->setTitle('Laporan Pengisian EMR')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengisian EMR');
                // $excel->sheet('Laporan DB', function ($sheet) use ($data, $tga, $tgb, $request) {
                //     $emrLengkap = 0;
                //     $row = 4;
                //     $no = 1;
                //     $sheet->row(1, [
                //         'Tanggal',
                //         $tga,
                //         $tgb,
                //     ]);
                //     $sheet->row(2, [
                //         'Poliklinik',
                //         baca_poli($request->poli)
                //     ]);
                //     $sheet->row(3, [
                //         'Dokter',
                //         baca_dokter($request->dokter)
                //     ]);
                //     $sheet->row($row, [
                //         'No',
                //         'Pasien',
                //         'RM',
                //         'NIK',
                //         'Dokter',
                //         'ASWAL',
                //         'CPPT',
                //         'RESUME TTE',
                //         'E-RESEP TTE',
                //     ]);
                //     foreach ($data['registrasi'] as $key => $d) {
                //         $status = '(*)'; // Tidak Lengkap
                //         if (!empty(json_decode(@$d->tte_resume_pasien)->base64_signed_file) || @$d->tte_resume_pasien_status) {
                //             $emrLengkap++;
                //             $status = '';
                //         }
                //         $sheet->row(++$row, [
                //             $no++,
                //             @$d->pasien->nama.' '.@$status,
                //             @$d->pasien->no_rm,
                //             " " . strval(@$d->pasien->nik),
                //             @$d->dokter_umum->nama,
                //             count(@$d->aswal_dokter) > 0 ? 'Lengkap' : '-',
                //             count(@$d->cppt_dokter) > 0 ? 'Lengkap' : '-',
                //             !empty(json_decode(@$d->tte_resume_pasien)->base64_signed_file) > 0 ? 'Lengkap' : '-',
                //             @$d->eResepTTE ? 'Lengkap' : '-',
                //         ]);
                //     }
                //     $filter_tga = $tga ? date('d m Y', strtotime($tga)) : '-';
                //     $filter_tgb = $tgb ? date('d m Y', strtotime($tgb)) : '-';
                //     $sheet->row(++$row, [
                //         'JUMLAH KUNJUNGAN PASIEN PADA TANGGAL' . $filter_tga . 'SAMPAI DENGAN' . $filter_tgb . 'ADALAH' . count($data['registrasi']) . 'PASIEN.'
                //     ]);
                //     $sheet->row(++$row, [
                //         'DATA PENGISIAN PASIEN YANG DILAKUKAN OLEH DOKTER ADALAH ' . $emrLengkap . ' DATA'
                //     ]);
                //     $sheet->row(++$row, [
                //         'Keterangan: * = Pengisian Tidak Lengkap'
                //     ]);
                // });
                $excel->sheet('Sheet1', function ($sheet) use ($registrasi) {
                    $sheet->loadView('sirs.excel.laporan-emr-dokter', [
                        'registrasi' => $registrasi,
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function laporanEmrPerawat()
    {
        $data['poli'] = Poli::where('politype', 'J')->pluck('nama', 'id');
        $data['perawats'] = [];
        return view('sirs.laporan-emr-perawat', $data);
    }

    public function laporanEmrPerawatByTanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request->tga) . ' 00:00:00';
        $tgb = valid_date($request->tgb) . ' 23:59:59';
        $data['poli'] = Poli::where('politype', 'J')->pluck('nama', 'id');
        $data['perawats'] = [];
        $data['registrasi'] = Registrasi::with(['pasien', 'dokter_umum', 'aswal', 'cppt', 'askep_and_askeb']);
        $data['tga'] = $tga;
        $data['tgb'] = $tgb;
        $data['filter_poli'] = $request->poli;

        if (!empty($request->poli)) {
            $data['registrasi'] = $data['registrasi']->where('poli_id', $request->poli);
            $poli = Poli::where('id', $request->poli)->select('perawat_id')->first();
            $perawatPoli = @(explode(",", $poli->perawat_id));
            $data['perawats'] = Pegawai::whereIn('id', $perawatPoli)->pluck('nama', 'id');
        }

        $perawat = null;
        if (!empty($request->perawat)) {
            $perawat = Pegawai::find($request->perawat);
            $poli = Poli::where('id', $request->poli)->select('perawat_id')->first();
            $data['perawatSelect'] = $request->perawat;
        }

        if (!empty($tga) && !empty($tgb)) {
            $data['registrasi'] = $data['registrasi']->whereBetween('created_at', [$tga, $tgb]);
        }

        $data['registrasi'] = $data['registrasi']->select('id', 'pasien_id', 'dokter_id')->get()->map(function ($reg) use ($perawat) {
            // $pegawai = Pegawai::find($reg->dokter_id); //dokter
            $pegawai = $reg->dokter_umum; //dokter
            if ($perawat) {
                $pegawai = $perawat;
            }
            $reg->aswal_perawat = $reg->aswal->filter(function ($item) use ($pegawai, $perawat) {
                return $perawat ? $item->user_id == $pegawai->user_id : $item->user_id != $pegawai->user_id;
            });
            $reg->cppt_perawat = $reg->cppt->filter(function ($item) use ($pegawai, $perawat) {
                return $perawat ? $item->user_id == $pegawai->user_id : $item->user_id != $pegawai->user_id;
            });
            return $reg;
        });

        if ($request->view) {
            return view('sirs.laporan-emr-perawat', $data);
        } elseif ($request->excel) {
            Excel::create('Laporan Pengisian EMR Perawat ', function ($excel) use ($data, $tga, $tgb, $request) {
                // Set the properties
                $excel->setTitle('Laporan DB')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan DB');
                $excel->sheet('Laporan DB', function ($sheet) use ($data, $tga, $tgb, $request) {
                    $emrLengkap = 0;
                    $row = 4;
                    $no = 1;
                    $sheet->row(1, [
                        'Tanggal',
                        $tga,
                        $tgb,
                    ]);
                    $sheet->row(2, [
                        'Poliklinik',
                        baca_poli($request->poli)
                    ]);
                    $sheet->row($row, [
                        'No',
                        'Pasien',
                        'RM',
                        'NIK',
                        'ASWAL',
                        'CPPT',
                        'RESUME',
                    ]);
                    foreach ($data['registrasi'] as $key => $d) {
                        if ((count($d->aswal_perawat) > 0 || count($d->cppt_perawat) > 0) && count($d->askep_and_askeb) > 0) {
                            $emrLengkap++;
                        }
                        $sheet->row(++$row, [
                            $no++,
                            baca_pasien(@$d->pasien_id),
                            @$d->no_rm,
                            " " . strval(@$d->nik),
                            count(@$d->aswal_perawat) > 0 ? 'Lengkap' : '-',
                            count(@$d->cppt_perawat) > 0 ? 'Lengkap' : '-',
                            count(@$d->askep_and_askeb) > 0 ? 'Lengkap' : '-',
                        ]);
                    }
                    $filter_tga = $tga ? date('d m Y', strtotime($tga)) : '-';
                    $filter_tgb = $tgb ? date('d m Y', strtotime($tgb)) : '-';
                    $sheet->row(++$row, [
                        'JUMLAH KUNJUNGAN PASIEN PADA TANGGAL' . $filter_tga . 'SAMPAI DENGAN' . $filter_tgb . 'ADALAH' . count($data['registrasi']) . 'PASIEN.'
                    ]);
                    $sheet->row(++$row, [
                        'DATA PENGISIAN PASIEN YANG DILAKUKAN OLEH PERAWAT ADALAH ' . $emrLengkap . ' DATA'
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function getPerawat(Request $request)
    {
        $poli = Poli::where('id', $request->poli)->select('perawat_id')->first();
        if (!$poli) {
            $data['metaData'] = [
                'code' => 404,
                'message' => 'Poli Not Found',
            ];
            return response()->json($data);
        }
        $perawats = @(explode(",", $poli->perawat_id));

        $data = [];
        $data['metaData'] = [
            'code' => 200,
            'message' => 'Success'
        ];

        foreach ($perawats as $perawat) {
            $perawat = Pegawai::find($perawat);
            $data['list'][] = [
                'namaPerawat' => $perawat->nama,
                'idPerawat' => $perawat->id,
            ];
        }

        // dd($data);
        return response()->json($data);
    }

    public function restriksiObat()
    {
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        return view('sirs.laporan-restriksi-obat', $data);
    }

    public function restriksiObatBy(Request $request)
    {
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $dokter = Pegawai::find($request['dokter']);
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $data['hari'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $data['bulan'] = $now->formatLocalized('%B');
        $resep = ResepNote::with('resep_detail.logistik_batch')
            ->where('created_by', $dokter->user_id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get()
            ->map(function ($resep) {
                $resep->total_harga = $resep->resep_detail->sum(function ($detail) {
                    return $detail->qty * $detail->logistik_batch->hargajual_umum;
                });
                return $resep;
            });

        $data['resep'] = $resep->groupBy(function ($item) {
            return $item->created_at->format('d');
        })->map(function ($groupedItems) {
            $total = $groupedItems->sum('total_harga');
            return $total;
        });
        return view('sirs.laporan-restriksi-obat', $data);
    }

    public function penyakitLuarRawatInap()
    {

        $data['tga'] = '';
        $data['tgb'] = '';

        $data['p_icd10'] = [];

        return view('sirs.rl.penyakit-rawat-inap-sebab-luar', $data)->with('no', 1);
    }

    public function penyakitLuarRawatInapFilter(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request->tga) . ' 00:00:00';
        $tgb = valid_date($request->tgb) . ' 23:59:59';

        $data['tga'] = $request->tga;
        $data['tgb'] = $request->tgb;

        $data['p_icd10'] = PerawatanIcd9::leftJoin('registrasis', 'registrasis.id', '=', 'perawatan_icd9s.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'perawatan_icd9s.registrasi_id')
            ->leftJoin('histori_rawatinap', 'histori_rawatinap.registrasi_id', '=', 'perawatan_icd9s.registrasi_id')
            ->whereNotNull('perawatan_icd9s.icd9')
            ->where('perawatan_icd9s.jenis', 'TI')
            ->whereBetween('perawatan_icd9s.created_at', [$tga, $tgb])
            ->select(
                DB::raw('GROUP_CONCAT(perawatan_icd10s.icd10 SEPARATOR "||") as daftar'),
                DB::raw('GROUP_CONCAT(pasiens.tgllahir SEPARATOR "||") as lahir'),
                DB::raw('GROUP_CONCAT(pasiens.kelamin SEPARATOR "||") as gender'),
                DB::raw('GROUP_CONCAT(pasiens.id SEPARATOR "||") as pasien_id'),
                DB::raw('GROUP_CONCAT(registrasis.status SEPARATOR "||") as status'),
                DB::raw('GROUP_CONCAT(registrasis.kondisi_akhir_pasien SEPARATOR "||") as kondisi_akhir'),
                DB::raw('GROUP_CONCAT(histori_rawatinap.mati SEPARATOR "||") as mati'),
                'perawatan_icd9s.icd9 as dtd'
            )
            ->groupBy('icd9')->orderBy('icd9', 'asc')->get();
        if ($request->submit == 'TAMPILKAN') {
            return view('sirs.rl.penyakit-rawat-inap-sebab-luar', $data)->with('no', 1);
        } elseif ($request->submit == 'EXCEL') {
            $p_icd10 = $data['p_icd10'];

            Excel::create('RL 4A Penyakit Rawat Inap (Sebab Luar)', function ($excel) use ($p_icd10) {
                $excel->setTitle('RL 4A Penyakit Rawat Inap (Sebab Luar)')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 4A Penyakit Rawat Inap (Sebab Luar)');

                $excel->sheet('Sheet1', function ($sheet) use ($p_icd10) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'DTD',
                        'TERPERINCI',
                        'Nama',
                        '6hr L',
                        '6hr P',
                        '6-28hr L',
                        '6-28hr P',
                        '28-1th L',
                        '28-1th P',
                        '1-4th L',
                        '1-4th P',
                        '4-14th L',
                        '4-14th P',
                        '14-24th L',
                        '14-24th P',
                        '24-44th L',
                        '24-44th P',
                        '44-64th L',
                        '44-64th P',
                        'L',
                        'P',
                        'Pasien Keluar (Hidup * Mati) L',
                        'Pasien Keluar (Hidup * Mati) P',
                        'Jumlah Pasien Keluar (Hidup & Mati)',
                        'Jumlah Pasien Keluar Mati',
                    ]);
                    foreach ($p_icd10 as $i) {
                        $kelamin = explode('||', $i['gender']);
                        $mati = array_count_values(explode('||', $i['mati']));
                        $jumlahPasienKeluar = count(array_unique(explode('||', $i['pasien_id'])));
                        $jumlahPasienKeluarMati = array_filter(explode('||', $i['kondisi_akhir']));
                        $pasienKeluar = array_filter(explode('||', $i['gender']));

                        $lahir = explode('||', $i['lahir']);
                        $gender = explode('||', $i['gender']);
                        $pasien_id = explode('||', $i['pasien_id']);

                        // dd( $pasien_id, $jumlahPasienKeluar );

                        $same = '';

                        $jmlPasienMati = 0;
                        $pasienKeluarLaki = 0;
                        $pasienKeluarPerempuan = 0;

                        $jkPasien = [];
                        $pasienLahir = [];
                        $pasienGender = [];

                        foreach ($pasien_id as $k => $v) {
                            if ($v != $same) {
                                $same = $v;
                                if (isset($jumlahPasienKeluarMati[$k])) {
                                    if ($jumlahPasienKeluarMati[$k] == 4) { // 4: pasien meninggal
                                        $jmlPasienMati += 1;
                                    }
                                }

                                if (isset($pasienKeluar[$k])) {
                                    if ($pasienKeluar[$k] == "L") { // pasien keluar
                                        $pasienKeluarLaki += 1;
                                    } else {
                                        $pasienKeluarPerempuan += 1;
                                    }
                                }

                                // pasien jenis kelamin
                                if (isset($kelamin[$k])) {
                                    $jkPasien[] = $kelamin[$k];
                                }
                                // lahir & gender
                                if (isset($lahir[$k])) {
                                    $pasienLahir[] = $lahir[$k];
                                }
                                if (isset($gender[$k])) {
                                    $pasienGender[] = $gender[$k];
                                }
                            }
                        }

                        $pasienLahirImplode = implode('||', $pasienLahir);
                        $pasienGenderImplode = implode('||', $pasienLahir);
                        // dd($pasienLahirImplode);
                        $gender = array_count_values($jkPasien);
                        $range = getRange($pasienLahirImplode, $pasienGenderImplode);

                        $_loop = [
                            $no++,
                            $i['dtd'],
                            '',
                            getICD9($i['dtd']),
                            $range[0],
                            $range[1],
                            $range[2],
                            $range[3],
                            $range[4],
                            $range[5],
                            $range[6],
                            $range[7],
                            $range[8],
                            $range[9],
                            $range[10],
                            $range[11],
                            $range[12],
                            $range[13],
                            $range[14],
                            $range[15],
                            $range[16],
                            $range[17],
                            (isset($gender['L'])) ? $gender['L'] : 0,
                            (isset($gender['P'])) ? $gender['P'] : 0,
                            $pasienKeluarLaki,
                            $pasienKeluarPerempuan,
                            $pasienKeluarPerempuan + $pasienKeluarLaki,
                            $jmlPasienMati,
                        ];
                        foreach (array_count_values(explode('||', $i['icd10'])) as $k => $v) {
                            $_loop[2] .= $k . ',';
                        }
                        $sheet->row(++$row, $_loop);
                    }
                });
            })->export('xlsx');
        }
    }

    public function laporanEvaluasiEmrDokter()
    {
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['dataEvaluasi'] = [];
        // $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        return view('sirs.laporan-evaluasi-emr-dokter', $data);
    }

    public function laporanEvaluasiEmrDokterByTanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request->tga) . ' 00:00:00';
        $tgb = valid_date($request->tgb) . ' 23:59:59';
        $data['poli'] = Poli::pluck('nama', 'id');
        $data['tga'] = $tga;
        $data['tgb'] = $tgb;
        $data['filter_poli'] = $request->poli;

        $dokters = Pegawai::where('kategori_pegawai', 1)->select('id', 'nama', 'user_id')->get();

        $registrasis = Registrasi::with(['aswal', 'cppt'])
            ->whereBetween('created_at', [$tga, $tgb])
            ->select('id', 'dokter_id', 'poli_id');

        if (!empty($request->poli)) {
            $registrasis = $registrasis->where('poli_id', $request->poli);
            $poli = Poli::find($request->poli);
            $dokterPoli = @(explode(",", $poli->dokter_id));
            $dokters = Pegawai::whereIn('id', $dokterPoli)->select('id', 'nama', 'user_id')->get();
        }

        $registrasis = $registrasis->get();

        $data['dataEvaluasi'] = [];

        foreach ($dokters as $key => $dokter) {
            $dokterRegistrasis = $registrasis->filter(function ($reg) use ($dokter) {
                return $reg->dokter_id == $dokter->id;
            });

            $dokterRegistrasis = $dokterRegistrasis->groupBy('poli_id');

            foreach ($dokterRegistrasis as $poli_id => $regis) {
                $emrTerisi = 0;
                $emrBelum = 0;
                foreach ($regis as $reg) {
                    $aswal = $reg->aswal->filter(function ($item) use ($dokter) {
                        return ($item->user_id == $dokter->user_id || $item->userdokter_id == $dokter->user_id);
                    });

                    $cppt = $reg->cppt->filter(function ($item) use ($dokter) {
                        return $item->user_id == $dokter->user_id;
                    });

                    if (count($aswal) > 0 || count($cppt) > 0) {
                        $emrTerisi++;
                    } else {
                        $emrBelum++;
                    }

                }

                $totalKunjungan = $regis->count();
                if ($emrTerisi > 0 && $totalKunjungan > 0) {
                    $kesimpulan = round(($emrTerisi / $totalKunjungan) * 100, 2);
                } else {
                    $kesimpulan = 0;
                }
                $data['dataEvaluasi'][$dokter->id][] = [
                    'namaDokter' => $dokter->nama,
                    'totalKunjungan' => $totalKunjungan,
                    'emrTerisi' => $emrTerisi,
                    'emrBelum' => $emrBelum,
                    'kesimpulan' => $kesimpulan,
                    'poli' => baca_poli($poli_id),
                ];
            }
        }


        if ($request->view) {
            return view('sirs.laporan-evaluasi-emr-dokter', $data);
        } elseif ($request->excel) {
            Excel::create('Lap Evaluasi Emr Dokter ', function ($excel) use ($data, $tga, $tgb, $request) {
                $dataEvaluasi = $data['dataEvaluasi'];
                // Set the properties
                $excel->setTitle('Lap Evaluasi Emr')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Lap Evaluasi Emr');
                $excel->sheet('Sheet1', function ($sheet) use ($dataEvaluasi) {
                    $sheet->loadView('sirs.excel.laporan-evaluasi-emr-dokter', [
                        'dataEvaluasi' => $dataEvaluasi,
                    ]);
                });
            })->export('xlsx');
        }
    }
}
