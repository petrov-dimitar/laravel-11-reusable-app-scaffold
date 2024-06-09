<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WebSocket\Client;

class ExampleController extends Controller
{
    public function connectToWebSocket(Request $request)
    {
        $client = new Client("ws://localhost:8081");

        $client->send("Hello, WebSocket server LARAVEL!");
        echo "Sent: Hello, WebSocket server LARAVEL!\n";

        $response = $client->receive();
        echo "Received: {$response}\n";

        $client->close();
    }
}
