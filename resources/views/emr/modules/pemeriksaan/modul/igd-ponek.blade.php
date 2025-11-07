<div class="col-md-12">
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen-igd-ponek/' . $unit . '/' . $reg->id) }}"
        class="form-horizontal">
        <div class="row">
            {{-- @include('emr.modules.addons.tabs') --}}
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
                    <h5><b>RENCANA ASUHAN KEBIDANAN KASUS PASCA TRAUMA</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">

                        <tr>
                            <td rowspan="5" style="width:2Tidak%;">Kesadaran</td>
                            <td colspan="2" style="padding: 5px;">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                                        type="hidden" value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                                        type="checkbox" value="Ya" id="flexCheckDefault" {{ @$dataAsesmenPonek['kesadaran']['compos_mentis'] == 'Ya' ? 'checked' : '' }}>
                                    Compos Mentis
                                </label>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][apatis]" type="hidden"
                                        value="Tidak" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][apatis]" type="checkbox"
                                        value="Ya" id="flexCheckDefault" {{ @$dataAsesmenPonek['kesadaran']['apatis'] == 'Ya' ? 'checked' : '' }}>
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
                                        type="checkbox" value="Ya" id="flexCheckDefault" {{ @$dataAsesmenPonek['kesadaran']['somnolen'] == 'Ya' ? 'checked' : '' }}>
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
                                        value="Ya" id="flexCheckDefault" {{ @$dataAsesmenPonek['kesadaran']['sopor'] == 'Ya' ? 'checked' : '' }}>
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
                                        value="Ya" id="flexCheckDefault" {{ @$dataAsesmenPonek['kesadaran']['coma'] == 'Ya' ? 'checked' : '' }}>
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
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['tanda_vital']['tekanan_darah'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Nadi (x/menit)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][nadi]" style="display:inline-block"
                                    class="form-control" id="" value="{{ @$dataAsesmenPonek['tanda_vital']['nadi'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Frekuensi Nafas (x/menit)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][frekuensi_nafas]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['tanda_vital']['frekuensi_nafas'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label"> Suhu (°C)</label>
                            <td>
                                <input type="text" name="asessment[tanda_vital][suhu]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['tanda_vital']['suhu'] }}">
                            </td>
                        </tr>


                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">BB (kg)</label>
                            <td>
                                <input oninput="hitungIMT()" type="number" name="asessment[tanda_vital][BB]" style="display:inline-block"
                                    class="form-control" id="beratBadan" value="{{ @$dataAsesmenPonek['tanda_vital']['BB'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">TB (cm)</label>
                            <td>
                                <input oninput="hitungIMT()" type="number" name="asessment[tanda_vital][TB]" style="display:inline-block"
                                    class="form-control" id="tinggiBadan" value="{{ @$dataAsesmenPonek['tanda_vital']['TB'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">SPO2</label>
                            <td colspan="2">
                                <input type="number" name="asessment[tanda_vital][SPO2]" style="display:inline-block"
                                    class="form-control" id="" value="{{ @$dataAsesmenPonek['tanda_vital']['SPO2'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">IMT</label>
                            <td colspan="2">
                                <input type="number" name="asessment[tanda_vital][IMT]" style="display:inline-block"
                                    class="form-control" id="imt" value="{{ @$dataAsesmenPonek['tanda_vital']['IMT'] }}">
                            </td>
                        </tr>
                        </td>
                        </tr>
                        <tr>
                            <td rowspan="7" style="width:20%;">Asesmen Nyeri</td>
                            <td>
                                <label for="nyeri1">
                                    <input type="radio" name="asessment[asesmen_nyeri][pilihan]" id="nyeri1" class="form-check-input" value="Tidak" {{ @$dataAsesmenPonek['asesmen_nyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                    Tidak
                                </label>
                            </td>
                            <td>
                                <label for="nyeri2">
                                    <input type="radio" name="asessment[asesmen_nyeri][pilihan]" id="nyeri2" class="form-check-input" value="Ya" {{ @$dataAsesmenPonek['asesmen_nyeri']['pilihan'] == 'Ya' ? 'checked' : '' }}>
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
                                    <input type="radio" name="asessment[asesmen_nyeri][provokatif][pilihan]" id="provokatif1" class="form-check-input" value="Benturan" {{ @$dataAsesmenPonek['asesmen_nyeri']['provokatif']['pilihan'] == 'Benturan' ? 'checked' : '' }}>
                                    Benturan
                                </label>
                                <label for="provokatif2">
                                    <input type="radio" name="asessment[asesmen_nyeri][provokatif][pilihan]" id="provokatif2" class="form-check-input" value="Spontan" {{ @$dataAsesmenPonek['asesmen_nyeri']['provokatif']['pilihan'] == 'Spontan' ? 'checked' : '' }}>
                                    Spontan
                                </label>
                                <input type="text" name="asessment[asesmen_nyeri][provokatif][sebutkan]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['asesmen_nyeri']['provokatif']['sebutkan']}}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Quality</label>
                            </td>
                            <td>
                                <label for="quality1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality1" class="form-check-input" value="Seperti Tertusuk Benda Tajam / Tumpul" {{ @$dataAsesmenPonek['asesmen_nyeri']['quality']['pilihan'] == 'Seperti Tertusuk Benda Tajam / Tumpul' ? 'checked' : '' }}>
                                    Seperti Tertusuk Benda Tajam / Tumpul
                                </label>
                                <label for="quality2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality2" class="form-check-input" value="Berdenyut" {{ @$dataAsesmenPonek['asesmen_nyeri']['quality']['pilihan'] == 'Berdenyut' ? 'checked' : '' }}>
                                    Berdenyut
                                </label>
                                <label for="quality3" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality3" class="form-check-input" value="Terbakar" {{ @$dataAsesmenPonek['asesmen_nyeri']['quality']['pilihan'] == 'Terbakar' ? 'checked' : '' }}>
                                    Terbakar
                                </label>
                                <label for="quality4" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality4" class="form-check-input" value="Terpelintir"  {{ @$dataAsesmenPonek['asesmen_nyeri']['quality']['pilihan'] == 'Terpelintir' ? 'checked' : '' }}>
                                    Terpelintir
                                </label>
                                <label for="quality5" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality5" class="form-check-input" value="Tertindih Benda Berat"  {{ @$dataAsesmenPonek['asesmen_nyeri']['quality']['pilihan'] == 'Tertindih Benda Berat' ? 'checked' : '' }}>
                                    Tertindih Benda Berat
                                </label>
                                <label for="quality6" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" id="quality6" class="form-check-input" value="Lain - Lain"  {{ @$dataAsesmenPonek['asesmen_nyeri']['quality']['pilihan'] == 'Lain - Lain' ? 'checked' : '' }}>
                                    Lain - Lain
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Region</label>
                            </td>
                            <td>
                                <input type="text" name="asessment[asesmen_nyeri][region][lokasi]" style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['asesmen_nyeri']['region']['lokasi'] }}">
                                <br>
                                <span>Menyebar : </span>
                                <br>
                                <label for="region1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][region][pilihan]" id="region1" class="form-check-input" value="Tidak" {{ @$dataAsesmenPonek['asesmen_nyeri']['region']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                    Tidak
                                </label>
                                <label for="region2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][region][pilihan]" id="region2" class="form-check-input" value="Ya" {{ @$dataAsesmenPonek['asesmen_nyeri']['region']['pilihan'] == 'Ya' ? 'checked' : '' }}>
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
                                    <input type="radio" name="asessment[asesmen_nyeri][severity][pilihan]" id="severity1" class="form-check-input" value="Wong Baker Face" {{ @$dataAsesmenPonek['asesmen_nyeri']['severity']['pilihan'] == 'Wong Baker Face' ? 'checked' : '' }}>
                                    Wong Baker Face
                                </label>
                                <label for="severity2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][severity][pilihan]" id="severity2" class="form-check-input" value="FLACCS" {{ @$dataAsesmenPonek['asesmen_nyeri']['severity']['pilihan'] == 'FLACCS' ? 'checked' : '' }}>
                                    FLACCS
                                </label>
                                <br>
                                <input type="text" name="asessment[asesmen_nyeri][severity][skor]" class="form-control" placeholder="Score" value="{{ @$dataAsesmenPonek['asesmen_nyeri']['severity']['skor']}}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Time (Durasi)</label>
                            </td>
                            <td>
                                <input type="text" name="asessment[asesmen_nyeri][time]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['asesmen_nyeri']['time']}}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Nyeri Hilang Jika</label>
                            </td>
                            <td>
                                <label for="nyeriHilang1" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang1" class="form-check-input" value="Minum Obat" {{ @$dataAsesmenPonek['asesmen_nyeri']['nyeriHilang']['pilihan'] == 'Minum Obat' ? 'checked' : '' }}>
                                    Minum Obat
                                </label>
                                <label for="nyeriHilang2" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang2" class="form-check-input" value="Istirahat" {{ @$dataAsesmenPonek['asesmen_nyeri']['nyeriHilang']['pilihan'] == 'Istirahat' ? 'checked' : '' }}>
                                    Istirahat
                                </label>
                                <label for="nyeriHilang3" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang3" class="form-check-input" value="Berubah Posisi" {{ @$dataAsesmenPonek['asesmen_nyeri']['nyeriHilang']['pilihan'] == 'Berubah Posisi' ? 'checked' : '' }}>
                                    Berubah Posisi
                                </label>
                                <label for="nyeriHilang4" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang4" class="form-check-input" value="Mendengar Musik" {{ @$dataAsesmenPonek['asesmen_nyeri']['nyeriHilang']['pilihan'] == 'Mendengar Musik' ? 'checked' : '' }}>
                                    Mendengar Musik
                                </label>
                                <br>
                                <label for="nyeriHilang5" style="margin-right: 10px;">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" id="nyeriHilang5" class="form-check-input" value="Lain - Lain" {{ @$dataAsesmenPonek['asesmen_nyeri']['nyeriHilang']['pilihan'] == 'Lain - Lain' ? 'checked' : '' }}>
                                    Lain - Lain
                                </label>
                                <br>
                                <input type="text" name="asessment[asesmen_nyeri][nyeriHilang][lainya]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['asesmen_nyeri']['nyeriHilang']['lainya']}}">
                            </td>
                        </tr>
                        </td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Risiko Cidera / Jatuh :</td>
                            <td colspan="2" style="padding: 5px;">

                                <input type="radio" value="Tidak" name="asessment[asesmen_nyeri][cidera]" {{ @$dataAsesmenPonek['asesmen_nyeri']['cidera'] == 'Tidak' ? 'checked' : '' }}> Tidak
                                <input type="radio" value="Ya" name="asessment[asesmen_nyeri][cidera]" {{ @$dataAsesmenPonek['asesmen_nyeri']['cidera'] == 'Ya' ? 'checked' : '' }}> Ya
                                <br>
                                <small>Bila ya isi form monitoring pencegahan pasien jatuh dan pasang gelang warna kuning</small>
                            </td>
                        </tr>
                    </table>

                    <h5><b>Riwayat</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:20%;">Keluhan Utama</td>
                            <td style="padding: 5px;">
                                <textarea rows="15" name="asessment[riwayat][keluhanUtama]" style="display:inline-block"
                                    placeholder="[Masukkan Riwayat Perjalanan Penyakit]" class="form-control">{{ @$dataAsesmenPonek['riwayat']['keluhanUtama'] }}</textarea>
                            </td>

                        </tr>
                    </table>

                    <h5><b>Menstruasi</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        {{-- <tr>
                            <td style="width:20%;">Siklus</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][siklus]"
                                    style="display:inline-block" class="form-control" id="siklus_menstruasi" value="{{ @$dataAsesmenPonek['riwayat']['siklus'] }}"></td>
                        </tr> --}}
                        <tr>
                            <td style="width:20%;">HPHT</td>
                            <td style="padding: 5px;">
                                <input type="date" name="asessment[riwayat][hpht]" class="form-control"
                                    id="hpht" value="{{ @$dataAsesmenPonek['riwayat']['hpht'] }}">
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="width:20%;"></td>
                            <td style="padding: 5px;">
                                <div>
                                    <label>HPL <span style="color: red; font-size: 10px; font-weight: 400;"><i id="rumus"></i></span></label>
                                    <input type="date" name="asessment[riwayat][hpl]" class="form-control" readonly id="hpl" value="{{ @$dataAsesmenPonek['riwayat']['hpl'] }}">
                                </div>
                            </td>
                        </tr> --}}
                        {{-- <tr>
                            <td style="width:20%;">Dismenorrhoe</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][dismenorrhoe]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['riwayat']['dismenorrhoe'] }}" /></td>
                        </tr>
                        <tr>
                            <td s tyle="width:20%;">Lama</td>
                            <td style="padding: 5px;"><input style="display:inline-block" type="text"
                                    name="asessment[riwayat][lama]" class="form-control" value="{{ @$dataAsesmenPonek['riwayat']['lama'] }}" />
                        </tr>
                        <tr>
                            <td style="width:20%;">Banyaknya</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][banyaknya]"
                                    style="display:inline-block" class="form-control" value="{{ @$dataAsesmenPonek['riwayat']['banyaknya'] }}"></td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Menorrhagia / Metorrhagia</td>
                            <td style="padding: 5px;">
                                <input type="text" name="asessment[riwayat][menorrhagia]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['riwayat']['menorrhagia'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Nyeri</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][nyeri]"
                                    style="display:inline-block" class="form-control" id="" value="{{ @$dataAsesmenPonek['riwayat']['nyeri'] }}"></td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Teratur</td>
                            <td style="padding: 5px;"><input type="text"name="asessment[riwayat][teratur]"
                                    class="form-control" value="{{ @$dataAsesmenPonek['riwayat']['teratur'] }}" /></td>
                        </tr> --}}
                        <tr>
                            <td style="width:20%;">TP</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][tp]"
                                    class="form-control" value="{{ @$dataAsesmenPonek['riwayat']['tp'] }}" /></td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Usia Kehamilan</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][usia_kehamilan]"
                                    class="form-control" value="{{ @$dataAsesmenPonek['riwayat']['usia_kehamilan'] }}" /></td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Lainnya</td>
                            <td style="padding: 5px;"><input type="text" name="asessment[riwayat][lainnya]"
                                    class="form-control" value="{{ @$dataAsesmenPonek['riwayat']['lainnya'] }}" /></td>
                        </tr>
                    </table>


                    <h5><b>Riwayat Kesehatan</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="3">Riwayat Alergi</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][obat]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][obat]"
                                    type="checkbox" value="Obat" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['obat'] == 'Obat' ? 'checked' : '' }}>
                                A. Obat
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][makanan]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][makanan]"
                                    type="checkbox" value="Makanan" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['makanan'] == 'Makanan' ? 'checked' : '' }}>
                                B. Makanan
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input name="asessment[riwayat][lainnya1]" type="text" class="form-control"
                                    id="lainnya" placeholder="Lain-lain" value="{{ @$dataAsesmenPonek['riwayat']['lainnya1']}}">
                            </td>
                        {{-- <tr>
                            <td style="width:20%;" rowspan="7">Riwayat Penyakit Dahulu :</td>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][hipertensi1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][hipertensi1]" type="checkbox" value="Hipertensi"
                                    id="flexCheckDefault">
                                Hipertensi
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][diabetes1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][diabetes1]" type="checkbox" value="Diabetes"
                                    id="flexCheckDefault">
                                Diabetes
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][asma1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][asma1]" type="checkbox" value="Asma"
                                    id="flexCheckDefault">
                                Asma
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][maag1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][maag1]" type="checkbox" value="Maag"
                                    id="flexCheckDefault">
                                Maag
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][hepatitis1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][hepatitis1]" type="checkbox" value="Hepatitis"
                                    id="flexCheckDefault">
                                Hepatitis
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][jantung1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatdahulu"
                                    name="asessment[riwayat][jantung1]" type="checkbox" value="Jatung"
                                    id="flexCheckDefault">
                                Jantung
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input name="asessment[riwayat][lainnya2]" type="text" class="form-control"
                                    id="lainnya" placeholder="Lain-lain">
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%;" rowspan="7">Riwayat Penyakit Keluarga :</td>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][hipertensi2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][hipertensi2]" type="checkbox" value="Hipertensi"
                                    id="flexCheckDefault">
                                Hipertensi
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][diabetes2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][diabetes2]" type="checkbox" value="Diabetes"
                                    id="flexCheckDefault">
                                Diabetes
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][asma2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][asma2]" type="checkbox" value="Asma"
                                    id="flexCheckDefault">
                                Asma
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][maag2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][maag2]" type="checkbox" value="Maag"
                                    id="flexCheckDefault">
                                Maag
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][hepatitis2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][hepatitis2]" type="checkbox" value="Hepatitis"
                                    id="flexCheckDefault">
                                Hepatitis
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][jantung2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkeluarga"
                                    name="asessment[riwayat][jantung2]" type="checkbox" value="Jatung"
                                    id="flexCheckDefault">
                                Jantung
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input name="asessment[riwayat][lainnya3]" type="text" class="form-control"
                                    id="lainnya" placeholder="Lain-lain">
                            </td>
                        </tr> --}}
                    </table>


                    <h5><b>Riwayat Perkawinan</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="3">Status</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][bkawin]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][bkawin]"
                                    type="checkbox" value="BKawin" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['bkawin'] == 'BKawin' ? 'checked' : '' }}>
                                A. Belum Kawin
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][kawin]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][kawin]"
                                    type="checkbox" value="Kawin" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['kawin'] == 'Kawin' ? 'checked' : '' }}>
                                B. Kawin
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][cerai]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][cerai]"
                                    type="checkbox" value="Cerai" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['cerai'] == 'Cerai' ? 'checked' : '' }}>
                                C. Cerai
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Menikah (x)</td>
                            <td style="padding: 5px;"><input type="number"
                                    name="asessment[riwayat][menikah]" style="display:inline-block"
                                    class="form-control" id="" value="{{ @$dataAsesmenPonek['riwayat']['menikah']}}"></td>
                        </tr>
                        <tr>
                            <td style="width:20%;">Lama Menikah </td>
                            <td>
                                <input name="asessment[riwayat][lama]" type="text" class="form-control"
                                    id="lama" placeholder="Lama Menikah" value="{{ @$dataAsesmenPonek['riwayat']['lama'] }}">
                            </td>
                        </tr>
                    </table>


                    {{-- <h5><b>Riwayat Kontrasepsi Yang Pernah Di Pakai</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="5" style="padding: 5px;">Riwayat Konstrasepsi Yang Pernah Di Pakai :</td>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][pil]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][pil]" type="checkbox"
                                    value="Pil" id="flexCheckDefault">
                                Pil
                            </td>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][suntik]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][suntik]" type="checkbox"
                                    value="suntik" id="flexCheckDefault">
                                Suntik
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][IUD]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][IUD]" type="checkbox"
                                    value="IUD" id="flexCheckDefault">
                                IUD
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][implan]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][implan]" type="checkbox"
                                    value="Implan" id="flexCheckDefault">
                                Implan
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][mow]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][mow]" type="checkbox"
                                    value="MOW" id="flexCheckDefault">
                                MOW
                            </td>
                        </tr>
                        </tr>
                    </table> --}}

                    <h5><b>Riwayat Penyakit Dahulu</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="9" style="padding: 5px;">Riwayat Penyakit Dahulu :</td>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][jantung_dhl]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][jantung_dhl]"
                                    type="checkbox" value="jantung" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['jantung_dhl'] == 'jantung' ? 'checked' : '' }}>
                                jantung
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][asma_dhl]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][asma_dhl]" type="checkbox"
                                    value="asma" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['asma_dhl'] == 'asma' ? 'checked' : '' }}>
                                asma
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][hipertensi_dhl]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][hipertensi_dhl]"
                                    type="checkbox" value="hipertensi" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['hipertensi_dhl'] == 'hipertensi' ? 'checked' : '' }}>
                                hipertensi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][DM_dhl]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][DM_dhl]" type="checkbox"
                                    value="DM" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['DM_dhl'] == 'DM' ? 'checked' : '' }}>
                                DM
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][hepatitis_dhl]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][hepatitis_dhl]"
                                    type="checkbox" value="Hepatitis" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['hepatitis_dhl'] == 'Hepatitis' ? 'checked' : '' }}>
                                Hepatitis
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][alergi_dhl]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][alergi_dhl]" type="checkbox"
                                    value="Alergi" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['alergi_dhl'] == 'Alergi' ? 'checked' : '' }}>
                                Alergi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][ginjal_dhl]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][ginjal_dhl]" type="checkbox"
                                    value="Ginjal" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['ginjal_dhl'] == 'Ginjal' ? 'checked' : '' }}>
                                Ginjal
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][tidak_ada_dhl]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][tidak_ada_dhl]"
                                    type="checkbox" value="Tidak Ada" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['tidak_ada_dhl'] == 'Tidak Ada' ? 'checked' : '' }}>
                                Tidak Ada
                            </td>
                        </tr>
                        </tr>
                    </table>



                    <h5><b>Riwayat Penyakit Keluarga</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="9" style="padding: 5px;">Riwayat Penyakit Keluarga :</td>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][jantung_klg]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][jantung_klg]"
                                    type="checkbox" value="jantung" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['jantung_klg'] == 'jantung' ? 'checked' : '' }}>
                                jantung
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][asma_klg]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][asma_klg]" type="checkbox"
                                    value="asma" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['asma_klg'] == 'asma' ? 'checked' : '' }}>
                                asma
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][hipertensi_klg]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][hipertensi_klg]"
                                    type="checkbox" value="hipertensi" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['hipertensi_klg'] == 'hipertensi' ? 'checked' : '' }}>
                                hipertensi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][DM_klg]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][DM_klg]" type="checkbox"
                                    value="DM" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['DM_klg'] == 'DM' ? 'checked' : '' }}>
                                DM
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][hepatitis_klg]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][hepatitis_klg]"
                                    type="checkbox" value="Hepatitis" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['hepatitis_klg'] == 'Hepatitis' ? 'checked' : '' }}>
                                Hepatitis
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][alergi_klg]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][alergi_klg]" type="checkbox"
                                    value="Alergi" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['alergi_klg'] == 'Alergi' ? 'checked' : '' }}>
                                Alergi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][ginjal_klg]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][ginjal_klg]" type="checkbox"
                                    value="Ginjal" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['ginjal_klg'] == 'Ginjal' ? 'checked' : '' }}>
                                Ginjal
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][tidak_ada_klg]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][tidak_ada_klg]"
                                    type="checkbox" value="Tidak Ada" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['tidak_ada_klg'] == 'Tidak Ada' ? 'checked' : '' }}>
                                Tidak Ada
                            </td>
                        </tr>
                        </tr>
                    </table>



                    <h5><b>Riwayat Gynecolog</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="9" style="padding: 5px;">Riwayat Gynecolog :</td>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][infertilitas]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][infertilitas]"
                                    type="checkbox" value="Infertilitas" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['infertilitas'] == 'Infertilitas' ? 'checked' : '' }}>
                                Infertilitas
                            </td>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][infeksi_virus]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][infeksi_virus]"
                                    type="checkbox" value="Infeksi Virus" id="flexCheckDefault" {{ @$dataAsesmenPonek['riwayat']['infeksi_virus'] == 'Infeksi Virus' ? 'checked' : '' }}>
                                Infeksi Virus
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][PMS]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][PMS]" type="checkbox" {{ @$dataAsesmenPonek['riwayat']['PMS'] == 'PMS' ? 'checked' : '' }}
                                    value="PMS" id="flexCheckDefault">
                                PMS
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][cervitis_akut]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][cervitis_akut]" {{ @$dataAsesmenPonek['riwayat']['cervitis_akut'] == 'Cervitis Akut' ? 'checked' : '' }}
                                    type="checkbox" value="Cervitis Akut" id="flexCheckDefault">
                                Cervitis Akut
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][endometriosis]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][endometriosis]" {{ @$dataAsesmenPonek['riwayat']['endometriosis'] == 'Endometriosis' ? 'checked' : '' }}
                                    type="checkbox" value="Endometriosis" id="flexCheckDefault">
                                Endometriosis
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][polyp_cervix]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][polyp_cervix]" {{ @$dataAsesmenPonek['riwayat']['polyp_cervix'] == 'Polyp Cervix' ? 'checked' : '' }}
                                    type="checkbox" value="Polyp Cervix" id="flexCheckDefault">
                                Polyp Cervix
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][myoma]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][myoma]" type="checkbox" {{ @$dataAsesmenPonek['riwayat']['myoma'] == 'Myoma' ? 'checked' : '' }}
                                    value="Myoma" id="flexCheckDefault">
                                Myoma
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][ca_cervix]" type="hidden"
                                    value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][ca_cervix]" type="checkbox" {{ @$dataAsesmenPonek['riwayat']['ca_cervix'] == 'Ca Cervix' ? 'checked' : '' }}
                                    value="Ca Cervix" id="flexCheckDefault">
                                Ca Cervix
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" name="asessment[riwayat][operai_kandungan]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" name="asessment[riwayat][operai_kandungan]" {{ @$dataAsesmenPonek['riwayat']['operai_kandungan'] == 'Operasi Kandungan' ? 'checked' : '' }}
                                    type="checkbox" value="Operasi Kandungan" id="flexCheckDefault">
                                Operasi Kandungan
                            </td>
                        </tr>
                        </tr>
                    </table>




                    <h5><b>Riwayat Kehamilan Dan Persalinan</b></h5>
                    <table style="width: 100%; text-align:center;"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;" border="2">
                        <tr>
                            <td style="padding: 5px;" rowspan="2">No</td>
                            <td style="padding: 5px;" rowspan="2">Tempat Persalinan</td>
                            <td style="padding: 5px;" rowspan="2">Jenis Persalinan</td>
                            <td style="padding: 5px;" rowspan="2">Penolong</td>
                            <td style="padding: 5px;" rowspan="2">Penyulit Kehamilan</td>
                            <td style="padding: 5px;" colspan="3">Anak</td>
                        </tr>
                        <tr>
                            <td>L/P</td>
                            <td>BB</td>
                            <td>Hidup/Mati</td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat1][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['tempat'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['jenis'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['penolong'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['penyulit'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['jkelamin'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['bb'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat1][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat1']['h/p'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat2][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['tempat'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['jenis'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['penolong'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['penyulit'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['jkelamin'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['bb'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat2][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat2']['h/p'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat4][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat4][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat4']['no'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat5][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat5][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat5']['no'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat6][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat6][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat6']['no'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat7][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat7][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat7']['no'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat8][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat8][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat8']['no'] }}"
                                    id="H/P">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="asessment[riwayat9][no]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="No">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][tempat]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="Tempat">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][jenis]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="Jenis">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][penolong]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="Penolong">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][penyulit]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="Penyulit">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][jkelamin]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="Jkelamin">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][bb]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="BB">
                            </td>
                            <td>
                                <input name="asessment[riwayat9][h/p]" type="text" class="form-control" value="{{ @$dataAsesmenPonek['riwayat9']['no'] }}"
                                    id="H/P">
                            </td>
                        </tr>                       
                    </table>


                    <h5><b>Riwayat KB</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td style="padding: 5px;">KB :</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][ya]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkb" name="asessment[riwayat][ya]" {{ @$dataAsesmenPonek['riwayat']['ya'] == 'Iya' ? 'checked' : '' }}
                                    type="checkbox" value="Iya" id="flexCheckDefault">
                                Ya
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][tidak]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkb" name="asessment[riwayat][tidak]" {{ @$dataAsesmenPonek['riwayat']['tidak'] == 'tidak' ? 'checked' : '' }}
                                    type="checkbox" value="tidak" id="flexCheckDefault">
                                Tidak
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;" rowspan="3">KB Yang Pernah Dipakai</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][pil]"
                                    type="hidden" value="pil" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkb" name="asessment[riwayat][pil]" {{ @$dataAsesmenPonek['riwayat']['pil'] == 'pil' ? 'checked' : '' }}
                                    type="checkbox" value="pil" id="flexCheckDefault">
                                Pil KB
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][iud]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkb" name="asessment[riwayat][iud]" {{ @$dataAsesmenPonek['riwayat']['iud'] == 'iud' ? 'checked' : '' }}
                                    type="checkbox" value="iud" id="flexCheckDefault">
                                IUD
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][suntik]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkb" name="asessment[riwayat][suntik]" {{ @$dataAsesmenPonek['riwayat']['suntik'] == 'suntik' ? 'checked' : '' }}
                                    type="checkbox" value="suntik" id="flexCheckDefault">
                                Suntik
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][susuk]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayatkb" name="asessment[riwayat][susuk]" {{ @$dataAsesmenPonek['riwayat']['susuk'] == 'susuk' ? 'checked' : '' }}
                                    type="checkbox" value="susuk" id="flexCheckDefault">
                                Susuk/Norplant
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="form-control" type="text" name="asessment[riwayat][lainnya4]" value="{{ @$dataAsesmenPonek['riwayat']['lainnya4'] }}"
                                    placeholder="Lainnya">
                            </td>
                        </tr>
                    </table>

                    <h5><b>Riwayat ANC</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td style="padding: 5px;" rowspan="3">ANC :</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][ya2]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][ya2]" {{ @$dataAsesmenPonek['riwayat']['ya2'] == 'Iya' ? 'checked' : '' }}
                                    type="checkbox" value="Iya" id="flexCheckDefault">
                                Ya
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][tidak2]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][tidak2]" {{ @$dataAsesmenPonek['riwayat']['tidak2'] == 'tidak' ? 'checked' : '' }}
                                    type="checkbox" value="tidak" id="flexCheckDefault">
                                Tidak
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][kandungan]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][kandungan]" type="checkbox" value="kandungan" {{ @$dataAsesmenPonek['riwayat']['kandungan'] == 'kandungan' ? 'checked' : '' }}
                                    id="flexCheckDefault">
                                Dokter Kandungan
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][bidan]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][bidan]" {{ @$dataAsesmenPonek['riwayat']['bidan'] == 'bidan' ? 'checked' : '' }}
                                    type="checkbox" value="bidan" id="flexCheckDefault">
                                Bidan
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="form-control" type="text" name="asessment[riwayat][lainnya5]" value="{{ @$dataAsesmenPonek['riwayat']['lainnya5'] }}"
                                    placeholder="Lainnya">
                            </td>
                        </tr>
                    </table>

                    <h5><b>Keluhan Saat Hamil</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td style="padding: 5px;" rowspan="2">Hamil Muda :</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][mual1]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][mual1]"{{ @$dataAsesmenPonek['riwayat']['mual1'] == 'mual' ? 'checked' : '' }}
                                    type="checkbox" value="mual" id="flexCheckDefault">
                                Mual/Muntah
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][perdarahan1]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][perdarahan1]" type="checkbox" value="perdarahan" {{ @$dataAsesmenPonek['riwayat']['perdarahan1'] == 'perdarahan' ? 'checked' : '' }}
                                    id="flexCheckDefault">
                                Perdarahan
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="form-control" type="text" name="asessment[riwayat][lainnya6]" value="{{ @$dataAsesmenPonek['riwayat']['lainnya6'] }}"
                                    placeholder="Lainnya">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;" rowspan="2">Hamil Tua :</td>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][mual2]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][mual2]" {{ @$dataAsesmenPonek['riwayat']['mual2'] == 'mual' ? 'checked' : '' }}
                                    type="checkbox" value="mual" id="flexCheckDefault">
                                Mual/Muntah
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][perdarahan2]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][perdarahan2]" type="checkbox" value="perdarahan" {{ @$dataAsesmenPonek['riwayat']['perdarahan2'] == 'perdarahan' ? 'checked' : '' }}
                                    id="flexCheckDefault">
                                Perdarahan
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="form-control" type="text" name="asessment[riwayat][lainnya7]" value="{{ @$dataAsesmenPonek['riwayat']['lainnya7'] }}"
                                    placeholder="Lainnya">
                            </td>
                        </tr>
                    </table>

                    <h5><b>Keadaan Bio Psikososial</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table-center table"
                        style="font-size:12px;">
                        <tr>
                            <td style="padding: 5px;" rowspan="3">Pola Makan (x/hari) :</td>
                            <td colspan="2">
                                <input class="form-control" type="text" name="asessment[riwayat][polamakan]" value="{{ @$dataAsesmenPonek['riwayat']['polamakan'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][muntah]"
                                    type="hidden" value="-" id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat" name="asessment[riwayat][muntah]" {{ @$dataAsesmenPonek['riwayat']['muntah'] == 'muntah' ? 'checked' : '' }}
                                    type="checkbox" value="muntah" id="flexCheckDefault">
                                Muntah
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][sulitmenelan]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][sulitmenelan]" type="checkbox" value="sulitmenelan" {{ @$dataAsesmenPonek['riwayat']['sulitmenelan'] == 'sulitmenelan' ? 'checked' : '' }}
                                    id="flexCheckDefault">
                                Sulit Menelan
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][sulitmengunyah]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][sulitmengunyah]" type="checkbox" {{ @$dataAsesmenPonek['riwayat']['sulitmengunyah'] == 'sulitmengunyah' ? 'checked' : '' }}
                                    value="sulitmengunyah" id="flexCheckDefault">
                                Sulit Mengunyah
                            </td>
                            <td>
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][nafsumakan]" type="hidden" value="-"
                                    id="flexCheckDefault">
                                <input class="form-check-input" class="riwayat"
                                    name="asessment[riwayat][nafsumakan]" type="checkbox" value="nafsumakan" {{ @$dataAsesmenPonek['riwayat']['nafsumakan'] == 'nafsumakan' ? 'checked' : '' }}
                                    id="flexCheckDefault">
                                Kehilangan Nafsu Makan
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Pola Minum (cc/hari) :</td>
                            <td colspan="2">
                                <input class="form-control" type="text" name="asessment[riwayat][polaminum]" value="{{ @$dataAsesmenPonek['riwayat']['polaminum'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;" rowspan="3">Pola Eleminasi :</td>
                            <td>BAK</td>
                            <td>Warna</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="asessment[riwayat][BAK]" value="{{ @$dataAsesmenPonek['riwayat']['BAK'] }}"
                                    placeholder="cc/hari">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="asessment[riwayat][warna]" value="{{ @$dataAsesmenPonek['riwayat']['warna'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td>BAB</td>
                            <td>
                                <input type="text" class="form-control" name="asessment[riwayat][banyak]" value="{{ @$dataAsesmenPonek['riwayat']['banyak'] }}"
                                    placeholder="x/hari">
                            </td>
                        </tr>
                    </table>

                    




                    
                </div>

                <div class="col-md-6">
                    <h5><b>Pemeriksaan Fisik</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td colspan="2" style="width:50%; font-weight:bold;">Pemeriksaan Fisik</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width:50%; font-weight:bold;">1. Kepala</td>
                        </tr>
                        {{-- <tr>
                            <td style="font-weight:500; width: 50%;">Cloasma Gravidarum</td>
                            <td>
                                <input type="radio" id="cloasma_1"
                                    name="asessment[pemeriksaanFisik][muka][cloasma]" value="Tidak" {{ @$dataAsesmenPonek['pemeriksaanFisik']['muka']['cloasma'] == 'Tidak' ? 'checked' : '' }}>
                                <label for="cloasma_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="cloasma_2"
                                    name="asessment[pemeriksaanFisik][muka][cloasma]" value="Ada" {{ @$dataAsesmenPonek['pemeriksaanFisik']['muka']['cloasma'] == 'Ada' ? 'checked' : '' }}>
                                <label for="cloasma_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr> --}}

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:500;">Mata</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Anemis</td>
                            <td>
                                <input type="radio" id="anemis_1"
                                    name="asessment[pemeriksaanFisik][mata][anemis]" value="-/-" {{ @$dataAsesmenPonek['pemeriksaanFisik']['mata']['anemis'] == '-/-' ? 'checked' : '' }}>
                                <label for="anemis_1"
                                    style="font-weight: normal; margin-right: 10px;">-/-</label>
                                <input type="radio" id="anemis_2"
                                    name="asessment[pemeriksaanFisik][mata][anemis]" value="+/+" {{ @$dataAsesmenPonek['pemeriksaanFisik']['mata']['anemis'] == '+/+' ? 'checked' : '' }}>
                                <label for="anemis_2"
                                    style="font-weight: normal; margin-right: 10px;">+/+</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Ikterik</td>
                            <td>
                                <input type="radio" id="ikterik_1"
                                    name="asessment[pemeriksaanFisik][mata][ikterik]" value="-/-" {{ @$dataAsesmenPonek['pemeriksaanFisik']['mata']['ikterik'] == '-/-' ? 'checked' : '' }}>
                                <label for="ikterik_1"
                                    style="font-weight: normal; margin-right: 10px;">-/-</label>
                                <input type="radio" id="ikterik_2"
                                    name="asessment[pemeriksaanFisik][mata][ikterik]" value="+/+" {{ @$dataAsesmenPonek['pemeriksaanFisik']['mata']['ikterik'] == '+/+' ? 'checked' : '' }}>
                                <label for="ikterik_2"
                                    style="font-weight: normal; margin-right: 10px;">+/+</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Lainnya</td>
                            <td>
                                <input type="text" name="asessment[pemeriksaanFisik][mata][lainnya]" class="form-control" id="" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['mata']['lainnya']}}">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:bold;">2. Leher</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">KGB Membesar</td>
                            <td>
                                <input type="radio" id="kgb_1"
                                    name="asessment[pemeriksaanFisik][leher][kgb]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['leher']['kgb'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="kgb_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="kgb_2"
                                    name="asessment[pemeriksaanFisik][leher][kgb]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['leher']['kgb'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="kgb_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">JVP Meningkat</td>
                            <td>
                                <input type="radio" id="jvp_1"
                                    name="asessment[pemeriksaanFisik][leher][jvp]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['leher']['jvp'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="jvp_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="jvp_2"
                                    name="asessment[pemeriksaanFisik][leher][jvp]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['leher']['jvp'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="jvp_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:bold;">3. Payudara</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Bentuk</td>
                            <td>
                                <input type="radio" id="bentuk_1"
                                    name="asessment[pemeriksaanFisik][payudara][bentuk]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['bentuk'] == 'Simetris' ? 'checked' : '' }} value="Simetris">
                                <label for="bentuk_1"
                                    style="font-weight: normal; margin-right: 10px;">Simetris</label>
                                <input type="radio" id="bentuk_2"
                                    name="asessment[pemeriksaanFisik][payudara][bentuk]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['bentuk'] == 'Asimetris' ? 'checked' : '' }} value="Asimetris">
                                <label for="bentuk_2"
                                    style="font-weight: normal; margin-right: 10px;">Asimetris</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">ASI</td>
                            <td>
                                <input type="radio" id="pengeluaran_1"
                                    name="asessment[pemeriksaanFisik][payudara][asi]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['asi'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="pengeluaran_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="pengeluaran_2"
                                    name="asessment[pemeriksaanFisik][payudara][asi]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['asi'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                <label for="pengeluaran_2"
                                    style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Kolostrum</td>
                            <td>
                                <input type="radio" id="kolostrum_1"
                                    name="asessment[pemeriksaanFisik][payudara][kolostrum]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['kolostrum'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="kolostrum_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="kolostrum_2"
                                    name="asessment[pemeriksaanFisik][payudara][kolostrum]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['kolostrum'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="kolostrum_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">TFU</td>
                            <td>
                                <input type="text" name="asessment[pemeriksaanFisik][payudara][tfu]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['payudara']['tfu'] }}" class="form-control"
                                    style="display: inline-block;" id="" placeholder="TFU">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:bold;">4. Abdomen</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Linea Nigra</td>
                            <td>
                                <input type="radio" id="linea_1"
                                    name="asessment[pemeriksaanFisik][abdomen][linea]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['linea'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="linea_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="linea_2"
                                    name="asessment[pemeriksaanFisik][abdomen][linea]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['linea'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="linea_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Striae</td>
                            <td>
                                <input type="radio" id="striae_1"
                                    name="asessment[pemeriksaanFisik][abdomen][striae]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['striae'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="striae_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="striae_2"
                                    name="asessment[pemeriksaanFisik][abdomen][striae]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['striae'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="striae_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Luka Bekas Operasi</td>
                            <td>
                                <input type="radio" id="lukaBekasOperasi_1"
                                    name="asessment[pemeriksaanFisik][abdomen][lukaBekasOperasi]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['lukaBekasOperasi'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="lukaBekasOperasi_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="lukaBekasOperasi_2"
                                    name="asessment[pemeriksaanFisik][abdomen][lukaBekasOperasi]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['lukaBekasOperasi'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="lukaBekasOperasi_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>

                        
                        <tr>
                            <td style="font-weight:500; width: 50%;">Kontraksi Uterus</td>
                            <td>
                                <input type="radio" id="kontraksiUterus_1"
                                    name="asessment[pemeriksaanFisik][abdomen][kontraksiUterus][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['kontraksiUterus']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                    value="Baik">
                                <label for="kontraksiUterus_1"
                                    style="font-weight: normal; margin-right: 10px;">Baik</label>
                                <input type="radio" id="kontraksiUterus_2"
                                    name="asessment[pemeriksaanFisik][abdomen][kontraksiUterus][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['kontraksiUterus']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                    value="Tidak">
                                <label for="kontraksiUterus_2"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label><br />
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Massa</td>
                            <td>
                                <input type="radio" id="massa_1"
                                    name="asessment[pemeriksaanFisik][abdomen][massa]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['massa'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="massa_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="massa_2"
                                    name="asessment[pemeriksaanFisik][abdomen][massa]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['massa'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="massa_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Nyeri Tekan</td>
                            <td>
                                <input type="radio" id="nyeriTekan_1"
                                    name="asessment[pemeriksaanFisik][abdomen][nyeriTekan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['nyeriTekan'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="nyeriTekan_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="nyeriTekan_2"
                                    name="asessment[pemeriksaanFisik][abdomen][nyeriTekan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['nyeriTekan'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                <label for="nyeriTekan_2"
                                    style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">BJA (x/menit)</td>
                            {{-- <td>
                                <input type="radio" id="BJA_1"
                                    name="asessment[pemeriksaanFisik][abdomen][BJA]" value="Reguler">
                                <label for="BJA_1"
                                    style="font-weight: normal; margin-right: 10px;">Reguler</label>
                                <input type="radio" id="BJA_2"
                                    name="asessment[pemeriksaanFisik][abdomen][BJA]" value="Irreguler">
                                <label for="BJA_2"
                                    style="font-weight: normal; margin-right: 10px;">Irreguler</label><br />
                                    <div>
                                        <input type="number" name="asessment[pemeriksaanFisik][abdomen][bja_detail_1]" style="display:inline-block" class="form-control" id="">
                                    </div>
                                    <div style="margin-top: 8px;">
                                        <input type="number" name="asessment[pemeriksaanFisik][abdomen][bja_detail_2]" style="display:inline-block" class="form-control" id="">
                                    </div>
                            </td> --}}
                            <td>
                                <input type="text" name="asessment[pemeriksaanFisik][abdomen][bja]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['bja'] }}"
                                    class="form-control" style="display: inline-block;" id=""
                                    placeholder="">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Bising Usus</td>
                            <td>
                                <input type="radio" id="bisingUsus_1"
                                    name="asessment[pemeriksaanFisik][abdomen][bisingUsus]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['bisingUsus'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="bisingUsus_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="bisingUsus_2"
                                    name="asessment[pemeriksaanFisik][abdomen][bisingUsus]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['bisingUsus'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="bisingUsus_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                                <input type="text" name="asessment[pemeriksaanFisik][abdomen][bisingUsusFrekuensi]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['bisingUsusFrekuensi'] }}" placeholder="Frekuensi" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Leopold I</td>
                            <td>
                                <label for="leopold1_1" style="font-weight: normal; margin-right: 10px;">
                                <input type="radio" id="leopold1_1"
                                    name="asessment[pemeriksaanFisik][abdomen][leopold1][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold1']['pilihan'] == 'Bokong' ? 'checked' : '' }} value="Bokong">
                                Bokong</label>

                                <label for="leopold1_2" style="font-weight: normal; margin-right: 10px;">
                                <input type="radio" id="leopold1_2"
                                    name="asessment[pemeriksaanFisik][abdomen][leopold1][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold1']['pilihan'] == 'Kepala' ? 'checked' : '' }} value="Kepala">
                                Kepala</label>

                                <label for="leopold1_3" style="font-weight: normal; margin-right: 10px;">
                                <input type="radio" id="leopold1_3"
                                    name="asessment[pemeriksaanFisik][abdomen][leopold1][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold1']['pilihan'] == 'Bagian Terkecil' ? 'checked' : '' }} value="Bagian Terkecil">
                                Bagian Terkecil</label>
                                <br />

                                <label for="leopold1_4" style="font-weight: normal; margin-right: 10px;">
                                <input type="radio" id="leopold1_4"
                                    name="asessment[pemeriksaanFisik][abdomen][leopold1][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold1']['pilihan'] == 'Lainnya' ? 'checked' : '' }} value="Lainnya">
                                Lainnya</label>

                                <br />
                                <input type="text" name="asessment[pemeriksaanFisik][abdomen][leopold1][sebutkan]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold1']['sebutkan'] }}" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Leopold II</td>
                            <td>
                                <label for="leopold2_2" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold2_2"
                                        name="asessment[pemeriksaanFisik][abdomen][leopold2][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold2']['pilihan'] == 'Puka' ? 'checked' : '' }} value="Puka">
                                    Puka</label>
    
                                    <label for="leopold2_3" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold2_3"
                                        name="asessment[pemeriksaanFisik][abdomen][leopold2][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold2']['pilihan'] == 'Puki' ? 'checked' : '' }} value="Puki">
                                    Puki</label>
                                    <br />
    
                                    <label for="leopold2_4" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold2_4" name="asessment[pemeriksaanFisik][abdomen][leopold2][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold2']['pilihan'] == 'Lainnya' ? 'checked' : '' }} value="Lainnya">
                                    Lainnya</label>
                                    
                                    <br />
                                    <input type="text" name="asessment[pemeriksaanFisik][abdomen][leopold2][sebutkan]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold2']['sebutkan'] }}" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Leopold III</td>
                            <td>
                                <label for="leopold3_1" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold3_1"
                                        name="asessment[pemeriksaanFisik][abdomen][leopold3][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold3']['pilihan'] == 'Bokong' ? 'checked' : '' }} value="Bokong">
                                    Bokong</label>
    
                                    <label for="leopold3_2" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold3_2"
                                        name="asessment[pemeriksaanFisik][abdomen][leopold3][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold3']['pilihan'] == 'Kepala' ? 'checked' : '' }} value="Kepala">
                                    Kepala</label>
    
                                    <label for="leopold3_3" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold3_3"
                                        name="asessment[pemeriksaanFisik][abdomen][leopold3][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold3']['pilihan'] == 'Bagian Terkecil' ? 'checked' : '' }} value="Bagian Terkecil">
                                    Bagian Terkecil</label>
                                    <br />
    
                                    <label for="leopold3_4" style="font-weight: normal; margin-right: 10px;">
                                    <input type="radio" id="leopold3_4" name="asessment[pemeriksaanFisik][abdomen][leopold3][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold3']['pilihan'] == 'Lainnya' ? 'checked' : '' }} value="Lainnya">
                                    Lainnya</label>
    
                                    <br />
                                    <input type="text" name="asessment[pemeriksaanFisik][abdomen][leopold3][sebutkan]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold3']['sebutkan'] }}" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Leopold IV</td>
                            <td>
                                <label for="leopold4_1" style="font-weight: normal; margin-right: 10px;">
                                <input type="radio" id="leopold4_1"
                                    name="asessment[pemeriksaanFisik][abdomen][leopold4][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold4']['pilihan'] == 'Konvergen' ? 'checked' : '' }} value="Konvergen">
                                Konvergen</label>

                                <label for="leopold4_2" style="font-weight: normal; margin-right: 10px;">
                                <input type="radio" id="leopold4_2"
                                    name="asessment[pemeriksaanFisik][abdomen][leopold4][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['abdomen']['leopold4']['pilihan'] == 'Divergen' ? 'checked' : '' }} value="Divergen">
                                Divergen</label>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:bold;">5. Genitalia</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Pengeluaran</td>
                            <td style="">
                                <input type="radio" id="pengeluaran_1"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Keputihan' ? 'checked' : '' }}
                                    value="Keputihan">
                                <label for="pengeluaran_1"
                                    style="font-weight: normal; margin-right: 10px;">Keputihan</label><br />
                                <input type="radio" id="pengeluaran_2"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Blood Show' ? 'checked' : '' }}
                                    value="Blood Show">
                                <label for="pengeluaran_2" style="font-weight: normal; margin-right: 10px;">Blood
                                    Show</label><br />
                                <input type="radio" id="pengeluaran_3"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Flek' ? 'checked' : '' }}
                                    value="Flek">
                                <label for="pengeluaran_3"
                                    style="font-weight: normal; margin-right: 10px;">Flek</label><br />
                                <input type="radio" id="pengeluaran_4"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Stosel' ? 'checked' : '' }}
                                    value="Stosel">
                                <label for="pengeluaran_4"
                                    style="font-weight: normal; margin-right: 10px;">Stosel</label><br />
                                <input type="radio" id="pengeluaran_5"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Ketuban' ? 'checked' : '' }}
                                    value="Ketuban">
                                <label for="pengeluaran_5"
                                    style="font-weight: normal; margin-right: 10px;">Ketuban</label><br />
                                <input type="radio" id="pengeluaran_6"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Nanah' ? 'checked' : '' }}
                                    value="Nanah">
                                <label for="pengeluaran_6"
                                    style="font-weight: normal; margin-right: 10px;">Nanah</label><br />
                                <input type="radio" id="pengeluaran_7"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] == 'Lainnya' ? 'checked' : '' }}
                                    value="Lainnya">
                                <label for="pengeluaran_7"
                                    style="font-weight: normal; margin-right: 10px;">Lainnya</label><br />
                                <input type="text"
                                    name="asessment[pemeriksaanFisik][genitalia][pengeluaran][jelaskan]" value="{{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['pengeluaran']['jelaskan'] }}"
                                    class="form-control" style="display: inline-block;" id=""
                                    placeholder="Jelaskan">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Kelainan</td>
                            <td>
                                <input type="radio" id="kelainan_1"
                                    name="asessment[pemeriksaanFisik][genitalia][kelainan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['kelainan']['pilihan'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="kelainan_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="kelainan_2"
                                    name="asessment[pemeriksaanFisik][genitalia][kelainan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['kelainan']['pilihan'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="kelainan_2"
                                    style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Lochea</td>
                            <td>
                                <input type="radio" id="lochea_1"
                                    name="asessment[pemeriksaanFisik][genitalia][lochea][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="lochea_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="lochea_2"
                                    name="asessment[pemeriksaanFisik][genitalia][lochea][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                <label for="lochea_2" style="font-weight: normal; margin-right: 10px;">Ada</label>
                                <input type="radio" id="lochea_3"
                                    name="asessment[pemeriksaanFisik][genitalia][lochea][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] == 'Rubra' ? 'checked' : '' }} value="Rubra">
                                <label for="lochea_3"
                                    style="font-weight: normal; margin-right: 10px;">Rubra</label><br />
                                <input type="radio" id="lochea_4"
                                    name="asessment[pemeriksaanFisik][genitalia][lochea][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] == 'Sangulienta' ? 'checked' : '' }} value="Sangulienta">
                                <label for="lochea_4"
                                    style="font-weight: normal; margin-right: 10px;">Sangulienta</label>
                                <input type="radio" id="lochea_5"
                                    name="asessment[pemeriksaanFisik][genitalia][lochea][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] == 'Alba' ? 'checked' : '' }} value="Alba">
                                <label for="lochea_5"
                                    style="font-weight: normal; margin-right: 10px;">Alba</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Perineum</td>
                            <td>
                                <input type="radio" id="perineum_1"
                                    name="asessment[pemeriksaanFisik][genitalia][perineum][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['perineum']['pilihan'] == 'Utuh' ? 'checked' : '' }} value="Utuh">
                                <label for="perineum_1"
                                    style="font-weight: normal; margin-right: 10px;">Utuh</label>
                                <input type="radio" id="perineum_2"
                                    name="asessment[pemeriksaanFisik][genitalia][perineum][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['perineum']['pilihan'] == 'Jaringan Parut' ? 'checked' : '' }} value="Jaringan Parut">
                                <label for="perineum_2" style="font-weight: normal; margin-right: 10px;">Jaringan
                                    Parut</label><br />
                                <input type="radio" id="perineum_3"
                                    name="asessment[pemeriksaanFisik][genitalia][perineum][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['perineum']['pilihan'] == 'Varises' ? 'checked' : '' }} value="Varises">
                                <label for="perineum_3"
                                    style="font-weight: normal; margin-right: 10px;">Varises</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Jahitan</td>
                            <td>
                                <input type="radio" id="jahitan_1"
                                    name="asessment[pemeriksaanFisik][genitalia][jahitan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['jahitan']['pilihan'] == 'Baik' ? 'checked' : '' }} value="Baik">
                                <label for="jahitan_1" style="font-weight: normal; margin-right: 10px;">Baik</label>
                                <input type="radio" id="jahitan_2"
                                    name="asessment[pemeriksaanFisik][genitalia][jahitan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['jahitan']['pilihan'] == 'Terlepas' ? 'checked' : '' }}
                                    value="Terlepas">
                                <label for="jahitan_2"
                                    style="font-weight: normal; margin-right: 10px;">Terlepas</label><br />
                                <input type="radio" id="jahitan_3"
                                    name="asessment[pemeriksaanFisik][genitalia][jahitan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['jahitan']['pilihan'] == 'Hematom' ? 'checked' : '' }} value="Hematom">
                                <label for="jahitan_3"
                                    style="font-weight: normal; margin-right: 10px;">Hematom</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Robekan</td>
                            <td>
                                <input type="radio" id="robekan_1"
                                    name="asessment[pemeriksaanFisik][genitalia][robekan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] == 'Grade I' ? 'checked' : '' }} value="Grade I">
                                <label for="robekan_1" style="font-weight: normal; margin-right: 10px;">Grade
                                    I</label>
                                <input type="radio" id="robekan_2"
                                    name="asessment[pemeriksaanFisik][genitalia][robekan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] == 'Grade II' ? 'checked' : '' }}
                                    value="Grade II">
                                <label for="robekan_2" style="font-weight: normal; margin-right: 10px;">Grade
                                    II</label><br />
                                <input type="radio" id="robekan_3"
                                    name="asessment[pemeriksaanFisik][genitalia][robekan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] == 'Grade III' ? 'checked' : '' }}
                                    value="Grade III">
                                <label for="robekan_3" style="font-weight: normal; margin-right: 10px;">Grade
                                    III</label>
                                <input type="radio" id="robekan_4"
                                    name="asessment[pemeriksaanFisik][genitalia][robekan][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] == 'Grade IV' ? 'checked' : '' }}
                                    value="Grade IV">
                                <label for="robekan_4" style="font-weight: normal; margin-right: 10px;">Grade
                                    IV</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Anus</td>
                            <td>
                                <input type="radio" id="anus_1"
                                    name="asessment[pemeriksaanFisik][genitalia][anus][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['anus']['pilihan'] == 'Haemoroid' ? 'checked' : '' }} value="Haemoroid">
                                <label for="anus_1"
                                    style="font-weight: normal; margin-right: 10px;">Haemoroid</label>
                                <input type="radio" id="anus_2"
                                    name="asessment[pemeriksaanFisik][genitalia][anus][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['anus']['pilihan'] == 'Condiloma' ? 'checked' : '' }} value="Condiloma">
                                <label for="anus_2"
                                    style="font-weight: normal; margin-right: 10px;">Condiloma</label><br />
                                <input type="radio" id="anus_3"
                                    name="asessment[pemeriksaanFisik][genitalia][anus][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['genitalia']['anus']['pilihan'] == 'T.A.K' ? 'checked' : '' }} value="T.A.K">
                                <label for="anus_3"
                                    style="font-weight: normal; margin-right: 10px;">T.A.K</label><br />
                            </td>
                        </tr>

                        {{-- <tr>
                            <td colspan="2" style="width:50%; font-weight:500;">Nifas</td>
                        </tr> --}}
                        {{-- <tr>
                            <td style="font-weight:500; width: 50%;">TFU</td>
                            <td>
                                <input type="text" name="asessment[pemeriksaanFisik][nifas][tfu]"
                                    class="form-control" style="display: inline-block;" id=""
                                    placeholder="">
                            </td>
                        </tr> --}}

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:500;">Pemeriksaan Dalam</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Vulva Vagina</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][vulvaVaginaPilihan1]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan1'] == 'T.A.K' ? 'checked' : '' }}
                                        value="T.A.K"> <label style="font-weight: normal; margin-right: 10px;" for="">T.A.K</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][vulvaVaginaPilihan2]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan2'] == 'Tampak Tali Pusat' ? 'checked' : '' }}
                                        value="Tampak Tali Pusat"><label style="font-weight: normal; margin-right: 10px;" for="">Tampak Tali Pusat</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][vulvaVaginaPilihan3]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan3'] == 'Ruptur' ? 'checked' : '' }}
                                        value="Ruptur"><label style="font-weight: normal; margin-right: 10px;" for="">Ruptur</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][vulvaVaginaPilihan4]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan4'] == 'Kista bartholini' ? 'checked' : '' }}
                                        value="Kista bartholini"><label style="font-weight: normal; margin-right: 10px;" for="">Kista bartholini</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][vulvaVaginaPilihan5]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan5'] == 'Varises' ? 'checked' : '' }}
                                        value="Varises"><label style="font-weight: normal; margin-right: 10px;" for="">Varises</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][vulvaVagina]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVagina'] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Portio</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][portioPilihan][tebal]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['tebal'] == 'Tebal' ? 'checked' : '' }}
                                        value="Tebal"> <label style="font-weight: normal; margin-right: 10px;" for="">Tebal</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][portioPilihan][lunak]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['lunak'] == 'Lunak' ? 'checked' : '' }}
                                        value="Lunak"><label style="font-weight: normal; margin-right: 10px;" for="">Lunak</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][portioPilihan][tipis]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['tipis'] == 'Tipis' ? 'checked' : '' }}
                                        value="Tipis"><label style="font-weight: normal; margin-right: 10px;" for="">Tipis</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][portioPilihan][kaku]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['kaku'] == 'Kaku' ? 'checked' : '' }}
                                        value="Kaku"><label style="font-weight: normal; margin-right: 10px;" for="">Kaku</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][portioPilihan][ruptur]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['ruptur'] == 'Ruptur' ? 'checked' : '' }}
                                        value="Ruptur"><label style="font-weight: normal; margin-right: 10px;" for="">Ruptur</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][portio]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['portio'] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Ketuban</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][ketubanPilihan1]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['ketubanPilihan1'] == 'Positif' ? 'checked' : '' }}
                                        value="Positif"> <label style="font-weight: normal; margin-right: 10px;" for="">Positif</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][ketubanPilihan2]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['ketubanPilihan2'] == 'Negatif' ? 'checked' : '' }}
                                        value="Negatif"><label style="font-weight: normal; margin-right: 10px;" for="">Negatif</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][ketuban]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['ketuban'] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Sisa</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][sisaPilihan1]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan1'] == 'Jernih' ? 'checked' : '' }}
                                        value="Jernih"> <label style="font-weight: normal; margin-right: 10px;" for="">Jernih</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][sisaPilihan2]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan2'] == 'Keruh' ? 'checked' : '' }}
                                        value="Keruh"><label style="font-weight: normal; margin-right: 10px;" for="">Keruh</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][sisaPilihan3]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan3'] == 'Hijau' ? 'checked' : '' }}
                                        value="Hijau"><label style="font-weight: normal; margin-right: 10px;" for="">Hijau</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][sisaPilihan4]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan4'] == 'Mekonium' ? 'checked' : '' }}
                                        value="Mekonium"><label style="font-weight: normal; margin-right: 10px;" for="">Mekonium</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][sisa]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['sisa'] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Lakmus</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][lakmusPilihan1]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['lakmusPilihan1'] == 'Positif' ? 'checked' : '' }}
                                        value="Positif"> <label style="font-weight: normal; margin-right: 10px;" for="">Positif</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][lakmusPilihan2]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['lakmusPilihan2'] == 'Negatif' ? 'checked' : '' }}
                                        value="Negatif"><label style="font-weight: normal; margin-right: 10px;" for="">Negatif</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][lakmus]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['lakmus'] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Presentasi</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][presentasiPilihan1]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan1'] == 'Kepala' ? 'checked' : '' }}
                                        value="Kepala"> <label style="font-weight: normal; margin-right: 10px;" for="">Kepala</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][presentasiPilihan2]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan2'] == 'Bokong' ? 'checked' : '' }}
                                        value="Bokong"><label style="font-weight: normal; margin-right: 10px;" for="">Bokong</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][presentasiPilihan3]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan3'] == 'Kaki' ? 'checked' : '' }}
                                        value="Kaki"><label style="font-weight: normal; margin-right: 10px;" for="">Kaki</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][presentasiPilihan4]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan4'] == 'Lintang' ? 'checked' : '' }}
                                        value="Lintang"><label style="font-weight: normal; margin-right: 10px;" for="">Lintang</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][presentasi]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['presentasi'] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">Penurunan Kepala</td>
                            <td>
                                <div>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][penurunanKepalaPilihan1]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan1'] == 'Hodge 1' ? 'checked' : '' }}
                                        value="Hodge 1"> <label style="font-weight: normal; margin-right: 10px;" for="">Hodge 1</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][penurunanKepalaPilihan2]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan2'] == 'Hodge 2' ? 'checked' : '' }}
                                        value="Hodge 2"><label style="font-weight: normal; margin-right: 10px;" for="">Hodge 2</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][penurunanKepalaPilihan3]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan3'] == 'Hodge 3' ? 'checked' : '' }}
                                        value="Hodge 3"><label style="font-weight: normal; margin-right: 10px;" for="">Hodge 3</label>
                                    <input type="checkbox"
                                        name="asessment[pemeriksaanFisik][pemeriksaanDalam][penurunanKepalaPilihan4]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan4'] == 'Hodge 4' ? 'checked' : '' }}
                                        value="Hodge 4"><label style="font-weight: normal; margin-right: 10px;" for="">Hodge 4</label>
                                </div>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][penurunanKepala]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepala'] }}</textarea>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="font-weight:500; width: 50%;">Pemeriksaan Dalam</td>
                            <td>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][presentaseFetus]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['presentaseFetus'] }}</textarea>
                            </td>
                        </tr> --}}
                        <tr>
                            <td style="font-weight:500; width: 50%;">Pembukaan</td>
                            <td>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][pemeriksaanDalam][pembukaan]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['pemeriksaanDalam']['pembukaan'] }}</textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width:50%; font-weight:500;">Gyonecologi</td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">a) Kelenjar Bartholini</td>
                            <td>
                                <input type="radio" id="kelenjarBartholini_1"
                                    name="asessment[pemeriksaanFisik][gyonecologi][kelenjarBartholini][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['gyonecologi']['kelenjarBartholini']['pilihan'] == 'Ada' ? 'checked' : '' }}
                                    value="Ada Pembengkakan">
                                <label for="kelenjarBartholini_1"
                                    style="font-weight: normal; margin-right: 10px;">Ada Pembengkakan</label>
                                <input type="radio" id="kelenjarBartholini_2"
                                    name="asessment[pemeriksaanFisik][gyonecologi][kelenjarBartholini][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['gyonecologi']['kelenjarBartholini']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                    value="Tidak">
                                <label for="kelenjarBartholini_2"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label><br />
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:500; width: 50%;">b) Inspekulo</td>
                            <td>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][gyonecologi][inspekulo]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['gyonecologi']['inspekulo'] }}</textarea>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Ekstremitas Atas dan Bawah</td>
                            <td>
                                <textarea rows="3" name="asessment[pemeriksaanFisik][ekstremitasAtasBawah]"
                                    style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$dataAsesmenPonek['pemeriksaanFisik']['ekstremitasAtasBawah'] }}</textarea>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Oedem</td>
                            <td>
                                <input type="radio" id="oedem_1"
                                    name="asessment[pemeriksaanFisik][oedem][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['oedem']['pilihan'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="oedem_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="oedem_2"
                                    name="asessment[pemeriksaanFisik][oedem][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['oedem']['pilihan'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                <label for="oedem_2"
                                    style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Varises</td>
                            <td>
                                <input type="radio" id="varises_1"
                                    name="asessment[pemeriksaanFisik][varises][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['varises']['pilihan'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="varises_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="varises_2"
                                    name="asessment[pemeriksaanFisik][varises][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['varises']['pilihan'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                <label for="varises_2"
                                    style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Kekuatan Otot dan Sendi</td>
                            <td>
                                <input type="radio" id="kekuatanOtot_1"
                                    name="asessment[pemeriksaanFisik][kekuatanOtot][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['kekuatanOtot']['pilihan'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                <label for="kekuatanOtot_1"
                                    style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="kekuatanOtot_2"
                                    name="asessment[pemeriksaanFisik][kekuatanOtot][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['kekuatanOtot']['pilihan'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                <label for="kekuatanOtot_2"
                                    style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:500; width: 50%;">Reflex</td>
                            <td>
                                <input type="radio" id="reflex_1"
                                    name="asessment[pemeriksaanFisik][reflex][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['reflex']['pilihan'] == 'Normal' ? 'checked' : '' }} value="Normal">
                                <label for="reflex_1"
                                    style="font-weight: normal; margin-right: 10px;">Normal</label>
                                <input type="radio" id="reflex_2"
                                    name="asessment[pemeriksaanFisik][reflex][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['reflex']['pilihan'] == 'Hyper' ? 'checked' : '' }} value="Hyper">
                                <label for="reflex_2" style="font-weight: normal; margin-right: 10px;">Hyper</label>
                                <input type="radio" id="reflex_3"
                                    name="asessment[pemeriksaanFisik][reflex][pilihan]" {{ @$dataAsesmenPonek['pemeriksaanFisik']['reflex']['pilihan'] == 'Hipo' ? 'checked' : '' }} value="Hipo">
                                <label for="reflex_3"
                                    style="font-weight: normal; margin-right: 10px;">Hipo</label><br />
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <h5><b>PEMERIKSAAN PENUNJANG</b></h5>
                        <tr>
                            <td style="text-align: center;">
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input"
                                        name="asessment[pemeriksaanPenunjang][laboratorium]" type="hidden"
                                        value="" id="flexCheckDefault">
                                    <input class="form-check-input"
                                        name="asessment[pemeriksaanPenunjang][laboratorium]" type="checkbox" {{ @$dataAsesmenPonek['pemeriksaanPenunjang']['laboratorium'] == 'Laboratorium' ? 'checked' : '' }}
                                        value="Laboratorium" id="flexCheckDefault">
                                    Laboratorium
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ekg]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ekg]" {{ @$dataAsesmenPonek['pemeriksaanPenunjang']['ekg'] == 'EKG' ? 'checked' : '' }}
                                        type="checkbox" value="EKG" id="flexCheckDefault">
                                    EKG
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input"
                                        name="asessment[pemeriksaanPenunjang][radiologi]" type="hidden"
                                        value="" id="flexCheckDefault">
                                    <input class="form-check-input"
                                        name="asessment[pemeriksaanPenunjang][radiologi]" type="checkbox" {{ @$dataAsesmenPonek['pemeriksaanPenunjang']['radiologi'] == 'Radiologi' ? 'checked' : '' }}
                                        value="Radiologi" id="flexCheckDefault">
                                    Radiologi
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ctg]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ctg]" {{ @$dataAsesmenPonek['pemeriksaanPenunjang']['ctg'] == 'CTG/NST' ? 'checked' : '' }}
                                        type="checkbox" value="CTG/NST" id="flexCheckDefault">
                                    CTG/NST
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][usg]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][usg]" {{ @$dataAsesmenPonek['pemeriksaanPenunjang']['usg'] == 'USG' ? 'checked' : '' }}
                                        type="checkbox" value="USG" id="flexCheckDefault">
                                    USG
                                </label>
                                <input type="text" name="asessment[pemeriksaanPenunjang][lainnya]" value="{{ @$dataAsesmenPonek['pemeriksaanPenunjang']['lainnya'] }}"
                                    class="form-control" style="display: inline-block;" id=""
                                    placeholder="Lainnya">
                            </td>
                        </tr>
                    </table>

                    <h5><b>V. RENCANA PEMULANGAN PASIEN (Discarge Planning)</b></h5>
                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                        {{-- <tr>
                            <td style="" colspan="2">
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][homeCare]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][homeCare]"
                                        type="checkbox" value="Perlu Pelayanan Home Care" id="flexCheckDefault">
                                    Perlu Pelayanan Home Care
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][katheter]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][katheter]"
                                        type="checkbox" value="Perlu Pemasangan Katheter" id="flexCheckDefault">
                                    Perlu Pemasangan Katheter
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][alatBantu]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][alatBantu]"
                                        type="checkbox" value="Penggunaan Alat Bantu" id="flexCheckDefault">
                                    Penggunaan Alat Bantu
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][ngt]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][ngt]"
                                        type="checkbox" value="Perlu Pemasangan NGT" id="flexCheckDefault">
                                    Perlu Pemasangan NGT
                                </label>
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][timTerapis]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][timTerapis]"
                                        type="checkbox" value="Dirujuk ke Tim Terapis" id="flexCheckDefault">
                                    Dirujuk ke Tim Terapis
                                </label><br />
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="margin-right: 10px; font-weight: 400;">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][lainnya]"
                                        type="hidden" value="" id="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[rencanaPemulangan][lainnya]"
                                        type="checkbox" value="Dirujuk ke Yang Lainnya" id="flexCheckDefault">
                                    Dirujuk ke Yang Lainnya
                                </label><br />
                                <input type="text" name="asessment[rencanaPemulangan][sebutkan]"
                                    class="form-control" style="display: inline-block;" id=""
                                    placeholder="Sebutkan">
                            </td>
                        </tr> --}}
                        <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][kontrol][dipilih]" value="Kontrol ulang RS" {{@$dataAsesmenPonek['rencanaPemulangan']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['kontrol']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$dataAsesmenPonek['rencanaPemulangan']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][kontrolPRB][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['kontrolPRB']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][dirawat][dipilih]" value="Dirawat" {{@$dataAsesmenPonek['rencanaPemulangan']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][dirawat][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['dirawat']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][dirujuk][dipilih]" value="Dirujuk" {{@$dataAsesmenPonek['rencanaPemulangan']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['dirujuk']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][alihgigd][dipilih]" value="Alih IGD" {{@$dataAsesmenPonek['rencanaPemulangan']['alihgigd']['dipilih'] == 'Alih IGD' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Alih IGD</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][alihgigd][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['alihgigd']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][alihponek][dipilih]" value="Alih Ponek" {{@$dataAsesmenPonek['rencanaPemulangan']['alihponek']['dipilih'] == 'Alih Ponek' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Alih Ponek</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][alihponek][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['alihponek']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][aps][dipilih]" value="APS" {{@$dataAsesmenPonek['rencanaPemulangan']['aps']['dipilih'] == 'APS' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">APS</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][aps][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['aps']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$dataAsesmenPonek['rencanaPemulangan']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][Konsultasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['Konsultasi']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" class="discargePlanningCheckbox" name="asessment[rencanaPemulangan][observasi][dipilih]" value="Observasi" {{@$dataAsesmenPonek['rencanaPemulangan']['observasi']['dipilih'] == 'Observasi' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Observasi</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][observasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['observasi']['waktu']}}">
                            </td>
                          </tr>
                          <tr>
                            <td style="width:25%; font-weight:500;">
                              <input type="checkbox" name="asessment[rencanaPemulangan][meninggal][dipilih]" value="Meninggal" {{@$dataAsesmenPonek['rencanaPemulangan']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                              <label  style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                            </td>
                            <td>
                              <input type="text" name="asessment[rencanaPemulangan][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$dataAsesmenPonek['rencanaPemulangan']['meninggal']['waktu']}}">
                            </td>
                          </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Ketika Pulang Masih Memerlukan Perawatan Lanjutan
                                (Kontrol)</td>
                            <td>
                                <input type="radio" id="kontrol_1"
                                    name="asessment[rencanaPemulangan][kontrol][pilihan]" {{@$dataAsesmenPonek['rencanaPemulangan']['kontrol']['pilihan'] == 'Tidak' ? 'checked' : ''}} value="Tidak">
                                <label for="kontrol_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                                <input type="radio" id="kontrol_2"
                                    name="asessment[rencanaPemulangan][kontrol][pilihan]" {{@$dataAsesmenPonek['rencanaPemulangan']['kontrol']['pilihan'] == 'Ya' ? 'checked' : ''}} value="Ya">
                                <label for="kontrol_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                            </td>
                        </tr>
                    </table>

{{-- 
                    <h5><b>RENCANA KEBIDANAN DENGAN KASUS HIPEREMESIS GRAVIDARUM</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:25%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <input type="checkbox" id="diagnosa1" name="asessment[hipermesis][diagnosa1]"
                                    value="Emesis Gravidarum">
                                <label for="diagnosa1" style="font-weight: normal;">Emesis Gravidarum</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[hipermesis][diagnosa2]"
                                    value="Hiperemesis Gravidarum">
                                <label for="diagnosa2" style="font-weight: normal;">Hiperemesis
                                    Gravidarum</label><br>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:25%; font-weight:bold;">Tujuan</td>
                            <td>
                                <input type="checkbox" id="tujuan1" name="asessment[hipermesis][tujuan1]"
                                    value="Mendeteksi masalah secara komprehensif">
                                <label for="tujuan1" style="font-weight: normal;">Mendeteksi masalah secara
                                    komprehensif</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[hipermesis][tujuan2]"
                                    value="Mendeteksi kelainan pada ibu hamil">
                                <label for="tujuan2" style="font-weight: normal;">Mendeteksi kelainan pada ibu
                                    hamil</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[hipermesis][tujuan3]"
                                    value="Mendeteksi secara dini tanda tanda HEG">
                                <label for="tujuan2" style="font-weight: normal;">Mendeteksi secara dini tanda
                                    tanda HEG</label><br>
                            </td>
                        </tr>


                        <tr>
                            <td style="width:25%; font-weight:bold;">Intervensi</td>
                            <td>
                                <input type="checkbox" id="intervensi1" name="asessment[hipermesis][intervensi1]"
                                    value="Kaji keadaan umum dan tanda-tanda vital">
                                <label for="intervensi1" style="font-weight: normal;">Kaji keadaan umum dan
                                    tanda-tanda vital</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[hipermesis][intervensi2]"
                                    value="anjurkan ibu agar tetap tenang dan nyaman">
                                <label for="intervensi2" style="font-weight: normal;">anjurkan ibu agar tetap tenang
                                    dan nyaman</label><br>
                                <input type="checkbox" id="intervensi1" name="asessment[hipermesis][intervensi3]"
                                    value="cegah terjadinya syok">
                                <label for="intervensi1" style="font-weight: normal;"> cegah terjadinya
                                    syok</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[hipermesis][intervensi4]"
                                    value="pertahankan keseimbangan dan cairan elektrolit">
                                <label for="intervensi2" style="font-weight: normal;">pertahankan keseimbangan dan
                                    cairan elektrolit</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[hipermesis][intervensi5]"
                                    value="Persiapan pemeriksaan dan pengambilan sampel pap smear">
                                <label for="intervensi1" style="font-weight: normal;">Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[hipermesis][intervensi6]"
                                    value="stabilkan abc">
                                <label for="intervensi2" style="font-weight: normal;">stabilkan abc</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[hipermesis][intervensi7]"
                                    value="anjurkan ibu untuk memakai oksigen">
                                <label for="intervensi1" style="font-weight: normal;">anjurkan ibu untuk memakai
                                    oksigen</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[hipermesis][intervensi8]"
                                    value="pemeriksaan laboratorium">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan
                                    laboratorium</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[hipermesis][intervensi9]"
                                    value="pemeriksaan nst">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan nst</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[hipermesis][intervensi10]"
                                    value="perisapan transfusi">
                                <label for="intervensi2" style="font-weight: normal;">perisapan
                                    transfusi</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">Observasi</td>
                            <td>
                                <input type="checkbox" id="observasi1" name="asessment[hipermesis][observasi1]"
                                    value="Keadaan Umum">
                                <label for="observasi1" style="font-weight: normal;">Keadaan Umum</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[hipermesis][observasi2]"
                                    value="TTV">
                                <label for="observasi2" style="font-weight: normal;">TTV</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[hipermesis][observasi3]"
                                    value="INTAKE-OUTTAKE">
                                <label for="observasi2" style="font-weight: normal;">INTAKE-OUTTAKE</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[hipermesis][observasi4]"
                                    value="Tanda Tanda Syok">
                                <label for="observasi2" style="font-weight: normal;">Tanda Tanda Syok</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">kolaborasi</td>
                            <td>
                                <input type="checkbox" id="kolaborasi1" name="asessment[hipermesis][kolaborasi1]"
                                    value="Pemberian Terapi Oleh Dokter SpOG">
                                <label for="kolaborasi1" style="font-weight: normal;">Pemberian Terapi Oleh Dokter
                                    SpOG</label><br>
                            </td>
                        </tr>
                    </table>



                    <h5><b>RENCANA KEBIDANAN DENGAN KASUS PENDARAHAN</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:25%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <input type="checkbox" id="diagnosa1" name="asessment[pendarahan][diagnosa1]"
                                    value="Abortus Imminens">
                                <label for="diagnosa1" style="font-weight: normal;">Abortus Imminens</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa2]"
                                    value="Abortus Insipiens">
                                <label for="diagnosa2" style="font-weight: normal;">Abortus Insipiens</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa3]"
                                    value="Abortus Kompliit">
                                <label for="diagnosa2" style="font-weight: normal;">Abortus Kompliit</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa4]"
                                    value="Abortus Inkompliit">
                                <label for="diagnosa2" style="font-weight: normal;">Abortus Inkompliit</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa5]"
                                    value="Missed Abortus">
                                <label for="diagnosa2" style="font-weight: normal;">Missed Abortus</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa6]"
                                    value="Blight Ovum">
                                <label for="diagnosa2" style="font-weight: normal;">Blight Ovum</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa7]"
                                    value="Molahidatidosa">
                                <label for="diagnosa2" style="font-weight: normal;">Molahidatidosa</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa8]"
                                    value="Fetal Demise">
                                <label for="diagnosa2" style="font-weight: normal;">Fetal Demise</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa9]"
                                    value="K.E.T">
                                <label for="diagnosa2" style="font-weight: normal;">K.E.T</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[pendarahan][diagnosa10]"
                                    value="I.U.F.D">
                                <label for="diagnosa2" style="font-weight: normal;">I.U.F.D</label><br>

                            </td>
                        </tr>

                        <tr>
                            <td style="width:25%; font-weight:bold;">Tujuan</td>
                            <td>
                                <input type="checkbox" id="tujuan1" name="asessment[pendarahan][tujuan1]"
                                    value="Mendeteksi masalah secara komprehensif">
                                <label for="tujuan1" style="font-weight: normal;">Mendeteksi masalah secara
                                    komprehensif</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[pendarahan][tujuan2]"
                                    value="Mengenali secara dini tanda-tanda gejala pendarahan">
                                <label for="tujuan2" style="font-weight: normal;">Mengenali secara dini tanda-tanda
                                    gejala pendarahan</label><br>
                            </td>
                        </tr>


                        <tr>
                            <td style="width:25%; font-weight:bold;">Intervensi</td>
                            <td>
                                <input type="checkbox" id="intervensi1" name="asessment[pendarahan][intervensi1]"
                                    value="Kaji keadaan umum dan tanda-tanda vital">
                                <label for="intervensi1" style="font-weight: normal;">Kaji keadaan umum dan
                                    tanda-tanda vital</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[pendarahan][intervensi2]"
                                    value="anjurkan ibu agar tetap tenang dan nyaman">
                                <label for="intervensi2" style="font-weight: normal;">anjurkan ibu agar tetap tenang
                                    dan nyaman</label><br>
                                <input type="checkbox" id="intervensi1" name="asessment[pendarahan][intervensi3]"
                                    value="cegah terjadinya syok">
                                <label for="intervensi1" style="font-weight: normal;"> cegah terjadinya
                                    syok</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[pendarahan][intervensi4]"
                                    value="pertahankan keseimbangan dan cairan elektrolit">
                                <label for="intervensi2" style="font-weight: normal;">pertahankan keseimbangan dan
                                    cairan elektrolit</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[pendarahan][intervensi5]"
                                    value="Persiapan pemeriksaan dan pengambilan sampel pap smear">
                                <label for="intervensi1" style="font-weight: normal;">Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[pendarahan][intervensi6]"
                                    value="stabilkan abc">
                                <label for="intervensi2" style="font-weight: normal;">stabilkan abc</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[pendarahan][intervensi7]"
                                    value="anjurkan ibu untuk memakai oksigen">
                                <label for="intervensi1" style="font-weight: normal;">anjurkan ibu untuk memakai
                                    oksigen</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[pendarahan][intervensi8]"
                                    value="pemeriksaan laboratorium">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan
                                    laboratorium</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[pendarahan][intervensi9]"
                                    value="pemeriksaan nst">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan nst</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[pendarahan][intervensi10]"
                                    value="perisapan transfusi">
                                <label for="intervensi2" style="font-weight: normal;">perisapan
                                    transfusi</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">Observasi</td>
                            <td>
                                <input type="checkbox" id="observasi1" name="asessment[pendarahan][observasi1]"
                                    value="Keadaan Umum">
                                <label for="observasi1" style="font-weight: normal;">Keadaan Umum</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[pendarahan][observasi2]"
                                    value="TTV">
                                <label for="observasi2" style="font-weight: normal;">TTV</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[pendarahan][observasi3]"
                                    value="INTAKE-OUTTAKE">
                                <label for="observasi2" style="font-weight: normal;">INTAKE-OUTTAKE</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[pendarahan][observasi4]"
                                    value="Tanda Tanda Syok">
                                <label for="observasi2" style="font-weight: normal;">Tanda Tanda Syok</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">kolaborasi</td>
                            <td>
                                <input type="checkbox" id="kolaborasi1" name="asessment[pendarahan][kolaborasi1]"
                                    value="Pemberian Terapi Oleh Dokter SpOG">
                                <label for="kolaborasi1" style="font-weight: normal;">Pemberian Terapi Oleh Dokter
                                    SpOG</label><br>
                            </td>
                        </tr>
                    </table>

                    
                    <h5><b>RENCANA KEBIDANAN DENGAN KASUS HAEMORAGIK ANTEPARTUM</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:25%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <input type="checkbox" id="diagnosa1" name="asessment[haemoragik][diagnosa1]"
                                    value="Plasenta Previa">
                                <label for="diagnosa1" style="font-weight: normal;">Plasenta Previa</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[haemoragik][diagnosa2]"
                                    value="Soluiso Plasenta">
                                <label for="diagnosa2" style="font-weight: normal;">Soluiso Plasenta</label><br>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:25%; font-weight:bold;">Tujuan</td>
                            <td>
                                <input type="checkbox" id="tujuan1" name="asessment[haemoragik][tujuan1]"
                                    value="Mendeteksi masalah secara komprehensif">
                                <label for="tujuan1" style="font-weight: normal;">Mendeteksi masalah secara
                                    komprehensif</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[haemoragik][tujuan2]"
                                    value="Mengenali secara dini tanda-tanda infeksi dibagian reproduksi">
                                <label for="tujuan2" style="font-weight: normal;">Mengenali secara dini tanda-tanda
                                    infeksi dibagian reproduksi</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[haemoragik][tujuan3]"
                                    value="Mencegah Terjadinya Syok">
                                <label for="tujuan2" style="font-weight: normal;">Mencegah Terjadinya
                                    Syok</label><br>
                            </td>
                        </tr>


                        <tr>
                            <td style="width:25%; font-weight:bold;">Intervensi</td>
                            <td>
                                <input type="checkbox" id="intervensi1" name="asessment[haemoragik][intervensi1]"
                                    value="Kaji keadaan umum dan tanda-tanda vital">
                                <label for="intervensi1" style="font-weight: normal;">Kaji keadaan umum dan
                                    tanda-tanda vital</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[haemoragik][intervensi2]"
                                    value="anjurkan ibu agar tetap tenang dan nyaman">
                                <label for="intervensi2" style="font-weight: normal;">anjurkan ibu agar tetap tenang
                                    dan nyaman</label><br>
                                <input type="checkbox" id="intervensi1" name="asessment[haemoragik][intervensi3]"
                                    value="cegah terjadinya syok">
                                <label for="intervensi1" style="font-weight: normal;"> cegah terjadinya
                                    syok</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[haemoragik][intervensi4]"
                                    value="pertahankan keseimbangan dan cairan elektrolit">
                                <label for="intervensi2" style="font-weight: normal;">pertahankan keseimbangan dan
                                    cairan elektrolit</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[haemoragik][intervensi5]"
                                    value="Persiapan pemeriksaan dan pengambilan sampel pap smear">
                                <label for="intervensi1" style="font-weight: normal;">Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[haemoragik][intervensi6]"
                                    value="stabilkan abc">
                                <label for="intervensi2" style="font-weight: normal;">stabilkan abc</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[haemoragik][intervensi7]"
                                    value="anjurkan ibu untuk memakai oksigen">
                                <label for="intervensi1" style="font-weight: normal;">anjurkan ibu untuk memakai
                                    oksigen</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[haemoragik][intervensi8]"
                                    value="pemeriksaan laboratorium">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan
                                    laboratorium</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[haemoragik][intervensi9]"
                                    value="pemeriksaan nst">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan nst</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[haemoragik][intervensi10]"
                                    value="perisapan transfusi">
                                <label for="intervensi2" style="font-weight: normal;">perisapan
                                    transfusi</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">Observasi</td>
                            <td>
                                <input type="checkbox" id="observasi1" name="asessment[haemoragik][observasi1]"
                                    value="Keadaan Umum">
                                <label for="observasi1" style="font-weight: normal;">Keadaan Umum</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[haemoragik][observasi2]"
                                    value="TTV">
                                <label for="observasi2" style="font-weight: normal;">TTV</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[haemoragik][observasi3]"
                                    value="INTAKE-OUTTAKE">
                                <label for="observasi2" style="font-weight: normal;">INTAKE-OUTTAKE</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[haemoragik][observasi4]"
                                    value="Tanda Tanda Syok">
                                <label for="observasi2" style="font-weight: normal;">Tanda Tanda Syok</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">kolaborasi</td>
                            <td>
                                <input type="checkbox" id="kolaborasi1" name="asessment[haemoragik][kolaborasi1]"
                                    value="Pemberian Terapi Oleh Dokter SpOG">
                                <label for="kolaborasi1" style="font-weight: normal;">Pemberian Terapi Oleh Dokter
                                    SpOG</label><br>
                            </td>
                        </tr>
                    </table>



                    <h5><b>RENCANA KEBIDANAN DENGAN KASUS ANEMIA</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:25%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <input type="checkbox" id="diagnosa1" name="asessment[anemia][diagnosa1]"
                                    value="Kehamilan">
                                <label for="diagnosa1" style="font-weight: normal;">Kehamilan</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[anemia][diagnosa2]"
                                    value="Persalinan">
                                <label for="diagnosa2" style="font-weight: normal;">Persalinan</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[anemia][diagnosa3]"
                                    value="Ginekologi">
                                <label for="diagnosa2" style="font-weight: normal;">Ginekologi</label><br>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:25%; font-weight:bold;">Tujuan</td>
                            <td>
                                <input type="checkbox" id="tujuan1" name="asessment[anemia][tujuan1]"
                                    value="Mendeteksi masalah secara komprehensif">
                                <label for="tujuan1" style="font-weight: normal;">Mendeteksi masalah secara
                                    komprehensif</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[anemia][tujuan2]"
                                    value="Mengenali secara dini tanda dan gejala anemia">
                                <label for="tujuan2" style="font-weight: normal;">Mengenali secara dini tanda dan
                                    gejala anemia</label><br>
                            </td>
                        </tr>


                        <tr>
                            <td style="width:25%; font-weight:bold;">Intervensi</td>
                            <td>
                                <input type="checkbox" id="intervensi1" name="asessment[anemia][intervensi1]"
                                    value="Kaji keadaan umum dan tanda-tanda vital">
                                <label for="intervensi1" style="font-weight: normal;">Kaji keadaan umum dan
                                    tanda-tanda vital</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[anemia][intervensi2]"
                                    value="anjurkan ibu agar tetap tenang dan nyaman">
                                <label for="intervensi2" style="font-weight: normal;">anjurkan ibu agar tetap tenang
                                    dan nyaman</label><br>
                                <input type="checkbox" id="intervensi1" name="asessment[anemia][intervensi3]"
                                    value="cegah terjadinya syok">
                                <label for="intervensi1" style="font-weight: normal;"> cegah terjadinya
                                    syok</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[anemia][intervensi4]"
                                    value="pertahankan keseimbangan dan cairan elektrolit">
                                <label for="intervensi2" style="font-weight: normal;">pertahankan keseimbangan dan
                                    cairan elektrolit</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[anemia][intervensi5]"
                                    value="Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear">
                                <label for="intervensi1" style="font-weight: normal;">Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[anemia][intervensi6]"
                                    value="stabilkan abc">
                                <label for="intervensi2" style="font-weight: normal;">stabilkan abc</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[anemia][intervensi7]"
                                    value="anjurkan ibu untuk memakai oksigen">
                                <label for="intervensi1" style="font-weight: normal;">anjurkan ibu untuk memakai
                                    oksigen</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[anemia][intervensi8]"
                                    value="pemeriksaan laboratorium">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan
                                    laboratorium</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[anemia][intervensi9]"
                                    value="pemeriksaan nst">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan nst</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[anemia][intervensi10]"
                                    value="perisapan transfusi">
                                <label for="intervensi2" style="font-weight: normal;">perisapan
                                    transfusi</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">Observasi</td>
                            <td>
                                <input type="checkbox" id="observasi1" name="asessment[anemia][observasi1]"
                                    value="Keadaan Umum">
                                <label for="observasi1" style="font-weight: normal;">Keadaan Umum</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[anemia][observasi2]"
                                    value="TTV">
                                <label for="observasi2" style="font-weight: normal;">TTV</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[anemia][observasi3]"
                                    value="INTAKE-OUTTAKE">
                                <label for="observasi2" style="font-weight: normal;">INTAKE-OUTTAKE</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[anemia][observasi4]"
                                    value="Tanda Tanda Syok">
                                <label for="observasi2" style="font-weight: normal;">Tanda Tanda Syok</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">kolaborasi</td>
                            <td>
                                <input type="checkbox" id="kolaborasi1" name="asessment[anemia][kolaborasi1]"
                                    value="Pemberian Terapi Oleh Dokter SpOG">
                                <label for="kolaborasi1" style="font-weight: normal;">Pemberian Terapi Oleh Dokter
                                    SpOG</label><br>
                            </td>
                        </tr>
                    </table> --}}

                    {{-- <h5><b>RENCANA KEBIDANAN DENGAN KASUS GINEKOLOGI</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:25%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <input type="checkbox" id="diagnosa1" name="asessment[ginekologi1][diagnosa1]"
                                    value="AUB">
                                <label for="diagnosa1" style="font-weight: normal;">AUB</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[ginekologi1][diagnosa2]"
                                    value="DUB">
                                <label for="diagnosa2" style="font-weight: normal;">DUB</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[ginekologi1][diagnosa3]"
                                    value="Menometoraghia">
                                <label for="diagnosa2" style="font-weight: normal;">Menometoraghia</label><br>
                                <input type="checkbox" id="diagnosa2" name="asessment[ginekologi1][diagnosa4]"
                                    value="Hiperplasia Endometrium">
                                <label for="diagnosa2" style="font-weight: normal;">Hiperplasia
                                    Endometrium</label><br>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:25%; font-weight:bold;">Tujuan</td>
                            <td>
                                <input type="checkbox" id="tujuan1" name="asessment[ginekologi1][tujuan1]"
                                    value="Mendeteksi masalah secara komprehensif">
                                <label for="tujuan1" style="font-weight: normal;">Mendeteksi masalah secara
                                    komprehensif</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[ginekologi1][tujuan2]"
                                    value="Mengenali secara dini tanda dan gejala infeksi">
                                <label for="tujuan2" style="font-weight: normal;">Mengenali secara dini tanda dan
                                    gejala infeksi</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[ginekologi1][tujuan3]"
                                    value="Mengenali tanda tanda pendarahan">
                                <label for="tujuan2" style="font-weight: normal;">Mengenali tanda tanda
                                    pendarahan</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[ginekologi1][tujuan4]"
                                    value="Mengambil tindakan pada kegawatdaruratan">
                                <label for="tujuan2" style="font-weight: normal;">Mengambil tindakan pada
                                    kegawatdaruratan</label><br>
                            </td>
                        </tr>


                        <tr>
                            <td style="width:25%; font-weight:bold;">Intervensi</td>
                            <td>
                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi1][intervensi1]"
                                    value="Kaji keadaan umum dan tanda-tanda vital">
                                <label for="intervensi1" style="font-weight: normal;">Kaji keadaan umum dan
                                    tanda-tanda vital</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi1][intervensi2]"
                                    value="anjurkan ibu agar tetap tenang dan nyaman">
                                <label for="intervensi2" style="font-weight: normal;">anjurkan ibu agar tetap tenang
                                    dan nyaman</label><br>
                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi1][intervensi3]"
                                    value="cegah terjadinya syok">
                                <label for="intervensi1" style="font-weight: normal;"> cegah terjadinya
                                    syok</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi1][intervensi4]"
                                    value="pertahankan keseimbangan dan cairan elektrolit">
                                <label for="intervensi2" style="font-weight: normal;">pertahankan keseimbangan dan
                                    cairan elektrolit</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi1][intervensi5]"
                                    value="Persiapan pemeriksaan dan
                  pengambilan sampel pap smear">
                                <label for="intervensi1" style="font-weight: normal;">Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi1][intervensi6]"
                                    value="stabilkan abc">
                                <label for="intervensi2" style="font-weight: normal;">stabilkan abc</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi1][intervensi7]"
                                    value="anjurkan ibu untuk memakai oksigen">
                                <label for="intervensi1" style="font-weight: normal;">anjurkan ibu untuk memakai
                                    oksigen</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi1][intervensi8]"
                                    value="pemeriksaan laboratorium">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan
                                    laboratorium</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi1][intervensi9]"
                                    value="pemeriksaan nst">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan nst</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi1][intervensi10]"
                                    value="perisapan transfusi">
                                <label for="intervensi2" style="font-weight: normal;">perisapan
                                    transfusi</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">Observasi</td>
                            <td>
                                <input type="checkbox" id="observasi1" name="asessment[ginekologi1][observasi1]"
                                    value="Keadaan Umum">
                                <label for="observasi1" style="font-weight: normal;">Keadaan Umum</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[ginekologi1][observasi2]"
                                    value="TTV">
                                <label for="observasi2" style="font-weight: normal;">TTV</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[ginekologi1][observasi3]"
                                    value="INTAKE-OUTTAKE">
                                <label for="observasi2" style="font-weight: normal;">INTAKE-OUTTAKE</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[ginekologi1][observasi4]"
                                    value="Tanda Tanda Syok">
                                <label for="observasi2" style="font-weight: normal;">Tanda Tanda Syok</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">kolaborasi</td>
                            <td>
                                <input type="checkbox" id="kolaborasi1" name="asessment[ginekologi1][kolaborasi1]"
                                    value="Pemberian Terapi Oleh Dokter SpOG">
                                <label for="kolaborasi1" style="font-weight: normal;">Pemberian Terapi Oleh Dokter
                                    SpOG</label><br>
                            </td>
                        </tr>
                    </table>









                    <h5><b>RENCANA KEBIDANAN DENGAN KASUS GINEKOLOGI</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td style="width:25%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <input type="checkbox" id="diagnosa1" name="asessment[ginekologi2][diagnosa1]"
                                    value="Wound Dehiscense">
                                <label for="diagnosa1" style="font-weight: normal;">Wound Dehiscense</label><br>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:25%; font-weight:bold;">Tujuan</td>
                            <td>
                                <input type="checkbox" id="tujuan1" name="asessment[ginekologi2][tujuan1]"
                                    value="Mendeteksi masalah secara komprehensif">
                                <label for="tujuan1" style="font-weight: normal;">Mendeteksi masalah secara
                                    komprehensif</label><br>
                                <input type="checkbox" id="tujuan2" name="asessment[ginekologi2][tujuan2]"
                                    value="Mengenali secara dini tanda dan gejala infeksi">
                                <label for="tujuan2" style="font-weight: normal;">Mengenali secara dini tanda dan
                                    gejala infeksi</label><br>
                            </td>
                        </tr>


                        <tr>
                            <td style="width:25%; font-weight:bold;">Intervensi</td>
                            <td>
                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi2][intervensi1]"
                                    value="Kaji keadaan umum dan tanda-tanda vital">
                                <label for="intervensi1" style="font-weight: normal;">Kaji keadaan umum dan
                                    tanda-tanda vital</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi2][intervensi2]"
                                    value="anjurkan ibu agar tetap tenang dan nyaman">
                                <label for="intervensi2" style="font-weight: normal;">anjurkan ibu agar tetap tenang
                                    dan nyaman</label><br>
                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi2][intervensi3]"
                                    value="cegah terjadinya syok">
                                <label for="intervensi1" style="font-weight: normal;"> cegah terjadinya
                                    syok</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi2][intervensi4]"
                                    value="pertahankan keseimbangan dan cairan elektrolit">
                                <label for="intervensi2" style="font-weight: normal;">pertahankan keseimbangan dan
                                    cairan elektrolit</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi2][intervensi5]"
                                    value="Persiapan pemeriksaan dan
                  pengambilan sampel pap smear">
                                <label for="intervensi1" style="font-weight: normal;">Persiapan pemeriksaan dan
                                    pengambilan sampel pap smear</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi2][intervensi6]"
                                    value="stabilkan abc">
                                <label for="intervensi2" style="font-weight: normal;">stabilkan abc</label><br>

                                <input type="checkbox" id="intervensi1" name="asessment[ginekologi2][intervensi7]"
                                    value="anjurkan ibu untuk memakai oksigen">
                                <label for="intervensi1" style="font-weight: normal;">anjurkan ibu untuk memakai
                                    oksigen</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi2][intervensi8]"
                                    value="pemeriksaan laboratorium">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan
                                    laboratorium</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi2][intervensi9]"
                                    value="pemeriksaan nst">
                                <label for="intervensi2" style="font-weight: normal;">pemeriksaan nst</label><br>
                                <input type="checkbox" id="intervensi2" name="asessment[ginekologi2][intervensi10]"
                                    value="perisapan transfusi">
                                <label for="intervensi2" style="font-weight: normal;">perisapan
                                    transfusi</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">Observasi</td>
                            <td>
                                <input type="checkbox" id="observasi1" name="asessment[ginekologi2][oservasi1]"
                                    value="Keadaan Umum">
                                <label for="observasi1" style="font-weight: normal;">Keadaan Umum</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[ginekologi2][oservasi2]"
                                    value="TTV">
                                <label for="observasi2" style="font-weight: normal;">TTV</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[ginekologi2][oservasi3]"
                                    value="INTAKE-OUTTAKE">
                                <label for="observasi2" style="font-weight: normal;">INTAKE-OUTTAKE</label><br>
                                <input type="checkbox" id="observasi2" name="asessment[ginekologi2][oservasi4]"
                                    value="Tanda Tanda Syok">
                                <label for="observasi2" style="font-weight: normal;">Tanda Tanda Syok</label><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; font-weight:bold;">kolaborasi</td>
                            <td>
                                <input type="checkbox" id="kolaborasi1" name="asessment[ginekologi2][kolaborasi1]]"
                                    value="Pemberian Terapi Oleh Dokter SpOG">
                                <label for="kolaborasi1" style="font-weight: normal;">Pemberian Terapi Oleh Dokter
                                    SpOG</label><br>
                            </td>
                        </tr>
                    </table> --}}






                    <h5><b>DOKUMEN PEMBERIAN INFORMASI</b></h5>
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <tr>
                            <td rowspan="11" style="width:20%;"></td>
                            <td style="padding: 5px;">
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Pemasangan Infus</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][pemasangan_infus]" {{@$dataAsesmenPonek['dokumen']['pemasangan_infus'] == 'Pemasangan Infus' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Pemasangan Infus">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Pemasangan Dower</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][pemasangan_dower]" {{@$dataAsesmenPonek['dokumen']['pemasangan_dower'] == 'Pemasangan Dower' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Pemasangan Dower">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Tindakan Restrain</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][restrain]" {{@$dataAsesmenPonek['dokumen']['restrain'] == 'Tindakan Restrain' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Tindakan Restrain"> 
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Tes Untuk Antibiotik</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][tes_antibiotik]" {{@$dataAsesmenPonek['dokumen']['tes_antibiotik'] == 'Tes Untuk Antibiotik' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Tes Untuk Antibiotik">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Pemberian Suntikan Injeksi</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][pemberian_suntikan]" {{@$dataAsesmenPonek['dokumen']['pemberian_suntikan'] == 'Pemberian Suntikan Injeksi' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Pemberian Suntikan Injeksi">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Pemasangan NGT</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][pemasangan_ngt]" {{@$dataAsesmenPonek['dokumen']['pemasangan_ngt'] == 'Pemasangan NGT' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Pemasangan NGT">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Pemasangan OGT</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][pemasangan_ogt]" {{@$dataAsesmenPonek['dokumen']['pemasangan_ogt'] == 'Pemasangan OGT' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Pemasangan OGT">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                             <label class="form-check-label">Pemasangan Bidai</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][pemasangan_bidai]" {{@$dataAsesmenPonek['dokumen']['pemasangan_bidai'] == 'Pemasangan Bidai' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Pemasangan Bidai">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Suction Nasofaring</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][suction_nasofaring]" {{@$dataAsesmenPonek['dokumen']['suction_nasofaring'] == 'Suction Nasofaring' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Suction Nasofaring">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Penjahitan Luka Derajat Ringan</label>
                            <td>
                                <input type="checkbox" name="asessment[dokumen][penjahitan_luka_derajat_ringan]" {{@$dataAsesmenPonek['dokumen']['penjahitan_luka_derajat_ringan'] == 'Penjahitan Luka Derajat Ringan' ? 'checked' : ''}}
                                    style="display:inline-block" id="" value="Penjahitan Luka Derajat Ringan">
                            </td>
                        </tr>
                    </table>



                    <div style="text-align: right;">
                        <button class="btn btn-success">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>


