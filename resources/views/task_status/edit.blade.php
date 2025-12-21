<x-app-layout>
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __("views.task_status.edit.title") }}
        </h1>

        <form class="w-50"  method="POST" action="{{ route('task_status.update', $task_status) }}">
            @csrf
            @method('PATCH')

            <div class="flex flex-col">
                @include('task_status.form')
                
                <div class="mt-2">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        {{ __('views.task_status.edit.buttons.edit') }}
                    </button>
                </div>                
            </div>
        </form>
    </div>
</x-app-layout>

