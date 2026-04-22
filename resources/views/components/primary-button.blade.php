<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'group relative inline-flex items-center px-6 py-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white font-semibold text-sm uppercase tracking-wide rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transform transition-all duration-300 overflow-hidden'
]) }}>
    {{-- Loading spinner --}}
    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white opacity-0 group-[&.loading]:opacity-100 hidden group-[&.loading]:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    
    <span class="relative z-10 flex-1 text-center">
        {{ $slot }}
    </span>
    
    {{-- Shimmer overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 opacity-0 group-hover:opacity-100 transition-opacity duration-500 -translate-x-full group-hover:translate-x-full"></div>
</button>

<script>
    // Auto add loading class on submit
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('x-primary-button');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.querySelector('span').textContent = 'Signing In...';
                }
            });
        });
    });
</script>
