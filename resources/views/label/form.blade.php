<div class="mb-3">
    <x-input-label for="name" :value="__('models.label.name')" />
    <x-text-input id="name" class="block mt-1 w-3/4" type="text" name="name" :value="old('name', $label->name)" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mb-3">
    <x-input-label for="description" :value="__('models.label.description')" />
    <x-textarea id="description" class="block mt-1 w-3/4" name="description">{{ old('description', $label->description) }}</x-textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>