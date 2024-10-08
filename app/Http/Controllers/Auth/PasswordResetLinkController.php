<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;

class PasswordResetLinkController extends Controller
{
    public function sendResetLink(Request $request): JsonResponse
    {
        
        $request->validate(['email' => 'required|email']);

        
        $status = Password::sendResetLink(
            $request->only('email')
        );

        
        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => __($status)])
                    : response()->json(['message' => __($status)], 400);
    }
}
    