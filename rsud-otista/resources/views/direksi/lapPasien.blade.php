@extends('master')
@section('header')
  <h1>Laporan Pasien</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form class="form-horizontal" action="{{ url('/direksi/laporan-pasien') }}" id="laporanTagihan" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
              <div class="col-md-7">
                <div class="form-group">
                  <label for="tanggal" class="col-md-2 control-label">Periode</label>
                  <div class="col-md-5">
                      <input type="text" name="tga" class="form-control datepicker" autocomplete="off" value="{{ isset($_POST['tga']) ? $_POST['tga'] : '' }}">
                      <span class="text-danger" id=""></span>
                  </div>
                  <div class="col-md-5">
                      <input type="text" name="tgb" class="form-control datepicker" autocomplete="off" value="{{ isset($_POST['tgb']) ? $_POST['tgb'] : '' }}">
                      <span class="text-danger" id=""></span>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                    <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
                    <input type="submit" name="tampil" class="btn btn-primary btn-flat" value="TAMPILKAN">
                </div>
              </div>
            </div>
        </div>
      </form>
      <hr/>
    @isset($tga)
      <div class="table-responsive">
        <table class="table table-bordered" id="data">
            <thead class="bg-primary">
                <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>No RM</th>
                    <th>Rawat Jalan</th>
                    <th>Rawat Inap</th>
                    <th>Rawat Darurat</th>
                    <th>Laboratorium</th>
                    <th>Radiologi</th>
                    <th>Farmasi</th>
                    <th>Rehab Medik</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->no_rm }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'J')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, '')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'G')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'L')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'R')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'A')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'M')) }}</td>
                    <td class="text-right">{{ number_format(lapPasien($d->reg_id, 'T')) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    @endisset
    </div>
  </div>
@endsection
@section('script')
    <script>
      $('.select2').select2();
    </script>
@endsection
