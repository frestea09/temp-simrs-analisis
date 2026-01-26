{{-- @extends('layouts.landingpage') --}}

{{-- @section('content') --}}
 
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="qhopes">
<!-- Favicon icon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('rsud/favicon.png')}}">
<title>{{config('app.nama')}}: Antrean </title>


<!-- <link href="http://172.168.1.5/emr/assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="{{asset('rsud/style.min.css')}}" rel="stylesheet">
<link href="{{asset('rsud/select2.min.css')}}" rel="stylesheet" type="text/css" >
<link href="{{asset('rsud/sweetalert2.min.css')}}" rel="stylesheet">

<link href="{{asset('rsud/antrean.css')}}" rel="stylesheet"> 
<link href="{{asset('rsud/jqbtk.css')}}" rel="stylesheet"> 

<script src="{{asset('rsud/jquery.min.js')}}"></script>
</head>

<body>
    
    <div class="wrapper">
                
        
<div class="body-content">

    <div class="box-display">
        <div class="container" style="max-width: 100%;">
            <div class="row">
                <div class="box-title1">SILAHKAN AMBIL ANTRIAN DISINI</div>
            </div>
            <div class="row">
                <div class="col-12 my-auto">
                    <div class="sidebar-content">
                    
                        {{-- <form action="" method="post" class="enlarged"> --}}
                            {{ csrf_field() }}
                            <div class="row box" style="margin-right: -180px !important;    margin-left: 15px !important;">
                            
                                <div class="col-md-2">
                                    <div class="box-center">
                                        <div id="btn_saderek">
                                            <img src="{{asset('rsud/img/button/led-circle-red-md.png')}}" width="200px">
                                        </div>
                                    </div>
                                    <div class="box-title3">PASIEN LAMA<br>MOBILE JKN</div>
                                </div>
                                <div class="col-md-2">
                                    <div class="box-center">
                                        <div id="btn_pasien_baru">
                                            <img src="{{asset('rsud/img/button/led-circle-green-md.png')}}" width="200px">
                                        </div>
                                    </div>
                                    <div class="box-title3">PASIEN BARU<br>MOBILE JKN</div>
                                </div>
                                <div class="col-md-2">
                                    <div class="box-center">
                                        <div id="btn_umum">
                                            <img src="{{asset('rsud/img/button/led-circle-red-md.png')}}" width="200px">
                                        </div>
                                    </div>
                                    <div class="box-title3">LOKET<br>NON JKN</div>
                                </div>
                                @if (date('H:i') > '06:00') 
                                    <div class="col-md-2">
                                        <div class="box-center">
                                            <div id="loket_b">
                                                {{-- <form method="POST" action="http://172.168.1.172/antrian/savetouch" accept-charset="UTF-8"><input name="_token" type="hidden"> --}}
                                                    {{ csrf_field() }}
                                                    <input name="kelompok" type="hidden" value="B">
                                                    <input name="bagian" type="hidden" value="bawah">
                                                    <input name="tanggal" type="hidden" value="{{date('Y-m-d')}}">
                                                    <input class="btnTouch" type="submit" value="LOKET 2" style="width: 200px;position: absolute;
                                                    opacity: 0;height: 200px;">
                                                    <img src="{{asset('rsud/img/button/led-circle-yellow-md.png')}}" width="200px">
                                                {{-- </form> --}}
                                            </div>
                                        </div>
                                        <div class="box-title3">LOKET<br>B</div>
                                    </div>   
                                    <div class="col-md-2">
                                        <div class="box-center">
                                            <div id="loket_c">
                                                    <input class="btnTouch" type="submit" value="LOKET 2" style="width: 200px;position: absolute;
                                                    opacity: 0;height: 200px;">
                                                    <img src="{{asset('rsud/img/button/led-circle-yellow-md.png')}}" width="200px">
                                            </div>
                                        </div>
                                        <div class="box-title3">LOKET<br>C</div>
                                    </div>   
                                @endif 
                                
							</div>

                        {{-- </form> --}}

						<div class="div-space2"></div>
						
                        <input type="hidden" id="sess_tipe" value="">
                        <input type="hidden" id="sess_mrid" value="">
                        <input type="hidden" id="sess_mrno" value="">
                        <input type="hidden" id="sess_mrname" value="">
                        <input type="hidden" id="sess_tgllahir"value="">
                        <input type="hidden" id="sess_jk" value="">
                        <input type="hidden" id="sess_nik" value="">
                        <input type="hidden" id="sess_nokartu" value="">
                        <input type="hidden" id="sess_nohp" value="">
                        <input type="hidden" id="sess_jenispasien" value="">
                        <input type="hidden" id="sess_pasienbaru" value="">
                        <input type="hidden" id="sess_poli_id" value="">
                        <input type="hidden" id="sess_kodepoli" value="">
                        <input type="hidden" id="sess_namapoli" value="">
                        <input type="hidden" id="sess_kodedokter" value="">
                        <input type="hidden" id="sess_namadokter" value="">

                        <input type="hidden" id="sess_norujukan" value="">
                        <input type="hidden" id="sess_jenisrujukan" value="">
                        <input type="hidden" id="sess_polirujukan" value="">
                        <input type="hidden" id="sess_polirujukannama" value="">
                        <input type="hidden" id="sess_eselon" value="">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
         
	{{-- <div class="runningtext">
        <div class="row h-100 ">
            <div class="runningtext-content">
                <div id="slideshow">
                    Selamat Datang di {{config('app.nama')}}
                </div>
            </div>
            
        </div>
    </div> --}}
 
