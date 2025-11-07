{!! Form::open(['method' => 'POST', 'url' => 'antrian2/savetouch']) !!}
    {!! Form::hidden('loket', 'bpjs') !!}
    {!! Form::hidden('tanggal', date('Y-m-d')) !!}
    {!! Form::submit("TEKAN DI SINI", ['class' => 'btnTouch']) !!}
{!! Form::close() !!}
