<?php

namespace App\Http\Controllers\Logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogistikPejabatPengadaan;
use Validator;

class PejabatController extends Controller
{
    public function index(){
        $data = LogistikPejabatPengadaan::all();
        return view('logistik.logistikmedik.pejabat', compact('data'))->with('no', 1);
    }
    //
    public function pejabatCreate(Request $request){
        $cek = Validator::make($request->all(), [
			'nip' => 'required|string',
			'nama' => 'required|string',
			'jabatan' => 'required|string'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
            LogistikPejabatPengadaan::create([
                'nip'       => $request['nip'],
                'nama'      => $request['nama'],
                'jabatan'   => $request['jabatan']
            ]);
            return response()->json(['success' => true]);
        }
    }

    public function pejabatUpdate(Request $request){
        $cek = Validator::make($request->all(), [
			'nip' => 'required|string',
			'nama' => 'required|string',
			'jabatan' => 'required|string'
        ]);
        if($cek->fails()){
            return response()->json(['success' => false, 'error' => $cek->errors()]);
        }else{
            LogistikPejabatPengadaan::where('id', $request['id'])
                    ->update([
                        'nip' => $request['nip'],
                        'nama' => $request['nama'],
                        'jabatan' => $request['jabatan']
                    ]);
            return response()->json(['success' => true]);
        }
    }

    public function getPejabat($id = ''){
        return LogistikPejabatPengadaan::where('id' , $id)->first();
    }
}
