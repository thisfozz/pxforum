<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="login" :value="__(key: 'Login')" />
            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="login"/>
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center mt-4">
            <x-primary-button class="w-auto px-6 py-2">
                {{ __('Register') }}
            </x-primary-button>

            <div class="mt-3 text-center">
                <small class="text-black">Already registered? 
                    <a href="{{ route('login') }}" class="underline text-sm text-black hover:text-dark-300">
                        {{ __('Sign in') }}
                    </a>
                </small>
            </div>
        </div>
    </form>
</x-guest-layout>