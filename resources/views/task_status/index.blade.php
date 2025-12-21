<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Привет от Хекслета!
        </h2>
    </x-slot>

    @auth
    <div>
        <x-a-btn-primary href="{{ route('task_status.create') }}">
            {{ __("views.task_status.index.buttons.create") }}
        </x-a-btn-primary>
    </div>
    @endauth

    <div>
        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <td>{{ __('models.task_status.id') }}</td>
                    <td>{{ __('models.task_status.name') }}</td>
                    <td>{{ __('models.task_status.created_at') }}</td>
                    @auth
                    <td>{{ __("views.common.actions.title") }}</td>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($task_statuses as $task_status)
                    <tr>
                        <td>{{ $task_status->id }}</td>
                        <td>{{ $task_status->name }}</td>
                        <td>{{ $task_status->created_at->format('d.m.Y') }}</td>
                        @auth
                        <td>
                            <a class="text-decoration-none" href="{{ route('task_status.edit', $task_status->id)}}">{{ __('views.common.actions.actions.edit') }}</a>
                            <form method="POST" action="{{ route('task_status.destroy', ['task_status' => $task_status]) }}">
                                @csrf
                                @method('DELETE')
                                <a class="text-decoration-none link-danger" 
                                    href="{{ route('task_status.destroy', ['task_status' => $task_status]) }}" 
                                    onclick="event.preventDefault(); if (confirm('{{ __('views.task_status.index.confirm_deletion') }}')) this.closest('form').submit();">
                                     {{ __('views.common.actions.actions.delete') }}
                                </a>
                            </form>     
                        </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $task_statuses->links() }}
    </div>
</x-app-layout>
