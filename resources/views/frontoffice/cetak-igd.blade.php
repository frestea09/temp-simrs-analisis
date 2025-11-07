@extends('master')
@section('header')
  <h1>Cetak Label Rekam Medis IGD<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/cetak-igd', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true,'autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <br>

        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>No. RM Baru</th>
              <th>Cara Bayar</th>
              <th>Nama Pasien</th>

              <th>SEP</th>
              <th class="text-center"> Kelamin</th>
              <th class="text-center"> Tgl Registrasi</th>
              <th>Satu Sehat</th>
              <th>Tujuan</th>
              {{-- <th class="text-center">KIB</th>  --}}
              <th class="text-center">General Consent</th>
              <th class="text-center">TTE General Consent</th>
              <th class="text-center">Barcode</th>
              <th class="text-center">Barcode 2</th>
              <th class="text-center">Barcode Inap</th>
              {{--<th class="text-center">RM01</th>--}}
              <th class="text-center">SEP</th>
              <th class="text-center">GELANG</th>
              <th class="text-center">Triage</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($today as $key => $d)
              @if (!empty($d->pasien_id))
                <tr class="text-center">
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                  {{-- <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm_lama : '' }}</td> --}}
                  <td>{{ @baca_carabayar(@$d->bayar) }}</td>
                  <td class="text-left">{{ !empty($d->pasien_id) ? strtoupper($d->pasien->nama) : '' }}</td>

                  <td class="text-left">{{ @$d->no_sep }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->kelamin : '' }}</td>
                  <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                  <td>{{ @$d->id_encounter_ss }}</td>
                  <td>{{ baca_poli(@$d->poli_id) }}</td>
                  {{-- <td><a href="{{ url('frontoffice/cetak_buktiregistrasi/'.$d->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td> --}}
                  <td> 
                    <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="showGeneralConsent({{$d->id}})"><i class="fa fa-pencil text-center"></i> </button>
                    <a target="_blank" href="{{ url('/signaturepad/general-consent/'.@$d->id) }}" class="btn btn-danger btn-sm btn-flat" data-toggle="tooltip" 
                      title="ttd pasien">
                      <i class=""></i>TTD
                    </a>
                    {{-- {{ dd($d->general_consent) }} --}}
                    {{-- @if($d->general_consent != null) --}}
                        <a target="_blank" href="/frontoffice/cetak-general-consent/{{$d->id}}" class="btn btn-warning btn-sm btn-flat" ><i class="fa fa-print text-center"></i> </a> 
                    {{-- @endif --}}
                  </td>
                  <td>
                    <button class="btn btn-danger btn-sm btn-flat proses-tte-general-consent" data-registrasi-id="{{@$d->id}}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    @if (!empty(json_decode(@$d->tte_general_consent)->base64_signed_file))
                        <a href="{{ url('cetak-tte-general-consent/pdf/' . @$d->id) }}"
                            target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                class="fa fa-print"></i> </a>
                    @endif
                  </td>
                  <td> <a href="{{ url('frontoffice/cetak_barcodeigd/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td> <a href="{{ url('frontoffice/cetak_barcodeigd2/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td> <a href="{{ url('frontoffice/cetak_barcoderi/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  {{--<td>
                    <a href="{{ url('frontoffice/cetak-rm01/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                  </td>--}}
                 
                  <td>
                    @if (!empty($d->no_sep))
                      <a href="{{ url('cetak-sep/'.$d->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('tindakan/cetak-gelang/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                  </td>
                  <td class="text-center">
                    @php
                        @$triage = @\App\EmrInapPemeriksaan::where('registrasi_id',$d->id)->where('type','triage-igd')->orderBy('id', 'DESC')->first();
                    @endphp
                    @if ($triage)
                      <a href="{{ url('cetak-triage-igd/pdf/'. @$d->id . '/'. @$triage->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
                    @endif
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>

      {{-- Modal General Consent --}}
      <div class="modal fade" id="modalGeneralConsent" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" >PERSETUJUAN UMUM/ GENERAL CONSENT</h4>
                </div>
                <div class="modal-body" > 
                    <form action="" method="POST" >
                        {{ csrf_field() }}
                        <div id="bodyGeneralConsent">
                            Loading. . .
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal TTE General Consent-->
    <div id="myModal3" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <form id="form-tte-general-consent" action="{{ url('tte-pdf-general-consent') }}" method="POST">
        <input type="hidden" name="id">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE General Consent</h4>
          </div>
          <div class="modal-body row" style="display: grid;">
              {!! csrf_field() !!}
              <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
              <input type="hidden" class="form-control" name="general_id" id="general_id" disabled>
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
            <button type="submit" class="btn btn-primary" id="button-proses-tte-general-consent">Proses TTE</button>
          </div>
        </div>
        </form>

      </div>
    </div>

@endsection

@section('script')
    <script>
        function showGeneralConsent(registrasi_id) {
            $('#modalGeneralConsent').modal('show')
            $('#modalGeneralConsent form').attr('action', '/frontoffice/general-consent/' + registrasi_id)
            $('#bodyGeneralConsent').load('/frontoffice/general-consent/' + registrasi_id);
        }
        // TTE General Consent
        $('.proses-tte-general-consent').click(function () {
            $('#registrasi_id_hidden3').val($(this).data("registrasi-id"));
            $('#general_id').val($(this).data("general-id"));
            $('#myModal3').modal('show');
        })

        $('#form-tte-general-consent').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-general-consent')[0].submit();
        })
    </script>
    <script>
        function showGeneralConsent(registrasi_id) {
            $('#modalGeneralConsent').modal('show')
            $('#modalGeneralConsent form').attr('action', '/frontoffice/general-consent/' + registrasi_id)
            $('#bodyGeneralConsent').load('/frontoffice/general-consent/' + registrasi_id);
        }
    </script>
@endsection
