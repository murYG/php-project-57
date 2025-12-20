<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("views.index.title") }}
        </h1>
    </x-slot>

    {{ __("views.index.content") }}

</x-app-layout>
