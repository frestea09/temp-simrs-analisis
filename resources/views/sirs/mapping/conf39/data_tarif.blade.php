<form class="form-horizontal" id="formMapping"  method="post">
    {{ csrf_field() }} {{ method_field('POST') }}

    <input type="hidden" name="conf_rl39_id" value="{{ session('conf_rl39_id') }}">
    Checked All : <input type="checkbox" onclick="toggle(this);"/>
    </br></br>
    <div class="row">
        <div class="col-md-6">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Tarif</th>
                    <th>Nominal</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($dataKiri as $key => $d)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ number_format($d->total) }}</td>
                            <td>
                                <input type="checkbox" name="tarif[]" value="{{ $d->id }}">
                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Tarif</th>
                    <th>Nominal</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($dataKanan as $key => $d)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ number_format($d->total) }}</td>
                            <td>
                                <input type="checkbox" name="tarif[]" value="{{ $d->id }}">
                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                </tbody>
              </table>
            </div>
            <input type="hidden" name="total" value="{{ $tarif->count() }}">
            <button type="button" name="button" onclick="saveMapping()" class="btn btn-default btn-flat">SIMPAN</button>
        </div>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" language="Javascript">
  function toggle(source) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i] != source)
              checkboxes[i].checked = source.checked;
      }
  }
</script>