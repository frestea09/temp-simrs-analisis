<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Informed Consent</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
    <style media="screen">

      .border {
        border: 1px solid black;
        border-collapse: collapse !important;
      }

      .bold {
          font-weight: bold;
      }

      .p-1 {
          padding: .2rem;
      }

      .text-center {
        text-align: center;
      }

      @media print {
        body {-webkit-print-color-adjust: exact !important;}
      }
    </style>
  </head>
  <body onload="window.print()">
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <div>
        <hr>
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">
                  <u>
                    SURAT PENUNDAAN PELAYANAN OLEH RUMAH SAKIT 
                    {{-- {{ implode(", ", @$cetak->tindakan) }} --}}
                  </u>
                </h3>
              </td>
            </tr>
          </table>
        
        <table class="border" style="width: 100%; font-size:12px;">
          <tr class="border">
            <td class="border p-1 bold text-center" colspan="4">PEMBERIAN INFORMASI</td>  
          </tr>  
          <tr class="border" style="text-align: start">
            <td class="border p-1" style="width: 35%" colspan="2">Dokter pelaksana tindakan</td>
            {{-- <td class="border p-1" style="width: 40%">&nbsp;</td> --}}
            <td class="border p-1" style="width: 25%" colspan="2">{{@$cetak->dokter_pelaksana_tindakan}}</td>
          </tr>
          <tr class="border" style="text-align: start">
            <td class="border p-1" style="width: 35%" colspan="2">Pemberi informasi</td>
            {{-- <td class="border p-1" style="width: 40%">&nbsp;</td> --}}
            <td class="border p-1" style="width: 25%" colspan="2">{{@$cetak->pemberi_informasi}}</td>
          </tr>
          <tr class="border" style="text-align: start">
            <td class="border p-1" style="width: 35%" colspan="2">Pemberian Persetujuan</td>
            {{-- <td class="border p-1" style="width: 40%">&nbsp;</td> --}}
            <td class="border p-1" style="width: 25%" colspan="2">{{@$cetak->persetujuan}}</td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">NO</td>
            <td class="border p-1 text-center" style="width: 30%">JENIS INFORMASI</td>
            <td class="border p-1 text-center" style="width: 40%">ISI INFORMASI</td>
            <td class="border p-1 text-center" style="width: 25%">CHECKLIST</td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">1</td>
            <td class="border p-1" style="width: 30%">Diagnosis</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_diagnosa_kerja}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->diagnosa_kerja == 'Diagnosa Kerja' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">2</td>
            <td class="border p-1" style="width: 30%">Dasar Diagnosis</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_diagnosa_banding}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->diagnosa_banding == 'Diagnosa Banding' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">3</td>
            <td class="border p-1" style="width: 30%">Tindakan Kedokteran</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_tindakan_dokter}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->tindakan_dokter == 'Tindakan dokter' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">4</td>
            <td class="border p-1" style="width: 30%">Indikasi Tindakan</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_indikasi_tindakan}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->indikasi_tindakan == 'Indikasi Tindakan' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">5</td>
            <td class="border p-1" style="width: 30%">Prosedur Tindakan</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_tata_cara}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->tata_cara == 'Tata Cara' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">6</td>
            <td class="border p-1" style="width: 30%">Tujuan</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_tujuan}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->tujuan == 'Tujuan' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">7</td>
            <td class="border p-1" style="width: 30%">Risiko</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_risiko_tindakan}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->risiko_tindakan == 'Risiko Tindakan' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">8</td>
            <td class="border p-1" style="width: 30%">Komplikasi</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_komplikasi}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->komplikasi == 'Komplikasi' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">9</td>
            <td class="border p-1" style="width: 30%">Prognosis</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_prognosis}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->prognosis == 'Prognosis' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">10</td>
            <td class="border p-1" style="width: 30%">Alternatif dan Risiko</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_alternatif_resiko}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->alternatif_resiko == 'Alternatif dan Resiko' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">11</td>
            <td class="border p-1" style="width: 30%">Lain-lain</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_lain_lain}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->lain_lain == 'Lain-lain' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1" colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal diatas secara benar, jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi</td>
            <td class="border p-1" style="text-align:center; vertical-align: top; padding:0px;" >
              @php
                $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
              @endphp
                <img src="data:image/png;base64, {!! $base64 !!} "> <br>
              ({{@$dokter->nama}})
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1" colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas yang saya beri tanda/paraf dikolom kanannya, dan telah memahaminya</td>
            <td class="border p-1" style="text-align:center; vertical-align: top; padding:0px;">
              @if ($pasien->tanda_tangan)
                <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                ({{$pasien->nama}})
              @endif
            </td>
          </tr>
          <tr>
            <td class="border p-1" colspan="4" style="border: none;">
              Dengan ini kami menunda pelayanan dan pengobatan pada pasien dengan alasan :
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ......................................................................................................................................................................................................
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ......................................................................................................................................................................................................
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ......................................................................................................................................................................................................
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              Soreang, Tanggal {{date('Y-m-d')}} Jam {{date('H:i')}}
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              Yang membuat pernyataan <br><br>
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              @if (!empty(@$cetak->dokter_yang_menyatakan))
                <img style="padding-left: 40px;" src="data:image/png;base64,{{DNS2D::getBarcodePNG(@$cetak->dokter_yang_menyatakan, 'QRCODE', 2,2)}}" class="d-inline block" alt="barcode" />
              @else
                <div style="height: 30px;"></div>
              @endif
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
             {{@$cetak->dokter_yang_menyatakan}} <br><br>
            </td>
          </tr>
          <tr>
            <td style="border: none;" colspan="4">
              *  Bila pasien tidak kompeten atau tidak mau menerima informasi maka penerima informasi adalah wali atau keluarga terdekat
            </td>
          </tr>
        </table>
        </div>
        <div style="page-break-before: always;">
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="width:10%;">
                <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
              </td>
              <td style="text-align: center">
                <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
                <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
              </td>
              <td style="width:10%;">
                <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
              </td>
            </tr>
          </table>
          <hr>
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">
                  <u>
                    SURAT PENUNDAAN PELAYANAN OLEH PASIEN
                    {{-- {{ implode(", ", @$cetak->tindakan) }} --}}
                  </u>
                </h3>
              </td>
            </tr>
          </table>
        
        <table class="border" style="width: 100%; font-size:12px;">
          <tr class="border">
            <td class="border p-1 bold text-center" colspan="4">PEMBERIAN INFORMASI</td>  
          </tr>  
          <tr class="border" style="text-align: start">
            <td class="border p-1" style="width: 35%" colspan="2">Dokter pelaksana tindakan</td>
            {{-- <td class="border p-1" style="width: 40%">&nbsp;</td> --}}
            <td class="border p-1" style="width: 25%" colspan="2">{{@$cetak->dokter_pelaksana_tindakan}}</td>
          </tr>
          <tr class="border" style="text-align: start">
            <td class="border p-1" style="width: 35%" colspan="2">Pemberi informasi</td>
            {{-- <td class="border p-1" style="width: 40%">&nbsp;</td> --}}
            <td class="border p-1" style="width: 25%" colspan="2">{{@$cetak->pemberi_informasi}}</td>
          </tr>
          <tr class="border" style="text-align: start">
            <td class="border p-1" style="width: 35%" colspan="2">Pemberian Persetujuan</td>
            {{-- <td class="border p-1" style="width: 40%">&nbsp;</td> --}}
            <td class="border p-1" style="width: 25%" colspan="2">{{@$cetak->persetujuan}}</td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">NO</td>
            <td class="border p-1 text-center" style="width: 30%">JENIS INFORMASI</td>
            <td class="border p-1 text-center" style="width: 40%">ISI INFORMASI</td>
            <td class="border p-1 text-center" style="width: 25%">CHECKLIST</td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">1</td>
            <td class="border p-1" style="width: 30%">Diagnosa Kerja</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_diagnosa_kerja}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->diagnosa_kerja == 'Diagnosa Kerja' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">2</td>
            <td class="border p-1" style="width: 30%">Diagnosa Banding</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_diagnosa_banding}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->diagnosa_banding == 'Diagnosa Banding' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">3</td>
            <td class="border p-1" style="width: 30%">Tindakan Dokter</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_tindakan_dokter}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->tindakan_dokter == 'Tindakan dokter' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">4</td>
            <td class="border p-1" style="width: 30%">Indikasi Tindakan</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_indikasi_tindakan}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->indikasi_tindakan == 'Indikasi Tindakan' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">5</td>
            <td class="border p-1" style="width: 30%">Tata Cara</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_tata_cara}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->tata_cara == 'Tata Cara' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">6</td>
            <td class="border p-1" style="width: 30%">Tujuan</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_tujuan}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->tujuan == 'Tujuan' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">7</td>
            <td class="border p-1" style="width: 30%">Risiko Tindakan</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_risiko_tindakan}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->risiko_tindakan == 'Risiko Tindakan' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">8</td>
            <td class="border p-1" style="width: 30%">Komplikasi</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_komplikasi}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->komplikasi == 'Komplikasi' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">9</td>
            <td class="border p-1" style="width: 30%">Prognosis</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_prognosis}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->prognosis == 'Prognosis' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">10</td>
            <td class="border p-1" style="width: 30%">Alternatif dan Risiko</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_alternatif_resiko}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->alternatif_resiko == 'Alternatif dan Resiko' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border text-center" style="text-align: start">
            <td class="border p-1 text-center" style="width: 5%">11</td>
            <td class="border p-1" style="width: 30%">Lain-lain</td>
            <td class="border p-1" style="width: 40%">{{@$cetak->jenis_informasi->isi_lain_lain}}</td>
            <td class="border p-1 text-center" style="width: 25%">
              <input class="form-check-input"
                {{ @$cetak->jenis_informasi->lain_lain == 'Lain-lain' ? 'checked' : '' }}
                type="checkbox">
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1" colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal diatas secara benar, jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi</td>
            <td class="border p-1" style="text-align:center; vertical-align: top; padding:0px;" ></td>
          </tr>
          <tr class="border">
            <td class="border p-1" colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas yang saya beri tanda/paraf dikolom kanannya, dan telah memahaminya</td>
            <td class="border p-1" style="text-align:center; vertical-align: top; padding:0px;"></td>
          </tr>
          <tr>
            <td class="border p-1" colspan="4" style="border: none;">
              Dengan ini saya selaku pasien/keluarga menunda pelayanan dan atau pengobatan dengan alasan :
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ......................................................................................................................................................................................................
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ......................................................................................................................................................................................................
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ......................................................................................................................................................................................................
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              Soreang, Tanggal {{date('Y-m-d')}} Jam {{date('H:i')}}
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              Yang membuat pernyataan <br><br>
            </td>
          </tr>
          <tr>
            <td style="padding-left: 20px; border: none;" colspan="4">
              ....................................................
            </td>
          </tr>
          <tr>
            <td style="border: none;" colspan="4">
              *  Bila pasien tidak kompeten atau tidak mau menerima informasi maka penerima informasi adalah wali atau keluarga terdekat
            </td>
          </tr>
        </table>
        </div>
      </div>
  </body>
</html>

