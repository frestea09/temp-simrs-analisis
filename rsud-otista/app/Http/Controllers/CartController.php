<?php

namespace App\Http\Controllers;

use App\LogistikBatch;
use App\Masterobat;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller {

	public function addCart(Request $request) {
		// dd($request->all());
		$obat  = LogistikBatch::findOrFail($request['masterobat_id']);
		// dd($obat);
		// $obat = Masterobat::findOrFail($request['masterobat_id']);
		if($request['cara_bayar_id'] == 2){
			$harga = $obat->hargajual_umum;
		}elseif($request['cara_bayar_id'] == 5){
			$harga = $obat->hargajual_kesda;
		}else{
			$harga = $obat->hargajual_jkn;
		}


		
		if ($request['diskon'] == null) {
			$diskon = 0;
		} else {
			$diskon = $request['diskon'];
		}

		$hargaReal = $harga - ($harga * ($diskon/100));







		if($request['obat_racik'] != null){
			$racik = $request['uang_racik'];
		}else{
			$racik = 0;
		}

		$created = date('Y-m-d H:i:s');

		if ($request['is_kronis'] == 'N') {
			$data = [
				'id' => $obat->id, //logistik_batch_id
				'name' => $obat->nama_obat,
				'qty' => $request['jumlah'],
				'price' => $hargaReal,
				'options' => [
					'masterobat_id' => $obat->masterobat_id,
					'cara_bayar_id' => $request['cara_bayar_id'],
					'pasien_id' => $request['pasien_id'],
					'registrasi_id' => $request['idreg'],
					'tipe_rawat' => $request['tipe_rawat'],
					'penjualan_id' => $request['penjualan_id'],
					'cara_minum_id' => $request['cara_minum_id'],
					'no_resep' => $request['no_resep'],
					'racikan' => $request['racikan'],
					'tiket' => $request['tiket'],
					'takaran' => $request['takaran'],
					'informasi1' => $request['informasi1'],
					'expired' => $request['expired'],
					'bud' => $request['bud'],
					'uang_racik' => $racik,
					'cetak' => $request['cetak'],
					'jml_kronis' => $request['jml_kronis'],
					'is_kronis' => $request['is_kronis'],
					'subtotal' => ((int)$hargaReal * (int)$request['jumlah']) + $racik,
					'created' => $created,
				],
			];
			$add = Cart::add($data);
		} else {
			$jml_obat = $request['jumlah'];
			$ds = intval($jml_obat / 30);
			$sisa = $jml_obat % 30;
			if ($sisa == 0 || $sisa == 15) {
				$jml_obat_kronis = $ds * 23;
				$jml_obat_non_kronis = $ds * 7;

				if ($sisa == 15) {
					$jml_obat_kronis += 11;
					$jml_obat_non_kronis += 4;
				}

				// Insert Kronis
				$data = [
					'id' => $obat->id, //logistik_batch_id
					'name' => $obat->nama_obat,
					'qty' => $jml_obat_kronis,
					'price' => $hargaReal,
					'options' => [
						'masterobat_id' => $obat->masterobat_id,
						'logistik_batch_id' => $obat->id,
						'cara_bayar_id' => $request['cara_bayar_id'],
						'pasien_id' => $request['pasien_id'],
						'registrasi_id' => $request['idreg'],
						'tipe_rawat' => $request['tipe_rawat'],
						'penjualan_id' => $request['penjualan_id'],
						'cara_minum_id' => $request['cara_minum_id'],
						'no_resep' => $request['no_resep'],
						'racikan' => $request['racikan'],
						'tiket' => $request['tiket'],
						'takaran' => $request['takaran'],
						'informasi1' => $request['informasi1'],
						'expired' => $request['expired'],
						'bud' => $request['bud'],
						'uang_racik' => $racik,
						'cetak' => $request['cetak'],
						'jml_kronis' => $request['jml_kronis'],
						'is_kronis' => 'Y',
						'subtotal' => ((int)$hargaReal * (int)$jml_obat_kronis) + $racik,
						'created' => $created,
					],
				];
				$add = Cart::add($data);

				// Insert Non Kronis
				$data = [
					'id' => $obat->id, //logistik_batch_id
					'name' => $obat->nama_obat,
					'qty' => $jml_obat_non_kronis,
					'price' => $hargaReal,
					'options' => [
						'masterobat_id' => $obat->masterobat_id,
						'logistik_batch_id' => $obat->id,
						'cara_bayar_id' => $request['cara_bayar_id'],
						'pasien_id' => $request['pasien_id'],
						'registrasi_id' => $request['idreg'],
						'tipe_rawat' => $request['tipe_rawat'],
						'penjualan_id' => $request['penjualan_id'],
						'cara_minum_id' => $request['cara_minum_id'],
						'no_resep' => $request['no_resep'],
						'racikan' => $request['racikan'],
						'tiket' => $request['tiket'],
						'takaran' => $request['takaran'],
						'informasi1' => $request['informasi1'],
						'expired' => $request['expired'],
						'bud' => $request['bud'],
						'uang_racik' => $racik,
						'cetak' => $request['cetak'],
						'jml_kronis' => $request['jml_kronis'],
						'is_kronis' => 'N',
						'subtotal' => ((int)$hargaReal * (int)$jml_obat_non_kronis) + $racik,
						'created' => $created,
					],
				];
				$add = Cart::add($data);
			}
		}


		if ($add) {
			return response()->json(['sukses' => true, 'data' => $data]);
		} else {
			return response()->json(['sukses' => false, 'data' => $data]);
		}
	}

	public function updateCart(Request $request) {
		for ($i = 1; $i <= $request->jenis; $i++) {
			Cart::update($request['id' . $i], $request['qty' . $i]);
		}
		return redirect('/cart-content');

	}

	public function deleteCart($rowid) {
		$del = Cart::remove($rowid);
		return response()->json(['sukses' => true]);
	}

	public function destroyCart() {
		Cart::destroy();
		return response()->json(['sukses' => true]);
	}

}
