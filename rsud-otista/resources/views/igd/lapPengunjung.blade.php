@extends('master')
@section('header')
  <h1>Laporan Pengunjung Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'igd-laporan-pengunjung', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-7">
          <div class="form-group">
            <label for="tga" class="col-md-3 control-label">Periode</label>
            <div class="col-md-4">
              {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <div class="col-md-4">
              {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
          </div>
          <div class="form-group">
            <label for="nama" class="col-md-3 control-label">Cara Bayar</label>
            <div class="col-md-8">
              <select name="cara_bayar" class="form-control select2">
                <option value="0" {{ ($crb == 0) ? 'selected' : '' }}>Semua</option>
                @foreach ($carabayar as $c)
                  <option value="{{ $c->id }}"{{ ($crb == $c->id) ? 'selected' : '' }}>{{ $c->carabayar }}
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group text-center">
            {{-- <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
            <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
            {{-- <input type="submit" name="pdf" class="btn btn-danger btn-flat" value="CETAK"> --}}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i>
              {{-- <th class="v-middle text-center" rowspan="2">No</th>
              <th class="v-middle text-center" rowspan="2" style="min-width:90px">Tanggal</th>
              <th class="v-middle text-center" rowspan="2">No. RM</th>
              <th class="v-middle text-center" rowspan="2">Nama</th>
              <th class="v-middle text-center" rowspan="2">Bayar</th>
              <th class="v-middle text-center" rowspan="2">Dokter Ahli</th>
              <th class="v-middle text-center" rowspan="2">Dokter Umum</th>
              <th class="v-middle text-center" rowspan="2">Petugas</th>
              <th class="v-middle text-center" rowspan="2">Total</th> --}}
              {{-- <th class="text-center" colspan="15">Rekap Tindakan</th> --}}
            </tr>
            <tr>
              {{-- <th class="v-middle text-center">T. Darurat</th>
              <th class="v-middle text-center">Lab</th>
              <th class="v-middle text-center">Rad</th>
              <th class="v-middle text-center">Operasi</th>
              <th class="v-middle text-center">B. Darah</th>
              <th class="v-middle text-center">PDL</th>
              <th class="v-middle text-center">Family Folder</th>
              <th class="v-middle text-center">O2</th>
              <th class="v-middle text-center">Diet</th>
              <th class="v-middle text-center">Fisio</th>
              <th class="v-middle text-center">EKG</th>
              <th class="v-middle text-center">Amblns</th>
              <th class="v-middle text-center">ADK</th>
              <th class="v-middle text-center">Visite</th> --}}
              {{-- <th class="v-middle text-center">Total</th> --}}
            </tr>
          </thead>
          <tbody>
            @php $all = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; $ceck = 0; @endphp
            @foreach ($darurat as $rdar)
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($rdar->created_at)) }}</td>
                <td class="text-center">{{ $rdar->pasien->no_rm }}</td>
                <td>{{ $rdar->pasien->nama }}</td>
                <td class="text-center">{{ baca_carabayar($rdar->bayar) }}</td>
                <td>{{ dokterStatus($rdar->id) }}</td>
                <td>{{ dokterStatus($rdar->id) }}</td>
                {{-- @for($i = 1; $i <= 16; $i++)
                  @if($i != 1 && $i != 3)
                  @php 
                    $mapp = mappingTindakan($rdar->id, $i);
                    // $all[$i-1] += $mapp;
                  @endphp
                    <td class="text-right">{{ $mapp }}</td>
                  @endif
                @endfor --}}
                <td>{{ baca_user($rdar->user_create) }}</td>
                <td class="text-right">{{ number_format($rdar->total) }}</td>
                {{-- @php $all[16] += $rdar->total; @endphp --}}
              </tr>
            @endforeach
          </tbody>
          {{-- <tfoot>
            <tr>
              <th colspan="7" class="text-center">Total</th>
            @foreach ($all as $k => $a)
              @if($k != 2 && $k != 0)
                <th class="text-right">{{ number_format($a) }}</th>
              @endif
            @endforeach
            </tr>
          </tfoot> --}}
        </table>
      </div>
      {{-- <div class="table-responsive">
        <table class="table table-bordered table-hover" style="width:650px">
          <thead>
            <tr>
              <th class="text-center" width="15px">No</th>
              <th class="text-center">Dokter</th>
              <th class="text-center">Visite</th>
              <th class="text-center">Total</th>
            </tr>
          </thead>
          <tbody>
            @php $_no = 1; $t_visite = 0; @endphp
            @foreach ($visite as $v)
              <tr>
                <td class="text-center" width="15px">{{ $_no++ }}</td>
                <td>{{ baca_dokter($v->dokter_id) }}</td>
                <td class="text-center">{{ $v->visite }}</td>
                <td class="text-right" width="35px">{{ number_format($v->nominal) }}</td>
              </tr>
              @php $t_visite += $v->nominal; @endphp
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3">Total</th>
              <th>{{ number_format($t_visite) }}</th>
            </tr>
          </tfoot>
        </table>
      </div> --}}
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $('.select2').select2()
    $(document).ready(function() {
      if($('select[name="jenis_pasien"]').val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }
      $('select[name="jenis_pasien"]').on('change', function () {
      if ($(this).val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }
      });
    });
  </script>
@endsection
