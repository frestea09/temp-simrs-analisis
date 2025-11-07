@extends('master')
@section('header')
  <h1>Rawat Inap - Asuhan Keperawatan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Data Pasien Rawat Inap</h4>
    </div>
    <div class="box-body">
      {{-- {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/billing', 'class' => 'form-horizontal']) !!}

        <div class="row">
          <div class="col-md-5">
            <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
                {!! Form::label('kelas_id', 'Pilih Kelas', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('kelas_id', $kelas, null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
                </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
                {!! Form::label('kamar_id', 'Pilih Bangsal', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    <select class="form-control" name="kamar_id" >

                    </select>
                    <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
                </div>
            </div>
          </div>
          <div class="col-md-2">
            <input type="submit" name="submit" class="btn btn-success btn-flat" value="CARI">
          </div>
        </div>

      {!! Form::close() !!}
      <hr> --}}

      @if ($inap->count() > 0)
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">No</th>
              <th class="text-center" style="vertical-align: middle">No. RM</th>
              <th class="text-center" style="vertical-align: middle">Nama</th>
              <th class="text-center" style="vertical-align: middle">Kelas</th>
              <th class="text-center" style="vertical-align: middle">Kamar</th>
              <th class="text-center" style="vertical-align: middle">Bed</th>
              <th class="text-center" style="vertical-align: middle">Cara Bayar</th>
              <th class="text-center" style="vertical-align: middle">RB</th>
              <th class="text-center" style="vertical-align: middle">ENTRY</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($inap as $key => $d)
              @php
                $reg = Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $reg->pasien->no_rm }}</td>
                <td>{{ $reg->pasien->nama }}</td>
                <td>{{ baca_kelas($d->kelas_id) }}</td>
                <td>{{ baca_kamar($d->kamar_id) }}</td>
                <td>{{ baca_bed($d->bed_id) }}</td>
                <td>{{ baca_carabayar($reg->bayar) }} {{ !empty($reg->tipe_jkn) ? ' - '.$reg->tipe_jkn : '' }}</td>
                <td>
                  <button type="button" onclick="rincianBiaya({{ $reg->id }}, '{{ $reg->pasien->nama }}', {{ $reg->pasien->no_rm }} )" class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i> </button>
                </td>
                <td>
                  <a href="{{ url('rawat-inap/entry-tindakan/'.$d->registrasi_id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>
          @endif

    </div>
  </div>

  <div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tindakan</th>
                  <th>Jenis Pelayanan</th>
                  <th>Tagihan</th>
                </tr>
              </thead>
              <tbody class="tagihan">
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-right">Total Tagihan</th>
                  <th class="text-right totalTagihan"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
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

    function jenisLayanan(jenis) {
      switch (jenis) {
        case 'TA' : return 'Layanan rawat jalan'; break;
        case 'TG' : return 'Layanan rawat darurat'; break;
        case 'TI' : return 'Layanan rawat inap'; break;
        default : return 'Apotik'; break;
      }
    }

    function rincianBiaya(registrasi_id, nama, no_rm) {
      $('#modalRincianBiaya').modal('show');
      $('.modal-title').text(nama +' | '+no_rm)
      $('.tagihan').empty();
      $.ajax({
        url: '/informasi-rincian-biaya/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $.each(data, function(key, value) {
            $('.tagihan').append('<tr> <td>'+ (key+1) +'</td> <td>'+ value.namatarif+'</td> <td>'+ jenisLayanan(value.jenis)+'</td> <td class="text-right">'+ ribuan(value.total)+'</td> </tr>')
          });
        }
      });

      $.ajax({
        url: '/informasi-total-biaya/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('.totalTagihan').html( ribuan(data) )
        }
      });
    }
  </script>
@endsection
