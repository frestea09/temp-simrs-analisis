<?php

namespace App\Http\Controllers;

use App\Foliopelaksana;
use App\Gizi;
use App\Historipengunjung;
use App\HistoriRawatInap;
use App\Mastergizi;
use App\Operasi;
use App\Orderlab;
use App\Kelompokkelas;
use App\Orderradiologi;
use App\Penjualan;
use App\Penjualandetail;
use App\Rawatinap;
use App\Pembayaran;
use App\Inacbgs_sementara;
use App\Mastermappingbiaya;
use App\PerawatanIcd9;
use App\MasterEtiket;
use App\masterCaraMinum;
use App\TakaranobatEtiket;
use App\PaguPerawatan;
use App\KondisiAkhirPasien;
use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Bed\Entities\Bed;
use Modules\Icd10\Entities\Icd10;
use Modules\Kamar\Entities\Kamar;
use Modules\Kelas\Entities\Kelas;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use PDF;
use Validator;
use Modules\Registrasi\Entities\Carabayar;
use Yajra\DataTables\DataTables;
use \App\HistoriSep;
use App\SepPoliLanjutan;
use App\inhealthSjp;
use App\ResepNote;
use App\ResepNoteDetail;
use App\Conf_rl\M_config35;
use App\PerawatanIcd10;
use Modules\Pasien\Entities\Province;
use App\Http\Controllers\LogUserController;
use App\FaskesRujukanRs;

class RawatinapController extends Controller
{
	public function index()
	{ }

	public function lapResumePasien()
	{
		$data['tga']		= '';
		$data['tgb']		= '';
		$data['p_icd9']		= [];
		return view('rawat-inap.lapResumePasien', $data)->with('no', 1);
	}

