<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{@$reg->no_sep}}_{{$reg->pasien->nama}}</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
      .page_break_after { page-break-after: always; }
      ._border td{
        border-bottom: 1px dashed #000;
        /* border-top: 1px dashed #000; */
      }
    </style>
  </head>
  <body>
    {{-- RESEP --}}
    @if (count($penjualan) > 0)
      @foreach ($penjualan as $item)
          @php
              $resep_note = @\App\ResepNote::where('penjualan_id', $item->id)->first();
              // $detail = @\App\Penjualandetail::where('penjualan_id', $item->id)
              //   ->with('masterobat')
              //   ->groupBy('masterobat_id')
              //   ->selectRaw('sum(jumlah) as jumlah, masterobat_id,etiket,informasi1,informasi2, cara_minum')
              //   ->get();
              
              // $detail_racikan = @\App\Penjualandetail::where('obat_racikan', 'Y')->where('penjualan_id', $item->id)
              //   ->with('masterobat')
              //   ->groupBy('masterobat_id')
              //   ->selectRaw('sum(jumlah) as jumlah, masterobat_id,etiket,informasi1,informasi2')->get();

              $detail = @\App\ResepNoteDetail::where('obat_racikan', 'N')->where('resep_note_id', $resep_note->id)->get();
              $detail_racikan = @\App\ResepNoteDetail::where('obat_racikan', 'Y')->where('resep_note_id', $resep_note->id)->get();

              
              if ($resep_note) {
                $nama_racikan = $resep_note->nama_racikan;
                $no_resep = $resep_note->no_resep;
              } else {
                $nama_racikan = '';
                $no_resep   = '';
              }
              @$get_note = @\App\Penjualandetail::where('penjualan_id', $item->id)
                ->where('catatan', '!=', 'null')
                ->first();
          @endphp
        <div class="{{count($penjualan) > 1 ? 'page_break_after' : ''}}" >
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
              <td>:&nbsp; {{ $reg->no_sep }}</td>
              <td>No. RM</td>
              <td>:&nbsp; {{ $reg->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td>Diagnosa</td>
              <td>:&nbsp;&nbsp;
                @if ($resume)
                  {{@$resume['diagnosa_utama']}}, {{@$resume['diagnosa_tambahan']}}
                @endif
              </td>
              <td>Usia / Jns Kelamin</td>
              <td>:&nbsp;{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td>
            </tr>
            <tr>
              <td>Cara Bayar</td>
              <td>:&nbsp;&nbsp;{{ baca_carabayar($reg->bayar) }}</td>
              <td>Tanggal</td>
              <td>:&nbsp;&nbsp;{{ date('d-m-Y' ,strtotime($item->created_at)) }}
              </td>
            </tr><br>
            <tr>
              <td style="vertical-align: top;">Nama Dokter</td>
              <td style="vertical-align: top;">:&nbsp;&nbsp;<br>
                @php
                  $resepNote    = App\ResepNote::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
                  $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                  $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' | ' . @$dokter->nip . ' | ' . @$resepNote->antrian_dipanggil))
                @endphp
                <div style="padding-left: 40px;">
                  <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                </div>
                ({{ $dokter->nama }})
              </td>
              <td colspan="2"><br>Riwayat Alergi Obat<br>
                <input type="checkbox" value="Tidak" {{ @$fisik['riwayat_alergi']['pilihan'] == 'Tidak' ? 'checked' : '' }}>Tidak Ada <br>
                <input type="checkbox" value="Ya" {{ @$fisik['riwayat_alergi']['pilihan'] == 'Ya' ? 'checked' : '' }}>Ada, Nama Obat {{@$fisik['riwayat_alergi']['sebutkan']}}
              </td>
            </tr>
          </table>
          <br/>
            <center>
              <b>{{baca_carabayar($reg->bayar)}}</b>
            </center><br/>
            <table style="width:100%">
              <tr>
                <td style="width:50%;vertical-align:top">
                  <table>
                    @foreach ($detail as $d)
                    <tr class="_border">
                      <td>
                        <b>R/</b> 
                        {{--<span style="padding-left: 20px">--}}- {{@$d->logistik_batch->nama_obat}}[{{$d->qty}}]<br/>
                        {{@$d->cara_minum ?? @$d->takaran}},{{@$d->informasi}}<br/>
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
                    @foreach ($detail_racikan as $d)
                    <tr>
                      <td>
                        <b>R/</b> 
                        <span style="padding-left: 20px">{{@$d->logistik_batch->nama_obat}} [{{$d->qty}}]</span><br/>
                        {{@$d->cara_minum}},{{@$d->takaran}},{{@$d->informasi}}<br/>
                      </td>
                    </tr>
                    @endforeach
                  </table>
                </td>
                <td style="width:50%;vertical-align:top">
                  <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size:11px;">
                    @php
                        $telaah = json_decode($catatans->catatan ?? '{}', true);
                    @endphp
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
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['1'] == '1' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['1'] != '1' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Ketepatan Obat</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['2'] == '2' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['2'] != '2' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Ketepatan Dosis</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['3'] == '3' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['3'] != '3' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Ketepatan frekuensi</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['4'] == '4' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['4'] != '4' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>Ketepatan aturan minum/makan obat</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['5'] == '5' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['5'] != '5' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>Ketepatan waktu pemberian</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['6'] == '6' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['6'] != '6' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>Duplikasi pengobatan</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['7'] == '7' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['7'] != '7' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td>Potensi alergi atau sensitivitas</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['8'] == '8' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['8'] != '8' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>9</td>
                      <td>Interaksi antara obat dan obat lain atau dengan makanan </td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['9'] == '9' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['9'] != '9' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>10</td>
                      <td>Variasi kriteria penggunaan obat dari rumah sakit (obat dagang,obat generik)</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['10'] == '10' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['10'] != '10' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>11</td>
                      <td>Kontra indikasi</td>
                      <td><span style="font-family: 'DejaVu Sans'">&#10004;</span></td>
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['11'] == '11' ? '&#10004;' : '' !!}</span></td> --}}
                      {{-- <td><span style="font-family: 'DejaVu Sans';">{!! @$telaah['11'] != '11' ? '&#10004;' : '' !!}</span></td> --}}
                      <td></td>
                      <td></td>
                    </tr>
                  </table>
                  
                </td>
              </tr>
            </table> 
            <br/>
          <br>
          <table style="width: 100%" border="0" cellspacing="0">
            <tr>
              <td style="width: 50%;">
                <table border="0" cellspacing="0" style="width: 100%">
                  <tr>
                    <td class="text-center">
                      {{-- @if(!tandatangan($reg->dokter_id)) --}}
                      <p>Penerima Obat<br/>
                        @if ($reg->pasien->tanda_tangan)
                          <img src="{{ public_path('images/upload/ttd/' . @$reg->pasien->tanda_tangan) }}" alt="ttd" width="200" height="100"><br>
                        @else
                          <br/><br/>
                        @endif
                          {{ $reg->pasien->nama }}
                      </p>
                      {{-- @else
                      <p>Nama &amp; Tanda Tangan <br/>Dokter<br/><br/><br/><br/><br/>
                        ({{ baca_dokter($reg->dokter_id) }})
                      </p>
                      @endif --}}
                  
                    </td>
                  </tr>
                </table>
              </td>
              {{-- <td>
                <table border="0" cellspacing="0" style="width: 100%">
                  <tr >
                    <td class="text-center">
                      <p>Nama &amp; Tanda Tangan <br/> Apotik<br/><br/><br/>
                        @php
                          $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@Auth::user()->pegawai->nama . ' | ' . @Auth::user()->pegawai->nip))
                        @endphp
                        <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                        ({{ Auth::user()->pegawai->nama }})
                      </p>
                    </td>
                  </tr>
                </table>
              </td> --}}
              <td style="vertical-align: top">
                <table border="1" style="width: 100%;font-size:11px; text-align:center;"  cellspacing="0">
                  <tr >
                    <td>Validasi</td>
                    <td>Nama</td>
                    <td>Paraf</td>
                  </tr>
                  <tr>
                    <td>ADM. Kasir</td>
                    <td style="text-align: left;">{{$pegawai[559]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[559]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[559]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>Telaah R/</td>
                    <td style="text-align: left;">{{$pegawai[123]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[123]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[123]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>Pemberian Etiker</td>
                    <td style="text-align: left;">{{$pegawai[216]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[216]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[216]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>Penyiapan Obat</td>
                    <td style="text-align: left;">{{$pegawai[472]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[472]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[472]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>Penyerahan Obat</td>
                    <td style="text-align: left;">{{$pegawai[413]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[413]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[413]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  {{-- <tr>
                    <td>6</td>
                    <td style="text-align: left;">{{$pegawai[227]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[227]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[227]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td style="text-align: left;">{{$pegawai[472]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[472]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[472]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>8</td>
                    <td style="text-align: left;">{{$pegawai[559]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[559]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[559]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>9</td>
                    <td style="text-align: left;">{{$pegawai[917]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[917]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[917]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td style="text-align: left;">{{$pegawai[918]['nama']}}</td>
                    <td>
                      @if(!empty($pegawai[918]['tanda_tangan']))
                          <img src="{{ public_path('images/' . $pegawai[918]['tanda_tangan']) }}" alt="ttd" width="50">
                      @endif
                    </td>
                  </tr> --}}
                </table>
              </td>
            </tr>
          </table>
          <table style="width: 100%" border="0" cellspacing="0">
            <tr>
              <td style="width: 50%;"></td>
              <td style="width: 50%;">
                <h5 style="text-align:center;"><b>PERSETUJUAN PERUBAHAN RESEP</b></h5>
                <table border="1" style="width: 100%;font-size:11px; text-align:center;"  cellspacing="0">
                  <tr>
                    <td colspan="2"><b>PERUBAHAN RESEP</b></td>
                  </tr>
                  <tr>
                    <td>TERTULIS</td>
                    <td>MENJADI</td>
                  </tr>
                  <tr>
                    <td>&nbsp;<br>&nbsp;</td>
                    <td>&nbsp;<br>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>PETUGAS FARMASI</td>
                    <td>VERIFIKASI DOKTER</td>
                  </tr>
                  <tr>
                    <td>&nbsp;<br>&nbsp;</td>
                    <td>&nbsp;<br>&nbsp;</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      @endforeach
        
    @endif
  </body>
</html>
