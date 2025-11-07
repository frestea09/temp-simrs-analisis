@extends('master')
@section('header')
    <h1>Operasi - Laporan Pengunjung<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"></div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'operasi/laporan/laporan-operasi', 'class'=>'form-horizontal']) !!}
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Periode</label>
                    <div class="col-md-4">
                        <input type="text" name="tga" value="{{ $tga }}" class="form-control datepicker" autocomplete="off" >
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="tgb" value="{{ $tgb }}" class="form-control datepicker" autocomplete="off" >
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tindakan</label>
                    <div class="col-md-8">
                        {{-- <select class="form-control select2" style="width: 100%" name="tarif_id">
                            <option value="0" {{ ($tarif_id == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($tindakan as $t)
                            <option value="{{ $t->tarif_id }}" {{ ($tarif_id == $t->tarif_id) ? 'selected' : '' }}>{{ $t->namatarif }}</option>
                        @endforeach
                        </select> --}}
                        <select name="tarif_id" id="tarif_id" class="form-control">
                                  
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="depo" class="col-sm-3 control-label">Kamar</label>
                    <div class="col-sm-8">
                    <select name="kamar" class="form-control select2" style="width: 100%">
                        <option value="">-- Semua Kamar --</option>
                        @foreach ($kamar as $id => $nama)
                            <option value="{{ $id }}" {{ @$filter_kamar == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Dokter</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="dokter_id">
                            <option value="0" {{ ($dokter_id == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($dokter as $d)
                            <option value="{{ $d->id }}" {{ ($dokter_id == $d->id) ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="jenis_pasien">
                            <option value="0" {{ ($jenis_pasien == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($cara_bayar as $cb)
                            <option value="{{ $cb->id }}" {{ ($jenis_pasien == $cb->id) ? 'selected' : '' }}>{{ $cb->carabayar }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="pull-left form-group">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
                    <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
                    <input type="submit" name="pdf" class="btn btn-danger btn-flat" value="CETAK">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        @php
            $subtotal = 0;
        @endphp
        {{-- ================================================================================================== --}}
        @isset($operasi_new)
            <div class='table-responsive'>
                <table class='table table-bordered table-hover' style="font-size:12px;">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">No. RM</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">L/P</th>
                            <th class="text-center">Bayar</th>
                            <th class="text-center">Dr. Bedah</th>
                            <th class="text-center">Dr. Anestesi</th>
                            <th class="text-center">Dr. Anak</th>
                            <th class="text-center">Perawat</th>
                            <th class="text-center">Tindakan</th>
                            <th class="text-center">Cito</th>
                            <th class="text-center">Poli</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Tarif</th>
                            <th class="text-center">Kamar</th>
                            <th class="text-center">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($operasi_new as $key => $d)
                    @php
                        $reg = Modules\Registrasi\Entities\Registrasi::find($key);
                        $total    = count($d);
                    @endphp
                    <tr>
                        <td rowspan="{{$total}}" class="text-center">{{$no++}}</td>
                        {{-- <td><button data-toggle="collapse" data-target="#{{$key}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span> Detail Obat</button> {{@$reg->pasien->no_rm}}</td> --}}
                        <td rowspan="{{$total}}">{{@$reg->pasien->no_rm}}</td>
                        <td rowspan="{{$total}}">{{@$reg->pasien->nama}}</td>
                        <td rowspan="{{$total}}" class="text-center">{{ @$reg->status == 'baru' ? 'Baru' : 'Lama' }}</td>
                        <td rowspan="{{$total}}" class="text-center">{{ @$reg->pasien->kelamin }}</td>
                        {{-- <td>IBS / Operasi</td> --}}
                        <td class="text-center" rowspan="{{$total}}">{{ strtoupper(baca_carabayar(@$reg->bayar)) }} {{ !empty(@$$reg->tipe_jkn) ? ' - '.@$reg->tipe_jkn : '' }}</td>
                        {{-- @if($total > 1) --}}
                        @php
                            $subtotal = 0;
                        @endphp
                            @foreach($d as $k => $t)
                            {{-- {{dd($t)}} --}}
                            @php
                                $subtotal += $t->total;
                                $nt     = $t->namatarif;
                                $tid     = $t->tarif_id;
                                $cito     = $t->cyto;
                                $poli     = @$t->poli_id;
                                $total  = $t->total;
                                $dokter = $t->dokter_bedah;
                                $perawat = $t->perawat;
                                // $perawat = $t->perawat_ibs1;
                                $kamar = $t->kamar_id;
                                $anestesi= $t->dokter_anestesi; 
                                $anak= $t->dokter_anak; 
                                $tgl    = $t->created_at;
                                $catatan    = $t->catatan;
                            @endphp
                                {{-- <td>{{ (isset($dokter[$k])) ? baca_dokter($dokter[$k]) : '' }}</td>
                                <td>{{ (isset($anestesi[$k])) ? baca_dokter($anestesi[$k]) : '' }}</td>
                                <td>{{@\Modules\Tarif\Entities\Tarif::find($tid[$k])->kategoritarif->namatarif}}-{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                <td>{{ @$cito[$k] !== NULL ? 'Ya' : 'Tidak' }}</td>
                                <td>-</td>
                                <td class="text-right">{{ @number_format($t) }}</td>
                                <td>{{ @$kamar[$k] ? @baca_kamar($kamar[$k]) : '' }}</td>
                                <td>{{ @$catatan[$k] ? @$catatan[$k] : '' }}</td> --}}
                                @if($k !== 0)
                            {{-- @else --}}
                                <tr>
                                @endif
                                    <td>{{ @baca_dokter(@$dokter)}}</td>
                                    <td>{{ @baca_dokter(@$anestesi)}}</td>
                                    <td>{{ @baca_dokter(@$anak)}}</td>
                                    <td>{{ @baca_pegawai(@$perawat)}}</td>
                                    {{-- <td>
                                        @isset($perawat)
                                            @if ($perawat == 1)
                                                <i>Perawat Bedah</i>
                                            @elseif($perawat == 2)
                                                <i>Perawat Anestesi</i>
                                            @endif
                                        @endisset
                                    </td> --}}
                                    <td>{{@$t->tarif->kategoritarif->namatarif}} <b>-</b> {{ $nt }}</td>
                                    
                                    <td>{{ @$cito !== NULL ? 'Ya' : 'Tidak' }}</td>
                                    @if ($poli == null)
                                    <td>{{ baca_poli(@$reg->poli_id) }}</td>
                                    @else
                                    <td>{{ baca_poli(@$poli) }}</td>
                                    @endif
                                    <td>{{date('d-m-Y',strtotime(@$tgl))}}</td>
                                    <td class="text-right">{{number_format($t->total)}}</td>
                                    <td>{{ @baca_kamar($kamar) }}</td>
                                    <td>{{ @$catatan }}</td>
                                </tr>
                            {{-- @endif --}}
                            @endforeach
                        </tr>
                                
                    {{-- <tr>
                        <td colspan="2">
                          <div class="accordian-body collapse show" id="{{$key}}"> 
                            <table class="table table-striped">
                                <thead>
                                  <tr class="info">
                                    <th>Nama Obat</th>
                                    <th>Stok Gudang</th>
                                    <th>Qty</th>
                                  </tr>
                                </thead>
                            </table>
                          </div>
                        </td>
                    </tr> --}}
                    @endforeach
                    {{-- @php $jumlah = 0; @endphp
                    @foreach ($operasi as $key => $d)
                        @php
                            $nt     = explode('||', $d->namatarif);
                            $tid     = explode('||', $d->tarif_id);
                            $cito     = explode('||', $d->cito);
                            $total  = explode('||', $d->total);
                            $dokter = explode('||', $d->dokter);$kamar = explode('||', $d->kamar);
                            $anestesi= explode('||', $d->anestesi);$tgl    = explode('||', $d->tanggal);
                            $catatan    = explode('||', $d->catatan);$catatan    = explode('||', $d->catatan);
                        @endphp
                        <tr>
                            <td class="text-center" rowspan="{{ count($total) }}">{{ $no++ }}</td>
                            <td rowspan="{{ count($total) }}">{{ $d->pasien->no_rm }}</td>
                            <td rowspan="{{ count($total) }}">{{ $d->pasien->nama }}</td>
                            <td class="text-center" rowspan="{{ count($total) }}">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                            <td class="text-center" rowspan="{{ count($total) }}">{{ $d->pasien->kelamin }}</td>
                            <td rowspan="{{ count($total) }}">IBS / Operasi</td>
                            <td class="text-center" rowspan="{{ count($total) }}">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                        @if(count($total) > 1)
                            @foreach($total as $k => $t)
                                @if($k == 0)
                                    <td>{{ (isset($dokter[$k])) ? baca_dokter($dokter[$k]) : '' }}</td>
                                    <td>{{ (isset($anestesi[$k])) ? baca_dokter($anestesi[$k]) : '' }}</td>
                                    <td>{{@\Modules\Tarif\Entities\Tarif::find($tid[$k])->kategoritarif->namatarif}}-{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                    <td>{{ @$cito[$k] !== NULL ? 'Ya' : 'Tidak' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                    <td class="text-right">{{ number_format($t) }}</td>
                                    <td>{{ @$kamar[$k] ? @baca_kamar($kamar[$k]) : '' }}</td>
                                    <td>{{ @$catatan[$k] ? @$catatan[$k] : '' }}</td>
                                @else
                                    <tr>
                                        <td>{{ (isset($dokter[$k])) ? baca_dokter($dokter[$k]) : '' }}</td>
                                        <td>{{ (isset($anestesi[$k])) ? baca_dokter($anestesi[$k]) : '' }}</td>
                                        <td>{{@\Modules\Tarif\Entities\Tarif::find($tid[$k])->kategoritarif->namatarif}}-{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                        <td>{{ (@$cito[$k] !== NULL) ? 'Ya' : 'Tidak' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                        <td class="text-right">{{ number_format($t) }}</td>
                                        <td>{{ @$kamar[$k] ? @baca_kamar($kamar[$k]) : '' }}</td>
                                        <td>{{ @$catatan[$k] ? @$catatan[$k] : '' }}</td>
                                    </tr>
                                @endif
                                @php $jumlah += (int)$t; @endphp
                            @endforeach
                        @else
                                <td>{{ baca_dokter($dokter[0]) }}</td>
                                <td>{{ baca_dokter($anestesi[0]) }}</td>
                                <td>{{@\Modules\Tarif\Entities\Tarif::find($tid[0])->kategoritarif->namatarif}}-{{(isset($nt[0])) ? $nt[0] : '' }}</td>
                                <td>{{ ($cito[0] !== NULL) ? 'Ya' : 'Tidak' }}</td>
                                <td>{{ date('d-m-Y', strtotime($tgl[0])) }}</td>
                                <td class="text-right">{{ number_format($total[0]) }}</td>
                                <td>{{ @$kamar[0] ? @baca_kamar($kamar[0]) : '' }}</td>
                                <td>{{ @$catatan[0] ? @$catatan[0] : '' }}</td>
                            </tr>
                            @php $jumlah += (int)$total[0]; @endphp
                        @endif
                    @endforeach --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center" colspan="11">Total</th>
                            <th class="text-right">{{ number_format($subtotal) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- <div class='table-responsive'>
                <table class='table table-bordered table-hover' style="width:650px">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Dokter Pelaksana</th>
                            <th class="text-center" width="100px">Total Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $_no = 1; @endphp
                    @foreach ($detail_dokter as $dd)
                        <tr>
                            <td class="text-center" width="15px">{{ $_no++ }}</td>
                            <td>{{ baca_dokter($dd->dokter_bedah) }}</td>
                            <td class="text-center">{{ $dd->jumlah }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> --}}
        @endisset
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.select2').select2()
        $(".skin-blue").addClass( "sidebar-collapse" );
        // TINDAKAN
        $('#tarif_id').select2({
            placeholder: "Klik untuk cari tindakan",
            width: '100%',
            ajax: {
                url: '/operasi/ajax-get-tindakan/',
                dataType: 'json',
                data: function (params) {
                    return {
                        j: 1,
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })
        $(document).ready(function() {
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
