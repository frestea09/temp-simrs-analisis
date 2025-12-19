<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
      @page {
        padding-bottom: 1cm;
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>
    <style>
        textarea[name="hasil_pemeriksaan"] {
            padding: 0;
            margin: 0;
            font-family: inherit;
        }
    </style>
  </head>
  <body>
    <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%; text-align: end;" class="pull-right">
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
  <div class="col-md-12">
    <table style="width:100%">
      <tr>
        <td style="width:100px;">Nomor RM</td>
        <td>: {{@$pasien->no_rm}}</td>
      </tr>
      
      <tr>
        <td>Nama Pasien</td>
        <td>: {{@$pasien->nama}}</td>
      </tr>

      <tr>
        <td>Umur</td>
        <td>: {{hitung_umur(@$pasien->tgllahir)}}</td>
      </tr>

      <tr>
        <td>Alamat</td>
        <td>: {{@$pasien->alamat}}</td>
      </tr>

      <tr>
        <td colspan="2">Hasil Pemeriksaan</td>
      </tr>
      <tr>
        <td colspan="2">
            @php
                $hasilPemeriksaan = '';
                if (isset($penunjang)) {
                    if (!is_null($penunjang->hasil_echo)) {
                        $hasilPemeriksaan .= "Echo:\n{$penunjang->hasil_echo}\n\n";
                    }
                    if (!is_null($penunjang->hasil_ekg)) {
                        $hasilPemeriksaan .= "EKG:\n{$penunjang->hasil_ekg}\n\n";
                    }
                    if (!is_null($penunjang->hasil_eeg)) {
                        $hasilPemeriksaan .= "EEG:\n{$penunjang->hasil_eeg}\n\n";
                    }
                    if (!is_null($penunjang->hasil_usg)) {
                        $hasilPemeriksaan .= "USG Kandungan:\n{$penunjang->hasil_usg}\n\n";
                    }
                    if (!is_null($penunjang->hasil_ctg)) {
                        $hasilPemeriksaan .= "CTG:\n{$penunjang->hasil_ctg}\n\n";
                    }
                    if (!is_null($penunjang->hasil_spirometri)) {
                        $hasilPemeriksaan .= "Spirometri:\n{$penunjang->hasil_spirometri}\n\n";
                    }
                    if (!is_null($penunjang->hasil_lainnya)) {
                        $hasilPemeriksaan .= "Lainnya:\n{$penunjang->hasil_lainnya}\n\n";
                    }
                }
                $hasilPemeriksaan = trim($hasilPemeriksaan);
            @endphp
            <textarea name="hasil_pemeriksaan" rows="50" style="height: 500px; width: 100%;">{{ $hasilPemeriksaan }}</textarea>
        </td>                
      </tr>
    </table>
    
    <table style="width:100%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;text-align:center">
              Soreang, {{date('d-m-Y', strtotime(@$penunjang->created_at))}}<br>
              Dokter
            </td>
        </tr>
        <tr style="height: 80px">
            <td style="width: 50%;vertical-align: bottom;text-align:center"></td>
            <td style="width: 50%; vertical-align: bottom;text-align:center">
                @php
                    // $dokter = Modules\Registrasi\Entities\Registrasi::find($reg->id);
                    $base64 = base64_encode(
                        \QrCode::format('png')
                            ->size(75)
                            ->merge('/public/images/' . configrs()->logo, 0.3)
                            ->errorCorrection('H')
                            ->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->sip . ' , ' . @$reg->created_at)
                    );
                @endphp
                <img src="data:image/png;base64, {!! $base64 !!} ">
            </td>
        </tr>
        <tr style="height: 80px">
            <td style="width: 50%;vertical-align: bottom;text-align:center"></td>
            <td style="width: 50%; vertical-align: bottom;text-align:center">{{ Auth::user()->name }}</td>
        </tr>
    </table>
  </body>
</html>