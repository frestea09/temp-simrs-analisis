<?php

namespace Modules\Accounting\Http\Controllers\Master;

use App\Logistik\LogistikSupplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Accounting\Entities\Master\KasDanBank;
use Modules\Registrasi\Entities\Carabayar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use MercurySeries\Flashy\Flashy;
use Modules\Accounting\Entities\JournalDetail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getJournal['data'] = Journal::with('journal_detail')->where('type', 'anggaran')->orderBy('tanggal')->get()->toArray();

        foreach ($getJournal['data'] as $keyJ => $j) {
            $getJournal['data'][$keyJ]['debit']     = 0;
            $getJournal['data'][$keyJ]['credit']    = 0;
            foreach ($j['journal_detail'] as $jd) {
                $getJournal['data'][$keyJ]['debit']     = $getJournal['data'][$keyJ]['debit'] + $jd['debit'];
                $getJournal['data'][$keyJ]['credit']    = $getJournal['data'][$keyJ]['credit'] + $jd['credit'];
            }
            unset($getJournal['data'][$keyJ]['journal_detail']);
        }

        return view('accounting::master.anggaran.index', $getJournal);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
    }

    public function getAkunData()
    {
        $akunCOA = AkunCOA::select('akutansi_akun_coas.code', 'akutansi_akun_coas.nama', 'akutansi_akun_coas.saldo_normal')->join('akun_types', 'akutansi_akun_coas.akun_type_id', '=', 'akun_types.id')
            ->whereIn('akun_types.code', [4, 5, 7])->get()->toArray();

        Excel::create('Anggaran ' . date('Y'), function ($excel) use ($akunCOA) {
            $excel->sheet('Sheetname', function ($sheet) use ($akunCOA) {
                $sheet->setCellValue('A1', 'Kode Akun');
                $sheet->setCellValue('B1', 'Nama Akun');
                $sheet->setCellValue('C1', 'Saldo Normal');
                $sheet->setCellValue('D1', 'Debit');
                $sheet->setCellValue('E1', 'Kredit');
                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($akunCOA, null, 'A2', false, false);

                $sheet->setColumnFormat([
                    'D' => '#,##0',
                    'E' => '#,##0'
                ]);
            });
        })->download('xlsx');
        // return $data;
        return view('accounting::master.anggaran.add-edit', $akunCOA);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $request['data'];
        $journal = $request->except('_token', 'journal_detail');
        $journal['tanggal'] = date('Y-m-d', strtotime($journal['tanggal']));
        $journal['type'] = 'anggaran';
        if (isset($journal['contact_type']) && $journal['contact_type'] == 'customer') {
            $journal['id_supplier'] = null;
        } elseif (isset($journal['contact_type']) && $journal['contact_type'] == 'supplier') {
            $journal['id_customer'] = null;
        } else {
            $journal['id_supplier'] = null;
            $journal['id_customer'] = null;
        }

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

        DB::beginTransaction();

        try {
            $saveJournal = Journal::create($journal);

            foreach ($journalDetail as $jd) {
                $jd['id_journal'] = $saveJournal->id;
                JournalDetail::create($jd);
            }

            DB::commit();
            Flashy::success('Data Journal Umum Berhasil Di Tambahkan');
            return redirect(route('saldo.anggaran.index'));
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            Flashy::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function import(Request $request)
    {
        $rules = array(
            'akun' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        // process the form
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            DB::beginTransaction();

            try {
                Excel::load(Input::file('akun'), function ($reader) use ($request) {
                    $fileName = $request->file('akun')->getClientOriginalName();
                    $data = $reader->noHeading()->toArray();
                    unset($data[0]);

                    $journal = Journal::updateOrCreate([
                        'code'              => 'JA' . explode(' ', str_replace('.xlsx', '', $fileName))[1]
                    ], [
                        'contact_type'      =>  '-',
                        'code'              => 'JA' . explode(' ', str_replace('.xlsx', '', $fileName))[1],
                        'tanggal'           => explode(' ', str_replace('.xlsx', '', $fileName))[1] . '-01-01',
                        'total_transaksi'   => 0,
                        'type'              => 'anggaran',
                        'keterangan'        => 'Master Anggaran Tahun ' . explode(' ', str_replace('.xlsx', '', $fileName))[1]
                    ]);

                    foreach ($data as $row) {
                        if (is_null($row[3]) && is_null($row[4])) {
                            continue;
                        } else {
                            $getAkun = AkunCOA::where('code', $row[0])->first();

                            JournalDetail::updateOrCreate([
                                'id_journal'    => $journal->id,
                                'id_akun_coa'   => $getAkun->id
                            ], [
                                'id_journal'    => $journal->id,
                                'id_akun_coa'   => $getAkun->id,
                                'debit'         => (is_null($row[3])) ? 0 : $row[3],
                                'credit'        => (is_null($row[4])) ? 0 : $row[4],
                                'type'          => 'anggaran',
                                'keterangan'    => 'Master Anggaran Tahun ' . explode(' ', str_replace('.xlsx', '', $fileName))[1]
                            ]);
                        }
                    }
                });
                DB::commit();
                Flashy::success('Data Akun COA Berhasil Di Upload');
                return redirect(route('master.anggaran.index'));
            } catch (\Exception $e) {
                DB::rollback();
                Flashy::error($e->getMessage());
                return Redirect::back();
            }
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

        return view('accounting::master.anggaran.detail', $getJournal);
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
