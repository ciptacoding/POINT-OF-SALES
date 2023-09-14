@extends('layouts.main')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/datepicker.min.js"></script>
@endpush

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
  <div class="mx-auto max-w-screen-xl px-4 lg:px-4">
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

      <div class="flex flex-col md:flex-row justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 items-end">
        <div class="w-full">
          <form class="flex gap-x-2 items-end w-full formTambahTransaksi"
            action="{{ route('laporan-keuangan.index') }}">

            <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                  </svg>
                </div>
                <input name="start" type="text" id="tanggal-awal"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Pilih tanggal mulai" autocomplete="off">
              </div>
              <span class="mx-4 text-gray-500">sampai</span>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                  </svg>
                </div>
                <input name="end" type="text" id="tanggal-akhir"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Pilih tanggal akhir" autocomplete="off">
              </div>
            </div>

            <button type="submit"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cari</button>

          </form>
        </div>
      </div>

      <div class="px-4 mb-4">
        <p>Filter: {{ request('start') }} - {{ request('end') }}</p>
      </div>

      <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
          <div class="flex">
            <div class="w-full">

              {{-- Table Body start --}}
              <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                      <th scope="col" class="px-4 py-3">No</th>
                      <th scope="col" class="px-4 py-3">Tanggal</th>
                      <th scope="col" class="px-4 py-3">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($transaksi as $item)
                    <tr class="border-b dark:border-gray-700">
                      <td class="px-4 py-3">{{ $firstItemTransaksi + $loop->index }}</td>
                      <td class="px-4 py-3">{{ $item->tanggal }}</td>
                      <td class="px-4 py-3">@rupiah($item->total_sum)</td>
                    </tr>
                    @empty
                    <tr class="border-b dark:border-gray-700">
                      <td class="px-4 py-3" colspan="3">Belum ada Transaksi</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              {{-- Table Body end --}}

            </div>
          </div>
          <div class="flex">
            <div class="w-full">

              {{-- Table Body start --}}
              <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                      <th scope="col" class="px-4 py-3">No</th>
                      <th scope="col" class="px-4 py-3">Tanggal</th>
                      <th scope="col" class="px-4 py-3">Total</th>
                      <th scope="col" class="px-4 py-3">Transaksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($pengeluaran as $item2)
                    <tr class="border-b dark:border-gray-700">
                      <td class="px-4 py-3">{{ $firstItemPengeluaran + $loop->index }}</td>
                      <td class="px-4 py-3">{{ $item2->tanggal }}</td>
                      <td class="px-4 py-3">@rupiah($item2->total)</td>
                      <td class="px-4 py-3">{{ $item2->transaksi }}</td>
                    </tr>
                    @empty
                    <tr class="border-b dark:border-gray-700">
                      <td class="px-4 py-3" colspan="3">Belum ada Pengeluaran</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              {{-- Table Body end --}}

            </div>
          </div>
        </div>
      </div>

      @if ($transaksi)
      <div class="py-4 px-4">
        {{ $transaksi->links('vendor.pagination.tailwind') }}
      </div>
      @endif

      @if ($pengeluaran)
      <div class="py-4 px-4">
        {{ $pengeluaran->links('vendor.pagination.tailwind') }}
      </div>
      @endif

      <div class="flex p-4">
        <div class="w-full md:w-1/2">
          <div class="flex flex-col gap-x-2 items-end gap-y-3">
            <div class="flex items-center gap-x-3">
              <label for="total_bayar" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Total
                Transaksi</label>
              <div class="flex">
                <span
                  class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                  Rp.
                </span>
                <input type="text" id="total_bayar" name="total_bayar"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-none rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  readonly value="{{ number_format($total,0,',','.') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/2">
          <div class="flex flex-col gap-x-2 items-end gap-y-3">
            <div class="flex items-center gap-x-3">
              <label for="total_bayar" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Total
                Pengularan</label>
              <div class="flex">
                <span
                  class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                  Rp.
                </span>
                <input type="text" id="total_bayar" name="total_bayar"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-none rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  readonly value="{{ number_format($total2,0,',','.') }}">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection