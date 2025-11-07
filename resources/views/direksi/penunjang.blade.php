@extends('master')
@section('header')
  <h1>Laporan Penunjang</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form class="form-horizontal" action="{{ url('/direksi/laporan-penunjang') }}" id="laporanTagihan" method="POST">
          {{ csrf_field() }}
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                      <label for="tanggal" class="col-md-3 control-label">Tanggal</label>
                      <div class="col-md-3">
                          <input type="text" name="tga" class="form-control datepicker" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                      <div class="col-md-3">
                          <input type="text" name="tgb" class="form-control datepicker" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                      <div class="col-md-3">
                          {{-- <input type="submit" name="submit" value="Check" class="btn btn-default btn-flat"> --}}
                          <input type="submit" name="cetak" value="Cetak" class="btn btn-danger btn-flat">
                      </div>
                      <div class="col-md-3">
                       
                      
                      </div>
                    </div>
                </div>
            </div>
        </form>

  <div class="row">
    <div class="col-sm-10">
      <h4>Periode: @isset ($tga)
          {{ $tga }} s/d {{ $tgb }}
      @endisset</h4>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>Nama</th>
              <th>Jumlah</th>
              <th>Jumlah Pendapatan</th>
            </tr>
          </thead>
          <tbody>

               
                @if (isset($laboratorium))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>Laboratorium</td>
                  <td>{{ $laboratorium[0]->jumlah }}</td>
                  <td>{{ number_format($laboratorium->sum('total')) }}</td>
                </tr>
                @endif
                
                 
                @if (isset($radiologi))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>Radiologi</td>
                  <td>{{ $radiologi[0]->jumlah }}</td>
                  <td>{{ number_format($radiologi->sum('total')) }}</td>
                </tr>
                @endif


                @if (isset($usg))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>Usg</td>
                  <td>{{ $usg[0]->jumlah }}</td>
                  <td>{{ number_format($usg->sum('total')) }}</td>
                </tr>
                @endif



                @if (isset($fnab))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>Fnab</td>
                  <td>{{ $fnab[0]->jumlah }}</td>
                  <td>{{ number_format($fnab->sum('total')) }}</td>
                </tr>
                @endif

                @if (isset($citologi))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>Citologi</td>
                  <td>{{ $citologi[0]->jumlah }}</td>
                  <td>{{ number_format($citologi->sum('total')) }}</td>
                </tr>
                @endif



                  
                @if (isset($pa_operasi))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>PA Operasi</td>
                  <td>{{ $pa_operasi[0]->jumlah }}</td>
                  <td>{{ number_format($pa_operasi->sum('total')) }}</td>
                </tr>
                @endif



                    
                @if (isset($pa_biopsi))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>PA Biopsi</td>
                  <td>{{ $pa_biopsi[0]->jumlah }}</td>
                  <td>{{ number_format($pa_biopsi->sum('total')) }}</td>
                </tr>
                @endif




          </tbody>  
        </table>
      </div>
    </div>
  </div>

  
      

        {{-- <form class="form-horizontal" id="laporanTagihan" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal" class="col-md-4 control-label">Tanggal</label>
                      <div class="col-md-4">
                          <input type="text" name="tga" class="form-control datepicker" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                      <div class="col-md-4">
                          <input type="text" name="tgb" class="form-control datepicker" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="shift" class="col-md-4 control-label">Shift Kasa</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="klinik" class="col-md-4 control-label">Klinik</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="poli_id">
                              @foreach (Modules\Poli\Entities\Poli::select('id', 'nama')->get() as $key => $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endforeach
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="petugas" class="col-md-4 control-label">Nama Petugas</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="petugas_id">
                              @foreach (App\Pembayaran::select('user_id')->distinct()->get(['user_id']) as $key => $d)
                                  <option value="{{ $d->user_id }}">{{ App\User::where('id', $d->user_id)->first()->name }}</option>
                              @endforeach
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bayar" class="col-md-4 control-label">Jenis Bayar</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="bayar">
                              <option value="1">JKN</option>
                              <option value="2">UMUM</option>
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="tipe_perawatan" class="col-md-4 control-label">Tipe Perawatan</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="jenispasien" class="col-md-4 control-label">Jenis Pasien</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="dokter" class="col-md-4 control-label">Nama Dokter</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="dokter_id">
                              @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endforeach
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tipelayanan" class="col-md-4 control-label">Tipe Layanan</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tipe_perawatan" class="col-md-4 control-label">Tipe Penerimaan</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="tipe_penerimaan">
                              <option value="tunai">Tunai</option>
                              <option value="piutang">Piutang</option>
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>

                </div>
            </div>
        </form> --}}




    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
