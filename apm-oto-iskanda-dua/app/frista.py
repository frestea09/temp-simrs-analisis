"""Automation helpers for launching and filling the Frista application."""
import subprocess

import pyautogui
from tkinter import messagebox

from app import config, database


class FristaAutomationError(Exception):
    """Raised when Frista automation cannot proceed."""


def _extract_nik(record) -> str | None:
    """Return the NIK from an API record."""

    if not record:
        return None

    nik = record.get("nik")
    if isinstance(nik, str) and len(nik) == 16 and nik.isdigit():
        return nik
    return None


def _resolve_nik(identifier: str) -> str:
    registration = database.fetch_latest_registration(identifier)
    patient = database.fetch_patient_by_identifier(identifier)

    if not registration and not patient:
        raise FristaAutomationError("Data registrasi atau pasien tidak ditemukan.")

    if len(identifier) == 16 and identifier.isdigit():
        return identifier

    nik = _extract_nik(patient) or _extract_nik(registration)
    if not nik:
        raise FristaAutomationError("NIK pasien tidak ditemukan dari data yang tersedia.")
    return nik


def open_frista_for_identifier(identifier: str):
    """Launch Frista and fill credentials plus the resolved NIK."""

    if not identifier:
        raise FristaAutomationError("Masukkan NIK atau identitas pasien terlebih dahulu.")

    nik = _resolve_nik(identifier)

    try:
        subprocess.Popen([config.FRISTA_EXECUTABLE])
    except FileNotFoundError as exc:
        raise FristaAutomationError("Executable Frista tidak ditemukan.") from exc

    pyautogui.sleep(config.FRISTA_LOGIN_DELAY_SECONDS)
    pyautogui.write(config.FRISTA_USERNAME)
    pyautogui.press("tab")
    pyautogui.write(config.FRISTA_PASSWORD)
    pyautogui.press("tab")
    pyautogui.press("space")

    pyautogui.sleep(config.FRISTA_STANDBY_SECONDS)

    screen_width, screen_height = pyautogui.size()
    pyautogui.click(screen_width // 2, screen_height // 2)
    pyautogui.write(nik)


def handle_automation_error(error: Exception):
    messagebox.showerror("Error", f"Terjadi kesalahan saat membuka Frista: {error}")
