<x-guest-layout>
    {{-- Status messages --}}
    <x-auth-session-status class="mb-8 animate-fade-in" :status="session('status')" />
    
    {{-- Header --}}
    <div class="text-center mb-12 animate-fade-in-up">
        <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent mb-4">
            Welcome Back
        </h1>
        <p class="text-xl text-white font-light max-w-md mx-auto leading-relaxed">
            Masuk ke akun Toko Roti Anda dan kelola penjualan dengan mudah
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
        @csrf

        {{-- Email Field --}}
        <div class="group animate-slide-in-up animation-delay-100">
            {{-- Label dipastikan memiliki margin-bottom agar tidak menabrak input --}}
            <x-input-label for="email" value="Email Address" class="text-white/90 mb-2 block" />
            <div class="relative">
                <i class="fas fa-at absolute left-4 top-1/2 -translate-y-1/2 text-white/50 z-10"></i>
                <x-text-input 
                    id="email" 
                    class="pl-12 w-full bg-white/10 border-white/20 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    placeholder="Masukkan email Anda"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password Field --}}
        <div class="group animate-slide-in-up animation-delay-200">
            <x-input-label for="password" value="Password" class="text-white/90 mb-2 block" />
            <div class="relative">
                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/50 z-10"></i>
                <x-text-input 
                    id="password"
                    class="pl-12 pr-12 w-full bg-white/10 border-white/20 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    type="password" 
                    name="password" 
                    required 
                    placeholder="Masukkan password Anda"
                />
                <button 
                    type="button"
                    class="absolute inset-y-0 right-3 flex items-center hover:text-white transition-all text-white/50"
                    onclick="togglePasswordVisibility()"
                    tabindex="-1"
                >
                    <svg id="eye-icon-open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-icon-closed" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.228 6.228A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 4.293M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me & Buttons --}}
        <div class="flex items-center justify-between py-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-white/20 bg-white/10 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-white/80">Remember me</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="flex-1 text-center py-3 px-6 bg-white/5 border border-white/10 rounded-xl text-white/80 hover:bg-white/10 transition-all text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-key"></i> Forgot?
                </a>
            @endif

            <button type="submit" class="flex-1 py-3 px-6 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i> LOG IN
            </button>
        </div>

        {{-- Footer --}}
        <div class="pt-8 border-t border-white/10 text-center">
            <p class="text-white/60 text-sm mb-4">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">
                Daftar Sekarang
            </a>
        </div>
    </form>

    <style>
        .animate-fade-in { animation: fadeIn 0.8s ease-out; }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
        .animate-slide-in-up { animation: slideInUp 0.6s ease-out; }
        .animation-delay-100 { animation-delay: 0.1s; }
        .animation-delay-200 { animation-delay: 0.2s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-icon-open');
            const eyeClosed = document.getElementById('eye-icon-closed');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>