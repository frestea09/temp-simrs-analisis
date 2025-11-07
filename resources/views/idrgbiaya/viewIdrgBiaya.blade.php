@extends('master')
@section('header')
  <h1>Master Idrg Rincian Biaya - Edit</h1>

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Idrg Rincian Biaya {{ $kelompok }}</h3>
            <a href="{{ url('idrg-biaya') }}" class="btn btn-default btn-flat"> <i class="fa fa-backward"></i></a>
        </div>
        <div class="box-body">
            <form class="form-horizontal" action="{{ url('simpan-idrg-biaya') }}"  method="post">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" name="url" value="{{ Request::segment(2) }}">
                <div class="bg-success">
                    <div class="form-group {{ $errors->has('idrg_biaya_id') ? ' has-error' : '' }}">
                        <label for="master" class="col-md-2 control-label">Ubah Tarif ke </label>
                        <div class="col-md-3">
                            <select name="idrg_biaya_id" class="chosen-select">
                                <option value=""></option>
                                @foreach ($master_biaya_id as $d)
                                    <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('idrg_biaya_id') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class='table-responsive'>
                            <table class='table table-striped table-bordered table-hover table-condensed'>
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Tarif</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Nominal</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKiri as $key => $d)
                                    <tr>
                                        <td class="text-center">{{ $no }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td class="text-center">{{ $d->jenis }}</td>
                                        <td class="text-center">{{ number_format($d->total) }}</td>
                                        <td class="text-center"><i class="fa fa-check text-danger"></i></td>
                                        <td class="text-center">
                                            <input type="checkbox" name="tarif{{ $no }}" value="{{ $d->id }}">
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class='table-responsive'>
                            <table class='table table-striped table-bordered table-hover table-condensed'>
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Tarif</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Nominal</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKanan as $key => $d)
                                    <tr>
                                        <td class="text-center">{{ $no }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td class="text-center">{{ $d->jenis }}</td>
                                        <td class="text-center">{{ number_format($d->total) }}</td>
                                        <td class="text-center"><i class="fa fa-check text-danger"></i></td>
                                        <td class="text-center">
                                            <input type="checkbox" name="tarif{{ $no }}" value="{{ $d->id }}">
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="total" value="{{ $tarif->count() }}">
                        <input type="submit" name="submit" value="SIMPAN" class="btn btn-primary" style="position: fixed; bottom: 20px; right: 40%">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('table').DataTable({
            paging      : false,
            lengthChange: false,
            searching   : true,
            ordering    : true,
            info        : true,
            autoWidth   : false
        });
    </script>    
@endsection
