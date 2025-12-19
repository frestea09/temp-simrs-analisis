@extends('master')

@section('header')
  {{-- <h1>Surat Masuk</h1> --}}
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
            Form Surat <a href="{{url('/hrd/administrasi/surat-masuk/')}}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" action="{{ url('hrd/administrasi/surat-masuk/save') }}" class="form-horizontal" id="formBiodata" enctype="multipart/form-data">
            {{ csrf_field() }} 
            <input type="hidden" name="type" value="surat_masuk">
            <input type="hidden" name="id" value="{{$data ? $data->id :''}}">
            <div class="form-group">
                <label for="nama" class="col-sm-4 control-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" name="nama" class="form-control" value="{{$data?$data->nama:''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="nama" class="col-sm-4 control-label">Nomor</label>
                <div class="col-sm-6">
                    <input type="text" name="nomor" class="form-control" value="{{$data?$data->nomor:''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="ttl" class="col-sm-4 control-label">File</label>
                <div class="col-sm-6">
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="ttl" class="col-sm-4 control-label"></label>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
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
