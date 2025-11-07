@extends('master')
@section('header')
  <h1>Resum Rawat Inap <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th class="text-center" colspan="3">
                PEMERINTAH KABUPATEN KUNINGAN <br />
                RUMAH SAKIT UMUM DAERAH 45 KUNINGAN <br />
                Jl. Jend. Sudirman No. 68 Tlp. (232)871885 <br />
                Website: http://rsud45.kuningan.go.id
              </th>
              <th rowspan="2" style="vertical-align: top">
                <table class="table table-condensed">
                   <tr>
                    <th colspan="2" class="text-center">Identitas Pasien</th>
                  </tr>
                  <tr>
                    <td style="width: 20%">Nama</td><td>: {{ $reg->pasien->nama }}</td>
                  </tr>
                   <tr>
                    <td>Tgl Lahir</td><td>: {{ $reg->pasien->tgllahir }} &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; {{ $reg->pasien->kelamin }}</td>
                  </tr>
                   <tr>
                    <td>No. RM</td><td>: {{ $reg->pasien->no_rm }}</td>
                  </tr>
                </table>
              </th>
            </tr>
            <tr>
              <th class="text-center" colspan="3"><h4 style="font-weight: bold; font-size: 14pt">RESUME MEDIS</h4></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
              <td style="width: 20%">Tanggal Masuk</td>
              <td style="width: 25%">{{ $inap->tgl_masuk }}</td>
              <td style="width: 20%">Ruang Rawat</td>
              <td style="width: 35%">{{ baca_kamar($inap->kamar_id) }}</td>
            </tr>
            <tr>
              <td>Tanggal Keluar</td>
              <td>{{ $inap->tgl_keluar }}</td>
              <td>Ruang Rawat</td>
              <td>{{ baca_kamar($inap->kamar_id) }}</td>
            </tr>
            <tr>
              <td>Lama Dirawat</td>
              <td>{{ !empty($inap->tgl_keluar) ? $los : NULL }}</td>
              <td>Berat Badan Bayi Lahir < 1 Bulan</td>
              <td></td>
            </tr>
            <tr>
              <td style="width: 15%">Indikasi / Alasan Dirawat</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Pemeriksaan Fisik Yang Bermakna</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td colspan="4">PENUNJANG YANG BERMAKNA</td>
            </tr>
            <tr>
              <td style="width: 15%">Hasil Laboratorium Yang Menyimpang</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Radiologi </td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Penunjang Lain</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
              <td style="width: 15%">Hasil Konsultasi</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Diagnosis Masuk</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td colspan="4">DIAGNOSA KELUAR</td>
            </tr>
            <tr>
              <td style="width: 15%">Diagnosa Utama</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Diagnosa Sekunder </td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Komorbid</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Kompikasi </td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
              <td style="width: 15%">Tindakan Operasi</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Tanggal Operasi</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Penyebab Kematian <br><i>Jikas Pasien Meninggal Dunia</i></td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
            <tr>
              <td style="width: 15%">Tindakan / Prosedur</td>
              <td style="width: 85%" colspan="3"></td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- =================================== OBAT SELAMA DI RAWAT============================= --}}

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th colspan="10" class="text-center" style="font-weight: bold;">Obat Selama Dirawat</th>
            </tr>
            <tr>
              <th>Nama Obat</th>
              <th>Jumlah</th>
              <th>Dosis</th>
              <th>Frekuensi</th>
              <th>Cara</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th colspan="10" class="text-center" style="font-weight: bold;">Obat Untuk Dibawa Pulang</th>
            </tr>
            <tr>
              <th>Nama Obat</th>
              <th>Jumlah</th>
              <th>Dosis</th>
              <th>Frekuensi</th>
              <th>Cara</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">

    </div>
  </div>
@endsection
