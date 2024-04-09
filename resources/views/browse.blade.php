<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="pb-12 bg-maintheme">
        <div class="w-full mx-auto   ">
            <h1 class="content-heading text-center heading1 mb-4 mt-10">trending games</h1>
            <br>
           
               
                <ProductCard :games="{{ json_encode($games) }}"></ProductCard>
                
           
        </div>
    </div>
</x-app-layout>
