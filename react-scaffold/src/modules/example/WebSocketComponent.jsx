import React, { useState } from 'react'

const WebSocketComponent = () => {
  const [message, setMessage] = useState('')
  const [ws, setWs] = useState(null)

  // Connect to WebSocket server
  const connectWebSocket = () => {
    console.log('connectWebSocket')
    const ws = new WebSocket('ws://localhost:8081') // WebSocket server URL

    ws.onopen = () => {
      console.log('WebSocket connected')
      setWs(ws)
    }

    ws.onmessage = (event) => {
      console.log({ event })
      setMessage(event.data)
    }

    ws.onerror = (error) => {
      console.error('WebSocket error:', error)
    }

    ws.onclose = () => {
      console.log('WebSocket disconnected')
      setWs(null)
    }
  }

  // Send message to WebSocket server
  const sendMessage = () => {
    if (ws) {
      ws.send('Hello from React!')
    }
  }

  return (
    <div>
      <h1>WebSocket Example</h1>
      <button onClick={connectWebSocket}>Connect WebSocket</button>
      <button onClick={sendMessage}>Send Message</button>
      <p>Message from server: {message}</p>
    </div>
  )
}

export default WebSocketComponent
