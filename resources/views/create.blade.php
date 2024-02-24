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
            <p>create</p>
           <br>

           <div class="create-form w-56">
            <h1 class="create-item-text">Create Item</h1>

            <x-splade-form action="{{ route('storeitem') }}" method="post" enctype="multipart/form-data">
              @csrf
          
              <x-splade-input name="iname" label="Name" />
          
              <x-splade-input name="price" type="number" label="Price" />
          
              <x-splade-input name="itemsite" label="Website" />
          
              <x-splade-input name="description" type="textarea" label="Description" />
          
              <x-splade-file name="image" label="Image" />
          
              <x-splade-submit class="my-btn upload-btn">Upload</x-splade-submit>
            </x-splade-form>
          
            <br>
          
            <a href="/client" class="back-text"><i class="bi bi-arrow-left-circle-fill back-icon"></i> Back</a>
          
            @if (session()->has('message'))
              <div class="alert alert-success">
                {{ session()->get('message') }}
              </div>
            @endif
          
            @if ($errors->any())
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            @endif
           </div>
          
            
        </div>
    </div>
</x-app-layout>