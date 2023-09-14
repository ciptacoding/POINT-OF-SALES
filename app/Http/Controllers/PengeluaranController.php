<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PengeluaranController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$title = 'Pengeluaran';
		$searchValue = $request->input('q');

		$pengeluaran =  Pengeluaran::query()->when($request->q, function(Builder $builder) use($request){
		$builder->where('tanggal', 'like', "%{$request->q}%")
		->orWhere('transaksi', 'like', "%{$request->q}%")
		->orWhere('keterangan', 'like', "%{$request->q}%");
		})->orderByDesc('tanggal')->paginate(10);

		$isEmpty = $pengeluaran->isEmpty();

		return view('pages.pengeluaran.index', compact('title', 'pengeluaran', 'searchValue', 'isEmpty'));
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$title = 'Stok';
		return view('pages.pengeluaran.create', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'kode_t' => 'required|unique:pengeluaran,kode_t',
			'tanggal' => 'required|date',
			'transaksi' => 'required|max:45',
			'total' => 'required',
			'keterangan' => 'required|max:45'
		]);
		Pengeluaran::create([
			'kode_t' => $request->kode_t,
			'tanggal' => $request->tanggal,
			'transaksi' => $request->transaksi,
			'total' => $request->total,
			'keterangan' => $request->keterangan
		]);

		return redirect()->route('pengeluaran.index')->with(['success' => 'Data Berhasil Disimpan']);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($kode_t)
	{
		$title = 'Pengeluaran';
		$pengeluaran = Pengeluaran::findOrFail($kode_t);

		return view('pages.pengeluaran.edit', compact('title', 'pengeluaran'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $kode_t)
	{
		$this->validate($request, [
			'kode_t' => 'required',
			'tanggal' => 'required|date',
			'transaksi' => 'required|max:45',
			'total' => 'required',
			'keterangan' => 'required|max:45'
		]);

		$pengeluaran = Pengeluaran::findOrFail($kode_t);

		$pengeluaran->kode_t = $request->kode_t;
		$pengeluaran->tanggal = $request->tanggal;
		$pengeluaran->transaksi = $request->transaksi;
		$pengeluaran->total = $request->total;
		$pengeluaran->keterangan = $request->keterangan;

		// Cek apakah kode t berubah
		if ($pengeluaran->isDirty('kode_t')) {
			// jika Kode t diubah, lakukan validasi unique
			$this->validate($request, [
					'kode_t' => 'required|unique:pengeluaran,kode_t'
			]);
		}

		$pengeluaran->save();

		return redirect()->route('pengeluaran.index')->with(['success' => 'Data Berhasil Diupdate']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $kode_t)
	{
		$pengeluaran = Pengeluaran::findOrFail($kode_t);

		$pengeluaran->delete();
		return redirect()->route('pengeluaran.index')->with(['success' => 'Data Berhasil Dihapus']);
	}
}
