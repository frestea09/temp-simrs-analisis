@extends('master')

@section('header')
  <h1>Logistik - PO
    <a href="{{ url('logistikmedik/po/create') }}" class="btn btn-success"> <i class="fa fa-icon fa-plus"></i> BUAT PO BARU</a>
  </h1>

@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Daftar PO Terbit
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
          <form action="{{ url('logistikmedik/cari-po') }}" class="form-horizontal" role="form" method="POST">
            {{ csrf_field() }}

          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgl_awal') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tgl_awal', isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : NULL , ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgl_akhir',  isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : NULL , ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
            </div>
          </div>
        </form>
        </div>
        
        <hr>
         <div class="table-responsive">
         <table class="table table-hover table-condensed table-bordered" id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>No. PO</th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th class="text-center">Status</th>
                <th class="text-center">Cetak</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Hapus</th>
              </tr>
            </thead>
            <tbody>
              <form method="post" id="formTutup">
                {{ csrf_field() }}
                @foreach ($po as $d)
                  @php
                      $no_po = \App\Logistik\Po::where('no_po', $d->no_po)->first();
                  @endphp
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>
                       <a href="{{ url('logistikmedik/list-po/'.$no_po->id) }}">
                        <b>{{ $d->no_po }}</b>
                      </a>
                    </td>
                    <td>{{ $no_po->supplier }}</td>
                    <td>{{ $no_po->tanggal }}</td>
                    <td class="text-center">
                      
                      <span class="label label-danger"> <i class="fa fa-icon fa-close"></i> {{ \App\Logistik\Po::where('no_po', $d->no_po)->where('verifikasi','N')->count() }}</span>
                      <span class="label label-success"> <i class="fa fa-icon fa-check"></i>{{ \App\Logistik\Po::where('no_po', $d->no_po)->where('verifikasi','Y')->count() }}</span>
                      <span class="label label-warning"> <i class="fa fa-icon fa-book"></i> {{ \App\Logistik\Po::where('no_po', $d->no_po)->where('verifikasi','B')->count() }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ url('logistikmedik/po-cetak/'.str_replace('/', '_', $d->no_po).'/'.$no_po->tanggal) }}" target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-print"></i></a>
                    </td>
                    <td class="text-center">
                      <a href="{{ url('logistikmedik/po-edit/'.str_replace('/', '_', $d->no_po).'/'.$no_po->tanggal) }}" target="_blank" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></a>
                    </td>
                    <td class="text-center">
                      
                          <a href="{{ url('logistikmedik/po-hapus/'.str_replace('/', '_', $d->no_po).'/'.$no_po->tanggal) }}" class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Yakin transaksi ini akan dihapus ?');" ><i class="fa fa-remove"></i></a>
                       
                    </td>
                  </tr>
                @endforeach
              </form>
              {{-- <tr>
                <td colspan="2">
                    <button type="button" class="btn btn-info btn-flat btn-sm" onclick="closeTransaksi()">Close</button>
                </td>
              </tr> --}}
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <div class="modal fade" id="Modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <form method="POST" id="form">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="id">
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Nama Obat</th>
                      <th>Jumlah</th>
                      <th>Verif</th>
                      <th>Cancel</th>
                      <th>Status Verif</th>
                    </tr>
                  </thead>
                  <tbody class="listPo">
                  </tbody>
                </table>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-flat" onclick="verifikasi()">Verif</button>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ModalSpk" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formSpk" class="form-horizontal">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="id" value="">
              <input type="hidden" name="no_po">
              <input type="hidden" name="supplier_id">
              <div class="form-group">
                <label for="nomor" class="col-sm-3 control-label">nomor</label>
                <div class="col-sm-5">
                  <input type="text" name="nomor" class="form-control">
                  <span class="textError nomorError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="nama" class="col-sm-3 control-label">Nama Pt</label>
                <div class="col-sm-5">
                  <input type="text" name="nama" class="form-control">
                  <span class="textError namaError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="nama_jabatan" class="col-sm-3 control-label">Nama Penjabat</label>
                <div class="col-sm-5">
                  <input type="text" name="nama_jabatan" class="form-control">
                  <span class="textError nama_jabatanError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="jabatan" class="col-sm-3 control-label">jabatan</label>
                <div class="col-sm-5">
                  <input type="text" name="jabatan" class="form-control">
                  <span class="textError jabatanError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">alamat</label>
                <div class="col-sm-9">
                  <input type="text" name="alamat" class="form-control">
                  <span class="textError alamatError"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Mengerjakan</label>
                <div class="col-sm-9">
                  <textarea name="mengerjakan" class="form-control wysiwyg" readonly>
                    
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="Terbilang" class="col-sm-3 control-label">Terbilang</label>
                <div class="col-sm-9">
                  <input type="text" name="terbilang" class="form-control" readonly>
                  <span class="textError terbilangError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Waktu Pelaksanaan</label>
                <div class="col-sm-9">
                  <div class="col-sm-6">
                    <input type="text" name="waktu_pelaksanaan" class="form-control">
                  </div>
                  <div class="col-sm-3">
                    <select name="hari" class="form-control select2">
                      <option value="hari">Hari</option>
                      <option value="bulan">Bulan</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Terhitung mulai Tanggal</label>
                <div class="col-sm-9">
                  <input type="text" name="mulai_tanggal" class="form-control datepicker" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Beban Anggaran</label>
                <div class="col-sm-9">
                  <select name="anggaran" class="form-control select2">
                    <option value="apbd">APBD</option>
                    <option value="blu">BLU</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="kode_rekening" class="col-sm-3 control-label">Kode Rekening</label>
                <div class="col-sm-9">
                  <input type="text" name="kode_rekening" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Tahun Anggaran</label>
                <div class="col-sm-9">
                  <input type="text" name="tahun_anggaran" value="{{ date('Y') }}" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Pembayaran : </label>
                <div class="col-sm-9">
                  <table class="table table-hover table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Faktur</th>
                        <th>Jumlah (Rp.)</th>
                      </tr>
                    </thead>
                    <tbody class="listPenerimaan">
                    </tbody>
                    <tfoot>
                      <tr>
                        <td>Total</td>
                        <td><input type="text" name="total_faktur"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-flat" onclick="saveSpk()">Simpan</button>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
  $('#select-all').click(function(){
    $('input[type="checkbox"]').prop('checked', this.checked);
  });

  $('.select2').select2();

  CKEDITOR.replace('mengerjakan', {
    height: 200,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
  });

  function closeTransaksi(){
    var data = $('#formTutup').serialize();
    $.post('/logistikmedik/close-transaksi', data, function(resp){
       if (resp.sukses == true) {
        location.reload();
      }
    })
  }

  function validasipo(id){
		$.ajax({
			url: '/logistikmedik/verifpphp',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
        alert('Jumlah Berhasil di ubah!!')
        $("#listPo").reload();
			}
		});
  }

  function cencelpo(id){
		$.ajax({
			url: '/logistikmedik/cencel-po',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
        alert('Berhasil di Cencel!!')
			}
		});
  }
  
  function statuspo(id){
   $.ajax({
			url: '/logistikmedik/statuspo',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == true){
				location.reload();
			}
		}); 
  }

  function pemeriksaan(id) {
      $('#Modal').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('input[name="id"]').val(id)
      $("#form")[0].reset()
      $.ajax({
        url: '/logistikmedik/periksa/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('.modal-title').text(data.verif.no_po)
        $('.listPo').empty()
        $.each(data.po, function(index, val) {
          $('.listPo').append('<tr>'+'<td>'+val.nama+'</td>'+'<td style="width:20%"><input type="number" name="jumlah'+val.id+'" value='+val.jumlah+' onchange=edit('+val.id+') class="form-control"></td>'+'<td><input type="checkbox" name="id[]" value='+val.id+'></td>'+'<td><button type="button" onclick=cencelpo('+val.id+') class="btn btn-danger btn-sm btn-flat"> Cancel </button></td>'+'<td class="text-center" style="font-size: large;"><b>'+val.verif_pphp+'</b></td>'+'</tr>')
        });
      })
  }

  function verifikasi(){
    var data = $('#form').serialize();
    $.post('/logistikmedik/verifpphp', data, function(resp){
       if (resp.sukses == true) {
        alert('Verif Berhasil !!')
        location.reload();
      }
    })
  }

  function edit(id){
		$.ajax({
			url: '/logistikmedik/edit-po',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'jumlah': $('input[name="jumlah'+id+'"]').val(),
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
        alert('Jumlah Berhasil di ubah!!')
			}
		});
  }
  
  function number_format (number, decimals, dec_point, thousands_sep) {
      // Strip all characters but numerical ones.
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
      var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function (n, prec) {
              var k = Math.pow(10, prec);
              return '' + Math.round(n * k) / k;
          };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
  }

  function spk(id) {
      $('#ModalSpk').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('input[name="id"]').val(id)
      $('.modal-title').text('Form SPK')
      $.ajax({
        url: '/logistikmedik/periksa/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="no_po"]').val(data.verif.no_po)
        $('input[name="supplier_id"]').val(data.supplier.id)
        $('input[name="nomor"]').val(data.nomor)
        $('input[name="nama"]').val(data.supplier.nama)
        $('input[name="nama_jabatan"]').val(data.supplier.nama_pejabat)
        $('input[name="jabatan"]').val(data.supplier.jabatan)
        $('input[name="alamat"]').val(data.supplier.alamat)
        $('input[name="kode_rekening"]').val(data.verif.kode_rekening)
        $('input[name="mulai_tanggal"]').val(data.verif.tanggal)
        $('input[name="total_faktur"]').val(number_format(data.totalpenerimaan))
        $('.listPenerimaan').empty()
        $.each(data.listpenerimaan, function(index, val) {
          $('.listPenerimaan').append('<tr>'+'<td>'+val.no_faktur+'</td>'+'<td style="width:20%">'+number_format(val.hpp)+'</td>'+'</tr>')
        });
      })
  }
  
  function saveSpk() {
    var data = $('#formSpk').serialize()
    var id = $('input[name="id"]').val()
    var mengerjakan = CKEDITOR.instances['mengerjakan'].getData();
    var form_data = new FormData($("#formSpk")[0])
    form_data.append('mengerjakan', mengerjakan)

    $.ajax({
      url: '/logistikmedik/spk',
      type: 'POST',
      dataType: 'json',
      data: form_data,
      async: false,
      processData: false,
      contentType: false,
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $("#formSpk")[0].reset()
        location.reload();
        alert('Spk Berhasil Dibuat!!')
      }
    });
  }

</script>
@endsection
