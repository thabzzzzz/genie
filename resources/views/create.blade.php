<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto sm:px-6 lg:px-12 ">
            <h1 class="content-heading heading1">create an item</h1>
            <br>
      
           <br>

           <div class="create-form w-64">
            

            <x-splade-form action="{{ route('storeitem') }}" method="post" enctype="multipart/form-data">
              @csrf
          
              <x-splade-input name="iname" label="Name"  class=""/>
          
              <x-splade-input name="price" type="number" label="Price" />
          
              <x-splade-input name="itemsite" label="Website" />
          
              <x-splade-input name="description" type="textarea" label="Description" />
          
              <x-splade-file name="image" label="Image" />
          
              <x-splade-submit class="my-btn upload-btn mt-5">Upload</x-splade-submit>
            </x-splade-form>
          
            <br>
          
            <Link href="/home" class="back-text link-container">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                    <path id="icon-path" strokeLinecap="round" strokeLinejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                
            </Link>
            
            
        
           </div>
          
            
        </div>
    </div>
</x-app-layout>