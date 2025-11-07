@extends('master')
@section('header')
  <h1>Update Jadwal : {{$jadwal[0]->namadokter}}<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body"> 
      @if( Session::has("error") )
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
        {{Session::get('error')}}
        </div>
      @endif
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan">
        <div class="col-sm-12">
          <div class="table-responsive">
            <form method="POST" class="form-horizontal" action="{{url('bridgingsep/update-jadwal-dokter-hfis')}}" id="formKunjungan"> 
            {{csrf_field()}}
            <input type="hidden" name="kodepoli" value="{{$jadwal[0]->kodepoli}}">
            <input type="hidden" name="kodesubspesialis" value="{{$jadwal[0]->kodesubspesialis}}" >
            <input type="hidden" name="kodedokter" value="{{$jadwal[0]->kodedokter}}" >
            <table class="table table-hover table-striped table-bordered" style="width:70%;">
              <thead>
                <tr>
                  {{-- <th>No</th> --}}
                  <th>Hari</th>
                  <th>Buka</th>
                  <th>Tutup</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $total = count($jadwal);
                    $hari = 8;
                    $total_jadwal = $hari-$total;
                    // echo $total_jadwal;
                @endphp
                 @foreach ($jadwal as $no=>$item)
                     <tr>
                       {{-- <td>{{$no+1}}</td> --}}
                       <td><input {{date('N') == $item->hari ? 'disabled' :''}} name="jadwal[{{$item->hari}}][hari]" type="hidden" value="{{$item->hari}}">{{$item->hari }} ({{convert_hari_hfis($item->hari)}})</td>
                       <td><input {{date('N') == $item->hari ? 'disabled' :''}} name="jadwal[{{$item->hari}}][buka]" style="width:40%;" class="form-control" value="{{$item->jadwal_start}}"></td>
                       <td><input {{date('N') == $item->hari ? 'disabled' :''}} name="jadwal[{{$item->hari}}][tutup]" style="width:40%;" class="form-control" value="{{$item->jadwal_end}}"></td>
                     </tr>
                 @endforeach
                 @for ($i = 1; $i <= $total_jadwal; $i++)
                  <tr>
                    {{-- <td>{{$no+1}}</td> --}}
                    <td><input {{date('N') == $total+$i ? 'disabled' :''}} name="jadwal[{{$total+$i}}][hari]" type="hidden" value="{{$total+$i}}">{{$total+$i }} ({{convert_hari_hfis($total+$i)}})</td>
                    <td><input {{date('N') == $total+$i ? 'disabled' :''}} name="jadwal[{{$total+$i}}][buka]" style="width:40%;" class="form-control" placeholder="Belum diset"></td>
                    <td><input {{date('N') == $total+$i ? 'disabled' :''}} name="jadwal[{{$total+$i}}][tutup]" style="width:40%;" class="form-control" placeholder="Belum diset"></td>
                  </tr>
                 @endfor
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3">
                    <button  type="submit" class="btn btn-success pull-right" onclick="update()"><i class="fa fa-edit"></i> SIMPAN</button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </form>
          </div>
        </div>
      </div> 

    </div>
      {{-- Loading State --}}
      <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    <div class="box-footer">

    </div>
  </div>
 

@endsection