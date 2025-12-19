@extends('master')
@section('header')
  <h1>Laporan Transaksi Keluar {{config('app.nama')}}</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form class="form-horizontal" action="{{ url('/direksi/laporan-transaksi-keluar') }}" id="laporanTagihan" method="POST">
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
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Klasifikasi</label>
                  <div class="col-md-9">
                    <select name="klasifikasi" class="form-control select2">
                      <option value="0" {{ ($klasifikasi == '0') ? 'selected' : '' }}>SEMUA</option>
                      @foreach ($data_klasifikasi as $item)
                        <option value={{$item->id}} {{ ($item->id == $klasifikasi) ? 'selected' : '' }}>{{$item->name}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('politipe') }}</small>
                  </div> 
                </div>
              </div> 
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Jenis</label>
                  <div class="col-md-9">
                    <select name="jenis" class="form-control select2">
                      <option value="0" {{ ($jenis == '0') ? 'selected' : '' }}>SEMUA</option>
                      @foreach ($data_jenis as $item)
                        <option value={{$item->id}} {{ ($item->id == $jenis) ? 'selected' : '' }}>{{$item->name}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('petugas') }}</small>
                  </div> 
                </div>
              </div> 
              {{-- <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-2 control-label">Cara Bayar&nbsp;</label>
                  <div class="col-md-9">
                    <select name="carabayar" class="form-control select2">
                      <option value="0" {{ ($carabayar == '0') ? 'selected' : '' }}>SEMUA</option>
                      @foreach ($cara_bayar as $item)
                        <option value={{$item->id}} {{ ($item->id == $carabayar) ? 'selected' : '' }}>{{$item->carabayar}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
                  </div> 
                </div>
              </div>  --}}
              <div class="col-md-5">
                <input type="submit" name="tampil" class="btn btn-primary btn-flat" value="TAMPILKAN">
                {{-- <input type="submit" name="cetak" class="btn btn-success btn-flat" value="CETAK"> --}}
              </div>
            </div>
            <div class="col-md-12">
              
            </div>
        </div>
      </form>
      <hr/>
    @isset($tga)
      <div class="table-responsive">
        <table class="table table-bordered table-striped" style="font-size:12px;">
        @php $no=1; $total = 0; @endphp
        {{-- @if(!empty($jenis)) --}}
          <thead>
            <tr>
              <td colspan="4" class="text-right"><b>Total</b></td>
              <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($data->sum('total')) }}</b></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th class="text-center" width="35px">NO</th>
              <th>Nama</th>
              {{-- <th class="text-center">Tgl</th> --}}
              {{-- <th class="text-center">No.Reg</th> --}}
              {{-- <th class="text-center">No. BKK</th> --}}
              {{-- <th class="text-center">Klasifikasi</th> --}}
              {{-- <th class="text-center">Jenis</th> --}}
              {{-- <th class="text-center">Satuan</th> --}}
              <th class="text-center">Hrg.Satuan</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Total</th>
              {{-- <th class="text-center">Bukti Transaksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($data->get() as $item)
              
              <tr>
                <td width="35px" class="text-center">{{$no++}}</td>
                <td>{{$item->keterangan}}</td>
                {{-- <td class="text-center">{{ tgl_indo($item->tanggal)}}</td> --}}
                {{-- <td>{{$item->registrasis->id}}</td> --}}
                {{-- <td class="text-center">{{@$item->no_bkk}}</td> --}}
                {{-- <td class="text-center">{{@$item->klasifikasi->name}}</td> --}}
                {{-- <td class="text-center">{{@$item->jenis->name}}</td> --}}
                {{-- <td class="text-center">{{@$item->satuanbeli->nama}}</td> --}}
                <td class="text-justify text-success"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format($item->harga_satuan) }}</span></td>
                <td class="text-justify text-red"><span class="pull-left"></span><span class="pull-right">{{ number_format($item->jumlah) }}</span></td>
                <td class="text-justify text-primary"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format($item->total) }}</span></td>
                {{-- <td  class="text-center">{{@$item->bukti_transaksi}}</td> --}}
              </tr>
              @php
                  $total += $item->total
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
                <td colspan="4" class="text-right"><b>Total</b></td>
                <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                <td>&nbsp;</td>
              </tr>
            
          </tbody>
        {{-- @else --}}
          {{-- <thead> --}}
            {{-- <tr>
              <th class="text-center" width="50%">Uraian</th>
              <th class="text-center" width="25%">Tanggal</th>
              <th class="text-center" width="25%">Total</th>
            </tr> --}}
          {{-- </thead> --}}
          <tbody> 
          </tbody>
        {{-- @endif --}}
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
