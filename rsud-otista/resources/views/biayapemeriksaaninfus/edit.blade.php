@extends('master')

@section('header')
  <h1>Kofigurasi - Biaya Infus</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Biaya Infus &nbsp;
        </h3>
        <a href="{{url('/biayapemeriksaaninfus')}}">Kembali</a>
      </div>
      <div class="box-body">
      {!! Form::open(['route' => ['biayapemeriksaaninfus.update', $biayainfus->id], 'method' => 'POST','class'=>'form-horizontal']) !!}
          
          @include('biayapemeriksaaninfus._form_edit')

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
          <th>Harga</th>
          <th>-</th>
        </tr>
        @foreach ($biayapemeriksaan as $key=>$item)
        @php
          $jenis = '';

          if ($item->tarif->jenis == "TA") {
            $jenis = 'Rawat Jalan';
          } elseif ($item->tarif->jenis == "TI") {
            $jenis = 'Rawat Inap';
          } elseif ($item->tarif->jenis == 'TG') {
            $jenis = 'IGD';
          }
        @endphp
        <tr>
          <td>{{$key+1}}</td>
          <td>{{$item->tarif->nama}} - {{$jenis}}</td>
          <td>{{number_format($item->tarif->total)}}</td>
          <td>
            <a href="{{url('biayapemeriksaaninfus/removetarif/' . $item->id)}}" onclick="return confirm('Yakin akan hapus tarif?')">Hapus</a>
          </td>
        </tr>
            
        @endforeach
      </table>
      </div>
    </div>
@stop

@section('script')
    <script>
      function saveTarifBiayaInfus(id) {
          tarif_id = $('select[name="tarif_id"]').val();
          $.ajax({
              url: '/biayapemeriksaaninfus/addtarif/'+id,
              type: "POST",
              dataType: "json",
              data: {
                  _token: "{{ csrf_token() }}",
                  tarif_id
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
