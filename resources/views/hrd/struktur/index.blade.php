@extends('master')

@section('header')
  <h1>Struktur</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        {{-- <a href="{{ url('hrd/master/struktur/create') }}" class="btn btn-default btn-flad">TAMBAH</a> --}}
        <button type="button" class="btn btn-default" id="add-modal">Tambah</button>
      </h3>
      </h3>
    </div>
    <div class="box-body">
        <table class="table table-hover table-bordered" id="data">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Parent</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($data['all'] as $key => $item)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                  @php
                    $parent = \App\HRD\HrdStruktur::find($item->parent_id);
                  @endphp
                  {{ isset($parent->nama) ? $parent->nama : null }}
                </td>
                <td>
                  <div class="btn-group"> 
                    <button type="button" class="btn btn-info btn-flat btn-sm" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" id="btn-edit-location"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                    {{-- <a class="btn btn-danger btn-flat btn-sm" href="{{ url('hrd/master/struktur/'.$item->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                    <form id="delete-form-{{ $item->id }}" action="{{ url('hrd/master/struktur/'.$item->id) }}" method="POST" style="display: none;">
                      {!! csrf_field() !!}
                      <input type="hidden" name="_method" value="DELETE">
                    </form> --}}
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" id="btn-add-pegawai"><i class="fa fa-user-plus" aria-hidden="true"></i></button>  
                    <button type="button" class="btn btn-primary btn-flat btn-sm" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" id="btn-view-pegawai"><i class="fa fa-users" aria-hidden="true"></i></button>  
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
        </table>
        <div class="row">
          <div class="col-sm-6">
            <p>Keterangan : </p>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>
                    <button type="button" class="btn btn-info btn-flat btn-sm">
                      <i class="fa fa-pencil-square" aria-hidden="true"></i>
                    </button>
                    </th>
                  <th>Tambah Struktur Baru</th>
                </tr>
                {{-- <tr>
                  <th>
                    <button type="button" class="btn btn-danger btn-flat btn-sm">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                  </th>
                  <th>Hapus Struktur</th>
                </tr> --}}
                <tr>
                  <th>
                    <button type="button" class="btn btn-default btn-flat btn-sm">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </button>
                  </th>
                  <th>Tambah Pegawai Dalam Struktur</th>
                </tr>
                <tr>
                  <th>
                    <button type="button" class="btn btn-primary btn-flat btn-sm">
                      <i class="fa fa-users" aria-hidden="true"></i>
                    </button>
                  </th>
                  <th>Lihat Pegawai Dalam Struktur</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
    </div>
  </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="formLocation" method="POST"action="{{ url('hrd/master/struktur') }}">
        {!! csrf_field() !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Struktur</h4>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="title" class="col-sm-4 col-form-label">Nama</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="nama" required="" placeholder="Masukkan Nama">
            <input type="hidden" class="form-control" name="parent_id">
          </div>
        </div>
        <div class="form-group row">
          <label for="title" class="col-sm-4 col-form-label">Parent</label>
          <div class="col-sm-8">
            <div class="file-browser">
              <ul>
                  <li class="folder" data-parent="0" data-parent-name="None"> Root</li>
                  @foreach ($data['struktur'] as $item)
                      <li class="folder" data-task="{{ $item->task_id }}" data-parent="{{ $item->id }}" data-parent-name="{{ $item->nama }}"> {{ $item->nama }}
                          <ul>
                              @foreach ($item->childrenLocation as $child)
                                  @include('hrd.struktur.recursive-option', ['child' => $child])
                              @endforeach
                          </ul>
                      </li>
                  @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="title" class="col-sm-4 col-form-label">Parent Select</label>
          <div class="col-sm-8">
            <span id="parent-select">Root</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

{{-- direksi --}}
<!-- Modal -->
<div id="myModalDireksi" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="formLocation" method="POST"action="{{ url('hrd/master/struktur/pegawai/direksi') }}">
        {!! csrf_field() !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="m-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="title" class="col-sm-4 col-form-label">Pilih Pegawai</label>
          <div class="col-sm-8">
            <select name="pegawai_id" id="masterPegawai" class="form-control">
            </select>
            <input type="hidden" class="form-control" name="struktur_id">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

{{-- view pegawai --}}
<!-- Modal -->
<div id="myModalView" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="m-title-view">Modal Header</h4>
      </div>
      <div class="modal-body" id="data-pegawai">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('script')
<script>
  let base_url = "{{ url('/') }}";
  // $(document).on('change','select[name="parent_id"]',function(){
  //   console.log(this.value)
  //   let nama = $(this).attr('data-nama');
  //   $('#parent_select').html(nama);
  // })
  $('.folder').on('click', function(e) {
    let id = $(this).attr('data-id');
    let parent = $(this).attr('data-parent');
    let parent_name = $(this).attr('data-parent-name');
    let select = $('#formLocation').find('input[name="parent_id"]').val();
    // console.log(parent);
    if( parent == select){
        alert('Please select other parent.')
        return false;
    }
    $('input[name="parent_id"]').val(parent);
    $('#parent-select').html(parent_name);
    $(this).toggleClass('folder-open');
    e.stopPropagation();
});

$(document).on('click','#btn-view-pegawai',function(){
  let name = $(this).attr('data-name');
  let id = $(this).attr('data-id');
  $('#m-title-view').html('Daftar Pegawai '+name);
  $('#myModalView').modal('show');
  getPegawai(id);
});

function getPegawai(id){
  $.ajax({
    url: base_url+'/hrd/master/struktur/getPegawai?struktur_id='+id,
    dataType: 'json',
    type: 'GET',
    cache: false,
    beforeSend: function(){
      $('#data-pegawai').html('<p class="text-center">Tunggu Sebentar...</p>');
    },
    success: function(res){
      $('#data-pegawai').html(res.html);
    }
  });
}

$(document).on('click','#btn-delete-pegawai',function(){
  if(confirm("Yakin Akan Dihapus ?")){
    let id = $(this).attr('data-id');
    $.ajax({
      url: base_url+'/hrd/master/struktur/deletePegawai?id='+id,
      dataType: 'json',
      type: 'GET',
      cache: false,
      success: function(res){
        location.reload();
      }
    });
  }
});
$(document).on('click','#btn-add-pegawai',function(){
  let name = $(this).attr('data-name');
  let id = $(this).attr('data-id');
  $('input[name="struktur_id"]').val(id);
  $('#m-title').html('Tambah '+name);
  $('#myModalDireksi').modal('show');
});

$(document).on('click','#add-modal',function(){
  $('#formLocation').attr('action',base_url+'/hrd/master/struktur');
  $('#formLocation').find('input[name="parent_id"]').val('');
    $('#formLocation').find('input[name="nama"]').val('');
  $('#myModal').modal('show');
});

$(document).on('click','#btn-edit-location',function(){
    let id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    $('#formLocation').attr('action',base_url+'/hrd/master/struktur/'+id);
    $('#formLocation').find('input[name="parent_id"]').val(id);
    $('#formLocation').find('input[name="nama"]').val(name);
    $('#myModal').modal('show');
})

$('#masterPegawai').select2({
      placeholder: "Pilih Pegawai",
      width: "100%",
      ajax: {
          url: '{{ url("hrd/master/search/pegawai") }}',
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
@section('css')
<style>
  /* .heading {
    font-weight: 400;
    text-align: center;
    background: #293538;
    margin: 0;
    color: white;
    padding: 10px 0;
}
.wrapper {
    padding: 20px 10px;
    margin: 0 auto;
    width: 300px;
} */
.file-browser {
    /* background: #364346; */
    /* color: white; */
    background: white;
    color: black;
    /* padding: 20px 10px; */
}
.file {
    /* color: #eee; */
    color: black;
    display: block;
    list-style: none;
}
.folder {
    list-style: none;
    cursor: pointer;
    margin: 4px 0;
}
.folder > ul {
    display: none;
}
.folder:before {
    /* padding: 5px; */
    height: 10px;
    width: 10px;
    text-align: center;
    line-height: 10px;
    background: black;
    /* background: #5f6f72; */
    color: white;
    border-radius: 1px;
    display: inline-block;
    content: '+';
}
.folder.folder-open > ul {
    display: block;
    padding-left: 15px;
    margin-left: 9px;
    border-left: 2px solid #5f6f72;
}
.folder.folder-open:before {
    content: '-';
}

.breadcrumb-site { 
    list-style: none; 
    overflow: hidden; 
    /* font: 18px Helvetica, Arial, Sans-Serif; */
    /* margin: 40px; */
    padding: 0;
  }
  .breadcrumb-site li { 
    float: left; 
  }
  .breadcrumb-site li a {
    color: white;
    text-decoration: none; 
    padding: 10px 0 10px 55px;
    background: brown; /* fallback color */
    background: hsl(34deg 0% 58%); 
    position: relative; 
    display: block;
    float: left;
  }
  .breadcrumb-site li a:after { 
    content: " "; 
    display: block; 
    width: 0; 
    height: 0;
    border-top: 50px solid transparent;           /* Go big on the size, and let overflow hide */
    border-bottom: 50px solid transparent;
    border-left: 30px solid hsl(34deg 0% 58%);
    position: absolute;
    top: 50%;
    margin-top: -50px; 
    left: 100%;
    z-index: 2; 
  }	
  .breadcrumb-site li a:before { 
    content: " "; 
    display: block; 
    width: 0; 
    height: 0;
    border-top: 50px solid transparent;           /* Go big on the size, and let overflow hide */
    border-bottom: 50px solid transparent;
    border-left: 30px solid white;
    position: absolute;
    top: 50%;
    margin-top: -50px; 
    margin-left: 1px;
    left: 100%;
    z-index: 1; 
  }	
  .breadcrumb-site li:first-child a {
    padding-left: 10px;
  }
  .breadcrumb-site li:nth-child(2) a       { background:        hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(2) a:after { border-left-color: hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(3) a       { background:        hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(3) a:after { border-left-color: hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(4) a       { background:        hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(4) a:after { border-left-color: hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(5) a       { background:        hsl(34deg 0% 58%); }
  .breadcrumb-site li:nth-child(5) a:after { border-left-color: hsl(34deg 0% 58%); }
  .breadcrumb-site li a:hover { background: hsl(34deg 0% 58%); }
  .breadcrumb-site li a:hover:after { border-left-color: hsl(34deg 0% 58%) !important; }

  /* a.loc-href{
      color : white;
  } */
  a.loc-href {
    color: black !important;
    }
  
  
</style>
@endsection