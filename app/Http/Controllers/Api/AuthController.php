<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Admin login.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password. Please verify your credentials.',
            ], 401);
        }

        // Generate or refresh API token
        $token = Str::random(60);
        $user->api_token = $token;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Welcome back, ' . $user->name,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * Check current admin auth status.
     */
    public function me(Request $request): JsonResponse
    {
        $token = $request->bearerToken() ?? $request->header('X-Admin-Token');
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'authenticated' => false,
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * Change admin password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $token = $request->bearerToken() ?? $request->header('X-Admin-Token');
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password does not match.',
            ], 422);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully.',
        ]);
    }

    /**
     * Admin logout.
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken() ?? $request->header('X-Admin-Token');
        if ($token) {
            User::where('api_token', $token)->update(['api_token' => null]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ]);
    }
}
