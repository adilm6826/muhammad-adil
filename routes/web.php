<?php

use App\Http\Controllers\FormOneController;
use App\Http\Controllers\FormSecondController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Begin:   Muhammad Adil Task Sub-Task 0.2

    // Begin: Route for first form
        // Route to show the first form
        Route::get('/firstForm',[FormOneController::class,'index'])->name('first-form.show');
        // Post Route for the first form to remove the space
        Route::post('/remove/space',[FormOneController::class,'remove_space'])->name('frist-form.remove-space');
    // End: Route for first form

    // //////////////////////
    // Begin: Route for second form
        // Route to show the 2nd form
        Route::get('/secondForm',[FormSecondController::class,'index'])->name('second-form.show');
        // Post Route for the 2nd form to coun the words from the given paragraph
        Route::post('/secondform/words/counts',[FormSecondController::class,'count_words'])->name('second-form.count_words');
    // End: Route for second form
// End:    Muhammad Adil Task Sub-Task 0.2
