<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Tindakan Operasi</title>
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
        /* margin-right: 0.1cm; */
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
      <br>
      <hr> 

      {{-- @if (substr(@$reg->status_reg, 0, 1) == 'I') --}}
      <table style="width:100%">
        <tbody>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td style="width:25%">Nama Peserta</td> <td>: {{ @$reg->pasien->nama }}</td>
            <td>Nomor SEP</td><td>: {{ @$reg->no_sep }}</td>
          </tr>
          <tr>
            <td style="width:25%">Nomor Rekam Medis</td> <td>: {{ $reg->pasien->no_rm }}</td>
            <td>Tanggal Masuk</td><td>: {{ @$ranap->tgl_masuk}}</td>
          </tr>
          <tr>
            <td style="width:25%">Umur Tahun</td> 
            <td>: 


              @if (@$reg->pasien->tgllahir != null)
              {{hitung_umur(@$reg->pasien->tgllahir)}}
              @else
                {{ "-" }}
              @endif



            </td>
            <td>Tanggal Keluar</td><td>: {{ @$ranap->tgl_keluar}}</td>
          </tr>
          <tr>
            <td style="width:25%">Umur Hari</td>
            <td>: 
            
            
              @if (@$reg->pasien->tgllahir != null)
              {{hitung_umur(@$reg->pasien->tgllahir)}}
             @else
              {{ "-" }}
             @endif
            
            
            
            </td>
            <td>Jenis Perawatan</td><td>:  
              @if (substr(@$reg->status_reg, 0, 1) == 'J')
                  {{ "Rawat Jalan" }}
              @elseif(substr(@$reg->status_reg, 0, 1) == 'I')   
                  {{ "Rawat Inap" }}
              @elseif(substr(@$reg->status_reg, 0, 1) == 'G')   
                  {{ "Gawat Darurat" }}    
              @elseif(substr(@$reg->status_reg, 0, 1) == null)   
                  {{ "-" }} 
              @endif
           </td>
          </tr>
          <tr>
            @php
                $emr = App\Emr::where('registrasi_id', $reg->id)
            @endphp
            <td style="width:25%">Tanggal Lahir</td> <td>: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
            <td>Cara Pulang</td><td>: {{ @$emr->diagnosis }}</td>
          </tr>
          <tr>

            

            <td style="width:25%">Jenis Kelamin</td> 
                <td>: 

                  @if (@$reg->pasien->kelamin == "L")
                        {{ "Laki-laki" }}
                  @else
                        {{ "Perempuan" }}      
                  @endif

                </td>
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
          </tr>
          <tr>
            <td style="width:25%">Kelas Perawatan</td> <td>: {{ baca_kelas(@$ranap->kelas_id) }}</td>
            <td>Berat Lahir</td><td>:  -</td>
          </tr>
        </tbody>
      </table>
      <hr/>
      <table class='table table-striped table-bordered table-hover table-condensed' id="rincian"
        style="font-size:12px;">
        <thead class="bg-primary">
          <tr>
            <th class="text-center" style="vertical-align: middle;">No</th>
            <th class="text-center" style="vertical-align: middle;">Tindakan</th>
            {{-- <th class="text-center" style="vertical-align: middle;">Jenis Pelayanan</th> --}}
            <th class="text-center" style="vertical-align: middle;">Biaya</th>
            <th class="text-center" style="vertical-align: middle;">Jml</th>
            {{-- <th class="text-center" style="vertical-align: middle;">Total + Cito</th> --}}
            <th class="text-center" style="vertical-align: middle;">Total</th>
            <th class="text-center" style="vertical-align: middle;">Cito</th>
            <th class="text-center" style="vertical-align: middle;">Kamar</th>
            <th class="text-center" style="vertical-align: middle;">Kelas</th>
            <th class="text-center" style="vertical-align: middle;">Dokter Bedah</th>
            <th class="text-center" style="vertical-align: middle;">Dokter Anestesi</th>
            <th class="text-center" style="vertical-align: middle;">Dokter Anak</th>
            {{-- <th class="text-center" style="vertical-align: middle;">Pelaksana</th> --}}
            <th class="text-center" style="vertical-align: middle;">Petugas Entry</th>
            <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
            <th class="text-center" style="vertical-align: middle;">Waktu</th>
          </tr>
        </thead>
        <tbody>
          @if (count($folio->get()) > 0)
          {{-- {{dd("A")}} --}}
            @foreach ($folio->get() as $key=>$item)
            @php
                @$jml = @floor(@$item->total / @$item->tarif->total);
                @$tindakan_igd += $item->total;
            @endphp
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$item->tarif->kategoritarif->namatarif}}-{{$item->namatarif}}</td>
                  <td>{{($item->tarif_id != 10000) ? number_format($item->tarif->total, 0, ',', '.') : NULL}}</td>
                  <td>{{($item->tarif_id != 10000) ? @floor(((@$item->total + @$item->diskon) / @$item->tarif->total)) : NULL}}</td>
                  <td>{{number_format($item->total, 0, ',', '.')}}</td>
                  <td>{{$item->cyto == 1? 'Ya':'Tidak'}}</td>
                  <td>{{baca_kamar(@$item->kamar_id)}}</td>
                  <td>{{baca_kelas(@$item->kelas_id)}}</td>
                  <td>{{baca_dokter(@$item->dokter_id)}}</td>
                  <td>{{@$item->dokter_anestesi ? baca_dokter(@$item->dokter_anestesi) : '-'}}</td>
                  <td>{{@$item->dokter_anak ? baca_dokter(@$item->dokter_anak) : '-'}}</td>
                  <td>{{@$item->user->name}}</td>
                  <td>{{baca_carabayar(@$item->cara_bayar_id)}}</td>
                  <td>{{@$item->created_at->format('d-m-Y')}}</td>
                </tr>
            @endforeach
          @endif
        </tbody>
        {{-- <tfoot> --}}
          <tr style="background: rgb(25, 90, 14);">
            <th colspan="4" class="text-right">Total</th>
            <th colspan="10">{{number_format(@$folio->sum('total'))}}</th>
          </tr>
        {{-- </tfoot> --}}
      </table>
      {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
      {{-- <table style="width:100%" cellspacing="1">
        <tr>
          <th style="border-bottom:1px solid black">BIAYA</th>
          <th class="text-right" style="border-bottom:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black">TOTAL</th>
        </tr>
      <tr><th class="dotTop" colspan="4">TINDAKAN</th></tr>
      @php
          $tindakan_igd = 0;
          $tindakan_irj_ina = 0;
      @endphp
      @if (count($folio->get()) > 0)
          
        @foreach ($folio->get() as $item)
        @php
            @$jml = @floor(@$item->total / @$item->tarif->total);
            @$tindakan_igd += $item->total;
        @endphp
            <tr>
              <td><span style="margin-left:40px;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td class="text-center">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
      @endif
      <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($tindakan_igd+$tindakan_irj_ina)}}</span></td>
      </table> --}}
           <table style="width: 100%;">
            <tr>
              <td style="width: 50%;" class="text-center">
                {{-- Petugas
                <br><br><br><br><br>
                {{baca_pegawai(Auth::user()->login)}} --}}
              </td>
              <td style="width: 50%;" class="text-center">
                Petugas
                {{-- {{ configrs()->kota }}, {{ date('d-m-Y') }} --}}
                <br><br><br><br><br>
                {{ Auth::user()->name }}<br>
              </td>
            </tr>
          </table> 

  </body>
</html>
