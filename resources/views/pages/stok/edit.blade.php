{{-- @dd($stok) --}}
@extends('layouts.main')

@section('content')
<section class="dark:bg-gray-900 p-3 sm:p-5">
      <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
          <!-- Start coding here -->
          <div class="p-10 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

            <a href="{{ route('stok.index') }}">
              <button type="button" class="mb-5 text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Back</button>
            </a>
            
            <form action="{{ route('stok.update', $stok->kode_stok) }}" method="POST">
              @csrf
              @method('PUT')
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="kode_stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Stok</label>
                        <input name="kode_stok" type="text" id="kode_stok" value="{{ old('kode_stok', $stok->kode_stok) }}" class="@error('kode_stok') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Nama Distributor" required>
                        @error('kode_stok')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Update</button>
            </form>      

          </div>
      </div>
    </section>
  
@endsection