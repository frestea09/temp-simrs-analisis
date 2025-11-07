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
</style>
@section('header')
    <h1>Persetujuan Pasien/Keluarga Terhadap Tindakan</h1>
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
            <form method="POST" action="{{ url('emr-soap/perencanaan/inap/persetujuan-tindakan/' . $unit . '/' . $reg->id) }}"
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
                        <div class="col-md-6">
                            <h5><b>Surat Pernyataan Persetujuan Pasien/Keluarga Terhadap Tindakan</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:20%;">Pemasangan Infus</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_pemasangan_infus]" value="" class="form-control" />
                                        <input type="text" name="form[pemasangan_infus]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Pemasangan Dower Cathether</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_pemasangan_dower_cathether]" value="" class="form-control" />
                                        <input type="text" name="form[pemasangan_dower_cathether]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Tindakan Restrain (Pengikatan)</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_tindakan_restrain]" value="" class="form-control" />
                                        <input type="text" name="form[tindakan_restrain]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Tes Untuk Antibiotik</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_test_antibiotik]" value="" class="form-control" />
                                        <input type="text" name="form[test_antibiotik]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Pemberian Suntikan/Injeksi</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_injeksi]" value="" class="form-control" />
                                        <input type="text" name="form[injeksi]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Pemasangan NGT</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_pemasangan_ngt]" value="" class="form-control" />
                                        <input type="text" name="form[pemasangan_ngt]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Pemasangan OGT</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_pemasangan_ogt]" value="" class="form-control" />
                                        <input type="text" name="form[pemasangan_ogt]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Pemasangan Bodao</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_pemasangan_bidai]" value="" class="form-control" />
                                        <input type="text" name="form[pemasangan_bidai]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Suction Nasofaring</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_suction_nasofaring]" value="" class="form-control" />
                                        <input type="text" name="form[suction_nasofaring]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Penjahitan Luka Derajat Ringan</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tgl_penjahitan_luka_derajat]" value="" class="form-control" />
                                        <input type="text" name="form[penjahitan_luka_derajat]" placeholder="Isi Informasi" value="" class="form-control" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Riwayat Surat Persetujuan Pasien/Keluarga Terhadap Tindakan</b></h5>
                                </div>
                                <div class="box-body table-responsive" style="max-height: 400px">
                                    <table style="width: 100%"
                                        class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                        style="font-size:12px;">
                                        @if (count($riwayat) == 0)
                                            <tr>
                                                <td><i>Belum ada riwayat</i></td>
                                            </tr>
                                        @endif
                                        @foreach ($riwayat as $item)
                                            <tr>
                                                <td>
                                                    {{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}
                                                    <span class="pull-right" style="font-size: 20px">
                                                        <a target="_blank"
                                                            href="{{ url('emr-soap-print-surat-persetujuan-tindakan/' . $unit . '/' . $reg->id . '/' . $item->id) }}"
                                                            data-toggle="tooltip" title="Cetak Surat"><i
                                                                class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                        <br /><br />
                    </div>


                </div>

                <div class="col-md-12 text-right">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
            <br />
            <br />
            {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key => $item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}

        </div>

        {{-- Modal Upload Surat Rujukan FKTP --}}
        <div class="modal fade" id="modalUploadPAPS" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" >Upload PAPS</h4>
                    </div>
                    <div class="modal-body" > 
                        <form action="/emr-soap-upload-surat-paps" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id">
                            <div class="form-group" style="padding: 0;">
                                <div class="col-sm-12" style="padding: 0;">
                                    <label for="file">Pilih file</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="margin-top: 2rem;">Simpan</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    </div>
                </div>
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
            function showUploadFKTP(id) {
                $('#modalUploadPAPS').modal('show')
                $('#id').val(id)
            }
        </script>
    @endsection
