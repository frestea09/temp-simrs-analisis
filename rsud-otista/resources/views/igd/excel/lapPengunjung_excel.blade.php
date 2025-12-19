<table class='table table-striped table-bordered table-hover table-condensed'>
  <thead>
    <tr>
      <th class="v-middle text-center">No</th>
      <th class="v-middle text-center" style="min-width:90px">Tanggal</th>
      <th class="v-middle text-center">No. RM</th>
      <th class="v-middle text-center">Nama</th>
      <th class="v-middle text-center">Bayar</th>
      <th class="v-middle text-center">Dokter Ahli</th>
      <th class="v-middle text-center">Dokter Umum</th>
      <th class="v-middle text-center">Petugas</th>
      <th class="v-middle text-center">Total</th>
    </tr>
  </thead>
  <tbody>
    @php $all = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; $ceck = 0;$no=1; @endphp
    @foreach ($darurat as $rdar)
    <tr>
      <td class="text-center">{{ $no++ }}</td>
      <td class="text-center">{{ date('d-m-Y', strtotime($rdar->created_at)) }}</td>
      <td class="text-center">{{ $rdar->pasien->no_rm }}</td>
      <td>{{ $rdar->pasien->nama }}</td>
      <td class="text-center">{{ baca_carabayar($rdar->bayar) }}</td>
      <td>{{ dokterStatus($rdar->id) }}</td>
      <td>{{ dokterStatus($rdar->id) }}</td>
        <td>{{ baca_user($rdar->user_create) }}</td>
        <td class="text-right">{{ number_format($rdar->total) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>