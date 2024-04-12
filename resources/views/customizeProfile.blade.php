<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="pb-12 bg-maintheme">
        <div class="w-full mx-auto   ">
            <h1 class="content-heading text-center heading1 mb-4 mt-10">customize your profile</h1>
            <br>
           
            <div class="customizeprofile ">
                
                <x-splade-form class="w-72" action="{{ route('customizeupdate') }}">
                    
                    <x-splade-file name="avatar" :show-filename="false" filepond  label="Profile avatar"/>
                 
                    <img v-if="form.avatar" :src="form.$fileAsUrl('avatar')" />
                    <br>
                    <br>
                    <x-splade-textarea name="summary" autosize />

                    <x-splade-submit label="Save" />
                 </x-splade-form>

              
            </div> 
           
                
           
        </div>
    </div>
</x-app-layout>