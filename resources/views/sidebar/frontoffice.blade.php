<li class="header text-yellow"><strong>PENDAFTARAN RAWAT JALAN</strong></li>
<li class="treeview">
  <a href="#">
    <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Pendaftaran</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>

  <ul class="treeview-menu">
    <li><a href="{{ url('antrian/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket UMUM </span></a></li>
    <li><a href="{{ url('antrian2/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket JKN BAWAH </span></a></li>
    <li><a href="{{ url('antrian3/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket JKN ATAS </span></a></li>
    {{--<li><a href="{{ url('antrian4/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Loket 4 </span></a></li>
    <li><a href="{{ url('antrian5/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Loket 5 </span></a></li>
    <li><a href="{{ url('antrian6/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Antrian Loket 6 </span></a></li>--}} 
    <li><a href="{{ url('daftar-perjanjian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Data Perjanjian</span></a></li>
    <li><a href="{{ url('antrian-new/antrianumum') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Display Umum</span></a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#">
    <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket JKN Bawah</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>

  <ul class="treeview-menu">
    <li><a href="{{ url('antrian-news/B/1/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 1 </span></a></li>
    <li><a href="{{ url('antrian-news/B/2/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 2 </span></a></li>
    <li><a href="{{ url('antrian-news/B/3/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 3 </span></a></li>
    <li><a href="{{ url('antrian-news/B/4/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 4 </span></a></li>
    <li><a href="{{ url('antrian-new/antrianbawah') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Display Loket</span></a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#">
    <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket JKN Atas</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>

  <ul class="treeview-menu">
    <li><a href="{{ url('antrian-news/C/5/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 5 </span></a></li>
    <li><a href="{{ url('antrian-news/C/6/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 6 </span></a></li>
    <li><a href="{{ url('antrian-news/C/7/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 7 </span></a></li>
    <li><a href="{{ url('antrian-news/C/8/daftarantrian') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Loket 8 </span></a></li>
    <li><a href="{{ url('antrian-new/antrianatas') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Display Loket</span></a></li>
  </ul>
</li>


{{-- <li><a href="{{ url('frontoffice/rawat-darurat') }}"><i class="fa fa-ambulance"></i> <span>Pendaftaran</span></a></li> --}}
{{-- <li><a href="{{ url('frontoffice/rawat-inap') }}"><i class="fa fa-bed"></i> <span>Rawat Inap</span></a></li> --}}
{{-- <li><a href="{{ url('frontoffice/supervisor') }}"><i class="fa fa-edit"></i> <span>Supervisor</span></a></li> --}}
<li><a href="{{ url('admission/sep-susulan/rawat-jalan') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>SEP Rawat Jalan</span></a></li>


@if (config('app.laporan_aktif') =='Y')
            @if (jamLaporan('rajal'))
            <li><a href="{{ url('frontoffice/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan</span></a></li>
            @endif
        @endif
  
 <li><a href="{{ url('frontoffice/cetak-irj') }}"><img src="{{ asset('menu/sidebar/printer.svg') }}" width="24"> <span>Cetak</span></a></li>
<li><a href="{{ url('bridgingsep') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>Integrasi SEP VClaim</span></a></li>
<li><a href="{{ url('/pendaftaran/pendaftaran-online') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span>Pendaftaran Online</span></a>
<li><a href="{{ url('bridgingsep/data-klaim') }}"><img src="{{ asset('menu/sidebar/laporan2.svg') }}" width="24"> <span>Laporan SEP VClaim</span></a></li>
{{-- <li><a href="{{ url('biayapemeriksaan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Konf. Biaya Pemeriksaan</span></a></li> --}}
{{-- @if (Auth::user()->name == 'BADARIYAH BAHRUM, A.Md.RMIK')
 <li><a href="{{ url('rawat-inap/laporan') }}"><i class="fa fa-pie-chart"></i> <span>Laporan Rawat Inap</span></a></li>
@endif --}}

