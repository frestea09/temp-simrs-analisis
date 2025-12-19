@extends('master')
@section('header')
  <h1>Management User</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
 
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data User &nbsp;
        <a href="{{ route('user.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
      <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            @if (Auth::user()->id == '1')
              <th>Edit</th>
              <th>Hapus</th>
                
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach ($user as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->name }}</td>
              <td>{{ $d->email }}</td>
              <td>
                <ul>
                  @foreach ($d->role as $r)
                    <li>{{$r->display_name}} </li>
                  @endforeach
                </ul>
              </td>
              @if (Auth::user()->id == '1')
              <td>
                <a href="{{ route('user.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                {{-- <button onclick="hapus({{ $d->id }})" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button> --}}
              </td>
              <td>
                {{-- <a href="{{ route('user.hapus', $d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                <button onclick="hapus({{ $d->id }})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
              </td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('script')
<script>

  function hapus(id) {
    
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: 'user/'+id+'/hapus',
      type: 'POST',
      dataType: 'json',
      success: function (data) {
        alert('berhasil Hapus');
        location.reload();
      }
    });
  }

</script>
@endsection