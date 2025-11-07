<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Pemantauan Transfusi</title>
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

      .border {
        border: 1px solid black;
      }
   

    </style>
  </head>
  <body>
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
      <br><br>
      <div class="col-sm-12 text-center">
          <hr>
          <table>
            <tr>
              <td colspan="3"><b>Informasi Pasien</b></td>
            </tr>
            <tr>
              <td style="width:100px;"><span>Nama</span></td>
              <td><span style="margin-left:20px;">:</span></td>
              <td>{{$pasien->nama}}</td>
            </tr>
            <tr>
              <td style="width:100px;"><span>Umur</span></td>
              <td><span style="margin-left:20px;">:</span></td>
              <td>{{@hitung_umur($pasien->tgllahir, 'Y')}}</td>
            </tr>
            <tr>
              <td style="width:100px;"><span>Alamat</span></td>
              <td><span style="margin-left:20px;">:</span></td>
              <td>{{$pasien->alamat}}</td>
            </tr>
          </table>
		  </div>
      <br><br>
      <div class="col-md-12">
        <table class='table table-striped table-bordered table-hover table-condensed border' style="width: 100%;">
          <thead class="border">
            <tr class="border">
              <th colspan="11" class="text-center border">PEMANTAUAN TRANSFUSI</th>
            </tr>
            <tr class="border">
              <th rowspan="2" class="text-center border">Tanggal</th>
              <th colspan="3" class="text-center border">&nbsp;</th>
              <th colspan="4" class="text-center border"></th>
              <th rowspan="2" class="text-center border">Tindakan</th>
              <th rowspan="2" class="text-center border">Ket</th>
            </tr>
            <tr class="border">
              <th class="text-center border">Labu</th>
              <th class="text-center border">Mulai Jam</th>
              <th class="text-center border">Selesai Jam</th>
              <th class="text-center border">0 Jam I</th>
              <th class="text-center border">0 Jam II</th>
              <th class="text-center border">0 Jam III</th>
              <th class="text-center border">0 Jam IV</th>
            </tr>
          </thead>
          <tbody>
                @php
                  $data = json_decode(@$cetak->fisik, true);
                @endphp
                <tr class="border">
                  <td class="border">{{ @$data['pemantauan_transfusi']['tanggal'] }}</td>
                  <td class="border">{{ @$data['pemantauan_transfusi']['labu_kg'].' Kg' }}</td>
                  <td class="border">{{ @$data['pemantauan_transfusi']['mulai_jam'] }}</td>
                  <td class="border">{{ @$data['pemantauan_transfusi']['selesai_jam'] }}</td>
                  <td class="border">
                    {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam1']['tensi'] }} <br>
                    {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam1']['nadi'] }} <br>
                    {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam1']['suhu'] }}
                  </td>
                  <td class="border">
                    {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam2']['tensi'] }} <br>
                    {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam2']['nadi'] }} <br>
                    {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam2']['suhu'] }}
                  </td>
                  <td class="border">
                    {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam3']['tensi'] }} <br>
                    {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam3']['nadi'] }} <br>
                    {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam3']['suhu'] }}
                  </td>
                  <td class="border">
                    {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam4']['tensi'] }} <br>
                    {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam4']['nadi'] }} <br>
                    {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam4']['suhu'] }}
                  </td>
                  <td class="border">{{ @$data['pemantauan_transfusi']['tindakan'] }}</td>
                  <td class="border">{{ @$data['pemantauan_transfusi']['keterangan'] }}</td>
                </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>

