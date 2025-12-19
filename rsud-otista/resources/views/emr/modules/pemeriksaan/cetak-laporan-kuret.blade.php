<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>

  </head>
  <body>
    @php
    $cetak = $laporan;
    $laporan = @json_decode(@$laporan->keterangan, true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>LAPORAN KURET</b></h5>
    <table style="width:100%; font-size:11px;" >
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
        <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
      </tr>
    </table>

    <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
        <tr>
            <td style="width:40%;">Tanggal</td>
            <td style="padding: 5px;">
                {{@$laporan['tanggal']}}
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Jam</td>
            <td style="padding: 5px;">
                {{@$laporan['jam']}}
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Anestesi</td>
            <td style="padding: 5px;">
                {{@$laporan['anestesi']}}
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Operator</td>
            <td style="padding: 5px;">
                {{@$laporan['operator']}}
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Asisten</td>
            <td style="padding: 5px;">
                {{@$laporan['asisten']}}
            </td>
        </tr>
        <tr>
            <td colspan="2"><p>Penderita dilakukan dalam posisi lithotomi setelah dilakukan tindakan dan antiseptik didaerah vulva dan sekitarnya dipasang Speculum bawah yang dipegang asisten.</p></td>
        </tr>
        <tr>
            <td style="width:40%;">Dengan pertolongan speculum atas, bibir depan portio dijepit dengan rongeltang, sonde masukan sedalam</td>
            <td style="padding: 5px;">
                <div class="btn-group" style="display: flex">
                    {{@$laporan['sonde_masukan_sedalam']}} cm
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Dilatasi dengan diiatator</td>
            <td style="padding: 5px;">
                <div>
                    <input class="form-check-input"
                        name="form[dilatasi_diiatator][pilihan]"
                        {{ @$laporan['dilatasi_diiatator']['pilihan'] == 'Tidak dilakukan' ? 'checked' : '' }}
                        type="radio" value="Tidak dilakukan">
                    <label class="form-check-label" style="font-weight: 400;">Tidak dilakukan</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="form[dilatasi_diiatator][pilihan]"
                        {{ @$laporan['dilatasi_diiatator']['pilihan'] == 'Dilakukan' ? 'checked' : '' }}
                        type="radio" value="Dilakukan">
                    <label class="form-check-label" style="font-weight: 400;">Dilakukan,</label>
                    <span>Hegar No :</span>
                    {{@$laporan['dilatasi_diiatator']['hegar_no']}}
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="padding: 5px;">
                <div>
                    <input class="form-check-input"
                        name="form[jenis][pilihan]"
                        {{ @$laporan['jenis']['pilihan'] == 'Corpus uteri ante' ? 'checked' : '' }}
                        type="radio" value="Corpus uteri ante">
                    <label class="form-check-label" style="font-weight: 400;">Corpus uteri ante</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="form[jenis][pilihan]"
                        {{ @$laporan['jenis']['pilihan'] == 'Retropileksi' ? 'checked' : '' }}
                        type="radio" value="Retropileksi">
                    <label class="form-check-label" style="font-weight: 400;">Retropileksi</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Pengeluaran jaringan dengan cunam abortus</td>
            <td style="padding: 5px;">
                <div>
                    <input class="form-check-input"
                        name="form[pengeluaran_jaringan][pilihan]"
                        {{ @$laporan['pengeluaran_jaringan']['pilihan'] == 'Tidak dilakukan' ? 'checked' : '' }}
                        type="radio" value="Tidak dilakukan">
                    <label class="form-check-label" style="font-weight: 400;">Tidak dilakukan</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="form[pengeluaran_jaringan][pilihan]"
                        {{ @$laporan['pengeluaran_jaringan']['pilihan'] == 'Dilakukan' ? 'checked' : '' }}
                        type="radio" value="Dilakukan">
                    <label class="form-check-label" style="font-weight: 400;">Dilakukan</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Dilakukan Curretage secara sistematis dan hati-hati sampai cavum uteri bersih dengan curet no</td>
            <td style="padding: 5px;">
                <div>
                    {{@$laporan['curretage']['curet_no']}}
                    <br><span>Berhasil dikeluarkan jaringan</span>
                    {{@$laporan['curretage']['berhasil_dikeluarkan_jaringan']}}
                    <br><span>Sebanyak (Gr)</span>
                    {{@$laporan['curretage']['sebanyak']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Jumlah pendarahan sebanyak</td>
            <td style="padding: 5px;">
                <div class="btn-group" style="display: flex">
                    {{@$laporan['jumlah_pendarahan']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Pemasangan IUD</td>
            <td style="padding: 5px;">
                <div>
                    <input class="form-check-input"
                        name="form[pemasangan_iud][pilihan]"
                        {{ @$laporan['pemasangan_iud']['pilihan'] == 'Tidak dilakukan' ? 'checked' : '' }}
                        type="radio" value="Tidak dilakukan">
                    <label class="form-check-label" style="font-weight: 400;">Tidak dilakukan</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="form[pemasangan_iud][pilihan]"
                        {{ @$laporan['pemasangan_iud']['pilihan'] == 'Dilakukan' ? 'checked' : '' }}
                        type="radio" value="Dilakukan">
                    <label class="form-check-label" style="font-weight: 400;">Dilakukan</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">D / Precurretage</td>
            <td style="padding: 5px;">
                <div class="btn-group" style="display: flex">
                    {{@$laporan['d_precurretage']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">D / Postcurretage</td>
            <td style="padding: 5px;">
                <div class="btn-group" style="display: flex">
                    {{@$laporan['d_postcurretage']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Keadaan O.S Post Curretage</td>
            <td style="padding: 5px;">
                <div>
                    <span>KU</span> <br>
                    {{@$laporan['keadaan_post_curretage']['ku']}}
                </div>
                <div>
                    <span>T</span> <br>
                    {{@$laporan['keadaan_post_curretage']['t']}}
                </div>
                <div>
                    <span>R</span> <br>
                    {{@$laporan['keadaan_post_curretage']['r']}}
                </div>
                <div>
                    <span>N</span> <br>
                    {{@$laporan['keadaan_post_curretage']['n']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Therapi post curretage</td>
            <td style="padding: 5px;">
                <div class="btn-group" style="display: flex">
                    {{@$laporan['therapi_post_curretage']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:40%;">Catatan</td>
            <td style="padding: 5px;">
                <div class="btn-group" style="display: flex">
                    {{@$laporan['catatan']}}
                </div>
            </td>
        </tr>
    </table> 
    <table style="width: 100%;font-size:11px;" border="0">
        <tr>
          <td style="width: 50%;"></td>
          <td style="width: 50%; text-align:center;"> 
            Dokter yang Bertugas / DPJP 
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="text-align: center;">
            @if (isset($proses_tte))
                #
            @elseif (isset($tte_nonaktif))
              @php
                @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip . '|' . @$cetak->created_at))
              @endphp
                <div style="margin-bottom: 40px;">
                  <img src="data:image/png;base64, {!! $base64 !!}">
                </div>
            @else
            <br><br><br><br>
            @endif
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="text-align: center;">
            <br/>
            {{baca_dokter(@$reg->dokter_id)}}
          </td>
        </tr>
      </table>
  </div>
  </body>
</html>