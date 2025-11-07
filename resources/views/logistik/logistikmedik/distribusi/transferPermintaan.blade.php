@extends('master')

@section('header')
  <h1><small>Logistik </small>Transfer Permintaan</h1>
@endsection

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      
      {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/transfer-permintaan', 'class'=>'form-horizontal']) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default{{ $errors->has('tgl_awal') ? ' has-error' : '' }}" type="button">Tanggal Permintaan</button>
                  </span>
                  {!! Form::text('tgl_awal', isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : NULL , ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                  <small class="text-danger">{{ $errors->first('tga') }}</small>
              </div>
            </div>
  
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Sampai Tanggal</button>
                </span>
                  {!! Form::text('tgl_akhir',  isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : NULL , ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
              </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-condensed" id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Gudang Asal</th>
              <th>Gudang Tujuan</th>
              <th>Tanggal</th>
              <th>Nomor</th>
              <th>Keterangan</th>
              <th>Edit</th>
              <th>Kirim</th>
              <th>Proses</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ \App\Logistik\LogistikGudang::find($d->gudang_asal)->nama }}</td>
                 <td>{{ \App\Logistik\LogistikGudang::find($d->gudang_tujuan)->nama }}</td>
                <td>{{ tgl_indo($d->tanggal_permintaan) }}</td>
                <td>{{ $d->nomor }}</td>
                <td>{{ @$d->keterangan }}</td>
                <td>
                  <a href="{{ url('logistikmedik/transfer-permintaan-edit/'.$d->nomor) }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-pencil"></i></a>
                </td>
                @if ($d->status == 0)
                <td>
                  <a href="{{ url('logistikmedik/proses-transfer-permintaan/'.$d->nomor) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-upload"></i></a>
                </td>
              @else
                <td>
                  <a href="#" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
                </td>
              @endif
              <td>
                @if ($d->proses_gudang == 1)
                  
                {{-- <a class="btn btn-danger btn-sm btn-flat" onclick="proses()"><i class="fa fa-check"></i></a> --}}
                <button class="btn btn-success"><i class="fa fa-check"></i></button>
                  
                @else
                     
                     <button class="btn btn-danger proses" value="{{ $d->id }}"><i class="fa fa-refresh"></i></button>
                @endif
               </td>
              <td>
              
                  <a href="{{ url('logistikmedik/cetak-transfer/'.$d->nomor) }}" target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-print"></i></a>

              </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">


$(document).ready(function() {

$(".proses").click(function() {

    var IdValue = $(this).val();
    // alert(IdValue);

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
    $.ajax({
      _token: $('input[name="token"]').val(),
      url: '/logistikmedik/prosesCheck/'+IdValue,
      type: 'POST',
      dataType: 'json'
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        alert('sukses proses');
        location.reload();
      }
    });




});

});

  
 
  
  $('.select2').select2()
//   $("#myBtn").on('click', function() {
//   //  ret = DetailsView.GetProject($(this).attr("#data-id"), OnComplete, OnTimeOut, OnError);
//   alert($(this).data("id"));
// });

  // function proses() {
  //   var plant = document.getElementById('myBtn');
  //   var fruitCount = plant.getAttribute('data-id') 
  //   console.log(fruitCount);
  //   var posID =  alert($(this).data("id"));
  //   console.log(posID);
  //   $.ajaxSetup({
  //           headers: {
  //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //           }
  //           });
  //   $.ajax({
  //     _token: $('input[name="token"]').val(),
  //     url: '/logistikmedik/prosesCheck/' + posID,
  //     type: 'POST',
  //     dataType: 'json',
  //   })
  //   .done(function(resp) {
  //     if (resp.sukses == true) {
  //       alert('Berhasil Transfer !!');
  //     }
  //   });
  // }
</script>
@endsection
