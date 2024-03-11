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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  mt-10">
                @foreach($items as $item)
                <div class="col">
                    <div class="card product-card">
                        <div class="relative">
                            <img src="uploads/{{ $item->itemimage }}" class="card-img-top" alt="product image">
                            <div class="card-buttons">
                                <a href="{{ $item->itemsite }}" class="my-btn-2" target="_blank"><img src="site-images/cardicons/globe2.svg" alt=""></a>
                                <a href="{{ route('item.edit',['item'=>$item]) }}" class="my-btn-2" title="Edit"><img src="site-images/cardicons/pencil-fill.svg" alt=""></a>
                                <form class="delete-form" method="post" action="{{ route('item.destroy',['item'=>$item]) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="my-btn-2" title="Delete"><img src="site-images/cardicons/trash-fill.svg" alt=""></button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body product-card-body bg-maintheme">
                            <p class="card-title">{{ $item->iname }}</p>
                            <p class="card-text">
                              
                              </p>
                              <br>
                          
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
    
</x-app-layout>
