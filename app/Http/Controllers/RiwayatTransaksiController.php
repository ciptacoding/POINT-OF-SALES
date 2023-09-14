<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Riwayat Transaksi';
        $transaksi = [];

        if ($request->q) {
            $sql = "SELECT kode_transaksi, tanggal, SUM(total) as total_bayar, bayar, kembali
                    FROM `transaksi`
                    WHERE nama_pelanggan LIKE :nama_pelanggan
                    GROUP BY kode_transaksi, tanggal, bayar, kembali
                    ORDER BY tanggal DESC
                    LIMIT 5";

            $transaksi = DB::select($sql, ['nama_pelanggan' => "%$request->q%"]);
        }

        return view('pages.riwayat-transaksi.index', compact('title', 'transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $title = 'Riwayat Transaksi';
        $transaksi = Transaksi::where('kode_transaksi', $id)->get();

        return view('pages.riwayat-transaksi.detail', compact('title', 'transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
