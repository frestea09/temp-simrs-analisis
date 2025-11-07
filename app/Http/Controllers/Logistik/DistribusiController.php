<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\LogistikBatch;
use Auth;
use Illuminate\Http\Request;
use PDF;
use DB;
use Flashy;
use Carbon\Carbon;
use App\Logistik\LogistikPermintaan;
use App\Logistik\LogistikStock;
use App\Masterobat;
use App\LogistikGudang;
use Yajra\DataTables\DataTables;

class DistribusiController extends Controller
{

	public function transferPermintaan()
	{

		$date = date('Y-m-d', strtotime('-2 days'));
		$data = \App\Logistik\LogistikPermintaan::distinct()
			->whereBetween('created_at', [$date . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
			->where('gudang_tujuan', Auth::user()->gudang_id)
			// ->where('status', '0')
			->orderBy('created_at', 'DESC')
			->distinct('nomor')
			->groupBy('nomor')
			->get(['nomor', 'tanggal_permintaan', 'status', 'gudang_asal', 'gudang_tujuan', 'id', 'proses_gudang', 'keterangan']);
		if (Auth::user()->gudang_id == NULL) {
			Flashy::success('Anda Tidak Punya Akses Ke Gudang!!');
			return redirect()->back();
		} else {
			return view('logistik.logistikmedik.distribusi.transferPermintaan', compact('data'))->with('no', 1);
		}
	}

	public function transferPermintaanBytanggal(Request $request)
	{
		request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'], ['tgl_awal.required' => 'Harap Diisi, Jangan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!']);

		$awal  = valid_date($request['tgl_awal']);
		$akhir = valid_date($request['tgl_akhir']);

		$data = \App\Logistik\LogistikPermintaan::distinct()
			->whereBetween('created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
			->where('gudang_tujuan', Auth::user()->gudang_id)
			// ->where('status', '0')
			->orderBy('created_at', 'DESC')
			->groupBy('nomor')
			->get(['nomor', 'tanggal_permintaan', 'status', 'gudang_asal', 'gudang_tujuan', 'id', 'proses_gudang', 'keterangan']);
		return view('logistik.logistikmedik.distribusi.transferPermintaan', compact('data'))->with('no', 1);
	}

	public function transferPermintaanEdit($nomor)
	{
		session()->forget('nomor');
		$data['permintaan'] = LogistikPermintaan::where('nomor', $nomor)->first();
		$data['list'] = LogistikPermintaan::where('nomor', $nomor)->get();

		if (!session('nomor')) {
			session(['nomor' => LogistikPermintaan::where('nomor', $nomor)->first()->nomor]);
		}

		$data['barang'] = Masterobat::select('id', 'nama')->get();
		$data['gudang'] = LogistikGudang::where('id', $data['permintaan']->gudang_tujuan)->first();
		// return session('nomor'); die;
		return view('logistik.logistikmedik.distribusi.editPermintaan', $data);
	}

	public function dataPermintaanEdit()
	{
		$data = LogistikPermintaan::where('nomor', session('nomor'))->get();
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

	public function prosesTransfer($nomor)
	{
		$gudang = LogistikPermintaan::where('nomor', $nomor)->first();
		$data = LogistikPermintaan::where('nomor', $nomor)->get();
		$no_stok = 1;
		$no_barang = 1;
		$no_dikirim = 1;
		$no_permintaan = 1;
		$no_cek = 1;
		return view('logistik.logistikmedik.distribusi.formProsesTransferPermintaan', compact('data', 'gudang', 'no_stok', 'no_barang', 'no_dikirim', 'no_permintaan', 'no_cek'))->with('no', 1);
	}




	public function hapusTransfer($id)
	{

		$gudang = \App\Logistik\LogistikPermintaan::find($id);
		$gudang->delete();
		return response()->json(['sukses' => true]);
	}










	public function viewTransfer($id)
	{
		$permintaan = LogistikPermintaan::find($id);
		$nama_obat	= baca_obat($permintaan->masterobat_id);
		$batches = LogistikBatch::where('masterobat_id', $permintaan->masterobat_id)->where('gudang_id', $permintaan->gudang_tujuan)->where('stok', '!=', 0)->get();
		$jumlah_permintaan = LogistikPermintaan::find($id);
		$stok_pusat		= LogistikStock::where('masterobat_id', $permintaan->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
		return response()->json(['permintaan' => $permintaan, 'nama_obat' => $nama_obat, 'stok_pusat' => $stok_pusat, 'nama_obat' => $nama_obat, 'batches' => $batches]);
	}

	public function viewTransferBaru($id)
	{
		$permintaan = \App\Logistik\LogistikPermintaan::find($id);
		$batches = \App\LogistikBatch::where('masterobat_id', $permintaan->masterobat_id)->where('gudang_id', $permintaan->gudang_tujuan)->where('stok', '!=', 0)->get();
		$nama_obat	= baca_obat($permintaan->masterobat_id);
		$jumlah_permintaan = \App\Logistik\LogistikPermintaan::find($id);
		$stok_pusat		= \App\Logistik\LogistikStock::where('masterobat_id', $permintaan->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total;
		// return compact('batches', 'permintaan', 'nama_obat', 'jumlah_permintaan', 'stok_pusat'); die;
		return view('logistik.logistikmedik.distribusi.DetailTransferPermintaan', compact('batches', 'permintaan', 'nama_obat', 'jumlah_permintaan', 'stok_pusat', 'jumlah_permintaan'));
	}

	public function saveProsesTransfer(Request $request, $id)
	{
		// dd(LogistikBatch::find($id));
		// return $request->all(); die;
		DB::transaction(function () use ($request, $id) {
			$dikirim = $request['jumlah_dikirim' . $id . ''];
			if (LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', $request['gudang_asal'])->count() > 0) {
				$total_depo = LogistikStock::where('masterobat_id', $request['masterobat_id'])
					->where('gudang_id', $request['gudang_asal'])
					->orderBy('id', 'DESC')
					->first()->total;
			} else {
				$total_depo = LogistikBatch::where('masterobat_id', $request['masterobat_id'])
					->where('gudang_id', $request['gudang_asal'])
					->sum('stok');
				}
			//Masuk Depo
			$gudang_tujuan = LogistikGudang::where('id', $request['gudang_tujuan'])->first();

			$depo = new LogistikStock();
			$depo->gudang_id = $request['gudang_asal'];
			$depo->supplier_id = 0;
			$depo->periode_id = NULL;
			$depo->masterobat_id = $request['masterobat_id'];
			$depo->logistik_batch_id = $id;
			$depo->batch_no = '';
			$depo->expired_date = date('Y-m-d');
			$depo->periode_id = date('m');
			$depo->masuk = $dikirim;
			$depo->keluar = 0;
			$depo->total = $total_depo + $dikirim;
			$depo->keterangan = 'Transfer dari gudang pusat tanggal ' . $gudang_tujuan->nama . date('d-m-Y');
			$depo->save();


			if (LogistikStock::where('masterobat_id', $request['masterobat_id'])->where('gudang_id', $request['gudang_tujuan'])->count() > 0) {
				$total_gudang = LogistikStock::where('masterobat_id', $request['masterobat_id'])
					->where('gudang_id', $request['gudang_tujuan'])
					->orderBy('id', 'DESC')
					->first()
					->total;
			} else {
				$total_gudang = LogistikBatch::where('masterobat_id', $request['masterobat_id'])
					->where('gudang_id', $request['gudang_tujuan'])
					->sum('stok');
			}

			$gudang_asal = LogistikGudang::where('id', $request['gudang_asal'])->first();

			$gudang = new LogistikStock();
			$gudang->gudang_id = $request['gudang_tujuan'];
			$gudang->supplier_id = 0;
			$gudang->periode_id = NULL;
			$gudang->masterobat_id = $request['masterobat_id'];
			$gudang->logistik_batch_id = $id;
			$gudang->batch_no = '';
			$gudang->expired_date = date('Y-m-d');
			$gudang->masuk = 0;
			$gudang->periode_id = date('m');
			$gudang->keluar = $dikirim;
			$gudang->total = $total_gudang - $dikirim;
			$gudang->keterangan = 'Transfer ke Depo ' . $gudang_asal->nama . '  tanggal ' . date('d-m-Y');
			$gudang->save();

			$cek = LogistikBatch::where('id', $id)->first();
			if (LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_asal'])->count() > 0) {
				$total_stok_depo_asal = LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_asal'])->first()->stok;
			} else {
				$total_stok_depo_asal = 0;
			}

			if (LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_tujuan'])->count() > 0) {
				$total_stok_depo_tujuan = LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_tujuan'])->first()->stok;
			} else {
				$total_stok_depo_tujuan = 0;
			}

			//Masuk Depo asal FARMASI
			if (LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_asal'])->count() > 0) {
				$depo = LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_asal'])->first();
				$depo->stok = $total_stok_depo_asal + $dikirim;
				$depo->nama_obat = $cek->nama_obat;
				$depo->updated_at = Carbon::now();
				$depo->update();
			} else {
				$depo = new LogistikBatch();
				$depo->masterobat_id = $request['masterobat_id'];
				$depo->nomorbatch = $cek->nomorbatch;
				$depo->nama_obat = $cek->nama_obat;
				$depo->bapb_id = 0;
				$depo->jumlah_item_diterima = 0;
				$depo->stok = $dikirim;
				$depo->satuanbeli_id = $cek->satuanbeli_id;
				$depo->satuanjual_id = $cek->satuanjual_id;
				$depo->gudang_id = $request['gudang_asal'];
				$depo->supplier_id = 0;
				$depo->user_id = Auth::user()->id;
				$depo->expireddate = $cek->expireddate;
				$depo->hargabeli = $cek->hargabeli;
				$depo->hargajual_jkn = $cek->hargajual_jkn;
				$depo->hargajual_umum = $cek->hargajual_umum;
				$depo->hargajual_dinas = $cek->hargajual_dinas;
				$depo->save();
			}

			//Masuk Depo tujuan GUDANG
			if (LogistikBatch::where('masterobat_id', $cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_tujuan'])->count() > 0) {
				// $depo = LogistikBatch::where('masterobat_id',$cek->masterobat_id)->where('nomorbatch', $cek->nomorbatch)->where('gudang_id', $request['gudang_tujuan'])->first();
				$depo = LogistikBatch::find($id);
				$depo->stok = $depo->stok - $dikirim;
				$depo->nama_obat = $cek->nama_obat;
				$depo->updated_at = Carbon::now();
				$depo->update();
			} else {
				$depo = new LogistikBatch();
				$depo->masterobat_id = $request['masterobat_id'];
				$depo->nomorbatch = $cek->nomorbatch;
				$depo->nama_obat = $cek->nama_obat;
				$depo->bapb_id = 0;
				$depo->jumlah_item_diterima = 0;
				$depo->stok = $dikirim;
				$depo->satuanbeli_id = $cek->satuanbeli_id;
				$depo->satuanjual_id = $cek->satuanjual_id;
				$depo->gudang_id = $request['gudang_tujuan'];
				$depo->supplier_id = 0;
				$depo->user_id = Auth::user()->id;
				$depo->expireddate = $cek->expireddate;
				$depo->hargabeli = $cek->hargabeli;
				$depo->hargajual_jkn = $cek->hargajual_jkn;
				$depo->hargajual_umum = $cek->hargajual_umum;
				$depo->hargajual_dinas = $cek->hargajual_dinas;
				$depo->save();
			}

			$opname_id = 0;
			$cek = LogistikPermintaan::where('nomor', $request['nomor_permintaan'])->where('masterobat_id', $request['masterobat_id'])->first();
			$pm = LogistikPermintaan::find($cek->id);
			$pm->status = 0;
			$pm->terkirim = $cek->terkirim + $dikirim;
			$pm->sisa_stock = $cek->sisa_stock + $dikirim;
			$pm->update();
			$opname_id = $cek->id;
			// }
		});
		// return die;
		// return $request['jumlah_dikirim']; die;
		return response()->json(['sukses' => true]);
	}

	public function cetakTransferStok($nomor)
	{
		$namaGudang = LogistikPermintaan::distinct()->where('nomor', $nomor)->first();
		$data = LogistikPermintaan::with('barang')->where('nomor', $nomor)->get();
		$no = 1;
		
		foreach($data as $key => $d){
			$stok = LogistikStock::where('gudang_id', Auth::user()->gudang_id)
				->where('masterobat_id', $d->masterobat_id)
				->select('total')
				->orderBy('id', 'DESC')
				->first();

			$data[$key]['stokGudangAsal'] = !empty($stok) ? $stok->total : 0;
			
		}
		// dd($data);

		// $pdf = PDF::loadView('logistik.logistikmedik.distribusi.kuitansiTransfer', compact('data', 'no', 'namaGudang'));
		// return $pdf->stream();
		return view('logistik.logistikmedik.distribusi.kuitansiTransfer', compact('data', 'no', 'namaGudang'));
	}
}
