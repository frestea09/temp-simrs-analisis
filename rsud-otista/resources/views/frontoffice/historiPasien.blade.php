@extends('master')
@section('header')
<h1>Histori Pasien<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-body">
    <div class="row">
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered table-hover">
            <tbody>
              <tr>
                <th>Nama Lengkap</th>
                <td>{{ !empty($pasien) ? $pasien->nama :NULL }}</td>
              </tr>
              <tr>
                <th>Nomor RM Baru</th>
                <td><b>{{ !empty($pasien) ?$pasien->no_rm :NULL }}</b></td>
              </tr>
              <tr>
                <th>Nomor RM Lama</th>
                <td>{{ !empty($pasien) ? $pasien->no_rm_lama : NULL }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>{{ !empty($pasien) ? $pasien->alamat : NULL }} rt: {{ !empty($pasien) ? $pasien->rt : NULL }} rw:
                  {{ !empty($pasien) ? $pasien->rw : NULL }}</td>
              </tr>
              <tr>
                <th>Ibu Kandung</th>
                <td>{{ !empty($pasien) ? $pasien->ibu_kandung : NULL }}</td>
              </tr>
              <tr>
                <th>HISTORY OBAT</th>
                <td><button type="button" id="historipenjualan" data-registrasiID="{{ $pasien->id }}" class="btn btn-info btn-sm btn-flat">
                  <i class="fa fa-th-list"></i> LIHAT
                </button></td>
              </tr>

            </tbody>
          </table>
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
      {{--END Modal History Penjualan ======================================================================== --}}
      <div class="col-md-4">
        {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/histori-pasien', 'class'=>'form-hosizontal']) !!}
        <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
          <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor
              RM</button>
          </span>
          {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
          <small class="text-danger">{{ $errors->first('no_rm') }}</small>
        </div>
        {!! Form::close() !!}

      </div>
    </div>
    @php
    $role = Auth::user()->role()->first()->name;
    @endphp

    {{-- <button type="button" class="btn btn-warning btn-sm" onclick="searchHistoryPasien({{$pasien->id}})" style="font-size: 15pt"><i class="fa fa-eye"></i> History RM</button> --}}
    
    <div class="table-responsive">
      <table class="table table-condensed table-bordered table-hover">
        <thead>
          <tr class="bg-primary">
            <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tgl.Registrasi</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tracer Kembali</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Poliklinik</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Kasus</th>
            {{-- <th rowspan="2" class="text-center" style="vertical-align: middle;">Lab</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Lab PA</th> --}}
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Radiologi</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tindakan</th>
            <th colspan="3" class="text-center">Rawat Inap</th>
            {{-- <th rowspan="2" class="text-center" style="vertical-align: middle;">Resume</th> --}}
            {{-- @if ($role == 'administrator') --}}
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Status</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Bayar</th>
            {{-- <th rowspan="2" class="text-center" style="vertical-align: middle;">Tagihan</th> --}}
            {{-- @role('administrator') --}}
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Registrasi_ID</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Pasien_ID</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Penginput Registrasi</th>
            {{-- @endrole --}}
            {{-- @endif --}}
          </tr>
          <tr class="bg-primary">
            <th class="text-center">Tanggal Masuk</th>
            <th class="text-center">Kamar</th>
            <th class="text-center">Tanggal Keluar</th>
          </tr>
        </thead>
        <tbody style="font-size:11px;">
          @if (!empty($reg))
          @foreach ($reg as $d)
          @php
          // $rj    = App\HistorikunjunganIRJ::where('registrasi_id', $d->id)->first();
          // $lab   = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->where('poli_id', 25)->get();
          // $labPa   = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->where('poli_id', 43)->get();
          // $rad   = App\HistorikunjunganRAD::where('registrasi_id', $d->id)->select('created_at')->get();
          $rad = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->get();
          // $ri    = App\Rawatinap::where('registrasi_id', $d->id)->first();
          // $folio = Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->id)->select('namatarif','total')->get();
          @endphp
          <tr @if($d->deleted_at) style="color:red" @endif>
            <td class="text-center">{{ $no++ }}</td>
            <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
            <td>{{ $d->tracer_kembali_tanggal ? date('d-m-Y',strtotime($d->tracer_kembali_tanggal)) : '-' }}</td>
            <td>
              {{ @$d->poli->nama }}
              <br>
              <b>({{ @$d->dokter_umum->nama }})</b>
            </td>
            <td> @if($d->kasus == '2') LAMA @else BARU @endif </td>
            {{-- <td>
              <ul style="padding: 0 0 0 15px">
                @foreach ($lab as $l)
                  <li>
                    {{ $l->namatarif }} / {{ $l->total }} <br>
                  </li>
                @endforeach
              </ul>
            </td>
            <td>
              <ul style="padding: 0 0 0 15px">
                @foreach ($labPa as $lpa)
                  <li>
                    {{ $lpa->namatarif }} / {{ $lpa->total }} <br>
                  </li>
                @endforeach
              </ul>
            </td> --}}
            <td>
              @foreach ($rad as $r)
              {{ $r->created_at->format('d-m-Y H:i:s') }} <br>
              @endforeach
            </td>
            <td>
              @if(!$d->deleted_at)
                <button class="btn btn-xs bg-info"
                onclick="popupWindow('/frontoffice/data-folio/'+{{$d->id}})">Lihat Tindakan</button>
              @endif
              {{-- @foreach (@$d->folio as $f)
              + {{ $f->namatarif }} / {{ $f->total }}<br>
              @endforeach --}}

              {{-- @if (count($folio) > 0) --}}
              @if(!$d->deleted_at)
                @if (Auth::user()->id == 1 || Auth::user()->id == 566)
                  <button class="btn btn-xs bg-primary"
                        onclick="pindahkanTgl({{ $d->id }},{{ $d->pasien_id }})">Pindahkan tindakan ke tgl</button>
                    
                @endif
              @endif
                  
              {{-- @endif --}}
            </td>
            <td>
              {{ @$d->rawat_inap ? tanggal(@$d->rawat_inap->tgl_masuk) : NULL }}
            </td>
            <td>
              {{ @$d->rawat_inap ? @$d->rawat_inap->kamar->nama : NULL }}
            </td>
            <td>
              {{ @$d->rawat_inap ? tanggal(@$d->rawat_inap->tgl_keluar) : NULL }}
              ({{ @$d->rawat_inap ? baca_user(@$d->rawat_inap->user_id) : NULL }})
            </td>
            {{-- <td>
              <a href="{{ url('cetak-resume-medis-rencana-kontrol/pdf/'.$d->id) }}" target="_blank"
                class="btn btn-warning"><i class="fa fa-paste"></i></a>
            </td> --}}
            <td class="text-right">
              @if ( substr($d->status_reg,0,1) == 'J' )
              RAWAT JALAN
              @elseif ( substr($d->status_reg,0,1) == 'G' )
              RAWAT DARURAT
              @elseif ( $d->status_reg == 'I1' )
              <i>*ANTRIAN RAWAT INAP</i>
              @elseif ( $d->status_reg == 'I2' )
              RAWAT INAP
              @elseif ($d->status_reg == 'I3')
              DIPULANGKAN
              @endif
              {{-- @if ($role == 'administrator') --}}
              {{-- @if (App\Rawatinap::where('registrasi_id',$d->id)->count() != 0) --}}
              @if ( substr($d->status_reg,0,1) == 'J' )
                @if ( json_decode(Auth::user()->is_edit,true)['edit'] == 1)
                <button class="btn btn bg-default btn-flat"
                  onclick="ubahPelayanan({{ $d->id }},'J2','{{ $d->created_at->format('d-m-Y') }}')"><i
                    class="fa fa-edit"></i> </button>
                @else
                @endif
              @elseif ( substr($d->status_reg,0,1) == 'G' )
                @if ( json_decode(Auth::user()->is_edit,true)['edit'] == 1)
                <button class="btn btn bg-default btn-flat"
                  onclick="ubahPelayanan({{ $d->id }},'G2','{{ $d->created_at->format('d-m-Y') }}')"><i
                    class="fa fa-edit"></i> </button>
                @else
                @endif
              @elseif ( $d->status_reg == 'I2' )
                @if ( json_decode(Auth::user()->is_edit,true)['edit'] == 1)
                  <button class="btn btn bg-default btn-flat"
                    onclick="ubahPelayananInap({{ $d->id }},'{{ $d->status_reg }}','{{ $d->created_at->format('d-m-Y') }}','{{ !empty($ri->tgl_masuk) ? \Carbon\Carbon::parse($ri->tgl_masuk)->format('d-m-Y') : NULL }}')"><i
                      class="fa fa-edit"></i> </button>
                @else
                @endif
              @elseif ( $d->status_reg == 'I3' )
                  @if ( json_decode(Auth::user()->is_edit,true)['edit'] == 1)
                  <button class="btn btn bg-default btn-flat"
                    onclick="ubahPelayananPulangkan({{ $d->id }},'{{ $d->status_reg }}','{{ $d->created_at->format('d-m-Y') }}','{{ !empty($ri->tgl_masuk) ? \Carbon\Carbon::parse($ri->tgl_masuk)->format('d-m-Y') : NULL }}','{{ !empty($ri->tgl_keluar) ? \Carbon\Carbon::parse($ri->tgl_keluar)->format('d-m-Y') : NULL }}')"><i
                      class="fa fa-edit"></i> </button>
                  @else
                  @endif
              @else
                  @if ( json_decode(Auth::user()->is_edit,true)['edit'] == 1)
                  <button class="btn btn bg-default btn-flat"
                    onclick="ubahPelayanan({{ $d->id }},'{{ $d->status_reg }}','{{ $d->created_at->format('d-m-Y') }}')"><i
                      class="fa fa-edit"></i> </button>
                  @else
                  @endif
              @endif
              {{-- @else
                    <button class="btn btn bg-default btn-flat" onclick="ubahPelayananbeluminap({{ $d->id }})"><i
                class="fa fa-edit"></i> </button>
              @endif --}}
              {{-- @endif --}}
            </td>
            {{-- @role('administrator') --}}
            <td>{{ @$d->bayars->carabayar }}</td>
            {{-- <td>
              <button class="btn btn-info total-tagihan-button" data-regId="{{$d->id}}"><i class="fa fa-search"></i></button>
            </td> --}}
            <td>{{ $d->id }}</td>
            <td>{{ $d->pasien_id }}</td>
            <td>{{ baca_user($d->user_create) }}</td>
            {{-- @endrole --}}
          </tr>
          @endforeach
          @else
          <tr>
            <th colspan="8" class="text-center">
              <h4>Data tidak ditemukan!!!</h4>
            </th>
          </tr>
          @endif
        </tbody>
      </table>
    </div>


    <div class="box-footer">
    </div>
  </div>


  {{-- MODAL PINDAHKAN TARIF --}}
  <div class="modal fade" id="pindahkanTgl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <h6 style="color:red;font-weight: bold;">* MOHON HATI-HATI SAAT PEMINDAHAN TINDAKAN!<span class="status"></span></h6>
          <h6 style="color:orange;font-weight: bold;">Jika sudah dipindahkan, tidak bisa dipindahkan kembali, pastikan data benar<span class="status"></span></h6>
          
          <input type="hidden" name="registrasi_id" value="">
          <div class="form-group">
          
            <div class="col-lg-12">
                
                <table class="table table-bordered" style="font-size:12px;">
                  <tr>
                    <th>Registrasi_ID</th>
                    <th>Tgl.Registrasi</th>
                    <th>Jenis Registrasi</th>
                    <th>Ruangan</th>
                    <th>Tgl.Masuk Ranap</th>
                    <th>Kamar</th>
                    <th>Tgl.Keluar Ranap</th>
                    <th>-</th>
                  </tr>

                  @foreach ($reg as $item)
                  @php
                      
                      $ri    = App\Rawatinap::where('registrasi_id', $item->id)->first();
                  @endphp
                  <tr>
                    <td>{{$item->id}}
                    
                    </td>
                    <td style="font-size:11px;">{{date('d-m-Y H:i',strtotime($item->created_at))}}</td>
                    <td>{{cek_jenis_reg($item->status_reg)}}</td>
                    <td>{{ @$item->poli->nama }}</td>
                    <td>
                      {{ !empty($ri) ? tanggal($ri->tgl_masuk) : '-' }}
                    </td>
                    <td>
                      {{ !empty($ri) ? baca_kamar($ri->kamar_id) : '-' }}
                    </td>
                    <td>
                      {{ !empty($ri) ? tanggal($ri->tgl_keluar) : '-' }}
                    </td>
                    
                    <td>
                      <form action="{{url('frontoffice/pindah-tindakan-pasien')}}"method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="regis_old" value="">  
                        <input type="hidden" name="pasien_pindahan" value="">  
                        <input type="hidden" name="regis_new" value={{$item->id}}>  
                        <input type="hidden" name="user_id" value={{Auth::user()->name}}>  
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin akan dipindahkan?')">Pilih</button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </table>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanPindahkan()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- MODAL UBAH STATUS PELAYANAN --}}
  <div class="modal fade" id="pelayanan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <h4 style="font-size: 12pt; font-weight: bold;">Status : <span class="status"></span></h4>
          {!! Form::open(['method' => 'POST', 'class'=>'form-horizontal', 'id' => 'formStatus2']) !!}
          <input type="hidden" name="registrasi_id" value="">
          <div class="form-group">
            <label for="status" class="col-md-4 control-label">Kembalikan Status Ke</label>
            <div class="col-lg-8">
              <select name="status_reg" class="form-control">
                {{-- <option value="">--</option> --}}
                <option value="J2">RAWAT JALAN</option>
                <option value="G2">RAWAT DARURAT</option>
                <option value="I1">ANTRIAN INAP</option>
                <option value="I2">RAWAT INAP</option>
                <option value="I3">PULANGKAN</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="status" class="col-md-4 control-label">Tanggal Registrasi</label>
            <div class="col-lg-8">
              <input type="text" class="form-control datepicker" name="tgl_registrasi">
            </div>
          </div>
          <div class="form-group status-tgl-masuk">
            <label for="status" class="col-md-4 control-label">Tanggal Masuk Inap</label>
            <div class="col-lg-8">
              <input type="text" class="form-control datepicker" name="tgl_masuk_inap" id="tgl_masuk_inap">
            </div>
          </div>
          <div class="form-group status-tgl-keluar">
            <label for="status" class="col-md-4 control-label">Tanggal Keluar Inap</label>
            <div class="col-lg-8">
              <input type="text" class="form-control datepicker" name="tgl_keluar_inap" id="tgl_keluar_inap">
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanStatus()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL UBAH STATUS PELAYANAN --}}
  <div class="modal fade" id="pelayananbeluminap">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <h4 style="font-size: 12pt; font-weight: bold;">Status : <span class="status"></span></h4>
          {!! Form::open(['method' => 'POST', 'class'=>'form-horizontal', 'id' => 'formStatus']) !!}
          <input type="hidden" name="registrasi_id" value="">
          <div class="form-group">
            <label for="status" class="col-md-4 control-label">Kembalikan Status Ke</label>
            <div class="col-lg-8">
              <select name="status_reg" class="form-control">
                {{-- <option value="">--</option> --}}
                <option value="J2">RAWAT JALAN</option>
                <option value="G2">RAWAT DARURAT</option>
                <option value="I1">ANTRIAN INAP</option>
              </select>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanHistori()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- Modal pencarian --}}
