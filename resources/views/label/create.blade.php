<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __("views.label.create.title") }}
        </h1>

        <form class="w-50"  method="POST" action="{{ route('labels.store') }}">
            @csrf
            <div class="flex flex-col">
                @include('label.form')
                
                <div class="mt-2">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        {{ __('views.label.create.buttons.create') }}
                    </button>
                </div>                
            </div>
        </form>
    </div>
</x-app-layout>
