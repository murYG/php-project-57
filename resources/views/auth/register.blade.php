<x-guest-layout>
    <h2 class="text-center"><a href="{{ route('welcome') }}">Менеджер задач</a></h2>
    
    <!-- Validation Errors -->
    <x-input-error-auth :messages="$errors->get('name')" class="mt-2" />
    <x-input-error-auth :messages="$errors->get('email')" class="mt-2" />
    <x-input-error-auth :messages="$errors->get('password')" class="mt-2" />
    <x-input-error-auth :messages="$errors->get('password_confirmation')" class="mt-2" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Имя')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтверждение')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Уже зарегистрированы?') }}
            </a>

            <x-primary-button class="ms-4" name="Зарегистрировать">
                Зарегистрировать
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
