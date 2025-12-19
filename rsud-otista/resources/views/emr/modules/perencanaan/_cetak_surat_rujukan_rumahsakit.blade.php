<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Rujukan Antar RS</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
   

    </style>
  </head>
  <body>
    @php
      $content = json_decode($cetak->rujukan_rs);
    @endphp
     <table border=0 style="width: 100%;"> 
        <tr>
          {{-- <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td> --}}
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          {{-- <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td> --}}
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;"><u>RUJUKAN PASIEN</u></h3>
              </td>
            </tr>
            {{-- <tr>
                <td style="text-align: center">
                    <span style="font-size:12px;">Nomor : {{ $cetak->nomor}} / RSUD-YANMED</span><br/>
                  </td>
            </tr> --}}
          </table>
          <br/>
          <table class="mb-5" border=0 style="width:100%; padding-bottom: 30px;">
            <tr>
                <td colspan="3" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang,{{date('d-M-Y')}}</td>
            </tr>
        </table>
          <table border=0 style="width: 100%;">
            <tr>
              <td><span>No RM</span></td>
              <td>: {{$pasien->no_rm}}</td>
            </tr>
            <tr>
              <td><span>Nama Pasien</span></td>
              <td>: {{$pasien->nama}}</td>
            </tr>
            <tr>
              <td ><span> Umur</span></td>
              <td>: {{@hitung_umur($pasien->tgllahir, 'Y')}}</td>
              <td></td>
            </tr>
            <tr>
                <td ><span> Tgl. Lahir</span></td>
                <td>: {{ date("d-m-Y", strtotime($pasien->tgllahir)) }}</td>
                {{-- <td><span>:</span></td> --}}
                <td></td>
              </tr>
            <tr>
                <td ><span> Jenis Kelamin</span></td>
                <td>: {{ ($pasien->kelamin == 'L') ? 'L' : 'P' }}</td>
                <td></td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Ruangan</span></td>
              <td>: {{@$content->ruangan}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Tanggal Masuk / Jam</span></td>
              <td>: {{@$content->tanggal_masuk}} / {{@$content->jam_masuk}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Rumah sakit Rujukan / Tujuan</span></td>
              <td>: {{@$content->rumah_sakit_tujuan}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Alasan Rujukan</span></td>
              <td>: {{@$content->alasan}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Dokter Penerima</span></td>
              <td>: {{@$content->dokter_penerima}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Dokter Perawat / Pendamping</span></td>
              <td>: {{@$content->dokter_perawat}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Diagnosa Medis</span></td>
              <td>: {{@$content->diagnosis}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Pengobatan / Tindakan</span></td>
              <td>: {{@$content->pengobatan}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Rencana Tindak Lanjut</span></td>
              <td>: {{@$content->rencana_tindak_lanjut}}</td>
            </tr>
            <tr>
              <td colspan="5" style="width:100%; text-align: start"><span><b>Keterangan Alat Medis Yang Digunakan</b></span></td>
            </tr>
            <tr>
              <td style="width:200px;"><span>IV Catch No:</span></td>
              <td>: {{@$content->iv_catch}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>DC No:</span></td>
              <td>: {{@$content->dc}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>NGT:</span></td>
              <td>: {{@$content->ngt}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Keterangan Penunjang:</span></td>
              <td>: {{@$content->keterangan_penunjang}}</td>
            </tr>
            <tr>
              <td colspan="5" style="width:100%; text-align: start"><span><b>Kondisi Pasien Saat Keluar Dari Rumah Sakit</b></span></td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Tanggal Keluar:</span></td>
              <td>: {{@$content->tanggal_keluar}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Riwayat Alergi:</span></td>
              <td>: {{@$content->riwayat_alergi}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Kesadaran:</span></td>
              <td>: {{@$content->kesadaran}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>GCS:</span></td>
              <td>: {{@$content->gcs}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>E:</span></td>
              <td>: {{@$content->e}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>M:</span></td>
              <td>: {{@$content->m}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>V:</span></td>
              <td>: {{@$content->v}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>BB:</span></td>
              <td>: {{@$content->bb}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>KG:</span></td>
              <td>: {{@$content->kg}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>TD:</span></td>
              <td>: {{@$content->td}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>HR:</span></td>
              <td>: {{@$content->ht}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>RR:</span></td>
              <td>: {{@$content->rr}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>Suhu:</span></td>
              <td>: {{@$content->suhu}}</td>
            </tr>
            <tr>
              <td style="width:200px;"><span>SpO2:</span></td>
              <td>: {{@$content->spo2}}</td>
            </tr>
          </table><br/>
          
         <div style="page-break-after: always"></div>
        <table border="0" style="width: 100%">
          <tr>
            <td colspan="5" style="width: 100%; text-align:  start"><span><b>Catatan Observasi Selama Dirawat</b></span></td>
          </tr>
            <tr>
              <td style="width:200px;"><span>Catatan:</span></td>
              <td>: {{@$content->catatan}}</td>
            </tr>
        </table>
        <br><br><br>
        <table border=0 style="width:100%">
             <tr>
                <td style="text-align: center">
                    Salam Sejawat<br/><br/><br/><br/>
                </td>
              </tr>
              <tr>
                <td style="text-align: center">
                    {{ baca_dokter($registrasi->dokter_id) }}
                </td>
              </tr>
        </table><br/>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">Petugas yang menyerahkan,<br/><br/><br/></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Petugas yang menerima,<br/><br/><br/></td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">({{ $content->petugas_yang_menyerahkan }})</td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">({{ $cetak->petugas_yang_menerima }})</td>
            </tr>

        </table>

        {{-- <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Selatpanjang,{{tanggalkuitansi(date('d-m-Y'))}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Dokter,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            
                <td colspan="4" scope="row" style="width:170px;"><br><br><br><br><br></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"><br><br><br><br><br>({{ baca_dokter($cetak->dokter_id) }})</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
    </table> --}}

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

