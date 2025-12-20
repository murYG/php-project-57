<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("views.task.show.title") }}: {{ $task->name }}
        </h2>
    </x-slot>

    <p><span class="font-black font-semibold">{{ __('models.task.name') }}:</span> {{ $task->name }}</p>
    <p><span class="font-black font-semibold">{{ __('models.task.status') }}:</span> {{ $task->status->name }}</p>
    <p><span class="font-black font-semibold">{{ __('models.task.description') }}:</span> {{ $task->description }}</p>

</x-app-layout>
