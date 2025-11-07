<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;

class LandingController extends Controller
{
    public function displayKamar(){
        $data = [];
        $kelas = Kelas::where('nama', '<>', '-')->take(12)->get();
        foreach($kelas as $key => $kl){
            $kamar = Bed::select('kamar_id')->where('virtual','N')->where('kelas_id', $kl->id)->distinct()->get();
            $data[$key]['kelas'] = $kl->nama;
            foreach($kamar as $i => $km){
                $total  = Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('virtual', 'N')->count();
                $isi    = Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('virtual', 'N')->where('reserved', 'Y')->count();
                $kosong = Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('virtual', 'N')->where('reserved', 'N')->count();

                $data[$key]['kamar'][$i] = [
                    'nama'  => baca_kamar($km->kamar_id),
                    'total' => $total,
                    'isi'   => $isi,
                    'kosong'=> $kosong
                ];
            }
        }
        return $data;
    }
}
