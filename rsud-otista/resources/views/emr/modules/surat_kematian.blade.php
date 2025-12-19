@extends('master')

<style>
  .form-box td, select,input,textarea{
    font-size: 12px !important;
  }
  .history-family input[type=text]{
    height:20px !important;
    padding:0px !important;
  }
  .history-family-2 td{
    padding:1px !important;
  }
</style>
@section('header')
  <h1>Surat Kematian</h1>
@endsection

@section('content')

<form id="search_pasien" class="form-horizontal form-small">
    <a href="" role="button" aria-expanded="false" aria-controls="collapseExample">
      <i class="fa fa-users"></i> Cari Pasien IGD
    </a>
	<hr>
    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="form-group row">
              <label for="reg_no" class="col-sm-4 text-right control-label col-form-label">No Registrasi</label>
                <div class="col-sm-8">
                  <input readonly="" type="text" class="form-control xbold" id="reg_no" name="reg_no" placeholder="">
                </div>
            </div>
        </div>
            <div class="col-sm-12 col-lg-5">
              <div class="form-group row">
                <label for="mr_name" class="col-sm-3 col-sm-4x text-right control-label col-form-label">Nama pasien</label>
                  <div class="col-sm-9 col-sm-8x">
                     <input readonly="" type="text" class="form-control xbold" id="mr_name" name="mr_name" placeholder="">
                  </div>
                </div>
              </div>
        <div class="col-sm-12 col-lg-3">
            <div class="form-group row">
                <label for="mr_no" class="col-sm-4 text-right control-label col-form-label">No. MR</label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" class="form-control xbold" id="mr_no" name="mr_no" placeholder="">
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-lg-4">
    	<div class="form-group row">
          <label for="reg_date" class="col-sm-4 text-right control-label col-form-label">Tgl Registrasi</label>
            <div class="col-sm-8">
              <input readonly="" type="text" class="form-control" id="reg_date" name="reg_date" placeholder="">
            </div>
        </div>
      </div>
        <div class="col-sm-12 col-lg-5">
            <div class="form-group row">
                <label for="dokter_name" class="col-sm-3 col-sm-4x text-right control-label col-form-label">Nama Dokter</label>
                  <div class="col-sm-9 col-sm-8x">
                     <input readonly="" type="text" class="form-control" id="dokter_name" name="dokter_name" placeholder="">
                  </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-3">
          <div class="form-group row">
              <label for="tgl_lahir" class="col-sm-4 text-right control-label col-form-label">Tgl Lahir</label>
          <div class="col-sm-8">
              <input readonly="" type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="">
          </div>
          </div>
        </div>
	  </div>

    <div class="row">
	  <div class="col-sm-12 col-lg-4">
        <div class="form-group row">
          <label for="penjamin" class="col-sm-4 text-right control-label col-form-label">Poliklinik </label>
            <div class="col-sm-8">
              <input readonly="" type="text" class="form-control" id="poli_nama" name="poli_nama" placeholder="">
            </div>
        </div>
    </div>
    <!-- <div class="col-sm-12 col-lg-5">
      <div class="form-group row">
        <label for="penjamin" class="col-sm-3 col-sm-4x text-right control-label col-form-label">TTD Dokter </label>
          <div class="col-sm-9 col-sm-8x">
            <input type="hidden" id="dokter_kode" name="dokter_kode" value="471">
              <span id="ttd_dokter"></span>
                <button class="btn btn-default signbtn" type="button" id="btn_sign_dokter"><img src="http://172.168.1.5/emr/assets/images/signature.png" width="20px">Sign</button>
          </div>
	  </div>
    </div> -->
    <!-- <div class="col-sm-12 col-lg-3">
      <div class="form-group row">
        <label for="penjamin" class="col-sm-4 text-right control-label col-form-label">TTD Pasien </label>
          <div class="col-sm-8">
            <span id="ttd_pasien"></span><button class="btn btn-default signbtn" type="button" id="btn_sign_pasien"><img src="http://172.168.1.5/emr/assets/images/signature.png" width="20px">Sign</button>
          </div>
        </div>
      </div> -->
	</div>

    <a class="" data-toggle="collapse" href="#collapseDetail" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa fa-chevron-down"></i> Detail Pasien
    </a>
	<div class="collapse" id="collapseDetail">

    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="form-group row">
                <label for="penjamin" class="col-sm-4 text-right control-label col-form-label">Status Periksa</label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" class="form-control" id="status_periksa" name="status_periksa" placeholder="">
                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-5">
            <div class="form-group row">
                <label for="status_periksa" class="col-sm-3 col-sm-4x text-right control-label col-form-label">Penjamin</label>
                    <div class="col-sm-9 col-sm-8x">
                        <input readonly="" type="text" class="form-control" id="penjamin" name="penjamin" placeholder="">
                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-3">
            <div class="form-group row">
                <label for="cara_bayar" class="col-sm-4 text-right control-label col-form-label">Cara Bayar</label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" class="form-control" id="cara_bayar" name="cara_bayar" placeholder="">
                    </div>
            </div>
		</div>
    </div>
	<div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="form-group row">
                <label for="telepon" class="col-sm-4 text-right control-label col-form-label">Telepon</label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" class="form-control" id="telepon" name="telepon" placeholder="">
                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-5">
            <div class="form-group row">
                <label for="alamat" class="col-sm-3 col-sm-4x text-right control-label col-form-label">Alamat</label>
                    <div class="col-sm-9 col-sm-8x">
                    	<input readonly="" type="text" class="form-control" id="alamat" name="alamat" placeholder="">
                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-3">
            <div class="form-group row">
                <label for="agama" class="col-sm-4 text-right control-label col-form-label">Agama</label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" class="form-control" id="agama" name="agama" placeholder="">
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>





  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
        <form method="POST" action="{{ url('/emr/save-riwayat') }}" class="form-horizontal">

          <div class="row">
            <div class="col-md-12">
              <br> 
              
              <div class="col-md-12">  
              
              <h5>Rekam Jejak - Sertifikat Kematian</h5>
              <table id="dt_table" class="table table-bordered" style="width:100%;">
						<thead class="bg-success text-white">
							<tr>
								<th style="text-align:center;vertical-align:middle">No</th>
								<th style="text-align:center;vertical-align:middle" colspan="2">Penyebab Kematian</th>
								<th style="text-align:center;vertical-align:middle">Perkiraan Interval antara awalnya dan kematian</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="text-align:center;" rowspan="3">1.</td>
								<td>a. Penyakit atau kondisi yang langsung menuju kematian</td>
								<td width="35%">
									<div class="input-group">  
										<label class="mt-2">a.&nbsp;</label>
										<input type="text" id="penyebab_a" name="penyebab_a" class="form-control" value="">
									</div>
									<label for="">Penyakit atau kondisi tersebut akibat (atau sebagai konsekuensi dari)</label>
								</td>
								<td width="35%">
									<input type="text" id="interval_a" name="interval_a" class="form-control" value="">
								</td>
							</tr>
							<tr>
								<td rowspan="2">b. Penyebab pendahulu kondisi sakit, kalau ada, yang menimbulkan penyebab di atas, dengan meletakkan kondisi dasar paling akhir</td>
								<td width="35%">
									<div class="input-group">  
										<label class="mt-2">b.&nbsp;</label>
										<input type="text" id="penyebab_b" name="penyebab_b" class="form-control" value="">
									</div>
									<label for="">Penyakit atau kondisi tersebut akibat (atau sebagai konsekuensi dari)</label>
								</td>
								<td width="35%">
									<input type="text" id="interval_b" name="interval_b" class="form-control" value="">
								</td>
							</tr>
							<tr>
								<td width="35%">
									<div class="input-group">  
										<label class="mt-2">c.&nbsp;</label>
										<input type="text" id="penyebab_c" name="penyebab_c" class="form-control" value="">
									</div>
								</td>
								<td width="35%">
									<input type="text" id="interval_c" name="interval_c" class="form-control" value="">
								</td>
							</tr>
							<tr>
								<td style="text-align:center;" rowspan="3">2.</td>
								<td rowspan="3">Kondisi penting lain yang ikut menyebabkan kematian, tapi tidak berhubungan dengan penyakit atau kondisi penyebaba kematian</td>
								<td width="35%">
									<div class="input-group">  
										<label class="mt-2">1.&nbsp;</label>
										<input type="text" id="kondisi_lain_1" name="kondisi_lain_1" class="form-control" value="">
									</div>
								</td>
								<td width="35%">
									<input type="text" id="interval_1" name="interval_1" class="form-control" value="">
								</td>
							</tr>
							<tr>
								<td width="35%">
									<div class="input-group">  
										<label class="mt-2">2.&nbsp;</label>
										<input type="text" id="kondisi_lain_2" name="kondisi_lain_2" class="form-control" value="">
									</div>
								</td>
								<td width="35%">
									<input type="text" id="interval_2" name="interval_2" class="form-control" value="">
								</td>
							</tr>
							<tr>
								<td width="35%">
									<div class="input-group">  
										<label class="mt-2">3.&nbsp;</label>
										<input type="text" id="kondisi_lain_3" name="kondisi_lain_3" class="form-control" value="">
									</div>
								</td>
								<td width="35%">
									<input type="text" id="interval_3" name="interval_3" class="form-control" value="">
								</td>
							</tr>
						</tbody>
					</table>
                
              </div>
              </div> 
          </div>
        </div>
                {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script>
                  
  function bindRadios(selector){
  $(selector).click(function() {
    $(selector).not(this).prop('checked', false);
  });
};

bindRadios("#radio1, #radio2, #radio3, #radio4, #radio5");
// bindRadios("#radio4, #radio5, #radio6");
                  
                </script> --}}

@endsection

@section('script')

    <script type="text/javascript">
        $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
    </script>
@endsection
