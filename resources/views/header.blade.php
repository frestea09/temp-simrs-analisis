<a href="{{ url('/') }}" class="logo">
  <span class="logo-mini"><b></b>S</span>
  <span class="logo-lg">SIMRS Terintegrasi</span>
</a>
<nav class="navbar navbar-static-top">
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div style="font-size: 15pt; float: left; margin-left: 20px; letter-spacing: 1;line-height:70px;">
       {{ config('app.header') }} 
       {{-- {{ config('app.kota') }}  --}}
 {{-- @include('cekinternet') --}}
  </div>
  @php 
     $datas = Modules\Pegawai\Entities\Pegawai::where('user_id', Auth::user()->id)->where('foto_profile','!=', null)->orderBy('id', 'asc')->first();
  @endphp
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li class="dropdown user user-menu">
        @if($datas)
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{-- <img src="{{ asset('style') }}/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> --}}
            {{-- <span class="hidden-xs">{{ Auth::user()->name }}</span> --}}
            {{-- <img src="{{ asset('images/'.$datas->foto_profile) }}" width="24">  --}}
            {{ Auth::user()->name }}
          </a>
        @else
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{-- <img src="{{ asset('style') }}/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">  --}}
            {{ Auth::user()->name }} 
            @if (@Auth::user()->gudang_id)
            <small>(<b>Gudang</b> : {{@baca_gudang_logistik(Auth::user()->gudang_id)}})</small>
                
            @endif
            {{-- <img src="{{ asset('images/1670644761user.jfif') }}" width="24"> {{ Auth::user()->name }} --}}
          </a>
        @endif
        <ul class="dropdown-menu">
          <li class="user-header">
            {{-- <img src="{{ asset('style') }}/dist/img/user2-160x160.jpg" class="img-circle" alt="Image"> --}}
            <hr>
            <p><b>{{ Auth::user()->name }}</b></p>
            @php
                $datasip = Modules\Pegawai\Entities\Pegawai::where('user_id', Auth::user()->id)->first();
            @endphp
            @if($datasip)

             @if($datasip->kategori_pegawai == 1)
                @if($datasip->sip)
                  <p>SIP   : {{ $datasip->sip }} </p>
      
                @else
                  <p>SIP: - </p>
                @endif
              @endif

            @else

               <p>SIP: - </p>
            @endif
            
            @if($datasip)
              @if($datasip->kategori_pegawai != 1)
                @if($datasip->str)
                  <p>STR: {{ $datasip->str }} </p>
                @else
                  <p>STR: - </p>
                @endif
              @endif
            @else
              <p></p>
            @endif

            <hr>
            <p><small>Masuk Sejak : {{ Auth::user()->created_at->diffForHumans() }}</small><hr></p>
          </li>
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{ route('user.show', Auth::user()->id) }}" class="btn btn-default btn-flat">Ubah Kata Sandi</a>
            </div>
            <div class="pull-right">
              <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar SIMRS</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
