<?php

namespace Modules\Accounting\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Accounting\Entities\Master\KasDanBank;

class KasDanBankController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getKasBank['data'] = KasDanBank::with('akun_coa')->orderBy('code')->get()->toArray();

        return view('accounting::master.kas_bank.index', $getKasBank);
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

        return view('accounting::master.kas_bank.add-edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        DB::beginTransaction();

        try {
            KasDanBank::create($post);
            DB::commit();
            Flashy::success('Data Kas dan Bank Berhasil Di Tambahkan');
            return redirect(route('master.kas_bank.index'));
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
    public function show()
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['is_edit']    = 1;
        $data['data']       = KasDanBank::where('id', $id)->first();
        $akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
        foreach ($akunCoa as $value) {
            $data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
        }


        return view('accounting::master.kas_bank.add-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_method', '_token', 'code');
        DB::beginTransaction();

        try {
            KasDanBank::where('id', $id)->update($post);
            DB::commit();
            Flashy::success('Data Akun Kas dan Bank ' . $request->code . ' Berhasil Di Update');
            return redirect(route('master.kas_bank.index'));
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
