<?php

namespace Modules\Registrasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrasiRequest extends FormRequest
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
          'nik'            => 'required|unique:pasiens,nik,'.$request['id'],
          'tmplahir'       => 'required',
          'tgllahir'       => 'required|date_format:d-m-Y',
          'kelamin'        => 'required',
          'province_id'    => 'required',
          'regency_id'     => 'required',
          'district_id'    => 'required',
          'village_id'     => 'required',
          'alamat'         => 'required',
          'nohp'           => 'required',
          'foto'           => 'sometimes',
          'negara'         => 'sometimes',
          'pekerjaan_id'   => 'required',
          'agama_id'       => 'required',
          'pendidikan_id'  => 'required',
          'suami_istri'    => 'required',
          'pj'            => 'required',
          'pj_status'      => 'required',

          // ====================================================

          'status'        => 'required',
          'keterangan'    => 'sometimes',
          'rujukan'       => 'sometimes',
          // 'dokter_id'     => 'required',
          'poli_id'       => 'required',
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
