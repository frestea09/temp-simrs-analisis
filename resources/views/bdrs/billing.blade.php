@extends('master')

@section('header')
  <h1>
      BDRS - Billing
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3> --}}
      </div>
      <div class="box-body">
        <div class="box box-info">
          <div class="box-body">
            
            {!! Form::open(['method' => 'POST', 'url' => 'bdrs/simpan-transaksi', 'class' => 'form-horizontal', 'id' => 'form-tindakan']) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="form-group{{ $errors->has('no_sample') ? ' has-error' : '' }}">
                  {!! Form::label('no_sample', 'No Sample', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('no_sample', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_sample') }}</small>
                  </div>
                </div>

                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                  {!! Form::label('tarif_id', 'Tindakan*', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
  
                     <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple">
                       
                     </select>
                      <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                  </div>
                </div>

                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                  {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control" name="dokter_id">
                        @foreach($dokter_poli as $d)
                          <option value="{{ $d }}"> {{ baca_dokter($d) }}</option>
                        @endforeach             
                     </select>
  
                     <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                  </div>
              </div>
  
              <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                {!! Form::label('pelaksana', 'Pelaksana LAB', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" name="pelaksana_lab">
                      @foreach($perawat_poli as $d)
                        <option value="{{ $d }}"> {{ baca_pegawai($d) }}</option>
                      @endforeach             
                   </select>

                   <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                </div>
              </div>
              </div>

              <div class="col-md-5">
                <div class="form-group{{ $errors->has('cara_bayar') ? ' has-error' : '' }}">
                  {!! Form::label('cara_bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control select2" name="cara_bayar">
                        @foreach($cara_bayar as $b)
                          <option value="{{ $b->id }}"> {{ $b->carabayar }}</option>
                        @endforeach             
                     </select>
  
                     <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                  {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    {!! Form::date('tanggal', null, ['class' => 'form-control']) !!}
                     <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                  </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                    </div>
                </div>
              </div>
            </div>

            {!! Form::close() !!}
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>No Sample</th>
                <th>Tindakan</th>
                <th>Total</th>
                <th>Dokter</th>
                <th>Pelaksana Lab</th>
                <th>Cara Bayar</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($bdrs as $item)
                <tr>
                  <td rowspan="{{$item->detail->count() == 0 ? 1 : $item->detail->count()}}">{{$loop->iteration}}</td>
                  <td rowspan="{{$item->detail->count() == 0 ? 1 : $item->detail->count()}}">{{$item->no_sample}}</td>
                  <td>{{ @$item->detail->first()->namatarif ?? '&nbsp;' }}</td>
                  <td>{{ @$item->detail->first()->total ?? '&nbsp;' }}</td>
                  <td>{{ @baca_dokter($item->detail->first()->dokter_id) }}</td>
                  <td>{{ @baca_pegawai($item->detail->first()->pelaksana_lab_id) ?? '&nbsp;' }}</td>
                  <td>{{ @baca_carabayar($item->detail->first()->cara_bayar_id) ?? '&nbsp;' }}</td>
                  <td>{{ @baca_user($item->detail->first()->user_id) ?? '&nbsp;' }}</td>
                  <td>{{ @date('d-m-Y', strtotime($item->detail->first()->created_at)) ?? '&nbsp;' }}</td>
                  <td rowspan="{{$item->detail->count() == 0 ? 1 : $item->detail->count()}}">
                    <a href="{{url('/bdrs/rb/'.$item->id)}}" target="_blank" class="btn btn-info btn-flat btn-xs">Rincian Biaya</a>
                    <a href="{{url('/bdrs/delete/'.$item->id)}}" class="btn btn-flat btn-danger btn-xs">Hapus</a>
                  </td>
                </tr>
                @foreach ($item->detail->slice(1) as $detail)
                    <tr>
                        <td>{{ @$detail->namatarif ?? '&nbsp;' }}</td>
                        <td>{{ @$detail->total ?? '&nbsp;' }}</td>
                        <td>{{ @baca_dokter($detail->dokter_id) ?? '&nbsp;' }}</td>
                        <td>{{ @baca_pegawai($detail->pelaksana_lab_id) ?? '&nbsp;' }}</td>
                        <td>{{ @baca_carabayar($detail->cara_bayar_id) ?? '&nbsp;' }}</td>
                        <td>{{ @baca_user($detail->user_id) ?? '&nbsp;' }}</td>
                        <td>{{ @date('d-m-Y', strtotime($detail->created_at)) ?? '&nbsp;' }}</td>
                    </tr>
                @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
  $('.select2').select2();

    function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
  
  $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan-lab/TA',
          dataType: 'json',
          data: function (params) {
              return {
                  j: 1,
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

  $(document).ready(function() {
          // Select2 Multiple
          $('.select2-multiple').select2({
              placeholder: "Pilih Multi Tindakan",
              allowClear: true
          });

      });
</script>
@endsection