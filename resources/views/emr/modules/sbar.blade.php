@extends('master')

@section('header')
  <h1>Catatan Perkembangan Pasien Terintegrasi - SBAR</h1>
@endsection

<style>
  body {font-family: Arial, Helvetica, sans-serif;}
  
  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }
  
  #myImg:hover {opacity: 0.7;}
  
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }
  
  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }
  
  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }
  
  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }
  
  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }
  
  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }
  
  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }
  
  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }
  
  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
  </style>








<style>
  .new{
    background-color:#e4ffe4;
  }
</style>
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
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> 
        @include('emr.modules.addons.profile')
        <div class="row">
          @include('emr.modules.addons.tabs')
            <div class="col-md-12">
                @if (!$emr)
                  <form method="POST" action="/save-emr-sbar" class="form-horizontal">
                @else
                  <form method="POST" action="/update-emr-sbar" class="form-horizontal">
                  {!! Form::hidden('emr_id', $emr->id) !!}
                @endif
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', @$reg->id) !!}
                    {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                    {!! Form::hidden('poli_id', @$poli ? @$poli : @$reg->poli_id) !!}
                    {!! Form::hidden('cara_bayar', @$reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br>
                    {{-- List soap --}}
                    <div class="col-md-6">  
                      <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                        <table class="table table-bordered" id="data" style="font-size: 12px;">
                             
                            <tbody>
                              @if (count($all_resume) == 0)
                                  <tr>
                                    <td>Tidak ada record</td>
                                  </tr>
                              @endif
                                @foreach( $all_resume as $key_a => $val_a )
                                <tr style="background-color:#9ad0ef">
                                  <th>{{@$val_a->registrasi->reg_id}}</th>
                                  <th>
                                    {{ $val_a->registrasi->rawat_inap ? 'Rawat Inap' : @strtoupper($val_a->registrasi->poli->nama)}}
                                  </th>
                                </tr>
                                <tr style="background-color:#9ad0ef">
                                  <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
                                  <th>
                                    {{-- {{ $val_a->dokter_id ? baca_dokter($val_a->dokter_id) : @$val_a->registrasi->dokter_umum->nama}} --}}
                                    
                                    {{ baca_user($val_a->user_id)}}

                                  </th>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>S:</b> {!! $val_a->situation !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>B:</b> {!! $val_a->background !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>R:</b> {!! $val_a->recomendation !!}</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><b>Dialihkan ke:</b> {!! $val_a->discharge !!}</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><b>Alasan dirawat:</b> {!! @explode('|', @$val_a->keterangan)[0] !!}</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><b>Alasan pindah:</b> {!! @explode('|', @$val_a->keterangan)[1] !!}</td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="" style="font-size:15px;">
                                    <p>
                                      @if (Auth::user()->id == $val_a->user_id)
                                        <span class="pull-right">
                                          <a href="{{url('/cetak-eresume-transfer-internal/'.$val_a->id)}}" target="_blank" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>&nbsp;&nbsp;
                                          <a href="{{url('/emr/duplicate-emr-sbar/'.$val_a->id.'/'.$dpjp.'/'.$poli.'/'.@$reg->id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp;
                                          <a href="{{url('/emr/sbar/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'/edit?poli='.$poli.'&dpjp='.$dpjp)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                        </span>
                                        <span class="pull-left">
                                          @if (!empty(json_decode(@$val_a->tte)->base64_signed_file))
                                            <a href="{{url('/cetak-eresume-transfer-internal-tte/'.$val_a->id)}}" target="_blank" data-toggle="tooltip" title="Cetak File TTE" class="btn btn-sm btn-success btn-flat"><i class="fa fa-print"></i></a>&nbsp;&nbsp;
                                          @endif
                                          <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="showTTEModal({{$val_a->id}})" data-toggle="tooltip" title="TTE"><i class="fa fa-pencil"></i></button>
                                        </span>
                                      @endif
                                    </p>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                    
                    {{-- SBAR Input --}}
                      <div class="col-md-6">  
                        <table style="width: 100%" style="font-size:12px;">
                          <tr>
                            <td><b>Situtation(S)</b></td>
                            <td style="padding: 5px;">
                                @if ($emr)
                                  <textarea required style="resize: vertical;" class="form-control" name="situation" required>{{$emr ? $emr->situation : ''}}</textarea>
                                @elseif ($cppt)
                                  <textarea required style="resize: vertical;" class="form-control" name="situation" required>{{$cppt->subject}}</textarea>
                                @else
                                  <textarea required style="resize: vertical;" class="form-control" name="situation" required></textarea>
                                @endif
                            </td> 
                          </tr>
                          <tr>
                              <td style="width:50px;"><b>Background(B)</b></td>
                              <td style="padding: 5px;">
                                  @if ($emr)
                                    <textarea required style="resize: vertical;" class="form-control" name="background" required>{{$emr ? $emr->background : ''}}</textarea>
                                  @elseif ($cppt)
                                    <textarea required style="resize: vertical;" class="form-control" name="background" required>Tekanan Darah: {{$cppt->tekanan_darah}}, Nadi: {{$cppt->nadi}}, Frekuensi Nafas : {{$cppt->frekuensi_nafas}}, Suhu: {{$cppt->suhu}}, Berat badan: {{$cppt->berat_badan}} &#13;{{$cppt->object}}</textarea>
                                  @else
                                    <textarea required style="resize: vertical;" class="form-control" name="background" required></textarea>
                                  @endif
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Assessment(A)</b></td>
                              <td style="padding: 5px;">
                                  @if ($emr)
                                    <textarea required style="resize: vertical;" class="form-control" name="assesment" required>{{$emr ? $emr->assesment : ''}}</textarea>
                                  @elseif ($cppt)
                                    <textarea required style="resize: vertical;" class="form-control" name="assesment" required>{{$cppt->assesment}}</textarea>
                                  @else
                                    <textarea required style="resize: vertical;" class="form-control" name="assesment" required></textarea>
                                  @endif
                              </td> 
                          </tr>
                          
                          <tr>
                              <td><b>Recomendation(R)</b></td>
                              <td style="padding: 5px;">
                                  @if ($emr)
                                    <textarea required style="resize: vertical;" class="form-control" name="recomendation" required>{{$emr ? $emr->recomendation : ''}}</textarea>
                                  @else
                                    <textarea required style="resize: vertical;" class="form-control" name="recomendation" required></textarea>
                                  @endif
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Dialihkan ke</b></td>
                              <td style="padding: 5px;">
                                @if ($unit == "igd")
                                  @if ($emr)
                                    <input required style="resize: vertical;" class="form-control" name="discharge" required value="{{$emr ? $emr->discharge : ''}}">
                                  @else
                                    <input required style="resize: vertical;" class="form-control" name="discharge" required>
                                  @endif
                                @else
                                  <select name="discharge" class="select2" style="width: 100%;">
                                    <option value="" selected disabled>-- Pilih Salah Satu --</option>
                                    @foreach ($kamar as $k)
                                      <option value="{{$k}}" {{@$emr->discharge == $k ? 'selected' : ''}}>{{$k}}</option>
                                    @endforeach
                                    <option value="Hemodialisa" {{@$emr->discharge == "Hemodialisa" ? 'selected' : ''}}>Hemodialisa</option>
                                    <option value="IBS" {{@$emr->discharge == "IBS" ? 'selected' : ''}}>IBS</option>
                                  </select>
                                @endif
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Alasan dirawat</b></td>
                              <td style="padding: 5px;">
                                  <input required style="resize: vertical;" class="form-control" name="alasan_dirawat" required value="{{$emr ? @explode('|', @$emr->keterangan)[0] : ''}}">
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Alasan pindah</b></td>
                              <td style="padding: 5px;">
                                  <input required style="resize: vertical;" class="form-control" name="alasan_pindah" required value="{{$emr ? @explode('|', @$emr->keterangan)[1] : ''}}">
                              </td> 
                          </tr>
                          <tr>
                            <td style="text-align: right;" colspan="2">
                              <button type="submit" class="btn btn-primary btn-flat pull-right">SIMPAN</button>
                            </td>
                          </tr>
                        </table>
                      </div>
                      
                      
                    <br/><br/> 
                </form>
                <hr/>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', @$reg->id) !!}
                  {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                  {!! Form::hidden('cara_bayar', @$reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form> 
            </div>
        </div>
    </div>
  </div>  

  {{-- Modal TTE Sbar--}}
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-sbar" action="" method="POST">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE Transfer Internal</h4>
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
          <button type="button" class="btn btn-primary" id="button-proses-tte-triage" onclick="prosesTTE()">Proses TTE</button>
      </div>
      </div>
      </form>
  
  </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        $(".skin-blue").addClass( "sidebar-collapse" );
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
    </script>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var dataImage = document.getElementById("dataImage");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = dataImage.src;
            captionText.innerHTML = this.alt;
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
    </script>

    <script>
        function showTTEModal(sbar_id) {
            $('#form-tte-sbar').attr('action', '/tte-transfer-internal/'+sbar_id)
            $('#myModal').modal('show');
        }

        function prosesTTE() {
            $('input').prop('disabled', false)
            $('#form-tte-sbar').submit();
        }
    </script>

@endsection
