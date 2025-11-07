@extends('master')

@section('header')
  <h1>
      Entry Tindakan Langsung - Ambulans & Pemulasaran Jenazah
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active">
              <div class="row">
                <div class="col-md-2">
                  <h3 class="widget-user-username">Nama</h3>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                </div>
                <div class="col-md-7">
                  <h3 class="widget-user-username">:{{ $reg->pasien->nama}}</h3>
                  <h5 class="widget-user-desc">: {{ $reg->pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ $reg->pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} </h5>
                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'pemulasaran-jenazah/save-tindakan-langsung', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            {!! Form::hidden('poli_tipe', $poli_tipe) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('dokter', $dokter, 49, ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control chosen-select" name="tarif_id">
                          @foreach($tindakan as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format($d->total) }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                      <a href="{{ url('pemulasaran-jenazah/pasien-langsung') }}" class="btn btn-primary btn-flat">SELESAI</a>
                    @if($cek > 0)
                      <a href="{{ url('pemulasaran-jenazah/cetak-tindakan/TA/'.$reg->id) }}" target="_blank" class="btn btn-warning btn-flat">CETAK</a>
                    @endif
                    </div>
                </div>
              </div>
            </div>

            {!! Form::close() !!}
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tindakan</th>
                <th>Pelayanan</th>
                <th>Biaya</th>
                <th>Jml</th>
                <th>Total</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Bayar</th>
                @role(['supervisor', 'rawatdarurat','administrator'])
                <th>Hapus</th>
                @endrole
              </tr>
            </thead>
            <tbody>
              @foreach ($folio as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                  <td>{{ $d->poli->nama }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                  <td>{{ number_format($d->total,0,',','.') }}</td>
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at->format('Y-m-d H:i:s') }}</td>
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  @role(['supervisor', 'radiologi','administrator'])
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <a href="{{ url('laboratorium/hapus-tindakan-irj/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                  </td>
                  @endrole
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
    function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

  $(document).ready(function() {
    //TINDAKAN entry
    $('select[name="kategoriTarifID"]').on('change', function() {
        var tarif_id = $(this).val();
        if(tarif_id) {
            $.ajax({
                url: '/tindakan/getTarif/'+tarif_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    //$('select[name="tarif_id"]').append('<option value=""></option>');
                    $('select[name="tarif_id"]').empty();
                    $.each(data, function(id, nama, total) {
                        $('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
                    });

                }
            });
        }else{
            $('select[name="tarif_id"]').empty();
        }
    });
  });

</script>
@endsection
