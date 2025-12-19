<li class="header text-yellow"><strong>RADIOLOGI GIGI</strong></li>
<li><a href="{{ url('radiologi-gigi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}" width="24">
        <span> Ter-billing</span></a></li>
<li><a href="{{ url('radiologi-gigi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}"
            width="24"> <span> Radiografer</span></a></li>
<li><a href="{{ url('radiologi-gigi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
            width="24"> <span> Hasil Radiologi Gigi</span></a></li>
<li><a href="{{ url('radiologi-gigi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
            width="24"></i> <span>Cari Pasien Terbiling</span></a></li>
<li><a href="{{ url('radiologi-gigi/cari-pasien-perawat') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
            width="24"></i> <span>Cari Pasien</span></a></li>
<li><a href="{{ url('radiologi-gigi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24">
        <span> Laporan</span></a></li>
<li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
        <span>Informasi Pasien</span></a></li>

{{-- @php
    $pol = (string) poliRadiologi() . ',' . poliRadiologiGigi();
@endphp

@if (Auth::user()->poli_id == $pol)
    <li class="header text-yellow"><strong>RADIOLOGI</strong></li>
    <li><a href="{{ url('radiologi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}" width="24">
            <span>
                Ter-billing</span></a></li>
    <li><a href="{{ url('radiologi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24">
            <span>
                Radiografer</span></a></li>
    <li><a href="{{ url('radiologi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span>
                Hasil Radiologi</span></a></li>
    <li><a href="{{ url('radiologi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i>
            <span>Cari Pasien Terbiling</span></a></li>
    <li><a href="{{ url('radiologi/cari-pasien-perawat') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien</span></a></li>
    <li><a href="{{ url('radiologi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24">
            <span>
                Laporan</span></a></li>
    <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
            <span>Informasi Pasien</span></a></li>

    <li class="header text-yellow"><strong>RADIOLOGI GIGI</strong></li>
    <li><a href="{{ url('radiologi-gigi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24">
            <span> Ter-billing</span></a></li>
    <li><a href="{{ url('radiologi-gigi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}"
                width="24"> <span> Radiografer</span></a></li>
    <li><a href="{{ url('radiologi-gigi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Hasil Radiologi Gigi</span></a></li>
    <li><a href="{{ url('radiologi-gigi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien Terbiling</span></a></li>
    <li><a href="{{ url('radiologi-gigi/cari-pasien-perawat') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien</span></a></li>
    <li><a href="{{ url('radiologi-gigi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}"
                width="24">
            <span> Laporan</span></a></li>
    <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
            <span>Informasi Pasien</span></a></li>
@elseif (Auth::user()->poli_id == poliRadiologi())
    <li class="header text-yellow"><strong>RADIOLOGI</strong></li>
    <li><a href="{{ url('radiologi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}" width="24">
            <span> Ter-billing</span></a></li>
    <li><a href="{{ url('radiologi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}" width="24">
            <span> Radiografer</span></a></li>
    <li><a href="{{ url('radiologi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Hasil Radiologi</span></a></li>
    <li><a href="{{ url('radiologi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien Terbiling</span></a></li>
    <li><a href="{{ url('radiologi/cari-pasien-perawat') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien</span></a></li>
    <li><a href="{{ url('radiologi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24">
            <span> Laporan</span></a></li>
    <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
            <span>Informasi Pasien</span></a></li>
@elseif(Auth::user()->poli_id == poliRadiologiGigi())
    <li class="header text-yellow"><strong>RADIOLOGI GIGI</strong></li>
    <li><a href="{{ url('radiologi-gigi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Ter-billing</span></a></li>
    <li><a href="{{ url('radiologi-gigi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}"
                width="24"> <span> Radiografer</span></a></li>
    <li><a href="{{ url('radiologi-gigi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Hasil Radiologi Gigi</span></a></li>
    <li><a href="{{ url('radiologi-gigi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien Terbiling</span></a></li>
    <li><a href="{{ url('radiologi-gigi/cari-pasien-perawat') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien</span></a></li>
    <li><a href="{{ url('radiologi-gigi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}"
                width="24"> <span> Laporan</span></a></li>
    <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
            <span>Informasi Pasien</span></a></li>
@else
    <li class="header text-yellow"><strong>RADIOLOGI</strong></li>
    <li><a href="{{ url('radiologi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}" width="24">
            <span> Ter-billing</span></a></li>
    <li><a href="{{ url('radiologi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}"
                width="24">
            <span> Radiografer</span></a></li>
    <li><a href="{{ url('radiologi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Hasil Radiologi</span></a></li>
    <li><a href="{{ url('radiologi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien Terbiling</span></a></li>
    <li><a href="{{ url('radiologi/cari-pasien-perawat') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien</span></a></li>
    <li><a href="{{ url('radiologi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}" width="24">
            <span> Laporan</span></a></li>
    <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}" width="24">
            <span>Informasi Pasien</span></a></li>

    <li class="header text-yellow"><strong>RADIOLOGI GIGI</strong></li>
    <li><a href="{{ url('radiologi-gigi/terbilling') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Ter-billing</span></a></li>
    <li><a href="{{ url('radiologi-gigi/billing') }}"><img src="{{ asset('menu/sidebar/penatajasa.svg') }}"
                width="24"> <span> Radiografer</span></a></li>
    <li><a href="{{ url('radiologi-gigi/hasil-radiologi') }}"><img src="{{ asset('menu/sidebar/lab.svg') }}"
                width="24"> <span> Hasil Radiologi Gigi</span></a></li>
    <li><a href="{{ url('radiologi-gigi/cari-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24"></i> <span>Cari Pasien Terbiling</span></a></li>
    <li><a href="{{ url('radiologi-gigi/cari-pasien-perawat') }}"><img
                src="{{ asset('menu/sidebar/pasien.svg') }}" width="24"></i> <span>Cari Pasien</span></a></li>
    <li><a href="{{ url('radiologi-gigi/laporan') }}"><img src="{{ asset('menu/sidebar/laporan.svg') }}"
                width="24"> <span> Laporan</span></a></li>
    <li><a href="{{ url('pasien/info-pasien') }}"><img src="{{ asset('menu/sidebar/pasien.svg') }}"
                width="24">
            <span>Informasi Pasien</span></a></li>
@endif --}}
