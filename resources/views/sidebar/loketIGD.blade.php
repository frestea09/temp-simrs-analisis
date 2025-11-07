<li class="header text-yellow"><strong>PENDAFTARAN GAWAT DARURAT</strong></li>
<li><a href="{{ url('frontoffice/rawat-darurat') }}"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Pendaftaran</span></a></li>
<li><a href="{{ url('admission/sep-susulan/rawat-darurat') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>SEP Susulan IGD</span></a></li>
<li><a href="{{ url('bridgingsep') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>Integrasi SEP VClaim</span></a></li>
<li><a href="{{ url('rawat-inap/ubah-dpjp') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}" width="24"> <span>Ubah DPJP </span></a></li>
<li><a href="{{ url('frontoffice/cetak-igd') }}"><img src="{{ asset('menu/sidebar/printer.svg') }}" width="24"> <span>Cetak</span></a></li>
{{-- <li><a href="{{ url('frontoffice/laporan-igd') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan</span></a></li>
<li><a href="{{ url('frontoffice/laporan/laporan-kunjungan-irna') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan Kunjungan Rawat Inap</span></a></li> --}}
 
@if (config('app.laporan_aktif') =='Y')

    @if (jamLaporan('igd'))
    <li><a href="{{ url('/igd-laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan </span></a></li>
    @endif
    @endif
 
<li><a href="{{ url('informasi-rawat-inap') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Rawat Inap</span></a></li>
<li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Pasien</span></a></li>
