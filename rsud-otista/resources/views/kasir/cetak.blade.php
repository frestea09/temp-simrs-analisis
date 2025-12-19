@extends('master')

@section('header')
  <h1>Kasir Rawat Jalan - Cetak Ulang <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kasir/cetakRj', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>JK</th>
              <th>Cara Bayar</th>
              <th class="text-center">Kwitansi</th>
              <th class="text-center">Kwi. Tindakan</th>
              <th class="text-center">Kwi. Penunjang</th>
              <th class="text-center">Kwi. Obat</th>
              <th class="text-center">Kwi. RAD,LAB,USG</th>
              {{-- <th class="text-center">Kwitansi Non Jasa Racik</th> --}}
              <th class="text-center">Rincian Biaya</th>
              <th class="text-center">Rincian Obat</th>
              <th class="text-center">Rincian Tindakan Retribusi</th>
              {{-- <th class="text-center">Rincian Biaya Non Jasa Racik</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($pemb as $key => $d)
              @php
                @$bayar = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
                @$bayar_obat = @App\Pembayaran::where('registrasi_id',$d->registrasi_id)->where('pembayaran','obat')->first();
                @$bayar_tindakan = @App\Pembayaran::where('registrasi_id',$d->registrasi_id)->where('pembayaran','tindakan')->first();
              @endphp
              @if (!empty($d->pasien))
              {{-- @php
                  $carabay = 
              @endphp --}}
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->nama : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->kelamin : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? @baca_carabayar(@$bayar->bayar) : '' }} {{@$bayar->bayar == '1' ? '('.@$bayar->tipe_jkn.')' : ''}}</td>
                  <td class="text-center">
                    <a href="{{ url('kasir/cetakkuitansi/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  <td class="text-center">
                    <a href="{{ url('kasir/cetakkuitansitanparetribusi/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/cetakkuitansi-blumlunas/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                  <td class="text-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p)
                          <li>
                            <a href="{{ url("kasir/cetakkuitansi-perkwitansi/".$p->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_kwitansi }} </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    {{-- <a href="{{ url('kasir/cetakkuitansi-blumlunas/'.$d->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a> --}}
                  </td>
                  <td class="text-center">
                    <a href="{{ url('kasir/cetakkuitansi-obat/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  <td class="text-left">
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="color:white !important">
                        {{-- @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p) --}}
                          <li>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-rad/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Radiologi </a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-lab/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Laboratorium </a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-usg/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> USG</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-ekg/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> EKG</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-ctscan/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> CT Scan</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-citologi/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Citologi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-biopsi/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Biopsi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-fnab/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>Fnab</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-operasi/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Operasi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-resume-medis/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>Resume Medis</a>
               
                          </li> 
                        {{-- @endforeach --}}
                      </ul>
                    </div>
                    {{-- <a href="{{ url('kasir/cetakkuitansi-blumlunas/'.$d->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a> --}}
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/cetakkuitansi-obat/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/cetak/cetakkuitansinonjasaracik/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                  <td class="text-center">
                    <a href="{{ url('kasir/rincian-biaya-rajal/'.@$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  <td class="text-center">
                    @if (isset($bayar_obat))
                    <a href="{{ url('kasir/rincian-biaya-obat/'.@$bayar_obat->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  <td class="text-center">
                    @if (isset($bayar_tindakan))
                    <a href="{{ url('kasir/rincian-biaya-tindakan/'.@$bayar_tindakan->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/rincian-biaya-non-jasa/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
