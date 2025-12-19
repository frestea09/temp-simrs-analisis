@extends('master')

@section('header')
  <h1>Kasir Rawat Inap - Cetak Ulang <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kasir/cetakIRNA', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()','autocomplete'=>'off']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>JK</th>
              <th>Cara Bayar</th>
              <th>Tanggal Pulang</th>
              <th class="text-center">Kwitansi</th>
              <th class="text-center">Kwi. Penunjang</th>
              {{-- <th class="text-center">Kwitansi Non Jasa Racik</th> --}}
              <th class="text-center">SIP</th>
              <th class="text-center">Surat Pulang Paksa</th>
              <th class="text-center">Rincian Biaya</th>
              {{-- <th class="text-center">Rincian Biaya Non Jasa Racik</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($pemb as $key => $d)
              @php
                $bayar = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
              @endphp
              @if (!empty($d->pasien_id))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->nama : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->kelamin : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $bayar->bayars->carabayar : '' }} {{ !empty($bayar->tipe_jkn) ? ' - '.$bayar->tipe_jkn : '' }}</td>
                  <td>{{@$d->tgl_keluar ? date('d-m-Y', strtotime(@$d->tgl_keluar)) : '' }}</td>
                  <td class="text-center">
                    <a href="{{ url('kasir/cetak/cetakkuitansiirna/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  <td class="text-left">
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="color:white !important">
                        {{-- @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p) --}}
                          <li>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-rad/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Radiologi </a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-lab/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Laboratorium </a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-usg/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> USG</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-citologi/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Citologi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-biopsi/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Biopsi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-fnab/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>Fnab</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-operasi/".$d->registrasi_id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Operasi</a>
                          </li>
                        {{-- @endforeach --}}
                      </ul>
                    </div>
                    {{-- <a href="{{ url('kasir/cetakkuitansi-blumlunas/'.$d->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a> --}}
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/cetak/cetakkuitansinonjasaracik/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                  <td class="text-center">
                    @if ($d->registrasis->keterangan_sip == NULL)
                      <a id="btn-buatSIP" href="#modalBuatSIP{{ $d->registrasi_id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-id="{{ $d->registrasi_id }}">Buat SIP</a>
                    @else
                      <a href="{{ url('tindakan/cetak-sip/'.$d->registrasi_id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                    @endif
                  </td>
                  <td class="text-center">
                    {{-- @if ($bayar->kondisi_akhir_pasien == 3) --}}
                    <a href="{{ url('kasir/cetak-surat-pulang-paksa/'. $d->registrasi_id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                    {{-- @else
                    -
                    @endif --}}
                  </td>
                  <td class="text-center">
                    {{-- <a href="{{ url('kasir/rincian-biaya/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a> --}}
                    <a href="{{ url('/ranap-informasi-rincian-biaya/'.$d->registrasi_id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/rincian-biaya-non-jasa/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                </tr>

                <!-- Modal Buat SIP-->
                <div class="modal fade" id="modalBuatSIP{{ $d->registrasi_id }}" role="dialog" aria-labelledby="" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="">Masukkan Keterangan</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">
                                <form method="POST" id="formBuatSIP" class="form-horizontal">
                                  {{ csrf_field() }}
                                  {{ method_field('POST') }}
                                  <input type="hidden" name="regId" id="regId{{ $d->registrasi_id }}" value="{{ $d->registrasi_id }}">
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <label for="">Keterangan</label>
                                      <br>
                                      <select name="keteranganSipModal" id="keteranganSipModal{{ $d->registrasi_id }}" class="form-control" required>
                                        <option value="SEP DAN RINCIAN DI RUANGAN">SEP DAN RINCIAN DI RUANGAN</option>
                                        <option value="SEP DAN RINCIAN DI KASIR">SEP DAN RINCIAN DI KASIR</option>
                                        <option value="LUNAS PEMBAYARAN">LUNAS PEMBAYARAN</option>
                                        <option value="PERJANJIAN PASIEN">PERJANJIAN PASIEN</option>
                                        <option value="PULANG ATAS PERMINTAAN SENDIRI (APS)">PULANG ATAS PERMINTAAN SENDIRI (APS)</option>
                                        <option value="MENINGGAL DUNIA">MENINGGAL DUNIA</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-sm-12" style="text-align: right">
                                        <button id="btn-save-resep-modal" class="btn btn-primary" type="button" onclick="buatSIP({{ $d->registrasi_id }})" >Buat SIP</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <!-- End Modal Buat SIP-->
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
@section('script')
    <script type="text/javascript">

      function buatSIP(registrasi_id){
        var regId = registrasi_id;
        var keterangan = $('#keteranganSipModal'+registrasi_id).val();

        let dataForm = {
          "regId" : regId,
          "keterangan" : keterangan,
          "_token" : $('input[name=_token]').val(),
        };

        // console.log(dataForm);
        $.ajax({
          url: "/kasir/buat-sip",
          method: 'POST',
          dataType: 'json',
          data: dataForm,
        }).done(function(resp){
          if(resp.sukses == true){
            alert(resp.text);
            location.reload(true);
          }else{
            alert(resp.text);
          }
        });
      }
    </script>
@endsection
