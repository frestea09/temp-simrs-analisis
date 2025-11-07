@extends('master')
@section('header')
    <h1>Satu Sehat - Request Satu Sehat</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <?php dump($json) ?>
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2()
    </script>
@endsection
