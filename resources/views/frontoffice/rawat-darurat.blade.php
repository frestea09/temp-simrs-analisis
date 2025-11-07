@extends('master')
@section('header')
  <h1>Pendaftaran - Gawat Darurat </h1>
@endsection

@php
    Session::forget('blm_terdata');
@endphp

@section('content')
  <div class="row">
    @php
      $tga = request('tga');
      $tgb = request('tgb');

      
      $triage = App\EmrInapPemeriksaan::where('registrasi_id', 0)
      ->where('pasien_id', 0)
      ->where('type', 'triage-igd')
      ->where('created_at', '>=', Carbon\Carbon::now()->subDay()->toDateTimeString());
      
      if(isset($tga) && isset($tgb)){
        $triage = $triage->whereBetween('created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59']);
      }

      $triage = $triage->get();
    @endphp
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
          {!! Form::open(['method' => 'GET', 'url' => '/frontoffice/rawat-darurat', 'class' => 'form-hosizontal']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Dari</button>
                        </span>
                        {!! Form::text('tga', "", [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai</button>
                        </span>
                        {!! Form::text('tgb', "", [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            
          <table class="table table-condensed table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th colspan="4" class="text-center">List Triage</th>
              </tr>
              <tr>
                <th>Nama</th>
                <th>Triage</th>
                <th>Tanggal Pengisian</th>
                <th>Pratinjau</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($triage as $tria)
                @php
                  $fisik = json_decode(@$tria->fisik, true);
                @endphp
                <tr>
                  <td>{{ @$fisik['namaPasien'] }}</td>
                  @if (@$fisik['triage']['kesimpulan'] == 'Emergency ATS I')
                    <td style="background-color: rgb(255, 106, 106);">{{ @$fisik['triage']['kesimpulan'] }}</td>
                  @elseif(@$fisik['triage']['kesimpulan'] == 'Urgent ATS II & III')
                    <td style="background-color: rgb(255, 238, 110);">{{ @$fisik['triage']['kesimpulan'] }}</td>
                  @elseif(@$fisik['triage']['kesimpulan'] == 'Non Urgent ATS IV & V')
                    <td style="background-color: rgb(166, 255, 110);">{{ @$fisik['triage']['kesimpulan'] }}</td>
                  @else
                    <td style="background-color: rgb(169, 169, 169);">{{ @$fisik['triage']['kesimpulan'] }}</td>
                  @endif
                  <td>{{ $tria->created_at }}</td>
                  <td>
                    <a href="{{ url('/emr-soap/pemeriksaan/triage-igd-awal/'.$tria->id) }}" target="_blank" class="btn btn-info btn-sm">
                      <span class="fa fa-eye"></span>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="box box-primary" style="border: 1.5px solid #0275d8 !important;">
        <div class="box-header with-border">
        <h3 class="box-title">Data Pasien Baru</h3>
        </div>
        <div class="box-body">
          <b>Pasien Baru: </b>
          <a href="{{ url('/registrasi/igd/jkn') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
          <a href="{{ url('/registrasi/igd/umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a>
          <p style="margin-top:15px"><small class="text-primary">*Pasien Baru adalah Pasien yang belum pernah berobat dan baru mengunjungi RS pertama kali.</small></p>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="box box-primary" style="border: 1.5px solid #D9534F !important;">
        <div class="box-header with-border">
          <h3 class="box-title">Data Pasien Belum Terdata</h3>
        </div>
        <div class="box-body">
          <b>PASIEN BLM TERDATA: </b>
          <a href="{{ url('/registrasi/igd/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
          <a href="{{ url('/registrasi/igd/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a>
          <p style="margin-top:15px"><small class="text-danger">*Pasien Belum Terdata adalah Pasien yang secara berkas sudah pernah tercatat di Rekam Medis namun belum terinput di Database SIMRS.</small></p>
        </div>
      </div>
    </div>
  </div>


  <div class="box box-primary">
    <form action="" id="filterData">
      <div class="row">
        <div class="col-md-2">
          <div class="input-group">
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama">
          </div>
        </div>
  
        <div class="col-md-2">
          <div class="input-group">
            <input type="text" class="form-control" name="no_rm" id="no_rm" placeholder="Masukan No RM">
          </div>
        </div>
  
        <div class="col-md-2">
          <div class="input-group">
            <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tgl Lahir">
          </div>
        </div>
  
        <div class="col-md-2">
          <div class="input-group">
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
          </div>
        </div>
  
        <div class="col-md-2">
          <div class="input-group">
            <input type="submit" name="submit" class="btn btn-primary btn-flat" value="Cari" id="filter">
          </div>
        </div>
  
  
      </div>
    </form>
  </div>



  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      
      {{-- <div class="col-md-5">
        <div class="form-group text-center">
          <input type="submit" name="submit" class="btn btn-primary btn-flat" value="Cari">
        </div>
      </div> --}}



      {{-- {!! Form::open(['method' => 'POST', 'url' => 'pasien/search-pasien-igd-filter/', 'class'=>'form-horizontal']) !!}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-7">
					<div class="form-group">
						<label for="tga" class="col-md-3 control-label">Periode</label>
						<div class="col-md-4">
              <input type="text" class="form-control">
							<small class="text-danger">{{ $errors->first('tga') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group text-center">
						<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
					</div>
				</div>
			</div>
		{!! Form::close() !!} --}}




    <div class="table-responsive" style="margin-top: -30px;">
      <table class="table-pasien table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>No. RM Baru</th>
            {{-- <th>No. RM Lama</th> --}}
            <th>Ibu Kandung</th>
            <th>Alamat</th>
            <th>Tgl.Lahir</th>
            <th>NIK</th>
            <th>No. JKN</th>
            <th>JKN</th>
            <th>NON JKN</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    {{--<b>PASIEN BLM TERDATA: </b>
    <a href="{{ url('/registrasi/igd/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
    <a href="{{ url('/registrasi/igd/umum-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a>--}}
        @if (!empty(session('no_sep')))
          <script type="text/javascript">
            window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=600,height=300)
          </script>
        @endif

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

@section('script')
  
<script type="text/javascript">
console.log(window.location.origin)
          
   

    // // let data = $('#filterData').serialize();

    // function filter() {
   

    // } 

    $('#filter').click(function(e){
      e.preventDefault();
      let nama = $('#nama').val();
      let no_rm = $('#no_rm').val();
      let tgl_lahir = $('#tgl_lahir').val();
      let alamat = $('#alamat').val();

      $('.table-pasien').DataTable({
      'language': {
          "url": "/json/pasien.datatable-language.json",
      },
      pageLength  : 5,
      paging      : true,
      lengthChange: false,
      searching   : true,
      ordering    : false,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax:{
        'type' : 'POST',
        'url'  : '/pasien/search-pasien-igd-filter',
        'data' : {
          nama: nama,
          no_rm: no_rm,
          tgl_lahir: tgl_lahir,
          alamat:alamat
        },
        'beforeSend': function (request) {
             request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
        }
      },
      columns: [
          {data: 'nama'},
          {data: 'no_rm'},
          {data: 'ibu_kandung'},
          {data: 'alamat'},
          {data: 'tgllahir'},
          {data: 'nik'},
          {data: 'no_jkn'},
          {data: 'jkn', searchable: false, sClass: 'text-center'},
          {data: 'non-jkn', searchable: false, sClass: 'text-center'}
       ]
      });
    })

     $('.table-pasien').DataTable({
      'language': {
          "url": "/json/pasien.datatable-language.json",
      },
      pageLength  : 5,
      paging      : true,
      lengthChange: false,
      searching   : true,
      ordering    : false,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax:{
        'url' : window.location.origin+'/pasien/search-pasien-igd/',
        'beforeSend': function (request) {
             request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
        }
      },
      columns: [
          {data: 'nama'},
          {data: 'no_rm'},
          // {data: 'no_rm_lama'},
          {data: 'ibu_kandung'},
          {data: 'alamat'},
          {data: 'tgllahir'},
          {data: 'nik'},
          {data: 'no_jkn'},
          {data: 'jkn', searchable: false, sClass: 'text-center'},
          {data: 'non-jkn', searchable: false, sClass: 'text-center'}
      ]
    });

</script>
@endsection
