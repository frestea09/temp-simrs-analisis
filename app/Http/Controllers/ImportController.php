<?php

namespace App\Http\Controllers;
use App\Mastersplit;
use App\Split;
use App\Biodata;
use App\HRD\HrdBiodata;
use App\HRD\HrdJabatan;
use App\Jadwaldokter;
use Excel;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Icd9\Entities\Icd9;
use Modules\Icd10\Entities\Icd10;
use Modules\Tarif\Entities\Tarif;
use Modules\Kelas\Entities\Kelas;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\HistoryKanza;
use App\Logistik\LogistikBatchBC;
use App\LogistikSupplier;
use App\MasterLicas;
use App\Masterobat;
use App\RisTindakan;
use App\Supliyer;
use Validator;
use DB;
use Modules\Pasien\Entities\Pekerjaan;
use Modules\Pasien\Entities\Province;
use Modules\Pasien\Entities\Regency;
use Modules\Pasien\Entities\Village;
use Modules\Pegawai\Entities\Pegawai;
use NumberFormatter;
use PhpMyAdmin\SqlParser\Utils\Formatter;

class ImportController extends Controller {

	public function templatePasien() {
		Excel::create('Template Data Pasien', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Data Pasien')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Data Pasien');
				$excel->sheet('Tarif Pasien', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'no_rm',
								'no_rm_lama',
								'kelamin',
								'alamat',
								'nohp',
							]);
					});
			})->export('xls');
	}

	public function importBiodata(Request $request) { 

		ini_set('max_execution_time', 0); //0=NOLIMIT
		//ini_set('memory_limit', '2048M');
		request()->validate(['excel' => 'required']);
		DB::beginTransaction();
        try{

			$excel  = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
				})->get();
          
			//rule
			$rowRules = [
				'id'      => 'required',
				'nama'      => 'required',
				'alamat'    => 'required',
				'tmplahir'  => 'required',
			];

			$pasienID = [];
            
			//Looping data
			foreach ($excels as $row) {

				$validator = Validator::make($row->toArray(), $rowRules);
				//if ($validator->fails()) {continue;
				//}
				$p = new Biodata();
				$p->pegawai_id     = $row['id'];
				$p->namalengkap    = $row['nama'];
				$p->alamat         = $row['alamat'];
				$p->tmplahir       = $row['tmplahir'];
				$p->tgllahir       = date("Y-m-d", strtotime($row['tgllahir']));
				$p->kelamin        = $row['kelamin'];
				$p->agama_id       = $row['agama'];
				$p->warganegara    = "WNI";
				$p->province_id    = 14;
				$p->regency_id     = 1410;
				$p->district_id    = 1405020;
				$p->village_id     = 1410020016;

				$p->save();
				array_push($pasienID, $p->id);
			}

			$biodata = Biodata::whereIn('id', $pasienID)->get();
			if ($biodata->count() == 0) {
				Flashy::info('Tidak ada data Biodata Pegawais yang diimport');
			} else {
				DB::commit();
				Flashy::success($biodata->count().' Data Biodata  berhasil diimport ke Database ');
			}
			// Return it's location
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Opsss Gagal Import data');
			return redirect('/cari-file-biodata');
		} 
	}

	public function importPasien(Request $request) { 
    
		ini_set('max_execution_time', 3000); //0=NOLIMIT
		ini_set('memory_limit', '2048M');
		
		// request()->validate(['excel' => 'required']);

		DB::beginTransaction();
        try{

			$excel  = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
				})->get();
          
			//rule
			$rowRules = [
				'no_rm'     => 'required',
				'nama'      => 'required',
				// 'alamat'    => 'required',
				// 'tmplahir'  => 'required',
				// 'tgllahir'  => 'required',
				// 'kelamin'   => 'required',
				// 'nohp'      => 'required',
				// 'no_ktp'    => 'required',
				// 'alamat'    => 'required',
				// 'ibu_kandung'  => 'required',
				// 'pekerjaan_id' => 'required',
			];

			$pasienID = [];
			//Looping data
			foreach ($excels as $row) {
				//    dd($row['no_identitas']);
				// $validator = Validator::make($row->toArray(), $rowRules);
				
			//if ($validator->fails()) {continue;
			//}

			 $cekdata = Pasien::where('no_rm',$row['no_rm'])->first();
			
			 if(!$cekdata){
				 
				 if($row['nama'] !== 'X' || $row['nama'] !== ''){

					// dd($row);


					$tgllahir = explode('/',$row['tgllahir']);
					$p = new Pasien();
					//$p->no_rm          = sprintf("%06s", $row['no_rm']);
					$p->no_rm          = $row['no_rm'];
					$p->nama           = $row['nama'];
					$p->alamat         = $row['alamat'];
					$p->tmplahir       = $row['tmplahir'];
					$p->tgllahir       = $row['tgllahir'];
					$p->kelamin        = $row['kelamin'];
					$p->golda          = $row['golda'];
					$p->nohp           = '0'.@$row['telepon'];
					$p->nik            = (int) $row['no_identitas'];
					$p->alamat         = $row['alamat'];
					$p->ibu_kandung    = $row['ibu_kandung'];
					$p->jkn            = '-';
					$p->no_jkn         = (int) $row['no_kartu'];
					$p->province_id    = (int) $row['province_id'];
					$p->regency_id    =  (int) $row['regency_id'];
					$p->district_id   = (int) $row['district_id'];
					$p->village_id    = (int) $row['village_id'];
					$p->agama_id   = $row['agama_id'];
					$p->rt   = $row['rt'];
					$p->rw   = $row['rw'];
					$p->negara   = $row['negara'];
					$p->pendidikan_id   = $row['pendidikan_id'];
					$p->pekerjaan_id   = $row['pekerjaan_id'];
					$p->status_marital   = $row['status_marital'];
					$p->mr_id   = $row['mr_id'];
					// $p->nik   = $row['nik'];

					$p->user_create    = 'Import';
					// $p->province_id    = $row['Kode_Propinsi'];
					// $p->regency_id     = $row['Kode_Kabupaten'];
					// $p->district_id    = $row['Kode_Kecamatan'];
					// $p->village_id     = $row['Kode_Kelurahan'];
					$p->suku_bangsa    = $row['suku'];
					$p->bhs_pasien     = '-';
					$p->cacat_fisik    = '-';

					$p->save();
					array_push($pasienID, $p->id);

				}
				
			 }

			}

			$pasien = Pasien::whereIn('id', $pasienID)->get();
			if ($pasien->count() == 0) {
				Flashy::info('Tidak ada data Pasien yang diimport');
			} else {
				DB::commit();
				Flashy::success($pasien->count().' Data Pasien berhasil diimport ke Database ');
			}
	
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('/cari-file-pasien');
		}

	}




	public function importPegawai(Request $request) { 
		// dd($request->all());
		ini_set('max_execution_time', 0); //0=NOLIMIT
		//ini_set('memory_limit', '2048M');
		
		request()->validate(['excel' => 'required']);

		DB::beginTransaction();
        try{

			$excel  = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
				})->get();
          
			//rule
			$rowRules = [
				'nama'      => 'required',
				
			];

			$pasienID = [];
            
			//Looping data
			foreach ($excels as $row) {
               
				$validator = Validator::make($row->toArray(), $rowRules);

				//if ($validator->fails()) {continue;
				//}
				
				$p = Pegawai::where('nama',$row['nama'])->first();
				if(!$p){
					$p = new Pegawai();
				}
				//$p->no_rm =$row['no_rm'];
				$p->nama           = $row['nama'];
				// $p->poli_type           = $row['poli_type'];
				// $p->poli_type           = $row['poli_type'];
				// $p->nip         = $row['nip'];
				// $p->golongan_tmt         = $row['golongan_tmt'];
				// $p->golongan         = $row['golongan'];
				// $p->jabatan         = $row['jabatan'];
				// $p->jabatan_tmt         = $row['jabatan_tmt'];
				$p->kategori_pegawai	  = $request->kategori;
				$p->save();
			}

			
			DB::commit();
			Flashy::success('berhasil diimport ke Database ');
			// Return it's location
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('/cari-file-pasien');
		} 
	}
	//=================== IRJ ======================================================
	public function templateIrj() {
		Excel::create('Template Tarif IRJ', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Import IRJ')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Tarif IRJ untuk SIMRS');
				$excel->sheet('Tarif IRJ', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'kode',
								'total',
								'split1',
								'split2',
								'split3'
							]);
					});
			})->export('xls');
	}

	public function importIrj(Request $request) {
		
		request()->validate(['excel' => 'required']);
		DB::beginTransaction();
        try{
			$excel = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
					// options, jika ada
				})->get();

			// rule
			$rowRules = [
				'nama'   => 'required',
				'total'  => 'required|integer', 
			];
			$irjID = [];

			//Looping data
			// dd($excels);
			foreach ($excels as $row) {
				$validator = Validator::make($row->toArray(), $rowRules);
				if ($validator->fails()) {continue;
				}

			$tarif = Tarif::where(['nama' => $row['nama'], 'kode' => $row['kode'], 'jenis' => $request['jenis'], 'carabayar' => $request['carabayar'], 'kategoritarif_id' => $request->kategoritarif_id])->first();
				if (!$tarif) {

					// $tarif= $request->all();
					$tarif = Tarif::create([
						    // 'id_tindakan'      => $row['id_tindakan'],
							'nama'             => $row['nama'],
							'jenis'            => $request['jenis'],
							'carabayar'        => $request['carabayar'],
							'kategoriheader_id'=> $request['kategoriheader'],
							'kategoritarif_id' => $request['kategoritarif_id'],
							'kelas_id' => $request['kelas'],
							'keterangan'       => '-',
							'tahuntarif_id'    => configrs()->tahuntarif,
							//'kelompok'         => $request['kelompok'],
							// 'jasa_rs'          => $row['jasa_rs'],
							// 'jasa_pelayanan'   => $row['jasa_pelayanan'],
							'total'            => $row['total']
						]
					);
					
					array_push($irjID, $tarif->id);
					//Input split
					$mastersplit = Mastersplit::where('kategoriheader_id', $request['kategoriheader'])->get();
					for ($i = 1; $i <= $mastersplit->count(); $i++) {
						//if (!empty($row['split'.$i])) {
							// $split = Split::create([
							// 		'tahuntarif_id'     => configrs()->tahuntarif,
							// 		'kategoriheader_id' => $request['kategoriheader'],
							// 		'tarif_id'          => $tarif->id,
							// 		'nama'              => $request['nama'.$i],
							// 		'nominal'           => ($row['split'.$i] == 0) ? '0' : $row['split'.$i]
							// 	]);
						//}

					}
				}
			}

			$tarifs = Tarif::whereIn('id', $irjID)->get();
			if ($tarifs->count() == 0) {
				Flashy::info('Tidak ada data tarif IRJ yang diimport');
			} else {
				DB::commit();
				Flashy::success($tarifs->count().' Data Tarif IRJ berhasil diimport ke Database ');
			}
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('kontrolpanel/import');
		}
		

		// Return it's location
		
	}
	public function importTarifNew(Request $request) {
		
		request()->validate(['excel' => 'required']);
		DB::beginTransaction();
        try{
			$excel = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
					// options, jika ada
				})->get();

			// rule
			$rowRules = [
				'nama'   => 'required',
				'harga_baru'  => 'required', 
			];
			$irjID = [];

			//Looping data
			// dd($excels);
			foreach ($excels as $row) {
				// $validator = Validator::make($row->toArray(), $rowRules);
				// if ($validator->fails()) {continue;
				// }
			if($row['harga_baru']){

				$tarif = Tarif::where(['nama' => $row['tarif'],'total' => $request['harga_baru']])->first();
				// dd($tarif);
					if (!$tarif) {
	
						// $tarif= $request->all();
						$tarif_rj = Tarif::create([
								// 'id_tindakan'      => $row['id_tindakan'],
								'nama'             => $row['tarif'],
								'jenis'            => 'TA',
								'carabayar'        => 1,
								'keterangan'       => '-',
								'tahuntarif_id'    => configrs()->tahuntarif,
								'total'            => $row['harga_baru']
							]
						);
						
						$tarif_rd = Tarif::create([
								// 'id_tindakan'      => $row['id_tindakan'],
								'nama'             => $row['tarif'],
								'jenis'            => 'TG',
								'carabayar'        => 1,
								'keterangan'       => '-',
								'tahuntarif_id'    => configrs()->tahuntarif,
								'total'            => $row['harga_baru']
							]
						);
						
						$tarif_ri = Tarif::create([
								// 'id_tindakan'      => $row['id_tindakan'],
								'nama'             => $row['tarif'],
								'jenis'            => 'TI',
								'carabayar'        => 1,
								'keterangan'       => '-',
								'tahuntarif_id'    => configrs()->tahuntarif,
								'total'            => $row['harga_baru']
							]
						);
	
						array_push($irjID, $tarif_rj->id);
					}
			}
			}

			$tarifs = Tarif::whereIn('id', $irjID)->get();
			if ($tarifs->count() == 0) {
				Flashy::info('Tidak ada data tarif IRJ yang diimport');
			} else {
				DB::commit();
				Flashy::success($tarifs->count().' Data Tarif IRJ berhasil diimport ke Database ');
			}
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('kontrolpanel/import');
		}
		

		// Return it's location
		
	}
	//=================== PEwagawi ======================================================
	public function templatePegawai() {
		Excel::create('Template Pegawai', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Import Pegawai')
				->setCreator('xx')
					->setCompany('XX')
				->setDescription('Template Pegawai SIMRS');
				$excel->sheet('Template', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'no_reg'
							]);
					});
			})->export('xls');
	}
	//=================== IRNA ======================================================
	public function templateIrna() {
		Excel::create('Template Tarif IRNA', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Import IRNA')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Tarif IRNA untuk SIMRS');
				$excel->sheet('Tarif IRNA', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'kode',
								'total',
								'split1',
								'split2',
								'split3'
							]);
					});
			})->export('xls');
	}

	public function importIrna(Request $request) {
		//return $request->all(); die;
		request()->validate(['excel' => 'required']);
		DB::beginTransaction();
        try{
			$excel = $request->file('excel');

			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
					// options, jika ada
				})->get();

			// rule
			$rowRules = [
				'nama'   => 'required',
				'total'  => 'required', 
			];
			$irjID = [];

			//Looping data
			foreach ($excels as $row) {
				$validator = Validator::make($row->toArray(), $rowRules);
				if ($validator->fails()) {continue;
				}

				//$tarif = Tarif::where('nama', $row['nama'])->where('kategoritarif_id', $request['kategoritarif_id'])->where('jenis', $request['jenis'])->first();
				//if (!$tarif) {
					$tarif = Tarif::create([
						    // 'id_tindakan'      => $row['id_tindakan'],
							'nama'             => $row['nama'],
							'kode'			   => @$row['kode'],
							'jenis'            => $request['jenis'],
							'carabayar'        => $request['carabayar'],
							'kategoriheader_id'=> $request['kategoriheader'],
							'kategoritarif_id' => $row['kategoritarif_id'],
							'kelas_id' => $request['kelas'],
							'keterangan'       => '-',
							'tahuntarif_id'    => configrs()->tahuntarif,
							//'kelompok'         => $request['kelompok'],
							// 'jasa_rs'          => $row['jasa_rs'],
							// 'jasa_pelayanan'   => $row['jasa_pelayanan'],
							'total'            => $row['total']
							//'cyto'             => $row['cyto']
						]
					);
					array_push($irjID, $tarif->id);
					//Input split
					$mastersplit = Mastersplit::where('kategoriheader_id', $request['kategoriheader'])->get();
					for ($i = 1; $i <= $mastersplit->count(); $i++) {
						//if (!empty($row['split'.$i])) {
							// $split = Split::create([
							// 		'tahuntarif_id'     => configrs()->tahuntarif,
							// 		'kategoriheader_id' => $request['kategoriheader'],
							// 		'tarif_id'          => $tarif->id,
							// 		'nama'              => $request['nama'.$i],
							// 		'nominal'           => $row['split'.$i]
							// 	]);
						//}

					}
				//}
			}

			$tarifs = Tarif::whereIn('id', $irjID)->get();
			if ($tarifs->count() == 0) {
				Flashy::info('Tidak ada data tarif IRNA yang diimport');
			} else {
				DB::commit();
				Flashy::success($tarifs->count().' Data Tarif IRNA berhasil diimport ke Database ');
			}

			// Return it's location
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('kontrolpanel/import');
		}
		
	}

	//=================== IGD ======================================================

	public function templateIGD() {
		Excel::create('Template Tarif IGD', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Tarif IGD')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Tarif IGD untuk SIMRS');
				$excel->sheet('Tarif IGD', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'kode',
								'total',
								'split1',
								'split2',
								'split3'
							]);
					});
			})->export('xls');
	}

	public function importIgd(Request $request) {
		//dd('import IGD');
		request()->validate(['excel' => 'required']);
		
		DB::beginTransaction();
        try{
			$excel = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
					// options, jika ada
				})->get();

			// rule
			$rowRules = [
				'nama'   => 'required',
				'total'  => 'required|integer', 
			];
			$irjID = [];
			//Looping data
			foreach ($excels as $row) {
				$validator = Validator::make($row->toArray(), $rowRules);
				if ($validator->fails()) {
					continue;
				}

				$tarif = Tarif::where(['nama' => $row['nama'],'kode' => @$row['kode'], 'jenis' => $request['jenis'], 'carabayar' => $request['carabayar'], 'kategoritarif_id' => $request->kategoritarif_id])->first();
				if (!$tarif) {
					$tarif = Tarif::create([
						    // 'id_tindakan'      => $row['id_tindakan'],
							'nama'             => $row['nama'],
							'kode'			   => @$row['kode'],
							'jenis'            => $request['jenis'],
							'carabayar'        => $request['carabayar'],
							'kategoriheader_id'=> $request['kategoriheader'],
							'kategoritarif_id' => $request['kategoritarif_id'],
							'keterangan'       => '-',
							'tahuntarif_id'    => configrs()->tahuntarif,
							//'kelompok'         => $request['kelompok'],
							// 'jasa_rs'          => $row['jasa_rs'],
							// 'jasa_pelayanan'   => $row['jasa_pelayanan'],
							'total'            => $row['total']
						]
					);
					array_push($irjID, $tarif->id);
					//Input split
					$mastersplit = Mastersplit::where('kategoriheader_id', $request['kategoriheader'])->get();
					for ($i = 1; $i <= $mastersplit->count(); $i++) {
						//if (!empty($row['split'.$i])) {
						// 	$split = Split::create([
						// 			'tahuntarif_id'     => configrs()->tahuntarif,
						// 			'kategoriheader_id' => $request['kategoriheader'],
						// 			'tarif_id'          => $tarif->id,
						// 			'nama'              => $request['nama'.$i],
						// 			'nominal'           => $row['split'.$i]
						// 		]);
						// //}

					}
				}
			}

			$tarifs = Tarif::whereIn('id', $irjID)->get();
			if ($tarifs->count() == 0) {
				Flashy::info('Tidak ada data tarif IGD yang diimport');
			} else {
				DB::commit();
				Flashy::success($tarifs->count().' Data Tarif IGD berhasil diimport ke Database ');
			}

			// Return it's location
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('kontrolpanel/import');
		}

		
	}

	//====================== ICD9 ==================================================
	public function templateIcd9() {
		Excel::create('Template ICD9', function ($excel) {
				// Set the properties
				$excel->setTitle('Template ICD9')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template ICD9');
				$excel->sheet('Tarif ICD9', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nomor',
								'nama',
							]);
					});
			})->export('xls');
	}

	public function importIcd9(Request $request) {
		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nomor' => 'required',
			'nama'  => 'required',
		];
		$icd9ID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			$icd9 = Icd9::where('nama', $row['nama'])->first();
			if (!$icd9) {
				$icd9 = Icd9::create([
						'nomor' => $row['nomor'],
						'nama'  => $row['nama'],
					]
				);
				array_push($icd9ID, $icd9->id);
			}
		}

		$icd9s = Icd9::whereIn('id', $icd9ID)->get();
		if ($icd9s->count() == 0) {
			Flashy::info('Tidak ada data ICD9 yang diimport');
		} else {
			Flashy::success($icd9s->count().' Data ICD9 berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}

	//====================== ICD9 ==================================================
	public function templateIcd10() {
		Excel::create('Template ICD10', function ($excel) {
				// Set the properties
				$excel->setTitle('Template ICD10')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template ICD10');
				$excel->sheet('Tarif ICD10', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nomor',
								'nama',
							]);
					});
			})->export('xls');
	}

	public function importIcd10(Request $request) {
		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nomor' => 'required',
			'nama'  => 'required',
		];
		$icd10ID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			$icd10 = Icd10::where('nama', $row['nama'])->first();
			if (!$icd10) {
				$icd10 = Icd10::create([
						'nomor' => $row['nomor'],
						'nama'  => $row['nama'],
					]
				);
				array_push($icd10ID, $icd10->id);
			}
		}

		$icd10s = Icd10::whereIn('id', $icd10ID)->get();
		if ($icd10s->count() == 0) {
			Flashy::info('Tidak ada data ICD9 yang diimport');
		} else {
			Flashy::success($icd10s->count().' Data ICD10 berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}

	public function getKatTarif($kategoriheader_id = '') {
		$kat = Mastersplit::where('kategoriheader_id', $kategoriheader_id)->pluck('namatarif', 'id');
		return json_encode($kat);
	}

	public function importProvince(Request $request) { 
		// dd($request);
		ini_set('max_execution_time', 0); //0=NOLIMIT
		//ini_set('memory_limit', '2048M');
		
		// request()->validate(['excel' => 'required']);
		// dd($request);
		DB::beginTransaction();
        try{

			$excel  = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
			
				// options, jika ada
				})->get();
				// dd($excels);
			//rule
			
			$rowRules = [
				'namalengkap'      => 'required',
			];

			$LogistikSupplierID = [];
			//Looping data
			foreach ($excels as $row) {
				//    dd($row['no_identitas']);
				// $validator = Validator::make($row->toArray(), $rowRules);
				
			//if ($validator->fails()) {continue;
			//}
			// $p->hargajual = $row['hargajual'];


			// $p = number_format($row['hargajual']);
			// dd($p);
			//  $cekdata = LogistikSupplier::where('id',$row['id'])->first();
			// dd($cekdata);
			 if(true){
				 
				 if($row['id'] !== 'X' || $row['id'] !== ''){
					$p = new LogistikSupplier();
					// $p->id = $row['id'];
					// $p->district_id = $row['district_id'];
					// $p->id = $row['id'];
					// $p->kode = $row['kode'];
					$p->nama = $row['nama'];
					$p->alamat = $row['alamat'];
					$p->nohp = $row['tlp'];
					// $p->cre = $row['cre'];
					
					// dd($p);
					$p->save();
					array_push($LogistikSupplierID, $p->id);

				}
				
			 }

			}
			$LogistikSupplier = LogistikSupplier::whereIn('id', $LogistikSupplierID)->get();
			if ($LogistikSupplier->count() == 0) {
				Flashy::info('Tidak ada data LogistikSupplier yang diimport');
			} else {
				DB::commit();
				Flashy::success($LogistikSupplier->count().' Data Regency berhasil diimport ke Database ');
			}
	
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('/cari-file-pasien');
		}

	}
	public function importRis(Request $request) { 
		// dd($request);
		ini_set('max_execution_time', 0); //0=NOLIMIT
		//ini_set('memory_limit', '2048M');
		
		// request()->validate(['excel' => 'required']);
		// dd($request);
		DB::beginTransaction();
        try{

			$excel  = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
			
				// options, jika ada
				})->get();
				// dd($excels);
			//rule
			// dd($excels);
			foreach ($excels as $row) {
				
			 
				 
				 if($row['mt_id'] !== ''){
					$p = new RisTindakan();
					$p->mt_id = $row['mt_id'];
					$p->mt_kode = $row['mt_kode'];
					$p->mt_desc = $row['mt_desc'];
					$p->mt_kode_pk = $row['mt_kode_pk'];
					$p->created_at = $row['rec_created'];
					$p->updated_at = $row['rec_edited'];
					$p->save();
					// $p->cre = $row['cre'];
				}
				
			 

			}
			
			DB::commit();
			Flashy::success('berhasil diimport ke Database ');
			
	
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('/cari-file-pasien');
		}

	}

	public function importLis(Request $request) { 
		// dd($request);
		ini_set('max_execution_time', 0); //0=NOLIMIT
		//ini_set('memory_limit', '2048M');
		
		// request()->validate(['excel' => 'required']);
		// dd($request);
		DB::beginTransaction();
        try{

			$excel  = $request->file('excel');
			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
			
				// options, jika ada
				})->get();
				// dd($excels);
			//rule
			// dd($excels);
			foreach ($excels as $row) {
				
			 
				 
				 if($row['mt_id'] !== ''){
					$p = new MasterLicas();
					$p->mt_id = $row['mt_id'];
					$p->general_code = $row['general_code'];
					$p->name = $row['name'];
					$p->lab_tind_id = $row['lab_tind_id'];
					$p->save();
					// $p->cre = $row['cre'];
				}
				
			 

			}
			
			DB::commit();
			Flashy::success('berhasil diimport ke Database ');
			
	
			return redirect('kontrolpanel/import');
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Import data');
			return redirect('/cari-file-pasien');
		}

	}

}
