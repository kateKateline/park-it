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
    <table class="data">
        <caption style="caption-side: top; padding: 8px 0; font-weight: 700; color: #0f172a;">
            Rekap Transaksi (Owner) - Periode {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}
        </caption>
        <thead>
        <tr>
            <th style="width: 22%;">Tanggal</th>
            <th class="num" style="width: 18%;">Jumlah</th>
            <th class="num" style="width: 20%;">Rata durasi (menit)</th>
            <th class="num" style="width: 40%;">Pendapatan</th>
        </tr>
        </thead>
        <tbody>
        @foreach (($series ?? []) as $r)
            <tr>
                <td>{{ \Carbon\Carbon::parse($r['tanggal'])->format('d/m/Y') }}</td>
                <td class="num">{{ (int) ($r['jumlah'] ?? 0) }}</td>
                <td class="num">{{ (int) ($r['rata_durasi'] ?? 0) }}</td>
                <td class="num">Rp {{ number_format((int) ($r['pendapatan'] ?? 0), 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

