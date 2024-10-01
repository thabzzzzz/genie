<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\Splade\Facades\SEO;
use ProtoneMedia\Splade\Components\Toast;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        SEO::title('genie')
        ->description('genie wishlist app')
        ->keywords('wishlist, organization');
        return view('welcome');
    });

    Route::get('/', function () {
        return redirect('/login');
    });

    Route::fallback([ClientController::class, 'notFound']);

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['verified'])->name('dashboard');

        Route::get('/dashboard', function () {
            return redirect('/home');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //my routes
        Route::get('/home',[ClientController::class,'home'])->name('home');

       
        Route::post('/storeitem',[ClientController::class,'storeitem'])->name('storeitem');

        Route::get('/browse',[ClientController::class,'browse'])->name('browse');


        //crud
        Route::get('/client/{item}/edit',[ClientController::class,'edit'])->name('item.edit');
        Route::put('/client/{item}/update',[ClientController::class,'update'])->name('item.update');
        Route::delete('/client/{item}/destroy',[ClientController::class,'destroy'])->name('item.destroy');
        Route::get('/gamedetail/{id}', [ClientController::class, 'gamedetail'])->name('gamedetail');

        //vue requests
        Route::post('/test', [ClientController::class, 'test'])->name('test');

        Route::delete('/api/games/{gameId}', [ClientController::class, 'delete'])->name('delete');
            
        Route::get('/search',[ClientController::class,'search'])->name('search');  

        Route::get('/customize',[ClientController::class,'customize'])->name('customize');  

        Route::post('/customize/update', [ClientController::class, 'customizeupdate'])->name('customizeupdate');
        
        Route::get('/profileview',[ClientController::class,'profileview'])->name('profileview'); 

        Route::post('/submitrating', [ClientController::class, 'submitRating'])->name('submitRating');
        Route::get('/average-rating/{gameId}', [ClientController::class, 'getAverageRating'])->name('average-rating');

        Route::post('/submitreview', [ClientController::class, 'submitreview'])->name('submitreview');
        Route::get('/game/{gameId}/reviews', [ClientController::class, 'getReviews']);

        //profile customization
        Route::post('/update-showcase', [ClientController::class, 'updateShowcase'])->name('update-showcase');
        Route::get('/showcase-game', [ClientController::class, 'getShowcaseGame'])->name('showcase-game');

        Route::get('/favourite-game/{gameId}', [ClientController::class, 'getFavouriteGame']);
Route::post('/save-favourite-game', [ClientController::class, 'saveFavouriteGame']);

//freind functions
Route::post('/friend-request', [ClientController::class, 'sendRequest']);
Route::post('/friend-request/{id}/accept', [ClientController::class, 'acceptRequest']);
Route::post('/friend-request/{id}/reject', [ClientController::class, 'rejectRequest']);
Route::get('/friend-requests/pending', [ClientController::class, 'pendingRequests']);


    });
   
    require __DIR__.'/auth.php';
});
