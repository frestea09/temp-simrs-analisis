<table>
    <thead>
        <tr>
            <th colspan="10">Formulir RL 5.3</th>
        </tr>
        <tr>
            <th colspan="10">10 Besar Penyakit Rawat Inap</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">ICD10</th>
        <th class="text-center">Diagnosa</th>
        <th class="text-center">Total</th>
      </tr>
      {{-- <tr>
        <th class="text-center" rowspan="2">No</th>
        <th class="text-center" rowspan="2">ICD10</th>
        <th class="text-center" rowspan="2">Diagnosa</th>
        <th valign="top" colspan="2">Pasien Keluar Hidup Menurut Jenis Kalamin</th>
        <th valign="top">Jumlah Pasien Keluar Hidup</th>
        <th valign="top" colspan="2">Pasien Keluar Mati Menurut Jenis Kalamin</th>
        <th valign="top">Jumlah Pasien Keluar Mati</th>
        <th class="text-center" rowspan="2">Total Hidup & Mati</th>
      </tr> --}}
      {{-- <tr>
        <th></th>
        <th></th>
        <th></th>
        <th class="text-center">Laki</th>
        <th class="text-center">Perempuan</th>
        <th class="text-center">LK + PR</th>
        <th class="text-center">Laki</th>
        <th class="text-center">Perempuan</th>
        <th class="text-center">LK + PR</th>
      </tr> --}}
    </thead>
    <tbody>
        @php
            $jmlHidupL = 0;
            $jmlHidupP = 0;
            $jmlHidup = 0;
            $jmlMatiL = 0;
            $jmlMatiP = 0;
            $jmlMati = 0;
            $jmlTotal = 0;
        @endphp
      @foreach ($data as $key => $d)
        @php
          $registrasi_id = explode('||',$d->registrasi_id);
          // dd($registrasi_id);
          $hidup_laki_laki = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
          ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
          ->where('perawatan_icd10s.icd10', $d->diagnosa)
          ->whereIn('registrasis.id', $registrasi_id)
          ->where('pasiens.kelamin', 'L')
          ->where('registrasis.kondisi_akhir_pasien', '!=', 4)
          ->count();
          $hidup_perempuan = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
          ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
          ->where('perawatan_icd10s.icd10', $d->diagnosa)
          ->whereIn('registrasis.id', $registrasi_id)
          ->where('pasiens.kelamin', 'P')
          ->where('registrasis.kondisi_akhir_pasien', '!=', 4)
          ->count();
          $mati_laki_laki = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
          ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
          ->where('perawatan_icd10s.icd10', $d->diagnosa)
          ->whereIn('registrasis.id', $registrasi_id)
          ->where('pasiens.kelamin', 'L')
          ->where('registrasis.kondisi_akhir_pasien', '=', 4)
          ->count();
          $mati_perempuan = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
          ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
          ->where('perawatan_icd10s.icd10', $d->diagnosa)
          ->whereIn('registrasis.id', $registrasi_id)
          ->where('pasiens.kelamin', 'P')
          ->where('registrasis.kondisi_akhir_pasien', '=', 4)
          ->count();

            $jmlHidupL += $hidup_laki_laki;
            $jmlHidupP += $hidup_perempuan;
            $jmlHidup += ($hidup_laki_laki+$hidup_perempuan);
            $jmlMatiL += $mati_laki_laki;
            $jmlMatiP += $mati_perempuan;
            $jmlMati += ($mati_laki_laki+$mati_perempuan);
            $jmlTotal += ($hidup_laki_laki+$hidup_perempuan+$mati_laki_laki+$mati_perempuan);
        @endphp
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $d->diagnosa }}</td>
          {{-- <td>
            @php
              $diagn = DB::table('icd10s')->where('nomor',$d->diagnosa)->first();
              $nama = DB::table('sirrsl_icd10s')->where('id',$diagn->nomor)->first();
            @endphp
            {{ $nama->nama }}
          </td> --}}
          <td>{{ baca_icd10($d->diagnosa) }}</td>
          {{-- <td>{{ $hidup_laki_laki }}</td>
          <td>{{ $hidup_perempuan }}</td>
          <td>{{ $hidup_laki_laki + $hidup_perempuan }}</td>
          <td>{{ $mati_laki_laki }}</td>
          <td>{{ $mati_perempuan }}</td>
          <td>{{ $mati_laki_laki + $mati_perempuan }}</td> --}}
          <td>{{ $hidup_laki_laki+$hidup_perempuan+$mati_laki_laki+$mati_perempuan }}</td>
        </tr>
      @endforeach
        {{-- <tr>
            <td colspan="3">Jumlah</td>
            <td>{{ $jmlHidupL }}</td>
            <td>{{ $jmlHidupP }}</td>
            <td>{{ $jmlHidup }}</td>
            <td>{{ $jmlMatiL }}</td>
            <td>{{ $jmlMatiP }}</td>
            <td>{{ $jmlMati }}</td>
            <td>{{ $jmlTotal }}</td>
        </tr> --}}
    </tbody>
  </table>