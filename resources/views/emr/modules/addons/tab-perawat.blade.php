<li class="dropdown">
    {{-- Asessment PER UNIT --}}
    @if ($unit == 'igd')
        <li><a href="{{ url('emr-soap/pemeriksaan/asesmen-igd/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen IGD</a></li>
    @endif
    @if ($unit == 'jalan')
        @if ($reg->poli_id == '15')
            <li><a href="{{ url('emr-soap/pemeriksaan/obgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Kebidanan</a></li>
        @elseif (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4'|| @$reg->poli_id == '47')
            <li><a href="{{ url('emr-soap/pemeriksaan/gigi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>
        @elseif (@$reg->poli_id == '6')
            <li><a href="{{ url('emr-soap/pemeriksaan/mata/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>
        @elseif (@$reg->poli_id == '27')
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li>
                                        <a href="{{ url('emr-soap/pemeriksaan/hemodialisis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                                Asesmen Awal Keperawatan
                                        </a>
                                </li>
                                <li>
                                        <a href="{{ url('emr-soap/pemeriksaan/laporan-hemodialisis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                                Laporan Hemodialisis
                                        </a>
                                </li>
                        </ul>
                </li>
        @elseif (@$reg->poli_id == '13' || @$reg->poli_id == '29')
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>
                                <li><a href="{{ url('emr-soap/pemeriksaan/formulir-edukasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                            Formulir Edukasi Pasien & Keluarga</a>
                                </li>
                        </ul>
                </li>
        @elseif (@$reg->poli_id == '41')
            <li><a href="{{ url('emr-soap/pemeriksaan/paru/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>
        @elseif(@$reg->poli_id == '20')
                <li><a href="{{ url('emr-soap/pemeriksaan/rehab-medik/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                        @if (Auth::user()->id == 735 || Auth::user()->id == 780 || Auth::user()->id == 736)
                                Asesmen Fisioterapi
                        @else
                                Asesmen Awal Keperawatan
                        @endif
                </a></li>
        @elseif (@$reg->poli_id == '12')
            <li><a href="{{ url('emr-soap/pemeriksaan/gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>
        @elseif (@$reg->poli_id == 35)
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>

                                <li>
                                        <a href="{{ url('emr-soap/pemeriksaan/mcu/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan dan Pengujian Kesehatan</a>
                                </li>
                                {{-- <li>
                                        <a href="{{ url('emr-soap/pemeriksaan/mcu/hasil/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil Medical Check Up</a>
                                </li> --}}
                                <li>
                                        <a href="{{ url('emr-soap/perencanaan/kir-sehat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">KIR Sehat</a>
                                </li>
                        </ul>
                </li>
        @elseif (@$reg->poli_id == 48)
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>

                                <li>
                                        <a href="{{ url('emr-soap/perencanaan/permohonan-vaksinasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Permohonan Vaksinasi</a>
                                </li>
                                <li>
                                        <a href="{{ url('emr-soap/perencanaan/persetujuan-vaksinasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Persetujuan Tindakan Vaksinasi</a>
                                </li>
                                <li>
                                        <a href="{{ url('emr-soap/perencanaan/daftar-tilik-vaksinasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Tilik Vaksinasi Dewasa</a>
                                </li>
                        </ul>
                </li>
            
        @else
            <li><a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Keperawatan</a></li>
        @endif
    @endif

    @if (@$reg->poli_id == '29')
    <li>
        <a href="{{ url('emr-soap/pemeriksaan/inap/hand-over-pasien/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hand Over Pasien</a>
    </li>
    <li>
        <a href="{{ url('emr-soap/pemeriksaan/inap/catatan-intake-output/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Catatan Intake Output Cairan</a>
    </li>
    <li>
        <a href="{{ url('emr-soap/pemeriksaan/inap/lembar-kendali-regimen/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Lembar Kendali Regimen</a>
    </li>
    @endif
    {{-- @if (Auth::user()->id == 659 || Auth::user()->id == 779 || Auth::user()->id == 1)  --}}
    {{-- Jika User Admin atau Sri Hanifah --}}
        <li>
                <a href="{{ url('emr-soap/pemeriksaan/pemantauan-transfusi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemantauan Transfusi</a>
        </li>
    {{-- @endif --}}
    @if (@$reg->poli_id == '20')
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rehab Medik <span
                    class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a
                        href="{{ url('emr-soap/pemeriksaan/layananRehab/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Layanan
                        Kedokteran dan Rehabilitasi</a>
                </li>
                <li>
                    <a
                        href="{{ url('emr-soap/pemeriksaan/programTerapi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Program
                        Terapi</a>
                </li>
                <li>
                    <a
                        href="{{ url('emr-soap/pemeriksaan/ujiFungsi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil
                        Tindakan Uji Fungsi</a>
                </li>
            </ul>
        </li>
    @endif
    {{-- Poli Klinik Jantung --}}
    @if (@$reg->poli_id == '14')
        <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                href="{{ url('emr-soap/perencanaan/treadmill/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Treadmill</a>
        </li>
        <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                href="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Echocardiogram</a>
        </li>
    @endif
    <ul class="dropdown-menu" role="menu">
        @if (substr($reg->status_reg, 0, 1) == 'J')
            @if ($reg->poli_id == '3')
                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/nutrisi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Nutrisi</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fungsional/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Fungsional</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                </li>
                {{-- <li><a href="{{url('emr-soap/penilaian/diagnosis/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/keadaanmukosaoral/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Gigi
                        Dan Mulut</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Anamnesa</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisik/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Padiatric</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/rencana/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rencana
                        (Terapi, Konsul, Rujukan)</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/edukasipasienkeluarga/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi</a>
                </li>
                {{-- <li><a href="{{url('emr-soap/penilaian/diagnosis/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Diagnosis</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @elseif ($reg->poli_id == '15')
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Keluhan
                        Utama</a></li>
                {{-- <li><a href="{{url('emr-soap/anamnesis/riwayat/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/penilaian/nyeri/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Skala
                        Nyeri</a></li>
                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/edukasiobgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                        Pasien & Keluarga</a></li>

                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikobgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/obgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Obsteri
                        Dan Gynecology</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikdalam/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Tambahan</a></li>
                {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Padiatric</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @else
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Keluhan
                        Utama</a></li>
                {{-- <li><a href="{{url('emr-soap/anamnesis/riwayat/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li>  --}}
                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/nutrisi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Nutrisi</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fungsional/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Fungsional</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikumum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Anamnesa</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Padiatric</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisik/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Penunjang</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/edukasipasienkeluarga/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/rencana/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rencana
                        (Terapi, Konsul, Rujukan)</a></li>
                <li><a
                        href="{{ url('emr-soap/penilaian/diagnosis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Diagnosis</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @endif
        @elseif (substr($reg->status_reg, 0, 1) == 'G')
            @if ($polis->bpjs == 'IGDO')
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Keluhan
                        Utama</a></li>
                {{-- <li><a href="{{url('emr-soap/anamnesis/riwayat/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/penilaian/nyeri/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Skala
                        Nyeri</a></li>
                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/edukasiobgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                        Pasien & Keluarga</a></li>

                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikobgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/obgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Obsteri
                        Dan Gynecology</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikdalam/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Tambahan</a></li>
                {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Padiatric</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @elseif ($polis->bpjs == 'IGDP')
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Keluhan
                        Utama</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat_umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                {{-- <li><a href="{{url('emr-soap/anamnesis/riwayat/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/penilaian/nyeri/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Skala
                        Nyeri</a></li>
                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/edukasiobgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                        Pasien & Keluarga</a></li>

                {{-- <li><a href="{{url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tanda Vital</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikobgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/obgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Obsteri
                        Dan Gynecology</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikdalam/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Tambahan</a></li>
                {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Padiatric</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @else
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/penilaian/nyeri/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Nyeri</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat_umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikumum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/statusfungsional/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Fungsional</a>
                <li><a
                        href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Padiatric</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/edukasipasienkeluarga/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                        Pasien & Keluarga</a></li>
                {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
                <li><a href="{{ url('emr-soap/anamnesis/primary/airway/' . $unit . '/' . $reg->id) }}}">Asesmen Gawat
                        Darurat</a></li>
                {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @endif
        @elseif (substr($reg->status_reg, 0, 1) == 'I')
                {{-- <li><a href="{{url('emr-soap/anamnesis/umum/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Umum</a></li>
            <li><a href="{{url('emr-soap/penilaian/nyeri/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Nyeri</a></li>
            <li><a href="{{url('emr-soap/pemeriksaan/fisikumum/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Pemeriksaan Fisik</a></li>
            <li><a href="{{url('emr-soap/pemeriksaan/penunjangInap/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Pemeriksaan Penunjang</a></li>
            <li><a href="{{url('emr-soap/anamnesis/statusfungsional/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Fungsional & Resiko Cidera</a>
            <li><a href="{{url('emr-soap/anamnesis/status/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Padiatric</a></li>
            <li><a href="{{url('emr-soap/anamnesis/edukasipasienkeluarga/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Edukasi Pasien & Keluarga</a></li>   
            <li><a href="{{url('emr-soap/anamnesis/main/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Main</a></li> --}}

            <li><a
                    href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
            </li>
            <li><a
                    href="{{ url('emr-soap/penilaian/nyeri/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Nyeri</a>
            </li>
            <li><a
                    href="{{ url('emr-soap/anamnesis/riwayat_umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
            </li>
            <li><a
                    href="{{ url('emr-soap/pemeriksaan/fisikumum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                    Fisik</a></li>
            <li><a
                    href="{{ url('emr-soap/anamnesis/statusfungsional/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                    Fungsional</a>
            <li><a
                    href="{{ url('emr-soap/anamnesis/status/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                    Padiatric</a></li>
            <li><a
                    href="{{ url('emr-soap/anamnesis/edukasipasienkeluarga/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                    Pasien & Keluarga</a></li>
            {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
            <li><a href="{{ url('emr-soap/anamnesis/primary/airway/' . $unit . '/' . $reg->id) }}}">Asesmen Gawat
                    Darurat</a></li>
            {{-- <li><a href="{{url('emr-soap/penilaian/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Status Lokalis</a></li> --}}
        @endif
        

        {{-- @if ($reg->poli_id == '3')            
        
            @endif

            @if ($reg->poli_id == '3')          
            <li><a href="{{url('pemeriksaan-fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Pemeriksaan Fisik</a></li>
            @else
            @endif
        
            <li><a href="{{url('emr-soap/anamnesis/main/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Main</a></li>
            <li><a href="{{url('emr-soap/anamnesis/riwayat/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li>
        
            @if ($reg->poli_id == '15')   
            <li><a href="{{url('emr-soap/anamnesis/obgyn/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Obsteri Dan Gynecology</a></li>
            @endif
        
        
            </li>
            <li><a href="{{url('emr-soap/anamnesis/kondisisosial/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Kondisi Sosial &
                    Psikologikal</a></li>
            <li><a href="{{url('emr-soap/anamnesis/permasalahangizi/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Permasalahan Gizi</a>
            </li>
            <li role="separator" class="divider"></li> --}}
        {{-- <li class="dropdown-header">Edukasi Pasien & Keluarga</li>
            <li><a href="{{url('emr-soap/anamnesis/edukasipasienkeluarga/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Edukasi Pasien &
                    Keluarga</a></li> --}}
        {{-- <li><a href="{{url('emr-soap/anamnesis/edukasipasienemergency/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Edukasi
                    Emergency</a></li>
            </li> --}}
    </ul>
</li>
{{-- <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pemeriksaan Umum<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('emr-soap/pemeriksaan/nutrisi/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Nutrisi</a></li>
        <li><a href="{{url('emr-soap/pemeriksaan/fungsional/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Fungsional</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{url('emr-soap/pemeriksaan/fisik/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Fisik</a></li>
    </ul>
</li> --}}
{{-- <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Penilaian <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
    
    <li><a href="{{url('emr-soap/anamnesis/primary/airway/'.$unit.'/'.$reg->id)}}}">Asesmen Gawat Darurat</a></li>
        
    </ul>
</li> --}}
{{-- <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perencanaan <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('emr-soap/perencanaan/terapi/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Terapi</a></li>
        <li><a href="{{url('emr-soap/perencanaan/kontrol/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Kontrol</a></li>
        <li><a href="{{url('emr-soap/perencanaan/surat/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Surat Sakit</a></li>
        <li><a href="{{url('emr-soap/perencanaan/rujukan/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Surat Rujukan Inap</a></li>
        <li><a href="{{url('emr-soap/perencanaan/kematian/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Surat Kematian</a></li>
        <li><a href="{{url('emr-soap/perencanaan/rujukanRS/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Surat Rujukan Rumah Sakit</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ICD <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('emr-soap-icd/icd10/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Diagnosa (ICD 10)</a></li>
        <li><a href="{{url('emr-soap-icd/icd9/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Tindakan (ICD 9 CM)</a></li>
    </ul>
</li> --}}

@if ($unit == 'igd' || $unit == 'inap')
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">EWS<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="{{ $route == 'ews-dewasa' ? 'active' : '' }}"><a
                    href="{{ url('emr-ews-dewasa/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Dewasa</a>
            </li>
            <li class="{{ $route == 'ews-anak' ? 'active' : '' }}"><a
                    href="{{ url('emr-ews-anak/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Anak</a>
            </li>
            <li class="{{ $route == 'ews-maternal' ? 'active' : '' }}"><a
                    href="{{ url('emr-ews-maternal/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Maternal</a>
            </li>
            <li class="{{ $route == 'ews-neonatus' ? 'active' : '' }}"><a
                    href="{{ url('emr-ews-neonatus/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Bayi</a>
            </li>

        </ul>
    </li>
@endif
@if ($unit == 'inap')
    <li class=""><a
        href="{{ url('emr/icu/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">ICU</a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengkajian Awal<span
                class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
                <li class="">
                        <a href="{{ url('emr-soap/pemeriksaan/asesmen-inap-perawat-dewasa/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                Dewasa
                        </a>
                </li>
                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_anak_perawat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Anak</a>
                </li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/maternitas/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Maternitas</a>
                </li>                
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/perinatologi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Perinatologi</a>
                </li>                
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rekonsiliasi Obat</a>
                </li>
        </ul>
    </li>

    <li><a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neonatus/' . $unit . '/' . $registrasi_id) }}">Asesmen
        Awal Medis Neonatus
    </a></li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Anak<span
                class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/inap/form-surveilans-infeksi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Formulir Surveilans Infeksi</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Pemberian Terapi</a>
                <a href="{{ url('emr-soap/pemeriksaan/resiko-jatuh-anak-inap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Resiko Jatuh Anak - Humpty Dumpty</a>
            </li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dewasa<span
                class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/inap/form-surveilans-infeksi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Formulir Surveilans Infeksi</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Pemberian Terapi</a>
            </li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Maternitas<span
                class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/inap/form-surveilans-infeksi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Formulir Surveilans Infeksi</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/partograf/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Partograf</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Pemberian Terapi</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/catatan-persalinan/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Catatan Persalinan</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/laporan-persalinan/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Laporan Persalinan</a>
            </li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perinatologi Neonatus<span
                class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Pemberian Terapi</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/lembar-rawat-gabung/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Lembar Rawat Gabung Bayi dengan Ibu</a>
                <a href="{{ url('emr-soap/perencanaan/pernyataan-persetujuan-rawat-nicu/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pernyataan Persetujuan Dirawat Diruang NICU</a>
                <a href="{{ url('emr-soap/perencanaan/surat-paps/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pernyataan Pulang APS</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-kontrol-istimewa/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Kontrol Istimewa</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/dokumen-pemberian-informasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Dokumen Pemberian Informasi</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/pernyataan-dnr/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pernyataan DNR</a>
                <a href="{{ url('emr-soap/pemeriksaan/inap/catatan-harian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Catatan Harian</a>
            </li>
        </ul>
    </li>

    
    <li>
        <a href="{{ url('emr-soap/pemeriksaan/usia_kehamilan/' . $unit . '/' . $registrasi_id) }}">
                Usia Kehamilan
        </a>
    </li>

    {{-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ulang<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a
                    href="{{ url('emr-soap/pemeriksaan/nyeri-inap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen
                    Nyeri</a>
                <a
                    href="{{ url('emr-soap/pemeriksaan/resiko-jatuh-dewasa-inap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Resiko
                    Jatuh Dewasa</a>
                <a
                    href="{{ url('emr-soap/pemeriksaan/resiko-jatuh-anak-inap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Resiko
                    Jatuh Anak</a>
                <a
                    href="{{ url('emr-soap/pemeriksaan/resiko-jatuh-neonatus-inap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Resiko
                    Jatuh Neonatus</a>
        </ul>
    </li> --}}
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hemodialisis<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                        <a href="{{ url('emr-soap/pemeriksaan/hemodialisis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                Asesmen Awal
                        </a>
                        <a href="{{ url('emr-soap/pemeriksaan/laporan-hemodialisis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                Laporan Hemodialisis
                        </a>
                </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">E-Order<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="{{ $route == 'rad' ? 'active' : '' }}"><a
                    href="{{ url('emr/rad/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">RAD</a>
            </li>
            <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                    href="{{ url('emr/lab/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB</a>
            </li>
            <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                    href="{{ url('emr/labPatalogiAnatomi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB
                    P.A</a></li>
            <li><a
                    href="{{ url('emr-soap/perencanaan/treadmill/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Treadmill</a>
            </li>
            <li><a
                    href="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Echocardiogram</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/usg/". $unit . '/' . $registrasi_id)}}">Upload Hasil USG</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/ekg/". $unit . '/' . $registrasi_id)}}">Upload Hasil EKG</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/ctg/". $unit . '/' . $registrasi_id)}}">Upload Hasil CTG</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/lain/". $unit . '/' . $registrasi_id)}}">Upload Hasil Lainnya</a>
            </li>
            <li>
                    <a href="{{ url('emr-soap/perencanaan/konsultasi-gizi/' . $unit . '/' . $registrasi_id) }}">Order Diet</a>
            </li>
        </ul>
     </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Edukasi<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a
                    href="{{ url('emr-soap/pemeriksaan/edukasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Kemauan
                    dan Kemampuan Edukasi
                </a>
            </li>
            <li>
                <a
                    href="{{ url('emr-soap/pemeriksaan/formulir-edukasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                    Formulir Edukasi Pasien & Keluarga
                </a>
            </li>
            @if (satusehat())
                <li class="{{ $route == 'diet' ? 'active' : '' }}">
                    <a href="{{ url('emr/diet/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                        diet</a>
                </li>
            @endif
        </ul>
    </li>

    <li class=""><a
        href="{{ url('emr-soap/pemeriksaan/pengantar/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pengantar</a>
    </li>

    <li>
        <a href="{{ url('emr-soap/pemeriksaan/tindakan_keperawatan/' . $unit . '/' . $registrasi_id ) }}">Tindakan Keperawatan / Kebidanan</a>
    </li>
@endif

<li class="{{ $route == 'soap' ? 'active' : '' }}"><a
        href="{{ url('emr/soap_perawat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">CPPT</a>
</li>
<li><a 
        href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Informed Consent</a>
</li>
@if ($unit == 'jalan')
<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">E-Order<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="{{ $route == 'rad' ? 'active' : '' }}"><a
                    href="{{ url('emr/rad/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">RAD</a>
            </li>
            <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                    href="{{ url('emr/lab/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB</a>
            </li>
            <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                    href="{{ url('emr/labPatalogiAnatomi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB
                    P.A</a></li>
            <li><a
                    href="{{ url('emr-soap/perencanaan/treadmill/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Treadmill</a>
            </li>
            <li><a
                    href="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Echocardiogram</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/usg/". $unit . '/' . $registrasi_id)}}">Upload Hasil USG</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/ekg/". $unit . '/' . $registrasi_id)}}">Upload Hasil EKG</a>
            </li>
            <li>
                    <a href="{{url("/emr/upload-hasil/ctg/". $unit . '/' . $registrasi_id)}}">Upload Hasil CTG</a>
            </li>
            <li>
                <a href="{{url("/emr/upload-hasil/lain/". $unit . '/' . $registrasi_id)}}">Upload Hasil Lainnya</a>
            </li>
        </ul>
     </li>
@endif
{{-- <li class="{{$route == 'rad' ? 'active' :''}}"><a href="{{url('emr/rad/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">RAD</a></li>
<li class="{{$route == 'lab' ? 'active' :''}}"><a href="{{url('emr/lab/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">LAB</a></li> --}}
{{-- <li class="{{$route == 'order_poli' ? 'active' :''}}"><a
        href="{{url('emr/poli/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Rujukan Internal</a></li> --}}
{{-- <li class="{{$route == 'eresep' ? 'active' :''}}"><a
        href="{{url('emr/eresep/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">E-Resep</a></li> --}}
{{-- <li class="{{$route == 'eresep-racikan' ? 'active' :''}}"><a
            href="{{url('emr/eresep-racikan/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">E-Resep Racik</a></li> --}}
{{-- <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hasil <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li class="{{$route == 'pemeriksaan-lab' ? 'active' :''}}"><a
            href="{{url('emr/pemeriksaan-lab/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Hasil LAB</a></li>
    <li class="{{$route == 'pemeriksaan-rad' ? 'active' :''}}"><a
            href="{{url('emr/pemeriksaan-rad/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Hasil Ekspertise</a></li>
    <li class="{{$route == 'emr-resume' ? 'active' :''}}"><a
                href="{{url('emr/resume/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Resume</a></li>
    </ul>
</li>
<li class="{{$route == 'emr-resume' ? 'active' :''}}">
    <a href="{{url('emr/resume/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Resume</a>
</li>

<li class="{{$route == 'emr-konsuldokter' ? 'active' :''}}"><a
    href="{{url('emr-konsuldokter/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Konsul Dokter Spesialis</a></li> --}}
{{-- <li class="{{$route == 'emr-resume' ? 'active' :''}}"><a
        href="{{url('emr/resume/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Resume</a></li> --}}
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hasil <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li class="{{ $route == 'pemeriksaan-lab' ? 'active' : '' }}"><a
                href="{{ url('emr/pemeriksaan-lab/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil
                LAB</a></li>
        <li class="{{ $route == 'pemeriksaan-lab-pa' ? 'active' : '' }}"><a
                href="{{ url('emr/pemeriksaan-lab-pa/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil
                LAB PA</a></li>
        <li class="{{ $route == 'pemeriksaan-rad' ? 'active' : '' }}"><a
                href="{{ url('emr/pemeriksaan-rad/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil
                Radiologi</a></li>
        <li class="{{ $route == 'pemeriksaan-penunjang' ? 'active' : '' }}"><a
                href="{{ url('emr/pemeriksaan-penunjang/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil
                Penunjang</a></li>
        <li class="{{ $route == 'pemeriksaan-laporan-operasi' ? 'active' : '' }}"><a
                href="{{ url('emr/pemeriksaan-laporan-operasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil
                Laporan Operasi</a></li>
        <li class="{{ $route == 'emr-resume' ? 'active' : '' }}"><a
                href="{{ url('emr/resume/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Histori</a>
        </li>
        @if ($unit == 'inap')
                
        <li class="{{ $route == 'emr-konsuldokter' ? 'active' : '' }}"><a
                href="{{ url('emr-konsuldokter/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hasil Konsul</a>
        </li>
        @endif
        {{-- <li class="{{ $route == 'emr-soap-icare' ? 'active' : '' }}"><a
                href="{{ url('emr-soap-icare/fkrtl/jalan/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">I-Care</a>
        </li> --}}
    </ul>
</li>
@if ($unit == 'igd')
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perencanaan <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                {{-- <li class="{{ $route == 'emr-konsuldokter' ? 'active' : '' }}"><a
                        href="{{ url('emr-konsuldokter/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Konsul
                        Dokter</a>
                </li>
                <li class="{{ $route == 'emr-surkon' ? 'active' : '' }}"><a
                        href="{{ url('emr-surkon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">SURKON</a>
                </li> --}}
                {{-- <li><a href="{{url('emr-soap/perencanaan/terapi/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Terapi</a></li> --}}
                {{-- <li><a href="{{url('emr-soap/perencanaan/kontrol/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Kontrol</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/perencanaan/menolak-rujuk/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Menolak Rujuk</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/surat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Sakit</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/rujukan/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Pengantar Rawat Inap</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/kematian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Kematian</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/rujukanRS/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Rujukan Rumah Sakit</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/visum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Visum</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/sertifikat-kematian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Sertifikat
                        Kematian</a></li>
                <li><a 
                        href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Informed 
                        Consent</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/inap/dokumen-pemberian-informasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Dokumen
                        Pemberian Informasi</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/surat-paps/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        APS</a></li>
                @if ($unit == 'igd')
                        {{-- <li><a
                                href="{{ url('emr/sbar/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">SBAR</a></li> --}}
                @endif
                </ul>
        </li>
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">E-Order<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="{{ $route == 'rad' ? 'active' : '' }}"><a
                        href="{{ url('emr/rad/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">RAD</a>
                    </li>
                    <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                        href="{{ url('emr/lab/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB</a>
                    </li>
                    <li class="{{ $route == 'lab' ? 'active' : '' }}"><a
                        href="{{ url('emr/labPatalogiAnatomi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB
                        P.A</a></li>
                    <li><a
                        href="{{ url('emr-soap/perencanaan/treadmill/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Treadmill</a>
                    </li>
                    <li><a
                        href="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Echocardiogram</a>
                    </li>
                </ul>
        </li>
        <li>
                <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Pemberian Terapi</a>
        </li>
@endif
@if (substr($reg->status_reg, 0, 1) == 'I')
@if ($reg->poli_id == 24 || $reg->poli_id == 15)
        <li class="">
                <a href="{{ url('emr-soap/pemeriksaan/asuhanBidan/' . $unit . '/' . $registrasi_id) }}">Asuhan Kebidanan</a>
        </li>
        <li>
                <a href="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/' . $unit . '/' . $registrasi_id) }}">Asuhan Keperawatan</a>
        </li>
@else
        <li>
                <a href="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/' . $unit . '/' . $registrasi_id) }}">Asuhan Keperawatan</a>
        </li>
@endif
    {{-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Askep<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="{{ $route == 'soap' ? 'active' : '' }}"><a
                    href="{{ url('emr-soap/pemeriksaan/asuhanBidan/' . $unit . '/' . $registrasi_id) }}">Asuhan
                    Kebidanan</a>
            </li>
            
        </ul>
    </li> --}}
@endif
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Upload Hasil<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
                <li>
                        <a href="{{url("/emr/upload-hasil/usg/". $unit . '/' . $registrasi_id)}}">USG</a>
                        <a href="{{url("/emr/upload-hasil/ekg/". $unit . '/' . $registrasi_id)}}">EKG</a>
                        <a href="{{url("/emr/upload-hasil/ctg/". $unit . '/' . $registrasi_id)}}">CTG</a>
                        <a href="{{url("/emr/upload-hasil/lain/". $unit . '/' . $registrasi_id)}}">LAINNYA</a>
                </li>
        </ul>
    </li>

{{-- <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Konsul <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
    <li class="{{$route == 'emr-jawabkonsul' ? 'active' :''}}"><a
            href="{{url('emr-jawabkonsul/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Jawab Konsul</a></li>
    </ul>
</li> --}}


@if (satusehat())
    @if ($unit != 'inap')
        <li class="{{ $route == 'diet' ? 'active' : '' }}"><a
                href="{{ url('emr/diet/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Edukasi
                diet</a></li>
    @endif
    {{-- <li class="{{$route == 'odontogram' ? 'active' :''}}"><a href="{{url('emr/odontogram/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Odontogram</a></li> --}}
@endif
<li><a href="{{ url('emr-soap/pemeriksaan/inap/form-surveilans-infeksi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Formulir Surveilans Infeksi</a></li>
@if ($unit == 'jalan')
        @if ($reg->poli_id == "15")
                <li><a href="{{ url('emr-soap/pemeriksaan/inap/laporan-persalinan/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Laporan Persalinan</a></li>
        @endif
@endif

@if ($unit != 'inap')
        <li><a href="{{ url('emr/sbar/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Transfer Internal</a></li>
@else
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transfer Internal<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                        <li>
                                <a href="{{url("/emr/sbar/". $unit . '/' . $registrasi_id)}}?sbar_tipe=masuk-ruangan">Masuk Ruangan</a>
                                <a href="{{url("/emr/sbar/". $unit . '/' . $registrasi_id)}}?sbar_tipe=keluar-ruangan">Keluar Ruangan</a>
                        </li>
                </ul>
        </li>
@endif


@if ($unit == 'jalan')
        @if ($reg->poli_id == "9")
                <li><a target="_blank" href="{{ url('emr-soap/pemeriksaan/pra-anestesi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pra Anestesi / Sedasi</a></li>
        @endif
@endif

{{-- Histori E Resep --}}
@if ($unit != 'jalan')
        <li>
                <a href="{{ url('emr-soap/pemeriksaan/apgar_score/' . $unit . '/' . $registrasi_id) }}">
                        Apgar Score
                </a>
        </li>
        <li>
                <a href="#" id="historipenjualaneresep" data-bayar="{{@$reg->bayar ? $reg->bayar :''}}" data-registrasiID="{{ $reg->id }}">History E-Resep
                </a>
        </li>

        <div class="modal fade" id="showHistoriPenjualanEresep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="">History E-Resep</h4>
                        </div>
                        <div class="modal-body">
                        <div id="dataHistoriEresep"></div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                        </div>
                        </div>
                </div>
        </div>
@endif
<li><a href="{{ url('clinicalpathway') }}">Clinical Pathway</a></li>
{{-- <li class="{{$route == 'diet' ? 'active' :''}}"><a href="{{url('emr-jasa-dokter/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Jasa Dokter</a></li> --}}
{{-- <li class="{{$route == 'emr-laporan-operasi' ? 'active' :''}}"><a href="{{url('emr-laporan-operasi/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Lap. Operasi</a></li> --}}