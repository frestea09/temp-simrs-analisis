<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SURAT KONTROL</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet"
    href="{{ asset('style') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet"
    href="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/select2/dist/css/select2.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
  {{-- default
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css"> --}}
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-yellow.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-red.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.min.css') }}">
  {{--
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/timepicker/bootstrap-timepicker.min.css">
</head>

<body class="hold-transition skin-red sidebar-mini">


  <div class="box box-primary">

    <div class="box-body">
      <div style="margin-top:20px;margin-left:10px;margin-right:10px;">
        <form method="POST" id="formRetur">
          {{ csrf_field() }} {{ method_field('POST') }}
          <input type="hidden" name="registrasi_id" value="">
          <input type="hidden" name="cara_bayar_id" value="">
          <input type="hidden" name="pasien_id" value="">
          <input type="hidden" name="dokter_id" value="">
          <input type="hidden" name="poli_id" value="">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th style="width: 25%">No. RM</th>
                  <td class="no_rm">{{@$reg->pasien->no_rm}}</td>
                </tr>
                <tr>
                  <th>Nama Pasien</th>
                  <td class="no_rm">{{@$reg->pasien->nama}}</td>
                </tr>

              </tbody>
            </table>
            <br />
            @php
              $unit = 'Jalan';
                if (substr($reg->status_reg, 0, 1) == 'J') {
									$unit = 'Jalan';
								} elseif (substr($reg->status_reg, 0, 1) == 'G') {
									$unit = 'Darurat';
								} elseif (substr($reg->status_reg, 0, 1) == 'I') {
									$unit = 'Inap';
								}
            @endphp
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th style="width: 80px;">No</th>
                  <th>Lihat Hasil</th>
                </tr>
                @if (count($rencanaKontrol) > 0)
                  @foreach ($rencanaKontrol as $key=>$p)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td><a target="_blank" href="{{url('/cetak-rencana-kontrol/'.$p->id)}}">{{ $p->no_surat_kontrol }}</a></td>
                  </tr>
                  @endforeach
                @else
                <tr>
                  <td colspan="2"><i>Maaf Belum Ada Rencana Kontrol</i></td>
                </tr>
                @endif

              </tbody>
            </table>
          </div>

          <div id="dataDetail"> </div>
          <button class="pull-right btn btn-default" onclick="window.close()">TUTUP</button>
      </div>



      </form>

    </div>
  </div>
</body>

</html>