@extends('master')
@section('header')
  <h1>Histori Pasien<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-md-8">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered table-hover">
              <tbody>
                <tr>
                  <th>Nama Lengkap</th><td>{{ !empty($pasien) ? $pasien->nama :NULL }}</td>
                </tr>
                <tr>
                  <th>Nomor RM Baru</th><td><b>{{ !empty($pasien) ?$pasien->no_rm :NULL }}</b></td>
                </tr>
                <tr>
                  <th>Nomor RM Lama</th><td>{{ !empty($pasien) ? $pasien->no_rm_lama : NULL }}</td>
                </tr>
                <tr>
                  <th>Alamat</th><td>{{ !empty($pasien) ? $pasien->alamat : NULL }} rt: {{ !empty($pasien) ? $pasien->rt : NULL }} rw: {{ !empty($pasien) ? $pasien->rw : NULL }}</td>
                </tr>
                <tr>
                  <th>Ibu Kandung</th><td>{{ !empty($pasien) ? $pasien->ibu_kandung : NULL }}</td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-4">
          {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/histori-pasien', 'class'=>'form-hosizontal']) !!}
            <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
                </span>
                {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('no_rm') }}</small>
            </div>
         {!! Form::close() !!}

        </div>
      </div>
    @php
      $role = Auth::user()->role()->first()->name;
    @endphp

    <div class="table-responsive">
      <table class="table table-condensed table-bordered table-hover">
        <thead>
          <tr class="bg-primary">
            <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Klinik</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Lab</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Radiologi</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tindakan</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Obat</th>
            <th colspan="3" class="text-center">Rawat Inap</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">S</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">O</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">A</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">P</th>
          </tr>
          <tr class="bg-primary">
            <th class="text-center">Tanggal Masuk</th>
            <th class="text-center">Kamar</th>
            <th class="text-center">Tanggal Keluar</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($reg))
            @foreach ($reg as $d)
              @php
                $rj = App\HistorikunjunganIRJ::where('registrasi_id', $d->id)->first();
                $lab = App\HistorikunjunganLAB::where('registrasi_id', $d->id)->get();
                $rad = App\HistorikunjunganRAD::where('registrasi_id', $d->id)->get();
                $ri = App\Rawatinap::where('registrasi_id', $d->id)->first();
                $folio= Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->id)->get();
              @endphp
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>
                  @foreach ($lab as $l)
                    {{ $l->created_at->format('d-m-Y H:i:s') }} <br>
                  @endforeach
                </td>
                <td>
                  @foreach ($rad as $r)
                    {{ $r->created_at->format('d-m-Y H:i:s') }} <br>
                  @endforeach
                </td>
                 <td>
                  @foreach ($folio as $f)
                    + {{ $f->namatarif }} <br>
                  @endforeach
                </td>
                <td>
                  @php
                  $total_obat = 0;
                  foreach ($folio as $f){
                    $total_obat += $f->total;
                  }
                  @endphp
                  {{ number_format($total_obat) }}
                </td>
                <td>
                  {{ !empty($ri) ? tanggal($ri->tgl_masuk) : NULL }}
                </td>
                <td>
                  {{ !empty($ri) ? baca_kamar($ri->kamar_id) : NULL }}
                </td>
                <td>
                  {{ !empty($ri) ? tanggal($ri->tgl_keluar) : NULL }}
                </td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </tr>
            @endforeach
          @else
            <tr>
              <th colspan="8" class="text-center"><h4>Data tidak ditemukan!!!</h4></th>
            </tr>
          @endif
        </tbody>
      </table>
    </div>


    <div class="box-footer">
    </div>
  </div>

  {{-- MODAL UBAH STATUS PELAYANAN --}}
  <div class="modal fade" id="pelayanan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <h4 style="font-size: 12pt; font-weight: bold;">Status : <span class="status"></span></h4>
          {!! Form::open(['method' => 'POST', 'class'=>'form-horizontal', 'id' => 'formStatus']) !!}
            <input type="hidden" name="registrasi_id" value="">
            <div class="form-group">
              <label for="status" class="col-md-4 control-label">Kembalikan Status Ke</label>
              <div class="col-lg-8">
                <select name="status_reg" class="form-control">
                  {{-- <option value="">--</option> --}}
                  <option value="J2">RAWAT JALAN</option>
                  <option value="G2">RAWAT DARURAT</option>
                  <option value="I1">ANTRIAN INAP</option>
                  <option value="I2">RAWAT INAP</option>
                  <option value="I3">PULANGKAN</option>
                </select>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanStatus()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL UBAH STATUS PELAYANAN --}}
  <div class="modal fade" id="pelayananbeluminap">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <h4 style="font-size: 12pt; font-weight: bold;">Status : <span class="status"></span></h4>
          {!! Form::open(['method' => 'POST', 'class'=>'form-horizontal', 'id' => 'formStatus']) !!}
            <input type="hidden" name="registrasi_id" value="">
            <div class="form-group">
              <label for="status" class="col-md-4 control-label">Kembalikan Status Ke</label>
              <div class="col-lg-8">
                <select name="status_reg" class="form-control">
                  {{-- <option value="">--</option> --}}
                  <option value="J2">RAWAT JALAN</option>
                  <option value="G2">RAWAT DARURAT</option>
                  <option value="I1">ANTRIAN INAP</option>
                </select>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanHistori()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
    function ubahPelayanan(registrasi_id) {
      $('#pelayanan').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
        }
      });
    }

     function ubahPelayananbeluminap(registrasi_id) {
      $('#pelayananbeluminap').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
        }
      });
    }

    function simpanStatus() {
      $.ajax({
        url: '/ubah-status-pelayanan',
        type: 'POST',
        dataType: 'json',
        data: $('#formStatus').serialize(),
        success: function (data) {
          if (data.sukses == true) {
            window.location.href = '/frontoffice/histori-pasien/'+data.pasien_id;
          }
        }
      });

    }


    function simpanHistori() {
      $.ajax({
        url: '/ubah-status-pelayanan',
        type: 'POST',
        dataType: 'json',
        data: $('#formStatus').serialize(),
        success: function (data) {
          if (data.sukses == true) {
            window.location.href = '/frontoffice/histori-pasien/'+data.pasien_id;
          }
        }
      });

    }
  </script>
@endsection
