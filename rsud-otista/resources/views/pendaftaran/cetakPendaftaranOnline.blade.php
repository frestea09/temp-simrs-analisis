<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 10pt;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
    </style>
  </head>
  <body onload="window.print()">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pendaftaran Online <br/>
      {{$tga}} / {{$tgb}}</h3>
    </div>
    <div class="box-body">
      <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' style="font-size:12px" border="1" cellspacing="0" cellpadding="1">
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
              </tr>
            </thead>
            <tbody>
            @foreach($reg as $k)
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
                    {{-- <td class="text-center">
                        @if(@$k['status'] == 'pending')
                          <a href="{{ url('regperjanjian/online/'.@$k['id']) }}" data-toggle="tooltip" data-placement="top" title="Proses"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a>
                          <a href="{{ url('pendaftaran/batalRegPendaftaran/'.@$k['id']) }}" onclick="return confirm('Yakin akan Batalkan antrian?')" data-toggle="tooltip" data-placement="top" title="Batalkan" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-times-circle"></i></a>
                        @else
                          <a href="{{ url('form-sep-susulan-online/'.@$k['registrasi_id']) }}" data-toggle="tooltip" data-placement="top" title="Proses"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </td> --}}
                </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>
  