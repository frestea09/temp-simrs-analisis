@extends('master')
@section('header')
  <h1>Penjualan Operasi  </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'GET', 'url' => 'penjualan/ibs-baru', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row" style="display: flex; flex-flow: row">
                <div class="col-md-8 input-group{{ $errors->has('search') ? ' has-error' : '' }}">
                    {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Nama/No RM']) !!}
                    <small class="text-danger">{{ $errors->first('search') }}</small>
                </div>
                <div class="col-md-4" >
                    <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI">
                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed'>
           <thead>
             <tr>
               <th>No</th>
               <th>Nama</th>
               <th>Nomor RM</th>
               <th>Alamat</th>
               <th>Tgl Registrasi</th>
               <th>Cara Bayar</th>
               @role('administrator')
                <th></th>
               @endrole
               <th>E-Resep</th>
               <th>Proses</th>
               <th>Proses New</th>
               <th>Tanggal Entry</th>
               <th>Rincian</th>
               <th>Faktur</th>
                <th>F. Kronis</th>
               <th>Etiket</th>
                {{--  <th>Edit</th>  --}}
                {{-- @role(['administrator']) --}}
                @if (Auth::user()->hasRole(['administrator', 'apotik']) || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                 {{-- <th>Hapus</th> --}}
                @endif
                @if (Auth::user()->hasRole(['administrator', 'apotik']) || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                 <th>Edit</th>
                @endif
             </tr>
           </thead>
           <tbody>
                @foreach ($data as $key => $r)
                  @php
                    $penjualan = App\Penjualan::where('registrasi_id', $r->registrasi_id)->orderBy('created_at', 'asc')->get();
                    $tgl_entry = App\Penjualan::where('registrasi_id', $r->registrasi_id)->orderBy('created_at', 'desc')->first();
                  @endphp
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ $r->nama }}</td>
                     <td>{{ $r->no_rm }}</td>
                     <td>{{ $r->alamat }} RT. {{ $r->rt }} RW. {{ $r->rw }}</td>
                     <td>{{ $r->created_at }}</td>
                     <td>{{ baca_carabayar($r->bayar) }}</td>
                      @role('administrator')
                        <td>
                            <a onclick="insertTagihan({{ $r->registrasi_id }}, '{{  $r->no_rm }}')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-plus"></i></a>
                        </td>
                     @endrole
                     <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary">Resep</button>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                          @forelse ($r->e_resep->whereIn('status',['dikirim','diproses']) as $v)
                            <li>
                                @if($v->status == "diproses")
                                  <a href="javascript:void(0)" class="btn btn-flat btn-sm text-success">{{ $v->uuid }} <i class="fa fa-check-square" aria-hidden="true"></i>
                                  </a>
                                @else
                                  <a href="{{ url('penjualan/form-penjualan-baru-ibs/'.$r->pasien_id.'/'.$r->registrasi_id.'?resep='.$v->uuid) }}" class="btn btn-flat btn-sm" target="_blank">{{ $v->uuid }}</a>
                                @endif
                            </li>
                          @empty
                            <li>
                                <a href="javascript:void(0)" class="btn btn-flat btn-sm">Belum Ada</a>
                            </li>
                          @endforelse
                        </ul>
                    </div>
                     </td>
                     <td>
                       <a href="{{ url('penjualan/form-penjualan-baru-ibs/'.$r->pasien_id).'/'.$r->registrasi_id }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
                     </td>
                     <td>
                      <a href="{{ url('penjualannew/form-penjualan-baru-ibs/' . $r->pasien_id) . '/' . $r->registrasi_id }}"
                          class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check"></i></a>
                    </td>
                     <td>
                      {{ @$tgl_entry->created_at }}
                     </td>
                     <td>
                        <a href="{{url('ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'.$r->registrasi_id) }}"class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank"><span class="fa fa-print"></span></a>
                      </td>
                      <td>
                       @if ($penjualan->first())
                       <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                          <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach ($penjualan as $p)
                                <li>
                                  <a href="{{ url('farmasi/cetak-detail-operasi/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">
                                      
                                      @php
                                      $nosep = App\Penjualan::find($p->id);
                                      $resep = substr($p->no_resep, 0, 3);
                                      @endphp

                                      @if ($nosep->user_id == 614 || $nosep->user_id == 613 || $nosep->user_id == 671 || $nosep->user_id == 800 || $nosep->user_id == 801 || $nosep->user_id == 711)
                                            
                                      @if ($resep == 'FRD')

                                      {{ str_replace('FRD', 'FRO', $p->no_resep) }}

                                      @elseif($resep == 'FRI') 

                                        {{ str_replace('FRI', 'FRO', $p->no_resep) }}

                                      @endif
                                            
                                            
                                      @else

                                          {{  $p->no_resep }}

                                      @endif
                                    
                                    </a>
                                  {{--  @endif  --}}
                                </li>
                            @endforeach
                          </ul>
                      </div>
                      @endif
                     </td>
                      <td>
                        @foreach ($penjualan as $d)
                        @php
                            $detail = \App\Penjualandetail::where('penjualan_id', $d->id)->where('is_kronis', 'Y')->first();
                        @endphp
                        @if ($detail != null)
                        <a href="{{ url('farmasi/cetak-fakturkronis/'.$d->id) }}" class="btn btn-danger btn-flat btn-sm" target="_blank"> <i class="fa fa-file-pdf-o"></i> </a>
                        @endif
                       @endforeach
                     </td>
                      <td>
                       @if ($penjualan->first())
                       <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-primary">Cetak</button>
                          <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach ($penjualan as $p)
                              <li><a href="{{ url('farmasi/laporan/etiket/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">

                                @php
                                    $nosep = App\Penjualan::find($p->id);
                                    $resep = substr($p->no_resep, 0, 3);
                                @endphp

                                @if ($nosep->user_id == 614 || $nosep->user_id == 613 || $nosep->user_id == 671 || $nosep->user_id == 800 || $nosep->user_id == 801 || $nosep->user_id == 711)
                                        
                                  @if ($resep == 'FRD')

                                  {{ str_replace('FRD', 'FRO', $p->no_resep) }}

                                  @elseif($resep == 'FRI') 

                                    {{ str_replace('FRI', 'FRO', $p->no_resep) }}

                                  @endif
                                        
                                        
                                @else

                                    {{  $p->no_resep }}

                                @endif

                               

                               


                              </a></li>
                            @endforeach
                          </ul>
                        </div>
                        @endif
                     </td>

                     {{--  <td>
                     @if(count($penjualan) > 0)
                        <div class="btn-group">
                           <button type="button" class="btn btn-sm btn-warning">Edit</button>
                           <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right" role="menu">  --}}
                           {{--  @foreach($penjualan as $p)  --}}
                              {{-- @if(resepLunas($p->no_resep) == 'Y') --}}
                                 {{--  <li><a href="#" type="button" onclick="updatePenjualan({{ $p->id }})" class="btn btn-sm btn-block">{{ $p->no_resep }}</a></li>  --}}
                              {{-- @else
                                 <li class="btn btn-sm btn-block"><strike>{{ $p->no_resep }}</strike></li>
                              @endif --}}
                           {{--  @endforeach  --}}
                           {{--  </ul>
                        </div>
                     @endif
                     </td>  --}}

                      {{-- <td>
                        @if ($penjualan->first())
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning">Edit</button>
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach ($penjualan as $p)
                                    <li>
                                      <button type="button" onclick="updatePenjualan({{ $d->id }})" class="btn btn-sm btn-flat"> {{ $p->no_resep }}</button>
                                    </li>
                            @endforeach

                          </ul>
                        </div>
                        @endif
                      @foreach ($penjualan as $d)
                        <button type="button" onclick="updatePenjualan({{ $d->id }})" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-database"></i></button>
                      @endforeach
                      </td> --}}
                       {{-- @role(['administrator']) --}}
                      @if (Auth::user()->hasRole(['administrator', 'apotik']) || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                        {{-- <th>
                          @if ($penjualan->first())
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                              @foreach ($penjualan as $p)
                              <li>
                                <button type="button" onclick="hapusPenjualan({{ $p->id }})" class="btn btn-sm btn-flat"><i class="fa fa-remove"></i> {{ $p->no_resep }}</button>
                              </li>
                            @endforeach
                            </ul>
                          </div>
                          @endif
                        </th> --}}
                      @endif
                      @if (Auth::user()->hasRole(['administrator', 'apotik']) || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                        <th>
                          @if ($penjualan->first())
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning">Edit</button>
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                              @foreach ($penjualan as $p)
                              <li>
                                {{-- <button type="button" onclick="hapusPenjualan({{ $p->id }})" class="btn btn-sm btn-flat"><i class="fa fa-remove"></i> {{ $p->no_resep }}</button> --}}
                                {{-- <button type="button" onclick="updatePenjualan({{ $p->id }})" class="btn btn-sm btn-flat"><i class="fa fa-pencil"></i> {{ $p->no_resep }}</button> --}}
                                <li><a target="_blank" href="{{url('penjualan/editformpenjualan/Inap/'.$d->registrasi_id.'/'.$p->id)}}" class="btn btn-sm btn-block">
                                  
                                  
                                  @php
                                  $nosep = App\Penjualan::find($p->id);
                                  $resep = substr($p->no_resep, 0, 3);
                                  @endphp

                                  @if ($nosep->user_id == 614 || $nosep->user_id == 613 || $nosep->user_id == 671 || $nosep->user_id == 800 || $nosep->user_id == 801 || $nosep->user_id == 711)
                                          
                                    @if ($resep == 'FRD')

                                    {{ str_replace('FRD', 'FRO', $p->no_resep) }}

                                    @elseif($resep == 'FRI') 

                                      {{ str_replace('FRI', 'FRO', $p->no_resep) }}

                                    @endif
                                          
                                          
                                  @else

                                      {{  $p->no_resep }}

                                  @endif
   
                                </a></li>
                                {{-- <a href="{{ url('penjualan/hapus-faktur-baru/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a> --}}
                              </li>
                            @endforeach
                            </ul>
                          </div>
                          @endif
                        </th>
                      @endif
                   </tr>
                @endforeach
             </tbody>
         </table>
         {{$data->appends(['tga' => request('tga'), 'tgb' => request('tgb'),  'search' => request('search')])->links()}}
       </div>
     @endif
    </div>
  </div>

  {{-- MODAL EDIT PENJUALAN --}}
  <div class="modal fade" id="penjualanDetail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div id="loadPenjualanDetail"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-flat addPenjualan" >Tambah Obat</button>
        </div>
      </div>
    </div>
  </div>
  {{-- MODAL HAPUS PENJUALAN --}}
  <div class="modal fade" id="penjualanHapusDetail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div id="loadPenjualanDetailHapus"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  {{-- TAMBAH OBAT --}}
  <div class="modal fade" id="tambahObat">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div id="loadTambahPenjualan"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat closeAddObat">Tutup</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="saveObat()">SIMPAN</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('script')
  <script type="text/javascript">
    $('.select2').select2();
    $('#masterNorm').select2({
        placeholder: "Pilih No Rm...",
        ajax: {
          url: '/pasien/master-pasien/',
          dataType: 'json',
          data: function (params) {
            return {
              q: $.trim(params.term)
            };
          },
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    })

    function updatePenjualan(penjualan_id) {
      $('#penjualanDetail').modal('show');
      $('#tambahObat').modal('hide')
      $('.modal-title').text('Update Penjualan Obat');
      $('#loadPenjualanDetail').load('/detail-penjualan/'+penjualan_id);
      $('.addPenjualan').attr('onclick', 'tambahObat('+penjualan_id+')');
    }

    function hapusPenjualan(penjualan_id) {
      $('#penjualanHapusDetail').modal('show');
      $('#tambahObat').modal('hide')
      $('.modal-title').text('Hapus Penjualan Obat');
      $('#loadPenjualanDetailHapus').load('/detail-penjualan-baru/'+penjualan_id);
    }

    function hapusObat(id){
      $.ajax({
        url: '/hapus-detail-penjualan/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data.sukses == true) {
            $('#penjualanDetail').modal('show');
            $('.modal-title').text('Update Penjualan Obat');
            $('#loadPenjualanDetail').load('/detail-penjualan/'+data.penjualan_id);
          }
        }
      });
    }

    function updateDetail() {
      var data = $('#formUpdateFaktur').serialize();
      $.ajax({
        url: '/penjualan/updateFaktur',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
          if (data.sukses == true) {
            alert('Berhasil Update !')
            updatePenjualan(data.penjualan_id)
          } else {
            alert('Gagal Update !')
            updatePenjualan(data.penjualan_id)
          }
        }
      });
    }

    function tambahObat(penjualan_id) {
      $('#penjualanDetail').modal('hide');
      $('#tambahObat').modal('show')
      $('.modal-title').text('Tambah Obat')
      $('#loadTambahPenjualan').load('/tambah-detail-penjualan/'+penjualan_id);
      $('.closeAddObat').attr('onclick', 'updatePenjualan('+penjualan_id+')');
    }

    function saveObat() {
      var data = $('#formTambahPenjualan').serialize();
      $.ajax({
        url: '/simpan-detail-penjualan',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
          if (data.sukses == true) {
            updatePenjualan(data.penjualan_id)
          } else {
            updatePenjualan(data.penjualan_id)
          }
        }
      });
    }

    function insertTagihan(registrasi_id, no_rm) {
      if (confirm('Yakin tagihan RM '+no_rm+' akan di tambahkan ke Tagihan?') == true) {
        $.ajax({
        url: '/penjualan/insert-tagihan-penjualan/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        if (data.sukses == true) {
          alert(data.notif)
        }
      });
      }
    }
  </script>
@endsection
