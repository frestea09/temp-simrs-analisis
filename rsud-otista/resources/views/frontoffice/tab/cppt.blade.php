<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CPPT</title>
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
            <table class='table-striped table-bordered table-hover table-condensed table' id="data">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Tgl. Dibuat</th>
                      <th>Poli / Ruangan</th>
                      <th>Sumber Data</th>
                      <th>Pratinjau</th>
                      <th>TTE Histori Asesmen dan CPPT</th>
                  </tr>
              </thead>
              <tbody>
                {{-- {{dd($resume)}} --}}
                  @php
                      $nomor = 1;
                  @endphp
                  @foreach ($resume as $key => $p)
                      @php
                          $pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $p->user_id)->first();
                      @endphp
                      {{-- {{dd($p->source)}} --}}
                          {{-- @if ($p->source == 'cppt') --}}
                              <tr>
                                  <td>{{ $nomor++  }}</td>
                                  <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                  <td>
                                      @if (@$p->unit == 'inap')
                                      {{ @$p->registrasi->rawat_inap->kamar->nama }}
                                      @elseif (@$p->unit == 'farmasi')
                                      Apotik / Farmasi
                                      @else
                                          @php
                                              $poli = @$p->poli_id ? baca_poli($p->poli_id) : $p->registrasi->poli->nama;
                                          @endphp
                                          {{ strpos($poli, 'IGD') !== false ? " " : "Poli " }} {{ $poli }}
                                      @endif
                                  </td>
                                  <td class="text-center" style="vertical-align: middle;">
                                      @if (@$p->unit == 'farmasi')
                                      <span class="label label-warning">{{strtoupper($p->source)}} - Farmasi</span>
                                      @else
                                      <span class="label {{ @$pegawai->kategori_pegawai == 1 ? 'label-primary' : 'label-warning' }}">{{strtoupper($p->source)}} - {{ @$pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat' }}</span>
                                      @endif
                                  </td>
                                  <td>
                                      <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=cppt" }}"
                                          target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                              class="fa fa-print"></i> </a>
                                  </td>
                                  <td>
                                      {{-- <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=cppt&tte=true" }}"
                                          data-source="cppt"
                                          data-resume-id="{{@$p->id}}"
                                          target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                              class="fa fa-pencil"></i> </button> --}}
                                      @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                          <a href="{{ url('/cetak-tte-eresume-medis/pdf/'. @$p->id) . "?source=cppt" }}"
                                              target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                  class="fa fa-download"></i> </a>
                                      @elseif (!empty($p->tte))
                                          <a href="{{ url('/dokumen_tte/'. @$p->tte) . "?source=cppt" }}"
                                              target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                  class="fa fa-download"></i> </a>
                                      @endif
                                  </td>
                              </tr>
                          {{-- @endif --}}
                  @endforeach
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