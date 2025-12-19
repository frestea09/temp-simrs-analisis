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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/akses_vaskular_hemodialis/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$resume->id) !!}
          <br>

          {{-- Anamnesis --}}
          @php
            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
            if(!@$dataPegawai){
                @$dataPegawai = 1;
            }
          @endphp

          @if (@$dataPegawai == '1')
            <div class="col-md-12">
          
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                    <h5><b>LAPORAN PENGGUNAAN AKSES VASKULAR AV-SHUNT</b></h5>
                    <tr>
                      <td style="font-weight: bold;">1. POSISI AV-SHUNT</td>
                      <td style="padding: 5px;">
                        <textarea rows="3" name="fisik[aksesVaskular][posisiAVShunt]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Posisi AV-Shunt]" class="form-control" >{{ @$assesment['aksesVaskular']['posisiAVShunt'] }}</textarea>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">2. TANGGAL PERTAMA PENGGUNAAN AV-SHUNT</td>
                      <td style="padding: 5px;">
                        <input type="text" style="display: inline-block;" name="fisik[aksesVaskular][tglPertama]" id="" class="form-control" placeholder="" value="{{@$assesment['aksesVaskular']['tglPertama']}}"><br>
                      </td>
                    </tr>
      
                    <tr>
                      <td style="font-weight: bold;">3. KONDISI LUKA OPERASI</td>
                      <td style="padding: 5px;">
                        <input type="text" style="display: inline-block;" name="fisik[aksesVaskular][kondisiLukaOperasi]" id="" class="form-control" placeholder="" value="{{@$assesment['aksesVaskular']['kondisiLukaOperasi']}}"><br>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <label for="" style="font-weight: normal; margin-right: 10px;">a. Bruit</label>
                        <input type="radio" id="bruit1" name="fisik[aksesVaskular][bruit][pilihan]" value="plus" {{@$assesment['aksesVaskular']['bruit']['pilihan'] == 'plus' ? 'checked' : ''}}>
                        <label for="bruit1" style="font-weight: normal;">+</label>
                        <input type="radio" id="bruit2" name="fisik[aksesVaskular][bruit][pilihan]" value="minus" {{@$assesment['aksesVaskular']['bruit']['pilihan'] == 'minus' ? 'checked' : ''}}>
                        <label for="bruit2" style="font-weight: normal;">-</label><br>
      
                        <label for="" style="font-weight: normal; margin-right: 10px;">b</label>
                        <input type="radio" id="b1" name="fisik[aksesVaskular][b][pilihan]" value="besar" {{@$assesment['aksesVaskular']['b']['pilihan'] == 'besar' ? 'checked' : ''}}>
                        <label for="b1" style="font-weight: normal;">Besar</label>
                        <input type="radio" id="b2" name="fisik[aksesVaskular][b][pilihan]" value="kecil" {{@$assesment['aksesVaskular']['b']['pilihan'] == 'kecil' ? 'checked' : ''}}>
                        <label for="b2" style="font-weight: normal;">Kecil</label><br>
      
                        <label for="" style="font-weight: normal; margin-right: 10px;">c. Besar Aliran Darah</label>
                        <input type="text" style="display: inline-block; width: 100px;" name="fisik[aksesVaskular][besarAliranDarah]" id="" class="form-control" placeholder="ml/menit" value="{{@$assesment['aksesVaskular']['besarAliranDarah']}}"><br>
                      </td>
                    </tr>
      
                    <tr>
                      <td style="font-weight: bold;">4. DOKTER PELAKSANA OPERASI AV-SHUNT</td>
                      <td style="padding: 5px;">
                        <label for="" style="font-weight: normal">Dokter :</label>
                          <select name="fisik[aksesVaskular][pelaksanaOperasi][namaDokter]" class="form-control selectpc" id="">
                            <option value="{{ @$assesment['aksesVaskular']['pelaksanaOperasi']['namaDokter'] }}">{{ @$assesment['aksesVaskular']['pelaksanaOperasi']['namaDokter'] }}</option>
                            @foreach ($dokter as $d)
                              <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                            @endforeach
                          </select>
                        <br>
                        <label for="" style="font-weight: normal">Tanggal :</label>
                        <input type="date" name="fisik[aksesVaskular][pelaksanaOperasi][tanggal]" id="" class="form-control" value="{{ @$assesment['aksesVaskular']['pelaksanaOperasi']['tanggal'] }}">
                      </td>
                    </tr>
                  </table>
      
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                    <h5>
                      <b>5. STATUS LOKALIS</b>
                        @if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4')
                        <a href="{{url('/emr-soap/penilaian/gigi/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"></i> Isi Lokalis</a>&nbsp;&nbsp;
                        @elseif(@$reg->poli_id == '15')
                        <a href="{{url('/emr-soap/penilaian/obgyn/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                        @elseif(@$reg->poli_id == '27')
                        <a href="{{url('/emr-soap/penilaian/hemodialisis/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                        @else
                        <a href="{{url('/emr-soap/penilaian/fisik/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                        @endif
                    </h5>
                    <tr>
                      <td><b>Status Lokalis :</b> 
                        
                         @if (@$gambar->image != null)
                          
                         <br>
                          <img src="/images/{{ @$gambar['image'] }}" id="dataImage" style="width: 400px; height:300px;">
                          <br>
                          <label for="">Keterangan Lokalis</label>
                          <br>
                          <ol>
                            <li>{{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][2][3] ? @$ketGambar['keterangan'][2][3] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][3][4] ? @$ketGambar['keterangan'][3][4] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][4][5] ? @$ketGambar['keterangan'][4][5] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][5][6] ? @$ketGambar['keterangan'][5][6] : '-' }} </li>
                          </ol>
                        @else
      
                          -
      
                         @endif
                      
                      </td>
                     </tr>
                    <tr>
                        <td style="padding: 5px;">
                          <textarea rows="3" name="fisik[keterangan_status_lokalis]" style="display:inline-block; resize: vertical;" placeholder="Keterangan Status Lokalis" class="form-control" ></textarea>
                        </td>
                    </tr>
                  </table>
      
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                    <h5><b>6. RIWAYAT LAIN TERKAIT AV-SHUNT</b></h5>
                    <tr>
                        <td style="padding: 5px;" colspan="2">
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][kegagalan][pilihan]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][kegagalan][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['kegagalan']['pilihan'] == 'true' ? 'checked' : ''}}>
                            Kegagalan
                          </label>
                          <label for="" style="font-weight: normal; margin-right: 15px;">, Jam</label>
                          <input type="text" style="width: 100px; display:inline-block" name="fisik[riwayatLain][kegagalan][jam]" id="" class="form-control" placeholder="" value="{{@$assesment['riwayatLain']['kegagalan']['jam']}}">
                          <label for="" style="font-weight: normal">Penyebab</label>
                          <input type="text" style="width: 150px; display:inline-block" name="fisik[riwayatLain][kegagalan][penyebab]" id="" class="form-control" placeholder="" value="{{@$assesment['riwayatLain']['kegagalan']['penyebab']}}">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;" colspan="2">
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][kematian][pilihan]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][kematian][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['kematian']['pilihan'] == 'true' ? 'checked' : ''}}>
                            Kematian AV-Shunt
                          </label>
                          <label for="" style="font-weight: normal; margin-right: 15px;">, Jam</label>
                          <input type="text" style="width: 100px; display:inline-block" name="fisik[riwayatLain][kematian][jam]" id="" class="form-control" placeholder="" value="{{@$assesment['riwayatLain']['kematian']['jam']}}">
                          <label for="" style="font-weight: normal">Penyebab</label>
                          <input type="text" style="width: 150px; display:inline-block" name="fisik[riwayatLain][kematian][penyebab]" id="" class="form-control" placeholder="" value="{{@$assesment['riwayatLain']['kematian']['penyebab']}}">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;" colspan="2">
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][pilihan]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['komplikasi']['pilihan'] == 'true' ? 'checked' : ''}}>
                            Komplikasi :
                          </label>
                          <br>
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][1]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][1]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['komplikasi']['1'] == 'true' ? 'checked' : ''}}>
                            Aneurissma
                          </label>
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][2]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][2]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['komplikasi']['2'] == 'true' ? 'checked' : ''}}>
                            Fenomena Hambatan Aliran Arteri
                          </label>
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][3]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][3]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['komplikasi']['3'] == 'true' ? 'checked' : ''}}>
                            Hipertensi Vena
                          </label>
                          <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][4]" type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][4]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['komplikasi']['4'] == 'true' ? 'checked' : ''}}>
                            Infeksi
                          </label>
                        </td>
                    </tr>
      
                    <tr>
                      <td style="padding: 5px;" colspan="2">
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                          <input class="form-check-input"  name="fisik[riwayatLain][lainnya][pilihan]" type="hidden" value="" id="flexCheckDefault">
                          <input class="form-check-input"  name="fisik[riwayatLain][lainnya][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['riwayatLain']['lainnya']['pilihan'] == 'true' ? 'checked' : ''}}>
                          Lain-Lain (Sebutkan)
                        </label>
                        <input type="text" style="width: 250px; display:inline-block" name="fisik[riwayatLain][lainnya][sebutkan]" id="" class="form-control" placeholder="" value="{{@$assesment['riwayatLain']['lainnya']['sebutkan']}}">
                      </td>
                  </tr>
                  </table>
                  <button type="submit" class="btn btn-success btn-flat">Simpan</button>
            </div>

        </form>

        

          <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                </tr>
              </thead>
            <tbody>
              
              @if (count($riwayats) == 0)
                  <tr>
                      <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                  </tr>
              @else
                @foreach ($riwayats as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli($riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')"><i class="fa fa-trash"></i></a>
                            <a href="{{ url("emr-soap/pemeriksaan/akses_vaskular_hemodialis/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="{{ url("emr-soap-print/cetak-akses-vaskular-hemodialis/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                    </tr>
                    <tr>
                      <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                      </td>
                    </tr>
                @endforeach
              @endif
            </tbody>
          </table>
          </div>
      @endif
          
          <br /><br />
        </div>
      </div>
      

  </div>

    {{-- Modal List Kontrol ======================================================================== --}}
    <div class="modal fade" id="showListKontrol" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">List Kontrol</h4>
              </div>
              <div class="modal-body">
                  <div id="dataListKontrol">
                      <div class="spinner-square">
                          <div class="square-1 square"></div>
                          <div class="square-2 square"></div>
                          <div class="square-3 square"></div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
              </div>
          </div>
      </div>
    </div>
    {{-- End Modal List Kontrol ======================================================================== --}}

  @endsection

  @section('script')

  <script type="text/javascript">
  status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        // $("#date_tanpa_tanggal").datepicker( {
        //     format: "mm-yyyy",
        //     viewMode: "months", 
        //     minViewMode: "months"
        // });
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
            autoclose: true
        });
        $("#date_dengan_tanggal").attr('', true);  
         
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
</script>
  @endsection