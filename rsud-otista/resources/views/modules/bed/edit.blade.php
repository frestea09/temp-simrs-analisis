@extends('master')

@section('header')
  <h1>Master Bed Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">

          Ubah Bed &nbsp;

        </h3>
      </div>
      <div class="box-body">
        <div class="col-sm-6">
          {!! Form::model($bed, ['route' => ['bed.update', $bed->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('bed::_form')

          {!! Form::close() !!}
        </div>
      </div>
    </div>
@stop

@section('script')
  <script type="text/javascript">
    $('.select2').select2();
    
    $('select[name="kelompokkelas_id"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkelas/'+kelompokkelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('select[name="kamarid"]').empty()
          $('select[name="kelas_id"]').empty()
          $('select[name="kelas_id"]').append('<option value=""></option>');
          $.each(data, function(key, value) {
              $('select[name="kelas_id"]').append('<option value="'+ value.id +'">'+ value.kelas +'</option>');
          });
        }
      })
    })

    $('select[name="kelas_id"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
      var kelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('select[name="kamarid"]').empty()
          $.each(data, function(key, value) {
              $('select[name="kamarid"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
          });
        }
      })
    })
  </script>
@endsection
