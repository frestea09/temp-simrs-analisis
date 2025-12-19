<?php

namespace App\Http\Controllers;

use Activity;
use App\Apoteker;
use App\Aturanetiket;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganIGD;
use App\MasterEtiket;
use App\RegistrasiDummy;
use App\masterCaraMinum;
use App\Masterobat;
use App\Penjualan;
use Modules\Kamar\Entities\Kamar;
use App\Penjualanbebas;
use Modules\Pegawai\Entities\Pegawai;
use App\Penjualandetail;
use App\Rawatinap;
use App\TakaranobatEtiket;
use Auth;
use Validator;
use Illuminate\Support\Facades\File;
use Cart;
use DB;
use PDF;
use Illuminate\Http\Request;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Tagihan;
use Yajra\DataTables\DataTables;
use Modules\Registrasi\Entities\Carabayar;
use MercurySeries\Flashy\Flashy;
use App\LogistikBatch;
use App\UangRacik;
use App\historiHapusFaktur;
use Carbon\Carbon;
use App\ResepNote;
use App\ResepNoteDetail;
use App\Logistik\LogistikNoBatch;
use App\Logistik\LogistikStock;
use App\Nomorrm;
use App\Satuanjual;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Config\Entities\Config;
use Modules\Icd10\Entities\Icd10;
use Modules\Icd9\Entities\Icd9;
use Modules\Poli\Entities\Poli;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\EsignLog;


class PenjualanController extends Controller
{

	public function indexRajal()
	{
		session()->forget('penjualanid');
		session()->forget('idpenjualan');
		session()->forget('next_resep');
		$unit = 'Jalan';
		$data['tga']	= '';
		$data['tgb']	= '';
		// $tgl = valid_date($request['tga']);
		$date = date('Y-m-d', strtotime('-2 days'));

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			// ->where('registrasis.created_at', 'LIKE', $tgl . '%')
			// ->where('pasiens.no_rm', $request['no_rm'])
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		// $histori_irj = HistorikunjunganIRJ::where('registrasi_id', $data->registrasi_id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		// $histori_igd = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
		// 	->where('histori_kunjungan_igd.registrasi_id', $data->registrasi_id)
		// 	->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
		// 	->get();
		// $unit = $request['unit'];
		$polis = '';
		return view('penjualan.irj', compact('data', 'unit', 'polis'))->with('no', 1);
		// return view('penjualan.index', compact('unit'));
	}

	public function indexDarurat()
	{
		session()->forget('penjualanid');
		session()->forget('idpenjualan');
		session()->forget('next_resep');
		$unit = 'Darurat';
		$date = date('Y-m-d', strtotime('-2 days'));
		$data['tga']	= '';
		$data['tgb']	= '';

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			// ->where('registrasis.created_at', 'LIKE', $tgl . '%')
			// ->where('pasiens.no_rm', $request['no_rm'])
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.igd', compact('unit', 'data'))->with('no', 1);;
	}

	public function indexRajalBy(Request $request)
	{
		if (!$request['tga'] || !$request['tgb']) {
			$tga = date('Y-m-d');
			$tgb = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
			$tgb = valid_date($request['tgb']);
		}

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tgb . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$unit = $request['unit'];

		return view('penjualan.irj', compact('data', 'unit'))->with('no', 1);
	}

