<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logistik\PejabatPengecekan;
use Validator;

class PejabatPengecekanController extends Controller
{
    public function index(){
        $data = PejabatPengecekan::all();
        return view('logistik.logistikmedik.pejabat_pengecekan', compact('data'))->with('no', 1);
    }
    //
    public function pejabatpengecekanCreate(Request $request){
        $cek = Validator::make($request->all(), [
			'nip' => 'required|string',
			'nama' => 'required|string',
			'jabatan' => 'required|string'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
            PejabatPengecekan::create([
                'nip'       => $request['nip'],
                'nama'      => $request['nama'],
                'jabatan'   => $request['jabatan']
            ]);
            return response()->json(['success' => true]);
        }
    }

    public function pejabatpengecekanUpdate(Request $request){
        $cek = Validator::make($request->all(), [
			'nip' => 'required|string',
			'nama' => 'required|string',
			'jabatan' => 'required|string'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
            PejabatPengecekan::where('id', $request['id'])
                    ->update([
                        'nip' => $request['nip'],
                        'nama' => $request['nama'],
                        'jabatan' => $request['jabatan']
                    ]);
            return response()->json(['success' => true]);
        }
    }

    public function getPejabatpengecekan($id = ''){
        return PejabatPengecekan::where('id' , $id)->first();
    }
}
