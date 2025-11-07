@extends('master')
@section('header')
    <h1>Farmasi - Laporan Eresep</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">

            <form method="POST" action="{{ url('farmasi/laporan-eresep') }}" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div clas="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::text('tga', $tga, ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    <select name="dokter_id" class="form-control select2">
                                        <option value="" selected>[Semua Dokter]</option>
                                        @foreach ($dokter as $item)
                                            <option value="{{ $item->id }}" {{ $dokter_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6 text-right">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" name="tampil" class="btn btn-primary btn-flat fa-file-pdf"
                                        value="TAMPILKAN">
                                    <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                                        value="EXCEL">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr />

            @if (isset($respon) && !empty($respon))
                <b>Periode : Tgl {{ $tga }} s/d {{ $tgb }}</b>
            @endif
            <br /><br />
            <div class='table-responsive'>
                @if ($respon)
                <table class='table-striped table-bordered table-hover table-condensed table' style="font-size:11px">
                    <thead>
                        <tr>
                            <th width="40px" class="text-center">No</th>
                            <th class="text-center">Dokter</th>
                            <th class="text-center">Pasien</th>
                            <th class="text-center">Poli</th>
                            <th class="text-center">E-Resep</th>
                            <th class="text-center">Apotik</th>
                            <th class="text-center">INA-CBG</th>
                            <th class="text-center">Kronis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_obat_eresep = 0;
                            $total_obat_apotik = 0;
                            $total_obat_kronis = 0;
                            $total_obat_non_kronis = 0;
                        @endphp
                            
                            @foreach ($respon as $key=>$item)
                                @php
                                    $total_obat_eresep_pasien = 0;
                                    $total_obat_apotik_pasien = 0;
                                    $total_obat_kronis_pasien = 0;
                                    $total_obat_non_kronis_pasien = 0;
                                @endphp
                                <tr>
                                <td>{{$key+1}}</td>
                                <td>{{@baca_dokter($item->dokter_id)}}</td>
                                <td>{{@baca_pasien_rm($item->pasien_id)}}</td>
                                <td>{{@baca_poli($item->poli_id)}}</td>
                                <td>
                                    @if ($item->resep_detail)
                                        @foreach ($item->resep_detail as $items)
                                            @php
                                                $totals = $items->qty*$items->logistik_batch->hargajual_jkn;
                                                $total_obat_eresep += $totals;
                                                $total_obat_eresep_pasien += $totals;
                                            @endphp
                                            - {{$items->logistik_batch->nama_obat}} <b>({{$items->qty}}) [<span style="color:green">{{($totals)}}</span>]</b><br/>
                                        @endforeach
                                        @if ($total_obat_eresep_pasien > 0)
                                            <br>
                                            <b>TOTAL: {{($total_obat_eresep_pasien)}}</b>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $penj = \App\Penjualandetail::where('penjualan_id',$item->penjualan_id)->get();
                                        @endphp
                                    @if ($penj)
                                        @foreach ($penj as $items)
                                            @php
                                                $total_obat_apotik += $items->hargajual;
                                                $total_obat_apotik_pasien += $items->hargajual;
                                            @endphp
                                                - {{$items->logistik_batch_with_trashed->nama_obat}} <b>({{$items->jumlah}}) [<span style="color:blue">{{($items->hargajual)}}</span>]</b><br/>
                                        @endforeach
                                        @if ($total_obat_apotik_pasien)
                                            <br>
                                            <b>TOTAL: {{($total_obat_apotik_pasien)}}</b>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $non_kronis = \App\Penjualandetail::where('penjualan_id',$item->penjualan_id)->where('is_kronis', 'N')->get();
                                        @endphp
                                    @if ($non_kronis)
                                        @foreach ($non_kronis as $items)
                                            @php
                                                $total_obat_non_kronis += $items->hargajual;
                                                $total_obat_non_kronis_pasien += $items->hargajual;
                                            @endphp
                                                - {{$items->logistik_batch_with_trashed->nama_obat}} <b>({{$items->jumlah}}) [<span style="color:blue">{{($items->hargajual)}}</span>]</b><br/>
                                        @endforeach
                                        @if ($total_obat_non_kronis_pasien)
                                            <br>
                                            <b>TOTAL: {{($total_obat_non_kronis_pasien)}}</b>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $kronis = \App\Penjualandetail::where('penjualan_id',$item->penjualan_id)->where('is_kronis', 'Y')->get();
                                        @endphp
                                    @if ($kronis)
                                        @foreach ($kronis as $items)
                                            @php
                                                $total_obat_kronis += $items->hargajual;
                                                $total_obat_kronis_pasien += $items->hargajual;
                                            @endphp
                                                - {{$items->logistik_batch_with_trashed->nama_obat}} <b>({{$items->jumlah}}) [<span style="color:blue">{{($items->hargajual)}}</span>]</b><br/>
                                        @endforeach
                                        @if ($total_obat_kronis_pasien)
                                            <br>
                                            <b>TOTAL: {{($total_obat_kronis_pasien)}}</b>
                                        @endif
                                    @endif
                                </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-right" colspan="4"><b>JUMLAH</b></td>
                                <td class="text-right">{{(@$total_obat_eresep)}}</td>
                                <td class="text-right">{{(@$total_obat_apotik)}}</td>
                                <td class="text-right">{{(@$total_obat_non_kronis)}}</td>
                                <td class="text-right">{{(@$total_obat_kronis)}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
            </div>
            {{-- <ul>
                <li><strong>No.RM, Nama Pasien, dan Poli</strong> baru akan muncul jika sudah di proses di menu antrian</li>
                <li><strong>Waktu Antri:</strong> Waktu ketika tiket antrian dicetak</li>
                <li><strong>Waktu Masuk Resep: </strong> Waktu ketika Nama Pasien di inputkan di antrian</li>
                <li><strong>Waktu Serah Obat: </strong> Waktu ketika tomobol panggil di kolom selesai di antrian di tekan</li>
                <li><strong>Response Time : </strong> Durasi dari waktu masuk resep hingga waktu serah obat</li>
                <li><strong>Lama Pelayanan : </strong> Durasi dari waktu antri hingga waktu serah obat</li>
            </ul> --}}
        </div>
        {{--  @include('frontoffice.ajax_lap_pengunjung')  --}}
    </div>
@endsection

@section('script')
<script>
        $(".skin-blue").addClass( "sidebar-collapse" );
        $('.select2').select2()
    </script>
@endsection
