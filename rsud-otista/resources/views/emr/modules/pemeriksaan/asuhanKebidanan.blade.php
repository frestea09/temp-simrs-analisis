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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanBidan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>

          {{-- Anamnesis --}}
          @php
            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
            if(!@$dataPegawai){
                @$dataPegawai = 1;
            }
          @endphp

          <div class="col-md-12">
                      
            <div class="col-md-6">
              <div class="table-responsive" style="max-height: 550px !important;border:1px solid blue">
                <table class="table table-bordered" id="data" style="font-size: 12px;">
                  @if (count($riwayats) == 0)
                    <tr>
                      <td>Belum Ada Record</td>
                    </tr>
                  @else
                    @foreach ($riwayats as $d)
                      @php
                        $diag = json_decode($d->diagnosis, true);
                        $pemeriksaan = json_decode($d->pemeriksaandalam, true);
                        $fungsional = json_decode($d->fungsional, true);
                        $jam_tindakan  = json_decode(@$d->fisik, true) ?? @$d->fisik;
                      @endphp 
                      <tr style="background-color:#9ad0ef">
                        <th style="width: 50%;">{{@$d->registrasi->reg_id}}</th>
                        <th>
                          {{ @$d->user->name }}
                        </th>
                      </tr>
                      
                      <tr style="background-color:#9ad0ef">
                        <th style="width: 50%;">{{ date('d-m-Y H:i', strtotime(@$d->created_at)) }}</th>
                        <th>
                          {{ @$d->type == "asuhan-keperawatan" ? 'Asuhan Keperawatan' : 'Asuhan Kebidanan' }}
                        </th>
                      </tr>
  
                      <tr>
                        <td colspan="2">
                          <span style="font-weight: bold;">Jam Tindakan :</span>
                          <br>
                          @if ($jam_tindakan)
                              @if (is_array($jam_tindakan))
                                  @foreach ($jam_tindakan as $jam)
                                    @if (!empty($jam))
                                      *{{date('d-m-Y H:i', strtotime($jam))}} <br>
                                    @endif
                                  @endforeach
                              @else
                                {{date('d-m-Y H:i', strtotime($d->fisik))}}
                              @endif
                          @else
                            -
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <span style="font-weight: bold;">Diagnosa :</span>
                          <br>
                          @if (is_array($diag))
                            @foreach ($diag as $diagnosa)
                              *{{ $diagnosa }} <br>
                            @endforeach
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <span style="font-weight: bold;">Intervensi :</span>
                          <br>
                          @if (is_array($pemeriksaan))
                            @foreach ($pemeriksaan as $intervensi)
                              *{{ $intervensi }} <br>
                            @endforeach
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <span style="font-weight: bold;">Implementasi :</span>
                          <br>
                          @if (is_array($fungsional))
                            @foreach ($fungsional as $i)
                              *{{ $i }} <br>
                            @endforeach
                          @endif
                        </td>
                      </tr>
                      @if (Auth::user()->id == $d->user_id)
                        <tr>
                          <td colspan="2">
                            <span class="pull-right">
                              <a href="{{url('emr-askeb/delete/'.$d->id)}}" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');">
                                <i class="fa fa-trash text-danger"></i>
                              </a>
                            </span>
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  @endif
                </table>
              </div>
            </div>

            <div class="col-md-6">
              @include('emr.modules.pemeriksaan.select-askeb')
  
              <div style="text-align: right;">
                <button class="btn btn-success">Simpan</button>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </form>
    @include('emr.modules.pemeriksaan.modal-tte-askeb')
  </div>
</div>

  

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
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);  
         
  </script>

  <script type="text/javascript">
    $('.select2-diagnosis').select2({
        placeholder: "Pilih Diagnosa",
        allowClear: true,
        width: '85%'
    });
    $('.select2-pemeriksaanDalam').select2({
        placeholder: "Pilih Intervensi",
        allowClear: true
    });
    $('.select2-fungsional').select2({
        placeholder: "Pilih Impelemntasi",
        allowClear: true
    });

    $('#select2-diagnosis').change(function(e){
      var intervensi = $('#select2-pemeriksaanDalam');
      var implementasi = $('#select2-fungsional');
      var diagnosa = $(this).val();

      intervensi.empty();
      implementasi.empty();

      $.ajax({
        url: '/emr-get-askep?namaDiagnosa='+diagnosa,
        type: 'get',
        dataType: 'json',
      })
      .done(function(res) {
        if(res[0].metadata.code == 200){
          $.each(res[1], function(index, val){
            intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
          })
          $.each(res[2], function(index, val){
            implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
          })
        }
      })

    });

    $('#historiAskeb').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriAskeb').modal('show');
            $('#dataHistoriAskeb').load("/emr-riwayat-askeb/" + id);
        });

  </script>
@endsection