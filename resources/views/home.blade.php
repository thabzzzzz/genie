<x-app-layout>
    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto">
            <h1 class="content-heading text-center heading1 mb-5 ">your collection</h1>
            <br>
           
            <x-splade-rehydrate >
            <homeGameCard :wishlistGameIds="{{ json_encode($wishlistGameIds) }}"></homeGameCard>
            </x-splade-rehydrate> 
            
        </div>
    </div>
</x-app-layout>
