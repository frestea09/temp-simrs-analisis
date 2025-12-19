@extends('master')

@section('header')
  <h1>Laporan LOS</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <form method="POST" class="form-horizontal" id="formLOS">
          {{ csrf_field() }}
        <div class="col-sm-3">
          <select name="kelompokkelas_id" class="form-control select2" style="width: 100%">
            @foreach ($kamar as $d)
              <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-3">
          <input type="text" name="tga" class="form-control datepicker" placeholder="tanggal awal">
        </div>
        <div class="col-sm-3">
          <input type="text" name="tgb" class="form-control datepicker" placeholder="tanggal akhir">
        </div>
        <div class="col-sm-3">
          <button type="button" onclick="viewLOS()" class="btn btn-primary btn-flat">TAMPILKAN</button>
        </div>
        </form>
      </div>
      <hr>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Ruang</th>
              <th>No. RM</th>
              <th>Pasien</th>
              <th>Tgl Masuk</th>
              <th>Tgl Keluar</th>
              <th class="text-center">LOS</th>
            </tr>
          </thead>
          <tbody class="dataLOS">
          </tbody>
        </table>
      </div>


    </div>
          {{-- State loading --}}
            <div class="overlay hidden">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
    <div class="box-footer">
    </div>
  </div>
@endsection


@section('script')
    <script type="text/javascript">
      $('.select2').select2()

      function viewLOS() {
        $('.overlay').removeClass('hidden')
        var data = $('#formLOS').serialize()
        $.ajax({
          url: '/direksi/laporan-los',
          type: 'POST',
          dataType: 'json',
          data: data,
        })
        .done(function(data) {
          $('.overlay').addClass('hidden')
          $('.dataLOS').empty()
          $.each(data.data, function(index, val) {
             $('.dataLOS').append('<tr> <td>'+(index + 1)+'</td> <td>'+val.kamar+'</td> <td>'+val.no_rm+'</td> <td>'+val.pasien+'</td> <td>'+val.tgl_masuk+'</td> <td>'+val.tgl_keluar+'</td> <td class="text-center">'+val.jml+'</td> </tr>')
          });
        })
        .fail(function() {
          
        });
        

      }
    </script>
@endsection
