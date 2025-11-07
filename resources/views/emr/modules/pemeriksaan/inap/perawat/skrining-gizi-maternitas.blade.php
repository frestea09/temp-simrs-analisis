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
</style>
@section('header')
    <h1>skrining</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
        </h3>
    </div>
    <div class="box-body">
      <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        @include('emr.modules.addons.profile')
        <form method="POST" action="{{ url('emr-soap/pemeriksaan-gizi-maternitas/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12">
                @include('emr.modules.addons.tab-gizi')
                {{ csrf_field() }}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                {!! Form::hidden('unit', $unit) !!}
                {!! Form::hidden('asessment_id', @$riwayat->id) !!}
              </div>
              <br>
              <div class="col-md-6">
                <h5 class="text-center"><b>SKRINING NUTRISI MATERNITAS</b></h5>
                <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                      <td colspan="2" style="width: 50%; font-weight:bold;">Skrining kehamilan dan nifas (Berdasarkan sumber: RSCM)</td>
                  </tr>
                  <tr>
                      <td colspan="2">1. Apakah asupan makan berkurang, karena tidak nafsu makan?</td>
                      <td style="vertical-align: middle; width: 20%;">
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter1]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter1'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label">Ya</label>
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter1]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter1'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">2. Ada gangguan metabolisme (DM, gangguan fungsi tiroid, infeksi kronis, seperti HIV/AIDS, TB, Lupus, Lain-lain)</td>
                      <td style="vertical-align: middle; width: 20%;">
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter2'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label">Ya</label>
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter2'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                          <input type="text" class="form-control" placeholder="Sebutkan jika lain-lain" name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2_lain]" value="{{ @$skrining['skrining_kehamilan_dan_nifas']['parameter2_lain'] }}">
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">3. Ada penambahan berat badan yang kurang atau lebih selama kehamilan?</td>
                      <td style="vertical-align: middle; width: 20%;">
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter3]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter3'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label">Ya</label>
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter3]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter3'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">4. Nilai Hb < 10 g/dl atau HCT < 30%</td>
                      <td style="vertical-align: middle; width: 20%;">
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter4]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter4'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label">Ya</label>
                          <input class="form-check-input"
                              name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter4]"
                              {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter4'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="3" style="width: 50%; font-weight:bold;">Total Skor</td>
                  </tr>
                  <tr>
                      <td colspan="3" style="width: 50%; font-weight:bold;">
                          <ul>
                              <li>Jika jawaban ya 1 s/d 3 rujuk ke dietisien</li>
                              <li>Jika jawaban ya > 3, rujuk ke Dokter Spesialis Gizi Klinik</li>
                          </ul>
                      </td>
                  </tr>
                  <tr>
                    <td style="width: 50%;">Berat Badan Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][berat_badan]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$skrining['berat_badan'] == 'Berat badan sangat kurang' ? 'selected' : '' }} value="Berat badan sangat kurang">Berat badan sangat kurang <b>(<-3)</b></option>
                            <option {{ @$skrining['berat_badan'] == 'Berat badan kurang' ? 'selected' : '' }} value="Berat badan kurang">Berat badan kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$skrining['berat_badan'] == 'Berat badan normal' ? 'selected' : '' }} value="Berat badan normal">Berat badan normal <b>(-2 sd +1)</b></option>
                            <option {{ @$skrining['berat_badan'] == 'Risiko berat badan lebih' ? 'selected' : '' }} value="Risiko berat badan lebih">Risiko berat badan lebih <b>(>+1)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Panjang Badan atau Tinggi Badan Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][panjang_badan]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$skrining['panjang_badan'] == 'Sangat pendek' ? 'selected' : '' }} value="Sangat pendek">Sangat pendek <b>(<-3)</b></option>
                            <option {{ @$skrining['panjang_badan'] == 'Pendek' ? 'selected' : '' }} value="Pendek">Pendek <b>(-3 sd <-2)</b></option>
                            <option {{ @$skrining['panjang_badan'] == 'Normal' ? 'selected' : '' }} value="Normal">Normal <b>(-2 sd +3)</b></option>
                            <option {{ @$skrining['panjang_badan'] == 'Tinggi' ? 'selected' : '' }} value="Tinggi">Tinggi <b>(>+3)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Berat Badan Menurut Panjang Badan Atau Tinggi Badan <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][berat_badan_menurut_tinggi_badan]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$skrining['berat_badan_menurut_tinggi_badan'] == 'Gizi buruk' ? 'selected' : '' }} value="Gizi buruk">Gizi buruk <b>(<-3)</b></option>
                            <option {{ @$skrining['berat_badan_menurut_tinggi_badan'] == 'Gizi kurang' ? 'selected' : '' }} value="Gizi kurang">Gizi kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$skrining['berat_badan_menurut_tinggi_badan'] == 'Gizi baik' ? 'selected' : '' }} value="Gizi baik">Gizi baik <b>(-2 sd +1)</b></option>
                            <option {{ @$skrining['berat_badan_menurut_tinggi_badan'] == 'Berisiko gizi lebih' ? 'selected' : '' }} value="Berisiko gizi lebih">Berisiko gizi lebih <b>(>+1 sd +2)</b></option>
                            <option {{ @$skrining['berat_badan_menurut_tinggi_badan'] == 'Gizi lebih' ? 'selected' : '' }} value="Gizi lebih">Gizi lebih <b>(>+2 sd +3)</b></option>
                            <option {{ @$skrining['berat_badan_menurut_tinggi_badan'] == 'Obesitas' ? 'selected' : '' }} value="Obesitas">Obesitas <b>(>+3)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Index Masa Tubuh (IMT) Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][imt_bayi]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$skrining['imt_bayi'] == 'Gizi buruk' ? 'selected' : '' }} value="Gizi buruk">Gizi buruk <b>(<-3)</b></option>
                            <option {{ @$skrining['imt_bayi'] == 'Gizi kurang' ? 'selected' : '' }} value="Gizi kurang">Gizi kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$skrining['imt_bayi'] == 'Gizi baik' ? 'selected' : '' }} value="Gizi baik">Gizi baik <b>(-2 sd +1)</b></option>
                            <option {{ @$skrining['imt_bayi'] == 'Berisiko gizi lebih' ? 'selected' : '' }} value="Berisiko gizi lebih">Berisiko gizi lebih <b>(>+1 sd +2)</b></option>
                            <option {{ @$skrining['imt_bayi'] == 'Gizi lebih' ? 'selected' : '' }} value="Gizi lebih">Gizi lebih <b>(>+2 sd +3)</b></option>
                            <option {{ @$skrining['imt_bayi'] == 'Obesitas' ? 'selected' : '' }} value="Obesitas">Obesitas <b>(>+3)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Index Masa Tubuh (IMT) Menurut Umur <br> <b>anak usia 5 - 18 tahun</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][imt_anak]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$skrining['imt_anak'] == 'Gizi kurang' ? 'selected' : '' }} value="Gizi kurang">Gizi kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$skrining['imt_anak'] == 'Gizi baik' ? 'selected' : '' }} value="Gizi baik">Gizi baik <b>(-2 sd +1)</b></option>
                            <option {{ @$skrining['imt_anak'] == 'Gizi lebih' ? 'selected' : '' }} value="Gizi lebih">Gizi lebih <b>(+1 sd +2)</b></option>
                            <option {{ @$skrining['imt_anak'] == 'Obesitas' ? 'selected' : '' }} value="Obesitas">Obesitas <b>(>+2)</b></option>
                        </select>
                    </td>
                </tr>
                  <tr>
                      <td colspan="2" style="width: 50%; font-weight: bold;">Untuk pasien dengan masalah Ginekologi / Onkologi</td>
                  </tr>
                  <tr>
                      <td colspan="2" style="font-weight: bold;">1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan?</td>
                  </tr>
                  <tr>
                      <td style="vertical-align: middle; width: 20%;" colspan="3">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1'] == 'Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir)' ? 'checked' : '' }}
                                  type="radio" value="Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir)">
                              <label class="form-check-label" style="font-weight: 400;">Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir) (0)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1'] == 'Tidak yakin (tanyakan apakah baju/celana terasa longgar)' ? 'checked' : '' }}
                                  type="radio" value="Tidak yakin (tanyakan apakah baju/celana terasa longgar)">
                              <label class="form-check-label" style="font-weight: 400;">Tidak yakin (tanyakan apakah baju/celana terasa longgar) (2)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1'] == 'ya' ? 'checked' : '' }}
                                  type="radio" value="ya">
                              <label class="form-check-label" style="font-weight: 400;">Ya, berapa penurunan berat badan tersebut?</label>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td>&nbsp;</td>
                      <td>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '1 - 5 Kg' ? 'checked' : '' }}
                                  type="radio" value="1 - 5 Kg">
                              <label class="form-check-label" style="font-weight: 400;">1 - 5 Kg (1)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '6 - 10 Kg' ? 'checked' : '' }}
                                  type="radio" value="6 - 10 Kg">
                              <label class="form-check-label" style="font-weight: 400;">6 - 10 Kg (2)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '11 - 15 Kg' ? 'checked' : '' }}
                                  type="radio" value="11 - 15 Kg">
                              <label class="form-check-label" style="font-weight: 400;">11 - 15 Kg (3)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '> 15 Kg' ? 'checked' : '' }}
                                  type="radio" value="> 15 Kg">
                              <label class="form-check-label" style="font-weight: 400;">> 15 Kg (4)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == 'Tidak yakin' ? 'checked' : '' }}
                                  type="radio" value="Tidak yakin">
                              <label class="form-check-label" style="font-weight: 400;"> Tidak yakin (2)</label>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="font-weight: bold;">2. Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun? (Misalnya asupan makan hanya 1/4 dari biasanya)</td>
                  </tr>
                  <tr>
                      <td style="vertical-align: middle; width: 20%;" colspan="3">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter2]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter2'] == 'Tidak' ? 'checked' : '' }}
                                  type="radio" value="Tidak">
                              <label class="form-check-label" style="font-weight: 400;">Tidak (0)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter2]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter2'] == 'Ya' ? 'checked' : '' }}
                                  type="radio" value="Ya">
                              <label class="form-check-label" style="font-weight: 400;">Ya (1)</label>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="font-weight: bold;">3. Sakit Berat?</td>
                  </tr>
                  <tr>
                      <td style="vertical-align: middle; width: 20%;" colspan="3">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter3]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter3'] == 'Tidak' ? 'checked' : '' }}
                                  type="radio" value="Tidak">
                              <label class="form-check-label" style="font-weight: 400;">Tidak (0)</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter3]"
                                  {{ @$skrining['pasien_ginekologi_onkologi']['parameter3'] == 'Ya' ? 'checked' : '' }}
                                  type="radio" value="Ya">
                              <label class="form-check-label" style="font-weight: 400;">Ya (2)</label>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 30%;">Kesimpulan & Tindak lanjut</td>
                      <td colspan="2"> 
                          <div >
                              <input class="form-check-input" name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][kesimpulan_tindak_lanjut][total_skor_lebih_2]"
                              {{ @$skrining['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_lebih_2'] == 'true' ? 'checked' : '' }} type="checkbox"
                              value="true">
                              <label class="form-check-label">Total Skor > 2, rujuk ke dietisien untuk asesmen gizi</label>
                          </div>
                          <div >
                              <input class="form-check-input" name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][kesimpulan_tindak_lanjut][total_skor_kurang_2]"
                              {{ @$skrining['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_kurang_2'] == 'true' ? 'checked' : '' }} type="checkbox"
                              value="true">
                              <label class="form-check-label">Total Skor < 2, Skrining ulang 7 hari</label>
                          </div>
                      </td>
                  </tr>
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      Diverifikasi oleh       
                    </td>
                    <td colspan="2">
                      <input type="text" name="fisik[skrining_nutrisi_dewasa][verifikasi][nama]" class="form-control" value="{{ @Auth::user()->name }}" readonly>
                    </td>
                  </tr>
                  @if (@$cppt)
                    @if ($cppt->user->Pegawai->kategori_pegawai == 1)
                    {{-- @if ($cppt->assesment) --}}
                    <tr>
                      <td style="width:50%; font-weight:bold;">
                        Diagnosa
                      </td>
                      <td>
                        {!! @$cppt->assesment !!}
                      </td>
                    </tr>
                    @endif

                  @if (@$cppt->diagnosistambahan)
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      Diagnosa Tambahan
                    </td>
                    <td>
                      {!! @$cppt->diagnosistambahan !!}
                    </td>
                  </tr>
                      
                  @endif
                @endif
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      Dibuat oleh       
                    </td>
                    <td>
                      <select name="user_id" class="select2" style="width: 100%;">
                        @if (@$assesment && !in_array(@$assesment->user_id, [898, 905, 900, 907, 902, 904, 918, 903, 919]))
                          <option value="{{@$assesment->user_id}}" selected>{{@$assesment->user->name}}</option>
                        @endif
                        <option value="898" {{@$assesment->user_id == 898}}>{{baca_user(898)}}</option>
                        <option value="905" {{@$assesment->user_id == 905}}>{{baca_user(905)}}</option>
                        <option value="900" {{@$assesment->user_id == 900}}>{{baca_user(900)}}</option>
                        <option value="907" {{@$assesment->user_id == 907}}>{{baca_user(907)}}</option>
                        <option value="902" {{@$assesment->user_id == 902}}>{{baca_user(902)}}</option>
                        <option value="904" {{@$assesment->user_id == 904}}>{{baca_user(904)}}</option>
                        <option value="918" {{@$assesment->user_id == 918}}>{{baca_user(918)}}</option>
                        <option value="903" {{@$assesment->user_id == 903}}>{{baca_user(903)}}</option>
                        <option value="919" {{@$assesment->user_id == 919}}>{{baca_user(919)}}</option>
                      </select>
                    </td>
                  </tr>
                </table>
                @if (@$nutrisiId != 'Y')
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" type="button" onclick="alert('Mohon pilih data skrining yang akan diverifikasi terlebuh dahulu!')">Verifikasi</button>
                </div>
                @else
                <div class="col-md-12 text-right">
                    <button class="btn btn-success">Verifikasi</button>
                </div>
                @endif
              </div>
              <div class="col-md-6">
                <div class="box box-solid box-warning">
                  <div class="box-header">
                    <h5><b>Riwayat Skrining Gizi Maternitas</b></h5>
                  </div>
                              <div class="box-body table-responsive" style="max-height: 400px">
                                  <table style="width: 100%"
                                      class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                      style="font-size:12px;">
                                      @if (count($riwayats) == 0)
                                          <tr>
                                              <td><i>Belum ada catatan</i></td>
                                          </tr>
                                      @endif
                                      @foreach ($riwayats as $item)
                                          @php
                                              $data = json_decode($item->fisik, true)['skrining_nutrisi_dewasa'];
                                          @endphp
                                          <tr>
                                            <td>
                                              <b>Kesimpulan :</b> {{@$data['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_lebih_2'] ? "Rujuk ke dietisien untuk asesmen gizi" : "Skrining ulang 7 hari"}}<br />
                                              <b>Dibuat oleh:</b> {{ @$item->user->name }}<br />
                                              @if (@$data['verifikasi']['nama'])
                                              <b>Diverifikasi oleh:</b> {{ @$data['verifikasi']['nama'] }}<br />
                                              @endif
                                              <span class="pull-right">
                                                  @if (@$data['verifikasi']['nama'])
                                                      <small class="text-success">Telah Diverifikasi</small>
                                                  @else
                                                      <a href="{{ URL::current() . '?asessment_id='. $item->id }}" class="label label-success">Verifikasi</a>
                                                  @endif
                                                  <small>{{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}</small>
                                              </span>
                                            </td>
                                          </tr>
                                      @endforeach
                                  </table>
                              </div>
                          </div>
                      </div>

                      <br /><br />
                  </div>


              </div>
          </form>
          <br />
          <br />

  </div>
@endsection

@section('script')
  <script type="text/javascript">
      $('.select2').select2();

    function totalSkor(){
      var arr = document.getElementsByClassName('skorSkrining');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalSkorId').value = tot;
    }
  </script>
@endsection
