<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="pb-12 bg-maintheme mb-20">
        <div class="w-full mx-auto">
            <h1 class="content-heading text-center heading1 mb-4 mt-10">customize your profile </h1>
            <br>

            <div class="customizeprofile"></div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-24">
                <div class="p-4 sm:p-8 bg-maintheme shadow sm:rounded-none profilesection">
                    <div class="profileform" dusk="update-profile-information">
                        <x-splade-form action="{{ route('customizeupdate') }}" method="POST">

                            <!-- Avatar Upload -->
                            <x-splade-file name="avatar" :show-filename="false" filepond label="Profile avatar" class="formfield" />
                            <img v-if="form.avatar" :src="form.$fileAsUrl('avatar')" style="max-width: 200px; max-height: 200px;" />
                            <br><br>

                            <!-- Description -->
                            <x-splade-textarea name="summary" autosize label="Description" class="formfield" />

                            <!-- Game Showcase Dropdown -->
                            <x-splade-select name="showcase_game_id" label="Showcase a Game" :options="$games" placeholder="Select a game" />

                            <!-- Submit Button -->
                            <x-splade-submit label="Save" class="profileButton my-btn-2 bg-transparent hover:bg-gray-200 text-gray-800 mt-10" />
                        </x-splade-form>

                        <!-- Debugging output -->
                        <pre>{{ json_encode(request()->all(), JSON_PRETTY_PRINT) }}</pre>

                        <Link href="{{ route('profileview') }}">
                            <button class="my-btn-2 mt-2">Back</button>
                        </Link>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
