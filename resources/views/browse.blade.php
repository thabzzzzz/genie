<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
            <h1 class="content-heading heading1">Browse Items</h1>
            <br>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
               
                <ProductCard :games="{{ json_encode($games) }}"></ProductCard>

            </div>
        </div>
    </div>
</x-app-layout>
