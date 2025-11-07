@extends('master')
@section('header')
    <h1>Laporan Rehabilitasi Medik</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => '/rehabmedik/laporan', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        {!! Form::label('tga', 'Periode', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                            <small class="text-danger">{{ $errors->first('tga') }}</small>
                        </div>
                        <div class="col-sm-4">
                        {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis" class="col-sm-3 control-label">Jenis Pasien</label>
                        <div class="col-sm-8">
                          <select name="jenis" class="form-control select2" style="width: 100%">
                            @if (isset($jenis) && $jenis == 'TA')
                              <option value="">Semua</option>
                              <option value="TA" selected="true">Rawat Jalan</option>
                              <option value="TI">Rawat Inap</option>
                              <option value="TG">Rawat Darurat</option>
                            @elseif (isset($jenis) && $jenis == 'TI')
                              <option value="">Semua</option>
                              <option value="TA">Rawat Jalan</option>
                              <option value="TI" selected="true">Rawat Inap</option>
                              <option value="TG">Rawat Darurat</option>
                            @elseif (isset($jenis) && $jenis == 'TG')
                              <option value="">Semua</option>
                              <option value="TA">Rawat Jalan</option>
                              <option value="TI">Rawat Inap</option>
                              <option value="TG" selected="true">Rawat Darurat</option>
                            @else
                              <option value="" selected>Semua</option>
                              <option value="TA">Rawat Jalan</option>
                              <option value="TI">Rawat Inap</option>
                              <option value="TG">Rawat Darurat</option>
                            @endif
                          </select>
                        </div>
                      </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tindakan</label>
                        <div class="col-md-8">
                            <select class="form-control select2" style="width: 100%" name="tarif_id">
                                <option value="0" {{ ($tarif_id == 0) ? 'selected' : '' }}>SEMUA</option>
                            @foreach ($tindakan as $t)
                                <option value="{{ $t->tarif_id }}" {{ ($tarif_id == $t->tarif_id) ? 'selected' : '' }}>{{ $t->namatarif }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
                        <div class="col-md-8">
                            <select class="form-control select2" style="width: 100%" name="bayar">
                                <option value="0" {{ ($bayar == 0) ? 'selected' : '' }}>SEMUA</option>
                            @foreach ($cara_bayar as $cb)
                                <option value="{{ $cb->id }}" {{ ($bayar == $cb->id) ? 'selected' : '' }}>{{ $cb->carabayar }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
                        {{--  <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">  --}}
                        <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <hr>
        @isset($lap)
            <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No. RM</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">L/P</th>
                            <th class="text-center">Poli</th>
                            <th class="text-center">Bayar</th>
                            <th class="text-center">Dokter</th>
                            <th class="text-center">Pelaksana</th>
                            <th class="text-center">Icd 10</th>
                            <th class="text-center">Icd 9</th>
                            <th class="text-center">Tindakan</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Tarif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $jumlah = 0; @endphp
                        @foreach ($lap as $key => $d)
                            @php
                                $icd10 = App\PerawatanIcd10::where('registrasi_id', $d->registrasi_id)->get();
                                $icd9 = App\PerawatanIcd9::where('registrasi_id', $d->registrasi_id)->get();
                               
                             

                                $nt     = explode('||', $d->tindakan);
                                $total  = explode('||', $d->total);
                                $tgl    = explode('||', $d->tanggal);
                            @endphp
                            <tr style="{{@$d->ubah_dpjp == 'Y' ? 'background-color: rgb(255, 221, 221)':''}}">
                                <td class="text-center" rowspan="{{ count($total) }}">{{ $no++ }}</td>
                                <td rowspan="{{ count($total) }}">{{ $d->pasien->no_rm }}</td>
                                <td rowspan="{{ count($total) }}">{{ $d->pasien->nama }}</td>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ $d->pasien->kelamin }}</td>
                                <td rowspan="{{ count($total) }}">{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                                <td rowspan="{{ count($total) }}">{{ baca_dokter($d->dokter_id) }}</td>
                                <td rowspan="{{ count($total) }}">{{ baca_pegawai($d->radiografer) }}</td>
                                <td rowspan="{{ count($total) }}">
                                   @if (isset($icd10))
                                    @foreach ($icd10 as $t)
                                    @php
                                          $nama_icd10 = Modules\Icd10\Entities\Icd10::where('nomor', $t->icd10)->first();
                                    @endphp
                                           ({{  $t->icd10 }} | {{ $nama_icd10->nama  }}),
                                    @endforeach
                                   @endif
                                </td>
                                <td rowspan="{{ count($total) }}">
                                    @if (isset($icd9))
                                     @foreach ($icd9 as $t)
                                     @php
                                      $nama_icd9 = Modules\Icd9\Entities\Icd9::where('nomor', $t->icd9)->first();      
                                     @endphp
                                             ({{  $t->icd9 }} | {{ $nama_icd9->nama  }}),
                                     @endforeach
                                    @endif
                                 </td>
                            @if(count($total) > 1)
                                @foreach($total as $k => $t)
                                    @if($k == 0)
                                        <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                        <td class="text-right">{{ number_format($t) }}</td>
                                    @else
                                        <tr>
                                            <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                            <td class="text-right">{{ number_format($t) }}</td>
                                        </tr>
                                    @endif
                                    @php $jumlah += (int)$t; @endphp
                                @endforeach
                            @else
                                    
                                    <td>{{ (isset($nt[0])) ? $nt[0] : '' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($tgl[0])) }}</td>
                                    <td class="text-right">{{ number_format($total[0]) }}</td>
                                </tr>
                                @php $jumlah += (int)$total[0]; @endphp
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="10">Total</th>
                                <th class="text-right">{{ number_format($jumlah) }}</th>
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            </div>
        @endisset
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
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
        });
    </script>
@endsection
