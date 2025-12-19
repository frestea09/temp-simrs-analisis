@extends('master')
@section('header')
  <h1>Penjualan Bebas</h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualanbebasbaru']) !!}
        {!! Form::hidden('pasien_id', 'P-01') !!}
        {!! Form::hidden('idreg', null) !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
              <tr>
                <th style="width: 30%">Nama Pasien</th>
                <td class="{{ $errors->has('nama') ? ' has-error' : '' }}">
                    {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('nama') }}</small>
                </td>
              </tr>
              <tr>
                <th>Kelamin</th>
                <td class="{{ $errors->has('kelamin') ? ' has-error' : '' }}">
                    <select class="form-control" name="kelamin" id="">
                      <option value="P">Perempuan</option>
                      <option value="L">Laki - Laki</option>
                    </select>
                  <small class="text-danger">{{ $errors->first('kelamin') }}</small>
                </td>
              </tr>
              <tr>
                <th>NO. HP</th>
                <td class="{{ $errors->has('nohp') ? ' has-error' : '' }}">
                  <input type="text" name="nohp" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('nohp') }}</small>
                </td>
              </tr>
              <tr>
                <th>NO. BPJS</th>
                <td class="{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
                  <input type="text" name="no_jkn" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
                </td>
              </tr>
              <tr>
                <th>NIK</th>
                <td class="{{ $errors->has('nik') ? ' has-error' : '' }}">
                  <input type="text" name="nik" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('nik') }}</small>
                </td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td class="{{ $errors->has('alamat') ? ' has-error' : '' }}">
                  <input type="text" name="alamat" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('alamat') }}</small>
                </td>
              </tr>
              <tr>
                <th>RT</th>
                <td class="{{ $errors->has('rt') ? ' has-error' : '' }}">
                  <input type="text" name="rt" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('rt') }}</small>
                </td>
              </tr>
              <tr>
                <th>RW</th>
                <td class="{{ $errors->has('rw') ? ' has-error' : '' }}">
                  <input type="text" name="rw" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('rw') }}</small>
                </td>
              </tr>
              <tr>
                <th>Dokter</th>
                <td>
                  @php
                      $dokter = Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
                  @endphp
                 <select name="dokter_id" id="" class="form-control select2">
                        <option value="">-- Pilih Dokter --</option>
                      @foreach ($dokter as $item)
                         <option value="{{ $item->id }}">{{ baca_dokter($item->id) }}</option>
                      @endforeach
                   
                 </select>
                </td>
              </tr>
              <tr>
                <th>Tanggal</th>
                <td>
                  <input type="text" name="tanggal" value="{{date('d-m-Y')}}" class="form-control datepicker" autocomplete="off">
                </td>
              </tr>
              @if (! session('idpenjualan'))
              <tr>
                  <th>
                    Pembuat Resep
                  </th>
                  <td>
                    <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }}">
                        {!! Form::select('pembuat_resep', $apoteker, null, ['class' => 'form-control select2']) !!}
                        <small class="text-danger">{{ $errors->first('pembuat_resep') }}</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th></th>
                  <td>
                    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin data sudah benar?")']) !!}
                  </td>
                </tr>
                @else
                <tr>
                  <th></th>
                  <td>
                    <b class="text-primary">{{ baca_apoteker($penjualan->pembuat_resep) }}</b>
                  </td>
                </tr>
                @endif


              @if (session('idpenjualan'))
                <tr>
                  <td>No. Faktur</td>
                  <td>{{ $penjualan->no_resep }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
{!! Form::close() !!}
<hr>
{!! Form::open(['method' => 'POST', 'url' => 'penjualanbebas-baru', 'class'=>'form-hosizontal']) !!}
  <div class="row">
    <div class="col-md-6">
      <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
        <span class="input-group-btn">
        <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
        </span>
        {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()','autocomplete'=>'off']) !!}
      </div>
    </div>
  </div>
{!! Form::close() !!}
        <hr>
        <h4>Penjualan Sebelumnya</h4>
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Dokter</th>
                <th>Faktur</th>
                <th>E Tiket</th>
                 <th>Edit</th> 
                {{-- <th>Hapus</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($today as $d)
                  @php
                   if (\App\Penjualan::where('registrasi_id', @$d->registrasi_id)->first()) {
                        $penjualan_id = App\Penjualan::where('registrasi_id', @$d->registrasi_id)->first()->id;
                    }
                    $reg =  @\Modules\Registrasi\Entities\Registrasi::find(@$d->registrasi_id)->pasien_id;
                  @endphp
                <tr>
                  <td>{{ @$no++ }}</td>
                  <td>{{ @$d->nama }}</td>
                  <td>{{ @$d->alamat }}</td>
                  <td>{{ @$d->dokter }}</td>
                  <td>
                   @if (\App\Penjualan::where('registrasi_id', @$d->registrasi_id)->first())
                   <a target="__blank" href="{{ url('farmasi/cetak-detail-bebas-baru/'. @$penjualan_id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print"></i></a>
                   @endif
                  </td>
                  <td>
                   
                    <a href="{{ url('farmasi/laporan/etiket/'. @$penjualan_id) }}" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-print"></i></a>
                    
                  </td>
                   <td>
                   @if ( json_decode(Auth::user()->is_edit,true)['edit'] == 1)
                    <a href="{{ url('penjualan/edit-penjualan-bebas-baru/'.@$d->registrasi_id.'/'.$penjualan_id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-pencil"></i></a>
                   @else
                   @endif
                  </td> 
                  {{-- <td>
                    @if ($d->lunas == 'N')
                      <a href="{{ url('hapus-penjualanbebas/'.$d->registrasi_id) }}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-remove"></i></a>
                    @endif
                  </td> --}}
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
    $('.select2').select2();
  </script>
@endsection