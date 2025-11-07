<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\LogistikPejabatPengadaan;
use Auth;
use Illuminate\Http\Request;
use PDF;
use Validator;
use Flashy;
use App\Logistik\Po;
use App\LogistikSupplier;
use App\Masterobat;
use App\Satuanbeli;
use DB;
use Excel;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\Master\AkunCOA;

class PoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		session()->forget('no_po');
		session()->forget('tanggal');
		$date = date('Y-m-d', strtotime('-5 days'));

		$data['po'] = Po::where('status', 'open')
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->distinct('no_po')
			->latest('no_po')
			->get(['no_po']);
		// return $data; die;
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.po.index', $data)->with('no', 1);
		}
	}


	public function verifikasi()
	{

		session()->forget('no_po');
		session()->forget('tanggal');
		$date = date('Y-m-d', strtotime('-5 days'));

		$data['po'] = Po::where('status', 'open')
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->distinct('no_po')
			->latest('no_po')
			->get(['no_po']);
		// return $data; die;
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.po.verifikasi', $data)->with('no', 1);
		}
	}

	public function po_byTanggal(Request $request)
	{
		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);

		$data['po'] = Po::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
			->where('status', 'open')
			->distinct('no_po')
			->latest('no_po')
			->get(['no_po']);

		// if ($request['lanjut']) {
		return view('logistik.logistikmedik.po.index', $data)->with(['no' => 1]);
		// }
	}

	public function verifikasiPObyTanggal(Request $request)
	{
		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);

		$data['po'] = Po::whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
			->where('status', 'open')
			->distinct('no_po')
			->latest('no_po')
			->get(['no_po']);

		// if ($request['lanjut']) {
		return view('logistik.logistikmedik.po.verifikasi', $data)->with(['no' => 1]);
		// }
	}

	public function verifikasiPObyNomor(Request $request)
	{
		if (empty($awal)) {
			$data['po'] = Po::Orwhere('no_po', $request['no_po'])
				->where('status', 'open')
				->distinct('no_po')
				->latest('no_po')
				->get(['no_po']);
		} else {
			$awal  = valid_date($request['tgl_awal']);
			$akhir = valid_date($request['tgl_akhir']);

			$data['po'] = Po::OrwhereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
				->Orwhere('no_po', $request['no_po'])
				->where('status', 'open')
				->distinct('no_po')
				->latest('no_po')
				->get(['no_po']);
		}

		if ($request['cari']) {
			return view('logistik.logistikmedik.po.verifikasi', $data)->with(['no' => 1]);
		}
	}

	public function no_po_byTanggal(Request $request)
	{
		if (empty($awal)) {
			$data['po'] = Po::Orwhere('no_po', $request['no_po'])
				->where('status', 'open')
				->distinct('no_po')
				->latest('no_po')
				->get(['no_po']);
		} else {
			$awal  = valid_date($request['tgl_awal']);
			$akhir = valid_date($request['tgl_akhir']);

			$data['po'] = Po::OrwhereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
				->Orwhere('no_po', $request['no_po'])
				->where('status', 'open')
				->distinct('no_po')
				->latest('no_po')
				->get(['no_po']);
		}

		if ($request['cari']) {
			return view('logistik.logistikmedik.po.index', $data)->with(['no' => 1]);
		}
	}

	public function data()
	{
		if (session('no_po')) {
			$data = Po::where('no_po', session('no_po'))->get();
		} else {
			$data = [];
		}
		return view('logistik.logistikmedik.po.data', compact('data'));
	}

	public function dataEdit()
	{
		if (session('no_po')) {
			$data = Po::where('no_po', session('no_po'))->get();
		} else {
			$data = [];
		}
		return view('logistik.logistikmedik.po.data-edit', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		$data['supplier'] = LogistikSupplier::all();
		$data['barang'] = Masterobat::all();
		$data['satuan'] = Satuanbeli::all();
		$data['penerima'] = \App\Logistik\LogistikPengirimPenerima::all();
		return view('logistik.logistikmedik.po.create', $data);
	}

	function editPO($supplier, $tanggal)
	{
		if (strpos($supplier, '_')) {
			$supplier = str_replace('_', '/', $supplier);
		}
		if (!session('no_po')) {
			session(['no_po' => Po::where('no_po', $supplier)->where('tanggal', $tanggal)->first()->no_po]);
		}
		$po = Po::where('no_po', $supplier)->where('tanggal', $tanggal)->first();
		$data = Po::where('no_po', $supplier)->where('tanggal', $tanggal)->get();

		// return compact('po', 'data'); die;
		return view('logistik.logistikmedik.po.edit', compact('po', 'data'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$cek = Validator::make($request->all(), [
			'tanggal' => 'required',
			'masterobat_id' => 'required',
			'jumlah' => 'required',
			'satuan' => 'required',
			'jenis_pengadaan' => 'required',
		]);

		// CEK JIKA SUDAH ADA SATUAN ATAU BELUM
		if (!is_numeric($request['satuan'])) {
			$cek_satuan = Satuanbeli::where('nama', $request['satuan'])->first();
			if (!$cek_satuan) {
				$cek_satuan = new Satuanbeli();
				$cek_satuan->nama = $request['satuan'];
				$cek_satuan->save();
				$request['satuan'] = $cek_satuan->id;
			} else {
				$request['satuan'] = $cek_satuan->id;
			}
		}

		$noAwal = '442/016/';
		$pelayanan = $request['jenis_pengadaan'];
		$cekUrutan = \App\NoPo::where('no_po', 'LIKE', '%' . date('Y'))->count();
		$nextPo = $noAwal . sprintf("%04s", abs($cekUrutan + 1)) . '/' . $pelayanan . '/' . date('Y');

		if (!empty(session('no_po'))) {
			$noPO = session('no_po');
		} else {
			$noPO = $nextPo;
			$po = new \App\NoPo();
			$po->no_po = $noPO;
			$po->user_id = Auth::user()->id;
			$po->save();
		}

		if ($request['diskon'] != null) {
			$diskonPo = $request['diskon'];
		} else {
			$diskonPo = 0;
		}


		if ($request['diskon'] != null) {
			$hargaPo = $request['harga'];
		} else {
			$hargaPo = 0;
		}

		if ($cek->fails()) {
			return response()->json(['sukses' => false, 'error' => $cek->errors()]);
		} else {
			$po = new Po();
			$po->no_po = $noPO;
			$po->gudang_id = Auth::user()->gudang_id;
			$po->jenis_pengadaan = $request['jenis_pengadaan'];
			$po->tanggal = valid_date($request['tanggal']);
			$po->supplier = $request['supplier'];
			$po->kode_barang = Masterobat::find($request['masterobat_id'])->kode;
			$po->masterobat_id = $request['masterobat_id'];
			$po->jumlah = $request['jumlah'];
			$po->sisa_supplier = $request['jumlah'];
			$po->lampiran = $request['lampiran'];
			$po->perihal = $request['perihal'];
			$po->satuan = $request['satuan'];
			$po->keterangan = $request['keterangan'];
			$po->kode_rekening = $request['kode_rekening'];
			$po->kategori_obat = $request['kategori_obat'];
			$po->no_sp = $request['no_sp'];
			$po->no_usulan = $request['no_usulan'];
			$po->harga = $hargaPo;
			$po->diskon_persen = $diskonPo;
			$po->totalHarga = ($hargaPo - ($hargaPo * ($diskonPo / 100))) * $request['jumlah'];
			$po->verifikasi = 'Y';
			$po->user = Auth::user()->name;
			$po->save();
			session(['no_po' => $po->no_po, 'tanggal' => $request['tanggal']]);
			return response()->json(['sukses' => true]);
		}
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
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$del = Po::find($id)->delete();
		return response()->json(['sukses' => true]);
	}

	function cetakPO($supplier, $tanggal)
	{
		// return $supplier; die;
		if (strpos($supplier, '_')) {
			$supplier = str_replace('_', '/', $supplier);
		}
		$po = Po::where('no_po', $supplier)->where('tanggal', $tanggal)->first();
		$data = Po::where('no_po', $supplier)->where('verifikasi', 'Y')->where('tanggal', $tanggal)->get();
		$no = 1;
		$pejabat = \App\LogistikPejabatPengadaan::All();
		$pegawai = \Modules\Pegawai\Entities\Pegawai::where('nama', @$po->user)->first();
		// return compact('po', 'data', 'no', 'pejabat'); die;

		$cek_obat = \App\Kategoriobat::where('id', $po->kategori_obat)->first();
		if ($cek_obat->nama == 'Prekursor') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_prekursor', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} elseif ($cek_obat->nama == 'Psikotropika') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_psikotropika', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} elseif ($cek_obat->nama == 'Narkotika') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_narkotika', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} elseif ($cek_obat->nama == 'Obat Tertentu') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_obat_tertentu', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} else {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		}
		return $pdf->stream();
	}


	function cetakPO_new($supplier, $tanggal)
	{
		// return $supplier; die;
		if (strpos($supplier, '_')) {
			$supplier = str_replace('_', '/', $supplier);
		}
		$po = Po::where('no_po', $supplier)->first();
		$data = Po::where('no_po', $supplier)->where('verifikasi', 'Y')->get();
		$no = 1;
		$pejabat = \App\LogistikPejabatPengadaan::All();
		$pegawai = \Modules\Pegawai\Entities\Pegawai::where('nama', @$po->user)->first();
		// return compact('po', 'data', 'no', 'pejabat'); die;

		$cek_obat = \App\Kategoriobat::where('id', $po->kategori_obat)->first();
		if ($cek_obat->nama == 'Prekursor') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_prekursor', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} elseif ($cek_obat->nama == 'Psikotropika') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_psikotropika', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} elseif ($cek_obat->nama == 'Narkotika') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_narkotika', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} elseif ($cek_obat->nama == 'Obat Tertentu') {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi_obat_tertentu', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		} else {
			$pdf = PDF::loadView('logistik.logistikmedik.po.kuitansi', compact('po', 'data', 'no', 'pejabat', 'pegawai'));
		}
		return $pdf->stream();
	}





	public function tutupTransaksi(Request $request)
	{
		// return request()->all();
		$status = $request['status'];
		foreach ($status as $d) {
			$data = Po::where('no_po', $d)->get();
			foreach ($data as $d) {
				$po = Po::find($d->id);
				$po->status = 'close';
				$po->update();
			}
		}
		Flashy::success('Berhasil Tutup Transaksi Po !');
		return response()->json(['sukses' => true]);
	}

	public function lap_po()
	{
		$data['po'] = Po::where('created_at', 'LIKE', date('Y-m-d') . '%')
			->where('status', 'close')
			->distinct()
			->get(['no_po', 'supplier', 'tanggal']);
		return view('logistik.logistikmedik.po.lap_po', $data)->with('no', 1);
	}

	public function lap_po_bytanggal(Request $request)
	{
		$data['po'] = Po::where('status', 'close')
			->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			->distinct()
			->get(['no_po', 'supplier', 'tanggal']);
		if ($request['lanjut']) {
			return view('logistik.logistikmedik.po.lap_po', $data)->with('no', 1);
		} else if ($request['pdf']) {
			if ($data['po']) {
				return view('logistik.logistikmedik.po.lap_po_pdf', $data)->with('no', 1);
			} else {
				return view('logistik.logistikmedik.po.lap_po', $data)->with('no', 1);
			}
		}
	}

	public function lap_pendapatan()
	{
		// $data['reg'] = \Modules\Registrasi\Entities\Registrasi::where('jenis_pasien', '!=', 1)
		// 	->where('created_at', 'LIKE', date('2019-01-10') . '%')
		// 	->distinct()
		// 	->get(['id']);
		// return $data; die;
		return view('logistik.logistikmedik.laporan.lap-pendapatan-pasien-perdepo')->with('no', 1);
	}

	public function lap_pendapatan_bytanggal(Request $request)
	{
		$data['reg'] = \Modules\Registrasi\Entities\Registrasi::leftJoin('users', 'registrasis.user_create', '=', 'users.id')
			->where('users.gudang_id', $request['gudang'])
			->where('registrasis.jenis_pasien', '!=', 1)
			->whereBetween('registrasis.created_at', [valid_date($request['tgl_awal']) . ' 00:00:00', valid_date($request['tgl_akhir']) . ' 23:59:59'])
			->distinct()
			->get(['registrasis.id', 'registrasis.pasien_id']);
		// return $data; die;
		return view('logistik.logistikmedik.laporan.lap-pendapatan-pasien-perdepo', $data)->with('no', 1);
	}

	public function lap_pendapatan_bpjs()
	{
		// $data['reg'] = \Modules\Registrasi\Entities\Registrasi::where('jenis_pasien', '!=', 1)
		// 	->where('created_at', 'LIKE', date('2019-01-10') . '%')
		// 	->distinct()
		// 	->get(['id']);
		// return $data; die;
		return view('logistik.logistikmedik.laporan.lap-pendapatan-pasien-bpjs')->with('no', 1);
	}

	public function lap_pendapatan_bpjs_bytanggal(Request $request)
	{
		$data['reg'] = \Modules\Registrasi\Entities\Registrasi::where('jenis_pasien', '=', 1)
			// ->where('users.gudang_id', $request['gudang'])
			->whereBetween('created_at', [valid_date($request['tgl_awal']) . ' 00:00:00', valid_date($request['tgl_akhir']) . ' 23:59:59'])
			->distinct()
			->get(['id', 'pasien_id']);
		// return $data; die;
		if ($request['lanjut']) {
			return view('logistik.logistikmedik.laporan.lap-pendapatan-pasien-bpjs', $data)->with('no', 1);
		} elseif ($request['pdf']) {
			// return $pemakaian; die;
			$pdf = PDF::loadView('logistik.logistikmedik.laporan.pdf_pendapatan_pasien_bpjs', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->download('Pendapatan Pasien BPJS' . date('Y-m-d') . '.pdf');
		} elseif ($request['excel']) {
			Excel::create('Lap Pendapatan Pasien BPJS ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Lap Pendapatan Pasien BPJS ')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Pendapatan Pasien BPJS ');
				$excel->sheet('Lap Pendapatan Pasien BPJS ', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$registrasi = $data['reg'];
					$sheet->row($row, [
						'No',
						'Nama',
						'Jumlah',
					]);
					foreach ($registrasi as $key => $d) {
						$pendapatan = number_format(\Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('tarif_id', 10000)->sum('total'));
						$sheet->row(++$row, [
							$no++,
							!empty($d->pasien_id) ? baca_pasien($d->pasien_id) : '',
							$pendapatan,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function lap_pendapatan_bebas()
	{
		// $data['reg'] = \Modules\Registrasi\Entities\Registrasi::where('jenis_pasien', '!=', 1)
		// 	->where('created_at', 'LIKE', date('2019-01-10') . '%')
		// 	->distinct()
		// 	->get(['id']);
		// return $data; die;
		return view('logistik.logistikmedik.laporan.lap-pendapatan-pasien-bebas')->with('no', 1);
	}

	public function lap_pendapatan_bebas_bytanggal(Request $request)
	{
		$data['reg'] = \Modules\Registrasi\Entities\Registrasi::where('pasien_id', '=', 0)
			// ->where('users.gudang_id', $request['gudang'])
			->whereBetween('created_at', [valid_date($request['tgl_awal']) . ' 00:00:00', valid_date($request['tgl_akhir']) . ' 23:59:59'])
			->distinct()
			->get(['id']);
		// return $data; die;
		if ($request['lanjut']) {
			return view('logistik.logistikmedik.laporan.lap-pendapatan-pasien-bebas', $data)->with('no', 1);
		} elseif ($request['pdf']) {
			// return $pemakaian; die;
			$pdf = PDF::loadView('logistik.logistikmedik.laporan.pdf_pendapatan_pasien_bebas', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->download('Lap Pendapatan Pasien Bebas ' . date('Y-m-d') . '.pdf');
		} elseif ($request['excel']) {
			Excel::create('Lap Pendapatan Pasien Bebas ', function ($excel) use ($data) {
				// Set the properties
				$excel->setTitle('Lap Pendapatan Pasien Bebas ')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Pendapatan Pasien Bebas ');
				$excel->sheet('Lap Pendapatan Pasien Bebas ', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$registrasi = $data['reg'];
					$sheet->row($row, [
						'No',
						'Nama',
						'Jumlah',
					]);
					foreach ($registrasi as $key => $d) {
						$pendapatan = number_format(\Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('tarif_id', 10000)->sum('total'));
						$sheet->row(++$row, [
							$no++,
							!empty($d->pasien_id) ? baca_pasien($d->pasien_id) : '',
							$pendapatan,
						]);
					}
				});
			})->export('xlsx');
		}
	}

	public function verif_pphp(Request $request)
	{
		$status = $request['id'];
		foreach ($status as $d) {
			$data = Po::where('id', $d)->get();
			foreach ($data as $d) {
				$po = Po::find($d->id);
				$po->verif_pphp = 'Y';
				$po->update();
			}
		}
		Flashy::success('Berhasil Verifikasi Transaksi Po !');
		return response()->json(['sukses' => true]);
	}

	public function verifPO(Request $request)
	{
		// return request()->all();
		$cek = Po::find($request['id']);
		$cek->verifikasi = 'Y';
		$cek->jumlah_verif = $request['jumlah'];
		$cek->update();

		$journal = Journal::create([
			'id_customer'		=> 0,
			'contact_type'		=> 'supplier',
			'code'				=> $cek->no_po,
			'tanggal'			=> date('Y-m-d'),
			'total_transaksi'	=> rupiah($cek->barang->hargabeli * $request['jumlah']),
			'type'				=> 'verifikasi_obat',
			'keterangan'		=> 'Jurnal Pembelian Obat PO ' . $cek->no_po,
			'verifikasi'		=> 1
		]);

		$akunMasterObat = AkunCOA::where('code', '101301001')->first();
		if (!empty($cek->barang->akutansi_akun_coa_id)) {
			$akunMasterObat = AkunCOA::where('id', $cek->barang->akutansi_akun_coa_id)->first();
		}
		$journalDetail[] = JournalDetail::create([
			'id_journal'		=> $journal->id,
			'id_akun_coa'		=> $akunMasterObat->id,
			'debit'				=> (int) rupiah($cek->barang->hargabeli * $request['jumlah']),
			'credit'			=> 0,
			'is_operasional'	=> 0,
			'type'				=> 'verifikasi_obat',
			'keterangan'		=> 'Jurnal Pembelian Obat ' . $cek->no_po . ' Akun ' . $akunMasterObat->nama
		]);

		$akunSementaraKas = AkunCOA::where('code', '101109099')->first();
		$journalDetail[] = JournalDetail::create([
			'id_journal'		=> $journal->id,
			'id_akun_coa'		=> $akunSementaraKas->id,
			'debit'				=> 0,
			'credit'			=> (int) rupiah($cek->barang->hargabeli * $request['jumlah']),
			'is_kas_bank'		=> 1,
			'type'				=> 'verifikasi_obat',
			'keterangan'		=> 'Jurnal Pembelian Obat ' . $cek->no_po . ' Akun ' . $akunSementaraKas->nama
		]);

		Flashy::success('PO Terverfikasi !');
		return response()->json(['sukses' => true]);
	}
	public function cancelPO(Request $request)
	{
		$cek = Po::find($request['id']);
		$cek->verifikasi = 'N';
		$cek->update();
		Flashy::success('Cancel Berhasil !');
		return response()->json(['sukses' => true]);
	}

	public function cencelpo(Request $request)
	{
		$cek = Po::find($request['id']);
		$cek->status_po = 'cencel';
		$cek->update();
		return response()->json(['sukses' => true]);
	}

	public function ubahjumlah(Request $request)
	{
		$obat = Po::where('id', $request['id'])->first();
		if (!empty(\App\Logistik\LogistikStock::where('gudang_id', 1)->where('masterobat_id', $obat->masterobat_id)->latest()->first()->total)) {
			$cek = \App\Logistik\LogistikStock::where('gudang_id', 1)->where('masterobat_id', $obat->masterobat_id)->latest()->first()->total;
		} else {
			$cek = 0;
		}
		if ($request['jumlah']) {
			# code...
			$po = Po::where('id', $request['id'])->first();
			$po->jumlah = $request['jumlah'];
			$po->totalHarga = $request['jumlah'] * $po->harga;
			$po->update();
			return response()->json(['sukses' => true]);
		} else {
			return response()->json(['sukses' => false]);
		}
	}




	public function ubahPpn(Request $request)
	{


		$poAwal = Po::where('no_po', $request['no_po'])->get();
		foreach ($poAwal as $po) {
			$poFinal = Po::find($po->id);
			$poFinal->ppn = $request['ppn'];
			$poFinal->jml_ppn = $request['jml_ppn'];
			$poFinal->update();
		}
		$poFix =  Po::where('no_po', $request['no_po'])->first();
		return response()->json(['sukses' => true, 'po' => $poFix]);
	}











	function hapusPO($no_po, $tanggal)
	{
		if (strpos($no_po, '_')) {
			$no_po = str_replace('_', '/', $no_po);
		}

		$data = Po::where('no_po', $no_po)->where('tanggal', $tanggal)->delete();

		Flashy::success('Berhasil Hapus Transaksi Po !');
		return redirect('logistikmedik/po');
	}

	public function verifstatuspo(Request $request)
	{
		$verifpphp = Po::find($request['id']);
		$verifpphp->status_po = 'Y';
		$verifpphp->update();
		return response()->json(['sukses' => true]);
	}

	public function listPo($id)
	{
		$data['verif'] = Po::find($id);
		$obat  = \App\Masterobat::where('id', $data['verif']->masterobat_id)->first();
		$supplier = \App\Logistik\LogistikSupplier::where('nama', $data['verif']->supplier)->first();
		$spk = \App\Logistik\LogistikSpk::where('no_po', $data['verif']->no_po)->first();
		$cek	= \App\Logistik\Logistik_BAPB::where('no_po', $data['verif']->no_po)->count();
		if ($cek > 0) {
			$data['bapb']	= \App\Logistik\Logistik_BAPB::where('no_po', $data['verif']->no_po)->first();
		} else {
			$data['bapb']	= 'kosong';
		}

		$cek = \App\Logistik\LogistikSpk::count();
		if ($cek >= 0) {
			$cekUrutan = 0000;
		} else {
			$cekUrutan = explode('/', DB::table('logistik_spks')
				->latest()
				->first()->nomor);
		}
		$noAwal = '019/';
		$data['nomorSPk'] = null;
		if (isset($cekUrutan[1])) {
			$data['nomorSPk'] = $noAwal . sprintf("%04s", abs($cekUrutan[1] + 1)) . '/PLK';
		}

		$cekbapb = \App\Logistik\Logistik_BAPB::count();
		if ($cekbapb == 0) {
			$cekUrutanbapb = 0000;
		} else {
			$cekUrutanbapb = explode('/', DB::table('logistik_bapbs')
				->latest()
				->first()->no_bapb);
		}
		$noAwalbapb = '020/';
		$data['nomorBAPB'] = $noAwalbapb . sprintf("%04s", abs($cekUrutanbapb[1] + 1)) . '/PLK';

		if (Auth::user()->hasRole('verifikatorlogistik')) {
			$data['belum_verif']    = Po::leftJoin('masterobats', 'logistik_po.masterobat_id', '=', 'masterobats.id')
				->leftJoin('satuanbelis', 'logistik_po.satuan', '=', 'satuanbelis.id')
				->where('logistik_po.no_po', $data['verif']->no_po)
				->where('verifikasi', 'B')
				->select('logistik_po.*', 'masterobats.nama', 'satuanbelis.nama as nama_satuan')
				->get();

			$data['verif']    = Po::leftJoin('masterobats', 'logistik_po.masterobat_id', '=', 'masterobats.id')
				->leftJoin('satuanbelis', 'logistik_po.satuan', '=', 'satuanbelis.id')
				->where('logistik_po.no_po', $data['verif']->no_po)
				->where('verifikasi', '<>', 'B')
				->select('logistik_po.*', 'masterobats.nama', 'satuanbelis.nama as nama_satuan')
				->get();
		} else {

			$data['verif']    = Po::leftJoin('masterobats', 'logistik_po.masterobat_id', '=', 'masterobats.id')
				->leftJoin('satuanbelis', 'logistik_po.satuan', '=', 'satuanbelis.id')
				->where('logistik_po.no_po', $data['verif']->no_po)
				->select('logistik_po.*', 'masterobats.nama', 'satuanbelis.nama as nama_satuan')
				->get();
		}

		// return $data; die;
		return view('logistik.logistikmedik.po.listPo', $data);
	}

	public function cek_po($id)
	{
		$verif = Po::find($id);
		$obat  = \App\Masterobat::where('id', $verif->masterobat_id)->first();
		$supplier = \App\Logistik\LogistikSupplier::where('nama', $verif->supplier)->first();
		$spk = \App\Logistik\LogistikSpk::where('no_po', $verif->no_po)->first();
		// return $spk; die;
		if (!empty(\App\Logistik\LogistikPenerimaan::where('no_po', $verif->no_po)->first()->hpp)) {
			$listpenerimaan = \App\Logistik\LogistikPenerimaan::where('no_po', $verif->no_po)->get();
		} else {
			$listpenerimaan = [];
		}
		if (!empty(\App\Logistik\LogistikPenerimaan::where('no_po', $verif->no_po)->first()->hpp)) {
			$totalpenerimaan = \App\Logistik\LogistikPenerimaan::where('no_po', $verif->no_po)->sum('hpp');
		} else {
			$totalpenerimaan = 0;
		}
		$cek	= \App\Logistik\Logistik_BAPB::where('no_po', $verif->no_po)->count();
		if ($cek > 0) {
			$bapb	= \App\Logistik\Logistik_BAPB::where('no_po', $verif->no_po)->first();
		} else {
			$bapb	= 'kosong';
		}

		$cek = \App\Logistik\LogistikSpk::count();
		if ($cek == 0) {
			$cekUrutan = 0000;
		} else {
			$cekUrutan = explode('/', DB::table('logistik_spks')
				->latest()
				->first()->nomor);
		}
		$noAwal = '019/';
		$nomorSPk = $noAwal . sprintf("%04s", abs($cekUrutan[1] + 1)) . '/PLK';

		$cekbapb = \App\Logistik\Logistik_BAPB::count();
		if ($cekbapb == 0) {
			$cekUrutanbapb = 0000;
		} else {
			$cekUrutanbapb = explode('/', DB::table('logistik_bapbs')
				->latest()
				->first()->no_bapb);
		}
		$noAwalbapb = '020/';
		$nomorBAPB = $noAwalbapb . sprintf("%04s", abs($cekUrutanbapb[1] + 1)) . '/PLK';

		$po    = Po::leftJoin('masterobats', 'logistik_po.masterobat_id', '=', 'masterobats.id')
			->leftJoin('satuanbelis', 'logistik_po.satuan', '=', 'satuanbelis.id')
			->where('logistik_po.no_po', $verif->no_po)
			->select('logistik_po.*', 'masterobats.nama', 'satuanbelis.nama as nama_satuan')
			// ->distinct('logistik_po.id')
			->get();

		$penerimaan    = Po::leftJoin('masterobats', 'logistik_po.masterobat_id', '=', 'masterobats.id')
			->leftJoin('satuanbelis', 'logistik_po.satuan', '=', 'satuanbelis.id')
			// ->leftJoin('logistik_bapbs', 'logistik_po.no_po', '=', 'logistik_bapbs.no_po')
			->where('logistik_po.no_po', $verif->no_po)
			->where('logistik_po.verif_pphp', 'Y')
			->select('logistik_po.*', 'masterobats.nama', 'satuanbelis.nama as nama_satuan')
			->distinct('logistik_po.id')
			->get(['logistik_po.id']);
		return response()->json(['sukses' => true, 'verif' => $verif, 'obat' => $obat, 'po' => $po, 'supplier' => $supplier, 'nomor' => $nomorSPk, 'nomorbapb' => $nomorBAPB, 'listSpk' => $spk, 'penerimaan' => $penerimaan, 'bapb' => $bapb, 'listpenerimaan' => $listpenerimaan, 'totalpenerimaan' => $totalpenerimaan, 'terbilangtotalpenerimaan' => terbilang($totalpenerimaan)]);
	}
}
