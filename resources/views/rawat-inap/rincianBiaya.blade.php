<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 11px;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
    </style>
  </head>
  <body onload="print()">

    {{-- <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:100px;">
                </th>
                <th class="text-left">
                  <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
                  <p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>

                </th>
              </tr>
            </tbody>
          </table> <br> --}}
          @php
              // $obat = 0;
              $ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
          @endphp
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            {{-- <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/> --}}
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            {{-- <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}
            <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">

          </td>
        </tr>
      </table>
      <hr>  

      {{-- @if (substr(@$reg->status_reg, 0, 1) == 'I') --}}
      <table style="width:100%;margin:auto">
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
                  {{ "Rawat Inap / " }} {{baca_kelompok(@$ranap->kelompokkelas_id)}}
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
              {{hitung_umur(@$reg->pasien->tgllahir)}}
              @else
                {{ "-" }}
              @endif



            </td>
            <td>Penjamin</td><td>: {{@baca_carabayar($reg->bayar)}} {{' - '.@baca_jkn(@$reg->id)}}</td>
            
            
          </tr>
          <tr>
            <td style="width:">No. Telp</td>
            <td>:  {{$reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp}}</td>
            @if ($ranap)
            <td>Tanggal Masuk</td><td>: {{ @date('d-m-Y',strtotime(@$ranap->tgl_masuk))}}</td>
            @endif
          </tr>
          <tr>
            @php
                $emr = App\Emr::where('registrasi_id', $reg->id)
            @endphp
            <td style="width:">Tanggal Lahir</td> <td>: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
          
            <td>Tanggal Keluar</td>
            @if (isset($ranap->tgl_keluar))
                <td>: {{ @date('d-m-Y',strtotime(@$ranap->tgl_keluar))}}</td>
            @else
                <td>: </td>
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
                    {{ "" }}
                  @endif
                </td>
                @endif
          </tr>
          <tr>
            <td>Alamat</td> <td>: {{ @$reg->pasien->alamat }}</td>
            @if (@$ranap)
              <td>Cara Pulang</td><td>: {{ $reg->pulang ? @baca_carapulang($reg->pulang) :'' }} - {{ $reg->kondisi_akhir_pasien ? @baca_carapulang($reg->kondisi_akhir_pasien) :'' }}</td>
            @endif
          </tr>
        </tbody>
      </table>
      {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
      <table style="width:100%; margin-top: 1rem;" cellspacing="1">
        @php
            $obatTotal = 0;
        @endphp

        @if (count($obat) > 0)
          {{-- BIAYA OBAT --}}
          <tr>
            <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA PEMAKAIAN OBAT</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black"></th>
            <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black"></th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
          @foreach ($obat as $o)
            @php
              @$obatTotal += $o->total;
            @endphp
  
            {{-- <tr>
              <td><span style="text-align:start;">{{$o->namatarif}}</span></td>
              <td></td>
              <td class="text-center"></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($o->total)}}</span></td>
            </tr> --}}
          @endforeach

          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Pemakaian Obat</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($obatTotal)}}</b></span></td>
          </tr>
        @endif

      {{-- Space --}}
      <tr>
        <td>
          <div style="height: 10px"></div>
        </td>
      </tr>

      @php
          $tindakan_igd = 0;
          $tindakan_irj_ina = 0;
      @endphp


      {{-- BIAYA TINDAKAN --}}

      @if (count($folio) > 0 || count($folio_null_tipe) > 0)
        <tr style="margin-top: 1rem;">
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA TINDAKAN</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
      @endif

      @if (count($folio) > 0)
        @foreach ($folio as $item)
            @php
              @$tindakan_igd += $item->total;
              // @$jml = @floor(@$item->total / @$item->tarif->total);
              if($item->verif_kasa_user =='tarif_new'){
                @$jml = @floor(@$item->total / @$item->tarif_baru->total);
              }else{
                @$jml = @floor(@$item->total / @$item->tarif->total);
              }
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}
                @if (@$item->tarif->is_show_dokter == 'Y')
                  - {!!'<b>'.baca_dokter($item->dokter_pelaksana).'</b>'!!}
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
      
      @if (count($folio_null_tipe) > 0)
          
        @foreach ($folio_null_tipe as $item)
        @php
            // @$jml = @floor(@$item->total / @$item->tarif->total);
            if($item->verif_kasa_user =='tarif_new'){
              @$jml = @floor(@$item->total / @$item->tarif_baru->total);
            }else{
              @$jml = @floor(@$item->total / @$item->tarif->total);
            }
            @$tindakan_irj_ina += $item->total;
        @endphp
            <tr>
              <td><span style="text-align: start;">{{$item->namatarif}}
                @if (@$item->tarif->is_show_dokter == 'Y')
                  - {!!'<b>'.baca_dokter($item->dokter_pelaksana).'</b>'!!}
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

      @if ($tindakan_igd > 0 || $tindakan_irj_ina >0)
      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Total Tindakan</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($tindakan_igd + $tindakan_irj_ina)}}</b></span></td>
      </tr>
      @endif

      {{-- Space --}}
      <tr>
        <td>
          <div style="height: 10px"></div>
        </td>
      </tr>

      @php
        $labTotal = 0;
      @endphp

    @if (count($lab) > 0)
      {{-- BIAYA LABORATORIUM --}}
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA LABORATORIUM</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black"></th>
        <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black"></th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>

      @foreach ($lab as $l)
        @php
          @$labTotal += $l->total;
        @endphp

        <tr style="display: none;">
          <td><span style="text-align:start;">{{$l->namatarif}}
            @if (@$l->tarif->is_show_dokter == 'Y')
              - {!!'<b>'.baca_dokter($l->dokter_lab).'</b>'!!}
            @endif
            @if (@$l->cyto != null)
            - {!!'<b>Cito</b>'!!}
            @endif
          </span></td>
          <td></td>
          <td class="text-center"></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($l->total)}}</span></td>
        </tr>
      @endforeach

      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Total Laboratorium</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($labTotal)}}</b></span></td>
      </tr>
    @endif

    {{-- Space --}}
    <tr>
      <td>
        <div style="height: 10px"></div>
      </td>
    </tr>

    @php
      $radTotal = 0;
    @endphp

    @if (count($rad) > 0)
      {{-- BIAYA RADIOLOGI --}}
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA RADIOLOGI</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black"></th>
        <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black"></th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>

      @foreach ($rad as $r)
        @php
          @$radTotal += $r->total;
        @endphp

        <tr style="display: none;">
          <td><span style="text-align:start;">{{$r->namatarif}}
            @if (@$r->tarif->is_show_dokter == 'Y')
              - {!!'<b>'.baca_dokter($r->dokter_radiologi).'</b>'!!}
            @endif
            @if (@$r->cyto != null)
            - {!!'<b>Cito</b>'!!}
            @endif
          </span></td>
          <td></td>
          <td class="text-center"></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($r->total)}}</span></td>
        </tr>
      @endforeach

      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Total Radiologi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($radTotal)}}</b></span></td>
      </tr>
    @endif



    {{-- Space --}}
    <tr>
      <td>
        <div style="height: 10px"></div>
      </td>
    </tr>
      <tr><th class="dotTop text-right" colspan="3" style="text-align: end">TOTAL BIAYA</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($tindakan_igd+$tindakan_irj_ina+$radTotal+$labTotal+$obatTotal)}}</span></td>
      {{-- <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="text-right dotTop">{{number_format($tindakan+$rad)}}</td> --}}
      </table>

          {{-- <p style="text-align:right;"><b> Total Biaya Perawatan: {{ number_format($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }}</b></p>
          
          <p><i>Terbilang: {{ terbilang($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }} Rupiah</i></p> --}}

           <table style="width: 100%;">
            <tr>
              @php
              $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
              @endphp
              <td style="width: 50%; text-align: center" class="text-center">
                Manager Administrasi
                <br>
                <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{baca_pegawai(390)}}
              </td>
              <td style="width: 50%; text-align: center;" class="text-center">
                Petugas Administrasi
                {{-- {{ configrs()->kota }}, {{ date('d-m-Y') }} --}}
                <br>
                <img src="{{ asset('/images/'. @Auth::user()->pegawai->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{ Auth::user()->name }}<br>
              </td>
            </tr>
          </table> 

  </body>
</html>
