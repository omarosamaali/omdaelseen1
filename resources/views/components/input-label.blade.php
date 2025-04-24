@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm']) }} style="font-family: cairo; color: black;">
    {{ $value ?? $slot }}
</label>
