<li class="header text-yellow"><strong>SIRS RL Kemkes</strong></li>
  {{-- <li><a href="{{ url('sirs/obat') }}"><i class="fa fa-list-ol"></i> <span> Obat</span></a></li>
  <li><a href="{{ url('sirs/penyakit') }}"><i class="fa fa-universal-access"></i> <span> Penyakit</span></a></li>
  <li><a href="{{ url('sirs/other') }}"><i class="fa fa-pie-chart"></i> <span> Menu Lain</span></a></li> --}}
  <li><a href="{{ url('sirs/rl') }}"><img src="{{ asset('menu/sidebar/mappingrl.svg') }}" width="24"> <span> RL</span></a></li>
  @if (jamLaporan('sirs'))
  <li><a href="{{ url('sirs/rl/laporan-tb') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span>Laporan</span></a></li>
  @endif