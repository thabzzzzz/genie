<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto   ">
           
            <br>
            
            
            <GameDetail :game-detail="{{ json_encode($gameDetail) }}"></GameDetail>
                
        </div>
    </div>
</x-app-layout>
