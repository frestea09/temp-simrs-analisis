@extends('master')

@section('header')
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Kamar Aplicares &nbsp;

      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'aplicare-bpjs/store', 'class' => 'form-horizontal']) !!}

      <div class="form-group{{ $errors->has('kelompok_id') ? ' has-error' : '' }}">
          {!! Form::label('kelompok_id', 'Nama Kelompok Kamar', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
            {{-- {!! Form::select('kelompok_id', $kelompokKamar, null, ['class' => 'form-control select2', 'style' => 'width: 100%;']) !!} --}}
            <select name="kelompok_id" id="" class="form-control select2" style="width: 100%;" required>
              @foreach($kelompokKamar as $k)
                <option value="{{ $k->id }}">{{ $k->kelompok. ' | Jumlah Bed : ' .$k->bed->count() }}</option>
              @endforeach
            </select>
              <small class="text-danger">{{ $errors->first('kelompok_id') }}</small>
          </div>
      </div>
      <div class="pull-right">
        <small class="text-danger">*Pastikan Kamar yang ditambah memang belom dikirim ke Aplicares BPJS (Agar Tidak Terjadi Duplikat)</small>
      </div>
      <br>



      <div class="btn-group pull-right">
          <a href="{{ route('kamar') }}" class="btn btn-warning btn-flat">Batal</a>
          {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
      </div>
      

        {!! Form::close() !!}
      </div>
    </div>
@endsection
@section('script')
    <script>
      $('.select2').select2();
    </script>
@endsection
