<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoCardlessController extends Controller
{
    public function createToken(Request $request)
    {
        // Retrieve secret ID and secret key from environment variables
        $secretId = env('GOCARDLESS_SECRET_ID');
        $secretKey = env('GOCARDLESS_SECRET_KEY');

        // Prepare the request body
        $data = [
            'secret_id' => $secretId,
            'secret_key' => $secretKey,
        ];

        // Make the POST request to the GoCardless API
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://bankaccountdata.gocardless.com/api/v2/token/new/', $data);

        // Check if the request was successful
        if ($response->successful()) {
            // Retrieve the authenticated user
            $auth_user = Auth::user();
            
            // Find the user by ID
            $user = User::find($auth_user->id);

            // Store the token in the 'gocardless_token' field of the user model
            $user->gocardless_token = $response->json()['access'];
            $user->save();
            
            // Return a success response
            return response()->json(['message' => 'Token created and stored successfully'], 200);
        } else {
            // Return an error response
            return response()->json(['error' => 'Failed to create token'], $response->status());
        }
    }
}
