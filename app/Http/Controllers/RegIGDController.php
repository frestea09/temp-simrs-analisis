<?php

namespace Modules\Registrasi\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Modules\Pasien\Entities\Province;
use Modules\Pasien\Entities\District;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Dokter;
use Modules\Pasien\Entities\Regency;
use Modules\Pasien\Entities\Village;

use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Perusahaan\Entities\Perusahaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Status;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Sebabsakit\Entities\Sebabsakit;

use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Config\Entities\Config;

use Modules\Icd10\Entities\Icd10;
use Auth;
use Flashy;

class RegIGDController extends Controller
{
    public function reg_igd()
    {
      $data['provinsi']    = Province::pluck('name','id');
      $data['kabupaten']   = Regency::pluck('name', 'id');
      $data['kecamatan']   = District::pluck('name', 'id');
      $data['desa']        = Village::pluck('name', 'id');
      $data['pekerjaan']   = Pekerjaan::pluck('nama','id');
      $data['agama']       = Agama::pluck('agama', 'id');
      $data['perusahaan']  = Perusahaan::pluck('nama','id');
      $data['pendidikan']  = Pendidikan::pluck('pendidikan','id');
      $data['status']      = Status::pluck('status','id');
      $data['carabayar']   = Carabayar::pluck('carabayar','id');
      $data['rujukan']     = Rujukan::pluck('nama','id');
      $data['tipelayanan'] = Tipelayanan::pluck('tipelayanan','id');
      $data['sebabsakit']  = Sebabsakit::pluck('nama','id');
      $data['poli']        = Poli::select('nama','id')->where('politype_id', 3)->get();
      $data['pasien']      = Pasien::find($id);
      $data['dokter']      = Dokter::pluck('nama','id');
      $data['icd10']      = Icd10::all();
      return view('igd.reg.create', $data);
    }

}
