"""API helpers for patient lookup."""
from datetime import date, datetime
import logging
from pathlib import Path
from typing import Optional, Tuple

import requests

from app import config


PatientRow = dict
RegistrationRow = dict

ERROR_LOG_PATH = Path.home() / "apm_api_errors.log"

logger = logging.getLogger(__name__)
if not logger.handlers:
    logger.setLevel(logging.INFO)
    file_handler = logging.FileHandler(ERROR_LOG_PATH, encoding="utf-8")
    formatter = logging.Formatter(
        "%(asctime)s - %(levelname)s - %(name)s - %(message)s"
    )
    file_handler.setFormatter(formatter)
    logger.addHandler(file_handler)


def ping_database() -> tuple[bool, Optional[str]]:
    try:
        response = requests.get(config.API_BASE_URL, timeout=config.API_TIMEOUT_SECONDS)
        response.raise_for_status()
        return True, None
    except requests.RequestException as err:
        error_message = f"Gagal menghubungi API: {err}"
        logger.error("API ping failed: %s", error_message)
        return False, error_message
    except Exception as err:  # noqa: BLE001
        error_message = f"Kesalahan tidak terduga: {err}"
        logger.exception(error_message)
        return False, error_message


def _build_url(endpoint_template: str, identifier: str) -> str:
    base = config.API_BASE_URL.rstrip("/")
    endpoint = endpoint_template.format(identifier=identifier).lstrip("/")
    return f"{base}/{endpoint}"


def _fetch_data(url: str) -> Optional[dict]:
    try:
        response = requests.get(url, timeout=config.API_TIMEOUT_SECONDS)
        response.raise_for_status()
        payload = response.json()
    except requests.RequestException as err:
        logger.error("API request failed for %s: %s", url, err)
        return None
    except ValueError as err:
        logger.error("API response not JSON for %s: %s", url, err)
        return None

    if isinstance(payload, dict) and "data" in payload:
        return payload["data"]
    return payload if isinstance(payload, dict) else None


def fetch_patient_by_no_rm(no_rm: str) -> Optional[PatientRow]:
    return _fetch_patient(no_rm)


def fetch_patient_by_nik(nik: str) -> Optional[PatientRow]:
    return _fetch_patient(nik)


def fetch_registration_by_no_rm(no_rm: str) -> Optional[RegistrationRow]:
    """Fetch the newest registration matching the given medical record number."""
    return _fetch_registration(no_rm)


def fetch_registration_by_nik(nik: str) -> Optional[RegistrationRow]:
    """Fetch the newest registration matching the given national ID."""
    return _fetch_registration(nik)


def fetch_registration_by_bpjs(bpjs_number: str) -> Optional[RegistrationRow]:
    """Fetch the newest registration matching the given BPJS card number."""
    return _fetch_registration(bpjs_number)


def fetch_patient_by_bpjs(bpjs_number: str) -> Optional[PatientRow]:
    """Fetch a patient record by BPJS card number."""
    return _fetch_patient(bpjs_number)


def fetch_patient_by_identifier(identifier: str) -> Optional[PatientRow]:
    """Return the patient matching No RM, NIK, or nomor BPJS (latest priority order)."""

    return _fetch_patient(identifier)


def _fetch_patient(identifier: str) -> Optional[PatientRow]:
    if not identifier:
        return None
    url = _build_url(config.API_PATIENT_ENDPOINT, identifier)
    return _fetch_data(url)


def fetch_latest_booking(identifier: str) -> Optional[Tuple[str, str, int]]:
    """
    Return the latest booking info (nomorantrian, no_rm, id) for the provided identifier.

    The identifier can be No RM, NIK (16 digit), or nomor BPJS. The query prioritizes No RM,
    then NIK, then BPJS number.
    """
    registration = _fetch_registration(identifier)
    if not registration:
        return None
    return (
        registration.get("nomorantrian")
        or registration.get("nomor_antrian"),
        registration.get("no_rm"),
        registration.get("id"),
    )


def fetch_latest_registration(identifier: str) -> Optional[RegistrationRow]:
    """
    Return the latest registration row (entire tuple) matching No RM, NIK, or nomor BPJS.
    """
    return _fetch_registration(identifier)


def _fetch_registration(identifier: str) -> Optional[RegistrationRow]:
    if not identifier:
        return None
    url = _build_url(config.API_REGISTRATION_ENDPOINT, identifier)
    return _fetch_data(url)


def extract_registration_date(registration: RegistrationRow) -> Optional[date]:
    """Extract the visit date from a registration row, normalized to a date object."""

    if not registration:
        return None

    raw_date = (
        registration.get("tanggal_periksa")
        or registration.get("tglperiksa")
        or registration.get("tanggal")
        or registration.get("created_at")
    )
    if isinstance(raw_date, datetime):
        return raw_date.date()
    if isinstance(raw_date, date):
        return raw_date
    if isinstance(raw_date, str) and raw_date:
        for fmt in ("%Y-%m-%d", "%Y-%m-%d %H:%M:%S"):
            try:
                return datetime.strptime(raw_date, fmt).date()
            except ValueError:
                continue
    return None
