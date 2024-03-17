<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;
use ProtoneMedia\Splade\Facades\Toast;

use App\Models\Wishlist;

class ClientController extends Controller
{
    public function home (){
        $items=Items::where('client', Auth::user()->name )->get();
        $itemsprice=  number_format(Items::where('client', Auth::user()->name )->sum('price'), 2, ',', ' ');
        return view('home',['items'=>$items,'itemsprice'=>$itemsprice]);
    }

    public function create(){
        return view('create'); 
    }

    public function storeitem(Request $request){
        

       
    $request->validate([
        'iname' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    $name = $request->input('iname');

    if ($request->hasFile('image')) {
        $image = $request->file('image');




     
        $imageName = time() . '_' . $image->getClientOriginalName();

        
        $image->move(public_path('uploads'), $imageName);

      
        $item = new Items;
        $item->iname=request('iname');
        $item->client = Auth::user()->name ;
      
        $item->price = request('price');
        
        $item->itemsite = request('itemsite');
        $item->description = request('description');

        $item->itemimage =$imageName;
        if ($item->save()) {
            Toast::title('Item added!')->autoDismiss(5)->rightBottom();
             
        }
    }

    

    // Handle if no image file was found in the request
    return redirect()->back()->with('error', 'No image found to upload.');
    }
    
    public function browse()
    {
        $apiKey = '36e199df12d14562ad36f3befadf81d5'; 
    
        $response = Http::withHeaders([
            'User-Agent' => 'genie',
            'Content-Type' => 'application/json',
        ])->get('https://api.rawg.io/api/games', [
            'key' => $apiKey, 
            'ordering' => '-added', 
            'page_size' => 50, 
        ]);
    
        $games = $response->json()['results'];
      
        return view('browse', ['games' => $games]);
    }

    public function edit (Items $item){
        return view('edit',['item'=>$item]);
    }

    public function update(Items $item, Request $request)
    {
        $data = $request->validate([
            'iname' => '',
            'price' => 'numeric',
            'itemsite' => '',
            'description' => '',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
    
            
            $data['itemimage'] = $imageName;
        }
    
        $item->update($data);
    
        return redirect()->back()->with('message', 'Item updated');
    }
    

    public function destroy(Items $item){
        $item->delete();
        return redirect()->back()->with('message', 'Item deleted');
    }
    public function gamedetail($id)
    {
        $apiKey = '36e199df12d14562ad36f3befadf81d5'; 
    
        
        $response = Http::withHeaders([
            'User-Agent' => 'genie',
            'Content-Type' => 'application/json',
        ])->get("https://api.rawg.io/api/games/{$id}", [
            'key' => $apiKey, 
        ]);
    
        $gameDetail = $response->json();
       
        return view('gamedetail', ['gameDetail' => $gameDetail]);
    }


    public function test(Request $request)
    {
        $gameId = $request->input('gameId');
    
        // Validate the gameId if needed
    
        // Create a new Wishlist entry for the user
        $wishlistEntry = Wishlist::create([
            'user_id' => Auth::user()->id, // Assuming you have user authentication
            'game_id' => $gameId,
        ]);
    
        // Respond with a success message or data (optional)
        return response()->json(['message' => 'Game added to wishlist!']);
    }
    
    
}
