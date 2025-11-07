@extends('master')
@section('header')
{{-- <h1>RADIOLOGI<small><a href="{{url('radiologi/notifikasi')}}" class="btn btn-default" id="tambah"> Kembali </a></small>
</h1> --}}
@endsection
@section('content')
<div class="box box-primary">
  <div class="overlay hidden">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
  <div class="box-header with-border">
    <h4>RADIOLOGI<small>&nbsp;<a href="{{url('radiologi/terbilling')}}" class="btn btn-default" id="tambah">Kembali </a></small>
    </h4>
    <div class="box-body">
      <h4 class="text-center">Input Ekspertise</h4>
      <hr style="border-top: 1px solid red;" />
      <div class="row">
        <div class="col-md-6">
          <button type="button" id="historiSoap"
            class="btn btn-primary btn-sm">
            <i class="fa fa-th-list"></i> HISTORY CPPT
          </button>

          <button type="button" id="historiLab" class="btn btn-success btn-sm" data-pasienID="{{ $reg->pasien_id }}">
            <i class="fa fa-th-list"></i> HISTORY LAB
          </button>
        </div>
        <div class="col-md-12">
          <form method="POST" class="form-horizontal" id="formEkspertise">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="{{$reg->id}}">
            <input type="hidden" name="ekspertise_id" value="{{$id_eksp}}">

            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Nama Pasien </th>
                    <td class="nama">{{@$reg->pasien->nama}}</td>
                    <th>Jenis Kelamin </th>
                    <td class="jk" colspan="3">{{@$reg->pasien->kelamin}}</td>
                  </tr>
                  <tr>
                    <th>Umur </th>
                    <td class="umur">{{@$umur}}</td>
                    <th>No. RM </th>
                    <td class="no_rm" colspan="3">{{@$reg->pasien->no_rm}}</td>
                  </tr>
                  <tr>
                    <th>Pemeriksaan</th>
                    <td>
                      {{-- <ol class="pemeriksaan"></ol> --}}
                      <div id="tindakanPeriksa">
                        <select class="form-control" name="tindakan_id">
                          <option>Silahkan Pilih</option>
                        @foreach ($tindakan as $key => $val)
                          @php
                              $selected = $key == '0' ? 'selected' : '';
                          @endphp
                          <option data_tgl="{{$val->created_at}}" value="{{$val->id}}" {{$selected}}>{{$val->namatarif}}</option>    
                        @endforeach
                      </select>
                      </div>
                    </td>
                    <th>Tanggal Pemeriksaan </th>
                    <td>
                      {!! Form::text('tglPeriksa', @valid_date(@$radiologi->tglPeriksa), ['class' => 'form-control datepicker ', 'required' =>
                      'required']) !!}
                    </td>
                  </tr>
                  <tr>
                    <th>Dokter Pelaksana</th>
                    <td>
                      <select name="dokter_id" class="form-control select2" style="width: 100%">
                        <option value="">-- Pilih --</option>
                        @foreach ($radiografer as $d)
                        {{-- @foreach (Modules\Pegawai\Entities\Pegawai::all() as $d) --}}
                        <option value="{{ $d->id }}" {{$d->id == $radiologi->dokter_id ? 'selected' : ''}}>{{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </td>
                    <th>Dokter Pengirim</th>
                    <td>
                      <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                        @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                        {{-- @foreach (Modules\Pegawai\Entities\Pegawai::all() as $d) --}}
                        <option value="{{ $d->id }}" {{$d->id == $radiologi->dokter_pengirim ? 'selected' : ''}}>{{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>
                  <tr>

                    <th>Diagnosa</th>
                    <td>
                      <div id="tindakanPeriksa">
                       <ul>
                        @foreach ($tindakan as $key => $val)
                        <li>
                          <p>{{ @$val->diagnosa }}</p>
                        </li>
                        @endforeach
                      </ul>
                      
                      </div>
                    </td>
                    <th>Tanggal Ekspertise </th>
                    <td colspan="3">
                      {!! Form::text('tanggal_eksp', date('d-m-Y',strtotime($radiologi->tanggal_eksp)), ['class' => 'form-control datepicker ', 'required' =>
                      'required']) !!}
                    </td>
                  </tr>
                  {{-- <tr>
                    <th>Klinis<br/>
                    <i style="font-weight: 400 !important"><small>(dari order radiologi)</small></i></th>
                    <td colspan="3">
                      <textarea name="klinis" class="form-control ckeditor">
                        {{$radiologi->klinis}}
                      </textarea>
                    </td>
                  </tr> --}}
                  <tr>
                    <th>Ekspertise</th>
                    <td colspan="3">
                      <textarea name="ekspertise" id="ekspertise" cols="115" rows="20">{{$radiologi->ekspertise}}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            {{-- <button type="button" class="btn pull-right btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button> --}}
            <button type="button" class="btn pull-right btn-primary btn-flat" id="simpan_ekspertise" onclick="showModalTTE()">Simpan</button>
            <button type="button" onclick="close_window()" class="btn btn-danger">Close/Tutup</button>
            <div class="btn-group">
              <button type="button" class="btn btn-warning">Cetak </button>
              <button type="button" class="btn btn-lg btn-warning dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                @foreach (\App\RadiologiEkspertise::where('registrasi_id', $reg->id)->get() as $p)
                  <li>
                    <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$reg->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal TTE Ekspertise--}}
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form id="form-tte-ekspertise" action="" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Hasil Ekspertise</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
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
        <button type="button" class="btn btn-primary" id="button-proses-tte-ekspertise" onclick="saveEkpertise()">Simpan</button>
        {{-- <button type="button" class="btn btn-primary" id="button-proses-tte-ekspertise" onclick="saveEkpertiseTemplate()">Simpan Dan Buat Template</button> --}}
      </div>
    </div>
    </form>

  </div>
</div>

 {{-- Modal History SOAP ======================================================================== --}}
 <div class="modal fade" id="showHistoriSoap" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="">History SOAP Sebelumnya</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive" style="max-height: 550px !important;border:1px solid blue">
              <table class="table table-bordered" id="data" style="font-size: 12px;">
                  <tbody>
                    @if (count($all_resume) == 0)
                        <tr>
                          <td>Tidak ada record</td>
                        </tr>
                    @endif
                      @foreach( $all_resume as $key_a => $val_a )
                          @php
                            $id_ss = @json_decode(@$val_a->id_observation_ss);
                          @endphp
                      <tr style="background-color:#9ad0ef">
                        <th>{{@$val_a->registrasi->reg_id}}</th>
                        <th>
                          @if ($val_a->unit == 'inap')
                            Rawat Inap
                            {{ @$val_a->registrasi->rawat_inap->kamar->nama }}
                          @else
                            POLI 
                            {{ @$val_a->poli_id ? @strtoupper(baca_poli($val_a->poli_id)) : @strtoupper($val_a->registrasi->poli->nama)}}
                          @endif
                        </th>
                      </tr>
                      <tr style="background-color:#9ad0ef">
                        <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
                        <th>
                          @php
                             $dokterid = Modules\Registrasi\Entities\Registrasi::where('id', $val_a->registrasi_id)->first();

                             if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4'){
                             $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'gigi')->first();
                             }elseif (@$reg->poli_id == '15') {
                              $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'obgyn')->first();
                             } else {
                              $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'fisik')->first();
                             }

                          @endphp
                          {{ baca_user($val_a->user_id)}}

                        </th>
                      </tr>
                      <tr>
                          <td colspan="2"><b>S:</b> {!! $val_a->subject !!}</td>
                      </tr>
                      <tr>
                          <td colspan="2"><b>O:</b> {!! $val_a->object !!}</td>
                      </tr>
                      <tr>
                          <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
                      </tr>
                      <tr>
                          <td colspan="2"><b>P:</b> {!! $val_a->planning !!}</td>
                      </tr>
                      <tr>
                          <td colspan="2"><b>Diagnosa Tambahan:</b> {!! $val_a->diagnosistambahan !!}</td>
                      </tr>
                      <tr>
                          <td colspan="2" data-idss="{{@$id_ss->edukasi}}">
                              <b>Edukasi:</b> 
                              {{@App\Edukasi::where('code', $val_a->edukasi)->first()->keterangan}}
                          </td>
                      </tr>
                      <tr>
                          <td colspan="2" data-idss="{{@$id_ss->diet}}">
                              <b>Diet:</b> 
                              {!! @$val_a->diet !!}
                          </td>
                      </tr>
                      <tr>
                          <td colspan="2" data-idss="{{@$id_ss->prognosis}}">
                              <b>Prognosis:</b> 
                              {{@App\Prognosis::where('code', $val_a->prognosis)->first()->keterangan}}
                          </td>
                      </tr>
                      <tr>
                        <td colspan="2"><b>Status Lokalis :</b>
                          @if (@$val_a->emrPenilaian && @$val_a->emrPenilaian->image != null)
                            <a id="myImg"><i class="fa fa-eye text-primary"></i></a>
                              <input type="hidden" src="/images/{{ @$val_a->emrPenilaian->image }}" id="dataImage">
                            
                            <div id="myModal" class="modal">
                              <span class="close" style="color: red; transform:scale(2); opacity:1">&times;</span>
                              <img class="modal-content" id="img01" style="margin-top: -40px">
                              <div id="caption">twat</div>
                            </div>
                          @else
                            -
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2"><b>Discharge Planning :</b>
                          @if (@$val_a->discharge)
                          @php
                              @$assesment  = @json_decode(@$val_a->discharge, true);
                          @endphp
                          {{-- JIKA PULANG --}}
                          @if (@$assesment['dischargePlanning']['kontrol']['dipilih'])
                            {{@$assesment['dischargePlanning']['kontrol']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrol']['waktu']}}
                          @elseif(@$assesment['dischargePlanning']['dirawat']['dipilih'])
                            {{@$assesment['dischargePlanning']['dirawat']['dipilih']}} - {{@$assesment['dischargePlanning']['dirawat']['waktu']}}
                          @elseif(@$assesment['dischargePlanning']['kontrolPRB']['dipilih'])
                            {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}
                          @elseif(@$assesment['dischargePlanning']['Konsultasi']['dipilih'])
                            {{@$assesment['dischargePlanning']['Konsultasi']['dipilih']}} - {{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}
                          @elseif(@$assesment['dischargePlanning']['pulpak']['dipilih'])
                            {{@$assesment['dischargePlanning']['pulpak']['dipilih']}} - {{@$assesment['dischargePlanning']['pulpak']['waktu']}}
                          @elseif(@$assesment['dischargePlanning']['meninggal']['dipilih'])
                            {{@$assesment['dischargePlanning']['meninggal']['dipilih']}} - {{@$assesment['dischargePlanning']['meninggal']['waktu']}}
                          @else
                            {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                          @endif

                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
      </div>
  </div>
</div>

{{-- Modal History Lab ======================================================================== --}}
<div class="modal fade" id="showHistoriLab" tabindex="-1" role="dialog" aria-labelledby=""
aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="">History LAB Sebelumnya</h4>
          </div>
          <div class="modal-body">
              <div id="dataHistoriLab">
                  <div class="spinner-square">
                      <div class="square-1 square"></div>
                      <div class="square-2 square"></div>
                      <div class="square-3 square"></div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
      </div>
  </div>
</div>

@endsection
@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    {{-- @parent --}}
    <script type="text/javascript">
    $('.select2').select2()
      //CKEDITOR
   
    function close_window() {
      if (confirm("Yakin Akan Tutup Halaman?")) {
        close();
      }
    }
    function showModalTTE() {
        $('#myModal').modal('show');
    }
    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      var ekspertise = $('#ekspertise').val();
      var nik = $('input[name="nik"]').val();
      var passphrase = $('input[name="passphrase"]').val();
      // tinymce.triggerSave();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('ekspertise', ekspertise)
      form_data.append('nik', nik)
      form_data.append('passphrase', passphrase)

      
      $.ajax({
        url: '/radiologi/ekspertise-baru',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
          $('.overlay').addClass('hidden')
        }
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="ekspertise_id"]').val(resp.data.id)
          alert(resp.text)
          if (resp.sukses_tte == true) {
            window.open('/radiologi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id+'/'+resp.data.folio_id+'?dokumen_tte=true')
          } else {
            window.open('/radiologi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id+'/'+resp.data.folio_id)
          }
          close();

        } else {
          alert(resp.text)
        }

      });
    }

    $(document).on('click', '#historiSoap', function(e) {
      var id = $(this).attr('data-pasienID');
      var unit = $('input[name=unit]').val();
      $('#showHistoriSoap').modal('show');
    });

    $(document).on('click', '#historiLab', function(e) {
      var id = $(this).attr('data-pasienID');
      $('#showHistoriLab').modal('show');
      $('#dataHistoriLab').load("/radiologi/history-lab/" + id);
    });
      
    </script>
@endsection