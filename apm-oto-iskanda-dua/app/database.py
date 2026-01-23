"""API helpers for patient lookup."""
from datetime import date, datetime
import logging
from pathlib import Path
from typing import Optional, Tuple
from urllib.parse import urlparse

import requests
import time

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


def _post_json(url: str, payload: dict) -> Optional[dict]:
    try:
        response = requests.post(url, json=payload, timeout=config.API_TIMEOUT_SECONDS)
        response.raise_for_status()
        return response.json()
    except requests.RequestException as err:
        logger.error("API POST failed for %s: %s", url, err)
        return None
    except ValueError as err:
        logger.error("API POST response not JSON for %s: %s", url, err)
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
    patient = _fetch_data(urls)
    if patient:
        return patient
    return _fetch_bpjs_participant(identifier)


def _fetch_bpjs_participant(identifier: str) -> Optional[PatientRow]:
    base_url = (config.BPJS_API_BASE_URL or "").strip().rstrip("/")
    if not base_url:
        return None

    today = date.today().strftime("%Y-%m-%d")
    identifier = identifier.strip()
    if not identifier:
        return None

    if identifier.isdigit() and len(identifier) == 16:
        path = f"/bpjs/vclaim/peserta/nik/{identifier}/tglSEP/{today}"
    else:
        path = f"/bpjs/vclaim/peserta/nokartu/{identifier}/tglSEP/{today}"

    url = f"{base_url}{path}"
    payload = _fetch_data([url])
    if not payload:
        return None

    participant = payload.get("peserta") if isinstance(payload, dict) else None
    if not participant and isinstance(payload, dict):
        participant = payload.get("response", {}).get("peserta")

    if not isinstance(participant, dict):
        return None

    return {
        "nama": participant.get("nama"),
        "no_kartu": participant.get("noKartu"),
        "nik": participant.get("nik"),
        "tgl_lahir": participant.get("tglLahir"),
        "jenis_kelamin": participant.get("sex") or participant.get("kelamin"),
        "provider": participant.get("provUmum") or participant.get("provPerujuk"),
    }


def update_taskid_after_print(registration: RegistrationRow, patient: Optional[PatientRow]) -> None:
    """Best-effort: run antrean/add + updatewaktu taskid 3 via backend-apm-oid."""
    if not registration:
        return

    base_url = (config.BPJS_API_BASE_URL or "").strip().rstrip("/")
    if not base_url:
        return

    add_endpoint = config.BPJS_ANTREAN_ADD_ENDPOINT or "/bpjs/antrean/add"
    update_endpoint = config.BPJS_ANTREAN_UPDATE_ENDPOINT or "/bpjs/antrean/updatewaktu"

    payload = _build_antrean_payload(registration, patient)
    if not payload:
        return

    add_url = f"{base_url}/{add_endpoint.lstrip('/')}"
    add_response = _post_json(add_url, payload) or {}

    kodebooking = _extract_kodebooking(add_response) or payload.get("kodebooking")
    if not kodebooking:
        return

    update_url = f"{base_url}/{update_endpoint.lstrip('/')}"
    update_payload = {
        "kodebooking": kodebooking,
        "taskid": 3,
        "waktu": int(time.time() * 1000),
    }
    _post_json(update_url, update_payload)


def _extract_kodebooking(response: dict) -> Optional[str]:
    if not isinstance(response, dict):
        return None
    candidate = response.get("kodebooking")
    if candidate:
        return str(candidate)
    response_payload = response.get("response") if isinstance(response.get("response"), dict) else {}
    candidate = response_payload.get("kodebooking")
    return str(candidate) if candidate else None


def _build_antrean_payload(registration: RegistrationRow, patient: Optional[PatientRow]) -> Optional[dict]:
    kodebooking = (
        registration.get("kodebooking")
        or registration.get("nomorantrian")
        or registration.get("nomor_antrian")
    )
    if not kodebooking:
        return None

    nomorkartu = (
        registration.get("no_kartu")
        or registration.get("nokartu")
        or registration.get("nomorkartu")
        or (patient or {}).get("no_kartu")
    )
    nik = registration.get("nik") or (patient or {}).get("nik")
    no_rm = registration.get("no_rm") or (patient or {}).get("no_rm")
    nama = registration.get("nama") or (patient or {}).get("nama")
    tanggal_periksa = (
        registration.get("tanggal_periksa")
        or registration.get("tglperiksa")
        or registration.get("tanggal")
    )

    nomorantrean = registration.get("nomorantrean") or registration.get("nomorantrian")
    angkaantrean = registration.get("angkaantrean")
    if angkaantrean is None and isinstance(nomorantrean, str):
        digits = "".join(char for char in nomorantrean if char.isdigit())
        angkaantrean = int(digits) if digits else None

    payload = {
        "kodebooking": str(kodebooking),
        "jenispasien": registration.get("jenispasien") or "JKN",
        "nomorkartu": nomorkartu or "",
        "nik": nik or "",
        "nohp": registration.get("no_hp") or registration.get("nohp") or "",
        "kodepoli": registration.get("kode_poli") or registration.get("kodepoli") or "",
        "namapoli": registration.get("nama_poli") or registration.get("poli") or "",
        "pasienbaru": int(bool(registration.get("pasien_baru") or registration.get("pasienbaru") == 1)),
        "norm": no_rm or "",
        "tanggalperiksa": tanggal_periksa or "",
        "kodedokter": registration.get("kode_dokter") or registration.get("kodedokter") or "",
        "namadokter": registration.get("nama_dokter") or registration.get("namadokter") or "",
        "jampraktek": registration.get("jam_praktek") or registration.get("jampraktek") or "",
        "jeniskunjungan": registration.get("jenis_kunjungan") or registration.get("jeniskunjungan") or 1,
        "nomorreferensi": registration.get("no_rujukan") or registration.get("nomorreferensi") or "",
        "nomorantrean": nomorantrean or "",
        "angkaantrean": int(angkaantrean) if angkaantrean is not None else 0,
        "estimasidilayani": registration.get("estimasidilayani") or int(time.time() * 1000),
        "sisakuotajkn": registration.get("sisakuotajkn") or 0,
        "kuotajkn": registration.get("kuotajkn") or 0,
        "sisakuotanonjkn": registration.get("sisakuotanonjkn") or 0,
        "kuotanonjkn": registration.get("kuotanonjkn") or 0,
        "keterangan": registration.get("keterangan") or f"Pasien {nama or ''}".strip() or "Pasien datang.",
    }
    return payload


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
