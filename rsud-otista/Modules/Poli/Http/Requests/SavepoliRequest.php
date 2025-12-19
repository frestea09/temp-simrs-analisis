<?php

namespace Modules\Poli\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavepoliRequest extends FormRequest
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
            'politype' => 'required',
            'bpjs' => 'required',
            'instalasi_id' => 'required',
            'kamar_id' => 'required',
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
