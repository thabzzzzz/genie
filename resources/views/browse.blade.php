<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
            <h1 class="content-heading heading1">Browse Items</h1>
            <br>
            
               
                <ProductCard :games="{{ json_encode($games) }}"></ProductCard>
                
           
        </div>
    </div>
</x-app-layout>
