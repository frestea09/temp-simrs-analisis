<div class="col-md-12">
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen-igd/' . $unit . '/' . $reg->id) }}"
        class="form-horizontal">
        {{ csrf_field() }}
        {!! Form::hidden('registrasi_id', $reg->id) !!}
        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
        {!! Form::hidden('unit', $unit) !!}
        {!! Form::hidden('asessment_id', request()->asessment_id) !!}
        {{-- Anamnesis --}}
        <h4 style="text-align: center; padding: 10px"><b>ASSESMEN AWAL MEDIS PASIEN GAWAT DARURAT</b></h4>

        <div class="col-md-6">
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <tr>
                    <td  style="width:20%; font-weight:bold;">
                        Skala Nyeri
                    </td>
                    <td>
                        <img src="{{asset('Skala-nyeri-wajah.png')}}" style="width: 100%">
                        <input name="asessment[igdAwal][skalaNyeri]" type="range" min="0" max="10" value="{{ @$asessment['igdAwal']['skalaNyeri'] }}" oninput="this.nextElementSibling.value = this.value">
                        <output style="text-align: center; font-weight: bold">{{ @$asessment['igdAwal']['skalaNyeri'] }}</output>
                    </td>
               </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Keluhan Utama
                    </td>
                    <td>
                        <b>ID SATUSEHAT : {{@$satusehat['dokter_id_condition_keluhan_utama']}}</b>
                        <select name="asessment[igdAwal][keluhanUtamaPilihan]" class="select2" style="width: 100%">
                            <option value="">-- Pilih Salah Satu --</option>
                            @if (@$keluhanUtama->children)
                                @foreach ($keluhanUtama->children as $keluhan)
                                    <option value="{{$keluhan->concept_id}}" {{@$asessment['igdAwal']['keluhanUtamaPilihan'] == $keluhan->concept_id ? 'selected' : ''}}>{{$keluhan->fsn_term}} | {{$keluhan->fsn_lang}}</option>
                                @endforeach
                            @endif
                        </select>
                        <textarea class="form-control" name="asessment[igdAwal][keluhanUtama]" style="width: 100%" rows="3">{{ @$asessment['igdAwal']['keluhanUtama'] ? @$asessment['igdAwal']['keluhanUtama'] : @$dataTriage['keluhanUtama']['ket'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Riwayat Penyakit Sekarang
                    </td>
                    <td>
                        <b>ID SATUSEHAT : {{@$satusehat['dokter_id_condition_riwayat_penyakit']}}</b>
                        <select name="asessment[igdAwal][riwayat_penyakit_pilihan]" class="select2" style="width: 100%">
                            <option value="">-- Pilih Salah Satu --</option>
                            @if (@$riwayatPenyakit->children)
                                @foreach ($riwayatPenyakit->children as $riwayat)
                                    <option value="{{$riwayat->concept_id}}" {{@$asessment['igdAwal']['riwayat_penyakit_pilihan'] == $riwayat->concept_id ? 'selected' : ''}}>{{$riwayat->fsn_term}} | {{$riwayat->fsn_lang}}</option>
                                @endforeach
                            @endif
                        </select>
                        <textarea class="form-control" name="asessment[igdAwal][riwayatPenyakit]" style="width: 100%" rows="3">{{ @$asessment['igdAwal']['riwayatPenyakit'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Airway
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Bersih]"
                                {{ @$asessment['igdAwal']['airway']['Bersih'] == 'Bersih' ? 'checked' : '' }} type="checkbox"
                                value="Bersih">
                            <label class="form-check-label">Bersih</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Spontan]"
                                {{ @$asessment['igdAwal']['airway']['Spontan'] == 'Spontan' ? 'checked' : '' }} type="checkbox"
                                value="Spontan">
                            <label class="form-check-label">Spontan</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Dispnoe]"
                                {{ @$asessment['igdAwal']['airway']['Dispnoe'] == 'Dispnoe' ? 'checked' : '' }} type="checkbox"
                                value="Dispnoe">
                            <label class="form-check-label">Dispnoe</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Techipnoe]"
                                {{ @$asessment['igdAwal']['airway']['Techipnoe'] == 'Techipnoe' ? 'checked' : '' }} type="checkbox"
                                value="Techipnoe">
                            <label class="form-check-label">Techipnoe</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Apnoe]"
                                {{ @$asessment['igdAwal']['airway']['Apnoe'] == 'Apnoe' ? 'checked' : '' }} type="checkbox"
                                value="Apnoe">
                            <label class="form-check-label">Apnoe</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Slem]"
                                {{ @$asessment['igdAwal']['airway']['Slem'] == 'Slem' ? 'checked' : '' }} type="checkbox"
                                value="Slem">
                            <label class="form-check-label">Slem</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][airway][Obstruksi]"
                                {{ @$asessment['igdAwal']['airway']['Obstruksi'] == 'Obstruksi' ? 'checked' : '' }} type="checkbox"
                                value="Obstruksi">
                            <label class="form-check-label">Obstruksi</label>
                        </div>
                        <div>
                            <input type="text" class="form-control" name="asessment[igdAwal][airway][dll]" style="width: 100%;"
                            value="{{ @$asessment['igdAwal']['airway']['dll'] }}" placeholder="Lainnya">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Breathing
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][breathing][Ronchi]"
                                {{ @$asessment['igdAwal']['breathing']['Ronchi'] == 'Ronchi' ? 'checked' : '' }} type="checkbox"
                                value="Ronchi">
                            <label class="form-check-label">Ronchi</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][breathing][ronchiKering]"
                                {{ @$asessment['igdAwal']['breathing']['ronchiKering'] == 'ronchiKering' ? 'checked' : '' }} type="checkbox"
                                value="ronchiKering">
                            <label class="form-check-label">Ronchi Kering</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][breathing][Wheezing]"
                                {{ @$asessment['igdAwal']['breathing']['Wheezing'] == 'Wheezing' ? 'checked' : '' }} type="checkbox"
                                value="Wheezing">
                            <label class="form-check-label">Wheezing</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][breathing][Stridor]"
                                {{ @$asessment['igdAwal']['breathing']['Stridor'] == 'Stridor' ? 'checked' : '' }} type="checkbox"
                                value="Stridor">
                            <label class="form-check-label">Stridor</label>
                        </div>
                        <div>
                            <input type="text" class="form-control" name="asessment[igdAwal][breathing][dll]" style="width: 100%;"
                            value="{{ @$asessment['igdAwal']['breathing']['dll'] }}" placeholder="Lainnya">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Circulation
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][circulation][tidakAdaPendarahan]"
                                {{ @$asessment['igdAwal']['circulation']['tidakAdaPendarahan'] == 'tidakAdaPendarahan' ? 'checked' : '' }} type="checkbox"
                                value="tidakAdaPendarahan">
                            <label class="form-check-label">Tidak Ada Pendarahan</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][circulation][pendarahanRingan]"
                                {{ @$asessment['igdAwal']['circulation']['pendarahanRingan'] == 'pendarahanRingan' ? 'checked' : '' }} type="checkbox"
                                value="pendarahanRingan">
                            <label class="form-check-label">Pendarahan Ringan</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][circulation][pendarahanSedang]"
                                {{ @$asessment['igdAwal']['circulation']['pendarahanSedang'] == 'pendarahanSedang' ? 'checked' : '' }} type="checkbox"
                                value="pendarahanSedang">
                            <label class="form-check-label">Pendarahan Sedang</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][circulation][pendarahanBerat]"
                                {{ @$asessment['igdAwal']['circulation']['pendarahanBerat'] == 'pendarahanBerat' ? 'checked' : '' }} type="checkbox"
                                value="pendarahanBerat">
                            <label class="form-check-label">Pendarahan Berat</label>
                        </div>
                        <div>
                            <input type="text" class="form-control" name="asessment[igdAwal][circulation][dll]" style="width: 100%;"
                            value="{{ @$asessment['igdAwal']['circulation']['dll'] }}" placeholder="Lainnya">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Kesadaran
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][kesadaran][composMentis]"
                                {{ @$asessment['igdAwal']['kesadaran']['composMentis'] == 'composMentis' ? 'checked' : '' }} type="checkbox"
                                value="composMentis">
                            <label class="form-check-label">Compos Mentis</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][kesadaran][apatis]"
                                {{ @$asessment['igdAwal']['kesadaran']['apatis'] == 'apatis' ? 'checked' : '' }} type="checkbox"
                                value="apatis">
                            <label class="form-check-label">Apatis</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][kesadaran][delirium]"
                                {{ @$asessment['igdAwal']['kesadaran']['delirium'] == 'delirium' ? 'checked' : '' }} type="checkbox"
                                value="delirium">
                            <label class="form-check-label">Delirium</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][kesadaran][somnolen]"
                                {{ @$asessment['igdAwal']['kesadaran']['somnolen'] == 'somnolen' ? 'checked' : '' }} type="checkbox"
                                value="somnolen">
                            <label class="form-check-label">Somnolen</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][kesadaran][soporoKoma]"
                                {{ @$asessment['igdAwal']['kesadaran']['soporoKoma'] == 'soporoKoma' ? 'checked' : '' }} type="checkbox"
                                value="soporoKoma">
                            <label class="form-check-label">Soporo Koma</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][kesadaran][koma]"
                                {{ @$asessment['igdAwal']['kesadaran']['koma'] == 'koma' ? 'checked' : '' }} type="checkbox"
                                value="koma">
                            <label class="form-check-label">Koma</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Glasgow Coma Scale</td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Mata
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                {{ @$asessment['igdAwal']['glasgow']['mata'] == '4 Spontan' ? 'checked' : '' }} type="radio"
                                value="4 Spontan">
                            <label class="form-check-label">4 Spontan</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                {{ @$asessment['igdAwal']['glasgow']['mata'] == '3 Respon Suara' ? 'checked' : '' }} type="radio"
                                value="3 Respon Suara">
                            <label class="form-check-label">3 Respon Suara</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                {{ @$asessment['igdAwal']['glasgow']['mata'] == '2 Respon Nyeri' ? 'checked' : '' }} type="radio"
                                value="2 Respon Nyeri">
                            <label class="form-check-label">2 Respon Nyeri</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                {{ @$asessment['igdAwal']['glasgow']['mata'] == '1 Tidak Merepson' ? 'checked' : '' }} type="radio"
                                value="1 Tidak Merepson">
                            <label class="form-check-label">1 Tidak Merepson</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Verbal
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                {{ @$asessment['igdAwal']['glasgow']['verbal'] == '5 Sadar Penuh' ? 'checked' : '' }} type="radio"
                                value="5 Sadar Penuh">
                            <label class="form-check-label">5 Sadar Penuh</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                {{ @$asessment['igdAwal']['glasgow']['verbal'] == '4 Bingung' ? 'checked' : '' }} type="radio"
                                value="4 Bingung">
                            <label class="form-check-label">4 Bingung</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                {{ @$asessment['igdAwal']['glasgow']['verbal'] == '3 Kata Kata Tidak Jelas' ? 'checked' : '' }} type="radio"
                                value="3 Kata Kata Tidak Jelas">
                            <label class="form-check-label">3 Kata Kata Tidak Jelas</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                {{ @$asessment['igdAwal']['glasgow']['verbal'] == '2 Hanya Suara' ? 'checked' : '' }} type="radio"
                                value="2 Hanya Suara">
                            <label class="form-check-label">2 Hanya Suara</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                {{ @$asessment['igdAwal']['glasgow']['verbal'] == '1 Tidak Merespon' ? 'checked' : '' }} type="radio"
                                value="1 Tidak Merespon">
                            <label class="form-check-label">1 Tidak Merespon</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Motorik
                    </td>
                    <td>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                {{ @$asessment['igdAwal']['glasgow']['motorik'] == '6 Mengikuti Perintah' ? 'checked' : '' }} type="radio"
                                value="6 Mengikuti Perintah">
                            <label class="form-check-label">6 Mengikuti Perintah</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                {{ @$asessment['igdAwal']['glasgow']['motorik'] == '5 Lokalisir Nyeri' ? 'checked' : '' }} type="radio"
                                value="5 Lokalisir Nyeri">
                            <label class="form-check-label">5 Lokalisir Nyeri</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                {{ @$asessment['igdAwal']['glasgow']['motorik'] == '4 Menolak Nyeri' ? 'checked' : '' }} type="radio"
                                value="4 Menolak Nyeri">
                            <label class="form-check-label">4 Menolak Nyeri</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                {{ @$asessment['igdAwal']['glasgow']['motorik'] == '3 Fleksi Abnormal' ? 'checked' : '' }} type="radio"
                                value="3 Fleksi Abnormal">
                            <label class="form-check-label">3 Fleksi Abnormal</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                {{ @$asessment['igdAwal']['glasgow']['motorik'] == '2 Eksternal Abnormal' ? 'checked' : '' }} type="radio"
                                value="2 Eksternal Abnormal">
                            <label class="form-check-label">2 Eksternal Abnormal</label>
                        </div>
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                {{ @$asessment['igdAwal']['glasgow']['motorik'] == '1 Tidak Merespon' ? 'checked' : '' }} type="radio"
                                value="1 Tidak Merespon">
                            <label class="form-check-label">Tidak Merespon</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        GCS SCORE
                    </td>
                    <td>
                        <input type="number" class="form-control" placeholder="Score GCS" name="asessment[igdAwal][glasgow][GCS]" value="{{ @$asessment['igdAwal']['glasgow']['GCS'] ?? @$dataAsesmenPerawat['disabilitycgstotal'] ?? (int) @$dataTriage['ttv']['gcs'] }}" style="width: 100%">
                    </td>
                </tr>
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Pupil
                    </td>
                    <td>
                        <div style="display: flex;gap: 5px; padding-top: 10px; justify-content: space-around">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][normal][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['normal']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Normal</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][normal][ka][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['normal']['ka']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ka</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][normal][ka][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['normal']['ka']['ket']}}">
                            </div>
                            <div>
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][normal][ki][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['normal']['ki']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ki</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][normal][ki][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['normal']['ki']['ket']}}">
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                        <div style="display: flex; gap: 5px; padding-top: 10px; justify-content: space-around">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][midriasis][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Midriasis</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][midriasis][ka][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ka']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ka</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][midriasis][ka][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ka']['ket']}}">
                            </div>
                            <div>
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][midriasis][ki][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ki']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ki</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][midriasis][ki][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ki']['ket']}}">
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                        <div style="display: flex; gap: 5px; padding-top: 10px; justify-content: space-around">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][miosis][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['miosis']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Miosis</label>
                            </div>
                            <div>
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][miosis][ka][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['miosis']['ka']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ka</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][miosis][ka][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['miosis']['ka']['ket']}}">
                            </div>
                            <div>
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][miosis][ki][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['miosis']['ki']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ki</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][miosis][ki][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['miosis']['ki']['ket']}}">
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                        <div style="display: flex; gap: 5px; padding-top: 10px; justify-content: space-around">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][lainnya][ada]"
                                {{ @$asessment['igdAwal']['glasgow']['pupil']['lainnya']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Lainnya</label>
                                <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][midriasis][dll]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['midriasis']['dll']}}">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Tanda Vital</td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;">TD</td>
                    <td> 
                        <input style="width: 80%; display: inline" type="text" class="form-control" name="asessment[igdAwal][tandaVital][tekananDarah]" value="{{@$asessment['igdAwal']['tandaVital']['tekananDarah'] ?? @$dataAsesmenPerawat['tanda_vital']['tekanan_darah'] ?? @$dataAsesmenPonek['tanda_vital']['tekanan_darah'] ?? @$dataTriage['ttv']['tekanan_darah'] }}" > 
                        <span style="width: 20%" >mmHg</span>
                    </td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;"> Frekuensi Nadi </td>
                    <td> 
                        <input style="width: 80%; display: inline" type="text" class="form-control" name="asessment[igdAwal][tandaVital][frekuensiNadi]"  value="{{@$asessment['igdAwal']['tandaVital']['frekuensiNadi'] ?? @$dataAsesmenPerawat['tanda_vital']['nadi'] ?? @$dataAsesmenPonek['tanda_vital']['nadi'] ?? @$dataTriage['ttv']['nadi'] }}" > 
                        <span style="width: 20%" >x/Menit</span>
                    </td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;"> Suhu </td>
                    <td> 
                        <input style="width: 80%; display: inline" type="text" class="form-control" name="asessment[igdAwal][tandaVital][suhu]"  value="{{@$asessment['igdAwal']['tandaVital']['suhu'] ?? @$dataAsesmenPerawat['tanda_vital']['suhu'] ?? @$dataAsesmenPonek['tanda_vital']['suhu'] ?? @$dataTriage['ttv']['suhu'] }}" >
                        <span style="width: 20%" >&deg;C</span>
                    </td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;"> RR </td>
                    <td> 
                        <input style="width: 80%; display: inline" type="text" class="form-control" name="asessment[igdAwal][tandaVital][RR]"  value="{{@$asessment['igdAwal']['tandaVital']['RR'] ?? @$dataAsesmenPerawat['tanda_vital']['frekuensi_nafas'] ?? @$dataAsesmenPonek['tanda_vital']['frekuensi_nafas'] ?? @$dataTriage['ttv']['RR'] }}" > 
                        <span style="width: 20%" >x/Menit</span>
                    </td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;"> SPO2 </td>
                    <td> 
                        <input style="width: 80%; display: inline" type="text" class="form-control" name="asessment[igdAwal][tandaVital][spo2]"  value="{{@$asessment['igdAwal']['tandaVital']['spo2'] ?? @$dataAsesmenPerawat['tanda_vital']['spo2'] ?? @$dataAsesmenPonek['tanda_vital']['SPO2'] ?? @$dataTriage['ttv']['saturasi'] }}" > 
                        {{-- <span style="width: 20%" >x/Menit</span> --}}
                    </td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;">BB </td>
                    <td> 
                        <input style="width: 80%; display: inline" type="text" class="form-control" name="asessment[igdAwal][tandaVital][BB]"  value="{{@$asessment['igdAwal']['tandaVital']['BB'] ?? @$dataAsesmenPerawat['tanda_vital']['BB'] ?? @$dataAsesmenPonek['tanda_vital']['BB'] ?? @$dataTriage['ttv']['BB'] }}" > 
                        <span style="width: 20%" >Kg</span>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Pemeriksaan Fisik</td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;">Kulit</td>
                    <td> 
                        <div style="display: flex; gap: 10px;">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Pucat]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Pucat'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Pucat</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Cyanosis]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Cyanosis'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Cyanosis</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Ikterik]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Ikterik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ikterik</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px;">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][DinginKering]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['DinginKering'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Dingin Kering</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][DinginLembab]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['DinginLembab'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Dingin Lembab</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Berkeringat]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Berkeringat'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Berkeringat</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px;">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][normal]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['normal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Hangat/Normal</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][panas]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['panas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Panas</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px;">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Eritema]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Eritema'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Eritema</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Urtikaria]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Urtikaria'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Urtikaria</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Petichiae]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Petichiae'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Petichiae</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px;">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][turgorBaik]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['turgorBaik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Turgor Baik</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Sedang]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Sedang'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Sedang</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Buruk]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Buruk'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Buruk</label>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" class="form-control" placeholder="Keterangan Lain" name="asessment[igdAwal][pemeriksaanFisik][kulit][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['kulit']['ket']}}" style="width: 100%">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Kebutuhan Edukasi dan Informasi Terintegrasi</td>
                </tr>
                <tr>
                    <td  style="width:20%; font-weight:bold;">Edukasi</td>
                    <td> 
                        <div style="">
                            Penjelasan Diberikan Oleh :<br/>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi][Dokter]"
                                {{ @$asessment['igdAwal']['edukasi']['Dokter'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Dokter</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi][Farmasi]"
                                {{ @$asessment['igdAwal']['edukasi']['Farmasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Farmasi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi][Nutrisi]"
                                {{ @$asessment['igdAwal']['edukasi']['Nutrisi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nutrisi</label>
                            </div><br/>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi][Laboratorium]"
                                {{ @$asessment['igdAwal']['edukasi']['Laboratorium'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Laboratorium</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi][Radiologi]"
                                {{ @$asessment['igdAwal']['edukasi']['Radiologi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Radiologi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi][Perawat]"
                                {{ @$asessment['igdAwal']['edukasi']['Perawat'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Perawat</label>
                            </div>
                            
                        </div>
                        
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="">
                            Penjelasan Mengenai <br/>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi2][Diagnosa]"
                                {{ @$asessment['igdAwal']['edukasi2']['Diagnosa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Menjelaskan Diagnosa Penyakit</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi2][Penunjang]"
                                {{ @$asessment['igdAwal']['edukasi2']['Penunjang'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Menjelaskan hasil pemeriksaan penunjang</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi2][Terapi]"
                                {{ @$asessment['igdAwal']['edukasi2']['Terapi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Menjelaskan terapi/pengobatan</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi2][Tindakan]"
                                {{ @$asessment['igdAwal']['edukasi2']['Tindakan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Menjelaskan rencana tindakan</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][edukasi2][vaksin]"
                                {{ @$asessment['igdAwal']['edukasi2']['vaksin'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Menjelaskan pemberian vaksin</label>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-6">
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                
                <tr>
                    <td  style="width:20%; font-weight:bold;">Kepala dan Leher</td>
                    <td> 
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Simetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Simetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Asimetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Asimetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Nyeri]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Nyeri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nyeri</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][luka]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['luka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Luka</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][jejas]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['jejas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Jejas</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Hematome]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Hematome'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Hematome</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][normal]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['normal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Hangat/Normal</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][pembedaranKGB]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['pembedaranKGB'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Pembedaran KGB</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][peningkatanJVP]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['peningkatanJVP'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Peningkatan JVP</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Massa]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Massa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Massa</label>
                            </div>
                            <div >
                                <input type="text" class="form-control"  name="asessment[igdAwal][pemeriksaanFisik][kepala][massaKet]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['kepala']['massaKet']}}">
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][fontanelCekung]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['fontanelCekung'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Funtanel Cekung</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][mataCekung]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['mataCekung'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Mata Cekung</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][kongjungtivaAnemis]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['kongjungtivaAnemis'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Konjungtiva Anemis</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][skleraIkterik]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['skleraIkterik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Sklera Ikterik</label>
                            </div>
                            <div >
                                <input type="text" class="form-control"  name="asessment[igdAwal][pemeriksaanFisik][kepala][lainnya]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['kepala']['lainnya']}}" placeholder="Lainnya">
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td  style="width:20%; font-weight:bold;">Dada</td>
                    <td> 
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Simetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Simetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Asimetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Asimetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Nyeri]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Nyeri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nyeri</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Lecet]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Lecet'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Lecet</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][luka]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['luka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Luka</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][jejas]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['jejas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Jejas</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][sesak]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['sesak'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Sesak</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][retraksiSuprasternal]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['retraksiSuprasternal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Retraksi Suprasternal</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][retraksiInterkostal]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['retraksiInterkostal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Retraksi Interkostal</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][retraksiSubsternal]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['retraksiSubsternal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Retraksi Substernal</label>
                            </div>
                        </div>
                      
                    </td>
                </tr>

                <tr>
                    <td  style="width:20%; font-weight:bold;">Suara Paru</td>
                    <td> 
                        <div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][Vesikuler]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['Vesikuler'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Vesikuler</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][Ronchi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['Ronchi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ronchi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][Wheezing]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['Wheezing'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Wheezing</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][PerkusiSonor]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['PerkusiSonor'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Perkusi Sonor</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][PerkusiDull]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['PerkusiDull'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Perkusi Dull</label>
                            </div>
                            <div >
                                <input type="text" class="form-control" placeholder="Lainnya" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['ket']}}" style="width: 100%">
                            </div>
                        </div>
                      
                    </td>
                </tr>

                <tr>
                    <td  style="width:20%; font-weight:bold;">Bunyi Jantung</td>
                    <td> 
                        <div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][batasJantung][ada]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['batasJantung']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Batas Jantung</label>
                                <input type="text" class="form-control" placeholder="Lainnya" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][batasJantung][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['batasJantung']['ket']}}" >
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][s1-s2]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['s1-s2'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">S1-S2 Murni reg/ireg</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][murmur]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['murmur'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Murmur</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][gallop]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['gallop'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Gallop</label>
                            </div>
                        </div>
                      
                    </td>
                </tr>

                <tr>
                    <td  style="width:20%; font-weight:bold;">Abdomen</td>
                    <td> 
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Simetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Simetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Asimetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Asimetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Soefel]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Soefel'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Soefel</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Kembung]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Kembung'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kembung</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Distensi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Distensi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Distensi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Ascities]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Ascities'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ascities</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][lukaTerbuka]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['lukaTerbuka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Luka Terbuka</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Lecet]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Lecet'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Lecet</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][jejas]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['jejas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Jejas</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Hamatome]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Hamatome'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Hamatome</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][pembesaranLimpa]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['pembesaranLimpa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Pembesaran Limpa</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][pembesaran Hepar]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['pembesaran Hepar'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Pembesaran Hepar</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Massa]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Massa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Massal</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][nyeriEpigastrik]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['nyeriEpigastrik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nyeri Tekan Epigastrik</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][nyeriPubic]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['nyeriPubic'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nyeri tekan supra pubic</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][mcBurney]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['mcBurney'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">MC Burney Sign</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][CVAPain]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['CVAPain'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">CVA Pain</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][perkusiThympani]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['perkusiThympani'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Perkusi Tyhmani</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][perkusiDull]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['perkusiDull'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">PerkusiDull</label>
                            </div>
                        </div>
                        <div>
                            <input type="text" class="form-control" placeholder="Lainnya" name="asessment[igdAwal][pemeriksaanFisik][abdomen][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['ket']}}" style="width: 100%">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td  style="width:20%; font-weight:bold;">BU</td>
                    <td> 
                        <input style="width: 80%; display: inline" type="number" class="form-control" name="asessment[igdAwal][pemeriksaanFisik][abdomen][BU]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['BU'] }}" > 
                        <span style="width: 20%" >x/Menit</span>
                    </td>
                </tr>

                <tr>
                    <td style="text-align: center; font-weight: bold" colspan="2">Saluran Kemih / Genetalia</td>
                </tr>

                <tr>
                    <td style="font-weight: bold">Penilian</td>
                    <td>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Luka]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Luka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Luka</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Lecet]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Lecet'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Lecet</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][NyeriTekan]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['NyeriTekan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nyeri Tekan</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Oedema]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Oedema'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Oedema</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Massa]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Massa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Massa</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Sekresi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Sekresi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Sekresi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][nyeriBAK]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['nyeriBAK'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nyeri Saat BAK</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Kesulitan]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Kesulitan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kesulitan</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][RetensiUrine]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['RetensiUrine'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Retensi Urine</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Poliuri]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Poliuri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Poliuri</label>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold">Frekuensi BAK</td>
                    <td>
                        <input type="text" class="form-control" placeholder="x/Hari" name="asessment[igdAwal][pemeriksaanFisik][genetalia][frekuensiBak]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['frekuensiBak']}}" style="width: 100%">
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold">Warna</td>
                    <td>
                        <input type="text" class="form-control"name="asessment[igdAwal][pemeriksaanFisik][genetalia][warna]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['warna']}}" style="width: 100%">
                    </td>
                </tr>


                <tr>
                    <td style="text-align: center; font-weight: bold" colspan="2">Ekstremitas (Atas/Bawah)</td>
                </tr>
                
                <tr>
                    <td style="font-weight: bold">Penilian</td>
                    <td>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Simetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Simetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Asimetris]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Asimetris</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][keterbatasanGerak]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['keterbatasanGerak'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Keterbaasan Gerak</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Deformitas]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Deformitas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Deformitas</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Kontosio]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Kontosio'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kontosio</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Hematome]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Hematome'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Hematome</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Oedema]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Oedema'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Oedema</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Refleks]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Refleks'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Refleks</label>
                            </div>

                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Gigitan]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Gigitan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Gigitan</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][VulnusPunctum]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['VulnusPunctum'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Vulnus Punctum</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Abrasi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Abrasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Abrasi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Laserasi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Laserasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Laserasi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Tertutup]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Tertutup'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Tertutup</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Terbuka]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Terbuka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Terbuka</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][AutoAmputasi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['AutoAmputasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Auto Amputasi</label>
                            </div>
                        </div>
                    </td>
                </tr>

                
                
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5>
                    <b>STATUS LOKALIS</b>
                    @if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4')
                        <a href="{{ url('/emr-soap/penilaian/gigi/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                            title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i
                                class="fa fa-pencil"></i> Isi Lokalis</a>&nbsp;&nbsp;
                    @elseif(@$reg->poli_id == '15')
                        <a href="{{ url('/emr-soap/penilaian/obgyn/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                            title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i
                                class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                    @else
                        <a href="{{ url('/emr-soap/penilaian/fisik/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                            title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i
                                class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                    @endif
                </h5>
                <tr>
                    <td><b>Status Lokalis :</b>
                        @if (@$gambar->image != null)
                            <a id="myImg"><i class="fa fa-eye text-primary"></i>Lihat Lokalis</a>
                            <input type="hidden" src="/images/{{ @$gambar['image'] }}" id="dataImage">

                            <div id="myModal" class="modal">
                                <span class="close" style=" padding: 20px; color: red; scale: 2;">&times;</span>
                                <img class="modal-content" id="img01" style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <div id="caption">...</div>
                            </div>
                        @else
                            -
                        @endif

                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">
                        <textarea rows="3" name="asessment[igdAwal][ketLokalis]" style="display:inline-block; resize: vertical;"
                            placeholder="Keterangan Status Lokalis" class="form-control">{{@$asessment['igdAwal']['ketLokalis']}}</textarea>
                    </td>
                </tr>
            </table>
            
            

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Diagnosa
                    </td>
                    <td>
                        <textarea name="asessment[igdAwal][diagnosa]" style="width: 100%" rows="3">{{ @$asessment['igdAwal']['diagnosa'] }}</textarea>
                    </td>
                </tr>
                {{-- <tr>
                    <td style="width:20%; font-weight:bold;">
                        Planning
                    </td>
                    <td>
                        <textarea name="asessment[igdAwal][planning]" style="width: 100%" rows="3">{{ @$asessment['igdAwal']['planning'] }}</textarea>
                    </td>
                </tr> --}}
                <tr>
                    <td style="width:20%; font-weight:bold;">
                        Tindakan & Pengobatan
                    </td>
                    <td>
                        <textarea name="asessment[igdAwal][tindakan_pengobatan]" style="width: 100%" rows="3">{{ @$asessment['igdAwal']['tindakan_pengobatan'] }}</textarea>
                    </td>
                </tr>
                {{-- <tr>
                    <td style="width:20%; font-weight:bold;">
                        Tindakan
                    </td>
                    <td>
                        <textarea name="asessment[igdAwal][tindakan]" style="width: 100%" rows="3">{{ @$asessment['igdAwal']['tindakan'] }}</textarea>
                    </td>
                </tr> --}}

                <tr>
                    <td style="text-align: center; font-weight: bold" colspan="2">Kasus</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Gawat Darurat</td>
                    <td>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][trauma]"
                                {{ @$asessment['igdAwal']['kasus']['trauma'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Trauma</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][KLL]"
                                {{ @$asessment['igdAwal']['kasus']['KLL'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">KLL</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][KecelakanKerja]"
                                {{ @$asessment['igdAwal']['kasus']['KecelakanKerja'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kecelakan Kerja</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][kecelakanRT]"
                                {{ @$asessment['igdAwal']['kasus']['kecelakanRT'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kecelakan Rumah Tangga</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][penganiayan]"
                                {{ @$asessment['igdAwal']['kasus']['penganiayan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Penganiayan</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][gigitan]"
                                {{ @$asessment['igdAwal']['kasus']['gigitan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Gigitan</label>
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div style="display: flex; gap: 10px">
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][nonTraumatik]"
                                {{ @$asessment['igdAwal']['kasus']['nonTraumatik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Non Traumatik</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][KLL]"
                                {{ @$asessment['igdAwal']['kasus']['KLL'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">KLL</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][inflasiDanInfeksi]"
                                {{ @$asessment['igdAwal']['kasus']['inflasiDanInfeksi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Inflasi dan Infeksi</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][neoplasma]"
                                {{ @$asessment['igdAwal']['kasus']['neoplasma'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Nesoplasma</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][kelainanDegeneratif]"
                                {{ @$asessment['igdAwal']['kasus']['kelainanDegeneratif'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kelainan Degeneratif</label>
                            </div>
                            <div >
                                <input class="form-check-input" name="asessment[igdAwal][kasus][kelainanEndokrinMetabolik]"
                                {{ @$asessment['igdAwal']['kasus']['kelainanEndokrinMetabolik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Kelainan Endokrine dan Metabolik</label>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                <tr>
                    <td style="text-align: center; font-weight: bold" colspan="2">Tindakan Selanjutnya</td>
                </tr>
                <tr>
                    <td style="width:40%; font-weight:bold;">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Dirawat' ? 'checked' : '' }} type="radio"
                                value="Dirawat">
                            <label class="form-check-label">Dirawat di Ruang</label>
                        </div>
                    </td>
                    <td>
                        <select name="asessment[igdAwal][tindakanSelanjutnya][ruangRawat]" id="select2-ruangRawat" class="form-control select2" style="display: inline-block; width: 100%;">
                            <option value="">-- Pilih --</option>
                            @foreach ($kamars as $kamar)
                                <option value="{{ $kamar->nama }}" {{ $kamar->nama == @$asessment['igdAwal']['tindakanSelanjutnya']['ruangRawat'] ? 'selected' : '' }}>{{ $kamar->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Dirujuk' ? 'checked' : '' }} type="radio"
                                value="Dirujuk">
                            <label class="form-check-label">Dirujuk</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'APS' ? 'checked' : '' }} type="radio"
                                value="APS">
                            <label class="form-check-label">Pulang Atas Permintaan Sendiri / Pulang Paksa</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Observasi' ? 'checked' : '' }} type="radio"
                                value="Observasi">
                            <label class="form-check-label">Observasi</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Meninggal' ? 'checked' : '' }} type="radio"
                                value="Meninggal">
                            <label class="form-check-label">Meninggal</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Pulang atas ijin dokter' ? 'checked' : '' }} type="radio"
                                value="Pulang atas ijin dokter">
                            <label class="form-check-label">Pulang atas ijin dokter</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'DOA' ? 'checked' : '' }} type="radio"
                                value="DOA">
                            <label class="form-check-label">DOA</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: inline-block; padding: 5px">
                            <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Pindah Ke IGD Umum / Alih IGD' ? 'checked' : '' }} type="radio"
                                value="Pindah Ke IGD Umum / Alih IGD">
                            <label class="form-check-label">Pindah Ke IGD Umum / Alih IGD</label>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="text-right" style="margin-top: 10px; ">
                @if (@$dataPegawai == 1)
                    
                <span style="color:red; font-style: italic; display:block">*Simpan Terlebih dahulu
                    sebelum mengisi bagian selanjutnya!</span>
                    <button class="btn btn-success">Simpan</button>
                @endif
            </div>
        </div>

        
        
        <br /><br />
    </form>
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var dataImage = document.getElementById("dataImage");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
          modal.style.display = "block";
          modalImg.src = dataImage.src;
          captionText.innerHTML = this.alt;
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
          modal.style.display = "none";
        }
    </script>
</div>
