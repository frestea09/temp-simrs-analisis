# Panduan build `apm-oto-iskanda-dua` menjadi `.exe`

APM Oto Iskanda Dua dijalankan di Windows dan membutuhkan bundel `.exe` yang mencakup aset Tkinter, modul otomatisasi, dan driver MySQL. Gunakan panduan berikut untuk menyiapkan lingkungan dan menghasilkan executable siap pakai.

## Prasyarat
- Windows dengan Python 3.11+ sudah terpasang.
- Akses internet untuk mengunduh dependensi.
- Hak eksekusi untuk menjalankan script `.bat`.

## Langkah cepat (disarankan)
1. Buka Command Prompt di root repo.
2. Jalankan:
   ```bat
   build_exe.bat
   ```
   Script ini akan:
   - Membuat virtualenv `.venv` (sekali saja).
   - Memasang dependensi dari `requirements.txt`.
   - Menjalankan PyInstaller dengan opsi:
     - `--onefile` dan `--windowed` agar output tunggal tanpa konsol.
     - `--add-data "assets;assets"` untuk memasukkan logo.
     - `--hidden-import` untuk plugin `mysql.connector` yang diperlukan.
     - `--icon assets\logo.ico` untuk ikon aplikasi.
   - Menyalin `app\user_config.json` ke folder `dist` untuk penyesuaian cepat.

Output akhir tersedia di `dist\apm-oto-iskanda-dua.exe`.

## Build manual (jika tidak menggunakan script)
1. Buat dan aktifkan virtualenv (opsional tapi dianjurkan):
   ```bat
   python -m venv .venv
   call .venv\Scripts\activate.bat
   ```
2. Pasang dependensi:
   ```bat
   pip install --upgrade pip
   pip install -r requirements.txt
   ```
3. Jalankan PyInstaller secara langsung:
   ```bat
   pyinstaller --noconfirm --clean --onefile --windowed ^
     --name apm-oto-iskanda-dua ^
     --icon assets\logo.ico ^
     --add-data "assets;assets" ^
     --hidden-import mysql.connector.locales.eng ^
     --hidden-import mysql.connector.plugins.caching_sha2_password ^
     main.py
   ```
4. (Opsional) Salin konfigurasi default agar mudah disunting:
   ```bat
   copy /Y app\user_config.json dist\user_config.json
   ```

## Catatan konfigurasi
- File konfigurasi runtime disimpan di direktori yang sama dengan `.exe` (`user_config.json`). Jika file belum ada, aplikasi memakai nilai default di `app/config.py`. Menyalin `user_config.json` ke `dist` memudahkan penyesuaian.
- Aset gambar dimuat otomatis saat runtime; tidak perlu penyesuaian path manual.
- Jika MySQL server menggunakan plugin autentikasi berbeda, sesuaikan `DB_AUTH_PLUGIN` melalui environment variable `APM_DB_AUTH_PLUGIN` sebelum build atau jalankan aplikasi sesuai pesan kesalahan yang muncul di UI.
