<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Poppins Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Fonts Bunny for fallback -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <style>
            .animated-bg {
                background: linear-gradient(-45deg, #121212, #1e1b2f, #2a1f4a, #121212);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
            }
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
            }
            @media (prefers-reduced-motion: reduce) {
                .animated-bg, * { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
            }
        </style>
    </head>
    <body class="font-['Poppins'] text-white antialiased min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 animated-bg relative overflow-hidden">
            <!-- Subtle particles -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-20 left-20 w-72 h-72 bg-purple-500/20 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                <div class="absolute top-40 right-20 w-72 h-72 bg-indigo-500/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000ms"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-rose-500/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000ms"></div>
            </div>
            
            <div class="relative z-10">
                <a href="/" class="mb-8 block p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 hover:scale-105 transition-all duration-300 animate-fade-in-up">
                    <img src="{{ asset('images/logo-roti.webp') }}" alt="Toko Roti Logo" class="w-24 h-24 lg:w-28 lg:h-28 object-contain mx-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md lg:max-w-lg mt-6 px-8 py-12 glass-card rounded-3xl {{ $attributes['class'] ?? '' }}">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
