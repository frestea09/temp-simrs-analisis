<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveBiodataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'namalengkap' => 'required',
            'tmplahir'  => 'required',
            'tgllahir'  => 'required',
            'suku'  => 'required',
            'warganegara'   => 'required',
            'alamat'    => 'required',
            'province_id'   => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'notlp' => 'required',
            'nohp'  => 'required',
            'kdpos' => 'required',
            'email' => 'required',
            'nokartupegawai' => 'required',
            // 'noktp'     =>'required',
            // 'noaskes'       =>'required',
            // 'notaspen'      =>'required',
            // 'npwp'      =>'required',
            // 'nokarsu'       =>'required',
        ];
    }
}
