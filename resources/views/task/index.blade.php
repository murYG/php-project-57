<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __("views.task.index.title") }}
        </h1>

        <div class="w-full flex items-center">
            <div>
                @include('task.filter')
            </div>

            @auth
            <div class="ml-auto">
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    {{ __("views.task.index.buttons.create") }}
                </a>
            </div>
            @endauth
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <td>{{ __('models.task.id') }}</td>
                    <td>{{ __('models.task.status') }}</td>
                    <td>{{ __('models.task.name') }}</td>
                    <td>{{ __('models.task.author') }}</td>
                    <td>{{ __('models.task.responsible') }}</td>
                    <td>{{ __('models.task.created_at') }}</td>
                    @canany(['update', 'delete'], new \App\Models\Task())
                    <td>{{ __("views.common.actions.title") }}</td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.show', $task->id) }}">
                                {{ $task->name }}
                            </a>
                        <td>{{ $task->author->name }}</td>
                        <td>{{ $task->responsible->name ?? '' }}</td>
                        <td>{{ $task->created_at->format('d.m.Y') }}</td>
                        @canany(['update', 'delete'], $task)
                        <td>
                            @can('delete', $task)
                            <a class="text-red-600 hover:text-red-900" 
                                href="{{ route('tasks.destroy', ['task' => $task]) }}" 
                                onclick="event.preventDefault(); 
                                    if (confirm('{{ __('views.task.index.confirm_deletion') }}')) 
                                        document.getElementById('delete-form[{{ $task->id }}]').submit();">
                                 {{ __('views.common.actions.actions.delete') }}
                            </a>
                            <form id="delete-form[{{ $task->id }}]" method="POST" action="{{ route('tasks.destroy', ['task' => $task]) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endcan
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.edit', $task->id)}}">
                                {{ __('views.common.actions.actions.edit') }}
                            </a>
                        </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $tasks->links() }}
    </div>
</x-app-layout>