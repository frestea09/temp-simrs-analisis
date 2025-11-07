@extends('master')

@section('header')
  <h1>Costing</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Upload Dokument
      </h3>
    </div>
    <div class="box-body">
      <h5>Data Registrasi</h5>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <tbody>
            <tr>
              <th>No. RM</th>
              <td>{{ $pasien->no_rm }}</td>
            </tr>
            <tr>
              <th>Nama Pasien</th>
              <td>{{ $pasien->nama }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <h5>Upload Dokument</h5>
          <form action="{{ url('frontoffice/saveuploadDokument') }}" id="formDokument" class="form-horizontal" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
            <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

            <div class="form-group">
              <label for="radiologi" class="col-sm-4 control-label">Hasil Radiologi</label>
              <div class="col-sm-8">
                <input type="file" name="radiologi" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="lab" class="col-sm-4 control-label">Hasil Laboratorium</label>
              <div class="col-sm-8">
                <input type="file" name="lab" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="resum" class="col-sm-4 control-label">Hasil Resume Medis</label>
              <div class="col-sm-8">
                <input type="file" name="resum" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="operasi" class="col-sm-4 control-label">Operasi & Anestesi</label>
              <div class="col-sm-8">
                <input type="file" name="operasi" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="pathway" class="col-sm-4 control-label">Klinikal Pathway</label>
              <div class="col-sm-8">
                <input type="file" name="pathway" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="ekg" class="col-sm-4 control-label">EKG</label>
              <div class="col-sm-8">
                <input type="file" name="ekg" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="echo" class="col-sm-4 control-label">Echocardiograms</label>
              <div class="col-sm-8">
                <input type="file" name="echo" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="submit" class="col-sm-4 control-label">&nbsp;</label>
              <div class="col-sm-8">
                <button type="submit" class="btn btn-primary btn-flat">UPLOAD</button>
              </div>
            </div>
          </form>
        </div>

        <div class="col-sm-6">
          <h5>Status Dokumen</h5>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Dokument</th>
                  <th class="text-center">View</th>
                  <th class="text-center">Hapus</th>
                  <th class="text-center">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Hasil Radiologi</td>
                  <td class="text-center">
                    @isset ($doc->radiologi)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('radiologi')"><i class="fa fa-folder-o"></i></button> --}}
                        @if (substr($doc->radiologi,-3) == 'pdf')
                          <a href="{{ url('dokumen_rekammedis/'.$doc->radiologi) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                        @else
                          <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'radiologi')"><i class="fa fa-folder-o"></i></button>
                        @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->radiologi))
                      <a href="{{ url('frontoffice/hapus-file-radiologi/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->radiologi) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Hasil Laboratorium</td>
                  <td class="text-center">
                    @isset ($doc->laboratorium)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('laboratorium')"><i class="fa fa-folder-o"></i></button> --}}
                          @if (substr($doc->laboratorium,-3) == 'pdf')
                            <a href="{{ url('dokumen_rekammedis/'.$doc->laboratorium) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                          @else
                            <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'laboratorium')"><i class="fa fa-folder-o"></i></button>
                          @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->laboratorium))
                      <a href="{{ url('frontoffice/hapus-file-laboratorium/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->laboratorium) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Laporan Resum Medis</td>
                  <td class="text-center">
                    @isset ($doc->resummedis)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('resummedis')"><i class="fa fa-folder-o"></i></button> --}}
                        @if (substr($doc->resummedis,-3) == 'pdf')
                          <a href="{{ url('dokumen_rekammedis/'.$doc->resummedis) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                        @else
                          <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'resummedis')"><i class="fa fa-folder-o"></i></button>
                        @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->resummedis))
                      <a href="{{ url('frontoffice/hapus-file-resummedis/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->resummedis) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Laporan Operasi & Anestesi</td>
                  <td class="text-center">
                    @isset ($doc->operasi)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('operasi')"><i class="fa fa-folder-o"></i></button> --}}
                        @if (substr($doc->operasi,-3) == 'pdf')
                          <a href="{{ url('dokumen_rekammedis/'.$doc->operasi) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                        @else
                          <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'operasi')"><i class="fa fa-folder-o"></i></button>
                        @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->operasi))
                      <a href="{{ url('frontoffice/hapus-file-operasi/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->operasi) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Klinik Pathway</td>
                  <td class="text-center">
                    @isset ($doc->pathway)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('pathway')"><i class="fa fa-folder-o"></i></button> --}}
                        @if (substr($doc->pathway,-3) == 'pdf')
                          <a href="{{ url('dokumen_rekammedis/'.$doc->pathway) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                        @else
                          <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'pathway')"><i class="fa fa-folder-o"></i></button>
                        @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->pathway))
                      <a href="{{ url('frontoffice/hapus-file-pathway/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->pathway) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>EKG</td>
                  <td class="text-center">
                    @isset ($doc->ekg)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('ekg')"><i class="fa fa-folder-o"></i></button> --}}
                        @if (substr($doc->ekg,-3) == 'pdf')
                          <a href="{{ url('dokumen_rekammedis/'.$doc->ekg) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                        @else
                          <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'ekg')"><i class="fa fa-folder-o"></i></button>
                        @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->ekg))
                      <a href="{{ url('frontoffice/hapus-file-ekg/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->ekg) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>Echocardiograms</td>
                  <td class="text-center">
                    @isset ($doc->echo)
                        {{-- <button class="btn btn-sm btn-flat btn-primary" onclick="viewDokumen('echocardiograms')"><i class="fa fa-folder-o"></i></button> --}}
                        @if (substr($doc->echo,-3) == 'pdf')
                          <a href="{{ url('dokumen_rekammedis/'.$doc->echo) }}" target="_blank" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-folder-o"></i></a>
                        @else
                          <button class="btn btn-sm btn-flat btn-info" onclick="viewDokumen({{ $doc->id }}, 'echo')"><i class="fa fa-folder-o"></i></button>
                        @endif
                    @endisset
                  </td>
                  <td class="text-center">
                    @if(isset($doc->echo))
                      <a href="{{ url('frontoffice/hapus-file-echo/'.$doc->id) }}" class="btn btn-danger btn-sm"> <i class="fa fa-icon fa-trash"></i> </a>
                    @else
                    <i class="fa fa-minus text-danger"></i>
                    @endif
                  </td>
                  <td class="text-center">{!! isset($doc->echo) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-minus text-danger"></i>' !!}</td>
                </tr>
              </tbody>
            </table>
          </div>
            @if ( substr($reg->status_reg, 0, 1) == 'I' )
              <a href="{{ url('frontoffice/e-claim/bridging-irna/'.$reg->id) }}" class="btn btn-flat btn-default">KEMBALI</a>
            @else
              <a href="{{ url('frontoffice/e-claim/bridging/'.$reg->id) }}" class="btn btn-flat btn-default">KEMBALI</a>
            @endif

      </div>

    </div>
  </div>


<div class="modal fade" id="modalDocument">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
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

@endsection

@section('script')
<script type="text/javascript">
    function viewDokumen(id, nama) {
      $('#modalDocument').modal('show')
      $('.modal-title').text('View dokumen '+nama)
      $.ajax({
        url: '/frontoffice/viewDokument/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        if (nama == 'radiologi') {
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.radiologi);
        } else if (nama == 'laboratorium'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.laboratorium);
        } else if (nama == 'resummedis'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.resummedis);
        } else if (nama == 'operasi'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.operasi);
        } else if (nama == 'pathway'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.pathway);
        } else if (nama == 'ekg'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.ekg);
        } else if (nama == 'echocardiograms'){
          $('img').attr('src', '/dokumen_rekammedis/'+json.data.echo);
        }
      });

    }

</script>
@endsection
