<table>
  <thead>
    <tr>
      <th class="text-center" colspan="8">10 BESAR PENYAKIT RAWAT INAP RSUD OTO ISKANDAR DI NATA</th>
    </tr>
    <tr>
      <th class="text-center" colspan="8">{{ Carbon\Carbon::parse($tga)->format('d-m-Y') }} - {{ Carbon\Carbon::parse($tgb)->format('d-m-Y') }} </th>
    </tr>
  </thead>
</table>
<table>
  <thead>
    <tr>
      <th class="text-center" style="vertical-align: middle;">No</th>
      <th class="text-center" style="vertical-align: middle;">ICD</th>
      <th class="text-center" style="vertical-align: middle;">Diagnosa</th>
      <th class="text-center" style="vertical-align: middle;">Pasien Keluar Hidup Menurut Jenis Kalamin (LK)</th>
      <th class="text-center" style="vertical-align: middle;">Pasien Keluar Hidup Menurut Jenis Kalamin (PR)</th>
      <th class="text-center" style="vertical-align: middle;">Pasien Keluar Mati Menurut Jenis Kalamin (LK)</th>
      <th class="text-center" style="vertical-align: middle;">Pasien Keluar Mati Menurut Jenis Kalamin (PR)</th>
      <th class="text-center" style="vertical-align: middle;">Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $key => $d)
      @php
        $registrasi_id = explode('||',$d->registrasi_id);
        // dd($registrasi_id);
        // $kasus_baru = \App\sirrl\RlIcd10::where('icd10', $d->diagnosa)->where('status', 'baru')->count();
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
      @endphp
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $d->diagnosa }}</td>
        <td>{{ baca_icd10($d->diagnosa) }}</td>
        <td class="text-center" style="vertical-align: middle;">{{ $hidup_laki_laki }}</td>
        <td class="text-center" style="vertical-align: middle;">{{ $hidup_perempuan }}</td>
        <td class="text-center" style="vertical-align: middle;">{{ $mati_laki_laki }}</td>
        <td class="text-center" style="vertical-align: middle;">{{ $mati_perempuan }}</td>
        <td class="text-center" style="vertical-align: middle;">{{ $hidup_laki_laki+$hidup_perempuan+$mati_laki_laki+$mati_perempuan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>