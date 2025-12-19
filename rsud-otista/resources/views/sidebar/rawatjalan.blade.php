<li class="header text-yellow"><strong>RAWAT JALAN</strong></li>
@php
      @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
        if(!@$dataPegawai){
            @$dataPegawai = 1;
        }
@endphp
@if (@$dataPegawai == 1)
<li><a href="{{ url('tindakan') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span> Dokter </span></a></li>
@else
<li><a href="{{ url('tindakan') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span> Perawat </span></a></li>
@endif
<li><a href="{{ url('tindakan/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span> Cari Pasien</span></a></li>
<li><a href="{{ url('rawat-inap/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span> Cari Pasien Inap</span></a></li>


{{-- <li><a href="{{ url('antrian_poli/layarlcd') }}"><img src="{{ asset('menu/sidebar/layar.svg') }}" width="24"> <span> LCD Antrian </span></a></li>
<li><a href="{{ url('antrian_poli/suara') }}"><img src="{{ asset('menu/sidebar/Promotion.svg') }}" width="24"> <span> Suara Antrian</span></a></li> --}}



<li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><img src="{{ asset('menu/sidebar/Writing.svg') }}" width="24"> <span> Ubah DPJP </span></a></li>
</span></a></li>


{{-- @php
date_default_timezone_set("Asia/Jakarta");
$now = date("His");
$start = '060000';
$end = '130000';
@endphp
@if ($now >= $start && $now <= $end)

@else --}}
@if (config('app.laporan_aktif') =='Y')

@if (jamLaporan('rajal'))
<li><a href="{{ url('rawat-jalan/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24"> <span> Laporan </span></a></li>
@endif
@endif

<li><a href="{{ url('rawat-inap/admission') }}"><img src="{{ asset('menu/sidebar/bed.svg') }}" width="24"> <span>Pendaftaran Inap</span></a></li>
<li><a href="{{ url('/pendaftaran/pendaftaran-online') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24"> <span>Pendaftaran Online</span></a>
</li>
<li><a href="{{ url('/pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"> <span>Informasi Pasien</span></a></li>
<li><a href="{{ url('farmasi/distribusi') }}"><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="24"> <span> Distribusi </span></a></li>

<li class="treeview">
    <a href="#">
      <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>ANTRIAN</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
  
    <ul class="treeview-menu">
        @foreach (Modules\Poli\Entities\Poli::where(['politype' => 'J'])->get() as $poli)
            <li><a href="{{ url('/antrian_poliklinik/poli/' . $poli->id) }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>{{$poli->nama}}</span></a></li>
        @endforeach
      <li><a href="{{ url('/antrian_poliklinik/tv1') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 1</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv2') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 2</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv3') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 3</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv4') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 4</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv5') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 5</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv6') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 6</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv7') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 7</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv8') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 8</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv9') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 9</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv10') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 10</span></a></li>
      <li><a href="{{ url('/antrian_poliklinik/tv11') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>TV 11</span></a></li>
    </ul>
  </li>
