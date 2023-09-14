<div class="overflow-x-auto">
  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    @if ($isEmpty)
    <p class="w-full text-center mt-4">No Data Found!</span>
      @else
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-4 py-3">Kode Transaksi</th>
          <th scope="col" class="px-4 py-3">Tanggal</th>
          <th scope="col" class="px-4 py-3">Transaksi</th>
          <th scope="col" class="px-4 py-3">Total</th>
          <th scope="col" class="px-4 py-3">Keterangan</th>
          <th scope="col" class="px-4 py-3 flex items-center justify-center">Action</th>
        </tr>
      </thead>
      <tbody class="allData">
        @foreach ($pengeluaran as $item)
        <tr class="border-b dark:border-gray-700">
          <td class="px-4 py-3">{{ $item->kode_t }}</td>
          <td class="px-4 py-3">{{ $item->tanggal }}</td>
          <td class="px-4 py-3">{{ $item->transaksi }}</td>
          <td class="px-4 py-3">{{ $item->total }}</td>
          <td class="px-4 py-3">{{ $item->keterangan }}</td>
          <td>
            <form class="px-4 py-3 flex items-center justify-center gap-4"
              onsubmit="return confirm('Apakah Anda Yakin?');"
              action="{{ route('pengeluaran.destroy', $item->kode_t) }}" method="POST">
              <a href="{{ route('pengeluaran.edit', $item->kode_t) }}"><svg xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg></a>
              @csrf
              @method('DELETE')
              <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
      @endif
  </table>
</div>