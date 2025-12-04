<?php

namespace Modules\Bed\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SavebedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kelompokkelas_id' => 'required',
            'kelas_id' => 'required',
            'kamarid' => 'required',
            'nama' => 'required',
            'kode' => 'required',
            'keterangan' => 'sometimes'
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
