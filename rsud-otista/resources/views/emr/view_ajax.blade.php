<div class='table-responsive'>
    <div class="mt-2 text-danger">
        <marquee behavior="scroll" direction="left"><i>* Untuk Menampilkan RME harap memanggil pasien terlebih dahulu</i></marquee>
    </div>
    <table class='table-striped table-bordered table-hover table-condensed table' id="datas">
        <thead>
            <tr>
                {{-- <th>No</th> --}}
                <th>Pasien</th>
                <th>RM</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Bayar</th>
                <th style="width:8%">Tgl.</th>
                <th>Status</th>
                @if ($unit == 'jalan')
                    <th>Kondisi</th>
                    <th>Cara Daftar</th>
                @endif
                {{-- <th class="text-center">E.RSP</th>   --}}
                {{-- <th class="text-center">LAB</th> --}}
                {{-- <th class="text-center">RAD</th> --}}
                <th class="text-center">EMR</th>
                <th class="text-center">SatuSehat</th>
                <th class="text-center">Status</th>
                <th class="text-center">i-care</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registrasi as $key => $d)
                @php
                    // $cpptDokter = $cppts->where('registrasi_id', $d->id)->where('user_id', $d->userDokter)->isNotEmpty() ;
                    // $hasilDischarge = '-';
                    // $foundDischarge = false;

                    // $planningDokter = App\Emr::where('registrasi_id', $d->id)->where('user_id', $d->userDokter)->orderBy('id', 'DESC')->first();
                    // if ($planningDokter && $planningDokter->discharge) {
                    //     $discharge = json_decode($planningDokter->discharge, true);
                    //     $planning = $discharge['dischargePlanning'] ?? [];

                    //     foreach ($planning as $plan) {
                    //         if (!empty($plan['dipilih'])) {
                    //             $hasilDischarge = $plan['dipilih'];
                    //             $foundDischarge = true;
                    //             break;
                    //         }
                    //     }
                    // }
                    // elseif (!$foundDischarge) {
                    //     $cpptPasien = App\Emr::where('pasien_id', $d->pasien_id)->where('registrasi_id', '<', $d->id)->orderBy('id', 'DESC')->get();
                    //     foreach ($cpptPasien as $c) {
                    //         if ($c->discharge) {
                    //             $discharge = json_decode($c->discharge, true);
                    //             $planning = $discharge['dischargePlanning'] ?? [];

                    //             foreach ($planning as $plan) {
                    //                 if (!empty($plan['dipilih'])) {
                    //                     $hasilDischarge = $plan['dipilih'];
                    //                     $foundDischarge = true;
                    //                     break 2;
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }
                    // $cpptPerawat = $cppts->where('registrasi_id', $d->id)->where('user_id', '!=', $d->userDokter)->isNotEmpty() ;
                    // $asesmenDokter = $asesments->where('registrasi_id', $d->id)->where('user_id', $d->userDokter)->isNotEmpty() ;
                    // $asesmenDokter2 = $asesments->where('registrasi_id', $d->id)->where('userdokter_id', $d->userDokter)->isNotEmpty() ;
                    // $asesmenPerawat = $asesments->where('registrasi_id', $d->id)->isNotEmpty() ;
                @endphp
                <tr>
                    {{-- <td>{{ $no++ }}</td> --}}
                    <td>{{ @$d->nama }}</td>
                    <td>{{ @$d->no_rm }}</td>
                    <td>{{ !empty($d->dokter_id) ? @$d->dokter_dpjp : null }}</td>
                    <td 
                        class="poli-name" 
                        data-id="{{ $d->id }}" 
                        data-poli="{{ $d->poli_id }}" 
                        data-nama="{{ $d->nama_poli }}"> 
                        <i class="loading"><small>memuat...</small></i>
                    </td> 
            {{-- {{$d->poli_id}} --}}
            <td>{{ @$d->carabayar }}
                @if (!empty($d->tipe_jkn))
                    - {{ $d->tipe_jkn }}
                @endif
            </td>
            <td>
                {{ date('d/m/Y H:i', strtotime($d->tgl_reg)) }}
            </td>
            <td>
                {{ @$d->keteranganStatus }}
            </td>
            

           
           @if ($unit == 'jalan')
                <td class="status-periksa" 
                    data-id="{{ $d->id }}" 
                    data-dokter="{{ $d->userDokter }}">
                    <i class="loading"><small>memuat...</small></i>
                </td>
                <td>
                    {{ @$d->cara_registrasi }}
                </td>
            @endif

            
            <td class="status-perawat text-center"
                data-id="{{ $d->id }}"
                data-dokter="{{ $d->userDokter }}"
                data-unit="{{ $unit }}"
                data-poli="{{ $d->poli_id }}"
                data-dpjp="{{ $d->dokter_id }}"
                data-status="{{ $d->keteranganStatus }}"
                data-tte="{{ $d->tte_resume_pasien_status }}">
                <i class="loading"><small>memuat...</small></i>
            </td>
            <td class="text-center">
                @if (@$d->id_encounter_ss != null)
                    <i class="fa fa-check"></i>
                @else
                    <i class="fa fa-times"></i>
                @endif
            </td>
            <td class="status-discharge"
                data-id="{{ $d->id }}"
                data-dokter="{{ $d->userDokter }}"
                data-pasien="{{ $d->pasien_id }}">
                <i class="loading"><small>memuat...</small></i>
            </td>
            <td>
                <a href="{{ url('emr-soap-icare/fkrtl/jalan/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-info"></i>-Care</a>
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
