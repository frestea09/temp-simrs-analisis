<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.12</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.12 Keluarga Berencana</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
    <thead>
    <tr>
        <th class="text-center" rowspan="2" valign="top">No</th>
        <th class="text-center" rowspan="2" valign="top">METODA</th>
        <th class="text-center" colspan="2" valign="top">KONSELING</th>
      <th class="text-center" colspan="4">KB BARU DENGAN CARA MASUK</th>
      <th class="text-center" colspan="3">KB BARU DENGAN KONDISI</th>
      <th class="text-center" rowspan="2">KUNJUNG AN ULANG</th>
      <th class="text-center" colspan="2">KELUHAN EFEK SAMPING</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th class="text-center">ANC</th>
        <th class="text-center">Pasca Persalinan</th>
        <th class="text-center">BUKAN RUJUKAN</th>
        <th class="text-center">RUJUKAN INAP</th>
      <th class="text-center">RUJUKAN JALAN</th>
                  <th class="text-center">TOTAL</th>
      <th class="text-center">PASCA PERSALIN AN/NIFAS</th>
      <th class="text-center">ABORTUS</th>
      <th class="text-center">LAINYA</th>
      <th></th>
      <th class="text-center">JUMLAH</th>
      <th class="text-center">DIRUJUK</th>
              </tr>
    </thead>
    <tbody>
      @if ( isset($result) )
        @php
          $totAnc = 0;
          $totPasca = 0;
          $totBukanRujukan = 0;
          $totRujukanInap = 0;
          $totRujukanJalan = 0;
          $totCaraMasuk = 0;
          $totNifas = 0;
          $totAbortus = 0;
          $totLainnya = 0;
          $totUlang = 0;
        @endphp
        @foreach ($result as $key => $d)
        @php
          $totAnc += $d['konseling']['anc'];
          $totPasca += $d['konseling']['pasca persalinan'];
          $totBukanRujukan += $d['cara_masuk']['bukan rujukan'];
          $totRujukanInap += $d['cara_masuk']['rujukan rawat inap'];
          $totRujukanJalan += $d['cara_masuk']['rujukan rawat jalan'];
          $totCaraMasuk += ($d['cara_masuk']['bukan rujukan'] + $d['cara_masuk']['rujukan rawat inap'] + $d['cara_masuk']['rujukan rawat jalan']);
          $totNifas += $d['kondisi']['pasca persalinan'];
          $totAbortus += $d['kondisi']['abortus'];
          $totLainnya += $d['kondisi']['lainnya'];
          $totUlang += $d['kunjungan_ulang']['Y'];
        @endphp
          <tr>
            <td>{{ $key+1 }}</td>
            <td class="text-center">{{ $d['metoda'] }}</td>
            <td class="text-center">{{ $d['konseling']['anc'] }}</td>
            <td class="text-center">{{ $d['konseling']['pasca persalinan'] }}</td>
            <td class="text-center">{{ $d['cara_masuk']['bukan rujukan'] }}</td>
            <td class="text-center">{{ $d['cara_masuk']['rujukan rawat inap'] }}</td>
            <td class="text-center">{{ $d['cara_masuk']['rujukan rawat jalan'] }}</td>
            <td class="text-center">{{ $d['cara_masuk']['bukan rujukan'] + $d['cara_masuk']['rujukan rawat inap'] + $d['cara_masuk']['rujukan rawat jalan'] }}</td>
            <td class="text-center">{{ $d['kondisi']['pasca persalinan'] }}</td>
            <td class="text-center">{{ $d['kondisi']['abortus'] }}</td>
            <td class="text-center">{{ $d['kondisi']['lainnya'] }}</td>
            <td class="text-center">{{ $d['kunjungan_ulang']['Y'] }}</td>
            <td class="text-center">{{ 0 }}</td>
            <td class="text-center">{{ 0 }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfooter>
        <tr>
          <th class="text-center">###</th>
          <th class="text-center">Total</th>
          <th class="text-center">{{ $totAnc }}</th>
          <th class="text-center">{{ $totPasca }}</th>
          <th class="text-center">{{ $totBukanRujukan }}</th>
          <th class="text-center">{{ $totRujukanInap }}</th>
          <th class="text-center">{{ $totRujukanJalan }}</th>
          <th class="text-center">{{ $totCaraMasuk }}</th>
          <th class="text-center">{{ $totNifas }}</th>
          <th class="text-center">{{ $totAbortus }}</th>
          <th class="text-center">{{ $totLainnya }}</th>
          <th class="text-center">{{ $totUlang }}</th>
          <th class="text-center">{{ 0 }}</th>
          <th class="text-center">{{ 0 }}</th>
        </tr>
      </tfooter>
      @endif
    </table>