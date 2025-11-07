<?php

namespace App\Http\Controllers\Api;

use App\Mahasiswa;
use App\PacsOrder;
use App\PacsExpertise;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;


class PacsController extends Controller
{
 
    public function index()
    {
        $data = PacsOrder::all();
        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    public function store(Request $request)
    {
         try {

            $request->validate([
                'nama'   => 'required',
                'no_rm' => 'required',
            ]);

            $dataorder = PacsOrder::create([
                'nama'        => $request->nama,
                'no_rm'       => $request->no_rm,
                'insurance'   => $request->insurance,
                'urgensi'     => $request->urgensi,
                'room'        => $request->room,
                'dokter'      => $request->dokter,
                'klinis'      => $request->klinis,
                'radiografer' => $request->radiografer,
                'tindakan'    => $request->tindakan
            ]);

            $data = PacsOrder::where('id', '=' , $dataorder->id)->get();

            if($data){
                return ApiFormatter::createApi(200, 'Success Create Poli Order');
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Data Not Found');
        }
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