<?php

namespace App\Http\Controllers;
use App\Masterobat;
use App\Po;
use App\Podetail;
use App\Supliyer;
use Auth;
use DB;
use Illuminate\Http\Request;
use PDF;
use Validator;
use Yajra\DataTables\DataTables;

class PoController extends Controller {
	public function index() {
		return view('po.index');
	}

	public function dataPO($value = '') {
		DB::statement(DB::raw('set @rownum=0'));
		$po = Po::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'no_po',
			'supplier_id',
			'tanggal',
			'tgl_penerimaan',
			'user_create',
		])->get();
		return DataTables::of($po)
			->addColumn('supplier', function ($po) {
				return Supliyer::where('id', $po->supplier_id)->first()->nama;
			})
			->addColumn('tanggal', function ($po) {
				return tgl_indo($po->tanggal);
			})
			->addColumn('aksi', function ($po) {
				return ' <a href="#" data-id="' . $po->id . '" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a> ' .
				'<a href="po-cetak/' . $po->id . '" target="_blank" class="btn btn-sm btn-danger btn-flat "><i class="fa fa-file-pdf-o"> </i></a>';
			})
			->rawColumns(['aksi'])
			->make(true);
	}

	public function dataDetailPO($id) {
		$po = Po::where('id', $id)->first();
		$detail = Podetail::where('po_id', $po->id)->get();
		$data = [
			'po' => $po,
			'distributor' => Supliyer::where('id', $po->supplier_id)->first()->nama,
			'tanggal' => tgl_indo($po->tanggal),
			'detail' => $detail,
		];
		return response()->json($data);
	}

	public function order() {
		return view('po.order');
	}

	public function addItem(Request $request) {
		request()->validate([
			'tanggal' => 'required',
		]);

		$cek = Po::where('supplier_id', $request['supplier_id'])->where('tanggal', valid_date($request['tanggal']))->count();
		if ($cek <= 0) {
			$po = new Po();
			$po->no_po = '001';
			$po->supplier_id = $request['supplier_id'];
			$po->tanggal = valid_date($request['tanggal']);
			$po->tgl_penerimaan = null;
			$po->user_create = Auth::user()->name;
			$po->save();
		} else {
			$po = Po::where('supplier_id', $request['supplier_id'])->where('tanggal', valid_date($request['tanggal']))->first();
		}
		$data = [
			'po_id' => $po->id,
			'no_po' => $po->no_po,
			'supplier_id' => $po->supplier_id,
			'tanggal' => $po->tanggal,
			'user_create' => $po->user_create,
		];
		return view('po.order', $data);
	}

	public function SimpanItem(Request $request) {
		$cek = Validator::make($request->all(), [
			'nama_item' => 'required',
			'jumlah_item' => 'required',
			'satuan' => 'required',
		]);
		if ($cek->passes()) {
			$item = new Podetail();
			$item->po_id = $request['po_id'];
			$item->no_po = $request['no_po'];
			$item->kode_item = $request['kode_item'];
			$item->nama_item = $request['nama_item'];
			$item->jumlah = $request['jumlah_item'];
			$item->satuan = $request['satuan'];
			$item->save();
			return response()->json(['sukses' => true]);
		} else {
			return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
		}
	}

	public function delete($id) {
		$item = Podetail::where('id', $id)->first();
		$item->delete();
		return response()->json(['sukses' => true]);
	}

	public function cetak($id = '') {
		$po = Po::where('id', $id)->first();
		$detail = Podetail::where('po_id', $po->id)->get();
		$pdf = PDF::loadView('po.kuitansi', compact('po', 'detail'));
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream('kuitansi_po.pdf');
	}

	//=========================================================================
	public function masterObat() {
		$obat = Masterobat::select('nama', 'kode')->orderBy('nama', 'asc')->get();
		return DataTables::of($obat)
			->addColumn('add', function ($obat) {
				return ' <a href="#" data-kode="' . $obat->kode . '" data-nama="' . $obat->nama . '" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
			})
			->rawColumns(['add'])
			->make(true);
	}

	public function detailPO($po_id) {
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Podetail::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'po_id',
			'no_po',
			'kode_item',
			'nama_item',
			'jumlah',
			'satuan'])->where('po_id', $po_id)->get();
		return DataTables::of($detail)
			->addColumn('delete', function ($detail) {
				return ' <a href="#" data-id="' . $detail->id . '" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
			})
			->rawColumns(['delete'])
			->make(true);
	}
}
