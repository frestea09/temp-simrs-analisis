"""Automation helpers for launching and filling the Frista application."""
import subprocess
from pathlib import Path

import pyautogui
from tkinter import messagebox

from app import config, database


class FristaAutomationError(Exception):
    """Raised when Frista automation cannot proceed."""


def _frista_executable_name() -> str:
    executable = Path(config.FRISTA_EXECUTABLE)
    return executable.name if executable.name else "Frista.exe"


def _is_frista_running() -> bool:
    exe_name = _frista_executable_name()
    try:
        result = subprocess.run(
            ["tasklist", "/FI", f"IMAGENAME eq {exe_name}"],
            capture_output=True,
            text=True,
            check=False,
        )
    except FileNotFoundError:
        return False
    return exe_name.lower() in result.stdout.lower()


def _focus_frista_window() -> bool:
    try:
        windows = pyautogui.getWindowsWithTitle(config.FRISTA_WINDOW_TITLE)
    except Exception:  # noqa: BLE001
        return False
    for window in windows:
        if not window:
            continue
        if getattr(window, "isMinimized", False):
            window.restore()
        window.activate()
        pyautogui.sleep(0.4)
        return True
    return False


def _launch_frista() -> bool:
    if _is_frista_running():
        if not _focus_frista_window():
            screen_width, screen_height = pyautogui.size()
            pyautogui.click(screen_width // 2, screen_height // 2)
        return False

    try:
        subprocess.Popen([config.FRISTA_EXECUTABLE])
    except FileNotFoundError as exc:
        raise FristaAutomationError("Executable Frista tidak ditemukan.") from exc
    pyautogui.sleep(config.FRISTA_LAUNCH_DELAY_SECONDS)
    _focus_frista_window()
    return True


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

    launched = _launch_frista()
    if launched:
        pyautogui.sleep(config.FRISTA_LOGIN_DELAY_SECONDS)
        pyautogui.write(config.FRISTA_USERNAME)
        pyautogui.press("tab")
        pyautogui.write(config.FRISTA_PASSWORD)
        pyautogui.press("tab")
        pyautogui.press("space")
        pyautogui.sleep(config.FRISTA_STANDBY_SECONDS)

    if not _focus_frista_window():
        screen_width, screen_height = pyautogui.size()
        pyautogui.click(screen_width // 2, screen_height // 2)
    pyautogui.hotkey("ctrl", "a")
    pyautogui.press("backspace")
    pyautogui.write(nik)


def handle_automation_error(error: Exception):
    messagebox.showerror("Error", f"Terjadi kesalahan saat membuka Frista: {error}")
