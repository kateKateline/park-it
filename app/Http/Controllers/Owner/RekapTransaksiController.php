<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RekapTransaksiController extends Controller
{
    private function buildSeries(Carbon $fromDate, Carbon $toDate): array
    {
        $rekapRaw = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$fromDate, $toDate])
            ->selectRaw('DATE(waktu_keluar) as tanggal')
            ->selectRaw('COUNT(*) as jumlah')
            ->selectRaw('COALESCE(SUM(total_bayar), 0) as pendapatan')
            ->selectRaw('AVG(durasi_menit) as rata_durasi')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $map = $rekapRaw->keyBy('tanggal');
        $series = [];

        $cursor = $fromDate->copy()->startOfDay();
        $toCursor = $toDate->copy()->startOfDay();
        while ($cursor->lte($toCursor)) {
            $d = $cursor->toDateString();
            $row = $map->get($d);
            $series[] = [
                'tanggal' => $d,
                'jumlah' => (int) ($row->jumlah ?? 0),
                'pendapatan' => (int) ($row->pendapatan ?? 0),
                'rata_durasi' => (int) round((float) ($row->rata_durasi ?? 0)),
            ];
            $cursor->addDay();
        }

        return $series;
    }

    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $fromDate = $from ? Carbon::parse($from)->startOfDay() : Carbon::now()->subDays(7)->startOfDay();
        $toDate = $to ? Carbon::parse($to)->endOfDay() : Carbon::now()->endOfDay();

        $series = $this->buildSeries($fromDate, $toDate);
        $rekap = array_reverse($series); // tampilkan terbaru di atas (desc)

        $total = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$fromDate, $toDate])
            ->sum('total_bayar');

        return view('owner.rekap.index', [
            'user' => $request->user(),
            'rekap' => $rekap,
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
            'total' => $total,
        ]);
    }

    public function pdf(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $fromDate = $from ? Carbon::parse($from)->startOfDay() : Carbon::now()->subDays(7)->startOfDay();
        $toDate = $to ? Carbon::parse($to)->endOfDay() : Carbon::now()->endOfDay();

        $series = $this->buildSeries($fromDate, $toDate);

        $total = array_reduce($series, fn ($acc, $r) => $acc + (int) ($r['pendapatan'] ?? 0), 0);
        $jumlah = array_reduce($series, fn ($acc, $r) => $acc + (int) ($r['jumlah'] ?? 0), 0);
        $avgDurasi = $jumlah > 0
            ? (int) round(array_reduce($series, fn ($acc, $r) => $acc + ((int) ($r['jumlah'] ?? 0)) * ((int) ($r['rata_durasi'] ?? 0)), 0) / $jumlah)
            : 0;

        $pdf = Pdf::loadView('owner.rekap.pdf', [
            'owner' => $request->user(),
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
            'series' => $series,
            'summary' => [
                'jumlah' => $jumlah,
                'pendapatan' => $total,
                'rata_durasi' => $avgDurasi,
            ],
            'generated_at' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'portrait');

        $filename = 'rekap-owner-' . $fromDate->toDateString() . '_to_' . $toDate->toDateString() . '.pdf';

        if ((string) $request->query('download', '') === '1') {
            return $pdf->download($filename);
        }

        // Default: preview (inline) via PDF viewer browser.
        return $pdf->stream($filename);
    }

    public function show(string $date, Request $request)
    {
        $tanggal = Carbon::parse($date)->toDateString();

        $items = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->where('status', 'selesai')
            ->whereDate('waktu_keluar', $tanggal)
            ->orderBy('waktu_keluar', 'desc')
            ->get();

        $summary = [
            'jumlah' => $items->count(),
            'pendapatan' => $items->sum('total_bayar'),
            'rata_durasi' => (int) round($items->avg('durasi_menit')),
        ];

        return view('owner.rekap.show', [
            'user' => $request->user(),
            'tanggal' => $tanggal,
            'items' => $items,
            'summary' => $summary,
        ]);
    }
}
