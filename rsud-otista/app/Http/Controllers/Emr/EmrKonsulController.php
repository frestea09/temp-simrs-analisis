<?php

namespace App\Http\Controllers\Emr;

use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use App\KondisiAkhirPasien;
use App\Posisiberkas;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use PDF;
use Modules\Registrasi\Entities\Carabayar;
use App\MasterEtiket;
use App\TakaranobatEtiket;
use App\Aturanetiket;
use App\Emr;
use App\EmrKonsul;
use Modules\Pegawai\Entities\Pegawai;
use Auth;
use Modules\Poli\Entities\Poli;
use Carbon\Carbon;

class EmrKonsulController extends Controller
{
	// KONSUL DOKTER
	public function konsulDokter(Request $request, $unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		$data['resume']         = Emr::where('pasien_id', @$data['reg']->pasien->id)->first();
		$data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		$data['dokter'] 		= Pegawai::where('kategori_pegawai', '1')->pluck('nama', 'id');
		if (substr($data['reg']->status_reg, 0, 1) == 'G') {
			$data['polis'] = Poli::where('nama', 'NOT LIKE', '%Laboratorium%')->where('nama', 'NOT LIKE', '%Radiologi%')->pluck('nama', 'id');
		} else {
			$data['polis'] = Poli::where('politype', 'J')->pluck('nama', 'id');
		}
		$data['carabayar'] 		= Carabayar::all('carabayar', 'id');
		$data['tiket'] 			= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] 	= Aturanetiket::all('aturan', 'id');
		$data['takaran'] 		= TakaranobatEtiket::all('nama', 'nama');
		$data['all_resume']     = EmrKonsul::where('pasien_id', @$data['reg']->pasien_id)->with('data_jawab_konsul')->where('type', 'konsul_dokter')->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrKonsul::find($request->konsul_dokter);

