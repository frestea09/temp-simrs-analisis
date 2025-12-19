@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }
  .scroll-umum{
   width: 100%;
   overflow-y:scroll;
   height:40%;
   display:block;
  }
</style>
@section('header')
<h1>Anamnesis - Riwayat</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/anamnesis/riwayat/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Riwayat</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:20%;">Keluhan Utama</td>
                <td style="padding: 5px;">
                  <textarea rows="15" name="keterangan" style="display:inline-block" placeholder="[Masukkan Riwayat Perjalanan Penyakit]" class="form-control" required></textarea></td>
              
                </tr>
            </table>
            <h5><b>Menstruasi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                {{-- <td style="width:20%;">Keluhan Utama</td>
                <td style="padding: 5px;">
                  <textarea rows="15" name="keterangan" style="display:inline-block" placeholder="[Masukkan Riwayat Perjalanan Penyakit]" class="form-control"></textarea></td>
               --}}
              
                  <tr>
                    <td style="width:20%;">HPHT</td>
                    <td style="padding: 5px;">
                      <input type="date" name="menstruasi[hpht]" class="form-control" id="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:20%;">Dismenorrhoe</td>
                    <td style="padding: 5px;"><input type="text" name="menstruasi[dismenorrhoe]" style="display:inline-block"
                        class="form-control" id=""/></td>
                  </tr>
                  <tr>
                    <td s tyle="width:20%;">Lama</td>
                    <td style="padding: 5px;"><input style="display:inline-block" type="text"  name="menstruasi[lama]" class="form-control" />
                  </tr>
                  <tr>
                    <td style="width:20%;">Banyaknya</td>
                    <td style="padding: 5px;"><input type="text" name="menstruasi[banyaknya]" style="display:inline-block"
                        class="form-control" ></td>
                  </tr>
                  <tr>
                    <td style="width:20%;">Menorrhagia / Metorrhagia</td>
                    <td style="padding: 5px;">
                      <input type="text"  name="menstruasi[menorrhagia]" style="display:inline-block" class="form-control" id="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:20%;">Siklus</td>
                    <td style="padding: 5px;"><input type="text" name="menstruasi[siklus]" style="display:inline-block" class="form-control" id=""></td>
                  </tr>
                  <tr>
                    <td style="width:20%;">Nyeri</td>
                    <td style="padding: 5px;"><input type="text" name="menstruasi[nyeri]" style="display:inline-block" class="form-control" id=""></td>
                  </tr>
                  <tr>
                    <td style="width:20%;">Teratur</td>
                    <td style="padding: 5px;"><input type="text"name="menstruasi[teratur]" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td style="width:20%;">TP</td>
                    <td style="padding: 5px;"><input type="text" name="menstruasi[tp]" class="form-control" /></td>
                  </tr>

                  </tr>
              
                </tr>
            </table>
            <h5><b>Riwayat Kesehatan</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
                <tr>
                    <td  rowspan="3">Riwayat Alergi</td>
                    <td>
                      <input class="form-check-input" class="riwayat"  name="menstruasi[obat]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="menstruasi[obat]" type="checkbox" value="Obat" id="flexCheckDefault">
                      A. Obat
                    </td>
                </tr>
                <tr>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="menstruasi[makanan]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="menstruasi[makanan]" type="checkbox" value="Makanan" id="flexCheckDefault">
                      B. Makanan
                      </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">
                      <input name="menstruasi[lainnya1]" type="text" class="form-control" id="lainnya" placeholder="Lain-lain">
                    </td>
                <tr>
                  <td style="width:20%;" rowspan="7">Riwayat Penyakit Dahulu :</td>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[hipertensi1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[hipertensi1]" type="checkbox" value="Hipertensi" id="flexCheckDefault">
                    Hipertensi
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[diabetes1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[diabetes1]" type="checkbox" value="Diabetes" id="flexCheckDefault">
                    Diabetes
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[asma1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[asma1]" type="checkbox" value="Asma" id="flexCheckDefault">
                    Asma
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[maag1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[maag1]" type="checkbox" value="Maag" id="flexCheckDefault">
                    Maag
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[hepatitis1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[hepatitis1]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                    Hepatitis
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[jantung1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="menstruasi[jantung1]" type="checkbox" value="Jatung" id="flexCheckDefault">
                    Jantung
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <input name="menstruasi[lainnya2]" type="text" class="form-control" id="lainnya" placeholder="Lain-lain">
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;" rowspan="7">Riwayat Penyakit Keluarga :</td>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[hipertensi2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[hipertensi2]" type="checkbox" value="Hipertensi" id="flexCheckDefault">
                    Hipertensi
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[diabetes2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[diabetes2]" type="checkbox" value="Diabetes" id="flexCheckDefault">
                    Diabetes
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[asma2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[asma2]" type="checkbox" value="Asma" id="flexCheckDefault">
                    Asma
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[maag2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[maag2]" type="checkbox" value="Maag" id="flexCheckDefault">
                    Maag
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[hepatitis2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[hepatitis2]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                    Hepatitis
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[jantung2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="menstruasi[jantung2]" type="checkbox" value="Jatung" id="flexCheckDefault">
                    Jantung
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <input name="menstruasi[lainnya3]" type="text" class="form-control" id="lainnya" placeholder="Lain-lain">
                  </td>
                </tr>
            </table>
            <h5><b>Riwayat Perkawinan</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;"> 
                <tr>
                    <td  rowspan="3">Status</td>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="menstruasi[bkawin]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="menstruasi[bkawin]" type="checkbox" value="BKawin" id="flexCheckDefault">
                      A. Belum Kawin
                    </td>
                </tr>
                <tr>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="menstruasi[kawin]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="menstruasi[kawin]" type="checkbox" value="Kawin" id="flexCheckDefault">
                      B. Kawin
                      </td>
                </tr>
                <tr>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="menstruasi[cerai]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="menstruasi[cerai]" type="checkbox" value="Cerai" id="flexCheckDefault">
                      C. Cerai
                      </td>
                </tr>
                <tr>
                  <td style="width:20%;">Menikah (x)</td>
                  <td style="padding: 5px;"><input type="number" value="0" name="menstruasi[menikah]" style="display:inline-block" class="form-control" id=""></td>
                </tr>
                <tr>
                  <td style="width:20%;">Lama Menikah </td>
                  <td>
                    <input name="menstruasi[lama]" type="text" class="form-control" id="lama" placeholder="Lama Menikah">
                  </td>
                </tr>
            </table>







            <h5><b>Riwayat Kontrasepsi Yang Pernah Di Pakai</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td rowspan="5" style="padding: 5px;">Riwayat Konstrasepsi Yang Pernah Di Pakai :</td>
                <td>
                <input class="form-check-input" name="menstruasi[pil]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[pil]" type="checkbox" value="Pil" id="flexCheckDefault">
                   Pil
                </td>
               <tr>
                <td>
                  <input class="form-check-input" name="menstruasi[suntik]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[suntik]" type="checkbox" value="suntik" id="flexCheckDefault">
                      Suntik
                  </td>
               </tr>
                <tr>
                  <td>
                    <input class="form-check-input" name="menstruasi[IUD]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"   name="menstruasi[IUD]" type="checkbox" value="IUD" id="flexCheckDefault">
                        IUD
                    </td>
                </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[implan]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[implan]" type="checkbox" value="Implan" id="flexCheckDefault">
                          Implan
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[mow]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[mow]" type="checkbox" value="MOW" id="flexCheckDefault">
                          MOW
                      </td>
                  </tr>
              </tr>
            </table>





            <h5><b>Riwayat Penyakit Dahulu</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td rowspan="9" style="padding: 5px;">Riwayat Penyakit Dahulu :</td>
                <td>
                <input class="form-check-input" name="menstruasi[pil_dhl]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[pil_dhl]" type="checkbox" value="Pil" id="flexCheckDefault">
                   Pil
                </td>
               <tr>
                <td>
                  <input class="form-check-input" name="menstruasi[jantung_dhl]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[jantung_dhl]" type="checkbox" value="jantung" id="flexCheckDefault">
                      jantung
                  </td>
               </tr>
                <tr>
                  <td>
                    <input class="form-check-input" name="menstruasi[asma_dhl]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"   name="menstruasi[asma_dhl]" type="checkbox" value="asma" id="flexCheckDefault">
                        asma
                    </td>
                </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[hipertensi_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[hipertensi_dhl]" type="checkbox" value="hipertensi" id="flexCheckDefault">
                          hipertensi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[DM_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[DM_dhl]" type="checkbox" value="DM" id="flexCheckDefault">
                          DM
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[hepatitis_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[hepatitis_dhl]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                          Hepatitis
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[alergi_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[alergi_dhl]" type="checkbox" value="Alergi" id="flexCheckDefault">
                          Alergi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[ginjal_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[ginjal_dhl]" type="checkbox" value="Ginjal" id="flexCheckDefault">
                          Ginjal
                      </td>
                  </tr>
                   <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[tidak_ada_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[tidak_ada_dhl]" type="checkbox" value="Tidak Ada" id="flexCheckDefault">
                          Tidak Ada
                      </td>
                  </tr>
              </tr>
            </table>














            
            <h5><b>Riwayat Penyakit Keluarga</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td rowspan="9" style="padding: 5px;">Riwayat Penyakit Keluarga :</td>
                <td>
                <input class="form-check-input" name="menstruasi[pil_klg]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[pil_klg]" type="checkbox" value="Pil" id="flexCheckDefault">
                   Pil
                </td>
               <tr>
                <td>
                  <input class="form-check-input" name="menstruasi[jantung_klg]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[jantung_klg]" type="checkbox" value="jantung" id="flexCheckDefault">
                      jantung
                  </td>
               </tr>
                <tr>
                  <td>
                    <input class="form-check-input" name="menstruasi[asma_klg]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"   name="menstruasi[asma_klg]" type="checkbox" value="asma" id="flexCheckDefault">
                        asma
                    </td>
                </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[hipertensi_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[hipertensi_klg]" type="checkbox" value="hipertensi" id="flexCheckDefault">
                          hipertensi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[DM_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[DM_klg]" type="checkbox" value="DM" id="flexCheckDefault">
                          DM
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[hepatitis_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[hepatitis_klg]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                          Hepatitis
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[alergi_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[alergi_klg]" type="checkbox" value="Alergi" id="flexCheckDefault">
                          Alergi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[ginjal_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[ginjal_klg]" type="checkbox" value="Ginjal" id="flexCheckDefault">
                          Ginjal
                      </td>
                  </tr>
                   <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[tidak_ada_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[tidak_ada_klg]" type="checkbox" value="Tidak Ada" id="flexCheckDefault">
                          Tidak Ada
                      </td>
                  </tr>
              </tr>
            </table>









            <h5><b>Riwayat Gynecolog</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td rowspan="9" style="padding: 5px;">Riwayat Gynecolog :</td>
                <td>
                <input class="form-check-input" name="menstruasi[infertilitas]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[infertilitas]" type="checkbox" value="Infertilitas" id="flexCheckDefault">
                   Infertilitas
                </td>
               <tr>
                <td>
                  <input class="form-check-input" name="menstruasi[infeksi_virus]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="menstruasi[infeksi_virus]" type="checkbox" value="Infeksi Virus" id="flexCheckDefault">
                      Infeksi Virus
                  </td>
               </tr>
                <tr>
                  <td>
                    <input class="form-check-input" name="menstruasi[PMS]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"   name="menstruasi[PMS]" type="checkbox" value="PMS" id="flexCheckDefault">
                        PMS
                    </td>
                </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[cervitis_akut]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[cervitis_akut]" type="checkbox" value="Cervitis Akut" id="flexCheckDefault">
                          Cervitis Akut
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[endometriosis]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[endometriosis]" type="checkbox" value="Endometriosis" id="flexCheckDefault">
                          Endometriosis
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[polyp_cervix]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[polyp_cervix]" type="checkbox" value="Polyp Cervix" id="flexCheckDefault">
                          Polyp Cervix
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[myoma]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[myoma]" type="checkbox" value="Myoma" id="flexCheckDefault">
                          Myoma
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[ca_cervix]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[ca_cervix]" type="checkbox" value="Ca Cervix" id="flexCheckDefault">
                          Ca Cervix
                      </td>
                  </tr>
                   <tr>
                    <td>
                      <input class="form-check-input" name="menstruasi[operai_kandungan]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="menstruasi[operai_kandungan]" type="checkbox" value="Operasi Kandungan" id="flexCheckDefault">
                          Operasi Kandungan
                      </td>
                  </tr>
              </tr>
            </table>
















            <h5><b>Riwayat Kehamilan Dan Persalinan</b></h5>
            <table style="width: 100%; text-align:center;" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;" border="2">
              <tr>
                <td style="padding: 5px;" rowspan="2">No</td>
                <td style="padding: 5px;" rowspan="2">Tempat Persalinan</td>
                <td style="padding: 5px;" rowspan="2">Jenis Persalinan</td>
                <td style="padding: 5px;" rowspan="2">Penolong</td>
                <td style="padding: 5px;" rowspan="2">Penyulit Kehamilan</td>
                <td style="padding: 5px;" colspan="3">Anak</td>
              </tr>
              <tr>
                <td>L/P</td>
                <td>BB</td>
                <td>Hidup/Mati</td>
              </tr>
              <tr>
                <td>
                  <input name="menstruasi[no]" type="text" class="form-control" id="No">
                </td>
                <td>
                  <input name="menstruasi[tempat]" type="text" class="form-control" id="Tempat">
                </td>
                <td>
                  <input name="menstruasi[jenis]" type="text" class="form-control" id="Jenis">
                </td>
                <td>
                  <input name="menstruasi[penolong]" type="text" class="form-control" id="Penolong">
                </td>
                <td>
                  <input name="menstruasi[penyulit]" type="text" class="form-control" id="Penyulit">
                </td>
                <td>
                  <input name="menstruasi[jkelamin]" type="text" class="form-control" id="Jkelamin">
                </td>
                <td>
                  <input name="menstruasi[bb]" type="text" class="form-control" id="BB">
                </td>
                <td>
                  <input name="menstruasi[h/p]" type="text" class="form-control" id="H/P">
                </td>
          </tr>
            </table>
            <h5><b>Riwayat KB</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td style="padding: 5px;">KB :</td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[ya]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayatkb"  name="menstruasi[ya]" type="checkbox" value="Iya" id="flexCheckDefault">
                    Ya
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[tidak]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayatkb"  name="menstruasi[tidak]" type="checkbox" value="tidak" id="flexCheckDefault">
                    Tidak
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" rowspan="3">KB Yang Pernah Dipakai</td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[pil]" type="hidden" value="pil" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayatkb"  name="menstruasi[pil]" type="checkbox" value="pil" id="flexCheckDefault">
                    Pil KB
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[iud]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayatkb"  name="menstruasi[iud]" type="checkbox" value="iud" id="flexCheckDefault">
                    IUD
                </td>
              </tr>
              <tr>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[suntik]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayatkb"  name="menstruasi[suntik]" type="checkbox" value="suntik" id="flexCheckDefault">
                    Suntik
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[susuk]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayatkb"  name="menstruasi[susuk]" type="checkbox" value="susuk" id="flexCheckDefault">
                    Susuk/Norplant
                </td>
              </tr>
              <tr>
                <td colspan="2">
                <input class="form-control" type="text" name="menstruasi[lainnya4]" placeholder="Lainnya"></td>
              </tr>
            </table>
            <h5><b>Riwayat ANC</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td style="padding: 5px;" rowspan="3">ANC :</td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[ya2]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[ya2]" type="checkbox" value="Iya" id="flexCheckDefault">
                    Ya
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[tidak2]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[tidak2]" type="checkbox" value="tidak" id="flexCheckDefault">
                    Tidak
                </td>
              </tr>
              <tr>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[kandungan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[kandungan]" type="checkbox" value="kandungan" id="flexCheckDefault">
                    Dokter Kandungan
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[bidan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[bidan]" type="checkbox" value="bidan" id="flexCheckDefault">
                    Bidan
                </td>
              </tr>
              <tr>
                <td colspan="2">
                <input class="form-control" type="text" name="menstruasi[lainnya5]" placeholder="Lainnya"></td>
              </tr>
            </table>
            <h5><b>Keluhan Saat Hamil</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td style="padding: 5px;" rowspan="2">Hamil Muda :</td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[mual1]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[mual1]" type="checkbox" value="mual" id="flexCheckDefault">
                    Mual/Muntah
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[perdarahan1]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[perdarahan1]" type="checkbox" value="perdarahan" id="flexCheckDefault">
                    Perdarahan
                </td>
              </tr>
              <tr>
                <td colspan="2">
                <input class="form-control" type="text" name="menstruasi[lainnya6]" placeholder="Lainnya"></td>
              </tr>
              <tr>
                <td style="padding: 5px;" rowspan="2">Hamil Tua :</td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[mual2]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[mual2]" type="checkbox" value="mual" id="flexCheckDefault">
                    Mual/Muntah
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[perdarahan2]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[perdarahan2]" type="checkbox" value="perdarahan" id="flexCheckDefault">
                    Perdarahan
                </td>
              </tr>
              <tr>
                <td colspan="2">
                <input class="form-control" type="text" name="menstruasi[lainnya7]" placeholder="Lainnya"></td>
              </tr>
            </table>
            <h5><b>Keadaan Bio Psikososial</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td style="padding: 5px;">Pola Makan (x/hari) :</td>
                <td colspan="2">
                  <input class="form-control" type="text" name="menstruasi[polamakan]">
                </td>
              </tr>  
              <tr>
                <td style="padding: 5px;" rowspan="3">Pola Minum (cc/hari) :</td>
                <td colspan="2">
                  <input class="form-control" type="text" name="menstruasi[polaminum]">
                </td>
              </tr>
              <tr>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[muntah]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[muntah]" type="checkbox" value="muntah" id="flexCheckDefault">
                    Muntah
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[sulitmenelan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[sulitmenelan]" type="checkbox" value="sulitmenelan" id="flexCheckDefault">
                    Sulit Menelan
                </td>
              </tr>
              <tr>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[sulitmengunyah]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[sulitmengunyah]" type="checkbox" value="sulitmengunyah" id="flexCheckDefault">
                    Sulit Mengunyah
                </td>
                <td>
                <input class="form-check-input" class="riwayat"  name="menstruasi[nafsumakan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input" class="riwayat"  name="menstruasi[nafsumakan]" type="checkbox" value="nafsumakan" id="flexCheckDefault">
                    Kehilangan Nafsu Makan
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" rowspan="3">Pola Eleminasi :</td>
                <td>BAK</td>
                <td>Warna</td>
              </tr>
              <tr>
                <td>
                  <input type="text" class="form-control" name="menstruasi[BAK]" placeholder="cc/hari">
                </td>
                <td>
                  <input type="text" class="form-control" name="menstruasi[warna]">
                </td>
              </tr>
              <tr>
                <td>BAB</td>
                <td>
                  <input type="text" class="form-control" name="menstruasi[banyak]" placeholder="x/hari">
                </td>
              </tr>
              <!-- <tr>
                  <td style="padding: 5px;" rowspan="3">Pola Istirahat :</td>
              </tr> -->
            </table>
            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan Data</button>
            </div>
          </div>
          {{-- Alergi --}}

          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Catatan Medis</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr>  
                @endif

                @php
                    $angka = 1;
                @endphp

                @foreach ($riwayat as $item)
                <tr style="background-color:#9ad0ef">
                  {{-- <th>{{$val_a->registrasi->reg_id}}</th> --}}
                  <th colspan="2">Catatan {{ $angka++ }} 
                    {{-- {{@strtoupper($val_a->registrasi->poli->nama)}} --}}
                  </th>
                </tr>
                  @if ($item->menstruasi == null)

                  <tr>
                    <td><b>Menstruasi : - </b><br/>
                  </tr>


                  @else

                  <tr>
                    <td rowspan="10" style="width: 100px"><b>Menstruasi :</b><br/>
                     
                       <tr>
                         <td>
                           <b>HPHT :</b>{{json_decode($item->menstruasi,true)['hpht']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Dismenorrhoe :</b>{{json_decode($item->menstruasi,true)['dismenorrhoe']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lama :</b>{{json_decode($item->menstruasi,true)['lama']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Banyaknya :</b>{{json_decode($item->menstruasi,true)['banyaknya']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Menorrhagia / Metorrhagia :</b>{{json_decode($item->menstruasi,true)['menorrhagia']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Siklus :</b>{{json_decode($item->menstruasi,true)['siklus']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Nyeri :</b>{{json_decode($item->menstruasi,true)['nyeri']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Teratur :</b>{{json_decode($item->menstruasi,true)['teratur']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>TP :</b>{{json_decode($item->menstruasi,true)['tp']}}
                         </td>
                       </tr>
                     
                   </td> 
                    
                 </tr>
                 <tr>
                    <td rowspan="4" style="width: 100px"><b>Alergi :</b><br/>
                      <tr>
                        <td>
                           <b>Obat : </b>{{json_decode(@$item->menstruasi,true)['obat']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Makanan : </b>{{json_decode(@$item->menstruasi,true)['makanan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya1']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="8" style="width: 100px"><b>Riwayat Penyakit Dahulu :</b><br/>
                      <tr>
                        <td>
                           <b>Hipertensi : </b>{{json_decode(@$item->menstruasi,true)['hipertensi1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Diabetes : </b>{{json_decode(@$item->menstruasi,true)['diabetes1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Asma : </b>{{json_decode(@$item->menstruasi,true)['asma1']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Maag : </b>{{json_decode(@$item->menstruasi,true)['maag1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Hepatitis : </b>{{json_decode(@$item->menstruasi,true)['hepatitis1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Jantung : </b>{{json_decode(@$item->menstruasi,true)['jantung1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya2']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="8" style="width: 100px"><b>Riwayat Penyakit Keluarga :</b><br/>
                      <tr>
                        <td>
                           <b>Hipertensi : </b>{{json_decode(@$item->menstruasi,true)['hipertensi2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Diabetes : </b>{{json_decode(@$item->menstruasi,true)['diabetes2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Asma : </b>{{json_decode(@$item->menstruasi,true)['asma2']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Maag : </b>{{json_decode(@$item->menstruasi,true)['maag2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Hepatitis : </b>{{json_decode(@$item->menstruasi,true)['hepatitis2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Jantung : </b>{{json_decode(@$item->menstruasi,true)['jantung2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya3']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="6" style="width: 100px"><b>Riwayat Perkawinan :</b><br/>
                      <tr>
                        <td>
                           <b>Belum Kawin : </b>{{json_decode($item->menstruasi,true)['bkawin']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Kawin : </b>{{json_decode($item->menstruasi,true)['kawin']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Cerai : </b>{{json_decode($item->menstruasi,true)['cerai']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Menikah : </b>{{json_decode($item->menstruasi,true)['menikah']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Hepatitis : </b>{{json_decode($item->menstruasi,true)['hepatitis2']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>


                 <tr>
                    <td rowspan="7" style="width: 100px"><b>Riwayat KB :</b><br/>
                      <tr>
                        <td>
                           <b>Iya : </b>{{json_decode(@$item->menstruasi,true)['ya']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Tidak : </b>{{json_decode(@$item->menstruasi,true)['tidak']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Pil : </b>{{json_decode(@$item->menstruasi,true)['iud']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Suntik : </b>{{json_decode(@$item->menstruasi,true)['suntik']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Susuk : </b>{{json_decode(@$item->menstruasi,true)['susuk']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya4']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="6" style="width: 100px"><b>Riwayat ANC :</b><br/>
                      <tr>
                        <td>
                           <b>Iya : </b>{{json_decode(@$item->menstruasi,true)['ya2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Tidak : </b>{{json_decode(@$item->menstruasi,true)['tidak2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Kandungan : </b>{{json_decode(@$item->menstruasi,true)['kandungan']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Bidan : </b>{{json_decode(@$item->menstruasi,true)['bidan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya5']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="4" style="width: 100px"><b>Keluhan saat hamil muda :</b><br/>
                      <tr>
                        <td>
                           <b>Mual / Muntah : </b>{{json_decode(@$item->menstruasi,true)['mual1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Perdarahan : </b>{{json_decode(@$item->menstruasi,true)['perdarahan1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya6']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="4" style="width: 100px"><b>Keluhan saat hamil tua :</b><br/>
                      <tr>
                        <td>
                           <b>Mual / Muntah : </b>{{json_decode(@$item->menstruasi,true)['mual2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Perdarahan : </b>{{json_decode(@$item->menstruasi,true)['perdarahan2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya7']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="8" style="width: 100px"><b>Keadaan Psikososial :</b><br/>
                      <tr>
                        <td>
                           <b>Pola Makan : </b>{{json_decode($item->menstruasi,true)['polamakan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Pola Minum : </b>{{json_decode($item->menstruasi,true)['polaminum']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Muntah : </b>{{json_decode(@$item->menstruasi,true)['muntah']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Sulit Mengunyah : </b>{{json_decode(@$item->menstruasi,true)['sulitmengunyah']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Sulit Menelan : </b>{{json_decode(@$item->menstruasi,true)['sulitmenelan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Keadaan Nafsu Makan : </b>{{json_decode(@$item->menstruasi,true)['nafsumakan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->menstruasi,true)['lainnya7']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>


                 <tr>
                    <td rowspan="4" style="width: 100px"><b>Keadaan Psikososial :</b><br/>
                       <tr>
                         <td>
                           <b>BAK : </b>{{json_decode($item->menstruasi,true)['BAK']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Warna : </b>{{json_decode($item->menstruasi,true)['warna']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>BAB : </b>{{json_decode($item->menstruasi,true)['banyak']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>
                 <tr>
                  <td rowspan="8" style="width: 100px"><b>Riwayat Kehamilan Dan Persalinan :</b><br/>
                     <tr>
                       <td>
                         <b>Tempat Persalinan : </b>{{json_decode($item->menstruasi,true)['tempat']}}
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <b>Jenis : </b>{{json_decode($item->menstruasi,true)['jenis']}}
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <b>Penolong : </b>{{json_decode($item->menstruasi,true)['penolong']}}
                       </td>
                     </tr>
                     <tr>
                      <td>
                        <b>Penyulit Kehamilan : </b>{{json_decode($item->menstruasi,true)['penyulit']}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <b>Jenis Kelamin : </b>{{json_decode($item->menstruasi,true)['jkelamin']}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <b>BB : </b>{{json_decode($item->menstruasi,true)['bb']}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <b>Hidup/Mati : </b>{{json_decode($item->menstruasi,true)['h/p']}}
                      </td>
                    </tr>

                  </td>   
               </tr>



                  @endif  
                  <tr> 
                      <td colspan="2"><b>Keterangan</b> : {{$item->keterangan}} <br/></td>
                  </tr>    
                  <tr>
                      <td colspan="2"><b>Penginput</b> : {{baca_user($item->user_id)}}<br/></td>
                  </tr>
                  <tr>
                    <td colspan="2">{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>    
                  <tr>
                    <td colspan="2"><span class="pull-right">
                      <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-hapus-riwayat/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus Data" style="color:red"><i class="fa fa-trash"></i></a>
                      {{-- <a href="{{url('emr-soap-rawatinap/anamnesis/riwayat/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp; --}}
                    </span>
                    </td>
                  </tr> 
                     
                
                @endforeach
              </table>
              </div>
              </div> 
          </div>
          
          <br /><br />
        </div>
      </div>
      
      {{-- <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div> --}}
    </form>
  </div>

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