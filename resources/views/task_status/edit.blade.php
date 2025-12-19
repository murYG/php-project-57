<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("controllers.task_status.edit") }}
        </h2>
    </x-slot>
    
    <form method="POST" action="{{ route('task_status.update', $task_status) }}">
        @csrf
        @method('PATCH')

        @include('task_status.form')

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('controllers.task_status.update') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
