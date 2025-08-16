<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div x-data="{show:false}" class="relative">
                <x-text-input id="password" type="password" x-bind:type="show ? 'text':'password'"
                    class="block mt-1 w-full pr-10"
                    name="password" required autocomplete="current-password" />
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
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
