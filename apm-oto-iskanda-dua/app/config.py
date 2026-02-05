"""Central configuration for database and BPJS automation."""

import json
import sys
from pathlib import Path
from typing import Dict

def _config_root() -> Path:
    """Lokasi penyimpanan konfigurasi yang bisa ditulis.

    Saat dijalankan sebagai executable (PyInstaller/py2exe) folder yang dipakai
    adalah direktori executable, bukan direktori bundle sementara yang tidak
    bisa ditulis. Ketika dikembangkan dari sumber, gunakan folder module.
    """

    if getattr(sys, "frozen", False):
        return Path(sys.executable).resolve().parent
    return Path(__file__).resolve().parent


CONFIG_FILE_PATH = _config_root() / "user_config.json"

DEFAULT_SETTINGS = {
    "BPJS_EXECUTABLE": r"C:\\Program Files (x86)\\BPJS Kesehatan\\Aplikasi Sidik Jari BPJS Kesehatan\\After.exe",
    "BPJS_WINDOW_TITLE": "Aplikasi Registrasi Sidik Jari",
    "BPJS_USERNAME": "1002r006th",
    "BPJS_PASSWORD": "#Bandung28",
    "LOGIN_DELAY_SECONDS": 0.8,
    "POST_LOGIN_DELAY_SECONDS": 0.6,
    "BPJS_STANDBY_SECONDS": 3.0,
    "FORM_FILL_DELAY_SECONDS": 2.5,
    "BPJS_LAUNCH_DELAY_SECONDS": 1.5,
    "BPJS_CLOSE_AFTER_FILL": False,
    "CHROME_EXECUTABLE": r"C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe",
    "CHECKIN_URL": "http://172.168.1.175:8070",
    "SEP_CHECK_URL": "http://172.168.1.175:8070/reservasi/cek",
    "SEP_CHECK_NEW_BASE_URL": "http://172.168.1.175:8070",
    "SEP_BASE_URL": "http://172.168.1.175:8070",
    "FRISTA_EXECUTABLE": r"C:\\Users\\ilman\\Documents\\Frista\\Frista.exe",
    "FRISTA_USERNAME": "1002r006th",
    "FRISTA_PASSWORD": "#Bandung28",
    "FRISTA_LOGIN_DELAY_SECONDS": 6.0,
    "FRISTA_STANDBY_SECONDS": 3.0,
    "API_BASE_URL": "http://172.168.1.175/api",
    "API_PRIMARY_BASE_URL": "http://172.168.1.175/api",
    "API_FALLBACK_BASE_URLS": "",
    "API_PATIENT_ENDPOINT": "/apm-oto/v1/patients/{identifier}",
    "API_REGISTRATION_ENDPOINT": "/apm-oto/v1/registrations/latest/{identifier}",
    "API_BOOKING_ENDPOINT": "/apm-oto/v1/bookings/latest/{identifier}",
    "API_TIMEOUT_SECONDS": 10,
    "BPJS_API_BASE_URL": "http://172.168.1.2:3001",
    "BPJS_ANTREAN_ADD_ENDPOINT": "/bpjs/antrean/add",
    "BPJS_ANTREAN_UPDATE_ENDPOINT": "/bpjs/antrean/updatewaktu",
    "ADMISSION_TICKET_TITLE": "Tiket Admisi",
    "ADMISSION_TICKET_MESSAGE": "Silakan pergi ke Loket Pendaftaran untuk melanjutkan pendaftaran.",
    "TICKET_BASE_URL": "http://172.168.1.175:8070",
    "TICKET_URL_TEMPLATE": "/reservasi/cetak-baru/{registration_id}/{no_rm}",
    "BPJS_VCLAIM_SEP_BASE_URL": "http://172.168.1.175:3002",
    "BPJS_VCLAIM_SEP_CREATE_FROM_SIMRS_ENDPOINT": "/bpjs/vclaim/sep/create-from-simrs/{identifier}",
}


def _load_user_settings() -> Dict[str, str | float]:
    settings = DEFAULT_SETTINGS.copy()
    if CONFIG_FILE_PATH.exists():
        try:
            loaded = json.loads(CONFIG_FILE_PATH.read_text(encoding="utf-8"))
        except json.JSONDecodeError:
            loaded = {}
        if isinstance(loaded, dict):
            settings.update({k: v for k, v in loaded.items() if k in DEFAULT_SETTINGS})
    return settings


def _persist_settings(settings: Dict[str, str | float]) -> None:
    CONFIG_FILE_PATH.parent.mkdir(parents=True, exist_ok=True)
    CONFIG_FILE_PATH.write_text(
        json.dumps(settings, indent=2),
        encoding="utf-8",
    )


def save_user_settings(settings: Dict[str, str | float]) -> None:
    """Persist updated settings and refresh globals for runtime use."""

    DEFAULT_SETTINGS.update(settings)
    _persist_settings(DEFAULT_SETTINGS)
    _apply_settings(DEFAULT_SETTINGS)


