<form class="form-horizontal" id="formMapping"  method="post">
    {{ csrf_field() }} {{ method_field('POST') }}

    <input type="hidden" name="mastermapping_id" value="{{ session('mastermapping_id') }}">
    <div class="row">
        <div class="col-md-6">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Tarif</th>
                    <th>JKN/UMUM</th>
                    <th>Nominal</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($dataKiri as $key => $d)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ baca_carabayar($d->carabayar) }}</td>
                            <td>{{ number_format($d->total) }}</td>
                            <td>
                                <input type="checkbox" name="tarif{{ $no }}" value="{{ $d->id }}">
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
                    <th>JKN/UMUM</th>
                    <th>Nominal</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($dataKanan as $key => $d)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ baca_carabayar($d->carabayar) }}</td>
                            <td>{{ number_format($d->total) }}</td>
                            <td>
                                <input type="checkbox" name="tarif{{ $no }}" value="{{ $d->id }}">
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
