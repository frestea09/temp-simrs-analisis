@extends('master')
@section('header')
  <h1>Eresep Belum Diproses</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'farmasi/proses-ulang-eresep-by-tgl', 'class'=>'form-horizontal']) !!}
        <div class="row">
          {{-- {!! Form::hidden('unit', $unit) !!} --}}
           <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Resep Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div> 
           <div class="col-md-6">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div> 
          {{-- <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">No RM</button>
              </span>
                <select name="no_rm" id="masterNorm" class="form-control" onchange="this.form.submit()"></select>
            </div>
          </div> --}}
        </div>
      {!! Form::close() !!}

     @if ($resep_note)
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
           <thead>
             <tr>
               <th>No</th>
               <th>No.Eresep</th> 
               <th>Pasien</th> 
               <th>Poli</th> 
               <th>Dokter</th> 
               <th>Tgl Input</th>
               <th>Proses</th>
               <th>Proses Baru</th>
             </tr>
           </thead> 
           <tbody>
            @foreach ($resep_note as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->uuid}}</td>
                <td>{{@$item->registrasi->pasien->nama}}</td>
                <td>{{@$item->registrasi->poli->nama}}</td>
                <td>{{@baca_dokter($item->registrasi->dokter_id)}}</td>
                <td>{{date('d-m-Y, H:i',strtotime($item->created_at))}}</td>
                <td><a target="_blank" class="btn btn-success btn-md" href="{{url('/penjualan/form-penjualan-baru-eresep/'.@$item->registrasi->pasien->id.'/'.@$item->registrasi->id.'/'.$item->id)}}">Proses</a></td>
                <td><a target="_blank" class="btn btn-danger btn-md" href="{{url('/penjualannew/form-penjualan-baru-eresep/'.@$item->registrasi->pasien->id.'/'.@$item->registrasi->id.'/'.$item->id)}}">Proses</a></td>
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
       


  </script>
@endsection
