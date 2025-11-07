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
<ul id="myTab" class="nav nav-tabs">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Skrining<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li>
          <a
              href="{{ url('emr-soap/pemeriksaan-gizi/inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Skrining Gizi
          </a>
          <a
              href="{{ url('emr-soap/pemeriksaan-gizi-anak/inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Skrining Gizi Anak
          </a>
          <a
              href="{{ url('emr-soap/pemeriksaan-gizi-maternitas/inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Skrining Gizi Maternitas
          </a>
          <a
              href="{{ url('emr-soap/pemeriksaan-gizi-perinatologi/inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Skrining Gizi Perinatologi
          </a>
          {{-- <a
              href="{{ url('emr-soap/asuhan-gizi-terintegrasi/inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Asuhan Gizi Terintegrasi
          </a> --}}
        </li>
    </ul>
  </li>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li>
          <a
              href="{{ url('emr-soap/pengkajian-gizi/inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Asesmen Gizi
          </a>
        </li>
    </ul>
  </li>
  <li class="{{ $route == 'soap' ? 'active' : '' }}">
    <a href="{{ url('emr/soap-gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">CPPT Gizi</a>
  </li>
  {{-- <li class="{{ $route == 'diet.gizi' ? 'active' : '' }}">
    <a href="{{ url('emr/diet-gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">Edukasi Diet</a>
  </li> --}}
  <li class="{{ $route == 'form.edukasi.gizi' ? 'active' : '' }}">
    <a
        href="{{ url('emr-soap/pemeriksaan/formulir-edukasi-gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp . '&gizi=true') }}">
        Formulir Edukasi Pasien & Keluarga
    </a>
  </li>
  <li class="{{ $route == 'emr-resume-gizi' ? 'active' : '' }}">
    <a href="{{ url('emr/resume-gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil</a>
  </li>

</ul>