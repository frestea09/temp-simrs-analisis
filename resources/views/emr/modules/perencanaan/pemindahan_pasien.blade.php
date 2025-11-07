
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Pemindahan Pasien</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 2cm;
          margin-right: 2cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
      body {
        font-size: 11px;
      }

    </style>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-12 text-center">
        <table border=0 style="width:100%;">
          <tr>
            <td>
              <table border=0 style="width: 100%;"> 
                <tr>
                  <td style="width:20%;">
                    <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
                  </td>
                  <td style="text-align: center">
                    <b style="font-size:12px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                    <b style="font-size:12px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
                    <b style="font-size:12px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                    <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
                  </td>
                  <td style="width:40%;">

                    <table border=1 style="width:100%">
                      <tr>
                          <td style="text-align:left;">Nama</td>
                          <td style="text-align:left;">{{$pasien->nama}}</td>
                      </tr>
                      <tr>
                        <td style="text-align:left;">Tanggal Lahir</td>
                        <td style="text-align:left;">{{$pasien->tgllahir}}</td>
                      </tr>
                      <tr>
                        <td style="text-align:left;">No RM</td>
                        <td style="text-align:left;">{{$pasien->no_rm}}</td>
                      </tr>
                      <tr>
                        <td style="text-align:left;">NIK</td>
                        <td style="text-align:left;">{{$pasien->nik}}</td>
                      </tr>
                    </table>  
        
                  </td>
                </tr>
              </table> 
            </td>
          </tr>
           <tr>
              <td style="text-align:center;">
                <br>
                <h1 style="font-size:17px;"><b><u>CATATAN PEMINDAHAN PASIEN DARI/ANTAR RUANGAN</u></b></h1>
              </td>
            </tr>
        
         

        </table>

        <br>

        <table border=1 style="width:100%;">
            <tr>
              <td style="text-align:center;"><b>SITUATION</b></td>
            </tr>
            <tr>
              <td>
                <table style="width:100%;">
                  <tr>
                    <td style="width:25%;"><span>Tiba Di Ruangan</span></td>
                    <td style="width:25%;"><span>: {{@$cetak->situation->di_ruangan}}</span></td>
                    <td style="width:25%;">Dari Ruangan</td>
                    <td style="width:25%;">: {{@$cetak->situation->dari_ruangan}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td style="width: 15%">Tanggal</td>
                    <td style="width: 15%">: {{@$cetak->situation->tgl_masuk}}</td>
                    <td style="width: 15%">Pukul</td>
                    <td style="width: 15%">: {{@$cetak->situation->jam_masuk}}</td>
                    <td style="width: 15%">Diagnosa</td>
                    <td style="width: 15%">: {{@$cetak->situation->diagnosa}}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%">Dokter</td>
                    <td style="width: 15%">{{@baca_dokter(@$cetak->situation->dokter_perawat)}}</td>
                  </tr>
                 
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table  style="width:100%;">
                  <tr>
                    <td style="width:60%;"><span>Pasien / keluarga sudah di jelaskan diagnosa yang jelas</span></td>
                    <td style="width:20%;"><span><input type="checkbox" {{@$cetak->situation->dijelaskan == 'on' ? 'checked' : ''}}>Ya</span></td>
                    <td style="width:20%;"><input type="checkbox" {{!isset($cetak->situation->dijelaskan) ? 'checked' : ''}}>Tidak</td>
                  </tr>
                  <tr>
                    <td style="width:60%;"><span>Masalah Keperawatan yang utama saat ini</span></td>
                    <td style="width:20%;"><span>: {{@$cetak->situation->masalah_keperawatan}}</span></td>
                    <td style="width:20%;"></td>
                  </tr>
                  <tr>
                    <td style="width:60%;"><span>Prosedur pembedahan yang akan/sudah di lakukan</span></td>
                    <td style="width:20%;"><span>: {{@$cetak->situation->prosedur_pembedahan}}</span></td>
                  </tr>
                </table>
              </td>
            </tr>
        </table>
        <br>
        <br>
        <table border=1 style="width:100%;">
          <tr>
            <td style="text-align:center;"><b>ASESMENT</b></td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td style="width:25%;"><span>Observasi terakhir pukul</span></td>
                  <td style="width:25%;">: {{@$cetak->assesment->observasi_akhir}}</td>
                  <td style="width:25%;"></td>
                  <td style="width:25%;"></td>
                </tr>
                <tr>
                  <td style="width:25%;"><span>GCS:</span></td>
                  <td style="width:25%;">{{@$cetak->assesment->gcs}}(e/m/v)</td>
                  <td style="width:25%;">Pupil dan reaksi cahaya : </td>
                  <td style="width:25%;">{{@$cetak->assesment->pupil_cahaya_kanan}} <b>(Kanan)</b></td>
                  <td style="width:25%;">{{@$cetak->assesment->pupil_cahaya_kiri}} <b>(Kiri)</b></td>
                </tr>
                <tr>
                  <td style="width:25%;"><span>TD: {{@$cetak->assesment->tekanan_darah}}mmHg</span></td>
                  <td style="width:25%;">N: {{@$cetak->assesment->nadi}}x/mnl</td>
                  <td style="width:25%;">RP: {{@$cetak->assesment->rp}}</td>
                  <td style="width:25%;">SPO2: {{@$cetak->assesment->spo2}}%</td>
                  <td style="width:25%;">Suhu: {{@$cetak->assesment->suhu}}C</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td style="width:25%; text-align: left;"><span>Diet/Nutrisi :</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->oral) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">oral</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->ngt) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">NGT</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->cairan) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Balasan Cairan</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->diet) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Diet Khusus</td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span></span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->puasa) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Puasa Jam</td>
                  <td style="width:5%; text-align: left;">{{@$cetak->assesment->puasa_jam}}</td>
                  <td style="width:20%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>BAB :</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->bab == 'normal' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Normal</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->bab == 'ileustomy/coloslomy' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Ileusomy</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->bab == 'inkonsistensiaurin' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Inkonsestia</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->bab == 'inkonsistensiaalvin' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Alvin</td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>BAK :</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->bak->normal) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Normal</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->kateter) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Kateter</td>
                  <td style="width:5%; text-align: left;">{{$cetak->assesment->kateter->jenis_kateter}}</td>
                  <td style="width:20%; text-align: left;">No Kateter : {{$cetak->assesment->kateter->no_kateter}}</td>
                  <td style="width:5%; text-align: left;">Tgl Psg.</td>
                  <td style="width:20%; text-align: left;">{{@$cetak->tgl_pasang}}</td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>Transfer/Mobiliasi:</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->transfer == 'mandiri' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Mandiri</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->transfer == 'dibantusebagian' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Dibantu Sebagian</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->transfer == 'dibantupenuh' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Dibantu Penuh</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>Mobiliasi:</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->mobilisasi == 'jalan' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Jalan</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->mobilisasi == 'tirahbaring' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Baring</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->mobilisasi == 'duduk' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Duduk</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>Gangguan Indra:</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->gangguan_indra == 'tidak_ada' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Tdk Ada</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->gangguan_indra == 'penciuman' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">penciuman</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->gangguan_indra == 'bicara' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">bicara</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->gangguan_indra == 'penglihatan' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Melihat</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->gangguan_indra == 'pendengaran' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Mendengar</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->gangguan_indra == 'perabaan' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Perabaan</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>Alat yg di gunakan:</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->alat_bantu == 'normal' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Tdk Ada</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->alat_bantu == 'gigi_palsu' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">gigi palsu</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->alat_bantu == 'kaca_mata' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">kaca mata</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{@$cetak->assesment->alat_bantu == 'alat_bantu_registrasi' ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">alat bantu dengar</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                <tr>
                  <td style="width:25%; text-align: left;"><span>Infus:</span></td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{isset($cetak->assesment->infus->tidak) ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Tidak</td>
                  <td style="width:5%; text-align: left;"><input type="checkbox" {{$cetak->assesment->infus->ya ? 'checked' : ''}}></td>
                  <td style="width:20%; text-align: left;">Ya</td>
                  <td style="width:20%; text-align: left;">Lokasi</td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;">: {{@$cetak->assesment->infus->ya->lokasi}}</td>
                </tr>
                <tr>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:5%; text-align: left;"></td>
                  <td style="width:20%; text-align: left;" colspan="2">Tanggal Pemasangan</td>
                  <td style="width:5%; text-align: left;" colspan="3">: {{@$cetak->assesment->infus->ya->tgl_pasang}}</td>
                  <td style="width:20%; text-align: left;"></td>
                </tr>
                
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td>hal-hal istimewa pasien</td>
                  <td>:{{@$cetak->assesment->hal_istimewa}}</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td style="width:25">Tindakan/kebutuhan khusus</td>
                  <td style="width:75">: {{@$cetak->assesment->tindakan}}</td>
                  {{-- <td style="width:25"><input type="checkbox"></td>
                  <td style="width:25">protokol resiko jatuh</td> --}}
                </tr>
                {{-- <tr>
                  <td style="width:25"><input type="checkbox"></td>
                  <td style="width:25">protokol resrain</td>
                  <td style="width:25"><input type="checkbox"></td>
                  <td style="width:25">perawatan luka</td>
                </tr> --}}
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td style="width:25">Peralatan Khusus yang di perlukan</td>
                  <td style="width:75">: {{@$cetak->assesment->peralatan_khusus}}</td>
                </tr>               
              </table>
            </td>
          </tr>
      </table>
        <br>
        <br>
        <table border=1 style="width:100%;">
          <tr>
            <td style="text-align:center;"><b>BACKGROUND</b></td>
          </tr>
          <tr>
            <td>
              <table  style="width:100%;">
                <tr>
                  <td style="width:40%;"><span>Riwayat alergi/obat</span></td>
                  <td style="width:30%;"><span><input type="checkbox" {{isset($cetak->background->alergi->ada) ? 'checked' : ''}}>Ya, nama obat: {{@$cetak->background->alergi->nama}}</span></td>
                  <td style="width:30%;"><input type="checkbox" {{!isset($cetak->background->alergi->ada) ? 'checked' : ''}}>Tidak</td>
                </tr>
                <tr>
                  {{-- {{dd(, @$cetak->background->intervensi, @$cetak->background->hasil_investigasi)}} --}}
                  <td style="width:40%;"><span>Riwayat Reaksi</span></td>
                  <td style="width:30%;">:  {{@$cetak->background->riwayat_reaksi}}</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:40%;"><span>Intervensi Medic / Keperawatan</span></td>
                  <td style="width:30%;">:  {{@$cetak->background->intervensi}}</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:40%;"><span>Hasil Investigasi Abnormal</span></td>
                  <td style="width:30%;">:  {{@$cetak->background->hasil_investigasi}}</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:40%;"><span>Kewaspadaan</span></td>
                  <td style="width:30%;">:  {{@$cetak->background->kewaspadaan}}</td>
                  <td style="width:30%;"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>



        <br>
        <br>


        <table border=1 style="width:100%;">
          <tr>
            <td style="text-align:center;"><b>REKOMENDATION</b></td>
          </tr>
          <tr>
            <td>
              <table  style="width:100%;">
                <tr>
                  <td style="width:30%;"><span>konsultasi</span></td>
                  <td style="width:40%;">: {{@$cetak->recomendation->konsultasi}}</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:30%;"><span>Terapi</span></td>
                  <td style="width:40%;">: {{@$cetak->recomendation->terapi}}</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:30%;"><span></span></td>
                  <td style="width:40%;">:</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:30%;"><span></span></td>
                  <td style="width:40%;">:</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:30%;"><span></span></td>
                  <td style="width:40%;">:</td>
                  <td style="width:30%;"></td>
                </tr>
                <tr>
                  <td style="width:30%;"><span></span></td>
                  <td style="width:40%;">:</td>
                  <td style="width:30%;"></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td style="width:40%;">Rencana Pemeriksaan lab/radiologi</td>
                  <td style="width:60%;">:  {{@$cetak->recomendation->rencana_pemeriksaan}}</td>
                </tr>
                <tr>
                  <td style="width:40%;">Rencana Tindakan Lebih Lanjut</td>
                  <td style="width:60%;">:  {{@$cetak->recomendation->rencana_tindakan}}</td>
                </tr>
                <tr>
                  <td style="width:40%;">Kebutuhan Transfer Pasien</td>
                  <td style="width:60%;">:  {{@$cetak->recomendation->kebutuhan_transfer_pasien}}</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width:100%;">
                <tr>
                  <td style="width:25%;"></td>
                  <td style="width:25%;"><input type="checkbox" {{isset($cetak->recomendation->derajat0) ? 'checked' : ''}}>derajat 0</td>
                  <td style="width:25%;"></td>
                  <td style="width:25%;"><input type="checkbox" {{isset($cetak->recomendation->derajat1) ? 'checked' : ''}}>derajat 1</td>
                </tr>
                <tr>
                  <td style="width:25%;"></td>
                  <td style="width:25%;"><input type="checkbox" {{isset($cetak->recomendation->derajat2) ? 'checked' : ''}}>derajat 2</td>
                  <td style="width:25%;"></td>
                  <td style="width:25%;"><input type="checkbox" {{isset($cetak->recomendation->derajat3) ? 'checked' : ''}}>derajat 3</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <br>
              <br>
              Note: Obat Barang, Dokumen, Dokumen yang di sertakan:
              <br>
              <br>
              <table style="width:100%;">
                 <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->hasil_permintaan) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Hasil/permintaan</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->admission) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Admision</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->lab) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Laboratorium</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->formulir_konsultasi_spesialis) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Formulir konsul spesialis</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->foto) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Foto / X-ray</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->echo) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Echo</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->ct) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">CT-Scan</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->form_rawat_inap) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Form Rawat Inap</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->usg) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">USG</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->konfirmasi_rmo) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Konfirmasi dr.RMO</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->mri_mra) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">MRI/MRA</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->ecg) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">ECG</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->konfirmasi_spesialis) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Konfirmasi spesialis</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->gelang_nama) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Gelang Nama</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->catatan_integrasi) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Catatan Terintegrasi</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->imr) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">IMR</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->rujukan_dari_dokter) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Rujukan Dokter/RS</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->obat_obatan) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Obatan-obatan</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->konfirmasi_spesialis) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Konfirmasi spesialis</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->gelang_nama) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Gelang Nama</td>
                </tr>
                <tr>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->konfirmasi_bo_tindakan_cito) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Konfirmasi BO</td>
                  <td style="width:5%;"><input type="checkbox" {{isset($cetak->recomendation->disertakan->informasi_concent) ? 'checked' : ''}}></td>
                  <td style="width:45%;text-align: left;">Inform Consent</td>
                </tr>
                <tr>
                  <td style="width:5%;"></td>
                  <td style="width:45%;text-align: left;">Observasi Tiba Di Ruangan:</td>
                  <td style="width:5%;">{{@$cetak->recomendation->obersarvasi_di_ruangan}}</td>
                  <td style="width:45%;text-align: left;"></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table border="1" style="width:100%;">
                <tr>
                 <td style="width:35%;text-align: center;height:20%">Di Setujui</td>
                 <td style="width:35%;text-align: center;height:20%">Di serahkan</td>
                 <td style="width:35%;text-align: center;height:20%">Di Terima</td>
               </tr>
               <tr>
                <td style="width:35%;text-align: center;">Pasien/Penanggung jawab</td>
                <td style="width:35%;text-align: center;">Perawat</td>
                <td style="width:35%;text-align: center;">Perawat Ruangan</td>
              </tr>
             </table>
            </td>
          </tr>
       </table>





        <style>

            .footer{
            padding-top: 20px;
            margin-left: 330px;
        }

        .table-border {
        border: 1px solid black;
        border-collapse: collapse;
        }

        </style>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>

