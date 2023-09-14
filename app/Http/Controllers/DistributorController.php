<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Database\Eloquent\Builder;	

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	public function index(Request $request)
	{
		$title = 'Distributor';
		$searchValue = $request->input('q');

		$distributor =  Distributor::query()->when($request->q, function(Builder $builder) use($request){
		$builder->where('nama', 'like', "%{$request->q}%")
		->orWhere('alamat', 'like', "%{$request->q}%");
		})->orderBy('nama')->paginate(10);

		$isEmpty = $distributor->isEmpty();

		return view('pages.distributor.index', compact('title', 'distributor', 'searchValue', 'isEmpty'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$title = 'Distributor';
		return view('pages.distributor.create', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		$this->validate($request, [
			'nama' => 'required|max:45',
			'alamat' => 'required|max:45',
			'no_tlp' => 'required|max:45',
		]);
		Distributor::create([
			'nama' => $request->nama,
			'alamat' => $request->alamat,
			'no_tlp' => $request->no_tlp
		]);

		return redirect()->route('distributor.index')->with(['success' => 'Data Berhasil Disimpan']);
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
	public function edit(string $id): View
	{
		$title = 'Distributor';
		$distributor = Distributor::findOrFail($id);

		return view('pages.distributor.edit', compact('title', 'distributor'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id): RedirectResponse
	{
		$this->validate($request, [
			'nama' => 'required|max:45',
			'alamat' => 'required|max:45',
			'no_tlp' => 'required|max:45',
		]);

		$distributor = Distributor::findOrFail($id);

		$distributor->update([
			'nama' => $request->nama,
			'alamat' => $request->alamat,
			'no_tlp' => $request->no_tlp
		]);

		return redirect()->route('distributor.index')->with(['success' => 'Data Berhasil Diupdate']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		$distributor = Distributor::findOrFail($id);

		$distributor->delete();
		return redirect()->route('distributor.index')->with(['success' => 'Data Berhasil Dihapus']);
	}
}