	public function indexDaruratBy(Request $request)
	{
		if (!$request['tga'] || !$request['tgb']) {
			$tga = date('Y-m-d');
			$tgb = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
			$tgb = valid_date($request['tgb']);
		}


		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			// ->whereBetween('registrasis.created_at', [$tgb . ' 00:00:00', $tgb . ' 23:59:59'])
			// ->where('pasiens.no_rm', $request['no_rm'])
			->whereBetween('registrasis.created_at', [$tgb . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$unit = $request['unit'];
		return view('penjualan.igd', compact('data', 'unit'))->with('no', 1);
	}

	public function rawat_inap()
	{
		session()->forget('penjualanid');
		session()->forget('idpenjualan');
		session()->forget('next_resep');
		$date = date('Y-m-d', strtotime('-10 days'));

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			// ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			// ->where('rawatinaps.tgl_keluar', null)
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.irna', compact('data'))->with('no', 1);
	}

	// public function rawat_inap() {
	// 	$date = date('Y-m-d', strtotime('-30 days'));

	// 	$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
	// 		// ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
	// 		// ->where('rawatinaps.tgl_keluar', null)
	// 		->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
	// 		->whereIn('registrasis.status_reg', ['I1','I2','I3'])
	// 		->where('registrasis.pasien_id', '<>', 0)
	// 		->select(
	// 			'registrasis.id as registrasi_id',
	// 			'registrasis.created_at as created_at',
	// 			'registrasis.poli_id',
	// 			'registrasis.bayar',
	// 			'pasiens.id as pasien_id',
	// 			'pasiens.nama',
	// 		  	'pasiens.alamat',
	// 		  	'pasiens.no_rm',
	// 			'pasiens.no_rm_lama',
	// 			'pasiens.rt',
	// 			'pasiens.rw')
	// 		->orderBy('registrasis.id', 'DESC')
	// 		->get();

	// 	return DataTables::of($data)
	// 		->addColumn('jkn', function ($data) {
	// 			return '<a href="/registrasi/igd/jkn/' . $data->id . '" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
	// 		})
	// 		->addColumn('non-jkn', function ($data) {
	// 			return '<a href="/registrasi/igd/umum/' . $data->id . '" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
	// 		})
	// 		->rawColumns(['jkn', 'non-jkn'])
	// 		->make(true);
	// }

	public function rawat_inap_byTanggal(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			// ->join('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			// ->where('rawatinaps.tgl_keluar', null)
			// ->where('pasiens.no_rm', $request['no_rm'])
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw', 'pasiens.no_rm_lama')
			->get();
		return view('penjualan.irna', compact('data'))->with('no', 1);
	}

	public function history($registrasi_id)
	{
		$penjualan = Penjualan::where('registrasi_id', $registrasi_id)->get();
		return view('penjualan.history', compact('penjualan'));
	}

	public function search(Request $request)
	{
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();
		return view('penjualan.index', compact('data', 'keyword'))->with('no', 1);
	}

	public function form_penjualan($idpasien, $idreg, $penjualan_id = '')
	{
		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);

		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($idpasien);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['detail'] = Penjualandetail::where('penjualan_id', '=', $penjualan_id)->get();
		$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		// return $data; die;
		return view('penjualan.form_penjualan', $data)->with('idreg', $idreg);
	}
	public function historyEresep($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$penjualan = ResepNote::with('penjualan.penjualandetail')->where('pasien_id', $reg->pasien_id)->orderBy('created_at', 'desc')->get();
		// $penjualan = ResepNote::where('pasien_id', $reg->pasien_id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();

		return view('penjualan.penjualan-baru.history_eresep', compact('penjualan'));
	}
	public function getMasterObat(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Masterobat::where('nama', 'like', '%' . $term . '%')->limit(15)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->hargajual_jkn)];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->hargajual_kesda)];
			} else {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->hargajual)];
			}
		}
		return \Response::json($formatted_tags);
	}

	public function save_penjualan(Request $request)
	{
		// return $request->all();
		$jenis = Registrasi::find($request['idreg'])->status_reg;
		$reg = Registrasi::find($request['idreg']);
		if (substr($jenis, 0, 1) == 'J') {
			$count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
			$next_resep = 'FRJ' . date('YmdHis');
		} elseif (substr($jenis, 0, 1) == 'I') {
			$count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
			$next_resep = 'FRI' . date('YmdHis');
		} elseif (substr($jenis, 0, 1) == 'G') {
			$count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
			$next_resep = 'FRD' . date('YmdHis');
		}

		//Ubah Note Eresep Jadi Selesai
		$getid = $request['idresep'];

		$resdone = ResepNote::find($getid);
		$resdone->proses = 'selesai';
		$resdone->save();

		DB::transaction(function () use ($request, $next_resep, $reg) {
			$p = new Penjualan();
			$p->no_resep = $next_resep;
			$p->pembuat_resep = $request['pembuat_resep'];
			$p->user_id = Auth::user()->id;
			$p->registrasi_id = $request['idreg'];

			if (!empty($request['idreg'])) {
				$p->save();
			}
			Activity::log('penjualan_' . Auth::user()->name . ' create no struk ' . $next_resep);
			if ($p) {
				session(['idpenjualan' => $p->id]);
			}

			//========================UPDATE Desember 2018====================================

			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $next_resep;
			$fol->total = 0;
			$fol->tarif_id = 10000;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
			$fol->cara_bayar_id = $reg->bayar;
			$fol->poli_tipe = 'A';
			$fol->gudang_id = @Auth::user()->gudang_id;
			$fol->pasien_id = $reg->pasien_id;
			// $fol->dokter_id = $reg->dokter_id;
			$fol->dokter_id = $request['dokter_id'];
			$fol->poli_id = $reg->poli_id;
			$fol->user_id = Auth::user()->id;
			$fol->save();

			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			// $tag->dokter_id = $reg->dokter_id;
			$tag->dokter_id = $request['dokter_id'];
			$tag->diskon = 0;
			$tag->pasien_id = $reg->pasien->id;
			$tag->harus_dibayar = 0;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			//================================================================================

		});
		return redirect('penjualan/formpenjualan/' . $request['pasien_id'] . '/' . $request['idreg'] . '/' . session('idpenjualan'));
	}

	public function save_detail(Request $request)
	{
		//dd($request['tipe_rawat']);
		return $request->all();
		die;
		request()->validate(['masterobat_id' => 'required']);
		$cek = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->count();
		if ($cek >= 1) {
			$pj = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->first();
			$pj->jumlah = $pj->jumlah + $request['jumlah'];
			if (cek_jenispasien($request['idreg']) == '1') {
				$harga = Masterobat::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
			} else {
				$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
			}
			if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
				$harga = rupiah($request['racikan']);
			}
			$pj->hargajual = $pj->hargajual + ($harga * $request['jumlah']);
			$pj->informasi1 = $request['informasi1'];
			$pj->informasi2 = $request['informasi2'];
			$pj->expired = $request['expired'];
			$pj->update();

			$fol = Folio::where('namatarif', $request['no_resep'])->first();
			$fol->total = $fol->total + ($harga * $request['jumlah']);
			$fol->update();

			$tag = Tagihan::where('registrasi_id', $request['idreg'])->orderBy('id', 'desc')->first();
			$tag->harus_dibayar = $tag->harus_dibayar + ($harga * $request['jumlah']);
			$tag->update();
			// Activity::log('penjualan_' . Auth::user()->name . ' menambahkan obat ' . Masterobat::find($request['masterobat_id'])->nama . ' sebanyak ' . $request['jumlah'] . ' ke no struk ' . $request['no_resep']);
		} else {
			$d = new Penjualandetail();
			$d->penjualan_id = $request['penjualan_id'];
			$d->no_resep = $request['no_resep'];
			$d->masterobat_id = $request['masterobat_id'];
			$d->jumlah = $request['jumlah'];
			if (cek_jenispasien($request['idreg']) == '1') {
				$harga = Masterobat::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
			} else {
				$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
			}

			if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
				$harga = rupiah($request['racikan']);
			}

			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$d->tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$d->tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$d->tipe_rawat = 'TI';
			}

			$d->hargajual = $harga * $request['jumlah'];
			$d->informasi1 = $request['informasi1'];
			$d->informasi2 = $request['informasi2'];
			$d->expired = $request['expired'];
			$d->etiket = $request['tiket'] . ' ' . $request['takaran'];
			$d->cetak = $request['cetak'];
			$d->save();

			$fol = Folio::where('namatarif', $request['no_resep'])->first();
			$fol->total = $fol->total + $d->hargajual;
			$fol->update();

			$tag = Tagihan::where('registrasi_id', $request['idreg'])->orderBy('id', 'desc')->first();
			$tag->harus_dibayar = $tag->harus_dibayar + $d->hargajual;
			$tag->update();
			// Activity::log('penjualan_' . Auth::user()->name . ' menambahkan obat ' . Masterobat::find($request['masterobat_id'])->nama . ' sebanyak ' . $request['jumlah'] . ' ke no struk ' . $request['no_resep']);
		}
		return redirect('penjualan/formpenjualan/' . $request['pasien_id'] . '/' . $request['idreg'] . '/' . $request['penjualan_id']);
	}

	public function deleteDetail($id, $idpasien, $idreg, $penjualan_id)
	{
		$obat = Penjualandetail::find($id);

		$fol = Folio::where('namatarif', $obat->no_resep)->first();
		$fol->total = $fol->total - $obat->hargajual;
		$fol->update();

		$tag = Tagihan::where('registrasi_id', $idreg)->orderBy('id', 'desc')->first();
		$tag->harus_dibayar = $tag->harus_dibayar - $obat->hargajual;
		$tag->update();

		Activity::log('penjualan_' . Auth::user()->name . ' menghapus obat ' . Masterobat::find($obat->masterobat_id)->nama . '  dari no struk ' . $obat->no_resep);
		$obat->delete();
		return redirect('penjualan/formpenjualan/' . $idpasien . '/' . $idreg . '/' . $penjualan_id);
	}

	public function save_totalpenjualan($penjualan_id = '')
	{
		return redirect('farmasi/cetak-detail/' . $penjualan_id);
	}

	//PENJUALAN BEBAS
	public function penjualanBebas()
	{
		session()->forget('idpenjualan');
		$data['barang'] = Masterobat::select('id', 'nama', 'hargajual', 'hargajual_jkn')->get();
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['today'] = Penjualanbebas::join('registrasis', 'penjualanbebas.id', '=', 'registrasis.id')
			->where('penjualanbebas.created_at', 'like', date('Y-m-d') . '%')
			->select('registrasis.id', 'penjualanbebas.*')->get();
		return view('penjualan.penjualanBebas', $data)->with('no', 1);
	}

	public function penjualanBebasBytanggal(Request $request)
	{
		session()->forget('idpenjualan');
		$data['barang'] = Masterobat::select('id', 'nama', 'hargajual', 'hargajual_jkn')->get();
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['today'] = Penjualanbebas::join('registrasis', 'penjualanbebas.id', '=', 'registrasis.id')
			->where('penjualanbebas.created_at', 'like', valid_date($request['tga']) . '%')
			->select('registrasis.id', 'registrasis.lunas', 'penjualanbebas.*')
			->get();
		return view('penjualan.penjualanBebas', $data)->with('no', 1);
	}

	public function hapusPenjualanBebas($registrasi_id)
	{
		$detail = Penjualanbebas::where('registrasi_id', $registrasi_id);
		$detail->delete();

		$reg = Registrasi::find($registrasi_id);
		$reg->delete();

		$folio = Folio::where('registrasi_id', $registrasi_id);
		$folio->delete();

		$tagihan = Tagihan::where('registrasi_id', $registrasi_id);
		$tagihan->delete();

		return back();
	}

	public function save_penjualan_bebas(Request $request)
	{
		request()->validate(['nama' => 'required', 'alamat' => 'required']);

		$count = Penjualan::where('no_resep', 'LIKE', 'FPB' . date('Ymd') . '%')->count() + 1;
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

			$p = new Penjualan();
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

			// $d = new Penjualandetail();
			// $d->penjualan_id = $p->id;
			// $d->no_resep = $p->no_resep;
			// $d->masterobat_id = config('app.obatRacikan_id'); //'3427';
			// $d->jumlah = 1;

			// $harga = Masterobat::select('hargajual')->where('id', config('app.obatRacikan_id'))->first()->hargajual;

			// $d->hargajual = $harga * 1;
			// $d->etiket = '';
			// $d->cetak = 'N';
			// $d->save();

		});
		return redirect('penjualan/formpenjualanbebas/0/' . session('reg_id') . '/' . session('idpenjualan'));
	}

	public function editPenjualanBebas($idreg, $penjualan_id = '')
	{
		session(['idpenjualan' => $penjualan_id, 'reg_id' => $idreg]);
		return redirect('penjualan/formpenjualanbebas/0/' . session('reg_id') . '/' . session('idpenjualan'));
	}

	public function form_penjualan_bebas($idpasien, $idreg, $penjualan_id = '')
	{
		// $data['barang'] = Masterobat::select('id', 'nama', 'hargajual', 'hargajual_jkn')->get();
		$data['barang'] = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->get();
		$data['reg'] = Registrasi::find($idreg);
		$data['pasien'] = Pasien::find($idpasien);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		if ($penjualan_id) {
			$data['penjualan'] = Penjualan::find($penjualan_id);
			$data['detail'] = Penjualandetail::where('penjualan_id', '=', $penjualan_id)->get();
			$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
			$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
			$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
			$data['penj_bebas'] = PenjualanBebas::where('registrasi_id', $idreg)->first();
			$data['no'] = 1;
		}
		return view('penjualan.form_penjualan_bebas', $data)->with('idreg', $idreg);
	}

	public function save_detail_bebas(Request $request)
	{
		// return $request; die;
		request()->validate(['masterobat_id' => 'required']);
		$d = new Penjualandetail();
		$d->penjualan_id = $request['penjualan_id'];
		$d->no_resep = $request['no_resep'];
		$d->masterobat_id = $request['masterobat_id'];
		$d->jumlah = $request['jumlah'];
		if (cek_jenispasien($request['idreg']) == '1') {
			$harga = Masterobat::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
		} else {
			$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
		}

		if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
			$harga = rupiah($request['racikan']);
		}
		if ($request['obat_racik'] == 'N') {
			$d->uang_racik = rupiah($request['uang_racik']);
		} else {
			$d->uang_racik = 0;
		}
		$d->hargajual = $harga * $request['jumlah'];
		$d->etiket = $request['tiket'] . ' ' . $request['komposisi'] . ' ' . $request['takaran'] . ' ' . $request['waktu'];
		$d->cetak = $request['cetak'];
		$d->save();
		return redirect('penjualan/formpenjualanbebas/' . $request['pasien_id'] . '/' . $request['idreg'] . '/' . $request['penjualan_id']);
	}

	public function deleteDetailBebas($id, $idpasien, $idreg, $penjualan_id)
	{
		Penjualandetail::find($id)->delete();
		return redirect('penjualan/formpenjualanbebas/' . $idpasien . '/' . $idreg . '/' . $penjualan_id);
	}

	public function save_totalpenjualan_bebas(Request $request)
	{
		// return $request; $die;
		$jasa_racik   = rupiah($request['jasa_racik']);
		$penjualan_id = $request['id_penjualan'];
		DB::transaction(function () use ($penjualan_id, $jasa_racik) {
			$total = 0;
			$det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
				if (Auth::user()->gudang_id == 2) {
					$saldo_obat = Masterobat::find($d->masterobat_id);
					$saldo_obat->saldo = ($saldo_obat->saldo - $d->jumlah);
					$saldo_obat->update();
				}
			}
			$total;

			$pj = Penjualan::find($penjualan_id);
			$reg = Registrasi::find(Penjualan::find($penjualan_id)->registrasi_id);

			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->total = $total;
			$fol->gudang_id = @Auth::user()->gudang_id;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = $jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
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
		});
		return redirect('farmasi/cetak-detail-bebas/' . $penjualan_id);
	}

	//UPDATE PENJUALAN OBAT
	public function detailPenjualan($penjualan_id)
	{
		$p			= Penjualan::find($penjualan_id);
		$data		= Penjualandetail::where('penjualan_id', $penjualan_id)->get();
		$reg		= Registrasi::find($p->registrasi_id);
		$carabayar	= Carabayar::pluck('carabayar', 'id');
		$folio		= Folio::where('namatarif', $data[0]['no_resep'])->first();
		return view('penjualan.detailPenjualan', compact('data', 'reg', 'folio', 'carabayar', 'p'))->with('no', 1);
	}

	// HAPUS FAKTUR LAMA (TANPA BATCH)
	public function hapusFaktur($fr = '')
	{
		Penjualandetail::where('no_resep', $fr)->delete();
		Penjualan::where('no_resep', $fr)->delete();
		Folio::where('namatarif', $fr)->delete();
		return redirect()->back();
	}

	public function updateFaktur(Request $req)
	{
		$fol = Folio::where('namatarif', $req->namatarif)->first();

		if ($req->cara_bayar_id != $fol->cara_bayar_id) {
			$total = 0;
			$detail = Penjualandetail::where('no_resep', $req->namatarif)->get();
			foreach ($detail as $d) {
				$penj = Penjualandetail::find($d->id);
				$masterObat = \App\LogistikBatch::where('masterobat_id', $penj->masterobat_id)->first();
				if ($req->cara_bayar_id == 2) {
					$harga = $penj->jumlah * $masterObat->hargajual_umum;
				} elseif ($req->cara_bayar_id == 5) {
					$harga = $penj->jumlah * $masterObat->hargajual_dinas;
				} else {
					$harga = $penj->jumlah * $masterObat->hargajual_jkn;
				}
				$penj->hargajual = $harga;
				$penj->update();
				$total += $harga;
			}
			$fol->total = $total;
			$fol->cara_bayar_id = $req->cara_bayar_id;
		}

		$fol->lunas = $req->bayar;
		$fol->cara_bayar_id = $req->cara_bayar_id;
		$fol->created_at = date('Y-m-d H:i:s', strtotime($req->created_at));
		$fol->update();

		$penj = Penjualan::where('no_resep', $req->namatarif)->first();
		$penj->created_at = date('Y-m-d H:i:s', strtotime($req->created_at));
		$penj->update();

		return response()->json(['sukses' => true, 'penjualan_id' => $penj->id]);
		// Flashy::success('Data Penjualan Berhasil Diupdate !');
		// return redirect('penjualan/irna');
	}

	public function hapusObat($id)
	{

		$detail = Penjualandetail::find($id);
		$penjualan = Penjualan::find($detail->penjualan_id);
		$folio = Folio::where('registrasi_id', $penjualan->registrasi_id)->where('namatarif', $detail->no_resep)->where('tarif_id', 10000)->first();
		if ($folio) {
			$folio->total = $folio->total - $detail->hargajual;
			$folio->update();
		}

		if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $detail->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
			$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $detail->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
		} else {
			$total_stok = \App\LogistikBatch::where('masterobat_id', $detail->masterobat_id)->sum('stok');
		}

		$cek_obat = \App\LogistikBatch::where('id', $detail->logistik_batch_id)->first();
		$cek_obat->stok = $cek_obat->stok + ($detail->jumlah + $detail->jml_kronis);
		$cek_obat->update();

		$stock = new \App\Logistik\LogistikStock();
		$stock->gudang_id = 2;
		$stock->user_id = Auth::user()->id;
		$stock->supplier_id = null;
		$stock->masterobat_id = $detail->masterobat_id;
		$stock->logistik_batch_id = $detail->logistik_batch_id;
		$stock->batch_no = $cek_obat->nomorbatch;
		$stock->expired_date = date("Y-m-d", strtotime($cek_obat->expireddate));
		// $stock->expired_date = !empty($saldo_obat->expireddate) ? $saldo_obat->expireddate : '';
		$stock->periode_id = date('m');
		$stock->keluar = 0;
		$stock->masuk = ($detail->jumlah + $detail->jml_kronis);
		$stock->total = $total_stok + ($detail->jumlah + $detail->jml_kronis);
		$stock->keterangan = 'Hapus Penjulan' . ' ' . $detail->no_resep;
		$stock->save();

		Activity::log('penjualan_edit_' . Auth::user()->name . ' menghapus obat ' . Masterobat::find($detail->masterobat_id)->nama . ' senilai ' . number_format($detail->hargajual) . ' no struk ' . $detail->no_resep);
		$detail->delete();
		return response()->json(['sukses' => true, 'penjualan_id' => $penjualan->id]);
	}
	public function hapusObatNew($id)
	{
		DB::beginTransaction();
		try {
			$detail = Penjualandetail::find($id);
			// dd($detail)
			$penjualan = Penjualan::find($detail->penjualan_id);
			$folio = Folio::where('registrasi_id', $penjualan->registrasi_id)->where('namatarif', $detail->no_resep)->where('tarif_id', 10000)->first();
			if ($folio) {
				$folio->total = $folio->total - $detail->hargajual;
				$folio->update();
			}

			if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $detail->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
				$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $detail->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
			} else {
				$total_stok = \App\LogistikBatch::where('masterobat_id', $detail->masterobat_id)->sum('stok');
			}
			// dd($total_stok);

			$cek_obat = \App\LogistikBatch::where('id', $detail->logistik_batch_id)->withTrashed()->first();
			// dd($cek_obat);
			$cek_obat->stok = $cek_obat->stok + ($detail->jumlah + $detail->jml_kronis);
			$cek_obat->update();


			$stock = new \App\Logistik\LogistikStock();
			$stock->gudang_id = 2;
			$stock->user_id = Auth::user()->id;
			$stock->supplier_id = null;
			$stock->masterobat_id = $detail->masterobat_id;
			$stock->logistik_batch_id = $detail->logistik_batch_id;
			$stock->batch_no = $cek_obat->nomorbatch;
			$stock->expired_date = date("Y-m-d", strtotime($cek_obat->expireddate));
			// $stock->expired_date = !empty($saldo_obat->expireddate) ? $saldo_obat->expireddate : '';
			$stock->periode_id = date('m');
			$stock->keluar = 0;
			$stock->masuk = ($detail->jumlah + $detail->jml_kronis);
			$stock->total = $total_stok + ($detail->jumlah + $detail->jml_kronis);
			$stock->keterangan = 'Hapus Penjulan' . ' ' . $detail->no_resep;
			$stock->save();

			Activity::log('penjualan_edit_' . Auth::user()->name . ' menghapus obat ' . Masterobat::find($detail->masterobat_id)->nama . ' senilai ' . number_format($detail->hargajual) . ' no struk ' . $detail->no_resep);
			$detail->delete();
			DB::commit();
			return response()->json(['sukses' => true, 'penjualan_id' => $penjualan->id]);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['sukses' => false, 'message' => 'Terjadi Kesalahan ' . $e->getMessage()]);
		}
	}


	public function updateSavePenjualan(Request $request)
	{
		// return $request->all(); die;
		// dd($request->all());

		$cek = Validator::make($request->all(), [
			'pembuat_resep' => ['required'],
		], [
			'pembuat_resep.required' => 'Pembuat Resep Wajib Diisi !',
		]);

		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {

			DB::beginTransaction();
			try {

				if (Cart::subtotal() > 0) {
					$save = DB::transaction(function () use ($request) {
						$totals = number_format(str_replace(',', '', Cart::subtotal()));
						$total_formated = str_replace(',', '', $totals);

						$jenis = Registrasi::find($request['idreg'])->status_reg;
						// $reg = Registrasi::find($request['idreg']);
						if (substr($jenis, 0, 1) == 'J') {
							$count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
							$next_resep = 'FRJ' . date('YmdHis');
						} elseif (substr($jenis, 0, 1) == 'I') {
							$count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
							$next_resep = 'FRI' . date('YmdHis');
						} elseif (substr($jenis, 0, 1) == 'G') {
							$count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
							$next_resep = 'FRD' . date('YmdHis');
						}

						//Save Penjualan
						$p = Penjualan::where('id', $request->penjualan_id)->first();
						// dd($p);
						if (!$p) {
							$p = new Penjualan();
							$p->no_resep = $next_resep;
							$p->pembuat_resep = $request['pembuat_resep'];
							$p->user_id = Auth::user()->id;
							$p->registrasi_id = $request['idreg'];
							$p->created_at = valid_date($request['created_at']);
							$p->save();
						}

						session(['penjualanid' => $p->id]);
						// dd(Cart::content());
						//Save Penjualan Detail
						// CEK APAKAH ADA FOLIO ATAU TIDAK
						$folio_cek = Folio::where('registrasi_id', $request['idreg'])->where('namatarif', $p->no_resep)->where('tarif_id', 10000)->first();

						if (!$folio_cek) {
							$cek_penj_det = Penjualandetail::where('penjualan_id', $p->id)->sum('hargajual');
							if ($cek_penj_det > '0') {
								$subtotal = $total_formated;
								$total_formated = $subtotal + $cek_penj_det;
							}

							$reg = Registrasi::find($request['idreg']);
							$fols = new Folio();
							$fols->registrasi_id = $request['idreg'];
							$fols->namatarif = $p->no_resep;
							$fols->total = @$total_formated;
							$fols->tarif_id = 10000;
							$fols->lunas = 'N';
							$fols->gudang_id = @Auth::user()->gudang_id;
							$fols->jenis = 'ORJ';
							$fols->cara_bayar_id = $reg->bayar;
							$fols->poli_tipe = 'A';
							$fols->pasien_id = $reg->pasien_id;
							$fols->dokter_id = $reg->dokter_id;
							$fols->poli_id = $reg->poli_id;
							$fols->user_id = Auth::user()->id;
							$fols->created_at = $p->created_at;
							$fols->save();
						} else {
							$folio = Folio::where('registrasi_id', $request['idreg'])->where('namatarif', $p->no_resep)->where('tarif_id', 10000)->first();
							// dd($p);
							// dd($folio);
							$folio->total = @$folio->total + str_replace(',', '', $totals);

							$folio->update();
						}

						foreach (Cart::content() as $d) {
							// dd($d->options->masterobat_id);
							$cek = Penjualandetail::where('masterobat_id', $d->options->masterobat_id)->where('penjualan_id', $request['penjualan_id'])->where('is_kronis', $d->options->is_kronis)->count();
							$obat = LogistikBatch::where('id', $d->id)->first();
							// dd($p->no_resep);
							// dd(Folio::where('registrasi_id', $request['idreg'])->where('tarif_id', 10000)->where('namatarif',$p->no_resep)->first());
							if ($cek > 0) {
								$pj = Penjualandetail::where('masterobat_id', $d->options->masterobat_id)->where('penjualan_id', $request['penjualan_id'])->where('is_kronis', $d->options->is_kronis)->first();
								$pj->jumlah = $pj->jumlah + $d->qty;
								if (cek_jenispasien($request['idreg']) == '1') {
									$harga = LogistikBatch::select('hargajual_jkn')->where('id', $d->id)->first()->hargajual_jkn;
								} else {
									$harga = LogistikBatch::select('hargajual_umum')->where('id', $d->id)->first()->hargajual_umum;
								}
								// if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
								// 	$harga = rupiah($request['racikan']);
								// }
								$pj->hargajual = $pj->hargajual + ($harga * $d->qty);
								$pj->informasi1 = @$d->options->informasi1;
								// $pj->informasi2 = $request['informasi2'];
								$pj->expired = $request['expired'];
								$pj->update();

								Activity::log('penjualan_edit_' . Auth::user()->name . ' menambahkan obat ' . Masterobat::find($d->options->masterobat_id)->nama . ' senilai ' . number_format($harga * $d->qty) . ' no struk ' . $pj->no_resep);
								$folio = Folio::where('registrasi_id', $request['idreg'])->where('namatarif', $pj->no_resep)->where('tarif_id', 10000)->first();
								$folio->total = $folio->total + ($harga * $d->qty);
								$folio->update();
							} else {
								$obat = LogistikBatch::where('id', $d->id)->first();
								$penj = new Penjualandetail();
								$penj->penjualan_id = $request['penjualan_id'];
								$penj->cara_minum_id = @$d->options->cara_minum_id;
								$penj->no_resep = $p->no_resep;
								$penj->masterobat_id = $d->options->masterobat_id;
								$penj->logistik_batch_id = $d->id;
								$penj->jumlah = $d->qty;
								$penj->jml_kronis = $d->options->jml_kronis;
								$penj->is_kronis = $d->options->is_kronis;
								if (cek_jenispasien($request['idreg']) == '1') {
									$harga = LogistikBatch::select('hargajual_jkn')->where('id', $d->id)->first()->hargajual_jkn;
								} else {
									$harga = LogistikBatch::select('hargajual_umum')->where('id', $d->id)->first()->hargajual_umum;
								}
								if (substr($jenis, 0, 1) == 'J') {
									@$penj->tipe_rawat = 'TA';
								} elseif (substr($jenis, 0, 1) == 'G') {
									@$penj->tipe_rawat = 'TG';
								} elseif (substr($jenis, 0, 1) == 'I') {
									@$penj->tipe_rawat = 'TI';
								}

								$penj->uang_racik = $d->options->uang_racik ? rupiah($d->options->uang_racik) : 0;
								$penj->hargajual = $harga * $d->qty;
								$penj->hargajual_kronis  = $harga * $d->options->jml_kronis;
								$penj->informasi1 = @$d->options->informasi1;
								$penj->informasi2 = @$d->options->informasi2;
								$penj->expired = $d->options->expired;
								$penj->etiket = $d->options->tiket . ' ' . $d->options->takaran;
								$penj->cetak = $d->options->cetak;
								$penj->created_at = $d->options->created;
								$penj->save();

								Activity::log('penjualan_edit_' . Auth::user()->name . ' menambahkan obat ' . LogistikBatch::find($d->id)->nama . ' senilai ' . number_format($penj->hargajual) . ' no struk ' . $p->no_resep);
							}

							if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
								$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
							} else {
								$total_stok = \App\LogistikBatch::where('masterobat_id', $obat->masterobat_id)->sum('stok');
							}

							$saldo_obat = LogistikBatch::find($obat->id);
							$saldo_obat->stok = $saldo_obat->stok - ($d->qty + $d->options->jml_kronis);
							$saldo_obat->update();

							$stock = new \App\Logistik\LogistikStock();
							$stock->gudang_id = Auth::user()->gudang_id;
							$stock->supplier_id = null;
							$stock->masterobat_id = $obat->masterobat_id;
							$stock->logistik_batch_id = $obat->id;
							$stock->batch_no = $obat->nomorbatch;
							// $stock->expired_date = valid_date($obat->expireddate);
							$stock->expired_date = date("Y-m-d", strtotime($obat->expireddate));
							$stock->masuk = 0;
							$stock->periode_id = date('m');
							$stock->keluar = $d->qty + $d->options->jml_kronis;
							$stock->total = $total_stok - ($d->qty + $d->options->jml_kronis);
							$stock->keterangan = 'Penjualan ' . $request['no_resep'];
							$stock->save();
						}
						// dd("A");
					});
					DB::commit();
					Cart::destroy();
					$jenis = substr($request['tipe_rawat'], 0, 1);
					return response()->json(['sukses' => true, 'id' => session('penjualanid'), 'jenis' => $jenis]);
				}
			} catch (Exception $e) {
				DB::rollback();
				return response()->json(['sukses' => 201, 'id' => session('penjualanid'), 'jenis' => $jenis]);
			}
			// dd(Cart::content());

		}
	}






	public function tambahPenjualan($penjualan_id)
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['barang'] = LogistikBatch::select('id', 'nama_obat', 'hargajual_umum', 'hargajual_jkn')->get();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['tipe_uang_racik'] = UangRacik::all();
		return view('penjualan.tambahPenjualan', $data);
	}

	public function saveTambahPenjualan(Request $request)
	{
		if (!empty($request['masterobat_id'])) {
			$cek = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->count();
			$obat = LogistikBatch::where('id', $request['masterobat_id'])->first();
			if ($cek > 0) {
				$pj = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->first();
				$pj->jumlah = $pj->jumlah + $request['jumlah'];
				if (cek_jenispasien($request['idreg']) == '1') {
					$harga = LogistikBatch::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
				} else {
					$harga = LogistikBatch::select('hargajual_umum')->where('id', $request['masterobat_id'])->first()->hargajual_umum;
				}
				if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
					$harga = rupiah($request['racikan']);
				}
				$pj->hargajual = $pj->hargajual + ($harga * $request['jumlah']);
				$pj->informasi1 = $request['informasi1'];
				$pj->informasi2 = $request['informasi2'];
				$pj->expired = $request['expired'];
				$pj->update();

				Activity::log('penjualan_edit_' . Auth::user()->name . ' menambahkan obat ' . Masterobat::find($request['masterobat_id'])->nama . ' senilai ' . number_format($harga * $request['jumlah']) . ' no struk ' . $pj->no_resep);
				$folio = Folio::where('registrasi_id', $request['registrasi_id'])->where('namatarif', $pj->no_resep)->where('tarif_id', 10000)->first();
				$folio->total = $folio->total + ($harga * $request['jumlah']);
				$folio->update();
			} else {
				$obat = LogistikBatch::where('id', $request['masterobat_id'])->first();
				$d = new Penjualandetail();
				$d->penjualan_id = $request['penjualan_id'];
				$d->no_resep = $request['no_resep'];
				$d->masterobat_id = $obat->masterobat_id;
				$d->logistik_batch_id = $request['masterobat_id'];
				$d->jumlah = $request['jumlah'];
				$d->jml_kronis = $request['jml_kronis'];
				if (cek_jenispasien($request['registrasi_id']) == '1') {
					$harga = LogistikBatch::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
				} else {
					$harga = LogistikBatch::select('hargajual_umum')->where('id', $request['masterobat_id'])->first()->hargajual_umum;
				}
				if (substr($request['tipe_rawat'], 0, 1) == 'J') {
					$d->tipe_rawat = 'TA';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
					$d->tipe_rawat = 'TG';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
					$d->tipe_rawat = 'TI';
				}

				$d->uang_racik = rupiah($request['uang_racik']);
				$d->hargajual = $harga * $request['jumlah'];
				$d->hargajual_kronis  = $harga * $request['jml_kronis'];
				$d->informasi1 = $request['informasi1'];
				$d->informasi2 = $request['informasi2'];
				$d->expired = $request['expired'];
				$d->etiket = $request['tiket'] . ' ' . $request['takaran'];
				$d->cetak = $request['cetak'];
				$d->save();

				Activity::log('penjualan_edit_' . Auth::user()->name . ' menambahkan obat ' . LogistikBatch::find($request['masterobat_id'])->nama . ' senilai ' . number_format($d->hargajual) . ' no struk ' . $d->no_resep);

				$folio = Folio::where('registrasi_id', $request['registrasi_id'])->where('namatarif', $d->no_resep)->where('tarif_id', 10000)->first();
				$folio->total = $folio->total + $d->hargajual;
				$folio->update();
			}

			if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
				$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
			} else {
				$total_stok = \App\LogistikBatch::where('masterobat_id', $obat->masterobat_id)->sum('stok');
			}

			$saldo_obat = LogistikBatch::find($obat->id);
			$saldo_obat->stok = $saldo_obat->stok - ($request['jumlah'] + $request['jml_kronis']);
			$saldo_obat->update();

			$stock = new \App\Logistik\LogistikStock();
			$stock->gudang_id = Auth::user()->gudang_id;
			$stock->supplier_id = null;
			$stock->masterobat_id = $obat->masterobat_id;
			$stock->logistik_batch_id = $obat->id;
			$stock->batch_no = $obat->nomorbatch;
			// $stock->expired_date = valid_date($obat->expireddate);
			$stock->expired_date = date("Y-m-d", strtotime($obat->expireddate));
			$stock->masuk = 0;
			$stock->periode_id = date('m');
			$stock->keluar = $request['jumlah'] + $request['jml_kronis'];
			$stock->total = $total_stok - ($request['jumlah'] + $request['jml_kronis']);
			$stock->keterangan = 'Penjualan ' . $request['no_resep'];
			$stock->save();
			return response()->json(['sukses' => true, 'penjualan_id' => $request['penjualan_id']]);
		} else {
			return response()->json(['sukses' => false, 'penjualan_id' => $request['penjualan_id']]);
		}
	}

	public function laporan()
	{
		return view('penjualan.laporan.index');
	}

	public function laporanPenjualan(Request $request)
	{
		ini_set('max_execution_time', 0);
		ini_set("memory_limit", "10000M");
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = $request['tga'];
		$tgb = $request['tgb'];

		$penjualan = Folio
			::where('jenis', 'ORJ')
			->join('pasiens', 'pasiens.id', '=', 'folios.pasien_id')
			->join('carabayars', 'carabayars.id', '=', 'folios.cara_bayar_id')
			->join('users', 'users.id', '=', 'folios.user_id')
			->whereBetween('folios.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->select('folios.*', 'pasiens.nama as nama_pasien', 'pasiens.no_rm', 'carabayars.carabayar', 'users.name as username')
			->get();

		$ranap_non_fornas = null;
		$rajal_non_fornas = null;
		$radar = null;
		$bebas = null;
		$operasi = null;
		$tampilKalkulasi = false;
		$hasilJalan = null;
		$hasilIGD = null;
		$hasilIRNA = null;
		$hasilBebas = null;
		$hasilOperasi = null;
		if ($request->submit == 'KALKULASI' || $request->submit == 'CETAK') {
			$tampilKalkulasi = true;

			$penjualanJalan = Penjualandetail
				::leftJoin('logistik_batches', 'penjualandetails.logistik_batch_id', '=', 'logistik_batches.id')
				->where('logistik_batches.gudang_id', '<>', 2)
				->where('penjualandetails.no_resep', 'like', 'FRJ' . '%')
				->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->get();
			$hasilJalan = [
				'jumlah_penjualan'  => $penjualanJalan->count(),
				'total_harga_jual'  => $penjualanJalan->sum('hargajual') + $penjualanJalan->sum('hargajual_kronis'),
				'total_harga_jual_pokok' => $penjualanJalan->sum(function ($item) {
					return ($item['jumlah'] + $item['jml_kronis']) * $item['hargabeli'];
				})
			];

			$penjualanIGD = Penjualandetail
				::leftJoin('logistik_batches', 'penjualandetails.logistik_batch_id', '=', 'logistik_batches.id')
				->where('logistik_batches.gudang_id', '<>', 2)
				->where('penjualandetails.no_resep', 'like', 'FRD' . '%')
				->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->get();
			$hasilIGD = [
				'jumlah_penjualan'  => $penjualanIGD->count(),
				'total_harga_jual'  => $penjualanIGD->sum('hargajual') + $penjualanIGD->sum('hargajual_kronis'),
				'total_harga_jual_pokok' => $penjualanIGD->sum(function ($item) {
					return ($item['jumlah'] + $item['jml_kronis']) * $item['hargabeli'];
				})
			];

			$penjualanIRNA = Penjualandetail
				::leftJoin('logistik_batches', 'penjualandetails.logistik_batch_id', '=', 'logistik_batches.id')
				->where('logistik_batches.gudang_id', '<>', 2)
				->where('penjualandetails.no_resep', 'like', 'FRI' . '%')
				->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->get();
			$hasilIRNA = [
				'jumlah_penjualan'  => $penjualanIRNA->count(),
				'total_harga_jual'  => $penjualanIRNA->sum('hargajual') + $penjualanIRNA->sum('hargajual_kronis'),
				'total_harga_jual_pokok' => $penjualanIRNA->sum(function ($item) {
					return ($item['jumlah'] + $item['jml_kronis']) * $item['hargabeli'];
				})
			];

			$penjualanBebas = Penjualandetail
				::leftJoin('logistik_batches', 'penjualandetails.logistik_batch_id', '=', 'logistik_batches.id')
				->where('logistik_batches.gudang_id', '<>', 2)
				->where('penjualandetails.no_resep', 'like', 'FPB' . '%')
				->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->get();
			$hasilBebas = [
				'jumlah_penjualan'  => $penjualanBebas->count(),
				'total_harga_jual'  => $penjualanBebas->sum('hargajual') + $penjualanBebas->sum('hargajual_kronis'),
				'total_harga_jual_pokok' => $penjualanBebas->sum(function ($item) {
					return ($item['jumlah'] + $item['jml_kronis']) * $item['hargabeli'];
				})
			];

			$penjualanOperasi = Penjualandetail
				::leftJoin('logistik_batches', 'penjualandetails.logistik_batch_id', '=', 'logistik_batches.id')
				->where('logistik_batches.gudang_id', 2)
				->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->get();
			$hasilOperasi = [
				'jumlah_penjualan'  => $penjualanOperasi->count(),
				'total_harga_jual'  => $penjualanOperasi->sum('hargajual') + $penjualanOperasi->sum('hargajual_kronis'),
				'total_harga_jual_pokok' => $penjualanOperasi->sum(function ($item) {
					return ($item['jumlah'] + $item['jml_kronis']) * $item['hargabeli'];
				})
			];
		}


		if ($request->submit == 'CETAK') {
			$no = 1;
			$pdf = PDF::loadView('penjualan.laporan.laporanPenjualanPDF', compact('penjualan',  'tga', 'tgb', 'radar', 'tampilKalkulasi', 'hasilJalan', 'hasilIRNA', 'hasilIGD', 'hasilOperasi', 'hasilBebas', 'no'));
			return $pdf->stream();
		} else if ($request->submit == 'EXCEL') {
			Excel::create('Laporan Penjualan Obat', function ($excel) use ($penjualan) {
				$excel->setTitle('Laporan Penjualan Obat')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Penjualan Obat');
				$excel->sheet('Penjualan User', function ($sheet) use ($penjualan) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'No Faktur',
						'Nama Pasien',
						'NO RM',
						'Total',
						'Jenis Pasien',
						'Tanggal',
						'User',
					]);
					foreach ($penjualan as $dt) {
						$sheet->row(++$row, [
							$no++,
							$dt->namatarif,
							@$dt->pasien_it == 0 ? 'Pasien Langsung' : @$dt->nama_pasien,
							$dt->pasien_id == 0 ? 'Pasien Langsung' : @$dt->no_rm,
							$dt->total,
							!empty($dt->cara_bayar_id) ? $dt->carabayar : 'Penjualan Langsung',
							$dt->created_at->format('d-m-Y'),
							$dt->username,
						]);
					}
				});
			})->export('xlsx');
		}
		// dd($total_umum_pokok, $total_jkn_pokok);
		return view('penjualan.laporan.index',  compact('penjualan',  'tga', 'tgb', 'radar', 'tampilKalkulasi', 'hasilJalan', 'hasilIRNA', 'hasilIGD', 'hasilOperasi', 'hasilBebas'))->with('no', 1);
	}

	public function laporanPenjualanUser()
	{
		$data['tga']		= now()->format('d-m-Y');
		$data['tgb']		= now()->format('d-m-Y');
		$data['users']      = Penjualan::leftjoin('users', 'users.id', '=', 'penjualans.user_id')->groupBy('users.id')->select('users.id as id', 'users.name as nama')->get();
		return view('penjualan.laporan.laporan_penjualan_user', $data)->with('no', 1);
	}

	public function laporanPenjualanUserByRequest(Request $req)
	{
		if ($req->tga != null & $req->tgb != null) {
			$tga	= valid_date($req->tga) . ' 00:00:00';
			$tgb	= valid_date($req->tgb) . ' 23:59:59';
		} else {
			$tga    = now()->startOfDay()->format('Y-m-d H:i:s');
			$tgb    = now()->endOfDay()->format('Y-m-d H:i:s');
		}

		$data = Penjualan::leftjoin('users', 'users.id', '=', 'penjualans.user_id')
			->leftJoin('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
			->leftJoin('masterobats', 'masterobats.id', '=', 'penjualandetails.masterobat_id')
			->whereBetween('penjualans.created_at', [$tga, $tgb])
			->select('penjualans.id', 'masterobats.nama as nama_obat', 'users.name as nama_user', 'penjualandetails.hargajual', 'penjualandetails.jumlah');
		if ($req->user_id != null || $req->user_id != '') {
			$data->where('users.id', $req->user_id);
		}

		if ($req->submit == 'EXCEL') {
			Excel::create('Laporan Penjualan', function ($excel) use ($data) {
				$excel->setTitle('Laporan Penjualan User')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Penjualan User');
				$excel->sheet('Penjualan User', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama User',
						'Nama Obat',
						'Jumlah',
						'Total Harga (Rp.)',
					]);
					foreach ($data->get() as $dt) {
						$sheet->row(++$row, [
							$no++,
							$dt->nama_user,
							$dt->nama_obat,
							$dt->jumlah,
							$dt->hargajual
						]);
					}
				});
			})->export('xlsx');
		}


		$no = 1;
		return DataTables::of($data)
			->addColumn('no', function () use (&$no) {
				return $no++;
			})
			->addColumn('nama_user', function ($data) {
				return $data->nama_user;
			})
			->addColumn('nama_obat', function ($data) {
				return $data->nama_obat;
			})
			->addColumn('jumlah', function ($data) {
				return $data->jumlah;
			})
			->addColumn('hargajual', function ($data) {
				return number_format($data->hargajual);
			})
			->make(true);
	}







	public function laporanPenjualanDetail($no_faktur)
	{
		$detail = Penjualandetail::where('no_resep', $no_faktur)->get();
		$total = Penjualandetail::where('no_resep', $no_faktur)->sum('hargajual');
		return view('penjualan.laporan.detailPenjualan', compact('detail', 'total'))->with('no', 1);
	}

	//RETUR
	public function returRajal()
	{
		return view('penjualan.retur.rajal');
	}

	public function returRajalByRequest(Request $request)
	{
		request()->validate(['tga' => 'required']);
		session(['tanggal' => valid_date($request['tga'])]);
		return view('penjualan.retur.rajal');
	}


	public function returRajalDetailnya($no_faktur)
	{
		$detail = Penjualandetail::where('no_resep', $no_faktur)->whereDate('created_at', '>=', '2020-05-01')->get();
		$row_id = 1;
		$row_detail = 1;
		$detail_id = 1;
		$retur_kronis = 1;
		return view('penjualan.retur.detailnya', compact('detail', 'row_id', 'row_detail', 'detail_id', 'retur_kronis', 'no_faktur'))->with('no', 1);
	}

	public function dataReturRajalByRequest()
	{
		$tanggal = session('tanggal') ? session('tanggal') : date('Y-m-d');
		$data = Registrasi::where('pasien_id', '<>', '0')->where('created_at', 'LIKE', $tanggal . '%')->whereNotIn('status_reg', ['I2', 'I3'])->get();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('no_rm', function ($data) {
				return $data->pasien->no_rm;
			})
			->addColumn('nama', function ($data) {
				return @$data->pasien->nama;
			})
			->addColumn('alamat', function ($data) {
				return @$data->pasien->alamat;
			})
			->addColumn('poli', function ($data) {
				return @$data->poli->nama;
			})
			->addColumn('poli', function ($data) {
				return @$data->poli->nama;
			})
			->addColumn('tanggal', function ($data) {
				return @$data->created_at->format('d-m-Y');
			})
			->addColumn('edit', function ($data) {
				// return '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="retur(' . $data->id . ')" style="margin-bottom: 5px;">RETUR</button>';
				return '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popitup(\'' . url('retur/rajal/detailnya/' . $data->id) . '\')" style="margin-bottom: 5px;">RETUR</button>';
				// return '<a href="'.url('retur/rajal/detailnya/'.$data->id).'" target="_new" class="btn btn-sm btn-primary btn-flat" style="margin-bottom: 5px;">RETUR</a>';
			})
			->rawColumns(['edit'])
			->make(true);
	}

	public function getDataRetur($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		if ($reg->pasien_id == 0) {
			# code...
			$pasien = Penjualanbebas::where('registrasi_id', $reg->id)->first();
			$pasien->no_rm = 'Penjualan Bebas';
		} else {
			$pasien = Pasien::find($reg->pasien_id);
		}
		$penjualan = Penjualan::where('registrasi_id', $reg->id)->whereDate('created_at', '>=', '2020-05-01')->get();
		return response()->json(['pasien' => $pasien, 'penjualan' => $penjualan, 'registrasi' => $reg]);
	}

	// FAIQ
	public function getPenjualanDetail($no_faktur)
	{
		$data['detail'] = Penjualandetail::where('no_resep', $no_faktur)->whereDate('created_at', '>=', '2020-05-01')->get();
		// $data['total_uang_racik'] = $data['detail']->sum('uang_racik');
		$data['folio']	= Folio::where('namatarif', $no_faktur)->get()->first();
		$data['total'] = $data['detail']->sum('hargajual');
		$data['total_uang_racik'] = $data['detail']->sum('uang_racik');
		$data['total_retur_inacbg'] = $data['detail']->sum(function($item) {
			return $item->retur_inacbg * ($item->masterobat->hargajual ?? 0);
		});
		$data['tipe_uang_racik'] = UangRacik::all();
		$row_id = 1;
		$row_detail = 1;
		$detail_id = 1;
		$retur_kronis = 1;
		return view('penjualan.retur.detail', $data, compact('row_id', 'row_detail', 'detail_id', 'retur_kronis'))->with('no', 1);
	}
	// public function getPenjualanDetail($no_faktur) {
	// 	$detail = Penjualandetail::where('no_resep', $no_faktur)->whereDate('created_at', '>=', '2020-05-01')->get();
	// 	$row_id = 1;
	// 	$row_detail = 1;
	// 	$detail_id = 1;
	// 	$retur_kronis = 1;
	// 	return view('penjualan.retur.detail', compact('detail', 'row_id', 'row_detail','detail_id', 'retur_kronis'))->with('no', 1);
	// }

	public function saveRetur(Request $request)
	{
		DB::beginTransaction();
		try {
			$jumlah = 0;
			for ($i = 1; $i < $request['jml']; $i++) {
				$returInacbg   = (int) $request['retur' . $i];
				$returKronis   = (int) $request['returkronis' . $i];
				$masterObatId  = $request['masterobat_id' . $i];
				$detailId      = $request['detail_id' . $i];

				if ($returInacbg == 0 && $returKronis == 0) {
					continue;
				}

				$batch = LogistikBatch::find($masterObatId);
				if (!$batch) {
					continue;
				}
				$hargaSatuan = $batch->hargajual_umum;

				$jumlah += ($returInacbg + $returKronis) * $hargaSatuan;

				$batch->stok += ($returInacbg + $returKronis);
				$batch->save();

				$detail = Penjualandetail::find($detailId);
				if ($detail) {
					$detail->jumlah     -= $returInacbg;
					$detail->jml_kronis -= $returKronis;

					$detail->retur_inacbg += $returInacbg;
					$detail->retur_kronis += $returKronis;

					$detail->hargajual        = $detail->jumlah * $hargaSatuan;
					$detail->hargajual_kronis = $detail->jml_kronis * $hargaSatuan;

					if ($detail->hargajual == 0) {
						$detail->uang_racik   = 0;
						$detail->uang_racik_id = 2;
					}

					$detail->save();
				}

				$latestStock = \App\Logistik\LogistikStock::where('masterobat_id', $batch->masterobat_id)
					// ->where('gudang_id', Auth::user()->gudang_id)
					->where('gudang_id', 3)
					->latest()
					->first();

				$totalStok = $latestStock ? $latestStock->total : LogistikBatch::where('masterobat_id', $batch->masterobat_id)->sum('stok');

				$stock = new \App\Logistik\LogistikStock();
				$stock->gudang_id        = 3; // apotik sentral
				$stock->user_id          = Auth::user()->id;
				$stock->supplier_id      = null;
				$stock->masterobat_id    = $batch->masterobat_id;
				$stock->logistik_batch_id= $batch->id;
				$stock->batch_no         = $batch->nomorbatch;
				$stock->expired_date     = date("Y-m-d", strtotime($batch->expireddate));
				$stock->periode_id       = date('m');
				$stock->keluar           = 0;
				$stock->masuk            = $returInacbg + $returKronis;
				$stock->total            = $totalStok + ($returInacbg + $returKronis);
				$stock->keterangan       = 'Retur Penjualan ' . $request['no_faktur'];
				$stock->save();
			}

			if ($jumlah == 0) {
				$updateFolio = Folio::where('namatarif', $request->no_faktur)->first();
				if ($updateFolio) {
					$updateFolio->jasa_racik = 0;
					$updateFolio->save();
				}
				DB::commit();
				return response()->json(['sukses' => false, 'message' => 'Tidak ada obat yang diretur']);
			}

			$folio = new Folio();
			$folio->registrasi_id = $request['registrasi_id'];
			$folio->namatarif     = 'Retur penjualan';
			$folio->cara_bayar_id = $request['cara_bayar_id'] ?? 0;
			$folio->total         = -$jumlah;
			$folio->tarif_id      = 9999;
			$folio->jenis         = 'ORJ';
			$folio->gudang_id     = Auth::user()->gudang_id;
			$folio->lunas         = 'N';
			$folio->no_kuitansi   = 'RPRJ' . date('Ymd');
			$folio->pasien_id     = $request['pasien_id'];
			$folio->dokter_id     = $request['dokter_id'];
			$folio->user_id       = Auth::user()->id;
			$folio->poli_id       = $request['poli_id'];
			$folio->save();

			DB::commit();
			return response()->json(['sukses' => true, 'message' => 'Obat diretur senilai Rp. ' . number_format($jumlah)]);

		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['sukses' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
		}
	}

	//RETUR RANAP
	public function returRanap()
	{
		return view('penjualan.retur.ranap');
	}

	public function returRanapByRequest(Request $request)
	{
		request()->validate(['tga' => 'required']);
		request()->validate(['tgb' => 'required']);

		session(['tga' => valid_date($request['tga'])], ['tgb' => valid_date($request['tgb'])]);
		return view('penjualan.retur.ranap');
	}

	public function dataReturRanapByRequest()
	{
		$tga = session('tga') ? session('tga') : date('Y-m-d');
		$tgb = session('tgb') ? session('tgb') : date('Y-m-d');

		$data = Registrasi::where('pasien_id', '<>', '0')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->whereIn('status_reg', ['I2', 'I3'])->get();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('no_rm', function ($data) {
				return $data->pasien->no_rm;
			})
			->addColumn('nama', function ($data) {
				return @$data->pasien->nama;
			})
			->addColumn('alamat', function ($data) {
				return $data->pasien->alamat;
			})
			->addColumn('poli', function ($data) {
				return @$data->poli->nama;
			})
			->addColumn('poli', function ($data) {
				return @$data->poli->nama;
			})
			->addColumn('tanggal', function ($data) {
				return $data->created_at->format('d-m-Y');
			})
			->addColumn('edit', function ($data) {
				return '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popitup(\'' . url('retur/rajal/detailnya/' . $data->id) . '\')" style="margin-bottom: 5px;">RETUR</button>';
				// return '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="retur(' . $data->id . ')" style="margin-bottom: 5px;">RETUR</button>';
			})
			->rawColumns(['edit'])
			->make(true);
	}

	// JANUARI 2019 ========================================================================================
	public static function insertTagihanPenjualan($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$penjualan = Penjualan::where("registrasi_id", $registrasi_id)->first();
		$detail = Penjualandetail::where('penjualan_id', $penjualan->id)->get();
		$cek_tagihan = Folio::where('namatarif', $penjualan->no_resep)->first();

		if (!$cek_tagihan) {
			$fol = new Folio();
			$fol->registrasi_id = $registrasi_id;
			$fol->namatarif = $penjualan->no_resep;
			$fol->total = $detail->sum('hargajual');
			$fol->tarif_id = 10000;
			$fol->lunas = 'N';
			$fol->gudang_id = @Auth::user()->gudang_id;
			$fol->jenis = 'ORJ';
			$fol->cara_bayar_id = $reg->bayar;
			$fol->poli_tipe = 'A';
			$fol->pasien_id = $reg->pasien_id;
			$fol->dokter_id = $reg->dokter_id;
			$fol->poli_id = $reg->poli_id;
			$fol->user_id = Auth::user()->id;
			$fol->created_at = $penjualan->created_at;
			$fol->save();

			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = $reg->pasien->id;
			$tag->harus_dibayar = 0;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->created_at = $penjualan->created_at;
			$tag->save();
			return response()->json(['sukses' => true, 'notif' => 'Tagihan RM ' . $reg->pasien->no_rm . ' berhasil di input.']);
		} else {
			$cek_tagihan->total = $detail->sum('hargajual');
			$cek_tagihan->update();
			return response()->json(['sukses' => true, 'notif' => 'Tagihan RM  ' . $reg->pasien->no_rm . '  berhasil di perbarui.']);
		}
	}

	//updaate 20/mei/2019
	public function newSavePenjualan(Request $request)
	{
		if (Cart::subtotal() > 0) {
			$save = DB::transaction(function () use ($request) {
				$jenis = Registrasi::find($request['idreg'])->status_reg;
				$reg = Registrasi::find($request['idreg']);
				if (substr($jenis, 0, 1) == 'J') {
					$count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
					$next_resep = 'FRJ' . date('YmdHis');
				} elseif (substr($jenis, 0, 1) == 'I') {
					$count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
					$next_resep = 'FRI' . date('YmdHis');
				} elseif (substr($jenis, 0, 1) == 'G') {
					$count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
					$next_resep = 'FRD' . date('YmdHis');
				}

				//Save Penjualan
				$p = new Penjualan();
				$p->no_resep = $next_resep;
				$p->pembuat_resep = $request['pembuat_resep'];
				$p->user_id = Auth::user()->id;
				$p->registrasi_id = $request['idreg'];
				$p->created_at = valid_date($request['created_at']);
				$p->save();
				session(['penjualanid' => $p->id]);

				//Save Penjualan Detail
				foreach (Cart::content() as $d) {
					$pd = new Penjualandetail();
					$pd->penjualan_id = $p->id;
					$pd->no_resep = $p->no_resep;
					$pd->masterobat_id = $d->id;
					$pd->jumlah = $d->qty;
					$pd->jml_kronis = $d->options->jml_kronis;

					if (substr($request['tipe_rawat'], 0, 1) == 'J') {
						$pd->tipe_rawat = 'TA';
					} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
						$pd->tipe_rawat = 'TG';
					} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
						$pd->tipe_rawat = 'TI';
					}

					$pd->uang_racik = $d->options->uang_racik;
					$pd->hargajual = $d->price * $d->qty;
					$pd->hargajual_kronis = $d->price * $d->options->jml_kronis;

					$pd->informasi1 = NULL;
					$pd->informasi2 = NULL;
					$pd->expired = $d->options->expired;
					$pd->etiket = $d->options->etiket . ' ' . $d->options->takaran;
					$pd->cetak = $d->options->cetak;
					$pd->save();

					//Kurangi Saldo
					if (Auth::user()->gudang_id == 2) {
						$saldo_obat = Masterobat::find($d->id);
						$saldo_obat->saldo = ($saldo_obat->saldo - $d->qty);
						$saldo_obat->update();
					}

					// GET STOK TERBARU
					if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $d->id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
						$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $d->id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
					} else {
						$total_stok = 0;
					}

					$bulan_ini = date('Y-m');
					$periode = \App\Logistik\LogistikPeriode::where('periodeAwal', 'like', $bulan_ini . '%')->first();

					$stock = new \App\Logistik\LogistikStock();
					$stock->gudang_id = Auth::user()->gudang_id;
					$stock->supplier_id = null;
					$stock->masterobat_id = $d->id;
					$stock->batch_no = null;
					$stock->expired_date = null;
					$stock->masuk = 0;
					$stock->periode_id = date('m');
					$stock->keluar = $d->qty;
					$stock->total = $total_stok - $d->qty;
					$stock->keterangan = 'Penjualan ' . $next_resep;
					$stock->save();
				}

				//Save Folio
				$fol = new Folio();
				$fol->registrasi_id = $reg->id;
				$fol->namatarif = $next_resep;
				$fol->total = rupiah(Cart::subtotal(0, ',' . ','));
				$fol->tarif_id = 10000;
				$fol->lunas = 'N';
				$fol->gudang_id = @Auth::user()->gudang_id;
				$fol->jenis = 'ORJ';
				// $fol->cara_bayar_id = $reg->bayar;
				$fol->cara_bayar_id = $request->cara_bayar_id;
				$fol->jenis_pasien = $reg->jenis_pasien;
				$fol->poli_tipe = 'A';
				$fol->pasien_id = $reg->pasien_id;
				$fol->dokter_id = $reg->dokter_id;
				$fol->poli_id = $reg->poli_id;
				$fol->created_at = date("Y-m-d H:i:s", strtotime($request->created_at));
				//biaya racik
				$fol->jasa_racik = rupiah($request['jasa_racik']);
				$fol->user_id = Auth::user()->id;
				$fol->save();

				//Save Tagihan
				$tag = new Tagihan();
				$tag->user_id = Auth::user()->id;
				$tag->registrasi_id = $reg->id;
				$tag->dokter_id = $reg->dokter_id;
				$tag->diskon = 0;
				$tag->pasien_id = $reg->pasien->id;
				$tag->harus_dibayar = rupiah(Cart::subtotal(0, ',' . ','));
				$tag->subsidi = 0;
				$tag->dijamin = 0;
				$tag->selisih_positif = 0;
				$tag->selisih_negatif = 0;
				$tag->approval_tanggal = date('Y-m-d');
				$tag->user_approval = '';
				$tag->pembulatan = 0;
				$tag->save();

				Cart::destroy();
			});
			$jenis = substr($request['tipe_rawat'], 0, 1);
			return response()->json(['sukses' => true, 'id' => session('penjualanid'), 'jenis' => $jenis]);
		}
	}

	// RAJAL FAST
	public function indexRajalBaruFast()
	{
		$unit = 'Jalan';
		$data['tga']	= '';
		$data['tgb']	= '';
		$date = date('Y-m-d');

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'I1', 'I2', 'I3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'registrasis.dokter_id')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$polis = '';
		return view('penjualan.penjualan-baru.irj-fast', compact('data', 'unit', 'polis'))->with('no', 1);
	}
	public function indexRajalBaruFastBy(Request $request)
	{
		if (!$request['tga'] || !$request['tgb']) {
			$tga = date('Y-m-d');
			$tgb = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
			$tgb = valid_date($request['tgb']);
		}
		$poli = $request['poli'];

		$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3', 'I1', 'I2', 'I3']);

		if ($poli) {
			$data = $data->where('poli_id', $poli);
		}

		$data = $data->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'registrasis.dokter_id')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$unit = $request['unit'];
		$polis = $request['poli'];
		// dd($data);
		//return view('penjualan.copy-resep.irj', compact('data', 'unit'))->with('no', 1);
		return view('penjualan.penjualan-baru.irj-fast', compact('data', 'unit', 'polis'))->with('no', 1);
	}


	//penjulan terbaru
	public function indexRajalBaru()
	{
		$unit = 'Jalan';
		$data['tga']	= '';
		$data['tgb']	= '';
		$date = date('Y-m-d');

		$data = Registrasi::leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftjoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftjoin('polis', 'polis.id', '=', 'registrasis.poli_id')
			->leftjoin('penjualans', 'penjualans.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'carabayars.carabayar', 'polis.nama as nama_poli', 'penjualans.no_resep', 'penjualans.id as penjualan_id', 'penjualans.created_at as pj_created_at')
			->orderBy('registrasis.id', 'DESC')
			->get();

		$polis = '';
		return view('penjualan.penjualan-baru.irj', compact('data', 'unit', 'polis'))->with('no', 1);
	}

	public function indexRajalBaruBy(Request $request)
	{
		if (!$request['tga'] || !$request['tgb']) {
			$tga = date('Y-m-d');
			$tgb = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
			$tgb = valid_date($request['tgb']);
		}
		$poli = $request['poli'];

		if ($tga == null) {
			$tga = date('Y-m-d');
		}

		if ($request['poli'] == null) {
			$poli = '';
		} else {
			$poli = $request['poli'];
		}

		$data = Registrasi::leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftjoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftjoin('polis', 'polis.id', '=', 'registrasis.poli_id')
			->leftjoin('penjualans', 'penjualans.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'carabayars.carabayar', 'polis.nama as nama_poli', 'penjualans.no_resep', 'penjualans.id as penjualan_id', 'penjualans.created_at as pj_created_at')
			->orderBy('registrasis.id', 'DESC');

		if ($poli) {
			$data = $data->where('poli_id', $poli);
		}

		$data = $data->orderBy('registrasis.id', 'DESC')->get();
		$unit = $request['unit'];
		$polis = $request['poli'];
		// dd($data);
		//return view('penjualan.copy-resep.irj', compact('data', 'unit'))->with('no', 1);
		return view('penjualan.penjualan-baru.irj', compact('data', 'unit', 'polis'))->with('no', 1);
	}

	//penjulan terbaru
	public function indexIbsBaru(Request $request)
	{
		if ($request['tga'] == null) {
			$tga = date('Y-m-d', strtotime('-5 days'));
		} else {
			$tga = valid_date($request['tga']);
		}
		if ($request['tgb'] == null) {
			$tgb = date('Y-m-d');
		} else {
			$tgb = valid_date($request['tgb']);
		}

		// $date = date('Y-m-d', strtotime('-1 days'));

		$data = Registrasi::whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->with(['e_resep'])
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw');
		if ($request->search != null) {
			$data->where('pasiens.nama', 'like', "%$request->search%")
				->orWhere('pasiens.no_rm', 'like', "%$request->search%")
				->orderBy('registrasis.id', 'DESC');
		}
		$data = $data->paginate(10);
		return view('penjualan.penjualan-baru.ibs', compact('data'))->with('no', 1);
	}

	public function indexIbsJalanBaru(Request $request)
	{
		if ($request['tga'] == null) {
			$tga = date('Y-m-d', strtotime('-5 days'));
		} else {
			$tga = valid_date($request['tga']);
		}
		if ($request['tgb'] == null) {
			$tgb = date('Y-m-d');
		} else {
			$tgb = valid_date($request['tgb']);
		}
		$data = Registrasi::whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'G1', 'G2', 'G3'])
			->where('registrasis.pasien_id', '<>', 0)
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->with(['e_resep'])
			->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw');
		if ($request->search != null) {
			$data->where('pasiens.nama', 'like', "%$request->search%")
				->orWhere('pasiens.no_rm', 'like', "%$request->search%")
				->orderBy('registrasis.id', 'DESC');
		}
		$data = $data->paginate(10);
		return view('penjualan.penjualan-baru.ibsJalan', compact('data'))->with('no', 1);
	}

	public function indexIbsBaruBy(Request $request)
	{
		if ($request['tga'] == null) {
			$tga = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
		}
		if ($request['tgb'] == null) {
			$tgb = date('Y-m-d');
		} else {
			$tgb = valid_date($request['tgb']);
		}
		$data = Registrasi::whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->with(['e_resep'])
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw')
			->orderBy('registrasis.id', 'DESC')
			->paginate(10);
		// dd($data);
		return view('penjualan.penjualan-baru.ibs', compact('data'))->with('no', 1);
	}

	public function indexIbsJalanBaruBy(Request $request)
	{
		if ($request['tga'] == null) {
			$tga = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
		}
		if ($request['tgb'] == null) {
			$tgb = date('Y-m-d');
		} else {
			$tgb = valid_date($request['tgb']);
		}


		$data = Registrasi::with(['e_resep'])->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['J1', 'J2', 'J3'])
			->where('registrasis.pasien_id', '<>', 0)
			// ->where('registrasis.id',29572)
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw', 'pasiens.no_rm_lama')
			->get();
		// dd($data);
		return view('penjualan.penjualan-baru.ibsJalan', compact('data'))->with('no', 1);
	}




















	public function indexDaruratBaru()
	{
		$unit = 'Darurat';
		$date = date('Y-m-d', strtotime('-2 days'));
		$data['tga']	= '';
		$data['tgb']	= '';

		$data = Registrasi::leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftjoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftjoin('polis', 'polis.id', '=', 'registrasis.poli_id')
			->leftjoin('penjualans', 'penjualans.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3', 'I2', 'I1'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'carabayars.carabayar', 'polis.nama as nama_poli', 'penjualans.no_resep', 'penjualans.id as penjualan_id', 'penjualans.created_at as pj_created_at')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.penjualan-baru.igd', compact('unit', 'data'))->with('no', 1);
	}

	public function indexDaruratBaruBy(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);
		$data = Registrasi::leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftjoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftjoin('polis', 'polis.id', '=', 'registrasis.poli_id')
			->leftjoin('penjualans', 'penjualans.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['G1', 'G2', 'G3', 'I2', 'I1'])
			->select('registrasis.id as registrasi_id', 'registrasis.lunas', 'registrasis.poli_id', 'registrasis.created_at as tgl_regisrasi', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'carabayars.carabayar', 'polis.nama as nama_poli', 'penjualans.no_resep', 'penjualans.id as penjualan_id', 'penjualans.created_at as pj_created_at')
			->orderBy('registrasis.id', 'DESC')
			->get();
		$unit = $request['unit'];
		return view('penjualan.penjualan-baru.igd', compact('data', 'unit'))->with('no', 1);
	}
	public function indexDaruratBaruFast()
	{
		$unit = 'Darurat';
		$date = date('Y-m-d', strtotime('-2 days'));
		$data['tga']	= '';
		$data['tgb']	= '';

		$data = Registrasi::with(['pasien', 'poli', 'penjualan', 'bayars'])
			->whereHas('pasien')
			// ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('poli_id', [23, 24, 26])
			->whereIn('status_reg', ['G1', 'G2', 'G3', 'I2', 'I1'])
			->orderBy('id', 'DESC')
			->get();

		return view('penjualan.penjualan-baru.igd-fast', compact('unit', 'data'))->with('no', 1);;
	}

	public function indexDaruratBaruFastBy(Request $request)
	{
		$tga = valid_date($request['tga']);
		$tgb = valid_date($request['tgb']);


		$data = Registrasi::with(['pasien', 'poli', 'penjualan', 'bayars'])
			->whereHas('pasien')
			// ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('poli_id', [23, 24, 26])
			->whereIn('status_reg', ['G1', 'G2', 'G3', 'I2', 'I1'])
			->orderBy('id', 'DESC')
			->get();

		$unit = $request['unit'];
		return view('penjualan.penjualan-baru.igd-fast', compact('data', 'unit'))->with('no', 1);
	}

	public function indexIrnaBaru()
	{
		$date = date('Y-m-d', strtotime('-10 days'));
		$data = Registrasi::leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftjoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftjoin('polis', 'polis.id', '=', 'registrasis.poli_id')
			->leftjoin('penjualans', 'penjualans.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_regisrasi', 'registrasis.lunas as lunas', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.rt', 'pasiens.rw', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'carabayars.carabayar', 'polis.nama as nama_poli', 'penjualans.no_resep', 'penjualans.id as penjualan_id', 'penjualans.created_at as pj_created_at')
			->orderBy('registrasis.id', 'DESC')
			->get();
		// $data = Registrasi::with(['e_resep'])->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		// 	->whereIn('registrasis.status_reg', ['I1','I2','I3'])
		// 	->where('registrasis.pasien_id', '<>', 0)
		// 	->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.lunas as lunas', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw')
		// 	->orderBy('registrasis.id', 'DESC')
		// 	->get();
		return view('penjualan.penjualan-baru.irna', compact('data'))->with('no', 1);
	}

	public function indexIrnaBaruBy(Request $request)
	{
		if ($request['tga'] == null) {
			$tga = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
		}
		if ($request['tgb'] == null) {
			$tgb = date('Y-m-d');
		} else {
			$tgb = valid_date($request['tgb']);
		}

		$data = Registrasi::leftjoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftjoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
			->leftjoin('polis', 'polis.id', '=', 'registrasis.poli_id')
			->leftjoin('penjualans', 'penjualans.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->select('registrasis.id as registrasi_id', 'registrasis.poli_id', 'registrasis.created_at as tgl_regisrasi', 'registrasis.lunas as lunas', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.rt', 'pasiens.rw', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'carabayars.carabayar', 'polis.nama as nama_poli', 'penjualans.no_resep', 'penjualans.id as penjualan_id', 'penjualans.created_at as pj_created_at')
			->orderBy('registrasis.id', 'DESC')
			->get();
		// $data = Registrasi::with(['e_resep'])->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
		// 	->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
		// 	->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
		// 	->where('registrasis.pasien_id', '<>', 0)
		// 	// ->where('registrasis.id',29572)
		// 	->select('registrasis.id as registrasi_id','registrasis.lunas as lunas', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at', 'pasiens.id as pasien_id','pasiens.nama','pasiens.alamat','pasiens.no_rm','pasiens.no_rm_lama','pasiens.rt','pasiens.rw','pasiens.no_rm_lama')
		// 	->get();
		// dd($data);
		return view('penjualan.penjualan-baru.irna', compact('data'))->with('no', 1);
	}
	public function indexIrnaBaruFast()
	{
		$poli = Poli::all()->pluck('nama', 'id');
		$unit = 'Inap';
		$date = date('Y-m-d', strtotime('-10 days'));
		// $kamar = Kamar::all()->pluck('nama', 'id');
		$kamar = Kamar::all()->map(function ($item) {
			// Hilangkan kata Kelas, VIP, dan Kamar di akhir (dan spasi sebelumnya)
			return trim(preg_replace('/\s*(Kelas\s*\d*|VIP|Kamar).*/i', '', $item->nama));
		})->unique()->sort()->values();

		$data = Registrasi::with(['e_resep'])->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->whereBetween('registrasis.created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0)
			->select('registrasis.id as registrasi_id', 'registrasis.created_at as created_at', 'registrasis.lunas as lunas', 'registrasis.poli_id', 'registrasis.bayar', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw','registrasis.dokter_id')
			->orderBy('registrasis.id', 'DESC')
			->get();
		return view('penjualan.penjualan-baru.irna-fast', compact('data', 'unit','poli','kamar'))->with('no', 1);
	}

	public function indexIrnaBaruFastBy(Request $request)
	{
		$poli = Poli::all()->pluck('nama', 'id');
		$unit = 'Inap';
		// $kamar = Kamar::all()->pluck('nama', 'id');
		$kamar = Kamar::all()->map(function ($item) {
			// Hilangkan kata Kelas, VIP, dan Kamar di akhir (dan spasi sebelumnya)
			return trim(preg_replace('/\s*(Kelas\s*\d*|VIP|Kamar).*/i', '', $item->nama));
		})->unique()->sort()->values();
		
		$filterKamar = $request['kamar_id'];
		if ($request['tga'] == null) {
			$tga = date('Y-m-d');
		} else {
			$tga = valid_date($request['tga']);
		}
		if ($request['tgb'] == null) {
			$tgb = date('Y-m-d');
		} else {
			$tgb = valid_date($request['tgb']);
		}
		$selected_poli = $request['poli_id'];
		// dd($request->all());
		$data = Registrasi::with(['e_resep'])->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->leftJoin('rawatinaps', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
			->leftJoin('kamars', 'kamars.id', '=', 'rawatinaps.kamar_id')
			->whereBetween('registrasis.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
			->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
			->where('registrasis.pasien_id', '<>', 0);
			// ->where('registrasis.id',29572)
		if($request['poli_id']){
			$data = $data->where('registrasis.poli_id',$request['poli_id']);
		}
		if ($request['kamar_id']) {
			$data = $data->where('kamars.nama', 'LIKE', $request['kamar_id'].'%');
		}
		// dd($request->all());
		$data = $data->select('registrasis.id as registrasi_id', 'registrasis.lunas as lunas', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.created_at', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_rm', 'pasiens.no_rm_lama', 'pasiens.rt', 'pasiens.rw', 'pasiens.no_rm_lama','registrasis.dokter_id')->get();
		// dd($data);
		return view('penjualan.penjualan-baru.irna-fast', compact('data', 'unit','poli','selected_poli', 'kamar', 'filterKamar'))->with('no', 1);
	}

	public function form_penjualan_baru(Request $request, $idpasien, $idreg, $penjualan_id = '')
	{

		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);
		// CEK APAKAH ADA NOMORANTRIAN
		if ($data['reg']->nomorantrian) {

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

			// if(status_consid(4)){
			// 	$updatewaktu4   = '{
			// 		"kodebooking": "'.$data['reg']->nomorantrian.'",
			// 		"taskid": "4",
			// 		"waktu": "'.round(microtime(true) * 1000).'"
			// 	}';
			// 	$session4 = curl_init($completeurl);
			// 	curl_setopt($session4, CURLOPT_HTTPHEADER, $arrheader);
			// 	curl_setopt($session4, CURLOPT_POSTFIELDS, $updatewaktu4);
			// 	curl_setopt($session4, CURLOPT_POST, TRUE);
			// 	curl_setopt($session4, CURLOPT_RETURNTRANSFER, TRUE);
			// 	curl_exec($session4);

			// }



			if (status_consid(5)) {
				$updatewaktu   = '{
					"kodebooking": "' . $data['reg']->nomorantrian . '",
					"taskid": "5",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($session2);
			}


			if (status_consid(6)) {
				// CONSID 6
				$updatewaktu6   = '{
					"kodebooking": "' . $data['reg']->nomorantrian . '",
					"taskid": "6",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session6 = curl_init($completeurl);
				curl_setopt($session6, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session6, CURLOPT_POSTFIELDS, $updatewaktu6);
				curl_setopt($session6, CURLOPT_POST, TRUE);
				curl_setopt($session6, CURLOPT_RETURNTRANSFER, TRUE);
				$resp6 = curl_exec($session6);
			}
		}

		if (!empty($request->resep)) {
			$data['resep'] = ResepNote::with('resep_detail.logistik_batch.master_obat')->where('uuid', $request->resep)->where('registrasi_id', $idreg)->where('status', 'dikirim')->first();
		}

		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($idpasien);
		// $data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = Penjualan::where('id', '=', session('penjualanid'))->first();
		$data['detail'] = Penjualandetail::where('no_resep', '=', @$data['penjualan']->no_resep)->get();
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['penjualanid'] = session('penjualanid');
		$data['next_resep'] = session('next_resep');
		// return $data; die;
		return view('penjualan.penjualan-baru.form_penjualan', $data)->with('idreg', $idreg);
	}


	public function form_penjualan_baru_ibs(Request $request, $idpasien, $idreg, $penjualan_id = '')
	{

		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);
		// CEK APAKAH ADA NOMORANTRIAN
		if ($data['reg']->nomorantrian) {

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

			// if(status_consid(4)){
			// 	$updatewaktu4   = '{
			// 		"kodebooking": "'.$data['reg']->nomorantrian.'",
			// 		"taskid": "4",
			// 		"waktu": "'.round(microtime(true) * 1000).'"
			// 	}';
			// 	$session4 = curl_init($completeurl);
			// 	curl_setopt($session4, CURLOPT_HTTPHEADER, $arrheader);
			// 	curl_setopt($session4, CURLOPT_POSTFIELDS, $updatewaktu4);
			// 	curl_setopt($session4, CURLOPT_POST, TRUE);
			// 	curl_setopt($session4, CURLOPT_RETURNTRANSFER, TRUE);
			// 	curl_exec($session4);
			// }


			if (status_consid(5)) {
				$updatewaktu   = '{
					"kodebooking": "' . $data['reg']->nomorantrian . '",
					"taskid": "5",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($session2);
			}

			if (status_consid(6)) {
				// CONSID 6
				$updatewaktu6   = '{
					"kodebooking": "' . $data['reg']->nomorantrian . '",
					"taskid": "6",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session6 = curl_init($completeurl);
				curl_setopt($session6, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session6, CURLOPT_POSTFIELDS, $updatewaktu6);
				curl_setopt($session6, CURLOPT_POST, TRUE);
				curl_setopt($session6, CURLOPT_RETURNTRANSFER, TRUE);
				$resp6 = curl_exec($session6);
			}
		}

		if (!empty($request->resep)) {
			$data['resep'] = ResepNote::with('resep_detail.logistik_batch.master_obat')->where('uuid', $request->resep)->where('registrasi_id', $idreg)->where('status', 'dikirim')->first();
		}

		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($idpasien);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = Penjualan::find(session('penjualanid'));
		$data['detail'] = Penjualandetail::where('no_resep', '=', session('next_resep'))->get();
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['penjualanid'] = session('penjualanid');
		$data['next_resep'] = session('next_resep');
		// return $data; die;
		return view('penjualan.penjualan-baru.form_penjualan_ibs', $data)->with('idreg', $idreg);
	}
















	public function getMasterObatBaru(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = LogistikBatch::leftJoin('masterobats', 'logistik_batches.masterobat_id', '=', 'masterobats.id')
			->where('logistik_batches.gudang_id', Auth::user()->gudang_id)
			->where('masterobats.nama', 'like', '%' . $term . '%')->where('stok', '!=', 0)->limit(15)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')
			->whereNull('masterobats.deleted_at')
			->select('logistik_batches.*', 'masterobats.nama')
			->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->hargajual_jkn) . ' | ' . $tag->nomorbatch . ' | ' . $tag->stok . ' | ED: ' . $tag->expireddate];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->hargajual_kesda) . ' | ' . $tag->nomorbatch . ' | ' . $tag->stok . ' | ED: ' . $tag->expireddate];
			} else {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->hargajual_jkn) . ' | ' . $tag->nomorbatch . ' | ' . $tag->stok . ' | ED: ' . $tag->expireddate];
			}
		}
		return \Response::json($formatted_tags);
	}

	public function getMasterObatBaruIbs(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = LogistikBatch::where('gudang_id', 2)->where('nama_obat', 'like', '%' . $term . '%')->where('stok', '!=', 0)->limit(15)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat . ' | Rp. ' . number_format($tag->hargajual_jkn) . ' | ' . $tag->nomorbatch . ' | ' . $tag->stok . ' | ED: ' . $tag->expireddate];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat . ' | Rp. ' . number_format($tag->hargajual_kesda) . ' | ' . $tag->nomorbatch . ' | ' . $tag->stok . ' | ED: ' . $tag->expireddate];
			} else {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat . ' | Rp. ' . number_format($tag->hargajual_jkn) . ' | ' . $tag->nomorbatch . ' | ' . $tag->stok . ' | ED: ' . $tag->expireddate];
			}
		}
		return \Response::json($formatted_tags);
	}






	//  E RESEP
	public function getDataMasterObatBaruNoBatch($id)
	{
		$obat = LogistikNoBatch::where('id', $id)->first();
		return response()->json(['obat' => $obat]);
	}
	public function getMasterObatBaruResepNoBatch(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = LogistikNoBatch::join('masterobats', 'masterobats.id', 'logistik_no_batches.masterobat_id')
			->where('masterobats.nama', 'like', '%' . $term . '%')
			->where('logistik_no_batches.saldo', '!=', 0)
			->limit(15)
			->orderByRaw('DATE_FORMAT(logistik_no_batches.expired_date, "%m-%d")')
			->select('logistik_no_batches.id', 'masterobats.nama')
			->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama];
			} else {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama];
			}
		}
		return \Response::json($formatted_tags);
	}

	public function getMasterObatBaruResep(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}
		$tags = LogistikBatch::leftJoin('masterobats', 'logistik_batches.masterobat_id', '=', 'masterobats.id')
			->where('logistik_batches.gudang_id', '3')
			->where('masterobats.nama', 'like', '%' . $term . '%')
			// ->where('jenis_obat','TABLET')
			// ->where('logistik_batches.stok', '>', '0')
			->limit(15)
			// ->orderByRaw('DATE_FORMAT(logistik_batches.expireddate, "%m-%d")')->get();
			->select('logistik_batches.id', 'masterobats.nama as nama_obat', 'logistik_batches.nomorbatch', 'logistik_batches.hargajual_umum', 'logistik_batches.hargajual_jkn')
			->orderBy('logistik_batches.id', 'DESC')
			->whereNull('masterobats.deleted_at')
			->groupBy('logistik_batches.masterobat_id')
			
			->get();

		// $tags = LogistikBatch::where('gudang_id', '2')
		// 		->where('nama_obat', 'like', '%' . $term . '%')
		// 		// ->where('stok', '!=', '0')
		// 		->where('stok', '!=', 0)
		// 		->limit(15)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')->get();


		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat . ' | JKN: ' . @number_format(@$tag->hargajual_jkn) . ' | ' . 'Umum: ' . @number_format(@$tag->hargajual_umum)];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat];
			} else {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat];
			}
		}
		return \Response::json($formatted_tags);
	}

	public function getMasterObatBaruResepRacik(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = LogistikBatch::where('logistik_batches.gudang_id', '2')
			->leftJoin('masterobats', 'logistik_batches.masterobat_id', '=', 'masterobats.id')
			->where('logistik_batches.nama_obat', 'like', '%' . $term . '%')
			// ->whereIn('masterobats.jenis_obat',['TABLET','TAB'])
			// ->whereIn('logistik_batches.satuanjual_id', ['74','113'])
			->where('logistik_batches.satuanjual_id', '113')
			// ->where('logistik_batches.stok', '>', '0')
			->select('logistik_batches.id', 'logistik_batches.nama_obat')
			->limit(15)
			->orderByRaw('DATE_FORMAT(logistik_batches.expireddate, "%m-%d")')
			->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat];
			} else {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat];
			}
		}
		return \Response::json($formatted_tags);
	}






	public function getMasterKode(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Icd10::where('nama', 'like', '%' . $term . '%')->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->nomor, 'text' => $tag->nama];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->nomor, 'text' => $tag->nama];
			} else {
				$formatted_tags[] = ['id' => $tag->nomor, 'text' => $tag->nama];
			}
		}
		return \Response::json($formatted_tags);
	}




	public function getMasterKodeIcd9(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Icd9::where('nomor', 'like', '%' . $term . '%')->get();

		$formatted_tags = [];
		foreach ($tags as $tag) {
			if ($request->j == 1) {
				$formatted_tags[] = ['id' => $tag->nomor, 'text' => $tag->nomor . ' | ' . $tag->nama];
			} elseif ($request->j == 5) {
				$formatted_tags[] = ['id' => $tag->nomor, 'text' => $tag->nomor . ' | ' . $tag->nama];
			} else {
				$formatted_tags[] = ['id' => $tag->nomor, 'text' => $tag->nomor . ' | ' . $tag->nama];
			}
		}
		return \Response::json($formatted_tags);
	}















	public function getDataMasterObatBaru($id)
	{
		$obat = LogistikBatch::where('id', $id)->first();
		$kategori_obat = $obat->master_obat->kategoriobat->nama;
		return response()->json(['obat' => $obat, 'kategori_obat' => $kategori_obat]);
	}

	public function getDataMasterKode($kode)
	{
		$kode = Icd10::where('nama', $kode)->first();
		return response()->json(['kode' => $kode->nama, 'id' => $kode->id]);
	}

	//simpan
	public function saveDetailBaru(Request $request)
	{
		$request->validate(['masterobat_id' => 'required']);
		$logistik_batch_id = $request->masterobat_id;
		if (!session('next_resep')) {
			$jenis = Registrasi::find($request['idreg'])->status_reg;
			if (substr($jenis, 0, 1) == 'J') {
				$next_resep = 'FRJ' . date('YmdHis');
			} elseif (substr($jenis, 0, 1) == 'I') {
				$next_resep = 'FRI' . date('YmdHis');
			} elseif (substr($jenis, 0, 1) == 'G') {
				$next_resep = 'FRD' . date('YmdHis');
			}

			//Save Penjualan
			$p = new Penjualan();
			$p->no_resep = $next_resep;
			$p->user_id = Auth::user()->id;
			$p->registrasi_id = $request['idreg'];
			$p->dokter_id = $request['dokter_id'];
			// $p->created_at = valid_date($request['created_at']);
			$p->save();

			session(['penjualanid' => $p->id]);
			session(['next_resep' => $next_resep]);
		}
		$obat = LogistikBatch::leftJoin('masterobats', 'masterobats.id', '=', 'logistik_batches.masterobat_id')
			->where('logistik_batches.id', $logistik_batch_id)
			->select('masterobats.nama', 'logistik_batches.*')
			->first();

		$cekdata = Penjualandetail::where('no_resep', session('next_resep'))->where('logistik_batch_id', $logistik_batch_id)->exists();

		if ($logistik_batch_id == config('app.obatRacikan_id')) {
			$harga = rupiah($request['racikan']);
		}

		if ($request['kronis'] == 'N') {
			if ($cekdata) {
				return response()->json([
					'sukses' => false,
					'error'  => 'Obat Sudah ada!'
				]);
			} else {
				if (cek_jenispasien($request['idreg']) == '1') {
					$harga = $obat->hargajual_jkn;
				} else {
					$harga = $obat->hargajual_umum;
				}

				if ($request['diskon'] == null) {
					$diskon = 0;
				} else {
					$diskon = $request['diskon'];
				}

				$hargaReal = $harga - ($harga * ($diskon / 100));
				$id_medication_dep = '';

				$Uangracik   = UangRacik::find($request['uang_racik']);

				$d = new Penjualandetail();
				$d->penjualan_id = session('penjualanid');
				if (@$request->kronis == 'Y') {
					$d->is_kronis = @$request->kronis;
				}
				$d->no_resep = session('next_resep');
				$d->masterobat_id = $obat->masterobat_id;
				$d->id_medication_dep = @$id_medication_dep;
				$d->logistik_batch_id = $request['masterobat_id'];
				$d->jml_kronis  = $request['jml_kronis'];
				$d->diskon  = $request['diskon'];
				$d->jumlah = $request['jumlah'];
				$d->uang_racik = rupiah($Uangracik->nominal);
				$d->uang_racik_id = $request['uang_racik'];
				$d->hargajual = $hargaReal * $request['jumlah'];
				if (substr($request['tipe_rawat'], 0, 1) == 'J') {
					$d->tipe_rawat = 'TA';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
					$d->tipe_rawat = 'TG';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
					$d->tipe_rawat = 'TI';
				}
				$d->expired = $request['expired'];
				$d->informasi1 = $request['informasi1'];
				$d->hargajual_kronis = $hargaReal * $request['jml_kronis'];
				$d->bud  = $request['bud'];
				$d->cara_minum_id  = $request['cara_minum_id'];
				$d->takaran	= $request['takaran'];
				$d->etiket = $request['tiket'];
				$d->cetak = $request['cetak'];
				$d->save();
				// return response()->json([
				//     'sukses' => true,
				//     'detail' => $d,
				//     'obat'   => $obat
				// ]);
			}
		} elseif ($request['kronis'] == 'Y') {
			if ($cekdata) {
				return response()->json([
					'sukses' => false,
					'message'  => 'Obat Sudah ada!'
				]);
			}
			/**
			 * Jika obat Kronis, maka hitung rumus
			 * Pemakaian obat full adalah 30 
			 * Pemakaian obat 1/2 adalah 15
			 * Pemakaian obat 1/4 adalah 8
			 * 
			 * Obat full (30) | 23 untuk kronis & 7 untuk non kronis
			 * Obat 1/2 (15) | 15/30= 0.5 0.5*7=3.5 -> pembulatan keatas jadi 4 untuk non kronis & 15-4 = 11 untuk kronis
			 * Obat 1/4 (8)  | 8/30=0.26 0.26*7= 1.82 -> pembulatan keatas jadi 2 untuk non kronis & 8-2 = 6 untuk kronis
			 */

			if (cek_jenispasien($request['idreg']) == '1') {
				$harga = $obat->hargajual_jkn;
			} else {
				$harga = $obat->hargajual_umum;
			}

			if ($request['diskon'] == null) {
				$diskon = 0;
			} else {
				$diskon = $request['diskon'];
			}

			$hargaReal = $harga - ($harga * ($diskon / 100));
			$id_medication_dep = '';

			$jml_obat = $request['jumlah'];
			$ds = intval($jml_obat / 30);
			$sisa = $jml_obat % 30;
			if ($sisa == 0 || $sisa == 15 || $sisa == 8) {
				$jml_obat_kronis = $ds * 23;
				$jml_obat_non_kronis = $ds * 7;

				if ($sisa == 15) {
					$jml_obat_kronis += 11;
					$jml_obat_non_kronis += 4;
				}

				if ($sisa == 8) {
					$jml_obat_kronis += 6;
					$jml_obat_non_kronis += 2;
				}

				$Uangracik   = UangRacik::find($request['uang_racik']);

				// Insert Kronis
				$d = new Penjualandetail();
				$d->penjualan_id = session('penjualanid');
				$d->is_kronis = 'Y';
				$d->no_resep = session('next_resep');
				$d->masterobat_id = $obat->masterobat_id;
				$d->id_medication_dep = @$id_medication_dep;
				$d->logistik_batch_id = $request['masterobat_id'];
				$d->jml_kronis  = $request['jml_kronis'];
				$d->diskon  = $request['diskon'];
				$d->jumlah = $jml_obat_kronis;
				$d->uang_racik = rupiah($Uangracik->nominal);
				$d->uang_racik_id = $request['uang_racik'];
				$d->hargajual = $hargaReal * ($jml_obat_kronis);
				if (substr($request['tipe_rawat'], 0, 1) == 'J') {
					$d->tipe_rawat = 'TA';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
					$d->tipe_rawat = 'TG';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
					$d->tipe_rawat = 'TI';
				}
				$d->expired = $request['expired'];
				$d->informasi1 = $request['informasi1'];
				$d->hargajual_kronis = $hargaReal * $request['jml_kronis'];
				$d->bud  = $request['bud'];
				$d->cara_minum_id  = $request['cara_minum_id'];
				$d->takaran	= $request['takaran'];
				$d->etiket = $request['tiket'];
				$d->cetak = $request['cetak'];
				$d->save();

				// Insert Non Kronis
				$d = new Penjualandetail();
				$d->penjualan_id = session('penjualanid');
				$d->is_kronis = 'N';
				$d->no_resep = session('next_resep');
				$d->masterobat_id = $obat->masterobat_id;
				$d->id_medication_dep = @$id_medication_dep;
				$d->logistik_batch_id = $request['masterobat_id'];
				$d->jml_kronis  = $request['jml_kronis'];
				$d->diskon  = $request['diskon'];
				$d->jumlah = $jml_obat_non_kronis;
				$d->uang_racik = rupiah($Uangracik->nominal);
				$d->uang_racik_id = $request['uang_racik'];
				$d->hargajual = $hargaReal * ($jml_obat_non_kronis);
				if (substr($request['tipe_rawat'], 0, 1) == 'J') {
					$d->tipe_rawat = 'TA';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
					$d->tipe_rawat = 'TG';
				} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
					$d->tipe_rawat = 'TI';
				}
				$d->expired = $request['expired'];
				$d->informasi1 = $request['informasi1'];
				$d->hargajual_kronis = $hargaReal * $request['jml_kronis'];
				$d->bud  = $request['bud'];
				$d->cara_minum_id  = $request['cara_minum_id'];
				$d->takaran	= $request['takaran'];
				$d->etiket = $request['tiket'];
				$d->cetak = $request['cetak'];
				$d->save();
			} else {
				return response()->json([
					'sukses'   => false,
					'message' => "Obat kronis hanya bisa ditambah untuk pemakaian penuh, 1/2, ataupun 1/4"
				]);
			}
		}

		$penjualanDetails = Penjualandetail::leftJoin('masterobats', 'masterobats.id', '=', 'penjualandetails.masterobat_id')->where('penjualandetails.no_resep', session('next_resep'))->select('masterobats.nama', 'penjualandetails.*')->get();
		// return redirect('penjualan/form-penjualan-baru/' . $request['pasien_id'] . '/' . $request['idreg'] . '/' . $request['penjualan_id']);
		return response()->json([
			'sukses'   => true,
			'id'        => session('penjualanid'),
			'jenis'     => $request['idreg'],
			'details'   => $penjualanDetails
		]);
	}

	public function saveTotalBaru(Request $request)
	{
		$jasa_racik   	= rupiah($request['jasa_racik']);
		$penjualan_id 	= $request['penjualan_id'] ? $request['penjualan_id'] : session('penjualanid');
		$cara_bayar		= $request['cara_bayar'];
		$pembuat_resep = $request['pembuat_resep'];
		$successtte = false;
		$proses_tte = $request->tte;
		$message = null;
		$jenis = substr($request['tipe_rawat'], 0, 1);

		// Update waktu
		$reg = Registrasi::find($request['reg_id']);
		// @updateTaskId(7,$reg->nomorantrian);

		if ($reg->nomorantrian) {

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

			if (status_consid(6)) {
				$updatewaktu   = '{
					"kodebooking": "' . @$reg->nomorantrian . '",
					"taskid": "6",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($session2);
				$sml2 = json_decode($resp, true);
			}

			// if (status_consid(7)) {
			// 	// UPDATE TASK ID 7
			// 	$updatewaktu2   = '{
			// 		"kodebooking": "' . @$reg->nomorantrian . '",
			// 		"taskid": "7",
			// 		"waktu": "' . round(microtime(true) * 1000) . '"
			// 	}';
			// 	$session3 = curl_init($completeurl);
			// 	curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
			// 	curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
			// 	curl_setopt($session3, CURLOPT_POST, TRUE);
			// 	curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
			// 	$response3 = curl_exec($session3);
			// 	$sml3 = json_decode($response3, true);

			// 	if (isset($sml3)) {
			// 		if (@$sml3['metadata']['code'] == '200' || @$sml3['metadata']['code'] == '208') {
			// 			@$reg = RegistrasiDummy::where('nomorantrian', @$reg->nomorantrian)->first();
			// 			if (@$reg) {
			// 				@$reg->taskid = 7;
			// 				@$reg->status = 'dilayani';
			// 				@$reg->save();
			// 			}
			// 		}
			// 	}
			// }
			// else{
			// 	return response()->json(['sukses' => true, 'message' => $resp['metadata']['message'], 'jenis' =>'']);
			// }
		}
		// return $request; $die;
		DB::beginTransaction();
		try {
			$total = 0;
			$pj = Penjualan::find($penjualan_id);
			$pj->pembuat_resep = @$pembuat_resep;
			$pj->response_time = $request['response_time'];
			$pj->update();

			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$tipe_rawat = 'TI';
			}

			$tipe['tipe_rawat'] = $tipe_rawat;
			Penjualandetail::where('penjualan_id', $penjualan_id)->update($tipe);
			$det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();

			// Optimize Query | menghindari query didalam loop
			$user_gudang_id = Auth::user()->gudang_id;
			$arr_logistik_batch = $det->pluck('logistik_batch_id')->toArray();
			$logistikBatches = LogistikBatch::whereIn('id', $arr_logistik_batch)->get();

			$arr_masterobat_id = $det->pluck('masterobat_id')->toArray();

			$logistikStockCreate = [];
			foreach ($det as $key => $d) {
				$stocks = LogistikBatch::where('gudang_id',  $user_gudang_id)
					->whereIn('masterobat_id', $arr_masterobat_id)
					->get(['masterobat_id', 'stok']);

				$total += $d->hargajual;
				// if (Auth::user()->gudang_id == 2) {
				if ($d->logistik_batch_id) {
					$saldo_obat = $logistikBatches->where('id', $d->logistik_batch_id)->first();

					// Jika id bukan 610 (riri) maka mempengaruhi stock
					if (Auth::user()->id != 610) {
						$saldo_obat->stok = ($saldo_obat->stok - ($d->jumlah + $d->jml_kronis));
						$saldo_obat->save();
					}

					$stok_batch = $stocks->where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');

					if ($stok_batch != 0  &&  $stok_batch != NULL) {
						$total_stok = $stok_batch;
					} else {
						$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
					}



					$logistikStok = [
						'gudang_id'         => $user_gudang_id,
						'supplier_id'       => null,
						'masterobat_id'     => $saldo_obat->masterobat_id,
						'logistik_batch_id' => $saldo_obat->id,
						'batch_no'          => $saldo_obat->nomorbatch,
						'expired_date'      => date("Y-m-d", strtotime($saldo_obat->expireddate)),
						'masuk'             => 0,
						'keluar'            => $d->jumlah + $d->jml_kronis,
						'total'             => $total_stok - ($d->jumlah + $d->jml_kronis),
						'keterangan'        => 'Penjualan ' . $pj->no_resep
					];
					array_push($logistikStockCreate, $logistikStok);
				}
			}
			LogistikStock::insert($logistikStockCreate);

			$total;
			$reg = Registrasi::find($pj->registrasi_id);

			$fol = Folio::where('namatarif', $pj->no_resep)->where('registrasi_id', $reg->id)->first();
			if (!$fol) {
				$fol = new Folio();
			}
			$fol->total = $total;
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->cara_bayar_id = $cara_bayar;
			$fol->gudang_id = $user_gudang_id;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = @$jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
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

			// update E Resep
			if (!empty($request->resep_uuid)) {
				@$resep = ResepNote::where('uuid', $request->resep_uuid)->first();
				if (isset($resep)) {
					@$dt_resep = [
						"no_resep" => @$pj->no_resep,
						"status" => 'selesai',
						"proses" => 'selesai',
						"comment" => @$request->ket_resep
					];
					@$resep->update($dt_resep);
				}
			}

			// Proses TTE
			if (!empty($request->tte)) {
				if (tte()) {
					// Create temp pdf eresep file
					$resep_note = ResepNote::where('penjualan_id', $penjualan_id)->first();
					$ttePDF = json_decode($resep_note->tte);
					$base64 = $ttePDF->base64_signed_file;
					$pdfContent = base64_decode($base64);

					$filePath = uniqId() . 'eresep-laporan.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(500)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					// Proses TTE
					$tte = tte_visible_koordinat($filePath, $request->nik_hidden, $request->passphrase, "##", $qrCodePath);

					log_esign($reg->id, $tte->response, "eresep-farmasi", $tte->httpStatusCode);

					$resp = json_decode($tte->response);

					if ($tte->httpStatusCode == 200) {
						$resep_note->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$resep_note->update();
						$successtte = true;

						session()->forget('idpenjualan');
						session()->forget('penjualanid');
						session()->forget('next_resep');
						DB::commit();
						return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
					} elseif ($tte->httpStatusCode == 400) {
						if (isset($resp->error)) {
							$message = $resp->error;
						} else {
							$message = 'Gagal melakukan proses TTE';
						}
					}

					DB::rollback();

					log_esign($reg->id, $tte->response, "eresep-farmasi", $tte->httpStatusCode);
					return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte, 'message' => $message]);
				} else {
					session()->forget('idpenjualan');
					session()->forget('penjualanid');
					session()->forget('next_resep');
					DB::commit();
					return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
				}
			} else {
				session()->forget('idpenjualan');
				session()->forget('penjualanid');
				session()->forget('next_resep');
				DB::commit();
				return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
			}

			DB::rollback();
			return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte, 'message' => $message]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['sukses' => false, 'id' => $penjualan_id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
		}
	}


	public function saveTotalBaruCart(Request $request)
	{
		$jasa_racik   	= rupiah($request['jasa_racik']);
		$penjualan_id 	= $request['penjualan_id'];
		$cara_bayar		= $request['cara_bayar'];
		$pembuat_resep = $request['pembuat_resep'];
		$successtte = false;
		$proses_tte = $request->tte;
		$jenis = substr($request['tipe_rawat'], 0, 1);

		// Update waktu
		$reg = Registrasi::find($request['reg_id']);

		// return $request; $die;

		DB::beginTransaction();
		try {
			$total = 0;

			// $pj = Penjualan::find($penjualan_id);
			// $pj->pembuat_resep = @$pembuat_resep;
			// $pj->response_time = $request['response_time'];
			// $pj->update();
			// dd(Cart::content());

			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$tipe_rawat = 'TI';
			}

			$tipe['tipe_rawat'] = $tipe_rawat;
			// Penjualandetail::where('penjualan_id', $penjualan_id)->update($tipe);
			// $det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();

			// Optimize Query | menghindari query didalam loop
			$user_gudang_id = Auth::user()->gudang_id;

			// $arr_masterobat_id = $det->pluck('masterobat_id')->toArray();


			// $arr_logistik_batch = $det->pluck('logistik_batch_id')->toArray();
			if (Cart::subtotal() >= 0) {
				// $logistikBatches = LogistikBatch::whereIn('id', $arr_logistik_batch)->get();
				$logistikStockCreate = [];
				if (substr($reg->status_reg, 0, 1) == 'J') {
					$next_resep = 'FRJ' . date('YmdHis');
				} elseif (substr($reg->status_reg, 0, 1) == 'I') {
					$next_resep = 'FRI' . date('YmdHis');
				} elseif (substr($reg->status_reg, 0, 1) == 'G') {
					$next_resep = 'FRD' . date('YmdHis');
				}
				$pj = new Penjualan();
				$pj->no_resep = $next_resep;
				$pj->pembuat_resep = $request['pembuat_resep'];
				$pj->user_id = Auth::user()->id;
				$pj->registrasi_id = $request['reg_id'];
				$pj->response_time = $request['response_time'];
				// $pj->created_at = valid_date($request['created_at']);
				$pj->save();
				// dd($pj);
				// foreach ($det as $key => $d) 
				// dd(Cart::content());
				foreach (Cart::content() as $d) {
					$stocks = LogistikBatch::where('id', $d->options->logistik_batch_id)
						->where('gudang_id',  $user_gudang_id)
						// ->whereIn('masterobat_id', $arr_masterobat_id)
						->get(['masterobat_id', 'stok']);

					// $total += $d->hargajual;
					// if (Auth::user()->gudang_id == 2) {
					if ($d->options->logistik_batch_id) {
						$saldo_obat = LogistikBatch::where('id', $d->options->logistik_batch_id)->first();

						// Jika id bukan 610 (riri) maka mempengaruhi stock
						if (Auth::user()->id != 610) {
							$saldo_obat->stok = ($saldo_obat->stok - ($d->qty + $d->options->jml_kronis));
							$saldo_obat->save();
						}

						$stok_batch = $stocks->where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');

						if ($stok_batch != 0  &&  $stok_batch != NULL) {
							$total_stok = $stok_batch;
						} else {
							$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
						}

						// Mekanisme baru untuk obat kronis dan nonkronis
						// QTY obat simpan di jumlah (baik kronis ataupun tidak)
						// col is_kronis menunjukan obat itu kronis atau tidak
						// Jadi dalam satu faktur penjualan bisa jadi ada dua obat yang sama satu nya kronis dan satunya tidak
						$pd = new Penjualandetail();
						$pd->penjualan_id = $pj->id;
						$pd->no_resep = $pj->no_resep;
						$pd->masterobat_id = $saldo_obat->masterobat_id;
						$pd->jumlah = $d->qty;
						$pd->is_kronis = $d->options->is_kronis;
						$pd->jml_kronis = $d->options->jml_kronis;
						$pd->uang_racik = $d->options->uang_racik;
						$pd->hargajual = $d->price * $d->qty;
						$pd->hargajual_kronis = $d->price * $d->options->jml_kronis;
						$pd->informasi1 = $d->options->informasi1;
						$pd->informasi2 = $d->options->informasi2;
						$pd->bud = $d->options->bud;
						$pd->cara_minum_id = $d->options->cara_minum_id;
						$pd->tipe_rawat = @$tipe_rawat;
						$pd->cara_bayar_id = $d->options->cara_bayar_id;
						$pd->expired = $d->options->expired;
						$pd->bud = $d->options->bud;
						$pd->etiket = $d->options->tiket;
						$pd->takaran =  $d->options->takaran;
						$pd->logistik_batch_id =  $d->options->logistik_batch_id;
						$pd->cetak = $d->options->cetak;
						$pd->created_at = $d->options->created ?? valid_date($request['created_at']);
						$pd->save();
						// dd($pd);

						$logistikStok = [
							'gudang_id'         => $user_gudang_id,
							'supplier_id'       => null,
							'masterobat_id'     => $saldo_obat->masterobat_id,
							'logistik_batch_id' => $saldo_obat->id,
							'batch_no'          => $saldo_obat->nomorbatch,
							'expired_date'      => date("Y-m-d", strtotime($saldo_obat->expireddate)),
							'masuk'             => 0,
							'keluar'            => $d->qty + $d->options->jml_kronis,
							'total'             => $total_stok - ($d->qty + $d->options->jml_kronis),
							'keterangan'        => 'Penjualan ' . $pj->no_resep
						];
						array_push($logistikStockCreate, $logistikStok);
					}
				}
			}


			LogistikStock::insert($logistikStockCreate);

			$total = (rupiah(Cart::subtotal(0, ',' . ',')));
			$reg = Registrasi::find($pj->registrasi_id);

			$fol = Folio::where('namatarif', $pj->no_resep)->where('registrasi_id', $reg->id)->first();
			if (!$fol) {
				$fol = new Folio();
			}
			$fol->total = $total;
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->cara_bayar_id = $cara_bayar;
			$fol->gudang_id = $user_gudang_id;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = @$jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
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

			$tte = null;
			// Proses TTE
			if (!empty($request->tte)) {
				if (tte()) {
					// Create temp pdf eresep file
					$resep_note = ResepNote::where('penjualan_id', $penjualan_id)->first();
					$ttePDF = json_decode($resep_note->tte);
					$base64 = $ttePDF->base64_signed_file;
					$pdfContent = base64_decode($base64);

					$filePath = uniqId() . 'eresep-laporan.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(500)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					// Proses TTE
					$tte = tte_visible_koordinat($filePath, $request->nik_hidden, $request->passphrase, "##", $qrCodePath);

					log_esign($reg->id, $tte->response, "eresep-farmasi", $tte->httpStatusCode);

					if ($tte->httpStatusCode == 200) {
						$resep_note->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$resep_note->update();
						$successtte = true;
					}
				} else {
					session()->forget('idpenjualan');
					session()->forget('penjualanid');
					session()->forget('next_resep');
					DB::commit();
					Cart::destroy();
					return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
				}
			} else {
				session()->forget('idpenjualan');
				session()->forget('penjualanid');
				session()->forget('next_resep');
				DB::commit();
				Cart::destroy();
				return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
			}

			if ($successtte) {
				// update E Resep
				if (!empty($request->resep_uuid)) {
					@$resep = ResepNote::where('uuid', $request->resep_uuid)->first();
					if (isset($resep)) {
						@$dt_resep = [
							"no_resep" => @$pj->no_resep,
							"status" => 'selesai',
							"proses" => 'selesai',
							"comment" => @$request->ket_resep
						];
						@$resep->update($dt_resep);
					}
				}
				session()->forget('idpenjualan');
				session()->forget('penjualanid');
				session()->forget('next_resep');
				DB::commit();
				Cart::destroy();
				return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
			}
			DB::rollback();
			if ($tte) {
				log_esign($reg->id, $tte->response, "eresep-farmasi", $tte->httpStatusCode);
			}
			return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json([
				'sukses' => false,
				'id' => $pj->id,
				'jenis' => $jenis,
				'tte' => $proses_tte,
				'sukses_tte' => $successtte,
				'message' => $e,
			]);
		}
	}






	public function saveTotalBaruIbs(Request $request)
	{
		//dd("test");
		$jasa_racik   	= rupiah($request['jasa_racik']);
		$penjualan_id 	= $request['penjualan_id'];
		$cara_bayar		= $request['cara_bayar'];
		$pembuat_resep = $request['pembuat_resep'];

		// Update waktu
		$reg = Registrasi::find($request['reg_id']);
		if ($reg->nomorantrian) {

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

			if (status_consid(6)) {
				$updatewaktu   = '{
					"kodebooking": "' . $reg->nomorantrian . '",
					"taskid": "6",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($session2);
				$sml2 = json_decode($resp, true);
			}


			if (status_consid(7)) {

				// UPDATE TASK ID 7
				$updatewaktu2   = '{
					"kodebooking": "' . $reg->nomorantrian . '",
					"taskid": "7",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session3 = curl_init($completeurl);
				curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
				curl_setopt($session3, CURLOPT_POST, TRUE);
				curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
				$response3 = curl_exec($session3);
				$sml3 = json_decode($response3, true);

				if ($sml3['metadata']['code'] == '200' || $sml3['metadata']['code'] == '208') {
					$reg = RegistrasiDummy::where('nomorantrian', $reg->nomorantrian)->first();
					if ($reg) {
						$reg->taskid = 7;
						$reg->status = 'dilayani';
						$reg->save();
					}
					// dd($reg);

				}
			}
			// else{
			// 	return response()->json(['sukses' => true, 'message' => $resp['metadata']['message'], 'jenis' =>'']);
			// }
		}
		// return $request; $die;
		DB::transaction(function () use ($penjualan_id, $jasa_racik, $cara_bayar, $pembuat_resep, $request) {
			$total = 0;
			$pj = Penjualan::find($penjualan_id);
			$pj->pembuat_resep = $pembuat_resep;
			$pj->update();

			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$tipe_rawat = 'TI';
			}

			$tipe['tipe_rawat'] = $tipe_rawat;
			Penjualandetail::where('penjualan_id', $penjualan_id)->update($tipe);

			$det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
				// if (Auth::user()->gudang_id == 2) {
				if ($d->logistik_batch_id) {
					$saldo_obat = LogistikBatch::find($d->logistik_batch_id);
					$saldo_obat->stok = ($saldo_obat->stok - ($d->jumlah + $d->jml_kronis));
					$saldo_obat->update();

					if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $saldo_obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
						$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $saldo_obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
					} else {
						$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
					}

					$stock = new \App\Logistik\LogistikStock();
					$stock->gudang_id = Auth::user()->gudang_id;
					$stock->supplier_id = null;
					$stock->masterobat_id = $saldo_obat->masterobat_id;
					$stock->logistik_batch_id = $saldo_obat->id;
					$stock->batch_no = $saldo_obat->nomorbatch;
					// $stock->expired_date = valid_date($saldo_obat->expireddate);
					$stock->expired_date = date("Y-m-d", strtotime($saldo_obat->expireddate));
					$stock->masuk = 0;
					$stock->periode_id = date('m');
					$stock->keluar = $d->jumlah + $d->jml_kronis;
					$stock->total = $total_stok - ($d->jumlah + $d->jml_kronis);
					$stock->keterangan = 'Penjualan ' . $pj->no_resep;
					$stock->save();
				}
				// }
			}
			$total;

			$reg = Registrasi::find($pj->registrasi_id);

			$fol = Folio::where('namatarif', $pj->no_resep)->where('registrasi_id', $reg->id)->first();
			if (!$fol) {
				$fol = new Folio();
			}
			$fol->total = $total;
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->cara_bayar_id = $cara_bayar;
			// $fol->total = $total;
			$fol->gudang_id = @Auth::user()->gudang_id;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = $jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
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

			// update E Resep
			if (!empty($request->resep_uuid)) {
				$resep = ResepNote::where('uuid', $request->resep_uuid)->first();
				if (isset($resep)) {
					$dt_resep = [
						"no_resep" => $pj->no_resep,
						"status" => 'selesai',
						"proses" => 'selesai',
						"comment" => $request->ket_resep
					];
					$resep->update($dt_resep);
				}
			}
		});
		$jenis = substr($request['tipe_rawat'], 0, 1);
		session()->forget('idpenjualan');
		session()->forget('next_resep');
		return response()->json(['sukses' => true, 'id' => $penjualan_id, 'jenis' => $jenis]);
	}







	// ERESEP
	// penjualan baru khusus eresep
	public function form_penjualan_baru_eresep(Request $request, $idpasien, $idreg, $ideresep = '', $idpenjualan = '')
	{
		//dd("test");
		//session()->forget('id');
		$resep_note = ResepNote::find($ideresep);
		//dd($resep_note->id);
		$data['id_resep'] = $resep_note->id;
		// dd($data['id_resep'] );
		$data['reg'] = Registrasi::find($idreg);
		// if($data['reg']->nomorantrian && $data['reg']->bayar == '1'){

		// 	$ID = config('app.consid_antrean');
		// 	date_default_timezone_set('Asia/Jakarta');
		// 	$t = time();
		// 	$dat = "$ID&$t";
		// 	$secretKey = config('app.secretkey_antrean');
		// 	$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
		// 	$completeurl = config('app.antrean_url_web_service')."antrean/updatewaktu";
		// 	$arrheader = array(
		// 		'X-cons-id: ' . $ID,
		// 		'X-timestamp: ' . $t,
		// 		'X-signature: ' . $signature,
		// 		'user_key:'. config('app.user_key_antrean'),
		// 		'Content-Type: application/json',
		// 	);

		// 	$updatewaktu   = '{
		// 		"kodebooking": "'.$data['reg']->nomorantrian.'",
		// 		"taskid": "5",
		// 		"waktu": "'.round(microtime(true) * 1000).'"
		// 	}';
		// 	$session2 = curl_init($completeurl);
		// 	curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
		// 	curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
		// 	curl_setopt($session2, CURLOPT_POST, TRUE);
		// 	curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
		// 	$resp = curl_exec($session2);

		// 	sleep(2);

		// 	// TASK ID 6
		// 	$updatewaktu6   = '{
		// 		"kodebooking": "'.$data['reg']->nomorantrian.'",
		// 		"taskid": "6",
		// 		"waktu": "'.round(microtime(true) * 1000).'"
		// 	}';
		// 	$session6 = curl_init($completeurl);
		// 	curl_setopt($session6, CURLOPT_HTTPHEADER, $arrheader);
		// 	curl_setopt($session6, CURLOPT_POSTFIELDS, $updatewaktu6);
		// 	curl_setopt($session6, CURLOPT_POST, TRUE);
		// 	curl_setopt($session6, CURLOPT_RETURNTRANSFER, TRUE);
		// 	$resp6 = curl_exec($session6);
		// 	// $sml6 = json_decode($resp, true);

		// }

		// dd($resep_note);
		session(['jenis' => $data['reg']->bayar]);
		$data['resep'] = ResepNote::with('resep_detail.logistik_batch.master_obat')->where('uuid', $resep_note->uuid)->where('registrasi_id', $idreg)->first();
		$data['Totresep'] = ResepNote::join('resep_note_detail', 'resep_note.id', '=', 'resep_note_detail.resep_note_id')
			->join('logistik_batches', 'resep_note_detail.logistik_batch_id', '=', 'logistik_batches.id')
			->select(DB::raw('sum(logistik_batches.hargajual_umum * resep_note_detail.qty) as total'), 'resep_note_detail.id_medication_request as id_medication_request', 'resep_note_detail.kronis as kronis')
			->where('resep_note.uuid', $resep_note->uuid)
			->where('resep_note.registrasi_id', $idreg)
			->first();
		if ($data['Totresep']) {
			$data['tot_sementara'] = $data['Totresep']->total;
			$data['idMedicReq'] = $data['Totresep']->id_medication_request;
		} else {
			$data['idMedicReq'] = $data['Totresep']->id_medication_request;
			$data['tot_sementara'] = '';
		}
		// dd($data['Totresep']);
		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$penjualan_id = session('penjualanid') ? session('penjualanid') : $idpenjualan;

		if (!empty($idpenjualan)) {
			$penjualans = Penjualan::find($idpenjualan);
			$next_res = $penjualans->no_resep;
		} else {
			$next_res = session('next_resep');
		}
		// dd($next_res);

		// $next_res = session('next_resep');
		$data['pasien'] = Pasien::find($idpasien);
		// cek jika tidak ada pasien maka cek registrasi id
		if (!$data['pasien']) {
			$reg = Registrasi::find($idpasien);
			$data['pasien'] = Pasien::find($reg->pasien_id);
		}
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['detail'] = Penjualandetail::where('no_resep', '=', $next_res)->get();
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['penjualanid'] = $penjualan_id;
		$data['next_resep'] = $next_res;
		// dd($data);

		// $resepnot = ResepNote::find($ideresep);
		// 	if($resepnot){
		// 		$resepnot->proses = 'diproses';
		// 		$resepnot->save();
		// 	}

		return view('penjualan.penjualan-baru.form_penjualan_eresep', $data)->with('idreg', $idreg);
	}
	public function validasiEresep(Request $request)
	{
		// dd(implode(",", $request->resep_detail['37098']['catatan']));

		$idpasien = $request->idpasien;
		$idreg    = $request->idreg;
		$ideresep = $request->ideresep;
		// dd($request->all());
		// $resepnot = ResepNote::find($ideresep);
		// 	if($resepnot){
		// 		$resepnot->proses = 'selesai';
		// 		$resepnot->save();
		// 	}

		DB::beginTransaction();
		try {
			session()->forget('next_resep');
			session()->forget('penjualanid');
			if (!session('next_resep')) {

				$jenis = Registrasi::find($idreg)->status_reg;
				$reg = Registrasi::find($idreg);
				if (substr($jenis, 0, 1) == 'J') {
					$count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
					$next_resep = 'FRJ' . date('YmdHis');
				} elseif (substr($jenis, 0, 1) == 'I') {
					$count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
					$next_resep = 'FRI' . date('YmdHis');
				} elseif (substr($jenis, 0, 1) == 'G') {
					$count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
					$next_resep = 'FRD' . date('YmdHis');
				}

				//Save Penjualan
				$p = new Penjualan();
				$p->no_resep = $next_resep;
				$p->user_id = Auth::user()->id;
				$p->registrasi_id = $idreg;
				$p->dokter_id = $reg->dokter_id;
				// $p->created_at = valid_date($request['created_at']);
				$p->save();
				session(['penjualanid' => $p->id]);
				session(['next_resep' => $next_resep]);
			}

			$resepnot = ResepNote::find($ideresep);
			if ($resepnot) {
				$resepnot->proses = 'diproses';
				$resepnot->status = 'diproses';
				$resepnot->penjualan_id = $p->id;
				$resepnot->is_validate = '1';
				$resepnot->notif_play = '0';
				$resepnot->no_resep = $p->no_resep;
				$resepnot->save();
			}

			foreach ($request['resep_detail'] as $d) {
				$caraminum   = @$d['cara_minum'];
				$Uangracik   = UangRacik::find($d['uang_racik']);
				$logistik_batch_id = $d['logistik_batch_id'];

				$obat_batch = LogistikBatch::where('id', $logistik_batch_id)->first();
				$id_medication_dep = '';

				// Validasi obat kronis atau bukan
				if ($d['kronis'] == 'N') {
					$details = new Penjualandetail();
					$details->penjualan_id = @$p->id;
					$details->no_resep = @$p->no_resep;
					$details->is_kronis = @$d['kronis'];
					$details->catatan = json_encode(@$d['catatan']);
					$details->masterobat_id = $obat_batch->masterobat_id;
					$details->logistik_batch_id = @$obat_batch->id;
					$details->jumlah = $d['qty'];
					$details->jml_kronis = $d['qty'];
					$details->id_medication_dep = @$id_medication_dep;
					$details->obat_racikan = @$d['obat_racikan'];
					// $details->cara_minum_id = @$minum_id;
					$details->cara_minum = @$caraminum;
					$details->informasi1 =  $d['informasi'];
					// $details->informasi2 =  implode(",", @$d['catatan']);

					if (cek_jenispasien($idreg) == '1') {
						$harga = LogistikBatch::select('hargajual_jkn')->where('id', $logistik_batch_id)->first()->hargajual_jkn;
					} else {
						$harga = LogistikBatch::select('hargajual_umum')->where('id', $logistik_batch_id)->first()->hargajual_umum;
					}
					// if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
					// 	$harga = rupiah($request['racikan']);
					// }
					$details->uang_racik    = rupiah(@$Uangracik->nominal);
					$details->uang_racik_id = @$d['uang_racik'];
					$details->hargajual = $harga * $d['qty'];

					$details->expired = $obat_batch->expireddate;
					$details->takaran	= $d['takaran'];
					$details->etiket = @$d['tiket'];
					// $details->cetak  = $d['cetak'];
					$details->save();
				} else {
					/**
					 * Jika obat Kronis, maka hitung rumus
					 * Pemakaian obat full adalah 30 
					 * Pemakaian obat 1/2 adalah 15
					 * Pemakaian obat 1/4 adalah 8
					 * 
					 * Obat full (30) | 23 untuk kronis & 7 untuk non kronis
					 * Obat 1/2 (15) | 15/30= 0.5 0.5*7=3.5 -> pembulatan keatas jadi 4 untuk non kronis & 15-4 = 11 untuk kronis
					 * Obat 1/4 (8)  | 8/30=0.26 0.26*7= 1.82 -> pembulatan keatas jadi 2 untuk non kronis & 8-2 = 6 untuk kronis
					 */

					$jml_obat = $d['qty'];
					$ds = intval($jml_obat / 30);
					$sisa = $jml_obat % 30;
					if ($sisa == 0 || $sisa == 15 || $sisa == 8) {
						$jml_obat_kronis = $ds * 23;
						$jml_obat_non_kronis = $ds * 7;

						if ($sisa == 15) {
							$jml_obat_kronis += 11;
							$jml_obat_non_kronis += 4;
						}

						if ($sisa == 8) {
							$jml_obat_kronis += 6;
							$jml_obat_non_kronis += 2;
						}

						// Insert Kronis
						$details2 = new Penjualandetail();
						$details2->penjualan_id = @$p->id;
						$details2->no_resep = @$p->no_resep;
						$details2->is_kronis = 'Y';
						$details2->catatan = json_encode(@$d['catatan']);
						$details2->masterobat_id = $obat_batch->masterobat_id;
						$details2->logistik_batch_id = @$obat_batch->id;
						$details2->jumlah = $jml_obat_kronis;
						$details2->id_medication_dep = @$id_medication_dep;
						$details2->obat_racikan = @$d['obat_racikan'];
						$details2->cara_minum = @$caraminum;
						$details2->informasi1 =  $d['informasi'];

						if (cek_jenispasien($idreg) == '1') {
							$harga = LogistikBatch::select('hargajual_jkn')->where('id', $logistik_batch_id)->first()->hargajual_jkn;
						} else {
							$harga = LogistikBatch::select('hargajual_umum')->where('id', $logistik_batch_id)->first()->hargajual_umum;
						}

						$details2->uang_racik    = rupiah(@$Uangracik->nominal);
						$details2->uang_racik_id = @$d['uang_racik'];
						$details2->hargajual = $harga * $jml_obat_kronis;

						$details2->expired = $obat_batch->expireddate;
						$details2->takaran	= $d['takaran'];
						$details2->etiket = @$d['tiket'];
						$details2->save();

						// Insert Non Kronis
						$details2 = new Penjualandetail();
						$details2->penjualan_id = @$p->id;
						$details2->no_resep = @$p->no_resep;
						$details2->is_kronis = 'N';
						$details2->catatan = json_encode(@$d['catatan']);
						$details2->masterobat_id = $obat_batch->masterobat_id;
						$details2->logistik_batch_id = @$obat_batch->id;
						$details2->jumlah = $jml_obat_non_kronis;
						$details2->id_medication_dep = @$id_medication_dep;
						$details2->obat_racikan = @$d['obat_racikan'];
						$details2->cara_minum = @$caraminum;
						$details2->informasi1 =  $d['informasi'];

						if (cek_jenispasien($idreg) == '1') {
							$harga = LogistikBatch::select('hargajual_jkn')->where('id', $logistik_batch_id)->first()->hargajual_jkn;
						} else {
							$harga = LogistikBatch::select('hargajual_umum')->where('id', $logistik_batch_id)->first()->hargajual_umum;
						}

						$details2->uang_racik    = rupiah(@$Uangracik->nominal);
						$details2->uang_racik_id = @$d['uang_racik'];
						$details2->hargajual = $harga * $jml_obat_non_kronis;

						$details2->expired = $obat_batch->expireddate;
						$details2->takaran	= $d['takaran'];
						$details2->etiket = @$d['tiket'];
						$details2->save();
					} else {
						DB::rollback();
						Flashy::error('Obat kronis hanya bisa ditambah untuk pemakaian penuh, 1/2, ataupun 1/4');
						return redirect()->back();
					}
				}
			}
			DB::commit();
			Flashy::success('Berhasil Validasi Eresep');
			// return redirect()->back();
			return redirect('/penjualan/form-penjualan-baru-eresep/' . $idpasien . '/' . $idreg . '/' . $ideresep . '/' . session('penjualanid'));
		} catch (Exception $e) {
			DB::rollback();

			Flashy::error('Gagal Validasi Eresep, Hubungi TS');
			return redirect()->back();
		}
	}

	public function deleteDetailBaru($id, $idpasien, $idreg, $penjualan_id, $ideresep = null)
	{
		Penjualandetail::find($id)->delete();
		Flashy::success('Berhasil Hapus Detail Obat');
		if ($ideresep) {
			return redirect('penjualan/form-penjualan-baru-eresep/' . $idpasien . '/' . $idreg . '/' . $ideresep . '/' . $penjualan_id);
		}
		return redirect('penjualan/form-penjualan-baru/' . $idpasien . '/' . $idreg . '/' . $penjualan_id);
	}

	public function deleteDetailBaruValidasi($idnotedetail, $idreg, $idnote)
	{
		//dd($idpasien,$idreg,$idnote);
		//ResepNote::with('resep_detail.logistik_batch.master_obat')->where('uuid',$resep_note->uuid)->first();
		//ResepNote::find($idnote)->delete();
		//	ResepNoteDetail::find($idnotedetail)->delete();
		Flashy::success('Berhasil Hapus');

		return redirect('penjualan/form-penjualan-baru-eresep/' . $idnotedetail . '/' . $idreg . '/' . $idnote);
	}

	public function batalEresep($unit, $id)
	{
		$d = ResepNote::find($id);
		$d->proses = 'dibatalkan';
		$d->status = 'dibatalkan';
		$d->save();
		Flashy::success('Data Eresep Berhasil DIbatalkan !');
		return redirect('farmasi/lcd-eresep/' . $unit);
	}
	public function viewEresep($id)
	{
		$data['resep'] = ResepNote::find($id);
		$data['reg'] = Registrasi::find($data['resep']->registrasi_id);
		$data['resep_detail'] = ResepNoteDetail::where('resep_note_id', $id)->get();

		return view('penjualan.view-eresep', $data);
	}

	public function historyBaru($registrasi_id)
	{
		$penjualan = Penjualan::with([
			'penjualandetail.masterobat' => function ($query) {
				$query->select('id', 'hargajual', 'nama');
			},
			'penjualandetail' => function ($query) {
				$query->groupBy('masterobat_id')
					->groupBy('created_at')
					->select(
						'*',
						DB::raw('SUM(jumlah) as jumlahTotal'),
						DB::raw('SUM(hargajual) as jumlahHarga'),
						DB::raw('SUM(retur_inacbg) as totalReturIna')
					);
			},
		])
		->where('registrasi_id', $registrasi_id)->where('user_id', '<>', 610)->orderBy('id', 'DESC')->get();
		$reg = Registrasi::where('id', $registrasi_id)->first();
		$registrasis = Registrasi::where('pasien_id', $reg->pasien_id)->orderBy('id', "DESC")->get(['id', 'poli_id', 'created_at']);
		return view('penjualan.penjualan-baru.history', compact('penjualan', 'reg', 'registrasis'));
	}


	public function historyBaruFilter($registrasi_id, $id_penjualan)
	{
		// dd($registrasi_id, $id_penjualan);
		$penjualan = Penjualan::where('id', $id_penjualan)->get();
		$reg = Registrasi::where('id', $registrasi_id)->first();
		$registrasis = Registrasi::where('pasien_id', $reg->pasien_id)->orderBy('id', "DESC")->limit(10)->get(['id', 'poli_id', 'created_at']);
		// dd($penjualan);
		return view('penjualan.penjualan-baru.history', compact('penjualan', 'reg', 'registrasis'));
	}

	public function historyBaruObat($registrasi_id)
	{
		$penjualan = Penjualan::with([
			'penjualandetail' => function ($query) {
				$query->groupBy('masterobat_id')->groupBy('created_at')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as jumlahHarga'));
			},
		])->where('registrasi_id', $registrasi_id)->where('user_id', '<>', 610)->orderBy('id', 'DESC')->get();
		$reg = Registrasi::where('id', $registrasi_id)->first();
		$registrasis = Registrasi::where('pasien_id', $reg->pasien_id)->orderBy('id', "DESC")->get(['id', 'poli_id', 'created_at']);
		return view('penjualan.penjualan-baru.history-obat', compact('penjualan', 'reg', 'registrasis'));
	}


	public function historyBaruObatFilter($registrasi_id, $id_penjualan)
	{
		// dd($registrasi_id, $id_penjualan);
		$penjualan = Penjualan::where('id', $id_penjualan)->get();
		$reg = Registrasi::where('id', $registrasi_id)->first();
		$registrasis = Registrasi::where('pasien_id', $reg->pasien_id)->orderBy('id', "DESC")->limit(10)->get(['id', 'poli_id', 'created_at']);
		// dd($penjualan);
		return view('penjualan.penjualan-baru.history-obat', compact('penjualan', 'reg', 'registrasis'));
	}


	public function historyBaruByIdPasien($pasien_id)
	{
		$re = Registrasi::where('pasien_id', $pasien_id)->limit(10)->get();

		$idregs = [];
		foreach ($re as $r) {
			$idregs[] = $r->id;
		}
		$penjualan = Penjualan::whereIn('registrasi_id', $idregs)->orderBy('id', 'DESC')->limit(10)->get();

		// dd($idreg);
		// if(count($penjualan) == '0'){
		// 	$reg = Registrasi::find($registrasi_id);
		// 	$idreg = [];
		// 	$resep_note = ResepNote::where('pasien_id',$reg->pasien_id)->get();
		// 	foreach($resep_note as $r){
		// 		$idreg[] = $r->registrasi_id;
		// 	}

		// 	$penjualan = Penjualan::whereIn('registrasi_id',$idreg)->get();

		// 	if(count($penjualan) == '0'){ //cek jika tidak ada data resep_note

		// 		$re = Registrasi::where('pasien_id',$reg->pasien_id)->get();
		// 		$idregs = [];
		// 		foreach($re as $r){
		// 			$idregs[] = $r->id;
		// 		}
		// 		$penjualan = Penjualan::whereIn('registrasi_id',$idregs)->orderBy('id','DESC')->limit(10)->get();
		// 	}
		// }
		return view('penjualan.penjualan-baru.history_tanpa_filter', compact('penjualan'));
	}


	public function cetakEresepManual(Request $request)
	{

		$idpenjualan = [];
		if ($request->penjualandetail_id != null)
			foreach ($request->penjualandetail_id as $r) {
				$idpenjualan[] = $r;
			}
		else {
			return redirect()->back();
		}
		$data['det'] = Penjualandetail::whereIn('id', $idpenjualan)->get()->map(function ($penjualandetail) {
			$arr = $penjualandetail;
			$penjualanall = Penjualandetail::where('penjualan_id', $penjualandetail->penjualan_id)->where('masterobat_id', $penjualandetail->masterobat_id)->get();
			$jumlahTotal = $penjualanall->sum('jumlah');
			$jumlahHarga = $penjualanall->sum('hargajual');
			$arr['jumlahTotal'] = $jumlahTotal;
			$arr['jumlahHarga'] = $jumlahHarga;
			return (object) $arr;
		});

		$data['penjualan'] = Penjualan::where('id', $request->penjualan_id)->first();
		return view('farmasi.laporan.etiket-pdf-baru-manual', $data);
	}
	//PENJUALAN BEBAS BARU

	public function penjualanBebasBaru()
	{
		session()->forget('idpenjualan');
		// $data['barang'] = LogistikBatch::all();
		$data['barang'] = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->where('stok', '!=', 0)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')->get();


		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['today'] = Penjualanbebas::join('registrasis', 'penjualanbebas.registrasi_id', '=', 'registrasis.id')
			->where('penjualanbebas.created_at', 'like', date('Y-m-d') . '%')
			->select('registrasis.id', 'penjualanbebas.*')->get();
		return view('penjualan.penjualan-baru.penjualanBebas', $data)->with('no', 1);
	}

	public function penjualanBebasBaruBytanggal(Request $request)
	{
		session()->forget('idpenjualan');
		$data['barang'] = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->where('stok', '!=', 0)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')->get();
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['today'] = Penjualanbebas::join('registrasis', 'penjualanbebas.registrasi_id', '=', 'registrasis.id')
			->where('penjualanbebas.created_at', 'like', valid_date($request['tga']) . '%')
			->select('registrasis.id', 'registrasis.lunas', 'penjualanbebas.*')
			->get();
		return view('penjualan.penjualan-baru.penjualanBebas', $data)->with('no', 1);
	}

	public function hapusPenjualanBebasBaru($registrasi_id)
	{
		$detail = Penjualanbebas::where('registrasi_id', $registrasi_id);
		$detail->delete();

		$reg = Registrasi::find($registrasi_id);
		$reg->delete();

		$folio = Folio::where('registrasi_id', $registrasi_id);
		$folio->delete();

		$tagihan = Tagihan::where('registrasi_id', $registrasi_id);
		$tagihan->delete();

		return back();
	}

	public function save_penjualan_bebas_baru(Request $request)
	{

		// $tanggal = date('Y-m-d H:i:s',strtotime($request->tanggal));

		request()->validate(['nama' => 'required', 'alamat' => 'required']);
		// sleep(5);
		$count = Penjualan::where('no_resep', 'LIKE', 'FPB' . date('Ymd') . '%')->count() + 1;
		$next_resep = 'FPB' . date('Ymd') . '-' . sprintf('%04s', $count);
		// DB::transaction(function () use ($request, $next_resep) {

		// $no = Nomorrm::count() + config('app.no_rm');
		// $no_rm = $no;
		// $cek = Pasien::where('no_rm', $no_rm)->count();
		// if ($cek > 0) {
		// 	Flashy::info('No RM baru (' . $no_rm . ') sdh ada, hubungi Admin!');
		// 	return back();
		// }



		$pasien_new = new Pasien();
		$pasien_new->nama = strtoupper($request['nama']);
		$pasien_new->nik = $request['nik'];
		$pasien_new->tgllahir = @$request['tgl_lahir'] ? @valid_date(@$request['tgl_lahir']) : '';
		$pasien_new->kelamin = @$request['kelamin'];
		// $pasien_new->no_rm = sprintf("%06s", $no_rm);
		$pasien_new->alamat = strtoupper($request['alamat']);
		$pasien_new->tgldaftar = date("Y-m-d");
		$pasien_new->rt = $request['rt'];
		$pasien_new->rw = $request['rw'];
		$pasien_new->nohp = $request['nohp'];
		$pasien_new->negara = 'Indonesia';
		$pasien_new->no_jkn = $request['no_jkn'];
		$pasien_new->user_create = Auth::user()->name;
		$pasien_new->user_update = '';
		$pasien_new->save();

		// Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => $no_rm]);
		$rms = Nomorrm::create(['pasien_id' => $pasien_new->id, 'no_rm' => Nomorrm::count() + config('app.no_rm')]);

		// UPDATEPASIEN
		$pasi = Pasien::where('id', $pasien_new->id)->first();
		$pasi->no_rm = $rms->id;
		$pasi->save();

		$tanggal = date('Y-m-d', strtotime($request['tanggal'])) . ' ' . date('H:i:s');
		// Save registrasi
		$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
		$reg = new Registrasi();
		$reg->pasien_id = $pasien_new->id;
		$reg->status_reg = 'A1'; //status registrasi apotik
		$reg->tracer = '1';
		$reg->cetak_barcode = '1';
		$reg->cetak_sep = '1';
		$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
		$reg->user_create = Auth::user()->id;
		$reg->created_at = $tanggal;
		$reg->save();






		$pb = new Penjualanbebas();
		$pb->registrasi_id = $reg->id;
		$pb->nama =  $pasien_new->nama;
		$pb->alamat =  $pasien_new->alamat;
		// $pb->dokter = !empty($request['dokter']) ? $request['dokter'] : ' ';
		$pb->dokter_id = !empty($request['dokter_id']) ? $request['dokter_id'] : ' ';
		$pb->created_at = date('Y-m-d H:i:s');
		$pb->save();

		$p = new Penjualan();
		$p->no_resep = $next_resep;
		$p->pembuat_resep = $request['pembuat_resep'];
		$p->user_id = Auth::user()->id;
		$p->registrasi_id = $reg->id;
		$p->created_at = date('Y-m-d H:i:s');
		if (!empty($reg->id)) {
			$p->save();
		}
		if ($p) {
			session(['idpenjualan' => $p->id, 'reg_id' => $reg->id]);
		}

		DB::commit();
		$cek_rmss = Nomorrm::where('pasien_id', $pasien_new->id)->orderBy('id', 'DESC')->first();
		// dd($cek_rmss);

		if ($cek_rmss) {
			if ($pasien_new->no_rm !== $cek_rmss->id) {
				// dd("BB");
				$up_pas = Pasien::where('id', $pasien_new->id)->first();
				$up_pas->no_rm = $cek_rmss->id;
				$up_pas->save();
			} else {
				// dd("CCC");
			}
		}

		// $d = new Penjualandetail();
		// $d->penjualan_id = $p->id;
		// $d->no_resep = $p->no_resep;
		// $d->masterobat_id = config('app.obatRacikan_id'); //'3427';
		// $d->jumlah = 1;

		// $harga = Masterobat::select('hargajual')->where('id', config('app.obatRacikan_id'))->first()->hargajual;

		// $d->hargajual = $harga * 1;
		// $d->etiket = '';
		// $d->cetak = 'N';
		// $d->save();

		// });
		return redirect('penjualan/formpenjualanbebasbaru/0/' . session('reg_id') . '/' . session('idpenjualan'));
	}

	public function editPenjualanBebasBaru($idreg, $penjualan_id = '')
	{
		session(['idpenjualan' => $penjualan_id, 'reg_id' => $idreg]);
		return redirect('penjualan/formpenjualanbebasbaru/0/' . session('reg_id') . '/' . session('idpenjualan'));
	}

	public function form_penjualan_bebas_baru($idpasien, $idreg, $penjualan_id = '')
	{
		$data['barang'] = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->where('stok', '!=', 0)->get();
		$data['reg'] = Registrasi::find($idreg);
		$data['pasien'] = Pasien::find($idpasien);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		if ($penjualan_id) {
			$data['penjualan'] = Penjualan::find($penjualan_id);
			$data['detail'] = Penjualandetail::where('penjualan_id', '=', $penjualan_id)->get();
			$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
			$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
			$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
			$data['penj_bebas'] = PenjualanBebas::where('registrasi_id', $idreg)->first();
			$data['no'] = 1;
		}
		return view('penjualan.penjualan-baru.form_penjualan_bebas', $data)->with('idreg', $idreg);
	}

	public function save_detail_bebas_baru(Request $request)
	{
		// return $request; die;
		request()->validate(['masterobat_id' => 'required', 'uang_racik' => 'required']);
		$obat_batch = LogistikBatch::find($request['masterobat_id']);
		$d = new Penjualandetail();
		$d->penjualan_id = $request['penjualan_id'];
		$d->no_resep = $request['no_resep'];
		$d->masterobat_id = $obat_batch->masterobat_id;
		$d->logistik_batch_id = $obat_batch->id;
		$d->jumlah = $request['jumlah'];
		$d->cara_minum_id = $request['cara_minum_id'];
		$d->informasi1 =  $request['informasi1'];
		if (cek_jenispasien($request['idreg']) == '1') {
			$harga = LogistikBatch::select('hargajual_jkn')->where('id', $request['masterobat_id'])->first()->hargajual_jkn;
		} else {
			$harga = LogistikBatch::select('hargajual_umum')->where('id', $request['masterobat_id'])->first()->hargajual_umum;
		}

		if ($request['masterobat_id'] == config('app.obatRacikan_id')) {
			$harga = rupiah($request['racikan']);
		}
		$Uangracik     = UangRacik::find($request['uang_racik']);
		$d->uang_racik = rupiah($Uangracik->nominal);
		$d->uang_racik_id = $request['uang_racik'];
		$d->hargajual = $harga * $request['jumlah'];
		$d->expired = $request['expired'];
		$d->takaran	= $request['takaran'];
		$d->etiket = $request['tiket'];
		$d->cetak = $request['cetak'];
		$d->save();
		return redirect('penjualan/formpenjualanbebasbaru/' . $request['pasien_id'] . '/' . $request['idreg'] . '/' . $request['penjualan_id']);
	}

	public function deleteDetailBebasBaru($id, $idpasien, $idreg, $penjualan_id)
	{
		Penjualandetail::find($id)->delete();
		return redirect('penjualan/formpenjualanbebasbaru/' . $idpasien . '/' . $idreg . '/' . $penjualan_id);
	}

	public function save_totalpenjualan_bebas_baru(Request $request)
	{
		// return $request; $die;
		$jasa_racik   = rupiah($request['jasa_racik']);
		$penjualan_id = $request['id_penjualan'];
		DB::transaction(function () use ($penjualan_id, $jasa_racik, $request) {
			$total = 0;

			if ($request['diskon'] == null) {
				$diskon = 0;
			} else {
				$diskon = $request['diskon'];
			}


			// dd($diskon);
			$det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual - ($d->hargajual * ($diskon / 100));
				// $hargaReal = $harga - ($harga * ($diskon/100));
				// if (Auth::user()->gudang_id == 2) {
				// 	$saldo_obat = Masterobat::find($d->masterobat_id);
				// 	$saldo_obat->saldo = ($saldo_obat->saldo - $d->jumlah);
				// 	$saldo_obat->update();
				// }
				// if (Auth::user()->gudang_id == 2) {
				$saldo_obat = LogistikBatch::find($d->logistik_batch_id);
				$saldo_obat->stok = $saldo_obat->stok - $d->jumlah;
				$saldo_obat->update();
				// }
				if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $saldo_obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
					$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $saldo_obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
				} else {
					$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
				}
				$pj = Penjualan::find($penjualan_id);
				$stock = new \App\Logistik\LogistikStock();
				$stock->gudang_id = Auth::user()->gudang_id;
				$stock->supplier_id = null;
				$stock->masterobat_id = $saldo_obat->masterobat_id;
				$stock->logistik_batch_id = $saldo_obat->id;
				$stock->batch_no = $saldo_obat->nomorbatch;
				$stock->expired_date = date("Y-m-d", strtotime($saldo_obat->expireddate));
				// $stock->expired_date = !empty($saldo_obat->expireddate) ? $saldo_obat->expireddate : '';
				$stock->masuk = 0;
				$stock->periode_id = date('m');
				$stock->keluar = $d->jumlah;
				$stock->total = $total_stok - $d->jumlah;
				$stock->keterangan = 'Penjualan Bebas' . $pj->no_resep;
				$stock->save();
			}
			$total;

			$pj = Penjualan::find($penjualan_id);
			$reg = Registrasi::find(Penjualan::find($penjualan_id)->registrasi_id);

			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->total = $total;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = $jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
			$fol->gudang_id = @Auth::user()->gudang_id;
			$fol->diskon = $diskon;
			$fol->pasien_id = $reg->pasien_id;
			$fol->dokter_id = $reg->dokter_id;
			$fol->poli_id = $reg->poli_id;
			$fol->user_id = Auth::user()->id;
			$fol->save();

			// Insert ke Tagihan

			// dd($total-$diskon);
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = 1; //$reg->dokter_id;
			$tag->diskon = $diskon;
			$tag->pasien_id = 0;
			$tag->total = $total;
			$tag->harus_dibayar = $total;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			DB::commit();
		});
		return redirect('farmasi/cetak-detail-bebas-baru/' . $penjualan_id);
	}

	// HAPUS FAKTUR BARU DENGAN BACTH KEMBALIKAN STOK
	public function hapus_faktur_baru(Request $request, $no_resep)
	{
		// return $request->all(); die;
		$cek_penjualan = Penjualan::where('no_resep', $no_resep)->first();
		$penjualan_id = $cek_penjualan->id;
		DB::transaction(function () use ($penjualan_id) {
			$total = 0;
			$detail = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
			foreach ($detail as $key => $d) {
				$total = $d->hargajual;

				$saldo_obat = LogistikBatch::find($d->logistik_batch_id);
				$saldo_obat->stok = $saldo_obat->stok + ($d->jumlah + $d->jml_kronis);
				$saldo_obat->update();

				if (!empty(\App\Logistik\LogistikStock::where('masterobat_id', $saldo_obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total)) {
					$total_stok = \App\Logistik\LogistikStock::where('masterobat_id', $saldo_obat->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
				} else {
					$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
				}
				$stock = new \App\Logistik\LogistikStock();
				$stock->gudang_id = 2;
				$stock->user_id = Auth::user()->id;
				$stock->supplier_id = null;
				$stock->masterobat_id = $d->masterobat_id;
				$stock->logistik_batch_id = $d->logistik_batch_id;
				$stock->batch_no = $saldo_obat->nomorbatch;
				$stock->expired_date = date("Y-m-d", strtotime($saldo_obat->expireddate));
				// $stock->expired_date = !empty($saldo_obat->expireddate) ? $saldo_obat->expireddate : '';
				$stock->periode_id = date('m');
				$stock->keluar = 0;
				$stock->masuk = ($d->jumlah + $d->jml_kronis);
				$stock->total = $total_stok + ($d->jumlah + $d->jml_kronis);
				$stock->keterangan = 'Hapus Penjulan' . ' ' . $d->no_resep;
				$stock->save();
			}
			// $pj = Penjualan::where('id', $penjualan_id)->first();
			// return $pj;die;

			$detail_penjualan = Penjualan::find($penjualan_id);
			if (Folio::where('namatarif', $detail_penjualan->no_resep)->first()) {
				$detail_folio = Folio::where('namatarif', $detail_penjualan->no_resep)->first();
			} else {
				$detail_folio = NULL;
			}

			if (Folio::where('namatarif', $detail_penjualan->no_resep)->first()) {
				$totalfolio = Folio::where('namatarif', $detail_penjualan->no_resep)->first()->total;
			} else {
				$totalfolio = NULL;
			}

			$detail_detailpenjualan = Penjualandetail::where('no_resep', $detail_penjualan->no_resep)->get();
			$totaldetail = Penjualandetail::where('no_resep', $detail_penjualan->no_resep)->sum('hargajual');
			$totalracik = Penjualandetail::where('no_resep', $detail_penjualan->no_resep)->sum('uang_racik');

			$histori = new historiHapusFaktur();
			$histori->penjualandetail = $detail_detailpenjualan;
			$histori->penjualan = $detail_penjualan;
			$histori->folio = $detail_folio;
			$histori->total_folio = $totalfolio;
			$histori->total_faktur = $totaldetail;
			$histori->total_uang_racik = $totalracik;
			$histori->no_faktur = $detail_penjualan->no_resep;
			$histori->save();

			$hapus_folio = Folio::where('namatarif', $detail_penjualan->no_resep)->delete();
			$hapus_detailpenjulan = Penjualandetail::where('no_resep', $detail_penjualan->no_resep)->delete();
			$hapus_penjualan = Penjualan::where('no_resep', $detail_penjualan->no_resep)->delete();
		});
		Flashy::success('Data Penjualan Berhasil Dihapus !');
		return redirect()->back();
	}

	//UPDATE PENJUALAN OBAT
	public function detailPenjualanHapus($penjualan_id)
	{
		$p			= Penjualan::find($penjualan_id);
		$data		= Penjualandetail::where('penjualan_id', $penjualan_id)->get();
		$reg		= Registrasi::find($p->registrasi_id);
		$carabayar	= Carabayar::pluck('carabayar', 'id');
		$folio		= Folio::where('namatarif', $data[0]['no_resep'])->first();
		return view('penjualan.detailHapusPenjualan', compact('data', 'reg', 'folio', 'carabayar', 'p'))->with('no', 1);
	}

	//RETUR PENJUALAN BEBAS
	public function returBebas()
	{
		return view('penjualan.retur.bebas');
	}

	public function returBebasByRequest(Request $request)
	{
		request()->validate(['tga' => 'required']);
		session(['tanggal' => valid_date($request['tga'])]);
		return view('penjualan.retur.bebas');
	}

	public function dataReturBebasByRequest()
	{
		$tanggal = session('tanggal') ? session('tanggal') : date('Y-m-d');
		$data = Registrasi::where('pasien_id', '0')->where('created_at', 'LIKE', $tanggal . '%')->where('status_reg', 'A1')->orderBy('created_at', 'desc')->get();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('no_rm', function ($data) {
				return 'Penjualan Bebas';
			})
			->addColumn('nama', function ($data) {
				return \App\Penjualanbebas::where('registrasi_id', $data->id)->first()->nama;
			})
			->addColumn('alamat', function ($data) {
				return \App\Penjualanbebas::where('registrasi_id', $data->id)->first()->alamat;
			})
			->addColumn('poli', function ($data) {
				return '-';
			})
			->addColumn('tanggal', function ($data) {
				return $data->created_at->format('d-m-Y');
			})
			->addColumn('edit', function ($data) {
				return '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="retur(' . $data->id . ')" style="margin-bottom: 5px;">RETUR</button>';
			})
			->rawColumns(['edit'])
			->make(true);
	}

	public function edit_form_penjualan($unit, $idreg, $penjualan_id = '')
	{
		$data['unit']	= $unit;
		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);
		$data['pasien'] = Pasien::find($data['reg']->pasien->id);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['detail'] = Penjualandetail::where('penjualan_id', '=', $penjualan_id)->get();
		// dd($data['detail']);
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['uangracik'] = UangRacik::all();
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		return view('penjualan.edit_form_penjualan', $data)->with('idreg', $idreg);
	}



	public function edit_form_penjualan_ibs($idreg, $penjualan_id = '')
	{
		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);
		$data['pasien'] = Pasien::find($data['reg']->pasien->id);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['detail'] = Penjualandetail::where('penjualan_id', '=', $penjualan_id)->get();
		// dd($data['detail']);
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['uangracik'] = UangRacik::all();
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		return view('penjualan.edit_form_penjualan', $data)->with('idreg', $idreg);
	}



	public function editKronis($id, Request $request)
	{
		$kronis = Penjualandetail::find($id);
		$kronis->jml_kronis = $request->jml_kronis;
		$kronis->update();
		return response()->json(['sukses' => true]);
	}

	public function editJumlah($id, Request $request)
	{
		$penjualan = Penjualandetail::find($id);
		$hargaSatuan = $penjualan->hargajual / $penjualan->jumlah;
		$penjualan->hargajual = $hargaSatuan * $request->jumlah;
		$penjualan->jumlah = $request->jumlah;
		$penjualan->update();
		return response()->json(['sukses' => true]);
	}

	public function editStatusKronis($id, Request $request)
	{
		$penjualan = Penjualandetail::find($id);
		$penjualan->is_kronis = $request->kronis;
		$penjualan->update();
		return response()->json(['sukses' => true]);
	}

	public function tabResep($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.resep', $data);
	}
	public function tabObatFarmasi($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.obat_farmasi', $data);
	}
	public function tabCopyResep($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.copy_resep', $data);
	}
	public function tabFaktur($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.faktur', $data);
	}
	public function tabFnonkronis($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		$data['non_kronis'] = true;
		return view('penjualan.tab.faktur', $data);
	}
	public function tabFkronis($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.fkronis', $data);
	}
	public function tabInfus($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)
			->whereHas('penjualandetail.masterobat', function ($query) {
				$query->where('nama', 'like', '%infus%');
			})
			->orderBy('id', 'DESC')
			->get();
		return view('penjualan.tab.infus', $data);
	}
	public function tabEtiket($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.etiket', $data);
	}
	public function tabEtiket2($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.etiket2', $data);
	}
	public function tabEdit($id)
	{
		$data['reg'] = Registrasi::find($id);
		$data['penjualan'] = Penjualan::where('registrasi_id', $id)->orderBy('id', 'DESC')->get();
		return view('penjualan.tab.edit', $data);
	}

	public function form_penjualan_baru_cart(Request $request, $idpasien, $idreg, $penjualan_id = '')
	{

		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);
		if ($data['reg']->nomorantrian) {

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




			if (status_consid(5)) {
				$updatewaktu   = '{
						"kodebooking": "' . @$data['reg']->nomorantrian . '",
						"taskid": "5",
						"waktu": "' . round(microtime(true) * 1000) . '"
					}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($session2);
			}


			if (status_consid(6)) {
				// CONSID 6
				$updatewaktu6   = '{
						"kodebooking": "' . @$data['reg']->nomorantrian . '",
						"taskid": "6",
						"waktu": "' . round(microtime(true) * 1000) . '"
					}';
				$session6 = curl_init($completeurl);
				curl_setopt($session6, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session6, CURLOPT_POSTFIELDS, $updatewaktu6);
				curl_setopt($session6, CURLOPT_POST, TRUE);
				curl_setopt($session6, CURLOPT_RETURNTRANSFER, TRUE);
				$resp6 = curl_exec($session6);
			}
		}
		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($idpasien);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['totalObat'] = Folio::where('registrasi_id', $idreg)->where('jenis', 'ORJ')->sum('total');
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['penjualan'] = Penjualan::where('id', '=', session('penjualanid'))->where('registrasi_id', '=', $idreg)->first();
		$data['detail'] = Penjualandetail::where('no_resep', '=', @$data['penjualan']->no_resep)->get();

		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['penjualanid'] = session('penjualanid');
		$data['next_resep'] = session('next_resep');
		// return $data; die;
		return view('penjualan.penjualan-baru.form_penjualan_new', $data)->with('idreg', $idreg);
	}

	public function form_penjualan_baru_eresep_cart(Request $request, $idpasien, $idreg, $ideresep = '', $idpenjualan = '')
	{

		
		// Coba destroy cart waktu halaman dibuka
		Cart::instance('obat' . $idreg)->destroy();
		Cart::instance('penjualan' . $idreg)->destroy();
		Cart::instance('telaah' . $idreg)->destroy();
		

		
		$resep_note = ResepNote::find($ideresep);
		$data['id_resep'] = $resep_note->id;
		$data['reg'] = Registrasi::find($idreg);
		// @updateTaskId(6,$data['reg']->nomorantrian);
		session(['jenis' => $data['reg']->bayar]);
		$data['resep'] = ResepNote::with('resep_detail.logistik_batch.master_obat')->where('uuid', $resep_note->uuid)->where('registrasi_id', $idreg)->first();
		$data['Totresep'] = ResepNote::join('resep_note_detail', 'resep_note.id', '=', 'resep_note_detail.resep_note_id')
			->join('logistik_batches', 'resep_note_detail.logistik_batch_id', '=', 'logistik_batches.id')
			->select(DB::raw('sum(logistik_batches.hargajual_umum * resep_note_detail.qty) as total'), 'resep_note_detail.id_medication_request as id_medication_request', 'resep_note_detail.kronis as kronis')
			->where('resep_note.uuid', $resep_note->uuid)
			->where('resep_note.registrasi_id', $idreg)
			->first();
		if ($data['Totresep']) {
			$data['tot_sementara'] = $data['Totresep']->total;
			$data['idMedicReq'] = $data['Totresep']->id_medication_request;
		} else {
			$data['idMedicReq'] = $data['Totresep']->id_medication_request;
			$data['tot_sementara'] = '';
		}
		// dd($data['Totresep']);
		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();

		// $penjualan_id = null;

		// if (!empty($idpenjualan)) {
		// 	$penjualans = Penjualan::find($idpenjualan);
		// 	$next_res = $penjualans->no_resep;
		// } else {
		// 	$next_res = null;
		// }

		$data['pasien'] = Pasien::find($idpasien);
		if (!$data['pasien']) {
			Flashy::error('Pasien tidak ditemukan!');
			return redirect()->back();
		}
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		// $data['penjualan'] = Penjualan::find($penjualan_id);
		// $data['detail'] = Penjualandetail::where('no_resep', '=', $next_res)->get();
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		// $data['penjualanid'] = $penjualan_id;
		// $data['next_resep'] = $next_res;

		return view('penjualan.penjualan-baru.form_penjualan_eresep_new', $data)->with('idreg', $idreg);
	}

	public function validasiEresepCart(Request $request)
	{

		// dd($request->all());
		$idpasien = $request->idpasien;
		$idreg    = $request->idreg;
		$ideresep = $request->ideresep;
		$jenis = Registrasi::find($idreg)->status_reg;
		$reg = Registrasi::find($idreg);
		// if (substr($jenis, 0, 1) == 'J') {
		//     $count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
		//     $next_resep = 'FRJ' . date('YmdHis');
		// } elseif (substr($jenis, 0, 1) == 'I') {
		//     $count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
		//     $next_resep = 'FRI' . date('YmdHis');
		// } elseif (substr($jenis, 0, 1) == 'G') {
		//     $count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
		//     $next_resep = 'FRD' . date('YmdHis');
		// }

		//  No resep generate saat akan simpan saja
		// Coba untuk tidak memakai session sama sekali
		$dataPenjualan = [
			'id' => uniqId(),
			'name' => 'Penjualan',
			'price' => 0,
			'qty' => 1,
			'options' => [
				'user_id' => Auth::user()->id,
				'registrasi_id' => $idreg,
				'dokter_id' => $reg->dokter_id,
				'id_resep' => $ideresep,
			]
		];

		$addPenjualan = Cart::instance('penjualan' . $idreg)->add($dataPenjualan);
		if (!$addPenjualan) {
			return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
		}

		// session()->forget('next_resep');
		// session()->forget('penjualanid');
		// if (!session('next_resep')) {

		// 	$jenis = Registrasi::find($idreg)->status_reg;
		// 	$reg = Registrasi::find($idreg);
		// 	if (substr($jenis, 0, 1) == 'J') {
		// 		$count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
		// 		$next_resep = 'FRJ' . date('YmdHis');
		// 	} elseif (substr($jenis, 0, 1) == 'I') {
		// 		$count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
		// 		$next_resep = 'FRI' . date('YmdHis');
		// 	} elseif (substr($jenis, 0, 1) == 'G') {
		// 		$count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
		// 		$next_resep = 'FRD' . date('YmdHis');
		// 	}

		// 	$dataPenjualan = [
		// 		'id' => uniqId(),
		// 		'name' => 'Penjualan',
		// 		'price' => 0,
		// 		'qty' => 1,
		// 		'options' => [
		// 			'no_resep' => $next_resep,
		// 			'user_id' => Auth::user()->id,
		// 			'registrasi_id' => $idreg,
		// 			'dokter_id' => $reg->dokter_id,
		// 			'id_resep' => $ideresep,
		// 		]
		// 	];

		// 	$addPenjualan = Cart::instance('penjualan' . $idreg)->add($dataPenjualan);
		// 	if (!$addPenjualan) {
		// 		return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
		// 	}
		// 	// session(['penjualanid' => $p->id]);
		// 	session(['next_resep' => $next_resep]);
		// }


		foreach ($request['resep_detail'] as $d) {
			// $caraminum   = $d['cara_minum'];
			$Uangracik   = UangRacik::find($d['uang_racik']);
			$logistik_batch_id = $d['logistik_batch_id'];
			$created = date('Y-m-d H:i:s');

			$obat_batch = LogistikBatch::where('id', $logistik_batch_id)->first();

			if ($obat_batch) {
				$id_medication_dep = '';

				$harga = LogistikBatch::select('hargajual_jkn')->where('id', $logistik_batch_id)->first()->hargajual_jkn;
				if($reg->poli->kelompok == 'ESO'){
					$cyto = ($harga * 30) / 100;
					$harga = $harga + $cyto;
				}else{
					if (cek_jenispasien($idreg) == '1') {
						$harga = LogistikBatch::select('hargajual_jkn')->where('id', $logistik_batch_id)->first()->hargajual_jkn;
					} else {
						$harga = LogistikBatch::select('hargajual_umum')->where('id', $logistik_batch_id)->first()->hargajual_umum;
					}
				}
				// Validasi obat kronis atau bukan

				// Penjualan_id dan no_resep didapat saat simpan
				if ($d['kronis'] == 'N') {
					$data = [
						'id' => $obat_batch->id,
						'name' => $obat_batch->nama_obat,
						'qty' => $d['qty'],
						'price' => $harga,
						'options' => [
							'is_kronis' => @$d['kronis'],
							'logistik_batch_id' => $logistik_batch_id,
							'cara_bayar_id' => @$d['cara_bayar_id'],
							'masterobat_id' => $obat_batch->masterobat_id,
							'tipe_rawat' => $request['tipe_rawat'],
							'cara_minum' => @$d['cara_minum'],
							'cara_bayar_id' => $reg->bayar,
							'racikan' => @$d['obat_racikan'],
							'tiket' => @$d['tiket'],
							'takaran' => @$d['takaran'],
							'expired' => $obat_batch->expireddate,
							'informasi1' => $d['informasi'],
							'jml_kronis' => @$d['jml_kronis'],
							'subtotal' => ($harga * $d['qty']),
							'uang_racik' => rupiah(@$Uangracik->nominal),
							'uang_racik_id' => @$d['uang_racik'],
							'created' => $created,
						],
					];
					$add = Cart::instance('obat' . $idreg)->add($data);
					if (!$add) {
						Cart::instance('penjualan' . $idreg)->destroy();
						return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
					}
				} else {
					/**
					 * Jika obat Kronis, maka hitung rumus
					 * Pemakaian obat full adalah 30 
					 * Pemakaian obat 1/2 adalah 15
					 * Pemakaian obat 1/4 adalah 8
					 * 
					 * Obat full (30) | 23 untuk kronis & 7 untuk non kronis
					 * Obat 1/2 (15) | 15/30= 0.5 0.5*7=3.5 -> pembulatan keatas jadi 4 untuk non kronis & 15-4 = 11 untuk kronis
					 * Obat 1/4 (8)  | 8/30=0.26 0.26*7= 1.82 -> pembulatan keatas jadi 2 untuk non kronis & 8-2 = 6 untuk kronis
					 */

					$jml_obat = $d['qty'];
					$ds = intval($jml_obat / 30);
					$sisa = $jml_obat % 30;
					if ($sisa == 0 || $sisa == 15 || $sisa == 8) {
						$jml_obat_kronis = $ds * 23;
						$jml_obat_non_kronis = $ds * 7;

						if ($sisa == 15) {
							$jml_obat_kronis += 11;
							$jml_obat_non_kronis += 4;
						}

						if ($sisa == 8) {
							$jml_obat_kronis += 6;
							$jml_obat_non_kronis += 2;
						}

						// Insert Kronis
						//  penjualan_id dan no_resep di generate saat insert ke db
						$data1 = [
							'id' => $obat_batch->id,
							'name' => $obat_batch->nama_obat,
							'qty' => $jml_obat_kronis,
							'price' => $harga,
							'options' => [
								'is_kronis' => 'Y',
								'logistik_batch_id' => $logistik_batch_id,
								'cara_bayar_id' => @$d['cara_bayar_id'],
								'masterobat_id' => $obat_batch->masterobat_id,
								'tipe_rawat' => $request['tipe_rawat'],
								'cara_minum' => @$d['cara_minum'],
								'cara_bayar_id' => $reg->bayar,
								'racikan' => @$d['obat_racikan'],
								'tiket' => @$d['tiket'],
								'takaran' => @$d['takaran'],
								'expired' => $obat_batch->expireddate,
								'informasi1' => $d['informasi'],
								'jml_kronis' => @$d['jml_kronis'],
								'subtotal' => ($harga * $jml_obat_kronis),
								'uang_racik' => rupiah(@$Uangracik->nominal),
								'uang_racik_id' => @$d['uang_racik'],
								'created' => $created,
							],
						];

						$add1 = Cart::instance('obat' . $idreg)->add($data1);

						// Insert Non Kronis
						$data2 = [
							'id' => $obat_batch->id,
							'name' => $obat_batch->nama_obat,
							'qty' => $jml_obat_non_kronis,
							'price' => $harga,
							'options' => [
								'is_kronis' => 'N',
								'logistik_batch_id' => $logistik_batch_id,
								'cara_bayar_id' => @$d['cara_bayar_id'],
								'masterobat_id' => $obat_batch->masterobat_id,
								'tipe_rawat' => $request['tipe_rawat'],
								'cara_minum' => @$d['cara_minum'],
								'cara_bayar_id' => $reg->bayar,
								'racikan' => @$d['obat_racikan'],
								'tiket' => @$d['tiket'],
								'takaran' => @$d['takaran'],
								'expired' => $obat_batch->expireddate,
								'informasi1' => $d['informasi'],
								'jml_kronis' => @$d['jml_kronis'],
								'subtotal' => ($harga * $jml_obat_non_kronis),
								'uang_racik' => rupiah(@$Uangracik->nominal),
								'uang_racik_id' => @$d['uang_racik'],
								'created' => $created,
							],
						];

						$add2 = Cart::instance('obat' . $idreg)->add($data2);

						if (!$add1 && !$add2) {
							Cart::instance('penjualan' . $idreg)->destroy();
							Cart::instance('obat' . $idreg)->destroy();
							return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
						}
					} else {
						Cart::instance('penjualan' . $idreg)->destroy();
						Cart::instance('obat' . $idreg)->destroy();
						return response()->json(['sukses' => false, 'data' => 'Obat kronis hanya bisa ditambah untuk pemakaian penuh, 1/2, ataupun 1/4']);
					}
				}
			}
		}

		$dataTelaah = [
			'id' => uniqId(),
			'name' => 'Penjualan',
			'price' => 0,
			'qty' => 1,
			'options' => $request->telaah
		];

		if (count(Cart::instance('telaah' . $idreg)->content()) > 0) {
			Cart::instance('telaah' . $idreg)->destroy();
		}

		$addTelaah = Cart::instance('telaah' . $idreg)->add($dataTelaah);
		if (!$addTelaah) {
			Cart::instance('penjualan' . $idreg)->destroy();
			Cart::instance('obat' . $idreg)->destroy();
			return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
		}
		return response()->json(['sukses' => true, 'data' => 'Berhasil validasi E-Resep']);
	}

	public function saveDetailBaruCart(Request $request)
	{
		$idreg = $request->idreg;
		$request->validate(['masterobat_id' => 'required']);
		$logistik_batch_id = $request->masterobat_id;
		$created = date('Y-m-d H:i:s');
		// if (!session('next_resep')) {

		// 	$jenis = Registrasi::find($idreg)->status_reg;
		// 	$reg = Registrasi::find($idreg);
		// 	if (substr($jenis, 0, 1) == 'J') {
		// 		$count = Penjualan::where('no_resep', 'LIKE', 'FRJ' . date('Ymd') . '%')->count() + 1;
		// 		$next_resep = 'FRJ' . date('YmdHis');
		// 	} elseif (substr($jenis, 0, 1) == 'I') {
		// 		$count = Penjualan::where('no_resep', 'LIKE', 'FRI' . date('Ymd') . '%')->count() + 1;
		// 		$next_resep = 'FRI' . date('YmdHis');
		// 	} elseif (substr($jenis, 0, 1) == 'G') {
		// 		$count = Penjualan::where('no_resep', 'LIKE', 'FRD' . date('Ymd') . '%')->count() + 1;
		// 		$next_resep = 'FRD' . date('YmdHis');
		// 	}

		// 	$dataPenjualan = [
		// 		'id' => uniqId(),
		// 		'name' => 'Penjualan',
		// 		'price' => 0,
		// 		'qty' => 1,
		// 		'options' => [
		// 			'no_resep' => $next_resep,
		// 			'user_id' => Auth::user()->id,
		// 			'registrasi_id' => $idreg,
		// 			'dokter_id' => $reg->dokter_id,
		// 		]
		// 	];
		// 	Cart::instance('penjualan' . $idreg)->destroy();
		// 	$addPenjualan = Cart::instance('penjualan' . $idreg)->add($dataPenjualan);
		// 	if (!$addPenjualan) {
		// 		return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
		// 	}
		// 	// session(['penjualanid' => $p->id]);
		// 	session(['next_resep' => $next_resep]);
		// }

		$jenis = Registrasi::find($idreg)->status_reg;
		$reg = Registrasi::find($idreg);

		$dataPenjualan = [
			'id' => uniqId(),
			'name' => 'Penjualan',
			'price' => 0,
			'qty' => 1,
			'options' => [
				'user_id' => Auth::user()->id,
				'registrasi_id' => $idreg,
				'dokter_id' => $reg->dokter_id,
			]
		];
		Cart::instance('penjualan' . $idreg)->destroy();
		$addPenjualan = Cart::instance('penjualan' . $idreg)->add($dataPenjualan);
		if (!$addPenjualan) {
			return response()->json(['sukses' => false, 'data' => 'Gagal memvalidasi obat']);
		}
		// session(['penjualanid' => $p->id]);
		$obat = LogistikBatch::leftJoin('masterobats', 'masterobats.id', '=', 'logistik_batches.masterobat_id')
			->where('logistik_batches.id', $logistik_batch_id)
			->withTrashed()
			->select('masterobats.nama', 'logistik_batches.*')
			->first();

		$cekdata = Penjualandetail::where('no_resep', session('next_resep'))->where('logistik_batch_id', $logistik_batch_id)->exists();

		if ($logistik_batch_id == config('app.obatRacikan_id')) {
			$harga = rupiah($request['racikan']);
		}

		if ($request['kronis'] == 'N') {
			if ($cekdata) {
				return response()->json([
					'sukses' => false,
					'error'  => 'Obat Sudah ada!'
				]);
			} else {
				$harga = $obat->hargajual_jkn;
				if($reg->poli->kelompok == 'ESO'){
					$cyto = ($harga * 30) / 100;
					$harga = $harga + $cyto;
				}else{
					if (cek_jenispasien($request['idreg']) == '1') {
						$harga = $obat->hargajual_jkn;
					} else {
						$harga = $obat->hargajual_umum;
					}
				}

				if ($request['diskon'] == null) {
					$diskon = 0;
				} else {
					$diskon = $request['diskon'];
				}

				$hargaReal = $harga - ($harga * ($diskon / 100));
				$id_medication_dep = '';

				$Uangracik   = UangRacik::find($request['uang_racik']);

				// $d = new Penjualandetail();
				// $d->penjualan_id = session('penjualanid');
				// if (@$request->kronis == 'Y') {
				// 	$d->is_kronis = @$request->kronis;
				// }
				// $d->no_resep = session('next_resep');
				// $d->masterobat_id = $obat->masterobat_id;
				// $d->id_medication_dep = @$id_medication_dep;
				// $d->logistik_batch_id = $request['masterobat_id'];
				// $d->jml_kronis  = $request['jml_kronis'];
				// $d->diskon  = $request['diskon'];
				// $d->jumlah = $request['jumlah'];
				// $d->uang_racik = rupiah($Uangracik->nominal);
				// $d->uang_racik_id = $request['uang_racik'];
				// $d->hargajual = $hargaReal * $request['jumlah'];
				// if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				// 	$d->tipe_rawat = 'TA';
				// } elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				// 	$d->tipe_rawat = 'TG';
				// } elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				// 	$d->tipe_rawat = 'TI';
				// }
				// $d->expired = $request['expired'];
				// $d->informasi1 = $request['informasi1'];
				// $d->hargajual_kronis = $hargaReal * $request['jml_kronis'];
				// $d->cara_minum_id  = $request['cara_minum_id'];
				// $d->takaran	= $request['takaran'];
				// $d->etiket = $request['tiket'];
				// $d->cetak = $request['cetak'];
				// $d->save();
				$data = [
					'id' => $obat->id,
					'name' => $obat->nama_obat,
					'qty' => $request['jumlah'],
					'price' => $hargaReal,
					'options' => [
						'is_kronis' => @$request->kronis,
						'logistik_batch_id' => $logistik_batch_id,
						'masterobat_id' => $obat->masterobat_id,
						'tipe_rawat' => $request['tipe_rawat'],
						'cara_minum' => $request['cara_minum_id'],
						'cara_bayar_id' => $reg->bayar,
						'tiket' => @$request['tiket'],
						'takaran' => @$request['takaran'],
						'expired' => $obat->expireddate,
						'informasi1' => $request['informasi1'],
						'jml_kronis' => @$request['jml_kronis'],
						'subtotal' => ($hargaReal * $request['jumlah']),
						'uang_racik' => rupiah(@$Uangracik->nominal),
						'uang_racik_id' => @$request['uang_racik'],
						'created' => $created,
					],
				];

				$add = Cart::instance('obat' . $idreg)->add($data);
				if (!$add) {
					return response()->json(['sukses' => false, 'data' => 'Gagal menambahkan obat']);
				}
			}
		} elseif ($request['kronis'] == 'Y') {
			if ($cekdata) {
				return response()->json([
					'sukses' => false,
					'message'  => 'Obat Sudah ada!'
				]);
			}
			/**
			 * Jika obat Kronis, maka hitung rumus
			 * Pemakaian obat full adalah 30 
			 * Pemakaian obat 1/2 adalah 15
			 * Pemakaian obat 1/4 adalah 8
			 * 
			 * Obat full (30) | 23 untuk kronis & 7 untuk non kronis
			 * Obat 1/2 (15) | 15/30= 0.5 0.5*7=3.5 -> pembulatan keatas jadi 4 untuk non kronis & 15-4 = 11 untuk kronis
			 * Obat 1/4 (8)  | 8/30=0.26 0.26*7= 1.82 -> pembulatan keatas jadi 2 untuk non kronis & 8-2 = 6 untuk kronis
			 */

			$harga = $obat->hargajual_jkn;
			if($reg->poli->kelompok == 'ESO'){
				$cyto = ($harga * 30) / 100;
				$harga = $harga + $cyto;
			}else{
				if (cek_jenispasien($request['idreg']) == '1') {
					$harga = $obat->hargajual_jkn;
				} else {
					$harga = $obat->hargajual_umum;
				}
			}

			if ($request['diskon'] == null) {
				$diskon = 0;
			} else {
				$diskon = $request['diskon'];
			}

			$hargaReal = $harga - ($harga * ($diskon / 100));
			$id_medication_dep = '';

			$jml_obat = $request['jumlah'];
			$ds = intval($jml_obat / 30);
			$sisa = $jml_obat % 30;
			if ($sisa == 0 || $sisa == 15 || $sisa == 8) {
				$jml_obat_kronis = $ds * 23;
				$jml_obat_non_kronis = $ds * 7;

				if ($sisa == 15) {
					$jml_obat_kronis += 11;
					$jml_obat_non_kronis += 4;
				}

				if ($sisa == 8) {
					$jml_obat_kronis += 6;
					$jml_obat_non_kronis += 2;
				}

				$Uangracik   = UangRacik::find($request['uang_racik']);

				// Insert Kronis
				$data1 = [
					'id' => $obat->id,
					'name' => $obat->nama_obat,
					'qty' => $jml_obat_kronis,
					'price' => $hargaReal,
					'options' => [
						'is_kronis' => 'Y',
						'logistik_batch_id' => $logistik_batch_id,
						'masterobat_id' => $obat->masterobat_id,
						'tipe_rawat' => $request['tipe_rawat'],
						'cara_minum' => $request['cara_minum_id'],
						'cara_bayar_id' => $reg->bayar,
						'tiket' => @$request['tiket'],
						'takaran' => @$request['takaran'],
						'expired' => $obat->expireddate,
						'informasi1' => $request['informasi1'],
						'jml_kronis' => @$request['jml_kronis'],
						'subtotal' => ($hargaReal * $jml_obat_kronis),
						'uang_racik' => rupiah(@$Uangracik->nominal),
						'uang_racik_id' => @$request['uang_racik'],
						'created' => $created,
					],
				];

				$add1 = Cart::instance('obat' . $idreg)->add($data1);

				// Insert Non Kronis
				$data2 = [
					'id' => $obat->id,
					'name' => $obat->nama_obat,
					'qty' => $jml_obat_non_kronis,
					'price' => $hargaReal,
					'options' => [
						'is_kronis' => 'N',
						'logistik_batch_id' => $logistik_batch_id,
						'masterobat_id' => $obat->masterobat_id,
						'tipe_rawat' => $request['tipe_rawat'],
						'cara_minum' => $request['cara_minum_id'],
						'cara_bayar_id' => $reg->bayar,
						'tiket' => @$request['tiket'],
						'takaran' => @$request['takaran'],
						'expired' => $obat->expireddate,
						'informasi1' => $request['informasi1'],
						'jml_kronis' => @$request['jml_kronis'],
						'subtotal' => ($hargaReal * $jml_obat_non_kronis),
						'uang_racik' => rupiah(@$Uangracik->nominal),
						'uang_racik_id' => @$request['uang_racik'],
						'created' => $created,
					],
				];

				$add2 = Cart::instance('obat' . $idreg)->add($data2);
				if (!$add1 && !$add2) {
					return response()->json(['sukses' => false, 'data' => 'Gagal menambahkan obat']);
				}
			} else {
				return response()->json([
					'sukses'   => false,
					'data' => "Obat kronis hanya bisa ditambah untuk pemakaian penuh, 1/2, ataupun 1/4"
				]);
			}
		}

		return response()->json(['sukses' => true, 'data' => 'Berhasil menambahkan obat']);
	}

	public function saveTotalBaruEresepCart(Request $request)
	{
		$cartContentTelaah = Cart::instance('telaah' . $request->reg_id)->content();
		if ($cartContentTelaah instanceof \Illuminate\Support\Collection) {
			$cartContentTelaah = $cartContentTelaah->toArray();
		}
		$firstKey = array_key_first($cartContentTelaah);
		$telaah = @$cartContentTelaah[$firstKey]['options'];

		$cartContent = Cart::instance('penjualan' . $request->reg_id)->content();
		if ($cartContent instanceof \Illuminate\Support\Collection) {
			$cartContent = $cartContent->toArray();
		}
		$firstKey = array_key_first($cartContent);
		$penjualanCart = @$cartContent[$firstKey];
		$jenis = Registrasi::find($request->reg_id)->status_reg;
		if (substr($jenis, 0, 1) == 'J') {
			$next_resep = 'FRJ' . date('YmdHis');
		} elseif (substr($jenis, 0, 1) == 'I') {
			$next_resep = 'FRI' . date('YmdHis');
		} elseif (substr($jenis, 0, 1) == 'G') {
			$next_resep = 'FRD' . date('YmdHis');
		}

		//cekDataa
		// $p = Penjualan::where('no_resep', $penjualanCart['options']['no_resep'])->first();
		// if (!$p) {
		// 	//Save Penjualan
		// 	$p = new Penjualan();
		// 	$p->no_resep = $penjualanCart['options']['no_resep'];
		// 	$p->user_id = $penjualanCart['options']['user_id'];
		// 	$p->registrasi_id = $penjualanCart['options']['registrasi_id'];
		// 	$p->dokter_id = $penjualanCart['options']['dokter_id'];
		// 	$p->catatan = json_encode($telaah);
		// 	$p->save();
		// }

		/*
            Cek Data New
            Penjualan pasti belum ter create di database, karena menggunakan cart
            Pengecekan selanjutnya hanya untuk memastikan bahwa no_resep ($next_resep) yang akan digunakan belum ada atau belum digunakan oleh orang lain.
            Ada peluang kecil jika 2 resep diproses bersamaan akan memiliki no_resep yg sama
        */


		$jasa_racik   	= rupiah($request['jasa_racik']);
		$cara_bayar		= $request['cara_bayar'];
		$successtte = false;
		$proses_tte = $request->tte;
		$message = null;
		$jenis = substr($request['tipe_rawat'], 0, 1);

		// Update waktu
		$reg = Registrasi::find($request->reg_id);
		if ($reg->nomorantrian) {
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

			if (status_consid(6)) {
				$updatewaktu   = '{
					"kodebooking": "' . @$reg->nomorantrian . '",
					"taskid": "6",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session2 = curl_init($completeurl);
				curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				curl_setopt($session2, CURLOPT_POST, TRUE);
				curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($session2);
				$sml2 = json_decode($resp, true);
			}

			if (status_consid(7)) {
				// UPDATE TASK ID 7
				$updatewaktu2   = '{
					"kodebooking": "' . @$reg->nomorantrian . '",
					"taskid": "7",
					"waktu": "' . round(microtime(true) * 1000) . '"
				}';
				$session3 = curl_init($completeurl);
				curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
				curl_setopt($session3, CURLOPT_POST, TRUE);
				curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
				$response3 = curl_exec($session3);
				$sml3 = json_decode($response3, true);

				if (isset($sml3)) {
					if (@$sml3['metadata']['code'] == '200' || @$sml3['metadata']['code'] == '208') {
						@$reg = RegistrasiDummy::where('nomorantrian', @$reg->nomorantrian)->first();
						if (@$reg) {
							@$reg->taskid = 7;
							@$reg->status = 'dilayani';
							@$reg->save();
						}
					}
				}
			}
		}
		DB::beginTransaction();
		try {
			$isNoResepExists = Penjualan::where('no_resep', $next_resep)->exists();
			if ($isNoResepExists) {
				return response([
					'sukses' => false,
					'message' => $next_resep . " Sudah ada! Coba ulangi proses simpan untuk mendapatkan no_resep baru!"
				]);
			}
			$p = new Penjualan();
			$p->no_resep = $next_resep;
			$p->user_id = $penjualanCart['options']['user_id'];
			$p->registrasi_id = $penjualanCart['options']['registrasi_id'];
			$p->dokter_id = $penjualanCart['options']['dokter_id'];
			$p->catatan = json_encode($telaah);
			$p->pembuat_resep = $request['pembuat_resep'];
			$p->response_time = $request['response_time'];
			$p->save();

			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$tipe_rawat = 'TI';
			}

			$tipe['tipe_rawat'] = $tipe_rawat;
			// Penjualandetail::where('penjualan_id', $penjualan_id)->update($tipe);
			// $det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();

			// Optimize Query | menghindari query didalam loop
			$user_gudang_id = Auth::user()->gudang_id;
			$logistikStockCreate = [];
			foreach (Cart::instance('obat' . $request->reg_id)->content() as $d) {
				$stocks = LogistikBatch::where('id', $d->options->logistik_batch_id)
					->where('gudang_id',  $user_gudang_id)
					->get(['masterobat_id', 'stok']);

				if ($d->options->logistik_batch_id) {
					$saldo_obat = LogistikBatch::where('id', $d->options->logistik_batch_id)->first();

					// Jika id bukan 610 (riri) maka mempengaruhi stock
					if (Auth::user()->id != 610) {
						$saldo_obat->stok = ($saldo_obat->stok - ($d->qty + $d->options->jml_kronis));
						$saldo_obat->save();
					}

					$stok_batch = $stocks->where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');

					if ($stok_batch != 0  &&  $stok_batch != NULL) {
						$total_stok = $stok_batch;
					} else {
						$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
					}

					// Mekanisme baru untuk obat kronis dan nonkronis
					// QTY obat simpan di jumlah (baik kronis ataupun tidak)
					// col is_kronis menunjukan obat itu kronis atau tidak
					// Jadi dalam satu faktur penjualan bisa jadi ada dua obat yang sama satu nya kronis dan satunya tidak
					// TODO: jika ada performance issue, bisa dipertimbakan untuk cara peng insertan penjualan detail dilakuakan seperti insert logistickStock dibawah
					$pd = new Penjualandetail();
					$pd->penjualan_id = $p->id;
					$pd->no_resep = $p->no_resep;
					$pd->masterobat_id = $saldo_obat->masterobat_id;
					$pd->jumlah = $d->qty;
					$pd->is_kronis = $d->options->is_kronis;
					$pd->jml_kronis = $d->options->jml_kronis;
					$pd->uang_racik = $d->options->uang_racik;
					$pd->hargajual = $d->price * $d->qty;
					$pd->hargajual_kronis = $d->price * $d->options->jml_kronis;
					$pd->informasi1 = $d->options->informasi1;
					$pd->informasi2 = $d->options->informasi2;
					$pd->cara_minum_id = @$d->options->cara_minum;
					$pd->tipe_rawat = @$tipe_rawat;
					$pd->cara_bayar_id = $d->options->cara_bayar_id;
					$pd->expired = $d->options->expired;
					$pd->etiket = $d->options->tiket;
					$pd->takaran =  $d->options->takaran;
					$pd->logistik_batch_id =  $d->options->logistik_batch_id;
					$pd->cetak = $d->options->cetak ?? 'Y';
					$pd->created_at = $d->options->created ?? valid_date($request['created_at']);
					$pd->save();
					// dd($pd);

					$logistikStok = [
						'gudang_id'         => $user_gudang_id,
						'supplier_id'       => null,
						'masterobat_id'     => $saldo_obat->masterobat_id,
						'logistik_batch_id' => $saldo_obat->id,
						'batch_no'          => $saldo_obat->nomorbatch,
						'expired_date'      => date("Y-m-d", strtotime($saldo_obat->expireddate)),
						'masuk'             => 0,
						'keluar'            => $d->qty + $d->options->jml_kronis,
						'total'             => $total_stok - ($d->qty + $d->options->jml_kronis),
						'keterangan'        => 'Penjualan ' . $p->no_resep
					];
					array_push($logistikStockCreate, $logistikStok);
				}
			}
			LogistikStock::insert($logistikStockCreate);

			$reg = Registrasi::find($p->registrasi_id);
			$fol = Folio::where('namatarif', $p->no_resep)->where('registrasi_id', $reg->id)->first();
			if (!$fol) {
				$fol = new Folio();
			}
			$total_tagihan = $p->penjualandetail->sum('hargajual');
			$fol->total = $total_tagihan;
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $p->no_resep;
			$fol->cara_bayar_id = $cara_bayar;
			$fol->gudang_id = $user_gudang_id;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = @$jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
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
			$tag->harus_dibayar = $total_tagihan;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			// update E Resep
			if (!empty($request->resep_uuid)) {
				$resep = ResepNote::where('uuid', $request->resep_uuid)->first();
				if (isset($resep)) {
					// @$resep->update([
					// 	"no_resep" => @$pj->no_resep,
					// 	"status" => 'selesai',
					// 	"proses" => 'selesai',
					// 	"is_validate" => '1',
					// 	"notif_play" => '0',
					// 	"penjualan_id" => @$pj->id,
					// 	"comment" => @$request->ket_resep
					// ]);
					@$resep->no_resep = @$p->no_resep;
					@$resep->status = 'selesai';
					@$resep->proses = 'selesai';
					@$resep->is_validate = '1';
					@$resep->notif_play = '0';
					@$resep->penjualan_id = @$p->id;
					@$resep->comment = @$request->ket_resep;
					@$resep->update();
				}
			}

			$tte = null;
			$tteFarmasi = null;
			// Proses TTE
			if (!empty($request->tte)) {
				$resep_note = ResepNote::with('resep_detail')->where('penjualan_id', $p->id)->first();
				$data['nama_racikan'] = '';
				$data['penjualan'] = $p;
				$data['resep_note'] = $resep_note;
				if ($data['resep_note']) {
					$data['nama_racikan'] = $data['resep_note']->nama_racikan;
					$data['no_resep'] = $data['resep_note']->no_resep;
				} else {
					$data['nama_racikan'] = '';
					$data['no_resep']     = '';
				}

				$data['reg'] = $reg;
				$data['detail'] = Penjualandetail::where('obat_racikan', 'N')->where('penjualan_id', $p->id)->get();
				$data['detail_racikan'] = Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $p->id)->get();
				$data['penjualan_detail'] =  Penjualandetail::where('penjualan_id', $p->id)->first();

				if (tte()) {
					// TTE Eresep Dokter
					// Create temp pdf eresep file 
					if (empty(json_decode(@$resep_note->tte)->base64_signed_file)) {
						$dt['detail'] = $resep_note->resep_detail;
						$dt['resep_note'] = $resep_note;
						$dt['reg'] = $reg;
						$dt['nama_racikan'] = $resep_note->nama_racikan;
						$dt['no_resep'] = $resep_note->no_resep;
						$dt['proses_tte_apotik'] = true;

						$pdf = PDF::loadView('farmasi.laporan.resepDokter', $dt);
						$pdf->setPaper('A4', 'potret');
						$pdfContent = $pdf->output();
					} else {
						$ttePDF = json_decode($resep_note->tte);
						$base64 = $ttePDF->base64_signed_file;
						$pdfContent = base64_decode($base64);
					}

					$filePath = uniqId() . 'eresep-laporan.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(500)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					// Proses TTE
					$tte = tte_visible_koordinat($filePath, $request->nik_hidden, $request->passphrase, "!", $qrCodePath);

					log_esign($reg->id, $tte->response, "eresep-dokter", $tte->httpStatusCode);

					$resp = json_decode($tte->response);

					// TTE Eresep Farmasi
					$data['proses_tte'] = true;

					$pdfFarmasi = PDF::loadView('farmasi.laporan.pdf_eresep', $data);
					$pdfFarmasi->setPaper('A4', 'potret');
					$pdfFarmasiContent = $pdfFarmasi->output();

					$filePath = uniqId() . 'eresep-farmasi.pdf';
					File::put(public_path($filePath), $pdfFarmasiContent);

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					// Proses TTE
					$tteFarmasi = tte_visible_koordinat($filePath, $request->nik_hidden, $request->passphrase, "#", $qrCodePath);

					log_esign($reg->id, $tteFarmasi->response, "eresep-farmasi", $tteFarmasi->httpStatusCode);

					$respFarmasi = json_decode($tteFarmasi->response);

					if ($tte->httpStatusCode == 200 && $tteFarmasi->httpStatusCode == 200) {
						$resep_note->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$resep_note->update();

						$p->tte = $tteFarmasi->response;
						$p->update();

						$successtte = true;
						// session()->forget('idpenjualan');
						// session()->forget('penjualanid');
						// session()->forget('next_resep');
						DB::commit();
						Cart::instance('obat' . $request->reg_id)->destroy();
						Cart::instance('telaah' . $request->reg_id)->destroy();
						Cart::instance('penjualan' . $request->reg_id)->destroy();
						return response()->json(['sukses' => true, 'id' => $p->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
					} elseif ($tte->httpStatusCode == 400 && $tteFarmasi->httpStatusCode == 400) {
						if (isset($resp->error)) {
							$message = $resp->error;
						} else {
							$message = 'Gagal melakukan proses TTE';
						}
					}
				} else {
					// Eresep Dokter
					$dt['detail'] = $resep_note->resep_detail;
					$dt['resep_note'] = $resep_note;
					$dt['reg'] = $reg;
					$dt['nama_racikan'] = $resep_note->nama_racikan;
					$dt['no_resep'] = $resep_note->no_resep;
					$dt['tte_nonaktif'] = true;

					$pdf = PDF::loadView('farmasi.laporan.resepDokter', $dt);
					$pdf->setPaper('A4', 'potret');
					$pdfContent = $pdf->output();

					$resep_note->tte = json_encode((object) [
						"base64_signed_file" => base64_encode($pdfContent),
					]);
					$resep_note->update();

					// Eresep Farmasi
					$data['tte_nonaktif'] = true;

					$pdfFarmasi = PDF::loadView('farmasi.laporan.pdf_eresep', $data);
					$pdfFarmasi->setPaper('A4', 'potret');
					$pdfFarmasiContent = $pdfFarmasi->output();
					$p->tte = json_encode((object) [
						"base64_signed_file" => base64_encode($pdfFarmasiContent),
					]);
					$p->update();

					DB::commit();
					Cart::instance('obat' . $request->reg_id)->destroy();
					Cart::instance('telaah' . $request->reg_id)->destroy();
					Cart::instance('penjualan' . $request->reg_id)->destroy();
					return response()->json(['sukses' => true, 'id' => $p->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => true]);
				}
			} else {
				// session()->forget('idpenjualan');
				// session()->forget('penjualanid');
				// session()->forget('next_resep');
				DB::commit();
				Cart::instance('obat' . $request->reg_id)->destroy();
				Cart::instance('telaah' . $request->reg_id)->destroy();
				Cart::instance('penjualan' . $request->reg_id)->destroy();
				return response()->json(['sukses' => true, 'id' => $p->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
			}
			DB::rollback();

			if ($tte && $tteFarmasi) {
				log_esign($reg->id, $tte->response, "eresep-dokter", $tte->httpStatusCode);
				log_esign($reg->id, $tteFarmasi->response, "eresep-farmasi", $tteFarmasi->httpStatusCode);
			}
			return response()->json(['sukses' => true, 'id' => $p->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte, 'message' => $message]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['sukses' => false, 'id' => $p->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
		}
	}

	public function form_penjualan_baru_cart_ibs(Request $request, $idpasien, $idreg, $penjualan_id = '')
	{

		$data['reg'] = Registrasi::find($idreg);
		session(['jenis' => $data['reg']->bayar]);

		$data['histori_irj'] = HistorikunjunganIRJ::where('registrasi_id', $data['reg']->id)->where('created_at', 'like', date('Y-m-d') . '%')->get();
		$data['histori_igd'] = HistorikunjunganIGD::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_igd.registrasi_id')
			->where('histori_kunjungan_igd.registrasi_id', $data['reg']->id)
			->where('histori_kunjungan_igd.created_at', 'like', date('Y-m-d') . '%')
			->get();
		// return $data; die;

		$data['pasien'] = Pasien::find($idpasien);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['penjualan'] = Penjualan::where('id', '=', session('penjualanid'))->where('registrasi_id', '=', $idreg)->first();
		$data['detail'] = Penjualandetail::where('no_resep', '=', @$data['penjualan']->no_resep)->get();
		$data['apoteker'] = Apoteker::pluck('nama', 'pegawai_id');
		$data['tiket'] = MasterEtiket::all('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama', 'nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['carabayar'] = Carabayar::all('carabayar', 'id');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['no'] = 1;
		$data['ranap']	= Rawatinap::where('registrasi_id', $idreg)->first();
		$data['uang_racik']	= UangRacik::where('id', 1)->first();
		$data['tipe_uang_racik'] = UangRacik::all();
		$data['cara_minum'] = masterCaraMinum::pluck('nama', 'id');
		$data['penjualanid'] = session('penjualanid');
		$data['next_resep'] = session('next_resep');
		// return $data; die;
		return view('penjualan.penjualan-baru.form_penjualan_new_ibs', $data)->with('idreg', $idreg);
	}

	public function saveTotalBaruCartIbs(Request $request)
	{
		$jasa_racik   	= rupiah($request['jasa_racik']);
		$penjualan_id 	= $request['penjualan_id'];
		$cara_bayar		= $request['cara_bayar'];
		$pembuat_resep = $request['pembuat_resep'];
		$successtte = false;
		$proses_tte = $request->tte;
		$jenis = substr($request['tipe_rawat'], 0, 1);

		// Update waktu
		$reg = Registrasi::find($request['reg_id']);

		// return $request; $die;

		DB::beginTransaction();
		try {
			$total = 0;

			// $pj = Penjualan::find($penjualan_id);
			// $pj->pembuat_resep = @$pembuat_resep;
			// $pj->response_time = $request['response_time'];
			// $pj->update();
			// dd(Cart::content());

			if (substr($request['tipe_rawat'], 0, 1) == 'J') {
				$tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'G') {
				$tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'], 0, 1) == 'I') {
				$tipe_rawat = 'TI';
			}

			$tipe['tipe_rawat'] = $tipe_rawat;
			// Penjualandetail::where('penjualan_id', $penjualan_id)->update($tipe);
			// $det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();

			// Optimize Query | menghindari query didalam loop
			$user_gudang_id = Auth::user()->gudang_id;

			// $arr_masterobat_id = $det->pluck('masterobat_id')->toArray();


			// $arr_logistik_batch = $det->pluck('logistik_batch_id')->toArray();
			if (Cart::subtotal() > 0) {
				// $logistikBatches = LogistikBatch::whereIn('id', $arr_logistik_batch)->get();
				$logistikStockCreate = [];

				$next_resep = 'FRO' . date('YmdHis');

				$pj = new Penjualan();
				$pj->no_resep = $next_resep;
				$pj->pembuat_resep = $request['pembuat_resep'];
				$pj->user_id = Auth::user()->id;
				$pj->registrasi_id = $request['reg_id'];
				$pj->response_time = $request['response_time'];
				// $pj->created_at = valid_date($request['created_at']);
				$pj->save();
				// dd($pj);
				// foreach ($det as $key => $d) 
				// dd(Cart::content());
				foreach (Cart::content() as $d) {
					$stocks = LogistikBatch::where('id', $d->options->logistik_batch_id)
						->where('gudang_id',  $user_gudang_id)
						// ->whereIn('masterobat_id', $arr_masterobat_id)
						->get(['masterobat_id', 'stok']);

					// $total += $d->hargajual;
					// if (Auth::user()->gudang_id == 2) {
					if ($d->options->logistik_batch_id) {
						$saldo_obat = LogistikBatch::where('id', $d->options->logistik_batch_id)->first();

						// Jika id bukan 610 (riri) maka mempengaruhi stock
						if (Auth::user()->id != 610) {
							$saldo_obat->stok = ($saldo_obat->stok - ($d->qty + $d->options->jml_kronis));
							$saldo_obat->save();
						}

						$stok_batch = $stocks->where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');

						if ($stok_batch != 0  &&  $stok_batch != NULL) {
							$total_stok = $stok_batch;
						} else {
							$total_stok = \App\LogistikBatch::where('masterobat_id', $saldo_obat->masterobat_id)->sum('stok');
						}

						// Mekanisme baru untuk obat kronis dan nonkronis
						// QTY obat simpan di jumlah (baik kronis ataupun tidak)
						// col is_kronis menunjukan obat itu kronis atau tidak
						// Jadi dalam satu faktur penjualan bisa jadi ada dua obat yang sama satu nya kronis dan satunya tidak
						$pd = new Penjualandetail();
						$pd->penjualan_id = $pj->id;
						$pd->no_resep = $pj->no_resep;
						$pd->masterobat_id = $saldo_obat->masterobat_id;
						$pd->jumlah = $d->qty;
						$pd->is_kronis = $d->options->is_kronis;
						$pd->jml_kronis = $d->options->jml_kronis;
						$pd->uang_racik = $d->options->uang_racik;
						$pd->hargajual = $d->price * $d->qty;
						$pd->hargajual_kronis = $d->price * $d->options->jml_kronis;
						$pd->informasi1 = $d->options->informasi1;
						$pd->informasi2 = $d->options->informasi2;
						$pd->cara_minum_id = $d->options->cara_minum_id;
						$pd->tipe_rawat = @$tipe_rawat;
						$pd->cara_bayar_id = $d->options->cara_bayar_id;
						$pd->expired = $d->options->expired;
						$pd->etiket = $d->options->tiket;
						$pd->takaran =  $d->options->takaran;
						$pd->logistik_batch_id =  $d->options->logistik_batch_id;
						$pd->cetak = $d->options->cetak;
						$pd->created_at = $d->options->created ?? valid_date($request['created_at']);
						$pd->save();
						// dd($pd);

						$logistikStok = [
							'gudang_id'         => $user_gudang_id,
							'supplier_id'       => null,
							'masterobat_id'     => $saldo_obat->masterobat_id,
							'logistik_batch_id' => $saldo_obat->id,
							'batch_no'          => $saldo_obat->nomorbatch,
							'expired_date'      => date("Y-m-d", strtotime($saldo_obat->expireddate)),
							'masuk'             => 0,
							'keluar'            => $d->qty + $d->options->jml_kronis,
							'total'             => $total_stok - ($d->qty + $d->options->jml_kronis),
							'keterangan'        => 'Penjualan ' . $pj->no_resep
						];
						array_push($logistikStockCreate, $logistikStok);
					}
				}
			}


			LogistikStock::insert($logistikStockCreate);

			$total = (rupiah(Cart::subtotal(0, ',' . ',')));
			$reg = Registrasi::find($pj->registrasi_id);

			$fol = Folio::where('namatarif', $pj->no_resep)->where('registrasi_id', $reg->id)->first();
			if (!$fol) {
				$fol = new Folio();
			}
			$fol->total = $total;
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $pj->no_resep;
			$fol->cara_bayar_id = $cara_bayar;
			$fol->gudang_id = $user_gudang_id;
			$fol->tarif_id = 10000;
			$fol->jasa_racik = @$jasa_racik;
			$fol->lunas = 'N';
			$fol->jenis = 'ORJ';
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


			$tte = null;
			// Proses TTE
			if (!empty($request->tte)) {
				if (tte()) {
					// Create temp pdf eresep file
					$resep_note = ResepNote::where('penjualan_id', $penjualan_id)->first();
					$ttePDF = json_decode($resep_note->tte);
					$base64 = $ttePDF->base64_signed_file;
					$pdfContent = base64_decode($base64);

					$filePath = uniqId() . 'eresep-laporan.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(500)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					// Proses TTE
					$tte = tte_visible_koordinat($filePath, $request->nik_hidden, $request->passphrase, "##", $qrCodePath);

					if ($tte->httpStatusCode == 200) {
						$resep_note->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$resep_note->update();
						$successtte = true;
					}
				} else {
					session()->forget('idpenjualan');
					session()->forget('penjualanid');
					session()->forget('next_resep');
					DB::commit();
					Cart::destroy();
					return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
				}
			} else {
				session()->forget('idpenjualan');
				session()->forget('penjualanid');
				session()->forget('next_resep');
				DB::commit();
				Cart::destroy();
				return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
			}

			if ($successtte) {
				// update E Resep
				if (!empty($request->resep_uuid)) {
					@$resep = ResepNote::where('uuid', $request->resep_uuid)->first();
					if (isset($resep)) {
						@$dt_resep = [
							"no_resep" => @$pj->no_resep,
							"status" => 'selesai',
							"proses" => 'selesai',
							"comment" => @$request->ket_resep
						];
						@$resep->update($dt_resep);
					}
				}
				session()->forget('idpenjualan');
				session()->forget('penjualanid');
				session()->forget('next_resep');

				log_esign($reg->id, $tte->response, "eresep-farmasi", $tte->httpStatusCode);

				DB::commit();
				Cart::destroy();
				return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
			}
			DB::rollback();
			if ($tte) {
				log_esign($reg->id, $tte->response, "eresep-farmasi", $tte->httpStatusCode);
			}
			return response()->json(['sukses' => true, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['sukses' => false, 'id' => $pj->id, 'jenis' => $jenis, 'tte' => $proses_tte, 'sukses_tte' => $successtte]);
		}
	}
}
