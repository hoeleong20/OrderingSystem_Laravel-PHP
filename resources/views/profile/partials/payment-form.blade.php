<!-- Author : Ting Jian Hao -->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Bank Account Number') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Enter your bank account details for validation and saving.') }}
        </p>
    </header>

    <!-- Account Number -->
    <form method="POST" action="{{ route('profile.verifyBank') }}">
        @csrf
        <!-- Account Number -->
        <div>
            <x-input-label for="account_number" :value="__('Account Number')" />
            <x-text-input id="account_number" name="account_number" type="text" class="mt-1 block w-full" :value="old('account_number',  $user->account_number ? Crypt::decryptString($user->account_number) : '')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'payment-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Bank Account Saved.') }}</p>
            @endif

            @if (session('status') === 'invalid-account-number')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-red-600 dark:text-red-400">{{ __('Invalid Account Number.') }}</p>
            @endif
        </div>
    </form>
</section>