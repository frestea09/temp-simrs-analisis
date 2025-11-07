@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }
</style>
@section('header')
<h1>Kontrol</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/perencanaan/kontrol/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Kontrol</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width:20%;">Poli Tujuan</td>
                <td style="padding: 5px;">
                  <select name="poli_id" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                        <option value="{{ $d->id }}" {{$d->id == $reg->poli_id ? 'selected' :''}}>{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Dokter</td>
                <td style="padding: 5px;">
                  <select name="dokter_id" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->id }}" {{$d->id == $reg->dokter_id ? 'selected' :''}}>{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal Kontrol</td>
                <td style="padding: 5px;">
                  <input type="date" name="tgl_kontrol" value="{{date('Y-m-d')}}" class="form-control"/>
                  <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Jam Kontrol</td>
                <td style="padding: 5px;">
                  <input type="time" value="{{date('H:i')}}" name="jam_kontrol" class="form-control"/>
                  <small class="pull-right">Klik icon <b>jam</b> untuk memunculkan tanggal</small>
                </td>
              </tr>
              <tr>
                  <td style="padding: 5px;" colspan="2">
                    <textarea rows="15" name="keterangan" style="display:inline-block" placeholder="[Keterangan]" class="form-control"></textarea></td>
                  </td>
              </tr>
               
            </table>
          </div>
          {{-- Alergi --}}
          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Catatan Medis</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr>  
                @endif
                @foreach ($riwayat as $item)
                  <tr>
                    <td> 
                      <b>Poli	:</b> {{baca_poli($item->poli_id)}}<br/>
                      <b>Dokter	:</b> {{baca_dokter($item->dokter_id)}}<br/>
                      <b>Waktu Kontrol	:</b> {{date('d-m-Y',strtotime($item->tgl_kontrol))}}, {{$item->jam_kontrol}} <br/>
                      <b>Keterangan	:</b> {{$item->keterangan}}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
              </table>
              </div>
              </div> 
          </div>
          
          <br /><br />
        </div>

        
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br/>
    <br/>
    {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}
    
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  $('.select2').select2();
  $("input[name='diagnosa_awal']").on('focus', function () {
        $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd9',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      $(document).on('click', '.addICD', function (e) {
        document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  @endsection