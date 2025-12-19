@extends('master')
@section('header')
  <h1>Dashboard - Log User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      
      <form method="POST" action="{{ url('/frontoffice/log-user') }}" class="form-horizontal" id="filterGudang">
      {{ csrf_field() }}
        <div class="row">
            {{-- {{@$user}} --}}
            <div clas="col-md-12">
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::label('tgla', 'Tanggal', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('tgla', @$tglAwal ? @$tglAwal : date('d-m-Y'), ['class' => 'form-control datepicker','autocomplete'=>'off','placeholder'=>'Dari','required'=>true]) !!}
                            <small class="text-danger">{{ $errors->first('tgla') }}</small>
                        </div> 
                        <div class="col-sm-5">
                            {!! Form::text('tglb', @$tglAkhir, ['class' => 'form-control datepicker','autocomplete'=>'off','placeholder'=>'Sampai','required'=>true]) !!}
                            <small class="text-danger">{{ $errors->first('tglb') }}</small>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                            <select name="user" class="form-control select2">
                            <option value="">[Semua User]</option>
                            <option {{@$user == 'dokter' ? 'selected' :''}} value="dokter">Dokter</option>
                            <option {{@$user == 'perawat' ? 'selected' :''}} value="perawat">Perawat</option>
                            </select>
                    </div>   
                </div>
                {{-- <div class="col-md-2">
                    <div class="form-group">
                            <select name="user_id" class="form-control select2">
                            <option value="" selected>[Semua User]</option>
                            <option value="dokter">Dokter</option>
                            <option value="dokter">Perawat</option>
                            </select>
                    </div>   
                </div> --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" name="tampil" class="btn btn-primary btn-flat fa-file-pdf" value="TAMPILKAN">
                            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                            {{-- <input type="submit" name="pdf" target="_blank" class="btn btn-warning btn-flat fa-file-pdf" value="PDF"> --}}
                            {{-- <a href="/frontoffice/time" class="btn btn-default btn-flat fa-file-pdf" > REFRESH </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
        <hr/>

        @if (isset($respon) && !empty($respon))
        <b>Periode : Tgl {{ $tgl1 }}   s/d  {{ $tgl2 }}</b>
        @endif
        <br/><br/>
        <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
                    <tr>
                        <th width="40px" class="text-center">No</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">CPPT</th>
                        <th class="text-center">ASESMEN</th>
                        <th class="text-center">BILLING</th>
                        <th class="text-center">E-RESEP</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($log) && !empty($log))

                    @foreach ($log as $no => $d)
                    @php
                        $cppt = \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','cppt')->count();
                        $asesmen = \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','asesmen')->count();
                        $billing = \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','billing')->count();
                        $eresep = \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','eresep')->count();
                    @endphp
                      <tr>
                        <td>{{$no+1}}</td>
                        <td>{{baca_user($d->user_id)}}</td>
                        <td>{{date('d-m-Y',strtotime($d->tanggal))}}</td>
                        <td class="text-center">{!!$cppt > 0 ? '<i class="fa fa-check" aria-hidden="true"></i> ('.$cppt.')' :''!!} </td>
                        <td class="text-center">{!!$asesmen > 0 ? '<i class="fa fa-check" aria-hidden="true"></i> ('.$asesmen.')' :''!!}</td>
                        <td class="text-center">{!!$billing > 0 ? '<i class="fa fa-check" aria-hidden="true"></i> ('.$billing.')' :''!!}</td>
                        <td class="text-center">{!!$eresep > 0 ? '<i class="fa fa-check" aria-hidden="true"></i> ('.$eresep.')' :''!!}</td>
                      </tr>
                    @endforeach

                    @endif 
                </tbody>
            </table>
        </div>
    </div>
      {{--  @include('frontoffice.ajax_lap_pengunjung')  --}}
  </div>
@endsection

@section('script')
  <script>
    $('.select2').select2()
  </script>
@endsection
