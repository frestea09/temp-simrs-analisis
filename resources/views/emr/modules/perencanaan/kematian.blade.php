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
<h1>Perencanaan - Surat Kematian</h1>
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
    <form method="POST" action="{{ url('emr-soap/perencanaan/kematian/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Surat Kematian</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width:20%;">No. Surat</td>
                <td style="padding: 5px;">
                  <input type="text" name="no_surat" value="" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Di buat Dokter</td>
                <td style="padding: 5px;">
                  <select name="dokter_id" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->id }}" {{$d->id == $reg->dokter_id ? 'selected' :''}}>{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal </td>
                <td style="padding: 5px;">
                  <input type="date" name="tgl_kontrol" value="{{date('Y-m-d')}}" class="form-control"/>
                  <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Jam </td>
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
                      <b>No. Surat	     :</b> {{$item->nomor}}<br/>
                      <b>dibuat Dokter	 :</b> {{baca_dokter($item->dokter_id)}}<br/>
                      <b>Waktu Meninggal :</b> {{date('d-m-Y',strtotime($item->tgl_kontrol))}}, {{$item->jam_kontrol}} <br/>
                      <b>Keterangan	     :</b> {{$item->keterangan}}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                    
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-delete/'.$unit.'/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                        <a target="_blank" href="{{url('emr-soap-print-surat-kematian/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Cetak Surat"><i class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                        <button class="btn btn-danger btn-sm btn-flat proses-tte-surat-kematian" title="TTE" data-kematian-id="{{@$item->id}}"><i class="fa fa-pencil"></i></button>
                        @if (!empty(json_decode(@$item->tte)->base64_signed_file))
                          <a href="{{ url('emr-soap-print-tte-surat-kematian/' . @$reg->id . '/' . @$item->id) }}" target="_blank" class="btn btn-success btn-sm btn-flat" title="Hasil TTE"><i class="fa fa-print"></i></a>
                        @endif
                      </span>
                    </td>
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

    <!-- Modal TTE Surat Kematian-->
<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-surat-kematian" action="{{ url('tte-emr-soap-surat-kematian/' . @$reg->id . '/' . @$item->id) }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE SURAT KEMATIAN</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
          <input type="hidden" class="form-control" name="kematian_id" id="kematian_id" disabled>
          <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Nama:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">NIK:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="passphrase" id="passphrase">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="button-proses-tte-surat-kematian">Proses TTE</button>z
      </div>
    </div>
    </form>

  </div>
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
  <script>
    function showSuratKematian(registrasi_id) {
        console.log('Unit:', unit);
        console.log('Registrasi ID:', registrasi_id);

        $('#modalSuratKematian').modal('show');
        $('#modalSuratKematian form').attr('action', '/emr-soap/perencanaan/surat/' + unit + '/' + registrasi_id);
        $('#bodySuratKematian').load('/emr-soap/perencanaan/surat/' + unit + '/' + registrasi_id);
    }

    // TTE Surat Kematian
    $('.proses-tte-surat-kematian').click(function () {
        const registrasiId = $(this).data("registrasi-id");
        const kematianId = $(this).data("kematian-id");

        // Set nilai input di modal
        $('#registrasi_id_hidden3').val(registrasiId);
        $('#kematian_id').val(kematianId);

        // Tampilkan modal
        $('#myModal3').modal('show');
        return false;

    });

    $('#form-tte-surat-kematian').submit(function (e) {
        e.preventDefault();
        $('input').prop('disabled', false);
        $('#form-tte-surat-kematian')[0].submit();
    })
  </script>
  @endsection