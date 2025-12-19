<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Sakit</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
   
      .footer{
          padding-top: 20px;
          margin-left: 330px;
      }

      .table-border {
      border: 1px solid black;
      border-collapse: collapse;
      }
    </style>
  </head>
  <body>
    {{-- Pernyataan DPJP --}}

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
                <h3 style="font-size:17px;"><u>SURAT PERNYATAAN DPJP</u></h3><br/>
              </td>
            </tr>
        </table>
          <br/>
          <table>
            <tr>
              <td colspan="3">Yang bertanda tangan dibawah ini :</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Nama</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pernyataan_dpjp']['nama']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Bidang Kewenangan Klinis</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pernyataan_dpjp']['bidang_kewenangan_klinis']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>SMF</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pernyataan_dpjp']['smf']}}</td>
            </tr>
            <tr>
              <td colspan="3">
                <br/><br/>
                Dengan ini menyatakan bersedia untuk menjadi Dokter Penanggung Jawab (DPJP) atas pasien :
              </td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Nama Pasien</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$pasien->nama}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Tanggal Lahir</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$pasien->tgllahir}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>No RM</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$pasien->no_rm}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Tempat Dirawat</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@baca_kamar(@$reg->rawat_inap->kamar)}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Diagnosa</span></td>
              <td><span>:</span></td>
              <td style="width: 58%;">
                  @if (!empty(@$reg->icd10s))
                    @foreach (@$reg->icd10s as $icd10s)
                      - {{baca_icd10(@$icd10s->icd10) . '(' . @$icd10s->icd10 . ')'}}
                    @endforeach
                  @endif
              </td>
            </tr>
          </table>
        <br><br><br><br> <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;">Soreang, {{tanggalkuitansi(date('d-m-Y'))}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Dokter,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td style="width:80px;text-align:center;">
                  @if (!empty($surat['pernyataan_dpjp']['nama']))
                    @php
                      @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($surat['pernyataan_dpjp']['nama']))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!}">
                  @endif
                </td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:80px;text-align:center;">({{@$surat['pernyataan_dpjp']['nama']}})</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
        </table>
      </div>
    </div>
    

    {{-- Pengalihan DPJP --}}
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
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;"><u>SURAT PENGALIHAN DPJP</u></h3><br/>
              </td>
            </tr>
        </table>
          <br/>
          <table>
            <tr>
              <td colspan="3">Yang bertandatangan di bawah ini, dengan ini mengalihkan pasien kepada :</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Nama</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pengalihan_dpjp']['nama']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Bidang Kewenangan Klinis</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pengalihan_dpjp']['bidang_kewenangan_klinis']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>SMF</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pengalihan_dpjp']['smf']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Alasan</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['pengalihan_dpjp']['alasan']}}</td>
            </tr>
            <tr>
              <td colspan="3" style="width: 100%;"><span>Sudah diverifikasi {{@$surat['pengalihan_dpjp']['nama']}} pada {{date('d-m-Y H:i:s', strtotime($cetak->verifikasi))}}</span></td>
            </tr>
            <tr>
              <td colspan="3">
                <br/><br/>
                Demikian surat penyataan ini dibuat untuk digunakan sebagaimana mestinya dengan penuh tanggung jawab.
              </td>
            </tr>
          </table>
        <br><br><br><br> <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;">Soreang, {{tanggalkuitansi(date('d-m-Y'))}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Dokter,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td style="width:80px;text-align:center;">
                  @if (!empty($surat['pengalihan_dpjp']['nama']))
                    @php
                      // @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$surat['pengalihan_dpjp']['nama']))
                      @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dpjp_inap->nama ?? @$dokter->nama))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!}">
                  @endif
                </td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                {{-- <td style="width:80px;text-align:center;">({{@$surat['pengalihan_dpjp']['nama']}})</td> --}}
                <td style="width:80px;text-align:center;">({{@$dpjp_inap->nama ?? @$dokter->nama}})</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
        </table>
      </div>
    </div>

    {{-- Rawat Bersama --}}
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
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;"><u>SURAT RAWAT BERSAMA</u></h3><br/>
              </td>
            </tr>
        </table>
          <br/>
          <table>
            <tr>
              <td colspan="3">Yang bertandatangan di bawah ini, dengan ini melakukan rawat bersama pasien kepada :</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Nama</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['rawat_bersama']['nama']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Bidang Kewenangan Klinis</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['rawat_bersama']['bidang_kewenangan_klinis']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>SMF</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['rawat_bersama']['smf']}}</td>
            </tr>
            <tr>
              <td style="width:40%;"><span>Alasan</span></td>
              <td><span>:</span></td>
              <td style="width: 58%">{{@$surat['rawat_bersama']['alasan']}}</td>
            </tr>
            <tr>
              <td colspan="3">
                <br/><br/>
                Demikian surat penyataan ini dibuat untuk digunakan sebagaimana mestinya dengan penuh tanggung jawab.
              </td>
            </tr>
          </table>
        <br><br><br><br> <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;">Soreang, {{tanggalkuitansi(date('d-m-Y'))}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Dokter,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td style="width:80px;text-align:center;">
                  @if (!empty($surat['rawat_bersama']['nama']))
                    @php
                      // @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$surat['rawat_bersama']['nama']))
                      @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dpjp_inap->nama ?? @$dokter->nama))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!}">
                  @endif
                </td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                {{-- <td style="width:80px;text-align:center;">({{@$surat['rawat_bersama']['nama']}})</td> --}}
                <td style="width:80px;text-align:center;">({{@$dpjp_inap->nama ?? @$dokter->nama}})</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
        </table>
      </div>
    </div>
  </body>
</html>

