<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Laravel API Documentation",
    description: "API documentation for the Laravel application",
    contact: new OA\Contact(
        email: "your-email@example.com"
    )
)]
#[OA\Schema(
    schema: "User",
    type: "object",
    title: "User",
    required: ["name", "email", "password"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "John Doe"),
        new OA\Property(property: "email", type: "string", format: "email", example: "john.doe@example.com"),
        new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
    ]
)]
class UserController extends Controller
{
    #[OA\Get(
        path: "/api/users",
        operationId: "getUsersList",
        tags: ["Users"],
        summary: "Get list of users",
        description: "Returns list of users",
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/User"))
            ),
            new OA\Response(response: 400, description: "Bad request"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function index()
    {
        \Log::info('UserController index method accessed.');

        return response()->json(['message' => 'This is a simple text message returned as JSON.']);
    }

    #[OA\Post(
        path: "/api/users",
        operationId: "storeUser",
        tags: ["Users"],
        summary: "Create a new user",
        description: "Creates a new user",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John Doe"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "john.doe@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "User created successfully"),
            new OA\Response(response: 400, description: "Bad request"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }

    #[OA\Get(
        path: "/api/users/{id}",
        operationId: "getUserById",
        tags: ["Users"],
        summary: "Get user by ID",
        description: "Returns a single user",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Successful operation", content: new OA\JsonContent(ref: "#/components/schemas/User")),
            new OA\Response(response: 404, description: "User not found"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function show($id)
    {
        \Log::info('Fetching user by ID.');

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
