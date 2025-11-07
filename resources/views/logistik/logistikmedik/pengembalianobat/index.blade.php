@extends('master')

@section('header')
  <h1>Logistik - Pengembalian Obat
    <a href="{{ url('/pengembalian/create') }}" class="btn btn-success"> <i class="fa fa-icon fa-plus"></i> BUAT PENGEMBALIAN</a>
  </h1>

@endsection

@section('content')
@isset($pinjamobat)
    
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Pengembalian Obat
      </h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
         <table class="table table-hover table-condensed table-bordered" id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Berita Acara Pinjam</th>
                <th>Berita Acara Pengembalian</th>
                <th>Tanggal Pengembalian</th>
                <th>Edit</th>
                {{-- <th>Cetak</th> --}}
              </tr>
            </thead>
            <tbody>
              {{-- @foreach ($pinjamobat as $i)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $i->nomorberitaacara }}</td>
                  <td>{{ $i->pinjam_dari }}</td>
                  <td>{{ $i->tgl_pinjam }}</td>
                  <td>
                    <a href="{{ url('peminjaman/rincian/'.$i->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-icon fa-edit"></i></a>  
                  </td>
                </tr>
              @endforeach --}}
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endisset
@endsection

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
</script>
@endsection
