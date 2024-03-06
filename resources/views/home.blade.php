<x-app-layout>
    

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto  ">
            <h1 class="content-heading heading1">your wishlist</h1>
            <br>

            <Link href="/create"> <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg></Link>
           
              <br>
            <h1>Balance: R{{$itemsprice}} </h1>
            <br>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
                @foreach($items as $item)
                <div class="col">
                    <div class="card product-card">
                        <img src="uploads/{{ $item->itemimage }}" class="card-img-top" alt="product image">
                        <div class="card-body product-card-body">
                            <h5 class="card-title">{{ $item->iname }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <p class="card-price">R {{ number_format($item->price, 2, ',', ' ') }}</p>
                            <div class="card-buttons">
                                <a href="{{ $item->itemsite }}" class="btn" target="_blank">Visit Site</a>
                                <a href="{{ route('item.edit',['item'=>$item]) }}" class="btn" title="Edit">Edit</a>
                                <form class="delete-form" method="post" action="{{ route('item.destroy',['item'=>$item]) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn" title="Delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
    
</x-app-layout>
