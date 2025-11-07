@extends('master')

@section('header')
    <h1>Verifikasi Konsul</h1>
@endsection

@section('css')
    <style>
        .blink_violet {
            color: rgb(149, 0, 255);
            font-weight: bold;
            animation: blinker 2s linear infinite;
        }
        
        @keyframes blinker {
            50% {
            opacity: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                Periode Tanggal: {{ date('d-m-Y') }}&nbsp;
            </h4>
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'emr-konsul/verif?unit=' . $unit . '&first_visit=false', 'class' => 'form-horizontal']) !!}            <div class="row">
                    <div class="col-md-3">
                        <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                    type="button">Tanggal</button>
                            </span>
                            {!! Form::text('tga', date('d-m-Y'), [
                                'class' => 'form-control datepicker',
                                'required' => 'required',
                                'autocomplete' => 'off',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('tga') }}</small>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group {{ $errors->has('tgb') ? ' has-error' : '' }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default {{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">Sampai Tanggal</button>
                            </span>
                            {!! Form::text('tgb', date('d-m-Y'), [
                                'class' => 'form-control datepicker',
                                'required' => 'required',
                                'autocomplete' => 'off',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('tgb') }}</small>
                        </div>
                    </div>

                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default {{ $errors->has('smf') ? ' has-error' : '' }}" type="button">SMF</button>
                        </span>
                        <select name="smf" class="select2">
                          @foreach (smf() as $id => $smf_item)
                            <option value="{{$id}}" {{$id == @$smf ? "selected" : ''}}>{{$smf_item}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default {{ $errors->has('smf') ? ' has-error' : '' }}" type="button">Status</button>
                        </span>
                        <select name="status" class="select2">
                          <option value="" selected>Semua</option>
                          <option value="terjawab" {{$status == "terjawab" ? 'selected' : ''}}>Terjawab</option>
                          <option value="belum_terjawab" {{$status == "belum_terjawab" ? 'selected' : ''}}>Belum Terjawab</option>
                        </select>
                      </div>
                    </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit">Cari</button>
              </div>
            </div>
            <br>

            {!! Form::close() !!}
            <hr>
        </div>

     <div class="table-responsive">



      <table class="table table-bordered table-condensed">
          <thead>
              <tr>
                  <th>No</th>
                  <th>No RM</th>
                  <th>Nama Pasien</th>
                  <th>Dokter Pengirim</th>
                  <th>DPJP Konsul</th>
                  <th>Pelayanan</th>
                  <th>Alasan Konsul / Diagnosa</th>
                  <th>Waktu Konsul</th>
                  @if ($unit == 'jalan')
                      <th>Poli Asal</th>
                      <th>Poli Tujuan</th>
                  @elseif ($unit == 'igd')
                      <th>Asal</th>
                      <th>Tujuan</th>
                  @else
                      <th>Ruang Asal</th>
                      <th>Ruang Tujuan</th>
                  @endif
                  <th>Jawaban Konsul</th>
                  @if (Auth::user()->pegawai->kategori_pegawai == 1)
                      <th>Verifikasi</th>
                  @endif
                  <th>EMR</th>
                  <th>CPPT</th>
                  <th>Hasil</th>
              </tr>
          </thead>
          <tbody>
              @forelse ($emrKonsuls as $konsul)
                  <tr>
                     <td>{{ $loop->iteration }}</td>                      
                     <td>{{ @$konsul->pasien->no_rm }}</td>
                      <td>{{ @$konsul->pasien->nama }}</td>
                      <td>{{ @$konsul->dokterPengirim->nama }}</td>
                      <td>{{ @$konsul->dokterTujuan->nama }}</td>
                      <td>
                          @if (@$konsul->unit == "jalan")
                              Rawat Jalan
                          @elseif (@$konsul->unit == "igd")
                              IGD
                          @elseif (@$konsul->unit == "inap")
                              Rawat Inap
                          @endif
                      </td>
                      <td>{!! @$konsul->alasan_konsul !!}</td>
                      <td>{{ date('d-m-Y H:i:s', strtotime(@$konsul->created_at)) }}</td>
                      <td>{{ baca_poli(@$konsul->poli_asal_id) }}</td>
                      <td>{{ baca_poli(@$konsul->poli_id) }}</td>
                      <td>
                          @if (@$konsul->data_jawab_konsul)
                              @foreach (@$konsul->data_jawab_konsul as $jawaban)
                                  * {{$jawaban->jawab_konsul}}  ({{date('d-m-Y H:i', strtotime($jawaban->created_at))}}) <br> <br>
                              @endforeach
                          @endif
                      </td>
                      @if (Auth::user()->pegawai->kategori_pegawai == 1)
                          <td class="text-center">
                              @if(@$konsul->verifikator == null)
                                  <button type="button" data-toggle="tooltip"
                                          data-id="{{ @$konsul->id }}"
                                          class="btn btn-info btn-xs btn-jawab btn-flat">Jawab
                                      Konsul</button>&nbsp;&nbsp;
                                  <button class="btn btn-success btn-md" onclick="verifikasiKonsul({{ @$konsul->id }})">
                                      <span class="fa fa-check"></span>
                                  </button>
                              @else
                                  <label class="label label-success">Sudah Diverifikasi - {{ @$konsul->userVerif->name }}</label>
                              @endif
                          </td>
                      @endif
                      <td>
                          @php
                              $reg = $konsul->registrasi;
                              $unitReg = null;
                              if (cek_status_reg($reg->status_reg) == "I") {
                                  $unitReg = "inap";
                              } elseif (cek_status_reg($reg->status_reg) == "J") {
                                  $unitReg = "jalan";
                              } elseif (cek_status_reg($reg->status_reg) == "G") {
                                  $unitReg = "igd";
                              }
                          @endphp
                          <a href="{{ url('emr-soap/anamnesis/main/' . $unitReg . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}"
                            class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                      </td>
                      <td>
                          <button type="button" id="historiSoap" data-pasienID="{{ $reg->pasien_id }}"
                                  class="btn btn-info btn-sm btn-flat">
                              <i class="fa fa-th-list"></i>
                          </button>
                      </td>
                      <td>
                          <a href="{{ url('emr/pemeriksaan-lab/' . $unitReg . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}" class="btn btn-danger btn-sm" target="_blank">Laboratorium</a>
                          <a href="{{ url('emr/pemeriksaan-rad/' . $unitReg . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}" class="btn btn-info btn-sm" target="_blank">Radiologi</a>
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="100%" class="text-center">Data tidak ditemukan.</td>
                  </tr>
              @endforelse
          </tbody>
      </table>

     <!-- Pagination Controls -->
   
    </div>


    </div>

    <div id="modals" class="modal fade" role="dialog">
      <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  {{-- <h4 class="modal-title">Jawab Konsul</h4> --}}
              </div>
              <div class="modal-body" id="dataModals">

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>

      </div>
    </div>

    {{-- Modal History Penjualan ======================================================================== --}}
    <div id="myModalHistoryResep" class="modal fade" role="dialog">
      <div class="modal-dialog">
  
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">History E-Resep</h4>
          </div>
          <div class="modal-body" id="listHistoryResep">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
  
      </div>
    </div>

    {{-- Modal History SOAP ======================================================================== --}}
  <div class="modal fade" id="showHistoriSoap" tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">History SOAP Sebelumnya</h4>
            </div>
            <div class="modal-body">
                <div id="dataHistoriSoap">
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
  {{-- End Modal History SOAP ======================================================================== --}}

@endsection

@section('script')
    <script>
    function verifikasiKonsul(idKonsul){
    $.ajax({
        url: '/emr-konsul/proses-verif/' + idKonsul,
        type: 'GET',
        dataType: 'json',
        success: function (res) {
            if(res.code){
                alert(res.message);
                location.href = '/emr-konsul/verif?unit=inap&first_visit=false'; // Sesuaikan URL reload
            }
        }
    });
    }

    $('.select2').select2({
        width: '100%'
    });

    $(document).on('click', '.btn-jawab', function() {
        let id = $(this).attr('data-id');
        $('#dataModals').html('');
        $('#dataModals').load('/emr-datakonsul/' + id);
        $('#modals').modal('show');
    });

    $(document).on('click', '#historiSoap', function(e) {
        var id = $(this).attr('data-pasienID');
        var unit = $('input[name=unit]').val();
        $('#showHistoriSoap').modal('show');
        $('#dataHistoriSoap').load("/soap/history/"+unit+"/" + id);
    });

    $(document).on('change', '#registrasi_select', function(){
        var regId = $(this).val();
        var unit = $('input[name=unit]').val();
        $('#showHistoriSoap').modal('show');
        $('#dataHistoriSoap').load("/soap/history-filter/"+unit+"/" + regId);
    });

    $(document).on('click','.btn-history-resep',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/tindakan/e-resep/history/'+id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $('#listHistoryResep').html('');
            },
            success: function (res){
                $('#listHistoryResep').html(res.html);
                $('#myModalHistoryResep').modal('show');
            }
        });
    });
    </script>
@endsection
