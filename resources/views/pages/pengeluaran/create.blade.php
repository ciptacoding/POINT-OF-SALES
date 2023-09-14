@extends('layouts.main')

@section('content')

<section class="dark:bg-gray-900 p-3 sm:p-5">
      <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
          <!-- Start coding here -->
          <div class="p-10 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

            <a href="{{ route('pengeluaran.index') }}">
              <button type="button" class="mb-5 text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Back</button>
            </a>
            
            <form action="{{ route('pengeluaran.store') }}" method="POST">
              @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="kode_t" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Transaksi</label>
                        <input name="kode_t" type="number" id="kode_t" value="{{ old('kode_t') }}" class="@error('kode_t') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Kode Transaksi" required>
                        @error('kode_t')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                        <input name="tanggal" type="date" id="tanggal" value="{{ old('tanggal') }}" class="@error('tanggal') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Tanggal" required>
                        @error('tanggal')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="transaksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaksi</label>
                        <input name="transaksi" type="text" id="transaksi" value="{{ old('transaksi') }}" class="@error('transaksi') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Transaksi" required>
                        @error('transaksi')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total</label>
                        <input name="total" type="number" id="total" value="{{ old('total') }}" class="@error('total') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Total" required>
                        @error('total')
                          <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <input name="keterangan" type="text" id="keterangan" value="{{ old('keterangan') }}" class="@error('keterangan') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan Keterangan" required>
                        @error('keterangan')
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