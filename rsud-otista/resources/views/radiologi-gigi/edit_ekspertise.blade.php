@extends('master')
@section('header')
{{-- <h1>RADIOLOGI<small><a href="{{url('radiologi-gigi/notifikasi')}}" class="btn btn-default" id="tambah"> Kembali </a></small>
</h1> --}}
@endsection
@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h4>RADIOLOGI<small>&nbsp;<a href="{{url('radiologi-gigi/terbilling')}}" class="btn btn-default" id="tambah">Kembali </a></small>
    </h4>
    <div class="box-body">
      <h4 class="text-center">Input Ekspertise</h4>
      <hr style="border-top: 1px solid red;" />
      {{-- <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <tr>
            <td>Nama</td>
            <td></td>
          </tr>
          <tr>
            <td>RM</td>
            <td>{{@$reg->pasien->no_rm}}</td>
          </tr>
          <tr>
            <td>Dokter</td>
            <td>{{baca_dokter(@$reg->dokter_id)}}</td>
          </tr>
          <tr>
            <td>Poli</td>
            <td>
              @php
              $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$reg->id)->orderBy('id','DESC')->first();
              @endphp
              @if ($histori)
              {{baca_poli(@$histori->poli_id)}}
              @else
              {{@$reg->poli->nama}}
              @endif
            </td>
          </tr>
        </table>
      </div> --}}
      <div class="row">
        <div class="col-md-12">
          <form method="POST" class="form-horizontal" id="formEkspertise">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="{{$reg->id}}">
            <input type="hidden" name="ekspertise_id" value="{{$id_eksp}}">

            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Nama Pasien </th>
                    <td class="nama">{{@$reg->pasien->nama}}</td>
                    <th>Jenis Kelamin </th>
                    <td class="jk" colspan="3">{{@$reg->pasien->kelamin}}</td>
                  </tr>
                  <tr>
                    <th>Umur </th>
                    <td class="umur">{{@$umur}}</td>
                    <th>No. RM </th>
                    <td class="no_rm" colspan="3">{{@$reg->pasien->no_rm}}</td>
                  </tr>
                  <tr>
                    <th>Pemeriksaan</th>
                    <td>
                      {{-- <ol class="pemeriksaan"></ol> --}}
                      <div id="tindakanPeriksa">
                        <select class="form-control" name="tindakan_id">
                          <option>Silahkan Pilih</option>
                        @foreach ($tindakan as $key => $val)
                          @php
                              $selected = $key == '0' ? 'selected' : '';
                          @endphp
                          <option data_tgl="{{$val->created_at}}" value="{{$val->id}}" {{$selected}}>{{$val->namatarif}}</option>    
                        @endforeach
                      </select>
                      </div>
                    </td>
                    <th>Tanggal Pemeriksaan </th>
                    <td>
                      {!! Form::text('tglPeriksa', @valid_date(@$radiologi->tglPeriksa), ['class' => 'form-control datepicker ', 'required' =>
                      'required']) !!}
                    </td>
                  </tr>
                  <tr>
                    <th>Dokter Pelaksana</th>
                    <td>
                      <select name="dokter_id" class="form-control select2" style="width: 100%">
                        <option value="">-- Pilih --</option>
                        @foreach ($radiografer as $d)
                        {{-- @foreach (Modules\Pegawai\Entities\Pegawai::all() as $d) --}}
                        <option value="{{ $d->id }}" {{$d->id == $radiologi->dokter_id ? 'selected' : ''}}>{{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </td>
                    <th>Dokter Pengirim</th>
                    <td>
                      <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                        @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                        {{-- @foreach (Modules\Pegawai\Entities\Pegawai::all() as $d) --}}
                        <option value="{{ $d->id }}" {{$d->id == $radiologi->dokter_pengirim ? 'selected' : ''}}>{{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th>-</th>
                    <td>
                      {{-- <input type="text" name="no_dokument" class="form-control"> --}}
                    </td>
                    <th>Tanggal Ekspertise </th>
                    <td colspan="3">
                      {!! Form::text('tanggal_eksp', date('d-m-Y',strtotime($radiologi->tanggal_eksp)), ['class' => 'form-control datepicker ', 'required' =>
                      'required']) !!}
                    </td>
                  </tr>
                  {{-- <tr>
                    <th>Klinis<br/>
                    <i style="font-weight: 400 !important"><small>(dari order radiologi)</small></i></th>
                    <td colspan="3">
                      <textarea name="klinis" class="form-control ckeditor">
                        {{$radiologi->klinis}}
                      </textarea>
                    </td>
                  </tr> --}}
                  <tr>
                    <th>Ekspertise</th>
                    <td colspan="3">
                      <textarea name="ekspertise" class="form-control wysiwyg">
                        {{$radiologi->ekspertise}}
                      </textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <button type="button" class="btn pull-right btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
            <button type="button" onclick="close_window()" class="btn btn-danger">Close/Tutup</button>
            <div class="btn-group">
              <button type="button" class="btn btn-warning">Cetak </button>
              <button type="button" class="btn btn-lg btn-warning dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                @foreach (\App\RadiologiEkspertise::where('registrasi_id', $reg->id)->where('poli_id', poliRadiologiGigi())->get() as $p)
                  <li>
                    <a href="{{ url("radiologi-gigi/cetak-ekpertise/".$p->id."/".$reg->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    {{-- @parent --}}
    <script type="text/javascript">
    $('.select2').select2()
      //CKEDITOR
    CKEDITOR.replace( 'ekspertise', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });
    function close_window() {
      if (confirm("Yakin Akan Tutup Halaman?")) {
        close();
      }
    }
    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      var ekspertise = CKEDITOR.instances['ekspertise'].getData();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('ekspertise', ekspertise)

      $.ajax({
        url: '/radiologi-gigi/ekspertise-baru',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="ekspertise_id"]').val(resp.data.id)
          alert('Ekspertise berhasil disimpan.')
          window.open('/radiologi-gigi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id)
          // window.location.open = '/radiologi-gigi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id
          close();

        }

      });
    }
      
    </script>
@endsection