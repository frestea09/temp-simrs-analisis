<?php

namespace Modules\Config\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Config\Http\Requests\SaveconfigRequest;
use Modules\Config\Http\Requests\UpdateconfigRequest;
use Modules\Config\Entities\Config;
use Modules\Config\Entities\Tahuntarif;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Pasien\Entities\Province2;
use Image;
use MercurySeries\Flashy\Flashy;
use Modules\Pasien\Entities\Province;
use Modules\Pasien\Entities\Regency;

class ConfigController extends Controller
{
    public function index()
    {
        if(Config::count() >= 1){
          return $this->show();
        }
        $config = Config::count();
        return view('config::index', compact('config'));
    }

    public function create()
    {
        $tahun = Tahuntarif::pluck('tahun','id');
        $direktur = Pegawai::pluck('nama','id');
        return view('config::create', compact('tahun', 'direktur'));
    }

    public function store(SaveconfigRequest $request)
    {
      if(!empty($request->file('logo'))){
          $image = time().$request->file('logo')->getClientOriginalName();
          $request->file('logo')->move('images/', $image);
          $img = Image::make(public_path().'/images/'.$image)->resize(300,300);
          $img->save();
      }else{
        $image = '';
      }
      $data = $request->all();
      $data['logo'] = $image;
      Config::create($data);
      Flashy::success('Konfigurasi sukses di tambahkan');
      return redirect()->route('config');
    }

    public function show()
    {
        $config = Config::find(1);
        return view('config::show', compact('config'));
    }
  
    public function edit()
    {
        $data['config'] = Config::find(1);
        $data['tahun'] = Tahuntarif::pluck('tahun','id');
        $data['direktur'] = Pegawai::pluck('nama','id');
        // $data['provinsi'] = Province::pluck('name', 'id');
        $data['provinsi'] = Province2::pluck('name', 'id');
        return view('config::edit', $data);
    }

    public function update(UpdateconfigRequest $request, $id)
    {
      
      $config = Config::find($id);
      
    //   turn off/on status satusehat
      $config->status_satusehat = $request->status_satusehat;
      $config->status_tte = $request->status_tte;
      $config->save();

      if(!empty($request->file('logo'))){
          $image = time().$request->file('logo')->getClientOriginalName();
          $request->file('logo')->move('images/', $image);
          $img = Image::make(public_path().'/images/'.$image)->resize(300,300);
          $img->save();
      }else{
        $image = $config->logo;
      }

      if(!empty($request->file('logoparipurna'))){
        $imagepari = time().$request->file('logoparipurna')->getClientOriginalName();
        $request->file('logoparipurna')->move('images/', $imagepari);
        $imgpari   = Image::make(public_path().'/images/'.$imagepari)->resize(300,300);
        $imgpari->save();
    }else{
        $imagepari = $config->logo_paripurna;
    }
      // satusehat APi
      $nama = $request->nama;
      $alamat = $request->alamat;
      $website = $request->website;
      $email = $request->email;
      $kota = $request->kota;
      $tlp = $request->tlp;
      $kode_pos = $request->kode_pos;
      $provinsi = $request->province_id2;
      $regency = $request->regency_id2;
      $district = $request->district_id2;
      $village = $request->village_id2;
      $longitude = $request->longitude;
      $latitude = $request->latitude;
      $altitude = $request->altitude;
      $rt = $request->rt;
      $rw = $request->rw;

      if(satusehat()){

        // ambil key client_id dan secretkey
        $client_id = config('app.client_id');
        $client_secret = config('app.client_secret');
        $organization_id = config('app.organization_id');
        
        // create code satusehat
        $urlcreatetoken = config('app.create_token');
        // dd($urlcreatetoken);
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
          CURLOPT_POSTFIELDS => 'client_id='.$client_id.'&client_secret='.$client_secret,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
  
        $response = curl_exec($curl1);
        // dd($response);
        $token = json_decode($response);
        $access_token = $token->access_token;
        curl_close($curl1);
        // dd($response);  
  
        // APi create organization
        $urlorganization = config('app.create_organization');
        // dd($urlorganization);
  
        $curl2 = curl_init();
        $body = '{
          "resourceType": "Organization",
          "active": true,
          "identifier": [
              {
                  "use": "official",
                  "system": "http://sys-ids.kemkes.go.id/organization/'.$organization_id.'",
                  "value": ""
              }
          ],
          "type": [
              {
                  "coding": [
                      {
                          "system": "http://terminology.hl7.org/CodeSystem/organization-type",
                          "code": "prov",
                          "display": "Healthcare Provider"
                      }
                  ]
              }
          ],
          "name": "'.$nama.'",
          "telecom": [
              {
                  "system": "phone",
                  "value": "'.$tlp.'",
                  "use": "work"
              },
              {
                  "system": "email",
                  "value": "'.$email.'",
                  "use": "work"
              },
              {
                  "system": "url",
                  "value": "'.$website.'",
                  "use": "work"
              }
          ],
          "address": [
              {
                  "use": "work",
                  "type": "both",
                  "line": [
                      "'.$alamat.'"
                  ],
                  "city": "'.$kota.'",
                  "postalCode": "'.$kode_pos.'",
                  "country": "ID",
                  "extension": [
                      {
                          "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                          "extension": [
                              {
                                  "url": "province",
                                  "valueCode": "'.$provinsi.'"
                              },
                              {
                                  "url": "city",
                                  "valueCode": "'.$regency.'"
                              },
                              {
                                  "url": "district",
                                  "valueCode": "'.$district.'"
                              },
                              {
                                  "url": "village",
                                  "valueCode": "'.$village.'"
                              }
                          ]
                      }
                  ]
              }
          ]
        }'; 
        // dd(json_decode($body,true));
        curl_setopt_array($curl2, array(
          CURLOPT_URL => $urlorganization,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS => $body,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_token.'',
            'Content-Type: application/json'
          ),
        ));
        
        $response2 = curl_exec($curl2);
        
        $id_organization = json_decode($response2);
        $id_organizationss = @$id_organization->id;
        // dd([
        //     'credential' => [
        //         'client_id' => $client_id,
        //         'client_secret'=>$client_secret,
        //         'organization_id'=>$organization_id,
        //     ],
        //     'url' => $urlorganization,
        //     'response' => json_decode($response2,true),
        // ]);
        curl_close($curl2);
      }
 // echo $response;
 
    //    dd($id_organizationss);
 
      $data = $request->all();
      $data['create_org'] = @$response2;
      $data['province_id'] = $provinsi;
      $data['regency_id'] = $regency;
      $data['district_id'] = $district;
      $data['village_id'] = $village;
      $data['longitude'] = $longitude;
      $data['latitude'] = $latitude;
      $data['status_finger_kiosk'] = $request->status_finger_kiosk;
      $data['status_validasi_sep'] = $request->status_validasi_sep;
      $data['altitude'] = $altitude;
      $data['rt'] = $rt;
      $data['rw'] = $rw;
      if ($config->id_organization != null) {
        $data['id_organization'] = @$config->id_organization;
      } else {
        $data['id_organization'] = @$id_organizationss;
      }
      $data['logo'] = $image;
      $data['logo_paripurna'] = $imagepari;
      $config->update($data);
      Flashy::info('Konfigurasi sukses di update');
      return redirect()->route('config');
    }

    public function destroy()
    {
    }
}
