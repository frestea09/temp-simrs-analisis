<form method="post" class="form-horizontal" action="{{ url('rawat-inap/update-inacbgs') }}">
    {{ csrf_field() }}
    {!! Form::hidden('id', $inacbgs->id) !!}
    <div class="col-sm-12">
        <div class="col-sm-6">
            <div class="form-group row">
                <label class="col-sm-5 control-label">Nama</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" readonly="readonly" value="{{ $inacbgs->pasien->nama }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-5 control-label">No Rm</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" readonly="readonly" value="{{ $inacbgs->pasien->no_rm }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-5 control-label">Registrasi</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" readonly="readonly" value="{{ $inacbgs->created_at->format('d-m-Y') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-5 control-label">INACBGS 1/2</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control text-right" readonly="readonly" value="{{ number_format($inacbgs->inacbgs1) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-5 control-label">INACBGS 2/3</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control text-right" readonly="readonly" value="{{ number_format($inacbgs->inacbgs2) }}">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group row">
                <label for="tanggal" class="col-sm-5 control-label">INAVBGS VIP</label>
                <div class="input-group col-sm-7">
                    <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                    <input type="number" class="form-control text-center" name="vip">
                </div>
            </div>
            <div class="form-group row">
                <label for="tanggal" class="col-sm-5 control-label">INAVBGS KLS 1</label>
                <div class="input-group col-sm-7">
                    <div class="input-group-addon">Rp</div>
                    <input type="number" class="form-control text-center" name="kls1">
                </div>
            </div>
            <div class="form-group row">
                <label for="tanggal" class="col-sm-5 control-label">INAVBGS KLS 2</label>
                <div class="input-group col-sm-7">
                    <div class="input-group-addon">Rp</div>
                    <input type="number" class="form-control text-center" name="kls2">
                </div>
            </div>
            <div class="form-group row">
                <label for="tanggal" class="col-sm-5 control-label">INAVBGS KLS 3</label>
                <div class="input-group col-sm-7">
                    <div class="input-group-addon">Rp</div>
                    <input type="number" class="form-control text-center" name="kls3">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row text-center">
                <input type="submit" class="btn btn-success btn-flat" value="Update">
            </div>
        </div>
    </div>
</form>