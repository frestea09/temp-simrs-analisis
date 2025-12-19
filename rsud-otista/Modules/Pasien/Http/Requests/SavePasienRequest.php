<?php

namespace Modules\Pasien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePasienRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'nama'           => 'required',
          'tmplahir'       => 'required',
          'tgllahir'       => 'required',
          'kelamin'        => 'required',
          'alamat'         => 'required',
          'no_rm'          => 'sometimes',
          'province_id'    => 'required',
          'regency_id'     => 'required',
          'district_id'    => 'required',
          'village_id'     => 'required',
          'nohp'           => 'required',
          'foto'           => 'sometimes',
          'negara'         => 'sometimes',
          'pekerjaan_id'   => 'required',
          'agama_id'       => 'required',
          'perusahaan_id'  => 'required',
          'pendidikan_id'  => 'required',
          'pj'             => 'required',
          'pj_status'      => 'required',
          'jkn'            => 'required',
        //   'nik'            => 'required',
          'jkn_asal'       => 'required',
          'suami_istri'    => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
