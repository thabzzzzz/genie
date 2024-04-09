<section>
    <header>
        <h1 class="content-heading  heading1 ">
            {{ __('Profile Information') }}
        </h1>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <x-splade-form method="patch" :action="route('profile.update')" :default="$user" class="mt-6 space-y-6" preserve-scroll>
        <x-splade-input id="name" name="name" type="text" :label="__('Name')" required autofocus autocomplete="name" class="custom-label"/>
        <x-splade-input id="email" name="email" type="email" :label="__('Email')" required autocomplete="email" class="custom-label"/>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <Link method="post" href="{{ route('verification.send') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </Link>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-splade-submit :label="__('Save')" 
            class="profileButton my-btn-2 bg-transparent hover:bg-gray-200 text-gray-800"
            />

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </x-splade-form>
</section>
