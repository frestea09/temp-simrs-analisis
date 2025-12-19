<?php

namespace Modules\Poli\Http\Controllers;

use App\Satusehat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Poli\Entities\Poli;

use Modules\Poli\Http\Requests\SavepoliRequest;
use Modules\Politype\Entities\Politype;
use Modules\Instalasi\Entities\Instalasi;
use Modules\Kamar\Entities\Kamar;
use MercurySeries\Flashy\Flashy;
use Modules\Config\Entities\Config;
use Modules\Pegawai\Entities\Pegawai;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $poli = Poli::all();
        return view('poli::index', compact('poli'))->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['dokter'] = Pegawai::where('kategori_pegawai', '1')->select('nama', 'id')->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', '2')->select('nama', 'id')->get();
        $data['poli'] = Politype::pluck('nama', 'kode');
        $data['instalasi'] = Instalasi::pluck('nama', 'id');
        $data['kamar'] = Kamar::pluck('nama', 'id');
        return view('poli::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(SavepoliRequest $request)
    {
        $data = $request->all();
        if ($request['dokter_id']) {
            if (count($request['dokter_id']) > 0) {
                $data['dokter_id'] = !empty($request['dokter_id']) ? implode(',', $request['dokter_id']) : '';
            }
        }
        if ($request['perawat_id']) {
            if (count($request['perawat_id']) > 0) {
                $data['perawat_id'] = !empty($request['perawat_id']) ? implode(',', $request['perawat_id']) : '';
            }
        }
        if(Satusehat::find(3)->aktif == 1) {
            if (satusehat()) {
                $satusehat = $this->createSatuSehat($request);
                $id_location_ss = @$satusehat->id;
                $data['id_location_ss'] = @$id_location_ss;
                $data['description'] = @$satusehat->name;
            }
        }
        Poli::create($data);
        Flashy::success('Poli baru berhasil di tambahkan');
        return redirect()->route('poli');
    }



    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('poli::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['poli_u'] = Poli::find($id);
        $data['poli'] = Politype::pluck('nama', 'kode');
        $data['instalasi'] = Instalasi::pluck('nama', 'id');
        $data['kamar'] = Kamar::pluck('nama', 'id');
        $data['dokter'] = Pegawai::where('kategori_pegawai', '1')->select('nama', 'id')->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', '2')->select('nama', 'id')->get();

        return view('poli::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if(Satusehat::find(3)->aktif == 1) {
            if (satusehat()) {
                if(Poli::find($id)->id_location_ss){
                    $satusehat = $this->updateSatuSehat($request,$id);
                    }else{
                        $create = $this->createSatuSehat($request);
                        $satusehat = $this->updateSatuSehat($request,$id,$create);
                    }
                // dd($satusehat);
                $id_location_ss = $satusehat->id;
                $data['id_location_ss'] = @$id_location_ss;
                $data['description'] = @$satusehat->name;
                
            }
        }
      


        // dd($response);
        
        
        // 
        // Flashy::info('Poli berhasil di update');
        // dd("A");
        if ($request['dokter_id']) {
            if (count($request['dokter_id']) > 0) {
                $p = Poli::where('id', $id)->first();
                $data['dokter_id'] = !empty($request['dokter_id']) ? implode(',', $request['dokter_id']) : $p->dokter_id;
                $dt = [];
                foreach ($request['dokter_id'] as $s) {

                    $pegawai = Pegawai::where('id', $s)->first();
                    $user = User::where('id', $pegawai->user_id)->first();

                    if ($user) {
                        if ($user->poli_id) {
                            $user->poli_id = implode(',', array_unique(explode(',', $user->poli_id . ',' . $id)));
                        } else {
                            $user->poli_id = $id;
                        }
                        $user->save();
                    }
                }
            }
        }
        if ($request['perawat_id']) {
            if (count($request['perawat_id']) > 0) {
                $p = Poli::where('id', $id)->first();
                $data['perawat_id'] = !empty($request['perawat_id']) ? implode(',', $request['perawat_id']) : $p->perawat_id;
                $dt = [];
                foreach ($request['perawat_id'] as $s) {

                    $pegawai = Pegawai::where('id', $s)->first();
                    $user = User::where('id', $pegawai->user_id)->first();

                    if ($user) {
                        if ($user->poli_id) {
                            $user->poli_id = implode(',', array_unique(explode(',', $user->poli_id . ',' . $id)));
                        } else {
                            $user->poli_id = $id;
                        }
                        $user->save();
                    }
                }
            }
        }
        // dd($data);
        Poli::find($id)->update($data);
        
        Flashy::info('Poli berhasil di update');
        return redirect()->route('poli');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    { }


    function createSatuSehat($request)
    {
        
        $config = Config::where('id', 1)->first();
        //API TOKEN
        $client_id = config('app.client_id');
        $client_secret = config('app.client_secret');
        $urlcreatetoken = config('app.create_token');
        $curl1 = curl_init();

        curl_setopt_array($curl1, array(
            CURLOPT_URL => $urlcreatetoken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response1 = curl_exec($curl1);
        $token = json_decode($response1);
        $access_token = @$token->access_token;
       
        curl_close($curl1);
        //END OF API TOKEN

        //API LOCATION
        $create_location = config('app.create_location');
        $id_location = config('app.organization_id');
        $curl = curl_init();
        $body = '{
            "resourceType": "Location",
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/location/' . $id_location . '",
                    "value": "rsudotista"
                }
            ],
            "status": "active",
            "name": "Ruang Poli ' . $request->nama . '",
            "description": "rsudotista",
            "mode": "instance",
            "telecom": [
                {
                    "system": "phone",
                    "value": "' . $config->tlp . '",
                    "use": "work"
                },
                {
                    "system": "fax",
                    "value": "rsudotista",
                    "use": "work"
                },
                {
                    "system": "email",
                    "value": "' . $config->email . '"
                },
                {
                    "system": "url",
                    "value": "' . $config->website . '",
                    "use": "work"
                }
            ],
            "address": {
                "use": "work",
                "line": [
                    "' . $config->alamat . '"
                ],
                "city": "' . $config->kota . '",
                "postalCode": "' . $config->kode_pos . '",
                "country": "ID",
                "extension": [
                    {
                        "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                        "extension": [
                            {
                                "url": "province",
                                "valueCode": "' . $config->province_id . '"
                            },
                            {
                                "url": "city",
                                "valueCode": "' . $config->regency_id . '"
                            },
                            {
                                "url": "district",
                                "valueCode": "' . $config->district_id . '"
                            },
                            {
                                "url": "village",
                                "valueCode": "' . $config->village_id . '"
                            },
                            {
                                "url": "rt",
                                "valueCode": "' . $config->rt . '"
                            },
                            {
                                "url": "rw",
                                "valueCode": "' . $config->rw . '"
                            }
                        ]
                    }
                ]
            },
            "physicalType": {
                "coding": [
                    {
                        "system": "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code": "ro",
                        "display": "Room"
                    }
                ]
            },
            "position": {
                "longitude": ' .(float) $config->longitude . ',
                "latitude": ' . (float)$config->latitude . ',
                "altitude": ' . (float)$config->altitude . '
            }
        }';
        // dd($body);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $create_location,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token . '',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        // dd($response);
        $id_location = json_decode($response);
        curl_close($curl);
        return $id_location;
    }

    function updateSatuSehat($request,$id,$id_location_ss = null)
    {
        $config = Config::where('id', 1)->first();
        //API TOKEN
        $client_id = config('app.client_id');
        $client_secret = config('app.client_secret');
        $urlcreatetoken = config('app.create_token');
        $curl1 = curl_init();

        curl_setopt_array($curl1, array(
            CURLOPT_URL => $urlcreatetoken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response1 = curl_exec($curl1);
        $token = json_decode($response1);
        $access_token = $token->access_token;
        // dd($access_token);
        curl_close($curl1);
        //END OF API TOKEN

        //API LOCATION
        $config = Config::where('id', 1)->first();
        $update_location = config('app.update_location');
        $id_location = config('app.organization_id');
        $poli = Poli::find($id);
        // dd($id_location_ss);
        if($poli->id_location_ss){
            $id_satusehat = $poli->id_location_ss;
        }else{
            $id_satusehat = $id_location_ss->id;
        }
        // dd($id_satusehat);

        // dd($poli);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $update_location . $id_satusehat,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => '{
            "resourceType": "Location",
            "id": "' . $id_satusehat . '",
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/location/' . $id_location . '",
                    "value": ""
                }
            ],
            "status": "active",
            "name": "Ruang Poli ' . $request->nama . '",
            "description":  "' . $request->description . '",
            "mode": "instance",
            "telecom": [
                {
                    "system": "phone",
                    "value": "' . $config->tlp . '",
                    "use": "work"
                },
                {
                    "system": "fax",
                    "value": "",
                    "use": "work"
                },
                {
                    "system": "email",
                    "value": "' . $config->email . '"
                },
                {
                    "system": "url",
                    "value": "' . $config->website . '",
                    "use": "work"
                }
            ],
            "address": {
                "use": "work",
                "line": [
                    "' . $config->alamat . '"
                ],
                "city": "' . $config->kota . '",
                "postalCode": "' . $config->kode_pos . '",
                "country": "ID",
                "extension": [
                    {
                        "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                        "extension": [
                            {
                                "url": "province",
                                "valueCode": "' . $config->province_id . '"
                            },
                            {
                                "url": "city",
                                "valueCode": "' . $config->regency_id . '"
                            },
                            {
                                "url": "district",
                                "valueCode": "' . $config->district_id . '"
                            },
                            {
                                "url": "village",
                                "valueCode": "' . $config->village_id . '"
                            },
                            {
                                "url": "rt",
                                "valueCode": "' . $config->rt . '"
                            },
                            {
                                "url": "rw",
                                "valueCode": "' . $config->rw . '"
                            }
                        ]
                    }
                ]
            },
            "physicalType": {
                "coding": [
                    {
                        "system": "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code": "bu",
                        "display": "Building"
                    }
                ]
            },
            "position": {
                "longitude": ' .(float) $config->longitude . ',
                "latitude": ' . (float)$config->latitude . ',
                "altitude": ' . (float)$config->altitude . '
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token . '',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        // dd($response);
        $id_location = json_decode($response);
        curl_close($curl);
        return $id_location;
    }
}
