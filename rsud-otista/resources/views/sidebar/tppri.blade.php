<li class="header text-yellow"><strong>PENDAFTARAN RAWAT INAP</strong></li>
<li><a href="{{ url('rawat-inap/admission') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Pendaftaran Rawat Inap</span></a></li>
<!--<li><a href="{{ url('admission/sep-susulan') }}"><i class="fa fa-dollar"></i> <span>SEP Susulan</span></a></li>-->
<li><a href="{{ url('frontoffice/rawat-darurat') }}"><img src="{{ asset('menu/sidebar/ambulan.svg') }}" width="24"> <span>Pendaftaran IGD</span></a></li>
<li><a href="{{ url('frontoffice/readmisi') }}"><img src="{{ asset('menu/sidebar/readmisi.svg') }}" width="24"> <span>Readmisi</span></a></li>
<li><a href="{{ url('frontoffice/cetak-irna') }}"><img src="{{ asset('menu/sidebar/printer.svg') }}" width="24"> <span>Cetak</span></a></li>
{{-- JIKA ADMIN SAJA --}}
@if (Auth::user()->id == 1)
  <li><a href="{{ url('/bed') }}"><i class="fa fa-database"></i> <span> Setting Bed</span></a></li>  
@endif

{{-- @php
date_default_timezone_set("Asia/Jakarta");
$now = date("His");
$start = '060000';
$end = '130000';
@endphp
@if ($now >= $start && $now <= $end)

@else --}}
@if (config('app.laporan_aktif') =='Y')

@if (jamLaporan('ranap'))
<li><a href="{{ url('frontoffice/laporan/pengunjung-irna') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan</span></a></li>
<li><a href="{{ url('frontoffice/laporan/laporan-kunjungan-irna') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan Kunjungan</span></a></li>
<li><a href="{{ url('frontoffice/laporan/laporan-ranap') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan Ranap</span></a></li>
@endif
@endif
{{-- @endif --}}




<li><a href="{{ url('informasi-rawat-inap') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Rawat Inap</span></a></li>
<li><a href="{{ url('bridgingsep') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>Integrasi SEP VClaim</span></a></li>
<li><a href="{{ url('admission/sep-susulan/rawat-inap') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>SEP Susulan Ranap</span></a></li>
{{-- <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Pasien</span></a></li> --}}
<li><a href="{{ url('/antrian-rawatinap') }}"><img src="{{ asset('menu/sidebar/layar.svg') }}" width="24"></i> <span>Antrian Ranap</span></a></li>
<li class="treeview">
    <a href="#">
        <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket Pasien</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
  
    <ul class="treeview-menu">
      <li><a href="{{ url('antrian-rawatinap/daftarantrian1') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket A </span></a></li>
      <li><a href="{{ url('antrian-rawatinap/daftarantrian2') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket B</span></a></li>
      <li><a href="{{ url('antrian-rawatinap/daftarantrian3') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket C</span></a></li>
      <li><a href="{{ url('antrian-rawatinap/daftarantrian4') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket D</span></a></li>
    </ul>
</li>
<li><a href="{{ url('frontoffice/merging-data') }}"><img src="{{ asset('menu/sidebar/supervisor.svg') }}" width="24"> <span>Merging Data Pasien</span></a></li>

  