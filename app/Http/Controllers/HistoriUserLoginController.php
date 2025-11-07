<?php

namespace App\Http\Controllers;
use DataTables;
use Excel;

class HistoriUserLoginController extends Controller {

	public function index() {
		return view('histori_user_login.index');
	}

	public function dataHistoriLogin() {
		$histori = \App\HistoriUserlogin::orderBy('created_at', 'desc')->get();
		return Datatables::of($histori)
			->addIndexColumn()
			->addColumn('nama', function ($histori) {
				return \App\User::find($histori->user_id)->name;
			})
			->addColumn('tanggal', function ($histori) {
				return $histori->created_at->format('d-m-Y H:i:s');
			})
			->make(true);
	}

	public function excelHistori($tga = '', $tgb = '') {
		if ($tga && $tgb) {
			$histori = \App\HistoriUserlogin::whereBetween('created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])->get();
		} else {
			$histori = \App\HistoriUserlogin::all();
		}
		Excel::create('Laporan Histori Login User ', function ($excel) use ($histori) {
			// Set the properties
			$excel->setTitle('Laporan Histori Login User')
				->setCreator('Digihealth')
				->setCompany('Digihealth')
				->setDescription('Laporan Histori Login User');
			$excel->sheet('Laporan Histori Login User', function ($sheet) use ($histori) {
				$row = 1;
				$no = 1;
				$sheet->row($row, [
					'No',
					'Nama',
					'IP Address',
					'Waktu',
				]);
				foreach ($histori as $key => $d) {
					$sheet->row(++$row, [
						$no++,
						\App\User::find($d->user_id)->name,
						$d->ip_address,
						$d->created_at,
					]);
				}
			});
		})->export('xlsx');
	}
}
