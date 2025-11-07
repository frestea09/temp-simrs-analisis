<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
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
  <body onload="print()">

    {{-- <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:100px;">
                </th>
                <th style="text-align:start;">
                  <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
                  <p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>

                </th>
              </tr>
            </tbody>
          </table> <br> --}}
          @php
              $obat = 0;
              $ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
          @endphp
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
      <br>
      <hr>
      <table style="width:100%">
        <tbody>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td style="width:25%">Kode Rumah Sakit</td> <td>: 3204090</td>
            <td>Nama Rumah Sakit</td><td>: {{ config('app.nama') }} </td>
          </tr>
          <tr>
            <td style="width:25%">Kelas Rumah Sakit</td> <td>:  C</td>
            <td>Jenis Tarif</td><td>: TARIF RS KELAS C PEMERINTAH</td>
          </tr>
        </tbody>
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
      @else



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
            <td style="width:25%">Umur Hari</td>
            <td>: 
            
            
              @if (@$reg->pasien->tgllahir != null)
                <?php
                  $tgl1 = new DateTime(@$reg->pasien->tgllahir);
                  $tgl2 = new DateTime("today");
                  $d = $tgl2->diff($tgl1)->days + 1;
                  echo $d." Hari";
                ?>
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
          <tr>
            <td style="width:25%">Kelas Perawatan</td> <td>: {{ baca_kelas(@$ranap->kelas_id) }}</td>
            <td>Berat Lahir</td><td>:  -</td>
          </tr>
          <tr>
            <td style="width:25%">Nomor Register SITB</td> <td>: -</td>
          </tr>
        </tbody>
      </table>




      @endif














          {{-- <br>--}}
          <hr> 
          @if (Auth::user()->hasRole('laboratorium'))
            <h3 style="text-align: center;">Rincian Biaya Pemeriksaan</h3>
          @else
            <h3 style="text-align: center;">Rincian Biaya Perawatan</h3>
          @endif
          <hr>

          @if($folio_irj->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Rawat Jalan</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irj as $noirj => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noirj  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                      <td>{{ @$d->tarif_baru->nama }}</td>
                      @php
                        $hargaTotal = @$d->tarif_baru->total;
                      @endphp
                      @if($reg->poli->kelompok == 'ESO') {{-- Jika Poli EKsekutif --}}
                        @if($d->cyto)
                        @php
                          $cyto = ($hargaTotal * 30) / 100;
                          $hargaTotal = $hargaTotal + $cyto;
                        @endphp
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? number_format(@$hargaTotal) : NULL }}</td>
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? (@$d->total / @$hargaTotal) : NULL }}</td>
                        @else
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? number_format(@$hargaTotal) : NULL }}</td>
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? (@$d->total / @$hargaTotal) : NULL }}</td>
                        @endif
                      @endif
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_irj) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irj_lab->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Laboratorium</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irj_lab as $noirjlab => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noirjlab  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                      <td>{{ @$d->tarif_baru->nama }}</td>
                      @php
                        $hargaTotal = @$d->tarif_baru->total;
                      @endphp
                      @if($reg->poli->kelompok == 'ESO') {{-- Jika Poli EKsekutif --}}
                        @if($d->cyto)
                        @php
                          $cyto = ($hargaTotal * 30) / 100;
                          $hargaTotal = $hargaTotal + $cyto;
                        @endphp
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? number_format(@$hargaTotal) : NULL }}</td>
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? (@$d->total / @$hargaTotal) : NULL }}</td>
                        @else
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? number_format(@$hargaTotal) : NULL }}</td>
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? (@$d->total / @$hargaTotal) : NULL }}</td>
                        @endif
                      @endif
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_irj_lab) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irj_rad->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Radiologi</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irj_rad as $noirjrad => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noirjrad  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                      <td>{{ @$d->tarif_baru->nama }}</td>
                      @php
                        $hargaTotal = @$d->tarif_baru->total;
                      @endphp
                      @if($reg->poli->kelompok == 'ESO') {{-- Jika Poli EKsekutif --}}
                        @if($d->cyto)
                        @php
                          $cyto = ($hargaTotal * 30) / 100;
                          $hargaTotal = $hargaTotal + $cyto;
                        @endphp
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? number_format(@$hargaTotal) : NULL }}</td>
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? (@$d->total / @$hargaTotal) : NULL }}</td>
                        @else
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? number_format(@$hargaTotal) : NULL }}</td>
                        <td style="text-align:start;">{{ (@$hargaTotal <> 0) ? (@$d->total / @$hargaTotal) : NULL }}</td>
                        @endif
                      @endif
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_irj_rad) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_igd->count())
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th colspan="5" style="text-align:start;">Instalasi Gawat Darurat</th>
              </tr>
                <tr>
                  <th style="text-align:start;">No</th>
                  <th style="text-align:start;">Nama Tindakan</th>
                  <th style="text-align:start;">Biaya @</th>
                  <th style="text-align:start;">Qty</th>
                  <th style="text-align:start;">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($folio_igd as $noigd => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noigd }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif_baru->total <> 0) ? number_format(@$d->tarif_baru->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif_baru->total <> 0) ? (@$d->total / @$d->tarif_baru->total) : NULL }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_igd) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_igd_lab->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Laboratorium</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_igd_lab as $noigdlab => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noigdlab  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif_baru->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif_baru->total) : NULL }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_igd_lab) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_igd_rad->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Radiologi</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_igd_rad as $noigdrad => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noigdrad  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif_baru->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif_baru->total) : NULL }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_igd_rad) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif


          {{-- RAWAT INAP --}}
          @if($folio_irna->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
                <tr>
                  <th colspan="5" style="text-align:start;">Rawat Inap</th>
                </tr>
                <tr>
                  <th style="text-align:start;">No</th>
                  <th style="text-align:start;">Nama Tindakan</th>
                  <th style="text-align:start;">Biaya @</th>
                  <th style="text-align:start;">Qty</th>
                  <th style="text-align:start;">Total</th>
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
                    <td style="text-align:start;">{{ ++$noirna }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif_baru->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif_baru->total) : NULL }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                  @php $kat = $d->tarif->kategoritarif_id @endphp
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_irna) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irna_lab->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Laboratorium</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irna_lab as $noirnalab => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noirnalab  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif_baru->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif_baru->total) : NULL }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_irna_lab) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif

          @if($folio_irna_rad->count() > 0)
          <div class="table-responsive">
            <table class="table table-bordered" style="width:100%;">
              <thead>
              <tr>
                <th style="text-align:start;">No</th>
                <th style="text-align:start;">Nama Tindakan</th>
                <th style="text-align:start;">Biaya @</th>
                <th style="text-align:start;">Qty</th>
                <th style="text-align:start;">Total</th>
              </tr>
              <tr>
                <th colspan="5" style="text-align:start;">Radiologi</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($folio_irna_rad as $noirnarad => $d)
                  <tr>
                    <td style="text-align:start;">{{ ++$noirnarad  }}</td>
                    @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ @$d->tarif_baru->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif_baru->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif_baru->total) : NULL }}</td>
                    @else
                    <td>{{ @$d->tarif->nama }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? number_format(@$d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ (@$d->tarif->total <> 0) ? (@$d->total / @$d->tarif->total) : NULL }}</td>
                    @endif
                    {{-- <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    <td style="text-align:start;">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td> --}}
                    <td style="text-align:start;">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4" style="text-align:center;">Total</th>
                  <th style="text-align:start;">{{ number_format($jml_irna_rad) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          @endif



          @if($penjualan->count() > 0)
            @if (baca_carabayar($reg->bayar) == 'UMUM' )
            <div class="table-responsive">
              <table class="table table-bordered" style="width: 100%">
                <thead>
                <tr>
                  <th colspan="3" style="text-align:start;">Rincian Obat</th>
                </tr>
                  <tr>
                    <th style="text-align:start;">No</th>
                    <th style="text-align:start;">No Resep</th>
                    <th style="text-align:start;" style="text-align:center; width:30%;">Obat</th>
                    <th style="text-align:start;">qty</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($penjualan as $nopen => $d)
                    <tr>
                      <td>{{ ++$nopen }}</td>
                      <td>{{ $d->no_resep }}</td>
                      <td style="text-align:center; width:30%;">{{ baca_obat($d->masterobat_id) }}</td>
                      {{-- <td>{{ number_format($d->hargajual/$d->jumlah) }}</td> --}}
                      <td>{{ $d->jumlah }}</td>
                      {{-- <td>{{ number_format($d->hargajual) }}</td> --}}
                    </tr>
                    {{-- <tr>
                      <td style="text-align:start;">{{ $no++ }}</td>
                      <td>{{ $d->namatarif }}</td>
                      <td style="text-align:start;">{{ ($d->total) }}</td>
                      <td style="text-align:start;">{{ ($d->total) }}</td>
                      <td style="text-align:start;">{{ number_format($d->total) }}</td>
                    </tr> --}}
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" style="text-align:center;">Total</th>
                    <th style="text-align:start;">{{ number_format($jml_obat) }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            
            @else
            <div class="table-responsive">
              <table class="table table-bordered" style="width: 100%">
                <thead>
                <tr>
                  <th colspan="6" style="text-align:start;">Rincian Obat</th>
                </tr>
                  <tr>
                    <th style="text-align:start;">No</th>
                    <th style="text-align:start;">No Resep</th>
                    <th style="text-align:start;" style="text-align:center; width:30%;">Obat</th>
                    <th style="text-align:start;">Biaya @</th>
                    <th style="text-align:start;">Qty</th>
                    <th style="text-align:start;">Total</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach ($penjualan as $nopenn => $d)
                  <?php
                    $total = $d->hargajual/$d->jumlah*$d->jumlah;
                      $obat += $total
                  ?>
                    <tr>
                      <td>{{ ++$nopenn }}</td>
                      <td>{{ @$d->no_resep }}</td>
                      <td style="text-align:left; width:30%;">{{ substr(strtoupper(baca_obat($d->masterobat_id)),0,40) }}</td>
                      <td>{{ $d->jumlah !== 0 ? number_format($d->hargajual/$d->jumlah) : number_format($d->hargajual)  }}</td>
                      <td>{{ $d->jumlah }}</td>
                      {{-- <td>{{ number_format($d->hargajual) }}</td> --}}
                      <td style="text-align:start;">{{ number_format($total) }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  @foreach ($jenisracik as $u) 
                    <tr>
                      <th colspan="3"  style="padding-left: 240px">{{ $u->nama }}</th>
                      <td style="text-align:start;">{{ $u->uang_racik}}</td>
                      <td>{{ $u->jmlracik}}</td>
                      <td style="text-align:start;">{{ $u->uracik}}</td>
                    </tr>
                  @endforeach

                  <tr>
                    <th colspan="5" style="text-align:center;">Total</th>
                    <th style="text-align:start;">{{ number_format($obat+$uangracik) }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            @endif
          
          @endif

          
          {{-- <table>

            <tfoot>
              <tr>
                <th colspan="4" style="text-align:center;">Total Biaya Perawatan</th>
                <th style="text-align:start;">{{ number_format($jml) }}</th>
              </tr>
  
              <tr>
                <th colspan="4" style="text-align:start;">
                  @if ($reg->bayar == 1)
                    Di Jamin
                  @else
                    Sisa
                  @endif
  
                </th>
                <th style="text-align:start;">{{ number_format($kuitansi->iur) }}</th>
              </tr>
              <tr>
                <th colspan="6" style="text-align:center;">Total Bayar</th>
                <th style="text-align:start;">{{ number_format($kuitansi->dibayar) }}</th>
              </tr>
            </tfoot>
          </table> --}}
          {{-- <p style="text-align:right;"><b>Total Biaya Perawatan: {{ number_format($jml) }}</b></p> --}}
          <p style="text-align:center;"><b> Total Biaya Perawatan: {{ number_format($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }}</b></p>
          {{-- <p><i>Terbilang: {{ terbilang($kuitansi->dibayar) }} Rupiah</i></p> --}}
          <p><i>Terbilang: {{ terbilang($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }} Rupiah</i></p>

          {{-- @php
            $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
          @endphp --}}
          <table style="width: 100%;">
            <tr>
              <td style="width: 50%;" style="text-align:start;">
                Manager Administrasi
                <br><br>
                {{-- <img src="url('/images/1687226376ttdtehnora.png')" alt="">
                <img src="{{ asset('images/1687226376ttdtehnora.png') }}"style="width: 60px;"> --}}
                <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br><br><br>
                {{-- Nora Haryanti, S.Sos<br> --}}
                {{ $norah->nama }}<br>
              </td>

              <td style="width: 50%;" style="text-align:start;">
                Kasir
                {{-- {{ configrs()->kota }}, {{ date('d-m-Y') }} --}}
                <br><br><br><br><br>
                {{ Auth::user()->name }}<br>
              </td>
            </tr>
          </table> 

  </body>
</html>
