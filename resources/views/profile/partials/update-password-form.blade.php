<section>
    <header>
        <h1 class="content-heading  heading1">
            {{ __('Update Password') }}
        </h1>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <x-splade-form method="put" :action="route('password.update')" class="mt-6 space-y-6" preserve-scroll>
        <x-splade-input id="current_password" name="current_password" type="password" :label="__('Current Password')" autocomplete="current-password" class="custom-label" />
        <x-splade-input id="password" name="password" type="password" :label="__('New Password')" autocomplete="new-password"  class="custom-label"/>
        <x-splade-input id="password_confirmation" name="password_confirmation" type="password" :label="__('Confirm Password')" autocomplete="new-password" class="custom-label"/>

        <div class="flex items-center gap-4">
            <x-splade-submit :label="__('Save')" class="profileButton my-btn-2 bg-transparent hover:bg-gray-200 text-gray-800" />


            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </x-splade-form>
</section>
