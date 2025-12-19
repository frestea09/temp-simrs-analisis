 
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
        <td style="width:30%;">
          <img src="{{ public_path('images/logo_bpjs.png') }}"style="height: 20px;">
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
                  $diagnosa = Modules\Icd10\Entities\Icd10::where('nomor', $reg->diagnosa_awal)->first();
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
                Pasien/Keluarga Pasien <br><br><br><br>_____________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    


  </body>
</html>

