@extends('master')
@section('header')
  <h1>Cetak Eresep</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <h4 class="text-center">Antrian E-Resep Hari Ini</h4>
      {{-- {!! Form::open(['method' => 'POST', 'url' => 'farmasi/eresep-cetak-by-tgl', 'class'=>'form-horizontal']) !!}
        <div class="row"> --}}
          {{-- {!! Form::hidden('unit', $unit) !!} --}}
           {{-- <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Resep Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div>  --}}
           {{-- <div class="col-md-6">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div>  --}}
          {{-- <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">No RM</button>
              </span>
                <select name="no_rm" id="masterNorm" class="form-control" onchange="this.form.submit()"></select>
            </div>
          </div> --}}
        {{-- </div>
      {!! Form::close() !!} --}}

      <div class='table-responsive col-md-6'>
        <h4>Antrian Belum Dipanggil</h4>
         <table class='table table-striped table-bordered table-hover table-condensed' id='tableAntrianResep'>
           <thead>
             <tr>
               <th>Panggil</th>
               <th>Antrian</th>
               <th>No.Eresep</th> 
               <th>RM</th> 
               <th>Pasien</th> 
               <th>Poli</th> 
               {{-- <th>Dokter</th>  --}}
               {{-- <th>Tgl Input</th> --}}
               <th>Cetak</th>
             </tr>
           </thead> 
           <tbody>

           </tbody>
         </table>
      </div>

      <div class='table-responsive col-md-6'>
        <h4>Antrian Sudah Dipanggil</h4>
         <table class='table table-striped table-bordered table-hover table-condensed' id='tableSudahDipanggilResep'>
           <thead>
             <tr>
               <th>Panggil</th>
               <th>Antrian</th>
               <th>No.Eresep</th> 
               <th>RM</th> 
               <th>Pasien</th> 
               <th>Poli</th> 
               {{-- <th>Dokter</th>  --}}
               {{-- <th>Tgl Input</th> --}}
               <th>Cetak</th>
             </tr>
           </thead> 
           <tbody>

           </tbody>
         </table>
      </div>
    </div>
  </div>
 

   

@endsection

@section('script')
  <script type="text/javascript">
    $(".skin-blue").addClass("sidebar-collapse");

    $(function() {
      $('#tableAntrianResep').DataTable({
          "language": {
              "url": "/json/pasien.datatable-language.json",
          },
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
          ordering: false,
          ajax: '/farmasi/get-eresep-cetak-belum-panggil',
          columns: [
            // {data: 'rownum', orderable: false, searchable: false},
              {data: 'panggil', orderable: false, searchable: false},
              {data: 'antrian', orderable: false, searchable: false},
              {data: 'uuid', orderable: false, searchable: false},
              {data: 'registrasi.pasien.no_rm', orderable: false},
              {data: 'registrasi.pasien.nama', orderable: false},
              {data: 'registrasi.poli.nama', orderable: false},
              {data: 'cetak', orderable: false, searchable: false},
          ]
      });
      $('#tableSudahDipanggilResep').DataTable({
          "language": {
              "url": "/json/pasien.datatable-language.json",
          },
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
          ordering: false,
          ajax: '/farmasi/get-eresep-cetak-sudah-panggil',
          columns: [
            // {data: 'rownum', orderable: false, searchable: false},
              {data: 'panggil', orderable: false, searchable: false},
              {data: 'antrian', orderable: false, searchable: false},
              {data: 'uuid', orderable: false, searchable: false},
              {data: 'registrasi.pasien.no_rm', orderable: false},
              {data: 'registrasi.pasien.nama', orderable: false},
              {data: 'registrasi.poli.nama', orderable: false},
              {data: 'cetak', orderable: false, searchable: false},
          ]
      });
    });
      


  </script>
@endsection
