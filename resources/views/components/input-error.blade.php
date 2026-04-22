@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'mt-2 animate-shake bg-rose-500/20 border border-rose-500/30 backdrop-blur-sm rounded-xl p-3 font-poppins font-medium text-sm text-rose-200 flex items-start gap-2']) }}>
        <svg class="h-5 w-5 flex-shrink-0 mt-0.5 text-rose-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
        <ul class="space-y-1 flex-1">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}
.animate-shake {
    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}
</style>

