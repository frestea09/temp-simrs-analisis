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
<h1>Daftar Tilik Vaksinasi</h1>
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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/perencanaan/daftar-tilik-vaksinasi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('assesment_id', @$riwayat->id) !!}
          <br>

          <h5 class="text-center"><b>FORMULIR DAFTAR TILIK PENAPISAN KONTRAINDIKASI UNTUK VAKSINASI DEWASA</b></h5>
          <br>
          <div class="col-md-12">
            <input type="hidden" name="assesment_type" value="hasil">
            {{-- {{dd($assesment)}} --}}
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <thead>
                <tr>
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 35%; text-align: center;">PERTANYAAN</th>
                  <th style="width: 10%; text-align: center;">YA</th>
                  <th style="width: 10%; text-align: center;">TIDAK</th>
                  <th style="width: 10%; text-align: center;">TIDAK TAHU</th>
                  <th style="width: 30%; text-align: center;">KETERANGAN</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">1</td>
                  <td>Apakah anda sedang sakit hari ini ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[1][ya]" value="ya1" {{ @$assesment['1']['ya'] == 'ya1' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[1][tidak]" value="tidak1" {{ @$assesment['1']['tidak'] == 'tidak1' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[1][tidaktahu]" value="tidaktahu1" {{ @$assesment['1']['tidaktahu'] == 'tidaktahu1' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[1][keterangan1]" class="form-control" value="{{ @$assesment['1']['keterangan1'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">2</td>
                  <td>Apakah anda memiliki alergi terhadap obat-obatan, makanan, komponen vaksin atau lateks ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[2][ya]" value="ya2" {{ @$assesment['2']['ya'] == 'ya2' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[2][tidak]" value="tidak2" {{ @$assesment['2']['tidak'] == 'tidak2' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[2][tidaktahu]" value="tidaktahu2" {{ @$assesment['2']['tidaktahu'] == 'tidaktahu2' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[2][keterangan2]" class="form-control" value="{{ @$assesment['2']['keterangan2'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">3</td>
                  <td>Apakah anda pernah mengalami reaksi alergi berat setelah menerima vaksin ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[3][ya]" value="ya3" {{ @$assesment['3']['ya'] == 'ya3' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[3][tidak]" value="tidak3" {{ @$assesment['3']['tidak'] == 'tidak3' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[3][tidaktahu]" value="tidaktahu3" {{ @$assesment['3']['tidaktahu'] == 'tidaktahu3' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[3][keterangan3]" class="form-control" value="{{ @$assesment['3']['keterangan3'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">4</td>
                  <td>Apakah anda memiliki penyakit kronis terkait jantung, paru-paru, asma, ginjal, penyakit metabolic (diabetes), anemia atau penyakit kelainan darah ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[4][ya]" value="ya4" {{ @$assesment['4']['ya'] == 'ya4' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[4][tidak]" value="tidak4" {{ @$assesment['4']['tidak'] == 'tidak4' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[4][tidaktahu]" value="tidaktahu4" {{ @$assesment['4']['tidaktahu'] == 'tidaktahu4' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[4][keterangan4]" class="form-control" value="{{ @$assesment['4']['keterangan4'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">5</td>
                  <td>Apakah anda menderita kanker, leukemia, HIV?AIDS atau gangguan sistem daya tahan tubuh ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[5][ya]" value="ya5" {{ @$assesment['5']['ya'] == 'ya5' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[5][tidak]" value="tidak5" {{ @$assesment['5']['tidak'] == 'tidak5' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[5][tidaktahu]" value="tidaktahu5" {{ @$assesment['5']['tidaktahu'] == 'tidaktahu5' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[5][keterangan5]" class="form-control" value="{{ @$assesment['5']['keterangan5'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">6</td>
                  <td>Dalam 3 bulan terakhir, apakah anda mendapatkan pengobatan yang melemahkan daya tahan tubuh seperti kortison, prednisone, steroid lainnya atau obat anti kanker atau terapi radiasi ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[6][ya]" value="ya6" {{ @$assesment['6']['ya'] == 'ya6' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[6][tidak]" value="tidak6" {{ @$assesment['6']['tidak'] == 'tidak6' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[6][tidaktahu]" value="tidaktahu6" {{ @$assesment['6']['tidaktahu'] == 'tidaktahu6' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[6][keterangan6]" class="form-control" value="{{ @$assesment['6']['keterangan6'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">7</td>
                  <td>Apakah anda pernah mengalami kejang atau gangguan sistem syaraf lainnya ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[7][ya]" value="ya7" {{ @$assesment['7']['ya'] == 'ya7' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[7][tidak]" value="tidak7" {{ @$assesment['7']['tidak'] == 'tidak7' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[7][tidaktahu]" value="tidaktahu7" {{ @$assesment['7']['tidaktahu'] == 'tidaktahu7' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[7][keterangan7]" class="form-control" value="{{ @$assesment['7']['keterangan7'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">8</td>
                  <td>Apakah anda menerima transfuse darah atau produk darah, atau mendapat terapi imun (gamma) globulin, atau obat antiviral dalam satu tahun terakhir ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[8][ya]" value="ya8" {{ @$assesment['8']['ya'] == 'ya8' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[8][tidak]" value="tidak8" {{ @$assesment['8']['tidak'] == 'tidak8' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[8][tidaktahu]" value="tidaktahu8" {{ @$assesment['8']['tidaktahu'] == 'tidaktahu8' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[8][keterangan8]" class="form-control" value="{{ @$assesment['8']['keterangan8'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">9</td>
                  <td>Apakah anda sedang hamil atau berencana untuk hamil dalam 1 bulan kedepan ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[9][ya]" value="ya9" {{ @$assesment['9']['ya'] == 'ya9' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[9][tidak]" value="tidak9" {{ @$assesment['9']['tidak'] == 'tidak9' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[9][tidaktahu]" value="tidaktahu9" {{ @$assesment['9']['tidaktahu'] == 'tidaktahu9' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[9][keterangan9]" class="form-control" value="{{ @$assesment['9']['keterangan9'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">10</td>
                  <td>Apakah anda mendapatkan vaksinasi dalam 4 minggu terakhir ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[10][ya]" value="ya10" {{ @$assesment['10']['ya'] == 'ya10' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[10][tidak]" value="tidak10" {{ @$assesment['10']['tidak'] == 'tidak10' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[10][tidaktahu]" value="tidaktahu10" {{ @$assesment['10']['tidaktahu'] == 'tidaktahu10' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[10][keterangan10]" class="form-control" value="{{ @$assesment['10']['keterangan10'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">11</td>
                  <td>Apakah anda membawa kartu vaksinasi ?</td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[11][ya]" value="ya11" {{ @$assesment['11']['ya'] == 'ya11' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[11][tidak]" value="tidak11" {{ @$assesment['11']['tidak'] == 'tidak11' ? 'checked' : '' }}>
                  </td>
                  <td style="text-align: center;">
                    <input type="checkbox" name="keterangan[11][tidaktahu]" value="tidaktahu11" {{ @$assesment['11']['tidaktahu'] == 'tidaktahu11' ? 'checked' : '' }}>
                  </td>
                  <td>
                    <input type="text" name="keterangan[11][keterangan11]" class="form-control" value="{{ @$assesment['11']['keterangan11'] }}">
                  </td>
                </tr>
              </tbody>
            </table>
            <div style="text-align: right;">
              <button class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
          <br>
          <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                  <th class="text-center" style="vertical-align: middle;">User</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                </tr>
              </thead>
            <tbody>
              {{-- {{ dd($riwayats) }} --}}
              @if (count($riwayats) == 0)
                  <tr>
                      <td colspan="3" class="text-center">Tidak Ada Riwayat Perencanaan</td>
                  </tr>
              @endif
              @foreach ($riwayats as $riwayat)
                  <tr>
                      <td style="text-align: center; {{ @$riwayat->id == request()->assesment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{@Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i')}}
                      </td>
                      <td style="text-align: center; {{ @$riwayat->id == request()->assesment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_user(@$riwayat->user_id) }}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->assesment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                      </td>
                     
                      <td style="text-align: center; {{ @$riwayat->id == request()->assesment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <a href="{{ URL::current() . '?assesment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="{{ url('emr-soap-print-daftar-tilik-vaksinasi/'.$unit.'/'.$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                          <a href="{{ url("emr-soap-delete/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                            <i class="fa fa-trash"></i>
                          </a>
                      </td>
                  </tr>
              @endforeach
             
            </tbody>
          </table>
          </div>
          

          <br /><br />
        </div>
      </div>
      
    {{-- </form> --}}

  </div>

  @endsection

  @section('script')


  <script type="text/javascript">
  $('.dates').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd/mm/yyyy",
            autoclose: true
            // viewMode: "months", 
            // minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);  
  </script>
  @endsection