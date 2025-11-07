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
        font-size: 10pt;
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
  {{-- <body> --}}

    {{-- <table style="width:95%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:95px;">
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
              @$ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
          @endphp
      <table border=0 style="width:95%;font-size:12px;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            {{--<b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>--}}
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
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
              {{hitung_umur(@$reg->pasien->tgllahir)}}
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
              <td>Cara Pulang</td><td>: {{ $reg->pulang ? @baca_carapulang($reg->pulang) :'' }} - {{ $reg->kondisi_akhir_pasien ? @baca_carapulang($reg->kondisi_akhir_pasien) :'' }}</td>
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
          $tindakan_rajal = 0;
          $tindakan_operasi = 0;
      @endphp
    

      {{-- FOLIO RAJAL --}}
      {{-- <tr> 
        <td><span style="text-align:start;font-weight:900">RAJAL</span></td>
      </tr> --}}
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
          <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium RAJAL</span></td>
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
                @if ($item->verif_kasa_user =='tarif_new')
                  <span style="text-align:start;">{{@$item->tarif_baru->kategoritarif->namatarif}} - {{$item->namatarif}}</span><br>
                  @if ($item->tarif_baru->bedah == 'Y')
                    <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                  @elseif($item->tarif_baru->anestesi == 'Y') 
                    <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                  @else
                    <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span> --}}
                  @endif
                @else
                  <span style="text-align:start;">{{@$item->tarif->kategoritarif->namatarif}} - {{$item->namatarif}}</span><br>
                  @if ($item->tarif->bedah == 'Y')
                    <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                  @elseif($item->tarif->anestesi == 'Y') 
                    <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                  @else
                    <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span> --}}
                  @endif
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


            {{-- BIAYA OBAT --}}
            @if (count($detail_obat_gudang_rajal_null) > 0 || count($detail_obat_gudang_rajal) > 0)
            <tr>
              <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT RAJAL</th>
              <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
              <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
              <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
            </tr>
              @foreach ($detail_obat_gudang_rajal_null as $key => $item)
                <tr>
                  <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
                </tr>
                @php
                  $jumlah_per_folio = 0;
                @endphp
                @foreach ($item->obat as $items)
                  <tr>
                    <td>{{$items->masterobat->nama}}</td>
                    {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                    <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td> --}}
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                    <td style="text-align: center;">{{@$items->jumlah}}</td>
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                  </tr>
                  @php
                    $jumlah_per_folio += $items->hargajual;
                  @endphp
                @endforeach
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b><span style="color:grey">Rp.</span><span style="float:right">{{number_format($jumlah_per_folio)}}</b></td>
                  </tr>
              @endforeach
              @foreach ($detail_obat_gudang_rajal as $key => $item)
                <tr>
                  <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
                </tr>
                @php
                  $jumlah_per_folio = 0;
                @endphp
                @foreach ($item->obat as $items)
                <tr>
                  <td>{{$items->masterobat->nama}}</td>
                  {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                  <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                  <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td> --}}
                  <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
               <td style="text-align: center;">{{@$items->jumlah}}</td>
               <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                </tr>
                  @php
                    $jumlah_per_folio += $items->hargajual;
                  @endphp
                @endforeach
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><b><span style="color:grey">Rp.</span><span style="float:right">{{number_format($jumlah_per_folio)}}</b></td>
                </tr>
              @endforeach
            @endif
            @if ($obat_gudang_rajal >0 || $obat_gudang_rajal_null > 0)
             {{-- OBAT RAJAL --}}
              <tr>
                <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat RAJAL</span></td>
                <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($obat_gudang_rajal+$obat_gudang_rajal_null)}}</b></span></td>
              </tr>    
            @endif
            <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
            {{--END OBAT RAJAL--}}
      
      
            
      
      
            {{-- OBAT OPERASI --}}
            
            @if (count($detail_obat_gudang_operasi) > 0) {{-- OPERASI --}}
            <tr>
              <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT OPERASI</th>
              <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
              <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
              <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
            </tr>
              @foreach ($detail_obat_gudang_operasi as $key => $item)
                {{-- @php
                  @$tindakan_rajal += $item->total;
                  @$jml = @floor(@$item->total / @$item->tarif->total);
                @endphp --}}
                <tr>
                 
                  <td colspan="4"><span style="text-align:start;font-weight:900">
                  
                    @php
                    $nama = substr($item->namatarif, 0, 3);
                    if ($item->user_id == 614 || $item->user_id == 613 || $item->user_id == 671 || $item->user_id == 800 || $item->user_id == 801 || $item->user_id == 711) {
                    echo str_replace($nama, "FRO", $item->namatarif);
                    }
                   @endphp
                  
                  </span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
                </tr>
                @php
                  $jumlah_per_folio = 0;
                @endphp
                @foreach ($item->obat as $items)
                <tr>
                  <td>{{$items->masterobat->nama}}</td>
                  {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                  <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                  <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td> --}}
                  <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
               <td style="text-align: center;">{{@$items->jumlah}}</td>
               <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                </tr>
                  @php
                    $jumlah_per_folio += $items->hargajual;
                  @endphp
                @endforeach
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><b><span style="color:grey">Rp.</span><span style="float:right">{{number_format($jumlah_per_folio)}}</b></td>
                </tr>
              @endforeach
            @endif
            @if ($obat_gudang_operasi >0) {{-- OBAT RAJAL --}}
              <tr>
                <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat Operasi</span></td>
                <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($obat_gudang_operasi)}}</b></span></td>
              </tr>    
            @endif
            <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
      














      {{-- BIAYA LABOR --}}
      {{-- <tr><th class="dotTop" colspan="2">LABORATORIUM</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($lab)}}</b></span></td> --}}
      {{-- <tr><th class="dotTop" colspan="2">RADIOLOGI</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($rad)}}</b></span></td> --}}
      <tr>
        <th class="dotTop text-right"colspan="3"><div style="float:right !important;text-align:right !important;">TOTAL BIAYA</div></th>
        <td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_biaya)}}</b></span></td>
      </tr>
      {{-- <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="text-right dotTop">{{number_format($tindakan+$rad)}}</td> --}}
      </table>
          {{-- <p style="text-align:right;"><b> Total Biaya Perawatan: {{ number_format($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_rajal+$jml_rajal_lab+$jml_rajal_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }}</b></p>
          
          <p><i>Terbilang: {{ terbilang($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_rajal+$jml_rajal_lab+$jml_rajal_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }} Rupiah</i></p> --}}
      <br/>
           <table style="width:95%; margin-left:70px;">
            <tr>
              @php
              $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
              @endphp
              <td style="width: 50%;" class="text-center">
                Manager Administrasi
                <br>
                <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{$norah->nama}}
              </td>
              <td style="width: 50%;" class="text-center">
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
