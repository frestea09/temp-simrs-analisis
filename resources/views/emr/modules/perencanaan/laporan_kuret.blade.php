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
    <h1>Laporan Kuret</h1>
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
            <form method="POST" action="{{ url('emr-soap/perencanaan/inap/laporan-kuret/' . $unit . '/' . $reg->id) }}"
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
                            <h5 class="text-center"><b>Laporan Kuret</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Tanggal</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[tanggal]" value="{{@$form['tanggal']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Jam</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[jam]" value="{{@$form['jam']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Anestesi</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[anestesi]" value="{{@$form['anestesi']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Operator</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[operator]" value="{{@$form['operator']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Asisten</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[asisten]" value="{{@$form['asisten']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Penderita dilakukan dalam posisi lithotomi setelah dilakukan tindakan dan antiseptik didaerah vulva dan sekitarnya dipasang Speculum bawah yang dipegang asisten.</p></td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Dengan pertolongan speculum atas, bibir depan portio dijepit dengan rongeltang, sonde masukan sedalam</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" style="display: flex">
                                            <input type="text" name="form[sonde_masukan_sedalam]" value="{{@$form['sonde_masukan_sedalam']}}" class="form-control" />
                                            <button type="button" class="btn btn-default">cm</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Dilatasi dengan diiatator</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[dilatasi_diiatator][pilihan]"
                                                {{ @$form['dilatasi_diiatator']['pilihan'] == 'Tidak dilakukan' ? 'checked' : '' }}
                                                type="radio" value="Tidak dilakukan">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak dilakukan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[dilatasi_diiatator][pilihan]"
                                                {{ @$form['dilatasi_diiatator']['pilihan'] == 'Dilakukan' ? 'checked' : '' }}
                                                type="radio" value="Dilakukan">
                                            <label class="form-check-label" style="font-weight: 400;">Dilakukan,</label>
                                            <span>Hegar No :</span>
                                            <input type="text" name="form[dilatasi_diiatator][hegar_no]" style="display:inline-block;" class="form-control" id="" value="{{@$form['dilatasi_diiatator']['hegar_no']}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[jenis][pilihan]"
                                                {{ @$form['jenis']['pilihan'] == 'Corpus uteri ante' ? 'checked' : '' }}
                                                type="radio" value="Corpus uteri ante">
                                            <label class="form-check-label" style="font-weight: 400;">Corpus uteri ante</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[jenis][pilihan]"
                                                {{ @$form['jenis']['pilihan'] == 'Retropileksi' ? 'checked' : '' }}
                                                type="radio" value="Retropileksi">
                                            <label class="form-check-label" style="font-weight: 400;">Retropileksi</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pengeluaran jaringan dengan cunam abortus</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pengeluaran_jaringan][pilihan]"
                                                {{ @$form['pengeluaran_jaringan']['pilihan'] == 'Tidak dilakukan' ? 'checked' : '' }}
                                                type="radio" value="Tidak dilakukan">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak dilakukan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pengeluaran_jaringan][pilihan]"
                                                {{ @$form['pengeluaran_jaringan']['pilihan'] == 'Dilakukan' ? 'checked' : '' }}
                                                type="radio" value="Dilakukan">
                                            <label class="form-check-label" style="font-weight: 400;">Dilakukan</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Dilakukan Curretage secara sistematis dan hati-hati sampai cavum uteri bersih dengan curet no</td>
                                    <td style="padding: 5px;">
                                            <input type="text" name="form[curretage][curet_no]" style="display:inline-block;" class="form-control" id="" value="{{@$form['curretage']['curet_no']}}">
                                            <br><span>Berhasil dikeluarkan jaringan</span>
                                            <input type="text" name="form[curretage][berhasil_dikeluarkan_jaringan]" style="display:inline-block;" class="form-control" id="" value="{{@$form['curretage']['berhasil_dikeluarkan_jaringan']}}">
                                            <br><span>Sebanyak (Gr)</span>
                                            <input type="text" name="form[curretage][sebanyak]" style="display:inline-block;" class="form-control" id="" value="{{@$form['curretage']['sebanyak']}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Jumlah pendarahan sebanyak</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" style="display: flex">
                                            <input type="text" name="form[jumlah_pendarahan]" value="{{@$form['jumlah_pendarahan']}}" class="form-control" />
                                            <button type="button" class="btn btn-default">cc</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pemasangan IUD</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pemasangan_iud][pilihan]"
                                                {{ @$form['pemasangan_iud']['pilihan'] == 'Tidak dilakukan' ? 'checked' : '' }}
                                                type="radio" value="Tidak dilakukan">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak dilakukan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pemasangan_iud][pilihan]"
                                                {{ @$form['pemasangan_iud']['pilihan'] == 'Dilakukan' ? 'checked' : '' }}
                                                type="radio" value="Dilakukan">
                                            <label class="form-check-label" style="font-weight: 400;">Dilakukan</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">D / Precurretage</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" style="display: flex">
                                            <input type="text" name="form[d_precurretage]" value="{{@$form['d_precurretage']}}" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">D / Postcurretage</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" style="display: flex">
                                            <input type="text" name="form[d_postcurretage]" value="{{@$form['d_postcurretage']}}" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Keadaan O.S Post Curretage</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <span>KU</span> <br>
                                            <input type="text" name="form[keadaan_post_curretage][ku]" value="{{@$form['keadaan_post_curretage']['ku']}}" class="form-control" />
                                        </div>
                                        <div>
                                            <span>T</span> <br>
                                            <input type="text" name="form[keadaan_post_curretage][t]" value="{{@$form['keadaan_post_curretage']['t']}}" class="form-control" />
                                        </div>
                                        <div>
                                            <span>R</span> <br>
                                            <input type="text" name="form[keadaan_post_curretage][r]" value="{{@$form['keadaan_post_curretage']['r']}}" class="form-control" />
                                        </div>
                                        <div>
                                            <span>N</span> <br>
                                            <input type="text" name="form[keadaan_post_curretage][n]" value="{{@$form['keadaan_post_curretage']['n']}}" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Therapi post curretage</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" style="display: flex">
                                            <input type="text" name="form[therapi_post_curretage]" value="{{@$form['therapi_post_curretage']}}" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Catatan</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" style="display: flex">
                                            <input type="text" name="form[catatan]" value="{{@$form['catatan']}}" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
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
                    <button class="btn btn-danger">Perbarui</button>
                    <a href="{{url('emr-soap/pemeriksaan/cetak_laporan_kuret' . '/' . $reg->id)}}" class="btn btn-warning">Cetak</a>
                {{-- </div>
                <div class="col-md-12 text-right" style="margin-top: 2rem;">  --}}
                    <button type="button" class="btn btn-flat btn-info proses-tte" title="TTE" data-id="{{@$riwayat->id}}" data-url="{{ url('emr-soap-print-surat-rujukan/'.$reg->id.'/'.$riwayat->id) }}">TTE</button>
                    @if (!empty($riwayat->tte))
                        <a href="{{url('/dokumen_tte/'.$riwayat->tte)}}" class="btn btn-flat btn-xs btn-info" target="_blank">Cetak File TTE</a>
                    @endif 
                @endif
            </form>
            <br />
            <br />

        </div>
    
        </div>
        <!-- Modal TTE SPRI-->
<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-sertifikat-kematian" action="{{ url('tte-emr-soap-laporan-kuret/' . @$reg->id . '/' . @$riwayat->id) }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE SERTIFIKAT KEMATIAN</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
          <input type="hidden" class="form-control" name="record_id" id="record_id" disabled>
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
        <button type="submit" class="btn btn-primary" id="button-proses-tte-sertifikat">Proses TTE</button>
      </div>
    </div>
    </form>

  </div>
</div>
    @endsection

    @section('script')
    
        <script type="text/javascript">
         $('.proses-tte').click(function () {
            $('#form-tte').attr('action', $(this).data("url"));
                $('#myModal').modal('show');
                
            })

            $('#form-tte').submit(function (e) {
                e.preventDefault();
                $('input').prop('disabled', false);
                $('#form-tte')[0].submit();
            })

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
            $('.proses-tte').click(function () {
                const registrasiId = $(this).data("registrasi-id");
                const kematianId = $(this).data("id");

                // Set nilai input di modal
                $('#registrasi_id_hidden3').val(registrasiId);
                $('#record_id').val(kematianId);

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
