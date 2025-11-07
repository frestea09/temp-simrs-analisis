<li class="header text-yellow"><strong>GAWAT DARURAT</strong></li>
<li><a href="{{ url('/igd/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span>
            {{ @Auth::user()->pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat' }} </span></a></li>
<li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}"
            width="24"> <span> Ubah DPJP </span></a></li>
</span></a></li>
<li><a href="{{ url('/igd/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"></i>
        <span>Cari Pasien</span></a></li>
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
          @if (jamLaporan('igd'))
<li><a href="{{ url('/igd-laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan
        </span></a></li>
@endif
@endif

<li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
        <span>Informasi Pasien</span></a></li>
<li><a href="{{ url('farmasi/distribusi') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24">
        <span> Distribusi </span></a></li>
