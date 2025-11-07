@extends('master')
@section('header')
    <h1>Log RIS</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET', 'url' => 'log-ris', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai Tanggal</button>
                        </span>
                        {!! Form::text('tgb', $tgb, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 10px">
                    <button class="btn btn-success pull-right" type="submit">TAMPILKAN</button>
                </div>

            </div>
            {!! Form::close() !!}
            <hr>
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id='logEncounter'>
                    <thead>
                        <tr>
                            <th>registrasi_id</th>
                            {{-- <th>status</th>
                            <th>service_name</th> --}}
                            <th>result</th>
                            <th>created_at</th>
                            {{-- <th>extra</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                            <tr>
                                <td>{{ $log->registrasi_id }}</td>
                                {{-- <td>
                                    @if($log->status == 'successed')
                                        <button class="btn btn-sm btn-flat btn-success">SUKSES</button>
                                    @else
                                        <button class="btn btn-sm btn-flat btn-danger">GAGAL</button>
                                    @endif
                                </td> --}}
                                {{-- <td>{{ $log->service_name }}</td> --}}
                                <td>
                                    <a target="_blank" href="/ris-json?id={{$log->id}}">
                                        <button class="btn btn-sm btn-primary">Lihat Response</button>
                                    </a>
                                </td>
                                <td>{{ date('d-m-Y H:i:s',strtotime($log->created_at)) }}</td>
                                {{-- <td>{{ $log->extra }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#logEncounter').DataTable({
            "language": {
                "url": "json/pasien.datatable-language.json",
            },
            pageLength: 10,
            processing: true,
            ordering: false,
        });

        $('.select2').select2()
    </script>
@endsection
