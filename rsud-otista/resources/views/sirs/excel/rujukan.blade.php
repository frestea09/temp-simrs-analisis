<table>
    <thead>
        <tr>
            <th colspan="11">Formulir RL 3.14</th>
        </tr>
        <tr>
            <th colspan="11">RL 3.14 Kegiatan Rujukan</th>
        </tr>
    </thead>
  </table>
  <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
    <thead>
    <tr>
          <th class="text-center" rowspan="2" valign="top">No</th>
          <th class="text-center" rowspan="2" valign="top">JENIS SPESIALISASI</th>
          <th class="text-center" colspan="6" valign="top">RUJUKAN</th>
          <th class="text-center" colspan="3">DIRUJUK</th>
      </tr>
      <tr>
          <th class="text-center">DITERIMA DARI PUSKESMAS</th>
          <th class="text-center">DITERIMA DARI FASILITAS KES. LAIN</th>
          <th class="text-center">DITERIMA DARI RS LAIN</th>
          <th class="text-center">DIKEMBALIKAN KE PUSKESMAS</th>
          <th class="text-center">DIKEMBAlIKAN KE FASILITAS KES.LAIN</th>
          <th class="text-center">DIKEMBALIKAN KE RS ASAL</th>
          <th class="text-center">PASIEN RUJUKAN</th>
          <th class="text-center">PASIEN DATANG SENDIRI</th>
          <th class="text-center">DITERIMA KEMBALI</th>
      </tr>
    </thead>
    <tbody>
      @if ( isset($kegitan_rujukan) )
        @php
            $diterimaPuskesmas = 0;
            $diterimaFaskes = 0;
            $diterimaRS = 0;
            $pasienRujukan = 0;
            $pasienSendiri = 0;
        @endphp
        @foreach ($kegitan_rujukan as $key => $d)
        @php
            $diterimaPuskesmas += $d['data']['rujukan'][1]['Puskesmas'];
            $diterimaFaskes += $d['data']['rujukan'][2]['Dokter Praktek'] + $d['data']['rujukan'][4]['Bidan'] + $d['data']['rujukan'][5]['Balai Pengobatan'];
            $diterimaRS += $d['data']['rujukan'][3]['Rumah Sakit'];
            $pasienRujukan += $d['data']['rujukan'][2]['Dokter Praktek'] + $d['data']['rujukan'][4]['Bidan'] + $d['data']['rujukan'][5]['Balai Pengobatan'];
            $pasienSendiri += $d['data']['rujukan'][0]['Datang Sendiri'];
        @endphp
          <tr>
            <td>{{ ($key + 1) }}</td>
            <td>{{ $d['poli'] }}</td>
            <td>{{ $d['data']['rujukan'][1]['Puskesmas'] }}</td>
            <td>{{ $d['data']['rujukan'][2]['Dokter Praktek'] + $d['data']['rujukan'][4]['Bidan'] + $d['data']['rujukan'][5]['Balai Pengobatan'] }}</td>
            <td>{{ $d['data']['rujukan'][3]['Rumah Sakit'] }}</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>{{ $d['data']['rujukan'][2]['Dokter Praktek'] + $d['data']['rujukan'][4]['Bidan'] + $d['data']['rujukan'][5]['Balai Pengobatan'] }}</td>
            <td>{{ $d['data']['rujukan'][0]['Datang Sendiri'] }}</td>
            <td>0</td>
          </tr>
        @endforeach
        <tr>
          <th>###</th>
          <th>Total</th>
          <th>{{ $diterimaPuskesmas }}</th>
          <th>{{ $diterimaFaskes }}</th>
          <th>{{ $diterimaRS }}</th>
          <th>{{ 0 }}</th>
          <th>{{ 0 }}</th>
          <th>{{ 0 }}</th>
          <th>{{ $pasienRujukan }}</th>
          <th>{{ $pasienSendiri }}</th>
          <th>{{ 0 }}</th>
        </tr>
      @endif
      </tbody>
    </table>