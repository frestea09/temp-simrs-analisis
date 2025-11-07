<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Idrg</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($idrg as $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->idrg }}</td>
              <td>
                  <div class="btn-group">
                      <button type="button" onclick="editForm('{{ $d->id }}')" class="btn btn-info btn-flat btn-sm">
                          <i class="fa fa-edit"></i>
                      </button>

                      <a href="{{ url('idrg/'.$d->id) }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-map"></i> </a>
                      <button type="button" onclick="detailIdrg('{{ $d->id }}')" class="btn btn-warning btn-flat btn-sm">
                          <i class="fa fa-folder-open"></i>
                      </button>

                  </div>

              </td>
            </tr>
        @endforeach

    </tbody>
  </table>
</div>

KETERANGAN TOMBOL: <br>
<button type="button" class="btn btn-info btn-flat btn-sm">
  <i class="fa fa-edit"></i>
</button> EDIT

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<button type="button" class="btn btn-primary btn-flat btn-sm">
  <i class="fa fa-map"></i>
</button> IDRG

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<button type="button" class="btn btn-warning btn-flat btn-sm">
  <i class="fa fa-folder-open"></i>
</button> DETAIL


<div class="modal fade" id="modalDetailIdrg" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
          <div class='table-responsive'>
            <table id='tableDetailIdrg' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tarif</th>
                  <th>Cara Bayar</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody> </tbody>
            </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
