<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="pb-12 bg-maintheme">
        <div class="w-full mx-auto   ">
            <h1 class="content-heading heading1 text-center pt-6">trending games</h1>
            <br>
            
               
                <ProductCard :games="{{ json_encode($games) }}"></ProductCard>
                
           
        </div>
    </div>
</x-app-layout>
