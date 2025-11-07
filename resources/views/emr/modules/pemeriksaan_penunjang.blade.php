@extends('master')
@section('header')
<h1>{{baca_unit($unit)}} - Pemeriksaan Penunjang <small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pemeriksaan Penunjang</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </div>
      </div> 
      <div class='table-responsive' style="margin-top: 2rem;">
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Tindakan</th>
              <th>Ruangan</th>
              <th>Tanggal</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($penunjang as $p)
                @php
                    $tindakan = [];
        
                    if (!is_null($p->hasil_echo)) $tindakan[] = 'Echo';
                    if (!is_null($p->hasil_ekg)) $tindakan[] = 'EKG';
                    if (!is_null($p->hasil_eeg)) $tindakan[] = 'EEG';
                    if (!is_null($p->hasil_usg)) $tindakan[] = 'USG Kandungan';
                    if (!is_null($p->hasil_ctg)) $tindakan[] = 'CTG';
                    if (!is_null($p->hasil_spirometri)) $tindakan[] = 'Spirometri';
                    if (!is_null($p->hasil_lainnya)) $tindakan[] = 'Lainnya';
        
                    $tindakanText = implode(', ', $tindakan);
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $tindakanText }}</td>
                    <td>{{ baca_poli($p->poli_id) }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                    <td>
                        <a href="{{ url("emr-soap-print/cetak-hasil-penunjang/".$reg->id. "/" .$p->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat">
                            <i class="fa fa-print"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
          </tbody>        
        </table>
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
