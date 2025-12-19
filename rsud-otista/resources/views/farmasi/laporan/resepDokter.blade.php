<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
      .page-break {
          page-break-after: always;
      }

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
    @if (isset($proses_tte) || isset($proses_tte_apotik))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    <table border=0 style="width: 100%"> 
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
    {{-- <b>{{$no_resep}}</b> --}}
    <table style="width: 100%;font-size:12px;">
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
        <td>No SEP</td>
        <td>: {{ $reg->no_sep }}</td>
        <td>No. Rekam Medik</td>
        <td>:&nbsp; {{ $reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td>Cara Bayar</td>
        <td>:&nbsp;&nbsp;{{ baca_carabayar($reg->bayar) }}</td>
        <td>Usia / Jns Kelamin</td>
        <td>:&nbsp;{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td>
      </tr>
      <tr>
        <td>Dibuat</td>
        <td>:&nbsp;&nbsp;{{ baca_dokter($reg->dokter_id) }}
          {{-- :&nbsp;&nbsp;
            {{ date('d-m-Y' ,strtotime($penjualan->created_at)) }} --}}
        </td>
        <td>Tanggal</td>
        <td>:&nbsp;&nbsp;{{ date('d-m-Y' ,strtotime(@$resep_note->created_at ?? @$detail[0]->created_at)) }}
        </td>
      </tr>
    </table>
    <br/><br/>
      <center>
        <b>{{baca_carabayar($reg->bayar)}}</b>
      </center>
      <br/><br/>
      <table style="width: 100%;">
        <tr>
          <td style="width:50%;vertical-align:top">
            <table>
              @foreach ($detail as $d)
              <tr>
                <td>
                  <b>R/</b> 
                  <span style="padding-left: 20px">{{@$d->logistik_batch->nama_obat}}[{{$d->qty}}]</span><br/>
                  {{@$d->cara_minum}},{{@$d->takaran}},{{@$d->informasi}}<br/>
                </td>
              </tr>
              @endforeach
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
              </tr> <tr>
                <td>
                </td>
              </tr>
              <tr>
                <td>
                  <b>R/</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b style="color:red;font-size:12px;"><u><i>{{strtoupper($nama_racikan)}}</i></u></b><b style="color:red">RACIKAN</b><br/><br/>
                </td>
              </tr>
            </table>
          </td>
          <td style="width:50%;vertical-align:top">
            <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size:11px;">
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
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Ketepatan Obat</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Ketepatan Dosis</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>4</td>
                <td>Ketepatan frekuensi</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>5</td>
                <td>Ketepatan aturan minum/makan obat</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>6</td>
                <td>Ketepatan waktu pemberian</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>7</td>
                <td>Duplikasi pengobatan</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>8</td>
                <td>Potensi alergi atau sensitivitas</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>9</td>
                <td>Interaksi antara obat dan obat lain atau dengan makanan </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>10</td>
                <td>Variasi kriteria penggunaan obat dari rumah sakit (obat dagang,obat generik)</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>11</td>
                <td>Kontra indikasi</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>
          </td>
        </tr>
      </table> 
      <br/>
    <br>
    {{-- <div class="page-break"></div> --}}
    <table style="width: 100%" border="0" cellspacing="0">
      <tr>
        <td>
          <table border="0" cellspacing="0" style="width: 100%">
            <tr >
              <td class="text-center">
                <p>Nama &amp; Tanda Tangan <br/>Dokter
                  <br/><br/><br/>
                  @if (isset($proses_tte))
                  <br/>
                    #
                  <br/><br/><br/><br/>
                  @elseif(baca_status_tte($reg->dokter_id) == 'non_aktif') {{-- Untuk dokter non ASN Tanda tangan berupa QR Nama dan NIP --}}
                    @php
                     $pegawai = \Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                     $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($pegawai->nama . ' | ' . $pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                  @else
                  <br/><br/><br/><br/>
                  @endif
                  ({{ baca_dokter($reg->dokter_id) }})
                </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table border="0" cellspacing="0" style="width: 100%">
            <tr >
              <td class="text-center">
                <p>Nama &amp; Tanda Tangan <br/> Apotik
                  <br/><br/><br/>
                  @if (isset($proses_tte) || isset($proses_tte_apotik))
                  <br>
                    !
                  <br/><br/><br/><br/>
                  @elseif (isset($tte_nonaktif))
                    @php
                      $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                  @else
                  <br/><br/><br/><br/>
                  @endif
                  (<i>Petugas Apotik</i>)
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
