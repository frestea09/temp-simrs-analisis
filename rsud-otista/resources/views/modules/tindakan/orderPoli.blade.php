<form class="form-horizontal" method="post" action="{{ url('tindakan/poli-ordered') }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ORDER POLI</h4>
    </div>
    <div class="modal-body">
        <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
                <tbody>
                    <tr><th>No. RM</th> <td>{{ $pasien->no_rm }}</td></tr>
                    <tr><th>Nama</th> <td>{{ $pasien->nama }}</td></tr>
                    <tr><th>Alamat</th> <td>{{ $pasien->alamat }}</td></tr>
                </tbody>
            </table>
        </div>
        {{ csrf_field() }} {{ method_field('POST') }}
        {!! Form::hidden('registrasi_id', $registrasi_id) !!}
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        <div class="form-group">
            <label class="col-sm-3 control-label">Poli Tujuan</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="poli_id" style="width: 100%">
                    @foreach ($poli as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Dokter DPJP</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="dokter_id" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <script>$('.select2').select2();</script>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Order</button>
    </div>
</form>