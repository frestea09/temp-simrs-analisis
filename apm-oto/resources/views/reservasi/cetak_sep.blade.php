 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak </title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style>
      body{
        font-family: sans-serif;
        font-size: 10pt;
        
      }
    </style>
  </head>
  <body>
    <table style="width: 100%; margin-left: 20px;">
      <tr>
        <td style="width:20%;">
          <img src="http://172.168.1.175/images/logo_bpjs.png"style="height: 20px;">
        </td>
        <td class="text-center" style="width:16%; font-weight: bold; padding-left:30px">
          SURAT ELIGIBILITAS PESERTA<br> {{ config('app.nama') }}
        </td>
        <td class="text-center" style="width:15%; font-weight: bold;">
        </td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
            </tr>
            <tr>
              <td>No. Rujukan</td><td>: {{ @$reg ? @$reg->no_rujukan : '' }} </td> //
            </tr>
            <tr>
              <td>Tgl. SEP</td><td>: {{ @$sep['tglSep'] }}</td>
            </tr>
            <tr>
              <td>No. Kartu</td><td>: {{ @$sep['peserta']['noKartu']  }} (MR. {{ @$reg->pasien->no_rm }})</td>
            </tr>
            <tr>
              <td>Nama Peserta</td><td>: {{ @$sep['peserta']['nama']  }} </td>
            </tr>
            <tr>
              <td>Status pasien</td><td>: {{ $reg->status }} </td> //
            </tr>
            <tr>
              <td>Tgl Lahir</td><td>: {{ @$sep['peserta']['tglLahir']  }}, Kelamin : {{ @$sep['peserta']['kelamin']  }} </td>
            </tr>
            <tr>
              <td>No. Telepon</td><td>: {{ @$reg->pasien->nohp }}</td>
            </tr>
            <tr>
              <td>Sub / Spesialis</td><td>: {{ @$sep['poli'] }}</td>
            </tr>
            <tr>
              <td>DPJP Yg Melayani</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
            </tr>
            <tr>
              <td>Faskes Perujuk</td><td>: {{ (substr($reg->status_reg, 0,1) == 'J') ? NULL : $perujuk }}</td>
            </tr>
            <tr>
              <td>Diagnosa Awal</td>
              <td style="font-size:8.5pt">:
                @php
                  $diagnosa = App\Models\Icd10::where('nomor', $reg->diagnosa_awal)->first();
                  $diags = $diagnosa ? @$diagnosa->nama : @$sep['diagnosa'];
                @endphp
                {{ $diagnosa ? @$diagnosa->nama : @$sep['diagnosa'] }}
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p class="text-left small" style="font-size: 60%;">
                  <i>
                  * Saya Menyetujui BPJS Kesehatan menggunakan informasi medis Pasien jika diperlukan. <br>
                  * SEP bukan sebagai bukti penjaminan peserta.
                Cetakan Ke 1
                </i>
              </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table>
            {{-- @if(cekKatarak(@$diags))
              <tr><td>PASIEN OPERASI KATARAK</td></tr>
            @endif --}}
            @if(@$sep['katarak'] == '1')
              <tr><td>PASIEN OPERASI KATARAK</td></tr>
            @endif
            <tr>
              <td style="padding-left:30px">Peserta</td> <td style="">: {{ @$sep['peserta']['jnsPeserta'] }}</td>
            </tr>
            <tr>
              <td style="padding-left:30px">COB</td> <td>: {{ (@$sep['penjamin'] != '') ? 'Ya' : '' }}</td>
            </tr>
            <tr>
              <td style="padding-left:30px">Jenis Rawat</td>
              <td>:
                {{ @$sep['jnsPelayanan'] }}
                {{-- @if (substr($reg->status_reg, 0,1) == 'I')
                  Rawat Inap
                @else
                  Rawat Jalan
                @endif --}}
              </td>
            </tr>
            <tr>
              <td style="padding-left:30px">Kelas Rawat</td>
              <td>:
                @if (substr($reg->status_reg, 0,1) == 'I')
                  {{--  {{ $reg->hakkelas }}  --}}
                  {{ @$sep['kelasRawat'] }}
                @else
                  -
                @endif
                </td>
            </tr>
            <tr>
              <td style="padding-left:30px">Penjamin</td> <td>: {{ @$sep['penjamin'] }}</td>
            </tr>
            <tr>
              <td style="padding-left:30px">Catatan</td><td>:  {{ @$sep['catatan'] }} </td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
              <td style="padding-left:30px" colspan="2" class="text-center">
                Pasien/Keluarga Pasien <br><br>
                {{-- @if (@$kode_finger == '1')
                  <img style="width:50px !important;" src="data:image/png;base64,{{DNS2D::getBarcodePNG(@$reg->pasien->nama.' - '.@$reg->pasien->no_rm, 'QRCODE', 4,4)}}" alt="barcode" />
                @endif --}}
                <br><br>_____________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: right;font-size:10px;">Cetakan ke 1 {{date('d-m-Y H:i:s')}}</td>
      </tr>
    </table>

    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="text-align: center">
          <h3 style="font-size:17px;">SURAT BUKTI PELAYANAN KESEHATAN (SBPK)</h3>
        </td>
      </tr>
    </table>

  <table border=0 class="table table-borderless">
    <tr>
      <td>1. Nama Rs/Type/Kode RS</td> <td style="padding-left:28px">: {{ strtoupper(configrs()->nama) }} / C /</td>
      <td></td><td></td>
      <td></td><td></td>
    </tr>

    <tr>
      <td>2. Nama/RM/Kls/Pelayanan</td> <td style="padding-left:28px">: {{ @$reg->pasien->nama }} / {{ @$reg->pasien->no_rm }} </td>
      <td></td><td></td>
      <td></td><td></td>
    </tr>

    <tr>
      <td>3. Berat Bayi Lahir</td> <td style="padding-left:28px">: __________</td>
      <td></td><td></td>
    </tr>
    
    <tr>
      <td>4. Tanggal Masuk</td> <td style="padding-left:28px">: {{ date('Y-m-d',strtotime($reg->created_at)) }}</td>
      <td>Dokter Pemeriksa</td><td style="padding-left:28px"></td>
      <td></td><td></td>
    </tr>
    <tr>
      <td>5. Tanggal Keluar</td>
      <td style="padding-left:28px">:{{ date('Y-m-d',  strtotime($reg->created_at))}}</td>
    </tr>
    <tr>
      <td>6. Jumlah Biaya</td>
      <td style="padding-left:28px"></td>
    </tr>
    <tr>
      <td>7. Jumlah Hari Dirawat</td> <td style="padding-left:28px">: __________     KODE INA-CGG-S: __________</td>
      <td></td><td></td>
      <td></td><td></td>
    </tr>
    <tr>
      <td>8. Cara Pulang</td>
      <td style="padding-left:28px">: 1.Sembuh | 2.Rujuk | 3.Permintaan Sendiri | 4.Meninggal</td>
    </tr>
    <tr>
      <td>9. No. Kartu / SEP</td>
      <td style="padding-left:28px">: {{ $reg->no_sep }}</td>
    </tr>
    <tr>
      <td>10. Diagnosa Utama</td>
      <td style="padding-left:28px">: _______________________________</td>
    </tr>
    <tr>
      <td>
        <table style="width:100%" class="table">
          <tr>
            <td>11. Diagnosa Sekunder</td><td style="padding-left:28px">:</td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>12. Jenis Pelayanan</td>
            <td style="padding-left:28px">: 1. Lab | 2. Radiologi | 3. USG</td>
          </tr>
          <tr>
              <table  style="width:100%" class="table">
                  <tr>
                      <td style="width:20px;text-align:center;">No</td>
                      <td style="width:45px;text-align:center;">Kode</td>
                      <td style="width:130px;text-align:center;">Diagnosa Sekunder</td>
                  </tr>
                  <tr>
                      <td style="width:30px;text-align:center;">1</td>
                      <td style="width:45px;text-align:center;">___________________</td>
                      <td style="width:130px;text-align:center;">___________________</td>
                  </tr>
                  <tr>
                      <td style="width:30px;text-align:center;">2</td>
                      <td style="width:45px;text-align:center;">___________________</td>
                      <td style="width:130px;text-align:center;">___________________</td>
                  </tr>
                  <tr>
                      <td style="width:30px;text-align:center;">3</td>
                      <td style="width:45px;text-align:center;">___________________</td>
                      <td style="width:130px;text-align:center;">___________________</td>
                  </tr>

              </table>
            </tr>
            
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width:100%" class="table">
          <tr>
            <td>13. Kode</td><td style="padding-left:28px">:</td>
            <td></td><td></td>
          </tr>
          <tr>
              <table  style="width:100%" class="table">
                  <tr>
                      <td style="width:20px;text-align:center;">No</td>
                      <td style="width:45px;text-align:center;">Kode</td>
                      <td style="width:130px;text-align:center;">Prosedur</td>
                  </tr>
                  <tr>
                      <td style="width:30px;text-align:center;">1</td>
                      <td style="width:45px;text-align:center;">___________________</td>
                      <td style="width:130px;text-align:center;">___________________</td>
                  </tr>
                  <tr>
                      <td style="width:30px;text-align:center;">2</td>
                      <td style="width:45px;text-align:center;">___________________</td>
                      <td style="width:130px;text-align:center;">___________________</td>
                  </tr>
                  <tr>
                      <td style="width:30px;text-align:center;">3</td>
                      <td style="width:45px;text-align:center;">___________________</td>
                      <td style="width:130px;text-align:center;">___________________</td>
                  </tr>

              </table>
            </tr>
            
        </table>
      </td>
    </tr>
    








  </table>
    


  </body>
</html>

