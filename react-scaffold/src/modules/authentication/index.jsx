import React from 'react'
import Login from './Login'
import Register from './Register'

// Define a functional component named MyComponent
function Authentication() {
  return (
    <div>
      <h1>Authentication View</h1>
      <Login />
      <Register />
    </div>
  )
}

export default Authentication
