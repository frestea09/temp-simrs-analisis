"""Action helpers to keep the Tkinter UI lean and readable."""

from datetime import date
import subprocess
import threading
import tkinter as tk
from tkinter import messagebox

import pyautogui

from app import bpjs, config, database


CONTROL_HINT_KEYS = {
    "is_kontrol",
    "kontrol",
    "jenis_kunjungan",
    "jenis_pasien",
    "kategori_kunjungan",
    "tipe_kunjungan",
    "jenis_registrasi",
    "tipe_registrasi",
}


def _is_control_registration(registration: dict) -> bool | None:
    if not registration:
        return None
    for key, value in registration.items():
        normalized_key = str(key).lower()
        if normalized_key not in CONTROL_HINT_KEYS:
            continue
        if isinstance(value, bool):
            return value
        if value is None:
            continue
        text_value = str(value).strip().lower()
        if not text_value:
            continue
        if text_value in {"1", "y", "yes", "true"}:
            return True
        if text_value in {"0", "n", "no", "false"}:
            return False
        if "kontrol" in text_value:
            return True
        return False
    return None


def _focus_chrome_window() -> bool:
    for title in ("Google Chrome", "Chrome"):
        try:
            windows = pyautogui.getWindowsWithTitle(title)
        except Exception:  # noqa: BLE001
            windows = []
        for window in windows:
            if not window:
                continue
            if getattr(window, "isMinimized", False):
                window.restore()
            window.activate()
            pyautogui.sleep(0.3)
            return True
    return False


def _open_chrome_url(url: str, half_screen_width: int, screen_height: int):
    if _focus_chrome_window():
        pyautogui.hotkey("ctrl", "l")
        pyautogui.write(url)
        pyautogui.press("enter")
        return

    window_position = f"--window-position={half_screen_width},0"
    window_size = f"--window-size={half_screen_width},{screen_height}"
    subprocess.Popen(
        [
            config.CHROME_EXECUTABLE,
            window_position,
            window_size,
            "--new-window",
            url,
        ]
    )


def launch_sep_flow(identifier: str, half_screen_width: int, screen_height: int):
    """
    Open Chrome directly to the SEP page for the latest booking tied to the identifier.
    Identifier may be No RM, NIK, or nomor BPJS.
    """

    registration = database.fetch_latest_registration(identifier)
    if not registration:
        messagebox.showwarning(
            "Reservasi Tidak Ditemukan",
            "Reservasi tidak ditemukan. Membuka halaman cek baru.",
        )
        fallback_url = f"{config.SEP_BASE_URL.rstrip('/')}/reservasi/cek-baru"
        _open_chrome_url(fallback_url, half_screen_width, screen_height)
        return

    registration_id = registration.get("id")
    no_rm = registration.get("no_rm")
    if not registration_id:
        messagebox.showwarning(
            "Reservasi Tidak Lengkap",
            "Data reservasi tidak lengkap. Membuka halaman cek baru.",
        )
        fallback_url = f"{config.SEP_BASE_URL.rstrip('/')}/reservasi/cek-baru"
        _open_chrome_url(fallback_url, half_screen_width, screen_height)
        return

    visit_date = database.extract_registration_date(registration)
    today = date.today()
    if visit_date and visit_date != today:
        messagebox.showwarning(
            "Tanggal Periksa Tidak Sesuai",
            (
                "Tanggal periksa pada data registrasi berbeda dengan hari ini.\n"
                f"Tanggal periksa: {visit_date.strftime('%d-%m-%Y')}."
            ),
        )
        return

    patient = database.fetch_patient_by_identifier(identifier)
    if not patient:
        messagebox.showwarning(
            "Pasien Tidak Ditemukan",
            "Data pasien belum ada di tabel pasiens. Pastikan pasien sudah terdaftar.",
        )

    is_control = _is_control_registration(registration)
    if is_control is None:
        is_control = messagebox.askyesno(
            "Jenis SEP",
            "Registrasi ini kontrol? Klik Ya untuk SEP Kontrol, Tidak untuk SEP Reguler.",
        )

    sep_path = "reservasi/sep-kontrol" if is_control else "reservasi/sep"
    sep_url = f"{config.SEP_BASE_URL.rstrip('/')}/{sep_path}/{registration_id}/{no_rm or ''}"
    _open_chrome_url(sep_url, half_screen_width, screen_height)


def run_action(root: tk.Tk, set_loading_state, action, message: str, buttons: list[tk.Button], on_error=None):
    set_loading_state(True, message, buttons)

    def task():
        try:
            action()
        except Exception as error:  # noqa: BLE001
            if on_error:
                on_error(error)
            else:
                messagebox.showerror("Error", f"Terjadi kesalahan: {error}")
        finally:
            root.after(0, lambda: set_loading_state(False, buttons=buttons))

    threading.Thread(target=task, daemon=True).start()


def run_bpjs_action(root: tk.Tk, set_loading_state, action, message: str, buttons: list[tk.Button]):
    run_action(root, set_loading_state, action, message, buttons, bpjs.handle_automation_error)
