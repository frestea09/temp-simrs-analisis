@extends('master')

@section('header')
  <h1>Android - Page - {{ $data['type_nama'] }}</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
            <strong>{!! $data['content']->content_title !!}</strong>
        </h3> --}}
          <div align="right">
            <a href="{{ url('android/pages') }}" class="btn btn-default btn-flat btn-sm">Kembali</a>
            @if( $data['type_slug'] == "berita" or $data['type_slug'] == "pelayanan" )
                <a href="{{ url('android/pages/create/'.$data["type_id"]) }}" class="btn btn-primary btn-flat btn-sm">Tambahkan</a>
            @else
                @if( $data['content'] !== null )
                    <a href="{{ url('android/pages/'.$data["content"]->id.'/edit') }}" class="btn btn-primary btn-flat btn-sm">Edit</a>
                @else
                    <a href="{{ url('android/pages/create/'.$data["type_id"]) }}" class="btn btn-primary btn-flat btn-sm">Tambahkan</a>
                @endif
            @endif
          </div>
      </div>
      <div class="box-body">
            @if( $data['type_slug'] == "berita" or $data['type_slug'] == "pelayanan" )
                <div class="row">
                    @foreach( $data['content'] as $key => $item )
                    @php $i= $key+1; @endphp
                    <div class="col-md-4">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                            <h3 class="box-title">{{ $item->content_title }}</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="text-center">
                                    <img src="{{ url($item->content_path.$item->content_thumbnail) }}" class="img-thumbnail" width="150" height="150">
                                </div>
                            {!! substr($item->content_description, 0, 75).' ...' !!}
                            </div>
                            <!-- /.box-body -->
                            <div class="box-body">
                                <a href="{{ url('android/pages/'.$item->id.'/edit') }}" class="btn btn-warning btn-flat btn-sm">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat btn-sm delete-data" data-id="{{ $item->id }}">Hapus</a>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    @if( $i % 3 == 0  )
                        <div class="clearfix"></div>
                    @endif
                    @endforeach
                </div>
                <div class="text-center">
                    {{ $data['content']->links() }}
                </div>
            @else
                @if( $data['content'] !== null )
                    <h2 class="text-center"><strong>{!! $data['content']->content_title !!}</strong></h2>
                    {!! $data['content']->content_description !!}
                @else
                    <p class="text-center">Data Halaman Tidak Ditemukan</p>
                @endif
            @endif
          </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-data">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-center" id="modal-data-title"></h4>
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
            let url = window.location.origin+'/android/pages/'+id;
            jQuery('#modal-data').modal('show', {
                backdrop: 'static'
            });
            $('#modal-data-title').html('Yakin Akan Menghapus Data ?');
            $('#form-delete').attr('action',url)
        })
    });
</script>
@endsection