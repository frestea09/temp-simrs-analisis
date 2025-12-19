<?php

namespace App\Http\Controllers;

use App\Android\pasien_android;
use App\Models\RegistrasiDummy;
use Illuminate\Http\Request;
use App\Models\Pasien\Village;
use Response;

class PasienController extends Controller
{
    
    public function pasienBaru(Request $request)
  { 
	// dd($request->all());
    
    // Jika nama kosong
    if(!$request->nama){
      return Response::json(["metadata"=> ["message"=> "Nama Belum Diisi","code"=> 201]]);
    }
    // Jika nomorkk kosong
    // if(!$request->nomorkk){
    //   return Response::json(["metadata"=> ["message"=> "Nomor KK Belum Diisi","code"=> 201]]);
    // }
    // Cek nomor NIK
    // if(strlen($request->nomorkk) !== 16)    {
    //   return Response::json(["metadata"=> ["message"=> "Nomor KK Tidak Sesuai","code"=> 201]]);
    // }
    
    // Jika nomor kartu kosong
    // if(!$request->nomorkartu){
    //   return Response::json(["metadata"=> ["message"=> "Nomor Kartu Belum Diisi","code"=> 201]]);
    // }
    // Cek nomor kartu
    // if(strlen($request->nomorkartu) !== 13)   {
    //   return Response::json(["metadata"=> ["message"=> "Format Nomor Kartu Tidak Sesuai","code"=> 201]]);
    // }
    // Jika NIK kosong
    if(!$request->nik){
      return Response::json(["metadata"=> ["message"=> "NIK Belum Diisi","code"=> 201]]);
    }

    // Cek nomor NIK
    if(strlen($request->nik) <= 15)    {
      return Response::json(["metadata"=> ["message"=> "Format NIK Tidak Sesuai","code"=> 201]]);
    }
    
    // Jika kelamin kosong
    if(!$request->jeniskelamin){
      return Response::json(["metadata"=> ["message"=> "Jenis Kelamin Belum Diisi","code"=> 201]]);
    }
    // Jika Tgl lahir kosong
    if(!$request->tanggallahir){
      return Response::json(["metadata"=> ["message"=> "Tanggal Lahir Belum Diisi","code"=> 201]]);
    }
    // Jika alamat kosong
    if(!$request->alamat){
      return Response::json(["metadata"=> ["message"=> "Alamat Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    // if(!$request->kelurahan_id){
    //   return Response::json(["metadata"=> ["message"=> "Kelurahan Belum Diisi","code"=> 201]]);
    // }
    // Jika kdprop kosong
    if(!$request->rw){
      return Response::json(["metadata"=> ["message"=> "RW Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->rt){
      return Response::json(["metadata"=> ["message"=> "RT Belum Diisi","code"=> 201]]);
    }
    
    $cek_reg = RegistrasiDummy::where('nik',$request->nik)
    ->where('nomorkartu',$request->nomorkartu)
    ->where('jenis_registrasi','pasien_baru')
    ->first();

    // if($cek_reg){
    //   return Response::json(["metadata"=> ["message"=> "Data Peserta Sudah Pernah Dientrikan dengan NIK atau No.JKN yang sama","code"=> 201]]);
    // }
    // CEK FORMAT TANGGAL
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$request->tanggallahir)) {
      $resp = Response::json([
        "metadata" => [
          "message" =>"Format Tanggal Lahir Tidak Sesuai, format yang benar adalah yyyy-mm-dd",
          "code"=> 201
        ]
      ]); 
      return $resp; die;
    }

    // GENERATE NEW NO RM
    $new_no_rm = date('Yn').sprintf("%03s", 0);
    $cek_norm = RegistrasiDummy::where('no_rm','like',date('Yn') . '%')->where('jenis_registrasi','pasien_baru')->count();
    @$cek_norm_android = pasien_android::where('no_rm','like',date('Yn') . '%')->count();
    @$cek_final_rm = $cek_norm_android+$cek_norm;

    if($cek_final_rm > 0){
        $norm = date('Yn').sprintf("%03s", $cek_final_rm+1);
    }else{
        $norm = $new_no_rm +1;
    }
	// dd($request->all());

    // return $norm;
    // dd($norm);
    //   $reg_dum  = RegistrasiDummy::where('nomorkartu', $request->nomorkartu)->first();
	 $kel = Village::find($request->kelurahan_id);

      if($cek_reg){
        $fkrtl = $cek_reg;
      }else{
        $fkrtl                 = New RegistrasiDummy();
      }
      $fkrtl->nomorkartu     = @$request->nomorkartu;
      $fkrtl->nik            = $request->nik;
      // $fkrtl->nomorkk        = $request->nomorkk; 
      $fkrtl->nama           = $request->nama;
      $fkrtl->kelamin        = $request->jeniskelamin;
      $fkrtl->tgllahir       = $request->tanggallahir;
      $fkrtl->tmplahir       = $request->tmplahir;
      $fkrtl->no_hp          = $request->nohp;
      $fkrtl->alamat         = $request->alamat;
      $fkrtl->kodeprop       = @$kel->kecamatan->kabupaten->provinsi->id;
      $fkrtl->namaprop       = @$kel->kecamatan->kabupaten->provinsi->name;
      $fkrtl->kodedati2      = @$kel->kecamatan->kabupaten->id;
      $fkrtl->namadati2      = @$kel->kecamatan->kabupaten->name;
      $fkrtl->kodekec        = @$kel->kecamatan->id;
      $fkrtl->namakec        = @$kel->kecamatan->name;
      $fkrtl->kodekel        = @$kel->id;
      $fkrtl->namakel        = @$kel->name;
      $fkrtl->rw             = $request->rw;
      $fkrtl->rt             = $request->rt;
      $fkrtl->cekin          = 'N';
      $fkrtl->jenisdaftar    = 'fkrtl'; 
      $fkrtl->jenis_registrasi    = 'pasien_baru'; 
      $fkrtl->kode_cara_bayar= 1;
      $fkrtl->status         = 'pending';  
      // $fkrtl->no_rm           ='';
      // $fkrtl->save();
	//   dd($fkrtl);
       
        
      // return $reg_dum; die;
      if ( $fkrtl->save()) {
        $resp = Response::json([
          "response"=> $fkrtl,
          "metadata"=> [
             "message"=> "Berhasil daftar pasien baru,Silahkan masukkan data reservasi",
             "code"=> 200
          ]
        ]);
      } else {
        $resp = Response::json([
          "metadata"=> [
            "message"=> "Data invalid !",
            "code"=> 201
          ]
        ]);
      }
     
    return $resp;
  }

}
