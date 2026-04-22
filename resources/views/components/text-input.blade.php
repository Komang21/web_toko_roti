@props(['disabled' => false])

<div class="relative">
    {{-- Icon slot --}}
    @if($icon ?? false)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
            <x-heroicon-o-{{ $icon }} class="h-5 w-5 text-white/60" />
        </div>
    @endif
    
    <input 
        @disabled($disabled) 
        {{ $attributes->merge([
            'class' => 'block w-full pl-0 pr-10 py-4 rounded-xl border-0 bg-white/10 border-white/20 backdrop-blur-sm text-white placeholder-white/60 font-medium text-sm focus:ring-2 focus:ring-indigo-400/50 focus:border-transparent transition-all duration-300 peer',
            'placeholder' => $attributes->get('placeholder', '')
        ]) }} 
    />
</div>

<style>
    .peer:focus ~ .floating-label { @apply -translate-y-2 scale-75 text-indigo-300; }
</style>

