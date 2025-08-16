<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div x-data="{show:false}" class="relative">
                <x-text-input id="update_password_current_password"
                    name="current_password"
                    type="password"
                    x-bind:type="show ? 'text':'password'"
                    class="mt-1 block w-full pr-10"
                    autocomplete="current-password" />
                <button type="button" @click="show=!show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.592m3.26-2.224A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.249 2.592M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3L3 3m9 9l9 9"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div x-data="{show:false}" class="relative">
                <x-text-input id="update_password_password"
                    name="password"
                    type="password"
                    x-bind:type="show ? 'text':'password'"
                    class="mt-1 block w-full pr-10" autocomplete="new-password" />
                <button type="button" @click="show=!show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.592m3.26-2.224A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.249 2.592M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3L3 3m9 9l9 9"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div x-data="{show:false}" class="relative">
                <x-text-input id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    x-bind:type="show ? 'text':'password'"
                    class="mt-1 block w-full pr-10" autocomplete="new-password" />
                <button type="button" @click="show=!show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.592m3.26-2.224A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.249 2.592M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3L3 3m9 9l9 9"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
