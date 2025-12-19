@extends('layouts.landingpage')

@section('content')
<div class="container">
    <marquee attribute_name = "attribute_value"....more attributes>
        Selamat Datang di Pendaftaran Online {{config('app.nama_rs')}}.
     </marquee>
    <h4 class="" style="color:#5F8D4E">Ketentuan Umum Pendaftaran Online</h4>
    <div class="row">
        <div class="col-lg-9">
            <ol>
                <li>Pendaftaran Online bisa dilakukan oleh pasien lama maupun pasien baru (Umum dan BPJS).</li>
                <li>Pendaftaran Online dapat dilakukan H-7 dari rencana kedatangan</li>
                <li>Pendaftaran online dapat dilakukan setiap hari (7x24 jam) dengan jam verifikasi setiap hari sampai dengan jam 12.00 WIB</li>
                <li>Pasien di hari yang sama hanya dapat mendaftar 1 kali dengan 1 dokter</li>
                {{-- <li>Pasien yang telah mendaftar online akan mendapatkan pesan melalui Whatsapp berisi pemberitahuan jadwal reservasi</li> --}}
                <li> Apa bila terdapat perubahan jadwal dokter maka jadwal yang telah direservasi tersebut akan dilayani oleh dokter lain yang bertugas</li>
                <li> No Antrian Periksa dokter adalah sesuai dengan urutan ketika melakukan reservasi.</li>
                <li>Urutan pelayanan berdasarkan nomor antri yang didapatkan pada waktu melakukan pendaftaran online. </li>
                {{-- <li>Pasien yang melakukan pendaftaran onsite akan mendapatkan nomor antrian setelah pendaftaran online</li> --}}
                
            </ol>
        </div>
        <div class="col-lg-3 text-center">
            <img style="max-width: 185px;" src="{{config('app.logo')}}" alt=""><br/>
            {{-- <p><b>dr.Prima Wulandari</b><br/> --}}
            <span style="font-size:13px;">{{config('app.nama')}}</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <a href="{{url('jadwal/dokter')}}" class="btn btn-warning" style="background-color: #E5D9B6;border-color:#E5D9B6;color:#285430;">Lihat Jadwal Dokter</a>
                    <a href="{{url('reservasi/cek')}}" class="btn btn-primary" style="background-color: #285430;border-color:#285430">Cek Data Reservasi</a>
                    {{-- <button type="button" class="btn btn-primary">Cek Data Reservasi</button> --}}
                    <div class="checkbox mt-2 mb-2">
                        <label><input type="checkbox" id="idIsSetuju" onchange="document.getElementById('next').disabled = !this.checked;">&nbsp; Saya setuju dengan ketentuan di atas</label>
                    </div>
                    <button onclick="location.href = '/reservasi';" type="button" class="btn btn-success" id="next" disabled>Lanjutkan Proses Pendaftaran</button><br/>
                </div>
                </div>
        </div>
    </div>
</div> 
@endsection