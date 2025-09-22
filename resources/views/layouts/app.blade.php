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

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>[x-cloak] { display: none !important; }</style>

</head>
<body class="bg-paper-2 text-ink font-sans">

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

  <!-- JS for toast notifications -->
  <script>
    function toast(message) {
      const el = document.createElement('div');
      el.textContent = message;
      el.className = 'fixed bottom-5 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-4 py-2 rounded-full shadow-lg z-50';
      document.body.appendChild(el);
      setTimeout(() => el.remove(), 2200);
    }

    function newsletterThanks() { toast('Thanks! Check your inbox to confirm.'); }

    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', () => {
        toast('Added to cart: ' + btn.dataset.name);
      });
    });
  </script>

</body>
</html>