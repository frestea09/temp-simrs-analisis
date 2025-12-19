@extends('master')
@section('header')
  <h1>Registrasi Laboratorium Langsung</h1>
@endsection

@section('content')
<style>
	.disables {
		pointer-events: none;
		cursor: default;
		}
</style>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Hasil Pencarian Pasien
      </h3>
    </div>
    <div class="box-body">
      @if (isset($data))
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor RM Baru</th>
                <th>Nomor RM Lama</th>
                <th>Ibu Kandung</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $d)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $d->nama }}</td>
                      <td>{{ $d->no_rm }}</td>
                      <td>{{ $d->no_rm_lama }}</td>
                      <td>{{ $d->ibu_kandung }}</td>
                      <td>{{ $d->alamat }}</td>
                      <td>
                        <a href="{{ url('laboratorium/saveLaborLangsung/'.$d->id) }}" onclick="disableButton()" class="btn btn-success btncek btn-sm"><i class="fa fa-check"></i></a>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
      @endif

    </div>
  </div>
@endsection

{{-- @section('script') --}}
<script type="text/javascript">
// $(document).ready(function() {
  function disableButton(){
    // alert("A");
    $('.btncek').addClass('disables')
  }
// })

</script>
{{-- @endsection --}}
