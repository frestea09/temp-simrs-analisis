<?php

namespace App\Http\Controllers\Api;

use App\Hasillab;
use App\Mahasiswa;
use App\PacsOrder;
use App\PacsExpertise;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\LisResult;
use Exception;
use Illuminate\Http\Request;


class LisController extends Controller
{
    public function store(Request $request)
    {
        
        //  try {

            $request->validate([
                'json'   => 'required',
                'no_ref' => 'required',
            ]);
            
            $d = Hasillab::where('no_lab',$request->no_ref)->first();
            if(!$d){
                return response()->json([
                    'data'=>[
                        'message' => 'No.Ref Belum Terdaftar',
                        'code' => '201'
                    ]
                ]);
            }

            if($d){
                $create = $d;
            }else{
                $create = new LisResult();
            }
            $create->json        = $request->json;
            $create->no_ref       = $request->no_ref;
            $create->save();
            // dd($create);
            // $dataorder = LisResult::create([
                
            // ]);
            return response()->json([
                'data'=>[
                    'message' => 'Sukses',
                    'code' => '200'
                ]
            ]);
            // return ApiFormatter::createApi(200, 'Sukses');
            // dd($create);

            // if($dataorder){
            //     
            // }else{
            //     return ApiFormatter::createApi(400, 'Failed');
            // }

        // } catch (Exception $error) {
        //     return ApiFormatter::createApi(400, 'Data Not Found');
        // }
    }


    public function expertise(Request $request)
    {
         try {

            $request->validate([
                'nama'   => 'required',
                'no_rm' => 'required',
            ]);

            $dataex = PacsExpertise::create([
                'acc_number'  => $request->acc_number,
                'nama'        => $request->nama,
                'no_rm'       => $request->no_rm,
                'kelamin'     => $request->kelamin,
                'service'     => $request->service,
                'exam_room'   => $request->exam_room,
                'status'      => $request->status,
                'spv'         => $request->spv,
                'expertise'   => $request->expertise
            ]);

            $data = PacsExpertise::where('id', '=' , $dataex->id)->get();

            if($data){
                return ApiFormatter::createApi(200, 'Success Create Expertise');
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Data Not Found');
        }
    }

    public function show($id)
    {
            $data = PacsOrder::where('id', '=' , $id)->get();

            if($data){
                return ApiFormatter::createApi(200, 'Success', $data);
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'nama'   => 'required',
                'alamat' => 'required',
            ]);

            $dataorder = PacsOrder::findOrFail($id);

            $dataorder->update([
                'nama'   => $request->nama,
                'alamat' => $request->alamat
            ]);

            $data = PacsOrder::where('id', '=' , $id)->get();

            if($data){
                return ApiFormatter::createApi(200, 'Success', $data);
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Data Not Found');
        }
    }

    public function destroy($id)
    {

        try {

            $dataorder = PacsOrder::findOrFail($id);
            $data    = $dataorder->delete();

            if($data){
                return ApiFormatter::createApi(200, 'Delete Data Success');
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $error) {

            return ApiFormatter::createApi(400, 'Failed');

        }

    }
}