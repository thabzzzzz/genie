<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto   ">
            <h1 class="content-heading heading1 text-center text-2xl">trending games</h1>
            <br>
            
               
                <ProductCard :games="{{ json_encode($games) }}"></ProductCard>
                
           
        </div>
    </div>
</x-app-layout>
