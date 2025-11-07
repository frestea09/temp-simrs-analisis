<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RESEP</title>
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
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th style="width: 80px;">No</th>
                  <th>Resep</th>
                </tr>
                @if (count($penjualan) > 0)
                  @foreach ($penjualan as $key=>$p)
                  <tr>
                    <td>{{$key+1}}</td>
                    {{-- <td><a href="{{ count($p->eresep) > 0 ? url('copy-resep/cetak-resep-dokter/'.$p->id) : url('copy-resep/cetak-detail-resep-farmasi/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a> - <small>{{date('d-m-Y',strtotime($p->created_at))}} {!! count($p->eresep) > 0 ? '<span style="color: red">(E-Resep)</span>' : '' !!}</small></td> --}}
                    <td><a href="{{url('copy-resep/cetak-detail-resep-farmasi/'.$p->id)}}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a><small> - {{date('d-m-Y', strtotime($p->created_at))}}</small></td>
                  </tr>
                  @endforeach
                @else
                <tr>
                  <td colspan="2"><i>Maaf Belum Ada Resep</i></td>
                </tr>
                @endif

              </tbody>
            </table>
          </div>
          <button class="pull-right btn btn-default" onclick="window.close()">TUTUP</button>

          <div id="dataDetail"> </div>

      </div>



      </form>

    </div>
  </div>
</body>
</html>