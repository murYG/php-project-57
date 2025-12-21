@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'rounded border-gray-300']) }} >
    {{ $slot }}
</select>