<script>
    $('#hpht').change(function () {
        let hpht = new Date($(this).val());
        let siklus = $('#siklus_menstruasi').val();

        // Jika siklus menstruasi 28 gunakan rumus Naegele jika tidak rumus Parikh
        if (siklus == 28) {
            hpht.setDate(hpht.getDate() + 7);
            hpht.setMonth(hpht.getMonth() -3);
            hpht.setFullYear(hpht.getFullYear() + 1);
            let tahun = hpht.getFullYear();
            let bulan = ('0' + (hpht.getMonth() + 1)).slice(-2);
            let tanggal = ('0' + hpht.getDate()).slice(-2);

            let tanggalHasil = tahun + '-' + bulan + '-' + tanggal;

            $('#hpl').val(tanggalHasil);
            $('#rumus').text("Rumus Naegele");
        } else {
            hpht.setMonth(hpht.getMonth() + 9);
            let hariTambahan = siklus - 21;
            hpht.setDate(hpht.getDate() + hariTambahan);

            let tahun = hpht.getFullYear();
            let bulan = ('0' + (hpht.getMonth() + 1)).slice(-2);
            let tanggal = ('0' + hpht.getDate()).slice(-2);
    
            let tanggalHasil = tahun + '-' + bulan + '-' + tanggal;

            $('#hpl').val(tanggalHasil);
            $('#rumus').text("Rumus Parikh");
        }

    })
</script>