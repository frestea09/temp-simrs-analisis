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
</style>
@section('header')
    <h1>Operasi</h1>
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/laporan-operasi/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
                <div class="row">
                  @if ($source === 'emr')
                      @include('emr.modules.addons.tabs')
                  @else
                      @include('emr.modules.addons.tab-operasi')
                  @endif
                    <div class="col-md-12">
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>

                        <div class="col-md-12">
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                                        <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($riwayats) == 0)
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                                        </tr>
                                    @endif
                                    @foreach ($riwayats as $index => $riwayat)
                                        <tr>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                            </td>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                              
                                                   <button type="button" class="btn btn-primary" data-index="{{ $index }}" onclick="previewLaporan(event)">
                                                    <i class="fa fa-eye"></i> Preview & Print
                                                  </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @if ($source !== 'emr')
                        <div class="col-md-12">
                          <h4 style="text-align: center;"><b>LAPORAN OPERASI ODS</b></h4>
                        </div>
                        
                        <div class="col-md-12">
                          <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Ruang Operasi</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[ruangOperasi]" value="{{ @$asessment['ruangOperasi']}}" />
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Kamar</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[kamar]" value="{{ @$asessment['kamar']}}" />
                                  </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">Sifat</td>
                                <td style="width:30%;">
                                    <div style="display: flex; flex-flow: column">
                                        <div style="width:100%;">
                                          <label for="sifat_1">
                                            <input class="form-check-input"
                                                name="fisik[sifat]" id="sifat_1"
                                                type="radio" value="Cito"  {{ @$asessment['sifat'] == 'Cito' ? 'checked' : '' }} >
                                            Cito
                                          </label>
                                        </div>
                                        <div style="width:100%;">
                                          <label for="sifat_2">
                                            <input class="form-check-input"
                                                name="fisik[sifat]" id="sifat_2"
                                                type="radio" value="Terencana"  {{ @$asessment['sifat'] == 'Terencana' ? 'checked' : '' }} >
                                            Terencana
                                          </label>
                                        </div>
                                    </div>
                                </td>
                                <td style="width:20%; font-weight:bold;">Tanggal Operasi</td>
                                <td style="width:30%;">
                                    <input type="text" class="form-control datepicker" name="fisik[tglOperasi]" value="{{ @$asessment['tglOperasi']}}" />
                                </td>
                              </tr>
                              <tr>
                                <td style="font-weight:bold;">Pembedah</td>
                                <td>
                                  <select name="fisik[pembedah]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dokters as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['pembedah'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="font-weight:bold;">Ahli Anestesi</td>
                                <td>
                                  <select name="fisik[ahliAnestesi]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dokters as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['ahliAnestesi'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td style="font-weight:bold;">Asisten I</td>
                                <td>
                                  <select name="fisik[asisten1]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['asisten1'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="font-weight:bold;">Asisten II</td>
                                <td>
                                  <select name="fisik[asisten2]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['asisten2'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td style="font-weight:bold;">Perawat Instrumen</td>
                                <td>
                                  <select name="fisik[perawat_instrumen]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['perawat_instrumen'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="font-weight:bold;">Perawat Anestesi</td>
                                <td>
                                  <select name="fisik[perawat_anestesi]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['perawat_anestesi'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Jenis Anestesi</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[jenisAnestesi]" value="{{ @$asessment['jenisAnestesi']}}" />
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Obat-obatan Anestesi</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[obatAnestesi]" value="{{ @$asessment['obatAnestesi']}}" />
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Diagnosa Pra Bedah</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[diagnosaPraBedah]" value="{{ @$asessment['diagnosaPraBedah']}}" />
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Indikasi Operasi</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[indikasiOperasi]" value="{{ @$asessment['indikasiOperasi']}}" />
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Diagnosis Pasca Bedah</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[diagnosaPascaBedah]" value="{{ @$asessment['diagnosaPascaBedah']}}" />
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Jenis Operasi</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[jenisOperasi]" value="{{ @$asessment['jenisOperasi']}}" />
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Desinfeksi kulit dengan</td>
                                  <td>
                                    <input type="text" class="form-control" name="fisik[desinfeksi]" value="{{ @$asessment['desinfeksi']}}" />
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Jaringan Yang di Eksisi</td>
                                  <td>
                                    <input type="text" class="form-control" name="fisik[jaringanEksisi]" value="{{ @$asessment['jaringanEksisi']}}" />
                                    <br>
                                    Dikirim ke PA
                                    <div style="display: flex; flex-flow: column">
                                      <div style="width:100%;">
                                        <label for="dikirimKePA_1">
                                          <input class="form-check-input"
                                              name="fisik[dikirimKePA]" id="dikirimKePA_1"
                                              type="radio" value="Ya"  {{ @$asessment['dikirimKePA'] == 'Ya' ? 'checked' : '' }} >
                                          Ya
                                        </label>
                                      </div>
                                      <div style="width:100%;">
                                        <label for="dikirimKePA_2">
                                          <input class="form-check-input"
                                              name="fisik[dikirimKePA]" id="dikirimKePA_2"
                                              type="radio" value="Tidak"  {{ @$asessment['dikirimKePA'] == 'Tidak' ? 'checked' : '' }} >
                                          Tidak
                                        </label>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                        
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Jam Operasi Dimulai</td>
                                  <td>
                                      <input type="time" name="fisik[jamOperasiMulai]" class="form-control" value="{{ @$asessment['jamOperasiMulai']}}">
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Lama Operasi Berlangsung</td>
                                  <td>
                                      <input type="text" name="fisik[lamaOperasi]" class="form-control" value="{{ @$asessment['lamaOperasi']}}">
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Jam Operasi Selesai</td>
                                  <td>
                                      <input type="time" name="fisik[jamOperasiSelesai]" class="form-control" value="{{ @$asessment['jamOperasiSelesai']}}">
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Jenis bahan yang dikirim ke lab untuk pemeriksaan</td>
                                  <td>
                                      <input type="text" name="fisik[jenisBahan]" class="form-control" value="{{ @$asessment['jenisBahan']}}">
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Macam Sayatan</td>
                                  <td>
                                      <input type="text" name="fisik[macamSayatan]" class="form-control" value="{{ @$asessment['macamSayatan']}}">
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Posisi penderita</td>
                                  <td>
                                      <input type="text" name="fisik[posisiPenderita]" class="form-control" value="{{ @$asessment['posisiPenderita']}}">
                                  </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">Singkatan kelainan yang ditemukan</td>
                                <td colspan="3">
                                  <textarea name="fisik[singkatanKelainan]" class="form-control" style="resize: vertical;" rows="5">{{ @$asessment['singkatanKelainan'] }}</textarea>
                                </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">Teknik Operasi dan Temuan Intra Operasi</td>
                                <td colspan="3">
                                  <textarea name="fisik[teknikOperasi]" class="form-control" style="resize: vertical;" rows="5">{{ @$asessment['teknikOperasi'] }}</textarea>
                                </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">Instruksi Anestesi</td>
                                <td colspan="3">
                                  <textarea name="fisik[instruksiAnestesi]" class="form-control" style="resize: vertical;" rows="5">{{ @$asessment['instruksiAnestesi'] }}</textarea>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" style="font-weight: bold;">Instruksi Pasca Bedah</td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">1. Kontrol Nadi/Tensi/Pernapasan/Suhu</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][kontrol]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['kontrol']}}">
                                </td>
                                <td style="width:20%; font-weight:bold;">5. Obat-obatan</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][obat_obatan]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['obat_obatan']}}">
                                </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">2. Puasa</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][puasa]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['puasa']}}">
                                </td>
                                <td style="width:20%; font-weight:bold;">6. Ganti balutan</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][gantiBalutan]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['gantiBalutan']}}">
                                </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">3. Drain</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][drain]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['drain']}}">
                                </td>
                                <td style="width:20%; font-weight:bold;">7. Lain-lain</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][lainLain]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['lainLain']}}">
                                </td>
                              </tr>
                              <tr>
                                <td style="width:20%; font-weight:bold;">4. Infus</td>
                                <td>
                                    <input type="text" name="fisik[instruksi_pasca_bedah][infus]" class="form-control" value="{{ @$asessment['instruksi_pasca_bedah']['infus']}}">
                                </td>
                                <td style="width:20%; font-weight:bold;">&nbsp;</td>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                        
                          </table>
                        </div>

                        <br /><br />
                    @endif
                    </div>
                </div>

            @if ($source !== 'emr')
                <div class="col-md-12 text-right">
                    <button class="btn btn-success">Simpan</button>
                </div>
            @endif
            </form>
        </div>
    @endsection
 <!-- Modal Preview -->
    <div id="previewModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Preview Laporan Operasi Rawat Inap</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="previewContent">
                        <!-- Isi preview laporan akan dimasukkan di sini -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="printLaporan()">Cetak</button>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script type="text/javascript">
            $(".skin-red").addClass("sidebar-collapse");
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab
                // alert(target);
            });
            $('.select2').select2();
            $("#date_tanpa_tanggal").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $("#date_dengan_tanggal").attr('', true);
              function previewLaporan($inputindex) {
        // Ambil data dari form input
               let index = event.target.getAttribute('data-index');

            // Pastikan index tidak undefined
            if (index === undefined) {
                console.error("Index is undefined.");
                return;
            }
            var assesment = @json($asessment);  
            var dokter = @json($dokters);
            var smf = @json($smf);
            var pasien = @json($pasien);  
            var reg = @json($reg); 
            // Ambil data riwayat berdasarkan index
            var riwayats = @json($riwayats); 
            var dataFisikOperasi = JSON.parse(riwayats[index]["fisik"]) 
            var smfTemp = @json($smfTemp); 
            var jenisAnastesiTemp = (dataFisikOperasi && dataFisikOperasi.jenisAnestesi) ? Object.values(dataFisikOperasi.jenisAnestesi) : [];

        let tanggalOperasi = document.querySelector('input[name="fisik[tanggalOperasi]"]')?.value || ".....";
        let ruangOperasi = document.querySelector('input[name="fisik[ruangOperasi]"]')?.value || ".....";
        let kamar = document.querySelector('input[name="fisik[kamar]"]')?.value || ".....";
        let dpjpBedah = document.querySelector('select[name="fisik[dpjpBedah]"]')?.value || ".....";
        let perawatInstrumen = document.querySelector('select[name="fisik[perawatInstrumen]"]')?.value || ".....";
        let jenisOperasi = document.querySelector('input[name="fisik[jenisOperasi]"]')?.value || ".....";
        let diagnosisPostOperasi = document.querySelector('input[name="fisik[diagnosisPostOperasi]"]')?.value || ".....";
        let instruksiPascaBedah = document.querySelector('textarea[name="fisik[instruksiPascaBedah]"]')?.value || ".....";
        var tgllahir = pasien["tgllahir"];  // Menggunakan template literal

        // Fungsi untuk format tanggal menjadi dd-mm-yyyy
        function formatDate(dateString) {
            var date = new Date(dateString);  // Membuat objek Date dari string tanggal
            var day = date.getDate();  // Mendapatkan hari (tanggal)
            var month = date.getMonth() + 1;  // Mendapatkan bulan (bulan dimulai dari 0, jadi tambahkan 1)
            var year = date.getFullYear();  // Mendapatkan tahun

            // Menambahkan leading zero jika hari atau bulan kurang dari 10
            day = (day < 10) ? '0' + day : day;
            month = (month < 10) ? '0' + month : month;

            // Mengembalikan tanggal dalam format dd-mm-yyyy
            return day + '-' + month + '-' + year;
        }
      function calculateAge(birthdate, currentDate) {
            // Memisahkan tanggal dan waktu pada created (karena ada waktu pada created_at)
            var current = new Date(currentDate.split(' ')[0]);  // Ambil hanya bagian tanggal (yyyy-mm-dd)
            var birth = new Date(birthdate);  // Membuat objek Date untuk tanggal lahir

            // Jika tanggal lahir lebih besar dari tanggal saat ini, umur harus 0
            if (birth > current) {
                return 0;
            }

            // Menghitung umur berdasarkan tahun
            var age = current.getFullYear() - birth.getFullYear();
            var month = current.getMonth() - birth.getMonth();  // Menghitung selisih bulan
            var day = current.getDate() - birth.getDate();  // Menghitung selisih hari

            // Menyesuaikan umur jika bulan atau hari belum tercapai
            if (month < 0 || (month === 0 && day < 0)) {
                age--;  // Kurangi 1 tahun jika bulan atau hari belum tercapai
            }

            return age;  // Mengembalikan umur
        }

    // Format tanggal lahir
     var formattedDate = formatDate(tgllahir);
      var umur = calculateAge(tgllahir, reg['created_at']);
      var jenisAnastesi = dataFisikOperasi?.jenisAnestesi ;
      const now = new Date();

      // Format tanggal dalam format dd-mm-yyyy
      const day = ("0" + now.getDate()).slice(-2); // Menambahkan leading zero jika hari kurang dari 10
      const month = ("0" + (now.getMonth() + 1)).slice(-2); // Menambahkan leading zero jika bulan kurang dari 10
      const year = now.getFullYear();

      // Format jam dalam format hh:mm
      const hours = ("0" + now.getHours()).slice(-2); // Menambahkan leading zero jika jam kurang dari 10
      const minutes = ("0" + now.getMinutes()).slice(-2); // Menambahkan leading zero jika menit kurang dari 10

      // Menyusun tanggal dan jam dalam format yang diinginkan
      const formattedDateTemp = `${day}-${month}-${year}`;
      const formattedTime = `${hours}:${minutes}`;
        // Membuat HTML untuk preview
      let laporanHTML = `
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasi</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0.5cm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        .center-text {
            text-align: center;
            font-weight: bold;
        }
        .right-text {
            text-align: right;
            font-weight: bold;
        }
        .container {
            padding-top: 1%;
            padding-bottom: 1%;
        }
        .container-to-right {
            text-align: right;
            padding: 1% 1%;
        }
        .container-medium {
            width: 50%;
            padding: 1%;
        }
        .container-border {
            border: 1px solid black;
        }
        .container-custom-left {
            padding-top: 1%;
            padding-left: 0.8%;
        }
        .container-custom-bottom {
            padding-bottom: 7%;
        }
        .size-medium {
            width: 40%;
        }
        @media print {
          .page-break {
              page-break-before: always;
          }
    .hide-on-print {
        visibility: hidden;
    }

      }
    </style>
</head>
<body>
    <table>
        <tr >
            <td rowspan="3" class="container-border" style="width: 20%; text-align: center; padding : 2%; ">    
              <img src="{{ asset('images/1679985924Lambang_Kabupaten_Bandung,_Jawa_Barat,_Indonesia.svg.png') }}" alt="Logo RSUD" style="width: 50%; height: auto;"><br/>
              <span  style="font-size : 60%; font-weight: bold;">RSUD OTO ISKANDAR DINATA</span><br/>
              <span style="font-size : 5px">Jl. Gading Tutuka, RT.01 RW.01, Kp, Cincin Kolot, Kec. Soreang, Kab. Bandung,
Jawa Barat</span>
            </td>
            <td colspan="2" class="center-text container-border" style="border-bottom : 0px white; padding-top : 2%">LAPORAN OPERASI</td>
            <td rowspan="3" class="container-border" style="width: 30%; padding-left : 1%; padding-right : auto;    padding-top : 2%;   font-size : 17px;">
                <span style="font-weight: bold;">No. RM</span> : ${riwayats[index]['pasien_id'] || ''}<br>
                <span style="font-weight: bold;">Nama</span> : ${pasien['nama'] || ''}  <span style="font-weight: normal;">${pasien['kelamin'] == "L" ? "L / <del>P</del>" : "<del>L</del> / P"} </span><br>
                <span style="font-weight: bold;">Tgl. lahir</span> : ${formattedDate || ''} <br>  <span style="font-weight: bold;">Umur</span> : ${umur}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center-text container-border" style="border-top : 0px white; ; padding-top : 2%;">SMF  ${smf[3]}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="container-to-right container-border" colspan="4" style="border-top : 0px white; border-bottom : 0px white; font-weight : bold;">Halaman 1 dari 2</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="container-medium container-border" colspan="2" style="font-weight : bold;">Ruang Operasi : <span style="font-weight : normal;">${dataFisikOperasi.ruangOperasi || ''}</span></td>
            <td class="container-medium container-border" colspan="2" style="font-weight : bold;">Kamar :  <span style="font-weight : normal;">${dataFisikOperasi.kamar || ''}</span></td>
        </tr>
        <tr>
            <td class="container-medium container-border" colspan="2" style="font-weight : bold;">Cito / Terencana :  <span style="font-weight : normal;">${dataFisikOperasi.sifat || ''}</span></td>
            <td class="container-medium container-border" colspan="2" style="font-weight : bold;">Tanggal Operasi:  <span style="font-weight : normal;">${dataFisikOperasi.tglOperasi || ''}</span></td>
        </tr>
        <tr>
            <td class="container-custom-left container-border" style="padding : 1%;  height : 4em; border-bottom : 0px white; font-weight : bold; ">Pembedah :<br/>  <span style="font-weight : normal;">${dataFisikOperasi.pembedah || ''}</span></td>
            <td class="container-border"   style="padding : 1%;  height : 4em; font-weight : bold;">Asisten I : <br/>  <span style="font-weight : normal;">${dataFisikOperasi.asisten1 || ''}</span></td>
            <td class="container-border" colspan="2"  style="padding : 1%;  height : 4em; border-bottom : 0px white; font-weight : bold;">Perawat instrumen:  <br/> <span style="font-weight : normal;">${dataFisikOperasi.perawat_instrumen || ''}</span></td>
        </tr>
        <tr>
            <td class="container-border" style="border-top : 0px white;"></td>
            <td class="container-border"  style="padding : 1%;  height : 4em; font-weight : bold;">Asisten II :<br/><span style="font-weight : normal;"> ${dataFisikOperasi.asisten2 || ''}</span></td>
            <td class="container-border"  style="border-top : 0px white;" colspan="2"></td>
        </tr>
        <tr>
            <td class="container-custom-left container-border" style="padding : 1%;  height : 4em; font-weight : bold;">Ahli Anestesi :  <span style="font-weight : normal;">${dataFisikOperasi.ahliAnestesi || ''}</span></td>
            <td class="container-border" style="padding : 1%;  height : 4em; font-weight : bold;">Jenis Anestesi :  <span style="font-weight : normal;">${jenisAnastesi }</span></td>
            <td class="container-border" colspan="2" style="padding : 1%;  height : 4em; font-weight : bold; border-bottom : 0px white;">Obat-obatan Anestesi :  <span style="font-weight : normal;">${dataFisikOperasi.obatAnestesi || ''}</span></td>
        </tr>
        
        <tr>
            <td class="container-custom-left container-border" style="padding : 1%;  height : 4em; font-weight : bold;" colspan="2">Perawat Anestesi :  <span style="font-weight : normal;">${dataFisikOperasi.perawat_anestesi || ''}</span></td>
            <td class="container-border" style="border-top : 0px white;" colspan="3"></td>
        </tr>
        <tr>
            <td class="container-custom-left container-border" colspan="2" style="padding : 1%; height : 4em; font-weight : bold;">Diagnosa Pra-Bedah :  <span style="font-weight : normal;">${dataFisikOperasi.diagnosaPraBedah || ''}</span></td>
            <td class="container-border" colspan="2" style="padding : 1%;  height : 4em; font-weight : bold;">Indikasi Operasi :  <span style="font-weight : normal;">${dataFisikOperasi.indikasiOperasi || ''}</span></td>
        </tr>
        <tr>
            <td class="container-custom-left container-border" colspan="2" style="padding : 1%;  height : 4em; font-weight : bold;">Diagnosa Pasca-Bedah :  <span style="font-weight : normal;">${dataFisikOperasi.diagnosaPascaBedah || ''}</span></td>
            <td class="container-border" colspan="2" style="padding : 1%;  height : 4em; font-weight : bold;">Jenis Operasi :  <span style="font-weight : normal;">${dataFisikOperasi.jenisOperasi || ''}</span></td>
        </tr>
        <tr>
            <td class="container-border" style="padding : 1%;  border-bottom : 0px white; font-weight : bold;">Desinfeksi kulit dengan : <span style="font-weight : normal;">${dataFisikOperasi.desinfeksi || ''}</span></td>
            <td class="container-border" style="padding : 1%; font-weight : bold;">Jaringan yang dieksisi : ${dataFisikOperasi.jaringanEksisi || ''}</td>
            <td class="container-border" colspan="2" rowspan="2" > <span  style="padding : 2%;  height : 4em; font-weight : bold;">GOL OPERASI : </span>
               
            </td>
        </tr>
        <tr>
            <td class="container-border" style="border-top : 0px white;"></td>
            <td class="container-border" style="padding : 1%; font-weight : bold;">Dikirim ke Bagian Patologi Anatomi: <br/> <input type="checkbox"  ${dataFisikOperasi.dikirimKePA == "Ya" ? "checked" : ""}> Ya <input type="checkbox"  ${dataFisikOperasi.dikirimKePA == "Tidak" ? "checked" : ""}> Tidak</td>
        </tr>
        <tr>
            <td colspan="3" class="container-border">
                <table style="width: 100%;">
                    <tr>
                        <td class="container-border" style="width: 33%; padding : 1%; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; border-right : 0px white; font-weight : bold;">Jam Operasi <span><br/></span> Dimulai :  <span style="font-weight : normal;">${dataFisikOperasi.jamOperasiMulai  || ''}</span></td>
                        <td class="container-border" style="width: 33%; padding : 1%; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; border-right : 0px white; font-weight : bold;">Jam Operasi <span><br/></span>  Selesai :  <span style="font-weight : normal;">${dataFisikOperasi.jamOperasiSelesai  || ''}</span></td>
                        <td class="container-border" style="width: 34%; padding : 1%; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; border-right : 0px white; font-weight : bold;">Lama Operasi <span><br/></span>  Berlangsung :  <span style="font-weight : normal;"> ${dataFisikOperasi.lamaOperasi  || ''}</span></td>
                    </tr>
                    <tr>
                        <td class="container-border" style="height: 30px; border-top : 0px white; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; border-right : 0px white;"> </td>
                        <td class="container-border" style="height: 30px; border-top : 0px white; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; border-right : 0px white;"></td>
                        <td class="container-border" style="height: 30px; border-top : 0px white; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; border-right : 0px white;"></td>
                    </tr>
                </table>
            </td>
          <td class="container-border" style="padding : 1%; font-weight : bold;">Jenis Bahan yang dikirim ke laboratorium untuk pemeriksaan  :  <span style="font-weight : normal;">${dataFisikOperasi.jenisBahan  || ''}</span></td>
        </tr>
        <tr>
            <td class="container-border" colspan="2" style="padding : 1%; height : 5em; font-weight : bold;">Macam Sayatan (bila perlu dengan gambar) :   <span style="font-weight : normal;">${dataFisikOperasi.macamSayatan  || ''}</span></td>
            <td class="container-border" colspan="2" style="padding : 1%; font-weight : bold;">Posisi Penderita (bila perlu dengan gambar) :  <span style="font-weight : normal;">${dataFisikOperasi.posisiPenderita  || ''}</span></td>
        </tr>
        <tr class="page-break" style="height : 30em;">
            <td class="container-border" colspan="4" style="padding : 1%;  border-bottom : 0px white; font-weight : bold;">Singkatan kelainan yang ditemukan dengan gambar (laporan lengkap lihat sebelah) : <span style="font-weight : normal;"> ${dataFisikOperasi.singkatanKelainan  || ''}</span></td>
        </tr>
        <tr>
            <td class="container-border" colspan="4" style="padding : 1%; border-top : 0px white; border-bottom : 0px white; font-weight : bold;">*) Coret yang tidak perlu, Beri Tanda contreng pada kotak kosong yang disediakan</td>
        </tr>
        <tr>
            <td class="container-border" colspan="4" style="padding : 1%; border-top : 0px white; font-weight : bold;">Keterangan : Lembar alat : Dokumen</td>
        </tr>
    </table>
    <br/>
    <table class="page-break">
          <tr >
            <td rowspan="3" class="container-border" style="width: 20%; text-align: center; padding : 2%; ">    
              <img src="{{ asset('images/1679985924Lambang_Kabupaten_Bandung,_Jawa_Barat,_Indonesia.svg.png') }}" alt="Logo RSUD" style="width: 50%; height: auto;"><br/>
              <span  style="font-size : 60%; font-weight: bold;">RSUD OTO ISKANDAR DINATA</span><br/>
              <span style="font-size : 5px">Jl. Gading Tutuka, RT.01 RW.01, Kp, Cincin Kolot, Kec. Soreang, Kab. Bandung,
Jawa Barat</span>
            </td>
            <td colspan="2" class="center-text container-border" style="border-bottom : 0px white; padding-top : 2%">LAPORAN OPERASI</td>
            <td rowspan="3" class="container-border" style="width: 30%; padding-left : 1%; padding-right : auto;    padding-top : 2%;   font-size : 17px;">
                <span style="font-weight: bold;">No. RM</span> : ${riwayats[index]['pasien_id'] || ''}<br>
                <span style="font-weight: bold;">Nama</span> : ${pasien['nama'] || ''}  <span style="font-weight: normal;">${pasien['kelamin'] == "L" ? "L / <del>P</del>" : "<del>L</del> / P"} </span><br>
                <span style="font-weight: bold;">Tgl. lahir</span> : ${formattedDate || ''} <br>  <span style="font-weight: bold;">Umur</span> : ${umur}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center-text container-border" style="border-top : 0px white; padding-bottom : 2%; padding-top : 2%;">SMF  ${smf[3]}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="container-to-right container-border" colspan="4" style="border-top : 0px white; border-bottom : 0px white; font-weight : bold;">Halaman 2 dari 2</td>
        </tr>
    </table>
    <table style="border : 1px solid black;">
        <tr style="text-align : center;">
            <td class="container-border" colspan="4" style="text-align : center; padding : 1%; border-top : 0px white; border-bottom : 0px white; border-left : 0px white; border-right : 0px white;  font-weight : bold;">
              <span>Laporan Operasi Lengkap (Riwayat perjalanan Operas yang terperinci dan lengkap)</span>
            </td>
        </tr>
        <tr style="display : flex; flex-direction : column; height : 25em; width : 100%; ">
             <td class="container-border" colspan="4" style="padding : 1%;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white;  text-align : left; font-weight : bold">
              <span style=" text-align: left;">Teknik Operasi dan Temuan Intra-Operasi :   <span style="font-weight : normal;">${dataFisikOperasi.teknikOperasi  || ''}</span></span>
            </td>
        </tr>
        <tr style="padding : 3em; height : 15em;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white;">
            <td class="container container-border" colspan="4" style="margin : 19px; padding : 1%; font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white;">Intruksi Anestesi :  <span style="font-weight : normal;">${dataFisikOperasi.instruksiAnestesi  || ''}</span></td>
        </tr>
        <tr class="page-break">
          <td class="container-medium container-border" colspan="2" style="font-weight : bold; border-bottom : 0px white; border-right : 0px white; ">Intruksi Pasca Bedah : </td>
          <td class="container-medium container-border" colspan="2" style="font-weight : bold; border-bottom : 0px white; border-left : 0px white; ">5. Obat-obatan :  <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.obat_obatan  || ''}</span></td>
          </tr>
          <tr>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; ">1. Kontrol Nadi/Tensi/Pernapasan/Suhu :  <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.kontrol  || ''}</span></td>
          </tr>
          <tr>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; ">2. Puasa :  <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.puasa  || ''}</span></td>
          </tr>
          <tr>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; ">3. Drain :  <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.drain  || ''}</span></td>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; ">6. Ganti Balutan :  <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.gantiBalutan  || ''}</span></td>
          </tr>
          <tr>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; ">4. Infus :   <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.infus  || ''}</span></td>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold;  border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; ">7. Lain-lain :  <span style="font-weight : normal;">${dataFisikOperasi.instruksi_pasca_bedah.lainLain  || ''}</span></td>
          </tr>
          <tr>
              <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; "></td>
          </tr>
          <tr>
              <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;  border-bottom : 0px white; border-left : 0px white;  border-right : 0px white; "></td>
          </tr>
          <tr>
              <td class="container" colspan="2" style="text-align: left; border-bottom : 0px white; border-top : 0px white; border-right : 0px white; font-weight : bold;">Pembuat Laporan</td>
              <td class="container" colspan="2" style="text-align: left; border-bottom : 0px white; border-top : 0px white; border-left : 0px white; font-weight : bold;">Soreang, ${formattedDateTemp} Jam ${formattedTime}</td>
          </tr>
           <tr>
              <td class="container" colspan="2" style="height : 7em; text-align: left; padding-top: 2%; border-top : 0px white;  border-bottom : 0px white; border-right  : 0px white;">${riwayats[index].tte ? riwayats[index].tte : "" }</td>
              <td class="container" colspan="2" style="height : 7em; text-align: left; padding-top: 2%; border-top : 0px white;  border-bottom : 0px white; border-left  : 0px white; ">${riwayats[index].tte ? riwayats[index].tte : "" }</td>
          </tr>
          <tr>
              <td class="container" colspan="2" style="text-align: left; border-top : 0px white; border-right  : 0px white; font-weight : bold;">${dataFisikOperasi.pembedah  || ''}</td>
              <td class="container" colspan="2" style="text-align: left; border-top : 0px white; border-left  : 0px white; font-weight : bold;">${dataFisikOperasi.pembedah  || ''}</td>
          </tr>
        <tr style="border-bottom : 0px white;">
            <td class="container-border" colspan="4" style="padding : 1%; border-top : 0px white; border-bottom : 0px white; font-weight : bold;">Keterangan : Lembar alat : Dokumen</td>
        </tr>
         <tr style="border-top : 0px white; border-left : 0px white; border-bottom :  0px white; ">
            <td class="container-border " colspan="4" style="padding : 1%; border-top : 0px white; font-weight : bold;"><span class="hide-on-print" style="color : white; font-weight : bold; border-bottom : 0px white; border-left  : 0px white; border-right : 0px white;">Keterangan : </span>Lembar Salinan : BPJS</td>
        </tr>
    </table>
</body>
</html>
        `;

        // Menampilkan laporan dalam modal
        document.getElementById('previewContent').innerHTML = laporanHTML;

        // Menampilkan modal
        $('#previewModal').modal('show');
    }

    // Fungsi untuk mencetak laporan
    function printLaporan() {
        let printContents = document.getElementById('previewContent').innerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        location.reload();
    }
        </script>
    @endsection
