@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-3 font-poppins font-medium text-base text-white/90 tracking-wide']) }}>
    {{ $value ?? $slot }}
</label>
