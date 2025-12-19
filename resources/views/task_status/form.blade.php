<div class="mb-3">
    <x-input-label for="name" :value="__('models.task_status.name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $task_status->name)" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>