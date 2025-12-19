<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;


class cekRegistrasiToday implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($no_rm, $poli_id)
    {
        $pasien = Pasien::where('no_rm', $no_rm)->first();
        $reg = Registrasi::where('pasien_id', $pasien->id)->where('poli_id', $poli_id)->where('created_at', \Carbon\Carbon::today())->count();
        return $reg <= 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute ini, hari ini sdh terdaftar di Poli yang sama.';
    }
}
