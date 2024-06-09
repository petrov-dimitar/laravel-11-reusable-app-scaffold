<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agreement; // Import the Agreement model
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

    public function getBanksForCountry(Request $request, $country)
    {
        // Retrieve the authenticated user
        $auth_user = Auth::user();
        
        // Find the user by ID
        $user = User::find($auth_user->id);

        // Check if the user has a GoCardless token
        if (!$user->gocardless_token) {
            return response()->json(['error' => 'GoCardless token not found'], 401);
        }

        // Make the GET request to the GoCardless API
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->gocardless_token,
        ])->get('https://bankaccountdata.gocardless.com/api/v2/institutions/', [
            'country' => $country
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            // Return the list of banks
            return response()->json($response->json(), 200);
        } else {
            // Return an error response
            return response()->json(['error' => 'Failed to fetch banks'], $response->status());
        }
    }

    public function createAgreement(Request $request)
    {
        $request->validate([
            'redirect' => 'required|url',
            'institution_id' => 'required|string',
            'reference' => 'required|string',
            'max_historical_days' => 'required|integer',
            'access_valid_for_days' => 'required|integer',
            'access_scope' => 'required|array',
            'user_language' => 'required|string',
        ]);

        // Retrieve the authenticated user
        $auth_user = Auth::user();
        
        // Find the user by ID
        $user = User::find($auth_user->id);

        // Check if the user has a GoCardless token
        if (!$user->gocardless_token) {
            return response()->json(['error' => 'GoCardless token not found'], 401);
        }

        // Step 1: Create the agreement
        $agreementResponse = Http::withToken($user->gocardless_token)
            ->post('https://bankaccountdata.gocardless.com/api/v2/agreements/enduser/', [
                'institution_id' => $request->institution_id,
                'max_historical_days' => $request->max_historical_days,
                'access_valid_for_days' => $request->access_valid_for_days,
                'access_scope' => $request->access_scope,
            ]);

            // var_dump($agreementResponse);

        // Check if the agreement request was successful
        if ($agreementResponse->failed()) {
            return response()->json(['error' => 'Failed to create agreement'], $agreementResponse->status());
        }

        $agreementData = $agreementResponse->json();

        // Save the agreement to the database
        $agreement = new Agreement();
        $agreement->user_id = $user->id;
        $agreement->agreement_id = $agreementData['id'];
        $agreement->created = $agreementData['created'];
        $agreement->max_historical_days = $agreementData['max_historical_days'];
        $agreement->access_valid_for_days = $agreementData['access_valid_for_days'];
        $agreement->access_scope = json_encode($agreementData['access_scope']);
        $agreement->institution_id = $agreementData['institution_id'];
        $agreement->save();

        // Step 2: Create the requisition using the agreement ID
        $requisitionResponse = Http::withToken($user->gocardless_token)
            ->post('https://bankaccountdata.gocardless.com/api/v2/requisitions/', [
                'redirect' => $request->redirect,
                'institution_id' => $request->institution_id,
                'reference' => $request->reference,
                'agreement' => $agreementData['id'],
                'user_language' => $request->user_language,
            ]);

        // Check if the requisition request was successful
        if ($requisitionResponse->failed()) {
            return response()->json(['error' => 'Failed to create requisition'], $requisitionResponse->status());
        }

        $requisitionData = $requisitionResponse->json();

        // Return the link to the client
        return response()->json(['link' => $requisitionData['link']], 201);
    }
}
