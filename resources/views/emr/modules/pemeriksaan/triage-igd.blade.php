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
</style>
@section('header')
    <h1>Assesmen</h1>
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

            <div class="row">
                <div class="col-md-12">
                    @include('emr.modules.addons.tabs')
                </div>
                <br>

                {{-- ASSESMENT --}}
                @php
                    @$dataPegawai = @Auth::user()->pegawai->kategori_pegawai;
                    if (!@$dataPegawai) {
                        @$dataPegawai = 1;
                    }
                @endphp



                <div class="col-md-12" style="margin-top: 20px">
                    <div class="panel box box-primary">
                        <div>
                            {{-- Histori --}}
                            <div class="col-md-12" style="padding-top: 40px">
                                <table class='table-striped table-bordered table-hover table-condensed table'>
                                    <thead>
                                        <tr>
                                            <th class="text-center" colspan="2" style="vertical-align: middle;">Riwayat
                                                Asesmen</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                                            <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $poli = isset($_GET['poli']) ? $_GET['poli'] : '';
                                            $dpjp = isset($_GET['dpjp']) ? $_GET['dpjp'] : '';
                                        @endphp

                                        @if (count($riwayats) == 0)
                                            <tr>
                                                <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                                            </tr>
                                        @endif
                                        @foreach ($riwayats as $riwayat)
                                            <tr>
                                                <td
                                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                    {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                                </td>
                                                <td
                                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                    <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id . '&poli=' . $poli . '&dpjp=' . $dpjp . '#Asessment' }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="/cetak-triage-igd/pdf/{{ $registrasi_id }}/{{ $riwayat->id }}"
                                                        target="_blank" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                    @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                                                        <a href="/emr-soap-file-tte/{{ $riwayat->id }}/Triage"
                                                            target="_blank" class="btn btn-success btn-sm">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-success btn-sm btn-flat" onclick="showTTEModal({{$riwayat->id}})"><i class="fa fa-pencil"></i></button>
                                                    @endif
                                                    <a href="{{ url('emr-soap-hapus-pemeriksaan/' . $unit . '/' . @$riwayat->registrasi_id . '/' . @$riwayat->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                                @include('emr.modules.pemeriksaan.modul.igd-triage')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

      {{-- Modal TTE Triage--}}
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-triage" action="" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE Triage</h4>
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
        var url = document.location.toString();
        if (url.match('#')) {
            $('#' + url.split('#')[1]).addClass('in');
        }

        $(".skin-red").addClass("sidebar-collapse");
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href") // activated tab
            // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);

        function showTTEModal(triage_id) {
            $('#form-tte-triage').attr('action', '/emr-soap/tte/tte-triage/'+triage_id)
            $('#myModal').modal('show');
        }

        function prosesTTE() {
            $('input').prop('disabled', false)
            $('#form-tte-triage').submit();
        }
    </script>

    {{-- ICD 10 --}}
@endsection
