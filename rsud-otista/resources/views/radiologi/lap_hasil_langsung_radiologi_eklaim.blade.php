<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Hasil Radiologi</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ public_path('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 2cm;
          margin-right: 2cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }

    </style>

  </head>
  <body>
    <table style="width: 100%; margin-left: 10px;">
      <tr>
        <td style="width:30%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 80px; float: left;">
        </td>
      </tr>
    </table>

    <div class="row">
      <div class="col-sm-12 text-center">
          <h4>{{config('app.nama_rs')}}</h4>
          <h5>INSTALASI RADIOLOGI</h5>
          <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
          <hr>
          <h5>HASIL PEMERIKSAAN RADIOLOGI</h5>
        <br>
      </div>
        <table style="width: 100%;font-size:11px;" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td> Nomer RM</td>
              <td>:</td>
              <td> {{ $radiologi->no_rm }} </td>

              @if ($radiologi->pengirim)
              <td> Kepada Yth.</td>
              <td>:</td>
              <td>  {{  baca_dokter($radiologi->pengirim)}} </td>
                  
              @endif
            </tr>
            <tr>
              <td> Nama Pasien</td>
              <td>:</td>
              <td> {{ $radiologi->nama }} </td>
              {{-- <td> No.Foto </td>
              <td>:</td>
              <td>
                @if ($count == 2)
                    @foreach ($tindakan as $item)
                      - {{ @$item->no_foto }}<br/>
                    @endforeach
                  @else
                    {{@$tindakan->no_foto}}
                  @endif
              </td> --}}

             
            </tr>
            <tr>
              <td> Alamat </td>
              <td>:</td>
              <td> {{ $radiologi->alamat }} </td>
              <td> Jenis </td>
              <td>:</td>
              <td>

                @if ($count == 2)
                  @foreach (@$tindakan as $item)
                    - {{ @$item->namatarif }}<br/>
                  @endforeach
                @else
                  {{@$tindakan->namatarif}}
                @endif
              </td>
            </tr>
            <tr>
              <td>Umur </td>
              <td>:</td>
              <td> {{ hitung_umur($radiologi->tgllahir) }} </td>
              {{-- <td> Diagnosa </td> --}}
              {{-- <td>:</td>
              <td> 
                @if ($count == 2)
                  @foreach ($tindakan as $item)
                    - {{ $item->diagnosa }}<br/>
                  @endforeach
                @else
                  {{$tindakan->diagnosa}}
                @endif
              </td> --}}
            </tr>
          </tbody>
        </table>
        <hr>
          {{-- <h5 style="margin-bottom: 0; margin-top: 10px;">Tindakan :
            @foreach ($folio as $item)
              {{ !empty($item->tarif_id) ? baca_tarif($item->tarif_id) : '' }},
            @endforeach
           </h5> --}}
          <h5 style="margin-bottom: 0; margin-top: 10px;font-family: Times New Roman, serif !important">Ekpertise :</h5>
          <div style=" padding: 5px; font-family: Times New Roman, serif !important;font-size: 15px;">
            {!! nl2br($radiologi->ekspertise) !!}
          </div>
        <div class="text-center" style="padding: 5px; float:right;">
          <u>Bandung, {{ date('d M Y') }}</u><br>
          Dokter Yang Memeriksa
          <hr>
          <br>
          <br>
          <br>
          <br>
          <u>{{ baca_dokter($radiologi->dokter) }}</u><br>
            SIP {{ !empty($dokter) ? $dokter->sip : '' }}
          <hr>
        </div>
        <div class="text-left" style="padding: 5px; float:left;">
          <u>Tanggal Pemeriksaan : {{  @$folio->created_at->format('d M Y H:i:s')   }}</u><br>
          <u>Tanggal Hasil : {{ date('d M Y H:i:s') }}</u>
          <hr>
          <br>
          <br>
          <br>
          <br>
        </div>
    </div>
  </body>
</html>
