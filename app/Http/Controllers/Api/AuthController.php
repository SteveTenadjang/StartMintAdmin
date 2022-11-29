<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function register(UserRequest $request): JsonResponse
    {
        $user = new User($request->validated());
		$user['password'] = Hash::make($request['password']);
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->bundle()->attach($request->input('bundle_id')?:1);
        return response()->auth(UserResource::make($user),$token);
    }

    public function login(Request $request): JsonResponse
    {
        $user = User::query()->where('email', $request->input('email'))->first();
        if(!$user)
        { return response()->error(statusCode: 404, message: 'Unknown Email'); }

        if (!Auth::attempt($request->only('email', 'password')))
        {
            Log::channel('auth-Login')->info("Login failed");
            return response()->error(statusCode: 401, message: 'Login failed');
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->auth(UserResource::make($user),$token);
    }

    // method for user logout and delete token
    public function logout(): JsonResponse
    {
        auth()->user()?->tokens()->delete();
        return response()->success(['user'=>null]);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $user = User::query()->where('email', $request->input('email'))->first();
        if(!$user)
        { return response()->error(statusCode: 404, message: 'Unknown Email'); }
        return response()->success($user);
    }
}
