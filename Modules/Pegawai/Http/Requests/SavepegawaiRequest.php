<?php

namespace Modules\Pegawai\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavepegawaiRequest extends FormRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			// 'nama'    => 'required',
			// 'tgllahir' => 'required',
			// 'sip_awal' => 'required',
			// 'sip_akhir' => 'required',
			// 'tmplahir' => 'required',
			// 'kelamin' => 'required',
			// 'agama' => 'required',
			// 'alamat' => 'required',
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
}
