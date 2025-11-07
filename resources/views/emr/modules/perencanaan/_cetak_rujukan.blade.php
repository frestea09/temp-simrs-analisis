<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Pengantar Rawat Inap</title>
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
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;"><u>SURAT PENGANTAR RAWAT INAP</u></h3>
              </td>
            </tr>
            {{-- <tr>
                <td style="text-align: center">
                    <span style="font-size:12px;">Nomor : {{ $cetak->nomor}} / RSUD-YANMED</span><br/>
                  </td>
            </tr> --}}
          </table>
          <br/>
          <table border=0 style="width:100%">
            <tr>
                <td colspan="3" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang,{{date('d-M-Y')}}</td>
            </tr>
            <tr>
                <td colspan="3" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Kepada Yth : ......................<br></td>
            </tr>
        </table>
          <table border=0 style="width: 100%;">
            <tr>
              <td colspan="3">Yang bertanda tangan dibawah ini</td>
            </tr>
            <tr>
                <td><input type="checkbox" style="margin-left:10px;"></td> 
                <td>Tempat tidur penuh</td>
                <td><input type="checkbox" style="margin-left:10px;"></td> 
                <td>Fasilitas tidak tersedia</td>
            </tr>
            <tr>
                <td><input type="checkbox" style="margin-left:10px;"></td> 
                <td>Sesuai permintaan pasien/keluarga</td>
                <td><input type="checkbox" style="margin-left:10px;"></td> 
                <td>.....................................</td>
              </tr>
          </table><br/>
          <table border=0 style="width: 100%;">
            <tr>
              <td colspan="2">Staff yang kontak</td>
              <td colspan="3">Staff yang menerima kontak</td>
            </tr>
            <tr>
              <td>Tanggal, Pukul : .....................</td>
              <td></td>
              <td></td>
            
              <td>Nama : .....................</td>
            </tr>
            <tr>
                <td>Unit : ......................................</td>
                <td></td>
                <td></td>
          
                <td>Unit : ........................</td>
              </tr>
          </table><br/>

          <table border=0 style="width: 100%;">
            {{--<tr>
              <td colspan="3">Yang bertanda tangan dibawah ini</td>
            </tr>--}}
            <tr>
              <td colspan="3">Menerangkan Bahwa</td>
            </tr>
            <tr>
              <td><span>Nama</span></td>
              <td>: {{$pasien->nama}}</td>
              {{-- <td><span>:</span></td> --}}
              {{-- <td>{{$pasien->nama}}</td> --}}
            </tr>
            <tr>
              <td ><span> Umur</span></td>
              <td>: {{@hitung_umur($pasien->tgllahir, 'Y')}}</td>
              {{-- <td><span>:</span></td> --}}
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
                <td>: {{ ($pasien->kelamin == 'L') ? 'Lk' : 'Pr' }}</td>
                {{-- <td><span>:</span></td> --}}
                <td></td>
              </tr>
            <tr>
              <td style="width:100px;"><span>Alamat</span></td>
              <td>: {{$pasien->alamat}}</td>
              {{-- <td><span>:</span></td> --}}
              {{-- <td style="margin-left:10px;">{{$pasien->alamat}}</td> --}}
            </tr>
            <tr>
                <td style="width:100px;"><span>Pekerjaan</span></td>
                <td>: {{ @baca_pekerjaan($pasien->pekerjaan_id)}}</td>
                {{-- <td><span>:</span></td> --}}
                {{-- <td style="margin-left:10px;">{{$pasien->alamat}}</td> --}}
              </tr>
              <tr>
                <td style="width:100px;"><span>No BPJS</span></td>
                <td>: {{$pasien->no_jkn}}</td>
                {{-- <td><span>:</span></td> --}}
                {{-- <td style="margin-left:10px;">{{$pasien->alamat}}</td> --}}
              </tr>
              <tr>
                <td style="width:100px;"><span>Tgl dirawat</span></td>
                <td>: {{ date("d-m-Y", strtotime($cetak->tgl_kontrol)) }} s/d {{ date("d-m-Y", strtotime($cetak->tgl_selesai)) }}</td>
                {{-- <td><span>:</span></td> --}}
                {{-- <td style="margin-left:10px;">{{$pasien->alamat}}</td> --}}
              </tr>
            {{-- <tr> --}}
              {{-- <td colspan="3">
                <br/><br/>
                Berdasarkan hasil pemeriksaan yang telah dilakukan, Pasien tersebut dalam keadaan sakit, Sehingga perlu beristirahat selama <b>{{$cetak->lama_istirahat}}</b> Hari,<br/>
                dari tanggal {{tanggalkuitansi(date('d-m-Y',strtotime($cetak->tgl_kontrol)))}} <b>s/d</b> {{tanggalkuitansi(date('d-m-Y',strtotime($cetak->tgl_selesai)))}}<br/><br/>
                Diagnosa : {{$cetak->keterangan}}<br/><br/>
                Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan sebagaimana mestinya.

                {{-- Pada tanggal {{tanggalkuitansi(date('d-m-Y'))}} sudah dilakukan pemeriksaan pada pasien tersebut diatas didapatkan hasil :
              </td> --}}
            {{-- </tr> --}}
          </table>

          <table border=0 style="width: 100%;">
            {{-- <tr>
              <td colspan="2">Staff yang kontak</td>
              <td colspan="3">Staff yang menerima kontak</td>
            </tr> --}}
            <tr>
              <td style="width: 50%">Nama Pengantar (Hubungan dengan pasien)</td>
              <td>: {{$pasien->hub_keluarga}}</td>
            </tr>
            <tr>
                <td>No Telephone / Hp</td>
                <td>: {{$pasien->nodarurat}}</td>
              </tr>
          </table><br/>

          <table border=0 style="width: 100%;">
            <tr>
              <td colspan="3">Catatan Klinis</td>
            </tr>
            {{-- <tr>
              <td style="width: 50%">Anamnesa</td>
              <td colspan="2">: {{$cetak->ket_anamnesa}}</td>
            </tr>
            <tr>
                <td>Pemeriksaan Fisik</td>
                <td colspan="2">: {{$cetak->ket_fisik}}</td>
            </tr> --}}
            <tr>
              <td>Riwayat Alergi</td>
              <td>: <input type="checkbox" style="margin-left:10px;"> Ya</td> 
              <td><input type="checkbox" style="margin-left:10px;"> Tidak</td> 
            </tr>
          </table>
          <table border=0 style="width: 100%;">
             <tr>
                <td style="width: 50%">Pemeriksaan Penunjang</td>
                <td>: ....................................................</td> 
              </tr>
              <tr>
                <td>Diagnosa</td>
                <td>: {{$cetak->keterangan}}</td><br/>
                </tr>
                <tr>
                    <td>Terapi/Tindakan (Dicantumkan waktu pemberi obat terakhir)</td>
                    <td>: ....................................................</td><br/>
                 </tr>
                 <td colspan="3">
                 <br/>
                 Terima kasih atas kerjasamanya.
                 </td>
          </table>
         
        <table border=0 style="width:100%">
             <tr>
                <td style="text-align: center">
                    Dokter yang merawat<br/><br/><br/><br/>
                </td>
              </tr>
              <tr>
                <td style="text-align: center">
                    ({{ baca_dokter($cetak->dokter_id) }})
                </td>
              </tr>
        </table><br/>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">Staf yang melakukan rujukan,<br/><br/><br/></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Staf yang menerima pasien,<br/><br/><br/></td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">(.......................................)</td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">(.......................................)</td>
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

