<?php

namespace App\Http\Controllers;

use Cart;
use App\LogistikBatch;
use Illuminate\Http\Request;

class CartNewController extends Controller
{

	public function addCart(Request $request)
	{
		$batch = LogistikBatch::where('id', $request['masterobat_id'])->first();
		if ($batch) {
			$obat = \App\Masterobat::findOrFail($batch->masterobat_id);
		} else {
			$obat = \App\Masterobat::findOrFail($request['masterobat_id']);
		}
		if ($request['jumlah'] > $batch->stok) {
			return response()->json(['sukses' => false, 'data' => 'Jumlah tidak boleh lebih dari stok obat']);
		}
		if ($request['cara_bayar_id'] == 2) {
			$harga = $batch->hargajual_umum;
		} elseif ($request['cara_bayar_id'] == 5) {
			$harga = $batch->hargajual_dinas;
		} else {
			$harga = $batch->hargajual_jkn;
		}
		if ($request['diskon'] == null) {
			$diskon = 0;
		} else {
			$diskon = $request['diskon'];
		}

		$hargaReal = $harga - ($harga * ($diskon / 100));
		$created = date('Y-m-d H:i:s');
		// if($request['obat_racik'] != 'Y'){
		// 	$racik = rupiah($request['uang_racik']);
		// }else{
		// 	$racik = rupiah(0);
		// }

		if ($request['is_kronis'] == 'N') {
			$data = [
				'id' => $obat->id,
				'name' => $obat->nama,
				'qty' => $request['jumlah'],
				'price' => $hargaReal,
				'options' => [
					'is_kronis' => $request['is_kronis'],
					'logistik_batch_id' => @$batch->id,
					'cara_bayar_id' => $request['cara_bayar_id'],
					'pasien_id' => $request['pasien_id'],
					// 'registrasi_id' => $request['idreg'],
					'tipe_rawat' => $request['tipe_rawat'],
					'cara_minum_id' => $request['cara_minum_id'],
					'penjualan_id' => $request['penjualan_id'],
					'no_resep' => $request['no_resep'],
					'racikan' => $request['racikan'],
					'tiket' => $request['tiket'],
					'takaran' => $request['takaran'],
					'expired' => $request['expired'],
					'informasi1' => $request['informasi1'],
					'diskon' => $diskon,
					// 'uang_racik' => $racik,
					'cetak' => $request['cetak'],
					'jml_kronis' => $request['jml_kronis'],
					'subtotal' => ($hargaReal * $request['jumlah']),
					'created' => $created,
				],
			];

			$add = Cart::add($data);
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

				// Insert Kronis
				$data1 = [
					'id' => $obat->id,
					'name' => $obat->nama,
					'qty' => $jml_obat_kronis,
					'price' => $hargaReal,
					'options' => [
						'is_kronis' => 'Y',
						'logistik_batch_id' => @$batch->id,
						'cara_bayar_id' => $request['cara_bayar_id'],
						'pasien_id' => $request['pasien_id'],
						// 'registrasi_id' => $request['idreg'],
						'tipe_rawat' => $request['tipe_rawat'],
						'cara_minum_id' => $request['cara_minum_id'],
						'penjualan_id' => $request['penjualan_id'],
						'no_resep' => $request['no_resep'],
						'racikan' => $request['racikan'],
						'tiket' => $request['tiket'],
						'takaran' => $request['takaran'],
						'expired' => $request['expired'],
						'diskon' => $diskon,
						// 'uang_racik' => $racik,
						'cetak' => $request['cetak'],
						'jml_kronis' => $request['jml_kronis'],
						'subtotal' => ($hargaReal * $jml_obat_kronis),
						'created' => $created,
					],
				];
				
				$add1 = Cart::add($data1);

				// Insert Non Kronis
				$data2 = [
					'id' => $obat->id,
					'name' => $obat->nama,
					'qty' => $jml_obat_non_kronis,
					'price' => $hargaReal,
					'options' => [
						'is_kronis' => 'N',
						'logistik_batch_id' => @$batch->id,
						'cara_bayar_id' => $request['cara_bayar_id'],
						'pasien_id' => $request['pasien_id'],
						// 'registrasi_id' => $request['idreg'],
						'tipe_rawat' => $request['tipe_rawat'],
						'cara_minum_id' => $request['cara_minum_id'],
						'penjualan_id' => $request['penjualan_id'],
						'no_resep' => $request['no_resep'],
						'racikan' => $request['racikan'],
						'tiket' => $request['tiket'],
						'takaran' => $request['takaran'],
						'expired' => $request['expired'],
						'diskon' => $diskon,
						// 'uang_racik' => $racik,
						'cetak' => $request['cetak'],
						'jml_kronis' => $request['jml_kronis'],
						'subtotal' => ($hargaReal * $jml_obat_non_kronis),
						'created' => $created,
					],
				];
				$add2 = Cart::add($data2);

				if ($add1 && $add2) {
					return response()->json(['sukses' => true, 'data' => 'Berhasil menambahkan obat']);
				} else {
					return response()->json(['sukses' => false, 'data' => 'Gagal menambahkan obat']);
				}
			} else {
				return response()->json(['sukses' => false, 'data' => 'Obat kronis hanya bisa ditambah untuk pemakaian penuh, 1/2, ataupun 1/4']);
			}
		}

