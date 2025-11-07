@extends('master')

@section('header')
  <h1>Lain-lain
    <a href="{{ url('hrd/administrasi/lain/create') }}" class="btn btn-default btn-flad btn-md">TAMBAH</a>
  </h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'hrd/administrasi/lain/byTanggal', 'class'=>'form-hosizontal']) !!}
     <div class="row">
       <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
             <span class="input-group-btn">
               <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
             </span>
             {!! Form::text('tga', date('d-m-Y'), ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
             <small class="text-danger">{{ $errors->first('tga') }}</small>
         </div>
       </div>

       <div class="col-md-6">
         <div class="input-group">
           <span class="input-group-btn">
             <button class="btn btn-default" type="button">Sampai Tanggal</button>
           </span>
             {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
         </div>
       </div>
       </div>
     {!! Form::close() !!}
     <hr> 

   </div>
    <div class="box-body">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="data">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Dokumen</th>
                  <th>Nama File</th>
                  <th>File</th>
                  <th>Tipe</th>
                  <th>Tanggal Upload</th>
                  <th>Upload Oleh</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $key=>$item)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->nomor}}</td>
                    <td>{{$item->nama}}</td>
                    <td style="font-size:10px;">{{$item->filename}}</td>
                    <td>{{$item->extension}}</td>
                    <td>{{date('Y-m-d',strtotime($item->created_at))}}</td>
                    <td>{{@$item->user->name}}</td>
                    <td style="width:100px;">
                      <a target="_blank" class="btn btn-success btn-flat btn-xs" href="{{asset('dokumen/'.$item->filename) }}"><i class="fa fa-download"></i></a>
                      <a href="{{ url('hrd/administrasi/lain/create/'.$item->id) }}" class="btn btn-info btn-flat btn-xs"><i class="fa fa-edit"></i></a>  
                      <a onclick="return confirm('Yakin akan menghapus dokumen?')" href="{{ url('hrd/administrasi/lain/delete/'.$item->id) }}" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i></a>  
                    </td>
                    
                  </tr>
                    
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>


@endsection

@section('script')
{{-- <script type="text/javascript">

  var table;
    table = $('.table').DataTable({
      'language': {
          'url': '/DataTables/datatable-language.json',
      },
      select: {
      	style: 'multi'
      },
      ordering: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: '{{ route('biodata.data') }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'nama'},
          {data: 'ttl'},
          {data: 'kelamin'},
          {data: 'alamat'},
          {data: 'nohp'},
          {data: 'status'},
          {data: 'action', searchable: false}

      ]
    });

</script> --}}
@endsection
