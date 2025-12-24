<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __("views.label.index.title") }}
        </h1>

        <div>
            @auth
            <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __("views.label.index.buttons.create") }}
            </a>
            @endauth
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <td>{{ __('models.label.id') }}</td>
                    <td>{{ __('models.label.name') }}</td>
                    <td>{{ __('models.label.description') }}</td>
                    <td>{{ __('models.label.created_at') }}</td>
                    @canany(['update', 'delete'], new \App\Models\Label())
                    <td>{{ __("views.common.actions.title") }}</td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach($labels as $label)
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $label->id }}</td>
                        <td>{{ $label->name }}</td>
                        <td>{{ $label->description }}</td>
                        <td>{{ $label->created_at->format('d.m.Y') }}</td>
                        @canany(['update', 'delete'], $label)
                        <td>
                            <a class="text-red-600 hover:text-red-900" 
                                href="{{ route('labels.destroy', ['label' => $label]) }}" 
                                onclick="event.preventDefault(); 
                                    if (confirm('{{ __('views.label.index.confirm_deletion') }}')) 
                                        document.getElementById('delete-form[{{ $label->id }}]').submit();">
                                 {{ __('views.common.actions.actions.delete') }}
                            </a>
                            <form id="delete-form[{{ $label->id }}]" method="POST" action="{{ route('labels.destroy', ['label' => $label]) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>                            
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('labels.edit', $label->id)}}">
                                {{ __('views.common.actions.actions.edit') }}
                            </a>
                        </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $labels->links() }}
    </div>
</x-app-layout>
