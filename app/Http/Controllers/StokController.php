<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StokController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$title = 'Stok';
		$searchValue = $request->input('q');

		$stok =  Stok::query()->when($request->q, function(Builder $builder) use($request){
		$builder->where('kode_stok', 'like', "%{$request->q}%");
		})->orderBy('kode_stok')->paginate(10);

		$isEmpty = $stok->isEmpty();


		return view('pages.stok.index', compact('title', 'stok', 'searchValue', 'isEmpty'));
	}

	

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$title = 'Stok';
		return view('pages.stok.create', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'kode_stok' => 'required|max:45|unique:stok,kode_stok',
		]);
		Stok::create([
			'kode_stok' => $request->kode_stok,
		]);

		return redirect()->route('stok.index')->with(['success' => 'Data Berhasil Disimpan']);
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
	public function edit($kode_stok)
	{
		$title = 'Stok';
		$stok = Stok::findOrFail($kode_stok);

		return view('pages.stok.edit', compact('title', 'stok'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $kode_stok)
	{
		$this->validate($request, [
			'kode_stok' => 'required|max:45',
		]);

		$stok = Stok::findOrFail($kode_stok);

		$stok->kode_stok = $request->kode_stok;

		// Cek apakah kode stok berubah
		if ($stok->isDirty('kode_stok')) {
			// Kode stok diubah, lakukan validasi unique
			$this->validate($request, [
					'kode_stok' => 'required|max:45|unique:stok,kode_stok'
			]);
		}

		$stok->save();

		return redirect()->route('stok.index')->with(['success' => 'Data Berhasil Diupdate']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $kode_stok)
	{
		$stok = Stok::findOrFail($kode_stok);

		$stok->delete();
		return redirect()->route('stok.index')->with(['success' => 'Data Berhasil Dihapus']);
	}
}
