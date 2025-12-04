<?php

namespace Modules\Accounting\Http\Controllers;

use App\Logistik\LogistikSupplier;
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
use Modules\Registrasi\Entities\Carabayar;

class JournalUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getJournal['data'] = Journal::with('journal_detail')->where('type', 'journal_umum')->orderBy('tanggal')->get()->toArray();

        foreach ($getJournal['data'] as $keyJ => $j) {
            $getJournal['data'][$keyJ]['debit']     = 0;
            $getJournal['data'][$keyJ]['credit']    = 0;
            foreach ($j['journal_detail'] as $jd) {
                $getJournal['data'][$keyJ]['debit']     = $getJournal['data'][$keyJ]['debit'] + $jd['debit'];
                $getJournal['data'][$keyJ]['credit']    = $getJournal['data'][$keyJ]['credit'] + $jd['credit'];
            }
            unset($getJournal['data'][$keyJ]['journal_detail']);
        }

        return view('accounting::journal_umum.index', $getJournal);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
        foreach ($akunCoa as $value) {
            $data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
        }

        $customer = Carabayar::orderBy('id')->get()->toArray();
        foreach ($customer as $value) {
            $data['customer'][$value['id']] = $value['carabayar'];
        }

        $supplier = LogistikSupplier::where('status', 1)->orderBy('id')->get()->toArray();
        foreach ($supplier as $value) {
            $data['supplier'][$value['id']] = $value['nama'];
        }

        $kasDanBank = KasDanBank::with('akun_coa')->orderBy('code')->get()->toArray();
        $data['kas_bank'][] = 'Pilih Kas dan Bank (Jika Perlu)';
        foreach ($kasDanBank as $value) {
            $data['kas_bank'][$value['id']] = implode(' - ', [$value['akun_coa']['code'], '(' . $value['no_rek'] . ') ' . $value['code']]);
        }

        return view('accounting::journal_umum.add-edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $journal = $request->except('_token', 'journal_detail');

        $journal['tanggal'] = date('Y-m-d', strtotime($journal['tanggal']));
        $journal['type'] = 'journal_umum';
        if (isset($journal['contact_type']) && $journal['contact_type'] == 'customer') {
            $journal['id_supplier'] = null;
        } elseif (isset($journal['contact_type']) && $journal['contact_type'] == 'supplier') {
            $journal['id_customer'] = null;
        } else {
            $journal['id_supplier'] = null;
            $journal['id_customer'] = null;
            $journal['contact_type'] = '-';
        }

        DB::beginTransaction();

        $journalDetail = $request->except('_token')['journal_detail'];
        $journal['total_transaksi'] = 0;
        foreach ($journalDetail as $jd) {
            if ($jd['debit'] != 0 && $jd['credit'] != 0) {
                DB::rollback();
                Flashy::error('Terdapat akun yang mengisi Debit dan Credit secara bersamaan');
                return Redirect::back();
            } else {
                $journal['total_transaksi'] = $journal['total_transaksi'] + ($jd['debit'] - $jd['credit']);
            }
        }

        if ($journal['total_transaksi'] != 0) {
            DB::rollback();
            Flashy::error('Total Transaksi Harus 0, selisih ' . $journal['total_transaksi']);
            return Redirect::back();
        }

        try {
            $saveJournal = Journal::create($journal);

            foreach ($journalDetail as $jd) {
                $jd['id_journal']   = $saveJournal->id;
                $jd['type']         = 'journal_umum';

                JournalDetail::create($jd);
            }

            DB::commit();
            Flashy::success('Data Journal Umum Berhasil Di Tambahkan');
            return redirect(route('journal_umum.index'));
        } catch (\Exception $e) {
            DB::rollback();
            Flashy::error($e->getMessage());
            return Redirect::back();
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $getJournal = Journal::with('journal_detail.akun', 'journal_detail.kas_bank')->where('id', $id)->first()->toArray();

        // switch ($getJournal['contact_type']) {
        //     case 'customer':
        //         $getJournal['contact']['name']  = Carabayar::where('id', $getJournal['id_customer'])->first()->carabayar;
        //         $getJournal['contact']['type']  = 'Customer';
        //         break;
        //     case 'supplier':
        //         $getJournal['contact']['name']  = LogistikSupplier::where('id', $getJournal['id_supplier'])->first()->nama;
        //         $getJournal['contact']['type']  = 'Customer';
        //         break;
        // }

        $sumCredit  = 0;
        $sumDebit   = 0;
        foreach ($getJournal['journal_detail'] as $key => $value) {
            $sumCredit  = $sumCredit + $value['credit'];
            $sumDebit   = $sumDebit + $value['debit'];
        }
        $getJournal['journal_detail'][] = [
            'credit'    => $sumCredit,
            'debit'     => $sumDebit,
            'as_total'  => 1,
            'akun'      => [
                'code'  => '',
                'nama'  => 'Total'
            ]
        ];

        return view('accounting::journal_umum.detail', $getJournal);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
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