<div class="modal fade" id="pasien">
  <div class="modal-dialog" style="width: max-content;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
          {{-- <b>Pasien Baru: </b>
          <a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
          <a href="{{ url('/registrasi/create_umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a> --}}
          <div class="container">
           
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive" style="margin-top: -30px;">
                  <table class="table table-hover table-condensed table-bordered" id="tablePasien">
                    <thead>
                      <tr>
                        <th style="vertical-align: middle;">Registrasi</th>
                        <th style="vertical-align: middle;">Status</th>
                         <th style="vertical-align: middle;">Dokter</th>
                        <th class="text-center" style="vertical-align: middle;">Poli</th>
                        <th style="vertical-align: middle;">Cara Bayar</th>
                        {{-- <th style="vertical-align: middle;">No. JKN</th>
                        <th class="text-center" style="vertical-align: middle;">JKN</th>
                        <th class="text-center" style="vertical-align: middle;">Non JKN</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      
        <div class="modal-footer">
      </div>

        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Total Tagihan -->
{{-- <div class="modal fade" id="total_tagihan" tabindex="-1" role="dialog" aria-labelledby="saldoPiutangTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">
                  Total Tagihan
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="box-body">
                  <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active">
                      <div class="row">
                        <div class="col-md-6">
                          <h3>Total Tagihan :</h3>
                          <h3>Tagihan Lunas:</h3>
                          <h3>Sisa Tagihan:</h3>
                          <h3>Status Pembayaran :</h3>
                        </div>
                        <div class="col-md-6" id="tagihan-info">
                          <h3 id="total_tagihan_rp"></h3>
                          <h3 id="tagihan_lunas_rp"></h3>
                          <h3 id="sisa_tagihan_rp"></h3>
                          <h3 id="status_pembayaran_tagihan"></h3>
                        </div>
                      </div>
                    </div>
                  </div>
          </div>
      </div>
  </div>
</div> --}}


  @endsection

  @section('script')
  <script type="text/javascript">
    $(".skin-blue").addClass( "sidebar-collapse" );

    $(document).on('click', '#historipenjualan', function (e) {
      var id = $(this).attr('data-registrasiID');
      $('#showHistoriPenjualan').modal('show');
      $('#dataHistori').load("/penjualan/"+id+"/history-baru-by-id-pasien");
    });

    $(document).on('change','select[name="status_reg"]',function(){
      if( this.value == 'I2' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').hide();
      }else if( this.value == 'I3' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').show();
      }else{
        $('.status-tgl-masuk').hide();
        $('.status-tgl-keluar').hide();
      }
    })

    function formatAngka(angka) {
      return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

    $('.total-tagihan-button').click(function () {
      let regId = $(this).attr('data-regId');
      $.ajax({
        url: '/frontoffice/total_tagihan/' + regId,
        type: 'get',
        dataType: 'json',
        success: function(response){
          $('#total_tagihan_rp').html('Rp. ' + formatAngka(response.total_tagihan))
          $('#tagihan_lunas_rp').html('Rp. ' + formatAngka(response.tagihan_lunas))
          $('#sisa_tagihan_rp').html('Rp. ' + formatAngka(response.sisa_tagihan))
          $('#status_pembayaran_tagihan').html(response.lunas ? 'Lunas' : 'Belum Lunas')
        }
      });
      $('#total_tagihan').modal('show');
    })
    
    function ubahPelayanan(registrasi_id,status_reg,tgl_registrasi) {
      $('#pelayanan').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      if( status_reg == 'I2' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').hide();
      }else if( status_reg == 'I3' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').show();
      }else{
        $('.status-tgl-masuk').hide();
        $('.status-tgl-keluar').hide();
      }
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
          $('select[name="status_reg"]').val(status_reg).trigger('change');
          $('input[name="tgl_registrasi"]').val(tgl_registrasi);
        }
      });
    }

    function pindahkanTgl(registrasi_id,pasien_id) {
      $('input[name="regis_old"]').val()
      $('input[name="pasien_pindahan"]').val()
      $('input[name="pasien_pindahan"]').val()

      $('#pindahkanTgl').modal('show');
      $('.modal-title').text('Pindahkan tindakan ke tgl');

      $('input[name="regis_old"]').val(registrasi_id)
      $('input[name="pasien_pindahan"]').val(pasien_id)
      console.log(registrasi_id,pasien_id);
      return
      // $.ajax({
      //   url: '/get-data-registrasi/'+registrasi_id,
      //   type: 'GET',
      //   dataType: 'json',
      //   success: function (data) {
      //     $('.status').html(data.status_reg)
      //     $('input[name="registrasi_id"]').val(data.registrasi_id)
      //     $('select[name="status_reg"]').val(status_reg);
      //     $('input[name="tgl_registrasi"]').val(tgl_registrasi);
      //   }
      // });
    }
    function popupWindow(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
      return false;
    }
    function ubahPelayananInap(registrasi_id,status_reg,tgl_registrasi,tgl_masuk){
      $('#pelayanan').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      if( status_reg == 'I2' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').hide();
      }else if( status_reg == 'I3' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').show();
      }else{
        $('.status-tgl-masuk').hide();
        $('.status-tgl-keluar').hide();
      }
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
          $('select[name="status_reg"]').val(status_reg);
          $('input[name="tgl_registrasi"]').val(tgl_registrasi);
          $('input[name="tgl_masuk_inap"]').val(tgl_masuk);
        }
      });
    }

    function ubahPelayananPulangkan(registrasi_id,status_reg,tgl_registrasi,tgl_masuk,tgl_keluar){
      $('#pelayanan').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      if( status_reg == 'I2' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').hide();
      }else if( status_reg == 'I3' ){
        $('.status-tgl-masuk').show();
        $('.status-tgl-keluar').show();
      }else{
        $('.status-tgl-masuk').hide();
        $('.status-tgl-keluar').hide();
      }
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
          $('select[name="status_reg"]').val(status_reg);
          $('input[name="tgl_registrasi"]').val(tgl_registrasi);
          $('input[name="tgl_masuk_inap"]').val(tgl_masuk);
          $('input[name="tgl_keluar_inap"]').val(tgl_keluar);
        }
      });
    }

     function ubahPelayananbeluminap(registrasi_id) {
      $('#pelayananbeluminap').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
        }
      });
    }

    function simpanStatus() {
      $('#pelayanan').modal('hide');
      $.ajax({
        url: '/ubah-status-pelayanan',
        type: 'POST',
        dataType: 'json',
        data: $('#formStatus2').serialize(),
        success: function (data) {
          if (data.sukses == true) {
            window.location.href = '/frontoffice/histori-pasien/'+data.pasien_id;
          }
        },
        error: function(error){
          console.log(error.error);
          alert('Data Rawat Inap tidak ada !');
        }
      });

    }


    function simpanHistori() {
      $.ajax({
        url: '/ubah-status-pelayanan',
        type: 'POST',
        dataType: 'json',
        data: $('#formStatus').serialize(),
        success: function (data) {
          if (data.sukses == true) {
            window.location.href = '/frontoffice/histori-pasien/'+data.pasien_id;
          }
        }
      });

    }

    // View History By App Kanza
    function searchHistoryPasien(no_rm){
    //alert(no_rm)
    $('#pasien').modal({backdrop: 'static', keybord: false});
    $('.modal-title').text('History RM')
    var table;
    table = $('#tablePasien').DataTable({
      
      pageLength  : 20,
      paging      : true,
      lengthChange: false,
      searching   : true,
      ordering    : false,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax: '/frontoffice/search-pasien-kanza/'+no_rm,
      columns: [
          {data: 'reg'},
          {data: 'status'},
          {data: 'dokter'},
          {data: 'poli'},
          {data: 'carabayar'}
      ]
    });
  }


  </script>
  @endsection