"""Action helpers to keep the Tkinter UI lean and readable."""

from datetime import date
from pathlib import Path
import shutil
import subprocess
import sys
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

CONTROL_NUMERIC_VALUES = {
    "0": False,
    "1": False,
    "2": True,
    "3": True,
    "4": True,
}
CONTROL_TRUE_VALUES = {"y", "yes", "true", "kontrol", "control", "postrawat", "post rawat"}
CONTROL_FALSE_VALUES = {"n", "no", "false", "reguler", "regular", "baru", "rujukan baru"}
CONTROL_REFERENCE_KEYS = {
    "no_surat_kontrol",
    "no_surkon",
    "surat_kontrol",
    "no_skdp",
}
CONTROL_REFERENCE_TOKENS = {"SKDP", "SURKON", "SURAT KONTROL"}


def _interpret_control_value(value: object) -> bool | None:
    if isinstance(value, bool):
        return value
    if value is None:
        return None
    text_value = str(value).strip().lower()
    if not text_value:
        return None
    if text_value in CONTROL_TRUE_VALUES:
        return True
    if text_value in CONTROL_FALSE_VALUES:
        return False
    if text_value in CONTROL_NUMERIC_VALUES:
        return CONTROL_NUMERIC_VALUES[text_value]
    if "kontrol" in text_value:
        return True
    return None


def _infer_control_from_registration(registration: dict) -> bool | None:
    if not registration:
        return None
    for key, value in registration.items():
        normalized_key = str(key).lower()
        if normalized_key not in CONTROL_HINT_KEYS:
            continue
        inferred = _interpret_control_value(value)
        if inferred is not None:
            return inferred

    for key in ("jenis_kunjungan", "jenisKunjungan", "jeniskunjungan", "jenis_kunjungan_kode"):
        value = registration.get(key)
        inferred = _interpret_control_value(value)
        if inferred is not None:
            return inferred

    for key in CONTROL_REFERENCE_KEYS:
        value = registration.get(key)
        if value:
            return True

    no_rujukan = registration.get("no_rujukan") or registration.get("nomor_rujukan")
    if isinstance(no_rujukan, str) and no_rujukan.strip():
        normalized_rujukan = no_rujukan.strip().upper()
        if any(token in normalized_rujukan for token in CONTROL_REFERENCE_TOKENS):
            return True
        if "K" in normalized_rujukan and len(normalized_rujukan) >= 6:
            return True
    return None


def _browser_window_titles() -> tuple[str, ...]:
    exe_name = Path(config.CHROME_EXECUTABLE).name.lower()
    if "firefox" in exe_name:
        return ("Mozilla Firefox", "Firefox")
    if "msedge" in exe_name or "edge" in exe_name:
        return ("Microsoft Edge", "Edge")
    if "chromium" in exe_name:
        return ("Chromium", "Google Chrome", "Chrome")
    return ("Google Chrome", "Chrome", "Chromium", "Microsoft Edge", "Edge")


def _is_chrome_based_browser() -> bool:
    exe_name = Path(config.CHROME_EXECUTABLE).name.lower()
    return any(token in exe_name for token in ("chrome", "chromium", "msedge", "edge"))


def _focus_chrome_window() -> bool:
    for title in _browser_window_titles():
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
        if _set_clipboard_text(url):
            pyautogui.hotkey("ctrl", "v")
        else:
            pyautogui.write(url)
        pyautogui.press("enter")
        return

    window_position = f"--window-position={half_screen_width},0"
    window_size = f"--window-size={half_screen_width},{screen_height}"
    browser_args = [
        config.CHROME_EXECUTABLE,
        window_position,
        window_size,
    ]
    if _is_chrome_based_browser():
        browser_args.append("--new-window")
    elif "firefox" in Path(config.CHROME_EXECUTABLE).name.lower():
        browser_args.append("-new-tab")
    browser_args.append(url)
    subprocess.Popen(browser_args)


def _set_clipboard_text(text: str) -> bool:
    if sys.platform.startswith("win"):
        subprocess.run(["cmd", "/c", "clip"], input=text, text=True, check=False)
        return True

    if sys.platform == "darwin":
        if shutil.which("pbcopy"):
            subprocess.run(["pbcopy"], input=text, text=True, check=False)
            return True
        return False

    if shutil.which("xclip"):
        subprocess.run(["xclip", "-selection", "clipboard"], input=text, text=True, check=False)
        return True
    if shutil.which("xsel"):
        subprocess.run(["xsel", "--clipboard", "--input"], input=text, text=True, check=False)
        return True
    return False


def _build_cek_baru_url() -> str:
    base_url = config.SEP_CHECK_NEW_BASE_URL or config.SEP_BASE_URL
    return f"{base_url.rstrip('/')}/reservasi/cek-baru"


def _build_ticket_url(registration_id: str | int, no_rm: str) -> str:
    base_url = config.TICKET_BASE_URL or config.SEP_BASE_URL
    template = config.TICKET_URL_TEMPLATE or "/reservasi/cetak-baru/{registration_id}/{no_rm}"
    path = template.format(registration_id=registration_id, no_rm=no_rm)
    return f"{base_url.rstrip('/')}/{path.lstrip('/')}"


