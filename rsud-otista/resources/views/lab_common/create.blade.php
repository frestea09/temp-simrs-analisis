@extends('master')
@section('header')
  <h1>Input Hasil Lab</h1>
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
    <div class="box box-widget widget-user">
      <div class="widget-user-header bg-aqua-active">
        <div class="row">
          <div class="col-md-2">
            <h4 class="widget-user-username">Nama</h4>
            <h5 class="widget-user-desc">No. RM</h5>
            <h5 class="widget-user-desc">Alamat</h5>
            <h5 class="widget-user-desc">Cara Bayar</h5>
          </div>
          <div class="col-md-7">
            <h4 class="widget-user-username">:{{ $pasien->nama}}</h4>
            <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
            <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
            <h5 class="widget-user-desc">: Umum</h5>
          </div>
          <div class="col-md-3 text-center">
            <h4>Total Tagihan</h4>
            <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Input Hasil Lab</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
      {{-- @if (! session('pj')) --}}
    {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlabCommon/store', 'class' => 'form-horizontal']) !!}
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> 
      <div class="col-md-6">
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {{-- {!! Form::hidden('dokter_id', $reg->dokter_id) !!} --}}
        {!! Form::hidden('reg_id', $reg->id) !!}
        @php
            $poli = Modules\Poli\Entities\Poli::find(43);
            $dokter_all = $dokter;
            $dokter_ids = explode(',', @$poli->dokter_id);
            $dokter = Modules\Pegawai\Entities\Pegawai::whereIn('id', $dokter_ids)->pluck('nama', 'id');
        @endphp
        <div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
            {!! Form::label('penanggungjawab', 'Penanggung Jawab', ['class' => 'col-sm-4 control-label']) !!}
            {{-- session('pj') --}}
            <div class="col-sm-8">
                {!! Form::select('penanggungjawab', $dokter, null, ['class' => 'chosen-select']) !!}
                <small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
            {!! Form::label('pengirim', 'Pengirim', ['class' => 'col-sm-4 control-label']) !!}
            {{-- session('pj') --}}
            <div class="col-sm-8">
                {!! Form::select('dokter_id', $dokter_all, $reg->dokter_id, ['class' => 'chosen-select']) !!}
                <small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jam', 'Jam Pengambilan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jam', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('no_sediaan') ? ' has-error' : '' }}">
          {!! Form::label('no_sediaan', 'No Sediaan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('no_sediaan', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('no_sediaan') }}</small>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group{{ $errors->has('tgl_pemeriksaan') ? ' has-error' : '' }}">
          {!! Form::label('tglpemeriksaan', 'Tgl Pemeriksaan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('tgl_pemeriksaan', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
              <small class="text-danger">{{ $errors->first('tgl_pemeriksaan') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jamkeluar', 'Jam Keluar', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jamkeluar', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('tanggal_keluar_hasil') ? ' has-error' : '' }}">
          {!! Form::label('tanggal_keluar_hasil', 'Tanggal Keluar Hasil', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('tanggal_keluar_hasil', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
              <small class="text-danger">{{ $errors->first('tanggal_keluar_hasil') }}</small>
          </div>
        </div>
      </div>

    {{-- @endif --}}
    
      <div class="col-md-12">
        <div class="box-group" id="accordion">
        @foreach($labsection as $sec)
          <div class="panel box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#{{ preg_replace('/[ ,]+/', '-', trim($sec->nama)) }}">{{ $sec->nama }}</a>
              </h4>
            </div>
            <div id="{{ preg_replace('/[ ,]+/', '-', trim($sec->nama)) }}" class="panel-collapse collapse">
            @foreach (App\Labkategori::where('labsection_id', $sec->id)->get() as $lab_kat)
              <div class="row">
                <div class="col-xs-12">
                  <div class="box">
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-striped table-bordered table-hover table-condensed dataTable no-footer">
                          <tr><th colspan="6">{{ $lab_kat->nama }}</th></tr>
                          <tr>
                            <th width="40px" class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            {{-- <th class="text-center">Hasil</th> --}}
                            <th class="text-center">Hasil Text</th>
                            {{-- <th class="text-center">Standart</th>
                            <th class="text-center">Satuan</th> --}}
                          </tr>
                          @php $no = 1; @endphp
                          @foreach (App\Laboratorium::where('labkategori_id', $lab_kat->id)->get() as $lab)
                          <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $lab->nama }}</td>
                            {{-- <td width="10%">
                              <input name="hasil[{{ $lab->id }}_{{ $lab_kat->id }}_{{ $sec->id }}]" class="form-control" />
                            </td> --}}
                            <td>
                              {{-- <input name="hasiltext[{{ $lab->id }}_{{ $lab_kat->id }}_{{ $sec->id }}]" class="form-control" /> --}}
                              <textarea name="hasiltext[{{ $lab->id }}_{{ $lab_kat->id }}_{{ $sec->id }}]" id="" rows="3" style="resize: vertical;" class="form-control"></textarea>
                            </td>
                            {{-- <td width="100px" class="text-center">{{ $lab->nilairujukanbawah }} - {{ $lab->nilairujukanatas}}</td>
                            <td width="150px" class="text-center">{{ $lab->satuan }}</td> --}}
                          </tr>
                          @endforeach
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            </div>
          </div>
        @endforeach
        </div>
        
          <div class="col-md-12">
            <div class="form-group{{ $errors->has('saran') ? ' has-error' : '' }}">
              {!! Form::label('saran', 'Saran', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('saran', null, ['class' => 'form-control ckeditor', 'style' => 'resize:vertical']) !!}
                  <small class="text-danger">{{ $errors->first('saran') }}</small>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group{{ $errors->has('pesan') ? ' has-error' : '' }}">
              {!! Form::label('pesan', 'Kesimpulan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('pesan', null, ['class' => 'form-control ckeditor', 'style' => 'resize:vertical']) !!}
                  <small class="text-danger">{{ $errors->first('pesan') }}</small>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group{{ $errors->has('kesan') ? ' has-error' : '' }}">
              {!! Form::label('kesan', 'Catatan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('kesan', null, ['class' => 'form-control ckeditor', 'style' => 'resize:vertical']) !!}
                  <small class="text-danger">{{ $errors->first('kesan') }}</small>
              </div>
            </div>
          </div>
          
        
        <button class="btn btn-success btn-flat pull-right" type="submit">Simpan</button>
      </div>
    {!! Form::close() !!}
  </div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Rincian Hasil Lab</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th width="40px" class="text-center">No</th>
            <th class="text-center">Kategori Lab</th>
            <th class="text-center">Nama</th>
            <th width="100px" class="text-center">Pemeriksaan</th>
            <th class="text-center">Waktu</th>
            {{-- <th class="text-center">Hasil</th> --}}
            <th class="text-center">Hasil Text</th>
            {{-- <th class="text-center">Standart</th>
            <th class="text-center">Satuan</th> --}}
            <th class="text-center">Hapus</th>
          </tr>
        </thead>
        <tbody>
      @if(count($hasillabs) > 0)
        @php $no = 1; @endphp
        @foreach($hasillabs as $labs)
        <tr>
          <td colspan="7">
            <b>{{ @$labs->no_lab }}</b> &nbsp;
            <a href="{{ url('pemeriksaanlabCommon/cetak/'.$reg->id.'/'.$labs->id) }}" class="btn btn-info btn-sm btn-flat">Cetak</a>
          </td>
        </tr>
        @php $rincian = App\RincianHasillab::where(['hasillab_id' => $labs->id])->get(); @endphp
        @foreach ($rincian as $item)
          <tr>
            <td class="text-center">{{ $no++ }}</td>
            <td>{{ @$item->labkategori->nama }}</td>
            <td>{{ $item->laboratoria->nama }}</td>
            <td class="text-center">
              @if (!empty($item->hasil))
                @if ($item->hasil <= $item->laboratoria->nilairujukanbawah)
                  <span class="text-danger">L</span>
                @elseif ($item->hasil >= $item->laboratoria->nilairujukanatas)
                  <span class="text-danger">H</span>
                @else
                  <span class="text-success">N</span>
                @endif
              @endif
            </td>
            <td class="text-center">{{ $labs->tgl_hasilselesai }} {{ $labs->jam }}</td>
            {{-- <td class="text-center">{{ $item->hasil }}</td> --}}
            <td class="text-center">{{ $item->hasiltext }}</td>
            {{-- <td class="text-center">{{ $item->laboratoria->rujukan }}</td> --}}
            {{-- <td class="text-center">{{ $item->laboratoria->nilairujukanbawah }} - {{ $item->laboratoria->nilairujukanatas }}</td> --}}
            {{-- <td>{{ $item->laboratoria->satuan }}</td> --}}
            <td class="text-center">
              <a href="{{ url('pemeriksaanlabCommon/hapus/'.$item->id) }}" class="btn btn-danger btn-sm btn-flat">Hapus</a>
            </td>
          </tr>
        @endforeach
        @endforeach
      @endif
        </tbody>
      </table>
    </div>
    {{-- @if(count($hasillabs) > 0)
      <a href="{{ url('pemeriksaanlabCommon/cetakAll/'.$reg->id) }}" target="_blank" class="btn btn-warning btn-flat pull-right">CETAK</a>
    @endif --}}
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
      CKEDITOR.replaceAll( 'ckeditor', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            })

      $('select[name="labsection_id"]').on('change', function() {
          var sec_id = $(this).val();
          if(sec_id) {
              $.ajax({
                  url: '/pemeriksaanlabCommon/getkategori/'+sec_id,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {
                      $('select[name="labkategori_id"]').empty();
                      $('select[name="labkategori_id"]').append('<option value=""></option>');
                      $.each(data, function(key, value) {
                          $('select[name="labkategori_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      });
                  }
              });
          }else{
              $('select[name="labkategori_id"]').empty();
          }
      });

      $('select[name="labkategori_id"]').on('change', function() {
          var cat_id = $(this).val();
          if(cat_id) {
              $.ajax({
                  url: '/pemeriksaanlabCommon/getlab/'+cat_id,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {
                      $('select[name="laboratoria_id"]').empty();
                      // $('select[name="laboratoria_id"]').append('<option value=""></option>');
                      $.each(data, function(key, value) {
                          $('select[name="laboratoria_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      });
                  }
              });
          }else{
              $('select[name="laboratoria_id"]').empty();
          }
      });

    });

  </script>
@endsection
