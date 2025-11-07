<li class="dropdown">
    <ul class="dropdown-menu" role="menu">
        @if (substr($reg->status_reg, 0, 1) == 'J')
            @if ($polis->bpjs == 'GIG')
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/nutrisi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Nutrisi</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fungsional/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Fungsional</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                </li>
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
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @elseif ($polis->bpjs == 'OBG')
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
            @elseif ($polis->bpjs == 'ANA')
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Keluhan
                        Utama</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat_umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/asesmenAnatomiAnak/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen
                        Anatomi Anak</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/penunjangTHT/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Penunjang</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/diagnosis_banding/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Diagnosis
                        Banding</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/diagnosis_kerja/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Diagnosis
                        Kerja</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/main/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Main</a>
                </li>
            @elseif ($polis->bpjs == 'THT')
                <li><a
                        href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Keluhan
                        Utama</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/riwayat_umum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Riwayat</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Fisik</a></li>
                <li><a
                        href="{{ url('emr-soap/anamnesis/generalisTHT/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Status
                        Generalis</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/penunjangTHT/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemeriksaan
                        Penunjang</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/diagnosis_banding/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Diagnosis
                        Banding</a></li>
                <li><a
                        href="{{ url('emr-soap/pemeriksaan/diagnosis_kerja/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Diagnosis
                        Kerja</a></li>
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
                        href="{{ url('emr/triase/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Triase</a>
                </li>
                {{-- <li><a href="{{url('emr/triase/'.$unit.'/'.$registrasi_id.')}}}">Triase</a></li> --}}
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
                <li class="{{ $route == 'medical_history' ? 'active' : '' }}"><a
                        href="{{ url('emr/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Triase</a>
                </li>
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
                <li class="{{ $route == 'medical_history' ? 'active' : '' }}"><a
                        href="{{ url('emr/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Triase</a>
                </li>
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
            <li class="{{ $route == 'medical_history' ? 'active' : '' }}"><a
                    href="{{ url('emr/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Triase</a>
            </li>
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
    </ul>
