@extends('master')
@section('header')
    <h1>Dashboard Satu Sehat</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET', 'url' => 'satusehat/dashboard', 'class' => 'form-horizontal']) !!}
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

                {{-- <div class="col-md-3">
                    <div class="input-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('status') ? ' has-error' : '' }}"
                                type="button">Status</button>
                        </span>
                        <select name="status" class="select2" style="width: 100%">
                            <option value="all" {{$status == 'all' ? 'selected' : ''}}>SEMUA</option>
                            <option value="successed" {{$status == 'successed' ? 'selected' : ''}}>SUKSES</option>
                            <option value="failed" {{$status == 'failed' ? 'selected' : ''}}>GAGAL</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                    </div>
                </div> --}}

                {{-- <div class="col-md-3">
                    <div class="input-group{{ $errors->has('service') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('service') ? ' has-error' : '' }}"
                                type="button">service</button>
                        </span>
                        <select name="service_name" class="select2" style="width: 100%">
                            <option value="all">SEMUA</option>
                            @foreach ($services as $service)
                                <option value="{{$service}}" {{$service == $service_name ? 'selected' : ''}}>{{$service}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('service') }}</small>
                    </div>
                </div> --}}
                <div class="col-md-3" style="margin-top:">
                    <button class="btn btn-success pull-left" type="submit">TAMPILKAN</button>
                </div>

            </div>
            {!! Form::close() !!}
            <hr>
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id=''>
                    <thead>
                        <tr>
                            <th>-</th>
                            <th>Registrasi</th>
                            <th>Encounter Seluruh</th>
                            <th>Sukses</th>
                            <th>Gagal</th>
                            <th>Condition</th>
                            <th>Obervation</th>
                            <th>Procedure</th>
                            <th>Compotion</th>
                            <th>Med. Request</th>
                            <th>Med. Dispense</th>
                            <th>Service Request</th>
                            <th>Spesiment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>RAJAL</td>
                            <td>{{number_format($registrasi)}}</td>
                            <td class="text-center" rowspan="3" style="vertical-align: middle">{{number_format($encounter)}}</td>
                            <td>{{number_format($encounter_sukses_rajal)}}</td>
                            <td>{{number_format($encounter_gagal_rajal)}}</td>
                            <td class="text-center" style="vertical-align: middle">{{number_format($condition_rajal)}}</td>
                            <td class="text-center" style="vertical-align: middle">{{number_format($observation_rajal)}}</td>
                            <td class="text-center" style="vertical-align: middle">{{number_format($procedure_rajal)}}</td>
                            <td class="text-center" style="vertical-align: middle">{{number_format($composition_rajal)}}</td>
                            <td class="text-center" style="vertical-align: middle">{{number_format($medication_rajal)}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>INAP</td>
                            <td>{{number_format($registrasi_inap)}}</td>
                            {{-- <td>{{number_format($encounter)}}</td> --}}
                            <td>{{number_format($encounter_sukses_inap)}}</td>
                            <td>{{number_format($encounter_gagal_inap)}}</td>
                            <td class="text-center">{{number_format($condition_inap)}}</td>
                            <td class="text-center">{{number_format($observation_inap)}}</td>
                            <td class="text-center">{{number_format($procedure_inap)}}</td>
                            <td class="text-center">{{number_format($composition_inap)}}</td>
                            <td class="text-center">{{number_format($medication_inap)}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>IGD</td>
                            <td>{{number_format($registrasi_igd)}}</td>
                            {{-- <td>{{number_format($encounter)}}</td> --}}
                            <td>{{number_format($encounter_sukses_igd)}}</td>
                            <td>{{number_format($encounter_gagal_igd)}}</td>
                            <td class="text-center">{{number_format($condition_igd)}}</td>
                            <td class="text-center">{{number_format($observation_igd)}}</td>
                            <td class="text-center">{{number_format($procedure_igd)}}</td>
                            <td class="text-center">{{number_format($composition_igd)}}</td>
                            <td class="text-center">{{number_format($medication_igd)}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        {{-- @foreach ($logs as $key => $log)
                             
                        @endforeach --}}
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