def _build_admission_ticket_html(identifier: str, patient: dict | None) -> str:
    title = config.ADMISSION_TICKET_TITLE
    message = config.ADMISSION_TICKET_MESSAGE
    patient_name = (patient or {}).get("nama") or "-"
    patient_nik = (patient or {}).get("nik") or "-"
    patient_card = (patient or {}).get("no_kartu") or "-"

    return f"""
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <title>{title}</title>
    <style>
      body {{ font-family: "Times New Roman", serif; margin: 24px; }}
      .ticket {{ border: 1px dashed #333; padding: 16px; width: 360px; }}
      h2 {{ margin: 0 0 8px; text-align: center; }}
      .label {{ font-weight: bold; }}
      .message {{ margin-top: 12px; font-size: 16px; }}
      .meta {{ margin-top: 12px; font-size: 12px; color: #333; }}
    </style>
  </head>
  <body onload="window.print()">
    <div class="ticket">
      <h2>{title}</h2>
      <div class="message">{message}</div>
      <hr/>
      <div><span class="label">Identitas:</span> {identifier}</div>
      <div><span class="label">Nama:</span> {patient_name}</div>
      <div><span class="label">NIK:</span> {patient_nik}</div>
      <div><span class="label">No. Kartu:</span> {patient_card}</div>
      <div class="meta">Silakan bawa tiket ini ke loket pendaftaran.</div>
    </div>
  </body>
</html>
"""


def _open_admission_ticket(identifier: str, patient: dict | None, half_screen_width: int, screen_height: int) -> bool:
    try:
        html = _build_admission_ticket_html(identifier, patient)
        output_path = Path(config.CONFIG_FILE_PATH).parent / "tiket-admisi.html"
        output_path.write_text(html, encoding="utf-8")
        _open_chrome_url(output_path.resolve().as_uri(), half_screen_width, screen_height)
        return True
    except OSError:
        return False


def launch_sep_flow(identifier: str, half_screen_width: int, screen_height: int):
    """
    Open Chrome directly to the SEP page for the latest booking tied to the identifier.
    Identifier may be No RM, NIK, or nomor BPJS.
    """

    registration = database.fetch_latest_registration(identifier)
    if not registration:
        patient = database.fetch_patient_by_identifier(identifier)
        messagebox.showwarning(
            "Reservasi Tidak Ditemukan",
            "Reservasi tidak ditemukan. Mencetak tiket admisi.",
        )
        if not _open_admission_ticket(identifier, patient, half_screen_width, screen_height):
            _open_chrome_url(_build_cek_baru_url(), half_screen_width, screen_height)
        return

    registration_id = registration.get("id")
    no_rm = registration.get("no_rm")
    if not registration_id:
        messagebox.showwarning(
            "Reservasi Tidak Lengkap",
            "Data reservasi tidak lengkap. Membuka halaman cek baru.",
        )
        _open_chrome_url(_build_cek_baru_url(), half_screen_width, screen_height)
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

    database.update_taskid_after_print(registration, patient)

    is_control = _infer_control_from_registration(registration)
    if is_control is None:
        is_control = False

    sep_path = "reservasi/sep-kontrol" if is_control else "reservasi/sep"
    sep_url = f"{config.SEP_BASE_URL.rstrip('/')}/{sep_path}/{registration_id}/{no_rm or ''}"
    _open_chrome_url(sep_url, half_screen_width, screen_height)


def launch_ticket_flow(identifier: str, half_screen_width: int, screen_height: int):
    """
    Open Chrome directly to the ticket print page for the latest booking tied to the identifier.
    """
    registration = database.fetch_latest_registration(identifier)
    if not registration:
        patient = database.fetch_patient_by_identifier(identifier)
        messagebox.showwarning(
            "Reservasi Tidak Ditemukan",
            "Reservasi tidak ditemukan. Mencetak tiket admisi.",
        )
        _open_admission_ticket(identifier, patient, half_screen_width, screen_height)
        return

    registration_id = registration.get("id")
    no_rm = registration.get("no_rm") or ""
    if not registration_id:
        messagebox.showwarning(
            "Reservasi Tidak Lengkap",
            "Data reservasi tidak lengkap untuk cetak tiket.",
        )
        return

    patient = database.fetch_patient_by_identifier(identifier)
    database.update_taskid_after_print(registration, patient)

    ticket_url = _build_ticket_url(registration_id, no_rm)
    _open_chrome_url(ticket_url, half_screen_width, screen_height)


def launch_ticket_flow_extended(identifier: str, half_screen_width: int, screen_height: int):
    """
    1. Call create-from-simrs API.
    2. If success (200), proceed to ticket print.
    3. If fail, show warning and print admission ticket.
    """
    response = database.create_sep_from_simrs(identifier)
    
    metadata = response.get("metaData", {}) if isinstance(response, dict) else {}
    code = metadata.get("code")
    message = metadata.get("message", "Gagal menghubungkan ke server untuk pembuatan SEP.")

    if code == "200":
        # Success: proceed with normal ticket flow
        launch_ticket_flow(identifier, half_screen_width, screen_height)
    else:
        # Failure: show message and print admission ticket
        messagebox.showwarning(
            "Gagal Membuat SEP",
            f"Pesan: {message}\n\nSistem akan mencetak tiket admisi untuk pendaftaran manual.",
        )
        patient = database.fetch_patient_by_identifier(identifier)
        _open_admission_ticket(identifier, patient, half_screen_width, screen_height)


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
