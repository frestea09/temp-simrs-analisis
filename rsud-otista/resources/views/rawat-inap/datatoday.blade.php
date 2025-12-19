@extends('master')

@section('header')
  <h1>Pendaftaran Rawat Inap Hari INI</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">

      </h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'list-rawat-inap-hari-ini', 'class'=>'form-horizontal']) !!}
      <input type="hidden" name="jenis_reg" value="I2">
      <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
            </div>
          </div> 
      </div>
      
      {!! Form::close() !!}

        <table class="table table-bordered table-condensed" id="data">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>No RM</th>
                    <th>Ruangan</th>
                    <th>Kelas</th>
                    <th>Tanggal Masuk</th>
                    <th>Del</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inap as $d)
                  <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ ($d->nama) }}</td>
                      <td>{{ $d->no_rm }}</td>
                      <td>{{ baca_kamar($d->kamar_id) }}</td>
                      <td>{{ baca_kelas($d->kelas_id) }}</td>
                      <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                      <td>
                        <button class="btn btn-danger btn-sm btn-flat" onclick="hapus({{ $d->rawatinap_id }})"><i class="fa fa-trash-o"></i></button>
                      </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  function hapus(id){
      if(confirm('Yakin Data Rawat Inap ini akan Di Hapus? ')){
        $.ajax({
          url: '/list-rawat-inap-hari-ini-hapus/'+id,
          type: 'GET',
          dataType: 'json',
          
        })
        .done(function(data) {
          if(data.sukses == true){
            location.reload();
          }
          if(data.sukses == false){
            alert('Data tidak bisa di hapus karena sudah ada tindakan di rawat inap');
          }
        });
      }
  }
</script>
@endsection
