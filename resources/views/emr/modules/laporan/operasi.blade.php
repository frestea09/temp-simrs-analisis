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
<h1>Anamnesis - Umum</h1>
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

    @include('emr.modules.addons.profile')
     <div class="row">
      <div class="col-md-12">
        @include('emr.modules.addons.tabs')
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">No. RM</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Status</th>
                <th class="text-center">L/P</th>
                <th class="text-center">Poli</th>
                <th class="text-center">Bayar</th>
                <th class="text-center">Dr. Bedah</th>
                <th class="text-center">Dr. Anestesi</th>
                <th class="text-center">Tindakan</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Cetak</th>

                {{-- <th class="text-center">Tarif</th> --}}
            </tr>
            </thead>
            <tbody>
              @php $jumlah = 0; @endphp
              @foreach ($operasi as $key => $d)
                  @php
                      $nt     = explode('||', $d->namatarif);
                      $total  = explode('||', $d->total);
                      $dokter = explode('||', $d->dokter);
                      $anestesi= explode('||', $d->anestesi);
                      $tgl    = explode('||', $d->tanggal);
                  @endphp
                  <tr>
                      <td class="text-center" rowspan="{{ count($total) }}">{{ $no++ }}</td>
                      <td rowspan="{{ count($total) }}">{{ $d->pasien->no_rm }}</td>
                      <td rowspan="{{ count($total) }}">{{ $d->pasien->nama }}</td>
                      <td class="text-center" rowspan="{{ count($total) }}">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                      <td class="text-center" rowspan="{{ count($total) }}">{{ $d->pasien->kelamin }}</td>
                      <td rowspan="{{ count($total) }}">{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                      <td class="text-center" rowspan="{{ count($total) }}">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  @if(count($total) > 1)
                      @foreach($total as $k => $t)
                          @if($k == 0)
                              <td>{{ (isset($dokter[$k])) ? baca_dokter($dokter[$k]) : '' }}</td>
                              <td>{{ (isset($anestesi[$k])) ? baca_dokter($anestesi[$k]) : '' }}</td>
                              <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                              <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                              <td class="text-right">{{ number_format($t) }}</td>
                          @else
                              <tr>
                                  <td>{{ (isset($dokter[$k])) ? baca_dokter($dokter[$k]) : '' }}</td>
                                  <td>{{ (isset($anestesi[$k])) ? baca_dokter($anestesi[$k]) : '' }}</td>
                                  <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                  <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                  <td class="text-right">{{ number_format($t) }}</td>
                              </tr>
                          @endif
                          @php $jumlah += (int)$t; @endphp
                      @endforeach
                  @else
                          <td>{{ baca_dokter($dokter[0]) }}</td>
                          <td>{{ baca_dokter($anestesi[0]) }}</td>
                          <td>{{ (isset($nt[0])) ? $nt[0] : '' }}</td>
                          <td>{{ date('d-m-Y', strtotime($tgl[0])) }}</td>
                          {{-- <td class="text-right">{{ number_format($total[0]) }}</td> --}}
                          <td class="text-center"><a  target="_blank" class="btn btn-success btn-md" href="{{url('cetak-laporan-operasi/'.$reg->id)}}"><i class="fa fa-print"></i></a></td>
                      </tr>
                      @php $jumlah += (int)$total[0]; @endphp
                  @endif
              @endforeach
              </tbody>
          </table>
        </div>
      </div>
     </div>
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  @endsection