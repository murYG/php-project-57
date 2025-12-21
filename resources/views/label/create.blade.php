<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("views.label.create.title") }}
        </h2>
    </x-slot>
    
    <form method="POST" action="{{ route('labels.store') }}">
        @csrf

        @include('label.form')

        <div class="flex items-center mt-4">
            <x-primary-button class="ms-3">
                {{ __('views.label.create.buttons.create') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
