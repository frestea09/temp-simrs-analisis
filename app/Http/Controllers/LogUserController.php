<?php

namespace App\Http\Controllers;

use App\LogUser;

class LogUserController extends Controller
{
     public static function log($user,$aksi,$registrasi_id=NULL){
        $cek = LogUser::where('user_id',$user)->where('registrasi_id',$registrasi_id)->where('text',$aksi)->where('tanggal',date('Y-m-d'))->first();
        if(!$cek){
            $log = new LogUser();
            $log->user_id = $user;
            $log->nama = baca_user($user);
            $log->text = $aksi;
            $log->registrasi_id = @$registrasi_id;
            $log->tanggal = date('Y-m-d');
            $log->save();

            return true;
        }else{
            return false;
        }
     }
}
