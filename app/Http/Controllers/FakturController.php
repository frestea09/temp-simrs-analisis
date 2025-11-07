<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supliyer;
use App\Faktur;
use Validator;
use Auth;

class FakturController extends Controller
{
    public function index()
    {
        $supplier = Supliyer::select('nama', 'id')->get();
        return view('faktur.index', compact('supplier'));
    }

    public function saveFaktur(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'no_faktur' => 'required',
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'keterangan' => 'required',
            'no_transaksi' => 'required',
            'sumber_dana' => 'nullable',
        ]);

        if($cek->fails()){
            return response()->json(['sukses' => false, 'errors' => $cek->errors()]);
        } else {
            $d = new Faktur();
            $d->no_faktur = $request['no_faktur'];
            $d->tanggal = valid_date($request['tanggal']);
            $d->supplier_id = $request['supplier_id'];
            $d->keterangan = $request['keterangan'];
            $d->no_transaksi = $request['no_transaksi'];
            $d->sumber_dana = $request['sumber_dana'];
            $d->user_create = Auth::user()->name;
            $d->save();
            return response()->json(['sukses' => true, 'faktur_id' => $d->id]);
        }
    }
}
