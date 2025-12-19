@extends('master')
@section('header')
    <h1>CONVERT TTE PDF</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'convert-pdf', 'class' => 'form-horizontal']) !!}
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
                        ]) !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('dokumen') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('dokumen') ? ' has-error' : '' }}"
                                type="button">Dokumen</button>
                        </span>
                        <select name="dokumen" class="select2" style="width: 100%">
                            <option value="resume" {{$dokumen == 'resume' ? 'selected' : ''}}>RESUME (RAJAL & IGD)</option>
                            <option value="resume-inap" {{$dokumen == 'resume-inap' ? 'selected' : ''}}>RESUME RAWAT INAP</option>
                            <option value="cppt-sbar" {{$dokumen == 'cppt-sbar' ? 'selected' : ''}}>CPPT & SBAR</option>
                            <option value="form-pemeriksaan" {{$dokumen == 'form-pemeriksaan' ? 'selected' : ''}}>FORM PEMERIKSAAN</option>
                            <option value="ekspertise" {{$dokumen == 'ekspertise' ? 'selected' : ''}}>EKSPERTISE</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('dokumen') }}</small>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 10px">
                    <button class="btn btn-success pull-right" type="submit">Convert</button>
                </div>

            </div>
            {!! Form::close() !!}
            <hr>
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
