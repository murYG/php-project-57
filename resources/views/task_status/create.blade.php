<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("controllers.task_status.create") }}
        </h2>
    </x-slot>
    
    <form method="POST" action="{{ route('task_status.store') }}">
        @csrf

        @include('task_status.form')

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('controllers.task_status.store') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
