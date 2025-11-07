@extends('master')
@section('header')
  <h1>Laboratory Information System (LIS) <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pasien</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Dokter</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $reg->pasien->no_rm }}</td>
                <td>{{ $reg->pasien->nama }}</td>
                <td>{{ $reg->pasien->alamat }}</td>
                <td>{{ baca_dokter($reg->dokter_id) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Input LIS</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save_lis', 'class' => 'form-horizontal']) !!}
      {!! Form::hidden('registrasi_id', $reg->id) !!}
      {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
      {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
      {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
      {!! Form::hidden('page', 'labJalan') !!}
      <div class="row">
        <div class="col-md-7">
          <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
            {!! Form::label('pelaksana', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('pelaksana', $pelaksana, session('pelaksana'), ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
            </div>
          </div>
         
          <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
            

            {!! Form::label('Note', 'Note', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                {!! Form::text('note','', ['class' => 'form-control','autocomplete'=>'off']) !!}
              </div>
          </div>

          <div class="form-group">
            {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
              {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {{-- {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!} --}}
                  {!! Form::text('tanggal',date("d-m-Y"), ['class' => 'form-control datepicker','autocomplete'=>'off']) !!}
                  <small class="text-danger">{{ $errors->first('jumlah') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
              {!! Form::label('poli_id', 'Pelayanan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  <select class="chosen-select" name="poli_id">
                    @foreach ($opt_poli as $key => $d)
                      @if ($d->id == $jenis->poli_id)
                        <option value="{{ $d->id }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                      @endif

                    @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('poli_id') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
            {!! Form::label('perawat', 'Ruangan', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('perawat', $poli, $reg->poli_id, ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                <small class="text-danger">{{ $errors->first('perawat') }}</small>
            </div>
          </div>
         
        </div>

        <div class="col-md-12">
          <h4>Input Test</h4>
          <table style="width: 100%" class="daftar_obat_2 table table-striped table-bordered table-hover table-condensed form-box"
            style="font-size:12px;">
            <tr>
              <th  class="text-center" style="width:50px;"><b>No</b></th>
              <th class="text-center" style="width:250px;"><b>Id</b></th>
              <th class="text-center" style="width:250px;"><b>Id Test</b></th>
              <th class="text-center" style="width:250px;"><b>Test</b></th>
              <th class="text-center" style="width:120px;"><b>Cito</b></th>
              
            </tr>
            @for ($i=0;$i <= 2; $i++) 
              <tr>
                <td class="text-center">{{$i+1}}</td>
                <td class="text-center"><input type="text" class="form-control" name="test[{{$i}}][id]"></td>
                <td class="text-center"><input type="text" class="form-control" name="test[{{$i}}][id_test]"></td>
                <td class="text-center"><input type="text" class="form-control" name="test[{{$i}}][test]"></td>
                <td class="text-center"><input type="text" class="form-control" name="test[{{$i}}][cito]"></td>
              </tr>
            @endfor
            <tfoot>
              <tr>
                <td colspan="7" class="text-right">
                  <button type="button" class="add_daftar_2">Tambah Kolom</button>
                  {{-- <button type="button" class="remove_field_button">Kurangi Kolom</button> --}}
                </td>
              </tr>
            </tfoot>
          </table>
        </div> 
      </div>
      <div class="form-group">
        {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat pull-right', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
          <a href="{{ url('tindakan') }}" class="btn btn-warning btn-flat pull-right" style="margin-right:20px;">Kembali</a>
            
        </div>
    </div>
      
      {!! Form::close() !!}
    </div>
  </div>
@endsection

<style>
  .select2-selection__rendered{
    padding-left: 20px !important;
  }
</style>

@section('script')
  <script type="text/javascript">
    $('.select2').select2();
  </script>
    <script>
      $(document).ready(function() {
          // Select2 Multiple
          $('.select2-multiple').select2({
              placeholder: "Pilih Multi Tindakan",
              allowClear: true
          });
          var max_fields      = 25;
          var wrapper         = $(".input_fields_wrap"); 
          var add_button      = $(".add_field_button");
          var remove_button   = $(".remove_field_button");
          var i = 2;


           // row 3
           $(".add_daftar_2").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(i < max_fields){
                  i++;
                  $('.daftar_obat_2').append( '<tr>'+
                  '<td class="text-center">'+(i+1)+'</td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][dosis]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][frekuensi]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][cara]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][cara]"></td>'+
                  '<td class="text-center"><a href="#" class="remove_field_obat_2 btn btn-xs btn-danger">X</a></td>'+
                '</tr>');
                  // $(wrapper).find(".datepicker").datepicker({autoclose: true,format: "dd-mm-yyyy"})
              }
          });
          $(".daftar_obat_2").on("click",".remove_field_obat_2", function(e){ //user click on remove text
              console.log($(this));
              e.preventDefault(); $(this).closest("tr").remove(); i--;
            })
      });
</script>
@endsection