@extends('master')
@section('header')
  <h1>Hasil Pemeriksaan Penunjang<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'index-inap-hasil-pemeriksaan', 'class'=>'form-horizontal']) !!}
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-7">
            <div class="form-group">
              <label for="no_rm" class="col-md-3 control-label">NO. RM</label>
              <div class="col-md-4">
                {!! Form::text('no_rm', @$no_rm, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('no_rm') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group text-center">
              <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Registrasi</th>
              <th>No. RM</th>
              <th>Nama </th>
              <th>Umur </th>
              <th>Kelamin </th>
              <th>Dokter</th>
              <th>Jenis Bayar</th>
              <th>Pelayanan</th>
              <th>Hasil Lab</th>
              <th>Hasil Radiologi</th>
            </tr>
          </thead>
          <tbody>
            @if (isset($reg))
              @foreach ($reg as $key => $d)
              @php
                $status_reg = cek_status_reg($d->status_reg);
              @endphp
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                    <td>{{ @$d->pasien->no_rm }}</td>
                    <td>{{ @$d->pasien->nama }}</td>
                    <td>{{ hitung_umur(@$d->pasien->tgllahir) }}</td>
                    <td>{{ @$d->pasien->kelamin }}</td>
                    <td>{{ baca_dokter(@$d->dokter_id) }}</td>
                    <td> {{ baca_carabayar($d->bayar) }}</td>
                    <td>
                        @if ($status_reg == 'I')
                          Rawat Inap
                        @elseif ($status_reg == 'J')
                          Rawat Jalan
                        @elseif ($status_reg == 'G')
                          IGD
                        @endif
                    </td>
                    <td class="text-center">
                      @if (!empty(json_decode(@$d->tte_hasillab_lis)->base64_signed_file))
                        <a href="{{ url('pemeriksaanlab/cetakAll-lis-tte/' . @$d->id) }}"
                          target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                            class="fa fa-print"></i> </a>
                      @else
                      <a href="{{ url('pemeriksaanlab/cetakAll-lis/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                      @endif
                    </td>
                    <td> 
                      @if (count($d->ekspertise) > 0)
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-success">Cetak</button>
                          <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                          @foreach ($d->ekspertise as $p)
                            <li>
                            <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$p->registrasi_id."/".$p->folio_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                            </li>
                          @endforeach
                          </ul>
                        </div>
                      @endif
                    </td>
                  </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>


    </div>
  </div>



@endsection
