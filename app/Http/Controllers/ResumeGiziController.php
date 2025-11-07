<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmrGizi;
use App\EmrInapPemeriksaan;
use Modules\Registrasi\Entities\Registrasi;
use PDF;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Auth;
use Flashy;

class ResumeGiziController extends Controller
{
    public function cetakPDFCPPT($reg_id, $id, Request $request)
    {
        $reg    = Registrasi::find($reg_id);
        $soap   = EmrGizi::find($id);

        // TTE
        if ($request->method() == "POST") {
            if (tte()) {
                $cetak_tte = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_cppt', compact('reg', 'soap', 'cetak_tte'));
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
    
                // Create temp pdf eresep file
                $filePath = uniqId() . '-cppt-gizi.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
    
                log_esign($reg->id, $tte->response, "cppt-gizi", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                    $soap->save();
                    Flashy::success('Berhasil melakukan proses TTE dokumen !');
                    return redirect()->back();
                } elseif ($tte->httpStatusCode == 400) {
                    if (isset($resp->error)) {
                        Flashy::error($resp->error);
                        return redirect()->back();
                    }
                } elseif ($tte->httpStatusCode == 500) {
                    Flashy::error($tte->response);
                    return redirect()->back();
                }
                Flashy::error('Gagal melakukan proses TTE dokumen !');
            } else {
                $tte_nonaktif = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_cppt', compact('reg', 'soap', 'tte_nonaktif'));
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
                $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
                $soap->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        $pdf    = PDF::loadView('resume.gizi.cetak_pdf_cppt', compact('reg', 'soap'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('resume-laporan.pdf');
    }

    public function cetakSkriningGiziDewasa($reg_id, $id, Request $request)
    {
        $data['data']    = EmrInapPemeriksaan::find($id);
        $data['reg']     = Registrasi::find($reg_id);
        $data['nutrisi']  = json_decode(@$data['data']->nutrisi, true);

        if ($request->method() == "POST") {
            if (tte()) {
                $data['cetak_tte'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_dewasa', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
    
                // Create temp pdf eresep file
                $filePath = uniqId() . '-skrining-gizi-dewasa.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
    
                log_esign($data['reg']->id, $tte->response, "skrining-gizi-dewasa", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $tte_file = [
                        'tte_skrining_gizi' => convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file)
                    ];
                    $data['data']->tte = json_encode($tte_file);
                    $data['data']->save();
                    Flashy::success('Berhasil melakukan proses TTE dokumen !');
                    return redirect()->back();
                } elseif ($tte->httpStatusCode == 400) {
                    if (isset($resp->error)) {
                        Flashy::error($resp->error);
                        return redirect()->back();
                    }
                } elseif ($tte->httpStatusCode == 500) {
                    Flashy::error($tte->response);
                    return redirect()->back();
                }
                Flashy::error('Gagal melakukan proses TTE dokumen !');
            } else {
                $data['tte_nonaktif'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_dewasa', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
                $tte_file = [
                    'tte_skrining_gizi' => convertTTE("dokumen_tte", base64_encode($pdfContent))
                ];
                $data['data']->tte = json_encode($tte_file);
                $data['data']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }
        
        $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_dewasa', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }

    public function cetakSkriningGiziAnak($reg_id, $id, Request $request)
    {
        $data['data']    = EmrInapPemeriksaan::find($id);
        $data['reg']     = Registrasi::find($reg_id);
        $data['nutrisi']  = json_decode(@$data['data']->nutrisi, true);

        if ($request->method() == "POST") {
            if (tte()) {
                $data['cetak_tte'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_anak', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
    
                // Create temp pdf eresep file
                $filePath = uniqId() . '-skrining-gizi-anak.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
    
                log_esign($data['reg']->id, $tte->response, "skrining-gizi-anak", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $tte_file = [
                        'tte_skrining_gizi' => convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file)
                    ];
                    $data['data']->tte = json_encode($tte_file);
                    $data['data']->save();
                    Flashy::success('Berhasil melakukan proses TTE dokumen !');
                    return redirect()->back();
                } elseif ($tte->httpStatusCode == 400) {
                    if (isset($resp->error)) {
                        Flashy::error($resp->error);
                        return redirect()->back();
                    }
                } elseif ($tte->httpStatusCode == 500) {
                    Flashy::error($tte->response);
                    return redirect()->back();
                }
                Flashy::error('Gagal melakukan proses TTE dokumen !');
            } else {
                $data['tte_nonaktif'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_anak', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
                $tte_file = [
                    'tte_skrining_gizi' => convertTTE("dokumen_tte", base64_encode($pdfContent))
                ];
                $data['data']->tte = json_encode($tte_file);
                $data['data']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_anak', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }

    public function cetakSkriningGiziMaternitas($reg_id, $id, Request $request)
    {
        $data['data']    = EmrInapPemeriksaan::find($id);
        $data['reg']     = Registrasi::find($reg_id);
        $data['skrining'] = @json_decode(@$data['data']->fisik, true)['skrining_nutrisi_dewasa'];

        if ($request->method() == "POST") {
            if (tte()) {
                $data['cetak_tte'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_maternitas', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
    
                // Create temp pdf eresep file
                $filePath = uniqId() . '-skrining-gizi-maternitas.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
    
                log_esign($data['reg']->id, $tte->response, "skrining-gizi-maternitas", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $tte_file = [
                        'tte_skrining_gizi' => convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file)
                    ];
                    $data['data']->tte = json_encode($tte_file);
                    $data['data']->save();
                    Flashy::success('Berhasil melakukan proses TTE dokumen !');
                    return redirect()->back();
                } elseif ($tte->httpStatusCode == 400) {
                    if (isset($resp->error)) {
                        Flashy::error($resp->error);
                        return redirect()->back();
                    }
                } elseif ($tte->httpStatusCode == 500) {
                    Flashy::error($tte->response);
                    return redirect()->back();
                }
                Flashy::error('Gagal melakukan proses TTE dokumen !');
            } else {
                $data['tte_nonaktif'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_maternitas', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
                $tte_file = [
                    'tte_skrining_gizi' => convertTTE("dokumen_tte", base64_encode($pdfContent))
                ];
                $data['data']->tte = json_encode($tte_file);
                $data['data']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_maternitas', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }

    public function cetakSkriningGiziPerinatologi($reg_id, $id, Request $request)
    {
        $data['data']    = EmrInapPemeriksaan::find($id);
        $data['reg']     = Registrasi::find($reg_id);
        $data['skrining'] = @json_decode(@$data['data']->fisik, true)['skrining_gizi_neonatus'];

        if ($request->method() == "POST") {
            if (tte()) {
                $data['cetak_tte'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_perinatologi', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
    
                // Create temp pdf eresep file
                $filePath = uniqId() . '-skrining-gizi-perinatologi.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
    
                log_esign($data['reg']->id, $tte->response, "skrining-gizi-perinatologi", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $tte_file = [
                        'tte_skrining_gizi' => convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file)
                    ];
                    $data['data']->tte = json_encode($tte_file);
                    $data['data']->save();
                    Flashy::success('Berhasil melakukan proses TTE dokumen !');
                    return redirect()->back();
                } elseif ($tte->httpStatusCode == 400) {
                    if (isset($resp->error)) {
                        Flashy::error($resp->error);
                        return redirect()->back();
                    }
                } elseif ($tte->httpStatusCode == 500) {
                    Flashy::error($tte->response);
                    return redirect()->back();
                }
                Flashy::error('Gagal melakukan proses TTE dokumen !');
            } else {
                $data['tte_nonaktif'] = true;
                $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_perinatologi', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
                $tte_file = [
                    'tte_skrining_gizi' => convertTTE("dokumen_tte", base64_encode($pdfContent))
                ];
                $data['data']->tte = json_encode($tte_file);
                $data['data']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        $pdf    = PDF::loadView('resume.gizi.cetak_pdf_skrining_perinatologi', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }

    public function cetakPengkajianGizi($reg_id, $id, Request $request)
    {
        $data['data']    = EmrInapPemeriksaan::find($id);
        $data['reg']     = Registrasi::find($reg_id);
        $data['assesment'] = json_decode(@$data['data']->fisik, true);

        if ($request->method() == "POST") {
            if (tte()) {
                $data['cetak_tte'] = true;
                $pdf            = PDF::loadView('resume.gizi.cetak_pdf_pengkajian_gizi', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
    
                // Create temp pdf eresep file
                $filePath = uniqId() . '-pengkajian-gizi.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
    
                log_esign($data['reg']->id, $tte->response, "pengkajian-gizi", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $data['data']->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                    $data['data']->save();
                    Flashy::success('Berhasil melakukan proses TTE dokumen !');
                    return redirect()->back();
                } elseif ($tte->httpStatusCode == 400) {
                    if (isset($resp->error)) {
                        Flashy::error($resp->error);
                        return redirect()->back();
                    }
                } elseif ($tte->httpStatusCode == 500) {
                    Flashy::error($tte->response);
                    return redirect()->back();
                }
                Flashy::error('Gagal melakukan proses TTE dokumen !');
            } else {
                $data['tte_nonaktif'] = true;
                $pdf            = PDF::loadView('resume.gizi.cetak_pdf_pengkajian_gizi', $data);
                $pdf->setPaper('A4', 'landscape');
                $pdfContent = $pdf->output();
                $data['data']->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
                $data['data']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        $pdf  = PDF::loadView('resume.gizi.cetak_pdf_pengkajian_gizi', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }
}
