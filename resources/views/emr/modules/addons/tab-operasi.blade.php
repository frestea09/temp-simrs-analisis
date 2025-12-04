@php
    $route = Route::current()->getName();
    $poli = request()->get('poli');
    $dpjp = request()->get('dpjp');
@endphp
<style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>

  @php
      @$kategoriPegawai = Auth::user()->pegawai->kategori_pegawai;
      @$kelompokPegawai = Auth::user()->pegawai->kelompok_pegawai;
      if (!@$kategoriPegawai) {
          @$kategoriPegawai = 1;
      }
  @endphp

  <ul id="myTab" class="nav nav-tabs">
    {{-- Dokter dan Penata Anestesi --}}
    @if (@$kelompokPegawai == '7' || @$kelompokPegawai == '8')
      <li>
        <a href="{{ url('emr-soap/pemeriksaan/pra-anestesi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Pra Anestesi</a>
      </li>
      <li>
        <a href="{{ url('emr-soap/pemeriksaan/kartu-anestesi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Kartu Anestesi</a>
      </li>
      <li>
        <a href="{{ url('emr-soap/pemeriksaan/keadaan-pasca-bedah/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Asesmen Pasca Bedah</a>
      </li>
      <li>
        <a href="{{ url('emr-soap/pemeriksaan/daftar-tilik-operasi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Daftar Tilik</a>
      </li>
      <li>
        <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id. '&source=operasi') }}">Informed Consent</a>
      </li>
      <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transfer Internal<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                      <li>
                              <a href="{{url("/emr/sbar/$unit/$registrasi_id") }}?source=operasi&sbar_tipe=masuk-ruangan">Masuk Ruangan</a>
                              <a href="{{url("/emr/sbar/$unit/$registrasi_id") }}?source=operasi&sbar_tipe=keluar-ruangan">Keluar Ruangan</a>
                      </li>
              </ul>
      </li>
    @else
    {{-- END Dokter dan Penata Anestesi --}}

      {{-- Dokter --}}
      @if (@$kategoriPegawai == '1')
        <li>
          <a href="{{ url('emr-soap/pemeriksaan/asesmen-pra-bedah/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Asesmen Pra Bedah</a>
        </li>
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan Operasi<span
                      class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi-ods/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Laporan Operasi Mata</a>
                  </li>
                  <li>
                    <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Laporan Operasi ODS</a>
                  </li>
                  <li>
                    <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi-ranap/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Laporan Operasi Rawat Inap</a>
                  </li>
                  <li>
                    <a href="{{ url('emr-soap/pemeriksaan/upload-laporan-operasi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Upload Laporan Operasi</a>
                  </li>
              </ul>
        </li>
        <li>
          <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id. '&source=operasi') }}">Informed Consent</a>
        </li>
      @endif
      {{-- END Dokter --}}

      {{-- Perawat --}}
      @if (@$kategoriPegawai == '2')
        <li>
          <a href="{{ url('emr-soap/pemeriksaan/pre-operatif/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Pre Operatif</a>
        </li>
        <li>
          <a href="{{ url('emr-soap/pemeriksaan/daftar-tilik-operasi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Daftar Tilik</a>
        </li>
        <li>
          <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id. '&source=operasi') }}">Informed Consent</a>
        </li>
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transfer Internal<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                        <li>
                                <a href="{{url("/emr/sbar/$unit/$registrasi_id") }}?source=operasi&sbar_tipe=masuk-ruangan">Masuk Ruangan</a>
                                <a href="{{url("/emr/sbar/$unit/$registrasi_id") }}?source=operasi&sbar_tipe=keluar-ruangan">Keluar Ruangan</a>
                        </li>
                </ul>
        </li>
      @endif
      {{-- END Perawat --}}
    @endif
  </ul>
