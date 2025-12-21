<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __("views.task_status.index.title") }}
        </h1>

        <div>
            @auth
            <a href="{{ route('task_status.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __("views.task_status.index.buttons.create") }}
            </a>
            @endauth
        </div>

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
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $task_status->id }}</td>
                        <td>{{ $task_status->name }}</td>
                        <td>{{ $task_status->created_at->format('d.m.Y') }}</td>
                        @auth
                        <td>
                            <a class="text-red-600 hover:text-red-900" 
                                href="{{ route('task_status.destroy', ['task_status' => $task_status]) }}" 
                                onclick="event.preventDefault(); 
                                    if (confirm('{{ __('views.task_status.index.confirm_deletion') }}')) 
                                        document.getElementById('delete-form[{{ $task_status->id }}]').submit();">
                                 {{ __('views.common.actions.actions.delete') }}
                            </a>
                            <form id="delete-form[{{ $task_status->id }}]" method="POST" action="{{ route('task_status.destroy', ['task_status' => $task_status]) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>                            
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('task_status.edit', $task_status->id)}}">
                                {{ __('views.common.actions.actions.edit') }}
                            </a>
                        </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $task_statuses->links() }}
    </div>
</x-app-layout>