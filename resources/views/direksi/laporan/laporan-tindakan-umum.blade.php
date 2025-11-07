@extends('master')
@section('header')
    <h1>Laporan Tindakan<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"></div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => '/direksi/laporan-tindakan-umum', 'class'=>'form-horizontal']) !!}
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
                {{-- <div class="form-group">
                    <label class="col-md-3 control-label">Tindakan</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="tarif_id">
                        <option value="0" {{ ($tarif_id == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($tindakan as $t)
                            <option value="{{ $t->id }}" {{ ($tarif_id == $t->id) ? 'selected' : '' }}>{{ $t->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-5">
                {{-- <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Dokter</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="dokter_id">
                            <option value="0" {{ ($dokter_id == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($dokter as $d)
                            <option value="{{ $d->id }}" {{ ($dokter_id == $d->id) ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="jenis_pasien"> --}}
                            {{-- <option value="0" {{ ($jenis_pasien == 0) ? 'selected' : '' }}>SEMUA</option> --}}
                        {{-- @foreach ($cara_bayar as $cb) --}}
                            {{-- <option value="{{ $cb->id }}" {{ ($jenis_pasien == $cb->id) ? 'selected' : '' }}>{{ $cb->carabayar }}</option> --}}
                        {{-- @endforeach --}}
                        {{-- </select>
                    </div>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Asal Tindakan</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="asal_tindakan">
                            <option value="semua" {{ ($asal_tindakan == "semua") ? 'selected' : '' }}>Semua</option>
                            <option value="TA" {{ ($asal_tindakan == "TA") ? 'selected' : '' }}>Rawat Jalan</option>
                            <option value="TI" {{ ($asal_tindakan == "TI") ? 'selected' : '' }}>Rawat Inap</option>
                            <option value="TG" {{ ($asal_tindakan == "TG") ? 'selected' : '' }}>IGD</option>
                        </select>
                    </div>
                </div> --}}
                <div class="pull-left form-group">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
                    <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        {{-- ================================================================================================== --}}
        @isset($tindakan_pasien_new)
            <div class='table-responsive'>
                <table class='table table-bordered table-hover' style="font-size:11px;">
                    <thead>
                        <tr class="text-center">
                            {{-- <th class="text-center">No</th> --}}
                            <th class="text-center">Reg_ID</th>
                            <th class="text-center">No. RM</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Pelayanan</th>
                            <th class="text-center">Tindakan</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tindakan_pasien_new->get() as $key=>$item)
                        @php
                            $tgl = @date('d-m-Y H:i',strtotime($item->tgl_reg));
                            $tgl_now  = @date('Y-m',strtotime($item->tgl_reg));
                            $fol = \Modules\Registrasi\Entities\Folio::
                            where('registrasi_id',$item->registrasi_id)
                            ->where('cara_bayar_id', '!=', 1) //AMBIL FOLIOS YANG CARA BAYAR ID TIDAK SAMA DENGAN 1
                            ->where('lunas', 'N')
                            ->where('created_at','LIKE',$tgl_now.'%')
                            ->select('namatarif','total')
                            ->get();
                        @endphp
                            <tr>
                                <td>{{$item->registrasi_id}}</td>
                                <td>{{$item->no_rm}}</td>
                                <td>{{$item->nama_pasien}}</td>
                                <td>{{cek_jenis_lis($item->status_reg)}}</td>
                                
                                <td>
                                    <ul>
                                        @if (count($fol) > 0)
                                            @foreach ($fol as $items)
                                                <li>{{$items->namatarif}} - {{$items->total}}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td>{{$item->total}}</td>
                                <td>{{$tgl}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <th class="text-center" colspan="11">Total</th>
                            <th class="text-right">{{ number_format(@$grandTotal) }}</th>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
        
        @endisset
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.select2').select2()
        $(".skin-blue").addClass( "sidebar-collapse" );
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
