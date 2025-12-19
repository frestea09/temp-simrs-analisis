@extends('master')

@section('header')
  <h1>Kofigurasi - Biaya Farmasi</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Biaya Farmasi &nbsp;
        </h3>
        <a href="{{url('/biayapemeriksaanfarmasi')}}">Kembali</a>
      </div>
      <div class="box-body">
      {!! Form::open(['route' => ['biayapemeriksaanfarmasi.update', $biayafarmasi->id], 'method' => 'POST','class'=>'form-horizontal']) !!}
          
          @include('biayapemeriksaanfarmasi._form_edit')

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
          <th>Obat</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Jenis</th>
          <th>Signa</th>
          <th>Informasi</th>
          <th>Aksi</th>
        </tr>
        @foreach ($biayapemeriksaan as $key=>$item)
        <tr>
          <td>{{$key+1}}</td>
          <td>{{$item->masterobat->nama}}</td>
          <td>{{number_format($item->masterobat->hargajual)}}</td>
          <td>{{$item->qty}}</td>
          <td>
              @if($item->obat_racikan === 'Y')
                  RACIK
              @elseif($item->obat_racikan === 'N')
                  NON RACIK
              @endif
          </td>
          <td>{{$item->cara_minum}}</td>
          <td>{{$item->informasi}}</td>
          <td>
            <a href="{{url('biayapemeriksaanfarmasi/removeobat/' . $item->id)}}" onclick="return confirm('Yakin akan hapus obat?')">Hapus</a>
          </td>
        </tr>
            
        @endforeach
      </table>
      </div>
    </div>
@stop

@section('script')
<script>
  function saveObatBiayaFarmasi(id) {
      let masterobat_id = $('select[name="masterobat_id"]').val();
      let qty = $('input[name="qty"]').val();
      let obat_racikan = $('select[name="obat_racikan"]').val();
      let cara_minum = $('input[name="cara_minum"]').val();
      let informasi = $('input[name="informasi"]').val();

      $.ajax({
          url: '/biayapemeriksaanfarmasi/addobat/' + id,
          type: "POST",
          dataType: "json",
          data: {
              _token: "{{ csrf_token() }}",
              masterobat_id: masterobat_id,
              qty: qty,
              obat_racikan: obat_racikan,
              cara_minum: cara_minum,
              informasi: informasi
          },
          success:function(data) {
            if (data.sukses) {
              alert('Berhasil menambah obat');
              window.location.reload();
            } else {
              alert('Gagal menambah obat');
            }
          }
      });
  }
</script>
@endsection