def _apply_settings(settings: Dict[str, str | float]) -> None:
    global BPJS_EXECUTABLE
    global BPJS_WINDOW_TITLE
    global BPJS_USERNAME
    global BPJS_PASSWORD
    global LOGIN_DELAY_SECONDS
    global POST_LOGIN_DELAY_SECONDS
    global BPJS_STANDBY_SECONDS
    global FORM_FILL_DELAY_SECONDS
    global BPJS_LAUNCH_DELAY_SECONDS
    global BPJS_CLOSE_AFTER_FILL
    global CHROME_EXECUTABLE
    global CHECKIN_URL
    global SEP_CHECK_URL
    global SEP_CHECK_NEW_BASE_URL
    global SEP_BASE_URL
    global FRISTA_EXECUTABLE
    global FRISTA_USERNAME
    global FRISTA_PASSWORD
    global FRISTA_LOGIN_DELAY_SECONDS
    global FRISTA_STANDBY_SECONDS
    global API_BASE_URL
    global API_PRIMARY_BASE_URL
    global API_FALLBACK_BASE_URLS
    global API_PATIENT_ENDPOINT
    global API_REGISTRATION_ENDPOINT
    global API_BOOKING_ENDPOINT
    global API_TIMEOUT_SECONDS
    global BPJS_API_BASE_URL
    global BPJS_ANTREAN_ADD_ENDPOINT
    global BPJS_ANTREAN_UPDATE_ENDPOINT
    global ADMISSION_TICKET_TITLE
    global ADMISSION_TICKET_MESSAGE
    global TICKET_BASE_URL
    global TICKET_URL_TEMPLATE
    global BPJS_VCLAIM_SEP_BASE_URL
    global BPJS_VCLAIM_SEP_CREATE_FROM_SIMRS_ENDPOINT

    BPJS_EXECUTABLE = settings["BPJS_EXECUTABLE"]
    BPJS_WINDOW_TITLE = settings["BPJS_WINDOW_TITLE"]
    BPJS_USERNAME = settings["BPJS_USERNAME"]
    BPJS_PASSWORD = settings["BPJS_PASSWORD"]
    LOGIN_DELAY_SECONDS = float(settings["LOGIN_DELAY_SECONDS"])
    POST_LOGIN_DELAY_SECONDS = float(settings["POST_LOGIN_DELAY_SECONDS"])
    BPJS_STANDBY_SECONDS = float(settings["BPJS_STANDBY_SECONDS"])
    FORM_FILL_DELAY_SECONDS = float(settings["FORM_FILL_DELAY_SECONDS"])
    BPJS_LAUNCH_DELAY_SECONDS = float(settings["BPJS_LAUNCH_DELAY_SECONDS"])
    BPJS_CLOSE_AFTER_FILL = bool(settings["BPJS_CLOSE_AFTER_FILL"])
    CHROME_EXECUTABLE = settings["CHROME_EXECUTABLE"]
    CHECKIN_URL = settings["CHECKIN_URL"]
    SEP_CHECK_URL = settings["SEP_CHECK_URL"]
    SEP_CHECK_NEW_BASE_URL = settings["SEP_CHECK_NEW_BASE_URL"]
    SEP_BASE_URL = settings["SEP_BASE_URL"]
    FRISTA_EXECUTABLE = settings["FRISTA_EXECUTABLE"]
    FRISTA_USERNAME = settings["FRISTA_USERNAME"]
    FRISTA_PASSWORD = settings["FRISTA_PASSWORD"]
    FRISTA_LOGIN_DELAY_SECONDS = float(settings["FRISTA_LOGIN_DELAY_SECONDS"])
    FRISTA_STANDBY_SECONDS = float(settings["FRISTA_STANDBY_SECONDS"])
    API_BASE_URL = settings["API_BASE_URL"]
    API_PRIMARY_BASE_URL = settings.get("API_PRIMARY_BASE_URL", API_BASE_URL)
    API_FALLBACK_BASE_URLS = settings.get("API_FALLBACK_BASE_URLS", "")
    API_PATIENT_ENDPOINT = settings["API_PATIENT_ENDPOINT"]
    API_REGISTRATION_ENDPOINT = settings["API_REGISTRATION_ENDPOINT"]
    API_BOOKING_ENDPOINT = settings.get("API_BOOKING_ENDPOINT", "/apm-oto/v1/bookings/latest/{identifier}")
    API_TIMEOUT_SECONDS = float(settings["API_TIMEOUT_SECONDS"])
    BPJS_API_BASE_URL = settings.get("BPJS_API_BASE_URL", "")
    BPJS_ANTREAN_ADD_ENDPOINT = settings.get("BPJS_ANTREAN_ADD_ENDPOINT", "/bpjs/antrean/add")
    BPJS_ANTREAN_UPDATE_ENDPOINT = settings.get("BPJS_ANTREAN_UPDATE_ENDPOINT", "/bpjs/antrean/updatewaktu")
    ADMISSION_TICKET_TITLE = settings.get("ADMISSION_TICKET_TITLE", "Tiket Admisi")
    ADMISSION_TICKET_MESSAGE = settings.get(
        "ADMISSION_TICKET_MESSAGE",
        "Silakan pergi ke Admisi untuk melanjutkan pendaftaran.",
    )
    TICKET_BASE_URL = settings.get("TICKET_BASE_URL", settings["SEP_BASE_URL"])
    TICKET_URL_TEMPLATE = settings.get("TICKET_URL_TEMPLATE", "/reservasi/cetak-baru/{registration_id}/{no_rm}")
    BPJS_VCLAIM_SEP_BASE_URL = settings.get("BPJS_VCLAIM_SEP_BASE_URL", "http://172.168.1.175:3002")
    BPJS_VCLAIM_SEP_CREATE_FROM_SIMRS_ENDPOINT = settings.get(
        "BPJS_VCLAIM_SEP_CREATE_FROM_SIMRS_ENDPOINT", "/bpjs/vclaim/sep/create-from-simrs/{identifier}"
    )


_apply_settings(_load_user_settings())
