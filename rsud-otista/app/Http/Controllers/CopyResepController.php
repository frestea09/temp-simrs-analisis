<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Activity;
use App\Apoteker;
use App\Aturanetiket;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganIGD;
use App\MasterEtiket;
use App\Masterobat;
use App\CopyResepDetail;
use App\CopyResep;
use App\Penjualanbebas;
use Modules\Pegawai\Entities\Pegawai;
use App\Rawatinap;
use App\EmrInapPemeriksaan;
use App\EmrInapPerencanaan;
use App\Emr;
use App\JknIcd10;
use App\JknIcd9;
use App\EmrResume;
use App\TakaranobatEtiket;
use App\Penjualandetail;
use App\Penjualan;
use Auth;
use PDF;
use DB;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Tagihan;
use Yajra\DataTables\DataTables;
use Modules\Registrasi\Entities\Carabayar;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Folio;
use App\UangRacik;
use App\ResepNoteDetail;
use App\historiHapusFaktur;
use App\ResepNote;
use Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\RujukanObat;

class CopyResepController extends Controller
{
	//penjulan ter
	public function indexRajal()
	{
		session()->forget('penjualanid');
		session()->forget('idpenjualan');
		session()->forget('next_resep');
		$unit = 'Jalan';
		$data['tga']	= '';
		$data['tgb']	= '';
		$date = date('Y-m-d', strtotime('-2 days'));

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.copy-resep.irj', compact('data', 'unit'))->with('no', 1);
	}

	public function indexRajalBy(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$unit = $request['unit'];

		return view('penjualan.copy-resep.irj', compact('data', 'unit'))->with('no', 1);
	}

	public function indexDarurat()
	{
		$unit = 'Darurat';
		$date = date('Y-m-d', strtotime('-2 days'));
		$data['tga']	= '';
		$data['tgb']	= '';

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.copy-resep.igd', compact('unit', 'data'))->with('no', 1);;
	}

