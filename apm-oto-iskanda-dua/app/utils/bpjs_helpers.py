"""Helper utilities for BPJS fingerprint automation."""
from pathlib import Path
import subprocess
from typing import Optional

import pyautogui

from app import config


def bpjs_executable_name() -> str:
    executable = Path(config.BPJS_EXECUTABLE)
    return executable.name if executable.name else "After.exe"


def is_bpjs_running() -> bool:
    exe_name = bpjs_executable_name()
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


def focus_bpjs_window() -> bool:
    try:
        windows = pyautogui.getWindowsWithTitle(config.BPJS_WINDOW_TITLE)
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


def focus_window() -> None:
    if focus_bpjs_window():
        return
    screen_width, screen_height = pyautogui.size()
    pyautogui.click(screen_width // 2, screen_height // 2)


def launch_application() -> bool:
    if is_bpjs_running():
        if not focus_bpjs_window():
            focus_window()
        return False

    subprocess.Popen([config.BPJS_EXECUTABLE])
    pyautogui.sleep(config.BPJS_LAUNCH_DELAY_SECONDS)
    focus_bpjs_window()
    return True


def login() -> None:
    pyautogui.sleep(config.LOGIN_DELAY_SECONDS)
    pyautogui.write(config.BPJS_USERNAME)
    pyautogui.press("tab")
    pyautogui.write(config.BPJS_PASSWORD)
    pyautogui.press("enter")
    pyautogui.sleep(config.POST_LOGIN_DELAY_SECONDS)
    pyautogui.press("enter")
    pyautogui.sleep(config.BPJS_STANDBY_SECONDS)


def prepare_member_field() -> None:
    focus_window()
    for _ in range(3):
        pyautogui.press("tab")
    pyautogui.press("space")


def fill_value(value: str) -> None:
    pyautogui.hotkey("ctrl", "a")
    pyautogui.press("backspace")
    pyautogui.write(str(value))


def fill_member_id(member_id: str) -> None:
    prepare_member_field()
    fill_value(member_id)
    pyautogui.sleep(config.FORM_FILL_DELAY_SECONDS)
    if config.BPJS_CLOSE_AFTER_FILL:
        pyautogui.hotkey("alt", "f4")


def resolve_bpjs_number(registration: Optional[dict], patient: Optional[dict]) -> Optional[str]:
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


def resolve_identity_value(registration: Optional[dict], patient: Optional[dict]) -> Optional[str]:
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


def fill_registration_details(registration: Optional[dict], patient: Optional[dict]) -> bool:
    prepare_member_field()
    identity_value = resolve_identity_value(registration, patient)
    bpjs_number = resolve_bpjs_number(registration, patient)
    value_to_fill = bpjs_number or identity_value
    if not value_to_fill:
        return False
    fill_value(str(value_to_fill))
    pyautogui.sleep(config.FORM_FILL_DELAY_SECONDS)
    if config.BPJS_CLOSE_AFTER_FILL:
        pyautogui.hotkey("alt", "f4")
    return True


def extract_nik_from_patient(patient: dict) -> Optional[str]:
    if not patient:
        return None
    nik = patient.get("nik")
    if isinstance(nik, str) and len(nik) == 16 and nik.isdigit():
        return nik
    return None
