# Panduan Singkat Integrasi SATUSEHAT

Panduan ini menjelaskan cara kerja integrasi SATUSEHAT di aplikasi SIMRS, lokasi konfigurasi, serta langkah penggunaan dasar untuk pemula.

## Gambaran Umum
- Integrasi SATUSEHAT menggunakan kredensial OAuth2 dan endpoint FHIR yang disetel di `config/app.php`. Semua permintaan (token, Encounter, Observation, dll.) memakai URL resmi Kemenkes.【F:config/app.php†L143-L192】
- Fitur SATUSEHAT dapat diaktifkan/dinonaktifkan lewat pengaturan `status_satusehat` pada tabel `configs`. Fungsi helper `satusehat()` memeriksa status ini sebelum modul lain mengirim data.【F:app/MyHelper.php†L2045-L2049】
- Setiap permintaan ke layanan SATUSEHAT dicatat dalam tabel `record_satusehat` dan direpresentasikan oleh model `RecordSatuSehat`. Relasi ke `Registrasi` memudahkan pelacakan encounter per pasien.【F:app/RecordSatuSehat.php†L8-L16】

## Mengaktifkan Integrasi
1. Buka menu **Konfigurasi** dan aktifkan opsi **Integrasi Satu Sehat**. Formulir menampilkan radio button Aktif/Nonaktif yang memodifikasi `status_satusehat` di tabel konfigurasi.【F:resources/views/modules/config/_form.blade.php†L295-L303】
2. Pastikan kredensial SATUSEHAT (`client_id`, `client_secret`, `organization_id`) beserta endpoint FHIR telah diisi sesuai lingkungan (DEV/PROD) pada `config/app.php`. Ganti nilai default dengan milik fasilitas Anda.【F:config/app.php†L143-L192】
3. Setelah status aktif, fungsi `satusehat()` akan mengembalikan data konfigurasi sehingga modul lain (pendaftaran, EMR, farmasi) dapat mengirim data ke SATUSEHAT secara otomatis.【F:app/MyHelper.php†L2045-L2049】

## Menu dan Rute Penting
- Sidebar menyediakan menu **KYC**, **Log**, dan **Dashboard** khusus SATUSEHAT untuk pengguna yang memiliki peran terkait.【F:resources/views/sidebar/satusehat.blade.php†L1-L4】
- Rute yang dilindungi middleware `web` dan `auth` mengarah ke berbagai fungsi pemantauan:
  - `/satusehat/create-kyc` dan `POST satusehat/kyc` untuk uji koneksi KYC.
  - `/satusehat/log-encounter` untuk melihat log permintaan ke SATUSEHAT.
  - `/satusehat/dashboard` untuk ringkasan registrasi dan status pengiriman Encounter/Observation/Condition/Procedure/Medication.
  - Endpoint tambahan untuk melihat JSON permintaan/respons serta log LIS/RIS.
  Semua rute didefinisikan di `routes/simrs/satusehat.php`. 【F:routes/simrs/satusehat.php†L1-L19】

## Memantau Pengiriman Data
- **Log Encounter**: `SatuSehatController::logEncounter` menampilkan daftar `record_satusehat` berdasarkan tanggal, status (successed/failed), dan jenis layanan (service_name). Gunakan untuk melacak permintaan yang terkirim ke SATUSEHAT per hari.【F:app/Http/Controllers/SatuSehatController.php†L30-L52】
- **Dashboard**: `SatuSehatController::dashboard` menghitung jumlah registrasi per tipe (Rawat Jalan/Rawat Inap/IGD) serta rekap keberhasilan Encounter, Condition, Observation, Procedure, Composition, dan Medication. Data diambil dari `record_satusehat` dan tabel `registrasi`. Halaman ini membantu melihat progres integrasi tanpa membuka log satu per satu.【F:app/Http/Controllers/SatuSehatController.php†L54-L114】
- **Model Log**: Setiap baris di `record_satusehat` menyimpan `service_name`, `status_reg`, `status`, dan payload JSON. Model `RecordSatuSehat` menyediakan relasi `registrasi()` untuk menelusuri pendaftaran terkait.【F:app/RecordSatuSehat.php†L8-L16】

## Alur Kerja Tingkat Tinggi
1. **Registrasi/Pengisian EMR**: Ketika status SATUSEHAT aktif, berbagai modul (mis. Frontoffice dan IGD) memanggil fungsi posting SATUSEHAT untuk Encounter, Condition, Observation, dan lain-lain. Permintaan yang terkirim dicatat di `record_satusehat` beserta statusnya.
2. **Pemantauan**: Admin membuka menu Log atau Dashboard untuk memastikan setiap permintaan sukses. Jika ada kegagalan, JSON permintaan/respons dapat dilihat lewat tombol detail pada halaman log.
3. **Penyesuaian Lokasi/Dokter**: Modul lain menyiapkan ID lokasi, organisasi, dan practitioner berdasarkan data poliklinik/dokter. Pastikan data NIK dan mapping ruang sudah benar sebelum mengirim Encounter agar SATUSEHAT menerima referensi yang valid.

## Tips untuk Pemula
- Mulailah dengan mengaktifkan **Integrasi Satu Sehat** dan memastikan kredensial di `config/app.php` sesuai. Tanpa ini, helper `satusehat()` akan mengembalikan `null` sehingga tidak ada permintaan yang dikirim.
- Buka **Dashboard** setelah beberapa pendaftaran untuk melihat apakah Encounter dan resource lain berhasil terkirim. Angka "failed" menunjukkan perlu penelusuran pada log atau validasi data.
- Gunakan **Log Encounter** untuk mengecek payload JSON saat debugging, terutama ketika SATUSEHAT menolak permintaan karena NIK atau referensi lokasi tidak valid.
- Dokumentasikan ID organisasi, lokasi, dan practitioner yang sudah disetujui SATUSEHAT agar tim pendaftaran dan IT memiliki referensi yang sama ketika terjadi perubahan data.
