
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

      .checked{
        width:20px;
        height:20px;
        background-color: red;
      }
    </style>
  </head>
  
  <body> 
    <table style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: left">
          <b style="font-size:17px;">{{strtoupper(configrs()->nama)}} GUMAWANG</b><br/>
          <b style="font-size:17px;">SURAT JAMINAN PELAYANAN(SJP) - BPJS</b>
        </td>
      </tr>
    </table>
    <table style="width: 100%;font-size:12px;"> 
      <tr>
        <td>
          <table>
            <tr>
              <td><b>{{baca_sjp($unit)}}</b></td>
            </tr>
            <tr>
              <td>No. SEP</td><td>: {{ @$reg->no_sep }}</td>
            </tr> 
            <tr>
              <td>Tanggal SJP</td><td>: {{date('d/m/Y',strtotime(@$reg->created_at)) }}</td>
            </tr>
            <tr>
              <td>Asal Rujukan</td><td>: {{ !empty($reg->pengirim_rujukan) ? baca_rujukan($reg->pengirim_rujukan) : '-' }}</td>
            </tr>
            <tr>
              <td>Diagnosa Awal</td><td>: {{!empty($reg->diagnosa_awal) ? baca_diagnosa($reg->diagnosa_awal) :'-' }}</td>
            </tr>
            <tr>
              <td>Poli Tujuan</td><td>: {{!empty($reg->poli_id) ? baca_poli($reg->poli_id) :'-'}}</td>
            </tr>
            <tr>
              <td>Nama Dokter</td><td>: {{!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id):'-' }}</td>
            </tr>  
          </table>
        </td>
        <td>
          <table>
            <tr>
              <td><b>NO SJP</b></td>
              <td><b>: {{@$reg->reg_id}}</b></td>
            </tr>
            <tr>
              <td>No. Medrec</td> <td>: {{ @$reg->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td>Peserta</td> <td>: {{ @$reg->pasien->nama }}</td>
            </tr>
            <tr>
              <td>No. Kartu</td> <td>: {{ @$reg->pasien->no_jkn }}</td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td> <td>: {{ kelamin(@$reg->pasien->kelamin) }}-{{ date('d/m/Y',strtotime(@$reg->pasien->tgllahir))}}-Umur: {{ !empty(@$reg->pasien->tgllahir) ? date('Y')-date('Y',strtotime(@$reg->pasien->tgllahir)) : '-'}}</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr> 
          </table>
        </td>
      </tr>
    </table>
    <table style="width: 100% !important;font-size:12px;"> 
      <tr>
        <td style="width:15%">Penunjang</td><td>
          1.
          <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
          <label for="vehicle1"> LAB</label>

          &nbsp;&nbsp;&nbsp;2.
          <input type="checkbox" id="vehicle2" name="vehicle1" value="Bike">
          <label for="vehicle1"> ECHO</label>
          &nbsp;&nbsp;&nbsp;3.
          <input type="checkbox" id="vehicle3" name="vehicle1" value="Bike">
          <label for="vehicle1"> USG</label>
          &nbsp;&nbsp;&nbsp;4.
          <input type="checkbox" id="vehicle4" name="vehicle1" value="Bike">
          <label for="vehicle1"> TREADMIL</label>
          &nbsp;&nbsp;&nbsp;5.
          <input type="checkbox" id="vehicle5" name="vehicle1" value="Bike">
          <label for="vehicle1"> FISIOTERAPI</label>
          &nbsp;&nbsp;&nbsp;6.
          <input type="checkbox" id="vehicle6" name="vehicle1" value="Bike">
          <label for="vehicle1"> ........</label>
        </td>
      </tr> 
      <tr>
        <td style="width:16%">Anestesis</td>
        <td style="border:1px solid black;height:35px;"></td>
      </tr> 
      <tr>
        <td style="width:15%">DIAGNOSA UTAMA</td>
        <td style="border:1px solid black;height:20px;text-align:right">
          <span style="margin-right:60px;">| &nbsp;&nbsp;&nbsp; ICD 10 :</span>
          <span style="margin-right:80px;">| &nbsp;&nbsp;&nbsp; Paraf Dokter : </span>
        </td>
      </tr>  
    </table> 
    <table style="width: 100% !important;font-size:12px;">   
      {{-- DIAGNOSA SEKUNDER --}}
      <tr>
        <td colspan="2">DIAGNOSA SEKUNDER</td>
      </tr>
      <tr>
        <td style="width: 5%">1.</td>
        <td style="border:1px solid black;height:20px;text-align:right">
          <span style="margin-right:60px;">| &nbsp;&nbsp;&nbsp; ICD 10 :</span>
          <span style="margin-right:80px;">| &nbsp;&nbsp;&nbsp; Paraf Dokter : </span>
        </td>
      </tr>  
      <tr>
        <td style="width: 5%">2.</td>
        <td style="border:1px solid black;height:20px;text-align:right">
          <span style="margin-right:60px;">| &nbsp;&nbsp;&nbsp; ICD 10 :</span>
          <span style="margin-right:80px;">| &nbsp;&nbsp;&nbsp; Paraf Dokter : </span>
        </td>
      </tr>  
     
      {{-- DIAGNOSA SEKUNDER --}}
      <tr>
        <td colspan="2">TINDAKAN</td>
      </tr>
      <tr>
        <td style="width: 5%">1.</td>
        <td style="border:1px solid black;height:20px;text-align:right">
          <span style="margin-right:60px;">| &nbsp;&nbsp;&nbsp; ICD 9CM :</span>
          <span style="margin-right:80px;">| &nbsp;&nbsp;&nbsp; Paraf Dokter : </span>
        </td>
      </tr>  
      <tr>
        <td style="width: 5%">2.</td>
        <td style="border:1px solid black;height:20px;text-align:right">
          <span style="margin-right:60px;">| &nbsp;&nbsp;ICD 9CM :</span>
          <span style="margin-right:80px;">| &nbsp;&nbsp; Paraf Dokter : </span>
        </td>
      </tr>  
      
    </table> 

    <table style="width: 100% !important;font-size:12px;margin-top:30px;">
    <tr>
      <td style="text-align:center;width:40%">Pasien/Keluarga
        <br/><br/><br/><br/><br/>-
      </td>
      <td style="text-align:center;width:40%">
        Operator<br/><br/><br/><br/><br/>
        {{@\App\User::find($reg->user_create)->name}}
      </td>
      <td style="text-align:center;width:40%">
        DPJP<br/><br/><br/><br/><br/>
        {{@!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id): '-'}}
      </td>
    </tr>
    </table>


    {{-- ------------------------------------------------------------- --}}
    <table style="width: 100%;"> 
      <tr>
        <td>
          <table>
            <tr>
              <td colspan="2"><b>BERKAS TIDAK DIBAWA PULANG</b><br/>
                  <b>RESEP PASIEN - BPJS</b>
              </td>
            </tr>
            <tr>
              <td>NO SJP</td><td>: {{ @$reg->reg_id }}</td>
            </tr> 
            <tr>
              <td>TGL.SJP</td><td>: {{date('d/m/Y',strtotime(@$reg->created_at)) }}</td>
            </tr>
            <tr>
              <td>NO. Resep</td><td>: </td>
            </tr> 
          </table>
        </td>
        <td>
          <table>
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
              <td>Nama Pasien</td> <td>: {{ @$reg->pasien->nama }}</td>
            </tr>
            <tr>
              <td>No. Medrec</td> <td>: {{ @$reg->pasien->no_rm }}</td>
            </tr> 
            <tr>
              <td>Tgl.Lahir</td> <td>: {{ date('d/m/Y',strtotime(@$reg->pasien->tgllahir))}}</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr> 
          </table>
        </td>
      </tr>
    </table>
    <table style="width: 100%;"> 
    <tr>
      <td>R/ Nama Obat<br/><br/></td>
    </tr>
    <tr>
      <td>R/ .........<br/><br/></td>
    </tr>
    <tr>
      <td>R/ .........<br/><br/></td>
    </tr>
    <tr>
      <td>R/ .........<br/><br/></td>
    </tr>
    <tr>
      <td>R/ .........<br/><br/></td>
    </tr>
    <tr>
      <td>R/ .........<br/><br/></td>
    </tr>
    </table>
    <table style="width: 100% !important;font-size:12px;margin-top:30px;">
      <tr>
        <td style="text-align:center;width:40%">Pasien/Keluarga
          <br/><br/><br/><br/><br/>-
        </td>
        <td style="text-align:center;width:40%">
          Operator<br/><br/><br/><br/><br/>
          {{@\App\User::find($reg->user_create)->name}}
        </td>
        <td style="text-align:center;width:40%">
          DPJP<br/><br/><br/><br/><br/>
          {{@!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id): '-'}}
        </td>
      </tr>
      </table>
  </body>
</html>
