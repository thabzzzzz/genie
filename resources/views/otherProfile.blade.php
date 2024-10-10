{{-- otherProfile.blade.php --}}
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="pb-12 bg-maintheme mb-32">
        <div class="w-full mx-auto">
            <h1 class="content-heading text-center heading1 mb-4 mt-10">{{ $user->name }}'s Profile</h1>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-maintheme shadow sm:rounded-none profilesection">

                    {{-- Profile Picture --}}
                    <div class="profile-picture-container">
                        @if ($profileCustomization)
                            <img src="{{ asset('profilePictures/' . $profileCustomization->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('profilePictures/profile_picture.jpg') }}" alt="Default Profile Picture" class="w-full h-full object-cover">
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="text-2xl mt-7">
                        <h1>About:</h1>
                        <p>{{ $description }}</p>
                    </div>

                    {{-- Favourite Game --}}
                    <div class="text-2xl mt-7">
                        <h1>Favourite Game:</h1>
                        <favouriteGame :showcase-game-id="{{ $showcaseGameId }}" image-url="{{ asset('site-images/images/favGame.jpg') }}"></favouriteGame>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
