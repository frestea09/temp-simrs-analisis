@extends('master')
@section('header')
  <h1>Informasi Rawat Inap<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <div class="row">
            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                            type="button">Status Pasien</button>
                    </span>
                    <select id="status_pasien" class="chosen-select">
                      <option value="" selected>Rawat Inap</option>
                      <option value="dipulangkan">Dipulangkan</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
            </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                      type="button">Tanggal Masuk</button>
              </span>
              {!! Form::text('tga', date('d-m-Y'), [
                  'class' => 'form-control datepicker',
                  'required' => 'required',
                  'autocomplete' => 'off',
                  'id' => 'tga'
              ]) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-4">
            <div class="input-group {{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                    <button class="btn btn-default {{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">Sampai Tanggal</button>
                </span>
                {!! Form::text('tgb', date('d-m-Y'), [
                    'class' => 'form-control datepicker',
                    'required' => 'required',
                    'onchange' => 'this.form.submit()',
                    'autocomplete' => 'off',
                    'id' => 'tgb'
                ]) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="filterData()">Cari</button>
                </span>
            </div>
        </div>
      </div>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table id="dataIrna" class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center" style="vertical-align: middle;">#</th>
                <th class="text-center" style="vertical-align: middle;">No. RM</th>
                <th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
                <th class="text-center" style="vertical-align: middle;">Alamat</th>
                <th class="text-center" style="vertical-align: middle;">Tanggal Masuk</th>
                <th class="text-center" style="vertical-align: middle;">Asal Pasien</th>
                <th class="text-center" style="vertical-align: middle;">Kelas</th>
                <th class="text-center" style="vertical-align: middle;">Ruangan</th>
                <th class="text-center" style="vertical-align: middle;">Bed</th>
                <th class="text-center" style="vertical-align: middle;">DPJP</th>
                <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
                <th class="text-center" style="vertical-align: middle;">RB</th>
                <th class="text-center" style="vertical-align: middle;">View</th>
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>


    </div>
  </div>

  <div class="modal fade" id="detailIrna" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <table class="table table-condensed table-bordered">
                <body>
                   <input type="hidden" id="id_ranap">
                    <tr>
                        <th>No. RM</th> <td id="no_rm"></td>
                    </tr>
                    <tr>
                        <th>Nama</th> <td id="nama"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th> <td id="alamat"></td>
                    </tr>
                    <tr>
                        <th>Tgl masuk</th> <td id="tgl_masuk"></td>
                    </tr>
                    <tr>
                        <th>Asal Pasien</th> <td id="poli"></td>
                    </tr>
                    <tr>
                        <th>Cara Bayar</th> <td id="carabayar"></td>
                    </tr>
                    <tr>
                        <th>Dokter</th> <td id="dokter"></td>
                    </tr>
                    <tr>
                        <th>Kelas</th> <td id="kelas"></td>
                    </tr>
                    <tr>
                        <th>kamar</th> <td id="kamar"></td>
                    </tr>
                    <tr>
                        <th>Bed</th> <td id="bed"></td>
                    </tr>
                    <tr>
                      <th>Keterangan</th> <td><input type="text" class="form-control" id="keterangan" onchange="editKeterangan()"></td>
                  </tr>
                    <tr>
                        <th>Diagnosa</th> <td id="diagnosa"></td>
                    </tr>
                </body>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <div class="rincian_biaya">
            </div>
            
            <br/>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tindakan</th>
                  {{--<th>Waktu Entry Tindakan</th>--}}
                  <th>Jenis Pelayanan</th>
                  <th>Biaya</th>
                </tr>
              </thead>
              <tbody class="tagihan">
              </tbody>
              <tfoot>
                <tr>
                  <th class="text-center" colspan="2">
                    <div class="rincian_biaya">
  
                    </div>
                  </th>
                  <th class="text-right">Total Tagihan Seluruh</th>
                  <th class="text-right totalTagihan"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('script')
    <script type="text/javascript">
    //SHOW DATA
    var table;
    table = $('#dataIrna').DataTable({
        "language": {
            "url": "json/pasien.datatable-language.json",
        },

      paging      : true,
      iDisplayLength : 25,
      lengthChange: true,
      searching   : true,
      ordering    : true,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax: '/data-rawat-inap',
      fnCreatedRow: function (row, data, index) {
			$('td', row).eq(0).html(index + 1);
        },
      columns: [
          {data: 'nomor'},
          {data: 'no_rm'},
          {data: 'nama'},
          {data: 'alamat'},
          {data: 'waktu'},
          {data: 'poli'},
          {data: 'kelas'},
          {data: 'bangsal'},
          {data: 'bed'},
          {data: 'dpjp'},
          {data: 'carabayar'},
          {data: 'rb'},
          {data: 'view'},
      ]
    });

    // FILTER
    function filterData() {
      let status = $('#status_pasien').val();
      let tga = $('#tga').val();
      let tgb = $('#tgb').val();
      table.clear().destroy();

      table = $('#dataIrna').DataTable({
          "language": {
              "url": "json/pasien.datatable-language.json",
          },

        paging      : true,
        iDisplayLength : 25,
        lengthChange: true,
        searching   : true,
        ordering    : true,
        info        : false,
        autoWidth   : false,
        destroy     : true,
        processing  : true,
        serverSide  : true,
        ajax: '/data-rawat-inap?status='+status+'&tga='+tga+'&tgb='+tgb,
        fnCreatedRow: function (row, data, index) {
        $('td', row).eq(0).html(index + 1);
          },
        columns: [
            {data: 'nomor'},
            {data: 'no_rm'},
            {data: 'nama'},
            {data: 'alamat'},
            {data: 'waktu'},
            {data: 'poli'},
            {data: 'kelas'},
            {data: 'bangsal'},
            {data: 'bed'},
            {data: 'dpjp'},
            {data: 'carabayar'},
            {data: 'rb'},
            {data: 'view'},
        ]
      });
    }

    //DETAIL IRNA
    function viewDetail(registrasi_id) {
        $('#detailIrna').modal('show');
        $('.modal-title').text('Detail Informasi Rawat Inap');

        $.ajax({
            url: '/detail-data-rawat-inap/'+registrasi_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);

                $('#no_rm').html(data.no_rm);
                $('#nama').html(data.nama);
                $('#alamat').html(data.alamat);
                $('#tgl_masuk').html(data.tglMasuk);
                $('#poli').html(data.poli);
                $('#carabayar').html(data.carabayar);
                $('#dokter').html(data.dokter);
                $('#kelas').html(data.kelas);
                $('#kamar').html(data.kamar);
                $('#bed').html(data.bed);
                $('#keterangan').val(data.keterangan);
                $('#id_ranap').val(data.id);
                $('#diagnosa').html(data.diagnosa_awal);
            }
        });
    }

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function jenisLayanan(jenis) {
      switch (jenis) {
        case 'TA':
          return 'Layanan rawat jalan';
          break;
        case 'TG':
          return 'Layanan rawat darurat';
          break;
        case 'TI':
          return 'Layanan rawat inap';
          break;
        default:
          return 'Apotik';
          break;
      }
    }

    function rincianBiaya(registrasi_id) {
      // alert(registrasi_id)
      $('#modalRincianBiaya').modal('show');
      // $('.modal-title').text(nama + ' | ' + no_rm + '|' + registrasi_id)
      $('.tagihan').empty();
      $('.rincian_biaya').empty();
      $.ajax({
        url: '/informasi-rincian-biaya-baru/' + registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          cetak = '<a class="btn btn-info btn-sm pull-right" style="margin-left:10px" target="_blank" href="/ranap-informasi-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya</a>';
          cetak2 = '<a class="btn btn-success btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya Unit Tanpa Rajal</a><br/>';
          cetak4 = '<br/><a class="btn btn-warning btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya-tanpa-igd/'+registrasi_id+'"><span class="fa fa-print"></span> RB Tanpa IGD</a><br/>';
          cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
          $('.rincian_biaya').append(cetak3)
          $('.rincian_biaya').append(cetak)
          $('.rincian_biaya').append(cetak2)
          $('.rincian_biaya').append(cetak4)
          // console.log(data);
          $('.modal-title').text(data.namaPasien + ' | ' + data.noRM + '|' + registrasi_id)
          $.each(data.tagihan, function (key, value) {
            $('.tagihan').append('<tr> <td>' + (key + 1) + '</td> <td>' + value.namatarif + '</td> <td>' + jenisLayanan(value.jenis) + '</td> <td class="text-right">' +
              ribuan(value.total) + '</td> </tr>')
          });
        }
      });

      $.ajax({
        url: '/informasi-total-biaya/' + registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // console.log(data);
          $('.totalTagihan').html(ribuan(data))
        }
      });
    }

    function editKeterangan() {

      let idRanap = $('#id_ranap').val()
      let dataReq = $('#keterangan').val()

      $.ajax({
            url: 'update-keterangan/'+idRanap,
            type: 'post',
            data: {
              data: dataReq
            },
            beforeSend: function (request) {
             request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
            },
            success: function (data) {
                alert('Success Update Keterangan');
                location.reload();
            }
        });



    }




    </script>
@endsection
