@extends('master')
@section('header')
<h1>Laporan Klaim Berkas VClaim BPJS Kesehatan<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'id' => 'formKlaim','url' => 'bridgingsep/data-klaim/pdf',
    'class'=>'form-hosizontal']) !!}
    <div class="row">
      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Tanggal Pulang</button>
          </span>
          {!! Form::text('tgl_pulang', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Jenis Pelayanan</button>
          </span>
          <select name="jenis_pelayanan" class="form-control select2" style="width: 100%">
            <option value="2">Rawat Jalan</option>
            <option value="1">Rawat Inap</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Status Klaim</button>
          </span>
          <select name="status" class="form-control select2" style="width: 100%">
            <option value="1">Proses Verifikasi</option>
            <option value="2">Pending Verifikasi</option>
            <option value="3">Klaim</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <button type="button" onclick="viewDocument()" class="btn btn-primary btn-flat">VIEW</button>
        <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-excel-o" value="CETAK"
          formtarget="_blank">
      </div>
    </div>
    {!! Form::close() !!}
    <hr>
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead class="bg-primary">
          <tr class="text-center">
            <th class="text-center" style="vertical-align: middle;">No</th>
            <th class="text-center" style="vertical-align: middle;">Nama</th>
            <th class="text-center" style="vertical-align: middle;">No RM</th>
            <th class="text-center" style="vertical-align: middle;">Nomer SEP</th>
            <th class="text-center" style="vertical-align: middle;">Poli</th>
            <th class="text-center" style="vertical-align: middle;">Tanggal SEP</th>
            <th class="text-center" style="vertical-align: middle;">Tanggal Pulang</th>
            <th class="text-center" style="vertical-align: middle;">Kode Grouper</th>
            <th class="text-center" style="vertical-align: middle;">Biaya Pengajuan</th>
            <th class="text-center" style="vertical-align: middle;">Biaya Disetujui</th>
            <th class="text-center" style="vertical-align: middle;">Tarif Grouper</th>
            <th class="text-center" style="vertical-align: middle;">Tarif Topup</th>
            <th class="text-center" style="vertical-align: middle;">Tarif Rs</th>
            <th class="text-center" style="vertical-align: middle;">Selisih</th>
            <th class="text-center" style="vertical-align: middle;">Status</th>
            <th class="text-center" style="vertical-align: middle;">Kelas Rawat</th>
          </tr>
        </thead>
        <tbody id="viewKlaim">

        </tbody>
        <tfoot class="bg-gray">
          <tr>
            <th colspan="8" class="text-right">TOTAL</th>
            <th id="totalPengajuan" class="text-right"></th>
            <th id="totalDisetujui" class="text-right"></th>
            <th id="totalGruper" class="text-right"></th>
            <th id="totalTopup" class="text-right"></th>
            <th id="totalRS" class="text-right"></th>
            <th id="totalSelisih" class="text-right"></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <div class="overlay hidden">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
  <div class="box-footer">
  </div>
</div>

@endsection
@section('script')
<script>
  $('.select2').select2();

      function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function viewDocument() {
        var data = $('#formKlaim').serialize()
        $('.overlay').removeClass('hidden')
        $.ajax({
          url: '/bridgingsep/data-klaim',
          type: 'POST',
          dataType: 'json',
          data: data,
        })
        .done(function(data) {
          resp = JSON.parse(data)
          // console.log(resp)
          $('.overlay').addClass('hidden')
          $('#viewKlaim').empty()
          if (resp[0].metaData.code == 200) {
            var total_pengajuan = 0
            var total_disetujui = 0
            var total_gruper = 0
            var total_topup = 0
            var total_rs = 0
            var total_selisih = 0
            $.each(resp[1].klaim, function(index, val) {
              var selisih = parseInt(val.biaya.byTopup) + parseInt(val.biaya.byTarifGruper) -  parseInt(val.biaya.byTarifRS);
              var css_class = selisih > 0 ? 'text-right text-success' : 'text-right text-danger';

              $('#viewKlaim').append('<tr> <td>'+(index+1)+'</td> <td>'+val.peserta.nama+'</td> <td>'+val.peserta.noMR+'</td> <td>'+val.noSEP+'</td> <td>'+val.poli+'</td> <td>'+val.tglSep+'</td> <td>'+val.tglPulang+'</td> <td>'+val.Inacbg.kode+'</td> <td class="text-right">'+ribuan(val.biaya.byPengajuan)+'</td> <td class="text-right">'+ribuan(val.biaya.bySetujui)+'</td> <td class="text-right">'+ribuan(val.biaya.byTarifGruper)+'</td> <td class="text-right">'+ribuan(val.biaya.byTopup)+'</td> <td class="text-right">'+ribuan(val.biaya.byTarifRS)+'</td> <th class="'+css_class+'">'+ribuan(selisih)+'</th> <td>'+val.status+'</td>  <td>'+val.kelasRawat+'</td> <td>')

              total_pengajuan += parseInt(val.biaya.byPengajuan) 
              total_disetujui += parseInt(val.biaya.bySetujui)
              total_gruper += parseInt(val.biaya.byTarifGruper)
              total_topup += parseInt(val.biaya.byTopup)
              total_rs += parseInt(val.biaya.byTarifRS)
              total_selisih += selisih
            });

            var class_totalSelisih = total_selisih > 0 ? 'text-right text-success' : 'text-right text-danger';
            
            $('#totalPengajuan').text(ribuan(total_pengajuan))
            $('#totalDisetujui').text(ribuan(total_disetujui))
            $('#totalGruper').text(ribuan(total_gruper))
            $('#totalTopup').text(ribuan(total_topup))
            $('#totalRS').text(ribuan(total_rs))
            $('#totalSelisih').addClass(class_totalSelisih)
            $('#totalSelisih').text(ribuan(total_selisih))
          }
          if (resp[0].metaData.code == 201) {
            alert(resp[0].metaData.message)
          }
        });
      }
</script>
@endsection