<section class="space-y-6">
    <header>
        <h1 class="content-heading  heading1">
            {{ __('Delete Account') }}
        </h1>

        <p class="mt-1 text-sm text-black-600 ">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

     <x-splade-form
        method="delete"
        :action="route('profile.destroy')"
      
        
    >
        <x-splade-submit danger :label="__('Delete Account')" 
        class="profileButton my-btn-2"
        />
    </x-splade-form>
</section>
