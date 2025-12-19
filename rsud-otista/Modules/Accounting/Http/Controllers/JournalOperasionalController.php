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
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;

class JournalOperasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->except('_token');

        $getJournal['data'] = Journal::with('journal_detail')
            ->where('type', '!=', 'anggaran')
            ->where('type', '!=', 'journal_umum')
            ->where('type', '!=', 'journal_pengeluaran');

        if ($post) {
            $getJournal['data'] = $getJournal['data']->where('tanggal', '>=', date('Y-m-d', strtotime($post['tga'])))
                ->where('tanggal', '<=', date('Y-m-d', strtotime($post['tgs'])));
            if ($post['status'] != 2) {
                $getJournal['data'] = $getJournal['data']->where('verifikasi', $post['status']);
            }
            $getJournal['status'] = $post['status'];
        } else {
            $getJournal['data'] = $getJournal['data']->where('tanggal', date('Y-m-d'));
            $getJournal['status'] = 2;
        }

        $getJournal['data'] = $getJournal['data']->orderBy('id')->get()->toArray();

        foreach ($getJournal['data'] as $keyJ => $j) {
            $getJournal['data'][$keyJ]['debit']     = 0;
            $getJournal['data'][$keyJ]['credit']    = 0;
            foreach ($j['journal_detail'] as $jd) {
                $getJournal['data'][$keyJ]['debit']     = $getJournal['data'][$keyJ]['debit'] + $jd['debit'];
                $getJournal['data'][$keyJ]['credit']    = $getJournal['data'][$keyJ]['credit'] + $jd['credit'];
            }
            unset($getJournal['data'][$keyJ]['journal_detail']);
        }


        return view('accounting::journal_operasional.index', $getJournal);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
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
    public function show($id)
    {
        $getJournal = Journal::with('journal_detail.akun', 'journal_detail.kas_bank')->where('id', $id)->first()->toArray();

        $sumCredit  = 0;
        $sumDebit   = 0;
        foreach ($getJournal['journal_detail'] as $jd) {
            $sumCredit  = $sumCredit + $jd['credit'];
            $sumDebit   = $sumDebit + $jd['debit'];
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

        $getJournal['pembayaran_detail'] = Folio::where('no_kuitansi', $getJournal['code'])->get();
        $sumTotal = 0;
        foreach ($getJournal['pembayaran_detail'] as $pd) {
            $sumTotal = $sumTotal + $pd['total'];
        }
        $getJournal['pembayaran_detail'][] = [
            'namatarif' => 'Total Pembayaran',
            'as_total'  => 1,
            'total'     => $sumTotal
        ];
        // return $getJournal;
        // return $getJournal;
        return view('accounting::journal_operasional.detail', $getJournal);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function verifikasi($id)
    {
        $getJournal = Journal::with('journal_detail.akun', 'journal_detail.kas_bank')->where('id', $id)->first()->toArray();

        $sumCredit  = 0;
        $sumDebit   = 0;
        foreach ($getJournal['journal_detail'] as $jd) {
            $sumCredit  = $sumCredit + $jd['credit'];
            $sumDebit   = $sumDebit + $jd['debit'];
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

        $getJournal['pembayaran_detail'] = Folio::where('no_kuitansi', $getJournal['code'])->get();
        if (!isset($getJournal['pembayaran_detail'][0])) {
            unset($getJournal['pembayaran_detail']);
        } else {
            $sumTotal = 0;
            foreach ($getJournal['pembayaran_detail'] as $pd) {
                $sumTotal = $sumTotal + $pd['total'];
            }
            $getJournal['pembayaran_detail'][] = [
                'namatarif' => 'Total Pembayaran',
                'as_total'  => 1,
                'total'     => $sumTotal
            ];
        }

        return view('accounting::journal_operasional.verifikasi', $getJournal);
    }
    public function verifikasiVerif($id)
    {
        $getJournal = Journal::with('journal_detail.akun', 'journal_detail.kas_bank')->where('id', $id)->first()->toArray();

        Journal::where('id', $id)->update(['verifikasi' => 1, 'tanggal' => $getJournal['tanggal']]);

        return redirect('accounting/journal_operasional/' . $id);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['journal'] = Journal::with('journal_detail.akun', 'journal_detail.kas_bank')->where('id', $id)->first()->toArray();

        $sumCredit  = 0;
        $sumDebit   = 0;
        foreach ($data['journal']['journal_detail'] as $jd) {
            $sumCredit  = $sumCredit + $jd['credit'];
            $sumDebit   = $sumDebit + $jd['debit'];
        }
        
        $data['journal']['pembayaran_detail'] = Folio::where('no_kuitansi', $data['journal']['code'])->get();
        $sumTotal = 0;
        foreach ($data['journal']['pembayaran_detail'] as $pd) {
            $sumTotal = $sumTotal + $pd['total'];
        }
        $data['journal']['pembayaran_detail'][] = [
            'namatarif' => 'Total Pembayaran',
            'as_total'  => 1,
            'total'     => $sumTotal
        ];
        
        return view('accounting::journal_operasional.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $post = $request->except('_method', '_token');

        try {
            foreach ($post['journal_detail'] as $key => $value) {
                JournalDetail::where('id', $key)->update([
                    'debit'     => rupiah($value['debit']),
                    'credit'    => rupiah($value['credit'])
                ]);
            }
            DB::commit();
            Flashy::success('Data Journal Operasional Berhasil Di Ubah');
            return redirect(route('journal_operasional.show', $id));
        } catch (\Exception $e) {
            DB::rollback();
            Flashy::error($e->getMessage());
            return Redirect::back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
