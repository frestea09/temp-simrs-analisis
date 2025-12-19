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

    .border {
        border: 1px solid black;
    }

    .bold {
        font-weight: bold;
    }

    .p-1 {
        padding: 1rem;
    }
</style>
@section('header')
    <h1>Sertifikat Kematian</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/perencanaan/sertifikat-kematian/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>
                        {{-- Anamnesis --}}
                        <div class="col-md-12">
                            <h5 class="text-center"><b>Sertifikat Kematian</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Nomor</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[nomor]" value="{{@$form['nomor']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tanggal Masuk</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tanggal_masuk]" value="{{@$form['tanggal_masuk']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Jam Masuk</td>
                                    <td style="padding: 5px;">
                                        <input type="time" name="form[jam_masuk]" value="{{@$form['jam_masuk']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tanggal Meninggal</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tanggal_meninggal]" value="{{@$form['tanggal_meninggal']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Jam Meninggal</td>
                                    <td style="padding: 5px;">
                                        <input type="time" name="form[jam_meninggal]" value="{{@$form['jam_meninggal']}}" class="form-control" />
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%;" class="border">
                                <thead>
                                    <tr>
                                        <th class="bold p-1 border text-center" style="width: 5%;">No</th>
                                        <th class="bold p-1 border text-center" style="width: 60%" colspan="2">Penyebab Kematian</th>
                                        <th class="bold p-1 border text-center" style="width: 35%;">Perkiraan Interval Antara Awalnya dan Kematian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-1 border text-center" style="vertical-align: top;" rowspan="3">1</td>
                                        <td class="p-1 border" style="vertical-align: top;">a. Penyakit atau kondisi yang langsung menuju kematian</td>
                                        <td class="p-1 border">
                                            (a) <br>
                                            <input type="text" name="form[penyebab_kematian][1][penyakit]" value="{{@$form['penyebab_kematian']['1']['penyakit']}}" class="form-control" />
                                            <small><i>penyakit atau kondisi tersebut akibat (atau sebagai konsekuensi dari)</i></small>
                                        </td>
                                        <td class="p-1 border">
                                            (a) <br>
                                            <input type="text" name="form[perkiraan_interval][1][penyakit]" value="{{@$form['perkiraan_interval']['1']['penyakit']}}" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-1 border" rowspan="2" style="vertical-align: top;">b. Penyebab pendahulu Kondisi sakit, kalau ada, yang menimbulkan penyebab diatas, dengan meletakkan kondisi dasar paling akhir</td>
                                        <td class="p-1 border">
                                            (b) <br>
                                            <input type="text" name="form[penyebab_kematian][1][penyebab]" value="{{@$form['penyebab_kematian']['1']['penyebab']}}" class="form-control" />
                                            <small><i>penyakit atau kondisi tersebut akibat (atau sebagai konsekuensi dari)</i></small>
                                        </td>
                                        <td class="p-1 border">
                                            (b) <br>
                                            <input type="text" name="form[perkiraan_interval][1][penyebab]" value="{{@$form['perkiraan_interval']['1']['penyebab']}}" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-1 border">
                                            (c) <br>
                                            <input type="text" name="form[penyebab_kematian][1][lainnya]" value="{{@$form['penyebab_kematian']['1']['lainnya']}}" class="form-control" />
                                        </td>
                                        <td class="p-1 border">
                                            (c) <br>
                                            <input type="text" name="form[perkiraan_interval][1][lainnya]" value="{{@$form['perkiraan_interval']['1']['lainnya']}}" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-1 border text-center" style="vertical-align: top;">2</td>
                                        <td class="p-1 border" style="vertical-align: top;">Kondisi penting lain yang ikut menyebabkan kematian, tapi tidak berhubungan dengan penyakit atau kondisi penyebab kematian.</td>
                                        <td class="p-1 border">
                                            (1) <br>
                                            <input type="text" name="form[penyebab_kematian][2][1]" value="{{@$form['penyebab_kematian']['2']['1']}}" class="form-control" />
                                            (2) <br>
                                            <input type="text" name="form[penyebab_kematian][2][2]" value="{{@$form['penyebab_kematian']['2']['2']}}" class="form-control" />
                                            (3) <br>
                                            <input type="text" name="form[penyebab_kematian][2][3]" value="{{@$form['penyebab_kematian']['2']['3']}}" class="form-control" />
                                        </td>
                                        <td class="p-1 border">
                                            (1) <br>
                                            <input type="text" name="form[perkiraan_interval][2][1]" value="{{@$form['perkiraan_interval']['2']['1']}}" class="form-control" />
                                            (2) <br>
                                            <input type="text" name="form[perkiraan_interval][2][2]" value="{{@$form['perkiraan_interval']['2']['2']}}" class="form-control" />
                                            (3) <br>
                                            <input type="text" name="form[perkiraan_interval][2][3]" value="{{@$form['perkiraan_interval']['2']['3']}}" class="form-control" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <br /><br />
                    </div>


                </div>

                @if (!isset($form))
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                @else
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-delete/'.$unit.'/'.$reg->id.'/'.$riwayat->id)}}" class="btn btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>
                        <button class="btn btn-danger proses-tte-sertifikat-kematian" title="TTE" data-kematian-id="{{@$riwayat->id}}"><i class="fa fa-pencil"></i></button>
                        @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                          <a href="{{ url('emr-soap-print-tte-sertifikat-kematian/' . @$reg->id . '/' . @$riwayat->id) }}" target="_blank" class="btn btn-success" title="Hasil TTE"><i class="fa fa-print"></i></a>
                        @endif
                        <a href="{{ url('emr-soap-print-sertifikat-kematian/' . @$reg->id . '/' . @$riwayat->id) }}" target="_blank" class="btn btn-info" title="Pratinjau"><i class="fa fa-eye"></i></a>
                        <button class="btn btn-danger" title="Perbarui"><i class="fa fa-refresh"></i></button>
                    </div>
                @endif
            </form>
            <br />
            <br />

        </div>
    
        </div>
    
    <!-- Modal TTE Sertifikat Kematian-->
<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-sertifikat-kematian" action="{{ url('tte-emr-soap-sertifikat-kematian/' . @$reg->id . '/' . @$riwayat->id) }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE SERTIFIKAT KEMATIAN</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
          <input type="hidden" class="form-control" name="kematian_id" id="kematian_id" disabled>
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
            <input type="password" class="form-control" name="passphrase" id="passphrase">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="button-proses-tte-sertifikat-kematian">Proses TTE</button>
      </div>
    </div>
    </form>

  </div>
</div>
    @endsection

    @section('script')
        <script type="text/javascript">
            //ICD 10
            $('.select2').select2();
            $("input[name='diagnosa_awal']").on('focus', function() {
                $("#dataICD10").DataTable().destroy()
                $("#ICD10").modal('show');
                $('#dataICD10').DataTable({
                    "language": {
                        "url": "/json/pasien.datatable-language.json",
                    },

                    pageLength: 10,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: '/sep/geticd9',
                    columns: [
                        // {data: 'rownum', orderable: false, searchable: false},
                        {
                            data: 'id'
                        },
                        {
                            data: 'nomor'
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'add',
                            searchable: false
                        }
                    ]
                });
            });

            $(document).on('click', '.addICD', function(e) {
                document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
                $('#ICD10').modal('hide');
            });
            $(".skin-red").addClass("sidebar-collapse");
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab
                // alert(target);
            });
            $("#date_tanpa_tanggal").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $("#date_dengan_tanggal").attr('required', true);
        </script>
        <script>
            let key= $('.daftar_terapi').length + 1;
            $('#tambah_terapi').click(function (e) {
                let row = $('#daftar_terapi_template').clone();
                row.removeAttr('id').removeAttr('style');

                row.find('input[name^="form[lembar_observasi]"]').each(function() {
                    let newName = $(this).attr('name').replace(/\d+/, key);
                    $(this).attr('name', newName);
                    $(this).prop('disabled', false);
                });

                key++;
                $('#table_terapi').append(row);
            });
        </script>
        <script>
            // TTE Sertifikat Kematian
            $('.proses-tte-sertifikat-kematian').click(function () {
                const registrasiId = $(this).data("registrasi-id");
                const kematianId = $(this).data("kematian-id");

                // Set nilai input di modal
                $('#registrasi_id_hidden3').val(registrasiId);
                $('#kematian_id').val(kematianId);

                // Tampilkan modal
                $('#myModal3').modal('show');
                return false;

            });

            $('#form-tte-sertifikat-kematian').submit(function (e) {
                e.preventDefault();
                $('input').prop('disabled', false);
                $('#form-tte-sertifikat-kematian')[0].submit();
            })
        </script>
    @endsection
