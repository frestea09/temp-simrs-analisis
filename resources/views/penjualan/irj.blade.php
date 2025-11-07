@extends('master')
@section('header')
  <h1>Penjualan Rawat Jalan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/jalan', 'class'=>'form-horizontal']) !!}
        <div class="row">
          {!! Form::hidden('unit', $unit) !!}
           <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div> 
           <div class="col-md-6">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
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
               <th>Histori</th>
               <th>RM Baru</th>
               <th>RM Lama</th>
               <th>Poli</th>
               <th>Jenis</th>
               {{-- <th>Alamat</th> --}}
               <th>Tgl Registrasi</th>
               <th>Proses</th>
               <th>Faktur</th>
                <th>F. Kronis K</th> 
               <th>Etiket</th>
                 <th>Edit</th>
             </tr>
           </thead>
           <tbody>
               @foreach ($data as $key => $d)
                 @php
                   $penjualan = App\Penjualan::where('registrasi_id', $d->registrasi_id)->orderBy('created_at', 'asc')->get();
                 @endphp
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ strtoupper($d->nama) }}</td>
                     <td>
                       @foreach (\App\HistorikunjunganIRJ::where('registrasi_id', $d->registrasi_id)->where('created_at', 'like', date('Y-m-d') . '%')->get(); as $i)
                           <p>-{{ baca_poli($i->poli_id) }}</p>
                       @endforeach
                     </td>
                     <td>{{ $d->no_rm }}</td>
                     <td>{{ $d->no_rm_lama }}</td>
                     <td>{{ strtoupper(baca_poli($d->poli_id)) }}</td>
                     <td>{{ baca_carabayar($d->bayar) }}</td>
                     {{-- <td>{{ strtoupper($d->alamat) }}</td> --}}
                     <td>{{ tanggal_eklaim($d->tgl_regisrasi) }}</td>
                     <td>
                      <a href="{{ url('penjualan/formpenjualan/'.$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
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
                                    <li><a href="{{ url('farmasi/cetak-detail/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a></li>
                            @endforeach
                          </ul>
                      </div>
                      @endif
                     </td>
                      <td>
                       @foreach ($penjualan as $d)
                          @php
                              $detail = \App\Penjualandetail::where('penjualan_id', $d->id)->sum('hargajual_kronis')
                          @endphp
                          @if ($detail > 0)
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
                                    <li><a href="{{ url('farmasi/laporan/etiket/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a></li>
                            @endforeach

                          </ul>
                        </div>
                        @endif
                     </td>
                      <th>
                        {{-- @if(count($penjualan) > 0)
                        <div class="btn-group">
                           <button type="button" class="btn btn-sm btn-warning">Edit</button>
                           <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right" role="menu">
                           @foreach($penjualan as $p)
                                 <li><a href="#" type="button" onclick="updatePenjualan({{ $p->id }})" class="btn btn-sm btn-block">{{ $p->no_resep }}</a></li>
                             
                           @endforeach
                           </ul>
                        </div>
                     @endif --}}
                      {{-- @foreach ($penjualan as $d)
                        <button type="button" onclick="updatePenjualan({{ $d->id }})" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-database"></i></button>
                      @endforeach --}}
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


  </script>
@endsection