</li>
@if ($unit == 'igd' || $unit == 'inap')
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">EWS<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="{{ $route == 'ews-dewasa' ? 'active' : '' }}"><a href="{{ url('emr-ews-dewasa/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Dewasa</a>
            </li>
            <li class="{{ $route == 'ews-anak' ? 'active' : '' }}"><a href="{{ url('emr-ews-anak/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Anak</a>
            </li>
            <li class="{{ $route == 'ews-maternal' ? 'active' : '' }}"><a href="{{ url('emr-ews-maternal/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Maternal</a>
            </li>
            <li class="{{ $route == 'ews-neonatus' ? 'active' : '' }}"><a href="{{ url('emr-ews-neonatus/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Bayi</a>
            </li>
        </ul>
    </li>
@endif
<li class="dropdown">
    {{-- Asessment PER UNIT --}}
        @if ($unit == 'igd')
                <li>
                <a href="{{ url('emr-soap/pemeriksaan/asesmen-igd/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen IGD</a>
                </li>
                {{-- <li>
                <a href="{{ url('emr-soap/pemeriksaan/triage-igd/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li> --}}
        @elseif($unit == 'jalan')
                {{-- Asessment PER POLI --}}
                @if ($reg->poli_id == '15')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/obgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                {{-- <li ><a href="{{url('emr-soap/pemeriksaan/awal-obgyn/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Asesmen Awal Medis Obgyn</a></li> --}}
                @elseif (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4' || @$reg->poli_id == '47')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/gigi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                @elseif (@$reg->poli_id == '6')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/mata/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                @elseif (@$reg->poli_id == '27')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/hemodialisis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/akses_vaskular_hemodialis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Penggunaan Akses Vaskular</a>
                </li>
                @elseif (@$reg->poli_id == '41')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/paru/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                @elseif (@$reg->poli_id == '12')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                @elseif (@$reg->poli_id == '20')
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/rehab-medik/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a>
                </li>
                @elseif (@$reg->poli_id == '13' || @$reg->poli_id == '29')
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a></li>

                                <li>
                                        <a href="{{ url('emr-soap/pemeriksaan/formulir-edukasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                            Formulir Edukasi Pasien & Keluarga
                                        </a>
                                </li>
                        </ul>
                </li>
                @elseif (@$reg->poli_id == 35)
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('emr-soap/pemeriksaan/awal-mcu/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a></li>

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
                                <li><a href="{{ url('emr-soap/pemeriksaan/awal-mcu/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a></li>
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
                @elseif (@$reg->poli_id == 42)
                        <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal<span
                                        class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/obgyn/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Obgyn</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/gigi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Gigi</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/mata/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Mata</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/hemodialisis/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Hemodialisis</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/paru/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Paru</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Gizi</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/rehab-medik/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rehab Medik</a>
                                        </li>
                                        <li>
                                                <a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Umum</a>
                                        </li>
                                </ul>
                        </li>
                @else
                <li><a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Asesmen Awal Medis</a></li>
                @endif
        @elseif ($unit == 'inap')
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal Medis<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li>
                                        <a href="{{ url('emr-soap/pemeriksaan/fisikCommon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                                Awal Medis
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_tht/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis THT
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_psikiatri/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Psikiatri
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_dalam/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Dalam
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_paru/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Paru
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_kulit/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Kulit & Kelamin
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_bedah/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Bedah
                                        </a>
                                </li>
                                <li class="">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_bedah_mulut/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Bedah Mulut
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neurologi/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Neurologi
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_mata/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Mata
                                        </a>
                                </li>
                                <li class="{{ $route == 'soap' ? 'active' : '' }}">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_gigi/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Gigi
                                        </a>
                                </li>
                                <li class="">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_rehab_medik/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Rehab Medik
                                        </a>
                                </li>
                                <li class="">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_onkologi/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Onkologi
                                        </a>
                                </li>
                                <li class="">
                                        <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_gizi/' . $unit . '/' . $registrasi_id) }}">Asesmen
                                                Awal Medis Gizi
                                        </a>
                                </li>
                        </ul>
                </li>
        @endif
    @if (@$reg->poli_id == '20')
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rehab Medik <span class="caret"></span>
            </a>
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
                <li>
                    <a
                        href="{{ url('emr-soap/pemeriksaan/rehabBaru/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rehab
                        Baru</a>
                </li>
            </ul>
        </li>
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
    </ul>
</li>
{{-- <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ICD <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a
                href="{{ url('emr-soap-icd/icd10/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Diagnosa
                (ICD 10)</a></li>
        <li><a
                href="{{ url('emr-soap-icd/icd9/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Tindakan
                (ICD 9 CM)</a></li>
        <li><a
                href="{{ url('emr-soap-igd/penyebabkematian/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Penyebab
                Kematian</a></li>
    </ul>
</li> --}}

<li class="{{ $route == 'soap' ? 'active' : '' }}"><a
        href="{{ url('emr/soap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">CPPT</a>
</li>

<li>
        <a href="{{ url('emr-soap/pemeriksaan/pemantauan-transfusi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemantauan Transfusi</a>
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
        <li class="{{ $route == 'labPatalogiAnatomi' ? 'active' : '' }}"><a
                href="{{ url('emr/labPatalogiAnatomi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">LAB
                P.A</a></li>
        <li class="{{ $route == 'eresep' ? 'active' : '' }}"><a
                href="{{ url('emr/eresep/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">E-Resep</a>
        </li>
        <li class=""><a
                href="{{ url('emr-soap/perencanaan/treadmill/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Treadmill</a>
        </li>
        <li class=""><a
                href="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Echocardiogra</a>
        </li>
        <li class=""><a 
                href="{{ url('emr-soap/perencanaan/konsultasi-gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Order Diet</a>
        </li>
    </ul>
</li>

{{-- <li class="{{$route == 'ris' ? 'active' :''}}"><a href="{{url('emr/ris/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">RIS</a></li> --}}


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
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perencanaan <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
            
        @if ($unit == 'jalan')
                <li class="{{ $route == 'emr-konsuldokter' ? 'active' : '' }}"><a
                        href="{{ url('emr-konsuldokter/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Konsul
                        Dokter</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/menolak-rujuk/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Menolak Rujuk
                </a></li>
                <li class="{{ $route == 'emr-surkon' ? 'active' : '' }}"><a
                        href="{{ url('emr-surkon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">SURKON</a>
                </li>
                {{-- <li><a href="{{url('emr-soap/perencanaan/terapi/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Terapi</a></li> --}}
                {{-- <li><a href="{{url('emr-soap/perencanaan/kontrol/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Kontrol</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/perencanaan/surat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Sakit</a></li>
                {{-- <li><a
                        href="{{ url('create-spri/'. $registrasi_id) }}">SPRI BPJS</a></li> --}}
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
                        href="{{ url('emr-soap/perencanaan/tindakan-rj/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Laporan
                        Tindakan Rawat Jalan</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/sertifikat-kematian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Sertifikat
                        Kematian</a></li>
                <li>
                        <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Informed 
                        Consent</a></li>
                @if ($reg->poli_id == "38" || $reg->poli_id == "47")
                <li>
                        <a href="{{ url('emr-soap/penilaian/prostodonti/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Form 
                        Prostodonti</a></li>
                @endif
        @endif

        @if ($unit == "inap")
                <li class="{{ $route == 'emr-konsuldokter' ? 'active' : '' }}"><a
                        href="{{ url('emr-konsuldokter/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Konsul
                        Dokter</a>
                </li>
                <li class="{{ $route == 'emr-surkon' ? 'active' : '' }}"><a
                        href="{{ url('emr-surkon/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">SURKON</a>
                </li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/menolak-rujuk/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Menolak Rujuk
                </a></li>
                {{-- <li><a href="{{url('emr-soap/perencanaan/terapi/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Terapi</a></li> --}}
                {{-- <li><a href="{{url('emr-soap/perencanaan/kontrol/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Kontrol</a></li> --}}
                <li><a
                        href="{{ url('emr-soap/perencanaan/surat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Sakit</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/rujukan/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Pengantar Rawat Inap</a></li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/inap/pernyataan-dnr/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pernyataan DNR</a>
                </li>
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
                <li>
                        <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Informed 
                        Consent</a></li>
        @endif

        @if ($unit == 'igd')
                <li><a
                        href="{{ url('emr-soap/perencanaan/surat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Sakit</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/rujukan/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                        Pengantar Rawat Inap</a></li>
                <li><a
                        href="{{ url('emr-soap/perencanaan/menolak-rujuk/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Menolak Rujuk
                </a></li>
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
                <li>
                        <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Informed 
                        Consent</a></li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar
                        Pemberian Terapi</a></li>
                {{-- <li><a
                        href="{{ url('emr/sbar/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">SBAR</a></li> --}}
                {{-- <li><a
                        href="{{ url('emr-soap/perencanaan/sbar/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">SBAR</a>
                </li> --}}
        @endif
    </ul>
</li>
@if ($unit == 'jalan')
        @if ($reg->poli_id == "9" || $reg->poli_id == "42")
                <li><a target="_blank" href="{{ url('emr-soap/pemeriksaan/pra-anestesi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pra Anestesi / Sedasi</a></li>
        @endif
@endif
@if($unit == 'jalan' || $unit == 'inap')
<li>
        <a href="{{ url('emr-soap/perencanaan/catatanKhusus/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                Catatan Khusus
        </a>
</li>
@endif
@if ($unit == 'inap')
    <li><a href="{{ url('emr-anestesi-inap/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pra
            Anestesi</a>
    </li>
    <li class=""><a
        href="{{ url('emr/icu/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">ICU</a>
    </li>
@endif
@if ($unit == 'igd')
<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catatan Khusus<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
                <li>
                        <a href="{{ url('emr-soap/perencanaan/catatanKhusus/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                Catatan Khusus
                        </a>
                        <a href="{{ url('emr-konsuldokter/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">
                                Konsul DPJP
                        </a>
                </li>
        </ul>
</li>
<li><a href="{{ url('emr-soap/perencanaan/igd/resume/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Resume</a></li>
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
{{-- <li><a href="{{ url('emr/ris/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">RIS</a></li> --}}
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
<li><a href="{{ url('clinicalpathway') }}">Clinical Pathway</a></li>
@if ($unit == 'inap')
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kriteria Masuk & Keluar Intensif<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{url("emr/form-kriteria-masuk-icu/". $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp)}}">Masuk ICU</a>
                <a href="{{url("emr/form-kriteria-keluar-icu/". $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp)}}">Keluar ICU</a>
            </li>
        </ul>
    </li>
@endif
{{-- <li class="{{$route == 'emr-resume' ? 'active' :''}}"><a
        href="{{url('emr/resume/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Resume</a>
    </li> --}}

{{-- <li class="{{$route == 'diet' ? 'active' :''}}"><a href="{{url('emr-jasa-dokter/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Jasa Dokter</a></li> --}}
