<li class="header text-yellow"><strong>LOGISTIK MEDIK</strong></li>
  
  {{-- <li><a href="{{ url('farmasi/master') }}"><img src="{{ asset('menu/sidebar/masterdata.svg') }}" width="24"> <span> Master </span></a></li> --}}
  {{-- <li><a href="{{ url('logistikmedik/view-pejabat') }}"><i class="fa fa-users"></i> <span>Master Pejabat</span></a></li> --}}
  {{-- <li><a href="{{ url('logistikmedik/setup') }}"><img src="{{ asset('menu/sidebar/Medical.svg') }}" width="24"> <span> Setup Awal </span></a></li> --}}
  <li><a href="{{ url('logistikmedik/setup') }}"><img src="{{ asset('menu/sidebar/masterdata.svg') }}" width="24"> <span> Master </span></a></li>
  {{--  <a><a href="{{ url('logistikmedik/saldoawal') }}"><i class="fa fa-battery-empty"></i> <span> Stock Awal </span></a></a>  --}}
  <li><a href="{{ url('logistikmedik/menupenerimaan') }}"><img src="{{ asset('menu/sidebar/Box.svg') }}" width="24"> <span> Pengadaan Barang</span></a></li>
  <li><a href="{{ url('logistikmedik/distribusi') }}"><img src="{{ asset('menu/sidebar/Stock.svg') }}" width="24"><span> Distribusi</span></a></li>
  <li><a href="{{ url('logistikmedik/pemakaian') }}"><img src="{{ asset('menu/sidebar/Planning.svg') }}" width="24"> <span> Pemakaian </span></a></li>
	  <li><a href="{{ url('retur-obat-rusak') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"><span>  Retur Obat Ke Supplier </span></a></li>
    <li><a href="{{ url('/peminjaman') }}"><img src="{{ asset('menu/sidebar/Delivery1.svg') }}" width="24"> <span> Peminjaman Obat </span></a></li>
    {{-- @if (date('d') == 26) --}}
      <li><a href="{{ url('logistikmedik/opname') }}"><img src="{{ asset('menu/sidebar/medis.svg') }}" width="24"> <span> Opname </span></a></li>
    {{-- @endif --}}
  @if (jamLaporan('logistikmedik'))
  <li><a href="{{ url('logistikmedik/laporan-gudang') }}"><img src="{{ asset('menu/sidebar/mappingrl.svg') }}" width="24"> <span> Laporan Gudang </span></a></li>
  @endif
  {{-- <li><a href="{{ url('#') }}"><i class="fa fa-recycle"></i> <span> Retur </span></a></li> --}}
  