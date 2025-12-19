<table>
    <thead>
        <tr>
            <th colspan="10">Formulir RL 3.15</th>
        </tr>
        <tr>
            <th colspan="10">Cara Bayar</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
    <thead>
    <tr>
          <th class="text-center" rowspan="2" valign="top">No</th>
          <th class="text-center" rowspan="2" valign="top">CARA PEMBAYARAN</th>
          <th class="text-center" colspan="2" valign="top">PASIEN RAWAT INAP</th>
          <th class="text-center" rowspan="2" valign="top">JUMLAH PASIEN RAWAT JALAN</th>
          <th class="text-center" colspan="3">JUMLAH PASIEN</th>
      </tr>
      <tr>
          <th class="text-center">JUMLAH PASIEN KELUAR</th>
          <th class="text-center">JUMLAH LAMA DIRAWAT</th>
          <th class="text-center">LABORATORIUM</th>
          <th class="text-center">RADIOLOGI</th>
          <th class="text-center">LAIN-LAIN</th>
      </tr>
    </thead>
    <tbody>
      @if ( isset($carabayar) )
        @foreach ($carabayar as $k => $d)
          <tr>
            <td>{{ $k+1 }}</td>
          <td class="text-center">{{$d->carabayar}}</td>
            <td class="text-center">{{$d->jumlahinap}}</td>
            <td class="text-center">{{$d->hariinap}} Hari</td>
            <td class="text-center">{{$d->jumlahjalan}}</td>
            <td class="text-center">{{$d->jumlahrad}}</td>
            <td class="text-center">{{$d->jumlahlab}}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
          </tr>
        @endforeach
      @endif
      </tbody>
    </table>