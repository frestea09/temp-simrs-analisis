"""API helpers for patient lookup."""
from datetime import date, datetime, time
import logging
from pathlib import Path
from typing import Optional, Tuple
from urllib.parse import urlparse

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
        response = requests.get(_normalized_base_url(), timeout=config.API_TIMEOUT_SECONDS)
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
    base = _normalized_base_url().rstrip("/")
    endpoint = endpoint_template.format(identifier=identifier).lstrip("/")
    return f"{base}/{endpoint}"


def _build_url_with_date(endpoint_template: str, identifier: str, visit_date: date) -> str:
    base = _normalized_base_url().rstrip("/")
    endpoint = endpoint_template.format(
        identifier=identifier,
        date=visit_date.strftime("%Y-%m-%d"),
    ).lstrip("/")
    return f"{base}/{endpoint}"


def _normalized_base_url() -> str:
    base_url = config.API_BASE_URL.strip()
    if not base_url:
        return base_url
    parsed = urlparse(base_url)
    if not parsed.scheme:
        return f"http://{base_url}"
    return base_url


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
    registration = fetch_latest_registration(identifier)
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
    registrations = fetch_registrations(identifier)
    return _select_latest_registration(registrations)


def fetch_registration_for_date(identifier: str, target_date: date) -> Optional[RegistrationRow]:
    """Return the registration matching the identifier and visit date."""

    registration = _fetch_registration_by_date(identifier, target_date)
    if registration:
        return registration
    registrations = fetch_registrations(identifier)
    if not registrations:
        return None
    return _select_registration_for_date(registrations, target_date)


def fetch_registrations(identifier: str) -> list[RegistrationRow]:
    """Fetch registrations matching the identifier (list endpoint when available)."""

    if not identifier:
        return []
    endpoint = config.API_REGISTRATION_LIST_ENDPOINT or config.API_REGISTRATION_ENDPOINT
    url = _build_url(endpoint, identifier)
    payload = _fetch_data(url)
    return _normalize_registrations(payload)


def _fetch_registration(identifier: str) -> Optional[RegistrationRow]:
    if not identifier:
        return None
    url = _build_url(config.API_REGISTRATION_ENDPOINT, identifier)
    return _fetch_data(url)


def _fetch_registration_by_date(identifier: str, target_date: date) -> Optional[RegistrationRow]:
    if not identifier or not config.API_REGISTRATION_BY_DATE_ENDPOINT:
        return None
    url = _build_url_with_date(
        config.API_REGISTRATION_BY_DATE_ENDPOINT,
        identifier,
        target_date,
    )
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


def _normalize_registrations(payload: object) -> list[RegistrationRow]:
    if payload is None:
        return []
    if isinstance(payload, list):
        return [item for item in payload if isinstance(item, dict)]
    if isinstance(payload, dict):
        return [payload]
    return []


def _parse_datetime_value(value: object) -> Optional[datetime]:
    if isinstance(value, datetime):
        return value
    if isinstance(value, date):
        return datetime.combine(value, time.min)
    if isinstance(value, str) and value:
        for fmt in ("%Y-%m-%d %H:%M:%S", "%Y-%m-%d"):
            try:
                return datetime.strptime(value, fmt)
            except ValueError:
                continue
    return None


def _registration_sort_key(registration: RegistrationRow) -> tuple:
    visit_date = extract_registration_date(registration) or date.min
    created_at = _parse_datetime_value(
        registration.get("created_at") or registration.get("updated_at")
    ) or datetime.min
    try:
        reg_id = int(registration.get("id"))
    except (TypeError, ValueError):
        reg_id = -1
    return (visit_date, created_at, reg_id)


def _select_latest_registration(registrations: list[RegistrationRow]) -> Optional[RegistrationRow]:
    if not registrations:
        return None
    return max(registrations, key=_registration_sort_key)


def _select_registration_for_date(
    registrations: list[RegistrationRow],
    target_date: date,
) -> Optional[RegistrationRow]:
    matches = [
        registration
        for registration in registrations
        if extract_registration_date(registration) == target_date
    ]
    if not matches:
        return None
    return max(matches, key=_registration_sort_key)
