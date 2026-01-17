# apm-oto-iskanda-dua

Aplikasi desktop (Tkinter) untuk pencarian data pasien dan otomasi BPJS/Frista.

## Prasyarat
- **Python 3.10+**
- Windows (untuk otomasi aplikasi BPJS/Frista via `pyautogui`)
- Akses ke API yang sudah disediakan vendor

## Instalasi Dependensi
Disarankan menggunakan virtual environment.

```bash
python -m venv .venv
.\.venv\Scripts\activate
pip install requests pyautogui
```

> Catatan: `tkinter` sudah termasuk di Python (Windows).

## Konfigurasi
Aplikasi membaca konfigurasi dari `user_config.json` di folder yang sama dengan executable/script.
Jika file tidak ada, default dari `app/config.py` akan digunakan.

Contoh `user_config.json` minimal:

```json
{
  "API_BASE_URL": "http://172.168.1.175:8070/api",
  "API_PATIENT_ENDPOINT": "/apm-oto/v1/patients/{identifier}",
  "API_REGISTRATION_ENDPOINT": "/apm-oto/v1/registrations/latest/{identifier}",
  "API_REGISTRATION_LIST_ENDPOINT": "/apm-oto/v1/registrations/{identifier}",
  "API_TIMEOUT_SECONDS": 10,
  "CHROME_EXECUTABLE": "C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe",
  "CHECKIN_URL": "http://172.168.1.175:8070",
  "SEP_BASE_URL": "http://172.168.1.175:8070"
}
```

Field penting:
- `API_BASE_URL`: base URL API vendor.
- `API_PATIENT_ENDPOINT`: template endpoint pasien, wajib ada `{identifier}`.
- `API_REGISTRATION_ENDPOINT`: template endpoint registrasi terbaru, wajib ada `{identifier}`.
- `API_REGISTRATION_LIST_ENDPOINT`: template endpoint daftar registrasi pasien (opsional, dipakai untuk memilih tgl periksa hari ini).
- `API_TIMEOUT_SECONDS`: timeout request HTTP.

## Menjalankan Aplikasi
Dari folder `apm-oto-iskanda-dua`:

```bash
python main.py
```

## Catatan Integrasi API
Aplikasi mengharapkan respons JSON seperti berikut:

### Endpoint pasien
```
GET {API_BASE_URL}{API_PATIENT_ENDPOINT}
```

Contoh respons:
```json
{
  "status": "success",
  "data": {
    "id": 123,
    "no_rm": "00123456",
    "nik": "3201xxxxxxxxxxxx",
    "nomor_bpjs": "0001234567890",
    "no_jkn": "0001234567890"
  }
}
```

### Endpoint registrasi terbaru
```
GET {API_BASE_URL}{API_REGISTRATION_ENDPOINT}
```

Contoh respons:
```json
{
  "status": "success",
  "data": {
    "id": 987,
    "no_rm": "00123456",
    "nomorantrian": "12082023POLI001",
    "tanggal_periksa": "2023-08-12",
    "nik": "3201xxxxxxxxxxxx",
    "nomorkartu": "0001234567890"
  }
}
```

> Minimal field yang dipakai otomasi: `id`, `no_rm`, `nik`, `nomorkartu`/`nomor_bpjs`.
