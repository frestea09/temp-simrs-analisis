<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logistik\LogistikPejabatBendahara;
use Validator;

class LogistikPejabatBendaharaController extends Controller
{
    public function index(){
        $data = LogistikPejabatBendahara::all();
        return view('logistik.logistikmedik.pejabat_bendahara', compact('data'))->with('no', 1);
    }
    //
    public function pejabatbendaharaCreate(Request $request){
        $cek = Validator::make($request->all(), [
			'nip' => 'required|string',
			'nama' => 'required|string',
			'jabatan' => 'required|string'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
            LogistikPejabatBendahara::create([
                'sk'       => $request['sk'],
                'nip'       => $request['nip'],
                'nama'      => $request['nama'],
                'jabatan'   => $request['jabatan']
            ]);
            return response()->json(['success' => true]);
        }
    }

    public function pejabatbendaharaUpdate(Request $request){
        $cek = Validator::make($request->all(), [
			'nip' => 'required|string',
			'nama' => 'required|string',
			'jabatan' => 'required|string'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
            LogistikPejabatBendahara::where('id', $request['id'])
                    ->update([
                        'nip' => $request['nip'],
                        'sk' => $request['sk'],
                        'nama' => $request['nama'],
                        'jabatan' => $request['jabatan']
                    ]);
            return response()->json(['success' => true]);
        }
    }

    public function getPejabatbendahara($id = ''){
        return LogistikPejabatBendahara::where('id' , $id)->first();
    }
}
