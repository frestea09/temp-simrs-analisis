@extends('master')

@section('header')
  <h1>Logistik  &nbsp;
    <a href="{{ route('penerimaan.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
  </h1>
@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
              Cari PO berdasarkan Tanggal:
        </h3>
      </div>

        <div class="box-body">
        <form method="POST" action="{{ url('logistikmedik/penerimaan/') }}" class="form-horizontal">
          {{ csrf_field() }}
          <div class="row">
              <div class="col-sm-6">
               <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                    </span>
                    {!! Form::text('tga', !empty(session('tga')) ? session('tga') : NULL , ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
              </div>

              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">s/d Tanggal</button>
                  </span>
                    {!! Form::text('tgb',   !empty(session('tga')) ? session('tga') : NULL  , ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                </div>
              </div>
              <hr>
              <div class="col-md-6">
                <div class="input-group">
                   {{-- <label for="submit" class="col-sm-2 control-label">&nbsp;</label> --}}
                     <button type="submit" class="btn btn-primary btn-flat">CARI</button>
               </div>
              </div>
            </div>
          </form>
          </div>
        </div>
    </div>
    <div class="col-sm-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
              Cari PO berdasarkan Nomor PO:
          </h3>
        </div>
          <div class="box-body">
          <form method="POST" action="{{ url('logistikmedik/penerimaan/') }}" class="form-horizontal">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group">
                  <label for="no_po" class="col-sm-2 control-label">No. PO</label>
                  <div class="col-sm-9">
                    <input type="text" value="{{ !empty(session('no_po')) ? session('no_po') : NULL }}" name="no_po" class="form-control">
                  </div>
                </div>
              <div class="col-md-6">
                <div class="input-group">
                   {{-- <label for="submit" class="col-sm-2 control-label">&nbsp;</label> --}}
                     <button type="submit" class="btn btn-primary btn-flat">CARI</button>
               </div>
              </div>
            </div>
          </form>
          </div>
      </div>
    </div>
</div>



  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Penerimaan Barang
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">          
            <table class="table">
                <thead class="bg-danger">
                  <tr>
                    <th>No</th>
                    <th>No. SP</th>
                    <th>Supplier</th>
                    <th>Tanggal SP</th>
                    <th>Petugas</th>
                    <th>Diskon</th>
                    @role(['po','pphp'])
                    <th>Terima</th>
                    @endrole
                    @role(['penerimaanpo'])
                    <th>Detail</th>
                    @endrole
                  </tr>
                </thead>
              <tbody>
                  @if (!empty($data))
                    @foreach ($data as $d)
                      @php
                        $awal = new DateTime($d->tanggal);
                        $today = new DateTime();
                        $po = \App\Logistik\Po::where('no_po',$d->no_po)->first();
                        $noPO = \App\NoPo::where('no_po',$d->no_po)->first();
                        $tempo = $today->diff($awal)->format("%a");
                        if(!empty($noPO)){
                          $id = $noPO->id;
                        } else {
                          $id = noPo($d->no_po);
                        }
                        $spk = \App\Logistik\LogistikSpk::where('no_po', $d->no_po)->first();
                        $penerimaan = \App\Logistik\LogistikPenerimaan::where('no_po', 'LIKE', '%' . $d->no_po . '%')->get()
                      @endphp
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->no_po }}</td>
                        <td>{{ $po->supplier }}</td>
                        <td>{{ $po->tanggal }}</td>
                        <td>{{ $po->user }}</td>
                        <td>{{ @$po->diskon_persen }}%</td>
                        @role(['po','pphp'])
                        <td>
                          @if ( \App\Logistik\Logistik_BAPB::where('no_po', $d->no_po)->count() > 0)
                            <a href="#" title="Terima Obat dari Supllier oleh Petugas Gudang" class="btn btn-default btn-md" disabled>Terima Dari Supplier</a>
                            @else
                            <a href="{{ url('logistikmedik/penerimaan/list-berita-acara/'.$po->id) }}" title="Terima Obat dari Supllier oleh Petugas Gudang" class="btn btn-success btn-md">Terima Dari Supplier</a>
                          @endif
                        </td>
                        @endrole
                        @role(['penerimaanpo'])
                        <td>
                            <a href="{{ url('logistikmedik/penerimaan/add-penerimaan/'.$id) }}" title="Masukkan Obat ke Stok Gudang" class="btn btn-primary btn-sm">MASUKKAN KE GUDANG</a>
                        </td>
                        @endrole
                      </tr>
                    @endforeach
                  @endif  
              </tbody>
            </table>
            </div>
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
                  <input type="text" readonly name="nomor" class="form-control">
                  <span class="textError nomorError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="nama" class="col-sm-3 control-label">Nama Pt</label>
                <div class="col-sm-5">
                  <input type="text" readonly name="nama" class="form-control">
                  <span class="textError namaError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="nama_jabatan" class="col-sm-3 control-label">Nama Penjabat</label>
                <div class="col-sm-5">
                  <input type="text" readonly name="nama_jabatan" class="form-control">
                  <span class="textError nama_jabatanError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="jabatan" class="col-sm-3 control-label">jabatan</label>
                <div class="col-sm-5">
                  <input type="text" readonly name="jabatan" class="form-control">
                  <span class="textError jabatanError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">alamat</label>
                <div class="col-sm-9">
                  <input type="text" readonly name="alamat" class="form-control">
                  <span class="textError alamatError"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Mengerjakan</label>
                <div class="col-sm-9">
                  <textarea name="mengerjakan" class="form-control wysiwyg">
                    Pengadaan
                  </textarea>
                   {{--  <input type="text" name="mengerjakan" class="form-control wysiwyg">  --}}
                </div>
              </div>
              <div class="form-group">
                <label for="Terbilang" class="col-sm-3 control-label">Terbilang</label>
                <div class="col-sm-9">
                  <input type="text" name="terbilang" class="form-control">
                  <span class="textError terbilangError"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Waktu Pelaksanaan</label>
                <div class="col-sm-2">
                  <input type="text" readonly name="waktu_pelaksanaan" class="form-control">
                </div>
                <div class="col-sm-2">
                  <input type="text" readonly name="hari" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Terhitung mulai Tanggal</label>
                <div class="col-sm-9">
                  <input type="text" readonly name="mulai_tanggal" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Sampai dengan Tanggal</label>
                <div class="col-sm-9">
                  <input type="text" readonly name="sampai_tanggal" class="form-control datepicker">
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-sm-3 control-label">Beban Anggaran</label>
                <div class="col-sm-9">
                  <select name="anggaran" class="form-control select2" style="width : 100%">
                    @foreach (\App\Logistik\LogistikPengirimPenerima::all() as $d)
                      <option value="{{ $d->departemen }}">{{ $d->departemen }} || {{ $d->nama }}</option>
                    @endforeach
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
                  <input type="text" name="tahun_anggaran" class="form-control">
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
              {{-- <div class="form-group">
                <label for="pembayarana_pertama" class="col-sm-3 control-label">Pembayaran Pertama</label>
                <div class="col-sm-9">
                  <input type="text" name="pembayarana_pertama" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="pembayarana_kedua" class="col-sm-3 control-label">Pembayaran Kedua</label>
                <div class="col-sm-9">
                  <input type="text" name="pembayarana_kedua" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="pembayarana_ketiga" class="col-sm-3 control-label">Pembayaran Ketiga</label>
                <div class="col-sm-9">
                  <input type="text" name="pembayarana_ketiga" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="pembayarana_keempat" class="col-sm-3 control-label">Pembayaran Keempat</label>
                <div class="col-sm-9">
                  <input type="text" name="pembayarana_keempat" class="form-control">
                </div>
              </div> --}}
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-flat" onclick="saveSpk()">Simpan</button>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-horizontal" id="formEditSpk">
          {{ csrf_field() }}
        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <tbody>
              <tr>
                <th>No Faktur</th> 
                <td>
                  <input type="text" name="masterobat_id" value="">
                  <input type="text" name="no_faktur" value="">
                </td>
              </tr>
              <tr>
                <th>Hpp</th> 
                <td>
                  <input type="text" name="hpp" value="">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-flat" onclick="saveEditJumlah()">Simpan</button>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>


@endsection

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2();

    function number_format (number, decimals, dec_point, thousands_sep) {
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

    CKEDITOR.replace('mengerjakan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function getPO() {
      $.ajax({
        url: '/logistikmedik/penerimaan/get-po',
        type: 'POST',
        dataType: 'json',
        data: {
          '_token': $('input[name="_token"]').val(),
          'tga' : $('input[name="tga"]').val(),
          'tgb' : $('input[name="tgb"]').val(),
          'no_po' : $('input[name="no_po"]').val()
        },
      })
      .done(function(json) {
        $('#viewPO').empty()
        $.each(json, function(index, val) {
           $('#viewPO').append('<tr> <td>'+(index+1)+'</td> <td>'+val.no_po+'</td> <td>'+val.supplier+'</td> <td>'+val.tanggal+'</td> <td>'+val.user+'</td> <td> <a href="{{ url('logistikmedik/penerimaan/detail-po/') }}/'+val.no_po+'" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-folder-open"></i></a> </td> </tr>')
        });
      });
    }

    function spk(id) {
      $('#ModalSpk').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $("#formSpk")[0].reset()
      $('input[name="id"]').val(id)
      $('.modal-title').text('Form SPK')
      $.ajax({
        url: '/logistikmedik/periksa/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        CKEDITOR.instances['mengerjakan'].setData(data.verif.jenis_pengadaan)
        $('input[name="id"]').val(data.listSpk.id)
        $('input[name="no_po"]').val(data.listSpk.no_po)
        $('input[name="nomor"]').val(data.nomor)
        $('input[name="nama"]').val(data.listSpk.nama)
        $('input[name="nama_jabatan"]').val(data.listSpk.nama_jabatan)
        $('input[name="jabatan"]').val(data.listSpk.jabatan)
        $('input[name="alamat"]').val(data.listSpk.alamat)
        $('input[name="terbilang"]').val(data.terbilangtotalpenerimaan)
        $('input[name="waktu_pelaksanaan"]').val(data.listSpk.waktu_pelaksanaan)
        $('input[name="hari"]').val(data.listSpk.waktu_hari)
        $('input[name="mulai_tanggal"]').val(data.listSpk.mulai_tanggal)
        $('input[name="sampai_tanggal"]').val(data.listSpk.sampai_tanggal)
        $('input[name="kode_rekening"]').val(data.listSpk.kode_rekening)
        /*$('input[name="pembayarana_pertama"]').val(data.listpenerimaan)
        $('input[name="pembayarana_kedua"]').val(data.listSpk.pembayarana_kedua)
        $('input[name="pembayarana_ketiga"]').val(data.listSpk.pembayarana_ketiga)
        $('input[name="pembayarana_keempat"]').val(data.listSpk.pembayarana_keempat)*/
        $('input[name="total_faktur"]').val(number_format(data.totalpenerimaan))
        $('input[name="tahun_anggaran"]').val(data.listSpk.tahun_anggaran)
        $('.listPenerimaan').empty()
        $.each(data.listpenerimaan, function(index, val) {
          $('.listPenerimaan').append('<tr>'+'<td>'+val.no_faktur+'</td>'+'<td style="width:20%">'+number_format(val.hpp)+' <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="editJumlah('+val.no_faktur+','+val.masterobat_id+')"><i class="fa fa-edit"></i></button></td>'+'</tr>')
        });
      })
    }

    function editJumlah(no_faktur, masterobat_id) {
      $('#editModal').modal('show')
      $('.modal-title').text('Input Jumlah')
      $("#formSpk")[0].reset()
      $.ajax({
        url: '/logistikmedik/edit-spk-jumlah/'+no_faktur+'/'+masterobat_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="masterobat_id"]').val(data.penerimaan.masterobat_id)
        $('input[name="no_faktur"]').val(data.penerimaan.no_faktur)
        $('input[name="hpp"]').val(data.penerimaan.hpp)
      })
      .fail(function() {

      });
    }

    function saveEditJumlah() {
      var data = $('#formEditSpk').serialize()
      var masterobat_id = $('input[name="masterobat_id"]').val()
      var no_faktur = $('input[name="no_faktur"]').val()

      $.ajax({
        url: '/logistikmedik/save-edit-jumlah',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $("#formEditSpk")[0].reset()
          location.reload();
          alert('Berhasil Diedit!!')
        }
      });
    }

    function berita(id) {
      $('#ModalBerita').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $("#formBerita")[0].reset()
      $('input[name="id"]').val()
      $.ajax({
        url: '/logistikmedik/periksa/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('.modal-title').text('Form Berita Acara '+data.verif.no_po+'')
        $('input[name="no_faktur"]').val(data.bapb.no_faktur)
        $('input[name="tanggal_faktur"]').val(data.bapb.tanggal_faktur)
        $('input[name="suplier"]').val(data.verif.supplier)
        $('input[name="nomor"]').val(data.nomorbapb)
        $('input[name="no_po"]').val(data.verif.no_po)
        $('.listPo').empty()
        $.each(data.penerimaan, function(index, val) {
          $('.listPo').append('<tr>'+'<td><input type="text" name="nama[]" value="'+val.nama+'" class="form-control" readonly><input type="hidden" name="item[]" value="'+val.nama+'"></td>'+'<td><input type="text" name="satuan[]" value="'+val.nama_satuan+'" class="form-control" readonly></td>'+'<td>'+val.nama_satuan+'</td>'+'<td><input type="text" name="jumlah[]" value="'+val.jumlah+'" class="form-control" readonly></td>'+'<td><input type="number" name="kondisi[]" value="'+val.kondisi+'" class="form-control"></td>'+'<td><input type="text" name="keterangan[]" value="'+val.keterangan+'" class="form-control"></td>'+'</tr>')
        });
      })
    }

    function saveBerita() {
      var data = $('#formBerita').serialize()
      var id = $('input[name="id"]').val()

      $.ajax({
        url: '/logistikmedik/bapb',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $("#formBerita")[0].reset()
          location.reload();
          alert('Berita Acara Berhasil Dibuat!!')
        }
        if (resp.sukses == false) {
          alert('Berita Acara Udah Disimpan!!')
        }
      });
    }

    function saveSpk() {
      var data = $('#formSpk').serialize()
      var mengerjakan = CKEDITOR.instances['mengerjakan'].getData();
      var form_data = new FormData($("#formSpk")[0])
      form_data.append('mengerjakan', mengerjakan)
      url = '/logistikmedik/spk-edit'

      $.ajax({
        url: '/logistikmedik/spk-edit',
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
      })
    }

     $('table').DataTable();

</script>
@endsection

