@extends('master')
@section('header')
    <h1>E Sign - Log Koneksi E Sign</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET', 'url' => 'esign/log', 'class' => 'form-horizontal']) !!}
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

                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('status') ? ' has-error' : '' }}"
                                type="button">Status</button>
                        </span>
                        <select name="status" class="select2" style="width: 100%">
                            <option value="all" {{$status == 'all' ? 'selected' : ''}}>SEMUA</option>
                            <option value="success" {{$status == 'success' ? 'selected' : ''}}>SUKSES</option>
                            <option value="fail" {{$status == 'fail' ? 'selected' : ''}}>GAGAL</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('service') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('service') ? ' has-error' : '' }}"
                                type="button">Type</button>
                        </span>
                        <select name="type" class="select2" style="width: 100%">
                            <option value="all">SEMUA</option>
                            @foreach ($type_name as $type_name)
                                <option value="{{$type_name}}" {{$type_name == $type ? 'selected' : ''}}>{{$type_name}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('service') }}</small>
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
                            <th>Registrasi ID</th>
                            <th>status</th>
                            <th>type</th>
                            <th>result</th>
                            <th>created_at</th>
                            {{-- <th>extra</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                        @php
                            $response = json_decode($log->response, true);
                            $jsonresponse = json_encode($response, JSON_PRETTY_PRINT);
                            // $extra = json_decode($log->extra, true);
                            // $jsonExtra = json_encode($extra, JSON_PRETTY_PRINT);
                        @endphp
                            <tr>
                                <td>{{ @$log->registrasi_id }}</td>
                                <td>
                                    @if($log->status == 'success')
                                        <button class="btn btn-sm btn-flat btn-success">SUKSES</button>
                                    @else
                                        <button class="btn btn-sm btn-flat btn-danger">GAGAL</button>
                                    @endif
                                </td>
                                <td>{{ $log->type }}</td>
                                <td><pre style="background-color: rgb(40, 38, 38); color: white; width:500px;">{!! @$jsonresponse !!}</pre></td>
                                <td>{{ date('d-m-Y H:i:s',strtotime($log->created_at)) }}</td>
                                {{-- <td><pre style="background-color: rgb(40, 38, 38); color: white; width:300px;">{!! @$jsonExtra !!}</pre></td> --}}
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
