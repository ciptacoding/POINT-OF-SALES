<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Pos | {{ $title }}</title>
  @stack('styles')
</head>

<body class="bg-slate-50">
  @include('partials.navbar')

  @include('partials.sidebar')

  <main class="sm:ml-64">
    <div class="mt-10">
      @yield('content')
    </div>
  </main>
  @stack('scripts')
</body>

</html>
