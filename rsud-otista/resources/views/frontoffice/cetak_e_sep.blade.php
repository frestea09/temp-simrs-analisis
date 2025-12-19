<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak </title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">

        


/* 

body{
        margin-top: 50px;
        margin-left: 15%;
        margin-right: 15%;
        font-size: 10pt;
      } */



        
    </style>
  </head>
  @php
      @$reg = Modules\Registrasi\Entities\Registrasi::where('id', @$data[0]->registrasi_id)->get();
      @$pasien = Modules\Pasien\Entities\Pasien::where('id', @$reg[0]->pasien_id)->get();
      @$soap = App\Emr::where('registrasi_id', @$reg[0]->id)->get();
      @$folio = Modules\Registrasi\Entities\Folio::where('registrasi_id', @$reg[0]->id)->get();
      @$penjualan = App\Penjualan::where('registrasi_id', @$reg[0]->id)->get();
    //   dd(@$penjualan);
      
  @endphp
  <body onload="print()">

          <table border="1" cellspacing="0" style="width: 100%">
            <tr>
              <td>
                <table>
                    <tr>
                        <td style="text-align: center">
                            {{-- {{ public_path('css/pdf.css') }} --}}
                            {{-- <img src="/images/{{ configrs()->logo }}" class="logoutama"> --}}
                            <img src="{{ public_path('images/'.configrs()->logo) }}" style="width:68px;height:60px">
                        </td>
                    </tr>
                    <tr>
                        <td>alamat </td><td>: {{ @$data[0]->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Telp </td><td>: {{ @$data[0]->no_hp }}</td>
                    </tr>
                </table>
              </td>
              <td style="width: 30%"><h3 style="text-align: center"><b>Ringkasan Rawat Jalan</b></h3></td>
              <td>
                <table>
                    <tr>
                        <td>Nama </td><td>: {{ @$data[0]->pasien_nama }}</td>
                    </tr>
                    <tr>
                        <td>No RM </td><td>: {{ @$data[0]->no_rm}}</td>
                    </tr>
                    <tr>
                        <td>Tgl Lahir </td><td>: {{ @$data[0]->pasien_tgllahir }}</td>
                    </tr>
                    <tr>
                        <td>Nik </td><td>: {{ @$data[0]->pasien_nama }}</td>
                    </tr>
                    <tr>
                        <td>Register </td><td>: {{ @$reg[0]->reg_id }}</td>
                    </tr>
                    <tr>
                        <td>Kelamin </td><td>: {{ @$data[0]->pasien_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Alamat </td><td>: {{ @$pasien[0]->alamat }}</td>
                    </tr>
                </table>
              </td>
            </tr>
          </table>

          <table border="1" cellspacing="0" style="width: 100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Tanggal Kunjungan </td><td>: {{ @$data[0]->tgl_masuk }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Sep </td><td>: {{ @$data[0]->no_sep }}</td>
                        </tr>
                        <tr>
                            <td>Klinik </td><td>: {{ @$reg[0]->poli_id }}</td>
                        </tr>
                        <tr>
                            <td>Dokter Penanggung Jawab </td><td>: {{ @$data[0]->dokter }}</td>
                        </tr>
                    </table>
                  </td>
            </tr>  
          </table>
          <table border="1" cellspacing="0" style="width: 100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Anamnesis </td><td>: {{ @$soap[0]->poli_id }}</td>
                        </tr>
                        <tr>
                            <td>Pemeriksaan Fisik </td><td>: {{ @$soap[0]->pemeriksaan_fisik }}</td>
                        </tr>
                        <tr>

                            <td>Tindakan </td>
                          
                            <td>
                                <table>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($folio as $item)
                                            <tr>
                                                <td>
                                                    : {{ $no++ }}. {{ @$item->namatarif }}
                                                </td>
                                            </tr>
                                        @endforeach
                                </table>
                            </td>
                          
                            
                          
                        </tr>
                        <tr>
                            <td>Obat Yang Di Berikan </td>

                            <td>
                                <table>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($penjualan as $item)
                                           

                                                    @php
                                                        
                                                        $penjualanDetail = App\Penjualandetail::where('penjualan_id', @$item->id)->get();
                                                        // dd(@$penjualanDetail);
                                                    @endphp

                                                    @foreach ($penjualanDetail as $data)
                                                    <tr>
                                                        <td>
                                                    : {{ $no++ }}. {{ baca_obat(@$data->masterobat_id)}}
                                                        </td>
                                                    </tr>
                                                    @endforeach





                                                    
                                               
                                        @endforeach
                                </table>
                            </td>

                        </tr>
                    </table>
                  </td>
            </tr>  
          </table>
          <table border="1" cellspacing="0" style="width: 100%"> 
            <tr>
              <th>
                <b>KONSULTASI</b>
              </th>
            </tr>
          </table>
          <table border="1" cellspacing="0" style="width: 100%">
            
            <tr>
              <th>
                <b>Tanggal</b>
              </th>
              <th><b>Ringkasan Rawat Jalan</b></th>
              <th>
                <b>Jawaban Konsul</b>
              </th>
            </tr>
            <tr>
                <td>....</td>
                <td>....</td>
                <td>....</td>
              </tr>
          </table>
          <table border="1" cellspacing="0" style="width: 100%; text-align:center;">
            <tr>
                <td style="padding-left: 70%; padding-top: 20px; padding-bottom: 20px">
                    <table style="text-align: center">
                        <tr>
                            <td>Soreang, {{ date("Y/m/d") }}</td>
                        </tr>
                        <tr>
                            <td>{{ @$data[0]->dokter }}</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(@$reg[0]->pengirim_rujukan, 'QRCODE', 4,4)}}" class="d-inline block" alt="barcode" />
                            </td>
                        </tr>
                    </table>
                  </td>
            </tr>  
          </table>
   
   
   
   
   
          <META HTTP-EQUIV="REFRESH" CONTENT="15; URL={{ url('/frontoffice/data-sep') }}">
  </body>
</html>
