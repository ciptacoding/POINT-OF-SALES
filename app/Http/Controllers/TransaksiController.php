<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $title = 'Transaksi';
        $barang = Barang::all();

        return view('pages.transaksi.index', compact('title', 'barang'));
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
        if (!$request->kode_barang) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal ditambahkan. Mohon isi nama barang',
            ], 400);
        }

        $barang = Barang::find($request->kode_barang);

        if (!$barang) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal ditambahkan. Kode barang tidak ditemukan',
            ], 400);
        }

        $data = $request->all();
        $data['nama_barang'] = $barang->nama_barang;
        $data['harga'] = $barang->harga;
        $data['total'] = $request->jumlah * $barang->harga;

        $data['hpp'] = $barang->hpp;
        $data['totalhpp'] = $barang->hpp * $request->jumlah;
        $data['diskon'] = 0;
        $data['kasir'] = 'admin2';

        $transaksi = Transaksi::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil ditambahkan',
            'data' => [
                'transactionId' => $transaksi->ID
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'transaksi' => $transaksi,
            ],
        ], 200);
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
        if (!$request->kode_barang) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal diupdate. Mohon isi nama barang',
            ], 400);
        }

        $barang = Barang::find($request->kode_barang);

        if (!$barang) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal diupdate. Nama barang tidak ditemukan',
            ], 400);
        }

        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal diupdate. ID transaksi tidak ditemukan',
            ], 404);
        }

        $data = $request->all();
        $data['nama_barang'] = $barang->nama_barang;
        $data['harga'] = $barang->harga;
        $data['total'] = $request->jumlah * $barang->harga;
        $data['hpp'] = $barang->hpp;
        $data['totalhpp'] = $barang->hpp * $request->jumlah;
        $data['diskon'] = 0;
        $data['kasir'] = 'admin2';

        $transaksi->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil diupdate'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal dihapus. Id tidak ditemukan',
            ], 404);
        }

        $transaksi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dihapus',
        ], 200);
    }

    public function getAll()
    {
        $transaksi = Transaksi::where('bayar', NULL)->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'transaksi' => $transaksi,
            ],
        ], 200);
    }

    public function saveTransaction(Request $request)
    {
        if ($request->jumlah_bayar < 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Transaksi gagal disimpan. Mohon isi inputan bayar dengan benar',
            ], 400);
        }

        $transaksi = $request->all();
        $transaksi['kode_transaksi'] = random_int(100000000000, 999999999999);
        $transaksi['tanggal'] = Carbon::now()->toDateTimeString();
        Transaksi::where('bayar', NULL)->update($transaksi);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil disimpan',
            'kode_transaksi' => $transaksi['kode_transaksi'],
        ], 200);
    }

    public function list()
    {
        $title = 'Data Transaksi';
        $total = $margin = 0;
        $transaksi = $daftarTransaksi = $firstItem = [];
        $start = request('start');
        $end = request('end');

        if (request('start')) {
            $daftarTransaksi = Transaksi::whereBetween('tanggal', [$start, $end])->get();
            foreach ($daftarTransaksi as $item) {
                $total += $item->total;
                $margin += $item->totalhpp;
            }

            $transaksi = Transaksi::whereBetween('tanggal', [$start, $end])->paginate(10)->withQueryString();
            $firstItem = $transaksi->firstItem();
        }

        return view('pages.transaksi.list', compact('title', 'transaksi', 'firstItem', 'total', 'margin'));
    }
}
