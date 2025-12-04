 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ @$reg->no_sep }}_{{ @$reg->pasien->nama }}</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style>
      ._border td{
        border-bottom: 1px dashed #000;
        border-top: 1px dashed #000;
      }
      ._border_bottom td{
        border-bottom: 1px dashed #000;
      }
      body{
        font-family: sans-serif;
        font-size: 10pt;
        
      }
      th{
        text-align: left;
      }
      .page_break_after{
        page-break-after: always;
      }
      .tableResume{
        width: 100%;
      }
      .borderResume{ /* table, th, td */
        border: 1px solid black;
        border-collapse: collapse;
      }
      .borderTriage th,.borderTriage tr,.borderTriage td{ /* table, th, td */
        border: 1px solid black;
        border-collapse: collapse;
      }
      .paddingResume{ /* th, td */
        padding: 15px;
      }

      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
    </style>
  </head>
  <body>
    @php
        libxml_use_internal_errors(true);
    @endphp

    {{-- SEP --}}
    @if (@$sep)  
      <div class="page-break-after">
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
                      $diags = baca_icd10($reg->diagnosa_awal) ? @baca_icd10($reg->diagnosa_awal) : @$sep['diagnosa'];
                    @endphp
                    {{ baca_icd10($reg->diagnosa_awal) ? baca_icd10($reg->diagnosa_awal) : @$sep['diagnosa'] }}
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p class="text-left small" style="font-size: 11px;">
                      * Surat Rujukan berlaku 1[satu] kali kunjungan, berlaku sampai dengan <b>{{@date('d/m/Y',strtotime("+3 month",strtotime(@$rujukan[1]['rujukan']['tglKunjungan'])))}}</b><br/>
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
        </table>
      </div>
    @endif
    {{-- END SEP --}}

    
    {{-- Rincian Biaya --}}
    @if ($rincian_biaya == "irj")
        <div style="page-break-before: always;">
        @php
            @$ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
        @endphp
        <table border=0 style="width:95%;font-size:12px;"> 
          <tr>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
            </td>
            <td style="text-align: center">
              <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
              {{--<b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>--}}
              <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
              <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
            </td>
          </tr>
        </table>
        <hr>
        <table style="width:95%;margin:auto;font-size:11px;">
          <tbody>
            <tr>
              <td style="width:">No. RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
              <td style="width:15%">No. SEP</td><td>: {{ @\App\HistoriSep::where('registrasi_id',$reg->id)->first()->no_sep }}</td>
            </tr>
            <tr>
              <td style="width:15%">Nama Peserta</td><td>: {{ @$reg->pasien->nama }}</td>
              <td>Jenis Perawatan</td><td>:  
                @if (substr(@$reg->status_reg, 0, 1) == 'J')
                    {{ "Rawat Jalan" }}
                @elseif(substr(@$reg->status_reg, 0, 1) == 'I')   
                    {{ "Rawat Inap / " }} {{baca_kelompok(@$ranap->kelompokkelas_id)}} -  {{baca_kelas(@$ranap->kelas_id)}}
                @elseif(substr(@$reg->status_reg, 0, 1) == 'G')   
                    {{ "Gawat Darurat" }}    
                @elseif(substr(@$reg->status_reg, 0, 1) == null)   
                    {{ "-" }} 
                @endif
            </td>
            </tr>
            <tr>
              <td style="width:">Umur Tahun</td> 
              <td>: 


                @if (@$reg->pasien->tgllahir != null)
                {{ hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) }}
                @else
                  {{ "-" }}
                @endif



              </td>
              <td>Penjamin</td><td>: {{@baca_carabayar($reg->bayar)}} {{' - '.@baca_jkn(@$reg->id)}}</td>
              
              
            </tr>
            <tr>
              <td style="width:">Poli</td>
              <td>: {{ baca_poli(@$reg->poli_id) }}</td>
              {{-- @if ($ranap) --}}
              <td>Tanggal Registrasi</td><td>: {{ @date('d-m-Y',strtotime(@$reg->created_at)) }}</td>
              {{-- @endif --}}
            </tr>
            <tr>
              @php
                  $emr = App\Emr::where('registrasi_id', $reg->id)
              @endphp
              <td style="width:">Tanggal Lahir</td> <td>: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
              @if ($ranap)
              <td>Tanggal Keluar</td><td>: {{ @date('d-m-Y',strtotime(@$ranap->tgl_keluar))}}</td>
              @elseif ($cppt)
              <td>Tanggal Keluar</td><td>: {{ @date('d-m-Y',strtotime(@$cppt->created_at))}}</td>
              @elseif ($soap)
              <td>Tanggal Keluar</td><td>: {{ @date('d-m-Y',strtotime(@$soap->created_at))}}</td>
              @endif
              
              
            </tr>
            <tr>
              <td style="width:">Jenis Kelamin</td> 
              <td>: 

                @if (@$reg->pasien->kelamin == "L")
                      {{ "Laki-laki" }}
                @else
                      {{ "Perempuan" }}      
                @endif

              </td>
              @if (@$ranap)
                <td>LOS</td>
                <td>:
                  @if (@$ranap->tgl_keluar != null)
                          
                    <?php
                      $tgl1 = new DateTime(@$ranap->tgl_masuk);
                      $tgl2 = new DateTime(@$ranap->tgl_keluar);
                      $d = $tgl2->diff($tgl1)->days + 1;
                      echo $d." hari";
                    ?>
                  @else
                    {{ "-" }};  
                  @endif
                </td>
              @endif
            </tr>
            <tr>
              <td>Alamat</td> <td>: {{ @$reg->pasien->alamat }}</td>
              @if (@$ranap)
                <td>Cara Pulang</td><td>: {{ $reg->kondisi_akhir_pasien ? @baca_carapulang($reg->kondisi_akhir_pasien) :'' }}</td>
              @endif
            </tr>
          </tbody>
        </table>
        <br/>
        {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
        <table style="width:95%;font-size:11px;" cellspacing="1">
        

        {{-- TINDAKAN KAMAR --}}
        @php
            $tindakan_rajal = 0;
            $tindakan_operasi = 0;
        @endphp
      

        {{-- FOLIO RAJAL --}}
        @if (count($folio_rajal) > 0 || $obat_gudang_rajal >0 || $rad_irj >0 || $lab_irj >0)
        <tr>
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA RAJAL</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
        @endif
        
        @if (count($folio_rajal) > 0)
          @foreach ($folio_rajal as $key => $item)
            @php
              @$tindakan_rajal += $item->total;
              @$jml = @floor(@$item->total / @$item->tarif->total);
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}
                @if (@$item->tarif->is_show_dokter == 'Y')
                  - {!!'<b>'.@baca_dokter($item->dokter_pelaksana).'</b>'!!}
                @endif
              </span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td class="text-center"><center>{{@$jml}}</center></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
          @endif
          @if ($rad_irj >0) {{-- RAD RAJAL --}}
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($rad_irj)}}</span></td>
          </tr>    
          @endif
          {{-- JIKA ADA LAB RAJAL --}}
          @if ($lab_irj >0)
          <tr>
            @if ($lab_irj_anatomi> 0) 
              <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium PATOLOGI ANATOMI</span></td>
            @else  
              <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium Rajal</span></td>
            @endif
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab_irj)}}</span></td>
          </tr>
              
          @endif
          
          @if ($lab_irj >0 || $tindakan_rajal > 0 || $rad_irj > 0)
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total RAJAL</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$tindakan_rajal+@$lab_irj+@$rad_irj)}}</b></span></td>
          </tr>
          @endif
          <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        {{-- END FOLIO RAJAL --}}
        {{-- JIKA ADA BANK DARAH --}}
        @if (count($tindakan_bank_darah) > 0)
          <tr>
            <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">BANK DARAH</th>
            <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
            <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
          @php
            @$total_tindakan_bank_darah = 0
          @endphp
          @foreach ($tindakan_bank_darah as $key => $item)
            @php
              @$total_tindakan_bank_darah += $item->total;
              @$jml = @floor(@$item->total / @$item->tarif->total);
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td style="text-align: center;">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
          @if ($total_tindakan_bank_darah >0)
            <tr>
              <td colspan="3"><span style="text-align:start;font-weight:900">Total Bank Darah</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_tindakan_bank_darah)}}</b></span></td>
            </tr>
          @endif
        @endif

        
        

        {{-- BIAYA TINDAKAN OPERASI --}}
        @php
            $total_operasi = 0
        @endphp
        @if (count($operasi) > 0)
        <tr>
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA OPERASI</th>
          <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black"></th>
          <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black"></th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
            
          @foreach ($operasi as $item)
          @php
              // @$jml_operasi = @floor(@$item->total / @$item->tarif->total);
              @$total_operasi += $item->total;
          @endphp
              <tr>
                <td colspan="3">
                  <span style="text-align:start;">{{@$item->tarif->kategoritarif->namatarif}} - {{$item->namatarif}}</span><br>
                  @if ($item->tarif->bedah == 'Y')
                    <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                  @elseif($item->tarif->anestesi == 'Y') 
                    <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                  @else
                    <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span> --}}
                  @endif
                </td>
                <td style="vertical-align:top;"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
              </tr>
          @endforeach
          
        @endif
        
        @if ($total_operasi >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total Operasi</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_operasi)}}</b></span></td>
        </tr>
        @endif

        {{-- CT. SCAN --}}
        @if (count($ct_scan) > 0)
          <tr>
            <th colspan="3" style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN CT. SCAN</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
            @foreach ($ct_scan as $key => $item)
                <tr>
                  <td colspan="3"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
                  <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($item->total)}}</span></td>
                </tr>
            @endforeach
            <tr>
              <td colspan="3"><span style="text-align:start;font-weight:900">Total CT. Scan</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_ct_scan)}}</b></span></td>
            </tr>    
            <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
          @endif
        {{--END CT. SCAN--}}

        {{-- BIAYA OBAT --}}
        @php
            $total_obat_rajal = 0;
        @endphp
        @if (count($detail_obat_gudang_rajal_null) > 0 || count($detail_obat_gudang_rajal) > 0)
        <tr>
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT RAJAL</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
          @foreach ($detail_obat_gudang_rajal_null as $key => $item)
            @if (count($item->obat) > 0)
              <tr>
                <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
              {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
              </tr>
              @foreach ($item->obat as $items)
              <tr>
                <td>{{$items->masterobat->nama}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
              </tr>
              @php
                  $total_obat_rajal += $items->jumlahHarga;
              @endphp
              @endforeach
            @endif
          @endforeach
          @foreach ($detail_obat_gudang_rajal as $key => $item)
            @if (count($item->obat) > 0)
              <tr>
                <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
              {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
              </tr>
              @foreach ($item->obat as $items)
              <tr>
                <td>{{$items->masterobat->nama}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
              </tr>
              @php
                  $total_obat_rajal += $items->jumlahHarga;
              @endphp
              @endforeach
            @endif
          @endforeach
        @endif
        @if ($total_obat_rajal > 0)
          {{-- OBAT RAJAL --}}
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat RAJAL</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_rajal)}}</b></span></td>
          </tr>    
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        {{--END OBAT RAJAL--}}

        {{-- OBAT OPERASI --}}
        @php
            $total_obat_operasi = 0;
        @endphp
        @if (count($detail_obat_gudang_operasi) > 0) {{-- OPERASI --}}
        <tr>
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT OPERASI</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
          @foreach ($detail_obat_gudang_operasi as $key => $item)
            @if (count($item->obat) > 0)
              <tr>
                <td colspan="4"><span style="text-align:start;font-weight:900">
                  @php
                  if (in_array($item->user_id, [613, 614, 671, 800, 801, 711])) {
                    echo str_replace("FRI", "FRO", $item->namatarif);
                  }
                  @endphp
                </span></td>
              </tr>
              @foreach ($item->obat as $items)
              <tr>
                <td>{{$items->masterobat->nama}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
              </tr>
              @php
                  $total_obat_operasi += $items->jumlahHarga;
              @endphp
              @endforeach
            @endif
          @endforeach
        @endif
        @if ($total_obat_operasi >0) {{-- OBAT RAJAL --}}
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat Operasi</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_operasi)}}</b></span></td>
          </tr>    
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        <tr>
          <th class="dotTop text-right"colspan="3"><div style="float:right !important;text-align:right !important;">TOTAL BIAYA</div></th>
          <td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_obat_operasi+@$total_obat_rajal+@$tindakan_rajal+@$lab_irj+@$rad_irj+@$total_operasi+@$total_tindakan_bank_darah+@$total_ct_scan)}}</b></span></td>
        </tr>

        </table>
         <br/>
         <table style="width:95%; margin-left:70px;">
          <tr>
            @php
            $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
            $tanggal = '';
              if ($ranap) {
                  $tanggal = date('d-m-Y H:i', strtotime(@$ranap->tgl_keluar));
              } elseif ($cppt) {
                  $tanggal = date('d-m-Y H:i', strtotime(@$cppt->created_at));
              } elseif ($soap) {
                  $tanggal = date('d-m-Y H:i', strtotime(@$soap->created_at));
              }
            @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($norah->nama . ' , ' . $norah->sip . ' , ' . $tanggal));
            @endphp
            <td style="width: 50%;" class="text-center">
             &nbsp;
            </td>
            <td style="width: 50%; text-align: center;" class="text-center">
              Manager Administrasi
              <br><br><br>
              {{-- <img src="{{ public_path('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt=""> --}}
              <img src="data:image/png;base64, {!! $base64 !!} "> <br>
              {{$norah->nama}}
            </td>
          </tr>
        </table> 
  @elseif ($rincian_biaya == "non-irj")
      <div style="page-break-before: always;">
      @php
          @$ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
      @endphp
      <table border=0 style="width:95%;font-size:12px;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            {{--<b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>--}}
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
      <hr>
      {{-- @if (substr(@$reg->status_reg, 0, 1) == 'I') --}}
      <table style="width:95%;margin:auto;font-size:11px;">
        <tbody>
          <tr>
            <td style="width:">No. RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
            <td style="width:15%">No. SEP</td><td>: {{ @\App\HistoriSep::where('registrasi_id',$reg->id)->first()->no_sep }}</td>
          </tr>
          <tr>
            <td style="width:15%">Nama Peserta</td><td>: {{ @$reg->pasien->nama }}</td>
            <td>Jenis Perawatan</td><td>:  
              @if (substr(@$reg->status_reg, 0, 1) == 'J')
                  {{ "Rawat Jalan" }}
              @elseif(substr(@$reg->status_reg, 0, 1) == 'I')   
                  {{ "Rawat Inap / " }} {{baca_kelompok(@$ranap->kelompokkelas_id)}} -  {{baca_kelas(@$ranap->kelas_id)}}
              @elseif(substr(@$reg->status_reg, 0, 1) == 'G')   
                  {{ "Gawat Darurat" }}    
              @elseif(substr(@$reg->status_reg, 0, 1) == null)   
                  {{ "-" }} 
              @endif
          </td>
          </tr>
          <tr>
            <td style="width:">Umur Tahun</td> 
            <td>: 


              @if (@$reg->pasien->tgllahir != null)
              {{ hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) }}
              @else
                {{ "-" }}
              @endif



            </td>
            <td>Penjamin</td><td>: {{@baca_carabayar($reg->bayar)}} {{' - '.@baca_jkn(@$reg->id)}}</td>
            
            
          </tr>
          <tr>
            <td style="width:">No. Telp</td>
            <td>:  {{$reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp}}</td>
            {{-- @if ($ranap) --}}
            @if (substr(@$reg->status_reg, 0, 1) == 'G')
              @php
                  $igd = App\HistorikunjunganIGD::where('registrasi_id', $reg->id)->first();
              @endphp
              <td>Tanggal Masuk</td><td>: {{ @date('d-m-Y',strtotime(@$igd->created_at)) }}</td>
            @else
              <td>Tanggal Masuk</td><td>: {{ @$ranap ? @date('d-m-Y',strtotime(@$ranap->tgl_masuk)) :@date('d-m-Y',strtotime(@$reg->created_at)) }}</td>
            @endif
            {{-- @endif --}}
          </tr>
          <tr>
            @php
                $emr = App\Emr::where('registrasi_id', $reg->id)
            @endphp
            <td style="width:">Tanggal Lahir</td> <td>: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
            @if (isset($ranap->tgl_keluar))
            <td>Tanggal Keluar</td><td>: {{ @date('d-m-Y',strtotime(@$ranap->tgl_keluar))}}</td>
            @else
            <td>Tanggal Keluar</td><td>: </td>
            @endif
            
            
          </tr>
          <tr>

            

            <td style="width:">Jenis Kelamin</td> 
                <td>: 

                  @if (@$reg->pasien->kelamin == "L")
                        {{ "Laki-laki" }}
                  @else
                        {{ "Perempuan" }}      
                  @endif

                </td>
                @if (@$ranap)
                <td>LOS</td>
                <td>:
                  @if (@$ranap->tgl_keluar != null)
                          
                    <?php
                      @$tglMasuk  = $ranap->tgl_masuk  ? \Carbon\Carbon::parse($ranap->tgl_masuk)->format('d-m-Y') : '-';
                      @$tglKeluar = $ranap->tgl_keluar ? \Carbon\Carbon::parse($ranap->tgl_keluar)->format('d-m-Y') : '-';
                      $tgl1 = new DateTime($tglMasuk);
                      $tgl2 = new DateTime($tglKeluar);
                      $d = $tgl2->diff($tgl1)->days + 1;
                      echo $d." hari";
                    ?>
                  @else
                    {{ "-" }};  
                  @endif
                </td>
                @endif
          </tr>
          <tr>
            <td>Alamat</td> <td>: {{ @$reg->pasien->alamat }}</td>
            @if (@$ranap)
              <td>Cara Pulang</td><td>: {{ $reg->kondisi_akhir_pasien ? @baca_carapulang($reg->kondisi_akhir_pasien) :'' }}</td>
            @endif
          </tr>
        </tbody>
      </table>
      <br/>
      {{-- <hr/> --}}
      {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
      <table style="width:95%;font-size:11px;" cellspacing="1">
      
  

      {{-- TINDAKAN KAMAR --}}
      {{-- <tr><th class="dotTop" colspan="4">TINDAKAN</th></tr> --}}
      @php
          $tindakan_igd = 0;
          $tindakan_rajal = 0;
          $tindakan_inap = 0;
          $tindakan_operasi = 0;
      @endphp
    

      {{-- FOLIO IGD --}}
      {{-- <tr> 
        <td><span style="text-align:start;font-weight:900">IGD</span></td>
      </tr> --}}
      @if (count($folio_igd) > 0 || $obat_gudang_igd >0 || $rad_igd >0 || $lab_igd >0)
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA IGD</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
        <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>
      @endif
      
      @if (count($folio_igd) > 0)
        @foreach ($folio_igd as $key => $item)
          @php
            @$tindakan_igd += $item->total;
            @$jml = @floor(@$item->total / @$item->tarif->total);
          @endphp
          <tr>
            <td><span style="text-align:start;">{{$item->namatarif}}
              @if (@$item->tarif->is_show_dokter == 'Y')
                - {!!'<b>'.@baca_dokter($item->dokter_pelaksana).'</b>'!!}
              @endif
              @if (@$item->cyto != null)
              - {!!'<b>Cito</b>'!!}
              @endif
            </span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
            <td style="text-align: center;">{{@$jml}}</td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
          </tr>
          
        @endforeach
        @endif
        @if ($rad_igd >0) {{-- RAD IGD --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi
          @if (count(@$dokter_rad_igd) > 0)
            @foreach (@$dokter_rad_igd as $item)
              - {!!'<b>'.baca_dokter(@$item->dokter_radiologi).'</b>'!!}
            @endforeach
          @endif
          </span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($rad_igd)}}</span></td>
        </tr>    
        @endif
        {{-- JIKA ADA LAB IGD --}}
        @if ($lab_igd >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium IGD</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab_igd)}}</span></td>
        </tr>
            
        @endif
        @if ($lab_igd >0 || $tindakan_igd > 0 || $rad_igd > 0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total IGD</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$tindakan_igd+@$lab_igd+@$rad_igd)}}</b></span></td>
        </tr>
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
      {{-- END FOLIO IGD --}}

      

      {{-- FOLIO INAP --}}
      {{-- <tr>
        <td class="" colspan="4"><span style="text-align:start;font-weight:900">Rawat Inap</span></td>
      </tr> --}}
      @if (count($folio_irna) > 0 || $total_ranap >0 || $lab_inap >0 || $rad_inap > 0)
        <tr>
          {{-- <th style="text-align:start; border-bottom:1px solid;border-top:1 px solid black !important:">RINCIAN BIAYA RAWAT INAP<br/></th> --}}
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA RAWAT INAP</th>
          <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
          <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
        
        @foreach ($folio_irna as $kamar => $tindakan)
        
          <tr>
            <td><span style="text-align:start;font-weight:900">{!!$kamar ? baca_kamar($kamar) : '-'!!}</span></td>
          </tr>
          @php
              @$total_perkamar = 0;
          @endphp
          @foreach ($tindakan as $item)
          @php
            @$total_perkamar += $item->total;
            @$jml = @floor(@$item->total / @$item->tarif->total);
            // @$tindakan_irj_ina += $item->total;
          @endphp
          <tr>
            <td>
              <span style="text-align:start;">{{$item->namatarif}}
                @if (@$item->tarif->is_show_dokter == 'Y')
                - {!!'<b>'.@baca_dokter($item->dokter_pelaksana).'</b>'!!}
                @endif
                @if (@$item->cyto != null)
                - {!!'<b>Cito</b>'!!}
                @endif
              </span>
            </td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
            <td style="text-align: center;">{{@$jml}}</td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
          </tr>
          @endforeach
          {{-- <tr>
            <td colspan="3"><span style="margin-left:80px;font-weight:900">SUB TOTAL</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_perkamar)}}</b></span></td>
          </tr>     --}}

        @endforeach
        @endif
        @if ($rad_inap >0) {{-- RAD INAP --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi RANAP
            @if (count(@$dokter_rad_inap) > 0)
              @foreach (@$dokter_rad_inap as $item)
                - {!!'<b>'.baca_dokter(@$item->dokter_radiologi).'</b>'!!}
              @endforeach
            @endif
          </span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($rad_inap)}}</span></td>
        </tr>    
        @endif
        {{-- JIKA ADA LAB INAP --}}
        @if ($lab_inap >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab_inap)}}</span></td>
        </tr>
        @endif
        
        @if ($total_ranap >0 || $lab_inap >0 || $rad_inap > 0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_ranap+@$lab_inap+@$rad_inap)}}</b></span></td>
        </tr>
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        
        {{-- JIKA ADA BANK DARAH --}}
        @if (count($tindakan_bank_darah) > 0)
          <tr>
            <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">BANK DARAH</th>
            <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
            <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
          @php
            @$total_tindakan_bank_darah = 0
          @endphp
          @foreach ($tindakan_bank_darah as $key => $item)
            @php
              @$total_tindakan_bank_darah += $item->total;
              @$jml = @floor(@$item->total / @$item->tarif->total);
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td style="text-align: center;">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
          @if ($total_tindakan_bank_darah >0)
            <tr>
              <td colspan="3"><span style="text-align:start;font-weight:900">Total Bank Darah</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_tindakan_bank_darah)}}</b></span></td>
            </tr>
          @endif
        @endif

        {{-- JIKA ADA LAB INAP PATOLOGI --}}
        @if (count($tindakan_lab_inap_patologi) > 0)
          <tr>
            <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">Lab Patologi Anatomi RANAP</th>
            <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
            <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
          @php
            @$total_tindakan_lab_pa = 0
          @endphp
          @foreach ($tindakan_lab_inap_patologi as $key => $item)
            @php
              @$total_tindakan_lab_pa += $item->total;
              @$jml = @floor(@$item->total / @$item->tarif->total);
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td style="text-align: center;">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
          @if (@$total_tindakan_lab_pa > 0)
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Lab Patologi Anatomi</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format(@$total_tindakan_lab_pa)}}</span></td>
          </tr>
          @endif
        @endif
        {{-- @if (@$bank_darah_inap >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Bank Darah RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format(@$bank_darah_inap)}}</span></td>
        </tr>
        @endif --}}
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        {{-- END FOLIO INAP --}}
      

      {{-- BIAYA TINDAKAN OPERASI --}}
      @php
          $total_operasi = 0
      @endphp
      @if (count($operasi) > 0)
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA OPERASI</th>
        <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black"></th>
        <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black"></th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>
          
        @foreach ($operasi as $item)
            @php
                @$total_operasi += $item->total;


                $tarif = Modules\Tarif\Entities\Tarif::find($item->tarif_id);
                $tahunTarif = Modules\Kategoritarif\Entities\Kategoritarif::find($tarif->kategoritarif_id);

            @endphp
            <tr>
              <td colspan="3">
                <span style="text-align:start;">
                @php
                  if ($item->user_id == 614 || $item->user_id == 613 || $item->user_id == 671 || $item->user_id == 800 || $item->user_id == 801 || $item->user_id == 711) {
                  echo str_replace("FRI", "FRO", $item->namatarif);
                  }
                @endphp
                </span><br>
                @if ($item->tarif->bedah == 'Y')
                  <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }})&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                    @if ($item->tarif->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                      <span style="">Perawat Bedah</span>
                    @elseif (@$item->tarif->kategoritarif->namatarif == 'Jasa Rumah Sakit Tindakan Operatif' || @$item->namatarif  == 'Tindakan Keperawatan Kat. V')

                    @else
                      <span style="">Dokter Bedah&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span>
                    @endif
                    @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} @endif
                @elseif($item->tarif->anestesi == 'Y') 
                  <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }})&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                    @if ($item->tarif->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                      <span style="">Perawat Anestesi</span>
                    @else  
                      <span style="">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                    @endif
                    @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} | 
                    @endif   
                    @if (@$item->perawat_ibs1 == 1) - {!!'<b>Perawat Bedah</b>'!!} 
                    {{-- @elseif(@$item->perawat_ibs1 == 2)  {!!'<b>Perawat Anestesi</b>'!!}   --}}
                    @endif</span>
                @else
                <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }}) &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                  @if (@$item->tarif->nama == 'Ruang Pemulihan' || @$item->tarif->kategoritarif->namatarif == 'Jasa Rumah Sakit Tindakan Operatif' || @$item->tarif->nama == 'Tindakan Keperawatan Kat. V')
                    
                  @else  
                    <span style="">Dokter Bedah&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span>
                  @endif
                  @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} @endif
                @endif
              
                
              </td>
              <td style="vertical-align:top;"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
        
      @endif
      
      @if ($total_operasi >0)
      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Total Operasi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_operasi)}}</b></span></td>
      </tr>
      @endif

              {{-- OBAT OPERASI --}}
              @php
                  $total_obat_operasi = 0;
              @endphp
              @if (count($detail_obat_gudang_operasi) > 0) {{-- OPERASI --}}
              <tr>
                <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT OPERASI</th>
                <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
                <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
                <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
              </tr>
                @foreach ($detail_obat_gudang_operasi as $key => $item)
                  @if (count($item->obat) > 0)
                    <tr>
                      <td colspan="4"><span style="text-align:start;font-weight:900">
                          @php
                          $resep = substr($item->namatarif, 0, 3);
                          @endphp
                          @if ($item->user_id == 614 || $item->user_id == 613 || $item->user_id == 671 || $item->user_id == 800 || $item->user_id == 801 || $item->user_id == 711)
                            @if ($resep == 'FRD')
                              {{ str_replace('FRD', 'FRO', $item->namatarif) }}
                            @elseif($resep == 'FRI') 
                              {{ str_replace('FRI', 'FRO', $item->namatarif) }}
                            @endif  
                          @else
                              {{  $item->namatarif }}
                          @endif
                      </span></td>
                    </tr>
                    @foreach ($item->obat as $items)
                    <tr>
                      <td>{{$items->masterobat->nama}}</td>
                      <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                      <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                      <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
                      {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
                    </tr>
                    @php
                        $total_obat_operasi += $items->jumlahHarga;
                    @endphp
                    @endforeach
                  @endif
                @endforeach
              @endif
              @if ($total_obat_operasi >0) {{-- OBAT IGD --}}
                <tr>
                  <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat Operasi</span></td>
                  <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_operasi)}}</b></span></td>
                </tr>    
              @endif
              <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
      {{-- BIAYA LABOR --}}
      
        {{-- BIAYA OBAT --}}
        @php
            $total_obat_igd = 0;
        @endphp
        @if (count($detail_obat_gudang_igd) > 0) {{-- IGD --}}
        <tr>
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT IGD</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
          @foreach ($detail_obat_gudang_igd as $key => $item)
            @if (count($item->obat) > 0)
              <tr>
                <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
              {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
              </tr>
              @foreach ($item->obat as $items)
              <tr>
                <td>{{$items->masterobat->nama}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
              </tr>
              @php
                  $total_obat_igd += $items->jumlahHarga;
              @endphp
              @endforeach
            @endif
          @endforeach
        @endif
        @if ($total_obat_igd >0) {{-- OBAT IGD --}}
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat IGD</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_igd)}}</b></span></td>
          </tr>    
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        {{--END OBAT IGD--}}


  
  
        {{-- OBAT IGD --}}
        @php
            $total_obat_inap = 0;
        @endphp
        @if (count($detail_obat_gudang_inap_null) > 0 || count($detail_obat_gudang_inap) > 0) {{-- IGD --}}
        <tr>
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT RANAP</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
          @foreach ($detail_obat_gudang_inap_null as $key => $item)
          @if (count($item->obat) > 0)
            <tr>
              <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
            {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
            </tr>
            @foreach ($item->obat as $items)
            <tr>
              <td>{{$items->masterobat->nama}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
              <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
              {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
            </tr>
            @php
                $total_obat_inap += $items->jumlahHarga;
            @endphp
            @endforeach
          @endif
          @endforeach
          @foreach ($detail_obat_gudang_inap as $key => $item)
            @if (count($item->obat) > 0)
              <tr>
                <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
              </tr>
              @foreach ($item->obat as $items)
              <tr>
                <td>{{$items->masterobat->nama}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                <td style="text-align: center;">{{@$items->jumlah}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td> --}}
              </tr>
              @php
                  $total_obat_inap += $items->jumlahHarga;
              @endphp
              @endforeach
            @endif
          @endforeach
        @endif
        @if ($total_obat_inap >0) 
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat RANAP</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_inap)}}</b></span></td>
          </tr>    
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        <tr>
        <th class="dotTop text-right"colspan="3"><div style="float:right !important;text-align:right !important;">TOTAL BIAYA</div></th>
        <td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$lab_igd+@$rad_igd+@$tindakan_igd+@$rad_inap+@$lab_inap+@$total_ranap+@$total_tindakan_bank_darah+@$total_tindakan_lab_pa+@$total_operasi+@$total_obat_operasi+@$total_obat_igd+@$total_obat_inap)}}</b></span></td>
      </tr>
      </table>
      <br/>
          <table style="width:100%;">
            <tr>
              @php
              $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
              $tanggal = '';
              if ($ranap) {
                  $tanggal = date('d-m-Y H:i', strtotime(@$ranap->tgl_keluar));
              } elseif ($cppt) {
                  $tanggal = date('d-m-Y H:i', strtotime(@$cppt->created_at));
              } elseif ($soap) {
                  $tanggal = date('d-m-Y H:i', strtotime(@$soap->created_at));
              }
              @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($norah->nama . ' , ' . $norah->sip . ' , ' . $tanggal))
              @endphp
              <td style="width: 50%; text-align:center;" class="text-center">
                {{-- Petugas Administrasi
               
                <br><br><br><br><br>
                {{ Auth::user()->name }}<br> --}}
              </td>
              <td style="width: 50%; text-align:center;" class="text-center">
                Manager Administrasi
                <br><br><br>
                {{-- <img src="{{ public_path('/images/'. @$norah->tanda_tangan) }}" style="width: 60px;" alt=""> --}}
                <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                {{@$norah->nama}}
              </td>
            </tr>
      </table> 
  @endif
    {{-- END Rincian Biaya --}}

        {{-- RESEP --}}
      @if (count(@$detail) > 0)
        <div style="page-break-before: always;">
  
        </div>
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
            <td>No. Rekam Medik</td>
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
            <td>:&nbsp;{{ !empty($reg->pasien->tgllahir) ? hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }} / {{ $reg->pasien->kelamin }}</td>
          </tr>
          <tr>
            <td>Cara Bayar</td>
            <td>:&nbsp;&nbsp;{{ baca_carabayar($reg->bayar) }}</td>
            <td>Tanggal</td>
            <td>:&nbsp;&nbsp;{{ date('d-m-Y' ,strtotime(@$resep_note->created_at ?? @$detail[0]->created_at)) }}
            </td>
          </tr>
          <tr>
            <td style="vertical-align: top;">Nama Dokter</td>
            <td style="vertical-align: top;">:&nbsp;&nbsp;<br>
              @php
                $resepNote    = App\ResepNote::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
                $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' | ' . @$dokter->nip . ' | ' . @$resepNote->antrian_dipanggil))
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
                <tr class="_border_bottom">
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
                    <b>R/</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b style="color:red;font-size:12px;"><u><i>{{strtoupper(@$nama_racikan)}}</i></u></b><b style="color:red">RACIKAN</b><br/><br/>
                  </td>
                </tr>
              </table>
            </td>
            <td style="width:50%;vertical-align:top">
              <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size:11px;">
                @php
                    $telaah = json_decode($penjualan->catatan ?? '{}', true);
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
                  <td class="text-center" style="text-align: center;">
                    {{-- @if(!tandatangan($reg->dokter_id)) --}}
                    <p>Penerima Obat<br/>
                      @if ($reg->pasien->tanda_tangan)
                      {{-- <img src="{{ public_path('images/upload/ttd/' . @$reg->pasien->tanda_tangan) }}" alt="ttd" width="200" height="100"><br> --}}
                        <img src="http://172.168.1.175/images/upload/ttd/{{@$reg->pasien->tanda_tangan }}" alt="ttd" width="200" height="100"><br>
                      @else
                      <br><br>
                      {{ $reg->pasien->nama }}
                      @endif
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
                    <p>Nama &amp; Tanda Tangan <br/> Apotik
                      <br/><br/><br/>
                      @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate('Apt. Adiyah, S.Farm., MM.RS' . ' , ' . '' . ' , ' . date('d-m-Y H:i' ,strtotime(@$resep_note->created_at ?? @$detail[0]->created_at))))
                      @endphp
                      <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                      (<i>Apt. Adiyah, S.Farm., MM.RS</i>)
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
                        {{-- <img src="{{ public_path('images/' . $pegawai[559]['tanda_tangan']) }}" alt="ttd" width="50"> --}}
                        <img src="http://172.168.1.175/images/{{$pegawai[559]['tanda_tangan'] }}" alt="ttd" width="50">
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Telaah R/</td>
                  <td style="text-align: left;">{{$pegawai[123]['nama']}}</td>
                  <td>
                    @if(!empty($pegawai[123]['tanda_tangan']))
                        {{-- <img src="{{ public_path('images/' . $pegawai[123]['tanda_tangan']) }}" alt="ttd" width="50"> --}}
                        <img src="http://172.168.1.175/images/{{$pegawai[123]['tanda_tangan']}}" alt="ttd" width="50">
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Pemberian Etiker</td>
                  <td style="text-align: left;">{{$pegawai[216]['nama']}}</td>
                  <td>
                    @if(!empty($pegawai[216]['tanda_tangan']))
                        {{-- <img src="{{ public_path('images/' . $pegawai[216]['tanda_tangan']) }}" alt="ttd" width="50"> --}}
                        <img src="http://172.168.1.175/images/{{$pegawai[216]['tanda_tangan'] }}" alt="ttd" width="50">
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Penyiapan Obat</td>
                  <td style="text-align: left;">{{$pegawai[472]['nama']}}</td>
                  <td>
                    @if(!empty($pegawai[472]['tanda_tangan']))
                        {{-- <img src="{{ public_path('images/' . $pegawai[472]['tanda_tangan']) }}" alt="ttd" width="50"> --}}
                        <img src="http://172.168.1.175/images/{{$pegawai[472]['tanda_tangan'] }}" alt="ttd" width="50">
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Penyerahan Obat</td>
                  <td style="text-align: left;">{{$pegawai[413]['nama']}}</td>
                  <td>
                    @if(!empty($pegawai[413]['tanda_tangan']))
                        <img src="http://172.168.1.175/images/{{$pegawai[413]['tanda_tangan'] }}" alt="ttd" width="50">
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
      @endif
      {{-- END RESEP --}}

    {{-- TRIAGE --}}
    @if ($reg->poli->politype == 'G' || substr(@$reg->status_reg, 0, 1) == 'I')
      @if ($asessment)
        <div style="page-break-before: always;">
          <table class="" style="width:100%;" border="1" cellspacing="0">
            <tr>
                <th colspan="1">
                    <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
                </th>
                <th colspan="4" style="font-size: 18pt; border: 0px solid rgb(255, 255, 255);">
                    <b>TRIAGE</b>
                </th>
                <th colspan="1" style="border: 0px solid rgb(255, 255, 255);">
                    @php
                        $triage = json_decode(json_encode($asessment), true);

                        switch (@$triage['triage']['kesimpulan']) {
                            case 'Emergency ATS I':
                                $style = "rgb(255, 106, 106)";
                                break;
                            case 'Urgent ATS II & III':;
                                $style = "rgb(255, 238, 110)";
                                break;
                            case 'Non Urgent ATS IV & V':
                                $style = "rgb(166, 255, 110)";
                                break;
                            case 'Meninggal':
                                $style = "rgb(169, 169, 169)";
                                break;
                            
                            default:
                                $style = "transparent";
                                break;
                        }
                    @endphp
                    <div style="width: 100%; height: 60px; background-color: {{$style}};">
                    </div>
                </th>
            </tr>
            <tr>
                <td colspan="6">
                    Tanggal Pemeriksaan : {{ date('d-m-Y', strtotime(@$reg->created_at)) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Nama Pasien</b><br>
                    {{ $reg->pasien->nama }}
                </td>
                <td colspan="2">
                    <b>Tgl. Lahir</b><br>
                    {{ !empty($reg->pasien->tgllahir) ? hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : null }}
                </td>
                <td>
                    <b>Jenis Kelamin</b><br>
                    {{ $reg->pasien->kelamin }}
                </td>
                <td>
                    <b>No MR.</b><br>
                    {{ $reg->pasien->no_rm }}
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <b>Alamat Lengkap</b><br>
                    {{ $reg->pasien->alamat .', '. @$reg->pasien->kelurahan->name .', '. @$reg->pasien->kecamatan->name .', '. @$reg->pasien->kabupaten->name .', '. @$reg->pasien->provinsi->name }}
                </td>
                <td>
                    <b>No Telp</b><br>
                    {{ $reg->pasien->nohp }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>TRIAGE</b>
                </td>
                <td colspan="5">
                    <ul>
                        <li><strong>Kontak awal dengan pasien :</strong>
                            {{ @$asessment->kontakAwal ? date('d-m-Y H:i', strtotime(@$asessment->kontakAwal)) : '' }}</li>
                        <li><strong>Cara Masuk :</strong> {{ @$asessment->caraMasuk }}</li>
                        <li><strong>Sudah Terpasang :</strong> {{ @$asessment->sudahTerpasang }}</li>
                        <li><strong>Alasan Kedatangan :</strong> {{ @$asessment->sebabDatang->sebab }}
                            ({{ @$asessment->sebabDatang->ket }})</li>
                        <li><strong>Kendaraan :</strong> {{ @$asessment->kendaraan }}</li>
                        <li><strong>Identitas Pengantar :</strong> Nama: {{ @$asessment->namaPengantar }} (Tepl.
                            {{ @$asessment->telpPengantar }}) </li>
                        <li><strong>Kasus :</strong> {{ @$asessment->kasus }}</li>
                        @if (@$asessment->kasus == 'Trauma')
                            <li><strong>Mekanisme Trauma :</strong>
                                <ul>
                                    @if (@$asessment->trauma->kllTunggal->ada == 'true')
                                        <li>
                                            <strong>KLL Tunggal </strong> {{ @$asessment->trauma->kllTunggal->subject }} di
                                            {{ @$asessment->trauma->kllTunggal->lokasi }} pada
                                            {{ @$asessment->trauma->kllTunggal->waktu ? date('d-m-Y H:i', strtotime(@$asessment->trauma->kllTunggal->waktu)) : '' }}
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->kll->ada == 'true')
                                        <li>
                                            <strong>KLL </strong> antara {{ @$asessment->trauma->kll->subject1 }} dengan
                                            {{ @$asessment->trauma->kll->subject2 }} di
                                            {{ @$asessment->trauma->kll->lokasi }}
                                            pada
                                            {{ @$asessment->trauma->kll->waktu ? date('d-m-Y H:i', strtotime(@$asessment->trauma->kll->waktu)) : '' }}
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->jatuh->ada == 'true')
                                        <li>
                                            <strong>Trauma Jatuh dari ketinggian </strong>
                                            ({{ @$asessment->trauma->jatuh->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->lukaBakar->ada == 'true')
                                        <li>
                                            <strong>Trauma Luka Bakar </strong> ({{ @$asessment->trauma->lukaBakar->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->listrik->ada == 'true')
                                        <li>
                                            <strong>Trauma Listrik </strong> ({{ @$asessment->trauma->listrik->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->kimia->ada == 'true')
                                        <li>
                                            <strong>Trauma Zat Kimia </strong> ({{ @$asessment->trauma->kimia->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->dll->ada == 'true')
                                        <li>
                                            <strong>Trauma Lainnya </strong> ({{ @$asessment->trauma->dll->ket }})
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li><strong>Keluhan Utama :</strong> {{ @$asessment->keluhanUtama->ket }}</li>
                        <li><strong>Alergi :</strong> {{ @$asessment->alergi->ket }}</li>
                        <li>
                            <strong>Tanda Vital : </strong> <br/>
                            TD : {{@$asessment_awal['igdAwal']['tandaVital']['tekananDarah'] ?? @$asessment_awal_ponek['tanda_vital']['tekanan_darah']}} mmHg<br/>
                            Frekuensi Nadi : {{@$asessment_awal['igdAwal']['tandaVital']['frekuensiNadi'] ?? @$asessment_awal_ponek['tanda_vital']['nadi']}} x/Menit<br/>
                            Suhu : {{@$asessment_awal['igdAwal']['tandaVital']['suhu'] ?? @$asessment_awal_ponek['tanda_vital']['suhu']}} &deg;C<br/>
                            RR : {{@$asessment_awal['igdAwal']['tandaVital']['RR'] ?? @$asessment_awal_ponek['tanda_vital']['frekuensi_nafas']}} x/Menit<br/>
                            SPO2 : {{@$asessment_awal['igdAwal']['tandaVital']['spo2'] ?? @$asessment_awal_ponek['tanda_vital']['SPO2']}} spo2<br/>
                            {{-- BB : {{@$asessment_awal['igdAwal']['tandaVital']['BB']}} Kg<br/> --}}
                        </li>
                        <li><strong>Skala Nyeri :</strong> {{ @$asessment_awal['igdAwal']['skalaNyeri'] }}</li>
                        @php
                            $asessment = json_decode(json_encode($asessment), true);
                        @endphp
                        <li><strong>Catatan Khusus :</strong> {{ @$asessment['triage']['catatan'] }}</li>
                    </ul>


                </td>
            </tr>
            <tr>
                <td colspan="6">
                    @php
                        $asessment = json_decode(json_encode($asessment), true);
                    @endphp
                    <style>
                        .red {
                            background-color: rgb(255, 106, 106);
                        }

                        .yellow {
                            background-color: rgb(255, 238, 110);
                        }

                        .green {
                            background-color: rgb(166, 255, 110);
                        }
                    </style>
                    <table style="width: 100%;font-size:12px;" border="1" cellspacing="0">
                        <tr>
                            <td colspan="6" style="font-weight: 900; text-align:center; padding-top:10px;">
                                TRIAGE
                            </td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td></td>
                            <td class="red">ATS I SEGERA</td>
                            <td class="yellow">ATS II 10 MENIT</td>
                            <td class="yellow">ATS III 30 MENIT</td>
                            <td class="green">ATS IV 60 MENIT</td>
                            <td class="green">ATS V 120 MENIT</td>
                        </tr>
                        <tr>
                            <td>Jalan Nafas</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['obstruksi'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Obstruksi / Parsial Obstruksi</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['yellow1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['yellow2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Pernafasan</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['nafasBerat'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Distress nafas berat</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['hentiNafas'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Henti Nafas</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['hivoventilasi'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Hivoventilasi</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['nafasSedang'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Distress nafas sedang</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['nafasRingan'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Distress nafas ringan</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['noDistress']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada distress nafas</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['noDistress']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada distress nafas</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Sirkulasi</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hemodinamikBerat'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Gangguan hemodinamik berat</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hentiJantung'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Henti Jantung</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['pendarahTakTerkontrol'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Pendarah tak terkontrol</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hemodinamikSedang'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Gangguan hemodinamik sedang</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hemodinamikRingan'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Gangguan hemodinamik ringan</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['noGangguan']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada gangguan sirkulasi</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input" name="asessment[triage][sirkulasi][noGangguan]"
                                        {{ @$asessment['triage']['sirkulasi']['noGangguan']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada gangguan sirkulasi</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>GCS</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['<9'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">GCS &lt; 9 </label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['9-12'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">GCS 9-12</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['>12'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">GCS >12</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['normalGCS']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Normal GCS</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['normalGCS']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Normal GCS</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kesimpulan
                            </td>
                            <td colspan="5">
                                @if (@$asessment['triage']['kesimpulan'] == 'Emergency ATS I')
                                    <div class="red" style="display: inline-block; padding: 10px">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Emergency ATS I' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Emergency ATS I</label>
                                    </div>
                                @endif
                                @if (@$asessment['triage']['kesimpulan'] == 'Urgent ATS II & III')
                                    <div class="yellow" style="display: inline-block; padding: 10px">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Urgent ATS II & III' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Urgent ATS II dan III</label>
                                    </div>
                                @endif
                                @if (@$asessment['triage']['kesimpulan'] == 'Non Urgent ATS IV & V')
                                    <div class="green" style="display: inline-block; padding: 10px">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Non Urgent ATS IV & V' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Non Urgent ATS IV dan V</label>
                                    </div>
                                @endif
                                @if (@$asessment['triage']['kesimpulan'] == 'Meninggal')
                                    <div style="display: inline-block; padding: 10px; background-color:rgb(169, 169, 169)">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Meninggal' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Meninggal</label>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        {{-- <div class="page_break_after"></div> --}}<br/>
        <table style="border: 0px;width:100%;">
            <tr style="border: 0px;">
                <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                    {{-- @if (isset($proses_tte) || isset($tte_nonaktif))
                        {{Auth::user()->pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat'}}
                    @else
                        @if (@$pegawai->kategori_pegawai == 1)
                            Dokter
                        @else
                            Perawat
                        @endif
                    @endif --}}
                    &nbsp;
                </td>
                <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                  Petugas Triage
                </td>
            </tr>
            <tr style="border: 0px;">
                <td colspan="3" style="text-align: center; border: 0px;">
                  {{-- <br/>
                    @if (isset($proses_tte))
                        #
                    @elseif (isset($tte_nonaktif))
                        @php
                            @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' , ' . Auth::user()->pegawai->nip))
                        @endphp
                        <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                    @endif --}}
                    &nbsp;
                </td>
                <td colspan="3" style="text-align: center; border: 0px;">
                  <br/>
                    @php
                        @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$pemeriksaan->user->pegawai->nama . ' , ' . @$pemeriksaan->user->pegawai->sip . ' , ' . date('d-m-Y', strtotime(@$pemeriksaan->created_at))))
                    @endphp
                    @if ($base64)
                        <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                    @endif
                </td>
            </tr>
            <tr style="border: 0px;">
                <td colspan="3" style="text-align: center; border: 0px;">
                    {{-- @if (isset($proses_tte) || isset($tte_nonaktif))
                        {{Auth::user()->pegawai->nama}}
                    @else
                        {{ @$pegawai->nama }}
                    @endif --}}
                    &nbsp;
                </td>
                <td colspan="3" style="text-align: center; border: 0px;">
                  {{@$pemeriksaan->user->pegawai->nama}}
                </td>
            </tr>
        </table>
        </div>   
        
      @endif

    @endif
        {{-- DD DISIN --}}
    {{-- JIKA INAP --}}
    @if(substr(@$reg->status_reg, 0, 1) == 'I')
    {{-- SPRI --}}
    @if (count($spri) > 0)
    <div style="page-break-before: always;">
    @foreach ($spri as $d)
        <table border=0 style="width:95%;font-size:12px;"> 
          <tr>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
            </td>
            <td style="text-align: center">
              <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
              {{--<b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>--}}
              <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
              <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
            </td>
          </tr>
        </table>
        <hr>

        <div class="row">
          <div class="col-sm-12 text-center">
              <table border=0 style="width: 100%;"> 
                <tr>
                  <td style="text-align: center">
                    <h3 style="font-size:17px;"><u>SURAT PENGANTAR RAWAT INAP</u></h3>
                  </td>
                </tr>
              </table>
              @php
                  $rujukan_spri = App\EmrInapPerencanaan::where('registrasi_id', @$d->registrasi_id)->where('type', 'rujukan')->first();
              @endphp
              <table border=0 style="width: 100%;">
                <tr>
                  <td style="width:200px !important;"><span>No.SPRI</span></td>
                  <td>: {{ @$d->no_spri ?? '-' }}</td>
                </tr>
                <tr>
                  <td style="width:200px !important;"><span>No. CM</span></td>
                  <td>: {{@$reg->pasien->no_rm}}</td>
                </tr>
                <tr>
                  <td><span>Nama Pasien</span></td>
                  <td>: {{@$reg->pasien->nama}}</td>
                </tr>
                <tr>
                  <td style=""><span>Alamat</span></td>
                  <td>: {{@$reg->pasien->alamat}}</td>
                </tr>
                <tr>
                  <td ><span> Tgl. Lahir</span></td>
                  <td>: {{ date("d-m-Y", strtotime(@$reg->pasien->tgllahir)) }}</td>
                  <td></td>
                </tr>
                <tr>
                  <td ><span> Usia</span></td>
                  {{-- <td>: {{@hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td> --}}
                  <td>: {{hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at)}}</td>
                  {{-- <td><span>:</span></td> --}}
                  <td></td>
                </tr>
                
                <tr>
                  <td ><span> Cara Bayar</span></td>
                  <td>: {{ baca_carabayar(@$d->carabayar) }}</td>
                  {{-- <td><span>:</span></td> --}}
                  <td></td>
                </tr>
                <tr>
                  <td style=""><span>Mulai tanggal rawat</span></td>
                  <td>: {{ date("d-m-Y", strtotime(@$d->tgl_rencana_kontrol)) }}</td>
                </tr>
                <tr>
                  <td style=""><span>Kebutuhan ruangan</span></td>
                  <td>:  {{baca_kamar(@$d->jenis_kamar)}}</td>
                </tr>
                <tr>
                  <td style=""><span>Dokter Pengirim</span></td>
                  <td>:  {{baca_dokter(@$d->dokter_pengirim)}}</td>
                </tr>
                <tr>
                  <td style=""><span>Dokter DPJP</span></td>
                  <td>:  {{baca_dokter(@$d->dokter_rawat)}}</td>
                </tr>
                {{-- <tr>
                  <td style=""><span>Dokter rawat</span></td>
                  <td>:  {{baca_dokter(@$d->dokter_rawat)}}</td>
                </tr> --}}
                <tr>
                  <td style=""><span>Diagnosa dan keterangan detail </span></td>
                  <td>:  
                    {{ strip_tags(@$d->diagnosa) }}
                  </td>
                </tr>
                {{-- <tr>
                  <td style=""><span>Dokter yang membuat</span></td>
                  <td>:  {{baca_dokter(@$d->dokter_pengirim)}}</td>
                </tr> --}}
                <tr>
                  <td style=""><span>Rencana Terapi</span></td>
                  <td>:  {{(@$rujukan_spri->rencana_terapi)}}</td>
                </tr>
            </table>
            <br>
            <br>
          <div style="padding: 5px; float:right; text-align: center">
            {{configrs()->kota}}, {{ date("d-m-Y", strtotime(@$reg->created_at)) }}
            <br>
              @php
                  @$tgl_spri = \App\SuratInap::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
                  $pegawai = \Modules\Pegawai\Entities\Pegawai::find(@$d->dokter_pengirim);
                  @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$pegawai->nama . ' , ' . @$pegawai->sip . ' , ' . @$tgl_spri->created_at))
              @endphp
              <br><br>
              <img src="data:image/png;base64, {!! $base64 !!} ">
              <br>
            <u>({{baca_dokter(@$d->dokter_pengirim)}})</u><br>
            <hr>
          </div>
        </div>
        @endforeach
      </div>
    @endif
    
    {{-- APGAR SCORE --}}
    @if ($apgarScore)
    <div style="page-break-before: always;">
      @php
      $apgar = @json_decode(@$apgarScore->fisik, true);
      @endphp
      <div class="col-md-12">
        <h5 class="text-center"><b>APGAR SCORE</b></h5>
        <table class="" style="width:100%;" border="1" cellspacing="0">
          <tr>
            <td style="width:100px;">NAMA</td>
            <td>: {{@$reg->pasien->nama}}</td>
    
            <td>TGLLAHIR/UMUR</td>
            <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
          </tr>
    
          <tr>
            <td>RUANG</td>
            <td>: {{@baca_poli($reg->poli_id)}}</td>
            <td>TANGGAL</td>
            <td>: {{date('d-m-Y',strtotime(@$reg->created_at))}}</td>
          </tr>
        </table>
        <table class="" style="width:100%;" border="1" cellspacing="0">
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Parameter</td>
            <td style="width: 10%;" class="border bold p-1 text-center">Nilai</td>
          </tr>
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Sikap tubuh</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
              {{@$apgar['ballard_score']['sikap_tubuh']['nilai']}}
            </td>
          </tr>
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Persegi jendela (pergelangan tangan)</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
              {{@$apgar['ballard_score']['persegi_jendela']['nilai']}}
            </td>
          </tr>
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Rekoli lengan</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
              {{@$apgar['ballard_score']['rekoli_lengan']['nilai']}}
            </td>
          </tr>
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Sudut popliteal</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
              {{@$apgar['ballard_score']['sudut_popliteal']['nilai']}}
            </td>
          </tr>
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Tanda selempang</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
              {{@$apgar['ballard_score']['tanda_selempang']['nilai']}}
            </td>
          </tr>
          <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Tumit ke kuping</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
              {{@$apgar['ballard_score']['tumit_ke_kuping']['nilai']}}
            </td>
          </tr>
        </table>
        <table class="border" border="1" cellspacing="0" style="width: 100%; margin-top: 3rem;" id="table_terapi">
          <tr class="border">
            <td class="border bold p-1 text-center">KATEGORI</td>
            <td class="border bold p-1 text-center">1 MENIT</td>
            <td class="border bold p-1 text-center">5 MENIT</td>
            <td class="border bold p-1 text-center">10 MENIT</td>
            <td class="border bold p-1 text-center">>15 MENIT</td>
          </tr>
          <tr class="border">
            <td class="border p-1 text-center">Warna</td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['warna']['1_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['warna']['5_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['warna']['10_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['warna']['15_menit']}}
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1 text-center">Denyut Jantung</td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['denyut_jantung']['1_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['denyut_jantung']['5_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['denyut_jantung']['10_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['denyut_jantung']['15_menit']}}
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1 text-center">Reflek</td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['reflek']['1_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['reflek']['5_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['reflek']['10_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['reflek']['15_menit']}}
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1 text-center">Tonus otot</td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['tonus_otot']['1_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['tonus_otot']['5_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['tonus_otot']['10_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['tonus_otot']['15_menit']}}
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1 text-center">Pernapasan</td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['pernapasan']['1_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['pernapasan']['5_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['pernapasan']['10_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['pernapasan']['15_menit']}}
            </td>
          </tr>
          <tr class="border">
            <td class="border p-1 text-center bold">Jumlah</td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['jumlah']['1_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['jumlah']['5_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['jumlah']['10_menit']}}
            </td>
            <td class="border bold p-1 text-center">
              {{@$apgar['kategori']['jumlah']['15_menit']}}
            </td>
          </tr>
        </table>
        <table style="font-size:12px; width: 100%;" border="1" cellspacing="0" class="border">
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Obat-obatan</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[obat_obatan][tidak_diberikan]" {{
                  @$apgar['obat_obatan']['tidak_diberikan']=='Tidak diberikan' ? 'checked' : '' }} type="checkbox"
                  value="Tidak diberikan">
                <label class="form-check-label" style="font-weight: 400;">Tidak diberikan</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[obat_obatan][hepatitis_b]" {{
                  @$apgar['obat_obatan']['hepatitis_b']=='Hepatitis B' ? 'checked' : '' }} type="checkbox"
                  value="Hepatitis B">
                <label class="form-check-label" style="font-weight: 400;">Hepatitis B</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[obat_obatan][salep_mata]" {{
                  @$apgar['obat_obatan']['salep_mata']=='Salep mata' ? 'checked' : '' }} type="checkbox" value="Salep mata">
                <label class="form-check-label" style="font-weight: 400;">Salep mata</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[obat_obatan][cardiotonika]" {{
                  @$apgar['obat_obatan']['cardiotonika']=='Cardiotonika' ? 'checked' : '' }} type="checkbox"
                  value="Cardiotonika">
                <label class="form-check-label" style="font-weight: 400;">Cardiotonika</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[obat_obatan][antibiotika]" {{
                  @$apgar['obat_obatan']['antibiotika']=='Antibiotika' ? 'checked' : '' }} type="checkbox"
                  value="Antibiotika">
                <label class="form-check-label" style="font-weight: 400;">Antibiotika</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[obat_obatan][vitamin]" {{
                  @$apgar['obat_obatan']['vitamin']=='Vitamin 1mg/0.5mg' ? 'checked' : '' }} type="checkbox"
                  value="Vitamin 1mg/0.5mg">
                <label class="form-check-label" style="font-weight: 400;">Vitamin 1mg/0.5mg</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Tindakan Resusitasi</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[resusitasi][resusitasi_tanpa_tindak_lanjut]" {{
                  @$apgar['resusitasi']['resusitasi_tanpa_tindak_lanjut']=='Resusitasi tanpa tindak lanjut' ? 'checked' : ''
                  }} type="checkbox" value="Resusitasi tanpa tindak lanjut">
                <label class="form-check-label" style="font-weight: bold;">Tidak</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[resusitasi][resusitasi_dengan_tindak_lanjut]" {{
                  @$apgar['resusitasi']['resusitasi_dengan_tindak_lanjut']=='Resusitasi dengan tindak lanjut' ? 'checked'
                  : '' }} type="checkbox" value="Resusitasi dengan tindak lanjut">
                <label class="form-check-label" style="font-weight: bold;">Ya</label>
              </div>
              <div style="margin-left: 1.5rem;">
                <div>
                  <input class="form-check-input" name="fisik[resusitasi][langkah_awal]" {{
                    @$apgar['resusitasi']['langkah_awal']=='Langkah awal' ? 'checked' : '' }} type="checkbox"
                    value="Langkah awal">
                  <label class="form-check-label" style="font-weight: 400;">Langkah awal</label>
                </div>
                <div>
                  <input class="form-check-input" name="fisik[resusitasi][perawatan_rutin]" {{
                    @$apgar['resusitasi']['perawatan_rutin']=='Perawatan rutin' ? 'checked' : '' }} type="checkbox"
                    value="Perawatan rutin">
                  <label class="form-check-label" style="font-weight: 400;">Perawatan rutin</label>
                </div>
                <div>
                  <input class="form-check-input" name="fisik[resusitasi][vtp]" {{ @$apgar['resusitasi']['vtp']=='VTP'
                    ? 'checked' : '' }} type="checkbox" value="VTP">
                  <label class="form-check-label" style="font-weight: 400;">VTP</label>
                </div>
                <div>
                  <input class="form-check-input" name="fisik[resusitasi][intubasi]" {{
                    @$apgar['resusitasi']['intubasi']=='Intubasi' ? 'checked' : '' }} type="checkbox" value="Intubasi">
                  <label class="form-check-label" style="font-weight: 400;">Intubasi</label>
                </div>
                <div>
                  <input class="form-check-input" name="fisik[resusitasi][kompres_dada]" {{
                    @$apgar['resusitasi']['kompres_dada']=='Kompres dada' ? 'checked' : '' }} type="checkbox"
                    value="Kompres dada">
                  <label class="form-check-label" style="font-weight: 400;">Kompres dada</label>
                </div>
                <div>
                  <input class="form-check-input" name="fisik[resusitasi][obat_obatan]" {{
                    @$apgar['resusitasi']['obat_obatan']=='Obat obatan' ? 'checked' : '' }} type="checkbox"
                    value="Obat obatan">
                  <label class="form-check-label" style="font-weight: 400;">Obat obatan</label>
                  <div style="margin-left: 1.5rem;">
                    1. {{@$apgar['resusitasi']['daftar_obat']['1'] ?? '-'}} <br>
                    2. {{@$apgar['resusitasi']['daftar_obat']['2'] ?? '-'}} <br>
                    3. {{@$apgar['resusitasi']['daftar_obat']['3'] ?? '-'}} <br>
                    4. {{@$apgar['resusitasi']['daftar_obat']['4'] ?? '-'}} <br>
                    5. {{@$apgar['resusitasi']['daftar_obat']['5'] ?? '-'}} <br>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="font-weight:bold;" class="border" colspan="2">PEMERIKSAAN FISIK</td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Warna</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][warna][biasa]" {{
                  @$apgar['pemeriksaan_fisik']['warna']['biasa']=='Biasa' ? 'checked' : '' }} type="checkbox" value="Biasa">
                <label class="form-check-label" style="font-weight: 400;">Biasa</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][warna][pucat]" {{
                  @$apgar['pemeriksaan_fisik']['warna']['pucat']=='Pucat' ? 'checked' : '' }} type="checkbox" value="Pucat">
                <label class="form-check-label" style="font-weight: 400;">Pucat</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][warna][pletora]" {{
                  @$apgar['pemeriksaan_fisik']['warna']['pletora']=='Pletora' ? 'checked' : '' }} type="checkbox"
                  value="Pletora">
                <label class="form-check-label" style="font-weight: 400;">Pletora</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][warna][sianosis]" {{
                  @$apgar['pemeriksaan_fisik']['warna']['sianosis']=='Sianosis' ? 'checked' : '' }} type="checkbox"
                  value="Sianosis">
                <label class="form-check-label" style="font-weight: 400;">Sianosis</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][warna][ikterus]" {{
                  @$apgar['pemeriksaan_fisik']['warna']['ikterus']=='Ikterus' ? 'checked' : '' }} type="checkbox"
                  value="Ikterus">
                <label class="form-check-label" style="font-weight: 400;">Ikterus</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Pernapasan</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][pernapasan][frekuensi]" {{
                  @$apgar['pemeriksaan_fisik']['pernapasan']['frekuensi']=='Frekuensi' ? 'checked' : '' }} type="checkbox"
                  value="Frekuensi">
                <label class="form-check-label" style="font-weight: 400;">Frekuensi</label>
                <span>Frekuensi x/menit</span>
                {{@$apgar['pemeriksaan_fisik']['pernapasan']['frekuensi_detail']}}
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][pernapasan][tipe_abodminothoracal]" {{
                  @$apgar['pemeriksaan_fisik']['pernapasan']['tipe_abodminothoracal']=='Tipe Abdomonithoracal' ? 'checked'
                  : '' }} type="checkbox" value="Tipe Abdomonithoracal">
                <label class="form-check-label" style="font-weight: 400;">Tipe Abdomonithoracal</label>
                {{@$apgar['pemeriksaan_fisik']['pernapasan']['tipe_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Keadaan umum</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][keadaan_umum][state]" {{
                  @$apgar['pemeriksaan_fisik']['keadaan_umum']['state']=='State' ? 'checked' : '' }} type="checkbox"
                  value="State">
                <label class="form-check-label" style="font-weight: 400;">State</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][keadaan_umum][1]" {{
                  @$apgar['pemeriksaan_fisik']['keadaan_umum']['1']=='1' ? 'checked' : '' }} type="checkbox" value="1">
                <label class="form-check-label" style="font-weight: 400;">1</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][keadaan_umum][2]" {{
                  @$apgar['pemeriksaan_fisik']['keadaan_umum']['2']=='2' ? 'checked' : '' }} type="checkbox" value="2">
                <label class="form-check-label" style="font-weight: 400;">2</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][keadaan_umum][3]" {{
                  @$apgar['pemeriksaan_fisik']['keadaan_umum']['3']=='3' ? 'checked' : '' }} type="checkbox" value="3">
                <label class="form-check-label" style="font-weight: 400;">3</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][keadaan_umum][4]" {{
                  @$apgar['pemeriksaan_fisik']['keadaan_umum']['4']=='4' ? 'checked' : '' }} type="checkbox" value="4">
                <label class="form-check-label" style="font-weight: 400;">4</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][keadaan_umum][5]" {{
                  @$apgar['pemeriksaan_fisik']['keadaan_umum']['5']=='5' ? 'checked' : '' }} type="checkbox" value="5">
                <label class="form-check-label" style="font-weight: 400;">5</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Kepala</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][simetris]" {{
                  @$apgar['pemeriksaan_fisik']['kepala']['simetris']=='Simetris/Asimetris' ? 'checked' : '' }}
                  type="checkbox" value="Simetris/Asimetris">
                <label class="form-check-label" style="font-weight: 400;">Simetris/Asimetris</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][caput]" {{
                  @$apgar['pemeriksaan_fisik']['kepala']['caput']=='Caput Sukcadaneum' ? 'checked' : '' }} type="checkbox"
                  value="Caput Sukcadaneum">
                <label class="form-check-label" style="font-weight: 400;">Caput Sukcadaneum</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][sefal_hematoma]" {{
                  @$apgar['pemeriksaan_fisik']['kepala']['sefal_hematoma']=='Sefal hematoma' ? 'checked' : '' }}
                  type="checkbox" value="Sefal hematoma">
                <label class="form-check-label" style="font-weight: 400;">Sefal hematoma</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][lain]" {{
                  @$apgar['pemeriksaan_fisik']['kepala']['lain']=='Lain-lain' ? 'checked' : '' }} type="checkbox"
                  value="Lain-lain">
                <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                {{@$apgar['pemeriksaan_fisik']['kepala']['lain_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Fontanel</td>
            <td class="border">
              <div class="btn-group">
                {{@$apgar['pemeriksaan_fisik']['fontanel_1']}} x <br>
                {{@$apgar['pemeriksaan_fisik']['fontanel_2']}} cm <br>
              </div>
              <span>Kelainan</span>
              {{@$apgar['pemeriksaan_fisik']['fontanel_keterangan']}}
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Sutura</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][sutura][normal]" {{
                  @$apgar['pemeriksaan_fisik']['sutura']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][sutura][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['sutura']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['sutura']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Rambut</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][rambut][normal]" {{
                  @$apgar['pemeriksaan_fisik']['rambut']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][rambut][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['rambut']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['rambut']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Mata</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][mata][normal]" {{
                  @$apgar['pemeriksaan_fisik']['mata']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][mata][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['mata']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['mata']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Hidung</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][hidung][normal]" {{
                  @$apgar['pemeriksaan_fisik']['hidung']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][hidung][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['hidung']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['hidung']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Mulut</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][mulut][normal]" {{
                  @$apgar['pemeriksaan_fisik']['mulut']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][mulut][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['mulut']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['mulut']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Lidah</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][lidah][normal]" {{
                  @$apgar['pemeriksaan_fisik']['lidah']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][lidah][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['lidah']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['lidah']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Gigi</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][gigi][normal]" {{
                  @$apgar['pemeriksaan_fisik']['gigi']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][gigi][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['gigi']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['gigi']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Leher</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][leher][normal]" {{
                  @$apgar['pemeriksaan_fisik']['leher']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][leher][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['leher']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['leher']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Kulit</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][kulit][normal]" {{
                  @$apgar['pemeriksaan_fisik']['kulit']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][kulit][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['kulit']['tidak_normal']=='Tidak normal' ? 'checked' : '' }} type="checkbox"
                  value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['kulit']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Jaringan subkutis</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][jaringan_subkutis][kurang]" {{
                  @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['kurang']=='Kurang' ? 'checked' : '' }} type="checkbox"
                  value="Kurang">
                <label class="form-check-label" style="font-weight: 400;">Kurang</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][jaringan_subkutis][cukup]" {{
                  @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['cukup']=='Cukup' ? 'checked' : '' }} type="checkbox"
                  value="Cukup">
                <label class="form-check-label" style="font-weight: 400;">Cukup</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][jaringan_subkutis][tidak_ada]" {{
                  @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['tidak_ada']=='Tidak ada' ? 'checked' : '' }}
                  type="checkbox" value="Tidak ada">
                <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Genitalia</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][genitalia][l]" {{
                  @$apgar['pemeriksaan_fisik']['genitalia']['l']=='L' ? 'checked' : '' }} type="checkbox" value="L">
                <label class="form-check-label" style="font-weight: 400;">L</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][genitalia][p]" {{
                  @$apgar['pemeriksaan_fisik']['genitalia']['p']=='P' ? 'checked' : '' }} type="checkbox" value="P">
                <label class="form-check-label" style="font-weight: 400;">P</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][genitalia][normal]" {{
                  @$apgar['pemeriksaan_fisik']['genitalia']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][genitalia][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['genitalia']['tidak_normal']=='Tidak Normal' ? 'checked' : '' }}
                  type="checkbox" value="Tidak Normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak Normal</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Testiskulorum</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][testiskulorum][belum_lengkap]" {{
                  @$apgar['pemeriksaan_fisik']['testiskulorum']['belum_lengkap']=='Belum lengkap' ? 'checked' : '' }}
                  type="checkbox" value="Belum lengkap">
                <label class="form-check-label" style="font-weight: 400;">Belum lengkap</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][testiskulorum][lengkap]" {{
                  @$apgar['pemeriksaan_fisik']['testiskulorum']['lengkap']=='Lengkap' ? 'checked' : '' }} type="checkbox"
                  value="Lengkap">
                <label class="form-check-label" style="font-weight: 400;">Lengkap</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][testiskulorum][tidak_ada]" {{
                  @$apgar['pemeriksaan_fisik']['testiskulorum']['tidak_ada']=='Tidak ada' ? 'checked' : '' }}
                  type="checkbox" value="Tidak ada">
                <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Neurologi</td>
            <td class="border">
              <div>
                <span>Reflek Moro</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_moro_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_moro_minus']}}
                </div>
              </div>
              <div>
                <span>Reflek Hidap</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_hisap_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_hisap_minus']}}
                </div>
              </div>
              <div>
                <span>Reflek Pegang</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_pegang_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_pegang_minus']}}
                </div>
              </div>
              <div>
                <span>Reflek Rooting</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_rooting_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_rooting_minus']}}
                </div>
              </div>
              <div>
                <span>Reflek Babinsky</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_babynsky_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_babynsky_minus']}}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Toraks</td>
            <td class="border">
              <div>
                <span>Bentuk</span>
                {{@$apgar['pemeriksaan_fisik']['toraks']['bentuk']}}
              </div>
              <div>
                <span>Pergerakan</span>
                {{@$apgar['pemeriksaan_fisik']['toraks']['pergerakan']}}
              </div>
              <div>
                <span>Retraksi Intercostal</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['toraks']['retraksi_intercostal_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['toraks']['retraksi_intercostal_minus']}}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Paru-paru</td>
            <td class="border">
              <div>
                <span>Suara pernafasan bronchovascular</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_pernapasan_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_pernapasan_minus']}}
                </div>
              </div>
              <div>
                <span>Suara tambahan</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_minus']}} <br>
                  jelaskan : {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_detail']}}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Jantung</td>
            <td class="border">
              <div>
                <span>Frekuensi</span>
                {{@$apgar['pemeriksaan_fisik']['jantung']['frekuensi']}}
              </div>
              <div>
                <span>Bising</span>
                <div class="btn-group">
                  {{@$apgar['pemeriksaan_fisik']['jantung']['bising_plus']}} /
                  {{@$apgar['pemeriksaan_fisik']['jantung']['bising_minus']}}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Abdomen</td>
            <td class="border">
              {{@$apgar['pemeriksaan_fisik']['abdomen']}}
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Hati</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][hati][tidak_teraba]" {{
                  @$apgar['pemeriksaan_fisik']['hati']['tidak_teraba']=='Tidak teraba' ? 'checked' : '' }} type="checkbox"
                  value="Tidak teraba">
                <label class="form-check-label" style="font-weight: 400;">Tidak teraba</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][hati][teraba]" {{
                  @$apgar['pemeriksaan_fisik']['hati']['teraba']=='Teraba' ? 'checked' : '' }} type="checkbox"
                  value="Teraba">
                <label class="form-check-label" style="font-weight: 400;">Teraba</label>
                {{@$apgar['pemeriksaan_fisik']['hati']['teraba_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Limpa</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][limpa][tidak_teraba]" {{
                  @$apgar['pemeriksaan_fisik']['limpa']['tidak_teraba']=='Tidak teraba' ? 'checked' : '' }} type="checkbox"
                  value="Tidak teraba">
                <label class="form-check-label" style="font-weight: 400;">Tidak teraba</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][limpa][teraba]" {{
                  @$apgar['pemeriksaan_fisik']['limpa']['teraba']=='Teraba' ? 'checked' : '' }} type="checkbox"
                  value="Teraba">
                <label class="form-check-label" style="font-weight: 400;">Teraba, Schiffner</label>
                {{@$apgar['pemeriksaan_fisik']['limpa']['teraba_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Umbilikus</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][umbilikus][normal]" {{
                  @$apgar['pemeriksaan_fisik']['umbilikus']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][umbilikus][kelainan]" {{
                  @$apgar['pemeriksaan_fisik']['umbilikus']['kelainan']=='Kelainan' ? 'checked' : '' }} type="checkbox"
                  value="Kelainan">
                <label class="form-check-label" style="font-weight: 400;">Kelainan</label>
                {{@$apgar['pemeriksaan_fisik']['umbilikus']['kelainan_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Pembesaran kelenjar di</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][ada]" {{
                  @$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['ada']=='Ada' ? 'checked' : '' }} type="checkbox"
                  value="Ada">
                <label class="form-check-label" style="font-weight: 400;">Ada</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][tidak_ada]" {{
                  @$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['tidak_ada']=='Tidak ada' ? 'checked' : '' }}
                  type="checkbox" value="Tidak ada">
                <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                {{@$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['tidak_ada_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Anus</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][anus][ada]" {{
                  @$apgar['pemeriksaan_fisik']['anus']['ada']=='Ada' ? 'checked' : '' }} type="checkbox" value="Ada">
                <label class="form-check-label" style="font-weight: 400;">Ada</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][anus][tidak_ada]" {{
                  @$apgar['pemeriksaan_fisik']['anus']['tidak_ada']=='Tidak ada' ? 'checked' : '' }} type="checkbox"
                  value="Tidak ada">
                <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Ektremitas bawah</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][ektremitas_bawah][normal]" {{
                  @$apgar['pemeriksaan_fisik']['ektremitas_bawah']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][ektremitas_bawah][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['ektremitas_bawah']['tidak_normal']=='Tidak normal' ? 'checked' : '' }}
                  type="checkbox" value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['ektremitas_bawah']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Ektremitas atas</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][ektremitas_atas][normal]" {{
                  @$apgar['pemeriksaan_fisik']['ektremitas_atas']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][ektremitas_atas][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['ektremitas_atas']['tidak_normal']=='Tidak normal' ? 'checked' : '' }}
                  type="checkbox" value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['ektremitas_atas']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:30%; font-weight:bold;" class="border">Tulang-tulang</td>
            <td class="border">
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][tulang_tulang][normal]" {{
                  @$apgar['pemeriksaan_fisik']['tulang_tulang']['normal']=='Normal' ? 'checked' : '' }} type="checkbox"
                  value="Normal">
                <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                <input class="form-check-input" name="fisik[pemeriksaan_fisik][tulang_tulang][tidak_normal]" {{
                  @$apgar['pemeriksaan_fisik']['tulang_tulang']['tidak_normal']=='Tidak normal' ? 'checked' : '' }}
                  type="checkbox" value="Tidak normal">
                <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                {{@$apgar['pemeriksaan_fisik']['tulang_tulang']['tidak_normal_detail']}}
              </div>
            </td>
          </tr>
        </table>
        <div class="form-group" style="margin-top: 10px;">
          {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
        </div>
      </div>
    </div>
        
    @endif
    @endif
    {{-- DD DISINI AMAN --}}
    

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
                @$icdxDiagnosaTambahan = @$content['icdx_diagnosa_tambahan'] ?? null;
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
              {{-- {{@$icdxDiagnosaTambahan}} --}}
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
                  @foreach (@$folio as $tindakan)
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

    {{-- E-Resume Rawat Inap --}}
    @if (count($resume_inap) > 0)
     <div style="page-break-before: always;">
      <table style="border: none !important; width:100%;font-size:12px;"> 
       <tr>
          <td style="width:10%; text-align: center; width: 30%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 25px;"> <br>
            <b style="font-size:8px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
            <b style="font-size:6px; font-weight:normal;"> {{ configrs()->tlp }}</b><br/>
            <b style="font-size:6px; font-weight:normal;"> Laman : {{ configrs()->website }} <span style="font-size:5px; margin-left:5px">Email : {{ configrs()->email }}</span></b><br/>
          </td>
          <td style="text-align: center; width: 30%; vertical-align: middle;">
              <h2 class="text-center" style="margin-top: -3rem; vertical-align: middle;">RESUME MEDIS PASIEN PULANG</h2>
          </td>
          <td style="width: 40%; vertical-align: top;" rowspan="2">
            <div style="border-radius: 10px; border: 1px solid black; padding: .5rem;">
                <div>
                    Nama : {{@$reg->pasien->nama}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Tanggal Lahir : {{@$reg->pasien->tgllahir}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    No. RM : {{@$reg->pasien->no_rm}} <br>
                </div>
            </div>
          </td>
        </tr>
      </table>

      <table style="border: 1px solid black; width:100%;font-size:12px; margin-top: -1rem;">
        <tr>
            <td style="padding: .3rem; width: 20%">Tanggal masuk</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{date('d-m-Y H:i:s', strtotime(@$reg->rawat_inap->tgl_masuk))}}</td>
            <td style="padding: .3rem; width: 20%">Tanggal kontrol</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{(@$content['tanggal_kontrol'])}}</td>
        </tr>
        <tr>
            <td style="padding: .3rem; width: 20%">Tanggal keluar</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{@$reg->rawat_inap->tgl_keluar ? date('d-m-Y H:i:s', strtotime(@$reg->rawat_inap->tgl_keluar)) : '-'}}</td>
            <td style="padding: .3rem; width: 20%">Tujuan poliklinik</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{@$content['tujuan_poliklinik']}}</td>
        </tr>
      </table>
      <table style="border: 1px solid black; width:100%;font-size:12px;"> 
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2"><b>INDIKASI RAWAT INAP :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2">
                <p style="margin: 0; padding: 0;">{{@$content['indikasi_rawat_inap']}}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2"><b>RINGKASAN RIWAYAT PENYAKIT :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['ringkasan_riwayat_penyakit'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2"><b>PEMERIKSAAN FISIK :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['pemeriksaan_fisik'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2"><b>PEMERIKSAAN PENUNJANG :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['pemeriksaan_penunjang'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2"><b>TERAPI / PENGOBATAN SELAMA DI RUMAH SAKIT :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;" colspan="2">
                <p style="margin: 0; padding: 0;">{{@$content['terapi_di_rumah_sakit']}}</p>
            </td>
        </tr>
        <tr>
          <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%"><b>CATATAN :</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['catatan'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem;"><b>REAKSI OBAT :</b></td>
            <td style="padding: .3rem 0 0 .3rem;;">
              <div style="display: inline-block;">
                <div style="vertical-align: middle; display: inline-block">
                    <input class="form-check-input"
                      style="vertical-align: middle;"
                        {{ @$content['pasien_usia_lanjut']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                        type="checkbox" value="Tidak">
                    <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Tidak</label>
                </div>
                <div style="vertical-align: middle; display: inline-block">
                    <input class="form-check-input"
                      style="vertical-align: middle;"
                        {{ @$content['pasien_usia_lanjut']['pilihan'] == 'Ya' ? 'checked' : '' }}
                        type="checkbox" value="Ya">
                    <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Ya</label>
                      {{@$content['pasien_usia_lanjut']['pilihan_ya']}}
                </div>
              </div>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>DIAGNOSA UTAMA :</b></td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>ICD X :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{{@$content['diagnosa_utama']}}</p>
            </td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">
                  {{-- Penutupan pengambilan icd dari resume, sepakat untuk icd full dari input koding --}}
                  {{-- @if ($content['icdx_diagnosa_utama'])
                    {{@baca_code_diagnosa($content['icdx_diagnosa_utama'])}}
                  @else --}}
                  <ul>
                    @foreach ($icd10Primary as $icd)
                      <li>{{baca_icd10($icd->icd10)}}</li>
                    @endforeach
                  </ul>
                  {{-- @endif --}}
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>DIAGNOSA TAMBAHAN :</b></td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>ICD X :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">- {{@$content['diagnosa_tambahan']}}</p>
                @if (is_array(@$content['tambahan_diagnosa_tambahan']))
                  @foreach (@$content['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                    <p style="margin: 0; padding: 0;">- {{@$content['tambahan_diagnosa_tambahan'][$key]}}</p>
                  @endforeach
                @endif
            </td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                {{-- <p style="margin: 0; padding: 0;">- {{@$content['icdx_diagnosa_tambahan']}}</p>
                @if (is_array(@$content['tambahan_icdx_diagnosa_tambahan']))
                  @foreach (@$content['tambahan_icdx_diagnosa_tambahan'] as $key => $icdx_diagnosa_tambahan)
                    <p style="margin: 0; padding: 0;">- {{@$content['tambahan_icdx_diagnosa_tambahan'][$key]}}</p>
                  @endforeach
                @endif --}}
                @php
                  $icd10Secondary_jkn = App\JknIcd10::where('registrasi_id', $reg->id)
                    ->whereNull('kategori')
                    ->get();
                @endphp
                @if (@$icd10Secondary_jkn)
                      @foreach (@$icd10Secondary_jkn as $icd)
                          <li>{{baca_icd10(@$icd->icd10)}}</li>
                      @endforeach
                @endif
                 @php
                    @$icdxDiagnosaTambahan = @$content['icdx_diagnosa_tambahan'] ?? null;
                @endphp

                {{@baca_code_diagnosa($icdxDiagnosaTambahan)}}
            </td>
        </tr> 
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>TINDAKAN / PROSEDUR / OPERASI :</b></td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>ICD IX :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! str_replace(',', '<br>', @$content['tindakan']) !!}</p>
                <p style="margin: 0; padding: 0;">
                  {!! is_array(@$content['tambahan_tindakan']) ? implode('<br>', @$content['tambahan_tindakan']) : str_replace(',', '<br>', @$content['tambahan_tindakan']) !!}</p>
                {{-- @if (is_array(@$content['tambahan_tindakan']))
                  @foreach (@$content['tambahan_tindakan'] as $key => $tindakan)
                    <p style="margin: 0; padding: 0;">- {{@$content['tambahan_tindakan'][$key]}}</p>
                  @endforeach
                @endif --}}
            </td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
              @if (count($icd9) > 0)
                <ul>
                  @foreach ($icd9 as $jkns9)
                    <li>{{$jkns9->icd9}} - {{baca_prosedur($jkns9->icd9)}}</li>
                      
                  @endforeach
                </ul>
                  @endif

                  
                <p style="margin: 0; padding: 0;">- {{@$content['icdix_tindakan']}}</p>
                @if (is_array(@$content['tambahan_icdix_tindakan']))
                  @foreach (@$content['tambahan_icdix_tindakan'] as $key => $icdix_tindakan)
                    @if (@$content['tambahan_icdix_tindakan'][$key])
                      <p style="margin: 0; padding: 0;">- {{@$content['tambahan_icdix_tindakan'][$key]}}</p>  
                    @endif
                  @endforeach
                @endif


                

            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%" colspan="2"><b>TINDAKAN :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%" colspan="2">
                <p style="margin: 0; padding: 0;">{{@$content['tindakan_diberikan']}}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%" colspan="2"><b>INSTRUKSI PERAWAT LANJUTAN / EDUKASI :</b></td>
        </tr>
      </table>
     </div>
     <div style="page-break-before: always;">
      <table style="border: 1px solid black; width:100%;font-size:12px;"> 
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%" colspan="2">
                <p style="margin: 0; padding: 0;">{{@$content['edukasi']}}</p>
                <br>
                <p>Cara Pulang : </p>
                <div style="display: inline-block;">
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'Izin dokter' ? 'checked' : '' }}
                          type="checkbox" value="Izin dokter">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Izin dokter</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'Pindah RS' ? 'checked' : '' }}
                          type="checkbox" value="Pindah RS">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Pindah RS</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'APS' ? 'checked' : '' }}
                          type="checkbox" value="APS">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">APS</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'Melariksan Diri' ? 'checked' : '' }}
                          type="checkbox" value="Melariksan Diri">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Melarikan Diri</label>
                  </div>
                </div>
                <br>
                <p>Kondisi Saat Pulang : </p>
                <div style="display: inline-block;">
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Sembuh' ? 'checked' : '' }}
                          type="checkbox" value="Sembuh">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Sembuh</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Perbaikan' ? 'checked' : '' }}
                          type="checkbox" value="Perbaikan">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Perbaikan</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Tidak sembuh' ? 'checked' : '' }}
                          type="checkbox" value="Tidak sembuh">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Tidak sembuh</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Meninggal' ? 'checked' : '' }}
                          type="checkbox" value="Meninggal">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Meninggal</label>
                  </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%" colspan="2"><b>TERAPI PULANG :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%" colspan="2">
                <p style="margin: 0; padding: 0;">{{@$content['terapi_pulang_detail']}}</p>
            </td>
        </tr>
      </table>
      <table style="width: 100%; font-size: 12px; margin-top: 5rem; text-align:center;">
        @php
            $ttd_pasien = \Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
            $sign_pad = App\TandaTangan::where('registrasi_id', $reg->id)
                ->where('jenis_dokumen', 'e-resume')
                ->orderByDesc('id')
                ->first();
            $ttd = App\TandaTangan::where('registrasi_id', $reg->id)
                ->orderByDesc('id')
                ->first();
        @endphp
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="text-center">Soreang, 
                    @if (@$rawatinap->tgl_keluar)
                        {{date('d-m-Y', strtotime(@$rawatinap->tgl_keluar))}}
                    @else
                        {{date('d-m-Y', strtotime(@$resume->created_at))}}
                    @endif
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center">
                  {{-- Pasien / Keluarga Pasien --}}
                  @if (ttdPasienBpjs($reg->created_at))
                    Tanda Tangan Pasien / Keluarga atau Wali
                  @elseif ($sign_pad)
                    Tanda Tangan Pasien
                  @else
                    Tanda Tangan Pasien / Keluarga atau Wali
                  @endif
                </td>
                
                <td>&nbsp;</td>
                <td class="text-center">Dokter penanggung jawab</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center">
                  @if (ttdPasienBpjs($reg->created_at))
                    @if (@$ttd->tanda_tangan)
                      <img src="{{url(path_ttd().'/images/upload/ttd/' . @$ttd->tanda_tangan)}}" alt="ttd" width="200" height="100">
                    @endif
                  @elseif ($sign_pad)
                    @if (@$sign_pad->tanda_tangan)
                      <img src="{{url(path_ttd().'/images/upload/ttd/' . @$sign_pad->tanda_tangan)}}" alt="ttd" width="200" height="100">
                    @endif
                  @endif
                </td>
                <td>&nbsp;</td>
                <td class="text-center">
                    {{-- @if (isset($proses_tte))
                        #
                    @elseif (isset($tte_nonaktif)) --}}
                        @php
                        $pegawai = \Modules\Pegawai\Entities\Pegawai::find($reg->rawat_inap->dokter_id);
                        @$base64  = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$pegawai->nama . ' | ' . @$pegawai->nip . ' | ' . @$resume->created_at))
                        @endphp
                        <img src="data:image/png;base64, {!! $base64 !!} ">
                    {{-- @else
                        &nbsp;
                    @endif --}}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center">{{@$reg->pasien->nama}}</td>
                <td>&nbsp;</td>
                <td class="text-center">{{baca_dokter(@$reg->rawat_inap->dokter_id)}}</td>
            </tr>
        </table>
    @endif
    {{-- End E-Resume --}}
    {{-- DD DISINI AMAN D--}}
    {{-- Laporan Tindakan IRJ --}}
    @foreach ($perencanaans as $perencanaan)
    <div style="page-break-before: always;">
        @php
            $cetak     = json_decode(@$perencanaan->keterangan);
            $pasien    = App\Pasien::find($perencanaan->pasien_id);
            $dokter    = $perencanaan->dokter_id;
        @endphp
      <table style="width: 100%; border: 1px solid black; border-collapse: collapse">
        <tr>
            <td style="width: 20%; text-align:center; border: 1px solid black; border-collapse: collapse" >
                <img src="{{ public_path('images/'.configrs()->logo) }}" alt="logo" style="width: 80px;margin: 10px 5px">
            </td>
            <td style="width: 40%; font-weight:bold;font-size:20px;text-align:center; border: 1px solid black; border-collapse: collapse">LAPORAN TINDAKAN RAWAT JALAN</td>
            <td style="width: 40%;padding: 5px;border: 1px solid black; border-collapse: collapse">
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">NORM : </span> {{@$pasien->no_rm}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">NAMA : </span> {{@$pasien->nama}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">TGL LAHIR : </span> {{date('d-m-Y', strtotime(@$pasien->tgllahir))}} 
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 5px;border: 1px solid black; border-collapse: collapse">
                <span style="font-weight: bold">Tanggal Tindakan : </span> {{ @$cetak->tgl_tindakan ? date('d-m-Y', strtotime(@$cetak->tgl_tindakan)) : '-'}}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 5px; text-align: center;font-weight:bold;border: 1px solid black; border-collapse: collapse"> Uraian Tindakan </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px;border: 1px solid black; border-collapse: collapse">{{@$cetak->uraian_tindakan}}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 70%; padding: 5px;border: 1px solid black; border-collapse: collapse">
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Diagnosa : </span> {{@$cetak->diagnosa}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Tindakan : </span> {{@$cetak->tindakan}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Jaringan yang dieksisi : </span> {{@$cetak->jaringanEksisi}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Dikirim ke PA : </span> {{@$cetak->sendToPA}} 
                </div>
            </td>
            <td style="width: 30%; padding: 5px;border: 1px solid black; border-collapse: collapse">
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Dokter : </span> {{baca_dokter(@$cetak->dokter)}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Asisten : </span> {{baca_pegawai(@$cetak->asisten)}} 
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 5px; text-align: center;font-weight:bold;border: 1px solid black; border-collapse: collapse"> Instruksi Post Tindakan </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px;border: 1px solid black; border-collapse: collapse">{{@$cetak->instruksi}}</td>
        </tr>
      </table>
      <table width="100%" style="border-collapse: collapse; border: 0px solid black !important">
          <tr>
              <td style="border: 0px solid black !important;" width="35%">&nbsp;</td>
              <td style="border: 0px solid black !important;" width="35%">&nbsp;</td>
              <td style="border: 0px solid black !important; text-align: center;">
                  <p style="">Tanda Tangan Dokter</p>
              </td>
          </tr>
          <tr>
              <td style="border: 0px solid black !important;">&nbsp;</td>
              <td style="border: 0px solid black !important;">&nbsp;</td>
              <td style="border: 0px solid black !important;">&nbsp;</td>
          </tr>
          <tr>
              <td style="border: 0px solid black !important;">&nbsp;</td>
              <td style="border: 0px solid black !important;">&nbsp;</td>
              <td style="border: 0px solid black !important; text-align: center;">
                @php
                  $pegawai = \Modules\Pegawai\Entities\Pegawai::find(@$dokter);
                  $base64 = null;
                  if ($pegawai) {
                    @$base64 = base64_encode(
                      \QrCode::format('png')
                        ->size(75)
                        ->merge('/public/images/' . configrs()->logo, 0.3)
                        ->errorCorrection('H')
                        ->generate(
                          $pegawai->nama . ' , ' . $pegawai->sip . ' , ' . date('d-m-Y H:i', strtotime(@$cetak->tgl_tindakan))
                        )
                    );
                  }
                @endphp
                @if ($base64)
                  <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
              </td>
          </tr>
          <tr>
              <td style="border: 0px solid black !important;">&nbsp;</td>
              <td style="border: 0px solid black !important;">&nbsp;</td>
              <td style="border: 0px solid black !important;">&nbsp;</td>
          </tr>
          <tr>
              <td style="border: 0px solid black !important; ">&nbsp;</td>
              <td style="border: 0px solid black !important; ">&nbsp;</td>
              <td style="border: 0px solid black !important; text-align: center;">
                  <p style="">{{@$pegawai->nama}}</p>
              </td>
          </tr>
      </table>
    </div>
    @endforeach

    {{-- END Laporan Tindakna IRJ --}}

    {{-- Hasil Lab --}}
    @if (count($hasilLab) > 0)
      @php
          libxml_use_internal_errors(true);
          @$lastIndex = count($hasilLab) - 1;
      @endphp
      <div style="page-break-before: always;">
      </div>
        @foreach ($hasilLab as $keys=>$itemhlab)
        <table border=0 style="width: 100%;"> 
          <tr>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
            </td>
            <td style="text-align: center">
              <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
              <b style="font-size:17px;">INSTALASI LABORATORIUM PATOLOGI KLINIK</b><br/>
              <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td style="width:10%;">
              {{-- <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}
            </td>
          </tr>
        </table>
        <hr>
        <h5 class="text-center" style="font-weight: bold;">HASIL PEMERIKSAAN LABORATORIUM</h5>
        <table style="width: 60%;">
          @php
            $folios = Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->id)->where('order_lab_id', @$itemhlab->order_lab_id)->first();
          @endphp
            <tbody>
              <tr>
                <td style="font-size:12px;width: 40%; font-weight: bold;">Dokter Penanggungjawab</td>
                <td style="font-size:12px;font-weight: bold;">: {{@baca_dokter($itemhlab->dokter_id) ?? @baca_dokter($folios->dokter_pelaksana)}}</td>
              </tr>
            </tbody>
        </table>
        <p style="padding-left:20px;">
          =======================================================================================
        </p>
          <table style="width: 100%;">
            <tbody style="font-size: 8pt; ">
              <tr>
                <th style="width: 17%">No. RM</th> <td>: {{ $reg->pasien->no_rm }}</td>
              </tr>
              <tr>
                <th>Nomor Lab</th> <td>: {{$itemhlab->no_lab}}</td>
                <th style="width: 17%">Dokter Pengirim</th> <td style="font-size: 11px;">: {{ baca_dokter($reg->dokter_id) }} </td>
              </tr>
              <tr>
                <th style="">Nama Pasien</th> <td>: {{ $reg->pasien->nama }}</td>
                <th style="width: 17%;">Asal Poli/Ruangan</th> 
                <td>: 
                  @if (substr($reg->status_reg,0,1) == 'G' || substr($reg->status_reg,0,1) == 'J')
                  {{ baca_poli($reg->poli_id) }}
                  @elseif ($reg->status_reg == 'I1')
                  Antrian Rawat Inap
                  @elseif ($reg->status_reg == 'I2')
                  {{ baca_kamar(\App\Rawatinap::where('registrasi_id',$reg->id)->first()->kamar_id) }}
                  @endif
                </td>
              </tr>
              
              <tr>
                  @php
                      @$licaResult = \App\LicaResult::where('no_lab', $itemhlab->no_lab)->first();
                      if(@$licaResult){
                        @$tgl_labs = @date('d-m-Y H:i',strtotime(@$licaResult->tgl_pemeriksaan));
                        @$tgl_labs_v2 = @date('d M Y H:i',strtotime(@$licaResult->tgl_pemeriksaan));
                        @$tgl_order = @date('d-m-Y H:i',strtotime(@$licaResult->created_at));
                      }else{
                        @$tgl_labs = @date('d-m-Y H:i',strtotime(@$hasilLab[0]->created_at));
                        @$tgl_labs_v2 = @date('d M Y H:i',strtotime(@$hasilLab[0]->created_at));
                        @$tgl_order = @date('d-m-Y H:i',strtotime(@$hasilLab[0]->created_at));
                      }
                  @endphp
                <th style="width: 17%;">Usia</th> <td>: {{ hitung_umur_by_tanggal(@$reg->pasien->tgllahir, @$licaResult->tgl_pemeriksaan ?? @$hasilLab[0]->created_at) }}</td>
                <th style="width: 17%;">Tanggal Order</th> <td style="font-size: 11px;">: 
                  {{-- Todo: tanggal order bukan dari $lab->created_at --}}
                  {{$tgl_labs}}
                </td>
              </tr>
              <tr>
                <th>Alamat</th> <td>: {{ $reg->pasien->alamat }}</td>
                <th style="width: 17%">Tanggal Selesai</th> <td style="font-size: 11px;">: {{$tgl_order}}</td>
              </tr>
              {{-- <tr>
                <th>Ket. Klinis</th> <td>: </td>
                
              </tr> --}}

            </tbody>
          </table>
        <p style="padding-left:20px;">
          =======================================================================================
        </p>
        <table style="width:100%; padding-bottom:5px">
          
              @if(is_iterable($itemhlab->jenis_pemeriksaan) && $itemhlab->total_pemeriksaan > 0)
                  <thead>
                      <tr><td colspan="5" class="text-center"><span>Nomor Lab: <i>{{$itemhlab->no_lab}} ({{$itemhlab->total_pemeriksaan}})</i></span></td></tr>
                      <tr>
                          <th class="">PEMERIKSAAN</th>
                          <th class="text-center" style="padding-right:50px;">HASIL</th>
                          <th class="text-center" style="padding-right:50px;">SATUAN</th>
                          <th class="text-center" style="padding-right:50px;">NILAI RUJUKAN</th>
                          <th class="text-center" style="padding-right:50px;">KET</th>
                      </tr>
                  </thead>

                  <tbody>
                    @php 
                        $kat = 0;
                        $groupedData = []; // Array untuk menampung data yang dikelompokkan berdasarkan sub_group
                        // Mengelompokkan data berdasarkan group_test dan sub_group
                        foreach ($itemhlab->jenis_pemeriksaan as $item) {
                            foreach ($item as $lab) {
                                @$groupedData[$lab->group_test][$lab->sub_group][] = $lab;
                            }
                        }
                    @endphp
                    
                    @foreach ($groupedData as $groupName => $subGroups)
                        <tr class="_border">
                            <td colspan="5" style="padding-top:10px;"><b>{{ $groupName }}</b></td>
                        </tr>
            
                        @foreach ($subGroups as $subGroupName => $tests)
                            @if ($subGroupName)
                                
                            <tr class="_border">
                                <td colspan="5" style="padding-top:10px;"><b>{{ $subGroupName }}</b></td>
                            </tr>
                            @endif
            
                            @foreach ($tests as $lab)
                                <tr>
                                    <td valign="top">{{ $lab->test_name }}</td>
                                    <td class="text-center" style="padding-right:50px;">
                                        @if ($lab->flag == "Abnormal")
                                            <sup>*</sup>
                                        @elseif ($lab->flag == "Critical")
                                            <sup>**</sup>
                                        @endif
                                        {{-- {!! $lab->result !!}  --}}
                                        {!! htmlentities($lab->result) !!}
                                        @if (@$lab->notes)
                                            <br/>{{@$lab->notes}}
                                        @endif
                                    </td>
                                    <td class="text-center" style="padding-right:50px;">{{ $lab->unit }}</td>
                                    <td class="text-center" style="padding-right:50px;">{{ $lab->nilai_normal }}</td>
                                    <td class="text-center" style="padding-right:50px;">{{ $lab->flag }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
            
                    <tr>
                        <td colspan="5">
                            =======================================================================================
                        </td>
                    </tr>
                </tbody>
              @endif
            </table>
          {{-- <p style="padding-left:0px;"> --}}
        <i style="padding-left:0px;">Dicetak pada: {{@$tgl_labs_v2}}</i> 
          {{-- </p> --}}
        {{-- <br>
        <br> --}}
        <div style="padding: 5px; float:right; text-align: center">
          {{ config('app.kota') }}, {{@$tgl_labs_v2}}
          @php
              if (isset($folios->dokter_pelaksana)) {
                @$dokter = \Modules\Pegawai\Entities\Pegawai::find($folios->dokter_pelaksana);
              } else {
                @$dokter = \Modules\Pegawai\Entities\Pegawai::find($itemhlab->dokter_id);
              }
              @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . date('d-m-Y H:i,',strtotime(@$licaResult->tgl_pemeriksaan))));
          @endphp
          @if ($base64)
          <br>
          <br>
            <img src="data:image/png;base64, {!! $base64 !!} ">
          <br>
          @else
            <br/><br/><br/>
          @endif
          {{-- <u>dr. Hj. Jenny, Sp. PK</u><br> --}}
          @if (isset($folios->dokter_pelaksana))
            {{@baca_dokter($folios->dokter_pelaksana)}}
          @else  
            {{@baca_dokter($itemhlab->dokter_id)}}
          @endif
          <hr>
        </div>

      
        <div style="float:none;clear:both"></div>
          @if ($keys !== $lastIndex)
            <div style="page-break-after: always"></div>
         @endif

        @endforeach
    @endif
    {{-- END Hasil Lab --}}

    {{-- Hasil Lab PA--}}
    @if (count($hasilLabsPA) > 0)
      <div style="page-break-before: always;">
        <table border=0 style="width: 100%;"> 
          <tr>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
            </td>
            <td style="text-align: center">
              <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
              <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
              <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
              <b style="font-size:17px;">LABORATORIUM PATOLOGI ANATOMIK</b><br/>
              <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td style="width:10%;">
              <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
            </td>
          </tr>
        </table>
        <hr>
        <br>
        <table style="width: 100%;padding-left:25px;">
          <tbody style="font-size: 8pt; ">
            <tr>
              <th style="width: 17%">Kepada Yth</th> <td style="font-size: 11px;">: {{ baca_dokter($hasilLabPA->dokter_id) }} </td>
            </tr>
            <tr>
              <th style="width: 17%">Bagian</th> <td style="font-size: 11px;">: {{ baca_poli(@$reg->poli_id) }} </td>
            </tr>
            <tr>
              <th style="width: 17%">Rs/Praktek</th> <td style="font-size: 11px;">: {{ strtoupper(configrs()->nama) }} </td>
            </tr>
          </tbody>
        </table>
        <br>

        <table style="width: 100%;padding-left:25px;">
          <tbody style="font-size: 8pt; ">
            {{-- <tr>
              <th style="width: 17%">No. RM</th> <td>: {{ isset($reg->pasien->no_rm) ? $reg->pasien->no_rm : '-' }}</td>
              <th>Tgl Lahir / Kelamin</th> <td>: {{ isset($reg->pasien->tgllahir) ? tgl_indo($reg->pasien->tgllahir) : '-' }} / {{ isset($reg->pasien->kelamin) ? $reg->pasien->kelamin : '-' }}</td>
            </tr>
            <tr>
              <th>Nama Pasien</th> <td>: {{ isset($reg->pasien->nama) ? $reg->pasien->nama : '-' }}</td>
              <th style="width: 17%">Dokter Pengirim</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->dokter_id) }} </td>
              <th>Keterangan Klinis</th> <td>: {{ @$reg->keterangan_klinis}}</td>
            </tr>
            <tr>
              <th>Alamat</th> <td>: {{ isset($reg->pasien->alamat) ? $reg->pasien->alamat : '-' }}</td>
              <th style="width: 17%">Dokter Pemeriksa</th> <td style="font-size: 11px;">: {{ baca_dokter(@$hasilLabPA->penanggungjawab) }}</td>
            </tr>
            <tr>
              <th>Di Terima Tanggal</th> 
              <td>:
                {{ date('d-M-Y',  strtotime(@$hasilLabPA->tgl_bahanditerima))}} {{ @$hasilLabPA->jam }}
              </td>
            </tr>
            <tr>
              <th>Di Jawab Tanggal</th>
              <td>:
                {{ date('d-M-Y',  strtotime(@$hasilLabPA->tgl_hasilselesai))}} {{ @$hasilLabPA->jamkeluar }}
              </td>
            </tr> --}}
            <tr>
              <th>No Sediaan</th>
              <td>: {{ @$hasilLabPA->no_sediaan ?? '-' }}</td>
              <th>Di Terima Tanggal</th>
              <td>:
                {{ date('d-M-Y',  strtotime(@$hasilLabPA->tgl_pemeriksaan))}} {{ @$hasilLabPA->jam }}
              </td>
            </tr>
            <tr>
              <th>Nama Pasien</th> <td>: {{ @$reg->pasien->nama }}</td>
              <th>Di Jawab Tanggal</th>
              <td>:
                {{ date('d-M-Y',  strtotime(@$hasilLabPA->tgl_hasilselesai))}} {{ @$hasilLabPA->jamkeluar }}
              </td>
            </tr>
            <tr>
              <th style="width: 17%">No. RM</th> <td>: {{ @$reg->pasien->no_rm }}</td>
              <th>Keterangan Klinis</th> <td>: {{ @$reg->keterangan_klinis}}</td>
            </tr>
            <tr>
              <th>Usia</th> <td>: {{ !empty($reg->pasien->tgllahir) ? hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }}</td>
            </tr>
          </tbody>
        </table>
        <br>
        {{-- <p style="padding-left:20px;">
          =======================================================================================
        </p> --}}
        <table style="width:100%; padding-left:30px;">
          {{-- <thead> --}}
            {{-- <tr> --}}
              {{-- <th class="">PEMERIKSAAN</th> --}}
              {{-- <th class="text-center" style="padding-right:50px;">HASIL</th> --}}
              {{-- <th class="text-center">PENGAMBILAN</th> --}}
              {{-- <th class="text-center" style="padding-right:50px;">STANDART</th> --}}
              {{-- <th class="text-center" style="padding-right:50px;">SATUAN</th> --}}
            {{-- </tr> --}}
          {{-- </thead> --}}
    
          <tbody>
            @php $kat = 0; @endphp
            @foreach($hasilLabsPA as $labs)
              @php $rincian = App\RincianHasillab::where(['hasillab_id' => $labs->id])->get(); @endphp
              @foreach ($rincian as $item)
                @if($item->labkategori_id != $kat)
                <tr class="_border">
                  <td style="padding-top:10px;"> <b> {{ App\Labkategori::where('id',$item->labkategori_id)->first()->nama }}</b></td>
                </tr>
                @else
                  =
                @endif

                @if($kat != 0 && $item->labkategori_id != $kat)
                <tr class="">
                <td style="font-weight: bold;"><br/>{{ $item->laboratoria->nama }}</td>
                @else
                <tr>
                  <td style="font-weight: bold;"><br/>{{ $item->laboratoria->nama }}</td>
                @endif
                </tr>
                <tr>
                  <td style=" word-wrap: break-word;">{{ $item->hasil }}</td>
                </tr>
                {{-- <td class="text-center" style="padding-right:50px;">{{ $item->laboratoria->nilairujukanbawah }} - {{ $item->laboratoria->nilairujukanatas }}</td>
                <td class="text-center" style="padding-right:50px;">{{ $item->laboratoria->satuan }}</td> --}}
                  @php $kat = $item->labkategori_id; @endphp
              @endforeach
            @endforeach
          </tbody>
        </table>

        <br>
        <br>
        <b style="padding-left:35px; margin-top: 50px">Kesimpulan :</b> 
        <div style="padding-left:35px;">
          @if($hasilLabPA->pesan ){!! $hasilLabPA->pesan !!} @else <i> Tidak Ada Kesimpulan </i> @endif
        </div>
        <br>
        <div style="padding-left:35px;">
          <b>Saran :</b>
          @if($hasilLabPA->saran ){!! $hasilLabPA->saran !!} @else <i> Tidak Ada Saran </i> @endif
        </div>
        <br>
        <div style="padding-left:35px;">
          <b>Catatan :</b> 
          @if($reg->catatan ){!! $reg->catatan !!} @else <i> Tidak Ada Catatan </i> @endif
        </div>
        <br>
        
        {{-- <p style="padding-left:20px;">
          =======================================================================================
        </p> --}}
        <br> <br>
  
        {{-- <p style="padding-left:0px;">
          <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i>
        </p> --}}
         
        <br>
        <br>
    
        <table style="width:100%; ">
          <tr>
            <td colspan="4" scope="row" style="width:200px;padding-left:20px;"><b> </b><i> </i></td>
            <td style="width:140px;text-align:center;"></td>
            <td style="width:140px;text-align:center;width:170px;"></td>
            <td style="width:140px;text-align:center;"></td>
            <td style="width:140px;text-align:center;">
              {{-- {{ config('app.kota') }}, {{ date('d-M-Y',  strtotime(@$hasilLabPA->tgl_hasilselesai))}} --}}
              Terimakasih atas kepercayaan TS
            </td>
          </tr>

          <tr>
              <td colspan="4" scope="row" style="width:170px;font-size: 7px;"> </td>
              <td></td>
              <td style="width:140px;text-align:center;width:170px;"></td>
              <td></td>
              <td style="text-align:center;">
                @php
                  libxml_use_internal_errors(true);
                  $pegawai = \Modules\Pegawai\Entities\Pegawai::find(@$hasilLabPA->penanggungjawab);
                  $base64 = null;
                  if ($pegawai) {
                    @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($pegawai->nama . ' , ' . $pegawai->sip . ' , ' . date('d-M-Y',  strtotime(@$hasilLabPA->tgl_hasilselesai)) . @$hasilLabPA->jamkeluar));
                  }
                @endphp
                @if ($base64)
                  <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
              </td>
          </tr>
          <tr>
              <td colspan="4" scope="row"></td>
              <td></td>
              <td></td>
              <td></td>
              <td style="width:80px;text-align:center;">({{ @$pegawai->nama }})</td>
          </tr>
        </table>
      </div>
    @endif
    {{-- END Hasil Lab PA--}}
    
    {{-- DD DISINI AMAN E--}}

    {{-- Hasil Radiologi --}}
    @if(count($radiologi) > 0)
      @foreach ($radiologi as $rad)
        @php
          if(!empty($rad->folio_id)){
                $count = 1;
                $tindakan = \Modules\Registrasi\Entities\Folio::where('id', $rad->folio_id)->first();	
            }else{
                $count = 2;
                $tindakan = \Modules\Registrasi\Entities\Folio::where('registrasi_id', $rad->registrasi_id)->where('poli_tipe', 'R')->get();
            }
        @endphp
        <div style="page-break-before: always;">
          <table style="width: 100%; margin-left: 10px;">
            <tr>
              <td style="width:30%;">
                <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 80px; float: left;">
              </td>
            </tr>
          </table>
      
          <div class="row">
            <div>
                <h4 style="text-align: center; font-family: Times New Roman, serif !important;font-size: 15pt;">{{config('app.nama_rs')}}</h4>
                <h5 style="text-align: center; font-family: Times New Roman, serif !important;font-size: 12pt;">INSTALASI RADIOLOGI</h5>
                <h6 style="text-align: center;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
                <hr>
                <h5 style="text-align: center; font-family: Times New Roman, serif !important;font-size: 12pt;">HASIL PEMERIKSAAN RADIOLOGI</h5>
              <br>
            </div>
            <table style="width: 100%;font-family: Times New Roman, serif !important;font-size: 15px;" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td> Nomer RM</td>
                  <td>:</td>
                  <td> {{ @$rad->no_rm }} </td>
    
                  @if (@$rad->pengirim)
                  <td> Kepada Yth.</td>
                  <td>:</td>
                  <td>  {{  baca_dokter(@$rad->pengirim)}} </td>
                      
                  @endif
                </tr>
                <tr>
                  <td> Nama Pasien</td>
                  <td>:</td>
                  <td> {{ @$rad->nama }} </td>
                </tr>
                <tr>
                  <td> Alamat </td>
                  <td>:</td>
                  <td> {{ @$rad->alamat }} </td>
                  <td> Jenis </td>
                  <td>:</td>
                  <td>
                    @if ($count == 2)
                      @foreach (@$tindakan as $item)
                        - {{ @$item->namatarif }}<br/>
                      @endforeach
                    @else
                      {{@$tindakan->namatarif}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Umur </td>
                  <td>:</td>
                  <td> {{ !empty($rad->tgllahir) ? @hitung_umur_by_tanggal($rad->tgllahir, $rad->tanggal_ekspertise) : NULL }} </td>
                </tr>
              </tbody>
            </table>
            <hr>
            <h5 style="margin-bottom: 0; margin-top: 10px;font-family: Times New Roman, serif !important">Ekpertise :</h5>
            <div style=" padding: 0px 5px; font-family: Times New Roman, serif !important;font-size: 15px; margin: 0px 5px;">
              <span>Kepada Yth TS</span><br><br>
              {!! nl2br(e(@$rad->ekspertise)) !!}
            </div>
  
  
  
  
            <div class="text-center" style="padding: 5px; float:right;">
              <br>
              <br>
              <br>
              <br>
              <table>
                <tr>
                  
                  <td style="text-align: center;"><u>Bandung,  {{ @$rad->tanggal_ekspertise ? \Carbon\Carbon::parse($rad->tanggal_ekspertise)->format('d M Y') : '-' }}</u></td>
                </tr>
                <tr>
                  <td style="text-align: center;"> Dokter Yang Memeriksa</td>
                </tr>
                <tr>
                  <td style="text-align: center;">
                    @php
                      $pegawai = \Modules\Pegawai\Entities\Pegawai::find(@$rad->dokter_id);
                      $base64 = null;
                      if ($pegawai) {
                        @$base64 = base64_encode(
                          \QrCode::format('png')
                            ->size(75)
                            ->merge('/public/images/' . configrs()->logo, .3)
                            ->errorCorrection('H')
                            ->generate(
                              $pegawai->nama . ' , ' . $pegawai->sip . ' , ' . date('d-m-Y H:i' ,strtotime(@$rad->tanggal_ekspertise))
                            )
                        );
                      }
                    @endphp
                    <br>
                    <br>
                    @if ($base64)
                      <img src="data:image/png;base64, {!! $base64 !!} ">
                    @endif
                    <br>
                    <br>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">
                    <u>{{ @$pegawai ? @$pegawai->nama : Auth::user()->name }}</u><br>
                    SIP {{ !empty($pegawai) ? $pegawai->sip : '' }}
                  </td>
                </tr>
              </table>
            </div>
            <div class="text-left" style="padding: 5px; float:left;">
              <br><br>
              Terima kasih atas kepercayaan Rekan Sejawat
              <br>
              <br>
              <table>
                @php
                    @$folioRad = Modules\Registrasi\Entities\Folio::find($rad->folio_id);
                @endphp
                <tr>
                  <td>Tanggal Pemeriksaan</td>
                  {{-- <td>:  
                    {{ @$folioRad->waktu_periksa ? @date('d-m-Y H:i:s', strtotime(@$folioRad->waktu_periksa)) : @$folioRad->created_at->format('d-m-Y H:i:s') }}
                  </td> --}}
                  <td>:
                    {{ !empty($folioRad) && !empty($folioRad->waktu_periksa)
                        ? date('d-m-Y H:i:s', strtotime($folioRad->waktu_periksa))
                        : (!empty($folioRad) && !empty($folioRad->created_at)
                            ? \Carbon\Carbon::parse($folioRad->created_at)->format('d-m-Y H:i:s')
                            : '-') }}
                  </td>
                </tr>
                <tr>
                  <td>Tanggal Hasil</td>
                  <td>: {{ @$rad->tanggal_ekspertise ? \Carbon\Carbon::parse($rad->tanggal_ekspertise)->format('d M Y H:i:s') : '-' }}</td>
                </tr>
              </table>
              <br>
              <br>
              <br>
              <br>
            </div>
          </div>
        </div>
      @endforeach
    @endif
    {{-- END Hasil Radiologi --}}

    {{-- Treadmill --}}
    @if (count(@$treadmill) > 0)  
      @foreach ($treadmill as $t)
        @php
          $dataTreadmill = json_decode($t->keterangan, true);
        @endphp
        <div style="page-break-before: always;">
          <table>
            <tr>
              <th colspan="1">
                <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
              </th>
              <th colspan="5" style="font-size: 20pt;">
                <b>HASIL EKSPERTISE TREADMILL</b>
              </th>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Nama Pasien</b><br>
                    {{ $reg->pasien->nama }}
                </td>
                <td colspan="2">
                    <b>Tgl. Lahir</b><br>
                    {{ !empty($reg->pasien->tgllahir) ? @hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }}
                </td>
                <td>
                    <b>Jenis Kelamin</b><br>
                    {{ $reg->pasien->kelamin }}
                </td>
                <td>
                    <b>No MR.</b><br>
                    {{ $reg->pasien->no_rm }}
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <b>Alamat Lengkap</b><br>
                    {{ $reg->pasien->alamat }}
                </td>
                <td>
                    <b>No Telp</b><br>
                    {{ $reg->pasien->nohp }}
                </td>
            </tr>
            <tr>
              <td>
                  <b>Angina</b>
              </td>
              <td colspan="2">
                {{@$dataTreadmill['Angina']}}
              </td>
              <td>
                  <b>HISTORY OF MI</b>
              </td>
              <td colspan="2">
                {{@$dataTreadmill['HISTORYOFMI']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>PRIOR OF CABG</b>
              </td>
              <td colspan="2">
                {{@$dataTreadmill['PRIOROFCABG']}}
              </td>
              <td>
                  <b>PRIOR CATH</b>
              </td>
              <td colspan="2">
                {{@$dataTreadmill['PRIORCATH']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>DIABETIC</b>
              </td>
              <td colspan="2">
                {{@$dataTreadmill['DIABETIC']}}
              </td>
              <td>
                  <b>SMOKING</b>
              </td>
              <td colspan="2">
                {{@$dataTreadmill['SMOKING']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>FAMILY HISTORY</b>
              </td>
              <td colspan="5">
                {{@$dataTreadmill['FAMILYHISTORY']}}
              </td> 
            </tr>
          
            
            <tr>
              <td>
                  <b>INDICATIONS</b>
              </td>
              <td colspan="5">
                {{@$dataTreadmill['INDICATIONS']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>MEDICATIONS</b>
              </td>
              <td colspan="5">
                {{@$dataTreadmill['MEDICATIONS']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>REFERRING PHYSICIAN</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['REFERRINGPHYSICIAN']}}
              </td>
              <td>
                  <b>LOCATION</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['LOCATION']}}
              </td>
              <td>
                  <b>PROCEDURE TYPE</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['PROCEDURETYPE']}}
              </td>
            </tr>
          
            <tr>
              <td>
                  <b>ATTENDING PHY</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['ATTENDINGPHY']}}
              </td>
              <td>
                  <b>TARGET HR:(85%)</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['TARGETHR']}}
              </td>
              <td>
                  <b>REASON FOR END</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['REASONFOR']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>TECHNICIAN</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['TECHNICIAN']}}
              </td>
              <td>
                  <b>MAX HR : (% MPHR)</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['MAXHR']}}
              </td>
              <td>
                  <b>SYMTOMS</b>
              </td>
              <td colspan="">
                {{@$dataTreadmill['SYMTOMS']}}
              </td>
            </tr>
    
            <tr>
              <td colspan="3" style="vertical-align: top;">
                  <b>DIAGNOSIS</b><br/>
                  {{@$dataTreadmill['DIAGNOSIS']}}
              </td>
              <td colspan="3" style="vertical-align: top;">
                  <b>NOTES </b><br/>
                  {{@$dataTreadmill['NOTES']}}
              </td>
            </tr>
            <tr>
              <td>
                  <b>CONCLUSIONS</b>
              </td>
              <td colspan="5">
                {{@$dataTreadmill['CONCLUSIONS']}}
              </td>
            </tr>
          
          </table>
          <br>
          <table style="border: 0px;margin-top: 3rem;">
            <tr style="border: 0px;">
              <td colspan="3" style="text-align: center; border: 0px;">
      
              </td>
              <td colspan="3" style="text-align: center; border: 0px;">
                @if (str_contains(baca_user(@$t->user_id),'dr.'))
                  
                    Dokter
                @else
                    Perawat
                @endif
              </td>
            </tr>
            <tr style="border: 0px; padding: 0;">
              <td colspan="3" style="text-align: center; border: 0px;">
              </td>
              <td colspan="3" style="text-align: center; border: 0px;">
                  @php
                    @$tgl_treadmill = App\EmrInapPerencanaan::where('registrasi_id', $reg->id)->where('type', 'treadmill')->orderBy('id', 'DESC')->first();
                    @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' , ' . Auth::user()->pegawai->sip . ' , ' . @$tgl_treadmill->created_at))
                  @endphp
                  <img src="data:image/png;base64, {!! $base64 !!} ">
              </td>
            </tr>
            <tr style="border: 0px;">
              <td colspan="3" style="text-align: center; border: 0px;">
      
              </td>
              <td colspan="3" style="text-align: center; border: 0px;">
                {{baca_user(@$t->user_id)}}
              </td>
            </tr>
          </table>
        </div>
      @endforeach
    @endif
    {{-- END Treadmill --}}
    
    {{-- Echocardiograms --}}
    @if (count(@$echocardiogram) > 0)
      @foreach ($echocardiogram as $d)
        <table style="width: 100%; margin-left: 10px;">
          <tr>
            <td style="width:30%;">
              <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 80px; float: left;">
            </td>
          </tr>
        </table>

        <div class="row">
          <div class="col-sm-12 text-center">
            <h4>{{config('app.nama_rs')}}</h4>
            <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
            <hr>
            <h5><u>ECHOCARDIOGRAPHY</u><br/>HASIL PEMERIKSAAN</h5>
            <br>
          </div>
          <table style="width: 100%;">
            <tbody class="table table-borderless">
              <tr>
                <td> Tanggal Pemeriksaan </td>
                <td>:</td>
                <td>  {{  @$d->created_at->format('d-m-Y') }} </td>
              </tr>
              <tr>
                <td> Nama </td>
                <td>:</td>
                <td> {{ $d->nama }} </td>

                <td> Jenis Klamin / Umur</td>
                <td>:</td>
                <td> {{ $d->kelamin }} / {{ !empty($reg->pasien->tgllahir) ?@hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }}</td>
              </tr>
              <tr>
                <td> Cara Bayar </td>
                <td>:</td>
                <td> {{ baca_carabayar($d->bayar) }} </td>

                <td> Alamat </td>
                <td>:</td>
                <td> {{ $d->alamat }} </td>
              </tr>
              <tr>
                <td> Klinik / Ruangan </td>
                <td>:</td>
                <td> 
                @if (substr($d->status_reg, 0,1) == 'I' )
                    @php
                        $irna = \App\Rawatinap::where('registrasi_id', $d->registrasi_id)->first();
                    @endphp
                    {{ $irna ? baca_kamar($irna->kamar_id) : null}}
                @else
                    {{ baca_poli($d->poli_id) }}
                @endif
                </td>
                <td> No. Rm </td>
                <td>:</td>
                <td> {{ $d->no_rm }} </td>
              </tr>
            </tbody>
          </table>
          <hr>
          <table style="width: 100%;" border="1" cellspacing="0" cellpadding="1">
            <thead>
              <tr>
                <th class="text-center">Pengukuran</th>
                <th class="text-center">Hasil</th>
                <th class="text-center">Normal</th>
                <th class="text-center">Pengukuran</th>
                <th class="text-center">Hasil</th>
                <th class="text-center">Normal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Aorta</td>
                <td>{{@$d->katup_katup_jantung_aorta}}</td>
                <td>20-37 mm</td>
                <td>LVEDD</td>
                <td>{{@$d->lvedd}}</td>
                <td>35-52 mm</td>
              </tr>
              <tr>
                <td>Atrium Kiri</td>
                <td>{{@$d->atrium_kiri}}</td>
                <td>15-40mm</td>
                <td>LVESD</td>
                <td>{{@$d->lvesd}}</td>
                <td>26-36mm</td>
              </tr>
              <tr>
                <td>LAVI</td>
                <td>{{@$d->global}}</td>
                <td></td>
                <td>IVSd</td>
                <td>{{@$d->ivsd}}</td>
                <td>7-11mm</td>
              </tr>
              <tr>
                <td>Ventrikel Kanan</td>
                <td>{{@$d->ventrikel_kanan}}</td>
                <td> &lt; 42mm </td>
                <td>IVSs</td>
                <td>{{@$d->ivss}}</td>
                <td></td>
              </tr>
              <tr>
                <td>Ejeksi Fraksi</td>
                <td>{{@$d->ejeksi_fraksi}}</td>
                <td> 53-77% </td>
                <td>PWd</td>
                <td>{{@$d->pwd}}</td>
                <td>7-11mm</td>
              </tr>
              <tr>
                <td>E/A</td>
                <td>{{@$d->ea}}</td>
                <td> </td>
                <td>PWs</td>
                <td>{{@$d->pws}}</td>
                <td></td>
              </tr>
              <tr>
                <td>E/e</td>
                <td>{{@$d->ee}}</td>
                <td> </td>
                <td>LVMI</td>
                <td>{{@$d->lvmi}}</td>
                <td></td>
              </tr>
              <tr>
                <td>TAPSE</td>
                <td>{{@$d->ee}}</td>
                <td> &gt; 17mm</td>
                <td>RWT</td>
                <td>{{@$d->rwt}}</td>
                <td></td>
              </tr>
            </tbody>
          </table>

          <table style="width: 100%">
            <tr>
              <td><b>Kesimpulan</b> : {!!@$d->kesimpulan!!}</td>
            </tr>
            <tr>
              <td><b>Catatan Dokter</b> : {!!@$d->catatan_dokter!!}</td>
            </tr>
          </table>
          <div class="text-center" style="padding: 5px; float:right;">
            Pemeriksa
            <br>
            <br>
            <br>
            @php
              @$tgl_echocardiogram = App\echocardiogram::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
              @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' , ' . Auth::user()->pegawai->sip . ' , ' . @$tgl_echocardiogram->created_at))
            @endphp
            <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
            <u>{{ @baca_user(@$d->user_id) }}</u><br>
          </div>
        </div>
      @endforeach
    @endif
    {{-- END Echocardiograms --}}

    {{-- Surat Kontrol --}}
    @if($suratKontrol)
      <div style="page-break-before: always;">
        <div class="row">
          <div> 
            <h4 style="text-align: center;"><u><b>SURAT KONTROL</b></u></h4>
            <br>
        </div>
        <div class="row">
          <div class="col-sm-12 text-left"> 
            <p> 
              Bersama ini kami kirimkan kembali penderita :
            </p>
            <br>
          </div>
          <table style="width: 100%;">
            <tbody class="table table-borderless">
              <tr> 
                  <td> <b>No. Rencana Kontrol</b> </td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->no_surat_kontrol }} </td>
              </tr>
              <tr> 
                  <td> <b>No. SEP</b> </td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->no_sep }} </td>
              </tr>
              <tr>
                  <td> <b>Tgl.Rencana Kontrol</b> </td>
                  <td>:</td>
                  <td> {{ @tgl_indo(@$suratKontrol->tgl_rencana_kontrol) }} </td>
              </tr>
              <tr>
                  <td> Nama </td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->registrasi->pasien->nama}} </td>
              </tr>
              <tr>
                  <td> Jenis Klamin / Umur</td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->registrasi->pasien->kelamin }} / {{ !empty($reg->pasien->tgllahir) ? @hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }}</td>
              </tr>
              <tr>
                  <td>Poli Tujuan</td>
                  <td>:</td>
                  <td>{{ baca_poli(@$suratKontrol->poli_id) }}</td>
              </tr>
              <tr>
                  <td> No. RM </td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->registrasi->pasien->no_rm }} </td>
              </tr>
              <tr>
                  <td> No. BPJS </td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->registrasi->pasien->no_jkn }} </td>
              </tr>
              <tr>
                  <td> Alamat </td>
                  <td>:</td>
                  <td> {{ @$suratKontrol->registrasi->pasien->alamat }} </td>
              </tr>
              <tr>
                  <td> Pasien masuk tanggal </td>
                  <td>:</td>
                  <td> {{ @tanggal(@$suratKontrol->registrasi->created_at) }} </td>
              </tr>
              <tr>
                  <td> Diagnosa </td>
                  <td>:</td>
                  <td> {!! @$suratKontrol->diagnosa_awal; !!} </td>
              </tr>
            </tbody>
          </table>
          <br>
          <br>
          <div style="padding: 5px; float:right;">
            {{--{{configrs()->kota}}, {{ date('d-m-Y') }}<br>--}}
              Mengetahui DPJP <br>
              <br><br>
              @php
                $pegawai = \Modules\Pegawai\Entities\Pegawai::find(@$suratKontrol->dokter_id);
                $base64 = null;
                if ($pegawai) {
                  @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($pegawai->nama . ' , ' . $pegawai->sip . ' , ' . @$suratKontrol->created_at));
                }
              @endphp
              @if ($base64)
                <img src="data:image/png;base64, {!! $base64 !!} ">
              @endif
              <br>
              {{ baca_dokter(@$suratKontrol->dokter_id) }}
            <hr>
          </div>
        </div>
      </div>
    @endif
    {{-- END Surat Kontrol --}}
    
    
    @if ($layanan_rehab)
    <div style="page-break-before: always;">
    @if (isset($proses_tte))
    <div class="footer">
      Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto
      Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau
      hasil cetakannya merupakan alat bukti hukum yang sah
    </div>
    @endif
    
    @php
    // $obat = 0;
    // $ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
    @endphp
    <table style="width: 100%;">
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}" style="width: 60px;">
          {{-- <img src="{{ asset('images/'.configrs()->logo) }}" style="width: 60px;"> --}}
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br />
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br />
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br />
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          {{-- <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}
    
        </td>
      </tr>
    </table>
    <hr>
    <br>
    
    <table style="width: 100%">
      <tr>
        <td style="text-align: center">
          <b>Lembar Formulir Rawat Jalan</b>
        </td>
      </tr>
      <tr>
        <td style="text-align: center">
          <b>Layanan Kedokteran Fisik dan Rehabilitasi</b>
        </td>
      </tr>
    </table>
    <br>
    
    <table style="width: 100%; border: 1px solid">
      <tr>
        <td colspan="3">
          <b>Diisi oleh Pasien / Peserta</b>
        </td>
      </tr>
      <tr>
        <td style="width: 25%">NO. RM</td>
        <td colspan="2">: {{ @$reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td style="width: 25%">Nama Pasien</td>
        <td colspan="2">: {{ @$reg->pasien->nama }}</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td colspan="2">: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td colspan="2">: {{ @$reg->pasien->alamat }}</td>
      </tr>
      <tr>
        <td>Telp / HP</td>
        <td colspan="2">: {{$reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp}}</td>
      </tr>
    
    </table>
    <br>
    
    <table style="width: 100%; border: 1px solid;">
      @php
          $created_at = \Carbon\Carbon::parse($reg->created_at);
      @endphp
      <tr>
        <td colspan="3">
          <b>Diisi oleh Dokter SpKFR</b>
        </td>
      </tr>
      <tr>
        <td style="width: 30%">Tanggal Pelayanan</td>
        <td>: {{ @\Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="width: 30%">Anamnesa</td>
        <td colspan="2">: {{ @json_decode(@$layanan_rehab->fisik, true)['anamnesa'] }}</td>
      </tr>
      <tr>
        <td style="width: 30%">Pemeriksaan Fisik dan Uji Fungsi</td>
        <td colspan="2">: {{ @json_decode(@$layanan_rehab->fisik, true)['pemeriksaan_fisik'] }}</td>
      </tr>
      <tr>
        <td style="width: 30%">Diagnosa Medis (ICD-10)</td>
        <td colspan="2">
          : {{ @json_decode(@$layanan_rehab->fisik, true)['icd10'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%">Pemeriksaan Penunjang</td>
        <td colspan="2">: {{ @json_decode(@$layanan_rehab->fisik, true)['pemeriksaan_penunjang'] }}</td>
      </tr>
      <tr>
        <td style="width: 30%">Tata Laksana KFR (ICD-9)</td>
        <td colspan="2">
            @if (isset($created_at) && $created_at->year == 2024 && in_array($created_at->month, [8, 9, 10, 11, 12]))
            : {{ @json_decode(@$layanan_rehab->fisik, true)['icd9'] }}
                Goal: VAS 2, ROM meningkat.
                Edukasi: prog terapi, home exc.
            @else
            : {{ @json_decode(@$layanan_rehab->fisik, true)['icd9'] }}
            @endif
        </td>
      </tr>
      <tr>
        <td style="width: 30%">Anjuran</td>
        {{-- <td colspan="2">: {{ @json_decode(@$layanan_rehab->fisik, true)['anjuran'] }}</td> --}}
        <td colspan="2">: 2x /minggu</td>
      </tr>
      <tr>
        <td style="width: 30%">Evaluasi</td>
        @if ($created_at->year == 2024 && $created_at->month <= 11){
          <td colspan="2">: 1 bulan</td>
        }
        @else
          <td colspan="2">: 2 minggu</td>
        @endif
        {{-- <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['evaluasi'] }}</td> --}}
      </tr>
      <tr>
        <td style="width: 30%">Suspek Penyakit Akibat Kerja</td>
        <td colspan="2">
          : {{ @json_decode(@$layanan_rehab->fisik, true)['penyakitAkibatkerja']['pilihan'] }}. {{ @json_decode(@$layanan_rehab->fisik,
          true)['penyakitAkibatkerja']['keterangan'] }}
        </td>
      </tr>
    
    </table>
    <br>
    <table style="width: 100%">
      @php
          $sign_rehab = App\TandaTangan::where('registrasi_id', $reg->id)
                ->where('jenis_dokumen', 'layanan-rehab')
                ->orderByDesc('id')
                ->first();
      @endphp
      <tr>
        <td style="width: 50%;"></td>
        <td style="text-align: center;">Soreang, {{@Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y')}}</td>
      </tr>
      <tr>
        <td style="text-align: center;">
          {{-- @if (@$ttd) --}}
          Tanda Tangan Pasien<br><br><br>
          {{-- <img style="width:50px !important;"
            src="data:image/png;base64,{{DNS2D::getBarcodePNG(@$reg->pasien->nama.' - '.@$reg->pasien->no_rm, 'QRCODE', 4,4)}}"
            alt="barcode" /> --}}
          @if ($sign_rehab && !empty($sign_rehab->tanda_tangan))
              <img src="{{ url(path_ttd().'/images/upload/ttd/' . @$sign_rehab->tanda_tangan) }}" alt="ttd" width="200" height="100">
          @elseif (ttdPasienBpjs($reg->created_at))
              @if (!empty($ttd_pasien->tanda_tangan))
                  <img src="{{ url(path_ttd().'/images/upload/ttd/' . @$ttd_pasien->tanda_tangan) }}" alt="ttd" width="200" height="100">
              @elseif (!empty($ttd->tanda_tangan))
                  <img src="{{ url(path_ttd().'/images/upload/ttd/' . @$ttd->tanda_tangan) }}" alt="ttd" width="200" height="100">
              @endif
          @endif
          <br>
          {{@$reg->pasien->nama}}
        </td>
        <td style="text-align: center;">
          Cap dan TTD Dokter<br> 
          {{-- @if (isset($proses_tte))
          <br><br><br>
          #
          <br><br><br><br>
          @elseif (isset($tte_nonaktif))
          <br><br>
          @php
          $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo,
          .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
          @endphp
          <img src="data:image/png;base64, {!! $base64 !!} ">
          <br>
          @else
          <br><br><br>
          <br><br><br><br>
          @endif --}}
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
            <img src="data:image/png;base64, {!! $base64 !!} "> <br>
    
    
          {{-- @if (isset($proses_tte))
          {{Auth::user()->pegawai->nama}}
          @else
          ............................
          @endif --}}
          {{ @$dokter->nama }}
        </td>
      </tr>
    </table>
    </div>
    @endif

    {{-- Hasil Penunjang --}}
    @if ($hasil_penunjang)
    @php
      $penunjang = $hasil_penunjang;
    @endphp
    <div style="page-break-before: always;">
    </div>
      <table border=0 style="width: 100%;"> 
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
            <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
      <hr>
      <div class="col-md-12">
        <table style="width:100%">
          <tr>
            <td style="width:100px;">Nomor RM</td>
            <td>: {{@$reg->pasien->no_rm}}</td>
          </tr>
          
          <tr>
            <td>Nama Pasien</td>
            <td>: {{@$reg->pasien->nama}}</td>
          </tr>
    
          <tr>
            <td>Umur</td>
            <td>: {{ !empty($reg->pasien->tgllahir) ? hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : NULL }}</td>
          </tr>
    
          <tr>
            <td>Alamat</td>
            <td>: {{@$reg->pasien->alamat}}</td>
          </tr>
    
          <tr>
            <td colspan="2">Hasil Pemeriksaan</td>
          </tr>
          <tr>
            <td colspan="2">
                @php
                    $hasilPemeriksaan = '';
                    if (isset($penunjang)) {
                        if (!is_null($penunjang->hasil_echo)) {
                            $hasilPemeriksaan .= "Echo:\n{$penunjang->hasil_echo}\n\n";
                        }
                        if (!is_null($penunjang->hasil_ekg)) {
                            $hasilPemeriksaan .= "EKG:\n{$penunjang->hasil_ekg}\n\n";
                        }
                        if (!is_null($penunjang->hasil_eeg)) {
                            $hasilPemeriksaan .= "EEG:\n{$penunjang->hasil_eeg}\n\n";
                        }
                        if (!is_null($penunjang->hasil_usg)) {
                            $hasilPemeriksaan .= "USG Kandungan:\n{$penunjang->hasil_usg}\n\n";
                        }
                        if (!is_null($penunjang->hasil_ctg)) {
                            $hasilPemeriksaan .= "CTG:\n{$penunjang->hasil_ctg}\n\n";
                        }
                        if (!is_null($penunjang->hasil_spirometri)) {
                            $hasilPemeriksaan .= "Spirometri:\n{$penunjang->hasil_spirometri}\n\n";
                        }
                        if (!is_null($penunjang->hasil_lainnya)) {
                            $hasilPemeriksaan .= "Lainnya:\n{$penunjang->hasil_lainnya}\n\n";
                        }
                    }
                    $hasilPemeriksaan = trim($hasilPemeriksaan);
                @endphp
                <textarea name="hasil_pemeriksaan" rows="50" style="height: 500px; width: 100%;">{{ $hasilPemeriksaan }}</textarea>
            </td>                
          </tr>
        </table>
        
        <table style="width:100%;">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%;text-align:center">
                  Soreang, {{date('d-m-Y', strtotime(@$penunjang->created_at))}}<br>
                  Dokter
                </td>
            </tr>
            <tr style="height: 80px">
                <td style="width: 50%;vertical-align: bottom;text-align:center"></td>
                <td style="width: 50%; vertical-align: bottom;text-align:center">
                    @php
                        $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                        @$base64 = base64_encode(
                            \QrCode::format('png')
                                ->size(75)
                                ->merge('/public/images/' . configrs()->logo, 0.3)
                                ->errorCorrection('H')
                                ->generate(@$dokter->nama . ' | ' . @$dokter->sip . ' , ' . @$reg->created_at)
                        );
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                </td>
            </tr>
            <tr style="height: 80px">
                <td style="width: 50%;vertical-align: bottom;text-align:center"></td>
                <td style="width: 50%; vertical-align: bottom;text-align:center">{{ @$dokter->nama }}</td>
            </tr>
        </table>
    {{-- END Hasil Penunjang --}}
    @endif
  </body>
</html>