		return view('emr.modules.konsul_dokter', $data);
	}

	public function getDokterPoli($poli_id)
	{

		$data = [];
		$poli = Poli::where('id', $poli_id)->first();

		// dd($dokter);
		if (!@$poli->dokter_id || @$poli->politype == 'G' || $poli_id == "all") {
			$dokter = Pegawai::where('kategori_pegawai', '1')->get();
		} else {
			$dokter = Pegawai::whereIn('id', explode(",", $poli->dokter_id))->get();
		}

		$data[0] = [
			'metadata' => [
				'code' => 200
			],
			'poli' => @$poli->nama
		];

		foreach ($dokter as $d) {
			$data[1][] = [
				'jadwal' => '',
				'namadokter' => $d->nama,
				'id' => $d->id,
			];
		}

		return response()->json($data);
	}

	public function saveKonsulDokter(Request $r)
	{

		// dd($r->all());
		$emr = new EmrKonsul();
		// $emr->keterangan = $r->keterangan;
		$emr->dokter_penjawab = $r->dokter_penjawab;
		$emr->dokter_pengirim = $r->dokter_pengirim;
		$emr->pasien_id  = $r->pasien_id;
		$emr->registrasi_id  = $r->registrasi_id;
		$emr->user_id  = Auth::user()->id;
		$emr->alasan_konsul  = $r->alasan_konsul;
		$emr->type  = 'konsul_dokter';
		// $emr->anjuran  = $r->anjuran;
		$emr->unit  	= $r->unit;
		$emr->tanggal  	= $r->tanggal;
		$emr->waktu  	= $r->waktu;
		$emr->poli_id	= $r->poli_id;
		$emr->poli_asal_id	= $r->poli_asal_id;
		$emr->save();

		Flashy::success('Catatan berhasil disimpan');
		return redirect()->back();
	}
	public function updateKonsulDokter(Request $r)
	{
		// 
		// dd($r->all());
		$emr = EmrKonsul::where('id', $r->emr_id)->first();
		// $emr->keterangan = $r->keterangan;
		$emr->dokter_penjawab = $r->dokter_penjawab;
		$emr->dokter_pengirim = $r->dokter_pengirim;
		$emr->user_id  = Auth::user()->id;
		$emr->alasan_konsul  = $r->alasan_konsul;
		$emr->tanggal  	= $r->tanggal;
		$emr->waktu  	= $r->waktu;
		$emr->poli_id  	= $r->poli_id;
		$emr->save();

		Flashy::success('Catatan berhasil disimpan');
		return redirect()->back();
	}

	// JAWAB KONSUL
	public function jawabKonsul($unit, $registrasi_id, $id_soap = NULL, $edit = NULL)
	{
		// dd($registrasi_id);
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		$data['resume']         = Emr::where('pasien_id', @$data['reg']->pasien->id)->first();
		$data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		$data['dokter'] 		= Pegawai::where('kategori_pegawai', '1')->pluck('nama', 'id');
		$data['carabayar'] 		= Carabayar::all('carabayar', 'id');
		$data['tiket'] 			= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] 	= Aturanetiket::all('aturan', 'id');
		$data['takaran'] 		= TakaranobatEtiket::all('nama', 'nama');
		$data['all_resume']     = EmrKonsul::where('pasien_id', @$data['reg']->pasien_id)->where('type', 'jawab_konsul')->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrKonsul::find($id_soap);

		return view('emr.modules.konsul_jawab', $data);
	}
	public function dataKonsul($id)
	{
		$data['dokter'] 		= Pegawai::where('kategori_pegawai', '1')->pluck('nama', 'id');
		$data['emr']			= EmrKonsul::find($id);
		$data['reg']            = Registrasi::find($data['emr']->registrasi_id);
		$data['unit']           = $data['emr']->unit;
		return view('emr.modules._data_konsul', $data);
	}
	public function dataJawabanKonsul($id)
	{
		$data['dokter'] 		= Pegawai::where('kategori_pegawai', '1')->pluck('nama', 'id');
		$data['emr']			= EmrKonsul::find($id);
		$data['reg']            = Registrasi::find($data['emr']->registrasi_id);
		$data['unit']           = $data['emr']->unit;
		$data['data_jawaban']	= EmrKonsul::where('konsul_dokter_id', $data['emr']->id)->get();
		return view('emr.modules._data_jawaban_konsul', $data);
	}
	public function updateJawabKonsul(Request $r)
	{

		// dd($r->all());
		$emr = EmrKonsul::where('id', $r->emr_id)->first();
		// $emr->keterangan = $r->keterangan;
		$emr->dokter_penjawab = $r->dokter_penjawab;
		$emr->dokter_pengirim = $r->dokter_pengirim;
		$emr->user_id  = Auth::user()->id;
		$emr->jawab_konsul  = $r->jawab_konsul;
		$emr->anjuran  = $r->anjuran;
		$emr->tanggal  	= $r->tanggal;
		$emr->waktu  	= $r->waktu;
		$emr->save();

		Flashy::success('Catatan berhasil disimpan');
		return redirect()->back();
	}
	public function updateJawabKonsulAjax(Request $r)
	{

		$emr = EmrKonsul::where('id', $r->id)->first();
		$emr->jawab_konsul  = $r->jawab_konsul ?? $emr->jawab_konsul;
		$emr->anjuran  = $r->anjuran ?? $emr->anjuran;
		$emr->update();

		return response()->json([
			"status" => true,
			"message" => "Berhasil memperbarui jawaban konsul"
		]);
	}
	public function saveJawabKonsul(Request $r)
	{

		// dd($r->all());
		$emr = new EmrKonsul();
		// $emr->keterangan = $r->keterangan;
		$emr->dokter_penjawab = $r->dokter_penjawab;
		$emr->dokter_pengirim = $r->dokter_pengirim;
		$emr->pasien_id  = $r->pasien_id;
		$emr->registrasi_id  = $r->registrasi_id;
		$emr->user_id  = Auth::user()->id;
		$emr->jawab_konsul  = $r->jawab_konsul;
		$emr->konsul_dokter_id  = $r->konsul_dokter_id;
		$emr->anjuran  = $r->anjuran;
		$emr->type  = 'jawab_konsul';
		$emr->unit  	= $r->unit;
		$emr->tanggal  	= $r->tanggal;
		$emr->waktu  	= $r->waktu;
		$emr->save();

		$konsul_dokter = EmrKonsul::find($r->konsul_dokter_id);

		if (empty($konsul_dokter->dokter_penjawab)) {
			$konsul_dokter->dokter_penjawab = Auth::user()->pegawai->id;
			$konsul_dokter->update();
		}

		Flashy::success('Jawab Konsul Berhasil Disimpan');
		return redirect()->back();
	}
	public function deleteJawabKonsul(Request $r)
	{
		$emr = EmrKonsul::find($r->id);
		if ($emr) {
			$emr->delete();
		}
		return response()->json([
			"status" => true,
			"message" => "Berhasil menghapus jawaban konsul",
		]);
	}

	public function buatCetakKonsul(Request $request)
	{
		$konsul = EmrKonsul::where('type', 'jawab_konsul')
			->where('registrasi_id', $request->regId)
			->orderBy('id', 'DESC')
			->first();
		if (!$konsul) {
			$konsul = EmrKonsul::where('type', 'konsul_dokter')
			->where('registrasi_id', $request->regId)
			->orderBy('id', 'DESC')
			->first();
			if(!$konsul){
				return response()->json([
					'sukses' => false,
					'text' => 'Konsul Tidak Ditemukan'
				]);
			}
		}

		$konsul->keterangan = $request->keterangan;
		$konsul->update();

		return response()->json([
			'sukses' => true,
			'text' => 'Sukses',
			'regId' => encrypt($konsul->registrasi_id),
			'konsulId' => encrypt($konsul->id),
		]);
	}

	public function cetakKonsul($regId, $konsulId)
	{
		// dd($regId);
		$regId = decrypt($regId);
		$konsulId = decrypt($konsulId);
		$reg = Registrasi::find($regId);
		$konsulJawab = EmrKonsul::find($konsulId);
		$konsulDokter = EmrKonsul::find($konsulJawab->konsul_dokter_id);
		$tglJawab = Carbon::parse($konsulJawab->created_at)->format('d/m/Y');
		if(!$konsulDokter){
			$konsulDokter = $konsulJawab;
			$tglJawab = null;
		}
		$data['reg'] = Registrasi::find($regId);
		$data['dataKonsul'] = [
			'namaPasien' => $reg->pasien->nama,
			'noRM' => $reg->pasien->no_rm,
			'poli' => $reg->poli->nama,
			'dokterPengirim' => baca_dokter($konsulJawab->dokter_pengirim),
			'dokterPenjawab' => baca_dokter($konsulJawab->dokter_penjawab),
			'alasanKonsul' => strip_tags($konsulDokter->alasan_konsul),
			'jawabKonsul' => $konsulJawab->jawab_konsul ?? '',
			'anjuran' => $konsulJawab->anjuran ?? '-',
			'keterangan' => $konsulJawab->keterangan ?? '-',
			'waktuKonsul' => Carbon::parse($konsulJawab->tanggal)->format('d/m/Y') . ' ' . $konsulJawab->waktu,
			'tanggalJawab' => $tglJawab,
		];
		// dd($data['dataKonsul']);

		$pdf = PDF::loadView('emr.modules.pdf_konsul', $data);
		$pdf->setPaper('A4', 'portrait');
		return $pdf->stream('Surat_Konsul_' . $reg->pasien->nama . '.pdf');
	}

	public function verifKonsul(Request $request){
		$unit = $request['unit'];
		$data['unit'] = $unit;
		$data['smf'] = $request['smf'] ?? 0;
		$data['status'] = $request['status'];
		$poli_id = Auth::user()->poli_id;
		$poli_id = explode(",", $poli_id);
		$data['emrKonsuls'] = EmrKonsul::with(['data_jawab_konsul','registrasi', 'pasien', 'dokterPengirim', 'dokterTujuan', 'userVerif'])
			->join('registrasis', 'registrasis.id', '=', 'emr_konsuls.registrasi_id')
			->join('polis', 'polis.id', '=','registrasis.poli_id')
			->where('emr_konsuls.type', 'konsul_dokter')
			->whereDate('emr_konsuls.created_at', date('Y-m-d'));

		if (Auth::user()->pegawai->kategori_pegawai == 1) {
			$userDokter = Auth::user();

			$data['emrKonsuls'] = $data['emrKonsuls']->where(function ($query) use ($userDokter, $poli_id) {
				$query->where('emr_konsuls.dokter_penjawab', $userDokter->pegawai->id)
					  ->orWhere(function ($subQuery) use ($poli_id) {
						  $subQuery->whereNull('emr_konsuls.dokter_penjawab')
									->whereIn('emr_konsuls.poli_id', $poli_id);
					  });
			});
			
		}

		if (!empty($unit)) {
			$data['emrKonsuls'] = $data['emrKonsuls']->where('emr_konsuls.unit', $unit);
		}
		
		$data['emrKonsuls'] = $data['emrKonsuls']->select([
								'emr_konsuls.id',
								'emr_konsuls.registrasi_id',
								'emr_konsuls.pasien_id',
								'emr_konsuls.dokter_pengirim',
								'emr_konsuls.dokter_penjawab',
								'emr_konsuls.verifikator',
								'emr_konsuls.alasan_konsul',
								'emr_konsuls.unit',
								'emr_konsuls.created_at',
								'emr_konsuls.poli_id',
								'emr_konsuls.poli_asal_id',
							])->get();

		return view('emr.modules.verif-konsul', $data)->with('no', 1);
	}

	public function verifKonsulFilter(Request $request){
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$tga = valid_date($request->tga);
		$tgb = valid_date($request->tgb);
		$unit = $request['unit'];
		$data['unit'] = $unit;
		$data['smf'] = $request['smf'];
		$data['status'] = $request['status'];
		$poli_id = Auth::user()->poli_id;
		$poli_id = explode(",", $poli_id);

		$data['emrKonsuls'] = EmrKonsul::with(['data_jawab_konsul','registrasi', 'pasien', 'dokterPengirim', 'dokterTujuan', 'userVerif'])
			->join('registrasis', 'registrasis.id', '=', 'emr_konsuls.registrasi_id')
			->join('polis', 'polis.id', '=','registrasis.poli_id')
			->where('emr_konsuls.type', 'konsul_dokter')
			->whereBetween('emr_konsuls.created_at', [$tga.' 00:00:00', $tgb.' 23:59:59']);

		if (Auth::user()->pegawai->kategori_pegawai == 1) {
			if (!empty($data['smf'])) {
				$dokterSMF = Pegawai::where('smf', $data['smf'])->pluck('id');
				$data['emrKonsuls'] = $data['emrKonsuls']->whereIn('emr_konsuls.dokter_penjawab', $dokterSMF);
			} else {
				$userDokter = Auth::user();
				$data['emrKonsuls'] = $data['emrKonsuls']->where(function ($query) use ($userDokter, $poli_id) {
					$query->where('emr_konsuls.dokter_penjawab', $userDokter->pegawai->id)
						  ->orWhere(function ($subQuery) use ($poli_id) {
								$subQuery->whereNull('emr_konsuls.dokter_penjawab')
										 ->whereIn('emr_konsuls.poli_id', $poli_id);
					});
				});
			}
		}

		if (!empty($unit)) {
			$data['emrKonsuls'] = $data['emrKonsuls']->where('emr_konsuls.unit', $unit);
		}

		if (!empty($data['status'])) {
			if ($data['status'] == "terjawab") {
				$data['emrKonsuls'] = $data['emrKonsuls']->has('data_jawab_konsul');
			} elseif ($data['status'] == "belum_terjawab") {
				$data['emrKonsuls'] = $data['emrKonsuls']->doesntHave('data_jawab_konsul');
			}
		}
		
		$data['emrKonsuls'] = $data['emrKonsuls']->select([
								'emr_konsuls.id',
								'emr_konsuls.registrasi_id',
								'emr_konsuls.pasien_id',
								'emr_konsuls.dokter_pengirim',
								'emr_konsuls.dokter_penjawab',
								'emr_konsuls.verifikator',
								'emr_konsuls.alasan_konsul',
								'emr_konsuls.unit',
								'emr_konsuls.created_at',
								'emr_konsuls.poli_id',
								'emr_konsuls.poli_asal_id',
							])->get();

		return view('emr.modules.verif-konsul', $data)->with('no', 1);
	}

	public function verifKonsulProses($idKonsul){
		$konsul = EmrKonsul::find($idKonsul);
		$konsul->verifikator = Auth::user()->id;
		$konsul->save();

		return response()->json([
			'code' => 200,
			'message' => 'Berhasil Verifkasi'
		]);
	}

	public function create($unit, $registrasi_id)
	{
		// 1. Ambil Data Dasar Registrasi dan Unit
		$data['registrasi_id'] = $registrasi_id;
		$data['unit'] = $unit;
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['infopasien'] = 'Penerjemah Bahasa';

		// 2. Ambil Riwayat Pasien Berdasarkan ID Pasien dari Registrasi
		$data['riwayat'] = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();

		// 3. Ambil Data Alergi (Tipe A)
		$data['alergi'] = MasterRiwayatKesehatan::where('tipe', 'A')->get();

		// 4. Ambil Informasi Riwayat Kesehatan (Tipe I)
		$informasi = MasterRiwayatKesehatan::where('tipe', 'I')->get();
		$riwayat_info = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'I')->get();
		$data['riwayat_info'] = [];
		foreach ($informasi as $d) {
			$data['riwayat_info'][$d->id]['id'] = $d->id;
			$data['riwayat_info'][$d->id]['nama'] = $d->nama;
			foreach ($riwayat_info as $isi) {
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['riwayat_info'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// 5. Ambil Cara Masuk (Tipe CM)
		$caramasuk = MasterRiwayatKesehatan::where('tipe', 'CM')->get();
		$CM = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'CM')->get();
		$data['CM'] = [];
		foreach ($caramasuk as $d) {
			$data['CM'][$d->id]['id'] = $d->id;
			$data['CM'][$d->id]['nama'] = $d->nama;
			foreach ($CM as $isi) {
				$data['CM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['CM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// 6. Ambil Asal Masuk (Tipe AM)
		$asalmasuk = MasterRiwayatKesehatan::where('tipe', 'AM')->get();
		$AM = EmrRiwayatKesehatan::where('riwayat_id', @$data['riwayat']->id)->where('tipe', 'AM')->get();
		$data['AM'] = [];
		foreach ($asalmasuk as $d) {
			$data['AM'][$d->id]['id'] = $d->id;
			$data['AM'][$d->id]['nama'] = $d->nama;
			foreach ($AM as $isi) {
				$data['AM'][$isi->riwayat_kesehatan_id]['keterangan'] = $isi->keterangan;
				$data['AM'][$isi->riwayat_kesehatan_id]['checked'] = $isi->checked;
			}
		}

		// 7. Return View dengan Data yang Telah Dikumpulkan
		return view('emr.modules.medical_history', $data);
	}

}
