@extends('master')

@section('header')
  <h1>SIPEKA</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal &nbsp;
      </h4>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'sipeka/dashboard', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      {{-- =================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. HP</th>
              <th>Tanggal Kejadian</th>
              <th>Lokasi Kejadian</th>
              <th>Bagian Permasalahan</th>
              <th>Jenis Permasalahan Petugas/Karyawan</th>
              <th>Bidang Petugas/Karyawan</th>
              <th>Nama Petugas/Karyawan yang bersangkutan</th>
              <th>Fasilitas yang Bermasalah</th>
              <th>Jenis Permasalahan Fasilitas</th>
              <th>Jenis Permasalahan Administrasi dan Infomasi</th>
              <th>Komplain</th>
              <th>Disposisi</th>
              <th>Balas</th>
            </tr>
          </thead>
          <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($sipeka as $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->no_hp }}</td>
                <td>{{ $d->tanggal_kejadian }}</td>
                <td>{{ $d->lokasi_kejadian }}</td>
                <td>{{ $d->bagian_permasalahan }}</td>
                <td>
                    @php
                        $data = json_decode($d->jenis_permasalahan_petugas, true);
                    @endphp
                    @if(!empty($data))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($data as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>{{ $d->bidang_petugas_karyawan }}</td>
                <td>{{ $d->nama_petugas_karyawan  }}</td>
                <td>
                    @php
                        $data = json_decode($d->masalah_fasilitas, true);
                    @endphp
                    @if(!empty($data))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($data as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    @php
                        $data = json_decode($d->jenis_masalah_fasilitas, true);
                    @endphp
                    @if(!empty($data))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($data as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>{{ $d->jenis_permasalahan_administrasi  }}</td>
                <td>{{ $d->komplain  }}</td>
                <td>

                  @if ($d->disposisi == null)
                        @if (Auth::user()->id == 850)
                        <div class="dropdown">
                          <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <input type="hidden" id="insertVal" value="1">
                            <input type="hidden" id="selesaiVal" value="4">
                            <input type="hidden" id="bagianKeuangan" value="keuangan">
                            <input type="hidden" id="bagianTataUsaha" value="tata_usaha">
                            <input type="hidden" id="bagianMedis" value="medis">
                            <input type="hidden" id="bagianKeperawatab" value="keperawatan">
                            <a class="dropdown-item btn btn-warning btn-sm" value="1" id="insert"  onclick="insert({{ $d->id }})">Verifikasi Ke Direktur</a>
                            
                            <a class="dropdown-item btn btn-warning btn-sm" value="1"  onclick="updateBagianKeuangan({{ $d->id }})">Verifikasi Ke Bidang Keuangan</a>
                            <a class="dropdown-item btn btn-warning btn-sm" value="1"  onclick="updateBagianTataUsaha({{ $d->id }})">Verifikasi Ke Bidang Tata Usaha</a>
                            <a class="dropdown-item btn btn-warning btn-sm" value="1"  onclick="updateBagianMedis({{ $d->id }})">Verifikasi Ke Bidang Medis</a>
                            <a class="dropdown-item btn btn-warning btn-sm" value="1"  onclick="updateBagianKeperawatan({{ $d->id }})">Verifikasi Ke Bidang Keperawatan</a>
                            <a class="dropdown-item btn btn-warning btn-sm" value="4" id="selesai"  onclick="selesai({{ $d->id }})">Selesaikan Laporan</a>
                          </div>
                        </div>
                        @else
                        <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Oleh Admin</button></i>
                        @endif
                       

                  @elseif($d->disposisi == 1)
                      @if (Auth::user()->id == 853)
                      <input type="hidden" id="direkturVal" value="2">
                      <i><button class="btn btn-primary btn-sm" value="2" id="direktur"  onclick="direktur({{ $d->id }})">Verifikasi Ke Bagian</button></i>
                      @else
                      <i><button class="btn btn-secondary btn-sm">Sedang Di Proses Direktur</button></i>
                      @endif
                      

                  @elseif($d->disposisi == 2)
                        @if (Auth::user()->id == 854)
                            @if ($d->bidang == 'medis')
                              <input type="hidden" id="bagianVal" value="3">
                              <i><button class="btn btn-danger btn-sm" value="3" id="bagian"  onclick="bagian({{ $d->id }})">Verifikasi Pesan</button></i>
                            @else
                              <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Medis</button></i>
                            @endif

                        @elseif(Auth::user()->id == 855)
                            @if ($d->bidang == 'keperawatan')
                              <input type="hidden" id="bagianVal" value="3">
                              <i><button class="btn btn-danger btn-sm" value="3" id="bagian"  onclick="bagian({{ $d->id }})">Verifikasi Pesan</button></i>
                            @else
                              <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Keperawatan</button></i>
                            @endif

                        @elseif(Auth::user()->id == 856)
                            @if ($d->bidang == 'keuangan')
                              <input type="hidden" id="bagianVal" value="3">
                              <i><button class="btn btn-danger btn-sm" value="3" id="bagian"  onclick="bagian({{ $d->id }})">Verifikasi Pesan</button></i>
                            @else
                              <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Keuangan</button></i>
                            @endif
                        @elseif(Auth::user()->id == 565)
                            @if ($d->bidang == 'tata_usaha')
                              <input type="hidden" id="bagianVal" value="3">
                              <i><button class="btn btn-danger btn-sm" value="3" id="bagian"  onclick="bagian({{ $d->id }})">Verifikasi Pesan</button></i>
                            @else
                              <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Tata Usaha</button></i>
                            @endif
                   
                        @endif


                  @elseif($d->disposisi == 3)
                      <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Admin
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <input type="hidden" id="selesaiVal" value="4">
                          <a class="dropdown-item btn btn-success btn-sm" onclick="alert('Sudah Di Verifikasi Direktur dan bidang')">Verifikasi Ke Direktur</a>
                          <a class="dropdown-item btn btn-success btn-sm" value="4" id="selesai"  onclick="selesai({{ $d->id }})">Selesaikan Laporan</a>
                        </div>
                      </div>
                  @elseif($d->disposisi == 4)
                        <i><button class="btn btn-success btn-sm" onclick="alert('Laporan Sudah Selesai')">Selesai</button></i>
                  @endif
                </td>
                <td>
                  @if ($d->disposisi == null)
                    @if (Auth::user()->id == 850)
                      <i><button class="btn btn-warning btn-sm"  id="balasanAdmin"  onclick="balasanAdmin({{ $d->id }})">Balasan Admin / Verivikator</button></i>
                    @else
                     
                    @endif
                    
                  @elseif($d->disposisi == 2)
                    @if (Auth::user()->id == 854)
                        @if ($d->bidang == 'medis')
                           <i><button class="btn btn-danger btn-sm"  id="balasanBidang"  onclick="balasanBagian({{ $d->id }})">Balasan Bagian Bidang Mdis</button></i>
                        @else
                          <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Medis</button></i>
                        @endif

                     @elseif(Auth::user()->id == 855)
                        @if ($d->bidang == 'keperawatan')
                          <i><button class="btn btn-danger btn-sm"  id="balasanBidang"  onclick="balasanBagian({{ $d->id }})">Balasan Bagian Bidang Keperawatan</button></i>
                        @else
                          <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Keperawatan</button></i>
                        @endif

                     @elseif(Auth::user()->id == 856)
                        @if ($d->bidang == 'keuangan')
                          <i><button class="btn btn-danger btn-sm"  id="balasanBidang"  onclick="balasanBagian({{ $d->id }})">Balasan Bagian Bidang Keuangan</button></i>
                        @else
                          <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Keuangan</button></i>
                        @endif
                     @elseif(Auth::user()->id == 565)
                        @if ($d->bidang == 'tata_usaha')
                          <i><button class="btn btn-danger btn-sm"  id="balasanBidang"  onclick="balasanBagian({{ $d->id }})">Balasan Bagian Bidang Tata Usaha</button></i>
                        @else
                          <i><button class="btn btn-secondary btn-sm" >Sedang Di Proses Bagian Tata Usaha</button></i>
                        @endif

                     @endif
                  
                         
                  @elseif($d->disposisi == 3)
                      @if (Auth::user()->id == 850)
                      <i><button class="btn btn-warning btn-sm"  id="balasanAdmin"  onclick="balasanAdmin({{ $d->id }})">Balasan Admin / Verivikator</button></i>
                      @else
                 
                @endif
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>

  
  <div class="modal fade" id="balasan_admin" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Silahkan Isi Balasan Disini !</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Beri Balasan:</label>
              <textarea class="form-control" id="balasan_input"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="save_balasan_admin" class="btn btn-primary">Kirim Balasan</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="balasan_bagian" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Silahkan Isi Balasan Disini !</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Beri Balasan:</label>
              <textarea class="form-control" id="balasan_input_bagian"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="save_balasan_bagian" class="btn btn-primary">Kirim Balasan</button>
        </div>
      </div>
    </div>
  </div>


@endsection
@section('script')
<script type="text/javascript">

      function balasanAdmin(id){
       $('#balasan_admin').modal('show');
       $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/get-balasan-admin/'+id,
                  type: "get",
                  dataType: "json",
                  success:function(data) {
                      $('#balasan_input').val(data.balasan);
                  }
        });
    
        $('#save_balasan_admin').on('click', function () {
          var data = $('#balasan_input').val();
          $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-balasan-admin/'+id,
                  type: "POST",
                  data:  {balasan : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Kirim Balasan')
                      location.reload()
                  }
        });
        });
      
      }


      function balasanBagian(id){
        $('#balasan_bagian').modal('show');
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/get-balasan-bagian/'+id,
                  type: "get",
                  dataType: "json",
                  success:function(data) {
                      $('#balasan_input_bagian').val(data.balasan);
                  }
        });
        $('#save_balasan_bagian').on('click', function () {
          var data = $('#balasan_input_bagian').val();
        
          $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-balasan-bagian/'+id,
                  type: "POST",
                  data:  {balasan : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Kirim Balasan')
                      location.reload()
                  }
        });
        });
      
      }




      function insert(id) {
        
        var data = $('#insertVal').val();
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-disposisi/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Laporan')
                      location.reload()
                  }
        });
      }
      

      function direktur(id) {
        
        var data = $('#direkturVal').val();
       
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-disposisi/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Laporan')
                      location.reload()
                  }
        });
      }


      function bagian(id) {
        
        var data = $('#bagianVal').val();
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-disposisi/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Laporan')
                      location.reload()
                  }
        });
      }



      function selesai(id) {
        
        var data = $('#selesaiVal').val();
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-disposisi/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Laporan')
                      location.reload()
                  }
        });
      }


    

      
      function updateBagianKeuangan(id) {
        
        var data = $('#bagianKeuangan').val();
       
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-bidang/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Ke Bidang')
                      location.reload()
                  }
        });
      }


      function updateBagianTataUsaha(id) {
        
        var data = $('#bagianTataUsaha').val();
       
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-bidang/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Ke Bidang')
                      location.reload()
                  }
        });
      }

    
      function updateBagianMedis(id) {
        
        var data = $('#bagianMedis').val();
       
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-bidang/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Ke Bidang')
                      location.reload()
                  }
        });
      }

      
      function updateBagianKeperawatan(id) {
        
        var data = $('#bagianKeperawatan').val();
       
        $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '/sipeka/update-bidang/'+id,
                  type: "POST",
                  data:  {disposisi : data},
                  dataType: "json",
                  success:function(data) {
                      alert('Berhasil Proses Ke Bidang')
                      location.reload()
                  }
        });
      }
      
</script>
@endsection
