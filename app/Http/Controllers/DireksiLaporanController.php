<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Rujukan;
use App\Historipengunjung;
use App\HistoriRawatInap;
use App\PengirimRujukan;
use Carbon\Carbon;
use Excel;
use Flashy;
use DB;

class DireksiLaporanController extends Controller
{
    public function indexIgd()
    {
			$data['carabayar']	= Carabayar::all();
			$data['rujukan']	= PengirimRujukan::all();

			$data['tga']		= "";
			$data['tgb']		= "";
			$data['crb']		= 0;
			$data['rjkn']		= 0;
			
			$data['darurat'] = Historipengunjung::with(['latest_icd10'])->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
					->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
					->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
					->where('histori_pengunjung.politipe', 'G')
					->select('registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe','registrasis.created_at as reg_created_at', 'registrasis.pengirim_rujukan')
					->get();
					
			return view('direksi.laporan.pengunjung-igd', $data);
    }

    public function filterIgd(Request $request)
    {
			request()->validate(['tga' => 'required', 'tgb' => 'required']);
			$data['carabayar']	= Carabayar::all();
			$data['rujukan']	= PengirimRujukan::all();
			$tga				= valid_date($request->tga) . ' 00:00:00';
			$tgb				= valid_date($request->tgb) . ' 23:59:59';

			$data['tga']		= $request->tga;
			$data['tgb']		= $request->tgb;
			$data['crb']		= $request->cara_bayar;
			$data['rjkn']		= $request->rujukan;

			$query = Historipengunjung::with(['latest_icd10'])->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
			->where('histori_pengunjung.politipe', 'G')
			->select('registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe','registrasis.created_at as reg_created_at', 'registrasis.pengirim_rujukan');
			
			if ($request->cara_bayar != 0) {
				$query->where('registrasis.bayar', '=', $request->cara_bayar);
			}

			if ($request->rujukan != 0) {
				$query->where('registrasis.pengirim_rujukan', '=', $request->rujukan);
			}

			$data['darurat'] = $query->get();
		// return $data['visite'];die;
				if ($request->submit == 'TAMPILKAN') {
					return view('direksi.laporan.pengunjung-igd', $data);
				}else{
            $data = $data['darurat'];
            Excel::create('Laporan Pengunjung Rawat Darurat', function ($excel) use ($data) {
                $excel->setTitle('Laporan Pengunjung Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Darurat');
                $excel->sheet('IGD', function ($sheet) use ($data) {
                    $sheet->loadView('direksi.excel.pengunjung-igd', [
                        'darurat' => $data
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function indexInap()
    {
			$data['carabayar']	= Carabayar::all();
			$data['rujukan']	= PengirimRujukan::all();

			$data['tga']		= "";
			$data['tgb']		= "";
			$data['crb']		= 0;
			$data['rjkn']		= 0;

			$data['irna'] = Historipengunjung::with(['latest_icd10','first_icd10','icd10','icd9'])->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
				->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->where('histori_pengunjung.politipe', 'I')
				->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
				->select('registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe','registrasis.created_at as reg_created_at', 'registrasis.pengirim_rujukan')
				->get();
			return view('direksi.laporan.pengunjung-inap', $data);
    }

    public function filterInap(Request $request)
    {   
			request()->validate(['tga' => 'required', 'tgb' => 'required']);
			$data['carabayar']	= Carabayar::all();
			$data['rujukan']	= PengirimRujukan::all();
			$tga				= valid_date($request->tga) . ' 00:00:00';
			$tgb				= valid_date($request->tgb) . ' 23:59:59';

			$data['tga']		= $request->tga;
			$data['tgb']		= $request->tgb;
			$data['crb']		= $request->cara_bayar;
			$data['rjkn']		= $request->rujukan;

			$query = Historipengunjung::with(['latest_icd10','first_icd10','icd10','icd9'])->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
			->where('histori_pengunjung.politipe', 'I')
			->select('registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_pengunjung.politipe','registrasis.created_at as reg_created_at', 'registrasis.pengirim_rujukan');

			if ($request->cara_bayar != 0) {
				$query->where('registrasis.bayar', '=', $request->cara_bayar);
			}

			// if ($request->rujukan != 0) {
			// 	$query->where('registrasis.rujukan', '=', $request->rujukan);
			// }

			if ($request->rujukan != 0) {
				$query->where('registrasis.pengirim_rujukan', '=', $request->rujukan);
			}

			$data['irna']		= $query->get();

		// $data['irna']		= HistoriRawatInap::with(['latest_icd10'])
		// 	->join('registrasis', 'registrasis.id', '=', 'histori_rawatinap.registrasi_id')
		// 	->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->whereBetween('histori_rawatinap.created_at', [$tga, $tgb])
		// 	->where('registrasis.bayar', ($request->cara_bayar == 0) ? '>' : '=', $request->cara_bayar)
		// 	->select('registrasis.id as registrasi_id', 'histori_rawatinap.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin','registrasis.created_at as reg_created_at')
		// 	->get();

		// return $data['visite'];die;
		if ($request->submit == 'TAMPILKAN') {
			return view('direksi.laporan.pengunjung-inap', $data);
		}else{
            $data = $data['irna'];
            Excel::create('Laporan Pengunjung Rawat Inap', function ($excel) use ($data) {
                $excel->setTitle('Laporan Pengunjung Rawat Inap')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Inap');
                $excel->sheet('Inap', function ($sheet) use ($data) {
                    $sheet->loadView('direksi.excel.pengunjung-inap', [
                        'irna' => $data
                    ]);
                });
            })->export('xlsx');
        }
    }

    public function indexJalan()
    {
			$data['carabayar']	= Carabayar::all();
			$data['rujukan']	= PengirimRujukan::all();

			$data['tga']		= "";
			$data['tgb']		= "";
			$data['crb']		= 0;
			$data['rjkn']		= 0;

			$data['rajal'] = Historipengunjung::with(['latest_icd10'])->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
				->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
				->where('histori_pengunjung.politipe', 'J')
				->select('registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'registrasis.poli_id','registrasis.created_at as reg_created_at', 'registrasis.pengirim_rujukan')
				->get();
			return view('direksi.laporan.pengunjung-jalan', $data);
    }

    public function filterJalan(Request $request)
    {
			request()->validate(['tga' => 'required', 'tgb' => 'required']);
			$data['carabayar']	= Carabayar::all();
			$data['rujukan']	= PengirimRujukan::all();
			$tga				= valid_date($request->tga) . ' 00:00:00';
			$tgb				= valid_date($request->tgb) . ' 23:59:59';

			$data['tga']		= $request->tga;
			$data['tgb']		= $request->tgb;
			$data['crb']		= $request->cara_bayar;
			$data['rjkn']		= $request->rujukan;

			$query = Historipengunjung::with(['latest_icd10'])->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
			->where('histori_pengunjung.politipe', 'J')
			->select('registrasis.id as registrasi_id', 'histori_pengunjung.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'registrasis.poli_id','registrasis.created_at as reg_created_at', 'registrasis.pengirim_rujukan');

			if ($request->cara_bayar != 0) {
				$query->where('registrasis.bayar', '=', $request->cara_bayar);
			}

			if ($request->rujukan != 0) {
				$query->where('registrasis.pengirim_rujukan', '=', $request->rujukan);
			}
			

			$data['rajal']		= $query->get();

		// return $data['visite'];die;
		if ($request->submit == 'TAMPILKAN') {
			return view('direksi.laporan.pengunjung-jalan', $data);
		}else{
            $data = $data['rajal'];
            Excel::create('Laporan Pengunjung Rawat Jalan', function ($excel) use ($data) {
                $excel->setTitle('Laporan Pengunjung Rawat Jalan')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Pengunjung Rawat Jalan');
                $excel->sheet('Jalan', function ($sheet) use ($data) {
                    $sheet->loadView('direksi.excel.pengunjung-jalan', [
                        'rajal' => $data
                    ]);
                });
            })->export('xlsx');
        }
    }
}
