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
    </style>
  </head>
  <body>
          @php
              $obat = 0;
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

      @if (substr(@$reg->status_reg, 0, 1) == 'I')
      <table style="width:100%">
        <tbody>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td style="width:25%">Nama</td> <td>: {{ $reg->pasien->nama }}</td>
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
           <td style="width:25%">Kelas Perawatan</td> <td>: {{ baca_kelas(@$ranap->kelas_id) }}</td>
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
        </tbody>
      </table>
      @else



      <table style="width:100%">
        <tbody>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td style="width:25%">Nomor Peserta</td> <td>: {{ @$reg->no_jkn }}</td>
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
           <td style="width:25%">Kelas Perawatan</td> <td>: {{ baca_kelas(@$ranap->kelas_id) }}</td>

          </tr>
          <tr>
            @php
                $emr = App\Emr::where('registrasi_id', $reg->id)->first()
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
                {{ "-" }}
              @endif
            </td>
          </tr>
        </tbody>
      </table>




      @endif














          {{-- <br>--}}
          <hr> 
          @if (Auth::user()->hasRole('laboratorium'))
            <h5 style="text-align: center;">Rincian Biaya Pemeriksaan</h5>
          @else
            <h5 style="text-align: center;">Rincian Biaya Perawatan</h5>
          @endif
          <hr>

          @if($folio_irj->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Tindakan</th>
                <th class="text-center">Biaya @</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
              </tr>
              <tr>
                <th colspan="5" class="text-left">Rawat Jalan</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irj as $noirj => $d)
                  <tr>
                    <td class="text-center">{{ ++$noirj  }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                      <td>{{ @$d->tarif_baru->nama }}</td>
                      @if(@$d->cyto)
                        @php
                        $cyto = ($d->tarif_baru->total * 30) / 100;
                        $hargaTotal = $d->tarif_baru->total + $cyto;
                        @endphp
                        <td class="text-right">{{ number_format(@$hargaTotal,0,',','.') }}</td>
                        <td class="text-center">{{@$hargaTotal ? ($d->total / @$hargaTotal) : '0'}}</td>
                      @else
                      <td class="text-right">{{ number_format(@$d->tarif_baru->total,0,',','.') }}</td>
                        <td class="text-center">{{@$d->tarif_baru->total ? ($d->total / @$d->tarif_baru->total) : '0'}}</td>
                      @endif
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td class="text-right">{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                      <td class="text-center">{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                    @endif
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_irj) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irj_lab->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Tindakan</th>
                <th class="text-center">Biaya @</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
              </tr>
              <tr>
                <th colspan="5" class="text-left">Laboratorium</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irj_lab as $noirjlab => $d)
                  <tr>
                    <td class="text-center">{{ ++$noirjlab  }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                      <td>{{ @$d->tarif_baru->nama }}</td>
                      @if(@$d->cyto)
                        @php
                        $cyto = ($d->tarif_baru->total * 30) / 100;
                        $hargaTotal = $d->tarif_baru->total + $cyto;
                        @endphp
                        <td class="text-right">{{ number_format(@$hargaTotal,0,',','.') }}</td>
                        <td class="text-center">{{@$hargaTotal ? ($d->total / @$hargaTotal) : '0'}}</td>
                      @else
                        <td class="text-right">{{ number_format(@$d->tarif_baru->total,0,',','.') }}</td>
                        <td class="text-center">{{@$d->tarif_baru->total ? ($d->total / @$d->tarif_baru->total) : '0'}}</td>
                      @endif
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td class="text-right">{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                      <td class="text-center">{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                    @endif
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_irj_lab) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irj_rad->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Tindakan</th>
                <th class="text-center">Biaya @</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
              </tr>
              <tr>
                <th colspan="5" class="text-left">Radiologi</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irj_rad as $noirjrad => $d)
                  <tr>
                    <td class="text-center">{{ ++$noirjrad  }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                      <td>{{ @$d->tarif_baru->nama }}</td>
                      @if(@$d->cyto)
                        @php
                        $cyto = ($d->tarif_baru->total * 30) / 100;
                        $hargaTotal = $d->tarif_baru->total + $cyto;
                        @endphp
                        <td class="text-right">{{ number_format(@$hargaTotal,0,',','.') }}</td>
                        <td class="text-center">{{@$hargaTotal ? ($d->total / @$hargaTotal) : '0'}}</td>
                      @else
                        <td class="text-right">{{ number_format(@$d->tarif_baru->total,0,',','.') }}</td>
                        <td class="text-center">{{@$d->tarif_baru->total ? ($d->total / @$d->tarif_baru->total) : '0'}}</td>
                      @endif
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td class="text-right">{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                      <td class="text-center">{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                    @endif
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_irj_rad) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_igd->count())
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th colspan="5" class="text-left">Instalasi Gawat Darurat</th>
              </tr>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Tindakan</th>
                  <th class="text-center">Biaya @</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($folio_igd as $noigd => $d)
                  <tr>
                    <td class="text-center">{{ ++$noigd }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif_baru->total) : '' }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                  @endif
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_igd) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_igd_lab->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Tindakan</th>
                <th class="text-center">Biaya @</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
              </tr>
              <tr>
                <th colspan="5" class="text-left">Laboratorium</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_igd_lab as $noigdlab => $d)
                  <tr>
                    <td class="text-center">{{ ++$noigdlab  }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif_baru->total) : '' }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                    @endif
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_igd_lab) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_igd_rad->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Tindakan</th>
                <th class="text-center">Biaya @</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
              </tr>
              <tr>
                <th colspan="5" class="text-left">Radiologi</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_igd_rad as $noigdrad => $d)
                  <tr>
                    <td class="text-center">{{ ++$noigdrad  }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif_baru->total) : '' }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                    @endif
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_igd_rad) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif


          {{-- RAWAT INAP --}}
          @if($folio_irna->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
                <tr>
                  <th colspan="5" class="text-left">Rawat Inap</th>
                </tr>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Tindakan</th>
                  <th class="text-center">Biaya @</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                
                @php $kat = 0; @endphp
                @foreach ($folio_irna as $noirna => $d)
                  @if($d->tarif->kategoritarif_id != $kat)
                  <tr class="_border">
                    <td colspan="5" style="padding-top:10px;"> {{ Modules\Kategoritarif\Entities\Kategoritarif::where('id',$d->tarif->kategoritarif_id)->first()->namatarif }} :</td>
                  </tr>
                  @else

                  @endif
                  <tr>
                    <td class="text-center">{{ ++$noirna }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif_baru->total) : '' }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                    @endif
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                  @php($kat = $d->tarif->kategoritarif_id)
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_irna) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irna_lab->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Tindakan</th>
                <th class="text-center">Biaya @</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
              </tr>
              <tr>
                <th colspan="5" class="text-left">Laboratorium</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irna_lab as $noirnalab => $d)
                  <tr>
                    <td class="text-center">{{ ++$noirnalab  }}</td>
                    @if (@$d->verif_kasa_user = 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif_baru->total) : '' }}</td>
                    <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    @else
                      <td>{{ @$d->tarif->nama }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                      <td>{{ (@$d->tarif->total <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                    @endif
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total</th>
                  <th class="text-right">{{ number_format($jml_irna_lab) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif
          
          {{-- <p style="text-align:right;"><b>Total Biaya Perawatan: {{ number_format($jml) }}</b></p> --}}
          <p style="text-align:right;"><b> Total Biaya Perawatan: {{ number_format($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad) }}</b></p>
          <p><i>Terbilang: {{ terbilang($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad) }} Rupiah</i></p>

           <table style="width: 100%;">
            <tr>

              <th class="text-center" style="width:30%">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}
              <br><br>
              {{-- <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
              <img src="{{ public_path('images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
              <br><br>
              <i><u>{{ $norah->nama }}</u></i></th>
            </tr>
          </table> 

  </body>
</html>