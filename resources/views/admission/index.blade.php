@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Data Pasien</h3>
      </div>
      <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'admission', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal Registrasi</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Instalasi Asal</th>
                <th>DPJP Rawat Jalan</th>
                <th>Cara Bayar</th>
                <th>Operasi</th>
                <th>Proses</th>
                <th>Persetujuan</th>
                <th>Buat SPRI</th>
                <th class="text-center" style="vertical-align: middle">Cetak SPRI</th>
                <th class="text-center">SEP</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($reg as $key => $d)
                @if (@$d->pasien)
                    
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>{{ @$d->pasien->nama }}</td>
                  <td>{{ @$d->pasien->alamat }}</td>
                  {{-- <td>{{ $d->poli->nama }}</td> --}}
                  <td>
                    @if ( substr($d->status_reg, 0,1) == 'J' )
                      Instalasi Rawat Jalan
                    @elseif ( substr($d->status_reg, 0,1) == 'G' )
                      Instalasi Rawat Darurat
                    @endif
                  </td>
                  <td>{{ baca_dokter($d->dokter_id) }} </td>
                  <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>
                    <a href="{{ url('rawat-inap/ibs/'.@$d->id) }}"
                      onclick="return confirm('Yakin akan di order ke IBS?')" class="btn btn-warning btn-sm btn-flat"><i
                        class="fa fa-cut"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('admission/proses/'.$d->id) }}" onclick="return confirm('Yakin pasien akan Anda inapkan')" class="btn btn-primary btn-sm"><i class="fa fa-bed"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('frontoffice/cetak-persetujuan/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm"><i class="fa fa-file-pdf-o"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('/create-spri/'.$d->id) }}" target="_blank"  class="btn btn-danger btn-sm"><i class="fa fa-bed"></i></a>
                  </td>
                  <td class="text-center">

                    {{-- @if (cek_spri($d->id) >= 1) --}}
                       {{-- <a href="{{ url('spri/cetak/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>  --}}
                    @if (isset($spri[$d->id]) && !empty($spri[$d->id]->tte))
                       <a href="{{url('/dokumen_tte/'.$spri[$d->id]->tte)}}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a> 
                    @endif
                  </td>
                  <td>
                    @if (!empty($d->no_sep))
                      <a href="{{ url('cetak-sep/'.$d->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                    @endif
                  </td>
                </tr>
                @endif
                {{-- @endif --}}
              @endforeach

            </tbody>
          </table>
        </div>

      </div>
    </div>
  <div class="modal fade" id="suratPri" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formEkspertise">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="">
            <input type="hidden" name="id" value="">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th>Nama Pasien </th> <td class="nama"></td>
                  <th>Umur </th><td class="umur"></td>
                </tr>
                <tr>
                  <th>Jenis Kelamin </th><td class="jk" colspan="1"></td>
                  <th>No. RM </th><td class="no_rm" colspan="2"></td>
                </tr>
                <tr>
                    <th>Dokter Rawat</th>
                    <td>
                        <select name="dokter_rawat" class="form-control select2" style="width: 100%">
                          @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                    </td>
                    <th>Dokter Pengirim</th>
                    <td>
                        <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                          @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Jenis Kamar</th>
                    <td>
                       <input type="text" name="jenis_kamar" class="form-control">
                    </td>
                    <th>Cara Bayar</th>
                    <td>
                        <select name="cara_bayar" class="form-control select2" style="width: 100%">
                          @foreach (\Modules\Registrasi\Entities\Carabayar::all() as $d)
                              <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                          @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                  <th>Diagnosa</th>
                  <td colspan="3">
                    <textarea name="diagnosa" class="form-control wysiwyg"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="saveSPRI()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
@stop
@section('script')
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
  
@endsection

