@extends('master')
@section('header')
  <h1>Laporan Indeks Kematian</h1>
@endsection
@section('content')
    {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/laporan-indeks-kematian', 'class'=>'form-horizontal']) !!}
        {{ csrf_field() }}
        <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
            <label class="col-md-3 control-label">Tanggal Mulai</label>
            <div class="input-group col-md-6 date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="tgl_awal" class="form-control pull-right datepicker" id="tgl_mulai" value="{{ !empty($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '' }}">
                <small class="text-danger">{{ $errors->first('tgl_awal') }}</small>
            </div>
            </div>
            <div class="form-group">
            <label class="col-md-3 control-label">Tanggal Akhir</label>
            <div class="input-group col-md-6 date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="tgl_akhir" class="form-control pull-right datepicker" id="tgl_akhir" value="{{ !empty($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '' }}">
                <small class="text-danger">{{ $errors->first('tgl_akhir') }}</small>
            </div>
            </div>
            <div class="form-group">
            <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
            <div class="col-sm-9">
                <input type="submit" name="type" class="btn btn-primary btn-flat" value="LANJUT">
                <input type="submit" name="type" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
            </div>
            </div>
        </div>
        </div>
    {!! Form::close() !!}
    <div class="box box-primary">
      <div class="box-body">
        <div class='table-responsive'>
          <table id='pasienData' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th class="text-center">No. RM</th>
                <th class="text-center">Dokter</th>
                <th class="text-center">Mati Di</th>
                <th class="text-center">Tanggal Jam Masuk</th>
                <th class="text-center">Tanggal Jam Keluar</th>
                <th class="text-center">Kode ICD X</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Umur</th>
                {{-- <th class="text-center">Komplikasi</th>
                <th class="text-center">Operasi</th> --}}
                <th class="text-center">Mati</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($registrasi as $r)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $r->pasien->no_rm }}</td>
                        <td>{{ baca_dokter($r->dokter_id) }}</td>
                        <td>
                            {{-- Inap --}}
                            @if (cek_status_reg($r->status_reg) == "I") 
                                Rawat Inap
                            {{-- Jalan --}}
                            @elseif (cek_status_reg($r->status_reg) == "J")
                                Rawat Jalan
                            {{-- IGD --}}
                            @elseif (cek_status_reg($r->status_reg) == "G")
                                IGD
                            @endif
                        </td>
                        <td>{{ $r->tgl_masuk }}</td>
                        <td>{{ $r->tgl_keluar }}</td>
                        <td>
                            @php
                                $icd10 = \App\PerawatanIcd10::where('registrasi_id', $r->id)->first();
                            @endphp
                            {{@$icd10->icd10 ?? '-'}}
                        </td>
                        <td>{{ $r->pasien->kelamin == 'L' ? 'Laki - laki' : 'Perempuan' }}</td>
                        <td>{{ hitung_umur($r->pasien->tgllahir) }}</td>
                        {{-- <td>-</td>
                        <td>-</td> --}}
                        <td>
                            @php
                                $kondisi = \App\KondisiAkhirPasien::find($r->kondisi_akhir_pasien)
                            @endphp
                            {{ $kondisi->namakondisi }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
@section('script')
    <script>
        $('#pasienData').DataTable();
    </script>
@endsection