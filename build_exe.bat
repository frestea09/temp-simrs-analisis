@echo off
REM Build APM Oto Iskanda Dua into a Windows executable.
SETLOCAL

IF NOT EXIST .venv (
  echo Membuat virtualenv lokal...
  python -m venv .venv
)

CALL .venv\Scripts\activate.bat
python -m pip install --upgrade pip
pip install -r requirements.txt

pyinstaller ^
  --noconfirm ^
  --clean ^
  --onefile ^
  --windowed ^
  --name apm-oto-iskanda-dua ^
  --icon assets\logo.ico ^
  --add-data "assets;assets" ^
  --hidden-import mysql.connector.locales.eng ^
  --hidden-import mysql.connector.plugins.caching_sha2_password ^
  main.py

REM Salin konfigurasi bawaan ke folder hasil build agar mudah disesuaikan.
copy /Y app\user_config.json dist\user_config.json >nul
echo.
echo Build selesai. File exe ada di dist\apm-oto-iskanda-dua.exe
ENDLOCAL
