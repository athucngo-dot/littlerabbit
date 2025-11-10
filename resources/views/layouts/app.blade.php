<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Little Rabbit — Kids Clothing & Accessories</title>
  <meta name="description" content="Soft, stylish children's clothing and accessories. Responsive, accessible e‑commerce landing page.">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Lato:wght@400;500;700&display=swap" rel="stylesheet">
  
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>[x-cloak] { display: none !important; }</style>

</head>
<body class="bg-paper-2 text-ink font-sans">

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

</body>
</html>