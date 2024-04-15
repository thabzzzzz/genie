<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="pb-12 bg-maintheme">
        <div class="w-full mx-auto   ">
            <h1 class="content-heading text-center heading1 mb-4 mt-10">profile page</h1>
            <br>
           
       


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-24">
                <div class="p-4 sm:p-8 bg-maintheme shadow sm:rounded-none profilesection">
                    <div class="profileform" dusk="update-profile-information">
                        <div class=""><h1>{{ Auth::user()->name }}</h1></div>
                        <div class="profile-picture-container">

                            @if (Auth::user()->profileCustomization)
                            <img src="{{ asset('profilePictures/' . Auth::user()->profileCustomization->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('profilePictures/profile_picture.jpg') }}" alt="Default Profile Picture" class="w-full h-full object-cover">
                        @endif

                        </div>
                    </div>
                </div>
            </div>


            
           
                
           
        </div>
    </div>
</x-app-layout>