</div>

<div id="modalPilihPasien" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-info">
                <h4 class="modal-title text-white" id="success-header-modalLabel">Pilih Penjamin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" name="form-detail" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                    
                    <div style="padding:10px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-cyan text-white" id="btn_tunai">
                                    <div class="card-body">
                                        <div class="no-block align-items-center text-center">
                                            <h3 class="font-weight-medium mb-2 mt-2 text-white">TUNAI / UMUM</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-orange text-white" id="btn_bpjs">
                                    <div class="card-body">
                                    <div class="no-block align-items-center text-center">
                                            <h3 class="font-weight-medium mb-2 mt-2 text-white">BPJS KESEHATAN</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-primary text-white" id="btn_asuransi">
                                    <div class="card-body">
                                    <div class="no-block align-items-center text-center">
                                            <h3 class="font-weight-medium mb-2 mt-2 text-white">ASURANSI</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalCekPasien" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel" aria-hidden="true"   data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-info">
                <h4 class="modal-title text-white" id="success-header-modalLabel">Pengecekan Pasien</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form id="formCekPasien" action="" name="form-cek-pasien" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                    
                    <div style="padding:10px;">
                    
                        <div class="alert alert-success" role="alert">
                            <i class="dripicons-checkmark"></i><h4> Scan / Input Salah Satu Pencarian Berikut:</h4>
                        </div>
                        <br>
                        
                        <div class="form-group is_jkn">
                            <label for="nokartu">No. Kartu Peserta (BPJS)</label>
                            <div class="input-group mb-3">
                                <input type="text" id="nokartu" name="nokartu" autofocus class="keyboard form-control form-control-lg">
                                <div class="input-group-append">
                                    <button id="btn_cekKartu" class="btn btn-info" type="button">Cek Data</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="norm">No. Rekam Medik (RM)</label>
                            <div class="input-group mb-3">
                            <input type="text" id="norm" name="norm" class="keyboard form-control form-control-lg">
                                <div class="input-group-append">
                                    <button id="btn_cekMR" class="btn btn-info" type="button">Cek Data</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nik">NIK KTP</label>
                            <div class="input-group mb-3">
                            <input type="text" id="nik" name="nik" class="keyboard form-control form-control-lg">
                                <div class="input-group-append">
                                    <button id="btn_cekNIK" class="btn btn-info" type="button">Cek Data</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalPoli" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document" style="max-width:1000px !important">
      <div class="modal-content">
        <div class="modal-header modal-colored-header bg-info">
          <h2 class="modal-title text-white" id="modalSayaLabel">PILIH POLIKLINIK & CEK MR</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">  
            <div id="dataPoli"></div>
        </div>
        <div class="modal-footer">
          <span style="position: absolute;left: 25px;font-weight:900 !important"><i><b><span style="color:red">*</span> BERWARNA ABU-ABU ARTINYA KUOTA POLI TELAH HABIS ATAU TUTUP</b></i></span>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
          {{-- <button type="button" class="btn btn-primary">Oke</button> --}}
        </div>
      </div>
    </div>
