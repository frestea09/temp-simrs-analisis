<?php

namespace Modules\Accounting\Http\Controllers\Saldo;

use App\Logistik\LogistikSupplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getSupplier = LogistikSupplier::orderBy('id')->get()->toArray();

        $customer['data'] = [];
        foreach ($getSupplier as $keyS => $s) {
            $getNilai = DB::table('journals')
            ->select(DB::raw('COALESCE(SUM(journal_details.debit), 0) AS debit'),
            DB::raw('COALESCE(SUM(journal_details.credit), 0) AS credit'),
            DB::raw('COALESCE(SUM(credit - debit), 0) AS total'))
            ->join('journal_details', 'journals.id', '=', 'journal_details.id_journal')
            ->where([
                'journals.contact_type' => 'supplier',
                'journals.id_supplier'  => $s['id']
            ])->first();
            
            $customer['data'][$keyS] = $s;
            $customer['data'][$keyS]['journal'] = json_decode(json_encode($getNilai), true);
        }
        
        return view('accounting::saldo.supplier.index', $customer);
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
