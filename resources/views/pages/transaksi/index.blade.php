@extends('layouts.main')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
  const baseUrl = {!! json_encode(url('/')) !!};
  const kode_barang = $('.formTambahTransaksi #kode_barang').select2();

  $('#nama_pelanggan').focus();
  
  $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  const getTransaksi = async () => {
    try {
      const response = await fetch(`${baseUrl}/transaksi/getAll`);
      const responseJson = await response.json();
      renderTransaksi(responseJson.data.transaksi);
    } catch (error) {
      showResponseMessage(error);
    }
  }

  const getTransaksiById = async (transaksiId) => {
    try {
      const response = await fetch(`${baseUrl}/transaksi/${transaksiId}`);
      const responseJson = await response.json();
      if (responseJson.status === 'success') {
        renderTransaksiById(responseJson.data.transaksi);
      } else {
        showResponseMessage(responseJson.message);  
      }
    } catch (error) {
      showResponseMessage(error);
    }
  }
  
  const insertTransaksi = async (transaksi) => {
    try {
      const options = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(transaksi)
      };
    
      const response = await fetch(`${baseUrl}/transaksi`, options);
      const responseJson = await response.json();
      kode_barang.select2('open');
      getTransaksi();
    } catch (error) {
      showResponseMessage(error);
    }
  }

  const updateTransaksi = async (transaksi) => {
    try {
      const options = {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(transaksi)
      };
      
      const response = await fetch(`${baseUrl}/transaksi/${transaksi.id}`, options);
      const responseJson = await response.json();
      // showResponseMessage(responseJson.message);
      getTransaksi();
    } catch (error) {
      showResponseMessage(error);
    }
  }

  const removeTransaksi = (transaksiId) => {
    fetch(`${baseUrl}/transaksi/${transaksiId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .then(response => {
      return response.json();
    })
    .then(responseJson => {
      // showResponseMessage(responseJson.message);
      getTransaksi();
    })
    .catch(error => {
      showResponseMessage(error);
    });
  }

  const saveTransaksi = async (transaksi) => {
    try {
      const options = {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(transaksi)
      };
      
      const response = await fetch(`${baseUrl}/transaksi/saveTransaction`, options);
      const responseJson = await response.json();
      if (responseJson.status === 'success') {
        document.location.href = `${baseUrl}/riwayat-transaksi/${responseJson.kode_transaksi}`;
      }
    } catch (error) {
      showResponseMessage(error);
    }
  }

  const renderTransaksi = (transaksi) => {
    $('table tbody').empty();
    let totalBayar = 0;
    if (transaksi.length) {
      $.each(transaksi, function(key, value) {
        $('table tbody').append(`
          <tr class="border-b dark:border-gray-700">
            <td class="px-4 py-3">${value.kode_barang}</td>
            <td class="px-4 py-3">${value.nama_barang}</td>
            <td class="px-4 py-3">${value.jumlah}</td>
            <td class="px-4 py-3">Rp. ${value.harga}</td>
            <td class="px-4 py-3">Rp. ${value.total}</td>
            <td>
              <div class="px-4 py-3 flex items-center justify-center gap-4">
                <button type="button" class="button-edit" data-id="${value.ID}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>  
                </button>
                <button type="button" class="button-delete" data-id="${value.ID}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        `);
        totalBayar = totalBayar + parseInt(value.total);
      });
    } else {
      $('table tbody').append(`
        <tr class="border-b dark:border-gray-700">
          <td class="px-4 py-3" colspan="6">Belum ada barang yang ditambahkan</td>
        </tr>
      `);
    }
    $('.formSimpanTransaksi #total_bayar').val(totalBayar);
  }

  const renderTransaksiById = ({ ID, kode_barang, jumlah, nama_pelanggan }) => {
    $('.formTambahTransaksi #id').val(ID);
    $('.formTambahTransaksi #nama_pelanggan').val(nama_pelanggan);
    $('.formTambahTransaksi #kode_barang').select2().val(kode_barang).trigger('change');
    $('.formTambahTransaksi #jumlah').val(jumlah);
    $('.formTambahTransaksi button[type=submit]').text('Update');
  }

  const showResponseMessage = (message = 'Check your internet connection') => {
    const notyf = new Notyf({
      duration: 1000,
      position: {
        x: 'center',
        y: 'bottom',
      },
      types: [
        {
          type: 'info',
          background: '#34495e',
          duration: 3000,
          dismissible: true,
        }
      ]
    });
    
    notyf.open({
      type: 'info',
      message,
    });
  };

  $(function() {
    $('.formTambahTransaksi').on('submit', function(e) {
      e.preventDefault();

      const transaksi = {
        nama_pelanggan: $('.formTambahTransaksi #nama_pelanggan').val(),
        kode_barang: $('.formTambahTransaksi #kode_barang').val(),
        jumlah: $('.formTambahTransaksi #jumlah').val(),
      };

      if ($('.formTambahTransaksi button').text() == 'Tambah') {
        insertTransaksi(transaksi);
      } else {
        updateTransaksi({
          id: $('.formTambahTransaksi #id').val(),
          ...transaksi,
        });
      }

      $('.formTambahTransaksi #id').val('');
      $('.formTambahTransaksi #kode_barang').select2().val('').trigger('change');
      $('.formTambahTransaksi #jumlah').val('');
      $('.formTambahTransaksi button[type=submit]').text('Tambah');
    });

    $('#bayar').on('keyup', function() {
      $('#kembali').val($(this).val() - $('#total_bayar').val());
    });

    $('table tbody').on('click', '.button-edit', function(e) {
      e.preventDefault();
      getTransaksiById($(this).data('id'));
    });

    $('table tbody').on('click', '.button-delete', function(e) {
      e.preventDefault();
      removeTransaksi($(this).data('id'));
    });

    $('.formSimpanTransaksi').on('submit', function(e) {
      e.preventDefault();

      const totalBayar = parseInt($('.formSimpanTransaksi #total_bayar').val());
      const bayar = parseInt($('.formSimpanTransaksi #bayar').val());

      if (bayar < totalBayar) {
        return showResponseMessage('Maaf jumlah bayar tidak cukup');
      }
      
      saveTransaksi({
        bayar: $('.formSimpanTransaksi #bayar').val(),
        kembali: $('.formSimpanTransaksi #kembali').val(),
      });
    
      $('.formSimpanTransaksi #bayar').val(0);
      $('.formSimpanTransaksi #kembali').val(0);
    });

    $(document).on('keydown', (event) => {
      if (event.ctrlKey && event.keyCode === 13) {
        const totalBayar = parseInt($('.formSimpanTransaksi #total_bayar').val());
        const bayar = parseInt($('.formSimpanTransaksi #bayar').val());
        
        if (bayar < totalBayar) {
          return showResponseMessage('Maaf jumlah bayar tidak cukup');
        }
        
        saveTransaksi({ 
          bayar: $('.formSimpanTransaksi #bayar').val(), 
          kembali: $('.formSimpanTransaksi #kembali').val(), 
        });
        
        $('.formSimpanTransaksi #bayar').val(0);
        $('.formSimpanTransaksi #kembali').val(0);
      }
    });

    getTransaksi();
  });
