{!! Form::open(['method' => 'POST', 'url' => 'antrian/savetouch']) !!}
    {!! Form::hidden('loket', 'bpjs') !!}
    {!! Form::hidden('tanggal', date('Y-m-d')) !!}
    {!! Form::submit("BPJS", ['class' => 'btn btn-success']) !!}
{!! Form::close() !!}
