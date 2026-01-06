"""Automation helpers for BPJS fingerprint application."""
import subprocess
from typing import Optional

import pyautogui
from tkinter import messagebox

from app import config, database


class BpjsAutomationError(Exception):
    """Raised when automation cannot proceed due to missing data."""


def _launch_application():
    subprocess.Popen([config.BPJS_EXECUTABLE])
    pyautogui.sleep(1.5)


def _login():
    pyautogui.sleep(config.LOGIN_DELAY_SECONDS)
    pyautogui.write(config.BPJS_USERNAME)
    pyautogui.press("tab")
    pyautogui.write(config.BPJS_PASSWORD)
    pyautogui.press("enter")
    pyautogui.sleep(config.POST_LOGIN_DELAY_SECONDS)
    pyautogui.press("enter")
    pyautogui.sleep(config.BPJS_STANDBY_SECONDS)


def _focus_window():
    screen_width, screen_height = pyautogui.size()
    pyautogui.click(screen_width // 2, screen_height // 2)


def _fill_member_id(member_id: str):
    _focus_window()
    for _ in range(4):
        pyautogui.press("tab")
    pyautogui.press("space")
    pyautogui.write(member_id)
    pyautogui.sleep(config.FORM_FILL_DELAY_SECONDS)
    pyautogui.hotkey("alt", "f4")


def _resolve_bpjs_number(registration: Optional[dict], patient: Optional[dict]) -> Optional[str]:
    if registration:
        for key in ("nomorkartu", "nomor_bpjs", "no_jkn", "no_bpjs"):
            value = registration.get(key)
            if value:
                return value
    if patient:
        for key in ("no_jkn", "nomor_bpjs", "no_bpjs", "nomorkartu"):
            value = patient.get(key)
            if value:
                return value
    return None


def _resolve_identity_value(registration: Optional[dict], patient: Optional[dict]) -> Optional[str]:
    if registration:
        for key in ("nik", "no_rujukan", "nomor_rujukan"):
            value = registration.get(key)
            if value:
                return value
    if patient:
        for key in ("nik", "no_rm"):
            value = patient.get(key)
            if value:
                return value
    return None


def _fill_registration_details(registration: Optional[dict], patient: Optional[dict]):
    _focus_window()
    identity_value = _resolve_identity_value(registration, patient)
    bpjs_number = _resolve_bpjs_number(registration, patient)
    if bpjs_number:
        # pyautogui.press("tab")
        # pyautogui.press("tab")
        # pyautogui.press("tab")
        # pyautogui.press("tab")
        # pyautogui.press("space")
        pyautogui.write(str(bpjs_number))
    elif identity_value:
        pyautogui.write(str(bpjs_number))
    pyautogui.sleep(config.FORM_FILL_DELAY_SECONDS)
    pyautogui.hotkey("alt", "f4")


def _extract_nik_from_patient(patient: dict) -> Optional[str]:
    """Return the NIK field if available."""
    if not patient:
        return None
    nik = patient.get("nik")
    if isinstance(nik, str) and len(nik) == 16 and nik.isdigit():
        return nik
    return None


def open_bpjs_for_member_id(no_rm: str):
    patient = database.fetch_patient_by_no_rm(no_rm)
    if not patient:
        raise BpjsAutomationError("Pasien dengan No RM tersebut tidak ditemukan.")

    bpjs_number = _resolve_bpjs_number(None, patient)
    if not bpjs_number:
        raise BpjsAutomationError("Data BPJS untuk pasien tidak tersedia.")

    _launch_application()
    _login()
    _fill_member_id(str(bpjs_number))


def open_bpjs_for_identifier(identifier: str):
    if not identifier:
        raise BpjsAutomationError("Masukkan No RM, NIK, atau BPJS terlebih dahulu.")

    registration: Optional[dict] = None
    patient: Optional[dict] = None

    registration = database.fetch_latest_registration(identifier)
    patient = database.fetch_patient_by_identifier(identifier)

    if not registration and not patient:
        raise BpjsAutomationError("Data registrasi atau pasien tidak ditemukan.")

    nik = None
    if len(identifier) == 16 and identifier.isdigit():
        nik = identifier
    if not nik and patient:
        nik = _extract_nik_from_patient(patient)

    _launch_application()
    _login()

    if registration:
        _fill_registration_details(registration, patient)
    elif patient and _resolve_identity_value(None, patient):
        _fill_registration_details(None, patient)
    elif nik:
        _fill_member_id(nik)
    else:
        raise BpjsAutomationError("NIK untuk pasien tidak ditemukan.")


def handle_automation_error(error: Exception):
    messagebox.showerror("Error", f"Terjadi kesalahan saat membuka aplikasi: {error}")
