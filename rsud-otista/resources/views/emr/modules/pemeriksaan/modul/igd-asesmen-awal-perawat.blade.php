<div class="col-md-12">
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen-igd-awal-perawat/' . $unit . '/' . $reg->id) }}"
        class="form-horizontal">
        <div class="row">
            <div class="col-md-12">
                {{ csrf_field() }}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                {!! Form::hidden('unit', $unit) !!}
                <br>

                {{-- Anamnesis --}}
                @php
                    @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
                    if (!@$dataPegawai) {
                        @$dataPegawai = 1;
                    }
                @endphp
                <div class="col-md-6">
                    <h5><b>Keluhan Utama</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <b>ID SATUSEHAT : {{@$satusehat['perawat_id_condition_keluhan_utama']}}</b>
                                <select name="asessment[keluhan_utama_pilihan]" class="select2" style="width: 100%">
                                    <option value="">-- Pilih Salah Satu --</option>
                                    @if (@$keluhanUtama->children)
                                        @foreach ($keluhanUtama->children as $keluhan)
                                            <option value="{{$keluhan->concept_id}}" {{@$asessment['keluhan_utama_pilihan'] == $keluhan->concept_id ? 'selected' : ''}}>{{$keluhan->fsn_term}} | {{$keluhan->fsn_lang}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <textarea name="asessment[keluhan_utama]" style="width: 100%;" rows="10">{{@$asessment['keluhan_utama']}}</textarea>
                            </td>
                        </tr>
                    </table>
                    
                    <h5><b>Asesmen Keperawatan - Airway</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="11">Asesmen Keperawatan - Airway</td>
                            <td>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwaybersih]"
                                        {{ @$asessment['airwaybersih'] == 'Bersih' ? 'checked' : '' }} type="checkbox"
                                        value="Bersih">
                                    <label class="form-check-label">Bersih</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwayspontan]"
                                        {{ @$asessment['airwayspontan'] == 'Spontan' ? 'checked' : '' }} type="checkbox"
                                        value="Spontan">
                                    <label class="form-check-label">Spontan</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwaydispnoe]"
                                        {{ @$asessment['airwaydispnoe'] == 'Dispnoe' ? 'checked' : '' }} type="checkbox"
                                        value="Dispnoe">
                                    <label class="form-check-label">Dispnoe</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwaytechnipnoe]"
                                        {{ @$asessment['airwaytechnipnoe'] == 'Techipnoe' ? 'checked' : '' }} type="checkbox"
                                        value="Techipnoe">
                                    <label class="form-check-label">Techipnoe</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwayapnoe]"
                                        {{ @$asessment['airwayapnoe'] == 'Apnoe' ? 'checked' : '' }} type="checkbox"
                                        value="Apnoe">
                                    <label class="form-check-label">Apnoe</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwayslem]"
                                        {{ @$asessment['airwayslem'] == 'Slem' ? 'checked' : '' }} type="checkbox"
                                        value="Slem">
                                    <label class="form-check-label">Slem</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[airwayobstruksi]"
                                        {{ @$asessment['airwayobstruksi'] == 'Obstruksi' ? 'checked' : '' }} type="checkbox"
                                        value="Obstruksi">
                                    <label class="form-check-label">Obstruksi</label>
                                </div>
                                <div>
                                    <input type="text" class="form-control" name="asessment[airwaydll]" style="width: 100%;"
                                    value="{{ @$asessment['airwaydll'] }}" placeholder="Lainnya">
                                </div>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Diagnosa Keperawatan - Airway</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select name="asessment[diagnosa_keperawatan][airway]" class="select-diagnosa-keperawatan" onchange="getAskep(this.value, 'airway')">
                                    <option value="">-- Pilih</option>
                                    @foreach ($diagnosaKeperawatan as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Intervensi - Airway</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-intervensi-keperawatan" name="asessment[intervensi_keperawatan][airway][]" multiple="multiple" id="select-intervensi-airway"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Implementasi - Airway</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-implementasi-keperawatan" name="asessment[implementasi_keperawatan][airway][]" multiple="multiple" id="select-implementasi-airway"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>



                    <h5><b>Asesmen Keperawatan - Breathing</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="6">Asesmen Keperawatan - Breathing</td>
                            <td>Pola Napas</td>
                            <td colspan="2">
                                <input type="text" name="asessment[breathingfrekuensi]" class="form-control"
                                    placeholder="Frekuensi/menit" >
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Bunyi Napas</td>
                            <td>
                                <input type="hidden" name="asessment[breathingVesikuler]" value="-">
                                <input type="checkbox" name="asessment[breathingVesikuler]" value="vesikuler">
                                Vesikuler
                            </td>
                            <td>
                                <input type="hidden" name="asessment[breathingwheezing]" value="-">
                                <input type="checkbox" name="asessment[breathingwheezing]" value="wheezing">
                                wheezing
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[breathingronchi]" value="-">
                                <input type="checkbox" name="asessment[breathingronchi]" value="ronchi">
                                Ronchi
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Tanda Distress Pernapasan</td>
                            <td>
                                <input type="hidden" name="asessment[breathingtanda_distressototbantu]"
                                    value="-">
                                <input type="checkbox" name="asessment[breathingtanda_distressototbantu]"
                                    value="Ya">
                                Penggunaan otot bantu
                            </td>
                            <td>
                                <input type="hidden" name="asessment[breathingtanda_distressretraksi]"
                                    value="-">
                                <input type="checkbox" name="asessment[breathingtanda_distressretraksi]"
                                    value="Ya">
                                Retraksi dada/inter costa
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[breathingtanda_distresscuping]" value="-">
                                <input type="checkbox" name="asessment[breathingtanda_distresscuping]"
                                    value="Ya">
                                Cuping hidung
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Jenis Pernapasan</td>
                            <td>
                                <input type="hidden" name="asessment[breathingjenis_napasdada]" value="-">
                                <input type="checkbox" name="asessment[breathingjenis_napasdada]"
                                    value="Pernapasan dada">
                                Pernapasan dada
                            </td>
                            <td>
                                <input type="hidden" name="asessment[breathingjenis_napasperut]" value="-">
                                <input type="checkbox" name="asessment[breathingjenis_napasperut]"
                                    value="pernapasan perut">
                                Pernapasan perut
                            </td>
                        </tr>
                    </table>

                    <h5><b>Diagnosa Keperawatan - Breathing</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select name="asessment[diagnosa_keperawatan][breathing]" class="select-diagnosa-keperawatan" onchange="getAskep(this.value, 'breathing')">
                                    <option value="">-- Pilih</option>
                                    @foreach ($diagnosaKeperawatan as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Intervensi - Breathing</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-intervensi-keperawatan" name="asessment[intervensi_keperawatan][breathing][]" multiple="multiple" id="select-intervensi-breathing"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Implementasi - Breathing</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-implementasi-keperawatan" name="asessment[implementasi_keperawatan][breathing][]" multiple="multiple" id="select-implementasi-breathing"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Asesmen Keperawatan - Circulation</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="16">Asesmen Keperawatan - Circulation</td>
                            <td rowspan="2">Akral</td>
                            <td>
                                <input type="hidden" name="asessment[circulationakralhangat]" value="-">
                                <input type="checkbox" name="asessment[circulationakralhangat]" value="Hangat">
                                Hangat
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationakraldingin]" value="-">
                                <input type="checkbox" name="asessment[circulationakraldingin]" value="Dingin">
                                Dingin
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[circulationakraloedema]" value="-">
                                <input type="checkbox" name="asessment[circulationakraloedema]" value="Oedema">
                                Oedema
                            </td>
                        </tr>

                        <tr>
                            <td>Pucat</td>
                            <td>
                                <input type="hidden" name="asessment[circulationpucatya]" value="-">
                                <input type="checkbox" name="asessment[circulationpucatya]" value="Ya">
                                Ya
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationpucattidak]" value="-">
                                <input type="checkbox" name="asessment[circulationpucattidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>

                        <tr>
                            <td>Sianosis</td>
                            <td>
                                <input type="hidden" name="asessment[circulationsianosisya]" value="-">
                                <input type="checkbox" name="asessment[circulationsianosisya]" value="Ya">
                                Ya
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationsianosistidak]" value="-">
                                <input type="checkbox" name="asessment[circulationsianosistidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Nadi</td>
                            <td colspan="2">
                                <input type="text" name="asessment[circulationfrekuensi]" class="form-control"
                                    placeholder="Frekuensi/menit" >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[circulationnaditeraba]" value="-">
                                <input type="checkbox" name="asessment[circulationnaditeraba]" value="Teraba">
                                Teraba
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationnadiTteraba]" value="-">
                                <input type="checkbox" name="asessment[circulationnadiTteraba]" value="Tidak teraba">
                                Tidak Teraba
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Irama :</td>
                            <td>
                                <input type="hidden" name="asessment[circulationiramareguler]" value="-">
                                <input type="checkbox" name="asessment[circulationiramareguler]" value="Reguler">
                                Reguler
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationiramaireguler]" value="-">
                                <input type="checkbox" name="asessment[circulationiramaireguler]" value="Ireguler">
                                Ireguler
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[circulationiramakuat]" value="-">
                                <input type="checkbox" name="asessment[circulationiramakuat]" value="Kuat">
                                Kuat
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationiramalemah]" value="-">
                                <input type="checkbox" name="asessment[circulationiramalemah]" value="Lemah">
                                Lemah
                            </td>
                        </tr>

                        <tr>
                            <td>Tekanan Darah</td>
                            <td colspan="2">
                                <input type="text" name="asessment[circulationtekanandarah]" class="form-control"
                                    placeholder="mmHg" >
                            </td>
                        </tr>

                        <tr>
                            <td>Suhu Badan</td>
                            <td colspan="2">
                                <input type="text" name="asessment[circulationsuhubadan]" class="form-control"
                                    placeholder="^C" >
                            </td>
                        </tr>

                        <tr>
                            <td>Perdarahan</td>
                            <td colspan="2">
                                <input type="text" name="asessment[circulationperdarahan]" class="form-control"
                                    placeholder="cc" >
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Luka Bakar</td>
                            <td>Grade</td>
                            <td>
                                <input type="text" name="asessment[circulationlukabakargrade]"
                                    class="form-control" placeholder="" >
                            </td>
                        </tr>
                        <tr>
                            <td>Luas</td>
                            <td>
                                <input type="text" name="asessment[circulationlukabakarluas]" class="form-control"
                                    placeholder="%" >
                            </td>
                        </tr>

                        <tr>
                            <td>Mual</td>
                            <td>
                                <input type="hidden" name="asessment[circulationmualya]" value="-">
                                <input type="checkbox" name="asessment[circulationmualya]" value="Ya">
                                Ya
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationmualtidak]" value="-">
                                <input type="checkbox" name="asessment[circulationmualtidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>

                        <tr>
                            <td>Muntah</td>
                            <td>
                                <input type="hidden" name="asessment[circulationmuntahya]" value="-">
                                <input type="checkbox" name="asessment[circulationmuntahya]" value="Ya">
                                Ya
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationmuntahtidak]" value="-">
                                <input type="checkbox" name="asessment[circulationmuntahtidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>

                        <tr>
                            <td>Pengisian Kapiler(CRT)</td>
                            <td>
                                <input type="hidden" name="asessment[circulationcrt_<2]" value="-">
                                <input type="checkbox" name="asessment[circulationcrt_<20]" value="<2">
                                < 2
                            </td>
                            <td>
                                <input type="hidden" name="asessment[circulationcrt_>2]" value="-">
                                <input type="checkbox" name="asessment[circulationcrt_>2]" value=">2">
                                > 2
                            </td>
                        </tr>
                    </table>

                    <h5><b>Diagnosa Keperawatan - Circulation</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select name="asessment[diagnosa_keperawatan][circulation]" class="select-diagnosa-keperawatan" onchange="getAskep(this.value, 'circulation')">
                                    <option value="">-- Pilih</option>
                                    @foreach ($diagnosaKeperawatan as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Intervensi - Circulation</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-intervensi-keperawatan" name="asessment[intervensi_keperawatan][circulation][]" multiple="multiple" id="select-intervensi-circulation"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
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

                    <h5><b>Implementasi - Circulation</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-implementasi-keperawatan" name="asessment[implementasi_keperawatan][circulation][]" multiple="multiple" id="select-implementasi-circulation"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>
                    
                </div>

                <div class="col-md-6">
                    <h5><b>Asesmen Keperawatan - Disability</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="14 ">Asesmen Keperawatan - Disability</td>
                            <td rowspan="2">Kesadaran :</td>
                            <td>
                                <input type="hidden" name="asessment[disabilitykesadarancm]" value="-">
                                <input type="checkbox" name="asessment[disabilitykesadarancm]" value="CM">
                                CM (15)
                            </td>
                            <td>
                                <input type="hidden" name="asessment[disabilitykesadaransomnolen]" value="-">
                                <input type="checkbox" name="asessment[disabilitykesadaransomnolen]"
                                    value="Somnolen">
                                Somnolen (12-14)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[disabilitykesadaransopor]" value="-">
                                <input type="checkbox" name="asessment[disabilitykesadaransopor]" value="Sopor">
                                Sopor (9-11)
                            </td>
                            <td>
                                <input type="hidden" name="asessment[disabilitykesadarankoma]" value="-">
                                <input type="checkbox" name="asessment[disabilitykesadarankoma]" value="Koma">
                                Koma (3-8)
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="3">Nilai GCS :</td>
                            <td>E :</td>
                            <td>
                                <input type="text" name="asessment[disabilitycgse]" value=""
                                    class="form-control gcs" >
                            </td>
                        </tr>
                        <tr>
                            <td>M :</td>
                            <td>
                                <input type="text" name="asessment[disabilitycgsm]" value=""
                                    class="form-control gcs" >
                            </td>
                        </tr>
                        <tr>
                            <td>V :</td>
                            <td>
                                <input type="text" name="asessment[disabilitycgsv]" value=""
                                    class="form-control gcs" >
                            </td>
                        </tr>
                        <tr>
                            <td>Total GCS :</td>
                            <td>
                                <input type="text" id="gcsScore" name="asessment[disabilitycgstotal]" value="" class="form-control" >
                            </td>
                        </tr>
                        <script>
                            let gcs = document.getElementsByClassName('gcs');
                            let gcsScore = document.getElementById('gcsScore');
                            gcs = Array.from(gcs);
                            gcs.forEach(el => {
                                el.addEventListener('input', function(){
                                    let gcsVal = 0;
                                    gcs.forEach(x => {
                                        let val = parseInt(x.value)
                                        if(isNaN(val)){
                                            val = 0;
                                        }
                                        gcsVal += val;
                                    })
                                    gcsScore.value = gcsVal;
                                })
                            });
                        </script>
                        
                        <tr>
                            <td>Reflek Cahaya :</td>
                            <td>
                                <input type="hidden" name="asessment[disabilityreflekada]" value="-">
                                <input type="checkbox" name="asessment[disabilityreflekada]" value="Ada">
                                Ada
                            </td>
                            <td>
                                <input type="hidden" name="asessment[disabilityreflektidakada]" value="-">
                                <input type="checkbox" name="asessment[disabilityreflektidakada]" value="Tidak ada">
                                Tidak Ada
                            </td>
                        </tr>
                        <tr>
                            <td>Diameter Pupil :</td>
                            <td colspan="2">
                                <input type="text" class="form-control" name="asessment[disabilitytxt]"
                                    value="" >
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="4">Ekstremitas :</td>
                            <td rowspan="2">Motorik :</td>
                            <td>
                                <input type="hidden" name="asessment[disabilitymotorikya]" value="-">
                                <input type="checkbox" name="asessment[disabilitymotorikya]" value="Ya">
                                Ya
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[disabilitymotoriktidak]" value="-">
                                <input type="checkbox" name="asessment[disabilitymotoriktidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2">Sensorik :</td>
                            <td>
                                <input type="hidden" name="asessment[disabilitysensorikya]" value="-">
                                <input type="checkbox" name="asessment[disabilitysensorikya]" value="Ya">
                                Ya
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="asessment[disabilitysensoriktidak]" value="-">
                                <input type="checkbox" name="asessment[disabilitysensoriktidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>
                        <tr>
                            <td>Kekuatan Otot :</td>
                            <td colspan="2">
                                <input type="text" class="form-control" name="asessment[disabilityotot]"
                                    value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>Kejang :</td>
                            <td>
                                <input type="hidden" name="asessment[disabilitykejangya]" value="-">
                                <input type="checkbox" name="asessment[disabilitykejangya]" value="Ya">
                                Ya
                            </td>
                            <td>
                                <input type="hidden" name="asessment[disabilitykejangtidak]" value="-">
                                <input type="checkbox" name="asessment[disabilitykejangtidak]" value="Ya">
                                Tidak
                            </td>
                        </tr>
                        <tr>
                            <td>Trismus :</td>
                            <td>
                                <input type="hidden" name="asessment[disabilitytrismusya]" value="-">
                                <input type="checkbox" name="asessment[disabilitytrismusya]" value="Ya">
                                Ya
                            </td>
                            <td>
                                <input type="hidden" name="asessment[disabilitytrismustidak]" value="-">
                                <input type="checkbox" name="asessment[disabilitytrismustidak]" value="Tidak">
                                Tidak
                            </td>
                        </tr>
                    </table>

                    <h5><b>Diagnosa Keperawatan - Disability</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select name="asessment[diagnosa_keperawatan][disability]" class="select-diagnosa-keperawatan" onchange="getAskep(this.value, 'disability')">
                                    <option value="">-- Pilih</option>
                                    @foreach ($diagnosaKeperawatan as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Intervensi - Disability</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-intervensi-keperawatan" name="asessment[intervensi_keperawatan][disability][]" multiple="multiple" id="select-intervensi-disability"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Implementasi - Disability</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-implementasi-keperawatan" name="asessment[implementasi_keperawatan][disability][]" multiple="multiple" id="select-implementasi-disability"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Asesmen Keperawatan - Eksposure</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                Adanya trauma / luka
                            </td>
                            <td>
                                <label for="trauma_1">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][isTrauma]" id="trauma_1" value="Tidak" {{ @$asessment['eksposure']['asesmen']['trauma']['isTrauma'] == 'Tidak' ? 'checked' : '' }}>
                                    Tidak
                                </label>
                                <label for="trauma_2">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][isTrauma]" id="trauma_2" value="Ya" {{ @$asessment['eksposure']['asesmen']['trauma']['isTrauma'] == 'Ya' ? 'checked' : '' }}>
                                    Ya
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="pilihan_1">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_1" value="Laceratum" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Laceratum' ? 'checked' : '' }}>
                                    Laceratum
                                </label><br>
                                <label for="pilihan_2">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_2" value="Ekskoriasi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Ekskoriasi' ? 'checked' : '' }}>
                                    Ekskoriasi
                                </label><br>
                                <label for="pilihan_3">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_3" value="Hematoma" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Hematoma' ? 'checked' : '' }}>
                                    Hematoma
                                </label><br>
                                <label for="pilihan_4">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_4" value="Contusio" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Contusio' ? 'checked' : '' }}>
                                    Contusio
                                </label><br>
                                <label for="pilihan_5">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_5" value="Auto Amputasi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Auto Amputasi' ? 'checked' : '' }}>
                                    Auto Amputasi
                                </label>
                            </td>
                            <td>
                                <label for="pilihan_6">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_6" value="Fraktur" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Fraktur' ? 'checked' : '' }}>
                                    Fraktur
                                </label><br>
                                <label for="pilihan_7">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_7" value="Dislokasi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Dislokasi' ? 'checked' : '' }}>
                                    Dislokasi
                                </label><br>
                                <label for="pilihan_8">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_8" value="Morsum" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Morsum' ? 'checked' : '' }}>
                                    Morsum
                                </label><br>
                                <label for="pilihan_9">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_9" value="Punctum" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Punctum' ? 'checked' : '' }}>
                                    Punctum
                                </label><br>
                                <label for="pilihan_10">
                                    <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_10" value="Apulsi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Apulsi' ? 'checked' : '' }}>
                                    Apulsi
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" name="asessment[eksposure][asesmen][trauma][lainnya]" placeholder="Lainnya" value="{{ @$asessment['eksposure']['asesmen']['trauma']['lainnya'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Adanya Nyeri
                            </td>
                            <td>
                                <label for="adaNyeri_1">
                                    <input type="radio" name="asessment[eksposure][asesmen][nyeri][pilihan]" id="adaNyeri_1" value="Tidak" {{ @$asessment['eksposure']['asesmen']['nyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                    Tidak
                                </label>
                                <label for="adaNyeri_2">
                                    <input type="radio" name="asessment[eksposure][asesmen][nyeri][pilihan]" id="adaNyeri_2" value="Ya" {{ @$asessment['eksposure']['asesmen']['nyeri']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                                    Ya
                                </label>
                                <br>
                                <input type="text" class="form-control" name="asessment[eksposure][asesmen][nyeri][lokasi]" placeholder="Lokasi" value="{{ @$asessment['eksposure']['asesmen']['nyeri']['lokasi'] }}">
                            </td>
                        </tr>
                    </table>

                    <h5><b>Diagnosa Keperawatan - Eksposure</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select name="asessment[diagnosa_keperawatan][eksposure]" class="select-diagnosa-keperawatan" onchange="getAskep(this.value, 'eksposure')">
                                    <option value="">-- Pilih</option>
                                    @foreach ($diagnosaKeperawatan as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Intervensi - Eksposure</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-intervensi-keperawatan" name="asessment[intervensi_keperawatan][eksposure][]" multiple="multiple" id="select-intervensi-eksposure"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Implementasi - Eksposure</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td>
                                <select class="form-control select-implementasi-keperawatan" name="asessment[implementasi_keperawatan][eksposure][]" multiple="multiple" id="select-implementasi-eksposure"  style="width: 100%;">
                                </select>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Tindakan Keperawatan / Kebidanan</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr style="width: 100%;">
                            <td style="width: 100%;">
                                <textarea style="width: 100%;" name="asessment[tindakan_keperawatan_kebidanan]" rows="10">{{ @$asessment['tindakan_keperawatan_kebidanan'] ?? @$dataAsesmenDokter['igdAwal']['tindakan_pengobatan'] }}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
                        <tr>
                            <td style="width:20%;">Risiko Cidera / Jatuh :</td>
                            <td colspan="2" style="padding: 5px;">

                                <input type="radio" value="Tidak" name="asessment[asesmen_nyeri][cidera]" {{ @$asessment['asesmen_nyeri']['cidera'] == 'Tidak' ? 'checked' : '' }}> Tidak
                                <input type="radio" value="Ya" name="asessment[asesmen_nyeri][cidera]" {{ @$asessment['asesmen_nyeri']['cidera'] == 'Ya' ? 'checked' : '' }}> Ya
                                <br>
                                <small>Bila ya isi form monitoring pencegahan pasien jatuh dan pasang gelang warna kuning</small>
                            </td>
                        </tr>
                        <tr>
                            <td>Aktifitas dan mobilisasi</td>
                            <td colspan="2">
                                <label for="aktifitasMobilisasi1">
                                    <input type="radio" name="asessment[aktifitasMobilisasi][pilihan]" id="aktifitasMobilisasi1" class="form-check-input" value="Mandiri" {{ @$asessment['aktifitasMobilisasi']['pilihan'] == 'Mandiri' ? 'checked' : '' }}>
                                    Mandiri
                                </label>
                                <label for="aktifitasMobilisasi2">
                                    <input type="radio" name="asessment[aktifitasMobilisasi][pilihan]" id="aktifitasMobilisasi2" class="form-check-input" value="Perlu Bantuan" {{ @$asessment['aktifitasMobilisasi']['pilihan'] == 'Perlu Bantuan' ? 'checked' : '' }}>
                                    Perlu Bantuan
                                </label>
                                <label for="aktifitasMobilisasi3">
                                    <input type="radio" name="asessment[aktifitasMobilisasi][pilihan]" id="aktifitasMobilisasi3" class="form-check-input" value="Alat Bantu Jalan" {{ @$asessment['aktifitasMobilisasi']['pilihan'] == 'Alat Bantu Jalan' ? 'checked' : '' }}>
                                    Alat Bantu Jalan
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="7" style="width:20%;">Asesmen Nyeri</td>
                            <td>
                                <label for="nyeri1">
                                    <input type="radio" name="asessment[asesmen_nyeri][pilihan]" id="nyeri1" class="form-check-input" value="Tidak">
                                    Tidak
                                </label>
                            </td>
                            <td>
                                <label for="nyeri2">
                                    <input type="radio" name="asessment[asesmen_nyeri][pilihan]" id="nyeri2" class="form-check-input" value="Ya">
                                    Ya
                                </label>
                            </td>
                            
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">
                                    Provokatif
                                </label>
                            </td>
                            <td>
                                <label for="provokatif1">
                                    <input type="radio" name="asessment[asesmen_nyeri][provokatif][pilihan]" id="provokatif1" class="form-check-input" value="Benturan">
                                    Benturan
                                </label>
                                <label for="provokatif2">
                                    <input type="radio" name="asessment[asesmen_nyeri][provokatif][pilihan]" id="provokatif2" class="form-check-input" value="Spontan">
                                    Spontan
                                </label>
                                <input type="text" name="asessment[asesmen_nyeri][provokatif][sebutkan]"
                                    style="display:inline-block" class="form-control" id="">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Quality</label>
                            </td>
                            <td>
                                <label for="quality1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality1" class="form-check-input" value="Seperti Tertusuk Benda Tajam / Tumpul">
                                    Seperti Tertusuk Benda Tajam / Tumpul
                                </label>
                                <label for="quality2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality2" class="form-check-input" value="Berdenyut">
                                    Berdenyut
                                </label>
                                <label for="quality3" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality3" class="form-check-input" value="Terbakar">
                                    Terbakar
                                </label>
                                <label for="quality4" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality4" class="form-check-input" value="Terpelintir">
                                    Terpelintir
                                </label>
                                <label for="quality5" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality5" class="form-check-input" value="Tertindih Benda Berat">
                                    Tertindih Benda Berat
                                </label>
                                <label for="quality6" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality6" class="form-check-input" value="Lain - Lain">
                                    Lain - Lain
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Region</label>
                            </td>
                            <td>
                                <input type="text" name="asessment[asesmen_nyeri][region][lokasi]" style="display:inline-block" class="form-control" id="">
                                <br>
                                <span>Menyebar : </span>
                                <br>
                                <label for="region1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][region][pilihan]" id="region1" class="form-check-input" value="Tidak">
                                    Tidak
                                </label>
                                <label for="region2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][region][pilihan]" id="region2" class="form-check-input" value="Ya">
                                    Ya
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Severity</label>
                            </td>
                            <td>
                                <label for="severity1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][severity][pilihan]" id="severity1" class="form-check-input" value="Wong Baker Face">
                                    Wong Baker Face
                                </label>
                                <label for="severity2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][severity][pilihan]" id="severity2" class="form-check-input" value="FLACCS">
                                    FLACCS
                                </label>
                                <br>
                                <input type="text" name="asessment[asesmen_nyeri][severity][skor]" class="form-control" placeholder="Score">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Time (Durasi)</label>
                            </td>
                            <td>
                                <input type="text" name="asessment[asesmen_nyeri][time]"
                                    style="display:inline-block" class="form-control" id="">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Nyeri Hilang Jika</label>
                            </td>
                            <td>
                                <label for="nyeriHilang1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang1" class="form-check-input" value="Minum Obat">
                                    Minum Obat
                                </label>
                                <label for="nyeriHilang2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang2" class="form-check-input" value="Istirahat">
                                    Istirahat
                                </label>
                                <label for="nyeriHilang3" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang3" class="form-check-input" value="Berubah Posisi">
                                    Berubah Posisi
                                </label>
                                <label for="nyeriHilang4" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang4" class="form-check-input" value="Mendengar Musik">
                                    Mendengar Musik
                                </label>
                                <br>
                                <label for="nyeriHilang5" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang5" class="form-check-input" value="Lain - Lain">
                                    Lain - Lain
                                </label>
                                <br>
                                <input type="text" name="asessment[asesmen_nyeri][nyeriHilang]"
                                    style="display:inline-block" class="form-control" id="">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="5" style="width:2Tidak%;">Kesadaran</td>
                            <td colspan="2" style="padding: 5px;">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                                        type="hidden" value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                                        type="checkbox" value="Ya" id="flexCheckDefault">
                                    Compos Mentis
                                </label>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][apatis]" type="hidden"
                                        value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][apatis]" type="checkbox"
                                        value="Ya" id="flexCheckDefault">
                                    Apatis
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][somnolen]" type="hidden"
                                        value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][somnolen]"
                                        type="checkbox" value="Ya" id="flexCheckDefault">
                                    Somnolen
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][sopor]" type="hidden"
                                        value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][sopor]" type="checkbox"
                                        value="Ya" id="flexCheckDefault">
                                    Sopor
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][coma]" type="hidden"
                                        value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][coma]" type="checkbox"
                                        value="Ya" id="flexCheckDefault">
                                    Coma
                                </label>
                            </td>
                        </tr>
                        </td>

                        </tr>
                        <tr>
                            <td rowspan="7" style="width:20%;">Tanda Vital</td>
                            <td style="padding: 5px;">
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Tekanan Darah (mmHG)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][tekanan_darah]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['tekananDarah'] ?? @$dataTriage['ttv']['tekanan_darah'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Nadi (x/menit)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][nadi]" style="display:inline-block"
                                    class="form-control" id="" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['frekuensiNadi'] ?? @$dataTriage['ttv']['nadi'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Frekuensi Nafas (x/menit)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][frekuensi_nafas]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['RR'] ?? @$dataTriage['ttv']['RR'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label"> Suhu (°C)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][suhu]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['suhu'] ?? @$dataTriage['ttv']['suhu'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label"> SpO2</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][spo2]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['spo2'] ?? @$dataTriage['ttv']['saturasi'] }}">
                            </td>
                        </tr>


                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">BB (kg)</label>
                            <td>
                                <input type="number" name="asessment[tanda_vital][BB]" style="display:inline-block"
                                    class="form-control" id="" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['BB'] ?? (int) @$dataTriage['ttv']['BB'] }}">
                            </td>
                        </tr>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12">
                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>

                {{-- Rekonsiliasi Obat --}}
                <div class="col-md-12" style="margin-top: 20px">
                    @if (@$current_asessment->id == request()->asessment_id || request()->asessment_id == null)
                        {{-- Muncul hanya jika user membuka asesment hari ini aja/registrasi --}}
                        <div class="box box-info">
                            <div class="box-body">
                                <form method="POST"
                                    action="{{ url('emr-soap/pemeriksaan/asesmen-igd/' . $unit . '/' . $reg->id) }}"
                                    class="form-horizontal">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                    {!! Form::hidden('unit', $unit) !!}
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[nama_obat]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[nama_obat]', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="text" name="rekonsiliasi[nama_obat]"
                                                        id="rekonsiliasi[nama_obat]" class="form-control">
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[nama_obat]') }}</small>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[alasan_makan]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[alasan_makan]', 'Alasan Makan Obat', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="text" name="rekonsiliasi[alasan_makan]"
                                                        id="rekonsiliasi[alasan_makan]" class="form-control">
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[alasan_makan]') }}</small>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[obat_dilanjutkan]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[obat_dilanjutkan]', 'Obat Dilanjutkan', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <select name="rekonsiliasi[obat_dilanjutkan]"
                                                        class="form-control select2" style="width: 100%">
                                                        <option value="YA">YA</option>
                                                        <option value="TIDAK">TIDAK</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[obat_dilanjutkan]') }}</small>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <input type="hidden" id="currentDateTime"
                                                name="rekonsiliasi[tanggal]" value="">
                                            <script>
                                                function setCurrentDateTime() {
                                                    const hiddenInput = document.getElementById('currentDateTime');
                                                    const now = new Date();
                                                    const formattedDateTime = now.toLocaleString();
                                                    hiddenInput.value = formattedDateTime;
                                                }
                                                setCurrentDateTime();
                                            </script>
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[dosis]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[dosis]', 'Dosis', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('rekonsiliasi[dosis]', '', ['class' => 'form-control']) !!}
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[dosis]') }}</small>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[frekuensi]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[frekuensi]', 'Frekuensi', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('rekonsiliasi[frekuensi]', '', ['class' => 'form-control']) !!}
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[][frekuensi]') }}</small>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9 text-center">
                                                    {!! Form::submit('Tambah', [
                                                        'class' => 'btn btn-success btn-flat',
                                                        'style' => 'width: 100%',
                                                        'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif


                    <div class='table-responsive'>
                        <table class='table-striped table-bordered table-hover table-condensed table'>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Frekuensi</th>
                                    <th>Alasan Makan Obat</th>
                                    <th>Obat Dilanjutkan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @if (isset($rekonsiliasi))
                                    @foreach ($rekonsiliasi as $r_obat)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ @$r_obat['nama_obat'] }}</td>
                                            <td>{{ @$r_obat['dosis'] }}</td>
                                            <td>{{ @$r_obat['frekuensi'] }}</td>
                                            <td>{{ @$r_obat['alasan_makan'] }}</td>
                                            <td>{{ @$r_obat['obat_dilanjutkan'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse(@$r_obat['tanggal'])->format('d-m-Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center">Tidak Ada Data</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px">
                    @if (@$current_asessment->id == request()->asessment_id || request()->asessment_id == null)
                        {{-- Muncul hanya jika user membuka asesment hari ini aja/registrasi --}}
                        <div class="box box-info">
                            <div class="box-body">
                                <form method="POST"
                                    action="{{ url('emr-soap/pemeriksaan/asesmen-igd/' . $unit . '/' . $reg->id) }}"
                                    class="form-horizontal">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                    {!! Form::hidden('unit', $unit) !!}
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[nama_obat]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[nama_obat]', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="text" name="obatAlergi[nama_obat]"
                                                        id="obatAlergi[nama_obat]" class="form-control"
                                                        placeholder="Nama Obat Yang Menimbulkan Alergi">
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[nama_obat]') }}</small>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[reaksi_alergi]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[reaksi_alergi]', 'Reaksi Alergi', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('obatAlergi[reaksi_alergi]', '', ['class' => 'form-control']) !!}
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[reaksi_alergi]') }}</small>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <input type="hidden" id="currentDateTime"
                                                name="obatAlergi[tanggal]" value="">
                                            <script>
                                                function setCurrentDateTime() {
                                                    const hiddenInput = document.getElementById('currentDateTime');
                                                    const now = new Date();
                                                    const formattedDateTime = now.toLocaleString();
                                                    hiddenInput.value = formattedDateTime;
                                                }
                                                setCurrentDateTime();
                                            </script>
                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[tingkat_alergi]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[tingkat_alergi]', 'Tingkat Alergi', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <select name="obatAlergi[tingkat_alergi]"
                                                        class="form-control select2" style="width: 100%">
                                                        <option value="RINGAN">RINGAN</option>
                                                        <option value="SEDANG">SEDANG</option>
                                                        <option value="BERAT">BERAT</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[tingkat_alergi]') }}</small>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9 text-center">
                                                    {!! Form::submit('Tambah', [
                                                        'class' => 'btn btn-success btn-flat',
                                                        'style' => 'width: 100%',
                                                        'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    <div class='table-responsive'>
                        <table class='table-striped table-bordered table-hover table-condensed table'>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Obat Yang Menimbulkan Alergi</th>
                                    <th>Tingkat Alergi</th>
                                    <th>Reaksi Alergi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @if (isset($obatAlergi))
                                    @foreach ($obatAlergi as $a_obat)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ @$a_obat['nama_obat'] }}</td>
                                            <td>{{ @$a_obat['tingkat_alergi'] }}</td>
                                            <td>{{ @$a_obat['reaksi_alergi'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse(@$a_obat['tanggal'])->format('d-m-Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center">Tidak Ada Data</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

        </div>
    </form>
</div>


{{-- </form> --}}
