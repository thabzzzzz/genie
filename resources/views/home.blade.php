<x-app-layout>
    

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
            <h1 class="content-heading heading1">your wishlist</h1>
            <br>

            <Link href="/create"> <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg></Link>
           
              <br>
            <strong>Balance: R{{$itemsprice}} </strong>
            <br>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
                @foreach($items as $item)
                <div class="col">
                    <div class="card border border-black rounded-lg mx-auto product-card" style="width: 21rem;">
                        <img src="uploads/{{ $item->itemimage }}" class="card-img-top rounded-lg" alt="product image">
                        <div class="card-body product-card-body">
                            <h5 class="card-title">{{ $item->iname }}</h5>
                            <div class="description-text"><i class="card-text">{{ $item->description }}</i></div>
                            <span><a href="{{ $item->itemsite }}" class="btn my-btn-2 text-black" target="_blank" title="Visit site"><i class="bi bi-globe"></i></a></span>
                            <span class="card-price">R {{ number_format($item->price, 2, ',', ' ') }}</span>
                           
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
</x-app-layout>
