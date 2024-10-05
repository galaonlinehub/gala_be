<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');
        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'fullname' => 'required|string|max:255',
            'password' => 'required|string|min:4',
            'highest_education_level' =>'required|string',
            'region_of_residence'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        try{
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'fullname' => $request->fullname,
                'region_of_residence' => $request->region_of_residence,
                'highest_education_level' => $request->highest_education_level,
                'password' => Hash::make($request->password),
            ]);

            // event(new Registered($user));
            $user->sendEmailVerificationNotification();

            $token = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'message' => 'User successfully registered',
                'token' => $token
            ], 201);}
            catch (\Exception $e) {
                return response()->json([
                    'message' => $e,
                    
                    // 'token' => $token
                ], 409);}
            }
    

    public function resendVerificationEmail(Request $request)
            {
                $user = User::where('email', $request->email)->first();
        
                if (!$user) {
                    return response()->json(['message' => 'User not found'], 404);
                }
        
                if ($user->hasVerifiedEmail()) {
                    return response()->json(['message' => 'Email already verified'], 400);
                }
        
                $user->sendEmailVerificationNotification();
        
                return response()->json(['message' => 'Verification email resent']);
            }
    

    public function redirectToProvider($provider)
    {
    return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
    $socialUser = Socialite::driver($provider)->stateless()->user();
    
    $user = User::updateOrCreate([
        'email' => $socialUser->getEmail(),
    ], [
        'username' => $socialUser->getName(),
        'provider' => $provider,
        'provider_id' => $socialUser->getId(),
    ]);

    $token = $user->createToken('MyApp')->accessToken;
    return response()->json(['token' => $token], 200);
}


public function mobileLogin(Request $request, $provider)
{
    $token = $request->input('access_token');
    
    if ($provider === 'google') {
        $socialUser = Socialite::driver('google')->userFromToken($token);
    } elseif ($provider === 'apple') {
        $socialUser = Socialite::driver('apple')->userFromToken($token);
    } else {
        return response()->json(['error' => 'Invalid provider'], 400);
    }

    $user = User::updateOrCreate([
        'email' => $socialUser->getEmail(),
    ], [
        'username' => $socialUser->getName(),
        'fullname' => $socialUser->getName(),
        'provider' => $provider,
        'provider_id' => $socialUser->getId(),
    ]);

    $authToken = $user->createToken('MyApp')->accessToken;
    return response()->json(['token' => $authToken], 200);
}


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }


}
