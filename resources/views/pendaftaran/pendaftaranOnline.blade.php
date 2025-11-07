@extends('master')
@section('header')
  <h1>Registrasi Online</h1>
@endsection

@section('content')
<style>
  .datepicker{
    top : 280.594px !important;
  }
</style>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pendaftaran Online</h3>
    </div>
    <div class="box-body">
      {{-- {!! Form::open(['method' => 'POST', 'url' => 'pendaftaran/pendaftaran-online', 'class'=>'form-horizontal']) !!} --}}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">RM/NAMA</button>
            </span>
            {!! Form::text('keyword', null, [
              'class' => 'form-control', 
              'autocomplete' => 'off', 
              'placeholder' => 'NO RM/NAMA',
              'required',
              ]) !!}
          </div>
          </div>
        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Tanggal</button>
            </span>
              {!! Form::date('tanggal', date('Y-m-d'), [
                'class' => 'form-control', 
                'autocomplete' => 'off', 
                'placeholder' => 'Tanggal',
                'required',
                ]) !!}
            </div>
          </div>
        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Poli</button>
            </span>
              <select name="poli_id" id="" class="form-control select2">
                <option value="">-- Semua --</option>  
                @foreach ($poli as $item)
                  <option value="{{$item->bpjs}}">{{$item->nama}}</option>  
                @endforeach
              </select>
            </div>
          </div>
        <div class="col-md-2">
          {{-- <div class="input-group"> --}}
            {{-- <span class="input-group-btn"> --}}
              {{-- <button class="btn btn-default" type="button">Bayar</button> --}}
            {{-- </span> --}}
              <select name="carabayar_id" id="" class="form-control select2">
                {{-- @foreach ($poli as $item) --}}
                  <option value="">-- Semua --</option>  
                  <option value="1">BPJS</option>  
                  <option value="2">UMUM</option>  
                {{-- @endforeach --}}
              </select>
            {{-- </div> --}}
          </div>
          <div class="form-group">
            <div class="col-md-6">
                <button class="btn btn-primary btn-flat searchBtn">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
          </div>
        </div>
      {{-- <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <div class="col-sm-6">
              <label class="control-label">Dari Tgl</label><br/>
              <input class="form-control datepicker" name="tga" type="text" value="{{ $tga }}" required>
            </div>
            <div class="col-sm-6">
              <label class="control-label">Sampai</label><br/>
              <input class="form-control datepicker" name="tgb" type="text" value="{{ $tgb }}" required>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label">Status</label><br/>
              {!! Form::select('status', ['pending' => 'Pending','checkin' => 'Checkin'], $status, ['class' => 'form-control select2']) !!}
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label">Jenis</label><br/>
              {!! Form::select('jenis', ['fkrtl' => 'FKRTL','android' => 'Android'], $jenis, ['class' => 'form-control select2']) !!}
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <br/>
            <button class="btn btn-primary" name="submit" type="submit" value="TAMPIL" >LIHAT</button>
            <button class="btn btn-success" name="submit" type="submit" value="CETAK">EXCEL</button>
          </div>
        </div>
      </div> --}}
      {{-- {!! Form::close() !!} --}}
      <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datanew" style="font-size:12px">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Kode Booking</th>
                <th>Rujukan</th>
                <th>No RM</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>No.HP</th>
                <th>Poli</th>
                <th>Cara Bayar</th>
                <th>Jenis</th>
                <th>Tanggal Periksa</th>
                <th class="text-center">Proses</th>
              </tr>
            </thead>
            <tbody>
            {{-- @foreach($reg as $k)
            @php
                $pasien = \App\RegistrasiDummy::where('jenis_registrasi','pasien_baru')->where('nik',$k->nik)->first();
            @endphp
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td class="text-center">{{ $k->nomorantrian }}</td>
                  <td class="text-center">{{ $k->no_rujukan }}</td>
                    <td>
                      {{ !empty($k->no_rm) ? $k->no_rm : 'Dari Mobile JKN' }}
                    </td>
                    <td>{!! !empty(@$k->nama) ? @$k->nama : '<i>Pasien Baru</i>' !!}</td>
                    <td>{{ !empty(@$k->nik) ? @$k->nik : @$pasien->nik }}</td>
                    <td>{{ !empty(@$k->no_hp) ? @$k->no_hp : @$pasien->no_hp }}</td>
                    <td>{{!empty(@$k['kode_poli']) ? @\Modules\Poli\Entities\Poli::where('bpjs', @$k['kode_poli'])->first()->nama :@\Modules\Poli\Entities\Poli::where('bpjs', @$pasien->kode_poli)->first()->nama }}</td>
                    <td class="text-center">
                      {{ !empty(@$k->kode_cara_bayar) ? baca_carabayar(@$k['kode_cara_bayar']) : 'JKN' }}
                    </td>
                    <td class="text-center">{{ ucfirst(@$k['jenisdaftar']) }}</td>
                    <td class="text-center">{{ @$k['tglperiksa'] }}</td>
                    <td class="text-center">
                        @if(@$k['status'] == 'pending')
                          <a href="{{ url('regperjanjian/online/'.@$k['id']) }}" data-toggle="tooltip" data-placement="top" title="Proses"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a>
                          <a href="{{ url('pendaftaran/batalRegPendaftaran/'.@$k['id']) }}" onclick="return confirm('Yakin akan Batalkan antrian?')" data-toggle="tooltip" data-placement="top" title="Batalkan" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-times-circle"></i></a>
                        @else
                          <a href="{{ url('form-sep-susulan-online/'.@$k['registrasi_id']) }}" data-toggle="tooltip" data-placement="top" title="Proses"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a>
                          
                        @endif
                    </td>
                </tr>
            @endforeach --}}
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    // $('.table').DataTable();
    $('.select2').select2();
    $(".datepicker").datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    });

    $(document).ready(function() {

      var datanew = $('#datanew').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/pendaftaran/data-pendaftaran-online',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
            d.tanggal = $('input[name="tanggal"]').val();
            d.poli_id = $('select[name="poli_id"]').val();
            d.carabayar_id = $('select[name="carabayar_id"]').val();
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'nomorantrian', orderable: false},
            {data: 'no_rujukan', orderable: false},
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'nik', orderable: false},
            {data: 'nohp', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'cara_bayar', orderable: false},
            {data: 'jenis_daftar', orderable: false},
            {data: 'tglperiksa', orderable: false},
            {data: 'proses', orderable: false}
        ]

      });
        $(".searchBtn").click(function (d){
          
          
          if($('select[name="poli_id"]').val()){
            if(!$('input[name="tanggal"]').val()){
              return alert("Tanggal wajib diisi")
            }
          }
        datanew.draw();
      });
    });
  </script>
@endsection
