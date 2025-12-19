<div id="modalAskeb" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="width: 100%; padding: 0 2rem;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Asuhan Kebidanan</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
        <form id="form-tte-askeb" action="{{url('emr-riwayat-askeb/tte')}}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="askeb_id" id="askeb_id_hidden">
            <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden">
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}">
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="proses-tte-askeb">Proses TTE</button>
        </div>
      </div>
  </div>
</div>