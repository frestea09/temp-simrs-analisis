 
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
          SURAT RUJUK BALIK (PRB)<br> {{ config('app.nama') }}
        </td>
        <td class="text-center" style="width:15%; font-weight: bold;">
        </td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td colspan="2">Mohon Pemeriksaan dan Penanganan Lebih Lanjut :</td>
            </tr>  
            <tr>
              <td>No. Kartu</td><td>: {{ @$prb->no_kartu  }}</td>
            </tr>
            <tr>
              <td>Nama Peserta</td><td>: {{ @$prb->registrasi->pasien->nama  }} </td>
            </tr>
            <tr>
              <td>Tgl Lahir</td><td>: {{ date('d-m-Y',strtotime(@$prb->registrasi->pasien->tgllahir))}}</td>
            </tr>
            <tr>
              <td>Diagnosa</td>
              <td style="font-size:8.5pt">:
                @php
                  @$diagnosa = Modules\Icd10\Entities\Icd10::where('nomor', @$reg->diagnosa_awal)->first();
                @endphp
                {{ @$diagnosa ? @$diagnosa->nama : @$sep['diagnosa'] }}
              </td>
            </tr>
            <tr>
              <td>Program PRB</td><td>: {{ @$program_prb->nama }}</td>
            </tr>
            <tr>
              <td>Keterangan</td><td>: {{ @$prb->keterangan }}</td>
            </tr>
            {{-- <tr>
              <td>DPJP Yg Melayani</td> <td>: {{ baca_dokter_bpjs(@$prb->kode_dpjp) }}</td>
            </tr> --}}
            <tr>
              <td>Saran Pengelolaan lanjutan di FKTP</td><td>: {{ @$prb->saran}}</td>
            </tr>
            
            <tr>
              <td colspan="2">Demikian atas bantuannya, diucapkan banyak terima kasih</td>
            </tr>
            <tr>
              <td colspan="2">
                <p class="text-left small" style="font-size: 60%;">
                  <i>
                  Tgl.Cetak {{date('d-m-Y H:i A')}}
                </i>
              </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table style="width:450px">  
            <tr>
              <td  style="padding-left:30px" colspan="3"><b>NO.SRB &nbsp;&nbsp;&nbsp; : {{@$prb->no_srb}}</b></td>
            </tr>
            <tr>
              <td  style="padding-left:30px" colspan="3">Tanggal.{{date('d-m-Y H:i A')}}</td>
            </tr>
            <tr>
              <td  style="padding-left:30px" colspan="3">R/.</td>
            </tr>
            @foreach ($prb_detail as $key =>$item)
              <tr>
                <td style="width:5%;padding-left:30px">{{$key+1}}. {{$item->signa_1}}X{{$item->signa_2}}</td> 
                <td style="width:95%;"> {{@$item->obat->nama}} </td>
                <td>{{$item->jumlah}}</td>
              </tr>
                
            @endforeach
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
              <td style="padding-left:30px" colspan="2" class="text-center">
                Mengetahui <br><br><br><br>_____________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  </body>
</html>

