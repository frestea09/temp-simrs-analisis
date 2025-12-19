<?php

namespace Modules\Tarif\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatetarifRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'nama' => 'required',
          'jenis' => 'required',
          'kategoritarif_id' => 'required',
          'keterangan' => 'required',
          'tahuntarif_id' => 'required'
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
