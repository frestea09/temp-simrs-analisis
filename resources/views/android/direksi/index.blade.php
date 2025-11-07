@extends('master')

@section('header')
  <h1>Android - Direksi</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
            <strong>{!! $data['content']->content_title !!}</strong>
        </h3> --}}
          <div align="right">
              <a href="{{ url('android/konfigurasi') }}" class="btn btn-default btn-flat btn-sm">Kembali</a>
              <a href="{{ url('android/direksi/create') }}" class="btn btn-primary btn-flat btn-sm" >Tambah</a>
          </div>
      </div>
         <div class="box-body">
            <div class="box-body">
                <div class='table-responsive'>
                    <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                      <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Tempat, Tgl Lahir</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Agama</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Photo</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->dir_nama }}</td>
                            <td>{{ $item->dir_tmplahir.', '.$item->dir_tgllahir }}</td>
                            <td>{{ $item->dir_kelamin }}</td>
                            <td>{{ $item->agama->agama }}</td>
                            <td>{{ $item->dir_alamat }}</td>
                            <td>{{ $item->manajemen->manaj_nama.' - '.$item->jabatan->jab_nama }}</td>
                            <td>
                                @if( $item->dir_photo !== null )
                                    <a href="{{ url($item->dir_photo_path.$item->dir_photo) }}" target="_blank">Lihat Photo</a>
                                @else
                                    Belum Ada
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('android/direksi/'.$item->id.'/edit') }}" class="btn btn-md btn-warning">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-md btn-danger delete-data" data-id="{{ $item->id }}">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
        </div>
    </div>

    <div class="modal fade" id="modal-data">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-center" id="modal-data-title">Form Halaman Baru</h4>
            </div>
            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <form method="POST" id="form-delete">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-success">Ya</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                </form>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(document).on('click','.delete-data', function(){
            let id = $(this).attr('data-id');
            let url = window.location.origin+'/android/direksi/'+id;
            jQuery('#modal-data').modal('show', {
                backdrop: 'static'
            });
            $('#modal-data-title').html('Yakin Akan Menghapus Data ?');
            $('#form-delete').attr('action',url)
        })
    })
</script>
@endsection