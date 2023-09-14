<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Pos | {{ $title }}</title>
  <style>
    @media print {
      @page {
        size: auto;
        margin: 0mm;
      }

      .mybtn {
        display: none;
      }

      .title {
        display: none;
      }
    }
  </style>
</head>

<body>
  @php
  $tanggal = "";
  @endphp
  @foreach ($transaksi as $item)
  @php
  $tanggal = $item->tanggal;
  @endphp
  @endforeach
  <div class="p-4 my-4 mx-auto">
    <button onclick="window.location.replace(document.referrer);"
      class="mybtn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Kembali</button>
    <button onclick="window.print()"
      class="mybtn text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Cetak</button>
    <h1 class="text-center font-bold text-3xl">Toko Darma Sari</h1>
    <p class="text-center">Br. Dinas Kelod Desa Bayuatis</p>
    <p class="text-center font-semibold">Hp/Wa: 087 762 602 884</p>
    <hr class="my-2">
    <p class="text-center">{{ date('d/m/Y H:i:s', strtotime($tanggal)); }} - Kasir: admin</p>
    <hr class="my-2">

    @php
    $totalBayar = $diskon = $bayar = $kembali = 0;
    @endphp

    @foreach ($transaksi as $item)
    <div class="mt-2">
      <p class="uppercase">{{ $item->nama_barang }}</p>
      <div class="grid grid-cols-2 gap-4">
        <p class="indent-5">{{ number_format($item->harga,0,',','.') }}x</p>
        <p>{{ $item->jumlah }} : <span>Rp {{ number_format($item->total,0,',','.') }}</span></p>
      </div>
    </div>
    @php
    $totalBayar += $item->total;
    $diskon = $item->diskon;
    $bayar = $item->bayar;
    $kembali = $item->kembali;
    @endphp
    @endforeach

    <hr class="my-2">
    <div class="grid grid-cols-2 gap-4">
      <p>Total</p>
      <p> : <span class="font-semibold">Rp. {{ number_format($totalBayar,0,',','.') }}</span></p>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <p>Diskon</p>
      <p> : <span class="font-semibold">Rp. {{ number_format($diskon,0,',','.') }}</span></p>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <p>Bayar</p>
      <p> : <span class="font-semibold">Rp. {{ number_format($bayar,0,',','.') }}</span></p>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <p>Kembali</p>
      <p> : <span class="font-semibold">Rp. {{ number_format($kembali,0,',','.') }}</span></p>
    </div>
  </div>
  <script>
    window.addEventListener("DOMContentLoaded", (event) => {
      window.print();
    });
  </script>
</body>

</html>