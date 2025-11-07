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
        <hr>
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">
                  <u>
                    SURAT PERSETUJUAN TINDAKAN 
                    @if (is_array(@$cetak->tindakan))
                      {{ implode(", ", @$cetak->tindakan) }}
                    @endif
                  </u>
                </h3>
              </td>
            </tr>
          </table>
        
        <table class="border" style="width: 100%;">
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
            <td class="border p-1" style="text-align:center; vertical-align: top; padding:0px; font-size: 10px;" ><br>
              @php
                $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
              @endphp
                <img src="data:image/png;base64, {!! $base64 !!} "> <br>
              ({{@$dokter->nama}})
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1" colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas yang saya beri tanda/paraf dikolom kanannya, dan telah memahaminya</td>
            <td class="border p-1" style="text-align:center; vertical-align: top; padding:0px; font-size: 10px;">
              @if ($pasien->tanda_tangan)
                <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                ({{$pasien->nama}})
              @endif
            </td>
          </tr>
          <tr class="border">
            <td colspan="4" class="bold text-center p-1">Bila pasien tidak kompeten atau tidak mau menerima informasi maka penerima informasi adalah wali atau keluarga terdekat</td>
          </tr>
        </table><br><br><br>
        <div style="page-break-before: always;">
          <table class="" style="width: 100%;">
            <tr class="border">
              <td colspan="4" class="bold text-center p-1">PERNYATAAN PERSETUJUAN</td>
            </tr>
            {{-- <tr class="border">
              <td colspan="4" class="p-1" style="text-align: start;">Yang bertanda tangan dibawah ini, saya nama {{@$cetak->yang_menyatakan}}, Umur {{@$cetak->umur}} tahun, ({{@$cetak->jensi_kelamin}}),
                Alamat {{@$cetak->alamat}}.
               Dengan ini menyatakan PERSETUJUAN untuk dilakukan tindakan {{ implode(", ", @$cetak->tindakan) }} terhadap saya/{{@$cetak->persetujuan}}. Saya, yang bernama {{$pasien->nama}}.. Umur {{hitung_umur($pasien->tgllahir)}} , ({{$pasien->kelamin == "L" ? 'Laki-laki' : 'Perempuan'}}), alamat {{$pasien->alamat}} No. Rekam Medis {{$pasien->no_rm}}..
               Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti diatas kepada saya/{{@$cetak->persetujuan}}.. saya, termasuk risiko dan komplikasi yang mungkin timbul apabila tindakan tersebut tidak dilakukan. Saya bertanggung jawab secara penuh atas segala akibat yang mungkin timbul sebagai akibat persetujuan kedokteran yang direncakan oleh dokter 
               Soreang tanggal {{date('Y-m-d')}}, Jam {{date('H:i')}}.
               </td>
            </tr> --}}
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
              <tr>
                  <td style="text-align: justify; padding: 5px;">1. Yang bertandatangan dibawah ini saya menyatakan <b>SETUJU</b> untuk dilaksanakan tindakan : <b>{{@$cetak->tindakan}}</b></td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">Nama : {{$pasien->nama}}</td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">Tanggal lahir/Jenis Kel. : {{$pasien->tgllahir}}/{{$pasien->kelamin == "L" ? 'Laki-laki' : 'Perempuan'}}</td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">No. RM : {{$pasien->no_rm}}</td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">Alamat : {{$pasien->alamat}}</td>
              </tr>
              <tr>
                  <td style="text-align: justify; padding: 5px;">2. Bila pasien berusia dibawah 21 tahun/tidak dapat menerima informasi dan tidak dapat memberikan <b>PERSETUJUAN</b> tindakan kedokteran karena alasan lain, 
                    sehingga tidak dapat menandatangani surat ini, pihak rumah sakit dapat mengambil kebijaksanaan dengan memperoleh tandatangan dari orang tua, pasangan, 
                    anggota keluarga terdekat atau wali pasien</td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">a. Saya yang bertandatangan dibawah ini :</td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">Nama : {{@$cetak->persetujuan}}</td>
              </tr>
              <tr>
                  <td style="text-indent: 30px">Tanggal lahir/Jenis Kel. : {{@$cetak->tanggal_lahir}}/{{@$cetak->jenis_kelamin}}</td>
              </tr>
              <tr>
                <td style="text-indent: 30px">Alamat : {{@$cetak->alamat}}</td>
            </tr>
            <tr>
              <td style="text-indent: 30px">b. Saya menyatakan dapat menerima informasi dan mampu membuat keputusan untuk memberikan 
                <b>PERSETUJUAN</b> dilaksanakannya tindakan terhadap :</td>
            </tr>
          <tr>
              <td style="text-indent: 30px">Nama Pasien : {{$pasien->nama}}</td>
          </tr>
          <tr>
              <td style="text-indent: 30px">Tanggal lahir/Jenis Kel. : {{$pasien->tgllahir}}/{{$pasien->kelamin == "L" ? 'Laki-laki' : 'Perempuan'}}</td>
          </tr>
          <tr>
            <td style="text-indent: 30px">No. RM : {{$pasien->no_rm}}</td>
          </tr>
          <tr>
            <td style="text-indent: 30px">Alamat : {{$pasien->alamat}}</td>
          </tr>
          <tr>
            <td style="text-align: justify; padding: 5px;">3. Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti diatas kepada saya, termasuk risiko dan komplikasi yang mungkin timbul.
              Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.</td>
          </tr>
          <tr>
            <td style="text-indent: 30px">Soreang, Tanggal {{date('Y-m-d')}}, jam {{date('H:i')}}</td>
          </tr>
          </table>
          </table><br>
          <table style="width:100%" border="0">
            <tr>
                <td style="width:20%;text-align:center;">Yang Menyatakan</td>
                <td style="width:20%;text-align:center;">Dokter</td>
            </tr>
            <tr>
                <td style="width:20%;text-align:center;">
                  @if ($pasien->tanda_tangan)
                    <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="200" height="100"><br>
                  @endif
                </td>
                <td style="width:20%;text-align:center;">
                  {{-- @if (!empty(@$cetak->dokter_yang_menyatakan))
                    <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(@$cetak->dokter_yang_menyatakan, 'QRCODE', 3,3)}}" class="d-inline block" alt="barcode" />
                  @else
                  <div style="height: 100px;"></div>
                  @endif --}}
                  @php
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                  @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                </td>
            </tr>
            <tr>
                <td style="width:20%;text-align:center; vertical-align: bottom;">({{$pasien->nama}})</td>
                {{-- <td style="width:20%;text-align:center; vertical-align: bottom;">({{@$cetak->dokter_yang_menyatakan}})</td> --}}
                <td style="width:20%;text-align:center; vertical-align: bottom;">({{@$dokter->nama}})</td>
            </tr>
            <tr>
              <td colspan="2" style="width:20%;text-align:center; height:50px;">Saksi</td>
          </tr>
          <tr>
            <td colspan="2" style="width:20%;text-align:center; height:50px;">
              @if ($ttd_saksi)
                <img src="{{ public_path('images/upload/ttd/' . @$ttd_saksi->tanda_tangan) }}" alt="ttd" width="200" height="100"><br>
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2" style="width:20%;text-align:center;">({{@$cetak->saksi}})</td>
          </tr>
        </table>
        </div>
      </div>
    </div>
  </body>
</html>

