 
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          
        <div class="box box-widget widget-user">
          
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
              </div>
              <div class="col-md-7">
                <h3 class="widget-user-username">:{{ @$reg->pasien->nama}}</h3>
                <h5 class="widget-user-desc">: {{ @$reg->pasien->no_rm }}</h5>
                <h5 class="widget-user-desc">: {{ !empty(@$reg->pasien->tgllahir) ? @$reg->pasien->tgllahir : ''}} / {{ !empty(@$reg->pasien->tgllahir) ? hitung_umur(@$reg->pasien->tgllahir) : NULL }}</h5>
                <h5 class="widget-user-desc">: {{ @$reg->pasien->alamat}}</h5>
                <h5 class="widget-user-desc">: {{ baca_carabayar(@$reg->bayar) }} </h5>
              @if($reg->bayar == 1)
                <h5 class="widget-user-desc">: {{ @$reg->pasien->no_jkn}}</h5>
              @endif
                <h5 class="widget-user-desc">: {{ baca_dokter(@$reg->dokter_id)}}</h5>
                <h5 class="widget-user-desc">: {{ @$reg->pasien->nohp}}</h5>
                <h5 class="widget-user-desc">: 
                  <button type="button" class="btn btn-warning btn-flat btn-history-resep" data-id="{{ $reg->id }}"><i class="fa fa-bars" aria-hidden="true"></i> HISTORI E-RESEP</button></h5>
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
      
      <div class="box box-info">
        <div class="box-body">
          {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
          <div class="row">
            <div class="col-md-8">
              <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                  {!! Form::label('tarif_id', 'Tindakan *', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                       
                     <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple">
                     
                    </select>

                      <small class="text-danger">{{ $errors->first('tarif_id') }}</small> 
                  </div>
              </div>
              <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                  {!! Form::label('pelaksana', 'Dokter Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      
                        <select class="form-control select2" name="pelaksana" style="width: 100%;">

                              <option value="" selected></option>
                              @foreach ($pelaksana as $d)
                                <option value="{{ $d->id }}" {{ @$d->id == @$reg->dokter_id ? 'selected' : '' }}> {{ @$d->nama }} </option>
                              @endforeach
                       
                      </select>
                      <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                  </div>
              </div>


              @php  
                  

                    $perawats = Modules\Poli\Entities\Poli::where('id', @$reg->poli_id)->pluck('perawat_id');
                 
                    $perawatReal =  @(explode(",", @$perawats[0]));
              @endphp   

              <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                  {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select name="perawat" id="" class="chosen-select form-control">
                        @foreach ($perawatReal as $key=>$item)
                            <option value="{{ $item }}">{{ baca_pegawai($item) }}</option>
                        @endforeach
                      </select>
                      <small class="text-danger">{{ $errors->first('perawat') }}</small>
                  </div>
              </div>
              <input type="hidden" name="kondisi_akhir_pasien" value="">
              
              <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                    {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-3">
                      <select name="cara_bayar_id" class="select2 form-control">
                      @foreach ($carabayar as $key => $item)
                        <option value="{{ $item->id }}" {{ ($item->id == $reg->bayar) ? 'selected=selected' : '' }}>{{ $item->carabayar }}</option>
                      @endforeach
                      </select>
                        <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                    </div>
                    {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                    </div>
              </div>
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

              <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                  {!! Form::label('poli_id', 'Pelayanan', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="select2" name="poli_id" style="width: 100%">
                        @php
                            $poliid = $reg ? $reg->poli_id : $reg->poli_id;
                        @endphp
                        @foreach ($opt_poli as $key => $d)
                            <option value="{{ $d->id }}" {{$d->id ==  $poliid ?  'selected' : ''}}>{{ @$d->nama }}</option>

                        @endforeach
                      </select>
                      <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                {!! Form::label('cyto', 'Eksekutif', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                  <select name="cyto" class="form-control">
                      <option value="" selected>Tidak</option>
                      <option value="cyto" {{ @$reg->poli->kelompok == 'ESO' ? 'selected' : '' }}>Ya</option>
                  </select>
                    <small class="text-danger">{{ $errors->first('cyto') }}</small>
                </div>
              
                </div>
              <div class="form-group">
                  {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9 text-center">
                      {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                  </div>
              </div>

            </div>
          </div>

          {!! Form::close() !!}
        </div>
      </div>
      
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Tindakan</th>
              <th>Pelayanan</th>
              <th>Total</th>
              <th>Pelaksana</th>
              <th>Perawat</th> 
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
                <td>{{ $no++ }}</td>
                <td>{{ (@$d->tarif_id <> 10000 ) ? @$d->tarif->nama : 'Penjualan Obat' }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td class="text-right">{{ number_format($d->total - $d->dijamin,0,',','.') }}</td>
                <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
                <td>{{ baca_pegawai($d->perawat) }}</td>
                <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                
                </td>
                
                <td>{{ $d->user->name }}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                <td class="text-center">
                  @if ($d->lunas == 'Y')
                  <i class="fa fa-check"></i>
                  @else
                  <i class="fa fa-remove"></i>
                  @endif
                </td>
                <td>
                  @if( $d->cara_bayar_id == 8)
                  <input type="hidden" name="no_sjp_inhealth" value="{{ isset($inhealth->no_sjp) ? $inhealth->no_sjp : null }}">
                  
                  @if (substr(@$jenis->status_reg,0,1) == 'G')
                  @else
                    <input type="hidden" name="jenis_pelayanan_inhealth" value="3">
                  @endif
                  @php
                    @$kode_jenpel = \DB::table('tarifs')->where('id', $d->tarif_id)->first()->inhealth_jenpel;
                  @endphp
                  <input type="hidden" name="kode_tindakan_inhealth" value="{{ @$kode_jenpel }}">
                  <input type="hidden" name="tglmasukrawat" value="{{ @$tglmasukrawat }}">
                  <input type="hidden" name="dokter_pelaksana_inhealth" value="{{ @$d->dokter_pelaksana }}">
                  <input type="hidden" name="poli_inhealth" value="{{ $d->poli_id }}">
                  <button id="btn-{{ $d->id }}" type="button" {{ (@$d->sinkron_inhealth == "sinkron") ? "disabled" : "" }} {{ (@$kode_jenpel==null) ? "disabled" : "" }} href="javascript:void(0)" data-id="{{ $d->id }}" class="btn btn-primary btn-sm btn-flat inhealth-tindakan"><i class="fa fa-check"></i></button>
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
              
          </tbody>
        </table>
      </div>
      {!! Form::open(['method' => 'POST', 'route' => 'tindakan.kondisiakhir', 'class' => 'form-horizontal']) !!}
        <input type="hidden" name="registrasi_id" value="{{ @$reg->id }}">
        <input type="hidden" name="source" value="cppt">
        <div class="btn-group pull-right">
          @if (substr($reg->status_reg,0,1) == 'J')
            <div class="pull-left">
              <input class="pull-left" name="tanpa_obat" type="checkbox" value="1" id="flexCheckChecked">
              &nbsp; <span class="text-danger">Wajib Dicentang Jika Pasien Tanpa Obat</span> &nbsp;&nbsp;
            </div>
          @endif
          <button type="submit" class="btn btn-success btn-flat" onclick="confirm('Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!')">SELESAI</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  @section('script')
  
  @endsection