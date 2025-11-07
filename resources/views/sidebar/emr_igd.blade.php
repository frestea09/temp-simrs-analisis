<li class="header text-yellow"><strong>ELEKTRONIK REKAM MEDIK IGD</strong></li>
{{-- <li><a href="{{ url('emr/jalan') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>EMR R.Jalan</span></a></li> --}}
@if (Auth::user()->pegawai->kategori_pegawai == 1)
<li><a href="{{ url('emr-soap/pemeriksaan/triage-igd-awal') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span>Triage</span></a></li>
@endif
<li><a href="{{ url('/frontoffice/antrian-realtime-igd') }}"><img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24"> <span> Antrian Realtime IGD</span></a></li>
<li><a href="{{ url('emr/igd') }}"><img src="{{ asset('menu/sidebar/ambulan.svg') }}" width="24"> <span>EMR IGD</span></a></li>
@php
    if (Auth::user()->pegawai->kategori_pegawai == 1) {
      $poli_id = Auth::user()->poli_id;
		  $poli_id = explode(",", $poli_id);
      $konsul = App\EmrKonsul::where('type', 'konsul_dokter')
                  ->where('unit', 'igd')
                  ->whereNull('verifikator')
                  ->whereDate('created_at', date('Y-m-d'))
                  ->where('dokter_penjawab', Auth::user()->pegawai->id)
                  ->orWhere(function ($subQuery) use ($poli_id) {
                        $subQuery->whereNull('dokter_penjawab')
                            ->whereIn('poli_id', $poli_id);
                  })
                  ->count();
    } else {
      $konsul = App\EmrKonsul::where('type', 'konsul_dokter')->where('unit', 'igd')->whereDate('created_at', date('Y-m-d'))->count();
    }
@endphp
<li>
  <a href="{{ url('emr-konsul/verif?unit=igd') }}">
    <img src="{{ asset('menu/sidebar/sepsusulan.svg') }}" width="24px"/>
    <span>Verif Konsul</span>
    @if($konsul > 0)
      <span class="label label-danger pull-right">{{ @$konsul }}</span>
    @endif
  </a>
</li>

