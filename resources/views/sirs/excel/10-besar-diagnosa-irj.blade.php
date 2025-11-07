<table>
    <thead>
        <tr>
            <th colspan="10">Formulir RL 5.4</th>
        </tr>
        <tr>
            <th colspan="10">10 Besar Penyakit Rawat Jalan</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
    <thead>
      <tr>
        <th class="text-center" rowspan="2" valign="top">No</th>
        <th class="text-center" rowspan="2" valign="top">DTD</th>
        <th class="text-center" rowspan="2" valign="top">Daftar Terperinci</th>
        <th class="text-center" rowspan="2" valign="top">Golongan Sebab Penyakit</th>
        <th class="text-center" colspan="2" valign="top">Pasien Keluar(Hidup&Mati) Menurut Jenis Kelamin</th>
        <th class="text-center" rowspan="2" valign="top">Jumlah Kasus Baru</th>
        <th class="text-center" rowspan="2" valign="top">Jumlah Kunjungan</th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th class="text-center">Laki</th>
        <th class="text-center">Perempuan</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @if ( isset($irj) )
      @php
          $jmlL = 0;
          $jmlP = 0;
          $jmlBaru = 0;
          $jmlKunjungan = 0;
      @endphp
      @foreach ($irj as $key => $d)
        @php
            $registrasi_id = explode('||',$d->registrasi_id);
            $dtd = \App\PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
                                    // ->join('sirrsl_icd10s', 'icd10s.kategori_nomor', '=', 'sirrsl_icd10s.id')
                                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                                    ->first();
            // dd($dtd);
            $kasus_baru = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
            ->where('perawatan_icd10s.icd10', $d->diagnosa)
            ->whereIn('registrasis.id', $registrasi_id)
            // ->where('perawatan_icd10s.status', 'baru')
            ->count();
            $laki_laki = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where('perawatan_icd10s.icd10', $d->diagnosa)
            ->whereIn('registrasis.id', $registrasi_id)
            ->where('pasiens.kelamin', 'L')
            // ->where('perawatan_icd10s.status', 'baru')
            ->count();
            $perempuan = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
            ->where('perawatan_icd10s.icd10', $d->diagnosa)
            ->whereIn('registrasis.id', $registrasi_id)
            ->where('pasiens.kelamin', 'P')
            // ->where('perawatan_icd10s.status', 'baru')
            ->count();

            $jmlL += $laki_laki;
            $jmlP += $perempuan;
            $jmlBaru += $kasus_baru;
            $jmlKunjungan += $d->jumlah;
        @endphp
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ isset($dtd->dtd) ? $dtd->dtd : $d->diagnosa }}</td>
          <td>{{ isset($dtd->daftar_terperinci) ? $dtd->daftar_terperinci : $d->diagnosa }}</td>
          <td>{{ isset($dtd->nama) ? $dtd->nama : baca_icd10($d->diagnosa) }}</td>
          <td>{{ $laki_laki }}</td>
          <td>{{ $perempuan }}</td>
          <td>{{ $kasus_baru }}</td>
          <td>{{ $d->jumlah }}</td>
        </tr>
      @endforeach
        <tr>
          <td colspan="4">Jumlah</td>
          <td>{{ $jmlL }}</td>
          <td>{{ $jmlP }}</td>
          <td>{{ $jmlBaru }}</td>
          <td>{{ $jmlKunjungan }}</td>
      </tr>
      @endif
    </tbody>
  </table>