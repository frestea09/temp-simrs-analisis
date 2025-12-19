@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }
</style>
@section('header')
    <h1>Operasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
        </h3>
    </div>
    <div class="box-body">
      <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
      <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
      <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

      @include('emr.modules.addons.profile')
      <form method="POST" action="{{ url('emr-soap/pemeriksaan/daftar-tilik-operasi/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
        <div class="row">
          @include('emr.modules.addons.tab-operasi')
          <div class="col-md-12">
            {{ csrf_field() }}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
            {!! Form::hidden('unit', $unit) !!}
            <br>

            <div class="col-md-12">
                <table class='table-striped table-bordered table-hover table-condensed table'>
                    <thead>
                        <tr>
                            <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                            <th class="text-center" style="vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($riwayats) == 0)
                            <tr>
                                <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                            </tr>
                        @endif
                        @foreach ($riwayats as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                        class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url("operasi/cetak-daftar-tilik/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa fa-print"></i></a>
                                    <a href="{{ url("operasi/delete-daftar-tilik/".@$riwayat->id) }}" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
              <h4 style="text-align: center;"><b>DAFTAR TILIK</b></h4>
            </div>

            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2" style="text-align: center; font-size: 18px !important; background-color: rgb(78, 78, 218); color: white;"><label for="">SIGN IN</label></td>
                  </tr>
                  <tr>
                    <td>Pukul</td>
                    <td>
                      <input type="datetime-local" name="fisik[sign_in][pukul]" class="form-control" placeholder="Pukul" value="{{ @$asessment['sign_in']['pukul'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>1. Pasien telah dikonfirmasikan</b></td>
                  </tr>
                  <tr>
                    <td>- Identitas dan gelang pasien</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][pasien_konfirmasi][identitas_dan_gelang_pasien]" value="Ya" {{@$asessment['sign_in']['pasien_konfirmasi']['identitas_dan_gelang_pasien'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Lokasi operasi</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][pasien_konfirmasi][lokasi_operasi]" value="Ya" {{@$asessment['sign_in']['pasien_konfirmasi']['lokasi_operasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Prosedur</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][pasien_konfirmasi][prosedur]" value="Ya" {{@$asessment['sign_in']['pasien_konfirmasi']['prosedur'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Surat ijin operasi</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][pasien_konfirmasi][surat_ijin_operasi]" value="Ya" {{@$asessment['sign_in']['pasien_konfirmasi']['surat_ijin_operasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>2. Lokasi operasi sudah diberi tanda</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][lokasi_operasi][diberi_tanda]" value="Ya" {{@$asessment['sign_in']['lokasi_operasi']['diberi_tanda'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>3. Mesin dan obat-obatan anestesi sudah dicek lengkap</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][mesin_dan_obat][lengkap]" value="Ya" {{@$asessment['sign_in']['mesin_dan_obat']['lengkap'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>4. Pulse oximeter sudah terpasang dan berfungsi</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][pulse_oximeter][terpasang]" value="Ya" {{@$asessment['sign_in']['pulse_oximeter']['terpasang'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>5. Apakah pasien mempunyai riwayat alergi</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][riwayat_alergi][ya]" value="Ya" {{@$asessment['sign_in']['riwayat_alergi']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_in][riwayat_alergi][tidak]" value="Tidak" {{@$asessment['sign_in']['riwayat_alergi']['tidak'] == "Tidak"}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>6. Kesulitan bernafas / risiko aspirasi dan menggunakan peralatan bantuan ?</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][kesulitan_bernafas][ya]" value="Ya" {{@$asessment['sign_in']['kesulitan_bernafas']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_in][kesulitan_bernafas][tidak]" value="Tidak" {{@$asessment['sign_in']['kesulitan_bernafas']['tidak'] == "Tidak"}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>7. Risiko kehilangan darah > 500 ml (7 ml / kg BB pada anak)</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][resiko_kehilangan_darah][ya]" value="Ya" {{@$asessment['sign_in']['resiko_kehilangan_darah']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_in][resiko_kehilangan_darah][tidak]" value="Tidak" {{@$asessment['sign_in']['resiko_kehilangan_darah']['tidak'] == "Tidak"}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>8. Dua akses intravena/akses sentral dan rencana terapi cairan</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][dua_akses_intravena][ya]" value="Ya" {{@$asessment['sign_in']['dua_akses_intravena']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_in][dua_akses_intravena][tidak]" value="Tidak" {{@$asessment['sign_in']['dua_akses_intravena']['tidak'] == "Tidak"}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>

            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2" style="text-align: center; font-size: 18px !important; background-color: rgb(78, 78, 218); color: white;"><label for="">TIME OUT</label></td>
                  </tr>
                  <tr>
                    <td>Pukul</td>
                    <td>
                      <input type="datetime-local" name="fisik[time_out][pukul]" class="form-control" placeholder="Pukul" value="{{ @$asessment['time_out']['pukul'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td><b>1. Konfirmasi seluruh anggota tim memperkenalkan nama dan perannya masing-masing</b></td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][konfirmasi_seluruh_anggota_tim][perkenalkan_nama_dan_peran]" value="Ya" {{@$asessment['time_out']['konfirmasi_seluruh_anggota_tim']['perkenalkan_nama_dan_peran'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>2. Dokter bedah, dokter anestesi dan perawat melakukan konfirmasi secara verbal</b></td>
                  </tr>
                  <tr>
                    <td>- Nama Pasien</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][konfirmasi_secara_verbal][nama_pasien]" value="Ya" {{@$asessment['time_out']['konfirmasi_secara_verbal']['nama_pasien'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Prosedur</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][konfirmasi_secara_verbal][prosedur]" value="Ya" {{@$asessment['time_out']['konfirmasi_secara_verbal']['prosedur'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Lokasi dimana insisi akan dibuat</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][konfirmasi_secara_verbal][lokasi_insisi_dibuat]" value="Ya" {{@$asessment['time_out']['konfirmasi_secara_verbal']['lokasi_insisi_dibuat'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>3. Apakah antibiotik profilaksis sudah diberikan 60 menit sebelunya?</b></td>
                  </tr>
                  <tr>
                    <td>- Nama antibiotik yang diberikan</td>
                    <td>
                      <input type="text" class="form-control" name="fisik[time_out][antibiotik_profilaksis][nama_antibiotik]" value="{{@$asessment['time_out']['antibiotik_profilaksis']['nama_antibiotik']}}">
                    </td>
                  </tr>
                  <tr>
                    <td>- Dosis antibiotik yang diberikan</td>
                    <td>
                      <input type="text" class="form-control" name="fisik[time_out][antibiotik_profilaksis][dosis_antibiotik]" value="{{@$asessment['time_out']['antibiotik_profilaksis']['dosis_antibiotik']}}">
                    </td>
                  </tr>
                  <tr>
                    <td><b>3. Mesin dan obat-obatan anestesi sudah dicek lengkap</b></td>
                    <td>
                      <input type="checkbox" name="fisik[sign_in][mesin_dan_obat][lengkap]" value="Ya" {{@$asessment['sign_in']['mesin_dan_obat']['lengkap'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>4. Antisipasi Kejadian Kritis</b></td>
                  </tr>
                  <tr>
                    <td colspan="2">a. Ahli Bedah</td>
                  </tr>
                  <tr>
                    <td>- Apakah ada kejadian kritis/langkah yang tidak rutin</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_bedah][ada_kejadian_kritis]" value="Ya" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['ada_kejadian_kritis'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_bedah][ada_kejadian_kritis]" value="Tidak" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['ada_kejadian_kritis'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Estimasi lama operasi</td>
                    <td>
                      <input type="text" class="form-control" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_bedah][estimasi_lama_operasi]" value="{{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['estimasi_lama_operasi']}}" placeholder="Menit">
                    </td>
                  </tr>
                  <tr>
                    <td>- Apakah ada antisipasi kehilangan darah</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_bedah][antisipasi_kehilangan_darah]" value="Ya" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['antisipasi_kehilangan_darah'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_bedah][antisipasi_kehilangan_darah]" value="Tidak" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['antisipasi_kehilangan_darah'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">b. Ahli Anestesi</td>
                  </tr>
                  <tr>
                    <td>- Apakah ada perhatian khusus terhadap pasien</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_anestesi][perhatian_khusus]" value="Ya" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_anestesi']['perhatian_khusus'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][ahli_anestesi][perhatian_khusus]" value="Tidak" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['ahli_anestesi']['perhatian_khusus'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">c. Perawat</td>
                  </tr>
                  <tr>
                    <td>- Sterilitas sudah dikonfirmasikan ?</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][perawat][sterilitas_dikonfirmasi]" value="Ya" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['perawat']['sterilitas_dikonfirmasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][perawat][sterilitas_dikonfirmasi]" value="Tidak" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['perawat']['sterilitas_dikonfirmasi'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Apakah ada perlengkapan terhadap kejadian kritis / perhatian lain ?</td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][perawat][perlengkapan_terhadap]" value="Ya" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['perawat']['perlengkapan_terhadap'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[time_out][antisipasi_kejadian_kritis][perawat][perlengkapan_terhadap]" value="Tidak" {{@$asessment['time_out']['antisipasi_kejadian_kritis']['perawat']['perlengkapan_terhadap'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Jumlah kasa awal</td>
                    <td>
                      <input type="text" class="form-control" name="fisik[time_out][antisipasi_kejadian_kritis][perawat][jumlah_kasa_awal]" value="{{@$asessment['time_out']['antisipasi_kejadian_kritis']['perawat']['jumlah_kasa_awal']}}" placeholder="Menit">
                    </td>
                  </tr>
                  <tr>
                    <td><b>5. Apakah foto Rontgen/ CT - Scan dan MRI telah ditayangkan ?</b></td>
                    <td>
                      <input type="checkbox" name="fisik[time_out][foto_rontgen][ditayangkan]" value="Sudah" {{@$asessment['time_out']['foto_rontgen']['ditayangkan'] == "Sudah" ? "checked" : ""}}>
                      <label>Sudah</label>
                      <input type="checkbox" name="fisik[time_out][foto_rontgen][ditayangkan]" value="Belum" {{@$asessment['time_out']['foto_rontgen']['ditayangkan'] == "Belum" ? "checked" : ""}}>
                      <label>Belum</label>
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>

            <div class="col-md-12">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2" style="text-align: center; font-size: 18px !important; background-color: rgb(78, 78, 218); color: white;"><label for="">SIGN OUT</label></td>
                  </tr>
                  <tr>
                    <td>Pukul</td>
                    <td>
                      <input type="datetime-local" name="fisik[sign_out][pukul]" class="form-control" placeholder="Pukul" value="{{ @$asessment['sign_out']['pukul'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>1. Perawat melakukan konfirmasi secara verbal dengan tim</b></td>
                  </tr>
                  <tr>
                    <td>- Nama prosedur tindakan telah dicatat</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_out][perawat_melakukan_konfirmasi][nama_prosedur]" value="Ya" {{@$asessment['sign_out']['perawat_melakukan_konfirmasi']['nama_prosedur'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Instrumen kasa, dan jarum telah dihitung dengan benar</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_out][instrumen_kasa][dihitung_dengan_benar]" value="Ya" {{@$asessment['sign_out']['instrumen_kasa']['dihitung_dengan_benar'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>

                      <table style="border: 1px solid black;">
                        <tr style="border: 1px solid black; text-align: center;">
                          <td style="border: 1px solid black;">Item Instrumen</td>
                          <td style="border: 1px solid black;">Pra</td>
                          <td style="border: 1px solid black;">Intra (+)</td>
                          <td style="border: 1px solid black;">Post</td>
                        </tr>
                        <tr style="border: 1px solid black; text-align: center;">
                          <td style="border: 1px solid black;">Kasa</td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][kasa][pra]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['kasa']['pra']}}">
                          </td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][kasa][intra]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['kasa']['intra']}}">
                          </td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][kasa][post]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['kasa']['post']}}">
                          </td>
                        </tr>
                        <tr style="border: 1px solid black; text-align: center;">
                          <td style="border: 1px solid black;">Jarum</td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][jarum][pra]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['jarum']['pra']}}">
                          </td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][jarum][intra]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['jarum']['intra']}}">
                          </td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][jarum][post]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['jarum']['post']}}">
                          </td>
                        </tr>
                        <tr style="border: 1px solid black; text-align: center;">
                          <td style="border: 1px solid black;">Depper</td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][depper][pra]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['depper']['pra']}}">
                          </td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][depper][intra]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['depper']['intra']}}">
                          </td>
                          <td style="border: 1px solid black;">
                            <input type="text" name="fisik[sign_out][instrumen_kasa][item_instrumen][depper][post]" class="form-control" value="{{@$asessment['sign_out']['instrumen_kasa']['item_instrumen']['depper']['post']}}">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>- Spesimen telah diberi label (termasuk nama pasien dan asal jaringan spesimen)</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_out][perawat_melakukan_konfirmasi][spesimen]" value="Ya" {{@$asessment['sign_out']['perawat_melakukan_konfirmasi']['spesimen'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_out][perawat_melakukan_konfirmasi][spesimen]" value="Tidak" {{@$asessment['sign_out']['perawat_melakukan_konfirmasi']['spesimen'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Adakah masalah dengan peralatan selama operasi</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_out][perawat_melakukan_konfirmasi][masalah_perawatan_operasi]" value="Ya" {{@$asessment['sign_out']['perawat_melakukan_konfirmasi']['masalah_perawatan_operasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_out][perawat_melakukan_konfirmasi][masalah_perawatan_operasi]" value="Tidak" {{@$asessment['sign_out']['perawat_melakukan_konfirmasi']['masalah_perawatan_operasi'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>2. Operator dokter bedah, dokter anestesi dan perawat</b></td>
                  </tr>
                  <tr>
                    <td>- Apakah ada perhatian khusus untuk pemulihan dan penatalaksanaan pasien ?</td>
                    <td>
                      <input type="checkbox" name="fisik[sign_out][operator_dokter_bedah][perhatian_khusus_pasien]" value="Ya" {{@$asessment['sign_out']['operator_dokter_bedah']['perhatian_khusus_pasien'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" name="fisik[sign_out][operator_dokter_bedah][perhatian_khusus_pasien]" value="Tidak" {{@$asessment['sign_out']['operator_dokter_bedah']['perhatian_khusus_pasien'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label> <br>
                      <textarea name="fisik[sign_out][operator_dokter_bedah][perhatian_khusus_pasien_detail]" id="" style="width: 100%;" rows="10">{{@$asessment['sign_out']['operator_dokter_bedah']['perhatian_khusus_pasien_detail']}}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>Tanggal Tindakan :</td>
                    <td>
                      <input type="datetime-local" name="fisik[sign_out][tanggal_tindakan]" class="form-control" placeholder="Tanggal Tindakan" value="{{ @$asessment['sign_out']['tanggal_tindakan'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan</button>
            </div>
            
          </div>

        </div>

      </form>
    </div>

  </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(".skin-red").addClass("sidebar-collapse");
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href") // activated tab
            // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);
    </script>
@endsection
