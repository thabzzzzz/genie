<x-app-layout>
    
    <div class="flex justify-center items-center space-x-4"> <!-- Adjusted to center the items -->
        <h1 class="text-xl">{{ $user->name }}'s Profile</h1>
        <form action="{{ route('invite.send', $user->id) }}" method="POST"> <!-- Correct route for sending invite -->
            @csrf
            <button type="submit" class="my-btn-2">Invite</button>
        </form>
    </div>
    

    <div class="pb-12 bg-maintheme mb-32">
        <div class="w-full mx-auto">
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

    {{-- Toast Notifications --}}
    @if (session('toast'))
        <div class="toast-container fixed bottom-4 right-4 z-50">
            <div class="toast bg-{{ session('toast.type') }} text-white p-3 rounded-md mb-2">
                {{ session('toast.message') }}
            </div>
        </div>
    @endif
</x-app-layout>
