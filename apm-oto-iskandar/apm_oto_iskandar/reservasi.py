import base64
import json
from datetime import date, datetime, timedelta
from typing import Dict, Optional

from sqlalchemy import and_, select
from sqlalchemy.orm import Session

from .db import (
    base_reservasi_query,
    find_patient_name,
    is_lock_enabled,
    poli_name,
    registrasi_dummy,
)


def _parse_booking_code(keyword: str) -> Dict[str, Optional[str]]:
    """
    Rebuild the booking code logic from the Laravel controller:
    - payloads longer than 200 chars are treated as base64 JSON from the mobile app
    - strings containing '-' are used verbatim
    - everything else is prefixed with today's DDMMYYYY format
    """
    keyword = keyword or ""
    if len(keyword) > 200:
        try:
            decoded = base64.b64decode(keyword).decode("utf-8")
            payload = json.loads(decoded)
            return {"kodebooking": payload.get("kodeBooking")}
        except (ValueError, json.JSONDecodeError):
            return {"kodebooking": None}

    if "-" in keyword:
        return {"nomorantrian": keyword}

    today_prefix = date.today().strftime("%d%m%Y")
    return {"nomorantrian": f"{today_prefix}{keyword.upper()}"}


def _format_date(value) -> str:
    if isinstance(value, (datetime, date)):
        return value.strftime("%d-%m-%Y")
    if isinstance(value, str):
        try:
            parsed = datetime.fromisoformat(value)
            return parsed.strftime("%d-%m-%Y")
        except ValueError:
            return value
    return ""


def _mask_nik(nik: Optional[str]) -> str:
    nik = nik or ""
    return f"{nik[:7]}*********"


def _parse_datetime(value) -> Optional[datetime]:
    if isinstance(value, datetime):
        return value
    if isinstance(value, date):
        return datetime.combine(value, datetime.min.time())
    if isinstance(value, str):
        for fmt in ("%Y-%m-%d %H:%M:%S", "%Y-%m-%dT%H:%M:%S"):
            try:
                return datetime.strptime(value, fmt)
            except ValueError:
                continue
    return None


def _cekin_status(estimasi, locked: bool) -> Dict[str, Optional[str]]:
    estimasi_dt = _parse_datetime(estimasi)
    if not estimasi_dt:
        return {"cekin": True, "jam": None}

    batas_cekin = estimasi_dt - timedelta(minutes=60)
    if locked:
        allowed = datetime.now() >= batas_cekin
    else:
        allowed = True
    return {"cekin": allowed, "jam": batas_cekin.strftime("%H:%M")}


def find_reservasi(session: Session, keyword: str, from_value: Optional[str]) -> Dict:
    today = date.today()
    filters = _parse_booking_code(keyword)
    stmt = base_reservasi_query(today)

    if "kodebooking" in filters and filters["kodebooking"]:
        stmt = stmt.where(registrasi_dummy.c.kodebooking == filters["kodebooking"])
    elif "nomorantrian" in filters and filters["nomorantrian"]:
        stmt = stmt.where(registrasi_dummy.c.nomorantrian == filters["nomorantrian"])

    if from_value:
        stmt = stmt.where(registrasi_dummy.c.no_rm.isnot(None))

    result = session.execute(stmt).mappings().first()
    if not result:
        return {
            "status": 500,
            "result": "Reservasi Tidak Ditemukan, atau Cek-in tidak sesuai tanggal periksa",
        }

    reservasi = dict(result)
    patient_name = reservasi.get("nama") or find_patient_name(session, reservasi.get("no_rm"))
    if not patient_name:
        return {
            "status": 500,
            "result": "Reservasi Pasien baru harap mendatangi admisi, untuk proses registrasi awal",
        }

    poli_label = poli_name(session, reservasi.get("kode_poli"))
    cekin_info = _cekin_status(reservasi.get("estimasidilayani"), is_lock_enabled(session))

    data = {
        "nomorantrian": reservasi.get("nomorantrian"),
        "nama": patient_name,
        "no_hp": reservasi.get("no_hp"),
        "no_rujukan": reservasi.get("no_rujukan"),
        "nik": _mask_nik(reservasi.get("nik")),
        "tglperiksa": _format_date(reservasi.get("tglperiksa")),
        "status": reservasi.get("status"),
        "id": reservasi.get("id"),
        "no_rm": reservasi.get("no_rm"),
        "poli": poli_label,
        "fingerprint": {"kode": "1", "status": "OK"},
        "cekin": cekin_info["cekin"],
        "jam_dilayani": cekin_info["jam"],
    }

    return {"status": 200, "result": data}
