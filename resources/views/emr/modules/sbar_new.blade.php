@extends('master')

@section('header')
  <h1>Transfer Internal - SBAR</h1>
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
          @if ($source === 'operasi')
              @include('emr.modules.addons.tab-operasi')
          @else
              @include('emr.modules.addons.tabs')
          @endif
            <div class="col-md-12">
              @php
                $dataEkstra = @json_decode(@$emr->ekstra, true);
                $dataBackground = @json_decode(@$emr->background, true);
                $dataAssesment = @json_decode(@$emr->assesment, true);
              @endphp


                @if (!$emr)
                  <form method="POST" action="/save-emr-sbar-new" class="form-horizontal">
                @else
                  <form method="POST" action="/update-emr-sbar-new" class="form-horizontal">
                  {!! Form::hidden('emr_id', $emr->id) !!}
                @endif
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', @$reg->id) !!}
                    {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                    {!! Form::hidden('poli_id', @$poli ? @$poli : @$reg->poli_id) !!}
                    {!! Form::hidden('cara_bayar', @$reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    {!! Form::hidden('ekstra[sbar_tipe]', @$dataEkstra['sbar_tipe'] ?? $sbar_tipe) !!}
                    <br>
                    {{-- List soap --}}
                    <div class="col-md-5">  
                      <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                        <table class="table table-bordered" id="data" style="font-size: 12px;">
                             
                            <tbody>
                              @if (count($all_resume) == 0)
                                  <tr>
                                    <td>Tidak ada record</td>
                                  </tr>
                              @endif
                                @foreach( $all_resume as $key_a => $val_a )
                                @php
                                  $ekstra = json_decode(@$val_a->ekstra, true);
                                @endphp
                                <tr style="background-color:#9ad0ef">
                                  <th>{{@$val_a->registrasi->reg_id}}</th>
                                  <th>
                                    {{ @$val_a->registrasi->rawat_inap ? 'Rawat Inap' : @strtoupper($val_a->registrasi->poli->nama)}}
                                  </th>
                                </tr>
                                <tr style="background-color:#9ad0ef">
                                  <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
                                  <th>
                                    {{-- {{ $val_a->dokter_id ? baca_dokter($val_a->dokter_id) : @$val_a->registrasi->dokter_umum->nama}} --}}
                                    
                                    {{ baca_user($val_a->user_id)}}

                                  </th>
                                </tr>
                                  @if ($ekstra)
                                    <tr>
                                      <td colspan="2"><b>Transfer Internal : </b><br>
                                        @if (@$ekstra['sbar_tipe'] == "sbar-jalan")
                                            Transfer Internal Rawat Jalan
                                        @endif
                                        @if (@$ekstra['sbar_tipe'] == "sbar-igd")
                                            Transfer Internal IGD
                                        @endif
                                        @if (@$ekstra['sbar_tipe'] == "sbar-inap-masuk-ruangan")
                                            Transfer Internal Masuk Ruangan (Rawat Inap)
                                        @endif
                                        @if (@$ekstra['sbar_tipe'] == "sbar-inap-keluar-ruangan")
                                            Transfer Internal Keluar Ruangan (Rawat Inap)
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><b>Ruang asal : </b><br>
                                        {{@$ekstra['ruang_asal']}} {{@$ekstra['ruang_asal_detail']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><b>Pindah ke : </b><br>
                                        {{@$ekstra['pindah_ke']['ruangan']}} - {{@$ekstra['pindah_ke']['tanggal']}} {{@$ekstra['pindah_ke']['jam']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><b>Doktek yang merawat : </b><br>
                                        {{@$ekstra['dokter_yang_merawat']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><b>Alasan dirawat : </b><br>
                                        {{@$ekstra['alasan_dirawat']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><b>Alasan pindah : </b><br>
                                        {{@$ekstra['alasan_pindah']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" class="" style="font-size:15px;">
                                        <p>
                                          @if (Auth::user()->id == $val_a->user_id)
                                            <span class="pull-right">
                                              <a href="{{url('/cetak-eresume-transfer-internal-new/'.$val_a->id)}}" target="_blank" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>&nbsp;&nbsp;
                                              <a href="{{url('/emr/duplicate-emr-sbar-new/'.$val_a->id.'/'.@$reg->id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp;
                                              <a href="{{url('/emr/sbar-delete/'.$unit.'/'.@$reg->id.'/'.$val_a->id)}}" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');"><i class="text-danger fa fa-trash"></i></a>
                                              <a href="{{url('/emr/sbar/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'/edit?poli='.$poli.'&dpjp='.$dpjp)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                            </span>
                                          @endif
                                        </p>
                                      </td>
                                    </tr>
                                  @else
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
                                  @endif
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                    
                    {{-- SBAR Input --}}
                      <div class="col-md-7">  
                        <table style="width: 100%" style="font-size:12px;">
                          <tr>
                            <td style="vertical-align: top">Ruang asal</td>
                            <td style="padding: 5px;">
                              <div>
                                <input type="checkbox" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "IGD" ? "checked" : ""}} value="IGD">
                                <label style="font-weight: normal;">IGD</label>
                              </div>
                              <div>
                                <input type="checkbox" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "IGD Kebidanan" ? "checked" : ""}} value="IGD Kebidanan">
                                <label style="font-weight: normal;">IGD Kebidananan</label>
                              </div>
                              <div>
                                <input type="checkbox" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "IBS" ? "checked" : ""}} value="IBS">
                                <label style="font-weight: normal;">IBS</label>
                              </div>
                              <div>
                                <input type="checkbox" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "Ruangan" ? "checked" : ""}} value="Ruangan">
                                <label style="font-weight: normal;">Ruangan</label>
                                <input type="text" class="form-control" name="ekstra[ruang_asal_detail]" value="{{@$dataEkstra['ruang_asal_detail']}}" placeholder="Ruangan">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Pindah ke</td>
                            <td style="padding: 5px;">
                              <div class="btn-group" style="display: flex;" role="group">
                                <input required type="text" class="form-control" name="ekstra[pindah_ke][ruangan]" value="{{@$dataEkstra['pindah_ke']['ruangan']}}" placeholder="Pindah ke">
                                <button class="btn btn-default">Tanggal</button>
                                <input required type="date" class="form-control" name="ekstra[pindah_ke][tanggal]" value="{{@$dataEkstra['pindah_ke']['tanggal'] ? @$dataEkstra['pindah_ke']['tanggal'] : date("Y-m-d")}}" placeholder="Tanggal">
                                <button class="btn btn-default">Jam</button>
                                <input required type="time" class="form-control" name="ekstra[pindah_ke][jam]" value="{{@$dataEkstra['pindah_ke']['jam'] ? @$dataEkstra['pindah_ke']['jam'] : date("H:i")}}" placeholder="Jam">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokter yang merawat</td>
                            <td style="padding: 5px;">
                                <input required type="text" class="form-control" name="ekstra[dokter_yang_merawat]" value="{{@$dataEkstra['dokter_yang_merawat'] ? @$dataEkstra['dokter_yang_merawat'] : @baca_dokter(@$reg->dokter_id)}}" placeholder="Dokter yang merawat">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Alasan dirawat</td>
                            <td style="padding: 5px;">
                                <input required type="text" class="form-control" name="ekstra[alasan_dirawat]" value="{{@$dataEkstra['alasan_dirawat']}}" placeholder="Alasan dirawat">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Alasan pindah</td>
                            <td style="padding: 5px;">
                                <input required type="text" class="form-control" name="ekstra[alasan_pindah]" value="{{@$dataEkstra['alasan_pindah']}}" placeholder="Alasan pindah">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td><b>Situtation(S)</b></td>
                            <td style="padding: 5px;">
                                @if ($emr)
                                  <textarea required style="resize: vertical;" class="form-control" rows="10" placeholder="[Masukkan keluhan pasien]" name="situation" required>{{$emr ? $emr->situation : ''}}</textarea>
                                @elseif ($cppt)
                                  <textarea required style="resize: vertical;" class="form-control" rows="10" placeholder="[Masukkan keluhan pasien]" name="situation" required>{{$cppt->subject}}</textarea>
                                @else
                                  <textarea required style="resize: vertical;" class="form-control" rows="10" placeholder="[Masukkan keluhan pasien]" name="situation" required></textarea>
                                @endif
                            </td> 
                          </tr>
                          <tr>
                              <td style="width:50px; vertical-align: top; padding-top: 5px;"><b>Background(B)</b></td>
                              <td style="padding: 5px;">
                                  <b>Kondisi pasien saat pindah:</b>
                                  <br>
                                  <div>
                                    <b>Kesadaran :</b><br>
                                    <input type="checkbox" {{@$dataBackground['kesadaran']['compos'] == "Compos Mentis" ? "checked" : ""}} name="background[kesadaran][compos]" value="Compos Mentis">
                                    <label style="font-weight: normal;">Compos Mentis</label>
                                    <input type="checkbox" {{@$dataBackground['kesadaran']['apatis'] == "Apatis" ? "checked" : ""}} name="background[kesadaran][apatis]" value="Apatis">
                                    <label style="font-weight: normal;">Apatis</label>
                                    <input type="checkbox" {{@$dataBackground['kesadaran']['delirium'] == "Delirium" ? "checked" : ""}} name="background[kesadaran][delirium]" value="Delirium">
                                    <label style="font-weight: normal;">Delirium</label>
                                    <input type="checkbox" {{@$dataBackground['kesadaran']['sopor'] == "Sopor" ? "checked" : ""}} name="background[kesadaran][sopor]" value="Sopor">
                                    <label style="font-weight: normal;">Sopor</label>
                                  </div>
                                  <div>
                                   <b>GCS :</b><br>
                                    E :
                                    <input required type="text" class="form-control" name="background[gcs][e]" value="{{@$dataBackground['gcs']['e']}}">
                                    M :
                                    <input required type="text" class="form-control" name="background[gcs][m]" value="{{@$dataBackground['gcs']['m']}}">
                                    V :
                                    <input required type="text" class="form-control" name="background[gcs][v]" value="{{@$dataBackground['gcs']['v']}}">
                                  </div>
                                  <div>
                                    <b>Tanda Vital :</b><br>
                                    Tekanan darah :
                                    <input required type="text" class="form-control" name="background[tanda_vital][tekanan_darah]" value="{{@$dataBackground['tanda_vital']['tekanan_darah'] ?? @$cpptPerawat->tekanan_darah}}">
                                    Nadi :
                                    <input required type="text" class="form-control" name="background[tanda_vital][nadi]" value="{{@$dataBackground['tanda_vital']['nadi'] ?? @$cpptPerawat->nadi}}">
                                    Pernafasan :
                                    <input required type="text" class="form-control" name="background[tanda_vital][pernafasan]" value="{{@$dataBackground['tanda_vital']['pernafasan'] ?? @$cpptPerawat->frekuensi_nafas}}">
                                    Suhu :
                                    <input required type="text" class="form-control" name="background[tanda_vital][suhu]" value="{{@$dataBackground['tanda_vital']['suhu'] ?? @$cpptPerawat->suhu}}">
                                  </div>
                                  <div>
                                    Penggunaan Oksigen :
                                    <input required type="text" class="form-control" placeholder="L/m" name="background[penggunaan_oksigen][penggunaan]" value="{{@$dataBackground['penggunaan_oksigen']['penggunaan']}}">
                                    Cairan Parenteral :
                                    <input required type="text" class="form-control" placeholder="ml/24jam" name="background[cairan_parenteral][cairan]" value="{{@$dataBackground['cairan_parenteral']['cairan']}}">
                                    Transfusi :
                                    <input required type="text" class="form-control" placeholder="ml" name="background[transfusi][transfusi]" value="{{@$dataBackground['transfusi']['transfusi']}}">
                                  </div>
                                  <div>
                                    <b>Penggunaan Kateter :</b>
                                    <input type="radio" name="background[penggunaan_kateter][detail]" onclick="penggunaan_kateter('Ada')" {{@$dataBackground['penggunaan_kateter']['detail'] == "Ada" ? "checked" : ""}} value="Ada">
                                    <label style="font-weight: normal;">Ada</label>
                                    <input type="radio" name="background[penggunaan_kateter][detail]" onclick="penggunaan_kateter('Tidak')" {{@$dataBackground['penggunaan_kateter']['detail'] == "Tidak" ? "checked" : ""}} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label> <br>
                                    <div id="penggunaan_kateter">
                                        @if (@$dataBackground['penggunaan_kateter']['detail'] == "Ada")
                                            Pemakaian ke :
                                            <input required type="text" class="form-control" name="background[penggunaan_kateter][pemakaian_ke]" value="{{@$dataBackground['penggunaan_kateter']['pemakaian_ke']}}">
                                            Tanggal :
                                            <input required type="date" class="form-control" name="background[penggunaan_kateter][tanggal]" value="{{@$dataBackground['penggunaan_kateter']['tanggal']}}">
                                            Jam :
                                            <input required type="time" class="form-control" name="background[penggunaan_kateter][jam]" value="{{@$dataBackground['penggunaan_kateter']['jam']}}">
                                        @endif
                                    </div>
                                  </div>
                                  <div>
                                    <b>Hasil Pemeriksaan selama dirawat :</b> <br>
                                    <textarea required name="background[hasil_pemeriksaan_selama_dirawat]" rows="5" placeholder="[Masukkan hasil pemeriksaan]" class="form-control">{{@$dataBackground['hasil_pemeriksaan_selama_dirawat']}}</textarea>
                                  </div>
                                  <div>
                                    <b>Prosedur / tindakan yang sudah dilakukan :</b> <br>
                                    <textarea required name="background[prosedur_tindakan_yang_dilakukan]" rows="5" placeholder="[Masukkan prosedur / tindakan]" class="form-control">{{@$dataBackground['prosedur_tindakan_yang_dilakukan'] ?? @$dataAswal['igdAwal']['tindakan_pengobatan']}}</textarea>
                                  </div>
                              </td> 
                          </tr>
                          <tr>
                              <td style="vertical-align: top; padding-top: 5px;"><b>Assessment(A)</b></td>
                              <td style="padding: 5px;">
                                <b>Diagnosa Medis:</b>
                                  <br>
                                  <div>
                                    <textarea required name="assesment[diagnosa_medis]" rows="5" placeholder="[Masukkan diagnosa medis]" class="form-control">{{ @$dataAssesment['diagnosa_medis'] ?? (is_array(@$diagnosa) ? implode(', ', array_filter(@$diagnosa)) : @$diagnosa) }}</textarea>
                                  </div>
                                <b>Diagnosa Keperawatan:</b>
                                  <br>
                                  <div>
                                    <textarea required name="assesment[diagnosa_keperawatan]" rows="5" placeholder="[Masukkan diagnosa keperawatan]" class="form-control">{{@$dataAssesment['diagnosa_keperawatan']}}</textarea>
                                  </div>
                              </td> 
                          </tr>
                          
                          <tr>
                              <td style="vertical-align: top; padding-top: 5px;"><b>Recomendation(R)</b></td>
                              <td style="padding: 5px;">
                                  @if ($emr)
                                    <textarea required style="resize: vertical;" class="form-control" rows="5" placeholder="Prosedur atau tindakan yang belum dilakukan / saran untuk mengatasi masalah pasien" name="recomendation" required>{{$emr ? $emr->recomendation : ''}}</textarea>
                                  @else
                                    <textarea required style="resize: vertical;" class="form-control" rows="5" placeholder="Prosedur atau tindakan yang belum dilakukan / saran untuk mengatasi masalah pasien" name="recomendation" required></textarea>
                                  @endif
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
        let html = `Pemakaian ke :
                        <input required type="text" class="form-control" name="background[penggunaan_kateter][pemakaian_ke]" value="{{@$dataBackground['penggunaan_kateter']['pemakaian_ke']}}">
                        Tanggal :
                        <input required type="date" class="form-control" name="background[penggunaan_kateter][tanggal]" value="{{@$dataBackground['penggunaan_kateter']['tanggal']}}">
                        Jam :
                        <input required type="time" class="form-control" name="background[penggunaan_kateter][jam]" value="{{@$dataBackground['penggunaan_kateter']['jam']}}">`;
                    
        function penggunaan_kateter(status) {
          if (status == "Ada") {
            $('#penggunaan_kateter').html(html);
          } else {
            $('#penggunaan_kateter').html('');
          }
        }

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
