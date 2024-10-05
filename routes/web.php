<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return response()->json("email verified",200);
// })->middleware(['auth:api', 'signed'])->name('verification.verify');


Route::get('/frank',function(EmailVerificationRequest $request){
    dd($request);
});


// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     dd($request);
//     try{

//         $request->fulfill();  // Verify the user
        
//         // Return the newly created view
//         return view('auth.verified');
//     }catch (Exception $e){
//         \Log::error($e->getMessage());
//         dd($e);
//     }
// })->middleware(['signed'])->name('verification.verify');

Route::get('/', function () {
    return view('welcome');
});
