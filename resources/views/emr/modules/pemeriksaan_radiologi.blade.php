@extends('master')
@section('header')
<h1>{{baca_unit($unit)}} - Pemeriksaan Radiologi <small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pemeriksaan Radiologi</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </div>
      </div> 
      <div class='table-responsive' style="margin-top: 2rem;">
        <button type="button" id="exam"  data-reg="{{ $reg->id }}" class="btn btn-warning btn-sm btn-flat">
          <i class="fa fa-th-list"></i> EXAM RIS
        </button>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Tindakan</th>
              <th>Ruangan</th>
              {{-- <th>SPV</th> --}}
              <th>Tanggal</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rad as $p)
            {{-- {{dd($p)}} --}}
            @php
                   $reg = \Modules\Registrasi\Entities\Registrasi::where('id', '=', $p->registrasi_id)->first();
                   $folio = Modules\Registrasi\Entities\Folio::where('registrasi_id', '=', $reg->id)->first();
            @endphp
            <tr>
              <td>{{ $p->no_dokument }}</td>
              <td>
                @if ($p->folio)
                  {{ @$p->folio->namatarif }}
                  
                @else  
                  @foreach ($tindakan = Modules\Registrasi\Entities\Folio::where('registrasi_id', $p->registrasi_id)->where('poli_tipe', 'R')->get() as $tind)
                    - {{ @$tind->namatarif }}<br/>
                  @endforeach
                @endif
              </td>
              <td>
                {{ baca_poli($p->poli_id) }}
              </td>
              {{-- <td>{{ $p->spv}}</td> --}}
              <td>{{ date('d-m-Y',strtotime($p->created_at)) }}</td>
              <td>
              <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$reg->id."/".$folio->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument }} </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

    {{-- Modal History Penjualan ======================================================================== --}}
    <div class="modal fade" id="showExam" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">EXAM RIS</h4>
          </div>
          <div class="modal-body">
            <div id="dataExam"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
<script>
  // HISTORY EXAM
  $(document).on('click', '#exam', function (e) {
    var id = $(this).attr('data-reg');
    // alert(id)
    $('#showExam').modal('show');
    $('#dataExam').load("/ris/getexam/"+id);
  });  
</script>
@endsection
