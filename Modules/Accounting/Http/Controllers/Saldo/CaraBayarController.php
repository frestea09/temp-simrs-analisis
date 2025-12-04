<?php

namespace Modules\Accounting\Http\Controllers\Saldo;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Journal;
use Modules\Registrasi\Entities\Carabayar;

class CaraBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getCustomer = Carabayar::orderBy('id')->get()->toArray();

        $customer['data'] = [];
        foreach ($getCustomer as $keyC => $c) {
            $getNilai = DB::table('journals')
            ->select(DB::raw('COALESCE(SUM(journal_details.debit), 0) AS debit'),
            DB::raw('COALESCE(SUM(journal_details.credit), 0) AS credit'),
            DB::raw('COALESCE(SUM(debit - credit), 0) AS total'))
            ->join('journal_details', 'journals.id', '=', 'journal_details.id_journal')
            ->where([
                'journals.contact_type' => 'customer',
                'journals.id_customer'  => $c['id']
            ])->first();
            
            $customer['data'][$keyC] = $c;
            $customer['data'][$keyC]['journal'] = json_decode(json_encode($getNilai), true);
        }
        
        return view('accounting::saldo.cara_bayar.index', $customer);
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
