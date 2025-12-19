{!! Form::open(['method' => 'POST', 'url' => 'antrian/savetouch']) !!}
    {{-- {!! Form::hidden('loket', 'umum') !!} --}}
    {!! Form::hidden('tanggal', date('Y-m-d')) !!}
    {!! Form::submit("TEKAN DI SINI", ['class' => 'btnTouch']) !!}
{!! Form::close() !!}