	public function indexDaruratBy(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);


		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$unit = $request['unit'];
		return view('penjualan.copy-resep.igd', compact('data', 'unit'))->with('no', 1);
	}

	public function indexIrna()
	{
		$date = date('Y-m-d', strtotime('-10 days'));

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.copy-resep.irna', compact('data'))->with('no', 1);
	}

	public function indexIrnaBy(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw', 'pasiens.no_rm_lama')
			->get();
		return view('penjualan.copy-resep.irna', compact('data'))->with('no', 1);
	}

	//PENJUALAN BEBAS BARU
	public function indexBebas()
	{
		session()->forget('idpenjualan');
		// $data['barang'] = Masterobat::all();
		$data['barang'] = Masterobat::where('saldo', '!=', 0)->get();


		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['today'] = Penjualanbebas::join('registrasis', 'penjualanbebas.id', '=', 'registrasis.id')
			->where('penjualanbebas.created_at', 'like', date('Y-m-d') . '%')
			->select('registrasis.id', 'penjualanbebas.*')->get();
		return view('penjualan.copy-resep.penjualanBebas', $data)->with('no', 1);
	}

	public function indexBebasBy(Request $request)
	{
		session()->forget('idpenjualan');
		$data['barang'] = Masterobat::where('saldo', '!=', 0)->get();
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['today'] = Penjualanbebas::join('registrasis', 'penjualanbebas.id', '=', 'registrasis.id')
			->where('penjualanbebas.created_at', 'like', valid_date($request['tga']) . '%')
			->select('registrasis.id', 'registrasis.lunas', 'penjualanbebas.*')
			->get();
		return view('penjualan.copy-resep.penjualanBebas', $data)->with('no', 1);
	}

	public function indexRujukan()
	{
		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.created_at', 'like', date('Y-m-d') . '%')
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.copy-resep.rujukan', compact('data'))->with('no', 1);
	}

	public function indexRujukanBy(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);
		$data = Registrasi::with('obat_rujukan')->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.copy-resep.rujukan', compact('data'))->with('no', 1);
	}

	public function saveSuratRujukan(Request $request)
	{
		$registrasi = Registrasi::find($request->registrasi_id);
		$cek = RujukanObat::where('registrasi_id', $registrasi->id)->first();
		$surat = $request->surat;
		if ($cek) {
			$rujukan = $cek;
		} else {
			$rujukan = new RujukanObat();
		}
		$rujukan->pasien_id		= $registrasi->pasien_id;
		$rujukan->registrasi_id = $registrasi->id;

		if ($surat == "resistensi") {
			$rujukan->diagnosa		= $request->diagnosa;
			$rujukan->nama_obat		= $request->nama_obat;
		} else {
			$rujukan->rumah_sakit	= $request->rumah_sakit;
			$rujukan->riwayat		= json_encode($request->riwayat);
		}
		if ($rujukan->save()) {
			return response()->json('Berhasil membuat rujukan');
		} else {
			return response()->json('Gagal membuat rujukan');
		}
	}

	public function cetakSuratRujukan(Request $request, $id)
	{
		$data['surat'] = $request->surat;
		$data['rujukan'] = RujukanObat::find($id);
		$data['pasien'] = Pasien::find($data['rujukan']->pasien_id);
		$data['registrasi'] = Registrasi::find($data['rujukan']->registrasi_id);
		$pdf = PDF::loadView('penjualan.copy-resep.cetakRujukan', $data);
		$pdf->setPaper('A4', 'portrait');
		return $pdf->stream();
	}

	public function hapusObatRujukan($id)
	{
		$rujukan = RujukanObat::find($id);
		if (!$rujukan) {
			return response()->json(['message' => 'Data tidak ditemukan.'], 404);
		}
		try {
			$rujukan->delete();
			return response()->json(['message' => 'Data rujukan berhasil dihapus.']);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Gagal menghapus data.'], 500);
		}
	}

	public function getDataMasterObat($id)
	{
		$obat = Masterobat::where('id', $id)->first();
		return response()->json(['obat' => $obat]);
	}

	public function history($registrasi_id)
	{
		$penjualan = CopyResep::where('registrasi_id', $registrasi_id)->get();
		return view('penjualan.copy-resep.history', compact('penjualan'));
	}

	public function form_penjualan($idpasien, $idreg, $penjualan_id = '')
	{
		// return $data; die;
		// dd($idpasien,$idreg);

		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);

		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($idpasien);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = CopyResep::find(session('penjualanid'));
		$data['detail'] = CopyResepDetail::where('no_resep', '=', session('next_resep'))->get();
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::where('id', 2)->get();
		$data['penjualanid'] = session('penjualanid');
		$data['next_resep'] = session('next_resep');
		// return $data; die;
		return view('penjualan.copy-resep.form_penjualan', $data)->with('idreg', $idreg);
	}

	public function form_edit_penjualan($idpasien, $idreg, $penjualan_id = '')
	{
		// return $penjualan_id; die;

		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);

		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = CopyResep::find($penjualan_id);
		$data['detail'] = CopyResepDetail::where('no_resep', '=', $data['penjualan']->no_resep)->get();
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::where('id', 2)->get();
		$data['penjualanid'] = session(['penjualanid' => $penjualan_id]);
		$data['next_resep'] = session(['next_resep' => $data['penjualan']->no_resep]);
		// return $data; die;
		return view('penjualan.copy-resep.form_penjualan', $data)->with('idreg', $idreg);
	}

	//simpan
	public function saveDetail(Request $request)
	{
		// return $request; die;
		// request()->validate(['masterobat_id' => 'required']);
		$validator = Validator::make($request->all(), [
			'masterobat_id' => 'required',
			'expired' => 'required',
		]);
		if ($validator->fails()) {
			$res = [
				"status" => false,
				"msg" => $validator->errors()->first()
			];
			return response()->json($res);
		}
		if (!session('next_resep')) {
			$jenis = Registrasi::find($request['idreg'])->status_reg;
			$reg = Registrasi::find($request['idreg']);
			if (substr($jenis, 0, 1) == 'J') {
				$count = CopyResep::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
				$next_resep = 'FRJ' . date('YmdHis');
			} elseif (substr($jenis, 0, 1) == 'I') {
				$count = CopyResep::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
				$next_resep = 'FRI' . date('YmdHis');
			} elseif (substr($jenis, 0, 1) == 'G') {
				$count = CopyResep::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
				$next_resep = 'FRD' . date('YmdHis');
			}
			//Save Penjualan
			$p = new CopyResep();
			$p->no_resep = $next_resep;
			$p->dokter_id = $request['dokter_id'];
			$p->user_id = Auth::user()->id;
			$p->registrasi_id = $request['idreg'];
			$p->save();
			session(['penjualanid' => $p->id]);
			session(['next_resep' => $next_resep]);
		}
		$obat = Masterobat::select('id')->where('id', $request['masterobat_id'])->first();
		$cekdata = CopyResepDetail::where('no_resep', session('next_resep'))->where('masterobat_id', $request['masterobat_id'])->first();
		if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
			$harga = rupiah($request['racikan']);
		}
		if ($cekdata) {
			if (cek_jenispasien($request['idreg']) == '1') {
				$harga = Masterobat::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
			} else {
				$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
			}

			// $detail              = CopyResepDetail::where('no_resep', session('next_resep'))->where('masterobat_id', $request['masterobat_id'])->first();
			$detail              = CopyResepDetail::where('no_resep', session('next_resep'))->where('masterobat_id', $request['masterobat_id'])->first();
			$detail->jumlah      = $detail->jumlah + $request['jumlah'] + $request['jml_kronis'];
			$detail->jml_kronis  = $request['jml_kronis'];
			$detail->hargajual   = $harga * ($detail->jumlah + $request['jumlah'] + $request['jml_kronis']);
			$detail->hargajual_kronis = $harga * ($detail->jml_kronis + $request['jumlah'] + $request['jml_kronis']);
			$detail->update();
			return response()->json(['sukses' => true]);
		} else {
			if (cek_jenispasien($request['idreg']) == '1') {
				$harga = Masterobat::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
			} else {
				$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
			}
			$d = new CopyResepDetail();
			$d->penjualan_id = session('penjualanid');
			$d->no_resep = session('next_resep');
			$d->masterobat_id = $obat->id;
			$d->jml_kronis  = $request['jml_kronis'];
			$d->jumlah = $request['jumlah'];
			$d->hargajual = $harga * $request['jumlah'];
			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$d->tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$d->tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$d->tipe_rawat = 'TI';
			}
			$d->expired = valid_date($request['expired']);
			$d->informasi1 = $request['informasi1'];
			$d->hargajual_kronis = $harga * $request['jml_kronis'];
			$d->etiket = $request['tiket'] . ' ' . $request['komposisi'] . ' ' . $request['takaran'] . ' ' . $request['waktu'];
			$d->cetak = $request['cetak'];
			$d->save();
		}
		return response()->json(['sukses' => true, 'id' => session('penjualanid'), 'jenis' => $request['idreg']]);
	}

	public function deleteDetail($id, $idpasien, $idreg, $penjualan_id)
	{
		CopyResepDetail::find($id)->delete();
		return redirect('copy-resep/form-penjualan/' . $idpasien . '/' . $idreg . '/' . $penjualan_id);
	}

	public function saveTotal(Request $request)
	{
		$jasa_racik   	= rupiah($request['jasa_racik']);
		$cara_bayar		= $request['cara_bayar'];
		$pembuat_resep = $request['pembuat_resep'];
		$penjualan_id 	= $request['penjualan_id'];
		// return $request; die;
		DB::transaction(function () use ($penjualan_id, $pembuat_resep, $cara_bayar, $jasa_racik) {
			$total = 0;
			$pj = CopyResep::find($penjualan_id);
			$pj->pembuat_resep = $pembuat_resep;
			$pj->update();

			// Tambahan 23 Juni 20
			$det = CopyResepDetail::where('penjualan_id', $penjualan_id)->get();
			$jenis;
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
				$jenis = $d->tipe_rawat;
			}

			$reg = Registrasi::find($pj->registrasi_id);

			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->cara_bayar_id = $cara_bayar;
			$fol->total = $total;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = $jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = $jenis;
			$fol->pasien_id = $reg->pasien_id;
			$fol->dokter_id = $reg->dokter_id;
			$fol->poli_id = $reg->poli_id;
			$fol->user_id = Auth::user()->id;
			$fol->save();

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = 1; //$reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = 0;
			$tag->harus_dibayar = $total;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();
			// End Tambahan
		});
		$jenis = substr($request['tipe_rawat'], 0, 1);
		session()->forget('idpenjualan');
		session()->forget('next_resep');
		return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis]);
	}

	//copy-resep
	public function cetakDetailCopyResep($penjualan_id = '')
	{
		session()->forget('penjualanid');
		$data['penjualan'] = CopyResep::find($penjualan_id);
		$data['reg']       = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail']    = CopyResepDetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['obat']	   = CopyResepDetail::join('masterobats', 'copy_resep_details.masterobat_id', '=', 'masterobats.id')
			->where('copy_resep_details.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', '!=', 4)
			->sum('copy_resep_details.hargajual');
		$data['alkes']	= CopyResepDetail::join('masterobats', 'copy_resep_details.masterobat_id', '=', 'masterobats.id')
			->where('copy_resep_details.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', 4)
			->sum('copy_resep_details.hargajual');
		$data['total'] = $data['detail']->sum('hargajual');
		$data['uang_racik'] = $data['detail']->sum('uang_racik');

		return view('farmasi.laporan.detailCopyResepBC', $data)->with('no', 1);
	}

	//resep
	public function cetakDetailResep($penjualan_id = '')
	{
		session()->forget('penjualanid');

		$data['penjualan'] = CopyResep::find($penjualan_id);
		// dd($data['penjualan']);
		$data['reg']       = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail']    = CopyResepDetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['obat']	   = CopyResepDetail::join('masterobats', 'copy_resep_details.masterobat_id', '=', 'masterobats.id')
			->where('copy_resep_details.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', '!=', 4)
			->sum('copy_resep_details.hargajual');
		$data['alkes']	= CopyResepDetail::join('masterobats', 'copy_resep_details.masterobat_id', '=', 'masterobats.id')
			->where('copy_resep_details.penjualan_id', $data['penjualan']->id)
			->where('masterobats.kategoriobat_id', 4)
			->sum('copy_resep_details.hargajual');
		$data['total'] = $data['detail']->sum('hargajual');
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		// return $data; die;,
		// return view('farmasi.laporan.detailCopyResep', $data)->with('no', 1);

		$pdf = PDF::loadView('farmasi.laporan.detailCopyResep', $data);
		$pdf->setPaper('A4', 'potret');
		return $pdf->stream();
	}


	//cetak Resep Farmasi

	public function cetakDetailResepFarmasi(Request $request, $penjualan_id = '')
	{
		session()->forget('penjualanid');
		if ($request->tte == "true") {
			$resepNote = ResepNote::where('penjualan_id', $penjualan_id)->first();
			$tte = json_decode($resepNote->tte);
			$base64 = $tte->base64_signed_file;

			$pdfContent = base64_decode($base64);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
			]);
		} else {
			$data['nama_racikan'] = '';
			$data['penjualan'] = Penjualan::find($penjualan_id);
			$data['resep_note'] = ResepNote::where('penjualan_id', $penjualan_id)->first();
			$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
			$data['pegawai'] = Pegawai::all()->keyBy('id')->toArray();
			$resume = EmrResume::where('registrasi_id', $data['reg']->id)->orderBy('id', 'DESC')->first();
			$data['resume'] = $resume ? json_decode($resume->content, true) : null;
			$data['asesmen_perawat'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
			$data['fisik'] = $data['asesmen_perawat'] ? json_decode($data['asesmen_perawat']->fisik, true) : null;
			$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)
				->with('masterobat')
				->groupBy('masterobat_id')
				->selectRaw('sum(jumlah) as jumlah, masterobat_id,etiket,informasi1,informasi2, cara_minum')
				->get();
			// $data['detail_racikan'] = Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $data['penjualan']->id)->get();
			$data['detail_racikan'] = Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $data['penjualan']->id)
				->with('masterobat')
				->groupBy('masterobat_id')
				->selectRaw('sum(jumlah) as jumlah, masterobat_id,etiket,informasi1,informasi2')->get();
			// $data['penjualan_detail'] = Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $data['penjualan']->id)->first();
			if ($data['resep_note']) {
				$data['nama_racikan'] = $data['resep_note']->nama_racikan;
				$data['no_resep'] = $data['resep_note']->no_resep;
			} else {
				$data['nama_racikan'] = '';
				$data['no_resep']   = '';
			}
			@$data['get_note'] = @Penjualandetail::where('penjualan_id', $data['penjualan']->id)
				->where('catatan', '!=', 'null')
				->first();
			// $data['obat']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			// 	->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			// 	->where('masterobats.kategoriobat_id', '!=', 4)
			// 	->groupBy('penjualandetails.masterobat_id')
			// 	->sum('penjualandetails.hargajual');
			// $data['alkes']	= Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
			// 	->where('penjualandetails.penjualan_id', $data['penjualan']->id)
			// 	->where('masterobats.kategoriobat_id', 4)
			// 	->groupBy('penjualandetails.masterobat_id')
			// 	->sum('penjualandetails.hargajual');
			// $data['total'] = $data['detail']->sum('hargajual');
			// $data['uang_racik'] = $data['detail']->sum('uang_racik');
			// $data['folio']	= Folio::where('namatarif', $data['penjualan']->no_resep)->get()->first();

			// return view('farmasi.laporan.detail', $data)->with('no', 1);
			$pdf = PDF::loadView('farmasi.laporan.detailCopyResep', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		}
	}

	public function cetakDetailResepFarmasiTanpaApotik(Request $request, $penjualan_id = '')
	{
		session()->forget('penjualanid');
		if ($request->tte == "true") {
			$resepNote = ResepNote::where('penjualan_id', $penjualan_id)->first();
			$tte = json_decode($resepNote->tte);
			$base64 = $tte->base64_signed_file;

			$pdfContent = base64_decode($base64);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
			]);
		} else {
			$data['nama_racikan'] = '';
			$data['penjualan'] = Penjualan::find($penjualan_id);
			$data['resep_note'] = ResepNote::where('penjualan_id', $penjualan_id)->first();
			$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
			$data['pegawai'] = Pegawai::all()->keyBy('id')->toArray();
			$resume = EmrResume::where('registrasi_id', $data['reg']->id)->orderBy('id', 'DESC')->first();
			$data['resume'] = $resume ? json_decode($resume->content, true) : null;
			$data['asesmen_perawat'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
			$data['fisik'] = $data['asesmen_perawat'] ? json_decode($data['asesmen_perawat']->fisik, true) : null;

			$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)
				->with('masterobat')
				->groupBy('masterobat_id')
				->selectRaw('sum(jumlah) as jumlah, masterobat_id,etiket,informasi1,informasi2, cara_minum')
				->get();
			$data['detail_racikan'] = Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $data['penjualan']->id)
				->with('masterobat')
				->groupBy('masterobat_id')
				->selectRaw('sum(jumlah) as jumlah, masterobat_id,etiket,informasi1,informasi2')->get();
			if ($data['resep_note']) {
				$data['nama_racikan'] = $data['resep_note']->nama_racikan;
				$data['no_resep'] = $data['resep_note']->no_resep;
			} else {
				$data['nama_racikan'] = '';
				$data['no_resep']   = '';
			}
			@$data['get_note'] = @Penjualandetail::where('penjualan_id', $data['penjualan']->id)
				->where('catatan', '!=', 'null')
				->first();

			$pdf = PDF::loadView('farmasi.laporan.detailCopyResepTanpaApotik', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		}
	}

	//cetak copy resep farmasi

	public function cetakDetailCopyResepFarmasi($penjualan_id = '')
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



		return view('farmasi.laporan.detailCopyResepBC', $data)->with('no', 1);
	}

	public function cetakDetailKronisCopyResep($penjualan_id = '')
	{
		session()->forget('penjualanid');
		$data['penjualan'] = CopyResep::find($penjualan_id);
		// return $data['penjualan']; die;
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail'] = CopyResepDetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		$data['total'] = $data['detail']->sum('hargajual_kronis');
		return view('farmasi.laporan.fakturkroniscopyresep', $data)->with('no', 1);
	}

	public function cetak_etiket($penjualan_id = '')
	{
		$data['penjualan'] = CopyResep::find($penjualan_id);
		return view('farmasi.laporan.etiket-pdf', $data);
		// $pdf = PDF::loadView('farmasi.laporan.etiket-pdf', $data)->setPaper([0, 0, 99.212598, 141.732283], 'landscape');;
		// return $pdf->stream();
	}

	public function hapusPenjualanBebasBaru($registrasi_id)
	{
		$detail = Penjualanbebas::where('registrasi_id', $registrasi_id);
		$detail->delete();

		$reg = Registrasi::find($registrasi_id);
		$reg->delete();

		return back();
	}

	public function save_penjualan_bebas_baru(Request $request)
	{
		request()->validate(['nama' => 'required', 'alamat' => 'required']);

		$count = CopyResep::where('no_resep', 'LIKE', 'FPB' . date('Ymd') . '%')->count() + 1;
		$next_resep = 'FPB' . date('Ymd') . '-' . sprintf('%04s', $count);
		DB::transaction(function () use ($request, $next_resep) {
			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = '0';
			$reg->status_reg = 'A1'; //status registrasi apotik
			$reg->tracer = '1';
			$reg->cetak_barcode = '1';
			$reg->cetak_sep = '1';
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->user_create = Auth::user()->id;
			$reg->save();

			$pb = new Penjualanbebas();
			$pb->registrasi_id = $reg->id;
			$pb->nama = $request['nama'];
			$pb->alamat = $request['alamat'];
			$pb->dokter = !empty($request['dokter']) ? $request['dokter'] : ' ';
			$pb->save();

			$p = new CopyResep();
			$p->no_resep = $next_resep;
			$p->pembuat_resep = $request['pembuat_resep'];
			$p->user_id = Auth::user()->id;
			$p->registrasi_id = $reg->id;
			if (!empty($reg->id)) {
				$p->save();
			}
			if ($p) {
				session(['idpenjualan' => $p->id, 'reg_id' => $reg->id]);
			}
		});
		return redirect('copy-resep/formpenjualanbebasbaru/0/' . session('reg_id') . '/' . session('idpenjualan'));
	}

	public function editPenjualanBebasBaru($idreg, $penjualan_id = '')
	{
		session(['idpenjualan' => $penjualan_id, 'reg_id' => $idreg]);
		return redirect('copy-resep/formpenjualanbebasbaru/0/' . session('reg_id') . '/' . session('idpenjualan'));
	}

	public function form_penjualan_bebas_baru($idpasien, $idreg, $penjualan_id = '')
	{
		$data['barang'] = Masterobat::where('saldo', '!=', 0)->get();
		$data['reg'] = Registrasi::find($idreg);
		$data['pasien'] = Pasien::find($idpasien);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::where('id', 2)->get();
		if ($penjualan_id) {
			$data['penjualan'] = CopyResep::find($penjualan_id);
			$data['detail'] = CopyResepDetail::where('penjualan_id', '=', $penjualan_id)->get();
			$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
			$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
			$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
			$data['penj_bebas'] = PenjualanBebas::where('registrasi_id', $idreg)->first();
			$data['no'] = 1;
		}
		return view('penjualan.copy-resep.form_penjualan_bebas', $data)->with('idreg', $idreg);
	}

	public function save_detail_bebas_baru(Request $request)
	{
		// return $request; die;
		request()->validate(['masterobat_id' => 'required']);
		$obat_batch = Masterobat::find($request['masterobat_id']);
		$d = new CopyResepDetail();
		$d->penjualan_id = $request['penjualan_id'];
		$d->no_resep = $request['no_resep'];
		$d->masterobat_id = $request['masterobat_id'];
		$d->jumlah = $request['jumlah'];
		if (cek_jenispasien($request['idreg']) == '1') {
			$harga = Masterobat::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
		} else {
			$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
		}
		$d->hargajual = $harga * $request['jumlah'];
		$d->etiket = $request['tiket'] . ' ' . $request['komposisi'] . ' ' . $request['takaran'] . ' ' . $request['waktu'];
		$d->cetak = $request['cetak'];
		$d->save();
		return redirect('copy-resep/formpenjualanbebasbaru/' . $request['pasien_id'] . '/' . $request['idreg'] . '/' . $request['penjualan_id']);
	}

	public function deleteDetailBebasBaru($id, $idpasien, $idreg, $penjualan_id)
	{
		CopyResepDetail::find($id)->delete();
		return redirect('copy-resep/formpenjualanbebasbaru/' . $idpasien . '/' . $idreg . '/' . $penjualan_id);
	}

	public function save_totalpenjualan_bebas_baru(Request $request)
	{
		$penjualan_id = $request['id_penjualan'];
		return redirect('copy-resep/cetak-detail-bebas/' . $penjualan_id);
	}

	public function cetakDetailBebas($penjualan_id = '')
	{
		$data['penjualan'] = CopyResep::find($penjualan_id);
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['pasien'] = \App\Penjualanbebas::where('registrasi_id', $data['reg']->id)->first();
		$data['detail'] = CopyResepDetail::where('penjualan_id', $data['penjualan']->id)->get();
		$data['total'] = $data['detail']->sum('hargajual');
		$data['total_uang_racik'] = $data['detail']->sum('uang_racik');
		return view('farmasi.laporan.detailBebasCopyResep', $data)->with('no', 1);
	}

	public function cetakResepDokter($penjualan_id)
	{
		$find = ResepNote::where('penjualan_id', $penjualan_id)->first();
		$tte    = json_decode($find->tte);

		if (!empty($tte)) {
			$base64 = $tte->base64_signed_file;

			$pdfContent = base64_decode($base64);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
				// 'Content-Disposition' => 'attachment; filename="Resep Dokter-' . $find->id . '.pdf"',
			]);
		} else {
			$dt['detail'] = ResepNoteDetail::where('resep_note_id', $find->id)->get();
			$dt['resep_note'] = $find;
			$dt['reg'] = Registrasi::find($find->registrasi_id);
			$dt['nama_racikan'] = $find->nama_racikan;
			$dt['no_resep'] = $find->no_resep;
			$pdf = PDF::loadView('farmasi.laporan.resepDokter', $dt);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	//resep
	public function bundlingResep($registrasi_id)
	{
		$mode = request()->query('mode');
		// Resep Dokter
		if ($mode == 'resep-dokter') {
			$data['reg'] = Registrasi::findOrFail($registrasi_id);
			$data['pasien'] = Pasien::find($data['reg']->pasien_id);
			$data['pegawai'] = Pegawai::all()->keyBy('id')->toArray();
			$data['penjualan'] = Penjualan::where('registrasi_id', $registrasi_id)->get();
			$data['catatans'] = Penjualan::join('resep_note', 'resep_note.penjualan_id', '=', 'penjualans.id')
				->where('penjualans.registrasi_id', $data['reg']->id)
				->select('resep_note.id', 'penjualans.catatan')
				->first();
			$resume = EmrResume::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
			$data['resume'] = $resume ? json_decode($resume->content, true) : null;
			$data['asesmen_perawat'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
			$data['fisik'] = $data['asesmen_perawat'] ? json_decode($data['asesmen_perawat']->fisik, true) : null;
	
			$pdf = PDF::loadView('farmasi.laporan.bundlingResepDokter', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream('resep-dokter.pdf');
		}
		// RESEP
		$data['nama_racikan'] = '';
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['pegawai'] = Pegawai::all()->keyBy('id')->toArray();
		$data['registrasi'] = $data['reg'];
		$resume = EmrResume::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
		$data['resume'] = $resume ? json_decode($resume->content, true) : null;
		$tteContent = @json_decode(@$data['reg']->tte_bundling_resep)->base64_signed_file;
		$data['catatans'] = Penjualan::join('resep_note', 'resep_note.penjualan_id', '=', 'penjualans.id')
			->where('penjualans.registrasi_id', $data['reg']->id)
			->select('resep_note.id', 'penjualans.catatan')
			->first();
		
		//E-RESUME
		$data['dokter'] = Pegawai::find($data['reg']->dokter_id);
        $poliBpjs = baca_poli_bpjs($data['reg']->poli_id);

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
        $data['rawatinap'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
        $data['resume_inap'] = EmrInapPerencanaan::where('registrasi_id',  '=', $data['reg']->id)->where('type', 'resume')->get();
        $data['resume'] = EmrInapPerencanaan::where('registrasi_id',  '=', $data['reg']->id)->where('type', 'resume')->orderBy('created_at', 'desc')->first();
        $data['content'] = json_decode(@$data['resume']->keterangan, true);
        // END E-Resume Rawat Inap

        $userDokterPoli = Pegawai::where('kategori_pegawai', 1)->pluck('user_id');
        $data['cppt'] = Emr::where('registrasi_id', $data['reg']->id)->whereIn('user_id', $userDokterPoli)->where('unit', '!=', 'sbar')->orderBy('id', 'desc')->first();
        $data['cppt_igd'] = Emr::where('registrasi_id', $data['reg']->id)->where('unit', 'igd')->whereIn('user_id', $userDokterPoli)->orderBy('id', 'desc')->first();
        $data['cpptPerawat'] = Emr::where('registrasi_id', $data['reg']->id)->whereNotIn('user_id', $userDokterPoli)->orderBy('id', 'desc')->first();

        $data['icd10Primary'] = JknIcd10::where('registrasi_id', $data['reg']->id)->where('kategori', 'Primary')->get();
        $data['icd10Secondary'] = JknIcd10::where('registrasi_id', $data['reg']->id)->whereNull('kategori')->get();
        $data['icd9'] = JknIcd9::where('registrasi_id', $data['reg']->id)->get();


        $data['folios'] = Folio::where('registrasi_id', $data['reg']->id)
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

		if (empty($tteContent)) {
			$data['penjualan'] = Penjualan::where('registrasi_id', $registrasi_id)->get();
			// dd($data['reg']->no_sep);
			@$sep	   = @$this->cetak_sep_new($data['reg']->no_sep);
			// dd($sep);
			$data['sep']		= @$sep['sep'];
			$data['rujukan']	= @$sep['rujukan'];
			$data['perujuk']	= @$sep['perujuk'];
			// SEP

			$data['rujukanObat'] = RujukanObat::where('registrasi_id', $data['reg']->id)->first();
			$data['rujukanObatOld'] = RujukanObat::where('pasien_id', $data['pasien']->id)->whereNotNull('riwayat')->first();
			$data['asesmen_perawat'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
			$data['fisik'] = $data['asesmen_perawat'] ? json_decode($data['asesmen_perawat']->fisik, true) : null;

			$pdf = PDF::loadView('farmasi.laporan.bundlingResep', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} else {
			$pdfContent = base64_decode($tteContent);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
				'Content-Disposition' => 'attachment; filename="bundling-' . $data['reg']->id . '.pdf"',
			]);
		}
	}

	public function testEresume($registrasi_id)
	{
		$data['reg'] = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::find($data['reg']->dokter_id);
        $poliBpjs = baca_poli_bpjs($data['reg']->poli_id);
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
        $data['rawatinap'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
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
	}

	public function tteBundlingResep(Request $request, $registrasi_id)
	{
		// RESEP
		$data['nama_racikan'] = '';
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['penjualan'] = Penjualan::where('registrasi_id', $registrasi_id)->get();
		$data['pegawai'] = Pegawai::all()->keyBy('id')->toArray();
		$resume = EmrResume::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
		$data['resume'] = json_decode($resume->content, true);
		$data['asesmen_perawat'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
		$data['fisik'] = $data['asesmen_perawat'] ? json_decode($data['asesmen_perawat']->fisik, true) : null;
		// dd($data['reg']->no_sep);
		@$sep	   = @$this->cetak_sep_new($data['reg']->no_sep);
		// dd($sep);
		$data['sep']		= @$sep['sep'];
		$data['rujukan']	= @$sep['rujukan'];
		$data['perujuk']	= @$sep['perujuk'];
		// SEP

		if ($request->proses_tte) {
			if (tte()) {
				// Generate QR code dengan gambar
				$qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
				// Simpan QR code dalam file
				$qrCodePath = uniqid() . '.png';
				File::put(public_path($qrCodePath), $qrCode);

				$data['proses_tte'] = true;
				$data['qrcode'] = $qrCodePath;

				$pdf = PDF::loadView('farmasi.laporan.bundlingResep', $data);
				$pdfContent = $pdf->output();

				// Create temp pdf file
				$filePath = uniqId() . '-bundling-resep.pdf';
				File::put(public_path($filePath), $pdfContent);
				$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
				log_esign($data['reg']->id, $tte->response, "bundling-resep", $tte->httpStatusCode);

				$resp = json_decode($tte->response);

				if ($tte->httpStatusCode == 200) {
					$data['reg']->tte_bundling_resep = $tte->response;
					$data['reg']->update();
					Flashy::success('Berhasil melakukan tandatangan !');
					return redirect()->back();
				} elseif ($tte->httpStatusCode == 400) {
					if (isset($resp->error)) {
						Flashy::error($resp->error);
						return redirect()->back();
					}
				} elseif ($tte->httpStatusCode == 500) {
					Flashy::error($tte->response);
					return redirect()->back();
				}
				Flashy::error('Gagal melakukan tandatangan !');
				return redirect()->back();
			} else {
				// Generate QR code dengan gambar
				$qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
				// Simpan QR code dalam file
				$qrCodePath = uniqid() . '.png';
				File::put(public_path($qrCodePath), $qrCode);

				$data['tte_nonaktif'] = true;
				$data['qrcode'] = $qrCodePath;

				$pdf = PDF::loadView('farmasi.laporan.bundlingResep', $data);
				$pdfContent = $pdf->output();
				File::delete(public_path($qrCodePath));

				$data['reg']->tte_bundling_resep = json_encode((object) [
					"base64_signed_file" => base64_encode($pdfContent),
				]);;
				$data['reg']->update();

				Flashy::success('Berhasil melakukan tandatangan !');
				return redirect()->back();
			}
		}
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
		// @$tglperiksa = '2024-01-02';
		// dd(@$nomorkartu,$tglperiksa);
		// if(@$nomorkartu && @$tglperiksa){
		// 	$cek_finger = $this->cekFinger(@$nomorkartu,@$tglperiksa);
		// 	$data['kode_finger'] = @$cek_finger[1]['kode'];
		// 	$data['status_finger'] = @$cek_finger[1]['status'];
		// }
		// dd($cek_finger);

		return $data;
		// $pdf = PDF::loadView('sep.cetak_sep_new', $data);
		// // $customPaper = array(0, 0, 793.7007874, 340);
		// $customPaper = array(0, 0, 793.7007874, 420);
		// $pdf->setPaper($customPaper);
		// // return $pdf->download('lab.pdf');
		// return $pdf->stream();
	}
	// }
}
