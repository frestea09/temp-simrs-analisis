@extends('master')

@section('header')
  <h1>EMR OPERASI</h1>
@endsection

@section('style')
  <style>
    .dataTables_filter {
      text-align: left !important;
    }
  </style>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Rencana Operasi&nbsp;
        </h4>
      </div>
      <div class="box-body">
         {!! Form::open(['method' => 'POST', 'url' => 'operasi/emr/'.$unit, 'class'=>'form-hosizontal']) !!}
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

        <div class="row">
          
          <div class="col-md-12">
            <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed' id="data">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No. RM</th>
                      <th>Nama</th>
                      <th>Poli / Ruangan</th>
                      <th>Rencana Operasi</th>
                      <th style="text-align: center">EMR</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($emr->count() < 1)
                      <tr>
                        <td colspan="8">Tidak ada pasien operasi</td>
                      </tr>
                    @else
                      @foreach ($emr as $key => $d)
                        <tr>
                          <td class="text-center">{{ $no++ }}</td>
                          <td class="text-center">{{ @$d->registrasi->pasien->no_rm }}</td>
                          <td>{{ @$d->registrasi->pasien->nama }}</td>
                          <td>
                            @if (@$d->registrasi->rawat_inap)
                              {{ !empty(@$d->registrasi->rawat_inap->kamar_id) ? baca_kamar(@$d->registrasi->rawat_inap->kamar_id) : NULL }}
                            @else
                              {{ baca_poli(@$d->registrasi->poli_id) }}
                            @endif
                          </td>
                          <td>{{ date('d-m-Y', strtotime(@$d->rencana_operasi)) }}</td>
                          <td class="text-center">
                              @if (cek_status_reg(@$d->registrasi->status_reg) == "I")
                                <a href="{{url('emr-soap/operasi/main/inap/' . $d->registrasi->id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-book"></i></a>
                              @elseif (cek_status_reg(@$d->registrasi->status_reg) == "J")
                                  <a href="{{url('emr-soap/operasi/main/jalan/' . $d->registrasi->id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-book"></i></a>
                              @elseif (cek_status_reg(@$d->registrasi->status_reg) == "G")
                                <a href="{{url('emr-soap/operasi/main/igd/' . $d->registrasi->id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-book"></i></a>
                              @endif
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
          </div>
        </div>
        
      </div>
    </div> 
@endsection

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
@endsection