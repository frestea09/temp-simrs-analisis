<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use PDF;
use Yajra\DataTables\DataTables;
use App\Logistik\LogistikPermintaan;
use App\Logistik\LogistikStock;
use App\Masterobat;
use App\Logistik\LogistikGudang;
use App\LogistikOpname;
use App\LogistikBatch;
use DB;
use Flashy;

class LogistikPermintaanController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		session()->forget('nomor');
		$date = date('Y-m-d', strtotime('-5 days'));

		$data = LogistikPermintaan::distinct()
		->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
		->where('gudang_asal', Auth::user()->gudang_id)->get(['nomor']);
		
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.permintaan.index', compact('data'))->with('no', 1);
		}
	}


	public function permintaanFilter(Request $request) {
		// session()->forget('nomor');
		// $date = date('Y-m-d', strtotime('-5 days'));

		$tga = $request['tga'] ? valid_date($request['tga']) : NULL;
		$tgb = $request['tgb'] ? valid_date($request['tgb']) : NULL;

		$data = LogistikPermintaan::distinct()
		->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])
		->where('gudang_asal', Auth::user()->gudang_id)->get(['nomor']);
		
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.permintaan.index', compact('data'))->with('no', 1);
		}
	}












	public function cekStokGudangAsal($masterobat_id, $gudang_asal_id = null) {
		if ($gudang_asal_id) {
			$stok = LogistikBatch::where('masterobat_id', $masterobat_id)->where('gudang_id', $gudang_asal_id)->sum('stok');
		} else {
			$stok = LogistikBatch::where('masterobat_id', $masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->sum('stok');
		}
		// $stok = LogistikOpname::where('obat_id', $masterobat_id)->where('gudang', Auth::user()->gudang_id)->orderBy('id', 'desc')->first();
		// $stok = LogistikStock::where('masterobat_id', $masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->orderBy('id', 'desc')->first();
		return response()->json($stok);
	}

	public function cekStokGudangTujuan($masterobat_id, $gudang_tujuan_id)
	{
		$stok = LogistikBatch::where('masterobat_id', $masterobat_id)->where('gudang_id', $gudang_tujuan_id)->sum('stok');
		return response()->json($stok);
	}

	public function cekSatuanBarang($masterobat_id)
	{
		$barang = \App\Masterobat::join('satuanjuals', 'masterobats.satuanjual_id', '=', 'satuanjuals.id')
		->where('masterobats.id', $masterobat_id)->select('satuanjuals.nama')->first();
		return response()->json($barang);
	}

	function dataPermintaan() {
		$data = LogistikPermintaan::where('gudang_asal', Auth::user()->gudang_id)->where('nomor', session('nomor'))->get();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('barang', function ($data) {
				return \App\Masterobat::find($data->masterobat_id)->nama;
			})
			->addColumn('harga', function ($data) {
				return \App\Masterobat::find($data->masterobat_id)->hargajual;
			})
			->addColumn('tanggal', function ($data) {
				return tgl_indo($data->tanggal_permintaan);
			})
			->addColumn('Jumlah', function ($data) {
				return '
                <input type="number" style="width: 30%" class="form-control text-center" name="jumlah_order' . $data->id . '" value="' . $data->jumlah_permintaan . '" onchange="editOrder(\'' . $data->id . '\')">';
			})
			->addColumn('user', function ($data) {
				return \App\User::find($data->user_id)->name;
			})
			->addColumn('hapus', function ($data) {
				return '<button type="button" onclick="hapusPermintaan(' . $data->id . ')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus', 'Jumlah'])
			->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		$cekUrutan = LogistikPermintaan::where('gudang_asal', Auth::user()->gudang_id)->count();
		// return str_replace(' ', '-', baca_gudang_logistik(Auth::user()->gudang_id));
		$nomor =  str_replace(' ', '-', baca_gudang_logistik(Auth::user()->gudang_id)) . '-' . sprintf("%05s", abs($cekUrutan + 1));

		$data['nomor'] = $nomor;
		$data['barang'] = Masterobat::select('id', 'nama')->get();
		$data['gudang'] = LogistikGudang::all();
		$data['user_gudang'] = LogistikGudang::find(Auth::user()->gudang_id)->nama;
		// return $cekUrutan; die;
		return view('logistik.logistikmedik.permintaan.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		session([
			'nomor' => $request['nomor'],
		]);
		$pm = new LogistikPermintaan();
		$pm->nomor = $request['nomor'];
		$pm->tanggal_permintaan = valid_date($request['tanggal']);
		$pm->gudang_asal = $request->gudang_asal_id ?? Auth::user()->gudang_id;
		$pm->gudang_tujuan = $request['gudang_tujuan'];
		$pm->masterobat_id = $request['masterobat_id'];
		$pm->jumlah_permintaan = $request['jumlah_permintaan'];
		$pm->sisa_stock = $request['sisa_stock'] ? $request['sisa_stock'] : 0;
		$pm->keterangan = $request['keterangan'];
		$pm->user_id = Auth::user()->id;
		$pm->save();
		if ($pm) {
			return response()->json(['sukses' => true, 'message' => 'Permintaan berhasil disimpan']);
		}
	}

	function hapusPermintaan($id) {
		$pm = LogistikPermintaan::find($id);
		$pm->delete();
		if ($pm) {
			return response()->json(['sukses' => true, 'message' => 'Permintaan berhasil dihapus']);
		}
	}

	public function edit_permintaan($nomor)
	{
		session()->forget('nomor');
		$data['permintaan'] = LogistikPermintaan::where('nomor', $nomor)->first();
		$data['list'] = LogistikPermintaan::where('nomor', $nomor)->get();

		if (!session('nomor')) {
			session(['nomor' => LogistikPermintaan::where('nomor', $nomor)->first()->nomor]);
		}
		
		$data['barang'] = Masterobat::select('id', 'nama')->get();
		$data['gudang'] = LogistikGudang::where('id', $data['permintaan']->gudang_tujuan)->first();
		$data['user_gudang'] = LogistikGudang::find(Auth::user()->gudang_id)->nama;
		// return session('nomor'); die;
		return view('logistik.logistikmedik.permintaan.edit', $data);
	}

	function hapus_permintaan($nomor)
	{
		$data = LogistikPermintaan::where('nomor', $nomor)->delete();

		Flashy::success('Berhasil Hapus Transaksi Permintaan !');
		return redirect('logistikmedik/permintaan');
	}

	public function cetakPermintaan($nomor) {
		$gudang = LogistikPermintaan::distinct()->where('nomor', $nomor)->first();
		$data = LogistikPermintaan::where('nomor', $nomor)->get();
		$no = 1;
		$pdf = PDF::loadView('logistik.logistikmedik.permintaan.kuitansi', compact('data', 'no', 'gudang','nomor'));
		return $pdf->stream();
	}

	public function prosesCheck($id) {
		// dd($nomor);
		$permintan = LogistikPermintaan::find($id);
		$permintan->proses_gudang = 1;
		$permintan->update();
		return response()->json(['sukses' => true]);
	}
	public function ubahqty(Request $request)
	{
		$permintan = LogistikPermintaan::where('id', $request['id'])->first();
		$permintan->jumlah_permintaan = $request['jumlah_order'];
		$permintan->update();
		return response()->json(['sukses' => true]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	//GUDANG PUSAT
}
