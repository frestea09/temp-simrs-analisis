@extends('master')

@section('header')
    <h1>Saldo Kas dan Bank </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Data Saldo Kas dan Bank &nbsp;
            </h3>
        </div>
        <div class="box-body">
            <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Akun</th>
                            <th>Nama</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Saldo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                {{-- <td>{{ $key + 1 }}</td> --}}
                                <td>{{ $d['code'] }}</td>
                                <td>{{ $d['nama'] }}</td>
                                <td>{{ number_format((int) $d['debit']) }}</td>
                                <td>{{ number_format((int) $d['credit']) }}</td>
                                <td>{{ number_format((int) $d['saldo']) }}</td>
                                <td>
                                    @if ((int) $d['saldo'] > 0)
                                        <a href="{{ route('saldo.kas_bank.transfer', $d['id']) }}"
                                            class="btn btn-info btn-sm"><i class="fa fa-credit-card"></i>
                                            Pindah Saldo</a>
                                    @endif
                                </td>
                                {{-- <td>
                                    <a href="{{ route('politype.edit', $d['id']) }}" class="btn btn-info btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
