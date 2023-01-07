<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Ваши данные') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Обновите Ваши данные и email адрес.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post"
            action="{{ route('profile.update') }}"
            class="mt-6 space-y-6"
            enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Имя')" />
            <x-text-input id="name" name="name" maxlength="50" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Имя пользователя')" />
            <x-text-input id="username" name="username" maxlength="50" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="user_desc" :value="__('Коротко о себе (не более 100 символов, будет видно всем)')" />
            <x-text-input id="user_desc" name="user_desc" maxlength="100" type="text" class="mt-1 block w-full" :value="old('user_desc', $user->user_desc)" autofocus autocomplete="user_desc" />
            <x-input-error class="mt-2" :messages="$errors->get('user_desc')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" maxlength="100" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <label for="avatar">Фото должно быть не более 100kb и соотношение сторон 1/1</label>
        <div class="flex">

            <input type="file" name="avatar"
                class="rounded-md shadow-sm mt-1 block w-full" @error('avatar') @enderror
                id="avatar">

            <img class="rounded-circle"
                    src="{{ $user->avatar }}"
                    width="50"
                    alt="Your avatar">
        </div>
        @error('avatar')
            <span class="laravel-alert">{{ $errors->first('avatar') }}</span>
        @enderror


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
