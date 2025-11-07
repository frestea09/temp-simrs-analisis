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

    .border {
        border: 1px solid black;
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

    tr, td {
        padding: 1rem !important;
        text-align: center;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .bold {
        font-weight: bold;
    }
    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    .xsmall {
        font-size: 12px;
    }
</style>
@section('header')
  <h1>Laporan Form Lepasan Obat<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
       
        <div class="box-body">
            <form action="{{ url('farmasi/form-lepasan-obat') }}" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          <label for="periode" class="col-sm-3 control-label">Periode</label>
                          <div class="col-sm-4 {{ $errors->has('tgl_awal') ? 'has-error' :'' }}">
                              <input type="text" autocomplete="off" id="tgl_awal" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('d-m-Y') }}" class="form-control datepicker">
                          </div>
                          <div class="col-sm-1 text-center">
                              s/d
                          </div>
                          <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                              <input type="text"  autocomplete="off" id="tgl_akhir" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('d-m-Y') }}" class="form-control datepicker">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-2"> 
                      <div class="form-group">
                          <div class="col-sm-4 col-sm-offset-3">
                              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="VIEW">
                              <!-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL"> -->
                          </div>
                      </div>
                  </div>
                
                </div>
            </form>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
          <h4>Formulir Penelusuran Obat (Assesmen IGD)</h4>
        </div>
        <div class="box-body">
            
          <div class='table-responsive'>
            <table class='table-striped table-bordered table-hover table-condensed table' id="tableRekonsiliasi">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pasien</th>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Frekuensi</th>
                        <th>Alasan Makan Obat</th>
                        <th>Obat Dilanjutkan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
            </table>
          </div>
          <hr>
          <div class='table-responsive'>
            <table class='table-striped table-bordered table-hover table-condensed table' id="tableAlergi">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pasien</th>
                        <th>Nama Obat Yang Menimbulkan Alergi</th>
                        <th>Tingkat Alergi</th>
                        <th>Reaksi Alergi</th>
                    </tr>
                </thead>
            </table>
          </div>

        </div>
    </div>

    <div class="box box-success">
        <div class="box-header with-border">
          <h4>Formulir Daftar Pemberian Terapi</h4>
        </div>
        <div class="box-body">
            
          <div class="col-md-12" style="overflow: auto;">
            <table style="width: 120%" class="border" style="font-size:12px;">
                <tr class="border">
                    <td class="border bold" rowspan="3">NO</td>
                    <td class="border bold" rowspan="3">NAMA PASIEN</td>
                    <td class="border bold" rowspan="3">NAMA OBAT</td>
                    <td class="border bold" rowspan="3">CARA DAN FREKUENSI</td>
                    <td class="border bold" colspan="17">TANGGAL</td>
                    <td class="border bold" rowspan="3">KET</td>
                </tr>
                <tr class="border">
                    <td class="border bold" rowspan="2">WAKTU/PETUGAS</td>
                    <td class="border" colspan="4">
                      TANGGAL I
                    </td>
                    <td class="border" colspan="4">
                      TANGGAL II
                    </td>
                    <td class="border" colspan="4">
                      TANGGAL III
                    </td>
                    <td class="border" colspan="4">
                      TANGGAL IV
                    </td>
                </tr>
                <tr class="border">
                    <td class="border bold">I</td>
                    <td class="border bold">II</td>
                    <td class="border bold">III</td>
                    <td class="border bold">IV</td>
                    <td class="border bold">I</td>
                    <td class="border bold">II</td>
                    <td class="border bold">III</td>
                    <td class="border bold">IV</td>
                    <td class="border bold">I</td>
                    <td class="border bold">II</td>
                    <td class="border bold">III</td>
                    <td class="border bold">IV</td>
                    <td class="border bold">I</td>
                    <td class="border bold">II</td>
                    <td class="border bold">III</td>
                    <td class="border bold">IV</td>
                </tr>

                @php $no = 1; @endphp
                @if (@$data_terapi)
                    @foreach ($data_terapi as $i=>$terapi)

                        @if (@$terapi['pemberian_terapi'][$i+1]['nama_obat'])
                            <tr class="border">
                                <td class="border  bold" rowspan="2">{{$no++}}<x/td>
                                <td class="border" rowspan="2">
                                    {{@$terapi['nama_pasien']}}
                                </td>
                                <td class="border" rowspan="2">
                                    {{@$terapi['pemberian_terapi'][$i+1]['nama_obat']}}
                                </td>
                                <td class="border" rowspan="2">
                                    {{@$terapi['pemberian_terapi'][$i+1]['frekuensi_pemberian']}}
                                </td>
                                <td class="border bold">TANGGAL & JAM</td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['1'])
                                        {{@$terapi['tanggal_1']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['1']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['2'])
                                        {{@$terapi['tanggal_1']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['2']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['3'])
                                        {{@$terapi['tanggal_1']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['3']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['4'])
                                        {{@$terapi['tanggal_1']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['jam']['4']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['1'])
                                        {{@$terapi['tanggal_2']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['1']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['2'])
                                        {{@$terapi['tanggal_2']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['2']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['3'])
                                        {{@$terapi['tanggal_2']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['3']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['4'])
                                        {{@$terapi['tanggal_2']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['jam']['4']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['1'])
                                        {{@$terapi['tanggal_3']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['1']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['2'])
                                        {{@$terapi['tanggal_3']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['2']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['3'])
                                        {{@$terapi['tanggal_3']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['3']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['4'])
                                        {{@$terapi['tanggal_3']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['jam']['4']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['1'])
                                        {{@$terapi['tanggal_4']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['1']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['2'])
                                        {{@$terapi['tanggal_4']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['2']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['3'])
                                        {{@$terapi['tanggal_4']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['3']}}
                                    @endif
                                </td>
                                <td class="border xsmall">
                                    @if (@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['4'])
                                        {{@$terapi['tanggal_4']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['jam']['4']}}
                                    @endif
                                </td>
                                <td rowspan="2">
                                    {{@$terapi['tanggal_4']['tanggal']}} <br> {{@$terapi['pemberian_terapi'][$i+1]['keterangan']}}
                                </td>
                            </tr>

                            <tr class="border">
                                <td class="border bold">NAMA</td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['nama']['1']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['nama']['2']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['nama']['3']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_1']['nama']['4']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['nama']['1']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['nama']['2']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['nama']['3']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_2']['nama']['4']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['nama']['1']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['nama']['2']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['nama']['3']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_3']['nama']['4']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['nama']['1']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['nama']['2']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['nama']['3']}}
                                </td>
                                <td class="border">
                                    {{@$terapi['pemberian_terapi'][$i+1]['tanggal_4']['nama']['4']}}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                  @else
                      <tr>
                          <td colspan="22" style="text-align: center">Tidak Ada Data</td>
                      </tr>
                  @endif
            </table>
          </div>
          
        </div>
    </div>
    
    <div class="box box-success">
        <div class="box-header with-border">
          <h4>Formulir Edukasi Pasien Dan Keluarga</h4>
        </div>
        <div class="box-body">
            

        </div>
    </div>
    

@endsection

@section('script')
  <script type="text/javascript">
    $(".skin-blue").addClass("sidebar-collapse");

    $(function() {
        let tgl_awal = $('#tgl_awal').val();
        let tgl_akhir = $('#tgl_akhir').val();

        $('#tableRekonsiliasi').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },
            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/farmasi/get-lepasan-rekonsiliasi/'+tgl_awal+'/'+tgl_akhir,
            columns: [
                {data: 'nomor', orderable: false, searchable: false},
                {data: 'nama_pasien', orderable: true, searchable: true},
                {data: 'nama_obat', orderable: true, searchable: true},
                {data: 'dosis', orderable: false},
                {data: 'frekuensi', orderable: false},
                {data: 'alasan_makan', orderable: false},
                {data: 'obat_dilanjutkan', orderable: false, searchable: false},
                {data: 'tanggal', orderable: true, searchable: false},
            ]
        });

        $('#tableAlergi').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },
            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/farmasi/get-lepasan-obatalergi/'+tgl_awal+'/'+tgl_akhir,
            columns: [
                {data: 'nomor', orderable: false, searchable: false},
                {data: 'nama_pasien', orderable: true, searchable: true},
                {data: 'nama_obat', orderable: true, searchable: true},
                {data: 'tingkat_alergi', orderable: true},
                {data: 'reaksi_alergi', orderable: true},
                {data: 'tanggal', orderable: true, searchable: true},
            ]
        });
    });
      


  </script>
@endsection
