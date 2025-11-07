<li class="header text-yellow"><strong>ANTRIAN RAWAT JALAN</strong></li>
<li><a href="{{ url('antrian/antrian') }}"><img src="{{ asset('menu/sidebar/pengguna.svg') }}" width="24"><span> Antrian</span></a></li>
<li class="treeview">
    <a href="#">
      <img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>ANTRIAN POLI</span>
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
      <li><a href="{{ url('/antrian_poliklinik/jantung_dalam') }}" target="_blank"><img src="{{ asset('menu/sidebar/pendaftaran.svg') }}" width="24"> <span>Klinik Jantung & Dalam</span></a></li>
    </ul>
  </li>
