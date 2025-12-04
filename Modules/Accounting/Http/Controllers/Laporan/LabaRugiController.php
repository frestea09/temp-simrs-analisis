<?php

namespace Modules\Accounting\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\Master\AkunCOA;
use Excel;
use Modules\Accounting\Entities\Ekuitas;
use Modules\Accounting\Entities\Master\AkunType;
use Modules\Accounting\Helpers\Helper;

class LabaRugiController extends Controller
{
    public function index(Request $request)
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
            $request->request->add(['is_neraca' => 1]);
            $neraca = Helper::lap_perubahan_ekuitas($request);

            if ($post['excel'] == 'SAP') {
                Excel::load('laporan/Neraca SAP.xlsx', function ($doc) use ($data, $neraca) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data, $neraca) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang Berakhir sampai dengan 31 Desember " . $data['tha'] . " dan 31 Desember " . $data['ths']);
                        $sheet->setCellValue('C6', $data['tha']);
                        $sheet->setCellValue('D6', $data['ths']);

                        $alKBP = Helper::getPerhitungan($data['tha'], 4, '11103');
                        $sheet->setCellValue('C10', $alKBP['realisasi']);
                        $sheet->setCellValue('D10', $alKBP['realisasi_sebelum']);
                        $alKB = Helper::getPerhitungan($data['tha'], 4, '11104');
                        $sheet->setCellValue('C11', $alKB['realisasi']);
                        $sheet->setCellValue('D11', $alKB['realisasi_sebelum']);
                        $alKL = Helper::getPerhitungan($data['tha'], 4, '11105');
                        $sheet->setCellValue('C12', $alKL['realisasi']);
                        $sheet->setCellValue('D12', $alKL['realisasi_sebelum']);
                        $alIJP = Helper::getPerhitungan($data['tha'], 3, '112');
                        $sheet->setCellValue('C13', $alIJP['realisasi']);
                        $sheet->setCellValue('D13', $alIJP['realisasi_sebelum']);
                        $alPKO = Helper::getPerhitungan($data['tha'], 3, '113');
                        $sheet->setCellValue('C14', $alPKO['realisasi']);
                        $sheet->setCellValue('D14', $alPKO['realisasi_sebelum']);
                        $alPKNO = Helper::getPerhitungan($data['tha'], 3, '114');
                        $sheet->setCellValue('C15', $alPKNO['realisasi']);
                        $sheet->setCellValue('D15', $alPKNO['realisasi_sebelum']);
                        $alPPTT = Helper::getPerhitungan($data['tha'], 3, '115');
                        $sheet->setCellValue('C16', $alPPTT['realisasi']);
                        $sheet->setCellValue('D16', $alPPTT['realisasi_sebelum']);
                        $alUMB = Helper::getPerhitungan($data['tha'], 3, '116');
                        $sheet->setCellValue('C17', $alUMB['realisasi']);
                        $sheet->setCellValue('D17', $alUMB['realisasi_sebelum']);
                        $alPBL = Helper::getPerhitungan($data['tha'], 3, '117');
                        $sheet->setCellValue('C19', $alPBL['realisasi']);
                        $sheet->setCellValue('D19', $alPBL['realisasi_sebelum']);

                        $tAl = [
                            'realisasi'         => $alKBP['realisasi'] + $alKB['realisasi'] + $alKL['realisasi'] + $alIJP['realisasi'] + $alPKO['realisasi'] + $alPKNO['realisasi'] + $alPPTT['realisasi'] + $alUMB['realisasi'] + $alPBL['realisasi'],
                            'realisasi_sebelum' => $alKBP['realisasi_sebelum'] + $alKB['realisasi_sebelum'] + $alKL['realisasi_sebelum'] + $alIJP['realisasi_sebelum'] + $alPKO['realisasi_sebelum'] + $alPKNO['realisasi_sebelum'] + $alPPTT['realisasi_sebelum'] + $alUMB['realisasi_sebelum'] + $alPBL['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C20', $tAl['realisasi']);
                        $sheet->setCellValue('D20', $tAl['realisasi_sebelum']);

                        $atT = Helper::getPerhitungan($data['tha'], 3, '131');
                        $sheet->setCellValue('C23', $atT['realisasi']);
                        $sheet->setCellValue('D23', $atT['realisasi_sebelum']);
                        $atGB = Helper::getPerhitungan($data['tha'], 3, '133');
                        $sheet->setCellValue('C24', $atGB['realisasi']);
                        $sheet->setCellValue('D24', $atGB['realisasi_sebelum']);
                        $atPM = Helper::getPerhitungan($data['tha'], 3, '132');
                        $sheet->setCellValue('C25', $atPM['realisasi']);
                        $sheet->setCellValue('D25', $atPM['realisasi_sebelum']);
                        $atJIJ = Helper::getPerhitungan($data['tha'], 3, '134');
                        $sheet->setCellValue('C26', $atJIJ['realisasi']);
                        $sheet->setCellValue('D26', $atJIJ['realisasi_sebelum']);
                        $atATL = Helper::getPerhitungan($data['tha'], 3, '135');
                        $sheet->setCellValue('C27', $atATL['realisasi']);
                        $sheet->setCellValue('D27', $atATL['realisasi_sebelum']);
                        $atKDP = Helper::getPerhitungan($data['tha'], 3, '136');
                        $sheet->setCellValue('C28', $atKDP['realisasi']);
                        $sheet->setCellValue('D28', $atKDP['realisasi_sebelum']);
                        $atAP = Helper::getPerhitungan($data['tha'], 3, '137');
                        $sheet->setCellValue('C29', $atAP['realisasi']);
                        $sheet->setCellValue('D29', $atAP['realisasi_sebelum']);
                        // $atBDD = Helper::getPerhitungan($data['tha'], 3, '114');
                        // $sheet->setCellValue('C15', $atBDD['realisasi']);
                        // $sheet->setCellValue('D15', $atBDD['realisasi_sebelum']);
                        // $atPBLU = Helper::getPerhitungan($data['tha'], 3, '115');
                        // $sheet->setCellValue('C16', $atPBLU['realisasi']);
                        // $sheet->setCellValue('D16', $atPBLU['realisasi_sebelum']);

                        $tAt = [
                            'realisasi'         => $atT['realisasi'] + $atGB['realisasi'] + $atPM['realisasi'] + $atJIJ['realisasi'] + $atATL['realisasi'] + $atKDP['realisasi'] + $atAP['realisasi'],
                            'realisasi_sebelum' => $atT['realisasi_sebelum'] + $atGB['realisasi_sebelum'] + $atPM['realisasi_sebelum'] + $atJIJ['realisasi_sebelum'] + $atATL['realisasi_sebelum'] + $atKDP['realisasi_sebelum'] + $atAP['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C33', $tAt['realisasi']);
                        $sheet->setCellValue('D33', $tAt['realisasi_sebelum']);

                        $pjpTPA = Helper::getPerhitungan($data['tha'], 4, '15101');
                        $sheet->setCellValue('C36', $pjpTPA['realisasi']);
                        $sheet->setCellValue('D36', $pjpTPA['realisasi_sebelum']);
                        $pjpTTG = Helper::getPerhitungan($data['tha'], 4, '15102');
                        $sheet->setCellValue('C37', $pjpTTG['realisasi']);
                        $sheet->setCellValue('D37', $pjpTTG['realisasi_sebelum']);
                        // $pjpPPTT = Helper::getPerhitungan($data['tha'], 3, '132');
                        // $sheet->setCellValue('C25', $pjpPPTT['realisasi']);
                        // $sheet->setCellValue('D25', $pjpPPTT['realisasi_sebelum']);

                        $tPJP = [
                            'realisasi'         => $pjpTPA['realisasi'] + $pjpTTG['realisasi'],
                            'realisasi_sebelum' => $pjpTPA['realisasi_sebelum'] + $pjpTTG['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C39', $tPJP['realisasi']);
                        $sheet->setCellValue('D39', $tPJP['realisasi_sebelum']);

                        $alKPK = Helper::getPerhitungan($data['tha'], 3, '152');
                        $sheet->setCellValue('C42', $alKPK['realisasi']);
                        $sheet->setCellValue('D42', $alKPK['realisasi_sebelum']);
                        // $alDK = Helper::getPerhitungan($data['tha'], 4, '15102');
                        // $sheet->setCellValue('C37', $alDK['realisasi']);
                        // $sheet->setCellValue('D37', $alDK['realisasi_sebelum']);
                        // $alAP = Helper::getPerhitungan($data['tha'], 4, '15102');
                        // $sheet->setCellValue('C37', $alAP['realisasi']);
                        // $sheet->setCellValue('D37', $alAP['realisasi_sebelum']);
                        $alATB = Helper::getPerhitungan($data['tha'], 3, '153');
                        $sheet->setCellValue('C45', $alATB['realisasi']);
                        $sheet->setCellValue('D45', $alATB['realisasi_sebelum']);
                        $alALL = Helper::getPerhitungan($data['tha'], 3, '154');
                        $sheet->setCellValue('C46', $alALL['realisasi']);
                        $sheet->setCellValue('D46', $alALL['realisasi_sebelum']);
                        // $alAA = Helper::getPerhitungan($data['tha'], 4, '15102');
                        // $sheet->setCellValue('C37', $alAA['realisasi']);
                        // $sheet->setCellValue('D37', $alAA['realisasi_sebelum']);

                        $tAlain = [
                            'realisasi'         => $alKPK['realisasi'] + $alATB['realisasi'] + $alALL['realisasi'],
                            'realisasi_sebelum' => $alKPK['realisasi_sebelum'] + $alATB['realisasi_sebelum'] + $alALL['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C48', $tAlain['realisasi']);
                        $sheet->setCellValue('D48', $tAlain['realisasi_sebelum']);

                        $tAset = [
                            'realisasi'         => $tAl['realisasi'] + $tAt['realisasi'] + $tPJP['realisasi'] + $tAlain['realisasi'],
                            'realisasi_sebelum' => $tAl['realisasi_sebelum'] + $tAt['realisasi_sebelum'] + $tPJP['realisasi_sebelum'] + $tAlain['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C49', $tAset['realisasi']);
                        $sheet->setCellValue('D49', $tAset['realisasi_sebelum']);

                        // $kUU = Helper::getPerhitungan($data['tha'], 3, '152');
                        // $sheet->setCellValue('C42', $kUU['realisasi']);
                        // $sheet->setCellValue('D42', $kUU['realisasi_sebelum']);
                        $kUPK = Helper::getPerhitungan($data['tha'], 3, '211');
                        $sheet->setCellValue('C55', $kUPK['realisasi']);
                        $sheet->setCellValue('D55', $kUPK['realisasi_sebelum']);
                        // $kUP = Helper::getPerhitungan($data['tha'], 4, '15102');
                        // $sheet->setCellValue('C37', $kUP['realisasi']);
                        // $sheet->setCellValue('D37', $kUP['realisasi_sebelum']);
                        // $kUKUN = Helper::getPerhitungan($data['tha'], 3, '153');
                        // $sheet->setCellValue('C45', $kUKUN['realisasi']);
                        // $sheet->setCellValue('D45', $kUKUN['realisasi_sebelum']);
                        $kBLUP = Helper::getPerhitungan($data['tha'], 3, '213');
                        $sheet->setCellValue('C58', $kBLUP['realisasi']);
                        $sheet->setCellValue('D58', $kBLUP['realisasi_sebelum']);
                        // $kBMH = Helper::getPerhitungan($data['tha'], 4, '15102');
                        // $sheet->setCellValue('C37', $kBMH['realisasi']);
                        // $sheet->setCellValue('D37', $kBMH['realisasi_sebelum']);
                        $kPDD = Helper::getPerhitungan($data['tha'], 3, '214');
                        $sheet->setCellValue('C60', $kPDD['realisasi']);
                        $sheet->setCellValue('D60', $kPDD['realisasi_sebelum']);
                        $kUJPL = Helper::getPerhitungan($data['tha'], 3, '216');
                        $sheet->setCellValue('C61', $kUJPL['realisasi']);
                        $sheet->setCellValue('D61', $kUJPL['realisasi_sebelum']);

                        $tKJPan = [
                            'realisasi'         => $kUPK['realisasi'] + $kBLUP['realisasi'] + $kPDD['realisasi'] + $kUJPL['realisasi'],
                            'realisasi_sebelum' => $kUPK['realisasi_sebelum'] + $kBLUP['realisasi_sebelum'] + $kPDD['realisasi_sebelum'] + $kUJPL['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C62', $tKJPan['realisasi']);
                        $sheet->setCellValue('D62', $tKJPan['realisasi_sebelum']);

                        $kKJP = Helper::getPerhitungan($data['tha'], 2, '22');
                        $sheet->setCellValue('C65', $kKJP['realisasi']);
                        $sheet->setCellValue('D65', $kKJP['realisasi_sebelum']);

                        $tKJPen = [
                            'realisasi'         => $kKJP['realisasi'],
                            'realisasi_sebelum' => $kKJP['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C66', $tKJPen['realisasi']);
                        $sheet->setCellValue('D66', $tKJPen['realisasi_sebelum']);

                        $tK = [
                            'realisasi'         => $tKJPan['realisasi'] + $tKJPen['realisasi'],
                            'realisasi_sebelum' => $tKJPan['realisasi_sebelum'] + $tKJPen['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C67', $tK['realisasi']);
                        $sheet->setCellValue('D67', $tK['realisasi_sebelum']);

                        $sheet->setCellValue('C70', $neraca['ekuitas_now_sum']);
                        $sheet->setCellValue('D70', $neraca['ekuitas_before_sum']);

                        $tE = [
                            'realisasi'         => $neraca['ekuitas_now_sum'],
                            'realisasi_sebelum' => $neraca['ekuitas_before_sum'],
                        ];
                        $sheet->setCellValue('C71', $tE['realisasi']);
                        $sheet->setCellValue('D71', $tE['realisasi_sebelum']);

                        $tKE = [
                            'realisasi'         => $tK['realisasi'] + $tE['realisasi'],
                            'realisasi_sebelum' => $tK['realisasi_sebelum'] + $tE['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('C72', $tKE['realisasi']);
                        $sheet->setCellValue('D72', $tKE['realisasi_sebelum']);
                    });
                })->download('xlsx');
            } else {
                Excel::load('laporan/Neraca SAK.xlsx', function ($doc) use ($data, $neraca) {
                    $doc->sheet('Sheet1', function ($sheet) use ($data, $neraca) {
                        $sheet->setCellValue('A4', "Untuk Tahun yang berakhir sampai dengan 31 Desember " . $data['tha'] . " dan " . $data['ths']);
                        $sheet->setCellValue('D6', $data['tha']);
                        $sheet->setCellValue('E6', $data['ths']);

                        $alKSK = Helper::getPerhitungan($data['tha'], 3, '111');
                        $sheet->setCellValue('D10', $alKSK['realisasi']);
                        $sheet->setCellValue('E10', $alKSK['realisasi_sebelum']);
                        $alP = Helper::getPerhitungan($data['tha'], 3, '113');
                        $sheet->setCellValue('D11', $alP['realisasi']);
                        $sheet->setCellValue('E11', $alP['realisasi_sebelum']);
                        $alPB = Helper::getPerhitungan($data['tha'], 3, '115');
                        $sheet->setCellValue('D13', $alPB['realisasi']);
                        $sheet->setCellValue('E13', $alPB['realisasi_sebelum']);
                        $alPer = Helper::getPerhitungan($data['tha'], 3, '117');
                        $sheet->setCellValue('D14', $alPer['realisasi']);
                        $sheet->setCellValue('E14', $alPer['realisasi_sebelum']);

                        $tAL = [
                            'realisasi'         => $alKSK['realisasi'] + $alP['realisasi'] + $alPB['realisasi'] + $alPer['realisasi'],
                            'realisasi_sebelum' => $alKSK['realisasi_sebelum'] + $alP['realisasi_sebelum'] + $alPB['realisasi_sebelum'] + $alPer['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D15', $tAL['realisasi']);
                        $sheet->setCellValue('E15', $tAL['realisasi_sebelum']);

                        $atT = Helper::getPerhitungan($data['tha'], 3, '131');
                        $sheet->setCellValue('D17', $atT['realisasi']);
                        $sheet->setCellValue('E17', $atT['realisasi_sebelum']);
                        $atPM = Helper::getPerhitungan($data['tha'], 3, '132');
                        $sheet->setCellValue('D18', $atPM['realisasi']);
                        $sheet->setCellValue('E18', $atPM['realisasi_sebelum']);
                        $atGB = Helper::getPerhitungan($data['tha'], 3, '133');
                        $sheet->setCellValue('D19', $atGB['realisasi']);
                        $sheet->setCellValue('E19', $atGB['realisasi_sebelum']);
                        $atJIJ = Helper::getPerhitungan($data['tha'], 3, '134');
                        $sheet->setCellValue('D20', $atJIJ['realisasi']);
                        $sheet->setCellValue('E20', $atJIJ['realisasi_sebelum']);
                        $atKDP = Helper::getPerhitungan($data['tha'], 3, '136');
                        $sheet->setCellValue('D21', $atKDP['realisasi']);
                        $sheet->setCellValue('E21', $atKDP['realisasi_sebelum']);
                        $atAPAT = Helper::getPerhitungan($data['tha'], 3, '137');
                        $sheet->setCellValue('D22', $atAPAT['realisasi']);
                        $sheet->setCellValue('E22', $atAPAT['realisasi_sebelum']);

                        $tAT = [
                            'realisasi'         => $atT['realisasi'] + $atPM['realisasi'] + $atGB['realisasi'] + $atJIJ['realisasi'] + $atKDP['realisasi'] + $atAPAT['realisasi'],
                            'realisasi_sebelum' => $atT['realisasi_sebelum'] + $atPM['realisasi_sebelum'] + $atGB['realisasi_sebelum'] + $atJIJ['realisasi_sebelum'] + $atKDP['realisasi_sebelum'] + $atAPAT['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D23', $tAT['realisasi']);
                        $sheet->setCellValue('E23', $tAT['realisasi_sebelum']);

                        $atAL = Helper::getPerhitungan($data['tha'], 3, '135');
                        $sheet->setCellValue('D24', $atAL['realisasi']);
                        $sheet->setCellValue('E24', $atAL['realisasi_sebelum']);

                        $tAset = [
                            'realisasi'         => $tAL['realisasi'] + $tAT['realisasi'] + $atAL['realisasi'],
                            'realisasi_sebelum' => $tAL['realisasi_sebelum'] + $tAT['realisasi_sebelum'] + $atAL['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D25', $tAset['realisasi']);
                        $sheet->setCellValue('E25', $tAset['realisasi_sebelum']);

                        $kBMHD = Helper::getPerhitungan($data['tha'], 3, '131');
                        $sheet->setCellValue('D29', $kBMHD['realisasi']);
                        $sheet->setCellValue('E29', $kBMHD['realisasi_sebelum']);
                        $kPDD = Helper::getPerhitungan($data['tha'], 3, '132');
                        $sheet->setCellValue('D30', $kPDD['realisasi']);
                        $sheet->setCellValue('E30', $kPDD['realisasi_sebelum']);

                        $tUU = [
                            'realisasi'         => $kBMHD['realisasi'] + $kPDD['realisasi'],
                            'realisasi_sebelum' => $kBMHD['realisasi_sebelum'] + $kPDD['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D31', $tUU['realisasi']);
                        $sheet->setCellValue('E31', $tUU['realisasi_sebelum']);

                        $sheet->setCellValue('D33', ($neraca['ekuitas_now']['ekuitas_awal'] ?? 0));
                        $sheet->setCellValue('E33', ($neraca['ekuitas_before']['ekuitas_awal'] ?? 0));

                        $sheet->setCellValue('D35', ($neraca['ekuitas_before']['surplus'] ?? 0));
                        $sheet->setCellValue('E35', 0);

                        $sheet->setCellValue('D36', ($neraca['ekuitas_now']['surplus'] ?? 0));
                        $sheet->setCellValue('E36', ($neraca['ekuitas_before']['surplus'] ?? 0));

                        $tSD = [
                            'realisasi'         => ($neraca['ekuitas_before']['surplus'] ?? 0) + ($neraca['ekuitas_now']['surplus'] ?? 0),
                            'realisasi_sebelum' => 0 + ($neraca['ekuitas_before']['surplus'] ?? 0),
                        ];

                        $sheet->setCellValue('D38', ($neraca['ekuitas_now']['ekuitas_awal'] ?? 0));
                        $sheet->setCellValue('E38', ($neraca['ekuitas_before']['ekuitas_awal'] ?? 0));

                        $tE = [
                            'realisasi'         => ($neraca['ekuitas_now']['ekuitas_awal'] ?? 0) + $tSD['realisasi'],
                            'realisasi_sebelum' => ($neraca['ekuitas_before']['ekuitas_awal'] ?? 0) + $tSD['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D40', $tE['realisasi']);
                        $sheet->setCellValue('E40', $tE['realisasi_sebelum']);
                        $sheet->setCellValue('D41', $tE['realisasi']);
                        $sheet->setCellValue('E41', $tE['realisasi_sebelum']);

                        $tLE = [
                            'realisasi'         => $tUU['realisasi'] + $tSD['realisasi'],
                            'realisasi_sebelum' => $tUU['realisasi_sebelum'] + $tSD['realisasi_sebelum'],
                        ];
                        $sheet->setCellValue('D43', $tLE['realisasi']);
                        $sheet->setCellValue('E43', $tLE['realisasi_sebelum']);
                    });
                })->download('xlsx');
            }
        } else {
            $sumPendapatan = [
                'anggaran'              => 0,
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $pendapatans = AkunCOA::where('akun_code_1', 4)
                ->where('akun_code_2', 0)
                ->where('akun_code_3', 0)
                ->where('akun_code_4', 0)
                ->where('akun_code_5', 0)
                ->where('akun_code_6', 0)
                ->where('akun_code_7', 0)
                ->where('akun_code_8', 0)
                ->where('akun_code_9', 0)
                ->get()->toArray();
            foreach ($pendapatans as $pendapatan) {
                $code = implode('', [$pendapatan['akun_code_1'], $pendapatan['akun_code_2']]);
                $getPerhitungan1   = Helper::getPerhitungan($data['tha'], 1, $code);

                $data['data'][$i]['code']               = $pendapatan['code'];
                $data['data'][$i]['nama']               = $pendapatan['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['anggaran']           = '';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['percent']            = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    $pendapatan_sub_1 = AkunCOA::where('akun_code_1', $pendapatan['akun_code_1'])
                        ->where('akun_code_2', $pendapatan['akun_code_2'])
                        ->where('akun_code_3', '!=', 0)
                        ->where('akun_code_4', 0)
                        ->where('akun_code_5', 0)
                        ->where('akun_code_6', 0)
                        ->where('akun_code_7', 0)
                        ->where('akun_code_8', 0)
                        ->where('akun_code_9', 0)
                        ->get()->toArray();
                    foreach ($pendapatan_sub_1 as $pendapatan_sub) {
                        $code = implode('', [$pendapatan_sub['akun_code_1'], $pendapatan_sub['akun_code_2'], $pendapatan_sub['akun_code_3']]);
                        $getPerhitungan2   = Helper::getPerhitungan($data['tha'], 2, $code);

                        $data['data'][$i]['code']               = $pendapatan_sub['code'];
                        $data['data'][$i]['nama']               = '&emsp;&emsp;' . $pendapatan_sub['nama'];
                        if ($post['level'] >= 3) {
                            $data['data'][$i]['tag']                = 'b0';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            $pendapatan_sub_2 = AkunCOA::where('akun_code_1', $pendapatan_sub['akun_code_1'])
                                ->where('akun_code_2', $pendapatan_sub['akun_code_2'])
                                ->where('akun_code_3', $pendapatan_sub['akun_code_3'])
                                ->where('akun_code_4', '!=', 0)
                                ->where('akun_code_5', 0)
                                ->where('akun_code_6', 0)
                                ->where('akun_code_7', 0)
                                ->where('akun_code_8', 0)
                                ->where('akun_code_9', 0)
                                ->get()->toArray();
                            foreach ($pendapatan_sub_2 as $class) {
                                $code = implode('', [$class['akun_code_1'], $class['akun_code_2'], $class['akun_code_3'], $class['akun_code_4'], $class['akun_code_5']]);
                                $getPerhitungan3   = Helper::getPerhitungan($data['tha'], 3, $code);

                                $data['data'][$i]['code']               = $class['code'];
                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                if ($post['level'] >= 4) {
                                    $data['data'][$i]['tag']                = 'b0';
                                    $data['data'][$i]['anggaran']           = '';
                                    $data['data'][$i]['realisasi']          = '';
                                    $data['data'][$i]['percent']            = '';
                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                    $i++;

                                    $pendapatan_sub_3 = AkunCOA::where('akun_code_1', $class['akun_code_1'])
                                        ->where('akun_code_2', $class['akun_code_2'])
                                        ->where('akun_code_3', $class['akun_code_3'])
                                        ->where('akun_code_4', $class['akun_code_4'])
                                        ->where('akun_code_5', $class['akun_code_5'])
                                        ->where('akun_code_6', '!=', 0)
                                        ->where('akun_code_7', 0)
                                        ->where('akun_code_8', 0)
                                        ->where('akun_code_9', 0)
                                        ->get()->toArray();
                                    foreach ($pendapatan_sub_3 as $sub_class) {
                                        $code = implode('', [$sub_class['akun_code_1'], $sub_class['akun_code_2'], $sub_class['akun_code_3'], $sub_class['akun_code_4'], $sub_class['akun_code_5'], $sub_class['akun_code_6'], $sub_class['akun_code_7']]);
                                        $getPerhitungan4   = Helper::getPerhitungan($data['tha'], 4, $code);

                                        if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                            $data['data'][$i]['code']               = $sub_class['code'];
                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                            if ($post['level'] >= 5) {
                                                $data['data'][$i]['tag']                = 'b0';
                                                $data['data'][$i]['anggaran']           = '';
                                                $data['data'][$i]['realisasi']          = '';
                                                $data['data'][$i]['percent']            = '';
                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                $i++;

                                                $pendapatan_sub_4 = AkunCOA::where('akun_code_1', $sub_class['akun_code_1'])
                                                    ->where('akun_code_2', $sub_class['akun_code_2'])
                                                    ->where('akun_code_3', $sub_class['akun_code_3'])
                                                    ->where('akun_code_4', $sub_class['akun_code_4'])
                                                    ->where('akun_code_5', $sub_class['akun_code_5'])
                                                    ->where('akun_code_6', $sub_class['akun_code_5'])
                                                    ->where('akun_code_7', $sub_class['akun_code_5'])
                                                    ->where('akun_code_8', $sub_class['akun_code_8'])
                                                    ->where('akun_code_9', '!=', 0)
                                                    ->get()->toArray();
                                                foreach ($pendapatan_sub_4 as $coa) {
                                                    $code = implode('', [$coa['akun_code_1'], $coa['akun_code_2'], $coa['akun_code_3'], $coa['akun_code_4'], $coa['akun_code_5'], $coa['akun_code_6'], $coa['akun_code_7'], $coa['akun_code_8'], $coa['akun_code_9']]);
                                                    $getPerhitungan5   = Helper::getPerhitungan($data['tha'], 5, $code);

                                                    if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                        $data['data'][$i]['code']               = $coa['code'];
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

                                                        if (end($pendapatan_sub_4) == $coa) {
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

                                            if (end($pendapatan_sub_3) == $sub_class) {
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
                                if (end($pendapatan_sub_2) == $class) {
                                    $data['data'][$i]['code']               = '';
                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $pendapatan_sub['nama'];
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

                        if (end($pendapatan_sub_1) == $pendapatan_sub) {
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = 'JUMLAH ' . $pendapatan['nama'];
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

            $sumBeban = [
                'anggaran'              => 0,
                'realisasi'             => 0,
                'realisasi_sebelum'     => 0
            ];
            $bebans = AkunCOA::where('akun_code_1', 5)
                ->where('akun_code_2', 0)
                ->where('akun_code_3', 0)
                ->where('akun_code_4', 0)
                ->where('akun_code_5', 0)
                ->where('akun_code_6', 0)
                ->where('akun_code_7', 0)
                ->where('akun_code_8', 0)
                ->where('akun_code_9', 0)
                ->get()->toArray();
            foreach ($bebans as $beban) {
                $code = implode('', [$beban['akun_code_1'], $beban['akun_code_2']]);
                $getPerhitungan1   = Helper::getPerhitungan($data['tha'], 1, $code);

                $data['data'][$i]['code']               = $beban['code'];
                $data['data'][$i]['nama']               = $beban['nama'];
                if ($post['level'] >= 2) {
                    $data['data'][$i]['tag']                = 'b0';
                    $data['data'][$i]['anggaran']           = '';
                    $data['data'][$i]['realisasi']          = '';
                    $data['data'][$i]['percent']            = '';
                    $data['data'][$i]['realisasi_sebelum']  = '';
                    $i++;

                    $beban_sub_1 = AkunCOA::where('akun_code_1', $beban['akun_code_1'])
                        ->where('akun_code_2', $beban['akun_code_2'])
                        ->where('akun_code_3', '!=', 0)
                        ->where('akun_code_4', 0)
                        ->where('akun_code_5', 0)
                        ->where('akun_code_6', 0)
                        ->where('akun_code_7', 0)
                        ->where('akun_code_8', 0)
                        ->where('akun_code_9', 0)
                        ->get()->toArray();
                    foreach ($beban_sub_1 as $beban_sub) {
                        $code = implode('', [$beban_sub['akun_code_1'], $beban_sub['akun_code_2'], $beban_sub['akun_code_3']]);
                        $getPerhitungan2   = Helper::getPerhitungan($data['tha'], 2, $code);

                        $data['data'][$i]['code']               = $beban_sub['code'];
                        $data['data'][$i]['nama']               = '&emsp;&emsp;' . $beban_sub['nama'];
                        if ($post['level'] >= 3) {
                            $data['data'][$i]['tag']                = 'b0';
                            $data['data'][$i]['anggaran']           = '';
                            $data['data'][$i]['realisasi']          = '';
                            $data['data'][$i]['percent']            = '';
                            $data['data'][$i]['realisasi_sebelum']  = '';
                            $i++;

                            $beban_sub_2 = AkunCOA::where('akun_code_1', $beban_sub['akun_code_1'])
                                ->where('akun_code_2', $beban_sub['akun_code_2'])
                                ->where('akun_code_3', $beban_sub['akun_code_3'])
                                ->where('akun_code_4', '!=', 0)
                                ->where('akun_code_5', 0)
                                ->where('akun_code_6', 0)
                                ->where('akun_code_7', 0)
                                ->where('akun_code_8', 0)
                                ->where('akun_code_9', 0)
                                ->get()->toArray();
                            foreach ($beban_sub_2 as $class) {
                                $code = implode('', [$class['akun_code_1'], $class['akun_code_2'], $class['akun_code_3'], $class['akun_code_4'], $class['akun_code_5']]);
                                $getPerhitungan3   = Helper::getPerhitungan($data['tha'], 3, $code);

                                $data['data'][$i]['code']               = $class['code'];
                                $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;' . $class['nama'];
                                if ($post['level'] >= 4) {
                                    $data['data'][$i]['tag']                = 'b0';
                                    $data['data'][$i]['anggaran']           = '';
                                    $data['data'][$i]['realisasi']          = '';
                                    $data['data'][$i]['percent']            = '';
                                    $data['data'][$i]['realisasi_sebelum']  = '';
                                    $i++;

                                    $beban_sub_3 = AkunCOA::where('akun_code_1', $class['akun_code_1'])
                                        ->where('akun_code_2', $class['akun_code_2'])
                                        ->where('akun_code_3', $class['akun_code_3'])
                                        ->where('akun_code_4', $class['akun_code_4'])
                                        ->where('akun_code_5', $class['akun_code_5'])
                                        ->where('akun_code_6', '!=', 0)
                                        ->where('akun_code_7', 0)
                                        ->where('akun_code_8', 0)
                                        ->where('akun_code_9', 0)
                                        ->get()->toArray();
                                    foreach ($beban_sub_3 as $sub_class) {
                                        $code = implode('', [$sub_class['akun_code_1'], $sub_class['akun_code_2'], $sub_class['akun_code_3'], $sub_class['akun_code_4'], $sub_class['akun_code_5'], $sub_class['akun_code_6'], $sub_class['akun_code_7']]);
                                        $getPerhitungan4   = Helper::getPerhitungan($data['tha'], 4, $code);

                                        if ($getPerhitungan4['anggaran'] != 0 || $getPerhitungan4['realisasi'] != 0 || $getPerhitungan4['realisasi_sebelum'] != 0) {
                                            $data['data'][$i]['code']               = $sub_class['code'];
                                            $data['data'][$i]['nama']               = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $sub_class['nama'];
                                            if ($post['level'] >= 5) {
                                                $data['data'][$i]['tag']                = 'b0';
                                                $data['data'][$i]['anggaran']           = '';
                                                $data['data'][$i]['realisasi']          = '';
                                                $data['data'][$i]['percent']            = '';
                                                $data['data'][$i]['realisasi_sebelum']  = '';
                                                $i++;

                                                $beban_sub_4 = AkunCOA::where('akun_code_1', $sub_class['akun_code_1'])
                                                    ->where('akun_code_2', $sub_class['akun_code_2'])
                                                    ->where('akun_code_3', $sub_class['akun_code_3'])
                                                    ->where('akun_code_4', $sub_class['akun_code_4'])
                                                    ->where('akun_code_5', $sub_class['akun_code_5'])
                                                    ->where('akun_code_6', $sub_class['akun_code_5'])
                                                    ->where('akun_code_7', $sub_class['akun_code_5'])
                                                    ->where('akun_code_8', $sub_class['akun_code_8'])
                                                    ->where('akun_code_9', '!=', 0)
                                                    ->get()->toArray();
                                                foreach ($beban_sub_4 as $coa) {
                                                    $code = implode('', [$coa['akun_code_1'], $coa['akun_code_2'], $coa['akun_code_3'], $coa['akun_code_4'], $coa['akun_code_5'], $coa['akun_code_6'], $coa['akun_code_7'], $coa['akun_code_8'], $coa['akun_code_9']]);
                                                    $getPerhitungan5   = Helper::getPerhitungan($data['tha'], 5, $code);

                                                    if ($getPerhitungan5['anggaran'] != 0 || $getPerhitungan5['realisasi'] != 0 || $getPerhitungan5['realisasi_sebelum'] != 0) {
                                                        $data['data'][$i]['code']               = $coa['code'];
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

                                                        if (end($beban_sub_4) == $coa) {
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

                                            if (end($beban_sub_3) == $sub_class) {
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
                                if (end($beban_sub_2) == $class) {
                                    $data['data'][$i]['code']               = '';
                                    $data['data'][$i]['nama']               = 'JUMLAH ' . $beban_sub['nama'];
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

                        if (end($beban_sub_1) == $beban_sub) {
                            $data['data'][$i]['code']               = '';
                            $data['data'][$i]['nama']               = 'JUMLAH ' . $beban['nama'];
                            $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                            $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                            $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                            $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                            $i++;

                            $sumBeban['anggaran']          = $sumBeban['anggaran'] + $getPerhitungan1['anggaran'];
                            $sumBeban['realisasi']         = $sumBeban['realisasi'] + $getPerhitungan1['realisasi'];
                            $sumBeban['realisasi_sebelum'] = $sumBeban['realisasi_sebelum'] + $getPerhitungan1['realisasi_sebelum'];
                        }
                    }
                } else {
                    $data['data'][$i]['anggaran']           = $getPerhitungan1['anggaran'];
                    $data['data'][$i]['realisasi']          = $getPerhitungan1['realisasi'];
                    $data['data'][$i]['percent']            = ($getPerhitungan1['anggaran'] == 0) ? 0 : ($getPerhitungan1['realisasi'] / $getPerhitungan1['anggaran']) * 100;
                    $data['data'][$i]['realisasi_sebelum']  = $getPerhitungan1['realisasi_sebelum'];
                    $i++;

                    $sumBeban['anggaran']          = $getPerhitungan1['anggaran'];
                    $sumBeban['realisasi']         = $getPerhitungan1['realisasi'];
                    $sumBeban['realisasi_sebelum'] = $getPerhitungan1['realisasi_sebelum'];
                }
            }

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
            $data['data'][$i]['nama']               = 'LABA / RUGI';
            $data['data'][$i]['realisasi']          = $sumPendapatan['realisasi'] - $sumBeban['realisasi'];
            $data['data'][$i]['realisasi_sebelum']  = $sumPendapatan['realisasi_sebelum'] - $sumBeban['realisasi_sebelum'];
            $i++;

            $data['data'][$i]['tag']                = '0';
            $data['data'][$i]['code']               = '';
            $data['data'][$i]['nama']               = '';
            $data['data'][$i]['anggaran']           = '';
            $data['data'][$i]['realisasi']          = '';
            $data['data'][$i]['percent']            = '';
            $data['data'][$i]['realisasi_sebelum']  = '';
            $i++;

            return view('accounting::laporan.laba_rugi.index', $data);
        }
    }
}
