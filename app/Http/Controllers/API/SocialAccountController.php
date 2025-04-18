<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class SocialAccountController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()->socialAccounts;
        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|string|in:tiktok,instagram,facebook,youtube',
            'platform_user_id' => 'required|string',
            'username' => 'required|string',
            'access_token' => 'required|string',
            'refresh_token' => 'nullable|string',
            'token_expires_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Encrypt tokens for security
        $accessToken = Crypt::encryptString($request->access_token);
        $refreshToken = $request->refresh_token ? Crypt::encryptString($request->refresh_token) : null;

        $account = auth()->user()->socialAccounts()->create([
            'platform' => $request->platform,
            'platform_user_id' => $request->platform_user_id,
            'username' => $request->username,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_expires_at' => $request->token_expires_at,
        ]);

        return response()->json($account, 201);
    }

    public function show($id)
    {
        $account = auth()->user()->socialAccounts()->findOrFail($id);
        return response()->json($account);
    }

    public function destroy($id)
    {
        $account = auth()->user()->socialAccounts()->findOrFail($id);
        $account->delete();

        return response()->json(['message' => 'Account disconnected successfully']);
    }
}
