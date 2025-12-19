@extends('master')
@section('header')
  <h1>Verifikator Rawat Jalan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class='table-responsive'>
        {!! Form::open(['method' => 'POST', 'url' => '/kasir/verifikasi-kasa', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div>
          </div>
        {!! Form::close() !!}
        <hr>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle;">No</th>
              <th class="text-center" style="vertical-align: middle;">Nomor RM</th>
              <th class="text-center" style="vertical-align: middle;">Nama</th>
              <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
              <th class="text-center" style="vertical-align: middle;">Layanan</th>
              <th class="text-center" style="vertical-align: middle;">Dokter</th>
              <th class="text-center" style="vertical-align: middle;">Klinik Tujuan</th>
              <th class="text-center" style="vertical-align: middle;">Tgl Masuk</th>
              <th class="text-center" style="vertical-align: middle;">Verifikasi</th>
              {{-- <th class="text-center" style="vertical-align: middle;">Cetak</th> --}}
            </tr>
          </thead>
          <tbody>

            @foreach ($registrasi as $key => $d)
                @php
                  $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
                @endphp
                <td>{{ $no++ }}</td>
                <td>{{ $pasien ? $pasien->no_rm : '' }} </td>
                <td>{{ $pasien ? strtoupper( $pasien->nama ) : '' }}</td>
                <td>{{ baca_carabayar($d->bayar) }} {{ (!empty($d->tipe_jkn) && $d->bayar == 1) ? ' - '.$d->tipe_jkn : '' }}</td>
                <td>
                  @if (substr($d->status_reg,0,1) == 'J')
                    RAWAT JALAN
                  @elseif (substr($d->status_reg,0,1) == 'G')
                    RAWAT DARURAT
                  @endif
                </td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>{{ strtoupper( baca_poli($d->poli_id) )}}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                <td>
                  <a href="{{ url('/kasir/verifikasi-rajal/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-check"></i>
                  </a>
                </td>
                {{-- 
                <td>
                  <button type="button" onclick="verifikasi({{ $d->id }})" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-check"></i>
                  </button>
                </td>
                <td>
                  @if ( Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('verif_kasa', 'Y')->sum('total') > 0)
                    <a href="{{ url('kasir/cetak-verifikasi/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  @endif
                </td> --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="modalVerifikasi" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Verifikasi Rawat Jalan</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="formTindakan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div id="detailVerifikasi">
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">TUTUP</button>
            <button class="btn btn-primary btn-flat btnTindakan" onclick="tambahTindakan(2)">TAMBAH TINDAKAN</button>
            <button type="button" class="btn btn-success btn-flat" onclick="selesai()">Selesai</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveForm()">SIMPAN</button>
        </div>
      </div>
    </div>
  </div>
  <button class="btn btn-primary btn-flat btnTindakan" onclick="tambahTindakan(2)">TAMBAH TINDAKAN</button>
  {{-- TAMBAH TINDAKAN --}}
  <div class="modal fade" id="tindakanTambah" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Verifikasi Rawat Jalan | Tambah Tindakan</h4>
        </div>
        <div class="modal-body">
          <div id="tambahTindakanVerif"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat" onclick="saveTindakanTambahan()">SIMPAN</button>
          <button type="button" class="btn btn-default btn-flat batal">BATAL</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function selesai() {
      $('#modalVerifikasi').modal('hide');
      location.reload();
    }

    function verifikasi(registrasi_id) {
      $('#tindakanTambah').modal('hide');
      $('#modalVerifikasi').modal('show');
      $('#detailVerifikasi').load('/kasir/detail-verifikasi-kasa/'+registrasi_id);
      $('.btnTindakan').attr('onclick', 'tambahTindakan('+registrasi_id+')');
    }

    function tambahTindakan(registrasi_id) {
      $('#modalVerifikasi').modal('hide');
      $('#tindakanTambah').modal('show');
      $('.registrasi_id').text(registrasi_id);
      $('.batal').attr('onclick', 'verifikasi('+registrasi_id+')');
      $('#tambahTindakanVerif').load('/kasir/tambah-tindakan/'+registrasi_id);
    }

    function saveForm() {
      var data = $('#formTindakan').serialize();

      $.ajax({
        url: '/kasir/save-verifikasi-kasa',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
          console.log(data);
          if (data.sukses == true) {
            $('#modalVerifikasi').modal('show');
            $('#detailVerifikasi').load('/kasir/detail-verifikasi-kasa/'+data.registrasi_id);
          }
        }
      });
    }

    function saveTindakanTambahan() {
      var data = $('#formTambahTindakan').serialize();
      $.ajax({
        url: '/kasir/save-tambah-tindakan',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
          if (data.sukses == true) {
            verifikasi(data.registrasi_id);
          }
        }
      });


    }


  </script>
@endsection
