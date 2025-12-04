{!! Form::open(['method' => 'POST', 'url' => 'antrian/savetouch']) !!}
    {{-- {!! Form::hidden('loket', 'umum') !!} --}}
    {!! Form::hidden('tanggal', date('Y-m-d')) !!}
    {!! Form::submit("TEKAN DISINI", ['class' => 'btn btn-primary btn-lg','style'=>'width:200px;height:200px']) !!}
{!! Form::close() !!}
