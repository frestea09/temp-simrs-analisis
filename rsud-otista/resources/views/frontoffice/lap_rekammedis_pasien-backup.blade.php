@extends('master')
@section('header')
  <h1>Vedika - Elektronik Klaim BPJS Kesehatan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/rekammedis-pasien', 'class' => 'form-horizontal']) !!}
        {{--  {!! Form::hidden('pasien_id', null) !!}  --}}
        <div class="row">
          <div class="col-sm-6">
            {{--  <div class="form-group">
                {!! Form::label('nama', 'Nama Pasien', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                  <div class="input-group">
                      {!! Form::text('nama', null, ['class' => 'form-control', 'onchange'=>'this.form.submit()']) !!}
                      <span class="input-group-btn">
                        <button type="button" id="openModal" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
                      </span>
                  </div>
                </div>
            </div>  --}}
            {{--  <div class="form-group">
                {!! Form::label('nama', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('no_rm', null, ['class' => 'form-control', 'readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                </div>
            </div>  --}}
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
          <div class="col-sm-6">
          </div>
        </div>

      {!! Form::close() !!}
      <hr>

      @if (isset($rekammedis))
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>No RM</th>
                <th>No JKN</th>
                <th>Tanggal</th>
                <th>Pelayanan</th>
                <th>Dokter</th>
                <th>Klinik</th>
                <th>Cara Bayar</th>
                <th>No SEP</th>
                {{-- <th>Subjective</th>
                <th>Objective</th>
                <th>Assesment</th>
                <th>Planning</th> --}}
                <th>Tindakan</th>
                <th>Resep</th>
                <th>Diagnosa</th>
                <th>Ekspertise</th>
                <th>Lab</th>
                <th>Opr</th>
                <th>Resume</th>
                <th>Pathway</th>
                <th>Biaya Rs</th>
                <th>Gruping INACBGs</th>
                <th>Cetak</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rekammedis as $key => $d)
              @php
                $doc = \App\DokumenRekamMedis::where('registrasi_id', $d->id)->first();
              @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->no_jkn }}</td>
                  <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
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
                  <td>
                    @if (substr($d->status_reg,0,1) == 'I')
                    @php
                      $irna = \App\Rawatinap::where('registrasi_id', $d->id)->first();
                    @endphp
                      {{ $irna ? baca_kamar($irna->kamar_id) : 'Salah Status...!, Bukan Rawat Inap' }}
                    @else
                      {{ $d->poli->nama }}
                    @endif
                  </td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ $d->no_sep }}</td>
                 {{--  <td></td>
                  <td></td>
                  <td></td>
                  <td></td> --}}
                  <td>
                    <ul>
                      <button class="btn btn-sm btn-flat btn-primary" onclick="viewDetailTindakan({{ $d->id }}, 'Tindakan')"> Tindakan</button>
                    </ul>
                  </td>
                  <td>
                    <ul>
                    <button class="btn btn-sm btn-flat btn-danger" onclick="viewDetailObat({{ $d->id }}, 'Resep')">Resep</button>
                    </ul>
                  </td>
                  <td>
                    <ul>
                    <button class="btn btn-sm btn-flat btn-success" onclick="viewDetailDiagnosa({{ $d->id }}, 'Diagnosa')">Diagnosa</button>
                    </ul>
                  </td>
                  <td>
                      @if (cek_ekspertise($d->id) >= 1)
                          <a href="{{ url('radiologi/cetakRincianRad/irj/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                      @endif
                  </td>
                  <td>
                    @if (cek_leb($d->id) >= 1)
                      <a href="{{ url('pemeriksaanlab/cetakAll/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  <td>
                    @isset ($doc->operasi)
                        <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen({{ $d->id }}, 'operasi')"><i class="fa fa-folder-o"></i></button>
                    @endisset
                  </td>
                  <td>
                    @isset ($doc->resummedis)
                        <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen({{ $d->id }}, 'resummedis')"><i class="fa fa-folder-o"></i></button>
                    @endisset
                  </td>
                  <td>
                    @isset ($doc->pathway)
                        <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen({{ $d->id }}, 'pathway')"><i class="fa fa-folder-o"></i></button>
                    @endisset
                  </td>
                  <td>
                      <button class="btn btn-sm btn-flat btn-primary" onclick="detailBiaya({{ $d->id }})"><i class="fa fa-print"></i></button>
                  </td>
                  
                  <td>
                    @if ($d->no_sep <> null)
                    <a href="{{ url('frontoffice/e-claim/cetak-eklaim/'.$d->no_sep) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  <td>
                    @if ($d->no_sep <> null)
                    <a href="{{ url('frontoffice/e-claim/cetak-full/'.$d->id) }}" class="btn btn-sm btn-danger btn-flat" target="_blank"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
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
    
  {{-- VIEW DOKUMEN --}}
    <div class="modal fade" id="modalDocument">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"></h3>
          </div>
          <div class="modal-body">
            <img src="" class="img img img-responsive">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
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
                  <th id="judul"></th>
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
@endsection

@section('script')
<script type="text/javascript">
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

  function viewDetailTindakan(registrasi_id, nama) {
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
      $('#tabelDetail').empty()
      $.each(json, function(index, val){
        $('#tabelDetail').append('<tr><td>'+(index + 1)+'</td><td>'+val.namatarif+'</td></tr>')
      })
    });
  }

  function viewDetailObat(registrasi_id, nama) {
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
      $('#tabelDetail').empty()
      $.each(json, function(index, val){
        $('#tabelDetail').append('<tr><td>'+(index + 1)+'</td><td>'+val.nama+'</td></tr>')
      })
    });
  }

  function viewDetailDiagnosa(registrasi_id, nama) {
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

  function viewDetailRagiologi(registrasi_id, nama) {
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

  function viewDokumen(registrasi_id, nama) {
    //alert(registrasi_id +' '+ nama )
      $('#modalDocument').modal('show')
      $('.modal-title').text('View Dokumen '+nama)
      $.ajax({
        url: '/frontoffice/viewDokument/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        if (nama == 'radiologi') {
          $('img').attr('src', '/dokumen_rekammedis/'+json.radiologi);
        } else if (nama == 'laboratorium'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.laboratorium);
        } else if (nama == 'resummedis'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.resummedis);
        } else if (nama == 'operasi'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.operasi);
        } else if (nama == 'pathway'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.pathway);
        }
      });
  }

  function detailBiaya(registrasi_id){
    window.open("{{ url('kasir/cetak-verifikasi') }}/"+registrasi_id,"Rincian Biaya", width=600,height=300)
  }
</script>
@endsection
