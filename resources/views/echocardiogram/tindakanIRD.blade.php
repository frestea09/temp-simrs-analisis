@extends('master')

@section('header')
  <h1>Billing System Echocardiogram - IGD </h1>
@endsection

@section('content')
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
 
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Periode Tanggal &nbsp;
        </h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'echocardiogram/tindakan-ird', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
            </div>
          </div>
          </div>
        {!! Form::close() !!}
        <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>Dokter</th>
                <th>Poli Tujuan</th>
                <th>Cara Bayar</th>
                <th>Echocardiogram</th>
                {{-- <th>Proses</th> --}}
                {{-- <th>Cetak</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                  @php
                    $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
                  @endphp
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $pasien ? $d->pasien->nama : '' }}</td>
                  <td>{{ $pasien ? $d->pasien->no_rm : '' }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="ekspertise({{ $d->id }})"><i class="fa fa-edit"></i></button>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('echocardiogram/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('YAKIN AKAN DIMASUKKAN TINDAKAN? KARENA AKAN MENAMBAH KUNJUNGAN RADIOLOGI')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td> --}}
                  {{-- <td class="text-center">
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->count() > 0)
                      <a href="{{ url('echocardiogram/cetakRincianRad/irj/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal fade" id="echocardiogramModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" id="formEkspertise">
              {{ csrf_field() }}
              <input type="hidden" name="registrasi_id" value="">
              <input type="hidden" name="pasien_id" value="">
              <input type="hidden" name="jenis" value="TG">
              <input type="hidden" name="id" value="">
            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Nama Pasien </th> <td class="nama"></td>
                    <th>Umur </th><td class="umur"></td>
                  </tr>
                  <tr>
                    <th>Jenis Kelamin </th><td class="jk" colspan="1"></td>
                    <th>No. RM </th><td class="no_rm" colspan="2"></td>
                  </tr>
                  {{-- <tr>
                    <th>Fungsi Sistolik LV</th>
                    <td>
                      <select name="fungsi_sistolik" class="form-control select2" style="width: 100%">
                        <option value="baik">Baik</option>
                        <option value="cukup">Cukup</option>
                        <option value="menurun">Menurun</option>
                      </select>
                    </td>
                    <th>Dimensi Ruang Jantung</th>
                    <td>
                      <select name="dimensi_ruang_jantung" class="form-control select2" style="width: 100%">
                        <option value="normal">Normal</option>
                        <option value="la_dilatasi">La dilatasi</option>
                        <option value="lv_dilatasi">Lv dilatasi</option>
                        <option value="ra_dilatasi">Ra dilatasi</option>
                        <option value="rv_dilatasi">Rv dilatasi</option>
                        <option value="semua_dilatasi">semua dilatasi</option>
                      </select>
                    </td>
                  </tr> --}}
                  <tr>
                    <th>Diagnosa Klinis</th>
                    <td colspan="2">
                      <input type="text" name="diagnosa" class="form-control">
                    </td>
                  </tr>
                  <tr>
                    <th>Atrium Kiri</th>
                    <td>
                      <input type="number" name="atrium_kiri" placeholder="Normal : 15-40mm" class="form-control">
                    </td>
                    <th>LVESD</th>
                    <td>
                      <input type="number" name="lvesd" placeholder="26-36" class="form-control">
                    </td>
                  </tr>
                  <tr>
                    <th>LAVI</th>
                    <td>
                      <input type="text" class="form-control" name="global" placeholder="">
                    </td>
                    <th>IVSd</th>
                    <td>
                      <input type="text" class="form-control" name="ivsd" placeholder="">
                    </td>
                  </tr>
                  <tr>
                    <th>Ventrikel Kanan</th>
                    <td>
                      <input type="number" class="form-control" name="ventrikel_kanan" placeholder="<42mm">
                    </td>
                    <th>IVSs</th>
                    <td>
                      <input type="number" class="form-control" name="ivss" placeholder="">
                    </td>
                  </tr>
                  <tr>
                    <th>Aorta</th>
                    <td>
                      <input type="text" class="form-control" name="katup_katup_jantung_aorta" placeholder="Normal : 20-37mm"/>
                    </td>
                    <th>LVEDD</th>
                    <td>
                      <input type="text" class="form-control" name="lvedd" placeholder="Normal : 35-52"/>
                    </td>
                  </tr>
                  <tr>
                    <th>Ejeksi Fraksi</th>
                    <td>
                      <input type="text" class="form-control" name="ejeksi_fraksi" placeholder="Normal : 53-77%"/>
                    </td>
                    <th>PWd</th>
                    <td>
                      <input type="text" class="form-control" name="pwd" placeholder="Normal : 7-11mm"/>
                    </td>
                  </tr>
                  <tr>
                    <th>E/A</th>
                    <td>
                      <input type="text" class="form-control" name="ea" placeholder=""/>
                    </td>
                    <th>PWs</th>
                    <td>
                      <input type="text" class="form-control" name="pws" placeholder=""/>
                    </td>
                  </tr>
                  <tr>
                    <th>E/e</th>
                    <td>
                      <input type="text" class="form-control" name="ee" placeholder=""/>
                    </td>
                    <th>LVMI</th>
                    <td>
                      <input type="text" class="form-control" name="lvmi" placeholder=""/>
                    </td>
                  </tr> 
                  <tr>
                    <th>TAPSE</th>
                    <td>
                      <input type="text" class="form-control" name="tapse" placeholder="Normal : > 17mm"/>
                    </td>
                    <th>rwt</th>
                    <td>
                      <input type="text" class="form-control" name="rwt"/>
                    </td>
                  </tr> 
                  <tr>
                    <th>Catatan Dokter</th>
                    <td colspan="3">
                      <textarea name="catatan_dokter" class="form-control wysiwyg"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <th>Kesimpulan</th>
                    <td colspan="3">
                      <textarea name="kesimpulan" class="form-control wysiwyg"></textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
          </div>
        </div>
      </div>
    </div>


@stop

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

  <script type="text/javascript">
    $('.select2').select2();
    
    CKEDITOR.replace( 'kesimpulan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    //CKEDITOR
    CKEDITOR.replace( 'catatan_dokter', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function ekspertise(id) {
      $('#echocardiogramModal').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Input Echocardiogram')
      $("#formEkspertise")[0].reset()
      CKEDITOR.instances['catatan_dokter'].setData('')
      CKEDITOR.instances['kesimpulan'].setData('')
      $.ajax({
        url: '/echocardiogram/echocardiogram/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('.nama').text(data.reg.pasien.nama)
        $('.no_rm').text(data.reg.pasien.no_rm)
        $('input[name="pasien_id"]').val(data.reg.pasien.id)
        $('.umur').text(data.umur)
        $('.jk').text(data.reg.pasien.kelamin)
        $('input[name="registrasi_id"]').val(data.reg.id)
        $('input[name="jenis"]').val(data.ep.jenis)
        $('input[name="ef"]').val(data.ep.ef)
        $('input[name="diagnosa"]').val(data.ep.diagnosa)
        $('input[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis)
        $('input[name="katup_katup_jantung_aorta"]').val(data.ep.katup_katup_jantung_aorta)
        $('input[name="ventrikel_kanan"]').val(data.ep.ventrikel_kanan)
        $('input[name="ivss"]').val(data.ep.ivss)
        $('input[name="ejeksi_fraksi"]').val(data.ep.ejeksi_fraksi)
        $('input[name="lvedd"]').val(data.ep.lvedd)
        $('input[name="pwd"]').val(data.ep.pwd)
        $('input[name="ea"]').val(data.ep.ea)
        $('input[name="ee"]').val(data.ep.ee)
        $('input[name="lvmi"]').val(data.ep.lvmi)
        $('input[name="pws"]').val(data.ep.pws)
        $('input[name="tapse"]').val(data.ep.tapse)
        $('input[name="rwt"]').val(data.ep.rwt)
        $('input[name="ivsd"]').val(data.ep.ivsd)
        $('input[name="lvesd"]').val(data.ep.lvesd)
        $('input[name="atrium_kiri"]').val(data.ep.atrium_kiri)
        $('input[name="global"]').val(data.ep.global)
        
        $('select[name="fungsi_sistolik_rv"]').val(data.ep.fungsi_sistolik_rv).trigger('change')
        
        
        if (data.ep != '') {
          $('input[name="id"]').val(data.ep.id)
          CKEDITOR.instances['kesimpulan'].setData(data.ep.kesimpulan)
          CKEDITOR.instances['catatan_dokter'].setData(data.ep.catatan_dokter)
        }
      })
      .fail(function() {

      });
    }

    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      var catatan_dokter = CKEDITOR.instances['catatan_dokter'].getData();
      var kesimpulan = CKEDITOR.instances['kesimpulan'].getData();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('catatan_dokter', catatan_dokter)
      form_data.append('kesimpulan', kesimpulan)

      $.ajax({
        url: '/echocardiogram/echocardiogram',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="id"]').val(resp.data.id)
          alert('Echocardiogram berhasil disimpan.')
          window.location.reload();
        }

      });
    }

    // $('select[name="katup_katup_jantung_aorta"]').on('change', function () {
    //     if ($(this).val() == '2_cuspis') {
    //       $('#katup_katup_jantung').removeClass('hide');
    //     } else if ($(this).val() == '3_cuspis') {
    //       $('#katup_katup_jantung').removeClass('hide');
    //     } else {
    //       $('#katup_katup_jantung').addClass('hide');
    //     }
    // });
  </script>
@endsection
