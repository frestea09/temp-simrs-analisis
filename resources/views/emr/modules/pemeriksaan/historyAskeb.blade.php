<div id="data-list-askep">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th>Tipe</th>
          <th>Jam Tindakan</th>
          <th>Diagnosa</th>
          <th>Intervensi</th>
          <th>Implementasi</th>
          <th>Tgl Regis</th>
          <th>Cetak</th>
          <th>TTE</th>
          <th>Hapus</th>
        </tr>
      </thead>
      <tbody>
        {{-- {{ dd($data) }} --}}
        @if (count($data) > 0)
          @foreach ($data as $key => $d)
            <tr>
              <td>
                {{@$d['type'] == "asuhan-keperawatan" ? 'Asuhan Keperawatan' : 'Asuhan Kebidanan'}}
              </td>
              <td>
                @if ($d['fisik'])
                    @if (is_array($d['fisik']))
                        @foreach ($d['fisik'] as $jam)
                            *{{date('d-m-Y H:i', strtotime($jam))}} <br>
                        @endforeach
                    @else
                      {{date('d-m-Y H:i', strtotime($d['fisik']))}}
                    @endif
                @else
                  -
                @endif
              </td>
              <td>
                @if (is_array($d['diagnosis']))
                  @foreach ($d['diagnosis'] as $diagnosa)
                    *{{ $diagnosa }} <br>
                  @endforeach
                @endif
              </td>
              <td>
                @if (is_array($d['siki']))
                  @foreach ($d['siki'] as $intervensi)
                    *{{ $intervensi }} <br>
                  @endforeach
                @endif
              </td>
              <td>
                @if (is_array($d['implementasi']))
                  @foreach ($d['implementasi'] as $implementasi)
                    *{{ $implementasi }}
                  @endforeach
                @endif
              </td>
              <td>
                {{ $d['tglRegis'] }}
              </td>
              <td>
                @if ($d['type'] == 'asuhan-keperawatan')
                <a href="{{ url('cetak-asuhan-keperawatan/pdf/'.$d['regId'].'/'.$d['askebId']) }}" class="btn btn-sm btn-info" target="_blank">
                  <span class="fa fa-print"></span>
                </a>
                @else
                <a href="{{ url('cetak-asuhan-kebidanan/pdf/'.$d['regId'].'/'.$d['askebId']) }}" class="btn btn-sm btn-info" target="_blank">
                  <span class="fa fa-print"></span>
                </a>
                @endif
              </td>
              <td>
                <button type="button" data-current-url="" class="btn btn-sm btn-warning button_tte_askeb" data-registrasi-id="{{$d['regId']}}" data-askeb-id="{{$d['askebId']}}">
                  <span class="fa fa-pencil"></span>
                </button>
              </td>
              <td>
                @if ($d['type'] == 'asuhan-keperawatan')
                <form action="{{ url('emr-riwayat-askep/delete/'.$d['askebId']) }}" method="POST" class="form_hapus_askep">
                  {{csrf_field()}}
                  <button class="btn btn-sm btn-danger button_hapus_askep" type="button">
                    <span class="fa fa-trash"></span>
                  </button>
                </form>
                @else
                <form action="{{ url('emr-riwayat-askeb/delete/'.$d['askebId']) }}" method="POST" class="form_hapus_askep">
                  {{csrf_field()}}
                  <button class="btn btn-sm btn-danger button_hapus_askep" type="button">
                    <span class="fa fa-trash"></span>
                  </button>
                </form>
                @endif
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="5">
              <span style="text-align: center">Tidak Ada Asuhan Kebidanan Sebelumnya</span>
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<script>
  $('.button_hapus_askeb').click(function (e) {
    $('form.form_hapus_askeb').submit();
  })

  $('.button_tte_askeb').click(function () {
    $('#showHistoriAskeb').modal('hide');
    $('#modalAskeb').modal('show');
    $('#askeb_id_hidden').val($(this).data("askeb-id"))
    $('#registrasi_id_hidden').val($(this).data("registrasi-id"))
  })

  $('#proses-tte-askeb').click(function (e) {
    e.preventDefault();
    $('#form-tte-askeb').submit();
  })
</script>