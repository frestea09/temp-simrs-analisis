"""Automation helpers for BPJS fingerprint application."""
from typing import Optional

from tkinter import messagebox

from app import database
from app.utils import bpjs_helpers


class BpjsAutomationError(Exception):
    """Raised when automation cannot proceed due to missing data."""


def open_bpjs_for_member_id(no_rm: str):
    patient = database.fetch_patient_by_no_rm(no_rm)
    if not patient:
        raise BpjsAutomationError("Pasien dengan No RM tersebut tidak ditemukan.")

    bpjs_number = bpjs_helpers.resolve_bpjs_number(None, patient)
    if not bpjs_number:
        raise BpjsAutomationError("Data BPJS untuk pasien tidak tersedia.")

    launched = bpjs_helpers.launch_application()
    if launched:
        bpjs_helpers.login()
    bpjs_helpers.fill_member_id(str(bpjs_number))


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
        nik = bpjs_helpers.extract_nik_from_patient(patient)

    launched = bpjs_helpers.launch_application()
    if launched:
        bpjs_helpers.login()

    if registration:
        filled = bpjs_helpers.fill_registration_details(registration, patient)
        if filled:
            return
        if nik:
            bpjs_helpers.fill_member_id(nik)
            return
        raise BpjsAutomationError("Data BPJS atau identitas pasien tidak ditemukan.")
    if patient and bpjs_helpers.resolve_identity_value(None, patient):
        filled = bpjs_helpers.fill_registration_details(None, patient)
        if filled:
            return
        if nik:
            bpjs_helpers.fill_member_id(nik)
            return
        raise BpjsAutomationError("Data BPJS atau identitas pasien tidak ditemukan.")
    elif nik:
        bpjs_helpers.fill_member_id(nik)
    else:
        raise BpjsAutomationError("NIK untuk pasien tidak ditemukan.")


def handle_automation_error(error: Exception):
    messagebox.showerror("Error", f"Terjadi kesalahan saat membuka aplikasi: {error}")
