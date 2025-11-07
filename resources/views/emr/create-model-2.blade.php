@extends('master')

@section('header')
  <h1>EMR</h1>
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

        <div class="row">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active" style="height: 175px;">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="widget-user-username">Nama</h4>
                                <h5 class="widget-user-desc">No. RM</h5>
                                <h5 class="widget-user-desc">Alamat</h5>
                                <h5 class="widget-user-desc">Cara Bayar</h5>
                                <h5 class="widget-user-desc">DPJP</h5>
                                <h5 class="widget-user-desc">Kunjungan</h5>
                            </div>
                            <div class="col-md-7">
                                <h3 class="widget-user-username">:{{ $reg->pasien->nama}}</h3>
                                <h5 class="widget-user-desc">: {{ $reg->pasien->no_rm }}</h5>
                                <h5 class="widget-user-desc">: {{ $reg->pasien->alamat}}</h5>
                                <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} </h5>
                                <h5 class="widget-user-desc">: {{ baca_dokter($reg->dokter_id)}}</h5>
                                <h5 class="widget-user-desc">: {{ ($reg->jenis_pasien == 1) ? 'Baru' : 'Lama' }}</h5>
                            </div>
                            <div class="col-md-3 text-center">
                                {{--  <h3>Total Tagihan</h3>
                                <h2 style="margin-top: -5px;">Rp. </h2>  --}}
                            </div>
                        </div>
                    </div>
                    <div class="widget-user-image">

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ url('save-emr') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                     
                    
                    <br>
                    <div class="col-md-12"> 


                        <table style="width: 100%"> 
                        <tr>
                            <td><b>Anamnesis</b></td>
                            <td style="padding: 5px;">
                                <textarea name="subject" required></textarea>
                            </td> 
                        </tr>
                        <tr>
                            <td><b>Pmrks.Fisik</b></td>
                            <td style="padding: 5px;">
                                <textarea name="object" required></textarea>
                            </td> 
                        </tr>
                        <tr>
                            <td><b>Pmrks.R</b></td>
                            <td style="padding: 5px;">
                                <textarea name="assesment" required></textarea>
                            </td> 
                        </tr>
                        <tr>
                            <td><b>Diagnosa</b></td>
                            <td style="padding: 5px;">
                                <textarea name="diagnosa" required></textarea>
                            </td> 
                        </tr>
                        <tr>
                            <td><b>Terapi</b></td>
                            <td style="padding: 5px;">
                                <textarea name="tindakan" required></textarea>
                            </td> 
                        </tr>
                        <tr>
                            <td><b>RESEP</b></td>
                            <td style="padding: 5px;">
                                <button type="button" class="btn btn-primary btn-sm btn-flat btn-add-resep" data-id="{{ $d->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm btn-flat btn-history-resep" data-id="{{ $d->id }}"><i class="fa fa-bars" aria-hidden="true"></i></button>
                            </td> 
                        </tr>
                    </table>
                      </div>
                     
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                    </div>
                </form>
                <hr/>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', $reg->id) !!}
                  {!! Form::hidden('cara_bayar', $reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <h3>EMR</h3>
                        <a href="{{ url('cetak-emr/'.$reg->id) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
                        <a href="{{ url('cetak-emr/pdf/'.$reg->id) }}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                        <a href="{{ url('cetak-emr-rencana-kontrol/pdf/'.$reg->id) }}" target="_blank" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i></a>
                        <table class="table table-bordered" id="data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject</th>
                                    <th>Object</th>
                                    <th>Assesment</th>
                                    <th>Planing</th>
                                    <th>Diagnosa</th>
                                    <th>Tindakan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $all_resume as $key_a => $val_a )
                                <tr>
                                    <td>{{ ($key_a + 1) }}</td>
                                    <td>{!! $val_a->subject !!}</td>
                                    <td>{!! $val_a->object !!}</td>
                                    <td>{!! $val_a->assesment !!}</td>
                                    <td>{!! $val_a->planing !!}</td>
                                    <td>{!! $val_a->diagnosa !!}</td>
                                    <td>{!! $val_a->tindakan !!}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-delete-resume-medis" data-id="{{ $val_a->id }}"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="modal fade" id="icd9" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD9</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  
  <div class="modal fade" id="icd10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD10</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>


@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);
        CKEDITOR.replace( 'diagnosa', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            });
        CKEDITOR.replace( 'tindakan', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            });

        CKEDITOR.replace( 'subject', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            });
        CKEDITOR.replace( 'object', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            });

        CKEDITOR.replace( 'assesment', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });
        CKEDITOR.replace( 'planing', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });
        $(document).ready(function(){
            $(document).on('click','.btn-delete-resume-medis',function(){
                let id = $(this).data('id');
                swal({
                    title: "Yakin Akan Dihapus?",
                    text: "Ketika Dihapus, Anda Tidak Bisa Mengembalikan Data Ini!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        callAjax(id);
                    }
                });
            })

            function callAjax(id) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/') }}/emr/"+id,
                    dataType: "JSON",
                    data : { 
                                _token: "{{ csrf_token() }}" 
                            },
                    success: function(res){
                        console.log(res)
                        location.reload();
                    }
                });
            }

            $('#kondisi_akhir').change(function(){
                if ($('#kondisi_akhir').val() === "4" || $('#nokontrol').prop("checked") === true) {
                    $("#rencana_kontrol").val('');
                    $("#rencana_kontrol").attr('required', false);
                    $("#rencana_kontrol").attr('disabled', true);
                } else {
                    $("#rencana_kontrol").attr('required', true);
                    $("#rencana_kontrol").attr('disabled', false);
                }
            });


            $('#nokontrol').click(function(){
                $("#rencana_kontrol").val('');
                if ($('#kondisi_akhir').val() === "4" || $('#nokontrol').prop("checked") === true) {
                    $("#rencana_kontrol").attr('required', false);
                    $("#rencana_kontrol").attr('disabled', true);
                } else {
                    $("#rencana_kontrol").attr('required', true);
                    $("#rencana_kontrol").attr('disabled', false);
                }
            });
        });
    </script>
@endsection
