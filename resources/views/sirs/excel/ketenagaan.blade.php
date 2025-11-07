<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 2</th>
        </tr>
        <tr>
            <th colspan="3">RL 2 Ketenagaan</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
  <thead>
  <tr>
    <th class="text-center" rowspan="3" valign="top">No</th>
    <th class="text-center" rowspan="3" valign="top">KUALIFIKASI PENDIDIKAN</th>
    <th class="text-center" colspan="2" valign="top">KEADAAN</th>
    <th class="text-center" colspan="2">KEBUTUHAN</th>
    <th class="text-center" colspan="2">KEKURANGAN</th>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th class="text-center">Laki-laki</th>
    <th class="text-center">Perempuan</th>
    <th class="text-center">Laki-laki</th>
    <th class="text-center">Perempuan</th>
    <th class="text-center">Laki-laki</th>
    <th class="text-center">Perempuan</th>
  </tr>
  </thead>
  <tbody>
    @php
      $totKeadaanLaki = 0;
      $totKeadaanPerempuan = 0;
      $totKebutuhanLaki = 0;
      $totKebutuhanPerempuan = 0;
      $totKekuranganLaki = 0;
      $totKekuranganPerempuan = 0;
    @endphp
    @if ( isset($rl_ketenagaan) )
      @foreach ($rl_ketenagaan as $key => $d)
        <tr>
          <td><b>#</b></td>
          <td class="text-center"><b>{{ ucWords($d['kualifikasi']) }}</b></td>
          <td class="text-center">{{ 0 }}</td>
          <td class="text-center">{{ 0 }}</td>
          <td class="text-center">{{ 0 }}</td>
          <td class="text-center">{{ 0 }}</td>
          <td class="text-center">{{ 0 }}</td>
          <td class="text-center">{{ 0 }}</td>
        </tr>
        @php
          $subKeadaanLaki = 0;
          $subKeadaanPerempuan = 0;
          $subKebutuhanLaki = 0;
          $subKebutuhanPerempuan = 0;
          $subKekuranganLaki = 0;
          $subKekuranganPerempuan = 0;
        @endphp
        @foreach( $d['data'] as $k => $v )
        <tr>
          <td>{{ $k+1 }}</td>
          <td class="text-center">{{ $v->pendidikan }}</td>
          <td class="text-center">{{ $v->jml_laki }}</td>
          <td class="text-center">{{ $v->jml_perempuan }}</td>
          <td class="text-center">{{ $v->kebutuhan_laki }}</td>
          <td class="text-center">{{ $v->kebutuhan_perempuan }}</td>
          <td class="text-center">{{ ($v->kebutuhan_laki - $v->jml_laki ) }}</td>
          <td class="text-center">{{ ($v->kebutuhan_perempuan  - $v->jml_perempuan ) }}</td>
        </tr>
        @php
          $subKeadaanLaki += $v->jml_laki;
          $subKeadaanPerempuan += $v->jml_perempuan;
          $subKebutuhanLaki += $v->kebutuhan_laki ;
          $subKebutuhanPerempuan += $v->kebutuhan_perempuan;
          $subKekuranganLaki += ($v->kebutuhan_laki - $v->jml_laki );
          $subKekuranganPerempuan += ($v->kebutuhan_perempuan  - $v->jml_perempuan );
        @endphp
        @endforeach
        <tr>
          <td>{{ ($key+1).'.99' }}</td>
          <td class="text-center"><i>Sub Total {{ ($key+1).'.99' }}</i></td>
          <td class="text-center">{{ $subKeadaanLaki }}</td>
          <td class="text-center">{{ $subKeadaanPerempuan }}</td>
          <td class="text-center">{{ $subKebutuhanLaki }}</td>
          <td class="text-center">{{ $subKebutuhanPerempuan }}</td>
          <td class="text-center">{{ $subKekuranganLaki }}</td>
          <td class="text-center">{{ $subKekuranganPerempuan }}</td>
        </tr>
        @php
          $totKeadaanLaki += $subKeadaanLaki;
          $totKeadaanPerempuan += $subKeadaanPerempuan;
          $totKebutuhanLaki += $subKebutuhanLaki;
          $totKebutuhanPerempuan += $subKebutuhanPerempuan;
          $totKekuranganLaki += $subKekuranganLaki;
          $totKekuranganPerempuan += $subKekuranganPerempuan;
        @endphp
      @endforeach
      <tr>
        <th>99</th>
        <th class="text-center">Total</th>
        <th class="text-center">{{ $totKeadaanLaki }}</th>
        <th class="text-center">{{ $totKeadaanPerempuan }}</th>
        <th class="text-center">{{ $totKebutuhanLaki }}</th>
        <th class="text-center">{{ $totKebutuhanPerempuan }}</th>
        <th class="text-center">{{ $totKekuranganLaki }}</th>
        <th class="text-center">{{ $totKekuranganPerempuan }}</th>
      </tr>
    @endif
    </tbody>
  </table>