<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Bed\Entities\Bed;

class SiranapController extends Controller {
	public function index() {
		//Super VIP ( Paviliun )
		$vvip_total = Bed::where('kelas_id', 1)->where('reserved', 'N')->count();
		//VIP 
		$vip_total = Bed::where('kelas_id', 2)->where('reserved', 'N')->count();
		$monitor_bed = '[
						 { "kode_ruang":"0001",
						  	"tipe_pasien":"0000",
						  	"total_tt":"' . $vvip_total . '",
						  	"terpakaiMale":"0",
						  	"terpakaiFemale":"0",
						  	"kosongMale":"0",
						  	"kosongFemale":"0",
						  	"waiting":"0",
						  	"tgl_update":"' . date("Y-m-d H:i:s") . '"
						  },
						  { "kode_ruang":"0001",
						  	"tipe_pasien":"0002",
						  	"total_tt":"' . $vip_total . '",
						  	"terpakaiMale":"0",
						  	"terpakaiFemale":"0",
						  	"kosongMale":"0",
						  	"kosongFemale":"0",
						  	"waiting":"0",
						  	"tgl_update":"' . date("Y-m-d H:i:s") . '"
						  },
						]';
		return $monitor_bed;

	}
}
