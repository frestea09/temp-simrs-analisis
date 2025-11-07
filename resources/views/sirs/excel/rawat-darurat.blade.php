<table>
    <thead>
        <tr>
            <th colspan="11">Formulir RL 3.2</th>
        </tr>
        <tr>
            <th colspan="11">RL 3.2 Kujungan Rawat Darurat</th>
        </tr>
    </thead>
</table>

<table class='table-striped table-bordered table-hover table-condensed table' id="data-table">
    <thead>
        <tr>
            <th class="text-center">&nbsp;</th>
            <th class="text-center">&nbsp;</th>
            <th class="text-center" colspan="2" valign="top">TOTAL PASIEN</th>
            <th class="text-center" colspan="3">TINDAK LANJUT PELAYANAN</th>
            <th class="text-center">&nbsp;</th>
            <th class="text-center">&nbsp;</th>
            <th class="text-center" colspan="2">DOA</th>
        </tr>
        <tr>
            <th class="text-center" valign="top">No</th>
            <th class="text-center" valign="top">JENIS PELAYANAN</th>
            <th class="text-center">RUJUKAN</th>
            <th class="text-center">NON RUJUKAN</th>
            <th class="text-center">DIRAWAT</th>
            <th class="text-center">DIRUJUK</th>
            <th class="text-center">PULANG</th>
            <th class="text-center">MATI < 24Jam </th>
            <th class="text-center">MATI > 24Jam </th>
            <th class="text-center">Y</th>
            <th class="text-center">N</th>
        </tr>
    </thead>
    <tbody>
        @if ( isset($rl_kujungan_rawat_darurat) )
              @php
                  $pasienRujukan = 0;
                  $pasienNonRujukan = 0;
                  $dirawat = 0;
                  $dirujuk = 0;
                  $pulang = 0;
                  $matiIGD_1 = 0;
                  $matiIGD_2 = 0;
                  $doa_1 = 0;
                  $doa_2 = 0;
              @endphp
              @foreach ($rl_kujungan_rawat_darurat as $key => $d)
              @php
                  $pasienRujukan += @$d['data']['rujukan']['Puskesmas'] + @$d['data']['rujukan']['Dokter Praktek'] ;
                  $pasienNonRujukan += @$d['data']['rujukan']['Datang Sendiri'] + @$d['data']['rujukan']['null'];
                  $dirawat += @$d['data']['kondisi']['Inap'];
                  $dirujuk += @$d['data']['kondisi']['Di Rujuk'];
                  $pulang += (@$d['data']['kondisi']['Pulang Atas Persetujuan Dokter'] + @$d['data']['kondisi']['Pulang Atas Permintaan Sendiri'] + @$d['data']['kondisi']['Lain - lain'] +  @$d['data']['kondisi']['null']) ;
                  $matiIGD_1 += @$d['data']['kondisi']['Meninggal Dibawah 24 Jam'];
                  $matiIGD_2 +=   @$d['data']['kondisi']['Meninggal Diatas 24 Jam'] ;
                  $doa_1 +=   @$d['data']['doa']['Y'] ;
                  $doa_2 +=   @$d['data']['doa']['N'] ;
              @endphp
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ @$d['poli'] }}</td>
                  <td>{{ @$d['data']['rujukan']['Puskesmas'] + @$d['data']['rujukan']['Dokter Praktek'] }}</td>
                  <td>{{ @$d['data']['rujukan']['Datang Sendiri'] + @$d['data']['rujukan']['null'] }}</td>
                  <td>{{ @$d['data']['kondisi']['Inap'] }}</td>
                  <td>{{ @$d['data']['kondisi']['Di Rujuk'] }}</td>
                  <td>{{ (@$d['data']['kondisi']['Pulang Atas Persetujuan Dokter'] + @$d['data']['kondisi']['Pulang Atas Permintaan Sendiri'] + @$d['data']['kondisi']['Lain - lain']  + @$d['data']['kondisi']['null'])  }}</td>
                  <td>{{ @$d['data']['kondisi']['Meninggal Dibawah 24 Jam']}}</td>
                  <td>{{  @$d['data']['kondisi']['Meninggal Diatas 24 Jam']   }}</td>
                  <td>{{  @$d['data']['doa']['Y']   }}</td>
                  <td>{{  @$d['data']['doa']['N']   }}</td>
                </tr>
              @endforeach
              <tr>
                <th>###</th>
                <th>Total</th>
                <th>{{ @$pasienRujukan }}</th>
                <th>{{ @$pasienNonRujukan }}</th>
                <th>{{ @$dirawat }}</th>
                <th>{{ @$dirujuk }}</th>
                <th>{{ @$pulang - ($matiIGD_1 + $matiIGD_2) }}</th>
                <th>{{ @$matiIGD_1 }}</th>
                <th>{{ @$matiIGD_2 }}</th>
                <th>{{ @$doa_1 }}</th>
                <th>{{ @$doa_2 }}</th>
              </tr>
            @endif
    </tbody>
</table>
