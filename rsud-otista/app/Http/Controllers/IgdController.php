<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Illuminate\Support\Facades\DB;
use PDF;
use Excel;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Poli\Entities\Poli;
use Modules\Tarif\Entities\Tarif;
use App\KondisiAkhirPasien;
use App\HistorikunjunganIGD;
use App\Historipengunjung;
use Modules\Registrasi\Entities\HistoriStatus;
use Auth;
use Modules\Pekerjaan\Entities\Pekerjaan;

class IgdController extends Controller {

	public function lap_pengunjung() {
		$data['carabayar']	= Carabayar::all();
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['crb']		= 0;
		$data['darurat']	= [];
		$data['visite']		= [];
		return view('igd.lapPengunjung', $data)->with('no', 1);
	}

	public function lap_pengunjung_byRequest(Request $req) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga).' 00:00:00';
		$tgb				= valid_date($req->tgb).' 23:59:59';

		$data['carabayar']	= Carabayar::all();
		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;
		$data['crb']		= $req->cara_bayar;
		$data['darurat']	= Folio::leftJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
				->where('folios.jenis', 'TG')->whereBetween('registrasis.created_at', [$tga, $tgb])
				->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
				->selectRaw('SUM(folios.total) as total, registrasis.user_create,registrasis.id, registrasis.pasien_id, registrasis.bayar, registrasis.created_at')
				->groupBy('folios.registrasi_id')->get();
		// return $data['darurat'];die;
		// foreach($data['darurat'] as $k => $r){
		// 	$data['darurat'][$k]['tindakan']	= Folio::where(['registrasi_id' => $r->id, 'jenis' => 'TG'])->where('tarif_id', '!=', 10000)
		// 		->selectRaw('SUM(total) as jumlah, mapping_biaya_id as mapping')->groupBy('mapping_biaya_id')->get();
		// 	$data['darurat'][$k]['total']		= Folio::where(['registrasi_id' => $r->id, 'jenis' => 'TG'])->where('tarif_id', '!=', 10000)->sum('total');
		// }
		

		$data['visite']		= Folio::leftJoin('registrasis', 'folios.registrasi_id', '=', 'registrasis.id')
				->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where(['folios.mapping_biaya_id' => 16, 'folios.jenis' => 'TG'])
				->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
				->whereBetween('registrasis.created_at', [$tga, $tgb])
				->groupBy('folios.dokter_id')
				->selectRaw('COUNT(folios.mapping_biaya_id) as visite, SUM(folios.total) as nominal, folios.dokter_id')->get();
		// return $data;die;
		
		if($req['lanjut']){
			return view('igd.lapPengunjung', $data)->with('no', 1);
		}elseif($req['pdf']){
			$no = 1;
			$pdf = PDF::loadView('igd.rekapLaporan', $data, compact('no'));
			$pdf->setPaper('A4', 'landscape');
			// return $pdf->download('rekapLaporanIrna.pdf');
			return view('igd.rekapLaporan', $data)->with('no', 1);
		}elseif($req['excel']){
			$darurat = $data['darurat'];
			$visite = $data['visite'];
			$tga = $req->tga;
			$tgb = $req->tgb;
			Excel::create('Pengunjung Rawat Darurat '.$tga.'/'.$tgb, function ($excel) use ($data,$darurat, $visite) {
                $excel->setTitle('Pengunjung Rawat Darurat')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Pengunjung Rawat Darurat');
					$excel->sheet('Pengunjung Rawat Darurat', function ($sheet) use ($data,$darurat, $visite) {
                    $sheet->loadView('igd.excel.lapPengunjung_excel', $data);
                });
            })->export('xlsx');
			 
		}
	}

	public function test($reg = ''){
		$peg = Pegawai::where(['kategori_pegawai' => 1, 'status' => 'umum'])->pluck('id');
		$dokter = Folio::leftJoin('foliopelaksanas', 'foliopelaksanas.folio_id', '=', 'folios.id')
				->leftJoin('pegawais', 'pegawais.id', '=', 'foliopelaksanas.dokter_pelaksana')
				->where('folios.registrasi_id', $reg)->whereIn('foliopelaksanas.dokter_pelaksana', $peg)
				->first();
		return $dokter->nama;
		// $dokter = Pegawai::where('kategori_pegawai', 1)->where('status', '!=', null)
		// 		->leftJoin('foliopelaksanas', 'foliopelaksanas.dokter_pelaksana', '=', 'pegawais.id')
		// 		->leftJoin('folios', 'folios.id', '=', 'foliopelaksanas.folio_id')
		// 		->where('folios.registrasi_id', $reg)->select('pegawais.nama')->first();
		// if($dokter != null){
		// 	return $dokter->nama;
		// }else{
		// 	return 'kosong';
		// }
	}

	public function transit()
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);

		$data['tga']		= '';
		$data['tgb']		= '';
		$data['registrasi']	= Registrasi::leftJoin('histori_kunjungan_igd', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
			->whereIn('registrasis.status_reg', ['G2', 'I2', 'I3'])
			->select('histori_kunjungan_igd.created_at as masuk', 'registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'histori_kunjungan_igd.triage_nama', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'registrasis.created_at')
			->take(50)->orderby('masuk','desc')->get();

		return view('igd.transit', $data)->with('no', 1);
	}

	public function filterTransit(Request $req)
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;
		$data['registrasi']	= Registrasi::leftJoin('histori_kunjungan_igd', 'histori_kunjungan_igd.registrasi_id', '=', 'registrasis.id')
			->whereIn('registrasis.status_reg', ['G2', 'I2', 'I3'])
			->whereBetween('registrasis.created_at', [valid_date($req->tga) . ' 00:00:00', valid_date($req->tgb) . ' 23:59:59'])
			->select('histori_kunjungan_igd.created_at as masuk', 'registrasis.dokter_id', 'registrasis.pasien_id', 'registrasis.id', 'histori_kunjungan_igd.triage_nama', 'registrasis.bayar', 'registrasis.status_reg', 'registrasis.tipe_jkn', 'registrasis.created_at')
			->orderby('masuk', 'desc')->get();


		return view('igd.transit', $data)->with('no', 1);
	}

	public function entryTindakanTransit($idreg, $idpasien)
	{
		$data['pasien'] = Pasien::find($idpasien);
		$data['reg_id'] = $idreg;
		$data['poli']	= Poli::where('politype','G')->pluck('nama','id');
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();

		$data['pegawai'] =  Pegawai::find(Auth::user()->id);

		$jenis = $data['jenis']->status_reg;
		
		$data['pelaksana'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');

		$data['perawat'] = Pegawai::where('poli_type', 'G')->pluck('nama', 'id');

		// return $data; die;

		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$data['carabayar'] = \Modules\Registrasi\Entities\Carabayar::pluck('carabayar', 'id');


		if (substr($jenis, 0, 1) == 'G' || $jenis == 'I1' || $jenis == 'I2') {
			$data['opt_poli'] = Poli::where('politype', 'G')->get();
			session(['jenis' => 'TG']);
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TG')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			if (Auth::user()->hasRole(['administrator'])) {
				$data['folio'] = Folio::where(['jenis' => 'TG', 'registrasi_id' => $idreg])
					->get();
			} else {
				$data['folio'] = Folio::where(['jenis' => 'TG', 'registrasi_id' => $idreg, 'user_id' => Auth::user()->id])
					->get();
			}
		} elseif (substr($jenis, 0, 1) == 'J') {
			$data['opt_poli'] = Poli::where('politype', 'J')->get();
			session(['jenis' => 'TA']);
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TA')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			if (Auth::user()->hasRole(['administrator'])) {
				$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $idreg])
					->get();
			} else {
				$data['folio'] = Folio::where(['jenis' => 'TA', 'registrasi_id' => $idreg, 'user_id' => Auth::user()->id])
					->get();
			}
		} elseif (substr($jenis, 0, 1) == 'I') {
			session(['jenis' => 'TI']);
			$data['opt_poli'] = Poli::where('politype', 'I')->get();
			$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
			if (Auth::user()->hasRole(['administrator'])) {
				$data['folio'] = Folio::where(['jenis' => 'TI', 'registrasi_id' => $idreg])
					->get();
			} else {
				$data['folio'] = Folio::where(['jenis' => 'TI', 'registrasi_id' => $idreg, 'user_id' => Auth::user()->id])
					->get();
			}
		}

		$data['tagihan'] = $data['folio']->sum('total');
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		return view('igd.entry-tindakan-transit', $data)->with('no', 1);
	}

	public function saveEntryTransit(Request $request)
	{
		request()->validate(['tarif_id' => 'required', 'pelaksana' => 'required']);

		$reg = Registrasi::find($request['registrasi_id']);
		$tarif = Tarif::find($request['tarif_id']);

		$fol = new Folio();
		$fol->registrasi_id = $request['registrasi_id'];
		$fol->poli_id = $request['poli_id'];
		$fol->lunas = 'N';
		$fol->namatarif = $tarif->nama;
		$fol->dijamin = $request['dijamin'];
		$fol->tarif_id = $request['tarif_id'];
		$fol->cara_bayar_id = (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar;
		$fol->jenis = $tarif->jenis;
		if (isset($request['page'])) {
			if ($request['page'] == 'labJalan' || $request['page'] == 'labIgd' || $request['page'] == 'labInap') {
				$fol->poli_tipe = 'L';
			} else if ($request['page'] == 'radJalan' || $request['page'] == 'radIgd' || $request['page'] == 'radInap') {
				$fol->poli_tipe = 'R';
			}
		} else {
			if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
				$fol->poli_tipe = 'G';
			} else {
				$fol->poli_tipe = 'J';
			}
		}
		$fol->total = ($tarif->total * $request['jumlah']);
		$fol->jenis_pasien = $request['jenis'];
		$fol->pasien_id = $request['pasien_id'];
		$fol->dokter_id = $request['dokter_id'];
		$fol->user_id = Auth::user()->id;
		$fol->poli_id = $request['poli_id'];
		if (!empty($request['tanggal'])) {
			$fol->created_at = valid_date($request['tanggal']) . ' ' . date('H:i:s');
		}
		$fol->mapping_biaya_id = $tarif->mapping_biaya_id;

		//revisi foliopelaksana
		$fol->dpjp = $request['dokter_id'];
		$fol->dokter_pelaksana = $request['pelaksana'];
		$fol->perawat = $request['perawat'];
		if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
			$fol->pelaksana_tipe = 'TG';
		} else {
			$fol->pelaksana_tipe = 'TA';
		}
		$fol->save();

		// Insert Kunjungan IRJ
		if ($fol->poli_tipe == 'J') {
			$cek = HistorikunjunganIRJ::where('registrasi_id', $request['registrasi_id'])->where('poli_id', $request['poli_id'])->count();
			if ($cek < 1) {
				$rj = new HistorikunjunganIRJ();
				$rj->registrasi_id = $request['registrasi_id'];
				$rj->pasien_id = $request['pasien_id'];
				$rj->dokter_id = @$request['dokter_id'];
				$rj->poli_id = $request['poli_id'];
				$rj->user = Auth::user()->id;
				$rj->save();
			}
		}

		// Insert Kunjungan IRD
		if ($fol->poli_tipe == 'G') {
			$cek = HistorikunjunganIGD::where('registrasi_id', $request['registrasi_id'])->where('triage_nama', baca_poli($request['poli_id']))->count();
			if ($cek < 1) {
				$rj = new HistorikunjunganIGD();
				$rj->registrasi_id = $request['registrasi_id'];
				$rj->pasien_id = $request['pasien_id'];
				$rj->triage_nama = baca_poli($request['poli_id']);
				$rj->user = Auth::user()->id;
				$rj->save();
			}
		}

		//Update Reg Status
		if (substr($reg->status_reg, 0, 1) == 'G') {
			$reg->status_reg = 'G2';
		} else if (substr($reg->status_reg, 0, 1) == 'J') {
			$reg->status_reg = 'J2';
		} else if (substr($reg->status_reg, 0, 1) == 'I') {
			$reg->status_reg = 'I2';
		}
		$reg->update();

		//input folio pelaksana
		// $fp = new Foliopelaksana();
		// $fp->folio_id = $fol->id;
		// $fp->dpjp = $request['dokter_id'];
		// $fp->dokter_pelaksana = $request['pelaksana'];
		// $fp->perawat = $request['perawat'];
		// if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
		// 	$fp->pelaksana_tipe = 'TG';
		// } else {
		// 	$fp->pelaksana_tipe = 'TA';
		// }
		// $fp->user = Auth::user()->id;
		// $fp->save();

		// Insert Histori
		$history = new HistoriStatus();
		$history->registrasi_id = $request['registrasi_id'];
		if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
			$history->status = 'G2';
		} else if (substr($reg->status_reg, 0, 1) == 'J') {
			$history->status = 'J2';
		} else if (substr($reg->status_reg, 0, 1) == 'I') {
			$history->status = 'I2';
		}

		$history->poli_id = $request['poli_id'];
		$history->bed_id = null;
		$history->user_id = Auth::user()->id;
		$history->save();

		session()->forget('jenis');
		return redirect('igd/entry-tindakan-transit/' . $request['registrasi_id'] . '/' . $request['pasien_id']);
		// return redirect()->back();
	}

	public function saveKondisiTransit(Request $req)
	{
		request()->validate(['kondisi_akhir_pasien' => 'required']);
		$reg						= Registrasi::find($req['registrasi_id']);
		$reg->kondisi_akhir_pasien	= $req->kondisi_akhir_pasien;
		$reg->update();

		return redirect('igd/transit');
	}

	public function lap_kunjungan(Request $request)
	{
        $data['carabayar']	        = Carabayar::all();
		$data['crb']		= 0;
		$data['kasus_id']           = '';
		$data['cara_masuk_id']      = '';
		$data['caraPulang']         = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
		$data['dokter']         	= Pegawai::where('kategori_pegawai', '1')->orderBy('nama', 'ASC')->get();
		$data['cara_pulang_id']     = '';
        $data['kondisiPulang']      = KondisiAkhirPasien::where('jenis', 'kondisi')->orderBy('urutan', 'ASC')->get();
		$data['kondisi_pulang_id']  = '';
		$data['status_pasien']      = '';
        $data['kelompok_bpjs']      = Registrasi::where('tipe_jkn', '!=', null)->groupBy('tipe_jkn')->pluck('tipe_jkn');
        $data['kelompok_bpjs_id']   = ''; 
		$data['poli'] = Poli::where('politype', 'G')->get();
		$data['poli_id'] = '';  
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['darurat'] 	= [];
		$data['pekerjaan']  = Pekerjaan::all();
		// $data['darurat'] = \App\HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
		// 	->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->where('histori_kunjungan_igd.created_at', 'LIKE', date('Y-m-d') . '%')
		// 	->select('registrasis.id as registrasi_id','registrasis.kondisi_akhir_pasien as kondisi_akhir', 'registrasis.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_kunjungan_igd.triage_nama')
		// 	->get();
		return view('igd.lap-kunjungan', $data)->with('no', 1);
	}

	// public function lap_kunjungan_byRequest(Request $req)
	// {
	// 	request()->validate(['tga' => 'required', 'tgb' => 'required']);
	// 	$data['carabayar']	= Carabayar::all();
	// 	$tga				= valid_date($req->tga) . ' 00:00:00';
	// 	$tgb				= valid_date($req->tgb) . ' 23:59:59';

	// 	$data['carabayar']	= Carabayar::all();
	// 	$data['tga']		= $req->tga;
	// 	$data['tgb']		= $req->tgb;
	// 	$data['crb']		= $req->cara_bayar;
	// 	$data['darurat']	= \App\HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=',  'histori_kunjungan_igd.registrasi_id')
	// 		->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
	// 		->whereBetween('histori_kunjungan_igd.created_at', [$tga, $tgb])
	// 		->where('registrasis.bayar', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
	// 		->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.bayar', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir', 'pasiens.kelamin', 'histori_kunjungan_igd.triage_nama')
	// 		->get();

	// 	// return $data;die;
	// 	if ($req['lanjut']) {
	// 		return view('igd.lap-kunjungan', $data)->with('no', 1);
	// 	} elseif ($req['pdf']) {
	// 		// $no = 1;
	// 		// $pdf = PDF::loadView('igd.rekapLaporan', $data, compact('no'));
	// 		// $pdf->setPaper('A4', 'landscape');
	// 		// return $pdf->download('rekapLaporanIrna.pdf');
	// 		return view('igd.rekapLapKunjunganIGD', $data)->with('no', 1);
	// 	} elseif ($req['excel']) {
	// 		$darurat = $data['darurat'];
	// 		$tga = $req->tga;
	// 		$tgb = $req->tgb;
	// 		Excel::create('Pengunjung Rawat Darurat', function ($excel) use ($darurat) {
	// 			$excel->setTitle('Pengunjung Rawat Darurat')
	// 				->setCreator('Digihealth')
	// 				->setCompany('Digihealth')
	// 				->setDescription('Pengunjung Rawat Darurat');
	// 			$excel->sheet('Pengunjung Rawat Darurat', function ($sheet) use ($darurat) {
	// 				$row = 3;
	// 				$no = 1;
	// 				// $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F'),'rows' => array([1,2])]);
	// 				$sheet->row(1, ['No', 'No. RM', 'Nama', 'Alamat', 'Umur', 'Jenis Kelamin', 'Cara Bayar', 'Pelayanan', 'Dokter', 'Tanggal']);
	// 				$ceck = 0;
	// 				foreach ($darurat as $dr) {
	// 					$_dtl = [$no++, $dr->no_rm, $dr->nama, $dr->alamat, hitung_umur($dr->tgllahir), $dr->kelamin, baca_carabayar($dr->bayar), $dr->triage_nama, baca_dokter($dr->dokter_id), date('d-m-Y', strtotime($dr->created_at)),];
	// 					$z = 7;
	// 					$sheet->row($row++, $_dtl);
	// 				}
	// 				$sheet->data = [];
	// 				$row++;
	// 				$row++;
	// 				$_no = 1;
	// 			});
	// 		})->export('xlsx');
	// 	}
	// }
	public function lap_kunjungan_byRequest(Request $req) {
        $req->validate(['tga' => 'required', 'tgb' => 'required']);
        $data['tga']		    = $req->tga;
		$data['tgb']		    = $req->tgb;
        $tga				    = valid_date($req->tga) . ' 00:00:00';
		$tgb				    = valid_date($req->tgb) . ' 23:59:59';
        $data['carabayar']	    = Carabayar::all();
		// $data['cara_bayar_id']	= $req->cara_bayar_id;
		$data['kasus_id']       = $req->kasus_id;
		$data['cara_masuk_id']  = $req->cara_masuk_id;
		$data['dokter']        	= Pegawai::where('kategori_pegawai', '1')->orderBy('nama', 'ASC')->get();
		$data['dokter_id']        	= $req->dokter_id;
		$data['caraPulang']     = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orderBy('urutan', 'ASC')->get();
		$data['cara_pulang_id'] = $req->cara_pulang_id;
        $data['kondisiPulang']  = KondisiAkhirPasien::get();
		$data['kondisi_pulang_id']      = $req->kondisi_pulang_id;
		$data['status_pasien']          = $req->status_pasien;
		$data['pekerjaan']          = $req->pekerjaan;
        $data['kelompok_bpjs']          = Registrasi::where('tipe_jkn', '!=', null)->groupBy('tipe_jkn')->pluck('tipe_jkn');
        $data['kelompok_bpjs_id']       = $req->kelompok_bpjs_id;
		$data['poli'] = Poli::where('politype', 'G')->get();
		$data['poli_id'] = $req->poli_id;
		$data['crb']		= $req->cara_bayar;

        if($req->cari != null){
            $data['darurat']	= HistorikunjunganIGD::
                join('registrasis', 'registrasis.id', '=',  'histori_kunjungan_igd.registrasi_id')
				->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				// ->whereBetween('histori_kunjungan_igd.created_at', [$tga, $tgb])
                ->where('pasiens.nama', 'LIKE', "%$req->keyword%")
                ->orWhere('pasiens.no_rm', 'LIKE', "%$req->keyword%")
				->select('registrasis.id as registrasi_id','registrasis.kondisi_akhir_pasien as kondisi_akhir','registrasis.keterangan', 'registrasis.created_at', 'registrasis.status_reg','registrasis.dokter_id', 'registrasis.bayar', 'registrasis.no_sep', 'pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir','pasiens.kelamin','histori_kunjungan_igd.triage_nama', 'registrasis.tipe_jkn', 'pasiens.pekerjaan_id')->get();
            return view('igd.lap-kunjungan', $data)->with('no', 1);
        }

		$data['darurat']	=  HistorikunjunganIGD::
                join('registrasis', 'registrasis.id', '=',  'histori_kunjungan_igd.registrasi_id')
                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                ->whereBetween('histori_kunjungan_igd.created_at', [$tga, $tgb])
                ->select('registrasis.id as registrasi_id','registrasis.kondisi_akhir_pasien as kondisi_akhir','registrasis.keterangan' ,'registrasis.created_at', 'registrasis.status_reg','registrasis.dokter_id', 'registrasis.bayar', 'registrasis.no_sep', 'registrasis.pulang','registrasis.kondisi_akhir_pasien' ,  'registrasis.status_ugd','pasiens.nama',  'pasiens.alamat', 'pasiens.id', 'pasiens.no_rm', 'pasiens.tgllahir','pasiens.kelamin','histori_kunjungan_igd.triage_nama', 'registrasis.tipe_jkn', 'pasiens.pekerjaan_id');

        if($data['cara_pulang_id'] != null){
            $data['darurat']->where('registrasis.pulang', $data['cara_pulang_id']);
        }
        if($data['kondisi_pulang_id'] != null){
            $data['darurat']->where('registrasis.kondisi_akhir_pasien', $data['kondisi_pulang_id']);
        }
        if($data['pekerjaan'] != null){
            $data['darurat']->where('pasiens.pekerjaan_id', $data['pekerjaan']);
        }
		if($data['dokter_id'] != null){
            $data['darurat']->where('registrasis.dokter_id', $data['dokter_id']);
        }
        if($data['status_pasien'] != null){
            if($data['status_pasien'] == 'bpjs'){
                $data['darurat']->where('registrasis.bayar', '!=', 2);
            }else{
                $data['darurat']->where('registrasis.bayar', 2);
            }
        }

        if($data['kelompok_bpjs_id'] != null){
            $data['darurat']->where('tipe_jkn', $data['kelompok_bpjs_id']);
        }
        if($data['poli_id'] != null){
            $data['darurat']->where('triage_nama', $data['poli_id']);
        }
        

        if($data['kasus_id'] != null){
            $kasus = $data['kasus_id'];
            $data['darurat'] = $data['darurat']->filter(function ($item) use($kasus) {
                return @json_decode(@$item['status_ugd'], true)['kasus'] == $kasus;
            });
        }
        if($data['cara_masuk_id'] != null){
            $caraMasuk = $data['cara_masuk_id'];
            $data['darurat'] = $data['darurat']->filter(function ($item) use($caraMasuk) {
                return @json_decode(@$item['status_ugd'], true)['caraMasuk'] == $caraMasuk;
            });
        }
				$data['darurat'] = $data['darurat']->get();
		// return $data;die;
		if($req['lanjut']){
			return view('igd.lap-kunjungan', $data)->with('no', 1);
		}elseif($req['pdf']){
			$no = 1;
			$pdf = PDF::loadView('igd.rekapLaporan', $data, compact('no'));
			$pdf->setPaper('A4', 'landscape');
			// return $pdf->download('rekapLaporanIrna.pdf');
			return view('igd.rekapLaporan', $data)->with('no', 1);
		}elseif($req['excel']){
			$darurat = $data['darurat'];
			$tga = $req->tga;
			$tgb = $req->tgb;
			Excel::create('Pengunjung Rawat Darurat '.$tga.'/'.$tgb, function ($excel) use ($darurat) {
				$excel->setTitle('Pengunjung Rawat Darurat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Pengunjung Rawat Darurat');
				$excel->sheet('Pengunjung Rawat Darurat', function ($sheet) use ($darurat) {
					$row = 3;
					$no = 1;
					// $sheet->setMergeColumn(['columns' => array('A','B','C','D','E','F'),'rows' => array([1,2])]);
					$sheet->row(1, [
						'No',
						'No. RM',
						'Nama',
						'No. SEP',
						'Alamat',
						'Pekerjaan',
						'Umur',
						'Jenis Kelamin',
						'Cara Bayar',
						'Pelayanan',
						'Dokter',
						'Kondisi Pulang',
						'Keterangan',
						'Tanggal'
					]);
					$ceck = 0;
					foreach ($darurat as $dr) {
						$_dtl = [
							$no++,
							$dr->no_rm, 
							$dr->nama,
							@$dr->no_sep,
							$dr->alamat,
							@baca_pekerjaan($dr->pekerjaan_id),
							hitung_umur($dr->tgllahir),
							$dr->kelamin, 
							baca_carabayar($dr->bayar) . ' - ' . $dr->tipe_jkn, 
							$dr->triage_nama == 'IGD Obgyn' ? 'IGD Ponek' : $dr->triage_nama,
							baca_dokter($dr->dokter_id), 
							@baca_carapulang(@$dr->kondisi_akhir),
							$dr->keterangan,
							date('d-m-Y', strtotime($dr->created_at)),];
						$z = 7;
						$sheet->row($row++, $_dtl);
					}
					$sheet->data = [];
					$row++;$row++;
					$_no = 1;
				});
			})->export('xlsx');
		}
	}




	public function cariPasien()
	{
		return view('rawat-inap.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		// $date = date('Y-m-d', strtotime('-7 days'));
		// return $request->all();
		if($request->no_rm){
			$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->first();
		}elseif($request->nama){
			$data['pasien'] = Pasien::where('nama', 'like', $request->nama.'%')->first();
		}
		$data['reg'] = Registrasi::where('registrasis.pasien_id', @$data['pasien']->id)
		->whereIn('status_reg', ['G1', 'G2', 'G3', 'I1','I2','I3'])
		->orderby('registrasis.id','DESC')
		->get();
		// return $data; die;
		return view('rawat-inap.cari-pasien', $data)->with('no',1);
	}




}
