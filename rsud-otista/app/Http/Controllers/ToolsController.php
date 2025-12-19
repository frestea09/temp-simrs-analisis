<?php

namespace App\Http\Controllers;

use App\Logistik\LogistikStock;
use App\Penjualan;
use App\Penjualandetail;
use App\RegistrasiDummy;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Folio;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    public static function historiPasien(Request $request)
    {
        $data['pasien'] = Pasien::where('no_rm', 'LIKE', '%' . $request['no_rm'] . '%')->orWhere('no_rm_lama', 'LIKE', '%' . $request['no_rm'] . '%')->first();
        if ($data['pasien']) {
            $data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->orderBY('id', 'desc')->get();
        }
        return view('tools.histori-pasien', $data)->with('no', 1);
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

    public function getLogistikStock()
    {
        $data['stok'] = LogistikStock::whereBetween('created_at', ['2020-04-01 00:00:00',  '2020-04-02 23:59:59'])
                        ->where('logistik_batch_id', '!=', NULL)
                        ->where('keterangan','like','Penjualan%')
                        ->get();
        return view('/logistik/logistikmedik/kartu_stok/logistik-stok',$data)->with('no',1);
    }
    public function updateLogistikID(Request $request, $id)
	{
		$batch_id = $request['logistik_batch_id'];
		$batch_no = $request['batch_no'];
		$stok = LogistikStock::find($id);
		$stok->logistik_batch_id = $batch_id;
		$stok->batch_no = $batch_no;
		$stok->update();
		Flashy::success('sukses update '.$batch_id.'  '.$batch_no);
		return redirect('logistikmedik/kartustok/edit-logistik-batch-id');
    }
    public function totalPenjualan($faktur)
    {

		$data['penjualan'] = Penjualan::where('no_resep',$faktur)->first();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
        
        $data['detail'] = Penjualandetail::where('no_resep', $faktur)->get();
		$data['total_harga_jual'] = $data['detail']->sum('hargajual');
		$data['uang_racik'] = $data['detail']->sum('uang_racik');
		$data['totalharga_dan_uang_racik'] = $data['total_harga_jual'] + $data['uang_racik']  ;
        // return $data;die;
        return view('tools.penjualan', $data)->with('no',1);
    }
    public function totalFolio($reg_id)
    {
        $data = Folio::where('registrasi_id',$reg_id)->sum('total');
        return $data; die;
    }
    public function microtime()
    {
        $data = RegistrasiDummy::latest('created_at')->first()->created_at;
        $micro = 	round(microtime($data) * 1000);
        
        return $micro; die;
    }
    public function getPenjualanDetail()
    {
        return view('tools.penjualandetail');
    }
    public function getPenjualanDetailby(Request $request)
    {
        $data['penjualan'] = Penjualandetail::where('no_resep', $request['faktur'])->get();
        return view('tools.penjualandetail',$data)->with('no',1);
    }
    public function updateRincianObat(Request $request, $id)
	{   
        $no_resep = Penjualandetail::where('id',$id)->first()->no_resep;
		$stok = Penjualandetail::find($id);
		$stok->logistik_batch_id = $request['logistik_batch_id'];
        $stok->masterobat_id = $request['masterobat_id'];
        
		$stok->update();
		Flashy::success('Sukses update Faktur '.$no_resep);
		return redirect('list-penjualan-salah')->with('session', $no_resep);
    }
}
