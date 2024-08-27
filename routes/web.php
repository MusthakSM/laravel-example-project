<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('test', function (){
    dispatch(function (){
        logger("Hello from the queue");
    })->delay(5);
    return "Done";
});


// Route for home..
Route::view('/', 'home');

// Route for Contact view..
Route::view('/contact', 'contact');

//// Route Controller for JobCOntroller
//Route::controller(JobController::class)->group(function(){
//     // Route for Jobs index view
//     Route::get('/jobs', 'index');
//     // Route for Jobs create view
//     Route::get('/jobs/create', 'create');
//     // Route for Jobs show view
//     Route::get('/jobs/{job}', 'show');
//     // Route to store the Job in the db.
//     Route::post('/jobs', 'store');
//     // Route to job edit view
//     Route::get('/jobs/{job}/edit', 'edit');
//     // Route to update the job in the db
//     Route::patch('/jobs/{job}', 'update');
//     //Route to Delete a job from db
//     Route::delete('/jobs/{job}', 'delete');
//});                                                         // This entire block can be replaced by Route::resource
//
//Route::resource('jobs', JobController::class, [
//    'except' => ['destroy']         // another method is 'only' which specifies the routes that should be initiated by the resource
//])->middleware('auth');

// Route for Jobs index view
Route::get('/jobs', [JobController::class, 'index']);
// Route for Jobs create view
Route::get('/jobs/create', [JobController::class, 'create']);
// Route for Jobs show view
Route::get('/jobs/{job}', [JobController::class, 'show']);
// Route to store the Job in the db.
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
// Route to job edit view
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware('auth')
    ->can('edit', 'job');
// Route to update the job in the db
Route::patch('/jobs/{job}', [JobController::class, 'update']);
//Route to Delete a job from db
Route::delete('/jobs/{job}', [JobController::class, 'delete']);

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

// Session..
Route::get('/login' , [SessionController::class, 'create'])->name('login');
Route::post('/login' , [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
