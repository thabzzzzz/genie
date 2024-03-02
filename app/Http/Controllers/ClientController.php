<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;
use ProtoneMedia\Splade\Facades\Toast;

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
        $apiKey = 'mzphnefd8jmf3d5d569scw2z0xjx93'; // Replace with your actual Client ID
        $accessToken = 'zz12wws7n9otva78pvmw32giaftmww'; // Replace with your actual Access Token
    
        $response = Http::withHeaders([
            'Client-ID' => $apiKey,
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post('https://api.igdb.com/v4/games/?fields=name,summary,cover.url,url&order=popularity:desc&limit=50&name=*
        ', [
            'fields' => 'name, summary', // Include both name and summary fields
            'limit' => 50,
        ]);
       
        $games = $response->json();
       
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

    
}
