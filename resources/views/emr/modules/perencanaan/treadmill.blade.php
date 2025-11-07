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
<h1>TREADMILL</h1>
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
    <form method="POST" action="{{ url('emr-soap/perencanaan/treadmill/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>TREADMILL</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width:20%;">Tanggal</td>
                <td  style="padding: 5px;">
                  <input type="date" name="keterangan[tgl_kontrol]" value="{{@$assesment['tgl_kontrol'] ? @$assesment['tgl_kontrol']:  date('Y-m-d')}}" class="form-control"/>
                  <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Angina</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[Angina]" value="{{@$assesment['Angina']}}" class="form-control"/>
                </td>
                <td style="width:20%;">HISTORY OF MI</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[HISTORYOFMI]" value="{{@$assesment['HISTORYOFMI']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">PRIOR OF CABG</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[PRIOROFCABG]" value="{{@$assesment['PRIOROFCABG']}}" class="form-control"/>
                </td>
                <td style="width:20%;">PRIOR CATH</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[PRIORCATH]" value="{{@$assesment['PRIORCATH']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">DIABETIC</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[DIABETIC]" value="{{@$assesment['DIABETIC']}}" class="form-control"/>
                </td>
                <td style="width:20%;">SMOKING</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[SMOKING]" value="{{@$assesment['SMOKING']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">FAMILY HISTORY</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[FAMILYHISTORY]" value="{{@$assesment['FAMILYHISTORY']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                  <td style="padding: 5px;" colspan="4">
                    <textarea rows="5" name="keterangan[INDICATIONS]" style="display:inline-block" placeholder="[INDICATIONS]" required class="form-control">{{@$assesment['INDICATIONS']}}</textarea></td>
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;" colspan="4">
                    <textarea rows="5" name="keterangan[MEDICATIONS]" style="display:inline-block" placeholder="[MEDICATIONS]" required class="form-control">{{@$assesment['MEDICATIONS']}}</textarea></td>
                  </td>
              </tr>
               
            </table>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              
              <tr>
                <td style="width:10%;">REFERRING PHYSICIAN</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[REFERRINGPHYSICIAN]" value="{{@$assesment['REFERRINGPHYSICIAN']}}" class="form-control"/>
                </td>
                <td style="width:10%;">LOCATION</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[LOCATION]" value="{{@$assesment['LOCATION']}}" class="form-control"/>
                </td>
                <td style="width:10%;">PROCEDURE TYPE</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[PROCEDURETYPE]" value="{{@$assesment['PROCEDURETYPE']}}" class="form-control"/>
                </td>
              </tr>
              
              <tr>
                <td style="width:10%;">ATTENDING PHY</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[ATTENDINGPHY]" value="{{@$assesment['ATTENDINGPHY']}}" class="form-control"/>
                </td>
                <td style="width:10%;">TARGET HR:(85%)</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[TARGETHR]" value="{{@$assesment['TARGETHR']}}" class="form-control"/>
                </td>
                <td style="width:10%;">REASON FOR END</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[REASONFOR]" value="{{@$assesment['REASONFOR']}}" class="form-control"/>
                </td>
              </tr>
              
              <tr>
                <td style="width:10%;">TECHNICIAN</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[TECHNICIAN]" value="{{@$assesment['TECHNICIAN']}}" class="form-control"/>
                </td>
                <td style="width:10%;">MAX HR : (% MPHR)</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[MAXHR]" value="{{@$assesment['MAXHR']}}" class="form-control"/>
                </td>
                <td style="width:10%;">SYMTOMS</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[SYMTOMS]" value="{{@$assesment['SYMTOMS']}}" class="form-control"/>
                </td>
              </tr>
               
              <tr>
                <td style="padding: 5px;" colspan="3">
                  <textarea rows="5" name="keterangan[DIAGNOSIS]" style="display:inline-block" placeholder="[DIAGNOSIS]" required class="form-control">{{@$assesment['DIAGNOSIS']}}</textarea></td>
                </td>
                <td style="padding: 5px;" colspan="3">
                  <textarea rows="5" name="keterangan[NOTES]" style="display:inline-block" placeholder="[NOTES]" required class="form-control">{{@$assesment['NOTES']}}</textarea></td>
                </td>
            </tr>
              <tr>
                <td style="padding: 5px;" colspan="6">
                  <textarea rows="5" name="keterangan[CONCLUSIONS]" style="display:inline-block" placeholder="[CONCLUSIONS]" required class="form-control">{{@$assesment['CONCLUSIONS']}}</textarea></td>
                </td>
            </tr>
            </table>
          </div>
          
          <br /><br />
        </div>

        
      </div>
      
      <div class="col-md-8 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
      
      <div class="col-md-12">
        <br/>
        <div class="box box-solid box-warning">
          <div class="box-header">
            <h5><b>Catatan Medis</b></h5>
          </div>
          <div class="box-body table-responsive" style="max-height: 400px">
            <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Waktu Input</th>
                      <th>Penginput</th>
                      <th>Pratinjau</th>
                      <th>TTE</th>
                  </tr>
              </thead>
              <tbody>
            @if (count($riwayat) == 0)
            <tr>
              <td><i>Belum ada catatan</i></td>
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
                  <a class="btn btn-warning btn-xs" href="{{url('/emr-soap/perencanaan/treadmill/'.$unit.'/'.$item->registrasi_id.'/'.$item->id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Edit</a>
                  <a target="_blank" class="btn btn-info btn-xs" href="{{url('/cetak-treadmill/pdf/'.$item->id)}}">Lihat</a>
                  <a onclick="return confirm('Yakin Akan Hapus Data?')" class="btn btn-danger btn-xs" href="{{url('/emr-soap/perencanaan/treadmill/'.$unit.'/'.$item->registrasi_id.'/'.$item->id.'/delete/?poli='.$poli.'&dpjp='.$dpjp)}}">Hapus</a>
                </td>
                <td>
                  <button type="button" class="btn btn-warning btn-xs proses-tte-treadmill" data-treadmill-id="{{$item->id}}">Tanda Tangan Elektronik</button>
                  @if (!empty(json_decode(@$item->tte)->base64_signed_file))
                      <a target="_blank" class="btn btn-success btn-xs" href="{{url('/cetak-treadmill-tte/pdf/'.$item->id)}}">Cetak</a>
                  @elseif (!empty(@$item->tte))
                      <a target="_blank" class="btn btn-success btn-xs" href="{{url('/dokumen_tte/'.$item->tte)}}">Cetak</a>
                  @endif
                </td>
              </tr> 
            @endforeach
            </tbody>
          </table>
          </div>
          </div> 
      </div>
    </form>
    <br/>
    <br/>
    
  </div>

  <!-- Modal TTE Treadmill-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-treadmill" action="{{ url('tte-pdf-treadmill') }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Treadmill</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="treadmill_id" id="treadmill_id" disabled>
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
            <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="button-proses-tte-treadmill">Proses TTE</button>
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
  $("input[name='diagnosa_awal']").on('focus', function () {
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
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      $(document).on('click', '.addICD', function (e) {
        document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });
    // $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  


        $('.proses-tte-treadmill').click(function () {
            $('#treadmill_id').val($(this).data("treadmill-id"));
            $('#myModal').modal('show');
        })

        $('#form-tte-treadmill').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-treadmill')[0].submit();
        })
         
  </script>
  @endsection