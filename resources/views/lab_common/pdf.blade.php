<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

  </head>
  <body>
    <div>
      <div>
          {{-- <img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive" style="width: 57px;float: left;position: absolute;margin: 10px;"> --}}
          <h6 class="text-center" style="font-size: 17pt; font-weight: bold; margin-top: -5px;">{{ strtoupper(configrs()->nama) }}</h6>
          <h4 class="text-center" style="font-weight: bold; margin-top: -5px; margin-bottom: -1px;">INSTALASI LABORATORIUM</h4>
          <p class="text-center">{{ configrs()->alamat }} {{ configrs()->tlp }} {{ configrs()->kota }}</p>
        <hr>
      </div>
    </div>
    <br>
      <table style="width: 100%">
        <tbody>
          <tr>
            <th style="width: 17%">No. Lab / No. RM</th> <td>: {{ $lab->no_lab }} / {{ $lab->pasien->no_rm }}</td>
            <th style="width: 17%">Dokter Pengirim</th> <td>: </td>
          </tr>
          <tr>
            <th>Nama Pasien</th> <td>: {{ $lab->pasien->nama }}</td>
            <th>Tgl Pemeriksaan</th> <td>: {{ tgl_indo($lab->tgl_pemeriksaan) }}</td>
          </tr>
          <tr>
            <th>Alamat</th> <td>: {{ $lab->pasien->alamat }}</td>
            <th>Waktu Sampel</th> <td>: {{ $lab->jam }} / {{ tgl_indo($lab->tgl_bahanditerima) }}</td>
          </tr>
          <tr>
            <th>Tgl Lahir / Umur</th> <td>: {{ tgl_indo($lab->pasien->tgllahir) }} / {{ !empty($lab->pasien->tgllahir) ? hitung_umur($lab->pasien->tgllahir) : NULL }}</td>
            <th>Dokter Pemeriksa</th> <td>: </td>
          </tr>
          <tr>
            <th>Jenis Kelamin</th> <td>: {{ ($lab->pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
          </tr>
        </tbody>
      </table>
      <br>
      ===============================================================================================
      <table style="width:100%">
        <thead>
          <tr>
            <th colspan="2" class="text-left">PEMERIKSAAN</th>
            <th class="text-center">HASIL</th>
            <th class="text-center">SATUAN</th>
            <th class="text-center">NILAI RUJUKAN</th>
          </tr>
        </thead>

        <tbody>

          @foreach ($rincian as $key => $d)
            <tr class="text-center">
              <td class="text-left">{{ $d->laboratoria->nama }}</td>
              <td class="text-right">
                @if (!empty($d->hasil))
                  @if ($d->hasil <= $d->laboratoria->nilairujukanbawah)
                    L
                  @elseif ($d->hasil >= $d->laboratoria->nilairujukanatas)
                    H
                  @endif
                @endif

              </td>
              <td>
                {{ ($d->hasil) ? number_format($d->hasil,2,'.',',') : '' }} {{ $d->hasiltext }}
              </td>
              <td>{{ !empty($d->hasil) ? $d->laboratoria->satuan : '' }}</td>
              <td>{{ !empty($d->hasil) ? $d->laboratoria->nilairujukanbawah : '' }}  {{ !empty($d->hasil) ? ' - '.$d->laboratoria->nilairujukanatas : '' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      ===============================================================================================
      <br> <br>
        <i>Dicetak pada: {{ date('m-d-Y H:i:s') }}</i> <br>

        {{-- <table style="width:100%">
            <thead>
                <tr>
                  <th colspan="2" class="text-left">PEMERIKSAAN</th>
                  <th class="text-center">HASIL</th>
                  <th class="text-center">SATUAN</th>
                  <th class="text-center">NILAI RUJUKAN</th>
                </tr>
            </thead>

            <tbody>
                {{ $section }}
                @foreach ($section as $key => $r)
                    Section {{ $r->labsection_id }} <br>
                    @foreach (App\RincianHasillab::where('hasillab_id', '=', $r->hasillab_id)->where('labsection_id', '=', $r->labsection_id)->distinct()->get(['labkategori_id']) as $key => $x)
                        - Kategori {{ $x->labkategori_id }} <br>
                        @foreach (App\RincianHasillab::where('hasillab_id', '=', $r->hasillab_id)->where('labsection_id', '=', $r->labsection_id)->where('labkategori_id', '=', $x->labkategori_id)->get() as $key => $y)
                            -- {{ $y->laboratoria_id }} <br>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table> --}}
        <br><br>
        <div class="text-center" style="padding: 5px; float:right;">
          Laboratorium, {{ date('d-m-Y') }}
          <br>
          <br>
          <br>
          <br>
          <u>{{ Auth::user()->name }}</u><br>
          {{-- SIP {{ $dokter->sip }} --}}
          <hr>
        </div>
  </body>
</html>
