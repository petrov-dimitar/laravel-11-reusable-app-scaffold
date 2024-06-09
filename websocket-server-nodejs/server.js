const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8081 }); // Change port if necessary

console.log("start server.js");

wss.on('connection', function connection(ws) {
    console.log('New connection');

    ws.on('message', function incoming(message) {
        console.log('Received: %s', message);
        wss.clients.forEach(function each(client) {
                client.send(`Broadcasting: ${message}`);
        });
        ws.send(`Received your message: ${message}`);
    });
});
