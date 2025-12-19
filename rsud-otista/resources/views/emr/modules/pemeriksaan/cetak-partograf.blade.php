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
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>

  </head>
  <body>
    @php
    $partograf = @json_decode(@$partograf->fisik, true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>PARTOGRAF</b></h5>
    <table style="width:100%">
      <tr>
        <td style="width:100px;">NAMA</td>
        <td>: {{@$reg->pasien->nama}}</td>

        <td>TGLLAHIR/UMUR</td>
        <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
      </tr>
      
      <tr>
        <td>RUANG</td>
        <td>: {{@baca_poli($reg->poli_id)}}</td>
        <td>TANGGAL</td>
        <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
      </tr>
    </table>

    <div class="col-md-6">
        <table style="width: 100%;font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
            <tr>
                <td style="width:30%; font-weight:bold;">Nama Ibu</td>
                <td>
                    {{@$partograf['nama_ibu']}}
                </td>
            </tr>
            <tr>
                <td style="width:30%; font-weight:bold;">Tanggal</td>
                <td>
                    {{@$partograf['tanggal']}}
                </td>
            </tr>
            <tr>
                <td style="width:30%; font-weight:bold;">Ketuban Pecah sejak jam</td>
                <td>
                    {{@$partograf['ketuban_pecah_sejak_jam']}}
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table style="width: 100%;font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
            <tr>
                <td style="width:30%; font-weight:bold;">Umur</td>
                <td>
                    {{@$partograf['ibu']}}
                    <label class="form-check-label" style="font-weight: bold;">G :</label>
                    {{@$partograf['G']}}
                    <label class="form-check-label" style="font-weight: bold;">P :</label>
                    {{@$partograf['P']}}
                    <label class="form-check-label" style="font-weight: bold;">A :</label>
                    {{@$partograf['A']}}
                </td>
            </tr>
            <tr>
                <td style="width:30%; font-weight:bold;">Jam</td>
                <td>
                    {{@$partograf['tanggal']}}
                </td>
            </tr>
            <tr>
                <td style="width:30%; font-weight:bold;">Mules sejak jam</td>
                <td>
                    {{@$partograf['mules_sejak_jam']}}
                </td>
            </tr>

            
        </table>
    </div>

    <div class="col-md-12" style="margin: 20px 0px;">
        <h5>Keterangan</h5>
        <table style="width: 100%; height: 150px;">
            <tr>
                <td>
                    Denyut Jantung Janin : {{@$partograf['keterangan']['denyut_jantung_janin']}}
                </td>
                <td>
                    Air Ketuban Penyusutan : {{@$partograf['keterangan']['air_ketuban_penyusutan']}}
                </td>
            </tr>
            <tr>
                <td>
                    Pembukaan Servis : {{@$partograf['keterangan']['pembukaan_servis']}}
                </td>
                <td>
                    Jam : {{@$partograf['keterangan']['jam']}}
                </td>
            </tr>
            <tr>
                <td>
                    Kontraksi Tiap 10 Menit : {{@$partograf['keterangan']['kontraksi_tiap']}}
                </td>
                <td>
                    Oksitosin : {{@$partograf['keterangan']['oksitosin']}}
                </td>
            </tr>
            <tr>
                <td>
                    CP Tetes / Menit : {{@$partograf['keterangan']['cp_tetes']}}
                </td>
                <td>
                    Obat dan cairan IV : {{@$partograf['keterangan']['obat_dan_cairan_iv']}}
                </td>
            </tr>
            <tr>
                <td>
                    Tekanan Darah : {{@$partograf['keterangan']['tekanan_darah']}}
                </td>
                <td>
                    Suhu : {{@$partograf['keterangan']['sunu']}}
                </td>
            </tr>
            <tr>
                <td>
                    Urine : {{@$partograf['keterangan']['urine']}}
                </td>
                <td>
                    Input : {{@$partograf['keterangan']['input']}}
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-12" style="text-align: center; margin-top: 3rem;">
        <div id="canvas_div" >
            @if (empty($partograf['base64']))
            -
            @else
                <img style="width: 95%;" src="data:image/png;base64,{{$partograf['base64']}}"/>
            @endif
        </div>
    </div>
  </div>
  </body>
</html>