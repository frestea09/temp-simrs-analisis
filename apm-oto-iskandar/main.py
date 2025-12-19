from datetime import date
from pathlib import Path

from fastapi import Depends, FastAPI, Form, Request
from fastapi.responses import HTMLResponse, JSONResponse
from fastapi.templating import Jinja2Templates
from sqlalchemy.orm import Session

from apm_oto_iskandar.db import get_session
from apm_oto_iskandar.reservasi import find_reservasi

BASE_DIR = Path(__file__).resolve().parent
templates = Jinja2Templates(directory=str(BASE_DIR / "templates"))

app = FastAPI(title="APM Oto Iskandar")


@app.get("/", response_class=HTMLResponse)
async def home(request: Request) -> HTMLResponse:
    return templates.TemplateResponse("home.html", {"request": request})


@app.get("/reservasi/cek", response_class=HTMLResponse)
async def cek_reservasi_page(request: Request) -> HTMLResponse:
    return templates.TemplateResponse(
        "cek_reservasi.html",
        {"request": request, "mode": "kunjungan", "today_prefix": date.today().strftime("%d%m%Y")},
    )


@app.get("/reservasi/cek-kontrol", response_class=HTMLResponse)
async def cek_reservasi_kontrol_page(request: Request) -> HTMLResponse:
    return templates.TemplateResponse(
        "cek_reservasi.html",
        {"request": request, "mode": "kontrol", "today_prefix": date.today().strftime("%d%m%Y")},
    )


@app.post("/reservasi/cek")
async def cek_reservasi(
    request: Request,
    keyword: str = Form(...),
    from_value: str = Form(None, alias="from"),
    session: Session = Depends(get_session),
):
    payload = find_reservasi(session, keyword, from_value)
    return JSONResponse(payload)
