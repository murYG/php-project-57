<form method="GET" action="{{ route('tasks.index') }}">
    <div class="flex">
        <x-select name="filter[status_id]" id="filter[status_id]">
            <option value="" @selected($filter['status_id'] == null)>{{ __('models.task.status') }}</option>
        @foreach ($statuses as $status)        
            <option value="{{ $status->id }}" @selected($filter['status_id'] == $status->id)>
                {{ $status->name }}
            </option>
        @endforeach            
        </x-select>
        
        <x-select name="filter[created_by_id]" id="filter[created_by_id]">
            <option value="" @selected($filter['created_by_id'] == null)>{{ __('models.task.author') }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($filter['created_by_id'] == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach 
        </x-select>
        
        <x-select name="filter[assigned_to_id]" id="filter[assigned_to_id]">
            <option value="" @selected($filter['assigned_to_id'] == null)>{{ __('models.task.author') }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($filter['assigned_to_id'] == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach 
        </x-select>
        
        <div class="flex">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="submit">
                {{ __('views.task.index.buttons.filter') }}
            </button>
        </div>
        
    </div>
</form>