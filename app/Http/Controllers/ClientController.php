<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;
use App\Models\UserReview;
use ProtoneMedia\Splade\Facades\Toast;

use App\Models\Wishlist;
use App\Models\ProfileCustomization;
use Illuminate\Support\Facades\File;

use ProtoneMedia\Splade\Facades\SEO;

class ClientController extends Controller
{
    public function home (){
        // fetch wishlist items associated with the current user
        $wishlistGameIds = Wishlist::where('user_id', Auth::user()->id)->pluck('game_id');
  
        SEO::title('genie')
            ->description('The one game tracker to rule them all!')
            ->keywords('gaming, database, tracker');

        return view('home', ['wishlistGameIds' => $wishlistGameIds]);
      }
  

    public function create(){
        return view('create'); 
    }


    // store for after creating a custom game
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
    // else for if no image file was found in the request
    return redirect()->back()->with('error', 'No image found to upload.');
    }
    

    // home page, displays games in cards component based on their id, and fetches the info from the api
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


    // editing the custom game info
    public function edit (Items $item){
        return view('edit',['item'=>$item]);
    }


    // uploading the custom game edit info
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
    

    // delete a game from the users collection
    public function destroy(Items $item){
        $item->delete();
        return redirect()->back()->with('message', 'Item deleted');
    }


    // the view when a user clicks a game card and loads the detailed game info, fetches the info from the api call
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

    // logic for adding a game to the users collection
    public function test(Request $request)
    {
        $gameId = $request->input('gameId');
    
        //  if the game already exists in the user's wishlist
        $wishlistEntry = Wishlist::where('user_id', Auth::user()->id)
                                    ->where('game_id', $gameId)
                                    ->first();
    
        // if the game already exists in the wishlist, return corresponding message
        if ($wishlistEntry) {
            return response()->json('This game is already in your collection!');
        }
    
        // if the game does not exist in the user's wishlist, add it
        try {
            $wishlistEntry = Wishlist::create([
                'user_id' => Auth::user()->id,
                'game_id' => $gameId,
            ]);
        } catch (\Exception $e) {
            // if there are any errors during insertion, return a generic error message
            return response()->json(['Something went wrong. Please try again.']);
        }
    
        // if the game is successfully added to the wishlist, return success message
        if ($wishlistEntry) {
            return response()->json('Game added to collection!');
        } else {
            // if insertion fails for some reason, return a generic error message
            return response()->json('Something went wrong. Please try again.');
        }
    }


    // delete method 
    public function delete($gameId) {
        try {
            // iind the game in the wishlist by both the user ID and the game ID
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

    // not found page
    public function notFound()
    {
        return view('notFound'); 
    }
    
    // search page, contains the search component to fetch game search info from api
    public function search()
    {
        return view('search'); 
    }

    // user profile customize page
    public function customize()
    {
        // Get the user's wishlist game IDs
        $wishlistGameIds = auth()->user()->wishlist->pluck('game_id')->toArray();
        
        // Assuming you have a service or method to fetch games from the API
        $games = $this->fetchGamesFromApi($wishlistGameIds);
    
        return view('customizeProfile', compact('games'));
    }


    private function fetchGamesFromApi($gameIds)
{
    $games = []; // Initialize an empty array to store the games

    // Loop through the game IDs and make API requests to fetch each game
    foreach ($gameIds as $gameId) {
        // Assuming you're using a method to send API requests
        $apiResponse = $this->sendApiRequest($gameId);

        // If the API response is successful, add the game to the games array
        if ($apiResponse && isset($apiResponse['name'])) {
            $games[$gameId] = $apiResponse['name']; // Adjust based on the response structure
        }
    }

    return $games;
}

// Example function to send API requests
private function sendApiRequest($gameId)
{
    // Replace this with your actual API request logic
    $apiUrl = "https://api.rawg.io/api/games/{$gameId}?key=36e199df12d14562ad36f3befadf81d5";
    
    try {
        $response = Http::get($apiUrl);
        return $response->json();
    } catch (\Exception $e) {
        // Handle API errors or log them
        return null;
    }
}


    // handling the data for the profile customization
    public function customizeupdate(Request $request)
    {
        $user = auth()->user();
    
        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'summary' => 'nullable|string|max:255',
            'showcase_game_id' => 'nullable|integer|exists:wishlists,game_id', // Validate the game ID
        ]);
    
        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $userId = $user->id;
    
                if ($user->profileCustomization && File::exists(public_path('profilePictures/' . $user->profileCustomization->profile_picture))) {
                    File::delete(public_path('profilePictures/' . $user->profileCustomization->profile_picture));
                }
    
                $fileName = $userId . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('profilePictures'), $fileName);
                $validatedData['profile_picture'] = $fileName;
            }
    
            if ($request->filled('summary')) {
                $validatedData['description'] = $request->input('summary');
            }
    
            $profileCustomization = ProfileCustomization::updateOrCreate(
                ['user_id' => $user->id],
                $validatedData
            );
    
            $profileCustomization->showcase_game_id = $request->input('showcase_game_id');
            $profileCustomization->save();
    
            Toast::title('Profile updated!')->autoDismiss(5)->leftBottom();
        } catch (Exception $e) {
            Toast::title('Error updating profile')->autoDismiss(5)->leftBottom();
        }
    
        return redirect()->route('profileview')->with('success', 'Profile updated successfully!');
    }
    
    
    
    public function profileview()
    {
        
    $user = auth()->user();

    // get the profile customization for the user
    $profileCustomization = $user->profileCustomization;

    // if profile customization exists, get the description, otherwise set it to empty string
    $description = $profileCustomization ? $profileCustomization->description : '';
    $showcaseGameId = $profileCustomization ? $profileCustomization->showcase_game_id : null;

    // Pass both 'description' and 'showcase_game_id' to the view
    return view('profileview', compact('description', 'showcaseGameId'));
    }

    // submit rating to database
    public function submitRating(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'gameId' => 'required|integer', 
            'rating' => 'required|integer|min:1|max:5', 
        ]);
    
        
        $gameId = $request->input('gameId');
        $rating = $request->input('rating');
    
        
        $userId = auth()->id(); 
    
        // Check if a user review for the specified game already exists
        $userReview = UserReview::where('user_id', $userId)
                                ->where('game_id', $gameId)
                                ->first();
    
        if ($userReview) {
            // If a user review exists, update its rating
            $userReview->rating = $rating;
            $userReview->save();
    
            return response()->json(['message' => 'Rating updated successfully'], 200);
        } else {
            // if no user review exists, create a new one
            $userReview = new UserReview();
            $userReview->user_id = $userId;
            $userReview->game_id = $gameId;
            $userReview->rating = $rating;
            $userReview->save();
    
            // Check if the rating was updated or added
            $message = $userReview->wasRecentlyCreated ? 'Rating submitted successfully' : 'Rating updated successfully';
            return response()->json(['message' => $message], 200);
        }
    }
    
    public function getAverageRating($gameId)
    {
        // get the average rating for the specified game forom  database
        $averageRating = UserReview::where('game_id', $gameId)->avg('rating');

        // Return the average rating as a JSON response
        return response()->json(['averageRating' => $averageRating]);
    }
    



    public function submitReview(Request $request)
    {
        $validated = $request->validate([
            'gameId' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);
    
        $userId = auth()->id();
        $gameId = $validated['gameId'];
        $rating = $validated['rating'];
        $reviewText = $validated['review'];
    
        // check if a user review for the specified game already exists
        $userReview = UserReview::where('user_id', $userId)
                                 ->where('game_id', $gameId)
                                 ->first();
    
        if ($userReview) {
            // update the existing review
            $userReview->rating = $rating;
            $userReview->review = $reviewText;
            $userReview->save();
            $message = 'Review updated successfully';
        } else {
            // create  new review
            $userReview = new UserReview();
            $userReview->user_id = $userId;
            $userReview->game_id = $gameId;
            $userReview->rating = $rating;
            $userReview->review = $reviewText;
            $userReview->save();
            $message = 'Review submitted successfully';
        }
    
        return response()->json(['message' => $message], 200);
    }
    




    public function getReviews($gameId)
    {
        $reviews = UserReview::where('game_id', $gameId)->with('user')->get();

        return response()->json($reviews);
    }

    public function updateShowcase(Request $request)
{
    $request->validate([
        'showcase_game_id' => 'required|integer',
    ]);

    $user = auth()->user();
    $user->showcase_game_id = $request->input('showcase_game_id');
    $user->save();

    return redirect()->route('profile.edit')->with('status', 'Showcase game updated!');
}

public function getShowcaseGame()
{
    $user = auth()->user();
    return response()->json(['game_id' => $user->showcase_game_id]);
}

}
