<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  {{--
  <link rel="stylesheet" href="/build/assets/app-463d3fa2.css"> --}}
  <title>Pos | {{ $title }}</title>
  @stack('styles')
</head>

<body class="bg-slate-50">
  @include('partials.navbar')

  @include('partials.sidebar')

  <main class="py-4 px-1 sm:ml-64">
    <div class="py-4 mt-10">
      @yield('content')
    </div>
  </main>
  @stack('scripts')

  {{-- <script src="/build/assets/app-547abec6.js"></script> --}}
</body>

</html>