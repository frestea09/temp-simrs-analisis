@extends('master')

@section('header')
  {{-- <h1>Surat Masuk</h1> --}}
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
            Preview Dokumen
      </h3>
    </div>
    <div class="box-body">
       <table class="table table-bordered">
        <tr>
            <td><b>Nama</b></td>
            <td>{{$data->nama}}</td>
        </tr>
        <tr>
            <td><b>Nomor</b></td>
            <td>{{$data->nomor}}</td>
        </tr>
        <tr>
            <td><b>File</b></td>
            <td>
                <a href="{{asset('dokumen/'.$data->filename) }}">Download</a>
            </td>
        </tr>
        
       </table>
    </div>
    <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

    $('#masterPegawai').select2({
        placeholder: "Pilih Pegawai",
        ajax: {
            url: '{{ url("hrd/biodata/search/pegawai") }}',
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

</script>
@endsection
