<x-guest-layout>
    <h2 class="text-center"><a href="{{ route('welcome') }}">Менеджер задач</a></h2>

    <!-- Validation Errors -->
@if ($errors->get('name') || $errors->get('password') || $errors->get('email') || $errors->get('password_confirmation'))
    <div class="mb-4">
        <div class="font-medium text-red-600">{{ __('Упс! Что-то пошло не так:') }}</div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ((array) $errors->get('name') as $message)
                <li>{{ $message }}</li>
            @endforeach
            @foreach ((array) $errors->get('password') as $message)
                <li>{{ $message }}</li>
            @endforeach
            @foreach ((array) $errors->get('email') as $message)
                <li>{{ $message }}</li>
            @endforeach
            @foreach ((array) $errors->get('password_confirmation') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <label class="block font-medium text-sm text-gray-700" for="name">
                {{ __('Имя') }}
            </label>
            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus" value="{{ old('name') }}">
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="email">
                {{ __('Email') }}
            </label>
            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="email" type="email" name="email" required="required" value="{{ old('email') }}" >
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password">
                {{ __('Пароль') }}
            </label>
            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password_confirmation">
                {{ __('Подтверждение') }}
            </label>
            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password_confirmation" type="password" name="password_confirmation" required="required">
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Уже зарегистрированы?') }}
            </a>
            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">{{ __('Зарегистрировать') }}</button>
        </div>
    </form>
</x-guest-layout>
