<?php

namespace App\Http\Controllers;

use App\Antrian as Antrian;
use Flashy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Poli\Entities\Poli;
use Modules\Pegawai\Entities\Pegawai;
use Illuminate\Support\Facades\Validator;
use App\RegistrasiAntrian;
use App\AntrianPoli;
use App\HistorikunjunganIRJ;
use Carbon\Carbon;
use DB;
use Auth;
use Modules\Registrasi\Entities\Registrasi;

class AntrianPoliController extends Controller
{

    // function __construct() {
    // 	$this->middleware(['auth']);
    // } 

    public function datalayarlcd($poli_id)
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('tanggal', date('Y-m-d'))
            ->where('poli_id', $poli_id)
            ->orderBy('id', 'desc')
            ->first();
        $terpanggil = AntrianPoli::where('tanggal', '=', date('Y-m-d'))
            ->where('status', '<>', '0')
            ->where('poli_id', $poli_id)
            ->orderBy('id', 'desc')
            ->first();
        // dd($antrian);
        return view('modules.antrian_poli.datalayarlcd', compact('antrian', 'terpanggil'));
    }

    //POLI ANAK
    public function datalayarlcdanak()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 1)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 1)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd', compact('antrian', 'terpanggil'));
    }

    public function datalayarlcdanakdiperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 1)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 1)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcdanakdiperiksa', compact('antrian', 'terpanggil'));
    }

    public function datalayarlcdanakantrian()
    {

        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            //->where('antrian_poli.panggil', '=', '1')
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 1)
            ->orderBy('antrian_poli.id', 'asc')->get();

        return view('modules.antrian_poli.datalayarlcdanakantrian', compact('antrian'));
    }

    //POLI NEUROLOGI/SYARAF
    public function datalayarlcdneurologi()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 24)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 24)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd2', compact('antrian', 'terpanggil'));
    }

    public function datalayarlcdsyarafperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 24)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 24)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcdsyarafperiksa', compact('antrian', 'terpanggil'));
    }

    public function datalayarlcdsyarafantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            //->where('antrian_poli.panggil', '=', '1')
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 24)
            ->orderBy('antrian_poli.id', 'asc')->get();

        return view('modules.antrian_poli.datalayarlcdsyarafantrian', compact('antrian'));
    }


    //POLI PENYAKIT DALAM
    public function datalayarlcdpenyakitdalam()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 23)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 23)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd3', compact('antrian', 'terpanggil'));
    }
    public function datalayarlcddalamperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 23)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 23)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcddalamperiksa', compact('antrian', 'terpanggil'));
    }
    public function datalayarlcddalamantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 23)
            ->orderBy('antrian_poli.id', 'asc')->get();

        return view('modules.antrian_poli.datalayarlcddalamantrian', compact('antrian'));
    }

    //POLI GERIATRI
    public function datalayarlcdgeriatri()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 27)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 27)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd10', compact('antrian', 'terpanggil'));
    }

    public function datalayarlcdgeriatriperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 27)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 27)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcdgeriatriperiksa', compact('antrian', 'terpanggil'));
    }
    public function datalayarlcdgeriatriantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 27)
            ->orderBy('antrian_poli.id', 'asc')->get();

        return view('modules.antrian_poli.datalayarlcddalamantrian', compact('antrian'));
    }


    // Versi 2
    //TV-1
    public function layarlcdpolitv1()
    {
        return view('modules.antrian_poli.layarlcd_poli');
    }

    //TV-2
    public function layarlcdpolitv2()
    {
        return view('modules.antrian_poli.layarlcd_poli_2');
    }

    //POLI BEDAH
    public function datalayarlcdbedah()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 12)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 12)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd4', compact('antrian', 'terpanggil'));
    }
    public function bedahperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 12)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 12)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.bedahperiksa', compact('antrian', 'terpanggil'));
    }
    public function bedahantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 12)
            ->orderBy('antrian_poli.id', 'asc')->get();
        return view('modules.antrian_poli.bedahantrian', compact('antrian'));
    }

    //POLI KEBIDANAN
    public function datalayarlcdbidan()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 11)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 11)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd5', compact('antrian', 'terpanggil'));
    }
    public function bidanperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 11)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 11)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.bidanperiksa', compact('antrian', 'terpanggil'));
    }
    public function bidanantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 11)
            ->orderBy('antrian_poli.id', 'asc')->get();
        return view('modules.antrian_poli.bidanantrian', compact('antrian'));
    }

    //POLI GIGI
    public function datalayarlcdgigi()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 8)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 8)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd6', compact('antrian', 'terpanggil'));
    }
    public function gigiperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 8)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 8)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.gigiperiksa', compact('antrian', 'terpanggil'));
    }
    public function gigiantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 8)
            ->orderBy('antrian_poli.id', 'asc')->get();
        return view('modules.antrian_poli.gigiantrian', compact('antrian'));
    }

    //POLI MCU/KARYAWAN
    public function datalayarlcdmcu()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 20)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 20)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd7', compact('antrian', 'terpanggil'));
    }
    public function mcuperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 20)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 20)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.mcuperiksa', compact('antrian', 'terpanggil'));
    }
    public function mcuantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 20)
            ->orderBy('antrian_poli.id', 'asc')->get();
        return view('modules.antrian_poli.mcuantrian', compact('antrian'));
    }

    //POLI THT
    public function datalayarlcdtht()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 7)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 7)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd8', compact('antrian', 'terpanggil'));
    }
    public function thtperiksa()
    {
        $antrian = AntrianPoli::whereIn('status', [4])
            ->where('poli_id', 7)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();

        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '4')
            ->where('antrian_poli.poli_id', 7)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.thtperiksa', compact('antrian', 'terpanggil'));
    }
    public function thtantrian()
    {
        $antrian = AntrianPoli::join('registrasis', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->select('registrasis.pasien_id', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.nomor', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '=', '0')
            ->where('antrian_poli.poli_id', 7)
            ->orderBy('antrian_poli.id', 'asc')->get();
        return view('modules.antrian_poli.thtantrian', compact('antrian'));
    }

    //POLI UMUM
    public function datalayarlcdumum()
    {
        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->where('poli_id', 17)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'desc')->first();
        $terpanggil = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
            ->select('pegawais.nama as dokter', 'antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
            ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
            ->where('antrian_poli.status', '<>', '0')
            ->where('antrian_poli.poli_id', 17)
            ->orderBy('antrian_poli.id', 'desc')->first();
        return view('modules.antrian_poli.datalayarlcd9', compact('antrian', 'terpanggil'));
    }
    // Versi 3 Update Terbaru

    //TV-1
    public function layarpolitv1()
    {
        return view('modules.antrian_poli.poli_v3_tv1');
    }

    //TV-2
    public function layarpolitv2()
    {
        //dd("tv2");
        return view('modules.antrian_poli.poli_v3_tv2');
    }


    //TV-2
    public function layartv2()
    {
        //dd("Layar TV2");
        return view('modules.antrian_poli.politv2');
    }

    public function getDisplay(Request $request)
    {
        $terpanggil = [];
        // foreach( $request->poli as $val ){
        // 	$antrian = AntrianPoli::where('tanggal', '=', date('Y-m-d'))
        // 		->where('status', '<>', '0')
        // 		->where('poli_id', $val)
        // 		->orderBy('id', 'desc')
        // 		->first();
        foreach ($request->poli as $val) {
            $antrian = AntrianPoli::join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
                ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                ->select('antrian_poli.id', 'pasiens.nama', 'antrian_poli.tanggal', 'antrian_poli.panggil', 'antrian_poli.nomor', 'antrian_poli.kelompok', 'antrian_poli.status', 'antrian_poli.poli_id', 'antrian_poli.id')
                ->where('antrian_poli.tanggal', '=', date('Y-m-d'))
                ->where('antrian_poli.status', '<>', '0')
                ->where('antrian_poli.poli_id', $val)
                ->orderBy('antrian_poli.id', 'desc')->first();

            $send = '';
            if (isset($antrian->nomor)) {
                if ($antrian->panggil == 0) {
                    $antriku    = !empty($antrian->nomor) ? $antrian->kelompok . $antrian->nomor : NULL;
                    $namapasien = !empty($antrian->nama) ? $antrian->nama : NULL;
                    //$send     = '<span class="blink_me">'.$antriku.'</span>';
                    $send       = '<div>
								<h4 class="header_antrian_on">' . $antriku . '</h4>
								<h4 class="nama_antrian_on">' . substr($namapasien, 0, 20) . '</h4>
								</div>';
                } else {
                    $antriku    = !empty($antrian->nomor) ? $antrian->kelompok . $antrian->nomor : NULL;
                    $namapasien = !empty($antrian->nama) ? $antrian->nama : NULL;
                    //$send       = '<span>'.$antriku.'</span>';	
                    $send       = '<div>
								<h4 class="header_antrian">' . $antriku . '</h4>
								<h4 class="nama_antrian">' . substr($namapasien, 0, 20) . '</h4>
								</div>';
                }
            }

            $terpanggil[$val] = $send;
        }
        $res = [
            "status" => true,
            "data" => $terpanggil
        ];
        return response()->json($res);
    }

    public function dataAntrianTerakhir()
    {

        $antrian = AntrianPoli::whereIn('status', [1, 2, 3])
            ->with(['poli'])
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('updated_at', 'desc')
            ->first();
        // dd( $antrian->poli->nama )
        // dd($antrian);
        if (isset($antrian->nomor)) {
            if ($antrian->panggil == 0) {
                $antrianku = !empty($antrian->nomor) ? $antrian->kelompok . $antrian->nomor : NULL;
                $poli = isset($antrian->poli->nama) ? $antrian->poli->nama : NULL;
                $res = [
                    "status" => true,
                    "antrian" => '<span class="blink_me">' . $antrianku . '</span>',
                    "poli" => '<span class="blink_me">' . $poli . '</span>'
                ];
                return response()->json($res);
            } else {
                $antrianku = !empty($antrian->nomor) ? $antrian->kelompok . $antrian->nomor : NULL;
                $poli = isset($antrian->poli->nama) ? $antrian->poli->nama : NULL;
                $res = [
                    "status" => true,
                    "antrian" => '<span>' . $antrianku . '</span>',
                    "poli" => '<span>' . $poli . '</span>'
                ];
                return response()->json($res);
            }
        }
        // return view('modules.antrian_poli.antrianTerakhir', compact('antrian'));
    }

    public function daftarpanggil()
    {
        $antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
            ->where('status', '=', '0')
            ->where('kelompok', 'C')
            // ->take(1)
            ->get();
        return view('modules.antrian_poli.daftarpanggil', compact('antrian'));
    }

    public function daftarantrian()
    {
        session()->forget('blm_terdata');
        session()->forget('jenis');
        session()->forget('igdlama');
        session()->forget('igdumum-lama');
        session()->forget('pasienID');
        $terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
            ->where('status', '<>', '0')
            ->where('loket', 3)
            ->orderBy('id', 'desc')
            // ->take(20)
            ->get();
        $data['poli'] = Poli::whereIn('politype', ['J'])->get();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(); // 1: DOKTER
        return view('modules.antrian_poli.daftarantrian', compact('terpanggil', 'data'));
    }

    public function layarlcd()
    {
        $data['poli'] = Poli::whereIn('politype', ['J'])->where('layar_lcd', '1')->orderBy('nama')->get();
        $dp = [];
        foreach ($data['poli'] as $key => $grid1) {
            // if($key <= 5){
            $dataGrid1[] = [
                'id' => $grid1->id,
                'nama' => $grid1->nama,
            ];
            $dp[] = [
                'id' => $grid1->id
            ];
            // }
            // if($key > 5){
            //     $dataGrid2[] = [
            //         'id' =>$grid1->id,
            //         'nama' =>$grid1->nama,
            //     ];
            // }
            // if($key > 12 && $key < 18){
            //     $dataGrid3[] = [
            //         'id' =>$grid1->id,
            //         'nama' =>$grid1->nama,
            //     ];
            // }
            // if($key > 18 && $key < 25){
            //     $dataGrid4[] = [
            //         'id' =>$grid1->id,
            //         'nama' =>$grid1->nama,
            //     ];
            // }
        }

        $data['grid'] = [
            'grid1' => $dataGrid1,
            // 'grid2' => $dataGrid2
        ];

        // dd($data['grid']);

        $poli = json_encode($dp);
        // dd($data['poli']);
        return view('modules.antrian_poli.layarlcd', compact('data', 'poli'));
    }

    public function layarlcd2()
    {
        $data['poli'] = Poli::whereIn('politype', ['J'])->where('layar_lcd', 2)->get();
        $poli = json_encode($data['poli']);
        return view('modules.antrian_poli.layarlcd', compact('data', 'poli'));
    }

    public function layarlcd3()
    {
        $data['poli'] = Poli::whereIn('politype', ['J'])->where('layar_lcd', 3)->get();
        $poli = json_encode($data['poli']);
        return view('modules.antrian_poli.layarlcd', compact('data', 'poli'));
    }

    public function suara()
    {
        $antrian = AntrianPoli::with(['register_antrian.poli'])
            // ->whereIn('id', $id_reg)
            ->where('panggil', 0)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'asc')->get();
        // dd($antrian);
        return view('modules.antrian_poli.playlist', compact('antrian'))->with(['start' => 1, 'no' => 4]);
    }

    public function ajaxSuara()
    {
        $antrian = AntrianPoli::with(['register_antrian.poli'])
            ->whereIn('poli_id', ['1', '23', '24'])
            ->where('panggil', 0)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'asc')->get();

        return view('modules.antrian_poli.playlist_ajax', compact('antrian'))->with(['start' => 1, 'no' => 4]);
    }

    public function ajaxSuaraTv2()
    {
        $antrian = AntrianPoli::with(['register_antrian.poli'])
            ->whereIn('poli_id', ['12', '11', '8', '20', '7', '17'])
            ->where('panggil', 0)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('id', 'asc')->get();
        // $poli = json_encode($antrian);
        // return $poli;
        // dd($antrian);
        return view('modules.antrian_poli.playlist_ajax_tv2', compact('antrian'))->with(['start' => 1, 'no' => 4]);
    }

    // public function panggil($id = '') {

    // 	// DB::table('antrians')->where('id', $id)->update(['status' => 1, 'loket' => 1]);
    // 	$atr = Antrian::find($id);
    // 	$regis = Registrasi::where('antrian_id',$id)->first();
    // 	// if(!$regis){
    // 	// 	$regis = Registrasi::where('antrian_poli_id',$id)->first();
    // 	// }
    // 	if($regis->nomorantrian){
    // 		// JIKA ADA UPDATE TASKID 3
    // 		$ID = config('app.consid_antrean');
    // 		date_default_timezone_set('UTC');
    // 		$t = time();
    // 		$dat = "$ID&$t";
    // 		$secretKey = config('app.secretkey_antrean');
    // 		$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
    // 		$completeurl = config('app.antrean_url_web_service')."antrean/updatewaktu";
    // 		$arrheader = array(
    // 			'X-cons-id: ' . $ID,
    // 			'X-timestamp: ' . $t,
    // 			'X-signature: ' . $signature,
    // 			'user_key:'. config('app.user_key_antrean'),
    // 			'Content-Type: application/json',
    // 		);

    // 		$updatewaktu   = '{
    // 			"kodebooking": "'.$regis->nomorantrian.'",
    // 			"taskid": 3,
    // 			"waktu": "'.round(microtime(true) * 1000).'"
    // 		 }'; 
    // 		 $session2 = curl_init($completeurl);
    // 		 curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
    // 		 curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
    // 		 curl_setopt($session2, CURLOPT_POST, TRUE);
    // 		 curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
    // 		 $resp = curl_exec($session2);
    // 		//  dd($resp);
    // 	}

    // 	$atr->status = 1;
    // 	$atr->loket = 3;
    // 	$atr->update();
    // 	return redirect('tindakan');
    // }

    public function panggilkembali($nomor, $poli, $reg_id)
    {
        $polis = Poli::where('id', $poli)->first();
        // $antrian = AntrianPoli::where('registrasi_id',$reg_id)->where('nomor',$nomor)->where('tanggal',date('Y-m-d'))->where('kelompok',$polis->kelompok)->first();
        // // dd($antrian);
        // if($antrian){
        // 	$antrian->status = $antrian->status+1;
        // 	$antrian->panggil = 0;
        // 	$antrian->nomor = $nomor;
        // 	$antrian->registrasi_id = $reg_id;
        // 	$antrian->save();
        // }

        $cekkedua = AntrianPoli::where('registrasi_id', $reg_id)->first();
        if (!$cekkedua) {
            $antrian = new AntrianPoli();
            $antrian->nomor = $nomor;
            $antrian->suara = $nomor . '.mp3';
            $antrian->status = 1;
            $antrian->panggil = 0;
            $antrian->poli_id = $poli;
            $antrian->registrasi_id = $reg_id;
            $antrian->tanggal = date('Y-m-d');
            $antrian->loket = session('no_loket') ? session('no_loket') : @$polis->loket;
            $antrian->kelompok = $polis->kelompok;
            $antrian->save();
        }
        // if($antrian){

        // }else{
        // 
        // }
        Flashy::info('Sedang memanggil antrian poli.');
        return redirect('/tindakan');
    }

    public function panggilkembali2($nomor, $id, $poli, $reg_id)
    {
        $d = AntrianPoli::where('id', $id)->first();

        $regis = Registrasi::where('id', $reg_id)->first();
        
        // $hisSep = HistoriSep::where('registrasi_id',$reg_id)->first();
        // dd($regis->no_sep);

        if(validasi_sep()){
            if($regis->bayar == 1){
                if(!$regis->no_sep){
                    Flashy::error('Gagal Memanggil Pasien, karena pasien belum terbit SEP');
                    return redirect()->back();
                }
    
            }
        }
        @updateTaskId(4,$regis->nomorantrian);
        // dd($regis);
        // if(!$regis){
        // 	$regis = Registrasi::where('antrian_poli_id',$id)->first();
        // }
        if ($regis->nomorantrian) {
            // JIKA ADA UPDATE TASKID 3
            $ID = config('app.consid_antrean');
            date_default_timezone_set('Asia/Jakarta');
            $t = time();
            $dat = "$ID&$t";
            $secretKey = config('app.secretkey_antrean');
            $signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
            $completeurl = config('app.antrean_url_web_service') . "antrean/updatewaktu";
            $arrheader = array(
                'X-cons-id: ' . $ID,
                'X-timestamp: ' . $t,
                'X-signature: ' . $signature,
                'user_key:' . config('app.user_key_antrean'),
                'Content-Type: application/json',
            );

            $updatewaktu   = '{
					"kodebooking": "' . $regis->nomorantrian . '",
					"taskid": 3,
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
            $session2 = curl_init($completeurl);
            curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
            curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
            curl_setopt($session2, CURLOPT_POST, TRUE);
            curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
            $resp = curl_exec($session2);
            //  dd($resp);
        }
        // $d->nomor = $nomor;
        $d->status = $d->status + 1;
        $d->registrasi_id =  $reg_id;
        $d->panggil = '0';
        $d->sudah_dipanggil = 1;
        $d->update();
        Flashy::info('Sedang Memanggil Antrian PoliKlinik');
        return redirect('/tindakan');
    }


    public function registrasi($id, $jenis)
    {
        $d = Antrian::find($id);
        $d->status = 3;
        $d->update();
        // DB::table('antrian3')->where('id', $id)->update(['status' => 3]);
        session(['no_loket' => 3]);
        if ($jenis == 'jkn') {
            session(['antrian_id' => $id]);
            return redirect('registrasi/create');
        } elseif ($jenis == 'umum') {
            session(['antrian_id' => $id]);
            return redirect()->route('registrasi.create_umum');
        }
    }

    public function reg_pasienlama($id, $jenis)
    {
        $d = Antrian::find($id);
        $d->status = 3;
        $d->update();
        // DB::table('antrian3')->where('id', $id)->update(['status' => 3]);
        session(['no_loket' => 3]);
        session(['antrian_id' => $id]);
        if ($jenis == 'jkn') {
            return redirect('registrasi');
        } elseif ($jenis == 'umum') {
            session(['jenis' => 'umum']);
            return redirect('registrasi');
        }
    }

    public function reg_blm_terdata($id, $jenis)
    {
        $d = Antrian::find($id);
        $d->status = 3;
        $d->update();
        // DB::table('antrian3')->where('id', $id)->update(['status' => 3]);
        session(['no_loket' => 3]);
        session(['antrian_id' => $id, 'blm_terdata' => true]);
        if ($jenis == 'jkn') {
            return redirect('registrasi/create');
        } elseif ($jenis == 'umum') {
            return redirect('registrasi/create_umum');
        }
    }

    public function prosesAntrian(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'poli' => 'required',
                'dokter' => 'required',
                'antrian_id' => 'required',
            ]);
            if ($validator->fails()) {
                $res = [
                    "status" => false,
                    "msg" => $validator->errors()->first()
                ];
                return response()->json($res);
            }
            // insert antrian poli
            $find = Antrian::find($request->antrian_id); // find antrian
            $antrian_poli = [
                "nomor" => $find->nomor,
                "suara" => $find->suara,
                "status" => 0, // jml telah dipanggil
                "panggil" => 0, // 0: blm dipanggil, 1: sudah dipanggil
                "tanggal" => $find->tanggal,
                "loket" => $find->loket,
                "kelompok" => $find->kelompok
            ];
            $antrian = AntrianPoli::create($antrian_poli);

            $data = [
                'poli_id' => $request->poli,
                'dokter_id' => $request->dokter,
                'id_antrian' => $request->antrian_id,
                'antrian_poli' => $this->antrianPoli($request->poli, date('Y-m-d')),
                'antrian_poli_id' => $antrian->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            DB::table('registrasi_antrian')->insert($data);
            DB::commit();
            $res = [
                "status" => true,
                "msg" => $request->all()
            ];
            return response()->json($res);
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                "status" => false,
                "msg" => $e->getMessage()
            ];
            return response()->json($res);
        }
    }

    public function antrianPoli($poli_id = NULL, $tgl = NULL)
    {
        $poli = RegistrasiAntrian::where('poli_id', $poli_id)->where('created_at', 'like', $tgl . '%')->count();
        return $poli + 1;
    }

    public function layarlcdtv1()
    {
        //$data['poli'] = Poli::whereIn('politype', ['J'])->where('layar_lcd','1')->orderBy('nama')->get();
        $data['poli'] = Poli::join('antrian_poli', 'polis.id', '=', 'antrian_poli.poli_id')
            ->join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->select('polis.id', 'pasiens.nama')
            ->whereIn('polis.politype', ['J'])->where('polis.layar_lcd', '1')
            // ->where('antrian_poli.created_at', 'like', date('Y-m-d') . '%')
            ->orderBy('polis.nama')->get();
        //dd($data['poli']);
        $dp           = [];

        foreach ($data['poli'] as $key => $grid1) {
            // if($grid1->id == 1){
            // 	dd()
            $dataGrid1[] = [
                'id'   => $grid1->id,
                'nama' => $grid1->nama,
            ];
            $dp[] = [
                'id' => $grid1->id
            ];
            // }
            // if($grid1->id == 24){
            //     $dataGrid2[]= [
            //         'id' =>$grid1->id,
            //         'nama' =>$grid1->nama,
            //     ];
            // 	$dp[] = [
            // 		'id' =>$grid1->id
            // 	];
            // }
            // if($grid1->id == 23){
            //     $dataGrid3[]= [
            //         'id' =>$grid1->id,
            //         'nama' =>$grid1->nama,
            //     ];
            // 	$dp[] = [
            // 		'id' =>$grid1->id
            // 	];
            // }
            // if($grid1->id == 20){
            //     $dataGrid4[]= [
            //         'id' =>$grid1->id,
            //         'nama' =>$grid1->nama,
            //     ];
            // 	$dp[] = [
            // 		'id' =>$grid1->id
            // 	];
            // }

        }

        $data['grid'] = [
            'grid1' => $dataGrid1, //grid1
            // 'neurologi' => $dataGrid2, //grid2
            // 'penyakitdalam' => $dataGrid3, //grid3
            // 'mcu' => $dataGrid4, //grid3

        ];

        // $data['poli'] = Poli::whereIn('politype', ['J'])->where('layar_lcd',1)->whereIn('id',['1'])->get();
        // $poli = json_encode($data['poli']);

        //dd($data['grid']);

        $poli = json_encode($dp);
        // dd($data['poli']);
        return view('modules.antrian_poli.layarlcdtv1', compact('data', 'poli'));
    }

    public function layarlcdtv2()
    {
        //$data['poli'] = Poli::whereIn('politype', ['J'])->where('layar_lcd','1')->orderBy('nama')->get();
        $data['poli'] = Poli::join('antrian_poli', 'polis.id', '=', 'antrian_poli.poli_id')
            ->join('registrasis', 'antrian_poli.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->select('polis.id', 'pasiens.nama')
            ->whereIn('polis.politype', ['J'])->where('polis.layar_lcd', '1')
            // ->where('antrian_poli.created_at', 'like', date('Y-m-d') . '%')
            ->orderBy('polis.nama')->get();

        $dp           = [];

        foreach ($data['poli'] as $key => $grid1) {

            $dataGrid1[] = [
                'id'   => $grid1->id,
                'nama' => $grid1->nama,
            ];
            $dp[] = [
                'id' => $grid1->id
            ];
        }

        $data['grid'] = [
            'grid1' => $dataGrid1, //grid1
        ];


        $poli = json_encode($dp);
        // dd($data['poli']);
        return view('modules.antrian_poli.layarlcdtv2', compact('data', 'poli'));
    }



    // Antrian NEW
    public function updateStatusPanggil($id)
    {
        $antrian = AntrianPoli::find($id);
        $antrian->panggil = 1;
        $antrian->save();
        return response()->json(['message' => 'Update Panggilan dari id: ' . $antrian->id]);
    }
    // TV1
    public function poliklinikTv1()
    {
        // Get latest antrian
        $antrianRM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 20)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        return view('modules.antrian_poli.new.tv_1', compact('antrianRM'));
    }
    public function ajaxTv1()
    {
        $antrianRM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 20)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianRM];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];
        return response()->json(array_values($data));
    }

    public function ajaxTv1BelumDipanggil()
    {
        $antrianRMBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 20)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Order
        foreach ($antrianRMBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianRMBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianRMBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianRMBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianRMBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianRMBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianRMBP  = $antrianRMBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianRMBP  = $antrianRMBP->values()->all();
        return response()->json($antrianRMBP);
    }

    // TV2
    public function poliklinikTv2()
    {
        $antrianKM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 16)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_2', compact('antrianKM'));
    }
    public function ajaxTv2()
    {
        $antrianKM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 16)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianKM];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv2BelumDipanggil()
    {
        $antrianKMBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 16)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Order
        foreach ($antrianKMBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianKMBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianKMBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianKMBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianKMBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianKMBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianKMBP  = $antrianKMBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianKMBP  = $antrianKMBP->values()->all();
        return response()->json($antrianKMBP);
    }

    // TV3 Paru, Penyakit Dalam, Jantung
    public function poliklinikTv3()
    {
        $antrianPR = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 41)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianD = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 2)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianJ = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 14)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_3', compact('antrianPR', 'antrianD', 'antrianJ'));
    }
    public function ajaxTv3()
    {
        $antrianPR = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 41)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrianD = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 2)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrianJ = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 14)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianPR, $antrianD, $antrianJ];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv3BelumDipanggil()
    {
        $antrianPRBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 41)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Order
        foreach ($antrianPRBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianPRBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianPRBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianPRBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianPRBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianPRBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianPRBP  = $antrianPRBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianPRBP  = $antrianPRBP->values()->all();


        $antrianDBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 2)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Order
        foreach ($antrianDBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianDBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianDBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianDBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianDBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianDBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianDBP  = $antrianDBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianDBP  = $antrianDBP->values()->all();

        $antrianJBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 14)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Order
        foreach ($antrianJBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianJBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianJBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianJBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianJBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianJBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianJBP  = $antrianJBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianJBP  = $antrianJBP->values()->all();

        return response()->json([
            $antrianPRBP,
            $antrianDBP,
            $antrianJBP
        ]);
    }

    // TV4 Anestesi, Bedah, Orthopedi, Saraf
    public function poliklinikTv4()
    {
        $antrianAN = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 9)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianB = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 5)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianO = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 18)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianSR = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 21)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();


        return view('modules.antrian_poli.new.tv_4', compact('antrianAN', 'antrianB', 'antrianO', 'antrianSR'));
    }
    public function ajaxTv4()
    {
        $antrianAN = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 9)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianB = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 5)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianO = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 18)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianSR = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 21)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianAN, $antrianB, $antrianO, $antrianSR];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];


        return response()->json(array_values($data));
    }

    public function ajaxTv4BelumDipanggil()
    {
        $antrianANBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 9)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianANBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianANBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianANBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianANBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianANBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianANBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianANBP  = $antrianANBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianANBP  = $antrianANBP->values()->all();


        $antrianBBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 5)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianBBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianBBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianBBP  = $antrianBBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianBBP  = $antrianBBP->values()->all();


        $antrianOBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 18)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianOBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianOBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianOBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianOBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianOBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianOBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianOBP  = $antrianOBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianOBP  = $antrianOBP->values()->all();

        $antrianSRBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 21)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianSRBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianSRBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianSRBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianSRBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianSRBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianSRBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianSRBP  = $antrianSRBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianSRBP  = $antrianSRBP->values()->all();

        return response()->json([
            $antrianANBP,
            $antrianBBP,
            $antrianOBP,
            $antrianSRBP
        ]);
    }

    // TV5 Bedah Anak, BEdah Syaraf, Aster, Jantung Anak
    public function poliklinikTv5()
    {
        $antrianBA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 28)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianBS = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 11)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianAS = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 10)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianJA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 30)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_5', compact('antrianBA', 'antrianBS', 'antrianAS', 'antrianJA'));
    }
    public function ajaxTv5()
    {
        $antrianBA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 28)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianBS = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 11)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianAS = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 10)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianJA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 30)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianBA, $antrianBS, $antrianAS, $antrianJA];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv5BelumDipanggil()
    {
        $antrianBABP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 28)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianBABP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBABP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianBABP  = $antrianBABP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianBABP  = $antrianBABP->values()->all();

        $antrianBSBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 11)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianBSBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBSBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBSBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianBSBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBSBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBSBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianBSBP  = $antrianBSBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianBSBP  = $antrianBSBP->values()->all();


        $antrianASBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 10)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianASBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianASBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianASBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianASBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianASBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianASBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianASBP  = $antrianASBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianASBP  = $antrianASBP->values()->all();


        $antrianJABP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 30)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianJABP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianJABP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianJABP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianJABP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianJABP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianJABP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianJABP  = $antrianJABP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianJABP  = $antrianJABP->values()->all();


        return response()->json([
            $antrianBABP,
            $antrianBSBP,
            $antrianASBP,
            $antrianJABP
        ]);
    }

    // TV6 Hematologi Onkologi, MCU, Kulit dan Kelamin
    public function poliklinikTv6()
    {
        $antrianH = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 13)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianMCU = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 35)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianKK = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 17)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_6', compact('antrianH', 'antrianMCU', 'antrianKK'));
    }
    public function ajaxTv6()
    {
        $antrianH = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 13)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianMCU = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 35)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianKK = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 17)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianH, $antrianMCU, $antrianKK];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];
        return response()->json(array_values($data));
    }

    public function ajaxTv6BelumDipanggil()
    {
        $antrianHBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 13)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianHBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianHBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianHBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianHBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianHBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianHBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianHBP  = $antrianHBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianHBP  = $antrianHBP->values()->all();


        $antrianMCUBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 35)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianMCUBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianMCUBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianMCUBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianMCUBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianMCUBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianMCUBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianMCUBP  = $antrianMCUBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianMCUBP  = $antrianMCUBP->values()->all();


        $antrianKKBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 17)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianKKBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianKKBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianKKBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianKKBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianKKBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianKKBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianKKBP  = $antrianKKBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianKKBP  = $antrianKKBP->values()->all();

        return response()->json([
            $antrianHBP,
            $antrianMCUBP,
            $antrianKKBP,
        ]);
    }

    // TV7 Anak, Obgyn
    public function poliklinikTv7()
    {
        $antrianA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 8)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianKB = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 15)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_7', compact('antrianA', 'antrianKB'));
    }
    public function ajaxTv7()
    {
        $antrianA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 8)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianKB = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 15)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianA, $antrianKB];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv7BelumDipanggil()
    {
        $antrianABP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 8)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianABP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianABP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianABP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianABP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianABP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianABP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianABP  = $antrianABP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianABP  = $antrianABP->values()->all();


        $antrianKBBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 15)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianKBBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianKBBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianKBBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianKBBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianKBBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianKBBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianKBBP  = $antrianKBBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianKBBP  = $antrianKBBP->values()->all();
        return response()->json([
            $antrianABP,
            $antrianKBBP,
        ]);
    }

    // TV8 Mata, THT, Gizi, Psikiatri
    public function poliklinikTv8()
    {
        $antrianM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 6)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianT = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 22)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        // $antrianGZ = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
        //     ->where('poli_id', 12)
        //     ->where('status', '!=', 0)
        //     ->orderBy('updated_at', 'DESC')
        //     ->first();
        // $antrianP = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
        //     ->where('poli_id', 19)
        //     ->where('status', '!=', 0)
        //     ->orderBy('updated_at', 'DESC')
        //     ->first();

        return view('modules.antrian_poli.new.tv_8', compact('antrianM', 'antrianT'));
    }
    public function ajaxTv8()
    {
        $antrianM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 6)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianT = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 22)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        // $antrianGZ = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
        //     ->where('poli_id', 12)
        //     ->where('status', '!=', 0)
        //     ->where('panggil', 0)
        //     ->orderBy('updated_at', 'DESC')
        //     ->first();
        // $antrianP = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
        //     ->where('poli_id', 19)
        //     ->where('status', '!=', 0)
        //     ->where('panggil', 0)
        //     ->orderBy('updated_at', 'DESC')
        //     ->first();

        $antrian = [$antrianM, $antrianT];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv8BelumDipanggil()
    {
        $antrianMBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 6)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianMBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianMBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianMBP  = $antrianMBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianMBP  = $antrianMBP->values()->all();


        $antrianTBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 22)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianTBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianTBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianTBP  = $antrianTBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianTBP  = $antrianTBP->values()->all();


        // $antrianGZBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
        //     ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
        //     ->whereNull('registrasis.deleted_at')
        //     ->where('antrian_poli.poli_id', 12)
        //     ->where('sudah_dipanggil', 0)
        //     ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
        //     ->where('antrian_poli.tanggal', date('Y-m-d'))
        //     ->select('registrasis.input_from', 'antrian_poli.kelompok as kelompok_antrian', 'antrian_poli.nomor as nomor_antrian', 'registrasis.nomorantrian', 'pasiens.nama')
        //     ->get();
        // // Order
        // foreach ($antrianGZBP as $key => $antrian) {
        //     if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
        //         $antrianGZBP[$key]->cara_daftar = 'Registrasi Online';
        //     } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
        //         $antrianGZBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
        //     } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
        //         $antrianGZBP[$key]->cara_daftar = 'Registrasi Perjanjian';
        //     } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
        //         $antrianGZBP[$key]->cara_daftar = 'Registrasi Onsite';
        //     } else {
        //         $antrianGZBP[$key]->cara_daftar = 'Registrasi';
        //     }
        //     if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
        //         // Bukan Online / JKN
        //         $antrian->kelompok_   = $antrian->kelompok_antrian;
        //         $antrian->urutan_     = intval($antrian->nomor_antrian);
        //     } else {
        //         // Online JKN
        //         $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
        //         $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
        //     }
        // }
        // $antrianGZBP  = $antrianGZBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianGZBP  = $antrianGZBP->values()->all();


        // $antrianPBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
        //     ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
        //     ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
        //     ->whereNull('registrasis.deleted_at')
        //     ->where('antrian_poli.poli_id', 19)
        //     ->where('sudah_dipanggil', 0)
        //     ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
        //     ->where('antrian_poli.tanggal', date('Y-m-d'))
        //     ->select('registrasis.input_from', 'antrian_poli.kelompok as kelompok_antrian', 'antrian_poli.nomor as nomor_antrian', 'registrasis.nomorantrian', 'pasiens.nama')
        //     ->get();
        // // Order
        // foreach ($antrianPBP as $key => $antrian) {
        //     if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
        //         $antrianPBP[$key]->cara_daftar = 'Registrasi Online';
        //     } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
        //         $antrianPBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
        //     } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
        //         $antrianPBP[$key]->cara_daftar = 'Registrasi Perjanjian';
        //     } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
        //         $antrianPBP[$key]->cara_daftar = 'Registrasi Onsite';
        //     } else {
        //         $antrianPBP[$key]->cara_daftar = 'Registrasi';
        //     }
        //     if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
        //         // Bukan Online / JKN
        //         $antrian->kelompok_   = $antrian->kelompok_antrian;
        //         $antrian->urutan_     = intval($antrian->nomor_antrian);
        //     } else {
        //         // Online JKN
        //         $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
        //         $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
        //     }
        // }
        // $antrianPBP  = $antrianPBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianPBP  = $antrianPBP->values()->all();

        return response()->json([
            $antrianMBP,
            $antrianTBP,
            // $antrianGZBP,
            // $antrianPBP
        ]);
    }

    // TV9 Gigi dan Mulut, Edodonsi, Bedah Mulut
    public function poliklinikTv9()
    {
        $antrianG = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 3)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianGE = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 34)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianBM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 4)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_9', compact('antrianG', 'antrianGE', 'antrianBM'));
    }

    public function ajaxTv9()
    {
        $antrianG = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 3)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianGE = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 34)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianBM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 4)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianG, $antrianGE, $antrianBM];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv9BelumDipanggil()
    {
        $antrianGBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 3)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Ordering agar sama dengan di menu dokter
        foreach ($antrianGBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianGBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianGBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianGBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianGBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianGBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianGBP  = $antrianGBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianGBP  = $antrianGBP->values()->all();


        $antrianGEBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 34)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Ordering agar sama dengan di menu dokter
        foreach ($antrianGEBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianGEBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianGEBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianGEBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianGEBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianGEBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianGEBP  = $antrianGEBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianGEBP  = $antrianGEBP->values()->all();


        $antrianBMBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 4)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Ordering agar sama dengan di menu dokter
        foreach ($antrianBMBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBMBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBMBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianBMBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBMBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBMBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianBMBP  = $antrianBMBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianBMBP  = $antrianBMBP->values()->all();

        return response()->json([
            $antrianGBP,
            $antrianGEBP,
            $antrianBMBP,
        ]);
    }

    // TV10 Bedah Anak dan Orthopedi
    public function poliklinikTv10()
    {
        $antrianOrto = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 18)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianBA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 28)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_10', compact('antrianOrto', 'antrianBA'));
    }

    public function ajaxTv10()
    {
        $antrianOrto = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 18)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianBA = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 28)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianOrto, $antrianBA];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv10BelumDipanggil()
    {
        $antrianOrtoBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 18)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Ordering agar sama dengan di menu dokter
        foreach ($antrianOrtoBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianOrtoBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianOrtoBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianOrtoBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianOrtoBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianOrtoBP[$key]->cara_daftar = 'Registrasi';
            }
            
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianOrtoBP  = $antrianOrtoBP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianOrtoBP  = $antrianOrtoBP->values()->all();


        $antrianBABP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 28)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();

        // Ordering agar sama dengan di menu dokter
        foreach ($antrianBABP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBABP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBABP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        // $antrianBABP  = $antrianBABP->sortBy(function ($antrian) {
        //     return [$antrian['kelompok_'], $antrian['urutan_']];
        // });
        // $antrianBABP  = $antrianBABP->values()->all();

        return response()->json([
            $antrianOrtoBP,
            $antrianBABP,
        ]);
    }

    // TV11 THT dan urologi
    public function poliklinikTv11()
    {
        $antrianM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 44)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianT = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 22)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        return view('modules.antrian_poli.new.tv_11', compact('antrianM', 'antrianT'));
    }

    public function ajaxTv11()
    {
        $antrianM = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 44)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianT = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 22)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $antrian = [$antrianM, $antrianT];
        $antrian = array_filter($antrian, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $antrian,
        ];

        return response()->json(array_values($data));
    }

    public function ajaxTv11BelumDipanggil()
    {
        $antrianMBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 44)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianMBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianMBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianMBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }

        $antrianTBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 22)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get();
        // Order
        foreach ($antrianTBP as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru'  || $antrian->input_from == 'regperjanjian_online') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianTBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianTBP[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }

        return response()->json([
            $antrianMBP,
            $antrianTBP,
        ]);
    }

    // Antrian Baru Per Poli
    public function displayAntrianPerPoli($poli_id)
    {
        // Get latest antrian
        $poli = Poli::find($poli_id);
        $lastCall = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', $poli_id)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        return view('modules.antrian_poli.new.poli.master-display', compact('lastCall', 'poli'));
    }
    public function ajaxAntrianPerPoli(Request $req)
    {
        $antrian = AntrianPoli::with(['register_antrian.pasien', 'poli'])
            ->where('tanggal', date('Y-m-d'))
            ->where('poli_id', $req->poli_id)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        // dd($antrian);
        // if ($antrian && !status_antrolo()) {
        //     if(@$antrian->register_antrian->nomorantrian_jkn){
        //         @$antrian->kelompok = @$antrian->register_antrian->nomorantrian_jkn;
        //     }else{
        //         if (strlen($antrian->kelompok) > 3 && $antrian->kelompok[3] === 'O') {
        //             $antrian->kelompok = substr($antrian->kelompok, 0, 3) . substr($antrian->kelompok, 4);
        //         }

        //     }
        // }

        $currentCall = [$antrian];
        $currentCall = array_filter($currentCall, function ($item) {
            return $item !== null;
        });

        $data = [
            'antrian' => $currentCall,
        ];
        // dd($data);

        return response()->json(array_values($data));
    }

    public function ajaxAntrianPerPoliBP($poli_id)
    {
        $antrianBP = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', $poli_id)
            ->where('sudah_dipanggil', 0)
            // ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->orderBy('registrasis.nomorantrian_jkn', 'ASC')
            // ->select('registrasis.input_from', 'antrian_poli.kelompok as kelompok_antrian', 'antrian_poli.nomor as nomor_antrian', 'registrasis.nomorantrian', 'registrasis.nomorantrian_jkn', 'pasiens.nama')
            ->select(
                'registrasis.input_from',
                'antrian_poli.kelompok as kelompok_antrian',
                'antrian_poli.nomor as nomor_antrian',
                DB::raw('COALESCE(registrasis.nomorantrian_jkn, registrasis.nomorantrian) as nomorantrian'),
                'pasiens.nama'
            )
            ->get()
            ;
        // dd($antrianBP);

        // Order
        foreach ($antrianBP as $key => $antrian) {
            // Menentukan label cara daftar
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBP[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBP[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif (
                in_array($antrian->input_from, [
                    'regperjanjian', 'regperjanjian_lama', 
                    'regperjanjian_baru', 'regperjanjian_online'
                ])
            ) {
                $antrianBP[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif (
                in_array($antrian->input_from, [
                    'registrasi-1', 'registrasi-2', 
                    'registrasi-3', 'registrasi-4'
                ])
            ) {
                $antrianBP[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBP[$key]->cara_daftar = 'Registrasi';
            }
        
            // Hanya jika status_antrolo() aktif
            if (!status_antrolo()) {
                if (strlen($antrian->kelompok_antrian) > 3 && $antrian->kelompok_antrian[3] === 'O') {
                    $antrian->kelompok_antrian = substr($antrian->kelompok_antrian, 0, 3) . substr($antrian->kelompok_antrian, 4);
                }
            }
        
            // Menentukan kelompok_ dan urutan_ tergantung sumber input
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian_jkn)) {
                // Bukan Online / JKN
                $antrian->kelompok_ = $antrian->kelompok_antrian;
                $antrian->urutan_   = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $split = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian_jkn));
                $antrian->kelompok_ = $split[1];
                $antrian->urutan_   = intval($split[2]);
            }
        }

        // Sorting: INT di atas, INTO di bawah, lalu urut ASC berdasarkan urutan_
        if ($poli_id == 2) {
            $antrianBP = $antrianBP->sortBy(function ($item) {
                return [
                    $item->kelompok_ === 'INT' ? 0 : 1, // INT = prioritas 0, INTO = prioritas 1
                    $item->urutan_
                ];
            })->values();
        }
        
        
        return response()->json($antrianBP);
    }

    public function antrianPoliJantungDalam()
    {
        $lastCallJantung = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 14)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $lastCallDalam = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 2)
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        return view('modules.antrian_poli.new.poli.tv_jantung_dan_dalam', compact('lastCallJantung', 'lastCallDalam'));
    }

    public function ajaxAntrianJantungDalam()
    {
        $antrianJantung = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 14)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $antrianDalam = AntrianPoli::with(['register_antrian.pasien', 'poli'])->where('tanggal', date('Y-m-d'))
            ->where('poli_id', 2)
            ->where('status', '!=', 0)
            ->where('panggil', 0)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $currentCallJantung = [$antrianJantung];
        $currentCallJantung = array_filter($currentCallJantung, function ($item) {
            return $item !== null;
        });
        $dataJantung = [
            'antrian' => $currentCallJantung,
        ];
        $currentCallDalam = [$antrianDalam];
        $currentCallDalam = array_filter($currentCallDalam, function ($item) {
            return $item !== null;
        });
        $dataDalam = [
            'antrian' => $currentCallDalam,
        ];
        return response()->json([
            'jantung' => array_values($dataJantung),
            'dalam' => array_values($dataDalam),
        ]);
    }

    public function ajaxAntrianBPJantungDalam()
    {
        $antrianBPDalam = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 2)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select('registrasis.input_from', 'antrian_poli.kelompok as kelompok_antrian', 'antrian_poli.nomor as nomor_antrian', 'registrasis.nomorantrian', 'pasiens.nama')
            ->get();

        // Order
        foreach ($antrianBPDalam as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBPDalam[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBPDalam[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianBPDalam[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBPDalam[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBPDalam[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        $antrianBPDalam  = $antrianBPDalam->sortBy(function ($antrian) {
            return [$antrian['kelompok_'], $antrian['urutan_']];
        });
        $antrianBPDalam  = $antrianBPDalam->values()->all();


        // Jantung
        $antrianBPJantung = HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
            ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->leftJoin('antrian_poli', 'antrian_poli.id', '=', 'registrasis.antrian_poli_id')
            ->whereNull('registrasis.deleted_at')
            ->where('antrian_poli.poli_id', 14)
            ->where('sudah_dipanggil', 0)
            ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
            ->where('antrian_poli.tanggal', date('Y-m-d'))
            ->select('registrasis.input_from', 'antrian_poli.kelompok as kelompok_antrian', 'antrian_poli.nomor as nomor_antrian', 'registrasis.nomorantrian', 'pasiens.nama')
            ->get();

        // Order
        foreach ($antrianBPJantung as $key => $antrian) {
            if ($antrian->input_from == 'KIOSK Reservasi Lama' || $antrian->input_from == 'KIOSK Reservasi Baru') {
                $antrianBPJantung[$key]->cara_daftar = 'Registrasi Online';
            } elseif ($antrian->input_from == 'registrasi-ranap-langsung') {
                $antrianBPJantung[$key]->cara_daftar = 'Registrasi Ranap Langsung';
            } elseif ($antrian->input_from == 'regperjanjian' || $antrian->input_from == 'regperjanjian_lama' || $antrian->input_from == 'regperjanjian_baru' || $antrian->input_from == 'regperjanjian_online') {
                $antrianBPJantung[$key]->cara_daftar = 'Registrasi Perjanjian';
            } elseif ($antrian->input_from == 'registrasi-1' || $antrian->input_from == 'registrasi-2' || $antrian->input_from == 'registrasi-3' || $antrian->input_from == 'registrasi-4') {
                $antrianBPJantung[$key]->cara_daftar = 'Registrasi Onsite';
            } else {
                $antrianBPJantung[$key]->cara_daftar = 'Registrasi';
            }
            if (!baca_nomorantrian_bpjs(@$antrian->nomorantrian)) {
                // Bukan Online / JKN
                $antrian->kelompok_   = $antrian->kelompok_antrian;
                $antrian->urutan_     = intval($antrian->nomor_antrian);
            } else {
                // Online JKN
                $antrian->kelompok_   = split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[1];
                $antrian->urutan_     = intval(split_nomorantrian_online(baca_nomorantrian_bpjs(@$antrian->nomorantrian))[2]);
            }
        }
        $antrianBPJantung  = $antrianBPJantung->sortBy(function ($antrian) {
            return [$antrian['kelompok_'], $antrian['urutan_']];
        });
        $antrianBPJantung  = $antrianBPJantung->values()->all();

        return response()->json([
            'jantung' => $antrianBPJantung,
            'dalam' => $antrianBPDalam,
        ]);
    }
}
