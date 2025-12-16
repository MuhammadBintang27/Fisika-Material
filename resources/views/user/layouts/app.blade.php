<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laboratorium Fisika Dasar')</title>
    <meta name="description" content="Laboratorium Fisika Dasar - Fasilitas unggulan untuk penelitian dan pendidikan fisika dengan teknologi terdepan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Preconnect for faster font loading -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://fonts.bunny.net">

    <!-- Fonts: Poppins & Plus Jakarta Sans -->
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#475569',
                        accent: '#f59e0b',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'jakarta': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
        
    </script>
    <script>
        // CSRF token setup for AJAX
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        window.axios = { defaults: { headers: { 'X-CSRF-TOKEN': token } } };
    </script>
</head>
<body class="overflow-x-hidden">
    @include('user.components.navbar')

    <main class="overflow-x-hidden">
        @yield('content')
    </main>

    @include('user.components.footer')

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
