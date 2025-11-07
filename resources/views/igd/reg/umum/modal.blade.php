<!-- Modal -->
<div id="myModalDokterPerujuk" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Dokter Perujuk</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="myModalPuskesmas" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Puskesmas</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="myModalFormPuskesmas" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <form id="formSavePuskesmas" method="POST" action="{{ url('ajax/savePuskesmas') }}">
      {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Puskesmas</h4>
      </div>
      <div class="modal-body row" style="display:grid">
        <div class="form-group">
          <label class="control-label col-sm-2">Nama:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control puskesmas-nama" name="nama" placeholder="Nama Puskesmas" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Alamat:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control puskesmas-alamat" name="alamat" placeholder="Alamat Puskesmas">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-submit-puskesmas">Submit</button>
      </div>
    </div>
    </form>

  </div>
</div>

<!-- Modal -->
<div id="myModalFormDokterPerujuk" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <form id="formSaveDokterPerujuk" method="POST" action="{{ url('ajax/saveDokterPerujuk') }}">
      {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Dokter Perujuk</h4>
      </div>
      <div class="modal-body row" style="display:grid">
        <div class="form-group">
          <label class="control-label col-sm-2">Nama:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control perujuk-nama" name="nama" placeholder="Nama Dokter Perujuk" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Alamat:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control perujuk-alamat" name="alamat" placeholder="Alamat Dokter Perujuk">
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-submit-dokter-perujuk">Submit</button>
      </div>
    </div>
    </form>

  </div>
</div>