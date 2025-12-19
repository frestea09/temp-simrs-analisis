<?php

namespace App\Http\Controllers\AndroidSaderek;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AndroidSaderek\MasterScreening;
use App\AndroidSaderek\screeningPasien;
use App\AndroidSaderek\screeningPasienDetail;
use App\AndroidSaderek\RegistrasiDummy;
use Carbon\Carbon;
use DB;

class ScreeningController extends Controller
{
    public function getScreening(Request $request,$no)
    {
        $data = MasterScreening::where('urut',$no)->where('status','Y')->first();
        $data->jumlah_screening = MasterScreening::where('status','Y')->count();
        if( isset($data->id) ){
            $res = [
                "status" => true,
                "data" => $data,
                "msg" => "Berhasil"
            ];
        }else{
            $res = [
                "status" => false,
                "data" => null,
                "msg" => "No Urut Screening Tidak Ditemukan"
            ];
        }
        return response()->json($res);
    }

    public function getScreeningALL()
    {
        $data = MasterScreening::where('status','Y')->get();
        $res = [
            "status" => true,
            "data" => $data,
            "msg" => "Berhasil"
        ];
        return response()->json($res);
    }

    public function saveScreeningAll(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try{
            $count = MasterScreening::count() + 1;
            $uuid = 'SCR' . date('YmdHis');
            $data = [
                "uuid" => $uuid,
                "nik" => $request->nik,
                "reg_id" => $request->reg_id,
                "nama" => $request->nama,
                "umur" => $request->umur,
                "alamat" => $request->alamat,
                "jenis" => $request->jenis,
                "hasil" => 0, // sum skor
                "status" => "N", // reject
            ];
            $result = screeningPasien::create($data); // create screening pasien

            $detail = [];
            $hasil = 0;
            foreach($request->screening as $key => $val){
                $detail[] = [
                    "screening_pasien_id" => $result->id,
                    "screening_id" => $val['screening_id'],
                    "jawab" => $val['jawab'],
                    "detail" => $val['detail'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ];
                $screening = MasterScreening::find($val['screening_id']); // find screening master
                if( $val['jawab'] == "Y" ) $hasil += $screening->skor;
                else $hasil += 0;
            }
            screeningPasienDetail::insert($detail); // create screening pasien detail

            // status
            if( $hasil > 0 ){ // fleksible
                $status = "N"; // rejected
            }else{
                $status = "Y"; // approved
            }
            // update screening pasien
            $update = screeningPasien::find($result->id);
            $update->update(["hasil" => $hasil,'status' => $status]);

            // update registrasi (terinfeksi covid)
            $reg = RegistrasiDummy::find($request->reg_id);
            if( isset($reg->id) ){ // jika tamu skip ini
                $data_reg = [
                    "terinfeksi_covid" => ($status == "N") ? 1 : 0
                ];
                $reg->update($data_reg);
            }

            DB::commit();
            $res = [
                "status" => true,
                "data" => $update,
                "msg" => "Berhasil"
            ];
            return response()->json($res);

        }catch(\Exception $e){
            DB::rollback();
            $res = [
                "status" => false,
                "data" => null,
                "msg" => "Terjadi Kesalahan. Error:".$e->getMessage(),
            ];
            return response()->json($res);
        }
    }

    public function saveScreening(Request $request)
    {
        DB::beginTransaction();
        try{
            if( $request->urut == 1 ){ // create
                $count = MasterScreening::count() + 1;
                $uuid = 'SCR' . date('YmdHis');
                $data = [
                    "uuid" => $uuid,
                    "nik" => $request->nik,
                    "hasil" => 0, // sum skor
                    "status" => "N", // reject
                ];
                $result = screeningPasien::create($data); // create screening pasien

                $screening = MasterScreening::find($request->screening_id); // find screening master
                if( $request->jawab == "Y" ){
                    $hasil = $screening->skor;
                }else{
                    $hasil = 0;
                }

                $detail = [
                    "screening_pasien_id" => $result->id,
                    "screening_id" => $request->screening_id,
                    "jawab" => $request->jawab,
                    "detail" => $request->detail,
                ];
                screeningPasienDetail::create($detail); // create screening pasien detail
                // update screening pasien
                $update = screeningPasien::find($result->id);
                $update->update(["hasil" => $hasil]);

            }else{ // update
                $screening = MasterScreening::find($request->screening_id); // find screening master

                $find = screeningPasien::where('uuid',$request->uuid)->first();
                if( $request->jawab == "Y" ){
                    $hasil = $find->hasil + $screening->skor;
                }else{
                    $hasil = $find->hasil;
                }
                // status
                if( $hasil > 200 ){ // fleksible
                    $status = "N"; // rejected
                }else{
                    $status = "Y"; // approved
                }
                $data = [
                    // "uuid" => $uuid,
                    "nik" => $request->nik,
                    "hasil" => $hasil, // sum skor
                    "status" => $status, // reject
                ];
                $find->update($data);

                $detail = [
                    // "screening_pasien_id" => $find->id,
                    // "screening_id" => $request->screening_id,
                    "jawab" => $request->jawab,
                    "detail" => $request->detail,
                ];
                screeningPasienDetail::updateOrCreate(
                    [ "screening_pasien_id" => $find->id, "screening_id" => $request->screening_id],
                    $detail
                ); // create screening pasien detail

                $result = $find;
            }
            $result->urut_selanjutnya = ($request->urut+1);
            $result->jumlah_screening = MasterScreening::where('status','Y')->count();
            $data = $result;
            DB::commit();
            $res = [
                "status" => true,
                "data" => $data,
                "msg" => "Berhasil"
            ];
            return response()->json($res);
        }catch(Exception $e){
            DB::rollback();
            $res = [
                "status" => false,
                "data" => null,
                "msg" => "Terjadi Kesalahan. Error:".$e->getMessage(),
            ];
            return response()->json($res);
        }
    }

    public function showScreening(Request $request)
    {
        $query = screeningPasien::with(['screening_detail.screening'])->orderBy('created_at', 'DESC');
        if( !empty($request->uuid) && !empty($request->nik) ){
            $query->where('uuid',$request->uuid);
            $query->where('nik',$request->nik);
        }elseif( !empty($request->uuid) ){
            $query->where('uuid',$request->uuid);
        }elseif( !empty($request->nik) ){
            $query->where('nik',$request->nik);
        }
        $data = $query->first();
        if(isset($data->id)){
            $res = [
                "status" => true,
                "data" => $data,
                "msg" => "Berhasil"
            ];
        }else{
            $res = [
                "status" => false,
                "data" => null,
                "msg" => "Screening Tidak Ditemukan"
            ];
        }
        return response()->json($res);
    }

    public function resultScreening($type,$id)
    {
        if( $type == "registrasi" ){
            $data = screeningPasien::with(['screening_detail.screening'])->where('reg_id',$id)->get();
        }elseif( $type == "uuid" ){
            $data = screeningPasien::with(['screening_detail.screening'])->where('uuid',$id)->first();
        }
       
        $res = [
            "status" => true,
            "data" => $data,
            "msg" => "Berhasil"
        ];
        return response()->json($res);
    }

}
