<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.1</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.1 Kegiatan Pelayanan Rawati Inap</th>
        </tr>
    </thead>
</table>

<table class='table table-striped table-bordered table-hover table-condensed' id="data">
  <thead>
  <tr>
        <th class="text-center" rowspan="2" valign="top">No</th>
        <th class="text-center" rowspan="2" valign="top">JENIS PELAYANAN</th>
        <th class="text-center" rowspan="2" valign="top">PASIEN AWAL TAHUN</th>
        <th class="text-center" rowspan="2" valign="top">PASIEN MASUK</th>
        <th class="text-center" rowspan="2" valign="top">PASIEN KELUAR HIDUP</th>
        <th class="text-center" colspan="2" valign="top">PASIEN KELUAR MATI</th>
        <th class="text-center" rowspan="2" valign="top">JUMLAH LAMA DIRAWAT</th>
        <th class="text-center" rowspan="2">PASIEN AKHIR TAHUN</th>
        <th class="text-center" rowspan="2">JUMLAH HARI PERAWATAN</th>
        <th class="text-center" colspan="6">RINCIAN HARI PERAWATAN PER KELAS</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th class="text-center">kurang 48 jam</th>
        <th class="text-center">lebih 48 jam</th>
        <th></th>
        <th></th>
        <th></th>
        <th class="text-center">VVIP</th>
        <th class="text-center">VIP</th>
        <th class="text-center">I</th>
        <th class="text-center">II</th>
        <th class="text-center">III</th>
        <th class="text-center">Kelas Khusus</th>
    </tr>
  </thead>
  <tbody>
    @if ( isset($pelayanan_rawat_inap) )
      @foreach ($pelayanan_rawat_inap as $key => $d)
        <tr>
            <td>{{ $key+1 }}</td>
            <td class="text-center">{{$d->kegiatan}}</td>
            <td class="text-center">{{$d->tahunbaru}}</td>
            <td class="text-center">{{$d->masuk}}</td>
            <td class="text-center">{{$d->keluar_hidup}}</td>
            <td class="text-center">{{$d->keluar_mati_kurang_48}}</td>
            <td class="text-center">{{$d->keluar_mati_lebih_48}}</td>
            <td class="text-center">{{$d->lama_dirawat}} Hari</td>
            <td class="text-center">{{$d->tahunakhir}}</td>
            <td class="text-center">{{$d->lama_dirawat}} Hari</td>
            <td class="text-center">{{$d->vvip}}</td>
            <td class="text-center">{{$d->vip}}</td>
            <td class="text-center">{{$d->kelas1}}</td>
            <td class="text-center">{{$d->kelas2}}</td>
            <td class="text-center">{{$d->kelas3}}</td>
            <td class="text-center">{{ 0 }}</td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>