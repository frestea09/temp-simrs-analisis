<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BpjsAntreanController extends Controller
{
    public function pendaftaranByIdentitas(Request $request)
    {
        $identifier = trim((string) $request->input('identifier', ''));
        $noRm = trim((string) $request->input('no_rm', ''));
        $nik = trim((string) $request->input('nik', ''));
        $bpjs = trim((string) $request->input('bpjs', ''));

        if ($identifier === '' && $noRm === '' && $nik === '' && $bpjs === '') {
            return response()->json([
                'metadata' => [
                    'message' => 'Masukkan No RM, NIK, atau nomor BPJS.',
                    'code' => 422,
                ],
            ], 422);
        }

        $query = DB::connection('rsud_otista')
            ->table('registrasis_dummy');

        if ($identifier !== '') {
            $query->where(function ($builder) use ($identifier) {
                $builder->where('no_rm', $identifier)
                    ->orWhere('nik', $identifier)
                    ->orWhere('nomorkartu', $identifier);
            });
        } else {
            $query->where(function ($builder) use ($noRm, $nik, $bpjs) {
                if ($noRm !== '') {
                    $builder->where('no_rm', $noRm);
                }

                if ($nik !== '') {
                    $builder->orWhere('nik', $nik);
                }

                if ($bpjs !== '') {
                    $builder->orWhere('nomorkartu', $bpjs);
                }
            });
        }

        $registrasi = $query->orderByDesc('id')->first();

        if (!$registrasi) {
            return response()->json([
                'metadata' => [
                    'message' => 'Kode booking tidak ditemukan untuk identitas tersebut.',
                    'code' => 404,
                ],
            ], 404);
        }

        $kodebooking = $registrasi->kodebooking ?: $registrasi->nomorantrian;

        if (!$kodebooking) {
            return response()->json([
                'metadata' => [
                    'message' => 'Data kode booking belum tersedia pada registrasi.',
                    'code' => 404,
                ],
            ], 404);
        }

        $baseUrl = rtrim(config('app.apm_oid_base_url', ''), '/');
        if ($baseUrl === '') {
            $baseUrl = $request->getSchemeAndHttpHost();
        }

        $endpoint = $baseUrl . '/bpjs/antrean/pendaftaran/kodebooking/' . urlencode($kodebooking);

        $session = curl_init($endpoint);
        curl_setopt($session, CURLOPT_HTTPGET, true);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        $statusCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
        $curlError = curl_error($session);
        curl_close($session);

        if ($response === false) {
            return response()->json([
                'metadata' => [
                    'message' => 'Gagal memanggil layanan antrean: ' . $curlError,
                    'code' => 502,
                ],
            ], 502);
        }

        $decoded = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return response()->json($decoded, $statusCode ?: 200);
        }

        return response($response, $statusCode ?: 200)
            ->header('Content-Type', 'application/json');
    }
}
