@if (isset($terpanggil->nomor))
  @if($terpanggil->panggil == 0)
    <div>
      <h4 class="dokter"> {{substr($terpanggil->dokter,0,18)}}</h4>
      <h4 class="header_antrian_on">{{ !empty($terpanggil->nomor) ? $terpanggil->kelompok.$terpanggil->nomor : NULL }} </h4>
      <h4 class="nama_antrian_on"> {{substr($terpanggil->nama,0,20)}}</h4>
    </div>
  @else
    <div>
      <h4 class="dokter"> {{substr($terpanggil->dokter,0,18)}}</h4>
      <h4 class="header_antrian">{{ !empty($terpanggil->nomor) ? $terpanggil->kelompok.$terpanggil->nomor : NULL }} </h4>
      <h4 class="nama_antrian"> {{substr($terpanggil->nama,0,20)}}</h4>
    </div>
  @endif
@endif