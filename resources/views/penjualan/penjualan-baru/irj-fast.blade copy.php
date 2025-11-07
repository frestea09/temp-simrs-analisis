@extends('master')
@section('header')
  <h1>Penjualan Rawat Jalan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/jalan-baru-fast', 'class'=>'form-horizontal']) !!}
        <div class="row">
          {!! Form::hidden('unit', $unit) !!}
           <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div> 
           <div class="col-md-4">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div> 
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('poli') ? ' has-error' : '' }}" type="button">Poli</button>
                </span>
                {{-- {!! Form::text('poli', null, ['autocomplete'=>'off','class' => 'form-control', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('poli') }}</small> --}}
                @php
                    $poli = Modules\Poli\Entities\Poli::all();
                @endphp
                <select name="poli" id="" onchange="this.form.submit()" class="select2">
                  <option value="">-- SEMUA --</option>
                  @foreach ($poli as $item)
                    <option value="{{ $item->id }}" {{$polis == $item->id ? 'selected' :''}}>{{ baca_poli($item->id) }}</option>
                  @endforeach
                
                </select>
            </div>
            <br>
          </div> 
           
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
           <thead>
             <tr>
               <th>No</th>
               <th>Nama</th>
               {{-- <th>Histori</th> --}}
               <th>RM</th>
               {{-- <th>RM Lama</th> --}}
               <th>Poli</th>
               <th>Jenis</th>
               {{-- <th>Alamat</th> --}}
               <th>Tgl Registrasi</th>
               <th>Proses</th>
                {{--@endif--}}
             </tr>
           </thead>
           <tbody>
               @foreach ($data as $key => $d)
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ strtoupper($d->nama) }}</td>
                     {{-- <td>
                       @foreach (\App\HistorikunjunganIRJ::where('registrasi_id', $d->registrasi_id)->where('created_at', 'like', date('Y-m-d') . '%')->get(); as $i)
                           <p>-{{ baca_poli($i->poli_id) }}</p>
                       @endforeach
                     </td> --}}
                     <td>{{ $d->no_rm }}</td>
                     {{-- <td>{{ $d->no_rm_lama }}</td> --}}
                     <td>{{ strtoupper(baca_poli($d->poli_id)) }}</td>
                     <td>{{ baca_carabayar($d->bayar) }}</td>
                     {{-- <td>{{ strtoupper($d->alamat) }}</td> --}}
                     <td>{{ tanggal_eklaim($d->tgl_regisrasi) }}</td>
                     <td>
                      <a href="{{ url('penjualan/form-penjualan-baru/'.$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                     </td>
                    </tr>
                  @endforeach
             </tbody>
         </table>
       </div>
     @endif
    </div>
  </div>
  

@endsection

@section('script')
  <script type="text/javascript">
    $('.select2').select2();
    $('#masterNorm').select2({
        placeholder: "Pilih No Rm...",
        ajax: {
            url: '/pasien/master-pasien/',
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
