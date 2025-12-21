<div class="mb-3">
    <x-input-label for="name" :value="__('models.task.name')" />
    <x-text-input id="name" class="block mt-1 w-3/4" type="text" name="name" :value="old('name', $task->name)" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mb-3">
    <x-input-label for="description" :value="__('models.task.description')" />
    <x-textarea id="description" class="block mt-1 w-3/4" name="description">{{ old('description', $task->description) }}</x-textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mb-3">
    <x-input-label for="status_id" :value="__('models.task.status')" />
    <x-select id="status_id" class="block mt-1 w-3/4" name="status_id">
        <option value="" @selected(old('status_id', $task->status_id) == null)></option>
    @foreach ($statuses as $status)
        <option value="{{ $status->id }}" @selected(old('status_id', $task->status_id) == $status->id)>
            {{ $status->name }}
        </option>
    @endforeach
    </x-select>
    <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
</div>

<div class="mb-3">
    <x-input-label for="assigned_to_id" :value="__('models.task.responsible')" />
    <x-select id="assigned_to_id" class="block mt-1 w-3/4" name="assigned_to_id">
        <option value="" @selected(old('assigned_to_id', $task->assigned_to_id) == null)></option>
    @foreach ($users as $responsible)
        <option value="{{ $responsible->id }}" @selected(old('assigned_to_id', $task->assigned_to_id) == $responsible->id)>
            {{ $responsible->name }}
        </option>
    @endforeach
    </x-select>
    <x-input-error :messages="$errors->get('assigned_to_id')" class="mt-2" />
</div>

<div class="mb-3">
    <x-input-label for="labels" :value="__('models.task.labels')" />
    <x-select multiple id="labels" class="block mt-1 w-3/4" name="labels[]">
    @foreach ($labels as $label)
        <option value="{{ $label->id }}" @selected(old('labels', $task->labels->contains($label->id)))>
            {{ $label->name }}
        </option>
    @endforeach
    </x-select>
    <x-input-error :messages="$errors->get('labels')" class="mt-2" />
</div>