@extends('master')
@section('header')
  <h1>Laporan Kunjungan - Rawat Darurat</h1>
@endsection

@section('css')
    <style>
        .mb-4{
            margin-bottom: 16px;
        }
        .w-full{
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'igd-laporan-kunjungan', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-12 mb-4">
            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                            type="button">Tanggal</button>
                    </span>
                    {!! Form::text('tga', \Carbon\Carbon::parse($tga)->format('d-m-Y'), [
                        'class' => 'form-control datepicker',
                        'required' => 'required',
                        'autocomplete' => 'off',
                    ]) !!}
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">s/d</button>
                    </span>
                    {!! Form::text('tgb', \Carbon\Carbon::parse($tgb)->format('d-m-Y'), [
                        'class' => 'form-control datepicker',
                        'required' => 'required',
                        'autocomplete' => 'off',
                    ]) !!}
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
            <div class="col-md-4">
              <div class="input-group{{ $errors->has('dokter') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('dokter') ? ' has-error' : '' }}"
                          type="button">Dokter</button>
                  </span>
                  <select name="dokter_id" class="form-control select2 " style="width: 100% ">
                      <option value="">-- SEMUA --</option>
                      @foreach ($dokter as $p)
                        <option value="{{$p->id}}" {{@$dokter_id == $p->id ? 'selected' :''}}>{{$p->nama}}</option>
                      @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('pekerjaan') }}</small>
              </div>
          </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="col-md-3">
                <div class="input-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('pekerjaan') ? ' has-error' : '' }}"
                            type="button">Pekerjaan</button>
                    </span>
                    <select name="pekerjaan" class="form-control select2 " style="width: 100% ">
                        <option value="">-- SEMUA --</option>
                        @foreach ($pekerjaan as $p)
                          <option value="{{$p->id}}">{{$p->nama}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('pekerjaan') }}</small>
                </div>
            </div>
            <div class="col-md-3">
              <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                          type="button">Poli</button>
                  </span>
                  <select name="poli_id" class="form-control select2" style="width: 100%" >
                       <option value="">-- SEMUA --</option>
                        @foreach ($poli as $i)
                          <option value="{{ $i->nama }}" {{ $poli_id == $i->nama ? 'selected' : '' }}>{{ $i->nama }}</option>
                        @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
              </div>
            </div>
            <div class="col-md-3">
                <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">Cara Masuk</button>
                    </span>
                    <select name="cara_masuk_id" class="form-control select2" style="width: 100%" >
                         <option value="">-- SEMUA --</option>
                         <option value="Datang Sendiri" {{@$cara_masuk_id == 'Datang Sendiri' ? 'selected' : ''}}>Datang Sendiri</option>
                         <option value="Rujukan Luar" {{@$cara_masuk_id == 'Rujukan Luar' ? 'selected' : ''}}>Rujukan Luar</option>
                         <option value="Petugas Kesehatan" {{@$cara_masuk_id == 'Petugas Kesehatan' ? 'selected' : ''}}>Petugas Kesehatan Lain</option>
                         <option value="KLL / Kasus Polisi" {{@$cara_masuk_id == 'KLL / Kasus Polisi' ? 'selected' : ''}}>KLL / Kasus Polisi</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">Cara Pulang</button>
                    </span>
                    <select name="cara_pulang_id" class="form-control select2" style="width: 100%" >
                        <option value="">-- SEMUA --</option>
                        @foreach ($caraPulang as $c)
                            <option value="{{ $c->id }}" {{ ($cara_pulang_id == $c->id) ? 'selected' : '' }}>{{ $c->namakondisi }}
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div> --}}
            <div class="col-md-3">
              <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                          type="button">Status Pasien</button>
                  </span>
                  <select name="status_pasien" class="form-control select2" style="width: 100%" >
                      <option value="">-- SEMUA --</option>
                      <option value="bpjs" {{@$status_pasien == 'bpjs' ? 'selected' : ''}}>BPJS</option>
                      <option value="non-bpjs" {{@$status_pasien == 'non-bpjs' ? 'selected' : ''}}>NON BPJS</option>
                 </select>
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
              </div>
          </div>
        </div>
       
        <div class="col-md-12 mb-4">
            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">Cara Pulang</button>
                    </span>
                    <select name="cara_pulang_id" class="form-control select2" style="width: 100%" >
                        <option value="">-- SEMUA --</option>
                        @foreach ($caraPulang as $c)
                            <option value="{{ $c->id }}" {{ ($cara_pulang_id == $c->id) ? 'selected' : '' }}>{{ $c->namakondisi }}
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">Kondisi Pulang</button>
                    </span>
                    <select name="kondisi_pulang_id" class="form-control select2" style="width: 100%" >
                        <option value="">-- SEMUA --</option>
                        @foreach ($kondisiPulang as $c)
                            <option value="{{ $c->id }}" {{ ($kondisi_pulang_id == $c->id) ? 'selected' : '' }}>{{ $c->namakondisi }}
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">Kelompok BPJS</button>
                    </span>
                    <select name="kelompok_bpjs_id" class="form-control select2" style="width: 100%" >
                        <option value="">-- Semua --</option>
                        @foreach ($kelompok_bpjs as $c)
                            <option value="{{ $c }}" {{ ($kelompok_bpjs_id == $c) ? 'selected' : '' }}>{{ $c }}
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
           <div class="col-md-4" style="display: flex">
                <input type="text" name="keyword"  class="form-control" placeholder="Nama/NO RM">
                <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI">
           </div>
            <div class="col-md-4 pull-right">
                <div class="form-group pull-right">
                    {{-- <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
                    <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
                    {{-- <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" formtarget="_blank"
                        value="CETAK"> --}}
                </div>
            </div>
        </div>

        {{-- <div class="col-md-7">
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
        </div> --}}
        
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th class="v-middle text-center">No</th>
              <th class="v-middle text-center">No. RM</th>
              <th class="v-middle text-center">Nama</th>
              <th class="v-middle text-center">No. SEP</th>
              <th class="v-middle text-center">Alamat</th>
              <th class="v-middle text-center">Pekerjaan</th>
              <th class="v-middle text-center">Umur</th>
              <th class="v-middle text-center">Jenis Kelamin</th>
              <th class="v-middle text-center">Cara Bayar</th>
              <th class="v-middle text-center">Pelayanan</th>
              <th class="v-middle text-center">Dokter</th>
              <th class="v-middle text-center">Cara Pulang</th>
              <th class="v-middle text-center">Kondisi Pulang</th>
              <th class="v-middle text-center" style="min-width:90px">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($darurat as $rdar)
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $rdar->no_rm }}</td>
                <td>{{ $rdar->nama }}</td>
                <td>{{ @$rdar->no_sep }}</td>
                <td>{{ $rdar->alamat }}</td>
                <td>{{ @baca_pekerjaan($rdar->pekerjaan_id) }}</td>
                <td>{{ hitung_umur($rdar->tgllahir) }}</td>
                <td>{{ $rdar->kelamin }}</td>
                <td>{{ @baca_carabayar($rdar->bayar) }} - {{ @$rdar->tipe_jkn }}</td>
                <td>{{ $rdar->triage_nama == 'IGD Obgyn' ? 'IGD Ponek' : $rdar->triage_nama }}</td>
                <td>{{ @baca_dokter($rdar->dokter_id) }}</td>
                <td>{{ @baca_carapulang(@$rdar->pulang) }}</td>
                <td>{{ @baca_carapulang(@$rdar->kondisi_akhir) }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($rdar->created_at)) }}</td>
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>

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
