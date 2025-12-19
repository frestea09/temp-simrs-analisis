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
<h1>Perencanaan - Surat Rujukan</h1>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/perencanaan/rujukan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('poli', $poli) !!}
          {!! Form::hidden('dpjp', $dpjp) !!}
          <br>
          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Surat Pengantar Rawat Inap</b> 
              <button type="button" class="btn pull-right btn-sm btn-primary btn-flat" onclick="popupWindow('/create-spri/'+{{$reg->id}})" style="margin-bottom: 5px;"><i class="fa fa-plus"></i> SPRI BPJS</button>
            </h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="width:20%;">Mulai Tgl Rawat</td>
                <td style="padding: 5px;">
                  <input type="date" value="{{@$assesmen->tgl_kontrol ?? date('Y-m-d')}}" name="tgl_kontrol" class="form-control"/>
                  <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small>
                </td>
              </tr>
              {{-- <tr>
                <td style="width:20%;">Sampai Tanggal Rawat</td>
                <td style="padding: 5px;">
                  <input type="date" value="{{@$assesmen->tgl_selesai ?? date('Y-m-d', strtotime("+1 day"))}}" name="tgl_selesai" class="form-control"/>
                </td>
              </tr> --}}

              @if ($unit == 'igd')
              <tr>
                <td style="width:20%;">Kebutuhan Ruangan</td>
                <td style="padding: 5px;">
                  <input type="text" class="form-control" name="kebutuhan_ruangan" id="" value="{{@$assesmen->kebutuhan_ruangan}}">
                </td>
              </tr>
                <tr>
                  <td style="width:20%;">Dokter Pengirim</td>
                  <td style="padding: 5px;">
                    <select name="dokter_igd_id" class="form-control select2" style="width: 100%">
                      @foreach ($dokter as $d)
                          <option value="{{ $d->id }}" {{(@$assesmen->dokter_igd_id ?? $reg->dokter_id) == $d->id ? 'selected' :''}}>{{ $d->nama }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Dokter DPJP</td>
                  <td style="padding: 5px;">
                    <select name="dokter_dpjp_id" class="form-control select2" style="width: 100%">
                      @foreach ($dokter as $d)
                          <option value="{{ $d->id }}" {{(@$surat_inap->dokter_rawat ?? $reg->dokter_id) == $d->id ? 'selected' :''}}>{{ $d->nama }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
                
              @endif
              {{-- <tr>
                <td style="width:20%;">Dokter Rawat</td>
                <td style="padding: 5px;">
                  <select name="dokter_id" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->id }}" {{(@$surat_inap->dokter_rawat ?? $reg->dokter_id) == $d->id ? 'selected' :''}}>{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </td>
              </tr> --}}
              <tr>
                <td style="width:20%;">Rencana Terapi</td>
                <td style="padding: 5px;">
                  <input type="text" class="form-control" name="rencana_terapi" id="" value="{{@$assesmen->rencana_terapi}}">
                </td>
              </tr>
              {{-- <tr>
                <td style="width:20%;">Anamnesa</td>
                <td style="padding: 5px;">
                  <input type="text" class="form-control" name="anamnesa" id=""> --}}
                  {{-- <select name="anamnesa" class="form-control select2" style="width: 100%">
                    @foreach ($medicalrecordumum as $d)
                        <option value="{{ $d->keterangan }}">{{ $d->keterangan }}</option>
                    @endforeach
                  </select> --}}
                {{-- </td>
              </tr>
              <tr>
                <td style="width:20%;">Pemeriksaan Fisik</td>
                <td style="padding: 5px;">
                  <input type="text" class="form-control" name="fisik" id=""> --}}
                  {{-- <select name="fisik" class="form-control select2" style="width: 100%">
                    @foreach ($fisik as $d)
                        <option value="{{json_decode($d->fisik,true)['fisik']}}">{{json_decode($d->fisik,true)['fisik']}}</option>
                    @endforeach
                  </select> --}}
                {{-- </td>
              </tr> --}}
              <tr>
                  <td style="padding: 5px;" colspan="2">
                    <textarea rows="5" name="keterangan" style="display:inline-block; resize:vertical;" placeholder="[Diagnosis dan Keterangan Detail]" class="form-control">{{ strip_tags(@$surat_inap ? @$surat_inap->diagnosa : "") }}</textarea></td>
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
                      <b>Mulai Tgl Rawat	:</b> {{date('d-m-Y',strtotime($item->tgl_kontrol))}}<br/>
                      {{-- <b>Sampai Tgl Rawat	:</b> {{date('d-m-Y',strtotime($item->tgl_selesai))}}<br/> --}}
                      {{-- <b>Anamnesa	:</b> {{$item->ket_anamnesa}}<br/>
                      <b>Fisik	:</b> {{$item->ket_fisik}}<br/> --}}
                      <b>Diagnosis	:</b> {{$item->keterangan}}<br/>
                      @if ($unit == 'igd')
                        <b>Kebutuhan Ruangan	:</b> {{$item->kebutuhan_ruangan}}<br/>
                        <b>Dokter IGD	:</b> {{@baca_dokter($item->dokter_igd_id)}}<br/>
                        <b>Dokter DPJP	:</b> {{@baca_dokter($item->dokter_dpjp_id)}}<br/>
                        <b>Rencana Terapi	:</b> {{($item->rencana_terapi)}}<br/>
                      @endif
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/perencanaan/rujukan/'. $unit .'/'.$reg->id. '?assesmen_id='. $item->id.'&delete=true')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                        <a target="_blank" href="{{url('emr-soap-print-surat-rujukan/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Cetak Surat"><i class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                        <a href="{{url('emr-soap/perencanaan/rujukan/'. $unit .'/'.$reg->id. '?assesmen_id='. $item->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil text-warning"></i></a>&nbsp;&nbsp;
                      </span>
                      <span class="pull-right" style="margin-right: 5rem;">
                        <button type="button" class="btn btn-flat btn-xs btn-danger proses-tte" data-url="{{ url('emr-soap-print-surat-rujukan/'.$reg->id.'/'.$item->id) }}">TTE</button>
                        @if (!empty($item->tte))
                          <a href="{{url('/dokumen_tte/'.$item->tte)}}" class="btn btn-flat btn-xs btn-info" target="_blank">Cetak File TTE</a>
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
        @if (@$assesmen)
          <input type="hidden" name="assesmen_id" value="{{@$assesmen->id}}">
          <button class="btn btn-warning">Perbarui</button>
        @else
          <button class="btn btn-success">Simpan</button>
        @endif
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

  <!-- Modal TTE SPRI-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte" action="" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE SPRI</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
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
            <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-medis">Proses TTE</button>
      </div>
    </div>
    </form>

  </div>
</div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  function popupWindow(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=1000,height=1000,scrollbars=yes');
      return false;
    }
  
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
        $('.proses-tte').click(function () {
            $('#form-tte').attr('action', $(this).data("url"));
            $('#myModal').modal('show');
            
        })

        $('#form-tte').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte')[0].submit();
        })
  </script>
  @endsection