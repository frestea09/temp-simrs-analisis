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
    <h1>Lembar Kendali Regimen Kemoterapi</h1>
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/lembar-kendali-regimen/' . $unit . '/' . $reg->id) }}"
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
                              <h4 style="text-align: center; padding: 10px"><b>Lembar Kendali Regimen</b></h4>
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
                                          
                                          <a href="{{ url("emr-soap/pemeriksaan/cetak_lembar_kendali_regimen/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
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
                      <h4 style="text-align: center;"><b>JADWAL KEMOTERAPI</b></h4>
                      <table class="table table-striped table-bordered table-hover table-condensed text-center" style="font-size:15px; width:100%;">
                        <tr>
                          <td>SIKLUS KE</td>
                          <td colspan="2"><input type="text" name="fisik[siklus1]" class="form-control" value="{{ @$assesment['siklus1'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[siklus2]" class="form-control" value="{{ @$assesment['siklus2'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[siklus3]" class="form-control" value="{{ @$assesment['siklus3'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[siklus4]" class="form-control" value="{{ @$assesment['siklus4'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[siklus5]" class="form-control" value="{{ @$assesment['siklus5'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[siklus6]" class="form-control" value="{{ @$assesment['siklus6'] }}"></td>
                        </tr>
                        <tr>
                          <td>HARI KE</td>
                          <td colspan="2"><input type="text" name="fisik[hari1]" class="form-control" value="{{ @$assesment['hari1'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[hari2]" class="form-control" value="{{ @$assesment['hari2'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[hari3]" class="form-control" value="{{ @$assesment['hari3'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[hari4]" class="form-control" value="{{ @$assesment['hari4'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[hari5]" class="form-control" value="{{ @$assesment['hari5'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[hari6]" class="form-control" value="{{ @$assesment['hari6'] }}"></td>
                        </tr>
                        <tr>
                          <td>TANGGAL</td>
                          <td colspan="2"><input type="date" name="fisik[tgl1]" class="form-control" value="{{ @$assesment['tgl1'] }}"></td>
                          <td colspan="2"><input type="date" name="fisik[tgl2]" class="form-control" value="{{ @$assesment['tgl2'] }}"></td>
                          <td colspan="2"><input type="date" name="fisik[tgl3]" class="form-control" value="{{ @$assesment['tgl3'] }}"></td>
                          <td colspan="2"><input type="date" name="fisik[tgl4]" class="form-control" value="{{ @$assesment['tgl4'] }}"></td>
                          <td colspan="2"><input type="date" name="fisik[tgl5]" class="form-control" value="{{ @$assesment['tgl5'] }}"></td>
                          <td colspan="2"><input type="date" name="fisik[tgl6]" class="form-control" value="{{ @$assesment['tgl6'] }}"></td>
                        </tr>
                        <tr>
                          <td>BERAT BADAN</td>
                          <td colspan="2"><input type="text" name="fisik[berat1]" class="form-control" value="{{ @$assesment['berat1'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[berat2]" class="form-control" value="{{ @$assesment['berat2'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[berat3]" class="form-control" value="{{ @$assesment['berat3'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[berat4]" class="form-control" value="{{ @$assesment['berat4'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[berat5]" class="form-control" value="{{ @$assesment['berat5'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[berat6]" class="form-control" value="{{ @$assesment['berat6'] }}"></td>
                        </tr>
                        <tr>
                          <td>LUAS PERMUKAAN TUBUH</td>
                          <td colspan="2"><input type="text" name="fisik[luasPermukaan1]" class="form-control" value="{{ @$assesment['luasPermukaan1'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[luasPermukaan2]" class="form-control" value="{{ @$assesment['luasPermukaan2'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[luasPermukaan3]" class="form-control" value="{{ @$assesment['luasPermukaan3'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[luasPermukaan4]" class="form-control" value="{{ @$assesment['luasPermukaan4'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[luasPermukaan5]" class="form-control" value="{{ @$assesment['luasPermukaan5'] }}"></td>
                          <td colspan="2"><input type="text" name="fisik[luasPermukaan6]" class="form-control" value="{{ @$assesment['luasPermukaan6'] }}"></td>
                        </tr>
                        <tr>
                          <td>NAMA OBAT</td>
                          <td>Dosis</td>
                          <td>Sediaan</td>
                          <td>Dosis</td>
                          <td>Sediaan</td>
                          <td>Dosis</td>
                          <td>Sediaan</td>
                          <td>Dosis</td>
                          <td>Sediaan</td>
                          <td>Dosis</td>
                          <td>Sediaan</td>
                          <td>Dosis</td>
                          <td>Sediaan</td>
                        </tr>
                        @for ($row = 1; $row <= 7; $row++)
                        <tr>
                          <td><input type="text" name="fisik[namaObat][{{ $row }}]" class="form-control" value="{{ @$assesment['namaObat'][$row] }}"></td>
                          <td><input type="text" name="fisik[dosis1][{{ $row }}]" class="form-control" value="{{ @$assesment['dosis1'][$row] }}"></td>
                          <td><input type="text" name="fisik[sediaan1][{{ $row }}]" class="form-control" value="{{ @$assesment['sediaan1'][$row] }}"></td>
                          <td><input type="text" name="fisik[dosis2][{{ $row }}]" class="form-control" value="{{ @$assesment['dosis2'][$row] }}"></td>
                          <td><input type="text" name="fisik[sediaan2][{{ $row }}]" class="form-control" value="{{ @$assesment['sediaan2'][$row] }}"></td>
                          <td><input type="text" name="fisik[dosis3][{{ $row }}]" class="form-control" value="{{ @$assesment['dosis3'][$row] }}"></td>
                          <td><input type="text" name="fisik[sediaan3][{{ $row }}]" class="form-control" value="{{ @$assesment['sediaan3'][$row] }}"></td>
                          <td><input type="text" name="fisik[dosis4][{{ $row }}]" class="form-control" value="{{ @$assesment['dosis4'][$row] }}"></td>
                          <td><input type="text" name="fisik[sediaan4][{{ $row }}]" class="form-control" value="{{ @$assesment['sediaan4'][$row] }}"></td>
                          <td><input type="text" name="fisik[dosis5][{{ $row }}]" class="form-control" value="{{ @$assesment['dosis5'][$row] }}"></td>
                          <td><input type="text" name="fisik[sediaan5][{{ $row }}]" class="form-control" value="{{ @$assesment['sediaan5'][$row] }}"></td>
                          <td><input type="text" name="fisik[dosis6][{{ $row }}]" class="form-control" value="{{ @$assesment['dosis6'][$row] }}"></td>
                          <td><input type="text" name="fisik[sediaan6][{{ $row }}]" class="form-control" value="{{ @$assesment['sediaan6'][$row] }}"></td>
                        </tr>
                        @endfor
                        <tr>
                          <td>KETERANGAN</td>
                          <td colspan="9">
                            <textarea name="fisik[keterangan]" rows="6" style="width: 100%; box-sizing: border-box;">{{@$assesment['keterangan']}}</textarea>
                          </td>
                        </tr>
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
