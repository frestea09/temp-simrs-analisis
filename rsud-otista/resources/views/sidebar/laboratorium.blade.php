<li class="header text-yellow"><strong>LABORATORIUM</strong></li>
  <li><a href="{{ url('laboratorium/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span> Laboratorium </span></a></li>
  <li><a href="{{ url('/laboratorium/antrian-lab') }}"><img src="{{ asset('menu/sidebar/pengguna.svg') }}" width="24"> <span> Daftar Antrian </span></a></li>
  <li><a href="{{ url('/laboratorium/display/antrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span> Display Antrian </span></a></li>
  <li><a href="{{ url('laboratorium/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"></i> <span>Cari Pasien</span></a></li>
  <li><a href="{{ url('laboratorium/master') }}"><img src="{{ asset('menu/sidebar/masterdata.svg') }}" width="24"> <span>Master Lab </span></a></li>
  <li><a href="{{ url('pemeriksaanlab') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}" width="24"> <span> Hasil Lab </span></a></li>
  <li><a href="{{ url('pemeriksaanlab/cari-pasien') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}" width="24"> <span>Cari Pasien Hasil Lab</span></a></li>
{{-- 
  @php
  date_default_timezone_set("Asia/Jakarta");
  $now = date("His");
  $start = '060000';
  $end = '130000';
  @endphp
  @if ($now >= $start && $now <= $end)

  @else --}}
  @if (config('app.laporan_aktif') =='Y')

  @if (jamLaporan('labor'))
  <li><a href="{{ url('laboratorium/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span> Laporan </span></a></li>
  @endif
  @endif

  
  <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Pasien</span></a></li>
  <li><a href="{{ url('farmasi/distribusi') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"> <span> Distribusi </span></a></li>