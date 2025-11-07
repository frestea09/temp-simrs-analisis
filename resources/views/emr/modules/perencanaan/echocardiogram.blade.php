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
</style>
@section('header')
<h1>ECHOCARDIOGRAM</h1>
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
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </ul>
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asesmen_id', $asesmen_id) !!}
          <br>
          {{-- Anamnesis --}}
          <div class="col-md-8">
            <h5><b>ECHOCARDIOGRAM</b></h5>
            <form method="POST" class="form-horizontal" id="formEkspertise" action="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id ) }}">
              {{ csrf_field() }}
              <input type="hidden" name="registrasi_id" value="">
              <input type="hidden" name="pasien_id" value="">
              <input type="hidden" name="jenis" value="TA">
              <input type="hidden" name="id" value="">
            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Diagnosa Klinis</th>
                    <td colspan="2">
                      <input type="text" name="diagnosa" class="form-control">
                    </td>
                  </tr>
                  <tr>
                    <th>Atrium Kiri</th>
                    <td>
                      <input type="number" name="atrium_kiri" placeholder="Normal : 15-40mm" class="form-control">
                    </td>
                    <th>LVESD</th>
                    <td>
                      <input type="number" name="lvesd" placeholder="26-36" class="form-control">
                    </td>
                  </tr>
                  <tr>
                    <th>LAVI</th>
                    <td>
                      <input type="text" class="form-control" name="global" placeholder="">
                    </td>
                    <th>IVSd</th>
                    <td>
                      <input type="text" class="form-control" name="ivsd" placeholder="">
                    </td>
                  </tr>
                  <tr>
                    <th>Ventrikel Kanan</th>
                    <td>
                      <input type="number" class="form-control" name="ventrikel_kanan" placeholder="<42mm">
                    </td>
                    <th>IVSs</th>
                    <td>
                      <input type="number" class="form-control" name="ivss" placeholder="">
                    </td>
                  </tr>
                  <tr>
                    <th>Aorta</th>
                    <td>
                      <input type="text" class="form-control" name="katup_katup_jantung_aorta" placeholder="Normal : 20-37mm"/>
                    </td>
                    <th>LVEDD</th>
                    <td>
                      <input type="text" class="form-control" name="lvedd" placeholder="Normal : 35-52"/>
                    </td>
                  </tr>
                  <tr>
                    <th>Ejeksi Fraksi</th>
                    <td>
                      <input type="text" class="form-control" name="ejeksi_fraksi" placeholder="Normal : 53-77%"/>
                    </td>
                    <th>PWd</th>
                    <td>
                      <input type="text" class="form-control" name="pwd" placeholder="Normal : 7-11mm"/>
                    </td>
                  </tr>
                  <tr>
                    <th>E/A</th>
                    <td>
                      <input type="text" class="form-control" name="ea" placeholder=""/>
                    </td>
                    <th>PWs</th>
                    <td>
                      <input type="text" class="form-control" name="pws" placeholder=""/>
                    </td>
                  </tr>
                  <tr>
                    <th>E/e</th>
                    <td>
                      <input type="text" class="form-control" name="ee" placeholder=""/>
                    </td>
                    <th>LVMI</th>
                    <td>
                      <input type="text" class="form-control" name="lvmi" placeholder=""/>
                    </td>
                  </tr> 
                  <tr>
                    <th>TAPSE</th>
                    <td>
                      <input type="text" class="form-control" name="tapse" placeholder="Normal : > 17mm"/>
                    </td>
                    <th>rwt</th>
                    <td>
                      <input type="text" class="form-control" name="rwt"/>
                    </td>
                  </tr> 
                  <tr>
                    <th>Catatan Dokter</th>
                    <td colspan="3">
                      <textarea name="catatan_dokter" class="form-control wysiwyg"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <th>Kesimpulan</th>
                    <td colspan="3">
                      <textarea name="kesimpulan" class="form-control wysiwyg"></textarea>
                    </td>
                  </tr>

                  {{-- Input hidden untuk tte --}}
                  <input type="hidden" name="nik" id="nik">
                  <input type="hidden" name="passphrase" id="passphrase">
                  <input type="hidden" name="proses_tte" id="proses_tte" value="false">
                </tbody>
              </table>
            </div>

                  
              <div class="col-md-8 text-right">
                <button type="button" class="btn btn-success" id="saveEkspertise">Simpan & TTE</button>
              </div>
            </form>
          </div>
          <div class="col-md-4">
            <br/>
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Riwayat Echocardiogram</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Waktu Input</th>
                          <th>Penginput</th>
                          <th>Cetak</th>
                      </tr>
                  </thead>
                  <tbody>
                @if (count($riwayat) == 0)
                <tr>
                  <td colspan="4" class="text-center"><i>Belum ada riwayat</i></td>
                </tr>  
                @endif
                @foreach ($riwayat as $key=>$item)
                @php
                    $poli = request()->get('poli');
                    $dpjp = request()->get('dpjp');
                @endphp
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{date('d-m-Y, H:i',strtotime($item->created_at))}}</td>
                    <td>{{baca_user($item->user_id)}}</td>
                    <td>
                          <a target="_blank" class="btn btn-success btn-xs" href="{{url('/echocardiogram/cetak-echocardiogram/'.$registrasi_id.'/'.$item->id)}}">Cetak</a>
                    </td>
                  </tr> 
                @endforeach
                </tbody>
              </table>
              </div>
              </div> 
          </div>
          <br /><br />
        </div>

        
      </div>

    <br/>
    <br/>
    
  </div>

  <!-- Modal TTE echocardiogram-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-echocardiogram" action="{{ url('tte-pdf-echocardiogram') }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Echocardiogram</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="echocardiogram_id" id="echocardiogram_id" disabled>
          <input type="hidden" class="form-control" name="nik_modal" id="nik_hidden_modal" value="{{Auth::user()->pegawai->nik}}" disabled>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Nama:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" name="dokter_modal" id="dokter_modal" value="{{Auth::user()->pegawai->nama}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">NIK:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nik_modal" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="passphrase_modal" id="passphrase_modal" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="button-proses-tte-echocardiogram">Proses TTE</button>
      </div>
    </div>
  </div>
</div>
  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  $('.select2').select2();
  $('#saveEkspertise').click(function (e) {
    e.preventDefault();
    $('#myModal').modal('show');
  })

  $('#button-proses-tte-echocardiogram').click(function () {
    if (confirm('Apakah anda yakin ingin melakukan proses TTE pada dokumen?')) {
      $('#nik').val($('#nik_hidden_modal').val())
      $('#passphrase').val($('#passphrase_modal').val())
      $('#proses_tte').val('true');
      $('#formEkspertise').submit();
    }
  })
  </script>
  @endsection