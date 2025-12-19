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

  input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
input[type="time"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
</style>
@section('header')
<h1>Fisik</h1>
@endsection

@section('content')
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/resiko-jatuh-dewasa-inap/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          
          <div class="col-md-12" style="padding-top: 40px">

            <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                    <th class="text-center" style="vertical-align: middle;">User</th>
                  </tr>
                </thead>
              <tbody>
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                    </tr>
                @endif
                @foreach ($riwayats as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                        </td>
                        {{-- @if ( $riwayat->id == request()->asessment_id )
                            <td style="text-align: center; background-color:rgb(172, 247, 162)">
                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                            </td>
                        @else
                            <td style="text-align: center;">
                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                            </td>
                        @endif --}}
                       
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_user($riwayat->user_id) }}
                            {{-- <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}
                            {{-- <a href="{{ url('tarif/') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                        </td>
                    </tr>
                @endforeach
               
              </tbody>
            </table>
           
          </div>

          {{-- Anamnesis --}}
          <h4 class="text-center"><b>SKALA JATUH MORSE UNTUK DEWASA</b></h4>
          <div class="col-md-12">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <thead>
                <tr>
                  <th class="text-center" style="width: 35%;">PARAMETER</th>
                  <th class="text-center" style="width: 35%;">KEADAAN</th>
                  <th class="text-center" style="width: 30%;">SKOR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="2">Riwayat jatuh (baru-baru ini atau dalam 3 bulan terakhir)</td>
                  <td>Tidak Pernah <b>(0 Skor)</b></td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa" name="fisik[skala][riwayatJatuh]" value="{{ @$asessment['skala']['riwayatJatuh'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa()">
                  </td>
                </tr>
                <tr>
                  <td>Pernah <b>(25 Skor)</b></td>
                </tr>

                <tr>
                  <td rowspan="2">Penyakit penyerta (diagnosis sekunder)</td>
                  <td>Ada <b>(15 Skor)</b></td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa" name="fisik[skala][penyakitPenyerta]" value="{{ @$asessment['skala']['penyakitPenyerta'] }}" placeholder="mis: 0" onblur="totalResikoJatuhDewasa()">
                  </td>
                </tr>
                <tr>
                  <td>Tidak Ada <b>(0 Skor)</b></td>
                </tr>

                <tr>
                  <td rowspan="3">Alat Bantu Jalan</td>
                  <td>Tanpa Alat Bantu <b>(0 Skor)</b></td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa" name="fisik[skala][alatBantuJalan]" value="{{ @$asessment['skala']['alatBantuJalan'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa()">
                  </td>
                </tr>
                <tr>
                  <td>Tongkat Penyangga (crutch), Walker <b>(15 Skor)</b></td>
                </tr>
                <tr>
                  <td>Kursi Roda <b>(30 Skor)</b></td>
                </tr>

                <tr>
                  <td rowspan="2">Pemakaian Infus intravena / Heparin</td>
                  <td>Ya <b>(20 Skor)</b></td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa" name="fisik[skala][pemakaianInfus]" value="{{ @$asessment['skala']['pemakaianInfus'] }}" placeholder="mis: 0" onblur="totalResikoJatuhDewasa()">
                  </td>
                </tr>
                <tr>
                  <td>Tidak <b>(0 Skor)</b></td>
                </tr>

                <tr>
                  <td rowspan="3">Cara Berjalan</td>
                  <td>Normal <b>(0 Skor)</b></td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa" name="fisik[skala][caraBerjalan]" value="{{ @$asessment['skala']['caraBerjalan'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa()">
                  </td>
                </tr>
                <tr>
                  <td>Lemah <b>(10 Skor)</b></td>
                </tr>
                <tr>
                  <td>Terganggu <b>(20 Skor)</b></td>
                </tr>

                <tr>
                  <td rowspan="2">Status Mental</td>
                  <td>Menyadari Kelemahannya <b>(0 Skor)</b></td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa" name="fisik[skala][statusMental]" value="{{ @$asessment['skala']['statusMental'] }}" placeholder="mis: 0" onblur="totalResikoJatuhDewasa()">
                  </td>
                </tr>
                <tr>
                  <td>Tidak Menyadari Kelemahannya <b>(15 Skor)</b></td>
                </tr>
              </tbody>
            </table>

            <table style="width: 50%; margin: auto;" class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <tr>
                <td style="font-weight: bold;">Skor Resiko Jatuh</td>
                <td>
                  <input type="text" class="form-control" id="skorResikoJatuhId" name="fisik[skala][total][skor]" value="{{ @$asessment['skala']['total']['skor'] }}" readonly>
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">Tingkat</td>
                <td>
                  <input type="text" class="form-control" id="tingkatResikoJatuhId" name="fisik[skala][total][tingkat]" value="{{ @$asessment['skala']['total']['tingkat'] }}" readonly>
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">Tindakan</td>
                <td>
                  <input type="text" class="form-control" id="tindakanResikoJatuhId" name="fisik[skala][total][tindakan]" value="{{ @$asessment['skala']['total']['tindakan'] }}" readonly>
                </td>
              </tr>
            </table>

          </div>
 
          <br /><br />
        </div>
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
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
        $("#date_dengan_tanggal").attr('', true);  
         
  </script>
   <script>

    function totalResikoJatuhDewasa(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId').value = tot;
      if(tot <= 24){
        document.getElementById('tingkatResikoJatuhId').value = "Resiko Rendah";
        document.getElementById('tindakanResikoJatuhId').value = "Tidak Ada Tindakan";
      }else if(tot >=25 && tot <=44){
        document.getElementById('tingkatResikoJatuhId').value = "Resiko Sedang";
        document.getElementById('tindakanResikoJatuhId').value = "Pencegahan Jatuh Standar";
      }else if(tot >= 45){
        document.getElementById('tingkatResikoJatuhId').value = "Resiko Tinggi";
        document.getElementById('tindakanResikoJatuhId').value = "Pencegahan Jatuh Resiko Tinggi";
      }
    }
    </script>
  @endsection