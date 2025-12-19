<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.merek') }} | {{ config('app.nama') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet"
    href="{{ asset('style') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet"
    href="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/select2/dist/css/select2.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
  {{-- default
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css"> --}}
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-yellow.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-red.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.min.css') }}">
  {{--
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/timepicker/bootstrap-timepicker.min.css">
</head>

<body class="hold-transition skin-red sidebar-mini">


  <div class="box box-primary">

    <div class="box-body">
      <div style="margin-top:20px;margin-left:10px;margin-right:10px;">
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
                  <th style="width: 25%">No. RM</th>
                  <td class="no_rm"></td>
                </tr>
                <tr>
                  <th>Nama Pasien</th>
                  <td class="namaPasien"></td>
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

      </div>

 
      <button type="button" id="btn-save" class="btn btn-primary btn-flat" onclick="saveRetur()">Simpan</button>
      </form>

    </div>

    <div class="overlay hidden">
      <i class="fa fa-refresh fa-spin"></i><br/><br/><br/><br/><br/><br/><br/><br/>
      <p class="text-center">Harap tunggu sampai proses selesai, jangan close halaman !</p>
    </div>
  </div>
</body>
<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="{{ asset('style') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('style') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="{{ asset('style') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('style') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('style') }}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{ asset('style') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('style') }}/dist/js/demo.js"></script>

<script>
  let registrasi_id = {{ $no_faktur }};
  retur(registrasi_id);
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
          type: "POST",
          data: data,
          dataType: 'json',
          beforeSend: function(){
            $('#btn-save').prop('disabled', true)
            $('.overlay').removeClass('hidden')
          },
          success: function(data){
            $('#btn-save').prop('disabled', false);
            if (data.sukses == true) {
              $('#modalRetur').modal('hide')
              alert(data.message)
              window.close();
            }
            if (data.sukses == false) {
              $('#modalRetur').modal('hide')
              alert(data.message)
              window.close();
            }
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          },
      });

    }
</script>

</html>