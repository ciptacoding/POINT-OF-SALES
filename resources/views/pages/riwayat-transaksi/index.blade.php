@extends('layouts.main')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
  <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
    <!-- Start coding here -->
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

      {{-- bagian searching bar dan button add product --}}
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/2">
          <form action="{{ route('riwayat-transaksi.index') }}" method="get" class="flex items-center">
            <label for="search" class="sr-only">Search</label>
            <div class="relative w-full">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                  viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <input type="text" id="search" name="q" value="{{ old('q') ?? request()->q }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                placeholder="Cari nama pelanggan">
            </div>
            <button type="submit"
              class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br  font-medium rounded-md text-sm px-5 py-2 text-center m-2">Cari</button>
          </form>
        </div>
      </div>
      {{-- bagian searching bar dan button add product --}}

      {{-- Table Body start --}}
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Kode Transaksi</th>
              <th scope="col" class="px-4 py-3">Tanggal</th>
              <th scope="col" class="px-4 py-3">Total Bayar</th>
              <th scope="col" class="px-4 py-3">Bayar</th>
              <th scope="col" class="px-4 py-3">Kembali</th>
              <th scope="col" class="px-4 py-3 flex items-center justify-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($transaksi as $item)
            <tr class="border-b dark:border-gray-700">
              <td class="px-4 py-3">{{ $item->kode_transaksi }}</td>
              <td class="px-4 py-3">{{ date('d-m-Y', strtotime($item->tanggal)); }}</td>
              <td class="px-4 py-3">Rp. {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
              <td class="px-4 py-3">Rp. {{ number_format($item->bayar, 0, ',', '.') }}</td>
              <td class="px-4 py-3">Rp. {{ number_format($item->kembali, 0, ',', '.') }}</td>
              <td class="px-4 py-3">
                <a href="{{ route('riwayat-transaksi.show', $item->kode_transaksi) }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                  </svg>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td class="px-4 py-3" colspan="6">Belum ada Riwayat Transaksi</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{-- Table Body end --}}

    </div>
  </div>
</section>
@endsection