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
  .select2-selection__rendered{
    padding-left: 20px !important;
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
@section('header')
<h1>fisik Fisik</h1>
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
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/pemantauan-transfusi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('poli_id', $poli) !!}
          {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
          {!! Form::hidden('pelaksana', $reg->dokter_id) !!}
          {!! Form::hidden('tanggal', Carbon\Carbon::now()->format('d-m-Y')) !!}
          {!! Form::hidden('jumlah', 1) !!}
          {!! Form::hidden('pemantauan_transfusi_id', @$pemantauanTransfusi->id) !!}
          <br>
          {{-- @role(['administrator', 'emr_inap']) --}}
            @php
              $transfusi = @json_decode(@$pemantauanTransfusi->fisik, true);
            @endphp
            <div class="col-md-6">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Pemantauan Transfusi</b></h5>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Tanggal</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[pemantauan_transfusi][tanggal]" placeholder="Tanggal" class="form-control datepicker" value="{{@$transfusi['pemantauan_transfusi']['tanggal'] ?? @$assesment['pemantauan_transfusi']['tanggal']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Transfusi</td>
                  <td style="padding: 5px;">
                    <div>
                        <label class="form-check-label">Labu KG</label>
                        <input type="text" name="fisik[pemantauan_transfusi][labu_kg]" placeholder="Labu KG" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['labu_kg'] ?? @$assesment['pemantauan_transfusi']['labu_kg']}}">
                        <label class="form-check-label">Mulai Jam</label>
                        <input type="time" name="fisik[pemantauan_transfusi][mulai_jam]" placeholder="Mulai Jam" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['mulai_jam'] ?? @$assesment['pemantauan_transfusi']['mulai_jam']}}">
                        <label class="form-check-label">Selesai Jam</label>
                        <input type="time" name="fisik[pemantauan_transfusi][selesai_jam]" placeholder="Selesai Jam" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['selesai_jam'] ?? @$assesment['pemantauan_transfusi']['selesai_jam']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">0 Jam I</td>
                  <td style="padding: 5px;">
                    <div>
                        <label class="form-check-label">Tensi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam1][tensi]" placeholder="Tensi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam1']['tensi'] ?? @$assesment['pemantauan_transfusi']['0jam1']['tensi']}}">
                        <label class="form-check-label">Nadi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam1][nadi]" placeholder="Nadi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam1']['nadi'] ?? @$assesment['pemantauan_transfusi']['0jam1']['nadi']}}">
                        <label class="form-check-label">Suhu</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam1][suhu]" placeholder="Suhu" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam1']['suhu'] ?? @$assesment['pemantauan_transfusi']['0jam1']['suhu']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">0 Jam II</td>
                  <td style="padding: 5px;">
                    <div>
                        <label class="form-check-label">Tensi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam2][tensi]" placeholder="Tensi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam2']['tensi'] ?? @$assesment['pemantauan_transfusi']['0jam2']['tensi']}}">
                        <label class="form-check-label">Nadi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam2][nadi]" placeholder="Nadi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam2']['nadi'] ?? @$assesment['pemantauan_transfusi']['0jam2']['nadi']}}">
                        <label class="form-check-label">Suhu</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam2][suhu]" placeholder="Suhu" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam2']['suhu'] ?? @$assesment['pemantauan_transfusi']['0jam2']['suhu']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">0 Jam III</td>
                  <td style="padding: 5px;">
                    <div>
                        <label class="form-check-label">Tensi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam3][tensi]" placeholder="Tensi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam3']['tensi'] ?? @$assesment['pemantauan_transfusi']['0jam3']['tensi']}}">
                        <label class="form-check-label">Nadi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam3][nadi]" placeholder="Nadi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam3']['nadi'] ?? @$assesment['pemantauan_transfusi']['0jam3']['nadi']}}">
                        <label class="form-check-label">Suhu</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam3][suhu]" placeholder="Suhu" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam3']['suhu'] ?? @$assesment['pemantauan_transfusi']['0jam3']['suhu']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">0 Jam IV</td>
                  <td style="padding: 5px;">
                    <div>
                        <label class="form-check-label">Tensi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam4][tensi]" placeholder="Tensi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam4']['tensi'] ?? @$assesment['pemantauan_transfusi']['0jam4']['tensi']}}">
                        <label class="form-check-label">Nadi</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam4][nadi]" placeholder="Nadi" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam4']['nadi'] ?? @$assesment['pemantauan_transfusi']['0jam4']['nadi']}}">
                        <label class="form-check-label">Suhu</label>
                        <input type="text" name="fisik[pemantauan_transfusi][0jam4][suhu]" placeholder="Suhu" class="form-control" value="{{@$transfusi['pemantauan_transfusi']['0jam4']['suhu'] ?? @$assesment['pemantauan_transfusi']['0jam4']['suhu']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Tindakan</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[pemantauan_transfusi][tindakan]" style="display:inline-block; resize: vertical;" placeholder="[Tindakan]" class="form-control" >{{@$transfusi['pemantauan_transfusi']['tindakan'] ?? @$assesment['pemantauan_transfusi']['tindakan']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Keterangan</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[pemantauan_transfusi][keterangan]" style="display:inline-block; resize: vertical;" placeholder="[Keterangan]" class="form-control" >{{@$transfusi['pemantauan_transfusi']['keterangan'] ?? @$assesment['pemantauan_transfusi']['keterangan']}}</textarea>
                  </td>
                </tr>
              </table>
              <div class="form-group" style="margin-top: 10px;">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::submit(empty($pemantauanTransfusi) ? "Simpan Pemantauan Transfusi" : "Perbarui Pemantauan Transfusi", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                    @if (!empty($pemantauanTransfusi))
                      <a href="{{ url("emr-soap/pemeriksaan/pemantauan-transfusi/".$unit."/".@$reg->id) }}" class="btn btn-info btn-flat">
                        Batal Edit
                      </a>
                    @endif
                </div>
              </div> 
            </div>

            <div class="col-md-6">
              <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th colspan="4" class="text-center" style="vertical-align: middle;">History</th>
                  </tr>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                    <th class="text-center" style="vertical-align: middle;">Mulai Jam</th>
                    <th class="text-center" style="vertical-align: middle;">Selesai Jam</th>
                    <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($riwayats_pemantauan) == 0)
                      <tr>
                          <td colspan="4" class="text-center">Tidak Ada Riwayat Pemantauan Transfusi</td>
                      </tr>
                  @endif
                  @foreach ($riwayats_pemantauan as $riwayat)
                  @php
                    @$pemantauan_transfusi = @json_decode(@$riwayat->fisik)->pemantauan_transfusi;
                  @endphp
                      <tr>
                          <td style="text-align: center; {{ $riwayat->id == request()->pemantauan_transfusi_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{@Carbon\Carbon::parse(@$pemantauan_transfusi->tanggal)->format('d-m-Y')}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->pemantauan_transfusi_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$pemantauan_transfusi->mulai_jam}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->pemantauan_transfusi_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$pemantauan_transfusi->selesai_jam}}
                          </td>
                        
                          <td style="text-align: center; {{ $riwayat->id == request()->pemantauan_transfusi_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              <a href="{{ url("emr-soap/pemeriksaan/pemantauan-transfusi/".$unit."/".@$riwayat->registrasi_id."?pemantauan_transfusi_id=".@$riwayat->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-pencil"></i>
                              </a>
                              <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                <i class="fa fa-trash"></i>
                              </a>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <i>Dibuat : {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }}</i>
                        </td>
                      </tr>
                  @endforeach
                
                </tbody>
              </table>
            </div>
          {{-- @endrole --}}

          <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' style="width: 100%;">
              <thead>
                <tr>
                  <th colspan="11" class="text-center">PEMANTAUAN TRANSFUSI</th>
                </tr>
                <tr>
                  <th rowspan="2" class="text-center">No</th>
                  <th rowspan="2" class="text-center">Tanggal</th>
                  <th colspan="3" class="text-center">Transfusi</th>
                  <th colspan="4" class="text-center"></th>
                  <th rowspan="2" class="text-center">Tindakan</th>
                  <th rowspan="2" class="text-center">Ket</th>
                  <th rowspan="2" class="text-center">Cetak</th>
                </tr>
                <tr>
                  <th class="text-center">Labu</th>
                  <th class="text-center">Mulai Jam</th>
                  <th class="text-center">Selesai Jam</th>
                  <th class="text-center">0 Jam I</th>
                  <th class="text-center">0 Jam II</th>
                  <th class="text-center">0 Jam III</th>
                  <th class="text-center">0 Jam IV</th>
                </tr>
              </thead>
              <tbody>
                @if (count($riwayats_pemantauan) > 0)
                  @foreach ($riwayats_pemantauan as $key => $pemantauan)
                    @php
                      $data = json_decode(@$pemantauan->fisik, true);
                    @endphp
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ @$data['pemantauan_transfusi']['tanggal'] }}</td>
                      <td>{{ @$data['pemantauan_transfusi']['labu_kg'].' Kg' }}</td>
                      <td>{{ @$data['pemantauan_transfusi']['mulai_jam'] }}</td>
                      <td>{{ @$data['pemantauan_transfusi']['selesai_jam'] }}</td>
                      <td>
                        {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam1']['tensi'] }} <br>
                        {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam1']['nadi'] }} <br>
                        {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam1']['suhu'] }}
                      </td>
                      <td>
                        {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam2']['tensi'] }} <br>
                        {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam2']['nadi'] }} <br>
                        {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam2']['suhu'] }}
                      </td>
                      <td>
                        {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam3']['tensi'] }} <br>
                        {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam3']['nadi'] }} <br>
                        {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam3']['suhu'] }}
                      </td>
                      <td>
                        {{ 'Tensi: '.@$data['pemantauan_transfusi']['0jam4']['tensi'] }} <br>
                        {{ 'Nadi: '.@$data['pemantauan_transfusi']['0jam4']['nadi'] }} <br>
                        {{ 'Suhu: '.@$data['pemantauan_transfusi']['0jam4']['suhu'] }}
                      </td>
                      <td>{{ @$data['pemantauan_transfusi']['tindakan'] }}</td>
                      <td>{{ @$data['pemantauan_transfusi']['keterangan'] }}</td>
                      <td class="text-center">
                        <a target="_blank" href="{{url('/emr-soap-print/cetak-pemantauan-transfusi/'.$pemantauan->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
@endsection
        