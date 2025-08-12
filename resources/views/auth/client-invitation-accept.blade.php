<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold">Activate Your Account</h2>
        <p class="text-sm text-gray-600">Welcome! Please set a password to access your client portal.</p>
    </div>

    <form method="POST" action="{{ route('client.invitation.store') }}">
        @csrf

        <!-- Invitation Token (Hidden) -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Activate Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
