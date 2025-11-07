@extends('master')

@section('header')
  <h1>SOAP</h1>
@endsection

@section('css')
    <style>
        .blink_red {
            color: red;
            font-weight: bold;
            animation: blinker 2s linear infinite;
        }
        
        @keyframes blinker {
            50% {
            opacity: 0;
            }
        }
    </style>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        {{-- <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>  --}}
        @include('emr.modules.addons.profile')
        <div class="row">
            <div class="col-md-12">
             @include('emr.modules.addons.tabs')
                <form method="POST" action="{{ url('save-emr') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br> 
                      <div class="col-md-6">  
                          {{-- <div class="table-responsive" style="height:600px;"> --}}
                            <h3 style="margin-top:0px !important">E - RESEP</h3>
                            <a href="{{ url('cetak-emr/'.$reg->id) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
                            <a href="{{ url('cetak-emr/pdf/'.$reg->id) }}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                            <a href="{{ url('cetak-emr-rencana-kontrol/pdf/'.$reg->id) }}" target="_blank" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i></a>
                            {{-- <button type="button" class="btn btn-warning btn-flat btn-history-resep pull-right" data-id="{{ $reg->id }}"><i class="fa fa-bars" aria-hidden="true"></i> HISTORI E-RESEP</button> --}}
                            <button type="button" id="historipenjualan" data-registrasiID="{{ $reg->id }}" class="btn btn-info btn-sm btn-flat pull-right">
                              <i class="fa fa-th-list"></i> HISTORY OBAT
                            </button>
                            <button type="button" id="historipenjualaneresep" data-bayar="{{@$reg->bayar ? $reg->bayar :''}}" data-registrasiID="{{ $reg->id }}" class="btn btn-warning btn-sm btn-flat pull-right">
                              <i class="fa fa-th-list"></i> HISTORY E-RESEP
                            </button>
                            {{-- <button type="button" class="btn btn-primary btn-flat btn-add-resep pull-right" data-id="{{ $reg->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i> TAMBAH E-RESEP</button><br/> --}}
                            
                        {{-- </div> --}}
                      </div>
                      
                    <br/>
                    <br/> 
                    
                </form>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', $reg->id) !!}
                  {!! Form::hidden('cara_bayar', $reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form>
                
            </div>

            {{-- form eresep --}}
            <div class="col-md-8">
              
                <!-- Modal content-->
                <input type="hidden" name="pasien_id" value="{{$reg->pasien_id}}">
                <input type="hidden" name="uuid">
                <input type="hidden" name="reg_id" value="{{$reg->id}}">
                <input type="hidden" name="source" value="{{$unit}}">
                <input type="hidden" name="poli_id" value="{{@$poli}}">
                <div class="modal-content">
                  <div class="modal-body" style="display:grid;">
                    <h3>Daftar E-Resep</h3>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="control-label col-sm-2">Nama Obat:</label>
                          <div class="col-sm-10">
                            <select name="masterobat_id" id="masterObat" class="form-control" onchange="cariBatch()">
                                  
                            </select>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-sm-6">
                        {{-- @php
                          $paket_farmasi = Modules\Registrasi\Entities\BiayaFarmasi::all();
                        @endphp
                        <div class="form-group row">
                          {!! Form::label('billing_farmasi', 'Bundling HD', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                            <input style="" type="radio" name="billing_farmasi" onchange="paketFarmasi(this.value)" value="Ya"> Ya <br>
                            <input style="" type="radio" name="billing_farmasi" onchange="paketFarmasi(this.value)" value="Tidak" checked> Tidak
                          </div>
                        </div>
                        
                        <div class="form-group row" style="display: none;" id="paket_farmasi">
                          {!! Form::label('paket_farmasi', 'Paket HD', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                            @forelse ($paket_farmasi as $paket)
                              <input style="" type="radio" name="paket_farmasi" value="{{$paket->id}}"> {{$paket->nama_biaya}} <br>
                            @empty
                              Tidak ada paket farmasi
                            @endforelse
                          </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Nama Racikan:</label>
                          <div class="col-sm-8">
                            <input type="text" name="nama_racikan" class="form-control">
                          </div>
                        </div> --}}
                       
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Stok:</label>
                          <div class="col-sm-8">
                            <input type="text" name="last_stok" class="form-control" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Qty:</label>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty">
                          </div>
                        </div>

                        {{-- <div class="form-group row{{ $errors->has('kronis') ? ' has-error' : '' }}">
                          {!! Form::label('kronis', 'Kronis', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8"> --}}
                            {{-- {!! Form::select('kronis', ['Y'=>'Ya', 'N'=>'Tidak'], 'N', ['class' => 'form-control select2']) !!} --}}
                            {{-- <select name="kronis" id="" class="form-control">
                              <option value="N">Tidak</option>
                              <option value="Y">Ya</option>
                            </select>
                            <small class="text-danger">{{ $errors->first('kronis') }}</small>
                          </div> 
                        </div> --}}
                        <input type="hidden" name="kronis" value="N">

                        <div class="form-group row">
                          <label class="control-label col-sm-4">Jenis</label>
                          <div class="col-sm-8">
                            <select class="form-control select2" id="jenis_obat" name="jenis_obat" style="width: 100%">
                                <option value="non_racik" selected>NON RACIK</option>
                                <option value="racikan" >RACIKAN</option>
                            </select>
                          </div>
                        </div>

                        {{-- <div class="form-group row hidden racikan">
                          <label class="control-label col-sm-4">Racikan:</label>
                          <div class="col-sm-8">
                            <select class="form-control select2" name="racikan_id" style="width: 100%">
                              @foreach($racikan as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Cara Bayar:</label>
                          <div class="col-sm-8">
                            <select class="form-control select2" name="cara_bayar" style="width: 100%">
                              @foreach($carabayar as $key => $item)
                              <option value="{{ $item->carabayar }}" >{{ $item->carabayar }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                       
                      </div>
                      <div class="col-sm-6">
                        
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Petunjuk Peracikan:</label>
                          <div class="col-sm-8"> --}}
                            {{-- <select class="form-control select2" name="takaran" style="width: 100%">
                              <option value=""></option>
                              @foreach($takaran as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select> --}}
                            {{-- <input type="text" class="form-control" name="takaran"> --}}
                            
                          {{-- </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Dosis:</label>
                          <div class="col-sm-8"> --}}
                            {{-- <select class="form-control select2" name="tiket" style="width: 100%">
                              <option value="" ></option>
                              @foreach($tiket as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select> --}}
                              {{-- <input type="text" class="form-control" name="tiket"> --}}
                            {{-- <br><a href="{{url('farmasi/etiket')}}" target="_blank" style="text-decoration: none;font-size:12px;">Tambah Data Dosis</a> --}}
                          {{-- </div>
                        </div> --}}
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Signa</label>
                          <div class="col-sm-8">
                            {{-- <select class="form-control select2" name="cara_minum" style="width: 100%">
                              <option value="" ></option>
                              @foreach($cara_minum as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select> --}}
                            <input type="text" class="form-control" name="cara_minum">
                            {{-- <br><a target="_blank" href="{{url('penjualan/master-cara-minum')}}" style="text-decoration: none;font-size:12px;">Tambah Data Cara Minum</a> --}}
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-sm-4">Informasi:</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="informasi">
                          </div>
                        </div>

                        <div class="text-right">
                          
                        <button type="button" class="btn btn-primary" id="btn-save-resep">Tambah</button>
                        <p style="color:red">* Klik <span class="text-primary">"Tambah"</span> Obat Dahulu setelah memilih obat, Lalu Klik <span class="text-success">"Simpan Saja"</span> Atau <span class="text-info">"Simpan & Buat Template"</span></p>
                        </div>
                      </div>
                    </div>
                    {{-- Paket Farmasi --}}
                    <div class="form-group row mt-3">
                      @php
                        $paket_farmasi = Modules\Registrasi\Entities\BiayaFarmasi::all();
                      @endphp
                      <label class="control-label col-sm-2">Pilih Paket HD:</label>
                      <div class="col-sm-6">
                        <select class="form-control select2" id="paket_farmasi" name="paket_farmasi" style="width: 100%">
                          <option value="">-- Pilih Paket --</option>
                          @foreach($paket_farmasi as $pf)
                            <option value="{{ $pf->id }}">{{ $pf->nama_biaya }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn btn-success" id="btnPilihPaket">
                          <i class="fa fa-plus"></i> Tambah Paket
                        </button>
                      </div>
                    </div>
                    <br/>
                    <table class='table table-striped table-bordered table-hover table-condensed'>
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Obat</th>
                          <th>Qty</th>
                          <th>Cara Bayar</th>
                          <th>Harga Jual</th>
                          {{-- <th>Kronis</th> --}}
                          {{-- <th>Harga Jual JKN Satuan</th> --}}
                          {{-- <th>Dosis</th> --}}
                          <th>Signa</th>
                          {{-- <th>Petunjuk Peracikan</th> --}}
                          <th>Racikan</th>
                          <th>Informasi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="listResep">
                      </tbody>
                    </table>
                    <div id="total_info" style="display: none;">
                      <h4 style="font-weight: bold;">Total Harga: <span id="total_harga"></span></h4>
                      {{-- <h4 style="font-weight: bold">Total Harga JKN: <span id="total_harga_jkn"></span></h4> --}}
                      <p style="color:red">* Jika <span class="text-primary">"Nama Obat"</span> Berwarna merah, stok pada farmasi kurang dari 100</p>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="form-group row">
                      <label class="control-label col-sm-4">Nama Racikan atau Cara Pembuatan:</label>
                      {{-- <label class="control-label col-sm-4">Cara Pembuatan:</label> --}}
                      <div class="col-sm-8">
                        <input type="text" name="nama_racikan" class="form-control">
                        <br/>
                      </div>
                      <div id="signa_peracikan" class="hidden">
                        <label class="control-label col-sm-4">Signa Peracikan:</label>
                        <div class="col-sm-8">
                          <input type="text" name="signa_peracikan" class="form-control" placeholder="Signa Khusus untuk obat per satu racikan">
                          <br/>
                        </div>

                      </div>

                      <div class="col-sm-12" style="display: none;" id="btnSimpanResep">
                        @if (@Auth::user()->pegawai->status_tte)
                          <button type="button" id="btn-final-resep-tte" class="btn btn-success">Simpan</button>
                          <button type="button" id="btn-final-resep-duplicate-tte" class="btn btn-info">Simpan & Buat Template</button>
                        @else
                          <button type="button" id="btn-final-resep" class="btn btn-success">Simpan</button>
                          <button type="button" id="btn-final-resep-duplicate" class="btn btn-info">Simpan & Buat Template</button>
                        @endif

                      </div>
                      {{-- Cek apakah user bisa melakukan TTE --}}
                    </div>
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                    
                  </div>
                </div>
          
              
            
            </div>

            <div class="col-md-4">
              <div class="row">
                <div class="col-12">
                  <h5>Template Obat</h5>
                  <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                    <table class="table table-bordered" id="data" style="font-size: 12px;">
                         
                      <tbody>
                        @if (count($template) == 0)
                            <tr>
                              <td>Tidak ada record</td>
                            </tr>
                        @endif
    
                         @foreach( $template as $key_a => $val_a )
                            @php
                                $reg_template     = \Modules\Registrasi\Entities\Registrasi::where('id',$val_a->registrasi_id)->first();
                            @endphp
                            @if (@$reg_template->poli_id == @$reg->poli_id)
                                
                            <tr style="border-top: 2px solid red;">
                              <td style="border-top: 2px solid orange;">Racikan</td>
                              <td style="border-top: 2px solid orange;">{{$val_a->nama_racikan}}</td>
                            </tr>
                            <tr>
                              <td>Pasien</td>
                              <td style="font-weight: bold; font-size: 13pt;">{{baca_pasien($val_a->pasien_id)}}</td>
                            </tr>
                            <tr>
                              <td>Pembuat</td>
                              <td style="font-weight: bold; font-size: 13pt;">{{$val_a->user->name}}</td>
                            </tr>
                            <tr>
                              <td>Tgl Buat</td>
                              <td>{{ date("d F Y H:i:s", strtotime($val_a->created_at))}}</td>
                            </tr>
                            <tr>
                              <td><button data-toggle="collapse" data-target="#{{$key_a}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span> Detail Obat</button></td>
                              <td><a onclick="return confirm('Yakin akan menggunakan template?, Jika ada obat yang habis harus diubah saat edit eresep')" href="/emr/eresep/use-template-eresep/{{$reg->id}}/{{$unit}}/{{$val_a->uuid}}?poli={{$poli}}&dpjp={{$dpjp}}&use_template={{$val_a->uuid}}" class="btn btn-success btn-xs">Gunakan Template</a></td>
                            </tr>
                            <tr>
                              <td><a onclick="return confirm('Yakin akan menghapus template?')" href="/emr/eresep/use-template-eresep/delete/{{ $val_a->id }}" class="btn btn-danger btn-xs">Hapus</a></td>
                              {{-- <td><a onclick="return confirm('Template akan digunakan untuk umum?')" href="/emr/eresep/use-template-eresep/share/{{ $val_a->id }}" class="btn btn-warning btn-xs">Bagikan Untuk Umum</a></td> --}}

                            </tr>
                            <tr>
                              <td colspan="2">
                                <div class="accordian-body collapse" id="{{$key_a}}"> 
                                  <table class="table table-striped">
                                      <thead>
                                        <tr class="info">
                                          <th>Nama Obat</th>
                                          <th>Stok Gudang</th>
                                          <th>Qty</th>
                                        </tr>
                                        @foreach ($val_a->resep_detail as $v)
                                        @php
				                                    $masterobat = App\Masterobat::where('id', $v->logistik_batch->masterobat_id)->whereNull('deleted_at')->first();

                                            $batch = @App\LogistikBatch::where('masterobat_id',$v->logistik_batch->master_obat->id)
                                            ->where('stok', '>', '0')
                                            ->where('gudang_id','3')
                                            ->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')
                                            ->first();
                                        @endphp
                                        
                                        @if ($masterobat)
                                          <tr>
                                            <td>{{@$v->logistik_batch->master_obat->nama}}</td>
                                            <td>
                                              {{-- @if ($v->logistik_batch['stok'] <= 0)
                                                <i style="color:red;">Stok Kurang atau habis</i>
                                              @else  
                                                {{$v->logistik_batch['stok']}}
                                              @endif --}}
                                              @if (@$batch->stok <= 0)
                                                <i style="color:red;">Stok Kurang atau habis</i>
                                              @else  
                                                {{@$batch->stok}}
                                              @endif
                                              
                                            </td>
                                            <td>{{$v->qty}}</td>
                                          </tr>
                                        @endif
                                            
                                        @endforeach
                                      </thead>
                                  </table>
                                </div>
                              </td>
                            </tr> 
                            @endif
                          @endforeach
    
                          {{-- @if (count($template2) == 0)
                            <tr>
                              <td>Tidak ada recordx</td>
                            </tr>
                        @endif
                          @foreach( $template2 as $key_a => $val_a )
                            <tr style="border-top: 2px solid red;">
                              <td style="border-top: 2px solid orange;">Racikan</td>
                              <td style="border-top: 2px solid orange;">{{$val_a->nama_racikan}}</td>
                            </tr>
                            <tr>
                              <td>Pembuat</td>
                              <td>{{$val_a->user->name}}</td>
                            </tr>
                            <tr>
                              <td><button data-toggle="collapse" data-target="#{{$key_a}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                              <td><a onclick="return confirm('Yakin akan menggunakan template?')" href="/emr/eresep/use-template-eresep/{{$reg->id}}/{{$unit}}/{{$val_a->uuid}}?poli={{$poli}}&dpjp={{$dpjp}}" class="btn btn-success btn-xs">Gunakan Template</a></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <div class="accordian-body collapse" id="{{$key_a}}"> 
                                  <table class="table table-striped">
                                      <thead>
                                        <tr class="info">
                                          <th>Nama Obat</th>
                                          <th>Qty</th>
                                        </tr>
                                        @foreach ($val_a->resep_detail as $v)
                                        <tr>
                                          <td>{{$v->logistik_batch->master_obat->nama}}</td>
                                          <td>{{$v->qty}}</td>
                                        </tr>
                                            
                                        @endforeach
                                      </thead>
                                  </table>
                                </div>
                              </td>
                            </tr> 
                          @endforeach --}}
                          </tbody>
                      </table>  
                  </div>
                </div>
              </div>
              {{-- Eresep Belum Diproses--}}
              <div class="row">
                <div class="col-12">
                  <div style="margin-top: 3rem;">
                      <h5>Eresep Belum Diproses</h5>
                      <div class="table-responsive">
                          <table class="table-responsive" style="width: 100%">
                              <thead>
                                <tr>
                                  <th>ID Eresep</th>
                                  <th>No Antrian</th>
                                  <th>Cetak Antrian</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($eresep_belum_diproses as $p)
                                  <tr>
                                    <td>{{$p->uuid}}</td>
                                    <td>{{@$p->kelompok.''.$p->nomor}}</td>
                                    <td style="padding: .5rem;">
                                      <a href="{{ url('/farmasi/cetak-antrian-eresep/' . $p->id) }}"
                                        target="_blank" class="btn btn-danger btn-sm btn-flat"> <i
                                            class="fa fa-print"></i> </a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
              </div>

              {{-- Eresep --}}
              {{-- <div class="row">
                <div class="col-12">
                  <div style="margin-top: 3rem;">
                      <h5>Eresep Telah Diproses</h5>
                      <div class="table-responsive">
                          <table class="table-responsive" style="width: 100%">
                              <thead>
                                <tr>
                                  <th>No Resep</th>
                                  <th>Eresep</th>
                                  <th>TTE Eresep</th>
                                  <th>Eresep BerTTE</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($penjualan as $p)
                                 @if (!empty($p->id) && !empty($p->tte))
                                  <tr>
                                    <td>{{$p->no_resep}}</td>
                                    <td style="padding: .5rem;">
                                      <a href="{{ url('/farmasi/cetak-eresep/' . $p->id) }}"
                                        target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                            class="fa fa-search"></i> </a>
                                    </td>
                                    <td style="padding: .5rem; text-align: center">
                                      @if ($p->tte_dokter)
                                        <b><i class="text-success">Dokumen sudah ditanda tangan</i></b>
                                      @else
                                        <button data-registrasi-id="{{$reg->id}}" data-penjualan-id="{{$p->id}}" data-url="{{ url('/farmasi/tte-eresep/' . $p->id) }}"
                                          target="_blank" class="btn btn-warning btn-sm btn-flat proses-tte"> <i
                                              class="fa fa-pencil"></i> </button>
                                      @endif
                                    </td>
                                    <td style="padding: .5rem; text-align: center">
                                      @if ($p->tte_dokter && $p->tte_apotik)
                                        <a href="{{ url('/farmasi/eresep-bertte/' . $p->id) }}"
                                          target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                              class="fa fa-download"></i> </a>
                                      @else
                                          -
                                      @endif
                                    </td>
                                  </tr>
                                 @endif
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
              </div> --}}

              {{-- template umum eresep --}}
              {{-- <div class="row">
                <div class="col-12">
                  <hr/>
                  <h5>Template Umum Obat</h5>
                  <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                    <table class="table table-bordered" id="data" style="font-size: 12px;">
                         
                      <tbody>
                        @if (count($template) == 0)
                            <tr>
                              <td>Tidak ada record</td>
                            </tr>
                        @endif
    
                         @foreach( $template_umum as $key_a => $val_a )
                            <tr style="border-top: 2px solid red;">
                              <td style="border-top: 2px solid orange;">Racikan</td>
                              <td style="border-top: 2px solid orange;">{{$val_a->nama_racikan}}</td>
                            </tr>
                            <tr>
                              <td>Pasien</td>
                              <td>{{baca_pasien($val_a->pasien_id)}}</td>
                            </tr>
                            <tr>
                              <td>Tgl Buat</td>
                              <td>{{ date("d F Y  H:i:s", strtotime($val_a->created_at))}}</td>
                            </tr>
                            <tr>
                              <td>Pembuat</td>
                              <td>{{$val_a->user->name}}</td>
                            </tr>
                            <tr>
                              <td><button data-toggle="collapse" data-target="#template_umum{{$key_a}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span> Detail Obat</button></td>
                              <td><a onclick="return confirm('Yakin akan menggunakan template?, Jika ada obat yang habis harus diubah saat edit eresep')" href="/emr/eresep/use-template-eresep/{{$reg->id}}/{{$unit}}/{{$val_a->uuid}}?poli={{$poli}}&dpjp={{$dpjp}}" class="btn btn-success btn-xs">Gunakan Template</a></td>
                            </tr>
                            <tr>
                              <td><a onclick="return confirm('Yakin akan menghapus template?')" href="/emr/eresep/use-template-eresep/delete/{{ $val_a->id }}" class="btn btn-danger btn-xs">Hapus</a></td>
                              <td><a onclick="return confirm('Template akan digunakan untuk umum?')" href="/emr/eresep/use-template-eresep/share/{{ $val_a->id }}" class="btn btn-warning btn-xs">Bagikan Untuk Umum</a></td>

                            </tr>
                            <tr>
                              <td colspan="2">
                                <div class="accordian-body collapse" id="template_umum{{$key_a}}"> 
                                  <table class="table table-striped">
                                      <thead>
                                        <tr class="info">
                                          <th>Nama Obat</th>
                                          <th>Stok Gudang</th>
                                          <th>Qty</th>
                                        </tr>
                                        @foreach ($val_a->resep_detail as $v)
                                        @php
                                            $batch = App\LogistikBatch::where('masterobat_id',$v->logistik_batch->master_obat->id)
                                            ->where('stok', '>', '0')
                                            ->where('gudang_id','3')
                                            ->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')
                                            ->first();
                                        @endphp
                                        <tr>
                                          <td>{{$v->logistik_batch->master_obat->nama}}</td>
                                          <td>
                                            @if ($v->logistik_batch['stok'] <= 0)
                                              <i style="color:red;">Stok Kurang atau habis</i>
                                            @else  
                                              {{$v->logistik_batch['stok']}}
                                            @endif
                                            @if (@$batch->stok <= 0)
                                              <i style="color:red;">Stok Kurang atau habis</i>
                                            @else  
                                              {{@$batch->stok}}
                                            @endif
                                            
                                          </td>
                                          <td>{{$v->qty}}</td>
                                        </tr>
                                            
                                        @endforeach
                                      </thead>
                                  </table>
                                </div>
                              </td>
                            </tr> 
                          @endforeach
    
                          </tbody>
                      </table>  
                  </div>
                </div>
              </div> --}}
            </div>
            {{-- tabel template  obat--}}

    </div>
  </div>
  <div class="modal fade" id="icd9" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD9</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  
  <div class="modal fade" id="icd10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD10</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  {{-- Modal Eresep --}}
  {{-- <div id="myModalAddResep" class="modal fade" role="dialog">
   
  </div> --}}
  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualanEresep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History E-Resep</h4>
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

  
    {{-- Modal History Penjualan ======================================================================== --}}
    <div class="modal fade" id="showHistoriPenjualan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">History Obat Sebelumnya</h4>
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

  {{-- Modal TTE --}}
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-update" method="POST">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE Resep</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            <input type="hidden" class="form-control" id="url" disabled>
            <input type="hidden" class="form-control" id="proses_tte" value="false" disabled>
            <input type="hidden" class="form-control" id="saveTemplate" value="false" disabled>
            <input type="hidden" class="form-control" id="nik_hidden" name="nik_hidden" value="{{@Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Dokter:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{@Auth::user()->pegawai->nama}}" disabled>
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
          <button type="submit" class="btn btn-primary" id="button-proses-tte-resep">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>

  {{-- Modal TTE --}}
  <div id="myModalTemplate" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-update" method="POST">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE Resep</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            <input type="hidden" class="form-control" id="url" disabled>
            <input type="hidden" class="form-control" id="proses_tte_template_resep" value="false" disabled>
            <input type="hidden" class="form-control" id="nik_hidden_template_resep" name="nik_hidden_template_resep" value="{{@Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Dokter:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter_template_resep" id="dokter_template_resep" value="{{@Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nik_template_resep" id="nik_template_resep" value="{{substr(@Auth::user()->pegawai->nik, 0, -5) . "*****"}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase_template_resep" id="passphrase_template_resep" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button_proses_tte_template_resep">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>
@endsection

@section('script')
    <script>
      $(document).ready(function(){
        $('select[name="jenis_obat"]').on('change', function(e) {
        e.preventDefault();
        if ($(this).val() != 'racikan') {
          $('#signa_peracikan').addClass('hidden')
        } else {
          $('#signa_peracikan').removeClass('hidden')
        }
      })

      })

      var buatResep = false;

      $('.sidebar').click(function (e) {
        if (buatResep == true) {
          e.preventDefault()
          alert('Eresep belum disimpan, harap simpan eresep terlebih dahulu')
        }
      })

      $('.logo').click(function (e) {
        if (buatResep) {
          e.preventDefault()
          alert('Eresep belum disimpan, harap simpan eresep terlebih dahulu')
        }
      })

      $('#myTab').click(function (e) {
        if (buatResep) {
          e.preventDefault()
          alert('Eresep belum disimpan, harap simpan eresep terlebih dahulu')
        }
      })

      $('.proses-tte').click(function () {
          let url = $(this).data('url');
          let penjualan_id = $(this).data('penjualan-id');
          let registrasi_id = $(this).data('registrasi-id');
          $.ajax({
              url: '/farmasi/eresep/pdf-cek-tte/' + registrasi_id + '/' + penjualan_id,
              type: 'get',
              dataType: 'json',
              success: function(response){
                  $('#penjualan_id').val(penjualan_id);
                  $('#url').val(url);
                  $('#dokter').val(response.dokter.nama);
                  if (response.dokter.nik) {
                    $('#nik').val(response.dokter.nik.substring(0, response.dokter.nik.length -5) + "*****");
                  } else {
                    $('#nik').val(response.dokter.nik);
                  }
                  $('#nik_hidden').val(response.dokter.nik);
                  $('#myModal').modal('show');
              },
              error: function (res){
                if (res.status == 500) {
                  alert('Internal Server Error 4')
                } else if (res.status == 0) {
                  alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
                }
              }
          });
      })

      $('#button-proses-tte').click(function (e) {
          e.preventDefault();
          let nik = $('#nik_hidden').val();
          let passphrase = $('#passphrase').val();

          let url = $('#url').val() + '?passphrase=' + passphrase + '&nik=' + nik;
          window.location.href = url;
      })
    </script>
    <script type="text/javascript">
      $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);
        // HISTORY RESEP
        $(document).on('click', '#historipenjualaneresep', function (e) {
          var id = $(this).attr('data-registrasiID');
          var bayar = $(this).attr('data-bayar');
          $('#showHistoriPenjualanEresep').modal('show');
          $('#dataHistoriEresep').load("/penjualan/"+id+"/"+bayar+"/history-eresep");
        });
        // BTN SAVE RESEP
        $(document).on('click','#btn-save-resep',function(){
        let body = {
            "uuid" : $('input[name=uuid]').val(),
            "reg_id" : $('input[name=reg_id]').val(),
            "pasien_id" : $('input[name=pasien_id]').val(),
            "source" : $('input[name=source]').val(),
            "masterobat_id" : $('select[name=masterobat_id]').val(),
            "qty" : $('input[name=qty]').val(),
            "cara_bayar" : $('select[name=cara_bayar]').val(),
            "tiket" : $('input[name=tiket]').val(),
            "cara_minum" : $('input[name=cara_minum]').val(),
            // "takaran" : $('select[name=takaran]').val(),
            "kronis" : $('select[name=kronis]').val(),
            "takaran" : $('input[name=takaran]').val(),
            "jenis_obat" : $('select[name=jenis_obat]').val(),
            "informasi" : $('input[name=informasi]').val(),
            "_token" : $('input[name=_token]').val(),
        };
        $.ajax({
            url: '/tindakan/e-resep/save-detail',
            type: 'POST',
            dataType: 'json',
            data: body,
            success: function (res){
              if(res.status == true){
                  // Jika belum ada resep
                  if ($('input[name="uuid"]').val() == "") {
                    $('input[name="uuid"]').val(res.uuid);
                  }
                  $('select[name="kronis"]').val('N');
                  $('input[name="qty"]').val('');
                  $('input[name="cara_minum"]').val('');
                  $('input[name="takaran"]').val('');
                  $('input[name="tiket"]').val('');
                  $('input[name="informasi"]').val('');
                  $('input[name="jenis_obat"]').val('');
                  $('#listResep').html(res.html);
                  $('#total_harga').html(res.total);

                  if (res.show_warning) {
                    $('#total_harga').addClass('blink_red')
                  
                  }
                  $('#total_info').show();


                  $('#masterObat').focus();
                  $('#masterObat').select2('open');
                  $('#btnSimpanResep').show();

                  buatResep = true;
              }else{
                return alert(res.data)
              }
            },
            error: function (res){
              if (res.status == 500) {
                alert('Internal Server Error 5')
              } else if (res.status == 0) {
                alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
              } else {
                alert('Gagal menambah obat')
              }
            }
        });
        })

            // $('select[name="jenis_obat"]').change(function(e) {
            //   if($(this).val() == 'racikan'){
            //     $('.racikan').removeClass('hidden')
            //   } else {
            //     $('.racikan').addClass('hidden')
            //   }
            // });

        // BTN FINAL RESEP OPEN MODAL TTE
        $(document).on('click','#btn-final-resep-tte',function(){
          $('#myModal').modal('show');
          $('#proses_tte').val('true');
        })
        // BTN SAVE TEMPLATE RESEP OPEN MODAL TTE
        $(document).on('click','#btn-final-resep-duplicate-tte',function(){
          $('#myModalTemplate').modal('show');
          $('#proses_tte_template_resep').val('true');
        })

        $('#btnPilihPaket').click(function() {
            let paketId = $('#paket_farmasi').val();
            if(!paketId) {
                alert('Silakan pilih paket farmasi dulu');
                return;
            }

            $.getJSON('/tindakan/e-resep/paket/' + paketId, function(res) {
                if(res.status) {
                    let details = res.data.details;

                    function saveNext(index) {
                        if(index >= details.length) return;

                        let item = details[index];

                        $.getJSON('/penjualan/resep/master-obat-baru/', { j: 5, q: item.nama }, function(batchRes) {
                            if(batchRes.length > 0){
                                let batchId = batchRes[0].id;

                                let body = {
                                    "masterobat_id" : batchId,
                                    "qty"           : item.qty ?? 1,
                                    "cara_bayar"    : $('select[name=cara_bayar]').val(),
                                    "tiket"         : item.tiket ?? '',
                                    "cara_minum"    : item.cara_minum ?? '',
                                    "kronis"        : $('select[name=kronis]').val(),
                                    "takaran"       : item.takaran ?? '',
                                    "jenis_obat"    : item.jenis_obat ?? 'non_racik',
                                    "informasi"     : item.informasi ?? '',
                                    "_token"        : $('input[name=_token]').val(),
                                    "uuid"          : $('input[name=uuid]').val(),
                                    "reg_id"        : $('input[name=reg_id]').val(),
                                    "pasien_id"     : $('input[name=pasien_id]').val(),
                                    "source"        : $('input[name=source]').val(),
                                };

                                $.post('/tindakan/e-resep/save-detail', body, function(res){
                                    if(res.status){
                                        if ($('input[name="uuid"]').val() == "") {
                                            $('input[name="uuid"]').val(res.uuid);
                                        }
                                        $('#listResep').html(res.html);
                                        $('#total_harga').html(res.total);
                                        $('#btnSimpanResep').show();
                                    }
                                    saveNext(index + 1);
                                }, 'json');
                            } else {
                                saveNext(index + 1);
                            }
                        });
                    }
                    saveNext(0);
                }
            });
        });


        $('#button-proses-tte-resep').click(function (e) {
          e.preventDefault();
          // if( confirm('Yakin Akan Disimpan?') ){
              let body = {
              "duplicate" : true,
              "nama_racikan": $('input[name=nama_racikan]').val(),
              "uuid" : $('input[name=uuid]').val(),
              "poli_id": $('input[name=poli_id]').val(),
              "_token" : $('input[name=_token]').val(),
              "nik": $('input[name=nik_hidden]').val(),
              "passphrase": $('input[name=passphrase]').val(),
              "proses_tte": $('#proses_tte').val()
              };
              $.ajax({
              url: '/tindakan/e-resep/save-resep',
              type: 'POST',
              dataType: 'json',
              data: body,
              success: function (res){
                  if(res.status == true){
                      $('#myModalAddResep').modal('hide');
                      // if(!alert('Berhasil Add E-Resep !')){window.location.reload();}
                      window.location.reload();
                  } else {
                    if (res.message) {
                      alert(res.message);
                    } else {
                      alert('Gagal menyimpan eresep')
                    }
                  }

                  $('#myModal').modal('hide');
              },
              error: function (res){
                if (res.status == 500) {
                  alert('Internal Server Error 6')
                } else if (res.status == 0) {
                  alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
                } else {
                  alert('Gagal menyimpan eresep')
                }
              }
              });
          // }
        })

        $('#button_proses_tte_template_resep').click(function (e) {
          e.preventDefault();
          // if( confirm('Yakin Akan Disimpan & buat template?') ){
                let body = {
                "duplicate" : true,
                "nama_racikan": $('input[name=nama_racikan]').val(),
                "uuid" : $('input[name=uuid]').val(),
                "poli_id": $('input[name=poli_id]').val(),
                "_token" : $('input[name=_token]').val(),
                "nik": $('input[name=nik_hidden_template_resep]').val(),
                "passphrase": $('input[name=passphrase_template_resep]').val(),
                "proses_tte": $('#proses_tte_template_resep').val()
                };
                $.ajax({
                url: '/tindakan/e-resep/save-resep-duplicate',
                type: 'POST',
                dataType: 'json',
                data: body,
                success: function (res){
                    if(res.status == true){
                        $('#myModalAddResep').modal('hide');
                        // if(!alert('Berhasil Add E-Resep !')){window.location.reload();}
                        window.location.reload();
                        // }
                    } else {
                      if (res.message) {
                        alert(res.message);
                      } else {
                        alert('Gagal menyimpan eresep');
                      }
                    }
                },
                error: function (res){
                  if (res.status == 500) {
                    alert('Internal Server Error 7')
                  } else if (res.status == 0) {
                    alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
                  } else {
                    alert('Gagal menyimpan eresep')
                  }
                }
                });
            // }
        })
        
        $('#btn-final-resep').click(function(e) {
          e.preventDefault();
          let saveTemplate = $('#saveTemplate').val();
          if (saveTemplate == 'false') {
            // if( confirm('Yakin Akan Disimpan ?') ){
                let body = {
                "duplicate" : true,
                "nama_racikan": $('input[name=nama_racikan]').val(),
                "signa_peracikan": $('input[name=signa_peracikan]').val(),
                "uuid" : $('input[name=uuid]').val(),
                "poli_id": $('input[name=poli_id]').val(),
                "_token" : $('input[name=_token]').val(),
                "nik": $('input[name=nik_hidden]').val(),
                "passphrase": $('input[name=passphrase]').val()
                };
                $.ajax({
                url: '/tindakan/e-resep/save-resep',
                type: 'POST',
                dataType: 'json',
                data: body,
                success: function (res){
                    if(res.status == true){
                        $('#myModalAddResep').modal('hide');
                        // if(!alert('Berhasil Add E-Resep !')){window.location.reload();}
                        window.location.reload();
                    } else {
                      if (res.message) {
                        alert(res.message);
                      } else {
                        alert('Gagal menyimpan eresep')
                      }
                    }
  
                    $('#myModal').modal('hide');
                },
                error: function (res){
                  if (res.status == 500) {
                    alert('Internal Server Error 8')
                  } else if (res.status == 0) {
                    alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
                  } else {
                    alert('Gagal menyimpan eresep')
                  }
                }
                });
            // }
          } else if (saveTemplate == 'true') {
            // if( confirm('Yakin Akan Disimpan & buat template?') ){
                let body = {
                "duplicate" : true,
                "nama_racikan": $('input[name=nama_racikan]').val(),
                "uuid" : $('input[name=uuid]').val(),
                "poli_id": $('input[name=poli_id]').val(),
                "_token" : $('input[name=_token]').val(),
                "nik": $('input[name=nik_hidden]').val(),
                "passphrase": $('input[name=passphrase]').val(),
                };
                $.ajax({
                url: '/tindakan/e-resep/save-resep-duplicate',
                type: 'POST',
                dataType: 'json',
                data: body,
                success: function (res){
                    if(res.status == true){
                        $('#myModalAddResep').modal('hide');
                        // if(!alert('Berhasil Add E-Resep !')){window.location.reload();}
                        window.location.reload();
                        // }
                    } else {
                      if (res.message) {
                        alert(res.message);
                      } else {
                        alert('Gagal menyimpan eresep');
                      }
                    }
                },
                error: function (res){
                  if (res.status == 500) {
                    alert('Internal Server Error 9')
                  } else if (res.status == 0) {
                    alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
                  } else {
                    alert('Gagal menyimpan eresep')
                  }
                }
                });
            // }
          }
        })
        
        // BTN FINAL RESEP DAN BUAT TEMPLATE
        $(document).on('click','#btn-final-resep-duplicate',function(){
          // $('#myModal').modal('show');
          // $('#saveTemplate').val('true');
          // if( confirm('Yakin Akan Disimpan & buat template?') ){
                let body = {
                  "duplicate" : true,
                  "nama_racikan": $('input[name=nama_racikan]').val(),
                  "signa_peracikan": $('input[name=signa_peracikan]').val(),
                  "uuid" : $('input[name=uuid]').val(),
                  "poli_id": $('input[name=poli_id]').val(),
                  "_token" : $('input[name=_token]').val(),
                  "nik": $('input[name=nik_hidden]').val(),
                  "passphrase": $('input[name=passphrase]').val(),
                };
                $.ajax({
                url: '/tindakan/e-resep/save-resep-duplicate',
                type: 'POST',
                dataType: 'json',
                data: body,
                success: function (res){
                    if(res.status == true){
                        $('#myModalAddResep').modal('hide');
                        // if(!alert('Berhasil Add E-Resep !')){window.location.reload();}
                        window.location.reload();
                        // }
                    } else {
                      if (res.message) {
                        alert(res.message);
                      } else {
                        alert('Gagal menyimpan eresep');
                      }
                    }
                },
                error: function (res){
                  if (res.status == 500) {
                    alert('Internal Server Error 10')
                  } else if (res.status == 0) {
                    alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
                  } else {
                    alert('Gagal menyimpan eresep')
                  }
                }
                });
          // }
        })

        // DELETE DETAIL RESEP
        $(document).on('click','.del-detail-resep',function(){
        let id = $(this).attr('data-id');
        let body = {
            "_token" : $('input[name=_token]').val(),
        };
        $.ajax({
            url: '/tindakan/e-resep/detail/'+id+'/delete',
            type: 'DELETE',
            dataType: 'json',
            data: body,
            success: function (res){
              if(res.status == true){
                  $('#listResep').html(res.html);
                  $('#total_harga').html(res.total);
              }
            },
            error: function (res){
              if (res.status == 500) {
                alert('Internal Server Error 11')
              } else if (res.status == 0) {
                alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
              } else {
                alert('Gagal menghapus obat')
              }
            }
        });
        })

        // EDIT DETAIL RESEP
        function editQty(id){
          let qty = $('input[name=edit-qty-'+id+']').val();
          let body = {
            "qty" : qty,
            "_token" : $('input[name=_token]').val(),
          };
          // console.log(body);
          $.ajax({
            url: '/tindakan/e-resep/detail/editQty/'+id,
            type: 'POST',
            dataType: 'json',
            data:body,
            success: function (res){
              if(res.status == true){
                $('#listResep').html(res.html);
                $('#total_harga').html(res.total);
              }else{
                alert("Perubahan Gagal");
              }
            },
            error: function (res){
              if (res.status == 500) {
                alert('Internal Server Error 12')
              } else if (res.status == 0) {
                alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
              } else {
                alert('Gagal merubah qty obat')
              }
            }
          });
        }

        function paketFarmasi(mcu) {
          if (mcu == "Ya") {
            $('#paket_farmasi').show();
          } else {
            $('#paket_farmasi').hide();
          }
        }

        // MASTER OBAT
        $('#masterObat').select2({
            placeholder: "Klik untuk isi nama obat",
            width: '100%',
            ajax: {
                url: '/penjualan/resep/master-obat-baru/',
                dataType: 'json',
                data: function (params) {
                    return {
                        j: 1,
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })

        function cariBatch() {
            var masterobat_id = $("select[name='masterobat_id']").val();
            var warning       = "Warning!! Stok Saat ini kurang dari 100, Silahkan Hubungi Apotik";
            $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
                // console.log(resp)
                // if(resp.obat.stok <= 100){
                //  alert(JSON.stringify(warning));
                //  $('input[name="last_stok"]').val(resp.obat.stok);
                // }else{
                //  $('input[name="last_stok"]').val(resp.obat.stok);
                // }
                
                 $('input[name="last_stok"]').val(resp.obat.stok);
                $('input[name="qty"]').focus();
                
            })
        }
        $(document).ready(function(){
            $(document).on('click','.btn-delete-resume-medis',function(){
                let id = $(this).data('id');
                swal({
                    title: "Yakin Akan Dihapus?",
                    text: "Ketika Dihapus, Anda Tidak Bisa Mengembalikan Data Ini!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        callAjax(id);
                    }
                });
            })

            function callAjax(id) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/') }}/emr/"+id,
                    dataType: "JSON",
                    data : { 
                                _token: "{{ csrf_token() }}" 
                            },
                    success: function(res){
                        console.log(res)
                        location.reload();
                    }
                });
            }

            $('#kondisi_akhir').change(function(){
                if ($('#kondisi_akhir').val() === "4" || $('#nokontrol').prop("checked") === true) {
                    $("#rencana_kontrol").val('');
                    $("#rencana_kontrol").attr('required', false);
                    $("#rencana_kontrol").attr('disabled', true);
                } else {
                    $("#rencana_kontrol").attr('required', true);
                    $("#rencana_kontrol").attr('disabled', false);
                }
            });


            $('#nokontrol').click(function(){
                $("#rencana_kontrol").val('');
                if ($('#kondisi_akhir').val() === "4" || $('#nokontrol').prop("checked") === true) {
                    $("#rencana_kontrol").attr('required', false);
                    $("#rencana_kontrol").attr('disabled', true);
                } else {
                    $("#rencana_kontrol").attr('required', true);
                    $("#rencana_kontrol").attr('disabled', false);
                }
            });
        });

        $(document).on('click', '#historipenjualan', function (e) {
          var id = $(this).attr('data-registrasiID');
          $('#showHistoriPenjualan').modal('show');
          $('#dataHistori').load("/penjualan/"+id+"/history-baru-obat");
        });

        $(document).on('change', '#registrasi_select', function(e) {
            var id = $(this).val();
            console.log(id)
            // Loading
            $('#data-list').html(
                `<div class="spinner-square"> <div class="square-1 square"></div> <div class="square-2 square"></div> <div class="square-3 square"></div></div>`
                );
            $('#dataHistori').load("/penjualan/" + id + "/history-baru-obat");
        });
        $(document).on('change', '#filterSelect', function(e) {
            // alert($('#filterSelect').val())
            let id = $('#registrasi_select').val();
            let penjualanId = $('#filterSelect').val();
            $('#shoWHistoriPenjualan').modal('show');
            $('#dataHistori').load("/penjualan/" + id + "/" + penjualanId + "/history-baru-obat-filter");
        });
    </script>

@endsection

@section('css')
    <style>
      #btn-save-resep:focus {
        background-color: green;
      }
    </style>
@endsection
