@extends('master')
@section('header')
  <h1>Penjualan Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/darurat-baru', 'class'=>'form-horizontal']) !!}
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
          {{-- <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">No RM</button>
              </span>
                <select name="no_rm" id="masterNorm" class="form-control" onchange="this.form.submit()"></select>
            </div>
          </div> --}}
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
           <thead>
             <tr>
               <th>No</th>
               <th>Nama</th>
               <th>RM Baru</th>
               <th>Poli</th>
               <th>Jenis</th>
               <th>Di Bayar</th>
               <th>Tgl Registrasi</th>
               <th>Proses</th>
               <th>Tgl Entry</th>
               <th>Etiket</th> 
                <th>Edit</th>
             </tr>
           </thead>
           <tbody>
               @foreach ($data->groupBy('registrasi_id') as $key => $penjualans)
                 @php
                    $data = $penjualans->first();
                 @endphp
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ strtoupper($data->nama) }}</td>
                     <td>{{ $data->no_rm }}</td>
                     <td>{{ $data->nama_poli }}</td>
                     <td>{{ $data->carabayar }}</td>
                     <td>
                        @if ($data->lunas == 'Y')
                            {{ 'Lunas' }}
                        @else
                            {{ 'Belum Lunas' }}
                        @endif
                     </td>
                     <td>{{ $data->tgl_regisrasi }}</td>
                     <td>
                      <a href="{{ url('penjualan/form-penjualan-baru/'.$data->pasien_id).'/'.$data->registrasi_id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                     </td>
                     <td>
                      {{ @$penjualans->sortBy('pj_created_at', 'desc')->first()->pj_created_at }}
                     </td>
                     <td>
                       @if ($penjualans->first())
                       <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-primary">Cetak</button>
                          <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach ($penjualans as $p)
                            <li>
                                <a href="{{ url('farmasi/laporan/etiket/'.$p->penjualan_id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                        @endif
                     </td>  
                    <th>
                      @if ($penjualans->first())
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-warning">Edit</button>
                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                          @foreach ($penjualans as $p)
                          <li>
                            {{-- <button type="button" onclick="updatePenjualan({{ $p->id }})" class="btn btn-sm btn-flat"><i class="fa fa-pencil"></i> {{ $p->no_resep }}</button> --}}
                            <a target="_blank" href="{{url("penjualan/editformpenjualan/Inap/$data->registrasi_id/$p->penjualan_id")}}">
                                <button type="button"  class="btn btn-sm btn-flat"><i class="fa fa-pencil"></i> {{ $p->no_resep }}
                                </button>
                            </a>
                          </li>
                        @endforeach
                        </ul>
                      </div>
                      @endif
                    </th>
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


  </script>
@endsection
