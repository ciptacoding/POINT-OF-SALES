@extends('layouts.main')
{{-- @dd($request->jumlah) --}}
@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2();
    });
  </script>
@endpush

@section('content')

<section class="dark:bg-gray-900 p-3 sm:p-5">
      <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
          <!-- Start coding here -->
          <div class="p-10 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

            <a href="{{ route('barang.index') }}">
              <button type="button" class="mb-5 text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Back</button>
            </a>
            
            <form action="{{ route('barang.store') }}" method="POST">
              @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Barang</label>
                        <input name="kode_barang" type="text" id="kode_barang" value="{{ old('kode_barang') }}" class="@error('kode_barang') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Kode Barang" required>
                        @error('kode_barang')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                        <input name="nama_barang" type="text" id="nama_barang" value="{{ old('nama_barang') }}" class="@error('nama_barang') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Nama Barang" required>
                        @error('nama_barang')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                        <input name="harga" type="number" id="harga" value="{{ old('harga') }}" class="@error('harga') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Harga" required>
                        @error('harga')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>  
                    <div>
                        <label for="kode_stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Stok</label>
                        <select id="kode_stok" class="select2 @error('kode_stok') border-red-500 @enderror" name="kode_stok">
                          <option value="{{ old('kode_stok') }}" selected>
                            @if (old('kode_stok'))
                              {{ old('kode_stok') }}
                            @else
                              Cari atau pilih kode stok
                            @endif
                          </option>
                          @foreach ($stok as $stk)
                            <option value="{{ $stk->kode_stok }}">{{ $stk->kode_stok }}</option>
                          @endforeach
                        </select>
                        @error('kode_stok')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="hpp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">HPP</label>
                        <input name="hpp" type="number" id="hpp" value="{{ old('hpp') }}" class="@error('hpp') border-red-500 @enderror bg-gray-50 border  text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan HPP" required>
                        @error('hpp')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
						  <div>
							<label for="jumlah_stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Stok</label>
							<input name="jumlah_stok" type="number" id="jumlah_stok" value="{{ old('jumlah_stok') }}" class="@error('jumlah_stok') border-red-500 	@enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-	gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 	placeholder="Masukan Jumlah Stok" required>
							@error('jumlah_stok')
								<p class="text-red-500 text-xs">{{ $message }}</p>
							@enderror
						</div>
                </div>
                <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Submit</button>
            </form>      

          </div>
      </div>
    </section>
  
@endsection