<?php

namespace Modules\Accounting\Http\Controllers\Saldo;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use MercurySeries\Flashy\Flashy;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Accounting\Entities\Master\KasDanBank;
use Modules\Accounting\Http\Controllers\LaporanController;

class KasDanBankController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $kasBank = KasDanBank::with('akun_coa')->get()->toArray();

        $getKasBank['data'] = [];
        foreach ($kasBank as $key => $value) {
            $total = Journal::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                ->where('akutansi_journals.verifikasi', 1)->where('akutansi_journal_details.id_akun_coa', $value['akun_coa']['id'])
                ->where('akutansi_journals.type', '!=', 'anggaran')->groupBy('akutansi_journal_details.id_akun_coa')->first();
            if (!empty($total)) {
                $getKasBank['data'][$key] = [
                    'id'        => $value['id'],
                    'code'      => $value['code'],
                    'nama'      => $value['nama'],
                    'debit'     => (is_null($total['debit'])) ? 0 : $total['debit'],
                    'credit'    => (is_null($total['credit'])) ? 0 : $total['credit'],
                    'saldo'     => $total['debit'] - $total['credit']
                ];
            }
        }

        return view('accounting::saldo.kas_bank.index', $getKasBank);
    }

    public function transferSaldo(Request $request, $id)
    {
        $post = $request->except('_token');

        if ($post) {
            $post['tanggal']        = date('Y-m-d', strtotime($post['tanggal']));
            $post['type']           = 'journal_umum';
            $post['id_supplier']    = null;
            $post['id_customer']    = null;
            $post['contact_type']   = '-';
            $post['code']           = 'TRF-SALDO-' . date('Y-m-d', strtotime($post['tanggal']));
            $post['verifikasi']     = 1;
            DB::beginTransaction();

            try {
                $tujuan = $post['tujuan'];
                unset($post['tujuan']);

                $saveJournal = Journal::create($post);

                JournalDetail::create([
                    'id_journal'    => $saveJournal->id,
                    'id_akun_coa'   => $tujuan,
                    'debit'         => (int) rupiah($post['total_transaksi']),
                    'credit'        => 0,
                    'type'          => 'journal_umum',
                    'keterangan'    => $post['keterangan']
                ]);
                JournalDetail::create([
                    'id_journal'    => $saveJournal->id,
                    'id_akun_coa'   => $id,
                    'debit'         => 0,
                    'credit'        => (int) rupiah($post['total_transaksi']),
                    'type'          => 'journal_umum',
                    'keterangan'    => $post['keterangan']
                ]);
                DB::commit();
                Flashy::success('Transfer Saldo Akun Berhasil');
                return redirect(route('saldo.kas_bank.index'));
            } catch (\Exception $e) {
                DB::rollback();
                Flashy::error($e->getMessage());
                return Redirect::back();
            }
        } else {
            $kasBank = KasDanBank::where('id', $id)->first();
            $akun   = AkunCOA::where('id', $kasBank->akun_coa_id)->first();

            $total = Journal::select(DB::raw('COALESCE(SUM(akutansi_journal_details.debit), 0) AS debit'), DB::raw('COALESCE(SUM(akutansi_journal_details.credit), 0) AS credit'))
                ->join('akutansi_journal_details', 'akutansi_journals.id', 'akutansi_journal_details.id_journal')
                ->where('akutansi_journals.verifikasi', 1)
                ->where('akutansi_journal_details.id_akun_coa', $kasBank->akun_coa_id)
                ->where('akutansi_journals.type', '!=', 'anggaran')
                ->groupBy('akutansi_journal_details.id_akun_coa')
                ->first();

            $getKasBank['data']['induk'] = [
                'id'        => $id,
                'code'      => $akun['code'],
                'nama'      => $akun['nama'],
                'debit'     => (is_null($total['debit'])) ? 0 : $total['debit'],
                'credit'    => (is_null($total['credit'])) ? 0 : $total['credit'],
                'saldo'     => $total['debit'] - $total['credit']
            ];

            $akunCoa   = AkunCOA::where('akun_code_1', 1)
                ->where('akun_code_9', '!=', 0)
                ->where('id', 'NOT LIKE', $kasBank->akun_coa_id)
                ->get()->toArray();
            foreach ($akunCoa as $value) {
                $getKasBank['data']['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
            }

            return view('accounting::saldo.kas_bank.add-edit', $getKasBank);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
