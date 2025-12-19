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

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
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
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    /* .rotate {
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      text-align: center;
      vertical-align: middle;
      white-space: nowrap;
    } */

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
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
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .select2-selection__rendered {
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
    <h1>Catatan Intake Output Cairan</h1>
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/catatan-intake-output/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                            @include('emr.modules.addons.tabs')
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                              <h4 style="text-align: center; padding: 10px"><b>Catatan Intake Output</b></h4>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                          <table class='table table-striped table-bordered table-hover table-condensed' >
                              <thead>
                                <tr>
                                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                                </tr>
                                <tr>
                                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                                  <th class="text-center" style="vertical-align: middle;">User</th>
                                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                              @if (count($riwayats) == 0)
                                  <tr>
                                      <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                                  </tr>
                              @endif
                              @foreach ($riwayats as $riwayat)
                                  <tr>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          {{ @$riwayat->user->name }}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                          
                                          <a href="{{ url("emr-soap/pemeriksaan/cetak_catatan_intake_output/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
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
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered table-condensed text-center" style="font-size:15px; width:100%;">
                        <thead>
                          <tr>
                            <th rowspan="3" style="width: 1%;" class="rotate">PUKUL</th>
                            <th rowspan="3" style="width: 5%;" class="rotate">ORAL</th>
                            <th colspan="4">INTAKE</th>
                            <th rowspan="3" class="rotate">TOTAL</th>
                            <th colspan="5">OUTPUT</th>
                          </tr>
                          <tr>
                            <th colspan="2">INFUS &amp; DARAH</th>
                            <th colspan="2">OBAT</th>
                            <th rowspan="2" class="rotate">URINE</th>
                            <th rowspan="2" class="rotate">FAECES</th>
                            <th rowspan="2" class="rotate">MUNTAH/NGT</th>
                            <th rowspan="2" class="rotate">DRAIN/DARAH</th>
                            <th rowspan="2" class="rotate">TOTAL</th>
                            <th rowspan="3" style="width: 15%;" class="rotate">NAMA PETUGAS</th>
                          </tr>
                          <tr>
                            <th style="width: 15%;">NAMA &amp; JUMLAH CAIRAN</th>
                            <th style="width: 5%;">SISA</th>
                            <th style="width: 15%;">NAMA &amp; JUMLAH</th>
                            <th style="width: 5%;">SISA</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            $hours = array_merge(range(7,24), range(1,6));
                          @endphp

                          @foreach($hours as $jam)
                            <tr>
                              <td>{{ $jam }}</td>
                              <td><input type="text" name="fisik[intake][oral][{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['oral'][$jam] }}"></td>
                              <td colspan="2"><input type="text" name="fisik[intake][infus_darah][{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['infus_darah'][$jam] }}"></td>
                              <td colspan="2"><input type="text" name="fisik[intake][obat][{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['obat'][$jam] }}"></td>
                              <td><input type="text" name="fisik[intake][total][{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['total'][$jam] }}"></td>
                              <td><input type="text" name="fisik[output][urine][{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['urine'][$jam] }}"></td>
                              <td><input type="text" name="fisik[output][faeces][{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['faeces'][$jam] }}"></td>
                              <td><input type="text" name="fisik[output][muntah_ngt][{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['muntah_ngt'][$jam] }}"></td>
                              <td><input type="text" name="fisik[output][drain_darah][{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['drain_darah'][$jam] }}"></td>
                              <td><input type="text" name="fisik[output][total][{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['total'][$jam] }}"></td>
                              <td><input type="text" name="fisik[nama_petugas][{{ $jam }}]" class="form-control" value="{{ @$assesment['nama_petugas'][$jam] }}"></td>
                            </tr>

                            {{-- Baris Jml setelah jam 12 & 20 --}}
                            @if(in_array($jam, [12,20]))
                            <tr>
                              <td><b>Jml</b></td>
                              <td><input type="text" name="fisik[intake][oral][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['oral']['jml_'.$jam] }}"></td>
                              <td colspan="2"><input type="text" name="fisik[intake][infus_darah][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['infus_darah']['jml_'.$jam] }}"></td>
                              <td colspan="2"><input type="text" name="fisik[intake][obat][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['obat']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[intake][total][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['intake']['total']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[output][urine][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['urine']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[output][faeces][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['faeces']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[output][muntah_ngt][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['muntah_ngt']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[output][drain_darah][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['drain_darah']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[output][total][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['output']['total']['jml_'.$jam] }}"></td>
                              <td><input type="text" name="fisik[nama_petugas][jml_{{ $jam }}]" class="form-control" value="{{ @$assesment['nama_petugas']['jml_'.$jam] }}"></td>
                            </tr>
                            @endif

                            {{-- Baris Tanggal setelah jam 24 --}}
                            @if($jam == 24)
                            <tr>
                              <td colspan="13"><b>Tanggal:</b> <input type="date" name="fisik[tanggal]" class="form-control" style="display:inline-block; width:auto;" value="{{ @$assesment['tanggal'] }}"></td>
                            </tr>
                            @endif

                            {{-- Baris Total setelah jam 6 --}}
                            @if($jam == 6)
                            <tr>
                              <td><b>Total</b></td>
                              <td><input type="text" name="fisik[intake][oral][total]" class="form-control" value="{{ @$assesment['intake']['oral']['total'] }}"></td>
                              <td colspan="2"><input type="text" name="fisik[intake][infus_darah][total]" class="form-control" value="{{ @$assesment['intake']['infus_darah']['total'] }}"></td>
                              <td colspan="2"><input type="text" name="fisik[intake][obat][total]" class="form-control" value="{{ @$assesment['intake']['obat']['total'] }}"></td>
                              <td><input type="text" name="fisik[intake][total][total]" class="form-control" value="{{ @$assesment['intake']['total']['total'] }}"></td>
                              <td><input type="text" name="fisik[output][urine][total]" class="form-control" value="{{ @$assesment['output']['urine']['total'] }}"></td>
                              <td><input type="text" name="fisik[output][faeces][total]" class="form-control" value="{{ @$assesment['output']['faeces']['total'] }}"></td>
                              <td><input type="text" name="fisik[output][muntah_ngt][total]" class="form-control" value="{{ @$assesment['output']['muntah_ngt']['total'] }}"></td>
                              <td><input type="text" name="fisik[output][drain_darah][total]" class="form-control" value="{{ @$assesment['output']['drain_darah']['total'] }}"></td>
                              <td><input type="text" name="fisik[output][total][total]" class="form-control" value="{{ @$assesment['output']['total']['total'] }}"></td>
                              <td><input type="text" name="fisik[nama_petugas][total]" class="form-control" value="{{ @$assesment['nama_petugas']['total'] }}"></td>
                            </tr>
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    </div>

                    @if (empty(@$assesment))
                      <button class="btn btn-success pull-right">Simpan</button>
                    @else
                      <button class="btn btn-danger pull-right">Perbarui</button>
                    @endif
                </form>
        </div>
    </div>
  </div>  
</div>

@endsection

@section('script')

@endsection
