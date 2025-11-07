<?php

namespace App\Http\Controllers;

use App\EmrInapPerencanaan;
use App\TandaTangan;
use Illuminate\Http\Request;
use Flashy;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Barryvdh\DomPDF\Facade as PDF;

class SignatureController extends Controller
{
    public function index()
    {
        return view('signaturePad');
    }

    public function upload(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);
        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signSuratPulPak($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        $pdf = PDF::loadView('kasir.cetakSuratPulangPaksa', compact('registrasi'));
        $pdf->setPaper('A4', 'potret');
        $pdfContent = $pdf->output();
        $pdfBase64 = base64_encode($pdfContent);
        return view('ttd.ttd-surat-pulpak', compact('registrasi_id', 'pdfBase64', 'registrasi'));
    }

    public function signSuratPulPakAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'surat-pulang-paksa')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'surat-pulang-paksa',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signPersetujuanPasien($EmrInapPerencanaan_id)
    {
        $data = EmrInapPerencanaan::find($EmrInapPerencanaan_id);
        return view('ttd.ttd-persetujuan-pasien', compact('data'));
    }

    public function signPersetujuanPasienAction(Request $request, $EmrInapPerencanaan_id)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'persetujuan-pasien')->where('emr_inap_perencanaan_id', $EmrInapPerencanaan_id)->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'emr_inap_perencanaan_id' => $EmrInapPerencanaan_id,
            'jenis_dokumen' => 'persetujuan-pasien',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signLayananRehab($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        return view('ttd.ttd-layanan-rehab', compact('registrasi'));
    }

    public function signLayananRehabAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'layanan-rehab')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'layanan-rehab',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }
    
    public function signProgramTerapi($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        return view('ttd.ttd-program-terapi', compact('registrasi'));
    }

    public function signProgramTerapiAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'program-terapi')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'program-terapi',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signEresume($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        return view('ttd.ttd-eresume', compact('registrasi'));
    }

    public function signEresumeAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'e-resume')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'nama_penanggung_jawab' => $request->nama,
            'jenis_dokumen' => 'e-resume',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signGeneralConsent($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        return view('ttd.ttd-general-consent', compact('registrasi'));
    }

    public function signGeneralConsentAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'general-consent')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'general-consent',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signPasien($pasien_id)
    {
        $pasien = Pasien::find($pasien_id);
        return view('ttd.ttd-pasien', compact('pasien'));
    }

    public function signPasienAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        Pasien::where('id', $request->pasien_id)->update(['tanda_tangan' => $fileName]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signSaksiPaps($id)
    {
        $paps = EmrInapPerencanaan::find($id);
        $registrasi = Registrasi::find($paps->registrasi_id);
        $ket = json_decode($paps->keterangan);
        return view('ttd.ttd-saksi-paps', compact('registrasi', 'ket', 'paps'));
    }

    public function signSaksiPapsAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)
            ->where('emr_inap_perencanaan_id', $request->riwayat_id)
            ->where('jenis_dokumen', 'saksi-paps')
            ->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'emr_inap_perencanaan_id' => $request->riwayat_id,
            'jenis_dokumen' => 'saksi-paps',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signInformedConsentSaksi($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        $perencanaan = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'informed-consent')->first();
        $data       = json_decode(@$perencanaan->keterangan, true);
        return view('ttd.ttd-informed-consent-saksi', compact('registrasi', 'data'));
    }

    public function signInformedConsentSaksiAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'informed-consent-saksi')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'informed-consent-saksi',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signVaksinasiSaksi($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        $perencanaan = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'persetujuan-vaksinasi')->first();
        $data       = json_decode(@$perencanaan->keterangan, true);
        return view('ttd.ttd-vaksinasi-saksi', compact('registrasi', 'data'));
    }

    public function signVaksinasiSaksiAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'vaksinasi-saksi')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'vaksinasi-saksi',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }

    public function signVaksinasiPemberi($registrasi_id)
    {
        $registrasi = Registrasi::find($registrasi_id);
        $perencanaan = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'persetujuan-vaksinasi')->first();
        $data       = json_decode(@$perencanaan->keterangan, true);
        return view('ttd.ttd-vaksinasi-pemberi', compact('registrasi', 'data'));
    }

    public function signVaksinasiPemberiAction(Request $request)
    {
        $folderPath = public_path('images/upload/ttd/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        TandaTangan::where('registrasi_id', $request->registrasi_id)->where('jenis_dokumen', 'vaksinasi-pemberi')->delete();

        TandaTangan::create([
            'registrasi_id' => $request->registrasi_id,
            'jenis_dokumen' => 'vaksinasi-pemberi',
            'tanda_tangan' => $fileName
        ]);

        return response()->json(['sukses' => true, 'path_signature' => $file]);
    }
}
