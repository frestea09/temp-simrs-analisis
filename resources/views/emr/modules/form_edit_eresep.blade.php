{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
  <!-- Modal -->
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
          {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                  {{-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                  </div> --}}
                  <div class="modal-body">
                      <div class="form-group row">
                          <label for="qty" class="col-md-2 col-md-offset-1 control-label">QTY</label>
                          <div class="col-md-6">
                              <input type="number" name="qty" id="qty" class="form-control data-qty" value="" required autofocus>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                </div>
                  <div class="modal-body">
                      <div class="form-group row">
                          <label for="etiket" class="col-md-2 col-md-offset-1 control-label">Etiket</label>
                          <div class="col-md-6">
                              <input type="text" name="tiket" id="tiket" class="form-control data-etiket" value="" required autofocus>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-sm btn-flat btn-primary">Simpan</button>
                  <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Batal</button>
                </div>
        </form>
        
      </div>
    </div>