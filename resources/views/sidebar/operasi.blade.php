<li class="header text-yellow"><strong>OPERASI / IBS</strong></li>
  <li><a href="{{ url('operasi/billing') }}"><img src="{{ asset('menu/sidebar/operasi.svg') }}" width="24"> <span> EMR Operasi </span></a></li>
  <li><a href="{{ url('operasi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"></i> <span>Cari Pasien</span></a></li>
  <li><a href="{{ url('penjualan/ibs-baru') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"><span> Penjualan IBS Irna</span></a></li>
  <li><a href="{{ url('penjualan/ibs-jalan-baru') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"><span> Penjualan IBS Irj</span></a></li>
  @if (jamLaporan('operasi'))
    <li><a href="{{ url('operasi/laporan/laporan-operasi') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"><span> Laporan </span></a></li>
  @endif
  <li><a href="{{ url('logistikmedik/opname') }}"><img src="{{ asset('menu/sidebar/medis.svg') }}" width="24"> <span> Opname </span></a></li>
  <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Pasien</span></a></li>
  <li><a href="{{ url('display-operasi') }}"><img src="{{ asset('menu/sidebar/layar.svg') }}" width="24"> <span>Display</span></a></li>
  <li><a href="{{ url('farmasi/distribusi') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"> <span> Distribusi </span></a></li>
  