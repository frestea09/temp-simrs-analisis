@extends('master')
@section('header')
    <h1>Log Bed  - {{ date('d-m-Y H:i',strtotime($log->created_at))}}</h1>
@endsection

@section('content')
    {{-- <div class="box box-primary"> --}}
        
        
            <pre>{{print_r(json_decode($log->request,true),1)}}</pre>
        
    {{-- </div> --}}
@endsection


