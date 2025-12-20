<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("views.task.index.title") }}
        </h2>
    </x-slot>

    @auth
    <div>
        <a href="{{ route('tasks.create') }}">
            {{ __("views.task.index.buttons.create") }}
        </a>
    </div>
    @endauth

    <div>
        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <td>{{ __('models.task.id') }}</td>
                    <td>{{ __('models.task.status') }}</td>
                    <td>{{ __('models.task.name') }}</td>
                    <td>{{ __('models.task.author') }}</td>
                    <td>{{ __('models.task.responsible') }}</td>
                    <td>{{ __('models.task.created_at') }}</td>
                    @auth
                    <td>{{ __("views.common.actions.title") }}</td>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td><a class="text-decoration-none" href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a></td>
                        <td>{{ $task->author->name }}</td>
                        <td>{{ $task->responsible->name ?? '' }}</td>
                        <td>{{ $task->created_at->format('d.m.Y') }}</td>
                        @auth
                        <td>
                            <a class="text-decoration-none" href="{{ route('tasks.edit', $task->id)}}">{{ __('views.common.actions.actions.edit') }}</a>
                            @if (Auth::user()->id === $task->author->id)
                            <form method="POST" action="{{ route('tasks.destroy', ['task' => $task]) }}">
                                @csrf
                                @method('DELETE')
                                <a class="text-decoration-none link-danger" 
                                    href="{{ route('tasks.destroy', ['task' => $task]) }}" 
                                    onclick="event.preventDefault(); if (confirm('{{ __('views.task.index.confirm_deletion') }}')) this.closest('form').submit();">
                                     {{ __('views.common.actions.actions.delete') }}
                                </a>
                            </form>
                            @endif
                        </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tasks->links() }}
    </div>
</x-app-layout>
