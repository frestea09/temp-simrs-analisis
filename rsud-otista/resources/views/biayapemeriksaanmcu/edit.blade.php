@extends('master')

@section('header')
  <h1>Kofigurasi - Biaya MCU</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Biaya MCU &nbsp;
        </h3>
        <a href="{{url('/biayapemeriksaanmcu')}}">Kembali</a>
      </div>
      <div class="box-body">
      {!! Form::open(['route' => ['biayapemeriksaanmcu.update', $biayamcu->id], 'method' => 'POST','class'=>'form-horizontal']) !!}
          
          @include('biayapemeriksaanmcu._form_edit')

          <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
              {!! Form::submit("Simpan", ['class' => 'btn btn-success']) !!}
          </div>

      {!! Form::close() !!}
      <br/>
      <br/>
      <table class="table table-bordered">
        <tr>
          <th>No</th>
          <th>Tarif</th>
          <th>Jenis</th>
          <th>Harga</th>
          <th>-</th>
        </tr>
        @foreach ($biayapemeriksaan as $key=>$item)
        @if (@$item->tarif)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->tarif->nama}}</td>
            <td>{{$item->jenis}}</td>
            <td>{{number_format($item->tarif->total)}}</td>
            <td>
              <a href="{{url('biayapemeriksaanmcu/removetarif/' . $item->id)}}" onclick="return confirm('Yakin akan hapus tarif?')">Hapus</a>
            </td>
          </tr>
            
        @endif
            
        @endforeach
      </table>
      </div>
    </div>
@stop

@section('script')
    <script>
      function saveTarifBiayaMCU(id) {
          tarif_id = $('select[name="tarif_id"]').val();
          jenis = $('select[name="jenis"]').val();
          $.ajax({
              url: '/biayapemeriksaanmcu/addtarif/'+id,
              type: "POST",
              dataType: "json",
              data: {
                  _token: "{{ csrf_token() }}",
                  tarif_id,
                  jenis
              },
              success:function(data) {
                if (data.sukses) {
                  alert('Berhasil menambah tarif');
                  window.location.reload();
                } else {
                  alert('Gagal menambah tarif');
                }
              }
          });
        }
    </script>
@endsection
