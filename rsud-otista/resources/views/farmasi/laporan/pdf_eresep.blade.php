<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
            @page {
                padding-bottom: 1cm;
            }

            .footer {
              position: fixed; 
              bottom: 0cm; 
              left: 0cm; 
              right: 0cm;
              height: 1cm;
              text-align: justify;
            }
    </style>
  </head>
  <body>
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <div style="float:none;clear:both;"></div>
    <br>
    <hr/>
    <br>
    <b>{{$no_resep}}</b>
    {{-- <table style="width: 100%">
      <tr>
        <td style="width:25%;">Riwayat Alergi Obat</td>
        <td>&nbsp;</td>
        <td style="width:10%;">Tgl</td>
        <td>:&nbsp;&nbsp;{{date('d-m-Y',strtotime($penjualan->created_at))}}</td>
      </tr>
      <tr>
        <td>Gangguan Fungsi Ginjal</td>
        <td>:</td>
        <td>Jam</td>
        <td>:&nbsp;&nbsp;{{date('H:i:s',strtotime($penjualan->created_at))}}</td>
      </tr>
      <tr>
        <td>Hamil/Menyusui</td>
        <td>:</td>
        <td>Ruangan</td>
        <td>:&nbsp;&nbsp;
          @php
              $histori = \App\HistorikunjunganIRJ::where('registrasi_id',$penjualan->registrasi_id)->orderBy('id','DESC')->first();
          @endphp
          @if ($histori)
          {{baca_poli(@$histori->poli_id)}}  
          @else
          {{@$reg->poli->nama}}
          @endif
        </td>
      </tr>
    </table> --}}
    <table style="width: 100%">
      <tr>
        <td style="width:25%;">Nama Lengkap </td>
        <td>:&nbsp; {{ $reg->pasien->nama }}</td>
        <td style="width:10%;">Unit yang Order</td>
        <td>:&nbsp;&nbsp;
        @if (substr($reg->status_reg, 0,1) == 'J')
            Instalasi Rawat Jalan / {{ baca_poli($reg->poli_id) }}
        @elseif (substr($reg->status_reg, 0,1) == 'G')
            Instalasi Rawat Darurat / {{ baca_poli($reg->poli_id) }}
        @elseif ($reg->status_reg == 'I2') 
            Instalasi Rawat Inap / {{ baca_kamar(App\Rawatinap::where('registrasi_id', $reg->id)->first()->kamar_id) }}
        @elseif ($reg->status_reg == 'I1') 
            Instalasi Rawat Inap / {{ baca_poli($reg->poli_id) }}
        @endif
        </td>
      </tr>
      <tr>
        <td>No. Rekam Medik</td>
        <td>:&nbsp; {{ $reg->pasien->no_rm }}</td>
        <td>Cara Bayar</td>
        <td>:&nbsp;&nbsp;{{ baca_carabayar($reg->bayar) }}</td>
      </tr>
      <tr>
        <td>Usia / Jns Kelamin</td>
        <td>:&nbsp;{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td>
        <td>Dibuat</td>
        <td>:&nbsp;&nbsp;{{ baca_dokter($reg->dokter_id) }}
          {{-- :&nbsp;&nbsp;
            {{ date('d-m-Y' ,strtotime($penjualan->created_at)) }} --}}
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>
        </td>
      </tr>
    </table>
    <br/>
    <center>
      <b>{{baca_carabayar($reg->bayar)}}</b>
    </center><br/>
    {{-- <div style="float:left"> --}}
      <table style="width: 100%;">
        <tr>
          <td style="width:50%;vertical-align:top">
            <table>
              {{-- <tr>
                <td>
                  <b>R/</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b style="color:red;font-size:12px;"><u><i>{{strtoupper($nama_racikan)}}</i></u></b><b>Non Racik</b>
                </td>
              </tr> --}}
              @if ($detail)
                  @php
                    $total_harga_resep = 0;
                  @endphp
                @foreach ($detail as $d)
                @php
                  $total_harga_resep += $d->hargajual;
                @endphp
                <tr>
                  {{-- <td>
                    R
                  </td> --}}
                  <td>
                    <b>R/</b> 
                    {{-- OK --}}
                    <span style="padding-left: 20px">{{@$d->masterobat->nama}}[{{$d->jumlah}}] <b>(Rp. {{number_format($d->hargajual)}})</b></span><br/>
                    {{-- End OK --}}
                    {{-- {{@$d->etiket}},{{@\App\masterCaraMinum::where('id',@$d->cara_minum_id)->first()->nama}} {{@$d->informasi1}},{{@$d->informasi2}}<br/> --}}
                    {{-- OK --}}
                    {{@$d->etiket ?? @$d->cara_minum}},{{@$d->informasi1}},{{@$d->informasi2}} <b> {{@$d->is_kronis == 'Y' ? 'Kronis' : 'Non Kronis'}} </b><br/>
                    {{-- End OK --}}
                    {{-- {{ $d->jumlah }}x{{ number_format((($d->hargajual+$d->hargajual_kronis)/($d->jumlah+$d->jml_kronis))) }}={{ number_format($d->hargajual_kronis+$d->hargajual+$d->uang_racik) }} --}}
                    {{-- <span style="color:red">exp({{@$d->masterobat->logistik_batch->expireddate}})</span> --}}
                  </td>
                </tr>
                @endforeach
              @endif
              <tr>
                <td>
                </td>
              </tr>
              <tr>
                <td>
                </td>
              </tr>
              <tr>
                <td>
                </td>
              </tr>
              <tr>
                <td>
                </td>
              </tr>
              
              <tr>
                <td>
                  <b>R/</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b style="color:red;font-size:12px;"><u><i>{{strtoupper($nama_racikan)}}</i></u></b><b style="color:red">RACIKAN</b><br/><br/>
                </td>
              </tr>
             
              @if ($detail_racikan)
                @foreach ($detail_racikan as $d)
                <tr>
                  <td>
                    {{@$d->masterobat->nama}} [{{$d->jumlah}}]<br/>
                    {{-- {{@$d->etiket}},{{@\App\masterCaraMinum::where('id',@$d->cara_minum_id)->first()->nama}} {{@$d->informasi1}},{{@$d->informasi2}}<br/> --}}
                    {{@$d->etiket}},{{@$d->informasi1}},{{@$d->informasi2}}<br/>
                    {{-- {{ $d->jumlah }}x{{ number_format((($d->hargajual+$d->hargajual_kronis)/($d->jumlah+$d->jml_kronis))) }}={{ number_format($d->hargajual_kronis+$d->hargajual+$d->uang_racik) }} --}}
                    {{-- <span style="color:red">exp({{@$d->masterobat->logistik_batch->expireddate}})</span> --}}
                  </td>
                </tr>
                @endforeach
                  
              @endif

              <tr>
                <td><b>Total</b></td>
              </tr>
              <tr>
                <td><b>Rp. {{number_format($total_harga_resep)}}</b></td>
              </tr>
            </table>
          </td>
          <td>
         
            
          
            <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;">
              <tr>
                <td>No</td>
                <td style="width: 100px;">Telaah Resep</td>
                <td>Ya</td>
                <td>Tidak</td>
                <td>Keterangan</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Ketepatan identitas pasien</td>
                <td>  
                    @if (@json_decode(@$get_note->catatan,true)["'1'"] == '1') 
                        {{ "Ya" }}
                    @endif
                </td>
                <td>
                  @if (@json_decode(@$get_note->catatan,true)["'1'"] == '0') 
                  {{ "Tidak" }}
              @endif
                </td>
                <td></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Ketepatan Obat</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'2'"] == '2') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'2'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Ketepatan Dosis</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'3'"] == '3') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'3'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>4</td>
                <td>Ketepatan frekuensi</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'4'"] == '4') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'4'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>5</td>
                <td>Ketepatan aturan minum/makan obat</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'5'"] == '5') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'5'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>6</td>
                <td>Ketepatan waktu pemberian</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'6'"] == '6') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'6'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>7</td>
                <td>Duplikasi pengobatan</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'7'"] == '7') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'7'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>8</td>
                <td>Potensi alergi atau sensitivitas</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'8'"] == '8') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'8'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>9</td>
                <td>Interaksi antara obat dan obat lain atau dengan makanan </td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'9'"] == '9') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'9'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              <tr>
                <td>10</td>
                <td>Variasi kriteria penggunaan obat dari rumah sakit (obat dagang,obat generik)</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'10'"] == '10') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'10'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
              
              <tr>
                <td></td>
                <td>Kontra indikasi</td>
                <td>  
                  @if (@json_decode(@$get_note->catatan,true)["'11'"] == '11') 
                      {{ "Ya" }}
                  @endif
              </td>
              <td>
                @if (@json_decode(@$get_note->catatan,true)["'11'"] == '0') 
                {{ "Tidak" }}
            @endif
              </td>
                <td></td>
              </tr>
            </table>
          </td>
        </tr>
        
      </table> 
      <br/>
    <br>

      
    {{-- <table style="width: 100%">
      <tr>
        <td style="width:15%;">PRO</td>
        <td>: {{@$reg->pasien->nama}}</td>
        <td style="width:15%;">No. RM</td>
        <td>:&nbsp;&nbsp;{{@$reg->pasien->no_rm}}</td>
      </tr>
      <tr>
        <td>Tgl. Lahir</td>
        <td>: {{date('d-m-Y',strtotime($reg->pasien->tgllahir))}}</td>
        <td>Berat Badan</td>
        <td>:</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>: {{@$reg->pasien->alamat}}</td>
        
      </tr>
    </table> --}}

    <table style="width: 100%" border="0" cellspacing="0">
      <tr>
        <td>
          <table border="0" cellspacing="0" style="width: 100%">
            <tr >
              <td class="text-center">
                @if(!tandatangan($reg->dokter_id))
                    @if (isset($cetak_tte))
                      <p>Nama &amp; Tanda Tangan<br/> Dokter<br/>
                        <br>
                        <img src="{{asset('barcode-tte-kominfo.jpeg')}}" style="width: 80px;">
                        <br/>
                        ({{ baca_dokter($reg->dokter_id) }})
                      </p>
                    @else
                      <p>Nama &amp; Tanda Tangan<br/> Dokter<br/>
                        @php
                          $pegawai = \Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                          $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($pegawai->nama . ' | ' . $pegawai->nip))
                        @endphp
                        <br><br><img src="data:image/png;base64, {!! $base64 !!} "> <br>
                        ({{ baca_dokter($reg->dokter_id) }})
                      </p>
                    @endif
                @else
                <p>Nama &amp; Tanda Tangan <br/>Dokter <br> <br>
                  @if (isset($cetak_tte))
                      <img src="{{asset('barcode-tte-kominfo.jpeg')}}" style="width: 80px;">
                      <br>
                  @else 
                  @php
                    $pegawai = \Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($pegawai->nama . ' | ' . $pegawai->nip))
                  @endphp
                  <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                  @endif
                   ({{ baca_dokter($reg->dokter_id) }})
                </p>
                @endif
            
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table border="0" cellspacing="0" style="width: 100%">
            <tr >
              <td class="text-center">
                <p>Nama &amp; Tanda Tangan <br/> Apotik<br/><br/>
                  @if (isset($proses_tte))
                  <br><br>
                  #
                  <br><br><br><br>
                  @elseif (isset($tte_nonaktif))
                  <br>
                    @php
                      $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                  @else
                  <br/><br/><br/><br><br><br>
                  @endif
                  {{Auth::user()->name}}
                </p>
              </td>
            </tr>
          </table>
        </td>
        <td style="vertical-align: top">
          <table border="1" style="width: 100%;font-size:12px;"  cellspacing="0">
            <tr >
              <td>Validasi</td>
              <td>Nama</td>
              <td>Paraf</td>
            </tr>
            <tr>
              <td>ADM.Kasir</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td>Telah R/</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Pemberian Etiket</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Penyiapan Obat</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Verifikasi Obat</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Penyerahan Obat</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
