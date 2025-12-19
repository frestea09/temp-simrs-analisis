<?php

namespace App\Http\Controllers\Saderek;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AndroidSaderek\RegistrasiDummy;
use App\AndroidSaderek\Poli;
use Carbon\Carbon;

class PendaftaranOnlineController extends Controller
{
    public function index()
    {
        $data['tga'] = date('d-m-Y');
        $data['tgb'] = date('d-m-Y');
		$data['poli_id'] = null;
		$data['poli'] = Poli::where('status',1)->pluck('nama','id');
		$data['poli']['all'] = 'Tampilkan Semua';
        $data['reg'] = RegistrasiDummy::with(['data_poli'])->whereDate('tglperiksa', Carbon::today()->toDateString())->get();
		return view('saderek.pendaftaranOnline', $data)->with('no', 1);
    }

    public function indexFilter(Request $request)
    {
        $data['tga'] = $request->tga;
		$data['tgb'] = $request->tgb;
		$tga		 = valid_date($data['tga']).' 00:00:00';
		$tgb		 = valid_date($data['tgb']).' 23:59:59';
		$data['reg'] = RegistrasiDummy::with(['data_poli'])->whereBetween('created_at', [$tga, $tgb])->get();

		return view('saderek.pendaftaranOnline', $data)->with('no', 1);
    }
}
