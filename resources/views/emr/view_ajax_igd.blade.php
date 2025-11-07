<div class='table-responsive'>
    <table class='table-striped table-bordered table-hover table-condensed table' id="dataemr">
        <thead>
            <tr>
                {{-- <th>No</th> --}}
                <th>Pasien</th>
                <th>RM</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Bayar</th>
                <th>SEP</th>
                <th style="width:8%">Tgl. Masuk</th>
                <th style="width:8%">Tgl. Pulang</th>
                <th>Keterangan</th>
                <th>Status</th>
                @if ($unit == 'igd')
                    <th>Kondisi</th>
                    {{-- <th>Cara Daftar</th> --}}
                @endif
                {{-- <th class="text-center">E.RSP</th>   --}}
                {{-- <th class="text-center">LAB</th> --}}
                {{-- <th class="text-center">RAD</th> --}}
                <th class="text-center">EMR</th>
                <th class="text-center">SatuSehat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registrasi as $key => $d)
                @php
                    $cpptDokter = $cppts->where('registrasi_id', $d->id)->where('user_id', $d->userDokter)->isNotEmpty() ;
                    $cpptPerawat = $cppts->where('registrasi_id', $d->id)->where('user_id', '!=', $d->userDokter)->isNotEmpty() ;
                    $asesmenDokter = $asesments->where('registrasi_id', $d->id)->where('user_id', $d->userDokter)->isNotEmpty() ;
                    $asesmenDokter2 = $asesments->where('registrasi_id', $d->id)->where('userdokter_id', $d->userDokter)->isNotEmpty() ;
                    $asesmenPerawat = $asesments->where('registrasi_id', $d->id)->isNotEmpty() ;

                    // Tutup sementara indikator pelayanan IGD

                    $background = '';

                    // if ($cpptDokter || $cpptPerawat) {
                    //   $background = '#d3ffd3';
                    // } else {
                    //   $menit = Carbon\Carbon::parse($d->tgl_reg)->diffInMinutes();
                    //   if ($menit <= 45) {
                    //     $background = '#5090ff';
                    //   } elseif ($menit <= 60) {
                    //     $background = '#ffff8c';
                    //   } elseif ($menit >= 75) {
                    //     $background = '#f15c5c';
                    //   }
                    // }
                @endphp
                <tr style="background-color: {{$background}}">
                    {{-- <td>{{ $no++ }}</td> --}}
                    <td>{{ @$d->nama }}</td>
                    <td>{{ @$d->no_rm }}</td>
                    <td>{{ !empty($d->dokter_id) ? @$d->dokter_dpjp : null }}</td>
                    <td>
                        @if (cek_folio_counts($d->id, $d->poli_id) > 0)
                            {{ !empty(@$d->poli_id) ? @$d->nama_poli : null }}
                        @else
                            <span style="color: red">{{ !empty(@$d->poli_id) ? @$d->nama_poli : null }}</span>
                    </td>
            @endif
            {{-- {{$d->poli_id}} --}}
            <td class="{{ empty($d->no_sep) ? 'text-red' : '' }}">
                {{ baca_carabayar($d->bayar) }}
                @if (!empty($d->tipe_jkn))
                    - {{ $d->tipe_jkn }}
                @endif
            </td>
            <td>{{ @$d->no_sep }}</td>
            <td>
                {{ date('d/m/Y H:i', strtotime($d->tgl_reg)) }}
            </td>
            <td>
                {{ @$d->tgl_pulang ? date('d/m/Y H:i', strtotime($d->tgl_pulang)) : '' }}
            </td>
            <td>
                {{ @$d->status_reg == "I3" ? "Dipulangkan" : (@$d->status_reg == "I2" ? "Diinapkan" : '') }}
                @if (empty($d->resume_igd)) <br>
                    <span style="color:red">(Resume IGD Belum dibuat)</span>
                @endif
            </td> 
            <td>
                {{ @$d->keteranganStatus }}
            </td>
            

            {{-- <td class="text-center">
              <a target="__blank" href="{{ url('tindakan/labJalan/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
              @if (cek_hasil_lab($d->id) >= 1)
                <a target="__blank" href="{{ url('pemeriksaanlab/pasien/'.$d->id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
              @endif
            </td> --}}
            {{-- <td class="text-center">
              <a target="__blank" href="{{ url('tindakan/radJalan/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
              @if (cek_ekspertise($d->id) >= 1)
                  <a target="__blank" href="{{ url('radiologi/ekspertise-pasien/'.$d->id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
              @endif
            </td> --}}
            {{-- <td class="text-center" style="width:200px;">
              <button type="button" class="btn btn-primary btn-sm btn-flat btn-add-resep" data-id="{{ $d->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
              <button type="button" class="btn btn-warning btn-sm btn-flat btn-history-resep" data-id="{{ $d->id }}"><i class="fa fa-bars" aria-hidden="true"></i></button>
            </td>  --}}
            @if ($unit == 'igd')
                <td>
                    @if ($cpptDokter || $asesmenDokter || $asesmenDokter2)
                        <span class="text-success"><i>Sudah Diperiksa</i></span>
                    @else
                        <span class="text-danger"><i>Belum Diperiksa</i></span>
                    @endif
                </td>
                {{-- <td>
                    {{ @$d->cara_registrasi }}
                </td> --}}
            @endif
            
            <td class="text-center">
                @if ($d->poli_id == 14 && $d->keteranganStatus == 'lama' && Auth::user()->pegawai->kategori_pegawai == 1)
                    @if ($cpptPerawat || $asesmenPerawat)
                        <a href="{{ url('emr/soap/' . $unit . '/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}"
                            class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                            @if (empty(@$d->tte_resume_pasien_status))
                                <br>
                                <span><i class="blink_violet">
                                    E-Resume belum di TTE
                                </i></span>
                            @endif
                    @else
                        <a href="{{ url('emr/soap/' . $unit . '/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}"
                            class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                    @endif
                @else
                    @if ($cpptPerawat || $asesmenPerawat)
                        <a href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}"
                            class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                        @if (empty(@$d->resume_igd->tte))
                            <br>
                            <span><i class="blink_violet">
                                E-Resume belum di TTE
                            </i></span>
                        @endif
                    @else
                        <a href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}"
                            class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                    @endif
                @endif
            </td>
            <td class="text-center">
                @if (@$d->id_encounter_ss != null)
                    <i class="fa fa-check"></i>
                @else
                    <i class="fa fa-times"></i>
                @endif
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="echocardiogramModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-horizontal" id="formEkspertise">
                    {{ csrf_field() }}
                    <input type="hidden" name="registrasi_id" value="">
                    <input type="hidden" name="pasien_id" value="">
                    <input type="hidden" name="jenis" value="TA">
                    <input type="hidden" name="id" value="">
                    <div class="table-responsive">
                        <table class="table-condensed table-bordered table">
                            <tbody>
                                <tr>
                                    <th>Pasien </th>
                                    <td class="nama"></td>
                                    <th>Umur </th>
                                    <td class="umur"></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin </th>
                                    <td class="jk" colspan="1"></td>
                                    <th>No. RM </th>
                                    <td class="no_rm" colspan="2"></td>
                                </tr>
                                <tr>
                                    <th>Fungsi Sistolik LV</th>
                                    <td>
                                        <select name="fungsi_sistolik" class="form-control select2" style="width: 100%">
                                            <option value="baik">Baik</option>
                                            <option value="cukup">Cukup</option>
                                            <option value="menurun">Menurun</option>
                                        </select>
                                    </td>
                                    <th>Dimensi Ruang Jantung</th>
                                    <td>
                                        <select name="dimensi_ruang_jantung" class="form-control select2"
                                            style="width: 100%">
                                            <option value="normal">Normal</option>
                                            <option value="la_dilatasi">La dilatasi</option>
                                            <option value="lv_dilatasi">Lv dilatasi</option>
                                            <option value="ra_dilatasi">Ra dilatasi</option>
                                            <option value="rv_dilatasi">Rv dilatasi</option>
                                            <option value="semua_dilatasi">semua dilatasi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ef</th>
                                    <td>
                                        <input type="number" name="ef" class="form-control">
                                    </td>
                                    <th>Lv</th>
                                    <td>
                                        <select name="lv" class="form-control select2" style="width: 100%">
                                            <option value="konsentrik(+)">Konsentrik (+)</option>
                                            <option value="Eksentrik(+)">Eksentrik(+)</option>
                                            <option value="(-)">(-)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Global</th>
                                    <td>
                                        <select name="global" class="form-control select2" style="width: 100%">
                                            <option value="normokinetik">Normokinetik</option>
                                            <option value="hipokinetik">Hipokinetik</option>
                                            <option value="(-)">(-)</option>
                                        </select>
                                    </td>
                                    <th>Fungsi Sistolik Rv</th>
                                    <td>
                                        <select name="fungsi_sistolik_rv" class="form-control select2"
                                            style="width: 100%">
                                            <option value="baik">Baik</option>
                                            <option value="menurun">Menurun</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tapse</th>
                                    <td>
                                        <select name="tapse" class="form-control select2" style="width: 100%">
                                            <option value="<_16">
                                                < 16</option>
                                            <option value=">_16">> 16</option>
                                        </select>
                                    </td>
                                    <th>Katup-Katup Jantung Mitral</th>
                                    <td>
                                        <select name="katup_katup_jantung_mitral" class="form-control select2"
                                            style="width: 100%">
                                            <option value="ms_ringan">ms_ringan</option>
                                            <option value="ms_sedang">ms_sedang</option>
                                            <option value="ms_berat">ms_berat</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Katup-Katup Jantung Aorta</th>
                                    <td>
                                        <select name="katup_katup_jantung_aorta" class="form-control select2"
                                            style="width: 100%">
                                            <option value="3_cuspis">3 cuspis</option>
                                            <option value="2_cuspis">2 cuspis</option>
                                        </select>
                                    </td>
                                    <th>Katup-Katup Jantung Trikuspid</th>
                                    <td>
                                        <select name="katup_katup_jantung_trikuspid" class="form-control select2"
                                            style="width: 100%">
                                            <option value="tr_ringan">Tr Ringan</option>
                                            <option value="tr_sedang">Tr Sedang</option>
                                            <option value="tr_berat">Tr Berat</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Katup-Katup Jantung Aorta Lain-Lain</th>
                                    <td>
                                        <input type="text" name="katup_katup_jantung_aorta_cuspis"
                                            class="form-control">
                                    </td>
                                    <th>Katup-Katup Jantung Pulmonal</th>
                                    <td>
                                        <select name="katup_katup_jantung_pulmonal" class="form-control select2"
                                            style="width: 100%">
                                            <option value="pr_ringan">Pr Ringan</option>
                                            <option value="pr_sedang">Pr Sedang</option>
                                            <option value="pr_berat">Pr Berat</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Catatan Dokter</th>
                                    <td colspan="3">
                                        <textarea name="catatan_dokter" class="form-control wysiwyg"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kesimpulan</th>
                                    <td colspan="3">
                                        <textarea name="kesimpulan" class="form-control wysiwyg"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
            </div>
        </div>
    </div>

</div>
