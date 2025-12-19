<li>
    <a href="{{ url('emr-soap/pemeriksaan/inap/form-surveilans-infeksi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Formulir Surveilans Infeksi</a>
</li>

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

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Asesmen Awal Medis<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        {{-- Pasien bayi usia 0 - 28 hari atau IGD Ponek --}}
        @if (@date_diff(@date_create(@$reg->pasien->tgllahir), @date_create(date('Y-m-d')))->days <= 28 && @$reg->poli_id == 24)
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neonatus/' . $unit . '/' . $registrasi_id) }}">Asesmen
                        Awal Medis Neonatus
                </a>
            </li>
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/ballard_score/' . $unit . '/' . $registrasi_id) }}">
                        New Ballard Score
                </a>
            </li>
        @else
            <li>
                <a href="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_obgyn/' . $unit . '/' . $registrasi_id) }}">Asesmen
                        Awal Medis Obgyn
                </a>
            </li>
        @endif
    </ul>
</li>

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

<li>
    <a href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Daftar Pemberian Terapi</a>
</li>

<li class="{{ $route == 'soap' ? 'active' : '' }}">
    <a href="{{ url('emr/soap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">CPPT</a>
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
        <li class="{{ $route == 'eresep' ? 'active' : '' }}"><a
                href="{{ url('emr/eresep/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">E-Resep</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/treadmill/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Treadmill</a>
        </li>
        <li><a
                href="{{ url('emr-soap/echocardiogram/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Echocardiogram</a>
        </li>
        {{-- <li>
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
        </li> --}}
        <li>    
                <a href="{{ url('emr-soap/perencanaan/konsultasi-gizi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Order Diet</a>
        </li>
    </ul>
</li>

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

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perencanaan <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a 
                href="{{ url('emr-soap/pemeriksaan/inap/partograf/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Partograf</a>
        </li>
        <li><a 
                href="{{ url('emr-soap/pemeriksaan/inap/catatan-persalinan/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Catatan Persalinan</a>
        </li>
        <li><a 
                href="{{ url('emr-soap/pemeriksaan/inap/laporan-persalinan/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Laporan Persalinan</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/inap/lembar-observasi-obgyn/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Lembar Observasi Obgyn</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/inap/laporan-kuret/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Laporan Kuret</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/menolak-rujuk/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Menolak 
                Rujuk</a>
        </li>
        <li class="{{ $route == 'emr-konsuldokter' ? 'active' : '' }}"><a
                href="{{ url('emr-konsuldokter/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Konsul
                Dokter</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/inap/surat-dpjp/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat Pernyataan DPJP</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/inap/pulang-pasien/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Perencanaan Pulang Pasien</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/rujukanRS/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                Rujukan Rumah Sakit</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/kematian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
                Kematian</a>
        </li>
        <li><a
                href="{{ url('emr-soap/perencanaan/sertifikat-kematian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Sertifikat
                Kematian</a></li>
        <li>
                <a href="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Informed 
                Consent</a></li>
    </ul>
</li>

<li>
        <a href="{{ url('emr-soap/pemeriksaan/formulir-edukasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Formulir Edukasi Pasien dan Keluarga</a>
</li>

<li>
        <a href="{{ url('emr-soap/perencanaan/inap/resume/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Resume</a>
</li>

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

<li class=""><a
        href="{{ url('emr-soap/pemeriksaan/pengantar/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pengantar</a>
</li>
 <li>
<a href="{{ url('emr-soap/pemeriksaan/usia_kehamilan/' . $unit . '/' . $registrasi_id) }}">
        Usia Kehamilan
</a>
</li>
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
    <li><a
        href="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rekonsiliasi Obat</a>
    </li>
@endif
<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan Operasi<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi-ods/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Laporan Operasi Mata</a>
                </li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Laporan Operasi ODS</a>
                </li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi-ranap/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Laporan Operasi Rawat Inap</a>
                </li>
                <li>
                        <a href="{{ url('emr-soap/pemeriksaan/upload-laporan-operasi/'. $unit .'/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id) }}">Upload Laporan Operasi</a>
                </li>
        </ul>
</li>
{{-- <li><a href="{{ url('emr/ris/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">RIS</a></li> --}}