<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("views.label.index.title") }}
        </h2>
    </x-slot>

    @auth
    <div>
        <a href="{{ route('labels.create') }}">
            {{ __("views.label.index.buttons.create") }}
        </a>
    </div>
    @endauth

    <div>
        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <td>{{ __('models.label.id') }}</td>
                    <td>{{ __('models.label.name') }}</td>
                    <td>{{ __('models.label.description') }}</td>
                    <td>{{ __('models.task.created_at') }}</td>
                    @auth
                    <td>{{ __("views.common.actions.title") }}</td>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($labels as $label)
                    <tr>
                        <td>{{ $label->id }}</td>
                        <td>{{ $label->name }}</td>
                        <td>{{ $label->description }}</td>
                        <td>{{ $label->created_at->format('d.m.Y') }}</td>
                        @auth
                        <td>
                            <a class="text-decoration-none" href="{{ route('labels.edit', $label->id)}}">{{ __('views.common.actions.actions.edit') }}</a>
                            <form method="POST" action="{{ route('labels.destroy', ['label' => $label]) }}">
                                @csrf
                                @method('DELETE')
                                <a class="text-decoration-none link-danger" 
                                    href="{{ route('labels.destroy', ['label' => $label]) }}" 
                                    onclick="event.preventDefault(); if (confirm('{{ __('views.label.index.confirm_deletion') }}')) this.closest('form').submit();">
                                     {{ __('views.common.actions.actions.delete') }}
                                </a>
                            </form>
                        </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $labels->links() }}
    </div>
</x-app-layout>
