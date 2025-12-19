@extends('master')

@section('header')
  <h1>Update <small>Logistik Bacth ID di Penjualan Detail</small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
       {!! Form::open(['method' => 'POST', 'url' => 'list-penjualan-salah', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor Faktur</button>
              </span>
              @if (session('session'))
              {!! Form::text('faktur', session('session'), ['class' => 'form-control', 'required' => 'required','placeholder'=>'Input Nomor Faktur Disini']) !!}
              @else
              {!! Form::text('faktur', NULL, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Input Nomor Faktur Disini']) !!}
              @endif
              <small class="text-danger">{{ $errors->first('faktur') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <input type="submit" name="cari" class="btn btn-primary btn-flat" value="Cari">
        </div>
      </div>
      {!! Form::close() !!}
    </div>

    <div class="box-footer">
    </div>
</div>
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Resep</th>
                    <th>Logistik Batch ID yang terinput</th>
                    <th>Logistik Batch ID yang BENAR</th>
                    <th>Master Obat ID yang BENAR</th>
                    <th>Update</th>
                  </tr>
                </thead>
                <tbody>
                    @isset($penjualan)
                        
                    @foreach ($penjualan as $d)
                    {!! Form::model($d, ['route' => ['tools-update-penjualan-detail', $d->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}
  
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td >{{ $d->no_resep }}</td>
                      <td class="text-center">{{ $d->masterobat_id }}</td>
                      <td class="text-center">
                          @if ($d->logistik_batch_id == NULL)
                            <input class="form-control text-center" name="logistik_batch_id" type="text" value="{{ $d->masterobat_id }}">
                          @else
                            {{ $d->logistik_batch_id }}                              
                          @endif
                      </td>
                      <td class="text-center">
                          @if ($d->logistik_batch_id == NULL)
                            <input class="form-control text-center" name="masterobat_id" type="text" value="">
                          @else
                          {{ $d->masterobat_id }} 
                          @endif
                      </td>
                      <td>
                        @if ($d->logistik_batch_id == NULL)
                        <button type="submit" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-save"></i> Update</button>
                        @else
                        <i class="fa fa-icon fa-check"></i>
                        @endif
                          
                      </td>
                    </tr>
                    {!! Form::close() !!}
  
                    @endforeach
                    @endisset
                </tbody>
              </table>
            </div>
          </div>
        </div>
            
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2();

  // $('table').DataTable();

</script>
@endsection
