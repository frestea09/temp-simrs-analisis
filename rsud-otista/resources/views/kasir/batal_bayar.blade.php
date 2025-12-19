@extends('master')

@section('header')
  <h1>Batal Bayar<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      {{-- {!! Form::open(['method' => 'POST', 'url' => 'kasir/batal-bayar', 'class'=>'form-hosizontal']) !!} --}}
      <div class="row">
        {{-- <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div> --}}

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">No RM/NAMA</button>
            </span>
            {!! Form::text('keyword', null, [
              'class' => 'form-control', 
              'autocomplete' => 'off', 
              'placeholder' => 'NO RM/NAMA',
              'required',
              ]) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6">
              <button class="btn btn-primary btn-flat searchBtn">
                  <i class="fa fa-search"></i> Cari
              </button>
          </div>
        </div>
        {{-- <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()','autocomplete'=>'off']) !!}
          </div>
        </div> --}}
      </div>
      {{-- {!! Form::close() !!} --}}
      <hr>

      <div class='table-responsive'>
        <table id='tableBatalBayar' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Pelayanan</th>
              <th>Alamat</th>
              <th>Tgl Registrasi</th>
              <th>Tgl Bayar</th>
              <th>User</th>
              <th>NoKwitansi</th>
              <th class="text-center">Total Bayar</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>


  <div class="modal fade" id="rincianBayar" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Rincian Pembayaran</h4>
        </div>
        <div class="modal-body" id="dataRincianBayar">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
      var tableBatalBayar = $('#tableBatalBayar').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/kasir/data-batal-bayar',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'alamat', orderable: false},
            {data: 'tglReg', orderable: false},
            {data: 'tglBayar', orderable: false},
            {data: 'user', orderable: false},
            {data: 'kwitansi', orderable: false},
            {data: 'dibayar', orderable: false},
            {data: 'detail', orderable: false},
        ]
      });

      $(".searchBtn").click(function (){
        tableBatalBayar.draw();
      });

    });

  </script>
@endsection
