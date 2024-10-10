<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl">All Users</h1>
    </x-slot>

    <div class="pb-12 bg-maintheme">
        <div class="w-full mx-auto">
            <h1 class="content-heading text-center heading1 mb-4 mt-10">All Users</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6 p-4">
                @foreach($users as $user)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                        <a href="{{ url('/user/' . $user->id) }}" class="flex flex-col items-center p-4">
                            <div class="profile-picture-container mb-2">
                                <img src="{{ asset('profilePictures/' . ($user->profileCustomization->profile_picture ?? 'profile_picture.jpg')) }}" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 object-cover rounded-full border-2 border-gray-300 shadow-md">
                            </div>
                            <h2 class="text-lg font-semibold text-center text-gray-800">{{ $user->name }}</h2>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
