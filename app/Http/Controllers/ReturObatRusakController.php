<?php

namespace App\Http\Controllers;

use App\Logistik\LogistikStock;
use Illuminate\Http\Request;
use App\LogistikBatch;
use App\Masterobat;
use App\ReturObatRusak;
use Auth;
use MercurySeries\Flashy\Flashy;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\Master\AkunCOA;

class ReturObatRusakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['returobatrusak'] = ReturObatRusak::all();
        // return $data;
        return view('logistik.logistikmedik.returobatrusak.index', $data)->with('no', 1);
    }

    public function getObat(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $tags = LogistikBatch::where('gudang_id', Auth::user()->gudang_id)->where('nama_obat', 'like', '%' . $term . '%')->where('stok', '!=', 0)->limit(15)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_obat . ' | Batch: ' . $tag->nomorbatch];
        }
        return \Response::json($formatted_tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('logistik.logistikmedik.returobatrusak.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return request()->all();

        $retur                       = new ReturObatRusak();
        $retur->logistik_batch_id    = $request['batch_id'];
        $retur->masterobat_id        = $request['masterobat_id'];
        $retur->supplier_id          = $request['supplier_id'];
        $retur->gudang_id            = $request['gudang_id'];
        $retur->jumlahretur          = $request['jumlah'];
        $retur->keterangan           = $request['keterangan'];
        $retur->hargabeli           = $request['hargabeli'];
        $retur->save();

        $batch = LogistikBatch::find($request['batch_id']);
        $batch->stok = $batch->stok - $request['jumlah'];
        $batch->update();
        $total_stok = LogistikBatch::where('id', $request['batch_id'])->where('gudang_id', Auth::user()->gudang_id)->sum('stok');
        $stock = new \App\Logistik\LogistikStock();
        $stock->gudang_id = Auth::user()->gudang_id;
        $stock->user_id = Auth::user()->id;
        $stock->supplier_id = $request['supplier'];
        $stock->masterobat_id = $request->masterobat_id;
        $stock->logistik_batch_id = $batch->id;
        $stock->batch_no = $batch->nomorbatch;
        $stock->expired_date = date("Y-m-d", strtotime($batch->expireddate));
        // $stock->expired_date = !empty($saldo_obat->expireddate) ? $saldo_obat->expireddate : '';
        $stock->periode_id = date('m');
        $stock->keluar = $request->jumlah;
        $stock->masuk = 0;
        // $stock->total = $total_stok - $request->jumlah;
        $stock->total = $batch->stok;
        $stock->keterangan = 'Retur Obat Rusak' . '| batch: ' . $batch->nomorbatch;
        $stock->save();

        $master = Masterobat::where('id', $request['masterobat_id'])->first();
        $journal = Journal::create([
            'id_customer'        => 0,
            'contact_type'        => 'supplier',
            'code'                => 'RETUR-' . $batch->nomorbatch,
            'tanggal'            => date('Y-m-d'),
            'total_transaksi'    => rupiah($master->hargabeli * $request['jumlah']),
            'type'                => 'verifikasi_obat',
            'keterangan'        => 'Jurnal Retur Obat Batch ' . $batch->nomorbatch,
            'verifikasi'        => 1
        ]);

        $akunSementaraKas = AkunCOA::where('code', '101109099')->first();
        $journalDetail[] = JournalDetail::create([
            'id_journal'        => $journal->id,
            'id_akun_coa'        => $akunSementaraKas->id,
            'debit'                => (int) rupiah($master->hargabeli * $request['jumlah']),
            'credit'            => 0,
            'is_kas_bank'        => 1,
            'type'                => 'verifikasi_obat',
            'keterangan'        => 'Jurnal Retur Obat ' . $batch->nomorbatch . ' Akun ' . $akunSementaraKas->nama
        ]);

        $akunMasterObat = AkunCOA::where('code', '101301001')->first();
        if (!empty($master->akutansi_akun_coa_id)) {
            $akunMasterObat = AkunCOA::where('id', $master->akutansi_akun_coa_id)->first();
        }
        $journalDetail[] = JournalDetail::create([
            'id_journal'        => $journal->id,
            'id_akun_coa'        => $akunMasterObat->id,
            'debit'                => 0,
            'credit'            => (int) rupiah($master->hargabeli * $request['jumlah']),
            'is_operasional'    => 0,
            'type'                => 'verifikasi_obat',
            'keterangan'        => 'Jurnal Retur Obat ' . $batch->nomorbatch . ' Akun ' . $akunMasterObat->nama
        ]);

        Flashy::success('Retur Berhasil Disimpan');
        return redirect('retur-obat-rusak');
    }

    public function penyerahanObat(Request $request)
    {
        $penyerahan = ReturObatRusak::find($request['obatrusak_id']);
        $penyerahan->user_gudang_pusat = $request['user_gudang_pusat'];
        $penyerahan->tgl_diterima = date('Y-m-d', strtotime($request['tglditerima']));
        $penyerahan->nama_penerima = $request['penerima'];
        $penyerahan->supplier_id = $request['supplier_id'];
        $penyerahan->hargabeli = $request['hargabeli'];
        $penyerahan->status = 'diterima';
        $penyerahan->update();
        Flashy::success('Penyerihan Obat Berhasil');
        return redirect('retur-obat-rusak');
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
}
