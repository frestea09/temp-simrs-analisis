@extends('master')
@section('header')
    <h1>Laporan RL 13B Jumlah Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <hr>
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id="data">
                    <thead>
                        <tr>
                            <th class="text-center" valign="top">No</th>
                            <th  valign="top">GOLONGAN OBAT</th>
                            <th class="text-center" valign="top">JUMLAH ITEM (obat)</th>
                            <th class="text-center" valign="top">JUMLAH OBAT YANG TERSEDIA DI RS (stok)</th>
                            <th class="text-center" valign="top">JUMLAH OBAT FORMULARIUM YANG TERSEDIA DI RS (stok)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                            <tr>
                                <td>{{$no++}}</td>
                                <td >{{$data['label']}}</td>
                                <td class="text-center">{{$data['jumlah_obat']}}</td>
                                <td class="text-center">{{$data['stok_obat']}}</td>
                                <td class="text-center">{{$data['stok_obat_formularium']}}</td>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
