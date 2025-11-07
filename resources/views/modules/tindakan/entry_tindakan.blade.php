@extends('master')

@section('header')
  <h1>
    @if (substr($jenis->status_reg,0,1) == 'G')
      Sistem Rawat Darurat
    @else
      Sistem Rawat Jalan 
    @endif
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3> --}}
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" style="height: auto;">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Tgl Lahir / Umur</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                @if(@$jenis->bayar == 1)
                  <h5 class="widget-user-desc">No JKN</h5>
                @endif
                  <h5 class="widget-user-desc">DPJP</h5>
                  <h5 class="widget-user-desc">No. Telepon</h5>
                  <h5 class="widget-user-desc">Eresep</h5>
                  @if (@$bayar_lunas)
                    <h5 class="widget-user-desc">No. Kwitansi</h5>
                  @endif
                </div>
                <div class="col-md-7">
                  <h3 class="widget-user-username">:{{ @$pasien->nama}}</h3>
                  <h5 class="widget-user-desc">: {{ @$pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ !empty(@$pasien->tgllahir) ? @$pasien->tgllahir : ''}} / {{ !empty(@$pasien->tgllahir) ? hitung_umur(@$pasien->tgllahir) : NULL }}</h5>
                  <h5 class="widget-user-desc">: {{ @$pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar(@$jenis->bayar) }} </h5>
                @if($jenis->bayar == 1)
                  <h5 class="widget-user-desc">: {{ @$pasien->no_jkn}}</h5>
                @endif
                  <h5 class="widget-user-desc">: {{ baca_dokter(@$jenis->dokter_id)}}</h5>
                  <h5 class="widget-user-desc">: {{ @$pasien->nohp}}</h5>
                  <h5 class="widget-user-desc">: 
                    <button type="button" class="btn btn-warning btn-flat btn-history-resep" data-id="{{ $reg_id }}"><i class="fa fa-bars" aria-hidden="true"></i> HISTORI E-RESEP</button></h5>

                    @if (count(@$bayar_lunas) > 0)
                      <h5 class="widget-user-desc">: 
                      @foreach ($bayar_lunas as $item)
                        - {{@$item->no_kwitansi}}<br/>
                      @endforeach
                      </h5>
                  @endif
                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                </div>
              </div>
            </div>
            <div class="widget-user-image"></div>
          </div>
          </div>
        </div>

        {{-- Modal History Penjualan ======================================================================== --}}
        <div id="myModalHistoryResep" class="modal fade" role="dialog">
          <div class="modal-dialog">
      
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">History E-Resep</h4>
              </div>
              <div class="modal-body" id="listHistoryResep">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
      
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
            <div class="row">
              <div class="col-md-8">
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan *', ['class' => 'col-sm-3 control-label']) !!}
                       {{-- @foreach(Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d) --}}
                       {{-- {{ $d->namatarif }} |  --}}
                    <div class="col-sm-9">
                        {{-- <select class="form-control chosen-select" name="tarif_id">
                          <option value="">Ketik Tindakan</option>
                          @foreach($tindakan as $d)
                            <option value="{{ $d->id }}">{{ @$d->nama }} | {{ number_format(@$d->total) }} 
                              @if($d->carabayar == 1)
                                <b class="pull-right text-green">&nbsp&nbsp&nbsp&nbsp [ JKN ]</b>
                              @elseif($d->carabayar == 2)
                                <b class="pull-right text-blue">&nbsp&nbsp&nbsp&nbsp [ Umum ]</b>
                              @elseif($d->carabayar == 8)
                                <b class="pull-right text-blue">&nbsp&nbsp&nbsp&nbsp [ Inhealth ]</b>
                              @endif
                            </option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small> --}}
                        {{-- <select class="select2-multiple form-control" name="tarif_id[]" multiple="multiple" id="select2Multiple" required>
                           @foreach($tindakan as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | {{ @$d->kode }} | {{ @$d->total }}
                            </option>
                            @endforeach              
                        </select> --}}
{{-- 
                        <select class="select2-multiple form-control" name="tarif_id[]" multiple="multiple" id="select2Multiple" required>
                           
                                      
                       </select> --}}
                       <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple">
                       
                      </select>

                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small> 
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Dokter Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {{--{!! Form::select('pelaksana', $pelaksana, $jenis->dokter_id, ['class' => 'chosen-select', 'placeholder'=>'']) !!}--}}
                          <select class="form-control select2" name="pelaksana" style="width: 100%;">

                                <option value="" selected></option>
                                @foreach ($pelaksana as $d)
                                  <option value="{{ $d->id }}" {{ @$d->id == @$jenis->dokter_id ? 'selected' : '' }}> {{ @$d->nama }} </option>
                                @endforeach
                         
                        </select>
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>


                @php  
                    

                    	$perawats = Modules\Poli\Entities\Poli::where('id', @$jenis->poli_id)->pluck('perawat_id');
                   
	                    $perawatReal =  @(explode(",", @$perawats[0]));
                @endphp   

                <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                    {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {{-- {!! Form::select('perawat', $perawatreal, null, ['class' => 'chosen-select','required'=>'required']) !!} --}}
                  
                        <select name="perawat" id="" class="select2 form-control">
                          @foreach ($perawatReal as $key=>$item)
                              <option value="{{ $item }}">{{ baca_pegawai($item) }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('perawat') }}</small>
                    </div>
                </div>



                {{-- <div class="form-group{{ $errors->has('kondisi_akhir_pasien') ? ' has-error' : '' }}">
                  {!! Form::label('kondisi_akhir_pasien', 'Kondisi Akhir Pasien', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                        {!! Form::select('kondisi_akhir_pasien', $kondisi_akhirs, NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                        <small class="text-danger">{{ $errors->first('kondisi_akhir_pasien') }}</small>
                  </div>
                </div> --}}



                <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                      {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-3">
                        <select name="cara_bayar_id" class="select2 form-control">
                        @foreach ($carabayar as $key => $item)
                          <option value="{{ $key }}" {{ ($key == $jenis->bayar) ? 'selected=selected' : '' }}>{{ $item }}</option>
                        @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                      </div>
                      {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-2 control-label']) !!}
                      <div class="col-sm-4">
                          {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                      </div>
                </div>
                <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                    {!! Form::label('cyto', 'Eksekutif', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          <select name="cyto" class="form-control">
                              <option value="" selected>Tidak</option>
                              <option value="cyto" {{ @$jenis->poli->kelompok == 'ESO' ? 'selected' : '' }}>Ya</option>
                          </select>
                          <small class="text-danger">{{ $errors->first('cyto') }}</small>
                      </div>
                  </div>

                  @if (cek_status_reg(@$jenis->status_reg) == 'G')
                    @php
                      $paket_infus = Modules\Registrasi\Entities\BiayaInfus::all();
                    @endphp

                    <div class="form-group">
                      {!! Form::label('billing_infus', 'Billing Infus', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                        <select name="billing_infus" class="form-control" onchange="paketInfus(this.value)">
                            <option value="Ya">Ya</option>
                            <option value="Tidak" selected>Tidak</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group" style="display: none;" id="paket_infus">
                      {!! Form::label('paket_infus', 'Paket Infus', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                        @forelse ($paket_infus as $paket)
                          <input style="" type="radio" name="paket_infus" value="{{$paket->id}}"> {{$paket->nama_biaya}} <br>
                        @empty
                          Tidak ada paket infus
                        @endforelse
                      </div>
                    </div>
                  @endif
              </div>

              
              
              <div class="col-md-4">
                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                {{-- @if(substr($jenis->status_reg,0,1) == 'G')
                    <div class="form-group">
                        {!! Form::label('jam_masuk', 'Jam Masuk', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control">
                            <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('jam_penanganan', 'Jam Penanganan', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <input type="time" name="jam_penanganan" id="jam_penanganan" class="form-control">
                            <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                        </div>
                    </div>
                @endif --}}

                <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                    {!! Form::label('poli_id', 'Pelayanan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="select2" name="poli_id" style="width: 100%">
                          @php
                              $poliid = $history ? $history->poli_id : $jenis->poli_id;
                          @endphp
                          @foreach ($opt_poli as $key => $d)
                            {{-- @if ($d->id == $->poli_id)
                              <option valuejenis="{{ $d->id }}" selected="true">{{ @$d->nama }}</option>
                            @else --}}
                              <option value="{{ $d->id }}" {{$d->id ==  $poliid ?  'selected' : ''}}>{{ @$d->nama }}</option>
                            {{-- @endif --}}

                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9 text-center">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat pull-right', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                    </div>
                </div>

              </div>

            </div>
            
            {!! Form::close() !!}
            </div>
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>Pilih</th>
                <th>No</th>
                <th>Tindakan</th>
                <th>Pelayanan</th>
                {{-- <th>Biaya</th> --}}
                {{-- <th>Jml</th> --}}
                <th>Total</th>
                <th>Pelaksana</th>
                <th>Perawat</th>
                {{-- <th>Perawat</th> --}}
                <th width="80px">Cara Bayar</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Bayar</th>
                <th>Sinkron</th> 
                <th>Hapus</th> 
              </tr>
            </thead>
            <tbody>
              <form id="formLunas">
                {{ csrf_field() }}
              @foreach ($folio as $key => $d)
                <tr>
                  {{-- <td>
                  @if($d->cara_bayar_id != 1)
                    <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
                  @else
                    @role(['administrator'])
                      <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
                    @endrole
                  @endif
                  </td> --}}
                  <td style="text-align: center;">
                    @if ($d->tercetak == 'Y')
                    <small style="color:green"><i>Tercetak</i></small>
                    @else
                    <input type="checkbox" name="pilih[{{$d->id}}]" value="{{$d->id}}" class="tindakan">
                    @endif
                  </td>
                  <td>{{ $no++ }}</td>
                  {{-- @php
                      if(@$d->verif_kasa_user =='tarif_new'){
                        @$tarif = @$d->tarif_baru->nama;
                      }else{
                        @$tarif = @$d->tarif->nama;
                      }
                  @endphp --}}
                  <td>{{ (@$d->tarif_id <> 10000 ) ? @$d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  {{-- <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td> --}}
                  {{-- <td class="text-center">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif->total) : '' }}</td> --}}
                  {{-- <td class="text-right">{{ number_format($d->total,0,',','.') }}</td> --}}
                  <td class="text-right">{{ number_format($d->total - $d->dijamin,0,',','.') }}</td>
                  <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
                  <td>{{ baca_pegawai($d->perawat) }}</td>
                  <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                  {{--<td>
                    <div class="form-group">
                      {!! Form::select('bayar', $carabayar, $d->cara_bayar_id, ['class' => 'form-control select2', 'id' => $d->id]) !!}
                    </div>--}}
                  </td>
                    {{--  @if (!empty($reg->perusahaan_id))
                      - {{ $reg->perusahaan->nama }}
                    @endif  --}}
                  <td>{{ $d->user->name }}</td>
                  <td>{{ date('d-m-Y H:i', strtotime(@$d->created_at)) }}</td>
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                    <i class="fa fa-check"></i>
                    @else
                    <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  <td> {{-- Jika Inhealth Mandiri --}}
                    @if( $d->cara_bayar_id == 8)
                    <input type="hidden" name="no_sjp_inhealth" value="{{ isset($inhealth->no_sjp) ? $inhealth->no_sjp : null }}">
                    {{-- 3: rawat jalan, 4: rawat inap --}}
                    @if (substr($jenis->status_reg,0,1) == 'G')
                    @else
                      <input type="hidden" name="jenis_pelayanan_inhealth" value="3">
                    @endif
                    @php
                      $kode_jenpel = \DB::table('tarifs')->where('id', $d->tarif_id)->first()->inhealth_jenpel;
                    @endphp
                    <input type="hidden" name="kode_tindakan_inhealth" value="{{ $kode_jenpel }}">
                    <input type="hidden" name="tglmasukrawat" value="{{ $tglmasukrawat }}">
                    <input type="hidden" name="dokter_pelaksana_inhealth" value="{{ $d->dokter_pelaksana }}">
                    <input type="hidden" name="poli_inhealth" value="{{ $d->poli_id }}">
                    <button id="btn-{{ $d->id }}" type="button" {{ ($d->sinkron_inhealth == "sinkron") ? "disabled" : "" }} {{ ($kode_jenpel==null) ? "disabled" : "" }} href="javascript:void(0)" data-id="{{ $d->id }}" class="btn btn-primary btn-sm btn-flat inhealth-tindakan"><i class="fa fa-check"></i></button>
                    @endif
                  </td>
                  @role(['rawatjalan','kasir', 'supervisor', 'rawatdarurat','administrator'])
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                  </td>
                  @endrole
                </tr>
                @endforeach
                </form>
                {{-- <tr>
                  <td><button onclick="lunas()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                  <td colspan="5">UPDATE TERBAYAR</td>
                @role(['administrator'])
                  <td><button type="button" onclick="belumLunas()" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                  <td colspan="7">UPDATE BELUM TERBAYAR</td>
                @endrole
                </tr> --}}
            </tbody>
          </table>
        </div>

        {{--  KONDISI PASIEN AKHIR  --}}
        {!! Form::open(['method' => 'POST', 'route' => 'tindakan.kondisiakhir', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('status_reg', substr($jenis->status_reg,0,1)) !!}
{{-- 
            <div class="form-group{{ $errors->has('kondisi_akhir_pasien') ? ' has-error' : '' }}">
                {!! Form::label('kondisi_akhir_pasien', 'Kondisi Akhir Pasien', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('kondisi_akhir_pasien', $kondisi, null, ['class' => 'chosen-select']) !!}
                    <small class="text-danger">{{ $errors->first('kondisi_akhir_pasien') }}</small>
                </div>
            </div>
            <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
              {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
             
                  <input type="text" name="keterangan" class="form-control">
                  <small class="text-danger">{{ $errors->first('keterangan') }}</small>
              </div>
          </div> --}}
            <div class="btn-group pull-right">
              @if (substr($jenis->status_reg,0,1) == 'J')
                <div class="pull-left">
                  <input class="pull-left" name="tanpa_obat" type="checkbox" value="1" id="flexCheckChecked">
                  &nbsp; <span class="text-danger">Wajib Dicentang Jika Pasien Tanpa Obat</span> &nbsp;&nbsp;
                </div>
                @endif

             
                {{-- <a href="{{ url('tindakan') }}" class="btn btn-success btn-flat" onclick="confirm('Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!')">SELESAI</a> --}}
                <button type="submit" class="btn btn-success btn-flat" onclick="confirm('Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!')">SELESAI</button>
                {{-- @else                 --}}
                {{-- <button type="submit" class="btn btn-success btn-flat" onclick="confirm('Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!')">SELESAI</button> --}}
                {{-- <a href="{{ url('tindakan/igd') }}" class="btn btn-success btn-flat" onclick="confirm('Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!')">SELESAI</a> --}}
              
                {{-- {!! Form::submit("SELESAI & VERIF", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!")']) !!} --}}
            </div>

          {!! Form::close() !!}

          {{-- JIKA Eksekutif --}}
          @if ($jenis->poli_id == 42) 
            {!! Form::open(['method' => 'POST', 'url' => url('/kasir/cetakkuitansi-dipilih-eksekutif/' . $reg_id), 'class' => 'form-horizontal', 'id' => 'tindakan-dipilih']) !!}
          @else    
            {!! Form::open(['method' => 'POST', 'url' => url('/kasir/cetakkuitansi-dipilih/' . $reg_id), 'class' => 'form-horizontal', 'id' => 'tindakan-dipilih']) !!}
          @endif
            <button type="button" class="btn btn-warning btn-flat" id="cetakKwitansi">CETAK KWITANSI TERPILIH/DIPILIH</button>
          {!! Form::close() !!}
      </div>
    </div>
@stop

<style>
  .select2-selection__rendered{
    padding-left: 20px !important;
  }
</style>

@section('script')
@parent
  <script>
      $(document).ready(function() {
          // Select2 Multiple
          $('.select2-multiple').select2({
              placeholder: "Pilih Multi Tindakan",
              allowClear: true
          });

      });

      $('#cetakKwitansi').click(function (e) {
        e.preventDefault();
        $('.tindakan:checked').each(function() {
          let elemen = $(this).clone();
          elemen.attr('type', "hidden").appendTo('#tindakan-dipilih');
        });
        $('#tindakan-dipilih').submit();
      })
</script>
<script type="text/javascript">
 status_reg = "<?= substr($jenis->status_reg,0,1) ?>"
  $('.select2').select2();
  $('select[name="bayar"]').on('change', function(){
    $.get('/tindakan/updateCaraBayar/'+$(this).attr('id')+'/'+$(this).val(), function(){
      location.reload();
    });
  })

 // MASTER OBAT
 $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan/'+status_reg,
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

  $(document).on('click','.btn-history-resep',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/tindakan/e-resep/history/'+id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
            $('#listHistoryResep').html('');
            },
            success: function (res){
            $('#listHistoryResep').html(res.html);
            $('#myModalHistoryResep').modal('show');
            }
        });
        })

  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function lunas(){
    var data = $('#formLunas').serialize();
    if(confirm('Yakin akan di lunaskan?')){
      $.post('/tindakan/lunas', data, function(resp){
        if(resp.sukses == true){
          location.reload()
        }
      })
    }
  }
  function belumLunas(){
    var data = $('#formLunas').serialize();
    if(confirm('Yakin belum lunas?')){
      $.post('/tindakan/belumLunas', data, function(resp){
        if(resp.sukses == true){
          location.reload()
        }
      })
    }
  }

  $(document).ready(function() {
    //TINDAKAN entry
    $('select[name="kategoriTarifID"]').on('change', function() {
        var tarif_id = $(this).val();
        if(tarif_id) {
            $.ajax({
                url: '/tindakan/getTarif/'+tarif_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    //$('select[name="tarif_id"]').append('<option value=""></option>');
                    $('select[name="tarif_id"]').empty();
                    $.each(data, function(id, nama, total) {
                        $('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
                    });

                }
            });
        }else{
            $('select[name="tarif_id"]').empty();
        }
    });
  });

  // tindakan inhealth
  $(document).on('click','.inhealth-tindakan', function(){
    let id = $(this).attr('data-id');
    let body = { _token : "{{ csrf_token() }}", poli : $('input[name="poli_inhealth"]').val(), kodedokter : $('input[name="dokter_pelaksana_inhealth"]').val(), nosjp : $('input[name="no_sjp_inhealth"]').val(), jenispelayanan : $('input[name="jenis_pelayanan_inhealth"]').val(), kodetindakan : $('input[name="kode_tindakan_inhealth"]').val(), tglmasukrawat : $('input[name="tglmasukrawat"]').val() };
    if( confirm('Yakin akan di Sinkron Inhealth?') ){
      $.ajax({
          url: '/tindakan/inhealth/'+id,
          type: "POST",
          data: body,
          dataType: "json",
          beforeSend: function(){
            $('button#btn-'+id).prop("disabled", true);
          },
          success:function(res) {
            $('button#btn-'+id).prop("disabled", false);
            if( res.status == true ){
              $('button#btn-'+id).prop("disabled", true);
              alert(res.msg);
            }else{
              alert(res.msg);
            }
          }
      });
    }
  })

  function paketInfus(mcu) {
    if (mcu == "Ya") {
      $('#paket_infus').show();
    } else {
      $('#paket_infus').hide();
    }
  }
</script>
@endsection
