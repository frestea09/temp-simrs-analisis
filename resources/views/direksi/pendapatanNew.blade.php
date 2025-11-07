@extends('master')
@section('header')
  <h1>Laporan Pendapatan {{config('app.nama')}}</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form class="form-horizontal" action="{{ url('/direksi/laporan-pendapatan-new') }}" id="laporanTagihan" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
              <div class="col-md-4">
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
              {{-- <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Kategori&nbsp;&nbsp;</label>
                  <div class="col-md-9">
                    <select name="kategori" class="form-control select2" style="width: 100%">
                      <option value="ALL" {{ ($kategori == 'ALL') ? 'selected' : '' }}>SEMUA</option>
                      <option value="IRNA" {{ ($kategori == 'IRNA') ? 'selected' : '' }}>RAWAT INAP</option>
                      <option value="RJ" {{ ($kategori == 'RJ') ? 'selected' : '' }}>RAWAT JALAN</option>
                      <option value="RD" {{ ($kategori == 'RD') ? 'selected' : '' }}>RAWAT DARURAT</option>
                      <option value="PB" {{ ($kategori == 'PB') ? 'selected' : '' }}>PENJUALAN BEBAS</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('politipe') }}</small>
                  </div> 
                </div>
              </div>  --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Petugas&nbsp;</label>
                  <div class="col-md-9">
                    <select name="petugas" class="form-control select2" style="width: 100%">
                      <option value="0" {{ ($petugas == '0') ? 'selected' : '' }}>SEMUA</option>
                      @foreach ($data_petugas as $item)
                        <option value={{$item->user_id}} {{ ($item->user_id == $petugas) ? 'selected' : '' }}>{{\App\User::find($item->user_id)->name}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('petugas') }}</small>
                  </div> 
                </div>
              </div> 
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Cara Bayar&nbsp;</label>
                  <div class="col-md-9">
                    <select name="carabayar" class="form-control select2" style="width: 100%">
                      <option value="0" {{ ($carabayar == '0') ? 'selected' : '' }}>SEMUA</option>
                      @foreach ($cara_bayar as $item)
                        <option value={{$item->id}} {{ ($item->id == $carabayar) ? 'selected' : '' }}>{{$item->carabayar}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
                  </div> 
                </div>
              </div> 
              <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal" class="col-md-2 control-label">SHIFT</label>
                    <div class="col-md-5">
                        <input type="time" name="time_start" class="form-control" value="{{ isset($_POST['time_start']) ? $_POST['time_start'] : '' }}">
                    </div>
                    <div class="col-md-5">
                        <input type="time" name="time_end"  class="form-control" value="{{ isset($_POST['time_end']) ? $_POST['time_end'] : '' }}">
                    </div>
                </div>
                <span style="font-size: 10px; color: red; font-style: italic">
                    *Untuk menampilkan data dalam 24 Jam, tidak perlu mengisi filter shift
                </span>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Ruangan&nbsp;</label>
                  <div class="col-md-9">
                    <select name="poli" class="form-control select2" style="width: 100%">
                      <option value="">SEMUA</option>
                      @foreach ($poli as $id => $nama)
                        <option value={{$id}} {{ ($id == $poliSelect) ? 'selected' : '' }}>{{$nama}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('poli') }}</small>
                  </div> 
                </div>
              </div> 
            </div>
            <div class="col-md-4">
              {{-- <input type="submit" name="tampil" class="btn btn-primary btn-flat pull-right" value="TAMPILKAN"> --}}
              <input type="submit" name="cetak" class="btn btn-success btn-flat pull-right" value="CETAK">
              <input type="submit" name="excel" class="btn btn-success btn-flat pull-right" value="EXCEL">
            </div>
            
        </div>
      </form>
      <hr/>
    @isset($tga)
      <div class="table-responsive">
        <table class="table table-bordered table-striped" style="font-size:12px;">
        @php $no=1; $total = 0; @endphp
        @if(!empty($kategori))
          <thead>
            <tr>
              <td colspan="8" class="text-right"><b>Total</b></td>
              <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($pembayaran->sum('dibayar')) }}</b></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th class="text-center" width="35px">NO</th>
              <th class="text-center">Nama</th>
              {{-- <th class="text-center">No.Reg</th> --}}
              <th class="text-center">No. RM</th>
              <th class="text-center">Pelayanan</th>
              <th class="text-center">No. Kwitansi</th>
              <th class="text-center">Bayar</th>
              <th class="text-center">Tagihan</th>
              <th class="text-center">Diskon</th>
              <th class="text-center">Dibayar</th>
              <th class="text-center">Petugas</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pembayaran->get() as $item)
            @php
            $reg = Modules\Registrasi\Entities\Registrasi::find(@$item->registrasi_id);     
             @endphp
              <tr>
                <td width="35px" class="text-center">{{$no++}}</td>
                @if ($reg->pasien_id == 0)
                <td><i>Penjualan Bebas</i></td>
                @else
                <td>{{ baca_pasien($reg->pasien_id) }}</td>
                @endif
                {{-- <td>{{$item->registrasis->id}}</td> --}}
                <td class="text-center">{{!empty($item->pasien->no_rm) ? $item->pasien->no_rm: '-'}}</td>
                <td class="text-center">{{!empty(@$item->registrasis) ? @$item->registrasis->poli->nama: '-'}}</td>
                <td class="text-center">{{!empty(@$item->no_kwitansi) ? @$item->no_kwitansi: '-'}}</td>
                <td class="text-center">{{!empty(@$item->registrasis) ? baca_carabayar(@$item->registrasis->bayar): '-'}}</td>
                <td class="text-justify text-success"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format(@$item->total) }}</span></td>
                <td class="text-justify text-red"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format(@$item->diskon_rupiah) }}</span></td>
                <td class="text-justify text-primary"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format(@$item->dibayar) }}</span></td>
                <td  class="text-center">{{@$item->user->name}}</td>
              </tr>
              @php
                  $total += $item->dibayar
              @endphp
            @endforeach
              {{-- <tr>
                <td colspan="2" class="text-right"><b>Total UMUM</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
              </tr>
              <tr>
                <td colspan="2" class="text-right"><b>Total JKN</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($JKN) }}</b></td>
              </tr> --}}
              <tr>
                <td colspan="8" class="text-right"><b>Total</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                <td>&nbsp;</td>
              </tr>
            
          </tbody>
        @else
          <thead>
            <tr>
              <th class="text-center" width="50%">Uraian</th>
              <th class="text-center" width="25%">Tanggal</th>
              <th class="text-center" width="25%">Total</th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach ($folio as $k => $f)
              @if($k == 0)
                <tr>
                  <td class="text-center" rowspan="{{ count($folio) }}"><b>{{ ($poliId == '') ? 'Rawat Inap' : baca_poli($poliId) }}</b></td>
                  <td class="text-center">{{ $f->tgl }}</td>
                  <td class="text-justify"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format($f->total) }}</span></td>
                  @php $total += $f->total; @endphp
                </tr>
              @else
                <tr>
                  <td class="text-center">{{ $f->tgl }}</td>
                  <td class="text-justify"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format($f->total) }}</span></td>
                  @php 
                    $total += $f->total;
                  @endphp
                </tr>
              @endif
            @endforeach --}}
              {{-- <tr>
                <td colspan="2" class="text-right"><b>Total UMUM</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
              </tr>
              <tr>
                <td colspan="2" class="text-right"><b>Total JKN</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($JKN) }}</b></td>
              </tr>
              <tr>
                <td colspan="2" class="text-right"><b>Total</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total + $JKN) }}</b></td>
              </tr> --}}
              {{--  @foreach ($tagihan as $t)
                @if($t->lunas == 'Y')
                  <tr>
                    <td colspan="2" class="text-right"><b>Total Terbayar</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($t->total) }}</b></td>
                  </tr>
                @else
                  <tr>
                    <td colspan="2" class="text-right"><b>Sisa Tagihan</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($t->total) }}</b></td>
                  </tr>
                @endif
              @endforeach  --}}
          </tbody>
        @endif
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
