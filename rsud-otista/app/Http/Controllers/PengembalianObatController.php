<?php

namespace App\Http\Controllers;

use App\Logistik\LogistikStock;
use App\LogistikPinjamObat;
use App\Masterobat;
use App\PengembalianObat;
use App\RincianPinjamObat;
use App\Satuanbeli;
use Illuminate\Http\Request;
use App\LogistikBatch;
use App\RincianPengembalianObat;
use DB;
use Auth;
use MercurySeries\Flashy\Flashy;

class PengembalianObatController extends Controller
{
    public function index()
    {
        return view('logistik.logistikmedik.pengembalianobat.index')->with('no',1);
    }

    public function create($peminjaman_id)
    {
        $data['peminjaman'] = LogistikPinjamObat::where('id', $peminjaman_id)->first();
        $data['pengembalian'] = PengembalianObat::where('id', $data['peminjaman']->pengembalian_id)->first();
        // $data['rincian'] = RincianPinjamObat::where('logistik_pinjam_obat_id', $peminjaman_id)->get();
        $data['rincian'] =  RincianPinjamObat::where('logistik_pinjam_obat_id', $peminjaman_id)
                            ->select('masterobat_id', DB::raw('sum(jumlah) as jumlah'))
                            ->groupBy('masterobat_id')
                            ->get();
        $data['rspinjam'] = \App\Rstujuanpinjam::all();
        $data['masterobat'] = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->get();
        $data['satuan']     = Satuanbeli::all();
        if (!empty($data['pengembalian'])) {
            $data['rincianpengembalian'] = RincianPengembalianObat::where('pengembalian_id', $data['pengembalian']->id)->get();
        } 
        
        return view('logistik.logistikmedik.pengembalianobat.create', $data)->with('no',1);
        
    }
    public function store(Request $request)
    {
        // return $request->all();
		$date = date('Y-m-d', strtotime($request->tanggalpengembalian));

        $pengembalian                        = New PengembalianObat();
        $pengembalian->logistikpinjamobat_id = $request['pinjam_id'];
        $pengembalian->nomorberitaacara      = $request['beritapengembalian'];
        $pengembalian->rspinjam_id              = $request['rspinjam'];
        $pengembalian->tgl_pengembalian      = $date;
        $pengembalian->user_id               = Auth::user()->id;
        $pengembalian->save();

        $pinjam = LogistikPinjamObat::find($request['pinjam_id']);
        $pinjam->pengembalian_id = $pengembalian->id;
        $pinjam->update();

        return redirect()->back();
    }

    public function simpanRincian(Request $request)
    {
        // return $request->all();
        $stok = LogistikBatch::where('id', $request['batch_id'])->first()->stok;
        $batch = LogistikBatch::find($request['batch_id']);
        $batch->stok = $stok-($request['jumlah']);
        $batch->update();

        $rincianpengembalian = new RincianPengembalianObat();
        $rincianpengembalian->masterobat_id = $batch->masterobat_id;
        $rincianpengembalian->logistik_batch_id = $request['batch_id'];
        $rincianpengembalian->jumlah = $request['jumlah'];
        $rincianpengembalian->pengembalian_id = $request['pengembalian_id'];
        $rincianpengembalian->save();
        
        $jumlah = LogistikBatch::where('masterobat_id', $batch->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->sum('stok');

        $kartustok = new LogistikStock();
        $kartustok->gudang_id = Auth::user()->gudang_id;
        $kartustok->supplier_id = NULL;
        $kartustok->masterobat_id = $batch->masterobat_id;
        $kartustok->batch_no = $request['nomorbatch'];
        $kartustok->logistik_batch_id = $batch->id;
        $kartustok->expired_date = $request['expired'];
        $kartustok->masuk = $request['jumlah'];
        // $kartustok->keluar = $request['jumlah'];
        $kartustok->periode_id = date('m');
        $kartustok->total = $jumlah - $request['jumlah'];
        $kartustok->rincianpengembalian_id = $rincianpengembalian->id;
        $kartustok->keterangan = 'Pengembalian Obat '.'| No. ' . $request['nomorberita']. ' '.$request['rskembali'];
        $kartustok->save();

        Flashy::success('Pengembalian Obat Berhasil Disimpan');

        // return [$kartustok, $batch, $rincianpengembalian];die;
        return redirect()->back();
    }

    public function detail_popuap_batch($masterobat_id, $pinjam_id)
    {
        $count = RincianPinjamObat::join('logistik_batches', 'logistik_batches.id', '=', 'rincian_pinjam_obats.logistik_batch_id')
        ->where('rincian_pinjam_obats.logistik_pinjam_obat_id', $pinjam_id)
        ->where('logistik_batches.masterobat_id', $masterobat_id)
        ->where('logistik_batches.gudang_id', Auth::user()->gudang_id)->count();
        if($count <= 0){
            return response()->json(['sukses' => false]);
        }else{
            $obat =  RincianPinjamObat::join('logistik_batches', 'logistik_batches.id', '=', 'rincian_pinjam_obats.logistik_batch_id')
            ->where('rincian_pinjam_obats.logistik_pinjam_obat_id', $pinjam_id)
            ->where('logistik_batches.masterobat_id', $masterobat_id)
            ->where('logistik_batches.gudang_id', Auth::user()->gudang_id)->get();
            return response()->json(['sukses' => true, 'obat' => $obat]);
        }
    }

    public function detail_master_obat_batch($nomorbatch)
    {
        $count = LogistikBatch::where('id', $nomorbatch)->where('gudang_id', Auth::user()->gudang_id)->count();
        if($count <= 0){
            return response()->json(['sukses' => false]);
        }else{
            $obat = LogistikBatch::where('id', $nomorbatch)->where('gudang_id', Auth::user()->gudang_id)->first();
            return response()->json(['sukses' => true, 'obat' => $obat]);
        }
    }

    public function hapusObat($id)
    {
        $batch_id = RincianPengembalianObat::where('id', $id)->first()->logistik_batch_id;
        $jumlah = RincianPengembalianObat::where('id', $id)->first()->jumlah;
        $rincian_id = RincianPengembalianObat::where('id', $id)->first()->id;
        
        $rincian = RincianPengembalianObat::find($id);
        $rincian->delete();
        
        $stok = LogistikBatch::where('id',$batch_id)->first()->stok;
        $batch = LogistikBatch::find($batch_id);
        $batch->stok = $stok + $jumlah;
        $batch->update();

        $logistikstok = LogistikStock::where('rincianpengembalian_id', $rincian_id)->delete();

        Flashy::success('Rincian Obat berhasil dihapus');
        return redirect()->back();
    }
}
