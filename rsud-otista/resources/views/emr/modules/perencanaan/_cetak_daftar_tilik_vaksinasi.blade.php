<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Daftar Tilik Vaksinasi</title>
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

      table {
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%;
      }

      td, th {
        border: 1px solid black;
        padding: 5px;
        vertical-align: top;
      }
       /* TABEL TANPA BORDER */
      table.no-border {
        border: none;
        border-collapse: collapse;
        width: 100%;
      }

      table.no-border td,
      table.no-border th {
        border: none;
        padding: 5px;
        vertical-align: top;
      }
      .footer {
        padding-top: 20px;
        margin-left: 330px;
      }
    </style>

  </head>
  <body>
     <table class="no-border" style="width: 100%;"> 
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
        <table class="no-border" style="width: 100%;"> 
          <tr>
            <td style="text-align: center">
              <h3 style="font-size:17px; margin-bottom: 0; line-height: 1;">FORMULIR DAFTAR TILIK PENAPISAN KONTRAINDIKASI UNTUK VAKSINASI DEWASA</h3>
            </td>
          </tr>                    
        </table>
        <table class="no-border" style="width: 100%; font-size: 12px;"> 
          <tr>
            <td style="width: 40%">NAMA PELAKU PERJALANAN</td>
            <td>: {{@$pasien->nama}}</td>
          </tr>                    
          <tr>
            <td style="width: 40%">TANGGAL LAHIR</td>
            <td>: {{tgl_indo($pasien->tgllahir)}}</td>
          </tr>                    
        </table>
          <table class="table-border" style="width: 100%; font-size: 15px;">
            <tr>
              <td style="width: 5%; text-align: center; font-size: 12px; padding: 10px;">NO</td>
              <td style="width: 35%; text-align: center; font-size: 12px; padding: 10px;">PERTANYAAN</td>
              <td style="width: 10%; text-align: center; font-size: 12px; padding: 10px;">YA</td>
              <td style="width: 10%; text-align: center; font-size: 12px; padding: 10px;">TIDAK</td>
              <td style="width: 10%; text-align: center; font-size: 12px; padding: 10px;">TIDAK TAHU</td>
              <td style="width: 30%; text-align: center; font-size: 12px; padding: 10px;">KETERANGAN</td>
            </tr>
            <tr>
              <td style="text-align: center;">1</td>
              <td>Apakah anda sedang sakit hari ini ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[1][ya]" value="ya1" {{ @$data['1']['ya'] == 'ya1' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[1][tidak]" value="tidak1" {{ @$data['1']['tidak'] == 'tidak1' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[1][tidak]" value="tidaktahu1" {{ @$data['1']['tidaktahu'] == 'tidaktahu1' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['1']['keterangan1'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">2</td>
              <td>Apakah anda memiliki alergi terhadap obat-obatan, makanan, komponen vaksin atau lateks ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[2][ya]" value="ya2" {{ @$data['2']['ya'] == 'ya2' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[2][tidak]" value="tidak2" {{ @$data['2']['tidak'] == 'tidak2' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[2][tidak]" value="tidaktahu2" {{ @$data['2']['tidaktahu'] == 'tidaktahu2' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['2']['keterangan2'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">3</td>
              <td>Apakah anda pernah mengalami reaksi alergi berat setelah menerima vaksin ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[3][ya]" value="ya3" {{ @$data['3']['ya'] == 'ya3' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[3][tidak]" value="tidak3" {{ @$data['3']['tidak'] == 'tidak3' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[3][tidak]" value="tidaktahu3" {{ @$data['3']['tidaktahu'] == 'tidaktahu3' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['3']['keterangan3'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">4</td>
              <td>Apakah anda memiliki penyakit kronis terkait jantung, paru-paru, asma, ginjal, penyakit metabolic (diabetes), anemia atau penyakit kelainan darah ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[4][ya]" value="ya4" {{ @$data['4']['ya'] == 'ya4' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[4][tidak]" value="tidak4" {{ @$data['4']['tidak'] == 'tidak4' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[4][tidak]" value="tidaktahu4" {{ @$data['4']['tidaktahu'] == 'tidaktahu4' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['4']['keterangan4'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">5</td>
              <td>Apakah anda menderita kanker, leukemia, HIV?AIDS atau gangguan sistem daya tahan tubuh ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[5][ya]" value="ya5" {{ @$data['5']['ya'] == 'ya5' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[5][tidak]" value="tidak5" {{ @$data['5']['tidak'] == 'tidak5' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[5][tidak]" value="tidaktahu5" {{ @$data['5']['tidaktahu'] == 'tidaktahu5' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['5']['keterangan5'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">6</td>
              <td>Dalam 3 bulan terakhir, apakah anda mendapatkan pengobatan yang melemahkan daya tahan tubuh seperti kortison, prednisone, steroid lainnya atau obat anti kanker atau terapi radiasi ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[6][ya]" value="ya6" {{ @$data['6']['ya'] == 'ya6' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[6][tidak]" value="tidak6" {{ @$data['6']['tidak'] == 'tidak6' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[6][tidak]" value="tidaktahu6" {{ @$data['6']['tidaktahu'] == 'tidaktahu6' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['6']['keterangan6'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">7</td>
              <td>Apakah anda pernah mengalami kejang atau gangguan sistem syaraf lainnya ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[7][ya]" value="ya6" {{ @$data['7']['ya'] == 'ya7' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[7][tidak]" value="tidak6" {{ @$data['7']['tidak'] == 'tidak7' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[7][tidak]" value="tidaktahu6" {{ @$data['7']['tidaktahu'] == 'tidaktahu7' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['7']['keterangan7'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">8</td>
              <td>Apakah anda menerima transfuse darah atau produk darah, atau mendapat terapi imun (gamma) globulin, atau obat antiviral dalam satu tahun terakhir ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[8][ya]" value="ya8" {{ @$data['8']['ya'] == 'ya8' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[8][tidak]" value="tidak8" {{ @$data['8']['tidak'] == 'tidak8' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[8][tidak]" value="tidaktahu8" {{ @$data['8']['tidaktahu'] == 'tidaktahu8' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['8']['keterangan8'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">9</td>
              <td>Apakah anda sedang hamil atau berencana untuk hamil dalam 1 bulan kedepan ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[9][ya]" value="ya9" {{ @$data['9']['ya'] == 'ya9' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[9][tidak]" value="tidak9" {{ @$data['9']['tidak'] == 'tidak9' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[9][tidak]" value="tidaktahu9" {{ @$data['9']['tidaktahu'] == 'tidaktahu9' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['9']['keterangan9'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">10</td>
              <td>Apakah anda mendapatkan vaksinasi dalam 4 minggu terakhir ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[10][ya]" value="ya10" {{ @$data['10']['ya'] == 'ya10' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[10][tidak]" value="tidak10" {{ @$data['10']['tidak'] == 'tidak10' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[10][tidak]" value="tidaktahu10" {{ @$data['10']['tidaktahu'] == 'tidaktahu10' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['10']['keterangan10'] }}
              </td>
            </tr>
            <tr>
              <td style="text-align: center;">11</td>
              <td>Apakah anda membawa kartu vaksinasi ?</td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[11][ya]" value="ya11" {{ @$data['11']['ya'] == 'ya11' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[11][tidak]" value="tidak11" {{ @$data['11']['tidak'] == 'tidak11' ? 'checked' : '' }}>
              </td>
              <td style="vertical-align: middle; padding-left: 20px;">
                <input type="checkbox" name="keterangan[11][tidak]" value="tidaktahu11" {{ @$data['11']['tidaktahu'] == 'tidaktahu11' ? 'checked' : '' }}>
              </td>
              <td>
                {{ @$data['11']['keterangan11'] }}
              </td>
            </tr>
          </table>
          <br>
          <table class="no-border" style="width: 100%; font-size: 12px;">
            <tr>
              <td style="width: 25%;">DIISI OLEH</td>
              <td style="width: 35%;">: {{baca_user(@$vaksinasi->user_id)}}</td>
              <td style="width: 15%;">TANGGAL</td>
              <td style="width: 25%;">: {{@$vaksinasi->created_at}}</td>
            </tr>
            <tr>
              <td style="width: 25%;">DIVERIFIKASI OLEH</td>
              <td style="width: 35%;">: {{baca_dokter(@$vaksinasi->dokter_id)}}</td>
              <td style="width: 15%;">TANGGAL</td>
              <td style="width: 25%;">: {{@$vaksinasi->created_at}}</td>
            </tr>
          </table>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>

