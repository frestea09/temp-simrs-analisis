<li class="header text-yellow"><strong>RAWAT INAP</strong></li>
{{-- <li><a href="{{ url('rawat-inap-menu-billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span> Perawat </span></a></li> --}}
<li><a href="{{ url('rawat-inap/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span> Perawat </span></a></li>
<li><a href="{{ url('rawat-inap/billingpulang') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span> Pasien Pulang </span></a></li>
<li><a href="{{ url('rawat-inap/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"></i> <span>Cari Pasien</span></a></li>
@if (jamLaporan('operasi'))
    <li><a href="{{ url('rawat-inap/hasil') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}" width="24"></i> <span>Hasil Penunjang</span></a></li>
@endif

<li><a href="{{ url('/frontoffice/supervisor/ubahdpjp') }}"><i class="fa fa-pie-chart"></i> <span>Ubah Status </span></a></li>
{{-- JIKA ADMIN SAJA --}}
@if (Auth::user()->id == 1)
  <li><a href="{{ url('/bed') }}"><i class="fa fa-database"></i> <span> Setting Bed</span></a></li>  
@endif
<li><a href="{{ url('rawat-inap/ubah-dpjp') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}" width="24"> <span>Ubah DPJP </span></a></li>


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
        <li><a href="{{ url('rawat-inap/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan </span></a></li>
        <li><a href="{{ url('farmasi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span> Laporan Farmasi</span></a></li>
        @endif
        @endif
    
<li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"></i> <span>Informasi Pasien</span></a></li>
{{-- <li><a href="{{ url('/antrian-rawatinap') }}"><img src="{{ asset('menu/sidebar/layar.svg') }}" width="24"></i> <span>Antrian Ranap</span></a></li>
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
  </li> --}}
  <li><a href="{{ url('display-operasi') }}"><img src="{{ asset('menu/sidebar/layar.svg') }}" width="24"> <span>Display Operasi</span></a></li>
  <li><a href="{{ url('masterpagu') }}"><img src="{{ asset('menu/sidebar/keuangan.svg') }}" width="24"> <span>Master Pagu</span></a></li>
  {{-- <li><a href="{{ url('farmasi/distribusi') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"> <span> Distribusi </span></a></li> --}}
{{-- 
<li><a href="{{ url('rawat-inap/lap_pengunjung_inap') }}"><i class="fa fa-pie-chart"></i> <span>Laporan </span></a></li>
<li><a href="{{ url('rawat-inap/billing') }}"><i class="fa fa-circle-o"></i> <span> Billing System IRNA </span></a></li>
<li><a href="{{ url('rawat-inap/askep') }}"><i class="fa fa-circle-o"></i> <span> Asuhan Keperawatan </span></a></li>
<li><a href="{{ url('rawat-inap/emr') }}"><i class="fa fa-stethoscope"></i> <span>E-Medical Record </span></a></li>
<li><a href="{{ url('rawat-inap/laporan') }}"><i class="fa fa-pie-chart"></i> <span>Laporan </span></a></li>
--}}
