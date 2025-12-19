<?php

namespace App\Http\Controllers;

use App\AntrianFarmasi;
use App\Penjualan;
use App\Penjualandetail;
use App\RencanaKontrol;
use Excel;
use Illuminate\Http\Request;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Kamar\Entities\Kamar;
use function GuzzleHttp\json_encode;
use App\CopyResepDetail;
use App\CopyResep;
use App\Kelompokkelas;
use App\Rawatinap;
use App\Logistik\LogistikStock;
use App\Masterobat;
use App\ResepNote;
use App\User;
use App\EmrInapPemeriksaan;
use Carbon\Carbon;
use PDF;
use DB;
use Illuminate\Support\Collection;
use Auth;
use CURLFile;
use Illuminate\Support\Facades\File;
use Modules\Poli\Entities\Poli;
use Flashy;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class FarmasiController extends Controller
{

	// Eresep Belum tervalidasi
	public function datalcderesep($unit = null)
	{

		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}

		$data_belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('proses', 'belum_diproses')->orderBy('id', 'ASC')->get();

		$data_sudah_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', '!=', 'belum_diproses')->orderBy('id', 'ASC')->get();

		$belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'belum_diproses')->where('notif_play', '0')->get();


		// $data_belum_dipanggil = $data = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('proses','belum_diproses')->orderBy('id','DESC')->get(); 
		return view('farmasi.data_lcd_eresep', compact('belum_diproses', 'data_sudah_diproses', 'data_belum_diproses', 'unit'));
	}

	public function lcderesep($unit = null)
	{
		return view('farmasi.lcd_eresep', compact('unit'));
	}


	public function datalcdereseppasien($unit = null)
	{

		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}
		$data_belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereIn('proses', ['belum_diproses', 'diproses'])->orderBy('id', 'ASC')->get();
			
		$data_sudah_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'selesai')->orderBy('id', 'ASC')->get();

		$belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'belum_diproses')->where('notif_play', '0')->get();

		$sedang_dipanggil_bpjs = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereNull('kelompok')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		$sedang_dipanggil_umum = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('kelompok', 'U')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		// $data_belum_dipanggil = $data = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('proses','belum_diproses')->orderBy('id','DESC')->get(); 
		return view('farmasi.data_lcd_eresep_pasien', compact('belum_diproses', 'data_sudah_diproses', 'data_belum_diproses', 'unit', 'sedang_dipanggil_bpjs', 'sedang_dipanggil_umum'));
	}
	public function datalcdereseppasiennew($unit = null)
	{

		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}
		$sedang_dipanggil_bpjs = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereNull('kelompok')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		$data_belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereNull('kelompok')
			->whereNotNull('antrian_dipanggil')
			->whereIn('proses', ['belum_diproses','selesai', 'diproses'])
			->where('nomor', '<', $sedang_dipanggil_bpjs->nomor)
			->orderBy('nomor', 'DESC') // ambil dari atas ke bawah dulu
			->limit(10)
			->get();
			// ->sortBy('nomor') // urutkan naik (55 - 64)
			// ->values(); // reset key

		$data_sudah_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'selesai')->orderBy('id', 'ASC')->get();
			

		

		$sedang_dipanggil_umum = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('kelompok', 'U')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		// $data_belum_dipanggil = $data = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('proses','belum_diproses')->orderBy('id','DESC')->get(); 
		return view('farmasi.data_lcd_eresep_pasien_new', compact('data_sudah_diproses', 'data_belum_diproses', 'unit', 'sedang_dipanggil_bpjs', 'sedang_dipanggil_umum'));
	}

	public function datalcdereseppasienumum($unit = null)
	{

		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}
		$data_belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereIn('proses', ['belum_diproses', 'diproses'])->orderBy('id', 'ASC')->get();

		$data_sudah_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'selesai')->orderBy('id', 'ASC')->get();

		$belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'belum_diproses')->where('notif_play', '0')->get();

		$sedang_dipanggil_umum = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('kelompok', 'U')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		$sedang_dipanggil_racik = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('kelompok', 'U')
			->where('jenis_resep', 'racikan')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		$sedang_dipanggil_nonracik = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('kelompok', 'U')
			->where('jenis_resep', 'tunggal')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		// $data_belum_dipanggil = $data = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('proses','belum_diproses')->orderBy('id','DESC')->get(); 
		return view('farmasi.data_lcd_eresep_pasien_umum', compact('belum_diproses', 'data_sudah_diproses', 'data_belum_diproses', 'unit', 'sedang_dipanggil_umum', 'sedang_dipanggil_racik', 'sedang_dipanggil_nonracik'));
	}

	public function lcdereseppasien($unit = null)
	{
		return view('farmasi.lcd_eresep_pasien', compact('unit'));
	}
	public function lcdereseppasiennew($unit = null)
	{
		return view('farmasi.lcd_eresep_pasien_new', compact('unit'));
	}

	public function lcdereseppasienumum($unit = null)
	{
		return view('farmasi.lcd_eresep_pasien_umum', compact('unit'));
	}

	public function suaraereseppasien($unit = null)
	{
		return view('farmasi.suara_eresep_pasien', compact('unit'));
	}

	public function datasuaraereseppasien($unit = null)
	{
		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}

		$sedang_dipanggil_umum = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->where('kelompok', 'U')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		$sedang_dipanggil_bpjs = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereNull('kelompok')
			->where('panggil', 1)
			->whereIn('proses', ['belum_diproses', 'diproses', 'selesai'])->orderBy('id', 'DESC')->first();

		return view('farmasi.data_suara_eresep_pasien', compact('unit', 'sedang_dipanggil_umum', 'sedang_dipanggil_bpjs'));
	}

	public function displaylcderesep($unit = null)
	{
		// dd('display to pasien');
		$unit = 'jalan';
		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}

		$data_belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_done_input', '1')
			->whereIn('proses', ['belum_diproses', 'diproses'])->orderBy('id', 'ASC')->get();

		$data_sudah_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', '!=', 'belum_diproses')->orderBy('id', 'ASC')->get();

		$belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('proses', 'belum_diproses')->where('notif_play', '0')->get();

		return view('farmasi.display_eresep', compact('unit', 'belum_diproses', 'data_sudah_diproses', 'data_belum_diproses', 'unit'));
	}

	public function panggilAntrianEresep($id)
	{
		
		

		$eresep = ResepNote::find($id);
		@updateTaskId(7,$eresep->registrasi->nomorantrian);//RUN TASKID 7
		
		// Update panggil = 0 agar tidak muncul di display antrian ERESEP
		if (empty($eresep->kelompok)) {
			ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('panggil', 1)->whereNull('kelompok')->update([
				"panggil" => 0
			]);
		} elseif ($eresep->kelompok == 'U') {
			ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('panggil', 1)->where('kelompok', 'U')->update([
				"panggil" => 0
			]);
		}

		// Ketika memanggil salah 1 antrian, Eresep yang telah selesai diproses juga otomatis update kolom antrian_dipanggil.
		ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('status', 'selesai')->where('proses', 'selesai')->whereNull('antrian_dipanggil')->update([
			"antrian_dipanggil" => now()->format('Y-m-d H:i:s')
		]);

		$data = [
			"panggil" => 1,
			"panggil_play" => 0,
			"antrian_dipanggil" => now()->format('Y-m-d H:i:s')
		];

		if ($eresep->update($data)) {
			// return response()->json(['sukses' => true]);
			Flashy::success('Berhasil memanggil antrian');
			return redirect()->back();
		}
		Flashy::success('Gagal memanggil antrian');
		return response()->json(['sukses' => false]);
	}

	// lcd khusus tervalidasi eresep
	public function validasidatalcderesep($unit = null)
	{
		if ($unit == 'jalan') {
			$uuid = 'ERJ';
		} elseif ($unit == 'inap') {
			$uuid = 'ERI';
		} elseif ($unit == 'igd') {
			$uuid = 'ERD';
		}
		// data telah diverifikasi
		$data_belum_diproses = ResepNote::
			// where('created_at', 'LIKE', date('Y-m-d') . '%')
			where('uuid', 'LIKE', $uuid . '%')
			->where('is_validate', '1')->where('proses', 'diproses')->orderBy('id', 'DESC')->get();
		// data telah terkirim
		$data_sudah_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_validate', '1')->where('proses', 'selesai')->orderBy('id', 'DESC')->get();


		$belum_diproses = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('uuid', 'LIKE', $uuid . '%')
			->where('is_validate', '1')
			->where('is_done_input', '1')
			->where('notif_play', '0')->get();


		// $data_belum_dipanggil = $data = ResepNote::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('proses','belum_diproses')->orderBy('id','DESC')->get(); 
		return view('farmasi.validasi_data_lcd_eresep', compact('belum_diproses', 'data_sudah_diproses', 'data_belum_diproses'));
	}
	public function validasilcderesep($unit = null)
	{
		return view('farmasi.validasi_lcd_eresep', compact('unit'));
	}


	public function prosesEresep($id)
	{
		$data = ResepNote::where('id', $id)->first();
		if ($data) {
			$data->proses = 'diproses';
			$data->save();
		}
		Flashy::success('Eresep Diproses');
		return redirect('/farmasi/lcd-eresep');
	}
	public function updateDetail()
	{
		$no_resep = Penjualan::all();
		foreach ($no_resep as $d) {
			$reg = Registrasi::find($d->registrasi_id);
			$ct = Penjualandetail::where('no_resep', $d->no_resep)->count();
			$det = Penjualandetail::where('no_resep', $d->no_resep)->first();
			$dtl = Penjualandetail::where(['masterobat_id' => 2437, 'no_resep' => $d->no_resep])->count();
			if ($reg['bayar'] == 2) { // UMUM tarif 200
				if ($ct > 0 && $dtl == 0) {
					$new = new Penjualandetail();
					$new->penjualan_id = $det['penjualan_id'];
					$new->no_resep = $d->no_resep;
					$new->masterobat_id = 2437;
					$new->jumlah = $ct;
					$new->hargajual = 200;
					$new->cetak = 'Y';
					$new->save();
					echo $d->no_resep . '  ' . $ct . '  ' . $det['penjualan_id'] . ' Umum<br/><br/>';
				}
			} else {
				if ($ct > 0 && $dtl == 0) {
					$new = new Penjualandetail();
					$new->penjualan_id = $det['penjualan_id'];
					$new->no_resep = $d->no_resep;
					$new->masterobat_id = 2437;
					$new->jumlah = $ct;
					$new->hargajual = 300;
					$new->cetak = 'Y';
					$new->save();
					echo $d->no_resep . '  ' . $ct . '  ' . $det['penjualan_id'] . ' JKN<br/><br/>';
				}
			}
		}
	}

	public function updateFolios()
	{
		$no_resep = Penjualan::offset(4200)->limit(500)->get();
		$detl = [];
		foreach ($no_resep as $d) {
			$total = 0;
			$det = Penjualandetail::select('jumlah', 'hargajual')->where('no_resep', $d->no_resep)->sum('hargajual');

			$fol = Folio::where(['namatarif' => $d->no_resep, 'total' => $det])->count();
			if ($fol > 0) {
				echo $d->no_resep . '   Sudah Sama = ' . $det . '<br/>';
			} else {
				Folio::where('namatarif', $d->no_resep)->update(['total' => $det]);
				echo $d->no_resep . '   Belum Sama = ' . $det . '<br/>';
			}
		}
	}

	public function lap_farmasi()
	{
		$data['penjualan'] = Penjualan::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		return view('farmasi.laporan.penjualan', $data);
	}

	public function lap_farmasi_byTanggal(Request $request)
	{
		request()->validate(['tga' => 'required']);
		$penjualan = Penjualan::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		if ($penjualan->count() < 0) {
			return redirect('farmasi/laporan/penjualan');
		} else {
			foreach ($penjualan as $key => $d) {
				if (Folio::where('namatarif', $d->no_resep)->count() < 1) {
					Penjualandetail::where('no_resep', $d->no_resep)->delete();
					Penjualan::where('no_resep', $d->no_resep)->delete();
				}
			}
			$data['penjualan'] = Penjualan::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
			return view('farmasi.laporan.penjualan', $data);
		}
	}

	public function cetak_etiket($penjualan_id = '')
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['resep_dokter'] = ResepNote::with('resep_detail')->where('penjualan_id', $penjualan_id)->first();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['ranap'] = Rawatinap::where('registrasi_id', $data['penjualan']->registrasi_id)->first();
		return view('farmasi.laporan.etiket-pdf-baru', $data);
		// $pdf = PDF::loadView('farmasi.laporan.etiket-pdf', $data)->setPaper([0, 0, 99.212598, 141.732283], 'landscape');;
		// return $pdf->stream();
	}
	public function cetak_etiket2($penjualan_id = '')
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['resep_dokter'] = ResepNote::with('resep_detail')->where('penjualan_id', $penjualan_id)->first();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['ranap'] = Rawatinap::where('registrasi_id', $data['penjualan']->registrasi_id)->first();
		return view('farmasi.laporan.etiket-pdf-baru2', $data);
		// $pdf = PDF::loadView('farmasi.laporan.etiket-pdf', $data)->setPaper([0, 0, 99.212598, 141.732283], 'landscape');;
		// return $pdf->stream();
	}

	public function cetak_infus($penjualan_id = '')
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['resep_dokter'] = ResepNote::with('resep_detail')->where('penjualan_id', $penjualan_id)->first();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		return view('farmasi.laporan.infus-pdf', $data);
	}

	public function cetak_etiket_bebas($penjualan_id = '')
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		return view('farmasi.laporan.etiket_bebas', $data);
	}

	public function cetakDetail($penjualan_id = '', Request $request)
	{
		session()->forget('penjualanid');
		$data['faktur'] = false;
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id);
		$data['obat']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', '!=', 4);
		$data['alkes']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', 4);

		// Jika ada faktur maka cetak penjualan khusus non kronis
		if ($request->faktur) {
			$data['detail']->where('is_kronis', 'N');
			$data['obat']->where('is_kronis', 'N');
			$data['alkes']->where('is_kronis', 'N');
			$data['faktur'] = true;
		}

		$data['detail'] = $data['detail']->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as hargaTotal'))->get();
		$data['obat'] = $data['obat']->sum('penjualandetails.hargajual');
		$data['alkes'] = $data['alkes']->sum('penjualandetails.hargajual');
		$data['total'] = $data['detail']->sum('hargaTotal');
		$data['uang_racik'] = $data['detail']->sum('uang_racik');

		// return $data; die;,
		return view('farmasi.laporan.detail', $data)->with('no', 1);
	}

	public function cetakDetailOperasi($penjualan_id = '')
	{
		session()->forget('penjualanid');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['obat']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', '!=', 4)
			->sum('penjualandetails.hargajual');
		$data['alkes']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', 4)
			->sum('penjualandetails.hargajual');
		$data['total'] = $data['detail']->sum('hargajual');
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		// return $data; die;,
		return view('farmasi.laporan.detailOperasi', $data)->with('no', 1);
	}


	public function prosesUlangEresep()
	{
		$data['resep_note'] = ResepNote::whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])->where('proses', 'belum_diproses')->get();
		// dd($resep_note);
		// return $data; die;,
		return view('farmasi.eresep_belum_diproses', $data)->with('no', 1);
	}
	public function prosesUlangEresepByTgl(Request $request)
	{
		$data['resep_note'] = ResepNote::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->where('proses', 'belum_diproses')->get();
		// dd($resep_note);
		// return $data; die;,
		return view('farmasi.eresep_belum_diproses', $data)->with('no', 1);
	}

	public function eresepCetak()
	{
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		$uuid = 'ERJ';
		// if($unit == 'jalan'){$uuid = 'ERJ';}
		// elseif($unit == 'inap'){$uuid = 'ERI';}
		// elseif($unit == 'igd'){$uuid = 'ERD';}
		// $data['antrianBelumDipanggil'] = ResepNote::where('uuid', 'LIKE', $uuid . '%')
		// 	->with(['registrasi', 'registrasi.poli', 'registrasi.pasien'])
		// 	->where('is_done_input', '1')
		// 	->where('notif_play', '0')
		// 	->where('panggil', '!=', '1')
		// 	->where('panggil_play', '0')
		// 	->whereNotNull('nomor')
		// 	->where('created_at', 'LIKE', date('Y-m-d') . '%')
		// 	->orderBy('id', 'ASC')
		// 	->select([
		// 		'id',
		// 		'uuid',
		// 		'registrasi_id',
		// 		'kelompok',
		// 		'nomor',
		// 		'created_at'
		// 	])
		// 	->get();

		// $data['antrianSudahDipanggil'] = ResepNote::where('uuid', 'LIKE', $uuid . '%')
		// 	->with(['registrasi', 'registrasi.poli', 'registrasi.pasien'])
		// 	->where('is_done_input', '1')
		// 	->where(function($query){
		// 		$query->where('notif_play', '!=', '0')
		// 		->orWhere('panggil_play', '1');
		// 	})
		// 	->whereNotNull('nomor')
		// 	->where('created_at', 'LIKE', date('Y-m-d') . '%')
		// 	->orderBy('id', 'ASC')
		// 	->select([
		// 		'id',
		// 		'uuid',
		// 		'registrasi_id',
		// 		'kelompok',
		// 		'nomor',
		// 		'created_at'
		// 	])
		// 	->get();
		// dd($resep_note);
		// return $data; die;,
		return view('farmasi.eresep_cetak')->with('no', 1);
	}
	public function eresepPrint($id)
	{
		$data['resep_note'] = ResepNote::find($id);
		$data['reg'] = Registrasi::find($data['resep_note']->registrasi_id);
		$data['rencana_kontrol'] = RencanaKontrol::where('registrasi_id', $data['reg']->id)->orderBy('id', 'DESC')->first();
		if($data['reg']->nomorantrian){
			@updateTaskId(5,$data['reg']->nomorantrian);//RUN TASKID 5
		}
		// dd($resep_note);
		// return $data; die;
		return view('farmasi.cetak-antrian-eresep', $data)->with('no', 1);
	}
	public function eresepCetakByTgl(Request $request)
	{
		$uuid = 'ERJ';

		$data['antrianBelumDipanggil'] = ResepNote::where('uuid', 'LIKE', $uuid . '%')
			->with(['registrasi', 'registrasi.poli', 'registrasi.pasien'])
			->where('created_at', 'LIKE',valid_date($request['tgb']).'%')
			->where('is_done_input', '1')
			->where('notif_play', '0')
			->where('panggil', '!=', '1')
			->where('panggil_play', '0')
			->whereNotNull('nomor')
			->orderBy('id', 'ASC')
			->select([
				'id',
				'uuid',
				'registrasi_id',
				'kelompok',
				'nomor',
				'created_at'
			])
			->limit(10)
			->get();

		$data['antrianSudahDipanggil'] = ResepNote::where('uuid', 'LIKE', $uuid . '%')
			->with(['registrasi', 'registrasi.poli', 'registrasi.pasien'])
			->where('created_at', 'LIKE',valid_date($request['tgb']).'%')
			->where('is_done_input', '1')
			->where(function($query){
				$query->where('notif_play', '!=', '0')
				->orWhere('panggil_play', '1');
			})
			->whereNotNull('nomor')
			->orderBy('id', 'ASC')
			->select([
				'id',
				'uuid',
				'registrasi_id',
				'kelompok',
				'nomor',
				'created_at'
			])
			->limit(10)
			->get();
		// dd($data['resep_note']);
		// return $data; die;,
		return view('farmasi.eresep_cetak', $data)->with('no', 1);
	}

	public function getDataEresepCetakBelumPanggil(){
		// ini_set('max_execution_time', 0);
		// ini_set('memory_limit', '8000M');

		$uuid = 'ERJ';

		$antrian = ResepNote::where('uuid', 'LIKE', $uuid . '%')
			->with(['registrasi', 'registrasi.poli', 'registrasi.pasien'])
			->where('is_done_input', '1')
			// ->where('notif_play', '0')
			// ->where('panggil', '!=', '1')
			// ->where('panggil_play', '0')
			->whereNull('antrian_dipanggil')
			->whereNotNull('nomor')
			->where('created_at', 'LIKE', date('Y-m-d') . '%')
			->orderBy('id', 'ASC')
			->select([
				'id',
				'uuid',
				'registrasi_id',
				'kelompok',
				'nomor',
				'created_at'
			]);

			return DataTables::of($antrian)
				->addColumn('panggil', function ($antrian){
					return '<a href="'.url('/farmasi/panggil-antrian/'.$antrian->id).'" class="btn btn-info btn-sm"><i class="fa fa-microphone"></i></a>';
				})
				->addColumn('antrian', function ($antrian){
					return $antrian->kelompok ? $antrian->kelompok.''.$antrian->nomor : $antrian->nomor;
				})
				->addColumn('cetak', function ($antrian){
					return '<a href="'.url('/farmasi/eresep-print/'.$antrian->id).'" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>';
				})
				->rawColumns(['panggil','cetak'])
				->make(true);
		
	}

	public function getDataEresepCetakSudahPanggil(){
		// ini_set('max_execution_time', 0);
		// ini_set('memory_limit', '8000M');

		$uuid = 'ERJ';

		$antrian = ResepNote::where('uuid', 'LIKE', $uuid . '%')
			->with(['registrasi', 'registrasi.poli', 'registrasi.pasien'])
			->where('is_done_input', '1')
			// ->where(function($query){
			// 	$query->where('notif_play', '!=', '0')
			// 	->orWhere('panggil_play', '!=', '0')
			// 	->orWhere('panggil', '1');
			// })
			->whereNotNull('antrian_dipanggil')
			->whereNotNull('nomor')
			->where('created_at', 'LIKE', date('Y-m-d') . '%')
			->orderBy('id', 'ASC')
			->select([
				'id',
				'uuid',
				'registrasi_id',
				'kelompok',
				'nomor',
				'created_at'
			]);

		return DataTables::of($antrian)
			->addColumn('panggil', function ($antrian){
				return '<a href="'.url('/farmasi/panggil-antrian/'.$antrian->id).'" class="btn btn-info btn-sm"><i class="fa fa-microphone"></i></a>';
			})
			->addColumn('antrian', function ($antrian){
				return $antrian->kelompok ? $antrian->kelompok.''.$antrian->nomor : $antrian->nomor;
			})
			->addColumn('cetak', function ($antrian){
				return '<a href="'.url('/farmasi/eresep-print/'.$antrian->id).'" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>';
			})
			->rawColumns(['panggil','cetak'])
			->make(true);

			

	}
	public function cetakDetailVedika($registrasi_id = '')
	{
		session()->forget('penjualanid');
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['penjualan'] = Penjualan::where('registrasi_id', $data['reg']->id)->get();
		$data['total'] = Folio::where('registrasi_id', $data['reg']->id)->where('tarif_id', 10000)->sum('total');
		return view('farmasi.laporan.detail-vedika', $data)->with('no', 1);
	}

	public function cetakDetailKronis($penjualan_id = '')
	{
		session()->forget('penjualanid');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		// return $data['penjualan']; die;
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->where('is_kronis', 'Y')->get();
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		$data['total'] = $data['detail']->sum('hargajual');
		$data['alkes']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', 4)
			->where('is_kronis', 'Y')
			->sum('penjualandetails.hargajual');
		$no = 1;
		return view('farmasi.laporan.fakturkronis-new', $data)->with('no', 1);
		// $pdf = PDF::loadView('farmasi.laporan.fakturkronis', $data, compact('no'));
	}

	public function cetakDetailBebas($penjualan_id = '')
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['pasien'] = \App\Penjualanbebas::where('registrasi_id', $data['reg']->id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['total'] = $data['detail']->sum('hargajual');
		$data['total_uang_racik'] = $data['detail']->sum('uang_racik');
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		return view('farmasi.laporan.detailBebasNew', $data)->with('no', 1);
	}

	public function hapusLaporan($no_faktur)
	{
		Penjualandetail::where('no_resep', $no_faktur)->delete();
		Penjualan::where('no_resep', $no_faktur)->delete();
		return redirect('farmasi/laporan/penjualan');
	}

	//LAPORAN FARMASI Update Maret 2019
	public function laporanKinerjaFarmasi()
	{
		return view('farmasi.laporan.kinerjaFarmasi');
	}

	public function dataLaporanKinerjaFarmasi(Request $request)
	{
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		request()->validate([
			'tglAwal' => 'required',
			'tglAkhir' => 'required',
		]);

		$tglAwal  = valid_date($request['tglAwal']) . ' 00:00:00';
		$tglAkhir = valid_date($request['tglAkhir']) . ' 23:59:59';
		$dokter   = $request['dokter'];
		// $user  = Auth::user()->id;

		if ($request['jenis'] == 'TA') {
			$jenis = 'FRJ';
		} elseif ($request['jenis'] == 'TI') {
			$jenis = 'FRI';
		} elseif ($request['jenis'] == 'TG') {
			$jenis = 'FRD';
		} elseif ($request['jenis'] == 'TL') {
			$jenis = 'FPB';
		} elseif ($request['jenis'] == '2') {
			$jenis = '2';
		}


		if ($jenis == 'FPB') {
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->where('folios.namatarif', 'LIKE', 'FPB' . '%')
				->where('folios.namatarif', '!=', 'Retur Penjualan')
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.total', '<>', 0)


				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			$datas['data'] = $datas['data']->get();
			// dd($datas['data']);
			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi_pl', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.kinerjaFarmasi', $datas);
			} elseif ($request['submit'] == 'excel') {
				Excel::create('Laporan Kinerja Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan Kinerja Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Kinerja Farmasi');
					$excel->sheet('Laporan Kinerja Farmasi', function ($sheet) use ($datas, $jenis) {
						$baris = 1;
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'user',
							'Nama',
							'Alamat',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajualtotal;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								@$pasien ? @$pasien->alamat : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),
								!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
								baca_obat($d->obat),
								$d->jumlah,
								$d->hargajualtotal,

							]);
						}
						$sheet->row($baris + 3, [
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'Total =',
							$sum,
						]);
					});
				})->export('xlsx');
			}
		} elseif ($jenis == '2') {
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->where('folios.gudang_id', $jenis)
				->where('folios.cara_bayar_id', $request['cara_bayar_id'])
				->where('folios.namatarif', '!=', 'Retur Penjualan')
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.total', '<>', 0)

				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			$datas['data'] = $datas['data']->get();

			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi_pl', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.kinerjaFarmasi', $datas);
			} elseif ($request['submit'] == 'excel') {
				Excel::create('Laporan Kinerja Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan Kinerja Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Kinerja Farmasi');
					$excel->sheet('Laporan Kinerja Farmasi', function ($sheet) use ($datas, $jenis) {
						$baris = 1;
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'user',
							'Nama',
							'Alamat',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajualtotal;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								@$pasien ? @$pasien->alamat : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),
								!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
								baca_obat($d->obat),
								$d->jumlah,
								$d->hargajualtotal,

							]);
						}
						$sheet->row($baris + 3, [
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'Total =',
							$sum,
						]);
					});
				})->export('xlsx');
			}
		} else {
			$dokter = \Modules\Pegawai\Entities\Pegawai::select('id')->get();
			$di = [];
			foreach ($dokter as $key => $d) {
				$di[] = '' . $d->id . '';
			}
			$dokters = $request->dokter;
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->where('folios.namatarif', 'LIKE', $jenis . '%')
				->where('folios.cara_bayar_id', $request['cara_bayar_id'])
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.namatarif', '!=', 'Retur Penjualan')
				->where('folios.total', '<>', 0)
				->where('folios.gudang_id', '<>', 2)
				->where('folios.user_id', '<>', 610)

				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			$datas['data'] = $datas['data']->get();

			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.kinerjaFarmasi', $datas);
			} elseif ($request['submit'] == 'excel') {
				$jenis = $request['jenis'];



				Excel::create('Laporan Kinerja Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan Kinerja Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Kinerja Farmasi');
					$excel->sheet('Laporan Kinerja Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$baris = 1;
						$sheet->row($row, [
							'No',
							'user',
							'Nama',
							'No. RM',
							'Alamat',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajualtotal;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								@$pasien ? @$pasien->alamat : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),
								!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
								baca_obat($d->obat),
								$d->jumlah,
								$d->hargajualtotal,

							]);
						}
						$sheet->row($baris + 3, [
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'Total =',
							$sum,
						]);
					});
				})->export('xlsx');
			}
		}
	}










	public function laporanResepFarmasi()
	{
		$data['userFarmasi'] = User::join('folios', 'folios.user_id', '=', 'users.id')
			->groupBy('folios.user_id')
			->where('folios.jenis', 'ORJ')
			->select('users.id as user_id')
			->get();
		$data['kelompok_kelas'] = Kelompokkelas::pluck('kelompok', 'id');
		return view('farmasi.laporan.ResepFarmasi', $data);
	}

	public function dataLaporanResepFarmasi(Request $request)
	{
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		request()->validate([
			'tglAwal' => 'required',
			'tglAkhir' => 'required',
		]);

		$tglAwal  = valid_date($request['tglAwal']) . ' 00:00:00';
		$tglAkhir = valid_date($request['tglAkhir']) . ' 23:59:59';
		$dokter   = $request['dokter'];
		$kelompok_kelas   = $request['kelompok_kelas'];
		$datas['userFarmasi'] = User::join('folios', 'folios.user_id', '=', 'users.id')
			->groupBy('folios.user_id')
			->where('folios.jenis', 'ORJ')
			->select('users.id as user_id')
			->get();
		$datas['kelompok_kelas'] = Kelompokkelas::pluck('kelompok', 'id');

		// $user  = Auth::user()->id;

		if ($request['jenis'] == 'TA') {
			$jenis = 'FRJ';
		} elseif ($request['jenis'] == 'TI') {
			$jenis = 'FRI';
		} elseif ($request['jenis'] == 'TG') {
			$jenis = 'FRD';
		} elseif ($request['jenis'] == 'TL') {
			$jenis = 'FPB';
		} elseif ($request['jenis'] == '2') {
			$jenis = '2';
		}


		if ($jenis == 'FPB') {
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->where('folios.namatarif', 'LIKE', 'FPB' . '%')
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.total', '<>', 0)
				->where('folios.gudang_id', '<>', 2)
				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->groupBy('folios.namatarif')
				->selectRaw('folios.registrasi_id, folios.namatarif as no_resep, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual * penjualandetails.jumlah as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			if (isset($kelompok_kelas)) {
				$datas['data']   = $datas['data']->join('rawatinaps', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')->where('rawatinaps.kelompokkelas_id', $kelompok_kelas);
			}
			$datas['data'] = $datas['data']->get();
			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi_pl', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.ResepFarmasi', $datas);
			} elseif ($request['submit'] == 'excel') {
				Excel::create('Laporan Lembar Resep Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan Lembar Resep Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Lembar Resep Farmasi');
					$excel->sheet('Laporan Lembar Resep Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'No Resep',
							'user',
							'Nama',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',

						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajual;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								$d->no_resep,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y H:i:s'),


							]);
						}
					});
				})->export('xlsx');
			}
		} elseif ($jenis == '2') {
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->where('folios.gudang_id', $jenis)
				->where('folios.cara_bayar_id', $request['cara_bayar_id'])
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.total', '<>', 0)
				->groupBy('folios.namatarif')
				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.gudang_id , folios.namatarif as no_resep, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual * penjualandetails.jumlah as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			if (isset($kelompok_kelas)) {
				$datas['data']   = $datas['data']->join('rawatinaps', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')->where('rawatinaps.kelompokkelas_id', $kelompok_kelas);
			}
			$datas['data'] = $datas['data']->get();

			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi_pl', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');


				// dd($datas);



				return view('farmasi.laporan.ResepFarmasi', $datas);
			} elseif ($request['submit'] == 'excel') {
				Excel::create('Laporan Lembar Resep Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan Lembar Resep Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Lembar Resep Farmasi');
					$excel->sheet('Laporan Lembar Resep Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'No Resep',
							'user',
							'Nama',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajual;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								str_replace("FRI", "FRO", $d->no_resep),
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),

							]);
						}
					});
				})->export('xlsx');
			}
		} else {
			$dokter = \Modules\Pegawai\Entities\Pegawai::select('id')->get();
			$di = [];
			foreach ($dokter as $key => $d) {
				$di[] = '' . $d->id . '';
			}
			$dokters = $request->dokter;
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->where('folios.namatarif', 'LIKE', $jenis . '%')
				->where('folios.cara_bayar_id', $request['cara_bayar_id'])
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.gudang_id', '<>', 2)
				->where('folios.total', '<>', 0)
				->groupBy('folios.namatarif')
				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif as no_resep, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual * penjualandetails.jumlah as hargajualtotal, penjualandetails.jumlah as jumlah, penjualandetails.penjualan_id as penjualanId');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			// dd($kelompok_kelas);
			if (isset($kelompok_kelas)) {
				$datas['data']   = $datas['data']->join('rawatinaps', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')->where('rawatinaps.kelompokkelas_id', $kelompok_kelas);
			}
			$datas['data'] = $datas['data']->get();

			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.ResepFarmasi', $datas);
			} elseif ($request['submit'] == 'excel') {
				$jenis = $request['jenis'];



				Excel::create('Laporan Lembar Resep Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan Lembar Resep Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Lembar Resep Farmasi');
					$excel->sheet('Laporan Lembar Resep Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'No Resep',
							'user',
							'Nama',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',

						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajual;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								$d->no_resep,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y H:i:s'),


							]);
						}
					});
				})->export('xlsx');
			}
		}
	}








	public function laporanResponseTime(Request $request)
	{
		$data['poli']       = Poli::all();
		$data['poli_id']    = '';
		$data['tga']        = Carbon::now()->format('d-m-Y');
		$data['tgb']        = Carbon::now()->format('d-m-Y');
		$tga                = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
		$tgb                = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
		// $data['respon']     = Penjualan::
		// leftjoin('registrasis', 'registrasis.id', '=', 'penjualans.registrasi_id')
		//     ->leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		//     ->leftjoin('antrian_farmasis', 'antrian_farmasis.registrasi_id', '=', 'penjualans.registrasi_id')
		//     ->where('penjualans.no_resep', 'LIKE', 'FRJ%')
		//     ->select('antrian_farmasis.created_at as mulai_antri', 'antrian_farmasis.processed_at as waktu_masuk_resep','registrasis.poli_id','registrasis.id as reg_id', 'pasiens.nama', 'pasiens.no_rm', 'penjualans.*')
		//     ->whereBetween('penjualans.created_at', [$tga, $tgb])
		//     ->get();
		// $data['respon']     = AntrianFarmasi::leftJoin('registrasis', 'registrasis.id', '=', 'antrian_farmasis.registrasi_id')
		// 	->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	// ->whereNotNull('registrasi_id')
		// 	->whereBetween('antrian_farmasis.created_at', [$tga, $tgb])
		// 	->select('antrian_farmasis.created_at as mulai_antri', 'antrian_farmasis.processed_at as waktu_masuk_resep', 'antrian_farmasis.finished_at as waktu_serah_obat', 'registrasis.poli_id', 'registrasis.id as reg_id', 'pasiens.nama', 'pasiens.no_rm')
		// 	->get();

		$data['respon'] = ResepNote::with('penjualans')->leftJoin('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'resep_note.pasien_id')
			->whereBetween('resep_note.created_at', [$tga, $tgb])
			->select('registrasis.id as registrasi_id', 'pasiens.nama as nama_pasien', 'pasiens.no_rm as no_rm_pasien', 'resep_note.*')
			->get();
		return view('farmasi.laporan.response-time', $data);
	}
	public function filterLaporanResponseTime(Request $request)
	{
		$request->validate([
			'tga'   => 'required',
			'tgb'   => 'required'
		]);
		$data['poli']       = Poli::select('nama', 'id')->get();
		$data['poli_id']    = $request->poli_id;
		$data['tga']        = Carbon::parse($request->tga)->format('d-m-Y');
		$data['tgb']        = Carbon::parse($request->tgb)->format('d-m-Y');
		$tga                = Carbon::parse($request->tga)->startOfDay()->format('Y-m-d H:i:s');
		$tgb                = Carbon::parse($request->tgb)->endOfDay()->format('Y-m-d H:i:s');
		// $data['respon']     = Penjualan::
		//     leftjoin('registrasis', 'registrasis.id', '=', 'penjualans.registrasi_id')
		//     ->leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		//     ->leftjoin('antrian_farmasis', 'antrian_farmasis.registrasi_id', '=', 'penjualans.registrasi_id')
		//     ->where('penjualans.no_resep', 'LIKE', 'FRJ%')
		//     ->select('antrian_farmasis.created_at as mulai_antri', 'registrasis.poli_id','registrasis.id as reg_id', 'pasiens.nama', 'pasiens.no_rm', 'penjualans.*')
		//     ->whereBetween('penjualans.created_at', [$tga, $tgb]);
		// $data['respon']     = AntrianFarmasi::leftjoin('registrasis', 'registrasis.id', '=', 'antrian_farmasis.registrasi_id')
		// 	->leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	// ->whereNotNull('registrasi_id')
		// 	->whereBetween('antrian_farmasis.created_at', [$tga, $tgb])
		// 	->select('antrian_farmasis.created_at as mulai_antri', 'antrian_farmasis.processed_at as waktu_masuk_resep', 'antrian_farmasis.finished_at as waktu_serah_obat', 'registrasis.poli_id', 'registrasis.id as reg_id', 'pasiens.nama', 'pasiens.no_rm');

		$data['respon'] = ResepNote::with('penjualans')->leftJoin('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
			->leftJoin('pasiens', 'pasiens.id', '=', 'resep_note.pasien_id')
			->whereBetween('resep_note.created_at', [$tga, $tgb])
			->select('registrasis.id as registrasi_id', 'pasiens.nama as nama_pasien', 'pasiens.no_rm as no_rm_pasien', 'resep_note.*');

		if ($data['poli_id'] != null || $data['poli_id'] != '') {
			$data['respon']->where('resep_note.poli_id', $data['poli_id']);
		}
		
		$data['respon'] = $data['respon']->get();
		if ($request['excel'] == 'EXCEL') {
			Excel::create('Lap Response Time Farmasi IRJ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Lap Response Time Farmasi IRJ')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Response Time Farmasi IRJ');
				$excel->sheet('Lap Response Time Farmasi IRJ', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'NO RM',
						'NAMA PASIEN',
						'POLI',
						'Tanggal',
						'Waktu Antri',
						'Waktu Masuk Resep',
						'Waktu Serah Obat',
						'Response Time (Menit)',
						'Lama Pelayanan (Menit)',
					]);
					foreach ($data['respon'] as $key => $d) {
						$waktu_antri = Carbon::parse($d->created_at);
						$waktu_masuk_resep = $d->penjualans ? Carbon::parse($d->penjualans->created_at) : null;
						$waktu_serah_obat = $d->antrian_dipanggil ? Carbon::parse($d->antrian_dipanggil) : null;
						$lamaProsesObat = $waktu_masuk_resep && $waktu_serah_obat ? $waktu_masuk_resep->diffInMinutes($waktu_serah_obat) : null;
						$lamaPelayanan = $waktu_antri && $waktu_serah_obat ? $waktu_antri->diffInMinutes($waktu_serah_obat) : null;
						$sheet->row(++$row, [
							$no++,
							@$d->no_rm_pasien,
							@$d->nama_pasien,
							@baca_poli($d->poli_id),
							$waktu_antri ? $waktu_antri->format('d-m-Y') : '-',
							$waktu_antri ? $waktu_antri->format('H:i') : '-',
							$waktu_masuk_resep ? $waktu_masuk_resep->format('H:i') : '-',
							$waktu_serah_obat ? $waktu_serah_obat->format('H:i') : '-',
							$lamaProsesObat !== null ? $lamaProsesObat : '-',
							$lamaPelayanan !== null ? $lamaPelayanan : '-'
						]);
					}
				});
			})->export('xlsx');
		} else {
			return view('farmasi.laporan.response-time', $data);
		}
	}

	// LAPORAN ERESEP
	public function laporanEresep(Request $request)
	{
		$data['dokter']       = Pegawai::where('kategori_pegawai','1')->get();
		$data['dokter_id']    = '';
		$data['tga']        = Carbon::now()->format('d-m-Y');
		$data['tgb']        = Carbon::now()->format('d-m-Y');
		$tga                = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
		$tgb                = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
		
		$data['respon']     = [];
		return view('farmasi.laporan.eresep', $data);
	}
	public function filterLaporanEresep(Request $request)
	{
		$request->validate([
			'tga'   => 'required',
			'tgb'   => 'required'
		]);
		$data['dokter']       = Pegawai::where('kategori_pegawai','1')->get();
		$data['dokter_id']    = $request->dokter_id;
		$data['tga']        = Carbon::parse($request->tga)->format('d-m-Y');
		$data['tgb']        = Carbon::parse($request->tgb)->format('d-m-Y');
		$tga                = Carbon::parse($request->tga)->startOfDay()->format('Y-m-d H:i:s');
		$tgb                = Carbon::parse($request->tgb)->endOfDay()->format('Y-m-d H:i:s');
		// $data['respon']     = Penjualan::
		//     leftjoin('registrasis', 'registrasis.id', '=', 'penjualans.registrasi_id')
		//     ->leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		//     ->leftjoin('antrian_farmasis', 'antrian_farmasis.registrasi_id', '=', 'penjualans.registrasi_id')
		//     ->where('penjualans.no_resep', 'LIKE', 'FRJ%')
		//     ->select('antrian_farmasis.created_at as mulai_antri', 'registrasis.poli_id','registrasis.id as reg_id', 'pasiens.nama', 'pasiens.no_rm', 'penjualans.*')
		//     ->whereBetween('penjualans.created_at', [$tga, $tgb]);
		$data['respon']     = ResepNote::leftjoin('registrasis', 'registrasis.id', '=', 'resep_note.registrasi_id')
			->with(['resep_detail'])
			->whereNotNull('resep_note.penjualan_id')
			->whereBetween('registrasis.created_at', [$tga, $tgb])
			->select('registrasis.dokter_id','resep_note.penjualan_id','registrasis.poli_id','resep_note.id','registrasis.pasien_id');

		if ($data['dokter_id'] != null || $data['dokter_id'] != '') {
			$data['respon']->where('registrasis.dokter_id', $data['dokter_id']);
		}

		$data['respon'] = $data['respon']->get();
		// dd($data['respon']);
		if ($request['excel'] == 'EXCEL') {
			Excel::create('Lap EResep', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Lap EResep')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap EResep');
				$excel->sheet('Lap EResep', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Dokter',
						'Pasien',
						'Poli',
						'E-Resep',
						'Apotik',
						'INA-CBG',
						'Kronis',
					]);
					$total_obat_eresep = 0;
					$total_obat_apotik = 0;
					$total_obat_non_kronis = 0;
					$total_obat_kronis = 0;
					foreach ($data['respon'] as $key => $item) {
						$detail = [];
						$dataDetail = NULL;
						if($item->resep_detail){
							$total_obat_eresep_pasien = 0;
							foreach($item->resep_detail as $items){
								$totals = $items->qty*$items->logistik_batch->hargajual_jkn;
								$total_obat_eresep += $totals;
								$total_obat_eresep_pasien += $totals;
								$detail[] = $items->logistik_batch->nama_obat.' ('.$items->qty.')'.' ['.$totals.']';
							}
							$detail[] = "TOTAL: " . $total_obat_eresep_pasien;
							$dataDetail = implode("\n", $detail);
						}

						$penj = Penjualandetail::where('penjualan_id',$item->penjualan_id)->get();
						$penjDetail = [];
						$dataPenjDetail = NULL;
						if($penj){
							$total_obat_apotik_pasien = 0;
							foreach($penj as $items){
								$total_obat_apotik += $items->hargajual;
								$total_obat_apotik_pasien += $items->hargajual;
								$penjDetail[] = $items->logistik_batch_with_trashed->nama_obat.' ('.$items->jumlah.')'.' ['.$items->hargajual.']';
							}
							$penjDetail[] = "TOTAL: " . $total_obat_apotik_pasien;
							$dataPenjDetail = implode("\n", $penjDetail);
						}

						$non_kronis = Penjualandetail::where('penjualan_id',$item->penjualan_id)->where('is_kronis', 'N')->get();
						$nKDetail = [];
						$datanKDetail = NULL;
						if($non_kronis){
							$total_obat_non_kronis_pasien = 0;
							foreach($non_kronis as $items){
								$total_obat_non_kronis += $items->hargajual;
								$total_obat_non_kronis_pasien += $items->hargajual;
								$nKDetail[] = $items->logistik_batch_with_trashed->nama_obat.' ('.$items->jumlah.')'.' ['.$items->hargajual.']';
							}
							$nKDetail[] = "TOTAL: " . $total_obat_non_kronis_pasien;
							$datanKDetail = implode("\n", $nKDetail);
						}

						$kronis = Penjualandetail::where('penjualan_id',$item->penjualan_id)->where('is_kronis', 'Y')->get();
						$kDetail = [];
						$datakDetail = NULL;
						if($kronis){
							$total_obat_kronis_pasien = 0;
							foreach($kronis as $items){
								$total_obat_kronis += $items->hargajual;
								$total_obat_kronis_pasien += $items->hargajual;
								$kDetail[] = $items->logistik_batch_with_trashed->nama_obat.' ('.$items->jumlah.')'.' ['.$items->hargajual.']';
							}
							$kDetail[] = "TOTAL: " . $total_obat_kronis_pasien;
							$datakDetail = implode("\n", $kDetail);
						}

						$sheet->row(++$row, [
							$no++,
							@baca_dokter($item->dokter_id),
							@baca_pasien_rm($item->pasien_id),
							@baca_poli($item->poli_id),
							@$dataDetail,
							@$dataPenjDetail,
							@$datanKDetail,
							@$datakDetail,
							
						]);
					}

					$sheet->row($row++,[
						'',
						'',
						'',
						'',
						'Total EResep: '.(@$total_obat_eresep),
						'Total Apotik: '.(@$total_obat_apotik),
						'Total INA-CBG: '.(@$total_obat_non_kronis),
						'Total Kronis: '.(@$total_obat_kronis),
					]);
				});
			})->export('xlsx');
		} else {
			return view('farmasi.laporan.eresep', $data);
		}
	}





	//penjulan baru
	public function cetakDetailBaru($penjualan_id = '')
	{
		session()->forget('penjualanid');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['obat']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', '!=', 4)
			->sum('penjualandetails.hargajual');
		$data['alkes']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', 4)
			->sum('penjualandetails.hargajual');
		$data['total'] = $data['detail']->sum('hargajual');
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		// return $data; die;,
		return view('farmasi.laporan.detailBaru', $data)->with('no', 1);
	}

	public function cetakDetailKronisBaru($penjualan_id = '')
	{
		session()->forget('penjualanid');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		// return $data['penjualan']; die;
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		$data['total'] = $data['detail']->sum('hargajual_kronis');
		return view('farmasi.laporan.fakturkronisbaru', $data)->with('no', 1);
	}

	public function cetakDetailBebasBaru($penjualan_id = '')
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['pasien'] = \App\Penjualanbebas::where('registrasi_id', $data['reg']->id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->get();
		// $data['total'] = $data['detail']->sum('hargajual');
		$data['total_uang_racik'] = $data['detail']->sum('uang_racik');
		$data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();
		// dd($data['folio']);
		return view('farmasi.laporan.detailBebasNew', $data)->with('no', 1);
	}

	public function pemakaian_obat_harian()
	{
		return view('farmasi.laporan.pemakaian-obat-harian');
	}

	public function pemakaian_obat_byTanggal_harian(Request $request)
	{

		// ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		request()->validate([
			'tglAwal' => 'required',
			'tglAkhir' => 'required',
		]);

		$tglAwal      = valid_date($request['tglAwal']) . ' 00:00:00';
		$tglAkhir     = valid_date($request['tglAkhir']) . ' 23:59:59';
		$jenis        = $request['jenis'];
		// $carabayar    = $request['cara_bayar_id'];

		$data['pemakaian'] = Penjualandetail::leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->leftJoin('logistik_stocks', 'masterobats.id', '=', 'logistik_stocks.masterobat_id')
			// ->leftJoin('carabayars', 'folios.cara_bayar_id', '=', 'carabayars.id')
			->whereBetween('penjualandetails.created_at', [$tglAwal, $tglAkhir])
			->where('penjualandetails.tipe_rawat', $jenis)
			->groupBy('penjualandetails.masterobat_id')
			->select(
				'masterobats.satuanjual_id',
				'logistik_stocks.keterangan',
				'logistik_stocks.total',
				'masterobats.nama',
				'logistik_stocks.keluar',
				'logistik_stocks.masuk',
				'logistik_stocks.expired_date',
				'penjualandetails.masterobat_id',
				'penjualandetails.obat_racikan',
				'masterobats.nama',
				// 'carabayars.carabayar',
				'penjualandetails.created_at',
				// 'folios.cara_bayar_id',
				'penjualandetails.tipe_rawat'
			);
		// if (isset($carabayar)) {
		// 	$data['pemakaian']   = $data['pemakaian']->where('folios.cara_bayar_id', $carabayar);
		// }
		$data['pemakaian'] = $data['pemakaian']->get();

		// $data['pemakaian'] = LogistikStock::whereBetween('created_at', [$tglAwal, $tglAkhir])->groupBy('logistik_batch_id')
		// ->select(DB::raw('sum(logistik_stocks.masuk) as masuk'),DB::raw('sum(logistik_stocks.keluar) as keluar'),'masterobat_id','logistik_batch_id','total')

		// ->get();
		// dd($data['pemakaian']);

		if ($request['submit'] == 'lanjut') {
			return view('farmasi.laporan.pemakaian-obat-harian', $data);
		} elseif ($request['submit'] == 'excel') {
			Excel::create('Lap Pemakaian Obat Harian', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Lap Pemakaian Obat Harian')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Pemakaian Obat Harian ');
				$excel->sheet('Lap Pemakaian Obat Harian ', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama Obat',
						'Satuan',
						'Keluar (Pemakaian)',
						'Masuk',
						'Harga(Rp)',
						// 'Jumlah Terpakai (item)',
						'Jumlah Harga',
						'Sisa (item)',
						'Expired',
						// 'Keterangan',
					]);
					foreach ($data['pemakaian'] as $key => $d) {
						$sheet->row(++$row, [
							$no++,
							@$d->master_obat->nama . '(' . @$d->logistik_batch->nomorbatch . ')',
							@baca_satuan_jual($d->master_obat->satuanjual_id),
							@$d->keluar,
							@$d->masuk,
							@number_format($d->logistik_batch->hargajual_umum),
							@number_format($d->logistik_batch->hargajual_umum * $d->keluar),
							@$d->total,
							@date('d-m-Y', strtotime(@$d->logistik_batch->expireddate)),
							// @$d->keterangan,
						]);
					}
				});
			})->export('xlsx');
		}
	}


	public function pemakaian_obat_harian_narkotika()
	{
		$data['obat'] = Masterobat::select('id', 'nama')->get();
		// dd($data['obat']);
		return view('farmasi.laporan.pemakaian-obat-harian-narkotika', $data);
	}
	public function laporanKronis()
	{
		$data['obat'] = Masterobat::select('id', 'nama')->get();
		// dd($data['obat']);
		return view('farmasi.laporan.laporanKronis', $data);
	}

	public function pemakaian_obat_harian_highalert()
	{
		return view('farmasi.laporan.pemakaian-obat-harian-highalert');
	}

	public function pemakaian_obat_harian_generik()
	{
		return view('farmasi.laporan.pemakaian-obat-harian-generik');
	}

	public function pemakaian_obat_harian_psikotropika()
	{
		return view('farmasi.laporan.pemakaian-obat-harian-psikotropika');
	}

	public function pemakaian_obat_harian_antibiotik()
	{
		$kamar = Kamar::pluck('nama', 'id');
		return view('farmasi.laporan.pemakaian-obat-harian-antibiotik', compact('kamar'));
	}

	public function pemakaian_obat(Request $request)
	{
		if ($request['tgl_awal'] != null && $request['tgl_akhir'] != null) {
			$awal  = $request['tgl_awal'];
			$akhir = $request['tgl_akhir'];
			$data['pemakaian']  = LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
				->where('gudang_id', 3)
				->groupBy('masterobat_id')
				->select(
					'masterobat_id',
					DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan FRJ%" THEN keluar ELSE 0 END) as jalan'),
					DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan FRI%" THEN keluar ELSE 0 END) as inap'),
					DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan FRD%" THEN keluar ELSE 0 END) as darurat'),
					DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan BebasFPB%" THEN keluar ELSE 0 END) as bebas'),
					DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan%" THEN keluar ELSE 0 END) as total'),
				)->paginate(20);
			return view('farmasi.laporan.pemakaian-obat', $data)->with(['no' => 1, 'awal' => $awal, 'akhir' => $akhir]);
		}
		return view('farmasi.laporan.pemakaian-obat')->with(['no' => 1]);
	}

	public function pemakaian_obat_byTanggal(Request $request)
	{
		ini_set('max_execution_time', 0); //no timeout
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);
		$data['pemakaian']  = LogistikStock::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
			->where('gudang_id', 3)
			->groupBy('masterobat_id')
			->select(
				'masterobat_id',
				DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan FRJ%" THEN keluar ELSE 0 END) as jalan'),
				DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan FRI%" THEN keluar ELSE 0 END) as inap'),
				DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan FRD%" THEN keluar ELSE 0 END) as darurat'),
				DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan BebasFPB%" THEN keluar ELSE 0 END) as bebas'),
				DB::raw('SUM(CASE WHEN keterangan LIKE "Penjualan%" THEN keluar ELSE 0 END) as total'),
			);

		if ($request['lanjut']) {
			$data['pemakaian'] = $data['pemakaian']->paginate(20);
			return view('farmasi.laporan.pemakaian-obat', $data)->with(['no' => 1, 'awal' => $awal, 'akhir' => $akhir]);
		} elseif ($request['pdf']) {
			$data['pemakaian'] = $data['pemakaian']->get();
			$pdf = PDF::loadView('farmasi.laporan.pdf_pemakaian_obat', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} elseif ($request['excel']) {
			$data['pemakaian'] = $data['pemakaian']->get();
			Excel::create('Laporan Pemakaian Obat ', function ($excel) use ($data, $awal, $akhir) {
				// Set the properties
				$excel->setTitle('Laporan Pemakaian Obat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pemakaian Obat');
				$excel->sheet('Laporan Pemakaian Obat', function ($sheet) use ($data, $awal, $akhir) {
					$row = 1;
					$no  = 1;
					$pemakaian = $data['pemakaian'];
					$sheet->row($row, [
						'No',
						'Nama Obat',
						'Bentuk Sediaan',
						'Stok Awal',
						'Jumlah Penerimaan',
						'Penggunaan Rawat Jalan',
						'Penggunaan Rawat Inap',
						'Penggunaan IGD',
						'Penjualan Bebas',
						'Total Penggunaan',
						'Harga Satuan',
						'Total Harga',
					]);
					foreach ($pemakaian as  $stocks) {
						$masterobat = @Masterobat::find(@$stocks->masterobat_id);
						$stokAwal = @LogistikStock::where('masterobat_id', @$masterobat->id)->where('gudang_id', 3)->whereDate('created_at', '<=', $awal)->orderBy('id', 'DESC')->first()->total;
						$penerimaan = @LogistikStock::where('masterobat_id', @$masterobat->id)->where('gudang_id', 3)->whereBetween('created_at', [$awal, $akhir])->sum('masuk');
						$sheet->row(++$row, [
							$no++,
							baca_obat(@$masterobat->id),
							baca_satuan_jual(@$masterobat->satuanjual_id),
							$stokAwal,
							$penerimaan,
							$stocks->jalan,
							$stocks->inap,
							$stocks->darurat,
							$stocks->bebas,
							$stocks->total,
							baca_obat_harga(@$masterobat->id),
							baca_obat_harga(@$masterobat->id)  * $stocks->total,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function pemakaian_obat_narkotika_byTanggal(Request $request)
	{
		// dd($request->all());
		$data['obat'] = Masterobat::select('id', 'nama')->get();
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);
		$jenis        = $request['jenis'];




		$data['pemakaian'] = Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->join('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
			->whereBetween('penjualandetails.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')]);
		if ($request->masterobat_id) {
			$request->namaobat = '';
			$data['pemakaian'] = $data['pemakaian']->where('masterobats.id', $request->masterobat_id);
		}

		if ($request->namaobat) {
			$request->masterobat_id = '';
			$data['pemakaian'] = $data['pemakaian']->where('masterobats.nama', 'like', '%' . $request->namaobat . '%');
		}
		$data['pemakaian'] = $data['pemakaian']->whereNotNull('masterobats.narkotik')
			->selectRaw('masterobats.id as obat, folios.gudang_id, folios.kelompokkelas_id, penjualandetails.no_resep, penjualandetails.created_at, folios.registrasi_id, folios.dokter_id as dokter, masterobats.hargajual, masterobats.hargabeli, folios.user_id, folios.cara_bayar_id, penjualandetails.jumlah');

		if (isset($jenis)) {
			if ($jenis == 2) {
				$data['pemakaian']  = $data['pemakaian']->where('folios.gudang_id', $jenis);
			} else {
				$data['pemakaian']  = $data['pemakaian']->where('penjualandetails.tipe_rawat', $jenis);
			}
		}
		$data['pemakaian'] = $data['pemakaian']->get();

		if ($request['lanjut']) {
			return view('farmasi.laporan.pemakaian-obat-harian-narkotika', $data)->with(['no' => 1]);
		} elseif ($request['pdf']) {
			$pdf = PDF::loadView('farmasi.laporan.pdf_pemakaian_obat', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} elseif ($request['excel']) {
			Excel::create('Laporan Pemakaian Obat ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Pemakaian Obat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pemakaian Obat');
				$excel->sheet('Laporan Pemakaian Obat', function ($sheet) use ($data) {
					$row = 1;
					$no  = 1;
					$pemakaian = $data['pemakaian'];
					$sheet->row($row, [
						'Tanggal',
						'No.Faktur',
						'Pasien',
						'No RM',
						'Alamat',
						'Nama Dokter',
						'Nama Obat',
						'Jumlah',
						'Harga Pokok',
						'Harga Satuan',
						'Harga Jual',
						'Harga Jual (Jumlah)',
						'Ruangan/Poli',
						'Cara Bayar',
						'User'
					]);
					$jumlahJualTotal = 0;
					$jumlahTotal = 0;
					$total_hargajual = 0;
					$total_hargabeli = 0;
					foreach ($pemakaian as $key => $d) {
						$reg = \Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();

						$total_hargajual += $d->hargajual;
						$total_hargabeli += $d->hargabeli;
						$jumlahTotal += $d->jumlah;
						$jumlahJualTotal += $jumlahTotal * $total_hargajual;



						if ($d->gudang_id == 2) {
							$resep = str_replace("FRI", "FRO", $d->no_resep);
						} else {
							$resep = @$d->no_resep;
						}



						$ruang = Rawatinap::where('registrasi_id', $reg->id)->first();






						if ($_POST['jenis'] == 'TI') {
							$ruang = baca_kelompok(@$ruang->kelompokkelas_id);
						} else {
							$ruang = baca_poli($reg->poli_id);
						}




						$sheet->row(++$row, [
							$d->created_at,
							@$resep,
							baca_pasien(@$reg->pasien_id),
							@$reg->pasien->no_rm,
							@$reg->pasien->alamat,
							baca_dokter(@$d->dokter),
							baca_obat($d->obat),
							@$d->jumlah,
							number_format(@$d->hargajual),
							number_format(@$d->hargabeli),
							number_format(@$d->hargajual),
							number_format(@$d->hargajual * $d->jumlah),
							$ruang,
							baca_carabayar(@$d->cara_bayar_id),
							baca_user(@$d->user_id)
						]);
					}
					$sheet->row(++$row, [
						'total',
						'',
						'',
						'',
						'',
						'',
						'',
						$jumlahTotal,
						$total_hargajual,
						$total_hargabeli,
						$total_hargajual,
						$jumlahJualTotal,
					]);
				});
			})->export('xlsx');
		}
	}
	public function laporanKronis_byTanggal(Request $request)
	{
		// dd($request->all());
		$data['obat'] = Masterobat::select('id', 'nama')->get();
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);
		$jenis        = $request['jenis'];




		$data['pemakaian'] = Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->join('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
			// ->where('folios.user_id', '610')
			->where('penjualandetails.is_kronis', 'Y')
			->whereBetween('penjualandetails.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')]);
		if ($request->masterobat_id) {
			$request->namaobat = '';
			$data['pemakaian'] = $data['pemakaian']->where('masterobats.id', $request->masterobat_id);
		}

		if ($request->namaobat) {
			$request->masterobat_id = '';
			$data['pemakaian'] = $data['pemakaian']->where('masterobats.nama', 'like', '%' . $request->namaobat . '%');
		}
		$data['pemakaian'] = $data['pemakaian']->selectRaw('masterobats.id as obat, folios.gudang_id, folios.kelompokkelas_id, penjualandetails.no_resep, penjualandetails.created_at, folios.registrasi_id, folios.dokter_id as dokter, masterobats.hargajual, masterobats.hargabeli, folios.user_id, folios.cara_bayar_id,folios.user_id, penjualandetails.jumlah');

		if (isset($jenis)) {
			if ($jenis == 2) {
				$data['pemakaian']  = $data['pemakaian']->where('folios.gudang_id', $jenis);
			} else {
				$data['pemakaian']  = $data['pemakaian']->where('penjualandetails.tipe_rawat', $jenis);
			}
		}
		$data['pemakaian'] = $data['pemakaian']->get();

		if ($request['lanjut']) {
			return view('farmasi.laporan.laporanKronis', $data)->with(['no' => 1]);
		} elseif ($request['pdf']) {
			$pdf = PDF::loadView('farmasi.laporan.pdf_pemakaian_obat', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} elseif ($request['excel']) {
			Excel::create('Laporan Pemakaian Obat Kronis', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Pemakaian Obat Kronis')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pemakaian Obat');
				$excel->sheet('Laporan Pemakaian Obat', function ($sheet) use ($data) {
					$row = 1;
					$no  = 1;
					$pemakaian = $data['pemakaian'];
					$sheet->row($row, [
						'Tanggal',
						'No.Faktur',
						'Pasien',
						'No RM',
						'SEP',
						'Alamat',
						'Nama Dokter',
						'Nama Obat',
						'Jumlah',
						'Harga Pokok',
						'Harga Satuan',
						'Harga Jual',
						'Harga Jual (Jumlah)',
						'Ruangan/Poli',
						'Cara Bayar',
						'Tanggal SEP',
						'User'
					]);
					$total_hargajual = 0;
					$total_hargabeli = 0;
					$jumlah = 0;
					$totalJual = 0;
					foreach ($pemakaian as $key => $d) {
						$reg = \Modules\Registrasi\Entities\Registrasi::with('pasien')->find($d->registrasi_id);

						if (!$reg) {
							// Lewatkan data yang tidak punya registrasi valid
							continue;
						}

						$total_hargajual += $d->hargajual;
						$total_hargabeli += $d->hargabeli;
						$jumlah += $d->jumlah;

						if ($d->gudang_id == 2) {
							$resep = str_replace("FRI", "FRO", $d->no_resep);
						} else {
							$resep = $d->no_resep ?? '-';
						}

						$rawatInap = Rawatinap::where('registrasi_id', $reg->id)->first();

						if ($_POST['jenis'] == 'TI') {
							$ruang = baca_kelompok(optional($rawatInap)->kelompokkelas_id);
						} else {
							$ruang = baca_poli($reg->poli_id);
						}

						$sheet->row(++$row, [
							$d->created_at ?? '-',
							$resep,
							baca_pasien($reg->pasien_id) ?? '-',
							optional($reg->pasien)->no_rm ?? '-',
							$reg->no_sep ?? '-',
							optional($reg->pasien)->alamat ?? '-',
							baca_dokter($d->dokter),
							baca_obat($d->obat),
							$d->jumlah ?? 0,
							number_format($d->hargajual ?? 0),
							number_format($d->hargabeli ?? 0),
							number_format($d->hargajual ?? 0),
							number_format(($d->hargajual ?? 0) * ($d->jumlah ?? 0)),
							$ruang,
							baca_carabayar($d->cara_bayar_id),
							$reg->tgl_sep ?? '-',
							baca_user($d->user_id)
						]);
					}
					$sheet->row(++$row, [
						'total',
						'',
						'',
						'',
						'',
						'',
						'',
						$jumlah,
						$total_hargajual,
						$total_hargabeli,
						$total_hargajual,
						$total_hargajual *  $jumlah,
					]);
				});
			})->export('xlsx');
		}
	}

	public function pemakaian_obat_highalert_byTanggal(Request $request)
	{
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

		request()->validate([
			'tglAwal' => 'required',
			'tglAkhir' => 'required',
		]);

		$tglAwal  = valid_date($request['tglAwal']) . ' 00:00:00';
		$tglAkhir = valid_date($request['tglAkhir']) . ' 23:59:59';
		$dokter   = $request['dokter'];
		// $user  = Auth::user()->id;

		if ($request['jenis'] == 'TA') {
			$jenis = 'FRJ';
		} elseif ($request['jenis'] == 'TI') {
			$jenis = 'FRI';
		} elseif ($request['jenis'] == 'TG') {
			$jenis = 'FRD';
		} elseif ($request['jenis'] == 'TL') {
			$jenis = 'FPB';
		} elseif ($request['jenis'] == '2') {
			$jenis = '2';
		}


		if ($jenis == 'FPB') {
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
				->whereNotNull('masterobats.high_alert')
				->where('folios.namatarif', 'LIKE', 'FPB' . '%')
				->where('folios.namatarif', '!=', 'Retur Penjualan')
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.total', '<>', 0)


				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			$datas['data'] = $datas['data']->get();
			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi_pl', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.pemakaian-obat-harian-highalert', $datas);
			} elseif ($request['submit'] == 'excel') {
				Excel::create('Laporan High Alert Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan High Alert Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan High Alert Farmasi');
					$excel->sheet('Laporan High Alert Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'user',
							'Nama',
							'Alamat',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajual;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								@$pasien ? @$pasien->alamat : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),
								!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
								baca_obat($d->obat),
								$d->jumlah,
								$d->hargajualtotal,

							]);
						}
						$sheet->row($baris + 3, [
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'Total =',
							$sum,
						]);
					});
				})->export('xlsx');
			}
		} elseif ($jenis == '2') {
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
				->whereNotNull('masterobats.high_alert')
				->where('folios.gudang_id', $jenis)
				->where('folios.cara_bayar_id', $request['cara_bayar_id'])
				->where('folios.namatarif', '!=', 'Retur Penjualan')
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.total', '<>', 0)

				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			$datas['data'] = $datas['data']->get();

			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi_pl', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.pemakaian-obat-harian-highalert', $datas);
			} elseif ($request['submit'] == 'excel') {
				Excel::create('Laporan High Alert Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan High Alert Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan High Alert Farmasi');
					$excel->sheet('Laporan High Alert Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'user',
							'Nama',
							'Alamat',
							'No. RM',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajual;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								@$pasien ? @$pasien->alamat : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),
								!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
								baca_obat($d->obat),
								$d->jumlah,
								$d->hargajualtotal,

							]);
						}
						$sheet->row($baris + 3, [
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'Total =',
							$sum,
						]);
					});
				})->export('xlsx');
			}
		} else {
			$dokter = \Modules\Pegawai\Entities\Pegawai::select('id')->get();
			$di = [];
			foreach ($dokter as $key => $d) {
				$di[] = '' . $d->id . '';
			}
			$dokters = $request->dokter;
			$user =  $request->user;
			$obat = $request->obat;
			$datas['data'] = Penjualandetail::leftJoin('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
				->leftJoin('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
				->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
				->whereNotNull('masterobats.high_alert')
				->where('folios.namatarif', 'LIKE', $jenis . '%')
				->where('folios.cara_bayar_id', $request['cara_bayar_id'])
				// ->whereIn('folios.dokter_id', empty($request['dokter']) ? [$request['dokter']] : $di)
				->where('folios.namatarif', '!=', 'Retur Penjualan')
				->where('folios.total', '<>', 0)
				->where('folios.gudang_id', '<>', 2)
				->where('folios.user_id', '<>', 610)

				->whereBetween('folios.created_at', [$tglAwal, $tglAkhir])
				->selectRaw('folios.registrasi_id, folios.namatarif, folios.jenis, folios.cara_bayar_id, folios.total, folios.pasien_id, folios.dokter_id, folios.poli_id, folios.created_at, penjualans.id as penjualan_id, penjualans.user_id, penjualandetails.masterobat_id as obat, penjualandetails.hargajual as hargajualtotal, penjualandetails.jumlah as jumlah');
			if (isset($obat)) {
				$datas['data']   = $datas['data']->where('penjualandetails.masterobat_id', $obat);
			}
			if (isset($user)) {
				$datas['data']   = $datas['data']->where('folios.user_id', $user);
			}
			$datas['data'] = $datas['data']->get();

			if ($request['submit'] == 'lanjut') {
				// return view('farmasi.laporan.kinerjaFarmasi', compact('data'))->with(['no' => 1, 'jenis' => $request['jenis']]);
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '8000M');
				return view('farmasi.laporan.pemakaian-obat-harian-highalert', $datas);
			} elseif ($request['submit'] == 'excel') {
				$jenis = $request['jenis'];



				Excel::create('Laporan High Alert Farmasi', function ($excel) use ($datas, $jenis) {
					// Set the properties
					$excel->setTitle('Laporan High Alert Farmasi')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan High Alert Farmasi');
					$excel->sheet('Laporan High Alert Farmasi', function ($sheet) use ($datas, $jenis) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'user',
							'Nama',
							'No. RM',
							'Alamat',
							'Baru/Lama',
							'L/P',
							'Ruang / Poli',
							'Cara Bayar',
							'Tanggal',
							'Dokter',
							'Obat',
							'Jumlah',
							'Tarif RS',
						]);
						$sum = 0;
						foreach ($datas['data'] as $key => $d) {
							$baris = ++$row;
							$sum += $d->hargajual;
							$reg = Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
							$irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
							$pasien = Pasien::find($d->pasien_id);
							$detail = Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();



							if (@$jenis == 'TA' || @$jenis == 'TG') {
								$poli = !empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL;
							} elseif (@$jenis == 'TI') {
								$poli = $irna ? baca_kamar($irna->kamar_id) : NULL;
							}

							$sheet->row(++$row, [
								$no++,
								baca_user($d->user_id),
								@$pasien ? @$pasien->nama : NULL,
								@$pasien ? @$pasien->no_rm : NULL,
								@$pasien ? @$pasien->alamat : NULL,
								(@$reg->jenis_pasien == '1') ? 'Baru' : 'Lama',
								@$pasien ? @$pasien->kelamin : NULL,
								@$poli,
								baca_carabayar($d->cara_bayar_id) . ' ' . @$reg->tipe_jkn,
								$d->created_at->format('d-m-Y'),
								!empty($d->dokter_id) ? baca_dokter($d->dokter_id) : NULL,
								baca_obat($d->obat),
								$d->jumlah,
								$d->hargajualtotal,

							]);
						}
						$sheet->row($baris + 3, [
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'Total =',
							$sum,
						]);
					});
				})->export('xlsx');
			}
		}
	}

	public function pemakaian_obat_psikotropika_byTanggal(Request $request)
	{
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);
		$jenis        = $request['jenis'];
		$data['pemakaian'] = Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->join('folios', 'penjualandetails.no_resep', '=', 'folios.namatarif')
			->whereBetween('penjualandetails.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])

			->whereNotNull('masterobats.psikotoprik')
			->selectRaw('masterobats.id as obat, penjualandetails.no_resep, penjualandetails.created_at, folios.registrasi_id, folios.dokter_id, masterobats.hargajual, masterobats.hargabeli, folios.user_id, folios.cara_bayar_id, penjualandetails.jumlah');
		if (isset($jenis)) {
			if ($jenis == 2) {
				$data['pemakaian']  = $data['pemakaian']->where('folios.gudang_id', $jenis);
			} else {
				$data['pemakaian']  = $data['pemakaian']->where('penjualandetails.tipe_rawat', $jenis);
			}
		}
		$data['pemakaian'] = $data['pemakaian']->get();
		if ($request['lanjut']) {
			return view('farmasi.laporan.pemakaian-obat-harian-psikotropika', $data)->with(['no' => 1]);
		} elseif ($request['pdf']) {
			$pdf = PDF::loadView('farmasi.laporan.pdf_pemakaian_obat', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} elseif ($request['excel']) {
			Excel::create('Laporan Pemakaian Obat ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Pemakaian Obat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pemakaian Obat');
				$excel->sheet('Laporan Pemakaian Obat', function ($sheet) use ($data) {
					$row = 1;
					$no  = 1;
					$pemakaian = $data['pemakaian'];
					$sheet->row($row, [
						'Tanggal',
						'No.Faktur',
						'Pasien',
						'No RM',
						'Alamat',
						'Nama Obat',
						'Jumlah',
						'Harga Pokok',
						'Harga Satuan',
						'Harga Jual',
						'Harga Jual (Jumlah)',
						// 'Ruangan/Poli',
						'Cara Bayar',
						'User'
					]);
					$total_hargajual = 0;
					$total_hargabeli = 0;
					foreach ($pemakaian as $key => $d) {
						$reg = \Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
						// if (stripos($d->no_resep,'FRI')) {
						// 	$poli = baca_kelas($reg->kelas_id);
						// }else {
						// 	$poli = baca_poli($reg->poli_id);
						// }
						$total_hargajual += $d->hargajual;
						$total_hargabeli += $d->hargabeli;
						$sheet->row(++$row, [
							$d->created_at,
							@$d->no_resep,
							baca_pasien(@$reg->pasien_id),
							@$reg->pasien->no_rm,
							@$reg->pasien->alamat,
							baca_obat($d->obat),
							@$d->jumlah,
							number_format(@$d->hargajual),
							number_format(@$d->hargabeli),
							number_format(@$d->hargajual),
							number_format(@$d->hargajual),
							//  baca_poli(@$reg->poli_id) || baca_kelompok(@$d->kelompokkelas),
							baca_carabayar(@$d->cara_bayar_id),
							baca_user(@$d->user_id)
						]);
					}
					$sheet->row(++$row, [
						'total',
						'',
						'',
						'',
						'',
						'',
						$total_hargajual,
						$total_hargabeli,
						$total_hargajual,
						$total_hargabeli,
					]);
				});
			})->export('xlsx');
		}
	}
	
	public function pemakaian_obat_antibiotik_byTanggal(Request $request)
	{
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);
		$filter = $request['kamar'];
		$data['filter_kamar'] = $filter;
		$data['kamar'] = Kamar::pluck('nama', 'id');
		$data['pemakaian'] = Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->join('penjualans', 'penjualandetails.penjualan_id', '=', 'penjualans.id')
			->join('rawatinaps', 'penjualans.registrasi_id', '=', 'rawatinaps.registrasi_id')
			->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
			->whereBetween('penjualandetails.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
			->whereNotNull('masterobats.antibiotik')
			->where('penjualandetails.tipe_rawat', 'TI')
			->select('registrasis.pasien_id', 'pasiens.tgllahir', 'pasiens.kelamin', 'pasiens.no_rm', 'rawatinaps.dokter_id', 'masterobats.id as obat', 'penjualandetails.jumlah', 'registrasis.diagnosa_inap', 'registrasis.diagnosa_awal', 'rawatinaps.tgl_masuk', 'rawatinaps.tgl_keluar');

		if (isset($filter)) {
			$data['pemakaian']  = $data['pemakaian']->where('rawatinaps.kamar_id', $filter);
		}
		$data['pemakaian'] = $data['pemakaian']->get();
		if ($request['lanjut']) {
			return view('farmasi.laporan.pemakaian-obat-harian-antibiotik', $data)->with(['no' => 1]);
		} elseif ($request['excel']) {
			Excel::create('Laporan Pemakaian Obat ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Pemakaian Obat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pemakaian Obat');
				$excel->sheet('Laporan Pemakaian Obat', function ($sheet) use ($data) {
					$row = 1;
					$no  = 1;
					$pemakaian = $data['pemakaian'];
					$sheet->row($row, [
						'Pasien',
						'No RM',
						'Usia',
						'Jenis Kelamin',
						'Diagnosa',
						'Tanggal Masuk',
						'Tanggal Keluar',
						'Lama Perawatan (Hari)',
						'Nama Obat',
						'Jumlah',
					]);
					foreach ($pemakaian as $key => $d) {
						$tglmasuk = Carbon::parse(@$d->tgl_masuk);
						$tglkeluar = Carbon::parse(@$d->tgl_keluar);

						if ($d->tgl_keluar) {
							$jumlahHari = $tglmasuk->diffInDays($tglkeluar);
						} else {
							$jumlahHari = '-';
						}
						$sheet->row(++$row, [
							baca_pasien(@$d->pasien_id),
							@$d->no_rm,
							hitung_umur(@$d->tgllahir),
							@$d->kelamin,
							baca_icd10(@$d->diagnosa_inap ?? $d->diagnosa_awal),
							@$d->tgl_masuk,
							@$d->tgl_keluar,
							$jumlahHari,
							baca_obat(@$d->obat),
							@$d->jumlah
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function pemakaian_obat_generik_byTanggal(Request $request)
	{
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);
		$jenis        = $request['jenis'];

		$data['pemakaian'] = Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->whereBetween('penjualandetails.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
			->where('penjualandetails.tipe_rawat', $jenis)
			->whereNotNull('masterobats.generik')
			->groupBy('penjualandetails.masterobat_id')
			->selectRaw('masterobat_id, no_resep, sum(jumlah) as jumlah_total, sum(jml_kronis) as jml_kronis_total')
			->get();

		if ($request['lanjut']) {
			return view('farmasi.laporan.pemakaian-obat-harian-generik', $data)->with(['no' => 1]);
		} elseif ($request['pdf']) {
			$pdf = PDF::loadView('farmasi.laporan.pdf_pemakaian_obat', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} elseif ($request['excel']) {
			Excel::create('Laporan Pemakaian Obat ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Laporan Pemakaian Obat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pemakaian Obat');
				$excel->sheet('Laporan Pemakaian Obat', function ($sheet) use ($data) {
					$row = 1;
					$no  = 1;
					$pemakaian = $data['pemakaian'];
					$sheet->row($row, [
						'No',
						'No.Faktur',
						'Nama Obat',
						'Satuan',
						'Harga Obat (Rp)',
						'Masuk',
						'Keluar',
						'Terpakai (item)',
						'Stok (item)',
						'Expired',
						'Keterangan',
					]);
					foreach ($pemakaian as $key => $d) {
						$sheet->row(++$row, [
							$no++,
							baca_obat($d->masterobat_id),
							baca_satuan_jual_report($d->masterobat_id),
							baca_obat_harga($d->masterobat_id),
							@historimasuk($d->masterobat_id),
							@historikeluar($d->masterobat_id),
							$d->jumlah_total + $d->jml_kronis_total,
							@stok($d->masterobat_id),
							@expired($d->masterobat_id),
							@Ket($d->masterobat_id),
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function cetakEresep($idPenjualan)
	{
		// dd($idPenjualan);
		$data['nama_racikan'] = '';
		$data['penjualan'] = Penjualan::find($idPenjualan);

		if (!empty(json_decode(@$data['penjualan']->tte)->base64_signed_file)) {
			$tte    = json_decode($data['penjualan']->tte);
			$base64 = $tte->base64_signed_file;

			$pdfContent = base64_decode($base64);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
			]);
		} else {
			$data['resep_note'] = ResepNote::where('penjualan_id', $idPenjualan)->first();
			@$data['get_note'] = @Penjualandetail::where('penjualan_id', $idPenjualan)
				->where('catatan', '!=', 'null')
				->first();
			// dd($data['get_note']);
			if ($data['resep_note']) {
				$data['nama_racikan'] = $data['resep_note']->nama_racikan;
				$data['no_resep'] = $data['resep_note']->no_resep;
			} else {
				$data['nama_racikan'] = '';
				$data['no_resep']     = '';
			}

			$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
			$data['detail'] = Penjualandetail::where('obat_racikan', 'N')->where('penjualan_id', $idPenjualan)->get();
			$data['detail_racikan'] = Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $idPenjualan)->get();
			$data['penjualan_detail'] =  Penjualandetail::where('penjualan_id', $idPenjualan)->first();

			$pdf = PDF::loadView('farmasi.laporan.pdf_eresep', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		}
	}

	public function cetakAntrianEresep($id)
	{
		$nomor = ResepNote::find($id);
		return view('farmasi.antrian_eresep', compact('nomor'));
	}

	public function tteEresep($idPenjualan, Request $request)
	{
		$data['nama_racikan'] = '';
		$data['penjualan'] = Penjualan::find($idPenjualan);
		$data['resep_note'] = ResepNote::where('penjualan_id', $idPenjualan)->first();
		@$data['get_note'] = @Penjualandetail::where('penjualan_id', $idPenjualan)
			->where('catatan', '!=', 'null')
			->first();
		// dd($data['get_note']);
		if ($data['resep_note']) {
			$data['nama_racikan'] = $data['resep_note']->nama_racikan;
			$data['no_resep'] = $data['resep_note']->no_resep;
		} else {
			$data['nama_racikan'] = '';
			$data['no_resep']     = '';
		}

		// $data['reg'] = Registrasi::where('id',$data['penjualan']->registrasi_id)->first();
		// $data['detail'] = Penjualandetail::where('obat_racikan','N')->where('penjualan_id', $idPenjualan)->get();
		// $data['detail_racikan'] = Penjualandetail::where('obat_racikan','Y')->where('penjualan_id', $idPenjualan)->get();
		// $data['penjualan_detail'] =  Penjualandetail::where('penjualan_id', $idPenjualan)->first();

		// $pdf = PDF::loadView('farmasi.laporan.pdf_eresep',$data);
		// $pdf->setPaper('A4', 'potret');
		$penjualan = Penjualan::find($idPenjualan);

		$tte = json_decode($penjualan->tte);
		$base64 = $tte->base64_signed_file;

		$pdfContent = base64_decode($base64);

		// Create temp pdf resume file
		$filePath = uniqId() . 'eresep-laporan.pdf';
		File::put(public_path($filePath), $pdfContent);

		// Proses TTE
		$tte = tte_invisible($filePath, $request->nik, $request->passphrase);

		// Remove temp pdf resume file
		File::delete(public_path($filePath));

		$resp = json_decode($tte->response);

		if ($tte->httpStatusCode == 200) {
			$data['penjualan']->tte = $tte->response;
			$data['penjualan']->tte_dokter = Auth::user()->id;
			$data['penjualan']->save();
			Flashy::success('Berhasil proses TTE');
			return redirect()->to(url('/emr/eresep/jalan/' . $data['penjualan']->registrasi_id));
		} elseif ($tte->httpStatusCode == 400) {
			if (isset($resp->error)) {
				Flashy::error($resp->error);
				return redirect()->to(url('/emr/eresep/jalan/' . $data['penjualan']->registrasi_id));
			}
		} elseif ($tte->httpStatusCode == 500) {
			Flashy::error($tte->response);
			return redirect()->back();
		}
		Flashy::error("Gagal melakukan proses TTE !");
		return redirect()->to(url('/emr/eresep/jalan/' . $data['penjualan']->registrasi_id));
	}

	public function eresepCek($regId, $idPenjualan)
	{
		$registrasi = Registrasi::find($regId);
		// $dokter = Pegawai::where('id', $registrasi->dokter_id)->first();
		// Temp
		$dokter = Auth::user()->pegawai;
		$penjualan = Penjualan::find($idPenjualan);
		return response()->json((object) [
			'dokter' => $dokter,
			'tte' => $penjualan->tte == null ? 'belum' : 'sudah',
		]);
	}

	public function EresepTTE($idPenjualan)
	{
		$penjualan = Penjualan::find($idPenjualan);

		$tte = json_decode($penjualan->tte);
		$base64 = $tte->base64_signed_file;

		$pdfContent = base64_decode($base64);
		return Response::make($pdfContent, 200, [
			'Content-Type' => 'application/pdf',
		]);
	}

	public function laporanPenggunaanObatIrj()
	{
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['crb']		= 0;

		$data['penggunaan'] = Penjualandetail::where('penjualandetails.created_at', '>=', date('Y-m-d') . ' 00:00:00')
			->where('penjualandetails.tipe_rawat', '=', 'TA')
			->leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->select(
				'penjualandetails.masterobat_id as nama_obat',
				'masterobats.kode as kode_obat',
				DB::raw('SUM(penjualandetails.jumlah) as radar')
			)
			->groupBy('penjualandetails.masterobat_id')
			->get();

		return view('farmasi.laporan.laporanPenggunaanObatIrj', $data)->with('no', 1);
	}
	public function filterPenggunaanObatIrj(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga) . ' 00:00:00';
		$tgb				= valid_date($req->tgb) . ' 23:59:59';

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;

		$data['penggunaan'] = Penjualandetail::whereBetween('penjualandetails.created_at', [$tga, $tgb])
			->where('penjualandetails.tipe_rawat', '=', 'TA')
			->leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->select(
				'penjualandetails.masterobat_id as nama_obat',
				'masterobats.kode as kode_obat',
				DB::raw('SUM(penjualandetails.jumlah) as radar')
			)
			->groupBy('penjualandetails.masterobat_id')
			->get();
		if ($req->submit == 'TAMPILKAN') {

			return view('farmasi.laporan.laporanPenggunaanObatIrj', $data)->with('no', 1);
		} else if ($req->submit == 'CETAK') {
			// return $pemakaian; die;
			// $pdf = PDF::loadView('logistiknew.logistikmedik.laporan.pdf_lap_retur_obat', $data);
			//  $pdf->setPaper('A4', 'potret');
			// return $pdf->download('Laporan Retur Obat' . date('Y-m-d') . '.pdf');
			$pdf = PDF::loadView('farmasi.laporan.laporanPenggunaanObatIrjPDF', compact('data'));
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
	public function laporanPenggunaanObatIrna()
	{
		$data['tga']		= "";
		$data['tgb']		= "";
		$data['crb']		= 0;

		$data['penggunaan'] = Penjualandetail::where('penjualandetails.created_at', '>=', date('Y-m-d') . ' 00:00:00')
			->where('penjualandetails.tipe_rawat', '=', 'TI')
			->leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->select(
				'penjualandetails.masterobat_id as nama_obat',
				'masterobats.kode as kode_obat',
				DB::raw('SUM(penjualandetails.jumlah) as radar')
			)
			->groupBy('penjualandetails.masterobat_id')
			->get();

		return view('farmasi.laporan.laporanPenggunaanObatIrna', $data)->with('no', 1);
	}
	public function filterPenggunaanObatIrna(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga) . ' 00:00:00';
		$tgb				= valid_date($req->tgb) . ' 23:59:59';

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;

		$data['penggunaan'] = Penjualandetail::whereBetween('penjualandetails.created_at', [$tga, $tgb])
			->where('penjualandetails.tipe_rawat', '=', 'TI')
			->leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->select(
				'penjualandetails.masterobat_id as nama_obat',
				'masterobats.kode as kode_obat',
				DB::raw('SUM(penjualandetails.jumlah) as radar')
			)
			->groupBy('penjualandetails.masterobat_id')
			->get();
		if ($req->submit == 'TAMPILKAN') {

			return view('farmasi.laporan.laporanPenggunaanObatIrna', $data)->with('no', 1);
		} else if ($req->submit == 'CETAK') {
			// return $pemakaian; die;
			// $pdf = PDF::loadView('logistiknew.logistikmedik.laporan.pdf_lap_retur_obat', $data);
			//  $pdf->setPaper('A4', 'potret');
			// return $pdf->download('Laporan Retur Obat' . date('Y-m-d') . '.pdf');
			$pdf = PDF::loadView('farmasi.laporan.laporanPenggunaanObatIrnaPDF', compact('data'));
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
	public function laporanPenggunaanObatIgd()
	{
		$data['tga']		= now()->format('d-m-Y');
		$data['tgb']		= now()->format('d-m-Y');
		$data['crb']		= 0;

		$data['penggunaan'] = Penjualandetail::where('penjualandetails.created_at', '>=', date('Y-m-d') . ' 00:00:00')
			->where('penjualandetails.tipe_rawat', '=', 'TG')
			->leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->select(
				'penjualandetails.masterobat_id as nama_obat',
				'masterobats.kode as kode_obat',
				DB::raw('SUM(penjualandetails.jumlah) as radar')
			)
			->groupBy('penjualandetails.masterobat_id')
			->get();

		return view('farmasi.laporan.laporanPenggunaanObatRadar', $data)->with('no', 1);
	}
	public function filterPenggunaanObatIgd(Request $req)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		// $data['carabayar']	= Carabayar::all();
		$tga				= valid_date($req->tga) . ' 00:00:00';
		$tgb				= valid_date($req->tgb) . ' 23:59:59';

		$data['tga']		= $req->tga;
		$data['tgb']		= $req->tgb;

		$data['penggunaan'] = Penjualandetail::whereBetween('penjualandetails.created_at', [$tga, $tgb])
			->where('penjualandetails.tipe_rawat', '=', 'TG')
			->leftJoin('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			->select(
				'penjualandetails.masterobat_id as nama_obat',
				'masterobats.kode as kode_obat',
				DB::raw('SUM(penjualandetails.jumlah) as radar')
			)
			->groupBy('penjualandetails.masterobat_id')
			->get();
		if ($req->submit == 'TAMPILKAN') {
			return view('farmasi.laporan.laporanPenggunaanObatRadar', $data)->with('no', 1);
		} else if ($req->submit == 'CETAK') {
			$penggunaan = $data['penggunaan'];
			$pdf = PDF::loadView('farmasi.laporan.laporanPenggunaanObatRadarPDF', compact('penggunaan'));
			return $pdf->stream();
		} elseif ($req->submit == 'EXCEL') {
			Excel::create('Pengunaan Obat Gawat Darurat', function ($excel) use ($data) {
				$excel->setTitle('Pengunaan Obat Gawat Darurat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Pengunaan Obat Gawat Darurat');
				$excel->sheet('Pengunaan Obat Gawat Darurat', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Kode Obat',
						'Nama Obat',
						'Total Penggunaan',
					]);
					foreach ($data['penggunaan'] as $d) {
						$sheet->row(++$row, [
							$no++,
							@$d->kode_obat,
							@baca_obat(@$d->nama_obat),
							@$d->radar
						]);
					}
				});
			})->export('xlsx');
		}
		return view('frontoffice.laporan-retur-obat', compact('data'));
	}

	public function cetakEresepTTE($id_penjualan)
	{
		$resep_note = ResepNote::where('penjualan_id', $id_penjualan)->firstOrFail();
		$tte = json_decode($resep_note->tte);
		$base64 = $tte->base64_signed_file;

		$pdfContent = base64_decode($base64);
		return Response::make($pdfContent, 200, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'attachment; filename="' . $resep_note->no_resep . '-eresep.pdf"',
		]);
	}

	public function formLepasanObat(Request $request)
	{
		if ($request['tgl_awal'] != null && $request['tgl_akhir'] != null) {
			$awal  = valid_date($request['tgl_awal']);
			$akhir = valid_date($request['tgl_akhir']);


			$emr_terapi = EmrInapPemeriksaan::whereBetween('emr_inap_pemeriksaans.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
				->join('pasiens', 'emr_inap_pemeriksaans.pasien_id', '=', 'pasiens.id')
				->select('pasiens.nama as nama_pasien', 'emr_inap_pemeriksaans.fisik')
				->where('emr_inap_pemeriksaans.type', 'daftar-pemberian-terapi')
				->where('emr_inap_pemeriksaans.is_done_input', true)
				->orderBy('emr_inap_pemeriksaans.id', 'ASC')
				->get();

			$data_terapi = array();
			foreach($emr_terapi as $emr){
				$asessment = json_decode(@$emr->fisik, true);

				if(!empty($asessment)){
					
					$asessment['nama_pasien'] = $emr->nama_pasien;
					$data_terapi[] = $asessment;
				}
			}
			// echo '<pre>'; print_r($data_terapi);die();
			$data['data_terapi'] = $data_terapi;



			return view('farmasi.form-lepasan-obat', $data)->with(['no' => 1, 'awal' => $awal, 'akhir' => $akhir]);
		}
		return view('farmasi.form-lepasan-obat')->with(['no' => 1]);
	}

	public function getLepasanRekonsiliasi($tgl_awal=null, $tgl_akhir=null)
	{
		if(!empty($tgl_awal) && !empty($tgl_akhir)){
			$awal  = valid_date($tgl_awal);
			$akhir = valid_date($tgl_akhir);

			//Rekonsiliasi
			$emr_asessment = EmrInapPemeriksaan::whereBetween('emr_inap_pemeriksaans.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
				->join('pasiens', 'emr_inap_pemeriksaans.pasien_id', '=', 'pasiens.id')
				->select('pasiens.nama as nama_pasien', 'emr_inap_pemeriksaans.fisik')
				->where('emr_inap_pemeriksaans.type', 'assesment-awal-medis-igd')
				->orderBy('emr_inap_pemeriksaans.id', 'ASC')
				->get();

			$data_rekonsiliasi = array();
			$data_obatAlergi = array();
			foreach($emr_asessment as $emr){
				$asessment = json_decode(@$emr->fisik, true);

				if(!empty($asessment['rekonsiliasi'])){
					$rekonsiliasi = [];
					foreach($asessment['rekonsiliasi'] as $rekon){
						$rekon['nama_pasien'] = $emr->nama_pasien;
						$rekonsiliasi[] = $rekon;
					}
					$data_rekonsiliasi[] = $rekonsiliasi;
				}

			}
			
			$rekonsiliasi = array();
			$no = 1;
			if($data_rekonsiliasi){
				foreach($data_rekonsiliasi as $rekon){
					foreach ($rekon as $r_obat){
						$r_obat['nomor'] = $no++; 
						$r_obat['tanggal'] = \Carbon\Carbon::parse(@$r_obat['tanggal'])->format('d-m-Y H:i'); 
						$rekonsiliasi[] = $r_obat; 
					}
				}
			}

			return DataTables::of($rekonsiliasi)
					->make(true);
		}
		return false;
	}

	public function getLepasanObatalergi($tgl_awal=null, $tgl_akhir=null)
	{
		if(!empty($tgl_awal) && !empty($tgl_akhir)){
			$awal  = valid_date($tgl_awal);
			$akhir = valid_date($tgl_akhir);

			//ObatAlergi
			$emr_asessment = EmrInapPemeriksaan::whereBetween('emr_inap_pemeriksaans.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
				->join('pasiens', 'emr_inap_pemeriksaans.pasien_id', '=', 'pasiens.id')
				->select('pasiens.nama as nama_pasien', 'emr_inap_pemeriksaans.fisik')
				->where('emr_inap_pemeriksaans.type', 'assesment-awal-medis-igd')
				->orderBy('emr_inap_pemeriksaans.id', 'ASC')
				->get();

			$data_rekonsiliasi = array();
			$data_obatAlergi = array();
			foreach($emr_asessment as $emr){
				$asessment = json_decode(@$emr->fisik, true);

				if(!empty($asessment['obatAlergi'])){
					$obatAlergi = [];
					foreach($asessment['obatAlergi'] as $alergi){
						$alergi['nama_pasien'] = $emr->nama_pasien;
						$obatAlergi[] = $alergi;
					}
					$data_obatAlergi[] = $obatAlergi;
				}
			}
			
			$obatAlergi = array();
			$no = 1;
			if($data_obatAlergi){
				foreach($data_obatAlergi as $alergi){
					foreach ($alergi as $a_obat){
						$a_obat['nomor'] = $no++; 
						$a_obat['tanggal'] = \Carbon\Carbon::parse(@$a_obat['tanggal'])->format('d-m-Y H:i'); 
						$obatAlergi[] = $a_obat; 
					}
				}
			}

			return DataTables::of($obatAlergi)
					->make(true);
		}
		return false;
	}

}

