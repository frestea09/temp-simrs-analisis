<?php

namespace App\Http\Controllers;

use App\Models\Pasien\Regency;
use App\Models\Pasien\District;
use App\Models\Pasien\Village;
use Illuminate\Http\Request;

class DemografiController extends Controller
{
    public function getKelurahan(Request $request) {
        
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Village::where('name', 'like', '%' . $term . '%')->limit(15)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' =>  ucwords(strtolower($tag->kecamatan->kabupaten->provinsi->name)).', '.ucwords(strtolower(convert_kabupaten($tag->kecamatan->kabupaten->name))). 
            ', ' .ucwords(strtolower($tag->kecamatan->name)). ', ' .ucwords(strtolower($tag->name))];
			
		}
		return \Response::json($formatted_tags);
	}
    // =========== Demografi ===============================
	public function getKabupaten($province_id) {
		$kab = Regency::where('province_id', $province_id)->pluck('name', 'id');
		return json_encode($kab);
	}

	public function getKecamatan($regency_id) {
		$kec = District::where('regency_id', $regency_id)->pluck('name', 'id');
		return json_encode($kec);
	}

	public function getDesa($district_id) {
		$desa = Village::where('district_id', $district_id)->pluck('name', 'id');
		return json_encode($desa);
	}
 
     
}