</script>
@endpush

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
  <div class="mx-auto max-w-screen-xl px-4 lg:px-4">
    <!-- Start coding here -->
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

      {{-- bagian searching bar dan button add product --}}
      <div class="flex flex-col md:flex-row justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 items-end">
        <div class="w-full">
          <form class="flex gap-x-2 items-end w-full formTambahTransaksi">
            @csrf
            <input type="hidden" id="id" name="id" value="">

            <div class="me-auto">
              <label for="nama_pelanggan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                Pelanggan</label>
              <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required placeholder="Masukan nama pelanggan">
            </div>

            <div>
              <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                Barang</label>
              <select id="kode_barang" class="select2" name="kode_barang">
                <option value="" selected>Masukan nama barang</option>
                @foreach ($barang as $brg)
                <option value="{{ $brg->kode_barang }}">{{ $brg->nama_barang }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                Barang</label>
              <input type="number" id="jumlah" name="jumlah"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required placeholder="Masukan jumlah barang">
            </div>

            <button type="submit"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah</button>

          </form>
        </div>
      </div>
      {{-- bagian searching bar dan button add product --}}

      {{-- Table Body start --}}
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">Kode</th>
              <th scope="col" class="px-4 py-3">Nama Barang</th>
              <th scope="col" class="px-4 py-3">Jumlah</th>
              <th scope="col" class="px-4 py-3">Harga</th>
              <th scope="col" class="px-4 py-3">Total</th>
              <th scope="col" class="px-4 py-3 flex items-center justify-center">Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      {{-- Table Body end --}}

    </div>

    <div class="flex justify-end pb-[30rem]">
      <div class="w-full md:w-auto">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden mt-4 p-4">
          <form class="formSimpanTransaksi">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-x-2 items-end gap-y-4">
              <div class="flex items-center gap-x-3">
                <label for="total_bayar" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Total
                  Bayar</label>
                <div class="flex">
                  <span
                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Rp.
                  </span>
                  <input type="number" id="total_bayar" name="total_bayar"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-none rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly value="0">
                </div>
              </div>
              <div class="flex items-center gap-x-3">
                <label for="bayar" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                  Bayar</label>
                <div class="flex">
                  <span
                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Rp.
                  </span>
                  <input type="number" id="bayar" name="bayar"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required value="0">
                </div>
              </div>
              <div class="flex items-center gap-x-3">
                <label for="kembali"
                  class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Kembalian</label>
                <div class="flex">
                  <span
                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Rp.
                  </span>
                  <input type="number" id="kembali" name="kembali"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-none rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly value="0">
                </div>
              </div>
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection