@extends('master')
@section('header')
  <h1>Retur Obat Rawat Jalan &amp; Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/retur/rajal', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>

          </div>
        </div>
      {!! Form::close() !!}

       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='dataTable'>
           <thead>
             <tr>
               <th>No</th>
               <th>No. RM</th>
               <th>Nama</th>
               <th>Alamat</th>
               <th>Poli</th>
               <th>Tgl Rawat</th>
               <th>Retur</th>
             </tr>
           </thead>
            <tbody>
            </tbody>
         </table>
       </div>

    </div>
  </div>

{{-- MODAL RETUR --}}
<div class="modal fade" id="modalRetur">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="formRetur">
        {{ csrf_field() }} {{ method_field('POST') }}
        <input type="hidden" name="registrasi_id" value="">
        <input type="hidden" name="cara_bayar_id" value="">
        <input type="hidden" name="pasien_id" value="">
        <input type="hidden" name="dokter_id" value="">
        <input type="hidden" name="poli_id" value="">

        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <tbody>
              <tr>
                <th style="width: 25%">No. RM</th><td class="no_rm"></td>
              </tr>
              <tr>
                <th>Nama Pasien</th><td class="namaPasien"></td>
              </tr>
              <tr>
                <th>Pilih No. Faktur</th>
                <td>
                  <select name="no_faktur" class="form-control select2" style="width: 100%">
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div id="dataDetail"> </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" id="btn-save" class="btn btn-primary btn-flat" onclick="saveRetur()">Simpan</button>
      </div>
    </div>
  </div>
</div>

@endsection



@section('script')
  <script type="text/javascript">
    //SHOW DATA
    var table;
    table = $('#dataTable').DataTable({
      'language': {
          'url': '/json/obat.datatable-language.json',
      },
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: '/retur/dataReturRajalByRequest',
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'no_rm'},
          {data: 'nama'},
          {data: 'alamat'},
          {data: 'poli'},
          {data: 'tanggal'},
          {data: 'edit', searchable: false}
      ]
    });

    //SELECT2
    $('.select2').select2();

    function retur(registrasi_id) {
      $('#modalRetur').modal('show')
      $('.modal-title').text('Retur Penjualan Rawat Jalan')
      $('#dataDetail').empty()
      $.ajax({
        url: '/retur/getdataretur/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        console.log(data);

        $('.no_rm').html(data.pasien.no_rm)
        $('.namaPasien').html(data.pasien.nama)
        $('input[name="registrasi_id"]').val(data.registrasi.id);
        $('input[name="cara_bayar_id"]').val(data.registrasi.bayar);
        $('input[name="dokter_id"]').val(data.registrasi.dokter_id);
        $('input[name="poli_id"]').val(data.registrasi.poli_id);
        $('input[name="pasien_id"]').val(data.pasien.id);
        $('select[name="no_faktur"]').empty()
        $('select[name="no_faktur"]').append('<option value=""></option>')
        $.each(data.penjualan, function(index, val) {
           $('select[name="no_faktur"]').append('<option value="'+val.no_resep+'">'+val.no_resep+'</option>')
        });
      });

      $('select[name="no_faktur"]').change(function(e) {
        e.preventDefault()
        var no_faktur = $('select[name="no_faktur"]').val();
        $('#dataDetail').load('/retur/getPenjualanDetail/'+no_faktur);
      });
    }

    function saveRetur() {
      var data = $('#formRetur').serialize()
      $.ajax({
        url: '/retur/saveRetur',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(data) {
        console.log(data);
        if (data.sukses == true) {
          $('#modalRetur').modal('hide')
          alert(data.message)
        }
        if (data.sukses == false) {
          $('#modalRetur').modal('hide')
          alert(data.message)
        }
      });

    }

    function popitup(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Rajal", 'width=900,height=600,scrollbars=yes');
      return false;
    }


  </script>
@endsection
