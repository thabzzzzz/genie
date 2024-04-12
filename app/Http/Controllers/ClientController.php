<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;
use ProtoneMedia\Splade\Facades\Toast;

use App\Models\Wishlist;
use App\Models\ProfileCustomization;

class ClientController extends Controller
{
    public function home (){
        // Fetch wishlist items associated with the current user
        $wishlistGameIds = Wishlist::where('user_id', Auth::user()->id)->pluck('game_id');
  
        // Debug to ensure you're getting the correct data
      
    
        // Pass wishlist game IDs to the view
        return view('home', ['wishlistGameIds' => $wishlistGameIds]);
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
    
        // Check if the game already exists in the user's wishlist
        $wishlistEntry = Wishlist::where('user_id', Auth::user()->id)
                                    ->where('game_id', $gameId)
                                    ->first();
    
        // If the game already exists in the wishlist, return corresponding message
        if ($wishlistEntry) {
            return response()->json('This game is already in your collection!');
        }
    
        // If the game does not exist in the user's wishlist, add it
        try {
            $wishlistEntry = Wishlist::create([
                'user_id' => Auth::user()->id,
                'game_id' => $gameId,
            ]);
        } catch (\Exception $e) {
            // If there are any errors during insertion, return a generic error message
            return response()->json(['Something went wrong. Please try again.']);
        }
    
        // If the game is successfully added to the wishlist, return success message
        if ($wishlistEntry) {
            return response()->json('Game added to collection!');
        } else {
            // If insertion fails for some reason, return a generic error message
            return response()->json('Something went wrong. Please try again.');
        }
    }

    public function delete($gameId) {
        try {
            // Find the game in the wishlist by both the user ID and the game ID
            $game = Wishlist::where('game_id', $gameId)
                            ->where('user_id', Auth::user()->id)
                            ->first();
            
            if (!$game) {
                return response()->json(['message' => 'Game not found'], 404);
            }
            
            // Perform deletion
            $game->delete();
            
            return response()->json(['message' => 'Game deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete game', 'error' => $e->getMessage()], 500);
        }
    }

    public function notFound()
    {
        return view('notFound'); 
    }
    
    public function search()
    {
        return view('search'); 
    }

    public function customize()
    {
        return view('customizeProfile'); 
    }

    public function customizeupdate(Request $request)
    {
        $user = auth()->user(); // Assuming you have user authentication
    
        $validatedData = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validation rules for image
            'summary' => 'nullable|string|max:255', // Optional description validation
        ]);
    
        // Handle image upload
        if ($request->hasFile('avatar')) {
            $fileName = uniqid() . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->storeAs('profilePictures', $fileName, 'public');
            $validatedData['profile_picture'] = $fileName;
 // Store in public/profilePictures
    
            // Save filename to the profile_customizations table
            $profileCustomization = ProfileCustomization::updateOrCreate(
                ['user_id' => $user->id], // Find or create a record for the user
                ['profile_picture' => $fileName] // Update or insert the avatar filename
            );
        }
    
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
    

    
    
}
