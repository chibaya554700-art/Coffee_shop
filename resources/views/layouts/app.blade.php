<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Coffee Shop')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            50:  '#fdf8f0',
                            100: '#f9edd9',
                            200: '#f2d9b0',
                            400: '#c8853a',
                            600: '#8B5E3C',
                            800: '#4A2C17',
                            900: '#2C1A0E',
                        },
                        cream: '#FAF3E0',
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans:  ['Lato', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.8s ease forwards;
    }
</style>

    @stack('styles')
</head>
<body class="bg-cream font-sans text-coffee-800 antialiased">
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>
</html>