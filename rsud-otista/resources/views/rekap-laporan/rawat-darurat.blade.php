@extends('master')
@section('header')
  <h1>Mapping Rawat Darurat (RL 3.2)</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Master Mapping
      </h3>
    </div>
    <div class="box-body">
        <div id="viewMapping"></div>

    </div>
  </div>

  <div class="modal fade" id="modalMapping" tabindex="-1"  role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="masterMappingForm"  method="post">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" name="id" value="">
                <div class="form-group" id="mappingGroup">
                  <label for="mapping" class="col-md-3 control-label">Nama Mapping</label>
                  <div class="col-md-9">
                      <input type="text" name="mapping" class="form-control" >
                      <span class="text-danger" id="mappingError"></span>
                  </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" onclick="saveForm()" class="btn btn-success btn-flat">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
