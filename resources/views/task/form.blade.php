<div>
    <label for="name">{{ __('models.task.name') }}</label>
</div>
<div class="mt-2">
    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name', $task->name) }}">
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>



<div>
    <label for="description">{{ __('models.task.description') }}</label>
</div>
<div>
    <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{ old('description', $task->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>



<div>
    <label for="status_id">{{ __('models.task.status') }}</label>
</div>
<div>
    <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
        <option value="" @selected(old('status_id', $task->status_id) == null)></option>
        @foreach ($statuses as $id => $name)
            <option value="{{ $id }}" @selected(old('status_id', $task->status_id) == $id)>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
</div>

<div>
    <label for="assigned_to_id">{{ __('models.task.assignedTo') }}</label>
</div>
<div>
    <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
        <option value="" @selected(old('assigned_to_id', $task->assigned_to_id) == null)></option>
        @foreach ($users as $id => $name)
            <option value="{{ $id }}" @selected(old('assigned_to_id', $task->assigned_to_id) == $id)>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('assigned_to_id')" class="mt-2" />
</div>

<div>
    <label for="labels">{{ __('models.task.labels') }}</label>
</div>
<div>
    <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels" multiple="">
        @foreach ($labels as $id => $name)
            <option value="{{ $id }}" @selected($task->labels->contains(old('labels', $id)))>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('labels')" class="mt-2" />
</div>