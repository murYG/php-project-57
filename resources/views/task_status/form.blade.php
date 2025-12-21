<div>
    <label for="name">{{ __('models.task_status.name') }}</label>
</div>
<div class="mt-2">
    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name', $task_status->name) }}">
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>