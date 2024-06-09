<?php

namespace App\WebSocket;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class WebSocketClient
{
    protected $client;
    protected $url;
    protected $headers;

    public function __construct(string $url)
    {
        $this->client = new Client();
        $this->url = $url;
        $this->headers = [
            'Origin' => 'http://localhost' // Replace with your actual origin
        ];
    }

    public function connect(): void
    {
        $request = new Request('GET', $this->url, $this->headers);

        $this->client->send($request, ['timeout' => 0]);
    }

    public function send(string $message): void
    {
        $this->client->send(
            new Request('POST', $this->url, $this->headers, $message),
            ['timeout' => 0]
        );
    }
}
