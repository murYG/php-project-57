<x-guest-layout>
    <h2 class="text-center"><a href="{{ route('welcome') }}">Менеджер задач</a></h2>
    
    <!-- Session Status -->
    <!-- Validation Errors -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <x-input-error-auth :messages="$errors->get('email')" class="mt-2" />
    <x-input-error-auth :messages="$errors->get('password')" class="mt-2" />        

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>       

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Запомнить меня') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
            @endif

            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">{{ __('Войти') }}</button>
        </div>      
    </form>
</x-guest-layout>
