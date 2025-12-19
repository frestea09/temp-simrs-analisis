<?php

namespace Modules\Registrasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRegistrasiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'no_rm'          => 'unique:pasiens,no_rm',
          'nama'           => 'required',
        //   'nik'            => 'required|unique:pasiens,nik|min:16',
          'tmplahir'       => 'required',
          'tgllahir'       => 'required|date_format:d-m-Y',
          'kelamin'        => 'required',
          'province_id'    => 'required',
          'regency_id'     => 'required',
          'district_id'    => 'required',
          'village_id'     => 'required',
          'alamat'         => 'required',
          //'rt'             => 'required',
          //'rw'             => 'required',
          //'nohp'           => 'required',
          'foto'           => 'sometimes',
          'negara'         => 'sometimes',
          'pekerjaan_id'   => 'required',
          'agama_id'       => 'required',
          'pendidikan_id'  => 'required',
          'status_marital' => 'required',
          'poli_id'       => 'required',
          // ====================================================
          // 'dokter_id'     => 'required',
          
          // 'icd'           => 'sometimes',

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
