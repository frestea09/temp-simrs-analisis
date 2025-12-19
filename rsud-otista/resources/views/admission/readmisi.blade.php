@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Readmisi&nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/readmisi', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
            </span>
            @if (session('no_rm'))
                
            {!! Form::text('no_rm', session('no_rm'), ['class' => 'form-control', 'required' => 'required']) !!}
            @else
            {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
                
            @endif
          </div>
          </div>
          <div class="col-md-4">
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
          </div>
        </div>
      {!! Form::close() !!}
        <div class='table-responsive'>       
          <table class='table' id="">
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Cara Bayar</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Status</th>
                <th>Rincian Tindakan</th>
                <th>LAB</th>
                <th>RADIOLOGI</th>
                <th>EKG</th>
                <th>OBAT</th>
              </tr>
            </thead>
            <tbody>
                @isset($reg)
                    @foreach ($reg as $key => $d)
                        @php
                            $folio= Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->id)->get();
                        @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ baca_norm($d->pasien_id) }}</td>
                        <td>{{ baca_pasien($d->pasien_id) }}</td>
                        <td>{{ baca_carabayar($d->bayar) }} {{ (!empty($d->tipe_jkn)) ? ' - '.$d->tipe_jkn : '' }}</td>
                        <td>{{ $d->tgl_masuk }}</td>
                        <td>{{ $d->tgl_keluar }}</td>
                        <td>
                            @if (substr($d->status_reg,0,1) == 'J' || $d->status_reg == 'I1')
                                Rawat Jalan
                            @elseif(substr($d->status_reg,0,1) == 'G')
                                Rawat Darurat
                            @else
                                Rawat Inap
                            @endif
                        </td>
                        <td>
                            @foreach ($folio as $f)
                            + {{ $f->namatarif }} <br>
                          @endforeach
                        </td>
                        <td>
                          @if (cek_hasil_lab($d->id) >= 1)
                            <a href="{{ url('pemeriksaanlab/pasien/'.$d->id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
                          @else
                            <i class="fa fa-minus text-danger"></i>
                          @endif
                        </td>
                        <td>
                          @if (cek_ekspertise($d->id) >= 1)
                            <a href="{{ url('radiologi/ekspertise-pasien/'.$d->id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
                          @else
                          <i class="fa fa-minus text-danger"></i>
                          @endif
                        </td>
                        <td>
                          @if (cekEcho($d->id))
                            <a class="btn btn-md btn-default"  target="_blank" href="{{ url('/echocardiogram/cetak-echocardiogram/'.$d->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            @else
                            <i class="fa fa-minus text-danger"></i>
                          @endif
                        </td>
                        <td>
                          @php
                            $penjualan = App\Penjualan::where('registrasi_id', $d->id)->orderBy('created_at', 'asc')->get();
                          @endphp
                          @if ($penjualan->first())
                          <div class="btn-group">
                              <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                              <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                                  <span class="caret"></span>
                                  <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                
                                @foreach ($penjualan as $p)
                                    <li>
                                      {{--  @if($p->created_at <= '2020-04-01 00:00:00')
                                        <a href="{{ url('farmasi/cetak-detail/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                                      @elseif($p->created_at >= '2020-04-01 00:00:00' && $p->created_at < '2020-04-02 15:51:16')
                                        <a href="{{ url('farmasi/cetak-detail-baru/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                                      @else  --}}
                                        <a href="{{ url('farmasi/cetak-detail/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                                      {{--  @endif  --}}
                                    </li>
                                @endforeach
                              </ul>
                          </div>
                          @endif
                        </td>
                    </tr>
                      {{-- {!! Form::close() !!} --}}

                    @endforeach
                    
                @endisset
            </tbody>
          </table>
        </div>
        @isset($reg)
            
        <div class="row">
            {!! Form::open(['method' => 'POST', 'url' => 'proses-readmisi', 'class'=>'form-hosizontal']) !!}
            <input type="hidden" name="no_rm" value="{{ $pasien->no_rm }}">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Readmisi dari Tanggal</label>
                    <select name="dari" class="form-control select2" style="">
                      <option value=""></option>
                      @foreach ($reg as $d)
                        <option value="{{ $d->id }}">{{ date('Y-m-d', strtotime($d->tgl_masuk))  }}</option>
                      @endforeach
                    </select>
                    {{-- <small id="helpId" class="form-text text-muted"></small> --}}
                  </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Ke Tanggal</label>
                    <select name="menuju" class="form-control select2" style="">
                      <option value=""></option>
                      @foreach ($reg as $d)
                        <option value="{{ $d->id }}">{{ date('Y-m-d', strtotime($d->tgl_masuk)) }}</option>
                      @endforeach
                    </select>
                    {{-- <small id="helpId" class="form-text text-muted"></small> --}}
                </div>
                <input type="submit" name="cari" class="btn btn-primary btn-flat" value="Proses">
            </div>
            {!! Form::close() !!}

        </div>
        @endisset
      </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
$('.select2').select2();

</script>
    
@endsection