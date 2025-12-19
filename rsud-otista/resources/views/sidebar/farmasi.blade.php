<li class="header text-yellow"><strong>APOTIK / FARMASI</strong></li>
	{{-- @role('supervisor-apotik')
		<li><a href="{{ url('farmasi/master') }}"><i class="fa fa-gears"></i> <span> Master </span></a></li>
	@endrole --}}
	{{-- <li class="treeview">
		<a href="#">
			<img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Pasien</span>
		  <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		  </span>
		</a>
	  
		<ul class="treeview-menu">
		  <li><a href="{{ url('antrian-farmasi/daftarantrian1') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Umum </span></a></li>
		  <li><a href="{{ url('antrian-farmasi/daftarantrian2') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Kronis </span></a></li>
		  <li><a href="{{ url('antrian-farmasi/daftarantrian3') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Non Kronis </span></a></li>
		  <li><a href="{{ url('antrian-farmasi/daftarantrian4') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Racikan </span></a></li>
		</ul>
	</li> --}}
	  {{-- <li class="treeview">
		<a href="#">
		  <i class="fa fa-desktop"></i> <span>EResep</span>
		  <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		  </span>
		</a> --}}
	  
		{{-- <ul class="treeview-menu">
			{{-- <li><a href="{{ url('antrian-farmasi/daftarantrian3') }}"><i class="fa fa-circle-o"></i> <span>Antrian Loket 3 </span></a></li>
			<li><a href="{{ url('antrian-farmasi/daftarantrian4') }}"><i class="fa fa-circle-o"></i> <span>Antrian Loket 4 </span></a></li>
		</ul>
	</li> --}}
	<li><a href="{{ url('farmasi/eresep') }}"><i class="fa fa-desktop"></i> <span>EResep</span></a></li>
	<li><a href="{{ url('farmasi/display-eresep') }}"><i class="fa fa-desktop"></i> <span>Display EResep Pasien</span></a></li>
	<li><a href="{{ url('farmasi/suara-eresep') }}"><i class="fa fa-desktop"></i> <span>Suara EResep Pasien</span></a></li>
	<li><a href="{{ url('farmasi/proses-ulang-eresep') }}"><i class="fa fa-desktop"></i> <span>Proses Ulang EResep</span></a></li>
	{{-- <li><a href="{{ url('farmasi/eresep-validasi') }}"><i class="fa fa-desktop"></i> <span> E-Resep Tervalidasi</span></a></li> --}}
	<li><a href="{{ url('farmasi/eresep-cetak') }}"><i class="fa fa-desktop"></i> <span> Cetak E-Resep</span></a></li>
	  {{-- <li><a href="{{ url('farmasi/master') }}"><img src="{{ asset('menu/sidebar/masterdata.svg') }}" width="24"> <span> Master </span></a></li> --}}
  <li><a href="{{ url('logistikmedik/setup') }}"><img src="{{ asset('menu/sidebar/masterdata.svg') }}" width="24"> <span> Master Logistik</span></a></li>
	  {{-- <li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}" width="24"> <span> Ubah DPJP </span></a></li> --}}
	  {{-- <li><a href="{{ url('farmasi/etiket') }}"><img src="{{ asset('menu/sidebar/Medical.svg') }}" width="24"> <span> Aturan Pakai </span></a></li> --}}
	  <li><a href="{{ url('farmasi/penjualan') }}"><img src="{{ asset('menu/sidebar/billing.svg') }}" width="24"> <span> Penjualan </span></a></li>
	  <li><a href="{{ url('farmasi/distribusi') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"> <span> Distribusi </span></a></li>
	  <li><a href="{{ url('copy-resep') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Copy Resep </span></a></li>
	  <li><a href="{{ url('farmasi/reture-penjualan') }}"><img src="{{ asset('menu/sidebar/readmisi.svg') }}" width="24"><span>  Retur Penjualan </span></a></li>
	  

	  {{-- @php
	  date_default_timezone_set("Asia/Jakarta");
	  $now = date("His");
	  $start = '060000';
	  $end = '130000';
	  @endphp
	  @if ($now >= $start && $now <= $end)

	  @else --}}
	  @if (config('app.laporan_aktif') =='Y')
		@if (jamLaporan('apotik'))
		<li><a href="{{ url('farmasi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span> Laporan </span></a></li>	 
		@endif 
	  @endif


		<li><a href="{{ url('farmasi/form-lepasan-obat') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Form Lepasan</span></a></li>


		 
	  {{-- <li><a href="{{ url('logistikmedik/transfer-permintaan') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"> <span> Kirim Stok </span></a></li>
	  <li><a href="{{ url('/logistikmedik/permintaan') }}"><img src="{{ asset('menu/sidebar/mappingrl.svg') }}" width="24"> <span> Permintaan Barang </span></a></li> --}}
	  {{-- @if (date('d') == 26) --}}
	  {{-- @role(['penerimaanpo']) --}}
	<li><a href="{{ url('logistikmedik/opname') }}"><img src="{{ asset('menu/sidebar/medis.svg') }}" width="24"> <span> Opname </span></a></li>
	  {{-- @endrole --}}
		{{-- @endif --}}

	  {{-- <li><a href="{{ url('/logistikmedik/kartustok') }}"><img src="{{ asset('menu/sidebar/Box.svg') }}" width="24"> <span> Kartu Stok </span></a></li>
	  <li><a href="{{ url('/logistikmedik/kartustok/batch') }}"><img src="{{ asset('menu/sidebar/Stock.svg') }}" width="24"> <span> Kartu Stok Batch</span></a></li> --}}
	  {{-- <li><a href="{{ url('retur-obat-rusak') }}"><i class="fa fa-retweet"></i><span>  Retur Obat Ke Gudang </span></a></li> --}}
	  <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Pasien</span></a></li>
	  <li><a href="{{ url('informasi-rawat-inap') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Rawat Inap</span></a></li>
