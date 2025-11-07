@extends('master')
@section('header')
  <h1>Input Diagnosa Rawat Jalan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/input_diagnosa_rawatjalan', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', date('d-m-Y'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        {{-- <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">No.RM</button>
            </span>
              {!! Form::text('no_rm', null, ['class' => 'form-control', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()','placeholder'=>'Ketik RM kemudian ENTER']) !!}
          </div>
        </div> --}}
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai</button>
            </span>
              {!! Form::text('tgb', date('d-m-Y'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Cara Bayar</button>
            </span>
            <select name="cara_bayar" class="form-control select2" onchange="this.form.submit()">
              <option value="0" {{ ($crb == 0) ? 'selected' : '' }}>Semua</option>
              @foreach ($carabayar as $c)
                <option value="{{ $c->id }}" {{ ($crb == $c->id) ? 'selected' : '' }}>{{ $c->carabayar }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-4">
          {{-- <div class="input-group"> --}}
            {{-- <span class="input-group-btn"> --}}
              {{-- <select name="poli_id" class="form-control chosen-select" id="" onchange="this.form.submit()">
                <option value="">SEMUA POLI</option>
                @foreach ($poli as $item)
                  <option value="{{$item->id}}" {{$item->id == @$poli_id ? 'selected' :''}}>{{$item->nama}}</option>
                @endforeach
              </select> --}}
            {{-- </span> --}}
              {{-- {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!} --}}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <i><span style="color:red">*</span> Nama yang berwarna hijau artinya sudah diinput diagnosa</i>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>No RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Cara Bayar</th>
              <th>Tanggal Registrasi</th>
          
              <th>Poli</th>
              <th>Umur</th>
              <th>Dokter</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
                <tr>
                  <td>{{ @$no++ }}</td>
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>
                    @php
                        $icd10 = App\PerawatanIcd10::where('registrasi_id',$d->id)->first();
                        // dd($icd10);
                        $icd9 = App\PerawatanIcd9::where('registrasi_id',$d->id)->first();
                    @endphp
                    @if ($icd10 || $icd9)
                    <span style="color:green"><b>{{ @$d->pasien->nama }}</b></span>
                    @else
                    {{ @$d->pasien->nama }}
                    @endif
                  </td>
                  <td>{{ @$d->pasien->alamat }}</td>
                  <td>{{ baca_carabayar($d->bayar) }} {{@$d->tipe_jkn}}</td>
                  <td>{{ @$d->created_at }}</td>
                
                  <td>{{ @$d->poli->nama }}</td>
                  <td>{{ hitung_umur(@$d->pasien->tgllahir) }}</td>
                  <td>{{ @$d->dokter_umum->nama }}</td>
                  <td>
                    @if (substr($d->status_reg, 0, 1) == 'J')
                    <a href="{{ url('frontoffice/form_input_diagnosa_rawatjalan/'.@$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
                    @else
                    <a href="{{ url('frontoffice/form_input_diagnosa_igd/'.@$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
                    @endif
                  </td>
                </tr>
           
            @endforeach

          </tbody>
        </table>
        
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
