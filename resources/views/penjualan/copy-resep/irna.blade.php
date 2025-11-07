@extends('master')
@section('header')
  <h1>Copy Resep - Rawat Inap  </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">
      
      {!! Form::open(['method' => 'POST', 'url' => 'copy-resep/irna', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div> 
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
          </div>
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
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
               <th>Proses</th>
               <th>Faktur</th>
                <th>F. Kronis</th> 
               <th>Etiket</th>
                <th>Edit</th>
             </tr>
           </thead>
           <tbody>
               @foreach ($data as $key => $r)
                  @php
                    $penjualan = App\CopyResep::where('registrasi_id', $r->registrasi_id)->orderBy('created_at', 'asc')->get();
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
                        <a href="{{ url('copy-resep/form-penjualan/'.$r->pasien_id.'/'.$r->registrasi_id) }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
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
                              <li><a href="{{ url('copy-resep/cetak-detail-copy-resep/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a></li>
                            @endforeach
                          </ul>
                      </div>
                      @endif
                     </td>
                      <td>
                       @foreach ($penjualan as $d)
                        @php
                            $detail = \App\CopyResepDetail::where('penjualan_id', $d->id)->sum('hargajual_kronis')
                        @endphp
                        @if ($detail > 0)
                          <a href="{{ url('copy-resep/cetak-copy-resep-fakturkronis/'.$d->id) }}" class="btn btn-danger btn-flat btn-sm" target="_blank"> <i class="fa fa-file-pdf-o"></i> </a>
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
                              <li><a href="{{ url('copy-resep/laporan/etiket/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a></li>
                            @endforeach
                          </ul>
                        </div>
                        @endif
                     </td>
                     <td>
                     @if(count($penjualan) > 0)
                        <div class="btn-group">
                           <button type="button" class="btn btn-sm btn-warning">Edit</button>
                           <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right" role="menu">
                           @foreach($penjualan as $p)
                           <li>
                            <a href="{{ url('copy-resep/form-edit-penjualan/'.cek_id_pasien($d->registrasi_id).'/'.$p->registrasi_id.'/'.$p->id) }}" class="btn btn-sm btn-block">{{ $p->no_resep }}</a>
                          </li>
                           @endforeach
                           </ul>
                        </div>
                     @endif
                     </td>
                   </tr>
                 @endforeach
             </tbody>
         </table>
       </div>
     @endif
    </div>
  </div>

  {{-- MODAL EDIT PENJUALAN --}}
  <div class="modal fade" id="penjualanDetail">
    <div class="modal-dialog">
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
