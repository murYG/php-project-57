@props(['messages'])

@if ($messages)
    <div class="mb-4">
        <div class="font-medium text-red-600">{{ __('Упс! Что-то пошло не так:') }}</div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
