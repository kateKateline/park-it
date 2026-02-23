# Detection API (untuk Python YOLO Service)

Endpoint yang dipanggil oleh Python saat kendaraan terdeteksi:

- **URL:** `http://park-it.test/api/detection`
- **Method:** `POST`
- **Content-Type:** `application/json`

## Di Python

**Penting:** variabel `LARAVEL_URL` harus **hanya berisi URL**, tanpa kata "POST":

```python
# Benar
LARAVEL_URL = "http://park-it.test/api/detection"
requests.post(LARAVEL_URL, json=data, timeout=3)

# Salah (jangan pakai "POST " di depan URL)
# LARAVEL_URL = "POST http://park-it.test/api/detection"  # <- ini penyebab gagal
```

## Konfigurasi via environment (opsional)

Di project Python, buat file `.env`:

```env
LARAVEL_URL=http://park-it.test/api/detection
WEBCAM_URL=http://localhost:8080/video
```

Lalu di Python, baca dengan `os.environ.get("LARAVEL_URL")` atau pakai `python-dotenv`:

```python
from dotenv import load_dotenv
load_dotenv()
LARAVEL_URL = os.environ.get("LARAVEL_URL", "http://park-it.test/api/detection")
```

## Test dari Windows (PowerShell / CMD)

Satu baris (tanpa backslash):

```powershell
curl -X POST http://park-it.test/api/detection -H "Content-Type: application/json" -d "{\"vehicle_type\": \"car\", \"color\": \"hitam\", \"confidence\": 0.87, \"timestamp\": \"2026-02-22 14:00:00\"}"
```

Atau simpan JSON di file `payload.json` lalu:

```powershell
curl -X POST http://park-it.test/api/detection -H "Content-Type: application/json" -d "@payload.json"
```
