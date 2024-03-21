<x-app-layout>
    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto">
            <h1 class="content-heading heading1">Your wishlist</h1>
            <br>
           
            
            <homeGameCard :wishlistGameIds="{{ json_encode($wishlistGameIds) }}"></homeGameCard>
                
            
        </div>
    </div>
</x-app-layout>
