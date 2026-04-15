<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekap Transaksi</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { font-size: 12px; color: #0f172a; padding: 10px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #e2e8f0; padding: 8px; }
        table.data th { background: #f8fafc; text-align: left; font-size: 11px; color: #334155; }
        table.data td.num, table.data th.num { text-align: right; }
        tbody tr:nth-child(odd) { background: #ffffff; }
        tbody tr:nth-child(even) { background: #f8fafc; }
    </style>
</head>
<body>
    <div style="margin-bottom: 20px;">
        <h2 style="margin: 0; color: #0f172a;">Laporan Rekap Transaksi</h2>
        <p style="margin: 4px 0; color: #64748b; font-size: 11px;">
            Periode: {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} @if($from !== $to) s/d {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }} @endif
        </p>
    </div>

    @if($items)
        {{-- Tampilan Detail (untuk rekap harian tunggal) --}}
        <div style="margin-bottom: 20px;">
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="width: 33%;">
                        <div style="font-size: 10px; color: #64748b;">Jumlah Transaksi</div>
                        <div style="font-size: 16px; font-weight: 700;">{{ $summary['jumlah'] }}</div>
                    </td>
                    <td style="width: 33%;">
                        <div style="font-size: 10px; color: #64748b;">Total Pendapatan</div>
                        <div style="font-size: 16px; font-weight: 700;">Rp {{ number_format($summary['pendapatan'], 0, ',', '.') }}</div>
                    </td>
                    <td style="width: 33%;">
                        <div style="font-size: 10px; color: #64748b;">Rata-rata Durasi</div>
                        <div style="font-size: 16px; font-weight: 700;">{{ \App\Support\DurationDisplay::fromMinutes($summary['rata_durasi']) }}</div>
                    </td>
                </tr>
            </table>

            <table class="data">
                <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kode</th>
                    <th style="width: 12%;">Plat</th>
                    <th style="width: 10%;">Jenis</th>
                    <th style="width: 18%;">Masuk</th>
                    <th style="width: 18%;">Keluar</th>
                    <th style="width: 12%;">Durasi</th>
                    <th class="num" style="width: 10%;">Biaya</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-family: monospace; font-size: 10px;">{{ $t->barcode }}</td>
                        <td style="font-weight: 700;">{{ $t->kendaraan?->plat_nomor }}</td>
                        <td style="text-transform: capitalize;">{{ $t->kendaraan?->jenis_kendaraan }}</td>
                        <td>{{ $t->waktu_masuk?->format('d/m/Y H:i') }}</td>
                        <td>{{ $t->waktu_keluar?->format('d/m/Y H:i') }}</td>
                        <td>{{ \App\Support\DurationDisplay::fromMinutes($t->durasi_menit) }}</td>
                        <td class="num">Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- Tampilan Ringkasan (untuk rentang tanggal) --}}
        <table class="data">
            <thead>
            <tr>
                <th style="width: 20%;">Tanggal</th>
                <th class="num" style="width: 14%;">Jumlah</th>
                <th class="num" style="width: 26%;">Rata-rata durasi</th>
                <th class="num" style="width: 40%;">Pendapatan</th>
            </tr>
            </thead>
            <tbody>
            @foreach (($series ?? []) as $r)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($r['tanggal'])->format('d/m/Y') }}</td>
                    <td class="num">{{ (int) ($r['jumlah'] ?? 0) }}</td>
                    <td class="num">{{ \App\Support\DurationDisplay::fromMinutes($r['rata_durasi'] ?? 0) }}</td>
                    <td class="num">Rp {{ number_format((int) ($r['pendapatan'] ?? 0), 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>TOTAL</td>
                    <td class="num">{{ $summary['jumlah'] }}</td>
                    <td class="num">{{ \App\Support\DurationDisplay::fromMinutes($summary['rata_durasi']) }} (Avg)</td>
                    <td class="num">Rp {{ number_format($summary['pendapatan'], 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif

    <div style="margin-top: 30px; text-align: right; font-size: 10px; color: #94a3b8;">
        Dicetak pada: {{ $generated_at }}
    </div>
</body>
</html>

