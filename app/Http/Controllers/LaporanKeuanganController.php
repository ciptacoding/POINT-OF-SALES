<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $title = 'Data Keuangan';
        $total = $total2 = 0;
        $daftarTransaksi = [];
        $transaksi = $pengeluaran = $firstItemTransaksi = $firstItemPengeluaran = [];
        $start = request('start');
        $end = request('end');

        if (request('start')) {
            $daftarTransaksi = Transaksi::select('tanggal', DB::raw('SUM(total) as total_sum'))
                ->whereBetween('tanggal', [$start, $end])
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'asc')
                ->get();
            foreach ($daftarTransaksi as $item) {
                $total += $item->total_sum;
            }

            $transaksi = Transaksi::select('tanggal', DB::raw('SUM(total) as total_sum'))
                ->whereBetween('tanggal', [$start, $end])
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'asc')
                ->paginate(10)
                ->withQueryString();
            $firstItemTransaksi = $transaksi->firstItem();


            $daftarPengeluaran = Pengeluaran::select('tanggal', 'total', 'transaksi')
                ->whereBetween('tanggal', [$start, $end])
                ->orderBy('tanggal', 'asc')
                ->get();
            foreach ($daftarPengeluaran as $item2) {
                $total2 += $item2->total;
            }
            $pengeluaran = Pengeluaran::select('tanggal', 'total', 'transaksi')
                ->whereBetween('tanggal', [$start, $end])
                ->orderBy('tanggal', 'asc')
                ->paginate(10)
                ->withQueryString();
            $firstItemPengeluaran = $pengeluaran->firstItem();
        }

        return view('pages.keuangan.index', compact('title', 'transaksi', 'pengeluaran', 'firstItemTransaksi', 'firstItemPengeluaran', 'total', 'total2'));
    }
}
