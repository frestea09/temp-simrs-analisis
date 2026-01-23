"""API helpers for patient lookup."""
from datetime import date, datetime
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
    last_error = None
    for base_url in _normalized_base_urls():
        try:
            response = requests.get(base_url, timeout=config.API_TIMEOUT_SECONDS)
            response.raise_for_status()
            return True, None
        except requests.RequestException as err:
            last_error = f"Gagal menghubungi API: {err}"
            logger.error("API ping failed: %s", last_error)
        except Exception as err:  # noqa: BLE001
            last_error = f"Kesalahan tidak terduga: {err}"
            logger.exception(last_error)
    return False, last_error


def _build_url(base_url: str, endpoint_template: str, identifier: str) -> str:
    base = base_url.rstrip("/")
    endpoint = endpoint_template.format(identifier=identifier).lstrip("/")
    return f"{base}/{endpoint}"


def _normalized_base_urls() -> list[str]:
    base_urls = []
    primary = (config.API_PRIMARY_BASE_URL or config.API_BASE_URL or "").strip()
    if primary:
        base_urls.append(primary)

    fallback_raw = (config.API_FALLBACK_BASE_URLS or "").strip()
    if fallback_raw:
        base_urls.extend([item.strip() for item in fallback_raw.split(",") if item.strip()])

    if not base_urls:
        return []

    normalized = []
    for base_url in base_urls:
        parsed = urlparse(base_url)
        normalized.append(base_url if parsed.scheme else f"http://{base_url}")
    return normalized


def _fetch_data(urls: list[str]) -> Optional[dict]:
    for url in urls:
        try:
            response = requests.get(url, timeout=config.API_TIMEOUT_SECONDS)
            response.raise_for_status()
            payload = response.json()
        except requests.RequestException as err:
            logger.error("API request failed for %s: %s", url, err)
            continue
        except ValueError as err:
            logger.error("API response not JSON for %s: %s", url, err)
            continue

        if isinstance(payload, dict) and "data" in payload:
            return payload["data"]
        if isinstance(payload, dict):
            return payload
    return None


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
    urls = [
        _build_url(base_url, config.API_PATIENT_ENDPOINT, identifier)
        for base_url in _normalized_base_urls()
    ]
    return _fetch_data(urls)


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
    urls = [
        _build_url(base_url, config.API_REGISTRATION_ENDPOINT, identifier)
        for base_url in _normalized_base_urls()
    ]
    return _fetch_data(urls)


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
