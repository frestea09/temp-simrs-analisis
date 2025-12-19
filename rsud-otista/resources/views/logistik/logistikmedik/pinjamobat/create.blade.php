@extends('master')

@section('header')
  <h1>Logistik - Peminjaman Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form Peminjaman Obat
      </h3>
    </div>
    <div class="box-body">
      <form class="form-horizontal" method="POST" action="{{ url('peminjaman/save') }}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nomorberita" class="col-sm-4 control-label">Nomor Berita Acara</label>
                <div class="col-sm-8">
                  <input type="text" name="nomorberita" id="" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="pinjamdari" class="col-sm-4 control-label">Pinjam Dari</label>
                <div class="col-sm-8">
                  <select name="pinjamdari" class="form-control select2" style="width: 100%">
                    @foreach ($rspinjam as $d)
                      <option value="{{ $d->id }}">{{ $d->nama }} </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ !empty(session('tanggal')) ? session('tanggal') : date('d-m-Y') }}" name="tanggal" class="form-control datepicker">
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                  <a href="{{ url('peminjaman') }}" class="btn btn-default btn-flat"> Selesai</a>
                  <button type="submit" class="btn btn-primary btn-flat">
                      Simpan
                  </button>
                  
                </div>
              </div>
            </div>
          </div>
        </form>
          
    </div>
  </div>

@endsection

@section('script')
{{-- <script type="text/javascript">
  $('.select2').select2()

</script> --}}
@endsection
