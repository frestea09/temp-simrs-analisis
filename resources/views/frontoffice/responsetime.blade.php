@extends('master')
@section('header')
  <h1>Dashboard - Response Time</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      
      <form method="POST" action="{{ url('frontoffice/export') }}" class="form-horizontal" id="filterGudang">
      {{ csrf_field() }}
        <div class="row">
            <div clas="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('tgla', 'Tanggal', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('tgla', null, ['class' => 'form-control datepicker']) !!}
                            <small class="text-danger">{{ $errors->first('tgla') }}</small>
                        </div> 
                        <div class="col-sm-4">
                            {!! Form::text('tglb', null, ['class' => 'form-control datepicker']) !!}
                            <small class="text-danger">{{ $errors->first('tglb') }}</small>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="poli_id" class="form-control select2">
                                <option value="" selected>[Semua Poli]</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                   
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" name="tampil" class="btn btn-primary btn-flat fa-file-pdf" value="TAMPILKAN">
                            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                            {{-- <input type="submit" name="pdf" target="_blank" class="btn btn-warning btn-flat fa-file-pdf" value="PDF"> --}}
                            <a href="/frontoffice/time" class="btn btn-default btn-flat fa-file-pdf" > REFRESH </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
        <hr/>

        @if (isset($respon) && !empty($respon))
        <b>Periode : Tgl {{ $tgl1 }}   s/d  {{ $tgl2 }}</b>
        @endif
        <br/><br/>
        <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
                    <tr>
                        <th width="40px" class="text-center">No</th>
                        <th class="text-center">No.RM</th>
                        <th class="text-center">Nama Pasien</th>
                        <th class="text-center">Poli</th>
                        <th class="text-center">Waktu Pendaftaran</th>
                        <th class="text-center">Waktu Akhir Pelayanan</th>
                        <th class="text-center">Lama Tunggu Pendaftaran</th>
                        {{-- <th class="text-center">Daftar Antrian Poli</th>
                        <th class="text-center">Akhir Pelayanan Poli</th> --}}
                        <th class="text-center">Lama Tunggu Pemeriksaan</th>
                        <th class="text-center">Lama Pelayanan Pelayanan</th>
                        <th class="text-center">Total Lama Pelayanan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($respon) && !empty($respon))

                    @foreach ($respon as $no => $d)
                       @php
                            // $awal  = strtotime($d->mulai_loket);
                            // $akhir = strtotime($d->mulai_akhir);
                            // $diff  = $akhir - $awal;

                            // $jam   = floor($diff / (60 * 60));
                            // $menit = $diff - ( $jam * (60 * 60) );
                            // $detik = $diff % 60;

                            // $awalpoli  = strtotime($d->mulai_poli);
                            // $akhirpoli = strtotime($d->akhir_poli);
                            // $difff  = $akhirpoli - $awalpoli;

                            // $jams   = floor($difff / (60 * 60));
                            // $menits = $difff - ( $jams * (60 * 60) );
                            // $detiks = $difff % 60;

                            date_default_timezone_set('Asia/Jakarta');
                            //Lama tunggu di loket depan
                            $waktuPendaftaran       = date_create($d->waktuPendaftaran);
                            $waktuAkhirPelayanan     = date_create($d->waktuAkhirPelayanan);

                            // lama tunggu pelayanan2
                            $pelayananA = date_create($d->mulai_poli);
                            $pelayananB = date_create($d->selesai_poli);
                            $diffa      = date_diff( $pelayananA, $pelayananB );

                            $waktuResep = count($d->eResep) > 0 ? $d->eResep->first()->created_at : null;
                            $waktuAsesmen = count($d->aswal) > 0 ? $d->aswal->first()->created_at : null;
                            $waktuCPPT = count($d->cppt) > 0 ? $d->cppt->first()->created_at : null;

                            $lamaTungguPendaftaran = date_diff($waktuPendaftaran, $waktuAkhirPelayanan);
                            $lamaTungguPemeriksaan = date_diff($waktuPendaftaran, $pelayananB);

                            if($waktuResep){
                                $waktuResep = date_create($waktuResep);
                                $lamaTungguPemeriksaan = date_diff($pelayananB, $waktuResep);
                                $totalLamaPelayanan = date_diff($waktuAkhirPelayanan, $waktuResep);
                            }elseif($waktuCPPT){
                                $waktuCPPT = date_create($waktuCPPT);
                                $lamaTungguPemeriksaan = date_diff($pelayananB, $waktuCPPT);
                                $totalLamaPelayanan = date_diff($waktuAkhirPelayanan, $waktuCPPT);
                            }elseif($waktuAsesmen){
                                $waktuAsesmen = date_create($waktuAsesmen);
                                $lamaTungguPemeriksaan = date_diff($pelayananB, $waktuAsesmen);
                                $totalLamaPelayanan = date_diff($waktuAkhirPelayanan, $waktuAsesmen);
                            }
                            
                            $lamaWaktuPelayananMenit = $lamaTungguPendaftaran->i + $lamaTungguPemeriksaan->i;
                            $lamaWaktuPelayananDetik = $lamaTungguPendaftaran->s + $lamaTungguPemeriksaan->s;
                       @endphp
                   
                      <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ @baca_poli($d->poli_id) }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($d->waktuPendaftaran)) }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($d->waktuAkhirPelayanan)) }}</td>
                        <td>{{ $lamaTungguPendaftaran->i.' Menit ' .$lamaTungguPendaftaran->s.' Detik'}}</td>
                        {{-- <td>{{ date('d-m-Y H:i:s', strtotime($d->mulai_poli)) }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($d->selesai_poli))  }}</td> --}}
                        <td>{{ $lamaTungguPemeriksaan->i.' Menit ' .$lamaTungguPemeriksaan->s.' Detik'}}</td>
                        <td>{{ $lamaWaktuPelayananMenit.' Menit ' .$lamaWaktuPelayananDetik.' Detik'}}</td>
                        <td>{{ $totalLamaPelayanan->h.' Jam'.$totalLamaPelayanan->i.' Menit'.$totalLamaPelayanan->s.' Detik'}}</td>
                      </tr>
                    @endforeach

                    @endif 
                </tbody>
            </table>
        </div>
    </div>
      {{--  @include('frontoffice.ajax_lap_pengunjung')  --}}
  </div>
@endsection

@section('script')
  <script>
    $('.select2').select2()
  </script>
@endsection
