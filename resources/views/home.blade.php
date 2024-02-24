<x-app-layout>
    <x-slot name="header">
    
    </x-slot>

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
            <h1 class="content-heading heading1">your wishlist</h1>
            <br>

            <Link href="/create"> <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg></Link>
           
              <br>
            <strong>Balance: </strong>
        </div>
    </div>
    
</x-app-layout>
