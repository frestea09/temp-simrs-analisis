<?php

namespace App\Http\Controllers;

use App\Aturanetiket;
use App\Emr;
use App\KuotaDokter;
use App\EmrResume;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganIGD;
use App\Historipengunjung;
use App\Inacbg;
use App\KondisiAkhirPasien;
use Illuminate\Support\Facades\Cache;
use App\PerawatanIcd9;
use App\PerawatanIcd10;
use App\JknIcd10;
use App\JknIcd9;
use App\Posisiberkas;
use App\EmrInapPerencanaan;
use App\Rawatinap;
use Modules\Jenisjkn\Entities\Jenisjkn;
use App\ResumePasien;
use App\Orderlab;
use App\Orderradiologi;
use App\HfisDokter;
use App\LicaResult;
use App\HistoriRawatInap;
use App\Kelompokkelas;
use App\MetodeBayar;
use App\Pembayaran;
use App\EmrGizi;
use App\Penjualan;
use App\Penjualandetail;
use App\ReturObatRusak;
use Carbon\Carbon;
use App\EmrInapPemeriksaan;
use App\Hasillab;
use App\KondisiAkhirPasienSS;
use App\LogUser;
use App\MasterEtiket;
use App\Prognosis;
use App\RadiologiEkspertise;
use App\ResepNote;
use App\ResepNoteDetail;
use App\Satusehat;
use App\TakaranobatEtiket;
use App\RencanaKontrol;
use App\echocardiogram;
use App\HasilPemeriksaan;
use App\HistorikunjunganRAD;
use App\Icd10Im;
use App\Icd10Inacbg;
use App\Icd9Im;
use App\InacbgLog;
use App\TandaTangan;
use App\LogFolio;
use Illuminate\Http\Request;
use Modules\Icd9\Entities\Icd9;
use Modules\Icd10\Entities\Icd10;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Carabayar;
use Yajra\DataTables\DataTables;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Pasien\Entities\HistoryKanza;
use Modules\Kamar\Entities\Kamar;
use Modules\Pekerjaan\Entities\Pekerjaan;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;


use Auth;
use DateTime;
use DB;
use Excel;
use Flashy;
use PDF;
use Validator;

class FrontofficeController extends Controller
{
    public function getDokter($id)
    {
        $ri = \Modules\Pegawai\Entities\Pegawai::where('id', $id)->first();
        return response()->json(['nama' => $ri->nama]);
    }

    public function lapResumePasien()
    {
        $data['tga']        = '';
        $data['tgb']        = '';
        $data['p_icd9']        = [];
        return view('frontoffice.lapResumePasien', $data)->with('no', 1);
    }

    public function filterLapResumePasien(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;

        $data['p_icd9']        = PerawatanIcd9::leftJoin('registrasis', 'registrasis.id', '=', 'perawatan_icd9s.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'perawatan_icd9s.registrasi_id')
            ->whereNotNull('perawatan_icd9s.icd9')
            ->where('perawatan_icd9s.jenis', 'TA')
            ->whereBetween('perawatan_icd9s.created_at', [$tga, $tgb])
            ->select(
                DB::raw('GROUP_CONCAT(perawatan_icd10s.icd10 SEPARATOR "||") as icd10'),
                DB::raw('GROUP_CONCAT(pasiens.tgllahir SEPARATOR "||") as lahir'),
                DB::raw('GROUP_CONCAT(pasiens.kelamin SEPARATOR "||") as gender'),
                DB::raw('GROUP_CONCAT(registrasis.status SEPARATOR "||") as status'),
                'perawatan_icd9s.icd9 as icd9'
            )
            ->groupBy('icd9')->orderBy('icd9', 'asc')->get();
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.lapResumePasien', $data)->with('no', 1);
        } elseif ($req->submit == 'CETAK') {
            $no = 1;
            $pdf = PDF::loadView('frontoffice.cetakLapResumePasien', $data, compact('no'));
            $pdf->setPaper('A4', 'landscape');
            // return $pdf->download('rekapLaporanIrna.pdf');
            return view('frontoffice.cetakLapResumePasien', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $p_icd9 = $data['p_icd9'];
            Excel::create('Morbiditas & Mortalitas Rajal', function ($excel) use ($p_icd9) {
                // Set the properties
                $excel->setTitle('Morbiditas & Mortalitas Rajal')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Morbiditas & Mortalitas Rajal');
                $excel->sheet('Morbiditas & Mortalitas Rajal', function ($sheet) use ($p_icd9) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'ICD9',
                        'ICD10',
                        'Nama',
                        '6hr L',
                        '6hr P',
                        '6-28hr L',
                        '6-28hr P',
                        '28hr-1th L',
                        '28hr-1th P',
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
                        '>64th L',
                        '>64th P',
                        'L',
                        'P',
                        'KB',
                        'KJ'
                    ]);
                    foreach ($p_icd9 as $i) {
                        $kelamin    = explode('||', $i->gender);
                        $gender     = array_count_values($kelamin);
                        $range      = getRange($i->lahir, $i->gender);
                        $status     = array_count_values(explode('||', $i->status));
                        $_loop = [
                            $no++,
                            $i->icd9,
                            '',
                            getICD9($i->icd9),
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
                            (isset($status['baru'])) ? $status['baru'] : 0,
                            count($kelamin)
                        ];

                        foreach (array_count_values(explode('||', $i->icd10)) as $k => $v) {
                            $_loop[2] .= $k . ',';
                        }
                        $sheet->row(++$row, $_loop);
                    }
                });
            })->export('xlsx');
        }
    }

    public function cetak()
    {
        $today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')
            ->orderBy('id', 'Desc')->get();
        return view('frontoffice.cetak', compact('today'))->with('no', 1);
    }

    public function cetakIRJ()
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '8000M');

        // $keyCache = 'cetakIRJ';
        // $today = Cache::get($keyCache);
        // if(!$today){
        $polis = Poli::where('politype', 'J')->get();
        $today = Registrasi::with(['pasien', 'poli', 'bayars'])
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4'])
            ->orderBy('id', 'Desc')
            ->select([
                'id',
                'pasien_id',
                'poli_id',
                'bayar',
                'no_sep',
                'tte_general_consent',
                'id_encounter_ss'
            ])
            ->get();
        // Cache::put($keyCache,$today,120); //BUAT CACHE 2 menit
        // }

        return view('frontoffice.cetak-irj', compact('today', 'polis'))->with('no', 1);
    }
    public function cetakIGD()
    {
        $today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')
            ->whereIn('status_reg', ['G1', 'G2', 'G3', 'G4', 'I1', 'I2', 'I3'])
            ->with('pasien')
            ->orderBy('id', 'Desc')
            ->select('pasien_id', 'bayar', 'no_sep', 'created_at', 'id_encounter_ss', 'tte_general_consent', 'poli_id', 'id')
            ->get();

        return view('frontoffice.cetak-igd', compact('today'))->with('no', 1);
    }
    public function cetakIRNA()
    {
        $today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')
            ->whereIn('status_reg', ['I1', 'I2', 'I3', 'I4'])
            ->orderBy('id', 'Desc')->get();
        return view('frontoffice.cetak-irna', compact('today'))->with('no', 1);
    }
    public function cetak_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $today = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->orderBy('id', 'Desc')->get();
        return view('frontoffice.cetak-igd', compact('today'))->with('no', 1);
    }

    public function cetak_byTanggalIGD(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $today = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereIn('status_reg', ['G1', 'G2', 'G3', 'G4', 'I1', 'I2'])
            ->with('pasien')
            ->orderBy('id', 'Desc')
            ->select('pasien_id', 'bayar', 'no_sep', 'created_at', 'id_encounter_ss', 'poli_id', 'id')
            ->get();
        return view('frontoffice.cetak-igd', compact('today'))->with('no', 1);
    }
    public function cetak_byTanggalIRJ(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '-1');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $poli_id = $request->input('poli_id');
        $today = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4'])
            ->when($poli_id, function ($q) use ($poli_id) {
                $q->where('poli_id', $poli_id);
            })
            ->orderBy('id', 'Desc')->get();
        $polis = Poli::where('politype', 'J')->get();
        return view('frontoffice.cetak-irj', compact('today', 'polis'))->with('no', 1);
    }
    public function cetak_byTanggalIRNA(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $today = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereIn('status_reg', ['I1', 'I2', 'I3', 'I4'])
            ->orderBy('id', 'Desc')->get();
        return view('frontoffice.cetak-irna', compact('today'))->with('no', 1);
    }

    public function cetakPerjanjian()
    {
        $today = Registrasi::where('created_at', '>', date('Y-m-d') . ' 23:59:59')->orderBy('id', 'Desc')->get();
        return view('frontoffice.cetak', compact('today'))->with('no', 1);
    }

    public function ajax_cetak()
    {
        $today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')->orderBy('id', 'Desc')->get();
        return view('frontoffice.ajax_cetak', compact('today'))->with('no', 1);
    }

    public function dataCetakBarcode()
    {
        $data['reg'] = Registrasi::where('status_reg', 'like', 'J%')
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->where('cetak_barcode', '0')
            ->orderBy('id', 'asc')->first();
        return view('frontoffice.dataCetakBarcode', $data);
    }

    public function cetak_barcode($id, $reg_id)
    {
        $data['pasien'] = Pasien::find($id);
        $data['registrasi'] = Registrasi::find($reg_id);
        $data['ruangan'] = Rawatinap::where('registrasi_id', '=', $reg_id)->first();
        return view('frontoffice.cetak_barcode', $data);
    }

    public function cetak_barcoderi($id, $reg_id)
    {
        $data['pasien'] = Pasien::find($id);
        $data['registrasi'] = Registrasi::find($reg_id);
        $data['ruangan'] = Rawatinap::where('registrasi_id', '=', $reg_id)->orderBy('id', 'DESC')->first();
        $data['histori'] = HistoriRawatInap::where('registrasi_id', '=', $reg_id)->orderBy('id', 'ASC')->first();
        return view('frontoffice.cetak_barcoderi', $data);
    }

    public function cetak_barcodeigd($id, $reg_id)
    {
        $data['pasien'] = Pasien::find($id);
        $data['registrasi'] = Registrasi::find($reg_id);
        $data['ruangan'] = Rawatinap::where('registrasi_id', '=', $reg_id)->first();
        $data['tgl'] = HistorikunjunganIGD::where('registrasi_id', '=', $reg_id)->first();
        return view('frontoffice.cetak_barcodeigd', $data);
    }
    public function cetak_barcode2($id, $reg_id)
    {
        $data['pasien'] = Pasien::find($id);
        $data['reg_id'] = Registrasi::find($reg_id);
        $data['tgl'] = HistorikunjunganIGD::where('registrasi_id', '=', $reg_id)->first();
        return view('frontoffice.cetak_barcode2', $data);
    }
    public function cetak_barcodeigd2($id, $reg_id)
    {
        $data['pasien'] = Pasien::find($id);
        $data['reg_id'] = Registrasi::find($reg_id);
        return view('frontoffice.cetak_barcodeigd2', $data);
    }

    public function cetak_gelang($id)
    {
        // dd("test");
        $data['pasien'] = Pasien::find($id);
        $pdf            = PDF::loadView('frontoffice.cetak_gelang', $data);
        return $pdf->stream();
    }

    public function cetak_buktiregistrasi($id)
    {
        $reg = Registrasi::find($id);
        $pasien = Pasien::find($reg->pasien_id);
        return view('frontoffice.buktiregistrasi', compact('reg', 'pasien'));
    }

    public function cetakKIUP($registrasi_id = '')
    {
        //dd('test');
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $pdf = PDF::loadView('frontoffice.cetakKIUP', $data);
        return $pdf->stream();
    }

    public function cetakPersetujuan($registrasi_id = '')
    {
        //dd('persetujuan');
        $data['reg']    = Registrasi::find($registrasi_id);
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        //dd($data['pasien']);
        $pdf = PDF::loadView('frontoffice.cetak_persetujuan', $data);
        return $pdf->stream();
    }

    public function cetakRm01($registrasi_id = '')
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $pdf = PDF::loadView('frontoffice.cetakRm01', $data);
        return $pdf->stream();
    }

    public function rekapPengunjung()
    {
        $data['darurat'] = [
            'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'P')->count(),
            'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'L')->count(),
            'total' => Registrasi::where('status_reg', 'like', '%G%')->count(),
        ];
        $data['inap'] = [
            'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'P')->count(),
            'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'L')->count(),
            'total' => Registrasi::where('status_reg', 'like', '%I%')->count(),
        ];
        $data['jalan'] = [
            'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'P')->count(),
            'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'L')->count(),
            'total' => Registrasi::where('status_reg', 'like', '%J%')->count(),
        ];
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['poli_id'] = '';
        $data['cara_bayar'] = '';
        return view('frontoffice.rekapPengunjung', $data)->with('no', 1);
    }


    public function dataRekap(Request $req)
    {
        request()->validate(['tgla' => 'required', 'tglb' => 'required']);
        if ($req->cara_bayar_id == '') {
            if ($req->poli_id == '') {
                $data['darurat'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'P')->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'L')->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%G%')->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['inap'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'P')->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'L')->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%I%')->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['jalan'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'P')->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'L')->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%J%')->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
            } else {
                $data['darurat'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'P')->where('registrasis.poli_id', $req->poli_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'L')->where('registrasis.poli_id', $req->poli_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%G%')->where('poli_id', $req->poli_id)->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['inap'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'P')->where('registrasis.poli_id', $req->poli_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'L')->where('registrasis.poli_id', $req->poli_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%I%')->where('poli_id', $req->poli_id)->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['jalan'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'P')->where('registrasis.poli_id', $req->poli_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'L')->where('registrasis.poli_id', $req->poli_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%J%')->where('poli_id', $req->poli_id)->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
            }
        } else {
            if ($req->poli_id == '') {
                $data['darurat'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'P')->where('registrasis.bayar', $req->cara_bayar_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'L')->where('registrasis.bayar', $req->cara_bayar_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%G%')->where('bayar', $req->cara_bayar_id)->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['inap'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'P')->where('registrasis.bayar', $req->cara_bayar_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'L')->where('registrasis.bayar', $req->cara_bayar_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%I%')->where('bayar', $req->cara_bayar_id)->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['jalan'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'P')->where('registrasis.bayar', $req->cara_bayar_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'L')->where('registrasis.bayar', $req->cara_bayar_id)->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%J%')->where('bayar', $req->cara_bayar_id)->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
            } else {
                $data['darurat'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'P')->where(['registrasis.poli_id' => $req->poli_id, 'registrasis.bayar' => $req->cara_bayar_id])->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%G%')->where('pasiens.kelamin', 'L')->where(['registrasis.poli_id' => $req->poli_id, 'registrasis.bayar' => $req->cara_bayar_id])->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%G%')->where(['poli_id' => $req->poli_id, 'bayar' => $req->cara_bayar_id])->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['inap'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'P')->where(['registrasis.poli_id' => $req->poli_id, 'registrasis.bayar' => $req->cara_bayar_id])->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%I%')->where('pasiens.kelamin', 'L')->where(['registrasis.poli_id' => $req->poli_id, 'registrasis.bayar' => $req->cara_bayar_id])->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%I%')->where(['poli_id' => $req->poli_id, 'bayar' => $req->cara_bayar_id])->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
                $data['jalan'] = [
                    'P' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'P')->where(['registrasis.poli_id' => $req->poli_id, 'registrasis.bayar' => $req->cara_bayar_id])->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'L' => Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.status_reg', 'like', '%J%')->where('pasiens.kelamin', 'L')->where(['registrasis.poli_id' => $req->poli_id, 'registrasis.bayar' => $req->cara_bayar_id])->whereBetween('registrasis.created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                    'total' => Registrasi::where('status_reg', 'like', '%J%')->where(['poli_id' => $req->poli_id, 'bayar' => $req->cara_bayar_id])->whereBetween('created_at', [valid_date($req->tgla), valid_date($req->tglb)])->count(),
                ];
            }
        }
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['poli_id'] = $req->poli_id;
        $data['cara_bayar'] = $req->cara_bayar_id;
        return view('frontoffice.rekapPengunjung', $data)->with('no', 1);
    }

    public function ResponTime(Request $request)
    {

        //dd("Respon");

        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['poli_id'] = '';
        $data['cara_bayar'] = '';
        return view('frontoffice.responsetime', $data);
    }
    public function LogUser(Request $request)
    {
        if ($request->tgla && $request->tglb) {
            $data['tglAwal']      = valid_date($request['tgla']);
            $data['tglAkhir']     = valid_date($request['tglb']);
            $data['user']         = @$request->user;

            // dd($tglAwal,$tglAkhir);
            $data['log'] = LogUser::groupBy('user_id')->groupBy('tanggal')->select('user_id', 'tanggal')->whereBetween('tanggal', [$data['tglAwal'], $data['tglAkhir']]);
            if ($data['user']) {
                if ($data['user'] == 'dokter') {
                    $data['log'] = $data['log']->where('nama', 'like', 'dr%');
                } else {
                    $data['log'] = $data['log']->where('nama', 'not like', 'dr%');
                }
            }
            $data['log'] = $data['log']->orderBy('id', 'DESC')->get();
        } else {
            $data['log'] = LogUser::where('tanggal', date('Y-m-d'))->groupBy('user_id')->groupBy('tanggal')->select('user_id', 'tanggal')->orderBy('id', 'DESC')->get();
        }

        if ($request->excel) {
            Excel::create('Log User ' . $data['tglAwal'] . '/' . $data['tglAkhir'], function ($excel) use ($data) {
                $excel->setTitle('Log User')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Log User');
                $excel->sheet('Log User', function ($sheet) use ($data) {
                    $sheet->loadView('frontoffice.excel.log_user_excel', $data);
                });
            })->export('xlsx');
        } else {
            return view('frontoffice.log_user', $data);
        }
    }


    public function getRespon($periode, $poli)
    {
        //dd($periode,$poli);
        //$data['bcgudang'] = LogistikGudang::where('id',$gudang)->first();
        $respon            = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('registrasis.poli_id', $poli)->where('registrasis.status_reg', 'like', '%J%')->where('registrasis.created_at', 'like', date('Y-m') . '%')->get();
        return view('frontoffice.responsetime', compact('respon'))->with('no', 1);
    }

    //Laporan Responses Time Pasien
    public function exportresponses(Request $request)
    {

        request()->validate([
            'tgla' => 'required',
            'tglb' => 'required',
        ]);

        $tglAwal      = valid_date($request['tgla']) . ' 00:00:00';
        $tglAkhir     = valid_date($request['tglb']) . ' 23:59:59';
        $poli         = $request['poli_id'];

        $data['tgl1'] = $request['tgla'];
        $data['tgl2'] = $request['tglb'];
        $data['poli'] = Poli::select('nama', 'id')->get();

        // $data['opnames'] = LogistikOpname::join('logistik_stocks', 'logistik_opnames.id', '=', 'logistik_stocks.opname_id')
        //                 ->join('masterobats','logistik_stocks.masterobat_id', '=', 'masterobats.id')
        //                 ->join('logistik_batches','logistik_opnames.logistik_batch_id', '=', 'logistik_batches.id')
        //                 ->whereBetween('logistik_opnames.created_at', [$tglAwal, $tglAkhir])
        //                 ->groupBy('logistik_stocks.masterobat_id')
        //                 ->select('masterobats.nama','masterobats.satuanjual_id','logistik_stocks.masuk','logistik_stocks.keluar','logistik_opnames.stok_tercatat as awal',
        //                 'logistik_opnames.tanggalopname','logistik_batches.hargajual_umum',DB::raw('sum(logistik_batches.hargajual_umum) as jumlah_harga'),
        //                 'logistik_stocks.expired_date','logistik_stocks.keterangan','logistik_opnames.stok_sebenarnya as sisa');

        // 			    if(isset($apotikjalan)){
        //                     $data['opnames']   = $data['opnames']->where('logistik_stocks.gudang_id', $apotikjalan);
        //                 }
        //                 if(isset($apotikinap)){
        //                     $data['opnames']   = $data['opnames']->where('logistik_stocks.gudang_id', $apotikinap);
        //                 }
        //                 if(isset($apotikigd)){
        //                     $data['opnames']   = $data['opnames']->where('logistik_stocks.gudang_id', $apotikigd);
        //                 }
        //               $data['opnames'] = $data['opnames']->get();

        $data['respon'] = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->with(['eResep', 'aswal', 'cppt'])
            ->where('registrasis.status_reg', 'like', '%J%')
            ->join('antrians', 'registrasis.antrian_id', '=', 'antrians.id')
            ->join('antrian_poli', 'registrasis.antrian_poli_id', '=', 'antrian_poli.id')
            ->whereBetween('registrasis.created_at', [$tglAwal, $tglAkhir])
            ->orderBy('registrasis.id', 'desc')
            ->select(
                'registrasis.id',
                'registrasis.poli_id',
                'pasiens.no_rm',
                'pasiens.nama',
                'antrians.created_at as waktuPendaftaran',
                'antrians.updated_at as waktuAkhirPelayanan',
                'antrian_poli.created_at as mulai_poli',
                'antrian_poli.updated_at as selesai_poli',
            );

        if (isset($poli)) {
            $data['respon']   = $data['respon']->where('registrasis.poli_id', $poli);
        }

        $data['respon'] = $data['respon']->get();

        //dd($data['respon']);

        if ($request['tampil']) {
            return view('frontoffice.responsetime', $data);
        } elseif ($request['pdf']) {
            //dd('cetak pdf');
            $pdf = PDF::loadView('logistik.logistikmedik.laporan.pdf_lap_opname', $data);
            $pdf->setPaper('A4', 'potret');
            return $pdf->stream();
        } elseif ($request['excel']) {
            //dd('cetak excel');
            Excel::create('Lap Responses Time Pelayanan', function ($excel) use ($data) {
                // Set the properties
                $excel->setTitle('Lap Responses Time Pelayanan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Lap Responses Time Pelayanan');
                $excel->sheet('Lap Responses Time Pelayanan', function ($sheet) use ($data) {
                    $row = 1;
                    $no  = 1;
                    $sheet->row($row, [
                        'No',
                        'No.RM',
                        'Pasien',
                        'Poli',
                        'Waktu Pendaftaran',
                        'Waktu Akhir Pelayanan',
                        'Lama Tunggu Pendaftaran',
                        // 'Daftar Antrian Poli',
                        // 'Akhir Pelayanan Poli',
                        'Lama Tunggu Pemeriksaan',
                        'Lama Pelayanan Pelayanan',
                        'Total Lama Pelayanan',
                    ]);
                    foreach ($data['respon'] as $key => $d) {

                        date_default_timezone_set('Asia/Jakarta');
                        //Lama tunggu di loket depan
                        $waktuPendaftaran       = date_create($d->waktuPendaftaran);
                        $waktuAkhirPelayanan     = date_create($d->waktuAkhirPelayanan);

                        // lama tunggu pelayanan2
                        $pelayananA = date_create($d->mulai_poli);
                        $pelayananB = date_create($d->selesai_poli);
                        $diffa      = date_diff($pelayananA, $pelayananB);

                        $waktuResep = count($d->eResep) > 0 ? $d->eResep->first()->created_at : null;
                        $waktuAsesmen = count($d->aswal) > 0 ? $d->aswal->first()->created_at : null;
                        $waktuCPPT = count($d->cppt) > 0 ? $d->cppt->first()->created_at : null;

                        $lamaTungguPendaftaran = date_diff($waktuPendaftaran, $waktuAkhirPelayanan);
                        $lamaTungguPemeriksaan = date_diff($waktuPendaftaran, $pelayananB);

                        if ($waktuResep) {
                            $waktuResep = date_create($waktuResep);
                            $lamaTungguPemeriksaan = date_diff($pelayananB, $waktuResep);
                            $totalLamaPelayanan = date_diff($waktuAkhirPelayanan, $waktuResep);
                        } elseif ($waktuCPPT) {
                            $waktuCPPT = date_create($waktuCPPT);
                            $lamaTungguPemeriksaan = date_diff($pelayananB, $waktuCPPT);
                            $totalLamaPelayanan = date_diff($waktuAkhirPelayanan, $waktuCPPT);
                        } elseif ($waktuAsesmen) {
                            $waktuAsesmen = date_create($waktuAsesmen);
                            $lamaTungguPemeriksaan = date_diff($pelayananB, $waktuAsesmen);
                            $totalLamaPelayanan = date_diff($waktuAkhirPelayanan, $waktuAsesmen);
                        }

                        $lamaWaktuPelayananMenit = $lamaTungguPendaftaran->i + $lamaTungguPemeriksaan->i;
                        $lamaWaktuPelayananDetik = $lamaTungguPendaftaran->s + $lamaTungguPemeriksaan->s;

                        $sheet->row(++$row, [
                            $no++,
                            @$d->no_rm,
                            @$d->nama,
                            @baca_poli($d->poli_id),
                            @date('d-m-Y H:i:s', strtotime($d->waktuPendaftaran)),
                            @date('d-m-Y H:i:s', strtotime($d->waktuAkhirPelayanan)),
                            @$lamaTungguPendaftaran->i . ' Menit ' . $lamaTungguPendaftaran->s . ' Detik',
                            // @date('d-m-Y H:i:s', strtotime($d->mulai_poli)),
                            // @date('d-m-Y H:i:s', strtotime($d->selesai_poli)),
                            @$lamaTungguPemeriksaan->i . ' Menit ' . $lamaTungguPemeriksaan->s . ' Detik',
                            @$lamaWaktuPelayananMenit . ' Menit ' . $lamaWaktuPelayananDetik . ' Detik',
                            @$totalLamaPelayanan->h . ' Jam ' . $totalLamaPelayanan->i . ' Menit ' . $totalLamaPelayanan->s . ' Detik',
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function lap_pengunjung()
    {
        $data['reg'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
            ->select('histori_pengunjung.*', 'registrasis.bayar')
            ->get();
        $data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::pluck('carabayar', 'id');
        return view('frontoffice.lap_pengunjung', $data)->with('no', 1);
    }

    public function lap_pengunjung_bytanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['reg'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->whereBetween('histori_pengunjung.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', $request['cara_bayar_id'])
            ->select('histori_pengunjung.*', 'registrasis.bayar')
            ->get();
        $data['cara_bayar'] = \Modules\Registrasi\Entities\Carabayar::pluck('carabayar', 'id');
        return view('frontoffice.lap_pengunjung', $data)->with('no', 1);
    }

    public function lap_kunjungan()
    {
        $cekpoli = Auth::user()->poli_id;
        // return $cekpoli;
        $data['reg'] = [];
        // if (!empty($cekpoli)) {
        //     $data['reg'] = HistorikunjunganIRJ::with('resep.resep_detail.logistik_batch')->join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
        //         ->join('perawatan_icd10s', 'histori_kunjungan_irj.registrasi_id', '=', 'perawatan_icd10s.registrasi_id')
        //         ->join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
        //         ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //         ->join('provinces', 'provinces.id', '=', 'pasiens.province_id')
        //         ->join('regencies', 'regencies.id', '=', 'pasiens.regency_id')
        //         ->join('districts', 'districts.id', '=', 'pasiens.district_id')
        //         ->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d') . '%')
        //         ->groupBy('histori_kunjungan_irj.registrasi_id')
        //         ->where('histori_kunjungan_irj.poli_id', $cekpoli)
        //         ->select('registrasis.keterangan as keterangan', 'registrasis.no_sep as sep', 'registrasis.jkn as jkn', 'registrasis.bayar as bayar', 'registrasis.kondisi_akhir_pasien as kondisi_akhir', 'icd10s.nama as namaicd10', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.alamat', 'pasiens.kelamin', 'pasiens.tgllahir', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status', 'registrasis.tipe_jkn', 'pasiens.nohp', 'pasiens.ibu_kandung', 'provinces.name as nama_provinsi', 'regencies.name as nama_kabupaten', 'districts.name as kecamatan') //PAKE AS PROVINCES
        //         ->get();
        // } else {
        //     $data['reg'] = HistorikunjunganIRJ::with('resep.resep_detail.logistik_batch')->join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
        //         ->join('perawatan_icd10s', 'histori_kunjungan_irj.registrasi_id', '=', 'perawatan_icd10s.registrasi_id')
        //         ->join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
        //         ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //         ->join('provinces', 'provinces.id', '=', 'pasiens.province_id')
        //         ->join('regencies', 'regencies.id', '=', 'pasiens.regency_id')
        //         ->join('districts', 'districts.id', '=', 'pasiens.district_id')
        //         ->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d') . '%')
        //         ->groupBy('histori_kunjungan_irj.registrasi_id')
        //         ->select('registrasis.keterangan as keterangan', 'registrasis.no_sep as sep', 'registrasis.jkn as jkn', 'registrasis.bayar as bayar', 'registrasis.kondisi_akhir_pasien as kondisi_akhir', 'icd10s.nama as namaicd10', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.alamat', 'pasiens.tgllahir', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status', 'registrasis.tipe_jkn', 'pasiens.nohp', 'pasiens.ibu_kandung', 'provinces.name as nama_provinsi', 'regencies.name as nama_kabupaten', 'districts.name as kecamatan') //PAKE AS PROVINCES
        //         ->get();
        // }
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['caraPulang']         = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
        $data['pekerjaan']          = Pekerjaan::all();
        $data['tga'] = NULL;
        $data['tgb'] = NULL;
        // return $data; die;
        return view('frontoffice.lap_kunjungan', $data)->with('no', 1);
    }

    public function lap_antrian()
    {
        $cekpoli = Auth::user()->poli_id;
        // return $cekpoli;
        if (!empty($cekpoli)) {
            $data['reg'] = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->where('registrasis.poli_id', $cekpoli)
                ->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
                ->get();
        } else {
            $data['reg'] = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
                ->get();
        }

        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        // return $data; die;
        return view('frontoffice.lap_antrian', $data)->with('no', 1);
    }

    public function lap_antrianBy(Request $request)
    {
        $cekpoli = Auth::user()->poli_id;

        $poli = Poli::select('id')->get();
        $pi = [];
        foreach ($poli as $key => $d) {
            $pi[] = '' . $d->id . '';
        }

        $dokter = Pegawai::select('id')->get();
        $di = [];
        foreach ($dokter as $key => $d) {
            $di[] = '' . $d->id . '';
        }
        // return $cekpoli;
        if (!empty($cekpoli)) {
            $data['reg'] = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->where('registrasis.poli_id', $cekpoli)
                ->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                ->get();
        } else {
            $data['reg'] = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                ->get();
        }
        $data['cara_bayar'] = Carabayar::all();
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        // return $data; die;
        return view('frontoffice.lap_antrian', $data)->with('no', 1);
    }
    public function lap_kunjungan_bytanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $poli = Poli::select('id')->get();
        $pi = [];
        foreach ($poli as $key => $d) {
            $pi[] = '' . $d->id . '';
        }

        $dokter = Pegawai::select('id')->get();
        $di = [];
        foreach ($dokter as $key => $d) {
            $di[] = '' . $d->id . '';
        }
        $data['cara_bayar'] = Carabayar::all();
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['caraPulang']         = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
        $data['pekerjaan']  = Pekerjaan::all();


        $query =  HistorikunjunganIRJ::with('resep.resep_detail.logistik_batch')->join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            // ->join('perawatan_icd10s', 'histori_kunjungan_irj.registrasi_id', '=', 'perawatan_icd10s.registrasi_id')
            // ->join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'pasiens.province_id')
            ->leftJoin('regencies', 'regencies.id', '=', 'pasiens.regency_id')
            ->leftJoin('districts', 'districts.id', '=', 'pasiens.district_id')
            ->with(['registrasi.icd9s', 'registrasi.icd10s'])
            ->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereNull('registrasis.deleted_at')
            ->whereIn('histori_kunjungan_irj.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
            ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
            //->groupBy('histori_kunjungan_irj.registrasi_id')
            ->select('registrasis.keterangan as keterangan', 'registrasis.pulang', 'registrasis.no_sep as sep', 'registrasis.bayar as bayar', 'registrasis.kondisi_akhir_pasien as kondisi_akhir', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.jkn as tipe_jkn_pasien', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status', 'registrasis.tipe_jkn', 'pasiens.nohp', 'pasiens.ibu_kandung', 'provinces.name as provinsi', 'regencies.name as kabupaten', 'districts.name as kecamatan', 'pasiens.pekerjaan_id'); //PAKE AS PROVINCES

        if ($request['cara_pulang_id'] != null) {
            $query->where('registrasis.pulang', $request['cara_pulang_id']);
        }

        if (!empty($request['jenis_pasien'])) {
            $query->where('registrasis.bayar', $request['jenis_pasien']);
        }

        if (!empty($request['tipe_jkn'])) {
            $query->where('registrasis.tipe_jkn', $request['tipe_jkn']);
        }

        if (!empty($request['pekerjaan'])) {
            $query->where('pasiens.pekerjaan_id', $request['pekerjaan']);
        }

        $data['reg'] = $query->get();
        $datareg = $data['reg'];

        if ($request['lanjut']) {
            return view('frontoffice.lap_kunjungan', $data)->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan Kunjungan ', function ($excel) use ($datareg, $request) {
                // Set the properties
                $excel->setTitle('Laporan Kunjungan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Kunjungan');
                $excel->sheet('Laporan Kunjungan', function ($sheet) use ($datareg, $request) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'No. RM',
                        'Umur',
                        'L/P',
                        'Alamat',
                        'Pekerjaan',
                        'Provinsi',
                        'Kabupaten',
                        'Kecamatan',
                        'No. HP',
                        'Klinik Tujuan',
                        'Dokter',
                        'Cara Bayar',
                        'Cara Pulang',
                        'sep',
                        // 'Tipe Jkn',
                        'Tanggal',
                        'Kunjungan',
                        'Diagnosa',
                        'Icd9',

                    ]);
                    foreach ($datareg as $key => $d) {
                        $icd10 = [];
                        $dataIcd10 = NULL;
                        if ($d->registrasi) {
                            if (count($d->registrasi->icd10s) > 0) {
                                foreach ($d->registrasi->icd10s as $data) {
                                    $icd10[] = baca_icd10($data->icd10);
                                }
                                $dataIcd10 = implode("\n", $icd10);
                            }
                        }

                        // dd($d->registrasi->icd9s);
                        $icd9 = [];
                        $dataIcd9 = NULL;
                        if ($d->registrasi) {
                            if (count($d->registrasi->icd9s) > 0) {
                                foreach ($d->registrasi->icd9s as $data) {
                                    $icd9[] = baca_icd9($data->icd9);
                                }
                                $dataIcd9 = implode("\n", $icd9);
                            }
                        }

                        $cppt = Emr::where("registrasi_id", @$d->registrasi->id)->whereNotNull('discharge')->first();

                        if ($cppt) {
                            $discharge = @baca_discharge_cppt($cppt);
                        }
                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            $d->no_rm,
                            hitung_umur($d->tgllahir, 'Y'),
                            $d->kelamin,
                            $d->alamat,
                            @baca_pekerjaan(@$d->pekerjaan_id),
                            $d->provinsi,
                            $d->kabupaten,
                            $d->kecamatan,
                            $d->nohp,
                            baca_poli($d->poli_id),
                            baca_dokter($d->dokter_id),
                            baca_carabayar($d->bayar) == "BPJS" ? baca_carabayar($d->bayar) . '-' . $d->tipe_jkn_pasien : baca_carabayar($d->bayar),
                            // @baca_carapulang(@$d->pulang),
                            @$discharge,
                            $d->sep,
                            // $d->tipe_jkn,
                            tanggal($d->created_at),
                            $d->status,
                            $dataIcd10,
                            $dataIcd9,
                        ]);
                    }
                });
            })->export('xlsx');
        } elseif ($request['pdf']) {
            $data['tga'] = valid_date($request['tga']) . ' 00:00:00';
            $data['tgb'] = valid_date($request['tgb']) . ' 23:59:59';
            // $tgb =  valid_date($request['tgb'];
            // $reg = $data['reg'];
            // $no = 1;
            // $pdf = PDF::loadView('frontoffice.pdf_lap_kunjungan', compact('reg', 'no'));
            // $pdf->setPaper('A4', 'landscape');
            // return $pdf->download('lap_kunjungan.pdf');
            return view('frontoffice.rekapLapKunjungan', $data)->with('no', 1);
        }
    }

    public function lap_diagnosa_irj()
    {
        $data['irj'] = [];
        // $data['irj'] = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->whereBetween('perawatan_icd10s.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
        //     ->where('perawatan_icd10s.jenis', '<>', 'TI')
        //     ->limit(10)
        //     ->get();
        $data['poli'] = Poli::pluck('nama', 'id');
        // foreach($data['irj'] as $a) {
        // 	$a->jk = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
        // 					->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        // 					->whereBetween('perawatan_icd10s.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
        // 					->where('perawatan_icd10s.jenis', '<>', 'TI')
        // 					->where('perawatan_icd10s.icd10', $a->icd10)
        // 					->select('pasiens.kelamin', DB::raw('count(*) as total'))
        // 					->groupBy('pasiens.kelamin')
        // 					->orderBy('total', 'desc')
        // 					->get();
        // }

        $data['icd10'] = JknIcd10::select('icd10 as diagnosa', DB::raw('COUNT(*) as jumlah'))
            ->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->groupBy('icd10')
            ->orderByDesc('jumlah')
            ->take(10)
            ->get();

        return view('frontoffice.lap_diagnosa_irj', $data)->with('no', 1);
    }

    public function lap_diagnosa_irj_byTanggal(Request $request)
    {

        $poli = Poli::pluck('nama', 'id');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $diagnosa = explode('#', $request->diagnosa);
        // dd($diagnosa);
        // if ($request['batas'] == 0) {
        // 	$limit = 0;
        // } else {
        // 	$limit = $request['batas'];
        // }

        $irj = JknIcd10::join('registrasis', 'registrasis.id', '=', 'jkn_icd10s.registrasi_id')
            ->whereBetween('jkn_icd10s.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('jkn_icd10s.jenis', '<>', 'TI')
            ->take(10);
        if ($diagnosa[0] !== '') {
            $irj = $irj->whereIn('jkn_icd10s.icd10', $diagnosa);
        }
        if ($request->poli != '') {
            $irj = $irj->where('registrasis.poli_id', $request->poli);
        }
        $icd10 = $irj
            ->select('jkn_icd10s.icd10 as diagnosa', DB::raw('COUNT(jkn_icd10s.id) as jumlah'))
            ->groupBy('jkn_icd10s.icd10')
            ->orderBy('jumlah', 'DESC')
            ->get();
        // dd($icd10);

        // foreach($icd10 as $a) {
        // 	$jk = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
        // 					->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        // 					->whereBetween('perawatan_icd10s.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
        // 					->where('perawatan_icd10s.jenis', '<>', 'TI')
        // 					->where('perawatan_icd10s.icd10', $a->icd10)
        // 					->select('pasiens.kelamin', DB::raw('count(*) as total'))
        // 					->groupBy('pasiens.kelamin')
        // 					->orderBy('total', 'desc');

        // 					if($request->poli != ''){
        // 						$jk = $jk->where('registrasis.poli_id', $request->poli);
        // 					}
        // 					if($diagnosa[0] !== ''){
        // 						$jk = $jk->whereIn('perawatan_icd10s.icd10',$diagnosa);
        // 					}
        // 					$jk = $jk->get();


        // 	$a->jk = $jk;
        // }
        if ($request['view']) {
            return view('frontoffice.lap_diagnosa_irj', compact('irj', 'icd10', 'poli'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan 10 Besar Penyakit IRJ ', function ($excel) use ($icd10) {
                // Set the properties
                $excel->setTitle('Laporan 10 Besar Penyakit IRJ')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan 10 Besar Penyakit IRJ');
                $excel->sheet('Laporan 10 Besar Penyakit IRJ', function ($sheet) use ($icd10) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'ICD10',
                        'Nama Diagnosa',
                        'Jumlah',
                    ]);
                    foreach ($icd10 as $key => $d) {
                        $sheet->row(++$row, [
                            $no++,
                            @$d->diagnosa,
                            baca_icd10(@$d->diagnosa),
                            @$d->jumlah,
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }



    public function lap_diagnosa_igd()
    {
        $data['igd'] = [];
        // $data['igd'] = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->whereBetween('perawatan_icd10s.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
        //     ->where('perawatan_icd10s.jenis', '<>', 'TG')
        //     ->limit(10)
        //     ->get();
        $data['poli'] = Poli::pluck('nama', 'id');
        return view('frontoffice.lap_diagnosa_igd', $data)->with('no', 1);
    }

    public function lap_diagnosa_igd_byTanggal(Request $request)
    {

        $poli = Poli::pluck('nama', 'id');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $diagnosa = explode('#', $request->diagnosa);
        // dd($diagnosa);
        // if ($request['batas'] == 0) {
        // 	$limit = 0;
        // } else {
        // 	$limit = $request['batas'];
        // }

        $igd = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('perawatan_icd10s.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', '<>', 'TG')
            ->limit(1000);
        if ($diagnosa[0] !== '') {
            $igd = $igd->whereIn('perawatan_icd10s.icd10', $diagnosa);
        }
        if ($request->poli != '') {
            $igd = $igd->where('registrasis.poli_id', $request->poli);
        }
        $ok = $igd->get();

        if ($request['view']) {
            return view('frontoffice.lap_diagnosa_igd', compact('igd', 'ok', 'poli'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan 10 Besar Penyakit IGD ', function ($excel) use ($ok) {
                // Set the properties
                $excel->setTitle('Laporan 10 Besar Penyakit IGD')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan 10 Besar Penyakit IGD');
                $excel->sheet('Laporan 10 Besar Penyakit IGD', function ($sheet) use ($ok) {
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
                            baca_pasien($reg->pasien_id),
                            $reg->pasien->no_rm,
                            " " . strval($reg->pasien->nik),
                            baca_dokter($reg->dokter_id),
                            @$reg->status,
                            $kasus,
                            baca_rujukan(@$reg->rujukkan),
                            baca_poli($reg->poli_id),
                            @baca_diagnosa(@$reg->diagnosa_awal),
                            @baca_diagnosa(@$reg->diagnosa_akhir),
                            baca_icd9(@$icd9->icd9),
                            baca_icd10(@$d->icd10),
                            @$reg->keterangan,
                            baca_jkn(@$reg->id),
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

    public function lap_indikator_igd(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '-1');
        $tga = $request->has('tga') ?  valid_date($request['tga']) . ' 00:00:00' : Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $tgb = $request->has('tgb') ?  valid_date($request['tgb']) . ' 23:59:59' : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        // $datas = Folio::where('jenis', 'TG')->where('poli_tipe', 'G')->whereBetween('created_at', [$tga, $tgb])->get();
        $datas = HistorikunjunganIGD::whereBetween('created_at', [$tga, $tgb])->get();
        if ($request['excel']) {
            Excel::create('Laporan Indikator Pelayanan IGD', function ($excel) use ($datas) {
                // Set the properties
                $excel->setTitle('Laporan Indikator Pelayanan IGD')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Indikator Pelayanan IGD');
                $excel->sheet('Laporan Indikator Pelayanan IGD', function ($sheet) use ($datas) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'RM',
                        'Alamat',
                        'Umur (Tahun)',
                        'JK',
                        'HP',
                        'Diagnosa',
                        'Cara Bayar',
                        'DPJP',
                        'Tgl Pelayanan',
                        'Triage',
                        'Kasus',
                        'Jam Masuk',
                        'Jam Pelayanan',
                        'Jam Pulang',
                        'Response Time (Menit)',
                        'Waktu Observasi (Menit)',
                        'Cara Masuk',
                        'Cara Pulang',
                        'Kondisi Pulang',
                        'Keterangan',

                    ]);
                    foreach ($datas as $key => $data) {
                        $diffResponseTime = null;
                        if (@json_decode(@$data->registrasi->status_ugd)->jam_masuk != null && @json_decode(@$data->registrasi->status_ugd)->jam_penanganan != null) {
                            $today = Carbon::today()->toDateString();
                            $waktuMasuk = Carbon::parse("$today " . @json_decode(@$data->registrasi->status_ugd)->jam_masuk . ":00");
                            $waktuPenanganan = Carbon::parse("$today " . @json_decode(@$data->registrasi->status_ugd)->jam_penanganan . ":00");
                            if ($waktuPenanganan < $waktuMasuk) {
                                $waktuPenanganan->addDay();
                            }
                            $diffResponseTime = $waktuPenanganan->diffInMinutes($waktuMasuk);
                        }

                        $diffWaktuObservasi = null;
                        $waktuPulang = Carbon::parse(@$data->registrasi->tgl_pulang)->format('H:i');
                        if (@$data->registrasi->tgl_pulang != null && @json_decode(@$data->registrasi->status_ugd)->jam_penanganan != null) {
                            $today = Carbon::today()->toDateString();
                            $waktuPulang = Carbon::parse("$today " . $waktuPulang . ":00");
                            $waktuPenanganan = Carbon::parse("$today " . @json_decode(@$data->registrasi->status_ugd)->jam_penanganan . ":00");
                            if ($waktuPenanganan > $waktuPulang) {
                                $waktuPulang->addDay();
                            }
                            $diffWaktuObservasi = $waktuPenanganan->diffInMinutes($waktuPulang);
                        }

                        $sheet->row(++$row, [
                            $no++,
                            @$data->pasien->nama,
                            @$data->pasien->no_rm,
                            @$data->pasien->alamat,
                            Carbon::parse(@$data->pasien->tgllahir)->diffInYears(Carbon::now()),
                            @$data->pasien->kelamin,
                            @$data->pasien->nohp,
                            @$data->registrasi->icd10s ? implode('|', @$data->registrasi->icd10s->pluck('icd10')->toArray()) : '',
                            @$data->registrasi->cara_bayar->carabayar,
                            baca_dokter(@$data->registrasi->dokter_id),
                            @$data->registrasi->created_at,
                            @json_decode(@$data->registrasi->status_ugd)->triage,
                            @json_decode(@$data->registrasi->status_ugd)->kasus,
                            @json_decode(@$data->registrasi->status_ugd)->jam_masuk,
                            @json_decode(@$data->registrasi->status_ugd)->jam_penanganan,
                            @$data->registrasi->tgl_pulang ? Carbon::parse(@$data->registrasi->tgl_pulang)->format('H:i') : '',
                            @$diffResponseTime,
                            @$diffWaktuObservasi,
                            @json_decode(@$data->registrasi->status_ugd)->caraMasuk,
                            @$data->registrasi->caraPulang->namakondisi,
                            @$data->registrasi->kondisiAkhir->namakondisi,
                            @json_decode(@$data->registrasi->status_ugd)->keterangan
                        ]);
                    }
                });
            })->export('xlsx');
        } else {
            return view('frontoffice.lap_indikator_pelayanan_igd', compact('tga', 'tgb', 'datas'))->with('no', 1);
        }
    }






    public function lap_diagnosa_irna()
    {
        $kamars  = Kamar::pluck('nama', 'id');
        $ok = [];
        // $irna   = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
        //     ->whereBetween('perawatan_icd10s.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
        //     ->where('perawatan_icd10s.jenis', '=', 'TI')
        //     ->select('pasiens.id as idPasien', 'rawatinaps.dokter_id as dokterRanap', 'rawatinaps.kelompokkelas_id as kelompok', 'rawatinaps.tgl_masuk as tglMasuk', 'rawatinaps.tgl_keluar as tglKeluar', 'rawatinaps.kamar_id', 'registrasis.created_at as tglRegis', 'registrasis.diagnosa_awal as diagnosaAwal', 'perawatan_icd10s.icd10 as icd10', 'registrasis.keterangan as keterangan', 'registrasis.id as idReg', 'pasiens.alamat as alamat', 'pasiens.province_id as provinsi', 'pasiens.regency_id as kabupaten', 'pasiens.district_id as kecamatan', 'pasiens.village_id as kelurahan', 'registrasis.rujukan as rujukan', 'registrasis.status as status', 'pasiens.nama as namaPasien', 'pasiens.no_rm as norm', 'pasiens.nik as nik')
        //     ->get();
        // $ok = [];
        // foreach ($irna as $irna) {
        //     $ok[] = [
        //         'idReg' => $irna->idReg,
        //         'idPasien' => $irna->idPasien,
        //         'namaPasien' => $irna->namaPasien,
        //         'norm' => $irna->norm,
        //         'nik' => $irna->nik,
        //         'dokterRanap' => baca_dokter($irna->dokterRanap),
        //         'status' => $irna->status,
        //         'rujukan' => baca_rujukan($irna->rujukan),
        //         'kelompok' => baca_kelompok($irna->kelompok),
        //         'tglRegis' => Carbon::parse($irna->tglRegis)->format('d-m-Y H:i:s'),
        //         'tglMasuk' => Carbon::parse($irna->tglMasuk)->format('d-m-Y H:i:s'),
        //         'tglKeluar' => $irna->tglKeluar ? Carbon::parse($irna->tglKeluar)->format('d-m-Y H:i:s') : '-',
        //         'diagnosaAwal' => baca_diagnosa($irna->diagnosaAwal),
        //         'icd10' => baca_icd10($irna->icd10),
        //         'keterangan' => $irna->keterangan,
        //         'tipe_jkn' => baca_jkn($irna->idReg),
        //         'alamat' => $irna->alamat,
        //         'provinsi' => baca_propinsi($irna->provinsi),
        //         'kabupaten' => baca_kabupaten($irna->kabupaten),
        //         'kecamatan' => baca_kecamatan($irna->kecamatan),
        //         'kelurahan' => baca_kelurahan($irna->kelurahan),
        //     ];
        // }
        return view('frontoffice.lap_diagnosa_irna', compact('ok', 'kamars'))->with('no', 1);
    }

    public function lap_diagnosa_irna_byTanggal(Request $request)
    {
        $kamars  = Kamar::pluck('nama', 'id');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $diagnosa = explode('#', $request->diagnosa);
        // dd($diagnosa);
        // if ($request['batas'] == 0) {
        // 	$limit = 0;
        // } else {
        // 	$limit = $request['batas'];
        // }

        $irna = PerawatanIcd10::join('registrasis', 'registrasis.id', '=', 'perawatan_icd10s.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('perawatan_icd10s.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('perawatan_icd10s.jenis', '=', 'TI')
            ->orderBy('registrasis.created_at', 'ASC')
            ->select(
                'pasiens.id as idPasien',
                'rawatinaps.dokter_id as dokterRanap',
                'rawatinaps.kelompokkelas_id as kelompok',
                'rawatinaps.tgl_masuk as tglMasuk',
                'rawatinaps.tgl_keluar as tglKeluar',
                'rawatinaps.kamar_id',
                'registrasis.created_at as tglRegis',
                'registrasis.diagnosa_awal as diagnosaAwal',
                'perawatan_icd10s.icd10 as icd10',
                'registrasis.keterangan as keterangan',
                'registrasis.id as idReg',
                'pasiens.alamat as alamat',
                'pasiens.province_id as provinsi',
                'pasiens.regency_id as kabupaten',
                'pasiens.district_id as kecamatan',
                'pasiens.village_id as kelurahan',
                'registrasis.rujukan as rujukan',
                'registrasis.status as status',
                'pasiens.nama as namaPasien',
                'pasiens.no_rm as norm',
                'pasiens.nik as nik'
            )
            ->limit(1000);
        if ($diagnosa[0] !== '') {
            $irna = $irna->whereIn('perawatan_icd10s.icd10', $diagnosa);
        }
        if ($request->kamar_id != '') {
            $irna = $irna->where('rawatinaps.kamar_id', $request->kamar_id);
        }
        $irna = $irna->get();
        $ok = [];

        foreach ($irna as $irna) {
            $ok[] = [
                'idReg' => $irna->idReg,
                'idPasien' => $irna->idPasien,
                'namaPasien' => $irna->namaPasien,
                'norm' => $irna->norm,
                'nik' => $irna->nik,
                'dokterRanap' => baca_dokter($irna->dokterRanap),
                'status' => $irna->status,
                'rujukan' => baca_rujukan($irna->rujukan),
                'kelompok' => baca_kelompok($irna->kelompok),
                'tglRegis' => Carbon::parse($irna->tglRegis)->format('d-m-Y H:i:s'),
                'tglMasuk' => Carbon::parse($irna->tglMasuk)->format('d-m-Y H:i:s'),
                'tglKeluar' => Carbon::parse($irna->tglKeluar)->format('d-m-Y H:i:s'),
                'diagnosaAwal' => baca_diagnosa($irna->diagnosaAwal),
                'icd10' => baca_icd10($irna->icd10),
                'keterangan' => $irna->keterangan,
                'tipe_jkn' => baca_jkn($irna->idReg),
                'alamat' => $irna->alamat,
                'provinsi' => baca_propinsi($irna->provinsi),
                'kabupaten' => baca_kabupaten($irna->kabupaten),
                'kecamatan' => baca_kecamatan($irna->kecamatan),
                'kelurahan' => baca_kelurahan($irna->kelurahan),
            ];
        }

        // return $ok; die;

        if ($request['view']) {
            return view('frontoffice.lap_diagnosa_irna', compact('irna', 'ok', 'kamars'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan 10 Besar Penyakit IRNA ', function ($excel) use ($ok) {
                // Set the properties
                $excel->setTitle('Laporan 10 Besar Penyakit IRNA')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan 10 Besar Penyakit IRNA');
                $excel->sheet('Laporan 10 Besar Penyakit IRNA', function ($sheet) use ($ok) {
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
                        'Ruangan',
                        'Poli',
                        'Tgl. Masuk',
                        'Tgl. Keluar',
                        'Diagnosa Awal',
                        // 'Diagnosa Akhir',
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
                        $icd9 = PerawatanIcd9::where('registrasi_id', $d['idReg'])->first();
                        // $ranap = Rawatinap::where('registrasi_id', $reg->id)->first();
                        $pasien = Registrasi::where('pasien_id', $d['idPasien'])->count();

                        if ($pasien > 1) {
                            $kasus = 'Lama';
                        } else {
                            $kasus = 'Baru';
                        }

                        $jk = null;
                        $sheet->row(++$row, [
                            $no++,
                            $d['namaPasien'],
                            $d['norm'],
                            " " . strval($d['nik']),
                            $d['dokterRanap'],
                            $d['status'],
                            @$kasus,
                            $d['rujukan'],
                            $d['kelompok'],
                            $d['tglRegis'],
                            $d['tglMasuk'],
                            $d['tglKeluar'],
                            $d['diagnosaAwal'],
                            // @baca_diagnosa(@$reg->diagnosa_akhir),
                            baca_icd9(@$icd9->icd9),
                            $d['icd10'],
                            $d['keterangan'],
                            $d['tipe_jkn'],
                            $d['alamat'],
                            $d['provinsi'],
                            $d['kabupaten'],
                            $d['kecamatan'],
                            $d['kelurahan'],
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }






    // public function lap_diagnosa_irna()
    // {
    // 	$data['irj'] = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE jenis = "TI" AND created_at LIKE "%' . date('Y-m-d') . '%" GROUP BY icd10 ORDER BY jumlah DESC limit 10');
    // 	return view('frontoffice.lap_diagnosa_irna', $data)->with('no', 1);
    // }

    // public function lap_diagnosa_irna_byTanggal(Request $request)
    // {
    // 	request()->validate(['batas' => 'required', 'tga' => 'required', 'tgb' => 'required']);
    // 	$tga = valid_date($request['tga']);
    // 	$tgb = valid_date($request['tgb']);
    // 	if ($request['batas'] == 0) {
    // 		$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" AND jenis = "TI"
    // 						GROUP BY icd10 ORDER BY jumlah DESC');
    // 	} else {
    // 		$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" AND jenis = "TI"
    // 						GROUP BY icd10 ORDER BY jumlah DESC limit ' . $request['batas'] . '');
    // 	}
    // 	if ($request['view']) {
    // 		return view('frontoffice.lap_diagnosa_irna', compact('data'))->with('no', 1);
    // 	} elseif ($request['excel']) {
    // 		Excel::create('Laporan 10 Besar Penyakit IRNA ', function ($excel) use ($data) {
    // 			// Set the properties
    // 			$excel->setTitle('Laporan 10 Besar Penyakit IRNA')
    // 				->setCreator('Digihealth')
    // 				->setCompany('Digihealth')
    // 				->setDescription('Laporan 10 Besar Penyakit IRNA');
    // 			$excel->sheet('Laporan 10 Besar Penyakit IRNA', function ($sheet) use ($data) {
    // 				$row = 1;
    // 				$no = 1;
    // 				$sheet->row($row, [
    // 					'No',
    // 					'ICD10',
    // 					'Diagnosa',
    // 					'Jumlah',
    // 				]);
    // 				foreach ($data as $key => $d) {
    // 					$sheet->row(++$row, [
    // 						$no++,
    // 						$d->diagnosa,
    // 						baca_icd10($d->diagnosa),
    // 						$d->jumlah,
    // 					]);
    // 				}
    // 			});
    // 		})->export('xlsx');
    // 	}
    // }	







    public function distribusi_ranap()
    {
        $tga = valid_date(date('Y-m-d'));
        $tgb = valid_date(date('Y-m-d'));

        $kelompok = Kelompokkelas::all();
        $cara_bayar = Carabayar::all();
        return view('frontoffice.lap_distribusi_ranap', compact('kelompok', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
    }

    public function distribusi_ranap_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $kelompok = Kelompokkelas::all();
        $cara_bayar = Carabayar::all();

        if ($request['view']) {
            return view('frontoffice.lap_distribusi_ranap', compact('kelompok', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('Distribusi Rawat Inap', function ($excel) use ($cara_bayar, $kelompok, $tga, $tgb) {
                $excel->setTitle('Distribusi Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Distribusi Rawat Inap');
                $excel->sheet('Distribusi', function ($sheet) use ($cara_bayar, $kelompok, $tga, $tgb) {
                    $sheet->loadView('frontoffice.lap_distribusi_ranap_excel', [
                        'cara_bayar' => $cara_bayar,
                        'kelompok' => $kelompok,
                        'tga' => $tga,
                        'tgb' => $tgb
                    ]);
                });
            })->export('xlsx');
        }
    }




    public function distribusi_radar()
    {
        $tga = valid_date(date('Y-m-d'));
        $tgb = valid_date(date('Y-m-d'));

        $poli = Poli::all();
        $cara_bayar = Carabayar::all();
        return view('frontoffice.lap_distribusi_radar', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
    }

    public function distribusi_radar_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $poli = Poli::all();
        $cara_bayar = Carabayar::all();

        if ($request['view']) {
            return view('frontoffice.lap_distribusi_radar', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['excel']) {
            return $request;
            die;
        }
    }








    public function distribusi_rajal()
    {
        $tga = valid_date(date('Y-m-d'));
        $tgb = valid_date(date('Y-m-d'));

        $poli = [];
        $cara_bayar = Carabayar::all();
        return view('frontoffice.lap_distribusi_rajal', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
    }

    public function distribusi_rajal_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $data_poli = [];
        $poli_hariini = Registrasi::where('bayar', 1)
            ->whereIn('status_reg', ['J1', 'J2', 'J3'])
            ->where('tipe_jkn', '!=', 'PBI')
            ->where('tipe_jkn', '!=', 'PNS')
            ->where('tipe_jkn', '!=', 'SWASTA')
            ->where('tipe_jkn', '!=', 'MANDIRI')
            ->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
            ->groupBy('poli_id')
            ->select('poli_id')->get();
        foreach ($poli_hariini as $p) {
            $data_poli[] = $p->poli_id;
        }
        // $poli_id = "6,3,6";
        // dd(explode(",",$poli_id));
        $poli = Poli::whereIn('id', $data_poli)->select('id', 'nama')->get();
        // dd($poli);
        $cara_bayar = Carabayar::all();

        if ($request['view']) {
            return view('frontoffice.lap_distribusi_rajal', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['excel']) {
            // dd($poli);
            Excel::create('Distribusi Rajal ' . $tga . '/' . $tgb, function ($excel) use ($cara_bayar, $poli, $tga, $tgb) {
                $excel->setTitle('Distribusi Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Distribusi Rawat Inap');
                $excel->sheet('Distribusi', function ($sheet) use ($cara_bayar, $poli, $tga, $tgb) {
                    $sheet->loadView('frontoffice.excel.lap_distribusi_rajal_excel', [
                        'cara_bayar' => $cara_bayar,
                        'tga' => $tga,
                        'poli' => $poli,
                        'tgb' => $tgb
                    ]);
                });
            })->export('xls');
        }
    }


    public function usg()
    {
        $tga = valid_date(date('Y-m-d'));
        $tgb = valid_date(date('Y-m-d'));

        $poli = Poli::all();
        $cara_bayar = Carabayar::all();
        return view('frontoffice.lap_usg', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
    }

    public function usg_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $poli = Poli::all();
        $cara_bayar = Carabayar::all();

        if ($request['view']) {
            return view('frontoffice.lap_usg', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('Laporan USG', function ($excel) use ($poli, $tga, $tgb) {
                $excel->setTitle('Laporan USG')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan USG');
                $excel->sheet('Laporan USG', function ($sheet) use ($poli, $tga, $tgb) {
                    $sheet->setCellValue('A1', 'No');
                    $sheet->mergeCells('A1:A3');

                    $sheet->setCellValue('B1', 'Poli');
                    $sheet->mergeCells('B1:B3');

                    $sheet->setCellValue('C1', 'Jumlah Pasien Per Status Bayar');
                    $sheet->mergeCells('C1:H1');

                    $sheet->setCellValue('C2', 'Bayar Sendiri (Umum)');
                    $sheet->mergeCells('C2:C3');

                    $sheet->setCellValue('D2', 'KONTRAK');
                    $sheet->mergeCells('D2:G2');

                    $sheet->setCellValue('D3', 'BPJS PBI');
                    $sheet->setCellValue('E3', 'BPJS PNS');
                    $sheet->setCellValue('F3', 'BPJS SWASTA');
                    $sheet->setCellValue('G3', 'BPJS MANDIRI');

                    $sheet->setCellValue('H2', 'KONTRAKTOR');
                    $sheet->mergeCells('H2:H3');

                    $sheet->setCellValue('I1', 'Jumlah Pasien Per Status');
                    $sheet->mergeCells('I1:K2');

                    $sheet->setCellValue('I3', 'LAMA');
                    $sheet->setCellValue('J3', 'BARU');
                    $sheet->setCellValue('K3', 'TOTAL');

                    $row = 4;
                    $no = 1;

                    foreach ($poli as $key => $d) {
                        $total_kontraktor = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                            ->where('registrasis.poli_id', $d->id)
                            ->where('registrasis.status_reg', 'like', 'J%')
                            ->where('registrasis.tipe_jkn', '!=', 'PBI')
                            ->where('registrasis.tipe_jkn', '!=', 'PNS')
                            ->where('registrasis.tipe_jkn', '!=', 'SWASTA')
                            ->where('registrasis.tipe_jkn', '!=', 'MANDIRI')
                            ->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $total_kontraktor_baru = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                            ->where('registrasis.poli_id', $d->id)
                            ->where('registrasis.status_reg', 'like', 'J%')
                            ->where('registrasis.status', 'baru')
                            ->where('registrasis.tipe_jkn', '!=', 'PBI')
                            ->where('registrasis.tipe_jkn', '!=', 'PNS')
                            ->where('registrasis.tipe_jkn', '!=', 'SWASTA')
                            ->where('registrasis.tipe_jkn', '!=', 'MANDIRI')
                            ->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $total_kontraktor_lama = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                            ->where('registrasis.poli_id', $d->id)
                            ->where('registrasis.status', 'lama')
                            ->where('registrasis.status_reg', 'like', 'J%')
                            ->where('registrasis.tipe_jkn', '!=', 'PBI')
                            ->where('registrasis.tipe_jkn', '!=', 'PNS')
                            ->where('registrasis.tipe_jkn', '!=', 'SWASTA')
                            ->where('registrasis.tipe_jkn', '!=', 'MANDIRI')
                            ->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();


                        $umum                = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $umum_baru           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $umum_lama           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $pbi                = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pbi_lama           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pbi_baru           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $pns                = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pns_lama           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pns_baru           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $swasta              = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $swasta_lama         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $swasta_baru         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $mandiri              = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $mandiri_lama         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $mandiri_baru         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $sheet->row(++$row, [
                            $no++,
                            baca_poli($d->id),
                            $umum,
                            $pbi,
                            $pns,
                            $swasta,
                            $mandiri,
                            $total_kontraktor,
                            @$total_kontraktor_lama + @$umum_lama + @$pbi_lama + @$pns_lama + $swasta_lama + $mandiri_lama,
                            @$total_kontraktor_baru + @$umum_baru + @$pbi_baru + @$pns_baru + $swasta_baru + $mandiri_baru,
                            @$total_kontraktor_lama + @$umum_lama + @$pbi_lama + @$pns_lama + $swasta_lama + $mandiri_lama + @$total_kontraktor_baru + @$umum_baru + @$pbi_baru + @$pns_baru + $swasta_baru + $mandiri_baru
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }


    public function ekg()
    {
        $tga = valid_date(date('Y-m-d'));
        $tgb = valid_date(date('Y-m-d'));

        $poli = Poli::all();
        $cara_bayar = Carabayar::all();
        return view('frontoffice.lap_ekg', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
    }

    public function ekg_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $poli = Poli::all();
        $cara_bayar = Carabayar::all();

        if ($request['view']) {
            return view('frontoffice.lap_ekg', compact('poli', 'cara_bayar', 'tga', 'tgb'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('Laporan EKG', function ($excel) use ($poli, $tga, $tgb) {
                $excel->setTitle('Laporan EKG')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan EKG');
                $excel->sheet('Laporan EKG', function ($sheet) use ($poli, $tga, $tgb) {
                    $sheet->setCellValue('A1', 'No');
                    $sheet->mergeCells('A1:A3');

                    $sheet->setCellValue('B1', 'Poli');
                    $sheet->mergeCells('B1:B3');

                    $sheet->setCellValue('C1', 'Jumlah Pasien Per Status Bayar');
                    $sheet->mergeCells('C1:H1');

                    $sheet->setCellValue('C2', 'Bayar Sendiri (Umum)');
                    $sheet->mergeCells('C2:C3');

                    $sheet->setCellValue('D2', 'KONTRAK');
                    $sheet->mergeCells('D2:G2');

                    $sheet->setCellValue('D3', 'BPJS PBI');
                    $sheet->setCellValue('E3', 'BPJS PNS');
                    $sheet->setCellValue('F3', 'BPJS SWASTA');
                    $sheet->setCellValue('G3', 'BPJS MANDIRI');

                    $sheet->setCellValue('H2', 'KONTRAKTOR');
                    $sheet->mergeCells('H2:H3');

                    $sheet->setCellValue('I1', 'Jumlah Pasien Per Status');
                    $sheet->mergeCells('I1:K2');

                    $sheet->setCellValue('I3', 'LAMA');
                    $sheet->setCellValue('J3', 'BARU');
                    $sheet->setCellValue('K3', 'TOTAL');

                    $row = 4;
                    $no = 1;

                    foreach ($poli as $key => $d) {
                        $total_kontraktor = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                            ->where('registrasis.poli_id', $d->id)
                            ->where('registrasis.status_reg', 'like', 'J%')
                            ->where('registrasis.tipe_jkn', '!=', 'PBI')
                            ->where('registrasis.tipe_jkn', '!=', 'PNS')
                            ->where('registrasis.tipe_jkn', '!=', 'SWASTA')
                            ->where('registrasis.tipe_jkn', '!=', 'MANDIRI')
                            ->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $total_kontraktor_baru = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                            ->where('registrasis.poli_id', $d->id)
                            ->where('registrasis.status_reg', 'like', 'J%')
                            ->where('registrasis.status', 'baru')
                            ->where('registrasis.tipe_jkn', '!=', 'PBI')
                            ->where('registrasis.tipe_jkn', '!=', 'PNS')
                            ->where('registrasis.tipe_jkn', '!=', 'SWASTA')
                            ->where('registrasis.tipe_jkn', '!=', 'MANDIRI')
                            ->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $total_kontraktor_lama = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                            ->where('registrasis.poli_id', $d->id)
                            ->where('registrasis.status', 'lama')
                            ->where('registrasis.status_reg', 'like', 'J%')
                            ->where('registrasis.tipe_jkn', '!=', 'PBI')
                            ->where('registrasis.tipe_jkn', '!=', 'PNS')
                            ->where('registrasis.tipe_jkn', '!=', 'SWASTA')
                            ->where('registrasis.tipe_jkn', '!=', 'MANDIRI')
                            ->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();


                        $umum                = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $umum_baru           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $umum_lama           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $pbi                = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pbi_lama           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pbi_baru           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $pns                = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pns_lama           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $pns_baru           = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $swasta              = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $swasta_lama         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $swasta_baru         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $mandiri              = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $mandiri_lama         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                        $mandiri_baru         = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%ekg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                        $sheet->row(++$row, [
                            $no++,
                            baca_poli($d->id),
                            $umum,
                            $pbi,
                            $pns,
                            $swasta,
                            $mandiri,
                            $total_kontraktor,
                            @$total_kontraktor_lama + @$umum_lama + @$pbi_lama + @$pns_lama + $swasta_lama + $mandiri_lama,
                            @$total_kontraktor_baru + @$umum_baru + @$pbi_baru + @$pns_baru + $swasta_baru + $mandiri_baru,
                            @$total_kontraktor_lama + @$umum_lama + @$pbi_lama + @$pns_lama + $swasta_lama + $mandiri_lama + @$total_kontraktor_baru + @$umum_baru + @$pbi_baru + @$pns_baru + $swasta_baru + $mandiri_baru
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }







    public function ajax_lap_pengunjung()
    {
        $data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        return view('frontoffice.ajax_lap_pengunjung', $data)->with('no', 1);
    }

    //REKAM MEDIS
    public function rekammedis_pasien()
    {
        // $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        // return view('frontoffice.lap_rekammedis_pasien', $data);
        return view('frontoffice.vedika');
    }
    public function rekammedis_pasienIRJ_IGD()
    {
        return view('frontoffice.lap_rekammedis_pasien_irj_igd');
    }
    public function rekammedis_pasienIRNA()
    {
        return view('frontoffice.lap_rekammedis_pasien_irna');
    }

    public function view_rekammedis_pasien(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        return $request->all();
        die;
        $tga        = valid_date($request['tga']) . ' 00:00:00';
        $tgb        = valid_date($request['tgb']) . ' 23:59:59';
        $data['rekammedis'] = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
            ->join('inacbgs', 'inacbgs.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [$tga, $tgb])->where('registrasis.bayar', '1')
            ->select(
                DB::raw('SUM(folios.total) as total'),
                'registrasis.*'
            )->groupBy('registrasis.id')->get();
        // return $data; die;
        return view('frontoffice.lap_rekammedis_pasien', $data)->with('no', 1);
    }


    public function view_rekammedis_pasienIRNA(Request $request)
    {
        request()->validate(['tga' => 'required']);

        $tga        = valid_date($request['tga']) . ' 00:00:00';
        // $tgb        = valid_date($request['tgb']) . ' 23:59:59';
        $data['rekammedis'] = Inacbg::leftjoin('registrasis', 'inacbgs.registrasi_id', '=', 'registrasis.id')
            ->leftjoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'inacbgs.registrasi_id')
            // ->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
            ->where('registrasis.created_at', 'like', $tga . '%')
            ->where('inacbgs.dijamin', '!=', NULL)
            ->where('registrasis.bayar', 1)
            ->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
            ->select('inacbgs.*', 'registrasis.pasien_id as pasien_id', 'registrasis.status_reg as status_reg', 'rawatinaps.dokter_id as dokter_id', 'registrasis.bayar as bayar', 'rawatinaps.tgl_masuk as tgl_masuk', 'rawatinaps.tgl_keluar as tgl_keluar')
            ->get();
        // return $data; die;
        return view('frontoffice.lap_rekammedis_pasien_irna', $data)->with('no', 1);
    }


    public function view_rekammedis_pasienIRJ_IGD(Request $request)
    {
        request()->validate(['tga' => 'required']);
        // return $request->all(); die;

        $tga        = valid_date($request['tga']);
        // $tgb        = valid_date($request['tgb']) . ' 23:59:59';
        $data['rekammedis'] = Inacbg::leftjoin('registrasis', 'inacbgs.registrasi_id', '=', 'registrasis.id')
            // ->whereBetween('registrasis.created_at', [$tga, $tgb])
            ->where('registrasis.created_at', 'like', $tga . '%')

            ->where('inacbgs.dijamin', '!=', NULL)
            ->where('registrasis.bayar', 1)
            ->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'G1', 'G2', 'G3'])
            ->select('inacbgs.*', 'registrasis.pasien_id as pasien_id', 'registrasis.status_reg as status_reg', 'registrasis.dokter_id as dokter_id', 'registrasis.bayar as bayar', 'registrasis.created_at as tgl_regis', 'registrasis.updated_at as tgl_pulang')
            ->get();
        // return $data; die;
        return view('frontoffice.lap_rekammedis_pasien_irj_igd', $data)->with('no', 1);
    }

    public function viewDetailDokumen($registrasi_id)
    {
        $radiologi = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('radiologi', 'like', '%radiologi%')->get(['radiologi', 'id']);
        $laboratorium = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('laboratorium', 'like', '%lab%')->get(['laboratorium', 'id']);
        $resummedis = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('resummedis', 'like', '%resum%')->get(['resummedis', 'id']);
        $ekg = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('ekg', 'like', '%ekg%')->get(['ekg', 'id']);
        $operasi = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('operasi', 'like', '%operasi%')->get(['operasi', 'id']);
        $echo = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('echo', 'like', '%echo%')->get(['echo', 'id']);
        $pathway = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->where('pathway', 'like', '%pathway%')->get(['pathway', 'id']);
        return response()->json(['radiologi' => $radiologi, 'laboratorium' => $laboratorium, 'resummedis' => $resummedis, 'operasi' => $operasi, 'ekg' => $ekg, 'echo' => $echo, 'pathway' => $pathway]);
    }

    //=========================== SUPERVISOR ==========================================
    public function registrasiByTanggal(Request $request)
    {
        return redirect('frontoffice/supervisor/hapusregistrasi/' . $request['tanggal'] . '/' . $request['poli_id']);
    }
    public function backregistrasiByTanggal(Request $request)
    {
        return redirect('frontoffice/supervisor/back/' . $request['tanggal']);
    }
    public function hapusRegistrasi($tanggal = '', $poli = '')
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '8000M');

        // if (!empty($tanggal)) {

        //     $data['registrasi'] = Registrasi::with(['pasien', 'poli', 'bayars'])->where('created_at', 'LIKE', valid_date($tanggal) . '%');
        //     if (!empty($poli)) {
        //         $data['registrasi']   = $data['registrasi']->where('poli_id', $poli);
        //     }
        //     $data['registrasi'] = $data['registrasi']->get();
        // } else {

        //     $data['registrasi'] = Registrasi::with(['pasien', 'poli', 'bayars'])->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        // }
        // $data['poli'] = Poli::select('nama', 'id')->get();
        // $data= []
        return view('frontoffice.hapus_registrasi')->with('no', 1);
    }

    public function datahapusRegistrasi(Request $req)
    {

        if ($req->filled('keyword')) {
            // dd($req->keyword);
            $d = Registrasi::leftJoin('pasiens', 'pasiens.id', 'registrasis.pasien_id')
                ->with(['pasien', 'folio', 'dokter_umum', 'poli', 'bayars'])
                ->where(function ($query) use ($req) {
                    $query->where('pasiens.no_rm', $req->keyword)
                        ->orWhere('pasiens.nama', 'LIKE', "%$req->keyword%");
                })
                // ->where('registrasis.status_reg', 'like', 'J%')
                ->orderBy('registrasis.id', 'DESC')
                ->select([
                    'registrasis.id',
                    'registrasis.pasien_id',
                    'registrasis.dokter_id',
                    'registrasis.poli_id',
                    'registrasis.bayar',
                    'registrasis.tipe_jkn',
                    'registrasis.lunas',
                    'registrasis.created_at'
                ])
                // ->limit(5)
                ->get();
        } else {
            $keyCache = 'hapus_registrasi';
            $d = Cache::get($keyCache);
            if (!$d) {
                $d = Registrasi::
                    // where('status_reg', 'like', 'J%')
                    with(['pasien', 'folio', 'dokter_umum', 'poli', 'bayars'])
                    ->where('created_at', 'LIKE', date('Y-m-d' . '%'))
                    ->select([
                        'registrasis.id',
                        'registrasis.pasien_id',
                        'registrasis.dokter_id',
                        'registrasis.poli_id',
                        'registrasis.bayar',
                        'registrasis.tipe_jkn',
                        'registrasis.lunas',
                        'registrasis.created_at'
                    ])
                    ->get();
                Cache::put($keyCache, $d, 120); //BUAT CACHE 2 menit
            }
        }


        return DataTables::of($d)

            ->addColumn('nama', function ($d) {
                return @$d->pasien->nama;
            })
            ->addColumn('no_rm', function ($d) {
                return @$d->pasien->no_rm;
            })
            ->addColumn('alamat', function ($d) {
                return @$d->pasien->alamat;
            })
            ->addColumn('dokter_umum', function ($d) {
                return @$d->dokter_umum->nama;
            })
            ->addColumn('poli', function ($d) {
                return @$d->poli->nama;
            })
            ->addColumn('cara_bayar', function ($d) {
                return @$d->bayars->carabayar . ' ' . @$d->tipe_jkn;
            })
            ->addColumn('tanggal', function ($d) {
                return @$d->created_at->format('d-m-Y');
            })
            ->addColumn('aksi', function ($d) {
                if (@$d->lunas == 'N') {

                    if (json_decode(Auth::user()->is_edit, true)['hapus'] == 1) {
                        if (count(@$d->folio) == 0) {
                            $confirm = "return confirm('Yakin pasien: " . @$d->pasien->nama . " akan di hapus?')";
                            return '<a href="' . url('frontoffice/supervisor/soft-delete-registrasi/' . @$d->id) . '" onclick="' . $confirm . '" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-trash-o"></i> </a>';
                        } else {
                            return "<small><i>Sudah Ada Billing</i></small>";
                        }
                    }
                } else {
                    return '<i class="fa fa-remove"></i>';
                }
            })
            ->addColumn('status', function ($d) {
                if (@$d->lunas != 'N') {

                    return "LUNAS";
                } else {
                    return "BELUM LUNAS";
                }
            })
            ->rawColumns(['status', 'aksi'])
            ->addIndexColumn()
            ->make(true);
    }


    public function backRegistrasi($tanggal = '')
    {

        if (!empty($tanggal)) {
            //dd('1');
            $data['registrasi'] = Registrasi::where('created_at', 'LIKE', valid_date($tanggal) . '%')->onlyTrashed()->get();
        } else {
            //dd('2');
            $data['registrasi'] = Registrasi::onlyTrashed()->get();
        }
        return view('frontoffice.backregistrasi', $data)->with('no', 1);
    }

    //Hapus SoftDelete Registrasi(Jika dihapus data tetap masih ada)
    public function SoftDeleteRegistrasi($id)
    {
        //dd("Test Hapus SoftDelete");
        $cek_folio = Folio::where('registrasi_id', $id)->where('lunas', 'Y')->count();
        if ($cek_folio > 0) {
            Flashy::danger('Daftar Registrasi Tidak bisa Dihapus, sudah di lakukan transaksi Pembayaran.');
        } else {
            //Tangkap User Yang Hapus , Marai Geger
            $datas['user_deleted'] = Auth::user()->name;
            Registrasi::where('id', $id)->update($datas);

            HistorikunjunganIRJ::where('registrasi_id', $id)->delete();
            Historipengunjung::where('registrasi_id', $id)->delete();
            //Hapus registrasi
            $DeleteReq = Registrasi::find($id)->delete();
            Flashy::success('Data Registrasi Pasien Berhasil dihapus');
            Cache::forget('hapus_registrasi');
            return redirect('/frontoffice/supervisor/hapusregistrasi');
        }
    }

    public function kembalikanreq($id)
    {
        $reqpasien = Registrasi::onlyTrashed()->where('id', $id);
        $reqpasien->restore();
        Flashy::success('Data Registrasi Pasien Berhasil dikembalikan');
        return redirect('/frontoffice/supervisor/hapusregistrasi');
    }

    // Hapus Permanen Registrasi berserta relasinya
    public function saveHapusRegistrasi($id)
    {
        $cek_folio = Folio::where('registrasi_id', $id)->where('lunas', 'Y')->count();
        if ($cek_folio > 0) {
            Flashy::danger('Daftar Registrasi Tidak bisa Dihapus, sudah di lakukan transaksi Pembayaran.');
        } else {

            //Hapus registrasi

            $folio = Folio::where('registrasi_id', $id)->get();
            if ($folio) {
                foreach ($folio as $d) {
                    $fol = Folio::find($d->id)->delete();
                }
            }

            // Hapus Histori Status
            $history = \Modules\Registrasi\Entities\HistoriStatus::where('registrasi_id', $id)->first();
            if ($history) {
                $history->delete();
            }
            //Hapus Histori Pengunjung
            $hp = \App\Historipengunjung::where('registrasi_id', $id)->count();
            if ($hp > 0) {
                Historipengunjung::where('registrasi_id', $id)->delete();
            }

            //Hapus Histori
            $igd = \App\HistorikunjunganIGD::where('registrasi_id', $id)->first();

            //Hapus Kunjunagn IRJ
            $hk = HistorikunjunganIRJ::where('registrasi_id', $id)->count();
            if ($hk > 0) {
                HistorikunjunganIRJ::where('registrasi_id', $id)->delete();
            }
            Registrasi::find($id)->delete();
            Flashy::success('Daftar Registrasi berhasil di hapus.');
        }
        return redirect('/frontoffice/supervisor/hapusregistrasi');
    }
    // YANG DIUBAH
    public function ubah_dpjp()
    {
        return view('frontoffice.ubah_dpjp');
    }

    public function dataUbahDpjp($tga = '', $tgb = '')
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8000M');
        if (!empty($tga) && !empty($tgb)) {
            $data = Registrasi::select(['registrasis.id as regis_id', 'pasien_id', 'jenis_pasien', 'status', 'dokter_id', 'poli_id', 'bayar', 'tipe_jkn', 'no_sep'])
                // ->join('sebabsakits', 'sebabsakits.id', '=', 'registrasis.sebabsakit_id')
                ->whereBetween('registrasis.created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
                ->where('pasien_id', '<>', '0')
                // ->where('poli_id', '<>', '0')
                ->get();
        } else {


            $keyCache = 'ubahdpjp';
            $data = Cache::get($keyCache);
            if (!$data) {
                $data = Registrasi::select(['registrasis.id as regis_id', 'pasien_id', 'jenis_pasien', 'status', 'dokter_id', 'poli_id', 'bayar', 'tipe_jkn'])

                    ->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
                    ->where('pasien_id', '<>', '0')
                    ->get();
                Cache::put($keyCache, $data, 120); //BUAT CACHE 2 menit
            }
        }

        return DataTables::of($data)
            ->addColumn('no_rm', function ($data) {
                // $pasien = Pasien::find($data->pasien_id);
                return @$data->pasien->no_rm;
            })
            ->addColumn('nama', function ($data) {
                // $pasien = Pasien::find($data->pasien_id);
                return @$data->pasien->nama;
            })
            ->addColumn('alamat', function ($data) {
                // $pasien = Pasien::find($data->pasien_id);
                return  @$data->pasien->alamat;
            })
            ->addColumn('poli', function ($data) {
                return baca_poli($data->poli_id);
            })
            ->addColumn('bayar', function ($data) {
                $jkn = !empty($data->tipe_jkn) ? ' - ' . $data->tipe_jkn : '';
                return baca_carabayar($data->bayar) . $jkn;
            })
            // yang ditambah
            ->addColumn('sebabsakit', function ($data) {
                return $data->sebabsakit_nama ? $data->sebabsakit_nama : '';
            })
            ->addColumn('dokter', function ($data) {
                return baca_dokter($data->dokter_id);
            })
            ->addColumn('ubah', function ($data) {
                return '<button type="button" onclick="ubahDpjp(' . $data->regis_id . ')" class="btn btn-primary btn-sm btn-flat">
                                    <i class="fa fa-edit"></i>
                                    </button>';
            })
            ->addColumn('create_sep', function ($data) {
                if ($data->bayar == 1 && $data->no_sep == '') {
                    return '<a href="' . url('frontoffice/supervisor/create_sep/' . $data->regis_id) . '" class="btn btn-success btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>';
                } else {
                    return NULL;
                }
            })
            ->rawColumns(['ubah', 'create_sep'])
            ->make(true);
    }

    public function createSepSusulan($registrasi_id)
    {
        session(['reg_id' => $registrasi_id, 'status' => 'ubahdpjp']);
        return redirect('/form-sep');
    }

    public function dataReg($id)
    {
        $reg = Registrasi::find($id);
        // dd($reg);
        $pasien = [
            'id' => $reg->id,
            'bayar' => $reg->bayar,
            'dokter_id' => $reg->dokter_id,
            'dokter' => HfisDokter::find($id),
            'no_rm' => $reg->pasien->no_rm,
            'nama' => $reg->pasien->nama,
            'alamat' => $reg->pasien->alamat,
            'poli' => @$reg->poli->nama,
            'poli_id' => $reg->poli_id,
            'tipe_jkn' => $reg->tipe_jkn,
        ];
        return response()->json($pasien);
    }

    public function save_ubahdpjp(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request['carabayar'] == 1) {
                $cek = Validator::make($request->all(), [
                    'tipe_jkn' => 'required',
                ]);
                if ($cek->fails()) {
                    return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
                }
            }
            $reg = Registrasi::find($request['id']);
            $reg->dokter_id = $request['dokter_id'];
            $reg->poli_id = $request['poli_id'];
            $reg->ubah_dpjp = 'Y';
            $reg->bayar = $request['carabayar'];

            // if (Auth::user()->hasRole('administrator') || Auth::user()->id == 16) {
            if (!empty($request['tgla'])) {
                $reg->created_at = valid_date($request['tgla']) . ' ' . date('H:i:s');
            }
            // }

            if ($request['carabayar'] == 1) {
                $reg->tipe_jkn = !empty($request['tipe_jkn']) ? $request['tipe_jkn'] : NULL;
            } else {
                $reg->tipe_jkn = NULL;
            }

            $reg->save();

            if (substr($reg->status_reg, 0, 1) == 'J') {
                $hk = HistorikunjunganIRJ::where('registrasi_id', $reg->id)->first();
                // dd($hk);
                $hk->dokter_id = $request['dokter_id'];
                $hk->poli_id = $request['poli_id'];
                $hk->save();
            }

            if (substr($reg->status_reg, 0, 1) == 'G') {
                $pali = Poli::find($request['poli_id']);
                $hk = HistorikunjunganIGD::where('registrasi_id', $reg->id)->first();
                $hk->triage_nama = $pali->nama;
                $hk->save();
            }

            $folio = Folio::where('registrasi_id', $request['id'])
                ->where(function ($q) {
                    $q->where('namatarif', 'like', 'Retribusi%')
                    ->orWhere('namatarif', 'like', 'Sticker%');
                })
                ->get();
            foreach ($folio as $d) {
                $fol = Folio::find($d->id);
                $fol->dokter_id = $request['dokter_id'];
                $fol->dokter_pelaksana = $request['dokter_id'];
                $fol->cara_bayar_id = $request['carabayar'];
                $fol->save();
            }

            DB::commit();

            Flashy::success('DPJP berhasil di Ubah');
            return response()->json(['sukses' => true, 'data' => $reg]);
        } catch (\Exception $e) {
            DB::rollback();
            Flashy::success('DPJP berhasil di Ubah');
            return response()->json(['sukses' => false, 'errors' => 'error ' . $e->getMessage()]);
        }
    }

    //=========================== REKAM MEDIS ============================================
    public function input_diagnosa_rawatjalan()
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        // $keyCache = 'input_diagnosa_irj';
        // $data['reg'] = Cache::get($keyCache);
        // if(!$data['reg']){
        $data['carabayar']  = Carabayar::all();
        $data['crb']        = 0;
        $data['reg'] = Registrasi::with(['pasien', 'poli', 'dokter_umum'])
            ->where('created_at', 'LIKE', date('Y-m-d') . '%')
            ->select([
                'id',
                'pasien_id',
                'poli_id',
                'dokter_id',
                'status_reg',
                'bayar',
                'tipe_jkn',
                'created_at',
            ])
            ->get();
        // Cache::put($keyCache,$data['reg'],120); //BUAT CACHE 2 menit
        // }

        $data['poli'] = Poli::where('politype', 'J')->get();
        return view('frontoffice.input_diagnosa_rawatjalan', $data)->with('no', 1);
    }

    public function input_diagnosa_rawatjalan_byTanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['carabayar']    = Carabayar::all();
        $data['crb']          = $request->cara_bayar;
        $tga = !$request['tga'] ? date('d-m-Y') : $request['tga'];
        $tgb = !$request['tgb'] ? date('d-m-Y') : $request['tgb'];

        $data['reg'] = Registrasi::with(['pasien', 'poli', 'dokter_umum'])
            ->whereBetween('created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
            ->where('registrasis.bayar', ($request->cara_bayar == 0) ? '>' : '=', $request->cara_bayar)
            ->select([
                'id',
                'pasien_id',
                'poli_id',
                'dokter_id',
                'status_reg',
                'bayar',
                'tipe_jkn',
                'created_at',
            ])
            ->get();
        // $data['reg'] = Registrasi::
        // leftJoin('pasiens', 'pasiens.id', 'registrasis.pasien_id')
        // ->where(function ($query) use($request){
        //     $query->where('pasiens.no_rm', $request->no_rm);
        //         // ->orWhere('pasiens.nama', 'LIKE', "%$req->keyword%");
        // })
        // ->select('registrasis.*','registrasis.id as id')
        // ->orderBy('id','DESC')
        // ->limit(5)
        // ->get();

        // $data['poli_id'] = $request['poli_id'];
        // if (!empty($request['poli_id'])) {
        //     $data['reg'] = $data['reg']->where('poli_id', $request['poli_id']);
        // }

        // $data['reg'] = $data['reg']->get();
        $data['poli'] = Poli::where('politype', 'J')->get();
        return view('frontoffice.input_diagnosa_rawatjalan', $data)->with('no', 1);
    }

    public function form_input_diagnosa_rawatjalan($id)
    {
        $data['reg'] = Registrasi::find($id);
        $dokter = Pegawai::find($data['reg']->dokter_id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
        $data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
        $data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
        $data['diagnosaAsesment'] = EmrInapPemeriksaan::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['diagnosaCPPT'] = Emr::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['kondisi_akhirs']    = KondisiAkhirPasienSS::whereIn('type', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang']       = KondisiAkhirPasienSS::whereIn('type', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();

        $d = Registrasi::where('pasien_id', $data['reg']->pasien_id)->get();
        $idregs = [];
        if ($d) {
            foreach ($d as $s) {
                $idregs[] = $s->id;
            }
        }
        $data['perawatanicd9'] = PerawatanIcd9::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        $data['perawatanicd10'] = PerawatanIcd10::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        $data['resume']    = ResumePasien::where('registrasi_id', $id)->first();
        return view('frontoffice.form_input_diagnosa_rawatjalan', $data)->with('no', 1);
    }

    public function simpan_diagnosa_rawatjalan(Request $request)
    {
        $reg = Registrasi::find($request['registrasi_id']);
        DB::transaction(function () use ($request, $reg) {
            //Simpan ke Perawatan icd9
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd9' . $i])) {
                    $icd9 = new PerawatanIcd9();
                    $icd9->icd9 = $request['icd9' . $i];
                    $icd9->kategori = $request['kategoriicd9' . $i];
                    $icd9->registrasi_id = $request['registrasi_id'];
                    $icd9->carabayar_id = $request['cara_bayar'];
                    $icd9->kasus = $request['kasus' . $i];
                    $icd9->jenis = 'TA';
                    if (satusehat() && Satusehat::find(5)->aktif == 1) {
                        $id_condition_ss = SatuSehatController::ProcedurePost($request['registrasi_id'], $request['icd9' . $i]);
                        $icd9->id_procedure_ss =  $id_condition_ss;
                    }
                    $icd9->save();
                }
            }
            //Simpan ke Perawatan icd10
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd10' . $i])) {
                    $icd10 = new PerawatanIcd10();
                    $icd10->icd10 = $request['icd10' . $i];
                    $icd10->kategori = $request['kategoriicd10' . $i];
                    $icd10->registrasi_id = $request['registrasi_id'];
                    $icd10->carabayar_id = $request['cara_bayar'];
                    $icd10->kasus = $request['kasus' . $i];
                    $icd10->jenis = 'TA';
                    if (satusehat() && Satusehat::find(4)->aktif == 1) {
                        $isPrimary = $icd10->kategori == 'Primary' ? true : false;
                        $id_condition_ss = SatuSehatController::ConditionPost($request['registrasi_id'], $request['icd10' . $i], $isPrimary);
                        $icd10->id_condition_ss =  $id_condition_ss;
                    }
                    $icd10->save();
                }
            }


            $reg->posisiberkas_id = $request['posisi_berkas_rm'];
            $reg->kondisi_akhir_pasien = $request['status_kondisi'];
            $reg->pulang = @$request->cara_pulang ?? NULL;

            if (satusehat()) {
                $id_leave_condition_ss = SatuSehatController::ConditionPostPulang(
                    $request['registrasi_id'],
                    @$request->kondisi_akhir
                );

                $id_cara_pulang_ss = SatuSehatController::EncounterPulangPut(
                    $request['registrasi_id'],
                    @$request->cara_pulang,
                );
                $reg->id_pulang_ss = json_encode([
                    'leave_condition'  => [
                        'id_ss' => @$id_leave_condition_ss,
                        'id'    => @$request->kondisi_akhir
                    ],
                    'cara_pulang'      => [
                        'id_ss' => @$id_cara_pulang_ss,
                        'id'    => @$request->cara_pulang
                    ],
                ]);
            }

            // if (Auth::user()->id == 813) {
            //     $reg->is_koding = 1;
            // }

            $reg->update();
        });
        if ($reg->bayar == '1') {
            return redirect('frontoffice/e-claim/bridging/' . $request['registrasi_id']);
        } else {
            return redirect('frontoffice/form_input_diagnosa_rawatjalan/' . $request['registrasi_id']);
        }
    }

    public function input_diagnosa_igd()
    {
        $data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('status_reg', 'LIKE', 'G%')->get();
        $data['poli'] = Poli::where('politype', 'G')->get();
        return view('frontoffice.input_diagnosa_igd', $data)->with('no', 1);
    }

    public function input_diagnosa_igd_byTanggal(Request $request)
    {
        // request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = !$request['tga'] ? date('d-m-Y') : $request['tga'];
        $tgb = !$request['tgb'] ? date('d-m-Y') : $request['tgb'];

        $data['reg'] = Registrasi::whereBetween('created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59']);
        $data['poli_id'] = $request['poli_id'];
        if (!empty($request['poli_id'])) {
            $data['reg'] = $data['reg']->where('poli_id', $request['poli_id']);
        }

        $data['reg'] = $data['reg']->get();
        $data['poli'] = Poli::where('politype', 'G')->get();
        return view('frontoffice.input_diagnosa_igd', $data)->with('no', 1);
    }

    public function form_input_diagnosa_igd($id)
    {
        $data['reg'] = Registrasi::find($id);
        $dokter = Pegawai::find($data['reg']->dokter_id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
        $data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
        $data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
        $data['diagnosaAsesment'] = EmrInapPemeriksaan::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['diagnosaCPPT'] = Emr::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['kondisi_akhirs']    = KondisiAkhirPasienSS::whereIn('type', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang']       = KondisiAkhirPasienSS::whereIn('type', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();
        $d = Registrasi::where('pasien_id', $data['reg']->pasien_id)->get();
        $idregs = [];
        if ($d) {
            foreach ($d as $s) {
                $idregs[] = $s->id;
            }
        }
        $data['perawatanicd9'] = PerawatanIcd9::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        $data['perawatanicd10'] = PerawatanIcd10::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        $data['resume']    = ResumePasien::where('registrasi_id', $id)->first();
        return view('frontoffice.form_input_diagnosa_igd', $data)->with('no', 1);
    }

    public function simpan_diagnosa_igd(Request $request)
    {
        // dd($request);
        DB::transaction(function () use ($request) {
            //Simpan ke Perawatan icd9
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd9' . $i])) {
                    $icd9 = new PerawatanIcd9();
                    $icd9->icd9 = $request['icd9' . $i];
                    $icd9->kategori = $request['kategoriicd9' . $i];
                    $icd9->registrasi_id = $request['registrasi_id'];
                    $icd9->carabayar_id = $request['cara_bayar'];
                    $icd9->kasus = $request['kasus' . $i];
                    $icd9->jenis = 'TG';
                    if (satusehat() && Satusehat::find(5)->aktif == 1) {
                        $id_condition_ss = SatuSehatController::ProcedurePost($request['registrasi_id'], $request['icd9' . $i]);
                        $icd9->id_procedure_ss =  $id_condition_ss;
                    }
                    $icd9->save();
                }
            }
            //Simpan ke Perawatan icd10
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd10' . $i])) {
                    $icd10 = new PerawatanIcd10();
                    $icd10->icd10 = $request['icd10' . $i];
                    $icd10->kategori = $request['kategoriicd10' . $i];
                    $icd10->registrasi_id = $request['registrasi_id'];
                    $icd10->carabayar_id = $request['cara_bayar'];
                    $icd10->kasus = $request['kasus' . $i];
                    $icd10->jenis = 'TG';
                    if (satusehat() && Satusehat::find(4)->aktif == 1) {
                        $isPrimary = $icd10->kategori == 'Primary' ? true : false;
                        $id_condition_ss = SatuSehatController::ConditionPost($request['registrasi_id'], $request['icd10' . $i], $isPrimary);
                        $icd10->id_condition_ss =  $id_condition_ss;
                    }
                    $icd10->save();
                }
            }

            $reg = Registrasi::find($request['registrasi_id']);
            $reg->posisiberkas_id = $request['posisi_berkas_rm'];
            $reg->kondisi_akhir_pasien = $request['status_kondisi'];

            // if (Auth::user()->id == 813) {
            //     $reg->is_koding = 1;
            // }

            $reg->update();
        });
        return redirect('frontoffice/form_input_diagnosa_rawatjalan/' . $request['registrasi_id']);
    }

    public function input_diagnosa_rawatinap()
    {
        $ranap    = Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->with(['pasien', 'registrasi'])
            ->where('rawatinaps.tgl_masuk', 'LIKE', date('Y-m-d') . '%')
            ->select('rawatinaps.id', 'rawatinaps.registrasi_id', 'registrasis.pasien_id', 'rawatinaps.tgl_masuk', 'rawatinaps.kelompokkelas_id', 'rawatinaps.dokter_id')
            ->get();

        $data = [];

        foreach ($ranap as $ranap) {
            $data[] = [
                'idReg' => $ranap->registrasi_id,
                'norm' => $ranap->pasien->no_rm,
                'nama_pasien' => $ranap->pasien->nama,
                'alamat' => $ranap->pasien->alamat,
                'tgl_regis' => @$ranap->registrasi->created_at ? Carbon::parse($ranap->registrasi->created_at)->format('d-m-Y H:i:s') : '',
                'tgl_masuk' => Carbon::parse($ranap->tgl_masuk)->format('d-m-Y H:i:s'),
                'kelompok' => baca_kelompok($ranap->kelompokkelas_id),
                'umur' => hitung_umur($ranap->pasien->tgllahir),
                'dokter' => baca_dokter($ranap->dokter_id)
            ];
        }
        // $data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('status_reg', 'LIKE', 'I%')->get();
        return view('frontoffice.input_diagnosa_rawatinap', ['data' => $data])->with('no', 1);
    }

    public function input_diagnosa_rawatinap_byTanggal(Request $request)
    {
        request()->validate(['tga' => 'required']);
        // $data['reg'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->where('status_reg', 'LIKE', 'I%')->get();
        $ranap    = Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->with(['pasien', 'registrasi'])
            ->whereIn('status_reg', ['I2', 'I3'])
            ->whereBetween('rawatinaps.tgl_masuk', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.pasien_id', '!=', NULL)
            ->select('rawatinaps.id', 'rawatinaps.registrasi_id', 'registrasis.pasien_id', 'rawatinaps.tgl_masuk', 'rawatinaps.kelompokkelas_id', 'rawatinaps.dokter_id')
            ->orderBy('rawatinaps.tgl_masuk', 'ASC')
            ->get();

        $data = [];

        foreach ($ranap as $ranap) {
            $data[] = [
                'idReg' => @$ranap->registrasi_id,
                'norm' => @$ranap->pasien->no_rm,
                'nama_pasien' => @$ranap->pasien->nama,
                'alamat' => @$ranap->pasien->alamat,
                'tgl_regis' => @$ranap->registrasi->created_at ? Carbon::parse(@$ranap->registrasi->created_at)->format('d-m-Y H:i:s') : '',
                'tgl_masuk' => Carbon::parse($ranap->tgl_masuk),
                'kelompok' => baca_kelompok($ranap->kelompokkelas_id),
                'umur' => hitung_umur($ranap->pasien->tgllahir),
                'dokter' => baca_dokter($ranap->dokter_id)
            ];
        }



        // return $data; die;
        return view('frontoffice.input_diagnosa_rawatinap', ['data' => $data])->with('no', 1);
    }

    public function form_input_diagnosa_rawatinap($id)
    {
        $data['reg'] = Registrasi::find($id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
        $data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
        $data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
        $data['kondisi_akhirs']    = KondisiAkhirPasienSS::whereIn('type', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang']       = KondisiAkhirPasienSS::whereIn('type', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();

        $d = Registrasi::where('pasien_id', $data['reg']->pasien_id)->get();
        $idregs = [];
        if ($d) {
            foreach ($d as $s) {
                $idregs[] = $s->id;
            }
        }
        $data['perawatanicd9'] = PerawatanIcd9::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        $data['perawatanicd10'] = PerawatanIcd10::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        $data['resume']    = ResumePasien::where('registrasi_id', $id)->first();
        // return $data; die;

        return view('frontoffice.form_input_diagnosa_rawatinap', $data)->with('no', 1);
    }

    public function simpan_diagnosa_rawatinap(Request $request)
    {
        DB::transaction(function () use ($request) {
            //Simpan ke Perawatan icd9
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd9' . $i])) {
                    $icd9 = new PerawatanIcd9();
                    $icd9->icd9 = $request['icd9' . $i];
                    $icd9->kategori = $request['kategoriicd9' . $i];
                    $icd9->registrasi_id = $request['registrasi_id'];
                    $icd9->carabayar_id = $request['cara_bayar'];
                    $icd9->jenis = 'TI';
                    $icd9->kasus = $request['kasus' . $i];
                    if (satusehat() && Satusehat::find(5)->aktif == 1) {
                        $id_condition_ss = SatuSehatController::ProcedurePost($request['registrasi_id'], $request['icd9' . $i]);
                        $icd9->id_procedure_ss =  $id_condition_ss;
                    }
                    $icd9->save();
                }
            }

            //Simpan ke Perawatan icd10
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd10' . $i])) {
                    $icd10 = new PerawatanIcd10();
                    $icd10->icd10 = $request['icd10' . $i];
                    $icd10->kategori = $request['kategoriicd10' . $i];
                    $icd10->registrasi_id = $request['registrasi_id'];
                    $icd10->carabayar_id = $request['cara_bayar'];
                    $icd10->jenis = 'TI';
                    $icd10->kasus = $request['kasus' . $i];
                    if (satusehat() && Satusehat::find(4)->aktif == 1) {
                        $isPrimary = $icd10->kategori == 'Primary' ? true : false;
                        $id_condition_ss = SatuSehatController::ConditionPost($request['registrasi_id'], $request['icd10' . $i], $isPrimary);
                        $icd10->id_condition_ss =  $id_condition_ss;
                    }
                    $icd10->save();
                }
            }

            $reg = Registrasi::find($request['registrasi_id']);
            $reg->posisiberkas_id = $request['posisi_berkas_rm'];
            $reg->kondisi_akhir_pasien = $request['status_kondisi'];
            if (satusehat()) {
                $id_leave_condition_ss = SatuSehatController::ConditionPostPulang(
                    $request['registrasi_id'],
                    @$request->kondisi_akhir
                );

                $id_cara_pulang_ss = SatuSehatController::EncounterPulangPut(
                    $request['registrasi_id'],
                    @$request->cara_pulang,
                );
                $reg->id_pulang_ss = json_encode([
                    'leave_condition'  => [
                        'id_ss' => @$id_leave_condition_ss,
                        'id'    => @$request->kondisi_akhir
                    ],
                    'cara_pulang'      => [
                        'id_ss' => @$id_cara_pulang_ss,
                        'id'    => @$request->cara_pulang
                    ],
                ]);
            }

            // if (Auth::user()->id == 813) {
            //     $reg->is_koding = 1;
            // }

            $reg->update();
        });
        // return redirect('frontoffice/form_input_diagnosa_rawatinap/' . $request['registrasi_id']);
        return redirect()->back();
    }

    public function bridgingIRNAIDRG($registrasi_id = '') {
		$data['reg'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->where('rawatinaps.registrasi_id', $registrasi_id)->first();
		$data['mapping'] = \App\Mastermapping::skip(0)->take(6)->get();
		$data['mapping1'] = \App\Mastermapping::skip(6)->take(6)->get();
		$data['mapping2'] = \App\Mastermapping::skip(12)->take(6)->get();
		$icd10 = JknIcd10::where('registrasi_id', $registrasi_id)->get();
        $diagns = NULL;
        foreach ($icd10 as $d) {
            $diagns .= $d->icd10 . '#';
        }
        
        $icd9 = JknIcd9::where('registrasi_id', $registrasi_id)->get();
        $proc = NULL;
		foreach ($icd9 as $d) {
			$proc .= $d->icd9 . '#';
		}

		@$data['klaim'] = \App\Inacbg::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		if(@$data['klaim']){
			@$data['hasil_import'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','idrg_to_inacbg_import')->orderBy('id','DESC')->first()->response;
			@$data['table_import_idrg']=json_decode($data['hasil_import'],true);
			@$data['table_import_idrg']=@$data['table_import_idrg']['msg'];

            // VIEW FINAL IDRG
            @$data['hasil_final_idrg'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','grouper1-idrg')->orderBy('id','DESC')->first()->response;
			@$data['table_final_idrg']=json_decode($data['hasil_final_idrg']);
			@$data['table_final_idrg'] = isset($data['table_final_idrg']->msg->response_idrg)
                ? $data['table_final_idrg']->msg->response_idrg
                : @$data['table_final_idrg']->response_idrg;
            
            // VIEW HASIL GROUPING INACBG
                @$data['hasil_grouping_inacbgs'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','grouper')->orderBy('id','DESC')->first()->response;
			@$data['hasil_grouping_inacbg']=json_decode($data['hasil_grouping_inacbgs']);
			@$data['hasil_grouping_inacbg'] = isset($data['hasil_grouping_inacbg']->msg->response_inacbg)
                ? $data['hasil_grouping_inacbg']->msg->response_inacbg
                : @$data['hasil_grouping_inacbg']->response_inacbg;
                
                // HASIL GROUPING_INACBGS_2
                @$data['hasil_grouping_inacbgs_2'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','grouper2')->orderBy('id','DESC')->first()->response;
			@$data['hasil_grouping_inacbg_2']=json_decode($data['hasil_grouping_inacbgs_2']);
			@$data['hasil_grouping_inacbg_2'] = isset($data['hasil_grouping_inacbg_2']->msg->response_inacbg)
                ? $data['hasil_grouping_inacbg_2']->msg->response_inacbg
                : @$data['hasil_grouping_inacbg_2']->response_inacbg;
			// CMG
                @$data['hasil_cmg']=json_decode($data['hasil_grouping_inacbgs']);
                @$data['hasil_cmg'] = isset($data['hasil_cmg']->msg->special_cmg_option)
                ? $data['hasil_cmg']->msg->special_cmg_option
                : @$data['hasil_cmg']->special_cmg_option;


		}

        if (isset($_GET['edit']) && $_GET['edit'] == 1 || $data['klaim']) {
            // $klaim = \App\Inacbg::where('registrasi_id', $registrasi_id)->first();
            $data['diagnosa'] = $data['klaim']->icd1;
            $data['prosedur'] = $data['klaim']->prosedur1;

            $data['diagnosa_inacbg'] = $data['klaim']->icd10_inacbg;
            if(!$data['diagnosa_inacbg']){
                $data['diagnosa_inacbg'] = $data['diagnosa'];
            }
            $data['prosedur_inacbg'] = $data['klaim']->icd9_inacbg;
            if(!$data['prosedur_inacbg']){
                $data['prosedur_inacbg'] = $data['prosedur'];
            }
        } else {
            $data['diagnosa'] = substr($diagns, 0, -1);
            $data['prosedur'] = substr($proc, 0, -1);
        }
		return view('frontoffice.e-claim.bridgingIRNAIDRG', $data)->with('no', 1);
	}

    public function historyDiagnosa($id)
    {
        $pasien = Pasien::find($id);
        $reg = Registrasi::where('pasien_id', $id)->get();

        if ($reg) {
            foreach ($reg as $s) {
                $idregs[] = $s->id;
            }
        }

        $diagnosa = PerawatanIcd10::with('registrasi')->whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        // return $diagnosa; die;

        return view('frontoffice.historyDiagnosa', compact('pasien', 'diagnosa'));
    }

    public function historyProsedur($id)
    {
        $pasien = Pasien::find($id);
        $reg = Registrasi::where('pasien_id', $id)->get();

        if ($reg) {
            foreach ($reg as $s) {
                $idregs[] = $s->id;
            }
        }

        $prosedur = PerawatanIcd9::with('registrasi')->whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        // return $prosedur; die;

        return view('frontoffice.historyProsedur', compact('pasien', 'prosedur'));
    }
    public function ajaxIcd10(Request $request, $kelas = NULL)
    {
        // dd($status_reg);
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }
        // dd($term);


        $tags = Icd10Im::where('description', 'like', '%' . $term . '%')
            ->orWhere('code', 'like', '%' . $term . '%')
            ->orWhere('code2', 'like', '%' . $term . '%')
            ->limit(50)
            ->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id' => $tag->code,
                'text' => @$tag->code . ' | ' . $tag->description
            ];
        }
        return \Response::json($formatted_tags);
    }
    public function ajaxIcd9(Request $request, $kelas = NULL)
    {
        // dd($status_reg);
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }
        // dd($term);


        $tags = Icd9Im::where('description', 'like', '%' . $term . '%')
            ->orWhere('code', 'like', '%' . $term . '%')
            ->orWhere('code2', 'like', '%' . $term . '%')
            ->limit(50)
            ->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id' => $tag->code,
                'text' => @$tag->code . ' | ' . $tag->description
            ];
        }
        return \Response::json($formatted_tags);
    }
    public function jknInputDiagnosaIrj($id)
    {
        $data['reg'] = Registrasi::find($id);
        $dokter = Pegawai::find($data['reg']->dokter_id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
        // $data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
        // $data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
        $data['diagnosaAsesment'] = EmrInapPemeriksaan::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['diagnosaCPPT'] = Emr::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['kondisi_akhirs']    = KondisiAkhirPasienSS::whereIn('type', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang']       = KondisiAkhirPasienSS::whereIn('type', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();

        $d = Registrasi::where('pasien_id', $data['reg']->pasien_id)->get();
        $idregs = [];
        if ($d) {
            foreach ($d as $s) {
                $idregs[] = $s->id;
            }
        }
        // $data['perawatanicd9'] = PerawatanIcd9::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        // $data['perawatanicd10'] = PerawatanIcd10::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        $data['jknIcd9'] = JknIcd9::where('registrasi_id', $data['reg']->id)->get();
        $data['jknIcd10'] = JknIcd10::where('registrasi_id', $data['reg']->id)->get();

        $data['resume']    = ResumePasien::where('registrasi_id', $id)->first();
        return view('frontoffice.form_jkn_input_diagnosa_irj', $data)->with('no', 1);
    }

    public function jknSimpanDiagnosaIrj(Request $request)
    {
        $reg = Registrasi::find($request['registrasi_id']);
        DB::transaction(function () use ($request, $reg) {
            // dd($request->all());
            //Simpan ke Jkn icd9
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd9' . $i])) {
                    $icd9 = new JknIcd9();
                    $icd9->icd9 = $request['icd9' . $i];
                    $icd9->kategori = $request['kategoriicd9' . $i];
                    $icd9->registrasi_id = $request['registrasi_id'];
                    $icd9->carabayar_id = $request['cara_bayar'];
                    $icd9->kasus = $request['kasus' . $i];
                    $icd9->jenis = 'TA';
                    $icd9->save();
                }
            }
            //Simpan ke Jkn icd10
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd10' . $i])) {
                    $icd10 = new JknIcd10();
                    $icd10->icd10 = $request['icd10' . $i];
                    $icd10->kategori = $request['kategoriicd10' . $i];
                    $icd10->registrasi_id = $request['registrasi_id'];
                    $icd10->carabayar_id = $request['cara_bayar'];
                    $icd10->kasus = $request['kasus' . $i];
                    $icd10->jenis = 'TA';
                    $icd10->save();
                }
            }

            $reg->is_koding = 1;
            $reg->update();
        });

        return redirect('frontoffice/e-claim/bridging-idrg/' . $request['registrasi_id']);
        // return redirect('frontoffice/jkn-input-diagnosa-irj/' . $request['registrasi_id']);
    }

    public function jknInputDiagnosaIrna($id)
    {
        $data['reg'] = Registrasi::find($id);
        $dokter = Pegawai::find($data['reg']->dokter_id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
        // $data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
        // $data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
        $data['diagnosaAsesment'] = EmrInapPemeriksaan::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['diagnosaCPPT'] = Emr::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['kondisi_akhirs']    = KondisiAkhirPasienSS::whereIn('type', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang']       = KondisiAkhirPasienSS::whereIn('type', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();

        $d = Registrasi::where('pasien_id', $data['reg']->pasien_id)->get();
        $idregs = [];
        if ($d) {
            foreach ($d as $s) {
                $idregs[] = $s->id;
            }
        }
        // $data['perawatanicd9'] = PerawatanIcd9::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        // $data['perawatanicd10'] = PerawatanIcd10::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        $data['jknIcd9'] = JknIcd9::where('registrasi_id', $data['reg']->id)->get();
        $data['jknIcd10'] = JknIcd10::where('registrasi_id', $data['reg']->id)->get();

        $data['resume']    = ResumePasien::where('registrasi_id', $id)->first();
        return view('frontoffice.form_jkn_input_diagnosa_irna', $data)->with('no', 1);
    }

    public function jknSimpanDiagnosaIrna(Request $request)
    {
        $reg = Registrasi::find($request['registrasi_id']);
        DB::transaction(function () use ($request, $reg) {
            // dd($request->all());
            //Simpan ke Jkn icd9
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd9' . $i])) {
                    $icd9 = new JknIcd9();
                    $icd9->icd9 = $request['icd9' . $i];
                    $icd9->kategori = $request['kategoriicd9' . $i];
                    $icd9->registrasi_id = $request['registrasi_id'];
                    $icd9->carabayar_id = $request['cara_bayar'];
                    $icd9->kasus = $request['kasus' . $i];
                    $icd9->jenis = 'TI';
                    $icd9->save();
                }
            }
            //Simpan ke Jkn icd10
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd10' . $i])) {
                    $icd10 = new JknIcd10();
                    $icd10->icd10 = $request['icd10' . $i];
                    $icd10->kategori = $request['kategoriicd10' . $i];
                    $icd10->registrasi_id = $request['registrasi_id'];
                    $icd10->carabayar_id = $request['cara_bayar'];
                    $icd10->kasus = $request['kasus' . $i];
                    $icd10->jenis = 'TI';
                    $icd10->save();
                }
            }

            $reg->is_koding = 1;
            $reg->update();
        });

        return redirect('frontoffice/e-claim/bridging-irna-idrg/' . $request['registrasi_id']);
        // return redirect('frontoffice/jkn-input-diagnosa-irj/' . $request['registrasi_id']);
    }

    public function jknInputDiagnosaIGD($id)
    {
        $data['reg'] = Registrasi::find($id);
        $dokter = Pegawai::find($data['reg']->dokter_id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
        // $data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
        // $data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
        $data['diagnosaAsesment'] = EmrInapPemeriksaan::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['diagnosaCPPT'] = Emr::where('registrasi_id', $id)->where('user_id', $dokter->user_id)->first();
        $data['kondisi_akhirs']    = KondisiAkhirPasienSS::whereIn('type', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang']       = KondisiAkhirPasienSS::whereIn('type', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();

        $d = Registrasi::where('pasien_id', $data['reg']->pasien_id)->get();
        $idregs = [];
        if ($d) {
            foreach ($d as $s) {
                $idregs[] = $s->id;
            }
        }
        // $data['perawatanicd9'] = PerawatanIcd9::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();
        // $data['perawatanicd10'] = PerawatanIcd10::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        $data['jknIcd9'] = JknIcd9::where('registrasi_id', $data['reg']->id)->get();
        $data['jknIcd10'] = JknIcd10::where('registrasi_id', $data['reg']->id)->get();

        $data['resume']    = ResumePasien::where('registrasi_id', $id)->first();
        return view('frontoffice.form_jkn_input_diagnosa_igd', $data)->with('no', 1);
    }

    public function jknSimpanDiagnosaIGD(Request $request)
    {
        $reg = Registrasi::find($request['registrasi_id']);
        DB::transaction(function () use ($request, $reg) {
            // dd($request->all());
            //Simpan ke Jkn icd9
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd9' . $i])) {
                    $icd9 = new JknIcd9();
                    $icd9->icd9 = $request['icd9' . $i];
                    $icd9->kategori = $request['kategoriicd9' . $i];
                    $icd9->registrasi_id = $request['registrasi_id'];
                    $icd9->carabayar_id = $request['cara_bayar'];
                    $icd9->kasus = $request['kasus' . $i];
                    $icd9->jenis = 'TG';
                    $icd9->save();
                }
            }
            //Simpan ke Jkn icd10
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($request['icd10' . $i])) {
                    $icd10 = new JknIcd10();
                    $icd10->icd10 = $request['icd10' . $i];
                    $icd10->kategori = $request['kategoriicd10' . $i];
                    $icd10->registrasi_id = $request['registrasi_id'];
                    $icd10->carabayar_id = $request['cara_bayar'];
                    $icd10->kasus = $request['kasus' . $i];
                    $icd10->jenis = 'TG';
                    $icd10->save();
                }
            }

            $reg->is_koding = 1;
            $reg->update();
        });

        return redirect('frontoffice/e-claim/bridging-idrg/' . $request['registrasi_id']);
        // return redirect('frontoffice/jkn-input-diagnosa-irj/' . $request['registrasi_id']);
    }

    public function historyDiagnosaJkn($id)
    {
        $pasien = Pasien::find($id);
        $reg = Registrasi::where('pasien_id', $id)->get();

        if ($reg) {
            foreach ($reg as $s) {
                $idregs[] = $s->id;
            }
        }

        $diagnosa = JknIcd10::with('registrasi')->whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        // return $diagnosa; die;

        return view('frontoffice.historyDiagnosaJkn', compact('pasien', 'diagnosa'));
    }

    public function historyProsedurJkn($id)
    {
        $pasien = Pasien::find($id);
        $reg = Registrasi::where('pasien_id', $id)->get();

        if ($reg) {
            foreach ($reg as $s) {
                $idregs[] = $s->id;
            }
        }

        $prosedur = JknIcd9::with('registrasi')->whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->get();

        // return $prosedur; die;

        return view('frontoffice.historyProsedurJkn', compact('pasien', 'prosedur'));
    }

    public function hasilLab($id)
    {
        $regs = Registrasi::where('pasien_id', $id)->get()->pluck('id')->toArray();
        $hasillabs   = Hasillab::whereIn('registrasi_id', $regs)->orderBy('tgl_pemeriksaan', 'DESC')->get();
        return view('frontoffice.hasil-lab', compact('hasillabs'));
    }
    public function hasilRad($id)
    {
        $hasildata['rads']            = RadiologiEkspertise::where('pasien_id', $id)->get();
        return view('frontoffice.hasil-rad', compact('hasilrads'));
    }
    public function hapusDiagnosa($id, $registrasi_id)
    {
        $diagnosa = PerawatanIcd10::find($id);
        $diagnosa->delete();
        $reg = Registrasi::find($registrasi_id);
        if (substr($reg->status_reg, 0, 1) == 'I') {
            return redirect('frontoffice/form_input_diagnosa_rawatinap/' . $registrasi_id);
        } else {
            return redirect('frontoffice/form_input_diagnosa_rawatjalan/' . $registrasi_id);
        }
    }

    public function hapusProsedur($id, $registrasi_id)
    {
        $prosedur = PerawatanIcd9::find($id);
        $prosedur->delete();
        $reg = Registrasi::find($registrasi_id);
        if (substr($reg->status_reg, 0, 1) == 'I') {
            return redirect('frontoffice/form_input_diagnosa_rawatinap/' . $registrasi_id);
        } else {
            return redirect('frontoffice/form_input_diagnosa_rawatjalan/' . $registrasi_id);
        }
    }

    public function hapusDiagnosaJkn($id, $registrasi_id)
    {
        $diagnosa = JknIcd10::find($id);
        $diagnosa->delete();
        $reg = Registrasi::find($registrasi_id);

        Flashy::success('Data Berhasil Dihapus');
        if (substr($reg->status_reg, 0, 1) == 'I') {
            return redirect('frontoffice/jkn-input-diagnosa-irna/' . $registrasi_id);
        } else {
            return redirect('frontoffice/jkn-input-diagnosa-irj/' . $registrasi_id);
        }  
    }

    public function hapusProsedurJkn($id, $registrasi_id)
    {
        $prosedur = JknIcd9::find($id);
        $prosedur->delete();
        $reg = Registrasi::find($registrasi_id);

        Flashy::success('Data Berhasil Dihapus');
        if (substr($reg->status_reg, 0, 1) == 'I') {
            return redirect('frontoffice/jkn-input-diagnosa-irna/' . $registrasi_id);
        } else {
            return redirect('frontoffice/jkn-input-diagnosa-irj/' . $registrasi_id);
        }
    }

    //BRIDGING INACBG ==========================================================
    public function data_rawatJalan()
    {
        $data['reg'] = [];
        // $date = date('Y-m-d');
        // $data['reg'] = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
        //     ->where('registrasis.bayar', 1)
        //     ->whereNotIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
        //     ->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
        //     ->orderBy('registrasis.id', 'desc')
        //     ->select('registrasis.id', 'registrasis.poli_id', 'registrasis.dokter_id', 'registrasis.no_sep', 'registrasis.created_at', 'pasiens.no_rm', 'pasiens.nama')
        //     ->get();
        return view('frontoffice.e-claim.data_rawatJalan', $data);
    }

    public function data_rawatJalan_byTanggal(Request $request)
    {
        $data['reg'] = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where('registrasis.bayar', 1)
            ->whereNotIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
            ->where('pasiens.no_rm', $request['no_rm'])
            ->orderBy('registrasis.id', 'desc')
            ->select('registrasis.id', 'registrasis.poli_id', 'registrasis.dokter_id', 'registrasis.no_sep', 'registrasis.created_at', 'pasiens.no_rm', 'pasiens.nama')
            ->get();
        return view('frontoffice.e-claim.data_rawatJalan', $data);
    }

    public function get_data_rawatJalan()
    {
        $data = Registrasi::where('status_reg', 'like', 'J%')->where('bayar', 1)->orderBy('id', 'desc')->get();
        return DataTables::of($data)
            ->addColumn('no_rm', function ($data) {
                return $data->pasien->no_rm;
            })
            ->addColumn('pasien', function ($data) {
                return $data->pasien->nama;
            })
            ->addColumn('poli', function ($data) {
                return $data->poli->nama;
            })
            ->addColumn('dokter', function ($data) {
                return baca_dokter($data->dokter_id);
            })
            ->addColumn('cara_bayar', function ($data) {
                return baca_carabayar($data->bayar) . ' - ' . $data->tipe_jkn;
            })
            ->addColumn('tgl_registrasi', function ($data) {
                return $data->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('proses', function ($data) {
                return '<a href="' . url('frontoffice/e-claim/bridging/' . $data->id) . '" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-database"></i></a>';
            })
            ->rawColumns(['proses'])
            ->make(true);
    }

    public function data_rawatInap()
    {
        $date = date('Y-m-d');
        $data['irna'] = [];
        // $data['irna'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
        //     ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
        //     ->where('registrasis.status_reg', 'like', 'I%')
        //     ->where('registrasis.bayar', 1)
        //     ->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
        //     // ->where('pasiens.no_rm', $request['no_rm'])
        //     ->select('registrasis.id as registrasi_id', 'registrasis.no_sep', 'pasiens.no_rm', 'pasiens.nama', 'rawatinaps.kamar_id', 'rawatinaps.dokter_id', 'rawatinaps.kelas_id', 'rawatinaps.tgl_keluar', 'rawatinaps.kelompokkelas_id')
        //     ->get();
        return view('frontoffice.e-claim.data_rawatInap', $data)->with('no', 1);
    }

    public function data_rawatInap_byTanggal(Request $request)
    {
        request()->validate(['no_rm' => 'required']);
        $data['irna'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where('registrasis.status_reg', 'like', 'I%')
            ->where('registrasis.bayar', 1)
            ->where('pasiens.no_rm', $request['no_rm'])
            ->select('registrasis.id as registrasi_id', 'registrasis.no_sep', 'pasiens.no_rm', 'pasiens.nama', 'rawatinaps.kamar_id', 'rawatinaps.dokter_id', 'rawatinaps.kelas_id', 'rawatinaps.tgl_keluar', 'rawatinaps.kelompokkelas_id')
            ->get();
        return view('frontoffice.e-claim.data_rawatInap', $data)->with('no', 1);
    }

    public function bridging($registrasi_id = '')
    {
        $data['irna'] = Rawatinap::where('id', $registrasi_id)->first();
        $data['reg'] = Registrasi::where('id', $registrasi_id)->first();
        $data['mapping'] = \App\Mastermapping::skip(0)->take(6)->get();
        $data['mapping1'] = \App\Mastermapping::skip(6)->take(6)->get();
        $data['mapping2'] = \App\Mastermapping::skip(12)->take(6)->get();
        // dd($data['resume']);
        // $icd10 = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
        $icd10 = JknIcd10::where('registrasi_id', $registrasi_id)->get();
        $diagns = NULL;
        foreach ($icd10 as $d) {
            $diagns .= $d->icd10 . '#';
        }
        // $icd9 = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
        $icd9 = JknIcd9::where('registrasi_id', $registrasi_id)->get();
        $proc = NULL;
        foreach ($icd9 as $d) {
            $proc .= $d->icd9 . '#';
        }
        if (isset($_GET['edit']) && $_GET['edit'] == 1) {
            $klaim = \App\Inacbg::where('registrasi_id', $registrasi_id)->first();
            $data['diagnosa'] = $klaim->icd1;
            $data['prosedur'] = $klaim->prosedur1;
        } else {
            $data['diagnosa'] = substr($diagns, 0, -1);
            $data['prosedur'] = substr($proc, 0, -1);
        }

        return view('frontoffice.e-claim.bridging', $data)->with('no', 1);
    }
    public function bridgingIdrg($registrasi_id = '')
    {
        $data['irna'] = Rawatinap::where('id', $registrasi_id)->first();
        $data['reg'] = Registrasi::where('id', $registrasi_id)->first();
        $data['mapping'] = \App\Mastermapping::skip(0)->take(6)->get();
        $data['mapping1'] = \App\Mastermapping::skip(6)->take(6)->get();
        $data['mapping2'] = \App\Mastermapping::skip(12)->take(6)->get();
        // dd($data['resume']);
        // $icd10 = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
        $icd10 = JknIcd10::where('registrasi_id', $registrasi_id)->get();
        $diagns = NULL;
        foreach ($icd10 as $d) {
            $diagns .= $d->icd10 . '#';
        }
        // $icd9 = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
        $icd9 = JknIcd9::where('registrasi_id', $registrasi_id)->get();
        $proc = NULL;
        foreach ($icd9 as $d) {
            $proc .= $d->icd9 . '#';
        }
        @$data['klaim'] = \App\Inacbg::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		if(@$data['klaim']){
			@$data['hasil_import'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','idrg_to_inacbg_import')->orderBy('id','DESC')->first()->response;
			@$data['table_import_idrg']=json_decode($data['hasil_import'],true);
			@$data['table_import_idrg']=@$data['table_import_idrg']['msg'];

            // VIEW FINAL IDRG
            @$data['hasil_final_idrg'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','grouper1-idrg')->orderBy('id','DESC')->first()->response;
			@$data['table_final_idrg']=json_decode($data['hasil_final_idrg']);
			@$data['table_final_idrg'] = isset($data['table_final_idrg']->msg->response_idrg)
                ? $data['table_final_idrg']->msg->response_idrg
                : @$data['table_final_idrg']->response_idrg;
            
            // VIEW HASIL GROUPING INACBG
                @$data['hasil_grouping_inacbgs'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','grouper')->orderBy('id','DESC')->first()->response;
			@$data['hasil_grouping_inacbg']=json_decode($data['hasil_grouping_inacbgs']);
			@$data['hasil_grouping_inacbg'] = isset($data['hasil_grouping_inacbg']->msg->response_inacbg)
                ? $data['hasil_grouping_inacbg']->msg->response_inacbg
                : @$data['hasil_grouping_inacbg']->response_inacbg;
                
                // HASIL GROUPING_INACBGS_2
                @$data['hasil_grouping_inacbgs_2'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','grouper2')->orderBy('id','DESC')->first()->response;
			@$data['hasil_grouping_inacbg_2']=json_decode($data['hasil_grouping_inacbgs_2']);
			@$data['hasil_grouping_inacbg_2'] = isset($data['hasil_grouping_inacbg_2']->msg->response_inacbg)
                ? $data['hasil_grouping_inacbg_2']->msg->response_inacbg
                : @$data['hasil_grouping_inacbg_2']->response_inacbg;
			// CMG
                @$data['hasil_cmg']=json_decode($data['hasil_grouping_inacbgs']);
                @$data['hasil_cmg'] = isset($data['hasil_cmg']->msg->special_cmg_option)
                ? $data['hasil_cmg']->msg->special_cmg_option
                : @$data['hasil_cmg']->special_cmg_option;


		}

        if (isset($_GET['edit']) && $_GET['edit'] == 1 || $data['klaim']) {
            // $klaim = \App\Inacbg::where('registrasi_id', $registrasi_id)->first();
            $data['diagnosa'] = $data['klaim']->icd1;
            $data['prosedur'] = $data['klaim']->prosedur1;

            $data['diagnosa_inacbg'] = $data['klaim']->icd10_inacbg;
            if(!$data['diagnosa_inacbg']){
                $data['diagnosa_inacbg'] = $data['diagnosa'];
            }
            $data['prosedur_inacbg'] = $data['klaim']->icd9_inacbg;
            if(!$data['prosedur_inacbg']){
                $data['prosedur_inacbg'] = $data['prosedur'];
            }
        } else {
            $data['diagnosa'] = substr($diagns, 0, -1);
            $data['prosedur'] = substr($proc, 0, -1);
        }

        return view('frontoffice.e-claim.bridging_idrg', $data)->with('no', 1);
    }

    public function bridgingIRNA($registrasi_id = '')
    {
        $data['reg'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->where('rawatinaps.registrasi_id', $registrasi_id)->first();
        $data['mapping'] = \App\Mastermapping::skip(0)->take(6)->get();
        $data['mapping1'] = \App\Mastermapping::skip(6)->take(6)->get();
        $data['mapping2'] = \App\Mastermapping::skip(12)->take(6)->get();
        // $icd10 = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
        $icd10 = JknIcd10::where('registrasi_id', $registrasi_id)->get();
        $diagns = NULL;
        foreach ($icd10 as $d) {
            $diagns .= $d->icd10 . '#';
        }
        // $icd9 = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
        $icd9 = JknIcd9::where('registrasi_id', $registrasi_id)->get();
        $proc = NULL;
        foreach ($icd9 as $d) {
            $proc .= $d->icd9 . '#';
        }

        @$data['klaim'] = \App\Inacbg::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
        if(@$data['klaim']){
			@$data['hasil_import'] = InacbgLog::where('no_sep',$data['klaim']->no_sep)->where('url','idrg_to_inacbg_import')->orderBy('id','DESC')->first()->response;
			@$data['table_import_idrg']=json_decode($data['hasil_import'],true);
			@$data['table_import_idrg']=@$data['table_import_idrg']['msg'];
			// dd($data['table_import_idrg']);
		}

        if (isset($_GET['edit']) && $_GET['edit'] == 1 || $data['klaim']) {
            // $klaim = \App\Inacbg::where('registrasi_id', $registrasi_id)->first();
            $data['diagnosa'] = $data['klaim']->icd1;
            $data['prosedur'] = $data['klaim']->prosedur1;
        } else {
            $data['diagnosa'] = substr($diagns, 0, -1);
            $data['prosedur'] = substr($proc, 0, -1);
        }
        return view('frontoffice.e-claim.bridgingIRNA', $data)->with('no', 1);
    }

    public static function cetakEklaim($no_sep)
    {
        $data = Inacbg::where('no_sep', $no_sep)->first();
        if ($data != null) {
            $registrasi = Registrasi::find($data->registrasi_id);
            $pdf = PDF::loadView('frontoffice.e-claim.cetakEklaim', compact('data', 'registrasi'));
            return $pdf->stream();
        } else {
            Flashy::info('Cetak E-Klaim Gagal, SEP Ini Belum Dibridging');
            return redirect()->back();
        }
    }

    public static function cetakFull($registrasi_id)
    {
        $registrasi = Registrasi::where('id', $registrasi_id)->first();
        $pasien = Pasien::find($registrasi->pasien_id);
        $tindakan = Folio::where('registrasi_id', $registrasi_id)
            ->where('verif_kasa', 'Y')
            ->whereNotIn('tarif_id', [119, 128, 1015, 1024, 10000, 10001])
            ->get();

        $penjualan = \App\Penjualan::where('registrasi_id', $registrasi_id)->first();
        if ($penjualan) {
            $penjulandetail = \App\Penjualandetail::join('masterobats', 'masterobats.id', '=', 'penjualandetails.masterobat_id')
                ->where('penjualan_id', $penjualan->id)
                ->select('masterobats.nama')
                ->get();
        } else {
            $penjulandetail = [];
        }
        $diagnosa = \App\PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
            ->where('registrasi_id', $registrasi_id)
            ->select('icd10s.nama')
            ->get();
        $prosedur = \App\PerawatanIcd9::join('icd9s', 'perawatan_icd9s.icd9', '=', 'icd9s.nomor')
            ->where('registrasi_id', $registrasi_id)
            ->select('icd9s.nama')
            ->get();
        $folio = Folio::where('registrasi_id', $registrasi_id)->where('verif_kasa', 'Y')->groupBy('tarif_id')
            ->selectRaw('tarif_id, sum(total) as total')
            ->get();
        $jml = Folio::where('registrasi_id', $registrasi_id)->where('verif_kasa', 'Y')->sum('total');
        $doc = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->get();

        $noobat = 1;
        $notindakan = 1;
        $nodiagnosa = 1;
        $noprosedur = 1;
        $nobiaya = 1;
        $pdf = PDF::loadView('frontoffice.e-claim.cetakFull', compact('registrasi', 'penjulandetail', 'tindakan', 'diagnosa', 'prosedur', 'noobat', 'notindakan', 'noprosedur', 'nodiagnosa', 'nobiaya', 'jml', 'folio', 'doc'));
        return $pdf->stream($registrasi->no_sep . '_' . $pasien->nama);
    }
    // OLD
    // public function eklaimDetailTindakan($registrasi_id) {
    // 	$data = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
    // 		->join('mastermapping', 'tarifs.mastermapping_id', '=', 'mastermapping.id')
    // 		->where('folios.registrasi_id', $registrasi_id)
    // 		->orderBy('folios.namatarif')
    // 		->get(['registrasi_id', 'namatarif', 'folios.total', 'mapping']);
    // 	$jumlah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
    // 		->join('mastermapping', 'tarifs.mastermapping_id', '=', 'mastermapping.id')
    // 		->where('folios.registrasi_id', $registrasi_id)
    // 		->orderBy('folios.namatarif')
    // 		->sum('folios.total');
    // 	return response()->json(['data' => $data, 'total' => $jumlah]);
    // }

    // NEW
    public function eklaimDetailTindakan($registrasi_id)
    {
        $data = Folio::with('tarif.mastermapping')
            ->where('registrasi_id', $registrasi_id)
            ->orderBy('namatarif')
            ->get(['registrasi_id', 'namatarif', 'total', 'tarif_id']);
        // return response()->json($data);
        $jumlah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
            // ->join('mastermapping', 'tarifs.mastermapping_id', '=', 'mastermapping.id')
            ->where('folios.registrasi_id', $registrasi_id)
            ->orderBy('folios.namatarif')
            ->sum('folios.total');
        return response()->json(['data' => $data, 'total' => $jumlah]);
    }
    public function eklaimDetailResume($registrasi_id)
    {
        $data = [];
        $query = \App\ResumePasien::where('registrasi_id', $registrasi_id)->get();
        foreach ($query as $q) {
            $data[] = [
                'tekanandarah' => $q->tekanandarah,
                'bb' => $q->bb,
                'diagnosa' => $q->diagnosa,
                'tindakan' => $q->tindakan,
                'keterangan' => baca_carapulang($q->keterangan),
                'created_at' => tanggalkuitansi(date('d-m-Y', strtotime($q->created_at))),
                'cara_bayar' => baca_carabayar($q->carabayar),
            ];
        }
        return response()->json(['data' => $data, 'total' => count($data)]);
    }
    public function eklaimDetailSpri($registrasi_id)
    {

        $data = [];
        $query = \App\SuratInap::where('registrasi_id', $registrasi_id)->get();
        foreach ($query as $q) {
            $data[] = [
                'no_spri' => $q->no_spri,
                'tgl_rencana_kontrol' => date('d-m-Y', strtotime($q->tgl_rencana_kontrol)),
                'diagnosa' => $q->diagnosa,
                'dokter_pengirim' => baca_dokter($q->dokter_pengirim),
                'dokter_rawat' => baca_dokter($q->dokter_rawat),
                'dokter_rawat' => baca_dokter($q->dokter_rawat),
                'cara_bayar' => baca_carabayar($q->carabayar),
                'kamar' => $q->jenis_kamar,
            ];
        }
        // dd($data);
        return response()->json(['data' => $data, 'total' => count($data)]);
    }

    public function eklaimDetailLab($registrasi_id)
    {

        $data = [];
        $query = Orderlab::where(['registrasi_id' => $registrasi_id, 'jenis' => 'TA'])->get();
        // dd($query);
        foreach ($query as $d) {
            $hasil = Hasillab::where('order_lab_id', $d->id)->first();
            $data[] = [
                'url' => $hasil ? @$hasil->registrasi_id . '/' . @$hasil->id : '',
                'pemeriksaan' => $d->pemeriksaan !== null ? $d->pemeriksaan : '-',
                'user' => \App\User::find($d->user_id)->name ? \App\User::find($d->user_id)->name : '-',
                'tgl' => $d->created_at->format('d - m - Y / H:i:s'),
            ];
        }
        // dd($data);
        return response()->json(['data' => $data, 'total' => count($data)]);
    }

    public function eklaimDetailRad($registrasi_id)
    {

        $data = [];
        $query = RadiologiEkspertise::where('registrasi_id', $registrasi_id)->get();
        foreach ($query as $d) {
            $data[] = [
                'pemeriksaan' => $d->uuid !== null ? $d->uuid : '-',
                'user' => \App\User::find($d->user_id)->name ? \App\User::find($d->user_id)->name : '-',
                'tgl' => $d->created_at->format('d - m - Y / H:i:s'),
                'id' => $d->id,
                'registrasi_id' => $d->registrasi_id,
            ];
        }
        // dd($data);
        return response()->json(['data' => $data, 'total' => count($data)]);
    }

    // ==========================================================================================
    public function geticd9data($inacbg=null)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        if($inacbg){
            $icd9 = Icd9::select('nomor as code', 'nama as description')->get();
        }else{
            $icd9 = Icd9Im::all();
        }
        return DataTables::of($icd9)
            ->addColumn('input', function ($icd9) {
                return '<button type="button" class="btn btn-success btn-sm btn-flat insert-prosedure" 
                    data-nama="' . $icd9->description . '" 
                    data-nomor="' . $icd9->code . '" 
                    data-accpdx="' . $icd9->accpdx . '" 
                    ' . ($icd9->validcode == 0 ? 'disabled' : '') . '>
                    <i class="fa fa-check"></i>
                </button>';
            })
            ->rawColumns(['input'])
            ->make(true);
    }
    public function geticd9dataInacbg($inacbg=null)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        if($inacbg){
            $icd9 = Icd9::select('nomor as code', 'nama as description')->get();
        }else{
            $icd9 = Icd9Im::all();
        }
        return DataTables::of($icd9)
            ->addColumn('input', function ($icd9) {
                return '<button type="button" class="btn btn-success btn-sm btn-flat insert-prosedure-inacbg" data-im="' . $icd9->im . '" data-nama="' . $icd9->description . '" data-nomor="' . $icd9->code . '"
                ' . ($icd9->im == 1 ? 'disabled' : '') . '><i class="fa fa-check"></i></button>';
            })
            ->rawColumns(['input'])
            ->make(true);
    }

    public function geticd10data($inacbg=null)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        if($inacbg){
            $icd9 = Icd10::select('nomor as code', 'nama as description')->get();
        }else{
            $icd9 = Icd10Im::all();
        }
        return DataTables::of($icd9)
            ->addColumn('input', function ($icd9) {
                
                return '<button type="button" class="btn btn-success btn-sm btn-flat insert-diagnosa" 
                    data-nama="' . $icd9->description . '" 
                    data-nomor="' . $icd9->code . '" 
                    data-accpdx="' . $icd9->accpdx . '" 
                    ' . ($icd9->validcode == 0 ? 'disabled' : '') . '>
                    <i class="fa fa-check"></i>
                </button>';
            })
            ->rawColumns(['input'])
            ->make(true);
    }
    public function geticd10dataInacbg($inacbg=null)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        
        $icd9 = Icd10Inacbg::all();
        return DataTables::of($icd9)
            ->addColumn('input', function ($icd9) {
                return '<button type="button" class="btn btn-success btn-sm btn-flat insert-diagnosa-inacbg" 
				' . ($icd9->validcode == 0 ? 'disabled' : '') . '
				data-im="' . $icd9->im . '" data-nama="' . $icd9->description . '" data-nomor="' . $icd9->code . '"><i class="fa fa-check"></i></button>';
            })
            ->rawColumns(['input'])
            ->make(true);
    }

    public function datapasien()
    {
        $pasien = Pasien::select(['id', 'no_rm', 'nama', 'kelamin', 'tgllahir', 'alamat'])->orderBy('id', 'desc');
        return DataTables::of($pasien)
            ->addColumn('input', function ($pasien) {
                return '<button type="button" class="btn btn-primary btn-sm btn-flat inputPasien" data-pasien_id="' . $pasien->id . '" data-nama="' . $pasien->nama . '" data-no_rm="' . $pasien->no_rm . '"><i class="fa fa-check"></i></button>';
            })
            ->rawColumns(['input'])
            ->make(true);
    }

    //TRACER
    public function dataFolio($reg_id)
    {
        $reg = Registrasi::find($reg_id);
        $folio = Folio::where('registrasi_id', $reg_id)->select('namatarif', 'total', 'lunas')->get();
        return view('frontoffice.tab.folio', compact('folio', 'reg'));
    }

    public function dataPindahkanTgl($reg_id, $pasien_id)
    {
        // dd("A");
        $keyCache = 'histori_pasien_' . $pasien_id;
        $data['reg'] = Cache::get($keyCache);
        if (!$data['reg']) {
            $data['reg']    = Registrasi::where('pasien_id', $pasien_id)
                ->orderBY('id', 'desc')
                ->get();
            Cache::put($keyCache, $data['reg'], 120); //BUAT CACHE 2 menit
        }

        // dd($data['reg']);
        // $folio = Folio::where('registrasi_id',$reg_id)->select('namatarif','total')->get();
        return view('frontoffice.tab.pindahkantgl', $data);
    }
    public function tracer()
    {
        return view('frontoffice/tracer');
    }

    public function dataTracer($poli_id = '', $tgl = '')
    {
        // if ($poli_id == 0) {
        //     $poli_id = '';
        // }
        // $poli = [];
        // foreach (Poli::all() as $key => $d) {
        //     $poli[] = '' . $d->id . '';
        // }

        // dd($poli_id,$tgl);
        $tanggal = !empty($tgl) ? valid_date($tgl) : '';
        DB::statement(DB::raw('set @nomorbaris=0'));
        $data = Registrasi::select([DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'), 'id', 'pasien_id', 'user_create', 'jenis_pasien', 'dokter_id', 'poli_id', 'bayar', 'tipe_jkn', 'no_loket', 'antrian_poli', 'posisi_tracer', 'user_create', 'posisiberkas_id', 'created_at'])
            ->with(['pasien', 'poli', 'dokter_umum', 'bayars'])
            ->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4'])
            ->where('tracer', '0')
            ->orderBy('id', 'DESC');

        if (!empty($tanggal)) {
            $data = $data->where('created_at', 'like', $tanggal . '%');
        } else {
            $five_day = date("Y-m-d", strtotime("-2 day"));
            $data = $data->where('created_at', '>=', $five_day);
        }
        // dd($five_day);
        // dd($data);
        return DataTables::of($data->get())
            ->addColumn('pasien', function ($data) {
                return @$data->pasien->nama;
            })
            ->addColumn('tgl', function ($data) {
                return date('d-m-Y', strtotime($data->created_at));
            })
            ->addColumn('penginput', function ($data) {
                $user = baca_user(@$data->user_create);
                if (!$user) {
                    $user = 'Checkin Mobile';
                }
                return $user;
            })
            ->addColumn('norm', function ($data) {
                return @$data->pasien->no_rm;
            })
            ->addColumn('poli', function ($data) {
                return @$data->poli->nama;
            })
            ->addColumn('dokter', function ($data) {
                return @$data->dokter_umum->nama;
            })
            ->addColumn('tanggal', function ($data) {
                return date('d-m-y H:i:s', strtotime($data->created_at));
            })
            ->addColumn('bayar', function ($data) {
                if (!empty($data->tipe_jkn)) {
                    return @$data->bayars->carabayar . ' ' . $data->tipe_jkn;
                } else {
                    return @$data->bayars->carabayar;
                }
            })
            ->addColumn('petugas', function ($data) {
                return $data->user_create;
            })
            ->addColumn('cetak', function ($data) {
                return '<a href="/frontoffice/cetak-tracer/' . $data->id . '" class="btn btn-primary btn-xs btn-sm btn-flat" target="_blank"><i class="fa fa-print">  </i></a>';
            })
            ->addColumn('proses', function ($data) {
                // return "A";
                $confirm = "return confirm('Yakin akan kirim berkas?')";
                $cancel = "return confirm('Yakin akan batalkan berkas?')";
                $terima = "return confirm('Yakin akan batalkan berkas?')";
                if ($data->posisi_tracer == '0' || $data->posisi_tracer == NULL) {
                    return '<a onclick="' . $confirm . '" href="/frontoffice/set-tracer/' . $data->id . '/1" class="btn btn-success btn-xs btn-flat"><i class="fa fa-solid fa-arrow-up"></i> Kirim</a>';
                } elseif ($data->posisi_tracer == '1') {
                    return '<a onclick="' . $cancel . '" href="/frontoffice/set-tracer/' . $data->id . '/-1" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-close"></i> Batal</a>&nbsp;
					<a onclick="' . $terima . '" href="/frontoffice/set-tracer/' . $data->id . '/2" class="btn btn-info btn-xs btn-flat"><i class="fa fa-solid fa-arrow-down"></i> Terima</a>';
                } else {
                    return '<i class="fa fa-check"></i> Selesai';
                }
            })
            ->rawColumns(['cetak', 'proses'])
            ->make(true);
    }

    public function setTracer($registrasi_id, $tracer)
    {
        $data = Registrasi::find($registrasi_id);
        if ($tracer == '1') {
            $data->posisi_tracer = '1';
            // $data->tracer = '1';
        } elseif ($tracer == '-1') {
            $data->posisi_tracer = '-1';
            // $data->tracer = '0';
        } elseif ($tracer == '2') {
            $data->posisi_tracer = '2';
            $data->tracer_kembali_tanggal = date('Y-m-d');
            // $data->tracer = '1';
        }
        $data->save();
        Flashy::info('Tracer Berhasil diupdate');
        return redirect()->back();
    }

    public function cetakTracer($registrasi_id)
    {
        $data = Registrasi::find($registrasi_id);
        return view('frontoffice.cetakTracer', compact('data'));
    }

    //TRACER ALL
    public function tracerAll()
    {
        $data = Registrasi::whereIn('status_reg', ['J1', 'J2', 'J3', 'J4', 'G1', 'G2', 'G3', 'G4'])
            // ->orWhere('status_reg', 'like', 'G%')
            ->where('tracer', '0')
            ->where('status', 'lama')->where('created_at', 'like', date('Y-m-d') . '%')->take(1)->get();
        // dd($data);
        return view('frontoffice.tracerAll', compact('data'))->with('no', 1);
    }

    public function cetakTracerAll()
    {
        $dataAll = Registrasi::where('tracer', '0')
            ->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4', 'G1', 'G2', 'G3', 'G4'])
            ->where('status', 'lama')->where('created_at', 'like', date('Y-m-d') . '%')->take(1)->get();
        return view('frontoffice.cetakTracerAll', compact('dataAll'));
    }

    public function settingKuotaPoli()
    {
        $poli = Poli::whereIn('politype', ['J', 'M'])->get();
        return view('frontoffice.settingKuotaPoli', compact('poli'))->with('no', 1);
    }

    public function getPoli($id)
    {
        $poli = Poli::find($id);
        return response()->json($poli);
    }

    public function saveKuotaPoli(Request $request)
    {
        $poli = Poli::find($request->id);
        $poli->kuota = $request['kuota'];
        // $poli->kuota_online = $request['kuota_online'];
        $poli->loket = $request['loket'];
        $poli->buka = $request['buka'];
        $poli->tutup = $request['tutup'];
        $poli->kode_loket = $request['bagian'];
        $poli->monday = $request['senin'];
        $poli->tuesday = $request['selasa'];
        $poli->wednesday = $request['rabu'];
        $poli->thursday = $request['kamis'];
        $poli->friday = $request['jumat'];
        $poli->saturday = $request['sabtu'];
        $poli->jkn_monday = $request['jkn_senin'];
        $poli->jkn_tuesday = $request['jkn_selasa'];
        $poli->jkn_wednesday = $request['jkn_rabu'];
        $poli->jkn_thursday = $request['jkn_kamis'];
        $poli->jkn_friday = $request['jkn_jumat'];
        $poli->jkn_saturday = $request['jkn_sabtu'];
        $poli->update();
        return response()->json(['sukses' => true]);
    }

    public function saveEditPraktik(Request $request)
    {
        $poli = Poli::find($request->id);
        $poli->praktik = $request['praktik'];
        $poli->update();
        return response()->json(['sukses' => true]);
    }

    public function tutupPraktik($id)
    {
        $poli = Poli::find($id);
        $poli->praktik = 'T';
        $poli->update();
        Flashy::info('Praktik ' . strtoupper($poli->nama) . ' Berhasil di Tutup.');
        return redirect()->route('setting-poli');
    }

    public function bukaPraktik($id)
    {
        $poli = Poli::find($id);
        $poli->praktik = 'Y';
        $poli->update();
        Flashy::info('Praktik ' . strtoupper($poli->nama) . ' Berhasil di Buka.');
        return redirect()->route('setting-poli');
    }

    public function settingKuotaDokter()
    {
        $dokter = Pegawai::where('kategori_pegawai', 1)->get();
        return view('frontoffice.settingKuotaDokter', compact('dokter'))->with('no', 1);
    }

    public function getDokters($id)
    {
        $dokter = Pegawai::with('kd')->find($id);
        return response()->json($dokter);
    }

    public function saveKuotaDokter(Request $request)
    {
        $kuota = KuotaDokter::updateOrCreate(
            ['pegawai_id' => $request->id],
            [
                'kuota'        => $request['kuota'],
                'loket'        => $request['loket'],
                'buka'         => $request['buka'],
                'tutup'        => $request['tutup'],
                'kode_loket'   => $request['bagian'],
                'monday'       => $request['senin'],
                'tuesday'      => $request['selasa'],
                'wednesday'    => $request['rabu'],
                'thursday'     => $request['kamis'],
                'friday'       => $request['jumat'],
                'saturday'     => $request['sabtu'],
                'sunday'       => $request['minggu'] ?? 0,
                'jkn_monday'   => $request['jkn_senin'],
                'jkn_tuesday'  => $request['jkn_selasa'],
                'jkn_wednesday'=> $request['jkn_rabu'],
                'jkn_thursday' => $request['jkn_kamis'],
                'jkn_friday'   => $request['jkn_jumat'],
                'jkn_saturday' => $request['jkn_sabtu'],
                'jkn_sunday'   => $request['jkn_minggu'] ?? 0,
            ]
        );

        return response()->json(['sukses' => true]);
    }

    public function saveEditPraktikDokter(Request $request)
    {
        $dokter = KuotaDokter::find($request->id);
        $dokter->praktik = $request['praktik'];
        $dokter->update();
        return response()->json(['sukses' => true]);
    }

    public function tutupPraktikDokter($id)
    {
        $dokter = KuotaDokter::find($id);
        $dokter->praktik = 'T';
        $dokter->update();
        Flashy::info('Praktik ' . strtoupper($dokter->nama) . ' Berhasil di Tutup.');
        return redirect()->route('setting-dokter');
    }

    public function bukaPraktikDokter($id)
    {
        $dokter = KuotaDokter::find($id);
        $dokter->praktik = 'Y';
        $dokter->update();
        Flashy::info('Praktik ' . strtoupper($dokter->nama) . ' Berhasil di Buka.');
        return redirect()->route('setting-dokter');
    }

    public function outgate()
    {
        return view('frontoffice.outgate');
    }

    public function outgateViewData(Request $request)
    {
        //return $request['no_rm']; die;
        request()->validate(['no_rm' => 'required']);
        $data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
            ->where('pasiens.no_rm', $request['no_rm'])
            ->select('pasiens.*', 'registrasis.id as regID', 'registrasis.poli_id')->first();
        if ($data) {
            $reg = Registrasi::find($data->regID);
            $reg->posisiberkas_id = 1;
            $reg->update();
        }

        return view('frontoffice.outgate', compact('data'));
    }

    public function inguide()
    {
        return view('frontoffice.inguide');
    }

    public function inguideViewData(Request $request)
    {
        //return $request['no_rm']; die;
        request()->validate(['no_rm' => 'required']);
        $data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
            ->where('pasiens.no_rm', $request['no_rm'])
            ->select('pasiens.*', 'registrasis.id as regID', 'registrasis.poli_id')->first();
        $reg = Registrasi::find($data->regID);
        $reg->posisiberkas_id = 2;
        $reg->update();
        return view('frontoffice.inguide', compact('data'));
    }

    public function dataSJP()
    {
        $data['sep'] = Registrasi::whereNotNull('no_sep')
            ->where('cetak_sep', '0')
            ->where('status_reg', 'like', 'J%')
            ->whereIN('no_loket', [1, 2])
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->take(1)
            ->orderBY('id', 'asc')
            ->get(['id', 'pasien_id', 'no_sep', 'poli_id', 'dokter_id']);
        return view('frontoffice.dataSJP', $data);
    }

    public function cetakSJP($unit, $id_reg)
    {
        // dd($id_reg);
        $data['reg'] = Registrasi::where('id', $id_reg)
            // ->whereIN('no_loket', [1,2])
            // ->where('created_at', 'like', date('Y-m-d') . '%')
            // ->take(1)
            // ->orderBY('id', 'asc')
            ->first();
        $data['unit'] = $unit;
        // dd($data['reg']);
        $pdf = PDF::loadView('frontoffice.cetakSJP', $data);
        return $pdf->stream();
        // return view('frontoffice/cetakSJP', $data);
    }
    public function dataSEP()
    {
        $data['sep'] = Registrasi::whereNotNull('no_sep')
            ->where('cetak_sep', '0')
            ->where('status_reg', 'like', 'J%')
            ->whereIN('no_loket', [1, 2])
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->take(1)
            ->orderBY('id', 'asc')
            ->get(['id', 'pasien_id', 'no_sep', 'poli_id', 'dokter_id']);
        return view('frontoffice.dataSEP', $data);
    }

    public function cetakSEP()
    {
        $data['reg'] = Registrasi::whereNotNull('no_sep')
            ->where('cetak_sep', '0')
            ->where('status_reg', 'like', 'J%')
            // ->whereIN('no_loket', [1,2])
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->take(1)
            ->orderBY('id', 'asc')
            ->first();
        return view('frontoffice/cetakSEP', $data);
    }

    public function dataSEP2()
    {
        $data['sep'] = Registrasi::whereNotNull('no_sep')
            ->where('cetak_sep', '0')
            ->where('status_reg', 'like', 'J%')
            // ->whereIN('no_loket', [3,4])
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->take(1)
            ->orderBY('id', 'asc')
            ->get(['id', 'pasien_id', 'no_sep', 'poli_id', 'dokter_id']);
        return view('frontoffice.dataSEP2', $data);
    }

    public function cetakSEP2()
    {
        $data['reg'] = Registrasi::whereNotNull('no_sep')
            ->where('cetak_sep', '0')
            ->where('status_reg', 'like', 'J%')
            ->whereIN('no_loket', [3, 4])
            ->where('created_at', 'like', date('Y-m-d') . '%')
            ->take(1)
            ->orderBY('id', 'asc')
            ->first();
        return view('frontoffice/cetakSEP2', $data);
    }

    public static function historiPasien($pasien_id)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        $data['pasien'] = Pasien::find($pasien_id);
        $data['norm']   = $data['pasien']->no_rm;
        $expired = Carbon::now()->addMinutes(1);
        // $keyCache = 'histori_pasien_'.$pasien_id;
        // $data['reg'] = Cache::get($keyCache);
        // if(!$data['reg']){
        $data['reg']    = Registrasi::with(['poli', 'bayars', 'dokter_umum', 'rawat_inap'])
            ->where('pasien_id', $pasien_id)
            ->withTrashed()
            ->orderBY('id', 'desc')
            ->select([
                'id',
                'pasien_id',
                'dokter_id',
                'poli_id',
                'bayar',
                'status_reg',
                'tracer_kembali_tanggal',
                'kasus',
                'user_create',
                'created_at',
                'deleted_at',
            ])
            ->get();
        //     Cache::put($keyCache,$data['reg'],120); //BUAT CACHE 2 menit
        // }

        return view('frontoffice.historiPasien', $data)->with('no', 1);
    }

    public function totalTagihan($reg_id)
    {
        $total_tagihan = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->sum('total');
        $tagihan_lunas = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->where('lunas', 'Y')->sum('total');
        $sisa_tagihan = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->sum('total');
        return response()->json((object) [
            'total_tagihan' => $total_tagihan,
            'tagihan_lunas' => $tagihan_lunas,
            'sisa_tagihan' => $sisa_tagihan,
            'lunas' => $sisa_tagihan == 0 ? true : false,
        ]);
    }

    public static function historiPasienRM($pasien_id)
    {
        $data['pasien'] = Pasien::find($pasien_id);
        $data['reg'] = Registrasi::where('pasien_id', $pasien_id)->orderBY('id', 'desc')->get();
        return view('frontoffice.history-pasien-rm', $data)->with('no', 1);
    }
    public static function pindahTindakanPasien(Request $request)
    {
        // dd($request->all());
        $fol = Folio::where('registrasi_id', $request->regis_old)->get();
        $regis = Registrasi::where('id', $request->regis_old)->first();
        // dd($fol);
        if ($regis) {
            $regis->kodeasal = Auth::user()->name . '_' . $request->regis_new;
            $regis->save();
        }
        foreach ($fol as $f) {
            $f = Folio::where('id', $f->id)->first();
            $f->registrasi_id = $request->regis_new;
            $f->verif_rj_user = Auth::user()->name;
            $f->pembatal = $request->regis_old;
            $f->save();
        }
        Flashy::success('Tarif Berhasil Dipindahkan');
        return redirect()->back();
        // $
    }
    public static function historiPasienByRequest(Request $request)
    {
        $data['pasien'] = Pasien::where('no_rm', 'LIKE', '%' . $request['no_rm'] . '%')->orWhere('no_rm_lama', 'LIKE', '%' . $request['no_rm'] . '%')->first();
        if ($data['pasien']) {
            $data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->orderBY('id', 'desc')->get();
        }
        return view('frontoffice.historiPasien', $data)->with('no', 1);
    }

    public static function getDataRegistrasi($registrasi_id)
    {
        $reg = Registrasi::find($registrasi_id);
        if (substr($reg->status_reg, 0, 1) == 'G') {
            $status = 'Rawat Darurat';
        } elseif (substr($reg->status_reg, 0, 1) == 'J') {
            $status = 'Rawat Jalan';
        } elseif ($reg->status_reg = 'I1') {
            $status = 'Admisi';
        } elseif ($reg->status_reg = 'I2') {
            $status = 'Rawat Inap';
        } elseif ($reg->status_reg = 'I3') {
            $status = 'Sudah di pulangkan';
        }
        return response()->json(['status_reg' => $status, 'registrasi_id' => $reg->id]);
    }

    public static function ubahStatusPelayanan(Request $request)
    {
        DB::beginTransaction();
        try {
            $reg = Registrasi::find($request['registrasi_id']);
            $reg->status_reg = $request['status_reg'];
            if ($request->tgl_registrasi !== null) { // update tgl registrasi
                $reg->created_at = Carbon::parse($request->tgl_registrasi)->format('Y-m-d ') . ' ' . date('H:i:s');
            }
            // dd($reg);
            if ($request->status_reg == 'I3') { // update tgl masuk / keluar @pulangkan
                $ri = Rawatinap::where('registrasi_id', $reg->id)->first();
                if ($ri == null) {
                    return response()->json(['error' => 'Data Pasien Tidak ada'], 404);
                }
                if ($request->tgl_masuk_inap !== null && $request->tgl_keluar_inap !== null) {
                    $ri->tgl_masuk = Carbon::parse($request->tgl_masuk_inap)->format('Y-m-d ') . ' ' . date('H:i:s');
                    $ri->tgl_keluar = Carbon::parse($request->tgl_keluar_inap)->format('Y-m-d ') . ' ' . date('H:i:s');
                    $ri->updated_at = Carbon::now();
                    $ri->save();
                } elseif ($request->tgl_masuk_inap !== null) {
                    $ri->tgl_masuk = Carbon::parse($request->tgl_masuk_inap)->format('Y-m-d ') . ' ' . date('H:i:s');
                    $ri->updated_at = Carbon::now();
                    $ri->save();
                } elseif ($request->tgl_keluar_inap !== null) {
                    $ri->tgl_keluar = Carbon::parse($request->tgl_keluar_inap)->format('Y-m-d ') . ' ' . date('H:i:s');
                    $ri->updated_at = Carbon::now();
                    $ri->save();
                }
            } elseif ($request->status_reg == 'I2') { // update tgl masuk / keluar @rawatinap
                $ri = Rawatinap::where('registrasi_id', $reg->id)->first();
                $ri->tgl_keluar = NULL;
                if ($request->tgl_masuk_inap !== null) {
                    $ri->tgl_masuk = Carbon::parse($request->tgl_masuk_inap)->format('Y-m-d ') . ' ' . date('H:i:s');
                    $ri->updated_at = Carbon::now();
                    $ri->save();
                }
            }
            $reg->save();
            $pasien = Pasien::find($reg->pasien_id);
            Cache::forget('histori_pasien_' . $pasien->id);
            DB::commit();
            Flashy::success('Status Pelayanan Berhasil di Ubah');
            return response()->json(['sukses' => true, 'pasien_id' => $pasien->id]);
        } catch (Exception $e) {
            DB::rollback();
            Flashy::error('Terjasi Kesalahan ' . $e->getMessage());
            return response()->json(['sukses' => false]);
        }
    }

    public function setCarabayar()
    {
        $folio = Folio::whereNull('cara_bayar_id')->take(3000)->get();
        $jml = [];
        foreach ($folio as $d) {
            $fol = Folio::find($d->id);
            $fol->cara_bayar_id = Registrasi::find($d->registrasi_id)->bayar;
            $fol->timestamps = false;
            $fol->update();
            array_push($jml, $fol->id);
        }
        $hasil = Folio::whereIn('id', $jml)->count();
        $sisa = Folio::whereNull('cara_bayar_id')->count();
        return $hasil . ' data berhasil di set cara bayar id <br />' . $sisa . ' cara bayar masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-cara-bayar">';
    }

    public function setBangsalFolio()
    {
        $folio = Folio::whereNull('kelompokkelas_id')->where('jenis', 'TI')->take(3000)->get();
        $jml = [];
        foreach ($folio as $d) {
            $fol = Folio::find($d->id);
            $fol->kelompokkelas_id = !empty(Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()) ? Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()->kelompokkelas_id : NULL;
            $fol->kamar_id = !empty(Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()) ? Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()->kamar_id : NULL;
            $fol->timestamps = false;
            $fol->update();
            array_push($jml, $fol->id);
        }
        $hasil = Folio::whereIn('id', $jml)->count();
        $sisa = Folio::whereNull('kelompokkelas_id')->where('jenis', 'TI')->count();
        return $hasil . ' data berhasil di set cara bangsal dan kamar <br />' . $sisa . ' bangsal masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-bangsal-folio">';
    }

    public function setJenisPerawatanIcd9()
    {
        $icd9 = PerawatanIcd9::whereNull('jenis')->take(1000)->get();
        $jml = [];
        foreach ($icd9 as $d) {
            $reg = Registrasi::find($d->registrasi_id)->status_reg;
            if (substr($reg, 0, 1) == 'I') {
                $jenis = 'TI';
            } elseif (substr($reg, 0, 1) == 'G') {
                $jenis = 'TG';
            } elseif (substr($reg, 0, 1) == 'J') {
                $jenis = 'TA';
            }
            $data = PerawatanIcd9::find($d->id);
            $data->jenis = $jenis;
            $data->timestamps = false;
            $data->update();
            array_push($jml, $data->id);
        }
        $hasil = PerawatanIcd9::whereIn('id', $jml)->count();
        $sisa = PerawatanIcd9::whereNull('jenis')->count();
        return $hasil . ' data berhasil di set jenis perawatan <br />' . $sisa . ' jenis perawatan masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-jenis-icd9">';
    }

    public function setJenisPerawatanIcd10()
    {
        $icd10 = PerawatanIcd10::whereNull('jenis')->take(1000)->get();
        $jml = [];
        foreach ($icd10 as $d) {
            $reg = Registrasi::find($d->registrasi_id)->status_reg;
            if (substr($reg, 0, 1) == 'I') {
                $jenis = 'TI';
            } elseif (substr($reg, 0, 1) == 'G') {
                $jenis = 'TG';
            } elseif (substr($reg, 0, 1) == 'J') {
                $jenis = 'TA';
            }
            $data = PerawatanIcd10::find($d->id);
            $data->jenis = $jenis;
            $data->timestamps = false;
            $data->update();
            array_push($jml, $data->id);
        }
        $hasil = PerawatanIcd10::whereIn('id', $jml)->count();
        $sisa = PerawatanIcd10::whereNull('jenis')->count();
        return $hasil . ' data berhasil di set jenis perawatan <br />' . $sisa . ' jenis perawatan masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-jenis-icd10">';
    }

    public function setMappingBiaya()
    {
        $folio = Folio::whereNull('mapping_biaya_id')->take(3000)->get();
        $jml = [];
        foreach ($folio as $d) {
            $fol = Folio::find($d->id);
            $fol->mapping_biaya_id = ($fol->tarif_id != 0) ? Tarif::find($fol->tarif_id)->mapping_biaya_id : NULL;
            $fol->timestamps = false;
            $fol->update();
            array_push($jml, $fol->id);
        }
        $hasil = Folio::whereIn('id', $jml)->count();
        $sisa = Folio::whereNull('mapping_biaya_id')->count();
        return $hasil . ' data berhasil di set mapping biaya <br />' . $sisa . ' mapping biaya masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-mapping-biaya">';
    }

    function getRM()
    {
        $pasien = Pasien::select([
            'id',
            'no_rm',
            'nama',
            'alamat',
        ])->whereNotNull('no_rm')->orderBy('id', 'asc');

        return DataTables::of($pasien)
            ->addColumn('edit', function ($pasien) {
                return '<input type="checkbox" name="pasienID[]" value="' . $pasien->id . '">';
            })
            ->rawColumns(['edit'])
            ->make(true);
    }

    function saveMergeRM(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'rmUtama' => 'required',
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        }

        // INI ARRAY PASIEN YANG AKAN DI MERGE KE PASIEN UTAMA
        $idpasien = $request['pasienID'];

        // ID PASIEN UTAMA 
        $idUtama = Pasien::where('no_rm', $request['rmUtama'])->first()->id;

        if (!empty($idpasien)) {
            foreach ($idpasien as $d) {
                if ($d != $idUtama) {
                    $reg = Registrasi::where('pasien_id', $d)->first();
                    $reg->pasien_id = $idUtama;
                    $reg->update();
                    
                    // UPDATE SEMUA EMR
                    $update_cppt = Emr::where('pasien_id', $d)->update([
                        'pasien_id' => $idUtama
                    ]);
                    $update_gizi = EmrGizi::where('pasien_id', $d)->update([
                        'pasien_id' => $idUtama
                    ]);

                    $update_pemeriksaan = EmrInapPemeriksaan::where('pasien_id', $d)->update([
                        'pasien_id' => $idUtama
                    ]);

                    $update_perencanaan = EmrInapPerencanaan::where('pasien_id', $d)->update([
                        'pasien_id' => $idUtama
                    ]);
                    
                    $update_folio = Folio::where('pasien_id', $d)->update([
                        'pasien_id' => $idUtama
                    ]);
                }
            }
        }
        Flashy::success('RM berhasil di gabungkan ke RM utama ' . $request['rmUtama']);
        return response()->json(['sukses' => true]);
    }

    //UPLOAD DOKUMENT REKAMMEDIS
    public function uploadDokument($registrasi_id)
    {
        $reg = Registrasi::find($registrasi_id);
        $pasien = Pasien::find($reg->pasien_id);
        $doc = \App\DokumenRekamMedis::where('registrasi_id', $registrasi_id)->first();
        return view('frontoffice.uploadDokumen', compact('reg', 'pasien', 'doc'));
    }

    public function saveDocument(Request $request)
    {
        $dokument = \App\DokumenRekamMedis::where('registrasi_id', $request['registrasi_id'])->first();

        //Radiologi
        if (!empty($request->file('radiologi'))) {
            if (!empty($dokument->radiologi)) {
                unlink('dokumen_rekammedis/' . $dokument->radiologi);
            }
            $radiologi = 'RM_' . $request['registrasi_id'] . '_radiologi_' . $request->file('radiologi')->getClientOriginalName();
            $request->file('radiologi')->move('dokumen_rekammedis/', $radiologi);
        } else {
            $radiologi = $dokument ? $dokument->radiologi : NULL;
        }
        //Lab
        if (!empty($request->file('lab'))) {
            if (!empty($dokument->laboratorium)) {
                unlink('dokumen_rekammedis/' . $dokument->laboratorium);
            }
            $lab = 'RM_' . $request['registrasi_id'] . '_lab_' . $request->file('lab')->getClientOriginalName();
            $request->file('lab')->move('dokumen_rekammedis/', $lab);
        } else {
            $lab = $dokument ? $dokument->laboratorium : NULL;
        }
        //Resum
        if (!empty($request->file('resum'))) {
            if (!empty($dokument->resummedis)) {
                unlink('dokumen_rekammedis/' . $dokument->resummedis);
            }
            $resum = 'RM_' . $request['registrasi_id'] . '_resum_' . $request->file('resum')->getClientOriginalName();
            $request->file('resum')->move('dokumen_rekammedis/', $resum);
        } else {
            $resum = $dokument ? $dokument->resummedis : NULL;
        }
        //Operasi
        if (!empty($request->file('operasi'))) {
            if (!empty($dokument->operasi)) {
                unlink('dokumen_rekammedis/' . $dokument->operasi);
            }
            $operasi = 'RM_' . $request['registrasi_id'] . '_operasi_' . $request->file('operasi')->getClientOriginalName();
            $request->file('operasi')->move('dokumen_rekammedis/', $operasi);
        } else {
            $operasi = $dokument ? $dokument->operasi : NULL;
        }
        //pathway
        if (!empty($request->file('pathway'))) {
            if (!empty($dokument->pathway)) {
                unlink('dokumen_rekammedis/' . $dokument->pathway);
            }
            $pathway = 'RM_' . $request['registrasi_id'] . '_pathway_' . $request->file('pathway')->getClientOriginalName();
            $request->file('pathway')->move('dokumen_rekammedis/', $pathway);
        } else {
            $pathway = $dokument ? $dokument->pathway : NULL;
        }
        //EKG
        if (!empty($request->file('ekg'))) {
            if (!empty($dokument->ekg)) {
                unlink('dokumen_rekammedis/' . $dokument->ekg);
            }
            $ekg = 'RM_' . $request['registrasi_id'] . '_ekg_' . $request->file('ekg')->getClientOriginalName();
            $request->file('ekg')->move('dokumen_rekammedis/', $ekg);
        } else {
            $ekg = $dokument ? $dokument->ekg : NULL;
        }
        //Echocardiograms
        if (!empty($request->file('echo'))) {
            if (!empty($dokument->echo)) {
                unlink('dokumen_rekammedis/' . $dokument->echo);
            }
            $echo = 'RM_' . $request['registrasi_id'] . '_echo_' . $request->file('echo')->getClientOriginalName();
            $request->file('echo')->move('dokumen_rekammedis/', $echo);
        } else {
            $echo = $dokument ? $dokument->echo : NULL;
        }

        if ($dokument) {
            $doc = \App\DokumenRekamMedis::where('registrasi_id', $request['registrasi_id'])->first();
        } else {
            $doc = new \App\DokumenRekamMedis();
        }
        $doc->registrasi_id = $request['registrasi_id'];
        $doc->pasien_id = $request['pasien_id'];
        $doc->radiologi = $radiologi;
        $doc->resummedis = $resum;
        $doc->operasi = $operasi;
        $doc->laboratorium = $lab;
        $doc->pathway = $pathway;
        $doc->ekg = $ekg;
        $doc->echo = $echo;
        $doc->user = Auth::user()->name;
        if ($dokument) {
            $doc->update();
        } else {
            $doc->save();
        }
        Flashy::success('Dokument berhasil disimpan.');
        return redirect('/frontoffice/uploadDokument/' . $request['registrasi_id']);
    }

    public function viewDokumen($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        $pdflaboratorium = substr($data->laboratorium, -3);
        $pdfradiologi = substr($data->radiologi, -3);
        $pdfresummedis = substr($data->resummedis, -3);
        $pdfoperasi = substr($data->operasi, -3);
        $pdfekg = substr($data->ekg, -3);
        $pdfpathway = substr($data->pathway, -3);
        $pdfecho = substr($data->echo, -3);
        return response()->json(['data' => $data, 'pdfradiologi' => $pdfradiologi, 'pdfresummedis' => $pdfresummedis, 'pdfoperasi' => $pdfoperasi, 'pdflaboratorium' => $pdflaboratorium, 'pdfpathway' => $pdfpathway, 'pdfecho' => $pdfecho, 'pdfekg' => $pdfekg]);
    }

    //viewDetail
    public function viewDetailTindakan($registrasi_id)
    {
        $tindakan = Folio::where('registrasi_id', $registrasi_id)->whereNotIn('tarif_id', [10000])->get();
        return response()->json($tindakan);
    }

    public function viewDetailObat($registrasi_id)
    {
        $penjualan = \App\Penjualan::where('registrasi_id', $registrasi_id)->first();
        $penjulandetail = \App\Penjualandetail::join('masterobats', 'masterobats.id', '=', 'penjualandetails.masterobat_id')
            ->where('penjualandetails.penjualan_id', $penjualan->id)
            // ->select('masterobats.nama')
            ->get();
        return response()->json($penjulandetail);
    }

    public function viewDetailDiagnosa($registrasi_id)
    {
        $diagnosa = \App\PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
            ->where('registrasi_id', $registrasi_id)
            ->select('icd10s.nama')
            ->get();
        $prosedur = \App\PerawatanIcd9::join('icd9s', 'perawatan_icd9s.icd9', '=', 'icd9s.nomor')
            ->where('registrasi_id', $registrasi_id)
            ->select('icd9s.nama')
            ->get();
        return response()->json(['diagnosa' => $diagnosa, 'prosedur' => $prosedur]);
    }

    public function viewDetailRadiologi($registrasi_id)
    {
        $radiologi = \App\RadiologiEkspertise::where('registrasi_id', $registrasi_id)->get();
        return response()->json($radiologi);
    }

    //=========================== LAPORAN PENGUNJUNG IGD ============================================

    public function lap_pengunjung_igd()
    {
        $data['carabayar']    = Carabayar::all();

        $data['tga']        = '';
        $data['tgb']        = '';
        $data['crb']        = 0;
        // $data['reg'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('politipe', 'G')->get();
        $data['reg'] = \App\HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('provinces', 'provinces.id', '=', 'pasiens.province_id')
            ->join('regencies', 'regencies.id', '=', 'pasiens.regency_id')
            ->join('districts', 'districts.id', '=', 'pasiens.district_id')
            ->join('villages', 'villages.id', '=', 'pasiens.village_id')
            ->select('histori_kunjungan_igd.*', 'registrasis.tipe_jkn', 'registrasis.bayar', 'provinces.name as provinsi', 'regencies.name as kabupaten', 'districts.name as kecamatan', 'villages.name as desa', 'pasiens.user_create')
            ->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
            ->get();
        return view('frontoffice.lap_pengunjung_igd', $data)->with('no', 1);
    }

    public function lap_pengunjung_igd_bytanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['carabayar']    = Carabayar::all();
        $data['crb']        = $request->cara_bayar;

        $data['reg'] = \App\HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('provinces', 'provinces.id', '=', 'pasiens.province_id')
            ->join('regencies', 'regencies.id', '=', 'pasiens.regency_id')
            ->join('districts', 'districts.id', '=', 'pasiens.district_id')
            ->join('villages', 'villages.id', '=', 'pasiens.village_id')
            ->whereBetween('histori_kunjungan_igd.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', ($request->cara_bayar == 0) ? '>' : '=', $request->cara_bayar)
            ->select('histori_kunjungan_igd.*', 'registrasis.bayar', 'provinces.name as provinsi', 'regencies.name as kabupaten', 'districts.name as kecamatan', 'villages.name as desa', 'pasiens.user_create')
            ->get();
        if ($request['view']) {
            return view('frontoffice.lap_pengunjung_igd', $data)->with('no', 1);
        } else if ($request['pdf']) {
            return view('frontoffice.rekapLapPengunjungIgd', $data)->with('no', 1);
        }
    }


    public function cekPasien(Request $request)
    {
        request()->validate(['norm' => 'required', 'tgl' => 'required']);
        $data['cekpasien'] = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->where('pasiens.no_rm', $request['norm'])
            ->where('registrasis.created_at',  'LIKE', valid_date($request['tgl']) . '%')
            ->select('pasiens.id as pasien_id', 'registrasis.*')
            ->first();

        // return $data;die;
        if ($request['cari']) {
            return view('farmasi/penjualan', $data)->with('no', 1);
        }
    }
    public function cekPasienPenjualan(Request $request)
    {
        session()->forget('penjualanid');
        session()->forget('idpenjualan');
        session()->forget('next_resep');
        // dd($request->all());
        // request()->validate(['norm' => 'required','tgl'=>'required']);

        $rm = $request['norm'];
        $nama = $request['nama_pasien'];
        $alamat = $request['alamat'];


        $data['cekpasien'] = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

            // ->where('registrasis.created_at',  'LIKE', valid_date($request['tgl']) . '%')
            ->select('pasiens.id as pasien_id', 'registrasis.*')
            ->orderBy('id', 'DESC');
        // ->limit(3)

        if (isset($rm)) {
            $data['cekpasien'] = $data['cekpasien']->where('pasiens.no_rm', $rm);
        }
        if (isset($nama)) {
            $data['cekpasien'] = $data['cekpasien']->where('pasiens.nama', 'LIKE', $nama . '%');
        }
        if (isset($alamat)) {
            $data['cekpasien'] = $data['cekpasien']->where('pasiens.alamat', 'LIKE', $alamat . '%');
        }



        $data['cekpasien'] = $data['cekpasien']->get();
        if (count($data['cekpasien']) == 0) {
            Flashy::error('Data Pasien tidak ditemukan');
            return redirect('farmasi/penjualan');
        }


        // return $data;die;
        if ($request['cari']) {
            return view('farmasi/penjualan', $data)->with('no', 1);
        }
    }


    public function lapPengunjungIrj()
    {
        $data['carabayar']    = Carabayar::all();
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;
        $data['rajal']      = [];
        // $data['rajal'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
        //     ->where('histori_pengunjung.politipe', 'J')
        //     ->select('registrasis.id as registrasi_id', 'registrasis.nomorantrian as nomor_antrian', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'registrasis.poli_id', 'pasiens.status_marital', 'pasiens.nohp', 'pasiens.ibu_kandung', 'pasiens.regency_id', 'pasiens.district_id', 'pasiens.province_id')
        //     ->get();
        return view('frontoffice.pengunjungIrj', $data)->with('no', 1);
    }
    public function lapPengunjungTagihanIrj()
    {
        $data['carabayar']    = Carabayar::all();
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;
        $data['rajal']      = [];
        return view('frontoffice.pengunjungTagihanIrj', $data)->with('no', 1);
    }


    public function filterLapPengunjungIrj(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['carabayar']    = Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['crb']        = $req->cara_bayar;

        $data['rajal']        = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
            ->where('histori_pengunjung.politipe', 'J')
            ->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
            ->select('registrasis.id as registrasi_id', 'registrasis.nomorantrian as nomor_antrian', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.no_sep', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'registrasis.poli_id', 'pasiens.nohp', 'histori_pengunjung.user')
            ->get();

        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.pengunjungIrj', $data)->with('no', 1);
        } elseif ($req->submit == 'CETAK') {
            $no = 1;
            $pdf = PDF::loadView('frontoffice.rekapLaporan', $data, compact('no'));
            $pdf->setPaper('A4', 'landscape');
            // return $pdf->download('rekapLaporanIrna.pdf');
            return view('frontoffice.rekapLaporan', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $rajal = $data['rajal'];
            $tga = $req->tga;
            $tgb = $req->tgb;
            $title = 'Laporan Pengunjung Rawat Jalan ' . $tga . " / " . $tgb;

            Excel::create($title, function ($excel) use ($rajal) {
                $excel->setTitle('Laporan Pengunjung Rawat Jalan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Jalan');
                $excel->sheet('Pengunjung Rawat Jalan', function ($sheet) use ($rajal) {
                    $row = 3;
                    $no = 1;
                    // $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F','G'),'rows' => array([1,2])]);
                    $sheet->row(1, ['No', 'No. SEP', 'No. RM', 'Nama', 'Alamat', 'Umur', 'Jenis Kelamin', 'No Hp', 'Cara Bayar', 'Poli', 'Dokter', 'Tanggal', 'Jenis Pendaftaran', 'User']);
                    $ceck = 0;
                    foreach ($rajal as $dr) {
                        if ($dr->nomor_antrian == null) {
                            $antr = 'Onsite';
                        } else {
                            $antr = 'Online';
                        }
                        $_dtl = [$no++, $dr->no_sep, $dr->no_rm, $dr->nama, $dr->alamat, hitung_umur($dr->tgllahir), $dr->kelamin, $dr->nohp, baca_carabayar($dr->bayar), baca_poli($dr->poli_id), baca_dokter($dr->dokter_id), date('d-m-Y', strtotime($dr->created_at)), @$antr, $dr->user];
                        $z = 7;
                        $sheet->row($row++, $_dtl);
                    }
                    $sheet->data = [];
                    $row++;
                    $row++;
                    $_no = 1;
                });
            })->export('xlsx');
        }
    }
    public function filterLapPengunjungTagihanIrj(Request $req)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['carabayar']    = Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['crb']        = $req->cara_bayar;

        $keyCache = 'tagihan_irj_laporan' . $tga . '_' . $tgb;
        $data['rajal'] = Cache::get($keyCache);
        if (!$data['rajal']) {
            $data['rajal']        = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [$tga, $tgb])
                ->where('registrasis.status_reg', 'LIKE', '%J%')
                // ->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
                ->select('registrasis.id as registrasi_id', 'registrasis.no_sep', 'registrasis.created_at', 'registrasis.tipe_jkn', 'registrasis.status', 'registrasis.nomorantrian as nomor_antrian', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama', 'pasiens.id', 'pasiens.no_rm', 'pasiens.kelamin', 'registrasis.poli_id')
                // ->limit(5)
                ->get();
            Cache::put($keyCache, $data['rajal'], 120); //BUAT CACHE 2 menit
        }

        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.pengunjungTagihanIrj', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $data['rajal'] = $data['rajal'];
            $data['tga'] = $req->tga;
            $data['tgb'] = $req->tgb;
            $data['title'] = 'Laporan Tagihan Rawat Jalan ' . $tga . " / " . $tgb;
            // dd($data['rajal']);

            Excel::create('Laporan Tagihan Rawat Jalan ' . $tga . '/' . $tgb, function ($excel) use ($data) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->applyFromArray(array(
                        'horizontal'       => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical'         => \PHPExcel_Style_Alignment::VERTICAL_TOP,
                        'wrap'         => TRUE
                    ));
                $excel->sheet('Laporan Tagihan Rawat Jalan', function ($sheet) use ($data) {
                    $sheet->loadView('frontoffice.excel.tagihanIRJ', $data);
                });
            })->download('xlsx');
        }
    }


    //informasi igd
    public function informasi_rawatigd()
    {
        return view('igd.informasi-igd');
    }

    public function dataRawatIgd()
    {
        DB::statement(DB::raw('set @nomorbaris=0'));
        $irna = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
            ->select([
                'registrasis.id as reg_id', 'pasien_id', 'jenis_pasien', 'status', 'rujukan', 'status_reg', 'registrasis.dokter_id', 'registrasis.poli_id',
                'registrasis.tipe_layanan', 'registrasis.bayar', 'registrasis.tipe_jkn', 'rawatinaps.created_at', 'rawatinaps.*'
            ])
            ->where('registrasis.status_reg', 'G1', 'G2')->get();
        return DataTables::of($irna)
            ->addColumn('nomor', function ($irna) {
                return '';
            })
            ->addColumn('no_rm', function ($irna) {
                return $irna->pasien->no_rm;
            })
            ->addColumn('nama', function ($irna) {
                return $irna->pasien->nama;
            })
            ->addColumn('alamat', function ($irna) {
                return $irna->pasien->alamat;
            })
            ->addColumn('poli', function ($irna) {
                return baca_poli($irna->poli_id);
            })
            ->addColumn('waktu', function ($irna) {
                return $irna->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('kelas', function ($irna) {
                return baca_kelas($irna->kelas_id);
            })
            ->addColumn('bangsal', function ($irna) {
                return baca_kamar($irna->kamar_id);
            })
            ->addColumn('bed', function ($irna) {
                return baca_bed($irna->bed_id);
            })
            ->addColumn('dpjp', function ($irna) {
                return baca_dokter($irna->dokter_id);
            })
            ->addColumn('carabayar', function ($irna) {
                $jkn = !empty($irna->tipe_jkn) ? '- ' . $irna->tipe_jkn : '';
                return baca_carabayar($irna->bayar) . " " . $jkn;
            })
            ->addColumn('view', function ($irna) {
                return '<button type="button" onclick="viewDetail(' . $irna->reg_id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open"></i></button>';
            })
            ->rawColumns(['view'])
            ->make(true);
    }


    public function detailDataRawatIgd($registrasi_id)
    {
        $detail = Registrasi::where('registrasis.id', $registrasi_id)->first();
        // ->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
        // ->join('histori_seps', 'registrasis.id', '=', 'histori_seps.registrasi_id')
        // ->select('registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.rujukan',
        // 	'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.poli_id',
        // 	'registrasis.tipe_layanan', 'registrasis.bayar', 'registrasis.tipe_jkn', 'rawatinaps.created_at as waktu', 'rawatinaps.tgl_masuk as masuk', 'rawatinaps.*', 'histori_seps.diagnosa_awal as diagnosa')
        // ->first();
        $ranap = Rawatinap::where('registrasi_id', $registrasi_id)->first();
        // dd($detail->poli_id);
        $jkn = !empty($detail->tipe_jkn) ? ' - ' . $detail->tipe_jkn : '';
        $data['no_rm'] = $detail->pasien->no_rm;
        $data['nama'] = $detail->pasien->nama;
        $data['alamat'] = $detail->pasien->alamat;
        $data['poli'] = baca_poli($detail->poli_id);
        $data['carabayar'] = baca_carabayar($detail->bayar) . $jkn;
        $data['dokter'] = baca_dokter($ranap->dokter_id);
        $data['kelas'] = baca_kelas($ranap->kelas_id);
        $data['kamar'] = baca_kamar($ranap->kamar_id);
        $data['bed'] = baca_bed($ranap->bed_id);
        $data['diagnosa_awal'] = $detail->diagnosa;
        $data['keterangan'] = $ranap->keterangan;
        $data['tglMasuk'] = tanggal_eklaim($ranap->tgl_masuk);
        return response()->json($data);
    }


    public function dataRawatInap()
    {
        DB::statement(DB::raw('set @nomorbaris=0'));
        $irna = Registrasi::find('id')
            ->select([
                'registrasis.id as reg_id', 'pasien_id', 'jenis_pasien', 'status', 'rujukan', 'status_reg', 'registrasis.dokter_id', 'registrasis.poli_id',
                'registrasis.tipe_layanan', 'registrasis.bayar', 'registrasis.tipe_jkn'
            ])
            ->where('registrasis.status_reg', 'G1')->get();
        return DataTables::of($irna)
            ->addColumn('nomor', function ($irna) {
                return '';
            })
            ->addColumn('no_rm', function ($irna) {
                return $irna->pasien->no_rm;
            })
            ->addColumn('nama', function ($irna) {
                return $irna->pasien->nama;
            })
            ->addColumn('alamat', function ($irna) {
                return $irna->pasien->alamat;
            })
            ->addColumn('poli', function ($irna) {
                return baca_poli($irna->poli_id);
            })
            ->addColumn('waktu', function ($irna) {
                return $irna->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('kelas', function ($irna) {
                return baca_kelas($irna->kelas_id);
            })
            ->addColumn('bangsal', function ($irna) {
                return baca_kamar($irna->kamar_id);
            })
            ->addColumn('bed', function ($irna) {
                return baca_bed($irna->bed_id);
            })
            ->addColumn('dpjp', function ($irna) {
                return baca_dokter($irna->dokter_id);
            })
            ->addColumn('carabayar', function ($irna) {
                $jkn = !empty($irna->tipe_jkn) ? '- ' . $irna->tipe_jkn : '';
                return baca_carabayar($irna->bayar) . " " . $jkn;
            })
            ->addColumn('view', function ($irna) {
                return '<button type="button" onclick="viewDetail(' . $irna->reg_id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open"></i></button>';
            })
            ->rawColumns(['view'])
            ->make(true);
    }

    // laporan pengunjung rawat darurat
    public function lapPengunjungIGD()
    {
        $data['carabayar']    = Carabayar::all();
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['darurat'] = [];
        // $data['darurat'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
        //     ->where('histori_pengunjung.politipe', 'G')
        //     ->select('pasiens.nohp', 'pasiens.nama_keluarga', 'registrasis.keterangan as keterangan', 'registrasis.user_create as user_id', 'registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe')
        //     ->get();
        return view('frontoffice.pengunjungIGD', $data)->with('no', 1);
    }


    public function filterLapPengunjungIGD(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['carabayar']    = Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['dokter_id'] = $req->dokter_id;
        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['crb']        = $req->cara_bayar;

        $data['darurat']        = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
            ->where('histori_pengunjung.politipe', 'G')
            ->where('registrasis.dokter_id', ($req->dokter_id == 0) ? '>' : '=', $req->dokter_id)
            ->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
            ->select('pasiens.nohp', 'pasiens.nama_keluarga', 'registrasis.user_create as user_id', 'registrasis.keterangan as keterangan', 'registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe')
            ->get();

        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.pengunjungIGD', $data)->with('no', 1);
        } elseif ($req->submit == 'CETAK') {
            // $no = 1;
            // $pdf = PDF::loadView('frontoffice.rekapLaporan', $data, compact('no'));
            // $pdf->setPaper('A4', 'landscape');
            // return $pdf->download('rekapLaporanIrna.pdf');
            return view('frontoffice.rekapPengunjungIGD', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $darurat = $data['darurat'];
            $tga = $req->tga;
            $tgb = $req->tgb;
            Excel::create('Laporan Pengunjung Rawat Darurat', function ($excel) use ($darurat) {
                $excel->setTitle('Laporan Pengunjung Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Darurat');
                $excel->sheet('Pengunjung Rawat Darurat', function ($sheet) use ($darurat) {
                    $row = 3;
                    $no = 1;
                    // $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F'),'rows' => array([1,2])]);
                    $sheet->row(1, ['No', 'No. RM', 'Penanggung Jawab', 'Nama', 'Alamat', 'Umur', 'Jenis Kelamin', 'Cara Bayar', 'Layanan', 'Dokter', 'Tanggal', 'User', 'Keterangan']);
                    $ceck = 0;
                    foreach ($darurat as $dr) {
                        $_dtl = [$no++, $dr->no_rm, $dr->nama_keluarga, $dr->nama, $dr->alamat, hitung_umur($dr->tgllahir), $dr->kelamin, baca_carabayar($dr->bayar), baca_poli($dr->poli_id), baca_dokter($dr->dokter_id), date('d-m-Y', strtotime($dr->created_at)), baca_user($dr->user_id), $dr->keterangan];
                        $z = 7;
                        $sheet->row($row++, $_dtl);
                    }
                    $sheet->data = [];
                    $row++;
                    $row++;
                    $_no = 1;
                });
            })->export('xlsx');
        }
    }

    // laporan jaga IGD
    public function lapJagaIGD(Request $req)
    {
        $data['carabayar']    = Carabayar::all();
        $data['crb']        = $req->crb;

        if ($req->tga == null && $req->tgb == null) {
            $tga        = now()->startOfDay()->format('Y-m-d H:i:s');
            $tgb        = now()->endOfDay()->format('Y-m-d H:i:s');
            $data['tga'] = now()->format('d-m-Y');
            $data['tgb'] = now()->format('d-m-Y');
        } else {
            $tga        = valid_date($req->tga) . ' 00:00:00';
            $tgb        = valid_date($req->tgb) . ' 23:59:59';
            $data['tga'] = $req->tga;
            $data['tgb'] = $req->tgb;
        }

        $data['darurat'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->select('registrasis.id', 'registrasis.sebabsakit_id', 'pasiens.nama', 'registrasis.status', 'registrasis.tgl_pulang', 'registrasis.status_ugd', 'registrasis.bayar',  'registrasis.created_at', 'registrasis.pulang', 'histori_kunjungan_igd.pengirim_rujukan', 'registrasis.keterangan', 'registrasis.kondisi_akhir_pasien')
            ->whereBetween('histori_kunjungan_igd.created_at', [$tga, $tgb]);

        if ($req->crb != null) {
            $$data['darurat']->where('registrasis.bayar', $req->crb);
        }

        $data['pagination'] = $data['darurat']->paginate(50);
        $data['daruratItems'] = $data['pagination']->map(function ($kunjungan) {
            $status_ugd =  @json_decode(@$kunjungan->status_ugd, true);
            // Waktu Observasi
            $masuk = $kunjungan->created_at;
            $pulang = $kunjungan->tgl_pulang;

            $tgl_pulang = new DateTime($pulang);
            $tgl_masuk = new DateTime($masuk);

            $selisih = $tgl_pulang->diff($tgl_masuk);
            $waktu_obs = null;

            if ($selisih->y == 0 && $selisih->m == 0 && $selisih->d == 0 && $selisih->h <= 6) {
                $waktu_obs = '< 6 jam';
            } else {
                $waktu_obs = '> 6 jam';
            }

            // Meninggal
            $meninggal = null;
            if ($kunjungan->pulang == 13) {
                $meninggal = 'DOA';
            } else if ($kunjungan->kondisi_akhir_pasien == 8) {
                $meninggal = '> 48 jam';
            } else if ($kunjungan->kondisi_akhir_pasien == 9) {
                $meninggal = '< 48 jam';
            }

            // Diinapkan
            $inap = null;

            if ($kunjungan->pulang == 7) {
                $inap = @$status_ugd['keterangan'];
            }
            // Rujuk
            if ($kunjungan->pulang == 2) {
                $rujuk = @$status_ugd['diRujukKe'];
            }

            // Pasien Akhir
            $emr = EmrInapPemeriksaan::where('registrasi_id', $kunjungan->id)->first();
            $emrFisik = @json_decode($emr->fisik, true);
            $kamarIso = [3, 6, 9, 12, 14, 16];
            $obs_anak = null;
            $obs_dewasa = null;
            $resus = Folio::where('registrasi_id', $kunjungan->id)->where('namatarif', 'like', '%RJP%')->first();
            $triage = @$emrFisik['triage'];
            $bedah = $kunjungan->sebabsakit_id == 1 ? true : false;
            $iso = RawatInap::where('registrasi_id', $kunjungan->id)->whereIn('kamar_id', $kamarIso)->first();

            $kesimpulan = @$emrFisik['triage']['kesimpulan'];
            if ($kesimpulan == 'Urgent ATS II & III') {
                $obs_dewasa = true;
            } else if ($kesimpulan == 'Non Urgent ATS IV & V') {
                $obs_anak = true;
            }

            return (object) [
                'regID' => $kunjungan->id,
                'nama' => $kunjungan->nama,
                'status' => $kunjungan->status,
                'waktu_observasi' => $waktu_obs,
                'cara_pulang' => @KondisiAkhirPasien::find($kunjungan->pulang)->namakondisi,
                'test' => $status_ugd,
                'meninggal' => $meninggal,
                'inap' => $inap,
                'rujuk' => @$rujuk,
                'keterangan' => $kunjungan->keterangan,
                'obs_anak' => $obs_anak,
                'obs_dewasa' => $obs_dewasa,
                'resus' => $resus,
                'triage' => $triage,
                'bedah' => $bedah,
                'iso' => $iso,
            ];
        });
        if ($req->submit == 'EXCEL') {
            // $darurat = $data['darurat']->get();

            Excel::create('Laporan Jaga Rawat Darurat ' . $tga . '/' . $tgb, function ($excel) use ($data) {
                $excel->setTitle('Laporan Jaga Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Jaga Rawat Darurat');
                $excel->sheet('Distribusi', function ($sheet) use ($data) {
                    $sheet->loadView('frontoffice.excel.jagaIGD_excel', $data);
                });
            })->export('xls');
            // Excel::create('Laporan Pengunjung Rawat Darurat', function ($excel) use ($darurat) {
            //     $excel->setTitle('Laporan Jaga Rawat Darurat')
            //         ->setCreator('Digihealth')
            //         ->setCompany('Digihealth')
            //         ->setDescription('Laporan Jaga Rawat Darurat');
            //     $excel->sheet('Jaga Rawat Darurat', function ($sheet) use ($darurat) {
            //         $row = 3;
            //         $no = 1;
            //         // $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F'),'rows' => array([1,2])]);
            //         $sheet->row(1, ['No', 'Nama', 'Jenis Pasien', 'Waktu Observasi', 'Cara Pulang', 'Meninggal', 'Diinapkan', 'Rujuk', 'Obs. Anak', 'Obs. Dewasa', 'Resus', 'Triage', 'Bedah', 'Iso', 'Keterangan']);
            //         foreach ($darurat as $dr) {
            //             $_dtl = [$no++, $dr->nama, $dr->status == 'baru' ? 'Baru' : 'Lama', $dr->waktu_observasi, $dr->cara_pulang ?? '-', $dr->meninggal ?? '-', $dr->inap ?? 'Tidak', $dr->rujuk ?? '-', $dr->obs_anak ? '✔' : '✘', $dr->obs_dewasa ? '✔' : '✘', $dr->resus ? '✔' : '✘', $dr->triage ? '✔' : '✘', $dr->bedah ? '✔' : '✘', $dr->iso ? '✔' : '✘', $dr->keterangan];
            //             $sheet->row($row++, $_dtl);
            //         }
            //         $sheet->data = [];
            //         $row++;
            //         $row++;
            //         $_no = 1;
            //     });
            // })->export('xlsx');
        } else {
            $no = $req->page ? (($req->page - 1) * 50) + 1 : 1;
            return view('frontoffice.jagaIGD', $data)->with('no', $no);
        }
    }


    public function filterLapJagaIGD(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['carabayar']    = Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['crb']        = $req->cara_bayar;

        $data['darurat'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->select('registrasis.id', 'registrasis.sebabsakit_id', 'pasiens.nama', 'registrasis.status', 'registrasis.tgl_pulang', 'registrasis.status_ugd', 'registrasis.created_at', 'registrasis.pulang', 'histori_kunjungan_igd.pengirim_rujukan', 'registrasis.keterangan', 'registrasis.kondisi_akhir_pasien')
            ->whereBetween('histori_kunjungan_igd.created_at', [$tga, $tgb]);

        $data['pagination'] = $data['darurat']->paginate(20);
        $data['daruratItems'] = $data['pagination']->map(function ($kunjungan) {
            $status_ugd =  @json_decode(@$kunjungan->status_ugd, true);
            // Waktu Observasi
            $masuk = $kunjungan->created_at;
            $pulang = $kunjungan->tgl_pulang;

            $tgl_pulang = new DateTime($pulang);
            $tgl_masuk = new DateTime($masuk);

            $selisih = $tgl_pulang->diff($tgl_masuk);
            $waktu_obs = null;

            if ($selisih->y == 0 && $selisih->m == 0 && $selisih->d == 0 && $selisih->h <= 6) {
                $waktu_obs = '< 6 jam';
            } else {
                $waktu_obs = '> 6 jam';
            }

            // Meninggal
            $meninggal = null;
            if ($kunjungan->pulang == 13) {
                $meninggal = 'DOA';
            } else if ($kunjungan->kondisi_akhir_pasien == 8) {
                $meninggal = '> 48 jam';
            } else if ($kunjungan->kondisi_akhir_pasien == 9) {
                $meninggal = '< 48 jam';
            }

            // Diinapkan
            $inap = null;

            if ($kunjungan->pulang == 7) {
                $inap = @$status_ugd['keterangan'];
            }
            // Rujuk
            if ($kunjungan->pulang == 2) {
                $rujuk = @$status_ugd['diRujukKe'];
            }

            // Pasien Akhir
            $emr = EmrInapPemeriksaan::where('registrasi_id', $kunjungan->id)->first();
            $emrFisik = @json_decode($emr->fisik, true);
            $kamarIso = [3, 6, 9, 12, 14, 16];
            $obs_anak = null;
            $obs_dewasa = null;
            $resus = Folio::where('registrasi_id', $kunjungan->id)->where('namatarif', 'like', '%RJP%')->first();
            $triage = @$emrFisik['triage'];
            $bedah = $kunjungan->sebabsakit_id == 1 ? true : false;
            $iso = RawatInap::where('registrasi_id', $kunjungan->id)->whereIn('kamar_id', $kamarIso)->first();

            $kesimpulan = @$emrFisik['triage']['kesimpulan'];
            if ($kesimpulan == 'Urgent ATS II & III') {
                $obs_dewasa = true;
            } else if ($kesimpulan == 'Non Urgent ATS IV & V') {
                $obs_anak = true;
            }

            return (object) [
                'regID' => $kunjungan->id,
                'nama' => $kunjungan->nama,
                'status' => $kunjungan->status,
                'waktu_observasi' => $waktu_obs,
                'cara_pulang' => @KondisiAkhirPasien::find($kunjungan->pulang)->namakondisi,
                'test' => $status_ugd,
                'meninggal' => $meninggal,
                'inap' => $inap,
                'rujuk' => @$rujuk,
                'keterangan' => $kunjungan->keterangan,
                'obs_anak' => $obs_anak,
                'obs_dewasa' => $obs_dewasa,
                'resus' => $resus,
                'triage' => $triage,
                'bedah' => $bedah,
                'iso' => $iso,
            ];
        });


        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.jagaIGD', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $darurat = $data['darurat']->get();
            Excel::create('Laporan Pengunjung Rawat Darurat', function ($excel) use ($darurat) {
                $excel->setTitle('Laporan Jaga Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Jaga Rawat Darurat');
                $excel->sheet('Jaga Rawat Darurat', function ($sheet) use ($darurat) {
                    $row = 3;
                    $no = 1;
                    // $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F'),'rows' => array([1,2])]);
                    $sheet->row(1, ['No', 'Nama', 'Jenis Pasien', 'Waktu Observasi', 'Cara Pulang', 'Meninggal', 'Diinapkan', 'Rujuk', 'Obs. Anak', 'Obs. Dewasa', 'Resus', 'Triage', 'Bedah', 'Iso', 'Keterangan']);
                    foreach ($darurat as $dr) {
                        $_dtl = [$no++, $dr->nama, $dr->status == 'baru' ? 'Baru' : 'Lama', $dr->waktu_observasi, $dr->cara_pulang ?? '-', $dr->meninggal ?? '-', $dr->inap ?? 'Tidak', $dr->rujuk ?? '-', $dr->obs_anak ? '✔' : '✘', $dr->obs_dewasa ? '✔' : '✘', $dr->resus ? '✔' : '✘', $dr->triage ? '✔' : '✘', $dr->bedah ? '✔' : '✘', $dr->iso ? '✔' : '✘', $dr->keterangan];
                        $sheet->row($row++, $_dtl);
                    }
                    $sheet->data = [];
                    $row++;
                    $row++;
                    $_no = 1;
                });
            })->export('xlsx');
        }
    }

    // Histori Hapus Tindakan
    public function historiHapusTindakan(Request $req)
    {   
        $data['tga'] = date('d-m-Y');
        $data['tgb'] = date('d-m-Y');

        $data['data'] = LogFolio::where('created_at', 'like', date('Y-m-d') . '%')->get();
        return view('frontoffice.historiTindakan', $data);
    }


    public function filterHistoriHapusTindakan(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tga'] = valid_date($req->tga);
        $data['tgb'] = valid_date($req->tgb);
        $data['data'] = LogFolio::whereBetween('created_at', [$data['tga'] . ' 00:00:00', $data['tgb'] . ' 23:59:59'])->get();
        return view('frontoffice.historiTindakan', $data);
    }


    // laporan pengunjung rawat darurat
    public function lapRegistrasiIGD()
    {
        $data['carabayar']            = Carabayar::all();
        // $data['cara_bayar_id']		= '';
        $data['kasus_id']           = '';
        $data['cara_masuk_id']      = '';
        $data['caraPulang']         = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang_id']     = '';
        $data['kondisiPulang']      = KondisiAkhirPasien::where('jenis', 'kondisi')->orderBy('urutan', 'ASC')->get();
        $data['kondisi_pulang_id']  = '';
        $data['status_pasien']      = '';
        $data['kelompok_bpjs']      = Registrasi::where('tipe_jkn', '!=', null)->groupBy('tipe_jkn')->pluck('tipe_jkn');
        $data['kelompok_bpjs_id']   = '';
        // dd($data['kelompok_bpjs'] );
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['blp']        = "";
        $data['darurat'] = [];
        // $data['darurat'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
        //     ->where('histori_pengunjung.politipe', 'G')
        //     ->select('pasiens.nohp', 'registrasis.tipe_jkn', 'registrasis.keterangan as keterangan', 'registrasis.user_create as user_id', 'registrasis.id as registrasi_id', 'registrasis.pulang', 'registrasis.kondisi_akhir_pasien', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status_ugd', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe')
        //     ->get();
        return view('frontoffice.registrasiIGD', $data)->with('no', 1);
    }

    public function filterLapRegistrasiIGD(Request $req)
    {
        // dd($req);

        request()->validate([
            'blp' => 'required_without_all:tga,tgb',
            'tga' => 'nullable|required_without:blp',
            'tgb' => 'nullable|required_without:blp',
        ]);
        $data['tga']            = $req->tga;
        $data['tgb']            = $req->tgb;
        $data['blp']            = $req->blp;
        // $tga                    = valid_date($req->tga) . ' 00:00:00';
        // $tgb                    = valid_date($req->tgb) . ' 23:59:59';
        $data['carabayar']        = Carabayar::all();
        // $data['cara_bayar_id']	= $req->cara_bayar_id;
        $data['kasus_id']       = $req->kasus_id;
        $data['cara_masuk_id']  = $req->cara_masuk_id;
        $data['caraPulang']     = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
        $data['cara_pulang_id'] = $req->cara_pulang_id;
        $data['kondisiPulang']  = KondisiAkhirPasien::where('jenis', 'kondisi')->orderBy('urutan', 'ASC')->get();
        $data['kondisi_pulang_id']      = $req->kondisi_pulang_id;
        $data['status_pasien']          = $req->status_pasien;
        $data['kelompok_bpjs']          = Registrasi::where('tipe_jkn', '!=', null)->groupBy('tipe_jkn')->pluck('tipe_jkn');
        $data['kelompok_bpjs_id']       = $req->kelompok_bpjs_id;

        $tga = !empty($req->tga) ? valid_date($req->tga) . ' 00:00:00' : null;
        $tgb = !empty($req->tgb) ? valid_date($req->tgb) . ' 23:59:59' : null;

        if ($req->cari != null) {
            $data['darurat'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->where('histori_pengunjung.politipe', 'G')
                ->where('pasiens.nama', 'LIKE', "%$req->keyword%")
                ->orWhere('pasiens.no_rm', 'LIKE', "%$req->keyword%")
                ->select('registrasis.tipe_jkn', 'pasiens.nohp', 'registrasis.keterangan as keterangan', 'registrasis.user_create as user_id', 'registrasis.id as registrasi_id', 'registrasis.pulang', 'registrasis.kondisi_akhir_pasien', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status_ugd', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe')->get();
            return view('frontoffice.registrasiIGD', $data)->with('no', 1);
        }

        $data['darurat'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            // ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
            ->where('histori_pengunjung.politipe', 'G')
            ->select('registrasis.tipe_jkn', 'pasiens.nohp', 'registrasis.keterangan as keterangan', 'registrasis.user_create as user_id', 'registrasis.id as registrasi_id', 'registrasis.pulang', 'registrasis.kondisi_akhir_pasien', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status_ugd', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe');

        if (!empty($req->blp)) {
            [$bulan, $tahun] = explode('-', $req->blp);
            $data['darurat']->whereMonth('rawatinaps.tgl_keluar', $bulan)
                            ->whereYear('rawatinaps.tgl_keluar', $tahun);
        } elseif ($tga && $tgb) {
            $data['darurat']->whereBetween('histori_pengunjung.created_at', [$tga, $tgb]);
        }
        
        if ($data['cara_pulang_id'] != null) {
            $data['darurat']->where('pulang', $data['cara_pulang_id']);
        }
        if ($data['kondisi_pulang_id'] != null) {
            $data['darurat']->where('kondisi_akhir_pasien', $data['kondisi_pulang_id']);
        }
        if ($data['status_pasien'] != null) {
            if ($data['status_pasien'] == 'bpjs') {
                $data['darurat']->where('bayar', '!=', 2);
            } else {
                $data['darurat']->where('bayar', 2);
            }
        }

        if ($data['kelompok_bpjs_id'] != null) {
            $data['darurat']->where('tipe_jkn', $data['kelompok_bpjs_id']);
        }
        $data['darurat'] = $data['darurat']->get();

        if ($data['kasus_id'] != null) {
            $kasus = $data['kasus_id'];
            $data['darurat'] = $data['darurat']->filter(function ($item) use ($kasus) {
                return @json_decode(@$item['status_ugd'], true)['kasus'] == $kasus;
            });
        }
        if ($data['cara_masuk_id'] != null) {
            $caraMasuk = $data['cara_masuk_id'];
            $data['darurat'] = $data['darurat']->filter(function ($item) use ($caraMasuk) {
                return @json_decode(@$item['status_ugd'], true)['caraMasuk'] == $caraMasuk;
            });
        }
        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.registrasiIGD', $data)->with('no', 1);
        } elseif ($req->submit == 'CETAK') {
            // $no = 1;
            // $pdf = PDF::loadView('frontoffice.rekapLaporan', $data, compact('no'));
            // $pdf->setPaper('A4', 'landscape');
            // return $pdf->download('rekapLaporanIrna.pdf');
            return view('frontoffice.rekapPengunjungIGD', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $darurat = $data['darurat'];
            $tga = $req->tga;
            $tgb = $req->tgb;
            $blp = $req->blp;

            $judul = 'Laporan Registrasi Rawat Darurat';
            if ($blp) {
                $judul .= ' Bulan Pulang ' . $blp;
            } elseif ($tga && $tgb) {
                $judul .= ' ' . $tga . ' - ' . $tgb;
            }

            Excel::create($judul, function ($excel) use ($darurat) {
                $excel->setTitle('Laporan Registrasi Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Registrasi Rawat Darurat');
                $excel->sheet('Pengunjung Rawat Darurat', function ($sheet) use ($darurat) {
                    $row = 2;
                    $no = 1;
                    $sheet->row(
                        1,
                        [
                            'No',
                            'Tanggal',
                            'No. RM',
                            'Nama',
                            'DPJP',
                            'Status Periksa',
                            'Kasus',
                            'Status Billing',
                            'Metode Bayar',
                            'Alamat',
                            'Umur',
                            'Jenis Kelamin',
                            'No Hp',
                            'Penjamin',
                            'Cara Masuk',
                            'Cara Pulang',
                            'Kondisi Pulang',
                            'User',
                            'Keterangan'
                        ]
                    );
                    foreach ($darurat as $d) {
                        $isNotLunas = Folio::where('registrasi_id', $d->registrasi_id)->where('lunas', 'N')->exists();
                        $pembayaran = @Pembayaran::where('registrasi_id', $d->registrasi_id)->first();
                        $metode_bayar = @MetodeBayar::find(@$pembayaran->metode_bayar_id)->name;
                        $sheet->row($row++, [
                            $no++,
                            (new DateTime($d->created_at))->format('d-m-Y'),
                            $d->no_rm,
                            $d->nama,
                            baca_dokter($d->dokter_id),
                            @json_decode(@$d->status_ugd, true)['jam_masuk'] != null ? 'Sudah Diproses' : 'Belum Diproses',
                            @json_decode(@$d->status_ugd, true)['kasus'],
                            $isNotLunas ? 'Belum Lunas' : 'Sudah Lunas',
                            @$metode_bayar,
                            $d->alamat,
                            hitung_umur($d->tgllahir),
                            $d->kelamin,
                            $d->nohp,
                            baca_carabayar($d->bayar),
                            @json_decode(@$d->status_ugd, true)['caraMasuk'],
                            baca_carapulang($d->pulang),
                            baca_carapulang($d->kondisi_akhir_pasien),
                            baca_user($d->user_id),
                            @json_decode(@$d->status_ugd, true)['keterangan']
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }


    // laporan pengunjung rawat irna
    public function lapPengunjungIRNA()
    {
        $data['carabayar']    = Carabayar::all();
        $data['kelompok']    = Kelompokkelas::all();
        $data['pekerjaan'] = Pekerjaan::all();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;
        $data['sp']            = 0;
        $data['klmpk']        = 0;
        $data['status_pulang'] = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
        $data['irna'] = [];
        // $data['irna'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'histori_pengunjung.registrasi_id')
        //     ->where('histori_pengunjung.politipe', 'I')
        //     ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
        //     ->select('registrasis.id as registrasi_id', 'registrasis.pulang as cara_pulang_id', 'registrasis.diagnosa_awal as diagnosa', 'histori_pengunjung.created_at', 'histori_pengunjung.user', 'registrasis.status_reg', 'rawatinaps.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe', 'pasiens.nohp')->get();
        return view('frontoffice.pengunjungIRNA', $data)->with('no', 1);
    }

    public function filterLapPengunjungIRNA(Request $req)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        request()->validate([
            'blp' => 'required_without_all:tga,tgb',
            'tga' => 'nullable|required_without:blp',
            'tgb' => 'nullable|required_without:blp',
        ]);              
        // dd($req->all());
        $data['carabayar']    = Carabayar::all();
        $data['kelompok']    = Kelompokkelas::all();
        $data['pekerjaan'] = Pekerjaan::all();
        // $tga                = valid_date($req->tga) . ' 00:00:00';
        // $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['dokter_id'] = $req->dokter_id;
        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['blp']        = $req->blp;
        $data['crb']        = $req->cara_bayar;
        $data['sp']            = $req->status_pulang;
        $data['klmpk']        = $req->kelompok;
        $data['pkrjn']        = $req->pekerjaan;
        $data['status_pulang'] = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();

        $query        = Historipengunjung
            ::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'histori_pengunjung.registrasi_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'rawatinaps.dokter_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'rawatinaps.kelas_id')
            ->leftJoin('kamars', 'kamars.id', '=', 'rawatinaps.kamar_id')
            ->leftJoin('beds', 'beds.id', '=', 'rawatinaps.bed_id')
            ->leftJoin('kondisi_akhir_pasiens', 'kondisi_akhir_pasiens.id', '=', 'registrasis.pulang')
            ->where('rawatinaps.kelompokkelas_id', ($req->kelompok == 0) ? '>' : '=', $req->kelompok)
            // ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
            ->where('rawatinaps.dokter_id', ($req->dokter_id == 0) ? '>' : '=', $req->dokter_id)
            ->where('histori_pengunjung.politipe', 'I')
            ->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
            ->select('registrasis.id as registrasi_id', 'registrasis.no_sep', 'registrasis.diagnosa_awal as diagnosa', 'histori_pengunjung.user', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'rawatinaps.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'pasiens.pekerjaan_id', 'histori_pengunjung.politipe', 'pasiens.nohp', 'carabayars.carabayar', 'polis.nama as nama_poli', 'pegawais.nama as dpjp', 'rawatinaps.*', 'kelas.nama as nama_kelas', 'kamars.nama as nama_kamar', 'beds.nama as nama_bed', 'kondisi_akhir_pasiens.namakondisi', 'registrasis.tipe_jkn');

        if (isset($req->status_pulang) && !empty($req->status_pulang)) {
            $query->where('registrasis.pulang', $req->status_pulang);
        }
        // if (!empty($req->pekerjaan)) {
        //     $query->where('pasiens.pekerjaan_id', $req->pekerjaan);
        // }
        if (!empty($req['pekerjaan'])) {
            $query->where('pasiens.pekerjaan_id', $req['pekerjaan']);
        }       
        if (!empty($req->tga) && !empty($req->tgb)) {
            $tga = valid_date($req->tga) . ' 00:00:00';
            $tgb = valid_date($req->tgb) . ' 23:59:59';
            $query->whereBetween('histori_pengunjung.created_at', [$tga, $tgb]);
        }
        if (!empty($req->blp)) {
            $carbonBlp = \Carbon\Carbon::createFromFormat('Y-m', $req->blp);
            $bulan = $carbonBlp->month;
            $tahun = $carbonBlp->year;
    
            $query->whereMonth('rawatinaps.tgl_keluar', $bulan)
                  ->whereYear('rawatinaps.tgl_keluar', $tahun);
        }                      

        $data['irna'] = $query->groupBy('histori_pengunjung.registrasi_id')->get();

        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.pengunjungIRNA', $data)->with('no', 1);
        } elseif ($req->submit == 'CETAK') {
            $no = 1;
            $pdf = PDF::loadView('frontoffice.rekapLaporan', $data, compact('no'));
            $pdf->setPaper('A4', 'landscape');
            return view('frontoffice.rekapLaporan', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $irna = $data['irna'];
            $tga = $req->tga;
            $tgb = $req->tgb;
            Excel::create('Laporan Pengunjung Rawat Inap', function ($excel) use ($irna) {
                $excel->setTitle('Laporan Pengunjung Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Inap');
                $excel->sheet('Pengunjung Rawat Inap', function ($sheet) use ($irna) {
                    $row = 3;
                    $no = 1;
                    // $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F','G'),'rows' => array([1,2])]);
                    $sheet->row(1, ['No', 'No. RM', 'No. SEP', 'Nama', 'Alamat', 'Pekerjaan', 'Umur', 'Jenis Kelamin', 'No Hp', 'Cara Bayar', 'Tanggal Masuk', 'Tanggal Keluar', 'Poli', 'Kelas', 'Kamar', 'Bed', 'Riwayat Mutasi', 'Dokter', 'Tanggal', 'Petugas', 'Keterangan', 'Diagnosa', 'Status Pulang']);
                    foreach ($irna as $dr) {
                        $riwayat_mutasi = \App\HistoriRawatInap::where('registrasi_id', $dr->registrasi_id)
                            ->orderBy('id', 'ASC')
                            ->select('bed_id')
                            ->get();
                        $mutasi_str = '';
                        if ($riwayat_mutasi->isNotEmpty()) {
                            $mutasi_str = baca_bed($riwayat_mutasi->first()->bed_id);
                        }
                        $_dtl = [
                            $no++,
                            $dr->no_rm,
                            $dr->no_sep,
                            $dr->nama,
                            $dr->alamat,
                            baca_pekerjaan($dr->pekerjaan_id),
                            hitung_umur($dr->tgllahir),
                            $dr->kelamin,
                            $dr->nohp,
                            @$dr->carabayar . '-' . @$dr->tipe_jkn,
                            (@$dr->tgl_masuk) ? date('d-m-Y', strtotime(@$dr->tgl_masuk)) : null,
                            (@$dr->tgl_keluar) ? date('d-m-Y', strtotime(@$dr->tgl_keluar)) : null,
                            @$dr->nama_poli,
                            (@$dr) ? @$dr->nama_kelas : null,
                            (@$dr) ? @$dr->nama_kamar : null,
                            (@$dr) ? @$dr->nama_bed : null,
                            $mutasi_str,
                            @$dr->dpjp,
                            date('d-m-Y', strtotime($dr->created_at)),
                            $dr->user,
                            (@$dr->keterangan) ? @$dr->keterangan : null,
                            $dr->diagnosa,
                            $dr->namakondisi
                        ];
                        $sheet->row($row++, $_dtl);
                    }
                    $sheet->data = [];
                    $row++;
                    $row++;
                });
            })->export('xlsx');
        }
    }

    // laporan pengunjung rawat irna
    public function lapRanap()
    {
        $data['carabayar']    = Carabayar::all();
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;

        // $data['irna'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        //     ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->where('histori_pengunjung.politipe', 'I')
        //     ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
        //     ->select('registrasis.id as registrasi_id', 'registrasis.diagnosa_awal as diagnosa', 'histori_pengunjung.created_at', 'histori_pengunjung.user', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe', 'pasiens.nohp', 'registrasis.no_sep')->get();
        $data['irna'] = [];
        return view('frontoffice.pengunjungRanap', $data)->with('no', 1);
    }

    public function filterLapRanap(Request $req) 
    {
        request()->validate([
            'blp' => 'required_without_all:tga,tgb',
            'tga' => 'nullable|required_without:blp',
            'tgb' => 'nullable|required_without:blp',
        ]);
        $data['carabayar']    = Carabayar::all();
        // $tga                = valid_date($req->tga) . ' 00:00:00';
        // $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['blp']        = $req->blp;
        $data['crb']        = $req->cara_bayar;

        $query = DB::table('rawatinaps')
            ->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('histori_rawatinap', 'histori_rawatinap.registrasi_id','=','registrasis.id')
            // ->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
            ->where('registrasis.status_reg', 'I3')
            ->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
            ->whereNull('rawatinaps.deleted_at')
            // ->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
            ->select(
                'rawatinaps.*',
                'histori_rawatinap.bed_id as riwayat_mutasi',
                'histori_rawatinap.created_at as tgl_mutasi',
                'histori_rawatinap.kelompokkelas_id as riwayat_kelas',
                'registrasis.poli_id',
                'registrasis.tipe_jkn',
                'registrasis.kondisi_akhir_pasien',
                'registrasis.status_reg',
                'registrasis.bayar',
                'registrasis.no_sep',
                'pasiens.nama',
                'pasiens.alamat',
                'pasiens.id',
                'pasiens.no_rm',
                'pasiens.tgllahir',
                'pasiens.kelamin',
                'pasiens.nohp');
        
        if (!empty($req->tga) && !empty($req->tgb)) {
            $tga = valid_date($req->tga) . ' 00:00:00';
            $tgb = valid_date($req->tgb) . ' 23:59:59';
            $query->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb]);
        }
        if (!empty($req->blp)) {
            $carbonBlp = \Carbon\Carbon::createFromFormat('Y-m', $req->blp);
            $bulan = $carbonBlp->month;
            $tahun = $carbonBlp->year;
    
            $query->whereMonth('rawatinaps.tgl_keluar', $bulan)
                  ->whereYear('rawatinaps.tgl_keluar', $tahun);
        }                      

        $data['irna'] = $query->get();
            

        // $data['irna']		= Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        // ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        // ->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
        // ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
        // ->where('histori_pengunjung.politipe','I')
        // ->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
        // ->select('registrasis.id as registrasi_id','registrasis.diagnosa_awal as diagnosa','histori_pengunjung.user', 'histori_pengunjung.created_at', 'registrasis.status_reg','registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',
        //   'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir','pasiens.kelamin','histori_pengunjung.politipe',
        //   'pasiens.nohp')
        // ->get();

        // return $data['visite'];die;
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.pengunjungRanap', $data)->with('no', 1);
        } elseif ($req->submit == 'CETAK') {
            $no = 1;
            $pdf = PDF::loadView('frontoffice.rekapLaporan', $data, compact('no'));
            $pdf->setPaper('A4', 'landscape');
            return view('frontoffice.rekapLaporan', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            $irna = $data['irna'];
            $tga = $req->tga;
            $tgb = $req->tgb;
            Excel::create('Laporan Pengunjung Rawat Inap ' . $tga . '/' . $tgb, function ($excel) use ($irna) {
                $excel->setTitle('Laporan Pengunjung Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Inap');
                $excel->sheet('Pengunjung Rawat Inap', function ($sheet) use ($irna) {
                    $row = 3;
                    $no = 1;
                    $sheet->row(1, ['No', ' ', 'Nama', 'No SEP', 'Kelas', 'Kamar', 'Bed', 'Riwayat Mutasi', 'Tgl Mutasi', 'Jam Mutasi', 'Tanggal Masuk', 'Jam Masuk', 'Tanggal Keluar', 'Jam Keluar', 'Hari Rawat', 'No MR', 'Ket Pulang', 'No Kwit', 'SMF','Penginput']);
                    $ceck = 0;
                    foreach ($irna as $d) {
                        $tgl1 = new DateTime(@$d->tgl_masuk);
                        $tgl2 = new DateTime(@$d->tgl_keluar);
                        $hari = $tgl2->diff($tgl1)->days + 1;
                        $_dtl = [
                            // @str_replace("Kelas", "", baca_kamar($d->kamar_id)),
                            $no++,
                            baca_carabayar($d->bayar) . ' ' . $d->bayar == 1 ? $d->tipe_jkn : '',
                            $d->nama,
                            $d->no_sep,
                            baca_kelompok($d->riwayat_kelas),
                            baca_kamar($d->kamar_id),
                            baca_bed($d->bed_id),
                            baca_bed($d->riwayat_mutasi),
                            date('d/m/Y', strtotime($d->tgl_mutasi)),
                            date('H:i', strtotime($d->tgl_mutasi)),
                            date('d/m/Y', strtotime($d->tgl_masuk)),
                            date('H:i', strtotime($d->tgl_masuk)),
                            date('d/m/Y', strtotime($d->tgl_keluar)),
                            date('H:i', strtotime($d->tgl_keluar)),
                            $hari,
                            $d->no_rm,
                            $d->kondisi_akhir_pasien ? @baca_carapulang($d->kondisi_akhir_pasien) : '',
                            '',
                            @baca_poli($d->poli_id),
                            @baca_user($d->user_id)
                        ];

                        $z = 7;
                        $sheet->row($row++, $_dtl);
                    }
                    $sheet->data = [];
                    $row++;
                    $row++;
                    $_no = 1;
                });
            })->export('xlsx');
        }
    }

    public function hapusFileRadiologi($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->radiologi);
        $data->radiologi = NULL;
        $data->update();
        Flashy::success('Dokumen Radiologi Berhasil Dihapus!');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }
    public function hapusFileResummedis($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->resummedis);
        $data->resummedis = NULL;
        $data->update();
        Flashy::success('Dokumen Resume Berhasil Dihapus!');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }
    public function hapusFileOperasi($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->operasi);
        $data->operasi = NULL;
        $data->update();
        Flashy::success('Dokumen Operasi Berhasil Dihapus!');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }
    public function hapusFileLaboratorium($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->laboratorium);
        $data->laboratorium = NULL;
        $data->update();
        Flashy::success('Dokumen Laboratorium Berhasil Dihapus!');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }
    public function hapusFilePathway($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->pathway);
        $data->pathway = NULL;
        $data->update();
        Flashy::success('Dokumen Pathway Berhasil Dihapus!');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }
    public function hapusFileEkg($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->ekg);
        $data->ekg = NULL;
        $data->update();
        Flashy::success('Dokumen EKG Berhasil Dihapus!');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }
    public function hapusFileEcho($id)
    {
        $data = \App\DokumenRekamMedis::where('id', $id)->first();
        unlink('dokumen_rekammedis/' . $data->echo);
        $data->echo = NULL;
        $data->update();
        Flashy::success('Dokumen Echo Berhasil Dihapus');
        return redirect('frontoffice/uploadDokument/' . $data->registrasi_id);
    }

    //Cari History Pasien By App Kanza

    public function searchHistoryPasien($no_rm)
    {

        session()->forget('no_rm');
        // session(['no_rm' => $no_rm]);
        $datarm = Pasien::where('id', $no_rm)->first();
        $pasien = HistoryKanza::select([
            'reg',
            'status',
            'dokter',
            'poli',
            'carabayar',
        ])->where('norm', $datarm->no_rm)->orderBy('id', 'asc');

        return DataTables::of($pasien)
            ->addColumn('jkn', function ($pasien) {
                return '<a href="/registrasi/create/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
            })
            ->addColumn('non-jkn', function ($pasien) {
                return '<a href="/registrasi/create_umum/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
            })
            ->rawColumns(['jkn', 'non-jkn'])
            ->make(true);
    }
    public function laporanReturObat()
    {
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;

        $data['returobatrusak'] = Penjualandetail::where('created_at', 'LIKE', date('Y-m-d') . '%')
            ->where('retur_inacbg', '!=', null)
            ->where('retur_kronis', '!=', null)
            ->get();
        // dd($data['returobatrusak']);

        return view('frontoffice.laporan-retur-obat', $data)->with('no', 1);
        // return view('frontoffice.laporan-retur-obat');
    }
    public function filterReturObat(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        // $data['carabayar']	= Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['returobatrusak'] = Penjualandetail::whereBetween('created_at', [$tga, $tgb])
            ->where('retur_inacbg', '!=', null)
            ->where('retur_kronis', '!=', null)
            ->get();
        // $data['po'] = Po::with(['satBeli'])->whereBetween('tanggal', [$tga, $tgb])
        //                 ->where('verifikasi', 'Y')
        //                 ->get();                

        // dd($po);
        if ($req->submit == 'TAMPILKAN') {
            // dd($data);
            return view('frontoffice.laporan-retur-obat', $data)->with('no', 1);
        } else if ($req->submit == 'CETAK') {
            // return $pemakaian; die;
            // $pdf = PDF::loadView('logistiknew.logistikmedik.laporan.pdf_lap_retur_obat', $data);
            //  $pdf->setPaper('A4', 'potret');
            // return $pdf->download('Laporan Retur Obat' . date('Y-m-d') . '.pdf');
            $pdf = PDF::loadView('frontoffice.laporan-retur-obat-pdf', compact('data'));
            return $pdf->stream();
        } elseif ($req->submit == 'EXCEL') {
            Excel::create('Laporan Retur Obat Rusak' . $tga . ' sampai ' . $tgb, function ($excel) use ($data) {
                // dd($data['po']);
                // Set the properties
                $excel->setTitle('Laporan retur Obat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan retur Obat logistik medik');
                $excel->sheet('Logistik retur Obat', function ($sheet) use ($data) {
                    // dd($data['po']);
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama PBF',
                        'No. Faktur',
                        'Nama Barang',
                        'Jumlah',
                        'Kronologi',
                        'Tindakan'
                    ]);
                    foreach ($data['returobatrusak'] as $st) {
                        $sheet->row(++$row, [
                            $no++,
                            @$st->suplier->nama,
                            @$st->logistik->bapb->no_faktur,
                            @$st->barang->nama,
                            @$st->jumlahretur,
                            @$st->keterangan,
                            @$st->status,

                        ]);
                    }
                });
            })->export('xlsx');
        }
        // dd($data);
        return view('frontoffice.laporan-retur-obat', compact('data'));
    }
    public function laporanKunjunganRawatJalan()
    {
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;
        $now                = now()->day;

        $data['kunjungan'] = HistorikunjunganIRJ::where('histori_kunjungan_irj.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->selectRaw('COUNT(case when pasiens.kelamin = "L" then 1 else null end) as kelaminLaki, COUNT(case when pasiens.kelamin = "P" then 1 else null end) as kelaminPerempuan,  COUNT(pasiens.kelamin) as jumlahKelamin, COUNT(case when registrasis.status = "lama" then 1 else null end) as lama, COUNT(case when registrasis.status = "baru" then 1 else null end) as baru, COUNT(registrasis.status) as jumlahStatus ,registrasis.poli_id as poli_id')
            ->groupBy('registrasis.poli_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'histori_kunjungan_irj.pasien_id')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'histori_kunjungan_irj.registrasi_id')
            ->get();

        return view('frontoffice.laporan-kunjungan', $data)->with('no', 1);
    }
    public function filterLaporanKunjunganRawatJalan(Request $req)
    {
        // dd($request->all());
        // $data['tga'] = $request['tga'] ? valid_date($request['tga']) : NULL;
        // $data['tgb'] = $request['tgb'] ? valid_date($request['tgb']) : NULL;
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        // $data['carabayar']	= Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        // $data['crb']		= $req->cara_bayar;

        $data['kunjungan']  = HistorikunjunganIRJ::whereBetween('histori_kunjungan_irj.created_at', [$tga, $tgb])
            ->selectRaw('COUNT(case when pasiens.kelamin = "L" then 1 else null end) as kelaminLaki, COUNT(case when pasiens.kelamin = "P" then 1 else null end) as kelaminPerempuan,  COUNT(pasiens.kelamin) as jumlahKelamin, COUNT(case when registrasis.status = "lama" then 1 else null end) as lama, COUNT(case when registrasis.status = "baru" then 1 else null end) as baru, COUNT(registrasis.status) as jumlahStatus ,registrasis.poli_id as poli_id')
            ->groupBy('registrasis.poli_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'histori_kunjungan_irj.pasien_id')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'histori_kunjungan_irj.registrasi_id')
            ->get();
        // $data['po'] = Po::with(['satBeli'])->whereBetween('tanggal', [$tga, $tgb])
        //                 ->where('verifikasi', 'Y')
        //                 ->get();                

        // dd($po);
        if ($req->submit == 'TAMPILKAN') {
            // dd($data);
            return view('frontoffice.laporan-kunjungan', $data)->with('no', 1);
        } else if ($req->submit == 'CETAK') {
            // return $pemakaian; die;
            // $pdf = PDF::loadView('logistiknew.logistikmedik.laporan.pdf_lap_retur_obat', $data);
            //  $pdf->setPaper('A4', 'potret');
            // return $pdf->download('Laporan Retur Obat' . date('Y-m-d') . '.pdf');
            // dd($data);
            $pdf = PDF::loadView('frontoffice.laporan-kunjungan-pdf', compact('data'));
            return $pdf->stream();
        } elseif ($req->submit == 'EXCEL') {
            Excel::create('Laporan Kunjungan Rawat Jalan' . $tga . ' sampai ' . $tgb, function ($excel) use ($data) {
                // dd($data['po']);
                // Set the properties
                $excel->setTitle('Laporan Kunjungan Rawat Jalan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Kunjungan Rawat Jalan');
                $excel->sheet('Logistik Kunjungan Rawat Jalan', function ($sheet) use ($data) {
                    // dd($data['po']);
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'jumlah kelamin laki-laki',
                        'jumlah kelamin perempuan',
                        'total jumlah kelamin',
                        'jumlah jenis kunjungan lama',
                        'jumlah jenis kunjungan baru',
                        'total jumlah jenis kunjungan'
                    ]);
                    foreach ($data['kunjungan'] as $st) {
                        $sheet->row(++$row, [
                            $no++,
                            baca_poli(@$st->poli_id),
                            @$st->kelaminLaki,
                            @$st->kelaminPerempuan,
                            @$st->jumlahKelamin,
                            @$st->lama,
                            @$st->baru,
                            @$st->jumlahKunjungan

                        ]);
                    }
                });
            })->export('xlsx');
        }
    }


    public function laporanKunjunganRawatInap()
    {
        $data['tga']        = "";
        $data['tgb']        = "";
        $data['crb']        = 0;
        $now                = now()->day;

        $data['kunjungan'] = HistoriRawatInap::where('histori_rawatinap.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->selectRaw('COUNT(case when polis.politype = "G" then 1 else null end) as igd, COUNT(case when polis.politype = "GP" then 1 else null end) as ponek, COUNT(case when polis.politype = "J" then 1 else null end) as rajal,  COUNT(pasiens.kelamin) as jumlahKelamin, COUNT(case when registrasis.status = "lama" then 1 else null end) as lama, COUNT(case when registrasis.status = "baru" then 1 else null end) as baru, COUNT(registrasis.status) as jumlahStatus ,histori_rawatinap.kamar_id as kamar_id, COUNT(case when registrasis.tipe_jkn = "PBI" then 1 else null end) as pbi, COUNT(case when registrasis.tipe_jkn = "NON PBI" then 1 else null end) as nonpbi, COUNT(case when registrasis.tipe_jkn = "SKTM" then 1 else null end) as sktm, COUNT(case when registrasis.tipe_jkn = "MANDIRI" then 1 else null end) as mandiri, COUNT(case when registrasis.tipe_jkn = "SWASTA" then 1 else null end) as swasta, COUNT(case when registrasis.tipe_jkn = "PNS" then 1 else null end) as pns, COUNT(case when registrasis.tipe_jkn = "P3K" then 1 else null end) as p3k, COUNT(case when registrasis.tipe_jkn = "BUMD" then 1 else null end) as bumd, COUNT(case when registrasis.tipe_jkn = "BUMN" then 1 else null end) as bumn, COUNT(case when registrasis.tipe_jkn = "POLRI" then 1 else null end) as polri, COUNT(case when registrasis.tipe_jkn = "TNI" then 1 else null end) as tni, COUNT(case when registrasis.bayar = "2" then 1 else null end) as umum, COUNT(case when registrasis.bayar = "1" then 1 else null end) as jkn')
            ->groupBy('histori_rawatinap.kamar_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'histori_rawatinap.pasien_id')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'histori_rawatinap.registrasi_id')
            ->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
            ->get();

        return view('frontoffice.laporan-kunjungan-inap', $data)->with('no', 1);
    }
    public function filterLaporanKunjunganRawatInap(Request $req)
    {
        // dd($request->all());
        // $data['tga'] = $request['tga'] ? valid_date($request['tga']) : NULL;
        // $data['tgb'] = $request['tgb'] ? valid_date($request['tgb']) : NULL;
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        // $data['carabayar']	= Carabayar::all();
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        // $data['crb']		= $req->cara_bayar;

        $data['kunjungan']  = HistoriRawatInap::whereBetween('histori_rawatinap.created_at', [$tga, $tgb])
            ->selectRaw('COUNT(case when polis.politype = "G" then 1 else null end) as igd, COUNT(case when polis.politype = "GP" then 1 else null end) as ponek, COUNT(case when polis.politype = "J" then 1 else null end) as rajal,  COUNT(pasiens.kelamin) as jumlahKelamin, COUNT(case when registrasis.status = "lama" then 1 else null end) as lama, COUNT(case when registrasis.status = "baru" then 1 else null end) as baru, COUNT(registrasis.status) as jumlahStatus ,histori_rawatinap.kamar_id as kamar_id, COUNT(case when registrasis.tipe_jkn = "PBI" then 1 else null end) as pbi, COUNT(case when registrasis.tipe_jkn = "NON PBI" then 1 else null end) as nonpbi, COUNT(case when registrasis.tipe_jkn = "SKTM" then 1 else null end) as sktm, COUNT(case when registrasis.tipe_jkn = "MANDIRI" then 1 else null end) as mandiri, COUNT(case when registrasis.tipe_jkn = "SWASTA" then 1 else null end) as swasta, COUNT(case when registrasis.tipe_jkn = "PNS" then 1 else null end) as pns, COUNT(case when registrasis.tipe_jkn = "P3K" then 1 else null end) as p3k, COUNT(case when registrasis.tipe_jkn = "BUMD" then 1 else null end) as bumd, COUNT(case when registrasis.tipe_jkn = "BUMN" then 1 else null end) as bumn, COUNT(case when registrasis.tipe_jkn = "POLRI" then 1 else null end) as polri, COUNT(case when registrasis.tipe_jkn = "TNI" then 1 else null end) as tni, COUNT(case when registrasis.bayar = "2" then 1 else null end) as umum, COUNT(case when registrasis.bayar = "1" then 1 else null end) as jkn')
            ->groupBy('histori_rawatinap.kamar_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'histori_rawatinap.pasien_id')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'histori_rawatinap.registrasi_id')
            ->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
            ->get();
        // $data['po'] = Po::with(['satBeli'])->whereBetween('tanggal', [$tga, $tgb])
        //                 ->where('verifikasi', 'Y')
        //                 ->get();                

        // dd($po);
        if ($req->submit == 'TAMPILKAN') {
            // dd($data);
            return view('frontoffice.laporan-kunjungan-inap', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            Excel::create('Laporan Kunjungan Rawat Inap', function ($excel) use ($data) {
                // dd($data['po']);
                // Set the properties
                $excel->setTitle('Laporan Kunjungan Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Kunjungan Rawat Inap');
                $excel->sheet('Logistik Kunjungan Rawat Inap', function ($sheet) use ($data) {
                    // dd($data['po']);
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'ruangan',
                        'jumlah pasien lama',
                        'jumlah pasien baru',
                        'jumlah kunjungan pasien',
                        'jumlah asal pasien igd',
                        'jumlah asal pasien ponek',
                        'jumlah asal pasien poliklinik',
                        'jumlah asal pasien',
                        'jumlah pasien Umum',
                        'jumlah pasien PBI',
                        'jumlah pasien NON PBI',
                        'jumlah pasien SKTM',
                        'jumlah pasien MANDIRI',
                        'jumlah pasien SWASTA',
                        'jumlah pasien PNS',
                        'jumlah pasien P3K',
                        'jumlah'
                    ]);
                    foreach ($data['kunjungan'] as $st) {
                        $sheet->row(++$row, [
                            $no++,
                            baca_kamar(@$st->kamar_id),
                            @$st->lama,
                            @$st->baru,
                            @$st->jumlahStatus,
                            @$st->igd,
                            @$st->ponek,
                            @$st->rajal,
                            @$st->igd + @$st->ponek + @$st->rajal,
                            @$st->umum,
                            @$st->pbi,
                            @$st->nonpbi,
                            @$st->sktm,
                            @$st->mandiri,
                            @$st->swasta,
                            @$st->pns,
                            @$st->p3k,
                            @$st->jkn + @$st->umum

                        ]);
                    }
                });
            })->export('xlsx');
        }
    }


    public function laporanRujukan()
    {
        $data['tga']        = "";
        $data['tgb']        = "";
        $now                = now()->day;

        $data['rujukan'] = [];

        return view('frontoffice.laporan-rujukan', $data)->with('no', 1);
    }

    public function filterLaporanRujukan(Request $req)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';

        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;

        $data['rujukan'] = EMR::whereBetween('emr.created_at', [$tga, $tgb])
            ->leftJoin('pasiens', 'pasiens.id', '=', 'emr.pasien_id')
            ->leftJoin('polis', 'polis.id', '=', 'emr.poli_id')
            ->leftJoin('registrasis', 'registrasis.id', '=', 'emr.registrasi_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->leftJoin('histori_rawatinap', 'histori_rawatinap.registrasi_id', '=', 'emr.registrasi_id')
            ->leftJoin('kelompok_kelas', 'kelompok_kelas.id', '=', 'histori_rawatinap.kelompokkelas_id')
            ->select(
                'pasiens.no_rm',
                'pasiens.nama',
                'pegawais.nama as nama_dokter',
                'emr.poli_id',
                'emr.unit',
                'polis.nama as nama_poli',
                'emr.assesment',
                'emr.discharge',
                'emr.created_at as tanggal_kunjungan',
                'kelompok_kelas.kelompok as ruangan'
            )
            ->get()
            ->map(function ($item) {
                // Decode JSON dari kolom discharge
                $dischargeData = json_decode($item->discharge, true);

                // Cek apakah ada data rujukan
                if (
                    isset($dischargeData['dischargePlanning']['dirujuk']) &&
                    !empty($dischargeData['dischargePlanning']['dirujuk']['diRujukKe']) &&
                    !empty($dischargeData['dischargePlanning']['dirujuk']['rsRujukan'])
                ) {
                    $dirujuk = $dischargeData['dischargePlanning']['dirujuk'];
                    $item->diRujukKe = $dirujuk['diRujukKe'];
                    $item->rsRujukanId = $dirujuk['rsRujukan'];

                    // Ambil nama rumah sakit rujukan dari tabel faskes_rujukan_rs
                    $rsRujukan = \DB::table('faskes_rujukan_rs')
                        ->where('id', $item->rsRujukanId)
                        ->value('nama_rs');

                    $item->rsRujukan = $rsRujukan;
                    return $item;
                }
                return null;
            })
            ->filter();

        // Menampilkan data dalam view atau mengekspor ke Excel
        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.laporan-rujukan', $data)->with('no', 1);
        } elseif ($req->submit == 'EXCEL') {
            Excel::create('Laporan Rujukan', function ($excel) use ($data) {
                $excel->setTitle('Laporan Rujukan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Rujukan');

                $excel->sheet('Rujukan Pasien', function ($sheet) use ($data) {
                    $row = 1;
                    $no = 1;

                    // Header Excel
                    $sheet->row($row, [
                        'No',
                        'No. RM',
                        'Nama Pasien',
                        'Tanggal Kunjungan',
                        'Dokter yang Merujuk',
                        'Unit',
                        'Asal Poliklinik',
                        'Ruangan',
                        'Diagnosa',
                        'Faskes Rujukan',
                        'Rumah Sakit Rujukan',
                    ]);

                    // Data Rujukan
                    foreach ($data['rujukan'] as $d) {
                        $sheet->row(++$row, [
                            $no++,
                            $d->no_rm,
                            $d->nama,
                            \Carbon\Carbon::parse($d->tanggal_kunjungan)->format('d-m-Y'),
                            $d->nama_dokter,
                            $d->unit,
                            $d->nama_poli,
                            $d->ruangan ?? '-',
                            $d->assesment ?? '-',
                            $d->diRujukKe,
                            $d->rsRujukan,
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function laporanPRB()
    {
        $data['tga']        = "";
        $data['tgb']        = "";
        $now                = now()->day;

        $data['prb'] = [];

        return view('frontoffice.laporan-prb', $data)->with('no', 1);
    }

    public function filterLaporanPRB(Request $req)
    {
        request()->validate([
            'tga' => 'required',
            'tgb' => 'required'
        ]);

        $tga = valid_date($req->tga) . ' 00:00:00';
        $tgb = valid_date($req->tgb) . ' 23:59:59';

        $data['tga'] = $req->tga;
        $data['tgb'] = $req->tgb;

        $data['rujukan'] = EMR::whereBetween('emr.created_at', [$tga, $tgb])
            ->leftJoin('registrasis', 'registrasis.id', '=', 'emr.registrasi_id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'emr.pasien_id')
            ->leftJoin('polis', 'polis.id', '=', 'emr.poli_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->whereRaw("LEFT(registrasis.status_reg, 1) = 'J'")
            ->where('registrasis.bayar', 1)
            ->whereRaw("
                JSON_UNQUOTE(
                    JSON_EXTRACT(emr.discharge, '$.dischargePlanning.kontrolPRB.dipilih')
                ) = 'Kontrol PRB'
            ")

            ->select(
                'pasiens.id as pasien_id',
                'registrasis.id as registrasi_id',
                'registrasis.dokter_id',
                'pasiens.no_rm',
                'pasiens.nama',
                'pegawais.nama as nama_dokter',
                'polis.nama as nama_poli',
                'emr.id as emr_id',
                'emr.unit',
                'emr.assesment',
                'emr.discharge',
                'emr.created_at as tanggal_kunjungan',
                'registrasis.created_at as tanggal_registrasi'
            )
            ->orderBy('emr.created_at', 'ASC')
            ->get()
            ->map(function ($item) {

                $discharge = json_decode($item->discharge, true);

                if (!isset($discharge['dischargePlanning']['kontrolPRB'])) {
                    return null;
                }

                $kontrolPRB = $discharge['dischargePlanning']['kontrolPRB'];

                $item->jenis_rujukan = 'PRB';
                $item->waktu_prb = $kontrolPRB['waktu'] ?? '-';

                return $item;
            })
            ->filter()
            ->values();

        if ($req->submit == 'TAMPILKAN') {
            return view('frontoffice.laporan-prb', $data)->with('no', 1);
        }

        if ($req->submit == 'EXCEL') {
            Excel::create('Laporan_PRB_Rawat_Jalan', function ($excel) use ($data) {

                $excel->setTitle('Laporan PRB Rawat Jalan');

                $excel->sheet('PRB', function ($sheet) use ($data) {
                    $row = 1;
                    $no = 1;

                    $sheet->row($row, [
                        'No',
                        'No RM',
                        'Nama Pasien',
                        'Tanggal Registrasi',
                        'Tanggal Kunjungan',
                        'Dokter',
                        'Poliklinik',
                        'Diagnosa',
                        'Jenis'
                    ]);

                    foreach ($data['rujukan'] as $d) {
                        $sheet->row(++$row, [
                            $no++,
                            $d->no_rm,
                            $d->nama,
                            \Carbon\Carbon::parse($d->tanggal_registrasi)->format('d-m-Y'),
                            \Carbon\Carbon::parse($d->tanggal_kunjungan)->format('d-m-Y'),
                            $d->nama_dokter,
                            $d->nama_poli,
                            $d->assesment ?? '-',
                            'PRB'
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function cetak_E_sep($id)
    {

        $data = Inacbg::where('id', $id)->get();
        // $data['reg'] = Registrasi::where('id', $data['inacbg'][0]->registrasi_id)->get();


        $pdf = PDF::loadView('frontoffice.cetak_e_sep', compact('data'));
        return $pdf->stream();
    }


    public function lap_kunjungan_irna()
    {
        $data['reg'] = [];
        // $data['reg'] = HistoriRawatInap::join('registrasis', 'histori_rawatinap.registrasi_id', '=', 'registrasis.id')
        //     ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->leftJoin('provinces', 'provinces.id', '=', 'pasiens.province_id')
        //     ->leftJoin('regencies', 'regencies.id', '=', 'pasiens.regency_id')
        //     ->leftJoin('districts', 'districts.id', '=', 'pasiens.district_id')
        //     ->with(['registrasi.icd9s', 'registrasi.icd10s'])
        //     ->where('histori_rawatinap.created_at', 'LIKE', date('Y-m-d') . '%')
        //     ->groupBy('histori_rawatinap.registrasi_id')
        //     ->select(
        //         'registrasis.keterangan as keterangan',
        //         'registrasis.no_sep as sep',
        //         'registrasis.bayar as bayar',
        //         'registrasis.kondisi_akhir_pasien as kondisi_akhir',
        //         'histori_rawatinap.registrasi_id',
        //         'histori_rawatinap.pasien_id',
        //         'histori_rawatinap.created_at',
        //         'histori_rawatinap.dokter_id',
        //         'histori_rawatinap.kamar_id',
        //         'pasiens.nama',
        //         'pasiens.alamat',
        //         'pasiens.no_rm',
        //         'pasiens.kelamin',
        //         'pasiens.tgllahir',
        //         'registrasis.bayar',
        //         'registrasis.status',
        //         'registrasis.tipe_jkn',
        //         'pasiens.nohp',
        //         'pasiens.ibu_kandung',
        //         'provinces.name as provinsi',
        //         'regencies.name as kabupaten',
        //         'districts.name as kecamatan'
        //     ) //PAKE AS PROVINCES
        //     ->get();

        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['pekerjaan'] = Pekerjaan::all();
        $data['tga'] = NULL;
        $data['tgb'] = NULL;
        // return $data; die;
        return view('frontoffice.lap_kunjungan_irna', $data)->with('no', 1);
    }

    public function lap_kunjungan_irna_bytanggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        // $poli = Poli::select('id')->get();
        // $pi = [];
        // foreach ($poli as $key => $d) {
        // 	$pi[] = '' . $d->id . '';
        // }

        $dokter = Pegawai::select('id')->get();
        $di = [];
        foreach ($dokter as $key => $d) {
            $di[] = '' . $d->id . '';
        }


        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
        $data['pekerjaan'] = Pekerjaan::all();


        $query =  HistoriRawatInap::join('registrasis', 'histori_rawatinap.registrasi_id', '=', 'registrasis.id')
            // ->join('perawatan_icd10s', 'histori_rawatinap.registrasi_id', '=', 'perawatan_icd10s.registrasi_id')
            // ->join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'pasiens.province_id')
            ->leftJoin('regencies', 'regencies.id', '=', 'pasiens.regency_id')
            ->leftJoin('districts', 'districts.id', '=', 'pasiens.district_id')
            ->with(['registrasi.icd9s', 'registrasi.icd10s'])
            ->whereBetween('histori_rawatinap.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
            //->groupBy('histori_rawatinap.registrasi_id')
            ->select(
                'registrasis.keterangan as keterangan',
                'registrasis.no_sep as sep',
                'registrasis.bayar as bayar',
                'registrasis.kondisi_akhir_pasien as kondisi_akhir',
                'histori_rawatinap.registrasi_id',
                'histori_rawatinap.pasien_id',
                'histori_rawatinap.created_at',
                'histori_rawatinap.dokter_id',
                'histori_rawatinap.kamar_id',
                'pasiens.nama',
                'pasiens.alamat',
                'pasiens.no_rm',
                'pasiens.kelamin',
                'pasiens.tgllahir',
                'pasiens.pekerjaan_id',
                'registrasis.bayar',
                'registrasis.status',
                'registrasis.tipe_jkn',
                'pasiens.nohp',
                'pasiens.ibu_kandung',
                'provinces.name as provinsi',
                'regencies.name as kabupaten',
                'districts.name as kecamatan'
            ); //PAKE AS PROVINCES


        if (!empty($request['jenis_pasien'])) {
            $query->where('registrasis.bayar', $request['jenis_pasien']);
        }

        if (!empty($request['tipe_jkn'])) {
            $query->where('registrasis.tipe_jkn', $request['tipe_jkn']);
        }

        if (!empty($request['pekerjaan'])) {
            $query->where('pasiens.pekerjaan_id', $request['pekerjaan']);
        }

        $data['reg'] = $query->get();
        //dd($data['reg']);
        $datareg = $data['reg'];

        if ($request['lanjut']) {
            return view('frontoffice.lap_kunjungan_irna', $data)->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan Kunjungan ' . valid_date($request['tga']) . '/' . valid_date($request['tgb']), function ($excel) use ($datareg, $request) {
                // Set the properties
                $excel->setTitle('Laporan Kunjungan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Kunjungan');
                $excel->sheet('Laporan Kunjungan', function ($sheet) use ($datareg, $request) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'No. RM',
                        'Umur',
                        'L/P',
                        'Alamat',
                        'Pekerjaan',
                        'Provinsi',
                        'Kabupaten',
                        'Kecamatan',
                        'No. HP',
                        'Ruangan',
                        'DPJP',
                        'Cara Bayar',
                        'SEP',
                        'Tipe Jkn',
                        'Tanggal',
                        'Kunjungan',
                        'Diagnosa',
                        'ICD9',
                        'Kondisi Akhir',
                        'Keterangan'

                    ]);
                    foreach ($datareg as $key => $d) {
                        $icd10 = [];
                        $dataIcd10 = NULL;
                        if ($d->registrasi) {
                            if (count($d->registrasi->icd10s) > 0) {
                                foreach ($d->registrasi->icd10s as $data) {
                                    $icd10[] = baca_icd10($data->icd10);
                                }
                                $dataIcd10 = implode("\n", $icd10);
                            }
                        }

                        // dd($d->registrasi->icd9s);
                        $icd9 = [];
                        $dataIcd9 = NULL;
                        if ($d->registrasi) {
                            if (count($d->registrasi->icd9s) > 0) {
                                foreach ($d->registrasi->icd9s as $data) {
                                    $icd9[] = baca_icd9($data->icd9);
                                }
                                $dataIcd9 = implode("\n", $icd9);
                            }
                        }

                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            $d->no_rm,
                            hitung_umur($d->tgllahir, 'Y'),
                            $d->kelamin,
                            $d->alamat,
                            @baca_pekerjaan(@$d->pekerjaan_id),
                            $d->provinsi,
                            $d->kabupaten,
                            $d->kecamatan,
                            $d->nohp,
                            @$d->kamar->nama,
                            baca_dokter($d->dokter_id),
                            baca_carabayar($d->bayar),
                            $d->sep,
                            $d->tipe_jkn,
                            tanggal($d->created_at),
                            $d->status,
                            $dataIcd10,
                            $dataIcd9,
                            @$d->registrasi ? @$d->registrasi->kondisiAkhir->namakondisi : '-',
                            @$d->keterangan
                        ]);
                    }
                });
            })->export('xlsx');
        } elseif ($request['pdf']) {
            $data['tga'] = valid_date($request['tga']) . ' 00:00:00';
            $data['tgb'] = valid_date($request['tgb']) . ' 23:59:59';
            // $tgb =  valid_date($request['tgb'];
            // $reg = $data['reg'];
            // $no = 1;
            // $pdf = PDF::loadView('frontoffice.pdf_lap_kunjungan', compact('reg', 'no'));
            // $pdf->setPaper('A4', 'landscape');
            // return $pdf->download('lap_kunjungan.pdf');
            return view('frontoffice.rekapLapKunjungan', $data)->with('no', 1);
        }
    }

    public function responseTimeIRJ(Request $req)
    {
        $data['tga'] = now()->format('d-m-Y');
        $data['tgb'] = now()->format('d-m-Y');
        $data['poli'] = Poli::where('politype', 'J')->get();

        return view('frontoffice.laporan-response-time-irj', $data);
    }
    public function responseTimeIRJExcel(Request $req)
    {
        // dd($req->all());
        if ($req->tga != null & $req->tgb != null) {
            $tga    = valid_date($req->tga) . ' 00:00:00';
            $tgb    = valid_date($req->tgb) . ' 23:59:59';
        } else {
            $tga    = now()->startOfDay()->format('Y-m-d H:i:s');
            $tgb    = now()->endOfDay()->format('Y-m-d H:i:s');
        }
        $data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->leftJoin('resep_note', 'resep_note.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('emr_inap_pemeriksaans', 'emr_inap_pemeriksaans.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('emr_inap_penilaians', 'emr_inap_penilaians.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [$tga, $tgb])
            ->where('status_reg', 'LIKE', 'J%')
            ->select('pasiens.nama', 'pasiens.no_rm', 'polis.nama as poli', 'registrasis.created_at as tanggal', 'registrasis.no_sep', 'antrians.created_at as checkin', 'antrians.updated_at as start_regis', 'registrasis.created_at as regis', 'antrian_poli.updated_at as enter_poli', 'antrian_poli.status as status_panggil', 'resep_note.created_at as eresep', 'emr_inap_pemeriksaans.created_at as asesmen', 'emr_inap_penilaians.created_at as cppt');
        if ($req->poli_id != null || $req->poli_id != '') {
            $data->where('registrasis.poli_id', $req->poli_id);
        }
        $data = $data->get();

        Excel::create('Response Time IRJ ' . $tga . '/' . $tgb, function ($excel) use ($data) {
            $excel->sheet('Response Time IRJ', function ($sheet) use ($data) {
                $sheet->loadView('frontoffice.laporan-response-time-irj-excel', compact('data'));
            });
        })->download('xlsx');
    }
    public function responseTimeIRJDataTable(Request $req)
    {
        if ($req->tga != null & $req->tgb != null) {
            $tga    = valid_date($req->tga) . ' 00:00:00';
            $tgb    = valid_date($req->tgb) . ' 23:59:59';
        } else {
            $tga    = now()->startOfDay()->format('Y-m-d H:i:s');
            $tgb    = now()->endOfDay()->format('Y-m-d H:i:s');
        }
        $data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->leftJoin('resep_note', 'resep_note.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('emr_inap_pemeriksaans', 'emr_inap_pemeriksaans.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('emr_inap_penilaians', 'emr_inap_penilaians.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [$tga, $tgb])
            ->where('status_reg', 'LIKE', 'J%')
            ->select('pasiens.nama', 'pasiens.no_rm', 'polis.nama as poli', 'registrasis.created_at as tanggal', 'registrasis.no_sep', 'antrians.created_at as checkin', 'antrians.updated_at as start_regis', 'registrasis.created_at as regis', 'antrian_poli.updated_at as enter_poli', 'antrian_poli.status as status_panggil', 'resep_note.created_at as eresep', 'emr_inap_pemeriksaans.created_at as asesmen', 'emr_inap_penilaians.created_at as cppt');
        if ($req->poli_id != null || $req->poli_id != '') {
            $data->where('registrasis.poli_id', $req->poli_id);
        }
        $no = 1;
        return DataTables::of($data)
            ->addColumn('no', function () use (&$no) {
                return $no++;
            })
            ->addColumn('no_rm', function ($data) {
                return $data->no_rm;
            })
            ->addColumn('name', function ($data) {
                return $data->nama;
            })
            ->addColumn('cara_regis', function ($data) {
                if ($data->checkin != null) {
                    $time       = '08:00:00';
                    $checkin    = date('H:i:s', strtotime($data->checkin));
                    if (Carbon::parse($checkin)->greaterThan(Carbon::parse($time))) {
                        return 'On Site';
                    } else {
                        return 'Perjanjian';
                    }
                } else {
                    return 'Online';
                }
            })
            ->addColumn('poli', function ($data) {
                return $data->poli;
            })
            ->addColumn('tanggal', function ($data) {
                return $data->tanggal ? date('d-m-Y', strtotime($data->tanggal)) : '-';
            })
            ->addColumn('checkin', function ($data) {
                $time       = '08:00';
                $checkin    = date('H:i', strtotime($data->checkin));
                if (Carbon::parse($checkin)->greaterThan(Carbon::parse($time))) {
                    return $data->checkin ? $checkin : '-';
                } else {
                    return $data->start_regis ? Carbon::parse($data->start_regis)->subMinute(5)->format('H:i') : '-';
                }
            })
            ->addColumn('start_regis', function ($data) {
                return $data->start_regis ? date('H:i', strtotime($data->start_regis)) : '-';
            })
            ->addColumn('cetak_sep', function ($data) {
                if ($data->no_sep !== null) {
                    return '<a href="/cetak-sep/' . $data->no_sep . '" target="_blank" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>';
                } else {
                    return '-';
                }
            })
            ->addColumn('regis', function ($data) {
                return $data->regis ? date('H:i', strtotime($data->regis)) : '-';
            })
            ->addColumn('enter_poli', function ($data) {
                if ($data->status_panggil == 0) {
                    return '-';
                }
                return $data->enter_poli ? date('H:i', strtotime($data->enter_poli)) : '-';
            })
            ->addColumn('proses_poli', function ($data) {
                if ($data->cppt != null) {
                    return  date('H:i', strtotime($data->cppt));
                }
                if ($data->asesmen != null) {
                    return date('H:i', strtotime($data->asesmen));
                }
                return '-';
            })
            ->addColumn('eresep', function ($data) {
                return $data->eresep ? date('H:i', strtotime($data->eresep)) : '-';
            })
            ->addColumn('tunggu_pendaftaran', function ($data) {
                if ($data->checkin != null && $data->start_regis != null) {
                    $time       = '08:00:00';
                    $checkin    = date('H:i:s', strtotime($data->checkin));
                    if (Carbon::parse($checkin)->greaterThan(Carbon::parse($time))) {
                        $diff = Carbon::parse($data->checkin)->diffInMinutes(Carbon::parse($data->start_regis));
                        return $diff == 0 ? '1 Menit' : $diff . " Menit";
                    } else {
                        return '5 Menit';
                    }
                }
                return '-';
            })
            ->addColumn('tunggu_poli', function ($data) {
                if ($data->start_regis != null && $data->status_panggil != 0) {
                    $diff = Carbon::parse($data->start_regis)->diffInMinutes(Carbon::parse($data->enter_poli));
                    return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                }
                return '-';
            })
            ->addColumn('lama_pelayanan', function ($data) {
                $time       = '08:00:00';
                $checkin    = date('H:i:s', strtotime($data->checkin));
                if (Carbon::parse($checkin)->greaterThan(Carbon::parse($time))) {
                    if ($data->checkin != null && $data->eresep != null) {
                        $diff = Carbon::parse($data->checkin)->diffInMinutes(Carbon::parse($data->eresep));
                        return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                    }
                    if ($data->checkin != null && $data->cppt != null) {
                        $diff = Carbon::parse($data->checkin)->diffInMinutes(Carbon::parse($data->cppt));
                        return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                    }
                    if ($data->checkin != null && $data->asesmen != null) {
                        $diff = Carbon::parse($data->checkin)->diffInMinutes(Carbon::parse($data->asesmen));
                        return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                    }
                } else {
                    if ($data->eresep != null) {
                        $diff = Carbon::parse($data->start_regis)->subMinute(5)->diffInMinutes(Carbon::parse($data->eresep));
                        return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                    }
                    if ($data->cppt != null) {
                        $diff = Carbon::parse($data->start_regis)->subMinute(5)->diffInMinutes(Carbon::parse($data->cppt));
                        return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                    }
                    if ($data->asesmen != null) {
                        $diff = Carbon::parse($data->start_regis)->subMinute(5)->diffInMinutes(Carbon::parse($data->asesmen));
                        return $diff == 0 ? '1 Menit' : $diff . ' Menit';
                    }
                }
            })
            ->rawColumns(['cetak_sep'])
            ->make(true);
    }

    public function laporanHarian()
    {
        $data['tga']        = now()->format('d-m-Y');
        $data['tgb']        = now()->format('d-m-Y');
        $tga                = valid_date($data['tga']) . ' 00:00:00';
        $tgb                = valid_date($data['tgb']) . ' 23:59:59';
        $data['polis']      = Poli::where('politype', 'J')->orderBy('nama')->get();
        $poli_arr           = $data['polis']->pluck('id')->toArray();
        // $registrasis        = HistorikunjunganIRJ
        //     ::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_irj.registrasi_id')
        //     ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
        //     ->whereBetween('registrasis.created_at', [$tga, $tgb])
        //     ->whereIn('registrasis.poli_id', $poli_arr)
        //     ->whereNull('registrasis.deleted_at')
        //     // ->whereIn('registrasis.bayar', [1, 2])
        //     ->select('registrasis.bayar', 'registrasis.poli_id', 'antrians.id as nomorantrian')
        //     ->get();

        $data['total_umum']     = 0;
        $data['total_jkn']      = 0;
        $data['total_online']   = 0;
        $data['total_offline']  = 0;
        $data['total_keseluruhan']  = 0;
        // $data['total_keseluruhan']  = $registrasis->count();

        // foreach ($data['polis'] as $key => $poli) {
        //     $poli->umum     = $registrasis->where('poli_id', $poli->id)->where('bayar', 2)->count();
        //     $poli->jkn      = $registrasis->where('poli_id', $poli->id)->where('bayar', 1)->count();
        //     $poli->offline  = $registrasis->where('poli_id', $poli->id)->where('nomorantrian', '!=', null)->count();
        //     $poli->online   = $registrasis->where('poli_id', $poli->id)->where('nomorantrian', null)->count();

        //     $data['total_umum']     += $poli->umum;
        //     $data['total_jkn']      += $poli->jkn;
        //     $data['total_online']   += $poli->offline;
        //     $data['total_offline']  += $poli->online;
        // }
        return view('frontoffice.laporan-harian', $data)->with('no', 1);
    }

    public function filterLaporanHarian(Request $req)
    {
        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $tga                = valid_date($req->tga) . ' 00:00:00';
        $tgb                = valid_date($req->tgb) . ' 23:59:59';
        $data['polis']      = Poli::where('politype', 'J')->orderBy('nama')->get();
        $poli_arr           = $data['polis']->pluck('id')->toArray();
        $registrasis        = HistorikunjunganIRJ
            ::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_irj.registrasi_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->whereBetween('registrasis.created_at', [$tga, $tgb])
            ->whereIn('registrasis.poli_id', $poli_arr)
            ->whereNull('registrasis.deleted_at')
            // ->whereIn('registrasis.bayar', [1, 2])
            ->select('registrasis.bayar', 'registrasis.poli_id', 'antrians.id as nomorantrian')
            ->get();

        $data['total_umum']     = 0;
        $data['total_jkn']      = 0;
        $data['total_online']   = 0;
        $data['total_offline']  = 0;
        $data['total_keseluruhan']  = $registrasis->count();

        foreach ($data['polis'] as $key => $poli) {
            $poli->umum     = $registrasis->where('poli_id', $poli->id)->where('bayar', 2)->count();
            $poli->jkn      = $registrasis->where('poli_id', $poli->id)->where('bayar', 1)->count();
            $poli->offline  = $registrasis->where('poli_id', $poli->id)->where('nomorantrian', '!=', null)->count();
            $poli->online   = $registrasis->where('poli_id', $poli->id)->where('nomorantrian', null)->count();

            $data['total_umum']     += $poli->umum;
            $data['total_jkn']      += $poli->jkn;
            $data['total_online']   += $poli->offline;
            $data['total_offline']  += $poli->online;
        }


        if ($req['excel']) {
            Excel::create('Lap. Harian ' . $tga . '/' . $tgb, function ($excel) use ($data) {
                $excel->setTitle('Laporan Harian')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Harian');
                $excel->sheet('Laporan Harian', function ($sheet) use ($data) {
                    $sheet->loadView('frontoffice.excel.laporan-harian', $data);
                });
            })->export('xls');
        } else {
            return view('frontoffice.laporan-harian', $data)->with('no', 1);
        }
    }

    public function cetakDokumen()
    {
        $registrasi = [];
        $no_rm = null;
        return view('frontoffice.cetakDokumen', compact('registrasi', 'no_rm'))->with('no', 1);
    }

    public function filterCetakDokumen(Request $request)
    {
        $no_rm = $request->no_rm;
        $pasien = Pasien::where('no_rm', $request->no_rm)->first();
        $registrasi = Registrasi::where('pasien_id', @$pasien->id)->get();
        return view('frontoffice.cetakDokumen', compact('registrasi', 'no_rm', 'pasien', 'request'))->with('no', 1);
    }

    public function lap_perawat()
    {
        $data['poli'] = Poli::all();
        $data['reg'] = [];
        return view('frontoffice.laporan-perawat', $data)->with('no', 1);
    }

    public function lap_perawatBy(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $poli = Poli::select('id')->get();
        $pi = [];
        foreach ($poli as $key => $d) {
            $pi[] = '' . $d->id . '';
        }

        $dokter = Pegawai::select('id')->get();
        $di = [];
        foreach ($dokter as $key => $d) {
            $di[] = '' . $d->id . '';
        }
        $data['cara_bayar'] = Carabayar::all();
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);


        $query =  HistorikunjunganIRJ::join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            // ->leftJoin('provinces', 'provinces.id', '=', 'pasiens.province_id')
            // ->leftJoin('regencies', 'regencies.id', '=', 'pasiens.regency_id')
            // ->leftJoin('districts', 'districts.id', '=', 'pasiens.district_id')
            ->leftJoin('emr', 'registrasis.id', '=', 'emr.registrasi_id')
            // ->with(['registrasi.icd9s', 'registrasi.icd10s'])
            ->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereNull('registrasis.deleted_at')
            ->whereIn('histori_kunjungan_irj.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
            ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
            ->select('registrasis.keterangan as keterangan', 'registrasis.no_sep as sep', 'registrasis.bayar as bayar', 'registrasis.kondisi_akhir_pasien as kondisi_akhir', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'registrasis.dokter_id', 'registrasis.bayar', 'registrasis.status', 'registrasis.tipe_jkn', 'pasiens.nohp', 'pasiens.ibu_kandung', 'emr.user_id as user_id'); //PAKE AS PROVINCES


        if (!empty($request['jenis_pasien'])) {
            $query->where('registrasis.bayar', $request['jenis_pasien']);
        }

        if (!empty($request['tipe_jkn'])) {
            $query->where('registrasis.tipe_jkn', $request['tipe_jkn']);
        }

        $data['reg'] = $query->get();
        $datareg = $data['reg'];

        if ($request['lanjut']) {
            return view('frontoffice.laporan-perawat', $data)->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan Perawat ', function ($excel) use ($data, $datareg) {
                // Set the properties
                $excel->setTitle('Laporan Perawat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Perawat');
                $excel->sheet('Laporan Perawat', function ($sheet) use ($data, $datareg) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'No. RM',
                        'SEP',
                        'L/P',
                        'Klinik Tujuan',
                        'Dokter DPJP',
                        'Cara Bayar',
                        'Perawat',
                        'Tanggal',

                    ]);
                    foreach ($datareg as $key => $d) {
                        $user = \Modules\Pegawai\Entities\Pegawai::where('user_id', $d->user_id)->first();

                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            $d->no_rm,
                            $d->sep,
                            $d->kelamin,
                            baca_poli($d->poli_id),
                            baca_dokter($d->dokter_id),
                            baca_carabayar($d->bayar) . ' ' . (($d->bayar == 1) ? $d->tipe_jkn : NULL),
                            @$user->kategori_pegawai != 1 ? @$user->nama : '-',
                            $d->created_at->format('d-m-Y'),
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }
    public function lap_penunjang()
    {
        $data['poli'] = Poli::all();
        $data['reg'] = [];
        return view('frontoffice.laporan-penunjang', $data)->with('no', 1);
    }

    public function lap_penunjangBy(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $poli = Poli::select('id')->get();
        $pi = [];
        foreach ($poli as $key => $d) {
            $pi[] = '' . $d->id . '';
        }

        $dokter = Pegawai::select('id')->get();
        $di = [];
        foreach ($dokter as $key => $d) {
            $di[] = '' . $d->id . '';
        }
        $data['cara_bayar'] = Carabayar::all();
        $data['poli'] = Poli::select('nama', 'id')->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);


        $data['rad_umum'] =  HistorikunjunganRAD::join('registrasis', 'histori_kunjungan_rad.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('histori_kunjungan_rad.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', '!=', '1')
            ->get()->count();
        $data['rad_jkn'] =  HistorikunjunganRAD::join('registrasis', 'histori_kunjungan_rad.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('histori_kunjungan_rad.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', '1')
            ->get()->count();

        $data['lab_anatomi_umum'] =  Hasillab::leftJoin('registrasis', 'hasillabs.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', '!=', '1')
            ->where('hasillabs.no_lab', 'like', '%LABR%')
            ->groupBy('hasillabs.registrasi_id')
            ->whereNull('registrasis.deleted_at')
            ->get()->count();
        // dd($data['lab_anatomi_umum']);

        $data['lab_anatomi_jkn'] =  Hasillab::leftJoin('registrasis', 'hasillabs.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', '1')
            ->where('hasillabs.no_lab', 'like', '%LABR%')
            ->groupBy('hasillabs.registrasi_id')
            ->whereNull('registrasis.deleted_at')
            ->get()->count();

        $data['lab_jkn'] =  Hasillab::leftJoin('registrasis', 'hasillabs.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', '1')
            ->where('hasillabs.no_lab', 'not like', '%LABR%')
            ->groupBy('hasillabs.registrasi_id')
            ->whereNull('registrasis.deleted_at')
            ->get()->count();

        $data['lab_umum'] =  Hasillab::leftJoin('registrasis', 'hasillabs.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', '!=', '1')
            ->where('hasillabs.no_lab', 'not like', '%LABR%')
            ->groupBy('hasillabs.registrasi_id')
            ->whereNull('registrasis.deleted_at')
            ->get()->count();

        $data['farmasi_jkn'] =  Folio::join('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', '1')
            ->whereNull('registrasis.deleted_at')
            ->where('folios.jenis', 'ORJ')
            ->groupBy('folios.registrasi_id')
            ->get()->count();

        $data['farmasi_umum'] =  Folio::join('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
            ->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('registrasis.bayar', '!=', '1')
            ->where('folios.jenis', 'ORJ')
            ->whereNull('registrasis.deleted_at')
            ->groupBy('folios.registrasi_id')
            ->get()->count();

        $data['reg'] = '';
        $datareg = $data['reg'];

        if ($request['lanjut']) {
            return view('frontoffice.laporan-penunjang', $data)->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan Penunjang ', function ($excel) use ($data, $datareg) {
                // Set the properties
                $excel->setTitle('Laporan Penunjang')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Perawat');
                $excel->sheet('Laporan Perawat', function ($sheet) use ($data, $datareg) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'Nama',
                        'No. RM',
                        'SEP',
                        'L/P',
                        'Klinik Tujuan',
                        'Dokter DPJP',
                        'Cara Bayar',
                        'Perawat',
                        'Tanggal',

                    ]);
                    foreach ($datareg as $key => $d) {
                        $user = \Modules\Pegawai\Entities\Pegawai::where('user_id', $d->user_id)->first();

                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            $d->no_rm,
                            $d->sep,
                            $d->kelamin,
                            baca_poli($d->poli_id),
                            baca_dokter($d->dokter_id),
                            baca_carabayar($d->bayar) . ' ' . (($d->bayar == 1) ? $d->tipe_jkn : NULL),
                            @$user->kategori_pegawai != 1 ? @$user->nama : '-',
                            $d->created_at->format('d-m-Y'),
                        ]);
                    }
                });
            })->export('xlsx');
        }
    }

    public function antrianRealtime()
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        session()->forget(['dokter', 'pelaksana', 'perawat']);

        // $exceptPoli = Poli::where('bpjs', '!=','HDL')->where('politype', 'J')->pluck('id');
        $exceptPoli = Poli::where('politype', 'J')->pluck('id');
        $poli_id            = Auth::user()->poli_id;
        $data['carabayar']     = Carabayar::all('carabayar', 'id');
        $data['tiket']         = MasterEtiket::all('nama', 'id');
        $data['cara_minum'] = Aturanetiket::all('aturan', 'id');
        $data['takaran']     = TakaranobatEtiket::all('nama', 'nama');
        $poli_id            = Auth::user()->poli_id;
        $data['jenisJkn'] = Jenisjkn::all();
        $data['tga']        = now()->format('d-m-Y');
        $data['tgb']        = now()->format('d-m-Y');
        $data['filter_reg'] = 'Semua';
        $data['filter_poli']     = '';
        $data['filter_jenisJkn']     = '';
        $data['filter_koding'] = '';
        $data['registrasi']    = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->with(['registrasi', 'poli', 'pasien', 'registrasi.uji_fungsi', 'registrasi.program_terapi', 'registrasi.layanan_rehab'])
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', '1')
            ->whereIn('registrasis.poli_id', $exceptPoli)
            ->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d') . '%')
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC');

        $data['poli'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')
            ->groupBy('poli_id')
            ->select('poli_id')
            ->get();
        // dd($data['poli']);

        if ($poli_id != '') {
            $poli_id = explode(",", $poli_id);
            // $data['poli']		= Poli::whereIn('id', $poli_id)->pluck('nama', 'id');
            $data['registrasi']->whereIn('histori_kunjungan_irj.poli_id', $poli_id);
        }

        $data['registrasi'] = $data['registrasi']->select('registrasis.id as id', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.id as id_kunjungan', 'antrian_poli.status', 'antrian_poli.nomor as nomor_antrian', 'antrian_poli.kelompok as kelompok_antrian', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.created_at', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.no_sep', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.input_from', 'pasiens.nama', 'pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.tgllahir', 'registrasis.tte_resume_pasien', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'registrasis.is_koding');

        // if (Auth::user()->id == 570 || Auth::user()->id == 574) {
        // 	$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'I1', 'I2', 'I3'])->get();
        // } else {
        // 	$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])->get();
        // }


        // Ordering
        // foreach ($data['registrasi'] as $key => $d) {
        // 	if ($d->input_from == 'KIOSK Reservasi Lama' || $d->input_from == 'KIOSK Reservasi Baru') {
        // 		$d->cara_registrasi = 'Registrasi Online';
        // 	} elseif ($d->input_from == 'registrasi-ranap-langsung') {
        // 		$d->cara_registrasi = 'Registrasi Ranap Langsung';
        // 	} elseif ($d->input_from == 'regperjanjian' || $d->input_from == 'regperjanjian_lama' || $d->input_from == 'regperjanjian_baru' || $d->input_from == 'regperjanjian_online') {
        // 		$d->cara_registrasi = 'Registrasi Perjanjian';
        // 	} elseif ($d->input_from == 'registrasi-1' || $d->input_from == 'registrasi-2' || $d->input_from == 'registrasi-3' || $d->input_from == 'registrasi-4') {
        // 		$d->cara_registrasi = 'Registrasi Onsite';
        // 	} else {
        // 		$d->cara_registrasi = 'Registrasi';
        // 	}

        // 	if (!baca_nomorantrian_bpjs(@$d->nomorantrian)) {
        // 		// Bukan Online / JKN
        // 		$d->kelompok_   = $d->kelompok_antrian;
        // 		$d->urutan_     = intval($d->nomor_antrian);
        // 	} else {
        // 		// Online JKN
        // 		$d->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$d->nomorantrian))[1];
        // 		$d->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$d->nomorantrian))[2]);
        // 	}
        // 	$resepNote = ResepNote::where('registrasi_id', $d->id)->whereNotNull('nomor')->select('id')->first();
        // 	$data['registrasi'][$key]['resepNoteId'] = $resepNote ? $resepNote->id : null;
        // }
        // $data['registrasi'] = $data['registrasi']->sortBy(function ($reg) {
        // 	return [$reg['kelompok_'], $reg['urutan_']];
        // });
        $data['registrasi'] =      $data['registrasi']->get();
        return view('frontoffice.antrian_realtime', $data)->with('no', 1);
    }


    public function hasilUpload($registrasi_id)
    {
        $data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'LAINNYA')->get();
        $data['reg'] = Registrasi::find($registrasi_id);
        return view('frontoffice.view-upload', $data)->with('no', 1);
    }

    public function uploadOperasi($registrasi_id)
    {
        $data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'operasi')->get();
        $data['reg'] = Registrasi::find($registrasi_id);
        return view('frontoffice.view-upload-operasi', $data)->with('no', 1);
    }

    public function antrianRealtime_byTanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        // dd('tindakan by tanggal');
        // $exceptPoli = Poli::where('bpjs', '!=','HDL')->where('politype', 'J')->pluck('id');
        $exceptPoli = Poli::where('politype', 'J')->pluck('id');
        $poli_id                = "";
        $data['carabayar']         = Carabayar::all('carabayar', 'id');
        $data['tiket']             = MasterEtiket::all('nama', 'id');
        $data['cara_minum']     = Aturanetiket::all('aturan', 'id');
        $data['takaran']         = TakaranobatEtiket::all('nama', 'nama');
        $data['jenisJkn'] = Jenisjkn::all();
        $data['filter_reg']     = $request['filter_reg'];
        $data['filter_poli']     = $request['filter_poli'];
        $data['filter_jenisJkn']     = $request['filter_jenisJkn'];
        $data['filter_koding'] = $request['filter_koding'];
        request()->validate(['tga' => 'required']);
        // request()->validate(['tgb' => 'required']);
        $data['tga']            = now()->format('d-m-Y');
        $data['tgb']            = now()->format('d-m-Y');
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['poli'] = Registrasi::
            // whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            where('created_at', 'like', valid_date($request['tga']) . '%')
            ->groupBy('poli_id')
            ->whereNotNull('poli_id')
            ->select('poli_id')
            ->get();
        // dd(valid_date($request['tga']));

        $data['registrasi']    = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->with(['registrasi', 'poli', 'pasien', 'registrasi.uji_fungsi', 'registrasi.program_terapi', 'registrasi.layanan_rehab'])
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', '1')
            ->where('histori_kunjungan_irj.created_at', 'like', valid_date($request['tga']) . '%')
            ->whereIn('registrasis.poli_id', $exceptPoli)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC');

        // ->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);

        // if ($poli_id != '') {
        // 	$poli_id = explode(",", $poli_id);
        // $data['poli']		= Poli::where('politype', 'J')->pluck('nama', 'id');
        // dd($data['poli']);
        if ($request->filter_poli) {
            $data['registrasi']->where('histori_kunjungan_irj.poli_id', $request->filter_poli);
        }

        if ($request->filter_jenisJkn) {
            $jenisJkn = Jenisjkn::find($request->filter_jenisJkn);
            $data['registrasi']->where('registrasis.tipe_jkn', $jenisJkn->nama);
        }

        if ($request->filter_koding) {
            if ($request->filter_koding == 'sudah') {
                $data['registrasi']->where('registrasis.is_koding', 1);
            } elseif ($request->filter_koding == 'belum') {
                $data['registrasi']->where(function ($q) {
                    $q->whereNull('registrasis.is_koding')
                    ->orWhere('registrasis.is_koding', 0);
                });
            }
        }
        // }

        // if (!empty($request['filter_reg'])) {
        // 	if ($request['filter_reg'] == "Pendaftaran Onsite") {
        // 		$data['registrasi'] = $data['registrasi']->whereNotNull('antrians.id');
        // 	} elseif ($request['filter_reg'] == "Pendaftaran Online") {
        // 		$data['registrasi'] = $data['registrasi']->whereNull('antrians.id')->where('registrasis.input_from', 'LIKE', '%KIOSK Reservasi%');
        // 	} elseif ($request['filter_reg'] == "registrasi-ranap-langsung") {
        // 		$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', '=', 'registrasi-ranap-langsung');
        // 	} elseif ($request['filter_reg'] == "regperjanjian") {
        // 		$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', 'like', '%regperjanjian%');
        // 	} elseif ($request['filter_reg'] == "Registrasi") {
        // 		$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', '!=', 'registrasi-ranap-langsung')->where('registrasis.input_from', 'notlike', '%regperjanjian%');
        // 	} elseif ($request['filter_reg'] == "Semua") {
        //     }
        // }
        // $data['registrasi'] = $data['registrasi'];


        $data['registrasi'] = $data['registrasi']->select('registrasis.id as id', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.id as id_kunjungan', 'antrian_poli.status', 'antrian_poli.nomor as nomor_antrian', 'antrian_poli.kelompok as kelompok_antrian', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.created_at', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.no_sep', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.input_from', 'pasiens.nama', 'pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.tgllahir', 'registrasis.tte_resume_pasien', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar',);
        // dd($data['registrasi'][11]);
        $data['registrasi']  = $data['registrasi']->get();
        return view('frontoffice.antrian_realtime', $data)->with('no', 1);
    }
    public function antrianRealtimeInap()
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        session()->forget(['dokter', 'pelaksana', 'perawat']);

        $exceptPoli = Poli::where('bpjs', '!=', 'HDL')->where('politype', 'J')->pluck('id');
        $poli_id            = Auth::user()->poli_id;
        $data['carabayar']     = Carabayar::all('carabayar', 'id');
        $data['tiket']         = MasterEtiket::all('nama', 'id');
        $data['cara_minum'] = Aturanetiket::all('aturan', 'id');
        $data['takaran']     = TakaranobatEtiket::all('nama', 'nama');
        $data['list_kamar']     = Kamar::all('nama', 'id');
        $data['jenisJkn'] = Jenisjkn::all();
        $poli_id            = Auth::user()->poli_id;
        $data['tga']        = now()->format('d-m-Y');
        $data['tgb']        = now()->format('d-m-Y');
        $data['tgp']        = now()->format('d-m-Y');
        $data['filter_reg'] = 'Semua';
        $data['filter_kamar']     = '';
        $data['filter_crb']     = '';
        $data['filter_jenisJkn']     = '';
        $data['filter_koding'] = '';
        $data['registrasi'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->with(['dokter_ahli', 'registrasi', 'registrasi.konsul', 'registrasi.kematian', 'registrasi.apgar_score', 'registrasi.triage'])
            ->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
            ->leftJoin('kamars', 'kamars.id', 'rawatinaps.kamar_id')
            ->leftJoin('beds', 'beds.id', 'rawatinaps.bed_id')
            ->leftJoin('kelas', 'kelas.id', 'rawatinaps.kelas_id')
            ->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
            ->where('registrasis.status_reg', 'like', 'I%')
            ->whereNull('rawatinaps.deleted_at')
            ->whereNull('registrasis.deleted_at')
            ->where('rawatinaps.tgl_masuk', 'like', valid_date($data['tga']) . '%')
            ->orderBy('rawatinaps.id', 'DESC');
        // dd($data['registrasi']);
        // if (Auth::user()->id == 570 || Auth::user()->id == 574) {
        // 	$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'I1', 'I2', 'I3'])->get();
        // } else {
        // 	$data['registrasi']	= $data['registrasi']->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])->get();
        // }


        // Ordering
        // foreach ($data['registrasi'] as $key => $d) {
        // 	if ($d->input_from == 'KIOSK Reservasi Lama' || $d->input_from == 'KIOSK Reservasi Baru') {
        // 		$d->cara_registrasi = 'Registrasi Online';
        // 	} elseif ($d->input_from == 'registrasi-ranap-langsung') {
        // 		$d->cara_registrasi = 'Registrasi Ranap Langsung';
        // 	} elseif ($d->input_from == 'regperjanjian' || $d->input_from == 'regperjanjian_lama' || $d->input_from == 'regperjanjian_baru' || $d->input_from == 'regperjanjian_online') {
        // 		$d->cara_registrasi = 'Registrasi Perjanjian';
        // 	} elseif ($d->input_from == 'registrasi-1' || $d->input_from == 'registrasi-2' || $d->input_from == 'registrasi-3' || $d->input_from == 'registrasi-4') {
        // 		$d->cara_registrasi = 'Registrasi Onsite';
        // 	} else {
        // 		$d->cara_registrasi = 'Registrasi';
        // 	}

        // 	if (!baca_nomorantrian_bpjs(@$d->nomorantrian)) {
        // 		// Bukan Online / JKN
        // 		$d->kelompok_   = $d->kelompok_antrian;
        // 		$d->urutan_     = intval($d->nomor_antrian);
        // 	} else {
        // 		// Online JKN
        // 		$d->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$d->nomorantrian))[1];
        // 		$d->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$d->nomorantrian))[2]);
        // 	}
        // 	$resepNote = ResepNote::where('registrasi_id', $d->id)->whereNotNull('nomor')->select('id')->first();
        // 	$data['registrasi'][$key]['resepNoteId'] = $resepNote ? $resepNote->id : null;
        // }
        // $data['registrasi'] = $data['registrasi']->sortBy(function ($reg) {
        // 	return [$reg['kelompok_'], $reg['urutan_']];
        // });
        $data['registrasi'] =      $data['registrasi']->get();
        return view('frontoffice.antrian_realtime_inap', $data)->with('no', 1);
    }


    public function antrianRealtimeInap_byTanggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');
        // dd('tindakan by tanggal');
        $exceptPoli = Poli::where('bpjs', '!=', 'HDL')->where('politype', 'J')->pluck('id');
        $poli_id                = "";
        $data['carabayar']         = Carabayar::all('carabayar', 'id');
        $data['tiket']             = MasterEtiket::all('nama', 'id');
        $data['cara_minum']     = Aturanetiket::all('aturan', 'id');
        $data['takaran']         = TakaranobatEtiket::all('nama', 'nama');
        $data['list_kamar']     = Kamar::all('nama', 'id');
        $data['jenisJkn'] = Jenisjkn::all();
        $data['filter_reg']     = $request['filter_reg'];
        $data['filter_kamar']     = $request['filter_kamar'];
        $data['filter_crb']     = $request['filter_crb'];
        $data['filter_jenisJkn']     = $request['filter_jenisJkn'];
        $data['filter_koding'] = $request['filter_koding'];
        request()->validate(['tga' => 'required']);
        // request()->validate(['tgb' => 'required']);
        $data['tga']            = now()->format('d-m-Y');
        $data['tgb']            = now()->format('d-m-Y');
        $data['tgp']            = $request['tgp'] ?? now()->format('d-m-Y');
        $data['blp']            = $request->input('blp', now()->format('Y-m'));
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['poli'] = Registrasi::
            // whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            where('created_at', 'like', valid_date($request['tga']) . '%')
            ->groupBy('poli_id')
            ->whereNotNull('poli_id')
            ->select('poli_id')
            ->get();
        // dd(valid_date($request['tga']));

        // $data['registrasi']    = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
        //     ->with(['registrasi', 'poli', 'pasien'])
        //     ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
        //     ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
        //     ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
        //     ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
        //     ->whereNull('registrasis.deleted_at')
        //     ->where('registrasis.bayar','1')
        //     ->where('histori_kunjungan_irj.created_at','like', valid_date($request['tga']).'%')
        //     ->whereIn('registrasis.poli_id', $exceptPoli)
        //     ->orderBy('histori_kunjungan_irj.created_at', 'ASC');

        // ->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59']);

        // if ($poli_id != '') {
        // 	$poli_id = explode(",", $poli_id);
        // $data['poli']		= Poli::where('politype', 'J')->pluck('nama', 'id');
        // dd($data['poli']);
        // if ($request->filter_poli) {
        //     $data['registrasi']->where('histori_kunjungan_irj.poli_id', $request->filter_poli);
        // }
        // }

        // if (!empty($request['filter_reg'])) {
        // 	if ($request['filter_reg'] == "Pendaftaran Onsite") {
        // 		$data['registrasi'] = $data['registrasi']->whereNotNull('antrians.id');
        // 	} elseif ($request['filter_reg'] == "Pendaftaran Online") {
        // 		$data['registrasi'] = $data['registrasi']->whereNull('antrians.id')->where('registrasis.input_from', 'LIKE', '%KIOSK Reservasi%');
        // 	} elseif ($request['filter_reg'] == "registrasi-ranap-langsung") {
        // 		$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', '=', 'registrasi-ranap-langsung');
        // 	} elseif ($request['filter_reg'] == "regperjanjian") {
        // 		$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', 'like', '%regperjanjian%');
        // 	} elseif ($request['filter_reg'] == "Registrasi") {
        // 		$data['registrasi'] = $data['registrasi']->where('registrasis.input_from', '!=', 'registrasi-ranap-langsung')->where('registrasis.input_from', 'notlike', '%regperjanjian%');
        // 	} elseif ($request['filter_reg'] == "Semua") {
        //     }
        // }
        // $data['registrasi'] = $data['registrasi'];

        $data['registrasi'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->with(['dokter_ahli', 'registrasi', 'registrasi.konsul', 'registrasi.kematian', 'registrasi.apgar_score', 'registrasi.triage'])
            ->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
            ->leftJoin('kamars', 'kamars.id', 'rawatinaps.kamar_id')
            ->leftJoin('beds', 'beds.id', 'rawatinaps.bed_id')
            ->leftJoin('kelas', 'kelas.id', 'rawatinaps.kelas_id')
            ->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
            ->where('registrasis.status_reg', 'like', 'I%')
            ->whereNull('rawatinaps.deleted_at')
            ->whereNull('registrasis.deleted_at')
            ->orderBy('rawatinaps.id', 'DESC');
        // dd($data['registrasi']);
        // $data['registrasi'] = $data['registrasi']->select('registrasis.id as id', 'histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.id as id_kunjungan', 'antrian_poli.status', 'antrian_poli.nomor as nomor_antrian', 'antrian_poli.kelompok as kelompok_antrian', 'registrasis.antrian_poli_id', 'histori_kunjungan_irj.created_at', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.dokter_id', 'histori_kunjungan_irj.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.no_sep', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.input_from', 'pasiens.nama', 'pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.tgllahir', 'registrasis.tte_resume_pasien', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar',);
        // dd($data['registrasi'][11]);
        // if ($request->tgp) {
        //     $data['registrasi']->where('rawatinaps.tgl_keluar', 'like', '%' . valid_date($request['tgp']) . '%');
        // } else {
        //     $data['registrasi']->where('rawatinaps.tgl_masuk', 'like', '%' . valid_date($request['tga']) . '%');
        // }

        if ($request->filled('blp')) {
            [$tahun, $bulan] = explode('-', $request->blp);
            $data['registrasi']->whereYear('rawatinaps.tgl_keluar', $tahun)
                               ->whereMonth('rawatinaps.tgl_keluar', $bulan);
        }
        elseif ($request->filled('tgp')) {
            $data['registrasi']->whereDate('rawatinaps.tgl_keluar', valid_date($request->tgp));
        }
        else {
            $data['registrasi']->whereDate('rawatinaps.tgl_masuk', valid_date($request->tga));
        }        

        if ($request->filter_kamar) {
            $data['registrasi']->where('rawatinaps.kamar_id', $request->filter_kamar);
        }

        if ($request->filter_crb) {
            $data['registrasi']->where('registrasis.bayar', $request->filter_crb);
        }

        if ($request->filter_jenisJkn) {
            $jenisJkn = Jenisjkn::find($request->filter_jenisJkn);
            $data['registrasi']->where('registrasis.tipe_jkn', $jenisJkn->nama);
        }

        if ($request->filter_koding) {
            if ($request->filter_koding == 'sudah') {
                $data['registrasi']->where('registrasis.is_koding', 1);
            } elseif ($request->filter_koding == 'belum') {
                $data['registrasi']->where(function ($q) {
                    $q->whereNull('registrasis.is_koding')
                    ->orWhere('registrasis.is_koding', 0);
                });
            }
        }

        $data['registrasi']  = $data['registrasi']->get();
        return view('frontoffice.antrian_realtime_inap', $data)->with('no', 1);
    }


    public function antrianRealtimeIgd(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        session()->forget(['dokter', 'pelaksana', 'perawat']);

        $poliIGD = Poli::where('politype', 'G')->pluck('id');
        $data['carabayar']     = Carabayar::all('carabayar', 'id');
        $data['tiket']         = MasterEtiket::all('nama', 'id');
        $data['cara_minum'] = Aturanetiket::all('aturan', 'id');
        $data['takaran']     = TakaranobatEtiket::all('nama', 'nama');
        $data['tga']        = now()->format('d-m-Y');
        $data['tgb']        = now()->format('d-m-Y');
        $data['filter_reg'] = 'Semua';
        $data['filter_poli']     = '';
        $data['filter_koding'] = '';
        $data['registrasi']    = HistorikunjunganIGD::leftJoin('registrasis', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
            ->with(['registrasi', 'pasien', 'registrasi.hasilLab_patalogi', 'registrasi.triage', 'registrasi.kematian', 'registrasi.paps', 'registrasi.rujukan_rumah_sakit'])
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', '1')
            ->whereIn('registrasis.poli_id', $poliIGD)
            ->where('histori_kunjungan_igd.created_at', 'LIKE', date('Y-m-d') . '%')
            ->orderBy('histori_kunjungan_igd.created_at', 'ASC');

        $data['poli'] = Poli::where('politype', 'G')->get();

        $data['registrasi'] = $data['registrasi']->select('registrasis.id as id', 'histori_kunjungan_igd.registrasi_id', 'histori_kunjungan_igd.id as id_kunjungan', 'histori_kunjungan_igd.created_at', 'histori_kunjungan_igd.pasien_id', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_reg', 'registrasis.bayar', 'registrasis.no_sep', 'registrasis.id', 'registrasis.status_reg', 'registrasis.nomorantrian', 'registrasis.input_from', 'pasiens.nama', 'pasiens.no_jkn', 'pasiens.no_rm', 'pasiens.tgllahir', 'registrasis.tte_resume_pasien', 'pegawais.nama as dokter_dpjp', 'carabayars.carabayar', 'registrasis.is_koding');

        $data['registrasi'] =      $data['registrasi']->get();
        $data['dt_paging'] =true;
        $data['search'] = false;
        return view('frontoffice.antrian_realtime_igd', $data)->with('no', 1);
    }

    public function antrianRealtimeIgd_byTanggal(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10000M');

        session()->forget(['dokter', 'pelaksana', 'perawat']);

        $request->validate([
            'tga'         => ['required_without:blp', 'date_format:d-m-Y'],
            'blp'         => ['nullable', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'filter_poli' => ['nullable','exists:polis,id'],
            'nama'        => ['nullable','string','max:100'],
            'dt_paging'   => ['nullable','boolean'],
        ]);

        if ($request->filled('blp')) {
            return $this->antrianRealtimeIgd_byBulan($request);
        }

        $data['carabayar']  = Carabayar::all('carabayar', 'id');
        $data['tiket']      = MasterEtiket::all('nama', 'id');
        $data['cara_minum'] = Aturanetiket::all('aturan', 'id');
        $data['takaran']    = TakaranobatEtiket::all('nama', 'nama');

        $data['blp']         = null;
        $data['tga']         = $request->input('tga', now()->format('d-m-Y'));
        $data['tgb']         = now()->format('d-m-Y');
        $data['filter_reg']  = $request->input('filter_reg');
        $data['filter_poli'] = $request->input('filter_poli');
        $data['filter_koding'] = $request->input('filter_koding');
        $data['nama']        = trim((string) $request->input('nama', ''));

        $tgaYmd = valid_date($data['tga']);
        $start  = \Carbon\Carbon::parse($tgaYmd)->startOfDay();
        $end    = (clone $start)->endOfDay();

        $q = HistorikunjunganIGD::query()
            ->join('registrasis', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
            ->join('polis as pg', function ($j) {
                $j->on('pg.id', '=', 'registrasis.poli_id')
                ->where('pg.politype', 'G');
            })
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->whereNull('pasiens.deleted_at')
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', 1)
            ->whereBetween('histori_kunjungan_igd.created_at', [$start, $end])
            ->orderBy('histori_kunjungan_igd.created_at', 'ASC');

        if ($data['filter_poli']) {
            $q->where('registrasis.poli_id', $data['filter_poli']);
        }

        if (filled($data['nama'])) {
            $keyword = str_replace(['%', '_'], ['\%', '\_'], $data['nama']); // escape wildcard
            $q->where(function ($sub) use ($keyword) {
                $sub->where('pasiens.no_rm', 'like', "%{$keyword}%")
                    ->orWhere('pasiens.nama',  'like', "%{$keyword}%");
            });
        }
        if ($data['filter_koding']) {
            if ($request->filter_koding == 'sudah') {
                $q->where('registrasis.is_koding', 1);
            } elseif ($request->filter_koding == 'belum') {
                $q->where(function ($sub) {
                    $sub->whereNull('registrasis.is_koding')
                        ->orWhere('registrasis.is_koding', 0);
                });
            }
        }

        $data['poli'] = Poli::where('politype', 'G')->get();

        $select = [
            'histori_kunjungan_igd.id as id',
            'histori_kunjungan_igd.registrasi_id',
            'histori_kunjungan_igd.id as id_kunjungan',
            'histori_kunjungan_igd.created_at',
            'histori_kunjungan_igd.pasien_id',

            'registrasis.id as registrasi_id',
            'registrasis.dokter_id',
            'registrasis.poli_id',
            'registrasis.created_at as tgl_reg',
            'registrasis.tgl_pulang',
            'registrasis.bayar',
            'registrasis.no_sep',
            'registrasis.status_reg',
            'registrasis.nomorantrian',
            'registrasis.input_from',
            'registrasis.tte_resume_pasien',
            'registrasis.is_koding',
            'registrasis.tte_hasillab_lis',

            'pasiens.no_rm as pasien_no_rm',
            'pasiens.nama as pasien_nama',
            'pasiens.no_jkn as pasien_no_jkn',
            'pasiens.tgllahir as pasien_tgllahir',
            'pasiens.kelamin',

            'pegawais.nama as dokter_dpjp',
            'carabayars.carabayar',

            'rawatinaps.kamar_id as rawat_inap_kamar',
        ];

        $registrasi = $q->select($select)->get();

        $data['registrasi'] = $registrasi;
        $data['no'] = 1;

        $data['dt_paging'] = true;
        $data['search'] = false;

        if ($request->ajax()) {
            return view('frontoffice.view_ajax_antrianRealtimeIGD', $data);
        }

        return view('frontoffice.antrian_realtime_igd', $data);
    }

    public function antrianRealtimeIgd_byBulan(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10000M');

        session()->forget(['dokter', 'pelaksana', 'perawat']);

        $request->validate([
            'blp'         => ['nullable', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'filter_poli' => ['nullable','exists:polis,id'],
            'nama'        => ['nullable','string','max:100'],
            'tga'         => ['nullable','date'], 
        ]);

        $data['carabayar']  = Carabayar::all('carabayar', 'id');
        $data['tiket']      = MasterEtiket::all('nama', 'id');
        $data['cara_minum'] = Aturanetiket::all('aturan', 'id');
        $data['takaran']    = TakaranobatEtiket::all('nama', 'nama');

        $data['blp']         = $request->input('blp');          
        $data['tga']         = $request->input('tga', now()->format('d-m-Y')); 
        $data['tgb']         = now()->format('d-m-Y');
        $data['filter_reg']  = $request->input('filter_reg');
        $data['filter_poli'] = $request->input('filter_poli');
        $data['filter_koding'] = $request->input('filter_koding');
        $data['nama']        = trim((string) $request->input('nama', ''));

        [$tahun, $bulan] = explode('-', $data['blp']);
        $start = \Carbon\Carbon::createFromDate((int)$tahun, (int)$bulan, 1)->startOfDay();
        $end   = (clone $start)->endOfMonth()->endOfDay();

        $q = HistorikunjunganIGD::query()
            ->join('registrasis', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
            ->join('polis as pg', function ($j) {
                $j->on('pg.id', '=', 'registrasis.poli_id')
                ->where('pg.politype', 'G');
            })
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrians', 'antrians.id', '=', 'registrasis.antrian_id')
            ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
            ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
            ->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
            ->whereNull('pasiens.deleted_at')
            ->whereNull('registrasis.deleted_at')
            ->where('registrasis.bayar', 1)
            ->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3'])
            ->whereBetween('registrasis.tgl_pulang', [$start, $end])
            ->orderBy('registrasis.tgl_pulang', 'ASC');

        if ($data['filter_poli']) {
            $q->where('registrasis.poli_id', $data['filter_poli']);
        }

        if (filled($data['nama'])) {
            $keyword = str_replace(['%', '_'], ['\%', '\_'], $data['nama']); 
            $q->where(function ($sub) use ($keyword) {
                $sub->where('pasiens.no_rm', 'like', "%{$keyword}%")
                ->orWhere('pasiens.nama',  'like', "%{$keyword}%");
            });
        }

        if ($data['filter_koding']) {
            if ($request->filter_koding == 'sudah') {
                $q->where('registrasis.is_koding', 1);
            } elseif ($request->filter_koding == 'belum') {
                $q->where(function ($sub) {
                    $sub->whereNull('registrasis.is_koding')
                        ->orWhere('registrasis.is_koding', 0);
                });
            }
        }


        $data['poli'] = Poli::where('politype', 'G')->get();

        $select = [
            'histori_kunjungan_igd.id as id',
            'histori_kunjungan_igd.registrasi_id',
            'histori_kunjungan_igd.id as id_kunjungan',
            'histori_kunjungan_igd.created_at',
            'histori_kunjungan_igd.pasien_id',

            'registrasis.id as registrasi_id',
            'registrasis.dokter_id',
            'registrasis.poli_id',
            'registrasis.created_at as tgl_reg',
            'registrasis.tgl_pulang',
            'registrasis.bayar',
            'registrasis.no_sep',
            'registrasis.status_reg',
            'registrasis.nomorantrian',
            'registrasis.input_from',
            'registrasis.tte_resume_pasien',
            'registrasis.is_koding',
            'registrasis.tte_hasillab_lis',

            'pasiens.no_rm as pasien_no_rm',
            'pasiens.nama as pasien_nama',
            'pasiens.no_jkn as pasien_no_jkn',
            'pasiens.tgllahir as pasien_tgllahir',
            'pasiens.kelamin',

            'pegawais.nama as dokter_dpjp',
            'carabayars.carabayar',

            'rawatinaps.kamar_id as rawat_inap_kamar',
        ];

        $perPage = 10;
        $page    = (int) $request->get('page', 1);
        $data['dt_paging'] =false;
        $data['search'] = true;

        $registrasi = $q->select($select)
            ->paginate($perPage, ['*'], 'page', $page)
            ->appends($request->except('page'))
            ->withPath(route('frontoffice.antrian-igd-bybln')); 

        if ($registrasi->lastPage() > 0 && $page > $registrasi->lastPage()) {
            $page = $registrasi->lastPage();
            $registrasi = $q->select($select)
                ->paginate($perPage, ['*'], 'page', $page)
                ->appends($request->except('page'))
                ->withPath(route('frontoffice.antrian-igd-bybln'));
        }

        $data['registrasi'] = $registrasi;
        $data['no'] = ($page - 1) * $perPage + 1;

        if ($request->ajax()) {
            return view('frontoffice.view_ajax_antrianRealtimeIGD', $data);
        }

        return view('frontoffice.antrian_realtime_igd', $data);
    }

    public function tabRadiologi($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $data['ekspertise'] = RadiologiEkspertise::where('registrasi_id', $reg_id)->orderBy('id', 'DESC')->get();
        return view('frontoffice.tab.radiologi', $data);
    }

    public function tabCPPTIGD($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $data['resume'] = Emr::where('pasien_id', $data['reg']->pasien_id)
							->where('unit', '!=', 'sbar')
							->orderBy('id', 'DESC')->get();
        
        return view('frontoffice.tab.cppt', $data);
    }

    public function tabSurkon($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $data['rencanaKontrol'] = RencanaKontrol::where('registrasi_id', $reg_id)->orderBy('id', 'DESC')->get();
        return view('frontoffice.tab.surkon', $data);
    }

    public function tabSurkonCasemix($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $pasien_id   = $data['reg']->pasien_id;
        $surkon = RencanaKontrol::where('pasien_id', $pasien_id)->orderBy('id', 'DESC')->groupBy('registrasi_id')->pluck('registrasi_id');
        $data['rencanaKontrol'] = RencanaKontrol::where('registrasi_id', @$surkon[1])->get();
        return view('frontoffice.tab.surkon', $data);
    }

    public function tabKriteriaICU($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $pasien_id   = $data['reg']->pasien_id;
        $data['masuk'] = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'kriteria-masuk-icu')->get();
        $data['keluar'] = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'kriteria-keluar-icu')->get();
        return view('frontoffice.tab.kriteriaICU', $data);
    }

    public function tabCoding($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $pasien_id   = $data['reg']->pasien_id;
        $data['icd10'] = JknIcd10::where('registrasi_id', $data['reg']->id)->get();
        $data['icd9'] = JknIcd9::where('registrasi_id', $data['reg']->id)->get();
        return view('frontoffice.tab.coding', $data);
    }

    public function tabLapTindakanIRJ($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $data['lapTindakanIRJ'] = EmrInapPerencanaan::where('registrasi_id', $reg_id)->where('type', 'lap-tindakan-rj')->get();
        return view('frontoffice.tab.laptindakanirj', $data);
    }

    private function hitungPemeriksaan($id_lis)
    {
        $licaResult = LicaResult::where('no_lab', $id_lis)->first();
        $hasil = '';
        $level_keys = array();

        if ($licaResult) {
            $hasil = json_decode($licaResult->json);

            foreach ($hasil as $k => $sub_array) {
                $this_level = @$sub_array->group_name ?? @$sub_array->group_test;
                $level_keys[$this_level][$k] = $sub_array;
            }

            $data['response'] = (object) ["no_ref" => $id_lis, "tgl_kirim" => $licaResult->tgl_pemeriksaan];
        } else {
            Flashy::error('Hasil dari LIS belum muncul, coba beberapa saat lagi');
            return redirect()->back();
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "172.168.1.97/lica-soreang/public/api/get_result/" . $id_lis, // your preferred link
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    // Set Here Your Requesred Headers
                    'x-api-key: licaapi',
                ),
            ));
            $response = curl_exec($curl);
            if (!isset(json_decode($response)->hasil)) {
                return 0;
            }
            $err = curl_error($curl);
            curl_close($curl);
            $data['response'] = '';
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data['response'] = json_decode($response);
                $hasil = $data['response']->hasil;
            }

            foreach ($hasil as $k => $sub_array) {
                $this_level = $sub_array->group_test;
                $level_keys[$this_level][$k] = $sub_array;
            }
        }

        return (object) [
            'total_pemeriksaan' => count($hasil),
            'jenis_pemeriksaan' => $level_keys,
        ];
    }

    public function downloadAll(Request $req, $reg_id)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '10000M');

        $data['reg'] = Registrasi::find($reg_id);
        if(!$data['reg']){
            Flashy::info('Pratinjau belum dapat dilihat');
            return redirect()->back();
        }
        $data['dokter'] = Pegawai::find($data['reg']->dokter_id);
        $poliBpjs = baca_poli_bpjs($data['reg']->poli_id);

        // $data['ttd_pasien'] = App\TandaTangan::where('registrasi_id', $data['reg']->id)->orderBy('id', 'DESC')->first();
        // $data['sign_pad']   = App\TandaTangan::where('registrasi_id', $data['reg']->id)->where('jenis_dokumen', 'e-resume')->orderBy('id', 'DESC')->first();

        // SEP
        $sep = @$this->cetak_sep_new(@$data['reg']->no_sep);
        $data['sep'] = @$sep['sep'];
        $data['rujukan'] = @$sep['rujukan'];
        // END SEP

        // RESEP
        $penjualan = Penjualan::join('resep_note', 'resep_note.penjualan_id', '=', 'penjualans.id')
            ->where('penjualans.registrasi_id', $data['reg']->id)
            ->select('resep_note.id', 'penjualans.catatan')
            ->first();
        $data['pegawai'] = Pegawai::all()->keyBy('id')->toArray();
        $resume = EmrResume::where('registrasi_id', $data['reg']->id)->orderBy('id', 'DESC')->first();
		$data['resume'] = $resume ? json_decode($resume->content, true) : null;
        $data['asesmen_perawat'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
		$data['fisik'] = $data['asesmen_perawat'] ? json_decode($data['asesmen_perawat']->fisik, true) : null;
        if ($penjualan) {
            $data['detail'] = ResepNoteDetail::where('resep_note_id', $penjualan->id)->get();
            $data['penjualan'] = $penjualan;
        } else {
            $data['detail'] = [];
        }
        // END RESEP

        // E-Resume
        // $data['soap']   = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->first();
        // $data['cppt'] = Emr::where('registrasi_id', $data['reg']->id)->where('user_id', $data['dokter']->user_id)->first();
        // $data['cppt_perawat'] = Emr::where('registrasi_id', $data['reg']->id)->where('user_id', '!=',$data['dokter']->user_id)->first();

        // Asesmen Hemodialisa & Gigi sudah dipisah antara perawat & dokter
        if ($poliBpjs == "HDL" || $poliBpjs == "GIG") {
            $data['soap']   = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'like', 'fisik_%')->where('user_id', $data['dokter']->user_id)->first();
        } else {
            $data['soap']   = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'like', 'fisik_%')->where('userdokter_id', $data['dokter']->user_id)->first();

            if (!$data['soap']) {
                $data['soap']   = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'like', 'fisik_%')->first();
            }
        }
        $data['resume_igd']   = EmrResume::where('registrasi_id', $data['reg']->id)->where('type','resume-igd')->orderBy('id','DESC')->first();
        
        // E-Resume Rawat Inap
        $data['rawatinap'] = Rawatinap::where('registrasi_id', $reg_id)->first();
        $data['resume_inap'] = EmrInapPerencanaan::where('registrasi_id',  '=', $data['reg']->id)->where('type', 'resume')->get();
        $data['resume'] = EmrInapPerencanaan::where('registrasi_id',  '=', $data['reg']->id)->where('type', 'resume')->orderBy('created_at', 'desc')->first();
        $data['content'] = json_decode(@$data['resume']->keterangan, true);
        // END E-Resume Rawat Inap

        //Update baru - mengatasi user dokter yg mengisi cppt selain dpjp
        // $poli = Poli::find($data['reg']->poli_id, ['dokter_id']);
        // $dokterPoli = preg_split("/\,/", $poli->dokter_id);
        // $userDokterPoli = Pegawai::whereIn('id', $dokterPoli)->pluck('user_id');
        $userDokterPoli = Pegawai::where('kategori_pegawai', 1)->pluck('user_id');
        $data['cppt'] = Emr::where('registrasi_id', $data['reg']->id)->whereIn('user_id', $userDokterPoli)->where('unit', '!=', 'sbar')->orderBy('id', 'desc')->first();
        $data['cppt_igd'] = Emr::where('registrasi_id', $data['reg']->id)->where('unit', 'igd')->whereIn('user_id', $userDokterPoli)->orderBy('id', 'desc')->first();
        $data['cpptPerawat'] = Emr::where('registrasi_id', $data['reg']->id)->whereNotIn('user_id', $userDokterPoli)->orderBy('id', 'desc')->first();

        // $data['icd10Primary'] = PerawatanIcd10::where('registrasi_id', $data['reg']->id)->where('kategori', 'Primary')->get();
        // $data['icd10Secondary'] = PerawatanIcd10::where('registrasi_id', $data['reg']->id)->whereNull('kategori')->get();
        // $data['icd9'] = PerawatanIcd9::where('registrasi_id', $data['reg']->id)->get();

        $data['icd10Primary'] = JknIcd10::where('registrasi_id', $data['reg']->id)->where('kategori', 'Primary')->get();
        $data['icd10Secondary'] = JknIcd10::where('registrasi_id', $data['reg']->id)->whereNull('kategori')->get();
        $data['icd9'] = JknIcd9::where('registrasi_id', $data['reg']->id)->get();


        $data['folio'] = Folio::where('registrasi_id', $data['reg']->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $data['rads'] = Folio::where('registrasi_id', $data['reg']->id)->where('poli_tipe', 'R')->get();
        $data['labs'] = Folio::where('registrasi_id', $data['reg']->id)->where('poli_tipe', 'L')->get();
        $data['obats'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $data['reg']->id)
            ->select('penjualandetails.*')
            ->get();
        $data['tgl'] = date('Y-m-d', strtotime($data['reg']->created_at));
        // END E-Resume

        // Lap Tindakan IRJ
        $data['registrasi'] = Registrasi::find($data['reg']->id);
        $data['perencanaans'] = EmrInapPerencanaan::where('type', 'lap-tindakan-rj')->where('registrasi_id', $data['registrasi']->id)->get();
        // END Lap Tindakan IRJ

        // Hasil Lab
        $data['hasilLab'] = Hasillab::where('registrasi_id', '=', $data['reg']->id)->whereNotNull('json')->where('no_lab', 'NOT LIKE', 'LAB%')->get();
        foreach ($data['hasilLab'] as $hlab) {
            $resp = $this->hitungPemeriksaan($hlab->no_lab);
            $hlab->total_pemeriksaan = @$resp->total_pemeriksaan;
            $hlab->jenis_pemeriksaan = @$resp->jenis_pemeriksaan;
        }
        // END Hasil Lab

        // LAYANAN REHAB
        // LAYANAN REHAB
		$data['layanan_rehab']   = EmrInapPemeriksaan::where('registrasi_id', '=', $reg_id)->where('type','layanan_rehab')->first();

        // Hasil Lab PA
        $data['hasilLabsPA'] = Hasillab::where('registrasi_id', '=', $data['reg']->id)->where('no_lab', 'LIKE', 'LAB%')->get();
        // dd($data['hasilLabsPA']);
        $data['hasilLabPA'] = Hasillab::where('registrasi_id', '=', $data['reg']->id)->where('no_lab', 'LIKE', 'LAB%')->orderBy('id', 'desc')->first();
        $poli = Poli::find(43);
        $data['dokterLabPA'] = @explode(",", $poli->dokter_id)[0];
        // END Hasil Lab

        //Hasil Radiologi
        $data['radiologi'] = RadiologiEkspertise::join('registrasis', 'registrasis.id', '=', 'radiologi_ekspertises.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->where('radiologi_ekspertises.registrasi_id', $data['reg']->id)
            ->select('registrasis.*', 'pasiens.*', 'radiologi_ekspertises.*', 'pasiens.no_rm as no_rm', 'radiologi_ekspertises.dokter_id as dokter', 'radiologi_ekspertises.folio_id',  'radiologi_ekspertises.dokter_pengirim as pengirim', 'radiologi_ekspertises.created_at as tanggal_ekspertise')
            ->get();
        //END Hasil Radiologi

        //Treadmill
        $data['treadmill'] = EmrInapPerencanaan::where('registrasi_id', $data['reg']->id)->where('type', 'treadmill')->get();
        //END Treadmill

        //Echocardiogram
        $data['echocardiogram'] = echocardiogram::join('registrasis', 'registrasis.id', '=', 'echocardiograms.registrasi_id')
            ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->where('echocardiograms.registrasi_id', $data['reg']->id)
            ->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.rt', 'pasiens.rw', 'pasiens.village_id', 'echocardiograms.*')
            ->get();
        //END Echocardiogram

        //Surat Kontrol
        // $data['suratKontrol'] = Rencanakontrol::where('registrasi_id', $data['reg']->id)
        //     ->whereNotNull('no_surat_kontrol')
        //     ->first();

        $pasien_id   = $data['reg']->pasien_id;
        $surkon = RencanaKontrol::where('pasien_id', $pasien_id)->orderBy('id', 'DESC')->groupBy('registrasi_id')->pluck('registrasi_id');
        $data['suratKontrol'] = RencanaKontrol::where('registrasi_id', @$surkon[1])->whereNotNull('no_surat_kontrol')->orderBy('id', 'DESC')->first();
        //END Surat Kontrol

        // Hasil Penunjang
        $data['hasil_penunjang'] = Emr::where('registrasi_id', $data['reg']->id)
            ->where(function($query) {
                $query->whereNotNull('hasil_usg')
                    ->orWhereNotNull('hasil_echo')
                    ->orWhereNotNull('hasil_ekg')
                    ->orWhereNotNull('hasil_eeg')
                    ->orWhereNotNull('hasil_ctg')
                    ->orWhereNotNull('hasil_spirometri')
                    ->orWhereNotNull('hasil_lainnya');
            })
            ->orderBy('id', 'DESC')
            ->first();
        // END Hasil Penunjang

        // Cetak RB
        $data['rincian_biaya'] = "irj";
        if (cek_status_reg($data['reg']->status_reg) == "J") {
            $data['lab_irj_anatomi'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                ->where('folios.jenis', 'TA')
                ->where('folios.cara_bayar_id', '!=', '2')
                ->where('folios.poli_tipe', 'L')
                ->where('tarifs.keterangan', '!=', 'BD')
                ->where('folios.poli_id', '=', 43)
                ->sum(\DB::raw('folios.total'));
            $data['rincian_biaya'] = "irj";
            $data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('cara_bayar_id', '!=', '2')
                ->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
                ->get();
            // OTOMATIS SINKRON
            $data['sinkron_obat'] = Folio::where('registrasi_id', '=', $data['reg']->id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
            foreach ($data['sinkron_obat'] as $so) {
                $sink = Penjualan::with('penjualandetail')->where('no_resep', $so->namatarif)->first()->penjualandetail->sum('hargajual');
                // dd($sink);
                if ($so->total !== $sink) {
                    if ($sink !== '0') {
                        DB::table('folios')->whereNull('deleted_at')
                            ->where('registrasi_id', $data['reg']->id)
                            ->where('namatarif', $so->namatarif)
                            ->update(['total' => $sink]);
                    }
                }
            }
            $data['obat'] = Folio::where('registrasi_id', '=', $data['reg']->id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
            // dd($data['obat']);
            $data['obat_gudang'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->with('gudang')
                ->where('jenis', 'ORJ')->groupBy('gudang_id')
                ->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
                ->get();

            $data['folio_rajal'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                ->where('folios.jenis', 'TA')
                ->where(function ($query) {
                    // $query->where('poli_tipe', '=', 'J')
                    $query->whereNotIn('folios.poli_tipe', ['G', 'L', 'R', 'O'])
                        ->orWhereNull('folios.poli_tipe');
                })
                // ->where('poli_tipe', '!=','L')
                ->where('folios.cara_bayar_id', '!=', '2')
                ->where('tarifs.keterangan', '!=', 'BD')
                ->selectRaw('sum(folios.total) AS total,folios.poli_tipe,folios.dokter_id,folios.registrasi_id,folios.namatarif,folios.created_at,folios.jenis,folios.tarif_id')
                ->orderBy('folios.namatarif', 'ASC')
                ->groupBy('folios.tarif_id')
                ->get();


            $data['folio_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('cara_bayar_id', '!=', '2')
                ->whereIn('jenis', ['TG', 'TI'])
                ->where('poli_tipe', 'G')
                ->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id')
                ->get();
            $data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRD' . '%') //IGD
                ->where('jenis', 'ORJ')
                ->sum('total');

            // OBAT RAJAL
            $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->with('gudang')
                ->where('user_id', '!=', 610)
                ->where('gudang_id', '9') //rajal
                ->where('jenis', 'ORJ')
                ->sum('total');
            if ($data['obat_gudang_rajal'] == 0) {
                $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('namatarif', 'like', 'FRJ' . '%')
                    ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                    ->where('jenis', 'ORJ')
                    ->where('user_id', '!=', 610)
                    ->sum('total');
                $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('namatarif', 'like', 'FRJ' . '%')
                    ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                    ->where('jenis', 'ORJ')
                    ->where('user_id', '!=', 610)
                    ->select('namatarif', 'total')
                    ->get()
                    ->map(function ($obat) {
                        return (object) [
                            "obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                            "namatarif" => $obat->namatarif,
                            "total" => $obat->total,
                        ];
                    });
                // $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                //     ->with('obat')
                //     ->where('namatarif', 'like', 'FRJ' . '%')
                //     ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                //     ->where('jenis', 'ORJ')
                //     ->where('user_id', '!=', 610)
                //     ->select('namatarif', 'total')
                //     ->get();
            } else {

                $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('namatarif', 'like', 'FRJ' . '%')
                    ->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                    ->where('jenis', 'ORJ')
                    ->where('user_id', '!=', 610)
                    ->sum('total');
                $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('namatarif', 'like', 'FRJ' . '%')
                    ->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                    ->where('jenis', 'ORJ')
                    ->where('user_id', '!=', 610)
                    ->select('namatarif', 'total')
                    ->get()
                    ->map(function ($obat) {
                        return (object) [
                            "obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                            "namatarif" => $obat->namatarif,
                            "total" => $obat->total,
                        ];
                    });
                // $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                //     ->with('obat')
                //     ->where('namatarif', 'like', 'FRJ' . '%')
                //     ->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                //     ->where('jenis', 'ORJ')
                //     ->where('user_id', '!=', 610)
                //     ->select('namatarif', 'total')
                //     ->get();
            }

            // OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
            $data['obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRJ' . '%')
                ->where('jenis', 'ORJ')
                ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
                ->where('gudang_id', NULL)
                ->sum('total');
            $data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRJ' . '%')
                ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
                ->where('gudang_id', NULL)
                ->where('jenis', 'ORJ')
                ->select('namatarif', 'total')
                ->get()
                ->map(function ($obat) {
                    return (object) [
                        "obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                        "namatarif" => $obat->namatarif,
                        "total" => $obat->total,
                    ];
                });
            // $data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
            //     ->with('obat')
            //     ->where('namatarif', 'like', 'FRJ' . '%')
            //     ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
            //     ->where('gudang_id', NULL)
            //     ->where('jenis', 'ORJ')
            //     ->select('namatarif', 'total')
            //     ->get();

            $data['operasi'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('cara_bayar_id', '!=', '2')
                ->where('jenis', '!=', 'ORJ')
                ->whereIn('poli_tipe', ['O'])
                ->selectRaw('sum(total) AS total,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id')
                ->get();

            $data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->with('gudang')
                ->where('gudang_id', '2') //OPERASI
                ->where('jenis', 'ORJ')
                ->sum('total');
            $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('gudang_id', '2') //OPERASI
                ->where('jenis', 'ORJ')
                ->select('namatarif', 'total', 'user_id')
                ->get()
                ->map(function ($obat) {
                    return (object) [
                        "obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                        "namatarif" => $obat->namatarif,
                        "user_id" => $obat->user_id,
                        "total" => $obat->total,
                    ];
                });
            // $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
            //     ->with('obat')
            //     ->where('gudang_id', '2') //OPERASI
            //     ->where('jenis', 'ORJ')
            //     ->select('namatarif', 'total', 'user_id')
            //     ->get();
            if ($data['obat_gudang_operasi'] == 0) {

                $data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('gudang_id', NULL)
                    ->where('namatarif', 'like', 'FRJ' . '%')
                    ->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
                    ->where('jenis', 'ORJ')
                    ->sum('total');
                $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('gudang_id', NULL)
                    ->where('namatarif', 'like', 'FRJ' . '%')
                    ->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
                    ->where('jenis', 'ORJ')
                    ->select('namatarif', 'total', 'user_id')
                    ->get()
                    ->map(function ($obat) {
                        return (object) [
                            "obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                            "namatarif" => $obat->namatarif,
                            "user_id" => $obat->user_id,
                            "total" => $obat->total,
                        ];
                    });
                // $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                //     ->with('obat')
                //     ->where('gudang_id', NULL)
                //     ->where('namatarif', 'like', 'FRJ' . '%')
                //     ->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
                //     ->where('jenis', 'ORJ')
                //     ->select('namatarif', 'total', 'user_id')
                //     ->get();
            }

            $data_folio_irna = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('jenis', 'TI')
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', null)
                ->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id ,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id', 'kamar_id')
                ->get();

            $data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRI' . '%')
                ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                ->where('jenis', 'ORJ')
                ->sum('total');


            $data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRI' . '%')
                ->where('jenis', 'ORJ')
                ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
                ->where('gudang_id', NULL)
                ->sum('total');

            $data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

            if ($data['obat_gudang_inap'] == 0) {
                $data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('namatarif', 'like', 'FRI' . '%') //INAP
                    ->where('jenis', 'ORJ')
                    ->where('gudang_id', NULL)
                    ->sum('total');

                $data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
            }

            $data['total_ranap'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('cara_bayar_id', '!=', '2')
                ->where('jenis', 'TI')
                ->where('poli_tipe', null)
                ->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->sum('total');

            $data['folio_irna'] = [];
            foreach ($data_folio_irna as $element) {
                $data['folio_irna'][$element['kamar_id']][] = $element;
            }

            $data['kamar'] = Folio::where('registrasi_id', $data['reg']->id)
                ->whereNull('poli_tipe')
                ->selectRaw('kamar_id')
                ->groupBy('kamar_id')
                ->get();


            $data['lab'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('poli_tipe', 'L')
                ->where('cara_bayar_id', '!=', '2')
                ->sum(\DB::raw('total'));

            $data['lab_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TG')
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'L')
                ->sum(\DB::raw('total'));
            $data['lab_inap'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TI')
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'L')
                ->sum(\DB::raw('total'));
            

            $data['lab_irj'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                ->where('folios.jenis', 'TA')
                ->where('folios.cara_bayar_id', '!=', '2')
                ->where('folios.poli_tipe', 'L')
                ->where('tarifs.keterangan', '!=', 'BD')
                ->sum(\DB::raw('folios.total'));
            $data['bank_darah'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                // ->where('folios.jenis', 'TI')
                // ->where('folios.poli_tipe', 'L')
                // ->where('folios.poli_id', '!=', 43)
                ->where('tarifs.keterangan', 'BD')
                ->sum(\DB::raw('folios.total'));
            $data['tindakan_bank_darah'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                // ->where('folios.jenis', 'TI')
                // ->where('folios.poli_tipe', 'L')
                // ->where('folios.poli_id', '!=', 43)
                ->where('tarifs.keterangan', 'BD')
                ->groupBy('folios.tarif_id')
                ->selectRaw('sum(folios.total) AS total,folios.tarif_id,folios.namatarif')
                ->get();


            $data['rad_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TG')
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'not like', '%CT. Scan%')
                ->sum(\DB::raw('total'));
            $data['rad_inap'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TI')
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'not like', '%CT. Scan%')
                ->sum(\DB::raw('total'));
            $data['rad_irj'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TA')
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'not like', '%CT. Scan%')
                ->sum(\DB::raw('total'));
            $total_biaya = Folio::where('registrasi_id', $data['reg']->id)->where('cara_bayar_id', '!=', '2')->where('user_id', '!=', 610)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
            $jasa_racik = Folio::where('registrasi_id', $data['reg']->id)->where('cara_bayar_id', '!=', '2')->where('user_id', '!=', 610)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
            $data['total_biaya'] = $total_biaya + $jasa_racik;
        } else {
            $data['rincian_biaya'] = "non-irj";

            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '10000M');

            $data['obat'] = Folio::where('registrasi_id', '=', $data['reg']->id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
            $data['obat_gudang'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->with('gudang')
                ->where('jenis', 'ORJ')->groupBy('gudang_id')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
                ->get();

            $data['folio_rajal'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('jenis', 'TA')
                ->where('poli_tipe', 'J')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->selectRaw('sum(total) AS total,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id', 'dokter_pelaksana')
                ->get();
            $data['folio_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->whereIn('jenis', ['TG', 'TI'])
                ->where('poli_tipe', 'G')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->selectRaw('sum(total) AS total,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id', 'dokter_pelaksana')
                ->get();
            $data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRD' . '%') //IGD
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('jenis', 'ORJ')
                ->sum('total');
            $data['detail_obat_gudang_igd'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRD' . '%') //IGD
                ->where('namatarif', 'not like', 'PO' . '%') //IGD
                ->where('jenis', 'ORJ')
                ->select('namatarif', 'total')
                ->get()
                ->map(function ($obat) {
                    return (object) [
                        "obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                        "namatarif" => $obat->namatarif,
                        "total" => $obat->total,
                    ];
                });
            // $data['detail_obat_gudang_igd'] = Folio::where('registrasi_id', '=', $data['reg']->id)
            //     ->with('obat')
            //     ->where('namatarif', 'like', 'FRD' . '%') //IGD
            //     ->where('namatarif', 'not like', 'PO' . '%') //IGD
            //     ->where('jenis', 'ORJ')
            //     ->select('namatarif', 'total')
            //     ->get();

            $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->with('gudang')
                ->where('namatarif', 'like', 'FRJ' . '%') //
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('jenis', 'ORJ')
                ->sum('total');

            $data['operasi'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('jenis', '!=', 'ORJ')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->whereIn('poli_tipe', ['O'])
                ->selectRaw('sum(total) AS total,perawat_ibs1,cyto,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id')
                ->get();

            $data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->with('gudang')
                ->where('gudang_id', '2') //OPERASI
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('jenis', 'ORJ')
                ->sum('total');
            $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('gudang_id', '2') //OPERASI
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('jenis', 'ORJ')
                ->select('namatarif', 'total', 'user_id')
                ->get()
                ->map(function ($obat) {
                    return (object) [
                        "obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                        "namatarif" => $obat->namatarif,
                        "user_id" => $obat->user_id,
                        "total" => $obat->total,
                    ];
                });
            // $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
            //     ->with('obat')
            //     ->where('gudang_id', '2') //OPERASI
            //     ->where('namatarif', 'not like', 'PO' . '%')
            //     ->where('jenis', 'ORJ')
            //     ->select('namatarif', 'total', 'user_id')
            //     ->get();
            if ($data['obat_gudang_operasi'] == 0) {

                $data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('gudang_id', NULL)
                    ->where('namatarif', 'like', 'FRI' . '%')
                    ->where('namatarif', 'not like', 'PO' . '%')
                    ->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
                    ->where('jenis', 'ORJ')
                    ->sum('total');
                $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('gudang_id', NULL)
                    ->where('namatarif', 'like', 'FRI' . '%')
                    ->where('namatarif', 'not like', 'PO' . '%')
                    ->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
                    ->where('jenis', 'ORJ')
                    ->select('namatarif', 'total', 'user_id')
                    ->get()
                    ->map(function ($obat) {
                        return (object) [
                            "obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                            "namatarif" => $obat->namatarif,
                            "user_id" => $obat->user_id,
                            "total" => $obat->total,
                        ];
                    });
                // $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                //     ->with('obat')
                //     ->where('gudang_id', NULL)
                //     ->where('namatarif', 'like', 'FRI' . '%')
                //     ->where('namatarif', 'not like', 'PO' . '%')
                //     ->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
                //     ->where('jenis', 'ORJ')
                //     ->select('namatarif', 'total', 'user_id')
                //     ->get();
            }

            // POLI_TIPE YANG NULL
            $data_folio_irna = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('jenis', 'TI')
                ->where('poli_tipe', null)
                ->where('namatarif', 'not like', 'PO' . '%')
                ->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id,cyto ,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->groupBy('tarif_id', 'kamar_id', 'dokter_pelaksana')
                ->get();

            $data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRI' . '%')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                ->where('jenis', 'ORJ')
                ->sum('total');
            $data['detail_obat_gudang_inap'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRI' . '%')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
                ->where('jenis', 'ORJ')
                ->select('namatarif', 'total')
                ->get()
                ->map(function ($obat) {
                    return (object) [
                        "obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                        "namatarif" => $obat->namatarif,
                        "total" => $obat->total,
                    ];
                });
            // $data['detail_obat_gudang_inap'] = Folio::where('registrasi_id', '=', $data['reg']->id)
            //     ->with('obat')
            //     ->where('namatarif', 'like', 'FRI' . '%')
            //     ->where('namatarif', 'not like', 'PO' . '%')
            //     ->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
            //     ->where('jenis', 'ORJ')
            //     ->select('namatarif', 'total')
            //     ->get();


            // OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
            $data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                ->where('namatarif', 'like', 'FRI' . '%')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('jenis', 'ORJ')
                ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
                ->where('gudang_id', NULL)
                ->sum('total');
            $data['detail_obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                // ->with([
                //     'obat' => function ($query) {
                //         $query->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
                //     },
                // ])
                ->where('namatarif', 'like', 'FRI' . '%')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
                ->where('gudang_id', NULL)
                ->where('jenis', 'ORJ')
                ->select('namatarif', 'total')
                ->get()
                ->map(function ($obat) {
                    return (object) [
                        "obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
                        "namatarif" => $obat->namatarif,
                        "total" => $obat->total,
                    ];
                });
            // $data['detail_obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $data['reg']->id)
            //     ->with('obat')
            //     ->where('namatarif', 'like', 'FRI' . '%')
            //     ->where('namatarif', 'not like', 'PO' . '%')
            //     ->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
            //     ->where('gudang_id', NULL)
            //     ->where('jenis', 'ORJ')
            //     ->select('namatarif', 'total')
            //     ->get();

            $data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

            if ($data['obat_gudang_inap'] == 0) {
                $data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $data['reg']->id)
                    ->where('namatarif', 'like', 'FRI' . '%') //INAP
                    ->where('jenis', 'ORJ')
                    ->where('namatarif', 'not like', 'PO' . '%')
                    ->where('gudang_id', NULL)
                    ->sum('total');

                $data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
            }


            //END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI

            $data['total_ranap'] = Folio::where('registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->where('jenis', 'TI')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('poli_tipe', null)
                ->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
                ->orderBy('namatarif', 'ASC')
                ->sum('total');

            $data['folio_irna'] = [];
            foreach ($data_folio_irna as $element) {
                $data['folio_irna'][$element['kamar_id']][] = $element;
            }
            // END POLI_TIPE YANG NULL

            $data['kamar'] = Folio::where('registrasi_id', $data['reg']->id)
                ->whereNull('poli_tipe')
                ->selectRaw('kamar_id')
                ->groupBy('kamar_id')
                ->get();

            $data['lab'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('poli_tipe', 'L')
                ->sum(\DB::raw('total'));

            $data['lab_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TG')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('poli_tipe', 'L')
                ->sum(\DB::raw('total'));
            $data['lab_inap'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                ->where('folios.jenis', 'TI')
                ->where('folios.namatarif', 'not like', 'PO' . '%')
                ->where('folios.poli_tipe', 'L')
                ->where('folios.poli_id', '!=', 43)
                ->where('tarifs.keterangan', '!=', 'BD')
                ->sum(\DB::raw('folios.total'));
            $data['bank_darah'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                // ->where('folios.jenis', 'TI')
                // ->where('folios.poli_tipe', 'L')
                // ->where('folios.poli_id', '!=', 43)
                ->where('tarifs.keterangan', 'BD')
                ->sum(\DB::raw('folios.total'));
            $data['tindakan_bank_darah'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                // ->where('folios.jenis', 'TI')
                // ->where('folios.poli_tipe', 'L')
                // ->where('folios.poli_id', '!=', 43)
                ->where('tarifs.keterangan', 'BD')
                ->groupBy('folios.tarif_id')
                ->selectRaw('sum(folios.total) AS total,folios.tarif_id,folios.namatarif')
                ->get();

            $data['lab_inap_patologi'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TI')
                ->where('poli_tipe', 'L')
                ->where('poli_id', 43)
                ->sum(\DB::raw('total'));
            $data['tindakan_lab_inap_patologi'] = Folio::where('folios.registrasi_id', $data['reg']->id)
                ->with('tarif')
                ->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
                ->where('folios.jenis', 'TI')
                ->where('folios.poli_tipe', 'L')
                ->where('folios.poli_id', 43)
                ->groupBy('folios.tarif_id')
                ->selectRaw('sum(folios.total) AS total,folios.tarif_id,folios.namatarif')
                ->get();

            $data['lab_irj'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TA')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('poli_tipe', 'L')
                ->sum(\DB::raw('total'));

            $data['rad_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TG')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->sum(\DB::raw('total'));
            if ($data['rad_igd'] > 0) {
                $data['dokter_rad_igd'] = Folio::where('registrasi_id', $data['reg']->id)
                    ->where('jenis', 'TG')
                    ->where('poli_tipe', 'R')
                    ->where('namatarif', 'not like', 'PO' . '%')
                    ->groupBy('dokter_radiologi')
                    ->select('dokter_radiologi')->get();
            }
            $data['rad_inap'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TI')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->sum(\DB::raw('total'));
            if ($data['rad_inap'] > 0) {
                $data['dokter_rad_inap'] = Folio::where('registrasi_id', $data['reg']->id)
                    ->where('jenis', 'TI')
                    ->where('namatarif', 'not like', 'PO' . '%')
                    ->where('poli_tipe', 'R')
                    ->groupBy('dokter_radiologi')
                    ->select('dokter_radiologi')->get();
            }

            $data['rad_irj'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('jenis', 'TA')
                ->where('namatarif', 'not like', 'PO' . '%')
                ->where('poli_tipe', 'R')
                ->sum(\DB::raw('total'));

            $data['rad_inap'] = $data['rad_inap'];
            $total_biaya = Folio::where('registrasi_id', $data['reg']->id)->where('namatarif', 'not like', 'PO' . '%')->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
            $jasa_racik = Folio::where('registrasi_id', $data['reg']->id)->where('namatarif', 'not like', 'PO' . '%')->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
            $data['total_biaya'] = $total_biaya + $jasa_racik;
        }
        // END Cetak RB

        if ($data['reg']->poli->politype == 'G' || substr(@$data['reg']->status_reg, 0, 1) == 'I') {

            $data['pemeriksaan']   = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'triage-igd')->orderBy('id', 'DESC')->first();
            $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik);
            $asessment_aswal   = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type','assesment-awal-medis-igd')->orderBy('id', 'DESC')->first();
            $asessment_aswal_ponek   = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type','assesment-awal-medis-igd-ponek')->orderBy('id', 'DESC')->first();
            $data['asessment_awal']  = json_decode(@$asessment_aswal->fisik, true);
            $data['asessment_awal_ponek']  = json_decode(@$asessment_aswal_ponek->fisik, true);
        }

        if (substr(@$data['reg']->status_reg, 0, 1) == 'I') {
            $data['spri'] = \App\SuratInap::join('registrasis', 'registrasis.id', '=', 'surat_inaps.registrasi_id')
                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->where('surat_inaps.registrasi_id', $data['reg']->id)
                ->select('surat_inaps.no_spri', 'registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.alamat', 'surat_inaps.*')
                ->get();
            $data['apgarScore'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'apgar-score')->first();
        }

        $data['ct_scan'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'like', '%CT. Scan%')
                ->get();
        $data['total_ct_scan'] = Folio::where('registrasi_id', $data['reg']->id)
                ->where('cara_bayar_id', '!=', '2')
                ->where('poli_tipe', 'R')
                ->where('namatarif', 'like', '%CT. Scan%')
                ->sum(\DB::raw('total'));

        $pdf = PDF::loadView('frontoffice.cetak_all', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(@$data['reg']->no_sep . '_' . $data['reg']->pasien->nama . '.pdf');
    }

    function cetak_sep_new($no_sep = '')
    {
        if (!empty($no_sep)) {
            $data['reg'] = Registrasi::where('no_sep', $no_sep)->first();
            // dd($data['reg']);
            // dd($data['reg']->ppk_rujukan);
            if (!empty($data['reg']->ppk_rujukan)) {
                $perujuk = explode('|', $data['reg']->ppk_rujukan);
                if (isset($perujuk[1])) {
                    $data['perujuk'] = $perujuk[1];
                } else {
                    $data['perujuk'] = NULL;
                }
            } else {
                $data['perujuk'] = '-';
            }

            session()->forget('no_sep');
        } else {
            $data['error'] = 'No. SEP Tidak ada';
        }


        $ID = config('app.sep_id');
        $t = time();
        $datasep = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($datasep), utf8_encode($secretKey), true));

        $completeurl = config('app.sep_url_web_service') . "/SEP/" . $no_sep;


        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'user_key:' . config('app.user_key'),
            'Content-Type: application/x-www-form-urlencoded',
        );
        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_HTTPGET, 1);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);

        $sml = json_decode($response, true);
        if ($response == null || $sml == null) {
            // dd("A");
            // Flashy::info('Jaringan bermasalah, tidak dapat terhubung ke VCLAIM BPJS');
            // return redirect()->back();
        }

        $data['rujukan'] = '';
        $stringEncrypt = stringDecrypt($ID . config('app.sep_key') . $t, $sml['response']);
        $data['sep'] = json_decode(decompress($stringEncrypt), true);
        if ($data['sep']) {
            $data['rujukan'] = cekRujukan($data['sep']['noRujukan']);
        }
        // dd($data['rujukan']);
        // $this->cekRujukan($data['data']->no_rujukan);
        // dd($data['sep']);

        // CEK FINGER
        $data['kode_finger'] = '1';
        $data['status_finger'] = 'OK';
        $cek_finger = [];
        @$nomorkartu = @$data['reg']->pasien->no_jkn;
        @$tglperiksa = @date('Y-m-d', strtotime($data['reg']->created_at));

        return $data;
    }

    function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }

    function cekFinger($nomor, $tglperiksa)
    {
        list($ID, $t, $signature) = $this->HashBPJS();

        @$completeurl = config('app.sep_url_web_service') . "/SEP/FingerPrint/Peserta/" . $nomor . "/TglPelayanan/" . $tglperiksa;
        @$response = $this->xrequest($completeurl, $signature, $ID, $t);
        if (@$response == 'Authentication failed') {
            @$json = [['metaData' => ['code' => '201', 'message' => 'Authentication failed']]];
            return response()->json(json_encode($json, JSON_PRETTY_PRINT));
        }
        @$array[] = json_decode(@$response, true);
        @$stringEncrypt = $this->stringDecrypt($ID . config('app.sep_key') . $t, $array[0]['response']);
        @$array[] = json_decode($this->decompress(@$stringEncrypt), true);
        // dd($array);
        @$sml = json_encode($array, JSON_PRETTY_PRINT);
        @$json = json_decode($sml, true);
        return @$json;
    }

    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    function decompress($string)
    {
        // dd($string);
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
    // SUDAH V2
    function signature()
    {

        $ID = config('app.sep_id');
        date_default_timezone_set('Asia/Jakarta');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        $user_key = config('app.user_key');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));


        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'user_key:' . $user_key,
            'Content-Type: application/json; charset=utf-8',
        );

        return response()->json($arrheader);

        // $json = json_encode($sml);
        // echo $json;die;
    }

    function xrequest($url, $signature, $ID, $t)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Content-Type: application/json";
        $headers[] = "X-Cons-Id:" . $ID;
        $headers[] = "X-Timestamp:" . $t;
        $headers[] = "X-Signature:" . $signature;
        $headers[] = "user_key:" . config('app.user_key');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $message = 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

    function HashBPJS()
    {
        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');

        date_default_timezone_set('Asia/Jakarta');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
        $encodedSignature = base64_encode($signature);
        // $encodedSignature = \LZCompressor\LZString::compressToBase64($signature);;
        return array($ID, $t, $encodedSignature);
    }

    function cekRujukan($nomor)
    {
        list($ID, $t, $signature) = $this->HashBPJS();
        // dd($nomor);
        $completeurl = config('app.sep_url_web_service') . "/Rujukan/" . $nomor;
        $response = $this->xrequest($completeurl, $signature, $ID, $t);
        // dd($response);
        if (!$response) {
            return $response;
        }
        if ($response == 'Authentication failed') {
            $json = [['metaData' => ['code' => '201', 'message' => 'Authentication failed']]];
            return response()->json(json_encode($json, JSON_PRETTY_PRINT));
        }
        $array[] = json_decode($response, true);
        $stringEncrypt = $this->stringDecrypt($ID . config('app.sep_key') . $t, $array[0]['response']);
        $array[] = json_decode($this->decompress($stringEncrypt), true);

        $sml = json_encode($array, JSON_PRETTY_PRINT);
        $json = json_decode($sml, true);
        return $json;
    }

    public function generalConsent($registrasi_id)
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['consent'] = json_decode($data['reg']->general_consent, true);
        return view('frontoffice.general_consent', $data);
    }
    public function generalConsentPost(Request $req, $registrasi_id)
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['reg']->general_consent = json_encode($req->consent);
        $data['reg']->save();
        $data['consent'] = $req->consent;

        return view('frontoffice.cetak_general_consent', $data);
    }
    public function generalConsentIrna($registrasi_id)
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['consent'] = json_decode($data['reg']->general_consent, true);
        return view('frontoffice.general_consent_irna', $data);
    }
    public function generalConsentPostIrna(Request $req, $registrasi_id)
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['reg']->general_consent = json_encode($req->consent);
        $data['reg']->save();
        $data['consent'] = $req->consent;

        if (!empty($data['reg']->pasien->tgllahir)) {
            $data['umur'] = Carbon::parse($data['reg']->pasien->tgllahir)->age . ' tahun';
        } else {
            $data['umur'] = 'Tanggal lahir tidak tersedia';
        }

        return view('frontoffice.cetak_general_consentirna', $data);
    }
    public function generalConsentCetak($registrasi_id)
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['consent'] = json_decode($data['reg']->general_consent, true);
        $data['ttd'] = TandaTangan::where('registrasi_id', $registrasi_id)
            ->where('jenis_dokumen', 'general-consent')
            ->first();

        if (!empty($data['reg']->pasien->tgllahir)) {
            $data['umur'] = Carbon::parse($data['reg']->pasien->tgllahir)->age . ' tahun';
        } else {
            $data['umur'] = 'Tanggal lahir tidak tersedia';
        }

        return view('frontoffice.cetak_general_consent', $data);
    }
    public function generalConsentCetakIrna($registrasi_id)
    {
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['consent'] = json_decode($data['reg']->general_consent, true);
        $data['ttd'] = TandaTangan::where('registrasi_id', $registrasi_id)
            ->where('jenis_dokumen', 'general-consent')
            ->first();

        if (!empty($data['reg']->pasien->tgllahir)) {
            $data['umur'] = Carbon::parse($data['reg']->pasien->tgllahir)->age . ' tahun';
        } else {
            $data['umur'] = 'Tanggal lahir tidak tersedia';
        }

        return view('frontoffice.cetak_general_consentirna', $data);
    }

    public function ttePDFGeneralConsent(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $nik = $request->nik;
        $passphrase = $request->passphrase;
        
        $reg    = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $consent = json_decode($reg->general_consent, true);
        $ttd    = TandaTangan::where('registrasi_id', $reg_id)
            ->where('jenis_dokumen', 'general-consent')
            ->first();
        // dd($reg->dokter_id);
        // $data   = json_decode($reg->general_consent, true);
        // dd($data);
        
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('frontoffice.cetak_general_consent', compact('reg', 'dokter', 'consent', 'ttd', 'proses_tte'));
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $filePath = uniqId() . '-general-consent.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "general-consent", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $reg->tte_general_consent = $tte->response;
                $reg->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
        } else {
            $tte_nonaktif = true;
            $pdf = PDF::loadView('frontoffice.cetak_general_consent', compact('reg', 'dokter', 'consent', 'ttd', 'tte_nonaktif'));
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $reg->tte_general_consent = json_encode((object) [
                "base64_signed_file" => base64_encode($pdfContent),
            ]);
            $reg->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakTTEPDFGeneralConsent($reg_id)
    {
        $reg    = Registrasi::find($reg_id);
        $tte    = json_decode($reg->tte_general_consent);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="General Consent-' . $reg_id . '.pdf"',
        ]);
    }
}