@extends('master')
@section('header')
  <h1>Lihat Elektronik Klaim BPJS Kesehatan Rawat Inap</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Periode Grouping Berdasarkan Tanggal Pulang Pasien</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'inacbg/lihat-eklaim-irna', 'class' => 'form-horizontal']) !!}
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="col-md-6">
                <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                    </span>
                    {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">s/d Tanggal</button>
                  </span>
                    {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      <hr>
      @if (isset($rekammedis))
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Pasien</th>
                <th class="text-center">No RM</th>
                <th class="text-center">No JKN</th>
                <th class="text-center">Tgl Regist</th>
                <th class="text-center">Tgl Pulang</th>
                <th class="text-center">Pelayanan</th>
                <th class="text-center">Dokter</th>
                <th class="text-center">Cara Bayar</th>
                <th class="text-center">No SEP</th>
                <th class="text-center">Total Rs</th>
                <th class="text-center">Dijamin INACBGs</th>
                <th class="text-center">Kode INACBGs</th>
                <th class="text-center">Hapus dari SIMRS</th>
                <th class="text-center">Dokumen</th>
                <th class="text-center">File Upload</th>
                 <th class="text-center">Cetak E-KLAIM</th> 
              </tr>
            </thead>
            <tbody>
              @foreach ($rekammedis as $key => $d)
              @php
                $doc = \App\DokumenRekamMedis::where('registrasi_id', $d->registrasi_id)->first();
              @endphp
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ baca_pasien($d->pasien_id) }}</td>
                  <td>{{ baca_norm($d->pasien_id) }}</td>
                  <td>{{ $d->no_kartu }}</td>
                  <td>{{ date("d-m-Y", strtotime($d->tgl_masuk)) }}</td>
                  <td>{{ date("d-m-Y", strtotime($d->tgl_keluar)) }}</td>
                  <td>
                    @if (substr($d->status_reg,0,1) == 'J')
                      Rawat Jalan
                    @elseif(substr($d->status_reg,0,1) == 'G')
                      Rawat Darurat
                    @elseif(substr($d->status_reg,0,1) == 'I')
                      Rawat Inap
                    @endif
                  </td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ $d->no_sep }}</td>
                  <td>{{ totalRS($d->registrasi_id) }}</td>
                  <td>{{ totalEklaim($d->registrasi_id) }}</td>
                  <td>{{ kodeInacbgs($d->registrasi_id) }}</td>
                  <td>
                    <a href="{{ url('/inacbg/hapus-eklaim-irna/'.$d->id) }}" class="btn btn-md btn-danger btn-flat"><i class="fa fa-trash"></i></a>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-md btn-primary">Lihat</button>
                      <button type="button" class="btn btn-md btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @if (cekEkpertise($d->registrasi_id))
                        <li><a class="btn btn-md"  target="_blank" href="{{ url('/radiologi/cetak-ekpertise-vedika/'.$d->registrasi_id) }}">Ekspertise</a></li>
                        @else
                        <li><a class="btn btn-md" href="#"><del>Ekspertise</del></a></li>
                        @endif
                        
                        @if (cekLab($d->registrasi_id))
                        <li><a class="btn btn-md"  target="_blank" href="{{ url('/pemeriksaanlab/cetakAll-vedika/'.$d->registrasi_id) }}">Hasil LAB</a></li>
                        @else
                        <li><a class="btn btn-md" href="#"><del>Hasil LAB</del></a></li>
                        @endif
                        
                        @if (cekEcho($d->registrasi_id))
                        <li><a class="btn btn-md"  target="_blank" href="{{ url('/echocardiogram/cetak-echocardiogram/'.$d->registrasi_id) }}"">Echocardiogram</a></li>
                        @else
                        <li><a class="btn btn-md" href="#"><del>Echocardiogram</del></a></li>
                        @endif
                        {{-- <li><a class="btn btn-md"  target="_blank" href="{{ url('/kasir/cetak-verifikasi/'.$d->registrasi_id) }}">Detail Biaya</a></li>
                        <li><a class="btn btn-md" href="#"><del>Detail Biaya</del></a></li> --}}
                        
                        @if (substr($d->status_reg,0,1) == 'I')
                        <li><a class="btn btn-md"  target="_blank" href="{{ url('/spri/'.$d->registrasi_id) }}"> SPRI</a></li>
                        @else
                        <li><a class="btn btn-md" href="#"><del>SPRI</del></a></li>
                        @endif

                        <li><a class="btn btn-md"  target="_blank" href="{{ url('/kasir/cetak-verifikasi/'.$d->registrasi_id) }}">Detail Biaya</a></li>
                        <li><a class="btn btn-md"  target="_blank" href="{{ url('/farmasi/cetak-detail-vedika/'.$d->registrasi_id) }}">Detail Obat</a></li>
                      </ul>
                    </div>
                  </td>
                  <td>
                      <div class="input-group-btn">
                        <a class="btn btn-sm bg-orange btn-flat" onclick="dokumenView({{ $d->registrasi_id }})" >View</a>
                      </div>
                  </td>
                  <td>
                    @if ($d->no_sep <> null)
                    <a href="{{ url('cetak-e-claim/'.$d->no_sep) }}" class="btn btn-md btn-danger btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  {{--  <td>
                    @if ($d->no_sep <> null)
                    <a href="{{ url('frontoffice/e-claim/cetak-full/'.$d->registrasi_id) }}" class="btn btn-md btn-danger btn-flat" target="_blank"><i class="fa fa-print"></i></a>
                    @endif
                  </td>  --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

    </div>
    <div class="box-footer">
    </div>
  </div>


  {{-- view PDF --}}
  <div class="modal fade" id="modalPDF" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
           <embed src="" frameborder="0" width="100%" height="400px">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL SEARCH pasien --}}
  <div class="modal fade" id="searchPasien" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id="dataPasien" class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No. RM</th>
                  <th>Nama Lengkap</th>
                  <th>Alamat</th>
                  <th>Input</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
    
    {{-- view detail --}}
    <div class="modal fade" id="viewDetail">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="my-modal-title"></h4>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th>NO</th>
                  <th id="judul">Nama</th>
                  <th id="judul">Harga</th>
                </tr>
              </thead>
              <tbody id="tabelDetail">
              </tbody>
            </table>
            <table class="table table-bordered table-condensed hidden" id="tableProsedur">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th id="prosedur"></th>
                  </tr>
                </thead>
                <tbody id="tabelDetailProsedur">
                </tbody>
              </table>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>
    {{-- VIEW DOKUMEN --}}
    <div class="modal fade" id="modalViewDocument">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document" style="width: 80%; height: 80%;">
        <div class="modal-content">
          <div class="modal-header bg-green-gradient">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"></h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-teal-gradient">
                    <thead>
                    <tr>
                        <th id="judulRadiologi"></th>
                    </tr>
                    </thead>
                    <tbody id="tabelRadiologi">
                    </tbody>
                </table>
              </div>
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-black-gradient">
                  <thead>
                  <tr>
                      <th id="judulLab"></th>
                  </tr>
                  </thead>
                  <tbody id="tabelLab">
                  </tbody>
              </table>
              </div>
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-danger">
                  <thead>
                  <tr>
                      <th id="judulResum"></th>
                  </tr>
                  </thead>
                  <tbody id="tabelResum">
                  </tbody>
              </table>
              </div>
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-fuchsia">
                  <thead>
                  <tr>
                      <th id="judulOpersi"></th>
                  </tr>
                  </thead>
                  <tbody id="tabelOpersi">
                  </tbody>
              </table>
              </div>
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-green">
                    <thead>
                    <tr>
                        <th id="judulPathway"></th>
                    </tr>
                    </thead>
                    <tbody id="tabelPathway">
                    </tbody>
                </table>
              </div>
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-gray">
                    <thead>
                    <tr>
                        <th id="judulEkg"></th>
                    </tr>
                    </thead>
                    <tbody id="tabelEkg">
                    </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <table class="table table-bordered table-condensed bg-maroon-gradient">
                    <thead>
                    <tr>
                        <th id="judulEchocardiograms"></th>
                    </tr>
                    </thead>
                    <tbody id="tabelEchocardiograms">
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    {{-- VIEW DOKUMEN --}}
    <div class="modal fade" id="modalDocument">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <h4 class="title"></h4>
            <img src="" class="img img img-responsive">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">

  function viewPDF(registrasi_id) {
    // alert(registrasi_id +' '+ nama )
      $('#modalPDF').modal('show')
      $('.modal-title').text('View Dokumen '+nama)
        if (nama == 'ekspertise') {
          $('embed').attr('src', '/radiologi/cetak-ekpertise/'+registrasi_id);
        } else if (nama == 'laboratorium'){
          $('embed').attr('src', '/pemeriksaanlab/cetakAll-vedika/'+registrasi_id);
        } else if (nama == 'biaya'){
          $('embed').attr('src', '/kasir/cetak-verifikasi/'+registrasi_id);
        } else if (nama == 'echocardiogram'){
          $('embed').attr('src', '/echocardiogram/cetak-echocardiogram/'+registrasi_id);
        } else if (nama == 'spri'){
          $('embed').attr('src', '/spri/'+registrasi_id);
        }else if (nama == 'obat'){
          $('embed').attr('src', '/farmasi/cetak-detail-vedika/'+registrasi_id);
        }
  }

  function dokumenView(registrasi_id) {
    $('#modalViewDocument').modal({
        backdrop: 'static',
        keyboard : false,
    })
    $('.modal-title').text('View Dokumen Upload')
    $.ajax({
      url: '/frontoffice/laporanrekammedis/viewdokumen/'+registrasi_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('#tabelRadiologi').empty()
      $('#judulRadiologi').text('Radiologi')
      $.each(json.radiologi, function(index, val){
        $('#tabelRadiologi').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarRadiologi('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
      $('#tabelLab').empty()
      $('#judulLab').text('Laboratorium')
      $.each(json.laboratorium, function(index, val){
        $('#tabelLab').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarLaboratorium('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
      $('#tabelResum').empty()
      $('#judulResum').text('Resum Medis')
      $.each(json.resummedis, function(index, val){
        $('#tabelResum').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarResummedis('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
      $('#tabelOpersi').empty()
      $('#judulOpersi').text('Operasi')
      $.each(json.operasi, function(index, val){
        $('#tabelOpersi').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarOperasi('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
      $('#tabelPathway').empty()
      $('#judulPathway').text('Pathway')
      $.each(json.pathway, function(index, val){
        $('#tabelPathway').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarPathway('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
      $('#tabelEkg').empty()
      $('#judulEkg').text('Ekg')
      $.each(json.ekg, function(index, val){
        $('#tabelEkg').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarEkg('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
      $('#tabelEchocardiograms').empty()
      $('#judulEchocardiograms').text('Echocardiogram')
      $.each(json.echo, function(index, val){
        $('#tabelEchocardiograms').append('<tr><td><button class="btn btn-sm btn-flat btn-info" onclick="viewGambarEchocardiograms('+val.id+')"><i class="fa fa-folder-o"></i></button></td></tr>')
      })
    });
  }

  function viewGambarRadiologi(id) {
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
          if(json.pdfradiologi == 'pdf') {
            $('#modalDocument').modal('hide')
            window.open("{{ url('dokumen_rekammedis') }}/"+json.data.radiologi,"Rincian Biaya", width=300,height=300)
          } else {
            $('#modalDocument').modal('show')
            $('.modal-title').text('View dokumen Radiologi')
            $('img').attr('src', '/dokumen_rekammedis/'+json.data.radiologi);
          }
        }
      });
    }

    function viewGambarLaboratorium(id) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen Laboratorium')
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            if(json.pdflaboratorium == 'pdf') {
              $('#modalDocument').modal('hide')
              window.open("{{ url('dokumen_rekammedis') }}/"+json.data.laboratorium,"Rincian Biaya", width=300,height=300)
            } else {
              $('#modalDocument').modal('show')
              $('.modal-title').text('View dokumen Laboratorium')
              $('img').attr('src', '/dokumen_rekammedis/'+json.data.laboratorium);
            }
          }
        });
    }

    function viewGambarResummedis(id) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen Resummedis')
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
          if(json.pdfresummedis == 'pdf') {
            $('#modalDocument').modal('hide')
            window.open("{{ url('dokumen_rekammedis') }}/"+json.data.resummedis,"Rincian Biaya", width=300,height=300)
          } else {
            $('#modalDocument').modal('show')
            $('.modal-title').text('View dokumen Resummedis')
            $('img').attr('src', '/dokumen_rekammedis/'+json.data.resummedis);
          }
        }
      });
    }

    function viewGambarOperasi(id) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen Operasi')
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
          if(json.pdfoperasi == 'pdf') {
            $('#modalDocument').modal('hide')
            window.open("{{ url('dokumen_rekammedis') }}/"+json.data.operasi,"Rincian Biaya", width=300,height=300)
          } else {
            $('#modalDocument').modal('show')
            $('.modal-title').text('View dokumen Operasi')
            $('img').attr('src', '/dokumen_rekammedis/'+json.data.operasi);
          }
        }
      });
    }

    function viewGambarPathway(id) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen Pathway')
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
          if(json.pdfpathway == 'pdf') {
            $('#modalDocument').modal('hide')
            window.open("{{ url('dokumen_rekammedis') }}/"+json.data.pathway,"Rincian Biaya", width=300,height=300)
          } else {
            $('#modalDocument').modal('show')
            $('.modal-title').text('View dokumen Pathway')
            $('img').attr('src', '/dokumen_rekammedis/'+json.data.pathway);
          }
        }
      });
    }

    function viewGambarEkg(id) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen Ekg')
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
          if(json.pdfekg == 'pdf') {
            $('#modalDocument').modal('hide')
            window.open("{{ url('dokumen_rekammedis') }}/"+json.data.ekg,"Rincian Biaya", width=300,height=300)
          } else {
            $('#modalDocument').modal('show')
            $('.modal-title').text('View dokumen Ekg')
            $('img').attr('src', '/dokumen_rekammedis/'+json.data.ekg);
          }
        }
      });
    }

    function viewGambarEchocardiograms(id) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen Echocardiograms')
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
          if(json.pdfecho == 'pdf') {
            $('#modalDocument').modal('hide')
            window.open("{{ url('dokumen_rekammedis') }}/"+json.data.echo,"Rincian Biaya", width=300,height=300)
          } else {
            $('#modalDocument').modal('show')
            $('.modal-title').text('View dokumen Echocardiograms')
            $('img').attr('src', '/dokumen_rekammedis/'+json.data.echo);
          }
        }
      });
    }

  $(document).ready(function() {
    if($('select[name="jenis_pasien"]').val() == 1) {
      $('select[name="tipe_jkn"]').removeAttr('disabled');
    } else {
      $('select[name="tipe_jkn"]').attr('disabled', true);
    }

    $('select[name="jenis_pasien"]').on('change', function () {
      if ($(this).val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }
    });

    //SEARCH PASIEN
    $('#openModal').on('click', function () {
      $("#dataPasien").DataTable().destroy();
      $('#searchPasien').modal('show');
      $('.modal-title').text('Cari Pasien');
      $('#dataPasien').DataTable({
          "language": {
              "url": "/json/pasien.datatable-language.json",
          },

          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
          ordering: false,
          ajax: '/frontoffice/lap-rekammedis/datapasien',
          columns: [
              {data: 'no_rm'},
              {data: 'nama'},
              {data: 'alamat'},
              {data: 'input', searchable: false},
          ]
      });
    });

    $(document).on('click', '.inputPasien', function (e) {
      $('input[name="nama"]').val($(this).attr('data-nama'));
      $('input[name="no_rm"]').val($(this).attr('data-no_rm'));
      $('input[name="pasien_id"]').val($(this).attr('data-pasien_id'));
      $('#searchPasien').modal('hide');
    });

    $('input[name="nama"]').on('keyup', function () {
      if ( $('input[name="nama"]').val() == '' ) {
        $('input[name="no_rm"]').val('');
        $('input[name="pasien_id"]').val('');
      }
    });

  });

  function viewDetailTindakan(registrasi_id) {
    $('#viewDetail').modal('show')
    $('#judul').text('Tindakan')
    $('#tableProsedur').addClass('hidden')
    $('.modal-title').text('View Dokumen '+nama)
    $.ajax({
      url: '/frontoffice/laporanrekammedis/tindakan/'+registrasi_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('#tabelDetail').html('');
      var total = 0;
      $.each(json, function(index, val){
        $('#tabelDetail').append('<tr><td class="text-center">'+(index + 1)+'</td><td>'+val.namatarif+'</td><td class="text-right">Rp. '+val.total+'</td></tr>')
        total += val.total;
      })
      $('#tabelDetail').append('<tr><td class="text-center">#</td><td><b>Total</b></td><td class="text-right"><b>Rp. '+total+'</b></td></tr>');
    });
  }

  function viewDetailObat(registrasi_id) {
    $('#viewDetail').modal('show')
    $('#judul').text('Resep')
    $('#tableProsedur').addClass('hidden')
    $('.modal-title').text('View Dokumen '+nama)
    $.ajax({
      url: '/frontoffice/laporanrekammedis/obat/'+registrasi_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('#tabelDetail').html('');
      var total = 0;
      $.each(json, function(index, val){
        $('#tabelDetail').append('<tr><td class="text-center">'+(index + 1)+'</td><td>'+val.nama+'</td><td class="text-right">Rp. '+val.jumlah * val.hargajual+'</td></tr>');
        total += val.jumlah * val.hargajual;
      })
      $('#tabelDetail').append('<tr><td class="text-center">#</td><td><b>Total</b></td><td class="text-right"><b>Rp. '+total+'</b></td></tr>');
    });
  }

  function viewDetailDiagnosa(registrasi_id) {
    $('#viewDetail').modal('show')
    $('#judul').text('Diagnosa')
    $('#prosedur').text('Prosedur')
    $('#tableProsedur').removeClass('hidden')
    $('.modal-title').text('View Dokumen '+nama)
    $.ajax({
      url: '/frontoffice/laporanrekammedis/diagnosa/'+registrasi_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('#tabelDetail').empty()
      $.each(json.diagnosa, function(index, val){
        $('#tabelDetail').append('<tr><td>'+(index + 1)+'</td><td>'+val.nama+'</td></tr>')
      })
      $('#tabelDetailProsedur').empty()
      $.each(json.prosedur, function(index, val){
        $('#tabelDetailProsedur').append('<tr><td>'+(index + 1)+'</td><td>'+val.nama+'</td></tr>')
      })
    });
  }

  function viewDetailRagiologi(registrasi_id) {
    $('#viewDetail').modal('show')
    $('#judul').text('Radiologi')
    $('#tableProsedur').addClass('hidden')
    $('.modal-title').text('View Dokumen '+nama)
    $.ajax({
      url: '/frontoffice/laporanrekammedis/radiologi/'+registrasi_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('#tabelDetail').empty()
      $.each(json, function(index, val){
        $('#tabelDetail').append('<tr><td>'+(index + 1)+'</td><td>'+val.ekspertise+'</td></tr>')
      })
    });
  }

  function detailBiaya(registrasi_id){
    window.open("{{ url('kasir/cetak-verifikasi') }}/"+registrasi_id,"Rincian Biaya", width=300,height=300)
  }
</script>
@endsection
