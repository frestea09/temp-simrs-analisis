<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganRM;
use App\HistorikunjunganRAD;
use App\HistorikunjunganIGD;
use App\KondisiAkhirPasien;
use App\Conf_rl\M_config31;
use App\Conf_rl\M_config33;
use App\Conf_rl\M_config34;
use App\Conf_rl\M_config35;
use App\Conf_rl\M_config36;
use App\Conf_rl\M_config37;
use App\Conf_rl\M_config38;
use App\Conf_rl\M_config39;
use App\Conf_rl\M_config310;
use App\Conf_rl\M_config311;
use App\Conf_rl\M_config312;
use Modules\Kamar\Entities\Kamar;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Registrasi;
use App\HRD\HrdPendidikan;
use App\HRD\HrdPendidikanKualifikasi;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Poli\Entities\Poli;
use App\RLKeluargaBerencana;
use App\Masterobat;
use App\Rawatinap;
use App\PengirimRujukan;
use Carbon\Carbon;
use Excel;
use DB;

class RlController extends Controller
{
    public function sepuluhBesarDiagnosa_irna() {
		return view('sirs.rl.10-besar-diagnosa-irna');
	}

	public function sepuluhBesarDiagnosaIrna_byTanggal(Request $request) {
		request()->validate(['batas' => 'required', 'tga' => 'required', 'tgb' => 'required']);
		$tga	= valid_date($request->tga) . ' 00:00:00';
		$tgb	= valid_date($request->tgb) . ' 23:59:59';
		if ($request['batas'] == 0) {
			// $data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" AND jenis = "TI"
			// 				GROUP BY icd10 ORDER BY jumlah DESC');
			$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '"AND icd10 NOT LIKE "O%" AND icd10 NOT LIKE "Z%" AND icd10 NOT LIKE "P%" AND icd10 NOT LIKE "Q%" AND icd10 NOT LIKE "R%" AND jenis = "TI" GROUP BY icd10 ORDER BY jumlah DESC');
		} else {
			// $data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" AND jenis = "TI"
			// 				GROUP BY icd10 ORDER BY jumlah DESC limit ' . $request['batas'] . '');
			$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '"AND icd10 NOT LIKE "O%" AND icd10 NOT LIKE "Z%" AND icd10 NOT LIKE "P%" AND icd10 NOT LIKE "Q%" AND icd10 NOT LIKE "R%" AND jenis = "TI" GROUP BY icd10 ORDER BY jumlah DESC limit ' . $request['batas'] . '');
        }
        // dd( $data );
		if ($request['view']) {
			return view('sirs.rl.10-besar-diagnosa-irna', compact('data', 'tga', 'tgb'))->with('no', 1);
		} elseif ($request['excel']) {
			Excel::create('Lap 10 besar diagnosa irna', function ($excel) use ($data) {
                $excel->setTitle('Lap 10 besar diagnosa irna')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Lap 10 besar diagnosa irna');
                $excel->sheet('Lap 10 besar diagnosa irna', function ($sheet) use ($data) {
                    $sheet->loadView('sirs.excel.10-besar-diagnosa-irna', [
                        'data' => $data
                    ]);
                });
            })->export('xlsx');
		}

	}
	
	public function sepuluhBesarDiagnosa_irj() {
		return view('sirs.rl.10-besar-diagnosa-irj');
	}

	public function sepuluhBesarDiagnosaIrj_byTanggal(Request $request) {
		request()->validate(['batas' => 'required', 'tga' => 'required', 'tgb' => 'required']);
		$tga	= valid_date($request->tga) . ' 00:00:00';
		$tgb	= valid_date($request->tgb) . ' 23:59:59';
		if ($request['batas'] == 0) {
			$irj = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" AND icd10 NOT LIKE "O%" AND icd10 NOT LIKE "Z%" AND icd10 NOT LIKE "P%" AND icd10 NOT LIKE "Q%" AND icd10 NOT LIKE "R%" AND jenis = "TA"
							GROUP BY icd10 ORDER BY jumlah DESC');
		} else {
			$irj = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" AND icd10 NOT LIKE "O%" AND icd10 NOT LIKE "Z%" AND icd10 NOT LIKE "P%" AND icd10 NOT LIKE "Q%" AND icd10 NOT LIKE "R%" AND jenis = "TA"
							GROUP BY icd10 ORDER BY jumlah DESC limit ' . $request['batas'] . '');
		}
		// dd( $irj );
		if ($request['view']) {
			return view('sirs.rl.10-besar-diagnosa-irj', compact('irj'))->with('no', 1);
		} elseif ($request['excel']) {
			Excel::create('Lap 10 besar diagnosa irj', function ($excel) use ($irj) {
                $excel->setTitle('Lap 10 besar diagnosa irj')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Lap 10 besar diagnosa irj');
                $excel->sheet('Lap 10 besar diagnosa irj', function ($sheet) use ($irj) {
                    $sheet->loadView('sirs.excel.10-besar-diagnosa-irj', [
                        'irj' => $irj
                    ]);
                });
            })->export('xlsx');
		}
	}
	
	public function kujungan_rawat_jalan() {
		$data['irj'] = DB::select('SELECT poli_id AS poli_id, sum(1) AS jumlah FROM histori_kunjungan_irj
		GROUP BY poli_id ORDER BY jumlah DESC limit 10');
		return view('sirs.rl.kunjungan-irj');
	}

	public function kujungan_rawat_jalanBytaggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $tga = valid_date($request['tga']). ' 00:00:00';
		// $tgb = valid_date($request['tgb']). ' 23:59:59';
        $tga = Carbon::createFromFormat('d-m-Y', $request['tga']);
        $tgb = Carbon::createFromFormat('d-m-Y', $request['tgb']);

        $tanggal = [];

        // Ambil bulan dan tahun dari tga
        $startMonth = $tga->month;
        $startYear = $tga->year;

        while ($startMonth <= $tgb->month && $startYear <= $tgb->year) {
            // Tentukan tanggal awal untuk bulan ini
            $currentTga = ($startMonth === $tga->month && $startYear === $tga->year) 
                        ? $tga->copy()->toDateString(). ' 00:00:00' 
                        : Carbon::createFromFormat('d-m-Y', '01-' . $startMonth . '-' . $startYear)->toDateString(). ' 00:00:00';
            
            // Tentukan tanggal akhir untuk bulan ini
            $endOfMonth = Carbon::createFromFormat('d-m-Y', '01-' . $startMonth . '-' . $startYear)->endOfMonth();
            
            // Jika bulan ini adalah bulan terakhir dari tgb
            if ($startMonth === $tgb->month && $startYear === $tgb->year) {
                $endOfMonth = $tgb; // gunakan tgb sebagai tanggal akhir
            }
            
            $tanggal[$startMonth] = [
                'tga' => $currentTga, // Tanggal awal bulan
                'tgb' => $endOfMonth->toDateString(). ' 23:59:59', // Tanggal akhir bulan,
                "month" => bulan($startMonth),
                "year" => $startYear,
            ];
            
            // Pindah ke bulan berikutnya
            if ($startMonth === 12) {
                $startMonth = 1; // reset ke Januari
                $startYear++; // tambahkan tahun
            } else {
                $startMonth++; // tambahkan bulan
            }
        }

        $data['irj'] = [];

        foreach ($tanggal as $key => $tgl) {
            $tga = $tgl['tga'];
            $tgb = $tgl['tgb'];

            $irj = DB::select('SELECT poli_id AS poli_id, sum(1) AS jumlah, GROUP_CONCAT(histori_kunjungan_irj.id) as tgl_lahir FROM histori_kunjungan_irj RIGHT JOIN pasiens ON histori_kunjungan_irj.pasien_id=pasiens.id WHERE histori_kunjungan_irj.created_at BETWEEN "' . $tga . '" AND "' . $tgb . '" GROUP BY histori_kunjungan_irj.poli_id ORDER BY jumlah DESC');
            $rehabmedik = HistorikunjunganRM::where('pasien_asal','TA')->whereBetween('created_at',[$tga,$tgb])->count();
            $radiologi = HistorikunjunganRAD::where('pasien_asal','TA')->whereBetween('created_at', [$tga,$tgb])->count();
            $rawatdarurat = \App\HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
                        ->whereBetween('histori_kunjungan_igd.created_at', [$tga,$tgb])
                        ->select('histori_kunjungan_igd.*', 'registrasis.bayar')
                        ->count();
            $conf_rl52 = ['Penyakit Dalam','Bedah','Kesehatan Anak (Neonatal)','Kesehatan Anak Lainnya','Obstetri & Gynecolog (Ibu Hamil)','Obstetri & Gynecolog Lainnya','Keluarga Berencana','Bedah Syaraf','Syaraf','Jiwa','Napza','Psikologi','THT','Mata','Kulit & Kelamin','Gigi & Mulut','Geriatri','Kardiologi','Radiologi','Bedah Ortopedi','Paru','Kusta','Umum','Rawat Darurat','Rehabilitasi Medik','Akupuntur Medik','Konsultasi Gizi','Day Care','Lain-lain'];

            $data['irj'][$key] = [
                "irj" => $irj,
                "rehabmedik" => $rehabmedik,
                "radiologi" => $radiologi,
                "rawatdarurat" => $rawatdarurat,
                "conf_rl52" => $conf_rl52,
                "month" => $tgl['month'],
                "year" => $tgl['year'],
            ];
        }

		if ($request['view']) {
			return view('sirs.rl.kunjungan-irj', $data)->with('no', 1);
			// return view('sirs.rl.kunjungan-irj', compact('irj','conf_rl52','rehabmedik','radiologi','rawatdarurat'))->with('no', 1);
		} elseif ($request['excel']) {
            Excel::create('Laporan RL 5.2 Kunjungan Rawat Jalan', function ($excel) use ($data) {
                $excel->setTitle('Laporan RL 5.2 Kunjungan Rawat Jalan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan RL 5.2 Kunjungan Rawat Jalan');
                $excel->sheet('RL 5.2', function ($sheet) use ($data) {
                    // $sheet->loadView('sirs.excel.kunjungan-irj', [
                    //     'irj' => $irj,
                    //     'conf_rl52' => $conf_rl52,
                    //     'rehabmedik' => $rehabmedik,
                    //     'radiologi' => $radiologi,
                    //     'rawatdarurat' => $rawatdarurat,
                    // ]);
                    $sheet->loadView('sirs.excel.kunjungan-irj', $data);
                });
            })->export('xlsx');
		}
	}

	public function tempat_tidur()
    {
        $data = M_config31::with('kamar.bed')->get();
        // dd($data);
        return view('sirs.rl.tempat-tidur', compact('data'))->with('no', 1);
    }

    public function tempat_tidurBytaggal(Request $request)
    {
        $rl_tempat_tidur = M_config31::with('kamar.bed')->get();

        if ($request['view']) {
            return view('sirs.rl.tempat-tidur', compact('rl_tempat_tidur'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('RL 1.3 Tempat Tidur', function ($excel) use ($rl_tempat_tidur) {
                $excel->setTitle('RL 1.3 Tempat Tidur')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 1.3 Tempat Tidur');
                $excel->sheet('RL 1.3', function ($sheet) use ($rl_tempat_tidur) {
                    $sheet->loadView('sirs.excel.tempat-tidur', [
                        'data' => $rl_tempat_tidur
                    ]);
                });
            })->export('xlsx');
        }
	}
	
	public function pelayanan()
    {
        return view('sirs.rl.pelayanan')->with('no', 1);
    }

    public function pelayananBytaggal(Request $req)
    {
        $data['thn']    = $req->tahun;

        $data['bulan']    = collect([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember']);
        $data['tahun']    = [];

		// dd($req->all());

        $data['inap'] = DB::table('rawatinaps')
                  ->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
                  ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                //   ->select('rawatinaps.*', 'registrasis.pulang')
                //   ->selectRaw('TIMESTAMPDIFF(HOUR, rawatinaps.tgl_masuk, rawatinaps.tgl_keluar) as diffhour')
                  ->selectRaw('COUNT(CASE WHEN registrasis.kondisi_akhir_pasien = 4 THEN registrasis.kondisi_akhir_pasien END) as keluar_mati')
                  ->selectRaw('COUNT(CASE WHEN registrasis.kondisi_akhir_pasien != 4 THEN registrasis.kondisi_akhir_pasien END) as keluar_hidup')
                  ->selectRaw('COUNT(registrasis.kondisi_akhir_pasien) as total_pasien')
                  ->selectRaw('COUNT(CASE WHEN registrasis.kondisi_akhir_pasien = 4 AND (TIMESTAMPDIFF(HOUR, rawatinaps.tgl_masuk, rawatinaps.tgl_keluar) < 48) THEN registrasis.kondisi_akhir_pasien END) as mati_kurang_48')
                  ->selectRaw('COUNT(CASE WHEN registrasis.kondisi_akhir_pasien = 4 AND (TIMESTAMPDIFF(HOUR, rawatinaps.tgl_masuk, rawatinaps.tgl_keluar) > 47) THEN registrasis.kondisi_akhir_pasien END) as mati_lebih_48')
                  ->selectRaw('SUM(ABS(DATEDIFF(IFNULL(rawatinaps.tgl_keluar, NOW()), rawatinaps.tgl_masuk))) as lama_rawat')
                  ->selectRaw('COUNT(CASE WHEN registrasis.kondisi_akhir_pasien = 4 AND pasiens.nama LIKE "BY%" THEN registrasis.kondisi_akhir_pasien END) as bayi_lahir_mati')
                  ->selectRaw('COUNT(CASE WHEN registrasis.kondisi_akhir_pasien != 4 AND pasiens.nama LIKE "BY%" THEN registrasis.kondisi_akhir_pasien END) as bayi_lahir_hidup')
                  ->selectRaw('MONTH(registrasis.created_at) as bln')
                  ->groupBy('bln')
                //   ->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                  ->whereYear('registrasis.created_at', $req->tahun)
                //   ->whereIn('rawatinaps.kamar_id', $kamar_id) 
                    // ->where('registrasis.pulang','4')
                  ->get();
            // dd($data);
        $data['kamar'] = Kamar::count();
        
        if ($req['view']) {
            return view('sirs.rl.pelayanan', compact('data'))->with('no', 1);
        } elseif ($req['excel']) {
            // return $request; die;
            Excel::create('RL 1.2 Pelayanan', function ($excel) use ($data) {
                $excel->setTitle('RL 1.2 Pelayanan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 1.2 Pelayanan');
                $excel->sheet('RL 1.2', function ($sheet) use ($data) {
                    $sheet->loadView('sirs.excel.pelayanan', [
                        'data' => $data
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function ketenagaan()
    {
        $pendidikan = HrdPendidikan::whereNotNull('kualifikasi_id')->get();
        $pegawai = Pegawai::whereNotNull('pendidikan_id')->get();
        $kualifikasi = HrdPendidikanKualifikasi::all();

        $data = [];
        foreach( $kualifikasi as $val ){ // kualifikasi
            $temp = [];
            foreach($pendidikan->where('kualifikasi_id',$val->id) as $d) { // pendidikan
                $jml_peg_L = 0;
                $jml_peg_P = 0;
                foreach($pegawai as $item){ // pegawai
                    if( $item->pendidikan_id == $d->id ){
                        if( $item->kelamin == "L" ){
                            $jml_peg_L += 1;
                        }else{
                            $jml_peg_P += 1;
                        }
                    }
                }
                $d->jml_laki = $jml_peg_L;
                $d->jml_perempuan = $jml_peg_P;
                $temp[] = $d;
            }
            $data[] = [
                "kualifikasi" => $val->nama,
                "data" => $temp
            ];
        }

        $rl_ketenagaan = $data;

        return view('sirs.rl.ketenagaan', compact('rl_ketenagaan'))->with('no', 1);
    }

    public function ketenagaanBytaggal(Request $request)
    {
        $pendidikan = HrdPendidikan::whereNotNull('kualifikasi_id')->get();
        $pegawai = Pegawai::whereNotNull('pendidikan_id')->get();
        $kualifikasi = HrdPendidikanKualifikasi::all();

        $data = [];
        foreach( $kualifikasi as $val ){ // kualifikasi
            $temp = [];
            foreach($pendidikan->where('kualifikasi_id',$val->id) as $d) { // pendidikan
                $jml_peg_L = 0;
                $jml_peg_P = 0;
                foreach($pegawai as $item){ // pegawai
                    if( $item->pendidikan_id == $d->id ){
                        if( $item->kelamin == "L" ){
                            $jml_peg_L += 1;
                        }else{
                            $jml_peg_P += 1;
                        }
                    }
                }
                $d->jml_laki = $jml_peg_L;
                $d->jml_perempuan = $jml_peg_P;
                $temp[] = $d;
            }
            $data[] = [
                "kualifikasi" => $val->nama,
                "data" => $temp
            ];
        }

        $rl_ketenagaan = $data;
        // dd( $request->all() );
        if ($request['view']) {
            return view('sirs.rl.ketenagaan', compact('rl_ketenagaan'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 2 Ketenagaan', function ($excel) use ($rl_ketenagaan) {
                $excel->setTitle('RL 2 Ketenagaan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 2 Ketenagaan');
                $excel->sheet('RL 2', function ($sheet) use ($rl_ketenagaan) {
                    $sheet->loadView('sirs.excel.ketenagaan', [
                        'rl_ketenagaan' => $rl_ketenagaan
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kegitan_rujukan()
    {
        return view('sirs.rl.rujukan')->with('no', 1);
    }

    public function kegitan_rujukanBytaggal(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $poli = Poli::where('politype','J')->get();
        // $rujukan = PengirimRujukan::all();
        $rujukan = DB::table('rujukans')->get();
        $result = HistorikunjunganIRJ::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_irj.registrasi_id')
                ->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                // ->whereIn('registrasis.jenis_pasien', ['1', '2'])
                // ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                // ->whereNotNull('histori_kunjungan_irj.poli_id')
                // ->groupBy('histori_kunjungan_irj.registrasi_id')
                // ->select(DB::raw($case))
                // ->first()
                // ->toArray();
                // ->limit(2)
                // ->where('histori_kunjungan_irj.poli_id',1)
                // ->where('registrasis.rujukan',null)
                ->get();
        $kegitan_rujukan = [];
        foreach( $poli as $v ){
            $dt = $result->where('poli_id',$v->id);
            $datarujukan = [];

            foreach( $rujukan as $r ){
                $datarujukan[] = [
                    $r->nama => $dt->where('rujukan',$r->id)->count()
                ];
            }
            // dd($dt->where('rujukan',null));
            $datarujukan[] = [
                "null" => $dt->where('rujukan',null)->count()
            ];
            $kegitan_rujukan[] = [
                "poli" => $v->nama,
                "data" => [
                    "rujukan" => $datarujukan
                ]
            ];
        };

        if ($request['view']) {
            return view('sirs.rl.rujukan', compact('kegitan_rujukan','rujukan'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('Laporan RL 3.14 Kegiatan Rujukan', function ($excel) use ($kegitan_rujukan) {
                $excel->setTitle('Laporan RL 3.14 Kegiatan Rujukan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan RL 3.14 Kegiatan Rujukan');
                $excel->sheet('RL 3.14', function ($sheet) use ($kegitan_rujukan) {
                    $sheet->loadView('sirs.excel.rujukan', [
                        'kegitan_rujukan' => $kegitan_rujukan
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kegiatan_rehabilitasi_medik()
    {
        return view('sirs.rl.rehabilitasi-medik')->with('no', 1);
    }

    public function kegiatan_rehabilitasi_medikBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $kegiatan_rehabilitasi_medik = M_config39::leftJoin('tarifs', 'tarifs.conf_rl39_id', '=', 'conf_rl39.id_conf_rl39')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl39_id', 1)
            ->selectRaw('conf_rl39.*, COUNT(folios.tarif_id) as count')
            ->groupBy('conf_rl39.id_conf_rl39')
            ->whereBetween('folios.created_at', [$tga, $tgb])
            ->get();

        if ($request['view']) {
            return view('sirs.rl.rehabilitasi-medik', compact('kegiatan_rehabilitasi_medik'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.9 Pelayanan Rehabilitasi Medik', function ($excel) use ($kegiatan_rehabilitasi_medik) {
                $excel->setTitle('RL 3.9 Pelayanan Rehabilitasi Medik')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.9 Pelayanan Rehabilitasi Medik');
                $excel->sheet('RL 3.9', function ($sheet) use ($kegiatan_rehabilitasi_medik) {
                    $sheet->loadView('sirs.excel.rehabilitasi-medik', [
                        'kegiatan_rehabilitasi_medik' => $kegiatan_rehabilitasi_medik
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kesehatan_jiwa()
    {
        $data = ['Psikotes','Konsultasi','Terapi Medikamentosa','Elektro Medik','Psikoterapi','Play Therapy','Rehabilitasi Medik Psikiatrik'];
        return view('sirs.rl.kesehatan-jiwa', compact('data'))->with('no', 1);
    }

    public function kesehatan_jiwaBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $rl_kesehatan_jiwa = M_config311::leftJoin('tarifs', 'tarifs.conf_rl311_id', '=', 'conf_rl311.id_conf_rl311')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl311_id', 1)
            ->selectRaw('conf_rl311.*, COUNT(folios.tarif_id) as count')
            ->groupBy('conf_rl311.id_conf_rl311')
            ->whereBetween('folios.created_at', [$tga, $tgb])
            ->get();

        if ($request['view']) {
            return view('sirs.rl.kesehatan-jiwa', compact('rl_kesehatan_jiwa'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.11 Kesehatan Jiwa', function ($excel) use ($rl_kesehatan_jiwa) {
                $excel->setTitle('RL 3.11 Kesehatan Jiwa')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.11 Kesehatan Jiwa');
                $excel->sheet('RL 3.11', function ($sheet) use ($rl_kesehatan_jiwa) {
                    $sheet->loadView('sirs.excel.kesehatan-jiwa', [
                        'rl_kesehatan_jiwa' => $rl_kesehatan_jiwa
                    ]);
                });
            })->export('xlsx');
        }
    }
	
	public function pengadaanObat()
	{
        $data['obat_seluruh_obat'] = Masterobat::count();
        $data['obat_seluruh_formularium_obat'] = Masterobat::where('formularium', 'Y')->count();
        $data['stok_obat_generik_formularium'] = Masterobat::where('generik', NULL)->where('formularium', 'Y')->count();
        $data['stok_obat_generik_non_formularium'] = Masterobat::where('generik', NULL)->where('non_formularium', 'Y')->count();
        $data['stok_obat'] = Masterobat::where('formularium', 'Y')->where('non_formularium', 'Y')->sum('saldo');

		return view('sirs.rl.pengadaan-obat',compact('data'));
	}

	public function pengadaanObatFilter(Request $request)
	{
        $data['obat_seluruh_obat'] = Masterobat::count();
        $data['obat_seluruh_formularium_obat'] = Masterobat::where('formularium', 'Y')->count();
        $data['stok_obat_generik_formularium'] = Masterobat::where('generik', NULL)->where('formularium', 'Y')->count();
        $data['stok_obat_generik_non_formularium'] = Masterobat::where('generik', NULL)->where('non_formularium', 'Y')->count();
        $data['stok_obat'] = Masterobat::where('formularium', 'Y')->where('non_formularium', 'Y')->sum('saldo');

        Excel::create('RL 3.13a Pengadaan Obat', function ($excel) use ($data) {
            $excel->setTitle('RL 3.13a Pengadaan Obat')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('RL 3.13a Pengadaan Obat');
            $excel->sheet('RL 3.13', function ($sheet) use ($data) {
                $sheet->loadView('sirs.excel.pengadaan-obat', [
                    'data' => $data
                ]);
            });
        })->export('xlsx');
	}

	public function pelayananResep()
	{
        $data['rawat_jalan_formalium_non'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRJ%')
        ->whereDate('penjualandetails.created_at',Carbon::today())    
        ->count();
        $data['rawat_jalan_formalium'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRJ%')
            ->where('generik', NULL)->where('formularium', 'Y')
            ->whereDate('penjualandetails.created_at',Carbon::today())
            ->count();
        $data['rawat_jalan_formalium_non_genrik'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRJ%')
            ->where('generik', NULL)->where('formularium', NULL)
            ->whereDate('penjualandetails.created_at',Carbon::today())
            ->count();

        $data['rawat_igd_formalium_non'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRD%')
        ->whereDate('penjualandetails.created_at',Carbon::today())    
        ->count();
        $data['rawat_igd_formalium'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRD%')
            ->where('generik', NULL)->where('formularium', 'Y')
            ->whereDate('penjualandetails.created_at',Carbon::today())
            ->count();
        $data['rawat_igd_formalium_non_generik'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRD%')
            ->where('generik', NULL)->where('formularium', NULL)
            ->whereDate('penjualandetails.created_at',Carbon::today())
            ->count();

        $data['rawat_irna_formalium_non'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRI%')
        ->whereDate('penjualandetails.created_at',Carbon::today())    
        ->count();
        $data['rawat_irna_formalium'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRI%')
            ->where('generik', NULL)->where('formularium', 'Y')
            ->whereDate('penjualandetails.created_at',Carbon::today())
            ->count();
        $data['rawat_irna_formalium_non_generik'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRI%')
            ->where('generik', NULL)->where('formularium', 'Y')
            ->whereDate('penjualandetails.created_at',Carbon::today())
            ->count();

		return view('sirs.rl.pelayanan-resep',compact('data'));
	}

	public function pelayananResepFilter(Request $request)
	{
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']) . ' 00:00:00';
        $tgb = valid_date($request['tgb']) . ' 23:59:59';

        $data['rawat_jalan_formalium_non'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRJ%')
       ->whereBetween('penjualandetails.created_at',[$tga,$tgb])    
        ->count();
        $data['rawat_jalan_formalium'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRJ%')
            ->where('generik', NULL)->where('formularium', 'Y')
           ->whereBetween('penjualandetails.created_at',[$tga,$tgb])
            ->count();
        $data['rawat_jalan_formalium_non_genrik'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRJ%')
            ->where('generik', NULL)->where('formularium', NULL)
           ->whereBetween('penjualandetails.created_at',[$tga,$tgb])
            ->count();

        $data['rawat_igd_formalium_non'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRD%')
       ->whereBetween('penjualandetails.created_at',[$tga,$tgb])    
        ->count();
        $data['rawat_igd_formalium'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRD%')
            ->where('generik', NULL)->where('formularium', 'Y')
           ->whereBetween('penjualandetails.created_at',[$tga,$tgb])
            ->count();
        $data['rawat_igd_formalium_non_generik'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRD%')
            ->where('generik', NULL)->where('formularium', NULL)
           ->whereBetween('penjualandetails.created_at',[$tga,$tgb])
            ->count();

        $data['rawat_irna_formalium_non'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRI%')
       ->whereBetween('penjualandetails.created_at',[$tga,$tgb])    
        ->count();
        $data['rawat_irna_formalium'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRI%')
            ->where('generik', NULL)->where('formularium', 'Y')
           ->whereBetween('penjualandetails.created_at',[$tga,$tgb])
            ->count();
        $data['rawat_irna_formalium_non_generik'] = \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')->where('penjualandetails.no_resep', 'like', '%FRI%')
            ->where('generik', NULL)->where('formularium', 'Y')
           ->whereBetween('penjualandetails.created_at',[$tga,$tgb])
            ->count();
        
        if ($request['view']) {
            return view('sirs.rl.pelayanan-resep',compact('data'));
        }else{
            Excel::create('RL 3.13b Pelayanan Resep', function ($excel) use ($data) {
                $excel->setTitle('RL 3.13b Pelayanan Resep')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.13b Pelayanan Resep');
                $excel->sheet('RL 3.13', function ($sheet) use ($data) {
                    $sheet->loadView('sirs.excel.pelayanan-resep', [
                        'data' => $data
                    ]);
                });
            })->export('xlsx');
        }
    }
    
    public function pelayanan_rawat_inap()
    {
        return view('sirs.rl.rawat-inap')->with('no', 1);
    }

    public function pelayanan_rawat_inapBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $awaltahun = \Carbon\Carbon::parse($tga)->startOfYear()->format('Y-m-d H:i:s');
        $akhirtahun = \Carbon\Carbon::parse($tga)->endOfYear()->format('Y-m-d H:i:s');
        $pelayanan_rawat_inap = [];

        $conf31 = M_config31::with('kamar')->get();
        foreach($conf31 as $d) {
          $eak = (object) array();
          $eak->kegiatan = $d->kegiatan;
          $eak->no = $d->nomer;
          $kamar_id = [];
          foreach($d->kamar as $kamar) {
            array_push($kamar_id, $kamar->id);
          }

          $tahunbaru = DB::table('rawatinaps')
                  ->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
                  ->whereDate('rawatinaps.tgl_masuk', '<=', $awaltahun)
                  ->whereDate('rawatinaps.tgl_keluar', '>=', $awaltahun)
                  ->whereIn('rawatinaps.kamar_id', $kamar_id) 
                  ->count();
          $eak->tahunbaru = $tahunbaru;
          $inap = DB::table('rawatinaps')
                  ->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
                  ->select('rawatinaps.*', 'registrasis.pulang')
                  ->selectRaw('TIMESTAMPDIFF(HOUR, rawatinaps.tgl_masuk, rawatinaps.tgl_keluar) as diffhour')
                  ->selectRaw('DATEDIFF(IFNULL(rawatinaps.tgl_keluar, NOW()), rawatinaps.tgl_masuk) as diffdays')
                  ->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                  ->whereIn('rawatinaps.kamar_id', $kamar_id) 
                  ->get();
          $masuk = $inap->count();
          $eak->masuk = $masuk;

          $keluar_hidup = $inap->where('registrasis.pulang', '!=', '4')
                          ->count();
          $eak->keluar_hidup = $keluar_hidup;

          $keluar_mati_kurang_48 = $inap->where('registrasis.pulang', '=', '4')
                                    ->where('diffhour', '<', '48')
                                    ->count();
          $eak->keluar_mati_kurang_48 = $keluar_mati_kurang_48;
          
          $keluar_mati_lebih_48 = $inap->where('registrasis.pulang', '=', '4')
                                    ->where('diffhour', '>=', '48')
                                    ->count();
          $eak->keluar_mati_lebih_48 = $keluar_mati_lebih_48;
                                  
          $lama_dirawat = $inap->sum('diffdays');
          $eak->lama_dirawat = $lama_dirawat;

          $tahunakhir = DB::table('rawatinaps')
                  ->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
                  ->where('rawatinaps.tgl_masuk', '<=', $akhirtahun)
                  ->where('rawatinaps.tgl_keluar', '>=', $akhirtahun)
                  ->whereIn('rawatinaps.kamar_id', $kamar_id) 
                  ->count();
          $eak->tahunakhir = $tahunakhir;
          
          $vvip = 0;
          $eak->vvip = $vvip;

          $vip = $inap->where('rawatinaps.kelas_id', '=', '17')->count();
          $eak->vip = $vip;

          $kelas1 = $inap->where('rawatinaps.kelas_id', '=', '2')->count();
          $eak->kelas1 = $kelas1;

          $kelas2 = $inap->where('rawatinaps.kelas_id', '=', '3')->count();
          $eak->kelas2 = $kelas2;

          $kelas3 = $inap->where('rawatinaps.kelas_id', '=', '4')->count();
          $eak->kelas3 = $kelas3;

          array_push($pelayanan_rawat_inap, $eak);
        }

        if ($request['view']) {
            return view('sirs.rl.rawat-inap', compact('pelayanan_rawat_inap'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.1 Pelayanan Rawat Inap', function ($excel) use ($pelayanan_rawat_inap) {
                $excel->setTitle('RL 3.1 Pelayanan Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.1 Pelayanan Rawat Inap');
                $excel->sheet('RL 3.13', function ($sheet) use ($pelayanan_rawat_inap) {
                    $sheet->loadView('sirs.excel.rawat-inap', [
                        'pelayanan_rawat_inap' => $pelayanan_rawat_inap
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kujungan_rawat_darurat()
    {
        return view('sirs.rl.rawat-darurat')->with('no', 1);
    }

    public function kujungan_rawat_daruratBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $poli = Poli::where('politype','G')->get();

        $rujukan = Rujukan::all();
        $kondisi = KondisiAkhirPasien::all();

        // $case = '';
        // foreach( $rujukan as $key => $val ){
        //     $case .= 'count(CASE WHEN registrasis.rujukan = '.$key.' THEN registrasis.rujukan END) as "'.$val.'",';
        // }
        // $case = rtrim($case, ',');
        $result = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
                ->whereBetween('histori_kunjungan_igd.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                // ->whereIn('registrasis.jenis_pasien', ['1', '2'])
                // ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                // ->whereNotNull('histori_kunjungan_irj.poli_id')
                // ->groupBy('histori_kunjungan_irj.registrasi_id')
                // ->select(DB::raw($case))
                // ->whereIn('registrasis.dokter_id',$di)
                // ->first()
                // ->toArray();
                // ->limit(2)
                // ->where('histori_kunjungan_irj.poli_id',1)
                // ->where('registrasis.rujukan',null)
                // ->where('histori_kunjungan_igd.triage_nama','IGD Anak')
                ->get();
        // dd( $result,$poli );
        // dd($result->where('triage_nama', 'IGD'));
        $rl_kujungan_rawat_darurat = [];
        foreach( $poli as $v ){
            $dt = $result->where('triage_nama',$v->nama);
            $datarujukan = [];
            $kondisiAkhir = [];
            // rujukan / non rujukan
            foreach( $rujukan as $r ){
                $datarujukan[$r->nama] = $dt->where('rujukan',$r->id)->count();
            }
            $datarujukan['null'] = $dt->where('rujukan',null)->count();
            // kondisi akhir
            foreach( $kondisi as $ka ){
                if($ka->id == 1 || $ka->id == 3 || $ka->id == 5){
                    $kondisiAkhir[$ka->namakondisi] = $dt->where('kondisi_akhir_pasien',$ka->id)->whereNotIn('status_reg', ['I1','I2', 'I3'])->count();
                }else{
                    $kondisiAkhir[$ka->namakondisi] = $dt->where('kondisi_akhir_pasien',$ka->id)->count();
                }
            }
            $kondisiAkhir["Inap"] = $dt->whereIn('status_reg',['I1','I2', 'I3'])->count();
            $kondisiAkhir["null"] = $dt->where('kondisi_akhir_pasien',null)->where('status_reg', '!=', 'I3')->count();

            $doa["Y"] = $dt->where('doa', 'Y')->count();
            $doa["N"] = $dt->where('doa', 'N')->count();
            $rl_kujungan_rawat_darurat[] = [
                "poli" => $v->nama,
                "data" => [
                    "rujukan" => $datarujukan,
                    "kondisi" => $kondisiAkhir,
                    "doa" => $doa,
                ]
            ];
            // dd($rl_kujungan_rawat_darurat);
        }
        // dd($rl_kujungan_rawat_darurat);

        if ($request['view']) {
            return view('sirs.rl.rawat-darurat', compact('rl_kujungan_rawat_darurat'))->with('no', 1);
        } elseif ($request['excel']) {
            Excel::create('Laporan RL 3.2 Kunjungan Rawat Darurat', function ($excel) use ($rl_kujungan_rawat_darurat) {
                $excel->setTitle('Laporan RL 3.2 Kunjungan Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan RL 3.2 Kunjungan Rawat Darurat');
                $excel->sheet('RL 3.2', function ($sheet) use ($rl_kujungan_rawat_darurat) {
                    $sheet->loadView('sirs.excel.rawat-darurat', [
                        'rl_kujungan_rawat_darurat' => $rl_kujungan_rawat_darurat
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kegiatan_kesehatan_gigi_dan_mulut()
    {
        return view('sirs.rl.gigi-dan-mulut')->with('no', 1);
    }

    public function kegiatan_kesehatan_gigi_dan_mulutBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $rl_kegiatan_kesehatan_gigi_dan_mulut =  M_config33::leftJoin('tarifs', 'tarifs.conf_rl33_id', '=', 'conf_rl33_new.id_conf_rl33')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl33_id', 1)
            ->selectRaw('conf_rl33_new.*, COUNT(folios.tarif_id) as count')
            ->groupBy('conf_rl33_new.id_conf_rl33')
            ->whereBetween('folios.created_at', [$tga, $tgb])
            ->get();
        // dd( $rl_kegiatan_kesehatan_gigi_dan_mulut );

        if ($request['view']) {
            return view('sirs.rl.gigi-dan-mulut', compact('rl_kegiatan_kesehatan_gigi_dan_mulut'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.3 Kegiatan Kesehatan Gigi dan Mulut', function ($excel) use ($rl_kegiatan_kesehatan_gigi_dan_mulut) {
                $excel->setTitle('RL 3.3 Kegiatan Kesehatan Gigi dan Mulut')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.3 Kegiatan Kesehatan Gigi dan Mulut');
                $excel->sheet('RL 3.3', function ($sheet) use ($rl_kegiatan_kesehatan_gigi_dan_mulut) {
                    $sheet->loadView('sirs.excel.gigi-dan-mulut', [
                        'rl_kegiatan_kesehatan_gigi_dan_mulut' => $rl_kegiatan_kesehatan_gigi_dan_mulut
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kegiatan_pembedahan()
    {
        return view('sirs.rl.pembedahan')->with('no', 1);
    }

    public function kegiatan_pembedahanBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $rl_pembedahan =  M_config36::leftJoin('tarifs', 'tarifs.conf_rl36_id', '=', 'conf_rl36_new.id_conf_rl36')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl36_id', 1)
            ->selectRaw('conf_rl36_new.*, COUNT(folios.tarif_id) as count')
            ->groupBy('conf_rl36_new.id_conf_rl36')
            ->whereBetween('folios.created_at', [$tga, $tgb])
        ->get();
        // dd( $rl_pembedahan );

        if ($request['view']) {
            return view('sirs.rl.pembedahan', compact('rl_pembedahan'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.6 Kegiatan Pembedahan', function ($excel) use ($rl_pembedahan) {
                $excel->setTitle('RL 3.6 Kegiatan Pembedahan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.6 Kegiatan Pembedahan');
                $excel->sheet('RL 3.6', function ($sheet) use ($rl_pembedahan) {
                    $sheet->loadView('sirs.excel.pembedahan', [
                        'rl_pembedahan' => $rl_pembedahan
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kegiatan_radiologi()
    {
        return view('sirs.rl.radiologi')->with('no', 1);
    }

    public function kegiatan_radiologiBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $kegiatan_radiologi = M_config37::leftJoin('tarifs', 'tarifs.conf_rl37_id', '=', 'conf_rl37.id_conf_rl37')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl37_id', 1)
            ->selectRaw('conf_rl37.*, COUNT(folios.tarif_id) as count')
            ->whereBetween('folios.created_at', [$tga, $tgb])
            ->groupBy('conf_rl37.id_conf_rl37')
            ->get();
        // dd( $kegiatan_radiologi );

        if ($request['view']) {
            return view('sirs.rl.radiologi', compact('kegiatan_radiologi'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.7 Kegiatan Radiologi', function ($excel) use ($kegiatan_radiologi) {
                $excel->setTitle('RL 3.7 Kegiatan Radiologi')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.7 Kegiatan Radiologi');
                $excel->sheet('RL 3.7', function ($sheet) use ($kegiatan_radiologi) {
                    $sheet->loadView('sirs.excel.radiologi', [
                        'kegiatan_radiologi' => $kegiatan_radiologi
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function pemeriksaan_laboratorium()
    {
        return view('sirs.rl.laboratorium')->with('no', 1);
    }

    public function pemeriksaan_laboratoriumBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $pemeriksaan_laboratorium = M_config38::leftJoin('tarifs', 'tarifs.conf_rl38_id', '=', 'conf_rl38.id_conf_rl38')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl38_id', 1)
            ->selectRaw('conf_rl38.*, COUNT(folios.tarif_id) as count')
            ->groupBy('conf_rl38.id_conf_rl38')
            ->whereBetween('folios.created_at', [$tga, $tgb])
            ->get();
        // dd($pemeriksaan_laboratorium);

        if ($request['view']) {
            return view('sirs.rl.laboratorium', compact('pemeriksaan_laboratorium'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.8 Pemeriksaan Laboratorium', function ($excel) use ($pemeriksaan_laboratorium) {
                $excel->setTitle('RL 3.8 Pemeriksaan Laboratorium')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.8 Pemeriksaan Laboratorium');
                $excel->sheet('RL 3.8', function ($sheet) use ($pemeriksaan_laboratorium) {
                    $sheet->loadView('sirs.excel.laboratorium', [
                        'pemeriksaan_laboratorium' => $pemeriksaan_laboratorium
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kebidanan()
    {
		$data['tga']		= '';
		$data['tgb']		= '';
		$data['p_icd10']	= [];
        return view('sirs.rl.kebidanan', $data)->with('no', 1);
    }

    public function kebidananFilter(Request $request)
    {
		$data['tga']	= valid_date($request->tga) . ' 00:00:00';
		$data['tgb']	= valid_date($request->tgb) . ' 23:59:59';

		$kebidanan = M_config34::all();

		$tarif = M_config34::join('tarifs','tarifs.conf_rl34_id','conf_rl34.id_conf_rl34')->pluck('id')->toArray();

		$result = Rawatinap::with(['registrasi.folio.tarif','registrasi.folio' => function($q) use($tarif){
					$q->whereIn('tarif_id',$tarif);
				}])
				->join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->whereBetween('rawatinaps.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				// ->limit(1)
				// ->groupBy('registrasis.rujukan')
                ->get();
        // dd($result);

		$rujukan = Rujukan::all();

		$data['result_kebidanan'] = [];
		foreach( $kebidanan as $key => $v ){
			$datarujukan = [];
			foreach( $rujukan as $kr => $rj ){ // rujukan
				$tarifRL34[$kr] = 0;
				$tarifRL34Hidup[$kr] = 0;
				$tarifRL34Mati[$kr] = 0;
				$tarifRL34Dirujuk[$kr] = 0;
				foreach($result as $val){ // result
					// foreach( $rujukan as $kr => $r ){
						// dd($val->registrasi->folio->tarif);
						foreach($val->registrasi->folio as $f){ // tarif
                            // dd($f->tarif->conf_rl34_id, $v->id_conf_rl34);
                            // dd($rj->id, $val->registrasi->rujukan);
							// dd($r->id, $val->registrasi->rujukan);
							if( ($f->tarif->conf_rl34_id == $v->id_conf_rl34 ) && ($rj->id == $val->registrasi->pengirim_rujukan) ){
								$tarifRL34[$kr] += 1;
								if( $val->registrasi->pulang == 4 ){ // mati
									$tarifRL34Mati[$kr] += 1;
								}elseif( $val->registrasi->pulang == 2 ){ // dirujuk
									$tarifRL34Dirujuk[$kr] += 1;
								}else{
									$tarifRL34Hidup[$kr] += 1;
								}
								// dd('stop');
							}
						}
						// $val->registrasi->folio->tarif->conf_rl34_id
						
					// }
				}
				$datarujukan[] = [
					$rj->nama => $tarifRL34[$kr],
					$rj->nama.' hidup' => $tarifRL34Hidup[$kr],
					$rj->nama.' mati' => $tarifRL34Mati[$kr],
					$rj->nama.' dirujuk' => $tarifRL34Mati[$kr],
				];
            }
					
			$data['result_kebidanan'][] = [
				"id" => $v->id_conf_rl34,
				"no" => $v->nomer,
				"nama" => $v->kegiatan,
				"rujukan" => $datarujukan
            ];
		}

		// dd($data);

		if ($request['submit'] == "TAMPILKAN") {
			return view('sirs.rl.kebidanan', $data)->with('no', 1);
		} else {
			$data = $data['result_kebidanan'];
			Excel::create('RL 3.4 Kebidanan', function ($excel) use ($data) {
                $excel->setTitle('RL 3.4 Kebidanan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.4 Kebidanan');
                $excel->sheet('RL 3.4 Kebidanan', function ($sheet) use ($data) {
                    $sheet->loadView('sirs.excel.kebidanan', [
                        'result_kebidanan' => $data
                    ]);
                });
            })->export('xlsx');
		}
    }

    public function pelayanan_khusus()
    {
        return view('sirs.rl.pelayanan-khusus')->with('no', 1);
    }

    public function pelayanan_khususBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $rl_pelayanan_khusus = M_config310::leftJoin('tarifs', 'tarifs.conf_rl310_id', '=', 'conf_rl310.id_conf_rl310')
            ->leftJoin('folios', 'folios.tarif_id', '=', 'tarifs.id')
            // ->where('tarifs.conf_rl310_id', 1)
            ->selectRaw('conf_rl310.*, COUNT(folios.tarif_id) as count')
            ->groupBy('conf_rl310.id_conf_rl310')
            ->whereBetween('folios.created_at', [$tga, $tgb])
            ->get();

        if ($request['view']) {
            return view('sirs.rl.pelayanan-khusus', compact('rl_pelayanan_khusus'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.10 Kegiatan Pelayanan Khusus', function ($excel) use ($rl_pelayanan_khusus) {
                $excel->setTitle('RL 3.10 Kegiatan Pelayanan Khusus')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.10 Kegiatan Pelayanan Khusus');
                $excel->sheet('RL 3.10', function ($sheet) use ($rl_pelayanan_khusus) {
                    $sheet->loadView('sirs.excel.pelayanan-khusus', [
                        'rl_pelayanan_khusus' => $rl_pelayanan_khusus
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function cara_bayar()
    {
        return view('sirs.rl.cara-bayar')->with('no', 1);
    }

    public function cara_bayarBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);

        $carabayar = Carabayar::all('id', 'carabayar');

        $inap = DB::table('rawatinaps')
                ->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
                // ->where('registrasis.status_reg', 'I2')
                ->whereNotNull('rawatinaps.tgl_keluar')
                ->select('rawatinaps.*', 'registrasis.bayar')
                ->selectRaw('DATEDIFF(IFNULL(rawatinaps.tgl_keluar, NOW()), rawatinaps.tgl_masuk) as diffdays')
                ->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->get();

          // $jalan = Registrasi::where('status_reg', 'like', 'J%')
          //         ->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
          //         ->get();
        $jalan = DB::table('histori_kunjungan_irj')
                ->join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
                ->select('histori_kunjungan_irj.*', 'registrasis.bayar')
                ->whereBetween('histori_kunjungan_irj.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->get();
        
        $rad = DB::table('histori_kunjungan_rad')
                ->join('registrasis', 'histori_kunjungan_rad.registrasi_id', '=', 'registrasis.id')
                ->select('histori_kunjungan_rad.*', 'registrasis.bayar')
                ->whereBetween('histori_kunjungan_rad.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->get();

        $lab = DB::table('histori_kunjungan_lab')
                ->join('registrasis', 'histori_kunjungan_lab.registrasi_id', '=', 'registrasis.id')
                ->select('histori_kunjungan_lab.*', 'registrasis.bayar')
                ->whereBetween('histori_kunjungan_lab.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
                ->get();

        foreach($carabayar as $cb) {
          $cb->jumlahinap = $inap->where('bayar', $cb->id)->count();
          $cb->hariinap = $inap->where('bayar', $cb->id)->sum('diffdays');
          $cb->jumlahjalan = $jalan->where('bayar', $cb->id)->count();
          $cb->jumlahrad = $rad->where('bayar', $cb->id)->count();
          $cb->jumlahlab = $lab->where('bayar', $cb->id)->count();
        }

        if ($request['view']) {
            return view('sirs.rl.cara-bayar', compact('carabayar'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.15 Cara Bayar', function ($excel) use ($carabayar) {
                $excel->setTitle('RL 3.15 Cara Bayar')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.15 Cara Bayar');
                $excel->sheet('RL 3.15', function ($sheet) use ($carabayar) {
                    $sheet->loadView('sirs.excel.cara-bayar', [
                        'carabayar' => $carabayar
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function kegiatan_pengujung() {
		$pengujung_baru = 0;
        $pengujung_lama = 0;
		return view('sirs.rl.pengunjung', compact('pengujung_baru','pengujung_lama'))->with('no', 1);
	}

	public function kegiatan_pengujungBytaggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);            
            $pengujung_baru = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('status', 'baru')
            ->count();
            $pengujung_lama = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->where('status', 'lama')
            ->count();
		if ($request['view']) {
            // return $pengujung; die;
			return view('sirs.rl.pengunjung', compact('pengujung_baru','pengujung_lama'))->with('no', 1);
		} elseif ($request['excel']) {
            Excel::create('RL 5.1 Pengunjung', function ($excel) use ($pengujung_baru,$pengujung_lama) {
                $excel->setTitle('RL 5.1 Pengunjung')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 5.1 Pengunjung');
                $excel->sheet('RL 5.1 Pengunjung', function ($sheet) use ($pengujung_baru,$pengujung_lama) {
                    $sheet->loadView('sirs.excel.pengunjung', [
                        'pengujung_baru' => $pengujung_baru,
                        'pengujung_lama' => $pengujung_lama,
                    ]);
                });
            })->export('xlsx');
		}
    }

    public function perinatologi()
    {
        $data['tga']		= '';
		$data['tgb']		= '';
		$data['p_icd10']	= [];
        return view('sirs.rl.perinatologi', $data)->with('no', 1);
    }

    public function perinatologiFilter(Request $request)
    {
		$data['tga']		= '';
		$data['tgb']		= '';

		$perinatologi = M_config35::all();
		// $poli = Poli::where('politype','J')->get();
        $rujukan = Rujukan::all();

        $result = Rawatinap::join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
                ->whereBetween('rawatinaps.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->where('rawatinaps.is_bayi','Y')
				->get();

        $data['result_perinatologi'] = [];
        foreach( $perinatologi as $v ){
			
            // $dt = $result->where('poli_id',$v->id);
            $datarujukan = [];

            foreach( $rujukan as $r ){
                $datarujukan[] = [
					$r->nama => $result->where('rujukan',$r->id)->count(),
					$r->nama." perinatologi_hidup" => $result->where('rujukan',$r->id)->where('perinatologi_hidup',$v->id_conf_rl35)->count(),
					$r->nama." perinatologi_mati" => $result->where('rujukan',$r->id)->where('perinatologi_mati',$v->id_conf_rl35)->count(),
					$r->nama." perinatologi_sebab_mati" => $result->where('rujukan',$r->id)->where('perinatologi_sebab_mati',$v->id_conf_rl35)->count(),
					"perinatologi_hidup" => $result->where('perinatologi_hidup',$v->id_conf_rl35)->count(),
					"perinatologi_mati" => $result->where('perinatologi_mati',$v->id_conf_rl35)->count(),
					"perinatologi_sebab_mati" => $result->where('perinatologi_sebab_mati',$v->id_conf_rl35)->count(),
					"dirujuk perinatologi_hidup" => $result->where('perinatologi_hidup',$v->id_conf_rl35)->where('pulang',2)->count(), // dirujuk
					"dirujuk perinatologi_mati" => $result->where('perinatologi_mati',$v->id_conf_rl35)->where('pulang',2)->count(), // dirujuk
					"dirujuk perinatologi_sebab_mati" => $result->where('perinatologi_sebab_mati',$v->id_conf_rl35)->where('pulang',2)->count(), // dirujuk
                ];
            }
            // dd($dt->where('rujukan',null));
            $datarujukan[] = [
				"null" => $result->where('rujukan',null)->count(),
				"null perinatologi_hidup" => $result->where('rujukan',null)->where('perinatologi_hidup',$v->id_conf_rl35)->count(),
				"null perinatologi_mati" => $result->where('rujukan',null)->where('perinatologi_mati',$v->id_conf_rl35)->count(),
				"null perinatologi_sebab_mati" => $result->where('rujukan',null)->where('perinatologi_sebab_mati',$v->id_conf_rl35)->count(),
				"perinatologi_hidup" => $result->where('perinatologi_hidup',$v->id_conf_rl35)->count(),
				"perinatologi_mati" => $result->where('perinatologi_mati',$v->id_conf_rl35)->count(),
				"perinatologi_sebab_mati" => $result->where('perinatologi_sebab_mati',$v->id_conf_rl35)->count(),
				"dirujuk perinatologi_hidup" => $result->where('perinatologi_hidup',$v->id_conf_rl35)->where('pulang',2)->count(), // dirujuk
				"dirujuk perinatologi_mati" => $result->where('perinatologi_mati',$v->id_conf_rl35)->where('pulang',2)->count(), // dirujuk
				"dirujuk perinatologi_sebab_mati" => $result->where('perinatologi_sebab_mati',$v->id_conf_rl35)->where('pulang',2)->count(), // dirujuk
            ];
            $data['result_perinatologi'][] = [
				"id" => $v->id_conf_rl35,
				"no" => $v->nomor,
				"nama" => $v->nama,
				"parent" => $v->parent_id,
				"rujukan" => $datarujukan
            ];
		}
		// dd( $data['result_perinatologi'] );
		if ($request['submit'] == "TAMPILKAN") {
			return view('sirs.rl.perinatologi', $data)->with('no', 1);
		} else {
			$data = $data['result_perinatologi'];
			Excel::create('RL 3.5 Perinatologi', function ($excel) use ($data) {
                $excel->setTitle('RL 3.5 Perinatologi')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.5 Perinatologi');
                $excel->sheet('RL 3.5 Perinatologi', function ($sheet) use ($data) {
                    $sheet->loadView('sirs.excel.perinatologi', [
                        'result_perinatologi' => $data
                    ]);
                });
            })->export('xlsx');
		}
    }

    public function keluarga_berencana()
    {
        return view('sirs.rl.keluarga-berencana')->with('no', 1);
    }

    public function keluarga_berencanaBytaggal(Request $request)
    {
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $tga = valid_date($request['tga']) . ' 00:00:00';
        $tgb = valid_date($request['tgb']) . ' 23:59:59';

        $data['keluarga_berencana'] = RLKeluargaBerencana::join('registrasis','registrasis.id','rl_keluarga_berencana.reg_id')
                            ->join('conf_rl312','conf_rl312.id_conf_rl312','rl_keluarga_berencana.conf_rl312_id')
                            ->whereBetween('registrasis.created_at', [$tga, $tgb])
                            ->select('rl_keluarga_berencana.*','conf_rl312.kegiatan','conf_rl312.id_conf_rl312 as id_rl')
                            ->get();
        $data['conf_rl312'] = M_config312::all();
        // dd($data['keluarga_berencana']);
        $result = [];
        foreach($data['conf_rl312'] as $val){
            $konseling = [
                "anc" => $data['keluarga_berencana']->where('konseling','anc')->where('id_rl',$val->id_conf_rl312)->count(),
                "pasca persalinan" => $data['keluarga_berencana']->where('konseling','pasca persalinan')->where('id_rl',$val->id_conf_rl312)->count()
            ];
            $cara_masuk = [
                "bukan rujukan" => $data['keluarga_berencana']->where('cara_masuk','bukan rujukan')->where('id_rl',$val->id_conf_rl312)->count(),
                "rujukan rawat inap" => $data['keluarga_berencana']->where('cara_masuk','rujukan rawat inap')->where('id_rl',$val->id_conf_rl312)->count(),
                "rujukan rawat jalan" => $data['keluarga_berencana']->where('cara_masuk','rujukan rawat jalan')->where('id_rl',$val->id_conf_rl312)->count(),
            ];
            $kondisi = [
                "pasca persalinan" => $data['keluarga_berencana']->where('kondisi','pasca persalinan')->where('id_rl',$val->id_conf_rl312)->count(),
                "abortus" => $data['keluarga_berencana']->where('kondisi','abortus')->where('id_rl',$val->id_conf_rl312)->count(),
                "lainnya" => $data['keluarga_berencana']->where('kondisi','lainnya')->where('id_rl',$val->id_conf_rl312)->count()
            ];
            $kunjungan_ulang = [
                "Y" => $data['keluarga_berencana']->where('kunjungan_ulang','Y')->where('id_rl',$val->id_conf_rl312)->count(),
                "T" => $data['keluarga_berencana']->where('kunjungan_ulang','T')->where('id_rl',$val->id_conf_rl312)->count()
            ];
            $result[] = [
                "metoda" => $val->kegiatan,
                "konseling" => $konseling,
                "cara_masuk" => $cara_masuk,
                "kondisi" => $kondisi,
                "kunjungan_ulang" => $kunjungan_ulang
            ];
        }

        // dd($result);

        if ($request['view']) {
            return view('sirs.rl.keluarga-berencana', compact('result'))->with('no', 1);
        } elseif ($request['excel']) {
            // return $request; die;
            Excel::create('RL 3.12Keluarga Berencana', function ($excel) use ($result) {
                $excel->setTitle('RL 3.12Keluarga Berencana')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('RL 3.12Keluarga Berencana');
                $excel->sheet('RL 3.12', function ($sheet) use ($result) {
                    $sheet->loadView('sirs.excel.keluarga-berencana', [
                        'result' => $result
                    ]);
                });
            })->export('xlsx');
        }
    }

    // TODO: refractor code
    public function pemakaianObat(Request $req){
        $data['tga']    = now()->format('d-m-Y');
        $data['tgb']    = now()->format('d-m-Y');
        $tga            = valid_date($data['tga']) . ' 00:00:00';
        $tgb            = valid_date($data['tgb']) . ' 23:59:59';
        $obats          = Masterobat
            ::leftJoin('penjualandetails', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
            ->whereBetween('penjualandetails.created_at', [$tga, $tgb]);

        $generik_all                = (clone $obats)->where('generik', 'Y')->where(function($query){
            $query->where('formularium', 'Y')->orWhere('non_formularium', 'Y');
        });
        $nonGenerik_formularium     = (clone $obats)->where('non_generik', 'Y')->where('formularium', 'Y');
        $nonGenerik_nonFormularium  = (clone $obats)->where('non_generik', 'Y')->where('non_formularium', 'Y');
    
        $data['datas']  = [
            'generik_all'   => [
                'label'         => 'Obat Generik (Formularium + Non Formularium',
                'count_rj'      =>  
                    (clone $generik_all)->where('penjualandetails.no_resep', 'LIKE', 'FRJ%')->sum('jumlah'),
                'count_igd'     =>  
                    (clone $generik_all)->where('penjualandetails.no_resep', 'LIKE', 'FRD%')->sum('jumlah'),
                'count_inap'    =>  
                    (clone $generik_all)->where('penjualandetails.no_resep', 'LIKE', 'FRI%')->sum('jumlah')
            ],
            'nonGenerik_formularium'   => [
                'label'         => 'Non Generik Formularium',
                'count_rj'      =>  
                    (clone $nonGenerik_formularium)->where('penjualandetails.no_resep', 'LIKE', 'FRJ%')->sum('jumlah'),
                'count_igd'     =>  
                    (clone $nonGenerik_formularium)->where('penjualandetails.no_resep', 'LIKE', 'FRD%')->sum('jumlah'),
                'count_inap'    =>  
                    (clone $nonGenerik_formularium)->where('penjualandetails.no_resep', 'LIKE', 'FRI%')->sum('jumlah')
            ],
            'nonGenerik_nonFormularium'   => [
                'label'         => 'Non Generik Non Formularium',
                'count_rj'      =>  
                    (clone $nonGenerik_nonFormularium)->where('penjualandetails.no_resep', 'LIKE', 'FRJ%')->sum('jumlah'),
                'count_igd'     =>  
                    (clone $nonGenerik_nonFormularium)->where('penjualandetails.no_resep', 'LIKE', 'FRD%')->sum('jumlah'),
                'count_inap'    =>  
                    (clone $nonGenerik_nonFormularium)->where('penjualandetails.no_resep', 'LIKE', 'FRI%')->sum('jumlah')
            ]
        ];
        $data['no'] =  1;
        return view('sirs.rl.pemakaian-obat', $data);
    }

    public function pemakaianObat_byTanggal(Request $req){
        $data['tga']    = $req->tga;
        $data['tgb']    = $req->tgb;
        $tga            = valid_date($req->tga) . ' 00:00:00';
        $tgb            = valid_date($req->tgb) . ' 23:59:59';
        $obats          = Masterobat
            ::leftJoin('penjualandetails', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
            ->whereBetween('penjualandetails.created_at', [$tga, $tgb]);

        $generik_all                = (clone $obats)->where('generik', 'Y')->where(function($query){
            $query->where('formularium', 'Y')->orWhere('non_formularium', 'Y');
        });
        $nonGenerik_formularium     = (clone $obats)->where('non_generik', 'Y')->where('formularium', 'Y');
        $nonGenerik_nonFormularium  = (clone $obats)->where('non_generik', 'Y')->where('non_formularium', 'Y');
    
        $data['datas']  = [
            'generik_all'   => [
                'label'         => 'Obat Generik (Formularium + Non Formularium',
                'count_rj'      =>  
                    (clone $generik_all)->where('penjualandetails.no_resep', 'LIKE', 'FRJ%')->sum('jumlah'),
                'count_igd'     =>  
                    (clone $generik_all)->where('penjualandetails.no_resep', 'LIKE', 'FRD%')->sum('jumlah'),
                'count_inap'    =>  
                    (clone $generik_all)->where('penjualandetails.no_resep', 'LIKE', 'FRI%')->sum('jumlah')
            ],
            'nonGenerik_formularium'   => [
                'label'         => 'Non Generik Formularium',
                'count_rj'      =>  
                    (clone $nonGenerik_formularium)->where('penjualandetails.no_resep', 'LIKE', 'FRJ%')->sum('jumlah'),
                'count_igd'     =>  
                    (clone $nonGenerik_formularium)->where('penjualandetails.no_resep', 'LIKE', 'FRD%')->sum('jumlah'),
                'count_inap'    =>  
                    (clone $nonGenerik_formularium)->where('penjualandetails.no_resep', 'LIKE', 'FRI%')->sum('jumlah')
            ],
            'nonGenerik_nonFormularium'   => [
                'label'         => 'Non Generik Non Formularium',
                'count_rj'      =>  
                    (clone $nonGenerik_nonFormularium)->where('penjualandetails.no_resep', 'LIKE', 'FRJ%')->sum('jumlah'),
                'count_igd'     =>  
                    (clone $nonGenerik_nonFormularium)->where('penjualandetails.no_resep', 'LIKE', 'FRD%')->sum('jumlah'),
                'count_inap'    =>  
                    (clone $nonGenerik_nonFormularium)->where('penjualandetails.no_resep', 'LIKE', 'FRI%')->sum('jumlah')
            ]
        ];
        $data['no'] =  1;

        return view('sirs.rl.pemakaian-obat', $data);
    }

    public function jumlahObat(Request $req){
        $obats  = Masterobat::leftJoin('logistik_batches', 'logistik_batches.masterobat_id', '=', 'masterobats.id');

        $generik_all                = (clone $obats)->where('generik', 'Y')->where(function($query){
            $query->where('formularium', 'Y')->orWhere('non_formularium', 'Y');
        });
        $nonGenerik_formularium     = (clone $obats)->where('non_generik', 'Y')->where('formularium', 'Y');
        $nonGenerik_nonFormularium  = (clone $obats)->where('non_generik', 'Y')->where('non_formularium', 'Y');
    
        $data['datas']  = [
            'generik_all'   => [
                'label'                 => 'Obat Generik (Formularium + Non Formularium',
                'jumlah_obat'           =>  (clone $generik_all)->groupBy('masterobats.id')->count(),
                'stok_obat'             =>  (clone $generik_all)->sum('stok'),
                'stok_obat_formularium' =>  '-',
            ],
            'nonGenerik_formularium'   => [
                'label'                 => 'Non Generik Formularium',
                'jumlah_obat'           =>  (clone $nonGenerik_formularium)->groupBy('masterobats.id')->count(),
                'stok_obat'             =>  '-',
                'stok_obat_formularium' =>  (clone $nonGenerik_formularium)->sum('stok'),

            ],
            'nonGenerik_nonFormularium'   => [
                'label'                 => 'Non Generik Non Formularium',
                'jumlah_obat'           =>  (clone $nonGenerik_nonFormularium)->groupBy('masterobats.id')->count(),
                'stok_obat'             =>  (clone $nonGenerik_nonFormularium)->sum('stok'),
                'stok_obat_formularium' =>  '-',
            ]
        ];
        $data['no'] =  1;
        return view('sirs.rl.jumlah-obat', $data);
    }

   

}
