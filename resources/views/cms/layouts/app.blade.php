<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Little Rabbit — CMS</title>

        <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Lato:wght@400;500;700&display=swap" rel="stylesheet">
    
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    @vite(['resources/css/app.css'])

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
   
</head>
<body class="min-h-screen bg-gradient-to-b from-mint to-paper-2 flex">

    <!-- Sidebar -->
    <x-cms.sidebar />

    <div class="flex-1 flex flex-col">

        <!-- Top Bar -->
        <header class="bg-white px-6 py-4 shadow-sm flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">
                @yield('title')
            </h1>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">
                    {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                </span>

                <form method="POST" action="{{ route('cms.logout') }}">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>
</body>
</html>