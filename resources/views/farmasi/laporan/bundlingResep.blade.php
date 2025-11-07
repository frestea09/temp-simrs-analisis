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
      .borderResume{ /* table, th, td */
        border: 1px solid black;
        border-collapse: collapse;
      }
      .tableResume{
        width: 100%;
      }
      .paddingResume{ /* th, td */
        padding: 15px;
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
              <td style="vertical-align: top;">Diagnosa</td>
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
              <td>:&nbsp;&nbsp;&nbsp;{{ date('d-m-Y' ,strtotime($item->created_at)) }}
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
                        <img src="{{ public_path('images/upload/ttd/' . $reg->pasien->tanda_tangan) }}" alt="ttd" width="200" height="100"><br>
                        @else
                        <br><br>
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

    {{-- SEP --}}
    @if (@$sep)
      <div style="{{count($penjualan) > 0 ? 'page-break-before:always' :''}}">
        <table style="width: 100%; margin-left: 20px;">
          <tr>
            <td style="width:50%;">
              <img src="{{ public_path('images/logo_bpjs.png') }}"style="height: 20px;">
            </td>
            <td class="text-center" style="font-weight: bold; padding-left:30px">
              SURAT ELIGIBILITAS PESERTA<br> {{ config('app.nama') }}
            </td>
            {{-- <td class="text-center" style="width:%; font-weight: bold;">
            </td> --}}
          </tr>
          <tr>
            <td style="vertical-align: top;">
              <table style="width:100%">
                <tr>
                  <td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
                </tr>
                {{-- <tr>
                  <td>No. Rujukan</td><td>: {{ @$reg ? @$reg->no_rujukan : '' }} </td> //
                </tr> --}}
                
                <tr>
                  <td>No. Kartu</td><td>: {{ @$sep['peserta']['noKartu']  }} (MR. {{ @$reg->pasien->no_rm }})</td>
                </tr>
                <tr>
                  <td>Nama Peserta</td><td>: {{ @$sep['peserta']['nama']  }}</td>
                </tr>
                {{-- <tr>
                  <td>Status pasien</td><td>: {{ $reg->status }} </td> //
                </tr> --}}
                <tr>
                  <td>Tgl Lahir</td><td>: {{ @$sep['peserta']['tglLahir']  }}, Kelamin : {{ @$sep['peserta']['kelamin']  }} </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>No. Telepon</td><td>: {{ @$reg->pasien->nohp }}</td>
                </tr>
                <tr>
                  <td>Sub / Spesialis</td><td>: {{ @$sep['poli'] }}</td>
                </tr>
                <tr>
                  <td>Dokter</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
                </tr>
                <tr>
                  <td>Faskes Perujuk</td><td>: {{@$rujukan[1]['rujukan']['provPerujuk']['nama']}}</td>
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
                    <p class="text-left small" style="font-size: 11px;">
                      @if (@$rujukan[0]['metaData']['code'] == '200')
                      * Surat Rujukan berlaku 1[satu] kali kunjungan, berlaku sampai dengan <b>{{@date('d/m/Y',strtotime("+3 month",strtotime(@$rujukan[1]['rujukan']['tglKunjungan'])))}}</b><br/>
                      @endif
                      <i><br/>
                      * Saya Menyetujui BPJS Kesehatan menggunakan informasi medis Pasien jika diperlukan. <br>
                      * SEP bukan sebagai bukti penjaminan peserta.
                      <br>**Dengan tampilnya luaran SEP elektronik ini merupakan hasil validasi terhadap<br/>
                      eligibilitas Pasien secara elektronik(validasi finger print atau biometrik/sistem validasi lain)<br/>
                      dan selanjutnya Pasien dapat mengakses pelayanan kesehatan rujukan sesuai ketentuan berlaku.<br/>
                      Kebenaran dan keaslian atas informasi data Pasien menjadi tanggung jawab penuh FKRTL.<br/><br/>
                      Cetakan ke 1 {{date('d-m-Y H:i:s')}}
                    {{-- Cetakan Ke 1 --}}
                    </i>
                  </p>
                  </td>
                </tr>
              </table>
            </td>
            <td style="vertical-align: top">
              <table style="width:100%">
                {{-- @if(cekKatarak(@$diags))
                  <tr><td>PASIEN OPERASI KATARAK</td></tr>
                @endif --}}
                @if(@$sep['katarak'] == '1')
                  <tr><td>PASIEN OPERASI KATARAK</td></tr>
                @endif
                <tr>
                  <td style="padding-left:30px;width:150px;">Tgl. SEP</td><td>: {{ date('d/m/Y',strtotime(@$sep['tglSep'])) }}</td>
                </tr>
                <tr>
                  <td style="padding-left:30px">Peserta</td> <td style="">: {{ @$sep['peserta']['jnsPeserta'] }}</td>
                </tr>
                
                {{-- <tr>
                  <td style="padding-left:30px">COB</td> <td>: {{ (@$sep['penjamin'] != '') ? 'Ya' : '' }}</td>
                </tr> --}}
                <tr>
                  <td style="padding-left:30px">Jns. Rawat</td>
                  <td>: {{ @$sep['jnsPelayanan'] }}</td>
                </tr>
                <tr>
                  <td style="padding-left:30px;vertical-align: top">Jns. Kunjungan</td>
                  <td>: - {{ @$sep['tujuanKunj']['nama'] }}
                    @if (@$sep['flagProcedure']['nama'])
                        <br/>&nbsp;&nbsp;- {{@$sep['flagProcedure']['nama']}}
                    @endif
                    @if (@$sep['kdPenunjang']['nama'])
                        <br/>- {{@$sep['kdPenunjang']['nama']}}
                    @endif
                    @if (@$sep['assestmenPel']['nama'])
                        <br/>- {{@$sep['assestmenPel']['nama']}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td style="padding-left:30px">Poli Perujuk</td>
                  <td>: {{@$rujukan[1]['rujukan']['poliRujukan']['nama']}}</td>
                </tr>
                <tr>
                  <td style="padding-left:30px">Kls. Hak</td>
                  <td>:
                    {{ @$sep['peserta']['hakKelas'] }}
                    </td>
                </tr>
                <tr>
                  <td style="padding-left:30px">Kls. Rawat</td>
                  <td>:
                    {{-- @if (substr($reg->status_reg, 0,1) == 'I') --}}
                      {{--  {{ $reg->hakkelas }}  --}}
                      {{ @$sep['kelasRawat'] }}
                    {{-- @else --}}
                    {{-- @endif --}}
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
                {{-- <tr>
                  <td colspan="2">&nbsp;</td>
                </tr> --}}
    
                <tr>
                  <td style="" colspan="" class="text-center">
                    
                  </td>
                  <td style="text-align:center" colspan="" class="text-center">
                    Pasien/Keluarga Pasien <br><br>
                    {{-- @if (@$kode_finger == '1')
                    @endif --}}
                    <img style="width:50px !important;" src="data:image/png;base64,{{DNS2D::getBarcodePNG(@$reg->pasien->nama.' - '.@$reg->pasien->no_rm, 'QRCODE', 4,4)}}" alt="barcode" />
                    <br>{{ @$sep['peserta']['nama']  }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          {{-- <tr>
            <td colspan="2" style="text-align: right;font-size:10px;">Cetakan ke 1 {{date('d-m-Y H:i:s')}}</td>
          </tr> --}}
        </table>
      </div>
        
    @endif

    {{-- RESEP KRONIS --}}
    @if (count($penjualan) > 0)
        @php
          $page = 0;
        @endphp
        @foreach ($penjualan as $item)
            @php
                $detail = \App\Penjualandetail::where('penjualan_id', $item->id)->where('is_kronis', 'Y')->get();
                $folio	= \Modules\Registrasi\Entities\Folio::where('namatarif', $item->no_resep)->get()->first();
                $uang_racik = $detail->sum('uang_racik');
                $total = $detail->sum('hargajual');
                $alkes	= \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                  ->where('penjualandetails.penjualan_id', $item->id)
                  ->where('masterobats.kategoriobat_id', 4)
                  ->where('is_kronis', 'Y')
                  ->sum('penjualandetails.hargajual');
            @endphp
            @if (count($detail) > 0)
              @php
                $page++;
              @endphp
            <div style="page-break-before:always">
              <table style="width:100%;">
                <tr style="font-size: 14px;">
                  <th style="text-align: center;">
                      {{ config('app.nama') }} <br />
                      {{ config('app.alamat') }}
                  </th>
                </tr>      
              </table>       
              <table style="width: 100%">
                <tr style="line-height:0.75; font-size: 14px;">
                  <td style="width: 50%; vertical-align: top;">
                    {{-- <b>{{ config('app.merek') }}</b> <br /> --}}
                      {{-- Website:  --}}
                      <table style="width: 100%;">
                        <tr> <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ @$reg->pasien->nama }}</td> </tr>
                        <tr> <td>No. SEP</td> <td>:</td> <td>{{ @$reg->no_sep }}</td> </tr>
                        <tr> <td>No. Rekam Medik</td> <td>:</td> <td>{{ @$reg->pasien->no_rm }}</td> </tr>
                        <tr> <td>Usia / Jns Kelamin</td> <td>:</td> <td>{{ !empty(@$reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td> </tr>
                        <tr> <td>Tgl Daftar</td> <td>:</td> <td>{{ @$reg->created_at }}</td> </tr>
                      </table>
                  </td>
                  <td style="width: 50%;">
                    {{-- Resume Data Pasien <br> --}}
                    <table style="width: 100%; ">
                      <tr style="font-size: 14px;"> <td>Unit yang Order</td> <td>:</td> 
                            <td>
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
                      <tr> <td>Sts. Cara Bayar</td> <td>:</td> <td>{{ baca_carabayar($reg->bayar) }} / {{ $reg->tipe_jkn }}</td> </tr>
                      <tr> <td>Dokter DPJP</td> <td>:</td> <td>{{ baca_dokter($reg->dokter_id) }}</td> </tr>
                      <tr> <td>Pembuat Resep</td> <td>:</td> <td>{{ baca_pegawai($item->pembuat_resep) }}</td> </tr>
                      {{--  <tr><td>Dokter</td><td>:</td><td>{{ ($penjualan->dokter_id != null) ? baca_dokter($penjualan->dokter_id) : '' }}</td></tr>  --}}
                      <tr> <td>Tanggal Input</td> <td>:</td> <td>{{ date('d-m-Y' ,strtotime($item->created_at)) }}</td> </tr>
                    </table>
                  </td>
                </tr>
                <tr style="line-height:0.5; font-size: 14px;">
                    <th colspan="2" style="text-align: center"><br> Faktur Penjualan Obat Kronis</th>  
                </tr>
              
              </table>
              <table class="" style="width: 90%;">
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <td colspan="5"><i> No. Resep : {{ @$item->no_resep }} </i></td>
                </tr>
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <th style="width: 5%; text-align: center">No</th>
                  <th>Resume Biaya dan Nama Obat</th>
                  <th style="text-align: center; width: 10%" colspan="2">Qty</th>
                  {{-- <th style="text-align: center; width: 10%">Uang Racik</th> --}}
                  {{-- <th style="text-align: center; width: 10%">Harga</th> --}}
                  <th style="text-align: center; width: 10%">Total</th>
                </tr>
              @foreach ($detail as $key=>$d)
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <td style="text-align: center">{{ $key+1 }}</td>
                  <td>{{ $d->masterobat->nama }}</td>
                  <td style="text-align: center " colspan="2">{{ $d->jumlah }}</td>
                  {{-- <td style="text-align: right">{{ number_format($d->uang_racik)  }}</td> --}}
                  {{-- <td style="text-align: right">{{ number_format(($d->hargajual / $d->jumlah)+$d->uang_racik)  }}</td> --}}
                  <td style="text-align: right">{{ number_format($d->hargajual+$d->uang_racik) }}</td>
                </tr>
              @endforeach
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <td colspan="2"><i>Terbilang: {{ terbilang($total+@$folio->jasa_racik+$uang_racik) }} rupiah</i></td>
                  <th style="text-align: right" colspan="2">Sub Total</th>
                  <th style="text-align: right">{{ number_format($total+$uang_racik) }}</th>
                </tr>
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  {{-- <th colspan="2">Total Obat : {{ number_format($obat) }}</th> --}}
                  <th colspan="2"></th>
                  <th style="text-align: right" colspan="2">Jasa</th>
                  <th style="text-align: right">{{ number_format(@$folio->jasa_racik) }}</th>
                </tr>
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <th colspan="2">Total Alkes : {{ number_format($alkes) }}</th>
                  <th style="text-align: right" colspan="2">Total Tagihan</th>
                  <th style="text-align: right">{{ number_format($total+@$folio->jasa_racik+$uang_racik) }}</th>
                </tr>
              </table>
            
              <table>
                <tr>
                  <td style="text-align: center;">
                    Petugas <br/>
                    @if (isset($proses_tte))
                      @if ($page == 1)
                        <br/><br/><br/>
                          #
                        <br/><br/><br/><br/>
                      @else
                        <br/>
                        <img style="width: 75px; height: 75px;" src="{{public_path($qrcode)}}" alt="qr">
                        <br/><br/>
                      @endif
                    @elseif (isset($tte_nonaktif))
                        <br/>
                        <img style="width: 75px; height: 75px;" src="{{public_path($qrcode)}}" alt="qr">
                        <br/><br/>
                    @else
                      <br/> <br>
                      @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                      @endphp
                      <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                    @endif
                    {{ Auth::user()->pegawai->nama }}
                  </td>
                </tr>
              </table>
            </div>
            @endif
        @endforeach
    @endif

    {{-- RESEP NON KRONIS --}}
    @if (count($penjualan) > 0)
        @php
          $page = 0;
        @endphp
        @foreach ($penjualan as $item)
            @php
                $detail = \App\Penjualandetail::where('penjualan_id', $item->id)->where('is_kronis', 'N')->get();
                $folio	= \Modules\Registrasi\Entities\Folio::where('namatarif', $item->no_resep)->get()->first();
                $uang_racik = $detail->sum('uang_racik');
                $total = $detail->sum('hargajual');
                $alkes	= \App\Penjualandetail::join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                  ->where('penjualandetails.penjualan_id', $item->id)
                  ->where('masterobats.kategoriobat_id', 4)
                  ->where('is_kronis', 'N')
                  ->sum('penjualandetails.hargajual');
            @endphp
            @if (count($detail) > 0)
              @php
                $page++;
              @endphp
            <div style="page-break-before:always">
              <table style="width:100%;">
                <tr style="font-size: 14px;">
                  <th style="text-align: center;">
                      {{ config('app.nama') }} <br />
                      {{ config('app.alamat') }}
                  </th>
                </tr>      
              </table>       
              <table style="width: 100%">
                <tr style="line-height:0.75; font-size: 14px;">
                  <td style="width: 50%; vertical-align: top;">
                    {{-- <b>{{ config('app.merek') }}</b> <br /> --}}
                      {{-- Website:  --}}
                      <table style="width: 100%;">
                        <tr> <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ $reg->pasien->nama }}</td> </tr>
                        <tr> <td>No. SEP</td> <td>:</td> <td>{{ $reg->no_sep }}</td> </tr>
                        <tr> <td>No. Rekam Medik</td> <td>:</td> <td>{{ $reg->pasien->no_rm }}</td> </tr>
                        <tr> <td>Usia / Jns Kelamin</td> <td>:</td> <td>{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td> </tr>
                        <tr> <td>Tgl Daftar</td> <td>:</td> <td>{{ $reg->created_at }}</td> </tr>
                      </table>
                  </td>
                  <td style="width: 50%;">
                    {{-- Resume Data Pasien <br> --}}
                    <table style="width: 100%; ">
                      <tr style="font-size: 14px;"> <td>Unit yang Order</td> <td>:</td> 
                            <td>
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
                      <tr> <td>Sts. Cara Bayar</td> <td>:</td> <td>{{ baca_carabayar($reg->bayar) }} / {{ $reg->tipe_jkn }}</td> </tr>
                      <tr> <td>Dokter DPJP</td> <td>:</td> <td>{{ baca_dokter($reg->dokter_id) }}</td> </tr>
                      <tr> <td>Pembuat Resep</td> <td>:</td> <td>{{ baca_pegawai($item->pembuat_resep) }}</td> </tr>
                      <tr> <td>Tanggal Input</td> <td>:</td> <td>{{ date('d-m-Y' ,strtotime($item->created_at)) }}</td> </tr>
                    </table>
                  </td>
                </tr>
                <tr style="line-height:0.5; font-size: 14px;">
                  @if (substr($reg->status_reg, 0,1) == 'J')
                    <th colspan="2" style="text-align: center"><br> Faktur Penjualan Apotik Rawat Jalan</th>            
                  @elseif (substr($reg->status_reg, 0,1) == 'G')
                    <th colspan="2" style="text-align: center"><br> Faktur Penjualan Apotik Rawat Darurat</th>  
                  @elseif (substr($reg->status_reg, 0,1) == 'I') 
                    <th colspan="2" style="text-align: center"><br> Faktur Penjualan Apotik Rawat Inap</th>
                  @endif
                </tr>
              
              </table>
              <table class="" style="width: 90%;">
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <td colspan="5"><i> No. Resep : {{ $item->no_resep }} </i></td>
                </tr>
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <th style="width: 5%; text-align: center">No</th>
                  <th>Resume Biaya dan Nama Obat</th>
                  <th style="text-align: center; width: 10%" colspan="2">Qty</th>
                  {{-- <th style="text-align: center; width: 10%">Uang Racik</th> --}}
                  {{-- <th style="text-align: center; width: 10%">Harga</th> --}}
                  <th style="text-align: center; width: 10%">Total</th>
                </tr>
              @foreach ($detail as $key=>$d)
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <td style="text-align: center">{{ $key+1 }}</td>
                  <td>{{ $d->masterobat->nama }}</td>
                  <td style="text-align: center " colspan="2">{{ $d->jumlah }}</td>
                  {{-- <td style="text-align: right">{{ number_format($d->uang_racik)  }}</td> --}}
                  {{-- <td style="text-align: right">{{ number_format(($d->hargajual / $d->jumlah)+$d->uang_racik)  }}</td> --}}
                  <td style="text-align: right">{{ number_format($d->hargajual+$d->uang_racik) }}</td>
                </tr>
              @endforeach
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <td colspan="2"><i>Terbilang: {{ terbilang($total+@$folio->jasa_racik+$uang_racik) }} rupiah</i></td>
                  <th style="text-align: right" colspan="2">Sub Total</th>
                  <th style="text-align: right">{{ number_format($total+$uang_racik) }}</th>
                </tr>
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  {{-- <th colspan="2">Total Obat : {{ number_format($obat) }}</th> --}}
                  <th colspan="2"></th>
                  <th style="text-align: right" colspan="2">Jasa</th>
                  <th style="text-align: right">{{ number_format(@$folio->jasa_racik) }}</th>
                </tr>
                <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
                  <th colspan="2">Total Alkes : {{ number_format($alkes) }}</th>
                  <th style="text-align: right" colspan="2">Total Tagihan</th>
                  <th style="text-align: right">{{ number_format($total+@$folio->jasa_racik+$uang_racik) }}</th>
                </tr>
              </table>

              <table>
                <tr>
                  <td>
                    Petugas <br/><br/>
                    @php
                      $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                    {{ Auth::user()->pegawai->nama }}
                  </td>
                </tr>
              </table>
            </div>
            @endif
        @endforeach
    @endif

    {{-- SURAT --}}
    @if (@$rujukanObat->nama_obat)
      <div style="page-break-before:always">
      <div>
        <table border=0 style="width: 100%"> 
          <tr>
            <td style="text-align: center">
              <b style="font-size:15px;">{{ strtoupper(configrs()->pt) }}</b><br/>
              <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
              <b style="font-size:10px;">{{ configrs()->alamat }}</b><br>
              <b style="font-size:10px;">Telp. {{ configrs()->tlp }}</b><br>
              <b style="font-size:10px;">Email. {{ configrs()->email }}</b><br>
            </td>
          </tr>
      </table>
      <hr>
      <div class="content">
          <br><br>
          <div>
              <p>Dengan Hormat,</p>
              <p>Melalui surat ini, saya menerangkan bahwa pasien saya :</p>
          </div>
          <br><br>
          <div class="detail-pasien">
              <table border="0" style="width: 100%;">
                  <tr>
                      <td style="width: 25%;">
                          Nama
                      </td>
                      <td>
                          : {{$pasien->nama}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 25%;">
                          No RM
                      </td>
                      <td>
                          : {{$pasien->no_rm}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 25%;">
                          Diagnosa
                      </td>
                      <td>
                          : {{$rujukanObat->diagnosa}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 25%;">
                          Nama Obat
                      </td>
                      <td>
                          : <b>{{$rujukanObat->nama_obat}}</b>
                      </td>
                  </tr>
              </table>
          </div>
          <br><br>
          <div style="text-align: justify;">
              <p>
                  Karena tidak tersedianya pemeriksaan resistensi terhadap Asam Asetilsalisilat, dan pasien memerlukan terapi <b>{{$rujukanObat->nama_obat}}</b> untuk kasus Peripheral Artherial Disease (PAD) dan Small Vessel Disease Cerebry (CSVD) maka saya menyatakan bahwa pasien tidak dapat menggunakan lagi terapi Asam Asetilsalisilat dengan alasan klinis.
              </p>
          </div>
          <br><br><br>
          <div class="ttd-area">
              <table border="0" style="width: 100%;">
                  <tr>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%; text-align:center;">
                          Hormat Saya, <br><br><br>
                          @php
                              $dokter = Modules\Pegawai\Entities\Pegawai::find($registrasi->dokter_id);
                              if ($dokter) {
                                  $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                              }
                          @endphp
                          @if ($dokter)
                              <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                              ({{$dokter->nama}})
                          @else
                              <br><br><br><br>
                              (....................................)
                          @endif
                      </td>
                  </tr>
              </table>
          </div>
      </div>
    @endif
    @if (@$rujukanObat->riwayat)
      <div style="page-break-before:always">
      <table border=0 style="width: 100%"> 
          <tr>
              <td style="width:10%;">
                  <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
              </td>
              <td style="text-align: center">
                  <b style="font-size:15px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                  <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                  <b style="font-size:10px;">{{ configrs()->alamat }}</b><br>
                  <b style="font-size:10px;">Telp. {{ configrs()->tlp }}</b>
                  <b style="font-size:10px;">Email. {{ configrs()->email }}</b><br>
              </td>
          </tr>
      </table>
      <hr>
      <br>
      <div class="content">
          <div>
              <p>Dengan ini menerangkan bahwa pasien :</p>
          </div>
          <br>
          <div class="detail-pasien">
              <table border="0" style="width: 100%;">
                  <tr>
                      <td style="width: 40%;">
                          Nama
                      </td>
                      <td>
                          : {{$pasien->nama}} ({{$pasien->kelamin}})
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 40%;">
                          No RM
                      </td>
                      <td>
                          : {{$pasien->no_rm}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 40%;">
                          Berdasarkan penggunaan obat di Rumah Sakit
                      </td>
                      <td>
                          : {{$rujukanObat->rumah_sakit}}
                      </td>
                  </tr>
              </table>
          </div>
          <br><br>
          <div>
              <p>Pasien tersebut :</p>
          </div>
          <div class="detail-riwayat">
              @php
                  $riwayat = json_decode($rujukanObat->riwayat);
              @endphp
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_acei->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat ACEI</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat ACEI</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Captopril)
                                  </li>
                                  <li>
                                      (Lisinopril)
                                  </li>
                                  <li>
                                      (Ramipril)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_acei->captopril}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_acei->lisinopril}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_acei->ramipril}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_statin->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat STATIN</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat STATIN</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Simvastatin)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_statin->simvastatin}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_arb->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat ARB</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat ARB</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Candesartan)
                                  </li>
                                  <li>
                                      (Irbesartan)
                                  </li>
                                  <li>
                                      (Telmisartan)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_arb->candesartan}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_arb->irbesarta}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_arb->telmisartan}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_insulin->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat Insulin</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat Insulin</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Human Insulin: short acting / intermediate acting / mix insulin)
                                  </li>
                                  <li>
                                      (Analog Insulin: rapid acting / mix insulin / long acting)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_insulin->human_insulin}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_insulin->analog_insulin}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
          <br><br><br>
          <div class="ttd-area">
              <table border="0" style="width: 100%;">
                  <tr>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%; text-align:center;">
                          Hormat Saya, <br><br><br>
                          @php
                              $dokter = Modules\Pegawai\Entities\Pegawai::find($registrasi->dokter_id);
                              if ($dokter) {
                                  $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                              }
                          @endphp
                          @if ($dokter)
                              <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                              ({{$dokter->nama}})
                          @else
                              <br><br><br><br>
                              (....................................)
                          @endif
                      </td>
                  </tr>
              </table>
          </div>
        </div>
      </div>
    @elseif (@$rujukanObatOld->riwayat)
    <div style="page-break-before:always">
      <table border=0 style="width: 100%"> 
          <tr>
              <td style="width:10%;">
                  <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
              </td>
              <td style="text-align: center">
                  <b style="font-size:15px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                  <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                  <b style="font-size:10px;">{{ configrs()->alamat }}</b><br>
                  <b style="font-size:10px;">Telp. {{ configrs()->tlp }}</b>
                  <b style="font-size:10px;">Email. {{ configrs()->email }}</b><br>
              </td>
          </tr>
      </table>
      <hr>
      <br>
      <div class="content">
          <div>
              <p>Dengan ini menerangkan bahwa pasien :</p>
          </div>
          <br>
          <div class="detail-pasien">
              <table border="0" style="width: 100%;">
                  <tr>
                      <td style="width: 40%;">
                          Nama
                      </td>
                      <td>
                          : {{$pasien->nama}} ({{$pasien->kelamin}})
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 40%;">
                          No RM
                      </td>
                      <td>
                          : {{$pasien->no_rm}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 40%;">
                          Berdasarkan penggunaan obat di Rumah Sakit
                      </td>
                      <td>
                          : {{$rujukanObatOld->rumah_sakit}}
                      </td>
                  </tr>
              </table>
          </div>
          <br><br>
          <div>
              <p>Pasien tersebut :</p>
          </div>
          <div class="detail-riwayat">
              @php
                  $riwayat = json_decode($rujukanObatOld->riwayat);
              @endphp
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_acei->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat ACEI</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat ACEI</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Captopril)
                                  </li>
                                  <li>
                                      (Lisinopril)
                                  </li>
                                  <li>
                                      (Ramipril)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_acei->captopril}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_acei->lisinopril}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_acei->ramipril}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_statin->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat STATIN</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat STATIN</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Simvastatin)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_statin->simvastatin}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_arb->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat ARB</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat ARB</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Candesartan)
                                  </li>
                                  <li>
                                      (Irbesartan)
                                  </li>
                                  <li>
                                      (Telmisartan)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_arb->candesartan}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_arb->irbesarta}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_arb->telmisartan}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
              <div>
                  @if (@$riwayat->riwayat_penggunaan_obat_insulin->status == "Tidak ada")
                      <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat Insulin</p>
                  @else
                      <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat Insulin</p>
                  @endif
                  <table border="0" style="width: 100%;">
                      <tr>
                          <td style="width: 50%;">
                              <ul>
                                  <li>
                                      (Human Insulin: short acting / intermediate acting / mix insulin)
                                  </li>
                                  <li>
                                      (Analog Insulin: rapid acting / mix insulin / long acting)
                                  </li>
                              </ul>
                          </td>
                          <td style="text-align: end;">
                              <ul style="list-style-type: none">
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_insulin->human_insulin}}</span>
                                  </li>
                                  <li>
                                      <span>Sejak : {{@$riwayat->riwayat_penggunaan_obat_insulin->analog_insulin}}</span>
                                  </li>
                              </ul>
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
          <br><br><br>
          <div class="ttd-area">
              <table border="0" style="width: 100%;">
                  <tr>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%;">&nbsp;</td>
                      <td style="width: 25%; text-align:center;">
                          Hormat Saya, <br><br><br>
                          @php
                              $dokter = Modules\Pegawai\Entities\Pegawai::find($registrasi->dokter_id);
                              if ($dokter) {
                                  $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                              }
                          @endphp
                          @if ($dokter)
                              <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                              ({{$dokter->nama}})
                          @else
                              <br><br><br><br>
                              (....................................)
                          @endif
                      </td>
                  </tr>
              </table>
          </div>
        </div>
      </div>
    @endif

    {{-- E-Resume --}}
    @if (substr($reg->status_reg, 0, 1) != 'I')
    <div style="page-break-before: always;">
      <table class="borderResume tableResume">
        <tr>
          <th class="borderResume paddingResume" colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"><br>
            <b style="font-size:12px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
          </th>
          <th class="borderResume paddingResume" colspan="5" style="font-size: 20pt;">
            <b>E-RESUME {{ $reg->poli->politype == 'G' ? 'RAWAT DARURAT' : 'RAWAT JALAN' }}</b>
          </th>
        </tr>
        <tr>
            <td class="borderResume paddingResume" colspan="2">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td class="borderResume paddingResume" colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }}
            </td>
            <td class="borderResume paddingResume">
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td class="borderResume paddingResume">
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td class="borderResume paddingResume" colspan="4">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td class="borderResume paddingResume">
              <b>Poli</b><br>
              {{ @$reg->poli->nama }}
            </td>
            <td class="borderResume paddingResume">
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td class="borderResume paddingResume" colspan="3">
            <b>Tanggal Masuk</b><br>
            {{date('d-m-Y H:i', strtotime(@$reg->created_at))}}
          </td>
          <td class="borderResume paddingResume" colspan="3">
            <b>Tanggal Keluar</b><br>
            @if ($cppt)
              {{date('d-m-Y, H:i', strtotime(@$cppt->created_at))}}
            @elseif ($soap)
              {{date('d-m-Y, H:i', strtotime(@$soap->created_at))}}
            @endif
          </td>
        </tr>
        <tr>
          <td class="borderResume paddingResume">
              <b>ANAMNESA</b>
          </td>
          <td class="borderResume paddingResume" colspan="5">
            @if (@$reg->poli->politype == 'G')
                {{@json_decode(@$resume_igd->content, true)['anamnesa']}}
            @else
              @if ($cppt)
                {{ @$cppt->subject }}
              @elseif ($soap)
                {{@json_decode(@$soap->fisik, true)['anamnesa']}}
              @endif
            @endif
          </td>
        </tr>
        <tr>
          <td class="borderResume paddingResume">
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td class="borderResume paddingResume" colspan="5">
            @if (@$reg->poli->politype == 'G')
                {{@json_decode(@$resume_igd->content, true)['pemeriksaan_fisik']}}
            @else
              @if ($cppt)
                {{ @$cppt->object }}
                <br>
                @if ($cpptPerawat)
                  <ul>
                    <li>
                      Tanda Vital<br/>
                      <ul>
                        <li>TD : {{ @$cpptPerawat->tekanan_darah }} mmHG</li>
                        <li>Nadi : {{ @$cpptPerawat->nadi }} x/menit</li>
                        <li>RR : {{ @$cpptPerawat->frekuensi_nafas }} x/menit</li>
                        <li>Temp : {{ @$cpptPerawat->suhu }} °C</li>
                        <li>Berat Badan : {{ @$cpptPerawat->berat_badan }} Kg</li>
                      </ul>
                    </li>
                  </ul>
                @endif
              @elseif ($soap)
                {{@json_decode(@$soap->fisik, true)['pemeriksaan_fisik']}}
                <br>
                <ul>
                  <li>
                    Tanda Vital<br/>
                    <ul>
                      <li>TD : {{ @$soap['tanda_vital']['tekanan_darah'] }} mmHG</li>
                      <li>Nadi : {{ @$soap['tanda_vital']['nadi'] }} x/menit</li>
                      <li>RR : {{ @$soap['tanda_vital']['RR'] }} x/menit</li>
                      <li>Temp : {{ @$soap['tanda_vital']['temp'] }} °C</li>
                      <li>Berat Badan : {{ @$soap['tanda_vital']['BB'] }} Kg</li>
                      <li>Tinggi Badan : {{ @$soap['tanda_vital']['TB'] }} Cm</li>
                    </ul>
                  </li>
                </ul>
              @endif
            @endif
          </td>
        </tr>
        @if (@$reg->poli->politype == 'G')
          @php
            $asessment = json_decode(json_encode($asessment), true);
          @endphp
          <tr>
            <td class="borderResume paddingResume">
              <b>Tanda Vital</b>
            </td>
            <td class="borderResume paddingResume" colspan="5">
              TD : {{@$asessment_awal['igdAwal']['tandaVital']['tekananDarah'] ?? @$asessment_awal_ponek['tanda_vital']['tekanan_darah']}} mmHg<br/>
              Frekuensi Nadi : {{@$asessment_awal['igdAwal']['tandaVital']['frekuensiNadi'] ?? @$asessment_awal_ponek['tanda_vital']['nadi']}} x/Menit<br/>
              Suhu : {{@$asessment_awal['igdAwal']['tandaVital']['suhu'] ?? @$asessment_awal_ponek['tanda_vital']['suhu']}} &deg;C<br/>
              RR : {{@$asessment_awal['igdAwal']['tandaVital']['RR'] ?? @$asessment_awal_ponek['tanda_vital']['frekuensi_nafas']}} x/Menit<br/>
              SPO2 : {{@$asessment_awal['igdAwal']['tandaVital']['spo2'] ?? @$asessment_awal_ponek['tanda_vital']['SPO2']}} spo2<br/>
            </td>
          </tr>
          <tr>
            <td class="borderResume paddingResume">
              <b>GCS</b>
            </td>
            <td class="borderResume paddingResume" colspan="5">
              <div>
                <input class="form-check-input"
                    {{ @$asessment['triage']['GCS']['<9'] == 'true' ? 'checked' : '' }}
                    type="checkbox" value="true">
                <label class="form-check-label">GCS &lt; 9 </label>

                <input class="form-check-input"
                    {{ @$asessment['triage']['GCS']['9-12'] == 'true' ? 'checked' : '' }}
                    type="checkbox" value="true">
                <label class="form-check-label">GCS 9-12</label>

                <input class="form-check-input"
                    {{ @$asessment['triage']['GCS']['>12'] == 'true' ? 'checked' : '' }}
                    type="checkbox" value="true">
                <label class="form-check-label">GCS >12</label>

                <input class="form-check-input"
                    {{ @$asessment['triage']['GCS']['normalGCS']['green1'] == 'true' ? 'checked' : '' }}
                    type="checkbox" value="true">
                <label class="form-check-label">Normal GCS</label>
 
                <input class="form-check-input"
                    {{ @$asessment['triage']['GCS']['normalGCS']['green2'] == 'true' ? 'checked' : '' }}
                    type="checkbox" value="true">
                <label class="form-check-label">Normal GCS</label>
              </div>
            </td>
          </tr>
          <tr>
            <td class="borderResume paddingResume">
              <b>Skala</b>
            </td>
            <td class="borderResume paddingResume" colspan="5">
              {{ @$asessment_awal['igdAwal']['skalaNyeri'] }}
            </td>
          </tr>
        @endif
        <tr>
          <td class="borderResume paddingResume">
              <b>DIAGNOSA UTAMA</b>
          </td>
          <td class="borderResume paddingResume" colspan="3">
            @if (@$reg->poli->politype == 'G')
            {{@json_decode(@$resume_igd->content, true)['diagnosa_utama']}}
            @else
            @if ($cppt)
            {!! e(@$cppt->assesment) !!}
            @elseif ($soap)
            {!! e(@json_decode(@$soap->fisik, true)['diagnosis']) !!}
            @endif
            @endif
          </td>
          <td class="borderResume paddingResume">
            <b>KODE ICD X</b>
          </td>
          <td class="borderResume paddingResume" colspan="1">
            {{-- Penutupan pengambilan icd dari resume, sepakat untuk icd full dari input koding --}}
            {{-- @php
            $icdxDiagnosaUtama = json_decode(@$resume_igd->content, true)['icdx_diagnosa_utama'] ?? null;
            @endphp --}}
            {{-- @if (@$reg->poli->politype == 'G' && (@json_decode(@$resume_igd->content, true)['icdx_diagnosa_utama']))
                {{@json_decode(@$resume_igd->content, true)['icdx_diagnosa_utama']}}
            @else --}}
              <ul>
                @foreach ($icd10Primary as $icd)
                  <li>{{baca_icd10($icd->icd10)}} - {{$icd->icd10}}</li>
                @endforeach
              </ul>
            {{-- @endif --}}
          </td>
        </tr>
        <tr>
          <td class="borderResume paddingResume">
              <b>DIAGNOSA TAMBAHAN</b>
          </td>
          <td class="borderResume paddingResume" colspan="3">
            @if (@$reg->poli->politype == 'G')
                {{ preg_replace('/[^\P{C}\t\n\r ]+/u', '', @json_decode(@$resume_igd->content, true)['diagnosa_tambahan'] ?? '') }} <br>
                {!! implode('<br>', preg_replace('/[^\P{C}\t\n\r ]+/u', '', @json_decode(@$resume_igd->content, true)['tambahan_diagnosa_tambahan'] ?? [])) !!}
            @else
              @if ($cppt)
                {{ @$cppt->diagnosistambahan }}
              @elseif ($soap)
                {{@json_decode(@$soap->fisik, true)['diagnosistambahan']}}
              @endif
            @endif
          </td>
          <td class="borderResume paddingResume">
              <b>KODE ICD X</b>
          </td>
          <td class="borderResume paddingResume" colspan="1">
            {{-- @php
                $icdxDiagnosaTambahan = json_decode(@$resume_igd->content, true)['icdx_diagnosa_tambahan'] ?? null;
            @endphp --}}
            {{-- @if (@$reg->poli->politype == 'G' && (@json_decode(@$resume_igd->content, true)['icdx_diagnosa_utama']))
                {{@json_decode(@$resume_igd->content, true)['icdx_diagnosa_tambahan']}} <br>
                {!! implode('<br>', preg_replace('/[^\P{C}\t\n\r ]+/u', '', @json_decode(@$resume_igd->content, true)['tambahan_icdx_diagnosa_tambahan'] ?? [])) !!}
            @else --}}
              <ul>
                @foreach ($icd10Secondary as $icd)
                  <li>{{baca_icd10($icd->icd10)}} - {{$icd->icd10}}</li>
                @endforeach
              </ul>
            {{-- @endif --}}
          </td>
        </tr>
        <tr>
          <td colspan="3" class="borderResume paddingResume" style="vertical-align: top;">
              <b>TINDAKAN</b><br/>
              {{-- @if (@$reg->poli->politype == 'G')
                {{@json_decode(@$resume_igd->content, true)['tindakan']}}
              @else --}}
                  @if ($cppt)
                    {{ @$cppt->planning }} <br>
                  @elseif ($soap)
                    {{@json_decode(@$soap->fisik, true)['planning']}} <br>
                  @endif
                  @foreach (@$folios as $tindakan)
                  - {{ @$tindakan->namatarif }}<br>
                  @endforeach
              {{-- @endif --}}
          </td>
          <td class="borderResume paddingResume" colspan="3" style="vertical-align: top;">
              <b>KODE ICD IX</b><br/>
              {{-- @if (@$reg->poli->politype == 'G')
                {{@json_decode(@$resume_igd->content, true)['icdix_tindakan']}}
              @else --}}
                <ul>
                  @foreach ($icd9 as $icd)
                    <li>{{baca_icd9($icd->icd9)}} - {{$icd->icd9}}</li>
                  @endforeach
                </ul>
              {{-- @endif --}}
          </td>
        </tr>
        <tr>
          <td class="borderResume paddingResume">
              <b>PENGOBATAN</b>
          </td>
          <td class="borderResume paddingResume" colspan="5">
            @if (@$reg->poli->politype == 'G')
                {{@json_decode(@$resume_igd->content, true)['pengobatan']}}
            @else
              @foreach (@$obats as $obat)
              - {{ substr(strtoupper(baca_obat(@$obat->masterobat_id)), 0, 40) }}<br>
              @endforeach
            @endif
          </td>
        </tr>
        <tr>
          <td class="borderResume paddingResume">
              <b>CARA PULANG</b>
          </td>
          @if (@$reg->poli->politype == 'G')
            <td class="borderResume paddingResume" colspan="5">
                {{@json_decode(@$resume_igd->content, true)['cara_pulang']}}
            </td>
          @else
          @php
            if ($soap) {
              @$assesments  = @json_decode(@$soap->fisik, true);
            } elseif ($cppt) {
              @$assesments  = @json_decode(@$cppt->discharge, true);
            }
          @endphp
          <td class="borderResume paddingResume" colspan="5">
                  <input type="checkbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                  <input type="checkbox" name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$assesments['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                  <input type="checkbox" name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat" {{@$assesments['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                  <input type="checkbox" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesments['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                  <input type="checkbox" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesments['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                  <input type="checkbox" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesments['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                  <input type="checkbox" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesments['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                  {{-- {{ $reg->kondisi_akhir_pasien ? @baca_carapulang($reg->kondisi_akhir_pasien) :'' }} --}}
          </td>
          @endif
        </tr>

      </table>
      <br>

        @php
            $ttd_pasien = \Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
            $sign_pad = App\TandaTangan::where('registrasi_id', $reg->id)
                ->where('jenis_dokumen', 'e-resume')
                ->orderByDesc('id')
                ->first();
            $sign_rehab = App\TandaTangan::where('registrasi_id', $reg->id)
                ->where('jenis_dokumen', 'layanan-rehab')
                ->orderByDesc('id')
                ->first();
            $ttd = App\TandaTangan::where('registrasi_id', $reg->id)
                ->orderByDesc('id')
                ->first();
        @endphp
      <table class="borderResume tableResume" style="border: 0px; margin-top: 3rem;">
        <tr style="border: 0px;">
          <td colspan="3" style="text-align: center; border: 0px; width: 60%;">
            @if (ttdPasienBpjs($reg->created_at))
              Tanda Tangan Pasien / Keluarga atau Wali
            @elseif ($sign_pad)
              Tanda Tangan Pasien
            @endif
          </td>
          <td colspan="3" style="text-align: center; border: 0px;">
            Dokter 
          </td>
        </tr>
        <tr style="border: 0px;">
          <td colspan="3" style="text-align: center; border: 0px; height: 1cm;">
            @if (ttdPasienBpjs($reg->created_at))
                @if (!empty($ttd_pasien->tanda_tangan))
                    <img src="{{ url(path_ttd().'/images/upload/ttd/' . @$ttd_pasien->tanda_tangan) }}" alt="ttd" width="200" height="100">
                    {{-- <img src="{{ public_path('images/upload/ttd/' . $ttd_pasien->tanda_tangan) }}" alt="ttd" width="200" height="100"> --}}
                @elseif (!empty($ttd->tanda_tangan))
                    {{-- <img src="{{ public_path('images/upload/ttd/' . $ttd->tanda_tangan) }}" alt="ttd" width="200" height="100"> --}}
                    <img src="{{ url(path_ttd().'/images/upload/ttd/' . @$ttd->tanda_tangan) }}" alt="ttd" width="200" height="100">
                @endif
            @elseif ($sign_pad && !empty($sign_pad->tanda_tangan))
                {{-- <img src="{{ public_path('images/upload/ttd/' . $sign_pad->tanda_tangan) }}" alt="ttd" width="200" height="100"> --}}
                <img src="{{ url(path_ttd().'/images/upload/ttd/' . @$sign_pad->tanda_tangan) }}" alt="ttd" width="200" height="100">
            @endif
          </td>
          <td colspan="3" style="text-align: center; border: 0px;height: 1cm;">
            {{-- {{isset($proses_tte) ? '#' : '&nbsp;'}} --}}
            @php
            $tanggal = '';
              if ($cppt) {
                @$tanggal = date('d-m-Y, H:i', strtotime(@$cppt->created_at));
              } elseif ($soap){
                @$tanggal = date('d-m-Y, H:i', strtotime(@$soap->created_at));
              }
                @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' , ' . @$dokter->sip . ' , ' . @$tanggal))
            @endphp
            <br><br>
            <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
          </td>
        </tr>
        <tr style="border: 0px;">
          <td colspan="3" style="text-align: center; border: 0px;">
            @if (ttdPasienBpjs($reg->created_at))
              {{ @$reg->pasien->nama }}
            @elseif ($sign_pad)
              {{ @$reg->pasien->nama }}
            @endif
          </td>
          <td colspan="3" style="text-align: center; border: 0px;">
            {{ @$dokter->nama }}
          </td>
        </tr>
      </table>
    </div>
    @endif
    {{-- END E-Resume --}}

  </body>
</html>
