<li class="header text-yellow"><strong>COSTING / CASEMIX</strong></li>
  <li><a href="{{ url('frontoffice/rekammedis') }}"><img src="{{ asset('menu/sidebar/bpjs.svg') }}" width="24"> <span>Bridging E-Klaim</span></a></li>
  <li><a href="{{ url('/frontoffice/rekammedis/laporan') }}"><img src="{{ asset('menu/sidebar/laporaneclaim.svg') }}" width="24"> <span> Laporan E-Klaim</span></a></li>
  <li><a href="{{ url('/bridgingsep/data-klaim') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Laporan VClaim</span></a></li>
  <li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}" width="24"> <span> Ubah DPJP</span></a></li>

  
  {{-- @if (config('app.laporan_aktif') =='Y') --}}
@if (Auth::user()->id == 823)
  <li><a href="{{ url('/frontoffice/antrian-realtime') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime</span></a></li>
  <li><a href="{{ url('/frontoffice/antrian-realtime-inap') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime Inap</span></a></li>
  <li><a href="{{ url('/frontoffice/antrian-realtime-igd') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime IGD</span></a></li>
@else
  @if (jamLaporan('realtime'))
  <li><a href="{{ url('/frontoffice/antrian-realtime') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime</span></a></li>
  <li><a href="{{ url('/frontoffice/antrian-realtime-inap') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime Inap</span></a></li>
  <li><a href="{{ url('/frontoffice/antrian-realtime-igd') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime IGD</span></a></li>
  @endif
@endif

    
{{-- @endif --}}
  {{-- @endif --}}
  