	public function filterLapResumePasien(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga				= valid_date($req->tga) . ' 00:00:00';
		$tgb				= valid_date($req->tgb) . ' 23:59:59';

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;

		$data['p_icd9']		= PerawatanIcd9::leftJoin('registrasis', 'registrasis.id', '=', 'perawatan_icd9s.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'perawatan_icd9s.registrasi_id')
			->leftJoin('histori_rawatinap', 'histori_rawatinap.registrasi_id', '=', 'perawatan_icd9s.registrasi_id')
			->whereNotNull('perawatan_icd9s.icd9')->where('perawatan_icd9s.jenis', 'TI')
			->whereBetween('perawatan_icd9s.created_at', [$tga, $tgb])
			->select(
				DB::raw('GROUP_CONCAT(perawatan_icd10s.icd10 SEPARATOR "||") as icd10'),
				DB::raw('GROUP_CONCAT(pasiens.tgllahir SEPARATOR "||") as lahir'),
				DB::raw('GROUP_CONCAT(pasiens.kelamin SEPARATOR "||") as gender'),
				DB::raw('GROUP_CONCAT(histori_rawatinap.mati SEPARATOR "||") as mati'),
				'perawatan_icd9s.icd9 as icd9'
			)
			->groupBy('icd9')->orderBy('icd9', 'asc')->get();
		if ($req->submit == 'TAMPILKAN') {
			return view('rawat-inap.lapResumePasien', $data)->with('no', 1);
		} elseif ($req->submit == 'CETAK') {
			$no = 1;
			$pdf = PDF::loadView('frontoffice.cetakLapResumePasien', $data, compact('no'));
			$pdf->setPaper('A4', 'landscape');
			// return $pdf->download('rekapLaporanIrna.pdf');
			return view('rawat-inap.cetakLapResumePasien', $data)->with('no', 1);
		} elseif ($req->submit == 'EXCEL') {
			$p_icd9 = $data['p_icd9'];
			Excel::create('Morbiditas & Mortalitas Ranap', function ($excel) use ($p_icd9) {
				// Set the properties
				$excel->setTitle('Morbiditas & Mortalitas Ranap')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Morbiditas & Mortalitas Ranap');
				$excel->sheet('Morbiditas & Mortalitas Ranap', function ($sheet) use ($p_icd9) {
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
						'Mati'
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
							(isset($mati[1])) ? $mati[1] : 0
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

	public function editInacbgs()
	{
		// $data['inacbgs']	= Inacbgs_sementara::leftJoin('registrasis', 'registrasis.id', '=', 'inacbgs_sementara.registrasi_id')
		// 		->where('inacbgs_sementara.ket', '')->get();
		$data['inacbgs']	= Registrasi::leftJoin('inacbgs_sementara', 'inacbgs_sementara.registrasi_id', '=', 'registrasis.id')
			->where('inacbgs_sementara.ket', '')
			->orderBy('registrasis.created_at', 'desc')
			->select('inacbgs_sementara.id', 'registrasis.created_at', 'registrasis.pasien_id', 'registrasis.dokter_id', 'inacbgs_sementara.inacbgs1', 'inacbgs_sementara.inacbgs2')->get();
		return view('rawat-inap.editInacbgs', $data)->with('no', 1);
	}

	public function dataInacbgs($id = '')
	{
		$data['inacbgs']	= Registrasi::leftJoin('inacbgs_sementara', 'inacbgs_sementara.registrasi_id', '=', 'registrasis.id')
			->where('inacbgs_sementara.id', $id)
			->select('inacbgs_sementara.id', 'registrasis.created_at', 'registrasis.pasien_id', 'registrasis.dokter_id', 'inacbgs_sementara.inacbgs1', 'inacbgs_sementara.inacbgs2')->first();
		return view('rawat-inap.dataInacbgs', $data);
	}

	public function updateInacbgs(Request $req)
	{
		$ket = [];
		if ($req->vip != 0) {
			$ket[] = 'inacbgs_vip';
		}
		if ($req->kls1 != 0) {
			$ket[] = 'inacbgs_kls1';
		}
		if ($req->kls2 != 0) {
			$ket[] = 'inacbgs_kls2';
		}
		if ($req->kls3 != 0) {
			$ket[] = 'inacbgs_kls3';
		}
		$ina = Inacbgs_sementara::find($req->id);
		$ina->inacbgs1		= 0;
		$ina->inacbgs2		= 0;
		$ina->inacbgs_vip	= $req->vip;
		$ina->inacbgs_kls1	= $req->kls1;
		$ina->inacbgs_kls2	= $req->kls2;
		$ina->inacbgs_kls3	= $req->kls3;
		$ina->ket 			= implode(';', $ket);
		$ina->update();
		// return implode(';', $ket);
		return redirect()->back();
	}

	public function menuBilling()
	{
		return view('rawat-inap.menuBillingIrna');
	}

	public function antrian($id = '')
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		$date = date('Y-m-d', strtotime('-2 days'));

		$data['antrian'] = Registrasi::whereIn('status_reg', ['I1', 'J1'])
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->get();
		//$data['reg']    = Registrasi::find($id);
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('rawat-inap.antrian', $data)->with('no', 1);
	}

	public function antrianform($id)
	{
		// $date = date('Y-m-d', strtotime('-10 days'));

		$data['reg'] = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->join('carabayars', 'registrasis.bayar', '=', 'carabayars.id')
			->select('registrasis.id', 'carabayars.carabayar as pembayaran', 'registrasis.bayar', 'registrasis.no_jkn', 'registrasis.tipe_jkn', 'pasiens.no_rm', 'pasiens.nama')
			->where('registrasis.id', $id)
			->first();
		$data['antrian'] = Registrasi::whereIn('status_reg', ['I1', 'J1'])
			// ->wherebetWeen('updated_at', [ $date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->get();
		//$data['reg']    = Registrasi::find($id);
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('rawat-inap.forma2', $data)->with('no', 1);
	}

	public function saveRawatInap(Request $request)
	{
		$ri = Rawatinap::where('registrasi_id', $request['registrasi_id'])->get();
		// if ($ri->count()) {
		// 	return response()->json(['error' => true, 'pesan' => 'Pasien sudah di inapkan sebelumnya!!! ']);
		// }
		$cek = Validator::make($request->all(), [
			'kelompokkelas_id' => 'required',
			'kelas_id' => 'required',
			'kamarid' => 'required',
			'bed_id' => 'required',
			'dokter_id' => 'required',
			'tgl_masuk' => 'required',
		]);
		if ($cek->passes()) {
			DB::transaction(function () use ($request) {
				$request['tgl_masuk'] = $request['tgl_masuk'] . ' ' . date('H:i:s');
				$reg = Registrasi::find($request['registrasi_id']);

				if ($request->rawatinap_id) {
					$ri = Rawatinap::where('id', $request->rawatinap_id)->first();
				} else {
					$ri = new Rawatinap();
				}
				$ri->registrasi_id = $request['registrasi_id'];
				$ri->carabayar_id = $request['carabayar_id'];
				$ri->kelompokkelas_id = $request['kelompokkelas_id'];
				$ri->kelas_id = $request['kelas_id'];
				$ri->kamar_id = $request['kamarid'];
				$ri->bed_id = $request['bed_id'];
				$ri->dokter_id = $request['dokter_id'];
				$ri->pagu_diagnosa_awal = $request['pagu_perawatan_id'];
				$ri->keterangan = $request['keterangan'];
				$ri->tgl_masuk = $request['tgl_masuk'];
				$ri->save();

				// JIKA BELUM ADA RAWATINAPID
				if (!$request->rawatinap_id) {
					$hi = new HistoriRawatInap();
					$hi->rawatinap_id = $ri->id;
					$hi->registrasi_id = $request['registrasi_id'];
					$hi->pasien_id = $reg->pasien->id;
					$hi->no_rm = $reg->pasien->no_rm;
					$hi->carabayar_id = $request['carabayar_id'];
					$hi->kelompokkelas_id = $request['kelompokkelas_id'];
					$hi->kelas_id = $request['kelas_id'];
					$hi->kamar_id = $request['kamarid'];
					$hi->bed_id = $request['bed_id'];
					$hi->dokter_id = $request['dokter_id'];
					$hi->tgl_masuk = $request['tgl_masuk'];
					$hi->user_id = Auth::user()->id;

					$hi->save();
				}

				//Insert Histori Pengunjung
				// JIKA BELUM ADA RAWATINAPID
				if (!$request->rawatinap_id) {
					$hp = new Historipengunjung();
					$hp->registrasi_id = $reg->id;
					$hp->pasien_id = $reg->pasien->id;
					$hp->politipe = 'I';
					if ($reg['status'] == 1) {
						$hp->status_pasien = 'BARU';
					} else {
						$hp->status_pasien = 'LAMA';
					}
					$hp->user = Auth::user()->name;
					$hp->save();
				}

				//Update registrasi
				$reg->status_reg = 'I2';
				$reg->no_rujukan = $request['no_rujukan'];
				$reg->tgl_rujukan = ($request['tgl_rujukan']) ? $request['tgl_rujukan'] : date('Y-m-d');
				$reg->ppk_rujukan = $request['ppk_rujukan'];
				$reg->tgl_sep = ($request['tgl_sep']) ? $request['tgl_sep'] : date('Y-m-d');
				$reg->diagnosa_inap = $request['diagnosa_awal'];
				$reg->catatan = $request['catatan_bpjs'];
				$reg->kelas_id = $request['kelas_id'];
				// $reg->hakkelas = $request['hak_kelas_inap'];
				$reg->no_sep = @$request['no_sep'];
				if ($request['poli_id']) {
					$reg->poli_id = @$request['poli_id'];
				}
				$reg->update();

				$bed = Bed::find($request['bed_id']);
				$bed->reserved = 'Y';
				$bed->update();

				if (!$request->rawatinap_id) {
					$histori = new HistoriStatus();
					$histori->registrasi_id = $request['registrasi_id'];
					$histori->status = 'I2';
					$histori->poli_id = $reg->poli_id;
					$histori->bed_id = $request['bed_id'];
					$histori->user_id = Auth::user()->id;
					$histori->save();
				}

				DB::commit();
				if (!empty($request['no_sep'])) {
					session(['no_sep' => $request['no_sep']]);
				}
			});
			Flashy::success('Rawat inap berhasil disimpan');
			return response()->json(['success' => '1']);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function hapusRawatInap($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$irna = Rawatinap::where('registrasi_id', $reg->id)->first();

		// //Hapus Histotri Status
		$histori = HistoriStatus::where('registrasi_id', $reg->id)->where('status', 'I2')->first();
		if ($histori) {
			$histori->delete();
		}

		//Update BED
		$bed = Bed::find($irna->bed_id);
		$bed->reserved = 'N';
		$bed->update();

		//Update registrasi
		$reg->status_reg = 'I1';
		$reg->no_rujukan = NULL;
		$reg->tgl_rujukan = NULL;
		$reg->ppk_rujukan = NULL;
		$reg->tgl_sep = NULL;
		$reg->diagnosa_inap = NULL;
		$reg->catatan = NULL;
		$reg->kelas_id = NULL;
		$reg->hakkelas = NULL;
		$reg->no_sep = NULL;
		$reg->update();

		//Insert Histori Pengunjung Rawat Inap
		$hp = Historipengunjung::where('registrasi_id', $registrasi_id)->where('politipe', 'I')->first();
		if ($hp) {
			$hp->delete();
		}

		//Hapus Histori Rawat Inap
		$hi = HistoriRawatInap::where('rawatinap_id', $irna->id)->where('registrasi_id', $registrasi_id)->first();
		if ($hi) {
			$hi->delete();
		}
	}

	public function pilihKelas(Request $req)
	{
		return redirect('rawat-inap/billing/' . $req['kelas_id'] . '/' . $req['kamar_id']);
	}

	public function billing($kelas_id = '', $kamar_id = '')
	{
		session()->forget('pj');
		session()->forget('lab_id');
		$data['tga']	= '';
		$data['tgb']	= '';
		$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->with(['dokter_ahli'])
			->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
			->leftJoin('kamars', 'kamars.id', 'rawatinaps.kamar_id')
			->leftJoin('beds', 'beds.id', 'rawatinaps.bed_id')
			->leftJoin('kelas', 'kelas.id', 'rawatinaps.kelas_id')
			->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
			->where('registrasis.status_reg', 'I2')
			->whereNull('rawatinaps.deleted_at')
			->whereNull('registrasis.deleted_at')
			->orderBy('id', 'DESC');

		if (!empty($kelas_id) && !empty($kamar_id)) {
			$data['inap'] =  $data['inap']->where('rawatinaps.kelas_id', $kelas_id)->where('rawatinaps.kamar_id', $kamar_id);
		}

		$kelompokKelas = Auth::user()->coder_nik;
		if ($kelompokKelas != '' || $kelompokKelas != NULL) {
			$kelompokKelas = explode(",", $kelompokKelas);
			$data['inap']->whereIn('rawatinaps.kelompokkelas_id', $kelompokKelas);
		}

		$data['inap'] = $data['inap']->select('rawatinaps.*', 'rawatinaps.dokter_id as dokter_inap', 'registrasis.id as reg_id', 'registrasis.tipe_jkn', 'registrasis.no_sep', 'registrasis.poli_id', 'registrasis.status_reg', 'registrasis.hakkelas', 'pegawais.nama as dokter_dpjp', 'pasiens.nama as nama_pasien', 'pasiens.no_rm', 'pasiens.tgllahir', 'kamars.nama as kamar', 'beds.nama as bed', 'kelas.nama as kelas', 'carabayars.carabayar')->get();

		// dd($data);
		$data['status_reg']	= 'I2';
		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
		// e resep
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['tiket'] = MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] = TakaranobatEtiket::all('nama', 'nama');
		$data['caraPulang'] = KondisiAkhirPasien::whereIn('jenis', ['cara_pulang', 'both'])->whereNotIn('namakondisi', ['Death On Arrival (DOA)', 'Di Inapkan', 'Kontrol'])->orderBy('urutan', 'ASC')->pluck('namakondisi', 'id');
		$data['kondisiPulang'] = KondisiAkhirPasien::whereIn('jenis', ['kondisi', 'both'])->where('namakondisi', '!=', 'Death On Arrival (DOA)')->orderBy('urutan', 'ASC')->pluck('namakondisi', 'id');
		$data['faskesRujukanRs']  = FaskesRujukanRs::all();
		$data['perinatologi'] = M_config35::all();

		$data['kelompok_kelas'] = getGroupKelas();
		// dd($data['cara_minum']);
		return view('rawat-inap.billing', $data)->with('no', 1);
	}

	public function filterBillingNew(Request $req)
	{
		// dd($req->all());
		// request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;
		$kelompokkelas_id = [];
		$kelompokkelas_id = [];
		$data['kelas']	= Kelompokkelas::where('kelompok', 'like', '%' . $req->kelompok_kelas . '%')->get();
		if (count($data['kelas'])) {
			foreach ($data['kelas'] as $kelas) {
				$kelompokkelas_id[] = $kelas->id;
			}
		}

		$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->with(['dokter_ahli'])
			->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
			->leftJoin('kamars', 'kamars.id', 'rawatinaps.kamar_id')
			->leftJoin('beds', 'beds.id', 'rawatinaps.bed_id')
			->leftJoin('kelas', 'kelas.id', 'rawatinaps.kelas_id')
			->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
			->where('registrasis.status_reg', 'I2')
			->whereNull('rawatinaps.deleted_at')
			->whereNull('registrasis.deleted_at')
			->whereIn('rawatinaps.kelompokkelas_id', $kelompokkelas_id)
			->groupBy('rawatinaps.registrasi_id')
			->orderBy('id', 'DESC')
			->limit(5);

		// if ($data['tga'] && $data['tgb']) {
		// 	$data['inap'] =	$data['inap']->whereBetween('rawatinaps.created_at', [valid_date($req['tga']) . ' 00:00:00', valid_date($req['tgb']) . ' 23:59:59']);
		// }
		if ($req->no_rm) {
			$data['inap'] =	$data['inap']->where('pasiens.no_rm', $req->no_rm);
		}

		// if (!empty($kelas_id) && !empty($kamar_id)) {
		// 	$data['inap'] =  $data['inap']->where('rawatinaps.kelas_id', $kelas_id)->where('rawatinaps.kamar_id', $kamar_id);
		// }

		$kelompokKelas = Auth::user()->coder_nik;
		if ($kelompokKelas != '' || $kelompokKelas != NULL) {
			$kelompokKelas = explode(",", $kelompokKelas);
			$data['inap']->whereIn('rawatinaps.kelompokkelas_id', $kelompokKelas);
		}

		$data['inap'] = $data['inap']->select('rawatinaps.*', 'rawatinaps.dokter_id as dokter_inap', 'registrasis.id as reg_id', 'registrasis.tipe_jkn', 'registrasis.no_sep', 'registrasis.poli_id', 'registrasis.status_reg', 'pegawais.nama as dokter_dpjp', 'pasiens.nama as nama_pasien', 'pasiens.no_rm', 'pasiens.tgllahir', 'kamars.nama as kamar', 'beds.nama as bed', 'kelas.nama as kelas', 'carabayars.carabayar')->get();


		$data['status_reg']	= $req->jenis_reg;
		// e resep
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] = TakaranobatEtiket::all('nama', 'nama');
		$data['caraPulang'] = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orWhere('jenis', 'both')->orderBy('urutan', 'ASC')->pluck('namakondisi', 'id');
		$data['perinatologi'] = M_config35::all();
		$data['kondisiPulang'] = KondisiAkhirPasien::whereIn('jenis', ['kondisi', 'both'])->where('namakondisi', '!=', 'Death On Arrival (DOA)')->orderBy('urutan', 'ASC')->pluck('namakondisi', 'id');
		$data['faskesRujukanRs']  = FaskesRujukanRs::all();
		$data['kelompok_kelas'] = getGroupKelas();
		$data['kelas_selected'] = $req->kelompok_kelas;
		return view('rawat-inap.billing', $data)->with('no', 1);
	}


	public function pilihKelasp(Request $req)
	{
		return redirect('rawat-inap/billingpulang/' . $req['kelas_id'] . '/' . $req['kamar_id']);
	}

	public function billingp($kelas_id = '', $kamar_id = '')
	{
		session()->forget('pj');
		session()->forget('lab_id');
		$data['tga']	= '';
		$data['tgb']	= '';
		if (!empty($kelas_id) && !empty($kamar_id)) {
			$data['inap'] = Rawatinap::where('kelas_id', $kelas_id)->where('kamar_id', $kamar_id)->get();
		} else {
			if (Auth::user()->kelompokkelas_id != 10) {
				$data['inap'] = DB::table('rawatinaps')
					->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
					->where('rawatinaps.kelompokkelas_id', Auth::user()->kelompokkelas_id)
					->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
					->where('registrasis.status_reg', 'I3')
					->whereNull('rawatinaps.deleted_at')
					->select('rawatinaps.*', 'registrasis.status_reg')->get();
			} else {
				$data['inap'] = DB::table('rawatinaps')
					->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
					->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
					->where('registrasis.status_reg', 'I3')
					->whereNull('rawatinaps.deleted_at')
					->select('rawatinaps.*', 'registrasis.status_reg')->get();
				// dd($data);
			}
		}
		foreach ($data['inap'] as $key => $d) {
			$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'jawab_konsul')->select('id')->orderBy('id', 'DESC')->first();
			if (!$konsulJawab) {
				$konsulJawab = EmrKonsul::where('registrasi_id', $d->id)->where('type', 'konsul_dokter')->select('id')->orderBy('id', 'DESC')->first();
			}
			$d->konsulJawabId = $konsulJawab ? $konsulJawab->id : null;
		}
		// dd($data);
		$data['status_reg']	= 'I3';
		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
		// e resep
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['tiket'] = MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] = TakaranobatEtiket::all('nama', 'nama');

		$data['perinatologi'] = M_config35::all();
		$data['kelompok_kelas'] = getGroupKelas();
		// dd($data['cara_minum']);
		return view('rawat-inap.billingpulang', $data)->with('no', 1);
	}



	public function cetak_rincian($registrasi_id)
	{
		$data['reg'] = Registrasi::where('id', $id)->first();
		$data['kuitansi'] = Pembayaran::where('id', $id);
		//dd($data['kuitansi']);
		$data['reg']      = Registrasi::with('bayars')->find($data['kuitansi']->registrasi_id);
		$nokuitansi       = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)->where('jenis', 'ORJ')->where('lunas', 'Y')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->first();
		if (!$nokuitansi) {
			$noresep = '';
		} else {
			$noresep = $nokuitansi->namatarif;
		}

		$data['penjualan'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			//->where('penjualandetails.no_kuitansi',$noresep)
			->where('penjualandetails.jumlah', '!=', '0')
			->where('penjualans.registrasi_id', $data['reg']->id)
			->select('penjualandetails.*')
			->get();

		//dd($data['penjualan'] );
		// return $data['penjualan']; die;

		//kondisi to lab rajal
		$data['folio_irj_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to rad rajal
		$data['folio_irj_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab igd
		$data['folio_igd_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to rad igd
		$data['folio_igd_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab irna
		$data['folio_irna_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab irna
		$data['folio_irna_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//Master Loop
		$data['folio_irj'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['folio_igd'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			// ->where('poli_tipe', 'J')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['folio_irna'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();
		// $data['folio_irna']   = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)->groupBy('tarif_id')->where('lunas', 'Y')->where('jenis', 'TI')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->get();

		$data['folio_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'ORJ')
			->get();

		$data['folio'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			//->where('jenis','TI')
			->groupBy('tarif_id')
			->selectRaw('tarif_id,verif_kasa_user, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['listDokter'] = [];
		foreach (Pegawai::where('kategori_pegawai', 1)->whereNotIn('id', [$data['reg']->dokter_id])->get() as $d) {
			$data['listDokter'][] = '' . $d->id . '';
		}
		$data['dokter'] = Folio::where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)
			->where('registrasi_id', $data['reg']->id)->whereIn('dokter_pelaksana', [$data['listDokter']])
			->groupBy('dokter_pelaksana')->select('dokter_pelaksana')->get();

		$data['jml'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('lunas', 'Y')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');
		$data['no'] = 1;

		//JUMLAH IGD

		$data['jml_igd'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			// ->where('poli_tipe', 'J')
			->Where('poli_tipe', 'G')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)
			->sum('total');

		$data['jml_igd_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_igd_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		//JUMLAH RAJAL

		$data['jml_irj_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irj_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irj'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'J')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');


		//JUMLAH IRNA

		$data['jml_irna_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irna_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irna'] = Folio::where('registrasi_id', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', null)
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		// $data['jml_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
		//     ->where('namatarif','!=','Retur penjualan')
		//     ->where('jenis','ORJ')
		// 	->where('lunas', 'Y')
		// 	->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		//new commant
		$data['jml_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('namatarif', '!=', 'Retur penjualan')
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->sum('total');

		// $data['jml_obat'] = Folio::join('penjualans','folios.registrasi_id','=','penjualans.registrasi_id')
		// 					->join('penjualandetails','penjualans.id','=','penjualandetails.penjualan_id')
		// 					->where('folios.registrasi_id', '=', $data['kuitansi']->registrasi_id)
		// 					->where('folios.namatarif','!=','Retur penjualan')
		// 					->where('penjualandetails.jumlah','!=','0')
		// 					->where('folios.jenis','ORJ')
		// 					->where('folios.lunas', 'Y')
		// 					->sum('total');

		//dd($data['jml_obat']);

		$data['embalase'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('embalase');

		$data['jasaracik'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('jasa_racik');

		$data['uangracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)->sum('uang_racik');

		$data['jmlracikper'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->groupBy('uang_racik_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)->sum('uang_racik');

		$data['Totracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)
			->groupBy('uang_racik_id')
			->selectRaw('count(penjualandetails.uang_racik) as Tot')
			->get();

		$data['jenisracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->join('uang_raciks', 'penjualandetails.uang_racik_id', '=', 'uang_raciks.id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)
			->groupBy('uang_racik_id')
			->select('penjualandetails.uang_racik', 'uang_raciks.nama', DB::raw('sum(penjualandetails.uang_racik) as uracik'), DB::raw('count(penjualandetails.uang_racik) as jmlracik'))
			->get();

		$data['no'] = 1;
		return view('rawat-inap.cetakbilling', compact('registrasi_id'))->with('no', 1);
	}


	public function filterBilling()
	{
		if (Auth::user()->kelompokkelas_id != 10) {
			$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->where(['rawatinaps.kelompokkelas_id' => Auth::user()->kelompokkelas_id, 'registrasis.status_reg' => 'I3'])
				->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
				->select('rawatinaps.*', 'registrasis.status_reg')->get();
		} else {
			$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
				->where('registrasis.status_reg', 'I3')
				->select('rawatinaps.*', 'registrasis.status_reg')->get();
		}
		$data['status_reg']	= 'I3';
		// e resep	
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] = TakaranobatEtiket::all('nama', 'nama');
		$data['perinatologi'] = M_config35::all();
		$data['faskesRujukanRs']  = FaskesRujukanRs::all();
		$data['kelompok_kelas'] = getGroupKelas();
		$data['caraPulang'] = KondisiAkhirPasien::where('jenis', 'cara_pulang')->orWhere('jenis', 'both')->orderBy('urutan', 'ASC')->pluck('namakondisi', 'id');

		return view('rawat-inap.billing', $data)->with('no', 1);
	}




	public function filterBillingNewPulang(Request $req)
	{
		// dd($req->all());
		// request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;
		$kelompokkelas_id = [];
		$data['kelas']	= Kelompokkelas::where('kelompok', 'like', '%' . $req->kelompok_kelas . '%')->get();
		if (count($data['kelas'])) {
			foreach ($data['kelas'] as $kelas) {
				$kelompokkelas_id[] = $kelas->id;
			}
		}
		$data['inap'] = Rawatinap::with('registrasi.pasien')->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.status_reg', $req->jenis_reg)
			->whereIn('rawatinaps.kelompokkelas_id', $kelompokkelas_id)
			->groupBy('rawatinaps.registrasi_id');

		if ($data['tga'] && $data['tgb']) {
			$data['inap'] =	$data['inap']->whereBetween('rawatinaps.created_at', [valid_date($req['tga']) . ' 00:00:00', valid_date($req['tgb']) . ' 23:59:59']);
		}
		if ($req->no_rm) {
			$data['inap'] =	$data['inap']->where('pasiens.no_rm', $req->no_rm);
		}

		$data['inap']	= $data['inap']->select('rawatinaps.*', 'registrasis.status_reg')->get();
		// dd($data['inap']);


		$data['status_reg']	= $req->jenis_reg;
		// e resep
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['cara_minum'] = masterCaraMinum::all('nama', 'id');
		$data['takaran'] = TakaranobatEtiket::all('nama', 'nama');
		$data['perinatologi'] = M_config35::all();
		$data['kelompok_kelas'] = getGroupKelas();
		$data['kelas_selected'] = $req->kelompok_kelas;
		return view('rawat-inap.billingpulang', $data)->with('no', 1);
	}


	public function inacbgs($reg_id)
	{
		$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $reg_id)->first();
		$data['reg_id']	= $reg_id;
		// return $data['inacbgs'];die;
		return view('rawat-inap.inacbgs', $data);
	}

	public function inacbgsSave(Request $req)
	{
		$ceck = Inacbgs_sementara::where('registrasi_id', $req->registrasi_id)->count();
		$ket = [];
		if ($req->inacbgs_vip != 0) {
			$ket[] = 'inacbgs_vip';
		}
		if ($req->inacbgs_kls1 != 0) {
			$ket[] = 'inacbgs_kls1';
		}
		if ($req->inacbgs_kls2 != 0) {
			$ket[] = 'inacbgs_kls2';
		}
		if ($req->inacbgs_kls3 != 0) {
			$ket[] = 'inacbgs_kls3';
		}
		if ($ceck > 0) {
			$ina = Inacbgs_sementara::where('registrasi_id', $req->registrasi_id)->first();
			$ina->inacbgs1		= 0;
			$ina->inacbgs2		= 0;
			$ina->inacbgs_vip	= $req->inacbgs_vip;
			$ina->inacbgs_kls1	= $req->inacbgs_kls1;
			$ina->inacbgs_kls2	= $req->inacbgs_kls2;
			$ina->inacbgs_kls3	= $req->inacbgs_kls3;
			$ina->ket 			= implode(';', $ket);
			$ina->user_id		= Auth::user()->id;
			$ina->update();
		} else {
			$ina = new Inacbgs_sementara();
			$ina->registrasi_id = $req->registrasi_id;
			$ina->inacbgs1			= 0;
			$ina->inacbgs2			= 0;
			$ina->inacbgs_vip		= $req->inacbgs_vip;
			$ina->inacbgs_kls1		= $req->inacbgs_kls1;
			$ina->inacbgs_kls2		= $req->inacbgs_kls2;
			$ina->inacbgs_kls3		= $req->inacbgs_kls3;
			$ina->ket 				= implode(';', $ket);
			$ina->user_id 			= Auth::user()->id;
			$ina->save();
		}
		return redirect('rawat-inap/billing');
	}

	public function update_pagu($registrasi_id, Request $request)
	{
		$rawatInap = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$rawatInap->pagu_diagnosa_awal = $request->biaya_diagnosa_awal;
		$rawatInap->save();

		return response()->json('ok');
	}

	public function entry_tindakan($registrasi_id)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		$data['icd9'] = PerawatanIcd9::where('registrasi_id',  $registrasi_id)->pluck('icd9')->toArray();
		$data['icd10'] = PerawatanIcd10::where('registrasi_id',  $registrasi_id)->pluck('icd10')->toArray();
		$data['reg_id'] = $registrasi_id;
		$data['reg'] = Registrasi::where('id', '=', $registrasi_id)->first();
		$data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
		$data['dokter'] = Pegawai::all();
		$data['perawat'] = Pegawai::pluck('nama', 'id');
		$data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
		if ($data['rawatinap']) {
			if (@$data['reg']->status_reg == NULL) {
				if ($data['rawatinap']->tgl_keluar) {
					@$data['reg']->status_reg = 'I3';
				} else {
					@$data['reg']->status_reg = 'I2';
				}
				@$data['reg']->save();
			}
		}
		//dd($data['rawatinap']);
		$data['carabayar'] = \Modules\Registrasi\Entities\Carabayar::pluck('carabayar', 'id');
		$data['kamar'] = Kamar::pluck('nama', 'id');
		$data['kelas'] = Kelas::pluck('nama', 'id');
		$data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
		// $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
		$data['pagu'] = PaguPerawatan::all();
		// inhealth mandiri
		$data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
		if ($data['rawatinap']) {
			session(['kelas' => $data['rawatinap']->kelas_id]);
		}
		// return $data; die;
		return view('rawat-inap.entry_tindakan', $data);
	}
	public function lihat_pasien_bed($id)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		$data['bed'] = Rawatinap::leftJoin('beds', 'beds.id', '=', 'rawatinaps.bed_id')
			->leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->where('rawatinaps.bed_id', $id)
			->whereNull('registrasis.deleted_at')
			->whereNull('rawatinaps.tgl_keluar')
			->orderBy('rawatinaps.id', 'DESC')
			->limit(5)
			->get();
		// dd($bed);


		// return $data; die;
		return view('rawat-inap.lihat_bed_pasien', $data);
	}

	public function dataTindakanIrna($registrasi_id)
	{
		// inhealth mandiri
		$data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
		$data['rawatinap'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		if (Auth::user()->hasRole(['administrator'])) {
			$carabayar = Carabayar::pluck('carabayar', 'id');
			$folio = Folio::where(['registrasi_id' => $registrasi_id])
				->where('jenis', 'TI')
				->where('poli_tipe', null)
				->orderBy('created_at', 'desc')
				->select('tarif_id', 'waktu_visit', 'poli_tipe', 'dokter_id', 'id', 'lunas', 'dijamin', 'cara_bayar_id', 'registrasi_id', 'namatarif', 'total', 'jenis', 'user_id', 'created_at', 'dpjp', 'dokter_pelaksana', 'perawat')
				->get();
		} else {
			$carabayar = Carabayar::pluck('carabayar', 'id');
			$folio = Folio::where(['registrasi_id' => $registrasi_id])
				->orderBy('created_at', 'desc')
				->select('tarif_id', 'waktu_visit', 'poli_tipe', 'dokter_id', 'id', 'lunas', 'dijamin', 'cara_bayar_id', 'registrasi_id', 'namatarif', 'total', 'jenis', 'user_id', 'created_at', 'dpjp', 'dokter_pelaksana', 'perawat')
				->get();
		}
		// return response()->json($folio); die;
		return view('rawat-inap.dataTindakanIrna', compact('folio', 'carabayar', 'data'))->with('no', 1);
	}

	public function updateCaraBayar($id, $cara_bayar)
	{
		$folio = Folio::find($id);
		$folio->cara_bayar_id = $cara_bayar;
		$folio->update();

		Flashy::success('Cara bayar berhasil di update !');
	}

	public function save_tindakan(Request $request)
	{

		request()->validate(['tarif_id' => 'required', 'pelaksana' => 'required']);
		LogUserController::log(Auth::user()->id, 'billing', $request['registrasi_id']);
		// dd($request['tarif_id']);
		DB::transaction(function () use ($request) {
			foreach ($request['tarif_id'] as $i) {
				$time = Carbon::now()->format('H:i:s');
				$kode   = $i;
				$ri = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
				$reg = Registrasi::find($request['registrasi_id']);
				$tarif = Tarif::find($kode);
				$fol = new Folio();
				$fol->registrasi_id = $request['registrasi_id'];
				$fol->lunas = 'N';
				$fol->namatarif = $tarif->nama;
				$fol->tarif_id = $kode;
				$fol->cara_bayar_id = $request['cara_bayar_id'];
				$fol->jenis = 'TI';
				// Penambahan harga berdasarkan Cito dan Eksekutif
				$cytoIncrease = $request['cyto'] != null ? $tarif->total * 0.5 : 0; // Tambah 50% jika Cito dipilih
				$eksekutifIncrease = $request['eksekutif'] != null ? $tarif->total * 0.8 : 0; // Tambah 80% jika Eksekutif dipilih

				// Total penambahan harga
				$totalIncrease = $cytoIncrease + $eksekutifIncrease;

				// Total setelah penambahan harga
				$fol->total = ($tarif->total + $totalIncrease) * $request['jumlah'];
				$fol->jenis_pasien = $request['jenis'];
				$fol->pasien_id = $request['pasien_id'];
				$fol->verif_kasa_user  = 'tarif_new';
				$fol->harus_bayar = $request['jumlah'];
				$fol->dijamin = $request['dijamin'];
				$fol->dokter_id = $request->dokter_id;
				$fol->cyto = $request['cyto'];

				if (!empty($request['tanggal'])) {
					$fol->created_at = valid_date($request['tanggal']) . ' ' . $time;
				}
				$fol->kelompokkelas_id = @$ri->kelompokkelas_id;
				$fol->kamar_id = @$ri->kamar_id;
				$fol->user_id = Auth::user()->id;
				$fol->mapping_biaya_id = $tarif->mapping_biaya_id;
				$fol->dpjp = $request['dpjp'];
				$fol->dokter_pelaksana = $request['pelaksana'];
				$fol->perawat = $request['perawat'];
				$fol->pelaksana_tipe = 'TI';
				$fol->waktu_visit = $request['waktu_visit_dokter'];

				$fol->save();

				// $fp = new Foliopelaksana();
				// $fp->folio_id = $fol->id;
				// $fp->dpjp = $request['dpjp'];
				// $fp->dokter_pelaksana = $request['pelaksana'];
				// $fp->perawat = $request['perawat'];
				// $fp->pelaksana_tipe = 'TI';
				// $fp->user = Auth::user()->id;
				// $fp->save();

				// Insert Histori
				$bed = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
				// $bed->dokter_id = $request['dpjp'];
				// $bed->update();

				$history = new HistoriStatus();
				$history->registrasi_id = $request['registrasi_id'];
				$history->status = 'I2';
				$history->bed_id = $bed->bed_id;
				$history->user_id = Auth::user()->id;
				$history->save();
			}

			session(['perawat' => $request['perawat'], 'pelaksana' => $request['pelaksana']]);
		});

		// return redirect('rawat-inap/entry-tindakan/' . $request['registrasi_id']);
		return redirect()->back();
	}

	public function editTindakan($folio_id = '', $tarif_id = '')
	{
		if ($tarif_id == 10000) {
			$folio = Folio::find($folio_id);
			return response()->json(['folio' => $folio, 'dokter' => '']);
		} else {
			$folio = Folio::where('folios.id', $folio_id)->first();
			$dokter = Rawatinap::where('registrasi_id', $folio->registrasi_id)->first();
			return response()->json(['folio' => $folio, 'dokter' => $dokter]);
		}
	}

	public function editJenisTindakan(Request $request, $id)
	{
		// Folio::find($request['id'])->update([
		// 	'jenis' => $request['jenis']
		// ]);
		$folio = Folio::find($request['id']);
		$folio->jenis = $request['jenis'];
		$folio->update();

		return response()->json(['sukses' => true, 'text' => 'Success Update Jenis Tindakan']);
	}

	public function saveEditTindakan(Request $request)
	{
		DB::transaction(function () use ($request) {
			$tarif = Tarif::find($request['tarif_id']);

			$fol = Folio::find($request['folio_id']);
			$fol->registrasi_id = $request['registrasi_id'];
			$fol->namatarif = $tarif->nama;
			$fol->tarif_id = $request['tarif_id'];
			$fol->mapping_biaya_id = $tarif->mapping_biaya_id;
			$fol->cara_bayar_id = $request['cara_bayar_id'];
			$fol->dijamin = $request['dijamin'];
			$fol->total = ($tarif->total * $request['jumlah']);
			if (!empty($request['tanggal'])) {
				$fol->created_at = valid_date($request['tanggal']);
			}
			$fol->user_id = Auth::user()->id;
			$fol->update();
			if ($request->id_tarif != 10000) {
				$fp = Folio::where('id', $fol->id)->first();
				$fp->dpjp = $request['dpjp'];
				$fp->dokter_pelaksana = $request['pelaksana'];
				$fp->perawat = $request['perawat'];
				$fp->pelaksana_tipe = 'TI';
				// $fp->user = Auth::user()->id;
				$fp->update();
			}
		});
		return response()->json(['sukses' => true]);
	}

	public function hapusTindakan($id, $registrasi_id)
	{
		if (Auth::user()->hasRole(['rawatinap', 'supervisor', 'administrator'])) {
			// Folio::where('id', $id)->where('lunas', 'N')->delete();

			$folio = Folio::find($id);

			if (@$folio->lunas == 'N') {
				$folio->delete();
			}
			Flashy::info('Tindakan berhasil di hapus');
		}
		// return redirect('/rawat-inap/entry-tindakan/' . $registrasi_id);
		return redirect()->back();
	}

	public function ibs($registrasi_id = '')
	{
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['ibs'] = Operasi::where('registrasi_id', $registrasi_id)->get();
		$data['poli'] = Poli::all();
		return view('rawat-inap.ibs', $data)->with('no', 1);
	}

	public function saveibs(Request $req)
	{
		// dd($req->kodepoli)
		$req->validate(['rencana_operasi' => 'required', 'suspect' => 'required', 'kodepoli' => 'required']);
		// if ($req->carabayar == 'JKN') {
		// 	$req->validate(['no_jkn' => 'required']);
		// } 

		$namapoli   = SepPoliLanjutan::where('kode_poli', $req->kodepoli)->first();
		// dd($namapoli);
		$booking	= Operasi::where('rencana_operasi', valid_date($req['rencana_operasi']))->count();
		$hitung		= $booking + 1;

		$ibs = new Operasi();
		$ibs->registrasi_id = @$req['registrasi_id'];
		$ibs->rawatinap_id = @$req['rawatinap_id'];
		$ibs->no_rm = $req['no_rm'];
		$ibs->no_jkn = !empty($req['no_jkn']) ? $req['no_jkn'] : NULL;
		$ibs->rencana_operasi = valid_date($req['rencana_operasi']);
		$ibs->suspect = $req['suspect'];
		if (!$req['rawatinap_id']) {
			$ibs->keterangan = 'Input dari TPPRI Sebelum diinapkan';
		}
		$ibs->kodepoli = $req['kodepoli'];
		$ibs->namapoli = @$namapoli->nama_poli;
		$ibs->terlaksana = 0;
		$ibs->kodebooking = 'IBS' . valid_date($req['rencana_operasi']) . '-' . $hitung;
		$ibs->save();
		Flashy::success('IBS berhasil disimpan');
		return redirect('rawat-inap/admission');
	}

	public function updateRencanaOperasi(Request $req)
	{
		$ibs = Operasi::find($req->id);
		if (!$ibs) {
			return response()->json(['error' => 'Data tidak ditemukan'], 404);
		}
		$ibs->rencana_operasi = $req->rencana_operasi;
		$ibs->save();

		return response()->json([
			'success' => true,
			'tgl_indo' => tgl_indo($ibs->rencana_operasi)
		]);
	}

	public function laboratorium($reg_id = '')
	{
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'L'])->get();
		$folio = Folio::where('registrasi_id', $reg_id)->get(['tarif_id']);
		foreach ($folio as $key) {
			$data['select'][] = $key['tarif_id'];
		}
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::pluck('nama', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'L')->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['tarif'] = Tarif::where('jenis', 'TI')->get(['id', 'nama']);
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 9)->where('tarifs.jenis', '=', 'TI')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['order'] = Orderlab::where(['registrasi_id' => $reg_id, 'jenis' => 'TI'])->get();
		$data['irna'] = Rawatinap::where('registrasi_id', $reg_id)->first();
		return view('rawat-inap.laboratorium', $data)->with('no', 1);
	}

	public function simpanLaboratorium(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderlab();
		$lab->jenis = 'TI';
		$lab->kamar_id = $request['kamar_id'];
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Laboratorium Sukses');
		return redirect('rawat-inap/billing');
	}

	public function ppi($pasien_id = '')
	{
		$data['reg'] = Registrasi::where('pasien_id', $pasien_id)->first();
		$data['pasien'] = Pasien::where('id', $pasien_id)->get();
		$data['ppi'] = \App\PPI\Ppi::where('pasien_id', $pasien_id)->get();
		// return $data; die;
		return view('rawat-inap.ppi', $data)->with('no', 1);
	}

	public function radiologi($reg_id = '')
	{
		$data['folio'] = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'R'])->get();
		$folio = Folio::where('registrasi_id', $reg_id)->get(['tarif_id']);
		foreach ($folio as $key) {
			$data['select'][] = $key['tarif_id'];
		}
		$data['reg'] = Registrasi::where('id', $reg_id)->first();
		$data['jenis'] = Registrasi::where('id', '=', $reg_id)->first();
		$data['pelaksana'] = Pegawai::pluck('nama', 'id');
		$data['perawat'] = Pegawai::where('poli_type', 'R')->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['tarif'] = Tarif::where('jenis', 'TI')->get(['id', 'nama']);
		$data['tindakan'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.kategoriheader_id', 11)->where('tarifs.jenis', '=', 'TI')->where('tarifs.total', '<>', 0)->select('tarifs.*', 'kategoritarifs.namatarif')->get();
		$data['order'] = Orderradiologi::where(['registrasi_id' => $reg_id, 'jenis' => 'TI'])->get();
		$data['irna'] = Rawatinap::where('registrasi_id', $reg_id)->first();
		return view('rawat-inap.radiologi', $data)->with('no', 1);
	}

	public function simpanRadiologi(Request $request)
	{
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderradiologi();
		$lab->jenis = 'TI';
		$lab->kamar_id = $request['kamar_id'];
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Radiologi Sukses');
		return redirect('rawat-inap/billing');
	}

	public function fisioterapi($registrasi_id = '')
	{
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		return view('rawat-inap.fisioterapi', $data);
	}

	public function gizi($registrasi_id = '')
	{
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['gizi'] = Mastergizi::pluck('gizi', 'gizi');
		return view('rawat-inap.gizi', $data);
	}

	public function simpanGizi(Request $request)
	{
		request()->validate(['catatan' => 'required']);
		$gz = new Gizi();
		$gz->registrasi_id = $request['registrasi_id'];
		$gz->dokter = baca_dokter($request['dokter']);
		$gz->kelas_id = $request['kelas_id'];
		$gz->kamar_id = $request['kamar_id'];
		$gz->bed_id = $request['bed_id'];
		$gz->pagi = $request['pagi'];
		$gz->siang = $request['siang'];
		$gz->malam = $request['pagi'];
		$gz->catatan = $request['catatan'];
		$gz->who_update = Auth::user()->name;
		$gz->save();
		Flashy::success('Pendaftaran Gizi Sukses');
		return redirect('rawat-inap/billing');
	}

	public function mutasi($registrasi_id)
	{
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['pengirim'] = Pegawai::pluck('nama', 'id');
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		$data['histori'] = HistoriRawatInap::where('registrasi_id', $registrasi_id)->get();
		return view('rawat-inap.mutasi', $data);
	}

	public function simpanMutasi(Request $request)
	{
		request()->validate(['kelompokkelas_id' => 'required', 'kelas_id' => 'required', 'kamarid' => 'required', 'bed_id' => 'required', 'pengirim' => 'required']);

		$cekbed = Bed::where('id', $request['bed_id'])->first();
		if ($cekbed->reserved == 'Y') {
			Flashy::success('Bed sudah terisi oleh pasien lain, silahkan pilih bed lain');
			return redirect()->back();
		}
		//  Validator::make($request->all(), [
		// 	'kelompokkelas_id' => 'required',
		// 	'kelas_id' => 'required',
		// 	'kamarid' => 'required',
		// 	'bed_id' => 'required',
		// 	'dokter_id' => 'required',
		// ]);
		// if ($cek->passes()) {
		DB::transaction(function () use ($request) {
			$irna = Rawatinap::where('id', $request['rawatinap_id'])->first();
			$irna->kelompokkelas_id = $request['kelompokkelas_id'];
			$irna->kelas_id = $request['kelas_id'];
			$irna->kamar_id = $request['kamarid'];
			$irna->bed_id = $request['bed_id'];
			$irna->dokter_id = $request['dokter_id'];
			$irna->pengirim = $request['pengirim'];
			$irna->update();

			//insert histori irna
			$reg = Registrasi::find($irna->registrasi_id);
			$hi = new HistoriRawatInap();
			$hi->rawatinap_id = $irna->id;
			$hi->registrasi_id = $reg->id;
			$hi->pasien_id = $reg->pasien->id;
			$hi->no_rm = $reg->pasien->no_rm;
			$hi->carabayar_id = $irna->carabayar_id;
			$hi->kelompokkelas_id = $request['kelompokkelas_id'];
			$hi->kelas_id = $request['kelas_id'];
			$hi->kamar_id = $request['kamarid'];
			$hi->bed_id = $request['bed_id'];
			$hi->dokter_id = $request['dokter_id'];
			$hi->pengirim = $request['pengirim'];
			$hi->tgl_masuk = !empty($request['tgl_masuk']) ? date(valid_date($request['tgl_masuk']) . ' H:i:s') : date('Y-m-d H:i:s');
			$hi->save();

			//Update bed baru
			$bb = Bed::where('id', $request['bed_id'])->first();
			$bb->reserved = 'Y';
			$bb->update();

			//Update bed lama
			$bed = Bed::where('id', $request['bed_lama'])->first();
			if ($bed) {
				$bed->reserved = 'N';
				$bed->update();
			}


			$history = new HistoriStatus();
			$history->registrasi_id = $request['registrasi_id'];
			$history->status = 'I2';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = $request['bed_id'];
			$history->user_id = Auth::user()->id;
			$history->save();
		});
		Flashy::success('Pendaftaran Mutasi Sukses');
		return redirect('rawat-inap/billing');
		// }
		// else {
		// 	return response()->json(['errors' => $cek->errors()]);
		// }
	}

	public function updateMutasi(Request $request)
	{
		$request->validate([
			'kelompokkelas_id_edit' => 'required',
			'kelas_id_edit' => 'required',
			'kamarid_edit' => 'required',
			'bed_id_edit' => 'required',
		]);

		$mutasi_id = $request->mutasi_id;
		$history = HistoriRawatInap::find($mutasi_id);
		$history->kelompokkelas_id = $request->kelompokkelas_id_edit;
		$history->kelas_id = $request->kelas_id_edit;
		$history->kamar_id = $request->kamarid_edit;
		$history->bed_id = $request->bed_id_edit;
		$history->update();

		Flashy::success('Update Mutasi Sukses');
		return redirect()->back();
	}

	public function pulang(Request $request)
	{
		// return $request->all();
		$registrasi_id = $request['registrasi_id'];
		$bed_id = $request['bed_id'];
		$statuspulang = $request['statusPulang'];
		$kondisiPulang = $request['kondisiPulang'];
		$tanggal = valid_date($request['tanggal']);
		// return response()->json(['data'=>$request->all()]); die;

		DB::transaction(function () use ($registrasi_id, $bed_id, $tanggal, $statuspulang, $request, $kondisiPulang) {
			$reg = Registrasi::where('id', $registrasi_id)->first();
			$reg->pulang  = $statuspulang;
			$reg->kondisi_akhir_pasien	= $kondisiPulang;
			$reg->status_reg = 'I3';
			//if rujukan
			// dd($request->status);
			if ($statuspulang == 2) {

				// JIKA ADA STATUS UGD
				if (@$reg->status_ugd) {
					$status_old = @json_decode(@$reg->status_ugd, true);
					if (is_array($request->status)) {
						$status_new = array_merge($status_old, $request->status);
					} else {
						$status_new = $status_old;
					}
					$reg->status_ugd = json_encode($status_new);

					// jika status ugd kosong
				} else {
					$reg->status_ugd = json_encode($request->status);
				}
			}
			$reg->update();

			$history = new HistoriStatus();
			$history->registrasi_id = $registrasi_id;
			$history->status = 'I3';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = null;
			$history->user_id = Auth::user()->id;
			$history->save();

			$bed = Bed::find($bed_id);
			if ($bed) {
				$bed->reserved = 'N';
				$bed->update();
			}
			$ri = Rawatinap::where('registrasi_id', $registrasi_id)->first();
			$ri->tgl_keluar = date($tanggal . ' H:i:s');
			if ($request->is_bayi != null) { // Jika Bayi
				$ri->is_bayi = 'Y';
				if ($request->status_bayi == "hidup") {
					$ri->perinatologi_hidup = $request->perinatologi_hidup;
				} elseif ($request->status_bayi == "mati") {
					$ri->perinatologi_mati = $request->perinatologi_mati;
					$ri->perinatologi_sebab_mati = $request->perinatologi_sebab_mati;
				}
			}
			$ri->update();
		});

		$reg = Registrasi::find($registrasi_id);
		Flashy::success('Pasien ' . $reg->pasien->nama . ' berhasil dipulangkan tanggal ' . tgl_indo($tanggal));
		return response()->json(['sukses' => true]);
	}

	//============ EMR =============================

	public function emr()
	{
		return view('rawat-inap.view_emr');
	}

	//========= LAPORAN ==========================================================
	/*
	public function lap_pengunjung_inap() {
		$data['reg'] = Historipengunjung::join('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->where('politipe', 'I')
			->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d') . '%')
			->select('registrasis.status', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.tgllahir', 'rawatinaps.kamar_id', 'rawatinaps.dokter_id')
			->get();
		return view('rawat-inap.lap_pengunjung_inap', $data)->with('no', 1);
	}

	public function lap_pengunjung_inap_bytanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['reg'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->where('politipe', 'I')
			->whereBetween('histori_pengunjung.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->select('registrasis.status', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.tgllahir', 'rawatinaps.kamar_id', 'rawatinaps.dokter_id')
			->get();
		return view('rawat-inap.lap_pengunjung_inap', $data)->with('no', 1);
	}
*/

	public function lapRekammedis()
	{
		$data['tga']	= '';
		$data['tgb']	= '';
		return view('rawat-inap.lapRekammedis', $data)->with('no', 1);
	}

	public function filterLapRekammedis(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga			= valid_date($req->tga) . ' 00:00:00';
		$tgb			= valid_date($req->tgb) . ' 23:59:59';

		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;

		$data['icd9']	= PerawatanIcd9::leftJoin('registrasis', 'registrasis.id', '=', 'perawatan_icd9s.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('perawatan_icd9s.created_at', [$tga, $tgb])
			->select(
				DB::raw("GROUP_CONCAT(pasiens.tgllahir SEPARATOR '||') as lahir"),
				'perawatan_icd9s.icd9'
			)
			->groupBy('perawatan_icd9s.icd9')->get();
		// return $data;die;
		return view('rawat-inap.lapRekammedis', $data)->with('no', 1);
	}

	public function lapPengunjung()
	{
		$data['kelas']		= Kelas::all();
		$data['kamar']		= Kamar::all();
		$data['carabayar']	= Carabayar::all();

		$data['tga']		= '';
		$data['tgb']		= '';
		$data['kls']		= 0;
		$data['crb']		= 0;
		$data['kmr']		= 0;
		$data['reg']		= Historipengunjung::where([['created_at', 'LIKE', date('Y-m-d') . '%'], ['politipe', '=', 'I']])->get();
		$data['mapping']	= Mastermappingbiaya::all();
		$data['rawatinap']	= [];
		$data['visite']		= [];
		return view('rawat-inap.lap_pengunjung', $data)->with('no', 1);
	}

	public function filterLapPengunjung(Request $req)
	{
		$req->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['kelas']		= Kelas::all();
		$data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga) . ' 00:00:00';
		$tgb				= valid_date($req->tgb) . ' 23:59:59';
		$data['kamar']		= Kamar::all();

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;
		$data['kls']		= $req->kelas;
		$data['crb']		= $req->cara_bayar;
		$data['kmr']		= $req->kamar;

		if ($req->cara_bayar == 5) {
			$data['rawatinap']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('folios', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('mastermapping_biaya', 'mastermapping_biaya.id', '=', 'folios.mapping_biaya_id')
				->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('perawatan_icd9s', 'perawatan_icd9s.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('icd9s', 'icd9s.nomor', '=', 'perawatan_icd9s.icd9')
				->where(['registrasis.bayar' => 5, 'folios.jenis' => 'TI'])
				->whereNotIn('folios.tarif_id', [10000, 0])
				->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
				// ->where('rawatinaps.kelas_id', ($req->kelas == 0) ? '>' : '=', $req->kelas)
				// ->where('rawatinaps.kamar_id', ($req->kamar == 0) ? '>' : '=', $req->kamar)
				->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
				->select('registrasis.created_at', 'pasiens.nama', 'pasiens.no_rm', 'tarifs.total as tarif', 'mastermapping_biaya.kelompok', 'icd9s.nama as icd9s', 'folios.namatarif', 'folios.total', 'folios.dokter_id', 'rawatinaps.kamar_id', 'rawatinaps.tgl_masuk', 'rawatinaps.tgl_keluar', 'registrasis.bayar as carabayar_id')->get();
			// return $data['rawatinap'];die;
		} else {
			$data['rawatinap']	= Rawatinap::join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->where('rawatinaps.carabayar_id', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
				// ->where('rawatinaps.kelas_id', ($req->kelas == 0) ? '>' : '=', $req->kelas)
				// ->where('rawatinaps.kamar_id', ($req->kamar == 0) ? '>' : '=', $req->kamar)
				->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
				->select('rawatinaps.id', 'rawatinaps.tgl_masuk', 'rawatinaps.tgl_keluar', 'rawatinaps.carabayar_id', 'rawatinaps.registrasi_id', 'registrasis.pasien_id')->get();

			foreach ($data['rawatinap'] as $k => $v) {
				$data['rawatinap'][$k]['tindakan']	= Folio::where(['registrasi_id' => $v->registrasi_id, 'jenis' => 'TI'])
					->where('tarif_id', '!=', 10000)->selectRaw('SUM(total) as jumlah, mapping_biaya_id as mapping')
					->groupBy('mapping_biaya_id')->get();
				$data['rawatinap'][$k]['kamar']		= HistoriRawatInap::join('kamars', 'histori_rawatinap.kamar_id', '=', 'kamars.id')
					->where('histori_rawatinap.rawatinap_id', $v->id)->select('kamars.nama')->get();
				$data['rawatinap'][$k]['total'] 	= Folio::where(['registrasi_id' => $v->registrasi_id, 'jenis' => 'TI'])
					->where('tarif_id', '!=', 10000)->sum('total');
			}

			$data['visite']		= Rawatinap::join('folios', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where(['folios.mapping_biaya_id' => 16, 'folios.jenis' => 'TI'])
				->where('rawatinaps.carabayar_id', ($req->cara_bayar == 0) ? '>' : '=', $req->cara_bayar)
				// ->where('rawatinaps.kelas_id', ($req->kelas == 0) ? '>' : '=', $req->kelas)
				// ->where('rawatinaps.kamar_id', ($req->kamar == 0) ? '>' : '=', $req->kamar)
				->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])->groupBy('folios.dokter_id')
				->selectRaw('COUNT(folios.mapping_biaya_id) as visite, SUM(folios.total) as nominal, folios.dokter_id')->get();
		}

		if ($req->submit == 'TAMPILKAN') {
			return view('rawat-inap.lap_pengunjung', $data)->with('no', 1);
		} elseif ($req->submit == 'CETAK') {
			$no = 1;
			$pdf = PDF::loadView('rawat-inap.rekapLaporan', $data, compact('no'));
			$pdf->setPaper('A4', 'landscape');
			return view('rawat-inap.rekapLaporan', $data)->with('no', 1);
		} elseif ($req->submit == 'EXCEL') {
			if ($req->cara_bayar == 5) {
				$ranap = $data['rawatinap'];
				$tga = $req->tga;
				$tgb = $req->tgb;
				Excel::create('Laporan Pengunjung Rawat Inap', function ($excel) use ($ranap) {
					$excel->setTitle('Laporan Pengunjung Rawat Inap')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Pengunjung Rawat Inap');
					$excel->sheet('Laporan Pengunjung Rawat Inap', function ($sheet) use ($ranap) {
						$row = 1;
						$no = 1;
						$sheet->row($row++, ['No', 'Masuk', 'Keluar', 'No. RM', 'Nama', 'Bayar', 'Kamar', 'DIagnosa Pulang', 'Dokter', 'Tindakan', 'Qty', 'Tarif', 'Total']);
						foreach ($ranap as $rn) {
							$sheet->row($row++, [
								$no++,
								date('d-m-Y', strtotime($rn->tgl_masuk)),
								date('d-m-Y', strtotime($rn->tgl_keluar)),
								$rn->no_rm,
								$rn->nama,
								baca_carabayar($rn->carabayar_id),
								baca_kamar($rn->kamar_id),
								$rn->icd9s,
								baca_dokter($rn->dokter_id),
								$rn->namatarif,
								$rn->total / $rn->tarif,
								$rn->tarif,
								$rn->total,
							]);
						}
					});
				})->export('xlsx');
			} else {
				$ranap = $data['rawatinap'];
				$visite = $data['visite'];
				$tga = $req->tga;
				$tgb = $req->tgb;
				Excel::create('Laporan Pengunjung Rawat Inap', function ($excel) use ($ranap, $visite) {
					$excel->setTitle('Laporan Pengunjung Rawat Inap')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Pengunjung Rawat Inap');
					$excel->sheet('Laporan Pengunjung Rawat Inap', function ($sheet) use ($ranap, $visite) {
						$row = 3;
						$no = 1;
						$sheet->setMergeColumn(['columns' => array('A', 'B', 'C', 'D', 'E', 'F', 'G'), 'rows' => array([1, 2])]);
						$sheet->row(1, ['No', 'Masuk', 'Keluar', 'No. RM', 'Nama', 'Bayar', 'Kamar', 'Rekap Tindakan']);
						$sheet->mergeCells('H1:V1');
						$sheet->fromArray(['T. Inap', 'Lab', 'Rad', 'Operasi', 'B. Darah', 'PDL', 'Family Folder', 'O2', 'Diet', 'Fisio', 'EKG', 'Amblns', 'ADK', 'Visite', 'Total'], NULL, 'H2');
						$ceck = 0;
						$all = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
						foreach ($ranap as $rn) {
							$room = [];
							foreach ($rn->kamar as $k => $kmr) {
								$room[$k] = $kmr->nama;
							}
							$_dtl = [$no++, date('d-m-Y', strtotime($rn->tgl_masuk)), date('d-m-Y', strtotime($rn->tgl_keluar)), ($rn->pasien_id != '') ? $rn->pasien->no_rm : '', $rn->pasien->nama, baca_carabayar($rn->carabayar_id), implode(',', $room)];
							$z = 7;
							for ($i = 1; $i <= 16; $i++) {
								if ($i != 2 && $i != 1) {
									foreach ($rn->tindakan as $t) {
										if ($i == $t->mapping) {
											$_dtl[$z++] = $t->jumlah;
											$all[$i - 3] += $t->jumlah;
											$ceck = 1;
										}
									}
									if ($ceck == 0) {
										$_dtl[$z++] = 0;
									} else {
										$ceck = 0;
									}
								}
							}
							$_dtl[$z++] = $rn->total;
							$sheet->row($row++, $_dtl);
							$all[14] += $rn->total;
						}
						$sheet->mergeCells('A' . $row . ':G' . $row);
						$sheet->row($row, ['Total']);
						$sheet->data = [];
						$sheet->fromArray($all, NULL, 'H' . $row, true);
						$row++;
						$row++;
						$sheet->mergeCells('A' . $row . ':D' . $row);
						$sheet->row($row++, ['Data Visite Dokter']);
						$sheet->row($row++, ['No', 'Dokter', 'Visite', 'Total']);
						$_no = 1;
						foreach ($visite as $v) {
							$sheet->row($row++, [
								$_no++,
								baca_dokter($v->dokter_id),
								$v->visite,
								$v->nominal
							]);
						}
					});
				})->export('xlsx');
			}
		}
	}
	public function sensus_harian()
	{
		return view('rawat-inap.sensus_harian');
	}

	public function informasi_rawat()
	{
		return view('rawat-inap.informasi-rawat');
	}

	public function dataRawatInap(Request $request)
	{
		DB::statement(DB::raw('set @nomorbaris=0'));
		if ($request->tga && $request->tgb) {
			$tga = date('Y-m-d', strtotime($request->tga));
			$tgb = date('Y-m-d', strtotime($request->tgb));
		} else {
			$tga = date('Y-m-d');
			$tgb = date('Y-m-d');
		}

		$irna = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->select([
				'registrasis.id as reg_id', 'pasien_id', 'jenis_pasien', 'status', 'rujukan', 'status_reg', 'registrasis.dokter_id', 'registrasis.poli_id',
				'registrasis.tipe_layanan', 'registrasis.bayar', 'registrasis.tipe_jkn', 'rawatinaps.created_at', 'rawatinaps.*'
			])
			->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59']);

		if ($request->status == "dipulangkan") {
			$irna = $irna->where('registrasis.status_reg', 'I3')->get();
		} else {
			$irna = $irna->where('registrasis.status_reg', 'I2')->get();
		}
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
			->addColumn('rb', function ($irna) {

				return '<button type="button" onclick="rincianBiaya(' . $irna->reg_id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-search"></i></button>';
			})
			->addColumn('view', function ($irna) {
				return '<button type="button" onclick="viewDetail(' . $irna->reg_id . ')" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open"></i></button>';
			})
			->rawColumns(['rb', 'view'])
			->make(true);
	}






	public function updateKeterangan($id, Request $request)
	{
		$set = Rawatinap::find($id);
		$set->keterangan = $request->data;
		$set->update();

		return response()->json($set);
	}






	public function detailDataRawatInap($registrasi_id)
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
		$data['id'] = $ranap->id;
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

	// ===========================================================================
	public function getTarif($kategoritarif_id = '', $reg_id = '')
	{
		$tarif = Tarif::where('jenis', 'TI')->where('kategoritarif_id', $kategoritarif_id)->get(['id', 'nama', 'total']);
		return response()->json($tarif);
	}
	public function getKamar($kelas_id)
	{
		$kamar = Kamar::where('kelas_id', $kelas_id)->pluck('nama', 'id');
		return json_encode($kamar);
	}

	public function getBed($kelompokkelas_id, $kelas_id, $kamar_id)
	{
		$bed = Bed::where('kelompokkelas_id', $kelompokkelas_id)->where('kelas_id', $kelas_id)->where('kamar_id', $kamar_id)->where('reserved', 'N')->pluck('nama', 'id');
		return response()->json($bed);
	}

	public function getdatareg($registrasi_id = '')
	{
		$data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->join('carabayars', 'registrasis.bayar', '=', 'carabayars.id')
			->select('registrasis.id', 'carabayars.carabayar as pembayaran', 'registrasis.bayar', 'registrasis.no_jkn', 'registrasis.tipe_jkn', 'pasiens.no_rm', 'pasiens.nama')
			->where('registrasis.id', $registrasi_id)
			->first();
		return response()->json($data);
	}

	public function lapirnagetkamar($kelas_id = '')
	{

		if (!empty($kelas_id)) {
			$kamar = Kamar::where('kelas_id', $kelas_id)->pluck('nama', 'id');
		} else {
			$kamar = Kamar::pluck('nama', 'id');
		}
		return json_encode($kamar);
	}

	public function rincianBiaya($registrasi_id)
	{
		// dd($registrasi_id);
		$tagihan = Folio::where('registrasi_id', $registrasi_id)
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		return response()->json($tagihan);
	}

	public function rincianBiayaBaru($registrasi_id)
	{
		// dd($registrasi_id);
		$tagihan = Folio::where('registrasi_id', $registrasi_id)
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		$reg = Registrasi::find($registrasi_id);
		$namaPasien = $reg->pasien->nama;
		$noRM = $reg->pasien->no_rm;

		return response()->json([
			'tagihan' => $tagihan,
			'namaPasien' => $namaPasien,
			'noRM' => $noRM,
		]);
	}

	// public function rincianBiayaRs($registrasi_id) {
	// 	$tagihan = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')
	// 		->select('registrasi_id', 'namatarif','created_at', 'total', 'jenis')
	// 		->get();
	// 	// dd($tagihan);
	// 	return response()->json($tagihan);
	// }
	public function rincianBiayaRs($id = '')
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		// dd($id);
		$data['reg'] = Registrasi::find($id);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// dd($data['tagihan']);
		// $data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis','ORJ')->sum(\DB::raw('total'));
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->get();
		$data['folio'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['G', 'J', 'O', 'M', 'A', 'I', 'Z', 'A', 'B', 'V', 'H', 'D'])
			->selectRaw('sum(total) AS total,poli_tipe ,registrasi_id,namatarif,created_at,jenis,tarif_id,dokter_pelaksana,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		// dd($data['folio']);
		// dd($data['folio_igd']);

		$data['folio_null_tipe'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->whereNull('poli_tipe')
			->selectRaw('sum(total) AS total,poli_tipe ,registrasi_id,namatarif,created_at,jenis,tarif_id,dokter_pelaksana,verif_kasa_user')
			// ->select('registrasi_id', 'namatarif','created_at', 'total', 'jenis','tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		// $data['lab'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','L')
		// 	->sum(\DB::raw('total'));
		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->get();

		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		$data['rad'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'R')
			->get();
		// dd($data['folio_obat']);
		// $pdf        = PDF::loadView('rawat-inap.rincianBiaya', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();

		return view('rawat-inap.rincianBiaya', $data);
	}

	public function rincianBiayaUnit($id = '')
	{
		// dd($id);
		$data['reg'] = Registrasi::find($id);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// OTOMATIS SINKRON
		// $data['sinkron_obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
		// foreach ($data['sinkron_obat'] as $so) {
		// 	$sink = Penjualan::with('penjualandetail')->where('no_resep', $so->namatarif)->first()->penjualandetail->sum('hargajual');
		// 	// dd($sink);
		// 	if ($so->total !== $sink) {
		// 		if ($sink !== '0') {
		// 			DB::table('folios')->whereNull('deleted_at')
		// 				->where('registrasi_id', $id)
		// 				->where('namatarif', $so->namatarif)
		// 				->update(['total' => $sink]);
		// 		}
		// 	}
		// }
		// dd($data['tagihan']);
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		$data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('jenis', 'ORJ')->groupBy('gudang_id')
			->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
			->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->whereIn('jenis', ['TG', 'TI'])
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['obat_gudang_igd_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');

		// if($data['obat_gudang_igd'] == 0){
		// 	$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');
		// }

		// $data['obat_gudang_igd'] = +$data['obat_gudang_igd_null'];

		// OBAT RAJAL
		// $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
		// ->with('gudang')
		// ->where('gudang_id','9') //rajal
		// ->where('jenis','ORJ')
		// ->sum('total');
		// if($data['obat_gudang_rajal'] == 0){
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('namatarif', 'like', 'FRJ' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');
		// }
		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('namatarif', 'like', 'FRI' . '%')
			->whereIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRI' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
		}
		// dd($data['obat_gudang_operasi']);

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id ,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			$data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}
		//END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		// dd($data['obat_gudang_inap']);



		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');
		// dd($data['total_ranap']);

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}
		// END POLI_TIPE YANG NULL

		// dd($data['folio_null_tipe']);

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();
		// dd($data['kamar']);

		// dd($data['folio_null_tipe']);


		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));


		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		// dd($data['folio_obat']);
		$total_biaya = Folio::where('registrasi_id', $id)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
		$jasa_racik = Folio::where('registrasi_id', $id)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
		$data['total_biaya'] = $total_biaya + $jasa_racik;
		// $pdf        = PDF::loadView('rawat-inap.rincianBiayaUnit', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();
		// dd('tset');
		return view('rawat-inap.rincianBiayaUnit', $data);
	}
	public function rincianBiayaUnitTanpaRajal($id = '')
	{
		// dd($id);
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		$data['reg'] = Registrasi::find($id);
		// dd($data['reg']);
		// $data['tagihan'] = Folio::where('registrasi_id', $id)
		// 	->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
		// 	->get();
		$data['sinkron_obat'] = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();

		foreach ($data['sinkron_obat'] as $so) {
			$sink = DB::table('penjualandetails')->where('no_resep', $so->namatarif)->sum('hargajual');
			// dd($sink);
			if ($so->total !== $sink) {
				if ($sink !== '0') {
					$fol = Folio::where('namatarif', $so->namatarif)->where('registrasi_id', $id)->first();
					$fol->total = $sink;
					$fol->save();
				}

				// 	}
				// }
			}
		}
		// dd($data['tagihan']);
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		$data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('jenis', 'ORJ')->groupBy('gudang_id')
			->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
			->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->selectRaw('sum(total) AS total,cyto,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_pelaksana')
			->get();
		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->whereIn('jenis', ['TG', 'TI'])
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			->selectRaw('sum(total) AS total,cyto,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_pelaksana')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('gudang_id', '!=', '2')
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['obat_gudang_igd_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');

		// if($data['obat_gudang_igd'] == 0){
		// 	$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');
		// }

		// $data['obat_gudang_igd'] = +$data['obat_gudang_igd_null'];

		// OBAT RAJAL
		// $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
		// ->with('gudang')
		// ->where('gudang_id','9') //rajal
		// ->where('jenis','ORJ')
		// ->sum('total');
		// if($data['obat_gudang_rajal'] == 0){
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('namatarif', 'like', 'FRJ' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');
		// }
		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,cyto,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id, user_id, dokter_bedah,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRI' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
		}
		// dd($data['obat_gudang_operasi']);

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,cyto,poli_tipe,kamar_id,dokter_id ,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id', 'dokter_pelaksana')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			// digunakan jika ada data penggunaan obat dibawah 9 juni
			// $data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}

		// $data['obat_gudang_inap'] = $data['obat_gudang_inap']+$data['obat_gudang_rajal'];

		//END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		// dd($data['obat_gudang_inap']);



		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,cyto,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');
		// dd($data['total_ranap']);

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}
		// END POLI_TIPE YANG NULL

		// dd($data['folio_null_tipe']);

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();
		// dd($data['kamar']);

		// dd($data['folio_null_tipe']);


		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TG')
			->where('folios.poli_tipe', 'L')
			->sum(\DB::raw('folios.total'));
		// $data['lab_inap'] = Folio::where('registrasi_id', $id)
		// 	->where('jenis', 'TI')
		// 	->where('poli_tipe', 'L')
		// 	->where('namatarif', 'NOT LIKE', ['%PRC%', '%CROSSMATCH%','TC'])
		// 	->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->sum(\DB::raw('folios.total'));

		$data['lab_inap_patologi'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', 43)
			->sum(\DB::raw('folios.total'));
		// $data['bank_darah'] = Folio::where('registrasi_id', $id)
		// 	// ->where('jenis', 'TI')
		// 	->where('poli_tipe', 'L')
		// 	->where('poli_id', '!=', 43)
		// 	->where('namatarif', 'LIKE', ['%PRC%', '%CROSSMATCH%'])
		// 	->sum(\DB::raw('total'));
		$data['bank_darah'] = Folio::where('folios.registrasi_id', $id)
			->with('tarif')
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->where('tarifs.keterangan', 'BD')
			->sum(\DB::raw('folios.total'));
		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TA')
			->where('folios.poli_tipe', 'L')
			->sum(\DB::raw('folios.total'));
		// $data['lab_inap'] = $data['lab_inap']+$data['lab_irj'];

		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		if ($data['rad_igd'] > 0) {
			$data['dokter_rad_igd'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TG')
				->where('poli_tipe', 'R')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		if ($data['rad_inap'] > 0) {
			$data['dokter_rad_inap'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TI')
				->where('poli_tipe', 'R')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));

		// $data['rad_inap'] = $data['rad_inap']+$data['rad_irj'];
		$data['rad_inap'] = $data['rad_inap'];
		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		// dd($data['folio_obat']);
		$total_biaya = Folio::where('registrasi_id', $id)->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
		$jasa_racik = Folio::where('registrasi_id', $id)->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
		$data['total_biaya'] = $total_biaya + $jasa_racik;
		// $pdf        = PDF::loadView('rawat-inap.rincianBiayaUnitTanpaRajal', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();
		// dd('test');
		return view('rawat-inap.rincianBiayaUnitTanpaRajal', $data);
	}

	public function rincianBiayaUnitTanpaIgd($id = '')
	{
		// dd($id);
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		$data['reg'] = Registrasi::find($id);
		// dd($data['reg']);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// $data['sinkron_obat'] = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();

		// foreach ($data['sinkron_obat'] as $so) {
		// 	$sink = DB::table('penjualandetails')->where('no_resep', $so->namatarif)->sum('hargajual');
		// 	// dd($sink);
		// 	if ($so->total !== $sink) {
		// 		if ($sink !== '0') {
		// 			$fol = Folio::where('namatarif', $so->namatarif)->where('registrasi_id', $id)->first();
		// 			$fol->total = $sink;
		// 			$fol->save();
		// 		}

		// 		// 	}
		// 		// }
		// 	}
		// }
		// dd($data['tagihan']);
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		$data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('jenis', 'ORJ')->groupBy('gudang_id')
			->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
			->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->selectRaw('sum(total) AS total,cyto,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_pelaksana')
			->get();
		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->whereIn('jenis', ['TG', 'TI'])
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			->selectRaw('sum(total) AS total,cyto,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_pelaksana')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('gudang_id', '!=', '2')
			->where('jenis', 'ORJ')
			->sum('total');

		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('namatarif', 'like', 'FRJ' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');




		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,cyto,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id, user_id, dokter_bedah,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRI' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
		}
		// dd($data['obat_gudang_operasi']);

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,cyto,poli_tipe,kamar_id,dokter_id ,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id', 'dokter_pelaksana')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			// digunakan jika ada data penggunaan obat dibawah 9 juni
			// $data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}

		// $data['obat_gudang_inap'] = $data['obat_gudang_inap']+$data['obat_gudang_rajal'];

		//END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		// dd($data['obat_gudang_inap']);



		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,cyto,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');
		// dd($data['total_ranap']);

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}
		// END POLI_TIPE YANG NULL

		// dd($data['folio_null_tipe']);

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();
		// dd($data['kamar']);

		// dd($data['folio_null_tipe']);


		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->where('poli_id', '!=', 43)
			->where('namatarif', 'NOT LIKE', ['%PRC%', '%CROSSMATCH%'])
			->sum(\DB::raw('total'));
		$data['lab_inap_patologi'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->where('poli_id', 43)
			->sum(\DB::raw('total'));
		$data['bank_darah'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->where('namatarif', 'LIKE', ['%PRC%', '%CROSSMATCH%'])
			->sum(\DB::raw('total'));
		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		// $data['lab_inap'] = $data['lab_inap']+$data['lab_irj'];

		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		if ($data['rad_igd'] > 0) {
			$data['dokter_rad_igd'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TG')
				->where('poli_tipe', 'R')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		if ($data['rad_inap'] > 0) {
			$data['dokter_rad_inap'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TI')
				->where('poli_tipe', 'R')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		if ($data['rad_irj'] > 0) {
			$data['dokter_rad_rajal'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TA')
				->where('poli_tipe', 'R')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}
		// $data['rad_inap'] = $data['rad_inap']+$data['rad_irj'];
		$data['rad_inap'] = $data['rad_inap'];
		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		// dd($data['folio_obat']);
		$total_biaya = Folio::where('registrasi_id', $id)->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
		$jasa_racik = Folio::where('registrasi_id', $id)->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
		$data['total_biaya'] = $total_biaya + $jasa_racik;
		// $pdf        = PDF::loadView('rawat-inap.rincianBiayaUnitTanpaRajal', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();
		// dd('test');
		return view('rawat-inap.rincianBiayaUnitTanpaIgd', $data);
	}

	public function sinkronRbTagihan($id)
	{

		$data['sinkron_obat'] = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
		// dd($data['sinkron_obat']);
		$aa = [];
		foreach ($data['sinkron_obat'] as $so) {
			$sink = DB::table('penjualandetails')->where('no_resep', $so->namatarif)->sum('hargajual');
			// dd($sink);
			// if($so->total !== $sink){
			// 	if($sink !== '0'){
			$fol = Folio::where('namatarif', $so->namatarif)->where('registrasi_id', $id)->first();
			$fol->total = $sink;
			$fol->save();
			// 		DB::table('folios')->whereNull('deleted_at')
			// 			->where('namatarif', $so->namatarif)
			// 			->update(['total' => $sink]);
			// 	}

			// }
		}
		dd("OK");
	}
	public function rincianBiayaUnitItemTanpaRajal($id = '')
	{
		// dd($id);
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		$data['reg'] = Registrasi::find($id);
		// dd($data['reg']);
		// $data['tagihan'] = Folio::where('registrasi_id', $id)
		// 	->select('registrasi_id', 'namatarif','created_at', 'total', 'jenis')
		// 	->get();
		// OTOMATIS SINKRON
		// $data['sinkron_obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis','ORJ')->select('namatarif','total')->get();
		// $data['sinkron_obat'] = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id',$id)->where('jenis','ORJ')->select('namatarif','total')->get();

		// foreach($data['sinkron_obat'] as $so){
		// 	$sink = DB::table('penjualandetails')->where('no_resep',$so->namatarif)->sum('hargajual');
		// 	// dd($sink);
		// 	if($so->total !== $sink){
		// 		if($sink !== '0'){
		// 			$fol = Folio::where('namatarif', $so->namatarif)->where('registrasi_id',$id)->first();
		// 			$fol->total = $sink;
		// 			$fol->save();
		// 		}

		// 	}
		// }
		// dd($data['sinkron_obat']);
		// dd($data['tagihan']);
		// $data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		// $data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
		// 	->with('gudang')
		// 	->where('jenis', 'ORJ')->groupBy('gudang_id')
		// 	->where('namatarif', 'not like', 'PO' . '%')
		// 	->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
		// 	->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->where('namatarif', 'not like', 'PO' . '%')
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_pelaksana')
			->get();
		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->whereIn('jenis', ['TG', 'TI'])
			->where('poli_tipe', 'G')
			->whereRaw('LOWER(namatarif) NOT LIKE ?', ['%ambulan%'])
			->where('namatarif', 'not like', 'PO' . '%')
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'dokter_pelaksana')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('namatarif', 'not like', 'PO' . '%')
			->where('jenis', 'ORJ')
			->sum('total');
		$data['detail_obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('namatarif', 'not like', 'PO' . '%') //IGD
			->where('jenis', 'ORJ')
			->select('namatarif', 'total')
			->get();
		// $data['detail_obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id) 
		// 	->where('namatarif', 'like', 'FRD' . '%') //IGD
		// 	->where('namatarif', 'not like', 'PO' . '%') //IGD
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});

		// dd($data['detail_obat_gudang_igd']);
		// $data['obat_gudang_igd_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');

		// if($data['obat_gudang_igd'] == 0){
		// 	$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');
		// }

		// $data['obat_gudang_igd'] = +$data['obat_gudang_igd_null'];

		// OBAT RAJAL
		// $data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
		// ->with('gudang')
		// ->where('gudang_id','9') //rajal
		// ->where('jenis','ORJ')
		// ->sum('total');
		// if($data['obat_gudang_rajal'] == 0){
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('namatarif', 'like', 'FRJ' . '%') //
			->where('namatarif', 'not like', 'PO' . '%')
			->where('jenis', 'ORJ')
			->sum('total');
		// }
		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->where('namatarif', 'not like', 'PO' . '%')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,perawat_ibs1,cyto,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('namatarif', 'not like', 'PO' . '%')
			->where('jenis', 'ORJ')
			->sum('total');
		$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('gudang_id', '2') //OPERASI
			->where('namatarif', 'not like', 'PO' . '%')
			->where('jenis', 'ORJ')
			->select('namatarif', 'total', 'user_id')
			->get();
		// dd("A");
		// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id', '2') //OPERASI
		// 	->where('namatarif', 'not like', 'PO' . '%')
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total', 'user_id')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRI' . '%')
				->where('namatarif', 'not like', 'PO' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
			// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('gudang_id', NULL)
			// 	->where('namatarif', 'like', 'FRI' . '%')
			// 	->where('namatarif', 'not like', 'PO' . '%')
			// 	->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total', 'user_id')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRI' . '%')
				->where('namatarif', 'not like', 'PO' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->select('namatarif', 'total', 'user_id')
				->get();
		}
		// dd($data['obat_gudang_operasi']);

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->whereRaw('LOWER(namatarif) NOT LIKE ?', ['%ambulan%'])
			->where('namatarif', 'not like', 'PO' . '%')
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id,cyto ,dokter_pelaksana,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id', 'dokter_pelaksana')
			->whereNull('deleted_at')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('namatarif', 'not like', 'PO' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['detail_obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('namatarif', 'like', 'FRI' . '%')
		// 	->where('namatarif', 'not like', 'PO' . '%')
		// 	->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('namatarif', 'like', 'FRI' . '%')
			->where('namatarif', 'not like', 'PO' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->select('namatarif', 'total')
			->get();
		// dd($data['detail_obat_gudang_inap']);
		// dd("A");


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('namatarif', 'not like', 'PO' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');
		// $data['detail_obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('namatarif', 'like', 'FRI' . '%')
		// 	->where('namatarif', 'not like', 'PO' . '%')
		// 	->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
		// 	->where('gudang_id', NULL)
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('namatarif', 'like', 'FRI' . '%')
			->where('namatarif', 'not like', 'PO' . '%')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->where('jenis', 'ORJ')
			->select('namatarif', 'total')
			->get();
		// dd($data['detail_obat_gudang_inap_null']);

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('namatarif', 'not like', 'PO' . '%')
				->where('gudang_id', NULL)
				->sum('total');

			$data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}

		// $data['obat_gudang_inap'] = $data['obat_gudang_inap']+$data['obat_gudang_rajal'];

		//END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		// dd($data['obat_gudang_inap']);



		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('namatarif', 'not like', 'PO' . '%')
			->where('poli_tipe', null)
			->whereRaw('LOWER(namatarif) NOT LIKE ?', ['%ambulan%'])
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');
		// dd($data['total_ranap']);

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}
		// END POLI_TIPE YANG NULL

		// dd($data['folio_null_tipe']);

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();
		// dd($data['kamar']);

		// dd($data['folio_null_tipe']);


		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TG')
			->where('folios.namatarif', 'not like', 'PO' . '%')
			->where('folios.poli_tipe', 'L')
			->sum(\DB::raw('folios.total'));
		// $data['lab_inap'] = Folio::where('folios.registrasi_id', $id)
		// 	->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
		// 	->where('folios.jenis', 'TI')
		// 	->where('folios.namatarif', 'not like', 'PO' . '%')
		// 	->where('folios.poli_tipe', 'L')
		// 	->where('folios.poli_id', '!=', 43)
		// 	->where('tarifs.keterangan', '!=', 'BD')
		// 	->sum(\DB::raw('folios.total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->sum(\DB::raw('folios.total'));
		$data['bank_darah_inap'] = Folio::where('folios.registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->where('tarifs.keterangan', 'BD')
			->sum(\DB::raw('folios.total'));
		$data['tindakan_bank_darah_all'] = Folio::where('folios.registrasi_id', $id)
			->with('tarif')
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			// ->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->where('tarifs.keterangan', 'BD')
			->groupBy('folios.namatarif')
			->selectRaw('sum(folios.total) AS total,folios.tarif_id,folios.namatarif,verif_kasa_user')
			->get();

		$data['lab_inap_patologi'] = Folio::where('registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', 43)
			->sum(\DB::raw('folios.total'));
		$data['tindakan_lab_inap_patologi'] = Folio::where('folios.registrasi_id', $id)
			->with('tarif')
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('folios.jenis', 'TI')
			->where('folios.poli_tipe', 'L')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.poli_id', 43)
			->groupBy('folios.tarif_id')
			->selectRaw('sum(folios.total) AS total,folios.tarif_id,folios.namatarif,verif_kasa_user')
			->get();

		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->where('folios.jenis', 'TA')
			->where('folios.namatarif', 'not like', 'PO' . '%')
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('tarifs.keterangan', '!=', 'BD')
			->where('folios.poli_tipe', 'L')
			->sum(\DB::raw('folios.total'));
		// $data['lab_inap'] = $data['lab_inap']+$data['lab_irj'];

		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->where('namatarif', 'not like', 'PO' . '%')
			->sum(\DB::raw('total'));
		if ($data['rad_igd'] > 0) {
			$data['dokter_rad_igd'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TG')
				->where('poli_tipe', 'R')
				->where('namatarif', 'not like', 'PO' . '%')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->where('namatarif', 'not like', 'PO' . '%')
			->sum(\DB::raw('total'));
		if ($data['rad_inap'] > 0) {
			$data['dokter_rad_inap'] = Folio::where('registrasi_id', $id)
				->where('jenis', 'TI')
				->where('namatarif', 'not like', 'PO' . '%')
				->where('poli_tipe', 'R')
				->groupBy('dokter_radiologi')
				->select('dokter_radiologi')->get();
		}

		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('namatarif', 'not like', 'PO' . '%')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));

		// $data['rad_inap'] = $data['rad_inap']+$data['rad_irj'];
		$data['rad_inap'] = $data['rad_inap'];
		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		// dd($data['folio_obat']);
		$total_biaya = Folio::where('registrasi_id', $id)->where('namatarif', 'not like', 'PO' . '%')->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
		// $jasa_racik = Folio::where('registrasi_id', $id)->where('namatarif', 'not like', 'PO' . '%')->where('jenis', '!=', 'TA')->where('namatarif', 'not like', '%' . 'FRJ' . '%')->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
		$jasa_racik = 0;
		$data['total_biaya'] = $total_biaya + $jasa_racik;
		// $pdf        = PDF::loadView('rawat-inap.rincianBiayaUnitItemTanpaRajal', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();
		return view('rawat-inap.rincianBiayaUnitItemTanpaRajal', $data);
	}
	public function rincianBiayaUnitItemTanpaKronis($id = '')
	{
		// dd($id);
		$data['reg'] = Registrasi::find($id);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->where('cara_bayar_id', '!=', '2')
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// OTOMATIS SINKRON
		// $data['sinkron_obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
		// foreach ($data['sinkron_obat'] as $so) {
		// 	$sink = Penjualan::with('penjualandetail')->where('no_resep', $so->namatarif)->first()->penjualandetail->sum('hargajual');
		// 	// dd($sink);
		// 	if ($so->total !== $sink) {
		// 		if ($sink !== '0') {
		// 			DB::table('folios')->whereNull('deleted_at')
		// 				->where('registrasi_id', $id)
		// 				->where('namatarif', $so->namatarif)
		// 				->update(['total' => $sink]);
		// 		}
		// 	}
		// }
		// dd("A");
		// dd($data['tagihan']);
		// $data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// // dd($data['obat']);
		// $data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
		// 	->with('gudang')
		// 	->where('jenis', 'ORJ')->groupBy('gudang_id')
		// 	->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
		// 	->get();

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
		// dd($data['folio_rajal']);
		// dd("A");
		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->whereIn('jenis', ['TG', 'TI'])
			->where('poli_tipe', 'G')
			->whereRaw('LOWER(namatarif) NOT LIKE ?', ['%ambulan%'])
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['obat_gudang_igd_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');

		// if($data['obat_gudang_igd'] == 0){
		// 	$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');
		// }

		// $data['obat_gudang_igd'] = +$data['obat_gudang_igd_null'];

		// OBAT RAJAL
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('user_id', '!=', 610)
			->where('gudang_id', '9') //rajal
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_rajal'] == 0) {
			$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->sum('total');
			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->where('user_id', '!=', 610)
			// 	->select('namatarif', 'total')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});

			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with(['obat' => function ($query) {
					$query->where('is_kronis', 'N');
				}])
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->select('namatarif', 'total')
				->get();
		} else {

			$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->sum('total');

			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->where('user_id', '!=', 610)
			// 	->select('namatarif', 'total')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with(['obat' => function ($query) {
					$query->where('is_kronis', 'N');
				}])
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '=', 2) //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->where('user_id', '!=', 610)
				->select('namatarif', 'total')
				->get();
		}
		// dd("A");
		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRJ' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
			->where('gudang_id', NULL)
			->sum('total');
		// $data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('namatarif', 'like', 'FRJ' . '%')
		// 	->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
		// 	->where('gudang_id', NULL)
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			->with(['obat' => function ($query) {
				$query->where('is_kronis', 'N');
			}])
			->where('namatarif', 'like', 'FRJ' . '%')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802, 610])
			->where('gudang_id', NULL)
			->where('jenis', 'ORJ')
			->select('namatarif', 'total')
			->get();

		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id', '2') //OPERASI
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total', 'user_id')
		// 	->get()
		// 	->map(function ($obat) {
		// 		return (object) [
		// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
		// 			"namatarif" => $obat->namatarif,
		// 			"total" => $obat->total,
		// 		];
		// 	});
		$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with(['obat' => function ($query) {
				$query->where('is_kronis', 'N');
			}])
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->select('namatarif', 'total', 'user_id')
			->get();
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
			// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			// 	->where('gudang_id', NULL)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total', 'user_id')
			// 	->get()
			// 	->map(function ($obat) {
			// 		return (object) [
			// 			"obat" => $obat->obat()->where('is_kronis', 'N')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'))->get(),
			// 			"namatarif" => $obat->namatarif,
			// 			"total" => $obat->total,
			// 		];
			// 	});
			$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->with(['obat' => function ($query) {
					$query->where('is_kronis', 'N');
				}])
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->select('namatarif', 'total', 'user_id')
				->get();
		}
		// dd($data['obat_gudang_operasi']);

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id ,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			$data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}
		//END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		// dd($data['obat_gudang_inap']);



		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('cara_bayar_id', '!=', '2')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');
		// dd($data['total_ranap']);

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}
		// END POLI_TIPE YANG NULL

		// dd($data['folio_null_tipe']);

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();
		// dd($data['kamar']);

		// dd($data['folio_null_tipe']);


		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->where('cara_bayar_id', '!=', '2')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_irj'] = Folio::where('folios.registrasi_id', $id)
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('folios.jenis', 'TA')
			->where('folios.namatarif', 'not like', 'PO' . '%')
			->where('folios.poli_tipe', 'L')
			->where('folios.poli_id', '!=', 43)
			->where('tarifs.keterangan', '!=', 'BD')
			->sum(\DB::raw('folios.total'));
		$data['tindakan_bank_darah_irj'] = Folio::where('folios.registrasi_id', $id)
			->with('tarif')
			->leftJoin('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('folios.jenis', 'TA')
			->where('folios.poli_id', '!=', 43)
			->where('tarifs.keterangan', 'BD')
			->groupBy('folios.tarif_id')
			->selectRaw('sum(folios.total) AS total,folios.tarif_id,folios.namatarif,verif_kasa_user')
			->get();


		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('cara_bayar_id', '!=', '2')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		// dd($data['folio_obat']);
		$total_biaya = Folio::where('registrasi_id', $id)->where('cara_bayar_id', '!=', '2')->where('user_id', '!=', 610)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
		// $jasa_racik = Folio::where('registrasi_id', $id)->where('cara_bayar_id', '!=', '2')->where('user_id', '!=', 610)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
		$jasa_racik = 0;
		$data['total_biaya'] = $total_biaya + $jasa_racik;
		// $pdf        = PDF::loadView('rawat-inap.rincianBiayaUnit', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();

		return view('rawat-inap.rincianBiayaUnitItemTanpaKronis', $data);
	}

	public function rincianBiayaUnitItem($id = '')
	{
		// dd($id);
		$data['reg'] = Registrasi::find($id);
		$data['tagihan'] = Folio::where('registrasi_id', $id)
			->select('registrasi_id', 'namatarif', 'created_at', 'total', 'jenis')
			->get();
		// dd($data['tagihan']);
		$data['obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->sum(\DB::raw('total + jasa_racik'));
		// dd($data['obat']);
		// OTOMATIS SINKRON
		// $data['sinkron_obat'] = Folio::where('registrasi_id', '=', $id)->where('jenis', 'ORJ')->select('namatarif', 'total')->get();
		// foreach ($data['sinkron_obat'] as $so) {
		// 	$sink = Penjualan::with('penjualandetail')->where('no_resep', $so->namatarif)->first()->penjualandetail->sum('hargajual');
		// 	// dd($sink);
		// 	if ($so->total !== $sink) {
		// 		if ($sink !== '0') {
		// 			DB::table('folios')->whereNull('deleted_at')
		// 				->where('registrasi_id', $id)
		// 				->where('namatarif', $so->namatarif)
		// 				->update(['total' => $sink]);
		// 		}
		// 	}
		// }
		$data['obat_gudang'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('jenis', 'ORJ')->groupBy('gudang_id')
			->selectRaw('sum(total+jasa_racik) as sum, gudang_id')
			->get();

		$data['folio_rajal'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TA')
			->where(function ($query) {
				$query->whereIn('poli_tipe', ['J', 'M'])->orWhereNull('poli_tipe');
			})
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['folio_igd'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->whereIn('jenis', ['TG', 'TI'])
			->where('poli_tipe', 'G')
			->whereRaw('LOWER(namatarif) NOT LIKE ?', ['%ambulan%'])
			->selectRaw('sum(total) AS total,poli_tipe,dokter_id,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();
		$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRD' . '%') //IGD
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['obat_gudang_igd_null'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');

		// if($data['obat_gudang_igd'] == 0){
		// 	$data['obat_gudang_igd'] = Folio::where('registrasi_id', '=', $id)
		// 	->where('gudang_id',NULL)
		// 	->where('namatarif','like','FRD'.'%') //IGD
		// 	->where('jenis','ORJ')
		// 	->sum('total');
		// }

		// $data['obat_gudang_igd'] = +$data['obat_gudang_igd_null'];

		// OBAT RAJAL
		$data['obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '9') //rajal
			->where('jenis', 'ORJ')
			->sum('total');
		if ($data['obat_gudang_rajal'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->sum('total');
			// $data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
			// 	->with([
			// 		'obat' => function ($query) {
			// 			$query->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
			// 		},
			// 	])
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total')
			// 	->get();
			$data['detail_obat_gudang_rajal'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
				->where('jenis', 'ORJ')
				->select('namatarif', 'total')
				->get();


			// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
			$data['obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRJ' . '%')
				->where('jenis', 'ORJ')
				->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
				->where('gudang_id', NULL)
				->sum('total');
			// $data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
			// 	->with([
			// 		'obat' => function ($query) {
			// 			$query->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
			// 		},
			// 	])
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			// 	->where('gudang_id', NULL)
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total')
			// 	->get();
			$data['detail_obat_gudang_rajal_null'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
				->where('gudang_id', NULL)
				->where('jenis', 'ORJ')
				->select('namatarif', 'total')
				->get();
		}
		// dd($data['folio_rajal']);



		$data['operasi'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', '!=', 'ORJ')
			->whereIn('poli_tipe', ['O'])
			->selectRaw('sum(total) AS total,poli_tipe,registrasi_id,dokter_anestesi,dpjp,dokter_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id')
			->get();

		$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('gudang')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->sum('total');
		// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
		// 	->with([
		// 		'obat' => function ($query) {
		// 			$query->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
		// 		},
		// 	])
		// 	->where('gudang_id', '2') //OPERASI
		// 	->where('jenis', 'ORJ')
		// 	->select('namatarif', 'total', 'user_id')
		// 	->get();
		$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			->with('obat')
			->where('gudang_id', '2') //OPERASI
			->where('jenis', 'ORJ')
			->select('namatarif', 'total', 'user_id')
			->get();
		if ($data['obat_gudang_operasi'] == 0) {

			$data['obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->sum('total');
			// $data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
			// 	->with([
			// 		'obat' => function ($query) {
			// 			$query->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
			// 		},
			// 	])
			// 	->where('gudang_id', NULL)
			// 	->where('namatarif', 'like', 'FRJ' . '%')
			// 	->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
			// 	->where('jenis', 'ORJ')
			// 	->select('namatarif', 'total', 'user_id')
			// 	->get();
			$data['detail_obat_gudang_operasi'] = Folio::where('registrasi_id', '=', $id)
				->with('obat')
				->where('gudang_id', NULL)
				->where('namatarif', 'like', 'FRJ' . '%')
				->whereIn('user_id', [614, 613, 671, 800, 801, 802]) //farmasi operasi
				->where('jenis', 'ORJ')
				->select('namatarif', 'total', 'user_id')
				->get();
		}
		// dd($data['obat_gudang_operasi']);

		// POLI_TIPE YANG NULL
		$data_folio_irna = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,dokter_id ,registrasi_id,namatarif,created_at,jenis,tarif_id,verif_kasa_user')
			->orderBy('namatarif', 'ASC')
			->groupBy('tarif_id', 'kamar_id')
			->get();

		$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('gudang_id', '!=', '2') //SELECT SELAIN GUDANG ID 2 , YAITU GUDANG OPERASI
			->where('jenis', 'ORJ')
			->sum('total');


		// OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		$data['obat_gudang_inap_null'] = Folio::where('registrasi_id', '=', $id)
			->where('namatarif', 'like', 'FRI' . '%')
			->where('jenis', 'ORJ')
			->whereNotIn('user_id', [614, 613, 671, 800, 801, 802])
			->where('gudang_id', NULL)
			->sum('total');

		// dd($data['obat_gudang_inap']);
		$data['obat_gudang_inap'] = $data['obat_gudang_inap'] + $data['obat_gudang_inap_null'];

		if ($data['obat_gudang_inap'] == 0) {
			$data['obat_gudang_inap'] = Folio::where('registrasi_id', '=', $id)
				->where('namatarif', 'like', 'FRI' . '%') //INAP
				->where('jenis', 'ORJ')
				->where('gudang_id', NULL)
				->sum('total');

			$data['obat_gudang_inap'] = @$data['obat_gudang_inap'] - @$data['obat_gudang_operasi'];
		}
		//END  OTOMATIS NONAKTIF JIKA GUDANG ID DI FOLIOS TERISI
		// dd($data['obat_gudang_inap']);



		$data['total_ranap'] = Folio::where('registrasi_id', $id)
			->with('tarif')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->selectRaw('sum(total) AS total,poli_tipe,kamar_id,registrasi_id,namatarif,created_at,jenis,tarif_id')
			->orderBy('namatarif', 'ASC')
			->sum('total');
		// dd($data['total_ranap']);

		$data['folio_irna'] = [];
		foreach ($data_folio_irna as $element) {
			$data['folio_irna'][$element['kamar_id']][] = $element;
		}
		// END POLI_TIPE YANG NULL

		// dd($data['folio_null_tipe']);

		$data['kamar'] = Folio::where('registrasi_id', $id)
			->whereNull('poli_tipe')
			->selectRaw('kamar_id')
			->groupBy('kamar_id')
			->get();
		// dd($data['kamar']);

		// dd($data['folio_null_tipe']);


		$data['lab'] = Folio::where('registrasi_id', $id)
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));

		$data['lab_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));
		$data['lab_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'L')
			->sum(\DB::raw('total'));


		$data['rad_igd'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_inap'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		$data['rad_irj'] = Folio::where('registrasi_id', $id)
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->sum(\DB::raw('total'));
		// $data['rad'] = Folio::where('registrasi_id', $id)
		// 	->where('poli_tipe','R')
		// 	->sum(\DB::raw('total'));
		// dd($data['folio_obat']);

		// if(substr($data['reg']->status_reg, 0, 1) == 'J'){
		// 	$total_biaya = Folio::where('registrasi_id', $id)
		// 	->where(function ($query){
		// 		$query->where('namatarif','not like','%'.'Retur penjualan'.'%')
		// 			->where(function ($query){
		// 				$query->where('gudang_id', '!=',2)
		// 					->orWhereNull('gudang_id');
		// 			});
		// 	})->sum(\DB::raw('total'));

		// 	$jasa_racik= Folio::where('registrasi_id', $id)
		// 	->where(function ($query){
		// 		$query->where('namatarif','not like','%'.'Retur penjualan'.'%')
		// 			->where(function ($query){
		// 				$query->where('gudang_id', '!=',2)
		// 					->orWhereNull('gudang_id');
		// 			});
		// 	})->sum(\DB::raw('jasa_racik'));

		// }else{
		$total_biaya = Folio::where('registrasi_id', $id)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('total'));
		$jasa_racik = Folio::where('registrasi_id', $id)->where('namatarif', 'not like', '%' . 'Retur penjualan' . '%')->sum(\DB::raw('jasa_racik'));
		// }
		$data['total_biaya'] = $total_biaya + $jasa_racik;
		// $pdf        = PDF::loadView('rawat-inap.rincianBiayaUnit', $data)->setpaper('folio', 'portrait');
		// return $pdf->stream();
		return view('rawat-inap.rincianBiayaUnitItem', $data);
	}

	public function sisaTotalTagihan($registrasi_id)
	{
		$tagihan = Folio::where('registrasi_id', $registrasi_id)->sum('total');
		return response()->json($tagihan);
	}

	public function askep()
	{
		session()->forget('pj');
		session()->forget('lab_id');
		if (!empty($kelas_id) && !empty($kamar_id)) {
			$data['inap'] = Rawatinap::where('kelas_id', $kelas_id)->where('kamar_id', $kamar_id)->get();
		} else {
			$data['inap'] = DB::table('rawatinaps')
				->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')->where('registrasis.status_reg', '=', 'I2')
				->select('rawatinaps.*', 'registrasis.status_reg')
				->get();
		}

		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
		return view('rawat-inap.askep', $data)->with('no', 1);
	}

	public function kosongkanBed($bed_id, $registrasi_id)
	{
		$bed = Bed::find($bed_id);
		$bed->reserved = 'N';
		$bed->update();

		$irna = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$irna->tgl_keluar = date('Y-m-d H:i:s');
		$irna->update();
		Flashy::success('Bed berhasil dikosongkan');
		return redirect('rawat-inap/billing');
	}

	public function simpanUpdateTanggalMasuk(Request $request)
	{
		if (!empty($request['tanggalMasuk'])) {
			$tgl = valid_date($request['tanggalMasuk']);
			$ri = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
			$ri->tgl_masuk = date($tgl . ' H:i:s');
			$ri->update();
			return response()->json(['sukses' => false]);
		} else {
			return response()->json(['sukses' => false]);
		}
	}

	public function kodeDPJP($id)
	{
		$pegawai = Pegawai::find($id)->kode_bpjs;
		return response()->json(['kode_bpjs' => $pegawai]);
	}

	public function resume($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$inap = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$date1 = Carbon::createMidnightDate(tglLOS($inap->tgl_masuk, 'Y'), tglLOS($inap->tgl_masuk, 'm'), tglLOS($inap->tgl_masuk, 'd'));
		$date2 = Carbon::createMidnightDate(tglLOS($inap->tgl_keluar, 'Y'), tglLOS($inap->tgl_keluar, 'm'), tglLOS($inap->tgl_keluar, 'd'));
		$los = $date1->diffInDays($date2);
		$dataPenjualan = Penjualan::where('registrasi_id', $registrasi_id)->get();
		$penjualan = [];
		foreach ($dataPenjualan as $d) {
			$penjualan[] = Penjualandetail::where('penjualan_id', $d->id)->first();
		}
		return view('rawat-inap.resume', compact('reg', 'inap', 'los', 'penjualan'));
	}

	public function getToday()
	{
		$data['tga']	= '';
		$data['tgb']	= '';
		$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
			->select('rawatinaps.id as rawatinap_id', 'rawatinaps.kamar_id', 'rawatinaps.kelas_id', 'rawatinaps.created_at', 'pasiens.nama', 'pasiens.no_rm', 'registrasis.id as registrasi_id')
			->get();
		return view('rawat-inap.datatoday', $data)->with('no', 1);;
	}
	public function getTodayByTgl(Request $req)
	{
		// dd($r->all());
		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;
		$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('rawatinaps.created_at', [valid_date($data['tga']) . ' 00:00:00', valid_date($data['tgb']) . ' 23:59:59'])
			->select('rawatinaps.id as rawatinap_id', 'rawatinaps.kamar_id', 'rawatinaps.kelas_id', 'rawatinaps.created_at', 'pasiens.nama', 'pasiens.no_rm', 'registrasis.id as registrasi_id')
			->get();
		return view('rawat-inap.datatoday', $data)->with('no', 1);;
	}

	public function hapusToday($id)
	{
		$inap = Rawatinap::find($id);
		// return $inap; die;
		$folio = Folio::where('registrasi_id', $inap->registrasi_id)->where('jenis', 'TI')->count();

		if ($folio > 0) {
			return response()->json(['sukses' => false]);
		} else {
			$reg = Registrasi::find($inap->registrasi_id);
			$reg->status_reg = 'I1';
			$reg->update();

			$bed = Bed::find($inap->bed_id);
			$bed->reserved = 'N';

			$histori = new HistoriStatus();
			$histori->registrasi_id = $reg->id;
			$histori->status = 'I1';
			$histori->bed_id = $bed->id;
			$histori->user_id = Auth::user()->id;

			$bed->update();
			$inap->delete();
			$histori->save();

			Flashy::success('Data Berhasil Di Hapus!');
			return response()->json(['sukses' => true]);
		}
	}

	public function UbahDpjp()
	{
		return view('rawat-inap.ubah_dpjp');
	}

	public function dataUbahDpjp($tga = '', $tgb = '')
	{
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		$date = date('Y-m-d', strtotime('-2 days'));

		if (!empty($tga) && !empty($tgb)) {
			$data = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->select(['registrasis.id AS registrasi_id', 'registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.no_sep', 'registrasis.status_reg', 'rawatinaps.kamar_id', 'rawatinaps.kelas_id', 'rawatinaps.id AS rawatinap_id', 'rawatinaps.dokter_id',])
				->whereBetween('registrasis.created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
				->where('registrasis.pasien_id', '<>', '0')
				// ->where('registrasis.status_reg', ['I2','I3'])
				->get();
		} else {
			$data = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->select(['registrasis.id AS registrasi_id', 'registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.no_sep', 'registrasis.status_reg', 'rawatinaps.kamar_id', 'rawatinaps.kelas_id', 'rawatinaps.id AS rawatinap_id', 'rawatinaps.dokter_id',])
				->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
				->where('registrasis.pasien_id', '<>', '0')
				// ->where('registrasis.status_reg', ['I2','I3'])
				->get();
		}


		return DataTables::of($data)
			->addColumn('no_rm', function ($data) {
				$pasien = Pasien::find($data->pasien_id);
				return $pasien ? $data->pasien->no_rm : '';
			})
			->addColumn('nama', function ($data) {
				$pasien = Pasien::find($data->pasien_id);
				return $pasien ? $data->pasien->nama : '';
			})
			->addColumn('alamat', function ($data) {
				$pasien = Pasien::find($data->pasien_id);
				return $pasien ? $data->pasien->alamat : '';
			})
			->addColumn('kelas', function ($data) {
				return baca_kelas($data->kelas_id);
			})
			->addColumn('kamar', function ($data) {
				return baca_kamar($data->kamar_id);
			})
			->addColumn('bayar', function ($data) {
				$jkn = !empty($data->tipe_jkn) ? ' - ' . $data->tipe_jkn : '';
				return baca_carabayar($data->bayar) . $jkn;
			})
			->addColumn('dokter', function ($data) {
				return baca_dokter($data->dokter_id);
			})
			->addColumn('ubah', function ($data) {
				if (json_decode(Auth::user()->is_edit, true)['edit'] == 1) {
					return '<button type="button" onclick="ubahDpjp(' . $data->rawatinap_id . ')" class="btn btn-primary btn-sm btn-flat"> <i class="fa fa-edit"></i> </button>';
				} else { }
			})
			->rawColumns(['ubah'])
			->make(true);
	}

	public function dataReg($id)
	{
		$reg = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->where('rawatinaps.id', $id)
			->first();
		$pasien = [
			'id' => $reg->id,
			'bayar' => $reg->bayar,
			'dokter_id' => $reg->dokter_id,
			'no_rm' => $reg->pasien->no_rm,
			'nama' => $reg->pasien->nama,
			'alamat' => $reg->pasien->alamat,
			'kamar' => baca_kamar($reg->kamar_id),
			'dokter' => baca_dokter($reg->dokter_id),
		];
		return response()->json($pasien);
	}

	public function save_ubahdpjp(Request $request)
	{
		$reg = Rawatinap::find($request['id']);
		$reg->dokter_id = $request['dokter_id'];
		$reg->update();

		$registrasi = Registrasi::find($reg->registrasi_id);
		$registrasi->bayar = $request['carabayar'];
		if ($request['carabayar'] == 1) {
			$registrasi->tipe_jkn = !empty($request['tipe_jkn']) ? $request['tipe_jkn'] : NULL;
		} else {
			$registrasi->tipe_jkn = NULL;
		}
		$registrasi->update();

		Flashy::success('DPJP berhasil di Ubah');
		return response()->json(['sukses' => true, 'data' => $reg]);
	}

	public function ambulance()
	{
		$data = [];
		return view('rawat-inap.ambulance', compact('data'))->with('no', 1);
	}

	public function ambulanceGetData(Request $request)
	{
		request()->validate(['no_rm' => 'required']);
		$data = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->where('registrasis.status_reg', 'like', 'I%')
			->where('pasiens.no_rm', $request['no_rm'])
			->select('registrasis.id as registrasi_id', 'registrasis.no_sep', 'pasiens.no_rm', 'pasiens.nama', 'rawatinaps.kamar_id', 'rawatinaps.dokter_id', 'rawatinaps.kelas_id', 'rawatinaps.tgl_keluar', 'rawatinaps.kelompokkelas_id')
			->get();
		return view('rawat-inap.ambulance', compact('data'))->with('no', 1);
	}

	public function saveAmbulance(Request $request)
	{
		$tarif = \Modules\Tarif\Entities\Tarif::find($request->tarif_id);
		$reg = Registrasi::find($request['registrasi_id']);
		$ri = Rawatinap::where('registrasi_id', $reg->id)->first();

		$fol = new Folio();
		$fol->registrasi_id = $request['registrasi_id'];
		$fol->lunas = 'N';
		$fol->namatarif = $tarif->nama;
		$fol->tarif_id = $request['tarif_id'];
		$fol->cara_bayar_id = $reg->bayar;
		$fol->jenis = 'TI';
		$fol->total = $tarif->total;
		$fol->jenis_pasien = $reg->jenis;
		$fol->pasien_id = $reg->pasien_id;
		$fol->dokter_id = $reg->dokter_id;

		if (!empty($request['tanggal'])) {
			$fol->created_at = valid_date($request['tanggal']);
		}

		$fol->kelompokkelas_id = $ri->kelompokkelas_id;
		$fol->kamar_id = $ri->kamar_id;
		$fol->user_id = Auth::user()->id;
		$fol->mapping_biaya_id = $tarif->mapping_biaya_id;
		$fol->save();

		if ($fol) {
			return response()->json(['sukses' => true, 'data' => $fol]);
		}
	}

	public function jenazah()
	{
		$data = [];
		return view('rawat-inap.jenazah', compact('data'))->with('no', 1);
	}

	public function jenazahGetData(Request $request)
	{
		request()->validate(['no_rm' => 'required']);
		$data = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->where('registrasis.status_reg', 'like', 'I%')
			->where('pasiens.no_rm', $request['no_rm'])
			->select('registrasis.id as registrasi_id', 'registrasis.no_sep', 'pasiens.no_rm', 'pasiens.nama', 'rawatinaps.kamar_id', 'rawatinaps.dokter_id', 'rawatinaps.kelas_id', 'rawatinaps.tgl_keluar', 'rawatinaps.kelompokkelas_id')
			->get();
		return view('rawat-inap.jenazah', compact('data'))->with('no', 1);
	}

	public function saveJenazah(Request $request)
	{
		$tarif = \Modules\Tarif\Entities\Tarif::find($request->tarif_id);
		$reg = Registrasi::find($request['registrasi_id']);
		$ri = Rawatinap::where('registrasi_id', $reg->id)->first();

		$fol = new Folio();
		$fol->registrasi_id = $request['registrasi_id'];
		$fol->lunas = 'N';
		$fol->namatarif = $tarif->nama;
		$fol->tarif_id = $request['tarif_id'];
		$fol->cara_bayar_id = $reg->bayar;
		$fol->jenis = 'TI';
		$fol->total = $tarif->total;
		$fol->jenis_pasien = $reg->jenis;
		$fol->pasien_id = $reg->pasien_id;
		$fol->dokter_id = $reg->dokter_id;

		if (!empty($request['tanggal'])) {
			$fol->created_at = valid_date($request['tanggal']);
		}

		$fol->kelompokkelas_id = $ri->kelompokkelas_id;
		$fol->kamar_id = $ri->kamar_id;
		$fol->user_id = Auth::user()->id;
		$fol->mapping_biaya_id = $tarif->mapping_biaya_id;
		$fol->save();

		if ($fol) {
			return response()->json(['sukses' => true, 'data' => $fol]);
		}
	}

	public function cetakRincianTindakan($registrasi_id)
	{
		$data['kuitansi'] = Pembayaran::where('id', $id)->first();
		//dd($data['kuitansi']);
		$data['reg']      = Registrasi::with('bayars')->find($data['kuitansi']->registrasi_id);
		$nokuitansi       = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)->where('jenis', 'ORJ')->where('lunas', 'Y')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->first();
		if (!$nokuitansi) {
			$noresep = '';
		} else {
			$noresep = $nokuitansi->namatarif;
		}

		$data['penjualan'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			//->where('penjualandetails.no_kuitansi',$noresep)
			->where('penjualandetails.jumlah', '!=', '0')
			->where('penjualans.registrasi_id', $data['reg']->id)
			->select('penjualandetails.*')
			->get();

		//dd($data['penjualan'] );
		// return $data['penjualan']; die;

		//kondisi to lab rajal
		$data['folio_irj_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to rad rajal
		$data['folio_irj_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab igd
		$data['folio_igd_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to rad igd
		$data['folio_igd_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab irna
		$data['folio_irna_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', 'L')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//kondisi to lab irna
		$data['folio_irna_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', 'R')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		//Master Loop
		$data['folio_irj'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TA')
			->where('poli_tipe', 'J')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['folio_igd'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TG')
			->whereIn('poli_tipe', ['G', 'Z', 'B'])
			// ->where('poli_tipe', 'J')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['folio_irna'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'TI')
			->where('poli_tipe', null)
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();
		// $data['folio_irna']   = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)->groupBy('tarif_id')->where('lunas', 'Y')->where('jenis', 'TI')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->get();

		$data['folio_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			->where('jenis', 'ORJ')
			->get();

		$data['folio'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)->where('lunas', 'Y')
			//->where('jenis','TI')
			->groupBy('tarif_id')
			->selectRaw('tarif_id, count(tarif_id) as jumlah, sum(total) as total')
			->get();

		$data['listDokter'] = [];
		foreach (Pegawai::where('kategori_pegawai', 1)->whereNotIn('id', [$data['reg']->dokter_id])->get() as $d) {
			$data['listDokter'][] = '' . $d->id . '';
		}
		$data['dokter'] = Folio::where('no_kuitansi', '=', $data['kuitansi']->no_kwitansi)
			->where('registrasi_id', $data['reg']->id)->whereIn('dokter_pelaksana', [$data['listDokter']])
			->groupBy('dokter_pelaksana')->select('dokter_pelaksana')->get();

		$data['jml'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('lunas', 'Y')->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');
		$data['no'] = 1;

		//JUMLAH IGD

		$data['jml_igd'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			// ->where('poli_tipe', 'J')
			->Where('poli_tipe', 'G')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)
			->sum('total');

		$data['jml_igd_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_igd_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TG')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		//JUMLAH RAJAL

		$data['jml_irj_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irj_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irj'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TA')
			->where('lunas', 'Y')
			->where('poli_tipe', 'J')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');


		//JUMLAH IRNA

		$data['jml_irna_lab'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', 'L')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irna_rad'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', 'R')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		$data['jml_irna'] = Folio::where('registrasi_id', $data['kuitansi']->registrasi_id)
			->where('jenis', 'TI')
			->where('lunas', 'Y')
			->where('poli_tipe', null)
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		// $data['jml_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
		//     ->where('namatarif','!=','Retur penjualan')
		//     ->where('jenis','ORJ')
		// 	->where('lunas', 'Y')
		// 	->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('total');

		//new commant
		$data['jml_obat'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('namatarif', '!=', 'Retur penjualan')
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->sum('total');

		// $data['jml_obat'] = Folio::join('penjualans','folios.registrasi_id','=','penjualans.registrasi_id')
		// 					->join('penjualandetails','penjualans.id','=','penjualandetails.penjualan_id')
		// 					->where('folios.registrasi_id', '=', $data['kuitansi']->registrasi_id)
		// 					->where('folios.namatarif','!=','Retur penjualan')
		// 					->where('penjualandetails.jumlah','!=','0')
		// 					->where('folios.jenis','ORJ')
		// 					->where('folios.lunas', 'Y')
		// 					->sum('total');

		//dd($data['jml_obat']);

		$data['embalase'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('embalase');

		$data['jasaracik'] = Folio::where('registrasi_id', '=', $data['kuitansi']->registrasi_id)
			->where('jenis', 'ORJ')
			->where('lunas', 'Y')
			->where('no_kuitansi', $data['kuitansi']->no_kwitansi)->sum('jasa_racik');

		$data['uangracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)->sum('uang_racik');

		$data['jmlracikper'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->groupBy('uang_racik_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)->sum('uang_racik');

		$data['Totracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)
			->groupBy('uang_racik_id')
			->selectRaw('count(penjualandetails.uang_racik) as Tot')
			->get();

		$data['jenisracik'] = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->join('uang_raciks', 'penjualandetails.uang_racik_id', '=', 'uang_raciks.id')
			->where('penjualans.registrasi_id', $data['kuitansi']->registrasi_id)
			->groupBy('uang_racik_id')
			->select('penjualandetails.uang_racik', 'uang_raciks.nama', DB::raw('sum(penjualandetails.uang_racik) as uracik'), DB::raw('count(penjualandetails.uang_racik) as jmlracik'))
			->get();

		$data['no'] = 1;
		$pdf        = PDF::loadView('rawat-inap.cetakrincian', $data)->setpaper('folio', 'landscape');
		return $pdf->stream();
	}

	public function lunaskanTindakan(Request $request)
	{
		foreach ($request->lunas as $key) {
			$id = (int) $key;
			$folio = Folio::find($id);
			$folio->lunas = 'Y';
			$folio->update();
		}
		Flashy::success('Tindakan berhasil di bayarkan / lunas');
		return response()->json(['sukses' => true]);
	}

	public function belumLunas(Request $request)
	{
		foreach ($request->lunas as $key) {
			$id = (int) $key;
			$folio = Folio::find($id);
			$folio->lunas = 'N';
			$folio->update();
		}
		Flashy::success('Tindakan berhasil');
		return response()->json(['sukses' => true]);
	}

	public function cekpasieninap()
	{

		$date = date('Y-m-d', strtotime('-10 days'));

		$data['reg'] = Registrasi::whereIn('status_reg', ['I1', 'I2'])
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->orderby('id', 'DESC')
			->get();
		return view('rawat-inap.cekpasieninap', $data)->with('no', 1);
	}

	public function getRegistrasi(Request $request, $reg_id)
	{
		$find = Registrasi::with('pasien')->find($reg_id);
		$res = [
			"status" => true,
			"data" => $find
		];
		return response()->json($res);
	}

	public function saveDetailResep(Request $request)
	{
		DB::beginTransaction();
		try {
			if (!empty($request->uuid)) { // update
				$resep = ResepNote::where('uuid', $request->uuid)->first();
				$detail = [
					"resep_note_id" => $resep->id,
					"logistik_batch_id" => $request->masterobat_id,
					"qty" => $request->qty,
					"cara_bayar" => $request->cara_bayar,
					"tiket" => $request->tiket,
					"cara_minum" => $request->cara_minum,
					"takaran" => $request->takaran,
					"informasi" => $request->informasi,
				];
				ResepNoteDetail::create($detail);
			} else { // create
				$uuid = 'ERI' . date('YmdHis');
				$data = [
					"uuid" => $uuid,
					"source" => $request->source,
					"registrasi_id" => $request->reg_id,
					"pasien_id" => $request->pasien_id,
					"created_by" => Auth::user()->id,
				];
				$resep = ResepNote::create($data);
				$detail = [
					"resep_note_id" => $resep->id,
					"logistik_batch_id" => $request->masterobat_id,
					"qty" => $request->qty,
					"cara_bayar" => $request->cara_bayar,
					"tiket" => $request->tiket,
					"cara_minum" => $request->cara_minum,
					"takaran" => $request->takaran,
					"informasi" => $request->informasi,
				];
				ResepNoteDetail::create($detail);
			}
			$show = ResepNoteDetail::with(['logistik_batch.master_obat'])->where('resep_note_id', $resep->id)->get();
			$html = '';
			foreach ($show as $key => $val) {
				$html .= '<tr>
						<td>' . ($key + 1) . '</td>
						<td>' . $val->logistik_batch->master_obat->nama . '</td>
						<td>' . $val->qty . '</td>
						<td>' . $val->cara_bayar . '</td>
						<td>' . $val->tiket . '</td>
						<td>' . $val->cara_minum . '</td>
						<td>' . $val->takaran . '</td>
						<td>' . $val->informasi . '</td>
						<td>
							<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
						</tr>';
			}
			DB::commit();
			$res = [
				"status" => true,
				"html" => $html,
				"uuid" => $resep->uuid
			];
			return response()->json($res);
		} catch (Exception $e) {
			DB::rollback();
			$res = [
				"status" => false,
				"data" => ""
			];
			return response()->json($res);
		}
	}

	public function deleteDetailResep(Request $request, $id)
	{
		$find = ResepNoteDetail::find($id);
		// delete
		$find->delete();
		if (isset($find->id)) {
			$show = ResepNoteDetail::with(['logistik_batch.master_obat'])->where('resep_note_id', $find->resep_note_id)->get();
			$html = '';
			foreach ($show as $key => $val) {
				$html .= '<tr>
						<td>' . ($key + 1) . '</td>
						<td>' . $val->logistik_batch->master_obat->nama . '</td>
						<td>' . $val->qty . '</td>
						<td>' . $val->cara_bayar . '</td>
						<td>' . $val->tiket . '</td>
						<td>' . $val->cara_minum . '</td>
						<td>' . $val->takaran . '</td>
						<td>' . $val->informasi . '</td>
						<td>
							<button type="button" data-id="' . $val->id . '" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
						</tr>';
			}
			$res = [
				"status" => true,
				"html" => $html,
			];
			return response()->json($res);
		}
		$res = [
			"status" => false,
			"html" => '<tr colspan="8" class="text-center">
					<td>Data Tidak Ada</td>
					</tr>',
		];
		return response()->json($res);
	}

	public function saveResep(Request $request)
	{
		$find = ResepNote::where('uuid', $request->uuid)->first();
		$data = [
			"status" => "dikirim"
		];
		$find->update($data);
		$res = [
			"status" => true,
		];
		return response()->json($res);
	}

	public function getHistoryResep(Request $request, $reg_id)
	{
		$data = ResepNote::with('resep_detail.logistik_batch.master_obat')->whereNotNull('status')->where('registrasi_id', $reg_id)->get();
		$html = '';
		if (count($data) == 0) {
			$html = '<p class="text-center">Belum Ada E-Resep :)</p>';
		}
		foreach ($data as $key => $val) {
			$detail = '';
			foreach ($val->resep_detail as $k => $v) {
				$detail .= '<tr>
							<td>' . ($k + 1) . '</td>
							<td>' . $v->logistik_batch->master_obat->nama . '</td>
							<td>' . $v->qty . '</td>
							</tr>';
			}
			$stat = ($val->status == "diproses") ? '<span class="text-success"><i class="fa fa-check-square" aria-hidden="true"></i>
			</span>' : '';
			$comment = '<tr><td>Keterangan </td><td colspan="2"><i>' . $val->comment . '</i></td></tr>';
			$html .= '<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>' . $val->uuid . '</th>
					<th class="text-center">' . $stat . '</th>
				</tr>
				<tr>
					<td>No</td>
					<td>Nama Obat</td>
					<td>Qty</td>
				</tr>
				' . $detail . '
				' . $comment . '
				</table>';
		}
		$res = [
			"status" => true,
			"html" => $html,
		];
		return response()->json($res);
	}

	public function sensusMasuk()
	{
		$data['tga']	= '';
		$data['tgb']	= '';
		$data['pasien']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'rawatinaps.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
			->where('rawatinaps.created_at', 'like', date('Y-m') . '%')
			->select(
				DB::raw('GROUP_CONCAT(icd10s.nama SEPARATOR ", ") as icd10'),
				'pasiens.nama',
				'pasiens.no_rm',
				'pasiens.tgllahir',
				'registrasis.bayar',
				'rawatinaps.kelas_id',
				'rawatinaps.kamar_id',
				'rawatinaps.tgl_masuk',
				'rawatinaps.dokter_id'
			)
			->groupBy('rawatinaps.id')->get();
		return view('rawat-inap.sensusMasuk', $data)->with('no', 1);
	}

	public function filterSensusMasuk(Request $req)
	{
		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;
		if ($req->tga == '' || $req->tgb == '') {
			$data['pasien']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
				->where('rawatinaps.created_at', 'like', date('Y-m') . '%')
				->select(
					DB::raw('GROUP_CONCAT(icd10s.nama SEPARATOR ", ") as icd10'),
					'pasiens.nama',
					'pasiens.no_rm',
					'pasiens.tgllahir',
					'registrasis.bayar',
					'rawatinaps.kelas_id',
					'rawatinaps.kamar_id',
					'rawatinaps.tgl_masuk',
					'rawatinaps.dokter_id'
				)
				->groupBy('rawatinaps.id')->get();
		} else {
			$data['pasien']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
				->whereBetween('rawatinaps.created_at', [valid_date($req->tga) . ' 00:00:00', valid_date($req->tgb) . ' 23:59:59'])
				->select(
					DB::raw('GROUP_CONCAT(icd10s.nama SEPARATOR ", ") as icd10'),
					'pasiens.nama',
					'pasiens.no_rm',
					'pasiens.tgllahir',
					'registrasis.bayar',
					'rawatinaps.kelas_id',
					'rawatinaps.kamar_id',
					'rawatinaps.tgl_masuk',
					'rawatinaps.dokter_id'
				)
				->groupBy('rawatinaps.id')->get();
		}

		$pasien = $data['pasien'];
		$no = 1;
		$tga = $req->tga;
		$tgb = $req->tgb;
		if ($req->submit == 'tampil') {
			return view('rawat-inap.sensusMasuk', $data)->with('no', 1);
		} else if ($req->submit == 'excel') {
			$periode = $req->tga . ' s/d ' . $req->tgb;
			Excel::create('Sensus Masuk' . $periode, function ($excel) use ($pasien, $periode) {
				// Set the properties
				$excel->setTitle('Sensus Masuk Periode ' . $periode)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Sensus Masuk Periode ' . $periode);
				$excel->sheet('Sensus Masuk', function ($sheet) use ($pasien) {
					$row = 1;
					$no = 1;
					$sheet->row($row++, ['No', 'Nama', 'No RM', 'Umur', 'Asal Masuk', 'Kelas', 'Tanggal', 'Jaminan', 'Diagnosa', 'Dokter']);

					foreach ($pasien as $p) {
						$sheet->row($row++, [
							$no++,
							$p->nama,
							$p->no_rm,
							hitung_umur($p->tgllahir),
							baca_kamar($p->kamar_id),
							baca_kelas($p->kelas_id),
							date('d M Y H:i:s', strtotime($p->tgl_masuk)),
							baca_carabayar($p->bayar),
							$p->icd10,
							($p->dokter_id != '') ? baca_dokter($p->dokter_id) : ''
						]);
					};
				});
			})->export('xlsx');
		} else if ($req->submit == 'pdf') {
			$pdf = PDF::loadView('rawat-inap.sensusMasukPdf', compact('no', 'pasien', 'tga', 'tgb'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream();
		}
	}

	public function sensusKeluar()
	{
		$data['tga']	= '';
		$data['tgb']	= '';
		$data['pasien']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'rawatinaps.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
			->where('rawatinaps.created_at', 'like', date('Y-m') . '%')
			->whereNotNull('rawatinaps.tgl_keluar')
			->select(
				DB::raw('GROUP_CONCAT(icd10s.nama SEPARATOR ", ") as icd10'),
				'pasiens.nama',
				'pasiens.no_rm',
				'pasiens.tgllahir',
				'registrasis.bayar',
				'rawatinaps.kelas_id',
				'rawatinaps.tgl_masuk',
				'rawatinaps.tgl_keluar',
				'rawatinaps.dokter_id',
				'registrasis.kondisi_akhir_pasien'
			)
			->groupBy('rawatinaps.id')->get();
		return view('rawat-inap.sensusKeluar', $data)->with('no', 1);
	}

	public function filterSensusKeluar(Request $req)
	{
		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;
		if ($req->tga == '' || $req->tgb == '') {
			$data['pasien']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
				->where('rawatinaps.created_at', 'like', date('Y-m') . '%')
				->whereNotNull('rawatinaps.tgl_keluar')
				->select(
					DB::raw('GROUP_CONCAT(icd10s.nama SEPARATOR ", ") as icd10'),
					'pasiens.nama',
					'pasiens.no_rm',
					'pasiens.tgllahir',
					'registrasis.bayar',
					'rawatinaps.kelas_id',
					'rawatinaps.tgl_masuk',
					'rawatinaps.tgl_keluar',
					'rawatinaps.dokter_id',
					'registrasis.kondisi_akhir_pasien'
				)
				->groupBy('rawatinaps.id')->get();
		} else {
			$data['pasien']	= Rawatinap::leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('perawatan_icd10s', 'perawatan_icd10s.registrasi_id', '=', 'rawatinaps.registrasi_id')
				->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->leftJoin('icd10s', 'icd10s.nomor', '=', 'perawatan_icd10s.icd10')
				->whereBetween('rawatinaps.created_at', [valid_date($req->tga) . ' 00:00:00', valid_date($req->tgb) . ' 23:59:59'])
				->whereNotNull('rawatinaps.tgl_keluar')
				->select(
					DB::raw('GROUP_CONCAT(icd10s.nama SEPARATOR ", ") as icd10'),
					'pasiens.nama',
					'pasiens.no_rm',
					'pasiens.tgllahir',
					'registrasis.bayar',
					'rawatinaps.kelas_id',
					'rawatinaps.tgl_masuk',
					'rawatinaps.tgl_keluar',
					'rawatinaps.dokter_id',
					'registrasis.kondisi_akhir_pasien'
				)
				->groupBy('rawatinaps.id')->get();
		}

		$pasien = $data['pasien'];
		$no = 1;
		$tga = $req->tga;
		$tgb = $req->tgb;
		if ($req->submit == 'tampil') {
			return view('rawat-inap.sensusKeluar', $data)->with('no', 1);
		} else if ($req->submit == 'excel') {
			$periode = $req->tga . ' s/d ' . $req->tgb;
			Excel::create('Sensus Keluar' . $periode, function ($excel) use ($pasien, $periode) {
				// Set the properties
				$excel->setTitle('Sensus Keluar Periode ' . $periode)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Sensus Keluar Periode ' . $periode);
				$excel->sheet('Sensus Keluar', function ($sheet) use ($pasien) {
					$row = 1;
					$no = 1;
					$sheet->row($row++, ['No', 'Nama', 'No RM', 'Umur', 'Tgl Masuk Ruangan', 'Tgl Keluar', 'Lama Rawat', 'Status Pulang', 'Kelas', 'Jaminan', 'Diagnosa', 'Dokter']);

					foreach ($pasien as $p) {
						$sheet->row($row++, [
							$no++,
							$p->nama,
							$p->no_rm,
							hitung_umur($p->tgllahir),
							date('d-m-Y H:i', strtotime($p->tgl_masuk)),
							date('d-m-Y H:i', strtotime($p->tgl_keluar)),
							lamaInap($p->tgl_masuk, $p->tgl_keluar),
							baca_carapulang($p->kondisi_akhir_pasien),
							baca_kelas($p->kelas_id),
							baca_carabayar($p->bayar),
							$p->icd10,
							($p->dokter_id != '') ? baca_dokter($p->dokter_id) : ''
						]);
					};
				});
			})->export('xlsx');
		} else if ($req->submit == 'pdf') {
			$pdf = PDF::loadView('rawat-inap.sensusKeluarPdf', compact('no', 'pasien', 'tga', 'tgb'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream();
		}
	}

	public function laporanCaraBayar()
	{
		$data['tga']	= '';
		$data['tgb']	= '';

		$data['bangsal']	= [];
		$data['carabayar']	= [];
		return view('rawat-inap.lapBangsalCaraBayar', $data)->with('no', 1);
	}

	public function caraBayarByReq(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;

		$data['bangsal']	= Kelompokkelas::all();
		$data['carabayar']	= Carabayar::all();
		if ($req->submit == 'TAMPILKAN') {
			return view('rawat-inap.lapBangsalCaraBayar', $data)->with('no', 1);
		} elseif ($req->submit == 'CETAK') {
			return view('rawat-inap.cetakBangsalCaraBayar', $data)->with('no', 1);
		} elseif ($req->submit == 'EXCEL') {
			$tga = $data['tga'];
			$tgb = $data['tgb'];
			$periode 	= $req->tga . ' s/d ' . $req->tgb;
			$bangsal 	= $data['bangsal'];
			$carabayar	= $data['carabayar'];
			Excel::create('Bangsal By Jaminan' . $periode, function ($excel) use ($tga, $tgb, $bangsal, $carabayar, $periode) {
				$excel->setTitle('Bangsal By Jaminan Periode ' . $periode)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Bangsal By Jaminan Periode ' . $periode);
				$excel->sheet('Bangsal By Jaminan', function ($sheet) use ($tga, $tgb, $bangsal, $carabayar) {
					$row = 1;
					$no = 1;
					$total = [];
					$head = ['No', 'Bangsal'];
					foreach ($carabayar as $k => $cb) {
						$total[$k] = 0;
						$head[$k + 2] = $cb->carabayar;
					};

					$sheet->row($row++, $head);

					foreach ($bangsal as $bs) {
						$body = [$no++, baca_kelompok($bs->id)];

						foreach ($carabayar as $k => $kl) {
							$lapTotal = lapByCaraBayar($bs->id, $kl->id, 'TI', $tga, $tgb);
							$total[$k] += $lapTotal;
							$body[$k + 2] = number_format($lapTotal);
						};
						$sheet->row($row++, $body);
					};

					$tfoot = ['#', 'TOTAL'];
					foreach ($total as $k => $t) {
						$tfoot[$k + 2] = number_format($t);
					}
					$sheet->row($row++, $tfoot);
				});
			})->export('xlsx');
		}
	}

	public function laporanKelasRawat()
	{
		$data['tga']	= '';
		$data['tgb']	= '';

		$data['bangsal'] = [];
		$data['kelas']	= [];
		return view('rawat-inap.lapBangsalKelasRawat', $data)->with('no', 1);
	}

	public function kelasRawatByReq(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;

		$data['bangsal']	= Kelompokkelas::all();
		$data['kelas']		= Kelas::all();

		if ($req->submit == 'TAMPILKAN') {
			return view('rawat-inap.lapBangsalKelasRawat', $data)->with('no', 1);
		} elseif ($req->submit == 'CETAK') {
			return view('rawat-inap.cetakBangsalKelasRawat', $data)->with('no', 1);
		} elseif ($req->submit == 'EXCEL') {
			$tga = $data['tga'];
			$tgb = $data['tgb'];
			$periode 	= $req->tga . ' s/d ' . $req->tgb;
			$bangsal 	= $data['bangsal'];
			$kelas	= $data['kelas'];
			Excel::create('Bangsal By Jaminan' . $periode, function ($excel) use ($tga, $tgb, $bangsal, $kelas, $periode) {
				$excel->setTitle('Bangsal By Jaminan Periode ' . $periode)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Bangsal By Jaminan Periode ' . $periode);
				$excel->sheet('Bangsal By Jaminan', function ($sheet) use ($tga, $tgb, $bangsal, $kelas) {
					$row = 1;
					$no = 1;
					$total = [];
					$head = ['No', 'Bangsal'];
					foreach ($kelas as $k => $kl) {
						$total[$k] = 0;
						$head[$k + 2] = $kl->nama;
					};

					$sheet->row($row++, $head);

					foreach ($bangsal as $bs) {
						$body = [$no++, baca_kelompok($bs->id)];

						foreach ($kelas as $k => $kl) {
							$lapTotal = lapByKelasRawat($bs->id, $kl->id, 'TI', $tga, $tgb);
							$total[$k] += $lapTotal;
							$body[$k + 2] = number_format($lapTotal);
						};
						$sheet->row($row++, $body);
					};

					$tfoot = ['#', 'TOTAL'];
					foreach ($total as $k => $t) {
						$tfoot[$k + 2] = number_format($t);
					}
					$sheet->row($row++, $tfoot);
				});
			})->export('xlsx');
		}
	}

	public function historiRanap()
	{
		$data['ranap']	= HistoriRawatInap::leftJoin('registrasis', 'registrasis.id', '=', 'histori_rawatinap.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'histori_rawatinap.pasien_id')->where('registrasis.status_reg', 'I2')->get();
		return view('rawat-inap.historiRanap', $data)->with('no', 1);
	}

	public function indeksKematian()
	{
		$data['registrasi'] = Registrasi::with('pasien')
			->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->select('registrasis.*', 'rawatinaps.tgl_masuk AS tgl_masuk', 'rawatinaps.tgl_keluar AS tgl_keluar')
			->whereIn('kondisi_akhir_pasien', [8, 9, 16])->get();
		return view('rawat-inap.indeks-kematian', $data);
	}

	public function indeksKematianByTanggal(Request $request)
	{
		$tga	= $request->tgl_awal;
		$tgb	= $request->tgl_akhir;

		$query = Registrasi::with('pasien')->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')->whereIn('kondisi_akhir_pasien', [8, 9, 16]);
		if ($tga && $tgb) {
			$query = $query->whereBetween('registrasis.created_at', [$tga, $tgb]);
		}

		$data['registrasi'] = $query->get();
		$export = $data['registrasi'];
		if ($request->type == "LANJUT") {
			return view('rawat-inap.indeks-kematian', $data);
		} else if ($request->type == "EXCEL") {
			Excel::create('Laporan Indeks Kematian', function ($excel) use ($export) {
				// Set the properties
				$excel->setTitle('Laporan Indeks Kematian')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Indeks Kematian');
				$excel->sheet('Laporan Indeks Kematian', function ($sheet) use ($export) {
					$row = 1;
					$no = 1;
					$sheet->mergeCells('D1:W1');
					$sheet->mergeCells('D2:W2');
					$sheet->row($row++, ['KARTU INDEKS KEMATIAN']);
					$sheet->row($row++, ['RUMAH SAKIT UMUM DAERAH OTO ISKANDAR DI NATA']);

					$row++;

					$sheet->mergeCells('D4:F4');
					$sheet->mergeCells('J4:K4');
					$sheet->mergeCells('L4:S4');
					$sheet->row(4, ['', '', '', 'MATI DI', '', '', '', '', '', 'JENIS KELAMIN', 'UMUR', 'MATI']);

					$row++;
					$sheet->row($row++, ['NO', 'NO RM', 'DOKTER', 'RJ', 'RD', 'RI', 'TGL JAM MASUK', 'TGL JAM KELUAR', 'KODE ICD X', 'L', 'P', 'UMUR', '<48 Jam', '>48 Jam']);

					foreach ($export as $p) {
						$icd10 = \App\PerawatanIcd10::where('registrasi_id', $p->id)->first();
						$sheet->row($row++, [
							$no++,
							$p->pasien->no_rm,
							baca_dokter($p->dokter_id),
							cek_status_reg($p->status_reg) == "J" ? '✔' : '-',
							cek_status_reg($p->status_reg) == "G" ? '✔' : '-',
							cek_status_reg($p->status_reg) == "I" ? '✔' : '-',
							$p->tgl_masuk,
							$p->tgl_keluar,
							@$icd10->icd10 ?? '-',
							$p->pasien->kelamin == 'L' ? '✔' : '-',
							$p->pasien->kelamin == 'P' ? '✔' : '-',
							hitung_umur($p->pasien->tgllahir),
							$p->kondisi_akhir_pasien == 9 ? '✔' : '-',
							$p->kondisi_akhir_pasien == 8 ? '✔' : '-'
						]);
					};
				});
			})->export('xlsx');
		}
	}

	public function demografiPasien()
	{
		$data['tga']	= '';
		$data['tgb']	= '';
		$pasien	= Rawatinap::join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->selectRaw("COUNT(*) as jmlpasien, pasiens.province_id")
			->groupBy('pasiens.province_id')->get();
		$provinsi = Province::all();
		$data['pasien'] =  $provinsi->map(function ($i) use ($pasien) {
			return [
				'name' => $i->name,
				'jmlpasien' => $pasien->where('province_id', $i->id)->first()->jmlpasien ?? 0
			];
		});
		return view('rawat-inap.demografipasien', $data)->with('no', 1);
	}
	public function demografiPasienBy(Request $request)
	{
		$data['tga']	= '';
		$data['tgb']	= '';
		$pasien	= Rawatinap::join('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->selectRaw("COUNT(*) as jmlpasien, pasiens.province_id")
			->groupBy('pasiens.province_id')->get();
		$provinsi = Province::all();
		$data['pasien'] =  $provinsi->map(function ($i) use ($pasien) {
			return [
				'name' => $i->name,
				'jmlpasien' => $pasien->where('province_id', $i->id)->first()->jmlpasien ?? 0
			];
		});

		$export = $data['pasien'];

		Excel::create('Demografi Pasien', function ($excel) use ($export) {
			// Set the properties
			$excel->setTitle('Demografi Pasien')
				->setCreator('Digihealth')
				->setCompany('Digihealth')
				->setDescription('Demografi Pasien');
			$excel->sheet('Demografi Pasien', function ($sheet) use ($export) {
				$row = 1;
				$no = 1;
				$sheet->row($row++, ['No', 'Provinsi', 'Jumlah Pasien']);

				foreach ($export as $p) {
					$sheet->row($row++, [
						$no++,
						$p['name'],
						$p['jmlpasien'],
					]);
				};
			});
		})->export('xlsx');
	}





	public function tagihan_ranap()
	{
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		$data['dokter']			= Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['tindakan']		= Tarif::groupBy('nama')->get();
		$data['cara_bayar']		= Carabayar::all();

		$data['tga']			= '';
		$data['tgb']			= '';
		$data['jenis_pasien']	= 0;
		$data['dokter_id']		= 0;
		$data['tarif_id']		= 0;
		$data['operasi']		= [];
		$data['detail_dokter']	= [];
		$data['catatan'] = [];
		return view('rawat-inap.tagihan_ranap', $data)->with('no', 1);
	}

	public function tagihan_ranap_by(Request $req)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		// dd($req->all());
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['tarif']			= Tarif::find($req->tarif_id);
		// dd($data['tarif']);
		$data['dokter']			= Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['tindakan']		= Tarif::groupBy('nama')->get();
		$data['cara_bayar']		= Carabayar::all();

		$data['tga']			= $req->tga;
		$data['tgb']			= $req->tgb;
		$data['jenis_pasien']	= $req->jenis_pasien;
		$data['dokter_id']		= $req->dokter_id;
		$data['tarif_id']		= $req->tarif_id;

		$tga				= valid_date($req['tga']) . ' 00:00:00';
		$tgb				= valid_date($req['tgb']) . ' 23:59:59';

		// Update: Tampilkan semua tindakan baik TI, TA, TG
		$data['irna']		= Folio
			::whereBetween('folios.created_at', [$tga, $tgb])
			->where('folios.jenis', '!=', 'ORJ')
			->leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->leftJoin('kelompok_kelas', 'kelompok_kelas.id', '=', 'rawatinaps.kelompokkelas_id')
			->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftJoin('pegawais as dpjp', 'dpjp.id', '=', 'folios.dokter_id')
			->leftJoin('pegawais as pelaksana', 'pelaksana.id', '=', 'folios.dokter_pelaksana')
			->select('folios.registrasi_id',  'folios.tarif_id', 'folios.poli_id', 'folios.kamar_id', 'folios.created_at', 'folios.namatarif', 'folios.total', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'registrasis.status', 'registrasis.bayar', 'registrasis.tipe_jkn', 'carabayars.carabayar', 'kelompok_kelas.kelompok', 'dpjp.nama as dpjp', 'pelaksana.nama as pelaksana');
		if ($data['dokter_id']) {
			$data['irna']->where('folios.dokter_id', $data['dokter_id']);
		}
		if ($data['jenis_pasien']) {
			$data['irna']->where('folios.jenis_pasien', $data['jenis_pasien']);
		}
		if ($data['tarif_id']) {
			$data['irna']->where('folios.namatarif', $data['tarif']->nama);
		}

		$data['irna'] = $data['irna']
			->orderBy('folios.created_at', 'ASC')
			->groupBy('folios.registrasi_id', 'tarif_id')->get();

		$data['grandTotal'] = $data['irna']->sum('total');
		$data['irna_new'] = [];
		foreach ($data['irna'] as $element) {
			$data['irna_new'][$element['registrasi_id']][] = $element;
		}
		// dd($data['irna_new']);
		if ($req->lanjut) {
			return view('rawat-inap.tagihan_ranap', $data)->with('no', 1);
		} elseif ($req->excel) {
			Excel::create('Laporan Tagihan ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Tagihan')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Tagihan');
				$excel->sheet('Laporan Tagihan', function ($sheet) use ($data) {
					$row = 1;
					$no  = 1;
					$sheet->row($row, [
						'No',
						'No.RM',
						'Nama',
						'Ruangan',
						'Status',
						'L/P',
						'Bayar',
						'Dokter Pelaksana',
						'DPJP',
						'Tangal',
						'Nama Tindakan',
						'Total',
					]);
					foreach ($data['irna'] as $key => $d) {
						$carabayar = $d->carabayar;
						if ($d->bayar == '1') {
							$carabayar = $carabayar . " - " .  @$d->tipe_jkn;
							$carabayar = strtoupper($carabayar);
						}
						$sheet->row(++$row, [
							$no++,
							@$d->no_rm,
							@$d->nama,
							@$d[0]->kelompok,
							@$d->status == 'baru' ? 'Baru' : 'Lama',
							@$d->kelamin,
							@$carabayar,
							@$d->pelaksana,
							@$d->dpjp,
							date('d-m-Y', strtotime(@$d->created_at)),
							@$d->namatarif
						]);
					}
				});
			})->export('xlsx');
		}
	}




	public function  deleteIbs($id)
	{
		$data = Operasi::find($id);
		$data->delete();

		return response()->json('success');
	}




	public function cariPasien()
	{
		return view('rawat-inap.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		// $date = date('Y-m-d', strtotime('-7 days'));
		// return $request->all();
		if ($request->no_rm) {
			$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->latest()->first();
		} elseif ($request->nama) {
			$data['pasien'] = Pasien::where('nama', 'like', $request->nama . '%')->latest()->first();
		}
		$data['reg'] = Registrasi::join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->where('registrasis.pasien_id', @$data['pasien']->id)
			// ->whereBetween('rawatinaps.tgl_keluar', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->orderby('registrasis.id', 'DESC')
			->select('registrasis.*', 'rawatinaps.tgl_masuk as tgl_masuk', 'rawatinaps.tgl_keluar as tgl_keluar')
			->groupBy('rawatinaps.registrasi_id')
			->get();
		$data['perinatologi'] = M_config35::all();
		// return $data; die;
		return view('rawat-inap.cari-pasien', $data)->with('no', 1);
	}

	public function sepuluhBesarPenyakit()
	{
		return view('rawat-inap.10-besar-penyakit');
	}

	public function sepuluhBesarPenyakitByTanggal(Request $request)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);

		$tga	= valid_date($request->tga) . ' 00:00:00';
		$tgb	= valid_date($request->tgb) . ' 23:59:59';

		$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah, GROUP_CONCAT(perawatan_icd10s.registrasi_id SEPARATOR "||") as registrasi_id FROM perawatan_icd10s WHERE created_at BETWEEN "' . $tga . '" AND "' . $tgb . '"AND icd10 NOT LIKE "O%" AND icd10 NOT LIKE "Z%" AND icd10 NOT LIKE "P%" AND icd10 NOT LIKE "Q%" AND icd10 NOT LIKE "R%" AND jenis = "TI" GROUP BY icd10 ORDER BY jumlah DESC limit 10');

		// dd($data);

		if ($request['view']) {
			return view('rawat-inap.10-besar-penyakit', compact('data', 'tga', 'tgb'))->with('no', 1);
		} elseif ($request['excel']) {
			Excel::create('Lap 10 Besar Penyakit Rawat Inap', function ($excel) use ($data, $tga, $tgb) {
				$excel->setTitle('Lap 10 Besar Penyakit Rawat Inap')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap 10 Besar Penyakit Rawat Inap');
				$excel->sheet('Sheet 1', function ($sheet) use ($data, $tga, $tgb) {
					$sheet->loadView('rawat-inap.10-besar-penyakit-excel', [
						'data' => $data,
						'tga' => $tga,
						'tgb' => $tgb,
					]);
				});
			})->export('xlsx');
		}
	}



	public function hasil()
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');

		session()->forget('pj');
		session()->forget('lab_id');
		$data['tga']	= '';
		$data['tgb']	= '';
		$kelompokKelas = Auth::user()->coder_nik;
		if ($kelompokKelas != '' || $kelompokKelas != NULL) {
			$kelompokKelas = explode(",", $kelompokKelas);

			$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->with([
					'registrasi',
					'registrasi.pasien',
					'registrasi.bayars',
					'registrasi.ekspertise',
					'registrasi.ekspertise_gigi',
					'registrasi.hasilLab_patalogi',
					'registrasi.hasilLab_klinis',
					'dokter_ahli',
					'kamar',
					'bed',
					'kelas'
				])
				->whereIn('rawatinaps.kelompokkelas_id', $kelompokKelas)
				// ->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
				->where('registrasis.status_reg', 'I2')
				->whereNull('registrasis.deleted_at')
				->orderBy('id', 'DESC')
				->select('rawatinaps.*', 'registrasis.status_reg')
				// ->limit(50)
				->get();
		} else {
			$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->with([
					'registrasi',
					'registrasi.pasien',
					'registrasi.bayars',
					'registrasi.ekspertise',
					'registrasi.ekspertise_gigi',
					'registrasi.hasilLab_patalogi',
					'registrasi.hasilLab_klinis',
					'dokter_ahli',
					'kamar',
					'bed',
					'kelas'
				])
				// ->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
				->where('registrasis.status_reg', 'I2')
				->whereNull('registrasis.deleted_at')
				->orderBy('id', 'DESC')
				->select('rawatinaps.*', 'registrasis.status_reg')
				// ->limit(50)
				->get();
			// dd($data);
		}
		// dd($data);
		// $data['status_reg']	= 'I2';
		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');

		$data['kelompok_kelas'] = getGroupKelas();
		// dd($data['cara_minum']);
		return view('rawat-inap.hasil', $data)->with('no', 1);
	}



	public function filterHasil(Request $req)
	{
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
		// dd($req->all());
		// request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['tga']	= $req->tga;
		$data['tgb']	= $req->tgb;

		// if (count($data['kelas'])) {
		// 	foreach ($data['kelas'] as $kelas) {
		// 		$kelompokkelas_id[] = $kelas->id;
		// 	}
		// }

		$data['inap'] = Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->with([
				'registrasi',
				'registrasi.pasien',
				'registrasi.bayars',
				'registrasi.ekspertise',
				'registrasi.ekspertise_gigi',
				'registrasi.hasilLab_patalogi',
				'registrasi.hasilLab_klinis',
				'dokter_ahli',
				'kamar',
				'bed',
				'kelas'
			]);

		if ($data['tga'] && $data['tgb']) {
			$data['inap'] =	$data['inap']->whereBetween('rawatinaps.created_at', [valid_date($req['tga']) . ' 00:00:00', valid_date($req['tgb']) . ' 23:59:59']);
		}

		if ($req->kelompok_kelas) {
			$kelompokKelas	= Kelompokkelas::where('kelompok', 'like', '%' . $req->kelompok_kelas . '%')->pluck('id');
			$data['inap'] =	$data['inap']->whereIn('rawatinaps.kelompokkelas_id', $kelompokKelas);
		}

		$data['inap']	= $data['inap']->whereNull('registrasis.deleted_at')
			->select('rawatinaps.*', 'registrasis.status_reg')
			->get();
		// dd($data['inap']);


		// $data['status_reg']	= $req->jenis_reg;
		// e resep

		$data['kelompok_kelas'] = getGroupKelas();
		$data['kelas_selected'] = $req->kelompok_kelas;
		return view('rawat-inap.hasil', $data)->with('no', 1);
	}

	public function selesaiBilling($reg_id)
	{
		$rawat_inap = Rawatinap::where('registrasi_id', $reg_id)->first();

		if ($rawat_inap) {
			$rawat_inap->selesai_billing = 'Pada ' . date('d-m-Y H:i') . ' oleh ' . Auth::user()->name;
			$rawat_inap->update();
			return response()->json([
				'code' => 200,
				'message' => 'Berhasil, status billing diselesaikan ' . $rawat_inap->selesai_billing
			]);
		}

		return response()->json([
			'code' => 404,
			'message' => 'Gagal, data Rawat Inap tidak ada'
		]);
	}
}