		if ($add) {
			return response()->json(['sukses' => true, 'data' => @$data]);
		} else {
			return response()->json(['sukses' => false, 'data' => @$data]);
		}
	}

	public function updateCart(Request $request)
	{
		for ($i = 1; $i <= $request->jenis; $i++) {
			Cart::update($request['id' . $i], $request['qty' . $i]);
		}
		return redirect('/cart-content');
	}

	public function deleteCart($rowid)
	{
		$del = Cart::remove($rowid);
		return response()->json(['sukses' => true]);
	}

	public function destroyCart()
	{
		Cart::destroy()->where('options.registrasi_id', 20911);
		return response()->json(['sukses' => true]);
	}
	public function refreshObat()
	{
		Cart::destroy();
		return redirect()->back();
	}

	public function cartEditJumlah(Request $request)
	{
		$rowId = $request->rowId;
		$qty = $request->qty;

		$data = Cart::get($rowId);
		$subTotal = $qty * $data->price;
		$options = $data->options;
		$options['subtotal'] = $subTotal;

		if ($data) {
			try {
				Cart::update($rowId, ['qty' => $qty, 'options' => $options]);
				return response()->json(['sukses' => true]);
			} catch (\Throwable $th) {
				return response()->json(['sukses' => false]);
			}
		}
		return response()->json(['sukses' => false]);
	}

	public function cartEditKronis(Request $request)
	{
		$rowId = $request->rowId;
		$is_kronis = $request->is_kronis;
		$data = Cart::get($rowId);
		$options = $data->options;
		$options['is_kronis'] = $is_kronis;

		try {
			Cart::update($rowId, ['options' => $options]);
			return response()->json(['sukses' => true]);
		} catch (\Throwable $th) {
			return response()->json(['sukses' => false]);
		}
	}

	public function cartEditJumlahEresep(Request $request)
	{
		$rowId = $request->rowId;
		$qty = $request->qty;

		$data = Cart::instance('obat' . $request->idreg)->get($rowId);
		$subTotal = $qty * $data->price;
		$options = $data->options;
		$options['subtotal'] = $subTotal;

		if ($data) {
			try {
				Cart::update($rowId, ['qty' => $qty, 'options' => $options]);
				return response()->json(['sukses' => true]);
			} catch (\Throwable $th) {
				return response()->json(['sukses' => false]);
			}
		}
		return response()->json(['sukses' => false]);
	}

	public function cartEditKronisEresep(Request $request)
	{
		$rowId = $request->rowId;
		$is_kronis = $request->is_kronis;
		$data = Cart::instance('obat' . $request->idreg)->get($rowId);
		$options = $data->options;
		$options['is_kronis'] = $is_kronis;

		try {
			Cart::instance('obat' . $request->idreg)->update($rowId, ['options' => $options]);
			return response()->json(['sukses' => true]);
		} catch (\Throwable $th) {
			return response()->json(['sukses' => false]);
		}
	}

	public function deleteEresepCart($rowid, $idreg)
	{
		$del = Cart::instance('obat' . $idreg)->remove($rowid);
		return response()->json(['sukses' => true]);
	}
}
