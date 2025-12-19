@extends('master')
@section('header')
@php
    $notif = '<span style="color:red">*</span>Jika ada masalah saat menambahkan obat, klik tombol <b>Refresh</b>';
@endphp
  @if ( substr($reg->status_reg, 0, 1) == 'I' )
    <h1>Penjualan Rawat Inap <a href="{{url('/refresh-obat')}}" class="btn btn-info btn-sm btn-flat">
      <i class="fa fa-refresh"></i> REFRESH
    </a></h1>
    {!!$notif!!}
  @elseif ( substr($reg->status_reg, 0, 1) == 'G' )
    <h1>Penjualan Rawat Darurat <a href="{{url('/refresh-obat')}}" class="btn btn-info btn-sm btn-flat">
      <i class="fa fa-refresh"></i> REFRESH
    </a></h1>
    {!!$notif!!}
  @elseif ( substr($reg->status_reg, 0, 1) == 'J' )
    <h1>Penjualan Rawat Jalan <a href="{{url('/refresh-obat')}}" class="btn btn-info btn-sm btn-flat">
      <i class="fa fa-refresh"></i> REFRESH
    </a></h1>
    {!!$notif!!}
  @endif
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
  <style>
    .blink_me {
      animation: blinker 5s linear infinite;
      color: rgb(255, 0, 0)
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }
  </style>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualan']) !!}
        {!! Form::hidden('pasien_id', @$pasien->id) !!}
        {!! Form::hidden('idreg', $idreg) !!}
        {!! Form::hidden('idresep', $id_resep) !!}
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <tbody>
            <tr>
              <td style="width: 30%">Nama Pasien / No. RM</td>
              <td>
                {{ strtoupper(@$pasien->nama) }} / {{ $pasien->no_rm }} / {{ (!empty($pasien->tgllahir)) ? hitung_umur($pasien->tgllahir) : 'tgl lahir kosonglo' }}
                  <button type="button" id="historipenjualan" data-registrasiID="{{ $idreg }}" class="btn btn-info btn-sm btn-flat">
                    <i class="fa fa-th-list"></i> HISTORY
                  </button>
                  <button type="button" id="historipenjualaneresep" data-bayar="{{@$reg->cara_bayar}}" data-registrasiID="{{ $idreg }}" class="btn btn-warning btn-sm btn-flat">
                    <i class="fa fa-th-list"></i> HISTORY E-RESEP
                  </button>
                  <button type="button" id="historicopyresep" data-bayar="{{@$reg->cara_bayar}}" data-registrasiID="{{ $idreg }}" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-th-list"></i> HISTORY COPY
                  </button>
              </td>
            </tr>
            <tr>
            @if ( $reg->status_reg == 'I2' )
              <td>Ruangan</td><td>{{ ($ranap->kamar_id != '') ? baca_kamar($ranap->kamar_id) : '' }}</td>
            @else
              <td>Klinik</td><td>{{ strtoupper(baca_poli($reg->poli_id)) }}</td>
            @endif
            </tr>

            <tr>
              <td> <b> Histori Kunjungan Pasien: </b></td>
              @if ($histori_irj->first())
              <td>
                @foreach ($histori_irj as $item)
                 <p> - Poli {{ strtoupper(baca_poli($item->poli_id)) }}</p>
                @endforeach
              </td>
              @endif
            </tr>

            @if ($histori_igd->first())
            <tr>
              <td>History : </td>
              <td>
                @foreach ($histori_igd as $item)
                 - {{ strtoupper(baca_poli($item->poli_id)) }}
                @endforeach
              </td>
            </tr>
            @endif

            <tr>
              <td>Dokter</td>
              <td>
                {{--  {{ baca_dokter($reg->dokter_id) }}  --}}
                {!! Form::select('dokter_id', $dokter, $reg->dokter_id, ['class' => 'form-control select2']) !!}
              </td>
            </tr>
            <tr>
              <td>Jenis Pasien</td><td>{{ baca_carabayar($reg->bayar) }}</td>
            </tr>
            <tr>
              <td>Alamat</td> <td>{{ strtoupper($pasien->alamat) }} RT. {{ $pasien->rt }} / RW. {{ $pasien->rw }} {{ baca_kelurahan($pasien->village_id) }} {{ baca_kecamatan($pasien->district_id) }}</td>
            </tr>
          </tbody>
        </table>
        
      {!! Form::close() !!}

      {{-- FORM VALIDASI ERESEP --}}
      @if(isset($resep->id))
      <form action="{{url('penjualan/validasi-eresep')}}" id="form-validate-erecipe" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="idpasien" value="{{$pasien->id}}" />
        <input type="hidden" name="idreg" value="{{$reg->id}}" />
        <input type="hidden" name="ideresep" value="{{$resep->id}}" />
      <div class="row">
        <div class="col-sm-12">
          <h3>E-Resep</h3>
          <table class="table table-bordered" style="font-size: 12px !important">
            <thead>
              <tr>
                <th>ID</th>
                <th colspan="2">{{ $resep->uuid }}</th>
                @if ($resep->nama_racikan)
                <th colspan="5" style="color:blueviolet">NAMA RACIKAN ATAU CARA PEMBUATAN : {{ $resep->nama_racikan }}</th>    
                @endif
                @if (@$resep->signa_peracikan)
                <th colspan="5" style="color:rgb(15, 91, 95)">SIGNA RACIKAN : {{ $resep->signa_peracikan }}</th>    
                @endif
              </tr>
              <tr>
                <th>No</th>
                <th colspan="2">Nama Obat</th>
                <th>Stok</th>
                <th>Qty</th>
                <th>Kronis</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Tersedia</th>
                <th>Etiket</th>
                <th>Takaran</th>
                <th>Informasi</th>
                <th>Cetak</th>
              </tr>
            </thead>
            
            <tbody>
              @php
                $tot_sementara = 0;
              @endphp
              @foreach($resep->resep_detail as $a => $b)
              <input type="hidden" name="resep_detail[{{@$b->id}}][logistik_batch_id]" value="{{$b->logistik_batch_id}}" />
              <input type="hidden" name="resep_detail[{{@$b->id}}][tiket]" value="{{$b->cara_minum}}" />
              <input type="hidden" name="resep_detail[{{@$b->id}}][takaran]" value="{{$b->takaran}}" /> 
              <input type="hidden" name="resep_detail[{{@$b->id}}][obat_racikan]" value="{{$b->obat_racikan}}" /> 
              <tr>
                <td>{{ ($a+1) }}</td>
                <td colspan="2">
                  @if ($b->obat_racikan == 'Y')
                      <span style="color:green">Racikan</span>
                  @endif
                  {{ @$b->logistik_batch->master_obat->nama }} <br>
                  @if (!empty(@$b->logistik_batch->deleted_at))
                    <span class="blink_me"><b>Obat pada batch ini telah di hapus, mohon untuk menginput manual obat ini setelah validasi</b></span>
                  @endif
                </td>
                <td>{{ @$b->logistik_batch->stok }}</td>
                <td>{{ @$b->qty }}</td>
                <td>
                  <input type="hidden" name="resep_detail[{{@$b->id}}][kronis]" value="N">
                  <input type="checkbox" name="resep_detail[{{@$b->id}}][kronis]" value="Y" {{$b->kronis == 'Y' ? 'checked' : ''}}>
                </td>
                @php
                  $hargaTotal = $b->logistik_batch->hargajual_umum;
                @endphp
                @if($reg->poli->kelompok == 'ESO')
                  @php
                    $cyto = ($hargaTotal * 30) / 100;
                    $hargaTotal = $hargaTotal + $cyto;
                  @endphp
                  <td>{{ number_format($hargaTotal) }}</td>
                  <td>{{ number_format($hargaTotal*$b->qty) }}</td>
                @else
                  <td>{{ number_format($hargaTotal) }}</td>
                  <td>{{ number_format($hargaTotal*$b->qty) }}</td>
                @endif
                @php
                  $tot_sementara += $hargaTotal;
                @endphp
                {{-- <td><input class="form-control" min="0" type="number" style="width: 70px;" value="{{$b->is_empty ? '0': $b->qty}}" name="resep_detail[{{@$b->id}}][qty]"></td> --}}

                {{-- JIKA STOK YANG DIMINTA LEBIH BESAR DARI JUMLAH STOK --}}
                {{-- @if ($b->qty > @$b->logistik_batch->stok)
                  <td><input class="form-control" min="0" type="number" onchange="cekJumlah({{$b->id}},{{@$b->logistik_batch->stok}})" style="width: 70px;" value="{{@$b->logistik_batch->stok}}" name="resep_detail[{{@$b->id}}][qty]"></td>  
                @else --}}
                <td><input class="form-control" min="0" type="number" style="width: 70px;" value="{{$b->qty}}" name="resep_detail[{{@$b->id}}][qty]"></td>
                {{-- @endif --}}
                <td>
                    <input class="form-control" type="text" style="width: 100%;" value="{{$b->cara_minum}}" name="resep_detail[{{@$b->id}}][tiket]">
                </td>
                <td>
                  <input class="form-control" type="text" tyle="width: 100%;" value="{{$b->takaran}}" name="resep_detail[{{@$b->id}}][takaran]">
                </select>
                </td>
                  <td>
                    <input class="form-control" type="text" style="width: 70px;" value="{{$b->informasi}}" name="resep_detail[{{@$b->id}}][informasi]">
                    
                  </td>
                  <td>
                    {!! Form::select('resep_detail['.@$b->id.'][cetak]', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
                  </td>
                  {{-- TANPA UANG RACIK --}}
                  <input type="hidden" name="resep_detail[{{$b->id}}][uang_racik]" value="2"> 
              </tr>
              @endforeach
              <td></td>
              <td>Total Harga:</td>
              <td colspan="6" class="text-right">{{ number_format($tot_sementara) }} </td>
            </tbody>
            <tfoot>
              @php
                  $cartContent = Cart::instance('telaah' . $idreg)->content();
                  if ($cartContent instanceof \Illuminate\Support\Collection) {
                      $cartContent = $cartContent->toArray();
                  }
                  $firstKey = array_key_first($cartContent);
                  $telaah = @$cartContent[$firstKey]['options'];
              @endphp
              <tr>
                <td>
                  <h5>Tela'ah :</h5>
                </td>
              </tr>
              <tr>
                <td>Check All</td>
                <td><input type="checkbox" id="check-all"></td>
              </tr>
              <tr>
                <td style="width: 300px">
                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input check-item"  name="telaah[1]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['1'] == '1' ? 'checked' : ''}}  name="telaah[1]" type="checkbox" value="1" id="flexCheckDefault">
                      Ketepatan identitas pasien
                    </label>
                  </div>
                </td>
                <td colspan="3">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[2]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['2'] == '2' ? 'checked' : ''}}  name="telaah[2]" type="checkbox" value="2" id="flexCheckChecked">
                      Ketepatan Obat
                    </label>
                  </div>

                </td>
                <td colspan="3">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[3]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['3'] == '3' ? 'checked' : ''}} name="telaah[3]" type="checkbox" value="3" id="flexCheckChecked">
                      Ketepatan frekuensi
                    </label>
                  </div>

                </td>
                <td colspan="4">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[4]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['4'] == '4' ? 'checked' : ''}}  name="telaah[4]" type="checkbox" value="4" id="flexCheckChecked">
                      Ketepatan aturan minum/makan obat
                    </label>
                  </div>

                </td>
                <td colspan="4">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[5]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['5'] == '5' ? 'checked' : ''}} name="telaah[5]" type="checkbox" value="5" id="flexCheckChecked">
                      Ketepatan waktu pemberian
                    </label>
                  </div>

                </td>
                 
               
              </tr>
              <tr>
                <td colspan="1">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[6]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['6'] == '6' ? 'checked' : ''}} name="telaah[6]" type="checkbox" value="6" id="flexCheckChecked">
                      Duplikasi pengobatan
                    </label>
                  </div>

                </td>
                <td colspan="3">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[7]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['7'] == '7' ? 'checked' : ''}} name="telaah[7]" type="checkbox" value="7" id="flexCheckChecked">
                      Potensi alergi atau sensitivitas
                    </label>
                  </div>

                </td>
                <td colspan="3">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[8]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['8'] == '8' ? 'checked' : ''}} name="telaah[8]" type="checkbox" value="8" id="flexCheckChecked">
                      Interaksi antara obat dan obat lain atau dengan makanan
                    </label>
                  </div>

                </td>
                <td colspan="3">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[9]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['9'] == '9' ? 'checked' : ''}} name="telaah[9]" type="checkbox" value="9" id="flexCheckChecked">
                      Variasi kriteria penggunaan obat dari rumah sakit (obat dagang,obat generik)
                    </label>
                  </div>

                </td>
                <td colspan="2">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[10]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['10'] == '10' ? 'checked' : ''}} name="telaah[10]" type="checkbox" value="10" id="flexCheckChecked">
                      Berat badan pasien
                    </label>
                  </div>

                </td>
                <td colspan="3">

                  <div class="form-check">
                    
                    <label class="form-check-label" for="flexCheckChecked">
                      <input class="form-check-input check-item"  name="telaah[11]" type="hidden" value="0" id="flexCheckDefault">
                      <input class="form-check-input check-item" {{@$telaah['11'] == '11' ? 'checked' : ''}} name="telaah[11]" type="checkbox" value="11" id="flexCheckChecked">
                      Kontra Indikasi
                    </label>
                  </div>

                </td>
              </tr>
              <tr><td class="text-right" colspan="11">
                
                @if ($resep->is_validate)
                  <span style="color:green"><i><b>Sudah Divalidasi</b></i></span>
                @else      
                  <div id="validated" style="{{empty($telaah) ? 'display: none;' : ''}}">
                    <span style="color:green"><i><b>Sudah Divalidasi</b></i></span>
                  </div>
                  <div id="invalidated" style="{{!empty($telaah) ? 'display: none;' : ''}}">
                    <span style="color:red">* Wajib klik validasi sebelum melanjutkan</span>
                    <button onclick="validasiResep()" type="button" class="btn btn-success">Validasi</a>
                  </div>
                @endif
              </td></tr>
            </tfoot>
          </table>
        </div>
      </div>
      </form>
      @endif

      <form method="POST" id="formPenjualan" class="form-horizontal">
        {{ csrf_field() }}
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('idreg', $idreg) !!}
        {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
          <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label text-primary">Racik</label>
            <div class="col-sm-4">
              <select class="form-control select2" name="uang_racik" style="width: 100%;">
                @foreach ($tipe_uang_racik as $d)
                  <option value="{{ @$d->id }}" {{ ( @$d->id == 2) ? 'selected' : '' }}>{{ $d->nama }}</option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">JUMLAH&nbsp;&nbsp;  </button>
                </span>
                <input type="number" name="jumlah" value="1" min="1" class="form-control">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Cetak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </span>
                {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('cetak') }}</small>
              </div>
            </div>
          </div>

          <div id="racikan">
            <div class="form-group{{ $errors->has('racikan') ? ' has-error' : '' }}">
              {!! Form::label('racikan', 'Harga Racikan', ['class' => 'col-sm-2 control-label']) !!}
              <div class="col-sm-4">
                {!! Form::text('racikan', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('racikan') }}</small>
              </div>
            </div>
          </div>
          <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
          {!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                <select name="masterobat_id" id="masterObat" class="form-control" onchange="cariBatch()"></select>
                <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
            </div>


            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">No. Batch</button>
                </span>
                {!! Form::text('batch',  null, ['class' => 'form-control', 'readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('batch') }}</small>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Harga</button>
                </span>
                {!! Form::text('harga',  null, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('harga') }}</small>
              </div>
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <select class="form-control select2" name="cara_bayar_id" style="width: 100%;">
                @foreach ($carabayar as $d)
                    @if ($reg->bayar == @$d->id)
                        <option value="{{ @$d->id }}" selected>{{ $d->carabayar }}</option>
                    @else
                        <option value="{{ @$d->id }}" >{{ $d->carabayar }}</option>
                    @endif
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Expired&nbsp;&nbsp;&nbsp;</button>
                </span>
                {!! Form::text('expired', null, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('expired') }}</small>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Stok&nbsp;&nbsp;</button>
                </span>
                {!! Form::text('stok', 0, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('stok') }}</small>
              </div>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('etiket', 'E-Tiket', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                <select class="form-control select2" name="tiket" style="width: 100%;">
                  @foreach ($tiket as $d)
                    <option value="{{ @$d->nama }}" >{{ @$d->nama }}</option>
                  @endforeach
                </select>
              <small class="text-danger">{{ $errors->first('tiket') }}</small>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Cara Minum&nbsp;&nbsp; </button>
                </span>
                {!! Form::select('cara_minum_id', $cara_minum, null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('cara_minum_id') }}</small>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Kronis</button>
                </span>
                <div style="margin-left: 1rem">
                  <input type="hidden" name="kronis" value="N">
                  <input type="checkbox" name="kronis" value="Y">
                </div>
                <small class="text-danger">{{ $errors->first('kronis') }}</small>
              </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
          {!! Form::label('informasi1', 'Informasi', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('informasi1') }}</small>
          </div>
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Jenis&nbsp;&nbsp;&nbsp;</button>
              </span>
              <input type="text" class="form-control" readonly name="jenis">
              <small class="text-danger">{{ $errors->first('expired') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
            <div class="col-sm-3">
              {{-- @if ($resep->is_validate) --}}
                <button type="button" class="btn btn-primary btn-flat" id="button_tambah_obat" style="{{empty($telaah) ? 'display: none;' : ''}}" onclick="addItem()">Tambahkan</button>
              {{-- @endif --}}
            </div>
          </div>
        </div>
        
        <hr>
        <div>
          <div class='table-responsive'>
            <div id="viewDataOrder"></div>
            {{-- <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>Nama Obat</th>
                  <th class="text-center">Kronis</th>
                  <th class="text-center">Jml</th>
                 
                  <th class="text-center">Jml Total</th>
                  <th style="width:10%" class="text-center">Harga @</th>
                  <th style="width:10%" class="text-center">Racik</th>
                  <th style="width:10%" class="text-center">Total</th>
                  <th>Etiket/Signa</th>
                  <th>Informasi</th>
                  <th>Cetak</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($detail as $key => $d)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) :'' }}</td>
                    <td class="text-center">
                      <select id="kronis{{$d->id}}" onchange="editStatusKronis({{$d->id}})" class="form-control">
                        <option value="Y" {{$d->is_kronis == 'Y' ? 'selected' : ''}}>Y</option>
                        <option value="N" {{$d->is_kronis == 'N' ? 'selected' : ''}}>N</option>
                      </select>
                    </td>
                    <td class="text-center">
                      <input type="number" id="jumlahObat{{$d->id}}" class="form-control" onchange="editJumlah({{ $d->id }})" value="{{ $d->jumlah }}">
                    </td>
                    <td class="text-center">{{ $d->jumlah}}</td>
                    <td class="text-right">{{ number_format(($d->hargajual)/($d->jumlah)) }}</td>
                    <td class="text-right">{{ number_format($d->uang_racik) }}</td>
                    <td class="text-right">{{ number_format($d->hargajual) }}</td>
                    <td>{{ $d->etiket == null || $d->etiket == '-' ? $d->cara_minum : '' }}</td>
                    <td>{{ $d->informasi2 }}</td>
                    <td>{{ $d->cetak }}</td>
                    <td>
                      <a href="{{ url('penjualan/deleteDetailBaru/'.@$d->id.'/'.@$pasien->id.'/'.$idreg.'/'.@$penjualan->id.'/'.@$resep->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5" class="text-right">Total Harga</th>
                  <th class="text-right">{{ number_format($detail->sum('hargajual') + count($detail) * $d->uang_racik) }}</th>
                </tr>
              </tfoot>
            </table> --}}
          </div>
        </div>
        {!! Form::close() !!}
        <form method="POST" id="formTotalPenjualan" class="form-horizontal">
        {{ csrf_field() }}
        {{-- <input class="form-control" type="hidden" name="penjualan_id" value="{{ !empty($penjualanid) ? $penjualanid : NULL }}"> --}}
        <input type="hidden" name="cara_bayar" value="{{ $reg->bayar }}">
        <input type="hidden" name="reg_id" value="{{ @$reg->id }}">
        @if(isset($resep->id))
        <input type="hidden" name="resep_uuid" value="{{ $resep->uuid }}">
        @endif
        {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
        <div class="col-sm-7">
          {{-- <div class="form-group {{ $errors->has('jasa_racik') ? ' has-error' : '' }} {{ ($reg->bayar != 1) ? 'hidden' : '' }}"> --}}
          <div class="form-group">
            {!! Form::label('jasa_racik', 'Jasa Racik', ['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-7">
              {!! Form::text('jasa_racik', 0, ['class' => 'form-control uang']) !!}
              <small class="text-danger">{{ $errors->first('jasa_racik') }}</small>
            </div>
          </div>
        </div>
        @if(isset($resep->id))
        <div class="col-sm-5">
          <div class="form-group{{ $errors->has('ket_resep') ? ' has-error' : '' }}">
            {!! Form::label('ket_resep', 'Keterangan E-Resep', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-6">
              <input class="form-control" name="ket_resep">
              <small class="text-danger">{{ $errors->first('ket_resep') }}</small>
            </div>
          </div>
        </div>
        @endif
        <div class="col-sm-7">
          <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }}">
            {!! Form::label('pembuat_resep', 'Pelaksana Layanan', ['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-7">
              {!! Form::select('pembuat_resep', $apoteker, null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('pembuat_resep') }}</small>
            </div>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="form-group">
            {!! Form::label('tanggal', 'Tanggal ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-6">
              {!! Form::text('created_at', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
              <small class="text-danger">{{ $errors->first('informasi2') }}</small>
            </div>
            <div class="col-sm-4">
              {{--  {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}  --}}
              <div id="save-eresep-area" style="{{!empty($telaah) ? '' : 'display:none'}}">
                <button type="button" id="button-simpan-eresep" onclick="savePenjualan()" class="btn btn-success btn-flat">SIMPAN</button>
                {{-- @if (!empty(json_decode(@$resep->tte)->base64_signed_file)) --}}
                    <button type="button" onclick="savePenjualanWithTTE()" class="btn btn-info btn-flat" style="margin-top: 12px;">SIMPAN & TTE</button>
                {{-- @endif --}}
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
  </div>

  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History Penjualan Obat Sebelumnya</h4>
        </div>
        <div class="modal-body">
          <div id="dataHistori"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

    {{-- Modal TTE  ======================================================================== --}}
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte">
        <input type="hidden" name="id">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Eresep</h4>
          </div>
          <div class="modal-body row" style="display: grid;">
              <input type="hidden" class="form-control" id="url" disabled>
              <input type="hidden" class="form-control" name="nik_hidden" value="{{@Auth::user()->pegawai->nik}}" id="nik_hidden">
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Nama:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="dokter" value="{{@Auth::user()->pegawai->nama}}" id="dokter" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">NIK:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nik" id="nik" value="{{substr(@Auth::user()->pegawai->nik, 0, -5) . "*****"}}" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
              </div>
            </div>
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte">Proses TTE</button>
          </div>
        </div>
        </form>
    
      </div>
    </div>

  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualanEresep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History E-Resep Hari ini</h4>
        </div>
        <div class="modal-body">
          <div id="dataHistoriEresep"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal History Copy ======================================================================== --}}
  <div class="modal fade" id="showHistoriCopyResep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History Copy Resep</h4>
        </div>
        <div class="modal-body">
          <div id="dataHistoriCopyResep"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Cetak ======================================================================== --}}
  <div class="modal fade" id="showCetak" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          {{--  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  --}}
          <h4 class="modal-title" id="">Cetak Nota</h4>
        </div>
        <div class="modal-body text-center">
          <h5>CETAK</h5>
          <a href="" class="btn btn-primary btn-flat" id="non_kronis"  target="_blank"> <i class="fa fa-file-pdf-o"></i>FAKTUR NON KRONIS </a>&nbsp;
          <a href="" class="btn btn-info btn-flat" id="eresep"  target="_blank"> <i class="fa fa-file-pdf-o"></i> ERESEP </a>&nbsp;
          <a href="" class="btn btn-warning btn-flat" id="etiket"  target="_blank"> <i class="fa fa-file-pdf-o"></i> ETIKET</a>&nbsp;
          <a href="" class="btn btn-danger btn-flat"  id="kronis" target="_blank"> <i class="fa fa-file-pdf-o"></i>FAKTUR KRONIS </a>&nbsp;<br/>
          <hr/>
          {{-- <a href="" class="btn btn-success btn-flat" id="copyresep"  target="_blank"> INPUT COPY RESEP</a>&nbsp; --}}
        </div>
        <div class="modal-footer">
          <a href="" class="btn btn-default btn-flat"  id="selesai" > SELESAI </a>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('script')

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('update.taskid') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                taskid: "6", // dinamis
                nomorantrian: "{{ $reg->nomorantrian }}"
            },
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr) {
                console.error("Terjadi kesalahan update TaskId!");
            }
        });
    });
</script>
<script type="text/javascript">
idreg = "<?= $idreg ?>"
$(".skin-blue").addClass( "sidebar-collapse" );
  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  $(document).ready(function() {
    if ($('input[name="cara"]').val() != 1) {
        $('#uang_racik').removeClass('hide');
    } else {
        $('#uang_racik').addClass('hide');
    }
    $('select[name="obat_racik"]').on('change', function () {
    if ($(this).val() != 'Y') {
        $('#uang_racik').removeClass('hide');
      } else {
        $('#uang_racik').addClass('hide');
      }
    });
    $('.uang').maskNumber({
			thousands: ".",
			integer: true,
    });

    $(document).on('click', '#historipenjualan', function (e) {
      var id = $(this).attr('data-registrasiID');
      $('#showHistoriPenjualan').modal('show');
      $('#dataHistori').load("/penjualan/"+id+"/history-baru");
    });

    // HISTORY PENJUALAN ERESEP
    $(document).on('click', '#historipenjualaneresep', function (e) {
      var id = $(this).attr('data-registrasiID');
      var bayar = $(this).attr('data-bayar');
      $('#showHistoriPenjualanEresep').modal('show');
      $('#dataHistoriEresep').load("/penjualan/"+id+"/"+bayar+"/history-eresep");
    });

    // HISTORY COPY RESEP
    $(document).on('click', '#historicopyresep', function (e) {
      var id = $(this).attr('data-registrasiID');
      var bayar = $(this).attr('data-bayar');
      $('#showHistoriCopyResep').modal('show');
      $('#dataHistoriCopyResep').load("/copy-resep/"+id+"/history");
    }); 

  });

  
  

  $('.select2').select2();
  $('#viewDataOrder').load("/cartContentResep/"+idreg)

  $('#masterObat').select2({
      placeholder: "Klik untuk isi nama obat",
      ajax: {
          url: '/penjualan/master-obat-baru/',
          dataType: 'json',
          data: function (params) {
              return {
                  j: {{ $reg->bayar }},
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true,
      },
      width: '100%'
  })

  function cariBatch() {
    var masterobat_id= $("select[name='masterobat_id']").val();
    $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
      $("input[name='expired']").val(resp.obat.expireddate);
      $("input[name='stok']").val(resp.obat.stok);
      $("input[name='jenis']").val(resp.kategori_obat);
      $("input[name='batch']").val(resp.obat.nomorbatch);
      $("input[name='harga']").val(ribuan(resp.obat.hargajual_jkn));
      $("input[name='jumlah']").attr('max',resp.obat.stok);
    })
  }

  function addItem() {
    $("input[name='jumlah']").attr('style','');
    let stok_max = $("input[name='stok']").val();
    let stok_input = $("input[name='jumlah']").val();
    if( parseInt(stok_max) < parseInt(stok_input)){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Lebih Dari '+stok_max+' !!');
    }else if( parseInt(stok_input) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
    } else {
      if (confirm('Yakin ingin menambahkan obat?')) {
        var data = $('#formPenjualan').serialize()
        $.ajax({
          url: '/penjualannew/simpan-penjualan-detail',
          type: 'POST',
          dataType: 'json',
          data: data,
        })
        .done(function(resp) {
          console.log(resp);
          if (resp.sukses == true) {
            $('#formTotalPenjualan')[0].reset();
            $("input[name='expired']").val('');
            $("input[name='stok']").val('');
            $("input[name='batch']").val('');
            $("input[name='harga']").val('');
            $('select[name="masterobat_id"]').empty()
            $('#viewDataOrder').load("/cartContentResep/"+idreg)
          } else {
            alert(resp.data)
          }
        }).fail(function (err) {
          if (err.status = 500) {
            alert('Internal Server Error 13')
          } else if (err.status = 0) {
            alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
          } else {
            alert('Gagal menambah obat ke eresep')
          }
        });
      }
    }
  }
  
  function deleteCartEresep(rowId, idreg) {
    if (confirm('Apakah anda yakin ingin menghapus obat?')) {
      $.ajax({
        url: '/cartDeleteEresep/'+rowId+'/'+idreg,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('select[name="masterobat_id"]').empty()
          $('#viewDataOrder').load("/cartContentResep/"+idreg)
        }
      }).fail(function (err) {
        if (err.status = 500) {
          alert('Internal Server Error 14')
        } else if (err.status = 0) {
          alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
        } else {
          alert('Gagal menghapus obat')
        }
      });
    }
  }

  function destroyCart() {
    if (confirm('Yakin akan di hapus semua?')) {
      $.ajax({
        url: '/cartDestroy',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('select[name="masterobat_id"]').empty()
          $('#viewDataOrder').load('{{ url('cartContent') }}')
        }
      }).fail(function (err) {
        if (err.status = 500) {
          alert('Internal Server Error 15')
        } else if (err.status = 0) {
          alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
        } else {
          alert('Gagal menghapus data')
        }
      });

    }
  }

  function editKronis(id) {
      alert($('#jumlahKronis').val());
      var data = $('#jumlahKronis').val();
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        url: '/penjualan/editKronis/'+id,
        type: 'POST',
        dataType: 'json',
        data: {
          jml_kronis : data,
        },
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          alert('Berhasil Update Jumlah'),
          location.reload();
        }
      }).fail(function (err) {
        if (err.status = 500) {
          alert('Internal Server Error 16')
        } else if (err.status = 0) {
          alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
        } else {
          alert('Gagal merubah jumlah obat')
        }
      });

    
  }



  function deleteCart(rowId) {
    $.ajax({
      url: '/cartDeleteResep/'+rowId,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $('select[name="masterobat_id"]').empty()
        $('#viewDataOrder').load('{{ url('cartContent') }}')
      }
    }).fail(function (err) {
      if (err.status = 500) {
        alert('Internal Server Error 17')
      } else if (err.status = 0) {
        alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
      } else {
        alert('Gagal menghapus obat')
      }
    });
  }

  $('#button-proses-tte').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('hide');
    if (confirm('Yakin data penjualan sudah benar?')) {
      var  data1 = $('#formTotalPenjualan').serialize()
      var  data2 = $('#form-tte').serialize()
      var  data = data1 + "&" + data2
      $.ajax({
        url: '/penjualannew/simpan-total-penjualan?tte=true',
        type: 'POST',
        dataType: 'json',
        data: data,
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
          $('.overlay').addClass('hidden')
        }
      })
      
      .done(function(resp) {
        if (resp.sukses == true && resp.tte == "true" && resp.sukses_tte == true) {
          showModalCetak(resp);
        }else if (resp.sukses == true && resp.tte == "true" && resp.sukses_tte != true){
          console.log(resp);
          if (resp.message) {
            alert(resp.message)
          } else {
            alert('Gagal melakukan proses TTE, eresep tidak disimpan!');
          }
        }else {
          alert('Gagal menyimpan data');
        }
      }).fail(function (err) {
        if (err.status = 500) {
          alert('Internal Server Error 18')
        } else if (err.status = 0) {
          alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
        } else {
          alert('Gagal menyimpan data')
        }
      });
    }
  })

  function savePenjualanWithTTE() {
    if (confirm('Apakah anda yakin akan menyimpan dan melakukan proses tanda tangan elektronik?')) {
          $('#myModal').modal('show');
      }
  }

  function showModalCetak(resp) {
    $('#showCetak').modal({ backdrop : 'static', keyboad : false });
    //$('#non_kronis').attr('href', '/farmasi/cetak-detail-baru/'+resp.id)
    //$('#kronis').attr('href', '/farmasi/cetak-baru-fakturkronis/'+resp.id)
    $('#non_kronis').attr('href', '/farmasi/cetak-detail/'+resp.id)
    $('#eresep').attr('href', '/farmasi/cetak-eresep-tte/'+resp.id)
    $('#etiket').attr('href', '/farmasi/laporan/etiket/'+resp.id)
    $('#copyresep').attr('href', '/copy-resep/form-penjualan/'+resp.pasien_id+'/'+resp.registrasi_id+'/'+resp.id)
    $('#kronis').attr('href', '/farmasi/cetak-fakturkronis/'+resp.id)
    if (resp.jenis == 'J') {
      $('#selesai').attr('href', '/penjualan/jalan-baru')
    }else if( resp.jenis == 'G'){
      $('#selesai').attr('href', '/penjualan/darurat-baru')
    }else if (resp.jenis == 'I') {
      $('#selesai').attr('href', '/penjualan/irna-baru')
    }
  }

  function savePenjualan() {
    if (confirm('Yakin data penjualan sudah benar?')) {
      var  data = $('#formTotalPenjualan').serialize()
      $.ajax({
        url: '/penjualannew/simpan-total-penjualan',
        type: 'POST',
        dataType: 'json',
        data: data,
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
           $('.overlay').addClass('hidden')
        }
      })
      
      .done(function(resp) {
        if (resp.sukses == true) {
          $('#showCetak').modal({ backdrop : 'static', keyboad : false });
          //$('#non_kronis').attr('href', '/farmasi/cetak-detail-baru/'+resp.id)
          //$('#kronis').attr('href', '/farmasi/cetak-baru-fakturkronis/'+resp.id)
          $('#non_kronis').attr('href', '/farmasi/cetak-detail/'+resp.id+'?faktur=nonkronis')
          // $('#eresep').attr('href', '/farmasi/cetak-eresep-tte/'+resp.id)
          $('#eresep').attr('href', '/farmasi/cetak-eresep/'+resp.id)
          
          $('#etiket').attr('href', '/farmasi/laporan/etiket/'+resp.id)
          $('#copyresep').attr('href', '/copy-resep/form-penjualan/'+resp.pasien_id+'/'+resp.registrasi_id+'/'+resp.id)
          $('#kronis').attr('href', '/farmasi/cetak-fakturkronis/'+resp.id)
          if (resp.jenis == 'J') {
            $('#selesai').attr('href', '/penjualan/jalan-baru')
          }else if( resp.jenis == 'G'){
            $('#selesai').attr('href', '/penjualan/darurat-baru')
          }else if (resp.jenis == 'I') {
            $('#selesai').attr('href', '/penjualan/irna-baru')
          }
          //window.history.back();
        }else{
          alert('Gagal Simpan karena '+resp.message)
        }
      }).fail(function (err) {
        if (err.status = 500) {
          alert('Internal Server Error 19')
        } else if (err.status = 0) {
          alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
        } else {
          alert('Gagal menyimpan data')
        }
      });
    }
  }

  // validate jumlah
  $(document).on('keyup change',"input[name='jumlah']", function(){
    $("input[name='jumlah']").attr('style','');
    let max = $("input[name='stok']").val();
    if( parseInt(max) < parseInt(this.value) ){
      alert('Input Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
      return false;
    }
    
  })

  function cekJumlah(id,stok_asli){
    // $("input[name='jumlah']").attr('style','');
    let max = stok_asli;
    let qty = $("input[name='resep_detail["+id+"][qty]']").val()
    // return alert(qty)
    if( parseInt(max) < parseInt(qty) ){
      alert('Input Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='resep_detail["+id+"][qty]']").val(max)
      
    }else if( parseInt(qty) < 1 ){
      // $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
      return false;
    }
    
  }


  function editJumlah(rowId, input) {
    var qty = input.value;
    $.ajax({
      url: '/cartEditJumlahEresep?rowId='+rowId+'&idreg='+idreg+'&qty='+qty,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('.overlay').removeClass('hidden')
      },
      complete: function () {
          $('.overlay').addClass('hidden')
      }
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $('#viewDataOrder').load("/cartContentResep/"+idreg)
      }else{
        alert('Gagal merubah jumlah obat')
      }
    }).fail(function (err) {
      if (err.status = 500) {
        alert('Internal Server Error 20')
      } else if (err.status = 0) {
        alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
      } else {
        alert('Gagal merubah jumlah obat')
      }
    });
  }

  function editStatusKronis(rowId, input) {
    var is_kronis = input.value;
    $.ajax({
      url: '/cartEditKronisEresep?rowId='+rowId+'&idreg='+idreg+'&is_kronis='+is_kronis,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('.overlay').removeClass('hidden')
      },
      complete: function () {
        $('.overlay').addClass('hidden')
      }
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $('#viewDataOrder').load("/cartContentResep/"+idreg)
      }else{
        alert('Gagal merubah status kronis pada obat!')
      }
    }).fail(function (err) {
      if (err.status = 500) {
        alert('Internal Server Error 21')
      } else if (err.status = 0) {
        alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
      } else {
        alert('Gagal merubah status kronis pada obat!')
      }
    });
  }

  function validateKronis(input){
    if(input.checked){
        alert('Pastikan jumlah obat adalah kelipatan 30!')
    }
  }

  function validasiResep() {
    if (confirm('Apakah anda yakin memvalidasi resep ini?')) {
      var data = $('#form-validate-erecipe').serialize()
      $.ajax({
        url: '/penjualannew/validasi-eresep',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(resp) {
        console.log(resp);
        if (resp.sukses == true) {
          $('#validated').show();
          $('#invalidated').hide();
          $('#button_tambah_obat').show();
          $('#save-eresep-area').show();
          $('#viewDataOrder').load("/cartContentResep/"+idreg)
        }else{
            return alert(resp.data)
        }
      }).fail(function (err) {
        if (err.status = 500) {
          alert('Internal Server Error 22')
        } else if (err.status = 0) {
          alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
        } else {
          alert('Gagal memvalidasi eresep')
        }
      });
    }
  }

</script>
<script>
    document.getElementById('check-all').addEventListener('change', function() {
        var inputes = document.getElementsByClassName('check-item');
        for (var i = 0; i < inputes.length; i++) {
            inputes[i].checked = this.checked;
        }
    });
</script>
@endsection