</div>

<div id="wait" style="display: none; width: 100%; height: 100%; top: 10px; left: 0px; position: fixed; z-index: 10000; text-align: center;">
    <img src="{{asset('rsud/img/loading.gif')}}" width="45" height="45" alt="Loading..." style="position: fixed; top: 50%; left: 50%;" />
</div>

<script type="text/javascript">
    var next_step_antrean_pasien_lama = 'admisi';

    $(document).ready(function() {
        
        $('#wait').hide();
    
        $(document).ajaxStart(function(){
            $('#wait').show();
        });
        $(document).ajaxComplete(function(){
            $('#wait').hide();
        });
        $(document).ajaxStop(function () {
            $('#wait').hide();
        });
        $(document).ajaxError(function () {
            $('#wait').hide();
        });   

        
        $('#btn_saderek').click(function(event) {
            
            // $('#modalCheckinSaderek').modal('show');
            
            // $('#modalCheckinSaderek').on('shown.bs.modal', function () {
                
            //     $('#nobooking').focus();
            // });
            window.location.href = "{{URL::to('reservasi/cek')}}"

        });

        $('#btn_umum').click(function(event) {
            
            // $('#modalCheckinSaderek').modal('show');
            
            // $('#modalCheckinSaderek').on('shown.bs.modal', function () {
                
            //     $('#nobooking').focus();
            // });
            window.location.href = "{{URL::to('reservasi/cek-umum')}}"

        });
        
        

        $('#btn_pasien_lama').click(function(event) {
            window.location.href = "{{URL::to('reservasi-lama')}}"
        });
        
        $('#btn_pasien_baru').click(function(event) {
            window.location.href = "{{URL::to('reservasi/cek-baru')}}"
            // pilih_pasien('1');
        });
        
        $('#btn_tunai').click(function() {
            cek_pasien('A');
        });
        
        $('#btn_bpjs').click(function() {
            cek_pasien('B');
        });
        $('#loket_b').click(function() {
            $('#modalPoli').modal('show');
            $('#dataPoli').load("/load-poli-v2/B/bawah");
        });
        $('#loket_c').click(function() {
            $('#modalPoli').modal('show');
            $('#dataPoli').load("/load-poli-v2/C/atas");
        });
        

        $('#btn_asuransi').click(function() {
            cek_pasien('C');
        });
        

        load_information();

        setInterval(function() { 
            $('#slideshow > div:first')
            .fadeOut(2000)
            .next()
            .fadeIn(2000)
            .end()
            .appendTo('#slideshow');
        },  6000);

        setInterval(function(){
            //auto load
            //load_information();
        },120000); 

        $('#nokartu').keyboard({type:'numpad'});
        $('#norm').keyboard({type:'numpad'});
        $('#nik').keyboard({type:'numpad'});
        $('#norujukan').keyboard();
        $('#nik_baru').keyboard({type:'numpad'});
        $('#nama_baru').keyboard();
        $('#nokartu_baru').keyboard({type:'numpad'});
        //$('#nobooking').keyboard();
        $('#nobooking').val('');

        $('#nobooking').keyup(function(){
            if(this.value.length == 17){
                $('#btn_checkinSaderek').trigger('click');
            }
        });
         
    });
     

    function load_information(){
        
    }
    
</script>            
    </div>

    <script src="{{asset('rsud/popper.min.js')}}"></script>
    <script src="{{asset('rsud/bootstrap.min.js')}}"></script>
    <script src="{{asset('rsud/select2.min.js')}}"></script>
    <script src="{{asset('rsud/select2.init.js')}}"></script>
    <script src="{{asset('rsud/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('rsud/jqbtk.js')}}"></script>
</body>

</html>
{{-- @endsection --}}