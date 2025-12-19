<li class="header text-yellow"><strong>KEUANGAN</strong></li>
  <li><a href="{{ url('kasir/transaksi') }}"><img src="{{ asset('menu/sidebar/billing.svg') }}" width="24"> <span> Kasir</span></a></li>
  <li><a href="{{ url('kasir/transaksi-keluar') }}"><img src="{{ asset('menu/sidebar/Wallet.svg') }}" width="24"> <span> Pengeluaran</span></a></li>
  <li><a href="{{ url('kasir/supervisor') }}"><img src="{{ asset('menu/sidebar/supervisor.svg') }}" width="24"><span> Supervisor</span></a></li>

    {{-- @php
	  date_default_timezone_set("Asia/Jakarta");
	  $now = date("His");
	  $start = '060000';
	  $end = '130000';
	  @endphp
	  @if ($now >= $start && $now <= $end)

	  @else --}}
    @if (config('app.laporan_aktif') =='Y')

    @if (jamLaporan('kasir'))
	    <li><a href="{{ url('kasir/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan</span></a></li>  
    @endif
    @endif
	  {{-- @endif --}}
  <li><a href="{{ url('kasir/cetak') }}"><img src="{{ asset('menu/sidebar/printer.svg') }}" width="24"><span> Cetak</a></span></li>
  <li><a href="{{ url('frontoffice/cetak-irj') }}"><img src="{{ asset('menu/sidebar/printer.svg') }}" width="24"><span> Cetak Rajal</a></span></li>
  {{-- <li><a href="{{ url('kasir/cetakRj') }}"><img src="{{ asset('menu/sidebar/printer.svg') }}" width="24"><span> Cetak</a></span></li> --}}
	<li class="treeview">
    <a href="#">
        <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket Pasien</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
  
    <ul class="treeview-menu">
			<li><a href="{{ url('antrian-rawatinap/suara') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24px"><span>Suara Antrian</span></a></li>
      <li><a href="{{ url('antrian-rawatinap/daftarantrian1') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket A </span></a></li>
      <li><a href="{{ url('antrian-rawatinap/daftarantrian4') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket D</span></a></li>
    </ul>
  </li>
