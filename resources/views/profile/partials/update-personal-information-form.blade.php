<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Личные данные') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Обновите свою личную информацию.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.avatar.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <div class="flex space-x-8">
            <div class="flex-shrink-0">
                <input type="file"
                       id="avatar"
                       name="avatar"
                       class="hidden"
                       accept="image/*"
                       onchange="this.form.submit(); document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])"/>
                       
                <label for="avatar" class="cursor-pointer block">
                    <div class="relative w-32 h-32">
                        <img id="avatar-preview"
                             class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-700"
                             src="{{ $userDetails && $userDetails->avatar_url ? asset('storage/' . $userDetails->avatar_url) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?d=mp&s=200' }}"
                             alt="Аватар профиля">
                    </div>
                </label>
            </div>

            <div class="flex-grow space-y-6">
                <div>
                    <x-input-label for="display_name" :value="__('Отображаемое имя')" />
                    <x-text-input id="display_name" 
                                 name="display_name" 
                                 type="text" 
                                 class="mt-1 block w-full" 
                                 :value="old('display_name', $user->display_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('display_name')" />
                </div>

                <div>
                    <x-input-label for="first_name" :value="__('Имя')" />
                    <x-text-input id="first_name" 
                                 name="first_name" 
                                 type="text" 
                                 class="mt-1 block w-full" 
                                 :value="old('first_name', $user->first_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <div>
                    <x-input-label for="last_name" :value="__('Фамилия')" />
                    <x-text-input id="last_name" 
                                 name="last_name" 
                                 type="text" 
                                 class="mt-1 block w-full" 
                                 :value="old('last_name', $user->last_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <div>
                    <x-input-label for="birthdate" :value="__('Дата рождения')" />
                    <x-text-input id="birthdate" 
                                 name="birthdate" 
                                 type="date" 
                                 class="mt-1 block w-full" 
                                 :value="old('birthdate', $user->birthdate)" />
                    <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Сохранено.') }}</p>
            @endif
        </div>
    </form>
</section> 

@if($userDetails)
    <div class="hidden">Debug: {{ $userDetails->avatar_url }}</div>
@endif 