<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$title = 'Barang';
		$searchValue = $request->input('q');

		$barang =  Barang::query()->when($request->q, function(Builder $builder) use($request){
			$builder->where('nama_barang', 'like', "%{$request->q}%")
			->orWhere('kode_stok', 'like', "%{$request->q}%");
		})->orderBy('nama_barang')->paginate(10);

		$isEmpty = $barang->isEmpty();

		return view('pages.barang.index', compact('title', 'barang', 'searchValue', 'isEmpty'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$title = 'Barang';
		$stok = Stok::all();
		return view('pages.barang.create', compact('title', 'stok'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		// @dd($request->kode_stok);
		$this->validate($request, [
			'kode_barang' => 'required|max:50|unique:barang,kode_barang',
			'nama_barang' => 'required|max:45',
			'harga' => 'required|integer',
			'kode_stok' => 'required|max:45',
			'hpp' => 'required|integer',
			'jumlah_stok' => 'required|integer' 
		]);

		Barang::create([
			'kode_barang' => $request->kode_barang,
			'nama_barang' => $request->nama_barang,
			'harga' => $request->harga,
			'kode_stok' => $request->kode_stok,
			'hpp' => $request->hpp
		]);

		$stok = Stok::findOrFail($request->kode_stok);
		$stok->jumlah_stok = $request->jumlah_stok;
		$stok->save();

		return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
	public function edit(string $kode_barang)
	{
		$title = 'Barang';
		$barang = Barang::findOrFail($kode_barang);
		$stok = Stok::all();
		$jml_stok = Stok::find($barang->kode_stok);
		if($jml_stok == null){
			$barang;
		}
		return view('pages.barang.edit', compact('title', 'barang', 'stok', 'jml_stok'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $kode_barang)
	{
		$this->validate($request, [
			'kode_barang' => 'required|max:50',
			'nama_barang' => 'required|max:45',
			'harga' => 'required|integer',
			'kode_stok' => 'required|max:45',
			'hpp' => 'required|integer',
			'jumlah_stok' => 'required|integer'
		]);

		$barang = Barang::findOrFail($kode_barang);

		$barang->kode_barang = $request->kode_barang;
		$barang->nama_barang = $request->nama_barang;
		$barang->harga = $request->harga;
		$barang->kode_stok = $request->kode_stok;
		$barang->hpp = $request->hpp;

		// Cek apakah kode stok berubah
		if ($barang->isDirty('kode_barang')) {
			// Kode stok diubah, lakukan validasi unique
			$this->validate($request, [
					'kode_barang' => 'required|max:50|unique:barang,kode_barang'
			]);
		}
		$barang->save();

		$stok_jml = Stok::find($barang->kode_stok);
		if($stok_jml == null){
			$new_stok = new Stok;
			$new_stok->kode_stok = $barang->kode_stok;
			$new_stok->jumlah_stok = $request->jumlah_stok;
			$new_stok->save();
		}else{
			$stok_jml->jumlah_stok = $request->jumlah_stok;
			$stok_jml->save();
		}

		return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diupdate']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $kode_barang)
	{
		$barang = Barang::findOrFail($kode_barang);

		$barang->delete();
		return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus']);
	}
}
