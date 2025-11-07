@extends('master')

@section('header')
  <h1>Logistik - Pinjam Obat
    <a href="{{ url('/peminjaman/create') }}" class="btn btn-success"> <i class="fa fa-icon fa-plus"></i> BUAT PEMINJAMAN</a>
  </h1>

@endsection

@section('content')
@isset($pinjamobat)
    
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Peminjaman Obat
      </h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
         <table class="table table-hover table-condensed table-bordered" id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Berita Acara</th>
                <th>Pinjam Dari</th>
                <th>Tanggal Pinjam</th>
                {{-- <th>Edit</th> --}}
                <th>Operator</th>
                <th>Pengembalian</th>
                {{-- <th>Cetak</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($pinjamobat as $i)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $i->nomorberitaacara }}</td>
                  <td>{{ \App\Rstujuanpinjam::where('id',$i->pinjam_dari)->first()->nama }}</td>
                  <td>{{ $i->tgl_pinjam }}</td>
                  {{-- <td>
                    <a href="{{ url('peminjaman/rincian/'.$i->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-icon fa-edit"></i></a>  
                  </td> --}}
                  <td>{{$i->user_id ? $i->user->name: '-'}}</td>
                  <td>
                    <a href="{{ url('pengembalian/create/'.$i->id) }}" class="btn btn-success btn-sm"> <i class="fa fa-icon fa-refresh"></i></a>  
                  </td>
                </tr>
              @endforeach
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
