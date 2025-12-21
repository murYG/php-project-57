<div>
    <label for="name">{{ __('models.label.name') }}</label>
</div>
<div class="mt-2">
    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name', $label->name) }}">
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <label for="description">{{ __('models.label.description') }}</label>
</div>
<div class="mt-2">
    <input class="rounded border-gray-300 w-1/3" type="text" name="description" id="description" value="{{ old('description', $label->description) }}">
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>