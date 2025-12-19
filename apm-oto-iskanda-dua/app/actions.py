"""Action helpers to keep the Tkinter UI lean and readable."""

import subprocess
import threading
import tkinter as tk
from tkinter import messagebox

from app import bpjs, config, database


def launch_checkin_portal(half_screen_width: int, screen_height: int):
    window_position = f"--window-position={half_screen_width},0"
    window_size = f"--window-size={half_screen_width},{screen_height}"
    subprocess.Popen(
        [
            config.CHROME_EXECUTABLE,
            window_position,
            window_size,
            "--new-window",
            config.CHECKIN_URL,
        ]
    )


def launch_sep_flow(identifier: str, half_screen_width: int, screen_height: int):
    """
    Open Chrome directly to the SEP page for the latest booking tied to the identifier.
    Identifier may be No RM, NIK, or nomor BPJS.
    """

    booking = database.fetch_latest_booking(identifier)
    if not booking:
        raise ValueError("Reservasi/booking tidak ditemukan untuk identitas tersebut.")

    nomorantrian, no_rm, booking_id, tglperiksa, nik = booking
    if not booking_id:
        raise ValueError("Data booking tidak lengkap untuk diarahkan ke halaman SEP.")

    # Pastikan tanggal periksa sesuai hari ini, jika tidak beri info tanggal yang benar
    if tglperiksa:
        try:
            from datetime import date

            parsed = date.fromisoformat(str(tglperiksa))
            if parsed != date.today():
                raise ValueError(
                    f"Tanggal periksa tidak sesuai. Jadwal asli: {parsed.strftime('%d-%m-%Y')}."
                )
        except ValueError:
            # Jika format tanggal tidak sesuai ISO, tetap biarkan agar tidak menghalangi flow
            pass

    # Validasi keberadaan pasien di master; informasikan jika belum ada
    patient = None
    if no_rm:
        patient = database.fetch_patient_by_no_rm(no_rm)
    if not patient and nik:
        patient = database.fetch_patient_by_nik(nik)
    if not patient:
        raise ValueError(
            "Data pasien belum ada di master pasien. Mohon registrasi/mapping pasien terlebih dahulu sebelum cetak SEP."
        )

    sep_url = f"{config.SEP_BASE_URL.rstrip('/')}/reservasi/sep/{booking_id}/{no_rm or ''}"

    window_position = f"--window-position={half_screen_width},0"
    window_size = f"--window-size={half_screen_width},{screen_height}"
    subprocess.Popen(
        [
            config.CHROME_EXECUTABLE,
            window_position,
            window_size,
            "--new-window",
            sep_url,
        ]
    )


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
