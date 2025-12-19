import os
from typing import Iterator, Optional

from sqlalchemy import (
    Column,
    Date,
    DateTime,
    Integer,
    MetaData,
    String,
    Table,
    create_engine,
    func,
    select,
)
from sqlalchemy.engine import Engine
from sqlalchemy.orm import Session, sessionmaker

# Re-use the same environment variables as the Laravel app so the services
# can point at the same database without duplicating configuration.
DB_HOST = os.getenv("DB_HOST", "127.0.0.1")
DB_PORT = os.getenv("DB_PORT", "3306")
DB_NAME = os.getenv("DB_DATABASE", "rsud_otista")
DB_USER = os.getenv("DB_USERNAME", "root")
DB_PASSWORD = os.getenv("DB_PASSWORD", "")


def build_database_url() -> str:
    return (
        f"mysql+pymysql://{DB_USER}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_NAME}"
    )


engine: Engine = create_engine(build_database_url(), pool_pre_ping=True, future=True)
SessionLocal = sessionmaker(bind=engine, autoflush=False, autocommit=False, future=True)
metadata = MetaData()

# Minimal table definitions for the reservation feature.
registrasi_dummy = Table(
    "registrasis_dummy",
    metadata,
    Column("id", Integer, primary_key=True),
    Column("registrasi_id", Integer),
    Column("nomorkartu", String(50)),
    Column("nomorantrian", String(100)),
    Column("kodebooking", String(100)),
    Column("nik", String(100)),
    Column("no_rm", String(50)),
    Column("nama", String(255)),
    Column("no_hp", String(50)),
    Column("no_rujukan", String(100)),
    Column("tglperiksa", Date),
    Column("kode_poli", String(25)),
    Column("status", String(50)),
    Column("jenisdaftar", String(50)),
    Column("jenis_registrasi", String(50)),
    Column("estimasidilayani", DateTime),
    Column("dokter_id", Integer),
    Column("kode_cara_bayar", String(10)),
    Column("created_at", DateTime),
    Column("updated_at", DateTime),
    extend_existing=True,
)

pasiens = Table(
    "pasiens",
    metadata,
    Column("id", Integer, primary_key=True),
    Column("no_rm", String(50)),
    Column("nama", String(255)),
    extend_existing=True,
)

polis = Table(
    "polis",
    metadata,
    Column("id", Integer, primary_key=True),
    Column("nama", String(255)),
    Column("bpjs", String(25)),
    extend_existing=True,
)

conf_consid = Table(
    "conf_consid",
    metadata,
    Column("id", Integer, primary_key=True),
    Column("consid", String(100)),
    Column("aktif", String(5)),
    extend_existing=True,
)


def get_session() -> Iterator[Session]:
    session: Session = SessionLocal()
    try:
        yield session
    finally:
        session.close()


def is_lock_enabled(session: Session) -> bool:
    record = session.execute(
        select(conf_consid.c.aktif).where(conf_consid.c.consid == "lock_apm")
    ).scalar_one_or_none()
    return bool(record)


def poli_name(session: Session, kode_poli: Optional[str]) -> str:
    if not kode_poli:
        return ""
    name = session.execute(
        select(polis.c.nama).where(polis.c.bpjs == kode_poli)
    ).scalar_one_or_none()
    return (name or kode_poli or "").upper()


def find_patient_name(session: Session, no_rm: Optional[str]) -> Optional[str]:
    if not no_rm:
        return None
    return session.execute(
        select(pasiens.c.nama).where(pasiens.c.no_rm == no_rm)
    ).scalar_one_or_none()


def base_reservasi_query(today):
    return (
        select(registrasi_dummy)
        .where(registrasi_dummy.c.jenis_registrasi == "antrian")
        .where(registrasi_dummy.c.jenisdaftar == "fkrtl")
        .where(func.date(registrasi_dummy.c.tglperiksa) == today)
    )
