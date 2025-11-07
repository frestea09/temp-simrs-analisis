<?php

namespace App\Http\Controllers\Covid;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CurlAPICovid;
use Modules\Kelas\Entities\Kelas;
use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;

class CovidController extends Controller
{
    protected $client;

    public function __construct(CurlAPICovid $client)
    {
        $this->client = $client;
    }

    public function post(){
        $kelas = Kelas::all();
        
        foreach ($kelas as $item){
            $bed = Bed::where('kelas_id', $item['id'])->where('virtual', 'N')->get();
			$kamar = Kamar::where('kelas_id', $item['id'])->count();

            if($item['id'] == 2){
                $body = [
                    "id_tt" 		=> 1,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 3){
                $body = [
                    "id_tt" 		=> 2,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 4){
                $body = [
                    "id_tt" 		=> 3,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 5){
                $body = [
                    "id_tt" 		=> 4,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 6){
                $body = [
                    "id_tt" 		=> 5,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 7){
                $body = [
                    "id_tt" 		=> 7,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 8){
                $body = [
                    "id_tt" 		=> 12,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 9){
                $body = [
                    "id_tt" 		=> 14,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }
            
            if($item['id'] != 1){
                $res    = $this->client->post('Fasyankes',json_encode($body));
            }
        }

        return $res;

    }

    public function put(){
        $kelas = Kelas::all();
        
        foreach ($kelas as $item){
            $bed = Bed::where('kelas_id', $item['id'])->where('virtual', 'N')->get();
			$kamar = Kamar::where('kelas_id', $item['id'])->count();

            if($item['id'] == 2){
                $body = [
                    "id_tt" 		=> 1,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 3){
                $body = [
                    "id_tt" 		=> 2,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 4){
                $body = [
                    "id_tt" 		=> 3,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 5){
                $body = [
                    "id_tt" 		=> 4,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 6){
                $body = [
                    "id_tt" 		=> 5,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 7){
                $body = [
                    "id_tt" 		=> 7,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 8){
                $body = [
                    "id_tt" 		=> 12,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }else if($item['id'] == 9){
                $body = [
                    "id_tt" 		=> 14,
                    "ruang" 		=> $item['nama'],
                    "jumlah_ruang" 	=> $kamar,
                    "jumlah" 		=> $bed->count(),
                    "terpakai" 		=> $bed->where('reserved', 'Y')->count(),
                    "prepare" 		=> 0,
                    "prepare_plan" 	=> 0,
                    "covid" 		=> 0,
                ];
            }
            
            if($item['id'] != 1){
                $res    = $this->client->put('Fasyankes',json_encode($body));
            }
        }

        return $res;

    }

    public function delete(){
        $datas    = $this->client->get('Fasyankes');
        $kelas = Kelas::all();
        foreach ($datas['data']['fasyankes'] as $data){
            $body = [
                "id_t_tt" 		=> $data['id_t_tt'],
            ];
            $res    = $this->client->delete('Fasyankes',json_encode($body));
        }

        return $res;
    }
}
