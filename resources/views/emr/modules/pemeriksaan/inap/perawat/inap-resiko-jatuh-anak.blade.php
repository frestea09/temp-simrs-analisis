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

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
input[type="time"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
</style>
@section('header')
<h1>Fisik</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/resiko-jatuh-anak-inap/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          
          {{-- Anamnesis --}}
          <h4 class="text-center"><b>PEMANTAUAN RESIKO JATUH HARIAN PASIEN ANAK SKALA HUMPTY DUMPTY</b></h4>
          <div class="col-md-12">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <thead>
                <tr>
                  <th class="text-center" style="width: 25%;">Parameter</th>
                  <th class="text-center" style="width: 30%;">Kriteria</th>
                  <th class="text-center" style="width: 5%;">Nilai</th>
                  <th class="text-center" style="width: 10%;">Skor 1</th>
                  <th class="text-center" style="width: 10%;">Skor 2</th>
                  <th class="text-center" style="width: 10%;">Skor 3</th>
                  <th class="text-center" style="width: 10%;">Skor 4</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="3">Umur</td>
                  <td>Dibawah 3 Tahun</td>
                  <td class="text-center">4</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][Umur][1]" value="{{ @$pemeriksaandalam['skala']['Umur']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][Umur][2]" value="{{ @$pemeriksaandalam['skala']['Umur']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][Umur][3]" value="{{ @$pemeriksaandalam['skala']['Umur']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][Umur][4]" value="{{ @$pemeriksaandalam['skala']['Umur']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>3-7 Tahun</td>
                  <td class="text-center">3</td>
                </tr>
                <tr>
                  <td>7-14 Tahun</td>
                  <td class="text-center">2</td>
                </tr>

                <tr>
                  <td rowspan="2">Jenis Kelamin</td>
                  <td>Laki-Laki</td>
                  <td class="text-center">2</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][jenisKelamin][1]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][jenisKelamin][2]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][jenisKelamin][3]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][jenisKelamin][4]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>Perempuan</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="4">Diagnosa</td>
                  <td>Kelainan Neorologis</td>
                  <td class="text-center">4</td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][diagnosa][1]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][diagnosa][2]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][diagnosa][3]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][diagnosa][4]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Perubahan Oksigenasi (Masalah Saluran Nafas, Dehidrasi, Anemia, Anoreksia, Sinkop / Sakit Kepala, dll)
                  </td>
                  <td class="text-center">3</td>
                </tr>
                <tr>
                  <td>Kelainan Psikis Perilaku</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>Diagnosa Lain</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="4">Faktor Lingkungan</td>
                  <td>Riwayat jatuh dari tempat tidur saat bayi anak</td>
                  <td class="text-center">4</td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][faktorLingkungan][1]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][faktorLingkungan][2]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][faktorLingkungan][3]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][faktorLingkungan][4]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Pasien menggunakan alat bantu/box
                  </td>
                  <td class="text-center">3</td>
                </tr>
                <tr>
                  <td>Pasien berada di tempat tidur</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>Diluar ruang rawat</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="3">Respon terhadap operasi/obat penenang/efek anestesi</td>
                  <td>Dalam 0 - 24 jam</td>
                  <td class="text-center">3</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][responOperasi][1]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][responOperasi][2]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][responOperasi][3]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][responOperasi][4]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>Dalam 25 - 48 jam</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>> 48 jam</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="3">Penggunaan obat</td>
                  <td>
                    Bermacam-macam obat digunakan obat sedative, hipnotik, barbiturate, fenotiazin, antidepresan, laksatif/diuretic, narkotik
                  </td>
                  <td class="text-center">3</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][penggunaanObat][1]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][penggunaanObat][2]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][penggunaanObat][3]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][penggunaanObat][4]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>Salah satu dari pengobatan di atas</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>Pengobatan lain</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Jumlah skor Humpty dumpty</td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId1" name="pemeriksaandalam[skala][total][skor][1]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['1'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId2" name="pemeriksaandalam[skala][total][skor][2]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['2'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId3" name="pemeriksaandalam[skala][total][skor][3]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['3'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId4" name="pemeriksaandalam[skala][total][skor][4]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['4'] }}" readonly>
                  </td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Tanggal dan jam</td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId1" name="pemeriksaandalam[skala][total][tanggal][1]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['1'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId2" name="pemeriksaandalam[skala][total][tanggal][2]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['2'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId3" name="pemeriksaandalam[skala][total][tanggal][3]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['3'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId4" name="pemeriksaandalam[skala][total][tanggal][4]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['4'] }}">
                  </td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Nama Penilai</td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId1" name="pemeriksaandalam[skala][total][penilai][1]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['1'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId2" name="pemeriksaandalam[skala][total][penilai][2]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['2'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId3" name="pemeriksaandalam[skala][total][penilai][3]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['3'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId4" name="pemeriksaandalam[skala][total][penilai][4]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['4'] }}">
                  </td>
                </tr>


              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-right">Keterangan</td>
                  <td colspan="4">
                    Skor resiko jatuh (skor minimum 7 dan skor maksimum 23)
                    <br>
                    Skor : <br>
                    7-11 = Resiko rendah untuk jatuh<br>
                    >12 = Resiko tinggi untuk jatuh<br>
                  </td>
                </tr>
              </tfoot>
            </table>

          </div>
 
          <br /><br />
        </div>
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
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
        $("#date_dengan_tanggal").attr('', true);  
         
  </script>
   <script>

    function totalResikoJatuhAnak1(){
      var arr = document.getElementsByClassName('resikoJatuhAnak1');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId1').value = tot;
    }
    function totalResikoJatuhAnak2(){
      var arr = document.getElementsByClassName('resikoJatuhAnak2');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId2').value = tot;
    }
    function totalResikoJatuhAnak3(){
      var arr = document.getElementsByClassName('resikoJatuhAnak3');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId3').value = tot;
    }
    function totalResikoJatuhAnak4(){
      var arr = document.getElementsByClassName('resikoJatuhAnak4');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId4').value = tot;
    }
    </script>
  @endsection