<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          Kunjungan Pasien Per Klinik &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Klinik</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @foreach (@$poli as $key=>$d)
                @if (!empty(@$d->poli_id))
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ !empty(@$d->poli_id) ? @baca_poli($d->poli_id)  : '' }}</td>
                    <td class="text-center">{{ @pasien_perpoli(date('Y-m-d'), $d->poli_id) }}</td>
                  </tr>
                @endif

              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>