<x-app-layout>
    

    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto sm:px-6 lg:px-8 ">
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
                    <div class="card border border-black mx-auto product-card" style="width: 21rem;">
                        <img src="uploads/{{ $item->itemimage }}" class="card-img-top " alt="product image">
                        <div class="card-body product-card-body p-2">
                            <b class="card-title">{{ $item->iname }}</b>
                            <div class="description-text"><i class="card-text">{{ $item->description }}</i></div>
                            <span class="card-price">R {{ number_format($item->price, 2, ',', ' ') }}</span>
                            <br>
                            <br>
                            <span>
                                <a href="{{ $item->itemsite }}" class="btn my-btn-2 text-black inline-block mr-1" target="_blank" title="Visit site">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                    </svg>
                                </a>
                            </span>
                            
                            <span>
                                <a title="Edit" href="{{ route('item.edit',['item'=>$item]) }}" class="btn my-btn-2 text-black inline-block mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </span>
                            
                            <span>
                                <form class="delete-form" method="post" action="{{ route('item.destroy',['item'=>$item]) }}" class="inline-block">
                                    @csrf
                                    @method('delete')
                                    <button title="Delete" type="submit" class="my-btn-2 btn text-black inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </span>
                            
                           
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
</x-app-layout>
